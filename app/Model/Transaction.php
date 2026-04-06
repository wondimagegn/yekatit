<?php
App::uses('AppModel', 'Model');
/**
 * Transaction Model
 *
 * @property Invoice $Invoice
 * @property Student $Student
 * @property Currency $Currency
 * @property Method $Method
 */
class Transaction extends AppModel {

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
            'field' => 'transaction_code',
            'prefix' => 'TRN',
            'date_format' => 'Y', // e.g., TRN-2025-000123
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
		'transaction_code' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
        /*
        'paid_amount' => array(
            'numeric' => array('rule' => 'numeric'),
            'message' => 'Amount must be a valid number'
        ),
        */
		'currency_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
        /*
		'converted_amount' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
        */
		'method_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
        'status' => array(
            'valid' => array(
                'rule' => array('inList', array('Success', 'Completed', 'Pending', 'Failed', 'Refunded', 'Credit')),
                'message' => 'Invalid status'
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
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'invoice_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PaymentCurrency' => array(
			'className' => 'PaymentCurrency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PaymentMethod' => array(
            
			'className' => 'PaymentMethod',
			'foreignKey' => 'method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        if (!empty($this->data[$this->alias]['invoice_id'])) {
            $this->Invoice->updatePaymentStatus(
                $this->data[$this->alias]['invoice_id']
            );
        }
        return true;
    }


    private $deletedInvoiceId = null;

    public function beforeDelete($cascade = true) {
        $this->deletedInvoiceId = $this->field('invoice_id');
        return parent::beforeDelete($cascade);
    }

    public function afterDelete() {
        if (!empty($this->deletedInvoiceId)) {
            $this->Invoice->updatePaymentStatus($this->deletedInvoiceId);
            $this->deletedInvoiceId = null;
        }
        return true;
    }

}
