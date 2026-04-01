<?php
class CourseAddsController extends AppController {

    var $name = 'CourseAdds';
    var $menuOptions = array(
                //'parent' => 'courseRegistrations',
                 'parent'=>'registrations',
                 'alias' => array(
                    'index' => 'View Course Adds',
                    'add' => 'Add course for single student',
                    'approve_adds'=>'Approve Students Add Request',
                    'student_add_courses'=>'Add Courses'
                   
            )
                
       );
     //var $components =array('AcademicYear', 'Security');
       var $components =array('AcademicYear');         
   
   //var $components =array('AcademicYear');
    function beforeRender() {

        $acyear_array_data = $this->AcademicYear->acyear_array();
        //To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        foreach($acyear_array_data as $k=>$v){
                if($v==$defaultacademicyear){
                $defaultacademicyear=$k;
                    break;
                }
        }
        if(!empty($this->program_type_id)){
	   		   $program_types=$programTypes =  $this->CourseAdd->Student->ProgramType->find('list',array('conditions'=>
	   		   	array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   		   $program_types=$programTypes=$this->CourseAdd->Student->ProgramType->find('list');
	   }

       if(!empty($this->program_id)){
	   		   $programs=$this->CourseAdd->Student->Program->find('list',array('conditions'=>
	   		   	array('Program.id'=>$this->program_id)));
	   } else{
	   		   $programs=$this->CourseAdd->Student->Program->find('list');
	   }
        $this->set(compact('acyear_array_data','defaultacademicyear','program_types','programs',
        	'programTypes'));
        unset($this->request->data['User']['password']);
	}
	/**
	* After successful test , this before filter will be applied to all controller
	* in our application to make our application more secure, protecting against form modification,
	* CSRF attacks
	*/
	
	function beforeFilter () {
	     parent::beforeFilter();
		 $this->Auth->allow('get_published_add_courses','invalid','search');
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
   
   function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Student'])){
               
                    $search_session = $this->request->data['Student'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data');
        	$this->request->data['Student'] = $search_session;
        } 

    }
   
	function index() {
		//$this->CourseAdd->recursive = 0;
		$this->paginate=array ('limit'=>200,'contain'=>array('PublishedCourse'=>array('Course'),
		'Student'=>array('id','full_name','department_id','program_id',
		'program_type_id'),'YearLevel'=>array('id','name')),
		'order'=>'CourseAdd.created DESC');
		 $options=array();
		 $department_id=array();
	     if ($this->role_id == ROLE_REGISTRAR) {
	                  if (!empty($this->department_ids)) {
	                       $department_id=$this->department_ids;
	                          
		                  $departments=$this->CourseAdd->Student->Department->find('list',
		                  array('conditions'=>array('Department.id'=>$department_id)));
		      
	                  } if (!empty($this->college_ids)) {
	                     $colleges=$this->CourseAdd->Student->College->find('list',
		                  array('conditions'=>array('College.id'=>$this->college_ids)));
		      
	                  }
	                 
	      } else if ($this->role_id == ROLE_DEPARTMENT ) {
	              $department_id=$this->department_id;
	            
		          $departments=$this->CourseAdd->Student->Department->find('list',
		          array('conditions'=>array('Department.id'=>$department_id)));
	      } else if ($this->role_id == ROLE_COLLEGE) {
	             $department_ids = $this->CourseAdd->Student->Department->find('list',
	              array('conditions'=>array('Department.college_id'=>$this->college_id)));
	              $department_id = array_keys($department_ids);
	             $beginning['pre']='Pre/Fresh';
	             $departments=$this->CourseAdd->Student->Department->find(
	             'list',array('conditions'=>array('Department.college_id'=>$this->college_id)));
		      
		        $departments = $beginning+$departments;
	      }
		  
		  $this->__init_search_index();  
		  if ($this->Session->read('search_data_index')) {
		    $this->request->data['viewCourseAdds']=true;
		  }
		 
		  
		  if (!empty($this->request->data) && isset($this->request->data['viewCourseAdds'])) { 
                    		                
		            
		             if (!empty($this->request->data['Search']['program_type_id'])) {
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                              $options[] = array(
                                   
                                    'Student.program_type_id'=>$this->request->data['Search']['program_type_id'],
                                    'Student.department_id'=>$department_id  
                                );
	                                           
	                         } 
	                         
	                        if ($this->role_id == ROLE_DEPARTMENT) {
                                 $options[] = array(
                                    
                                    'Student.program_type_id'=>$this->request->data['Search']['program_type_id'],
                                     'Student.department_id'=>$department_id    
                                 );
	                        }  
	                        
	                       if ($this->role_id == ROLE_COLLEGE) {
                                
                                 
                                 $options[] = array(
                                    
                                     'Student.program_type_id'=>$this->request->data['Search']['program_type_id'],
                                     'Student.college_id'=>$this->college_id   
                                 );
	                        }    
	                }
	                
	                if (!empty($this->request->data['Search']['program_id'])) {
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                              $options[] = array(
                                   
                                    'Student.program_id'=>$this->request->data['Search']['program_id'],
                                    'Student.department_id'=>$department_id  
                                );
	                                           
	                         } 
	                         
	                        if ($this->role_id == ROLE_DEPARTMENT) {
                                 $options[] = array(
                                    
                                    'Student.program_id'=>$this->request->data['Search']['program_id'],
                                     'Student.department_id'=>$department_id    
                                 );
	                        }  
	                         if ($this->role_id == ROLE_COLLEGE) {
                                
                                 
                                 $options[] = array(
                                    
                                    'Student.program_id'=>$this->request->data['Search']['program_id'],
                                     'Student.college_id'=>$this->college_id   
                                 );
	                        }    
	                }
		              if (!empty($this->request->data['Search']['college_id'])) {
	                        if ($this->role_id == ROLE_REGISTRAR) {
	                              
                                    $options[] = array(
                                    
                                       'Student.department_id is null',
                                       'Student.college_id'=>$this->request->data['Search']['college_id']  
                                     );
	                                           
	                         } 
	                         
	                      
	                }
		             if (!empty($this->request->data['Search']['department_id'])) {
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                              $options[] = array(
                                   
                                    'Student.department_id'=>$this->request->data['Search']['department_id'] 
                                );
	                                           
	                         } 
	                         
	                        if ($this->role_id == ROLE_DEPARTMENT) {
                                 $options[] = array(
                                    
                                     'Student.department_id'=>$this->request->data['Search']['department_id']  
                                 );
	                        }  
	                        
	                      if ($this->role_id == ROLE_COLLEGE) {
                                
                                if (strcasecmp($this->request->data['Search']['department_id'],'pre')===0) {
                                    $options[] = array(
                                    
                                       'Student.department_id is null',
                                       'Student.college_id'=>$this->college_id   
                                     );
                                } else {
                                   $options[] = array(
                                    
                                    'Student.department_id'=>$this->request->data['Search']['department_id'],
                                 );
                                }
                                
	                       } 
	                }
	                
	                 if (!empty($this->request->data['Search']['semester'])) {
	                       
	                              $options[] = array(
                                   
                                    'CourseAdd.semester'=>$this->request->data['Search']['semester'],
                                    'Student.department_id'=>$department_id  
                                );

	                }
		            
		             if (!empty($this->request->data['Search']['academic_year'])) {
	                       
	                              $options[] = array(
                                   
                                    'CourseAdd.academic_year'=>$this->request->data['Search']['academic_year'],
                                    'Student.department_id'=>$department_id  
                                );

	                }
	                
		            if ($this->request->data['Search']['rejected']==1 && $this->request->data['Search']['accepted']==0 
	               && $this->request->data['Search']['notprocessed']==0) {
	                         if ($this->role_id == ROLE_DEPARTMENT) {
	                             $options[] = array(
	                               
	                                "CourseAdd.department_approval"=>0,
	                                'Student.department_id'=>$department_id
	                           );         
	                         }
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                              $options[] = array(
	                               
	                                "CourseAdd.registrar_confirmation"=>0,
	                                'Student.department_id'=>$department_id
	                           );         
	                         }
	                              
