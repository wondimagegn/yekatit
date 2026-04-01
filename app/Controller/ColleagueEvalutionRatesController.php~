<?php
App::uses('AppController', 'Controller');
/**
 * ColleagueEvalutionRates Controller
 *
 * @property ColleagueEvalutionRate $ColleagueEvalutionRate
 * @property PaginatorComponent $Paginator
 */
class ColleagueEvalutionRatesController extends AppController {
	  public $components = array('AcademicYear');
	  public $menuOptions = array(
             'parent'=>'evalution',
             'exclude' => array('index'),
             'alias' => array(
                    'colleague_evaluate_instructor'=>'Evaluate Colleagues',
                     'head_evaluate_instructor'=>'Evaluate Instructor as Head',
                     'instructor_evaluation_report' => 'Instructor Evaluation Reports',
                  
            )
    );
	public function beforeFilter() {
	     parent::beforeFilter();
	   //  $this->Auth->Allow();
	}


	public function beforeRender() {
		$acyear_array_data = $this->AcademicYear->acyear_array();
		//To diplay current academic year as default in drop down list
		$academic_year_selected=$defaultacademicyear=$this->AcademicYear->current_academicyear();
		$this->set(compact('acyear_array_data','defaultacademicyear','academic_year_selected'));
	}
	
	public function index(){
		return $this->redirect(array('action' => 'colleague_evaluate_instructor'));
	}
	
