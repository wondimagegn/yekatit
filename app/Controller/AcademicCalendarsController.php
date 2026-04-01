<?php
class AcademicCalendarsController extends AppController {

    public $name = 'AcademicCalendars';
    public $helpers = array('DatePicker');
    public $menuOptions = array(
            
             'parent' => 'dashboard',
             'exclude' => array('autoSaveExtension'),
             'alias' => array(
                    'index'=>'View All Academic Calendar',
                    'add'=>'Set Academic Calendar',
                    'extending_calendar'=>'Extending Calendar',
            )
     );
     public $paginate = array();    
     public $components =array('EthiopicDateTime','Paginator','AcademicYear');
	
     public function beforeFilter() {
		 parent::beforeFilter();
		 $this->Auth->allow('autoSaveExtension','extending_calendar');
	
     }

     public function beforeRender() {

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

	public function index() {
		$this->AcademicCalendar->recursive = 0;	
		
                
	    $this->paginate = array(
	    'fields'=>array('id','academic_year','semester','full_year',
	    'department_id','year_level_id',
	    'course_registration_start_date',
	    'course_registration_end_date',
	    'course_add_start_date',
	    'course_add_end_date',
	    'course_drop_start_date',
	    'course_drop_end_date',
	    'grade_submission_start_date',
	    'grade_submission_end_date',
	    'grade_fx_submission_end_date',
	    'senate_meeting_date',
	    'graduation_date',
	    'created'),
				'contain'=>array('ExtendingAcademicCalendar'=>array('Department','Program','ProgramType'),'Program'=>array('fields'=>array('id','name')),'ProgramType'=>array('id','name')),
		'order'=>array(
				
				'AcademicCalendar.created'=>'DESC',
				'AcademicCalendar.full_year'=>'DESC',
				
		)
	);
    if (!empty($this->request->data) && 
    isset($this->request->data['viewAcademicCalendar'])) { 
	           
	            $options = array();
			  
	            if (!empty($this->request->data['Search']['program_id'])) {
	               $options[] = array(
	                    'AcademicCalendar.program_id'=>$this->request->data['Search']['program_id']
	               
	                 );
	            }

	            if (!empty($this->request->data['Search']['program_type_id'])) {
	               $options[] = array(
	                    'AcademicCalendar.program_type_id'=>$this->request->data['Search']['program_type_id']
	               
	                 );
	            }
	            
			    if (!empty($this->request->data['Search']['department_id'])) {
	               $options[] = array(
	                  
	                    'AcademicCalendar.department_id like '=>'%s:_:"'.$this->request->data['Search']['department_id'].'"%',
	               
	                 );
	            }

	             if (!empty($this->request->data['Search']['academic_year'])) {
	               $options[] = array(
	                    'AcademicCalendar.academic_year'=>$this->request->data['Search']['academic_year']
	               
	                 );
	            }

	             if (!empty($this->request->data['Search']['semester'])) {
	               $options[] = array(
	                    'AcademicCalendar.semester'=>$this->request->data['Search']['semester']
	               
	                 );
	            }
				
               $this->paginate['conditions']=$options;
               $this->Paginator->settings=$this->paginate;
	           $academicCalendars= $this->Paginator->paginate('AcademicCalendar');  
	          
	          if (empty($academicCalendars)) {
	            $this->Session->setFlash('<span></span>'.
	            __('There is no academic calendar defined in the system in the given criteria.'),
				    'default',array('class'=>'info-box info-message'));
			  }
	     } else {
	     		$this->Paginator->settings=$this->paginate;	  
	     	   $academicCalendars = $this->paginate();
	     }
		
		
		foreach ($academicCalendars as $ack=>&$ackv) {
		     $department_ids=unserialize($ackv['AcademicCalendar']['department_id']);
		     $year_level_ids=unserialize($ackv['AcademicCalendar']['year_level_id']);
		     $found=false;
		     
		     if (in_array("pre",$department_ids,true )) {
		   
		       
		        $ackv['AcademicCalendar']['department_name']=implode(", ",'Pre/Freshman');
		     } 
		     
		       $ackv['AcademicCalendar']['department_name']=implode(", ",$this->AcademicCalendar->Department->find('list',array('conditions'=>array('Department.id'=>$department_ids))));
		     
		     
		      $ackv['AcademicCalendar']['year_name']=implode("\n",$year_level_ids);	
		}

		$departments = $this->AcademicCalendar->Department->find('list');
		$programs = $this->AcademicCalendar->Program->find('list');
		$programTypes = $this->AcademicCalendar->ProgramType->find('list');
		$this->set(compact('departments', 'programs', 'programTypes'));
		$this->set('academicCalendars',$academicCalendars);
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid academic calendar'));
			return $this->redirect(array('action' => 'index'));
		}
		$academicCalendar=$this->AcademicCalendar->read(null, $id);
	$academicCalendar['AcademicCalendar']['college_id']=unserialize($academicCalendar['AcademicCalendar']['college_id']);
			$academicCalendar['AcademicCalendar']['department_id']=unserialize($academicCalendar['AcademicCalendar']['department_id']);
			
			$academicCalendar['AcademicCalendar']['year_level_id']=unserialize($academicCalendar['AcademicCalendar']['year_level_id']);
	
		$academic_calandedr_college_ids=$this->AcademicCalendar->Department->find('list',array('conditions'=>array(
		'Department.id'=>$academicCalendar['AcademicCalendar']['department_id']
		),'fields'=>'college_id'));
		$colleges = $this->AcademicCalendar->College->find('list',array('conditions'=>array(
		'College.id'=>$academic_calandedr_college_ids
		)));
		$college_department=array();
	    foreach($colleges as $college_id => $college_name) {
	      
           
            $departments = $this->AcademicCalendar->Department->find('list', 
            array('fields' => array('id', 'name'),
             'conditions' => array('Department.college_id' => $college_id), 'order' => 'Department.name'));
         
            foreach($departments as $department_id => $departmentname) {
                  if (in_array($department_id,$academicCalendar['AcademicCalendar']['department_id'])) {
                     $college_department[$college_id][$department_id] =  $departmentname;
                  } 
                  
            }
            
        }
      
		$departments = $this->AcademicCalendar->Department->find('list');
		
		$yearLevels = $this->AcademicCalendar->YearLevel->find('list');
		$this->set('academicCalendar', $academicCalendar);
		$this->set(compact('colleges', 'departments', 'yearLevels','college_department'));
	}

