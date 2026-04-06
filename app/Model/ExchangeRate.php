<?php
App::uses('AppModel', 'Model');
/**
 * ExchangeRate Model
 *
 * @property FromCurrency $FromCurrency
 * @property ToCurrency $ToCurrency
 */
class ExchangeRate extends AppModel {

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
		)
	);

    public $validate = array(
        'from_currency_id' => array('notBlank' => array('rule' => 'notBlank', 'message' => 'From currency is required')),
        'to_currency_id' => array('notBlank' => array('rule' => 'notBlank', 'message' => 'To currency is required')),
        'rate' => array('decimal' => array('rule' => array('decimal'), 'message' => 'Must be a valid rate')),
        'effective_date' => array('date' => array('rule' => 'date', 'message' => 'Must be a valid date'))
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed

    public $belongsTo = array(
        'FromCurrency' => array('className' => 'PaymentCurrency', 'foreignKey' => 'from_currency_id'),
        'ToCurrency' => array('className' => 'PaymentCurrency', 'foreignKey' => 'to_currency_id')
    );

}
