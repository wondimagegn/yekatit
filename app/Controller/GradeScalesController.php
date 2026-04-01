<?php
class GradeScalesController extends AppController {

	var $name = 'GradeScales';
   //gradeSettings
     var $menuOptions = array(
                 'parent' => 'gradeSettings',
                 'alias' => array(
                
                    'add' => 'Set Scale',
                    'index'=> 'View Scale'
                   
            )
                
	     );
	   function beforeFilter(){
        parent::beforeFilter();
       
       }
	function index() {
		$this->GradeScale->recursive = 0;
		$this->paginate=array('contain'=>array('Program','GradeScaleDetail'=>array('Grade'=>array('GradeType'))));
		if($this->role_id==ROLE_COLLEGE){
		    $conditions=array('GradeScale.model'=>'College','GradeScale.foreign_key'=>$this->college_id);
		} else if ($this->role_id == ROLE_REGISTRAR) { 
		   $conditions=array('GradeScale.model'=>'College');
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		  $conditions=array('GradeScale.model'=>'Department','GradeScale.foreign_key'=>$this->department_id);
		}
		$gradeScales=$this->paginate($conditions);
		
		$this->set(compact('loggedData'));
		$this->set('gradeScales', $this->paginate($conditions));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid grade scale'));
			return $this->redirect(array('action' => 'index'));
		}
	      $conditions=array();
              $conditions['GradeScale.id']=$id;
	      if($this->role_id==ROLE_COLLEGE){
		$conditions['model']='College';
		$conditions['foreign_key']=$this->college_id;
		$gradeScale=$this->GradeScale->find('first', array('conditions'=>$conditions,'contain'=>array('Department','College','Program'=>array('fields'=>array('id','name')),'GradeScaleDetail'=>array('Grade'=>array('id','grade')))));
		  
		} else if ($this->role_id==ROLE_REGISTRAR) {
		  $conditions['model']='College';
		  $gradeScale=$this->GradeScale->find('first', array('conditions'=>$conditions,'contain'=>array('Program'=>array('fields'=>array('id','name')),'GradeScaleDetail'=>array('Grade'=>array('id','grade')))));   
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		  $conditions['model']='Department';
		  $conditions['foreign_key']=$this->department_id;
		  $gradeScale=$this->GradeScale->find('first', array('conditions'=>$conditions,'contain'=>array('Program'=>array('fields'=>array('id','name')),'GradeScaleDetail'=>array('Grade'=>array('id','grade')))));
		} else { 
		$gradeScale=$this->GradeScale->find('first', array('conditions'=>$conditions,'contain'=>array('Program'=>array('fields'=>array('id','name')),'GradeScaleDetail'=>array('Grade'=>array('id','grade')))));
		}
		$gradeType = $this->GradeScale->GradeScaleDetail->Grade->GradeType->find('first',array('fields'=>array('id','type'),'conditions'=>array('GradeType.id'=>$gradeScale['GradeScale']['grade_type_id']),'contain'=>array('Grade')));
	  	
		if(!empty($gradeScale['GradeScale']['model']) && $gradeScale['GradeScale']['model']=='College') {
			$college=ClassRegistry::init('College')->find('first',array('conditions'=>array('College.id'=>$gradeScale['GradeScale']['foreign_key'])));
		} else if (!empty($gradeScale['GradeScale']['model']) && $gradeScale['GradeScale']['model']=='Department') {
		
		$department=ClassRegistry::init('Department')->find('first',array('conditions'=>array('Department.id'=>$gradeScale['GradeScale']['foreign_key'])));
		}
		