	public function colleague_evaluate_instructor($staff_id = null) {
		$this->__colleague_evaluate_instructor($staff_id);
	}
	private function __colleague_evaluate_instructor($staff_id=null) {
		
		if(isset($this->request->data['getInstructorList'])){
         
          $colleagueLists = $this->ColleagueEvalutionRate->getNotEvaluatedColleagues($this->request->data,
          	$this->Auth->user('id'));
          if(empty($colleagueLists)){
             $this->Session->setFlash('<span></span>'.__('No result found.'),'default',array('class'=>'error-box error-message'));
          }
		}

		//get list of instructors
		if(isset($this->request->data['submitEvaluationResult'])){
			
			  $colleagueList=array();
			  $count=0;
			  $instructor=$this->ColleagueEvalutionRate->Staff->find('first',array('conditions'=>
			  	array('Staff.id'=>$this->request->data['Search']['staff_id']),'recursive'=>-1));
			  $evaluatorStaff=$this->ColleagueEvalutionRate->Staff->find('first',array('conditions'=>
			  	array('Staff.user_id'=>$this->Auth->user('id')),'contain'=>array('Title','Position')));
			  $isInstructorEvaluated=$this->ColleagueEvalutionRate->find('count',
			  	array('conditions'=>array('ColleagueEvalutionRate.semester'=>$this->request->data['Search']['semester'],
'ColleagueEvalutionRate.academic_year'=>$this->request->data['Search']['acadamic_year'],
'ColleagueEvalutionRate.staff_id'=>$this->request->data['Search']['staff_id'],
'ColleagueEvalutionRate.evaluator_id'=>$evaluatorStaff['Staff']['id']
			  		)));
			  
			  if($isInstructorEvaluated==0 ){
			  foreach ($this->request->data['ColleagueEvalutionRate'] as $key => $value) {
			  
			  	$colleagueList['ColleagueEvalutionRate'][$count]['academic_year']=
			  	$this->request->data['Search']['acadamic_year'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['semester']=
			  	$this->request->data['Search']['semester'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['instructor_evalution_question_id']=$value['instructor_evalution_question_id'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['staff_id']=
			  	$this->request->data['Search']['staff_id'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['evaluator_id']=
			  	$evaluatorStaff['Staff']['id'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['rating']=$value['rating'];
			  	$count++;
			  }
              
			  if ($this->ColleagueEvalutionRate->saveAll(
			  	$colleagueList['ColleagueEvalutionRate'])) {
				$this->Session->setFlash('<span></span>'.__('You have evaluated '.
				$instructor['Title']['title'].' '.
				$instructor['Staff']['full_name'].' '.
				$instructor['Position']['position'].
				' Thank you! Please fill the next instructor evaluation.'),
				'default',array('class'=>'success-box success-message'));
			  } else {
				 $this->Session->setFlash('<span></span>'.__('The  evalution rate could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			  }

			} else {
				 $this->Session->setFlash('<span></span>'.__("You have already evaluated ".
				 $instructor['Title']['title'].' '.$instructor['Staff']['full_name'].' '.
				 $instructor['Position']['position'].""),
				 'default',array('class'=>'error-box error-message'));
			}
		}

		
		$instructorEvalutionQuestionsObjective = $this->ColleagueEvalutionRate->InstructorEvalutionQuestion->find('all',array('conditions'=>array(
			'InstructorEvalutionQuestion.type'=>'objective',
			'InstructorEvalutionQuestion.for'=>'colleague',
			'InstructorEvalutionQuestion.active'=>1

			),'fields'=>array('InstructorEvalutionQuestion.id',
			'InstructorEvalutionQuestion.question',
			'InstructorEvalutionQuestion.question_amharic'
			)));
		$this->set(compact('colleagueLists','instructorEvalutionQuestionsObjective'));
		$this->render('colleague_evaluate_instructor');
	}
	public function head_evaluate_instructor($staff_id=null) {
		
		$this->__head_evaluate_instructor($staff_id);
	}

	
	public function instructor_evaluation_report($staff_id=null) {
		
		$this->__instructor_evaluation_report($staff_id);
	}
	private function __instructor_evaluation_report($staff_id=null) {

		if(isset($this->request->data['getInstructorList'])){
         
          	  $colleagueLists = $this->ColleagueEvalutionRate->getEvaluatedColleaguesListForHeadReport($this->request->data,$this->Auth->user('id'));
	          if(empty($colleagueLists)){
	             $this->Session->setFlash('<span></span>'.__('No result found.'),'default',array('class'=>'error-box error-message'));
	          }
	          $this->set(compact('colleagueLists'));
		}

		//get list of instructors
		if(isset($this->request->data['generateEvaluationReport'])){
			
			  $evaluationAggregateds=$this->ColleagueEvalutionRate->getInstructorEvaluationResult($this->request->data, $this->department_id);
			
			    if(empty($evaluationAggregateds)) {
					$this->Session->setFlash('<span></span>'.__('There is no evaluation report for selected instructor '), 'default', array('class'=>'info-box info-message'));
				}
				else {

					$this->set(compact('evaluationAggregateds'));
					
					$this->response->type('application/pdf');
					$this->layout = '/pdf/default';
					$this->render('instructor_evaluation_report_pdf');
					
					return;
					
				}
				
		}

		$this->set(compact('colleagueLists'));
		$this->render('instructor_evaluation_report');
	}
    private function __head_evaluate_instructor($staff_id=null) {
		
		if(isset($this->request->data['getInstructorList'])){
         
          $colleagueLists = $this->ColleagueEvalutionRate->getNotEvaluatedColleaguesListForHead($this->request->data,
          	$this->Auth->user('id'));
          if(empty($colleagueLists)){
             $this->Session->setFlash('<span></span>'.__('No result found.'),'default',array('class'=>'error-box error-message'));
          }
		}

		//get list of instructors
		if(isset($this->request->data['submitEvaluationResult'])){
			  $colleagueList=array();
			  $count=0;
			  $instructor=$this->ColleagueEvalutionRate->Staff->find('first',array('conditions'=>
			  	array('Staff.id'=>$this->request->data['Search']['staff_id']),'recursive'=>-1));
			   $evaluatorStaff=$this->ColleagueEvalutionRate->Staff->find('first',array('conditions'=>
			  	array('Staff.user_id'=>$this->Auth->user('id')),'contain'=>array('Title','Position')));

			 foreach ($this->request->data['ColleagueEvalutionRate'] as $key => $value) {  

			  	$colleagueList['ColleagueEvalutionRate'][$count]['academic_year']=$this->request->data['Search']['acadamic_year'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['semester']=$this->request->data['Search']['semester'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['instructor_evalution_question_id']=$value['instructor_evalution_question_id'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['staff_id']=$this->request->data['Search']['staff_id'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['evaluator_id']=$evaluatorStaff['Staff']['id'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['rating']=$value['rating'];
			  	$colleagueList['ColleagueEvalutionRate'][$count]['dept_head']=1;
			  	$count++;

			}
              
			if ($this->ColleagueEvalutionRate->saveAll($colleagueList['ColleagueEvalutionRate'])) {
				$this->Session->setFlash('<span></span>'.__('You have evaluated '.$instructor.' Thank you! Please fill the next instructor evaluation.'),'default',array('class'=>'success-box success-message'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The  evalution rate could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}

		$instructorEvalutionQuestionsObjective = $this->ColleagueEvalutionRate->InstructorEvalutionQuestion->find('all',array('conditions'=>array(
			'InstructorEvalutionQuestion.type'=>'objective',
			'InstructorEvalutionQuestion.for'=>'dep-head',
			'InstructorEvalutionQuestion.active'=>1
			),'fields'=>array('InstructorEvalutionQuestion.id',
			'InstructorEvalutionQuestion.question',
			'InstructorEvalutionQuestion.question_amharic',
			
			)));
		$this->set(compact('colleagueLists','instructorEvalutionQuestionsObjective'));
		$this->render('colleague_evaluate_instructor');
	}
}
