<?php
class Contact extends AppModel {
	var $name = 'Contact';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
    var $virtualFields = array(
        'full_name' => 'CONCAT(Contact.first_name, " ",Contact.middle_name," ",Contact.last_name)');
       
	var $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Staff' => array(
			'className' => 'Staff',
			'foreignKey' => 'staff_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $validate = array(
		'first_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter contact first name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'middle_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter contact middle name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter contact last name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
		'kebele' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter contact kebele',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'phone_mobile' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Enter mobile phone number including country code.',
				'allowEmpty' => true,
			       'required' => false,
				
			),
            		'unique'=>array(
				 'rule'=>'isUnique',
				 'message'=>'The mobile phone number is used by someone. Please provide another phone number.',
				 'on' => 'update',
			)
		),
		
	);
}
