<?php
class SenateListsController extends AppController {

     public $name = 'SenateLists';
     public $menuOptions = array(
		'parent' => 'graduation',
		'exclude' => array('search', 'delete'),
		'weight'=>1,
		'alias' => array(
			'index' => 'View Senate List',
			'add' => 'Prepare Senate List'
		)
	);
	public $components =array('EthiopicDateTime','AcademicYear');
    public $paginate=array();
	public function beforeFilter() {
	 parent::beforeFilter();
	 $this->Auth->allow('search');
	}
	 /*
	 *Generic search for returned items
	 */
	 public function search() {
		// the page we will redirect to
		$url['action'] = 'index';
		
		// build a URL will all the search elements in it
		// the resulting URL will be 
		// domain.com/returned_items/index/Search.keywords:mykeyword/Search.tag_id:3
		//debug($this->request->data);
		foreach ($this->request->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				if(is_array($vv)) {
					foreach($vv as $kkk => $vvv)
						$url[$k.'.'.$kk.'.'.$kkk] = $vvv;
				}
				else
					$url[$k.'.'.$kk]=$vv;
			} 
		}
		// redirect the user to the url
		return $this->redirect($url, null, true);
	}

	public function index() {	
	//$this->paginate = array('limit' => 100);
	$this->paginate = array('contain'=>array(
	'Student' => array('Department', 'Curriculum', 'ProgramType','CourseDrop'=>array('CourseRegistration'=>array('PublishedCourse'=>array('Course'))),'CourseAdd'=>array('PublishedCourse'=>array('Course'=>array('GradeType'))),'CourseRegistration'=>array('PublishedCourse'=>array('Course'=>array('GradeType'))), 'Program', 'StudentExamStatus' => array('order' => array('StudentExamStatus.created DESC')),
	'order'=>array('Student.full_name ASC')
	),
	));	
	  // Sort 
		if (isset($this->request->data['SenateList']['sort_by']) && !empty($this->request->data['SenateList']['sort_by'])) {
		   if($this->request->data['SenateList']['sort_by']=="full_name ASC" || $this->request->data['SenateList']['sort_by']=="full_name DESC" ){
			$this->paginate['contain']['Student']['order'] = $this->request->data['SenateList']['sort_by'];
			} else {
			  $this->paginate['order'] = $this->request->data['SenateList']['sort_by'];
			}
		}
		
        if((isset($this->request->data['SenateList']) && isset($this->request->data['viewPDF']))) {
	  $search_session = $this->Session->read('search_data');
           $this->request->data['SenateList'] = $search_session;
	    }
        if(isset($this->passedArgs)) {
	      if(isset($this->passedArgs['page'])) {	
		 	 $this->__init_search(); 
                         $this->request->data['SenateList']['page']=$this->passedArgs['page'];
                     $this->__init_search(); 
             } 
	     } 

        if((isset($this->request->data['SenateList']) && isset($this->request->data['listStudentsForSenateList']))) {
	        $this->__init_search();
	    }
             
        // filter by department or college
		if (isset($this->request->data['SenateList']['limit']) && !empty($this->request->data['SenateList']['limit'])) {
			$this->paginate['limit'] = $this->request->data['SenateList']['limit'];
			$this->paginate['maxLimit'] = $this->request->data['SenateList']['limit'];

			
		}


		
		// filter by department or college
		if (isset($this->request->data['SenateList']['department_id']) && !empty($this->request->data['SenateList']['department_id'])) {
			$department_id = $this->request->data['SenateList']['department_id'];
			$college_id = explode('~', $department_id);
			if(count($college_id) > 1)
				$this->paginate['conditions'][]['Student.college_id'] = $college_id[1];
			else
				$this->paginate['conditions'][]['Student.department_id'] = $department_id;
		}

		// filter by program 

		if (isset($this->request->data['SenateList']['program_id']) && !empty($this->request->data['SenateList']['program_id'])) {
			$this->paginate['conditions'][]['Student.program_id'] = $this->request->data['SenateList']['program_id'];
		}

		// filter by program type
		if (isset($this->request->data['SenateList']['program_type_id']) && !empty($this->request->data['SenateList']['program_type_id'])) {
			$this->paginate['conditions'][]['Student.program_type_id'] = $this->request->data['SenateList']['program_type_id'];
		}

		// filter by minute number

		if (isset($this->request->data['SenateList.minute_number']) && !empty($this->request->data['SenateList']['minute_number'])) {
		        unset($this->paginate);
			$this->paginate['conditions'][]['SenateList.minute_number'] = $this->request->data['SenateList']['minute_number'];
		}
			// filter by period
			if(isset($this->request->data['SenateList']['senate_date_from']['year'])) {
			$this->paginate['conditions'][] = array('SenateList.approved_date >= \''.$this->request->data['SenateList']['senate_date_from']['year'].'-'.$this->request->data['SenateList']['senate_date_from']['month'].'-'.$this->request->data['SenateList']['senate_date_from']['day'].'\'');

			$this->paginate['conditions'][] = array('SenateList.approved_date <= \''.$this->request->data['SenateList']['senate_date_to']['year'].'-'.$this->request->data['SenateList']['senate_date_to']['month'].'-'.$this->request->data['SenateList']['senate_date_to']['day'].'\'');	
			}
         if (isset($this->request->data['SenateList']['page']) && !empty($this->request->data['SenateList']['page'])) {
			$this->paginate['page'] = $this->request->data['SenateList']['page'];
		}              
        $this->Paginator->settings=$this->paginate;
	    //debug($this->Paginator->settings);
	
       if(isset($this->Paginator->settings['conditions'])) {
		      $students_for_senate_list=$senateLists= 
$this->Paginator->paginate('SenateList');  
		}
		else {
			$senateLists= array();
		}

	   if (empty($senateLists) && isset($this->request->data) && !empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('There is no student in the senate list based on the given criteria.'),'default',array('class'=>'info-box info-message'));

		}
        $excludeMajor=$this->request->data['SenateList']['exclude_major'];
	    $programs = $this->SenateList->Student->Program->find('list');

		$program_types = $this->SenateList->Student->ProgramType->find('list');

		$departments = $this->SenateList->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);

		$programs = array(0 => 'All Programs') + $programs;

		$program_types = array(0 => 'All Program Types') + $program_types;

		$departments = array(0 => 'All University Students') + $departments;

		$default_department_id = null;

		$default_program_id = null;

		$default_program_type_id = null;

	    if((!empty($this->request->data['SenateList']) && !empty($this->request->data['viewPDF']))) {

					$student_ids = array();
					$certificate_template =array();
					$students_for_senate_list_pdf=array();
					$count=1;
					foreach($students_for_senate_list as $k=>$v) {
					$v['Student']['ExemptedCredit']=$this->SenateList->Student->CourseExemption->getStudentCourseExemptionCredit($v['Student']['id']);
					$v['Student']['TransferedCredit']=$this->SenateList->Student->DepartmentTransfer->getTransferedCourseCredit($v['Student']['id']);
					$v['Student']['CourseDroppedCredit']=$this->SenateList->Student->CourseDrop->droppedCreditSum($v['Student']['id']);
					if($v['Student']['program_id']==2){
					$v['Student']['ThesisResult']=ClassRegistry::init('ExamGrade')->getApprovedThesisGrade($v['Student']['id']);

					}

					/*
					if(ClassRegistry::init('ExamGrade')->iSStudentHasF($v['Student']['id'])){
					$v['Student']['PointDeducation']=ClassRegistry::init('ExamGrade')->getTotalCreditPointDeduction($v['Student']['id']);
					}
					*/
					//$v['Student']['PointDeducation']=ClassRegistry::init('ExamGrade')->getTotalCreditPointDeduction($v['Student']['id']);
					$students_for_senate_list_pdf[$v['Student']['Program']['name'].'~'.$v['Student']['ProgramType']['name'].'~'.$v['Student']['Department']['name'].'~'.$v['Student']['Curriculum']['name'].'~'.$v['Student']['Curriculum']['minimum_credit_points'].'~'.$v['Student']['Curriculum']['amharic_degree_nomenclature'].'~'.$v['Student']['Curriculum']['specialization_amharic_degree_nomenclature'].'~'.$v['Student']['Curriculum']['english_degree_nomenclature'].'~'.$v['Student']['Curriculum']['specialization_english_degree_nomenclature'].'~'.$v['Student']['Curriculum']['type_credit']][]=$v;
					//debug($students_for_senate_list_pdf);
					}

					$defaultacademicyear=$this->AcademicYear->current_academicyear();
					$ethiopicYear = $e_year = $this->EthiopicDateTime->GetEthiopicYear(date('j'), date('n'), date('Y'));

					$this->set(compact('students_for_senate_list_pdf','defaultacademicyear','excludeMajor','ethiopicYear'));

					$this->response->type('application/pdf');
					$this->layout = '/pdf/default';
					$this->render('senate_list_masspage_pdf');


	   } 

	     $this->set(compact('programs', 'program_types', 'departments', 'students_in_senate_list', 'default_department_id', 'default_program_id', 'default_program_type_id', 'senateLists','excludeMajor'));

	}
       
	function __init_search() {
        // We create a search_data session variable when we fill any criteria  in the search form.
		if(!empty($this->request->data['SenateList'])) {
         
/*
         $readPage=$this->Session->read('search_data');
		if(isset($readPage['SenateList']['page'])) {
		  $this->request->data['SenateList']['page']=$readPage['SenateList']['page'];
		}
	*/
         $search_session = $this->request->data['SenateList'];
		       // Session variable 'search_data'
		 $this->Session->write('search_data', $search_session); 
		} else {

	          $search_session = $this->Session->read('search_data');

		  $this->request->data['SenateList'] = $search_session;
		}
       }
    

	/***
	1. Display list of department, program, program type (optional)
	2. After "List Students" button, all students but note in the senate list and graduation list 
		who take all courses will be displayed 
		(non eligible students will be displayed in red with justification '+')
	3. A check-box to include students in the senate list
	***/
	function add($department_id = null, $program_id = null, $program_type_id = null) {
		$programs = $this->SenateList->Student->Program->find('list');
		$program_types = $this->SenateList->Student->ProgramType->find('list');
		$departments = $this->SenateList->Student->Department->allDepartmentsByCollege2(0, 
		$this->department_ids, $this->college_ids);
		$department_combo_id = null;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		//When any of the button is clicked (List students or Add to Senate List)
		
		if(!empty($this->request->data) && !empty($this->request->data['listStudentsForSenateList'])) {
			//debug($this->request->data);
			$students_for_senate_list = $this->SenateList->getListOfStudentsForSenateList($this->request->data['SenateList']['program_id'], $this->request->data['SenateList']['program_type_id'], $this->request->data['SenateList']['department_id']);
			$default_department_id = $this->request->data['SenateList']['department_id'];
			$default_program_id = $this->request->data['SenateList']['program_id'];
			$default_program_type_id = $this->request->data['SenateList']['program_type_id'];
		}
		else if(!empty($department_id) && !empty($program_id)) {
			$students_for_senate_list = $this->SenateList->getListOfStudentsForSenateList($program_id, $program_type_id, $department_id);
			$default_department_id = $department_id;
			$default_program_id = $program_id;
			$default_program_type_id = $program_type_id;
		}
	  
		//debug($students_for_senate_list);
		if(!empty($this->request->data) && !empty($this->request->data['addStudentToSenateList'])) {
			//debug($this->request->data);
			if(trim($this->request->data['SenateList']['minute_number']) == "") {
				$this->Session->setFlash('<span></span>'.__('Please enter minute number.'), 'default',array('class'=>'error-box error-message'));
			}
			else {
				$senate_list = array();
				foreach($this->request->data['Student'] as $key => $student) {
					if($student['include_senate'] == 1) {
						$sl_count = $this->SenateList->find('count', array('conditions' => array('SenateList.student_id' => $student['id'])));
						if($sl_count == 0) {
							$sl_index = count($senate_list);
							$senate_list[$sl_index]['student_id'] = $student['id'];
							$senate_list[$sl_index]['minute_number'] = trim($this->request->data['SenateList']['minute_number']);
							$senate_list[$sl_index]['approved_date'] = $this->request->data['SenateList']['approved_date']['year'].'-'.$this->request->data['SenateList']['approved_date']['month'].'-'.$this->request->data['SenateList']['approved_date']['day'];
						}
					}
				}
				if(empty($senate_list)) {
					$this->Session->setFlash('<span></span>'.__('You are required to select at least one student to be included in the senate list.'), 'default',array('class'=>'error-box error-message'));
				}
				else {
					if($this->SenateList->saveAll($senate_list, array('validate'=>false))) {
						$this->Session->setFlash('<span></span>'.__(count($senate_list).' students are included in the senate list. After senate approval, you can add those students to the graduation list.'), 'default',array('class'=>'success-box success-message'));
						return $this->redirect(array('action' => 'add', $this->request->data['SenateList']['department_id'], $this->request->data['SenateList']['program_id'], $this->request->data['SenateList']['program_type_id']));
					}
					else {
						$this->Session->setFlash('<span></span>'.__('The system unable to include the selected students in the senate list. Please try again.'), 'default',array('class'=>'error-box error-message'));
					}
				}
			}
		}
              
	      if(isset($this->request->data['SenateList']) && isset($this->request->data['viewPDF'])) {
		//debug($this->request->data);
	       $student_ids = array();
	       $certificate_template =array();
	   
	       foreach($this->request->data['Student'] as $key => $student) 
               {
		   if($student['include_senate'] == 1) {
			$student_ids[] = $student['id'];
		   }
	       }
	       $students_for_senate_list = $this->SenateList->getListOfStudentsForSenateListGivenId($student_ids);
					
				
		$defaultacademicyear=$this->AcademicYear->current_academicyear();
		$ethiopicYear = $e_year = $this->EthiopicDateTime->GetEthiopicYear(date('j'), date('n'), date('Y'));
		$this->set(compact('students_for_senate_list','defaultacademicyear','ethiopicYear'));
		$this->layout='pdf';
		$this->render('senate_list_pdf');
		
		} 
		$this->set(compact('programs', 'program_types', 'departments', 'department_combo_id', 'students_for_senate_list', 'default_department_id', 'default_program_id', 'default_program_type_id'));
	}

	function delete($id = null) {
		$this->SenateList->id = $id;
		if (!$id || !$this->SenateList->exists($id)) {
			$this->Session->setFlash('<span></span>'.__('Invalid senate list'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$senate_detail = $this->SenateList->find('first', 
			array(
				'conditions' =>
				array(
					'SenateList.id' => $id
				),
				'contain' =>
				array(
					'Student'
				)
			)
		);
		if(!in_array($senate_detail['Student']['department_id'], $this->department_ids)) {
			$this->Session->setFlash('<span></span>'.__('You do not have privilege to manage the selected student records.'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$graduate_count = $this->SenateList->Student->GraduateList->find('count',
			array(
				'conditions' =>
				array(
					'GraduateList.student_id' => $senate_detail['Student']['id']
				)
			)
		);
		if($graduate_count > 0) {
			$this->Session->setFlash('<span></span>'.__('<u>'.$senate_detail['Student']['full_name'].'</u> is on graduate list and can not be deleted.'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		else {
			if ($this->SenateList->delete($id)) {
				$this->Session->setFlash('<span></span>'.__('<u>'.$senate_detail['Student']['full_name'].'</u> is successfully removed from the senate list'), 'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action'=>'index'));
			}
		}
		$this->Session->setFlash('<span></span>'.__('<u>'.$senate_detail['Student']['full_name'].'</u> is not removed from the senate list. Please try again.'), 'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	
}
?>
