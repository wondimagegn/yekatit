<?php
App::uses('AppModel', 'Model');

class PaymentMethod extends AppModel {

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
        'Transaction' => array('className' => 'Transaction', 'foreignKey' => 'method_id'),
        'Attachment' => array(
            'className' => 'Media.Attachment',
            'foreignKey' => 'foreign_key',
            'conditions'    => array('model' => 'PaymentMethod'),
            'dependent' => true,
        ),

    );


    public $validate = array(
        'name' => array(
            'notEmpty' => array('rule' => 'notEmpty', 'message' => 'Name is required'),
            'unique' => array('rule' => 'isUnique', 'message' => 'Name must be unique')
        ),
        'active' => array('boolean' => array('rule' => 'boolean'))
    );
    function preparedAttachment($data = null)
    {

        foreach ($data['Attachment'] as $in =>  &$dv) {

            if (
                empty($dv['file']['name']) && empty($dv['file']['type'])
                && empty($dv['tmp_name'])
            ) {
                unset($data['Attachment'][$in]);
            } else if ($in == 0) {
                $dv['model'] = 'PaymentMethod';
                $dv['group'] = 'PaymentMethodLogo';
            }
        }
        return $data;
    }

    public function getMethodConfig($methodId) {
        $method = $this->find('first', array(
            'conditions' => array('PaymentMethod.id' => $methodId),
            'fields'     => array('config'),
            'recursive'  => -1
        ));

        if (empty($method) || empty($method['PaymentMethod']['config'])) {
            return array(); // or throw exception
        }

        $config = json_decode($method['PaymentMethod']['config'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            CakeLog::error("Invalid JSON in payment method config ID {$methodId}: " . json_last_error_msg());
            return array();
        }

        return $config;
    }
}