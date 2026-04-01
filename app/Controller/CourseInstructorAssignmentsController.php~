<?php
class CourseInstructorAssignmentsController extends AppController {

     public $name = 'CourseInstructorAssignments';
     public $menuOptions = array(
            
             'parent' => 'curriculums',
             'exclude' => array('add','get_department','assign_instructor_update','reset_department',
             'assign_instructor',
             'get_assigned_fx_for_instructor', 'get_assigned_courses_of_instructor_by_section_for_combo',
             'get_assigned_grade_entry_for_instructor','assign'),
             'alias' => array(
                    'index' => 'View Instructors Assignment',
		'assign' => 'Assign Instructors to Courses Manually',
					'change_course_department'=>'Change Course Department/Dispatch to other Department',
	'assign_course_instructor'=>'Assign Instructors to Courses'
                   
            )
    );
	public $paginate=array();
    public $components =array('AcademicYear');
	
    public function beforeFilter(){
        parent::beforeFilter();
         //$this->Auth->allow(array('*'));
         $this->Auth->allow('get_assigned_courses_of_instructor_by_section_for_combo', 'get_department',
   'get_assigned_fx_for_instructor',
   'assign_instructor','assign_instructor_update',
         'get_course_instructor_detail',
         'get_assigned_grade_entry_for_instructor','reset_department');  
    }
    public function beforeRender() {

        $acyear_array_data = $this->AcademicYear->acyear_array();
       // $acyear_array_data =$this->AcademicYear->academicYearInArray(date('Y')-11,date('Y'));
        //To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        $this->set(compact('acyear_array_data','defaultacademicyear'));
        unset($this->request->data['User']['password']);
	}