    public function add() {
	  if (!empty($this->request->data)) {
		$this->AcademicCalendar->create();
		//debug($this->request->data);
		  if (!empty($this->request->data['AcademicCalendar']['academic_year']) && !empty($this->request->data['AcademicCalendar']['semester'])) {
		  if (!empty($this->request->data['AcademicCalendar']['year_level_id']) && !empty($this->request->data['AcademicCalendar']['department_id'])) {
		         
		           if ($this->AcademicCalendar->check_duplicate_entry($this->request->data)) {		        
			           
			            $departments_id=serialize($this->request->data['AcademicCalendar']['department_id']);
			          
			            $year_level_id=serialize($this->request->data['AcademicCalendar']['year_level_id']);
			            $this->request->data['AcademicCalendar']['department_id']=$departments_id;
			           
			            $this->request->data['AcademicCalendar']['year_level_id']=$year_level_id;
		               //debug($this->request->data);
		                if ($this->AcademicCalendar->save($this->request->data)) {
				            $this->Session->setFlash('<span></span>'.__('The academic calendar has been saved'),
				            'default',array('class'=>'success-box success-message'));
				            $this->redirect(array('action' => 'index'));
			            } else {
				            $this->Session->setFlash('<span></span>'.__('The academic calendar could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				            $this->request->data['AcademicCalendar']['department_id']=unserialize($departments_id);
			           
			                $this->request->data['AcademicCalendar']['year_level_id']=unserialize($year_level_id);  
			              
			            }
	   } else {
		$error=$this->AcademicCalendar->invalidFields();
		if(isset($error['duplicate'])){
		$this->Session->setFlash('<span></span>'.__($error['duplicate'][0].' Those unchecked red marked department has an academic calendar for the given criteria .'),'default',array('class'=>'error-box error-message'));
		}
		$this->set('alreadyexisteddepartment',$error['departmentduplicate']);
		$this->set('alreadyexistedyearlevel',$error['yearlevelduplicate']);
	   } 
	} else {
		if (empty($this->request->data['AcademicCalendar']['year_level_id'])) {
			$this->Session->setFlash('<span></span>'.__('Please select the year level you want to set academic calendar.'),'default',array('class'=>'error-box error-message')); 
		} else if (empty($this->request->data['AcademicCalendar']['deparment_id']) &&
		            empty($this->request->data['AcademicCalendar']['deparment_id']) ) {
		                 $this->Session->setFlash('<span></span>'.__('Please select the department you want to set academic calendar.'),'default',array('class'=>'error-box error-message'));  
		} else {
		 	$this->Session->setFlash('<span></span>'.__('Please select year level and  department you want to set academic calendar.'),'default',array('class'=>'error-box error-message'));	 
		} 
		}
	  } else {
		     $this->Session->setFlash('<span></span>'.__('Please provide academic year and semester.'),'default',array('class'=>'error-box error-message'));
	} 
	}
	$colleges = $this->AcademicCalendar->College->find('list');
	$college_department=array();
	foreach($colleges as $college_id => $college_name) {
		$departments = $this->AcademicCalendar->Department->find('list', array('fields' => array('id', 'name'), 'conditions' => array('Department.college_id' => $college_id), 'order' => 'Department.name'));
             foreach($departments as $department_id => $departmentname) {
                $college_department[$college_id][$department_id] =  $departmentname;
               }
               $college_department[$college_id]['pre_'.$college_id]='Pre/Freshman';
        }
        if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
           	$yearLevels = $this->AcademicCalendar->YearLevel->distinct_year_level();
         
        }
       	$departments = $this->AcademicCalendar->Department->find('list');
	$programs = $this->AcademicCalendar->Program->find('list');
	$programTypes = $this->AcademicCalendar->ProgramType->find('list');
	$this->set(compact('colleges', 'departments', 'programs', 'programTypes', 'yearLevels','college_department','departments_ids'));
	
      }
     
      public function edit($id = null) {
    	
    	
    	if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid academic calendar'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
		     debug($this->request->data);
		     if (!empty($this->request->data['AcademicCalendar']['year_level_id']) && !empty($this->request->data['AcademicCalendar']['department_id'])) {
		        $departments_id=serialize($this->request->data['AcademicCalendar']['department_id']);
			    $year_level_id=serialize($this->request->data['AcademicCalendar']['year_level_id']);
			    $this->request->data['AcademicCalendar']['department_id']=$departments_id;
			    $this->request->data['AcademicCalendar']['year_level_id']=$year_level_id;
			    if ($this->AcademicCalendar->check_duplicate_entry($this->request->data)) {	
			        if ($this->AcademicCalendar->save($this->request->data)) {
				        $this->Session->setFlash('<span></span>'.__('The academic calendar has been updated.'),
				        'default',array('class'=>'success-box success-message'));
				        $this->redirect(array('action' => 'index'));
			        } else {
				        $this->Session->setFlash('<span></span>'.__('The academic calendar could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			        }
			    } else {
			           $error=$this->AcademicCalendar->invalidFields();
			                       
			              if(isset($error['duplicate'])){
			                        $this->Session->setFlash('<span></span>'.__($error['duplicate'][0].' Those unchecked red marked department has an academic calendar for the given criteria .'),
			                                'default',array('class'=>'error-box error-message'));
			              }
			              $this->set('alreadyexisteddepartment',$error['departmentduplicate']);
			              $this->set('alreadyexistedyearlevel',$error['yearlevelduplicate']);
			    }
			    
			 } else {
			      if (empty($this->request->data['AcademicCalendar']['year_level_id'])) {
		                 $this->Session->setFlash('<span></span>'.__('Please select the year level you want to set academic calendar.'),'default',array('class'=>'error-box error-message'));  
		          } else if (empty($this->request->data['AcademicCalendar']['deparment_id']) &&
		            empty($this->request->data['AcademicCalendar']['deparment_id']) ) {
		                 $this->Session->setFlash('<span></span>'.__('Please select the department you want to set academic calendar.'),'default',array('class'=>'error-box error-message'));  
		          } else {
		            $this->Session->setFlash('<span></span>'.__('Please select year level and  department you want to set academic calendar.'),'default',array('class'=>'error-box error-message'));  
		          }
			 }
			    $departments_id=unserialize($this->request->data['AcademicCalendar']['department_id']);
			   // $college_id=unserialize($this->request->data['AcademicCalendar']['college_id']);
			    $year_level_id=unserialize($this->request->data['AcademicCalendar']['year_level_id']);
			    $this->request->data['AcademicCalendar']['department_id']=$departments_id;
			    $this->request->data['AcademicCalendar']['year_level_id']=$year_level_id;
			
		}
	
		
        if (empty($this->request->data)) {
			$this->request->data = $this->AcademicCalendar->read(null, $id);
			$this->request->data['AcademicCalendar']['college_id']=unserialize($this->request->data['AcademicCalendar']['college_id']);
			$this->request->data['AcademicCalendar']['department_id']=unserialize($this->request->data['AcademicCalendar']['department_id']);
			
			$this->request->data['AcademicCalendar']['year_level_id']=unserialize($this->request->data['AcademicCalendar']['year_level_id']);
			
			//$departments_ids = $this->AcademicCalendar->Department->find('list',array('conditions'=>array('Department.id'=>$this->request->data['AcademicCalendar']['department_id'])));
			$departments_ids=$this->department_ids+$this->request->data['AcademicCalendar']['department_id']; 
			$departments_list = $this->AcademicCalendar->Department->find('all',array('conditions'=>array('Department.id'=>$departments_ids),'contain'=>array('College'=>array('id','name'))));
			 
			 debug($departments_list);
		} else {
		  //$departments_ids = $this->AcademicCalendar->Department->find('list',array('conditions'=>array('Department.id'=>$this->request->data['AcademicCalendar']['department_id'])));
		  $departments_ids=$this->department_ids+$this->request->data['AcademicCalendar']['department_id'];
		  $departments_list = $this->AcademicCalendar->Department->find('all',array('conditions'=>array('Department.id'=>$departments_ids),'contain'=>array('College'=>array('id','name'))));
			debug($departments_list);
		}
        if ($this->role_id == ROLE_REGISTRAR) {
           $yearLevels = $this->AcademicCalendar->YearLevel->distinct_year_level(); 
        }
		
		$departments = array();
		foreach($departments_list as $w_key => $dept) {
			
				//$departments[$dept['College']['name']][$dept['Department']['id']] = $dept['Department']['name'];
				$departments[$dept['Department']['id']] =  $dept['Department']['name'];
		}
		debug($departments);
		/*
		foreach ($departments as $college =>&$dept_list) {
		          $college_id=$this->AcademicCalendar->Department->field('college_id',
		          array('Department.id'=>array_keys($dept_list)));
		          $dept_list['pre_'.$college_id]='Pre/Freshman';
		}
	*/
		
		$programs = $this->AcademicCalendar->Program->find('list');
		$programTypes = $this->AcademicCalendar->ProgramType->find('list');
		
		$this->set(compact('colleges', 'departments', 'programs', 'programTypes', 'yearLevels','college_department','departments_ids'));
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for academic calendar'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->AcademicCalendar->delete($id)) {
			$this->Session->setFlash(__('Academic calendar deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Academic calendar was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	
	public function extending_calendar(){
	debug($this->request->data);
	   if(!empty($this->request->data) 
	   && isset($this->request->data['searchbutton'])){
	            $options = array();
			  
	            if (!empty($this->request->data['Search']['program_id'])) {
	               $options[] = array(
	                    'AcademicCalendar.program_id'=>$this->request->data['Search']['program_id']
	               
	                 );
	            }
	            
	            if (!empty($this->request->data['Search']['program_type_id'])) {
	               $options[] = array(
	                    'AcademicCalendar.program_type_id'=>$this->request->data['Search']['program_type_id']
	               
	                 );
	            }
	            
	            if (!empty($this->request->data['Search']['academic_year'])) {
	               $options[] = array(
	                    'AcademicCalendar.academic_year'=>$this->request->data['Search']['academic_year']
	               
	                 );
	            }

	             if (!empty($this->request->data['Search']['semester'])) {
	               $options[] = array(
	                    'AcademicCalendar.semester'=>$this->request->data['Search']['semester']
	               
	                 );
	            }
	            
	           
	           $xacademicCalendars= $this->AcademicCalendar->find('all',array('conditions'=>$options,'contain'=>array('Program','ProgramType')));
	           $academicCalendars=array();
	           foreach($xacademicCalendars as 
	           $acK=>$acV){
	           	$years=unserialize($acV['AcademicCalendar']['year_level_id']);
	           	$departments=unserialize($acV['AcademicCalendar']['department_id']);
	           	$list='';
	            foreach($departments as $deptk=>$deptv){
	            	$list.=' '.$this->AcademicCalendar->Department->field('Department.name',array('Department.id'=>$deptv)).' ';
	            }
	           
	           	$academicCalendars[$list][$acV['AcademicCalendar']['id']]=$acV['AcademicCalendar']['full_year'].' '.$acV['Program']['name'].' '.$acV['ProgramType']['name'];
	           	
	           }
	          
	                                 
	    }
	     if(!empty($this->request->data) 
	   && isset($this->request->data['extend'])){
	        
	        $saveAllExtention=array();
	        $count=0;
	   		foreach($this->request->data['ExtendingAcademicCalendar']['department_id'] as $dk=>$dpv ){
	   		   foreach($this->request->data['ExtendingAcademicCalendar']['year_level_id'] as $yk=>$ylv ){
	   		  
	   		  $saveAllExtention['ExtendingAcademicCalendar'][$count]['academic_calendar_id']=$this->request->data['ExtendingAcademicCalendar']['academic_calendar_id'];
	   		  	
	   		   	       $saveAllExtention['ExtendingAcademicCalendar'][$count]['department_id']=$dpv;
	   		   	       $saveAllExtention['ExtendingAcademicCalendar'][$count]['year_level_id']=$ylv;
	   		   	       $saveAllExtention['ExtendingAcademicCalendar'][$count]['program_id']=$this->request->data['Search']['program_id'];
	   		   	         $saveAllExtention['ExtendingAcademicCalendar'][$count]['program_type_id']=$this->request->data['Search']['program_id'];
	   		   	          $saveAllExtention['ExtendingAcademicCalendar'][$count]['activity_type']=$this->request->data['ExtendingAcademicCalendar']['activity_type'];
	   		   	          
	   		   	        $saveAllExtention['ExtendingAcademicCalendar'][$count]['days']=$this->request->data['ExtendingAcademicCalendar']['days'];
	   		   	    $count++;
	   		      
	   		  }
	   		}
	   	if(isset($saveAllExtention) && !empty($saveAllExtention)){
	   		  if ($this->AcademicCalendar->ExtendingAcademicCalendar->saveAll($saveAllExtention['ExtendingAcademicCalendar'],
	   		array('validate'=>'first'))) {
				    $this->Session->setFlash('<span></span>'.__('The academic calendar extension  has been updated'),'default',array('class'=>'success-box success-message'));
				    $this->redirect(array('action' => 'index'));
			    } else {
				    $this->Session->setFlash('<span></span>'.__('The academic calendar extension could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				$options = array();
			  
	            if (!empty($this->request->data['Search']['program_id'])) {
	               $options[] = array(
	                    'AcademicCalendar.program_id'=>$this->request->data['Search']['program_id']
	               
	                 );
	            }
	            
	            if (!empty($this->request->data['Search']['program_type_id'])) {
	               $options[] = array(
	                    'AcademicCalendar.program_type_id'=>$this->request->data['Search']['program_type_id']
	               
	                 );
	            }
	            
	            if (!empty($this->request->data['Search']['academic_year'])) {
	               $options[] = array(
	                    'AcademicCalendar.academic_year'=>$this->request->data['Search']['academic_year']
	               
	                 );
	            }

	             if (!empty($this->request->data['Search']['semester'])) {
	               $options[] = array(
	                    'AcademicCalendar.semester'=>$this->request->data['Search']['semester']
	               
	                 );
	            }
	            
	           
	           $xacademicCalendars= $this->AcademicCalendar->find('all',array('conditions'=>$options,'contain'=>array('Program','ProgramType')));
	           $academicCalendars=array();
	           foreach($xacademicCalendars as 
	           $acK=>$acV){
	           	$years=unserialize($acV['AcademicCalendar']['year_level_id']);
	           	$departments=unserialize($acV['AcademicCalendar']['department_id']);
	           	$list='';
	            foreach($departments as $deptk=>$deptv){
	            	$list.=' '.$this->AcademicCalendar->Department->field('Department.name',array('Department.id'=>$deptv)).' ';
	            }
	           
	           	$academicCalendars[$list][$acV['AcademicCalendar']['id']]=$acV['AcademicCalendar']['full_year'].' '.$acV['Program']['name'].' '.$acV['ProgramType']['name'];
	           	
	           }
			     
			    }
		 }
	   		//debug($saveAllExtention);
	   }
	   
	    if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
           	$yearLevels = $this->AcademicCalendar->YearLevel->distinct_year_level();
         
        }
       	$departments = $this->AcademicCalendar->Department->find('list');
       	
	    $programs = $this->AcademicCalendar->Program->find('list');
		$programTypes = $this->AcademicCalendar->ProgramType->find('list');
		$activity_types['registration']='Registration';
		$activity_types['add']='Add';
		$activity_types['drop']='Drop';
		$activity_types['grade_submission']='Grade Submission';
		$activity_types['fx_grade_submission']='Fx Grade Submission';
		$activity_types['graduation_date']='Graduation Day';
		$activity_types['senate_meeting']='University Senate Meeting';
		$this->set(compact('departments', 'programs', 'programTypes','yearLevels','activity_types'));
		$this->set('academicCalendars',$academicCalendars);
		
	}
	
	function autoSaveExtension(){
	    $this->autoRender=false;
	    
	    if($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
			 $academicCalendars=array();
	    	 $save_is_ok=true;
	    	 if(isset($this->request->data['ExtendingAcademicCalendar']) && !empty($this->request->data['ExtendingAcademicCalendar'])){
	    	 	foreach($this->request->data['ExtendingAcademicCalendar'] as $ek=>$ev){
	    	 	    $data['ExtendingAcademicCalendar']=$ev;
	    	 	    if(isset($data['ExtendingAcademicCalendar']) && !empty($data['ExtendingAcademicCalendar'])){
				 		$this->AcademicCalendar->ExtendingAcademicCalendar->set($data['ExtendingAcademicCalendar']);
						if ($this->AcademicCalendar->ExtendingAcademicCalendar->save(
						$data)) {
							//debug($data);
						} 
					}
	    	 	}
	    	 }
		}
	}
}
