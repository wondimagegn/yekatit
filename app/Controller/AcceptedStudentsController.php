<?php
App::import('Vendor', 'PhpExcelReader/Excel/reader');
class AcceptedStudentsController extends AppController {
    public $name = 'AcceptedStudents';
    public $helpers = array('Xls');
    public $paginate = array();    
    public $menuOptions = array(
            
             'parent' => 'placement',
             'exclude' => array('search',
             'print_autoplaced_pdf','export_autoplaced_xls','download','print_students_number_pdf',
             'export_students_number_xls'),
             'alias' => array(
                    'index'=>'List Accepted Students',
                    'add'=>'Add Accepted Students',
                    'generate'=>'Generate Student Id',
                    'import_newly_students'=>'Import Newly Accepted Students',
                    'direct_placement' => 'Direct Department Placement',
                    'auto_placement' => 'Auto Department Placement',
                    'cancel_auto_placement'=>'Cancel Auto Placement',
					'auto_placement_approve_college'=>'Approve Auto Placement/View',
					'export_print_students_number'=>'Export/Print Students Id',
					'approve_auto_placement' => 'Accept Auto Placed Students',
					'print_student_identification'=>'Print Student ID',
            )
    );


    public $components =array('EthiopicDateTime','Paginator','AcademicYear');
    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('download','print_students_number_pdf','export_students_number_xls','count_result','search');
    }
    
    public function beforeRender() {
        $acyear_array_data = $this->AcademicYear->acyear_array();
	$acYearMinuSeparated = $this->AcademicYear->acYearMinuSeparated();
        //To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
	$defaultacademicyearMinusSeparted=str_replace('/','-',$defaultacademicyear);

	   if(!empty($this->program_type_id)){
	   		   $program_types=$programTypes =  $this->AcceptedStudent->ProgramType->find('list',array('conditions'=>array('ProgramType.id'=>array_values($this->program_id))));
	   } else{
	   		   $program_types=$programTypes=$this->AcceptedStudent->ProgramType->find('list');
	   }
	   if(!empty($this->program_id)){
	   		 $programs =  $this->AcceptedStudent->Program->find('list',array('conditions'=>array('Program.id'=>array_values($this->program_id)),'fields'=>array('Program.id','Program.name')));
	   		
	   } else{
	   		 $programs =  $this->AcceptedStudent->Program->find('list');
	   }
	
        $this->set(compact('acyear_array_data','acYearMinuSeparated',
'defaultacademicyear','program_types','programs','programTypes','defaultacademicyearMinusSeparted'));
        unset($this->request->data['User']['password']);
    }
    /*
    *Generic search for returned items
    */
    function search() {
			// the page we will redirect to
			$url['action'] = 'index';
			
			// build a URL will all the search elements in it
			// the resulting URL will be 
			// domain.com/returned_items/index/Search.keywords:mykeyword/Search.tag_id:3
			foreach ($this->request->data as $k=>$v){ 
				foreach ($v as $kk=>$vv){ 
					$url[$k.'.'.$kk]=$vv; 
				} 
			}
			// redirect the user to the url
			return $this->redirect($url, null, true);
    }
     
     public function index() {
	 	$this->paginate = array('order' => 'AcceptedStudent.created DESC','limit'=>100);
	 	
		// filter by academic year  
	 	if (isset($this->passedArgs['Search.academicyear']) && !empty($this->passedArgs)) {
 			$academic_year = str_replace('-','/',$this->passedArgs['Search.academicyear']);
		   if(!empty($academic_year)) {
				$this->paginate['conditions'][]['AcceptedStudent.academicyear'] = $academic_year;
		   } 
		  
	      $this->request->data['Search']['academicyear'] = $this->passedArgs['Search.academicyear'];
	 	}
	    // filter by department or college	
		if (isset($this->passedArgs['Search.department_id']) && !empty($this->passedArgs['Search.department_id'])) {
	          $this->request->data['Search']['department_id'] = $this->passedArgs['Search.department_id'];
	           $this->paginate['conditions'][]['AcceptedStudent.department_id'] =$this->passedArgs['Search.department_id'];
		 } 

		   // filter by department or college	
		if (isset($this->passedArgs['Search.college_id']) && !empty($this->passedArgs['Search.college_id'])) {
	          $this->request->data['Search']['college_id'] = $this->passedArgs['Search.college_id'];
	           $this->paginate['conditions'][]['AcceptedStudent.college_id'] =$this->passedArgs['Search.college_id'];
		 } 

      	// filter by program 
		debug($this->passedArgs);
		 if(isset($this->passedArgs['Search.admitted'])) { 
				if($this->passedArgs['Search.admitted']==2) {
		          $this->paginate['conditions'][]='AcceptedStudent.id  in (select accepted_student_id from students)';
				} else {
				   $this->paginate['conditions'][]='AcceptedStudent.id not in (select accepted_student_id from students where accepted_student_id is not null )';
				}
		         
				$this->request->data['Search']['admitted'] = $this->passedArgs['Search.admitted'];
		 }
        
		 // filter by program 
	 	if(isset($this->passedArgs['Search.program_id'])) { 
	            $program_id=$this->passedArgs['Search.program_id'];
		    if(!empty($program_id)) {
	            $this->paginate['conditions'][]['AcceptedStudent.program_id'] = $program_id;
	            } 
			$this->request->data['Search']['program_id'] = $this->passedArgs['Search.program_id'];
	  	 }
	    
 
	     // filter by program type
	     if (isset($this->passedArgs['Search.program_type_id'])) { 
	            $program_type_id=$this->passedArgs['Search.program_type_id'];
		   if(!empty($program_type_id)) {
	            $this->paginate['conditions'][]['AcceptedStudent.program_type_id'] = $program_type_id;
	           } 
                 //set the Search data, so the form remembers the option
$this->request->data['Search']['program_type_id'] = $this->passedArgs['Search.program_type_id'];
	   }
	  // filter by name
	  if (isset($this->passedArgs['Search.name'])) { 
	            $name=$this->passedArgs['Search.name'];
		    if(!empty($name)){
	            $this->paginate['conditions'][]['AcceptedStudent.first_name like'] = '%'.$name.'%'; 
		    }
		    $this->request->data['Search']['name'] = $this->passedArgs['Search.name'];
	  }

	  	  // filter by university attended 
	 	if(isset($this->passedArgs['Search.attended_stream'])) { 
	        $stream_id=$this->passedArgs['Search.attended_stream'];
		    if(!empty($stream_id)) {
	            $this->paginate['conditions'][]['AcceptedStudent.attended_stream like'] = $stream_id.'%';
	        } 
			$this->request->data['Search']['attended_stream'] = $this->passedArgs['Search.attended_stream'];
	  	 }
	  	 
	  	 if(isset($this->passedArgs['Search.university_attended'])) { 
	        $university_attended=$this->passedArgs['Search.university_attended'];
		    if(!empty($university_attended)) {
	            $this->paginate['conditions'][]['AcceptedStudent.university_attended like'] = $university_attended.'%';
	        } 
			$this->request->data['Search']['university_attended'] = $this->passedArgs['Search.university_attended'];
	  	 }
	  	 


	  	
      if($this->role_id == ROLE_STUDENT) {
          $this->paginate['conditions'][]='AcceptedStudent.id in (select accepted_student_id from students where id='.$this->student_id.')';
	  }

	  if(isset($this->paginate['conditions']) && !empty($this->paginate['conditions'])){	
	  $this->Paginator->settings['conditions']=$this->paginate['conditions'];
	  }
	   debug($this->Paginator->settings);
	  $acceptedStudents = $this->Paginator->paginate('AcceptedStudent');
	 

	   if (empty($acceptedStudents) && isset($this->passedArgs) && !empty($this->passedArgs)) {
			$this->Session->setFlash('<span></span>'.__('There is no student in system based on the given criteria.'),'default',array('class'=>'info-box info-message'));
	   }
	      
	   if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR== $this->Session->read('Auth.User')['Role']['parent_id']) {
		     if(!empty($this->department_ids)) {
		       $departments=$this->AcceptedStudent->Department->allDepartmentInCollegeIncludingPre($this->department_ids,null); 
			} else if (!empty($this->college_ids)) {
			  $departments=$this->AcceptedStudent->Department->allDepartmentInCollegeIncludingPre(null, $this->college_ids,$this->onlyPre); 
			}
		 } else if(!empty($this->department_id) || !empty($this->college_id)) {
			 if ($this->role_id == ROLE_DEPARTMENT) {
	      
		            $departments= $this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));
		         } else if ($this->role_id == ROLE_COLLEGE) {
		    	  $departments=$this->AcceptedStudent->Department->allDepartmentInCollegeIncludingPre(null, $this->college_id,1); 
		        }       
		 } 
	  
	  if(!empty($this->department_ids)){
	   		 $departments = $this->AcceptedStudent->Department->find('list',
	   		 	array('conditions'=>array('Department.id'=>$this->department_ids)));
	   		 $collegeIdss=$this->AcceptedStudent->Department->find('list',
	   		 	array('conditions'=>array('Department.id'=>$this->department_ids),'fields'=>array('Department.college_id')));
	   		 $colleges=$this->AcceptedStudent->College->find('list',
	   		 	array('conditions'=>array('College.id'=>$collegeIdss)));
	   		
	   
	   } else if(isset($this->department_id) && !empty($this->department_id)){
		$departments = $this->AcceptedStudent->Department->find('list',

	   		 	array('conditions'=>array('Department.id'=>$this->department_id)));
	   		 $collegeIdss=$this->AcceptedStudent->Department->find('list',
	   		 	array('conditions'=>array('Department.id'=>$this->department_id),'fields'=>array('Department.college_id')));
	   		 $colleges=$this->AcceptedStudent->College->find('list',
	   		 	array('conditions'=>array('College.id'=>$collegeIdss)));
		

	   }
	   if(!empty($this->program_type_id)){
	   		   $programTypes = $this->AcceptedStudent->ProgramType->find('list',array('conditions'=>
	   		   	array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   		   $programTypes = $this->AcceptedStudent->ProgramType->find('list');
	   }
	    if(!empty($this->program_id)){
	   		   
	   		    $programs = $this->AcceptedStudent->Program->find('list',
	   		    	array('conditions'=>array('Program.id'=>$this->program_id)));	
	   } else{
	   		   $programs = $this->AcceptedStudent->Program->find('list');	
	   }

	   
	   $this->set(compact('colleges','departments','programs','programTypes'));	
	   
	  if($this->Session->read('student_not_deleted')) {
	   $this->set('student_not_deleted',$this->Session->read('student_not_deleted'));
	   $this->Session->delete('student_not_deleted');
	  }
debug($departments);
debug($colleges);
	  $this->set(compact('acceptedStudents','departments','colleges'));
	
	}
	
	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid accepted student'),'default', array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('acceptedStudent', $this->AcceptedStudent->read(null, $id));
	}

       public function add() {
		if (!empty($this->request->data)) {
			 $this->AcceptedStudent->create();
			if(empty($this->request->data['AcceptedStudent']['disability'])){
			 $this->request->data['AcceptedStudent']['disability']="";	
			}
			
			if(strcasecmp($this->request->data['AcceptedStudent']['department_id'],'No department')===0){
			     $this->request->data['AcceptedStudent']['department_id']=NULL;	
			} else if ($this->request->data['AcceptedStudent']['department_id']=="") {
			       $this->request->data['AcceptedStudent']['department_id']=NULL;
			} else {
			    if (!empty($this->request->data['AcceptedStudent']['department_id'])) {
			         $this->request->data['AcceptedStudent']['placementtype']=REGISTRAR_ASSIGNED;
			         $this->request->data['AcceptedStudent']['department_id']=$this->request->data['AcceptedStudent']['department_id'];
			    }
			    
			}
		if($this->AcceptedStudent->check_program_type($this->request->data)) {
			$check_everything_similar= $this->AcceptedStudent->find('count',array('conditions'=>$this->request->data['AcceptedStudent'],'recursive'=>-1));
			if ($check_everything_similar == 0) {
			if($this->request->data['AcceptedStudent']['program_id']!=PROGRAM_UNDEGRADUATE || $this->request->data['AcceptedStudent']['program_type_id']!=PROGRAM_TYPE_REGULAR){
				if (empty($this->request->data['AcceptedStudent']['EHEECE_total_results'])) {
						    unset($this->request->data['AcceptedStudent']['EHEECE_total_results']);
				}
			 }

			if ($this->AcceptedStudent->save($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('The accepted student has been saved'),'default',array('class'=>'success-box success-message'));
			  $this->request->data=null;
			} else {
			$this->Session->setFlash('<span></span>'.__('The accepted student could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		  } else {
		$this->Session->setFlash('<span></span>'.__('You have already entered the student data.'),'default',array('class'=>'error-box error-message'));
		 }
	       } else {
			$error=$this->AcceptedStudent->invalidFields();
		   if(isset($error['program'])){
			$this->Session->setFlash(__('<span></span>'.$error['program'][0]),
	'default',array('class'=>'error-box error-message'));
		    }
	       } 
		
	    }
        $colleges = $this->AcceptedStudent->College->find('list');
        if (!empty($this->request->data['AcceptedStudent']['college_id'])) {
            $departments = $this->AcceptedStudent->Department->find('list',
            array('conditions'=>array('Department.college_id'=>$this->request->data['AcceptedStudent']['college_id'])));    
        } else {
             $temp = array_keys($colleges);
		     $collegeIds = $temp[0];
		     $departments = $this->AcceptedStudent->Department->find('list',
            array('conditions'=>array('Department.college_id'=>$collegeIds)));    
        }
		
	  $regions = $this->AcceptedStudent->Region->find('list');
	  
	  $this->set(compact('departments','teachingCenters', 'programTypes','colleges','programs','regions'));
	}

    public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid accepted student'),'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if(empty($this->request->data['AcceptedStudent']['disability'])){
			 $this->request->data['AcceptedStudent']['disability']=NULL;	
			}
			
			
			$this->set($this->request->data);
			if ($this->AcceptedStudent->validates()) {
			     if($this->AcceptedStudent->check_program_type($this->request->data,$this->role_id)) {
			      
			            if ($this->AcceptedStudent->save($this->request->data)) {
                            $studentDetail=$this->AcceptedStudent->Student->find('first',
                            	array('conditions'=>array('Student.accepted_student_id'=>$this->AcceptedStudent->id),
                            		'contain'=>array('AcceptedStudent')
                            	));
                            if(!empty($studentDetail)){
                            	$admissionyear=$this->AcademicYear->get_academicYearBegainingDate($studentDetail['AcceptedStudent']['academicyear']);
                            	$this->AcceptedStudent->Student->id=$studentDetail['Student']['id'];
                            		$this->AcceptedStudent->Student->saveField('admissionyear', $admissionyear);
                            		$this->AcceptedStudent->Student->saveField('mother_tongue_id',$this->request->data['AcceptedStudent']['mother_tongue_id']);
                            }
			            	

				            $this->Session->setFlash('<span></span>'.__('The accepted student has been saved'),'default',array('class'=>'success-box success-message'));
				            $this->redirect(array('action' => 'index'));
			            } else {
				            $this->Session->setFlash('<span></span>'.__('The accepted student could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			            }
			      
			    } else {
			        $error=$this->AcceptedStudent->invalidFields();
			               
			          if(isset($error['program'])){
			                    $this->Session->setFlash(__('<span></span>'.$error['program'][0]),
			                            'default',array('class'=>'error-box error-message'));
			          }
			    }
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->AcceptedStudent->read(null, $id);
		}
		$selected_department=$this->request->data['AcceptedStudent']['department_id'];
        $colleges = $this->AcceptedStudent->College->find('list');
		$departments = $this->AcceptedStudent->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->request->data['AcceptedStudent']['college_id'])));
       
		$regions = $this->AcceptedStudent->Region->find('list');
        $currentacyeardata = $this->request->data['AcceptedStudent']['academicyear'];
        $isAdmittedAndHaveDepartment=$this->AcceptedStudent->find('first',array(
        'conditions'=>array('AcceptedStudent.id'=>$id),'contain'=>array('Student'=>array('College','Department'))));
       // debug($isAdmittedAndHaveDepartment);

          $motherTongues=$this->AcceptedStudent->MotherTongue->find('list');
	  $modalities=$this->AcceptedStudent->Modality->find('list');
	  $teachingCenters=$this->AcceptedStudent->TeachingCenter->find('list');

		$this->set(compact('departments','motherTongues','modalities','teachingCenters', 'programTypes','colleges','programs','currentacyeardata',
		'selected_department','regions','isAdmittedAndHaveDepartment'));
	}

    function delete() {
	$student_not_deleted=array();
	$delete_count = 0;
	$data=$this->AcceptedStudent->find('first',array('conditions'=>array('AcceptedStudent.id'=>array_keys($this->request->data['AcceptedStudent']['delete'])),'fields'=>array('id','department_id',
        'college_id','program_id','program_type_id'),
'recursive'=>-1));
          if (!empty($this->request->data['AcceptedStudent']['delete'])) {
            foreach($this->request->data['AcceptedStudent']['delete'] as $id => $delete) {
                if ($delete == 1) {
					
				$admitted=$this->AcceptedStudent->Student->find('first',array('conditions'=>array('Student.accepted_student_id'=>$id),'recursive'=>-1));

				$admission_check=$this->AcceptedStudent->Student->checkAdmissionTransaction($admitted['Student']['id']);

             	$preference_check=$this->AcceptedStudent->Preference->find('count',array('conditions'=>array('Preference.accepted_student_id'=>$id),'recursive'=>-1));
			    
				if ($admission_check==0 && $preference_check==0) {
                        if ($this->AcceptedStudent->delete($id)) {
                            $delete_count++;
                        }
               } else {
                        $student_not_deleted[]=$id;

               }
	    }
	  }
        }

	if(!empty($student_not_deleted)){
	$this->Session->Write('student_not_deleted',$student_not_deleted); 
        }

		

        if (count($this->request->data['AcceptedStudent']['delete']) == count($student_not_deleted) ) {
		$this->Session->setFlash('<span></span>'.__('You can not delete the selected student, they already have department or student number or fill preference.'),'default',array('class'=>'error-box error-message'));
        } else {
           if(empty($student_not_deleted)){
                    if ($delete_count>0) {
                        $this->Session->setFlash('<span></span>'.$delete_count . ' AcceptedStudent' . (($delete_count == 1) ? ' was' : 's were') . ' deleted','default',array('class'=>'success-box success-message'));
			
		 } else {
		  $this->Session->setFlash('<span></span>Please select atleast one  student to delete','default',array('class'=>'error-box error-message'));
		}

            } else {
		if( $delete_count>0 ){
		    $this->Session->setFlash('<span></span>'.$delete_count . ' AcceptedStudent' . (($delete_count == 1) ? ' was' : 's were') . ' deleted, but those red marked student coudn\'t be delete, they have already department or have student number.','default',array('class'=>'success-box success-message'));
                 } 
	    }
            
            if (!empty($student_not_deleted)) {
               $this->Session->setFlash('<span></span>'.count($student_not_deleted). ' AcceptedStudent' . (($delete_count == 1) ? ' was' : 's were') . ' red marked student coudn\'t be delete, they have already department or have student number.','default',array('class'=>'error-box error-message'));
            }
        }
	$this->redirect(Router::url($this->referer(), true));
    }
   /**
   *Number  of accepted students categorized by results
   @set selected_student_result_category
   */
   function summery() {
		$thisyear = date('Y');
		$thismonth = date('m');
		$shortthisyear = substr($thisyear,2,2);
		if($thismonth == "09" or $thismonth == "10" or $thismonth == "11" or $thismonth == "12") {
			$acyear = $thisyear.'/'.($shortthisyear + 1);
		} else {
			$acyear = ($thisyear - 1).'/'.$shortthisyear;
		}
		if($this->Session->read('acyear')){
			$this->Session->write('acyear',$acyear);
		} else {
				$this->Session->write('acyear',$acyear);
		}

		$total_selected_student=$this->AcceptedStudent->find('count',array(
			'conditions'=>array("AcceptedStudent.academicyear LIKE" => "$acyear%")
			)
		);

		if($result_critieria_data=$this->Session->read('result_critieria_data')){		$selected_student_result_category_count=array();
		foreach($result_critieria_data as $key=>$value) {
		$selected_student_result_category_count[$value['PlacementsResultsCriteria']['name'].'('.$value['PlacementsResultsCriteria']['result_from'].'-'.$value['PlacementsResultsCriteria']['result_to'].')'] = $this->AcceptedStudent->find('count',array('conditions'=>array("AcceptedStudent.academicyear LIKE" => "$acyear%","AcceptedStudent.EHEECE_total_results >="
											=>$value['PlacementsResultsCriteria']['result_from'],
											"AcceptedStudent.EHEECE_total_results <="=>$value['PlacementsResultsCriteria']['result_to']))
			);
			if($this->Session->read('result_critieria_data')){
				$this->Session->delete('result_critieria_data');
			}
		}
		$this->Session->write('selected_student_result_category_count',$selected_student_result_category_count);
	  }
	}

    public function generate($id=null){
    //********* TO Filter students per academic year,College,Program, program_type and display
    $data=$this->AcceptedStudent->getidlessstudentsummery($this->AcademicYear->current_academicyear());
    $this->AcceptedStudent->recursive = 0;
    $acceptedStudents=null;
    $selectedsacdemicyear =null;
    $selected_program = null;
    $selected_program_type = null;
    $selected_college = null;
  
    $colleges = $this->AcceptedStudent->College->find('list');
    $selectedsacdemicyear = $this->AcademicYear->current_academicyear();
    $isbeforesearch = 1;
    $this->set(compact('data','selectedsacdemicyear','programs','programTypes','colleges','isbeforesearch'));
     if (!empty($this->request->data) && isset($this->request->data['search'])) {
            $isbeforesearch = 0;
	    $selectedsacdemicyear = $this->request->data['AcceptedStudent']['academicyear'];
            $selected_college = $this->request->data['AcceptedStudent']['college_id'];
            $selected_program = $this->request->data['AcceptedStudent']['program_id'];
            $selected_program_type=$this->request->data['AcceptedStudent']['program_type_id'];
            $selected_department_id=$this->request->data['AcceptedStudent']['department_id'];
           if(!empty($this->request->data['AcceptedStudent']['limit'])){
           	 $limit=$this->request->data['AcceptedStudent']['limit'];
           } else {
           	 $limit=200;
           }
           
            
	     $conditions = array(
                "AcceptedStudent.academicyear" => $selectedsacdemicyear,
                'AcceptedStudent.college_id'=>$selected_college,
'AcceptedStudent.program_id'=>$selected_program,
'AcceptedStudent.program_type_id'=>$selected_program_type,
'AcceptedStudent.department_id'=>$selected_department_id,
                    "OR"=>array("AcceptedStudent.studentnumber is null",
                                    "AcceptedStudent.studentnumber" =>array(0,'')));
                
			  $this->paginate = array('conditions'=>$conditions,'order'=>array(
			  'AcceptedStudent.first_name ASC'),
			  'limit'=>$limit,
			  'maxLimit'=>$limit,
			  'contain'=>array('Department','College','ProgramType','Program')
			  );
	
       $this->Paginator->settings=$this->paginate;
       $acceptedStudents = $this->Paginator->paginate('AcceptedStudent');
       debug(count($acceptedStudents));
       $this->set('show_list_generated',true);
       $this->set(compact('selectedsacdemicyear','acceptedStudents',
                'selected_college','selected_program','selected_program_type','isbeforesearch'));
	}
    ///***end of Filter
    if(isset($this->request->data['generateid'])){
	$generate_count =0;
	$Id_generation_failed_students_count = 0;
	$Id_generation_failed_students = null;
//To check wheteher at least one check_box checked or not
		$university =ClassRegistry::init('University')->find('first',array('order'=>array('University.academic_year DESC')));
        $check_count=0;
        foreach($this->request->data['AcceptedStudent']['generate'] as $value) {
            $check_count +=$value;
        }
		if (!empty($check_count)) {
            $generate_id_list = $this->request->data['AcceptedStudent']['generate'];
		 foreach($generate_id_list as $id => $generate) {
				if($generate!=0){
					$this->request->data = $this->AcceptedStudent->readAllById($id);
					break;
				}
		  }
		  $generate_accepted_student_lists=$this->AcceptedStudent->find('list',
		  	array('conditions'=>array('AcceptedStudent.id'=>array_keys($generate_id_list)),
		  		'order'=>array('AcceptedStudent.first_name ASC')
		  		));
          $count = $this->AcceptedStudent->countIdByDepartment($this->request->data['Department']['id'], $this->request->data['AcceptedStudent']['academicyear']);
          $count = $count + 1;
          foreach($generate_accepted_student_lists as $id => $generate) {
               $ccc = 0;
               do {
				if($count >=1 && $count <=9) {
				     $count = '00'.$count;
				} else if($count >=10 && $count <=99) {
				     $count = '0'.$count;
				}
             $loop_back = false;
            //generate only for the selected students
            if($generate_id_list[$id]!=0){
		    $this->request->data = $this->AcceptedStudent->readAllById($id);
              
                if(!empty($this->request->data['AcceptedStudent']['college_id'])){
                    if(!empty($this->request->data['AcceptedStudent']['academicyear'])) {
                        $programTypeShortName = $this->request->data['ProgramType']['shortname'];
                        $CollageShortName=$university['University']['short_name'];
                        $programShortName=$this->request->data['Program']['shortname'];
                        $departmentShortName=$this->request->data['Program']['shortname'];
                       
                       
                        $acyear=$this->request->data['AcceptedStudent']['academicyear'];
                        $GCyear=substr(($this->request->data['AcceptedStudent']['academicyear']),0,4);
                        $GCmonth=date('m');
                        $GCday=date('j');
                        $ETyear=$this->EthiopicDateTime->GetEthiopicYear($GCday, $GCmonth, $GCyear);
                        //$shortAcyear = date('y',strtotime($ETyear));
                        if($GCmonth <=8){
                        	$ETshortAcyear = substr($ETyear,2,2)+1;
                        	if($ETshortAcyear < 10){
                        		$ETshortAcyear = "0".$ETshortAcyear;
                        	}
                        } else {
                        	$ETshortAcyear = substr($ETyear,2,2);
                        }
                        
                        $generatedStudentId =$CollageShortName.$programShortName.$programTypeShortName.'/'.$count.'/'.$ETshortAcyear;
                        if(empty($this->request->data['AcceptedStudent']['studentnumber']))
                        {
                        	//Check whether generated id alreday in database or not
                        	$is_generatedStudentId_already_in_database = $this->AcceptedStudent->find('count', array('conditions'=>array('AcceptedStudent.studentnumber'=>$generatedStudentId)));
                        	if($is_generatedStudentId_already_in_database == 0){
                        	    $this->AcceptedStudent->id=$this->request->data['AcceptedStudent']['id'];
		                     	$this->AcceptedStudent->saveField('studentnumber', $generatedStudentId);
		                   	 	$generate_count++;
                       	 	} else {
                       	 		
                       	 		$loop_back = true;
                       	 	}
                        }
                    } else {
                       	 $student_name = $this->AcceptedStudent->field('AcceptedStudent.full_name',array('AcceptedStudent.id'=>$id));
		                $Id_generation_failed_students_count++;
		                $Id_generation_failed_students .= "<ol> For ".$student_name." please provide academic year.</ol>";
                    }
                } else {
                    
                    $student_name = $this->AcceptedStudent->field('AcceptedStudent.full_name',array('AcceptedStudent.id'=>$id));
                    $Id_generation_failed_students_count++;
                    $Id_generation_failed_students .= "<ol> For ".$student_name." must be belongs to a collage.</ol>";
                }
             }
	     $count = $count + 1;
        } while($loop_back == true);
       }
	     if($Id_generation_failed_students_count ==0){
	    	$this->Session->setFlash('<span></span>'.$generate_count .' Student ID'. (($generate_count == 1) ? ' was' : 's were') . ' generated','default',array('class'=>'success-box success-message'));
	     } else {
	     	$this->Session->setFlash('<span></span>'.$generate_count .' Student ID'. (($generate_count == 1) ? ' was' : 's were') . ' generated successfully but For '.$Id_generation_failed_students_count.' Students the system failed to generate student Id. Please modifiy those students missing record based on the following lists <ul>'.$Id_generation_failed_students .'<ul>','default',array('class'=>'info-box info-message'));
	     }
            
      } else {
           $this->Session->setFlash('<span></span>'.__("Please select atleast one student"),'default',array('class'=>'error-box error-message'));
           
        }
        $this->set('show_list_generated',true);
        $this->redirect(array('action' => 'generate'));
	   }	  
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
    
	
    public function export_print_students_number() {
		//$this->AcceptedStudent->recursive = 0;
		$acceptedStudents=null;
		$selectedsacdemicyear =null;
		$selected_program = null;
		$selected_program_type = null;
		$selected_college = null;
		$programs = $this->AcceptedStudent->Program->find('list');
		$programTypes = $this->AcceptedStudent->ProgramType->find('list');
        if(!empty($this->department_ids)) {
			$departments = $this->AcceptedStudent->Department->find('list',
array('conditions'=>array('Department.id'=>$this->department_ids)));
		} else if(!empty($this->college_ids)) {
			$colleges = $this->AcceptedStudent->College->find('list',
array('conditions'=>array('College.id'=>$this->college_ids)));
		} else {
            if(!empty($this->department_id)) {
			   		$departments = $this->AcceptedStudent->Department->find('list',
array('conditions'=>array('Department.id'=>$this->department_ids)));
			} else if(!empty($this->college_id)) {
                   $colleges = $this->AcceptedStudent->College->find('list',
array('conditions'=>array('College.id'=>$this->college_ids)));
			}

		}
		$selectedsacdemicyear = $this->AcademicYear->current_academicyear();
		$isbeforesearch = 1;
		$this->set(compact('selectedsacdemicyear','programs','programTypes','departments','colleges','isbeforesearch'));
		$this->__init_search();
		if ($this->Session->read('search_data')) {
		  $this->request->data['search']=true;
		}
		
		if (!empty($this->request->data) && isset($this->request->data['search'])) {
		    
            $isbeforesearch = 0;
			$selectedsacdemicyear = $this->request->data['AcceptedStudent']['academicyear'];
            $conditions=array();
			
		    if(!empty($this->request->data['AcceptedStudent']['department_id'])) {
              $conditions['AcceptedStudent.department_id']=$this->request->data['AcceptedStudent']['department_id'];
			}
			if(!empty($this->request->data['AcceptedStudent']['college_id'])) {
              $conditions['AcceptedStudent.college_id']=$this->request->data['AcceptedStudent']['college_id'];
			}
			
			if(!empty($this->request->data['AcceptedStudent']['program_id'])) {
              $conditions['AcceptedStudent.program_id']=$this->request->data['AcceptedStudent']['program_id'];
			}

            if(!empty($this->request->data['AcceptedStudent']['program_type_id'])) {
              $conditions['AcceptedStudent.program_type_id']=$this->request->data['AcceptedStudent']['program_type_id'];
			}

		    if(!empty($this->request->data['AcceptedStudent']['academicyear'])) {
              $conditions['AcceptedStudent.academicyear']=$this->request->data['AcceptedStudent']['academicyear'];
			}

			$conditions['NOT']=array('AcceptedStudent.studentnumber'=>array('','null','NULL'));
		
           
                
			$this->paginate = array('limit'=>50000,'fields'=>array('full_name','sex','studentnumber'),'order'=>array('AcceptedStudent.full_name ASC '),
				'contain'=>array('Region'=>array('fields'=>'name')));

			$this->Paginator->settings['conditions']=$conditions;
            $acceptedStudents = $this->Paginator->paginate('AcceptedStudent');

			if(!empty($this->request->data['AcceptedStudent']['department_id'])) {
				$selected_dept = $this->AcceptedStudent->Department->find('first',array('conditions'=>array('Department.id'=>$this->request->data['AcceptedStudent']['department_id'])));
				$selected_department_name=$selected_dept['Department']['name'];
				$selected_college_name = $this->AcceptedStudent->College->field('College.name',array('College.id'=>$selected_dept['Department']['college_id']));
			
			}
			if(!empty($this->request->data['AcceptedStudent']['college_id'])) {
			$selected_college_name = $this->AcceptedStudent->College->field('College.name',array('College.id'=>$this->request->data['AcceptedStudent']['college_id']));
			$selected_department_name="";
			}

			$selected_program_name = $this->AcceptedStudent->Program->field('Program.name',array('Program.id'=>$this->request->data['AcceptedStudent']['program_id']));
			$selected_program_type_name = $this->AcceptedStudent->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['AcceptedStudent']['program_type_id']));
					
			$this->Session->write('acceptedStudents',$acceptedStudents);
			$this->Session->write('selected_college_name',$selected_college_name);
			$this->Session->write('selected_department_name',$selected_department_name);
			$this->Session->write('selected_program_name',$selected_program_name);
			$this->Session->write('selected_program_type_name',$selected_program_type_name);
			$this->Session->write('selected_acdemicyear',$selectedsacdemicyear);
			
			$this->set(compact('selectedsacdemicyear','acceptedStudents','selected_college_name','selected_program_name',
				'selected_program_type_name','isbeforesearch','departments',
'selected_department_name'));
		}
	}
	
	public function print_students_number_pdf() {
		$acceptedStudents = $this->Session->read('acceptedStudents');
	    $selected_college_name = $this->Session->read('selected_college_name');
		$selected_program_name =$this->Session->read('selected_program_name');
		$selected_program_type_name = $this->Session->read('selected_program_type_name');
		$selected_acdemicyear =$this->Session->read('selected_acdemicyear');
		$selected_department_name=$this->Session->read('selected_department_name');
		
	    $this->set(compact('acceptedStudents','selected_college_name','selected_program_name','selected_program_type_name',
			'selected_acdemicyear','selected_department_name'));
		
	    $this->layout='pdf';
	    $this->render();
      }
	
     public function export_students_number_xls () {
		$acceptedStudents = $this->Session->read('acceptedStudents');
	    $selected_college_name = $this->Session->read('selected_college_name');
		$selected_program_name =$this->Session->read('selected_program_name');
		$selected_program_type_name = $this->Session->read('selected_program_type_name');
		$selected_acdemicyear =$this->Session->read('selected_acdemicyear');
		$selected_department_name=$this->Session->read('selected_department_name');
		
	    $this->set(compact('acceptedStudents','selected_college_name','selected_program_name','selected_program_type_name',
			'selected_acdemicyear','selected_department_name'));
	}
	
     public function direct_placement() {
		if (!empty($this->request->data)) {
		    $selectedAcademicYear=null;$search=false;
		    if(!empty($this->request->data['AcceptedStudent']['academicyear'])){
			   $selectedAcademicYear = $this->request->data['AcceptedStudent']['academicyear'];
			   $search=true;
			} else {
			   $selectedAcademicYear= $this->AcademicYear->current_academicyear();
			}

			if(!empty($selectedAcademicYear))
            {
			    // condition to list accepted student of given academic year and college
			    if(isset($this->request->data['search'])) {
					 $conditions = array(
                     
                        "AcceptedStudent.college_id" => $this->college_id,
                        "AcceptedStudent.Placement_Approved_By_Department is null" 

			        );
				    if(!empty($selectedAcademicYear)) {
                         $conditions[] =  "AcceptedStudent.academicyear LIKE '".$selectedAcademicYear."%'";
				    }
					if(!empty($this->request->data['AcceptedStudent']['name'])) {
                         $conditions[] =  "AcceptedStudent.first_name LIKE '".$this->request->data['AcceptedStudent']['name']."%'";
				    }

                    if(!empty($this->request->data['AcceptedStudent']['limit'])) {
                        $this->Paginator->settings['limit']=$this->request->data['AcceptedStudent']['limit'];
				    } else {
                      $this->Paginator->settings['limit']=100;
					}
				   
			        $this->Paginator->settings['conditions']=$conditions;
			        $this->set('acceptedStudents',$this->Paginator->paginate('AcceptedStudent'));
			        $departments = $this->AcceptedStudent->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->college_id)));
					$programTypes=$this->AcceptedStudent->ProgramType->find('list');
					$programs=$this->AcceptedStudent->Program->find('list');
					$this->set(compact('departments','programTypes','programs')); 
		          
			        return;
			    }

			    debug($this->request->data);
			    if(isset($this->request->data['assigndirectly'])) {

			    $directlyplacementstudents=array();
			    if(!empty($this->request->data['AcceptedStudent']['department_id'])){
			       $department_id=$this->request->data['AcceptedStudent']['department_id'];

			       $this->set('selecteddepartment',$department_id);
			       $counter=0;
		       $arraycountvalue=array_count_values($this->request->data['AcceptedStudent']['directplacement']);

			       if(isset($arraycountvalue[1])&&!empty($arraycountvalue[1])){
			           $check_again_students_not_assigned_by_others=array();
			           foreach($this->request->data['AcceptedStudent']['directplacement']
			           as $key=>$value){
			             if($value){
			                $directlyplacementstudents['AcceptedStudent'][$counter]['id']=$key;
			                $directlyplacementstudents['AcceptedStudent'][$counter]['department_id']=$department_id;
			                $directlyplacementstudents['AcceptedStudent'][$counter]['placementtype']=DIRECT_PLACEMENT;
			                $check_again_students_not_assigned_by_others[]=$key;
			                $student=$this->AcceptedStudent->find('first',
			             		array('conditions'=>array('AcceptedStudent.id'=>$key),
			             			'contain'=>array('Student')));

			                 $directlyplacementstudents['Student'][$counter]['department_id']=$department_id;
			                $directlyplacementstudents['Student'][$counter]['id']=$student['Student']['id'];


			                $counter++;
			             }


			       }
			       
			       if(!empty($directlyplacementstudents['AcceptedStudent'])){
			          if($this->AcceptedStudent->saveAll(
			            $directlyplacementstudents['AcceptedStudent'])) {
			            $conditions = array("AcceptedStudent.academicyear LIKE" =>
			            $selectedAcademicYear.'%',"AcceptedStudent.college_id"=>
			            $this->college_id,'AcceptedStudent.placementtype'=>DIRECT_PLACEMENT,
			            "AcceptedStudent.Placement_Approved_By_Department is null");
			        	$departmentname=$this->AcceptedStudent->Department->field('Department.name',
			        		array('Department.id'=>$department_id));

						 if($this->AcceptedStudent->Student->saveAll(
			            $directlyplacementstudents['Student'],array('validate'=>false))) {

		                  }			        	

			        	/*
			        	$this->Paginator->settings['conditions']=$conditions;

	                   
	                    $acceptedStudents=$this->Paginator->paginate('AcceptedStudent');

		                $this->set('acceptedStudents',
		                	$acceptedStudents);
		                $departmentname=null;
		                foreach($acceptedStudents as $acceptedStudent){
	                            $departmentname=$acceptedStudent['Department']['name'];
	                            break;
	                    }
	                    */
				        $this->Session->setFlash('<span></span>'.__('The student has been directly
				        placed to '.$departmentname.' department ', true),
				        'default', array('class'=>'success-box success-message'));



			            } else {
				        $this->Session->setFlash('<span></span>'.__('The direct placement
				        could not be saved. Please, try again.', true),'default',
				        array('class'=>'error-box error-message'));
			          }
			       }
                 
			    } else {
			       $this->Session->setFlash('<span></span>'.__("No student is selected.
			        Please select atleast one student you want to assign to department.",
			        true),'default',array('class'=>'error-box error-message'));
			    }
			  } else {
			         $this->Session->setFlash('<span></span>'.__("No department is selected.
			         Please select the department you want to assign.",true),'default',array('class'=>'error-box error-message'));
			  }
			
			 } elseif(isset($this->request->data['transfertodepartment'])) {
			  
			    if($this->_transferToDepartment($this->request->data)=="NODEPARTMENT"){
			         $this->Session->setFlash('<span></span>'.__("No department is selected.
			         Please select the department you want to transfer.",true),'default',
			         array('class'=>'error-box error-message'));
			         //$this->redirect(array('action'=>'direct_placement'));
			    } elseif($this->_transferToDepartment($this->request->data)=="NOSTUDENT") {
			      $this->Session->setFlash('<span></span>'.__("No student is selected.
			        Please select atleast one student you want to transfer to department.",
			        true),
			       'default',array('class'=>'error-box error-message'));
			         //$this->redirect(array('action'=>'direct_placement'));
			    } elseif(is_array($this->_transferToDepartment($this->request->data))) {
			            $transfer=$this->_transferToDepartment($this->request->data);

			            if($this->AcceptedStudent->saveAll(
			            $transfer['AcceptedStudent'])) {
	                    $conditions = array("AcceptedStudent.academicyear LIKE" =>
			            $selectedAcademicYear.'%',"AcceptedStudent.college_id"=>
			            $this->college_id,"AcceptedStudent.Placement_Approved_By_Department is null");
		                 $acceptedStudents=$this->paginate($conditions);
		                //$acceptedStudents=$this->paginate($conditions);
		                $this->set('acceptedStudents',$acceptedStudents);
		                $departmentname=$this->AcceptedStudent->find('first',array("conditions" => array("AcceptedStudent.academicyear LIKE" =>
			            $selectedAcademicYear.'%',"AcceptedStudent.college_id"=>
			            $this->college_id,"AcceptedStudent.department_id"=>
			            $transfer['AcceptedStudent'][0]['department_id'])));


		                  if($this->AcceptedStudent->Student->saveAll(
			            $transfer['Student'],array('validate'=>false))) {

		                  }
				        $this->Session->setFlash('<span></span>'.__('The student has been transferred
				          to '.$departmentname['Department']['name'].
				          ' department ', true),'default',
				          array('class'=>'success-box success-message'));

			            } else {
				        $this->Session->setFlash('<span></span>'.__('The direct placement
				        could not be saved. Please, try again.', true),
				        'default',array('class'=>'error-box error-message'));
			          }
			          	
			    }
			  
			 } elseif(isset($this->request->data['cancelplacement'])) {
			     if($this->_cancelPlacement($this->request->data)=="NOSTUDENT"){
			         $this->Session->setFlash('<span></span>'.__("No student is selected.
			        Please select atleast one student you want to cancel.",true),
			        'default',array('class'=>'error-box error-message'));
			         //$this->redirect(array('action'=>'direct_placement'));

			    } elseif(is_array($this->_cancelPlacement($this->request->data))) {
			            $cancelPlacement=$this->_cancelPlacement($this->request->data);
			            if($this->AcceptedStudent->saveAll(
			            $cancelPlacement['AcceptedStudent'])) {

	                    $conditions = array("AcceptedStudent.academicyear LIKE" =>
			            $selectedAcademicYear.'%',"AcceptedStudent.college_id"=>
			            $this->college_id,"AcceptedStudent.Placement_Approved_By_Department is null");
		                 $acceptedStudents=$this->paginate($conditions);
		                $this->set('acceptedStudents',$acceptedStudents);

				        $this->Session->setFlash('<span></span>'.__('The student placement is
				        cancelled ', true),'default',array('class'=>'success-box success-message'));

			            } else {
				        $this->Session->setFlash('<span></span>'.__('The direct placement
				        could not be saved. Please, try again.', true),
				        'default',array('class'=>'error-box error-message'));
			          }
			    }
			  }
			}
			
			$this->redirect(array('action'=>'direct_placement','page'=>$this->passedArgs['page']));
		} else {
		     $conditions = array(
                "AcceptedStudent.academicyear LIKE" => $this->AcademicYear->current_academicyear().'%'

			,"AcceptedStudent.college_id"=>$this->college_id,"AcceptedStudent.Placement_Approved_By_Department is null");

          $this->Paginator->settings['conditions']=$conditions;
			        $this->set('acceptedStudents',$this->Paginator->paginate('AcceptedStudent'));
		
		}
		$departments = $this->AcceptedStudent->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->college_id)));
	    $programTypes=$this->AcceptedStudent->ProgramType->find('list');
		
		$programs=$this->AcceptedStudent->Program->find('list');
		
		$this->set(compact('departments','programTypes','programs')); 
	}
	function _eligiblestudentforplacement($selectedAcademicYear=null,
	$college_id=null){
	           
                 $checkStudentIsAvailabeForPlacement=$this->AcceptedStudent->find(
                        'count',array('conditions'=>array(                            
                                "OR"=>array(
                 'AcceptedStudent.department_id IS NULL',
                 'AcceptedStudent.department_id '=>array('',0)),
                 
                 "AcceptedStudent.academicyear LIKE" =>
                                        $selectedAcademicYear.'%',
                                        "AcceptedStudent.college_id" =>$college_id,
                                        "AcceptedStudent.Placement_Approved_By_Department is null",
                                        "OR"=>array("AcceptedStudent.placementtype IS NULL",
                                        "AcceptedStudent.placementtype"=>CANCELLED_PLACEMENT))
                              ));
		return  $checkStudentIsAvailabeForPlacement;	         			           

	}
	/**
	*Place students automatically
	*/
    public function auto_placement () {
        if (!empty($this->request->data)&&
		isset($this->request->data['runautoplacement'])) {
		
		  if(!empty($this->request->data['AcceptedStudent']['academicyear'])){
		      $check_auto_placement_already_run=$this->AcceptedStudent->find('count',
		      array('conditions'=>array('AcceptedStudent.academicyear'=>$this->request->data['AcceptedStudent']['academicyear'],
		      'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placementtype'=>
		      AUTO_PLACEMENT)));
		      if($check_auto_placement_already_run==0) {
			        $selectedAcademicYear = $this->request->data['AcceptedStudent']['academicyear'];
			          //check accepted student is imported into the system
			          if($this->_eligiblestudentforplacement(
			          $selectedAcademicYear,$this->college_id)){			             
			             //check placement setting is recorded
			             $checkplacementsetting=$this->
			             AcceptedStudent->checkPlacementSettingIsRecorded(
			             $selectedAcademicYear,$this->college_id);
			             
			             if($checkplacementsetting){
			                    //check preference deadline is not passed
			                 
			                    if($this->AcceptedStudent->isPreferenceDeadlinePassed(
			                                $selectedAcademicYear,$this->college_id)){
			                       //select prepartory or freshman result
			                      $preference_not_completed_percent=$this->_getListOfAcceptedStudentsWithoutPreference(
			                      $selectedAcademicYear,$this->college_id);
			                      //debug($preference_not_completed_percent);
			                      $preference_completed_percent=(100-$preference_not_completed_percent);
			                      //debug($preference_completed_percent);
			                    
			                    //Check that reseved place is defined for all eligible students
			                    $reservedPlaces_c = ClassRegistry::init('ReservedPlace')->find('all',
			                    	array(
			                    		'conditions' =>
			                    		array(
			                    			'ReservedPlace.college_id' => $this->college_id,
			                    			'ReservedPlace.academicyear' => $selectedAcademicYear
			                    		),
			                    		'recursive' => -1
			                    	)
			                    );
			                    $participatingDepartments_c = ClassRegistry::init('ParticipatingDepartment')->find('all',
			                    	array(
			                    		'conditions' =>
			                    		array(
			                    			'ParticipatingDepartment.college_id' => $this->college_id,
			                    			'ParticipatingDepartment.academic_year' => $selectedAcademicYear
			                    		),
			                    		'recursive' => -1
			                    	)
			                    );
			                    $pd_computational_capacity_sum = 0;
			                    $rp_sum = 0;
			                    foreach($participatingDepartments_c as $pd_value) {
			                    	$pd_computational_capacity_sum += 
			                    	($pd_value['ParticipatingDepartment']['number']-(
			                    	$pd_value['ParticipatingDepartment']['female'] + 
			                    	$pd_value['ParticipatingDepartment']['regions'] + 
			                    	$pd_value['ParticipatingDepartment']['disability']));
			                    }
			                    foreach($reservedPlaces_c as $rp_value) {
			                    	$rp_sum += $rp_value['ReservedPlace']['number'];
			                    }
			                    if($rp_sum == $pd_computational_capacity_sum) {
			                    if($preference_completed_percent>0){
			                       $isPrepartory=ClassRegistry::
	    init('PlacementsResultsCriteria')->isPrepartoryResult($selectedAcademicYear,$this->college_id);                       // not used remove it 
			                        /*$checkPlacementSettingIsRecord['prepartory_result']=
			                        ClassRegistry::init('PlacementsResultsCriteria')
			                        ->isPrepartoryResult($selectedAcademicYear,
			                        $this->college_id);*/
			              
			                   $autoplacedstudents=array();
			                   //auto placement start
			                    $placementLock=array();
			                    $this->loadModel('PlacementLock');
			                    $placement_lock_id=$this->PlacementLock->find('first',
			                    array('conditions'=>array('PlacementLock.college_id'=>$this->college_id,
			                    'PlacementLock.academic_year'=>$selectedAcademicYear)));
			                    if(!empty($placement_lock_id)){
			                       $placementLock['PlacementLock']['id']=$placement_lock_id['PlacementLock']['id'];
			                    } else {
			                        $placementLock['PlacementLock']['id']=null;
			                    }
			                    
			                   
			                    $placementLock['PlacementLock']['college_id']=$this->college_id;
			                    $placementLock['PlacementLock']['academic_year']=$selectedAcademicYear;
			                    $placementLock['PlacementLock']['process_start']=1;
			                    $placementLock['PlacementLock']['start_time']=date('Y-m-d H:i:s');
			                   
			                    $this->PlacementLock->create();
			                    $this->PlacementLock->save($placementLock);
			                    $placement_lock_id=$this->PlacementLock->id;
			               
			                // if no quota is given run the parallel placement
			                 if($this->AcceptedStudent->detect_privilaged_qutoa_presence(
			                 $selectedAcademicYear,$this->college_id)==0){
			                         $autoplacedstudents=$this->AcceptedStudent
			                            ->auto_parallel_assignment($selectedAcademicYear,
			                            $this->college_id,
			                            $isPrepartory);
			                            
			                            
			                       
			                 } 
			                 // if  quota is given run the sequential placement
			                 // run sequential placement if there is quota.
			                 else {
			                   
			                    $autoplacedstudents=$this->AcceptedStudent
			                        ->auto_placement_algorithm($selectedAcademicYear,
			                        $this->college_id,
			                        $isPrepartory, $this->request->data['AcceptedStudent']['high_proprity_for_high_result'], 
			                        $this->request->data['AcceptedStudent']['first_consider_first']);
			                  
			                 }
			                   //auto placement end
			                    $select_placement_lock=$this->PlacementLock->read(null,$placement_lock_id);
			                    
			                    $select_placement_lock['PlacementLock']['end_time']=date('Y-m-d H:i:s');
			                    $select_placement_lock['PlacementLock']['process_start']=0;
			                    $this->PlacementLock->save($select_placement_lock);
			                
			                 if(!empty($autoplacedstudents)){ 
			                  $college_name=$this->AcceptedStudent->College->field('College.name', array('College.id '=>$this->college_id));
			                  $this->Session->setFlash(
			                            __('<span></span>Auto placement result for '.$selectedAcademicYear.' academic year of '.$college_name.'.'),'default', array('class'=>'success-box success-message'));
			                         //record the auto placement to the lock database
			                         
			                         $auto_already_run=true;
			                         $this->set(compact('autoplacedstudents','auto_already_run'));
			                         $this->Session->write('autoplacedstudents',$autoplacedstudents);
			                         $this->Session->write('selected_academic_year',$selectedAcademicYear);
			                         
			                  }      
			            } else {
			                       $this->Session->setFlash(
			                            __('<span></span>You can not run auto placement. '.$preference_not_completed_percent.' % of students has not completed their preference.'),'default',
			                            array('class'=>'error-box error-message'));
			                       $this->redirect(array('controller'=>'preferences','action'=>'add'));
			            }
			            }
			            //If reseved place is not defined for all available eligible students
			            else {
			            	$this->Session->setFlash(__('<span></span>There is some inconsistency with the department quota and reserved place for each department. Please go to "<u>Add/Edit Reserved Place For Department</u>" section and adjust before you run the auto placement.'),'default', array('class'=>'error-box error-message'));
			            }
			                      
                } else 
                        {
                            $error=$this->AcceptedStudent->invalidFields();
                            if(isset($error['preferencedeadline'])){
                                $this->Session->setFlash(
                                __('<span></span>'.$error['preferencedeadline'][0]),'default',
                                array('class'=>'error-box error-message'));
                            }
                             //$this->redirect(array('controller'=>'PreferenceDeadlines','action'=>'index'));
                        }   
			     } else {
			                    $error=$this->AcceptedStudent->invalidFields();
			               
			                     if(isset($error['reserved_place'][0])){
			                        $this->Session->setFlash(__('<span></span>'.$error['reserved_place'][0]),'default',array('class'=>'error-box error-message'));
			                        $this->redirect(array('controller'=>'reservedPlaces','action'=>'add'));
			                     } elseif(isset($error['placement_result_criteria'])){
			                        $this->Session->setFlash(
			                        __('<span></span>'.$error['placement_result_criteria'][0]),
			                        'default',array('class'=>'error-box error-message'));
			                         $this->redirect(array('controller'=>'placementsResultsCriterias','action'=>'add'));
			                     } elseif(isset($error['participating_department'])){
			                        $this->Session->setFlash(
			                        __('<span></span>'.$error['participating_department'][0]),'default',

			                        array('controller'=>'participatingDepartments','action'=>'add_quota'));
			                     } else {
			                         $this->Session->setFlash(__('<span></span>Please fill the input fields'),'default',array('class'=>'error-box error-message'));
			                     }      
			             }
			       } else {
			             $this->Session->setFlash('<span></span>There is no student for the selected academic year that needs auto placement.This happens if there is no student for the given academic year or all students are auto or directly placed to department','default', array('class' => 'error-box error-message'));
	                  $this->redirect(array('controller'=>'placement','action'=>'index'));
                        
			       }
			  } else {
			      $this->Session->setFlash('<span></span>You have already run an auto placement for '.$this->request->data['AcceptedStudent']['academicyear'].' academic year. In order to run again you have to cancell the previous auto placement first ','default', 
array('class' => 'error-box error-message'));
			    $this->redirect(array('action'=>'cancel_auto_placement'));
			  }
			} else {
			  $this->Session->setFlash(__('<span></span>Please select academic year to run the auto placement'),'default',array('class'=>'error-box error-message'));
			}
         
        }
	  
	}

	public function __manual_placement () {
         if(!empty($this->request->data)) {
            //debug($this->request->data);
			if(!empty($this->request->data['AcceptedStudent']['academicyear'])){
			       
			         $selectedAcademicYear = $this->request->data['AcceptedStudent']['academicyear'];
			         $conditions = array("AcceptedStudent.academicyear LIKE" =>
			            $selectedAcademicYear.'%',
			            "AcceptedStudent.college_id"=>
			            $this->college_id,
			            'AcceptedStudent.placementtype'=>AUTO_PLACEMENT,
			            "AcceptedStudent.Placement_Approved_By_Department is null");
	                    $acceptedStudents=$this->paginate($conditions);

		                $this->set('acceptedStudents',$acceptedStudents);
		                if(isset($this->request->data['cancelplacement'])){
		                      foreach($this->request->data['AcceptedStudent'] as $k=>&$v) {
		                            $v['department_id']=0;
		                            $v['placementtype']=CANCELLED_PLACEMENT;
		                      }
		                      if($this->AcceptedStudent->saveAll(
			                    $this->request->data['AcceptedStudent'])) {

	                            $conditions = array("AcceptedStudent.academicyear LIKE" =>
			                    $selectedAcademicYear.'%',"AcceptedStudent.college_id"=>
			                    $this->college_id,
			                    'AcceptedStudent.placementtype'=>CANCELLED_PLACEMENT);
		                         $acceptedStudents=$this->paginate($conditions);
		                        $this->set('acceptedStudents',$acceptedStudents);
                                 $this->Session->setFlash(__('<span></span>The auto placement for
				                 all students of '.$this->college_name.' for '.$selectedAcademicYear.' academic year has been 
				                 cancelled. Please rerun the auto placement to assign students to departments or use direct assignment to assign to department.', true),
				                 'default',array('class'=>'success-box success-message'));
				               

			                    } else {
				                  $this->Session->setFlash('<span></span>'.__('The auto placement couldn\'t be cancelled. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                    }
		                
		                }
	               
	               $this->set('selected_academic_year',true);
	        } else {
	        
	         $this->Session->setFlash('<span></span>'.__('Please select academic year'),
	         'default',array('class'=>'error-box error-message'));
	        }
	      
	     } // end of not empty
	    
	}

     public function cancel_auto_placement () {
         $this->paginate=array('limit'=>500000);
         if(!empty($this->request->data)) {
            //debug($this->request->data);
			if(!empty($this->request->data['AcceptedStudent']['academicyear'])){
			        
			         $selectedAcademicYear = $this->request->data['AcceptedStudent']['academicyear'];
			         $conditions = array("AcceptedStudent.academicyear LIKE" =>
			            $selectedAcademicYear.'%',"AcceptedStudent.college_id"=>
			            $this->college_id,
			            'AcceptedStudent.placementtype'=>AUTO_PLACEMENT,
			            'AcceptedStudent.program_type_id'=>PROGRAM_TYPE_REGULAR,
	        		    'AcceptedStudent.program_id'=>PROGRAM_UNDEGRADUATE,
			            "AcceptedStudent.Placement_Approved_By_Department is null");
	                    $acceptedStudents=$this->paginate($conditions);

		                $this->set('acceptedStudents',$acceptedStudents);
		               
	               $this->set('selected_academic_year',true);
	        } else {
	        
	         $this->Session->setFlash('<span></span>'.__('Please select academic year'),
	         'default',array('class'=>'error-box error-message'));
	        }
	      
	     } // end of not empty
	     
	      if(!empty($this->request->data) && isset($this->request->data['cancelplacement'])){
                  $selected_academic_year=null;
                  foreach($this->request->data['AcceptedStudent'] as $k=>&$v) {
                        $v['minute_number']=NULL;
						$v['department_id']=NULL;
                        $v['placementtype']=CANCELLED_PLACEMENT;
                        $selected_academic_year=$v['academicyear'];
						//The following break is used as the code is replaced by the following code and we need it to be excuted once to get academic year
						break;
                  }
			     $conditions = array("AcceptedStudent.academicyear" =>$selected_academic_year,
					"AcceptedStudent.college_id"=>$this->college_id,
			        'AcceptedStudent.placementtype'=>AUTO_PLACEMENT,
			        'AcceptedStudent.program_type_id'=>PROGRAM_TYPE_REGULAR,
				    'AcceptedStudent.program_id'=>PROGRAM_UNDEGRADUATE,
			        "AcceptedStudent.Placement_Approved_By_Department is null");
		                $this->Paginator->settings=$this->paginate;
				$this->Paginator->settings['conditions']=$conditions;
         $acceptedStudents=$this->Paginator->paginate('AcceptedStudent'); 
        
					$placement_cancelation_list = array();
					foreach($acceptedStudents as $acceptedStudent) {
						$index = count($placement_cancelation_list);
						$placement_cancelation_list[$index]['id'] = $acceptedStudent['AcceptedStudent']['id'];
						$placement_cancelation_list[$index]['placementtype'] = CANCELLED_PLACEMENT;
						$placement_cancelation_list[$index]['minute_number']=NULL;
						$placement_cancelation_list[$index]['department_id']=NULL;
					}

		                   if($this->AcceptedStudent->saveAll($placement_cancelation_list)) {
							  //The following code is replaced by the above as a solution for the limitation on the number of post fields
		                      //if($this->AcceptedStudent->saveAll($this->request->data['AcceptedStudent'])) {
	                            $conditions = array("AcceptedStudent.academicyear LIKE" =>
			                    $selected_academic_year.'%',"AcceptedStudent.college_id"=>
			                    $this->college_id,
			                    'AcceptedStudent.placementtype'=>CANCELLED_PLACEMENT);
		                         $acceptedStudents=$this->paginate($conditions);
		                        $this->set('acceptedStudents',$acceptedStudents);
		                        $this->set('selected_academic_year',true);
		                        $this->set('hide_button',true);
		                        $college_name=$this->AcceptedStudent->College->field('College.name', array('College.id '=>$this->college_id));
                                 $this->Session->setFlash('<span></span>'.__('The auto placement for
				                 all students of '.$college_name.' for '.$selected_academic_year.' academic year has been 
				                 cancelled. Please re-run the auto placement to assign students to departments or use direct assignment to department.', true),
				                 'default',array('class'=>'success-box success-message'));
				                 

			                    } else {
				                  $this->Session->setFlash('<span></span>'.__('The auto placement couldn\'t be cancelled. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                    }
		                
		   }
	             
	    
	}


	function _transferToDepartment($data=null){
	    $transferToDepartment=array();
	   

	    if(!empty($data['AcceptedStudent']['department_id'])){
			       $department_id=$data['AcceptedStudent']['department_id'];
			       $counter=0;


			       $arraycountvalue=array_count_values($this->request->data['AcceptedStudent']['directplacement']);

			       if(isset($arraycountvalue[1])&&!empty($arraycountvalue[1])){
			           foreach($this->request->data['AcceptedStudent']['directplacement']
			           as $key=>$value){
			             if($value){
			             	$student=$this->AcceptedStudent->find('first',
			             		array('conditions'=>array('AcceptedStudent.id'=>$key),
			             			'contain'=>array('Student')));

			                $transferToDepartment['AcceptedStudent'][$counter]['id']=$key;
			                $transferToDepartment['AcceptedStudent'][$counter]['department_id']=$department_id;
			                $transferToDepartment['AcceptedStudent'][$counter]['placementtype']=DIRECT_PLACEMENT;

			                $transferToDepartment['Student'][$counter]['department_id']=$department_id;
			                $transferToDepartment['Student'][$counter]['id']=$student['Student']['id'];


			                $counter++;
			             }


			       }
			       return $transferToDepartment;

			    } else {
			      return "NOSTUDENT";
			    }
	   } else {
			   return "NODEPARTMENT";
	   }
	}

	function _cancelPlacement($data=null){
	               $cancelledplacement=array();
	   		      // $department_id=$data['AcceptedStudent']['department_id'];
			       $counter=0;

			       $arraycountvalue=array_count_values($this->request->data['AcceptedStudent']['directplacement']);

			       if(isset($arraycountvalue[1])&&!empty($arraycountvalue[1])){
			           foreach($this->request->data['AcceptedStudent']['directplacement']
			           as $key=>$value){
			             if($value){

			                $cancelledplacement['AcceptedStudent'][$counter]['id']=$key;
			                $cancelledplacement['AcceptedStudent'][$counter]['department_id']=null;
			                $cancelledplacement['AcceptedStudent'][$counter]['placementtype']=CANCELLED_PLACEMENT;
			                $counter++;

			             }


			       }
			       return $cancelledplacement;

			    } else {
			      return "NOSTUDENT";
			    }

	}
	
	function auto_fill_preference($academicyear = '2011/12'){
	        $accepted_students=$this->AcceptedStudent->find('all',array('recursive' => '-1', 'conditions'=>array(
	        'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.academicyear LIKE'=>$academicyear)));
	        $detail_of_participating_department=ClassRegistry::init('ParticipatingDepartment')
                  ->find('all',array('recursive' => '-1', 'conditions'=>array('ParticipatingDepartment.college_id'=>$this->college_id,'ParticipatingDepartment.academic_year'=>$academicyear)));
            $number_of_participating_department=count($detail_of_participating_department);
        //debug($detail_of_participating_department);
		//debug($data);
		$departments = array();
		foreach($detail_of_participating_department as $key => $participating_department) {
		//debug($participating_department['ParticipatingDepartment']['department_id']);
			array_push($departments, $participating_department['ParticipatingDepartment']['department_id']);
			}
		//debug($departments);
		$count = 0;
		$preference_selection = array();
		foreach($accepted_students as $key => $accepted_student){
			$filled = $this->AcceptedStudent->Preference->find('count', array('conditions' => array(
			'Preference.accepted_student_id' => $accepted_student['AcceptedStudent']['id'])));
			if($filled <= 0)
				{
				shuffle($departments);
				for($i = 1; $i <= count($departments); $i++)
				{
				$preference_selection[$count]['accepted_student_id'] = $accepted_student['AcceptedStudent']['id'];
				$preference_selection[$count]['academicyear'] = $accepted_student['AcceptedStudent']['academicyear'];
				$preference_selection[$count]['college_id'] = $this->college_id;
				$preference_selection[$count]['department_id'] = $departments[$i-1];
				$preference_selection[$count]['preferences_order'] = $i;
				$count++;
				}
				}
			
		}
		$this->AcceptedStudent->Preference->saveAll($preference_selection);
		return $this->redirect(array('controller'=>'preferences','action'=>'index'));
	/*
	$data=$this->AcceptedStudent->find('all',array('conditions'=>array(
	        'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.academicyear LIKE'=>$academicyear)));
	        $detail_of_participating_department=ClassRegistry::init('ParticipatingDepartment')
                  ->find('all',array('conditions'=>array('ParticipatingDepartment.college_id'=>$this->college_id,'ParticipatingDepartment.academic_year'=>$academicyear)));
            $number_of_participating_department=count($detail_of_participating_department);
        debug($detail_of_participating_department);
		debug($data);
		
		 exit();
		 $preference=array();
         $preference_random=array('numberOfVariables'=>$count($detail_of_participating_department));
         $preference_order=array();
          // Loop through our range of variables and set a random number for each one.
        foreach (range(1, $preference_random['numberOfVariables']) as $variable) {
            
            $preference_order[] = rand(1,count($detail_of_participating_department));
            //check uniquiness of each array
           
            
        }
         foreach($data as $key=>$value){
                foreach($detail_of_participating_department as $k=>$v){
                //accepted_student_id	academicyear	college_id	department_id	preferences_order
                    $randompreferenceorder=rand(1,$number_of_participating_department);
                    $preference_order=1;
                    if($key>0){
                    $preference_order=$preference['Preference'][$key-1]['preferences_order']!=$randompreferenceorder?$randompreferenceorder:rand(1,$number_of_participating_department);
                    }
	                $preference['Preference'][$key]['accepted_student_id']=$value['AcceptedStudent']['id'];
	                $preference['Preference'][$key]['academicyear']=$academicyear;
	                $preference['Preference'][$key]['department_id']=$v['ParticipatingDepartment']['department_id'];
	                 $preference['Preference'][$key]['college_id']=$v['ParticipatingDepartment']['college_id'];
	                $preference['Preference'][$key]['preferences_order']=$preference_order;
	            }
	      }*/
	}
	public function import_newly_students()
	{
        $regions = $this->AcceptedStudent->Region->find('list');
        $colleges = $this->AcceptedStudent->College->find('list');
		
        $departments = $this->AcceptedStudent->Department->find('list');
        $streams['Computational Science']="Computational Science";
        $streams['Natural Science']="Natural Science";
        $streams['Health Science']="Health Sciences";
        
        $programs = $this->AcceptedStudent->Program->find('list');
       
        $programTypes = $this->AcceptedStudent->ProgramType->find('list');
        
        $departments_organized_by_college=$this->AcceptedStudent->College->find('all',
		array('fields'=>array('id','name'),'contain'=>array('Department'=>array('id','name'))));
	    
		$return=array();

		if (!empty($departments_organized_by_college)) {
		    foreach($departments_organized_by_college as $dep_id=>$dep_name) {
               
			   if(!empty($dep_name['Department'])) {
				  foreach($dep_name['Department'] as $k=>$v) {
						 $return[$dep_name['College']['name']]
[$v['id']]=$v['name'];	
				  }
			   } else {
                  $return[$dep_name['College']['name']][$dep_name['College']['id']]=$dep_name['College']['name'];	
			   }
		    }
		}
		$departments_organized_by_college=$return;
		
        $this->set(compact('regions','colleges','streams','departments','programs','programTypes',
        'departments_organized_by_college'));	   
        if (!empty($this->request->data)
             && is_uploaded_file($this->request->data['AcceptedStudent']['File']['tmp_name'])){
                //check the file type before doing the fucken manipulations.
			     if(strcasecmp($this->request->data['AcceptedStudent']['File']['type'],'application/vnd.ms-excel')) {
                     $this->Session->setFlash('<span></span>'.__('Importing Error. Please  save your excel file as "Excel 97-2003 Workbook" type while you saved the file and import again. Try also to use other 97-2003 file types if you are using office 2010 or recent versions. Current file format is: '.$this->request->data['AcceptedStudent']['File']['type']),'default', array('class'=>'error-box error-message'));
                    return ;
                }

                $data = new Spreadsheet_Excel_Reader();
                // Set output Encoding.
                $data->setOutputEncoding('CP1251');
                $data->read($this->request->data['AcceptedStudent']['File']['tmp_name']);
               
                        
               $headings = array();
               
               $xls_data = array();
             
               //check without department 
              //TODO: Remove studentnumber
               $required_fields = array('first_name','middle_name','last_name',
               'gpa', 'program', 'program_type',
                'stream','university_attended','department',
                'sex','attended_stream');
               
                $non_existing_field=array();
                $non_valide_rows=array();
                if(empty($data->sheets[0]['cells'])) {
                     $this->Session->setFlash('<span></span>'.__('Importing Error. The excel file 
                     you uploaded is empty.', true),'default', array('class'=>'error-box error-message'));
                    return ;
                }
                if(empty($data->sheets[0]['cells'][1])) {
                     $this->Session->setFlash('<span></span>'.
                     __('Importing Error. Please insert your filed name (first_name,
                      middle_name, last_name, total_results, program_type, stream,motherTongue,department, region, sex)  at first row of your excel file.', true),'default', array('class'=>'error-box error-message'));
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
                      $this->Session->setFlash('<span></span>'.__('Importing Error. '.$field_list.' is/are required in 
                      the excel file you imported at first row.', true),'default', array('class'=>'error-box error-message'));  
                      return;
                  }
                else
                {
               
                $colleges = $this->AcceptedStudent->College->find('list');
                foreach($colleges as $k => $v)
				$colleges[$k] = strtoupper(trim($v));

                $program_types = $this->AcceptedStudent->ProgramType->find('list');
                foreach($program_types as $k => $v)
                  $program_types[$k] = strtoupper(trim($v));
                $regions = $this->AcceptedStudent->Region->find('list');
                foreach($regions as $k => $v)
                  $regions[$k] = strtoupper(trim($v));
                $programs = $this->AcceptedStudent->Program->find('list');
                foreach($programs as $k => $v)
                  $programs[$k] = strtoupper(trim($v));
                foreach($departments as $k => $v)
                  $departments[$k] = strtoupper(trim($v));
               
                $fields_name_acceptedStudents_table=$data->sheets[0]['cells'][1];
              
                $duplicated_student_number = array();
                for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                    $row_data = array();
                    $name_error_duplicate = false;
                    $department_against_college=0;
                    for ($j = 1; $j <= count($fields_name_acceptedStudents_table); $j++) 
                    {
                          
                            if($fields_name_acceptedStudents_table[$j] == "stream" 
                            && in_array(trim($data->sheets[0]['cells'][$i][$j]), $colleges)== 0)
                                {
                                   $department_against_college=array_search(strtoupper(trim(
                                           $data->sheets[0]['cells'][$i][$j])),$colleges);
                                  
                              }
                           
                            //check student number is given and populate with value 
                          
                            if($fields_name_acceptedStudents_table[$j] == "studentnumber")
                            {
                                $currentStudentNumber=trim($data->sheets[0]['cells'][$i][$j]);
                                if (isset($currentStudentNumber)&& !empty($currentStudentNumber)) {
                                   $duplicated_student_number[$currentStudentNumber]=
                                   isset($duplicated_student_number[$currentStudentNumber]) ?
                                   $duplicated_student_number[$currentStudentNumber] : 0 +1;
                                  
                                   if(isset($duplicated_student_number[$currentStudentNumber])
                                   && $duplicated_student_number[$currentStudentNumber]>1) {
                                   
                                       $non_valide_rows[] = "Duplicated student number at row number ".$i; 
                                       continue;
                                   }
                                } else {
                                   $duplicated_student_number[$currentStudentNumber]=0;
                                } 
                            }

                            if (strcasecmp($fields_name_acceptedStudents_table[$j],
                                   "department")==0 ) {
                                         
                                          // is department belongs the selected college ?
                                           $department_id=array_search(strtoupper(trim(
                                           $data->sheets[0]['cells'][$i][$j])),$departments);

                                           $your_college_id = $this->AcceptedStudent->Department->
                                           field('college_id',array('Department.id'=>$department_id));
                                         
                                           if ($your_college_id != $department_against_college) {
                                               $non_valide_rows[] = "The department entered is not belong the stream entered on row number ".$i;
                                             continue;
                                           }
                            } 
                          
                           if($fields_name_acceptedStudents_table[$j] == "gpa" && (!isset($data->sheets[0]['cells'][$i][$j]) || (trim($data->sheets[0]['cells'][$i][$j]) == "" || !is_numeric($data->sheets[0]['cells'][$i][$j])))){
                                   //TODO: Uncomment the following two lines
                                    $non_valide_rows[] = "Please enter a valid  result on row number ".$i;
                                continue;
                            }
                           
                              if(strcasecmp($fields_name_acceptedStudents_table[$j], "sex") ==0 && (!isset($data->sheets[0]['cells'][$i][$j]) || !(strcasecmp(trim($data->sheets[0]['cells'][$i][$j]),'m') || strcasecmp($data->sheets[0]['cells'][$i][$j],'f') || strcasecmp(trim($data->sheets[0]['cells'][$i][$j]),'male') || strcasecmp($data->sheets[0]['cells'][$i][$j],'female'))))
                                {
                                $non_valide_rows[] = "Invalid sex entry on row number ".$i;
                                continue;
                             }
                             //TODO   
                            if(!$name_error_duplicate && in_array($fields_name_acceptedStudents_table[$j], 
                            array('first_name','middle_name','last_name',
                            'attended_stream','university_attended
')) && 
                            (!isset($data->sheets[0]['cells'][$i][$j]) || 
                            trim($data->sheets[0]['cells'][$i][$j]) == NULL))
                               {
                                
                                $non_valide_rows[] = "Please enter first, middle,last name,attended_stream and university_attended  on row number ".$i;
                                $name_error_duplicate = true;
                                continue;
                              }
                                //debug($fields_name_acceptedStudents_table[$j]);
                               if($fields_name_acceptedStudents_table[$j] == "stream" &&
                                (!isset($data->sheets[0]['cells'][$i][$j]) || 
                                !in_array(strtoupper(trim($data->sheets[0]['cells'][$i][$j])), $colleges)))
                                {
                                
                                $non_valide_rows[] = "Please enter a valid stream name on row number ".$i;
                                continue;
                                }
                            if(strcasecmp($fields_name_acceptedStudents_table[$j],"program_type") == 0 && 
                            (!isset($data->sheets[0]['cells'][$i][$j]) || 
                            !in_array(strtoupper(trim($data->sheets[0]['cells'][$i][$j])), $program_types)))
                                {
                                
                                $non_valide_rows[] = "Please enter a valid program type on row number ".$i;
                                continue;
                                }
                                
                            if(strcasecmp($fields_name_acceptedStudents_table[$j],"program") == 0 && (!isset($data->sheets[0]['cells'][$i][$j]) || !in_array(strtoupper(trim($data->sheets[0]['cells'][$i][$j])), $programs)))
                                {
                                 $non_valide_rows[] = "Please enter a valid program on row number ".$i;
                            
                                 continue;
                                }

                            
                         if(in_array($fields_name_acceptedStudents_table[$j], $required_fields))
                            {
                            if($fields_name_acceptedStudents_table[$j] == "stream"){
            
                              $college_id=array_search(strtoupper(trim($data->sheets[0]['cells'][$i][$j])),$colleges);
                              $row_data['college_id'] = $college_id;
                            } else if (strcasecmp($fields_name_acceptedStudents_table[$j],"department")==0) {
                              
                             if(isset($data->sheets[0]['cells'][$i][$j]) && 
                             $data->sheets[0]['cells'][$i][$j]!="") {
                             
                                $department_id=array_search(
                                strtoupper(trim($data->sheets[0]['cells'][$i][$j])),$departments);
                             
                                $row_data['department_id'] = $department_id;
                              }
                            }
                            else if($fields_name_acceptedStudents_table[$j] == "program_type"){
                              $program_type_id=array_search(strtoupper(trim($data->sheets[0]['cells'][$i][$j])),$program_types);
                              $row_data['program_type_id'] = $program_type_id;           
                             }
                            else if(strcasecmp($fields_name_acceptedStudents_table[$j],"program")==0){
                              $program_id=array_search(strtoupper(trim($data->sheets[0]['cells'][$i][$j])),$programs);
                              $row_data['program_id'] = $program_id;           
                             }  else {
                              $row_data[$fields_name_acceptedStudents_table[$j]] = isset($data->sheets[0]['cells'][$i][$j]) ? $data->sheets[0]['cells'][$i][$j] : '';
                            }
                        } else{
                        	  $row_data[$fields_name_acceptedStudents_table[$j]] = isset($data->sheets[0]['cells'][$i][$j]) ? $data->sheets[0]['cells'][$i][$j] : '';
                        }
                    }
                      
                    $selectedAcademicyear=$this->request->data['AcceptedStudent']['academicyear'];
                    $row_data['academicyear']=$selectedAcademicyear;
                  
                    if(isset($row_data['sex']) && strcasecmp($row_data['sex'],'f')==0){
                        
                         $row_data['sex']='female';
                    }
                    if(isset($row_data['sex']) && strcasecmp($row_data['sex'],'m')==0){
                         $row_data['sex']='male';
                    }
                    $name_check = explode(' ', $row_data['first_name']);
                    if(count($name_check) >= 3 
                    && 0) {
							$row_data['first_name']=ucfirst(strtolower($name_check[0]));
							$row_data['middle_name']=ucfirst(strtolower($name_check[1]));
							$row_data['last_name']=ucfirst(strtolower($name_check[2]));
                    } else {
						$row_data['first_name']=ucfirst(strtolower($row_data['first_name']));
						$row_data['middle_name']=ucfirst(strtolower($row_data['middle_name']));
						$row_data['last_name']=ucfirst(strtolower($row_data['last_name']));
					   
					}
			        if(!empty($row_data['studentnumber'])) {	
					               // debug($row_data['studentnumber']);
					    $student_number_depulicated=$this->AcceptedStudent->find('count',
				                   array('conditions'=>array('AcceptedStudent.studentnumber'=>$row_data['studentnumber']),'recursive'=>-1));
							
									 if(!empty($student_number_depulicated)) {
									 $non_valide_rows[] = "The student number  on row number ".$i." has already existed or imported.Please remove it from your excel file.";
									 }			
					}
                    if(isset($row_data['gpa']) && !empty($row_data['gpa'])){
					
					} else {
                         unset($row_data['gpa']);
					}
					 $is_duplicated=$this->AcceptedStudent->find('count',
                   array('conditions'=>$row_data,'recursive'=>-1));

                   if($is_duplicated>0){
                    $non_valide_rows[] = "The  data on row number ".$i." has already existed or imported.Please remove it from your excel file.";
                   }
			
                   $xls_data[] = array('AcceptedStudent' => $row_data);
                   $data->sheets[0]['cells'][$i]=null;
                   if(count($non_valide_rows) == 19) {
					   		$non_valide_rows[] = "Please check other similar errors in the file you imported.";
					   		break;
					}
			    }
               
                   //invalid rows 
                   if(count($non_valide_rows) > 0)
                   {
                      $row_list = "";
                      $this->Session->setFlash('<span></span>'.__('Importing Error. 
                      Please correct the following listed rows in your excel file.', true),
                      'default', array('class'=>'error-box error-message'));
                      $this->set('non_valide_rows',$non_valide_rows);
                      return;
                    }    
                }
               
                if(!empty($xls_data)){   
                    $reformat_for_saveAll=array();
                    foreach ($xls_data as $xlk=>&$xlv) {
			
                        if(empty($xlv['AcceptedStudent']['total_results'])){
                           unset($xlv['AcceptedStudent']['total_results']);
                        }
                        if(!empty($xlv['AcceptedStudent']['department_id'])) {
                            $xlv['AcceptedStudent']['placementtype']=REGISTRAR_ASSIGNED;
                        }
                        $reformat_for_saveAll['AcceptedStudent'][]=$xlv['AcceptedStudent'];
                      
                    }
                   
                    if($this->AcceptedStudent->saveAll($reformat_for_saveAll['AcceptedStudent'], array('validate'=>'first'))) {
						//Get college user detail by college_id, is_admin
						$college_admin = ClassRegistry::init('Staff')->find('first',
							array('conditions' =>array(
		'Staff.college_id' => $reformat_for_saveAll['AcceptedStudent'][0]['college_id'],'User.role_id' => ROLE_COLLEGE,
		'User.is_admin' => 1),'contain' => array('User')
							)
						);
						if(!empty($college_admin)) {
							$auto_message['AutoMessage']['message'] = count($reformat_for_saveAll['AcceptedStudent']).' students are assigned to your stream. Please use view accepted students tool to view list of students.';
							$auto_message['AutoMessage']['read'] = 0;
							$auto_message['AutoMessage']['user_id'] = $college_admin['User']['id'];
							ClassRegistry::init('AutoMessage')->save($auto_message);
						}
                        $this->Session->setFlash('<span></span>Success. Imported '. count($reformat_for_saveAll['AcceptedStudent']) .' records.','default',array('class'=>'success-box success-message'));
                        //$this->redirect(array('action'=>'index'));
                    } else {
                        $this->Session->setFlash('<span></span>Error. Unable to import records. Please try again.','default',array('class'=>'error-box error-message'));
			 
                    } 
               } else {
                 $this->Session->setFlash('<span></span>Error. Unable to import records. Please try again.','default',array('class'=>'error-box error-message'));
               }            
        } 

	}
	
	function _getListOfAcceptedStudentsWithoutPreference($academicyear=null,$college_id=null){
	     
            $acceptedStudents=$this->AcceptedStudent->find('all',
                        array('conditions'=>array(                            
                                "OR"=>array(
                 'AcceptedStudent.department_id IS NULL',
                 'AcceptedStudent.department_id '=>array('',0)),
                 
                 "AcceptedStudent.academicyear LIKE" =>
                                        $academicyear.'%',
                                        "AcceptedStudent.college_id" =>$college_id,
                                        "AcceptedStudent.Placement_Approved_By_Department is null",
                                        "OR"=>array("AcceptedStudent.placementtype IS NULL",
                                        "AcceptedStudent.placementtype"=>CANCELLED_PLACEMENT))
                              ));
          
            $acceptedStudentscount=$this->AcceptedStudent->find('count',
                        array('conditions'=>array(                            
                                "OR"=>array(
                 'AcceptedStudent.department_id IS NULL',
                 'AcceptedStudent.department_id '=>array('',0)),
                 
                 "AcceptedStudent.academicyear LIKE" =>
                                        $academicyear.'%',
                                        "AcceptedStudent.college_id" =>$college_id,
                                        "AcceptedStudent.Placement_Approved_By_Department is null" ,
                                        "OR"=>array("AcceptedStudent.placementtype IS NULL",
                                        "AcceptedStudent.placementtype"=>CANCELLED_PLACEMENT))
                              ));
            $not_completed_count=0;
            $preference_not_completed=array();
			        foreach($acceptedStudents as $k=>$value){
			            $count=count($value['Preference']);
			            if(!$count){
			              $preference_not_completed[]=$value;
			              $not_completed_count++;
			            }
			        }
		  $not_completed_preference=($not_completed_count/$acceptedStudentscount)*100;    
          return  $not_completed_preference;
	       
	}
	
	// function to view pdf 
	function print_autoplaced_pdf() {
	    $autoplacedstudents=$this->Session->read('autoplacedstudents');
	    $selected_academic_year = $this->Session->read('selected_academic_year');
	    
	    /*$placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array('AcceptedStudent.college_id'=>
	                   $this->college_id,'AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%',
	                   'AcceptedStudent.placementtype'=>AUTO_PLACEMENT),
	                   'order'=>array('AcceptedStudent.department_id asc',
	                   'AcceptedStudent.EHEECE_total_results desc',
	                   'AcceptedStudent.freshman_result desc')));
	                   $departments=ClassRegistry::init('ParticipatingDepartment')->find("all",
	                   array('fields'=>'ParticipatingDepartment.department_id',
	                   "conditions"=>array('ParticipatingDepartment.academic_year LIKE'=>$selected_academic_year.'%',
	    'ParticipatingDepartment.college_id'=>$this->college_id)));
	                 
	                 if (empty($placedstudent)) {
	                      $this->Session->setFlash('<span></span> No auto placement report for
	                      the selected academic year.','default',
		                     array('class'=>'info-box info-message'));
		                     $this->redirect(array('action'=>'auto_placement_approve_college'));
		              }
		             
                     $dep_id=array();
                     foreach($departments as $k=>$v){
                        $dep_id[]=$v['ParticipatingDepartment']['department_id'];
                     }
                   
                     $dep_name=$this->AcceptedStudent->Department->find('list',
                     array('conditions'=>array(
                     'Department.id'=>$dep_id)));
                     $newly_placed_student=array();
                     foreach($dep_name as $dk=>$dv){
                             foreach($placedstudent as $k=>$v){
                                if($dk==$v['Department']['id']){
                                        $newly_placed_student[$dv][$k]=$v;
                                    }
                              }
                              $newly_placed_student['auto_summery'][$dv]['C']=$this->
                              AcceptedStudent->find('count',
                              array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>
                              $selected_academic_year.'%','AcceptedStudent.department_id'=>$dk,
                              'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'C')));
                              $newly_placed_student['auto_summery'][$dv]['Q']=0;
                      }
        $autoplacedstudents=$newly_placed_student;      
	    */
	    $college_name=$this->college_name;
	    //debug($college_name);
	    $this->set(compact('autoplacedstudents','college_name','selected_academic_year'));
	    $this->layout='pdf';
	    $this->render();
	   // $this->Session->delete('autoplacedstudents');
	
	}
	// function to export
	function export_autoplaced_xls() {
	     //$selected_academic_year = $this->Session->read('selected_academic_year');
	    /*
	    $placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array('AcceptedStudent.college_id'=>
	                   $this->college_id,'AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%',
	                   'AcceptedStudent.placementtype'=>AUTO_PLACEMENT),
	                   'order'=>array('AcceptedStudent.department_id asc',
	                   'AcceptedStudent.EHEECE_total_results desc',
	                   'AcceptedStudent.freshman_result desc')));
	                   $departments=ClassRegistry::init('ParticipatingDepartment')->find("all",
	                   array('fields'=>'ParticipatingDepartment.department_id',
	                   "conditions"=>array('ParticipatingDepartment.academic_year LIKE'=>$selected_academic_year.'%',
	    'ParticipatingDepartment.college_id'=>$this->college_id)));
	                 
	                 if (empty($placedstudent)) {
	                      $this->Session->setFlash('<span></span> No auto placement report for
	                      the selected academic year.','default',
		                     array('class'=>'info-box info-message'));
		                     $this->redirect(array('action'=>'auto_placement_approve_college'));
		              }
		             
                     $dep_id=array();
                     foreach($departments as $k=>$v){
                        $dep_id[]=$v['ParticipatingDepartment']['department_id'];
                     }
                   
                     $dep_name=$this->AcceptedStudent->Department->find('list',
                     array('conditions'=>array(
                     'Department.id'=>$dep_id)));
                     $newly_placed_student=array();
                     foreach($dep_name as $dk=>$dv){
                             foreach($placedstudent as $k=>$v){
                                if($dk==$v['Department']['id']){
                                        $newly_placed_student[$dv][$k]=$v;
                                    }
                              }
                              $newly_placed_student['auto_summery'][$dv]['C']=$this->
                              AcceptedStudent->find('count',
                              array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>
                              $selected_academic_year.'%','AcceptedStudent.department_id'=>$dk,
                              'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'C')));
                              $newly_placed_student['auto_summery'][$dv]['Q']=0;
                      }
        */
        $autoplacedstudents=$this->Session->read('autoplacedstudents');
       // $autoplacedstudents=$newly_placed_student; 
	    $this->set('autoplacedstudents',$autoplacedstudents);
	    //$this->Session->delete('autoplacedstudents');
	}
	
	// funcation to produce report of autoplacement 
	
	public function auto_report() {
		    /*
	       if(!empty($this->request->data)){
	                  $this->Session->delete('autoplacedstudents');
	                  $conditions=null;
	                  $selected_academic_year=$this->request->data['AcceptedStudent']['academicyear'];
	                  if($selected_academic_year) {
	                        
		                    
	                   } else {
	                        $selected_academic_year=$this->AcademicYear->current_academicyear();
	                      
	                   }
	                   $placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array('AcceptedStudent.college_id'=>
	                   $this->college_id,'AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%',
	                   'AcceptedStudent.placementtype'=>AUTO_PLACEMENT),
	                   'order'=>array('AcceptedStudent.department_id asc',
	                   'AcceptedStudent.EHEECE_total_results desc',
	                   'AcceptedStudent.freshman_result desc')));
	                   $departments=ClassRegistry::init('ParticipatingDepartment')->find("all",
	                   array('fields'=>'ParticipatingDepartment.department_id',
	                   "conditions"=>array('ParticipatingDepartment.academic_year LIKE'=>$selected_academic_year.'%',
	    'ParticipatingDepartment.college_id'=>$this->college_id)));
	                 
	                 if (empty($placedstudent)) {
	                      $this->Session->setFlash('<span></span> No auto placement report for
	                      the selected academic year.','default',
		                     array('class'=>'info-box info-message'));
		                     $this->redirect(array('action'=>'auto_placement_approve_college'));
		              }
		             
                     $dep_id=array();
                     foreach($departments as $k=>$v){
                        $dep_id[]=$v['ParticipatingDepartment']['department_id'];
                     }
                   
                     $dep_name=$this->AcceptedStudent->Department->find('list',
                     array('conditions'=>array(
                     'Department.id'=>$dep_id)));
                     $newly_placed_student=array();
                     foreach($dep_name as $dk=>$dv){
                             foreach($placedstudent as $k=>$v){
                                if($dk==$v['Department']['id']){
                                        $newly_placed_student[$dv][$k]=$v;
                                    }
                              }
                              $newly_placed_student['auto_summery'][$dv]['C']=$this->
                              AcceptedStudent->find('count',
                              array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>
                              $selected_academic_year.'%','AcceptedStudent.department_id'=>$dk,
                              'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'C')));
                              $newly_placed_student['auto_summery'][$dv]['Q']=$this->
                              AcceptedStudent->find('count',
                              array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>
                              $selected_academic_year.'%','AcceptedStudent.department_id'=>$dk,
                              'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'Q')));
                      }
                    // debug($newly_placed_student);
                    $this->Session->write('selected_academic_year',$selected_academic_year);
                    $this->Session->write('autoplacedstudents',$newly_placed_student);
                    $this->set('autoplacedstudents',$newly_placed_student);             
	     }
	     */
	 	  $this->__view_placement_report();

	}
	
	
	function __view_placement_report()  
    {

		 $options = array();
		 $options = array('order'=>array(
	                   'AcceptedStudent.EHEECE_total_results DESC',
	                   'AcceptedStudent.freshman_result DESC'));
         $options['conditions'][]=array('AcceptedStudent.college_id'=>$this->college_id);
		 debug($options);

		 if(isset($this->request->data['Search']) && !empty($this->request->data['Search'])){

            
	            if (isset($this->request->data['Search']['academic_year']) 
			&& !empty($this->request->data['Search']['academic_year'])) {
					$options['conditions'][]=array('AcceptedStudent.academicyear'=>
$this->request->data['Search']['academic_year']);
				 }

			    if (isset($this->request->data['Search']['department_id']) 
			&& !empty($this->request->data['Search']['department_id'])) {
					$options['conditions'][]=array('AcceptedStudent.department_id'=>$this->request->data['Search']['department_id']);
				 }

				
			    if (isset($this->request->data['Search']['sex']) 
			&& !empty($this->request->data['Search']['sex']) &&
$this->request->data['Search']['sex']!='all' ) {

					$options['conditions'][]=array('AcceptedStudent.sex'=>$this->request->data['Search']['sex']);
				 }

				
			    if (isset($this->request->data['Search']['placement_based']) 
			&& !empty($this->request->data['Search']['placement_based']) &&
$this->request->data['Search']['placement_based']!='all' ) {

					$options['conditions'][]=array('AcceptedStudent.placement_based'=>$this->request->data['Search']['placement_based']);
				 }

				if (isset($this->request->data['Search']['placementtype']) 
			&& !empty($this->request->data['Search']['placementtype']) &&
$this->request->data['Search']['placementtype']!='all' ) {

					$options['conditions'][]=array('AcceptedStudent.placementtype'=>$this->request->data['Search']['placementtype']);
				 }

				 if (isset($this->request->data['Search']['result_criteria_id']) 
			&& !empty($this->request->data['Search']['result_criteria_id']) &&
$this->request->data['Search']['result_criteria_id']!='all' ) {
                    //find type of result criteria 
				    $resultCriteriam=ClassRegistry::init('PlacementsResultsCriteria')->find('first',array('conditions'=>array('PlacementsResultsCriteria.id'=>$this->request->data['Search']['result_criteria_id'])));
					if($resultCriteriam['PlacementsResultsCriteria']['prepartory_result']){
						$options['conditions'][]=array(
'AcceptedStudent.EHEECE_total_results >='=>$resultCriteriam['PlacementsResultsCriteria']['result_from'],
'AcceptedStudent.EHEECE_total_results <='=>$resultCriteriam['PlacementsResultsCriteria']['result_to']
);
					} else {
						$options['conditions'][]=array(
'AcceptedStudent.freshman_result >='=>$resultCriteriam['PlacementsResultsCriteria']['result_from'],'AcceptedStudent.freshman_result <='=>$resultCriteriam['PlacementsResultsCriteria']['result_to']);
					}
				}
                
			    $placedstudent=$this->AcceptedStudent->find('all',
array('conditions'=>$options['conditions'],'order'=>array('AcceptedStudent.freshman_result DESC','AcceptedStudent.EHEECE_total_results DESC')));
				
				if (empty($placedstudent)) {
					$this->Session->setFlash('<span></span> There is no report for the selected academic year.','default',array('class'=>'info-box info-message'));
				  // $this->redirect(array('action'=>'auto_placement_approve_college'));
		        } else {
		           $dep_id=array();
				   $departments=ClassRegistry::init('ParticipatingDepartment')->getParticipatingDepartment($this->college_id,$this->request->data['Search']['academic_year']);
				   $dep_id=array_keys($departments);

		          $dep_name=$this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$dep_id)));

				  $newly_placed_student=array();
                  foreach($dep_name as $dk=>$dv)
                  {
                     foreach($placedstudent as $k=>$v){
                        if($dk==$v['Department']['id']){
                                $newly_placed_student[$dv][$k]=$v;
                         }
                      }
                     $newly_placed_student['auto_summery'][$dv]['C']=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear'=>$this->request->data['Search']['academic_year'],'AcceptedStudent.department_id'=>$dk,
'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'C')));
                     $newly_placed_student['auto_summery'][$dv]['CF']=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear'=>$this->request->data['Search']['academic_year'],'AcceptedStudent.department_id'=>$dk,
'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'C',
'AcceptedStudent.sex'=>'female')));
                    $newly_placed_student['auto_summery'][$dv]['QF']=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear'=>$this->request->data['Search']['academic_year'],'AcceptedStudent.department_id'=>$dk,
'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'Q',
'AcceptedStudent.sex'=>'female')));
                    $newly_placed_student['auto_summery'][$dv]['Q']=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear'=>$this->request->data['Search']['academic_year'],'AcceptedStudent.department_id'=>$dk,'AcceptedStudent.college_id'=>$this->college_id,
'AcceptedStudent.placement_based'=>'Q')));
                  }

				if((isset($this->request->data['generatePlacedList']) 
&& !empty($this->request->data['generatePlacedList']))){
						$selected_academic_year=$this->request->data['Search']['academic_year'];
					    $autoplacedstudents=$newly_placed_student;
                       
                         $university=ClassRegistry::init('University')->find('first',
array('order'=>array('University.created DESC')));

                    	$this->set(compact('autoplacedstudents','selected_academic_year','university'));
						$this->response->type('application/pdf');
				 		$this->layout = '/pdf/default';
						$this->render('print_autoplaced_pdf');
						return ;
		         }
				 
			     $this->set('autoplacedstudents',$newly_placed_student);
                       
			}

             $departments=ClassRegistry::init('ParticipatingDepartment')->getParticipatingDepartment($this->college_id,$this->request->data['Search']['academic_year']);
             $resultCriterias=ClassRegistry::init('PlacementsResultsCriteria')->getPlacementResultCriteria($this->college_id,$this->request->data['Search']['academic_year']);
              $this->set(compact('departments','resultCriterias'));
			 
		 }

		$this->render('auto_report');


	}
    
    function download ($file, $file_name) {    
            $this->view = 'Media';    
            $params = array( 
                    'id' => $file_name,      
                    'name' => $file, 
                    'download' => true, // force the download, don't just open.        
                    'extension' => 'xls',             
                    'mimeType' => array('xls' =>'application/application/vnd.ms-excel'),
                    'path' => APP . 'webroot/files/template' . DS. $file_name
                    
                    ); 
                //debug($params);
               $this->set($params);
    
     }
     /*
     function issue_password() {
        //debug($this->request->data);
	    if(!empty($this->request->data) && 
	    isset($this->request->data['issuepasswordtostudent'])){
	          
	            // check password length
                           $this->loadModel('Securitysetting');
                           
                           $securitysetting=$this->Securitysetting->find('first');
                           if (strlen($this->request->data['User']['passwd'])>=$securitysetting['Securitysetting']['minimum_password_length'] && strlen($this->request->data['User']['passwd'])<=$securitysetting['Securitysetting']['maximum_password_length']) { 

	               // if (!empty($this->request->data['User']['password'])) {
	              
				   $this->request->data['User']['role_id']=ROLE_STUDENT;
				   $this->request->data['User']['password']=$this->Auth->password($this->request->data['User']['passwd']);
				   unset($this->request->data['User']['passwd']);
				   
	               $username=$this->AcceptedStudent->User->find('first',array('conditions'=>array('User.username'=>$this->request->data['User']['username']),'recursive'=>-1));
	               
	               if (!empty($username)) {
	                 $this->request->data['User']['id']=$username['User']['id'];
	               }
	               $this->request->data['User']['force_password_change'] = 1;
	               if($this->AcceptedStudent->User->save($this->request->data['User'])){
	                    
	                   
	                    // if the issued is the first time update accepted student field  
	                    if(empty($this->request->data['User']['id'])){
	                        $this->request->data['AcceptedStudent']['user_id']=$this->AcceptedStudent->User->id;
					        $this->AcceptedStudent->id = $this->request->data['AcceptedStudent']['id'];
					        
					        $this->AcceptedStudent->saveField('user_id',
					        $this->request->data['AcceptedStudent']['user_id']);
					    }
					   
					    $student=$this->AcceptedStudent->Student->find('first',array('conditions'=>array(
	                    'Student.accepted_student_id'=>$this->request->data['AcceptedStudent']['id']
	                    ),'recursive'=>-1,'fields'=>array('id','user_id')));
	                 
	                    if (!empty($student)) {
	                        if (!empty($this->request->data['User']['id'])) {
	                    	    $student['Student']['user_id']=$this->request->data['User']['id'];
	                    	} else {
	                    	  $student['Student']['user_id']=$this->AcceptedStudent->User->id;
	                    	}
	                      
	                    	$this->AcceptedStudent->Student->id=$student['Student']['id'];
	                    	$this->AcceptedStudent->Student->saveField('user_id',$student['Student']['user_id']);
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
          
               if(!empty($this->request->data['AcceptedStudent']['studentnumber'])){
		          $students = array();
                  if ($this->role_id == ROLE_DEPARTMENT) {
		                  $students=$this->AcceptedStudent->find('first',
		                  array('conditions'=>array('AcceptedStudent.studentnumber 
		                  LIKE '=>trim($this->request->data['AcceptedStudent']['studentnumber']).'%',
		                  'AcceptedStudent.department_id'=>$this->department_id)));
		                  if (!empty($students)) {
		                           $this->set('students',$students);
			                       $this->set('hide_search',true);
			                       $this->set('student_number',$this->request->data['AcceptedStudent']['studentnumber']);
		                  } else {
		                                    $this->Session->setFlash('
			                         <span></span> You are not elegible to issue/reset password.The student  
			                         is not belongs to your  department.','default',
		                        array('class'=>'info-box info-message')); 
         
		                  }
		                  
			       
		           } else if ($this->role_id == ROLE_COLLEGE) {
		               $students=$this->AcceptedStudent->find('first',array('conditions'=>array('AcceptedStudent.studentnumber LIKE '=>
			         trim($this->request->data['AcceptedStudent']['studentnumber']).'%'))); 
		               if (!empty($students)) {
			                
			                 $students=$this->AcceptedStudent->find('first',
			                 array('conditions'=>array('AcceptedStudent.studentnumber LIKE'=>
			                 trim($this->request->data['AcceptedStudent']['studentnumber']).'%',
			                 'AcceptedStudent.college_id'=>$this->college_id,
			                 'AcceptedStudent.department_id is null',
			                 )));
			                  
			                  if (empty($students)) {
			                    
			                         $this->Session->setFlash('
			                         <span></span> You are not elegible to issue/reset password. The student has already assigned to department. Department is responsible for  password  issue or reset.','default',
		                        array('class'=>'info-box info-message')); 
			                     
			                  } else {
			                    
			                       $this->set('students',$students);
			                       $this->set('hide_search',true);
			                       $this->set('student_number',$this->request->data['AcceptedStudent']['studentnumber']);
		        
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
    
    */
    
    function deattach_curriculum () {
             // deattach curriculum 
	         if(!empty($this->request->data) && isset($this->request->data['deaattach'])) {
	               $selected_count=array_count_values($this->request->data['AcceptedStudent']['approve']);
                   if (isset($selected_count[1]) && $selected_count[1]>0) {
                    unset($this->request->data['AcceptedStudent']['SelectAll']);
                    $approve_placement=$this->request->data;
                    $update_admitted_students_department=array();
                   
                    $selected_approved_students=$approve_placement['AcceptedStudent']['approve'];
                    unset($approve_placement['AcceptedStudent']['academicyear']);
                    unset($approve_placement['AcceptedStudent']['curriculum_id']);
                    unset($approve_placement['AcceptedStudent']['approve']);

                      unset($approve_placement['AcceptedStudent']['department_id']);
                    unset($approve_placement['AcceptedStudent']['limit']);
                    unset($approve_placement['AcceptedStudent']['name']);
                    
					unset($approve_placement['AcceptedStudent']['program_id']);
					unset($approve_placement['AcceptedStudent']['program_type_id']);
                
                    foreach($approve_placement['AcceptedStudent'] as $mk=>&$mv){
                        foreach ($selected_approved_students as $student_id=>$is_selected) {
                           
                            if ($is_selected && $student_id==$mv['id']) {
                                
                                //$mv['Placement_Approved_By_Department']=1;
                                $mv['curriculum_id']= null;
                                $update_admitted_students_department[]=$mv['id'];

                                break;
                            }
                        }   
                    
                    }
                    
                 if(!empty($approve_placement)) {
                      
                       if($this->AcceptedStudent->saveAll($approve_placement['AcceptedStudent'], array('validate'=>'first'))) {
                       
                         $students=$this->AcceptedStudent->Student->find('all',
                       array('conditions'=>array('Student.accepted_student_id'=>$update_admitted_students_department),'fields'=>array('id','department_id','accepted_student_id','curriculum_id'),
                       'recursive'=>-1));
                       
                        if (!empty($students)) {
                            $accepted_students_department_id=$this->AcceptedStudent->field('AcceptedStudent.department_id',array('AcceptedStudent.id'=>$update_admitted_students_department)
                );
                            
                            $update_students=array();
                            $curriculumHistoryAttachment=array();
                            $count=0;
                            foreach($students as $stv){
                                $update_students['Student'][$count]['id']=$stv['Student']['id'];
                                $update_students['Student'][$count]['department_id']=$accepted_students_department_id;
                                 $update_students['Student'][$count]['curriculum_id']=null;
                                //check if s/he has already that curriculum attachment
								$checkAttachment=$this->AcceptedStudent->Student->CurriculumAttachment->find('count',array('conditions'=>array('CurriculumAttachment.student_id'=>$stv['Student']['id'],
'CurriculumAttachment.curriculum_id'=>$stv['Student']['curriculum_id'])));
                               	if(!$checkAttachment){
                                  	$curriculumHistoryAttachment['CurriculumAttachment'][$count]['student_id']=$stv['Student']['id'];
                                   
	 $curriculumHistoryAttachment['CurriculumAttachment'][$count]['curriculum_id']=$stv['Student']['curriculum_id'];
//$this->AcceptedStudent->Student->CurriculumAttachment->save($curriculumHistoryAttachment);   	
							      }
							  $count++;
                            }
                            if(!empty($curriculumHistoryAttachment))
                            {
				              $this->AcceptedStudent->Student->CurriculumAttachment->saveAll($curriculumHistoryAttachment['CurriculumAttachment'],array('validate'=>false));
                            }
                            if (!empty($update_students['Student'])) {
                                if ($this->AcceptedStudent->Student->saveAll($update_students['Student'],array('validate'=>false))){
                               
                                } else {
                                   $this->Session->setFlash('<span></span>'.__('Synchronization problem, students department.'),
                        'default',array('class'=>'success-box success-message'));
                                }
                            }
                            
                          
                        }
                        $this->Session->setFlash('<span></span>'.__('The selected student has been deattached from his/her curriculum.'),
                        'default',array('class'=>'success-box success-message'));
                      }
                    
                     }
                   } else {
                       $this->Session->setFlash('<span></span>'.__('Please select atleast one student to deattach from curriculum.'),'default',array('class'=>'error-box error-message'));
                   }
                  // $this->request->data['searchbutton']=true;
	         }
            if(!empty($this->request->data) && isset($this->request->data['searchbutton'])){
	                 if (isset($this->request->data['AcceptedStudent']['academicyear'])) {
	                  $selected_academic_year=$this->request->data['AcceptedStudent']['academicyear'];
	                  }
	                  if($selected_academic_year) {
	                        
		                    
	                   } else {
	                        $selected_academic_year=$this->AcademicYear->current_academicyear();
	                      
	                   }
	                   //WHERE item_sub_category_id IN (SELECT id FROM item_sub_categories
	                   $this->set('selected_academicyear',$selected_academic_year);
	                   //TODO deattach from curriculum should not include those who are graduated 
	                   $placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array(
	                   'AcceptedStudent.academicyear'=>$selected_academic_year,
	                    'AcceptedStudent.program_id'=>$this->request->data['AcceptedStudent']['program_id'],
					    'AcceptedStudent.program_type_id'=>$this->request->data['AcceptedStudent']['program_type_id'],
	                   'AcceptedStudent.department_id'=>$this->request->data['AcceptedStudent']['department_id'],
	                   // 'AcceptedStudent.curriculum_id is not null',
	                   'OR'=>array('AcceptedStudent.curriculum_id is not null'),
	                   'AcceptedStudent.id IN (select accepted_student_id from students where 
	                   id NOT IN (select student_id from graduate_lists) ) ',
	                  ),'limit'=>$this->request->data['AcceptedStudent']['limit'],'contain'=>array('Program'=>array('id','name'),'Department'=>array('id','name'),
	                  'ProgramType'=>array('id','name'),'Region'=>array('id','name'),
	                  'Curriculum'=>array('id','curriculum_detail'))));
	                   
	                  if (empty($placedstudent)) {
	                      $this->Session->setFlash('<span></span>'.__('There is no students  in the system that has attached to curriculum needs curriculum deattachment.'),'default',
		                     array('class'=>'info-box info-message'));
		                     //$this->redirect(array('action'=>'approve_auto_placement'));
		              } else {
                                   
                        $this->set('autoplacedstudents',$placedstudent); 
                        $this->set('selected_academicyear',$selected_academic_year);
                        $this->set('auto_approve',true);
                     }  
	     }
         $programs = $this->AcceptedStudent->Program->find('list');
	     $programTypes = $this->AcceptedStudent->ProgramType->find('list');

	   if(isset($this->request->data['AcceptedStudent']['department_id']) && !empty($this->request->data['AcceptedStudent']['department_id'])){
	   		$curriculums =  ClassRegistry::init('Curriculum')->find('list',array('fields'=>array('Curriculum.id','Curriculum.curriculum_detail'),'conditions'=>array('Curriculum.department_id'=>$this->request->data['AcceptedStudent']['department_id'])));
	   } else{
	   	 $curriculums =  ClassRegistry::init('Curriculum')->find('list',array('fields'=>array('Curriculum.id','Curriculum.curriculum_detail'),'conditions'=>array('Curriculum.department_id'=>$this->department_id)));
	   }
	   
	   if(!empty($this->program_id)){
	   		 $programs = $this->AcceptedStudent->Program->find('list',
	   		 	array('conditions'=>array('Program.id'=>$this->program_id)));
	   } else{
	   	  	 $programs = $this->AcceptedStudent->Program->find('list');
	   }
	   if(!empty($this->program_type_id)){
	   	   $programTypes = $this->AcceptedStudent->ProgramType->find('list',
	   	   	array('conditions'=>array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   	   $programTypes = $this->AcceptedStudent->ProgramType->find('list');
	   }
	   
	   if(!empty($this->department_ids)){
	   		 $departments = $this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
	   } else if(!empty($this->department_id)){
	   	$departments = $this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));
	   } 
	   $this->set(compact('programs','programTypes','departments'));
	
    }
    
   public function attach_curriculum() {
                 // attach curriculum 
	         if(!empty($this->request->data) && isset($this->request->data['attach'])) {
	            
	               $selected_count=array_count_values($this->request->data['AcceptedStudent']['approve']);
                   if (isset($selected_count[1]) && $selected_count[1]>0) {
                    unset($this->request->data['AcceptedStudent']['SelectAll']);
                    $approve_placement=$this->request->data;
                    $update_admitted_students_department=array();
                    $selected_academic_year=$approve_placement['AcceptedStudent']['academicyear'];
                    $curriculum_id=$approve_placement['AcceptedStudent']['curriculum_id'];
                    $selected_approved_students=$approve_placement['AcceptedStudent']['approve'];
                    unset($approve_placement['AcceptedStudent']['academicyear']);
                    unset($approve_placement['AcceptedStudent']['curriculum_id']);
                    unset($approve_placement['AcceptedStudent']['approve']);
                    unset($approve_placement['AcceptedStudent']['department_id']);
                    unset($approve_placement['AcceptedStudent']['limit']);
                    unset($approve_placement['AcceptedStudent']['name']);
                    
					unset($approve_placement['AcceptedStudent']['program_id']);
					unset($approve_placement['AcceptedStudent']['program_type_id']);
                    
                
                    foreach($approve_placement['AcceptedStudent'] as $mk=>&$mv){
                        foreach ($selected_approved_students as $student_id=>$is_selected) {
                           
                            if ($is_selected && $student_id==$mv['id']) {
                                
                                $mv['Placement_Approved_By_Department']=1;
                                $mv['curriculum_id']= $curriculum_id;
                                $update_admitted_students_department[]=$mv['id'];
                                break;
                            }
                        }   
                    }
                    
                 if(!empty($approve_placement)) {
                      debug($approve_placement);
                       if($this->AcceptedStudent->saveAll($approve_placement['AcceptedStudent'], array('validate'=>false))) {
                       
                         $students=$this->AcceptedStudent->Student->find('all',
                       array('conditions'=>array('Student.accepted_student_id'=>$update_admitted_students_department),'fields'=>array('id','department_id','accepted_student_id'),
                       'recursive'=>-1));
                       
                        if (!empty($students)) {
                            $accepted_students_department_id=$this->AcceptedStudent->field('AcceptedStudent.department_id',array('AcceptedStudent.id'=>$update_admitted_students_department));
                            
                            $update_students=array();
                            $count=0;
						    $curriculumHistoryAttachment=array();
                            foreach($students as $stv){
                                     $update_students['Student'][$count]['id']=$stv['Student']['id'];
                                     $update_students['Student'][$count]['department_id']=$accepted_students_department_id;
                                      $update_students['Student'][$count]['curriculum_id']=$curriculum_id;
                                   //for what we need to archive their section ???   
                                  /*

                                   $this->AcceptedStudent->Student->StudentsSection->id=
			                       $this->AcceptedStudent->Student->StudentsSection->
			                       field('StudentsSection.id',
			                       array('StudentsSection.student_id'=>$stv['Student']['id'],
			                       'StudentsSection.archive'=>0));
			                       $this->AcceptedStudent->Student->StudentsSection->
			                       saveField('archive','1');
								  */

								//check if s/he has already that curriculum attachment
                                 $checkAttachment=$this->AcceptedStudent->Student->CurriculumAttachment->find('count',array('conditions'=>array('CurriculumAttachment.student_id'=>$stv['Student']['id'],
'CurriculumAttachment.curriculum_id'=>$curriculum_id)));
                               	if(!$checkAttachment){
                                  	$curriculumHistoryAttachment['CurriculumAttachment'][$count]['student_id']=$stv['Student']['id'];
								   $curriculumHistoryAttachment['CurriculumAttachment'][$count]['curriculum_id']=$curriculum_id;
								}
                                $count++;   
                            }
                            
                           if(!empty($curriculumHistoryAttachment)){
                            $this->AcceptedStudent->Student->CurriculumAttachment->saveAll($curriculumHistoryAttachment['CurriculumAttachment'],array('validate'=>false));
							}
                            
                            if (!empty($update_students['Student'])) {


                                if ($this->AcceptedStudent->Student->saveAll($update_students['Student'],array('validate'=>false))){
                               
                                } else {
                                   $this->Session->setFlash('<span></span>'.__('Synchronization problem, students department.'),
                        'default',array('class'=>'success-box success-message'));
                                }
                            }
                            
                          
                        }
                        $this->Session->setFlash('<span></span>'.__('The selected student has been attached successfully.'),
                        'default',array('class'=>'success-box success-message'));
                    } else {
                         $this->Session->setFlash('<span></span>'.__('The attachment could not be saved..'),
                        'default',array('class'=>'error-box error-message'));
                      
                    
                    	
                    }
                    
                   }
                   } else {
                       $this->Session->setFlash('<span></span>'.__('Please select atleast one student to attach curriculum.'),'default',array('class'=>'error-box error-message'));
$this->request->data['searchbutton']=true;
                   
                   }
	         }
            if(!empty($this->request->data) && isset($this->request->data['searchbutton'])){
	                 
	                  $selected_academic_year=$this->request->data['AcceptedStudent']['academicyear'];
	                  
	                  if($selected_academic_year) {
	                        
		                    
	                   } else {
	                        $selected_academic_year=$this->AcademicYear->current_academicyear();
	                      
	                   }
	                 $program_id = $this->request->data['AcceptedStudent']['program_id'];
	                 
	                   $this->set('selected_academicyear',$selected_academic_year);
	                  
                          $placedstudent=$this->AcceptedStudent->find('all',array('conditions'=>array(
                       'AcceptedStudent.first_name LIKE'=>$this->request->data['AcceptedStudent']['name'].'%',
	                  
	                   'AcceptedStudent.academicyear'=>$selected_academic_year,
	                  
	                  // 'AcceptedStudent.department_id'=>$this->department_id,
			   'AcceptedStudent.id in (select accepted_student_id from students where department_id='.$this->request->data['AcceptedStudent']['department_id'].')',
	                   'AcceptedStudent.curriculum_id is null',
	                  'AcceptedStudent.program_id'=>$program_id,
			'AcceptedStudent.program_type_id'=>$this->request->data['AcceptedStudent']['program_type_id']),'limit'=>$this->request->data['AcceptedStudent']['limit']));

	                   
	                  if (empty($placedstudent)) {
	                      $this->Session->setFlash('<span></span>'.__('There is no students  in the system that needs curriculum attachment in the given criteria.'),'default',array('class'=>'info-box info-message'));
		                     //$this->redirect(array('action'=>'approve_auto_placement'));
		              } else {
                                   
                        $this->set('autoplacedstudents',$placedstudent); 
                        $this->set('selected_academicyear',$selected_academic_year);
                        $this->set('auto_approve',true);
                     }     
	   }
	   if(isset($this->request->data['AcceptedStudent']['department_id']) && !empty($this->request->data['AcceptedStudent']['department_id'])){
	   		$curriculums =  ClassRegistry::init('Curriculum')->find('list',array('fields'=>array('Curriculum.id','Curriculum.curriculum_detail'),'conditions'=>array('Curriculum.department_id'=>$this->request->data['AcceptedStudent']['department_id'])));
	   } else{
	   	 $curriculums =  ClassRegistry::init('Curriculum')->find('list',array('fields'=>array('Curriculum.id','Curriculum.curriculum_detail'),'conditions'=>array('Curriculum.department_id'=>$this->department_id)));
	   }
	   
	   if(!empty($this->program_id)){
	   		 $programs = $this->AcceptedStudent->Program->find('list',
	   		 	array('conditions'=>array('Program.id'=>$this->program_id)));
	   } else{
	   	  	 $programs = $this->AcceptedStudent->Program->find('list');
	   }
	   if(!empty($this->program_type_id)){
	   	   $programTypes = $this->AcceptedStudent->ProgramType->find('list',
	   	   	array('conditions'=>array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   	   $programTypes = $this->AcceptedStudent->ProgramType->find('list');
	   }
	   if(!empty($this->department_ids)){
	   		 $departments = $this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
	   } else if(!empty($this->department_id)){
	   	$departments = $this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));
	   } 
	   
		$this->set(compact('curriculums','departments','programs','programTypes'));
     
     }
     function approve_auto_placement () {
    
      if(!empty($this->request->data) && isset($this->request->data['approve']) ) {
               
               $selected_count=array_count_values($this->request->data['AcceptedStudent']['approve']);
               if (isset($selected_count[1]) && $selected_count[1]>0) {
               
                
                if (empty($this->request->data['AcceptedStudent']['curriculum_id'])) {
                   $this->Session->setFlash('<span></span>'.__('Select the curriculum that student will attend their study during stay at the department.'),
                        'default',array('class'=>'error-box error-message'));
                    $this->request->data['searchbutton']=true;
                } else {
                   
                    unset($this->request->data['AcceptedStudent']['SelectAll']);
                    $approve_placement=$this->request->data;
                    $update_admitted_students_department=array();
                    $selected_academic_year=$approve_placement['AcceptedStudent']['academicyear'];
                    $curriculum_id=$approve_placement['AcceptedStudent']['curriculum_id'];
                    $selected_approved_students=$approve_placement['AcceptedStudent']['approve'];
                    unset($approve_placement['AcceptedStudent']['academicyear']);
                    unset($approve_placement['AcceptedStudent']['curriculum_id']);
                    unset($approve_placement['AcceptedStudent']['approve']);
                
                    foreach($approve_placement['AcceptedStudent'] as $mk=>&$mv){
                        foreach ($selected_approved_students as $student_id=>$is_selected) {
                           
                            if ($is_selected && $student_id==$mv['id']) {
                                
                                $mv['Placement_Approved_By_Department']=1;
                                $mv['curriculum_id']= $curriculum_id;
                                $update_admitted_students_department[]=$mv['id'];

                                break;
                            }
                        }   
                    
                    }
                   // debug($approve_placement);
                    if(!empty($approve_placement)) {
                     
                      
                       if($this->AcceptedStudent->saveAll($approve_placement['AcceptedStudent'], array('validate'=>'first'))) {
                       
                         $students=$this->AcceptedStudent->Student->find('all',array('conditions'=>array('Student.accepted_student_id'=>$update_admitted_students_department),'fields'=>array('id','department_id','accepted_student_id'),
                       'recursive'=>-1));
                       
                        if (!empty($students)) {
                            $accepted_students_department_id=$this->AcceptedStudent->field('AcceptedStudent.department_id',array('AcceptedStudent.id'=>$update_admitted_students_department)
                );
                            
                            $update_students=array();
                            $count=0;
                            foreach($students as $stv){
                                     $update_students['Student'][$count]['id']=$stv['Student']['id'];
                                     $update_students['Student'][$count]['department_id']=$accepted_students_department_id;
                                      $update_students['Student'][$count]['curriculum_id']=$curriculum_id;
                                     $count++;
                            }
                            
                            if (!empty($update_students['Student'])) {
                                if ($this->AcceptedStudent->Student->saveAll(
                                $update_students['Student'],array('validate'=>false))) {
                               
                                } else {
                                   $this->Session->setFlash('<span></span>'.__('Synchronization problem, students department.'),
                        'default',array('class'=>'success-box success-message'));
                                }
                            }
                            
                          
                        }
                        $this->Session->setFlash('<span></span>'.__('The placement has been approved.'),
                        'default',array('class'=>'success-box success-message'));
                        $placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array(
	                   'AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%',
	                   'AcceptedStudent.Placement_Approved_By_Department'=>1,
	                   'AcceptedStudent.department_id'=>$this->department_id,
	                   'AcceptedStudent.placementtype'=>AUTO_PLACEMENT,
	                   'AcceptedStudent.program_type_id'=>PROGRAM_TYPE_REGULAR,
	        		    'AcceptedStudent.program_id'=>PROGRAM_UNDEGRADUATE,
	                   'AcceptedStudent.studentnumber is not null',
	                   'AcceptedStudent.minute_number is not null'),
	                   'order'=>array('AcceptedStudent.department_id asc',
	                   'AcceptedStudent.EHEECE_total_results desc',
	                   'AcceptedStudent.freshman_result desc')));
	                    
                         $this->set('autoplacedstudents',$placedstudent); 
                         $this->set('auto_approve',true);
                         $this->set('turn_of_approve_button',true);
                         $this->set('selected_academicyear',$selected_academic_year);
                         $this->redirect(array('action'=>'approve_auto_placement'));
                        } else {
                            $this->Session->setFlash('<span></span>'.__('Unable to approve auto placement. Please try again.'),'default',array('class'=>'error-box error-message'));
                        }
                       
                       
                    }
               }
               
              } else {
                $this->Session->setFlash('<span></span>'.__('Please select atleast one student to approve.'),'default',array('class'=>'error-box error-message'));
                $this->request->data['searchbutton']=true;
              }
         }
        
         if(!empty($this->request->data) &&  isset($this->request->data['searchbutton'])){
	                 
	                  $selected_academic_year=$this->request->data['AcceptedStudent']['academicyear'];
	                
	                  if($selected_academic_year) {
	                        
		                    
	                   } else {
	                        $selected_academic_year=$this->AcademicYear->current_academicyear();
	                      
	                   }
	                 
	                   $this->set('selected_academicyear',$selected_academic_year);
	                   $placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array('AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%',
	                   'AcceptedStudent.Placement_Approved_By_Department is null',
	                   'AcceptedStudent.department_id'=>$this->department_id,
	                   'AcceptedStudent.placementtype'=>AUTO_PLACEMENT,
	                   'AcceptedStudent.minute_number is not null',
	                    'AcceptedStudent.studentnumber is not null'
	                   ),
	                   'order'=>array('AcceptedStudent.department_id asc',
	                   'AcceptedStudent.EHEECE_total_results desc',
	                   'AcceptedStudent.freshman_result desc')));
	                 
	                   $departments=ClassRegistry::init('ParticipatingDepartment')->find("all",
	                   array('fields'=>'ParticipatingDepartment.department_id',
	                   "conditions"=>array('ParticipatingDepartment.academic_year LIKE'=>$selected_academic_year.'%',
	    'ParticipatingDepartment.college_id'=>$this->college_id)));
	                  if (empty($placedstudent)) {
	                      $this->Session->setFlash('<span></span>'.__('There is no auto placed students that needs acceptance and curriculum attachment by your department for the '.$selected_academic_year.' academic year.'),'default',
		                     array('class'=>'info-box info-message'));
		                     $this->redirect(array('action'=>'approve_auto_placement'));
		              } else {
                    
                   
                        $this->set('autoplacedstudents',$placedstudent); 
                        $this->set('minute_number',$placedstudent[0]['AcceptedStudent']['minute_number']);
                        $this->set('selected_academicyear',$selected_academic_year);
                        $this->set('auto_approve',true);
                    }
                      
                      
	                    
	     }
	     
	     $curriculums =  ClassRegistry::init('Curriculum')->find('list',array('fields'=>array('Curriculum.id','Curriculum.curriculum_detail'),'conditions'=>array(
	     'Curriculum.department_id'=>$this->department_id,'Curriculum.program_id'=>PROGRAM_UNDEGRADUATE)));
	$this->set(compact('curriculums'));
      
     }
     
     function auto_placement_approve_college() {
         if(!empty($this->request->data) && isset($this->request->data['approve']) ) {
               // debug($this->request->data);
               if(!empty($this->request->data['AcceptedStudent']['minute_number'])) {
                    $approve_placement=$this->request->data;
                    $admitted_students_ids=array();
                    unset($approve_placement['AcceptedStudent']['academicyear']);
                    unset($approve_placement['AcceptedStudent']['minute_number']);
                    foreach($approve_placement['AcceptedStudent'] as $mk=>&$mv){
                        $mv['minute_number']=$this->request->data['AcceptedStudent']['minute_number'];
                        
                        $student_id=$this->AcceptedStudent->Student->field('id',
                        array('Student.accepted_student_id'=>$mv['id']));
                        if (!empty($student_id)) {
                            $admitted_students_ids[]=$student_id;
                        }
                       
                    }
                    if(!empty($approve_placement)) {
                      
                       if($this->AcceptedStudent->saveAll($approve_placement['AcceptedStudent'], array('validate'=>'first'))) {
                            $this->Session->setFlash('<span></span>'.__('The placement has been approved.'),
                        'default',array('class'=>'success-box success-message'));
                            if (!empty($admitted_students_ids)) {
                                 foreach ($admitted_students_ids as $i=>$v) {
                                   $this->AcceptedStudent->Student->StudentsSection->id=
			                       $this->AcceptedStudent->Student->StudentsSection->
			                       field('StudentsSection.id',
			                       array('StudentsSection.student_id'=>$v,
			                       'StudentsSection.archive'=>0));
			                       $this->AcceptedStudent->Student->StudentsSection->
			                       saveField('archive','1');
			                     }
			                }
                        
                            $this->redirect(array('action'=>'index'));
                        } else {
                            
                         $this->Session->setFlash('<span></span>'.__('Unable to approve auto placement. Please try again.'),'default',array('class'=>'error-box error-message'));   
                            
                         } 
                        
                    }
               } else {
                   $this->Session->setFlash('<span></span>'.__('Please give the minute number 
                   for the approval.',true),'default',
		                     array('class'=>'error-box error-message'));
		           
                
               }
         }
         if(!empty($this->request->data)){
	                 
	                  $selected_academic_year=$this->request->data['AcceptedStudent']['academicyear'];
	                  if($selected_academic_year) {
	                        
		                    
	                   } else {
	                        $selected_academic_year=$this->AcademicYear->current_academicyear();
	                      
	                   }
	                   $this->set('selected_academicyear',$selected_academic_year);
	                   $placedstudent=$this->AcceptedStudent->find('all',
	                   array('conditions'=>array('AcceptedStudent.college_id'=>
	                   $this->college_id,'AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%',
	                   'AcceptedStudent.placementtype'=>AUTO_PLACEMENT,
	                   "OR"=>array('AcceptedStudent.minute_number is null','AcceptedStudent.minute_number'=>'')),
	                   'order'=>array('AcceptedStudent.department_id asc',
	                   'AcceptedStudent.EHEECE_total_results desc',
	                   'AcceptedStudent.freshman_result desc')));
	                  
	                   $departments=ClassRegistry::init('ParticipatingDepartment')->find("all",
	                   array('fields'=>'ParticipatingDepartment.department_id',
	                   "conditions"=>array('ParticipatingDepartment.academic_year LIKE'=>$selected_academic_year.'%',
	    'ParticipatingDepartment.college_id'=>$this->college_id)));
	     if(empty($placedstudent)) {
	       $this->Session->setFlash('<span></span>'.__('There is no auto placement result that needs approval for the selected academic year.'),'default',array('class'=>'info-box info-message'));
		$placedstudent=$this->AcceptedStudent->find('all',array('conditions'=>array('AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.academicyear LIKE '=>$selected_academic_year.'%','AcceptedStudent.placementtype'=>AUTO_PLACEMENT)));
	          $minute_number=$placedstudent[0]['AcceptedStudent']['minute_number'];
	          $this->set(compact('minute_number'));
             }
             $dep_id=array();
             foreach($departments as $k=>$v){
                $dep_id[]=$v['ParticipatingDepartment']['department_id'];
             }
             $dep_name=$this->AcceptedStudent->Department->find('list',array('conditions'=>array('Department.id'=>$dep_id)));
	  $newly_placed_student=array();
          foreach($dep_name as $dk=>$dv){
            foreach($placedstudent as $k=>$v){
            	if($dk==$v['Department']['id']){
                     $newly_placed_student[$dv][$k]=$v;
                }
            }
            $newly_placed_student['auto_summery'][$dv]['C']=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>
$selected_academic_year.'%','AcceptedStudent.department_id'=>$dk,'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'C')));
          $newly_placed_student['auto_summery'][$dv]['Q']=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>$selected_academic_year.'%','AcceptedStudent.department_id'=>$dk,'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placement_based'=>'Q')));
        }
   	$this->set('autoplacedstudents',$newly_placed_student); 
	$this->set('selected_academicyear',$selected_academic_year);
	$this->set('auto_approve',true);
       }
     }
     // count_result($result=null,$result_type=null)
     function count_result() {
         $this->layout = 'ajax';
         $field=null;
         //debug($this->request->data);
         if (!empty($this->request->data['PlacementsResultsCriteria']['prepartory_result'])) {
            $field='AcceptedStudent.EHEECE_total_results';
         } else {
            $field='AcceptedStudent.freshman_result';
         }
         $result_count=$this->AcceptedStudent->find('count',array('conditions'=>array('AcceptedStudent.academicyear LIKE'=>
                             $this->request->data['PlacementsResultsCriteria']['admissionyear'].'%',
                              'AcceptedStudent.college_id'=>$this->college_id,
                               $field.' >= '=>$this->request->data['PlacementsResultsCriteria']['result_from'],
                              $field.' <= '=>$this->request->data['PlacementsResultsCriteria']['result_to'],
                              "OR"=>array('AcceptedStudent.department_id is null','AcceptedStudent.department_id'=>array('',0)))));
         if (!empty($this->request->data['PlacementsResultsCriteria']['result_from']) && !empty($this->request->data['PlacementsResultsCriteria']['result_from'])) {
            $from=$this->request->data['PlacementsResultsCriteria']['result_from'];
            $to=$this->request->data['PlacementsResultsCriteria']['result_to'];
            $this->set(compact('from','to'));
         }
         $this->set('result_count',$result_count);
     }
     
     function print_student_identification() { 
           $this->layout = 'pdf';           // Set layout to pdf 
           $this->set('doc_id', '1234567'); // Set number to print 
           $this->render('print_student_identification'); 
     }
}
