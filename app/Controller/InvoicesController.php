<?php
App::uses('HttpSocket', 'Network/Http');
App::uses('Telebirr', 'Lib/Payment');
/**
 * Invoices Controller
 *
 * @property Invoice $Invoice
 * @property PaginatorComponent $Paginator
 */
class InvoicesController extends AppController {

    public $name = 'Invoices';

    public $menuOptions = array(
        'parent'=>'costShares',
        'exclude' => array('generate_invoice','recordPayment','view', 'deleteTransaction','refund',
            'generateStudentInvoices','payment_callback'),
        'alias' => array(
            'index'=>'View Invoices',
            'recordPayment'=>'Record Payment',
        )
    );
    public $components =array('AcademicYear','Paginator','Billing');
    public $paginate = array();

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->Allow(
		'pay_at',
		'recordPayment',
		'view'
        );
    }

    function beforeRender() {
        parent::beforeRender();
        $acyear_array_data = $this->AcademicYear->acyear_array();
        //To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        $this->set(compact('acyear_array_data','defaultacademicyear'));

    }

    public function generate_invoice($invoice_number = '', $type = 'Full')
    {
        // Rate limiting using CakePHP 2.10 Session component
        $lastRequest = $this->Session->read('last_invoice_request');
        $requestCount = $this->Session->read('invoice_request_count') ?: 0;
        $currentTime = time();

        if ($lastRequest && ($currentTime - $lastRequest < 60)) { // 60-second window
            if ($requestCount >= 5) { // Max 5 requests per minute
                $this->response->statusCode(429); // Too Many Requests
                $this->Flash->error('Rate limit exceeded. Try again later.');
                $this->redirect('/');
            }
            $this->Session->write('invoice_request_count', $requestCount + 1);
        } else {
            $this->Session->write('invoice_request_count', 1);
            $this->Session->write('last_invoice_request', $currentTime);
        }


        if(isset($invoice_number) && !empty($invoice_number)){

            $invoiceDetails = $this->Invoice->find('first', array(
                'conditions' => array('Invoice.receipt_code' => $invoice_number),
                'contain' => array(
                    'Transaction' => array('PaymentCurrency', 'PaymentMethod')
                )
            ));
            debug($invoiceDetails);
            debug($invoiceDetails);
        }

        $universityDetails = ClassRegistry::init('University')->find(
            'first',
            array(
                'order' => array('University.created DESC')
            )
        );
        $this->set(compact('invoiceDetails',  'universityDetails'));

        $this->response->type('application/pdf');
        $this->layout = '/pdf/default';
        $this->render('pdf/invoice_service_pdf');
        return;
    }

    public function index() {
        $conditions = array();
        $options = array();
        $filterFormData = array();

        // Handle POST (filter submission or clear)
        if ($this->request->is('post')) {
            debug($this->request->data);
            if (!empty($this->request->data['clear_filters'])) {
                // Clear filters
                $this->Session->delete('Invoice.filters');
                $this->Session->delete('Invoice.filter_form');
                $this->Flash->info('Filters cleared.');
            } else {
                // Process filters
                $filterData = !empty($this->request->data['Invoice']) ? $this->request->data['Invoice']:array();
                // payer_name
                if (!empty($filterData['payer_name'])) {
                    $options[] = array(
                          'Invoice.payer_name LIKE' => '%'.trim($filterData['payer_name']). '%'
                    );
                    $conditions['Invoice.payer_name LIKE'] = '%' . trim($filterData['payer_name']) . '%';
                }

                // status
                if (!empty($filterData['status'])) {
                    $options[] = array(
                        'LOWER(Invoice.status)' => strtolower($filterData['status'])
                    );
                }
                debug($filterData);
                // due_date_to - same pattern
                if (!empty($filterData['due_date_to']) && !empty($filterData['due_date_from'])) {
                    $from = $filterData['due_date_from'];
                    $to= $filterData['due_date_to'];
                    $options[] = array(
                        'Invoice.due_date >= \'' .$from['year'].'-'.$from['month'].'-'.$from['day']. '\'',
                        'Invoice.due_date <= \'' . $to['year'].'-'.$to['month'].'-'.$to['day']. '\'',
                    );

                    $conditions['Invoice.due_date >='] = $filterData['due_date_from'];
                    $conditions['Invoice.due_date <='] = $filterData['due_date_to'];
                }

                // Store in session
                $this->Session->write('Invoice.filters', $conditions);
                $this->Session->write('Invoice.filter_form', $filterData);

                $this->Flash->info('Filters applied.');

            }

            // Always redirect after POST (PRG)
          //  return $this->redirect(array('action' => 'index'));
        }

        // GET request: load from session if exists
        $conditions = $this->Session->read('Invoice.filters') ?: array();
        $filterFormData = $this->Session->read('Invoice.filter_form') ?: array();
        // Pagination settings
        $this->paginate = array(
            'contain'    => array('Transaction'),
            'order'      => array('Invoice.created' => 'DESC'),
            'limit'      => 20,
            'recursive'  => -1
        );

        $invoices = $this->paginate($options);

        $this->set(compact('invoices', 'filterFormData'));

        // Status options
        $statuses = array(
            'Pending'        => 'Pending',
            'Partially Paid' => 'Partially Paid',
            'Paid'           => 'Paid',
            'Overdue'        => 'Overdue',
            'Cancelled'      => 'Cancelled'
        );
        $this->set('statuses', $statuses);
    }

    /**
     * Extend due date for an overdue invoice
     * @param int $id Invoice ID
     */
    public function extendDueDate($id = null) {
        $this->Invoice->id = $id;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $newDueDate = $this->request->data['Invoice']['new_due_date'];
            if (!empty($newDueDate)) {
                $this->Invoice->saveField('due_date', $newDueDate);
                $this->Invoice->saveField('status', 'Pending'); // Reset status if needed
                $this->Session->setFlash(__('Due date extended successfully.'), 'default', array('class' => 'alert-success'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Please provide a new due date.'), 'default', array('class' => 'alert-danger'));
            }
        }

        // For GET: show mini form or use AJAX modal in view
        $invoice = $this->Invoice->findById($id);
        $this->set(compact('invoice'));
        $this->render('extend_due_date'); // Separate small view or inline in index
    }


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Invoice->id = $id;
		if (!$this->Invoice->exists()) {
			throw new NotFoundException(__('Invalid invoice'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Invoice->delete()) {
            $this->Flash->success('The invoice has been deleted.');
        } else {
            $this->Flash->error('The invoice has been deleted.');

        }
		return $this->redirect(array('action' => 'index'));
	}

    public function recordPayment($invoiceId = null) {
        $this->Invoice->id = $invoiceId;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }

        $invoice = $this->Invoice->find('first', array(
            'conditions' => array('Invoice.id' => $invoiceId),
            'contain' => false // we don't need transactions yet
        ));
        $this->set(compact('invoice'));

        if ($this->request->is('post') || $this->request->is('put')) {
            // Example: coming from payment gateway callback or admin form
            $data = $this->request->data['Transaction'];

            // Basic required fields (adjust according to your form/gateway)

            $transaction = array(
                'Transaction' => array(
                    'invoice_id'       => $invoiceId,
                    'student_id'       => isset($data['student_id']) ? $data['student_id'] : 0,
                    'payer_type' => !empty($data['payer_type']) ? $data['payer_type'] : $invoice['Invoice']['payer_type'],
                    'payer_id' => !empty($data['payer_id']) ? $data['payer_id'] : $invoice['Invoice']['payer_id'],
                    'payer_name'       => !empty($data['payer_name']) ? $data['payer_name'] : $invoice['Invoice']['payer_name'],
                    'payer_email'      => !empty($data['payer_email']) ? $data['payer_email'] : $invoice['Invoice']['payer_email'],
                    'paid_amount'      => $data['paid_amount'],
                    'currency_id'      => isset($data['currency_id']) ? $data['currency_id'] : 1,
                    'converted_amount' => isset($data['converted_amount']) ? $data['converted_amount'] : (isset($data['paid_amount']) ? $data['paid_amount'] : 0),
                    'exchange_rate'    => isset($data['exchange_rate']) ? $data['exchange_rate'] : 1,
                    'method_id'        => $data['method_id'],
                    'transaction_code' => !empty($data['transaction_code']) ? $data['transaction_code'] : 'MANUAL-' . time(),
                    'transaction_ref'  => !empty($data['transaction_ref']) ? $data['transaction_ref'] : '',
                    'status'           => !empty($data['status']) ? $data['status'] : 'Success',
                    'paid_at'          => !empty($data['paid_at']) ? $data['paid_at'] : date('Y-m-d H:i:s'),
                    'notes'            => !empty($data['notes']) ? $data['notes'] : 'Payment recorded manually'
                )
            );

            $this->Invoice->Transaction->create();
            if ($this->Invoice->Transaction->save($transaction)) {

                // For gateway success → you might send email/receipt here
                $this->Flash->success('Payment recorded successfully.');

                // Redirect depending on context
                if ($this->request->is('ajax')) {
                    return $this->renderJson(array('success' => true, 'message' => 'Payment recorded'));
                }
                return $this->redirect(array('action' => 'view', $invoiceId));
            } else {

                $this->Flash->info('Could not record payment. Please check the data..');

            }
        }


        $paymentCurrencies = $this->Invoice->Transaction->PaymentCurrency->find('list');
        $paymentMethods = $this->Invoice->Transaction->PaymentMethod->find('list');
        $statuses= array('Success'=>'Success', 'Completed'=>'Completed', 'Pending'=>'Pending',
            'Failed'=>'Failed', 'Refunded'=>'Refunded', 'Credit'=>'Credit');
        $this->set(compact('paymentCurrencies','statuses', 'paymentMethods'));

    }

    /**
     * Dedicated refund/credit action
     * Only finance users can access
     */
    public function refund($invoiceId = null) {
        // Permission check (adjust based on your Auth setup)
        if (!$this->Session->read('Auth.User') || $this->Session->read('Auth.User')['is_admin']!=1) {
            $this->Flash->error('Only authorized finance users can issue refunds.');
            return $this->redirect(array('action' => 'view', $invoiceId));
        }

        $this->Invoice->id = $invoiceId;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }

        $invoice = $this->Invoice->find('first', array(
            'conditions' => array('Invoice.id' => $invoiceId),
            'contain'    => false
        ));

        $currentRemaining = (float)$invoice['Invoice']['remaining'];

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = isset($this->request->data['Transaction']) ? $this->request->data['Transaction']: array();

            $refundAmountRaw = trim(isset($data['refund_amount']) ? $data['refund_amount']:'');
            $refundAmount     = is_numeric($refundAmountRaw) ? abs((float)$refundAmountRaw) : 0.0;

            // ── Safe comparison ────────────────────────────────────────────────────────
            $maxAllowed = abs($currentRemaining); // positive value

            // Use BCMath if available (most reliable for money)
            $isTooHigh = function_exists('bccomp')
                ? bccomp((string)$refundAmount, (string)$maxAllowed, 2) > 0
                : (abs($refundAmount - $maxAllowed) > 0.001);

            if ($refundAmount <= 0) {
                $this->Flash->info(
                    'Please enter a valid positive refund amount.'
                );
            } elseif ($isTooHigh) {
                $this->Flash->error(
                    'Refund amount cannot exceed the current credit/remaining balance (' .
                    number_format($maxAllowed, 2) . ' ETB).'
                );
            } else {
                // Proceed to save
                $transactionData = array(
                    'Transaction' => array(
                        'invoice_id'       => $invoiceId,
                        'payer_name'       => $invoice['Invoice']['payer_name'],
                        'payer_email'      => $invoice['Invoice']['payer_email'],
                        'paid_amount'      => - $refundAmount,  // Negative!
                        'currency_id'      => !empty($data['currency_id']) ? $data['currency_id']:1,
                        'method_id'        => !empty($data['method_id']) ? $data['method_id']:1,
                        'transaction_code' => 'REF-' . date('YmdHis') . '-' . $invoice['Invoice']['receipt_code'],
                        'transaction_ref'  => !empty($data['transaction_ref']) ? $data[ 'transaction_ref'] : '',
                        'status'           => 'Refunded',
                        'paid_at'          => !empty($data['paid_at']) ? $data['paid_at'] : date('Y-m-d H:i:s'),
                        'notes'            => trim(( isset($data['reason']) ? $data['reason']:'') . ' - ' .
                            (isset($data['notes']) ? $data['notes']:''))
                    )
                );
                debug($transactionData);

                $this->Invoice->Transaction->create();
                if ($this->Invoice->Transaction->save($transactionData)) {
                    $this->Invoice->updatePaymentStatus($invoiceId);

                    $this->Flash->success(
                        __('Refund of ' . number_format($refundAmount, 2) . ' ETB recorded successfully.')
                    );
                    // Refresh invoice for email
                    $invoice = $this->Invoice->findById($invoiceId);
                    $this->Invoice->sendStatusNotification($invoice, 'Refund Issued');

                    return $this->redirect(array('action' => 'view', $invoiceId));
                } else {
                    $this->Flash->error(__('Failed to record refund. Please check the data.'));
                }
            }
        }

        // GET: display form
        $this->set(compact('invoice'));
        $this->set('refundReasons', array(
            'Overcharge'      => 'Overcharge correction',
            'Service Return'  => 'Service or goods returned',
            'Discount'        => 'Post-payment discount/adjustment',
            'Duplicate'       => 'Duplicate payment',
            'Other'           => 'Other (please specify in notes)'
        ));
        $this->set('currencies', $this->Invoice->Transaction->PaymentCurrency->find('list'));
        $this->set('paymentMethods', $this->Invoice->Transaction->PaymentMethod->find('list'));
    }
    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {

        $this->Invoice->id = $id;
        if (!$this->Invoice->exists()) {
            throw new NotFoundException(__('Invalid invoice'));
        }

        // Fetch invoice + all related transactions (ordered by date descending)
        $invoice = $this->Invoice->find('first', array(
            'conditions' => array('Invoice.id' => $id),
            'contain' => array(
                'Transaction' => array(
                    'order' => 'Transaction.paid_at DESC',
                    'PaymentCurrency',
                    'PaymentMethod',
                )
            )
        ));

        if (empty($invoice)) {
            $this->Flash->info('Invoice not found.');
            return $this->redirect(array('action' => 'index'));
        }


        $this->set(compact('invoice'));
        // Attach payer data if linked
       // $payer = $this->Invoice->getPayer();
        $this->set(compact('invoice'));

        // Optional: set page title
        $this->set('title_for_layout', 'Invoice #' . $invoice['Invoice']['receipt_code']);

    }

    public function processPayment($invoiceId) {
        $invoice = $this->Invoice->findById($invoiceId);
        if (empty($invoice)) throw new NotFoundException();

        // Example: Gateway integration (e.g., Stripe)
        // $gatewayResponse = $this->PaymentGateway->charge(...);

        $gatewayResponse=array();
        if ($gatewayResponse['success']) {
            $transactionData = array(
                'invoice_id' => $invoiceId,
                'payer_name' => $invoice['Invoice']['payer_name'],
                'paid_amount' => $gatewayResponse['amount'],
                'currency_id' => $gatewayResponse['currency'],
                // ... other fields from response ...
                'status' => 'Success',
                'paid_at' => date('Y-m-d H:i:s')
            );
            $this->Transaction->create();
            if ($this->Transaction->save($transactionData)) {
                // Update invoice status
                $this->Invoice->updateStatus($invoiceId);  // Custom method to recalc status
                $this->Flash->success('Payment successful!');
            } else {
                // Handle save error
            }
        } else {
            // Create failed transaction for logging
            $transactionData = array(
                // ... similar, but status = 'Failed', notes = $gatewayResponse['error']
            );
            $this->Transaction->save($transactionData);
        }
    }

    /**
     * Delete a transaction
     *
     * @param int $transactionId
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function deleteTransaction($transactionId = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        // Redirect back to invoice view
        $invoice = $this->Invoice->Transaction->find('first', [
            'conditions' => ['Transaction.id' => $transactionId],
            'fields'     => ['Transaction.invoice_id']
        ]);

        $this->Invoice->Transaction->id = $transactionId;
        if (!$this->Invoice->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }

        if ($this->Invoice->Transaction->delete()) {
            $this->Flash->success('Transaction deleted successfully. Invoice updated!');
        } else {
            $this->Flash->error('Failed to delete transaction.');
        }

        $invoiceId = $invoice['Transaction']['invoice_id'];

        return $this->redirect(array('action' => 'view', $invoiceId));
    }

    public function generateStudentInvoices($id = null,$targetType='Student') {
        $this->layout = 'ajax';
        if (!$this->Session->read('Auth.User')['is_admin']) {
            $this->Flash->error('Only admins can generate invoices.');
            return $this->redirect($this->referer());
        }
        $targetId = (int)$id;
        $targetEntity = null;

        $payerModel = ClassRegistry::init($targetType);
        $targetEntity = $payerModel->findById($targetId);

        if (empty($targetEntity)) {
            $this->Flash->error('Entity not found.');
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {

            $selectedFeeTypeIds = isset($this->request->data['fee_type_ids']) ? $this->request->data['fee_type_ids'] : array();
            $dynamicValues = isset($this->request->data['dynamic_values']) ? $this->request->data['dynamic_values'] : array();
            $context = array('dynamic' => $dynamicValues);

            if (empty($selectedFeeTypeIds)) {
                $this->Flash->error('Please select at least one fee type.');
            } else {
                $generated = $this->Billing->generateInvoices(
                    $targetType,
                    $targetId,
                    $selectedFeeTypeIds,
                    $context
                );
                $this->Flash->success($generated . ' invoice(s) generated.');

                if ($this->request->is('ajax')) {
                    $this->autoRender = false;
                    echo "<script>window.location.href = '" . $this->referer() . "';</script>";
                    return;
                }
                return $this->redirect($this->referer());
            }
        }

        // GET / modal
        $feeTypes = ClassRegistry::init('FeeType')->find('list', array(
            'fields'     => array('id', 'name'),
            'conditions' => array('active' => 1)
        ));

        $this->set(compact('feeTypes', 'targetEntity', 'targetType', 'targetId'));
        $this->render('generate_student_invoices_modal');
    }

    /**
     * Telebirr payment callback / webhook endpoint
     * Handles success/failure notifications from Telebirr
     *
     * @return void
     */
    public function payment_callback() {
        $this->autoRender = false;
        $this->layout = false;

        // 1. Read raw POST body safely (CakePHP recommended way)
        $rawBody = $this->request->input();

        // Log everything for debugging (critical!)
        CakeLog::write('telebirr_callback', "Callback received:\n" .
            "Headers: " . json_encode($this->request->headers) . "\n" .
            "Raw body:\n" . $rawBody
        );
        debug($rawBody);

        // 2. Determine content type
        $contentType = $this->request->header('Content-Type') ?: 'application/json';

        // 3. Parse body
        $data = null;
        if (stripos($contentType, 'application/json') !== false) {
            $data = json_decode($rawBody, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                CakeLog::write('telebirr_callback', 'JSON decode error: ' . json_last_error_msg());
                echo 'FAILURE';
                exit;
            }
        } elseif (stripos($contentType, 'xml') !== false || stripos($contentType, 'text/xml') !== false) {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($rawBody);
            if ($xml === false) {
                $errors = libxml_get_errors();
                CakeLog::write('telebirr_callback', 'XML parse error: ' . print_r($errors, true));
                echo 'FAILURE';
                exit;
            }
            $data = json_decode(json_encode($xml), true); // XML → array
        } else {
            CakeLog::write('telebirr_callback', 'Unknown Content-Type: ' . $contentType);
            echo 'FAILURE';
            exit;
        }

        // 4. Extract common fields (adjust keys based on your Telebirr response format)
        $outTradeNo = isset($data['outTradeNo'])
            ? $data['outTradeNo']
            : (isset($data['out_trade_no']) ? $data['out_trade_no'] : '');

        $statusRaw = isset($data['status'])
            ? $data['status']
            : (isset($data['result_code'])
                ? $data['result_code']
                : (isset($data['code']) ? $data['code'] : ''));

        $status = strtolower($statusRaw);

        $paidAmount = isset($data['totalAmount'])
            ? (float)$data['totalAmount']
            : (isset($data['total_amount']) ? (float)$data['total_amount'] : 0);

        $transactionNo = isset($data['transactionNo'])
            ? $data['transactionNo']
            : (isset($data['trans_no']) ? $data['trans_no'] : '');

        $sign = isset($data['sign']) ? $data['sign'] : '';


        // 5. Find invoice by outTradeNo (matches receipt_code)
        $invoice = $this->Invoice->find('first', array(
            'conditions' => array('Invoice.receipt_code' => $outTradeNo),
            'recursive'  => -1
        ));

        if (empty($invoice)) {
            CakeLog::write('telebirr_callback', 'Invoice not found for outTradeNo: ' . $outTradeNo);
            echo 'FAILURE';
            exit;
        }

        $invoiceId = $invoice['Invoice']['id'];

        // 6. Find the pending transaction created in pay_at()
        $transaction = $this->Invoice->Transaction->find('first', array(
            'conditions' => array(
                'Transaction.invoice_id' => $invoiceId,
                'Transaction.status'     => 'Pending',
                'Transaction.transaction_code LIKE' => '%' . $outTradeNo . '%'
            ),
            'order' => array('Transaction.created' => 'DESC'),
            'recursive' => -1
        ));

        if (empty($transaction)) {
            CakeLog::write('telebirr_callback', 'No pending transaction found for invoice ' . $invoiceId);
            echo 'SUCCESS'; // Idempotent response
            exit;
        }

        $transactionId = $transaction['Transaction']['id'];

        // 7. Verify signature using your Telebirr class logic
        $isValid = $this->verifyTelebirrCallbackSignature($data);

        if (!$isValid) {
            CakeLog::write('telebirr_callback', 'Invalid signature for transaction ' . $transactionId);
            echo 'FAILURE';
            exit;
        }

        // 8. Update transaction
        $updateData = array(
            'id'             => $transactionId,
            'transaction_ref' => $transactionNo,
            'paid_amount'    => $paidAmount,
            'paid_at'        => date('Y-m-d H:i:s'),
            'notes'          => 'Telebirr callback: ' . $rawBody
        );

        if (in_array($status, ['success', '0000', 'SUCCESS', 'completed'])) {  // Adjust to real success codes


            $updateData['status'] = 'Success';
            $this->Invoice->Transaction->save($updateData);

            // Update invoice remaining & status
            $this->Invoice->updatePaymentStatus($invoiceId);

            // Optional: send email/notification
            if (method_exists($this->Invoice, 'sendStatusNotification')) {
                $freshInvoice = $this->Invoice->findById($invoiceId);
                $this->Invoice->sendStatusNotification($freshInvoice, 'Payment Success');
            }

            CakeLog::write('telebirr_callback', 'Success: Payment confirmed for invoice ' . $invoiceId);
            echo 'SUCCESS';
        } else {
            $updateData['status'] = 'Failed';
            $updateData['notes'] .= ' - Payment failed: ' . (isset($data['message']) ? $data['message'] : (isset($data['result_msg']) ?
                    $data['result_msg'] : 'Unknown'));

            $this->Invoice->Transaction->save($updateData);

            CakeLog::write('telebirr_callback', 'Failure: ' . $status . ' for invoice ' . $invoiceId);
            echo 'FAILURE';

        }

        exit;
    }

    /**
     * Verify Telebirr callback signature
     * Adapted from your Telebirr.php logic
     *
     * @param array $data Parsed callback data
     * @return bool
     */
    private function verifyTelebirrCallbackSignature($data) {
        $receivedSign = isset($data['sign']) ? $data['sign'] : '';

        // Remove sign from data before building string
        unset($data['sign']);

        // Sort params alphabetically (Telebirr requirement)
        ksort($data);

        $stringToSign = '';
        foreach ($data as $k => $v) {
            if ($v === '' || $v === null) continue;
            $stringToSign .= "$k=$v&";
        }
        $stringToSign = rtrim($stringToSign, '&');

        // Append appKey (from config)
        $appKey = Configure::read('Telebirr.AppKey');
        $stringToSign .= $appKey;

        // Generate expected sign (SHA256 → uppercase, same as your class)
        $expectedSign = strtoupper(hash('sha256', $stringToSign));

        // Timing-safe comparison
        return hash_equals($receivedSign, $expectedSign);
    }


    /**
     * Initiate payment and record initial transaction
     * (Telebirr redirect or manual method confirmation)
     */
    public function pay_at()
    {
        $this->layout = false;

        if (
            empty($this->request->data['Invoice']['invoiceNumber']) ||
            empty($this->request->data['Invoice']['methodId'])
        ) {
            $this->Flash->error('Invalid payment request. Missing required parameters.');
            $this->redirect('/');
            return;
        }

        $invoiceNumber = $this->request->data['Invoice']['invoiceNumber'];
        $methodId      = $this->request->data['Invoice']['methodId'];

        // Fetch invoice
        $invoice = ClassRegistry::init('Invoice')->find('first', array(
            'conditions' => array(
                'Invoice.receipt_code' => $invoiceNumber,
                'Invoice.status'       => array('Pending', 'Partially Paid') // Allow payment on partial too
            ),
            'recursive'  => -1
        ));

        if (empty($invoice)) {
            $this->Flash->error('Invoice not found, already paid, or not in payable status.');
            $this->redirect('/');
            return;
        }

        // Fetch payment method
        $paymentMethod = ClassRegistry::init('PaymentMethod')->find('first', array(
            'conditions' => array('PaymentMethod.id' => $methodId),
            'recursive'  => -1
        ));

        if (empty($paymentMethod)) {
            $this->Flash->error('Invalid or inactive payment method.');
            $this->redirect('/');
            return;
        }

        $methodName = strtolower($paymentMethod['PaymentMethod']['name']);
        $amountToPay = $invoice['Invoice']['remaining']; // Pay remaining balance

        // Prepare transaction base data (common for all methods)
        $transactionBase = array(
            'invoice_id'     => $invoice['Invoice']['id'],
            'payer_name'     => $invoice['Invoice']['payer_name'],
            'payer_email'    => $invoice['Invoice']['payer_email'],
            'paid_amount'    => $amountToPay,
            'currency_id'    => 1, // Default to ETB (change to dynamic if needed)
            'converted_amount' => $amountToPay, // Will be adjusted if non-base currency
            'exchange_rate'  => 1.0,
            'method_id'      => $methodId,
            'status'         => 'Pending', // Initial state
            'notes'          => 'Payment initiated via ' . ucfirst($methodName),
            'paid_at'        => date('Y-m-d H:i:s')
        );

        switch ($methodName) {
            case 'telebirr':
                $PUBLICKEY   = Configure::read('Telebirr.PublicKey');
                $APPKEY      = Configure::read('Telebirr.AppKey');
                $APPID       = Configure::read('Telebirr.AppID');
                $API         = Configure::read('Telebirr.Api');
                $SHORTCODE   = Configure::read('Telebirr.shortcode');
                $NOTIFYURL   = Configure::read('Telebirr.NotifyUrl');
                $RETURNURL   = Configure::read('Telebirr.ReturnUrl');
                $TIMEOUT     = '2';
                $RECEIVER    = Configure::read('Telebirr.receiver');

                $subject = 'University Fee Payment - ' . $invoice['Invoice']['receipt_code'];

                $pay1 = new Telebirr(
                    $PUBLICKEY,
                    $APPKEY,
                    $APPID,
                    $API,
                    $SHORTCODE,
                    $NOTIFYURL,
                    $RETURNURL,
                    $TIMEOUT,
                    $RECEIVER,
                    $amountToPay,
                    $subject,
                    $invoice['Invoice']['receipt_code']
                );

                $res = $pay1->getPaymentRequestWrapped();

                if ($res['code'] == 200) {
                    // Record pending transaction BEFORE redirect
                    $transaction = array('Transaction' => $transactionBase);
                    $transaction['Transaction']['transaction_code'] = 'TB-' . date('YmdHis') . '-' . $invoice['Invoice']['receipt_code'];

                    $transaction['Transaction']['transaction_ref'] = isset($res['data']['outTradeNo']) ? $res['data']['outTradeNo'] : '';

                    ClassRegistry::init('Transaction')->create();

                    if (!ClassRegistry::init('Transaction')->save($transaction)) {
                        CakeLog::error('Failed to record pending Telebirr transaction for invoice ' . $invoiceNumber);
                    }
                    // Redirect to Telebirr payment page
                    $this->redirect($res['data']['toPayUrl']);
                    return;
                } else {
                    $errorMsg = !empty($res['message']) ? $res['message'] : 'Telebirr payment initiation failed.';
                    CakeLog::error('Telebirr failure: ' . json_encode($res));
                    $this->Flash->error($errorMsg);
                    $this->redirect($this->referer());
                    return;
                }
                break;
            case 'cash':
                $this->redirect(array(
                    'controller' => 'payment_methods',
                    'action'     => 'view',
                    $methodId
                ));
                break;
            case 'bank transfer':
                // For manual methods: record transaction as pending/completed manually
                $transaction = array('Transaction' => $transactionBase);
                $transaction['Transaction']['status'] = 'Pending'; // or 'Completed' if immediate confirmation
                $transaction['Transaction']['transaction_code'] = 'MANUAL-' . date('YmdHis') . '-' . $invoice['Invoice']['receipt_code'];

                ClassRegistry::init('Transaction')->create();
                if (ClassRegistry::init('Transaction')->save($transaction)) {
                    // For manual methods, optionally mark invoice as paid immediately (if confirmed)
                    // $this->Invoice->updatePaymentStatus($invoice['Invoice']['id']);

                    $this->Flash->success('Payment recorded. Please complete transfer and notify finance.');
                } else {
                    $this->Flash->error('Failed to record manual payment.');
                }

                // Redirect to payment instruction / confirmation page
                $this->redirect(array(
                    'controller' => 'payment_methods',
                    'action'     => 'view',
                    $methodId
                ));
                break;

            default:
                $this->Flash->error('Unsupported payment method.');
                $this->redirect(array(
                    'controller' => 'payment_methods',
                    'action'     => 'view',
                    $methodId
                ));
                break;
        }

        // Fallback (should not reach here)
        $this->redirect('/');
    }

}
