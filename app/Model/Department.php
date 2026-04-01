<?php
class Department extends AppModel {
	var $name = 'Department';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
 	 var $validate = array(
			'name' => array(
				'notBlank' => array(
					'rule' => 'notBlank',
					'message' => 'Name is required'
				
			    ),
			    'isUniqueDepartmentInCollege' => array(
			        'rule' => array('isUniqueDepartmentInCollege'),
				    'message' => 'The college name should be unique in the campus. 
				    The name is already taken. Use another one.'
			    ),
			  ),
    );
    
     function isUniqueDepartmentInCollege () {
	 
	    $count=0;
        if (!empty($this->data['Department']['id'])) {
          $count=$this->find('count',array('conditions'=>array('Department.college_id'=>$this->data['Department']['college_id'],'Department.name'=>trim($this->data['Department']['name']),
          'Department.id <> '=>$this->data['Department']['id'])));
        } else {
          $count=$this->find('count',array('conditions'=>array('Department.college_id'=>$this->data['Department']['college_id'],'Department.name'=>trim($this->data['Department']['name']))));
        }
	    if ($count>0) {
	        return false;
	    } 
	    
	    return true; 
	}
	
	var $belongsTo = array(
		'College' => array(
			'className' => 'College',
			'foreignKey' => 'college_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'AcceptedStudent' => array(
			'className' => 'AcceptedStudent',
			'foreignKey' => 'department_id',
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
		 'DepartmentTransfer' => array(
			'className' => 'DepartmentTransfer',
			'foreignKey' => 'department_id',
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
		/*'GradeScale' => array(
			'className' => 'GradeScale',
			'foreignKey' => 'department_id',
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
		*/
		'Curriculum' => array(
			'className' => 'Curriculum',
			'foreignKey' => 'department_id',
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
			'foreignKey' => 'department_id',
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
		'PublishedCourse' => array(
			'className' => 'PublishedCourse',
			'foreignKey' => 'department_id',
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
		'Note' => array(
			'className' => 'Note',
			'foreignKey' => 'department_id',
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
		'Offer' => array(
			'className' => 'Offer',
			'foreignKey' => 'department_id',
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
		'Preference' => array(
			'className' => 'Preference',
			'foreignKey' => 'department_id',
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
			'foreignKey' => 'department_id',
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
			'foreignKey' => 'department_id',
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
        'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'department_id',
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
       'YearLevel' => array(
			'className' => 'YearLevel',
			'foreignKey' => 'department_id',
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
		'GradeScale' => array( 
            'className' => 'GradeScale', 
            'foreignKey' => 'foreign_key', 
            'conditions'    => array('model' => 'Department'),
            'dependent' => true, 
        ),
        'AcademicCalendar' => array(
			'className' => 'AcademicCalendar',
			'foreignKey' => 'college_id',
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
		'TakenProperty' => array(
			'className' => 'TakenProperty',
			'foreignKey' => 'department_id',
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
	);
	
	
   function canItBeDeleted($department_id = null) {
		        if($this->YearLevel->find('count', array('conditions' => array('YearLevel.department_id' =>$department_id))) > 0)
			        return false;
			    if($this->Student->find('count', array('conditions' => array('Student.department_id' =>$department_id))) > 0)
			        return false;
		        else if($this->Section->find('count', array('conditions' => array('Section.department_id' => $department_id))) > 0)
			        return false;
		        else if($this->GradeScale->find('count', array('conditions' => array('GradeScale.model' =>'Department','GradeScale.foreign_key'=>$department_id))) > 0)
			        return false;
			     else if($this->PublishedCourse->find('count', array('conditions' => array('PublishedCourse.department_id' =>$department_id))) > 0)
			        return false;
			     else if($this->Curriculum->find('count', array('conditions' => array('Curriculum.department_id' =>$department_id))) > 0)
			        return false;
			     else if($this->AcceptedStudent->find('count', array('conditions' => array('AcceptedStudent.department_id' =>$department_id))) > 0)
			        return false;
			     else if($this->AcceptedStudent->find('count', array('conditions' => array('AcceptedStudent.department_id' =>$department_id))) > 0)
			        return false;
			       else if($this->AcceptedStudent->find('count', array('conditions' => array('AcceptedStudent.department_id' =>$department_id))) > 0)
			        return false;
		        else if($this->Staff->find('count', array('conditions' => array('Staff.department_id'=>$department_id)))>0)
		            return false;
		        else
			        return true;
		}
	
	function allDepartmentsByCollege($include_freshman_program = 0){
		$departments_organized = array();
		$departments_data = $this->College->find('all', 
			array(
				'contain' => array('Department')
			)
		);//debug($departments_data);
		foreach($departments_data as $key => $college_and_department) {
			$departments_organized[$college_and_department['College']['name']] = array();
			if($include_freshman_program == 1)
				$departments_organized[$college_and_department['College']['name']]['c~'.$college_and_department['College']['id']] = 'Freshman Program';
			foreach($college_and_department['Department'] as $key => $department) {
				$departments_organized[$college_and_department['College']['name']][$department['id']] = $department['name'];
			}
		}
		//array_unshift($sections_organized, array('' => '--- Select Section ---'));
		//debug($departments_organized);
		return $departments_organized;
	}
	//Filter list of departments by thier privligae (It is for registrar)
	function allDepartmentsByCollege2($include_all_department = 0, $privilaged_department_ids = array(), 
	$privilaged_collage_ids = array()){
		$departments_organized = array();
		if(!empty($privilaged_department_ids)){
           $departments_data = $this->College->find('all', 
			array(
				'contain' => array('Department'=>array('conditions'=>array('Department.id'=>$privilaged_department_ids)))
			)
		);
		} else if(!empty($privilaged_collage_ids)){
           $departments_data = $this->College->find('all', 
			array(
				'conditions'=>array('College.id'=>$privilaged_collage_ids),
				'contain' => array('Department')
			)
		);

		} else {
			 $departments_data = $this->College->find('all', 
			array(
				'contain' => array('Department')
			)
		);
		debug($departments_data);
		}
		
		foreach($departments_data as $key => $college_and_department) {
			//$departments_organized[$college_and_department['College']['name']] = array();
			if($include_all_department == 1) {
				$departments_organized[$college_and_department['College']['name']]['c~'.$college_and_department['College']['id']] = 'All '.$college_and_department['College']['shortname'].'';
			}
			else if(in_array($college_and_department['College']['id'], $privilaged_collage_ids)) {
				$departments_organized[$college_and_department['College']['name']]['c~'.$college_and_department['College']['id']] = 'Freshman Program';
			}
			foreach($college_and_department['Department']
			 as $key => $department) {
				//debug($department['id']);
				//debug($privilaged_department_ids);
				if(is_array($privilaged_department_ids) && 
				!empty($privilaged_department_id)) {
					if(in_array($department['id'], $privilaged_department_ids)) {
						$departments_organized[$college_and_department['College']['name']][$department['id']] = $department['name'];
					}
				} else if(isset($privilaged_department_id) && $department['id']==$privilaged_department_ids) {
                   debug($department);
                   $departments_organized[$college_and_department['College']['name']][$department['id']] = $department['name'];
				} else {
					
					$departments_organized[$college_and_department['College']['name']][$department['id']] = $department['name'];
				}
				
			}
		}
		//array_unshift($sections_organized, array('' => '--- Select Section ---'));
		//debug($departments_organized);
		return $departments_organized;
	}

	//Filter list of departments by college (It is for college privliage use like grade view)
	function allCollegeDepartments($college_id = null) {
		$departments_organized = array();
		$departments_data = $this->College->Department->find('all', 
			array(
				'conditions' => array('Department.college_id' => $college_id),
				'recursive' => -1
			)
		);
		$departments_organized['c~'.$college_id] = 'Freshman Program';
		foreach($departments_data as $key => $department) {
			$departments_organized[$department['Department']['id']] = $department['Department']['name'];
		}
		return $departments_organized;
	}
	
	//Filter list of departments by thier privligae (It is for registrar)
	function allDepartmentsByCollege3($include_all_department = 0, $privilaged_department_ids = array(), 
	$privilaged_collage_ids = array()){
		$departments_organized = array();
		$departments_data = $this->College->find('all', 
			array(
				'contain' => array('Department')
			)
		);
		foreach($departments_data as $key => $college_and_department) {
			//$departments_organized[$college_and_department['College']['name']] = array();
			if($include_all_department == 1) {
				$departments_organized[$college_and_department['College']['name']]['c~'.$college_and_department['College']['id']] = 'All '.$college_and_department['College']['shortname'].' Students';
			}
			/*
			else if(in_array($college_and_department['College']['id'], $privilaged_collage_ids)) {
				$departments_organized[$college_and_department['College']['name']]['c~'.$college_and_department['College']['id']] = 'Freshman Program';
			}
			*/
			foreach($college_and_department['Department'] as $key => $department) {
				
			//	if(in_array($department['id'], $privilaged_department_ids)) {
					$departments_organized[$college_and_department['College']['name']][$department['id']] = 
					$department['name'];
			  //  }
			}
		}
		//array_unshift($sections_organized, array('' => '--- Select Section ---'));
		//debug($departments_organized);
		return $departments_organized;
	}

	function allDepartmentInCollegeIncludingPre($department_ids=null,$college_ids=null,$includePre=0) {
		  $departments=array(); 
		  if(!empty($department_ids)) {
		       	$college_s=$this->find('all',
			   array('conditions'=>array('Department.id'=>$department_ids),'contain'=>array('College')));
			foreach($college_s as $k=>$v){
				if($includePre) {
				$departments['c~'.$v['College']['id']]='Pre '.$v['College']['name'];
				} else {
				$departments[$v['Department']['id']]=$v['Department']['name'];	
				}	
			}
		   }

		  if(!empty($college_ids)) {
		           $college_s=$this->find('all',array('conditions'=>array('Department.college_id'=>$college_ids),'contain'=>array('College')));
			foreach($college_s as $k=>$v){
				if($includePre){
				$departments['c~'.$v['College']['id']]='Pre '.$v['College']['name'];
				} else {			
				$departments[$v['Department']['id']]=$v['Department']['name'];	
				}	
			} 
		 }
		 return $departments;
	} 


}
