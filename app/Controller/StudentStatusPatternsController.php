<?php
class StudentStatusPatternsController extends AppController {

	var $name = 'StudentStatusPatterns';
	 var $menuOptions = array(
        'parent' => 'grades',
        'alias' => array(
                    'index' => 'View all Status Pattern',
                    'add' => 'Add New Status Pattern',
                      'regenerate_status'=>'Regenerate Student Status',
			'regenerate_academic_status'=>'Regenerate Selected Student Academic Status'
         )
    );
    
    var $components =array('AcademicYear');
	
    public function beforeFilter() {
          parent::beforeFilter();
         
    }

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
       
	}


	function index() {
		$this->StudentStatusPattern->recursive = 0;
		$this->set('studentStatusPatterns', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid student status pattern'),
			'default',array('class'=>'info-box info-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('studentStatusPattern', $this->StudentStatusPattern->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->StudentStatusPattern->create();
			if ($this->StudentStatusPattern->save($this->request->data)) {
			
				$this->Session->setFlash('<span></span>'.__('The student status pattern has been saved'),
			'default',array('class'=>'success-box success-message'));
			
				return $this->redirect(array('action' => 'index'));
			} else {
			
				$this->Session->setFlash('<span></span>'.__('The student status pattern could not be saved. 
				Please, try again.', true),'default',array('class'=>'error-box error-message'));
		
			}
		}
		$programs = $this->StudentStatusPattern->Program->find('list');
		$programTypes = $this->StudentStatusPattern->ProgramType->find('list');
		$this->set(compact('programs', 'programTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			
			$this->Session->setFlash('<span></span>'.__('Invalid student status pattern'),
			'default',array('class'=>'info-box info-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->StudentStatusPattern->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The student status pattern has been saved'),
			'default',array('class'=>'success-box success-message'));
			
				return $this->redirect(array('action' => 'index'));
			} else {
			
				$this->Session->setFlash('<span></span>'.__('The student status pattern could not be saved. 
				Please, try again.', true),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->StudentStatusPattern->read(null, $id);
		}
		$programs = $this->StudentStatusPattern->Program->find('list');
		$programTypes = $this->StudentStatusPattern->ProgramType->find('list');
		$this->set(compact('programs', 'programTypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for student status pattern'),
			'default',array('class'=>'info-box info-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->StudentStatusPattern->delete($id)) {
			
			$this->Session->setFlash('<span></span>'.__('Student status pattern deleted'),
			'default',array('class'=>'success-box success-message'));
			
			
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<span></span>'.__('Student status pattern was not deleted.'),
		'default',array('class'=>'error-box error-message'));
				
		return $this->redirect(array('action' => 'index'));
	}
	
	
	/***
	*Regenerate Student Academic Status given published course 
	*/
   public function regenerate_status ($published_course_id = null) {
		$published_course_combo_id = null;
		$department_combo_id = null;
		$publishedCourses = array();
		$have_message = false;
		$programs = $this->StudentStatusPattern->Program->find('list');
		$program_types = $this->StudentStatusPattern->ProgramType->find('list');
		if(!empty($this->department_id) && $this->role_id==ROLE_DEPARTMENT) {
			/*			
			$departments = ClassRegistry::init('Department')->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));
			*/
			$department_ids[]=$this->department_id;
		    $college_ids=array();
			$departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(0,$department_ids,$college_ids);
		} else {		
		$departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(0, 
		$this->department_ids, $this->college_ids);
		}
		//List published course button is clicked
		if(isset($this->request->data['listPublishedCourses'])) {
			//There is nothing to do here for the time being
			$this->Session->delete('search_data_statusgeneration');
			// $publishedCourses=array();
                       $this->request->data['StudentStatusPattern']['published_course_id'] = null;
		}

		if(!empty($this->request->data)) {
			
			$department_id = $this->request->data['StudentStatusPattern']['department_id'];
			$department_combo_id = $department_id;
			$college_id = explode('~', $department_id);
                        
			$publishedCourses = array();
			if(is_array($college_id) && count($college_id) > 1) {
				
				$college_id = $college_id[1];
				$publishedCourses = ClassRegistry::init('CourseInstructorAssignment')
				->listOfCoursesCollegeFreshTakingOrgBySection($college_id, 
				$this->request->data['StudentStatusPattern']['acadamic_year'], 
				$this->request->data['StudentStatusPattern']['semester'], 
$this->request->data['StudentStatusPattern']['program_id'], 
				$this->request->data['StudentStatusPattern']['program_type_id']);
			}
			else {
				$publishedCourses =ClassRegistry::init('CourseInstructorAssignment')->listOfCoursesSectionsTakingOrgBySection($department_id, 
				$this->request->data['StudentStatusPattern']['acadamic_year'], $this->request->data['StudentStatusPattern']['semester'], 
				$this->request->data['StudentStatusPattern']['program_id'], 
				$this->request->data['StudentStatusPattern']['program_type_id']);
			}
			if(empty($publishedCourses)) {
				$this->Session->setFlash('<span></span>'.__('There is no published courses for the selected filter criteria.'), 'default',array('class'=>'info-box info-message'));
					return $this->redirect(array('action' => 'regenerate_status'));
			}
			else
				$publishedCourses = array('0' => '--- Select Published Course ---') + $publishedCourses;
			// $this->set(compact('publishedCourses'));
		}
		
		//When published course is selected from the combo box
		if(!empty($published_course_id) || (isset($this->request->data['StudentStatusPattern']['published_course_id']) 
		&& $this->request->data['StudentStatusPattern']['published_course_id'] != 0)) {
		
			if(isset($this->request->data['StudentStatusPattern']['published_course_id']))
		        $published_course_id = $this->request->data['StudentStatusPattern']['published_course_id'];
			
			$publishedCourses = array();
			
			$published_course =ClassRegistry::init('PublishedCourse')->find('first', 
				array(
					'conditions' => array('PublishedCourse.id' => $published_course_id),
					'contain' => array('Section')
				)
			);
			$departmentIds=array();
		    $collegeIds=array();
			if(!empty($this->department_id) && $this->role_id==ROLE_DEPARTMENT) {
			  $departmentIds[]=$this->department_id;
			} else if (!empty($this->college_id) && $this->role_id==ROLE_COLLEGE) {
			  $collegeIds[]=$this->college_id;
			} else if (!empty($this->department_ids)) {
			  $departmentIds=$this->department_ids;
			} else if (!empty($this->college_ids)) {
			  $collegeIds=$this->college_ids;
			}
			if(empty($published_course) || (!empty($published_course['PublishedCourse']['department_id']) &&
			 !in_array($published_course['PublishedCourse']['department_id'], $departmentIds)) || 
			 (!empty($published_course['PublishedCourse']['college_id']) && 
			 !in_array($published_course['PublishedCourse']['college_id'], $collegeIds))) {
			   
			    
				$this->Session->setFlash('<span></span>'.__('Please select a valid published course.'), 
				'default',array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => 'regenerate_status'));
			    
			}
			else {
			
				if(empty($published_course['PublishedCourse']['department_id'])) {
					$publishedCourses = ClassRegistry::init('CourseInstructorAssignment')->
					listOfCoursesCollegeFreshTakingOrgBySection($published_course['PublishedCourse']['college_id'], 
					$published_course['PublishedCourse']['academic_year'], 
					$published_course['PublishedCourse']['semester'], 
					$published_course['PublishedCourse']['program_id'], 
					$published_course['PublishedCourse']['program_type_id']);
					$department_combo_id = 'c~'.$published_course['PublishedCourse']['college_id'];
				}
				else {
					$publishedCourses = ClassRegistry::init('CourseInstructorAssignment')->
					listOfCoursesSectionsTakingOrgBySection($published_course['PublishedCourse']['department_id'],
					 $published_course['PublishedCourse']['academic_year'], 
					 $published_course['PublishedCourse']['semester'], 
					 $published_course['PublishedCourse']['program_id'], 
					 $published_course['PublishedCourse']['program_type_id']);
					$department_combo_id = $published_course['PublishedCourse']['department_id'];
					
			    }
			}
			$published_course_combo_id = $published_course_id;
			
			if (!empty($published_course_id)) {
			// debug($published_course_id);
			
			 $result=ClassRegistry::init('Student')->StudentExamStatus->updateAcdamicStatusByPublishedCourse(
			 $published_course_id);
			
			 if($result) {
			    $this->Session->setFlash('<span></span>'.__('Status Regenerated Successfully.'), 
				'default',array('class'=>'success-box success-message'));
				$this->Session->delete('search_data_statusgeneration');
          		  }
            
             
                    }   
		    $program_id = $published_course['PublishedCourse']['program_id'];
		    $program_type_id = $published_course['PublishedCourse']['program_type_id'];
		    $department_id = $published_course['PublishedCourse']['department_id'];
		    $academic_year_selected = $published_course['PublishedCourse']['academic_year'];
		    $semester_selected = $published_course['PublishedCourse']['semester'];
		}
             
		$this->set(compact('publishedCourses', 'programs', 'program_types', 'departments',
		 'published_course_combo_id', 'department_combo_id',
		  'program_id', 'program_type_id', 'department_id', 
		  'academic_year_selected', 'semester_selected'));
            
	}
	
	
    /*
     *regenerate individual student academic status 
     */
     
     function regenerate_individual_academic_status() {
	       
        if (!empty($this->request->data) && isset($this->request->data['regenerate'])) {


		$graduated=ClassRegistry::init('Student')->find('first',array(
			'conditions'=>array('Student.id'=>$this->request->data['Student']['id'],'Student.graduated'=>1),
			'recursive'=>-1
		));

	    if($graduated['Student']['graduated']){
		    $this->Session->setFlash('<span></span>'.__($graduated['Student']['full_name'] .' ('. $graduated['Student']['studentnumber'] .') is a graduated student. 
			    Status Regeneration for graduated studnt is not allowed'),'default',array('class'=>'info-box info-message'));
		    return ;
	     }
	
		
	     // read hidden status id for delete 
             if (!empty($this->request->data['StudentStatusPattern'])) {
                $statusListForDelete=array_keys($this->request->data['StudentStatusPattern']);
             }
            
             $studentSectionAttended= ClassRegistry::init('StudentsSection')->find('list',
             array('conditions'=>array('StudentsSection.student_id'=>$this->request->data['Student']['id']
             ),'fields'=>array('StudentsSection.section_id','StudentsSection.student_id')));
         $course_registered=ClassRegistry::init('CourseRegistration')->find('list',
            array('conditions'=>array('CourseRegistration.student_id'=>$this->request->data['Student']['id']),
            'order' => array('CourseRegistration.academic_year ASC',
            'CourseRegistration.semester ASC'),'recursive'=>-1,
'fields'=>array('CourseRegistration.published_course_id',
'CourseRegistration.published_course_id')));

		$course_added=ClassRegistry::init('CourseAdd')->find('list',
            array('conditions'=>array('CourseAdd.student_id'=>$this->request->data['Student']['id']),
            'order' => array('CourseAdd.academic_year ASC',
            'CourseAdd.semester ASC'),'recursive'=>-1,
'fields'=>array('CourseAdd.published_course_id',
'CourseAdd.published_course_id')));
         $listofputaken=$course_registered+$course_added;
		
         $listPublishedCourseTakenBySection=ClassRegistry::init('PublishedCourse')->find('all',
            array('conditions'=>array('PublishedCourse.id'=>$listofputaken),
            'order' => array('PublishedCourse.academic_year ASC',
            'PublishedCourse.semester ASC'),'recursive'=>-1));
         if (isset($statusListForDelete) && !empty($statusListForDelete)) { 
                ClassRegistry::init('StudentExamStatus')->deleteAll(array('StudentExamStatus.id'=>$statusListForDelete), false);
            }
           
            $statusgenerated=false;
            foreach($listPublishedCourseTakenBySection as $value) {
            
                 $checkIfStatusIsGenerated=ClassRegistry::init('Student')->StudentExamStatus->find('count',array('conditions'=>array('StudentExamStatus.student_id'=>$this->request->data['Student']['id'],'StudentExamStatus.academic_year'=>$value['PublishedCourse']['academic_year'],'StudentExamStatus.semester'=>$value['PublishedCourse']['semester'])));
		if(!$checkIfStatusIsGenerated) {
			
            $statusgenerated=ClassRegistry::init('Student')->StudentExamStatus->updateAcdamicStatusByPublishedCourseOfStudent($value['PublishedCourse']['id'],$this->request->data['Student']['id']);
           
            
		  if($statusgenerated) {
			//debug($value);
		   } else {
			debug($value);
		   }

		}	
	  }
			 
	   if ($statusgenerated) {
			     $this->Session->setFlash('<span></span>'.__('Status Regenerated Successfully.'), 
				    'default',array('class'=>'success-box success-message'));
            
        }
           
           
            $this->request->data['regeneratestudentstatus']=true;
   
           
	}
       
        // Function to load/save search criteria.
               
        if ($this->Session->read('search_data_statusgeneration') && 
        !isset($this->request->data['regeneratestudentstatus'])) {
                       $this->request->data['regeneratestudentstatus']=true;
                       $this->request->data['Student']=$this->Session->read('search_data_statusgeneration');
                       $this->set('hide_search',true);
                      
        }
        
       
           
        if (!empty($this->request->data) && isset($this->request->data['regeneratestudentstatus'])) {
			$this->Session->delete('search_data_statusgeneration');
			$everythingfine=true;
			if (empty($this->request->data)){
			      $this->Session->setFlash('<span></span> '.__('Please provide
			          the student number (ID) you want to regenerate or update status.', true),
			          'default',array('class'=>'error-box error-message'));  
			       $everythingfine=false;
			}
		        $department_id = null;
			$college_id =null;
			if (!empty($this->department_ids)) {
				$department_id = $this->department_ids;
			} else if (!empty($this->department_id)) { 
			        $department_id = $this->department_id;
			} else {
				
				if($this->role_id == ROLE_REGISTRAR) {
                                       if(!empty($this->department_ids)) {
						$department_id=$this->department_ids;
				       } else if (!empty($this->college_ids)) {
                                            $college_id=$this->college_ids;
				       }  
				}				
			}
			
			if ($everythingfine) {
				
				if (!empty($department_id)) {
				   $check_id_is_valid=ClassRegistry::init('Student')->
			            find('count',
			            array('conditions'=>array('Student.studentnumber'=>
				    trim($this->request->data['Student']['studentnumber']),
				    'Student.graduated'=>0
				    
				    )));
				} else if (!empty($college_id)) {
                                   $check_id_is_valid=ClassRegistry::init('Student')->
			            find('count',
			            array('conditions'=>array('Student.studentnumber'=>
				    trim($this->request->data['Student']['studentnumber']),'Student.college_id'=>$college_id,
				    'Student.department_id is null',
				    'Student.graduated'=>0
				    )));
				}
			           
			           
			             if ($check_id_is_valid>0) {
			                 // do something if needed
			                $everythingfine=true;
			             } else {
					     $everythingfine=false;


					$check_id_is_valid = ClassRegistry::init('Student')->find('count', array(
						'conditions' => array(
							'Student.studentnumber' => trim($this->request->data['Student']['studentnumber']),
							'Student.department_id' => $department_id,
							'Student.graduated'  => 1,
						)
					));

					if ($check_id_is_valid) {

						$studentDetails = ClassRegistry::init('Student')->find('first', array(
							'conditions' => array(
								'Student.studentnumber' => trim($this->request->data['Student']['studentnumber']),
								'Student.department_id' => $department_id,
							),
							'fields' => array('Student.full_name', 'Student.studentnumber'),
							'recursive' => -1
						));

						$this->Session->setFlash('<span></span>'.__($studentDetails['Student']['full_name'] .' ('. $studentDetails['Student']['studentnumber'] .') 
							is a graduated student. Status Regeneration for graduated studnt is not allowed'),'default',array('class'=>'info-box info-message'));

					} else {

						$check_id_is_valid = ClassRegistry::init('Student')->find('count', array(
							'conditions' => array(
								'Student.studentnumber' => trim($this->request->data['Student']['studentnumber']),
							)
						));

						if (!$check_id_is_valid) {
							$this->Session->setFlash('<span></span>'.__('The provided student number is not valid, Please check and try again.'),
							'default',array('class'=>'info-box info-message')
							);
						} else {
							
							 $this->Session->setFlash('<span></span>'.__('You do not have the privilege to access the selected student\'s profile.'),
                                                        'default',array('class'=>'error-box error-message'));

						}

					}

			            
			             }
			}
			             
			//debug($this->request->data);
			if ($everythingfine) {
			          
			          $this->__init_search();
			          $studentDbId=ClassRegistry::init('Student')->field('Student.id',array('Student.studentnumber'=>trim($this->request->data['Student']['studentnumber'])));
			          $student_section_exam_status=ClassRegistry::init('Student')->
	                get_student_section($studentDbId,null,null);
	               
			           
			          $alreadyGeneratedStatus=ClassRegistry::init('StudentExamStatus')->find('all',
			          array('conditions'=>array('StudentExamStatus.student_id'=>$studentDbId),
			          'contain'=>array('Student'=>array('College','Department','Program','ProgramType'),
			          'AcademicStatus')));
			     
			        
			          $this->set('hide_search',true);
			          $this->set(compact('alreadyGeneratedStatus','student_section_exam_status'));  
		   }
	    }

	      $programs = $this->StudentStatusPattern->Program->find('list');
	      $program_types = $this->StudentStatusPattern->ProgramType->find('list');

           	if (!empty($this->department_ids)) {
		$yearLevels = ClassRegistry::init('YearLevel')->find('list',
		array('conditions'=>array('YearLevel.department_id' => $this->department_ids),
'fields'=>array('name','name')));
		} else if (!empty($this->department_id)) { 
                    $yearLevels = ClassRegistry::init('YearLevel')->find('list',
		array('conditions'=>array('YearLevel.department_id' => $this->department_id),
'fields'=>array('name','name')));
		} else {
		     $yearLevels[0] = "Pre/Unassign Freshman";
		   
		}

	    $this->set(compact('programs','program_types','yearLevels'));
	 }
   
   
       function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Student'])){
               
                    $search_session = $this->request->data['Student'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_statusgeneration', $search_session);
                
        } else {

        	$search_session = $this->Session->read('ssearch_data_statusgeneration');
        	$this->request->data['Student'] = $search_session;
        } 

     }
     
     function regenerate_academic_status($section_id = null) {

	    if (!empty($this->department_ids)) {
	    	
			$this->__regenerate_status($section_id, 0);
			
			//$this->_generateBySection($section_id);
	    } else if (!empty($this->department_id) && $this->role_id==ROLE_DEPARTMENT) {
		  $this->__regenerate_status($section_id, 0);
		} else {
	   		$this->__regenerate_status($section_id, 1);
	    }
     }
     
    
     
     private function __regenerate_status($section_id = null, $freshman_program = 0) {
       /*
		1. Retrieve list of sections based on the given search criteria
		2. Display list of sections
		3. Up on the selection of section, display list of students with check-box
		4. Prepare student password issue/reset in PDF for the selected students
		*/
		
		$programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		if ($freshman_program==0 && !empty($this->department_ids)) {
		$yearLevels = ClassRegistry::init('YearLevel')->find('list',array('conditions'=>array('YearLevel.department_id' => $this->department_ids),'fields'=>array('name','name')));
		} else if (!empty($this->department_id) && $this->role_id==ROLE_DEPARTMENT) {
		  $yearLevels = ClassRegistry::init('YearLevel')->find('list',array('conditions'=>array('YearLevel.department_id' => $this->department_id),'fields'=>array('name','name')));
		} else {
		     $yearLevels[0] = "Pre/Unassign Freshman";
		   
		}
       
		$departments[0] = 0;
          
          //Get sections button is clicked
		if(isset($this->request->data['regenerateAllStatus'])) 
		{
			
			//delete their previous status 
           
             $isTheDeletionSuccessful=ClassRegistry::init('StudentExamStatus')->
deleteAll(array('StudentExamStatus.student_id in (select id from students where admissionyear >="'.$this->AcademicYear->get_academicYearBegainingDate($this->request->data['StudentStatusPattern']['acadamic_year']).'" and admissionyear <="'.$this->AcademicYear->nextAcademicYearBeginingDate($this->request->data['StudentStatusPattern']['acadamic_year']). '" and department_id='.
	$this->request->data['StudentStatusPattern']['program_id'].' and program_id='.
	$this->request->data['StudentStatusPattern']['program_id'].' and program_id='.$this->request->data['StudentStatusPattern']['program_type_id'].' )'),false);
           
	        if($isTheDeletionSuccessful)
	        {
	           $done=ClassRegistry::init('Student')->regenerate_academic_status_by_batch($this->request->data['StudentStatusPattern']['department_id'],$this->request->data['StudentStatusPattern']['acadamic_year'],0,0,0,0,$this->request->data['StudentStatusPattern']['program_id'],
				$this->request->data['StudentStatusPattern']['program_type_id']);
				if($done){
					$this->Session->setFlash('<span></span>'.__('Status Regenerated Successfully.'), 'default',array('class'=>'success-box success-message'));
				}
	        }
       
		}        
         //Get sections button is clicked
		if(isset($this->request->data['listSections'])) {
			//debug($this->request->data['listSections']);
			if(!empty($this->request->data['listSections'])){
                $section_id=0;
			}
		    $this->__init_search_student();
		    if (!empty($this->request->data['StudentStatusPattern']['department_id']))
            {
			
               $year_level_selected_id=ClassRegistry::init('YearLevel')->field('YearLevel.id',array('YearLevel.name'=>$this->request->data['StudentStatusPattern']['year_level_id'],'YearLevel.department_id'=>$this->request->data['StudentStatusPattern']['department_id']));
		    } else {
		        $year_level_selected_id=null;
		    }
                       
			$options = array();
			$options = array(
						'conditions' =>
						array(
					
							'Section.program_id' => $this->request->data['StudentStatusPattern']['program_id'],
							'Section.program_type_id' => $this->request->data['StudentStatusPattern']['program_type_id']
						),
						'recursive' => -1
			 );
                        
			if($freshman_program == 1) {
				$options['conditions'][] = 
					array(
						'Section.college_id' => 
$this->request->data['StudentStatusPattern']['college_id'],
						 'Section.archive' =>0,
						'Section.department_id IS NULL',
						'Section.year_level_id IS NULL'
					);
			}
			else {
			  
				$options['conditions'][] = array(
				    'Section.department_id' => $this->request->data['StudentStatusPattern']['department_id'],
		
				    'Section.year_level_id' => $year_level_selected_id,
				    
				    );
			}
			
			$sections = ClassRegistry::init('Section')->find('list', $options);
			
			if ($freshman_program == 1) {
			       $sections['pre']="All";
			       asort($sections);
			      
			}
			
			if(empty($sections)) {
			    $this->Session->setFlash('<span></span>'.__('There is no section by the selected search criteria.'), 'default', array('class'=>'info-box info-message'));
			}
			else {
				$sections = array('0' => '--- Select Section ---') + $sections;
			}
			$year_level_selected = $this->request->data['StudentStatusPattern']['year_level_id'];
			
			$program_id = $this->request->data['StudentStatusPattern']['program_id'];
			$program_type_id = $this->request->data['StudentStatusPattern']['program_type_id'];
		} 

                //Section is selected from the combo box
		
		if(isset($this->request->data['regenerateStatus']) || (!empty($section_id) && ($section_id != 0 || strcasecmp($section_id,"pre")==0))) {
		    $this->__init_search_student();
	        if (!empty($this->request->data['StudentStatusPattern']['department_id'])) {
			
                $year_level_selected_id=ClassRegistry::init('YearLevel')->field('YearLevel.id',array('YearLevel.name'=>$this->request->data['StudentStatusPattern']['year_level_id'],'YearLevel.department_id'=>$this->request->data['StudentStatusPattern']['department_id']));
		    } else {
		        $year_level_selected_id=null;
		    }
            if(isset($this->request->data['regenerateStatus'])) {    
				$section_id = $this->request->data['StudentStatusPattern']['section_id'];
			}
			
			if ($section_id != "pre") {
			    $section_detail = ClassRegistry::init('Section')->find('first',
				    array(
					    'conditions' =>
					    array(
						    'Section.id' => $section_id
					    ),
					    'recursive' => -1
				    )
			    );
			    $year_level_selected = $section_detail['Section']['year_level_id'];
			    $program_id = $section_detail['Section']['program_id'];
			    $program_type_id = $section_detail['Section']['program_type_id'];
			}
			//Student list retrial
			
			if (strcasecmp($section_id, "pre") ==0) {
			    
			    $students_in_section =ClassRegistry::init('Student')->listStudentByAdmissionYear(null,$this->request->data['StudentStatusPattern']['college_id'],$this->request->data['StudentStatusPattern']['acadamic_year'],$this->request->data['StudentStatusPattern']['name']);
			    // $sections['pre']="All";
			    // asort($sections);
			 
			} else {
			    $students_in_section = ClassRegistry::init('Section')->getSectionStudents($section_id,$this->request->data['StudentStatusPattern']['name']);                 
			}
		   $options = array();
		   $options = array(
						'conditions' =>
						array(
							'Section.program_id' => $this->request->data['StudentStatusPattern']['program_id'],
							'Section.program_type_id' => $this->request->data['StudentStatusPattern']['program_type_id']
						),
						'recursive' => -1
		    );

			if($freshman_program == 1) {
				$options['conditions'][] = 
					array(
						'Section.college_id' => $this->request->data['StudentStatusPattern']['college_id'],
						'Section.academicyear' =>$this->request->data['StudentStatusPattern']['status_acadamic_year'],
						'Section.department_id IS NULL',
						'Section.year_level_id IS NULL'
					);
			}
			else {
			  
				$options['conditions'][] = array(
				    'Section.department_id' => $this->request->data['StudentStatusPattern']['department_id'],
					'Section.academicyear' =>$this->request->data['StudentStatusPattern']['status_acadamic_year'],
				    'Section.year_level_id' => $year_level_selected_id
				    );
			}
			
			$sections = ClassRegistry::init('Section')->find('list', $options);

			
		    //Give an option to get all freshman studnet of the college
		    if ($freshman_program == 1) {
			       $sections['pre']="All";
			       asort($sections);		      
			}
			
			if(empty($sections)) {
				$this->Session->setFlash('<span></span>'.__('There is no section by the selected search criteria.'), 'default', array('class'=>'info-box info-message'));
			}
			else {
				$sections = array('0' => '--- Select Section ---') + $sections;
			}
		} else {
		   
		}

		if($section_id != 0 ){
            $selectedSectionsDetail = ClassRegistry::init('Section')->find('first', array('conditions'=>array('Section.id'=>$section_id)));

            $sections = ClassRegistry::init('Section')->find('list', array('conditions'=>array(
            	'Section.department_id'=>$selectedSectionsDetail['Section']['department_id'],
            	'Section.year_level_id'=>$selectedSectionsDetail['Section']['year_level_id'],
            	'Section.program_type_id'=>$selectedSectionsDetail['Section']['program_type_id'],
            	'Section.program_id'=>$selectedSectionsDetail['Section']['program_id'],
            	'Section.academicyear'=>$selectedSectionsDetail['Section']['academicyear'],
            	'Section.college_id'=>$selectedSectionsDetail['Section']['college_id']
            	)));

		}
		
               //Issue Student Password button is clicked
		if(isset($this->request->data['regenerateStatus'])) {
			//debug($this->request->data);
			foreach($this->request->data['StudentStatusPattern'] as $key => $student) {
				if (is_numeric($key)) {
				   
				    if (isset($student['gp']) && $student['gp']==1) {
					      $student_ids[] =  $student['student_id'];
					
			            }
			     } 
			}
			if($this->_generateBySection($this->request->data['StudentStatusPattern']['section_id'],$student_ids)){
				$this->Session->setFlash('<span></span>'.__('Status Regenerated Successfully.'), 'default',array('class'=>'success-box success-message'));
			}
			/*
			$student_ids = array();
			$statusgenerated=false;
			foreach($this->request->data['StudentStatusPattern'] as $key => $student) {
				if (is_numeric($key)) {
				   
				    if (isset($student['gp']) && $student['gp']==1) {
					      $student_ids[] =  $student['student_id'];
					
			            }
			     } 
			}

            if(empty($student_ids)) {
				$this->Session->setFlash('<span></span>'.__('You are required to select at 
				least one student.', true), 'default', array('class'=>'error-box error-message'));
			}
			else {           
				$studentSectionAttended= ClassRegistry::init('StudentsSection')->find('list',array('conditions'=>array(
					'StudentsSection.student_id'=>$student_ids,

					'StudentsSection.section_id in 
					(select id from sections where academicyear="'.
					$this->request->data['StudentStatusPattern']['status_acadamic_year'].'") '),'fields'=>array('StudentsSection.section_id',
'StudentsSection.student_id')));
				
				$listPublishedCourseTakenBySection=ClassRegistry::init('PublishedCourse')->find('list',array('conditions'=>array(
					'PublishedCourse.section_id'=>array_keys($studentSectionAttended),
					'PublishedCourse.academic_year'=>$this->request->data['StudentStatusPattern']['status_acadamic_year'],
					'PublishedCourse.semester'=>
					$this->request->data['StudentStatusPattern']['semester']),'order' => array('PublishedCourse.academic_year ASC',
				'PublishedCourse.semester ASC','PublishedCourse.created ASC'),
				'fields'=>array('PublishedCourse.id','PublishedCourse.id'),
				'group'=>array('PublishedCourse.academic_year','PublishedCourse.semester')
				));
               
				$isTheDeletionSuccessful=ClassRegistry::init('StudentExamStatus')->
deleteAll(array('StudentExamStatus.student_id'=>$student_ids,
'StudentExamStatus.semester'=>$this->request->data['StudentStatusPattern']['semester'],'StudentExamStatus.academic_year'=>$this->request->data['StudentStatusPattern']['status_acadamic_year']),false);
              
			 	if($isTheDeletionSuccessful) 
                {
				     foreach($listPublishedCourseTakenBySection as $value) {
				       foreach ($student_ids as $k=>$student_id) {
						if(ClassRegistry::init('ExamGrade')->is_grade_submitted($value)) { 
				$statusgenerated=ClassRegistry::init('StudentExamStatus')->updateAcdamicStatusByStudent($student_id,$value);
				         }
				      }
				    }
				    $this->Session->setFlash('<span></span>'.__('Status Regenerated Successfully.'), 'default',array('class'=>'success-box success-message'));
				} else {
					$this->Session->setFlash('<span></span>'.__('Please try again. '), 'default',array('class'=>'error-box error-message'));
				}  
	      }
	      */
        }

		 if(!empty($this->department_ids)){
	
		      $departments=ClassRegistry::init('Department')->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
	     
	      
		  } else if (!empty($this->college_ids)) {
	
		      $colleges=ClassRegistry::init('College')->find('list',
		      array('conditions'=>array('College.id'=>$this->college_ids)));
		     
			      
		 } else if(!empty($this->department_id) && $this->role_id==ROLE_DEPARTMENT) {
            $departments=ClassRegistry::init('Department')->find('list',array('conditions'=>array('Department.id'=>$this->department_id)));

		 } else if (!empty($this->college_id) && $this->role_id==ROLE_COLLEGE) {
              $colleges=ClassRegistry::init('College')->find('list',array('conditions'=>array('College.id'=>$this->college_id)));    
		 }
          
             $this->set(compact('programs','departments','colleges', 'program_types', 'departments','yearLevels','year_level_selected',
		 'semester_selected', 'program_id', 'program_type_id', 'section_id', 'sections', 
		 'students_in_section'));
	    $this->render('regenerate_academic_status');
     }		

     function __init_search_student() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['StudentStatusPattern'])){
                 
                    $search_session = $this->request->data['StudentStatusPattern'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data_student', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data_student');
        	$this->request->data['StudentStatusPattern'] = $search_session;
        } 

     }

     private function _generateBySection($section_id,$studentLists=array()){
		$statusgenerated=false;
		if(!empty($studentLists)){
			$studentSectionAttended= ClassRegistry::init('StudentsSection')->find('all',
             array('conditions'=>array('section_id'=>$section_id,
             	'student_id'=>$studentLists
             ),'fields'=>array('section_id','student_id')));
		} else {
			 $studentSectionAttended= ClassRegistry::init('StudentsSection')->find('all',
             array('conditions'=>array('section_id'=>$section_id
             ),'fields'=>array('section_id','student_id')));
		}
		
	
		foreach ($studentSectionAttended as $sec_id => $student)
		{
			 $statusListForDelete=ClassRegistry::init('StudentExamStatus')->find('list',
			 	array('conditions'=>array('StudentExamStatus.student_id'=>$student['StudentsSection']['student_id']),'fields'=>array('StudentExamStatus.id','StudentExamStatus.id')));
        	 $course_registered=ClassRegistry::init('CourseRegistration')->find('list',
            array('conditions'=>array('CourseRegistration.student_id'=>$student['StudentsSection']['student_id']),
            'order' => array('CourseRegistration.academic_year ASC',
            'CourseRegistration.semester ASC'),'recursive'=>-1,
'fields'=>array('CourseRegistration.published_course_id',
'CourseRegistration.published_course_id')));

			$course_added=ClassRegistry::init('CourseAdd')->find('list',
	            array('conditions'=>array('CourseAdd.student_id'=>$student['StudentsSection']['student_id']),
	            'order' => array('CourseAdd.academic_year ASC',
	            'CourseAdd.semester ASC'),'recursive'=>-1,
	'fields'=>array('CourseAdd.published_course_id',
	'CourseAdd.published_course_id')));
	      $listofputaken=$course_registered+$course_added;
          $listPublishedCourseTakenBySection=ClassRegistry::init('PublishedCourse')->find('all',
            array('conditions'=>array('PublishedCourse.id'=>$listofputaken),
            'order' => array('PublishedCourse.academic_year ASC',
            'PublishedCourse.semester ASC'),'recursive'=>-1));
          debug($statusListForDelete);
			if (isset($statusListForDelete) && !empty($statusListForDelete)) { 

                ClassRegistry::init('StudentExamStatus')->deleteAll(array('StudentExamStatus.id'=>$statusListForDelete), false);
         }
         debug($listPublishedCourseTakenBySection);         
       foreach($listPublishedCourseTakenBySection as $value) 
       {
		
		$checkIfStatusIsGenerated=ClassRegistry::init('Student')->StudentExamStatus->find('count',array('conditions'=>array('StudentExamStatus.student_id'=>$student['StudentsSection']['student_id'],'StudentExamStatus.academic_year'=>$value['PublishedCourse']['academic_year'],'StudentExamStatus.semester'=>$value['PublishedCourse']['semester'])));
			if(!$checkIfStatusIsGenerated) {

			$statusgenerated=ClassRegistry::init('Student')->StudentExamStatus->updateAcdamicStatusByPublishedCourseOfStudent($value['PublishedCourse']['id'],$student['StudentsSection']['student_id']);

			}	
	  	}
	  }
	  return $statusgenerated;
    }
}
