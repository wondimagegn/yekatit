<?php
//App::import('Vendor','nusoap');
App::import('Vendor', 'PhpExcelReader/Excel/reader');
class StudentsController extends AppController {
     
    public $name = 'Students';
    public $conn;
    	public $config=array();
    public $helpers = array('DatePicker','Media.Media','Xls');
    public $menuOptions = array(
	              'parent' => 'placement',
                  'exclude' => array('add','search','name_change','correct_name','profile_not_build_list','get_course_registered_and_add'),
                  'alias' => array(
                    'index'=>'View Admitted Students',
                    'department_issue_password' => 'Issue Password',
                     'name_list'=>'Name Correction',
                     'id_card_print'=>'Print Student ID Card'
                  )                
    );
    public $paginate = array();
    public $components =array('AcademicYear','EthiopicDateTime');
    public function beforeFilter() {
       parent::beforeFilter();
       $this->Auth->allow('ajax_get_department','change','get_regions','get_cities',
'ajax_update','ajax_check_ecardnumber','change','get_course_registered_and_add','auto_yearlevel_update','student_lists',
'search','get_modal_box','id_card_print',
'update_koha_db','print_record','update_lms_db');    
    }
    public function beforeRender() {
        parent::beforeRender();
	// Ensure that encrypted passwords are not sent back to the user
        unset($this->request->data['User']['password']);
        $acyear_array_data = $this->AcademicYear->acyear_array();
        //To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        $acYearMinuSeparated = $this->AcademicYear->acYearMinuSeparated();
        //To diplay current academic year as default in drop down list
	   $defaultacademicyearMinusSeparted=str_replace('/','-',$defaultacademicyear);
	   if(!empty($this->program_type_id)){
	   		   $program_types=$programTypes =  $this->Student->ProgramType->find('list',array('conditions'=>
	   		   	array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   		   $program_types=$programTypes =  $this->Student->ProgramType->find('list');
	   }
	   if(!empty($this->program_id)){
	   		 $programs =  $this->Student->Program->find('list',array('conditions'=>
	   		   	array('Program.id'=>$this->program_id)));
	   } else{
	   		 $programs =  $this->Student->Program->find('list');
	   }
	   $this->set(compact('acyear_array_data','defaultacademicyear','acYearMinuSeparated','program_types','programTypes','defaultacademicyearMinusSeparted','programs'));
	}
    function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['AcceptedStudent'])){
               
                    $search_session = $this->request->data['AcceptedStudent'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data');
        	$this->request->data['AcceptedStudent'] = $search_session;
        } 

    }
    
     function __init_search_student() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Student'])){
                 