	public function index() {
		$defaultacademicyear=$this->AcademicYear->current_academicyear();
		$conditions_text = array();
		if(empty($this->request->data['CourseInstructorAssignment']['department_id']) && empty($this->request->data['CourseInstructorAssignment']['instructor_name']) && empty($this->request->data['CourseInstructorAssignment']['course_name']) && empty($this->request->data['CourseInstructorAssignment']['academicyear']) &&empty($this->request->data['CourseInstructorAssignment']['semester'])){
			unset($this->request->data['CourseInstructorAssignment']);
		} 
        if(ROLE_COLLEGE == $this->role_id ){
        	$departments = array(); 
        	$departments = $this->CourseInstructorAssignment->PublishedCourse->Department->find('list',
        	array('conditions'=>array('Department.college_id'=>$this->college_id)));
			$departments[1000] ="Pre/Unassign Freshman";
        	$this->set(compact('departments'));
        	if(empty($this->request->data['CourseInstructorAssignment']['department_id'])){
        		$this->department_id = array_keys($departments);
        	} else {
            	$this->department_id = $this->request->data['CourseInstructorAssignment']['department_id'];
            }
        } 
		if(!empty($this->request->data['CourseInstructorAssignment']['instructor_name'])){
			$section_id_array = $this->CourseInstructorAssignment->Staff->find('list',array(
			'conditions'=>array('Staff.first_name LIKE'=>trim($this->request->data['CourseInstructorAssignment']['instructor_name']).'%')
			));
			$conditions_text['CourseInstructorAssignment.staff_id']=$section_id_array;
		}
		if(!empty($this->request->data['CourseInstructorAssignment']['course_name'])){
			$course_id_array = $this->CourseInstructorAssignment->PublishedCourse->Course->find('list',array(
			'conditions'=>array('Course.course_title LIKE'=>'%'.trim($this->request->data['CourseInstructorAssignment']['course_name']).'%')
			));
			if ($this->role_id == ROLE_COLLEGE) {
			    if($this->department_id == 1000 || (empty($this->request->data['CourseInstructorAssignment']['department_id']))){
				    $published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array('conditions'=>array('PublishedCourse.college_id'=>$this->college_id,'PublishedCourse.course_id'=>$course_id_array,'PublishedCourse.drop'=>0)
				    ));
			
			    } 
			
			}
			
			if ($this->role_id == ROLE_DEPARTMENT) {
				$published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array('conditions'=>array('PublishedCourse.given_by_department_id'=>$this->department_id,'PublishedCourse.course_id'=>$course_id_array,'PublishedCourse.drop'=>0)
				));
				
			}
			$conditions_text['CourseInstructorAssignment.published_course_id'] = $published_course_id_array;
		}
		if(!empty($this->request->data['CourseInstructorAssignment']['academicyear'])){
			$conditions_text['CourseInstructorAssignment.academic_year']=$this->request->data['CourseInstructorAssignment']['academicyear'];
		}
		if(!empty($this->request->data['CourseInstructorAssignment']['semester'])){

			$conditions_text['CourseInstructorAssignment.semester'] = $this->request->data['CourseInstructorAssignment']['semester'];;
		}

		if(!empty($conditions_text)){
			if(!isset($conditions_text['CourseInstructorAssignment.published_course_id'])){
				if($this->department_id == 1000 || (empty($this->request->data['CourseInstructorAssignment']['department_id']))) {
					$published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array('conditions'=>array("OR"=>array('PublishedCourse.college_id'=>$this->college_id, 'PublishedCourse.department_id'=>$this->department_id))));
				
				} else {	
					$published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array('conditions'=>array('PublishedCourse.given_by_department_id'=>$this->department_id, 'PublishedCourse.drop'=>0)));
				}
			$conditions_text['CourseInstructorAssignment.published_course_id'] = $published_course_id_array;
			
			}
			$conditions = array($conditions_text);
		} else {
			if($this->department_id == 1000){
				$published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array('conditions'=>array("OR"=>array('PublishedCourse.college_id'=>$this->college_id, 'PublishedCourse.given_by_department_id'=>$this->department_id,'PublishedCourse.drop'=>0))));
			} else {
				$published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array('conditions'=>array('PublishedCourse.given_by_department_id'=>$this->department_id, 'PublishedCourse.drop'=>0)));
			}
			
			$conditions = array('CourseInstructorAssignment.published_course_id'=>$published_course_id_array);

		}

		if(ROLE_COLLEGE == $this->role_id && empty($this->request->data)){
		        $published_course_id_array = $this->CourseInstructorAssignment->PublishedCourse->find('list',array(
			'conditions'=>array("OR"=>array('PublishedCourse.department_id'=>array_keys($departments), 'PublishedCourse.college_id'=>$this->college_id))));
			$conditions = array('CourseInstructorAssignment.published_course_id'=>$published_course_id_array);
			
        	$this->paginate = array('conditions'=>$conditions,'contain'=>array('Section'=>array
			('fields'=>array('Section.name')),'CourseSplitSection','Staff'=>array('fields'=>array('Staff.full_name','Staff.user_id'),
			'conditions'=>array('Staff.active'=>1),'Title'=>array('fields'=>array('Title.title')),'Position'=>
			array('fields'=>array('Position.position'))),'PublishedCourse'=>array('fields'=>array('PublishedCourse.id'),
			'Course'=>array('fields'=>array('Course.course_code_title','Course.credit','Course.course_detail_hours')))), 'order'=>array('CourseInstructorAssignment.created DESC'));
			
            $this->Paginator->settings=$this->paginate;
		    $this->set('courseInstructorAssignments', $this->Paginator->paginate('CourseInstructorAssignment'));

		} else {
		$this->paginate = array('conditions'=>$conditions,'contain'=>array('Section'=>array
			('fields'=>array('Section.name')),'CourseSplitSection','Staff'=>array('fields'=>array('Staff.full_name','Staff.user_id'),
			'conditions'=>array('Staff.active'=>1),'Title'=>array('fields'=>array('Title.title')),'Position'=>
			array('fields'=>array('Position.position'))),'PublishedCourse'=>array('fields'=>array('PublishedCourse.id'),
			'Course'=>array('fields'=>array('Course.course_code_title','Course.credit','Course.course_detail_hours')))), 'order'=>array('CourseInstructorAssignment.created DESC'));
            $this->Paginator->settings=$this->paginate;
		    $this->set('courseInstructorAssignments', $this->Paginator->paginate('CourseInstructorAssignment'));
		}
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid course instructor assignment'));
			return $this->redirect(array('action' => 'index'));
		}
		$courseInstructorAssignment = $this->CourseInstructorAssignment->find('first',array('conditions'=>array('CourseInstructorAssignment.id'=>$id),'contain'=>array('Section'=>array('fields'=>array('Section.id','Section.name')),'CourseSplitSection','Staff'=>array('fields'=>array('Staff.id','Staff.full_name')),'PublishedCourse'=>array('fields'=>array('PublishedCourse.id'),'Course'=>array('fields'=>array('Course.id','Course.course_code_title'))))));
		$this->set(compact('courseInstructorAssignment'));
		//$this->set('courseInstructorAssignment', $this->CourseInstructorAssignment->read(null, $id));

	}

	public function add() {

		if (!empty($this->request->data)) {
			$this->CourseInstructorAssignment->create();
			if ($this->CourseInstructorAssignment->save($this->request->data)) {
				$this->Session->setFlash(__('The course instructor assignment has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course instructor assignment could not be saved. Please, try again.'));
			}
		}
		
		$publishedCourses = $this->CourseInstructorAssignment->PublishedCourse->find('all',
		array('contain'=>array('Course')));
		
		$sections = $this->CourseInstructorAssignment->Section->find('list');
		$staffs = $this->CourseInstructorAssignment->Staff->find('list',array('fields'=>'full_name',
		'conditions'=>array('Staff.college_id'=>$this->college_id)));
		//$courses = $this->CourseInstructorAssignment->Course->find('list');
		$this->set(compact('sections', 'staffs','publishedCourses'));
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid course instructor assignment'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->CourseInstructorAssignment->save($this->request->data)) {
				$this->Session->setFlash(__('The course instructor assignment has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course instructor assignment could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CourseInstructorAssignment->read(null, $id);
		}
		$sections = $this->CourseInstructorAssignment->Section->find('list');
		$staffs = $this->CourseInstructorAssignment->Staff->find('list');
		$courses = $this->CourseInstructorAssignment->Course->find('list');
		$this->set(compact('sections', 'staffs', 'courses'));
	}

	function delete($id = null,$published_course_id = null) {
		if(!empty($published_course_id)){
		
			$course_instructor_assignment_data = $this->CourseInstructorAssignment->PublishedCourse->find('first',array
			('fields'=>array('PublishedCourse.academic_year','PublishedCourse.semester','PublishedCourse.program_id',
			'PublishedCourse.program_type_id','PublishedCourse.year_level_id',),'conditions'=>array
			('PublishedCourse.id'=>$published_course_id,'PublishedCourse.drop'=>0),'contain'=>array()));
			
			$this->Session->write('selected_academicyear',$course_instructor_assignment_data['PublishedCourse']
				['academic_year']);
			$this->Session->write('selected_program_id',$course_instructor_assignment_data['PublishedCourse']
				['program_id']);
			$this->Session->write('selected_program_type_id',$course_instructor_assignment_data['PublishedCourse']
				['program_type_id']);
			$this->Session->write('selected_semester',$course_instructor_assignment_data['PublishedCourse']
				['semester']);
			if(ROLE_COLLEGE != $this->role_id ){
				$this->Session->write('selected_year_level_id',$course_instructor_assignment_data['PublishedCourse']
					['year_level_id']);
			}
		}
		
	    if (!$id) {
			$this->Session->setFlash(__('<span></span> Invalid id for course instructor assignment.'),'default',
				array('class'=>'error-box error-message'));
			if(!empty($published_course_id)){
				return $this->redirect(array('action' => 'assign_course_instructor',$published_course_id));
			} else {
				return $this->redirect(array('action'=>'index'));
			}
		}
		
		$id_exists=$this->CourseInstructorAssignment->find('count',
		array('conditions'=>array('CourseInstructorAssignment.id'=>$id)));
		if ($id_exists==0) {
		      $this->Session->setFlash(__('<span></span> 
		      Invalid id for course instructor assignment.',true),'default',
				    array('class'=>'error-box error-message'));
		   // $this->redirect(array('action' => 'assign',$published_course_id));
		    $this->redirect(array('action' => 'assign_course_instructor',$published_course_id));
		}
		$is_delete_allowed=false;
		
		$deletion_allowed=$this->CourseInstructorAssignment->find('first',
		array('conditions'=>array('CourseInstructorAssignment.id'=>$id),'recursive'=>-1));
		if (!empty($deletion_allowed)){
		    $published_course_ID=$deletion_allowed['CourseInstructorAssignment']['published_course_id'];
		
		    $get_list_registred_courses=$this->CourseInstructorAssignment->PublishedCourse->CourseRegistration->find('all',array('conditions'=>array('CourseRegistration.published_course_id'=>$published_course_ID),
		    'recursive'=>-1));
		   
		     if (!empty($get_list_registred_courses)){
		        $list_registred_courses=array();
		        foreach ($get_list_registred_courses as $grk=>$grv) {
		                $list_registred_courses[]=$grv['CourseRegistration']['id'];
		        }

		        $count_allowed=$this->CourseInstructorAssignment->PublishedCourse->CourseRegistration->ExamGrade->find('count',
		        array('conditions'=>array('ExamGrade.course_registration_id'=>
		        $list_registred_courses)));

		        if ($count_allowed>0) {
		             $is_delete_allowed=false;    
		        } else {
		            $is_delete_allowed=true;
		        }
		     } else {
		       $is_delete_allowed=true;
		     }
		
		}
		
		if ($is_delete_allowed) {
		
		    $pub_cours_id=$this->CourseInstructorAssignment->find('first',
		array('conditions'=>array('CourseInstructorAssignment.id'=>$id),'recursive'=>-1));
		
		   if(ROLE_COLLEGE == $this->role_id ){
				 $isBelongsUrDepartment=$this->CourseInstructorAssignment->PublishedCourse->find('count',
	        array('conditions'=>array('PublishedCourse.college_id'=>$this->college_id,
	        'PublishedCourse.year_level_id'=>0,
	        'PublishedCourse.id'=>$pub_cours_id['CourseInstructorAssignment']['published_course_id'])));
			} else {
			     $isBelongsUrDepartment=$this->CourseInstructorAssignment->PublishedCourse->find('count',
	        array('conditions'=>array('PublishedCourse.given_by_department_id'=>$this->department_id,
	        'PublishedCourse.id'=>$pub_cours_id['CourseInstructorAssignment']['published_course_id'])));
	        
	        
			}
	        
	        if($isBelongsUrDepartment>0) {
			    if ($this->CourseInstructorAssignment->delete($id)) {
				    $this->Session->setFlash(__('<span></span> Course instructor assignment is deleted '),'default',
					    array('class'=>'success-box success-message'));
				    if(!empty($published_course_id)){
					   // $this->redirect(array('action' => 'assign',$published_course_id));
					    $this->redirect(array('action' => 'assign_course_instructor',$published_course_id));
				    } else {
					    $this->redirect(array('action'=>'index'));
				    }
			    }
		   } else {
	         	$this->Session->setFlash(__('<span></span> You are not elegible to delete this instructor assignment.'),'default',array('class'=>'error-box error-message'));	   
		     //$this->redirect(array('action' => 'assign',$published_course_id));
		     $this->redirect(array('action' => 'assign_course_instructor',$published_course_id));
		   }	
		}
		$this->Session->setFlash(__('<span></span> Course instructor assignment was not deleted. The instructor has 
			already submitted grade.',true),'default',array('class'=>'error-box error-message'));
		if(!empty($published_course_id)){
			//$this->redirect(array('action' => 'assign',$published_course_id));
			return $this->redirect(array('action' => 'assign_course_instructor',$published_course_id));
		} else {
			return $this->redirect(array('action'=>'index'));
		}
	}
	//old for instructor assignment
	public function  assign($for_assign_instructor = null) {
		if(!empty($for_assign_instructor)){
		$this->request->data['CourseInstructorAssignment']['academicyear'] = $this->Session->read('selected_academicyear');
		$this->request->data['CourseInstructorAssignment']['program_id'] = $this->Session->read('selected_program_id');
		$this->request->data['CourseInstructorAssignment']['program_type_id'] = $this->Session->read('selected_program_type_id');
		if(ROLE_COLLEGE != $this->role_id ){
			$this->request->data['CourseInstructorAssignment']['year_level_id'] = $this->Session->read('selected_year_level_id');
		}
		$this->request->data['CourseInstructorAssignment']['semester'] = $this->Session->read('selected_semester');
		$this->request->data['search'] = true;
		}
		$programs = $this->CourseInstructorAssignment->Section->Program->find('list');
        $programTypes = $this->CourseInstructorAssignment->Section->ProgramType->find('list');
		$yearLevels = $this->CourseInstructorAssignment->Section->YearLevel->find('list',array('conditions'=>
            array('YearLevel.department_id'=>$this->department_id)));
        $isbeforesearch = 1;
        $this->set(compact('programs','programTypes','isbeforesearch','yearLevels'));
		if(!empty($this->request->data) && isset($this->request->data['search'])) {

			$everythingfine=false;
			switch($this->request->data) {
			        case empty($this->request->data['CourseInstructorAssignment']['academicyear']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the academic year you want to assign instructor for publish courses.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['CourseInstructorAssignment']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester you want to assign instructor for publish courses. '),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['CourseInstructorAssignment']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to assign instructor for publish courses. '),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['CourseInstructorAssignment']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to assign instructor for publish courses. '),'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			 if(ROLE_COLLEGE != $this->role_id ){
				if(empty($this->request->data['CourseInstructorAssignment']['year_level_id'])){
					$this->Session->setFlash('<span></span> '.__('Please select the year level you want to assign 
					instructor for publish courses. ', true),'default',array('class'=>'error-box error-message')); 
					$everythingfine=false;
				} else {
					$everythingfine=true;
				}
			}
			if ($everythingfine) {
			    $selected_academic_year =$this->request->data['CourseInstructorAssignment']['academicyear'];
			    $selected_program =$this->request->data['CourseInstructorAssignment']['program_id'];
				$selected_program_type = $this->request->data['CourseInstructorAssignment']['program_type_id'];
				$selected_semester = $this->request->data['CourseInstructorAssignment']['semester'];
				$program_type_id=$selected_program_type;
				$find_the_equvilaent_program_type=unserialize($this->CourseInstructorAssignment->Section->ProgramType->
					field('ProgramType.equivalent_to_id',array('ProgramType.id'=>$selected_program_type)));
				if (!empty($find_the_equvilaent_program_type)) {
					$selected_program_type_array=array();
					$selected_program_type_array[] =$selected_program_type;
					$program_type_id=array_merge($selected_program_type_array,$find_the_equvilaent_program_type);
				}
				if(ROLE_COLLEGE != $this->role_id ){
					$selected_year_level = $this->request->data['CourseInstructorAssignment']['year_level_id'];
					$conditions=array('PublishedCourse.academic_year'=>$selected_academic_year, 'PublishedCourse.department_id'=>$this->department_id, 'PublishedCourse.program_id'=>$selected_program,'PublishedCourse.program_type_id'=>$program_type_id,'PublishedCourse.year_level_id'=>$selected_year_level,'PublishedCourse.semester'=>$selected_semester,'PublishedCourse.drop'=>0);
				} else {
					$conditions=array('PublishedCourse.academic_year'=>$selected_academic_year, 'PublishedCourse.college_id'=>$this->college_id,'PublishedCourse.program_id'=>$selected_program, 'PublishedCourse.program_type_id'=>$program_type_id,'PublishedCourse.semester'=>$selected_semester,'PublishedCourse.drop'=>0,"OR"=>array("PublishedCourse.department_id is null","PublishedCourse.department_id"=>array(0,'')));
				}
				$publishedcourses = $this->CourseInstructorAssignment->PublishedCourse->find('all',array(
					'conditions'=>$conditions,'fields'=>array('PublishedCourse.section_id'),
					'contain'=>array('Section'=>array('fields'=>array('Section.id','Section.name')),'Course'=>array(
					'fields'=>array('Course.id','Course.course_title','Course.course_code','Course.credit',
					'Course.lecture_hours','Course.tutorial_hours','Course.laboratory_hours')),
					'SectionSplitForPublishedCourse'=>array('CourseSplitSection'),'CourseInstructorAssignment'=>
					array('fields'=>array('CourseInstructorAssignment.id','CourseInstructorAssignment.staff_id',
					'CourseInstructorAssignment.type','CourseInstructorAssignment.isprimary', 'CourseInstructorAssignment.course_split_section_id'),
					'Staff'=>array('fields'=>array('Staff.full_name'),'conditions'=>array('Staff.active'=>1),
					'Title'=>array('fields'=>array('title')),'Position'=>array('fields'=>array('position')))
					))
				));

				$sections_array = array();
				$course_type_array = array();
				foreach($publishedcourses as $key=>$publishedcourse) {
					if(!empty($publishedcourse['SectionSplitForPublishedCourse'])){
						foreach($publishedcourse['SectionSplitForPublishedCourse'][0]['CourseSplitSection'] as 
							$split_section_for_course){
						   $sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]
								['course_title'] = $publishedcourse['Course']['course_title'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]['course_id'] 
							= $publishedcourse['Course']['id'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]
								['course_code'] = $publishedcourse['Course']['course_code'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]
								['credit'] = $publishedcourse['Course']['credit'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']] 
								['credit_detail'] = $publishedcourse['Course']['lecture_hours'].' '.$publishedcourse['Course']
								['tutorial_hours'].' '.$publishedcourse['Course']['laboratory_hours'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]
								['course_split_section_id'] = $split_section_for_course['id'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]
								['section_id'] = $publishedcourse['PublishedCourse']['section_id'];
							$sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]
								['published_course_id'] = $publishedcourse['PublishedCourse']['id'];
							
							 $sections_array[$publishedcourse['Section']['name']][$split_section_for_course['section_name']]['grade_submitted'] = $this->CourseInstructorAssignment->PublishedCourse->CourseRegistration->ExamGrade->is_grade_submitted($publishedcourse['PublishedCourse']['id']);
							if(!empty($publishedcourse['CourseInstructorAssignment'])){
								foreach($publishedcourse['CourseInstructorAssignment'] as $askey => $assign_instructor){
								if($split_section_for_course['id'] == $assign_instructor['course_split_section_id'] ){
									$sections_array[$publishedcourse['Section']['name']][$split_section_for_course
										['section_name']]['assign_instructor'][$assign_instructor['isprimary']][$askey]
										['full_name'] = $assign_instructor['Staff']['Title']['title'] .' '. 
										$assign_instructor['Staff']['full_name'];
									$sections_array[$publishedcourse['Section']['name']][$split_section_for_course
										['section_name']]['assign_instructor'][$assign_instructor['isprimary']][$askey]
										['position'] = $assign_instructor['Staff']['Position']['position'];
									$sections_array[$publishedcourse['Section']['name']][$split_section_for_course
										['section_name']]['assign_instructor'][$assign_instructor['isprimary']][$askey]
										['course_type'] = $assign_instructor['type'];
									$sections_array[$publishedcourse['Section']['name']][$split_section_for_course
										['section_name']]['assign_instructor'][$assign_instructor['isprimary']][$askey]
										['CourseInstructorAssignment_id'] = $assign_instructor['id'];
									}
								}
							}
						
							//$course_type_array[$split_section_for_course['section_name']][-1] = "---Select---";
							if($publishedcourse['Course']['lecture_hours'] >0){
								$course_type_array[$split_section_for_course['section_name']]["Lecture"] = "Lecture";	
								if($publishedcourse['Course']['tutorial_hours'] >0 && $publishedcourse['Course']['laboratory_hours'] >0){
									$course_type_array[$split_section_for_course['section_name']]["Lecture+Tutorial+Lab"] = "Lect.+Tut.+Lab";
								}
							}
							if($publishedcourse['Course']['tutorial_hours'] >0){
								$course_type_array[$split_section_for_course['section_name']]["tutorial"] = "Tutorial";
								if($publishedcourse['Course']['lecture_hours'] >0){
									$course_type_array[$split_section_for_course['section_name']]["Lecture+Tutorial"] = "Lect.+Tut.";
								}
							} else if($publishedcourse['Course']['laboratory_hours'] >0){
								$course_type_array[$split_section_for_course['section_name']]["Lab"] = "Lab";
								if($publishedcourse['Course']['lecture_hours'] >0){
									$course_type_array[$split_section_for_course['section_name']]["Lecture+Lab"] = "Lec.+Lab";
								}
							}
						}
					} else {
						$sections_array[$publishedcourse['Section']['name']][$key]['course_title'] = $publishedcourse
							['Course']['course_title'];
						$sections_array[$publishedcourse['Section']['name']][$key]['course_id'] = $publishedcourse['Course']['id'];
						$sections_array[$publishedcourse['Section']['name']][$key]['course_code'] = $publishedcourse
							['Course']['course_code'];
						$sections_array[$publishedcourse['Section']['name']][$key]['credit'] = $publishedcourse
							['Course']['credit'];
						$sections_array[$publishedcourse['Section']['name']][$key]['credit_detail'] = $publishedcourse
							['Course']['lecture_hours'].' '.$publishedcourse['Course']['tutorial_hours'].' '.
							$publishedcourse['Course']['laboratory_hours'];
						$sections_array[$publishedcourse['Section']['name']][$key]['section_id'] = 
							$publishedcourse['PublishedCourse']['section_id'];
						$sections_array[$publishedcourse['Section']['name']][$key]['published_course_id'] = 
							$publishedcourse['PublishedCourse']['id'];
												
						$sections_array[$publishedcourse['Section']['name']][$key]['grade_submitted'] = $this->CourseInstructorAssignment->PublishedCourse->CourseRegistration->ExamGrade->is_grade_submitted($publishedcourse['PublishedCourse']['id']);
						if(!empty($publishedcourse['CourseInstructorAssignment'])){
							foreach($publishedcourse['CourseInstructorAssignment'] as $askey=>$assign_instructor){
							
								$sections_array[$publishedcourse['Section']['name']][$key]['assign_instructor']
									[$assign_instructor['isprimary']][$askey]['full_name'] = $assign_instructor['Staff']
									['Title']['title'] .' '. $assign_instructor['Staff']['full_name'];
								$sections_array[$publishedcourse['Section']['name']][$key]['assign_instructor']
									[$assign_instructor['isprimary']][$askey]['position'] = $assign_instructor['Staff']
									['Position']['position'];
								$sections_array[$publishedcourse['Section']['name']][$key]['assign_instructor']
									[$assign_instructor['isprimary']][$askey]['course_type'] = $assign_instructor['type'];
								$sections_array[$publishedcourse['Section']['name']][$key]['assign_instructor']
									[$assign_instructor['isprimary']][$askey]['CourseInstructorAssignment_id'] = 
									$assign_instructor['id'];
							}
							
						}
						//$course_type_array[$key][-1] = "---Select---";
						if($publishedcourse['Course']['lecture_hours'] >0){
							$course_type_array[$key]["Lecture"] = "Lecture";
							if($publishedcourse['Course']['tutorial_hours'] >0 && $publishedcourse['Course']['laboratory_hours'] >0){
								$course_type_array[$key]["Lecture+Tutorial+Lab"] = "Lect.+Tut.+Lab";
							}
						}
						if($publishedcourse['Course']['tutorial_hours'] >0){
							$course_type_array[$key]["tutorial"] = "Tutorial";
							if($publishedcourse['Course']['lecture_hours'] >0){
								$course_type_array[$key]["Lecture+Tutorial"] = "Lect.+Tut.";
							}
						} if($publishedcourse['Course']['laboratory_hours'] >0){
							$course_type_array[$key]["Lab"] = "Lab";
							if($publishedcourse['Course']['lecture_hours'] >0){
								$course_type_array[$key]["Lecture+Lab"] = "Lect.+Lab";
							}
						}
					}	
				}

				if (empty($sections_array)) {
			         $this->Session->setFlash('<span></span> '.__('There is no published courses to assign instructor
					  in the selected criteria.', true),'default',array('class'=>'info-box info-message'));     
			    } else {
			    	if(ROLE_COLLEGE == $this->role_id){
			    		$thiscollege = $this->college_id;
			    		
			    	} else {
			    		$thiscollege = $this->CourseInstructorAssignment->PublishedCourse->Department->field('Department.college_id',array('Department.id'=>$this->department_id));
			    		$thisdepartment = $this->department_id;
			    		$this->set(compact('thisdepartment'));
			    	}
					 $colleges = $this->CourseInstructorAssignment->PublishedCourse->College->find('list', array('fields'=>'College.shortname'));
					 $departments = $this->CourseInstructorAssignment->PublishedCourse->Department->find('list',array('fields'=>'Department.shortname','conditions'=>array('Department.college_id'=>$thiscollege)));
					//unset($this->request->data);
					$this->set(compact('sections_array','colleges','departments','course_type_array', 'thiscollege'));
				}
			}
		}
	}
	function get_department($college_id=null) {
	   
		$this->layout = 'ajax';
		$departments = null;
		$departments = $this->CourseInstructorAssignment->Section->Department->find('list',array(
			'fields'=>'Department.shortname','conditions'=>array('Department.college_id'=>$college_id)));

	    $this->set(compact('departments'));
	}

	function assign_instructor($data=null){
			$this->layout = 'ajax';
			$explode_data = explode("~",$data);
			$department_id = $explode_data[0];
			
			if($department_id =="pre") {
			    $departments = $this->CourseInstructorAssignment->Section->Department->find('list',array(
			'fields'=>'Department.shortname'));
			    foreach($departments as $dep_id=>$dep_name) {
                   $department_id=$dep_id;
                   break;     
                }
                
			} 
				
			$selected_course_type = $explode_data[1];
			if(strcmp($selected_course_type,"Lecture Tutorial")==0){
				$selected_course_type = "Lecture+Tutorial";
			}
			if(strcmp($selected_course_type,"Lecture Lab")==0){
				$selected_course_type = "Lecture+Lab";
			}
			$selected_published_course_id = $explode_data[2];
			$isprimary = $explode_data[3];
			$selected_course_split_section_id = $explode_data[4];
			if($selected_course_split_section_id == 0){
				$selected_course_split_section_id = null;
			}
			$this->CourseInstructorAssignment->PublishedCourse->recursive=-1;
			$published_course_detail = $this->CourseInstructorAssignment->PublishedCourse->find('first',array(
				'conditions'=>array('PublishedCourse.id'=>$selected_published_course_id, 'PublishedCourse.drop'=>0),
				'fields'=>array('PublishedCourse.academic_year', 'PublishedCourse.program_id', 'PublishedCourse.program_type_id', 'PublishedCourse.year_level_id','PublishedCourse.section_id', 'PublishedCourse.course_id', 'PublishedCourse.semester'
				)
			));

		$selected_academicyear = $published_course_detail['PublishedCourse']['academic_year'];
		$selected_program_id = $published_course_detail['PublishedCourse']['program_id'];
		$selected_program_type_id = $published_course_detail['PublishedCourse']['program_type_id'];
		$selected_year_level_id = $published_course_detail['PublishedCourse']['year_level_id'];
		$selected_semester = $published_course_detail['PublishedCourse']['semester'];
		$selected_department_id = $department_id;
		$selected_section_id = $published_course_detail['PublishedCourse']['section_id'];
		$course_id = $published_course_detail['PublishedCourse']['course_id'];
		
		$selected_course_title = $this->CourseInstructorAssignment->PublishedCourse->Course->field('Course.course_title'
		,array('Course.id'=>$course_id));
		

		$course_code_title=$this->CourseInstructorAssignment->PublishedCourse->Course->field('Course.course_code_title',
		array('Course.id'=>$course_id));
		if(!empty($department_id) && is_numeric($department_id))
        {
		$equivalent_courses=array_values(ClassRegistry::init('EquivalentCourse')->find('list',
			array('conditions'=>array('EquivalentCourse.course_for_substitued_id'=>$course_id)
			,'fields'=>array('course_be_substitued_id'))));
			$equivalent_courses[]=$course_id;
		
			$instructors_detail=$this->CourseInstructorAssignment->Staff->find('all',
			array('conditions'=>array('Staff.department_id'=>$selected_department_id,'Staff.active'=>1),
			'fields'=>array('Staff.id','Staff.full_name'),
			'contain'=>array('Title'=>array('fields'=>array('Title.title')),
			'User'=>array('fields'=>array('id','role_id','username','active'),
			'conditions'=>array('User.role_id'=>ROLE_INSTRUCTOR,
'User.active'=>1)),
			'CourseInstructorAssignment'=>array('fields'=>array('id','academic_year'),
			'PublishedCourse'=>array('fields'=>array('id','course_id'),
			'Course'=>array('fields'=>array('id','course_code_title')),
			'conditions'=>array('PublishedCourse.course_id'=>$equivalent_courses))))));
			
			foreach ($instructors_detail as $sd=>&$sv) {
				$experiance=0;
				foreach ($sv['CourseInstructorAssignment'] as $k=>$v) {
				   if (!empty($v['PublishedCourse'])) {
				    $experiance++;
				   } 
				}
				$sv['Experiance']=$experiance;
				$sv['course_code_title']=$course_code_title;
				unset($sv['CourseInstructorAssignment']);
			}
		
			$instructors_list = array();
			foreach($instructors_detail as $ik=>$iv){
				   if($iv['User']['active']==1){
					
					$instructors_list[$iv['Staff']['id']] = $iv['Title']['title'].' '.$iv['Staff']['full_name'].' Give '.$iv['Experiance'].' times';
				   }
			}
			$this->set(compact('instructors_list','selected_department_id','selected_course_type','selected_section_id',
				'selected_published_course_id','selected_course_split_section_id','selected_academicyear','selected_course_title',
				'selected_program_id',
				'selected_program_type_id','selected_year_level_id','selected_semester','isprimary',
				'instructors','instructors_detail','courses','course_code_title'));
	
		} else {
			$instructors_detail = null;
			$instructors_list = null;
				$this->set(compact('instructors_list','selected_department_id','selected_course_type','selected_section_id',
			'selected_published_course_id','selected_course_split_section_id','selected_academicyear','selected_course_title',
			'selected_program_id',
			'selected_program_type_id','selected_year_level_id','selected_semester','isprimary',
			'instructors','instructors_detail','courses','course_code_title'));
		}
	}

	function assign_instructor_update() {
		$selected_academicyear = $this->request->data['CourseInstructorAssignment']['academic_year'];
		$this->Session->write('selected_academicyear',$selected_academicyear);
		$selected_program_id = $this->request->data['CourseInstructorAssignment']['selected_program_id'];
		$this->Session->write('selected_program_id',$selected_program_id);
		$selected_program_type_id = $this->request->data['CourseInstructorAssignment']['selected_program_type_id'];
		$this->Session->write('selected_program_type_id',$selected_program_type_id);
		if(ROLE_COLLEGE != $this->role_id ){
			$selected_year_level_id = $this->request->data['CourseInstructorAssignment']['selected_year_level_id'];
			$this->Session->write('selected_year_level_id',$selected_year_level_id);
		}
		$selected_semester = $this->request->data['CourseInstructorAssignment']['semester'];
		$this->Session->write('selected_semester',$selected_semester);
		$count_assign_instructor_for_lecture = 0;
		if($this->request->data['CourseInstructorAssignment']['isprimary'] == 1){
			$explode_data = explode("+",$this->request->data['CourseInstructorAssignment']['type']);
			if(strcasecmp($explode_data[0],'Lecture') ==0){
			$count_assign_instructor_for_lecture = $this->CourseInstructorAssignment->find('count',array('conditions'=>array(
				'CourseInstructorAssignment.published_course_id'=>$this->request->data['CourseInstructorAssignment']['published_course_id'],
				'CourseInstructorAssignment.section_id'=>$this->request->data['CourseInstructorAssignment']['section_id'],
				'CourseInstructorAssignment.isprimary'=>1,
				'CourseInstructorAssignment.type LIKE'=>'Lecture%',
				'CourseInstructorAssignment.academic_year'=>$this->request->data['CourseInstructorAssignment']['academic_year'],
				'CourseInstructorAssignment.semester'=>$this->request->data['CourseInstructorAssignment']['semester'],
				"OR"=>array("CourseInstructorAssignment.course_split_section_id"=>$this->request->data['CourseInstructorAssignment']
				['course_split_section_id'],"CourseInstructorAssignment.course_split_section_id is null",
				"CourseInstructorAssignment.course_split_section_id" => array(0,'')))));
			}
		}
		$count_assign_instructor = 0;
		$count_assign_instructor = $this->CourseInstructorAssignment->find('count',array('conditions'=>array(
			'CourseInstructorAssignment.published_course_id'=>$this->request->data['CourseInstructorAssignment']['published_course_id'],
			'CourseInstructorAssignment.staff_id'=>$this->request->data['CourseInstructorAssignment']['staff_id'],
			'CourseInstructorAssignment.section_id'=>$this->request->data['CourseInstructorAssignment']['section_id'],
			'CourseInstructorAssignment.isprimary'=>$this->request->data['CourseInstructorAssignment']['isprimary'],
			'CourseInstructorAssignment.academic_year'=>$this->request->data['CourseInstructorAssignment']['academic_year'],
			'CourseInstructorAssignment.semester'=>$this->request->data['CourseInstructorAssignment']['semester'],
			"OR"=>array("CourseInstructorAssignment.course_split_section_id"=>$this->request->data['CourseInstructorAssignment']
				['course_split_section_id'],"CourseInstructorAssignment.course_split_section_id is null",
				"CourseInstructorAssignment.course_split_section_id" => array(0,'')))));
		$instructor_name = $this->CourseInstructorAssignment->Staff->field('Staff.full_name',array('Staff.id'=>
				$this->request->data['CourseInstructorAssignment']['staff_id'])); //only for display
		if(empty($this->request->data['CourseInstructorAssignment']['course_split_section_id'])){
			unset($this->request->data['CourseInstructorAssignment']['course_split_section_id']);
		}
		$for_assign_instructor = 1;
		if(($this->request->data['CourseInstructorAssignment']['isprimary'] == 1) &&($count_assign_instructor_for_lecture >0)){
			$this->Session->setFlash(__('<span></span> Instructor is already assign for "Lecture" for the course '.
				$this->request->data['CourseInstructorAssignment']['selected_course_title'] .', To reassign please discard the 
				previous assignment first or change course type of the assignment.',true),'default',array('class'=>
				'error-box error-message'));
			//$this->redirect(array('action' => 'assign',$for_assign_instructor));
			return $this->redirect(array('action' => 'assign_course_instructor',$for_assign_instructor));
		  
		} else {
			if($count_assign_instructor==0){
				//$this->CourseInstructorAssignment->create();
				if($this->CourseInstructorAssignment->save($this->request->data)){
				     //Notifications
				    ClassRegistry::init('AutoMessage')->sendNotificationOnInstructorAssignment(
				    $this->request->data['CourseInstructorAssignment']['published_course_id']);
				    
					$this->Session->setFlash(__('<span></span> Instructor '.$instructor_name.' is assign for the course '.
						$this->request->data['CourseInstructorAssignment']['selected_course_title'],true),'default',
						array('class'=>'success-box success-message'));
						
				
					//$this->redirect(array('action' => 'assign',$for_assign_instructor));
				     $this->redirect(array('action'=>'assign_course_instructor',$for_assign_instructor));
				} else {
					$this->Session->setFlash(__('<span></span> Instructor '.$instructor_name.' is unable to assign for 
						the course '.$this->request->data['CourseInstructorAssignment']['selected_course_title'].' please try 7
						again.',true),'default',array('class'=>'error-box error-message'));
					//$this->redirect(array('action' => 'assign',$for_assign_instructor));
				    $this->redirect(array('action'=>'assign_course_instructor',$for_assign_instructor));
				}
			} else {
				$this->Session->setFlash(__('<span></span> Instructor '.$instructor_name.' is already assign for the 
					course '.$this->request->data['CourseInstructorAssignment']['selected_course_title'] .', to reassign please 
					discard the previous assignment first or change course type of the assignment.',true),'default',
					array('class'=>'error-box error-message'));
				//$this->redirect(array('action' => 'assign',$for_assign_instructor));
				return $this->redirect(array('action'=>'assign_course_instructor',$for_assign_instructor));
			}
		} 
	}

	function get_assigned_courses_of_instructor_by_section_for_combo($acadamic_year1 = null, $acadamic_year2 = null, $semester = null, $instructor_id = null) {
		$this->layout = 'ajax';
		//debug($acadamic_year1.'/'.$acadamic_year2);
		//debug($semester);
		if(empty($instructor_id))
			$instructor_id = $this->Auth->user('id');
		$instructor_id = $this->CourseInstructorAssignment->Staff->field('id', array('user_id' => $this->Auth->user('id')));
		$publishedCourses = $this->CourseInstructorAssignment->listOfCoursesInstructorAssignedBySection($acadamic_year1.'/'.$acadamic_year2, $semester, $instructor_id);
		//debug($publishedCourses);
		$this->set(compact('publishedCourses'));
	}
	
	function get_assigned_fx_for_instructor($acadamic_year1 = null, $acadamic_year2 = null, $semester = null, $instructor_id = null) {
		$this->layout = 'ajax';
		
		if(empty($instructor_id))
			$instructor_id = $this->Auth->user('id');
		$instructor_id = $this->CourseInstructorAssignment->Staff->field('id', array('user_id' => $this->Auth->user('id')));
		$publishedCourses = $this->CourseInstructorAssignment->listOfFxCoursesInstructorAssignedBySection($acadamic_year1.'/'.$acadamic_year2, $semester, $instructor_id);
		
		$this->set(compact('publishedCourses'));
	}
	function get_assigned_grade_entry_for_instructor($acadamic_year1 = null, $acadamic_year2 = null, $semester = null, $instructor_id = null){
	  $this->layout = 'ajax';
		
		if(empty($instructor_id))
			$instructor_id = $this->Auth->user('id');
		$instructor_id = $this->CourseInstructorAssignment->Staff->field('id', array('user_id' => $this->Auth->user('id')));
		$publishedCourses = $this->CourseInstructorAssignment->listOfAssignedGradeEntryAssignedBySection($acadamic_year1.'/'.$acadamic_year2, $semester, $instructor_id);
		debug($publishedCourses);
		
		$this->set(compact('publishedCourses'));
		
	}
	
	function reset_department($college_id=null){
		$this->layout = 'ajax';
		$departments = null;
		$departments = $this->CourseInstructorAssignment->Section->Department->find('list',array(
			'fields'=>'Department.shortname','conditions'=>array('Department.college_id'=>$college_id)));

	    $this->set(compact('departments'));

	}
	
	function view_instructor_course_load () {
	      /*
            1. We need to have a tool that will display staffs current assignment of courses from 
            all department so that the hosting department 
            (if possible other departments also) can get instructor load. 
            Filtering criteria will be by Academic Year, Semester, 
            Department, and Instructor. 
            Out of this instructor will be mandatory and the other will be optional (--- All ---). (High)
         */
         
         $this->paginate = array('contain'=>array('Section'=>array
			('fields'=>array('Section.name')),'CourseSplitSection','Staff'=>array(
			'conditions'=>array('Staff.active'=>1),'Title'=>array('fields'=>array('Title.title')),'Position'=>
			array('fields'=>array('Position.position'))),'PublishedCourse'=>array('fields'=>array('PublishedCourse.id','PublishedCourse.academic_year','PublishedCourse.semester'),
			'Course'=>array('fields'=>array('Course.course_code_title','Course.credit','Course.course_code',
'Course.course_title','Course.lecture_hours','Course.tutorial_hours',
'Course.laboratory_hours','Course.course_detail_hours')),
'CourseRegistration')), 'order'=>array('CourseInstructorAssignment.created DESC'));
           // search 
	      if (!empty($this->request->data) && isset($this->request->data['viewInstructorLoad'])) { 
	            $options = array();
	         
	            if (!empty($this->request->data['Search']['department_id'])) {
	               $options[] =array(
	                  'Staff.department_id'=>$this->request->data['Search']['department_id']
	               );
	            }
	            if (!empty($this->request->data['Search']['staff_id'])) {
	               $options[] =array(
	                  'CourseInstructorAssignment.staff_id'=>$this->request->data['Search']['staff_id']
	               );
	            }
	            if (!empty($this->request->data['Search']['semester'])) {
	               $options[] =array(
	                  'CourseInstructorAssignment.semester'=>$this->request->data['Search']['semester']
	               );
	            }
	            
	            if (!empty($this->request->data['Search']['academic_year'])) {
	               $options[] =array(
	                  'CourseInstructorAssignment.academic_year'=>$this->request->data['Search']['academic_year']
	               );
	            }
	           $this->paginate['conditions']=$options;
	           $this->Paginator->settings=$this->paginate;
		  
	           $instructor_loads=$this->Paginator->paginate('CourseInstructorAssignment');
	          
	           
	           if(empty($instructor_loads)) {
                    $this->Session->setFlash('<span></span>'.__('There is no course load in the system with in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	           } else {
	             $instructor_loads=$this->CourseInstructorAssignment
	             ->instructorLoadOrganizedByAcademicYearAndSemester($instructor_loads);
	             $staff_details=$this->CourseInstructorAssignment->Staff->find('first',
	             array('conditions'=>array('Staff.id'=>$this->request->data['Search']['staff_id']),
	             'contain'=>array('Position','Title')));
	             $this->set(compact('instructor_loads','staff_details'));
	           }
	            
	            
	      }
	      if (!empty($this->request->data['Search']['department_id'])) {
	         
	      $staffs=$this->CourseInstructorAssignment->Staff->find(
	      'list',
	      array('conditions'=>array('Staff.department_id'=>$this->request->data['Search']['department_id'],'Staff.user_id  IN (SELECT id FROM users  
	      WHERE role_id='.ROLE_INSTRUCTOR.' OR (is_admin=1 and role_id ='.ROLE_DEPARTMENT.' ) )'),'fields'=>array('id','full_name')));
	      
	      } else {
	            
	      $staffs=$this->CourseInstructorAssignment->Staff->find(
	      'list',
	      array('conditions'=>array('Staff.department_id'=>$this->department_id,'Staff.user_id  IN (SELECT id FROM users  
	      WHERE role_id='.ROLE_INSTRUCTOR.' OR (is_admin=1 and role_id ='.ROLE_DEPARTMENT.'))'),'fields'=>array('id','full_name')));
	      
	      }
	      
	      
	      if (!empty($this->request->data['Search']['college_id'])) {
	         $departments=$this->CourseInstructorAssignment->Staff->Department->find('list',
	      array('fields'=>array('id','name'),'conditions'=>array('Department.college_id'=>$this->request->data['Search']['college_id'])));
	        
	      } else {
	        $departments=$this->CourseInstructorAssignment->Staff->Department->find('list',
	      array('fields'=>array('id','name')));
	      
	      }
	      
	       $colleges=$this->CourseInstructorAssignment->Staff->College->find('list',
	      array('fields'=>array('id','name')));
	      
	      $this->set(compact('departments','staffs','colleges'));
	
	} 
	
	public function assign_course_instructor ($for_assign_instructor=null) {
	    
	    if(!empty($for_assign_instructor))
        {
		     
		    if ($this->Session->read('search_data')) {

            	$search_session = $this->Session->read('search_data');
            	$this->request->data['Search'] = $search_session;
                // debug($this->request->data);
             }
             $this->request->data['getPublishedCourse'] = true;
		      $data=$this->CourseInstructorAssignment->PublishedCourse->find('first', array(
			
				'conditions' => array(
				'PublishedCourse.id'=>$for_assign_instructor,
				'PublishedCourse.given_by_department_id'=>$this->department_id,
				),
				'contain'=>array('YearLevel')
				));
			  // debug($data);
			   if (!empty($data)) {
			    $this->request->data['Search']['academicyear']=$data['PublishedCourse']['academic_year'];
			    if ($data['PublishedCourse']['given_by_department_id']!=
			    $data['PublishedCourse']['department_id']) {
			        //find the equivalent year level of the published department 
			        $publishing_department_year_level=$this->CourseInstructorAssignment->PublishedCourse->YearLevel
			        ->find('first',
			        array('conditions'=>array('YearLevel.name'=>$data['YearLevel']['name'],
			        'YearLevel.department_id'=>$this->department_id),
			        'recursive'=>-1
			        )
			        );
			        // debug($publishing_department_year_level['YearLevel']['id']);
                    if(!empty($publishing_department_year_level['YearLevel']['id'])) {
			        $yearLevelArrays[]=$publishing_department_year_level['YearLevel']['id'];
                     } else {
                        $yearLevelArrays[]=0;
					 }
			        $this->request->data['Search']['year_level_id']=$yearLevelArrays;
			   } else {
			    
			        if (isset($data['YearLevel']['id'])) {
			            $yearLevelArrays[]=$data['YearLevel']['id'];
			            $this->request->data['Search']['year_level_id']=$yearLevelArrays;  
			        }
			     //   debug($yearLevelArrays);
			      
			   }
			   // debug($data['PublishedCourse']['program_id']);
			   
			   $this->request->data['Search']['semester']=$data['PublishedCourse']['semester'];
			   $this->request->data['Search']['program_id']=$data['PublishedCourse']['program_id'];
			   $this->request->data['Search']['program_type_id']=$data['PublishedCourse']['program_type_id'];
				$this->request->data['Search']['section_id']=$data['PublishedCourse']['section_id'];
			   
			  // debug($this->request->data);
			    
			} else {
			
			}
		
			
			
		}
		
	   
	    
	    if (!empty($this->request->data) && isset($this->request->data['getPublishedCourse'])) {
	       
			$everythingfine=false;
			switch($this->request->data) {
			         case empty($this->request->data['Search']['academicyear']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the academic year you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Search']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         
			         case empty($this->request->data['Search']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Search']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			
			
			if ($everythingfine) {
			        $this->__init_search();	        
		            $semester=$this->request->data['Search']['semester'];
		            $academic_year=$this->request->data['Search']['academicyear'];
		            if (!empty($this->request->data['Search']['year_level_id'])) {

                      $yearLevelIds=$this->CourseInstructorAssignment->getAllDepartmentYearLevelMatchingYear($this->request->data['Search']['year_level_id']);
                     
		            } 
		         
		          if ($this->role_id == ROLE_COLLEGE) {
	                  $publishedCourses=$this->CourseInstructorAssignment->PublishedCourse->find('all',
			        array('conditions'=>array(
			        'PublishedCourse.drop'=>0,
			       
			         'PublishedCourse.college_id'=>$this->college_id,
			        'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			        'PublishedCourse.year_level_id'=>$this->request->data['Search']['year_level_id'],
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']),
			        'order'=>array('PublishedCourse.created DESC'),
			        'contain'=>array('YearLevel'=>array('order'=>array('YearLevel.name')),'College',
			        'Department'=>array('College'),
			        'GivenByDepartment'=>array('College'),
			        'Program',
			        'CourseInstructorAssignment'=>array('fields'=>array('CourseInstructorAssignment.id',
			                'CourseInstructorAssignment.staff_id',
					        'CourseInstructorAssignment.type',
					        'CourseInstructorAssignment.isprimary',
					        'CourseInstructorAssignment.course_split_section_id'
					        ),
					        'Staff'=>array('fields'=>array('Staff.full_name'),
					        'conditions'=>array('Staff.active'=>1),
					        'Title'=>array('fields'=>array('title')),
					        'Position'=>array('fields'=>array('position')))
					   ),
			        'SectionSplitForPublishedCourse'=>array('CourseSplitSection'),
			        
			        'ProgramType',
			        'Section','Course'=>array('Prerequisite'=>array('Course','PrerequisiteCourse'))))); 
	              } else if ($this->role_id == ROLE_DEPARTMENT) {
                       /*
	                   $yearLevelOfOtherDepartment = $this->CourseInstructorAssignment->PublishedCourse->find('list',
	                   array('conditions'=>array(
	                   'PublishedCourse.given_by_department_id'=>$this->department_id,
	                   'PublishedCourse.department_id !='=>$this->department_id,
	                    'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			       
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']
	                   ),
	                   'fields'=>array('PublishedCourse.id','PublishedCourse.year_level_id'),
	                   'limit'=>5000000000
	                   
	                   )
	                   );
	                   if (!empty($yearLevelOfOtherDepartment)) {
	                       $yearLevelOtherDepartmentName = $this->CourseInstructorAssignment->PublishedCourse->YearLevel->
	                       find('list',
	                      array('conditions'=>array(
	                        'YearLevel.id'=>$yearLevelOfOtherDepartment,
	                      
	                      ))
	                      
	                      );
	                  }
	                
	                   $yearLevelSelectedOfHostingDepartment = $this->CourseInstructorAssignment->PublishedCourse->YearLevel->find(
	                   'list',
	                  array('conditions'=>array(
	                  'YearLevel.id'=>$this->request->data['Search']['year_level_id'],
	                 
	                  ))
	                  );
	             
	                  //find the year level other department 
	                  $yearLevelIds=array();
                      $yearLevelIds[]= 0; 
	                  foreach ($yearLevelSelectedOfHostingDepartment as $key=>$valueHostingDepartment) {
	                        if (isset($yearLevelOtherDepartmentName)) {
	                         
	                            $yearLevelKey=array_keys($yearLevelOtherDepartmentName, $valueHostingDepartment);
	                            
	                        }
	                        if (!empty($yearLevelKey)) {
	                       
	                          $yearLevelIds += $yearLevelKey; 
	                         
	                        
	                        }
	                      
	                       $yearLevelIds[]= $key;     
	                  }
                      */
	              
                  if(!empty($this->request->data['Search']['section_id']) && 
!empty($yearLevelIds)) {
	                $publishedCourses=$this->CourseInstructorAssignment->PublishedCourse->find('all',
			        array('conditions'=>array(
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.given_by_department_id'=>$this->department_id,
			        'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			        'PublishedCourse.section_id'=>$this->request->data['Search']['section_id'],
			        'PublishedCourse.year_level_id'=>$yearLevelIds,
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']),
			        'order'=>array('PublishedCourse.created DESC'),
			        'contain'=>array('YearLevel'=>array('order'=>array('YearLevel.name')),'College',
			        'Department'=>array('College'),
			        'GivenByDepartment'=>array('College'),
			        'Program',
			        'CourseInstructorAssignment'=>array('fields'=>array('CourseInstructorAssignment.id',
			                'CourseInstructorAssignment.staff_id',
					        'CourseInstructorAssignment.type',
					        'CourseInstructorAssignment.isprimary',
					        'CourseInstructorAssignment.course_split_section_id'
					        ),
					        'Staff'=>array('fields'=>array('Staff.full_name'),
					        'conditions'=>array('Staff.active'=>1),
					        'Title'=>array('fields'=>array('title')),
					        'Position'=>array('fields'=>array('position')))
					   ),
			        'SectionSplitForPublishedCourse'=>array('CourseSplitSection'),
			        
			        'ProgramType',
			        'Section','Course'=>array('Prerequisite'=>array('Course','PrerequisiteCourse')),
			        
			        
			        ),
			        'limit'=>5000000000
			        
			        ));
			     } else if(!empty($yearLevelIds)) {
                     $publishedCourses=$this->CourseInstructorAssignment->PublishedCourse->find('all',
			        array('conditions'=>array(
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.given_by_department_id'=>$this->department_id,
			        'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			       // 'PublishedCourse.year_level_id'=>$this->request->data['Search']['year_level_id'],
			        'PublishedCourse.year_level_id'=>$yearLevelIds,
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']),
			        'order'=>array('PublishedCourse.created DESC'),
			        'contain'=>array('YearLevel'=>array('order'=>array('YearLevel.name')),'College',
			        'Department'=>array('College'),
			        'GivenByDepartment'=>array('College'),
			        'Program',
			        'CourseInstructorAssignment'=>array('fields'=>array('CourseInstructorAssignment.id',
			                'CourseInstructorAssignment.staff_id',
					        'CourseInstructorAssignment.type',
					        'CourseInstructorAssignment.isprimary',
					        'CourseInstructorAssignment.course_split_section_id'
					        ),
					        'Staff'=>array('fields'=>array('Staff.full_name'),
					        'conditions'=>array('Staff.active'=>1),
					        'Title'=>array('fields'=>array('title')),
					        'Position'=>array('fields'=>array('position')))
					   ),
			        'SectionSplitForPublishedCourse'=>array('CourseSplitSection'),
			        
			        'ProgramType',
			        'Section','Course'=>array('Prerequisite'=>array('Course','PrerequisiteCourse')),
			        
			        
			        ),
			        'limit'=>5000000000
			        
			        ));

				} else {
                       
                          $publishedCourses=$this->CourseInstructorAssignment->PublishedCourse->find('all',
			        array('conditions'=>array(
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.given_by_department_id'=>$this->department_id,
			        'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			      
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']),
			        'order'=>array('PublishedCourse.created DESC'),
			        'contain'=>array('YearLevel'=>array('order'=>array('YearLevel.name')),'College',
			        'Department'=>array('College'),
			        'GivenByDepartment'=>array('College'),
			        'Program',
			        'CourseInstructorAssignment'=>array('fields'=>array('CourseInstructorAssignment.id',
			                'CourseInstructorAssignment.staff_id',
					        'CourseInstructorAssignment.type',
					        'CourseInstructorAssignment.isprimary',
					        'CourseInstructorAssignment.course_split_section_id'
					        ),
					        'Staff'=>array('fields'=>array('Staff.full_name'),
					        'conditions'=>array('Staff.active'=>1),
					        'Title'=>array('fields'=>array('title')),
					        'Position'=>array('fields'=>array('position')))
					   ),
			        'SectionSplitForPublishedCourse'=>array('CourseSplitSection'),
			        
			        'ProgramType',
			        'Section','Course'=>array('Prerequisite'=>array('Course','PrerequisiteCourse')),
			        
			        
			        ),
			        'limit'=>5000000000
			        
			        ));

				}   
	              
	          }           
		             
			       
			        
			     
			         if (empty($publishedCourses)) {
			              $this->Session->setFlash('<span></span> '.__('There is no published courses in the given criteria that needs instructor assignment.'),'default',array('class'=>'error-box error-message'));  
			         } else {
			          
			           $organizedPublishedCourse=$this->
			           CourseInstructorAssignment->organized_Published_courses_by_for_assignment($publishedCourses);
			         
			           $sections_array=$organizedPublishedCourse['sections_array'];
			           $course_type_array=$organizedPublishedCourse['course_type_array'];
			           
			         
			           $this->set(compact('organizedPublishedCourse','sections_array','course_type_array','semester','academic_year'));
			           $this->set('turn_off_search',true); 
			         }
			       
			        
			        
			       
			  
			} else {
			  
			   //$this->redirect(array('action'=>'add'));
			}
		}
		
	  if ($this->role_id == ROLE_COLLEGE) {
	    $yearLevels['0'] = 'Pre/Freshman'; 
	  } else if ($this->role_id == ROLE_DEPARTMENT) {
	    //$yearLevels = $this->CourseInstructorAssignment->PublishedCourse->YearLevel->find('list',array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
	     $yearLevels = $this->CourseInstructorAssignment->PublishedCourse->YearLevel->find('list',
	  array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
	   
	  
	  }
	  
	 
	  $programs=$this->CourseInstructorAssignment->PublishedCourse->Program->find('list');
	  $programTypes=$this->CourseInstructorAssignment->PublishedCourse->ProgramType->find('list');
	  $departments=$this->CourseInstructorAssignment->PublishedCourse->Department->find('list');
	  $colleges=$this->CourseInstructorAssignment->PublishedCourse->College->find('list');
	  $defaultCollege=$this->college_id;
	  $defaultDepartment=$this->department_id;
	  
	  $this->set(compact('yearLevels','departments','colleges','defaultCollege','defaultDepartment','programs','programTypes'));
	  
	}
	
	function change_course_department () {
	
	  if (!empty($this->request->data) && isset($this->request->data['changeDispatch'])) {
	         
	          if ($this->CourseInstructorAssignment->PublishedCourse->saveAll($this->request->data['PublishedCourse'],
			        array('validate'=>'first'))) {
			        $this->Session->setFlash('<span></span>'.__('The course instructor assignment has been dispatch or changed, and it will be visible for the department for instructor assignment.'),
				    'default',array('class'=>'success-box success-message'));
				    $this->request->data['getPublishedCourse']=true;
				    
			    } else {
			    
				    $this->Session->setFlash('<span></span>'.__('The course departments could not be updated or dispatched. Please, try again.'),
				    'default',array('class'=>'error-box error-message'));
			        
			    }
	  }
	  $this->__init_search();		
	  if (!empty($this->request->data) && isset($this->request->data['getPublishedCourse'])) {
	       
			$everythingfine=false;
			switch($this->request->data) {
			         case empty($this->request->data['Search']['academicyear']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the academic year you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Search']['semester']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the semester of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Search']['year_level_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the year level  of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Search']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			         case empty($this->request->data['Search']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type of the course you want to dispatch or change course department.'),'default',array('class'=>'error-box error-message'));  
			         break;  
			         default:
			         $everythingfine=true;
			                
			}
			
			if ($everythingfine) {
			              
		            $semester=$this->request->data['Search']['semester'];
		            $academic_year=$this->request->data['Search']['academicyear'];
		            if ($this->role_id == ROLE_DEPARTMENT) {
		               $publishedCourses=$this->CourseInstructorAssignment->PublishedCourse->find('all',
			        array('conditions'=>array(
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.department_id'=>$this->department_id,
			        'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			        'PublishedCourse.year_level_id'=>$this->request->data['Search']['year_level_id'],
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']),
			        'contain'=>array('YearLevel','College','Department'=>array('College'),'GivenByDepartment'=>array('College'),'Program','CourseInstructorAssignment','ProgramType','Section','Course'=>array('Prerequisite'=>array('Course','PrerequisiteCourse')))));  
		            } else if ($this->role_id == ROLE_COLLEGE) {
		               $publishedCourses=$this->CourseInstructorAssignment->PublishedCourse->find('all',
			        array('conditions'=>array(
			        'PublishedCourse.drop'=>0,
			        'PublishedCourse.department_id is null',
			        'PublishedCourse.semester'=>$this->request->data['Search']['semester'],
			        'PublishedCourse.academic_year'=>$this->request->data['Search']['academicyear'],
			        'PublishedCourse.year_level_id'=>$this->request->data['Search']['year_level_id'],
			        'PublishedCourse.program_id'=>$this->request->data['Search']['program_id'],
			        'PublishedCourse.program_type_id'=>$this->request->data['Search']['program_type_id']),
			        'contain'=>array('YearLevel','College','Department'=>array('College'),'GivenByDepartment'=>array('College'),'Program','CourseInstructorAssignment','ProgramType','Section','Course'=>array('Prerequisite'=>array('Course','PrerequisiteCourse')))));  
		            
		            }
			      
			        
			         
			         if (empty($publishedCourses)) {
			              $this->Session->setFlash('<span></span> '.__('There is no published courses in the given criteria.'),'default',array('class'=>'error-box error-message'));  
			         } else {
			           
			           $organizedPublishedCourse=$this->
			           CourseInstructorAssignment->
			           organized_published_courses_by_program_sections($publishedCourses);
			           $year_level_id=$this->request->data['Search']['year_level_id'];
			           $program_id=$this->request->data['Search']['program_id'];
			           $program_type_id=$this->request->data['Search']['program_type_id'];
			           
			           $this->set(compact('organizedPublishedCourse','year_level_id','program_id','program_type_id','semester','academic_year'));
			           $this->set('turn_off_search',true); 
			         }
			       
			        
			        
			       
			  
			} else {
			  
			   //$this->redirect(array('action'=>'add'));
			}
			
			
		}
	  if ($this->role_id == ROLE_COLLEGE) {
	    $yearLevels['0'] = 'Pre/Freshman'; 
	  } else if ($this->role_id == ROLE_DEPARTMENT) {
	    $yearLevels = $this->CourseInstructorAssignment->PublishedCourse->YearLevel->find('list',array('conditions'=>array('YearLevel.department_id'=>$this->department_id)));
	  }
	 
	  $programs=$this->CourseInstructorAssignment->PublishedCourse->Program->find('list');
	  $programTypes=$this->CourseInstructorAssignment->PublishedCourse->ProgramType->find('list');
	  $departments=$this->CourseInstructorAssignment->PublishedCourse->Department->find('list');
	  $colleges=$this->CourseInstructorAssignment->PublishedCourse->College->find('list');
	  $defaultCollege=$this->college_id;
	  $defaultDepartment=$this->department_id;
	  
	  $this->set(compact('yearLevels','departments','colleges','defaultCollege',
	  'defaultDepartment','programs','programTypes'));
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
            	$this->request->data['Search'] = $search_session;

            }
    }
    
}
