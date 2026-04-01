<?php 
class GraduationController extends AppController {
	var $name = "Graduation";
	var $uses = array();
	var $menuOptions = array(
		'exclude' => array('index'),
	);
	  public $components =array('EthiopicDateTime','AcademicYear');

	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->Allow('course_check_list');
	}
	
	function index() {
		
	}

	public function course_check_list($student_id=null)
	{
	  if (!empty($this->request->data) && isset($this->request->data['continue'])) {  
		if (!empty($this->request->data['Student']['studentID'])) {
		$student_id_valid=ClassRegistry::init('Student')->
		find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']))));
		$check_id_is_valid=ClassRegistry::init('Student')->
		find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']))));
		$studentIDs=1;

		if ($student_id_valid>0 && $check_id_is_valid>0) {
		$everythingfine=true;
		$student_id=ClassRegistry::init('Student')->field('id',array('studentnumber'
		=>trim($this->request->data['Student']['studentID'])));
		$student_academic_profile=ClassRegistry::init('Student')->getStudentRegisteredAddDropCurriculumResult($student_id,$this->AcademicYear->current_academicyear());
		debug($student_academic_profile);
		$studentAttendedSections=ClassRegistry::init('Section')->getStudentSectionHistory($student_id);
		debug($student_academic_profile);

		$this->set(compact('student_academic_profile','studentAttendedSections'));
		} else {
		if($check_id_is_valid==0) {
		$this->Session->setFlash('<span></span> '.__('You dont have the privilage to view the selected students profile.'),'default',array('class'=>'error-box error-message'));   
		} else {
		$this->Session->setFlash('<span></span> '.__('The provided student number is not valid.'),'default',array('class'=>'error-box error-message'));
		}  
		}
		} else {
		$this->Session->setFlash('<span></span> '.__('Please provide student number to  view profile.'),'default',array('class'=>'error-box error-message'));  

		}
	  }      
	}
}
?>
