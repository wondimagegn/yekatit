<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
/**
 * Invoice Model
 *
 * @property Student $Student
 * @property Transaction $Transaction
 */
class Invoice extends AppModel {
	
	var $actsAs = array(
		'Containable',
		'Tools.Logable' => array(
			'change' => 'full',
			//'change' => 'list',
			'description_ids' => 'true',
			'displayField' => 'username',
			'foreignKey' => 'foreign_key',
			//'skip' => array('search', 'view'), // functions to skip logging
			'ignore' => array('created', 'modified') // fields to ignore in log
		),
        'CodeGenerator' => array(
            'field' => 'receipt_code',
            'prefix' => 'INV',
            'date_format' => 'Y', // e.g., INV-2025-000123
            'sequence_length' => 6,
            'reset_sequence' => 'yearly'
        ),
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(

        'receipt_code' => array('rule' => 'isUnique', 'message' => 'Receipt  number taken. try again.'),
        'total_amount' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'due_date' => array(
			'date' => array(
				'rule' => array('date'),
			),
		),
		'status' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
        'remaining' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'Remaining must be a valid number'
            ),
            'notNegativeIfPaid' => array(   // custom rule example
                'rule' => array('validateRemaining'),
                'message' => 'Remaining cannot be negative unless overpaid is allowed'
            )
        ),
        'payer_type' => array(
            'validIfUsed' => array(
                'rule'    => array('validatePayerIdentity'),
                'message' => 'Either payer_name/email or payer_type + payer_id must be provided'
            )
        ),
        'payer_id' => array(
            'numericIfUsed' => array(
                'rule'    => array('validatePayerIdentity'),
                'message' => 'Payer ID must be numeric when payer_type is used'
            )
        )
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(

        'Student' => array(
            'className'  => 'Student',
            'foreignKey' => 'payer_id',
            'conditions' => array('Invoice.payer_type' => 'Student')
        ),
        'OnlineApplicant' => array(
            'className'  => 'OnlineApplicant',
            'foreignKey' => 'payer_id',
            'conditions' => array('Invoice.payer_type' => 'OnlineApplicant')
        ),
        'OfficialTranscriptRequest' => array(
            'className'  => 'OfficialTranscriptRequest',
            'foreignKey' => 'payer_id',
            'conditions' => array('Invoice.payer_type' => 'OfficialTranscriptRequest')
        )
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Transaction' => array(
			'className' => 'Transaction',
			'foreignKey' => 'invoice_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
          'order'=>'',
          //  'order' => 'Transaction.paid_at DESC',  // Latest first
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',

		)
	);

    /**
     * Custom validation rule: ensure either named payer OR linked entity is present
     */
    public function validatePayerIdentity($check) {
        $data = $this->data[$this->alias];

        $hasNamedPayer = !empty($data['payer_name']) || !empty($data['payer_email']);
        $hasLinkedPayer = !empty($data['payer_type']) && !empty($data['payer_id']);

        // At least one of the two must be present
        if (!$hasNamedPayer && !$hasLinkedPayer) {
            return false;
        }

        // If linked payer is used, payer_id must be numeric
        if ($hasLinkedPayer && !is_numeric($data['payer_id'])) {
            return false;
        }

        return true;
    }

    /**
     * Helper method – set payer when creating/updating invoice
     *
     * @param string $modelName e.g. 'Student', 'OnlineApplicant', 'Employee'
     * @param int $id
     * @return void
     */
    public function setPayer($modelName, $id) {
        $this->data[$this->alias]['payer_type'] = $modelName;
        $this->data[$this->alias]['payer_id']   = (int)$id;

        $model = ClassRegistry::init($modelName);
        $payer = $model->find('first', array(
            'conditions' => array($model->primaryKey => $id),
            'recursive'  => -1
        ));
        if(isset($payer) && !empty($payer)) {
            $this->data[$this->alias]['payer_name']  = $payer[$modelName]['full_name'];
            $this->data[$this->alias]['payer_email'] = $payer[$modelName]['email'];
        }
        // Optional: clear fallback fields if using linked entity
        //$this->data[$this->alias]['payer_name']  = null;
        //$this->data[$this->alias]['payer_email'] = null;
    }

    /**
     * Helper method – set guest payer (fallback)
     *
     * @param string $name
     * @param string $email
     * @return void
     */
    public function setGuestPayer($name, $email) {
        $this->data[$this->alias]['payer_name']  = $name;
        $this->data[$this->alias]['payer_email'] = $email;
        // Optional: clear linked fields
        $this->data[$this->alias]['payer_type'] = null;
        $this->data[$this->alias]['payer_id']   = null;
    }

    /**
     * After find callback – optionally attach payer data
     */
    public function afterFind($results, $primary = false) {
        if (!$primary || empty($results)) {
            return $results;
        }

        foreach ($results as &$result) {
            if (!empty($result[$this->alias]['payer_type']) && !empty($result[$this->alias]['payer_id'])) {
                $modelName = $result[$this->alias]['payer_type'];
                $id = $result[$this->alias]['payer_id'];

                $model = ClassRegistry::init($modelName);
                $payer = $model->find('first', array(
                    'conditions' => array($model->primaryKey => $id),
                    'recursive'  => -1
                ));

                if ($payer) {
                    $result['Payer'] = $payer[$modelName];
                    $result['Payer']['model'] = $modelName;
                }
            }
        }

        return $results;
    }

    // Virtual field approach 1: using virtualFields (simplest, but recalculates every time)
    /*
    public $virtualFields = array(
        'remaining' => 'Invoice.total_amount - (
            SELECT COALESCE(SUM(Transaction.paid_amount), 0)
            FROM transactions AS Transaction
            WHERE Transaction.invoice_id = Invoice.id
            AND Transaction.status = "Success"
        )'
    );
    */

    // Optional custom validation
    public function validateRemaining($check) {
        $value = array_values($check)[0];
        if ($value < 0 && $this->data[$this->alias]['status'] !== 'Overpaid') {
            return false;
        }
        return true;
    }


    /**
     * Recalculate remaining and status after transaction changes
     * Now saves remaining as real field
     * Handles refunds (negative paid_amount) and overpayments
     *
     * @param int $invoiceId
     * @return bool
     */
    /**
     * Recalculate and save remaining + status after transaction change
     */
    public function updatePaymentStatus($invoiceId) {
        $this->id = $invoiceId;
        if (!$this->exists()) {
            return false;
        }

        $invoice = $this->find('first', [
            'conditions' => ['Invoice.id' => $invoiceId],
            'contain'    => ['Transaction'],
            'recursive'  => -1
        ]);

        if (empty($invoice)) {
            return false;
        }

        // Inside updatePaymentStatus in Invoice.php
        $totalPaid = 0;
        if (!empty($invoice['Transaction'])) {
            foreach ($invoice['Transaction'] as $t) {
                if (in_array($t['status'], ['Success', 'Completed', 'Refunded'])) {
                    $totalPaid += (float)$t['paid_amount'];
                }
            }
        }

        $remaining = round($invoice['Invoice']['total_amount'] - $totalPaid, 2);

        // Determine correct status
        $status = 'Pending';
        if ($remaining <= 0) {
            $status = ($remaining < 0) ? 'Overpaid' : 'Paid';
        } elseif ($remaining < $invoice['Invoice']['total_amount']) {
            $status = 'Partially Paid';
        }

        // Save both fields
        $saved = $this->save([
            'remaining' => $remaining,
            'status'    => $status
        ], [
            'fieldList' => ['remaining', 'status'],
            'callbacks' => false,           // avoid recursion
            'validate'  => false
        ]);

        if ($saved) {
            // Optional: send email when reaching Paid or Overpaid
            if (in_array($status, ['Paid', 'Overpaid'])) {
                $this->sendStatusNotification($invoice, $status);
            }
        }

        return $saved !== false;
    }

    /**
     * Send email notification on status change
     *
     * @param array $invoice Full invoice data
     * @param string $newStatus
     * @return bool
     */
    public function sendStatusNotification($invoice, $newStatus) {
        if (empty($invoice['Invoice']['payer_email'])) {
            return false;  // No email
        }

        $email = new CakeEmail('default');  // 'default' is your config in email.php

        if ($newStatus === 'Refund Issued') {
            $email->subject('Refund Issued for Invoice #' . $invoice['Invoice']['receipt_code']);
            // Add refund-specific message in template
        } else {
            $email->subject('Invoice #' . $invoice['Invoice']['receipt_code'] . ' Update: ' . $newStatus);
        }

        $email->to($invoice['Invoice']['payer_email'])
            ->emailFormat('html')
            ->template('invoice_status_update')  // Create this template in View/Emails/html/
            ->viewVars(array(
                'invoice'   => $invoice,
                'newStatus' => $newStatus
            ));

        try {
            $email->send();
            return true;
        } catch (Exception $e) {
            // Log error
            CakeLog::error('Failed to send email for invoice ' . $invoice['Invoice']['id'] . ': ' . $e->getMessage());
            return false;
        }
    }

    // In Invoice model
    public function getTotalRefunded($invoiceId) {
        return abs((float)$this->Transaction->find('first', array(
            'conditions' => array(
                'Transaction.invoice_id' => $invoiceId,
                'Transaction.status'     => 'Refunded',
                'Transaction.paid_amount <' => 0
            ),
            'fields' => array('SUM(ABS(Transaction.paid_amount)) AS total_refunded'),
            'recursive' => -1
        ))[0]['total_refunded'] ? (float)$this->Transaction->find('first', array(
            'conditions' => array(
                'Transaction.invoice_id' => $invoiceId,
                'Transaction.status'     => 'Refunded',
                'Transaction.paid_amount <' => 0
            ),
            'fields' => array('SUM(ABS(Transaction.paid_amount)) AS total_refunded'),
            'recursive' => -1
        ))[0]['total_refunded']: 0);
    }

}
