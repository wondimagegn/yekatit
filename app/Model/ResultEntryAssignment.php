<?php
App::uses('AppModel', 'Model');
/**
 * ResultEntryAssignment Model
 *
 * @property Student $Student
 * @property PublishedCourse $PublishedCourse
 * @property CourseRegistration $CourseRegistration
 * @property CourseAdd $CourseAdd
 */
class ResultEntryAssignment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'student_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'minute_number' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'published_course_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PublishedCourse' => array(
			'className' => 'PublishedCourse',
			'foreignKey' => 'published_course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseRegistration' => array(
			'className' => 'CourseRegistration',
			'foreignKey' => 'course_registration_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseAdd' => array(
			'className' => 'CourseAdd',
			'foreignKey' => 'course_add_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	function isRegisteredAndAddedCourse($published_course_id,$student_id){
		$registered=$this->CourseRegistration->find("count",array('conditions'=>array(
		'CourseRegistration.student_id'=>$student_id,
		'CourseRegistration.published_course_id'=>$published_course_id)));
		if($registered){
			return $registered;
		} else {
		$added=$this->CourseAdd->find("count",
		array(
		'conditions'=>
		array(
		'CourseAdd.student_id'=>$student_id,
		'CourseAdd.published_course_id'=>$published_course_id)));
			
			return $added;
		}
		
	}
	public function assignedResultEntry($published_course_id){
		$assigned=$this->find('count', 
				array(
					'conditions' => 
						array(
					
							'ResultEntryAssignment.published_course_id' => $published_course_id,
						),
						'recursive'=>-1
				)
			);
	    
		return $assigned;
	}
	function getExamResultEntry($department_id = "", $acadamic_year = "", $program_id = "", $program_type_id = "0", $semester = "0") {
		$makeup_exams_formated = array();
		if($department_id != "" && $acadamic_year != "" ) {
			$conditions['PublishedCourse.given_by_department_id'] = $department_id;
			$conditions['PublishedCourse.academic_year'] = $acadamic_year;
			if(isset($program_id) && !empty($program_id)){
			  $conditions['PublishedCourse.program_id'] = $program_id;
			}	
			if($program_type_id != "0")
				$conditions['PublishedCourse.program_type_id'] = $program_type_id;
			if($semester != "0")
				$conditions['PublishedCourse.semester'] = $semester;
			
			//result entry assingment published course exams which are assigned to the instructor
			debug($conditions);
			$all_makeup_exams = $this->PublishedCourse->find('all', 
				array(
					'conditions' => $conditions,
					'contain' => 
					array(
						'Section', 
						'Course', 
						'ResultEntryAssignment' => 
						array(
							
							'CourseRegistration' => 
							array(
								'PublishedCourse' => array('Course'),
								'Student',
								'ExamGrade'
							),
							'CourseAdd' => 
							array(
								'PublishedCourse' => array('Course'), 
								'Student',
							  'ExamGrade'
							)
						),
					)
				)
			);
			debug($all_makeup_exams);
			$count = 0;
			foreach($all_makeup_exams as $key => $makeup_exams) {
				if(isset($makeup_exams['ResultEntryAssignment']) && !empty($makeup_exams['ResultEntryAssignment'])) {
					foreach($makeup_exams['ResultEntryAssignment'] as $me_key => $makeup_exam) {//debug($makeup_exam);
						if(!empty($makeup_exam['CourseRegistration'])) {
							$makeup_exams_formated[$count]['student_name'] = $makeup_exam['CourseRegistration']['Student']['first_name'].' '.$makeup_exam['CourseRegistration']['Student']['middle_name'].' '.$makeup_exam['CourseRegistration']['Student']['last_name'];
							$makeup_exams_formated[$count]['student_id'] = $makeup_exam['CourseRegistration']['Student']['studentnumber'];
							$makeup_exams_formated[$count]['exam_for'] = $makeup_exam['CourseRegistration']['PublishedCourse']['Course']['course_title'].' ('.$makeup_exam['CourseRegistration']['PublishedCourse']['Course']['course_code'].') [Registered]';
						$makeup_exams_formated[$count]['ExamGrade'] = $makeup_exam['CourseRegistration']['ExamGrade'][0];
						}
						else {
							$makeup_exams_formated[$count]['student_name'] = $makeup_exam['CourseAdd']['Student']['first_name'].' '.$makeup_exam['CourseAdd']['Student']['middle_name'].' '.$makeup_exam['CourseAdd']['Student']['last_name'];
							$makeup_exams_formated[$count]['student_id'] = $makeup_exam['CourseAdd']['Student']['studentnumber'];
							$makeup_exams_formated[$count]['exam_for'] = $makeup_exam['CourseAdd']['PublishedCourse']['Course']['course_title'].' ('.$makeup_exam['CourseAdd']['PublishedCourse']['Course']['course_code'].') [Added]';
						$makeup_exams_formated[$count]['ExamGrade'] = $makeup_exam['CourseAdd']['ExamGrade'][0];
						
						}
						
						$makeup_exams_formated[$count]['minute_number'] = $makeup_exam['minute_number'];
						
						$makeup_exams_formated[$count]['taken_exam'] = $makeup_exams['Course']['course_title'].' ('.$makeup_exams['Course']['course_code'].')';
						$makeup_exams_formated[$count]['section_exam_taken'] = $makeup_exams['Section']['name'];
						
						$makeup_exams_formated[$count]['created'] = $makeup_exam['created'];
						$makeup_exams_formated[$count]['modified'] = $makeup_exam['modified'];
						
						
						
						$makeup_exams_formated[$count]['id'] = $makeup_exam['id'];
						$count++;
					}
				}
			}
		}
		
		return $makeup_exams_formated;
	}
}
