<?php
class YearLevel extends AppModel {
	var $name = 'YearLevel';
	var $validate = array(
		
		'department_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select department',
				'allowEmpty' => false,
				'required' => false,
				'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'year_level_id',
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
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'year_level_id',
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
		'ExamPeriod' => array(
			'className' => 'ExamPeriod',
			'foreignKey' => 'year_level_id',
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
    /**
    *Function that returns distinct year level for registrar 
    *Return array of year level 
    */
    function distinct_year_level () {
       		$year_level_find=$this->find('all',
		   array('fields'=>array('DISTINCT YearLevel.name'),
		  'order'=>'YearLevel.name asc','group'=>'YearLevel.name','recursive'=>-1));
		    $extract=Set::extract('/YearLevel/name', $year_level_find);
		  
		    $yearLevels=$extract;
		    $yearLevels=$this->find('all',
		   array('fields'=>array('DISTINCT YearLevel.name'),'recursive'=>-1));
		
		    $yearleveldistinct=array();
		    foreach($yearLevels as $key=>$value){
		    		$yearleveldistinct[$value['YearLevel']['name']]=$value['YearLevel']['name'];
		    }
		    
		   return $yearleveldistinct;
    }
	
	function get_department_max_year_level($department_ids = null) {
		$max_year_level = 0;
		if(is_array($department_ids)) {
			foreach($department_ids as $department_id => $department_name) {
				$yearLevels = $this->find('list',
					array(
						'conditions' =>
						array(
							'YearLevel.department_id' => $department_id
						)
					)
				);
				foreach($yearLevels as $yearLevel) {
					$year_level_number = substr($yearLevel, 0, strlen($yearLevel)-2);
					if($year_level_number > $max_year_level) {
						$max_year_level = $year_level_number;
					}
				}
			}
		}
		else {
			$yearLevels = $this->find('list',
				array(
					'conditions' =>
					array(
						'YearLevel.department_id' => $department_id
					)
				)
			);
			foreach($yearLevels as $yearLevel) {
				$year_level_number = substr($yearLevel, 0, strlen($yearLevel)-2);
				if($year_level_number > $max_year_level) {
					$max_year_level = $year_level_number;
				}
			}
		}
		return $max_year_level;
	}

	

	function getNextYearLevel($yearLevelId,$departmentId) {
		$yearLevel=$this->find('first',array('conditions'=>array('YearLevel.id'=>$yearLevelId),'recursive'=>-1));
		$yearLevels=$this->find('all',array('conditions'=>array('YearLevel.department_id'=>$departmentId),'recursive'=>-1,'order'=>'YearLevel.name ASC'));	
		foreach($yearLevels as $k=>$v){
			if($v['YearLevel']['name']>$yearLevel['YearLevel']['name']){
                     return $v['YearLevel']['id'];
			}
		}
		return null;
	}
	
}
?>
