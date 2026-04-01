<?php
class CourseRegistrationsController extends AppController {
      public $name = 'CourseRegistrations';
      public $menuOptions = array(
                
                'parent'=>'registrations',
                'exclude'=>array(
                'get_course_registered_grade_list', 
                'get_course_registered_grade_result','get_course_category_combo','search',
'show_course_registred_students','get_section_combo',
'getIndividualRegistration'),
                 'alias' => array(
                    'index' => 'View All Registration',
                  
            	)
            );
    public $components =array('AcademicYear');

    public $helpers = array('Xls','Media.Media');
    public $paginate = array();
    
    public function beforeFilter () {
	      parent::beforeFilter();
	      $this->Auth->Allow('show_course_registred_students', 'get_course_registered_grade_list', 
	      'get_course_registered_grade_result','search',
	      'get_course_category_combo',
'registration_view','get_section_combo',
'manage_missing_registration',
'getIndividualRegistration',
'update_missing_registration');
	       if($this->role_id== ROLE_STUDENT){
		 	   
		 	   $students=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id' => $this->student_id),'recursive' => -1));
               if(empty($students['Student']['ecardnumber']) && isset($user["User"]['id']) && !empty($user["User"]['id']) && strcasecmp($this->request->params['controller'], 'students') != 0 && strcasecmp($this->request->params['action'], 'change') != 0) {
					return $this->redirect(array('controller' => 'students', 'action' => 'change'));
			   }
	 	  }
		
     }
     public function beforeRender() {
	$acyear_array_data = $this->AcademicYear->acyear_array();
        //$acyear_array_data=$this->AcademicYear->academicYearInArray(date('Y')-8,date('Y')+1);
	 $acyear_array_minu_separted = $this->AcademicYear->acYearMinuSeparated();
        //To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        if(!empty($this->program_type_id)){
	   		   $program_types=$programTypes =  $this->CourseRegistration->Student->ProgramType->find('list',array('conditions'=>
	   		   	array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   		   $program_types=$programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
	   }
	   
	    if(!empty($this->program_id)){
	   		   $programs=$this->CourseRegistration->Student->Program->find('list',array('conditions'=>
	   		   	array('Program.id'=>$this->program_id)));
	   } else{
	   		   $programs=$this->CourseRegistration->Student->Program->find('list');
	   }
	   
        $this->set(compact('acyear_array_data','programs','defaultacademicyear',
'acyear_array_minu_separted','programTypes','program_types'));

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
		foreach ($this->request->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
		}

		// redirect the user to the url
		return $this->redirect($url, null, true);
	}
	 

	function __init_search_index() {
        // We create a search_data session variable when we fill any criteria  in the search form.
	     if(!empty($this->request->data['Search'])) {
	      $search_session = $this->request->data['Search'];
		  // Session variable 'search_data'
		   $this->Session->write('search_data_index', $search_session); 
	     } else {
		   $search_session = $this->Session->read('search_data_index');
		  $this->request->data['Search'] = $search_session;
	     }
     }

	/**
	* Function to allow students to register for the published coures
	*/
	
	public function register() {
	   //check students are allowed to register based on their academic status.
	    $getRegistrationDeadLine=false;
	    $get_student_acadamic_status=null;
	    $latestSemester=null;
	     $studentDetails=$this->CourseRegistration->Student->find('first',array('conditions'=>array('Student.id'=>$this->student_id),'recursive'=>-1));
	    //$getStudentCurrentSection=$this->student_id;
	    $getCourseNotRegistered=ClassRegistry::init('StudentsSection')->getMostRecentSectionPublishedCourseNotRegistered($this->student_id);
        $isThereFxInPrevAcademicStatus=$this->CourseRegistration->Student->
StudentExamStatus->checkFxPresenseInStatus($this->student_id);
		
	    //debug($getCourseNotRegistered);
	    if(isset($getCourseNotRegistered) && 
!empty($getCourseNotRegistered)) {
             $latest_academic_year=$getCourseNotRegistered[0]['PublishedCourse']['academic_year'];
	    } else {
	      $latest_academic_year = $this->AcademicYear->current_academicyear();
	    }
	   
	    $passed_or_failed=$this->CourseRegistration->Student->StudentExamStatus->get_student_exam_status($this->student_id,$latest_academic_year);
		
	   $latestAcSemester= $this->CourseRegistration->getLastestStudentSemesterAndAcademicYear(
	   $this->student_id,$latest_academic_year);
	   $latestSemester=$latestAcSemester['semester'];
       $paymentRequired=$this->CourseRegistration->Student->Payment->paidPayment($this->student_id,$latestAcSemester);

	   if (($passed_or_failed==1 || $passed_or_failed==3) && ($isThereFxInPrevAcademicStatus==1) && $paymentRequired) {
		$get_student_acadamic_status=$this->CourseRegistration->Student->StudentExamStatus->getStudentAcadamicStatus($this->student_id,$latest_academic_year,$latestSemester);
	       $student_section= $this->CourseRegistration->Student->student_academic_detail($this->student_id,$latest_academic_year);
	      if (!empty($this->department_id)) {
                $year_level_id = $this->CourseRegistration->YearLevel->field('name',array('id'=> $student_section['Section'][0]['year_level_id']));
            	$getRegistrationDeadLine=$this->CourseRegistration->AcademicCalendar->check_registration($latest_academic_year,$latestSemester,$this->department_id,$year_level_id,
            	$studentDetails['Student']['program_id'],$studentDetails['Student']['program_type_id']);
		
	       } else if (!empty($this->college_id)) {
	           $getRegistrationDeadLine=$this->CourseRegistration->AcademicCalendar->check_registration ($latest_academic_year,$latestSemester,$this->college_id,0,$studentDetails['Student']['program_id'],$studentDetails['Student']['program_type_id']);
	       }
	    
	     if ($getRegistrationDeadLine==0 || $getRegistrationDeadLine==1) {
		// $getRegistrationDeadLine=1;//TODO remove imported for the purpose of backregistration
	     } else {
	    $registration_start_date=$getRegistrationDeadLine;
	      $getRegistrationDeadLine=0;
	     }  
	     //$getRegistrationDeadLine=1;
	     if (!$getRegistrationDeadLine) {
	              if(isset($registration_start_date) && !empty($registration_start_date)) {
		     		
			$this->Session->setFlash('<span></span>'.__('Course registration start at '.$registration_start_date.'. You can not register for now.', true),'default',array('class'=>'info-box info-message'));
	             } else {
	                $this->Session->setFlash('<span></span>'.__('Course registration deadline passed. You can not registered, please advice registrar.'),'default',array('class'=>'info-box info-message'));
	             }
	             $this->redirect(array('action' => 'index'));
		     $deadlinepassed=true;
	            $this->set(compact('deadlinepassed'));
	       
	        }
	        ////TODO why i deleted previously ?, introduced after bettycomment/////////////////////////////////////////////////////////////
	       $not_registered=$this->CourseRegistration->alreadyRegistred($latestSemester,$latest_academic_year,$this->student_id);
	      if($not_registered>0) {
                $this->Session->setFlash('<span></span>'.__('You have already registered for semester '.$latestSemester.'/'.$latest_academic_year.'. Please search and view for what courses you have registered.', true),'default',array('class'=>'info-box info-message'));
	          $this->redirect(array('action' => 'index'));
	      }
	      if (!empty($this->request->data)) {
	            
	            //check students has already registered  
	             $not_registered=$this->CourseRegistration->alreadyRegistred($this->request->data['CourseRegistration'][1]['semester'],$latest_academic_year,$this->request->data['CourseRegistration'][1]['student_id']);
	            if ($not_registered==0) {
	                //Save course registration.
	                if (!empty($this->request->data['CourseRegistration'])) {
	                	foreach ($this->request->data['CourseRegistration'] as $eek=>&$eev) {
	                		# code...
	                		if(!isset($eev['gp'])){
                             
	                		} else if($eev['gp']==0){
	                			unset($this->request->data['CourseRegistration'][$eek]);
	                		}
	                		$this->request->data['CourseRegistration'][$eek]['cafeteria_consumer']=$this->request->data['CourseRegistration'][0]['cafeteria_consumer'];
	                		
	                	}
	                	if(!empty($this->request->data['CourseRegistration'])){
				           if ($this->CourseRegistration->saveAll($this->request->data['CourseRegistration'],array('validate'=>false))) {
							
							$this->Session->setFlash('<span></span>'.__('You have successfully registered for semester '.$latestSemester.'/'.$latest_academic_year, true),'default',array('class'=>'success-box success-message'));
								$this->redirect(array('action' => 'index'));				
							}
					  } else {
					  	  $this->Session->setFlash('<span></span>'.__('Please select the courses you want to register for semester '.$latestSemester.'/'.$latest_academic_year, true),'default',array('class'=>'error-box error-message'));
					  }

	       			}
	            } else {
	               $this->Session->setFlash('<span></span>'.__('You have already registered for semester '.$latestSemester.'/'.$latest_academic_year.'.', true),'default',array('class'=>'error-box error-message'));
	            }
	   }
	   
	if (!empty($student_section)) {
	    if (count($student_section['Section'])>0) {
	    	if (empty($student_section['Student']['department_id'])){
	        $published_courses=$this->CourseRegistration->PublishedCourse->find('all',
	            array('conditions'=>array(
	            'PublishedCourse.department_id is null',
	            'PublishedCourse.section_id'=>$student_section['Section'][0]['id'],
	            'PublishedCourse.year_level_id'=>0,'PublishedCourse.add'=>0
	            ,'PublishedCourse.academic_year LIKE'=>$latest_academic_year.'%',
	            'PublishedCourse.semester'=>$latestSemester,
	            'PublishedCourse.college_id'=>$student_section['Student']['college_id'],
	            ),'contain'=>array('Course'=>array(
	            'Prerequisite'=>array('id','prerequisite_course_id','co_requisite'),'fields'=>array('Course.id','Course.course_code','Course.course_title','Course.lecture_hours',
	            'Course.tutorial_hours','Course.credit')))));
	                
	               } else {
	                $published_courses=$this->CourseRegistration->PublishedCourse->find('all',
	            array('conditions'=>array('PublishedCourse.department_id'=>$this->department_id,
	            'PublishedCourse.section_id'=>$student_section['Section'][0]['id'],'PublishedCourse.year_level_id'=>$student_section['Section'][0]['year_level_id'],'PublishedCourse.add'=>0
	            ,'PublishedCourse.academic_year LIKE'=>$latest_academic_year.'%',
	            'PublishedCourse.semester'=>$latestSemester),'contain'=>array('Course'=>array(
	            'Prerequisite'=>array('id','prerequisite_course_id','co_requisite'),'fields'=>array('Course.id','Course.course_code','Course.course_title','Course.lecture_hours',
	            'Course.tutorial_hours','Course.credit')))));
	            }
	           $published_courses= $this->CourseRegistration->getRegistrationType($published_courses,$this->student_id,$get_student_acadamic_status);
		$previous_status_semester=$this->CourseRegistration->Student->StudentExamStatus->
	       getPreviousSemester($latest_academic_year,$latestSemester);
		$latest_status_year_semester = $this->CourseRegistration->Student->StudentExamStatus->studentYearAndSemesterLevelOfStatusDisplay($this->student_id, $latest_academic_year,$previous_status_semester['semester']);  
		$student_section_exam_status=$this->CourseRegistration->Student->get_student_section($this->student_id,$latest_academic_year,$latest_status_year_semester['semester']);
	   $this->set(compact('published_courses','student_section','student_section_exam_status'));
	      
	            }
	    	}
	    } else {
	        if ($passed_or_failed==2) {
	            $this->Session->setFlash('<span></span>'.__('Your academic status for the previous semester is not yet generated due to incomplete grade submission of registered courses. So, for now you can not register for semester '.$latestSemester.'/'.$latest_academic_year.', please come back later and check!', true),'default',array('class'=>'info-box info-message'));
	        } else if ($passed_or_failed==4) {
	           $this->Session->setFlash('<span></span>'.__('Your academic status is dismissed you can not register for semester '.$latestSemester.'/'.$latest_academic_year.'. Don\t forget to apply for readmission.', true),'default',array('class'=>'info-box info-message'));
	        } else if ($isThereFxInPrevAcademicStatus==0) {
                     $this->Session->setFlash('<span></span>'.__('You have invalid grade(Fx, or NG) in your last registration, please fix those grade problem  and come back for semester '.$latestSemester.'/'.$latest_academic_year.' registration.', true),'default',array('class'=>'info-box info-message'));

			} else if($paymentRequired==0){
				 $this->Session->setFlash('<span></span>'.__('Payment is required for registration of'.$latestSemester.'/'.$latest_academic_year.' , please settle the payment and come again.', true),'default',array('class'=>'info-box info-message'));
                             $this->redirect(array('controller'=>'payments','action' => 'student_settle_payment'));				
			}
	        $this->redirect(array('action'=>'index'));   
	   }
	   if (empty($published_courses)) {
	            $this->Session->setFlash('<span></span>'.__('There is no published courses that required registration.'),'default',array('class'=>'info-box info-message'));
		$this->redirect(array('action' => 'index'));
	   }
	    
	  }
	 
	  /**
	  * Private function that get list of students not registred for latest 
	  * academic year and semester.
	  */
	/*
	public function register() {
	   //check students are allowed to register based on their academic status.
	    $getRegistrationDeadLine=false;
	    $get_student_acadamic_status=null;
	    $latestSemester=null;
	    //$getStudentCurrentSection=$this->student_id;
	    $getCourseNotRegistered=ClassRegistry::init('StudentsSection')->getMostRecentSectionPublishedCourseNotRegistered($this->student_id);
	    
	    if(isset($getCourseNotRegistered) && 
!empty($getCourseNotRegistered)) {
	
             $latest_academic_year=$getCourseNotRegistered[0]['PublishedCourse']['academic_year'];
	    } else {
	      $latest_academic_year = $this->AcademicYear->current_academicyear();
	    }
	   
	    $passed_or_failed=$this->CourseRegistration->Student->StudentExamStatus->get_student_exam_status($this->student_id,$latest_academic_year);
	    debug($passed_or_failed);
	    $latestAcSemester= $this->CourseRegistration->getLastestStudentSemesterAndAcademicYear(
	   $this->student_id,$latest_academic_year);
	   $latestSemester=$latestAcSemester['semester'];
	   if ($passed_or_failed==1 || 
$passed_or_failed==3) {
		debug($getCourseNotRegistered);	
               $latest_status_year_semester = $this->CourseRegistration->Student->StudentExamStatus->studentYearAndSemesterLevelOfStatusDisplay($this->student_id, $latest_academic_year,$previous_status_semester['semester']);  
		$student_section_exam_status=$this->CourseRegistration->Student->get_student_section($this->student_id,$latest_academic_year,$latest_status_year_semester['semester']);

	       $student_section= $this->CourseRegistration->Student->student_academic_detail($this->student_id,$latest_academic_year);
		$this->set(compact('published_courses','student_section',
'student_section_exam_status'));
	      

	    } else {
	        if ($passed_or_failed==2) {
	            $this->Session->setFlash('<span></span>'.__('Your academic status is not generated so you can not register for semester '.$latestSemester.'/'.$latest_academic_year.'.', true),'default',array('class'=>'info-box info-message'));
	        } else if ($passed_or_failed==4) {
	           $this->Session->setFlash('<span></span>'.__('Your academic status is dismissed you can not register for semester '.$latestSemester.'/'.$latest_academic_year.'.', true),'default',array('class'=>'info-box info-message'));
		
	        }
	    // $this->redirect(array('action'=>'index'));   
	   }
	   if (empty($published_courses)) {
	       $this->Session->setFlash('<span></span>'.__('There is no published courses that required registration.'),'default',array('class'=>'info-box info-message'));
		//$this->redirect(array('action' => 'index'));
	   }
	    
	  }	
         */
	function _student_list_not_registred ($data=null) {
	  	     $options = array();
	         $options['fields']=array('PublishedCourse.id');
	         $search_conditions = array();
	         
            $search_conditions['conditions'][]=array('Student.id NOT IN (select student_id from graduate_lists)');
            $search_conditions['fields']=array('Student.id',
		'Student.studentnumber','Student.full_name');
            $search_conditions['limit']=20;
		    $search_conditions['order']=array('Student.full_name');
		    $search_conditions['contain']=array('Section'=>array('id','year_level_id'),
		    'StudentsSection.archive = 0','Program'=>array('fields'=>array('id','name')),
		'ProgramType'=>array('fields'=>array('id','name')),
		'Department'=>array('fields'=>array('id','name')));
				
	         $organized_students=array(); 
	         $published_course_ids=array();
	        if (isset($data['Student']['academicyear'])) {
	            $latest_semester_academic_year=$this->CourseRegistration->latest_academic_year_semester(
	          $data['Student']['academicyear']);
	        } else {
	           $latest_semester_academic_year=$this->CourseRegistration->latest_academic_year_semester(
	          $this->AcademicYear->current_academicyear());
	        }
	        /*
	         $latest_semester_academic_year=$this->CourseRegistration->latest_academic_year_semester(
	          $this->AcademicYear->current_academicyear());
	         */
             if(!empty($latest_semester_academic_year)) {
                   
                    $options['conditions'][] = array(
                            'PublishedCourse.academic_year like '=>$latest_semester_academic_year['academic_year'].'%',
                            'PublishedCourse.add'=>0);
                   if (!empty($data['Student']['department_id'])) {
                        $options['conditions'][] = array(
                            'PublishedCourse.department_id'=>$data['Student']['department_id']);
                        
                   }
                   
                   if (empty($data['Student']['department_id']) || empty($data['Student']['college_id']) ) {
                            if (!empty($this->department_ids)) {
                               
                             $options['conditions'][] = array(
                            'PublishedCourse.department_id'=>$this->department_ids);
                   
                            } else if (!empty($this->college_ids)) {
                               
                             $options['conditions'][] = array(
                            'PublishedCourse.college_id'=>$this->college_ids);
                          //  debug($this->college_ids);
                            
                            }
                   }
                   
                   if (!empty($data['Student']['program_id'])) {
                       $options['conditions'][] = array(
                            'PublishedCourse.program_id'=>$data['Student']['program_id']);
                   }
                   
                   if (!empty($data['Student']['program_type_id'])) {
                       $options['conditions'][] = array(
                            'PublishedCourse.program_type_id'=>$data['Student']['program_type_id']);
                   }
                   
                   if (!empty($data['Student']['semester'])) {
                       $options['conditions'][] = array(
                            'PublishedCourse.semester'=>$data['Student']['semester']);
                       $this->request->data['Student']['semester']=$data['Student']['semester'];
                   } 
                   $published_course_ids=$this->CourseRegistration->PublishedCourse->find('list',$options);   
                  if (empty($published_course_ids)) {
                         return array();
                   }
                   
                   $options=array();              
             } else {
                /*
                $published_course_ids=$this->CourseRegistration->PublishedCourse->find('list',
                 array('conditions'=>array('PublishedCourse.department_id'=>$this->department_ids,'PublishedCourse.add'=>0),'fields'=>array('PublishedCourse.id')));
               */
             
             }
             
             if(!empty($data)) {
             
                   
                   if (!empty($data['Student']['program_id'])) {
                       $search_conditions['conditions'][] = array(
                            'Student.program_id'=>$data['Student']['program_id']);
                    }
                   
                   if (!empty($data['Student']['program_type_id'])) {
                          $search_conditions['conditions'][] = array(
                            'Student.program_type_id'=>$data['Student']['program_type_id']);
    
                   }
                   
                   if (!empty($data['Student']['department_id'])) {
                        $department_ids = $this->_givenPublisheCourseReturnDept($published_course_ids);
                        if (in_array($data['Student']['department_id'],$department_ids['dept'])) {
                             $search_conditions['conditions'][] = array(
                            'Student.department_id'=>$data['Student']['department_id']);
                        } 
   
                   } 
                   
                   if (!empty($data['Student']['college_id'])) {
                      $search_conditions['conditions'][] = array(
                            'Student.college_id'=>$data['Student']['college_id']);
                       $search_conditions['conditions'][] = array(
                            'Student.department_id is null');
                   }
                   
                   if (!empty($data['Student']['studentnumber'])) {
                      $search_conditions['conditions'][] = array(
                            'Student.studentnumber like '=> trim ($data['Student']['studentnumber']));
                     
                   }
                   
                   if (!empty($this->department_ids) && empty($data['Student']['department_id'])) {
                    
                     $search_conditions['conditions'][] = array(
                            'Student.department_id'=>$this->department_ids);
   
                   } else if (!empty($this->college_ids) && empty($data['Student']['college_id'])) {
                           
                            $college_ids = $this->_givenPublisheCourseReturnDept($published_course_ids);
                           
                             $search_conditions['conditions'][] = array(
                            'Student.college_id'=>$college_ids['college'],
                            'Student.department_id is null'); 
           
                   }
                   
             } else {
                   
                   if (!empty($this->department_ids)) {
                      $department_ids = $this->_givenPublisheCourseReturnDept($published_course_ids);
                      
                                            $search_conditions['conditions'][] = array(
                            'Student.department_id'=>$department_ids['dept']);
   
                   } else if (!empty($this->college_ids)) {
                        $college_ids = $this->_givenPublisheCourseReturnDept($published_course_ids);
                      
                         $search_conditions['conditions'][] = array(
                            'Student.department_id is null'); 
                             $search_conditions['conditions'][] = array(
                            'Student.college_id'=>$college_ids['college']); 
           
                   }
                       /*
                       $department_ids = $this->_givenPublisheCourseReturnDept($published_course_ids);
             
                       $conditions['Student.department_id']=$department_ids;
                      */
                      //$conditions['Student.department_id']=$this->department_ids;
             }
             $section_ids = $this->CourseRegistration->PublishedCourse->find('list',
             array('conditions'=>array('PublishedCourse.id'=>
             $published_course_ids),'fields'=>'section_id'));
              $sections_students= ClassRegistry::init('StudentsSection')->find('list',
		       array('conditions'=>array('section_id'=>$section_ids,'archive'=>0),'fields'=>'student_id'));
              
            $search_conditions['conditions'][] = array(
                            'Student.id '=>$sections_students); 
    
             $this->CourseRegistration->Student->bindModel(
				array(
					'hasMany' => array(
						'StudentsSection' => array(
							'className' => 'StudentsSection',
			
							)
						)
					)
				);
			   
			  $students=$this->CourseRegistration->Student->find('all',$search_conditions);
			 
			  if(!empty($students)){
			      $students_list_not_registred=array();
			     // student by student 
			      foreach ($students as $id=>&$detail) {
			               $registred_all_published_course=0;
			               foreach($published_course_ids as $pidd=>$pvv){
			                   
			                       $check=$this->CourseRegistration->find('count',
			                    array('conditions'=>array('CourseRegistration.student_id'=>$detail['Student']['id'],'CourseRegistration.published_course_id'=>$pvv)));
			                   
			                        if($check>0){
			                            // $students_list_not_registred[]=$detail;
			                            $registred_all_published_course++;
			                        }
			                   
			                    
			               }
			               //unset
			               if ($registred_all_published_course>0) {
			                  unset($students[$id]);
			                  $registred_all_published_course=0;
			               }
			      }
			   }
			      //organize by program, program type, year_level,and section 
			  if(!empty($students)){
			   
			    foreach($students as $student_key=>$student_value){
			            if (!empty($student_value['StudentsSection'])
			            && count($student_value['StudentsSection'])>0) {
			              $year_level_found=null;
			              foreach ($student_value['Section'] 
			                  as $sect_index=>$sect_value) {
			                     if ($student_value['StudentsSection'][0]['section_id'] == 
			                  $sect_value['id']) {
			                        $year_level_found=$sect_value['year_level_id'];
			                    }
			                  
			                  }
                $organized_students[$student_value['Program']['name']][$student_value['ProgramType']['name']][$year_level_found][$student_value['StudentsSection'][0]['section_id']][]=$student_value;               
			            }
			    }
			    return $organized_students;
			  }
			 return $organized_students;
			 //return $students;	
				
	  }
	  /*
	  function maintain_registration($student_id=null,$register_selected_section=null) {
	     
	        
          //read from session selected academic year 
            $academicYearSelected=$this->Session->read('search_data_registration');
            if (isset($academicYearSelected)){
                    $latest_academic_year=$academicYearSelected['academicyear'];
                   // $this->request->data['Student']=$academicYearSelected;
            } else {
                if (isset($this->request->data['Student']['academicyear'])) {
	                $latest_academic_year=$this->request->data['Student']['academicyear'];
	                $this->request->data['continue']=true;
	            } else {
	               $latest_academic_year=$this->AcademicYear->current_academicyear();
	            }
            }
            
            if ($student_id==0 && !empty($register_selected_section)) {
            
                debug($academicYearSelected);
            }
            
          
	        
	        $breaker_detail = ClassRegistry::init('User')->find('first',
                      			array(
                      				'conditions' =>
                      				array(
                      					'User.id' =>$this->Auth->user('id')
                      				),
                      				'contain' => 
                      				array(
                      					'Staff',
                      					'Student'
                      				)
                      			)
          	 );
	        if ($student_id) {
	          
	        
	            $this->request->data['Student']['studentnumber']=$this->CourseRegistration->Student->field('Student.studentnumber',
			                 array('Student.id'=>$student_id));
			    $this->request->data['Student']['academicyear']=$latest_academic_year;
			    
			  
                 if (!empty($this->department_ids)) {
                    $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$student_id,'Student.department_id'=>$this->department_ids)));
                 } else if (!empty($this->college_ids)) {
                                $elegible_registrar_responsibility=$this->CourseRegistration->
                                Student->find('count',
                                array('conditions'=>array('Student.id'=>$student_id,
                                'Student.college_id'=>$this->college_ids,
                                'Student.department_id is null'),'contain'=>array()));         
                    
                 } else if (!empty($this->department_id)) {
                         $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',
                         array('conditions'=>array('Student.id'=>$student_id,
                         'Student.department_id'=>$this->department_id)));
       
                 } else if (!empty($this->college_id)) {
                         $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',
                         array('conditions'=>array('Student.id'=>$student_id,
                         'Student.college_id'=>$this->college_id)));
       
                 }
                 
	      
                 if ($elegible_registrar_responsibility==0) {
                        $this->Session->setFlash('<span></span> You do not have the privilage to register the selected student. Your action is logged and reported to the system administrators.','default',array('class'=>'error-box error-message'));
                      
						$details=null;
						
						if (isset ($breaker_detail['Staff']) && !empty($breaker_detail['Staff'])) {
						  $details.=$breaker_detail['Staff'][0]['first_name'].' '.
						  $breaker_detail['Staff'][0]['middle_name'].' '.
						  $breaker_detail['Staff'][0]['last_name'].' ('.
						  $breaker_detail['User']['username'].')';
						} else if (isset ($breaker_detail['Student']) && !empty($breaker_detail['Student'])) {
						$details.=$breaker_detail['Student'][0]['first_name'].' '.
						$breaker_detail['Student'][0]['middle_name'].' '.
						$breaker_detail['Student'][0]['last_name'].' ('.
						$breaker_detail['User']['username'].')';
						
						}
				       
						ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$details.'</u> is trying to register students without assigned privilage. Please give appropriate warning.'); 
	                   
	                   $this->request->data['Student']['studentnumber']=null;       
                 
                 
                 
                 } else {
                 
	                $this->request->data['continue']=true;
	             }
	        }
	        // The system asks the user to enter student identification number
            //OR to make selection for step number
           if(!empty($this->request->data) && isset($this->request->data['continue'])){
                 $this->__init_maintain_academic_year();
                 
                 $students=$this->_student_list_not_registred($this->request->data);
                 
                
                 if(empty($students) && $student_id=="" ){
                    
                    if (!empty($this->request->data)) {
                        $this->Session->setFlash('<span></span>There is no result in the given criteria 
                        that needs course registration maintaince for '.$this->request->data['Student']['academicyear'].
                        ' Academic Year.','default',
		                       array('class'=>'info-box info-message'));
                    } else {
                            $this->Session->setFlash('<span></span>There is no result in the given criteria 
                        that needs course registration maintaince for '.$this->AcademicYear->current_academicyear().
                        ' Academic Year.','default',
		                       array('class'=>'info-box info-message'));
                    }
                     //$students=$this->_student_list_not_registred();
                 }
             
                 if (!empty($this->request->data['Student']['studentnumber'])) {
                    //$latest_academic_year=$this->AcademicYear->current_academicyear();
                    //debug($this->Session->read('search_data_registration'));
                    $stud_id = $this->CourseRegistration->Student->field('Student.id',
			                 array('Student.studentnumber like '=>trim($this->request->data['Student']['studentnumber'])));
			                 
			          $latestAcSemester= $this->CourseRegistration->
			          getLastestStudentSemesterAndAcademicYear($stud_id,$latest_academic_year);
	                   $latestSemester=$latestAcSemester['semester'];
			          
	                $student_section= $this->CourseRegistration->Student->student_academic_detail(
	                   $stud_id,$latest_academic_year);
	                
	                
	                   
                    $published_courses=$this->CourseRegistration->registerSingleStudent(
                    $stud_id,$latest_academic_year);
                   
			        if ($published_courses['passed'] === false ) {
			           $this->Session->setFlash('<span></span>'.__('Your academic status is dismissed 
			           you can not register for semester '.$latestSemester.'/'.$latest_academic_year.'.', 
			           true),'default',array('class'=>'info-box info-message'));
			           $dismissed=true;
			           $this->set(compact('dismissed'));
			        }
			        
			        $previous_status_semester=$this->CourseRegistration->Student->StudentExamStatus->
	       getPreviousSemester($latest_academic_year,$latestSemester);
	              
			       $latest_status_year_semester = $this->CourseRegistration->Student->StudentExamStatus->
			       studentYearAndSemesterLevelOfStatusDisplay($stud_id, $latest_academic_year,
			       $previous_status_semester['semester']);
			     
	                $student_section_exam_status=$this->CourseRegistration->Student->
	                get_student_section($stud_id,$latest_academic_year,$latest_status_year_semester['semester']);
	              
		           $published_courses=$published_courses['register'];
		           if(empty($published_courses)){
		           $this->Session->setFlash('<span></span> There is no courses publisehd for the selected students for the current academic year, or you do not have the privilage to register this students. Please contact his/her department.','default',
		                   array('class'=>'error-box error-message'));
	               }
		           $this->set('hide_search',true);
                   $this->set(compact('published_courses',
                   'student_section','year_level_name','student_section_exam_status'));
                             
                 }
              
                 $this->set(compact('students')); 
                 
   
            } 
            
            if (!empty($this->request->data) && isset($this->request->data['register'])) {
                
	            //check students has already registered  
	            // debug($this->Session->read('search_data_registration'));
	            $semester=$this->request->data['CourseRegistration'][1]['semester'];
	            $not_registered=$this->CourseRegistration->alreadyRegistred(
	            $this->request->data['CourseRegistration'][1]['semester'],
	            $latest_academic_year,
	            $this->request->data['CourseRegistration'][1]['student_id']);
	           
	            if ($not_registered == 0) {
	                //Save course registration.
	                if (!empty($this->request->data['CourseRegistration'])) {
	                    
	                    if ($this->CourseRegistration->saveAll($this->request->data['CourseRegistration'],
	                    array('validate'=>false))) {
	                        foreach ($this->request->data['CourseRegistration'] as $nn=>$namevalue) {
	                            $student_id=$namevalue['student_id'];
	                            break;
	                        }
	                       $student_name = $this->CourseRegistration->Student->field('full_name',
	                    array('Student.id'=> $student_id));
	                       
	                         $this->Session->setFlash('<span></span>'.__('You have successfully registered '.
	                         $student_name.' for '.$latest_academic_year.
	                         ' of  semester '.$semester.'', true),'default',array('class'=>'success-box success-message'));
	                         unset($this->request->data['Student']['studentnumber']);
	                         $this->__init_maintain_academic_year();
	                         
	                         
	                         //$this->redirect(array('action'=>'maintain_registration'));
	                    } 
	                    //debug($this->CourseRegistration->invalidFields());
	                }
	            } else {
	              $this->Session->setFlash('<span></span>'.__('The student has already registered for '.
	              $this->AcademicYear->current_academicyear().' academic year of  semester '.
	              $semester.'', true),'default',array('class'=>'error-box error-message'));
	             //$this->redirect(array('action'=>'maintain_registration'));
	            }
              
          }
          
        
          if (empty($this->request->data)) {
          
			// $students=$this->_student_list_not_registred();
			 
			
			// $this->set(compact('students'));
          }
           if ( $this->role_id == ROLE_REGISTRAR) {
               
		    $yearLevels = $this->CourseRegistration->YearLevel->distinct_year_level();   
		    $programs=$this->CourseRegistration->Student->Program->find('list',
             array('conditions'=>array('Program.id'=>$this->program_id)));
		    $departments=$this->CourseRegistration->Student->Department->find('list',
          array('conditions'=>array('Department.id'=>$this->department_ids)));
             $programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
             $this->set(compact('departments','yearLevels','programs','programTypes'));
            
          }
          
          $latest_semester_academic_year=$this->CourseRegistration->latest_academic_year_semester(
           $this->AcademicYear->current_academicyear());
          //debug($this->AcademicYear->current_academicyear());
          if(!empty($this->department_ids)){
              $departments=$this->CourseRegistration->Student->Department->find('list',
              array('conditions'=>array('Department.id'=>$this->department_ids)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array('Section.department_id'=>$this->department_ids)));
              
              $yearLevels=$this->CourseRegistration->PublishedCourse->YearLevel->find('list',
              array('conditions'=>array('YearLevel.department_id'=>$this->department_ids)));
              
          } else if (!empty($this->college_ids)) {
              $colleges=$this->CourseRegistration->Student->College->find('list',
              array('conditions'=>array('College.id'=>$this->college_ids)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array('Section.college_id'=>$this->college_ids)));
                      
          } else if (!empty($this->department_id)) {
               $departments=$this->CourseRegistration->Student->Department->find('list',
              array('conditions'=>array('Department.id'=>$this->department_id)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array('Section.department_id'=>$this->department_id)));
              
              $yearLevels=$this->CourseRegistration->PublishedCourse->YearLevel->find('list',
              array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
              
              $programs=$this->CourseRegistration->Student->Program->find('list');
		      $programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
              $this->set(compact('programs','programTypes'));
             
          } else if (!empty($this->college_id)) {
              $colleges=$this->CourseRegistration->Student->College->find('list',
              array('conditions'=>array('College.id'=>$this->college_id)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array('Section.college_id'=>$this->college_id)));
              
               $programs=$this->CourseRegistration->Student->Program->find('list');
		      $programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
              $this->set(compact('programs','programTypes'));
          }
          
          
          $this->set(compact('departments','colleges','latest_semester_academic_year','sections','yearLevels'));
            
	  }
	  */
	  
	  
	  function maintain_registration($student_id=null,$register_selected_section=null) {
	      $this->__register_student($student_id, $register_selected_section);   
	  }
	  
	  private function __register_student($student_id=null,$register_selected_section=null) {
	         
          //read from session selected academic year 
            $academicYearSelected=$this->Session->read('search_data_registration');
	       //debug($academicYearSelected);
		   if(!empty($academicYearSelected)){
		      $this->request->data['continue']=true;
		   }
           if(!empty($academicYearSelected)){
		      	if(!empty($academicYearSelected['academic_year'])) {
                    $latest_academic_year=$academicYearSelected['academic_year'];
                   } else if(isset($academicYearSelected['academicyear'])) {
		   			$latest_academic_year=$academicYearSelected['academicyear'];
		      	}
            } else {
                if (!empty($this->request->data['Student']['academicyear'])) {
	                $latest_academic_year=$this->request->data['Student']['academicyear'];
	                $this->request->data['continue']=true;
	            } else {
	               $latest_academic_year=$this->AcademicYear->current_academicyear();
	            }
            }
              
	        $breaker_detail = ClassRegistry::init('User')->find('first',array('conditions' =>array('User.id' =>$this->Auth->user('id')),'contain' => array('Staff','Student')));
  
            if ($student_id==0 && !empty($register_selected_section)) {
                 //check elegibility 
                  $this->request->data['Student']=$academicYearSelected;
		  $this->request->data['continue']=true;
	          $students_list=$this->CourseRegistration->
                  Section->getSectionActiveStudentsId($register_selected_section);    
                  if (!empty($this->department_ids)) {
                    $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$students_list,'Student.department_id'=>
                    $this->department_ids,
'Student.program_type_id'=>$this->program_type_id,
                  'Student.program_id'=>$this->program_id
                    )));
                 } else if (!empty($this->college_ids)) {
                                $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$students_list,'Student.college_id'=>$this->college_ids,
'Student.program_type_id'=>$this->program_type_id,
                  'Student.program_id'=>$this->program_id,
                                	'Student.department_id is null'),'contain'=>array()));         
                    
                 } else if (!empty($this->department_id)) {
                         $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',
                         array('conditions'=>array('Student.id'=>$students_list,
                         'Student.department_id'=>$this->department_id)));
       
                 } else if (!empty($this->college_id)) {
                         $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',
                         array('conditions'=>array('Student.id'=>$students_list,
                         'Student.college_id'=>$this->college_id)));
       
                 }
                 
                 if ($elegible_registrar_responsibility==0) {
                     $this->Session->setFlash('<span></span> You do not have the privilage to register the selected student. Your action is logged and reported to the system administrators.','default',array('class'=>'error-box error-message'));
       					$details=null;
					   if (isset ($breaker_detail['Staff']) && !empty($breaker_detail['Staff'])) {
						  $details.=$breaker_detail['Staff'][0]['first_name'].' '.
						  $breaker_detail['Staff'][0]['middle_name'].' '.
						  $breaker_detail['Staff'][0]['last_name'].' ('.
						  $breaker_detail['User']['username'].')';
						} else if (isset ($breaker_detail['Student']) && !empty($breaker_detail['Student'])) {
						    $details.=$breaker_detail['Student'][0]['first_name'].' '.
						    $breaker_detail['Student'][0]['middle_name'].' '.
						    $breaker_detail['Student'][0]['last_name'].' ('.
						    $breaker_detail['User']['username'].')';
						
						}
				       
						ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(
						Configure::read('User.user'), '<u>'.
						$details.'</u> is trying to register students without assigned privilage. 
						Please give appropriate warning.'); 
	                   
                 } else {
					
                    $isRegistered=$this->CourseRegistration->massRegisterStudent(
                    $register_selected_section,$academicYearSelected); 
                    if ($isRegistered==1) {
                     $this->Session->setFlash('<span></span> All students in the selected section are registered successfully for selected academic year and semester. Only those students who are not dismissed and fullfield prerequiste has been registred.You can view all  course registrations  using the following "Course Registration View" tool.','default',array('class'=>'success-box success-message'));
                    } else if($isRegistered==3) {
                        //registration not successful tell for the user 
                         $this->Session->setFlash('<span></span> Some of the students  in the selected section are not elegible for registration.','default',
array('class'=>'info-box info-message'));
                    } 
                    
                 }   
                
                   
            }
          
      if ($student_id) {
				$this->request->data['Student']['studentnumber']=$this->CourseRegistration->Student->field('Student.studentnumber',array('Student.id'=>$student_id));
				if(isset($latest_academic_year)) {
				   $this->request->data['Student']['academicyear']=$latest_academic_year;
				}
		        if(!empty($this->department_ids)) {
                 $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$student_id,'Student.department_id'=>$this->department_ids)));
                 } else if (!empty($this->college_ids)) {
                 $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$student_id,'Student.college_id'=>$this->college_ids,'Student.department_id is null'),'contain'=>array()));       
                 } else if (!empty($this->department_id)) {
                         $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$student_id,'Student.department_id'=>$this->department_id)));
                 } else if (!empty($this->college_id)) {
                         $elegible_registrar_responsibility=$this->CourseRegistration->Student->find('count',array('conditions'=>array('Student.id'=>$student_id,
'Student.college_id'=>$this->college_id)));
                 }
               if ($elegible_registrar_responsibility==0) {
		$this->Session->setFlash('<span></span> You do not have the privilage to register the selected student. Your action is logged and reported to the system administrators.','default',array('class'=>'error-box error-message'));
$details=null;
	if (isset ($breaker_detail['Staff']) && !empty($breaker_detail['Staff'])) {
$details.=$breaker_detail['Staff'][0]['first_name'].' '.$breaker_detail['Staff'][0]['middle_name'].' '.$breaker_detail['Staff'][0]['last_name'].' ('.$breaker_detail['User']['username'].')';
} else if (isset ($breaker_detail['Student']) && !empty($breaker_detail['Student'])) {
	$details.=$breaker_detail['Student'][0]['first_name'].' '.$breaker_detail['Student'][0]['middle_name'].' '.				$breaker_detail['Student'][0]['last_name'].' ('.$breaker_detail['User']['username'].')';
}
ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$details.'</u> is trying to register students without assigned privilage. Please give appropriate warning.'); 
$this->request->data['Student']['studentnumber']=null;       
                 } else {
                 
	                $this->request->data['continue']=true;
	             }
	        }
	       $buttonClicked=false;
	       $buttonIndex='';
	       for($i = 0;
				 $i <= $this->request->data['CourseRegistration']['register_count']; $i++) {
				 if(isset($this->request->data['registerSelected_'.$i.''])){
				 	$buttonClicked=true;
				 	$buttonIndex=$i;
				 	break;
				 }
		   }
		  
	         //Register Selected students
	      if(isset($this->request->data)
	      && isset($this->request->data['CourseRegistration']) 
	      && $buttonClicked) {
				
				if(isset($this->request->data['registerSelected_'.
				$buttonIndex])) {
					  unset($this->request->data['CourseRegistration']['select_all']);
					  unset($this->request->data['CourseRegistration']['register_count']);
					  $studentLists=array();
					  $regCount=0;
					  foreach(
					  $this->request->data['CourseRegistration'] as $data){
					    
					    if($data['ggp']){
						
						$notRegistered=$this->CourseRegistration->alreadyRegistred($this->request->data['Student']['semester'],$this->request->data['Student']['academicyear'],$data['student_id']);
						if ($notRegistered == 0) {
						  
						  $publishedCourseLists=$this->CourseRegistration->registerSingleStudent($data['student_id'],$this->request->data['Student']['academicyear'],$this->request->data['Student']['semester']);
						  
			if($publishedCourseLists['passed']==false || $publishedCourseLists['passed']==4){
				continue;
		     }
			$psL= $this->CourseRegistration->getRegistrationType($publishedCourseLists['register'],$data['student_id']);
			
			foreach($psL as $pl){
					if (!isset($pl['prequisite_taken_passsed']) && !isset($pl['exemption']) || (isset($pl['prequisite_taken_passsed']) && $pl['prequisite_taken_passsed']==1 )) {
					    if(isset($pl['PublishedCourse']['id']) && !empty($pl['PublishedCourse']['id'])){
						  $studentLists['CourseRegistration'][$regCount]['student_id']=$data['student_id'];
						  $studentLists['CourseRegistration'][$regCount]['semester']=$pl['PublishedCourse']['semester'];
						  $studentLists['CourseRegistration'][$regCount]['academic_year']=$pl['PublishedCourse']['academic_year'];
						  $studentLists['CourseRegistration'][$regCount]['year_level_id']=$pl['PublishedCourse']['year_level_id'];
						   $studentLists['CourseRegistration'][$regCount]['section_id']=$pl['PublishedCourse']['section_id'];
						   $studentLists['CourseRegistration'][$regCount]['published_course_id']=$pl['PublishedCourse']['id'];
							$regCount++;
					      }
					    }
					  }  
					 }
				    }    
			      }	    
			   }
			  
			  
			  if(isset($studentLists['CourseRegistration']) && !empty($studentLists['CourseRegistration'])){
			  if ($this->CourseRegistration->saveAll($studentLists['CourseRegistration'],array('validate'=>false))) {
	              $this->Session->setFlash('<span></span>'.__('You have successfully registered the selected students  for '.$latest_academic_year.' of  semester '.$semester.'', true),'default',array('class'=>'success-box success-message'));
	             $this->request->data['continue']=false;
	           }
	          }
			 
			}
			
	        // The system asks the user to enter student identification number
            //OR to make selection for step number
           if(!empty($this->request->data) && isset($this->request->data['continue'])){
               // $this->__init_search();
				if(empty($student_id)) {
				$students=$this->CourseRegistration->student_list_not_registred($this->request->data);
				}
                // $students=$this->_student_list_not_registred($this->request->data);
                 if(empty($students) && $student_id=="" ){
                   if (!empty($this->request->data)) {
					 if (!$this->Session->check('Message.flash')){
					 $this->Session->setFlash('<span></span>No result found in the given criteria that needs course registration maintaince for '.$this->request->data['Student']['academicyear'].' Academic Year.','default',array('class'=>'info-box info-message'));
                                
                     } 
                    } else {
                            $this->Session->setFlash('<span></span>There is no result in the given criteria that needs course registration maintaince for '.$this->AcademicYear->current_academicyear().' Academic Year.','default',array('class'=>'info-box info-message'));
                    }
                     //$students=$this->_student_list_not_registred();
                 }
             
                if (!empty($this->request->data['Student']['studentnumber'])) {
              $stud_id = $this->CourseRegistration->Student->field('Student.id',array('Student.studentnumber like '=>trim($this->request->data['Student']['studentnumber'])));
			      
				   $latestAcSemester= $this->CourseRegistration->getLastestStudentSemesterAndAcademicYear($stud_id,$latest_academic_year);
	               
                   $latestSemester=$latestAcSemester['semester'];
		   $student_section= $this->CourseRegistration->Student->student_academic_detail($stud_id,$latest_academic_year);
                   if(!empty($this->request->data['Student']['semester'])) {
                   $published_courses=$this->CourseRegistration->registerSingleStudent($stud_id,$latest_academic_year,$this->request->data['Student']['semester']);
					} else {
                       $published_courses=$this->CourseRegistration->registerSingleStudent($stud_id,$latest_academic_year);
					}
                   if ($published_courses['passed'] === false || $published_courses['passed'] == 4  ) {
			           $this->Session->setFlash('<span></span>'.__('Your academic status is dismissed you can not register for semester '.$latestSemester.'/'.$latest_academic_year.'.', 
			           true),'default',array('class'=>'info-box info-message'));
			           $dismissed=true;
			
			           $this->set(compact('dismissed'));
			        }
			        
			        $previous_status_semester=$this->CourseRegistration->Student->StudentExamStatus->getPreviousSemester($latest_academic_year,$latestSemester);
	              
			       $latest_status_year_semester = $this->CourseRegistration->Student->StudentExamStatus->studentYearAndSemesterLevelOfStatusDisplay($stud_id, $latest_academic_year,$previous_status_semester['semester']);
			     
	                $student_section_exam_status=$this->CourseRegistration->Student->
	                get_student_section($stud_id,$latest_academic_year,$latest_status_year_semester['semester']);
	              
		           $published_courses=$published_courses['register'];
		           if(empty($published_courses)){
		           $this->Session->setFlash('<span></span> No course(s) publisehd for the selected student for the current academic year, or you do not have the privilage to register the selected student. Please contact his/her department.','default',array('class'=>'error-box error-message'));
	               }
		           $this->set('hide_search',true);
		           debug($published_courses);
                   $this->set(compact('published_courses',
                   'student_section','year_level_name','student_section_exam_status'));
              }
              $this->set(compact('students')); 
              
            } 
            
            if (!empty($this->request->data) && isset($this->request->data['register'])) {
              	debug($this->request->data);  
	            //check students has already registered  
	            // debug($this->Session->read('search_data_registration'));
	            $semester=$this->request->data['CourseRegistration'][1]['semester'];
	            /*
	            $not_registered=$this->CourseRegistration->alreadyRegistred(
	            $this->request->data['CourseRegistration'][1]['semester'],
	            $latest_academic_year,
	            $this->request->data['CourseRegistration'][1]['student_id']);
	           */
	           $not_registered=$this->CourseRegistration->alreadyRegistred(
	            $this->request->data['CourseRegistration'][1]['semester'],
	            $this->request->data['CourseRegistration'][1]['academic_year'],
	            $this->request->data['CourseRegistration'][1]['student_id']);
	            debug($not_registered);
	            if ($not_registered == 0) {
	                //Save course registration.


	                if (!empty($this->request->data['CourseRegistration'])) {
	                   // debug($this->request->data['CourseRegistration']);
	                    foreach ($this->request->data['CourseRegistration'] 
	                    as $eek=>&$eev) {
	                		# code...
	                		if(!isset($eev['gp'])){
                             
	                		} else if($eev['gp']==0){
	                			unset($this->request->data['CourseRegistration'][$eek]);
	                		}

	                		$this->request->data['CourseRegistration'][$eek]['cafeteria_consumer']=$this->request->data['CourseRegistration'][0]['cafeteria_consumer'];
	                		
	                	}
                       if(!empty($this->request->data['CourseRegistration'])){
	                    if ($this->CourseRegistration->saveAll($this->request->data['CourseRegistration'],
	                    array('validate'=>false))) {
	                        foreach ($this->request->data['CourseRegistration'] as $nn=>$namevalue) {
	                            $student_id=$namevalue['student_id'];
	                            break;
	                        }
					$student_name = $this->CourseRegistration->Student->field('full_name',array('Student.id'=> $student_id));
					$this->Session->setFlash('<span></span>'.__('You have successfully registered '.$student_name.' for '.$latest_academic_year.' of  semester '.$semester.'', true),'default',array('class'=>'success-box success-message'));
						unset($this->request->data['Student']['studentnumber']);
						$this->__init_search();
	
						$this->redirect(array('action'=>'maintain_registration'));
				     } 
				   } else {
				   	   $this->Session->setFlash('<span></span>'.__('Please select the courses you want to register for semester '.$latestSemester.'/'.$latest_academic_year, true),'default',array('class'=>'error-box error-message'));
				   }
		         }
	            } else {
	              $this->Session->setFlash('<span></span>'.__('The student has already registered for '.
	              $this->AcademicYear->current_academicyear().' academic year of  semester '.
	              $semester.'', true),'default',array('class'=>'error-box error-message'));
	            }
              
          }
          
           if ( $this->role_id == ROLE_REGISTRAR || 
ROLE_REGISTRAR == $this->Session->read('Auth.User')['Role']['parent_id']) {
            
		    $programs=$this->CourseRegistration->Student->Program->find('list');
		    $departments=$this->CourseRegistration->Student->Department->find('list',
          array('conditions'=>array('Department.id'=>$this->department_ids)));
             //$programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
             $this->set(compact('departments','yearLevels','programs','programTypes'));
            
          }
          
          $latest_semester_academic_year=$this->CourseRegistration->latest_academic_year_semester(
           $this->AcademicYear->current_academicyear());
          //debug($this->AcademicYear->current_academicyear());
          if(!empty($this->department_ids)){
              $departments=$this->CourseRegistration->Student->Department->find('list',
              array('conditions'=>array('Department.id'=>$this->department_ids)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array(
              	 'Section.department_id'=>$this->department_ids,
                  'Section.program_type_id'=>$this->program_type_id,
                  'Section.program_id'=>$this->program_id,
              	)));
            
              
          } else if (!empty($this->college_ids)) {
              $colleges=$this->CourseRegistration->Student->College->find('list',
              array('conditions'=>array('College.id'=>$this->college_ids)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array(
              	'Section.college_id'=>$this->college_ids,
                'Section.program_type_id'=>$this->program_type_id,
                  'Section.program_id'=>$this->program_id,
              	)));
                      
          } else if (!empty($this->department_id)) {
               $departments=$this->CourseRegistration->Student->Department->find('list',
              array('conditions'=>array('Department.id'=>$this->department_id)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',
              array('conditions'=>array('Section.department_id'=>$this->department_id)));
              
              $yearLevels=$this->CourseRegistration->PublishedCourse->YearLevel->find('list',
              array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
              
              $programs=$this->CourseRegistration->Student->Program->find('list');
		      //$programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
              $this->set(compact('programs','programTypes'));
             
          } else if (!empty($this->college_id)) {
              $colleges=$this->CourseRegistration->Student->College->find('list',
              array('conditions'=>array('College.id'=>$this->college_id)));
              $sections=$this->CourseRegistration->PublishedCourse->Section->find('list',array('conditions'=>array('Section.college_id'=>$this->college_id)));
              
              $programs=$this->CourseRegistration->Student->Program->find('list');
		      //$programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
              $this->set(compact('programs','programTypes'));
          }
             
		  $yearLevels = $this->CourseRegistration->YearLevel->distinct_year_level();   
          
          $this->set(compact('departments','colleges','latest_semester_academic_year','sections','yearLevels'));
	      $this->render('maintain_registration');
	  }
	  
	  public function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Student'])){
               
                    $search_session = $this->request->data['Student'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_registration', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data_registration');
        	$this->request->data['Student'] = $search_session;
        } 

    }
	 
	   function __init_maintain_academic_year() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Student']) && !empty($this->request->data['Student']['academicyear'])){
               
                    $search_session = $this->request->data['Student'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_registration', $search_session);
                
        } else {
          
        	$search_session = $this->Session->read('search_data_registration');
        	$this->request->data['Student'] = $search_session;
        } 

      } 
      public function individual_course_register() {
        if ($this->Session->read('search_data_registration') 
        && !isset($this->request->data['getsection'])) {
            $this->request->data['getsection']=true;
            $this->request->data['Student']=$this->Session->read('search_data_registration');
            $this->set('hide_search',true);          
        }
        if (!empty($this->request->data) 
        && isset($this->request->data['registerIndivdualCourse'])) {
			$one_is_selected=0;
			$selected_published_courses=array();
			$formattedSaveAllRegistration=array();
			$count=0;
			foreach (
			$this->request->data['PublishedCourse'] 
			as $section_id=>$publishedcourse) {
			    $student_list=$this->CourseRegistration->Section->getSectionActiveStudentsId($section_id);  
				
				foreach($publishedcourse as 
				$p_id=>$selected){ 
					if ($selected==1) {
					  $publishedCourseDetailedS=$this->CourseRegistration->PublishedCourse->find('first',array('conditions'=>array('PublishedCourse.id'=>$p_id),
				'recursive'=>-1));
				
						$one_is_selected++;
						foreach($student_list as $stk=>$stv){
						
						//courseRegistered
						if(!$this->CourseRegistration->courseRegistered($p_id,$publishedCourseDetailedS['PublishedCourse']['semester'],$publishedCourseDetailedS['PublishedCourse']['academic_year'],$stv) && $this->CourseRegistration->CourseDrop->course_taken($stv,
						$publishedCourseDetailedS['PublishedCourse']['course_id'])==3){
						   $formattedSaveAllRegistration['CourseRegistration'][$count]['published_course_id']
                         =$publishedCourseDetailedS['PublishedCourse']['id'];
                          $formattedSaveAllRegistration['CourseRegistration'][$count]['course_id']
                         =$publishedCourseDetailedS['PublishedCourse']['course_id'];
                         
                           $formattedSaveAllRegistration['CourseRegistration'][$count]['semester']
                         =$publishedCourseDetailedS['PublishedCourse']['semester'];
                         
                            $formattedSaveAllRegistration['CourseRegistration'][$count]['academic_year']
                         =$publishedCourseDetailedS['PublishedCourse']['academic_year'];
                         
                          $formattedSaveAllRegistration['CourseRegistration'][$count]['student_id']
                         =$stv;
                         
                          $formattedSaveAllRegistration['CourseRegistration'][$count]['section_id']
                         =$publishedCourseDetailedS['PublishedCourse']['section_id'];
                         
                         $formattedSaveAllRegistration['CourseRegistration'][$count]['year_level_id']
                         =$publishedCourseDetailedS['PublishedCourse']['year_level_id'];
                         $count++;
						}
					  }
				  }
			}
		  }
		  
		  if(isset($formattedSaveAllRegistration) && !empty($formattedSaveAllRegistration)){
		     if ($this->CourseRegistration->saveAll($formattedSaveAllRegistration['CourseRegistration'],
		     array('validate'=>false))) {
	              $this->Session->setFlash('<span></span> '.__('The selected course has been register for elegible students.'),'default',array('class'=>'success-box sucess-message'));
	            } else {
	                   $this->Session->setFlash('<span></span> '.__('The selected course couldnt be registered.'),'default',array('class'=>'error-box error-message')); 
	            } 
		  }
		  if($one_is_selected==0){
		    $this->Session->setFlash('<span></span> '.__('Please select one course atleast.'),'default',array('class'=>'error-box error-message')); 
		  }
	   }
	  if (!empty($this->request->data) && isset($this->request->data['getsection'])) {
			$this->Session->delete('search_data_registration');
			$everythingfine=false;
			switch($this->request->data) {
			        case empty($this->request->data['Student']['academic_year']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the academic year you want to cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester you want to cancel  course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['department_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the department you want to cancel  course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['year_level_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the year level you want cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Student']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to cancel courses registration.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Student']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			if ($everythingfine) {
			      
			   $this->__init_search();
			   $yearLevelId=$this->CourseRegistration->PublishedCourse->YearLevel->field('id',array('YearLevel.department_id'=>$this->request->data['Student']['department_id'],'YearLevel.name'=>$this->request->data['Student']['year_level_id']));
			       
			   $sections=$this->CourseRegistration->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$this->request->data['Student']['department_id'],
			        'Section.year_level_id'=>$yearLevelId,
			        'Section.program_id'=>$this->request->data['Student']['program_id'],
			        'Section.program_type_id'=>$this->request->data['Student']['program_type_id'],
'Section.academicyear'=>$this->request->data['Student']['academic_year'])));
			$listOfPublishedCourses=$this->CourseRegistration->PublishedCourse->find('all',array('conditions'=>array(
			'PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
			'PublishedCourse.year_level_id'=>$yearLevelId,
			'PublishedCourse.drop'=>0,
			'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
			'PublishedCourse.program_type_id'=>$this->request->data['Student']['program_type_id'],
			'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
			'PublishedCourse.academic_year'=>$this->request->data['Student']['academic_year'],
			'PublishedCourse.id not in (select published_course_id from course_registrations)'

			),'fields'=>array('id','section_id'),
			'contain'=>array('Course'=>array('fields'=>array('id','course_title','course_code','lecture_hours','tutorial_hours','credit')))));
		    $organized_published_course_by_section=array();
			$published_counter=0;
			foreach($listOfPublishedCourses as $lp=>$lv){
					if (isset($lv['PublishedCourse']['section_id']) && !empty($lv['PublishedCourse']['section_id'])) {  
							 $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
							 [$published_counter]=$lv;
							 $publish_courses_list_ids[$published_counter]=$lv['PublishedCourse']['id'];
					}
					$published_counter++;
			}
	      if (empty($listOfPublishedCourses) 
	      && !isset($this->request->data['registerIndivdualCourse'])) {
		$this->Session->setFlash('<span></span> '.__('No result is found in a given criteria.'),'default',array('class'=>'info-box info-message'));  
	     } else {
			$this->set('hide_search',true);
			$listofPublishedCourses=$organized_published_course_by_section;
			$this->set(compact('sections','listOfPublishedCourses'));
			$this->set(compact('organized_published_course_by_section',
			'published_counter','grade_submitted_counter'));
         }
		$year_level_id=$this->request->data['Student']['year_level_id'];
		$program_name=$this->CourseRegistration->PublishedCourse->Program->field('Program.name',array('Program.id'=>$this->request->data['Student']['program_id']));
		$program_type_name=$this->CourseRegistration->PublishedCourse->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Student']['program_type_id']));
			        $academic_year=$this->request->data['Student']['academic_year'];
			        $semester=$this->request->data['Student']['semester'];
			        $department_name=$this->CourseRegistration->PublishedCourse->Department->field(
			        'Department.name',array('Department.id'=>$this->request->data['Student']['department_id']));
			        $this->set(compact('sections','year_level_id','program_name','program_type_name',
			        'academic_year','semester','department_name'));  
		   }
	 }
	 
	 if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
	    
		   $yearLevels =$this->CourseRegistration->YearLevel->distinct_year_level();
		    $programs=$this->CourseRegistration->Student->Program->find('list',
             array('conditions'=>array('Program.id'=>$this->program_id)));
		    $departments=$this->CourseRegistration->Student->Department->find('list',
          array('conditions'=>array('Department.id'=>$this->department_ids)));
             $this->set(compact('departments','yearLevels','programs'));
           
		
		} else if ($this->role_id == ROLE_COLLEGE) { 
		     $yearLevels =$this->CourseRegistration->YearLevel->distinct_year_level();
		    $programs=$this->CourseRegistration->Student->Program->find('list');
		    $departments=$this->CourseRegistration->Student->Department->find('list',
          array('conditions'=>array('Department.college_id'=>$this->department_id)));
             $this->set(compact('departments','yearLevels','programs'));
             
		} else {
		   $departments=$this->CourseRegistration->Student->Department->find('list',array('conditions'=>
		   array('Department.id'=>$this->department_id)));
		   $yearLevels=$this->CourseRegistration->YearLevel->find('list',array('conditions'=>
		   array('YearLevel.department_id'=>$this->department_id)));
		   $programs=$this->CourseRegistration->Student->Program->find('list');
		  $this->set(compact('departments','yearLevels','programs'));
		}
		$programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
		$this->set(compact('programTypes'));
        
      }
	  /**
	  * Function to cancel registration of selected department
	  * given academic year,semester.
	  */
	public function cancel_registration () {
	// Function to load/save search criteria.       
        if ($this->Session->read('search_data_registration') && 
        !isset($this->request->data['getsection'])) {
                       $this->request->data['getsection']=true;
                       $this->request->data['Student']=$this->Session->read('search_data_registration');
                       $this->set('hide_search',true);
                      
        }
        if (!empty($this->request->data) && isset($this->request->data['canceregistration'])) {
	    $one_is_selected=0;
	    $selected_published_courses=array();
	    foreach ($this->request->data['PublishedCourse'] as $section_id=>$publishedcourse) {
	               foreach($publishedcourse as $p_id=>$selected){ 
	                    if ($selected==1) {
	                         $one_is_selected++;
	                        // break 2;
	                        $selected_published_courses[]=$p_id;
	                    }
	                }
	          }
	          
	          //check if checked.
	          if ($one_is_selected) {
	              
	               if(!empty($selected_published_courses)) {
	                     //foreach publish course
	                      $register_for_delete['register']=array();
	                      $tmp=array();
	                      $add_for_delete['add']=array();
	                      $grade_submitted_pub_count = 0;
	                      foreach ($selected_published_courses as $key=>$pid) {
	                      	   $is_grade_submitted = $this->CourseRegistration->ExamGrade->is_grade_submitted($pid);
	                      	   //check again if grade si not submitted then allow cancellation.
	                      	   if (!$is_grade_submitted) { 
	                          	   $tmp=$this->CourseRegistration->PublishedCourse->
	                          	   getStudentsTakingPublishedCourse($pid);
	                          	 
	                               if(!empty($tmp['register']) && count($tmp['register'])>0) {
	                                 
	                                    foreach($tmp['register'] as $index=>$value){
	                                        if (isset($value['CourseRegistration']['id'])
	                                        &&
	                                        !empty($value['CourseRegistration']['id'])) {
	                                        $register_for_delete['register'][]=
	                                        $value['CourseRegistration']['id'];
	                                        
	                                        }
	                                        
	                                         if (isset($value['CourseAdd']['id'])
	                                        &&
	                                        !empty($value['CourseAdd']['id'])) {
	                                        $add_for_delete['add'][]=
	                                        $value['CourseAdd']['id'];
	                                        
	                                        }
	                                        
	                                        
	                                    }
	                               
	                               }
	                               if(!empty($tmp['add']) && count($tmp['add'])>0) {
	                                    foreach($tmp['add'] as $index=>$value){
	                                        if (!empty($value['CourseAdd']['id'])) {
	                                            $add_for_delete['add'][]=$value['CourseAdd']['id'];
	                                        }
	                                    }
	                               
	                               }
	                               $tmp=array();
	                           } else {
	                             $grade_submitted_pub_count++;
	                           }
                         }
                      
                      if (count($selected_published_courses) !=$grade_submitted_pub_count) {  
                             if(!empty($register_for_delete['register'])) {
	                            
	                           if($this->CourseRegistration->deleteAll(
	                             array('CourseRegistration.id'=>$register_for_delete['register']), false)) {
							          
				                 }
				                
				             }
				            if (!empty($add_for_delete['add'])) {
				               if($this->CourseRegistration->PublishedCourse->CourseAdd->deleteAll(array('CourseAdd.id'=>$add_for_delete['add']), false)) {
							    }
				            }
				            if (!empty($register_for_delete['register']) || !empty($add_for_delete['add'])) {
				                 $this->Session->setFlash('<span></span>'.
				                 __('Course registration is cancelled for selected courses.'), 'default', array('class' => 'success-message success-box'));
							     
				            }
		     		  } else {
		                    $this->Session->setFlash('<span></span>'.__('You can not cancel the course registration grade has already submitted.'), 'default', array('class' => 'info-message  info-box'));
				      
				      }  
				       // $this->redirect(array('action'=>'index'));
				      
	               }
	          } else {
	                  $this->Session->setFlash('<span></span> '.__('Please select courses you want to cancel registration for mass students.'),'default',array('class'=>'error-box error-message')); 
	          }
	   }
	  if (!empty($this->request->data) && isset($this->request->data['getsection'])) {
			$this->Session->delete('search_data_registration');
			$everythingfine=false;
			switch($this->request->data) {
			        case empty($this->request->data['Student']['academic_year']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the academic year you want to cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester you want to cancel  course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['department_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the department you want to cancel  course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['year_level_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the year level you want cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Student']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to cancel courses registration.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Student']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			if ($everythingfine) {
			      
			        $this->__init_search();
			        $yearLevelId=$this->CourseRegistration->PublishedCourse->YearLevel->field('id',
			       array('YearLevel.department_id'=>$this->request->data['Student']['department_id'],
			       'YearLevel.name'=>$this->request->data['Student']['year_level_id']));
			       
			        $sections=$this->CourseRegistration->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$this->request->data['Student']['department_id'],
			        'Section.year_level_id'=>$yearLevelId,
			        'Section.program_id'=>$this->request->data['Student']['program_id'],
			        'Section.program_type_id'=>$this->request->data['Student']['program_type_id'],
'Section.academicyear'=>$this->request->data['Student']['academic_year']
			        
			        )));
			      
			     
			       
			      $listOfPublishedCourses=$this->CourseRegistration->PublishedCourse->find('all',array('conditions'=>array(
			        'PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
			        'PublishedCourse.year_level_id'=>$yearLevelId,
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Student']['program_type_id'],
			        'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
  'PublishedCourse.academic_year'=>$this->request->data['Student']['academic_year'],
			           
			        ),'fields'=>array('id','section_id'),
			        'contain'=>array('Course'=>array('fields'=>array('id','course_title','course_code','lecture_hours','tutorial_hours','credit')))));
			       $organized_published_course_by_section=array();
			       $publish_courses_list_ids = array();
			       $published_counter=0;
			       $grade_submitted_counter=0;
			       foreach($listOfPublishedCourses as $lp=>$lv){
			             if (isset($lv['PublishedCourse']['section_id']) && 
			             !empty($lv['PublishedCourse']['section_id'])) {  
			             $is_grade_submitted = $this->CourseRegistration->ExamGrade->is_grade_submitted(
			              $lv['PublishedCourse']['id']);
			             
			               $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			             [$published_counter]=$lv;
			             if($is_grade_submitted) {
			           
			              $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			             [$published_counter]['grade_submitted']=1;
			              $grade_submitted_counter++;
			             } else {
			              
			              $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			             [$published_counter]['grade_submitted']=0;
			             
			             }
			            
			             $publish_courses_list_ids[$published_counter]=$lv['PublishedCourse']['id'];
			             
			             
			            }
			            $published_counter++;
			        }
			       
			        $publishedCourseRegister = $this->CourseRegistration->find('all',array('conditions'=>array(
			        'CourseRegistration.published_course_id'=>$publish_courses_list_ids,
			        'CourseRegistration.published_course_id IN (select published_course_id from course_registrations)',
			        'CourseRegistration.id NOT IN (select course_registration_id from exam_grades where 
			        course_registration_id is not null)'
			        
			        ),
			        'order'=>'CourseRegistration.id DESC',
			        'contain'=>array('ExamGrade','PublishedCourse'=>array('Course'))));
			        
			        $publishedCourseAdd = ClassRegistry::
	    init('CourseAdd')->find('all',array('conditions'=>array(
			        'CourseAdd.published_course_id'=>$publish_courses_list_ids,
			        'CourseAdd.published_course_id IN (select published_course_id 
			        from course_adds)',
			        'CourseAdd.id NOT IN (select course_add_id from exam_grades where course_add_id is not null)'
			        
			        ),
			        'contain'=>array('ExamGrade','PublishedCourse'=>array('Course'))));
	      if (empty($publishedCourseRegister) && empty($publishedCourseAdd) && !isset($this->request->data['canceregistration'])) {
		$this->Session->setFlash('<span></span> '.__('No result is found. Either grade is submitted or there is no course registration in the selected criteria.'),'default',array('class'=>'info-box info-message'));  
	        } else {
		$this->set('hide_search',true);
$listofPublishedCourses=$organized_published_course_by_section;
$this->set(compact('sections','listOfPublishedCourses'));
$this->set(compact('organized_published_course_by_section',
'published_counter','grade_submitted_counter'));
	        
                 }
		$year_level_id=$this->request->data['Student']['year_level_id'];
		$program_name=$this->CourseRegistration->PublishedCourse->Program->field('Program.name',array('Program.id'=>$this->request->data['Student']['program_id']));
		$program_type_name=$this->CourseRegistration->PublishedCourse->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Student']['program_type_id']));
			        $academic_year=$this->request->data['Student']['academic_year'];
			        $semester=$this->request->data['Student']['semester'];
			        $department_name=$this->CourseRegistration->PublishedCourse->Department->field(
			        'Department.name',array('Department.id'=>$this->request->data['Student']['department_id']));
			        
			       
			        $this->set(compact('sections','year_level_id','program_name','program_type_name',
			     'academic_year','semester','department_name'));  
			      
			
		   }
	 }
	 
	   if ( $this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
	    
		   $yearLevels =$this->CourseRegistration->YearLevel->distinct_year_level();
		    $programs=$this->CourseRegistration->Student->Program->find('list',
             array('conditions'=>array('Program.id'=>$this->program_id)));
		    $departments=$this->CourseRegistration->Student->Department->find('list',
          array('conditions'=>array('Department.id'=>$this->department_ids)));
             $this->set(compact('departments','yearLevels','programs'));
           
		
		} else if ($this->role_id == ROLE_COLLEGE) { 
		     $yearLevels =$this->CourseRegistration->YearLevel->distinct_year_level();
		    $programs=$this->CourseRegistration->Student->Program->find('list');
		    $departments=$this->CourseRegistration->Student->Department->find('list',
          array('conditions'=>array('Department.college_id'=>$this->department_id)));
             $this->set(compact('departments','yearLevels','programs'));
             
		} else {
		   $departments=$this->CourseRegistration->Department->find('list',array('conditions'=>
		   array('Department.id'=>$this->department_id)));
		   $yearLevels=$this->CourseRegistration->YearLevel->find('list',array('conditions'=>
		   array('YearLevel.department_id'=>$this->department_id)));
		   $programs=$this->CourseRegistration->Student->Program->find('list');
		  $this->set(compact('departments','yearLevels','programs'));
		}
		$programTypes=$this->CourseRegistration->Student->ProgramType->find('list');
		$this->set(compact('programTypes'));
	            
	  }
	  
	  function show_course_registred_students($published_course_id=null) {
	        $this->layout='ajax';
	          /// give the user the list of courses which is already displayed
					// from the session when validation error occur.
			$registred_students=$this->CourseRegistration->PublishedCourse->getStudentsTakingPublishedCourse($published_course_id);
	        $this->set(compact('registred_students'));
	  } 
	
	function get_course_registered_grade_list($register_or_add = null) {
		$this->layout = 'ajax';
		$grade_scale = array();
		if($register_or_add != "0" && $register_or_add != "") {
			$register_or_add = explode('~', $register_or_add);
			if(strcasecmp($register_or_add[1], 'add') == 0) {
				$published_course_id = $this->CourseRegistration->PublishedCourse->CourseAdd->field('published_course_id', array('id' => $register_or_add[0]));
			}
			else {
				$published_course_id = $this->CourseRegistration->field('published_course_id', array('id' => $register_or_add[0]));
			}
		
		$grade_scale = $this->CourseRegistration->PublishedCourse->CourseRegistration->getPublishedCourseGradeScaleList($published_course_id);
		//$grade_scale = $grade_scale + array('NG' => 'NG');
		$grade_scale = array('0' => '--- Select Grade ---') + $grade_scale;
		}
		$this->set(compact('grade_scale'));
	}
	
	function get_course_registered_grade_result($register_or_add = null) {
		$this->layout = 'ajax';
		$grade_history = array();
		if($register_or_add != "0" && $register_or_add != "") {
			$register_or_add = explode('~', $register_or_add);
			if(count($register_or_add) == 2) {
				if($register_or_add[1] == 'register')
					$grade_history = $this->CourseRegistration->getCourseRegistrationGradeHistory($register_or_add[0]);
				else
					$grade_history = $this->CourseRegistration->PublishedCourse->CourseAdd->getCourseAddGradeHistory($register_or_add[0]);
			}
		}
		$this->set(compact('grade_history', 'register_or_add'));
	}
	
	function _givenPublisheCourseReturnDept ($publish_course_ids=array()) {
	   //write it as function and reuse 
         //$department_colleges_ids = array ();
         $department_colleges_ids['dept']=array();
         $department_colleges_ids['college']=array();
         if (!empty($publish_course_ids)) {
             foreach ($publish_course_ids as $id=>$idvalue) {
                        /*if (!empty($idvalue['department_id'])) {        
                                    $department_ids[] =$this->CourseRegistration->PublishedCourse->field('department_id',array('PublishedCourse.id'=>$idvalue)); 
                          }
                          */
                          $college_department=$this->CourseRegistration->PublishedCourse->find('first',
                          array('conditions'=>array('PublishedCourse.id'=>$idvalue),
                          'fields'=>array('department_id','college_id'),'recursive'=>-1));
                         
                           if (!empty($college_department['PublishedCourse']['department_id'])) {
                              $department_colleges_ids['dept'][]=$college_department['PublishedCourse']['department_id'];
                           } else {
                             $department_colleges_ids['college'][]=$college_department['PublishedCourse']['college_id'];
                           }   
             }
         }
         return $department_colleges_ids;
	}
	
	
	
	
	
     /*
     *Cancel individual student registration 
     */
     function cancel_individual_registration($student_id=null) {
	       
        if (!empty($this->request->data) && isset($this->request->data['canceregistration'])) {
            
             
            $registrationListForDelete=array_keys($this->request->data['CourseRegistration']);
            if($this->CourseRegistration->deleteAll(array('CourseRegistration.id'=>
            $registrationListForDelete), false)) {
		        
		          $this->Session->setFlash('<span></span>'.
				                 __('The selected student course registration cancellation is successful.'), 
				                 'default', array('class' => 'success-message success-box'));     
               
             }	
            $this->Session->delete('search_data_registration'); 
            unset($this->request->data['getstudentregistration']);//=false;   
	    }
       
        // Function to load/save search criteria.
               
        if ($this->Session->read('search_data_registration') && 
        !isset($this->request->data['getstudentregistration'])) {
                       $this->request->data['getstudentregistration']=true;
                       $this->request->data['Student']=$this->Session->read('search_data_registration');
                       $this->set('hide_search',true);
                      
        }
        
       
           
        if (!empty($this->request->data) && isset($this->request->data['getstudentregistration'])) {
			$this->Session->delete('search_data_registration');
			$everythingfine=false;
			switch($this->request->data) {
			        case empty($this->request->data['Student']['academic_year']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the academic year you want to cancel course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester you want to cancel  course registration.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         
			        case empty($this->request->data['Student']['studentnumber']) :
			         $this->Session->setFlash('<span></span> '.__('Please provide
			          the student number (ID) you want to cancel course registration.', true),
			          'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			
			if ($everythingfine) {
			          $check_id_is_valid=$this->CourseRegistration->Student->
			            find('count',
			            array('conditions'=>array('Student.studentnumber'=>
			            trim($this->request->data['Student']['studentnumber']))));
			           
			             if ($check_id_is_valid>0) {
			                 // do something if needed
			             
			             } else {
			                $everythingfine=false;
			                $this->Session->setFlash('<span></span> '.
			                __('The provided student number is not valid.'),'default',
			                array('class'=>'error-box error-message'));      
			             }
			}
			             
			if ($everythingfine) {
			      
			       $this->__init_search();
			          $studentDbId=$this->CourseRegistration->Student->field('Student.id',
			       array('Student.studentnumber'=>$this->request->data['Student']['studentnumber']));
			       
			         $student_section= $this->CourseRegistration->Student->student_academic_detail(
			         $studentDbId,$this->request->data['Student']['academic_year']);
			       
			           $student_section_exam_status=$this->CourseRegistration->Student->
	                get_student_section($studentDbId,$this->request->data['Student']['academic_year'],
	               $this->request->data['Student']['semester']);
	               
			       $course_registration_id_publish_ids=$this->CourseRegistration->find('list',
			       array('conditions'=>array('CourseRegistration.student_id'=>$studentDbId,
			       'CourseRegistration.semester'=>$this->request->data['Student']['semester'],
			        'CourseRegistration.academic_year'=>$this->request->data['Student']['academic_year']
			       ),'fields'=>array('CourseRegistration.id','CourseRegistration.published_course_id'),'recursive'=>-1));
                 	
                 	
                 	
                 	$publiscourse_ids=array_values($course_registration_id_publish_ids);	          
			      $listOfPublishedCourses=$this->CourseRegistration->PublishedCourse->find('all',
			      array('conditions'=>array(
			       'PublishedCourse.id'=>$publiscourse_ids,
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.academic_year'=>$this->request->data['Student']['academic_year'],
			      
			        'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
			          
			        ),'fields'=>array('id','section_id'),
			        'contain'=>array(
			                'Course'=>array('fields'=>array('id','course_title',
			                'course_code','lecture_hours','tutorial_hours','credit')
			              )
			            )
			          )
			        );
			      
			     
			     
			       $organized_published_course_by_section=array();
			       $publish_courses_list_ids = array();
			       $published_counter=0;
			       $grade_submitted_counter=0;
			       $isGradeSubmittedToAnyCourse=false;
			     
			       foreach($listOfPublishedCourses as $lp=>$lv) {
			       
			             if (isset($lv['PublishedCourse']['section_id']) && 
			             !empty($lv['PublishedCourse']['section_id'])) {  
			             $is_grade_submitted = $this->CourseRegistration->ExamGrade->is_grade_submitted(
			              $lv['PublishedCourse']['id']);
			             
			               $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			             [$published_counter]=$lv;
			             if($is_grade_submitted) {
			           
			              $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			             [$published_counter]['grade_submitted']=1;
			              $grade_submitted_counter++;
			              $isGradeSubmittedToAnyCourse=true;
			             } else {
			              
			              $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			             [$published_counter]['grade_submitted']=0;
			             
			             }
			            
			             $publish_courses_list_ids[$published_counter]=$lv['PublishedCourse']['id'];
			             
			             
			            }
			            $published_counter++;
			        }
			       
			       
			        if (empty($listOfPublishedCourses)) {
			              $this->Session->setFlash('<span></span> '.__('No result is found. There is no course registration in the selected criteria.'),'default',array('class'=>'info-box info-message'));  
			        
			        } else {
			        
			           $this->set('hide_search',true);
			        
			           $listofPublishedCourses=$organized_published_course_by_section;
			           $this->set(compact('listOfPublishedCourses'));
			          $this->set(compact('organized_published_course_by_section',
			          'published_counter','grade_submitted_counter'));
			     
			        
			        }
			        
			        $this->set(compact('student_section_exam_status','isGradeSubmittedToAnyCourse',
			        'course_registration_id_publish_ids'));  
			      
			
		   }
	    }
	    
	 }
	
	public function grade_view_by_course() {	
		$this->paginate = array('contain'=>array('Student' => array('Department', 'Curriculum', 'ProgramType', 'Program'), 'ExamGrade' => array('order' => array('ExamGrade.created DESC'))));
		
	
         if((isset($this->request->data['CourseRegistration']) && isset($this->request->data['viewPDF']))) {
	  		$search_session = $this->Session->read('search_data_list_course');
            $this->request->data['CourseRegistration'] = $search_session;
	    }

		if(isset($this->passedArgs)) {
	         if(isset($this->passedArgs['page'])) {	
		 	 	  $this-> __init_search_course_lists();
                  $this->request->data['CourseRegistration']['page']=$this->passedArgs['page'];
                  $this-> __init_search_course_lists();
             } 
	     } 

        if((isset($this->request->data['CourseRegistration']) && isset($this->request->data['listStudentWithGrade']))) {
	        $this-> __init_search_course_lists();
	    }

        //limit
		if (isset($this->request->data['CourseRegistration']['limit']) && !empty($this->request->data['CourseRegistration']['limit'])) {
			$this->paginate['limit'] = $this->request->data['CourseRegistration']['limit'];
		 } else {
			$this->paginate['limit']=50;
		 }

		// filter by department 
		if (isset($this->request->data['CourseRegistration']['department_id']) && !empty($this->request->data['CourseRegistration']['department_id'])) {
			 $this->paginate['conditions'][]['Student.department_id'] = $this->request->data['CourseRegistration']['department_id'];
		}

       // filter by college 
		if (isset($this->request->data['CourseRegistration']['college_id']) && !empty($this->request->data['CourseRegistration']['college_id'])) {
             if($this->request->data['CourseRegistration']['college_id']=='pre'){
				 $this->paginate['conditions'][]['Student.college_id'] = $this->request->data['CourseRegistration']['college_id'];
                 $this->paginate['conditions'][] = 'Student.department_id is null';
			 } else {
			 $this->paginate['conditions'][]['Student.college_id'] = $this->request->data['CourseRegistration']['college_id'];
			 }		
	   }

		// filter by program 

		if (isset($this->request->data['CourseRegistration']['program_id']) && !empty($this->request->data['CourseRegistration']['program_id'])) {
			$this->paginate['conditions'][]['Student.program_id'] = $this->request->data['CourseRegistration']['program_id'];
		}

		// filter by program type
		if (isset($this->request->data['CourseRegistration']['program_type_id']) && !empty($this->request->data['CourseRegistration']['program_type_id'])) {
			$this->paginate['conditions'][]['Student.program_type_id'] = $this->request->data['CourseRegistration']['program_type_id'];
		}


		// filter by program type
		if (isset($this->request->data['CourseRegistration']['course_id']) && !empty($this->request->data['CourseRegistration']['course_id'])) {
			  $listCourseRegistrationIdsSql="SELECT GROUP_CONCAT( cr.id ) as ids 
FROM  course_registrations AS cr, published_courses AS ps
WHERE cr.academic_year='".$this->request->data['CourseRegistration']['acadamic_year']."' AND cr.semester= '".$this->request->data['CourseRegistration']['semester']."' AND ps.semester='".$this->request->data['CourseRegistration']['semester']."' AND ps.academic_year='".$this->request->data['CourseRegistration']['acadamic_year']."' AND ps.id = cr.published_course_id AND ps.course_id =".$this->request->data['CourseRegistration']['course_id']." AND ps.program_id=".$this->request->data['CourseRegistration']['program_id']." AND ps.program_type_id=".$this->request->data['CourseRegistration']['program_type_id']."
and cr.published_course_id=ps.id ORDER BY GROUP_CONCAT(cr.id)";
			 $listCourseRegistrationIdsQueryResult = ClassRegistry::init('CourseRegistration')->query($listCourseRegistrationIdsSql);
			
		    if(!empty($listCourseRegistrationIdsQueryResult[0][0]['ids']))
            {
			$this->paginate['conditions'][]['CourseRegistration.id'] = explode(',',$listCourseRegistrationIdsQueryResult[0][0]['ids']);
			}
		}

		 //order by
		if (isset($this->request->data['CourseRegistration']['sortby']) && !empty($this->request->data['CourseRegistration']['sortby'])) {
			$this->paginate['order'] =array('Student.'.$this->request->data['CourseRegistration']['sortby'].' ASC','Student.first_name');
		}



        if (isset($this->request->data['CourseRegistration']['page']) && !empty($this->request->data['CourseRegistration']['page'])) {
			$this->paginate['page'] = $this->request->data['CourseRegistration']['page'];
		}              
        $this->Paginator->settings=$this->paginate;
	    //debug($this->Paginator->settings);
	
       if(isset($this->Paginator->settings['conditions'])) {
		      $studentExamGradeList=$this->Paginator->paginate('CourseRegistration');  
		}
		else {
			$studentExamGradeList= array();
		}
		
		
	   if (empty($studentExamGradeList) && isset($this->request->data) && !empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('No student taking the course and score grade for the selected course.'),'default',array('class'=>'info-box info-message'));
		}
		
	    if((!empty($this->request->data['CourseRegistration']) && !empty($this->request->data['viewPDF']))) {
				 $this->autoLayout = false;
				$courseDetail=$this->CourseRegistration->PublishedCourse->Course->find('first',array('conditions'=>array('Course.id'=>$this->request->data['CourseRegistration']['course_id']),'contain'=>array('Curriculum','YearLevel')));
				$academicYear=$this->request->data['CourseRegistration']['acadamic_year'];
				
				$semester=$this->request->data['CourseRegistration']['semester'];
			   $department=$this->CourseRegistration->Student->Department->find('first',
array('conditions'=>array('Department.id'=>$this->request->data['CourseRegistration']['department_id']),'contain'=>array('College'=>array('Campus'))));
		       $program=$this->CourseRegistration->Student->Program->find('first',
array('conditions'=>array('Program.id'=>$this->request->data['CourseRegistration']['program_id']),'recursive'=>-1));
				 $programType=$this->CourseRegistration->Student->ProgramType->find('first',
array('conditions'=>array('ProgramType.id'=>$this->request->data['CourseRegistration']['program_type_id']),'recursive'=>-1));
			   $university= ClassRegistry::init('University')->getStudentUnivrsity($studentExamGradeList[0]['CourseRegistration']['student_id']);
              $filename="Roaster- ".$department['Department']['name'].' Academic_Year-'.$academicYear.' Semester- '.$semester;
			  $this->set(compact('courseDetail','department','program',
'programType','university','studentExamGradeList','filename','academicYear','semester'));
             
			 $this->render('grade_view_xls');
			
					/*
					$this->set(compact('studentExamGradeList'));
					$this->response->type('application/pdf');
			 		$this->layout = '/pdf/default';
					$this->render('grade_view_list_pdf');
			      */
	   } 



		if(!empty($this->department_ids)){
			$departments = $this->CourseRegistration->PublishedCourse->Department->find('list',
array('conditions'=>array('Department.id'=>$this->department_ids)));
		} else if (!empty($this->college_ids)) {
			$colleges = $this->CourseRegistration->PublishedCourse->College->find('list',
array('conditions'=>array('College.id'=>$this->college_ids)));
		} else {
				if(!empty($this->department_id) && $this->role_id==ROLE_DEPARTMENT) {
				$departments = $this->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));
				} else if(!empty($this->college_id) && $this->role_id==ROLE_COLLEGE) {
				$colleges = $this->CourseRegistration->PublishedCourse->College->find('list',array('conditions'=>array('College.id'=>$this->college_id)));
				$colleges['pre']='Pre Engineering';
				} 
		}
		$selectedAcademicYear=$this->AcademicYear->current_academicyear();
		$defaultSemester="I";
		
		if(!empty($this->request->data['CourseRegistration']['acadamic_year'])){
			$selectedAcademicYear=$this->request->data['CourseRegistration']['acadamic_year'];
		} 

		if(!empty($this->request->data['CourseRegistration']['semester'])){
			$defaultSemester=$this->request->data['CourseRegistration']['semester'];
		} 

		
     	$programs = $this->CourseRegistration->PublishedCourse->Section->Program->find('list');
		$program_types = $this->CourseRegistration->PublishedCourse->Section->ProgramType->find('list');
	    if(isset($this->request->data['CourseRegistration']) && !empty($this->request->data['CourseRegistration']['department_id'])){
			$defaultDepartment=$this->request->data['CourseRegistration']['department_id'];
			
		} else {
		  	$defaultDepartment=current(array_keys($departments));
		}		

		if(isset($this->request->data['CourseRegistration']) && !empty($this->request->data['CourseRegistration']['college_id'])){
			$defaultCollege=$this->request->data['CourseRegistration']['college_id'];
		} else {
            if(!empty($colleges)){
				$defaultCollege=current(array_keys($colleges));
		    } else {
				$defaultCollege=null;
			}		
		}	

	   if(isset($this->request->data['CourseRegistration']) && !empty($this->request->data['CourseRegistration']['program_id'])){
			$defaultProgram=$this->request->data['CourseRegistration']['program_id'];
		} else {
        	$defaultProgram=current(array_keys($programs));   	
		}

		if(isset($this->request->data['CourseRegistration']) && !empty($this->request->data['CourseRegistration']['program_type_id'])){
			$defaultProgramType=$this->request->data['CourseRegistration']['program_type_id'];
		} else {
        	$defaultProgramType=current(array_keys($program_types));
		}

		
		
        if(!empty($defaultDepartment)){         
		$courses=$this-> _getCourseLists($selectedAcademicYear,$defaultSemester,
$defaultProgram,$defaultProgramType,$defaultCollege,$defaultDepartment,0);
		} else {
			$courses=$this-> _getCourseLists($selectedAcademicYear,$defaultSemester,
$defaultProgram,$defaultProgramType,$defaultCollege,$defaultDepartment,1);
		}
		
		$sortOptions=array('middle_name'=>'Middle Name','last_name'=>'Last Name',
'studentnumber'=>'Student ID');
		$this->set(compact('programs','courses','program_types','departments','sortOptions','colleges',
'studentExamGradeList'));
	}
	function get_course_category_combo($paramaters){
         $this->layout = 'ajax';
	     $courseLists=array();
		 $criteriaLists = explode('~',$paramaters); 
          if(!empty($criteriaLists[0])) {
          $courseLists=$this-> _getCourseLists(str_replace('-','/',$criteriaLists[2]),$criteriaLists[3],$criteriaLists[4],$criteriaLists[5],$criteriaLists[1],
$criteriaLists[0],0);
              $this->set(compact('courseLists'));
		  } else if(!empty($criteriaLists[1])){
     
				if($criteriaLists[1]=='pre'){
				  	
					$courseLists=$this->_getCourseLists(str_replace('-','/',$criteriaLists[2]),$criteriaLists[3],$criteriaLists[4],$criteriaLists[5],$criteriaLists[1],
$criteriaLists[0],1);
				} else {
					
				 $courseLists=$this->_getCourseLists(str_replace('-','/',$criteriaLists[2]),$criteriaLists[3],$criteriaLists[4],$criteriaLists[5],$criteriaLists[1],
$criteriaLists[0],0);
				}
		}
		 $this->set(compact('courseLists'));

	}
	function _getCourseLists($academic_year,$semester,$program_id,$program_type_id,$college_id=null,$department_id=null, $pre=false){

		 
            $courseLists=array();
			if($pre){
				  $courses=$this->CourseRegistration->PublishedCourse->find('all',array('conditions'=>array('PublishedCourse.academic_year'=>$academic_year,'PublishedCourse.semester'=>$semester,'PublishedCourse.program_id'=>$program_id,'PublishedCourse.program_type_id'=>$program_type_id,
		'PublishedCourse.college_id'=>$college_id,
		'PublishedCourse.department_id is null'),'contain'=>array('Course')));
			 } else if(!empty($department_id)){
				 $courses=$this->CourseRegistration->PublishedCourse->find('all',
								array('conditions'=>array('PublishedCourse.academic_year'=>$academic_year,'PublishedCourse.semester'=>$semester,'PublishedCourse.program_id'=>$program_id,'PublishedCourse.program_type_id'=>$program_type_id,
		'PublishedCourse.department_id'=>$department_id),'contain'=>array('Course')));
			 } else if(!empty($college_id)) {
				$courses=$this->CourseRegistration->PublishedCourse->find('all',array('conditions'=>array('PublishedCourse.academic_year'=>$academic_year,'PublishedCourse.semester'=>$semester,'PublishedCourse.program_id'=>$program_id,'PublishedCourse.program_type_id'=>$program_type_id,
		'PublishedCourse.college_id'=>$college_id),'contain'=>array('Course')));
		   }
          
          foreach($courses as $k=>$v){
			$courseLists[$v['PublishedCourse']['course_id']]=$v['Course']['course_title'].'('.$v['Course']['course_code'].'-'.$v['Course']['credit'].')';
		  }
		return $courseLists;
	}


	function __init_search_course_lists() {
       
		if(!empty($this->request->data['CourseRegistration'])) {
      			 $search_session = $this->request->data['CourseRegistration'];
			   // Session variable 'search_data'
				 $this->Session->write('search_data_list_course', $search_session); 
		} else {
			$search_session = $this->Session->read('search_data_list_course');
		    $this->request->data['CourseRegistration'] = $search_session;
		}
     }

	public function index() {
		$this->__view_registration();
	}

	function __view_registration()  {
          $options = array(
'contain'=>array('Student'=>array('order'=>array('Student.first_name ASC'),
'Department'=>array('id','name'),'Program'=>array('id','name'),'ProgramType'=>array('id','name')),'YearLevel','CourseDrop','PublishedCourse'=>array('Course')),
'order'=>'CourseRegistration.created DESC');

		 if((isset($this->request->data['generateRegisteredList']) && !empty($this->request->data['generateRegisteredList']))){
             $options['group']=array('CourseRegistration.student_id');
		}
        
        if(isset($this->request->data['Search']) && 
!empty($this->request->data['Search'])){
            if($this->role_id == ROLE_STUDENT) {
                  $options['conditions'][]['CourseRegistration.student_id']=$this->student_id;
				if (isset($this->request->data['Search']['semester']) 
			&& !empty($this->request->data['Search']['semester'])) {
					$options['conditions'][]=array('CourseRegistration.semester'=>$this->request->data['Search']['semester']);
				 } 
				if (isset($this->request->data['Search']['academic_year']) 
			&& !empty($this->request->data['Search']['academic_year'])) {
					$options['conditions'][]=array('CourseRegistration.academic_year'=>$this->request->data['Search']['academic_year']);
				 } 
				
			} else {
                // filter by department or college		
				if (isset($this->request->data) && !empty($this->request->data['Search']['department_id'])) {
				 $options['conditions'][]['Student.department_id']=$this->request->data['Search']['department_id'];
				 } 
				 if (isset($this->request->data['Search']['college_id']) 
			&& !empty($this->request->data['Search']['college_id'])) {
					$options['conditions'][]=array('Student.college_id'=>$this->request->data['Search']['college_id'],'Student.department_id is null');
				 } 
				   // filter by program 
				 if (isset($this->request->data['Search']['program_id']) && !empty($this->request->data['Search']['program_id'])) {
						$options['conditions'][]['Student.program_id'] = $this->request->data['Search']['program_id'];
				 }

				// filter by program type
				if (isset($this->request->data['Search']['program_type_id']) && !empty($this->request->data['Search']['program_type_id'])) {
						$options['conditions'][]['Student.program_type_id'] = $this->request->data['Search']['program_type_id'];
				}
               // filter by semester and academic year
               if (isset($this->request->data['Search']['semester']) 
			&& !empty($this->request->data['Search']['semester'])) {
					$options['conditions'][]=array('CourseRegistration.semester'=>$this->request->data['Search']['semester']);
				 } 
				if (isset($this->request->data['Search']['academic_year']) 
			&& !empty($this->request->data['Search']['academic_year'])) {
					$options['conditions'][]=array('CourseRegistration.academic_year'=>$this->request->data['Search']['academic_year']);
				 } 

				 // filter section
               if (isset($this->request->data['Search']['section_id']) 
			&& !empty($this->request->data['Search']['section_id'])) {
					$options['conditions'][]=array('CourseRegistration.section_id'=>$this->request->data['Search']['section_id']);
				 }
                //filter by student number
              if (!empty($this->request->data['Search']['studentnumber'])) {
					  unset($options['conditions']);
					  debug($options);
					  $options['conditions'][]['Student.studentnumber'] = $this->request->data['Search']['studentnumber'];

					if(!empty($this->department_ids)) {
					  $options['conditions'][]['Student.department_id'] = $this->department_ids;
					} else if(!empty($this->college_ids)) {
						 $options['conditions'][]['Student.college_id'] = $this->college_ids;
					} else {
                    $options['conditions'][]['Student.department_id'] = $this->department_id;
					}

					 $options['conditions'][]['Student.studentnumber'] = $this->request->data['Search']['studentnumber'];
		              if (isset($this->request->data['Search']['semester']) && !empty($this->request->data['Search']['semester'])) {
						$options['conditions'][]=array('CourseRegistration.semester'=>$this->request->data['Search']['semester']);
					 } 
					if (isset($this->request->data['Search']['academic_year']) 
				&& !empty($this->request->data['Search']['academic_year'])) {
						$options['conditions'][]=array('CourseRegistration.academic_year'=>$this->request->data['Search']['academic_year']);
					 } 
			   }

           }
		}
		 if(isset($options['conditions']) && !empty($options['conditions']))
		 {
		      $courseRegistrations=$this->CourseRegistration->find('all',$options);  
		 } else {
				$courseRegistrations= array();
		 }
		
		 if (empty($courseRegistrations) && !empty($this->request->data['search'])) {
			 $this->Session->setFlash('<span></span>'.__('No result found for the given search criteria.'),'default',array('class'=>'info-box info-message'));
		 }
		
        //Generate Slip
		if(isset($this->request->data['generateSlip']) && !empty($this->request->data['generateSlip'])) {
		    if(!empty($courseRegistrations)) 
            {
				$student_copies=array();
				foreach($courseRegistrations as $k=>$v){
					$student_copy = ClassRegistry::init('ExamGrade')->getStudentCopy($v['CourseRegistration']['student_id'], $v['CourseRegistration']['academic_year'], $v['CourseRegistration']['semester']);
			
					if(!empty($student_copy['courses'])) {
					$student_copy['University'] = ClassRegistry::init('University')->getStudentUnivrsity($v['CourseRegistration']['student_id']);
					$student_copy['RegistrationDate']=$v['CourseRegistration']['created'];

					$student_copies[$v['CourseRegistration']['student_id']] = $student_copy;
					}
				}
				
				$this->set(compact('student_copies'));
				$this->response->type('application/pdf');
		 		$this->layout = '/pdf/default';
				$this->render('register_slip_pdf');
			    return ;
               
			} else {
				  $this->Session->setFlash('<span></span>'.__('No result found for the given search criteria.'),'default',array('class'=>'info-box info-message'));
			}

		}

		//Generate Registered List
		if(isset($this->request->data['generateRegisteredList']) && !empty($this->request->data['generateRegisteredList'])) {
			 
		if(!empty($courseRegistrations)) {
		   //$this->paginate['limit']=800;
			 $departmentName=$this->CourseRegistration->Student->Department->field('Department.name',array('Department.id'=>$this->request->data['Search']['department_id']));
		
			$programName=$this->CourseRegistration->Student->Program->field('Program.name',array('Program.id'=>$this->request->data['Search']['program_id']));
		
			$programTypeName=$this->CourseRegistration->Student->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Search']['program_type_id']));

			$sectionDetail=$this->CourseRegistration->Section->find('first',
array('conditions'=>array('Section.id'=>$this->request->data['Search']['section_id']),
'contain'=>array('YearLevel')));
            $sectionName=!empty($sectionDetail['YearLevel']['name']) ? 
$sectionDetail['Section']['name'].'('.$sectionDetail['YearLevel']['name'].')' : 
$sectionDetail['Section']['name'].'(1st)';
		     $registrationFormated[$this->request->data['Search']['academic_year'].'~'.$this->request->data['Search']['semester'].'~'.$departmentName.'~'
	.$programName.'~'.$programTypeName.'~'.$sectionName]=$courseRegistrations;


		  $students_in_registration_list_pdf=$registrationFormated;
			$this->set(compact('students_in_registration_list_pdf'));
			$this->response->type('application/pdf');
	 		$this->layout = '/pdf/default';
			$this->render('registeration_list_pdf');
			return ;
		} else {
          $this->Session->setFlash('<span></span>'.__('No result found for the given search criteria.'),'default',array('class'=>'info-box info-message'));
		}
	  

		}

       if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR== $this->Session->read('Auth.User')['Role']['parent_id']) {
	       if(!empty($this->department_ids)) {
	       $departments=$this->CourseRegistration->Student->Department->allDepartmentInCollegeIncludingPre($this->department_ids,null); 
		  } else if (!empty($this->college_ids)) {
		  $departments=$this->CourseRegistration->Student->Department->allDepartmentInCollegeIncludingPre(null, $this->college_ids,$this->onlyPre); 
		 }
	   } else if ($this->role_id == ROLE_COLLEGE) {
	        $departments=$this->CourseRegistration->Student->Department->allDepartmentInCollegeIncludingPre(null, $this->college_id); 
	   } else if ($this->role_id == ROLE_DEPARTMENT) {
          $departments=$this->CourseRegistration->Student->Department->find('list', 
array('conditions'=>array('Department.id'=>$this->department_id))); 
	   }

	   if(isset($this->request->data['Search']['section_id']) && !empty($this->request->data['Search']['section_id'])) {

           if(!empty($this->request->data['Search']['department_id'])){
		   $sections=$this->CourseRegistration->Section->find('list', 
	array('conditions'=>array('Section.program_id'=>$this->request->data['Search']['program_id'],'Section.program_type_id'=>$this->request->data['Search']['program_type_id'],'Section.academicyear'=>$this->request->data['Search']['academic_year'],'Section.department_id'=>$this->request->data['Search']['department_id']))); 
			} else {
              $sections=$this->CourseRegistration->Section->find('list', 
	array('conditions'=>array('Section.program_id'=>$this->request->data['Search']['program_id'],'Section.program_type_id'=>$this->request->data['Search']['program_type_id'],'Section.academicyear'=>$this->request->data['Search']['academic_year'],'Section.college_id'=>$this->request->data['Search']['college_id']))); 
		   }
		   $this->set(compact('sections'));
      }

    

		$programs = $this->CourseRegistration->Student->Program->find('list');
		$programTypes =  $this->CourseRegistration->Student->ProgramType->find('list');
		if($this->role_id == ROLE_STUDENT) {
			$student_ay_s_list = $this->CourseRegistration->ExamGrade->getListOfAyAndSemester($this->student_id);
			$acadamic_years = array();
			foreach($student_ay_s_list as $key => $ay_s) {
				$acadamic_years[$ay_s['academic_year']] = $ay_s['academic_year'];
			}
			$this->set(compact('acadamic_years'));	 
		}
         $this->set(compact('courseRegistrations'));
	    $this->set(compact('departments',
'acyear_array_data','programs','colleges','programTypes'));
		$this->render('view_registration');
	}
