<?php
App::uses('AppModel', 'Model');

class PaymentCurrency extends AppModel {

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
    
    public $hasMany = array(
        'FeeType' => array('className' => 'FeeType', 'foreignKey' => 'currency_id'),
        'Transaction' => array('className' => 'Transaction', 'foreignKey' => 'currency_id')
    );

    public $validate = array(
        'name' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'Name is required'),
            'unique' => array('rule' => 'isUnique', 'message' => 'Name must be unique')
        ),
        'currency_code' => array('notEmpty' => array('rule' => 'notEmpty', 'message' => 'Currency code is required')),
        'currency_territory' => array('notEmpty' => array('rule' => 'notEmpty', 'message' => 'Territory is required'))
    );
}