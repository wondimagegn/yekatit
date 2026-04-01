<?php
App::import('Xml'); 
//App::import('Vendor', 'xmlrpc'); 
App::import('Vendor', 'xmlrpc'); 
class ClearancesController extends AppController {

	var $name = 'Clearances';
    var $menuOptions = array(
                'exclude'=>array('index'),
                 'alias' => array(
                    'index'=>'View Clearance/Withdraw',                 
                    'approve_clearance'=>'Approve Clearance',
                    'add'=>'Clear/Withdraw',
                  
            )
                
    );
     var $components =array('AcademicYear');
     var $helpers = array('Media.Media');
    
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
	
	function beforeFilter () {
	       parent::beforeFilter();
		
	}
    
	function index() {
		$this->Clearance->recursive = 0;
		
		//$this->paginate = array('contain'=>array('Student'=>array('id','full_name')));
		 $this->paginate = array('contain'=>array('Student'=>
        array('fields'=>array('id','program_id','program_type_id','full_name','department_id'),
        'StudentExamStatus'=>array('order'=>
        array('StudentExamStatus.sgpa DESC','StudentExamStatus.cgpa DESC')),'Department'=>array('id','name'),'Program'=>array('id','name'),'ProgramType'=>array('id','name'))));
        
		if (!empty($this->request->data) && isset($this->request->data['viewClearance'])) { 
	              $options = array();
	                if (!empty($this->deparment_ids)) {
		                  if (empty($this->request->data['Search']['department_id'])) {
		                      $options [] = array(
	                                'Student.department_id'=>$this->department_ids);
		                  }
		            
		            } else if (!empty($this->college_ids)) {
		              
		                  if (empty($this->request->data['Search']['college_id'])) {
		                      $options [] = array(
	                                'Student.college_id'=>$this->college_ids,
		                            'Student.department_id is null'
	                               
	                               );
		                  }		            
		            }
		         
	              if (!empty($this->request->data['Search']['department_id'])) {
	               $options [] = array(
	                    'Student.department_id'=>$this->request->data['Search']['department_id']
	               
	                 );
	             }
	            
	             if (!empty($this->request->data['Search']['college_id'])) {
	                   $options[] = array(
	                           
	                            "Student.college_id"=>$this->request->data['Search']['college_id'],
	                             'Student.department_id is null'
	                            
	                            );  
	                            
	              } 
	              if (!empty($this->request->data['Search']['academic_year'])) {
	                      
	                      $options[] = array(
	                           
	                            " YEAR(Clearance.request_date) >=  "=>$this->request->data['Search']['academic_year'].'%'
	                            );  
	              }
	              
	             
	              
	              if (!empty($this->request->data['Search']['program_id'])) {
	                           $options[] = array(
	                               
	                                "Student.program_id "=>$this->request->data['Search']['program_id']
	                           );         
	              }
	              
	              
	              if (!empty($this->request->data['Search']['program_type_id'])) {
	                           $options[] = array(
	                               
	                                "Student.program_type_id "=>$this->request->data['Search']['program_type_id']
	                           );         
	              }
	              
	               if ($this->request->data['Search']['clear']==1 && $this->request->data['Search']['withdrawl']==0) {
	                           $options[] = array(
	                               
	                                "Clearance.type "=>'clearance'
	                           );         
	              }
	              
	               if ($this->request->data['Search']['withdrawl']==1 && $this->request->data['Search']['clear']==0) {
	                           $options[] = array(
	                               
	                                "Clearance.type "=>'withdraw'
	                           );         
	              }
	              
	              $clearances=$this->paginate($options);
	              if(empty($clearances)) {
                    $this->Session->setFlash('<span></span>'.__('There is no clearance   in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	              }
	     } else {
		    if ($this->role_id == ROLE_STUDENT) {
		       $conditions = array (
		            'Clearance.student_id'=>$this->student_id
		       );  
		       $clearances = $this->paginate($conditions);
		      
		    } 
		
		}
		
		$programs = $this->Clearance->Student->Program->find('list');
		if ($this->role_id == ROLE_DEPARTMENT ){
		  $departments = $this->Clearance->Student->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_id)));
		} else if ($this->role_id == ROLE_REGISTRAR) {
		 
		    if (!empty($this->department_ids)) {
		        $departments = $this->Clearance->Student->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_ids)));
		
		   } else if (!empty($this->college_ids)) {
		     
		    $colleges = $this->Clearance->Student->College->find('list',
		array('conditions'=>array('College.id'=>$this->college_ids)));
		
		   }
		
		} else if ($this->role_id == ROLE_COLLEGE) {
		   $departments = $this->Clearance->Student->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->college_id)));
		}
		
		$programTypes = $this->Clearance->Student->ProgramType->find('list');
		$this->set(compact('programs','departments','colleges','programTypes'));
		
		$this->set(compact('clearances')); 
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid clearance'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('clearance', $this->Clearance->read(null, $id));
	}

	function add() {
	//TODO :Attachment in case of withdrawl
		if (!empty($this->request->data)) {
			$this->Clearance->create();
			$this->request->data['Clearance']['student_id']= $this->student_id;
			
			if ($this->Clearance->validateStudentClearance($this->student_id)) {
			    //check if student has received dorm before the clearance date 
			    // returned ?
			    $checkDorm=ClassRegistry::init('DormitoryAssignment')->takeNDormAndReturn($this->student_id,$this->request->data['Clearance']['request_date']); 
			    if ($checkDorm==0) {
			         if ($this->Clearance->checkDuplication($this->request->data)) {
			                
			                /*
	                        $client = new IXR_Client(WIMIS_URL);
                          
                            if (!$client->query('issuedReturned',$this->student_id)) {
                               // Display the result 
                                $taken_properties_from_property_administration['error']='error';
                            } else {
                               
                                 $taken_properties_from_property_administration=$client->getResponse();
                                 
                            
                            }
					*/
                            
                         //   if (count($taken_properties_from_property_administration)==0 && 
                         // !isset($taken_properties_from_property_administration['error'])) {
			              
			               if (true) {     
			                    if ($this->Clearance->saveAll($this->request->data,array('validate'=>'first'))) {
				                    $this->Session->setFlash('<span></span>'.__('The clearance has been send to registrar for approval.'),'default',array('class'=>'success-box success-message'));
				                    $this->redirect(array('action' => 'index'));
			                    } else {
				                    $this->Session->setFlash('<span></span>'.__('The clearance could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                    }
			                } else {
			                    if (isset($taken_properties_from_property_administration['error'])) {
			                        $this->Session->setFlash('<span></span>'.__('The property administration server is busy  could not process your clearance request now.
			                         Please, try again.', true),'default',array('class'=>'error-box error-message'));
			                    } else {
			                           $string='';
			                           $string.='<ul>';

			                           foreach ($taken_properties_from_property_administration as 
			                           $in=>$value) {
			                                $string.='<li>'.$value.'</li>';
			                           }
			                           $string.='</ul>';
			                           $this->Session->setFlash('<span></span>'.__('You can not cleared. You have taken properties from the university, please return the properties and come back for clearance request.'.$string.''),
			                        'default',array('class'=>'error-box error-message'));
			                    }
			                }
			          } else {
			             $this->Session->setFlash('<span></span>'.__('You have already requested clearance for the selected year.'),'default',array('class'=>'error-box error-message'));
			          }
			     } else {
		                $this->Session->setFlash('<span></span>'.__('You can not cleared before returning dormitory.Please return, and come back again.'),'default',array('class'=>'error-box error-message'));
			        
			     }
			    
			} else {
			      $error=$this->Clearance->invalidFields();
			      
			      if(isset($error['not_returned_item'])){
			                $string = '';
			                
			                foreach ($error['not_returned_item'] as $index=>$value) {
			                    $string .= ' From <ul> ';
			                    foreach ($value as $k=>$v) {
			                      $string .= ' <li>'.$k.'<ul>';
			                      foreach ($v as $pk => $pv) {
			                      	  $string .= ' <li> '.$pv.' taken not returned. </li>';
			                      }
			                    	 $string .='</ul> </li>';
			                    }
			                    $string .='</ul>';
			                }
			                
			                $this->Session->setFlash('<span></span>'.__('You can not cleared. You have taken properties from the university, please return the properties and come back for clearance request.'.$string.''),
			                        'default',array('class'=>'error-box error-message'));
			      }
			
			}
		}
		$current_academic_year=$this->AcademicYear->current_academicyear();
		$student_section_exam_status=$this->Clearance->Student->get_student_section($this->student_id,
	        $current_academic_year);
		//$students = $this->Clearance->Student->find('list');
		$this->set(compact('student_section_exam_status'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid clearance'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Clearance->save($this->request->data)) {
				$this->Session->setFlash(__('The clearance has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clearance could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Clearance->read(null, $id);
		}
		$students = $this->Clearance->Student->find('list');
		$this->set(compact('students'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for clearance'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$is_deletion_allowed=$this->Clearance->find('count',array('conditions'=>array('Clearance.id'=>$id,'Clearance.confirmed is null',
		'Clearance.student_id'=>$this->student_id)));
		if ($is_deletion_allowed) {
		        if ($this->Clearance->delete($id)) {
			        $this->Session->setFlash('<span></span>'.__('Clearance request cancelled.'),
			        'default',array('class'=>'success-box success-message'));
			        $this->redirect(array('action'=>'index'));
		        }
		} else {
		  $this->Session->setFlash('<span></span>'.__('Clearance was not deleted since it was processed by registrar.'),
		'default',array('class'=>'error-box error-message'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
	
	function approve_clearance () {
	     
        $this->paginate = array('contain'=>array('Attachment','Student'=>
        array('fields'=>array('id','program_id','program_type_id','full_name','department_id'),
        'StudentExamStatus'=>array('order'=>
        array('StudentExamStatus.created DESC')),'Department'=>array('id','name'),'Program'=>array('id','name'),'ProgramType'=>array('id','name'))));
       
	   if (!empty($this->request->data) && isset($this->request->data['saveIt'])) {
			$this->Clearance->create();
		    foreach ($this->request->data['Clearance'] as $data=>&$value) {
		            $value['acceptance_date']=date('Y-m-d');
		    }
		    
			if ($this->Clearance->saveAll($this->request->data['Clearance'],array('validate'=>'first'))) {
				$this->Session->setFlash('<span></span>'.__('The selected clearance applicant has been approved,and students will be notified.'),'default',
				array('class'=>'success-box success-message'));
				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The clearance could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
			
			
		}
		
	   if (!empty($this->request->data) && isset($this->request->data['filterClearnce'])) { 
	           
	             $options = array();
	             $options[] = array(
	                            "Clearance.confirmed is null" );
	                            
	                if (!empty($this->deparment_ids)) {
		                  if (empty($this->request->data['Search']['department_id'])) {
		                      $options [] = array(
	                                'Student.department_id'=>$this->department_ids);
		                  }
		            
		            } else if (!empty($this->college_ids)) {
		              
		                  if (empty($this->request->data['Search']['college_id'])) {
		                      $options [] = array(
	                                'Student.college_id'=>$this->college_ids,
		                            'Student.department_id is null'
	                               
	                               );
		                  }		            
		            }          
			      if (!empty($this->request->data['Search']['department_id'])) {
	                   $options[] = array(
	                           
	                            "Student.department_id"=>$this->request->data['Search']['department_id']
	                            );  
	              } 
	              if (!empty($this->request->data['Search']['academic_year'])) {
	                      $year=explode('/',$this->request->data['Search']['academic_year']);
	                      $options[] = array(
	                           
	                            " YEAR(Clearance.request_date) >= "=>$year[0].'%'
	                            );  
	              }
	              
	              
	            
	              if (!empty($this->request->data['Search']['program_id'])) {
	                           $options[] = array(
	                               
	                                "Student.program_id "=>$this->request->data['Search']['program_id']
	                           );         
	              }
	              
	              
	              if (!empty($this->request->data['Search']['program_type_id'])) {
	                           $options[] = array(
	                               
	                                "Student.program_type_id "=>$this->request->data['Search']['program_type_id']
	                           );         
	              }
	              
	               if ($this->request->data['Search']['clear']==1 && $this->request->data['Search']['withdrawl']==0) {
	                           $options[] = array(
	                               
	                                "Clearance.type "=>'clearance'
	                           );         
	              }
	              
	               if ($this->request->data['Search']['withdrawl']==1 && $this->request->data['Search']['clear']==0) {
	                           $options[] = array(
	                               
	                                "Clearance.type "=>'withdraw'
	                           );         
	              }
	             
	           $clearances=$this->paginate($options);
	           if(empty($clearances)) {
                    $this->Session->setFlash('<span></span>'.__('There is no clearance request in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	           } else {
	             $clearances=$this->Clearance->organizeListOfClearanceApplicant($clearances);
	           }
	         
	          $this->set('clearances', $clearances);
	          $search=true;
	          $this->set(compact('search'));
	   } else {
	       $options[] = array('OR'=>array("Clearance.confirmed is null",
	       'Clearance.confirmed'=>0));
	       if (!empty($this->department_ids)) {
	          $options[] = array(
	                               
	                                "Student.department_id "=>$this->department_ids
	                           );
	           $clearances=$this->paginate($options);
	         
	            $clearances=$this->Clearance->organizeListOfClearanceApplicant($clearances);
	       } else if (!empty($this->college_ids)) {
	           $options[] = array(
	                               "Student.department_id is null ",
	                                "Student.college_id "=>$this->college_ids
	                           );
	           $clearances=$this->paginate($options);
	           debug($clearances);
	           $clearances=$this->Clearance->organizeListOfClearanceApplicant($clearances);
	       } else {
	        $clearances=array();
	       }
	       $this->set('clearances', $clearances);
	   }
         
		$programs = $this->Clearance->Student->Program->find('list');
		if ($this->role_id == ROLE_DEPARTMENT ){
		  $departments = $this->Clearance->Student->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_id)));
		} else if ($this->role_id == ROLE_REGISTRAR) {
		 
		     if (!empty($this->department_ids)) {
		        $departments = $this->Clearance->Student->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_ids)));
		
		   } else if (!empty($this->college_ids)) {
		     
		    $colleges = $this->Clearance->Student->College->find('list',
		array('conditions'=>array('College.id'=>$this->college_ids)));
		
		   }
		
		} else if ($this->role_id == ROLE_COLLEGE) {
		   $departments = $this->Clearance->Student->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->college_id)));
		}
		
		$programTypes = $this->Clearance->Student->ProgramType->find('list');
		$this->set(compact('programs','departments','colleges','programTypes'));
	}
	
	function withdraw_management () {
	   /* get the list of approved clearnce and allow the registrar to feed proper withdrawl
	    if the student withdraw is approved and accepted by the party show in the 
	    readmission application the decision of the withdrawal
	    */
	    
	    $this->paginate = array('contain'=>array('Student'=>
        array('fields'=>array('id','program_id','program_type_id','studentnumber','full_name','department_id'),
        'StudentExamStatus'=>array('order'=>
        array('StudentExamStatus.sgpa DESC','StudentExamStatus.cgpa DESC')),'Department'=>array('id','name'),'Program'=>array('id','name'),'ProgramType'=>array('id','name'))));
        
      
        
         if (!empty($this->request->data) && isset($this->request->data['saveIt'])) {
			$this->Clearance->create();
		    foreach ($this->request->data['Clearance'] as $in=>&$va) {
			
			       if ($va['forced_withdrawal'] == "") {
			        
			          unset($this->request->data['Clearance'][$in]);
			       }
			}
			if (!empty($this->request->data['Clearance'])) {
			    if ($this->Clearance->saveAll($this->request->data['Clearance'],array('validate'=>'first'))) {
				    $this->Session->setFlash('<span></span>'.__('The selected withdrawal applicant has been approved.'),'default',
				    array('class'=>'success-box success-message'));
				    // if the withdraw is final make the student sectionless 
				    foreach ($this->request->data['Clearance'] as $seindex=>$secvalue) {
				        if ($secvalue['forced_withdrawal']==1) {
				             $this->Clearance->Student->StudentsSection->id=$this->Clearance->
			               Student->StudentsSection->field('StudentsSection.id',
			               array('StudentsSection.student_id'=>
			               $secvalue['student_id'],'StudentsSection.archive'=>0));
			              $this->Clearance->Student->StudentsSection->saveField('archive','1'); 
				        }
				       
				    
				    }
				    
				    
				    //$this->redirect(array('action' => 'index'));
			    } else {
				    $this->Session->setFlash('<span></span>'.__('The withdrawal could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			     $this->request->data['viewWithdrawal']=true;
			    }
			
			} else {
			    $this->Session->setFlash('<span></span>'.__('You have not selected withdrawal student for approval.'),'default',array('class'=>'info-box info-message'));
			    $this->request->data['viewWithdrawal']=true;
			}
			
			
		}
		
		if (!empty($this->department_ids)) {
		       $departments = $this->Clearance->Student->Department->find('list',
		    array('conditions'=>array('Department.id'=>$this->department_ids)));
		       $department_ids = $this->department_ids;
		} else if (!empty($this->college_ids)) {
		     $colleges = $this->Clearance->Student->College->find('list',
		    array('conditions'=>array('College.id'=>$this->college_ids)));
		    $college_ids = $this->college_ids;
		}
		if (!empty($this->request->data) && isset($this->request->data['viewWithdrawal'])) { 
	             $options = array();
	             $options[] = array(
	                               
	                               "Clearance.confirmed "=>1,
	                                "Clearance.type "=>'withdraw',
	                                 "Clearance.forced_withdrawal is null"
	                           );   
	                if (!empty($this->deparment_ids)) {
		                  if (empty($this->request->data['Search']['department_id'])) {
		                      $options [] = array(
	                                'Student.department_id'=>$this->department_ids);
		                  }
		            
		            } else if (!empty($this->college_ids)) {
		              
		                  if (empty($this->request->data['Search']['college_id'])) {
		                      $options [] = array(
	                                'Student.college_id'=>$this->college_ids,
		                            'Student.department_id is null'
	                               
	                               );
		                  }		            
		            } 
	                             
	            if (!empty($this->request->data['Search']['department_id'])) {
	               $options [] = array(
	                    'Student.department_id'=>$this->request->data['Search']['department_id']
	               
	                 );
	             }
	           
	             if (!empty($this->request->data['Search']['college_id'])) {
	                   $options[] = array(
	                            "Student.department_id is null",
	                            "Student.college_id"=>$this->request->data['Search']['college_id']
	                            );  
	              } 
	              
	              if (!empty($this->request->data['Search']['academic_year'])) {
	                  
	                      $year=explode('/',$this->request->data['Search']['academic_year']);
	                     
	                          $options[] = array(
	                           
	                            " YEAR(Clearance.request_date) >= "=>$year[0].'%'
	                            );   
	                   
	                     
	              }
	              
	             
	              
	              if (!empty($this->request->data['Search']['program_id'])) {
	                       
	                      
	                          $options[] = array(
	                               "Student.program_id "=>$this->request->data['Search']['program_id']
	                          );   
	                     
	              
	              }
	              
	              
	              if (!empty($this->request->data['Search']['program_type_id'])) {
	                   
	                     
	                          $options[] = array(
	                               "Student.program_type_id "=>$this->request->data['Search']['program_type_id']
	                          );   
	                       
	              }
	              /*
	               if ($this->request->data['Search']['clear']==1 && $this->request->data['Search']['notcleared']==0) {
	                         
	                     if (isset($this->request->data['Search']['department_id']) && 
	                      empty($this->request->data['Search']['department_id'])) {
	                       
	                           $options[] = array(
	                               
	                                "Clearance.confirmed "=>1,
	                                 "Student.department_id"=>$this->department_ids
	                           );
	                           
	                      } else if (isset($this->request->data['Search']['college_id']) 
	                      && empty($this->request->data['Search']['college_id'])) {
	                            $options[] = array(
	                                 "Student.department_id is null",
	                                 "Clearance.confirmed "=>1,
	                                 "Student.college_id"=>$this->college_ids
	                            );   
	                      } else {
	                          
	                          $options[] = array(
	                                 "Clearance.confirmed "=>1
	                           );   
	                          
	                      }         
	              }
	              
	               if ($this->request->data['Search']['notcleared']==1 && $this->request->data['Search']['clear']==0) {
	                          
	                    if (isset($this->request->data['Search']['department_id']) && 
	                      empty($this->request->data['Search']['department_id'])) {
	                       
	                           $options[] = array(
	                               
	                                "Clearance.confirmed "=>array(0,-1),
	                                "Student.department_id"=>$this->department_ids
	                           );
	                           
	                      } else if (isset($this->request->data['Search']['college_id']) 
	                      && empty($this->request->data['Search']['college_id'])) {
	                            $options[] = array(
	                                 "Student.department_id is null",
	                                "Clearance.confirmed "=>array(0,-1),
	                                 "Student.college_id"=>$this->college_ids
	                            );   
	                      } else {
	                          
	                          $options[] = array(
	                                "Clearance.confirmed "=>array(0,-1),
	                           );   
	                          
	                      }                 
	              }
	              */
	              
	           $clearances=$this->paginate($options);
	           debug($clearances);
	           if(empty($clearances)) {
                    $this->Session->setFlash('<span></span>'.__('There is no withdrawal in the system with in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	           } else {
	             $clearances=$this->Clearance->organizeListOfClearanceApplicant($clearances);
	           }
	         
	          $this->set('clearances', $clearances);
	          $search=true;
	          $this->set(compact('search'));
	     }
		
		$programs = $this->Clearance->Student->Program->find('list');
		
		
		
		$programTypes = $this->Clearance->Student->ProgramType->find('list');
		$this->set(compact('programs','colleges','departments','programTypes'));
		
		$this->set(compact('clearances')); 
	
	}
	
}
