<?php
class ExamTypesController extends AppController {

	public $name = 'ExamTypes';
    public $components =array('AcademicYear');
	public $menuOptions = array(
			'parent' => 'grades',
			'exclude' => array('get_exam_type_view_page', 'get_exam_type_entry_form', 'index'),
			'alias' => array(
                    'college_exam_type_mgt_for_instructor' => 'Freshman Course Exam Setup',
                    'exam_type_mgt_for_instructor' => 'Department Course Exam Setup',
                    'add' => 'Your Course Exam Setup'
                    //'index'=>'View Exam Setup',
                    //'add'=>'Manage Exam Setup',
                    //'exam_type_mgt_for_instructor' => 'Manage Exam Setup'
            )
    );
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->Allow('get_exam_type_entry_form', 'get_exam_type_view_page');
        if($this->Session->check('Message.auth')){
               $this->Session->delete('Message.auth');
        }
		if ($this->Auth->user() && in_array($this->request->params['action'], array('login'))) {
			return $this->redirect($this->Auth->logout());
		}
	}
	
    public function beforeRender() {

    	if($this->role_id==ROLE_INSTRUCTOR){
			$acyear_array_data = $this->ExamType->PublishedCourse->CourseInstructorAssignment->find('list',array('conditions'=>array(
				'CourseInstructorAssignment.staff_id in (select id from staffs where user_id="'.$this->Auth->user('id').'")'),
                 'fields'=>array(
                 	'CourseInstructorAssignment.academic_year',
                 	'CourseInstructorAssignment.academic_year'

                 	),
                 'order'=>array('CourseInstructorAssignment.academic_year DESC')
			));
			if(empty($acyear_array_data))
				$acyear_array_data = $this->AcademicYear->acyear_array();
		} else {
		   $acyear_array_data = $this->AcademicYear->acyear_array();
           $defaultacademicyear=$this->AcademicYear->current_academicyear();	
		}

        $this->set(compact('acyear_array_data','defaultacademicyear'));
	}
	
	public function index() {
		/*if($this->role_id == 6)
			return $this->redirect(array('action' => 'exam_type_mgt_for_instructor'));
		else*/
			return $this->redirect(array('action' => 'add'));
	}
	
	public function add($published_course_id = null) {
			$this->__exam_type_mgt($published_course_id, 'instructor');
	}
	
	public function college_exam_type_mgt_for_instructor($published_course_id = null) {
		if(isset($this->college_id) && !empty($this->college_id)) {
		//First I was thinking to limit this task for those who has only college or department role. 
		//But now it is accessible to anyone as long as he/she has college id
		//if($this->role_id == 6 || $this->role_id == 5) {
			$edit = 0;
			$programs = $this->ExamType->PublishedCourse->Section->Program->find('list');
			$program_types = $this->ExamType->PublishedCourse->Section->ProgramType->find('list');
			
			if(!empty($this->request->data)) {
				$publishedCourses = $this->ExamType->PublishedCourse->CourseInstructorAssignment-> listOfCoursesCollegeFreshTakingOrgBySection($this->college_id, $this->request->data['ExamType']['acadamic_year'], $this->request->data['ExamType']['semester'], $this->request->data['ExamType']['program_id'], $this->request->data['ExamType']['program_type_id']);
				if(empty($publishedCourses)) {
					$this->Session->setFlash('<span></span>'.__('There is no published courses for the selected filter criteria.'), 'default',array('class'=>'info-box info-message'));
				}
				else
					$publishedCourses = array('0' => '--- Select Published Course ---') + $publishedCourses;
			}
			else {
				$publishedCourses = array();
				$published_course_combo_id = $published_course_id;
			}
			$this->set(compact('publishedCourses', 'programs', 'program_types'));
			if($published_course_id == null && isset($this->request->data['ExamType']['published_course_id']))
				$published_course_id = $this->request->data['ExamType']['published_course_id'];
/**************************  Begin "List Published Courses" button  **************************/
			if(isset($this->request->data['listPublishedCourses'])) {
				unset($this->request->data['ExamType']['published_course_id']);
				$published_course_combo_id = "";
			}
/*******************************  Save Exam Type button clicked  ***************************/
			else {
				$this->__exam_type_mgt($published_course_id, 'college');
			}
			
			$this->set(compact('published_course_id', 'published_course_combo_id', 'edit'));
		}
		else {
			$this->Session->setFlash('<span></span>'.__('You need to have assigned college through college or department or instructor role to access this area. Please contact your system administrator to get college or department or instructor role.'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}
	
	function exam_type_mgt_for_instructor($published_course_id = null) {
		if(isset($this->department_id) && !empty($this->department_id)) {
		//First I was thinking to limit this task for those who has only department role. 
		//But now it is accessible to anyone as long as he/she has department id
		//if($this->role_id == 6) {
			$edit = 0;
			$programs = $this->ExamType->PublishedCourse->Section->Program->find('list');
			$program_types = $this->ExamType->PublishedCourse->Section->ProgramType->find('list');
			
			if(!empty($this->request->data)) {
				$department_id = $this->department_id;
				$publishedCourses = $this->ExamType->PublishedCourse->CourseInstructorAssignment-> listOfCoursesSectionsTakingOrgBySection($department_id, $this->request->data['ExamType']['acadamic_year'], $this->request->data['ExamType']['semester'], $this->request->data['ExamType']['program_id'], $this->request->data['ExamType']['program_type_id']);
				if(empty($publishedCourses)) {
					$this->Session->setFlash('<span></span>'.__('There is no published courses for the selected filter criteria.'), 'default',array('class'=>'info-box info-message'));
				}
				else
					$publishedCourses = array('0' => '--- Select Published Course ---') + $publishedCourses;
				$this->set(compact('publishedCourses'));
			}
			else
				{
				$publishedCourses = array();
				$published_course_combo_id = $published_course_id;
				$this->set(compact('publishedCourses'));
			}
			if($published_course_id == null && isset($this->request->data['ExamType']['published_course_id']))
				$published_course_id = $this->request->data['ExamType']['published_course_id'];
/**************************  Begin "List Published Courses" button  **************************/
			if(isset($this->request->data['listPublishedCourses'])) {
				unset($this->request->data['ExamType']['published_course_id']);
				$published_course_combo_id = "";
			}
/*******************************  Save Exam Type button clicked  ***************************/
			else {
				$this->__exam_type_mgt($published_course_id, 'department');
			}
			
			$this->set(compact('programs', 'program_types', 'published_course_id', 'published_course_combo_id', 'edit'));
		}
		else {
			$this->Session->setFlash('<span></span>'.__('You need to have department or instructor role to access this area. Please contact your system administrator to get either department or instructor role.'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}
	
	private function __exam_type_mgt($published_course_id = null, $sourse = 'instructor') {
		$selected_acadamic_year = $this->AcademicYear->current_academicyear();
		$selected_semester = 'I';
		$edit = 0;
		$published_course_combo_id = "";
		$percent_sum_validation = true;
		$grade_submitted = false;
		$deleted_exam_types = array();
		$view_only = false;
		$fraud = false;
		$exam_types = array();
		
		$instructor_id = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->field('id', 
		array('Staff.user_id' => $this->Auth->user('id')));
		
		//List of exam setup retrival for redirection with published course ID
		if(!empty($published_course_id)) {
			$exam_types = $this->ExamType->find('all', 
				array(
					'conditions' => 
					array(
						'ExamType.published_course_id' => $published_course_id,
					),
					'recursive' => -1
				)
			);
		$published_course_combo_id = $published_course_id;
		
		}//End of list of exam setup retrival for redirection with published course ID

		
		
		//Checking if the user is ligible to manage published course exam type
		if(!empty($this->request->data['ExamType']['published_course_id'])) {
$published_course_id = $this->request->data['ExamType']['published_course_id'];
		}
		if(!empty($published_course_id)) {
			$instructor_id_for_checking = $this->ExamType->PublishedCourse->CourseInstructorAssignment->field('staff_id', array('CourseInstructorAssignment.published_course_id' => $published_course_id, 
				//'CourseInstructorAssignment.type LIKE \'%Lecture%\'', 

				'isprimary' => 1));
			
			$published_course_department = $this->ExamType->PublishedCourse->find('first',
				array(
					'conditions' => array('PublishedCourse.id' => $published_course_id),
					'contain' => array('Section' => array('Department'))
				)
			);
			
			
			//Do you have the right to manage exam type
			$assigned_instructor_user_id = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->field('Staff.user_id', array('Staff.id' => $instructor_id_for_checking));
			$active_account = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->User->field('active', array('User.id' => $assigned_instructor_user_id));
			//debug($instructor_id_for_checking == $instructor_id);
			//debug($instructor_id_for_checking);
			//debug($instructor_id);
			//Role based checking is now removed
			//if(!(($this->role_id == 6 && $this->department_id == $published_course_department['Section']['Department']['id'] && $active_account == 0) || ($this->role_id == 5 && $this->college_id == $published_course_department['PublishedCourse']['college_id'] && $active_account == 0) || ($instructor_id_for_checking == $instructor_id))) {
			
			if(!(($this->department_id == (isset($published_course_department['Section']['Department']['id']) ? 
			$published_course_department['Section']['Department']['id']:"")
			&& $active_account == 0) || 
			($this->college_id == (isset($published_course_department['PublishedCourse']['college_id']) ? 
			$published_course_department['PublishedCourse']['college_id']:"")
			&& $active_account == 0) || ($instructor_id_for_checking == $instructor_id))) {
				$this->Session->setFlash('<span></span>'.__('Sorry the selected published course is not assigned to you to manage its exam type. Please select a valid published course again.'), 'default', array('class' => 'error-message error-box'));
				return $this->redirect(array('controller' => 'dashboard', 'action'=>'index'));
			}
			//End of do you have the right to manage exam result and grade
			
			//Do you have view only access? (It is not neccessary as the user is trapped on the above checking)
			$login_instructor_id = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->field('id', array('Staff.user_id' => $this->Auth->user('id')));
			
			if($active_account == 1 && $instructor_id_for_checking != $login_instructor_id)
				$view_only = true;
		}//End for do they have view only access?
		
		if(!empty($this->request->data)) {
			$exam_types = $this->ExamType->find('all', 
				array(
					'conditions' => array(
						'ExamType.published_course_id' => $published_course_id,
					),
					'recursive' => -1
				)
			);
			if(count($exam_types) > 0)
				$edit = 1;
			$percent_sum = 0;
			$mandatory_exam = 0;
			$course_exam_grade = $this->ExamType->PublishedCourse->find('all', 
				array(
					'conditions' => 
					array(
						'PublishedCourse.id' => $published_course_id,
					),
					'contain' => 
					array(
						'CourseRegistration' => 
						array(
							'ExamGrade' => 
							array(
								'fields' => 'ExamGrade.id'
							)
						),
						'CourseAdd' => 
						array(
							'ExamGrade' => 
							array(
								'fields' => 'ExamGrade.id'
							)
						)
					)
				)
			);
			if((isset($course_exam_grade[0]['CourseRegistration'][0]['ExamGrade']) && count($course_exam_grade[0]['CourseRegistration'][0]['ExamGrade']) > 0) || (isset($course_exam_grade[0]['CourseAdd'][0]['ExamGrade']) && count($course_exam_grade[0]['CourseAdd'][0]['ExamGrade']) > 0)) {
				$this->Session->setFlash('<span></span>'.__('You can not apply changes on the exam setup for the already grade submitted course.'), 'default', array('class' => 'error-message error-box'));
				return $this->redirect(array('action' => (strcasecmp($sourse, 'instructor') == 0 ? 'add' : 'exam_type_mgt_for_instructor'), $published_course_id));
			}
			$exam_type_user_edit_id = array();
			//debug($this->request->data['ExamType']);
			foreach($this->request->data['ExamType'] as $key => &$exam_type) {
				if(is_array($exam_type)) {
					if(!isset($exam_type['mandatory'])) {
						$exam_type['mandatory'] = 0;
					}
					else if($exam_type['mandatory'] == 1) {
						$mandatory_exam++;
					}
					if($edit == 1 && isset($exam_type['id'])) {
						$exam_type_detail = $this->ExamType->find('first', 
							array(
								'conditions' => array('id' => $exam_type['id']),
								'recursive' => -1
							)
						);
						$exam_type_user_edit_id[] = $exam_type['id'];
						if($exam_type_detail['ExamType']['published_course_id'] != $published_course_id) {
							$fraud = true;
							break;
						}
						else if($exam_type['percent'] != ""){
							$exam_type_exam_result = $this->ExamType->ExamResult->find('first', array('conditions'=> array('ExamResult.exam_type_id' => $exam_type['id']),
	'order' => array('ExamResult.result DESC')));
	if($exam_type_exam_result['ExamResult']['result'] > $exam_type['percent']) {
								$this->Session->setFlash('<span></span>'.__('There are already recorded exam result for "'.$exam_type['exam_name'].'" and the maximum percentage can only be '.$exam_type_exam_result['ExamResult']['result'].'. Please delete the already recorded exam result/s to enter a larger percentage.'), 'default', array('class' => 'error-message error-box'));
								return $this->redirect(array('action' => (strcasecmp($sourse, 'instructor') == 0 ? 'add' : 'exam_type_mgt_for_instructor'), $published_course_id));
							}
						}
					}
					$exam_type['published_course_id'] = $published_course_id;
					//$exam_type['section_id'] = $section_course[0];
					if(trim($exam_type['percent']) != "" && is_numeric($exam_type['percent']) && $exam_type['percent'] > 0 && $exam_type['percent'] <= 100)
						$percent_sum += $exam_type['percent'];
					else
						$percent_sum_validation = false;
				}
			}

			if($fraud) {
				$this->Session->setFlash('<span></span>'.__('The system encounter a problem while processing your exam setup submission. Please try your submission again.'), 'default', array('class' => 'error-message error-box'));
				return $this->redirect(array('action' => (strcasecmp($sourse, 'instructor') == 0 ? 'add' : 'exam_type_mgt_for_instructor'), $published_course_id));
			}

			$selected_acadamic_year = $this->request->data['ExamType']['acadamic_year'];
			$selected_semester = $this->request->data['ExamType']['semester'];
			if(!empty($this->request->data['ExamType']['published_course_id'])) {
			$published_course_combo_id = $this->request->data['ExamType']['published_course_id'];
			}			
			//$section_id = $section_course[0];
			if(strcasecmp($sourse, 'instructor') !=0 ) {
				$program_type_id = $this->request->data['ExamType']['program_type_id'];
				$program_id = $this->request->data['ExamType']['program_id'];
				unset($this->request->data['ExamType']['program_type_id']);
				unset($this->request->data['ExamType']['program_id']);
			}
			unset($this->request->data['ExamType']['published_course_id']);
			unset($this->request->data['ExamType']['acadamic_year']);
			unset($this->request->data['ExamType']['semester']);
			unset($this->request->data['ExamType']['edit']);
			
			//debug($this->request->data);
			//debug($edit);
			if($edit == 1 && !empty($published_course_id)) {
				$exam_types_db = $this->ExamType->find('all',
					array(
						'conditions' => array(
							'ExamType.published_course_id' => $published_course_id,
							//'ExamType.section_id' => $section_course[0]
						),
						'recursive' => -1
					)
				);
				
				foreach($exam_types_db as $key => $exam_type_db) {
					if(!in_array($exam_type_db['ExamType']['id'], $exam_type_user_edit_id))
						$deleted_exam_types[] = $exam_type_db['ExamType']['id'];
				}
				foreach($deleted_exam_types as $key => $user_deleted_exam_type_id) {
					$exam_result_count = $this->ExamType->ExamResult->find('count', 
						array(
							'conditions' => array('exam_type_id' => $user_deleted_exam_type_id),
							'recursive' => -1
						)
					);
					if($exam_result_count > 0) {
						$exam_type_name = $this->ExamType->field('exam_name', 
							array(
								'ExamType.id' => $user_deleted_exam_type_id
							)
						);
						$this->Session->setFlash('<span></span>'.__($exam_type_name.' exam type has exam result and could not be deleted. Please delete the exam result before you make deletion.'), 'default', array('class' => 'error-message error-box'));
						return $this->redirect(array('action' => (strcasecmp($sourse, 'instructor') == 0 ? 'add' : 'exam_type_mgt_for_instructor'), $published_course_id));
					}
				}
			}
			$duplicate_exam_type = false;
			$exam_type_name = array();
			foreach($this->request->data['ExamType'] as $key => $exam_type_check) {
				if(is_array($exam_type_check))
				$exam_type_name[] = $exam_type_check['exam_name'];
			}
			for($i = 0; $i < count($exam_type_name); $i++) {
				for($j = $i+1; $j < count($exam_type_name); $j++) {
					if(strcasecmp($exam_type_name[$i], $exam_type_name[$j]) == 0) {
						$duplicate_exam_type = $exam_type_name[$i];
						break 2;
					}
				}
			}
			$this->ExamType->create();
			$this->set($this->request->data['ExamType']);
			if($duplicate_exam_type) {
				$this->Session->setFlash('<span></span>'.__($duplicate_exam_type.' exam type is duplicated. Please use uniqe name.'), 'default', array('class' => 'error-message error-box'));
			}
			else if($percent_sum_validation && $percent_sum != 100) {
				$this->Session->setFlash('<span></span>'.__('The sum of exam percentage should be equal with 100.'), 'default', array('class' => 'error-message error-box'));
			}
			else if($percent_sum_validation && $mandatory_exam == 0) {
				$this->Session->setFlash('<span></span>'.__('You are required to select at least one exam (for example final exam) as a mandatory exam.'), 'default', array('class' => 'error-message error-box'));
			}
			else if ($this->ExamType->saveAll($this->request->data['ExamType'], array('validate'=>'first'))) {
				if(!empty($deleted_exam_types)) {
					if(!$this->ExamType->deleteAll(array('ExamType.id'=>$deleted_exam_types), false)) {
						$this->Session->setFlash('<span></span>'.__('Exam type entry/update is saved but deletion for exam type is interrupted. Please check your exam type entry and/or update for consistency.'), 'default', array('class' => 'error-message error-box'));
						return $this->redirect(array('action' => (strcasecmp($sourse, 'instructor') == 0 ? 'add' : 'exam_type_mgt_for_instructor'), $published_course_id));
						//redirect to add page
					}
				}
				/*foreach($deleted_exam_types as $key => $user_deleted_exam_type_id) {
					$this->ExamType->delete($user_deleted_exam_type_id);
				}*/
				$this->Session->setFlash('<span></span>'.__('The exam type has been saved'), 'default', array('class' => 'success-message success-box'));
					return $this->redirect(array('controller'=>'examResults','action' => 'add',$published_course_id));
				return $this->redirect(array('action' => (strcasecmp($sourse, 'instructor') == 0 ? 'add' : 'exam_type_mgt_for_instructor'), $published_course_id));
			} else {
				$this->Session->setFlash('<span></span>'.__('The exam type could not be saved. Please, try again.'), 'default', array('class' => 'error-message error-box'));
			}
		}//End of if(!empty($this->request->data))

		//Published courses retrival
		if(strcasecmp($sourse, 'instructor')==0)
			$publishedCourses = $this->ExamType->PublishedCourse->CourseInstructorAssignment->listOfCoursesInstructorAssignedBySection($selected_acadamic_year, $selected_semester, $instructor_id);
		else if(!empty($this->request->data) || $published_course_id){
			$department_id = $this->department_id;
			if(empty($this->request->data)) {
				$published_course_detail = $this->ExamType->PublishedCourse->find('first', 
					array(
						'conditions' => array('PublishedCourse.id' => $published_course_id),
						'recursive' => -1
					)
				);
				$program_type_id = $published_course_detail['PublishedCourse']['program_type_id'];
				$program_id = $published_course_detail['PublishedCourse']['program_id'];
				$acadamic_year = $published_course_detail['PublishedCourse']['academic_year'];
				$semester = $published_course_detail['PublishedCourse']['semester'];
				//$published_course_combo_id = $published_course_id;
			}
			else {
				//$program_type_id = $this->request->data['ExamType']['program_type_id'];
				//$program_id = $this->request->data['ExamType']['program_id'];
				$acadamic_year = $selected_acadamic_year;//$this->request->data['ExamType']['acadamic_year'];
				$semester = $selected_semester; //$this->request->data['ExamType']['semester'];
			}
			$publishedCourses = $this->ExamType->PublishedCourse->CourseInstructorAssignment-> listOfCoursesSectionsTakingOrgBySection($department_id, $acadamic_year, $semester, $program_id, $program_type_id);
		}
		//End of published courses retrival
		
		if(!empty($publishedCourses))
			$publishedCourses = array('' => '---Select Course---') + $publishedCourses;

		//The user need to select a course inorder to see the record page
		if(0 && !empty($publishedCourses) && empty($this->request->data)) {
			$default_course_section = array_keys($publishedCourses);
			$default_course_section = array_keys($publishedCourses[$default_course_section[0]]);
			//$default_course_section = explode('~', $default_course_section[0]);
			//$section_id = $default_course_section[0];
			$published_course_id = $default_course_section[0];
			$exam_types = $this->ExamType->find('all', array(
				'conditions' => array(
					'ExamType.published_course_id' => $published_course_id,
					//'ExamType.section_id' => $section_id
				),
				'recursive' => -1
			));//->CourseRegistration->ExamGrade
			if(count($exam_types) > 0)
				$edit = 1;
				
			//debug($exam_types);
		}

		$course_exam_grade = array();
		if(!empty($published_course_id)) {
		$course_exam_grade = $this->ExamType->PublishedCourse->find('all', array(
			'conditions' => array(
				'PublishedCourse.id' => $published_course_id,
				//'PublishedCourse.section_id' => $section_id
			),
			'contain' => 
				array(
					'CourseRegistration' => 
					array(
						'ExamGrade' => 
						array(
							'fields' => 'ExamGrade.id'
						)
					),
					'CourseAdd' => 
					array(
						'ExamGrade' => 
						array(
							'fields' => 'ExamGrade.id'
						)
					),
				),
		));//debug($course_exam_grade);
		$published_course_department = $this->ExamType->PublishedCourse->find('first',
				array(
					'conditions' => array('PublishedCourse.id' => $published_course_id),
					'contain' => array('Section' => array('Department'))
				)
			);
		$publishedCourses= $this->ExamType->PublishedCourse->CourseInstructorAssignment->listOfCoursesInstructorAssignedBySection($published_course_department['PublishedCourse']['academic_year'], $published_course_department['PublishedCourse']['semester'], $instructor_id_for_checking);
			
		}
		
		if((isset($course_exam_grade[0]['CourseRegistration'][0]['ExamGrade']) && count($course_exam_grade[0]['CourseRegistration'][0]['ExamGrade']) > 0) || (isset($course_exam_grade[0]['CourseAdd'][0]['ExamGrade']) && count($course_exam_grade[0]['CourseAdd'][0]['ExamGrade']) > 0)) {
		    //	$grade_submitted = true;
                     $grade_submitted = ClassRegistry::init('ExamGrade')->editableExamType($published_course_id);
		}
                
		
                
		$all_exam_setup_detail = 'exam_name,percent,order,mandatory,edit';
		$this->set(compact('grade_submitted', 'edit', 'exam_types', 'publishedCourses', 'selected_semester', 'published_course_combo_id', 'all_exam_setup_detail', 'program_type_id', 'program_id', 'acadamic_year', 'semester'));
	}

	function get_exam_type_entry_form($published_course_id = null) {
		if($this->Auth->user('id')) {
			if(strcasecmp('null', $published_course_id) == 0)
				$published_course_id = null;
			$this->layout = 'ajax';
			$edit = 0;
			$exam_types = array();
			$grade_submitted = false;
			$view_only = false;
		
			if(!empty($published_course_id)) {
				//User legibility checking
				$instructor_id_for_checking = $this->ExamType->PublishedCourse->CourseInstructorAssignment->field('CourseInstructorAssignment.staff_id', array('CourseInstructorAssignment.published_course_id' => $published_course_id, 'CourseInstructorAssignment.type LIKE \'%Lecture%\'', 'isprimary' => 1));
				//Not to block department head his/her own assigned courses
				$login_instructor_id = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->field('id', array('Staff.user_id' => $this->Auth->user('id')));
			
				$assigned_instructor_user_id = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->field('Staff.user_id', array('Staff.id' => $instructor_id_for_checking));
				$active_account = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->User->field('active', array('User.id' => $assigned_instructor_user_id));
				//Role based checking is removed
				//if(($this->role_id == 5 || $this->role_id == 6) && $active_account == 1 && $instructor_id_for_checking != $login_instructor_id)
				if($active_account == 1 && $instructor_id_for_checking != $login_instructor_id)
					$view_only = true;
				//End of user eligibility checking
			
				//Now it is accessible as long as he/she has permission
				//if($this->role_id == 5 || $this->role_id == 6 || $instructor_id_for_checking == $login_instructor_id) {
				if(1) {
					$instructor_id = $this->ExamType->PublishedCourse->CourseInstructorAssignment->Staff->field('id', array('user_id' => $this->Auth->user('id')));
					$course_assigned = $this->ExamType->PublishedCourse->CourseInstructorAssignment->find('count', 
						array(
							'conditions' => array(
								'CourseInstructorAssignment.published_course_id' => $published_course_id,
								),
							'recursive' => -1
						)
					);
				
					//Now it is accessible as long as s/he has the privilage (actually it is public)
					//if($course_assigned <= 0 && !($this->role_id == 6 || $this->role_id == 5))
					if(0)
						$published_course_id = null;
					else {
						$exam_types = $this->ExamType->find('all', 
							array(
								'conditions' => array(
									'ExamType.published_course_id' => $published_course_id,
								),
								'recursive' => -1
							)
						);
					}
					if(count($exam_types) > 0)
						$edit = 1;
					$course_exam_grade = $this->ExamType->PublishedCourse->find('all', 
						array(
							'conditions' => array(
								'PublishedCourse.id' => $published_course_id,
							),
							'contain' => 
								array(
									'CourseRegistration' => 
									array(
										'ExamGrade' => 
										array(
											'fields' => 'ExamGrade.id'
										)
									),
									'CourseAdd' => 
									array(
										'ExamGrade' => 
										array(
											'fields' => 'ExamGrade.id'
										)
									)
								),
							)
						);
						
					if((isset($course_exam_grade[0]['CourseRegistration'][0]['ExamGrade']) && count($course_exam_grade[0]['CourseRegistration'][0]['ExamGrade']) > 0) || (isset($course_exam_grade[0]['CourseAdd'][0]['ExamGrade']) && count($course_exam_grade[0]['CourseAdd'][0]['ExamGrade']) > 0))
						$grade_submitted = true;
				}
				else
					$published_course_id = null;
			}//End of if if(!empty($published_course_id))
			$all_exam_setup_detail = 'exam_name,percent,order,mandatory,edit';
			$this->set(compact('grade_submitted', 'edit', 'exam_types', 'published_course_id', 'all_exam_setup_detail', 'view_only'));
		}//login user checking
	}
	public function view($pid){
			$continouseExamSetup=ClassRegistry::init('ExamType')->getExamType($pid);
			$total_registered=ClassRegistry::init('CourseRegistration')->find('count',
array('conditions'=>array('CourseRegistration.published_course_id'=>$pid)));
						
		   $this->set(compact('continouseExamSetup','total_registered'));
	}
}
