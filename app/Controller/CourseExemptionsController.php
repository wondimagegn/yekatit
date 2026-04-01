<?php
class CourseExemptionsController extends AppController {

	var $name = 'CourseExemptions';
     var $menuOptions = array(
                //'parent' => 'courseRegistrations',
                  'parent' => 'registrations',
                 'exclude'=>array('approve_request','index',
                 	'add_student_exempted_course',
                 	'add_student_exemption'),
                 'alias' => array(
                    'list_exemption_request'=>'Approve Exemption Requests',                 
                    'add'=>'Course Exemption Request',
                    'list_approved'=>'View Exemption'
                   
            )
                
       );
    // var $components =array('AcademicYear', 'Security');
     var $helpers = array('Media.Media');           
   
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
        $this->set(compact('acyear_array_data','defaultacademicyear'));
        unset($this->request->data['User']['password']);
	}
	/**
	* After successful test , this before filter will be applied to all controller
	* in our application to make our application more secure, protecting against form modification,
	* CSRF attacks
	*/
	function beforeFilter () {
	       parent::beforeFilter();
		  $this->Auth->Allow('invalid');
		
		 
		 //security against (primary key) injection, xss or other things
		
	}
	
	function list_exemption_request () {
	     
		   $conditions=array();
	       if ($this->role_id != ROLE_STUDENT) {
	         
	          $this->paginate = array('contain'=>array('Course'=>array('id','course_code_title','credit'),
	          'Student'=>array('fields'=>array('id','full_name','program_id','program_type_id'),'Program'=>array('id','name'),'ProgramType'=>array('id','name'),'Department'=>array('id','name'))),
	          'limit'=>100,'order'=>array('CourseExemption.request_date desc'));
	          
	          
	    	     $department_ids = array();
	    	     if (!empty($this->department_ids)) {
	    	         $department_ids=$this->department_ids;
	    	     } elseif(!empty($this->department_id)) {
	    	        $department_ids=$this->department_id;
	    	     }
	    	     if ($this->role_id == ROLE_DEPARTMENT) {
	        	      $conditions[] = array(
	        	      
                        "CourseExemption.department_accept_reject is null",
                        "Student.department_id"=>$department_ids,
                        
                        
			         );
		           
		         }
		         if ($this->role_id == ROLE_REGISTRAR) {
		            // display only approved exemption
	        	      $conditions[] = array(
                       
                         "Student.department_id "=>$department_ids,
                         "CourseExemption.registrar_confirm_deny is null",
                         "CourseExemption.department_accept_reject"=>1,
                         );
		            
		         }
		        
	       }
	       
	    
	        $courseExemptions=$this->paginate($conditions);
	       
	        if (empty($courseExemptions)) {
	         $this->Session->setFlash('<span></span>'.__('There is no course exemptions requests.'),'default',array('class'=>'info-box info-message')); 
	         
	         }
	
		   $this->set('courseExemptions',$courseExemptions);
	}
	
	function index() {
		   /*
		   $conditions=array();
	       if ($this->role_id != ROLE_STUDENT) {
	          
	          $this->paginate = array('contain'=>array('Course'=>array('id','course_code_title','credit'),
	          'Student'=>array('fields'=>array('id','full_name','program_id','program_type_id'),'Program'=>array('id','name'),'ProgramType'=>array('id','name'),'Department'=>array('id','name'))),
	          'limit'=>100,'order'=>array('CourseExemption.request_date desc'));
	          
	          
	    	     $department_ids = array();
	    	     if (!empty($this->department_ids)) {
	    	         $department_ids=$this->department_ids;
	    	     } elseif(!empty($this->department_id)) {
	    	        $department_ids=$this->department_id;
	    	     }
	    	     if ($this->role_id == ROLE_DEPARTMENT) {
	        	      $conditions[] = array(
	        	      
                        "CourseExemption.department_accept_reject is null",
                        "Student.department_id"=>$department_ids,
                        
                        
			         );
		           
		         }
		         if ($this->role_id == ROLE_REGISTRAR) {
		            // display only approved exemption
	        	      $conditions[] = array(
                        "CourseExemption.request_date <= " => date("Y-m-d"),
                        
                         "Student.department_id "=>$department_ids,
                         "CourseExemption.registrar_confirm_deny is null",
                         "CourseExemption.department_accept_reject"=>1,
                         );
		            
		         }
		        
	       }
	       */
	        if (!empty($this->request->data) && isset($this->request->data['viewExemption'])) { 
	             $options = array();
	           
                    if (!empty($this->request->data['Search']['program_id'])) {
                        $curriculums=$this->CourseSubstitutionRequest->CourseBeSubstitued->
                        Curriculum->find('list',array('fields'=>array('id'),
                        'conditions'=>array('Curriculum.department_id'=>$this->department_id,
                        'Curriculum.program_id'=>$this->request->data['Search']['program_id']))); 
                        if (!empty($options)) {
                                
                        } else {
                        $options [] = array(
                            'CourseForSubstitued.curriculum_id'=>$curriculums
                       
                         );
                       }
                    }
	                
	              ///////////////////////////////////////////////////
	              
	              
	                if ($this->request->data['Search']['rejected']==1 && $this->request->data['Search']['accepted']==0 
	               && $this->request->data['Search']['notprocessed']==0) {
	                           $options[] = array(
	                               
	                                "CourseSubstitutionRequest.department_approve"=>0,
	                                'Student.department_id'=>$this->department_id
	                           );         
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==0) {
	                          $options[] = array(
	                               
	                                "CourseSubstitutionRequest.department_approve=1",
	                                'Student.department_id'=>$this->department_id
	                           );         
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==1) {
	                            $options[] = array(
	                               
	                                "CourseSubstitutionRequest.department_approve is null",
	                                'Student.department_id'=>$this->department_id
	                           );             
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==0) {
	                           
	                            $options[] = array(
	                               
	                                "CourseSubstitutionRequest.department_approve"=>array(0,1),
	                                'Student.department_id'=>$this->department_id
	                           );                 
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==1) {
	                           $options[] = array(
	                               
	                                 'OR'=>array(
	                                 "CourseSubstitutionRequest.department_approve"=>1,
	                                 "CourseSubstitutionRequest.department_approve is null ")
	                           );         
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==1) {
	                           $options[] = array(
	                               
	                                 'OR'=>array("CourseSubstitutionRequest.department_approve"=>0,
	                                 "CourseSubstitutionRequest.department_approve is null")
	                           );         
	              }
	              
	              
	              $courseExemptions=$this->paginate($options);
	              if(empty($courseExemptions)) {
                    $this->Session->setFlash('<span></span>'.__('There is no course exemption request   in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	              }
	     } else {
	       if ($this->role_id == ROLE_STUDENT) {
	          
	          $this->paginate = array('contain'=>array('Course'=>array('id','course_code_title','credit'),
	          'Student'=>array('fields'=>array('id','full_name'),'Department'=>array('id','name'))),
	          'limit'=>100,'order'=>array('CourseExemption.request_date desc'));
	         
	          $options[] = array(
                    "CourseExemption.request_date <= " => date("Y-m-d"),
                   
                    "CourseExemption.student_id"=>$this->student_id
			     );
			   
		     
	        }
	        $courseExemptions=$this->paginate($options);
	     }   
	     
	       
	        if (empty($courseExemptions)) {
	         $this->Session->setFlash('<span></span>'.__('There is no course exemptions requests.'),'default',array('class'=>'info-box info-message')); 
	         
	         }
	
		    $this->set('courseExemptions',$courseExemptions);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid course exemption'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('courseExemption', $this->CourseExemption->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->CourseExemption->create();
			
			//check duplicate entry
			$duplicated=$this->CourseExemption->find('count',array('conditions'=>$this->request->data['CourseExemption']));
			
			if ($duplicated==0) {
			    $this->request->data['CourseExemption']['request_date']=date('Y-m-d');
			   
			    if ($this->CourseExemption->saveAll($this->request->data,array('validate'=>'first'))) {
				    $this->Session->setFlash('<span></span>'.__('The course exemption has been saved'),'default',array('class'=>'success-box success-message'));
				    $this->redirect(array('action' => 'index'));
			    } else {
				    $this->Session->setFlash('<span></span>'.__('The course exemption could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message')); 
			    }
			
		   } else {
		      $this->Session->setFlash('<span></span>'.__('The course exemption could not be saved. You have already requested course exemptions for the selected courses.'),'default',
		      array('class'=>'error-box error-message'));
		        $this->redirect(array('action' => 'index'));
		   }	
		 }
		  $current_academic_year= $this->AcademicYear->current_academicyear();
		  $student_section_exam_status=$this->CourseExemption->Student->get_student_section($this->student_id,
	        $current_academic_year);
	    
		$courses = $this->CourseExemption->Course->find('list',array('conditions'=>array(
		'Course.curriculum_id'=>$student_section_exam_status['StudentBasicInfo']['curriculum_id']),
		'fields'=>array('id','course_code_title')));
		 $previous_exemption_accepted=$this->CourseExemption->find('all',
		    array('conditions'=>array('CourseExemption.student_id'=>$student_section_exam_status['StudentBasicInfo']['id'],'CourseExemption.department_accept_reject'=>1,
		    'CourseExemption.registrar_confirm_deny'=>1,
		    'CourseExemption.department_approve_by is not null')));
		    
		//$students = $this->CourseExemption->Student->find('list');
		$this->set(compact('courses','previous_exemption_accepted','student_section_exam_status'));
	}

	function edit($id = null) {
        $this->CourseExemption->id = $id;
        if (!$this->CourseExemption->exists()) {
            $this->Session->setFlash(__('Invalid course exemption'));
        }
		/*if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid course exemption'));
			return $this->redirect(array('action' => 'index'));
		}
		*/
		
		if (!empty($this->request->data)) {
			if ($this->CourseExemption->save($this->request->data)) {
				$this->Session->setFlash(__('The course exemption has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course exemption could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CourseExemption->read(null, $id);
		}
		$courses = $this->CourseExemption->Course->find('list');
		$students = $this->CourseExemption->Student->find('list');
		$this->set(compact('courses', 'students'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for course exemption'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		// dont allow deletion if the students request is accepted or reject by department
		$is_deletion_allowed=$this->CourseExemption->find('count',array('conditions'=>array('CourseExemption.id'=>$id,"OR"=>array('CourseExemption.department_approve_by is null',
		'CourseExemption.department_approve_by'=>array('')),
		'CourseExemption.student_id'=>$this->student_id)));
		
		if ($is_deletion_allowed>0) {
		    if ($this->CourseExemption->delete($id)) {
			    $this->Session->setFlash('<span></span>'.__('Course exemption request is cancelled.'),'default',array('class'=>'success-box success-message'));
			// $this->redirect(array('action'=>'index'));   
		    } else {
		       $this->Session->setFlash('<span></span>'.__('Course exemption could not be cancelled.Please try again.'));
		    }
		
		} else {
		     $this->Session->setFlash('<span></span>'.__('Course exemption could not be cancelled. 
		     You request has been approved/rejected by your department.', true),'default',
		     array('class'=>'error-box error-message'));
		    
		}
		return $this->redirect(array('action' => 'index'));
		
	}
	function approve_request($id=null) {
	        
	         if (!empty($this->request->data)) {
	             $department_ids = array();
	        	 if (!empty($this->department_ids)) {
	        	         $department_ids=$this->department_ids;
	        	 } elseif(!empty($this->department_id)) {
	        	        $department_ids=$this->department_id;
	        	 }
	             $elgibile_to_approve=$this->CourseExemption->Student->find('count',
	             array('conditions'=>array('Student.department_id'=>$department_ids,
	             'Student.id'=>$this->request->data['CourseExemption']['student_id'])));
	            if ($elgibile_to_approve>0) {
	                if ($this->role_id == ROLE_DEPARTMENT) {
	                    $this->request->data['CourseExemption']['department_approve_by']=
	                    $this->Auth->user('full_name');
	                    
	                } else if ($this->role_id == ROLE_REGISTRAR) {
	                   $this->request->data['CourseExemption']['registrar_approve_by']=
	                    $this->Auth->user('full_name');
	                }
	                if ($this->CourseExemption->save($this->request->data)) {
				        $this->Session->setFlash('<span></span>'.__('The course exemption request has been saved'),'default',array('class'=>'success-box success-message'));
				        //registrar
				        if ($this->role_id == ROLE_REGISTRAR) {
				        $count=$this->CourseExemption->find('count',
				        array('conditions'=>array('Student.department_id'=>$department_ids,
				     'CourseExemption.department_approve_by is not null',"OR"=>array('CourseExemption.registrar_approve_by is null','CourseExemption.registrar_approve_by'=>array('')))));
				       } else {
				          $count=$this->CourseExemption->find('count',
				        array('conditions'=>array('Student.department_id'=>$department_ids,
				     "OR"=>array('CourseExemption.department_approve_by is null','CourseExemption.department_approve_by'=>array('')))));
				       }
				       if ($count==0) {
				            $this->redirect(array('action' => 'list_approved'));
			            } else {
			              $this->redirect(array('action' => 'index'));
			            }
			        } else {
				        $this->Session->setFlash('<span></span>'.__('The course exemption request could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			           $this->request->data = $this->CourseExemption->read(null, $id);
			        }
			    } else {
			      $this->Session->setFlash('<span></span>'.__('You are not elgible to approve the request.'),'default',array('class'=>'error-box error-message'));
			    }
	         }
	         
	         if (empty($this->request->data)) {
			    $this->request->data = $this->CourseExemption->read(null, $id);
		        
		     }
		
		      $current_academic_year= $this->AcademicYear->current_academicyear();
		      $student_section_exam_status=$this->CourseExemption->Student->get_student_section($this->request->data['CourseExemption']['student_id'],
	            $current_academic_year);
		    $courseForSubstitueds = $this->CourseExemption->Course->find('list',
		    array('conditions'=>array(
		               'Course.curriculum_id'=>
		               $student_section_exam_status['StudentBasicInfo']['curriculum_id']
		               ),
		        'fields'=>array('id','course_title')
		       )
		    );
		    $previous_exemption_accepted=$this->CourseExemption->find('all',
		    array('conditions'=>array('CourseExemption.student_id'=>$this->request->data['CourseExemption']['student_id'],'CourseExemption.department_accept_reject'=>1,
		    'CourseExemption.registrar_confirm_deny'=>1,
		    'CourseExemption.department_approve_by is not null')));
		
		    $courses = $this->CourseExemption->Course->find('list',
		    array('fields'=>array('id','course_title')));
		    $this->set(compact('students', 'courses', 
		    'student_section_exam_status','previous_exemption_accepted'));
	
	}
	
	
	function list_approved () {
	        $this->paginate = array('limit'=>200);
		    $options=array();
		     $department_id=array();
	         if ($this->role_id == ROLE_REGISTRAR) {
	                    if (!empty($this->department_ids)) {
	                    $department_id=$this->department_ids;
	                    }
	          } else if ($this->role_id == ROLE_DEPARTMENT ) {
	                    $department_id=$this->department_id;
	          }
		     
		     if (!empty($this->request->data) && isset($this->request->data['viewExemption'])) { 
	              
	              
	               
	                
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
	                     
	              }
	              
	               if (!empty($this->request->data['Search']['year_approved']['year'])) {
	                  
	                     if ($this->role_id == ROLE_REGISTRAR) {
	                          $options[] = array(
                               
                                ' CourseExemption.request_date LIKE '=>'%'.$this->request->data['Search']['year_approved']['year'].'%',
                                'Student.department_id'=>$department_id
                            );
	                                       
	                     } 
	                     
	                    if ($this->role_id == ROLE_DEPARTMENT) {
                             $options[] = array(
                                
                               ' CourseExemption.request_date LIKE '=>'%'.$this->request->data['Search']['year_approved']['year'].'%',
                                'Student.department_id'=>$department_id
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
	             }
	             
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
	             }
	             
	           
	             if (!empty($this->request->data['Student']['studentnumber'])) {
	                if ($this->role_id == ROLE_REGISTRAR) {
	                    $options[] = array(
                           
                            'Student.studentnumber LIKE '=> $this->request->data['Search']['studentnumber'].'%',
                            'Student.department_id'=>$department_id
                              
                        );
                        
	                                   
	                 } else if ($this->role_id == ROLE_DEPARTMENT) {
                         $options[] = array(
                           
                            'Student.studentnumber LIKE '=> $this->request->data['Search']['studentnumber'].'%',
                            'Student.department_id'=>$department_id
                              
                        );
                        
	                 }
	               
	             }
	           
	           
	              
	                if ($this->request->data['Search']['rejected']==1 && $this->request->data['Search']['accepted']==0 
	               && $this->request->data['Search']['notprocessed']==0) {
	                         if ($this->role_id == ROLE_DEPARTMENT) {
	                             $options[] = array(
	                               
	                                "CourseExemption.department_accept_reject"=>0,
	                                'Student.department_id'=>$department_id
	                           );         
	                         }
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                              $options[] = array(
	                               
	                                "CourseExemption.registrar_confirm_deny"=>0,
	                                'Student.department_id'=>$department_id
	                           );         
	                         }
	                          
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==0) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                          $options[] = array(
	                               
	                                "CourseExemption.department_accept_reject"=>1,
	                                'Student.department_id'=>$department_id
	                           );         
	                        }
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                           $options[] = array(
	                               
	                                "CourseExemption.registrar_confirm_deny"=>1,
	                                'Student.department_id'=>$department_id
	                           );      
	                         }
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==0
	               && $this->request->data['Search']['notprocessed']==1) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                            $options[] = array(
	                               
	                                "CourseExemption.department_accept_reject is null",
	                                'Student.department_id'=>$department_id
	                           );
	                        }   
	                        
	                        if ($this->role_id == ROLE_REGISTRAR) {
	                          $options[] = array(
	                               
	                                "CourseExemption.registrar_confirm_deny is null",
	                                'Student.department_id'=>$department_id
	                           );
	                        }              
	                                      
	              }
	              
	               if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==0) {
	                         if ($this->role_id == ROLE_DEPARTMENT) {
	                                
	                            $options[] = array(
	                               
	                                "CourseExemption.department_accept_reject"=>array(0,1),
	                                'Student.department_id'=>$department_id
	                           );                 
	                         }
	                         
	                         if ($this->role_id == ROLE_REGISTRAR) {
	                           $options[] = array(
	                               
	                                "CourseExemption.registrar_confirm_deny"=>array(0,1),
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
	                                 "CourseExemption.department_accept_reject"=>1,
	                                 "CourseExemption.department_accept_reject is null ")
	                           ); 
	                       }
	                       
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                            $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array(
	                                 "CourseExemption.registrar_confirm_deny"=>1,
	                                 "CourseExemption.registrar_confirm_deny is null ")
	                           ); 
	                       }        
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==1) {
	                        if ($this->role_id == ROLE_DEPARTMENT) {
	                           $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseExemption.department_accept_reject"=>0,
	                                 "CourseExemption.department_accept_reject is null")
	                           );
	                           
	                       }
	                       
	                       if ($this->role_id == ROLE_REGISTRAR) {
	                            $options[] = array(
	                                 'Student.department_id'=>$department_id,
	                                 'OR'=>array("CourseExemption.registrar_confirm_deny"=>0,
	                                 "CourseExemption.registrar_confirm_deny is null")
	                           );
	                       }         
	              }
	        
		   }
		   
		    
	      
	       if ($this->role_id == ROLE_STUDENT) {
	       
	              $options[] = array(
                   
                    "CourseExemption.student_id"=>$this->student_id
			     );
			   
			   
		     
	       } else {
	            if (empty($options)) {
	                $options[] = array(
                       
                        "Student.department_id"=>$department_id
			         );
	            }
	                      
	        }
	        
		   /*
		   if (!empty($this->request->data['Student']['studentnumber'])) {
		     $student_number=$this->request->data['Student']['studentnumber'];
		   }
	       if ($this->role_id != ROLE_STUDENT) {
	       
	    	  $this->paginate = array('contain'=>array('Student'=>array('Department'),'Course'));
	    	  if ($this->role_id == ROLE_REGISTRAR) {
	    	      $department_ids=array();
	    	      $college_ids = array();
	    	      
	    	      if (!empty($this->department_ids)) {
	    	         if (!empty($this->request->data['Student']['department_id'])) {
	    	            $department_ids=$this->request->data['Student']['department_id'];
	    	         } else {
	    	            $department_ids=$this->department_ids;
	    	         }
	    	      } else if (!empty($this->college_ids)) {
	    	         $college_ids=$this->college_ids;
	    	         
	    	      } else {
	    	        $department_ids=$this->department_id;
	    	        $college_ids = $this->college_id;
	    	      }
	    	     
	        	      if (!empty($department_ids)) {
	            	      $conditions = array(
                            "CourseExemption.request_date <= " => date("Y-m-d"),
                            
                            'Student.department_id'=>$department_ids     
                        );
			             
			          } else if (!empty($college_ids)) {
			            $conditions = array(
                            "CourseExemption.request_date <= " => date("Y-m-d"),
                           
                            'Student.college_id'=>$college_ids
                            );
			          
			          } 
			   
			    
	    	  } else if ($this->role_id == ROLE_DEPARTMENT)  {
	    	        if (!empty($student_number)) {
	    	             $studentnumber_valide=$this->CourseExemption->Student->find('count',
	    	             array('conditions'=>array('Student.studentnumber LIKE '=>$student_number.'%')));
	    	         
	    	             if ($studentnumber_valide) {
	            	         $conditions = array(
                                 "CourseExemption.request_date <= " => date("Y-m-d"),
                                
                                 "Student.department_id"=>$this->department_id,
                                 "Student.studentnumber LIKE "=>trim($student_number).'%',
                               
			                );
			             } else {
			                 $this->Session->setFlash('<span></span>'.__('There student number is not valid.'));
			                  $conditions = array(
                                 "CourseExemption.request_date <= " => date("Y-m-d"),
                               
                                 "Student.department_id"=>$this->department_id
			                );
			             }
			        } else {
			             $conditions = array(
                             "CourseExemption.request_date <= " => date("Y-m-d"),
                           
                             "Student.department_id"=>$this->department_id                             
			            );
			        }
	    	  }
	         
	       }
	       
	       if ($this->role_id == ROLE_STUDENT) {
	       
	          $conditions = array(
                    "CourseExemption.request_date <= " => date("Y-m-d"),
                   
                    "CourseExemption.student_id"=>$this->student_id
			     );
			   
		     
	        }
	        */
		//$this->paginate($conditions)
		$courseExemptions=$this->paginate($options);
		if (empty($courseExemptions)) {
		   $this->Session->setFlash('<span></span>'.__('There is no approved course exemptions request.'),'default',array('class'=>'info-box info-message'));
		} else {
		    $this->set('courseExemptions',$courseExemptions);
		    $search_visible=true;
		    $this->set('search_visible',$search_visible);
		}
		
		if ($this->role_id == ROLE_REGISTRAR) {
		      if (!empty($this->department_ids)) {
		              $departments = $this->CourseExemption->Student->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_ids)));
		      }
		      
		}
		
		
		if ($this->role_id == ROLE_DEPARTMENT) {
		      if (!empty($this->department_id)) {
		              $departments = $this->CourseExemption->Student->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_id)));
		      }
		      
		}
		$programs= $this->CourseExemption->Student->Program->find('list');
		$programTypes=$this->CourseExemption->Student->ProgramType->find('list');
		
	    $this->set(compact('departments','programs','programTypes'));
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
     
        public function add_student_exempted_course($student_id)
        {
		$this->layout='ajax';
        $student_detail=$this->CourseExemption->Student->find('first',
array('conditions'=>array('Student.id'=>$student_id),'contain'=>array('AcceptedStudent')));
		
		$courses=$this->CourseExemption->Course->find('list',
array('conditions'=>array('Course.curriculum_id'=>$student_detail['Student']['curriculum_id']),'fields'=>array('id','course_title')));
       $exemptedCourseLists = $this->CourseExemption->find('all', 
				array('conditions'=>array('CourseExemption.student_id'=>$student_id),'recursive'=>-1));
		
        $this->set(compact('sectionOrganized','student_detail',
'courses','exemptedCourseLists'));
	}

	
	public function add_student_exemption()
       {
		
	if(!empty($this->request->data)) 
	{
             if(!empty($this->request->data['CourseExemption'])) {
		 $formattedCourseExemption=array();
		 $count=0;
		 reset($this->request->data['CourseExemption']);
		
		 $student_id=$this->request->data['CourseExemption']
[0]['student_id']; 
         $transfer_from=
         $this->request->data['CourseExemption']
[0]['transfer_from'];         
         $allExemptedIds=$this->CourseExemption->find('list',array('conditions'=>array('CourseExemption.student_id'=>$student_id),
            	'recursive'=>-1,'fields'=>array('CourseExemption.id','CourseExemption.id')));
		 debug($this->request->data);
		 foreach($this->request->data['CourseExemption'] as $k=>$v) {
			if(isset($student_id) && isset($v['course_id'])) {
			   if(!empty($formattedCourseExemption['CourseExemption'][$count]['id'])){
				   $formattedCourseExemption['CourseExemption'][$count]['id']=$v['id'];
				   unset($allExemptedIds[$v['id']]);
		            }
			   $formattedCourseExemption['CourseExemption'][$count]['request_date']=date('Y-m-d h:i:s');
$formattedCourseExemption['CourseExemption'][$count]['reason']='data entry via registrar';
$formattedCourseExemption['CourseExemption'][$count]['taken_course_title']=$v['taken_course_title'];
$formattedCourseExemption['CourseExemption'][$count]['taken_course_code']=$v['taken_course_code'];
$formattedCourseExemption['CourseExemption'][$count]['course_taken_credit']=$v['course_taken_credit'];

$formattedCourseExemption['CourseExemption'][$count]['department_accept_reject']=1;


$formattedCourseExemption['CourseExemption'][$count]['department_reason']='data entry via registrar';

$formattedCourseExemption['CourseExemption'][$count]['registrar_confirm_deny']=1;

$formattedCourseExemption['CourseExemption'][$count]['registrar_reason']='data entry via registrar';

$formattedCourseExemption['CourseExemption'][$count]['department_approve_by']=$this->Auth->user('full_name');

$formattedCourseExemption['CourseExemption'][$count]['registrar_approve_by']=$this->Auth->user('full_name');

$formattedCourseExemption['CourseExemption']
[$count]['course_id']=$v['course_id'];
$formattedCourseExemption['CourseExemption'][$count]['student_id']=$student_id;
$formattedCourseExemption['CourseExemption'][$count]['transfer_from']=$transfer_from;


	$count++;
			}
		}

			if(!empty($allExemptedIds)){
				if($this->CourseExemption->deleteAll(
				array('CourseExemption.id'=>$allExemptedIds), false)) {

				}	
			}
                        debug($formattedCourseExemption);
			if(!empty($formattedCourseExemption)) {
				if ($this->CourseExemption->saveAll($formattedCourseExemption['CourseExemption'],array('validate'=>'first'))) {
				$this->Session->setFlash('<span></span>'.__('The course exemption has been saved'),'default',array('class'=>'success-box success-message'));
				} else {

				$this->Session->setFlash(__('<span></span>The exempted courses lists coudnt be saved. Please, try again.',true),'default',array('class'=>'error-box error-message'));
				}
			}
                
		} else {
               	$this->Session->setFlash(__('<span></span>The exempted courses lists coudnt be saved. Please, try again.',true),'default',array('class'=>'error-box error-message'));
             
		 }
		}
		
		$this->redirect(array('controller'=>'students','action' => 'student_academic_profile',$this->request->data['CourseExemption'][0]['student_id']));
		
	}


}
