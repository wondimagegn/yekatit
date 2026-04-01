<?php
class CourseDropsController extends AppController {

	var $name = 'CourseDrops';
    var $menuOptions = array(
               // 'parent' => 'courseRegistrations',
                'parent' => 'registrations',
                'exclude'=>array('list_students'),
                'alias' => array(
                    'index' => 'View Course Drops',
                    'add' => 'Drop course for single student',
                    'forced_drop'=>'Forced Drop',
                    'drop_courses'=>'Drop Courses'
                   
            )
                
      );
    var $components =array('AcademicYear');
    
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
	   		   $program_types=$programTypes =  $this->CourseDrop->Student->ProgramType->find('list',array('conditions'=>
	   		   	array('ProgramType.id'=>$this->program_type_id)));
	   } else{
	   		   $program_types=$programTypes=$this->CourseDrop->Student->ProgramType->find('list');
	   }

       if(!empty($this->program_id)){
	   		   $programs=$this->CourseDrop->Student->Program->find('list',array('conditions'=>
	   		   	array('Program.id'=>$this->program_id)));
	   } else{
	   		   $programs=$this->CourseDrop->Student->Program->find('list');
	   }

        $this->set(compact('acyear_array_data','defaultacademicyear','program_types','programs',
        	'programTypes'));
        unset($this->request->data['User']['password']);
	}
	
	function beforeFilter () {
	   //list_students
	     parent::beforeFilter();
        
         $this->Auth->allow('list_students');
	
	}
	

	function index($id=null) {
		$this->CourseDrop->recursive = 0;
		$this->paginate=array('limit'=>200,'contain'=>array('Student'=>array('fields'=>array('id','full_name',
		'studentnumber')),'CourseRegistration'=>array('PublishedCourse'=>array(
		'Course'=>array('fields'=>array('id','course_title','course_code_title',
		'credit'))),'YearLevel'=>array('fields'=>array('id','name')))),'order'=>array('CourseDrop.created desc'));
	     $options=array();
		 $department_id=array();
	     if ($this->role_id == ROLE_REGISTRAR) {
	                  if (!empty($this->department_ids)) {
	                       $department_id=$this->department_ids;
	                          
		                  $departments=$this->CourseDrop->Student->Department->find('list',
		                  array('conditions'=>array('Department.id'=>$department_id)));
		      
	                  } if (!empty($this->college_ids)) {
	                     $colleges=$this->CourseDrop->Student->College->find('list',
		                  array('conditions'=>array('College.id'=>$this->college_ids)));
		      
	                  }
	                 
	      } else if ($this->role_id == ROLE_DEPARTMENT ) {
	              $department_id=$this->department_id;
	            
		          $departments=$this->CourseDrop->Student->Department->find('list',
		          array('conditions'=>array('Department.id'=>$department_id)));
	      } else if ($this->role_id == ROLE_COLLEGE) {
	             $department_ids = $this->CourseDrop->Student->Department->find('list',
	              array('conditions'=>array('Department.college_id'=>$this->college_id)));
	              $department_id = array_keys($department_ids);
	             $beginning['pre']='Pre/Fresh';
	             $departments=$this->CourseDrop->Student->Department->find(
	             'list',array('conditions'=>array('Department.college_id'=>$this->college_id)));
		      
		        $departments = $beginning+$departments;
	      }
	      
		  $this->__init_search_index();  
		  if ($this->Session->read('search_data_index')) {
		    $this->request->data['viewCourseDrops']=true;
		  }
		  
		  if (!empty($this->request->data) && isset($this->request->data['viewCourseDrops'])) { 
                    		                
		            
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
                                   
                                    'CourseDrop.semester'=>$this->request->data['Search']['semester'],
                                    'Student.department_id'=>$department_id  
                                );

	                }
		            
		             if (!empty($this->request->data['Search']['academic_year'])) {
	                       
	                              $options[] = array(
                                   
                                    'CourseDrop.academic_year'=>$this->request->data['Search']['academic_year'],
                                    'Student.department_id'=>$department_id  
                                );

	                }
	                
		            if ($this->request->data['Search']['rejected']==1 && $this->request->data['Search']['accepted']==0 
	               && $this->request->data['Search']['notprocessed']==0) {
	                         if ($this->role_id == ROLE_DEPARTMENT) {
	                             $options[] = array(
	                               
	                                "CourseDrop.department_approval"=>0,
	                                'Student.department_id'=>$department_id
	                           );         
	                         }
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                              $options[] = array(
	                               
	                                "CourseDrop.registrar_confirmation"=>0,
	                                'Student.department_id'=>$department_id
	                           );         
	                         }
	                         
	                        if ($this->role_id == ROLE_COLLEGE) {
	                           
	                           if (strcasecmp($this->request->data['Search']['department_id'],'pre')===0) {
                                    $options[] = array(
                                        "CourseDrop.department_approval"=>0,
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
	                               
	                                "CourseDrop.department_approval"=>1,
	                                'Student.department_id'=>$department_id
	                           );         
	                        }
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                           $options[] = array(
	                               
	                                "CourseDrop.registrar_confirmation"=>1,
	                                'Student.department_id'=>$department_id
	                           );      
	                         }
	                         
	                         if ($this->role_id == ROLE_COLLEGE) {
	                              $options[] = array(
	                               
	                                "CourseDrop.department_approval"=>1,
	                                'Student.department_id'=>$department_id
	                              );         
	                         }
	                         
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==1) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                            $options[] = array(
	                               
	                                "CourseDrop.department_approval is null",
	                                'Student.department_id'=>$department_id
	                           );
	                        }   
	                        
	                        if ($this->role_id == ROLE_REGISTRAR) {
	                          $options[] = array(
	                                "CourseDrop.department_approval=1",
	                                "CourseDrop.registrar_confirmation is null",
	                                'Student.department_id'=>$department_id
	                           );
	                        }
	                        
	                        if ($this->role_id == ROLE_COLLEGE) {
	                           
	                           if (strcasecmp($this->request->data['Search']['department_id'],'pre')===0) {
                                    $options[] = array(
                                       'Student.department_id is null',
                                       "CourseDrop.department_approval is null",
                                       'Student.college_id'=>$this->college_id   
                                     );
                                } else {
                                   $options[] = array(
                                    "CourseDrop.department_approval is null",
                                    'Student.department_id'=>$department_id
                                 );
                                }
                              
	                        
	                        }   
	                        
	                        
	                        
	                                      
	                                      
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==0) {
	                         if ($this->role_id == ROLE_DEPARTMENT) {
	                                
	                            $options[] = array(
	                               
	                                "CourseDrop.department_approval"=>array(0,1),
	                                'Student.department_id'=>$department_id
	                           );                 
	                         }
	                         
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                           $options[] = array(
	                                "CourseDrop.department_approval=1",
	                                "CourseDrop.registrar_confirmation"=>array(0,1),
	                                'Student.department_id'=>$department_id
	                           );       
	                         }
	                         
	                         if ($this->role_id == ROLE_COLLEGE) {
	                               $options[] = array(
	                               
	                                "CourseDrop.department_approval"=>array(0,1),
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
	                                 "CourseDrop.department_approval"=>1,
	                                 "CourseDrop.department_approval is null ")
	                           ); 
	                       }
	                       
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                            $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 "CourseDrop.department_approval=1",
	                                 'OR'=>array(
	                                 "CourseDrop.registrar_confirmation"=>1,
	                                 "CourseDrop.registrar_confirmation is null ")
	                           ); 
	                       }
	                       
	                       if ($this->role_id == ROLE_COLLEGE) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array(
	                                 "CourseDrop.department_approval"=>1,
	                                 "CourseDrop.department_approval is null ")
	                           ); 
	                       }        
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==1) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseDrop.department_approval"=>0,
	                                 "CourseDrop.department_approval is null")
	                           );
	                           
	                       }
	                       
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                            $options[] = array(
	                                 "CourseDrop.department_approval=1",
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseDrop.registrar_confirmation"=>0,
	                                 "CourseDrop.registrar_confirmation is null")
	                           );
	                       }
	                       
	                       if ($this->role_id == ROLE_COLLEGE) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseDrop.department_approval"=>0,
	                                 "CourseDrop.department_approval is null")
	                           );
	                           
	                       }         
	              }
	              
	      }
	      
	      if ($this->role_id == ROLE_STUDENT) {
	       
	              $options[] = array(
                       
                        "CourseDrop.student_id"=>$this->student_id
			         );
			   
		     
	       } else {
	          
	            if (empty($options)) {
	                if ($this->role_id == ROLE_COLLEGE ) {
	                  
	                $options[] = array(
                       
                        "Student.department_id is null",
                        "Student.college_id"=>$this->college_id
			         );
	                } else {
	                    
	                $options[] = array(
                       
                        "Student.department_id"=>$department_id
			         );
	                }
	                
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

	       
	        $courseDrops=$this->paginate($options);
		    if (empty($courseDrops)) {
		       $this->Session->setFlash('<span></span>'.__('There is no dropped courses in the system in the given criteria.'),'default',array('class'=>'info-box info-message'));
		    } else {
		        $this->set('courseDrops',$courseDrops);
		       
		    }
		
		  $this->set(compact('programs','programTypes','departments','colleges'));
	
	}

	

	function add($id=null,$registration_id=null) {

	    if ($id) {
	         
                 if (!empty($this->department_ids)) {
                    $elegible_registrar_responsibility=$this->CourseDrop->Student->find('count',
                    array('conditions'=>array('Student.id'=>$id,'Student.department_id'=>$this->department_ids,
						'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id
                    	)));
                 } else if (!empty($this->college_ids)) {
                                $elegible_registrar_responsibility=$this->CourseDrop->Student->find('count',
                                array('conditions'=>array('Student.id'=>$id,'Student.college_id'=>$this->college_ids,
                                		'Student.program_type_id'=>$this->program_type_id,
                    	'Student.program_id'=>$this->program_id,
                                'Student.department_id is null')));         
                    
                 }
                
                 if ($elegible_registrar_responsibility==0) {
                        $this->Session->setFlash('<span></span> You do not have the privilage to drop 
                        the selected student courses.','default',array('class'=>'error-box error-message'));
	                               
                 } else { 
                 
	             
	                 $detail = $this->CourseDrop->drop_courses_list($id,$this->AcademicYear->current_academicyear());
	                 $coursesDrop=$detail['courseDrop'];
	                 $student_section_exam_status=$detail['student_basic'];
	                 $already_dropped=$detail['alreadyDropped'];
	                
	                 if (empty($detail['courseDrop'])) {
                                    $this->Session->setFlash('<span></span>'.
                                    __('The student has not registred for 
                                    the latest academic year and semester.', true),
                                    'default',array('class'=>'error-box error-message'));
                     }  else {
                                        
                            $this->set(compact('coursesDrop'));
                            $this->set(compact('student_section_exam_status','already_dropped')); 
				            
				            $this->set('no_display',true);
                                      
                     }         
	           }
	    }
	    
	    
	    if ($registration_id) {
	          
	           if (!empty($this->department_ids)) {
	                 $registrationDetail= $this->CourseDrop->
	                CourseRegistration->find('first',
                                array(
                                    'conditions'=>
                                    array(
                                        'CourseRegistration.id'=>$registration_id
                                    ),
                                    'contain'=>array(
                                        'Student'=>array(
                                            'conditions'=>array(
                                                'Student.department_id'=>$this->department_ids
                                            )
                                        )
                                    )
                        )
                     );
                     
                    
	           } else if (!empty($this->college_ids)) {
	                  $registrationDetail= $this->CourseDrop->
	                CourseRegistration->find('first',
                                array(
                                    'conditions'=>
                                    array(
                                        'CourseRegistration.id'=>$registration_id
                                    ),
                                    'contain'=>array(
                                        'Student'=>array(
                                            'conditions'=>array(
                                               'Student.college_id'=>$this->college_ids,
                                              'Student.department_id is null'
                                            )
                                        )
                                    )
                        )
                     );
	           }
	           
	           
                 if (!empty($registrationDetail)) {
                     $elegible_registrar_responsibility=1;
                 } else {
                     $elegible_registrar_responsibility=0;
                 }
                 
                 if ($elegible_registrar_responsibility==0) {
                        $this->Session->setFlash('<span></span> You do not have the privilage to drop 
                        the selected student courses.','default',array('class'=>'error-box error-message'));
                                   
                 } else { 
                 
                 
                     $detail = $this->CourseDrop->drop_courses_list(
                     $registrationDetail['CourseRegistration']['student_id'],
                     $registrationDetail['CourseRegistration']['academic_year']);
                     $coursesDrop=$detail['courseDrop'];
                     $student_section_exam_status=$detail['student_basic'];
                     $already_dropped=$detail['alreadyDropped'];
                    
                     if (empty($detail['courseDrop'])) {
                                    $this->Session->setFlash('<span></span>'.
                                    __('The student has not registred for 
                                    the latest academic year and semester.', true),
                                    'default',array('class'=>'error-box error-message'));
                     }  else {
                                        
                            $this->set(compact('coursesDrop'));
                            $this->set(compact('student_section_exam_status','already_dropped')); 
			                
			                $this->set('no_display',true);
                                      
                     }         
               }
               
	    }
	    
	    
		if (!empty($this->request->data) && isset($this->request->data['drop'])) {
			
			$selected=array_sum($this->request->data['CourseRegistration']['drop']);
			//$student_id=$this->request->data['CourseRegistration']['student_id'];
			if ($selected>0) {
			
			$selected_courses_for_drop=$this->request->data['CourseRegistration']['drop'];
			unset($this->request->data['CourseRegistration']['drop']);
			//unset($this->request->data['CourseRegistration']['student_id']);
			$delete_selected_from_registration=array();
			
			foreach ($selected_courses_for_drop as $k=>$v) {
			        if ($v==0) {
			             foreach ($this->request->data['CourseDrop'] as $cr=>$cv) {
			                 if ($cv['course_registration_id']==$k) {
			                   unset($this->request->data['CourseDrop'][$cr]);
			                 } 
			             }
			        }
			 }
			/// if needed to delete from course registration table use deleted_selected_from_registration
			// array
			 foreach ($this->request->data['CourseDrop'] as $ds=>&$dv) {
			        $delete_selected_from_registration[]=$dv['course_registration_id'];
			       // unset($dv['id']);
			 }
			    
			   // $this->request->data['CourseDrop']=$this->request->data['CourseRegistration'];
			    
			    //debug($this->request->data['CourseRegistration']);
			   
			    unset($this->request->data['CourseRegistration']);
			    unset($this->request->data['Student']);
			    $this->CourseDrop->create();
			    $already_dropped_courses=array();
			    $selected_courses_drop=array();
			    foreach ($this->request->data['CourseDrop'] as $cdd=>$cdv) {
			           // debug($cdv);
			            $check=$this->CourseDrop->find('count',array('conditions'=>$cdv,'recursive'=>-1));
			            // already dropped, unset it
			            if ($check) {
			               $already_dropped_courses[]=$cdv['course_id'];
			              // unset ($this->request->data['CourseDrop'][$cdd]);
			              
			            } else {
			                $selected_courses_drop['CourseDrop'][]=$cdv;
			            }
			    }
			 
			    //check duplicate dropping
			    if (count($already_dropped_courses)==count($this->request->data['CourseDrop'])) {
			          $this->Session->setFlash('<span></span>'.__('All the selected courses has already dropped. You do not need to drop it again'),'default',array('class'=>'error-box error-message'));
		             //$this->redirect(array('action'=>'index',$this->request->data['CourseDrop'][0]['student_id']));
			    } else {
			          unset($this->request->data);
			          $this->request->data=$already_dropped_courses;
			    }
			    
			    if (!empty($selected_courses_drop['CourseDrop'])) {
			        
			         foreach ($selected_courses_drop['CourseDrop'] as $di=>&$dv) {
			                
			                $dv['registrar_confirmation']=1;
			                $dv['department_approval']=1;
			                $dv['registrar_confirmed_by']=$this->Auth->user('full_name');
			         }
			       
			        if ($this->CourseDrop->saveAll($selected_courses_drop['CourseDrop'],array('validate'=>'first'))) {
				        $this->Session->setFlash('<span></span>'.__('The course has been dropped successfully.'),'default',
				        array('class'=>'success-box success-message'));
				        // do hard deletion from course registration
				
				        $this->redirect(array('action' => 'index'));
			        } else {
				        $this->Session->setFlash('<span></span>'.__('The course drop could not be dropped. Please, try again.'),
				        'default',array('class'=>'error-box error-message'));
			        }
			        
			    } else {
			      $this->Session->setFlash('<span></span>'.__('The selected courses could not be dropped. '),'default',array('class'=>'error-box error-message'));
		             //$this->redirect(array('action'=>'index',$this->request->data['CourseDrop'][0]['student_id']));
			    }
			  
			
			
		   } else {
		       $this->Session->setFlash('<span></span>'.__('The course drop could not be saved. Please, select one courses to drop.'),'default',array('class'=>'error-box error-message'));
		       $this->redirect(array('action'=>'add',$student_id));
		   }
		}
	   if (!empty($this->request->data) && isset($this->request->data['continue'])) {
	        if (isset($this->request->data['Student']['academicyear'])) {
	           $current_academic_year= $this->request->data['Student']['academicyear'];
	        } else {
	            $current_academic_year= $this->AcademicYear->current_academicyear();  
	        }
	     
	       $student_lists=array();
		   
		   $student_lists=$this->CourseDrop->student_list_registred_but_not_dropped ($this->request->data,
		   $current_academic_year);
		   
		   if(isset($this->request->data['Student']['semseter']) && !empty($this->request->data['Student']['semseter'])) {
		     
			// set the Search data, so the form remembers the option
			$this->request->data['Student']['semester'] = $this->request->data['Student']['semseter'];
		   }
		   
		   if(isset($this->request->data['Student']['department_id']) && !empty($this->request->data['Student']['department_id'])) {
		     
			// set the Search data, so the form remembers the option
			$this->request->data['Student']['department_id'] = $this->request->data['Student']['department_id'];
		   }
		   
		    
		   if(isset($this->request->data['Student']['studentnumber']) && !empty($this->request->data['Student']['studentnumber'])) {
		     
			    // set the Search data, so the form remembers the option
			    $this->request->data['Student']['studentnumber'] = $this->request->data['Student']['studentnumber'];
		   
		   }
		   
		   if (empty($student_lists)) {
		   
			       $this->Session->setFlash('<span></span>'.__('There are no studens who have registered for '.$current_academic_year.' academic year who needs dropping of courses. Either you have already dropped courses for those students, or grade has been submitted. '),'default',array('class'=>'error-box error-message'));
			} else {
			    $semester = $student_lists[0]['CourseRegistration']['semester'];
		        $this->set(compact('semester'));
			    $this->set('student_lists',$student_lists);
			    $this->set(compact('current_academic_year'));
			
			}
			   
	   }
	   if (empty($this->request->data)) {
               $current_academic_year= $this->AcademicYear->current_academicyear();
		
		      $student_lists=array();
		     $this->set('student_lists',$student_lists);
		     
		     $this->set(compact('current_academic_year'));
				
			
        }
		$yearLevels = $this->CourseDrop->YearLevel->find('list');
		
		$departments= $this->CourseDrop->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.id'=>$this->department_ids)));
		
		$this->set(compact('yearLevels','departments','programs'));
	}
	
	
	function mass_drop() {
	  
	    //get list of students and registered courses 
	    if (!empty($this->request->data) && isset($this->request->data['continue'])) {
	           
	       	$everythingfine=false;
		    switch($this->request->data) {
			        case empty($this->request->data['Student']['department_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select department you want to drop courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['academic_year']) :
			         $this->Session->setFlash('<span></span> '.__('Please select academic year you  want to drop courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to drop courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['year_level_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the year level you want to drop courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to drop courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			        
			         default:
			         $everythingfine=true;
			                
		    }
	       // everthing is selected, reterive from the data list of published coures for the selected criteria
	      if ($everythingfine) {
	        
	        $this->__init_search();
			 $equivalent_program_type_id=$this->AcademicYear->equivalent_program_type($this->request->data['Student']['program_type_id']);
			  $publishedCourses=$this->CourseDrop->CourseRegistration->find('all',
			 array('conditions'=>array('CourseRegistration.academic_year LIKE '=>$this->request->data['Student']['academic_year'].'%','CourseRegistration.semester'=>$this->request->data['Student']['semester'],
			 'CourseRegistration.published_course_id=PublishedCourse.id','Student.id NOT IN (select student_id from graduate_lists)'),
			 'contain'=>array('PublishedCourse'=>array(
			    'conditions'=>array('PublishedCourse.academic_year LIKE '=>$this->request->data['Student']['academic_year'].'%','PublishedCourse.drop'=>1,'PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
			    'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
			    'PublishedCourse.program_type_id'=>$equivalent_program_type_id),
			    'fields'=>array('id','year_level_id','semester','program_type_id',
			    'department_id','academic_year','section_id'),
			    'Course'=>array('fields'=>array('id','course_title','course_code',
			    'credit','lecture_hours','tutorial_hours','course_code_title')),
			 ),'Student'=>array('fields'=>array('id','full_name','studentnumber')),
			 'ExamGrade')));
			 $group_courses=array();
			 foreach($publishedCourses as $pk=>$pv){
			     if (!empty($pv['PublishedCourse']['Course'])) {
			         $group_courses[$pv['PublishedCourse']['Course']['id']]=$pv['PublishedCourse']['Course'];
			     }
			 }
			 
			 if (!empty($publishedCourses)) {
			  
			 $list_of_students_registered=array();
			 $list_of_students_registered_organized_by_section=array();
			
			 foreach ($publishedCourses as $k=>$v) {
			          $studentsss=$this->CourseDrop->CourseRegistration->find('all'
			           ,array('conditions'=>array(
			           'CourseRegistration.year_level_id'=>$v['PublishedCourse']['year_level_id'],
			           'CourseRegistration.semester'=>$v['PublishedCourse']['semester'],
			           'CourseRegistration.academic_year LIKE '=>$v['PublishedCourse']['academic_year'].'%',
			           'CourseRegistration.section_id'=>$v['PublishedCourse']['section_id'],
			           'CourseRegistration.published_course_id'=>$v['PublishedCourse']['id'],
			           'CourseRegistration.id NOT IN (select course_registration_id from course_drops)'
			           ),
			           
			           'contain'=>array('ExamGrade','PublishedCourse'=>array('Course'=>array('fields'=>array('id','course_code_title','credit',''))),'Student'=>array('Program','ProgramType','Department',
			           'fields'=>array('id','full_name','studentnumber')))));
			     
		            if (!empty($studentsss)) {
			          
			            // $list_of_students_registered=array_merge($list_of_students_registered,$studentsss);
			            $list_of_students_registered_organized_by_section[$v['PublishedCourse']['section_id']][$v['PublishedCourse']['Course']['course_code_title']]=$studentsss;
		             $list_of_students_registered[$v['PublishedCourse']['Course']['course_code_title']]=$studentsss;
		                $sections_list[]=$v['PublishedCourse']['section_id'];
		              
		            }
			         
	         }
	         
	         //list of students registered for the published courses, unset those courses which 
	         // has already grade submitted.
	                 
	                if (!empty($list_of_students_registered)) {
	                        $sections=$this->CourseDrop->Student->Section->find('list',
	                        array('conditions'=>array('Section.id'=>$sections_list)));
	                        $list_of_students_registered_for_courses=array();
	                         foreach ($list_of_students_registered as $k=>&$v) {
	                                  foreach ($v as $kkk=>$vvv) {
	                                    if (empty($vvv['ExamGrade']) && count($vvv['ExamGrade'])==0) {
	                                       // unset($list_of_students_registered[$k]);
	                                       $list_of_students_registered_for_courses[$k][]=$v[$kkk];
	                                    }
	                                  }
	                         } 
	                        
		                   $this->set('hide_search',true);
		                   $this->set('list_of_students_registered_for_courses',$list_of_students_registered_for_courses);
		                   $this->set(compact('list_of_students_registered','list_of_students_registered_organized_by_section','sections'));
		                   $this->set(compact('publishedCourses','group_courses'));
		            } else {
		              $this->Session->setFlash('<span></span>'.__('There is no students who have been registred for the published courses that need mass drop in the given criteria. Mass drop required department to publish as drop for sections.'),
				                    'default',array('class'=>'error-box error-message'));
		            }
		            
		           
		        } else {
		          
		          $this->Session->setFlash('<span></span>'.__('There is no courses published  for the mass drop for a given  criteria.'),'default',array('class'=>'error-box error-message'));
		           //$this->redirect(array('action'=>'index'));
		        
		        }
		    }
	     
	    }
	     
	      // drop the selected courses
	    if (!empty($this->request->data) && isset($this->request->data['massdrop'])) {
	           
	            //$selected_courses_for_drop=array_sum($this->request->data['CourseDrop']['drop']);
	            if(!empty($this->request->data['CourseDrop']['minute_number'])){
	                $minute_number=$this->request->data['CourseDrop']['minute_number'];
			        unset($this->request->data['CourseDrop']['minute_number']);
			        unset($this->request->data['Student']);
			        $forced=1;
			        //prepare for soft deletion
			        $delete_selected_from_registration=array();
			      
			        //prepare for saveAll
			        if (count($this->request->data['CourseDrop'])>0) {
			            $year_level_id=$this->request->data['CourseDrop'][0]['year_level_id'];
			            $academic_year=$this->request->data['CourseDrop'][0]['academic_year'];
			            $semester=$this->request->data['CourseDrop'][0]['semester'];
			            foreach ($this->request->data['CourseDrop'] as $cd=>&$cv) {
			                    
			                           $cv['academic_year']=$academic_year;
			                           $cv['semester']=$semester;
			                           $cv['year_level_id']=$year_level_id;
			                           $cv['minute_number']=$minute_number;
			                           $cv['forced']=$forced;
			                           $cv['registrar_confirmation']=1;
			                           $cv['department_approval']=1;
			                          // $cv['course_id']=$k;
			             }
			          
			         
			            //check for duplicate entry
			            $already_dropped_courses=array();
			            $selected_courses_drop=array();
			            
			            foreach ($this->request->data['CourseDrop'] as $cdd=>$cdv) {
			                    $major_field=$cdv;
			                    unset($major_field['minute_number']);
			                    unset($major_field['forced']);
			                    $check=$this->CourseDrop->find('count',array('conditions'=>$major_field,'recursive'=>-1));
			                   // debug($cdv);
			                    // already dropped, unset it
			                    if ($check>0) {
			                       $already_dropped_courses[]=$cdv['course_registration_id'];
			                   
			                    } else {
			                        $selected_courses_drop['CourseDrop'][]=$cdv;
			                    }
			            }
			           
			           if (count($already_dropped_courses)==count($this->request->data['CourseDrop'])) {
			                  $this->Session->setFlash('<span></span>'.__('The course for the sections  has already mass dropped to all students registred. You do not need to drop it again.'),'default',array('class'=>'error-box error-message'));
		                     $this->redirect(array('action'=>'index'));
			            } else {
			                  unset($this->request->data);
			                  $this->request->data=$already_dropped_courses;
			            }
			        //saveAll
			       $this->set($this->request->data);
			       
			       if ($this->CourseDrop->saveAll($selected_courses_drop['CourseDrop'],
			       array('validate'=>'first'))) {
				            $this->Session->setFlash('<span></span>The course drop has been saved','default',
				            array('class'=>'success-box success-message'));
				           if($this->Session->delete('search_data_approve')){
				                $this->Session->delete('search_data_approve');
				            }
				            
				            // do hard deletion from course registration
				
				          $this->redirect(array('controller'=>'CourseDrops','action'=>'index'));
			       } else {
				            $this->Session->setFlash('<span></span>'.__('The course drop could not be saved.'),
				            'default',array('class'=>'error-box error-message'));
			          //  $this->request->data['CourseDrop']['drop']=$selected_courses_for_drop;
			       }
			             
			     }
			     
			    } else {
			       $this->Session->setFlash('<span></span>'.__('The mass drop could not be saved. You have to provide minute number.'),
				            'default',array('class'=>'error-box error-message'));
			    
			    }          
	           
	    }
	    
	   if ($this->role_id == ROLE_REGISTRAR) {
	       
		    $yearLevels=$this->CourseDrop->YearLevel->distinct_year_level();
		    $this->set(compact('yearLevels'));
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		     $yearLevels = $this->CourseDrop->YearLevel->find('list',array('conditions'=>array(
		     'YearLevel.department_id'=>$this->department_id)));
		      $this->set(compact('yearLevels'));
		} else {
            $yearLevels = $this->CourseDrop->YearLevel->find('list');
            $this->set(compact('yearLevel'));
		
		}
		
        $departments= $this->CourseDrop->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.id'=>$this->department_ids)));  	
		$programTypes=$this->CourseDrop->CourseRegistration->PublishedCourse->ProgramType->find('list');
		$programs=$this->CourseDrop->CourseRegistration->PublishedCourse->Program->find('list');
	    $this->set(compact('departments','programTypes','programs'));
	}

    function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Student'])){
               
                    $search_session = $this->request->data['Student'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_approve', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data_approve');
        	$this->request->data['Student'] = $search_session;
        } 

    }
	function approve_drops() {
	     $flag=false;
	     if (!empty($this->request->data) && isset($this->request->data['approverejectdrop'])) {
	                $this->set($this->request->data);
	               
	                foreach ($this->request->data['CourseDrop'] as $k=>&$v) {
	                    if ($this->role_id == ROLE_DEPARTMENT || 
	                     $this->role_id == ROLE_COLLEGE) {
	                         if ($v['department_approval'] == '') {
	                            unset($this->request->data['CourseDrop'][$k]);
	                         } else {
	                             $v['department_approved_by']=$this->Auth->user('full_name');
	                         }
	                    } else if ($this->role_id == ROLE_REGISTRAR) {
	                          if ($v['registrar_confirmation'] == '') {
	                            unset($this->request->data['CourseDrop'][$k]);
	                         } else {
	                             $v['registrar_confirmed_by']=$this->Auth->user('full_name');
	                         }
	                        
	                    
	                    }
	                   
	                }
	               
	                if (!empty($this->request->data['CourseDrop'])) {
					  
					    if ($this->CourseDrop->saveAll($this->request->data['CourseDrop'],
					    array('validate'=>'first'))) {
					         if ($this->role_id == ROLE_DEPARTMENT) {
							     $this->Session->setFlash('<span></span>'.__('The course drop has been approved and notified to registrar for confirmation.'), 'default',array('class'=>'success-box success-message'));
							} else if ($this->role_id == ROLE_REGISTRAR) {
							    $this->Session->setFlash('<span></span>'.__('The course drop has confirmed by registrar.'), 'default',array('class'=>'success-box success-message'));
							}
							 $flag=true;
							   // $this->redirect(array('action'=>'approve_drops'));
					    } else {
					  	     $this->Session->setFlash('<span></span>'.__('The course drop approve could not be saved. Please, try again.'),
								     'default',array('class'=>'error-box error-message'));
					    }
					  
					} else {
					    if ($this->role_id == ROLE_REGISTRAR) {
					    $this->Session->setFlash('<span></span>'.__('The course drop could not be saved. You have not confirmed/denay any of the listed requests.'),
								     'default',array('class'=>'error-box error-message'));
					    } else if ($this->role_id == ROLE_DEPARTMENT) {
					        $this->Session->setFlash('<span></span>'.__('The course drop could not be saved. You have not approved any of the listed requests.'),
								     'default',array('class'=>'error-box error-message'));
					    }
					  
					}
	            
	     }
	        //read from session 
	     // Function to load/save search criteria.
               
        if ($this->Session->read('search_data_approve')) {
                       $this->request->data['getdroprequests']=true;
                       $this->request->data['Student']=$this->Session->read('search_data_approve');
                       $this->set('hide_search',true);
                      
        } 
	    
	     if (!empty($this->request->data) && isset($this->request->data['getdroprequests'])) {
			//$this->Session->delete('search_data_registration');
			$everythingfine=false;
			switch($this->request->data) {
			       
			        case empty($this->request->data['Student']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester you want to cancel  course registration.'),'default',array('class'=>'error-box error-message'));  
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
			    
			        $section_organized_published_course=array();
			        $department_id=null;
			        if (!empty($this->request->data['Student']['department_id'])) {
			            $department_id=$this->request->data['Student']['department_id'];
			        } else {
			            $department_id=$this->department_id;
			        }
			        
			        $program_type_id=$this->AcademicYear->equivalent_program_type($this->request->data['Student']['program_type_id']);
				  
			     
			        $sections=$this->CourseDrop->Student->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$department_id,'Section.year_level_id'=>$this->request->data['Student']['year_level_id'],'Section.program_id'=>$this->request->data['Student']['program_id'],'Section.program_type_id'=>$program_type_id,
			        'Section.archive'=>0,
			        )));
			      
			        // query according their roles
			        $this->CourseDrop->Student->bindModel(array('hasMany'=>array('StudentsSection')));
			        if ($this->role_id == ROLE_REGISTRAR) {
			         
			            $courseDrops = $this->CourseDrop->find('all',array('conditions'=>array(
			        'Student.department_id'=>$department_id,'CourseDrop.year_level_id'=>$this->request->data['Student']['year_level_id'],'Student.program_id'=>$this->request->data['Student']['program_id'],'Student.program_type_id'=>$program_type_id,
			        'CourseDrop.semester'=>$this->request->data['Student']['semester'],
			        'CourseDrop.academic_year'=>$this->request->data['Student']['academic_year'],
			        'CourseDrop.department_approval=1',
			        'CourseDrop.registrar_confirmation is null',
			        'Student.id NOT IN (select student_id from graduate_lists)'),
			        'contain'=>array('CourseRegistration',
			        'Student'=>array(
			              'StudentsSection'=>array('conditions'=>array('StudentsSection.archive=0')),
			                         'CourseRegistration'=>array(
			                   'conditions'=>array(
			                      'CourseRegistration.year_level_id'=>$this->request->data['Student']['year_level_id'],
			                      'CourseRegistration.semester'=>$this->request->data['Student']['semester'],
			                      'CourseRegistration.academic_year'=>
			                      $this->request->data['Student']['academic_year']
			              ),
			              'PublishedCourse'=>array('Course'=>array('fields'=>array('course_code', 'course_detail_hours' ,'credit','course_title','course_code')),'fields'=>array('PublishedCourse.id')),
			            'fields'=>array('id')
			            ) 
			            
			                     ,'fields'=>array('id','full_name')
			                )
			             )
			          )
			        );
			       
			        } else {
			        
			        $courseDrops = $this->CourseDrop->find('all',array('conditions'=>array(
			        'Student.department_id'=>$department_id,
			        'CourseDrop.year_level_id'=>$this->request->data['Student']['year_level_id'],
			        'Student.program_id'=>$this->request->data['Student']['program_id'],
			        'Student.program_type_id'=>$program_type_id,
			        'CourseDrop.semester'=>$this->request->data['Student']['semester'],
			        'CourseDrop.academic_year'=>$this->request->data['Student']['academic_year'],
			         'CourseDrop.department_approval is null',
			        'CourseDrop.registrar_confirmation is null',
			      
			        'Student.id NOT IN (select student_id from graduate_lists)'),
			        'contain'=>array('CourseRegistration'=>array(
			   
			              'PublishedCourse'=>array('Course','fields'=>array('PublishedCourse.id')),
			            'fields'=>array('id')
			            ),
			        'Student'=>array(
			              'StudentsSection'=>array('conditions'=>array('StudentsSection.archive=0')),
			              'CourseRegistration'=>array(
			                   'conditions'=>array(
			                      'CourseRegistration.year_level_id'=>$this->request->data['Student']['year_level_id'],
			                      'CourseRegistration.semester'=>$this->request->data['Student']['semester'],
			                      'CourseRegistration.academic_year'=>
			                      $this->request->data['Student']['academic_year']
			              ),
			              'PublishedCourse'=>array('Course'=>array('fields'=>array('course_code', 'course_detail_hours' ,'credit','course_title','course_code')),'fields'=>array('PublishedCourse.id')),
			            'fields'=>array('id')
			            ), 
			            
			                     'fields'=>array('id','full_name')
			                )
			             )
			          )
			        );
			       //debug($courseDrops);
			      
			      }
			      
			        if (empty($courseDrops)) {
			            if ($this->role_id == ROLE_DEPARTMENT) {
			              $this->Session->setFlash('<span></span> '.__('No  students drop request is found in the given criteria.'),'default',array('class'=>'info-box info-message'));  
			              
			              } else if ($this->role_id == ROLE_REGISTRAR) {
			                 $this->Session->setFlash('<span></span> '.__('No drop request is approved by deparment who needs registrar confirmation  in the given  criteria.'),'default',array('class'=>'info-box info-message'));  
			              } else {
			                 $this->Session->setFlash('<span></span> '.__('No drop request is approved by deparment who needs  confirmation  in the given  criteria.'),'default',array('class'=>'info-box info-message'));  
			              }
			        } else {
			              $this->__init_search();
			             foreach ($courseDrops as $pk=>&$pv) {
			                
			                if (array_key_exists($pv['Student']['StudentsSection'][0]['section_id'],
			               $sections)) {
			                  
			                  $pv['Student']['max_load']=$this->CourseDrop->Student->calculateStudentLoad(
			                  $pv['Student']['id'],
			                  $this->request->data['Student']['semester'],
			                  $this->request->data['Student']['academic_year']);
			                 
			                  $section_organized_published_course[$pv['Student']['StudentsSection'][0]['section_id']][]=$pv;
			                }
			                
			            }
			          
			           $this->set('hide_search',true);
			           $this->set('coursesss',$section_organized_published_course);
			           $this->set(compact('sections'));
			        
			        }  
			      
			        $year_level_id=$this->request->data['Student']['year_level_id'];
			        $program_name=$this->CourseDrop->CourseRegistration->PublishedCourse->Program->field('Program.name',array('Program.id'=>$this->request->data['Student']['program_id']));
			        $program_type_name=$this->CourseDrop->CourseRegistration->PublishedCourse->ProgramType->field('ProgramType.name',array('ProgramType.id'=>$this->request->data['Student']['program_type_id']));
			        $academic_year=$this->request->data['Student']['academic_year'];
			        $semester=$this->request->data['Student']['semester'];
			        $department_name=$this->CourseDrop->CourseRegistration->PublishedCourse->Department->field('Department.name',array('Department.id'=>$department_id));
			       
			        $this->set(compact('sections','year_level_id','program_name','program_type_name',
			     'academic_year','semester','department_name'));
			
		   }
	   }
	   if ($this->role_id == ROLE_REGISTRAR) {
	       $department_ids=array();
	       $college_ids = array();
	       
	       if (!empty($this->department_ids)) {
	        $departments= $this->CourseDrop->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.id'=>$this->department_ids))); 
		    } else if (!empty($this->college_ids)) {
		       $departments= $this->CourseDrop->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.college_id'=>$this->college_ids))); 
		    }
		    
		    if (!empty($this->department_ids)) {
	           if (!isset($section_organized_published_course)) {
	            $section_organized_published_course=$this->CourseDrop->list_course_drop_request(
	            $this->role_id,$this->department_ids,$this->AcademicYear->current_academicyear());
	            
	           
	            $sections=$this->CourseDrop->Student->Section->find('list',array('conditions'=>array(
			            'Section.department_id'=>$this->department_id,'Section.archive'=>0,
			            )));
			
			     $coursesss=$section_organized_published_course;
			    if (empty($coursesss) && !$flag) {
			      $this->Session->setFlash('<span></span> '.__('No students drop request has been approved by department and waits your confirmation.'),'default',array('class'=>'info-box info-message'));  
			    }
			     $this->set(compact('sections','coursesss'));    
	           }
		    }
		    if (!empty($this->college_ids)) {
	           if (!isset($section_organized_published_course)) {
	            $section_organized_published_course=$this->CourseDrop->list_course_drop_request(
	            $this->role_id,null,$this->AcademicYear->current_academicyear(),$this->college_ids);
	           
	            $sections=$this->CourseDrop->Student->Section->find('list',array('conditions'=>array(
			            'Section.department_id is null',
			            'Section.college_id'=>$this->college_ids,'Section.archive'=>0,
			            )));
			     $coursesss=$section_organized_published_course;
			    if (empty($coursesss) && !$flag) {
			      $this->Session->setFlash('<span></span> '.__('No students drop request has been approved by department and waits your confirmation.'),'default',array('class'=>'info-box info-message'));  
			    }
			     $this->set(compact('sections','coursesss'));    
	           }
		    }
		       
		
	   } else if ($this->role_id == ROLE_DEPARTMENT)  {
	   
	        if (!isset($section_organized_published_course)) {
	        $section_organized_published_course=$this->CourseDrop->list_course_drop_request(
	        $this->role_id,$this->department_id,$this->AcademicYear->current_academicyear());
	        $sections=$this->CourseDrop->Student->Section->find('list',array('conditions'=>array(
			        'Section.department_id'=>$this->department_id,'Section.archive'=>0,
			        )));
			 
			 $coursesss=$section_organized_published_course;
			 if (empty($coursesss) && !$flag) {
			    $this->Session->setFlash('<span></span> '.__('No students drop request that needs approval.'),'default',array('class'=>'info-box info-message'));  
			              
			 }
			 $this->set(compact('sections','coursesss'));    
	       }
	   } else if($this->role_id == ROLE_COLLEGE) {
            	   $departments= $this->CourseDrop->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.college_id'=>$this->college_id)));	 
		    if (!isset($section_organized_published_course)) {    
                $section_organized_published_course=$this->CourseDrop->list_course_drop_request(
	            $this->role_id,null,$this->AcademicYear->current_academicyear(),$this->college_id);
	           
	            $sections=$this->CourseDrop->Student->Section->find('list',array('conditions'=>array(
			            'Section.department_id is null',
			            'Section.college_id'=>$this->college_id,'Section.archive'=>0,
			            )));
			     $coursesss=$section_organized_published_course;
			     if (empty($coursesss) && !$flag) {
			        $this->Session->setFlash('<span></span> '.__('No students drop request that needs approval.'),'default',array('class'=>'info-box info-message'));  
			                  
			     }
			     $this->set(compact('sections','coursesss'));   
            }
	   } 	
	    if ($this->role_id == ROLE_REGISTRAR) {
	    
		    $yearLevels=$this->CourseDrop->YearLevel->distinct_year_level();
		    $this->set(compact('yearLevels'));
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		     $yearLevels = $this->CourseDrop->YearLevel->find('list',array('conditions'=>array(
		     'YearLevel.department_id'=>$this->department_id)));
		      $this->set(compact('yearLevels'));
		} else {
            $yearLevels = $this->CourseDrop->YearLevel->find('list');
            $this->set(compact('yearLevel'));
		
		}
	   
		$programTypes=$this->CourseDrop->CourseRegistration->PublishedCourse->ProgramType->find('list');
		$programs=$this->CourseDrop->CourseRegistration->PublishedCourse->Program->find('list');
	    $this->set(compact('departments','programTypes','programs'));
	}
	
	
	
	function list_students ($course_id=null) {
	      $this->layout='ajax';
	      //debug($this->request->data);
	       $studentsss=ClassRegistry::init('CourseRegistration')->find('all'
			           ,array('conditions'=>array(
			           'CourseRegistration.year_level_id'=>$this->request->data['CourseDrop'][0]['year_level_id'],
			           'CourseRegistration.semester'=>$this->request->data['CourseDrop'][0]['semester'],
			           'CourseRegistration.academic_year LIKE'=>$this->request->data['CourseDrop'][0]['academic_year'],
			          
			           'CourseRegistration.course_id'=>$course_id,
			           'CourseRegistration.student_id NOT IN (select student_id from graduate_lists)'),
			           
			           'contain'=>array('ExamResult','Course'=>array('fields'=>array('id','course_code_title','credit','')),'Student'=>array('Program','ProgramType','Department',
			           'fields'=>array('id','full_name','studentnumber')))));
		  if (!empty($studentsss)) {
		             $list_of_students_registered_for_courses=array();
	                 foreach ($studentsss as $k=>&$v) {
	                          //foreach ($v as $kkk=>$vvv) {
	                              if (empty($v['ExamResult']) && count($v['ExamResult'])==0) {
	                               // unset($list_of_students_registered[$k]);
	                                $list_of_students_registered_for_courses[]=$v;
	                             }
	                          //}
	                 } 
	                
		           $this->set('hide_search',true);
		           $this->set('studentsss',$list_of_students_registered_for_courses);
		           //$this->set(compact('list_of_students_registered'));
		  }
	
	    //$this->set(compact('studentsss'));
	    
	}
	
	function drop_courses() {
	       $current_academic_year= $this->AcademicYear->current_academicyear();
	        $studentDetails=$this->CourseDrop->Student->find('first',array('conditions'=>array('Student.id'=>$this->student_id),'recursive'=>-1));
	       $student_section_exam_status=$this->CourseDrop->Student->get_student_section(
	       $this->student_id,$current_academic_year);
	       
	       $getRegistrationDeadLine=false;
	      
	        $latestAcSemester= $this->CourseDrop->CourseRegistration->getLastestStudentSemesterAndAcademicYear(
	   $this->student_id,$current_academic_year,1);
	       $semester=$latestAcSemester['semester'];
	      
	        if (!empty($this->department_id)) {
	          $year_level_id = $this->CourseDrop->CourseRegistration->PublishedCourse->YearLevel->field('name',
	          array('id'=>$student_section_exam_status['Section']['year_level_id']));
	          
	        $getRegistrationDeadLine =  $this->CourseDrop->CourseRegistration->AcademicCalendar->check_add_drop_end($current_academic_year,$semester,$this->department_id,
	        $year_level_id,$studentDetails['Student']['program_id'],$studentDetails['Student']['program_type_id']);
	        
	        } else if (!empty($this->college_id)) {
	            
	          $getRegistrationDeadLine =   $this->CourseDrop->CourseRegistration->AcademicCalendar->check_add_drop_end($current_academic_year,$semester,$this->college_id,0,$studentDetails['Student']['program_id'],$studentDetails['Student']['program_type_id']);
	        }
	        
	        if ($getRegistrationDeadLine==0 || $getRegistrationDeadLine==1) {
	          
	        } else {
	                $drop_start_date=$getRegistrationDeadLine;
	                $getRegistrationDeadLine=0;
	                
	        }  
	          
	       if (!$getRegistrationDeadLine) {
	       
	             if(isset($drop_start_date) && !empty($drop_start_date)) {
	                  $this->Session->setFlash('<span></span>'.__('Course Drop starts at '.$drop_start_date.'. You can not drop courses now.'),'default',array('class'=>'info-box info-message'));
	             } else {
	                 $this->Session->setFlash('<span></span>'.__('Course Add/Drop deadline passed. You can not drop courses.'),'default',array('class'=>'info-box info-message'));
	             }
	          
			    $this->redirect(array('controller'=>'courseRegistrations','action'=>'index'));    
	        } else {
			         $detail = $this->CourseDrop->drop_courses_list($this->student_id,$this->AcademicYear->current_academicyear());
	                 $coursesDrop=$detail['courseDrop'];
	                 $student_section_exam_status=$detail['student_basic'];
	                 $already_dropped=$detail['alreadyDropped'];
	                 $semester=$detail['semester'];
	                 if (empty($detail['courseDrop'])) {
                             $this->Session->setFlash('<span></span>'.
				    __('You can not drop courses for semester '.$semester.' of '.
				    $this->AcademicYear->current_academicyear().'
				    .You have to registered for the courses before dropping.', true),
				    'default',
				        array('class'=>'info-box info-message'));
                     }  else {
                                        
                            $this->set(compact('coursesDrop'));
                            $this->set(compact('student_section_exam_status','already_dropped')); 
			                         
                     }    
             
	        
	      }
	      
	      if (!empty($this->request->data)) {
	        $selected=array_sum($this->request->data['CourseRegistration']['drop']);
			
			if ($selected>0) {
			
			$selected_courses_for_drop=$this->request->data['CourseRegistration']['drop'];
			unset($this->request->data['CourseRegistration']['drop']);
			//unset($this->request->data['CourseRegistration']['student_id']);
			$delete_selected_from_registration=array();
			
			foreach ($selected_courses_for_drop as $k=>$v) {
			        if ($v==0) {
			             foreach ($this->request->data['CourseDrop'] as $cr=>$cv) {
			                 if ($cv['course_registration_id']==$k) {
			                   unset($this->request->data['CourseDrop'][$cr]);
			                 } 
			             }
			        }
			 }
			/**if needed to delete from course registration table use deleted_selected_from_registration
			array*/
			 foreach ($this->request->data['CourseDrop'] as $ds=>&$dv) {
			        $delete_selected_from_registration[]=$dv['course_registration_id'];
			       // unset($dv['id']);
			 }
			
			    unset($this->request->data['CourseRegistration']);
			    unset($this->request->data['Student']);
			    $this->CourseDrop->create();
			    $already_dropped_courses=array();
			    $selected_courses_drop=array();
			    foreach ($this->request->data['CourseDrop'] as $cdd=>$cdv) {
			            debug($cdv);
			            $check=$this->CourseDrop->find('count',array('conditions'=>$cdv,'recursive'=>-1));
			            // already dropped, unset it
			            if ($check) {
			               $already_dropped_courses[]=$cdv['course_registration_id'];
			              // unset ($this->request->data['CourseDrop'][$cdd]);
			              
			            } else {
			                $selected_courses_drop['CourseDrop'][]=$cdv;
			            }
			    }
			 
			    //check duplicate dropping
			    if (count($already_dropped_courses)==count($this->request->data['CourseDrop'])) {
			          $this->Session->setFlash('<span></span>'.__('All the selected courses has already dropped. You do not need to drop it again'),'default',array('class'=>'error-box error-message'));
		             //$this->redirect(array('action'=>'index',$this->request->data['CourseDrop'][0]['student_id']));
			    } else {
			          unset($this->request->data);
			          $this->request->data=$already_dropped_courses;
			    }
			    
			    if (!empty($selected_courses_drop['CourseDrop'])) {
			            if ($this->CourseDrop->saveAll($selected_courses_drop['CourseDrop'],array('validate'=>'first'))) {
			        
				        $this->Session->setFlash('<span></span>'.__('The course drop request has been sent to department successfully.'),'default',
				        array('class'=>'success-box success-message'));
				        // do hard deletion from course registration
				
				        $this->redirect(array('controller'=>'course_registrations','action' => 'index'));
			        } else {
				        $this->Session->setFlash('<span></span>'.__('The course drop could not be dropped. Please, try again.'),
				        'default',array('class'=>'error-box error-message'));
			        }
			        
			    } else {
			      $this->Session->setFlash('<span></span>'.__('The selected courses could not be dropped. '),'default',array('class'=>'error-box error-message'));
		             //$this->redirect(array('action'=>'index',$this->request->data['CourseDrop'][0]['student_id']));
			    }
			  
			
			
		   } else {
		       $this->Session->setFlash('<span></span>'.__('The course drop could not be saved. Please, select one courses to drop.'),'default',array('class'=>'error-box error-message'));
		      // $this->redirect(array('action'=>'add',$student_id));
		   }
	    }
	                  
	   	 
	  
	}
	
	function forced_drop () {
	     if (!empty($this->request->data) && isset($this->request->data['continue'])) {
	        if (isset($this->request->data['Student']['academicyear'])) {
	           $current_academic_year= $this->request->data['Student']['academicyear'];
	        } else {
	            $current_academic_year= $this->AcademicYear->current_academicyear();  
	        }
	        
	        if(isset($this->request->data['Student']['semseter']) && 
	        !empty($this->request->data['Student']['semseter'])) { 
	             
			    // set the Search data, so the form remembers the option
			    $this->request->data['Student']['semester'] = $this->request->data['Student']['semseter'];
		    }
		      
		   if(isset($this->request->data['Student']['department_id']) && 
		   !empty($this->request->data['Student']['department_id'])) {
			    // set the Search data, so the form remembers the option
			    $this->request->data['Student']['department_id'] = $this->request->data['Student']['department_id'];
		   }
		   
		    
		   if(isset($this->request->data['Student']['studentnumber']) && 
		   !empty($this->request->data['Student']['studentnumber'])) {
			    // set the Search data, so the form remembers the option
			    $this->request->data['Student']['studentnumber'] = $this->request->data['Student']['studentnumber'];
		   }
		      
	       $student_lists=array();
		   
		   $student_lists=$this->CourseDrop->list_of_students_need_force_drop($this->department_ids,
		   $current_academic_year,$this->request->data['Student']['semester']);
		   
		
		 
		   
		    if (empty($student_lists['list'])) {
		   
			       $this->Session->setFlash('<span></span>'.__('There are no studens who have registered for '.$current_academic_year.' academic year who needs dropping of courses. Either you have already dropped courses for those students, or grade has been submitted. '),'default',array('class'=>'error-box error-message'));
			} else {
			    $this->set(compact('semester'));
			    $latest_academic_year=$current_academic_year;
			    $this->set('student_lists',$student_lists['list']);
			    $this->set(compact('current_academic_year','latest_academic_year'));
			
			}
			
			   
	    } else {
	         $student_lists=$this->CourseDrop->list_of_students_need_force_drop($this->department_ids);
	         $this->set('student_lists',$student_lists['list']);
	    }
	    
	    $departments= $this->CourseDrop->CourseRegistration->PublishedCourse->Department->find('list',array('conditions'=>array(
		'Department.id'=>$this->department_ids)));
		$programs = $this->CourseDrop->Student->Program->find('list');
		$programTypes = $this->CourseDrop->Student->ProgramType->find('list');
		$this->set(compact('yearLevels','departments','programs'));
		
	   
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
	
}