		$this->set(compact('department','gradeType','college','gradeScale'));

	}
    //was used during college delegation time 
	function  _add() {
	    //check if department is allowed to set scale.
	    /*if($this->role_id == ROLE_DEPARTMENT) {
	        $check_setting=$this->GradeScale->PublishedCourse->College->find('count',array('conditions'=>array(
	        'College.id'=>$this->college_id,'College.deligate_scale'=>1)));
	        
	        if ($check_setting==0) {
	            $this->Session->setFlash('<span></span>'.__('The college you belong is responsible for scale setting, you are not allowed to set scale.'),
				'default',array('class'=>'info-message info-box'));
				return $this->redirect(array('action' => 'index'));
	        }
	    }
	    */
	    if($this->role_id == ROLE_DEPARTMENT) {
	        $check_undegraduate_delegated = $this->GradeScale->PublishedCourse->College->find('count',
	        array('conditions'=>array(
	        'College.id'=>$this->college_id,'College.deligate_scale'=>1)));
	        $check_postgraduate_delegated=$this->GradeScale->PublishedCourse->College->find('count',array('conditions'=>array(
	        'College.id'=>$this->college_id,'College.deligate_for_graduate_study'=>1)));
	        
	        if ($check_undegraduate_delegated==0 && $check_postgraduate_delegated==0) {
	            $this->Session->setFlash('<span></span>'.__('The registrar is responsible for setting grade scale to 
	            your college. You can ask registrar to delegate the scale setting to department', true),
				'default',array('class'=>'info-message info-box'));
				return $this->redirect(array('action' => 'index'));
				
	        } else if ($check_postgraduate_delegated>0)  {
	          /*   
	           if ($check_undegraduate_delegated == 0 ) {
	                   $this->Session->setFlash('<span></span>'.__('The college you belong is responsible for scale setting, you are not allowed to set scale.'),
				        'default',array('class'=>'info-message info-box'));
				        $this->redirect(array('action' => 'index'));        
	           }
	           */
	           
	        } else if ($check_undegraduate_delegated == 0 ) {
	            $this->Session->setFlash('<span></span>'.__('The registrar is responsible for setting grade scale to 
	            your college. You can ask registrar to delegate the scale setting to department', true),
				'default',array('class'=>'info-message info-box'));
				return $this->redirect(array('action' => 'index'));        
	        
	        }
	        
	        
	        $find_delegation_program_ids = $this->GradeScale->PublishedCourse->College->find('first',array('conditions'=>array(
	        'College.id'=>$this->college_id),'fields'=>array('deligate_for_graduate_study','deligate_scale')));
	        if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==1 && 
	        $find_delegation_program_ids['College']['deligate_scale']==1) {
	           /*$this->Session->setFlash('<span></span>'.__('You have delegated scale setting to departments.'),
				'default',array('class'=>'info-message info-box'));*/
				//$this->redirect(array('action' => 'index'));
		        $programs = $this->GradeScale->Program->find('list');    
	        } else if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==1) {
	        
	          $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_POST_GRADUATE)));    
	        } else if ($find_delegation_program_ids['College']['deligate_scale']==1) {
	          
	          $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_UNDEGRADUATE)));   
	        }
	  
	    }
		if ($this->role_id == ROLE_COLLEGE) {
		   
	        $find_delegation_program_ids = $this->GradeScale->PublishedCourse->College->find('first',array('conditions'=>array(
	        'College.id'=>$this->college_id),'fields'=>array('deligate_for_graduate_study','deligate_scale')));
	        if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==0 && 
	        $find_delegation_program_ids['College']['deligate_scale']==0) {
		        $programs = $this->GradeScale->Program->find('list');    
	        } else if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==0) {
	        
	          $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_POST_GRADUATE)));    
	        } else if ($find_delegation_program_ids['College']['deligate_scale']==0) {
	          
	          $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_UNDEGRADUATE)));   
	        } else if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==1 && 
	        $find_delegation_program_ids['College']['deligate_scale']==1) {
	        
	             $this->Session->setFlash('<span></span>'.__('You have delegated scale setting to departments for
	              both undergraduate and post graduate program but you can define scale for non department assigned
	               or pre/freshman program.', true),
				'default',array('class'=>'info-message info-box'));
				$programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_UNDEGRADUATE)));   
				//$this->redirect(array('action' => 'index'));
				$onlyfresh=true;
				$this->set(compact('onlyfresh'));
	        
	        }
		}
	    
		if (!empty($this->request->data)) {
			    $this->GradeScale->create();
			    if($this->role_id == ROLE_COLLEGE) {
		            $this->request->data['GradeScale']['model']="College";
		            $this->request->data['GradeScale']['foreign_key']=$this->college_id;
		        } elseif ($this->role_id==ROLE_DEPARTMENT) {
		           $this->request->data['GradeScale']['model']="Department";
		            $this->request->data['GradeScale']['foreign_key']=$this->department_id;
		        }
		        if ($this->role_id == ROLE_COLLEGE) {
		        $check_scale_execlusiveness=$this->GradeScale->GradeScaleDetail->check_scale_execlusiveness($this->request->data,$this->role_id);
		        
		        } elseif ($this->role_id == ROLE_DEPARTMENT) {
		           $check_scale_execlusiveness=$this->GradeScale->GradeScaleDetail->check_scale_execlusiveness($this->request->data,$this->role_id);
		        
		         
		        }
               
		      if (true) {
		           
		            $this->request->data=$this->GradeScale->unset_empty_rows($this->request->data);
		           
		            if(isset($this->request->data['GradeScale']['own'])){
		               $own=$this->request->data['GradeScale']['own'];
		            } else {
		               $own=0;
		            }
		            $scale_ids=$this->GradeScale->GradeScaleDetail->Grade->GradeType->getGradeScaleDetails($this->request->data['GradeScale']['grade_type_id'],$this->request->data['GradeScale']['program_id'],
		            $this->request->data['GradeScale']['foreign_key'],1,$own);
		          
		            if (count($scale_ids['GradeScale']) == 0) {
		               
		          //check grade uniqueness
		          if ($this->GradeScale->GradeScaleDetail->checkGradeIsUnique($this->request->data)) {
		             //check continuty
		                $continues=$this->GradeScale->GradeScaleDetail->gradeRangeContinuty($this->request->data);
		             if ($continues) {
			            if ($this->GradeScale->saveAll($this->request->data,array('validate'=>'first'))) {
				            $this->Session->setFlash('<span></span>'.__('The grade scale has been saved'),
				            'default',array('class'=>'success-message success-box'));
				            $this->redirect(array('action' => 'index'));
			            } else {
				            $this->Session->setFlash('<span></span>'.__('The grade scale could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			            }
			        } else {
			               $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			               
			                     if(isset($error['grade_range_continuty'])){
			                        $this->Session->setFlash(__('<span></span>'.
			                        $error['grade_range_continuty'][0], true),
			                        'default', array('class' => 'error-box error-message'));
			                     } 
			        }
			        
			      } else {
			         $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			               
			                     if(isset($error['checkGradeIsUnique'])){
			                        $this->Session->setFlash(__('<span></span>'.
			                        $error['checkGradeIsUnique'][0], true),
			                        'default', array('class' => 'error-box error-message'));
			                     } 
			      
			      }
			        
			     } else {
			       
			        $grade_type=$this->GradeScale->GradeScaleDetail->Grade->GradeType->field('type',
			        array('GradeType.id'=>$this->request->data['GradeScale']['grade_type_id']));
			        $this->Session->setFlash('<span></span>'.__('You have already setup grade scale for  '.$grade_type.' grade type. Inorder to define a new scale with same grade type first deactivate the previous scale defined in this page.'),"session_flash_link",array('class'=>'error-box error-message',
			        'link_text'=>"this page",
			        'link_url'=>array(
			            "controller" => "grade_scales",
						"action" => "index",
						"admin" => false

			        )));
			      
			       
			       
			     }
		      } else {
		      
		             $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			                        
                     if(isset($error['minimum_maximum_result'][0])){
                        $this->Session->setFlash(__('<span></span>'.
                        $error['minimum_maximum_result'], true),
                        'default', array('class' => 'error-box error-message'));
                      }
		      
		     }
		}
		
		$gradeTypes = $this->GradeScale->GradeScaleDetail->Grade->GradeType->find('list',array('fields'=>array('id','type')));
		if(empty($this->request->data)) {
			$temp = array_keys($gradeTypes);
			$gradeTypeId = $temp[0];
		} else {
			$gradeTypeId = $this->request->data['GradeScale']['grade_type_id'];
		}
		
		
		
		$grades=$this->GradeScale->GradeScaleDetail->Grade->find('list',array('conditions'=>array('Grade.grade_type_id'=>$gradeTypeId),'fields'=>array('id','grade')));
		$this->paginate=array('contain'=>array('Program','GradeScaleDetail'=>array('Grade'=>array('GradeType'=>array('id','type'),'fields'=>array('id','grade')))));
		if($this->role_id==ROLE_COLLEGE){
		    $conditions=array('GradeScale.model'=>'College','GradeScale.active'=>1,'GradeScale.foreign_key'=>$this->college_id);
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		  $conditions=array('GradeScale.model'=>'Department','GradeScale.active'=>1,'GradeScale.foreign_key'=>$this->department_id);
		}
		$gradeScales=$this->paginate($conditions);
		
		  //check if department is allowed to set scale.
	    
		$this->set(compact('gradeTypes','grades', 'programs','gradeScales'));
	}
  
  
    function set_grade_scale () {
	    if (!empty($this->request->data) && isset($this->request->data['saveIt'])) {
		       
			    $this->GradeScale->create();
			    if($this->role_id == ROLE_REGISTRAR) {
		            $this->request->data['GradeScale']['model']="College";
		            $this->request->data['GradeScale']['foreign_key']=$this->request->data['Search']['college_id'];
		        } elseif ($this->role_id==ROLE_DEPARTMENT) {
		           $this->request->data['GradeScale']['model']="Department";
		            $this->request->data['GradeScale']['foreign_key']=$this->department_id;
		        }
		       
		      if (true) {
		           
		            $this->request->data=$this->GradeScale->unset_empty_rows($this->request->data);
		           
		            if(isset($this->request->data['GradeScale']['own'])){
		               $own=$this->request->data['GradeScale']['own'];
		            } else {
		               $own=0;
		            }
		            $scale_ids=$this->GradeScale->GradeScaleDetail->Grade->GradeType->getGradeScaleDetails($this->request->data['GradeScale']['grade_type_id'],$this->request->data['GradeScale']['program_id'],
		            $this->request->data['GradeScale']['foreign_key'],1,$own);
		          
		            if (count($scale_ids['GradeScale']) == 0) {
		               
		          //check grade uniqueness
		          if ($this->GradeScale->GradeScaleDetail->checkGradeIsUnique($this->request->data)) {
		             //check continuty
		                $continues=$this->GradeScale->GradeScaleDetail->gradeRangeContinuty($this->request->data);
		             if ($continues) {
			            if ($this->GradeScale->saveAll($this->request->data,array('validate'=>'first'))) {
				            $this->Session->setFlash('<span></span>'.__('The grade scale has been saved'),
				            'default',array('class'=>'success-message success-box'));
				            $this->redirect(array('action' => 'index'));
			            } else {
				            $this->Session->setFlash('<span></span>'.__('The grade scale could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			            }
			        } else {
			               $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			               
			                     if(isset($error['grade_range_continuty'])){
			                        $this->Session->setFlash(__('<span></span>'.
			                        $error['grade_range_continuty'][0], true),
			                        'default', array('class' => 'error-box error-message'));
			                     } 
			        }
			        
			      } else {
			         $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			               
			                     if(isset($error['checkGradeIsUnique'])){
			                        $this->Session->setFlash(__('<span></span>'.
			                        $error['checkGradeIsUnique'][0], true),
			                        'default', array('class' => 'error-box error-message'));
			                     } 
			      
			      }
			        
			     } else {
			       
			        $grade_type=$this->GradeScale->GradeScaleDetail->Grade->GradeType->field('type',
			        array('GradeType.id'=>$this->request->data['GradeScale']['grade_type_id']));
			        $this->Session->setFlash('<span></span>'.__('You have already setup grade scale for  '.$grade_type.' grade type. Inorder to define a new scale with same grade type first deactivate the previous scale defined in this page.'),"session_flash_link",array('class'=>'error-box error-message',
			        'link_text'=>"this page",
			        'link_url'=>array(
			            "controller" => "grade_scales",
						"action" => "index",
						"admin" => false

			        )));
			      
			       
			       
			     }
		      } else {
		      
		             $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			                        
                     if(isset($error['minimum_maximum_result'])){
                        $this->Session->setFlash(__('<span></span>'.$error['minimum_maximum_result'][0], true),
                        'default', array('class' => 'error-box error-message'));
                      }
		      
		     }
		}
	    if($this->role_id == ROLE_DEPARTMENT) {
	        $check_undegraduate_delegated = $this->GradeScale->PublishedCourse->College->find('count',array('conditions'=>array(
	        'College.id'=>$this->college_id,'College.deligate_scale'=>1)));
	        $check_postgraduate_delegated=$this->GradeScale->PublishedCourse->College->find('count',array('conditions'=>array(
	        'College.id'=>$this->college_id,'College.deligate_for_graduate_study'=>1)));
	        
	        if ($check_undegraduate_delegated==0 && $check_postgraduate_delegated==0) {
	            $this->Session->setFlash('<span></span>'.__('The registrar responsible for scale setting,
	             you are not allowed to set scale. Ask registrar to delegate your department for scale settings.', true),
				'default',array('class'=>'info-message info-box'));
				return $this->redirect(array('action' => 'index'));
				
	        } else if ($check_postgraduate_delegated>0)  {
	        
	        } else if ($check_undegraduate_delegated == 0 ) {
	            $this->Session->setFlash('<span></span>'.__('The registrar  is responsible for scale setting, you are not allowed to set scale.'),
				'default',array('class'=>'info-message info-box'));
				return $this->redirect(array('action' => 'index'));        
	        
	        }
	        
	        
	        $find_delegation_program_ids = $this->GradeScale->PublishedCourse->College->find('first',array('conditions'=>array(
	        'College.id'=>$this->college_id),'fields'=>array('deligate_for_graduate_study','deligate_scale')));
	        if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==1 && 
	        $find_delegation_program_ids['College']['deligate_scale']==1) {
	          
		        $programs = $this->GradeScale->Program->find('list');    
	        } else if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==1) {
	        
	          $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_POST_GRADUATE)));    
	        } else if ($find_delegation_program_ids['College']['deligate_scale']==1) {
	          
	          $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_UNDEGRADUATE)));   
	        }
	        
	         $turn_off_search=true;
		     $this->set(compact('turn_off_search'));
	  
	    }
	    
		if ($this->role_id == ROLE_REGISTRAR) {
		    if (isset($this->request->data['Search']['college_id']) && 
		    !empty($this->request->data['Search']['college_id'])) {
		      $this->request->data['continue']=true;
		    
		    }
		    if (!empty($this->request->data) && isset($this->request->data['continue'])) {
		       if (!empty($this->request->data['Search']['college_id'])) {
			           
			             $find_delegation_program_ids = $this->GradeScale->PublishedCourse->College->find('first',array('conditions'=>array(
	                    'College.id'=>$this->request->data['Search']['college_id']),
	                    'contain'=>array(),'fields'=>array('deligate_for_graduate_study','deligate_scale')));
	                    
	                  
	                    if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==0 && 
	                    $find_delegation_program_ids['College']['deligate_scale']==0) {
		                    $programs = $this->GradeScale->Program->find('list');    
	                    } else if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==0) {
	                    
	                      $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_POST_GRADUATE)));    
	                    } else if ($find_delegation_program_ids['College']['deligate_scale']==0) {
	                      
	                      $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_UNDEGRADUATE)));   
	                    } else if ($find_delegation_program_ids['College']['deligate_for_graduate_study']==1 && 
	                    $find_delegation_program_ids['College']['deligate_scale']==1) {
	                    
	                         /*$this->Session->setFlash('<span></span>'.__('You have delegated scale setting to departments for both undergraduate and post graduate program but you can define scale for non department assigned or pre/freshman program.'),
				            'default',array('class'=>'info-message info-box'));
				            */
				            $programs = $this->GradeScale->Program->find('list',array('conditions'=>array('Program.id'=>PROGRAM_UNDEGRADUATE)));   
				            //$this->redirect(array('action' => 'index'));
				            $onlyfresh=true;
				            $this->set(compact('onlyfresh'));
	                    
	                    }
	                 $college_id=$this->request->data['Search']['college_id'];
	                 $turn_off_search=true;
		            $this->set(compact('turn_off_search','college_id'));
		          }
		            
		    }
	
	      
		}
	    
		
		
		$gradeTypes = $this->GradeScale->GradeScaleDetail->Grade->GradeType->find('list',array('fields'=>array('id','type')));
		if(empty($this->request->data)) {
			$temp = array_keys($gradeTypes);
			$gradeTypeId = $temp[0];
		} else {
		    if (!empty($this->request->data['GradeScale']['grade_type_id'])) {
		        $gradeTypeId = $this->request->data['GradeScale']['grade_type_id'];
		    } else {
		        $temp = array_keys($gradeTypes);
			    $gradeTypeId = $temp[0];
		    
		    }
		    
		}
		
		
		
		$grades=$this->GradeScale->GradeScaleDetail->Grade->find('list',array('conditions'=>array('Grade.grade_type_id'=>$gradeTypeId),
			'fields'=>array('id','grade'),'limit'=>100));
		$this->paginate=array('contain'=>array('Program','GradeScaleDetail'=>array('Grade'=>array('GradeType'=>array('id','type'),'fields'=>array('id','grade')))));
		if($this->role_id==ROLE_REGISTRAR){
		     $conditions=array('GradeScale.model'=>'College');
		     $gradeScales=$this->paginate($conditions); 
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		  $conditions=array('GradeScale.model'=>'Department','GradeScale.active'=>1,'GradeScale.foreign_key'=>$this->department_id);
		 $gradeScales=$this->paginate($conditions);
		} 
		
	  $programs = $this->GradeScale->Program->find('list');	
		  //check if department is allowed to set scale.
	    $colleges=ClassRegistry::init('College')->find('list');
		$this->set(compact('gradeTypes','grades','colleges', 'programs','gradeScales'));
	}
	
    function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid grade scale'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->GradeScale->id = $id;
        
        if (!$this->GradeScale->exists()) {
             $this->Session->setFlash('<span></span>'.__('Invalid grade scale'),
			'default',array('class'=>'error-box error-message'));
			
			return $this->redirect(array('action'=>'index'));
        }
		//check if grade is submitted in the given scale id 
		$is_grade_editing_possible=$this->GradeScale->check_grade_submitted($id);
	    if($is_grade_editing_possible){
	       $this->Session->setFlash('<span></span>'.
	       __('You can not edit this scale. Student has already get a grade with this scale. 
	       Please deactivate this grade scale and define a new grade scale if you want grade scale change.', true),
			'default',array('class'=>'error-box error-message'));
			
			return $this->redirect(array('action'=>'index'));
	    }
		if (!empty($this->request->data)) {
		
		        //check grade uniqueness
		         if ($this->GradeScale->GradeScaleDetail->checkGradeIsUnique($this->request->data)) {
		                 //check continuty
		               $continues=$this->GradeScale->GradeScaleDetail->gradeRangeContinuty($this->request->data);
		               if ($continues) {
		                                 
			                    if ($this->GradeScale->saveAll($this->request->data,array('validate'=>'first'))) {
				                    $this->Session->setFlash('<span></span>'.__('The grade scale has been saved'),
				                    'default',array('class'=>'success-message success-box'));
				                    $this->redirect(array('action' => 'index'));
			                    } else {
				                    $this->Session->setFlash('<span></span>'.__('The grade scale could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                    }
			            } else {
			                        $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			                   
			                         if(isset($error['grade_range_continuty'])){
			                            $this->Session->setFlash(__('<span></span>'.
			                            $error['grade_range_continuty'][0], true),
			                            'default', array('class' => 'error-box error-message'));
			                         } 
			            }
			
	              } else {
	                  $error=$this->GradeScale->GradeScaleDetail->invalidFields();
			                   
			                         if(isset($error['checkGradeIsUnique'])){
			                            $this->Session->setFlash(__('<span></span>'.$error['checkGradeIsUnique'][0], true),
			                            'default', array('class' => 'error-box error-message'));
			                         } 
	               
	              }
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GradeScale->read(null, $id);
		}
			
		//$gradeTypes = $this->GradeScale->GradeType->find('list',array('fields'=>array('id','type')));
		$gradeTypes = $this->GradeScale->GradeScaleDetail->Grade->GradeType->find('list',array('fields'=>array('id','type')));
		if(empty($this->request->data)) {
			$temp = array_keys($gradeTypes);
			$gradeTypeId = $temp[0];
		} else {
		        if (!empty($this->request->data['GradeScale']['grade_type_id'])) {
			        $gradeTypeId = $this->request->data['GradeScale']['grade_type_id'];
		        } else {
		            $temp = array_keys($gradeTypes);
			        $gradeTypeId = $temp[0];
		        }
		        
		}
		
		$grades=$this->GradeScale->GradeScaleDetail->Grade->find('list',array('conditions'=>array('Grade.grade_type_id'=>$gradeTypeId),'fields'=>array('id','grade')));
		
		
		$this->paginate=array('contain'=>array('Program'));
		$conditions=array('GradeScale.active'=>1);
		$gradeScales=$this->paginate($conditions);
		
		$programs = $this->GradeScale->Program->find('list');
		$this->set(compact('gradeTypes','grades', 'programs','gradeScales'));
	}
	function delete($id = null,$action_controller_id=null) {
	    if (!empty($action_controller_id)) {
	        $grade_type=explode('~',$action_controller_id);
	    }
	    
	    $this->GradeScale->id = $id;
        
        if (!$this->GradeScale->exists()) {
             $this->Session->setFlash('<span></span>'.__('Invalid id for grade scale'),
			'default',array('class'=>'error-box error-message'));
			if (!empty($grade_type[0]) && !empty($grade_type[1]) && 
			!empty($grade_type[2])) {
			    $this->redirect(array('controller'=>$grade_type[1],'action'=>$grade_type[0],
			    $grade_type[2]));
			} elseif (!empty($grade_type[0]) && !empty($grade_type[1])) {
			   $this->redirect(array('controller'=>$grade_type[1],'action'=>$grade_type[0]));
			}
			return $this->redirect(array('action'=>'index'));
        }
		//TODO: CHeck grade scale is not involved for any grade computing
		// it true, call function in here to return true or false to allow deletion.
		$check_not_involved_in_grade_computing=$this->GradeScale->allowDelete($id);
		if ($check_not_involved_in_grade_computing) {
		    if ($this->GradeScale->delete($id)) {
			    $this->Session->setFlash('<span></span>'.__('Grade scale deleted.'),
			    'default',array('class'=>'success-box success-message'));
			    if (!empty($grade_type[0]) && 
			    !empty($grade_type[1]) && !empty($grade_type[2])) {
			        $this->redirect(array('controller'=>$grade_type[1],'action'=>$grade_type[0],$grade_type[2]));
			    } elseif (!empty($grade_type[0]) && !empty($grade_type[1])) {
			       $this->redirect(array('controller'=>$grade_type[1],'action'=>$grade_type[0]));
			    
			    }
			    $this->redirect(array('action'=>'index'));
		    }
		
		}
	   
		$this->Session->setFlash('<span></span>'.__('Grade scale was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	
	function deactive_scale () {
	
	    if (!empty($this->request->data) && isset($this->request->data['deactivateselected'])) {
	              $selected_atleast_one=array_sum($this->request->data['GradeScale']['selected']);
	              
	              if ($selected_atleast_one>0) {
	                // reformat for deactivation
	                $data=array();
	                $count=0;
	                foreach ($this->request->data['GradeScale']['selected'] as $grade_scale_id=>$selected) {
	                    if ($selected == 1) {
	                        $data['GradeScale'][$count]['active']=0;
	                        $data['GradeScale'][$count]['id']=$grade_scale_id;
	                    }
	                }
	              
	               if (!empty($data)) {
	                     	if ($this->GradeScale->saveAll($data['GradeScale'])) {
				                $this->Session->setFlash('<span></span>'.__('The grade scale has deactivated successfully.'),
				                'default',array('class'=>'success-message success-box'));
				                $this->redirect(array('action' => 'index'));
			                } else {
				                $this->Session->setFlash('<span></span>'.__('The grade scale could not be deactived. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                }
	               }
	              
	              } else {
	                $this->Session->setFlash('<span></span>'.__('Select atleast one grade scale you want to deactivate.'),
				'default',array('class'=>'error-message error-box'));
	              }
	    }
	    $this->GradeScale->recursive = 0;
		
		$this->paginate=array('limit'=>1000,'contain'=>array('Program','GradeScaleDetail'=>array('Grade'=>array('GradeType'))));
		if($this->role_id==ROLE_COLLEGE){
		    $conditions=array('model'=>'College','GradeScale.active'=>1,
		    'GradeScale.foreign_key'=>$this->college_id); 
		}  else if ($this->role_id == ROLE_DEPARTMENT) {
		  $conditions=array('model'=>'Department','GradeScale.active'=>1,
		  'GradeScale.foreign_key'=>$this->department_id);
		} else if ($this->role_id==ROLE_REGISTRAR) {
		      $conditions=array('model'=>'College');
		}
		
		$gradeScales=$this->paginate($conditions);
		
		if(empty($gradeScales)) {
		    $this->Session->setFlash('<span></span>'.__('There is no scale that  needs deactivation.'),'default',array('class'=>'error-box error-message'));
		     $this->redirect(array('action' => 'index'));
		} else {
		        $this->set('gradeScales', $this->paginate($conditions));
		}
		
		$this->set('gradeScales', $this->paginate($conditions));
	}
	
	function activate_scale () {
	
	    if (!empty($this->request->data) && isset($this->request->data['activatescale'])) {
	              $selected_atleast_one=array_sum($this->request->data['GradeScale']['selected']);
	             
	              if ($selected_atleast_one>0) {
	                // reformat for deactivation
	                $data=array();
	                $count=0;
	                foreach ($this->request->data['GradeScale']['selected'] as $grade_scale_id=>$selected) {
	                    if ($selected == 1) {
	                        $data['GradeScale'][$count]['active']=1;
	                        $data['GradeScale'][$count]['id']=$grade_scale_id;
	                    }
	                }
	              
	               if (!empty($data)) {
	                     	if ($this->GradeScale->saveAll($data['GradeScale'])) {
				                $this->Session->setFlash('<span></span>'.__('The grade scale has activated successfully.'),
				                'default',array('class'=>'success-message success-box'));
				                $this->redirect(array('action' => 'index'));
			                } else {
				                $this->Session->setFlash('<span></span>'.__('The grade scale could not be activated. Please, try again.'),'default',array('class'=>'error-box error-message'));
			                }
	               }
	              
	              } else {
	                $this->Session->setFlash('<span></span>'.__('Select atleast one grade scale you want to activate.'),
				'default',array('class'=>'error-message error-box'));
	              }
	    }
	    $this->GradeScale->recursive = 0;
		
		$this->paginate=array('contain'=>array('Program','GradeScaleDetail'=>array('Grade'=>array('GradeType'))));
		if($this->role_id==ROLE_COLLEGE){
		    $conditions=array('model'=>'College','GradeScale.active'=>0,
		    'GradeScale.foreign_key'=>$this->college_id);
		} else if ($this->role_id == ROLE_REGISTRAR) {
		     $conditions=array('model'=>'College','GradeScale.active'=>0);
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		  $conditions=array('model'=>'Department','GradeScale.active'=>0,
		  'GradeScale.foreign_key'=>$this->department_id);
		}
		$gradeScales=$this->paginate($conditions);
		if(empty($gradeScales)) {
		    $this->Session->setFlash('<span></span>'.__('There is no scale that  needs activatation.'),'default',array('class'=>'error-box error-message'));
		     $this->redirect(array('action' => 'index'));
		} else {
		        $this->set('gradeScales', $this->paginate($conditions));
		}
	}
	
}