//department_id+'~'+college_id+'~'+academic_year+'~'+semester+'~'+program_id+'~'+program_type_id+'d'
	 function get_section_combo($paramaters) {
		    $this->layout = 'ajax';
            $criteriaLists = explode('~',$paramaters);
          debug($criteriaLists);
          
          if(!empty($criteriaLists) && count($criteriaLists)>4)
          {
            $department_college_id=$criteriaLists[0];
            $academicYear=str_replace('-','/',$criteriaLists[1]);
            $program_id=$criteriaLists[2];
			$program_type_id=$criteriaLists[3];
            $type=$criteriaLists[4];
			$options = array(
					'conditions' =>
					array(
						'Section.academicyear'=>$academicYear,
						'Section.program_id'=> $program_id,
						'Section.program_type_id' => $program_type_id
					),
					'contain' => array('Program','ProgramType',
'Department','YearLevel','College'),
                    'order'=>array('Section.year_level_id ASC')
            );
           
			if($type == 'c') {
				$options['conditions'][] = 
					array(
						'Section.college_id' => $department_college_id,
						'Section.department_id IS NULL'
					);
			}
			else {
				$options['conditions']['Section.department_id']
				=$department_college_id;
			}
		     $sections = $this->CourseRegistration->Section->find('all', $options);
		    
           	   $sectionOrganizedByYearLevel=array();
		       foreach($sections as $k=>$v) {
		          if(!empty($v['YearLevel']['name'])) {
		          	$sectionOrganizedByYearLevel[$v['Section']['id']]=$v['Section']
	['name']."(".$v['YearLevel']['name'].")";
				  } else {
		              $sectionOrganizedByYearLevel[$v['Section']['id']]=$v['Section']
	['name']."(1st)";
					debug($v['Section']['name']);
				  }
			   }
		   }
		   $this->set(compact('sectionOrganizedByYearLevel'));
	}

   
    public function manage_missing_registration($student_id)
    {
		$this->layout='ajax';
		$academicYearList=$this->AcademicYear->academicYearInArray(date('Y')-5,date('Y'));
		$studentID=$student_id;
       
        $this->set(compact('academicYearList','studentID'));
	}

    public function update_missing_registration()
    {
   
	      if(!empty($this->request->data)) 
          {
			  $selectedStudentDetail=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id'=>$this->request->data['Student']['selected_student_id']),'recursive'=>-1));
			  $ngGradeDeleationList=array(); 
             //cancel ng 
              if(isset($this->request->data) && !empty($this->request->data['cancelNG'])) 
              {
		       
		        $count=0;
			    foreach($this->request->data['CourseRegistration'] as $key => $student) {
					 
					if($student['gp'] == 1 && !empty($student['id']) && !empty($selectedStudentDetail)) {
		                  $ngGradeDeleationList['ExamGrade'][]=$student['id'];
		               
					}
				 }
				 if(!empty($ngGradeDeleationList['ExamGrade']))
				 {
		          
                    if($this->CourseRegistration->ExamGrade->deleteAll(array('ExamGrade.course_registration_id'=>$ngGradeDeleationList['ExamGrade']),false)) {
						$this->Session->setFlash('<span></span>'.__('You have deleted the NG  successfully.'), 'default', array('class'=>'success-box success-message'));
						 $this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$this->request->data['Student']['selected_student_id']));
				    }
				 } else {
		              $this->Session->setFlash(__('<span></span>The NG could not be deleted to selected student. Please, try again.',true),'default',array('class'=>'error-box error-message'));
		              $this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$this->request->data['Student']['selected_student_id']));
				 }
		      }
			
			 //register missing courses  
            if(isset($this->request->data) && !empty($this->request->data['registerMissingCourse'])) 
            {
		        $registrationLists=array(); 
		        $count=0;
			    foreach($this->request->data['CourseRegistration'] as $key => $student) {
					 
					if($student['gp'] == 1 && !empty($student['published_course_id']) && 
		empty($student['id']) && !empty($selectedStudentDetail)) {
		                  $publishedCourseDetail=$this->CourseRegistration->PublishedCourse->find('first',
	array('conditions'=>array('PublishedCourse.id'=>$student['published_course_id']),
	'contain'=>array()));
		                  $registrationLists['CourseRegistration'][$count]['year_level_id']=$publishedCourseDetail['PublishedCourse']['year_level_id'];
		                  $registrationLists['CourseRegistration'][$count]['section_id']=$publishedCourseDetail['PublishedCourse']['section_id'];
		                  $registrationLists['CourseRegistration'][$count]['semester']=$publishedCourseDetail['PublishedCourse']['semester'];
		                  $registrationLists['CourseRegistration'][$count]['academic_year']=$publishedCourseDetail['PublishedCourse']['academic_year'];
		                  $registrationLists['CourseRegistration'][$count]['student_id']=$selectedStudentDetail['Student']['id'];
						  $registrationLists['CourseRegistration'][$count]['published_course_id']=$student['published_course_id'];
		                  $registrationLists['CourseRegistration'][$count]['created']=$this->AcademicYear->getAcademicYearBegainingDate($publishedCourseDetail['PublishedCourse']['academic_year'],$publishedCourseDetail['PublishedCourse']['semester']);

						 $registrationLists['CourseRegistration'][$count]['modified']=$this->AcademicYear->getAcademicYearBegainingDate($publishedCourseDetail['PublishedCourse']['academic_year'],$publishedCourseDetail['PublishedCourse']['semester']);
		                   
		                $count++;
				 }
			  }

		  	    if(!empty($registrationLists))
				 {
				 debug($registrationLists);
				    if($this->CourseRegistration->saveAll($registrationLists['CourseRegistration'],array('validate'=>false))){
				       $this->Session->setFlash(__('<span></span>Missing course registration  successfully.',true),'default',array('class'=>'success-box success-message'));
		               $this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$this->request->data['Student']['selected_student_id']));
					}
				 } else {
				      $this->Session->setFlash(__('<span></span>The registration could not be added to selected student. Please, try again.',true),'default',array('class'=>'error-box error-message'));
				      $this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$this->request->data['Student']['selected_student_id']));
				 }
		   }
      }
		//$this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$this->request->data['Student']['selected_student_id']));	
	}

	public function getIndividualRegistration($parameters) {
         $this->layout = 'ajax';
	     $courseLists=array();
		 $criteriaLists = explode('~',$parameters); 
         if(!empty($criteriaLists) && count($criteriaLists)>2)
         {
            $academicYear=str_replace('-','/',$criteriaLists[0]);
//$criteriaLists[0];
			$semester=$criteriaLists[1];
			$student=$criteriaLists[2];
			$getStudentSection=$this->CourseRegistration->Section->getStudentSectionInGivenAcademicYear($academicYear,$student);
			$studentDetail=$this->CourseRegistration->Student->find('first',
array('conditions'=>array('Student.id'=>$student),
'contain'=>array('Department','College','Program','ProgramType','Curriculum')));
           $latest_academic_year['academic_year']=$academicYear;
           $latest_academic_year['semester']=$semester;
		   $passed_or_failed=$this->CourseRegistration->Student->StudentExamStatus->get_student_exam_status($student,$latest_academic_year['academic_year']);
		  
		   if (($passed_or_failed==1 || $passed_or_failed==3)) 
           {

             $publishedCourses=$this->CourseRegistration->PublishedCourse->find('all',
array('conditions'=>array('PublishedCourse.semester'=>$semester,
'PublishedCourse.academic_year'=>$academicYear,
'PublishedCourse.section_id'=>$getStudentSection['Section']['id']),'contain'=>array('Course'=>array('Prerequisite','fields'=>array('id','course_title','course_code','credit'),'GradeType'=>array('Grade'=>array('fields'=>array('id','grade')))))));
			debug($publishedCourses);
			  $failedAnyPrerequistie['freq']=0;
             foreach($publishedCourses as $k=>&$vv)
             {
		         $courseRegistration = $this->CourseRegistration->find('first',
array('conditions'=>array('CourseRegistration.student_id'=>$student,$vv['PublishedCourse']['id'],'CourseRegistration.published_course_id'=>$vv['PublishedCourse']['id'])));
				 
                //if(empty($courseRegistration)) {
				         if(!empty($vv['Course']['Prerequisite'])) {
							
								foreach($vv['Course']['Prerequisite'] as $preValue ) { 
									$failed =ClassRegistry::init('CourseDrop')->prequisite_taken($student,$preValue['prerequisite_course_id']);
									debug($failed);
									debug($preValue);
									
									if($failed==0  && $preValue['co_requisite']!=true) {
									   $failedAnyPrerequistie['freq']++;   							
									}
								}
						}
						if($failedAnyPrerequistie['freq']>0){
						  $vv['PublishedCourse']['prerequisiteFailed']=true;
                         $failedAnyPrerequistie['freq']=0;
						} else {
				           $vv['PublishedCourse']['prerequisiteFailed']=0;
						} 

				//} 
                //course registration 
				if(!empty($courseRegistration)) {
                    $approvedGrade =$this->CourseRegistration->ExamGrade->getApprovedGrade($courseRegistration['CourseRegistration']['id'], 1);
                     if(!empty($approvedGrade) && $approvedGrade['grade']=='NG' ){
                          $vv['PublishedCourse']['readOnly']=false;
                          $vv['PublishedCourse']['grade']=$approvedGrade['grade'];
					 } else if(!empty($approvedGrade) && $approvedGrade['grade']!='NG') {
                         $vv['PublishedCourse']['readOnly']=true;
                         $vv['PublishedCourse']['grade']=$approvedGrade['grade'];
					 } else {
                          $vv['PublishedCourse']['readOnly']=false;
					 }
					$vv['PublishedCourse']['course_registration_id']=$courseRegistration['CourseRegistration']['id'];
				} else {
                   $vv['PublishedCourse']['readOnly']=false;
                   $vv['PublishedCourse']['grade']='';
				}
			}
		
		  } else {
			 
                $status="The student academic status is dismissed you can not register for semester '".$latest_academic_year['semester']."/".$latest_academic_year['academic_year']."'. Advisee him/her to apply for readmission";
               $this->set(compact('status'));
		 }
	    }

		$this->set(compact('publishedCourses','studentDetail'));

	}
	
}