	                         if ($this->role_id == ROLE_COLLEGE) {
	                           
	                           if (strcasecmp($this->request->data['Search']['department_id'],'pre')===0) {
                                    $options[] = array(
                                        "CourseAdd.department_approval"=>0,
                                       'Student.department_id is null',
                                       'Student.college_id'=>$this->college_id   
                                     );
                                } else {
                                   $options[] = array(
                                     "CourseDrop.department_approval"=>0,
                                    'Student.department_id'=>$department_id
                                 );
                                }
                              
	                        }
	                          
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==0) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                          $options[] = array(
	                               
	                                "CourseAdd.department_approval"=>1,
	                                'Student.department_id'=>$department_id
	                           );         
	                        }
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                           $options[] = array(
	                               
	                                "CourseAdd.registrar_confirmation"=>1,
	                                'Student.department_id'=>$department_id
	                           );      
	                         }
	                    if ($this->role_id == ROLE_COLLEGE) {
	                           
	                           if (strcasecmp($this->request->data['Search']['department_id'],'pre')===0) {
                                    $options[] = array(
                                       "CourseAdd.department_approval"=>1,
                                       'Student.department_id is null',
                                       'Student.college_id'=>$this->college_id   
                                     );
                                } else {
                                   $options[] = array(
                                    "CourseAdd.department_approval"=>1,
                                    'Student.department_id'=>$department_id
                                 );
                                }
                              
	                        
	                   }  
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==1) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                            $options[] = array(
	                               
	                                "CourseAdd.department_approval is null",
	                                'Student.department_id'=>$department_id
	                           );
	                        }   
	                        
	                        if ($this->role_id == ROLE_REGISTRAR) {
	                          $options[] = array(
	                                "CourseAdd.department_approval=1",
	                                "CourseAdd.registrar_confirmation is null",
	                                'Student.department_id'=>$department_id
	                           );
	                        }
	                        
	                     if ($this->role_id == ROLE_COLLEGE) {
	                           
	                           if (strcasecmp($this->request->data['Search']['department_id'],'pre')===0) {
                                    $options[] = array(
                                       'Student.department_id is null',
                                        "CourseAdd.department_approval is null",
                                       'Student.college_id'=>$this->college_id   
                                     );
                                } else {
                                   $options[] = array(
                                     "CourseAdd.department_approval is null",
                                    'Student.department_id'=>$department_id
                                 );
                                }
                              
	                        
	                    }               
	                                      
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==0) {
	                         if ($this->role_id == ROLE_DEPARTMENT) {
	                                
	                            $options[] = array(
	                               
	                                "CourseAdd.department_approval"=>array(0,1),
	                                'Student.department_id'=>$department_id
	                           );                 
	                         }
	                         
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                           $options[] = array(
	                                "CourseAdd.department_approval=1",
	                                "CourseAdd.registrar_confirmation"=>array(0,1),
	                                'Student.department_id'=>$department_id
	                           );       
	                         }  
	                         
	                          if ($this->role_id == ROLE_COLLEGE) {
	                               $options[] = array(
	                               
	                                "CourseAdd.department_approval"=>array(0,1),
	                                'Student.department_id'=>$department_id
	                               );            
	                         }  
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==1) {
	                       if ($this->role_id == ROLE_DEPARTMENT) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array(
	                                 "CourseAdd.department_approval"=>1,
	                                 "CourseAdd.department_approval is null ")
	                           ); 
	                       }
	                       
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                            $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 "CourseAdd.department_approval=1",
	                                 'OR'=>array(
	                                 "CourseAdd.registrar_confirmation"=>1,
	                                 "CourseAdd.registrar_confirmation is null ")
	                           ); 
	                       } 
	                       
	                        if ($this->role_id == ROLE_COLLEGE) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array(
	                                 "CourseAdd.department_approval"=>1,
	                                 "CourseAdd.department_approval is null ")
	                           ); 
	                       }               
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==1) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseAdd.department_approval"=>0,
	                                 "CourseAdd.department_approval is null")
	                           );
	                           
	                       }
	                       
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                            $options[] = array(
	                                 "CourseAdd.department_approval=1",
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseAdd.registrar_confirmation"=>0,
	                                 "CourseAdd.registrar_confirmation is null")
	                           );
	                       }
	                       
	                        if ($this->role_id == ROLE_COLLEGE) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseAdd.department_approval"=>0,
	                                 "CourseAdd.department_approval is null")
	                           );
	                           
	                       }                  
	              }
	              
	      }
	      if ($this->role_id == ROLE_STUDENT) {
	              $options[] = array(
                        "CourseAdd.student_id"=>$this->student_id
			         );
	       } else {
	            if (empty($options)) {
	                $options[] = array(
                        "Student.department_id"=>$department_id
			         );
	            }
	      }
	      if(empty($this->request->data['Search']['program_type_id']) && !empty($this->program_type_id)){
	      	    $options[] = array(
                        "Student.program_type_id"=>$this->program_type_id
                 );
	      }
	      if(empty($this->request->data['Search']['program_id']) && !empty($this->program_id)){
	      	    $options[] = array(
                        "Student.program_id"=>$this->program_id
                 );
	      }

        $courseAdds=$this->paginate($options);
       
	    if (empty($courseAdds)) {
	       $this->Session->setFlash('<span></span>'.__('There is no add courses in the system in the given criteria.'),'default',array('class'=>'info-box info-message'));
	    } else {
	        $this->set('courseAdds',$courseAdds);
	       
	    }
		  $this->set(compact('programs','programTypes','departments'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid course add'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('courseAdd', $this->CourseAdd->read(null, $id));
	}
    function add($id=null) {
        $logged_user_detail = ClassRegistry::init('User')->find('first',array('conditions' =>
                      				array(
                      					'User.id' =>$this->Auth->user('id')
                      				),
                      				'contain' => 
                      				array(
                      					'Staff',
                      					'Student'
                      				))
        );
         // add 
         if($id) {
                 $this->__init_search_index();
                 //check privilage ?
	             $elegible_registrar_responsibility=0;
	             if (!empty($this->department_ids)) {
                    $elegible_registrar_responsibility=$this->CourseAdd->Student->find('count',
                    array('conditions'=>array(
                    	'Student.id'=>$id,
                    	'Student.department_id'=>$this->department_ids,
                    	'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                    	))
                    );
                 } else if (!empty($this->college_ids)) {
                   $elegible_registrar_responsibility=$this->CourseAdd->Student->find('count',
                   array('conditions'=>array('Student.id'=>$id,'Student.college_id'=>$this->college_ids,
                   	'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                   'Student.department_id is null')));         
                    
                 }
                
                 if ($elegible_registrar_responsibility==0) {
                        $this->Session->setFlash('<span></span> You do not have the privilage to add coures for  the selected student. Your action is loggged and reported to the system administrators.','default',array('class'=>'error-box error-message'));
                      
						$details=null;
						
						if (isset ($logged_user_detail['Staff']) && !empty($logged_user_detail['Staff'])) {
						  $details.=$logged_user_detail['Staff'][0]['first_name'].' '.
						  $logged_user_detail['Staff'][0]['middle_name'].' '.
						  $logged_user_detail['Staff'][0]['last_name'].' ('.
						  $logged_user_detail['User']['username'].')';
						} else if (isset ($logged_user_detail['Student']) && 
						!empty($logged_user_detail['Student'])) {
						$details.=$logged_user_detail['Student'][0]['first_name'].' '.
						$logged_user_detail['Student'][0]['middle_name'].' '.
						$logged_user_detail['Student'][0]['last_name'].' ('.
						$logged_user_detail['User']['username'].')';
						
						}
				       
						ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$details.'</u> is trying to add courses for students without assigned privilage. Please give appropriate warning.'); 
                        //$this->redirect('add');
	                 
                }
           if (!empty($this->request->data['Search']['academicyear'])) {
              $current_academic_year=$this->request->data['Search']['academicyear'] ;
               $semester=$this->request->data['Search']['semester'];
           } else {
              $current_academic_year= $this->AcademicYear->current_academicyear(); 
               $latestAcSemester=  ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($id,
           $current_academic_year,1);
       
               $semester=$latestAcSemester['semester'];
           
           }    
           $student_section_exam_status=$this->CourseAdd->Student->get_student_section($id,
	           $current_academic_year);
	           
	           $getRegistrationDeadLine=false;
	            
	           if(empty($student_section_exam_status)) {
	             
	             $this->Session->setFlash('<span></span>'.__('You are sectionless. Please advice department.'),'default',array('class'=>'warning-box warning-message'));     
	             $this->redirect('/');
	            
	            }
	           
	            if (!empty($this->department_ids)) {
	             $year_level_id = $this->CourseAdd->YearLevel->field('name',
	              array('id'=>$student_section_exam_status['Section']['year_level_id']));
	              
	            $getRegistrationDeadLine =  ClassRegistry::init('CourseRegistration')->AcademicCalendar->
	            check_add_date_end($current_academic_year,$semester,
	            $student_section_exam_status['StudentBasicInfo']['department_id'],$year_level_id);
	             
	          
	            } else if (!empty($this->college_ids)) {
	                  
	                  $getRegistrationDeadLine =  ClassRegistry::init('CourseRegistration')->AcademicCalendar->
	                  check_add_date_end($current_academic_year,$semester,
	                  $student_section_exam_status['StudentBasicInfo']['college_id'],0);
	               
	            }
	            if ($getRegistrationDeadLine==0 || $getRegistrationDeadLine==1) {
	              
	            } else {
	                    $add_start_date=$getRegistrationDeadLine;
	                    $getRegistrationDeadLine=0;        
	            }
	            
	          if (!$getRegistrationDeadLine) {
	                if(isset($add_start_date) && !empty($add_start_date)) {
	                    $this->Session->setFlash('<span></span>'.__('Course add start at '.
	                    $add_start_date.' Please come back when course add starts.', true),
	                    'default',array('class'=>'info-box info-message'));
	                    $this->redirect(array('controller'=>'courseAdds','action'=>'add'));  
	                } else {
	                     $this->Session->setFlash('<span></span>'.
	                     __('Course add dead line is passed for students but as registrar you can 
	                     maintain student adds. Beware that student should have to register for 
	                     the semester and academic year before adding courses.', true),'default',
	                     array('class'=>'info-box info-message'));
	                }
	                 
	          }
	        
	        $student_section = $this->CourseAdd->Student->student_academic_detail($id,$current_academic_year);  
	         if (empty($student_section_exam_status['Section']['year_level_id'])) {
	              $published_detail=array('academic_year'=>$current_academic_year,
	              'semester'=>$semester,'student_id'=>$id,'year_level_id'=>0);
	         
	         } else {
	             $published_detail=array('academic_year'=>$current_academic_year,
	            'semester'=>$semester,'student_id'=>$id, 'year_level_id'=>
	            $student_section_exam_status['Section']['year_level_id']);
	           
	         }
	         
	          if (!empty($student_section_exam_status['Section'])) {
	               
	               if (!empty($student_section_exam_status['StudentBasicInfo']['department_id'])) {
	               $ownDepartmentPublishedForAdd=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array('PublishedCourse.semester'=>$semester,
	               'PublishedCourse.department_id'=>$student_section_exam_status['StudentBasicInfo']['department_id'],
	               'PublishedCourse.section_id'=>$student_section_exam_status['Section']['id'],
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               'PublishedCourse.add'=>1),'contain'=>array('Course')));
	               } else if (empty($student_section_exam_status['StudentBasicInfo']['department_id'])) {
	                  $ownDepartmentPublishedForAdd=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array('PublishedCourse.semester'=>$semester,
	               'PublishedCourse.department_id is null ',
	                'PublishedCourse.college_id'=>$student_section_exam_status['College']['id'],
	               'PublishedCourse.section_id'=>$student_section_exam_status['Section']['id'],
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               'PublishedCourse.add'=>1),'contain'=>array('Course')));
	      
	               }
	               
	               $pub_own_as_add_courses = array();
	               $count=0;
	               foreach ($ownDepartmentPublishedForAdd as $ownIndex=>$ownValue) {
	                   $already_added = $this->CourseAdd->find('count',array('conditions'=>
	               array('CourseAdd.student_id'=>$id,
	               'CourseAdd.published_course_id'=>$ownValue['PublishedCourse']['id'])));
	                   if ($already_added>0) {
	                      $pub_own_as_add_courses[$count]=$ownValue;
	                      $pub_own_as_add_courses[$count]['already_added']=1;
	                   } else {
	                     $pub_own_as_add_courses[$count]=$ownValue;
	                      $pub_own_as_add_courses[$count]['already_added']=0;
	                   }         
	               }
	               $ownDepartmentPublishedForAdd=$pub_own_as_add_courses;
	              
	               $this->set(compact('ownDepartmentPublishedForAdd'));
              } else {
                 $this->Session->setFlash('<span></span>'.__('The student is sectionless, 
                 S/he should be assigned to section by department. Please advice department.', true),
                 'default',array('class'=>'warning-box warning-message'));     
              }
              
              $this->set(compact('student_section','student_section_exam_status'));
              
	          if (!empty($this->request->data['CourseAdd'])) 
	          {
	                
	           
	             $selected=array_sum($this->request->data['CourseAdd']['add']);
			     
			     if ($selected>0) {
			
			            $selected_courses_for_add=$this->request->data['CourseAdd']['add'];
			            unset($this->request->data['CourseAdd']['add']);
			            unset($this->request->data['Student']['department_id']);
			           
			            $add_selected_to_registration=array();
                       		
			            foreach ($selected_courses_for_add as $k=>$v) {
			                    if ($v==1) {
			                        $published_detail['published_course_id']=$k;
			                        $add_selected_to_registration['CourseAdd'][]=
			                        $published_detail['published_course_id'];
			                    } 
			             }
			            $this->request->data['CourseAdd']=$add_selected_to_registration['CourseAdd'];
			                  
			            //check for duplicate entry
			            $already_added_courses=array();
			            $selected_courses_add=array();
			            $count=0;
			            
			            foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
			                
			                    $check=$this->CourseAdd->find('count',
			                    array('conditions'=>array('CourseAdd.published_course_id'=>$cdv,
			                    'CourseAdd.student_id'=>$id),'recursive'=>-1));
			                  
			                    // already added, unset it
			                    if ($check>0) {
			                       $already_added_courses[]=$cdv;
			                   
			                    } else {
			                           $is_mass_add = $this->CourseAdd->PublishedCourse->field('add',
			                           array('id'=>$cdv));
			                           
			                           $selected_courses_add['CourseAdd'][$count]['published_course_id']=$cdv;
			                           if($is_mass_add==1) {
			                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
			                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
			                            }
			                            
			                    		$selected_courses_add['CourseAdd'][$count]['student_id']=
			                    		$id;
			                    		$selected_courses_add['CourseAdd'][$count]['semester']=$semester;
			                    		$selected_courses_add['CourseAdd'][$count]['academic_year']=
			                    		$current_academic_year;
			                    		if (empty($student_section['Section'][0]['year_level_id'])
			                    		|| $student_section['Section'][0]['year_level_id']==0) {
			                    		   $selected_courses_add['CourseAdd'][$count]['year_level_id']=0;
			                    		} else {
			                    		    $selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
			                    		}
			                    		//$selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
			                    }
			                    $count++;
			            }
			            
			           if (count($already_added_courses)==count($this->request->data['CourseAdd'])) {
			                  $this->Session->setFlash('<span></span>'.
			                  __('All the selected courses has already  added. 
			                  You do not need to add it again.', true),'default',
			                  array('class'=>'info-box info-message'));
			                  
		                     //$this->redirect(array('action'=>'index'));
		                     
			            } else {
			                 // unset($this->request->data);
			                  $this->request->data['CourseAdd']=$selected_courses_add;
			            }
			            $this->request->data['CourseAdd']=$this->request->data['CourseAdd']['CourseAdd'];
	                 if (!empty($this->request->data['CourseAdd'])){ 
	                 	  //debug($this->request->data);
	                 	  //debug($this->request->data['CourseAdd']);
	                    if ($this->CourseAdd->saveAll($this->request->data['CourseAdd'],
					    array('validate'=>'first'))) {
							     $this->Session->setFlash('<span></span>'.__('The course add has been sent to department successfully for approval.'), 'default',array('class'=>'success-box success-message'));
							  // dont forget to add to registration table after approval
							  
					    } else {
						     $this->Session->setFlash('<span></span>'.__('The course add could not be send. 
						     Please, try again.', true),'default',
						     array('class'=>'error-box error-message'));
					    }
					}
				} else {
				    $this->Session->setFlash('<span></span>'.__('Please select atleast one course you want to add.'),'default',array('class'=>'error-box error-message'));
				}
	                    //debug($this->request->data);
	       }
        }  
         
       if (!empty($this->request->data) && isset($this->request->data['add'])) {
       
           if (!empty($this->request->data['Search']['academicyear'])) {
              $current_academic_year=$this->request->data['Search']['academicyear'] ;
               $semester=$this->request->data['Search']['semester'];
           } else {
              $current_academic_year= $this->AcademicYear->current_academicyear(); 
               $latestAcSemester=  ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($id,
           $current_academic_year,1);
       
               $semester=$latestAcSemester['semester'];
           
           }    
           debug($this->request->data);
		   
		   $selected=array_sum($this->request->data['CourseAdd']['add']);
		   $student_section = $this->CourseAdd->Student->student_academic_detail(
		   $this->request->data['Student']['id'],$current_academic_year); 
		  
	       
		   if ($selected>0 ) 
		   {
			
			         $selected_courses_for_add=$this->request->data['CourseAdd']['add'];
			         unset($this->request->data['CourseAdd']['add']);
			         unset($this->request->data['Student']['department_id']);
			         
			         $add_selected_to_registration=array();
                       		
			          foreach ($selected_courses_for_add as $k=>$v) {
		                    if ($v==1) {
		                        $published_detail['published_course_id']=$k;
		                        $add_selected_to_registration['CourseAdd'][]=
		                        $published_detail['published_course_id'];
		                    } 
			          }
		             $this->request->data['CourseAdd']=$add_selected_to_registration['CourseAdd'];
		             
		             $already_added_courses=array();
		             $selected_courses_add=array();
		             $count=0;
			            
			          foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
			                
	                    $check=$this->CourseAdd->find('count',array('conditions'=>
	                    array('CourseAdd.published_course_id'=>$cdv,'CourseAdd.student_id'=>
	                    $this->request->data['Student']['id']),'recursive'=>-1));
	                  
	                    // already added, unset it
	                    if ($check>0) {
	                       $already_added_courses[]=$cdv;
	                   
	                    } else {
	                           $is_mass_add = $this->CourseAdd->PublishedCourse->field('add',
	                           array('id'=>$cdv));
	                           
	                           $selected_courses_add['CourseAdd'][$count]['published_course_id']=$cdv;
	                           if($is_mass_add==1) {
	                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
	                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
	                            } else {
	                              $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
	                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
	                           $selected_courses_add['CourseAdd'][$count]['egistrar_confirmed_by']=$this->Auth->user('id');
	                           
	                            
	                            }
	                            
	                    		$selected_courses_add['CourseAdd'][$count]['student_id']=
	                    		$this->request->data['Student']['id'];
	                    		$selected_courses_add['CourseAdd'][$count]['semester']=$semester;
	                    		$selected_courses_add['CourseAdd'][$count]['academic_year']=$current_academic_year;
	                    		if (empty($student_section['Section'][0]['year_level_id'])) {
	                    		  $selected_courses_add['CourseAdd'][$count]['year_level_id']=0;
	                    		} else {
	                    		  $selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
	                    		}
	                    		
	                    }
			            $count++;
			        }
			            
		           if (count($already_added_courses)==
		           count($this->request->data['CourseAdd'])) {
		                  $this->Session->setFlash('<span></span>'.__('All the selected courses has already  added. 
		                  You do not need to add it again.', true),
		                  'default',array('class'=>'info-box info-message'));
		                  
	                     //$this->redirect(array('action'=>'index'));
	                     
		           } else {
		                 // unset($this->request->data);
		                  $this->request->data['CourseAdd']=$selected_courses_add;
		           }
		           
			       $this->request->data['CourseAdd']=$this->request->data['CourseAdd']['CourseAdd'];
	               if (!empty($this->request->data['CourseAdd'])){ 
	                   if ($this->CourseAdd->saveAll($this->request->data['CourseAdd'],
					    array('validate'=>'first'))) {
							 
							     $this->Session->setFlash('<span></span>'.
							     __('The course add has been successful.'), 'default',
							     array('class'=>'success-box success-message')); 
							  
					    } else {
						     $this->Session->setFlash('<span></span>'.__('The course add could not be send. 
						     Please, try again.', true),'default',
						     array('class'=>'error-box error-message'));
					    }
				  }
		      } else {
				    $this->Session->setFlash('<span></span>'.__('Please select atleast 
				    one course you want to add.', true),'default',
				    array('class'=>'error-box error-message'));
		      }
	             
		}
        
        
        if (!empty($this->request->data) && isset($this->request->data['continue']))  {
                 $this->__init_search_index();
	             $options = array();
	             $options['conditions'][] = 'Student.id NOT IN (SELECT student_id FROM graduate_lists)';
		         $options['conditions'][] = 'Student.id NOT IN (SELECT student_id FROM senate_lists)';
		         
		        
		         /*
		          if (!empty($this->request->data['Search']['semester'])) {
	                $options['conditions'][] = 'Student.id NOT IN (SELECT student_id FROM senate_lists)';
	             } 
	             */
	             
	             if (!empty($this->request->data['Search']['academicyear'])) {
	                $options['conditions'][] = 'Student.id  IN (SELECT student_id FROM students_sections 
	                where section_id IN (select id from sections where academicyear like "'.
	                $this->request->data['Search']['academicyear'].'" ))';
	             } 
	           
	             if (!empty($this->request->data['Search']['studentnumber'])) {
	               $options['conditions']['Student.studentnumber'] = $this->request->data['Search']['studentnumber'];
	             } 
	             if (!empty($this->request->data['Search']['department_id']) && empty($this->request->data['Search']['studentnumber'])) {
	               $options['conditions']['Student.department_id'] = $this->request->data['Search']['department_id'];
	             }
	             
	             if (!empty($this->request->data['Search']['college_id'])) {
	               $options['conditions']['Student.college_id'] = $this->request->data['Search']['college_id'];
	               $options['conditions'][] = 'Student.department_id IS NULL';
	             }
	             
	             $options['contain'] = array(
	                            'CourseDrop',
				                'Program'=>array(
				                    'fields'=>array('id','name')
				                
				                 ),
				                'ProgramType'=>array(
				                    'fields'=>array('id','name')
				                 ),
				                'Department'=>array(
				                'fields'=>array('id','name')
				            )
				                
				 );
				 
		    $options['fields'] = array('Student.id', 'Student.full_name', 
		    'Student.first_name', 'Student.middle_name', 'Student.last_name', 'Student.studentnumber',
		     'Student.admissionyear', 'Student.gender','Student.full_name');
		   
		    $options['order'] = array('Student.full_name');
		    //debug($options);
		    $student_lists = $this->CourseAdd->PublishedCourse->Course->Student->find('all', $options);
		
	      
	        $this->set(compact('student_lists','collegess'));
	   
	    }
        if (!empty($this->college_ids)) {
		   $colleges = $this->CourseAdd->PublishedCourse->College->find('list',array('conditions'=>
		   array('College.id'=>$this->college_ids)));
		   //$colleges = $this->CourseAdd->PublishedCourse->College->find('list');
		}
	    
	     if (!empty($this->department_ids)) {
		        $departments= $this->CourseAdd->PublishedCourse->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
		      
		
		 }
		$collegess = $this->CourseAdd->PublishedCourse->College->find('list',
		array('order'=>array('College.name ASC')));
		$this->set(compact('yearLevels', 'departments','colleges','collegess'));
    
    
    
    }
    /*
	function add($id=null) {
		 $logged_user_detail = ClassRegistry::init('User')->find('first',
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
	     if($id) {
	     	     //check privilage ?
	             $elegible_registrar_responsibility=0;
	             if (!empty($this->department_ids)) {
                    $elegible_registrar_responsibility=$this->CourseAdd->Student->find('count',array('conditions'=>array('Student.id'=>$id,'Student.department_id'=>$this->department_ids)));
                 } else if (!empty($this->college_ids)) {
                   $elegible_registrar_responsibility=$this->CourseAdd->Student->find('count',
                   array('conditions'=>array('Student.id'=>$id,'Student.college_id'=>$this->college_ids,'Student.department_id is null')));         
                    
                 }
                
                 if ($elegible_registrar_responsibility==0) {
                        $this->Session->setFlash('<span></span> You do not have the privilage to add coures for  the selected student. Your action is loggged and reported to the system administrators.','default',array('class'=>'error-box error-message'));
                      
						$details=null;
						
						if (isset ($logged_user_detail['Staff']) && !empty($logged_user_detail['Staff'])) {
						  $details.=$logged_user_detail['Staff'][0]['first_name'].' '.
						  $logged_user_detail['Staff'][0]['middle_name'].' '.
						  $logged_user_detail['Staff'][0]['last_name'].' ('.
						  $logged_user_detail['User']['username'].')';
						} else if (isset ($logged_user_detail['Student']) && 
						!empty($logged_user_detail['Student'])) {
						$details.=$logged_user_detail['Student'][0]['first_name'].' '.
						$logged_user_detail['Student'][0]['middle_name'].' '.
						$logged_user_detail['Student'][0]['last_name'].' ('.
						$logged_user_detail['User']['username'].')';
						
						}
				       
						ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$details.'</u> is trying to add courses for students without assigned privilage. Please give appropriate warning.'); 
                        //$this->redirect('add');
	                 
                 }
                 
	       
	       $current_academic_year= $this->AcademicYear->current_academicyear();
	       $student_section_exam_status=$this->CourseAdd->Student->get_student_section(
	       $id,$current_academic_year);
	       
	       $getRegistrationDeadLine=false;
	     
	     $latestAcSemester=  ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear(
	   $id,$current_academic_year,1);
	   
	       $semester=$latestAcSemester['semester'];
	        
	        if(empty($student_section_exam_status)){
	         $this->Session->setFlash('<span></span>'.__('You are sectionless. Please advice department.'),'default',array('class'=>'warning-box warning-message'));     
	         $this->redirect('/');
	        
	        }
	        if (!empty($this->department_ids)) {
	         $year_level_id = $this->CourseAdd->YearLevel->field('name',
	          array('id'=>$student_section_exam_status['Section']['year_level_id']));
	          
	        $getRegistrationDeadLine =  ClassRegistry::init('CourseRegistration')->AcademicCalendar->check_add_date_end($current_academic_year,$semester,$student_section_exam_status['StudentBasicInfo']['department_id'],$year_level_id);
	         
	      
	        } else if (!empty($this->college_ids)) {
	              
	              $getRegistrationDeadLine =  ClassRegistry::init('CourseRegistration')->AcademicCalendar->check_add_date_end($current_academic_year,$semester,$student_section_exam_status['StudentBasicInfo']['college_id'],0);
	              
	             // $getRegistrationDeadLine=true;
	        }
	        if ($getRegistrationDeadLine==0 || $getRegistrationDeadLine==1) {
	          
	        } else {
	                $add_start_date=$getRegistrationDeadLine;
	                $getRegistrationDeadLine=0;
	                
	        }  
	              
	       if (!$getRegistrationDeadLine) {
	            if(isset($add_start_date) && !empty($add_start_date)) {
	                $this->Session->setFlash('<span></span>'.__('Course add start at '.$add_start_date
	                .' Please come back when course add starts.', true),'default',
	                array('class'=>'info-box info-message'));
	              $this->redirect(array('controller'=>'courseAdds','action'=>'add'));  
	            } else {
	              $this->Session->setFlash('<span></span>'.__('Course add dead line is passed for students but as registrar you can maintain student adds. Beware that student should have to register for the semester and academic year before adding courses.'),'default',array('class'=>'info-box info-message'));
	            }
	           
	            
	            
			  // $this->redirect(array('controller'=>'courseRegistrations','action'=>'index'));    
	        }
	        
	        $student_section = $this->CourseAdd->Student->
			  student_academic_detail($id,
	        $current_academic_year);  
	         if (empty($student_section_exam_status['Section']['year_level_id'])) {
	              $published_detail=array('academic_year'=>$current_academic_year,
	            'semester'=>$semester,'student_id'=>$id,
	            'year_level_id'=>0);
	         
	         } else {
	                 $published_detail=array('academic_year'=>$current_academic_year,
	            'semester'=>$semester,'student_id'=>$id,
	            'year_level_id'=>$student_section_exam_status['Section']['year_level_id']);
	           
	         }
	         
	            if (!empty($student_section_exam_status['Section'])) {
	               
	               if (!empty($student_section_exam_status['StudentBasicInfo']['department_id'])) {
	               $ownDepartmentPublishedForAdd=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array('PublishedCourse.semester'=>$semester,
	               'PublishedCourse.department_id'=>$student_section_exam_status['StudentBasicInfo']['department_id'],
	               'PublishedCourse.section_id'=>$student_section_exam_status['Section']['id'],
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               'PublishedCourse.add'=>1),'contain'=>array('Course')));
	               } else if (empty($student_section_exam_status['StudentBasicInfo']['department_id'])) {
	                  $ownDepartmentPublishedForAdd=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array('PublishedCourse.semester'=>$semester,
	               'PublishedCourse.department_id is null ',
	                'PublishedCourse.college_id'=>$student_section_exam_status['College']['id'],
	               'PublishedCourse.section_id'=>$student_section_exam_status['Section']['id'],
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               'PublishedCourse.add'=>1),'contain'=>array('Course')));
	      
	               }
	               
	               $pub_own_as_add_courses = array();
	               $count=0;
	               foreach ($ownDepartmentPublishedForAdd as $ownIndex=>$ownValue) {
	                   $already_added = $this->CourseAdd->find('count',array('conditions'=>
	               array('CourseAdd.student_id'=>$id,
	               'CourseAdd.published_course_id'=>$ownValue['PublishedCourse']['id'])));
	                   if ($already_added>0) {
	                      $pub_own_as_add_courses[$count]=$ownValue;
	                      $pub_own_as_add_courses[$count]['already_added']=1;
	                   } else {
	                     $pub_own_as_add_courses[$count]=$ownValue;
	                      $pub_own_as_add_courses[$count]['already_added']=0;
	                   }         
	               }
	               $ownDepartmentPublishedForAdd=$pub_own_as_add_courses;
	              
	               $this->set(compact('ownDepartmentPublishedForAdd'));
	            } else {
	                 $this->Session->setFlash('<span></span>'.__('The student is sectionless, S/he should be assigned to section by department. Please advice department.'),'default',array('class'=>'warning-box warning-message'));     
	            }
	            $this->set(compact('student_section','student_section_exam_status'));
	            if (!empty($this->request->data)) {
	                
	             $selected=array_sum($this->request->data['CourseAdd']['add']);
			     
			     if ($selected>0) {
			
			            $selected_courses_for_add=$this->request->data['CourseAdd']['add'];
			            unset($this->request->data['CourseAdd']['add']);
			            unset($this->request->data['Student']['department_id']);
			           
			            $add_selected_to_registration=array();
                       		
			            foreach ($selected_courses_for_add as $k=>$v) {
			                    if ($v==1) {
			                        $published_detail['published_course_id']=$k;
			                        $add_selected_to_registration['CourseAdd'][]=$published_detail['published_course_id'];
			                    } 
			             }
			            $this->request->data['CourseAdd']=$add_selected_to_registration['CourseAdd'];
			                        //debug($this->request->data);
			                        //check for duplicate entry
			            $already_added_courses=array();
			            $selected_courses_add=array();
			            $count=0;
			            
			            foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
			                
			                    $check=$this->CourseAdd->find('count',
			                    array('conditions'=>array('CourseAdd.published_course_id'=>$cdv,
			                    'CourseAdd.student_id'=>$id),'recursive'=>-1));
			                  
			                    // already added, unset it
			                    if ($check>0) {
			                       $already_added_courses[]=$cdv;
			                   
			                    } else {
			                           $is_mass_add = $this->CourseAdd->PublishedCourse->field('add',
			                           array('id'=>$cdv));
			                           
			                           $selected_courses_add['CourseAdd'][$count]['published_course_id']=$cdv;
			                           if($is_mass_add==1) {
			                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
			                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
			                            }
			                            
			                    		$selected_courses_add['CourseAdd'][$count]['student_id']=
			                    		$id;
			                    		$selected_courses_add['CourseAdd'][$count]['semester']=$semester;
			                    		$selected_courses_add['CourseAdd'][$count]['academic_year']=$current_academic_year;
			                    		if (empty($student_section['Section'][0]['year_level_id'])
			                    		|| $student_section['Section'][0]['year_level_id']==0) {
			                    		   $selected_courses_add['CourseAdd'][$count]['year_level_id']=0;
			                    		} else {
			                    		    $selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
			                    		}
			                    		//$selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
			                    }
			                    $count++;
			            }
			            
			           if (count($already_added_courses)==count($this->request->data['CourseAdd'])) {
			                  $this->Session->setFlash('<span></span>'.__('All the selected courses has already  added. You do not need to add it again.'),'default',array('class'=>'info-box info-message'));
			                  
		                     //$this->redirect(array('action'=>'index'));
		                     
			            } else {
			                 // unset($this->request->data);
			                  $this->request->data['CourseAdd']=$selected_courses_add;
			            }
			            $this->request->data['CourseAdd']=$this->request->data['CourseAdd']['CourseAdd'];
	                 if (!empty($this->request->data['CourseAdd'])){ 
	                 	  //debug($this->request->data);
	                 	  //debug($this->request->data['CourseAdd']);
	                    if ($this->CourseAdd->saveAll($this->request->data['CourseAdd'],
					    array('validate'=>'first'))) {
							     $this->Session->setFlash('<span></span>'.__('The course add has been sent to department successfully for approval.'), 'default',array('class'=>'success-box success-message'));
							  // dont forget to add to registration table after approval
							  
					    } else {
						     $this->Session->setFlash('<span></span>'.__('The course add could not be send. Please, try again.'),
								     'default',array('class'=>'error-box error-message'));
					    }
					}
				} else {
				    $this->Session->setFlash('<span></span>'.__('Please select atleast one course you want to add.'),
								     'default',array('class'=>'error-box error-message'));
				}
	                    //debug($this->request->data);
	       }
	        
	        
	        
	    }
	   
		if (!empty($this->request->data) && isset($this->request->data['add'])) {
		          $current_academic_year= $this->AcademicYear->current_academicyear();
		         $selected=array_sum($this->request->data['CourseAdd']['add']);
		           $student_section = $this->CourseAdd->Student->
			  student_academic_detail($this->request->data['Student']['id'],
	        $current_academic_year); 
			     $latestAcSemester=  ClassRegistry::init('CourseRegistration')
			     ->getLastestStudentSemesterAndAcademicYear(
			     $this->request->data['Student']['id'],$current_academic_year,
			     1);
			     
	            $semester=$latestAcSemester['semester'];
	       
			     if ($selected>0) {
			
			            $selected_courses_for_add=$this->request->data['CourseAdd']['add'];
			            unset($this->request->data['CourseAdd']['add']);
			            unset($this->request->data['Student']['department_id']);
			           
			            $add_selected_to_registration=array();
                       		
			            foreach ($selected_courses_for_add as $k=>$v) {
			                    if ($v==1) {
			                        $published_detail['published_course_id']=$k;
			                        $add_selected_to_registration['CourseAdd'][]=$published_detail['published_course_id'];
			                    } 
			             }
			            $this->request->data['CourseAdd']=$add_selected_to_registration['CourseAdd'];
			                        //debug($this->request->data);
			                        //check for duplicate entry
			            $already_added_courses=array();
			            $selected_courses_add=array();
			            $count=0;
			            
			            foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
			                
			                    $check=$this->CourseAdd->find('count',array('conditions'=>array('CourseAdd.published_course_id'=>$cdv,'CourseAdd.student_id'=>$this->request->data['Student']['id']),'recursive'=>-1));
			                  
			                    // already added, unset it
			                    if ($check>0) {
			                       $already_added_courses[]=$cdv;
			                   
			                    } else {
			                           $is_mass_add = $this->CourseAdd->PublishedCourse->field('add',
			                           array('id'=>$cdv));
			                           
			                           $selected_courses_add['CourseAdd'][$count]['published_course_id']=$cdv;
			                           if($is_mass_add==1) {
			                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
			                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
			                            } else {
			                              $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
			                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
			                           $selected_courses_add['CourseAdd'][$count]['egistrar_confirmed_by']=$this->Auth->user('id');
			                           
			                            
			                            }
			                            
			                    		$selected_courses_add['CourseAdd'][$count]['student_id']=
			                    		$this->request->data['Student']['id'];
			                    		$selected_courses_add['CourseAdd'][$count]['semester']=$semester;
			                    		$selected_courses_add['CourseAdd'][$count]['academic_year']=$current_academic_year;
			                    		if (empty($student_section['Section'][0]['year_level_id'])) {
			                    		  $selected_courses_add['CourseAdd'][$count]['year_level_id']=0;
			                    		} else {
			                    		  $selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
			                    		}
			                    		
			                    }
			                    $count++;
			            }
			            
			           if (count($already_added_courses)==count($this->request->data['CourseAdd'])) {
			                  $this->Session->setFlash('<span></span>'.__('All the selected courses has already  added. You do not need to add it again.'),'default',array('class'=>'info-box info-message'));
			                  
		                     //$this->redirect(array('action'=>'index'));
		                     
			            } else {
			                 // unset($this->request->data);
			                  $this->request->data['CourseAdd']=$selected_courses_add;
			            }
			            $this->request->data['CourseAdd']=$this->request->data['CourseAdd']['CourseAdd'];
	                 if (!empty($this->request->data['CourseAdd'])){ 
	                   if ($this->CourseAdd->saveAll($this->request->data['CourseAdd'],
					    array('validate'=>'first'))) {
							 
							     $this->Session->setFlash('<span></span>'.__('The course add has been successful.'), 'default',array('class'=>'success-box success-message')); 
							  
					    } else {
						     $this->Session->setFlash('<span></span>'.__('The course add could not be send. Please, try again.'),
								     'default',array('class'=>'error-box error-message'));
					    }
					}
				} else {
				    $this->Session->setFlash('<span></span>'.__('Please select atleast one course you want to add.'),
								     'default',array('class'=>'error-box error-message'));
				}
	             
		}
		
	   if (!empty($this->request->data) && isset($this->request->data['continue'])) {
	            
	             if (!empty($this->request->data['Search']['studentnumber'])) {
                       $college_ids=array(); 
                       $department_ids=array();
	                   if (!empty($this->request->data['Search']['college_id'])) {
	                       $college_ids=$this->request->data['Student']['college_id'];
	                   } else if (!empty($this->college_ids)) {
	                       $college_ids=$this->college_ids;
	                   } else if (!empty($this->request->data['Search']['department_id'])) {
	                      $department_ids=$this->request->data['Search']['department_id'];
	                   } else if (!empty($this->department_ids)) {
	                      $department_ids=$this->department_ids;
	                   }
	                   
	                   if (!empty($college_ids)) {
	                         $student_lists=$this->CourseAdd->PublishedCourse->
	                         Course->Student->find('all',
                             array('conditions'=>array(
                             'Student.department_id is null',
                             'Student.college_id'=>$college_ids,
                             'Student.studentnumber'=>trim($this->request->data['Search']['studentnumber']),
                             'Student.id NOT IN (select student_id from graduate_lists)'),
				                'contain'=>array('CourseDrop',
				                'Program'=>array('fields'=>array('id','name')),
				                'ProgramType'=>array('fields'=>array('id','name')),
				                'Department'=>array('fields'=>array('id','name'))),
				                'fields'=>array('Student.id','Student.studentnumber',
				                'Student.full_name'),'order'=>'Student.full_name')); 
	             
	                   } else if (!empty($department_ids)) {
	                       $student_lists=$this->CourseAdd->PublishedCourse->
	                         Course->Student->find('all',
                             array('conditions'=>array(
                             'Student.department_id'=>$department_ids,
                            
                             'Student.studentnumber'=>trim($this->request->data['Search']['studentnumber']),
                             'Student.id NOT IN (select student_id from graduate_lists)'),
				                'contain'=>array('CourseDrop',
				                'Program'=>array('fields'=>array('id','name')),
				                'ProgramType'=>array('fields'=>array('id','name')),
				                'Department'=>array('fields'=>array('id','name'))),
				                'fields'=>array('Student.id','Student.studentnumber',
				                'Student.full_name'),'order'=>'Student.full_name')); 
	                       
	                   }
	                      
	               } elseif (!empty($this->request->data['Search']['department_id'])) {
	                   $student_lists=$this->CourseAdd->PublishedCourse->Course->Student->find('all',
                             array('conditions'=>array('Student.department_id'=>$this->request->data['Search']['department_id'],'Student.id NOT IN (select student_id from graduate_lists)'),
				                'contain'=>array('CourseDrop','Program'=>array('fields'=>array('id','name')),'ProgramType'=>array('fields'=>array('id','name')),'Department'=>array('fields'=>array('id','name'))),'fields'=>array('Student.id','Student.studentnumber','Student.full_name'),'order'=>'Student.full_name')); 
	                
	                }  elseif (!empty($this->request->data['Search']['college_id'])) {
	                   $student_lists=$this->CourseAdd->PublishedCourse->Course->Student->find('all',
                             array('conditions'=>array(
                             'Student.department_id is null',
                             'Student.college_id'=>$this->request->data['Search']['college_id'],
                             'Student.id NOT IN (select student_id from graduate_lists)'),
				                'contain'=>array('CourseDrop','Program'=>array('fields'=>array('id','name')),'ProgramType'=>array('fields'=>array('id','name')),'Department'=>array('fields'=>array('id','name'))),'fields'=>array('Student.id','Student.studentnumber','Student.full_name'),'order'=>'Student.full_name')); 
	                    
	                }
	                
	        
	      
	        $this->set(compact('student_lists','collegess'));
	   
	   }
	   if (empty($this->request->data)) {
                   
                $current_academic_year= $this->AcademicYear->current_academicyear();
			    $semester=ClassRegistry::init('CourseRegistration')->latestCourseRegistrationSemester(
			   $current_academic_year);
				
	             $publishedCourses=$this->CourseAdd->PublishedCourse->find('all',
			 array('conditions'=>array(
			 'PublishedCourse.academic_year'=>$current_academic_year,
			 'PublishedCourse.add'=>1,
			 'PublishedCourse.department_id'=>$this->department_ids,
			 'PublishedCourse.semester'=>$semester),
			 'contain'=>array('Course'=>array('Prerequisite',
			 'fields'=>array('Course.id','Course.course_title','Course.course_code','Course.course_code_title')))));
			
			 $this->set(compact('publishedCourses'));
		
				
			
        }
		if (!empty($this->college_ids)) {
		   $colleges = $this->CourseAdd->PublishedCourse->College->find('list',array('conditions'=>
		   array('College.id'=>$this->college_ids)));
		   //$colleges = $this->CourseAdd->PublishedCourse->College->find('list');
		}
	    
	     if (!empty($this->department_ids)) {
		        $departments= $this->CourseAdd->PublishedCourse->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
		        //$departments = array();
		
		 }
		$collegess = $this->CourseAdd->PublishedCourse->College->find('list');
		$this->set(compact('yearLevels', 'departments','colleges','collegess'));
	}
    */
	
	public function approve_adds() {
	     $flag=false;
	     if (!empty($this->request->data) && isset($this->request->data['approverejectadd'])) {
	     	foreach ($this->request->data['CourseAdd'] as $k=>&$v) {
	               	    $maxLoad=$this->CourseAdd->Student->calculateStudentLoad(
			                  $v['student_id'],$v['semester'], $v['academic_year']);
	               	    //todo read maximum load for course add from general settings
	               	    $allowedMaximum=ClassRegistry::init('AcademicCalendar')->maximumCreditPerSemester($v['student_id']);
	               	    if($maxLoad < $allowedMaximum ){

			                    if ($this->role_id == ROLE_DEPARTMENT || $this->role_id == ROLE_COLLEGE ) {
			                         if ($v['department_approval'] == '') {
			                            unset($this->request->data['CourseAdd'][$k]);
			                         } else {
			                             $v['department_approved_by']=$this->Auth->user('full_name');
			                         }
			                    } else if ($this->role_id == ROLE_REGISTRAR) {
			                          if ($v['registrar_confirmation'] == '') {
			                            unset($this->request->data['CourseAdd'][$k]);
			                         } else {
			                             $v['registrar_confirmed_by']=$this->Auth->user('full_name');
			                         }
			                    }
	                   } else {
	                   		unset($this->request->data['CourseAdd'][$k]);
	                   }
	                   
	                }
	                $this->set($this->request->data);
	               
	                if (!empty($this->request->data['CourseAdd'])) {
					    if ($this->CourseAdd->saveAll($this->request->data['CourseAdd'],
					    array('validate'=>'first'))) {
					        if ($this->role_id == ROLE_DEPARTMENT) {
					          
							     $this->Session->setFlash('<span></span>'.__('The course add has been approved and send to registrar for confirmation.'), 'default',array('class'=>'success-box success-message'));
					        } else if ($this->role_id == ROLE_REGISTRAR ) {
					        
					           
							     $this->Session->setFlash('<span></span>'.__('The course add has been confirmed.'), 'default',array('class'=>'success-box success-message'));
					        }
							     $flag=true;
							
							   // $this->redirect(array('action'=>'approve_drops'));
					    } else {
						     $this->Session->setFlash('<span></span>'.__('The course add approve could not be saved. Please, try again.'),
								     'default',array('class'=>'error-box error-message'));
					    }
					
					} else {
					    if ($this->role_id == ROLE_DEPARTMENT) {
					    $this->Session->setFlash('<span></span>'.__('The course add approval could not be saved. You have not approved any of the listed requests.'),
								     'default',array('class'=>'error-box error-message'));
					    } else if ($this->role_id == ROLE_REGISTRAR) {
					       $this->Session->setFlash('<span></span>'.__('The course add confirmation  could not be saved. You have not confirmed any of the listed requests.'),
								     'default',array('class'=>'error-box error-message'));
					    }
					}
	            
	     }
	        //read from session 
	     // Function to load/save search criteria.
               
        if ($this->Session->read('search_data')) {
                       $this->request->data['getaddsection']=true;
                       $this->request->data['Student']=$this->Session->read('search_data');
                       $this->set('hide_search',true);
                      
        } 
        
	     if (!empty($this->request->data) && isset($this->request->data['getaddsection'])) {
			
			$everythingfine=false;
			switch($this->request->data) {
			       
			        case empty($this->request->data['Student']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester you want to approve add requests.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        
			         case empty($this->request->data['Student']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to approve course add request.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Student']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to approve course add.'),'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			if ($everythingfine) {
			    
			        $section_organized_published_course=array();
			        $department_id=null;
			        
			        if (!empty($this->request->data['Student']['department_id'])) {
			            $department_id=$this->request->data['Student']['department_id'];
			            
			        } else {
			            $department_id=$this->department_id;
			        }
			        
			        $program_type_id=$this->AcademicYear->equivalent_program_type($this->request->data['Student']['program_type_id']);
				  
			        if (!empty($this->request->data['Student']['year_level_id'])) {     
			        $sections=$this->CourseAdd->Student->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$department_id,
			        'Section.year_level_id'=>$this->request->data['Student']['year_level_id'],'Section.program_id'=>$this->request->data['Student']['program_id'],'Section.program_type_id'=>$program_type_id,
			        'Section.archive'=>0,
			        )));
			        } else {
			          $sections=$this->CourseAdd->Student->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$department_id,'Section.program_id'=>$this->request->data['Student']['program_id'],'Section.program_type_id'=>$program_type_id,
			        'Section.archive'=>0,
			        )));
			        
			        }
			       
			        // query according their roles
			        $this->CourseAdd->Student->bindModel(array('hasMany'=>array('StudentsSection')));
			        if ($this->role_id == ROLE_REGISTRAR) {
			        
			        $courseAdds = $this->CourseAdd->find('all',array('conditions'=>array(
			        'Student.department_id'=>$this->request->data['Student']['department_id'],
			      
			        'Student.program_id'=>$this->request->data['Student']['program_id'],
			        'Student.program_type_id'=>$program_type_id,
			        'CourseAdd.semester'=>$this->request->data['Student']['semester'],
			        'CourseAdd.academic_year like'=>$this->request->data['Student']['academic_year'].'%',
			        'CourseAdd.department_approval=1',
			        'CourseAdd.registrar_confirmed_by is null',
			        'Student.id NOT IN (select student_id from graduate_lists)'),
			        'contain'=>array('PublishedCourse'=>array('Course'=>array(
			        'Prerequisite',
			        'fields'=>array('credit','id','course_detail_hours','course_title',
			        'course_code')),'fields'=>array('PublishedCourse.id')),
			        'Student'=>array(
			              
			              'StudentsSection'=>array('conditions'=>array('StudentsSection.archive=0')),
			              'CourseRegistration'=>array(
			                   'ExamGrade',
			                   'PublishedCourse'=>array('Course'=>array('Prerequisite','fields'=>array('credit','id','course_detail_hours','course_title',
			        'course_code')),'fields'=>array('PublishedCourse.id')),
			                   'conditions'=>array(
			                     
			                      'CourseRegistration.semester'=>$this->request->data['Student']['semester'],
			                      'CourseRegistration.academic_year like'=>
			                      $this->request->data['Student']['academic_year'].'%'
			              ),
			              'fields'=>array('id','published_course_id')
			            )
			                     ,'fields'=>array('id','full_name')
			                )
			             )
			          )
			        );
			        
			        
			     
			        } else {
			        //Invistage reassigment of variable while there is a containable after find all \
			        // which we expect to be override but distrbuing the code.
			       //$courseAdds = $this->CourseAdd->find('all');
			        //debug($courseAdds);
			     
			       if (!empty($this->request->data['Student']['year_level_id'])) {
			            $year_level_id=$this->request->data['Student']['year_level_id'];
			       } else {
			            $year_level_id = $this->CourseAdd->YearLevel->find('list',
			            array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
			       }
			     
			        $courseAdds = $this->CourseAdd->find('all',array('conditions'=>array(
			        'Student.department_id'=>$department_id,
			        'CourseAdd.year_level_id'=>$year_level_id,
			        'Student.program_id'=>$this->request->data['Student']['program_id'],
			        'Student.program_type_id'=>$program_type_id,
			        'CourseAdd.semester'=>$this->request->data['Student']['semester'],
			        'CourseAdd.academic_year like'=>$this->request->data['Student']['academic_year'].'%',
			        
			        "OR"=>array('CourseAdd.department_approved_by is null',
			        'CourseAdd.department_approved_by'=>array('')),
			        'Student.id NOT IN (select student_id from graduate_lists)'),
			        'contain'=>array('PublishedCourse'=>array('Course'=>array(
			        'Prerequisite',
			        'fields'=>array('credit','id','course_detail_hours','course_title',
			        'course_code')),'fields'=>array('PublishedCourse.id')),
			        'Student'=>array(
			              
			              'StudentsSection'=>array('conditions'=>array('StudentsSection.archive=0')),
			              'CourseRegistration'=>array(
			                   'ExamGrade',
			                   'PublishedCourse'=>array('Course'=>array('Prerequisite','fields'=>array('credit','id','course_detail_hours','course_title',
			        'course_code')),'fields'=>array('PublishedCourse.id')),
			                   'conditions'=>array(
			                     
			                      'CourseRegistration.semester'=>$this->request->data['Student']['semester'],
			                      'CourseRegistration.academic_year like'=>
			                      $this->request->data['Student']['academic_year'].'%'
			              ),
			              'fields'=>array('id','published_course_id')
			            )
			                     ,'fields'=>array('id','full_name')
			                )
			             )
			          )
			        );
			        
			        
			      
			      }
			      
			        if (empty($courseAdds)) {
			             if ($this->role_id == ROLE_REGISTRAR) {
			              $this->Session->setFlash('<span></span> '.__('No add request  needs confirmation in the given  criteria.'),'default',array('class'=>'info-box info-message'));  
			            } else if ($this->role_id == ROLE_DEPARTMENT) {
			                $this->Session->setFlash('<span></span> '.__('No add request needs approval in the given criteria.'),'default',array('class'=>'info-box info-message'));
			                //$this->redirect(array'')
			            }
			        
			        } else {
			             $this->__init_search();
			            
			             foreach ($courseAdds as $pk=>&$pv) {
			                
			                if (array_key_exists(
			                $pv['Student']['StudentsSection'][0]['section_id']
			                ,$sections)) {
			                  
			                  $pv['Student']['max_load']=$this->CourseAdd->Student->calculateStudentLoad(
			                  $pv['Student']['id'],$this->request->data['Student']['semester'], $this->request->data['Student']['academic_year']);
			                 
			                  $section_organized_published_course[$pv['Student']['StudentsSection'][0]['section_id']][]=$pv;
			                }
			                
			           }
			          
			           
			           //$section_organized_published_course=$this->CourseAdd->reformatApprovalRequest($courseAdds);
			           $this->set('hide_search',true);
			           $this->set('coursesss',$section_organized_published_course);
			           $this->set(compact('sections'));
			        
			        }  
			      
			        $program_name=$this->CourseAdd->Student->Program->field('Program.name',array('Program.id'=>$this->request->data['Student']['program_id']));
			        $program_type_name=$this->CourseAdd->Student->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Student']['program_type_id']));
			        $academic_year=$this->request->data['Student']['academic_year'];
			        $semester=$this->request->data['Student']['semester'];
			        $department_name=$this->CourseAdd->Student->Department->field('Department.name',array('Department.id'=>$department_id));
			       
			        $this->set(compact('sections','year_level_id','program_name','program_type_name',
			     'academic_year','semester','department_name'));
			
		   }
	   }
	  
	   if ($this->role_id == ROLE_REGISTRAR) {
	       $department_ids=array();
	       $college_ids = array();
	       
	       if (!empty($this->department_ids)) {
	        $departments= $this->CourseAdd->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.id'=>$this->department_ids))); 
		    } else if (!empty($this->college_ids)) {
		       $departments= $this->CourseAdd->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.college_id'=>$this->college_ids))); 
		    }
		
	   } else if($this->role_id == ROLE_COLLEGE) {
            	 $departments= $this->CourseAdd->PublishedCourse->Department->find('list',
            	        array('conditions'=>array('Department.college_id'=>$this->college_id)));	   
	            $courseAdds=$this->CourseAdd->courseAddRequestWaitingApproval($this->department_ids);  
	            
	            
	            
	             $courseAdds=$this->CourseAdd->courseAddRequestWaitingApproval(null,0,$this->college_id,1);
	              $this->set('coursesss',$this->CourseAdd->reformatApprovalRequest(
			 $courseAdds,
			 null,$this->AcademicYear->current_academicyear(),$this->college_id));
	            
	   } 	
	    if ($this->role_id == ROLE_REGISTRAR) {
	     
		    $yearLevels=$this->CourseAdd->YearLevel->distinct_year_level();
		    $this->set(compact('yearLevels'));
		    
			$courseAdds=$this->CourseAdd->courseAddRequestWaitingApproval($this->department_ids,1,null,1,$this->program_id,
			$this->program_type_id);
			
			
			if (empty($courseAdds) && !$flag) {
			    $this->Session->setFlash('<span></span> '.__('No add request requests in the system that needs confirmation.'),'default',array('class'=>'info-box info-message'));  
			} else {
			 $this->set('coursesss',$this->CourseAdd->reformatApprovalRequest($courseAdds,
			 $this->department_ids,$this->AcademicYear->current_academicyear()));
			}      
		    
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		     $courseAdds=$this->CourseAdd->courseAddRequestWaitingApproval($this->department_id,2);  
		    
			if (empty($courseAdds) && !$flag) {
			    $this->Session->setFlash('<span></span> '.__('No add request in the system that needs approval.'),'default',array('class'=>'info-box info-message'));  
			} else {
			 $this->set('coursesss',$this->CourseAdd->reformatApprovalRequest(
			 $courseAdds,
			 $this->department_id,$this->AcademicYear->current_academicyear()));
			}      
		     $yearLevels = $this->CourseAdd->YearLevel->find('list',array('conditions'=>array(
		     'YearLevel.department_id'=>$this->department_id),'fields'=>array('id','name')));
		      $this->set(compact('yearLevels'));
		} else {
            $yearLevels = $this->CourseAdd->YearLevel->find('list');
            $this->set(compact('yearLevels'));
		
		}
	   
		$programTypes=$this->CourseAdd->PublishedCourse->ProgramType->find('list');
		$programs=$this->CourseAdd->PublishedCourse->Program->find('list');
	    $this->set(compact('departments','programTypes','programs'));
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for course add'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->CourseAdd->delete($id)) {
			$this->Session->setFlash(__('Course add deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Course add was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
	/*
	function mass_add () {
	  
	    //get list of students and registered courses 
	    if (!empty($this->request->data) && isset($this->request->data['continue'])) {
	        
	       	$everythingfine=false;
		    switch($this->request->data) {
		    
			        case empty($this->request->data['Student']['department_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select department you want to add courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['academic_year']) :
			         $this->Session->setFlash('<span></span> '.__('Please select academic year you  want to add  courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			          case empty($this->request->data['Student']['year_level_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select year level you  want to add  courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to add courses for mass students. Please, try again.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to add courses for mass students. Please, try again.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			        
			         default:
			         $everythingfine=true;
			                
		    }
	       // everthing is selected, reterive from the data list of published coures for the selected criteria
	      if ($everythingfine) {
	         $this->__init_search();
	         $program_type_id=$this->AcademicYear->equivalent_program_type(
	         $this->request->data['Student']['program_type_id']);
	         
	         //debug($this->request->data['Student']['semester']);
	         $published_courses=$this->CourseAdd->PublishedCourse->find('all',
	         array('fields'=>array('id','section_id','semester','academic_year','year_level_id'),
	         'conditions'=>array('PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
	         'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
	         'PublishedCourse.program_type_id'=>$program_type_id,
	         'PublishedCourse.add'=>1,
	         'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
	         'PublishedCourse.academic_year like '=>$this->request->data['Student']['academic_year'].'%'
	         ),
	         'contain'=>array('Course'=>array('id','course_title','course_code','lecture_hours',
	         'tutorial_hours','credit'))));
	         //'PublishedCourse.id NOT IN (select published_course_id from course_adds where published_course_id is not null)
	         
	         $program=$this->CourseAdd->PublishedCourse->Program->field('name',array('id'=>$this->request->data['Student']['program_id']));
	         $programType=$this->CourseAdd->PublishedCourse->ProgramType->field('name',array('id'=>$this->request->data['Student']['program_type_id']));
	        if(empty($published_courses)) {
	              $this->Session->setFlash('<span></span>'.__('There is no published courses 
	              who need mass add for the selected criteria.', true),
	              'default',array('class'=>'error-box error-message'));
	        } else {
	             $section_ids=array();
	             $published_course_ids = array();
	             foreach ($published_courses as $pkk=>$pvv) {
	              if ($this->CourseAdd->ExamGrade->
	              is_grade_submitted($pvv['PublishedCourse']['id'])==0) {
	                   $section_ids[]=$pvv['PublishedCourse']['section_id'];
	                   $published_course_ids[]=$pvv['PublishedCourse']['id'];
	               }
	             }
	            $published_courses=$this->CourseAdd->PublishedCourse->find('all',
	         array('fields'=>array('id','section_id','semester','academic_year','year_level_id'),
	         'conditions'=>array('PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
	         'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
	         'PublishedCourse.add'=>1,
	         'PublishedCourse.section_id'=>$section_ids,
	         'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
	         'PublishedCourse.academic_year like '=>$this->request->data['Student']['academic_year'].'%'
	         ),
	         'contain'=>array('Course'=>array('id','course_title','course_code','lecture_hours',
	         'tutorial_hours','credit'))));
	         
	         
	             if(!empty($section_ids)) {
	           
	              $list_of_students_in_active_section=$this->CourseAdd->PublishedCourse->Section->StudentsSection->find('all',
	              array('conditions'=>array('StudentsSection.section_id'=>$section_ids,
	              'StudentsSection.archive'=>0)));
	             
	              $student_index=array();
	              $student_section_index = array();
	              foreach($list_of_students_in_active_section as $index=>$student){
	                    $course_add=$this->CourseAdd->find('count',array('conditions'=>
	                    array('CourseAdd.student_id'=>$student['StudentsSection']['student_id'],
	                    'CourseAdd.published_course_id'=>$published_course_ids)));
	                    if ($course_add==0) {
	                        $student_index[]=$student['StudentsSection']['student_id'];
	                        $student_section_index[$student['StudentsSection']['student_id']]=$student['StudentsSection']['section_id'];
	                    }
	              }
	             
	              $students=$this->CourseAdd->Student->find('all',
	              array('conditions'=>array('Student.department_id'=>$this->request->data['Student']['department_id'],
	              'Student.id'=>$student_index,'Student.program_type_id'=>$program_type_id,'Student.program_id'=>$this->request->data['Student']['program_id'],
	              'Student.id NOT IN (select student_id from graduate_lists)'),'fields'=>array('id','studentnumber','full_name'),'contain'=>array()));
	              
	              $sections=$this->CourseAdd->Student->Section->find('list',array('conditions'=>array('Section.id'=>$section_ids)));
	              //list of students organized by section.
	              $section_organized_students=array();
                    foreach ($section_ids as $id=>$section_id) {
                     
                          foreach($students as $st_index=>$studentdetail){
                                   
                                  if(in_array($studentdetail['Student']['id'],
                                  $student_index)){
                                    if ($section_id == $student_section_index[$studentdetail['Student']['id']]) {      
                                        $section_organized_students[$section_id][]=
                                        $studentdetail['Student'];
                                    }
                                }
                          }         
                     
                   }
	             
	            }
	            
	            if (empty($section_organized_students)) {
		        $this->Session->setFlash('<span></span>'.__('There is no section who need mass add for the selected criteria.'),'default',array('class'=>'error-box error-message'));
		        } else {
		        
		        
		        }
	            $this->set(compact('section_organized_students','published_courses','sections',
	            
	            'program','programType'));
	            
	          
	        }
	        
	      } 
	    }
	     
	      // drop the selected courses
	    if (!empty($this->request->data) && isset($this->request->data['massadd'])) {
	          
	           //check for duplicate entry
	                $already_added_courses=array();
	                $selected_courses_add=array();
	                unset($this->request->data['Student']);
	                $count=0;
	                foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
	                       
	                        $check=$this->CourseAdd->find('count',array('conditions'=>$cdv,'recursive'=>-1));
	                      
	                        // already added, unset it
	                        if ($check>0) {
	                           $already_added_courses[]=$cdv['published_course_id'];
	                       
	                        } else {
	                            $selected_courses_add['CourseAdd'][$count]=$cdv;
	                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
	                            $selected_courses_add['CourseAdd'][$count]['reason']='Published as add';
	                            $selected_courses_add['CourseAdd'][$count]['department_approved_by']='Published as add';
	                            $selected_courses_add['CourseAdd'][$count]['registrar_confirmed_by']=$this->Auth->user('id');
	                            $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
	                            $count++;
	                        }
	                }
	                
		           if (count($already_added_courses)==count($this->request->data['CourseAdd'])) {
		                  $this->Session->setFlash('<span></span>'.__('All the selected courses has already  added for the selected sections. You do not need to add it again'),'default',array('class'=>'error-box error-message'));
	                     $this->redirect(array('action'=>'index'));
		            } else {
		                  unset($this->request->data);
		                  $this->request->data=$already_added_courses;
		            }
			       //saveAll
			       $this->set($this->request->data);
			    
			           if ($this->CourseAdd->saveAll($selected_courses_add['CourseAdd'],
			           array('validate'=>'first'))) {
				                $this->Session->setFlash('<span></span>'.__('The course add has been saved'),'default',
				                array('class'=>'success-box success-message'));
				                $this->Session->delete('search_data');
				                // save to course registration table
				              
				                $this->redirect(array('action' => 'index'));
			           } else {
				                $this->Session->setFlash('<span></span>'.__('The course add could not be saved. Please, try again.'),
				                'default',array('class'=>'error-box error-message'));
			           }
	        
	    }
	    
	     if ($this->role_id == ROLE_REGISTRAR) {
	        $year_level_find=$this->CourseAdd->YearLevel->find('all',
		   array('fields'=>array('DISTINCT YearLevel.name','YearLevel.id'),
		  'order'=>'YearLevel.name asc','group'=>'YearLevel.name','recursive'=>-1));
		    $extract=Set::extract('/YearLevel/name', $year_level_find);
		    $another=Set::extract('/YearLevel/id',$year_level_find);
		    $combined=array_combine($another, $extract);
		    $yearLevels=$combined;
		    $this->set(compact('yearLevels'));
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		     $yearLevels = $this->CourseAdd->YearLevel->find('list',array('conditions'=>array(
		     'YearLevel.department_id'=>$this->department_id)));
		      $this->set(compact('yearLevels'));
		} else {
            $yearLevels = $this->CourseAdd->YearLevel->find('list');
            $this->set(compact('yearLevels'));
		
		}
        if (!empty($this->department_ids)) {
        $departments= $this->CourseAdd->PublishedCourse->Department->find('list',
        array('conditions'=>array(
		'Department.id'=>$this->department_ids)));
		$this->set(compact('departments'));  
		} else if (!empty($this->college_ids)) {
		  $colleges= $this->CourseAdd->PublishedCourse->College->find('list',
        array('conditions'=>array(
		'College.id'=>$this->college_ids)));
		$this->set(compact('colleges'));
		}
		$programTypes=$this->CourseAdd->PublishedCourse->ProgramType->find('list');
		$programs=$this->CourseAdd->PublishedCourse->Program->find('list');
	    $this->set(compact('departments','programTypes','programs'));
	}
	*/
	
	/**
	*add courses via student 
	* student_add_courses
	*/
	function student_add_courses() {
	      
	       $current_academic_year= $this->AcademicYear->current_academicyear();
	       $student_section_exam_status=$this->CourseAdd->Student->get_student_section(
	       $this->student_id,$current_academic_year);
	       $studentDetails=$this->CourseAdd->Student->find('first',array('conditions'=>array('Student.id'=>$this->student_id),'recursive'=>-1));
	       $getRegistrationDeadLine=false;$latestAcSemester=ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($this->student_id,$current_academic_year,1);
            $semester=$latestAcSemester['semester']; 
                     
	        if(empty($student_section_exam_status)){
	         $this->Session->setFlash('<span></span>'.__('You are sectionless. Please advice department.'),'default',array('class'=>'warning-box warning-message'));     
	         $this->redirect('/');
	        
	        }
	        if (!empty($this->department_id)) {
	         $year_level_id = $this->CourseAdd->YearLevel->field('name',
	          array('id'=>$student_section_exam_status['Section']['year_level_id']));
	          
	        $getRegistrationDeadLine =  ClassRegistry::init('CourseRegistration')->AcademicCalendar->check_add_date_end($current_academic_year,$semester,$this->department_id,$year_level_id,$studentDetails['Student']['program_id'],$studentDetails['Student']['program_type_id']);
	         
	        
	        } else if (!empty($this->college_id)) {
	         
	          $getRegistrationDeadLine =  ClassRegistry::init('CourseRegistration')->AcademicCalendar->check_add_date_end($current_academic_year,$semester,$this->college_id,0,$studentDetails['Student']['program_id'],$studentDetails['Student']['program_type_id']);
	        
	          
	        }
	        
	          if ($getRegistrationDeadLine==0 || $getRegistrationDeadLine==1) {
	          
	          } else {
	                $add_start_date=$getRegistrationDeadLine;
	                $getRegistrationDeadLine=0;
	                
	          } 
	       if (!$getRegistrationDeadLine) {
	            if (isset($add_start_date) && !empty($add_start_date)) {
	              $this->Session->setFlash('<span></span>'.__('Course add start date is '.$add_start_date.'. You can not add courses now.'),'default',array('class'=>'info-box info-message'));
	            } else {
	              $this->Session->setFlash('<span></span>'.__('Course Add deadline passed. You can not add courses.'),'default',array('class'=>'info-box info-message'));
	            }
	            
			   $this->redirect(array('controller'=>'courseRegistrations','action'=>'index'));    
	        } else {
	             $student_section = $this->CourseAdd->Student->
			  student_academic_detail($this->student_id,
	        $current_academic_year);  
	            
	            $published_detail=array('academic_year'=>$current_academic_year,
	            'semester'=>$semester,'student_id'=>$this->student_id,
	            'year_level_id'=>$student_section_exam_status['Section']['year_level_id']);
	            
	            if (!empty( $student_section_exam_status['Section'])) {
	              
	               $ownDepartmentPublishedForAdd=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array(
	               'PublishedCourse.semester'=>$semester,
	               'PublishedCourse.department_id'=>$this->department_id,
	               'PublishedCourse.section_id'=>$student_section_exam_status['Section']['id'],
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               'PublishedCourse.add'=>1),
	               'contain'=>array('Course')));
	              
	               $pub_own_as_add_courses = array();
	               $count=0;
	               foreach ($ownDepartmentPublishedForAdd as $ownIndex=>$ownValue) {
	                   $already_added = $this->CourseAdd->find('count',array('conditions'=>
	               array('CourseAdd.student_id'=>$this->student_id,
	               'CourseAdd.published_course_id'=>$ownValue['PublishedCourse']['id'])));
	                   if ($already_added>0) {
	                      $pub_own_as_add_courses[$count]=$ownValue;
	                      $pub_own_as_add_courses[$count]['already_added']=1;
	                   } else {
	                     $pub_own_as_add_courses[$count]=$ownValue;
	                      $pub_own_as_add_courses[$count]['already_added']=0;
	                   }         
	               }
	               $ownDepartmentPublishedForAdd=$pub_own_as_add_courses;
	              
	               $this->set(compact('ownDepartmentPublishedForAdd'));
	            } else {
	                 $this->Session->setFlash('<span></span>'.__('You are sectionless. Please advice department.'),'default',array('class'=>'warning-box warning-message'));     
	            }
	            $this->set(compact('student_section','student_section_exam_status'));
	            if (!empty($this->request->data)) {
	                
	             $selected=array_sum($this->request->data['CourseAdd']['add']);
			     
			     if ($selected>0) {
			
			            $selected_courses_for_add=$this->request->data['CourseAdd']['add'];
			            unset($this->request->data['CourseAdd']['add']);
			            unset($this->request->data['Student']['department_id']);
			           
			            $add_selected_to_registration=array();
                       		
			            foreach ($selected_courses_for_add 
			            as $k=>$v) {
			                    if ($v==1) {
			                        $published_detail['published_course_id']=$k;
			                        $add_selected_to_registration['CourseAdd'][]=$published_detail['published_course_id'];
			                    } 
			             }
			            $this->request->data['CourseAdd']=$add_selected_to_registration['CourseAdd'];
			                        //debug($this->request->data);
			                        //check for duplicate entry
			            $already_added_courses=array();
			            $selected_courses_add=array();
			            $count=0;
			            $currentLoadToAdd=0;
			            foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
			                $courseDetailCredit=$this->CourseAdd->find('first',array('conditions'=>array('CourseAdd.published_course_id'=>$cdv),'contain'=>array('Course')));
			                    $check=$this->CourseAdd->find('count',array('conditions'=>array('CourseAdd.published_course_id'=>$cdv,'CourseAdd.student_id'=>$this->student_id),'recursive'=>-1));
			                  
			                    // already added, unset it
			                    if ($check>0) {
			                       $already_added_courses[]=$cdv;
			                   
			                    } else {
			                          $currentLoadToAdd+=$courseDetailCredit['Course']['credit'];
			                  
			                           $is_mass_add = $this->CourseAdd->PublishedCourse->field('add',
			                           array('id'=>$cdv));
			                           
			                           $selected_courses_add['CourseAdd'][$count]['published_course_id']=$cdv;
			                           if($is_mass_add==1) {
			                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
			                           $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
			                            }
			                            
			                    		$selected_courses_add['CourseAdd'][$count]['student_id']=$this->student_id;
			                    		$selected_courses_add['CourseAdd'][$count]['semester']=$semester;
			                    		$selected_courses_add['CourseAdd'][$count]['academic_year']=$current_academic_year;
			                    		if (empty($student_section['Section'][0]['year_level_id'])
			                    		|| $student_section['Section'][0]['year_level_id']==0) {
			                    		   $selected_courses_add['CourseAdd'][$count]['year_level_id']=0;
			                    		} else {
			                    		    $selected_courses_add['CourseAdd'][$count]['year_level_id']=$student_section['Section'][0]['year_level_id'];
			                    		}
			                    		
			                    }
			                    $count++;
			            }
			            
			           if (count($already_added_courses)==count($this->request->data['CourseAdd'])) {
			                  $this->Session->setFlash('<span></span>'.__('All the selected courses has already  added. You do not need to add it again.'),'default',array('class'=>'info-box info-message'));
			                  
		                     $this->redirect(array('action'=>'index'));
		                     
			            } else {
			                 // unset($this->request->data);
			                  $this->request->data['CourseAdd']=$selected_courses_add;
			            }
			            $this->request->data['CourseAdd']=$this->request->data['CourseAdd']['CourseAdd'];
	                 if (!empty($this->request->data['CourseAdd'])){ 
	                 	  //debug($this->request->data);
	                 	//check if the add request is more than the allowed course per semester
	                    $maxLoad=($currentLoadToAdd+$this->CourseAdd->Student->calculateStudentLoad($this->student_id,$semester, $current_academic_year));	
	                    $allowedMaximum=ClassRegistry::init('AcademicCalendar')->maximumCreditPerSemester($this->student_id);
	                    if($maxLoad>$allowedMaximum){ 
			                if ($this->CourseAdd->saveAll(
			                $this->request->data['CourseAdd'],
							array('validate'=>'first'))) {
									 $this->Session->setFlash('<span></span>'.__('The course add has been sent to department successfully for approval.'), 'default',array('class'=>'success-box success-message'));
								  // dont forget to add to registration table after approval
								  $this->redirect(array('action'=>'index'));
							} else {
								 $this->Session->setFlash('<span></span>'.__('The course add could not be send. Please, try again.'),
										 'default',array('class'=>'error-box error-message'));
							}
					    } else {
					       $this->Session->setFlash('<span></span>'.__('The maximum course load allowed per semester is '.$allowedMaximum.'. Please reduce the number of courses you would like to take and try again.'),'default',array('class'=>'error-box error-message'));
					    }
					}
				} else {
				    $this->Session->setFlash('<span></span>'.__('Please select atleast one course you want to add.'),'default',array('class'=>'error-box error-message'));
				}
	                    //debug($this->request->data);
	            }
	      }           
	    // $departments= $this->CourseAdd->PublishedCourse->Department->find('list');
	     $colleges = $this->CourseAdd->PublishedCourse->College->find('list');
	     $this->set(compact('colleges'));
	  
	}
	//get_published_add_courses
	function get_published_add_courses($section_id=null,$student_id=null,$academicYearSemester=null) {
	       $this->layout='ajax';
	       if (!empty($academicYearSemester)) {
	          // $current_academic_year= $this->AcademicYear->current_academicyear();
	           $academicYearSemesterArray = explode(",", $academicYearSemester);
	          
	           $academicYear=str_replace("-", "/", $academicYearSemesterArray[0]);
	           $current_academic_year=$academicYear;
	           $section_semester=$academicYearSemesterArray[1];
	       } else {
	           $current_academic_year= $this->AcademicYear->current_academicyear(); 
	        
	           if (!empty($student_id)) {
	               $latestAcSemester=ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear(
	               $student_id,$current_academic_year);
	           } else {
	                $latestAcSemester=ClassRegistry::init('CourseRegistration')->
	                getLastestStudentSemesterAndAcademicYear($this->student_id,$current_academic_year);
	          
	           }
	           $section_semester = ClassRegistry::init('CourseRegistration')->
	           latest_semester_of_section ($section_id,$current_academic_year);
	          
	           if ($section_semester==2) {
	             $section_semester=$latestAcSemester['semester'];
	           }  
	          
	       }
	      
	       
	      
	       
	       /*$otherAdds=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array('PublishedCourse.semester'=>$semester,
	             
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               'PublishedCourse.department_id'=>$this->request->data['Student']['department_id']),
	               'contain'=>array('Course'=>array('fields'=>array('course_code','credit','id','course_title')))));
	               */
	        if (!empty($student_id)) {
	        $student_section_id = $this->CourseAdd->Student->StudentsSection->field('section_id',
	        array('student_id'=>$student_id,'archive'=>0));
	        } else {
	            $student_section_id = $this->CourseAdd->Student->StudentsSection->field('section_id',
	        array('student_id'=>$this->student_id,'archive'=>0));
	       
	        }
	        if($student_section_id==$section_id) {
	           // exclude mass add 
	            $otherpublished=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array(
	               
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               
	               'PublishedCourse.semester '=>$section_semester,
	               'PublishedCourse.add=0',
	               'PublishedCourse.section_id'=>$section_id),
	               'contain'=>array('Course'=>array('fields'=>array('course_code','credit','id','course_title')))));
	    
	        } else {
                $otherpublished=$this->CourseAdd->PublishedCourse->find('all',
	               array('conditions'=>array(
	               
	               'PublishedCourse.academic_year LIKE '=>$current_academic_year.'%',
	               
	               'PublishedCourse.semester '=>$section_semester,
	               'PublishedCourse.drop=0',
	               'PublishedCourse.section_id'=>$section_id),
	               'contain'=>array('Course'=>array('fields'=>array('course_code','credit','id','course_title')))));
	       }
	       if (!empty($student_id)) {
	        $otherAdds=$this->__exclude_already_added($otherpublished,$student_id);        
	       } else {
	          $otherAdds=$this->__exclude_already_added($otherpublished,$this->student_id);
	       }
	       $this->set(compact('otherAdds'));
	       if (!empty($student_id)) {
	         $this->set('student_id',$student_id);
	       } else {
	         $this->set('student_id',$this->student_id);
	       }
	       
	         
	}
	
	function __exclude_already_added ($otherAdds,$student_id=null) {
	            $pub_own_as_add_courses = array();
	            $count=0;
	         
	            foreach ($otherAdds 
	            as $ownIndex=>$ownValue) {
	              if(isset($student_id) && !empty($student_id)){
	               $already_added = $this->CourseAdd->find('count',array('conditions'=>
	               array(
	               'CourseAdd.student_id'=>$student_id,
	               //'CourseAdd.registrar_confirmation'=>1,
	               //'CourseAdd.department_approval'=>1,
	               'CourseAdd.published_course_id'=>$ownValue['PublishedCourse']['id'])));
	               
	                  } else {
	                  $already_added = $this->CourseAdd->find('count',array('conditions'=>
	               array(
	               'CourseAdd.student_id'=>$this->student_id,
	               //'CourseAdd.registrar_confirmation'=>1,
	               //'CourseAdd.department_approval'=>1,
	               'CourseAdd.published_course_id'=>$ownValue['PublishedCourse']['id'])));
	               
	                  }
	                  if (!empty($ownValue['Course']['id'])) {
	                  $already_taken_course = ClassRegistry::init('CourseDrop')->course_taken($student_id,$ownValue['Course']['id']);
	                   }
	        		if($ownValue['Course']['id']==9440){
	        		debug($ownValue);
	                  debug($already_taken_course);
	                  
	                  }
	                   /**
						   *1 -exclude from add 
						   *2 -exclude from add
						   *3 -allow add 
						   *4 - prerequist failed.
	       			 */
	                
	                  if (
	                  $already_taken_course == 1 
	                  || $already_taken_course==4 
	                  || $already_taken_course == 2 
	                  ) {
	                      
	        if($already_added>0 ){
	      $pub_own_as_add_courses[$count]=$ownValue;
	                      
	      $pub_own_as_add_courses[$count]['already_added']=0;
	      } else {
	        $pub_own_as_add_courses[$count]=$ownValue;
	                      
	      $pub_own_as_add_courses[$count]['already_added']=1;
	      }
	                      if ($already_taken_course==4) {
	                        $pub_own_as_add_courses[$count]['prerequiste_failed']=1;
	                      }
	                  } else {
	                     
	                       $pub_own_as_add_courses[$count]=$ownValue;
	                       $pub_own_as_add_courses[$count]['already_added']=0;
	         
	                  }
	                  $count++;         
	           }
	           return $pub_own_as_add_courses;
	}
	
	/**
	*The authentication key is regenerated every time a form is evaluated with requireAuth.
	*This means that if a user submits a form with a key that has already been used, 
	*the form submission will be considered invalid.There are several cases in 
	*which this could occur, including but not limited to using multiple browser windows, 
	*using the Back button to return to a previous page, browser caching, proxy caching, 
	*and more. While you may be tempted to write off these problems as user error, 
	*you should resist the temptation and plan on handling invalid form submissions gracefully.
	*
	*/
	function invalid () {
	  $this->cakeError('youSuck');
	}
	
	function __init_search_index() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Search'])){
               
                    $search_session = $this->request->data['Search'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_index', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data_index');
        	$this->request->data['Search'] = $search_session;
        } 

    }
    
    function cancel_mass_add () { 
          
	      // Function to load/save search criteria.
        //   $this->Session->delete('search_data');
        if ($this->Session->read('search_data') && !isset($this->request->data['getsection'])) {
                       $this->request->data['getsection']=true;
                       $this->request->data['Student']=$this->Session->read('search_data');
                       $this->set('hide_search',true);
                      
        }
        
        
	    if (!empty($this->request->data) && isset($this->request->data['cancelmassadd'])) {
	         
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
	                    
	                      $grade_submitted_pub_count = 0;
	                      $add_for_delete['add']=array();
	                      foreach ($selected_published_courses as $key=>$pid) {
	                      	   $is_grade_submitted = $this->CourseAdd->ExamGrade->is_grade_submitted($pid);
	                      	   //check again if grade is not submitted then allow cancellation.
	                      	   if (!$is_grade_submitted) { 
	                          	  // $tmp=$this->CourseAdd->PublishedCourse->getStudentsTakingPublishedCourse($pid);
	                          	  $add_for_delete['add'][]=$pid;
	                           } else {
	                             $grade_submitted_pub_count++;
	                           }
                         }
                         
                         
                      if (count($selected_published_courses) !=$grade_submitted_pub_count) {  
                        
				            if (!empty($add_for_delete['add'])) {
				               if($this->CourseAdd->deleteAll(array('CourseAdd.published_course_id'=>$add_for_delete['add']), false)) {
							   }
				            }
				            
				            if (!empty($add_for_delete['add'])) {
				                 $this->Session->setFlash('<span></span>'.__('Course registration is cancelled for selected courses.'), 'default', array('class' => 'success-message success-box'));
							     
				            }
		     		  } else {
		                          $this->Session->setFlash('<span></span>'.
		                          __('You can not cancel the mass add  
		                           grade has already submitted.', true), 
		                          'default', array('class' => 'info-message 
		                          info-box'));
				      
				      }  
				       // $this->redirect(array('action'=>'index'));
				      
	               }
	              
	          } else {
	                  $this->Session->setFlash('<span></span> '.__('Please 
	                  select courses you want to cancel the mass add.', true),
	                  'default',array('class'=>'error-box error-message')); 
	          
	          }
	        
	   }
	  if (!empty($this->request->data) && isset($this->request->data['getsection'])) {
			$this->Session->delete('search_data');
		
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
			        // yearlevel map for the selected department
			       // debug($this->request->data['Student']['year_level_id']);
			        $this->__init_search();
			        $yearLevelId=$this->CourseAdd->PublishedCourse->YearLevel->field('id',
			       array('YearLevel.department_id'=>$this->request->data['Student']['department_id'],
			       'YearLevel.name'=>$this->request->data['Student']['year_level_id']));
			       
			        $sections=$this->CourseAdd->PublishedCourse->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$this->request->data['Student']['department_id'],
			        'Section.year_level_id'=>$yearLevelId,
			        'Section.program_id'=>$this->request->data['Student']['program_id'],
			        'Section.program_type_id'=>$this->request->data['Student']['program_type_id']
			        
			        )));
			    
			      $listOfPublishedCourses=$this->CourseAdd->PublishedCourse->find('all',array('conditions'=>array(
			        'PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
			        'PublishedCourse.year_level_id'=>$yearLevelId,
			        'PublishedCourse.add'=>1,
			        'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Student']['program_type_id'],
			        'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
			            "OR"=>array(
			                
			                 'PublishedCourse.id IN (select published_course_id from course_adds)'
			            ),
			        ),'fields'=>array('id','section_id'),
			        'contain'=>array('Section'=>array('fields'=>array('id','name')),'Course'=>array('fields'=>array('id','course_title','course_code',
			        'lecture_hours','tutorial_hours','credit')))));
			      
			       $organized_published_course_by_section=array();
			       $publish_courses_list_ids=array();
			     
			       $publish_counter=0;
			       $grade_submitted_counter=0;
			       foreach($listOfPublishedCourses as $lp=>$lv){
			             if (isset($lv['PublishedCourse']['section_id']) && 
			             !empty($lv['PublishedCourse']['section_id'])) {  
			              $is_grade_submitted = $this->CourseAdd->ExamGrade->is_grade_submitted(
			              $lv['PublishedCourse']['id']);
			              if ($is_grade_submitted) { 
			                //put a flag and disabled the check box for selection 
			                 $organized_published_course_by_section[$lv['PublishedCourse']['section_id']]
			                 [$publish_counter]=$lv;
			                 
			                  $organized_published_course_by_section
			                  [$lv['PublishedCourse']['section_id']][$publish_counter]['grade_submitted']=1;
			                 
			                 $publish_courses_list_ids[$publish_counter]=$lv['PublishedCourse']['id'];
			                 $grade_submitted_counter++;
			             } else {
			             
			               $organized_published_course_by_section[$lv['PublishedCourse']['section_id']][
			               $publish_counter]=$lv;
			                 $publish_courses_list_ids[]=$lv['PublishedCourse']['id'];
			                  $organized_published_course_by_section
			                  [$lv['PublishedCourse']['section_id']][$publish_counter]['grade_submitted']=0;
			             }
			             
			            }
			            $publish_counter++;
			        }
			      
			       
			        $publishedCourseAdd = ClassRegistry::
	    init('CourseAdd')->find('all',array('conditions'=>array(
			        'CourseAdd.published_course_id'=>$publish_courses_list_ids,
			        'CourseAdd.published_course_id IN (select published_course_id 
			        from course_adds)',
			        'CourseAdd.id NOT IN (select course_add_id from exam_grades where course_add_id is not null)'
			        
			        ),
			        'contain'=>array('ExamGrade','PublishedCourse'=>array('Course','Section'))));
			     
			        
			       
			        if (empty($publishedCourseAdd) ) {
			              $this->Session->setFlash('<span></span> '.
			              __('No result is found. 
			              Either grade is submitted or there is no mass add in 
			              the selected criteria.', true),'default',array('class'=>'info-box info-message'));  
			        
			        } else {
			          
			            $published_course_ids=array();
			         
			           $this->set('hide_search',true);
			          
			          
			           $this->set(compact('sections','listOfPublishedCourses','organized_published_course_by_section'));
			         
			        
			        }
			        
			        $year_level_id=$this->request->data['Student']['year_level_id'];
			        $program_name=$this->CourseAdd->PublishedCourse->Program->field('Program.name',array('Program.id'=>$this->request->data['Student']['program_id']));
			        $program_type_name=$this->CourseAdd->PublishedCourse->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Student']['program_type_id']));
			        $academic_year=$this->request->data['Student']['academic_year'];
			        $semester=$this->request->data['Student']['semester'];
			        $department_name=$this->CourseAdd->PublishedCourse->Department->field(
			        'Department.name',array('Department.id'=>$this->request->data['Student']['department_id']));
			        
			       
			        $this->set(compact('sections','year_level_id','program_name','program_type_name',
			     'academic_year','semester','department_name','publish_counter','grade_submitted_counter'));  
			      
			
		   }
	 }
	   if ( $this->role_id == ROLE_REGISTRAR) {
	    
		   $yearLevels =$this->CourseAdd->YearLevel->distinct_year_level();
		    $programs=$this->CourseAdd->Student->Program->find('list',
             array('conditions'=>array('Program.id'=>$this->program_id)));
		    $departments=$this->CourseAdd->Student->Department->find('list',
          array('conditions'=>array('Department.id'=>$this->department_ids)));
             $this->set(compact('departments','yearLevels','programs'));
           
		
		} else if ($this->role_id == ROLE_COLLEGE) { 
		     $yearLevels =$this->CourseAdd->YearLevel->distinct_year_level();
		    $programs=$this->CourseAdd->Student->Program->find('list');
		    $departments=$this->CourseAdd->Student->Department->find('list',
          array('conditions'=>array('Department.college_id'=>$this->department_id)));
             $this->set(compact('departments','yearLevels','programs'));
             
		} else {
		   $departments=$this->CourseAdd->Department->find('list',array('conditions'=>
		   array('Department.id'=>$this->department_id)));
		   $yearLevels=$this->CourseAdd->YearLevel->find('list',array('conditions'=>
		   array('YearLevel.department_id'=>$this->department_id)));
		   $programs=$this->CourseAdd->Student->Program->find('list');
		  $this->set(compact('departments','yearLevels','programs'));
		}
		$programTypes=$this->CourseAdd->Student->ProgramType->find('list');
		$this->set(compact('programTypes'));
	        
    }
    
     function mass_add () { 
          
	      // Function to load/save search criteria.
       // $this->Session->delete('search_data');       
        if ($this->Session->read('search_data') && !isset($this->request->data['getsection'])) {
                       $this->request->data['getsection']=true;
                       $this->request->data['Student']=$this->Session->read('search_data');
                       $this->set('hide_search',true);
                      
        }
        
        
	    if (!empty($this->request->data) && isset($this->request->data['massadd'])) {
	         
	          $one_is_selected=false;
	          $selected_published_courses=array();
	          $section_allowed_mass_add = array();
	          foreach ($this->request->data['PublishedCourse'] as $section_id=>$publishedcourse) {
	              // $section_counter=0;
	               foreach($publishedcourse as $p_id=>$selected){ 
	                    if ($selected==1) {
	                         $one_is_selected=true;
	                        // break 2;
	                        
	                    $selected_published_courses[$section_id][]=$p_id;
	                    }
	                }
	          }
	    debug($selected_published_courses);
	     //check if checked.
	    if ($one_is_selected) {
	         
	         if(!empty($selected_published_courses)) {
	              $selected_courses_add=array();
	              $count=0;
	              $totalStudentAlreadyAdded=0;
	              foreach ($selected_published_courses 
	              as $section_id=>$pid) {
	     //dont forget to turn on archive to 0
	                           $list_of_students_in_active_section=$this->CourseAdd->PublishedCourse->
	                           Section->StudentsSection->find('all',
	              array('conditions'=>array('StudentsSection.section_id'=>$section_id,
	              'StudentsSection.archive'=>0),'recursive'=>-1));	
	                
	                 if (!empty($list_of_students_in_active_section)) {
	                        $criteria=$this->Session->read('search_data');
	                      
		$year_level_id=$this->CourseAdd->PublishedCourse->YearLevel->field('id',
		array('YearLevel.department_id'=>$criteria['department_id'],'YearLevel.name'=>$criteria['year_level_id']));
		debug($year_level_id);
			      debug(count($list_of_students_in_active_section));
	foreach ($list_of_students_in_active_section as $k=>$value) {
	        foreach ($pid as $pk=>$pvalue) {
	        debug($criteria);
	        debug($year_level_id);
	        debug($pvalue);
			$check=$this->CourseAdd->find('count',array('conditions'=>
			array('CourseAdd.student_id'=>$value['StudentsSection']['student_id'],
			'CourseAdd.academic_year'=>$criteria['academic_year'],
			'CourseAdd.semester'=>$criteria['semester'],
			'CourseAdd.year_level_id'=>$year_level_id,
			'CourseAdd.published_course_id'=>$pvalue,
			),
			'recursive'=>-1)
			);
                            $listThePrerequistCourse= $this->CourseAdd->PublishedCourse->find('first',
	            array('conditions'=>array('PublishedCourse.id'=>$pvalue),'contain'=>array('Course'=>array(
	            'Prerequisite'=>array('id','prerequisite_course_id','co_requisite'),
	            'fields'=>array('Course.id','Course.course_code','Course.course_title','Course.lecture_hours',
	            'Course.tutorial_hours','Course.credit')))));
	                         
	                         $checkForPrerequiste=$this->CourseAdd->courseHasPrerequistAndFullFilled(
	                         $listThePrerequistCourse,
	                         $value['StudentsSection']['student_id']);
	                        
	                         
	                         //course taken as registred courses in given semester and 
	                         // academic year 
	                         
	                         $checkForRegistration= ClassRegistry::init('CourseRegistration')->courseRegistered(
	                         $criteria['semester'],$criteria['academic_year'],
	                         $value['StudentsSection']['student_id']);
	                         //4 dismissed
	                         $passed_or_failed=$this->CourseAdd->Student->StudentExamStatus->get_student_exam_status( $value['StudentsSection']['student_id'],$criteria['academic_year']);
			               
                            // first time and fullfilled prequisite, and course not registred
                           
                            if($checkForPrerequiste==false){
                            	debug($pp++);
                            	 debug($listThePrerequistCourse);
	                         
                            }
                            debug($checkForPrerequiste);
                            debug($checkForRegistration);
                            debug($check);
                           
                            if ($check==0 && $checkForPrerequiste==true && $checkForRegistration == 0) {
                              if($passed_or_failed!=4){
                                $selected_courses_add['CourseAdd'][$count]['semester']=$criteria['semester'];
                                $selected_courses_add['CourseAdd'][$count]['academic_year']=$criteria['academic_year'];
                                $selected_courses_add['CourseAdd'][$count]['year_level_id']=$year_level_id;
                                 $selected_courses_add['CourseAdd'][$count]['published_course_id']=$pvalue;
                                  $selected_courses_add['CourseAdd'][$count]['student_id']=$value['StudentsSection']['student_id'];
                                $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
                                $selected_courses_add['CourseAdd'][$count]['reason']='Published as add';
                                $selected_courses_add['CourseAdd'][$count]['department_approved_by']='Published as add';
                                $selected_courses_add['CourseAdd'][$count]['registrar_confirmed_by']=$this->Auth->user('id');
                                $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
                                $count++;
                            	}
                            } else{
                            //nothing 
                            $totalStudentAlreadyAdded++;
                            }
	                     } //publishe course 
	                    }
	                 }
                  } 
                   debug($count);
                   debug($pp);
                  //check and add course as mass add   
                  if(isset($selected_courses_add['CourseAdd']) && count($selected_courses_add['CourseAdd'])>0) {
                      if ($this->CourseAdd->saveAll($selected_courses_add['CourseAdd'],array('validate'=>'first'))) {
				                $this->Session->setFlash('<span></span>'.
				                __('The course add has been saved'),'default',
				                array('class'=>'success-box success-message'));
				                $this->Session->delete('search_data');
				                // save to course registration table
				              
				                $this->redirect(array('action' => 'index'));
			           } else {
				                $this->Session->setFlash('<span></span>'.__('The course add could not be saved. Please, try again.'),
				                'default',array('class'=>'error-box error-message'));
			           } 
			      } else {
			       $this->Session->setFlash('<span></span>'.__('The mass add for '.$totalStudentAlreadyAdded.' student(s) has already approved earlier and currently we couldnt find more students for approval. '),'default',array('class'=>'info-box info-message'));
			      }   
	          }    
	     } else {
	       $this->Session->setFlash('<span></span> '.__('Please select courses 
	       you want to cancel/delete.', true),
	         'default',array('class'=>'error-box error-message')); 
	          
	     }
	        
	   }
	  if (!empty($this->request->data) && isset($this->request->data['getsection'])) {
			$this->Session->delete('search_data');
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
	// yearlevel map for the selected department
			$this->__init_search();
			$program_type_id=$this->AcademicYear->equivalent_program_type(
			$this->request->data['Student']['program_type_id']);
            $yearLevelId=$this->CourseAdd->PublishedCourse->YearLevel->field('id',array('YearLevel.department_id'=>$this->request->data['Student']['department_id'],'YearLevel.name'=>$this->request->data['Student']['year_level_id']));
			$sections=$this->CourseAdd->PublishedCourse->Section->find('list',array('conditions'=>array('Section.department_id'=>$this->request->data['Student']['department_id'],
			'Section.year_level_id'=>$yearLevelId,
			'Section.program_id'=>$this->request->data['Student']['program_id'],
			'Section.program_type_id'=>$program_type_id)));

		$listOfPublishedCourses=$this->CourseAdd->PublishedCourse->find('all',array('conditions'=>array(
		'PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
		'PublishedCourse.year_level_id'=>$yearLevelId,
		'PublishedCourse.add'=>1,
		'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
		'PublishedCourse.program_type_id'=>$this->request->data['Student']['program_type_id'],
		'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
		'PublishedCourse.academic_year like '=>$this->request->data['Student']['academic_year'].'%'),'fields'=>array('id','section_id'),
		'contain'=>array('Section'=>array('fields'=>array('id','name')),'Course'=>array('fields'=>array('id','course_title','course_code',
		'lecture_hours','tutorial_hours','credit')))));
			    
			if(empty($listOfPublishedCourses)) {
$this->Session->setFlash('<span></span>'.__('There is no published courses which need mass add for the selected criteria.', true),
'default',array('class'=>'error-box error-message'));
			} else {

			}
			$organized_published_course_by_section=array();
			$publish_courses_list_ids=array();
			$counter=0;
			$totalAddedCourse=0;
			
			foreach($listOfPublishedCourses 
			as $lp=>$lv){
			 if (isset($lv['PublishedCourse']['section_id']) && !empty($lv['PublishedCourse']['section_id'])) {  
			
			  $is_grade_submitted = $this->CourseAdd->ExamGrade->is_grade_submitted(
			  $lv['PublishedCourse']['id']);
			  if ($is_grade_submitted) { 
				//put a flag and disabled the check box for selection 
$organized_published_course_by_section[$lv['PublishedCourse']['section_id']][$counter]=$lv;
$organized_published_course_by_section
[$lv['PublishedCourse']['section_id']][$counter]['grade_submitted']=true;
$publish_courses_list_ids[$counter]=$lv['PublishedCourse']['id'];
			 } else {
$organized_published_course_by_section[$lv['PublishedCourse']['section_id']][$counter]=$lv;
$publish_courses_list_ids[]=$lv['PublishedCourse']['id'];
$organized_published_course_by_section
[$lv['PublishedCourse']['section_id']][$counter]['grade_submitted']=false;
			 }
			}
			$counter++;
		  }
		$this->set(compact('sections',
		'listOfPublishedCourses',
		'organized_published_course_by_section'));
		$year_level_id=$this->request->data['Student']['year_level_id'];
	    $program_name=$this->CourseAdd->PublishedCourse->Program->field('Program.name',array('Program.id'=>$this->request->data['Student']['program_id']));
		$program_type_name=$this->CourseAdd->PublishedCourse->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Student']['program_type_id']));
		$academic_year=$this->request->data['Student']['academic_year'];
	    $semester=$this->request->data['Student']['semester'];
	    $department_name=$this->CourseAdd->PublishedCourse->Department->field(
	    'Department.name',array('Department.id'=>$this->request->data['Student']['department_id']));
		$this->set(compact('sections',
		'year_level_id','program_name',
		'program_type_name',
		'academic_year','semester',
		'department_name'));  
		}
	   }
	   if ( $this->role_id == ROLE_REGISTRAR) {
	    
		   $yearLevels =$this->CourseAdd->YearLevel->distinct_year_level();
		    $programs=$this->CourseAdd->Student->Program->find('list',
             array('conditions'=>array('Program.id'=>$this->program_id)));
		    $departments=$this->CourseAdd->Student->Department->find('list',
          array('conditions'=>array('Department.id'=>$this->department_ids)));
             $this->set(compact('departments','yearLevels','programs'));
           
		
		} else if ($this->role_id == ROLE_COLLEGE) { 
		     $yearLevels =$this->CourseAdd->YearLevel->distinct_year_level();
		    $programs=$this->CourseAdd->Student->Program->find('list');
		    $departments=$this->CourseAdd->Student->Department->find('list',
          array('conditions'=>array('Department.college_id'=>$this->department_id)));
             $this->set(compact('departments','yearLevels','programs'));
             
		} else {
		   $departments=$this->CourseAdd->Department->find('list',array('conditions'=>
		   array('Department.id'=>$this->department_id)));
		   $yearLevels=$this->CourseAdd->YearLevel->find('list',array('conditions'=>
		   array('YearLevel.department_id'=>$this->department_id)));
		   $programs=$this->CourseAdd->Student->Program->find('list');
		  $this->set(compact('departments','yearLevels','programs'));
		}
		$programTypes=$this->CourseAdd->Student->ProgramType->find('list');
		$this->set(compact('programTypes'));
	        
    }

	 public function cancel_course_add() {
			if($this->role_id==ROLE_REGISTRAR || ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']){
				$this->__cancel_course_add();
			} 
	 }
     
	  private function __cancel_course_add($selected = null) {
		/*
		1. Retrieve list of sections based on the given search criteria
		2. Display list of sections
		3. Up on the selection of section, display list of students with check-box
		4. Prepare student grade report in PDF for the selected students
		*/
		$programs = $this->CourseAdd->PublishedCourse->Section->Program->find('list');
		$program_types = $this->CourseAdd->PublishedCourse->Section->ProgramType->find('list');
        $acyear_list = $this->AcademicYear->academicYearInArray(date('Y')-6,date('Y'));
		$this->set(compact('acyear_list'));

		 //deleteGrade button is clicked
	       //deleteGrade button is clicked
	     if(isset($this->request->data['deleteGrade']) && !empty($this->request->data['deleteGrade'])) {
		    $publishedCoursesId=array();
			$student_ids = array();
			$studentId=null;
			$courseAddAndGrade=array();
            $courseAddAndGrade=array();
			$count=0;
            $scaleNotFound['freq']=0;
			
			foreach($this->request->data['CourseAdd'] as $key => $student) {
		     
			  if($student['gp'] == 1) {
				$student_ids[] = $student['student_id'];
			    $studentId=$student['student_id'];
			    $courseAddAndGrade[$count]['CourseAdd']=$student;
			    $publishedCoursesId=$student['published_course_id'];

				if(!empty($student['grade_id'])){
                    $courseAddAndGrade[$count]['ExamGrade'][$count]['id']=$student['grade_id'];
				}

                if(!empty($student['id'])){
                    $courseAddAndGrade[$count]['ExamGrade'][$count]['course_add_id']=$student['id'];
				}
               
			 }
			 $count++;
		  }
		
          if(!empty($courseAddAndGrade)) {
				$courseAddandRegistrationExamGradeIds=array();
				foreach($courseAddAndGrade as $data) {
					  foreach($data['ExamGrade'] as $k=>$v) {
					    $courseAddandRegistrationExamGradeIds['ExamGrade'][]=$v['id'];
						if(!empty($v['course_add_id'])) {
							$courseAddandRegistrationExamGradeIds['CourseAdd'][]=$v['course_add_id'];
						}
					}
				}
     
				
                if(!empty($courseAddandRegistrationExamGradeIds['CourseAdd'])) {

                      if($this->CourseAdd->deleteAll(array('CourseAdd.id'=>$courseAddandRegistrationExamGradeIds['CourseAdd']),false)) {
		                   $this->CourseAdd->ExamGrade->deleteAll(array('ExamGrade.id'=>$courseAddandRegistrationExamGradeIds['ExamGrade']),false);
			$this->Session->setFlash('<span></span>'.__('You have deleted the data successfully.'), 'default', array('class'=>'success-box success-message'));
					    }
				}
				
			
		    } else {
					if(empty($student_ids)) {
					    $this->request->data['listAddedCourses']=true;
					    $this->Session->setFlash('<span></span> '.__('You are required to select at least one course.'), 'default', array('class'=>'error-box error-message'));
					}
			}
	    }

		//Get published course for the selected student
	    if(isset($this->request->data['listAddedCourses']) && !empty($this->request->data['listAddedCourses'])) {
		  
		    $department_ids=array();
		    $everyThingOk=false;
		    $selectedStudent=array();
		    if(!empty($this->department_ids))
            {
				$selectedStudent=$this->CourseAdd->Student->find('first',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['CourseAdd']['studentnumber'])),
	'contain'=>array('StudentsSection')));
			   $selectedStudentDetail=$this->CourseAdd->Student->getStudentRegisteredAddDropCurriculumResult($selectedStudent['Student']['id']);
			
			   if(!empty($selectedStudent)) {
				  if(!in_array($selectedStudent['Student']['department_id'],$this->department_ids)) {
				  debug($selectedStudent['Student']['department_id']);
		                      $this->Session->setFlash('<span></span>'.
	__('You don\'t have the privilage to cancel course add for '.$this->request->data['CourseAdd']['studentnumber'].'.'), 'default', array('class'=>'info-box info-message'));
				   } else {
				   
					$everyThingOk=true;
				   }
				} else {
		            $this->Session->setFlash('<span></span>'.__(' '.$this->request->data['CourseAdd']['studentnumber'].' is not a valid student number.'), 'default', array('class'=>'info-box info-message'));
				}
		    } else if(!empty($this->college_ids)) { 
	
				$selectedStudent=$this->CourseAdd->Student->find('first',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['CourseAdd']['studentnumber'])),
	'contain'=>array('StudentsSection')));
				$selectedStudentDetail=$this->CourseAdd->Student->getStudentRegisteredAddDropCurriculumResult($selectedStudent['Student']['id']);
			
			   if(!empty($selectedStudent)) {
				   if(!in_array($selectedStudent['Student']['college_id'],$this->college_ids)) {
		                      $this->Session->setFlash('<span></span>'.
	__('You don\'t have the privilage to cancel course add for '.$this->request->data['ExamGrade']['studentnumber'].'.'), 'default', array('class'=>'info-box info-message'));
				   } else {
						$everyThingOk=true;
				   }
				} else {
		            $this->Session->setFlash('<span></span>'.__(' '.$this->request->data['CourseAdd']['studentnumber'].' is not a valid student number.'), 'default', array('class'=>'info-box info-message'));
				}

			} else if($this->role_id==ROLE_REGISTRAR) {
                 $everyThingOk=true;
                 $selectedStudent=$this->CourseAdd->Student->find('first',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['CourseAdd']['studentnumber'])),
	'contain'=>array('StudentsSection')));
		    } else {
			   $this->Session->setFlash('<span></span>'.__('You don\'t have the privilage to enter data for the selected student.'), 'default', array('class'=>'info-box info-message'));

		    }
            $password=$this->CourseAdd->Student->User->field('User.password',
array('User.id'=>$this->Auth->user('id')));
			
            $hashedPasswordGiven=Security::hash($this->request->data['CourseAdd']['password'], null, true);
		    if($hashedPasswordGiven==$password) {
				
             	$everyThingOk=true;
			 	$selectedStudent=$this->CourseAdd->Student->find('first',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['CourseAdd']['studentnumber'])),
	'contain'=>array('StudentsSection')));
			} else {
                $everyThingOk=false;
                $this->Session->setFlash('<span></span>'.__('Wrong password!'), 'default', array('class'=>'info-box info-message'));
			}
			
			debug($everyThingOk);
			debug($selectedStudent);
		    if($everyThingOk && !empty($selectedStudent)) {
			/*
			 * find the published course in that semester and academic year
			 * does that published course has registration, grade submitted, then disable in the interface data entry
			 */
               $yearLevelAndSemesterOfStudent=$this->CourseAdd->Student->StudentExamStatus->studentYearAndSemesterLevel($selectedStudent['Student']['id'],$this->request->data['CourseAdd']['acadamic_year'], $this->request->data['CourseAdd']['semester']);
		      
		      $student_academic_profile=$this->CourseAdd->Student->getStudentRegisteredAddDropCurriculumResult($selectedStudent['Student']['id'],$this->AcademicYear->current_academicyear());
	        $this->set(compact('student_academic_profile'));
			$selectedStudentDetails= $this->CourseAdd->ExamGrade->getStudentCopy($selectedStudent['Student']['id'],$this->request->data['CourseAdd']['acadamic_year'], $this->request->data['CourseAdd']['semester']);
		    $admission_explode=explode('-',$selectedStudentDetails['Student']['admissionyear']);
			$studentAdmissionYear=$this->AcademicYear->get_academicyear($admission_explode[1], $admission_explode[0]);
		     
			 $publishedCourses=$this->CourseAdd->find('all',array('conditions'=>array('CourseAdd.academic_year'=>$this->request->data['CourseAdd']['acadamic_year'],
'CourseAdd.semester'=>$this->request->data['CourseAdd']['semester'],
'CourseAdd.student_id'=>$selectedStudentDetails['Student']['id']),
'contain'=>array('PublishedCourse'=>array('Course'=>array('Prerequisite')))));
			debug($publishedCourses);
			$studentbasic=$selectedStudentDetails;
			$this->set(compact('publishedCourses','studentbasic'));
		   }
	       
	      }
           
          if(!empty($this->department_ids)){
				$departments=$this->CourseAdd->Student->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
           }else if (!empty($this->college_ids)) {
				$colleges=$this->CourseAdd->Student->College->find('list',array('conditions'=>array('College.id'=>$this->college_ids)));          
           } 
           $this->set(compact('programs', 'program_types', 'departments', 'academic_year_selected', 'semester_selected', 'program_id', 'program_type_id', 'section_id', 'sections','students_in_section','student_copies','colleges','department_id','college_id'));
	       $this->render('cancel_course_add');
	       
	      
	 }
   
}
