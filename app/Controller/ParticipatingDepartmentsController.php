<?php
class ParticipatingDepartmentsController extends AppController {

	var $name = 'ParticipatingDepartments';
    var $menuOptions = array(
             'parent' => 'quotas',         
             'exclude' => array('get_summeries', 'index'),
			 'alias' => array(
                    'index' => 'List Participating Departments',
                    'add' => 'Add Participating Departments',
                    'add_quota' => 'Add/Edit Department Quota' 
            )
    );
    var $paginate = array(
        'ParticipatingDepartment' => array(
            'limit' => 100,
            'order' => array(
                'ParticipatingDepartment.department_id' => 'asc',
            ),
        ));
    var $components = array('AcademicYear');
     function beforeFilter(){
         parent::beforeFilter();
         $this->Auth->Allow('participating_departments','get_summeries','getParticipatingDepartment');
     }
    function beforeRender() {
		$acyear_array_data = $this->AcademicYear->acyear_array();
        //To diplay current academic year as default in drop down list
        $selected=$this->AcademicYear->current_academicyear();
        /*
        foreach($acyear_array_data as $k=>$v){
                if($v==$selected){
                $selected=$k;
                    break;
                }
        }
        */
        $this->set(compact('acyear_array_data','selected'));
	}
	function index() {
	/*
		$this->ParticipatingDepartment->recursive = 0;
		$conditions = array ('ParticipatingDepartment.academic_year LIKE '=> $this->AcademicYear->current_academicyear().'%','ParticipatingDepartment.college_id'=>$this->college_id);
		$participatingDepartment=$this->paginate($conditions);
		if (empty($participatingDepartment)) {
			$this->Session->setFlash('<span></span>'.__('Please add  auto placment participationg 
			department of '.$this->AcademicYear->current_academicyear().' academic year.', true),'default',
			array('class'=>'info-box info-message'));
			$this->redirect (array('action'=>'add'));
		} 
		$this->set('participatingDepartments',$participatingDepartment);
	  */  
	    $this->redirect(array('action'=>'add_quota'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid participating department'),'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('participatingDepartment', $this->ParticipatingDepartment->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
		   $this->ParticipatingDepartment->create();
		  
		   $reformatparticipatingdepartments=array();
		  if(!empty($this->request->data['ParticipatingDepartment']['academic_year'])){
		  
		   if(!empty($this->request->data['ParticipatingDepartment']['department_id'])){
		          
		           foreach($this->request->data['ParticipatingDepartment']['department_id'] as $k=>$v){
		                if(!empty($v)){
		                $reformatparticipatingdepartments['ParticipatingDepartment'][$k]['id']=null;
			                      $reformatparticipatingdepartments['ParticipatingDepartment']
			            [$k]['academic_year']=$this->request->data['ParticipatingDepartment']['academic_year'];
			             $reformatparticipatingdepartments['ParticipatingDepartment']
			            [$k]['department_id']=$v;
			             $reformatparticipatingdepartments['ParticipatingDepartment']
			            [$k]['college_id']=$this->college_id;
		                    $check=$this->ParticipatingDepartment->checkIfOtherCollege($v,$this->college_id);
		                    if(!$check){	                         
			                     $reformatparticipatingdepartments['ParticipatingDepartment']
			                    [$k]['other_college_department']=1;
			                     /* $reformatparticipatingdepartments['ParticipatingDepartment']
			                    [$k]['number']=$this->request->data['ParticipatingDepartment']['number'];
		                        */
		                    }
		                
			           
		                }
		        }
		        
		     
			    $this->set($this->request->data);
			    if($this->ParticipatingDepartment->validates()){
		                //check participating department has already recorded
		                $academic_year =$this->request->data['ParticipatingDepartment']['academic_year'];
		                $this->set(compact('academic_year'));
		                if($this->ParticipatingDepartment->isAlreadyRecordedParticipationgDepartments(
		                $this->college_id,
		                $this->request->data['ParticipatingDepartment']['academic_year'],$reformatparticipatingdepartments)){
		                     /* SaveAll departments participating in the college placement. It is possible to save
		                the id of others department under the given department*/
		                  
		                  $reformatparticipatingdepartments=$this->ParticipatingDepartment->isAlreadyRecordedParticipationgDepartments(
		                $this->college_id,
		                $this->request->data['ParticipatingDepartment']['academic_year'],$reformatparticipatingdepartments);
		                  //debug($reformatparticipatingdepartments);
			              if($this->ParticipatingDepartment->saveAll($reformatparticipatingdepartments['ParticipatingDepartment'])) {
				            $this->Session->setFlash('<span></span>'.__('The participating department has been saved'),'default',array('class'=>'success-box success-message'));
				            $this->redirect(array('action' => 'add_quota'));
			              } else {
			                $error=$this->ParticipatingDepartment->invalidFields();
			               
				            $this->Session->setFlash('<span></span>'.__('The participating department could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			              }
			             
			
			            } else {
			             $error=$this->ParticipatingDepartment->invalidFields();
			           
			             if(isset($error['alreadyrecorded'])){
			                $this->Session->setFlash(__('<span></span>'.$error['alreadyrecorded'][0]),
			                'default', array('class' => 'error-box error-message'));
			             } 
			             
			               // $this->redirect(array('action' => 'index'));
			            }
		                  
		              
		           }
		    } else {
		            
		             $this->Session->setFlash(__('<span></span>Select atleast one  participating department '),'default',array('class'=>'error-box error-message'));
		           // $this->redirect(array('action' => 'index'));
		               
		   }
		   $turn_off_button=true;
		   $this->set(compact('check_auto_placement_already_run_not_allow_adding_or_edit',
		   'turn_off_button'));        
	     } else {
	     
	        $this->Session->setFlash(__('<span></span>Select Academic Year.'),'default',array('class'=>'error-box error-message'));
		           // $this->redirect(array('action' => 'index'));
	     }
			
		}
		
		$colleges = $this->ParticipatingDepartment->College->find('list',
		    array('conditions'=>array('College.id <> '=>$this->college_id)));
		
		$departments = $this->ParticipatingDepartment->Department->find('list',
		array('conditions'=>array('Department.college_id '=>$this->college_id)));
		$othersdepartments=$this->ParticipatingDepartment->College->Department->find('list',
		array('conditions'=>array('Department.college_id <> '=>$this->college_id),
		'fields'=>array('id','name','college_id')));
		$otherdep=array();
		
	    if (!empty($othersdepartments)) {
		    foreach ($colleges as $k => $v){
		        
		        foreach($othersdepartments as $key=>$value){
		                if($key==$k){
		                    
		                    $otherdep[$v]=$value;
		                }        
		        }
		        
		    }
        }
		$totalstudents=$this->__totalstudnets($this->college_id);
		//debug($totalstudents);
		$academic_year = $this->AcademicYear->current_academicyear();
	    $this->set(compact('academic_year'));
		$this->set(compact('colleges', 'departments','totalstudents','otherdep'));
	}

	function edit($id = null) {
	
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid participating department'),'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
		
		    $this->set($this->request->data);
		    if($this->ParticipatingDepartment->validates()){
		        if($this->ParticipatingDepartment->canEditOwn($this->college_id,$id)){
		         
		           if($this->ParticipatingDepartment->checkAgainstAvailableStudentFromOtherCollege($this->request->data['ParticipatingDepartment'])){
		           
		           if(
		             $this->ParticipatingDepartment->checkDepartmentCapacityBeforeEditing(
		             $this->request->data['ParticipatingDepartment'],
		                $this->college_id,
		                $this->request->data['ParticipatingDepartment']['academic_year'])){
		           
			            if ($this->ParticipatingDepartment->save($this->request->data)) {
				            $this->Session->setFlash('<span></span>'.__('The participating department 
				            has been updated', true),'default',array('class'=>'error-box error-message'));
				            $this->redirect(array('action' => 'index'));
			            } else {
				            $this->Session->setFlash('<span></span>'.__('The participating department 
				            could not be saved. Please, try again.', true),'default',
				            array('class'=>'error-box error-message'));
			            }
			          } else {
			          
			             $error=$this->ParticipatingDepartment->invalidFields();
			           
			             if(isset($error['DepartmentCapacity'])){
			                $this->Session->setFlash(__('<span></span>'.$error['DepartmentCapacity'][0]),
			                'default',array('class'=>'error-box error-message'));
			             }
			          }
			      } else {
			        $this->Session->setFlash('<span></span>'.__('The total number of students for other college is less than the number of students you want to participate for placement in your college. Please, reduce the number.'),'default',array('class'=>'error-box error-message'));
			      }
			    } else {
			       $this->Session->setFlash('<span></span>'.__('You are not allowed to edit others 
			       college data.', true),'default',array('class'=>'error-box error-message'));			        
			    }
			 } else {
			        $this->Session->setFlash('<span></span>'.__('Validation Error. Please fill 
			        the required field.', true),'default',array('class'=>'error-box error-message'));
			 
			 }
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->ParticipatingDepartment->read(null, $id);
			//debug($this->request->data);
			
		}
		$colleges = $this->ParticipatingDepartment->College->find('list',
		array('conditions'=>array('College.id'=>$this->request->data['ParticipatingDepartment']['college_id'])));
		$other_college_department=$this->ParticipatingDepartment->find('first', 
		array('conditions'=>array('ParticipatingDepartment.id'=>$id)));
		$others_college_id=null;
		if(!empty($other_college_department['ParticipatingDepartment']['other_college_department'])){
		    $this->request->data['ParticipatingDepartment']['other_college_department']=$other_college_department['ParticipatingDepartment']['other_college_department'];
		   $findcollege=$this->ParticipatingDepartment->Department->find('first',array('conditions'=>array('
	            Department.id'=>$other_college_department['ParticipatingDepartment']['department_id']),'contain'=>array(
	                                        'College'=>array(
	                                            'fields'=>array(
	                                                'id',
	                                                'name')
	                                           )
	                                          )
	                                       )
	                                      
	                                     );
	        if(!empty($findcollege['College']['id'])){
	        $others_college_id=$findcollege['College']['id'];
		    }
		}
		if(!empty($others_college_id)){
		   
		    $departments = $this->ParticipatingDepartment->Department->find('list',
		    array('conditions'=>array('Department.college_id'=>array($this->college_id,
		    $others_college_id))));
		    //debug($departments);
	         $this->set(compact('departments'));
	    } else {
	         $departments = $this->ParticipatingDepartment->Department->find('list',
		    array('conditions'=>array('Department.college_id'=>$this->college_id)));
		    $this->set(compact('departments'));
	    }
		$this->set(compact('colleges'));
	}

	function delete($id = null,$action_model_id=null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for participating department'),'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		//check auto has already run 
       
		$related_reserved_place = $this->ParticipatingDepartment->read(null, $id);
		$this->loadModel('PlacementLock');
        $auto_run=$this->PlacementLock->find('count',array('conditions'=>array(
         'PlacementLock.college_id'=>$this->college_id,'PlacementLock.academic_year'=>$related_reserved_place['ParticipatingDepartment']['academic_year'],'PlacementLock.process_start'=>1))); 
        if($auto_run){
             $this->Session->setFlash('<span></span>'.__('The auto placement is up and running you can not delete the participationg department right now, please come back after you cancelled the auto placement.'),'default',array('class'=>'error-box error-message'));
              if (!empty($action_model_id)) {
	            $quota=explode('~',$action_model_id);
	          }
	          if (!empty($quota[0]) && !empty($quota[1]) && 
			            !empty($quota[2])) {
			                $this->redirect(array('action'=>$quota[0],$quota[2]));
			  } else {
			     $this->redirect(array('action'=>'index'));
			  } 
              
        }
		// we need to check student has strated to fill preference before 
	
		 //check that any preference student has started filed preference
	    $check=ClassRegistry::init('Preference')
                  ->find('count',array('conditions'=>array('Preference.college_id'=>$this->college_id,
                  'Preference.academicyear'=>$related_reserved_place['ParticipatingDepartment']['academic_year'])));
         if($check){
            
                $this->Session->setFlash('<span></span>'.__('Student has started to fill their preference.You can not delete  participating department.'),'default',array('class'=>'error-box error-message'));
              if (!empty($action_model_id)) {
	            $quota=explode('~',$action_model_id);
	          }
	          if (!empty($quota[0]) && !empty($quota[1]) && 
			            !empty($quota[2])) {
			                $this->redirect(array('action'=>$quota[0],$quota[2]));
			  } else {
			     $this->redirect(array('action'=>'index'));
			  } 
             //$this->redirect(array('action'=>'index'));
        } 
        $this->loadModel('ReservedPlace');
        $participating_department_id=$this->ParticipatingDepartment->field('department_id',
        array('ParticipatingDepartment.id'=>$id));
        
        $is_placed_reserved= $this->ReservedPlace->find('count',
        array('conditions'=>array(
            'ReservedPlace.participating_department_id'=>$participating_department_id,
            'ReservedPlace.college_id'=>$this->college_id,
            'ReservedPlace.academic_year'=>$related_reserved_place['ParticipatingDepartment']['academic_year']
            )));
        if ($is_placed_reserved==0) {
		        if ($this->ParticipatingDepartment->delete($id)) {
		           /* $this->loadModel('ReservedPlace');
		            $this->ReservedPlace->deleteAll(array('ReservedPlace.participating_department_id'=>$related_reserved_place['ParticipatingDepartment']['department_id']));
			        */
			       if (!empty($action_model_id)) {
	                        $quota=explode('~',$action_model_id);
	               }
	               if (!empty($quota[0]) && !empty($quota[1]) && 
			                !empty($quota[2])) {
			            $this->Session->setFlash('<span></span>'.__('Participating department  has been deleted.'),'default',array('class'=>'success-box success-message'));
			         
			             $this->redirect(array('action'=>$quota[0],$quota[2]));
			       } else {
			          $this->Session->setFlash('<span></span>'.__('Participating department  has been deleted.'),'default',array('class'=>'success-box success-message'));
			         
			         $this->redirect(array('action'=>'index'));
			       } 
			       
			       // $this->redirect(array('action'=>'index'));
		        }
		
		} else {
		      if (!empty($action_model_id)) {
	            $quota=explode('~',$action_model_id);
	          }
	          if (!empty($quota[0]) && !empty($quota[1]) && 
			            !empty($quota[2])) {
			      $this->Session->setFlash('<span></span>'.__('Participating department could not be deleted, place already reserved.'),'default',array('class'=>'error-box error-message'));
			                $this->redirect(array('action'=>$quota[0],$quota[2]));
			  } else {
			     $this->Session->setFlash('<span></span>'.__('Participating department could not be deleted, place already reserved.'),'default',array('class'=>'error-box error-message'));
			     $this->redirect(array('action'=>'index'));
			  } 
		}
		
		//$this->Session->setFlash('<span></span>'.__('Participating department was not deleted'),'default',array('class'=>'error-box error-message'));
		//$this->redirect(array('action' => 'index'));
	}
	
	function participating_departments($academic_year = null){
	    
		/*$this->layout = 'ajax';
		$departments=$this->ParticipatingDepartment->Department->find('list',
		array('conditions'=>array('Department.college_id '=>$college_id)));
		
		$this->set('departments',$this->ParticipatingDepartment->Department->find('list',
		array('conditions'=>array('Department.college_id '=>$college_id))));
		*/
		$this->layout = 'ajax';
		$departments=$this->ParticipatingDepartment->find('all',
		array('conditions'=>array('Department.college_id '=>$this->college_id,
		'ParticipatingDepartment.academic_year LIKE '=>$academic_year.'%')));
		$developingRegions=$this->ParticipatingDepartment->College->AcceptedStudent->Region->find('list');
		
		
		$this->set(compact('departments','developingRegions'));
		
	}
	function __totalstudnets($college_id=null){
	    //$this->loadModel('AcceptedStudent');
	    if($college_id){
	       
		      $total=ClassRegistry::init('AcceptedStudent')->find('count',array('conditions'=>array('AcceptedStudent.college_id'=>$college_id,
			  'AcceptedStudent.academicyear LIKE '=>$this->AcademicYear->current_academicyear().'%',
			  'OR'=>array('AcceptedStudent.department_id  is null ',array('AcceptedStudent.department_id'=>array('',0))))));
		   return $total;
	    }
	}
	
	function get_summeries($college_id=null) {
	          $this->layout='ajax';
	      
	       
	          if(!empty($college_id)){
	          
		        $total_accepted_student_college=$this->ParticipatingDepartment->ReservedPlace->total_accepted_students_unsigned_to_department($college_id,$this->AcademicYear->current_academicyear());
		
	            $this->set(compact('total_accepted_student_college'));
	            
	         }
	          
	}
	function _ajax_add_quota(){
	    Configure::write('debug', 0);
        $this->layout = 'ajax';
        if ($this->RequestHandler->isAjax()) {
              if (!empty($this->request->data)) {
                 $this->ParticipatingDepartment->create();
                  $this->ParticipatingDepartment->set($this->request->data['ParticipatingDepartment']);
                   if($this->ParticipatingDepartment->validates()) {
                       if ($this->ParticipatingDepartment->save($this->request->data)) {
                                $message = __('The Quota has been saved.');
                                $data = $this->request->data;
                                $this->set('success', compact('message', 'data'));
                            }
                        } else {
                            $message = __('The Qutoa could not be saved. Please, try again.');
                            $Post = $this->ParticipatingDepartment->invalidFields();
                            $data = compact('Post');
                            $this->set('errors', compact('message', 'data'));
                        }
                    }
           }
	}
	/**
	*Add quota of each participating department
	*/
	function add_quota($academic_year=null) {
	     if (!empty($academic_year)) {
	        $this->request->data['ParticipatingDepartment']['academic_year']=str_replace('-', "/",$academic_year);
	     }
	     if(!empty($this->request->data)){
	     
	        $selectedAcademicYear=null;$search=false; $developing_regions_id=null;	
	        $reformatparticipating=array();
	       
	        if(!empty($this->request->data['ParticipatingDepartment']['academic_year'])){
		       $selectedAcademicYear = $this->request->data['ParticipatingDepartment']['academic_year'];
		       $search=true;
		       $hide_search=2;
		    } else {
		       $selectedAcademicYear= $this->AcademicYear->current_academicyear();
		    }
		    // is auto placement run 
		      $check_auto_placement_already_run_not_allow_adding_or_edit=ClassRegistry::init('AcceptedStudent')->find('count',
		      array('conditions'=>array('AcceptedStudent.academicyear'=> $selectedAcademicYear,'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.placementtype'=>
		      AUTO_PLACEMENT)));
		      $this->set(compact('check_auto_placement_already_run_not_allow_adding_or_edit','hide_search'));
			 //check auto has already run 
	         $this->loadModel('PlacementLock');
	         $auto_run=$this->PlacementLock->find('count',array('conditions'=>array(
	         'PlacementLock.college_id'=>$this->college_id,'PlacementLock.academic_year'=>$selectedAcademicYear,'PlacementLock.process_start'=>1))); 
	        if($auto_run){
	             $this->Session->setFlash('<span></span>'.__('The auto placement is up and running you can not modify the participationg department paramater right now, please come back after you cancelled the auto placement.'),'default',array('class'=>'error-box error-message'));
	             $this->redirect(array('action'=>'add_quota'));
	        }
		    $departments=$this->ParticipatingDepartment->find('all',
		    array('conditions'=>array('ParticipatingDepartment.college_id'=>$this->college_id,
		    'ParticipatingDepartment.academic_year LIKE '=>$selectedAcademicYear.'%'),
		    'contain'=>array()));
		    
		    if(empty($departments)){
		        $this->Session->setFlash(__('<span></span>First add participating departments and result criteria, then you can add quota for each department.'),'default',array('class'=>'error-box error-message'));
		        $this->redirect('/participatingDepartments/add');
		    }
		    //Check if result category is recorded. It is used to know what kind of result is being used for student placement (freshman or preparatory)
		    
		      $checkResultCategoryIsRecorded = ClassRegistry::init('PlacementsResultsCriteria')->
		      find('count',
		      array('conditions'=>array("PlacementsResultsCriteria.admissionyear LIKE" => 
		       $selectedAcademicYear.'%',
		      'PlacementsResultsCriteria.college_id'=>$this->college_id)));
		     
		      if(!$checkResultCategoryIsRecorded){
		          $this->Session->setFlash(__('<span></span>Please first add result criteria for the selected '.$selectedAcademicYear.' academic year and then you can add quota for each department.'),'default', array('class' => 'info-box info-message'));
		          $this->redirect(array('controller'=>'placementsResultsCriterias','action'=>'add'));
		      } 
		    
		    $already_added_capacity=$this->ParticipatingDepartment->find('count',
		    array('conditions'=>array('ParticipatingDepartment.college_id'=>$this->college_id,
		    'ParticipatingDepartment.academic_year LIKE '=>$selectedAcademicYear.'%',
		    'ParticipatingDepartment.number >'=>0)));
		  
		    $developingRegions=$this->ParticipatingDepartment->College->AcceptedStudent->Region->find('list');
		 
		     //debug($departments);
		     $selectedDevelopingRegions= !isset($this->request->data['ParticipatingDepartment']['developing_regions_id'])?array($departments[0]['ParticipatingDepartment']['developing_regions_id']):$this->request->data['ParticipatingDepartment']['developing_regions_id'];
		    //debug($this->request->data['ParticipatingDepartment']['developing_regions_id']);
		  //  debug($selectedDevelopingRegions);
		//    exit();
	            
		    $isPrepartory = ClassRegistry::init('PlacementsResultsCriteria')->isPrepartoryResult($selectedAcademicYear, $this->college_id);
		    $options = 
		    array(
	        'conditions'=>
	        array(
	        	'AcceptedStudent.disability is not null',
	        	'AcceptedStudent.college_id' => $this->college_id,
	        	'AcceptedStudent.academicyear LIKE ' => $selectedAcademicYear.'%',
	        	"OR"=>
	        	array(
	        		"AcceptedStudent.department_id is null",
	        		"AcceptedStudent.department_id"=>array(0,'')
	        	),
	     		'AcceptedStudent.program_type_id' => PROGRAM_TYPE_REGULAR,
	     		'AcceptedStudent.program_id' => PROGRAM_UNDEGRADUATE
	        ),
	        'contain'=>array()
	       );
	       if($isPrepartory == 0) {
	       	$options['conditions'][] = 'AcceptedStudent.freshman_result IS NOT NULL';
	       }
		    $quota_sum['disable']=$this->ParticipatingDepartment->College->AcceptedStudent->find('count', $options);
	        
		    $options = 
	        array(
	        'conditions'=>
	        array(
	        	'AcceptedStudent.college_id'=>$this->college_id,
	        	"AcceptedStudent.region_id"=>$selectedDevelopingRegions,
	        	'AcceptedStudent.academicyear LIKE '=>$selectedAcademicYear."%",
	        	"OR"=>
	        	array(
	        		"AcceptedStudent.department_id is null",
	        		"AcceptedStudent.department_id"=>array(0,'')
	        	),
	     		'AcceptedStudent.program_type_id' => PROGRAM_TYPE_REGULAR,
	     		'AcceptedStudent.program_id' => PROGRAM_UNDEGRADUATE
	        ),
	        'contain'=>array()
	       );
	       if($isPrepartory == 0) {
	       	$options['conditions'][] = 'AcceptedStudent.freshman_result IS NOT NULL';
	       }
	         
	         $quota_sum['region']=$this->ParticipatingDepartment->College->AcceptedStudent->find('count', $options);
	        
	        $options = 
		     array(
	        	'conditions'=>
	        	array(
	        		'AcceptedStudent.sex'=>'female',
	        		'AcceptedStudent.college_id'=>$this->college_id,
	        		'AcceptedStudent.academicyear LIKE'=>$selectedAcademicYear.'%',
	        		"OR"=>
	        		array(
	        			"AcceptedStudent.department_id is null",
	        			"AcceptedStudent.department_id"=>array(0,'')
	        		)
	        	),
	        	'contain'=>array()
	        );
	       if($isPrepartory == 0) {
	       	$options['conditions'][] = 'AcceptedStudent.freshman_result IS NOT NULL';
	       }
	        
		     $quota_sum['female']=$this->ParticipatingDepartment->College->AcceptedStudent->find('count', $options);
		     $this->set(compact('quota_sum'));
		     $total_students_for_placement=$this->ParticipatingDepartment->College->AcceptedStudent->find('count',array(
	        'conditions'=>array(
	        'AcceptedStudent.college_id'=>$this->college_id,'AcceptedStudent.academicyear LIKE'=>$selectedAcademicYear.'%',"OR"=>array("AcceptedStudent.department_id is null",
	        "AcceptedStudent.department_id"=>array(0,''))),'recursive'=>-1));
	        $this->set(compact('total_students_for_placement'));
	        
	        if($isPrepartory == 0) {
	        	//Students with freshman result
	        	ClassRegistry::init('AcceptedStudent')->copyFreshmanResult($selectedAcademicYear, $this->college_id);
		      $total_students_with_fm_result = $this->ParticipatingDepartment->College->AcceptedStudent->find('count',
		      array(
	        		'conditions' => 
	        		array(
	        			'AcceptedStudent.college_id' => $this->college_id,
	        			'AcceptedStudent.academicyear LIKE' => $selectedAcademicYear.'%',
	        			"OR"=>
	        			array(
	        				"AcceptedStudent.department_id is null",
	        				"AcceptedStudent.department_id" => array(0,'')
	        			),
			     		'AcceptedStudent.program_type_id' => PROGRAM_TYPE_REGULAR,
			     		'AcceptedStudent.program_id' => PROGRAM_UNDEGRADUATE,
			     		'AcceptedStudent.freshman_result IS NOT NULL'
	        		),
	        		'contain'=>array(),
	        	)
	        );
	        $this->set(compact('total_students_with_fm_result'));
	        }
	        
		    if(isset($this->request->data)){
		    $reformatparticipating['ParticipatingDepartment']=$this->request->data['ParticipatingDepartment'];
            }
            if(!isset($this->request->data['ParticipatingDepartment']['developing_regions_id'])){
              $selected_regions=$departments[0]['ParticipatingDepartment']['developing_regions_id'];
              $this->set(compact('selected_regions'));
             
            }
            if(isset($this->request->data['ParticipatingDepartment']['developing_regions_id']) 
                && !empty($this->request->data['ParticipatingDepartment']['developing_regions_id']
                )){
	            		   
	            $count=count($this->request->data['ParticipatingDepartment']['developing_regions_id']);
	        
	            foreach($this->request->data['ParticipatingDepartment']['developing_regions_id'] as 
	            $key=>$value){
	               if(--$count){
	                $developing_regions_id.=$value.',';
	               } else {
	               $developing_regions_id.=$value;
	               }
	          
	             }	
	            $reformatparticipating['ParticipatingDepartment']['developing_regions_id']=$developing_regions_id;  
	           
            }
           
            unset($reformatparticipating['ParticipatingDepartment']['academic_year']);
		    unset($reformatparticipating['ParticipatingDepartment']['developing_regions_id']);
		        //reformat the data for saveAll
		    foreach($reformatparticipating['ParticipatingDepartment'] as &$v){
		            $v['developing_regions_id']=$developing_regions_id;
		    }
		   //Female, developing regions and disability stat
		   $stat['female'] = ClassRegistry::init('Preference')->getPreferenceStat($this->college_id, $selectedAcademicYear, 'female');
		   $stat['region'] = ClassRegistry::init('Preference')->getPreferenceStat($this->college_id, $selectedAcademicYear, 'region');
		   $stat['disable'] = ClassRegistry::init('Preference')->getPreferenceStat($this->college_id, $selectedAcademicYear, 'disable');
		   $stat['all'] = ClassRegistry::init('Preference')->getPreferenceStat($this->college_id, $selectedAcademicYear);
		   //debug($stat);
		     $this->set(compact('departments', 'developingRegions', 'selectedAcademicYear', 'already_added_capacity', 'stat'));
		      //add or edit quota click.
		   if(isset($this->request->data['quota'])){
		        $this->set($this->request->data);
		     if($this->ParticipatingDepartment->validates()) {
		           if(
		            $this->ParticipatingDepartment->checkAvailableDisableStudentInTheGivenAcademicYear(
		            $reformatparticipating['ParticipatingDepartment'],$this->college_id,
		            $selectedAcademicYear) && $this->ParticipatingDepartment->checkAvailableFemaleInTheGivenAcademicYear(
		            $reformatparticipating['ParticipatingDepartment'],$this->college_id,
		            $selectedAcademicYear) && $this->ParticipatingDepartment->checkAvailableRegionStudentInTheGivenAcademicYear(
		               $reformatparticipating['ParticipatingDepartment'],$this->college_id, $selectedDevelopingRegions,$selectedAcademicYear) && $this->ParticipatingDepartment->checkAvailableNumberOfStudentAgainstGivenQuotaOfDepartment($reformatparticipating['ParticipatingDepartment'],
		                $this->college_id,$selectedAcademicYear)){
		          
			                  if ($this->ParticipatingDepartment->
			                    saveAll($reformatparticipating['ParticipatingDepartment'])) {
				                    $this->Session->setFlash(__('<span></span>The quota has been saved'),'default',array('class'=>'success-box success-message'));
				                   // $this->redirect(array('action' => 'index'));

			                    } else {
				                    $this->Session->setFlash(__('<span></span>The quota could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                    }
			            } else {
			             //debug($this->request->data);
			             $error=$this->ParticipatingDepartment->invalidFields();
			           
			             if(isset($error['DepartmentCapacity'])){
			                $this->Session->setFlash(__('<span></span>'.$error['DepartmentCapacity'][0]),
			                'default',array('class'=>'error-box error-message'));
			             } elseif(isset($error['female'])){
			                $this->Session->setFlash(__('<span></span>'.$error['female'][0]),
			                'default',array('class'=>'error-box error-message'));
			             } elseif(isset($error['regions'])){
			                $this->Session->setFlash(__('<span></span>'.$error['regions'][0]),
			                'default',array('class'=>'error-box error-message'));
			             } elseif(isset($error['alreadyrecorded'])) {
			               $this->Session->setFlash(__('<span></span>'.$error['alreadyrecorded'][0]),
			               'default',array('class'=>'error-box error-message'));
			             } else {
			                $this->Session->setFlash(__('<span></span>Please fill the input fields'),'default',array('class'=>'error-box error-message'));
			             }       
			    } 
	          } else {
	             // didnt validate 
		  } 
	    }
	  } // end not empty  
	}

	function getParticipatingDepartment($academicYear)
    {
		 $this->layout = 'ajax';
         $departmentList=$this->ParticipatingDepartment->getParticipatingDepartment($this->college_id, str_replace('-','/',$academicYear));
		$this->set(compact('departmentList'));
	}
}
