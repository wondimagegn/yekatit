<?php
class DepartmentTransfer extends AppModel {
	var $name = 'DepartmentTransfer';
	var $validate = array(
		
		'minute_number' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Provide minute number.',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
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
		),
		/*
		'FromDepartment' => array(
			'className' => 'Department',
			'foreignKey' => 'from_department_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),*/
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function attachSemesterAttended ($data=null) {
	        
	        if (!empty($data)) {
	            foreach ($data as $i=>&$v) {
	                  $v['DepartmentTransfer']['semester_attended']=ClassRegistry::init('ExamGrade')->getListOfAyAndSemester($v['DepartmentTransfer']['student_id']);
	            }
	        }
	        return $data;       
	}

	function getTransferedCourseCredit($student_id) {
		$transferedDepartment=$this->find('all',
array('conditions'=>array('DepartmentTransfer.student_id'=>$student_id,
'DepartmentTransfer.sender_department_approval'=>1,
'DepartmentTransfer.sender_college_approval'=>1,
'DepartmentTransfer.receiver_department_approval'=>1,
'DepartmentTransfer.receiver_college_approval'=>1,
)));
	$totalTransfered=0;
        foreach($transferedDepartment as $k=>$v) {
           // find all courses registered in the previous department 
	     $transferSql="SELECT cr.id, cr.student_id, cr.published_course_id, pc.course_id, pc.department_id
FROM  `course_registrations` AS cr, published_courses AS pc
WHERE pc.department_id=".$v['DepartmentTransfer']['from_department_id']."
AND pc.id = cr.published_course_id
AND cr.student_id=".$v['DepartmentTransfer']['student_id']."";
	   $transferResult = $this->query($transferSql);
	   foreach($transferResult as $kk=>$vv) {
                if(isset($vv['cr']['id']) && $this->Student->CourseRegistration->ExamGrade->isRegistrationAddForFirstTime($vv['cr']['id'], 1, 1)) {
		$totalTransfered+=$totalTransfered;			

		}
	   }

            $transferAddSql="SELECT cr.id, cr.student_id, cr.published_course_id, pc.course_id, pc.department_id
FROM  `course_adds` AS cr, published_courses AS pc
WHERE pc.department_id=".$v['DepartmentTransfer']['from_department_id']."
AND pc.id = cr.published_course_id
AND cr.student_id=".$v['DepartmentTransfer']['student_id']."";
	   $transferAddResult = $this->query($transferAddSql);
	   foreach($transferResult as $kk=>$vv) {
               
                if(isset($vv['cr']['id']) && $this->Student->
CourseRegistration->ExamGrade->isRegistrationAddForFirstTime($vv['cr']['id'], 0, 1)) {
                 $totalTransfered+=$totalTransfered;			

		}
	   }

	}
     return $totalTransfered;
    }
}
