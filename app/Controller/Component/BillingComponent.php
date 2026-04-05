<?php
App::uses('Component', 'Controller');

class BillingComponent extends Component {
    public $components = array( 'Session');

    public $models = array('FeeType', 'Invoice','OnlineApplicant', 'Transaction', 'ExchangeRate', 'Student');

    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);
    }

    public function startup(Controller $controller) {
        $this->controller = $controller;
        foreach ($this->models as $model) {
            $this->$model = ClassRegistry::init($model);
        }
    }

    /**
     * Generate a transaction for an invoice.
     *
     * @param int $invoiceId
     * @param array $paymentData e.g., array('amount' => 100, 'currency_id' => 2, 'method_id' => 1)
     * @return array Transaction data, or false on failure
     */
    public function generateTransaction($invoiceId, $paymentData) {
        $invoice = $this->Invoice->findById($invoiceId);
        if (!$invoice) {
            //$this->Session->setFlash(__('Invalid invoice.'));
            return false;
        }

        $baseCurrencyId = Configure::read('App.base_currency_id', 1);
        $paidAmount = $paymentData['amount'];
        $paidCurrencyId = $paymentData['currency_id'];
        $exchangeRate = $this->getExchangeRate($paidCurrencyId, $baseCurrencyId);
        if ($exchangeRate === null) {
            //$this->Session->setFlash(__('No exchange rate available.'));
            return false;
        }
        $convertedAmount = $paidAmount * $exchangeRate;

        $transactionData = array(
            'Transaction' => array(
                'invoice_id' => $invoiceId,
                'student_id' => $invoice['Invoice']['student_id'],
                'payer_name' => $invoice['Invoice']['payer_name'],
                'payer_email' => $invoice['Invoice']['payer_email'],
                'paid_amount' => $paidAmount,
                'currency_id' => $paidCurrencyId,
                'converted_amount' => $convertedAmount,
                'exchange_rate' => $exchangeRate,
                'method_id' => $paymentData['method_id'],
                'status' => 'pending',
                'notes' => 'Generated for service in ' . $this->request->controller
            )
        );

        $this->Transaction->create();
        if ($this->Transaction->save($transactionData)) {
            // Process payment
            $result = $this->Payment->process($this->Transaction->PaymentMethod->field('gateway',
                array('id' => $paymentData['method_id'])), $transactionData['Transaction']);
            if ($result['success']) {
                $this->Transaction->saveField('status', 'completed');
                $this->Transaction->saveField('transaction_ref', $result['transaction_ref']);
                $this->Transaction->saveField('paid_at', date('Y-m-d H:i:s'));
            } else {
                $this->Transaction->saveField('status', 'failed');
                $this->Transaction->saveField('notes', $result['error']);
            }
            //$this->Session->setFlash(__('Transaction generated with code: %s', $this->Transaction->field('transaction_code')));
            return $this->Transaction->read();
        } else {
            //$this->Session->setFlash(__('Failed to generate transaction.'));
            return false;
        }
    }

    // Get exchange rate (from base to target currency)
    public function getExchangeRate($fromCurrencyId, $toCurrencyId) {
        if ($fromCurrencyId == $toCurrencyId) {
            return 1.0;
        }
        $rate = $this->ExchangeRate->find('first', array(
            'conditions' => array(
                'ExchangeRate.from_currency_id' => $fromCurrencyId,
                'ExchangeRate.to_currency_id' => $toCurrencyId,
                'ExchangeRate.effective_date <= ' => date('Y-m-d')
            ),
            'order' => array('ExchangeRate.effective_date' => 'DESC')
        ));
        if ($rate) {
            return $rate['ExchangeRate']['rate'];
        }
        // Fallback: Use an API (e.g., OpenExchangeRates) or throw error
        $this->log('Exchange rate not found for ' . $fromCurrencyId . ' to ' . $toCurrencyId, 'error');
        return null;
    }

    // Convert amount
    public function convertAmount($amount, $fromCurrencyId, $toCurrencyId) {
        $rate = $this->getExchangeRate($fromCurrencyId, $toCurrencyId);
        if ($rate === null) {
            return null; // Handle error
        }
        return $amount * $rate;
    }

    /**
     * Check if a fee type is applicable to the payer
     *
     * @param array $feeType
     * @param array $payerEntity (optional - can be empty now)
     * @param string $payerType
     * @return bool
     */
    public function isApplicable($feeType, $payerEntity = array(), $payerType = '') {
        $applicableTo = !empty($feeType['FeeType']['applicable_to']) ? $feeType['FeeType']['applicable_to']:null;

        if (empty($applicableTo)) {
            return true;
        }

        if (in_array($applicableTo, ['all', 'all_students', 'all_applicants'])) {
            return true;
        }

        // Simple string match
        return $applicableTo === $payerType;
    }

    /**
     * Calculate final amount for a fee type
     * - Starts from fee_types.amount
     * - Applies computation_rule using dynamic_values[feeTypeId] if needed
     * - Applies discount (if discountable)
     * - Applies tax
     *
     * @param array $feeType Full FeeType record
     * @param array $context Context data (including 'dynamic' => user inputs keyed by feeTypeId)
     * @param int $feeTypeId The ID of the fee type (used for dynamic values)
     * @return float Final amount (rounded to 2 decimals)
     */
    public function calculateFeeAmount($feeType, $context = array(), $feeTypeId = null) {
        // Base amount from fee_types table
        $baseAmount = (float)(isset($feeType['FeeType']['amount']) ? $feeType['FeeType']['amount'] : 0);

        // Dynamic user inputs (keyed by feeTypeId)
        $dynamicValues = isset($context['dynamic']) ? $context['dynamic'] : array();

        // Apply computation rule (may use dynamic value for this feeTypeId)
        $baseAmount = $this->applyComputationRule(
            $baseAmount,
            isset($feeType['FeeType']['computation_rule']) ? $feeType['FeeType']['computation_rule'] : null,
            $dynamicValues,
            $feeTypeId
        );

        // Apply discount if discountable
        $discount = 0;
        if (!empty($feeType['FeeType']['discountable'])) {
            $discount = $this->calculateDiscount($baseAmount, $context);
        }
        $baseAmount = $baseAmount - $discount;

        // Apply tax
        $taxRate = (float)(isset($feeType['FeeType']['tax_rate']) ? $feeType['FeeType']['tax_rate'] : 0);
        $taxAmount = $baseAmount * ($taxRate / 100);
        $finalAmount = $baseAmount + $taxAmount;

        return round($finalAmount, 2);
    }

    /**
     * Apply computation rule safely
     * Uses dynamicValues[feeTypeId] as the multiplier/unit value if required
     *
     * @param float $baseAmount Original amount from fee_types.amount
     * @param string|null $ruleJson JSON string from computation_rule
     * @param array $dynamicValues User-entered values (dynamic_values[feeTypeId])
     * @param int $feeTypeId The fee type ID for this calculation
     * @return float Modified amount
     */
    private function applyComputationRule($baseAmount, $ruleJson, $dynamicValues, $feeTypeId) {
        if (empty($ruleJson)) {
            return $baseAmount;
        }

        $rule = json_decode($ruleJson, true);
        if (!is_array($rule) || empty($rule)) {
            return $baseAmount;
        }

        // Pattern 1: Override with fixed amount
        if (isset($rule['type']) && $rule['type'] === 'fixed' && isset($rule['amount'])) {
            return (float)$rule['amount'];
        }

        // Pattern 2: base * multiplier
        if (isset($rule['base']) && isset($rule['multiplier'])) {
            // Get user-entered value for this fee type
            $multiplierValue = isset($dynamicValues[$feeTypeId]) ? (float)$dynamicValues[$feeTypeId] : 1.0;  // default to 1 if not entered
            return (float)$rule['base'] * $multiplierValue;
        }

        // Pattern 3: per_unit alias
        if (isset($rule['per_unit']) && isset($rule['unit'])) {
            $unitValue = isset($dynamicValues[$feeTypeId]) ? (float)$dynamicValues[$feeTypeId] : 1.0;  // default to 1
            return (float)$rule['per_unit'] * $unitValue;
        }

        // Unknown rule → keep original
        return $baseAmount;
    }

    /**
     * Calculate discount amount
     * Customize this method based on your business rules
     *
     * @param float $amount Current amount before discount
     * @param array $context
     * @return float Discount amount
     */
    private function calculateDiscount($amount, $context) {
        $student = isset($context['student']) ? $context['student'] : array();

        // Example: 10% discount for scholarship students
        if (!empty($student['is_scholarship']) || !empty($student['has_discount'])) {
            return $amount * 0.10;
        }

        // Add more rules here (category, year of study, etc.)

        return 0;
    }

    /**
     * Generate invoices for multiple fee types for a given payer
     *
     * @param string $payerType e.g., 'Student', 'OnlineApplicant'
     * @param int $payerId
     * @param array $selectedFeeTypeIds
     * @param array $context Optional context for calculations
     * @return int Number of invoices generated
     */
    public function generateInvoices($payerType, $payerId, $selectedFeeTypeIds, $context = array()) {
        $generatedCount = 0;

        foreach ($selectedFeeTypeIds as $feeTypeId) {
            $feeType = $this->FeeType->findById($feeTypeId);
            if (empty($feeType)) {
                continue;
            }

            // Optional: check applicability (now generic)
            if (!$this->isApplicable($feeType, array(), $payerType)) {
                continue;
            }

            $amount = $this->calculateFeeAmount($feeType, $context, $feeTypeId);

            if ($amount <= 0) {
                continue; // Skip zero/negative
            }

            $invoiceData = array(
                'Invoice' => array(
                    'total_amount' => $amount,
                    'remaining'    => $amount,
                    'due_date'     => date('Y-m-d', strtotime('+30 days')),
                    'status'       => 'Pending',
                    'notes'        => 'Generated for fee type: ' . $feeType['FeeType']['name'],
                    'currency_id'  => !empty($feeType['FeeType']['currency_id']) ? $feeType['FeeType']['currency_id']:1
                )
            );

            $this->Invoice->create();

            if ($payerType && $payerId) {
                $this->Invoice->setPayer($payerType, $payerId);
            } else {
                $this->Invoice->setGuestPayer(
                    !empty($context['payer_name']) ? $context['payer_name']:'',
                    !empty($context['payer_email']) ? $context['payer_name']:''
                );
            }

            if ($this->Invoice->save($invoiceData)) {
                $generatedCount++;
                if (method_exists($this->Invoice, 'sendInvoiceNotification')) {
                    $invDetail = $this->Invoice->findById($this->Invoice->id);
                    $this->Invoice->sendInvoiceNotification($invDetail, 'Pending');
                }
            }
        }

        return $generatedCount;
    }
}