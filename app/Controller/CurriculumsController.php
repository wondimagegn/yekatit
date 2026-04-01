<?php
class CurriculumsController extends AppController {

	 var $name = 'Curriculums';
	 var $helpers = array('DatePicker','Media.Media');
	 var $menuOptions = array(
		     'title'=>'xyz',
		     'exclude' => array('get_curriculums','get_courses','get_course_category_combo','search','deleteCourseCategory','get_curriculum_combo','lock'),
		     'alias' => array(
		            'index' => 'List Curricula',
		            'add' => 'Add Curriculum'
		           
		    )
	 );
	  
     public function beforeFilter(){
            parent::beforeFilter();   
            $this->Auth->allow('get_curriculums','get_courses','get_course_category_combo',
            'get_curriculum_combo','search');		     
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
		
		/*foreach ($this->request->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
		}
		*/
		foreach ($this->request->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				if(is_array($vv)) {
					foreach($vv as $kkk => $vvv)
						$url[$k.'.'.$kk.'.'.$kkk] = $vvv;
				}
				else
					$url[$k.'.'.$kk]=$vv;
			} 
		}

		// redirect the user to the url
		return $this->redirect($url, null, true);
	 }
	 
	function index($program_id=null) {
	  $this->__init_search();
		//debug($this->data);		    
	 if (!empty($this->request->data) && isset($this->request->data['search'])) { 

	           $options = array();
	           
	           if ($this->role_id == ROLE_DEPARTMENT) {
	                 $options[] = array(
	                           "Curriculum.department_id"=>$this->department_id
	                        );
	           } else if ($this->role_id ==ROLE_COLLEGE ) {
	                $department_ids = $this->Curriculum->Department->find('list',
	                array('conditions'=>array('Department.college_id'=>$this->college_id),
	                'fields'=>array('Department.id','Department.id')));
	                
	                if (!empty($this->request->data['Search']['department_id'])) {
	                        $options[] = array(
	                           "Curriculum.department_id"=>$this->request->data['Search']['department_id']
	                        );
	                } else {
	                     $options[] = array(
	                           "Curriculum.department_id"=> $department_ids
	                        );
	                }
	           } else if ($this->role_id == ROLE_REGISTRAR || $this->role_id == $this->Session->read('Auth.User')['Role']['parent_id']) {
	                  if (!empty($this->request->data['Search']['department_id'])) {
	                        $options[] = array(
	                           "Curriculum.department_id"=>$this->request->data['Search']['department_id']
	                        );
	                  } else {
	                      $options[] = array(
	                           "Curriculum.department_id"=> $this->department_ids
	                        );
	                  }
	           }
	           if (!empty($this->request->data['Search']['program_id'])) {
	                        $options[] = array(
	                           "Curriculum.program_id"=>$this->request->data['Search']['program_id']
	                        );
	           }
	          $this->__init_search();
	           $result_curriculums=$this->paginate($options);
	           if (empty($result_curriculums)) {
	                         $this->Session->setFlash('<span></span>'.
	                         __('No result is found for the given search criteria.'),
	                         'default',array('class'=>'info-box info-message'));
	    
	           }
	        
	     }
		
	    if ($this->role_id == ROLE_COLLEGE) {
		    $departments=$this->Curriculum->Department->find('list',
		    array('conditions'=>array('Department.college_id'=>$this->college_id)));
	   } else if ($this->role_id == ROLE_DEPARTMENT) {
		     $departments=$this->Curriculum->Department->find('list',
		    array('conditions'=>array('Department.id'=>$this->department_id)));
		    $yearLevels = $this->Curriculum->Department->YearLevel->find('list',
		array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
		    $curriculums = $this->Curriculum->find('list',array('fields'=>array('Curriculum.curriculum_detail'),
			'conditions'=>array('Curriculum.department_id'=>$this->department_id)));
	  } else if ($this->role_id == ROLE_REGISTRAR || $this->role_id == $this->Session->read('Auth.User')['Role']['parent_id']) {
		   if (!empty($this->department_ids)) {
		         $departments=$this->Curriculum->Department->find('list',array('conditions'=>
		         array('Department.id'=>$this->department_ids))); 
		         $college_ids=$this->Curriculum->Department->find('list',
		         array('conditions'=>array('Department.id'=>$this->department_ids),
		         'fields'=>array('Department.college_id')));
		         $colleges=$this->Curriculum->Department->College->find('list',
		         array('conditions'=>array('College.id'=>$college_ids)));  
		          $curriculums = $this->Curriculum->find('list',array('fields'=>array('Curriculum.curriculum_detail'),
			'conditions'=>array('Curriculum.department_id'=>$this->department_ids)));
		   
		   }
		}
		
	  
		
		if (isset($this->request->data['Search']['department_id']) && 
		!empty($this->request->data['Search']['department_id'])) {
		      $curriculums = $this->Curriculum->find('list',array('fields'=>array('Curriculum.curriculum_detail'),
			'conditions'=>array('Curriculum.department_id'=>$this->request->data['Search']['department_id'])));
		 
		}
		
		$programs = $this->Curriculum->Program->find('list');		
	    $this->set(compact('colleges','curriculums','programs','departments',
	    'result_curriculums'));
	}

     
     public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid curriculum'));
			return $this->redirect(array('action' => 'index'));
		}
		$curriculum=$this->Curriculum->find('first',array('conditions'=>array('Curriculum.id'=>$id),'contain'=>array('Attachment','CourseCategory','Course'=>array('order'=>'Course.year_level_id ASC, Course.semester ASC, Course.course_title ASC',
'CourseCategory'=>array('fields'=>array('id','name')),'YearLevel'=>array('id','name'),'GradeType'=>array('fields'=>array('id','type')),'Prerequisite'=>array('Course','PrerequisiteCourse')),'Department'=>array('fields'=>array('id','name')))));
		
		$this->set('curriculum',$curriculum);
	}

     public function add() 
	 {
		if (!empty($this->request->data) && !empty($this->request->data['saveCurriculum'])) {
				$this->Curriculum->create();
				 $this->request->data=$this->Curriculum->preparedAttachment($this->request->data);
				if ($this->Curriculum->saveAll($this->request->data,array('validate'=>'first'))) {
					$this->Session->setFlash('<span></span>'.__('The curriculum has been saved'),
					'default',array('class'=>'success-box success-message'));	
			return $this->redirect(array('action' => 'index'));
				} else {
				   
					$this->Session->setFlash('<span></span>'.__('The curriculum could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				}
		}

		//To copy curriculum from selected curriculum new curriculum
		if (!empty($this->request->data) && isset($this->request->data['copyCurriculum'])) {
			   if(!empty($this->request->data['Curriculum']['from_curriculum'])) {
				
				   $curriculums=$this->Curriculum->find('first',
array('conditions'=>array('Curriculum.id'=>$this->request->data['Curriculum']['from_curriculum']),'contain'=>array('CourseCategory')));
					$formatCurriculumForSaveAll['Curriculum']=$curriculums['Curriculum'];
				    $formatCurriculumForSaveAll['Curriculum']['name']=$curriculums['Curriculum']['name'].'(copy)';
					unset($formatCurriculumForSaveAll['Curriculum']['id']);
					$count=0;
				    foreach($curriculums['CourseCategory'] as $k=>$v) {
                     $formatCurriculumForSaveAll['CourseCategory'][$count]['name']=$v['name'];
					 $formatCurriculumForSaveAll['CourseCategory'][$count]['code']=$v['code'];
			         $formatCurriculumForSaveAll['CourseCategory'][$count]['mandatory_credit']=$v['mandatory_credit'];
					 $formatCurriculumForSaveAll['CourseCategory'][$count]['total_credit']=$v['total_credit'];
					
					$count++;
				  }
                 
                 if(!empty($formatCurriculumForSaveAll)) {
				  if ($this->Curriculum->saveAll($formatCurriculumForSaveAll,array('validate'=>false))) {
                      
						 $copied_courses = $this->Curriculum->Course->find('all',array('conditions'=>array('Course.curriculum_id'=>$curriculums['Curriculum']['id']),'contain'=>array('Book','Journal','Weblink','Prerequisite'=>array('PrerequisiteCourse'),'CourseCategory'),'limit'=>5000000,
'order'=>'Course.semester ASC,Course.year_level_id ASC,Course.course_title ASC'));
				     //debug(count($copied_courses));
					//unset empty prerequisite/Book/Journal and weblink data before save
					 $newCopyCourses = $this->Curriculum->Course->saveAllFormatCopyCourse($copied_courses);
				
					$saveCourse=array();
					$count=0;
				    $prerequiteHold=array();
					foreach($newCopyCourses as $each_courses) {
						    $saveCourse=$each_courses;
							$saveCourse['Course']['curriculum_id'] = $this->Curriculum->id;
							$courseCategory=$this->Curriculum->CourseCategory->find('first',array('conditions'=>array('CourseCategory.curriculum_id'=>$this->Curriculum->id,
	'CourseCategory.name'=>$each_courses['CourseCategory']['name'],
	'CourseCategory.code'=>$each_courses['CourseCategory']['code'],
	'CourseCategory.total_credit'=>$each_courses['CourseCategory']['total_credit'],'CourseCategory.mandatory_credit'=>$each_courses['CourseCategory']['mandatory_credit'])));
						  //find previous prerqusite and and hold it for
						   // new created course
                          unset($saveCourse['Prerequisite']);
						 if(!empty($each_courses['Prerequisite']) && 
!empty($each_courses['Prerequisite'])){
								   $preCount=0;
						//		debug($each_courses);
								   foreach($each_courses['Prerequisite'] as 
$k=>$v) {
									  $prerequite=$this->Curriculum->Course->find('first',array('conditions'=>array('Course.curriculum_id'=>$this->Curriculum->id,
'Course.course_code'=>$v['PrerequisiteCourse']['course_code'],'Course.course_title'=>$v['PrerequisiteCourse']['course_title'])));
										if(!empty($prerequite)) {
                      $saveCourse['Prerequisite'][$preCount]['prerequisite_course_id']=$prerequite['Course']['id'];
 //$saveCourse['Prerequisite'][$preCount]['co_requisite']=$v['PrerequisiteCourse']['co_requisite'];
										}
							        $preCount++;
								 }
						}			
	            
						
						 
						 $saveCourse['Course']['course_category_id']=$courseCategory['CourseCategory']['id'];	
						unset($saveCourse['CourseCategory']);
						
						if(isset($saveCourse['Course']['id']) && !empty($saveCourse['Course']['id'])) {
							unset($saveCourse['Course']['id']);
						}

						if(!empty($saveCourse)){
					       if ($this->Curriculum->Course->saveAll($saveCourse,
array('validate'=>false))) {
											  
							}
					    } 		
						$count++;
					}

				  
					$this->Session->setFlash('<span></span>'.__('The curriculum has been copied successfully'),'default',array('class'=>'success-box success-message'));
					    return $this->redirect(array('action' => 'index'));
					 } else { 
 debug($this->Curriculum->invalidFields()); 
						$this->Session->setFlash('<span></span>'.__('The curriculum could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
					  }
				  } else {
                     $this->Session->setFlash('<span></span>'.__('Please select the curriculum you want to copy. Please, try again.'),'default',array('class'=>'error-box error-message'));
				  }
				} else {
				  $this->Session->setFlash('<span></span>'.__('Please select the curriculum you want to copy. Please, try again.'),'default',array('class'=>'error-box error-message'));
				}
		}
		$earlierCurriculums=$this->Curriculum->find('list',array('conditions'=>array('Curriculum.department_id'=>$this->department_id)));		
		$course_category_values=array('mandatory'=>'Manadatory','optional'=>'Optional','general'=>'General','elective'=>'Elective');
		
			$department_id = $this->department_id;
			$programs = $this->Curriculum->Program->find('list');
			$programTypes = $this->Curriculum->ProgramType->find('list');
			$this->set(compact('departments','programs','programTypes','department_id',
				'course_category_values','earlierCurriculums'));
	}

	public function edit($id = null) {
		$curriculum_exist=$this->Curriculum->find('count',array('conditions'=>array('Curriculum.id'=>$id)));
		if ($curriculum_exist == 0) {
			    $this->Session->setFlash('<span></span>'.__('Invalid curriculum'),
			    'default',array('class'=>'warning-box warning-message'));
			    $this->redirect(array('action' => 'index'));
		    }
		    $elgible_user=$this->Curriculum->find('count',array('conditions'=>array('Curriculum.id'=>$id,
		    'Curriculum.department_id'=>$this->department_id)));
		    if ($elgible_user == 0 ) {
		       $this->Session->setFlash('<span></span>'.__('You are not elgible to add curriculums.'),
			    'default',array('class'=>'warning-box warning-message'));
			    $this->redirect(array('action' => 'index'));
		    }
		if (!empty($this->request->data)) {
		    $this->request->data=$this->Curriculum->preparedAttachment($this->request->data);
			if ($this->Curriculum->saveAll($this->request->data,array('validate'=>'first'))) {
			
				$this->Session->setFlash('<span></span>'.__('The curriculum has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The curriculum could not be saved. Please, try again.'),
				'default',array('class'=>'error-box error-message'));
			}
			
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Curriculum->read(null, $id);
		}
		$department_id = $this->department_id;
		$programs = $this->Curriculum->Program->find('list');
		$programTypes = $this->Curriculum->ProgramType->find('list');
		$course_category_values=array('mandatory'=>'Manadatory','optional'=>'Optional','general'=>'General','elective'=>'Elective');
		
		$this->set(compact('departments','programs','programTypes','department_id','course_category_values'));
	}
    
    function deleteCourseCategory ($id=null,$action_controller_id=null){
        if (!empty($action_controller_id)) {
	$course_category=explode('~',$action_controller_id);
	}	    
	$this->Curriculum->CourseCategory->id = $id;
	if(!$this->Curriculum->CourseCategory->exists()) {
	   $this->Session->setFlash('<span></span>'.__('Invalid id for course category'), 'default', array('class' => 'error-message error-box'));
	if (!empty($course_category[0]) && !empty($course_category[1]) && !empty($course_category[2])) {
	  $this->redirect(array('controller'=>$course_category[1],'action'=>$course_category[0],$course_category[2]));
	} 
	$this->redirect(array('action'=>'index'));	
       }
	$doesCourseCategoryBelongs=$this->Curriculum->find('count',array('conditions'=>array('Curriculum.id'=>$course_category[2])));
	if($doesCourseCategoryBelongs>0){
	 if ($this->Curriculum->CourseCategory->delete($id)) {
	$this->Session->setFlash('<span></span>'.__('Course category deleted'),'default',array('class'=>'success-box success-message'));
	if (!empty($course_category[0]) && !empty($course_category[1]) && !empty($course_category[2])) {
	$this->redirect(array('controller'=>$course_category[1],'action'=>$course_category[0],$course_category[2]));
	}
	$this->redirect(array('action'=>'index'));
	      
       }
     } else {
	$this->Session->setFlash('<span></span>'.__('You are not eligible to delete this course category.'),
'default',array('class'=>'success-box success-message'));		   
      }
      $this->redirect(array('action' => 'index'));
    }
    function delete($id = null) {

	$curriculum_exist=$this->Curriculum->find('count',array('conditions'=>array('Curriculum.id'=>$id)));
	if ($curriculum_exist == 0) {
	$this->Session->setFlash('<span></span>'.__('Invalid curriculum'),
	'default',array('class'=>'warning-box warning-message'));
	$this->redirect(array('action' => 'index'));
	}
	$elgible_user=$this->Curriculum->find('count',array('conditions'=>array('Curriculum.id'=>$id,
	'Curriculum.department_id'=>$this->department_id)));
	if ($elgible_user == 0 ) {
	$this->Session->setFlash('<span></span>'.__('You are not elgible to add curriculums.'),
	'default',array('class'=>'warning-box warning-message'));
	$this->redirect(array('action' => 'index'));
	}

	if ($this->Curriculum->canItBeDeleted($id)) {
	if ($this->Curriculum->delete($id)) {
	$this->Session->setFlash('<span></span>'.__('Curriculum deleted'),
	'default',array('class'=>'success-box success-message'));
	$this->redirect(array('action'=>'index'));
	}
	} else {
	$this->Session->setFlash('<span></span>'.__('You can not delete curriculum .It is attached to other model.'),
	'default',array('class'=>'error-box error-message'));
	$this->redirect(array('action' => 'index'));
	}
      }
      
     function get_courses($curriculum_id=null) {
	  $this->layout='ajax';
	  if ($curriculum_id!=null) {
	    $courses = $this->Curriculum->Course->find('list',array('conditions'=>array('Course.curriculum_id'=>$curriculum_id),'fields'=>array('id','course_code_title')));
	  } else {
	      $model_name=array_keys($this->request->data);
	      $courses = $this->Curriculum->Course->find('list',array('conditions'=>array('Course.curriculum_id'=>$this->request->data[$model_name[0]]['curriculum_id']),'fields'=>array('id','course_code_title')));
	   
	 }
	 $this->set(compact('courses'));
     }
     
    function get_curriculums($department_id=null) {
	   $this->layout='ajax';
	   if($department_id != null) {
	       
	       $curriculums = $this->Curriculum->find('list',
	           array('conditions'=>array('Curriculum.department_id'=>$department_id),'fields'=>array('Curriculum.curriculum_detail')));	   
	            $this->set(compact('curriculums'));
	   } else {
           	            
	           $model_name=array_keys($this->request->data);
	          
	           $curriculums = $this->Curriculum->find('list',
	           array('conditions'=>array('Curriculum.department_id'=>$this->request->data[$model_name[0]]['department_id']),'fields'=>array('Curriculum.curriculum_detail')));    
	       if (!empty($curriculums)) {
	                foreach($curriculums as $ck=>$cv){
	                $courses=$this->Curriculum->Course->find('list',
	           array('conditions'=>array('Course.curriculum_id'=>$ck),'fields'=>array('id','course_code_title')));
	                 break;
	              }
	       }
	       $this->set(compact('curriculums','courses'));
	   }
	}
	
	function get_curriculum_combo ($department_id=null,$program_id=null) {
           $this->layout='ajax';  
         
	       if (!empty($department_id) && !empty($program_id)) {
	       $curriculums = $this->Curriculum->find('list',
	           array('conditions'=>array('Curriculum.department_id'=>$department_id,
	           'Curriculum.program_id'=>$program_id),'fields'=>array('Curriculum.curriculum_detail')));	   
	       } else if (!empty($department_id)) { 
	           $curriculums = $this->Curriculum->find('list',
	           array('conditions'=>array('Curriculum.department_id'=>$department_id),'fields'=>array('Curriculum.curriculum_detail')));	   
	       
	       } else if (!empty($program_id)) {
	         
	          if (!empty($this->department_id) && $this->role_id == ROLE_DEPARTMENT) {
	                $curriculums = $this->Curriculum->find('list',
	           array('conditions'=>array('Curriculum.program_id'=>$program_id,
	           'Curriculum.department_id'=>$this->department_id),'fields'=>array('Curriculum.curriculum_detail')));	 
	          } else {
	              $curriculums = $this->Curriculum->find('list',
	           array('conditions'=>array('Curriculum.program_id'=>$program_id),'fields'=>array('Curriculum.curriculum_detail')));	 
	          }
	          
	             
	       } else {
	          $curriculums=array();
	       }
	       $this->set(compact('curriculums'));	
	
	}
	
	function get_course_category_combo ($curriculum_id=null) {
              $this->layout='ajax';
              $courseCategories=$this->Curriculum->CourseCategory->find('list',
              array('conditions'=>array('CourseCategory.curriculum_id'=>$curriculum_id),
              'fields'=>array('CourseCategory.id','CourseCategory.name')));
              $this->set(compact('courseCategories'));	
	}

	
	 

	 public function lock($id = null) {
		$this->Curriculum->id = $id;
		if (!$this->Curriculum->exists()) {
			throw new NotFoundException(__('Invalid Curriculum '));
		}
		$curriculums=$this->Curriculum->find('first',
	           	array('conditions'=>array('Curriculum.id'=>$this->Curriculum->id),'recursive'=>-1));
		$lock=($curriculums['Curriculum']['lock']==0 ? 1:0);
		$message=($lock==1 ? 'Locked ': ' Unlocked');
		
		$this->request->allowMethod('post', 'lock');
         
		if ($this->Curriculum->saveField('lock',$lock)) {

			$this->Session->setFlash('<span></span>'.__('Curriculum is '.$message),'default',array('class'=>'success-box success-message'));
		} else {
			
			$this->Session->setFlash('<span></span>'.__('Curriculum is not able '.$message.' Please try again.'),'default',array('class'=>'error-box error-message'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	
	 public function approve($id = null) {
		$this->Curriculum->id = $id;
		if (!$this->Curriculum->exists()) {
			throw new NotFoundException(__('Invalid Curriculum '));
		}
		$curriculums=$this->Curriculum->find('first',
	           	array('conditions'=>array('Curriculum.id'=>$this->Curriculum->id)));
		$approve=$curriculums['Curriculum']['registrar_approved']==0 ? 1:0;
		$message=$approve==1 ? 'Approved By Registrar ': ' Pending for Approval';
		$this->request->allowMethod('post', 'approve');

		if ($this->Curriculum->saveField('registrar_approved',$approve)) {

			$this->Session->setFlash('<span></span>'.__('Curriculum is '.$message),'default',array('class'=>'success-box success-message'));
		} else {
			
			$this->Session->setFlash('<span></span>'.__('Curriculum is not able '.$message.' Please try again.'),'default',array('class'=>'error-box error-message'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Search'])){
               
                    $search_session = $this->request->data['Search'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data');
        	$this->request->data['search']=true;
        	$this->request->data['Search'] = $search_session;

        } 


    }
}
