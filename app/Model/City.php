<?php
class City extends AppModel {
	var $name = 'City';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'city_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Staff' => array(
			'className' => 'Staff',
			'foreignKey' => 'city_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'city_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	function canItBeDeleted($city_id = null) {
		if($this->Student->find('count', array('conditions' => array('Student.city_id' 
		=> $city_id))) > 0)
			return false;
		else if($this->Contact->find('count', array('conditions' => 
		array('Contact.city_id' =>$city_id))) > 0)
			return false;
		else
			return true;
	 }

	
	var $validate = array(
	   'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Provide city name.',
				'allowEmpty' => false,
				'required' => false,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUniqueCityInRegion' => array(
			    'rule' => array('isUniqueCityInRegion'),
				'message' => 'The city name should be unique in the selected region. The name is already taken. Use another one.'
			),
		),
		
	);
	
	function isUniqueCityInRegion() {
	        $count=0;
            if (!empty($this->data['City']['id'])) {
               $count=$this->find('count',array('conditions'=>array('City.region_id'=>$this->data['City']['region_id'],'City.name'=>$this->data['City']['name'],'City.id <>'=> $this->data['City']['id'])));
               
            } else {
             $count=$this->find('count',array('conditions'=>array('City.region_id'=>$this->data['City']['region_id'],'City.name'=>$this->data['City']['name'])));
            }
	        
	        if ($count>0) {
	            return false;
	        } 
	        return true; 
    }
}
