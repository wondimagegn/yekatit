<?php
App::uses('AppModel', 'Model');
/**
 * StudentEvalutionRate Model
 *
 * @property InstructorEvalutionQuestion $InstructorEvalutionQuestion
 * @property Student $Student
 * @property PublishedCourse $PublishedCourse
 */
class StudentEvalutionRate extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'instructor_evalution_question_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'rating' => array(
			'notBlank' => array(
				'rule'=>'notBlank',
				'required' => true,
			)
		),
		
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InstructorEvalutionQuestion' => array(
			'className' => 'InstructorEvalutionQuestion',
			'foreignKey' => 'instructor_evalution_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
		)
	);

	public function getNotEvaluatedRegisteredCourse($student_id){
		$course=array();
		$mostRecentReg=$this->Student->CourseRegistration->find('first',array('conditions'=>array('CourseRegistration.student_id'=>$student_id),
			'order'=>'CourseRegistration.created DESC',
			
			'recursive'=>-1));
		
		if(!empty($mostRecentReg)){
		  $course=$this->Student->CourseRegistration->find('first',array('conditions'=>array(
			'CourseRegistration.student_id'=>$student_id,
			'CourseRegistration.semester'=>$mostRecentReg['CourseRegistration']['semester'],
			'CourseRegistration.academic_year'=>$mostRecentReg['CourseRegistration']['academic_year'],
           "CourseRegistration.published_course_id not in (select published_course_id from student_evalution_rates where student_id=$student_id and published_course_id is not null )",
           "CourseRegistration.published_course_id  in (select published_course_id from course_instructor_assignments where isprimary=1 and published_course_id is not null)"
			),
			
			'order'=>array('CourseRegistration.created DESC'),
            'contain'=>array('PublishedCourse'=>array(
            	'Course','CourseInstructorAssignment'=>array('Staff'=>array('Title','Position'))))
			));	
		}
		
		
		return $course;
	}

	public function getACSem($student_id){
		$getAS=array();
		$course=$this->Student->CourseRegistration->find('first',array('conditions'=>array(
			'CourseRegistration.student_id'=>$student_id,
          
			),
			'order'=>array('CourseRegistration.created DESC'),
			));
		if(!empty($course)){
			$getAS['academicYear']=$course['CourseRegistration']['academic_year'];
		    $getAS['semester']=$course['CourseRegistration']['semester'];
		}
		
		return $getAS;
	}
}
