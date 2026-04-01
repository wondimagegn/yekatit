<?php
class CourseSubstitutionRequestsController extends AppController {

	 var $name = 'CourseSubstitutionRequests';
     var $menuOptions = array(
                //'parent' => 'courseRegistrations',
                 'parent' => 'registrations',
                'exclude'=>array('index'),
                 'alias' => array(
                    'list_approved'=>'View Approved Substitution',                 
                    'add'=>'Course Substitution Request',
                  
            )
                
       );
    // var $components =array('AcademicYear', 'Security');
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
	      // this is introduced to protect ajax request break when we used 
	      // security compnent to protect the application from form temparting
	      // crsf
         /* if ($this->request->action == 'get_published_add_courses') { 
                    $this->Security->validatePost = false; 
          } 
          $this->Security->requireAuth('edit','add','delete');
         
		 $this->Security->blackHoleCallback='invalid';
		
	   
		 $this->Auth->Allow('get_published_add_courses','invalid');
		
		 */
		 //security against (primary key) injection, xss or other things
		
	}
	
	function index() {
		  // $this->CourseSubstitutionRequest->recursive = 1;
		   $this->paginate = array('contain'=>array('Student'=>array('Department'),
	    	  'CourseForSubstitued'=> array('Department','Curriculum'),'CourseBeSubstitued'=>array('Department','Curriculum')));
		   $conditions=null;
		   $student_number=null;
		   
		   if (!empty($this->request->data['Student']['studentnumber'])) {
		     $student_number=$this->request->data['Student']['studentnumber'];
		   }
	       if ($this->role_id != ROLE_STUDENT) {
	       
	    	 if ($this->role_id == ROLE_DEPARTMENT)  {
	    	        if (!empty($student_number)) {
	    	             $studentnumber_valide=$this->CourseSubstitutionRequest->Student->find('count',
	    	             array('conditions'=>array('Student.studentnumber LIKE '=>$student_number.'%')));
	    	         
	    	             if ($studentnumber_valide) {
	            	         $conditions = array(
                              
                                 "Student.department_id"=>$this->department_id,
                                 "Student.studentnumber LIKE "=>trim($student_number).'%',
                                'CourseSubstitutionRequest.department_approve is null'
			                );
			             } else {
			                 $this->Session->setFlash('<span></span>'.__('There student number is not valid.'));
			                  $conditions = array(
                                 "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                                 "CourseSubstitutionRequest.request_date >= " => date("Y-m-d",strtotime("-2 day")),
                                 "Student.department_id"=>$this->department_id,
                                "CourseSubstitutionRequest.department_approve_by is null",
			                );
			             }
			        } else {
			             $conditions = array(
                           
                             "Student.department_id"=>$this->department_id,
                             "CourseSubstitutionRequest.department_approve is null"
			            );
			        }
	    	  }
	         
	       }
	       
	       if ($this->role_id == ROLE_STUDENT) {
	          
	         /// $this->paginate = array('contain'=>array('Student'=>array('Department'),'YearLevel','Course'));
	         
	          $conditions = array(
                   
                    "CourseSubstitutionRequest.student_id"=>$this->student_id
			     );
			   
		     
	        }
		//$this->paginate($conditions)
		/*$this->paginate = array('contain'=>array('Student'=>array('Department'),
	    	  'CourseForSubstitued'=> array('Department','Curriculum'),'CourseBeSubstitued'=>array('Department','Curriculum')));
		*/
		$courseSubstitutionRequests=$this->paginate($conditions);
		
		if (empty($courseSubstitutionRequests)) {
		   $this->Session->setFlash('<span></span>'.__('There is no course substitution request.'),
		   'default',array('class'=>'info-box info-message'));
		} else {
		    $this->set('courseSubstitutionRequests',$courseSubstitutionRequests);
		    $search_visible=true;
		    $this->set('search_visible',$search_visible);
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid course substitution request'),'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		
	
		$this->set('courseSubstitutionRequest',$this->CourseSubstitutionRequest->find('first', 
		array('conditions'=>array('CourseSubstitutionRequest.id'=>$id),
		'contain'=>array('Student'=>array('id','full_name'),'CourseForSubstitued',
		'CourseBeSubstitued'))));
	}

	function add() {
		if (!empty($this->request->data)) {
		 
		   //check duplicate entry
		     $compare_with_master_equivalencey=ClassRegistry::init('EquivalentCourse')->find('count',
		     array('conditions'=>array('EquivalentCourse.course_for_substitued_id'=>
		     $this->request->data['CourseSubstitutionRequest']['course_for_substitued_id'],
		     'EquivalentCourse.course_be_substitued_id'=>
		     $this->request->data['CourseSubstitutionRequest']['course_be_substitued_id'])));
		     
		     if ($compare_with_master_equivalencey==0) {
		            //$this->request->data['CourseSubstitutionRequest']=$this->request->data['EquivalentCourse'];
		            $this->request->data['CourseSubstitutionRequest']['student_id']=$this->request->data['EquivalentCourse']['student_id'];
		            
			        $duplicated=$this->CourseSubstitutionRequest->find('count',
			        array('conditions'=>array('CourseSubstitutionRequest.course_be_substitued_id'=>$this->request->data['CourseSubstitutionRequest']['course_be_substitued_id'],
			        'CourseSubstitutionRequest.course_for_substitued_id'=>$this->request->data['CourseSubstitutionRequest']['course_for_substitued_id']
			        ,'CourseSubstitutionRequest.student_id'=>$this->request->data['CourseSubstitutionRequest']['student_id'])));
			
			        if ($duplicated==0) {
			            $this->CourseSubstitutionRequest->create();
			            $this->request->data['CourseSubstitutionRequest']['request_date']=date('Y-m-d');
			          
			            if ($this->CourseSubstitutionRequest->isSimilarCurriculum($this->request->data)) {
			                if ($this->CourseSubstitutionRequest->save($this->request->data)) {
			               
				            $this->Session->setFlash('<span></span>'.__('The course substitution request has been saved'),'default',array('class'=>'success-box success-message'));
				            $this->redirect(array('action' => 'index'));
					        } else {
						        $this->Session->setFlash('<span></span>'.__('The course substitution request could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
						       // $this->request->data=$this->__reformat($this->request->data);
					        }
			            } else {
			            	$error=$this->CourseSubstitutionRequest->invalidFields();
                   
		                     if(isset($error['error'])){
		                        $this->Session->setFlash(__('<span></span>'.$error['error'][0], true),'default',array('class'=>'error-box error-message'));
					        }
			            }
			           
			           
			            
			        } else {
			          $this->Session->setFlash('<span></span>'.__('The course substitution request could not be saved. You have already requested course exemptions for the selected courses.'),'default',
		              array('class'=>'error-box error-message'));
		                $this->redirect(array('action' => 'index'));
			        }
		        } else {
		           $this->Session->setFlash('<span></span>'.__('You dont need to request subtitution for the selected courses, it will be automatically substitued since the department has already mapped the course you selected are equivalent.'),'default',
		              array('class'=>'error-box error-message'));
		        }
		        
		   }
		  $current_academic_year= $this->AcademicYear->current_academicyear();
		  $student_section_exam_status=$this->CourseSubstitutionRequest->Student->get_student_section($this->student_id,
	        $current_academic_year);
	     
		$courseForSubstitueds = $this->CourseSubstitutionRequest->CourseForSubstitued->find('list',
		array('conditions'=>array(
		           'CourseForSubstitued.curriculum_id'=>
		           $student_section_exam_status['StudentBasicInfo']['curriculum_id']
		           ),
		    'fields'=>array('id','course_code','course_title')
		   )
		);
		$previous_substitution_accepted=$this->CourseSubstitutionRequest->find('all',
		array('conditions'=>array('CourseSubstitutionRequest.student_id'=> $student_section_exam_status['StudentBasicInfo']['id'],'CourseSubstitutionRequest.department_approve'=>1)));
		
		//$courseBeSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list');
		$departments=$this->CourseSubstitutionRequest->CourseBeSubstitued->Department->find('all',
		array('fields'=>array('id','name'),
		'contain'=>array('College'=>array('id','name'))));
		$return=array();
		if (!empty($departments)) {
		    foreach($departments as $dep_id=>$dep_name) {
	                $return[$dep_name['College']['name']][$dep_name['Department']['id']]=$dep_name['Department']['name'];	
		    }
		}
		$departments=$return;
		$curriculums=$this->CourseSubstitutionRequest->CourseBeSubstitued->Curriculum->find('list',
		array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array('Curriculum.department_id'=>$this->department_id)));
		
		
		if (empty($this->request->data)) {
		    
		    $courseBeSubstitueds = array(); 
		    $otherCurriculums=array();
		}
		if (empty($this->request->data['CourseSubstitutionRequest']['other_curriculum_id'])) {
		     $otherCurriculums=array();
		}
		if (!empty($this->request->data['CourseSubstitutionRequest']['other_curriculum_id'])) {
		    $other_department_id=$this->CourseSubstitutionRequest->CourseBeSubstitued->Curriculum->field('department_id',array('Curriculum.id'=>$this->request->data['CourseSubstitutionRequest']['other_curriculum_id']));    
		
		   $otherCurriculums=$this->CourseSubstitutionRequest->CourseBeSubstitued->Curriculum->find('list',
		array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array('Curriculum.department_id'=>$other_department_id)));    
		
		}
		if (!empty($this->request->data['CourseSubstitutionRequest']['course_be_substitued_id'])) {
		      $curriculum_id=$this->CourseSubstitutionRequest->CourseBeSubstitued->field('curriculum_id',
		      array('CourseBeSubstitued.id'=>$this->request->data['CourseSubstitutionRequest']['course_be_substitued_id']));
		       
		     $courseBeSubstitueds = $this->CourseSubstitutionRequest->CourseBeSubstitued->find('list',
		array('conditions'=>array('CourseBeSubstitued.curriculum_id'=>$curriculum_id),'fields'=>array('id','course_code','course_title')));
		} else {
		       if (!empty($this->request->data['CourseSubstitutionRequest']['other_curriculum_id'])) {
		            $courseBeSubstitueds = $this->CourseSubstitutionRequest->CourseBeSubstitued->find('list',
		array('conditions'=>array('CourseBeSubstitued.curriculum_id'=>$this->request->data['CourseSubstitutionRequest']['other_curriculum_id']),'fields'=>array('id','course_code','course_title')));
		       }
		}
		
		
		$this->set(compact('courseForSubstitueds', 'courseBeSubstitueds','departments',
		'curriculums','student_section_exam_status','otherCurriculums','previous_substitution_accepted'));
		
		
	}
	
	function __reformat ($data = null) {
            /* 
	       foreach($data['ReturnedItemsList'] as $key => &$returneditem) {
		        $itemSubCategories = $this->ReturnedItem->ReturnedItemsList->Item->ItemSubCategory->getListOfSubCategories($issueditem['item_main_category_id']);
		        $returneditem['itemSubCategories'] = $itemSubCategories;
		        if(isset($returneditem['item_sub_category_id'])) {
			        $items = $this->ReturnedItem->ReturnedItemsList->Item->getListOfItems($returneditem['item_sub_category_id']);
		        }
		        else {
			        $items = array();
		        }
		        
		        if(!empty($itemSubCategories))
			            $returneditem['items'] = $items;
		        else
			            $returneditem['items'] = array();
		
	       }
	      return $data; 
		  */
		  $curriculums=$this->CourseSubstitutionRequest->CourseBeSubstitued->Curriculum->find('list',
		array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array('Curriculum.department_id'=>$data['CourseSubstitutionRequest']['department_id'])));
		
		$courseBeSubstitueds = $this->CourseSubstitutionRequest->CourseBeSubstitued->find('list',
		array('conditions'=>array(
		           'CourseBeSubstitued.curriculum_id'=>
		          $data['CourseSubstitutionRequest']['other_curriculum_id']
		           ),
		    'fields'=>array('id','course_title')
		   )
		);
		
		$data['curriculum']=$curriculums;
		$data['courseBeSubstitued']=$courseBeSubstitueds;
		return $data;
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid course substitution request'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->CourseSubstitutionRequest->save($this->request->data)) {
				$this->Session->setFlash(__('The course substitution request has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course substitution request could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CourseSubstitutionRequest->read(null, $id);
		}
		$courseForSubstitueds = $this->CourseSubstitutionRequest->CourseForSubstitued->find('list',
		array('conditions'=>array(
		           'CourseForSubstitued.curriculum_id'=>
		           $student_section_exam_status['StudentBasicInfo']['curriculum_id']
		           ),
		    'fields'=>array('id','course_title')
		   )
		);
		
		$courseBeSubstitueds = $this->CourseSubstitutionRequest->CourseBeSubstitued->find('list',
		array('fields'=>array('id','course_title')));
		$this->set(compact('students', 'courseForSubstitueds', 'courseBeSubstitueds',
		'student_section_exam_status'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for course substitution request'),'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->CourseSubstitutionRequest->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Course substitution request deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<span></span>'.__('Course substitution request was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	
	function approve_substitution($id=null) {
	     if (!$id) {
	            
	           $this->redirect(array('action' => 'index'));
	     }
	     //check request is their department 
	     
	     $check=$this->CourseSubstitutionRequest->find('count',
	     array('conditions'=>array('CourseSubstitutionRequest.id'=>$id,
	     'Student.department_id'=>$this->department_id)));
	     if($check==0) {
	             $this->Session->setFlash('<span></span>'.__('You are not elegible to approve the selected student course substitution request.'),'default',array('class'=>'error-box error-message')); 
	            $this->redirect(array('action' => 'index'));
	     }
	     
	     if (!empty($this->request->data)) {
	        $this->CourseSubstitutionRequest->id = $id;
            if (!$this->CourseSubstitutionRequest->exists()) {
                $this->Session->setFlash('<span></span>'.__('Invalid course exemption.'),
                'default',array('class'=>'error-box error-message'));
                $this->redirect(array('action' => 'index'));
            }
	        $this->request->data['CourseSubstitutionRequest']['department_approve_by']=$this->Auth->user('full_name');
	        if ($this->CourseSubstitutionRequest->save($this->request->data)) {
	            // if accepted course subtitution  and approved postitive,save it on master
	            // course mapping table.
	           
	            if ($this->request->data['CourseSubstitutionRequest']['department_approve']==1 && !empty($this->request->data['CourseSubstitutionRequest']['department_approve_by'])) {
	                 ClassRegistry::init('EquivalentCourse')->save($this->request->data);
	                $this->Session->setFlash('<span></span>'.__('The course substitution request has been saved and the course mapping will be applicable for all students who have same course substitution request.'),'default',array('class'=>'success-box success-message'));
	               
			     } else {
			       $this->Session->setFlash('<span></span>'.__('The course substitution request has been saved'),'default',array('class'=>'success-box success-message')); 
			     }
			    
				
				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The course substitution request could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
	     }
	     if (empty($this->request->data)) {
	        $this->CourseSubstitutionRequest->id = $id;
            if (!$this->CourseSubstitutionRequest->exists()) {
                $this->Session->setFlash(__('Invalid course substitution.'));
                $this->redirect(array('action' => 'index'));
            }
            
			$this->request->data = $this->CourseSubstitutionRequest->read(null, $id);
		 }
		
		  $current_academic_year= $this->AcademicYear->current_academicyear();
		  $student_section_exam_status=$this->CourseSubstitutionRequest->Student->get_student_section($this->request->data['CourseSubstitutionRequest']['student_id'],
	        $current_academic_year);
		$courseForSubstitueds = $this->CourseSubstitutionRequest->CourseForSubstitued->find('list',
		array('conditions'=>array(
		           'CourseForSubstitued.curriculum_id'=>
		           $student_section_exam_status['StudentBasicInfo']['curriculum_id']
		           ),
		    'fields'=>array('id','course_title')
		   )
		);
		$previous_substitution_accepted=$this->CourseSubstitutionRequest->find('all',
		array('conditions'=>array('CourseSubstitutionRequest.student_id'=>$this->request->data['CourseSubstitutionRequest']['student_id'],'CourseSubstitutionRequest.department_approve'=>1)));
		
		$courseBeSubstitueds = $this->CourseSubstitutionRequest->CourseBeSubstitued->find('list',
		array('fields'=>array('id','course_title')));
		
		$test=$this->CourseSubstitutionRequest->CourseBeSubstitued->find('all',
		array('fields'=>array('id','course_title','course_code'),
		'contain'=>array('Curriculum'=>array('fields'=>
		array('id','name','department_id','year_introduced','program_id'),'Department'=>array('id','name')),'CourseForSubstitued')));
		 foreach ($test as $i=>$value) {
		     $courseBeSubstitueds[$value['CourseBeSubstitued']['id']]=
		     $value['CourseBeSubstitued']['course_title'].'-'.$value['CourseBeSubstitued']['course_code'].'('.$value['Curriculum']['name'].')';
		 }
		
		
		$this->set(compact('students', 'courseForSubstitueds', 'courseBeSubstitueds',
		'student_section_exam_status','previous_substitution_accepted'));
	
	}
	
	function list_approved () {
	       $this->paginate = array('limit'=>200);
	       $this->paginate = array('contain'=>array('Student'=>array('Department'),
	    	  'CourseForSubstitued'=> array('Department','Curriculum'),'CourseBeSubstitued'=>array('Department','Curriculum')));
	      $programs=$this->CourseSubstitutionRequest->Student->Curriculum->Program->find('list');
	       if (!empty($this->request->data['Search']['program_id'])) {
	           $curriculums=$this->CourseSubstitutionRequest->Student->Curriculum->find('list',
		array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array(
		    'Curriculum.department_id'=>$this->department_id,
		    'Curriculum.program_id'=>$this->request->data['Search']['program_id']
		    )));    
	      } else {
	           $curriculums=array();
	      }
	      
	      if (!empty($this->request->data) && isset($this->request->data['viewSubstitution'])) { 
	             $options = array();
	           
                    if (!empty($this->request->data['Search']['curriculum_id'])) {
                         $options [] = array(
                            'CourseForSubstitued.curriculum_id'=>$this->request->data['Search']['curriculum_id']
                       
                         );
                        
                    }
                    
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
	                                  'Student.department_id'=>$this->department_id,
	                                 'OR'=>array(
	                                 "CourseSubstitutionRequest.department_approve"=>1,
	                                 "CourseSubstitutionRequest.department_approve is null ")
	                           );         
	              }
	              
	               if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==1
	               && $this->request->data['Search']['notprocessed']==1) {
	                           $options[] = array(
	                                 'Student.department_id'=>$this->department_id,
	                                 'OR'=>array("CourseSubstitutionRequest.department_approve"=>0,
	                                 "CourseSubstitutionRequest.department_approve is null")
	                           );         
	              }
	              
	              
	              $courseSubstitutionRequests=$this->paginate($options);
	              if(empty($courseSubstitutionRequests)) {
                    $this->Session->setFlash('<span></span>'.__('There is no course substitution request   in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	              }
	     } else {
		    if ($this->role_id == ROLE_STUDENT) {
		       $conditions = array (
		            'CourseSubstitutionRequest.student_id'=>$this->student_id
		       );  
		       $courseSubstitutionRequests = $this->paginate($conditions);
		      
		    } 
		
		}
	      $this->set(compact('programs','curriculums','courseSubstitutionRequests'));
	      
		   /*$conditions=null;
		   $student_number=null;
		   
		   if (!empty($this->request->data['Student']['studentnumber'])) {
		     $student_number=$this->request->data['Student']['studentnumber'];
		   }
	       if ($this->role_id != ROLE_STUDENT) {
	       
	    	 
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
                            "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                            
                            'Student.department_id'=>$department_ids,
                            'CourseSubstitutionRequest.department_approve_by is not null'
                            );
			             
			          } else if (!empty($college_ids)) {
			            $conditions = array(
                            "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                           
                            'Student.college_id'=>$college_ids,
                            "CourseSubstitutionRequest.department_approve_by is not null"
			             );
			          
			          } 
			   
			    
	    	  } else if ($this->role_id == ROLE_DEPARTMENT)  {
	    	        if (!empty($student_number)) {
	    	             $studentnumber_valide=$this->CourseSubstitutionRequest->Student->find('count',
	    	             array('conditions'=>array('Student.studentnumber LIKE '=>$student_number.'%')));
	    	         
	    	             if ($studentnumber_valide) {
	            	         $conditions = array(
                                 "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                                
                                 "Student.department_id"=>$this->department_id,
                                 "Student.studentnumber LIKE "=>trim($student_number).'%',
                                'CourseSubstitutionRequest.department_approve_by is not null'
			                );
			             } else {
			                 $this->Session->setFlash('<span></span>'.__('There student number is not valid.'));
			                  $conditions = array(
                                 "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                               
                                 "Student.department_id"=>$this->department_id,
                                "CourseSubstitutionRequest.department_approve_by is not null",
			                );
			             }
			        } else {
			             $conditions = array(
                             "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                           
                             "Student.department_id"=>$this->department_id,
                             "CourseSubstitutionRequest.department_approve_by is not null"
			            );
			        }
	    	  }
	         
	       }
	       
	       if ($this->role_id == ROLE_STUDENT) {
	          
	         /// $this->paginate = array('contain'=>array('Student'=>array('Department'),'YearLevel','Course'));
	         
	          $conditions = array(
                    "CourseSubstitutionRequest.request_date <= " => date("Y-m-d"),
                    "CourseSubstitutionRequest.request_date >= " => date("Y-m-d",strtotime("-2 day")),
                    "CourseSubstitutionRequest.student_id"=>$this->student_id
			     );
			   
		     
	        }
		//$this->paginate($conditions)
		$courseSubstitutionRequests=$this->paginate($conditions);
		if (empty($courseSubstitutionRequests)) {
		   $this->Session->setFlash('<span></span>'.__('There is no course substitution request.'),
		   'default',array('class'=>'info-box info-message'));
		} else {
		    $this->set('courseSubstitutionRequests',$courseSubstitutionRequests);
		    $search_visible=true;
		    $this->set('search_visible',$search_visible);
		}
       */	
	}
}