                    $search_session = $this->request->data['Student'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_student', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data_student');
        	$this->request->data['Student'] = $search_session;
        } 

         if(!empty($this->request->data['Display'])){
                $this->Session->delete('display_field_student'); 
                    $display_session = $this->request->data['Display'];
                   // Session variable 'search_data'
                    $this->Session->write('display_field_student', $display_session);
                
        } else {
           /*
        	$display_session = $this->Session->read('display_field_student');
        	$this->request->data['Display'] = $display_session;
        	*/
        } 



     }
    
     /*
	 *Generic search for returned items
	 */
	 function search() {
	     $this->__init_search_student();
		// the page we will redirect to
		$url['action'] = 'index';
		
		// build a URL will all the search elements in it
		// the resulting URL will be 
		// domain.com/returned_items/index/Search.keywords:mykeyword/Search.tag_id:3
		unset($this->request->data['Display']);
		
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
		$department_id = null;
		$college_id =null;
		if (!empty($this->department_ids)) {
				if(!empty($this->passedArgs['Search.department_id'])){
				 $department_id =$this->passedArgs['Search.department_id'];
				 } else {
				  $department_id = $this->department_ids;
				 }
		} else if(!empty($this->college_ids)) {
				if(!empty($this->passedArgs['Search.department_id'])){
				 $department_id = $this->passedArgs['Search.department_id'];
				 } else {
				   $college_id = $this->college_ids;
				 }
		
		} else if (!empty($this->department_id) && 
	$this->role_id == ROLE_DEPARTMENT) { 
			 $department_id = $this->department_id;
		} else if(!empty($this->college_id) && $this->role_id == ROLE_COLLEGE) {
			$college_id = $this->college_id;
		} else if ($this->role_id == ROLE_STUDENT) {
			if(!empty($this->department_id)){
				$department_id = $this->department_id;
			}elseif(!empty($this->college_id)){
			 $college_id = $this->department_id;
			}
		}

        
	  if($this->role_id == ROLE_STUDENT)
      {
           $this->paginate['conditions'][]['Student.id'] = $this->student_id;
      }

		 // filter by admission year  
	  if (isset($this->passedArgs['Search.academicyear']) 
	  	&& !empty($this->passedArgs)) {
	  	$academic_year = str_replace('-','/',$this->passedArgs['Search.academicyear']);
	     if(!empty($academic_year)){
			$admissionYear=$this->AcademicYear->get_academicYearBegainingDate($academic_year);
			debug($admissionYear);
			$nextAc=$this->Student->StudentExamStatus->getNextSemster(
				$academic_year);

			$nextAdmissionYear=$this->AcademicYear->get_academicYearBegainingDate($nextAc['academic_year']);
			debug($nextAdmissionYear);			
			if(!empty($academic_year)) {
				/*
				$this->paginate['conditions'][]="Student.admissionyear >= '$admissionYear' 
and Student.admissionyear <='$nextAdmissionYear'";
				 */
				  $this->paginate['conditions'][]['Student.academicyear']=$academic_year;
			} 
			$this->request->data['Search']['academicyear'] =  $this->passedArgs['Search.academicyear'];
	     }
	   }
		
	// filter by department or college	
	  if (isset($this->passedArgs['Search.department_id']) && !empty($this->passedArgs['Search.department_id'])) {
			$ex_dep_id=explode('~',$this->passedArgs['Search.department_id']);
		   if(count($ex_dep_id)>1){
			   $department_id =$ex_dep_id[1]; 
			   $conditions = array(
	'Student.college_id'=>$department_id,
	'Student.department_id is null');    
			   $this->paginate['conditions'][]=$conditions;
			} else{
			   $this->paginate['conditions'][]['Student.department_id'] = $department_id;
			}
		    $this->request->data['Search']['department_id'] = $this->passedArgs['Search.department_id'];
		 } else if (!empty($department_id)) {
			 $this->paginate['conditions'][]['Student.department_id'] = $department_id;
		 } else if (!empty($college_id) && ($this->role_id == ROLE_REGISTRAR || 
	ROLE_REGISTRAR == $this->Session->read('Auth.User')['Role']['parent_id'])) {

			 $this->paginate['conditions'][]['Student.college_id'] = $college_id;
		 }

       // filter by program 
	  if(isset($this->passedArgs['Search.program_id'])) { 
	        $program_id=$this->passedArgs['Search.program_id'];
		    if(!empty($program_id)) {
	            $this->paginate['conditions'][]['Student.program_id'] = $program_id;
	        } 
		    $this->request->data['Search']['program_id'] = $this->passedArgs['Search.program_id'];
	   }  
	   // filter by program type
	   if (isset($this->passedArgs['Search.program_type_id'])) { 
	            $program_type_id=$this->passedArgs['Search.program_type_id'];
				   if(!empty($program_type_id)) {
			            $this->paginate['conditions'][]['Student.program_type_id'] = $program_type_id;
			       } 
				$this->request->data['Search']['program_type_id'] = $this->passedArgs['Search.program_type_id'];
	   }
	  // filter by name
	  if (isset($this->passedArgs['Search.name'])) { 
	            $name=$this->passedArgs['Search.name'];
		    if(!empty($name)){
	            $this->paginate['conditions'][]['Student.first_name like'] = '%'.$name.'%'; 
		    }
		    $this->request->data['Search']['name'] = $this->passedArgs['Search.name'];
	  }
	  
	  // filter by name
	  if (isset($this->passedArgs['Search.gender'])) { 
	            $gender=$this->passedArgs['Search.gender'];
		    if(!empty($gender)){
	            $this->paginate['conditions'][]['Student.gender like'] =$gender.'%'; 
		    }
		    $this->request->data['Search']['gender'] = $this->passedArgs['Search.gender'];
	  }
	  
      if(!empty($this->onlyPre)) {
	        $conditions = array(
			"Student.department_id is null");
            $this->paginate['conditions'][]=$conditions;
	  } 
	  
	  if(isset($this->passedArgs['Search.limit'])){
		   $this->paginate['limit']=$this->passedArgs['Search.limit'];
		   $this->paginate['maxLimit']=$this->passedArgs['Search.limit'];
		   $this->request->data['Search']['limit']=$this->passedArgs['Search.limit'];
	  }
	  $this->Paginator->settings=$this->paginate;
	  debug($this->Paginator->settings);
	  if(!isset($this->Paginator->settings['conditions'])) {
			if ($this->role_id == ROLE_DEPARTMENT) {
			$conditions = array(
			"Student.department_id"=> $this->department_id,
			);
			} else if ($this->role_id == ROLE_COLLEGE) {
			$conditions = array(
			"Student.college_id "=>$this->college_id
			//"AcceptedStudent.department_id is null"
			);
			} else if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR== $this->Session->read('Auth.User')['Role']['parent_id']){
						
			 if(!is_array($department_id)) {
		        $ex_dep_id=explode('~',$department_id);
			 } else {
				$ex_dep_id=array();
			 }
			 if(count($ex_dep_id)>1){
			    $department_id =$ex_dep_id[1];  
			    $conditions = array(
			    	"Student.college_id"=>$department_id,
			    	"Student.program_type_id"=>$program_type_id,
			    	"Student.program_id"=>$program_id,
			    	'Student.department_id is null');
				
			  } else {
				$conditions = array(
		"Student.department_id"=>$department_id,
		"Student.program_type_id"=>$program_type_id,
			    	"Student.program_id"=>$program_id
			);
			   }
				if (!empty($department_id)) {
					$conditions = array("Student.department_id"=>$department_id,
						"Student.program_type_id"=>$program_type_id,
			    	"Student.program_id"=>$program_id
					);       
				} else if (!empty($this->college_ids)) {
				$conditions = array(
				"Student.college_id"=>$this->college_ids,
				"Student.program_type_id"=>$program_type_id,
			    	"Student.program_id"=>$program_id
				); 
				}
	      }
	
			if (isset($conditions)) {
			  $this->Paginator->settings['conditions']=$conditions;
			   $students=$this->Paginator->paginate('Student'); 
			}
		    $from=date("Y-m-d",strtotime("-60 day"));
		    $to=date("Y-m-d");
		    $this->set(compact('from','to'));
		} else {
			if(!empty($this->department_ids)){
				 $this->paginate['conditions'][]['Student.department_id'] = $this->department_ids;
			}
			if(!empty($this->college_ids)){
				 $this->paginate['conditions'][]['Student.department_id'] = $this->college_ids;
			}
			if(!empty($this->program_type_id)){
				 $this->paginate['conditions'][]['Student.program_type_id'] = $this->program_type_id;
			}
			if(!empty($this->program_id)){
				 $this->paginate['conditions'][]['Student.program_id'] = $this->program_id;
			}
			$this->Paginator->settings=$this->paginate;
		   	$students = $this->Paginator->paginate('Student');
	    }
	    
	    if (empty($students) && isset($this->passedArgs) && !empty($this->passedArgs)) {
	       $this->Session->setFlash('<span></span>'.__('No result is found  in the selected criteria.'),'default',array('class'=>'info-box info-message'));
	    }

		if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR== $this->Session->read('Auth.User')['Role']['parent_id']) {
		if(!empty($this->department_ids)) {
		$departments=$this->Student->Department->allDepartmentInCollegeIncludingPre($this->department_ids,null); 
		} else if (!empty($this->college_ids)) {
		$departments=$this->Student->Department->allDepartmentInCollegeIncludingPre(null, $this->college_ids,$this->onlyPre); 
		}
		} else if(!empty($this->department_id) || !empty($this->college_id)) {
		if ($this->role_id == ROLE_DEPARTMENT) {

		    $departments= $this->Student->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));
		 } else if ($this->role_id == ROLE_COLLEGE) {
		  $departments=$this->Student->Department->allDepartmentInCollegeIncludingPre(null, $this->college_id,1); 
		}       
		} 
	   
	    if(!empty($students)){

            $this->Session->delete('students');
        	$this->Session->write('students', 
        	$students);
	    }
	    $this->set(compact('colleges','departments','programs','programTypes'));	
	    
		$this->set(compact('students'));
	
	}
	public  function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid student'));
			return $this->redirect(array('action' => 'index'));
		}
		/*
		$studentss=$this->Student->find('all',
		array('fields'=>array('Student.first_name')));
		*/
		$student=$this->Student->find('first',array('conditions'=>array('Student.id'=>$id),
		'contain'=>array('User'=>array('id','username'),'Program'=>array('id','name'),
		'ProgramType'=>array('id','name'),'Country'=>array('id','name','code'),
		'City'=>array('id','name'),'Region'=>array('id','name','short'),
		'Department'=>array('id','name'),
		'College'=>array('id','name','shortname'),'Attachment','HighSchoolEducationBackground',
		'HigherEducationBackground','EslceResult','EheeceResult','Section','Contact'=>array('Country','Region','City'))));
		$regions=$this->Student->Region->find('list');
		$this->set('student',$student);
		$this->set(compact('regions'));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->request->data['User']['role_id']=3;
			
			if ($this->Student->saveAll($this->request->data,array('validate'=>'first'))) {
				$this->Session->setFlash(__('The student has been saved'),'flash');
				
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be saved. Please, try again.'));
			}
		}

		
		$contacts = $this->Student->Contact->find('list');
		$departments = $this->Student->Department->find('list');
		$countries=$this->Student->Country->find('list');
		$cities=$this->Student->Region->City->find('list');
		$colleges = $this->Student->College->find('list');
		//$users = $this->Student->User->find('list');
		$programs = $this->Student->Program->find('list');
		$programTypes =$this->Student->ProgramType->find('list');
		$this->set(compact( 'contacts','users','departments','regions','countries',
		'cities','colleges','programs','programTypes'));

	}
	
       
	public function edit($id = null) {
		
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid student'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$check_elegibility_to_edit=0;
		if (!empty($this->college_ids)) { 
		    $check_elegibility_to_edit=$this->Student->find (
		    'count',array('conditions'=>array('Student.college_id'=>$this->college_ids,
		    'Student.id'=>$id)));
		   
		} else if ($this->department_ids) {
		     $check_elegibility_to_edit=$this->Student->find (
		    'count',array('conditions'=>array('Student.department_id'=>$this->department_ids,
		    'Student.id'=>$id)));
		   
		    
		}
		   
		   
		if ($check_elegibility_to_edit==0) {
		         $this->Session->setFlash(__('<span></span> You are not elgibile to edit the student profile. This happens when you are trying to edit students profile which you are not assigned to edit.', true),'default',array('class'=>'error-box error-message'));
		         $this->redirect(array('action'=>'index'));
						       
		} 
		if (!empty($this->request->data)) {
		     // Higher education information won't be present in many cases, do not
                            // store it if nothing is entered.
                           
                            if (isset($this->request->data['HigherEducationBackground'])) {
                                
                                foreach ($this->request->data['HigherEducationBackground'] as $k => $v) {
                                   if (empty($v['name']) && empty($v['diploma_awarded']) && empty($v['name'])
                                    && empty($v['cgpa_at_graduation']) && empty($v['city']) ) {
                                        unset($this->request->data['HigherEducationBackground'][$k]);
                                    }
                                }
                               
                            }
                            
                             // High school information won't be present, do not
                            // store it if nothing is entered.
                            if ($this->request->data['Student']['program_id']!=PROGRAM_UNDEGRADUATE 
                            || $this->request->data['Student']['program_type_id']!=PROGRAM_TYPE_REGULAR) {
                                if (isset($this->request->data['HighSchoolEducationBackground'])) {
                                    $save_highschool_education = false;
                                    foreach ($this->request->data['HighSchoolEducationBackground'] as $k => $v) {
                                        if (!empty($v['name']) || !empty($v['region_id']) ||
                                        !empty($v['town']) || !empty($v['zone'])
                                        || !empty($v['school_level'])) {
                                            $save_highschool_education = true;
                                        }
                                    }
                                    if (!$save_highschool_education) {
                                        unset($this->request->data['HighSchoolEducationBackground']);
                                    }
                                }
                            }
            unset($this->request->data['User']);
             $this->Student->HighSchoolEducationBackground->deleteHighSchoolEducationBackgroundList($id,$this->request->data);
             $this->Student->HigherEducationBackground->deleteHigherEducationList($id,$this->request->data);
             $this->Student->EslceResult->deleteEslceResultList($id,$this->request->data);
             $this->Student->EheeceResult->deleteEheeceResultList($id,$this->request->data);
		debug($this->request->data);
             $this->request->data=$this->Student->unset_empty($this->request->data);
             $check_elegibility_to_edit=0;

              // unset($this->request->data['Student']['first_name']);           
               // TODO dont allow multiple national exam taken 
              //   debug($this->request->data);        
			    if ($this->Student->saveAll($this->request->data,array('validate'=>'first'))) {
				    $this->Session->setFlash('<span></span>'.__('The student profile has been updated'),
				    'default',array('class'=>'success-box success-message'));
				    $this->redirect(array('action' => 'index'));
			    } else {
				    $this->Session->setFlash('<span></span>'.__('The student could not be saved. Please, try again.'),
				    'default',array('class'=>'error-box error-message'));
			       //  debug($this->Student->invalidFields());
				 // debug($this->request->data);
			    }
                 
           
			// $this->request->data = $this->Student->read(null, $id);
			$data = $this->Student->find('first',array('conditions'=>array('Student.id'=>$id),
			'contain'=>array('Contact','AcceptedStudent','EslceResult','EheeceResult',
			'Attachment','Family','Employment',
			'HigherEducationBackground',
			'HighSchoolEducationBackground',
			'User')));
			debug($data);
			$this->request->data['Student']['studentnumber']=$data['Student']['studentnumber'];
			$this->request->data['Student']['program_id']=$data['Student']['program_id'];
			$this->request->data['Student']['program_type_id']=$data['Student']['program_type_id'];
			$this->request->data['Student']['department_id']=$data['Student']['department_id'];
			$this->request->data['Student']['college_id']=$data['Student']['college_id'];
			$this->request->data['Student']['admissionyear']=$data['Student']['admissionyear'];
			
		}
		if (empty($this->request->data)) {
			
			$this->request->data = $this->Student->find('first',array('conditions'=>array('Student.id'=>$id),
			'contain'=>array('Contact','AcceptedStudent','Family','Employment','EslceResult','EheeceResult',
			'Attachment','HigherEducationBackground','HighSchoolEducationBackground','User')));
		  debug($this->request->data);
		}
		
		$regions=$this->Student->Region->find('list');
		$countries=$this->Student->Country->find('list');
		$cities = $this->Student->City->find('list');
		$colleges = $this->Student->College->find('list');
		$departments = $this->Student->Department->find('list');
		
		//$contacts = $this->Student->Contact->find('list');
		//$users = $this->Student->User->find('list');
		$programs = $this->Student->Program->find('list');
		$programTypes =$this->Student->ProgramType->find('list');
		$this->set(compact('contacts','colleges','cities','departments','programs','programTypes','regions','countries'));
	}
   
    /**
    * Function which will allows the registrar to admit all students then upda
    */
    public function admit_all() {
          
          if(!empty($this->request->data) && !empty($this->request->data['admit']))
         {
                $atleast_select_one=array_sum($this->request->data['AcceptedStudent']['approve']);
         
                if ($atleast_select_one>0) {
					
                       unset($this->request->data['Student']['SelectAll']);
                       $admittedStudentsLists=array();
					   $selectedAdmittedCount=0;
                       foreach($this->request->data['AcceptedStudent']['approve'] as $id=>$selected){
                         if ($selected==1) {
                               $selected_students[]=$id;
	                           $basicData=$this->Student->AcceptedStudent->find('first',
array('conditions'=>array('AcceptedStudent.id'=>$id)));
							   if(!empty($basicData)) {
                                 $admittedStudentsLists['Student'][$selectedAdmittedCount]['first_name']=$basicData['AcceptedStudent']['first_name'];
							 $admittedStudentsLists['Student'][$selectedAdmittedCount]['middle_name']=$basicData['AcceptedStudent']['middle_name'];
 $admittedStudentsLists['Student'][$selectedAdmittedCount]['last_name']=$basicData['AcceptedStudent']['last_name'];

$admittedStudentsLists['Student'][$selectedAdmittedCount]['last_name']=$basicData['AcceptedStudent']['last_name'];
$admittedStudentsLists['Student'][$selectedAdmittedCount]['user_id']=$basicData['AcceptedStudent']['user_id'];
$admittedStudentsLists['Student'][$selectedAdmittedCount]['accepted_student_id']=$basicData['AcceptedStudent']['id'];
                  $admittedStudentsLists['Student'][$selectedAdmittedCount]['gender']=$basicData['AcceptedStudent']['sex'];
 $admittedStudentsLists['Student'][$selectedAdmittedCount]['studentnumber']=$basicData['AcceptedStudent']['studentnumber'];
                $admittedStudentsLists['Student'][$selectedAdmittedCount]['region_id']=$basicData['AcceptedStudent']['region_id'];
                $admittedStudentsLists['Student'][$selectedAdmittedCount]['program_id']=$basicData['AcceptedStudent']['program_id'];
 $admittedStudentsLists['Student'][$selectedAdmittedCount]['college_id']=$basicData['AcceptedStudent']['college_id'];
 $admittedStudentsLists['Student'][$selectedAdmittedCount]['department_id']=$basicData['AcceptedStudent']['department_id'];
                  $admittedStudentsLists['Student'][$selectedAdmittedCount]['program_type_id']=$basicData['AcceptedStudent']['program_type_id'];
                
                $admittedStudentsLists['Student'][$selectedAdmittedCount]['curriculum_id']=$basicData['AcceptedStudent']['curriculum_id'];
                
                 $admittedStudentsLists['Student'][$selectedAdmittedCount]['gpa']=$basicData['AcceptedStudent']['gpa'];
                  $admittedStudentsLists['Student'][$selectedAdmittedCount]['moeadmissionnumber']=$basicData['AcceptedStudent']['moeadmissionnumber'];
                   $admittedStudentsLists['Student'][$selectedAdmittedCount]['attended_stream']=$basicData['AcceptedStudent']['attended_stream'];
                
                 $admittedStudentsLists['Student'][$selectedAdmittedCount]['university_attended']=$basicData['AcceptedStudent']['university_attended'];


   $admittedStudentsLists['Student'][$selectedAdmittedCount]['academicyear']=$basicData['AcceptedStudent']['academicyear'];
                 $admittedStudentsLists['Student'][$selectedAdmittedCount]['admissionyear']=$this->AcademicYear->get_academicYearBegainingDate($basicData['AcceptedStudent']['academicyear']);
                 		}
						$selectedAdmittedCount++;
                	 }
                 }
					
                       if ($this->Student->saveAll($admittedStudentsLists['Student'],array('validate'=>'first'))) {
				                    $this->Session->setFlash(__('<span></span>All selected students has been admitted. Dont forget to maintain their records.'),'default',array('class'=>'success-box success-message'));
				                     
				                    $this->redirect(array('action' => 'index'));
				                  
			           } else {
				                    $this->Session->setFlash(__('<span></span>The student could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				                     
			            }
                       
                } else {
                   $this->Session->setFlash('<span></span>'.__('Please select atleast one student to admit.'),'default',array('class'=>'error-box error-message'));
                  $this->request->data['getacceptedstudent']=true;
               
                  $this->request->data['AcceptedStudent']=$this->Session->read('search_data');
                }
          }
          if (!empty($this->request->data) && !empty($this->request->data['getacceptedstudent'])) {
               $this->__init_search();
               if(!empty($this->request->data['AcceptedStudent']['academicyear'])){
			    $conditions=null;
			    $ssacdemicyear = $this->request->data['AcceptedStudent']['academicyear'];
				$pprogram_id=$this->request->data['AcceptedStudent']['program_id'];
				$pprogram_type_id=$this->request->data['AcceptedStudent']['program_type_id'];
                $name=$this->request->data['AcceptedStudent']['name'];
			    $college_ids=array();
			    $department_ids = array();
			    if (!empty($this->college_ids)) {
			        $college_ids=$this->college_ids;
			    } elseif (!empty($this->department_ids)) {
			        $department_ids=$this->department_ids;
			    } 
			    // retrive list of students based on registrar clerk assigned responsibility
			    if (!empty($college_ids)) {
			    
			           if (!empty($this->request->data['AcceptedStudent']['college_id'])) {
			                $conditions = array(
                                "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
                                "AcceptedStudent.first_name LIKE" => "$name%",
								
                                "AcceptedStudent.college_id" =>$this->request->data['AcceptedStudent']['college_id'],
  "AcceptedStudent.program_id" =>$pprogram_id,
 "AcceptedStudent.program_type_id" =>$pprogram_type_id,
                              // "AcceptedStudent.department_id is null OR AcceptedStudent.department_id=0 OR  AcceptedStudent.department_id='' ",
                               "AcceptedStudent.studentnumber is not null ",
"AcceptedStudent.id NOT IN (select accepted_student_id from students where accepted_student_id is not null )",
			                );
			                //Student.id NOT IN (select student_id from graduate_lists)
			               
			           } else {
			               $conditions = array(
                                "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
                                  "AcceptedStudent.first_name LIKE" => "$name%",
                                "AcceptedStudent.college_id" => $college_ids,
                                  "AcceptedStudent.program_id" =>$pprogram_id,
 "AcceptedStudent.program_type_id" =>$pprogram_type_id,
                                "AcceptedStudent.studentnumber is not null ",
                                "AcceptedStudent.id NOT IN (select accepted_student_id from students 
                                where accepted_student_id is not null )"
			                );
			           }
			    } elseif (!empty($department_ids)) {
			           
			           if (!empty($this->request->data['AcceptedStudent']['department_id'])) {
			                $conditions = array(
                                "AcceptedStudent.academicyear"=>$ssacdemicyear,
                               //   "AcceptedStudent.first_name LIKE" => "$name%",
                                "AcceptedStudent.studentnumber IS NOT NULL",
                                "AcceptedStudent.department_id" =>$this->request->data['AcceptedStudent']['department_id'],
 "AcceptedStudent.program_id" =>$pprogram_id,
 "AcceptedStudent.program_type_id" =>$pprogram_type_id,
                                 "AcceptedStudent.id NOT IN (select accepted_student_id from students)",
			                );
                       debug($conditions);
			           } else {
			               $conditions = array(
                                "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
                                 "AcceptedStudent.first_name LIKE" => "$name%",
                                "AcceptedStudent.department_id" =>$department_ids,
                                 "AcceptedStudent.program_id" =>$pprogram_id,
 "AcceptedStudent.program_type_id" =>$pprogram_type_id,
                                "AcceptedStudent.studentnumber is not null ",
                                 "AcceptedStudent.id NOT IN (select accepted_student_id from students 
                                 where accepted_student_id is not null)",
			                );
			           }
			       
			    }
			      //
			     if (!empty($conditions)) {
			           // $this->paginate = array('limit'=>50000);
                       if(isset($this->request->data['AcceptedStudent']['limit'])) {
							$limit=$this->request->data['AcceptedStudent']['limit'];
						} else {
                           $limit=1800;
						}
                       /*
			           $this->paginate = array('limit'=>$limit,'contain'=>array('Student','College','Department','Program','ProgramType','Region','User'));
                  */
                      $this->paginate = array(
 							'limit'=>$limit,
			  			'maxLimit'=>$limit,
                      	);


					
					 $this->paginate['conditions']=$conditions;
					 $this->Paginator->settings=$this->paginate;
                     debug($this->Paginator->settings);
			         $acceptedStudents=$this->Paginator->paginate('AcceptedStudent');
                     debug($acceptedStudents);
			            $this->set('acceptedStudents',$acceptedStudents);
			            if(!empty($acceptedStudents)){
			                $this->set('admitsearch',true);
			            } else {
			               $this->Session->setFlash(__('<span></span>No data is found with your search criteria that needs admission, either all students has been admitted or no student is accepted in the given criteria.'),'default',array('class'=>'info-box info-message'));
				
			            }
			            $admitsearch=true;
			            $this->request->data['getacceptedstudent']=true;
			            
			      } else {
			         $this->Session->setFlash(__('<span></span>You dont have privilage to admit students in the given criteria.'),'default',array('class'=>'error-box error-message'));
				
			      }
			   } else {
			      $this->Session->setFlash(__('<span></span>Please select academic  year'),'default',array('class'=>'error-box error-message'));
			   }
			
			}
         // display the right department and college based on the privilage of registrar users
		 if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR == $this->Session->read('Auth.User')['Role']['parent_id']) {
		        $college_ids=array();
		        $department_ids = array();
		       
		        if (!empty($this->college_ids)) {
		            
		            $college_ids=$this->college_ids;
		             $this->set('colleges',$this->Student->College->find('list',
		            array('conditions'=>array('College.id'=>$college_ids))));
		            $this->set('departments',$this->Student->Department->find('list',
		            array('conditions'=>array('Department.college_id'=>$college_ids))));
		             $this->set('college_level',true);
		        } elseif (!empty($this->department_ids)) {
		            $department_ids=$this->department_ids;
		            $this->set('departments',$this->Student->Department->find('list',
		            array('conditions'=>array('Department.id'=>$department_ids))));
		              $this->set('colleges',$this->Student->College->find('list',
		            array('conditions'=>array('College.id'=>$college_ids))));
		            $this->set('department_level',true);
		        } 
		         //$colleges = $this->Student->College->find('list');
		         $this->set(compact('colleges'));
		    
		   } else {
		     $colleges = $this->Student->College->find('list');
		     $departments = $this->Student->Department->find('list'); 
		     $this->set(compact('colleges','departments'));
		   }
		   $regions=$this->Student->Region->find('list');
		   $countries=$this->Student->Country->find('list');
		   $cities=$this->Student->City->find('list');
		   $programs = $this->Student->Program->find('list');
		 //  $programTypes =$this->Student->ProgramType->find('list');
		   $this->set(compact('programs',
		    'programTypes','regions','countries','cities'));
    }
    function admit($id = null) {
           
            //check the student has already got student number, else redirect
            if($id){
                    $check_elegibility_to_edit=0;
                    if (!empty($this->college_ids)) { 
                    $check_elegibility_to_edit=$this->Student->AcceptedStudent->find (
                    'count',array('conditions'=>array(
                    	'AcceptedStudent.college_id'=>$this->college_ids,
                    	'AcceptedStudent.program_type_id'=>$this->program_type_id,
                    	'AcceptedStudent.program_id'=>$this->program_id,
                    'AcceptedStudent.id'=>$id)));
                    } else if (!empty($this->department_ids)) {
                      $check_elegibility_to_edit=$this->Student->AcceptedStudent->find (
                    'count',array('conditions'=>array('AcceptedStudent.department_id'=>$this->department_ids,
                    	'AcceptedStudent.program_type_id'=>$this->program_type_id,
                    	'AcceptedStudent.program_id'=>$this->program_id,
                    'AcceptedStudent.id'=>$id)));
                   
                    
                    }

                    if ($check_elegibility_to_edit==0) {
                             $this->Session->setFlash(__('<span></span> You are not elgibile to admit the student. This happens when you are trying to admit students which you are not assigned.'),'default',array('class'=>'error-box error-message'));
                             $this->redirect(array('action'=>'index'));
				                           
                    }
                    
                 $studentnumber=$this->Student->AcceptedStudent->find('first',
			       array('conditions'=>array('AcceptedStudent.id'=>$id),'fields'=>array('AcceptedStudent.studentnumber'),'recursive'=>-1));
			    
			    if(empty($studentnumber['AcceptedStudent']['studentnumber'])){
			   
                 $this->Session->setFlash(__('<span></span> You can not admit students before generating student number, please generate student number.'),'default',array('class'=>'error-box error-message'));
                   $this->redirect(array('controller'=>'accepted_students','action'=>'generate'));
                }
                 $isAdmitted=$this->Student->isAdmitted($id);
                if($isAdmitted){
			   
                 $this->Session->setFlash(__('<span></span> You have already admitted the students.'),'default',array('class'=>'error-box error-message'));
                   $this->redirect(array('controller'=>'students','action'=>'admit'));
                }
			 } else {
			      // Function to load/save search criteria.
               
                if ($this->Session->read('search_data')) {
                             $this->request->data['getacceptedstudent']=true;
                }
            
			 }
			 
			 
			
             if(!empty($this->request->data) && isset($this->request->data['admit'])){
			    
                     
			       $this->set($this->request->data);
                  // if($this->Student->validates()){
                         
                         $isAdmitted=$this->Student->isAdmitted($id);
                         if(!$isAdmitted){
                            $this->request->data['User']['role_id']=ROLE_STUDENT;
                            $this->request->data['User']['username']=$this->request->data['Student']['studentnumber'];
                            $this->request->data['User']['first_name']=$this->request->data['Student']['first_name'];
                            $this->request->data['User']['last_name']=$this->request->data['Student']['last_name'];
                            $this->request->data['User']['middle_name']=$this->request->data['Student']['middle_name'];
                            $this->request->data['User']['email']=$this->request->data['Student']['email'];
                             // Higher education information won't be present in many cases, do not
                            // store it if nothing is entered.
                           
                            if (isset($this->request->data['HigherEducationBackground'])) {
                                $save_higher_education = false;
                                foreach ($this->request->data['HigherEducationBackground'] as $k => $v) {
                                   if (!empty($v['name']) || !empty($v['diploma_awarded']) ||
                                    !empty($v['date_graduated']) || !empty($v['name'])
                                    || !empty($v['cgpa_at_graduation']) ) {
                                        $save_high_education = true;
                                    }
                                }
                                if (!$save_higher_education) {
                                    unset($this->request->data['HigherEducationBackground']);
                                }
                            }
                            // High school information won't be present, do not
                            // store it if nothing is entered.
                            if ($this->request->data['Student']['program_id']!=PROGRAM_UNDEGRADUATE 
                            || $this->request->data['Student']['program_type_id']!=PROGRAM_TYPE_REGULAR) {
                                if (isset($this->request->data['HighSchoolEducationBackground'])) {
                                    $save_highschool_education = false;
                                    foreach ($this->request->data['HighSchoolEducationBackground'] as $k => $v) {
                                        if (!empty($v['name']) || !empty($v['region']) ||
                                        !empty($v['town']) || !empty($v['zone'])
                                        || !empty($v['school_level'])) {
                                            $save_highschool_education = true;
                                        }
                                    }
                                    if (!$save_highschool_education) {
                                        unset($this->request->data['HighSchoolEducationBackground']);
                                    }
                                }
                            }
                           
                            $this->request->data=$this->Student->unset_empty($this->request->data);
                          
			                    if ($this->Student->saveAll($this->request->data,array('validate'=>'first'))) {
				                    $this->Session->setFlash(__('<span></span>The student has been saved'),'default',array('class'=>'success-box success-message'));
				                     
				                    $this->redirect(array('action' => 'admit'));
				                  
			                    } else {
				                    $this->Session->setFlash(__('<span></span>The student could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				                     $this->set('id',$this->request->data['Student']['accepted_student_id']);
				                     
			                    }
                           
                           
                        } else {
                             $this->Session->setFlash(__('<span></span>The student has already admitted '),'default',array('class'=>'warning-box warning-message'));
                             $this->redirect(array('edit',$id));
                        }
                 $this->set('admitsearch',true);
			 }
			
		if (!empty($this->request->data) && isset($this->request->data['getacceptedstudent'])) {
		   $this->__init_search();
		   if(!empty($this->request->data['AcceptedStudent']['academicyear'])){
		    $conditions=null;
		    $ssacdemicyear = $this->request->data['AcceptedStudent']['academicyear'];
		    $college_ids=array();
		    $department_ids = array();
		    if (!empty($this->college_ids)) {
		        $college_ids=$this->college_ids;
		    } elseif (!empty($this->department_ids)) {
		        $department_ids=$this->department_ids;
		    } 
		    // retrive list of students based on registrar clerk assigned responsibility
		    if (!empty($college_ids)) {
		           if (!empty($this->request->data['AcceptedStudent']['college_id'])) {
		                
		                $conditions = array(
		                   "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
		                    "AcceptedStudent.college_id" =>$this->request->data['AcceptedStudent']['college_id'],

		                    "AcceptedStudent.id NOT IN (select accepted_student_id from students where
		                     accepted_student_id is not null)",
		                );
		               
		               
		           } else {
		               $conditions = array(
		                    "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
		                    "AcceptedStudent.college_id" => $college_ids,
		                   
		                    "AcceptedStudent.id NOT IN (select accepted_student_id from students 
		                    where accepted_student_id is not null)"
		                );
		           }
		    } elseif (!empty($department_ids)) {
		           
		           if (!empty($this->request->data['AcceptedStudent']['department_id'])) {
		                $conditions = array(
		                    "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
		                    "AcceptedStudent.department_id" =>$this->request->data['AcceptedStudent']['department_id'],
		                   
		                     "AcceptedStudent.id NOT IN (select accepted_student_id from students 
		                     where accepted_student_id is not null)",
		                );
		           } else {
		               $conditions = array(
		                    "AcceptedStudent.academicyear LIKE" => "$ssacdemicyear%",
		                    "AcceptedStudent.department_id" =>$department_ids,
		                     "AcceptedStudent.id NOT IN (select accepted_student_id from students 
		                     where accepted_student_id is not null)",
		                );
		           }
		       
		    }
		    if(!empty($this->request->data['AcceptedStudent']['program_id'])){
		    	 $conditions['AcceptedStudent.program_id']=$this->request->data['AcceptedStudent']['program_id'];
		    } else {
		    	 $conditions['AcceptedStudent.program_id']=$this->program_id;
		    }
		    if(!empty($this->request->data['AcceptedStudent']['program_type_id'])){
		    	 $conditions['AcceptedStudent.program_type_id']=$this->request->data['AcceptedStudent']['program_type_id'];
		    } else {
		    	 $conditions['AcceptedStudent.program_type_id']=$this->program_type_id;
		    }
		    debug($conditions);
		    if (!empty($conditions)) 
		    {
				$this->paginate = array('limit'=>50000,'contain'=>array('Student','College','Department','Program','ProgramType','Region','User'));
				$this->paginate['conditions']=$conditions;
				$this->Paginator->settings=$this->paginate;
				$acceptedStudents=$this->Paginator->paginate('AcceptedStudent');
				debug($acceptedStudents);
		        $this->set('acceptedStudents',$acceptedStudents);
		            if(!empty($acceptedStudents)){
		                $this->set('admitsearch',true);
		            } else {
		               $this->Session->setFlash(__('<span></span>No data is found with your search criteria'),'default',array('class'=>'info-box info-message'));
			
		            }
		            $this->request->data['getacceptedstudent']=true;
		            $admitsearch=true;
		      } else {
		         $this->Session->setFlash(__('<span></span>You dont have privilage to admit students in the given criteria.'),'default',array('class'=>'error-box error-message'));
			
		      }
		   } else {
		      $this->Session->setFlash(__('<span></span>Please select academic  year'),'default',array('class'=>'error-box error-message'));
		   }

		}
			
			if($id){
			    $is_student_id_exist=$this->Student->AcceptedStudent->find('count',
			    array('conditions'=>array('AcceptedStudent.id'=>$id)));
			    if($is_student_id_exist){
			        $this->set(compact('id'));
			        $this->set('admitsearch',true);
			        $data = $this->Student->AcceptedStudent->find('first', 
			        array('conditions'=>array('AcceptedStudent.id'=>$id)));
			       
			        $data_import=array();
                    if(!empty($data)){
                               
                      
                        unset($data['Preference']);
                        unset($data['Student']);
                        $data_import=$data;
                        $data_import['Student']['accepted_student_id']=$data['AcceptedStudent']['id'];
                        $data_import['Student']['first_name']=$data['AcceptedStudent']['first_name'];
                        $data_import['Student']['middle_name']=$data['AcceptedStudent']['middle_name'];
                        $data_import['Student']['last_name']=$data['AcceptedStudent']['last_name'];
                        $data_import['Student']['studentnumber']=$data['AcceptedStudent']['studentnumber'];
                          $data_import['Student']['gpa']=$data['AcceptedStudent']['gpa'];
                            $data_import['Student']['attended_stream']=$data['AcceptedStudent']['attended_stream'];
                              $data_import['Student']['university_attended']=$data['AcceptedStudent']['university_attended'];
                              
                        $data_import['Student']['region_id']=$data['AcceptedStudent']['region_id'];
                     
                         $data_import['Student']['college_id']=$data_import['AcceptedStudent']['college_id'];
                        $data_import['Student']['department_id']=$data['AcceptedStudent']['department_id'];
                        $data_import['Student']['program_id']=$data['AcceptedStudent']['program_id'];
                        $data_import['Student']['program_type_id']=$data['AcceptedStudent']
                               ['program_type_id'];
                        $data_import['Student']['gender']=$data['AcceptedStudent']['sex'];
                        $data_import['Student']['curriculum_id']=$data['AcceptedStudent']['curriculum_id'];
                        $data_import['User']['id']=$data['User']['id'];
                        $data_import['User']['role_id']=$data['User']['role_id'];
                        unset($data['AcceptedStudent']);
                  }
                  $this->request->data = $data_import;
			    }
			}
		    // display the right department and college based on the privilage of registrar users
		   if ($this->role_id == ROLE_REGISTRAR) {
		        $college_ids=array();
		        $department_ids = array();
		       
		        if (!empty($this->college_ids)) {
		            
		            $college_ids=$this->college_ids;
		             $this->set('colleges',$this->Student->College->find('list',
		            array('conditions'=>array('College.id'=>$college_ids))));
		            $this->set('departments',$this->Student->Department->find('list',
		            array('conditions'=>array('Department.college_id'=>$college_ids))));
		             $this->set('college_level',true);
		        } elseif (!empty($this->department_ids)) {
		            $department_ids=$this->department_ids;
		            $this->set('departments',$this->Student->Department->find('list',
		            array('conditions'=>array('Department.id'=>$department_ids))));
		              $this->set('colleges',$this->Student->College->find('list',
		            array('conditions'=>array('College.id'=>$college_ids))));
		            $this->set('department_level',true);
		        } 
		         $colleges = $this->Student->College->find('list');
		         $this->set(compact('colleges'));
		    
		   } else {
		     $colleges = $this->Student->College->find('list');
		     $departments = $this->Student->Department->find('list'); 
		     $this->set(compact('colleges','departments'));
		   }
			$regions=$this->Student->Region->find('list');
		    $countries=$this->Student->Country->find('list');
		    $cities=$this->Student->City->find('list');
		  
		    $this->set(compact('programs',
		    'programTypes','regions','countries','cities'));
			
    }
  
	function get_regions($country_id=null){
	    
		$this->layout = 'ajax';
		if ($country_id) {
		  $regions=$this->Student->Region->find('list',array('conditions'=>array('Region.country_id' =>$country_id)));
		} else {
		  $regions=$this->Student->Region->find('list',array('conditions'=>array('Region.country_id' =>$this->request->data['Student']['country_id'])));
		}
		
		$this->set(compact('regions'));
		
	}
	function get_cities($region_id=null) {
		$this->layout = 'ajax';
		if ($region_id) {
		  $cities=$this->Student->City->find('list',array('conditions'=>array('City.region_id' 
		=>$region_id)));
	
		} else {
		  $cities=$this->Student->City->find('list',array('conditions'=>array('City.region_id' 
		=>$this->request->data['Student']['region_id'])));
	
		}
		$this->set(compact('cities'));
		
	}
	
	function ajax_get_department() {
	        $this->layout = 'ajax';

	        $this->set('departments',$this->Student->Department->find('list',array('conditions'=>array('Department.college_id'=>$this->request->data['Staff'][0]['college_id']))));
	        // init departments
	        /*$college_id = $this->request->data['id'];


	        $departments = array();
	        $this->layout = null;




	        if($college_id > 0) {
		            // get departments
		            $departments = $this->Department->find('list',array('conditions'=>array('Department.college_id'=>$college_id)));
		        
	        }

	        // set
	        $this->set(compact('departments'));
        */
    }
    /*
    function issue_password() {
        //issue students password
       

	    if(!empty($this->request->data) && 
	    isset($this->request->data['issuepasswordtostudent'])){
	            $this->set($this->request->data);
	            if($this->Student->User->validates()){
	                //debug($this->request->data);
	                if (!empty($this->request->data['User']['password'])) {
	                $this->request->data['User']['password'] = 
				    $this->Auth->password($this->request->data['User']['password']);
				    $this->request->data['User']['role_id']=ROLE_STUDENT;
	                if($this->Student->User->save($this->request->data['User'])){
	                     $this->request->data=null;
					       	
	                    $this->Session->setFlash('<span></span>The student password has been updated. ','default',
		           array('class'=>'success-box success-message'));
		           
				       
	                } else {
	                   $this->Session->setFlash('<span></span>The student password could not be updated. ','default',
		           array('class'=>'error-box error-message'));
	                }
	                
	               } else {
	               
	                  $this->Session->setFlash('<span></span>The issued password coudnt be empty. Please generate password first before issue. ','default',
		           array('class'=>'error-box error-message'));
	               }
	            }
	    }
       if(!empty($this->request->data)&&isset($this->request->data['issuestudentidsearch'])){
              
               if(!empty($this->request->data['Student']['studentnumber'])){
		               $students=$this->Student->find('first',array('conditions'=>array('Student.studentnumber LIKE '=>
			         trim($this->request->data['Student']['studentnumber']).'%')));
			         
		             if ($this->role_id == ROLE_DEPARTMENT) { 
		           
			             if (!empty($students)) {
			              
			                  $students=$this->Student->find('first',
			                 array('conditions'=>array('Student.studentnumber LIKE'=>
			                 trim($this->request->data['Student']['studentnumber']).'%',
			                 'Student.department_id'=>$this->department_id)));
			                 
			                if (!empty($students)) {
			                     if (!empty($students['Student']['department_id'])) {
			                       
			                   
			                     } else if ($students['Student']['college_id'] != $this->college_id) {
			                         $this->Session->setFlash('<span></span>
			                      You are not elegible to issue password.','default',
		                        array('class'=>'info-box info-message')); 
			                     }
			                            
			                }
			             } 
			             
			       
		             } else if ($this->role_id == ROLE_COLLEGE) {
		             
		              
			             if (!empty($students)) {
			                
			                 $students=$this->Student->find('first',
			                 array('conditions'=>array('Student.studentnumber LIKE'=>
			                 trim($this->request->data['Student']['studentnumber']).'%',
			                 'Student.college_id'=>$this->college_id,
			                 'OR'=>array('Student.department_id is null',
			                 'Student.department_id'=>array(0,'')))));
			                       
			                if (!empty($students)) {
			                     if (!empty($students['Student']['department_id'])) {
			                       
			                     $this->Session->setFlash('<span></span>
			                      You can not issued password. Department is responsbile to manage those students who joined department. ','default',
		                        array('class'=>'info-box info-message')); 
			                     } else if ($students['Student']['college_id'] != $this->college_id) {
			                         $this->Session->setFlash('<span></span>
			                      You are not elegible to issue password.','default',
		                        array('class'=>'info-box info-message')); 
			                     }
			                            
			                }
			             } 
		             }
		             
			        //debug($students);
			        if(empty($students)){
			          $this->Session->setFlash('<span></span>Please enter a valid student number','default',
		           array('class'=>'error-box error-message'));
			        } else {
			               $this->set('students',$students);
			               $this->set('hide_search',true);
			               $this->set('student_number',$this->request->data['Student']['studentnumber']);
			        }
		             
		       } else {
		           $this->Session->setFlash('<span></span>Please enter student number','default',
		           array('class'=>'error-box error-message'));
		       }
		 
       }
      
		$this->set('studentks', $this->paginate());
      
    }
    */
    
    
     function issue_password() {
        //debug($this->request->data);
	    if(!empty($this->request->data) && 
	    isset($this->request->data['issuepasswordtostudent'])){
          
            // check password length
               $this->loadModel('Securitysetting');
               
               $securitysetting=$this->Securitysetting->find('first');
               if (strlen($this->request->data['User']['passwd'])
               >=$securitysetting['Securitysetting']['minimum_password_length'] 
               && strlen($this->request->data['User']['passwd'])<=
               $securitysetting['Securitysetting']['maximum_password_length']) { 

               // if (!empty($this->request->data['User']['password'])) {
               debug($this->request->data);
		       $this->request->data['User']['role_id']=ROLE_STUDENT;
		       $this->request->data['User']['password']=$this->Auth->password($this->request->data['User']['passwd']);
		       unset($this->request->data['User']['passwd']);
		       
               $username=$this->Student->User->find('first',array('conditions'=>array('User.username'=>$this->request->data['User']['username']),'recursive'=>-1));
               
               if (!empty($username)) {
                 $this->request->data['User']['id']=$username['User']['id'];
               }
               $this->request->data['User']['force_password_change'] = 1;
             
               if($this->Student->User->save($this->request->data['User'])){
                    
			        
			         // if the issued is the first time update  student field  
                    if(empty($this->request->data['User']['id'])){
                        $this->request->data['Student']['user_id']=$this->Student->User->id;
			            $this->Student->id = $this->request->data['Student']['id'];
			            
			            $this->Student->saveField('user_id',
			            $this->request->data['Student']['user_id']);
			        }
			       
			        $student=$this->Student->find('first',array('conditions'=>array(
                    'Student.id'=>$this->request->data['Student']['id']
                    ),'recursive'=>-1,'fields'=>array('id','user_id')));
                 
                    if (!empty($student)) {
                        if (!empty($this->request->data['User']['id'])) {
                    	    $student['Student']['user_id']=$this->request->data['User']['id'];
                    	} else {
                    	  $student['Student']['user_id']=$this->Student->User->id;
                    	}
                      
                    	$this->Student->id=$student['Student']['id'];
                    	$this->Student->saveField('user_id',$student['Student']['user_id']);
                    	
                    	$this->Student->AcceptedStudent->id=$student['Student']['accepted_student_id'];
                    	$this->Student->AcceptedStudent->saveField('user_id',$student['Student']['user_id']);
                    	
                    	$this->Session->setFlash('<span></span>

                            The student password has been updated. ','default',
                      array('class'=>'success-box success-message'));
        	
                    } else {
                      
                    $this->Session->setFlash('<span></span>
                    The student password has been updated. ','default',
              array('class'=>'success-box success-message'));
                    }
                    
                $this->request->data=null;
                
		           
                } else {
                   $this->Session->setFlash('<span></span>The student password could not be updated. ','default',array('class'=>'error-box error-message'));
                } 
            } else {
               $this->Session->setFlash('<span></span>'.__('Password policy: Your password should be greather than or equal to '.$securitysetting['Securitysetting']['minimum_password_length'].' and less than or equal to '.$securitysetting['Securitysetting']['maximum_password_length'].''), 'default', array('class' => 'error-box error-message'));
            
            }
          
	    }
       if(!empty($this->request->data)&&isset($this->request->data['issuestudentidsearch'])){
          
               if(!empty($this->request->data['Student']['studentnumber'])){
		          $students = array();
                  if ($this->role_id == ROLE_DEPARTMENT) {
		                  $students=$this->Student->find('first',
		                  array('conditions'=>array('Student.studentnumber 
		                  LIKE '=>trim($this->request->data['Student']['studentnumber']).'%',
		                  'Student.department_id'=>$this->department_id),
		                  'contain'=>array('User','AcceptedStudent','Program','College',
		                  'Department','ProgramType')));
		                  if (!empty($students)) {
		                           $this->set('students',$students);
			                       $this->set('hide_search',true);
			                       $this->set('student_number',$this->request->data['Student']['studentnumber']);
		                  } else {
		                                    $this->Session->setFlash('
			                         <span></span> You are not elegible to issue/reset password.The student  is not belongs to your  department.','default',array('class'=>'info-box info-message')); 
         
		                  }
		                  
			       
		           } else if ($this->role_id == ROLE_COLLEGE) {
		               $students=$this->Student->find('first',array('conditions'=>
		               array('Student.studentnumber LIKE '=>
			         trim($this->request->data['Student']['studentnumber']).'%'),'contain'=>array('User','AcceptedStudent','Program','College',
		                  'Department','ProgramType'))); 
		               if (!empty($students)) {
			                
			                 $students=$this->Student->find('first',
			                 array('conditions'=>array('Student.studentnumber LIKE'=>
			                 trim($this->request->data['Student']['studentnumber']).'%',
			                 'Student.college_id'=>$this->college_id,
			                 'Student.department_id is null',
			                 )));
			                  
			                  if (empty($students)) {
			                    
			                         $this->Session->setFlash('
			                         <span></span> You are not elegible to issue/reset password. The student has already assigned to department. Department is responsible for  password  issue or reset.','default',
		                        array('class'=>'info-box info-message')); 
			                     
			                  } else {
			                    
			                       $this->set('students',$students);
			                       $this->set('hide_search',true);
			                       $this->set('student_number',$this->request->data['Student']['studentnumber']);
		        
			                  }
			                  
			           } else {
			                
			                if(empty($students)){
			                  $this->Session->setFlash('<span></span>
			                  Please enter a valid student number','default',
		                   array('class'=>'error-box error-message'));
			                }       
			           }
		           }


		       } else {
		           $this->Session->setFlash('<span></span>Please enter student number','default',
		           array('class'=>'error-box error-message'));
		       }
		 
       }
      
		//$this->set('studentks', $this->paginate());
      
    }
    
    
    function profile () {
        
        $check_student_admitted=$this->Student->find('count',
        array('conditions'=>array('Student.id'=>$this->student_id)));
        if ($check_student_admitted==0) {
          
				$this->Session->setFlash('<span></span>'.__('You profile will be available after registrar has finished the admission data entry.'),
				'default',array('class'=>'info-box info-message'));
                $this->redirect('/dashboard/index');
        }
        if (!empty($this->request->data)) {
            unset($this->request->data['User']);
           
            if (!empty($this->request->data['Student']['email'])) {
                $this->request->data['User']['id']=$this->Auth->user('id');
                $this->request->data['User']['email']=$this->request->data['Student']['email'];   
            }
            
            $this->request->data=$this->Student->unset_empty($this->request->data);
          
			if ($this->Student->saveAll($this->request->data,array('validate'=>'first'))) {
				$this->Session->setFlash('<span></span>'.__('Your Profile is updated.'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('controller'=>'dashboard','action' => 'index'));
			} else {
			   
				$this->Session->setFlash('<span></span>'.__('The student could not be saved. Please, try again.'),
				'default',array('class'=>'error-box error-message'));
				$studentsss=$this->Student->find('first', 
            array('conditions'=>array('Student.id'=>$this->student_id),'contain'=>array('User','Attachment')));
				$this->request->data['Student']= $studentsss['Student'];
			    $this->request->data['User']=$studentsss['User'];
			    $this->request->data['Attachment']=$studentsss['Attachment'];
			    /*
			    if (!isset($this->request->data['Attachment'][0]['dirname'])) {
			         $this->request->data['Attachment']=array();
			    }
			    */
			}
			
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Student->find('first', 
            array('conditions'=>array('Student.id'=>$this->student_id),
            'contain'=>array('User','AcceptedStudent','Curriculum'=>array('Course'=>array('CourseCategory','GradeType'),'CourseCategory'),
            'Program','ProgramType','Contact','Country','Region','City','Department','College','EslceResult',
            'EheeceResult','Attachment','HigherEducationBackground','HighSchoolEducationBackground')));
          
			//$this->request->data = $this->Student->read(null, $this->student_id);
			
		}
		$regions=$this->Student->Region->find('list');
		$countries=$this->Student->Country->find('list');
		$colleges = $this->Student->College->find('list');
		$departments = $this->Student->Department->find('list');
		$contacts = $this->Student->Contact->find('list');
		$users = $this->Student->User->find('list');
		$programs = $this->Student->Program->find('list');
		$cities=$this->Student->City->find('list');
		$programTypes =$this->Student->ProgramType->find('list');
		$this->set(compact('contacts','users','colleges','departments','programs','programTypes', 'regions','countries','cities'));
      
    }
    
    public function ajax_update() {
       /* if ($this->request->data) {
            App::import('Core', 'sanitize');
            $email = Sanitize::clean($this->request->data['Student']['email']);

            $this->Student->id = $this->student_id;
            $this->Student->saveField('email', $title);
            $this->set('studentemail', $title);
        }
        */
        
        //Step 1. Update the value in the database 
        $value = $this->request->data['update_value']; //new value to save  
        $field = $this->request->data['element_id']; 
        $this->Student->id = $this->student_id;
        if (!$this->Student->saveField($field,$value,true)) { // Update the field 
            $this->set('error', true);  
        }  
        $student= $this->Student->read(null, $this->student_id);
			
        //Step 2. Get the display value for the field if the field is a foreign key 
        // See if field to be updated is a foreign key and set the display value 
        if (substr($field,-3) == '_id'){ 
         
            // Chop off the "_id" 
            $new_field = substr($field,0,strlen($field)-3);  

            // Camelize the result to get the Model name 
            $model_name = Inflector::camelize($new_field); 

            // See if the model has a display name other than default "name";  
            if (!empty($this->$model_name->display_field)){ 
                $display_field = $this->$model_name->display_field; 
            }else { 
                $display_field = 'name'; 
            } 
         
            // Get the display value for the id 
            $value = $this->$model_name->field($display_field,array('id' => $value)); 
        } 

        //Step 3. Set the view variable and render the view. 
        $this->set('value',$value); 
        $this->beforeRender(); 
        $this->layout = 'ajax'; 
    }

	function get_course_registered_and_add($student_id = "") {
		$this->layout = "ajax";
		$published_courses = array();
		if($student_id != "") {
			$published_courses = $this->Student->getStudentRegisteredAndAddCourses( $student_id );
		}
		$this->set(compact('published_courses'));
	}
	
	/**
	*Web services to access students from warehouse system
	*/
	function student_lists ($student_id=null){
	 
	  $this->Student->bindModel(array('hasMany'=>array('StudentsSection'=>array('conditions'=>array('StudentsSection.archive'=>0)))));
	  if ($student_id) {
	  
	    $students = $this->Student->find('all',array('conditions'=>array(
	    'Student.id'=>$student_id,'Student.id NOT IN (select  student_id from graduate_lists)'),'fields'=>array('id','studentnumber','full_name','department_id'),'contain'=>array('StudentsSection')));
	   
	  
	  } else {
	    $students = $this->Student->find('all',array('conditions'=>array('Student.id NOT IN (select  student_id from graduate_lists)'),'fields'=>array('id','studentnumber','full_name','department_id'),'contain'=>array('StudentsSection')));
	  
	  }
	  
	  
	  $sections = $this->Student->Section->find('all', 
				array(
				 
					'conditions' => array(
					
						'Section.archive' => 0
					),
					
					'contain' => array('Program'=>array('id','name'), 'ProgramType'=>array('id','name'))
				)
		);
	  
	 
	  $colleges = $this->Student->College->find('all',array('fields'=>array('College.id','College.name'),
	  'contain'=>array()));
	  $departments = $this->Student->Department->find('all',array('fields'=>array('Department.id','Department.name','Department.college_id'),
	  'contain'=>array()));
	  $this->set(compact('students','sections','colleges','departments'));
	}
	
	function manage_student_medical_card_number(){
		if(isset($this->request->data['search'])){
			$studentnumber = $this->request->data['Student']['studentnumber'];
			if(!empty($studentnumber)){
				$students = $this->Student->get_student_details_for_health($studentnumber);
				if(empty($students)){
					$this->Session->setFlash('<span></span>'.__('There is not student in this ID. Please provide correct student id (format example. Reg/453/88).'),'default',array('class'=>'error-box error-message'));
				} else {
					$this->set(compact('students'));
				}
			} else {
				$this->Session->setFlash('<span></span>'.__('Please provide student ID (format example. Reg/453/88).'),'default',array('class'=>'info-box info-message'));
			}
		}
		
		if(isset($this->request->data['submit'])){
			$this->Student->id = $this->request->data['Student']['id'];
			if($this->Student->saveField('card_number', $this->request->data['Student']['card_number'],true)){
				$this->Session->setFlash('<span></span>'.__(' The card number has been saved.'),'default',array('class'=>'success-box success-message'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The card number could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
			$students = $this->Student->get_student_details_for_health($this->request->data['Student']['studentnumber']);
			$this->set(compact('students'));
		}
	}
	
	function student_academic_profile ($student_id=null) {
	    if ($this->role_id == ROLE_STUDENT) {     
	       
	         $student_academic_profile=$this->Student->getStudentRegisteredAddDropCurriculumResult($this->student_id,$this->AcademicYear->current_academicyear());
	         $this->set(compact('student_academic_profile'));
	    } else {
		   
		     if(!empty($student_id) && is_numeric($student_id)){
	         if ($this->role_id == ROLE_REGISTRAR) {
	         	   if(!empty($this->department_ids)){
                        $check_id_is_valid=$this->Student->
			            find('count',
			            array('conditions'=>array('Student.id'=>$student_id,
			            	'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                    	'Student.department_id'=>$this->department_ids
			            	)));
	         	   }else if(!empty($this->college_ids)) {
                        $check_id_is_valid=$this->Student->
			            find('count',
			            array('conditions'=>array('Student.id'=>$student_id,
			            	'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                    	'Student.college_id'=>$this->college_ids
			            	)));
	         	   }
	              
			   
	         } else if ($this->role_id == ROLE_DEPARTMENT) {
	             $check_id_is_valid=$this->Student->
			            find('count',array('conditions'=>array('Student.id'=>$student_id,'Student.department_id'=>$this->department_id,
	
			            	)));
                 
				   
	         } else if ($this->role_id == ROLE_COLLEGE) {
	                    $check_id_is_valid=$this->Student->
			            find('count',array('conditions'=>array('Student.id'=>$student_id,'Student.college_id'=>$this->college_id)));
			 
	         } else if ($this->role_id == ROLE_SYSADMIN){
                   $check_id_is_valid=$this->Student->
			            find('count',array('conditions'=>array('Student.id'=>$student_id)));
	         }
	       	}
	       	debug($check_id_is_valid);
	        if (isset($check_id_is_valid) && $check_id_is_valid>0) {
	           $student_academic_profile=$this->Student->getStudentRegisteredAddDropCurriculumResult($student_id,$this->AcademicYear->current_academicyear());
               $studentAttendedSections=ClassRegistry::init('Section')->getStudentSectionHistory($student_id);

						
	           $this->set(compact('student_academic_profile','studentAttendedSections'));
	        }
	    }
		
	    if (!empty($this->request->data) && isset($this->request->data['continue'])) { 
	    	debug($this->request->data); 
	    	if (!empty($this->request->data['Student']['studentID'])) {
			            $student_id_valid=$this->Student->
			            find('count',
			            array('conditions'=>array('Student.studentnumber'=>
			            trim($this->request->data['Student']['studentID']))));
                        if ($this->role_id == ROLE_REGISTRAR) {
                        	  if(!empty($this->department_ids)){
							   $check_id_is_valid=$this->Student->
									find('count',
									array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']),
'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                    	'Student.department_id'=>$this->department_ids
										)));
								}else if(!empty($this->college_ids)){
                                     $check_id_is_valid=$this->Student->
									find('count',
									array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']),
'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                    	'Student.college_id'=>$this->college_ids
										)));
								}
						   
						 } else if ($this->role_id == ROLE_DEPARTMENT) {
							 $check_id_is_valid=$this->Student->
									find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']),'Student.department_id'=>$this->department_id)));
						     
							   
						 } else if ($this->role_id == ROLE_COLLEGE) {
							        $check_id_is_valid=$this->Student->
									find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']),'Student.college_id'=>$this->college_id)));
						 
						 } else if ($this->role_id == ROLE_SYSADMIN){
                                $check_id_is_valid=$this->Student->
									find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentID']))));
	         		     }
	       
			            $studentIDs=1;
			            
			             if ($student_id_valid>0 && $check_id_is_valid>0) {
			                 $everythingfine=true;
			                

$student_id=$this->Student->field('id',array('studentnumber'
			                =>trim($this->request->data['Student']['studentID'])));


$student_academic_profile=$this->Student->getStudentRegisteredAddDropCurriculumResult($student_id,$this->AcademicYear->current_academicyear());

$studentAttendedSections=ClassRegistry::init('Section')->getStudentSectionHistory($student_id);
						
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
	
	function get_modal_box($student_id = null){
		$this->layout = 'ajax';
		if($this->Auth->user('id')){
			if($this->role_id==ROLE_STUDENT){
                $check_id_is_valid=$this->Student->
			            find('count',
			            array('conditions'=>array('Student.id'=>$this->student_id)));
			} else if($this->role_id!=ROLE_STUDENT) {
				 $check_id_is_valid=$this->Student->
			            find('count',
			            array('conditions'=>array('Student.id'=>$student_id)));
			}
           
			if ($check_id_is_valid>0) {
		         $student_academic_profile=$this->Student->getStudentRegisteredAddDropCurriculumResult(
		         $student_id,$this->AcademicYear->current_academicyear());
		         $this->set(compact('student_academic_profile'));
		    }
		} else {

		}
	}
	
	function profile_not_build_list () {
	     $student_lists=$this->Student->getProfileNotBuildList();
	     $this->set(compact('student_lists'));
	}
	
	function name_change($id=null) {
              
		 if (!empty($this->request->data['Student']) && isset($this->request->data['searchStudentName'])) {
			
			$student_id = null;
			$everythingfine=true;
			if (empty($this->request->data['Student'])){
			      $this->Session->setFlash('<span></span> '.__('Please provide the student number (ID) you want to change name.'),'default',array('class'=>'error-box error-message'));  
			       $everythingfine=false;
			}
		        $department_id = null;
			$college_id =null;
			if (!empty($this->department_ids)) {
				$department_id = $this->department_ids;
			} else if (!empty($this->department_id)) { 
			        $department_id = $this->department_id;
			} else {	
			   if($this->role_id == ROLE_REGISTRAR) {
		               if(!empty($this->department_ids)) {
					$department_id=$this->department_ids;
			       } else if (!empty($this->college_ids)) {
		                    $college_id=$this->college_ids;
			       }  
			  }				
		       }
		
		if ($everythingfine) {
	
		     if (!empty($department_id)) {
			   $check_id_is_valid=$this->Student->
			    find('count',
			    array('conditions'=>array('Student.studentnumber'=>
		  trim($this->request->data['Student']['studentnumber']),
		'Student.department_id'=>$department_id)));
			
		     } else if (!empty($college_id)) {
			   $check_id_is_valid=$this->Student->
			    find('count',
			    array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentnumber']),'Student.college_id'=>$college_id,'Student.department_id is null')));
		     }
		     
		     if ($check_id_is_valid>0) {
			 // do something if needed
			$everythingfine=true;
			$student_id= $this->Student->
			    find('first',
			    array('conditions'=>array('Student.studentnumber'=>
		  trim($this->request->data['Student']['studentnumber']),
		'Student.department_id'=>$department_id),'recursive'=>-1));
		     } else {
			$everythingfine=false;
			$this->Session->setFlash('<span></span> '.
			__('The provided student number  is not valid or you don\'t have the privilage to change name to this student.'),'default',
			array('class'=>'error-box error-message'));      
		     }
	      }
		
	        if ($everythingfine) {
			$test_data = $this->Student->find('first',array('conditions'=>array('Student.id'=>$student_id['Student']['id']),
			'recursive'=>-1));          
			$this->request->data=$this->Student->StudentNameHistory->reformat($test_data);        
		}
	    }
	    if (!empty($this->request->data) && isset($this->request->data['changeName'])) {
			$data=$this->Student->StudentNameHistory->reformat($this->request->data);
			if ($this->Student->StudentNameHistory->save($data)) {
			     $change['Student']['amharic_first_name']=$data['StudentNameHistory']['to_amharic_first_name'];
			     $change['Student']['id']=$data['StudentNameHistory']['student_id'];
			     $change['Student']['amharic_middle_name']=$data['StudentNameHistory']['to_amharic_middle_name'];
			     
			      $change['Student']['amharic_last_name']=$data['StudentNameHistory']['to_amharic_last_name'];
			      
			      $change['Student']['first_name']=$data['StudentNameHistory']['to_first_name'];
			     $change['Student']['middle_name']=$data['StudentNameHistory']['to_middle_name'];
			     
			      $change['Student']['last_name']=$data['StudentNameHistory']['to_last_name'];
			      
			      
			    if ($this->Student->save($change)) {
			       $this->Session->setFlash('<span></span> '.__('The student changed name has been saved.'),
			       'default',array('class'=>'success-box success-message'));  
			       
				//save the changed name in student table
				$this->redirect($this->referer());
				//return $this->redirect(array('action' => 'index'));
			    } else {
			      
			      $this->Session->setFlash('<span></span> '.__('The student changed name could not be saved.
			       Please, try again.', true),'default',array('class'=>'error-box error-message'));  
			        $this->Student->StudentNameHistory->delete($this->Student->StudentNameHistory->id);
			    
			    }
				
			} else {
			    //debug($this->Student->StudentNameHistory->invalidFields());

				  $this->Session->setFlash('<span></span> '.__('The student changed name could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message')); 
				  $this->redirect($this->referer()); 
			}
		}
		
		if (empty($this->request->data) && !empty($id)) {
			$test_data = $this->Student->find('first',array('conditions'=>array('Student.id'=>$id),
			'contain'=>array()));
			
		    $this->request->data=$this->Student->StudentNameHistory->reformat($test_data);	
		}
		
	}
	
	
	
	function department_issue_password($section_id = null) {
		$this->__issue_password($section_id, 0);
	}
	function freshman_issue_password($section_id = null) {
	    $this->__issue_password($section_id, 1);
	}
	
	private function __issue_password($section_id = null, $freshman_program = 0) {
		/*
		1. Retrieve list of sections based on the given search criteria
		2. Display list of sections
		3. Up on the selection of section, display list of students with check-box
		4. Prepare student password issue/reset in PDF for the selected students
		*/
		$programs = $this->Student->Section->Program->find('list');
		$program_types = $this->Student->Section->ProgramType->find('list');
		if ($freshman_program==0) {
		$yearLevels = $this->Student->Section->YearLevel->find('list',
		array('conditions'=>array('YearLevel.department_id' => $this->department_id)));
		} else {
		     $yearLevels[0] = "Pre/Unassign Freshman";
		   
		}
       
		$departments[0] = 0;
		//Get sections button is clicked
		if(isset($this->request->data['listSections'])) {
		    $this->__init_search_student();
			$options = array();
			$options = array(
						'conditions' =>
						array(
						
							'Section.archive' =>0,
							'Section.program_id' => $this->request->data['Student']['program_id'],
							'Section.program_type_id' => $this->request->data['Student']['program_type_id']
						),
						'recursive' => -1
			 );

			if($freshman_program == 1) {
				$options['conditions'][] = 
					array(
						'Section.college_id' => $this->college_id,
						'Section.archive' =>0,
						'Section.department_id IS NULL',
						'Section.year_level_id IS NULL'
					);
			}
			else {
			  
				$options['conditions'][] = array(
				    'Section.department_id' => $this->department_id,
				    'Section.year_level_id' => $this->request->data['Student']['year_level_id'],
				    
				    );
			}
			
			$sections = $this->Student->Section->find('list', $options);
			
			if ($freshman_program == 1) {
			       $sections['pre']="All";
			       asort($sections);
			      
			}
			
			if(empty($sections)) {
			    $this->Session->setFlash('<span></span>'.__('There is no section by the selected search criteria.'), 
			    'default', array('class'=>'info-box info-message'));
			}
			else {
				$sections = array('0' => '--- Select Section ---') + $sections;
			}
			$year_level_selected = $this->request->data['Student']['year_level_id'];
			
			$program_id = $this->request->data['Student']['program_id'];
			$program_type_id = $this->request->data['Student']['program_type_id'];
		} 
		//Section is selected from the combo box
		
		if(isset($this->request->data['issueStudentPassword']) ||
		 (!empty($section_id) && ($section_id != 0 || 
		 strcasecmp($section_id,"pre")==0) )) {
		    $this->__init_search_student();
			if(isset($this->request->data['issueStudentPassword'])) {
			    
		$section_id = $this->request->data['Student']['section_id'];
			}
			
			if ($section_id != "pre") {
			    $section_detail = $this->Student->Section->find('first',
				    array(
					    'conditions' =>
					    array(
						    'Section.id' => $section_id
					    ),
					    'recursive' => -1
				    )
			    );
			    $year_level_selected = $section_detail['Section']['year_level_id'];
			    $program_id = $section_detail['Section']['program_id'];
			    $program_type_id = $section_detail['Section']['program_type_id'];
			}
			//Student list retrial
			
			if (strcasecmp($section_id, "pre") ==0) {
			    
			    $students_in_section = $this->Student->listStudentByAdmissionYear(
			    null,$this->college_id,$this->request->data['Student']['acadamic_year'],$this->request->data['Student']['name']);
			   
			} else {
				
			    $students_in_section = $this->Student->Section->getSectionStudents($section_id,
$this->request->data['Student']['name']);
                               
                              
			}
			$options = array();
			$options = array(
						'conditions' =>
						array(
						
							'Section.archive' =>0,
							'Section.program_id' => $this->request->data['Student']['program_id'],
							'Section.program_type_id' => $this->request->data['Student']['program_type_id']
						),
						'recursive' => -1
			 );

			if($freshman_program == 1) {
				$options['conditions'][] = 
					array(
						'Section.college_id' => $this->college_id,
						'Section.archive' =>0,
						'Section.department_id IS NULL',
						'Section.year_level_id IS NULL'
					);
			}
			else {
			  
				$options['conditions'][] = array(
				    'Section.department_id' => $this->department_id,
				    'Section.year_level_id' => $this->request->data['Student']['year_level_id'],
				    
				    );
			}
			
			$sections = $this->Student->Section->find('list', $options);

			
		    //Give an option to get all freshman studnet of the college
		    if ($freshman_program == 1) {
			       $sections['pre']="All";
			       asort($sections);		      
			}
			
			if(empty($sections)) {
				$this->Session->setFlash('<span></span>'.__('There is no section by the selected search criteria.'), 'default', array('class'=>'info-box info-message'));
			}
			else {
				$sections = array('0' => '--- Select Section ---') + $sections;
			}
		} else {
		   
		}
		
	//Issue Student Password button is clicked
	if(isset($this->request->data['issueStudentPassword'])) {
			$student_ids = array();		
			foreach($this->request->data['Student'] as $key => $student) {
	        if (is_numeric($key) && !empty($student['student_id'])) {			   
			   if (isset($student['gp']) && $student['gp']==1) {
			       $student_detail['student_id']=$student['student_id'];
				   
				   $student_detail['flat_password']=$this->_generatePassword(5);
				    $student_detail['hashed_password'] =  
				    Security::hash(trim($student_detail['flat_password']), null, true);
				    $student_ids[] =  $student_detail;
				   
							
			   }
			  } 
	        }

		if(empty($student_ids)) {
		 $this->Session->setFlash('<span></span>'.__('You are required to select at least one student.', true), 'default', array('class'=>'error-box error-message'));
		} else {
			
			  $student_passwords = $this->Student->getStudentPassword($student_ids);
				
			if(empty($student_passwords)) {
			$this->Session->setFlash('<span></span>'.
			__('Password issue/reset has experiance problem  for the selected students. Please try again.'), 'default', array('class'=>'info-box info-message'));
			}
			else {
					   
			 $this->set(compact('student_passwords'));
			
			$this->response->type('application/pdf');
	 		$this->layout = '/pdf/default';
			
		    if($this->request->data['Student']['single_page']=="yes") {
			$this->render('mass_password_issue_single_page_pdf');
			} else {
				$this->render('issue_password_pdf');
			}		
			return;
			}
			
		  }
	  }
	$this->set(compact('programs', 'program_types', 'departments','yearLevels','year_level_selected','semester_selected', 'program_id', 'program_type_id', 'section_id', 'sections', 
		 'students_in_section'));
	$this->render('issue_password_list');
    }

 
	
	
    function _generatePassword($length='')
    {
        $str='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $max=strlen($str);
        $length=@round($length);
        if(empty($length)){$length=rand(8,12);}
        $password='';
        for($i=0; $i<$length; $i++){$password.=$str{rand(0,$max-1)};}
        return $password;
    }

   function auto_yearlevel_update() {
		$studentssections= $this->Student->find('all',
array('conditions'=>array('Student.id NOT IN (select student_id from graduate_lists)'),'contain'=>array('CourseRegistration'=>array('order'=>array('CourseRegistration.created DESC'),'limit'=>1)),'fields'=>array('Student.id','Student.studentnumber','Student.full_name')));
			
		$count=0;
		$studentList=array();
		foreach($studentssections as $key => $student) {
		    if(empty($student['CourseRegistration']) ||
empty($student['CourseRegistration'][0]['year_level_id']) ) {
			$studentList['Student'][$count]['yearLevel']='1st';
		    } else {
		     // find the year level
		     $yearLevel=ClassRegistry::init('YearLevel')->field('YearLevel.name',array('YearLevel.id'=>$student['CourseRegistration'][0]['year_level_id']));
		   if(!empty($yearLevel)) {
                     $studentList['Student'][$count]['yearLevel']=$yearLevel;
		     }

			debug($yearLevel); 
		   }
		 $studentList['Student'][$count]['id']=$student['Student']['id'];
			
		  $count++;
		}
					
		if(!empty($studentList['Student'])) 
		{
		 //saveAll 
                 		 
		  if ($this->Student->saveAll($studentList['Student'],array('validate'=>false))) {

		   }
					  
		}
			
	}


     public function name_list() 
     {
		
	
	$this->paginate = array('contain'=>array('Department', 'Curriculum', 'ProgramType', 'Program','College'));
	
        if((isset($this->request->data['Student']) && isset($this->request->data['viewPDF']))) {
	  $search_session = $this->Session->read('search_data');
	  debug($search_session);
           $this->request->data['Student'] = $search_session;
	}
	
        if(isset($this->passedArgs)) {
	    if(isset($this->passedArgs['page'])) {	
		 	 $this->__init_search_name(); 
                         $this->request->data['Student']['page']=$this->passedArgs['page'];
                     $this->__init_search_name();
             } 
	} 

        if((isset($this->request->data['Student']) && isset($this->request->data['listStudentsForNameChange']))) {
	        $this->__init_search_name();
	}
       
	
	// filter by department or college
	if (isset($this->request->data['Student']['department_id']) && !empty($this->request->data['Student']['department_id'])) {
		$department_id = $this->request->data['Student']['department_id'];
		$college_id = explode('~', $department_id);
		if(count($college_id) > 1)
			$this->paginate['conditions'][]['Student.college_id'] = $college_id[1];
		else
			$this->paginate['conditions'][]['Student.department_id'] = $department_id;
	}
	// filter by program 
	if (isset($this->request->data['Student']['program_id']) && !empty($this->request->data['Student']['program_id'])) {
$this->paginate['conditions'][]['Student.program_id'] = $this->request->data['Student']['program_id'];
	}

	// filter by program type
	if (isset($this->request->data['Student']['program_type_id']) && !empty($this->request->data['Student']['program_type_id'])) {
		$this->paginate['conditions'][]['Student.program_type_id'] = $this->request->data['Student']['program_type_id'];
	}

	if (isset($this->request->data['Student']['studentnumber']) && !empty($this->request->data['Student']['studentnumber'])) {
        unset($this->paginate);
	$this->paginate['conditions'][]['Student.studentnumber'] = $this->request->data['Student']['studentnumber'];
	}

       if (isset($this->request->data['Student']['admission_year']) && !empty($this->request->data['Student']['admission_year'])) {
       debug($this->request->data['Student']['admission_year']);
	$this->paginate['conditions'][]['Student.admissionyear'] = $this->AcademicYear->getAcademicYearBegainingDate($this->request->data['Student']['admission_year'],'I');
	
       }
	

       if (isset($this->request->data['Student']['name']) && !empty($this->request->data['Student']['name'])) {
        unset($this->paginate);
           $this->paginate['conditions'][]['Student.first_name LIKE '] = trim($this->request->data['Student']['name']).'%';
	
       }
			
     if (isset($this->request->data['Student']['page']) && !empty($this->request->data['Student']['page'])) {
		$this->paginate['page'] = $this->request->data['Student']['page'];
	}              
    
	$this->Paginator->settings=$this->paginate;
	if (isset($this->request->data) && !empty($this->Paginator->settings['conditions'])) {
		
	    $students_for_name_list=$senateLists= $this->Paginator->paginate('Student');  
	}
	else {

		$students_for_name_list= array();

	}

        if (empty($students_for_name_list) && isset($this->request->data) && !empty($this->request->data)) {
          $this->Session->setFlash('<span></span>'.__('There is no student in the system based on the given criteria.'),'default',array('class'=>'info-box info-message'));
	}
      //debug($students_for_name_list);
       $programs = $this->Student->Program->find('list');
      $program_types = $this->Student->ProgramType->find('list');
      $departments = $this->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);

	$programs = array(0 => 'All Programs') + $programs;

	$program_types = array(0 => 'All Program Types') + $program_types;

	$departments = array(0 => 'All University Students') + $departments;

	$default_department_id = null;

	$default_program_id = null;

	$default_program_type_id = null;

	 if((isset($this->request->data['Student']) && isset($this->request->data['viewPDF']))) {
	    debug($students_for_name_list);
		foreach($students_for_name_list as $k=>$v) {
	         $g_d_obj = new DateTime($v['Student']['admissionyear']);
	        $admission_year=explode('-',$v['Student']['admissionyear']);
		$e_g_year= $this->EthiopicDateTime->GetEthiopicYear($g_d_obj->format('j'),$g_d_obj->format('n'), $g_d_obj->format('Y'));
		$g_academic_year=$this->AcademicYear->get_academicyear($admission_year[1],$admission_year[0]);

		$students_for_name_list_pdf[$v['Department']['name'].'~'.$v['Program']['name'].'~'.$v['ProgramType']['name'].'~'.$g_academic_year.'('.$e_g_year.'E.C)'][]=$v;

		}
      	$this->set(compact('students_for_name_list_pdf','defaultacademicyear'));
		$this->response->type('application/pdf');
		$this->layout='pdf';
		$this->render('name_list_pdf');
		
	  } 

	     $this->set(compact('programs', 'program_types', 'departments', 'students_for_name_list', 'default_department_id', 'default_program_id', 'default_program_type_id', 'senateLists'));

	}

       function __init_search_name() {
        // We create a search_data session variable when we fill any criteria  in the search form.
		if(!empty($this->request->data['Student'])) {
                 $search_session = $this->request->data['Student'];
                // Session variable 'search_data'
		 $this->Session->write('search_data', $search_session); 
		} else {

	        $search_session = $this->Session->read('search_data');
		  $this->request->data['Student'] = $search_session;
		}
       }

       function correct_name($id)
       {
        
         if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid vote'));
	    $this->redirect(array('action' => 'name_list'));
         }
        $check_elegibility_to_edit=0;
        if (!empty($this->college_ids)) { 
            $check_elegibility_to_edit=$this->Student->find (
            'count',array('conditions'=>array('Student.college_id'=>$this->college_ids,
            'Student.id'=>$id)));
           
        } else if ($this->department_ids) {
             $check_elegibility_to_edit=$this->Student->find (
            'count',array('conditions'=>array('Student.department_id'=>$this->department_ids,
            'Student.id'=>$id)));
           
            
        }
           
           
        if ($check_elegibility_to_edit==0) {
                 $this->Session->setFlash(__('<span></span> You are not elgibile to correct the student name. This happens when you are trying to edit students name which you are not assigned to edit.'),'default',array('class'=>'error-box error-message'));
            $this->redirect(array('action'=>'name_list'));
				               
        } 
	 if (!empty($this->request->data)) {
	    if ($this->Student->save($this->request->data)) {
		$this->Session->setFlash('<span></span>'.__('The student name has been updated.'),'default',array('class'=>'success-box success-message'));
		 $this->redirect($this->referer());
		 //$this->redirect(array('action' => 'name_list'));
	    } else {
			$this->Session->setFlash('<span></span>'.__('The student name could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
	    }
	 }
	 if (empty($this->request->data)) {
		$this->request->data = $this->Student->read(null, $id);
	 }

       }	

       function __auto_registration_update($publishedcourse_id) 
       {
		
		 $latest_academic_year = $this->AcademicYear->current_academicyear();
		$publishedCourseDetail=ClassRegistry::init('PublishedCourse')->find('first',array('conditions'=>array('PublishedCourse.id'=>$publishedcourse_id),'recursive'=>-1));

		$studentssections=ClassRegistry::init('StudentsSection')->find('all',array('conditions'=>array('StudentsSection.section_id'=>$publishedCourseDetail['PublishedCourse']['section_id']),'recursive'=>-1));
           	$count=0;
		$studentList=array();		
				
		foreach($studentssections as $k=>$v) {
			// registered 
			$registered=ClassRegistry::init('CourseRegistration')->find('first',array('conditions'=>array('CourseRegistration.published_course_id'=>$publishedcourse_id,'CourseRegistration.student_id'=>$v['StudentsSection']['student_id']),'recursive'=>-1));
		//print_r($registered);
			if(empty($registered)) {
			// does that student dismissed ?	
	                 $passed_or_failed=$this->Student->StudentExamStatus->getStudentLastExamStatus(
$v['StudentsSection']['student_id'],$latest_academic_year);
	  
	  if($passed_or_failed==1 || $passed_or_failed==3) {
		
		
		$studentList['CourseRegistration'][$count]['year_level_id']=$publishedCourseDetail['PublishedCourse']['year_level_id'];

$studentList['CourseRegistration'][$count]['section_id']=$publishedCourseDetail['PublishedCourse']['section_id'];


$studentList['CourseRegistration'][$count]['semester']=$publishedCourseDetail['PublishedCourse']['semester'];



$studentList['CourseRegistration'][$count]['academic_year']=$publishedCourseDetail['PublishedCourse']['academic_year'];


$studentList['CourseRegistration'][$count]['student_id']=$v['StudentsSection']['student_id'];

$studentList['CourseRegistration'][$count]['published_course_id']=$publishedCourseDetail['PublishedCourse']['id'];


$studentList['CourseRegistration'][$count]['created']=$publishedCourseDetail['PublishedCourse']['created'];
		

$studentList['CourseRegistration'][$count]['modified']=$publishedCourseDetail['PublishedCourse']['modified'];

			   }
			
                       } 
			$count++;
			//print_r($count);		
		}	
			
		if(!empty($studentList['CourseRegistration'])) 
		{
		 //saveAll 
                 		 
		  if (ClassRegistry::init('CourseRegistration')->saveAll($studentList['CourseRegistration'],array('validate'=>false))) {

		   }
					  
		}
			
    }
   
    public function scan_profile_picture(){
    	debug($this->request->data);
    	if (isset($this->request->data['Synchronize']) && !empty($this->request->data['Synchronize'])) {
    	/*
    	   $allImages=glob(WWW_ROOT."media/transfer/img/*.jpg");
    	   debug($allImages);
    	   foreach ($allImages as $image) {
    	   debug($image);
    	   $imageFileName=explode(WWW_ROOT.'media/transfer/img/', $image);
    	   	  
    	   	    $studentnumberWithImage=str_replace('-','/',$imageFileName[1]);
    	   	    $studentnumber=explode('.jpg', $studentnumberWithImage);
    	   	    debug($studentnumber);
    	   	}
    	   	*/
    	   $path=WWW_ROOT."media/transfer/img/";
    	   $allImages=$this->__getNewestFN($path);
    	   $count=0;
    	   foreach ($allImages as $image) {
    	   		//check if student is there
    	   	      $attachmentModel=array();
    	   	   
    	   	    $imageFileName=explode(WWW_ROOT.'media/transfer/img/', $image);
    	   	  
    	   	    $studentnumberWithImage=str_replace('-','/',$imageFileName[1]);
    	   	    $studentnumber=explode('.jpg', $studentnumberWithImage);
    	   	 
    	   		$student_number_exist=$this->Student->find('first',array('conditions'=>array('Student.studentnumber'=>$studentnumber[0])));
    	   		$filename=$imageFileName[1];
    	   		
    	   		
    	   		if(!empty($student_number_exist)){
    	   			  $isUploadedAlready= ClassRegistry::init('Photo')->find('first',array('conditions'=>array('Photo.model'=>'Student','Photo.foreign_key'=>$student_number_exist['Student']['id'],
    	   			  	'Photo.group'=>'profile')));
    	   			  if(!empty($isUploadedAlready)){
                         $attachmentModel['Photo']['id']=$isUploadedAlready['Photo']['id'];
    	   			  }
                      $attachmentModel['Photo']['model']='Student';
			          $attachmentModel['Photo']['foreign_key']=$student_number_exist['Student']['id'];
			          $attachmentModel['Photo']['dirname']='img';
			          $attachmentModel['Photo']['basename']=$filename;
			          $attachmentModel['Photo']['checksum']=md5($filename);
			          $attachmentModel['Photo']['group']='profile';

			           if(!empty($attachmentModel['Photo'])) {
                           if(empty($attachmentModel['Photo']['id'])) {
                               ClassRegistry::init('Photo')->create();
                            }
                            if(ClassRegistry::init('Photo')->save($attachmentModel)) {

                            $count++;
                       			
                            }
                        }
    	   		}
    	   
    		} 
    		if($count){
    		$this->Session->setFlash('<span></span>'.__('The dropped profile pictures of students has been completed by synchronizing '.$count.' file(s).'),'default',array('class'=>'success-box success-message'));
    		}
    	}
    }
    private function __getNewestFN ($path) {
		// store all .inf names in array
				 
		$files = glob($path.'*.{jpg}', GLOB_BRACE);
		usort($files, array($this, "_filemtime_compare"));
		
		return $files;
		/*
		$p = opendir($path);
	
		while (false !== ($file = readdir($p))) {
		$parts=pathinfo($file);
			debug($parts);
		if (strstr($file,".inf") && $parts['extension']=='jpg')
			$list[]=date("YmdHis ", filemtime($path.$file)).$path.$file; 
		}
		// sort array descending
		rsort($list);
		// return newest file name
		return $list[0];
		*/
	}
	private function _filemtime_compare($a, $b)
	{
		return filemtime($a) - filemtime($b);
	}
	public function mass_import_profile_picture() {
		
		 if (!empty($this->request->data)) 
         {
                    
                //check the file type before doing the fucken manipulations.
			     if(strcasecmp($this->request->data['Student']['xls']['type'],'application/vnd.ms-excel')) {
                     $this->Session->setFlash('<span></span>'.__('Importing Error. Please  save your excel file as "Excel 97-2003 Workbook" type while you saved the file and import again. Try also to use other 97-2003 file types if you are using office 2010 or recent versions. Current file format is: '.$this->request->data['Student']['File']['type']),'default', array('class'=>'error-box error-message'));
                    return ;
                }

				$data = new Spreadsheet_Excel_Reader();
                // Set output Encoding.
                $data->setOutputEncoding('CP1251');
                $data->read($this->request->data['Student']['xls']['tmp_name']);
		        $headings = array();
		        $xls_data = array();
				$non_existing_field=array();
                $required_fields = array('studentnumber','photonumber');
				
			     if(empty($data->sheets[0]['cells'])) {
                     $this->Session->setFlash('<span></span>'.__('Importing Error. The excel file 
                     you uploaded is empty.', true),'default', array('class'=>'error-box error-message'));
                    return ;
                }
                if(empty($data->sheets[0]['cells'][1])) {
                     $this->Session->setFlash('<span></span>'.
                     __('Importing Error. Please insert your filed name (studentnumber,photonumber)  at first row of your excel file.', true),'default', array('class'=>'error-box error-message'));
                    return ;
                }           
                     
                for($k=0;$k<count($required_fields); $k++){
                      if(in_array($required_fields[$k], $data->sheets[0]['cells'][1])===FALSE)
                        $non_existing_field[]=$required_fields[$k];
                }
               
                if(count($non_existing_field) > 0)
                  {
                      $field_list = "";
                      foreach($non_existing_field as $k=>$v) 
                            $field_list .= ($v.", ");
                      
                      $field_list = substr($field_list, 0, (strlen($field_list)-2));
                      $this->Session->setFlash('<span></span>'.__('Importing Error. '.$field_list.' is/are required in the excel file you imported at first row.', true),'default', array('class'=>'error-box error-message'));  
                      return;
                }
                else
                {

                    $fields_name_import_table=$data->sheets[0]['cells'][1];
		            $formatUploadedPicsPath=array();
					$uploadMaps=array();
                  
					for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                          $row_data=array();
					
                          for ($j = 1; $j <= count($fields_name_import_table); $j++) {

                                 if ($fields_name_import_table[$j] == "studentnumber" && 
                                $data->sheets[0]['cells'][$i][$j]=="") {
                               
                                $non_valide_rows[] = "Please enter a valid student number on row number ".$i;
                                continue;
                                
                                } else {
                                        /*
                                      $uploadMaps[$data->sheets[0]['cells'][$i][1]]=$data->sheets[0]['cells'][$i][2];
                                */

                                 if($fields_name_import_table[$j]=="studentnumber")
                                 {
                                    $row_data['studentnumber']=$data->sheets[0]['cells'][$i][$j];
                                
                                 }

                                  if($fields_name_import_table[$j]=="photonumber")
                                 {
                                    $row_data['photonumber']=$data->sheets[0]['cells'][$i][$j];
                                
                                 }


								}
						  }
                        
                          $uploadMaps[$row_data['studentnumber']]=$row_data['photonumber'];

					 }
                   $invalidStudentIds=array();
                   $validStudentIds=array();
				  if(!empty($uploadMaps)) { 
                     
					  $rowCount=1;
                      $attachmentModel=array();
					  foreach($uploadMaps as $kk=>$vv) {
                             //check if the student id exists 

                               $student_number_exist=$this->Student->find('first',
                   array('conditions'=>array('Student.studentnumber'=>$kk),'recursive'=>-1));
                         debug($student_number_exist);
                             // $formatUploadedPicsPath[]
                            if($student_number_exist) {
                              $uploadAndSavePicture=array();
                              foreach($this->request->data['Student']['File'] as $fk=>$fv) {
                                     $attachmentModel=array();
                                     if(stristr($fv['name'],$vv) !==FALSE ) {
                                    
	
                              $ext = substr(strtolower(strrchr($fv['name'], '.')), 1); //get the extension
                              $filenameNew=str_replace('/','-',$kk).'.'
                              .$ext;
						   
                        	  $arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions
                              //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {

                          

                              if(move_uploaded_file($fv['tmp_name'], WWW_ROOT."/media/transfer/img/".$filenameNew))
                              {

                                      $attachment=ClassRegistry::init('Photo')->find('first',
                   array('conditions'=>array('foreign_key'=>$student_number_exist['Student']['id'],'model'=>"Student"),'recursive'=>-1,'fields'=>array('id','model','dirname','basename',
'checksum','group')));
                                       if(!empty($attachment)) {
                                              $attachmentModel['Photo']['id']=$attachment['Photo']['id'];
                                       }
                                               
								        // do size validation and extension in here 

          $attachmentModel['Photo']['model']='Student';
          $attachmentModel['Photo']['foreign_key']=$student_number_exist['Student']['id'];
          $attachmentModel['Photo']['dirname']='img';
          $attachmentModel['Photo']['basename']=$filenameNew;
          $attachmentModel['Photo']['checksum']=md5($filenameNew);
          $attachmentModel['Photo']['group']='profile';
                          
                                          if(!empty($attachmentModel['Photo'])) {
                                               if(empty($attachmentModel['Photo']['id'])) {
                                                   ClassRegistry::init('Photo')->create();
                                                }
                                                if(ClassRegistry::init('Photo')->save($attachmentModel)) {
                                            $validStudentIds[$kk]=$rowCount;
                                                }
                                          }
                                   
                               } 

                             }
                                      
                                     } 
                              }
	                        } else {
                              $invalidStudentIds[$kk]=$rowCount;
                            }

                           $rowCount++;
				      }
				  }	
                      
                  if(!empty($validStudentIds)) {
						debug($invalidStudentIds);
                       $this->Session->setFlash('<span></span>Success. Uploaded '. count($validStudentIds) .' profile pictures.','default',array('class'=>'success-box success-message'));
                   }   
				}

         }

        $profilePictureUploaded=ClassRegistry::init('Attachment')->find('count',array('conditions'=>array('group'=>'profile','model'=>"Student",
'foreign_key  in (select id from students )'),'recursive'=>-1));

        $totalStudentCount=$this->Student->find('count',array('conditions'=>array('Student.id not in (select student_id from graduate_lists )'),'recursive'=>-1));
		
        $this->set(compact('profilePictureUploaded','totalStudentCount'));
	}

	
	public function activate_deactivate_profile($parameters) {
		 if(!empty($parameters)){
		 	  $student=$this->Student->find('first',array('conditions'=>array('Student.id'=>$parameters),'contain'=>array('User')));
		
		  if(!empty($student) && !empty($student['User']['id'])){
		          $this->Student->User->id = $student['User']['id'];
		          if($student['User']['active']==true){
		                 $this->Student->User->saveField('active',false); 
				  $this->Session->setFlash('<span></span>'.__('The student profile has been deactivated'), 'default',array('class'=>'success-box success-message'));  
		          } elseif($student['User']['active']==false) {
		               $this->Student->User->saveField('active',true);  
				  $this->Session->setFlash('<span></span>'.__('The student profile has been activated'), 'default',array('class'=>'success-box success-message'));  
		          }
			
		 } else {
			 $this->Session->setFlash('<span></span>'.__('The student was not issue username/password to his/her account so no need to activate/deactivate account'), 'default',array('class'=>'error-box error-message'));  
		 }
		
		$this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$student['Student']['id']));
	     }
	}
    public function id_card_print(){
    	 if (!empty($this->request->data) && !empty($this->request->data['getacceptedstudent'])) {
    	 	
             $options=array();
             $limit=100;
             if(!empty($this->request->data['Search']['academicyear'])){
             	 $options['conditions']['AcceptedStudent.academicyear']=$this->request->data['Search']['academicyear'];
             }
             if(!empty($this->request->data['Search']['department_id'])){
             	$college_id = explode('~', $this->request->data['Search']['department_id']);
				if(count($college_id) > 1) {
					$options['conditions']['AcceptedStudent.college_id']=$college_id[1];
				} else {
	              $options['conditions']['AcceptedStudent.department_id']=$college_id;
				} 
             }

             if(!empty($this->request->data['Search']['name'])){
             	 $options['conditions']['AcceptedStudent.first_name LIKE ']=$this->request->data['Search']['name'].'%';
             }

             if(!empty($this->request->data['Search']['program_type_id'])){
             	 $options['conditions']['AcceptedStudent.program_type_id']=$this->request->data['Search']['program_type_id'];
             }
              if(!empty($this->request->data['Search']['program_id'])){
             	 $options['conditions']['AcceptedStudent.program_id']=$this->request->data['Search']['program_id'];
             }
             if(!empty($this->request->data['Search']['limit'])){
             	 $limit=$this->request->data['Search']['limit'];
             }


             if(!empty($options)){
             	  	 $this->paginate = array('limit'=>$limit,
			  'maxLimit'=>$limit);


					
					 $this->paginate['conditions']=$options['conditions'];
					 $this->Paginator->settings=$this->paginate;
                     debug($this->Paginator->settings);
			         $acceptedStudents=$this->Paginator->paginate('AcceptedStudent');
			      if(empty($acceptedStudents)){
			      	  $this->Session->setFlash('<span></span>'.__('No result found.'), 'default',array('class'=>'error-box error-message'));  
			      }
                  $this->set(compact('acceptedStudents'));
             }

         }

          if (!empty($this->request->data) && !empty($this->request->data['printIDCard'])) {
          	   $studentsList=array();
          	
          		foreach ($this->request->data['AcceptedStudent']['approve'] as $key => $value) {
          			# code...
          			if($value==1){
          				$university['University']=ClassRegistry::init('University')->getAcceptedStudentUnivrsity($key);
          				$studentsList[$key]=array_merge($this->Student->AcceptedStudent->find('first',
          				array('conditions'=>array('AcceptedStudent.id'=>$key),
          					'contain'=>array('Student'=>array('Attachment'),'College',
          						'Department','Program',
          						'ProgramType'))),$university);
          			}
          			
          			
          		}

				if(empty($studentsList)) {
					$this->Session->setFlash('<span></span>'.__('There is no students to print ID card '), 'default', array('class'=>'info-box info-message'));
				}
				else {
					$this->set(compact('studentsList'));
					$this->response->type('application/pdf');
					$this->layout = '/pdf/default';
					$this->render('id_card_print_pdf');
					return;
				}
				
          }

         if($this->role_id==ROLE_SYSADMIN){
		 	$department_ids=ClassRegistry::init('Department')->find('list',array('fields'=>
		 		array('Department.id','Department.id')));
		 	
            $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$department_ids, $this->college_ids);
		 } else if (!empty($this->department_ids) || 
	!empty($this->college_ids)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_ids, $this->college_ids);
		 } else if(!empty($this->department_id)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_id, $this->college_id);
		 }  else {
            $departments=array();
		 }
		 $this->set(compact('departments'));
    }
	public function card_printing_report(){
		
	      if(isset($this->request->data['getReport']) 
	      	|| isset($this->request->data['getReportExcel'])) {
               if($this->request->data['Student']['report_type']=='IDPrintingCount' || $this->request->data['Student']['report_type']=='NOTPrinttedIDCount') {
                  if ($this->request->data['Student']['report_type']=='NOTPrinttedIDCount'){
               		 $this->request->data['Student']['printed_count']=0;
               		   $headerLabel=$this->__label('Not Printed ID Card Printing Statistics  for ',$this->request->data['Student']['acadamic_year'],
	               $this->request->data['Student']['program_type_id'],$this->request->data['Student']['program_id'],$this->request->data['Student']['department_id'],
	               $this->request->data['Student']['gender']);
               	   } else {
               	   	  $headerLabel=$this->__label('ID Card Printing Statistics  for ',$this->request->data['Student']['acadamic_year'],
	               $this->request->data['Student']['program_type_id'],$this->request->data['Student']['program_id'],$this->request->data['Student']['department_id'],
	               $this->request->data['Student']['gender']);
               	   }
                
                  $distributionIDPrintingCount=$this->Student->getIDPrintCount($this->request->data['Student']);
                   $years=$this->__years($this->request->data['Student']['department_id']);


                  $this->set(compact('distributionIDPrintingCount','years',
                  	'headerLabel'));

		         if($this->request->data['Student']['report_type']=='IDPrintingCount' && isset($this->request->data['getReportExcel'])){
			       		
				       	$this->autoLayout = false;
			            $filename='ID Card Printing Statistics -'.date('Ymd H:i:s');

			             $this->set(compact('distributionIDPrintingCount','years',
                  	'headerLabel','filename'));

						$this->render('/Elements/reports/xls/id_printing_stats_xls');
						return;	
			       } 

               } else if ($this->request->data['Student']['report_type']=='IDNotIssuedStudentList'){
                   $this->request->data['Student']['printed_count']=0;
               	   $headerLabel=$this->__label('ID Card Not Issued List ',$this->request->data['Student']['acadamic_year'],
	               $this->request->data['Student']['program_type_id'],$this->request->data['Student']['program_id'],$this->request->data['Student']['department_id'],
	               $this->request->data['Student']['gender']);

                   $idNotPrintedStudentList=$this->Student->getIDPrintCount($this->request->data['Student'],'list');
                   $years=$this->__years($this->request->data['Student']['department_id']);

                   $this->set(compact('idNotPrintedStudentList','years',
                  	'headerLabel'));

		         if($this->request->data['Student']['report_type']=='IDNotIssuedStudentList' && isset($this->request->data['getReportExcel'])){
		         	    $this->autoLayout = false;
			            $filename='ID Card Not Issued List -'.date('Ymd H:i:s');

			             $this->set(compact('idNotPrintedStudentList','years',
                  	'headerLabel','filename'));

						$this->render('/Elements/reports/xls/id_not_issued_student_list_xls');
						return;	
			       } 

               }

	      }
       	  $report_type_options = array(
    	  	'Statistics'=>array(
                  'IDPrintingCount' => 'ID Print Count',
                  'NOTPrinttedIDCount' => 'Not Printed ID Count',
                 
    	  	),
            'List'=>array(
                  'IDNotIssuedStudentList' => 'ID Card Not Issued Student List',
                  //'profileNotCompleted' => 'Profile Not Completed Student List',
    	  	),
    	  	 /*
    	  	'List'=>array(
                  'IDNotIssuedStudentList' => 'ID Card Not Issued Student List',
                  'profileNotCompleted' => 'Profile Not Completed Student List',
    	  	),
    	  	*/
    	  
    	 	);
          $programs = ClassRegistry::init('Program')->find('list');
		  $program_types = ClassRegistry::init('ProgramType')->find('list');
		  
		  //debug($academicStatuses);
		 if($this->role_id==ROLE_SYSADMIN){
		 	$department_ids=ClassRegistry::init('Department')->find('list',array('fields'=>
		 		array('Department.id','Department.id')));
		 	
            $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$department_ids, $this->college_ids);
		 } else if (!empty($this->department_ids) || 
	!empty($this->college_ids)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_ids, $this->college_ids);
		 } else if(!empty($this->department_id)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_id, $this->college_id);
		 }  else {
            $departments=array();
		 }
		$yearLevels =  ClassRegistry::init('YearLevel')->distinct_year_level(); 
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Students') + $departments;
		$yearLevels =   array(0 => 'All Year Level') + $yearLevels;
		
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
	        $default_year_level_id=null;
		$default_year_level_id=null;
		$default_region_id = null;
		$graph_type=array('bar'=>'Bar Chart','pie'=>'Pie Chart','line'=>'Line Chart');		
		  $this->set(compact('departments','academicStatuses','graph_type','default_region_id','program_types',
	'programs','default_program_type_id','graph_type','student_lists','default_program_id',
	'default_department_id','report_type_options','default_year_level_id','yearLevels'));
	}

	private function __years($college_idds){
		   $college_id = explode('~', $college_idds);
			if(count($college_id) > 1) {
			     $years =  ClassRegistry::init('YearLevel')->find('list',array('conditions'=>array('YearLevel.department_id in (select id from departments where college_id='.$college_id[1].' )'),
			     	'fields'=>array(
				'YearLevel.name','YearLevel.name')));
			} else if(!empty($college_idds)) {
                $years =  ClassRegistry::init('YearLevel')->find('list',array('conditions'=>array('YearLevel.department_id'=>$college_idds),
			     	'fields'=>array(
				'YearLevel.name','YearLevel.name')));
			} else {
				$years=ClassRegistry::init('YearLevel')->find('list',array(
			     	'fields'=>array(
				'YearLevel.name','YearLevel.name')));
			}
			return $years;
	}

	private function __label($prefix,$acadamic_year,$program_type_id,$program_id,$department_id,$gender){

		    $programs = ClassRegistry::init('Program')->find('list');
			$programTypes = ClassRegistry::init('ProgramType')->find('list');

		     $label='';
		     $name='';
		     $label.=$prefix.' '.$acadamic_year.' of ';
		     if($program_type_id==0){
		     	$label.='all program types ';
		     } else {
		     	$label.=$programTypes[$program_type_id];
		     }

		     if($program_id==0){
		     	$label.='undergraduate/graduate ';
		     } else {
		     	$label.='in '.$programs[$program_id];
		     	debug($program_id);
		     }


		     if($gender=="all"){
		     	//$label.=' both gender';
		     }

		    $college_id = explode('~', $department_id);
			if(count($college_id) > 1) {
			     $namee=ClassRegistry::init('College')->find('first',array('conditions'=>array('College.id'=>$college_id[1]),
			     	'recursive'=>-1));
			     $name.=' '.$namee['College']['name'];
			} else if(!empty($department_id)) {
                 $namee=ClassRegistry::init('Department')->find('first',array('conditions'=>array('Department.id'=>$department_id),
			     	'recursive'=>-1));
                  $name.=' '.$namee['Department']['name'];
			} else if($department_id==0) {
				$name.='for all department';
			}
            $label.=$name;
            return $label;
	}
	
	public function print_record(){
         $display_field_student['Display']=$this->Session->read('display_field_student');
        
         $students=$this->Session->read('students');
         if(!empty($students)){
         	$university['University'] = ClassRegistry::init('University')->getStudentUnivrsity($students[0]['Student']['id']);
         	$colleges=$this->Student->College->find('first',
         		array('conditions'=>array('College.id'=>$students[0]['Student']['college_id']),'recursive'=>-1));
         	$departments=$this->Student->Department->find('first',
         		array('conditions'=>array('Department.id'=>$students[0]['Student']['department_id']),'recursive'=>-1));
         	$this->set(compact('students','display_field_student','university','departments','colleges'));
			$this->response->type('application/pdf');
		 	$this->layout = '/pdf/default';
			$this->render('print_students_list_pdf');
			    return ;
         }       
	}
	public function ajax_check_ecardnumber(){
		$this->layout = 'ajax';
        $value='Invalid';
		if (!empty($this->data)) {
			if (!empty($this->data['Student']['ecardnumber'])) {
				$u = $this->Student->find('first',
					array('conditions'=>array('Student.ecardnumber'=>
						$this->data['Student']['ecardnumber'])));
				
				if (empty($u)) {
					$value='Valid';
				} 
			}
		}
		$this->set(compact('value'));
	}

	/*
	public function push_students_cafe_entry() {

    	 if (!empty($this->request->data) && !empty($this->request->data['getStudent'])) 
    	 {
    	 	
             $options=array();
             $limit=100;
             if(!empty($this->request->data['Search']['academicyear'])){
             	 $options['conditions']['Student.admissionyear']=$this->AcademicYear->get_academicYearBegainingDate($this->request->data['Search']['academicyear']);
             }
             if(!empty($this->request->data['Search']['currentAcademicYear'])
             	&& !empty($this->request->data['Search']['currentAcademicYear'])){
             	
             	$cafe=$this->request->data['Search']['cafe'];
             
             	$options['conditions'][] = 'Student.id in (select student_id from course_registrations where academic_year="'.$this->request->data['Search']['currentAcademicYear'].'" and semester="'.$this->request->data['Search']['semester'].'" and cafeteria_consumer='.$cafe.') and Student.ecardnumber is not null';

             }
             if(!empty($this->request->data['Search']['department_id'])){
             	$college_id = explode('~', $this->request->data['Search']['department_id']);
				if(count($college_id) > 1) {
					$options['conditions']['Student.college_id']=$college_id[1];
				} else {
	              $options['conditions']['Student.department_id']=$college_id;
				} 
             }

             if(!empty($this->request->data['Search']['name'])){
             	 $options['conditions']['Student.first_name LIKE ']=$this->request->data['Search']['name'].'%';
             }

             if(!empty($this->request->data['Search']['program_type_id'])){
             	 $options['conditions']['Student.program_type_id']=$this->request->data['Search']['program_type_id'];
             }
             if(!empty($this->request->data['Search']['program_id'])){
             	 $options['conditions']['Student.program_id']=$this->request->data['Search']['program_id'];
             }
             if(!empty($this->request->data['Search']['limit'])){
             	 $limit=$this->request->data['Search']['limit'];
             }


             if(!empty($options)){
             	  	 $this->paginate = array('limit'=>$limit,
			  'maxLimit'=>$limit);		
					 $this->paginate['conditions']=$options['conditions'];
					 $this->Paginator->settings=$this->paginate;
                    
			      $students=$this->Paginator->paginate('Student');
			      if(empty($students)){
			      	  $this->Session->setFlash('<span></span>'.__('No result found.'), 'default',array('class'=>'error-box error-message'));  
			      }
                  $this->set(compact('students'));
             }
         }

        if (!empty($this->request->data) && !empty($this->request->data['pushStudentsToCafeGate'])) {
          	   $studentsList=array();
          	   $db = ConnectionManager::getDataSource("mssql");
          	   foreach ($this->request->data['Student']['approve'] as $key => $value) {
          			if($value==1){
          				$studentsList=1;
          				$studentInfo=$this->Student->find('first',array('conditions'=>array('Student.id'=>$key),'contain'=>array('College')));
          				$mealHallAssigned=$this->Student->MealHallAssignment->find('first',array('conditions'=>array('MealHallAssignment.student_id'=>$key,'MealHallAssignment.academic_year'=>$this->request->data['Search']['currentAcademicYear']),'recursive'=>-1));

          			    $studentQuery="SELECT TOP(1) SLN_Employee FROM dbo.MSTR_Employee AS S WHERE Employee_Code='".$studentInfo['Student']['studentnumber']."'";
		                //[Access_Level4]
		  				$studentResult = $db->query($studentQuery);
		  				if(!empty($studentResult[0][0]['SLN_Employee'])){
		  					    // does the student exist ?
		  						
          			    		$cardSQL="SELECT TOP(1) SLN_Employee FROM ACS_Cards_Info AS S WHERE SLN_Employee='".$studentResult[0][0]['SLN_Employee']."'";

          			    		$cardResult = $db->query($cardSQL);
          			    		if($this->request->data['Search']['allow']==1){
          			    			  $accessLevel4Cafe=isset($mealHallAssigned['MealHallAssignment']['meal_hall_id']) ? $mealHallAssigned['MealHallAssignment']['meal_hall_id']:0 ;
          			    				
          			    		} else {
          			    			$accessLevel4Cafe=0;
          			    		}
          			    		

          			    		if(!empty($cardResult[0][0]['SLN_Employee'])){
          			    			$cafeAccessSQL="UPDATE ACS_Cards_Info
SET Access_Level4 = ".$accessLevel4Cafe." WHERE SLN_Employee=".$cardResult[0][0]['SLN_Employee']."";
								
          			    		} else{
          			    				// do inseration to ess db
		  						$slnEmployee=$studentResult[0][0]['SLN_Employee'];
		  						$cardNumber=$studentInfo['Student']['ecardnumber'];
		  						$facilityID=$studentInfo['College']['campus_id'];
		  						$accessLevel1CommonGate=13;
		  						$accessLevel2AllStudentGate=9;
		  						$accessLevel3AllLibGate=5;
		  						
		  						$accessLevel5=0;
		  						$accessLevel6=0;
		  						$accessLevel7=0;
		  						$accessLevel8=0;
		  	
		  					   $cafeAccessSQL="INSERT INTO ACS_Cards_Info(SLN_Employee,Card_Number,Facility_ID,Access_Level1,Access_Level2,Access_Level3,Access_Level4,Access_Level5,Access_Level6,Access_Level7,Access_Level8) VALUES ('$slnEmployee','$cardNumber','$facilityID','$accessLevel1CommonGate','$accessLevel2AllStudentGate','$accessLevel3AllLibGate','$accessLevel4Cafe','$accessLevel5','$accessLevel6','$accessLevel7','$accessLevel8')";
          			    	}
          			    	$cafeQuery = $db->query($cafeAccessSQL);
          			    	debug($cafeQuery);

		  				}
          			}
          		}

				if(empty($studentsList)) {
					$this->Session->setFlash('<span></span>'.__('Please select the students you would like to allow/deny cafe gate.'), 'default', array('class'=>'info-box info-message'));
				}
				else {
					$this->Session->setFlash('<span></span>'.__('The selected students has been allowed/denied cafe gate and update has been propagated to devices.'), 'default', array('class'=>'success-box success-message')); 
				}
				
          }


         if($this->role_id==ROLE_SYSADMIN){
		 	$department_ids=ClassRegistry::init('Department')->find('list',array('fields'=>
		 		array('Department.id','Department.id')));
		 	
            $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$department_ids, $this->college_ids);
		 } else if (!empty($this->department_ids) || 
	!empty($this->college_ids)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_ids, $this->college_ids);
		 } else if(!empty($this->department_id)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_id, $this->college_id);
		 }  else {
            $departments=array();
		 }
		 $this->set(compact('departments'));
    }
    */

    public function push_students_cafe_entry() {
    	 $this->_mssql();
    	 if (!empty($this->request->data) && !empty($this->request->data['getStudent'])) 
    	 {
    	 	
             $options=array();
             $limit=100;
             if(!empty($this->request->data['Search']['academicyear'])){
             	 $options['conditions']['Student.admissionyear']=$this->AcademicYear->get_academicYearBegainingDate($this->request->data['Search']['academicyear']);
             }
             if(!empty($this->request->data['Search']['currentAcademicYear'])
             	&& !empty($this->request->data['Search']['currentAcademicYear'])){
             	
             	$cafe=$this->request->data['Search']['cafe'];
             
             	$options['conditions'][] = 'Student.id in (select student_id from course_registrations where academic_year="'.$this->request->data['Search']['currentAcademicYear'].'" and semester="'.$this->request->data['Search']['semester'].'" and cafeteria_consumer='.$cafe.') and Student.ecardnumber is not null';

             }
             if(!empty($this->request->data['Search']['department_id'])){
             	$college_id = explode('~', $this->request->data['Search']['department_id']);
				if(count($college_id) > 1) {
					$options['conditions']['Student.college_id']=$college_id[1];
				} else {
	              $options['conditions']['Student.department_id']=$college_id;
				} 
             }

             if(!empty($this->request->data['Search']['name'])){
             	 $options['conditions']['Student.first_name LIKE ']=$this->request->data['Search']['name'].'%';
             }

             if(!empty($this->request->data['Search']['program_type_id'])){
             	 $options['conditions']['Student.program_type_id']=$this->request->data['Search']['program_type_id'];
             }
             if(!empty($this->request->data['Search']['program_id'])){
             	 $options['conditions']['Student.program_id']=$this->request->data['Search']['program_id'];
             }
             if(!empty($this->request->data['Search']['limit'])){
             	 $limit=$this->request->data['Search']['limit'];
             }


             if(!empty($options)){
             	  	 $this->paginate = array('limit'=>$limit,
			  'maxLimit'=>$limit);		
					 $this->paginate['conditions']=$options['conditions'];
					 $this->Paginator->settings=$this->paginate;
                    
			      $students=$this->Paginator->paginate('Student');
			      if(empty($students)){
			      	  $this->Session->setFlash('<span></span>'.__('No result found.'), 'default',array('class'=>'error-box error-message'));  
			      }
                  $this->set(compact('students'));
             }
         }

        if (!empty($this->request->data) && !empty($this->request->data['pushStudentsToCafeGate'])) {
          	   $studentsList=array();
          	   
          	   foreach ($this->request->data['Student']['approve'] as $key => $value) {
          			if($value==1){
          				$studentsList=1;
          				$studentInfo=$this->Student->find('first',array('conditions'=>array('Student.id'=>$key),'contain'=>array('College')));
          				$mealHallAssigned=$this->Student->MealHallAssignment->find('first',array('conditions'=>array('MealHallAssignment.student_id'=>$key,'MealHallAssignment.academic_year'=>$this->request->data['Search']['currentAcademicYear']),'recursive'=>-1));

          			    $studentQuery="SELECT TOP(1) SLN_Employee FROM dbo.MSTR_Employee AS S WHERE Employee_Code='".$studentInfo['Student']['studentnumber']."'";
		                //[Access_Level4]
		  				$resultSetReturn = $this->_mssql($studentQuery);
		  			
		  				while ($row = mssql_fetch_assoc($resultSetReturn)) {
                            $studentResult[0][0]['SLN_Employee']=$row['SLN_Employee'];
		  				}
		  				mssql_free_result($resultSetReturn);
		  				if(!empty($studentResult[0][0]['SLN_Employee'])){
		  					    // does the student exist ?
		  						
          			    		$cardSQL="SELECT TOP(1) SLN_Employee FROM ACS_Cards_Info AS S WHERE SLN_Employee='".$studentResult[0][0]['SLN_Employee']."'";

          			    	//	$cardResult = $db->query($cardSQL);
          			    		$cardResultSet = $this->_mssql($cardSQL);
          			    		while ($row = mssql_fetch_assoc($resultSetReturn)) {
                           			 $cardResult[0][0]['SLN_Employee']=$row['SLN_Employee'];
		  						}
		  						mssql_free_result($cardResultSet);
          			    		if($this->request->data['Search']['allow']==1){
          			    			  $accessLevel4Cafe=isset($mealHallAssigned['MealHallAssignment']['meal_hall_id']) ? $mealHallAssigned['MealHallAssignment']['meal_hall_id']:0 ;
     
          			    		} else {
          			    			$accessLevel4Cafe=0;
          			    		}
          			    		

          			    		if(!empty($cardResult[0][0]['SLN_Employee'])){
          			    			$cafeAccessSQL="UPDATE ACS_Cards_Info
SET Access_Level4 = ".$accessLevel4Cafe." WHERE SLN_Employee=".$cardResult[0][0]['SLN_Employee']."";
								
          			    		} else{
          			    				// do inseration to ess db
		  						$slnEmployee=$studentResult[0][0]['SLN_Employee'];
		  						$cardNumber=$studentInfo['Student']['ecardnumber'];
		  						$facilityID=$studentInfo['College']['campus_id'];
		  						$accessLevel1CommonGate=13;
		  						$accessLevel2AllStudentGate=9;
		  						$accessLevel3AllLibGate=5;
		  						
		  						$accessLevel5=0;
		  						$accessLevel6=0;
		  						$accessLevel7=0;
		  						$accessLevel8=0;
		  	
		  					   $cafeAccessSQL="INSERT INTO ACS_Cards_Info(SLN_Employee,Card_Number,Facility_ID,Access_Level1,Access_Level2,Access_Level3,Access_Level4,Access_Level5,Access_Level6,Access_Level7,Access_Level8) VALUES ('$slnEmployee','$cardNumber','$facilityID','$accessLevel1CommonGate','$accessLevel2AllStudentGate','$accessLevel3AllLibGate','$accessLevel4Cafe','$accessLevel5','$accessLevel6','$accessLevel7','$accessLevel8')";
          			    	}
          			    	$cafeQuery = $this->_mssql($cafeAccessSQL);
          			    	debug($cafeQuery);

		  				}
          			}
          		}

				if(empty($studentsList)) {
					$this->Session->setFlash('<span></span>'.__('Please select the students you would like to allow/deny cafe gate.'), 'default', array('class'=>'info-box info-message'));
				}
				else {
					$this->Session->setFlash('<span></span>'.__('The selected students has been allowed/denied cafe gate and update has been propagated to devices.'), 'default', array('class'=>'success-box success-message')); 
				}
				 mssql_close($this->conn);
          }


         if($this->role_id==ROLE_SYSADMIN){
		 	$department_ids=ClassRegistry::init('Department')->find('list',array('fields'=>
		 		array('Department.id','Department.id')));
		 	
            $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$department_ids, $this->college_ids);
		 } else if (!empty($this->department_ids) || 
	!empty($this->college_ids)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_ids, $this->college_ids);
		 } else if(!empty($this->department_id)) {
		     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
			$this->department_id, $this->college_id);
		 }  else {
            $departments=array();
		 }
		 $this->set(compact('departments'));
		
    }

    public function change($id=null){

    	if(!empty($this->request->data)){
    		$data=$this->request->data;
    		$this->request->data= $this->Student->find('first',array('conditions'=>array('Student.id'=> $this->student_id),
			'contain'=>array('Contact')));
    		$this->request->data['Student']['ecardnumber']=$data['Student']['ecardnumber'];
    		$this->request->data['Student']['phone_mobile']=$data['Student']['phone_mobile'];
    		//$this->request->data['Contact'][0]['phone_mobile']=$data['Contact'][0]['phone_mobile'];	
			
    	}
    	
    

		if (!empty($this->request->data) && $this->Student->save($this->request->data)){
		 		$this->Session->setFlash('<span></span>'.__('The ecardnumber and mobile phone number was updated successfully'),'default',array('class'=>'success-box success-message'));
		 		$this->redirect('/');
		} else if(!empty($this->request->data)) {
			 $this->Session->setFlash('<span></span>'.__('Your data could not be saved.Please, try again.', true),'default',array('class'=>'error-box error-message'));
			
		}
		$this->request->data = $this->Student->find('first',array('conditions'=>array('Student.id'=> $this->student_id),
			'contain'=>array('Contact',
			'Attachment')));

    }
	
	public function update_koha_db() {
		
		if(!empty($this->request->data) && !empty($this->request->data['updateKohaDB'])) {
             
             $status=$this->Student->extendKohaBorrowerExpireDate($this->request->data['AcceptedStudent']['approve']); 
             
             if($status){
               $this->Session->setFlash(__('<span></span>You have successfully update book borrower database.'),'default',array('class'=>'success-box success-message'));
             }
            
            
        }
        debug($this->request->data);
        if (!empty($this->request->data) && !empty($this->request->data['getacceptedstudent'])) {
          if (!empty($this->request->data['Search']['college_id'])) {
          	 $conditions['AcceptedStudent.college_id']=$this->request->data['Search']['college_id'];
          }
          if (!empty($this->request->data['Search']['name'])) {
          	 $conditions['AcceptedStudent.first_name like ']=$this->request->data['Search']['name'].'%';
          }
          if (!empty($this->request->data['Search']['academicyear'])) {
          	 $conditions['AcceptedStudent.academicyear like ']=$this->request->data['Search']['academicyear'].'%';
          }
          if (!empty($this->request->data['Search']['program_id'])) {
          	 $conditions['AcceptedStudent.program_id']=$this->request->data['Search']['program_id'];
          }
         if (!empty($this->request->data['Search']['program_type_id'])) {
          	 $conditions['AcceptedStudent.program_type_id']=$this->request->data['Search']['program_type_id'];
          }
          if (!empty($conditions)) {
		      if(isset(
		      $this->request->data['Search']['limit'])) {
						$limit=$this->request->data['AcceptedStudent']['limit'];
			  } else {
				       $limit=1800;
			  }
			 $acceptedStudentIds=$this->Student->AcceptedStudent->find('list',array('conditions'=>$conditions,
			 'limit'=>$limit,
			 'maxLimit'=>$limit,
			 'fields'=>array('AcceptedStudent.id',
			 'AcceptedStudent.id'
			 )
			 ));
			
            $students=ClassRegistry::init('StudentExamStatus')->getMostRecentStudentStatusForKoha($acceptedStudentIds,1);
           
           
            if(!empty($students)){
               $acceptedStudents=$students;
               $this->set(compact('acceptedStudents'));
            } else {
               $this->Session->setFlash(__('<span></span>No data is found with your search criteria that needs update, either all students has been updated or they are not qualified for borrower extension.'),'default',array('class'=>'info-box info-message'));
            }
		  } 
          
         //debug($conditions);
             
		}
         // display the right department and college based on the privilage of registrar users
	  $colleges = $this->Student->College->find('list');
	  $departments = $this->Student->Department->find('list'); 
       $this->set(compact('colleges','departments'));
		  
	   $programs = $this->Student->Program->find('list');
		 //  $programTypes =$this->Student->ProgramType->find('list');
		   $this->set(compact('programs',
		   'programTypes','colleges','departments'));	
	
	}
	
		public function update_lms_db() {
		
			if(!empty($this->request->data) && !empty($this->request->data['updateLMSDB'])) {
		          /*
		         $status=$this->Student->extendKohaBorrowerExpireDate($this->request->data['AcceptedStudent']['approve']); 
		         
		         if($status){
		           $this->Session->setFlash(__('<span></span>You have successfully update LMS system.'),'default',array('class'=>'success-box success-message'));
		         }   
		         */
		         debug($this->request->data);
		         $department_ids=$this->Student->Department->find('list',array('conditions'=>array('Department.college_id'=>$this->request->data['Search']['college_id']),
		         'fields'=>array('Department.id','Department.id')
		         ));
		         debug($department_ids);
		        $db = ConnectionManager::getDataSource('lms'); 
		         // find published courses and update the courses table 
		         $publishedCourseList=ClassRegistry::init('PublishedCourse')->find('all',
		         array('conditions'=>array(
					'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
					'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
					'PublishedCourse.department_id'=>$department_ids,
					'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
					'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id'],		
		         ),
		         'contain'=>array(
		          'Course',
		         'CourseInstructorAssignment'=>array('Staff'=>array('User','Department','College',
		         'City','Country')),
		         )
		         ));
				//debug($publishedCourseList);
				foreach($publishedCourseList as $pk=>$pv){
				
					//feed course list 
					if(isset($pv['PublishedCourse']['id']) && !empty($pv['PublishedCourse']['id'])) {
						// course inseration 
						    $sqlCourseRecorded= "SELECT count(*),courseid FROM  courses as course 
							where courseid=".$pv['PublishedCourse']['id']."";
							$resultCourseRecorded= $db->query($sqlCourseRecorded);
							if($resultCourseRecorded[0][0]['count(*)']==0){
							   //create the course if not existed.
							   $fullname=$pv['Course']['course_title'];
							   $shortname=$pv['Course']['course_code'];
							   $pid=$pv['PublishedCourse']['id'];
							   $createCourseSql="INSERT INTO  `courses` (`id`,
							   `fullname`,`shortname`,`courseid`) VALUES (NULL,
							   \"$fullname\",\"$shortname\",\"$pid\")";
							   $resultinsert = $db->query($createCourseSql); 
							  
							} else {
									// nothing to do for now but we need to update course detail required
							}
					}
				   //instructor enrollement done
				   if(isset($pv['CourseInstructorAssignment']) && 
				   !empty($pv['CourseInstructorAssignment'])){
				     //check if the instructor is primary and enroll it 
				      
				     foreach($pv['CourseInstructorAssignment'] as $cia=>$civ){
					     //is that primary instructor
					     debug($civ);    
					     if($civ['isprimary'] && isset($civ['Staff']['User']['username']) 
					     && !empty($civ['Staff']['User']['username']) ){
					       
					        $sqlUserTeacher= "SELECT count(*),username FROM  users as user 
							where username='".$civ['Staff']['User']['username']."'";
							$resultUserTeacher = $db->query($sqlUserTeacher);
						
							if($resultUserTeacher[0][0]['count(*)']==0){
							   // create user 
							   
							   $username=$civ['Staff']['User']['username'];
							   $password=$civ['Staff']['User']['password'];
							   $firstname=$civ['Staff']['first_name'];$lastname=$civ['Staff']['last_name'];
							   $email=$civ['Staff']['email'];
							   $city=$civ['Staff']['City']['name'];
							   $country=$civ['Staff']['Country']['name'];
							   $institution=$civ['Staff']['College']['name'];$department=$civ['Staff']['Department']['name'];
							   $mobile=$civ['Staff']['phone_mobile'];$phone=$civ['Staff']['phone_office'];
							   $amharicfirstname=$civ['Staff']['first_name'];
							   $amhariclastname=$civ['Staff']['last_name'];$middlename=$civ['Staff']['middle_name'];
							   $address=$civ['Staff']['address'];
							   
							   $createUsersSql="INSERT INTO  `users` (`id`,`username`,`password`,
							   `firstname`,`lastname`,`email`,`city`,`country`
							   ,`idnumber`,`institution`,`department`,
							   `mobile`,`phone`,
							   `amharicfirstname`,
							   `amhariclastname`,
							   `middlename`,
							   `address`) VALUES (NULL,
							   \"$username\",\"$password\",
							   \"$firstname\",\"$lastname\",\"$email\",
							   \"$city\",\"$country\",\"$username\",
							\"$institution\",\"$department\",\"$mobile\",\"$phone\",
							\"$amharicfirstname\",
							\"$amhariclastname\",
							\"$middlename\",
							\"$address\"
							)";
							  $resultinsert = $db->query($createUsersSql); 							   
							}
						    debug($civ);
							//Is s/he already enrolled
							$courseId=$civ['published_course_id'];
							$idNumber=$civ['Staff']['User']['username'];
							$role_name='teacher';
							debug($courseId);
							$sqlEnrollTeacher= "SELECT count(*),
							course_id FROM  enrollment as enroll 
							where course_id=".$civ['published_course_id']." 
							and id_number='".$civ['Staff']['User']['username']."' 
							and role_name='teacher'";
							$resultEnrollTeacher = $db->query($sqlEnrollTeacher);
							debug($resultEnrollTeacher);
							$insertToEnrollementTeacher="INSERT INTO  `enrollment` (`id`,`course_id`,`id_number`,`role_name`) VALUES (NULL,
							\"$courseId\",\"$idNumber\",
							\"$role_name\")";
							
							debug($resultEnrollTeacher);

							$resultinsert = $db->query($insertToEnrollementTeacher); 

							if($resultEnrollTeacher[0][0]['count(*)']==0){
								// never enrolled for the course as teacher
								  $resultTeachers = $db->query($insertToEnrollementTeacher); 		
							} else {
								//update the new instructor
							}
							
					     }
				     }
				  }  
				  
				
				  //student enrollement 
				
				 $registeredStudentList=ClassRegistry::init('CourseRegistration')->find('all',
				 array('conditions'=>array('CourseRegistration.published_course_id'=>
				 $pv['PublishedCourse']['id']),
		         'contain'=>array('Student'=>array('User','Department','College','City','Country'))
		         ));
		         	if(isset($registeredStudentList) && 
		         	!empty($registeredStudentList)){
					   foreach($registeredStudentList as $regk=>$regv){
					        
					        $sqlUserStudent= "SELECT count(*),username FROM  users as user 
							where username='".$regv['Student']['User']['username']."'";
							$resultUserStudent = $db->query($sqlUserStudent);
						
							if($resultUserStudent[0][0]['count(*)']==0){
							   // create user 
							   
							   $username=$regv['Student']['User']['username'];
							   $password=$regv['Student']['User']['password'];
							   $firstname=$regv['Student']['first_name'];
							   $lastname=$regv['Student']['last_name'];
							   $email=$regv['Student']['email'];
							   $city=$regv['Student']['City']['name'];
							   $country=$regv['Student']['Country']['name'];
							   $institution=$regv['Student']['College']['name'];
							   $department=$regv['Student']['Department']['name'];
							   $mobile=$regv['Student']['phone_mobile'];$phone=$regv['Student']['phone_home'];
							   $amharicfirstname=$regv['Student']['amharic_first_name'];
							   $amhariclastname=$regv['Student']['amharic_last_name'];$middlename=$regv['Student']['amharic_middle_name'];
							   $address=$regv['Student']['address1'];
							   
							   $createUsersStudentSql="INSERT INTO  `users` (`id`,`username`,`password`,
							   `firstname`,`lastname`,`email`,`city`,`country`
							   ,`idnumber`,`institution`,`department`,
							   `mobile`,`phone`,
							   `amharicfirstname`,
							   `amhariclastname`,
							   `middlename`,
							   `address`) VALUES (NULL,
							   \"$username\",\"$password\",
							   \"$firstname\",\"$lastname\",\"$email\",
							   \"$city\",\"$country\",\"$username\",
							\"$institution\",\"$department\",\"$mobile\",\"$phone\",
							\"$amharicfirstname\",
							\"$amhariclastname\",
							\"$middlename\",
							\"$address\"
							)";
							  $resultinsert = $db->query($createUsersStudentSql); 							   
							}
						   
							//Is s/he already enrolled
							$courseId=$regv['CourseRegistration']['published_course_id'];
							$idNumber=$regv['Student']['User']['username'];
							$role_name='student';
							$sqlEnrollStudent= "SELECT count(*),
							course_id FROM  enrollment as enroll 
							where course_id=".$regv['CourseRegistration']['published_course_id']." 
							and id_number='".$regv['Student']['User']['username']."' 
							and role_name='student'";
							$resultEnrollStudent = $db->query($sqlEnrollStudent);
						
							if($resultEnrollStudent[0][0]['count(*)']==0){
								// never enrolled for the course as teacher
                              $insertToEnrollementStudent="INSERT INTO  `enrollment` (`id`,`course_id`,`id_number`,`role_name`) VALUES (NULL,
								\"$courseId\",\"$idNumber\",
								\"$role_name\")";

								$resultinsertS = $db->query($insertToEnrollementStudent); 
		
							} else {
								//update the new instructor
							}
						     //debug($regv);
					       //die;
					   }
				    }
				  
				}
		         
		         
		         
		    }
		    /*
			if (!empty($this->request->data) && !empty($this->request->data['getacceptedstudent'])) 
			{
			  if (!empty($this->request->data['Search']['college_id'])) {
			  	 $conditions['AcceptedStudent.college_id']=$this->request->data['Search']['college_id'];
			  }
			  if (!empty($this->request->data['Search']['name'])) {
			  	 $conditions['AcceptedStudent.first_name like ']=$this->request->data['Search']['name'].'%';
			  }
			  if (!empty($this->request->data['Search']['academicyear'])) {
			  	 $conditions['AcceptedStudent.academicyear like ']=$this->request->data['Search']['academicyear'].'%';
			  }
			  if (!empty($this->request->data['Search']['program_id'])) {
			  	 $conditions['AcceptedStudent.program_id']=$this->request->data['Search']['program_id'];
			  }
			  if (!empty($this->request->data['Search']['program_type_id'])) {
			  	 $conditions['AcceptedStudent.program_type_id']=$this->request->data['Search']['program_type_id'];
			  }
			  if (!empty($conditions)) {
				  if(isset(
				  $this->request->data['Search']['limit'])) {
							$limit=$this->request->data['AcceptedStudent']['limit'];
				  } else {
						   $limit=1800;
				  }
				 $acceptedStudentIds=$this->Student->AcceptedStudent->find('list',array('conditions'=>$conditions,
				 'limit'=>$limit,
				 'maxLimit'=>$limit,
				 'fields'=>array('AcceptedStudent.id',
				 'AcceptedStudent.id'
				 )
				 ));
		
				$students=ClassRegistry::init('StudentExamStatus')->getMostRecentStudentStatusForKoha($acceptedStudentIds,1);
			   
			   
				if(!empty($students)){
				   $acceptedStudents=$students;
				   $this->set(compact('acceptedStudents'));
				} else {
				   $this->Session->setFlash(__('<span></span>No data is found with your search criteria that needs update, either all students has been updated or they are not qualified for borrower extension.'),'default',array('class'=>'info-box info-message'));
				}
			  } 
			  
			 //debug($conditions);
				 
			}
			*/
			 // display the right department and college based on the privilage of registrar users
		  $colleges = $this->Student->College->find('list');
		  $departments = $this->Student->Department->find('list'); 
		   $this->set(compact('colleges','departments'));
			  
		   $programs = $this->Student->Program->find('list');
			 //  $programTypes =$this->Student->ProgramType->find('list');
			   $this->set(compact('programs',
			   'programTypes','colleges','departments'));	
	
	}
	
    private function _mssql($query){
	 		//connect to the database 
	 		$this->conn=mssql_connect($this->config['host'],$this->config['login'],$this->config['password']);
	 		$selectDB=mssql_select_db($this->config['database'],$this->conn);
	 		$result=mssql_query($query);
	 		return  $result;

	 }
	 private function _config(){
            $this->config['host'] = '10.144.5.210';
			$this->config['login'] = 'sa';
			$this->config['password'] = 'admin@123';
			$this->config['database']='ESS';
	 }
}
