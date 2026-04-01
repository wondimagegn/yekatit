<?php
class DashboardController extends AppController
{
	public $name = "Dashboard";
	public $uses = array();
	public $menuOptions = array(

		'exclude' => array('index', 'get_modal'),
		'weight' => -100000000,
	);

	public $components = array('EthiopicDateTime', 'AcademicYear', 'RequestHandler');

	public function beforeRender()
	{
		$acyear_array_data = $this->AcademicYear->acyear_array();
		//To diplay current academic year as default in drop down list
		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		foreach ($acyear_array_data as $k => $v) {
			if ($v == $defaultacademicyear) {
				$defaultacademicyear = $k;
				break;
			}
		}
		$this->set(compact('acyear_array_data', 'defaultacademicyear'));
		unset($this->request->data['User']['password']);
	}
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(
			'get_modal',
			'getMessageAjax',
			'getRankAjax',
			'getApprovalCourseListAjax',
			'getApprovalRejectGradeChange',
			'getApprovalRejectGrade',
			'disptachedAssignedCourseList',
			'addDropRequestList',
			'clearanceWithdrawSubRequest',
			'getProfileNotComplete',
			'getCourseSchedule',
			'getBackupAccountRequest',
			'getAcademicCalender',
			'getStudentAssignedDormitory'
		);
	}

	public function get_modal($published_course_id = null)
	{
		$this->layout = 'ajax';
		if (!empty($published_course_id)) {
			//get publishedcourse details
			$publishedCourse_details = ClassRegistry::init('CourseSchedule')->get_published_course_details($published_course_id);
			$formatted_published_course_detail = array();
			$formatted_published_course_detail['course_code'] = $publishedCourse_details['Course']['course_code'];
			$formatted_published_course_detail['course_name'] = $publishedCourse_details['Course']['course_title'];
			//Instructor assigned for lecture
			if ($publishedCourse_details['Course']['lecture_hours'] != 0) {
				if (!empty($publishedCourse_details['CourseInstructorAssignment'])) {
					$is_instructor_assigned = false;
					foreach ($publishedCourse_details['CourseInstructorAssignment'] as $assigned_instructor) {
						if (strcasecmp($assigned_instructor['type'], 'Lecture') == 0 || strcasecmp($assigned_instructor['type'], 'Lecture+Tutorial') == 0 || strcasecmp($assigned_instructor['type'], 'Lecture+Lab') == 0) {
							if (isset($formatted_published_course_detail['lecture'])) {
								$formatted_published_course_detail['lecture'] = $formatted_published_course_detail['lecture'] . ', ' . $assigned_instructor['Staff']['Title']['title'] . ' ' . $assigned_instructor['Staff']['full_name'];
							} else {
								$formatted_published_course_detail['lecture'] = $assigned_instructor['Staff']['Title']['title'] . ' ' . $assigned_instructor['Staff']['full_name'];
							}
							$is_instructor_assigned = true;
						}
					}
					if ($is_instructor_assigned == false) {
						$formatted_published_course_detail['lecture'] = "TBA";
					}
				} else {
					$formatted_published_course_detail['lecture'] = "TBA";
				}
			}

			//Instructor assigned for Tutorial
			if ($publishedCourse_details['Course']['tutorial_hours'] != 0) {
				if (!empty($publishedCourse_details['CourseInstructorAssignment'])) {
					$is_instructor_assigned = false;
					foreach ($publishedCourse_details['CourseInstructorAssignment'] as $assigned_instructor) {
						if (strcasecmp($assigned_instructor['type'], 'Tutorial') == 0 || strcasecmp($assigned_instructor['type'], 'Lecture+Tutorial') == 0) {
							if (isset($formatted_published_course_detail['tutorial'])) {
								$formatted_published_course_detail['tutorial'] = $formatted_published_course_detail['tutorial'] . ', ' . $assigned_instructor['Staff']['Title']['title'] . ' ' . $assigned_instructor['Staff']['full_name'];
							} else {
								$formatted_published_course_detail['tutorial'] = $assigned_instructor['Staff']['Title']['title'] . ' ' . $assigned_instructor['Staff']['full_name'];
							}
							$is_instructor_assigned = true;
						}
					}
					if ($is_instructor_assigned == false) {
						$formatted_published_course_detail['tutorial'] = "TBA";
					}
				} else {
					$formatted_published_course_detail['tutorial'] = "TBA";
				}
			}
			//Instructor assigned for Laboratory
			if ($publishedCourse_details['Course']['laboratory_hours'] != 0) {
				if (!empty($publishedCourse_details['CourseInstructorAssignment'])) {
					$is_instructor_assigned = false;
					foreach ($publishedCourse_details['CourseInstructorAssignment'] as $assigned_instructor) {
						if (strcasecmp($assigned_instructor['type'], 'Lab') == 0 || strcasecmp($assigned_instructor['type'], 'Lecture+Lab') == 0) {
							if (isset($formatted_published_course_detail['lab'])) {
								$formatted_published_course_detail['lab'] = $formatted_published_course_detail['lab'] . ', ' . $assigned_instructor['Staff']['Title']['title'] . ' ' . $assigned_instructor['Staff']['full_name'];
							} else {
								$formatted_published_course_detail['lab'] = $assigned_instructor['Staff']['Title']['title'] . ' ' . $assigned_instructor['Staff']['full_name'];
							}
							$is_instructor_assigned = true;
						}
					}
					if ($is_instructor_assigned == false) {
						$formatted_published_course_detail['lab'] = "TBA";
					}
				} else {
					$formatted_published_course_detail['lab'] = "TBA";
				}
			}
			$this->set(compact('formatted_published_course_detail'));
		}
	}
	public function index()
	{
		$this->layout = 'dashboard';

		//$comingAcademicCalendarsDeadlines=ClassRegistry::init('AcademicCalendar')->getComingAcademicCalendarsDeadlines();



		if ($this->role_id == ROLE_STUDENT) {
			$comingAcademicCalendarsDeadlines = array();
		} else {

			if (!empty($this->department_id)) {

				$comingAcademicCalendarsDeadlines = ClassRegistry::init('AcademicCalendar')->getComingAcademicCalendarsDeadlines($this->AcademicYear->current_academicyear(), $this->department_id);
				debug($comingAcademicCalendarsDeadlines);
			} else if (!empty($this->college_id) && empty($this->department_id)) {
				// $calendar['pre_'.$this->college_id]=$calendarr['pre_'.$this->college_id];
			}
		}
		$this->set(compact('comingAcademicCalendarsDeadlines'));


		/*
          $courses_for_registrar_approval=ClassRegistry::init('ExamGrade')->getListOfGradeForRegistrarApproval($this->department_ids,$this->college_ids);
          $this->set(array(
            'courses_for_registrar_approval' => $courses_for_registrar_approval,
            '_serialize' => array('courses_for_registrar_approval')
        ));
        18067

         */
		//ClassRegistry::init('ExamGrade')->getRejectedOrNonApprovedPublishedCourseList($this->department_id, 1);


	}
	public function getProfileNotComplete()
	{
		$this->layout = "ajax";
		$profile_not_build = array();
		/*
        	if($this->MenuOptimized->check($this->Auth->user(), 'controllers/Students/profile_not_build_list') && ($this->role_id != ROLE_STUDENT)) {
			if(!empty($this->department_ids)) {
			$profile_not_build = ClassRegistry::init('Student')->getProfileNotBuildList(
20,$this->department_ids);
			} else if (!empty($this->college_ids)) {
			$profile_not_build = ClassRegistry::init('Student')->getProfileNotBuildList(
20,$this->college_ids,1);
			}
		}
	        $profile_not_buildc=count($profile_not_build);
	        */
		$this->set(compact('profile_not_build', 'profile_not_buildc'));
		$this->set('_serialize', array('profile_not_buildc'));
	}

	public function getAcademicCalender()
	{
		$this->layout = "ajax";
		$calendar = array();
		if ($this->role_id == ROLE_STUDENT) {
			$calendarr = ClassRegistry::init('AcademicCalendar')->getAcademicCalender($this->AcademicYear->current_academicyear());
			if (!empty($this->department_id)) {
				$calendar[$this->department_id] = $calendarr[$this->department_id];
			} else if (!empty($this->college_id) && empty($this->department_id)) {
				$calendar['pre_' . $this->college_id] = $calendarr['pre_' . $this->college_id];
			}
			$this->set(compact('calendar'));
		}
		$this->set(compact('calendar'));
		$this->set('_serialize', array('calendar'));
	}

	public function clearanceWithdrawSubRequest()
	{
		$this->layout = "ajax";
		$clearance_request = array();
		$exemption_request = array();
		$substitution_request = array();
		//clearances/approve_clearance
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/Clearances/approve_clearance')) {
			if (!empty($this->department_ids)) {

				$clearance_request = ClassRegistry::init('Clearance')->count_clearnce_request($this->department_ids);
			} else if (!empty($this->college_ids)) {

				$clearance_request = ClassRegistry::init('Clearance')->count_clearnce_request(
					null,
					$this->college_ids
				);
			}
			$this->set(compact('clearance_request'));
			//$this->set('_serialize', array('clearance_request'));
		}

		//courseExemptions/list_exemption_request
		if ($this->MenuOptimized->check(
			$this->Auth->user(),
			'controllers/CourseExemptions/list_exemption_request'
		)) {

			if (!empty($this->department_ids)) {

				$exemption_request = ClassRegistry::init('CourseExemption')->count_exemption_request($this->role_id, $this->department_ids, null);
			} else if (!empty($this->college_ids)) {

				$exemption_request = ClassRegistry::init('CourseExemption')->count_exemption_request($this->role_id, null, $this->college_ids);
			}
			$this->set(compact('exemption_request'));
			// $this->set('_serialize', array('exemption_request'));
		}

		//substitution
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseSubstitutionRequests/approve_substitution')) {
			$substitution_request = ClassRegistry::init('CourseSubstitutionRequest')->count_substitution_request($this->department_id);
			$this->set(compact('substitution_request'));
			//$this->set('_serialize', array('substitution_request'));
		}
		$this->set('_serialize', array(
			'clearance_request', 'substitution_request',
			'exemption_request'
		));
	}

	public function addDropRequestList()
	{
		//course_drops/approve_drops
		$this->layout = "ajax";
		$drop_request = array();
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseDrops/approve_drops')) {
			if ($this->role_id == ROLE_REGISTRAR) {

				if (!empty($this->department_ids)) {

					$drop_request = ClassRegistry::init('CourseDrop')->count_drop_request(
						$this->department_ids
					);
				} else if (!empty($this->college_ids)) {

					$drop_request = ClassRegistry::init('CourseDrop')->count_drop_request(
						null,
						1,
						$this->college_ids
					);
				}
			} else {
				if ($this->role_id == ROLE_DEPARTMENT) {

					$drop_request_dpt = ClassRegistry::init('CourseDrop')->count_drop_request(
						$this->department_id,
						2
					);
				} else if ($this->role_id == ROLE_COLLEGE) {
					$drop_request = ClassRegistry::init('CourseDrop')->count_drop_request(
						null,
						3,
						$this->college_id
					);
				}
			}
			$this->set(compact('drop_request', 'drop_request_dpt'));
			//$this->set('_serialize', array('drop_request','drop_request_dpt'));
		}

		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseDrops/forced_drop')) {
			//	$forced_drops = ClassRegistry::init('CourseDrop')->list_of_students_need_force_drop($this->department_ids);
			//$this->set(compact('forced_drops'));
		}

		//course_adds/approve_adds
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseAdds/approve_adds')) {

			if ($this->role_id == ROLE_REGISTRAR) {
				if (!empty($this->department_ids)) {

					$add_request = ClassRegistry::init('CourseAdd')->count_add_request(
						$this->department_ids,
						1,
						null,
						$this->program_id,
						$this->program_type_id
					);
				} else if (!empty($this->college_ids)) {

					$add_request = ClassRegistry::init('CourseAdd')->count_add_request(
						null,
						1,
						$this->college_ids,
						$this->program_id,
						$this->program_type_id
					);
				}
			} else {

				if ($this->role_id == ROLE_DEPARTMENT) {

					$add_request_dpt = ClassRegistry::init('CourseAdd')->count_add_request($this->department_id, 2);
				} else if ($this->role_id == ROLE_COLLEGE) {

					$add_request = ClassRegistry::init('CourseAdd')->count_add_request(
						null,
						3,
						$this->college_id
					);
				}
			}
			$this->set(compact('add_request', 'add_request_dpt'));
			//$this->set('_serialize', array('add_request','add_request_dpt'));
		}
		$this->set('_serialize', array('drop_request', 'drop_request_dpt', 'add_request', 'add_request_dpt'));
	}


	/*
	* Introduce for the purpose of optimization, the login process
	* is becoming slow becuse of too many queries
	*/
	public function getMessageAjax()
	{
		$this->layout = 'ajax';
		//Message Box
		$auto_messages = ClassRegistry::init('AutoMessage')->getMessages($this->Auth->user('id'));
		$this->set('auto_messages', $auto_messages);
		$this->set('_serialize', array('auto_messages'));
	}
	public function getRankAjax()
	{
		$this->layout = 'ajax';
		if ($this->role_id == ROLE_STUDENT) {
			//Display student rank relative to others
			$rank = ClassRegistry::init('StudentExamStatus')->displayStudentRank($this->student_id, $this->AcademicYear->current_academicyear());

			$this->set('rank', $rank);
			$this->set('_serialize', array('rank'));
		}
	}

	public function getStudentAssignedDormitory()
	{
		$this->layout = 'ajax';
		if ($this->role_id == ROLE_STUDENT) {
			//Display student dorm
			$dormAssignedStudent = ClassRegistry::init('DormitoryAssignment')->getStudentAssignedDormitory($this->student_id);
			$this->set('dormAssignedStudent', $dormAssignedStudent);
			$this->set('_serialize', array('dormAssignedStudent'));
		}
	}

	public function getCourseSchedule()
	{
		if ($this->role_id == ROLE_STUDENT) {
			$student_course_schedules = array();
			/*
			    $student_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForStudent($this->student_id, $this->AcademicYear->current_academicyear());
			*/
			$this->set(compact('student_course_schedules'));
			$this->set('_serialize', array('student_course_schedules'));
		} else if ($this->role_id == ROLE_INSTRUCTOR) {
			//Instructor course schedule
			$instructor_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForInstructor($this->Auth->user('id'), $this->role_id);
			$this->set(compact('instructor_course_schedules'));
			$this->set('_serialize', array('instructor_course_schedules'));
		}
	}

	public function getApprovalRejectGrade()
	{
		$this->layout = 'ajax';
		//If the user has department grade approval privilage
		if ($this->MenuOptimized->check(
			$this->Auth->user(),
			'controllers/ExamGrades/approve_non_freshman_grade_submission'
		)) {

			$courses_for_dpt_approvals = ClassRegistry::init('ExamGrade')->getRejectedOrNonApprovedPublishedCourseList($this->department_id, 1);

			$this->set('courses_for_dpt_approvals', $courses_for_dpt_approvals);
			$this->set('_serialize', array('courses_for_dpt_approvals'));
		}

		//If the user has freshman program grade approval privilage
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGrades/approve_freshman_grade_submission')) {

			$courses_for_freshman_approvals = ClassRegistry::init('ExamGrade')->getRejectedOrNonApprovedPublishedCourseList(
				$this->department_id,
				0
			);

			$this->set('courses_for_freshman_approvals', $courses_for_freshman_approvals);
			$this->set('_serialize', array('courses_for_freshman_approvals'));
		}

		//If the user has regustrar grade confirmation privilage
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGrades/confirm_grade_submission')) {
			/*
		   $courses_for_registrar_approval = ClassRegistry::init('ExamGrade')->getRegistrarNonApprovedCoursesList($this->department_ids, $this->college_ids,$this->program_id,$this->program_type_id);
		   */

			$courses_for_registrar_approval = ClassRegistry::init('ExamGrade')->getRegistrarNonApprovedCoursesList(
				$this->department_ids,
				$this->college_ids,
				$this->program_id,
				$this->program_type_id
			);
			$this->set('courses_for_registrar_approval', $courses_for_registrar_approval);
			$this->set(
				'_serialize',
				array('courses_for_registrar_approval')
			);
		}
	}

	public function getApprovalRejectGradeChange()
	{
		$this->layout = 'ajax';
		//If the user has college grade change approval privilage
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_college_grade_change')) {
			debug($this->college_id);
			$exam_grade_changes_for_college_approval = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForCollegeApproval($this->college_id);
			$exam_grade_changes_for_college_approval_sum = 0;
			foreach ($exam_grade_changes_for_college_approval as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						$exam_grade_changes_for_college_approval_sum += count($value3);
					}
				}
			}
			$exam_grade_changes_for_college_approval = $exam_grade_changes_for_college_approval_sum;
			//debug($exam_grade_changes_for_college_approval);
			$this->set(compact('exam_grade_changes_for_college_approval'));
		}

		//If the user has department grade change approval privilage
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_department_grade_change')) {
			$exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->department_id, 1);
			$exam_grade_change_requests_sum = 0;
			foreach ($exam_grade_change_requests as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$exam_grade_change_requests_sum += count($value2);
				}
			}
			$exam_grade_change_requests = $exam_grade_change_requests_sum;
			$makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 0, 1);
			$makeup_exam_grades_sum = 0;
			foreach ($makeup_exam_grades as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$makeup_exam_grades_sum += count($value2);
				}
			}
			$makeup_exam_grades = $makeup_exam_grades_sum;
			$rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 1, 1);
			$rejected_makeup_exams_sum = 0;
			foreach ($rejected_makeup_exams as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$rejected_makeup_exams_sum += count($value2);
				}
			}
			$rejected_makeup_exams = $rejected_makeup_exams_sum;
			$rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->department_id, 1);
			$rejected_supplementary_exams_sum = 0;
			foreach ($rejected_supplementary_exams as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$rejected_supplementary_exams_sum += count($value2);
				}
			}
			$rejected_supplementary_exams = $rejected_supplementary_exams_sum;
			$this->set(compact('exam_grade_change_requests', 'makeup_exam_grades', 'rejected_makeup_exams', 'rejected_supplementary_exams'));


			$this->set('_serialize', array(
				'exam_grade_change_requests', 'makeup_exam_grades', 'rejected_makeup_exams',
				'rejected_supplementary_exams'
			));
		}

		//If the user has freshman grade change approval privilage
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_freshman_grade_change')) {
			$fm_exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->college_id, 0);
			$fm_exam_grade_change_requests_sum = 0;
			foreach ($fm_exam_grade_change_requests as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$fm_exam_grade_change_requests_sum += count($value2);
				}
			}

			$fm_exam_grade_change_requests = $fm_exam_grade_change_requests_sum;
			$fm_makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 0, 0);
			$fm_makeup_exam_grades_sum = 0;
			foreach ($fm_makeup_exam_grades as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$fm_makeup_exam_grades_sum += count($value2);
				}
			}
			$fm_makeup_exam_grades = $fm_makeup_exam_grades_sum;
			$fm_rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 1, 0);
			$fm_rejected_makeup_exams_sum = 0;
			foreach ($fm_rejected_makeup_exams as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$fm_rejected_makeup_exams_sum += count($value2);
				}
			}
			$fm_rejected_makeup_exams = $fm_rejected_makeup_exams_sum;
			$fm_rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->college_id, 0);
			$fm_rejected_supplementary_exams_sum = 0;
			foreach ($fm_rejected_supplementary_exams as $key => $value) {
				foreach ($value as $key2 => $value2) {
					$fm_rejected_supplementary_exams_sum += count($value2);
				}
			}
			$fm_rejected_supplementary_exams = $fm_rejected_supplementary_exams_sum;
			$this->set(compact('fm_exam_grade_change_requests', 'fm_makeup_exam_grades', 'fm_rejected_makeup_exams', 'fm_rejected_supplementary_exams'));

			$this->set('_serialize', array(
				'fm_exam_grade_change_requests', 'fm_makeup_exam_grades', 'fm_rejected_makeup_exams',
				'fm_rejected_supplementary_exams'
			));
		}


		//If the user has registrar grade change approval privilage
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_registrar_grade_change')) {
			$reg_exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForRegistrarApproval($this->department_ids, $this->college_ids, $this->program_id, $this->program_type_id);

			//debug($reg_exam_grade_change_requests);

			$reg_exam_grade_change_requests_sum = 0;
			foreach ($reg_exam_grade_change_requests as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							$reg_exam_grade_change_requests_sum += count($value4);
						}
					}
				}
			}
			$reg_exam_grade_change_requests = $reg_exam_grade_change_requests_sum;
			$reg_makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForRegistrarApproval(
				$this->department_ids,
				$this->college_ids,
				$this->program_id,
				$this->program_type_id
			);
			$reg_makeup_exam_grades_sum = 0;
			foreach ($reg_makeup_exam_grades as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							$reg_makeup_exam_grades_sum += count($value4);
						}
					}
				}
			}
			$reg_makeup_exam_grades = $reg_makeup_exam_grades_sum;
			$reg_supplementary_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeByDepartmentForRegistrarApproval($this->department_ids, $this->college_ids);
			$reg_supplementary_exam_grades_sum = 0;
			foreach ($reg_supplementary_exam_grades as $key => $value) {
				foreach ($value as $key2 => $value2) {
					foreach ($value2 as $key3 => $value3) {
						foreach ($value3 as $key4 => $value4) {
							$reg_supplementary_exam_grades_sum += count($value4);
						}
					}
				}
			}
			$reg_supplementary_exam_grades = $reg_supplementary_exam_grades_sum;
			$this->set(compact(
				'reg_exam_grade_change_requests',
				'reg_makeup_exam_grades',
				'reg_supplementary_exam_grades'
			));
			$this->set('_serialize', array(
				'reg_exam_grade_change_requests',
				'reg_makeup_exam_grades', 'reg_supplementary_exam_grades'
			));
		}
		$this->set('_serialize', array(
			'exam_grade_change_requests', 'makeup_exam_grades', 'rejected_makeup_exams',
			'rejected_supplementary_exams', 'exam_grade_changes_for_college_approval',
			'reg_exam_grade_change_requests', 'reg_makeup_exam_grades', 'reg_supplementary_exam_grades',
			'fm_exam_grade_change_requests', 'fm_makeup_exam_grades',
			'fm_rejected_makeup_exams', 'fm_rejected_supplementary_exams'
		));
	}

	public function getBackupAccountRequest()
	{
		$this->layout = 'ajax';
		//Backup
		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/Backups/index')) {
			$latest_backups = ClassRegistry::init('Backup')->getLatestBackups(3);
			$this->set(compact('latest_backups'));
		}

		if ($this->role_id == ROLE_SYSADMIN) {
			$tasks_for_confirmation = ClassRegistry::init('Vote')->getListOfTaskForConfirmation($this->Auth->user('id'));
			$confirmed_tasks = ClassRegistry::init('Vote')->getListOfOtherAdminTasks($this->Auth->user('id'));
			$confirmed_taskss = count($confirmed_tasks);
			$password_reset_confirmation_request = 0;
			$admin_cancelation_confirmation_request = 0;
			$admin_assignment_confirmation_request = 0;
			$role_change_confirmation_request = 0;
			$deactivation_confirmation_request = 0;
			$activation_confirmation_request = 0;
			foreach ($tasks_for_confirmation as $value) {
				if (strcasecmp($value['Vote']['task'], 'Password Reset') == 0) {
					$password_reset_confirmation_request++;
				} else if (strcasecmp($value['Vote']['task'], 'Administrator Cancellation') == 0) {
					$admin_cancelation_confirmation_request++;
				} else if (strcasecmp($value['Vote']['task'], 'Administrator Assignment') == 0) {
					$admin_assignment_confirmation_request++;
				} else if (strcasecmp($value['Vote']['task'], 'Role Change') == 0) {
					$role_change_confirmation_request++;
				} else if (strcasecmp($value['Vote']['task'], 'Account Deactivation') == 0) {
					$deactivation_confirmation_request++;
				} else if (strcasecmp($value['Vote']['task'], 'Account Activation') == 0) {
					$activation_confirmation_request++;
				}
			}
			$this->set(compact('password_reset_confirmation_request', 'admin_cancelation_confirmation_request', 'admin_assignment_confirmation_request', 'confirmed_taskss', 'confirmed_tasks', 'role_change_confirmation_request', 'deactivation_confirmation_request', 'activation_confirmation_request'));
		}

		$this->set('_serialize', array(
			'password_reset_confirmation_request', 'admin_cancelation_confirmation_request', 'admin_assignment_confirmation_request', 'confirmed_taskss', 'role_change_confirmation_request', 'deactivation_confirmation_request',
			'activation_confirmation_request', 'latest_backups'
		));
	}
	public function courseSchedule()
	{
		if ($this->role_id == ROLE_STUDENT) {
			//Student course schedule
			$student_course_schedules = 0;
			$student_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForStudent($this->student_id);

			$this->set(compact('section_course_schedule', 'starting_and_ending_hour'));
			$this->set('_serialize', array('section_course_schedule', 'starting_and_ending_hour'));
		} else if ($this->role_id == ROLE_INSTRUCTOR) {
			//Instructor course schedule
			$instructor_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForInstructor($this->Auth->user('id'), $this->role_id);
			$this->set(compact('instructor_course_schedules'));
			$this->set('_serialize', array('instructor_course_schedules'));
		}
	}
	public function disptachedAssignedCourseList()
	{
		$this->layout = "ajax";
		/*
		if($this->MenuOptimized->check($this->Auth->user(), 'controllers/examResults/add')) {
			$latest_assigned_courses = ClassRegistry::init('AutoMessage')->
			getInstructorLatestCourseAssignment($this->Auth->user('id'));
			debug($latest_assigned_courses);
			$this->set(compact('latest_assigned_courses'));
            $this->set('_serialize',
            	array('latest_assigned_courses'));
		}
		*/
		//If the user has instructor assignment
		/*
		if($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseInstructorAssignments/assign_course_instructor')) {
			$this->set('dispatched_course_required_assignment',$dispatched_course_list);
            $this->set('_serialize',array('dispatched_course_required_assignment'));
		}
		*/
		//If the user has instructor assignment



		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseInstructorAssignments/assign_course_instructor')) {
			$dispatched_course_not_assigned = ClassRegistry::init('CourseInstructorAssignment')->getDisptachedCoursesNotAssigned($this->department_id);
			$dispatched_course_list = ClassRegistry::init('CourseInstructorAssignment')->getDisptachedCoursesForNotification($this->department_id);
			$this->set(compact(
				'dispatched_course_not_assigned',
				'dispatched_course_list'
			));
			$this->set('_serialize', array(
				'dispatched_course_list',
				'dispatched_course_not_assigned'
			));
		}
	}
	public function view_logs()
	{
		if (!empty($this->request->data)) {
			// $this->Model->findUserActions(301, array('fields' => array('id','model'),'model' => 'BookTest');
			$params = array();
			$params['fields'] = array(
				'id', 'model',
				'user_id', 'ip', 'foreign_key', 'description', 'action',
				'change', 'created'
			);
			if (isset($this->request->data['Dashboard']['username']) && !empty($this->request->data['Dashboard']['username'])) {
				$username = $this->request->data['Dashboard']['username'];
				$params['conditions'][] = "user_id IN (SELECT id FROM users WHERE username like '%$username%' )";
			}

			if (!empty($this->request->data['Dashboard']['action'])) {
				$params['conditions']['action'] = $this->request->data['Dashboard']['action'];
			}
			if (!empty($this->request->data['Dashboard']['model'])) {
				$params['conditions']['model'] = $this->request->data['Dashboard']['model'];
			}

			if (!empty($this->request->data['Dashboard']['change_date_from'])) {
				$change_date_from = $this->request->data['Dashboard']['change_date_from'];
				$params['conditions']['created >='] = $change_date_from['year'] . '-' . $change_date_from['month'] . '-' . $change_date_from['day'];
			}
			if (!empty($this->request->data['Dashboard']['change_date_to'])) {
				$change_date_to = $this->request->data['Dashboard']['change_date_to'];

				$params['conditions']['created <='] = $change_date_to['year'] . '-' . $change_date_to['month'] . '-' . $change_date_to['day'] . ' ';
			}
			debug($params);
			debug($this->request->data);
			if (!empty($this->request->data['Dashboard']['limit'])) {
				$params['limit'] = $this->request->data['Dashboard']['limit'];
			} else {
				$params['limit'] = 5;
			}

			$logs = ClassRegistry::init('User')
				->getUserLogDetail($this->Auth->user('id'), $params);
		}
		/*
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id <> ' => ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM
				)
			)
		);
		*/
		//$roles = array('0' => '--- All ---') + $roles;
		$this->set(compact('roles', 'logs'));
	}
}
