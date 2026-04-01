<?php
class StudentStatusPattern extends AppModel {
	var $name = 'StudentStatusPattern';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Program' => array(
			'className' => 'Program',
			'foreignKey' => 'program_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProgramType' => array(
			'className' => 'ProgramType',
			'foreignKey' => 'program_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function getProgramTypePattern($program_id = null, $program_type_id = null, $acadamic_year = null) {
		$status_patterns = $this->find('all', 
			array(
				'conditions' => 
				array(
					'StudentStatusPattern.program_id' => $program_id,
					'StudentStatusPattern.program_type_id' => $program_type_id
				),
				'order' => array('StudentStatusPattern.application_date ASC'),
				'recursive' => -1
			)
		);
		if(!empty($status_patterns)) {
			$pattern = $status_patterns[0]['StudentStatusPattern']['pattern'];
			$sys_acadamic_year = $status_patterns[0]['StudentStatusPattern']['acadamic_year'];
			//If it is introduced latelly
			if(substr($sys_acadamic_year, 0, 4) > substr($acadamic_year, 0, 4))
				return 1;
			else {
				do {
					foreach($status_patterns as $key => $status_pattern) {
						if($sys_acadamic_year == $status_pattern['StudentStatusPattern']['acadamic_year']) {
							$pattern = $status_pattern['StudentStatusPattern']['pattern'];
						}
					}
					if(strcasecmp($acadamic_year, $sys_acadamic_year) != 0) {
						$sys_acadamic_year = (substr($sys_acadamic_year, 0, 4)+1).'/'.
						substr((substr($sys_acadamic_year, 0, 4)+2), 2, 2);
					}
					else {
						return $pattern;
					}
				}while($sys_acadamic_year != '3000/01');
			}
			return $pattern;
		}
		else
			return 1;
	}
	function isLastSemesterInCurriculum($student_id){
	  
	   $minimumPointofCurriculum=ClassRegistry::init('Student')->find('first',
	   array('conditions'=>array('Student.id'=>$student_id),'contain'=>array('Curriculum')));
	   
	  $allAdded = ClassRegistry::init('CourseAdd')->find('all', 
			array(
				'conditions' => array(
				'CourseAdd.student_id' => $student_id,
				'CourseAdd.department_approval' => 1,
				'CourseAdd.registrar_confirmation' => 1
				
				),
				'contain' => 
				array(
					'PublishedCourse'=>array('Course'=>array('CourseCategory','Curriculum')),
					
				),
				
			)
		);
		$allRegistered=ClassRegistry::init('CourseRegistration')->find('all', 
			array(
				'conditions' => array(
				'CourseRegistration.student_id' => $student_id,
				
				),
				'contain' => 
				array(
					'PublishedCourse'=>array('Course'=>array('CourseCategory','Curriculum')),
					
				),
				
			)
		);
		$lastCreditSum=0;
		foreach($allRegistered as $lk=>$lv){
			$lastCreditSum+=$lv['PublishedCourse']['Course']['credit'];
		}
		foreach($allAdded as $lk=>$lv){
			$lastCreditSum+=$lv['PublishedCourse']['Course']['credit'];
		}
		debug($minimumPointofCurriculum['Curriculum']['minimum_credit_points']);
		debug($lastCreditSum);
		if($lastCreditSum >=$minimumPointofCurriculum['Curriculum']['minimum_credit_points']){
				return true;
		}
		return false;
		
	}
	
}
