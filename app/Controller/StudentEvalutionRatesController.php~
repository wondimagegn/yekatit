<?php
App::uses('AppController', 'Controller');
/**
 * StudentEvalutionRates Controller
 *
 * @property StudentEvalutionRate $StudentEvalutionRate
 * @property PaginatorComponent $Paginator
 */
class StudentEvalutionRatesController extends AppController {
   
    public $menuOptions = array(
              	'parent' => 'evalution',
            'exclude' => array('index'),
              'alias' => array(
                      'add'=>'Fill Evaluation Form',
                  
            )
    );
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	 public function beforeFilter() {
	     parent::beforeFilter();
	  	 //$this->Auth->Allow();
	
     }


/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		return $this->redirect(array('action' => 'add'));

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->StudentEvalutionRate->exists($id)) {
			throw new NotFoundException(__('Invalid student evalution rate'));
		}
		$options = array('conditions' => array('StudentEvalutionRate.' . $this->StudentEvalutionRate->primaryKey => $id));
		$this->set('studentEvalutionRate', $this->StudentEvalutionRate->find('first', $options));
	}

	/**
	 * get the most recent registered course lists, and 
	 * force to finish, and redirec to exam result page if
	 * finished evaluation 
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->StudentEvalutionRate->create();
			
			if ($this->StudentEvalutionRate->saveAll($this->request->data['StudentEvalutionRate'])) {
				if ($this->StudentEvalutionRate->InstructorEvalutionQuestion->StudentEvalutionComment->saveAll($this->request->data['StudentEvalutionComment'])) {
				
			    }
				$instructor=$this->request->data['Instructor']['full_name'];
				$this->Session->setFlash('<span></span>'.__('You have evaluated '.$instructor.' Thank you! Please fill the next instructor evaluation.'),'default',array('class'=>'success-box success-message'));

				return $this->redirect(array('action' => 'add'));
			} else {
				
				 // debug($this->request->data);
				$this->Session->setFlash('<span></span>'.__('The student evalution rate could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));

			}
			
		}
		$courseList = $this->StudentEvalutionRate->getNotEvaluatedRegisteredCourse($this->student_id);
		if(empty($courseList)){
			$this->Session->setFlash('<span></span>'.__('Thank you for completing instructor evaluation. You can view your grade now.'),'default',array('class'=>'success-box success-message'));
			// redirec to 
			$ac=$this->StudentEvalutionRate->getACSem($this->student_id);

			if(!empty($ac['academicYear'])){
				$academicYear=str_replace("/", "-",$ac['academicYear']);

				$semester=$ac['semester'];
			    return $this->redirect(array('controller'=>'exam_grades','action' => "student_grade_view/$academicYear/$academicYear/$semester"));
			}
			return $this->redirect(array('controller'=>'exam_grades','action' => "student_grade_view"));
			
			
		}
		$instructorEvalutionQuestionsObjective = $this->StudentEvalutionRate->InstructorEvalutionQuestion->find('all',array('conditions'=>array(
			'InstructorEvalutionQuestion.type'=>'objective',
			'InstructorEvalutionQuestion.for'=>'student',
			'InstructorEvalutionQuestion.active'=>1

			),'fields'=>array('InstructorEvalutionQuestion.id',
			'InstructorEvalutionQuestion.question',
			'InstructorEvalutionQuestion.question_amharic'
			),
			'recursive'=>-1
			));

		$instructorEvalutionQuestionsOpenEnded = $this->StudentEvalutionRate->InstructorEvalutionQuestion->find('all',array('conditions'=>array('InstructorEvalutionQuestion.type'=>'open-ended',
            'InstructorEvalutionQuestion.for'=>'student',
            'InstructorEvalutionQuestion.active'=>1

			),
			'recursive'=>-1,
			'fields'=>array('InstructorEvalutionQuestion.id',
			'InstructorEvalutionQuestion.question',
			'InstructorEvalutionQuestion.question_amharic',
			)));


		$this->set(compact('instructorEvalutionQuestionsObjective',
		'instructorEvalutionQuestionsOpenEnded','courseList'));
	}

}
