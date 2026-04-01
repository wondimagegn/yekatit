<?php
App::uses('AppModel', 'Model');
/**
 * GeneralSetting Model
 *
 * @property Program $Program
 * @property ProgramType $ProgramType
 */
class GeneralSetting extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
		'daysAvaiableForNgToF' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'daysAvaiableForDoToF' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'daysAvailableForFxToF' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'weekCountForAcademicYear' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'minimumCreditForStatus' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'allowMealWithoutCostsharing' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'notifyStudentsGradeByEmail' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'allowStudentsGradeViewWithouInstructorsEvalution' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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

	function daysAvaiableForGradeChange($published_course_id){
		$publishedCourses=ClassRegistry::init('PublishedCourse')->find('first',array('conditions'=>array('PublishedCourse.id'=>$published_course_id),
			'recursive'=>-1));
		
		if(!empty($publishedCourses)){
            $settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.$publishedCourses['PublishedCourse']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$publishedCourses['PublishedCourse']['program_type_id'].'"%',

			),'recursive'=>-1));
			return $settings['GeneralSetting']['daysAvaiableForGradeChange'];
		}
		
		return 14;
	}
	
	function daysAvaiableForNgToF(){
		//Important Note: The maximum allowed days should not be greater than 4 months
		return 14;
	}
	
	function daysAvaiableForDoToF(){
		//Important Note: The maximum allowed days should not be greater than 4 months
		return 43;
	}

	function daysAvailableForFxToF() {
		return 30;
	}
	
	function allowMealWithoutCostsharing($student_id) {
		$studentDetail=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id'=>$student_id),'recursive'=>-1));
		
		$settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.$studentDetail['Student']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$studentDetail['Student']['program_type_id'].'"%',

			),'recursive'=>-1));
		
		if(!empty($settings)){
           return $settings['GeneralSetting']['allowMealWithoutCostsharing'];
		}
		return 0;
	}

	function notifyStudentsGradeByEmail($exam_grade_id) {
		$gradeDetail=ClassRegistry::init('ExamGrade')->find('first',array('conditions'=>array('ExamGrade.id'=>$exam_grade_id),'contain'=>array('CourseRegistration'=>array('PublishedCourse'))));
		if(!empty($gradeDetail['CourseRegistration'])){
          $settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.
			$gradeDetail['CourseRegistration']['PublishedCourse']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$gradeDetail['CourseRegistration']['PublishedCourse']['program_type_id'].'"%',

			),'recursive'=>-1));
          return $settings['GeneralSetting']['notifyStudentsGradeByEmail'];
		} else if(!empty($gradeDetail['CourseAdd'])){
			 $settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.
			$gradeDetail['CourseAdd']['PublishedCourse']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$gradeDetail['CourseAdd']['PublishedCourse']['program_type_id'].'"%',

			),'recursive'=>-1));
          return $settings['GeneralSetting']['notifyStudentsGradeByEmail'];

		} else if(!empty($gradeDetail['MakeupExam'])){
              $settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.
			$gradeDetail['MakeupExam']['PublishedCourse']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$gradeDetail['MakeupExam']['PublishedCourse']['program_type_id'].'"%',

			),'recursive'=>-1));
          return $settings['GeneralSetting']['notifyStudentsGradeByEmail'];
		}
		return 0;
	}

	public function allowRegistrationWithoutPayment($student_id) {
		$studentDetail=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id'=>$student_id),'recursive'=>-1));
		
		$settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.$studentDetail['Student']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$studentDetail['Student']['program_type_id'].'"%',

			),'recursive'=>-1));
	
		if(!empty($settings)){
           return $settings['GeneralSetting']['allowRegistrationWithoutPayment'];
		}
		return 0;
	}

	function allowStudentsGradeViewWithouInstructorsEvalution($student_id) {
		$studentDetail=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id'=>$student_id),'recursive'=>-1));
		
		$settings=$this->find('first',array('conditions'=>array(
			'GeneralSetting.program_id like'=>'%s:_:"'.$studentDetail['Student']['program_id'].'"%',
			'GeneralSetting.program_type_id like'=>'%s:_:"'.$studentDetail['Student']['program_type_id'].'"%',

			),'recursive'=>-1));
		
		if(!empty($settings)){
           return $settings['GeneralSetting']['allowStudentsGradeViewWithouInstructorsEvalution'];
		}
		return 0;
	}
}
