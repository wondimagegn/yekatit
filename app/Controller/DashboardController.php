<?php
class DashboardController extends AppController
{
	public $name = "Dashboard";
	public $uses = array();

	public $menuOptions = array(
		'exclude' => array(
			'index', 
			'get_modal'
		),
		'weight' => -100000000,
	);

	public $components = array('EthiopicDateTime', 'AcademicYear', 'RequestHandler');

	public function beforeRender()
	{
		$acyear_array_data = $this->AcademicYear->acyear_array();
		$defaultacademicyear = $this->AcademicYear->current_academicyear();

		if(!empty($acyear_array_data)) {
			foreach ($acyear_array_data as $k => $v) {
				if ($v == $defaultacademicyear) {
					$defaultacademicyear = $k;
					break;
				}
			}
		}

		if ($this->Session->check('Auth.User')) {
			if (isset($this->Session->read('users_relation')['User']['id']) && ($this->Session->read('Auth.User')['id'] == $this->Session->read('users_relation')['User']['id'] && $this->role_id == $this->Session->read('Auth.User')['role_id']))  {
				$role_id  = $this->Session->read('Auth.User')['role_id'];
			} else {
				$this->Session->destroy();
				return $this->redirect($this->Auth->logout());
			}
		} else {
			$this->Session->destroy();
			return $this->redirect($this->Auth->logout());
		}

		$this->set('role_id', $role_id);

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

		// check and delete search data from users session, the user logout is not necessary just to clear search session
		/* if ($this->Session->check('search_data')) {
			$this->Session->delete('search_data');
		}

		if ($this->Session->check('search_data_student')) {
			$this->Session->delete('search_data_student');
		}

		if ($this->Session->check('search_data_registration')) {
			$this->Session->delete('search_data_registration');
		}

		if ($this->Session->check('search_data_users_index')) {
			$this->Session->delete('search_data_users_index');
		}

		if ($this->Session->check('search_data_index')) {
			$this->Session->delete('search_data_index');
		}  
		
		if ($this->Session->check('Curriculum.search_data_curriculum')) {
			$this->Session->delete('Curriculum.search_data_curriculum');
		} */

		if ($this->Session->check('Auth.User')) {
			$this->__clearSearchSessions();
		}
	}


	/**
	 * Clear all search-related session data when the user is redirected to dashboard or visits dashbord.
	 */
	private function __clearSearchSessions() 
	{

		$allSession = $this->Session->read();

		// Keys we do not want to inspect deeply
		$excludedParents = ['Config', 'Auth', 'User', 'permissionLists', 'reformatePermission', 'users_relation'];

		foreach ($allSession as $parentKey => $value) {

			// Case 1: top-level key itself is search_*
			if (strpos($parentKey, 'search_') === 0) {
				debug($parentKey);
				debug($value );
				$this->Session->delete($parentKey);
				continue;
			}

			// Case 2: nested array under non-excluded parent
			if (is_array($value) && !in_array($parentKey, $excludedParents)) {
				foreach ($value as $childKey => $childValue) {
					if (strpos($childKey, 'search_') === 0) {
						debug($childKey);
						debug($value );
						$this->Session->delete($parentKey . '.' . $childKey);
					}
				}
			}
		}
	}

	public function get_modal($published_course_id = null)
	{
		$this->layout = 'ajax';

		if (!empty($published_course_id)) {
			//get publishedcourse details
			$publishedCourse_details = ClassRegistry::init('CourseSchedule')->get_published_course_details($published_course_id);
			$formatted_published_course_detail = array();

			if (!empty($publishedCourse_details)) {

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
			}

			$this->set(compact('formatted_published_course_detail'));
		}
	}

	public function index()
	{
		$this->layout = 'dashboard';

		$currentAcySemester = $this->AcademicYear->current_acy_and_semester();
		$current_acy =  $currentAcySemester['academic_year'];
		$current_semester = $currentAcySemester['semester'];

		$current_year = (int) ((explode('/', $current_acy)[0]));


		if (is_numeric(ACY_BACK_GRADE_APPROVAL_DASHBOARD) && ACY_BACK_GRADE_APPROVAL_DASHBOARD) {
			$ac_yearss = $this->AcademicYear->academicYearInArray(($current_year  - ACY_BACK_GRADE_APPROVAL_DASHBOARD), $current_year);
		} else {
			$ac_yearss[$current_acy] = $current_acy;
		}
		
		$acy_ranges_by_coma_quoted_for_display =  implode ( ", ", $ac_yearss);
		
		$this->set(compact('acy_ranges_by_coma_quoted_for_display'));

		$comingAcademicCalendarsDeadlines = array();
		//$comingAcademicCalendarsDeadlines = ClassRegistry::init('AcademicCalendar')->getComingAcademicCalendarsDeadlines();
		
		/* if ($this->role_id == ROLE_STUDENT) {
			$comingAcademicCalendarsDeadlines = array();
		} else {
			if (!empty($this->department_id)) {
				$comingAcademicCalendarsDeadlines = ClassRegistry::init('AcademicCalendar')->getComingAcademicCalendarsDeadlines($this->AcademicYear->current_academicyear(), $this->department_id);
				debug($comingAcademicCalendarsDeadlines);
			} else if (!empty($this->college_id) && empty($this->department_id)) {
				// $calendar['pre_'.$this->college_id] = $calendarr['pre_'.$this->college_id];
			}
		} */

		$this->set(compact('comingAcademicCalendarsDeadlines'));

		$show_fill_alumni_survey_link = false;
		$show_notification_message = true;

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT && !empty($this->Session->read('Auth.User')['id'])) {

			$notEvaluatedList = classRegistry::init('StudentEvalutionRate')->getNotEvaluatedRegisteredCourse($this->student_id);

			if (!classRegistry::init('GeneralSetting')->allowStudentsGradeViewWithouInstructorsEvalution($this->student_id) && !empty($notEvaluatedList)) {
				$show_notification_message = false;
				//TO DO: check evaluation dates form academic calendar and redirect if grade is not submitted and and some X days are prior to grade submisson based on department or college (if freshman)
				//return $this->redirect(array('controller' => 'StudentEvalutionRates', 'action' => 'add'));
			}
			
			$show_fill_alumni_survey_link = $isExitExamEligible = ClassRegistry::init('StudentStatusPattern')->isEligibleForExitExam($this->student_id);
			
			$isNotProfilePage = strcasecmp($this->request->params['action'], 'profile') != 0;
			$isNotUsersPage = strcasecmp($this->request->params['controller'], 'users') != 0;
			$isNotChangePwdPage = strcasecmp($this->request->params['action'], 'changePwd') != 0;

			//force last year students irrispect of FORCE_ALL_STUDENTS_TO_FILL_BASIC_PROFILE value
			
			if (($isExitExamEligible || FORCE_ALL_STUDENTS_TO_FILL_BASIC_PROFILE == 1) && $isNotProfilePage && $isNotUsersPage && $isNotChangePwdPage) {
				if (!ClassRegistry::init('StudentStatusPattern')->completedFillingProfileInfomation($this->student_id)) {
					$this->Flash->warning('Dear ' . $this->Session->read('Auth.User')['first_name']. ', before proceeding, you must complete your basic profile. If you encounter an error, are unable to update your profile on your own, or require further assistance, please report to the registrar record officer assigned to your department.');
					return $this->redirect(array('controller' => 'students', 'action' => 'profile'));
				}
			}

			$studentDetails = ClassRegistry::init('Student')->find('first', array('conditions' => array('Student.id' => $this->student_id), 'fields' => array('id', 'program_id', 'program_type_id', 'studentnumber', 'country_id', 'fayda_identification_number', 'fayda_alias_number',
                'phone_mobile'), 'recursive' => -1));
			$isEthiopianStudent = (isset($studentDetails['Student']['country_id']) && (int) $studentDetails['Student']['country_id'] == COUNTRY_ID_OF_ETHIOPIA ? true : false);
			$isFaydaFinFilled = (isset($studentDetails['Student']['fayda_identification_number']) && !empty($studentDetails['Student']['fayda_identification_number']) ? true : false);
			$isFaydaFanFilled = (isset($studentDetails['Student']['fayda_alias_number']) && !empty($studentDetails['Student']['fayda_alias_number']) ? true : false);


			// force all nationals to fill fayda and TIN
			// comment the following line to force only ethiopian nationals to fill fayda, $isEthiopianStudent is to 1 to overide the previous $isEthiopianStudent variable above, which actually checks students nationality.

			if ($isEthiopianStudent && (!$isFaydaFinFilled || !$isFaydaFanFilled) && ($isExitExamEligible
                    || FORCE_ALL_STUDENTS_TO_FILL_FAYDA_NUMBERS == 1) && $isNotProfilePage && $isNotUsersPage && $isNotChangePwdPage) {

					if (!$isFaydaFinFilled && !$isFaydaFanFilled) {
						$this->Flash->info('Dear ' . $this->Session->read('Auth.User')['first_name']. ', before proceeding, you must update your Fayda Identification Number (FIN) and Fayda Alias Number (FAN). Ensure that you provide the correct 16-digit FAN, located on the front, and the 12-digit FIN, found on the back of your national Fayda ID card.');
					} else if (!$isFaydaFinFilled) {
						$this->Flash->info('Dear ' . $this->Session->read('Auth.User')['first_name']. ', before proceeding, you must update your Fayda Identification Number (FIN). Please ensure that you provide the correct 12-digit FIN, located on the back of your national Fayda ID card.');
					} else {
						$this->Flash->info('Dear ' . $this->Session->read('Auth.User')['first_name']. ', before proceeding, you must update your Fayda Alias Number (FAN). Please ensure that you provide the correct 16-digit FAN, located on the front of your national Fayda ID card.');
					}
				return $this->redirect(array('controller' => 'students', 'action' => 'profile'));
			}

			if (isset($studentDetails['Student']['phone_mobile']) && !empty($studentDetails['Student']['phone_mobile']) && $studentDetails['Student']['phone_mobile'] !== ClassRegistry::init('Student')->getformatedEthiopianMobilePhoneNumber($studentDetails['Student']['phone_mobile'], 1)) {
				$this->Flash->warning('Dear ' . $this->Session->read('Auth.User')['first_name']. ', your provided mobile phone number seems invalid. Please provide a valid Ethiopian mobile number starting with +2519 (Ethiotelecom) or +2517 (Safaricom), followed by 8 digits.');
				return $this->redirect(array('controller' => 'students', 'action' => 'profile'));
			}
			

			if ((ESHE_SSS_COURSE_COMPLETION_CHECKING_ENABLED == 1 || SHOW_ESHE_SSS_COURSE_COMPLETION_REMINDER == 1) && !$isExitExamEligible && isset($studentDetails['Student']['program_id']) && !empty($studentDetails['Student']['program_id'])) {
				
				$allow_registration = true;
				$requirement_satisfied = true;
				$pass_score = DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE;

				$checkForCertificationCourseSetting = array();
				$certification_courses_list = array();
				$number_of_courses_to_complete = DEFAULT_ESHE_SSS_COURSES_TO_COMPLETE;
				$requirement_academic_year_and_semester = 'for the upcoming ' . ESHE_SSS_COURSE_COMPLETION_STARTED_ACADEMIC_YEAR . ' academic year' . '(' . ESHE_SSS_COURSE_COMPLETION_STARTED_ETHIOPIAN_ACADEMIC_YEAR . ' E.C.)';

				$programs_to_enforce_eshe_sss_course_completion = Configure::read('programs_to_enforce_eshe_sss_course_completion');
				$program_types_to_exclude_enforcing_eshe_sss_course_completion = Configure::read('program_types_to_exclude_enforcing_eshe_sss_course_completion');

				if (ESHE_SSS_COURSE_COMPLETION_CHECKING_ENABLED == 1) {

					if (!empty($programs_to_enforce_eshe_sss_course_completion) && in_array($studentDetails['Student']['program_id'], $programs_to_enforce_eshe_sss_course_completion)) {
						$checkForCertificationCourseSetting = ClassRegistry::init('CertificationCourseSetting')->getCertificationCourseSetting($academic_year = $current_acy, $semester = $current_semester, $program_id = (!empty($studentDetails['Student']['program_id']) ? $studentDetails['Student']['program_id'] : PROGRAM_UNDEGRADUATE));
					}

					if (!empty($checkForCertificationCourseSetting['CertificationCourseSetting'])) {

						$certification_course_ids = unserialize($checkForCertificationCourseSetting['CertificationCourseSetting']['certification_course_id']);

						if (!empty($certification_course_ids)) {
							$certification_courses_list = ClassRegistry::init('CertificationCourse')->getCertificationCourses($certification_course_ids, $details = 1);
						}

						//debug($certification_courses_list);

						$number_of_corses_to_complete = (!empty($checkForCertificationCourseSetting['CertificationCourseSetting']['required_courses_count']) ? ((int) $checkForCertificationCourseSetting['CertificationCourseSetting']['required_courses_count']) : 0);

						if (!empty($checkForCertificationCourseSetting['CertificationCourseSetting']['program_id'])) {
							$programs_to_enforce_eshe_sss_course_completion[$checkForCertificationCourseSetting['CertificationCourseSetting']['program_id']] = $checkForCertificationCourseSetting['CertificationCourseSetting']['program_id'];
						}

						if (!empty($checkForCertificationCourseSetting['CertificationCourseSetting']['program_type_ids_to_exclude'])) {
							
							$program_type_ids_to_exclude = unserialize($checkForCertificationCourseSetting['CertificationCourseSetting']['program_type_ids_to_exclude']);

							if (!empty($program_type_ids_to_exclude)) {
								//debug($program_type_ids_to_exclude);
								if (isset($studentDetails['Student']['program_type_id']) && !empty($studentDetails['Student']['program_type_id']) && in_array($studentDetails['Student']['program_type_id'], $program_type_ids_to_exclude)) {
									$number_of_courses_to_complete = 0;
									$programs_to_enforce_eshe_sss_course_completion = array();
									$program_types_to_exclude_enforcing_eshe_sss_course_completion[$studentDetails['Student']['program_type_id']] = $studentDetails['Student']['program_type_id'];
									$allow_registration = true;
								}
							}
						}

						if (isset($checkForCertificationCourseSetting['CertificationCourseSetting']['pass_score']) && !empty($checkForCertificationCourseSetting['CertificationCourseSetting']['pass_score'])) {
							$pass_score = $checkForCertificationCourseSetting['CertificationCourseSetting']['pass_score'];
						}

						//$requirement_academic_year_and_semester = 'for this semester (' . $checkForCertificationCourseSetting['CertificationCourseSetting']['academic_year'] . ', ' . $checkForCertificationCourseSetting['CertificationCourseSetting']['semester'] . ')';

						$registeredForCurrentSemester = $this->__checkTheStudentRegisteredOrAddedForCurrentSemester($this->student_id, $currentAcySemester);

						if ($registeredForCurrentSemester) {
							$currentAcySemesterCustom = $this->AcademicYear->next_acy_and_semester($currentAcySemester);
						} else {
							$currentAcySemesterCustom = $currentAcySemester;
						}

						//debug($currentAcySemesterCustom);

						// get label with dynamic semester lebeling
						$requirement_academic_year_and_semester = $this->__getRequirementLabel($checkForCertificationCourseSetting, $currentAcySemesterCustom);


						if (!empty($pass_score) && !empty($studentDetails['Student']['id']) && !empty($certification_course_ids) && !empty($number_of_courses_to_complete)) {
							$requirement_satisfied = ClassRegistry::init('StudentsCertificationCourse')->checkRequirementSatisfied($studentDetails['Student']['id'],  $number_of_courses_to_complete, $pass_score, $certification_course_ids);
						}

						if (isset($checkForCertificationCourseSetting['CertificationCourseSetting']['hold_registration_for_students']) && !empty($checkForCertificationCourseSetting['CertificationCourseSetting']['hold_registration_for_students'])) {
							$allow_registration = false;
						}
						
					}
				}

				if (!empty($programs_to_enforce_eshe_sss_course_completion) && in_array($studentDetails['Student']['program_id'], $programs_to_enforce_eshe_sss_course_completion)) {
					if (empty($program_types_to_exclude_enforcing_eshe_sss_course_completion) || (!empty($program_types_to_exclude_enforcing_eshe_sss_course_completion) && !in_array($studentDetails['Student']['program_type_id'], $program_types_to_exclude_enforcing_eshe_sss_course_completion))) {

						$dear_name_to_display = !empty($this->Session->read('Auth.User')['first_name']) ? $this->Session->read('Auth.User')['first_name'] : 'students';
						
						/* $eshe_sss_notifications = array(
							"Heads up, $dear_name_to_display!" => 'Don\'t forget to complete at least ' . $number_of_corses_to_complete . ' courses from your Student Success Suite (e-SHE) training! It\'s a mandatory requirement for course registration for the upcoming semester (2018 E.C). If you don\'t complete it, you won\'t be able to register. Do it now to avoid any delays!',
							'Important Reminder!' => 'To ensure a smooth registration process for the upcoming semester (2018 E.C), all students must complete at least ' . DEFAULT_ESHE_SSS_COURSES_TO_COMPLETE . ' courses from Student Success Suite(e-SHE) training!. This is a strict requirement, and you won\'t be able to register for courses for the upcoming semester without it. Finish it up as soon as possible!',
							'Action Required!' => 'Complete at least ' . $number_of_corses_to_complete . ' courses from your Student Success Suite (e-SHE) training! This is essential for upcoming semester registration. No training = no registration for 2018 E.C. Get it done before that!'
						); */

						// for modal notifications, it contains HTML TAGS, DON'T USE THIS WITH FLASH MESSAGES

						$getCertificationCourseDetails = ClassRegistry::init('StudentsCertificationCourse')->getStudentCertificationCourseDetails($studentDetails['Student']['id'],  $number_of_courses_to_complete, $pass_score, $certification_course_ids);
						
						if (!$requirement_satisfied && !$allow_registration) {
							//not satisfied the requirement and setting says hold registration, thus, write a variable in to student session that could be checked before course registration
							$this->Session->write('hold_registration_requirement_not_satisfied', true);
							$this->Session->write('getCertificationCourseDetails', $getCertificationCourseDetails);
						}

						if (!empty($getCertificationCourseDetails)) {

						}

						if (!empty($number_of_corses_to_complete)) {
							$eshe_sss_notifications = array(
								"Heads up, $dear_name_to_display!" => 'Don\'t forget to complete at least ' . ($number_of_corses_to_complete) . ' ' . ($number_of_corses_to_complete == 1 ? 'course' : 'courses') .  ' from your Student Success Suite (e-SHE) training! It\'s a mandatory requirement for course registration ' . $requirement_academic_year_and_semester . '. If you don\'t complete it, you won\'t be able to register. <br><br> Do it now to avoid any delays!',
								'Important Reminder!' => 'To ensure a smooth registration process ' . $requirement_academic_year_and_semester . ', all students must complete at least ' . ($number_of_corses_to_complete) . ' ' . ($number_of_corses_to_complete == 1 ? 'course' : 'courses') .  ' from Student Success Suite (e-SHE) training!. This is a strict requirement, and you won\'t be able to register for courses without it. <br><br>Finish it up as soon as possible!',
								'Action Required!' => 'Complete at least ' . ($number_of_corses_to_complete) . ' ' . ($number_of_corses_to_complete == 1 ? 'course' : 'courses') .  ' from your Student Success Suite (e-SHE) training! This is essential ' . $requirement_academic_year_and_semester . '. <br><br>No training = no registration. Get it done before that!'
							);
						}

						if (!empty($number_of_corses_to_complete) && !empty($checkForCertificationCourseSetting)) {
							$eshe_sss_notifications = array(
								'Action Required!' => 'Dear ' . $dear_name_to_display . ', please complete at least ' . ($number_of_corses_to_complete) . ' ' . ($number_of_corses_to_complete == 1 ? 'course' : 'courses') .  ' from your Student Success Suite (e-SHE) training to register ' . $requirement_academic_year_and_semester . '. <br>'
							);
						}

						if ($requirement_satisfied) {
							$eshe_sss_notifications = array(
								'Success' => 'Dear ' . $dear_name_to_display . ', thank you for completing ' . (isset($getCertificationCourseDetails['tookAllRequiredCoursesWithAllPass']) && $getCertificationCourseDetails['tookAllRequiredCoursesWithAllPass'] ? 'all the required courses' : (isset($getCertificationCourseDetails['completedCourseCount']) && !empty($getCertificationCourseDetails['completedCourseCount']) ? ($getCertificationCourseDetails['completedCourseCount'] . ' ' . ( $getCertificationCourseDetails['completedCourseCount'] == 1 ? 'course' : 'courses' ) ) : 'the the minimum required courses')) . ' from your Student Success Suite (e-SHE) training!<br>'
							);
						}
						
						if (!empty($eshe_sss_notifications)) {

							$randomMessageKey = array_rand($eshe_sss_notifications);
							$randomMessageContent = $eshe_sss_notifications[$randomMessageKey];

							// use this to show notification as flash message
							/* if (!$this->Session->check('Message.flash')) {
								// Check if the notification has already been shown in this session
								if (!$this->Session->check('eshe_sss_notification_shown')) {
									$this->Flash->info("$randomMessageKey, $randomMessageContent");
									// Mark the notification as shown
									$this->Session->write('eshe_sss_notification_shown', 1);
								}
							} */

							//uncomment the above if block and use this to show notification using a modal
							// Check if the notification has already been shown in this session

							$dashboardNotificationModalContent = array(); 

							if (!$this->Session->check('eshe_sss_notification_shown')) {
								$dashboardNotificationModalContent = array(
									'notification_header' => $randomMessageKey, 
									'notification_content' => $eshe_sss_notifications[$randomMessageKey], 
									'notification_footer' => ESHE_SSS_COURSE_COMPLETION_REMINDER_FOOTER, 
									'additional_notification_footer_URL_1' => 'eSHE Portal: &nbsp; <a href="'. ESHE_WEB_URL .'" target="_blank">'. ESHE_WEB_URL .'</a>',
									'additional_notification_footer_URL_2' => '<div class="info-box info-message" style="font-family: \'Times New Roman\', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span>If you’ve forgotten your password, please complete the form at <a href="'. ESHE_PASSWORD_RESET_REQUEST_FORM .'" target="_blank">'. ESHE_PASSWORD_RESET_REQUEST_FORM .'</a>. Once submitted, allow some time and check the <b>OTP tab</b> within your academic profile to retrieve your new password.</div>',
									'required_courses_list' => (!empty($getCertificationCourseDetails) ? $getCertificationCourseDetails : (!empty($certification_courses_list) /* && !$requirement_satisfied */ ? $certification_courses_list : array())),
									'alertHeaderColor' => ($requirement_satisfied ? 'text-black' : 'text-red'),
									'withDetails' => (!empty($getCertificationCourseDetails) ? true : false)
								);
								// Mark the notification as shown
								$this->Session->write('eshe_sss_notification_shown', 1);
							}

							//$this->set(compact('dashboardNotificationModalContent'));
						}

					}

				}
			}
		}

		$calendar = array();

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {

			$dept_col = (!empty($this->department_id) ? $this->department_id : 'pre_' . $this->college_id);
			$program_id = $this->program_id;
			$program_type_id = $this->program_type_id;
			$year_level = '1st';
			$semester = 'I';

			$academicYear =  $currentAcySemester['academic_year'];
			$semester = $currentAcySemester['semester'];

			if (!empty($this->last_section)) {
				//debug($this->last_section);
				if (isset($this->last_section['YearLevel']) && !empty($this->last_section['YearLevel']['name'])) {
					$dept_col = $this->last_section['department_id'];
					$year_level = $this->last_section['YearLevel']['name'];
					$program_id = $this->last_section['program_id'];
					$program_type_id = $this->last_section['program_type_id'];
					$academicYear = $this->last_section['academicyear'];
				} else {
					$dept_col = 'pre_' .$this->last_section['college_id'];
					$year_level = '1st';
					$program_id = $this->last_section['program_id'];
					$program_type_id = $this->last_section['program_type_id'];
					$academicYear = $this->last_section['academicyear'];
				}
				//debug($year_level);
			}

			if ($academicYear == $currentAcySemester['academic_year'] && $semester == $currentAcySemester['semester'] && !empty($this->last_section)) {
				$calendar = ClassRegistry::init('AcademicCalendar')->getAcademicCalenderStudent($dept_col, $year_level, $academicYear, $semester, $program_id, $program_type_id);
			}
			//debug($calendar);
		}

		$this->set(compact('calendar'));

		$this->set(compact('show_fill_alumni_survey_link', 'show_notification_message'));
	}

	public function getProfileNotComplete()
	{
		$this->layout = "ajax";
		$profile_not_buildc = 0;

		/* if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/Students/profile_not_build_list') && ($this->role_id != ROLE_STUDENT)) {
			if (!empty($this->department_ids)) {
				$profile_not_build = ClassRegistry::init('Student')->getProfileNotBuildList(20, $this->department_ids);
			} else if (!empty($this->college_ids)) {
				$profile_not_build = ClassRegistry::init('Student')->getProfileNotBuildList(20, $this->college_ids, 1);
			}
		}
		$profile_not_buildc = count($profile_not_build); */

		if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/Students/profile_not_build_list') && ($this->role_id != ROLE_STUDENT)) {
			if (!empty($this->department_ids)) {
				$profile_not_buildc = ClassRegistry::init('Student')->getProfileNotBuildListCount(DAYS_BACK_PROFILE, $this->department_ids, null, $this->program_ids, $this->program_type_ids);
			} else if (!empty($this->college_ids)) {
				$profile_not_buildc = ClassRegistry::init('Student')->getProfileNotBuildListCount(DAYS_BACK_PROFILE, null , $this->college_ids, $this->program_ids, $this->program_type_ids);
			}
		}

		$this->set(compact('profile_not_buildc'));
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
			//$this->set(compact('calendar'));
		}

		$this->set(compact('calendar'));
		$this->set('_serialize', array('calendar'));
	}

	public function clearanceWithdrawSubRequest()
	{
		$this->layout = "ajax";
		
		$clearance_request = 0;
		$exemption_request = 0;
		$substitution_request = 0;

		//clearances/approve_clearance
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR /* || $this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT */) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/Clearances/approve_clearance')) {
				$current_academic_year_start_date = $this->AcademicYear->get_academicYearBegainingDate($this->AcademicYear->current_academicyear());
				if (!empty($this->college_ids)) {
					$clearance_request = ClassRegistry::init('Clearance')->count_clearnce_request(null, $this->college_ids, DAYS_BACK_CLEARANCE, $current_academic_year_start_date);
				} else if (!empty($this->department_ids)) {
					$clearance_request = ClassRegistry::init('Clearance')->count_clearnce_request($this->department_ids, null, DAYS_BACK_CLEARANCE, $current_academic_year_start_date);
				}
			}
		}

		//courseExemptions/list_exemption_request
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseExemptions/list_exemption_request')) {
				if (!empty($this->college_ids)) {
					$exemption_request = ClassRegistry::init('CourseExemption')->count_exemption_request($this->role_id, null, $this->college_ids);
				} else if (!empty($this->department_ids)) {
					$exemption_request = ClassRegistry::init('CourseExemption')->count_exemption_request($this->role_id, $this->department_ids, null);
				}
			}
		}

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseExemptions/list_exemption_request')) {
				if (!empty($this->department_id)) {
					$exemption_request = ClassRegistry::init('CourseExemption')->count_exemption_request($this->role_id, $this->department_id, null);
				}
			}
		}

		/* if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE ) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseExemptions/list_exemption_request')) {
				if (!empty($this->college_id)) {
					$exemption_request = ClassRegistry::init('CourseExemption')->count_exemption_request($this->role_id, null, $this->college_id);
				}
			}
		} */

		//substitution
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseSubstitutionRequests/approve_substitution')) {
				$substitution_request = ClassRegistry::init('CourseSubstitutionRequest')->count_substitution_request($this->department_id);
			}
		}


		$this->set(compact('clearance_request', 'substitution_request', 'exemption_request'));

		$this->set('_serialize', array('clearance_request', 'substitution_request', 'exemption_request'));
	}

	public function addDropRequestList()
	{
		//course_drops/approve_drops
		$this->layout = "ajax";

		$drop_request = 0;
		$drop_request_dpt = 0;
		$forced_drops = 0;
		$add_request_dpt = 0;
		$add_request = 0;

		$current_acy = $this->AcademicYear->current_academicyear();

		if (is_numeric(ACY_BACK_COURSE_ADD_DROP_APPROVAL) && ACY_BACK_COURSE_ADD_DROP_APPROVAL) {
			$ac_yearsAddDrop = $this->AcademicYear->academicYearInArray(((explode('/', $current_acy)[0]) - ACY_BACK_COURSE_ADD_DROP_APPROVAL), (explode('/', $current_acy)[0]));
		} else {
			$ac_yearsAddDrop[$current_acy] = $current_acy;
		}
		
		$ac_yearsAddDrop = array_keys($ac_yearsAddDrop);

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE || $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR ) {

			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseDrops/approve_drops')) {
				if ($this->role_id == ROLE_REGISTRAR) {
					if (!empty($this->department_ids)) {
						$drop_request = ClassRegistry::init('CourseDrop')->count_drop_request($this->department_ids);
					} else if (!empty($this->college_ids)) {
						$drop_request = ClassRegistry::init('CourseDrop')->count_drop_request(null, 1, $this->college_ids);
					}
				} else {
					if ($this->role_id == ROLE_DEPARTMENT) {
						$drop_request_dpt = ClassRegistry::init('CourseDrop')->count_drop_request($this->department_id, 2);
					} else if ($this->role_id == ROLE_COLLEGE) {
						$drop_request = ClassRegistry::init('CourseDrop')->count_drop_request(null, 3, $this->college_id);
					}
				}
			}

			if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR ) {
				if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseDrops/forced_drop')) {
					
					if (!empty($this->department_ids)) {
						$forced_drops = ClassRegistry::init('CourseDrop')->list_of_students_need_force_drop($this->department_ids, null, $this->program_ids, $this->program_type_ids, $current_acy);
					} else if (!empty($this->college_ids)) {
						$forced_drops = ClassRegistry::init('CourseDrop')->list_of_students_need_force_drop(null, $this->college_ids, $this->program_ids, $this->program_type_ids, $current_acy, null, 1);
					}
					
					if (count($forced_drops) && $forced_drops['count'] != 0) {
						//$forced_drops = count($forced_drops) - 1;
						$forced_drops = $forced_drops['count'];
					} else {
						$forced_drops = 0;
					}
				}
			}

			//course_adds/approve_adds
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseAdds/approve_adds')) {
				if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
					if (!empty($this->department_ids)) {
						$add_request = ClassRegistry::init('CourseAdd')->count_add_request($this->department_ids, 1, null, $this->program_ids, $this->program_type_ids, $ac_yearsAddDrop);
					} else if (!empty($this->college_ids)) {
						$add_request = ClassRegistry::init('CourseAdd')->count_add_request(null, 1, $this->college_ids, $this->program_ids, $this->program_type_ids, $ac_yearsAddDrop);
					}
				} else {
					if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
						$add_request_dpt = ClassRegistry::init('CourseAdd')->count_add_request($this->department_id, 2, null, null, null, $ac_yearsAddDrop);
					} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
						$add_request = ClassRegistry::init('CourseAdd')->count_add_request(null, 3, $this->college_id, null, null, $ac_yearsAddDrop);
					}
				}
			}
		}

		$this->set(compact('drop_request', 'drop_request_dpt', 'add_request', 'add_request_dpt', 'forced_drops'));

		$this->set('_serialize', array('drop_request', 'drop_request_dpt', 'add_request', 'add_request_dpt', 'forced_drops'));
		
	}

	// Introduced for the purpose of optimization, the login process is becoming slow becuse of too many queries
	public function getMessageAjax()
	{
		$this->layout = 'ajax';
		$auto_messages = ClassRegistry::init('AutoMessage')->getMessages($this->Auth->user('id'));
		$this->set('auto_messages', $auto_messages);
		$this->set('_serialize', array('auto_messages'));
	}

	public function getRankAjax()
	{
		$this->layout = 'ajax';
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
			$rank = ClassRegistry::init('StudentExamStatus')->displayStudentRank($this->student_id, $this->AcademicYear->current_academicyear());
			$this->set('rank', $rank);
			$this->set('_serialize', array('rank'));
		}
	}

	public function getStudentAssignedDormitory()
	{
		$this->layout = 'ajax';
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
			$dormAssignedStudent = ClassRegistry::init('DormitoryAssignment')->getStudentAssignedDormitory($this->student_id);
			$this->set('dormAssignedStudent', $dormAssignedStudent);
			$this->set('_serialize', array('dormAssignedStudent'));
		}
	}

	public function getCourseSchedule()
	{
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
			$student_course_schedules = array();
			// $student_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForStudent($this->student_id, $this->AcademicYear->current_academicyear());
			$this->set(compact('student_course_schedules'));
			$this->set('_serialize', array('student_course_schedules'));
		} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_INSTRUCTOR) {
			$instructor_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForInstructor($this->Auth->user('id'), $this->role_id);
			$this->set(compact('instructor_course_schedules'));
			$this->set('_serialize', array('instructor_course_schedules'));
		}
	}

	public function getApprovalRejectGrade()
	{

		$this->layout = 'ajax';

		$current_acy = $this->AcademicYear->current_academicyear();

		if (is_numeric(ACY_BACK_GRADE_APPROVAL_DASHBOARD) && ACY_BACK_GRADE_APPROVAL_DASHBOARD) {
			$ac_years = $this->AcademicYear->academicYearInArray(((explode('/', $current_acy)[0])  - ACY_BACK_GRADE_APPROVAL_DASHBOARD), (explode('/', $current_acy)[0]));
		} else {
			$ac_years[$current_acy] = $current_acy;
		}
		
		$ac_years = array_keys($ac_years);

		//If the user has department grade approval privilage
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGrades/approve_non_freshman_grade_submission')) {
				$courses_for_dpt_approvals = ClassRegistry::init('ExamGrade')->getRejectedOrNonApprovedPublishedCourseList2($this->department_id, '', '', array(), array(), array(), $ac_years, $this->role_id);
				//debug($courses_for_dpt_approvals);
				$this->set('courses_for_dpt_approvals', $courses_for_dpt_approvals);
				$this->set('_serialize', array('courses_for_dpt_approvals'));
			}
		}

		//If the user has freshman program grade approval privilage
		//if (/* $this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT ||  */ $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
			/* if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGrades/approve_freshman_grade_submission')) {
				//$courses_for_freshman_approvals = ClassRegistry::init('ExamGrade')->getRejectedOrNonApprovedPublishedCourseList($this->department_id, 0);
				$courses_for_freshman_approvals = ClassRegistry::init('ExamGrade')->getRejectedOrNonApprovedPublishedCourseList2($this->college_id, '', '', array(), array(), array(), $ac_years, $this->role_id, 1);
				$this->set('courses_for_freshman_approvals', $courses_for_freshman_approvals);
				$this->set('_serialize', array('courses_for_freshman_approvals'));
			}
		} */

		//If the user has regustrar grade confirmation privilage
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGrades/confirm_grade_submission')) {
				$courses_for_registrar_approval = ClassRegistry::init('ExamGrade')->getRegistrarNonApprovedCoursesList2($this->department_ids, $this->college_ids, '', '', $this->program_ids, $this->program_type_ids, $ac_years);
				$this->set('courses_for_registrar_approval', $courses_for_registrar_approval);
				$this->set('_serialize', array('courses_for_registrar_approval'));
			}
		}
	}

	public function getApprovalRejectGradeChange()
	{
		$this->layout = 'ajax';

		$exam_grade_change_requests = 0;
		$makeup_exam_grades = 0;
		$rejected_makeup_exams = 0;
		$rejected_supplementary_exams = 0;
		$exam_grade_changes_for_college_approval = 0;
		$reg_exam_grade_change_requests = 0;
		$reg_makeup_exam_grades = 0;
		$reg_supplementary_exam_grades = 0;
		$fm_exam_grade_change_requests = 0; 
		$fm_makeup_exam_grades = 0;
		$fm_rejected_makeup_exams = 0;
		$fm_rejected_supplementary_exams = 0;

		$departmentIDs =  array();

		if (!empty($this->department_ids)) {
			$departmentIDs = $this->department_ids;
		}

		//If the user has college grade change approval privilage
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {

			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_college_grade_change')) {
				debug($this->college_id);

				$exam_grade_changes_for_college_approval = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForCollegeApproval($this->college_id);
				$exam_grade_changes_for_college_approval_sum = 0;
				
				if (!empty($exam_grade_changes_for_college_approval)) {
					foreach ($exam_grade_changes_for_college_approval as $key => $value) {
						foreach ($value as $key2 => $value2) {
							foreach ($value2 as $key3 => $value3) {
								$exam_grade_changes_for_college_approval_sum += count($value3);
							}
						}
					}
				}

				$exam_grade_changes_for_college_approval = $exam_grade_changes_for_college_approval_sum;
			}
		}

		//If the user has department grade change approval privilage
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {

			$departmentIDs = array();

			if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				$departmentIDs[] = $this->department_id;
			} else {
				$departmentIDs = $this->department_ids;
			}
			
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_department_grade_change')) {
				
				if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
					$exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->department_id, 1, $departmentIDs);
					$makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 0, 1, $departmentIDs);
					$rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 1, 1, $departmentIDs);
					$rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->department_id, 1, $departmentIDs);
				} else {
					$exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->college_id, 0, $departmentIDs);
					$makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 0, 0, $departmentIDs);
					$rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 1, 0, $departmentIDs);
					$rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->college_id, 0, $departmentIDs);
				}
				
				$exam_grade_change_requests_sum = 0;

				if (!empty($exam_grade_change_requests)) {
					foreach ($exam_grade_change_requests as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$exam_grade_change_requests_sum += count($value2);
						}
					}
				}

				$exam_grade_change_requests = $exam_grade_change_requests_sum;
				//debug($exam_grade_change_requests);

				//$makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 0, 1, $departmentIDs);
				$makeup_exam_grades_sum = 0;

				if (!empty($makeup_exam_grades)) {
					foreach ($makeup_exam_grades as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$makeup_exam_grades_sum += count($value2);
						}
					}
				}

				$makeup_exam_grades = $makeup_exam_grades_sum;

				//$rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 1, 1, $departmentIDs);
				$rejected_makeup_exams_sum = 0;

				if (!empty($rejected_makeup_exams)) {
					foreach ($rejected_makeup_exams as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$rejected_makeup_exams_sum += count($value2);
						}
					}
				}

				$rejected_makeup_exams = $rejected_makeup_exams_sum;

				//$rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->department_id, 1, $departmentIDs);
				$rejected_supplementary_exams_sum = 0;

				if (!empty($rejected_supplementary_exams)) {
					foreach ($rejected_supplementary_exams as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$rejected_supplementary_exams_sum += count($value2);
						}
					}
				}

				$rejected_supplementary_exams = $rejected_supplementary_exams_sum;
			}
		}

		//If the user has freshman grade change approval privilage
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
			
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_freshman_grade_change')) {
				
				if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
					$fm_exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->department_id, 1, $departmentIDs);
					$fm_makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 0, 1, $departmentIDs);
					$fm_rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->department_id, 1, 1, $departmentIDs);
					$fm_rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->department_id, 1, $departmentIDs);
				} else {
					$fm_exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->college_id, 0, $departmentIDs);
					$fm_makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 0, 0, $departmentIDs);
					$fm_rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 1, 0, $departmentIDs);
					$fm_rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->college_id, 0, $departmentIDs);
				}

				//$fm_exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForDepartmentApproval($this->college_id, 0, $departmentIDs);
				$fm_exam_grade_change_requests_sum = 0;

				if (!empty($fm_exam_grade_change_requests)) {
					foreach ($fm_exam_grade_change_requests as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$fm_exam_grade_change_requests_sum += count($value2);
						}
					}
				}

				$fm_exam_grade_change_requests = $fm_exam_grade_change_requests_sum;
				
				//$fm_makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 0, 0, $departmentIDs);
				$fm_makeup_exam_grades_sum = 0;
				
				if (!empty($fm_makeup_exam_grades)) {
					foreach ($fm_makeup_exam_grades as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$fm_makeup_exam_grades_sum += count($value2);
						}
					}
				}

				$fm_makeup_exam_grades = $fm_makeup_exam_grades_sum;
				
				//$fm_rejected_makeup_exams = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForDepartmentApproval($this->college_id, 1, 0, $departmentIDs);
				$fm_rejected_makeup_exams_sum = 0;
				
				if (!empty($fm_rejected_makeup_exams)) {
					foreach ($fm_rejected_makeup_exams as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$fm_rejected_makeup_exams_sum += count($value2);
						}
					}
				}

				$fm_rejected_makeup_exams = $fm_rejected_makeup_exams_sum;
				
				//$fm_rejected_supplementary_exams = ClassRegistry::init('ExamGradeChange')->getMakeupGradesAskedByDepartmentRejectedByRegistrar($this->college_id, 0, $departmentIDs);
				$fm_rejected_supplementary_exams_sum = 0;
				
				if (!empty($fm_rejected_supplementary_exams)) {
					foreach ($fm_rejected_supplementary_exams as $key => $value) {
						foreach ($value as $key2 => $value2) {
							$fm_rejected_supplementary_exams_sum += count($value2);
						}
					}
				}

				$fm_rejected_supplementary_exams = $fm_rejected_supplementary_exams_sum;
			}
		}

		//If the user has registrar grade change approval privilage

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {

			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/ExamGradeChanges/manage_registrar_grade_change')) {

				$reg_exam_grade_change_requests = ClassRegistry::init('ExamGradeChange')->getListOfGradeChangeForRegistrarApproval($this->department_ids, $this->college_ids, $this->program_ids, $this->program_type_ids);
				$reg_exam_grade_change_requests_sum = 0;

				if (!empty($reg_exam_grade_change_requests)) {
					foreach ($reg_exam_grade_change_requests as $key => $value) {
						foreach ($value as $key2 => $value2) {
							foreach ($value2 as $key3 => $value3) {
								foreach ($value3 as $key4 => $value4) {
									$reg_exam_grade_change_requests_sum += count($value4);
								}
							}
						}
					}
				}

				$reg_exam_grade_change_requests = $reg_exam_grade_change_requests_sum;

				$reg_makeup_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeForRegistrarApproval($this->department_ids, $this->college_ids, $this->program_ids, $this->program_type_ids);
				$reg_makeup_exam_grades_sum = 0;

				if (!empty($reg_makeup_exam_grades)) {
					foreach ($reg_makeup_exam_grades as $key => $value) {
						foreach ($value as $key2 => $value2) {
							foreach ($value2 as $key3 => $value3) {
								foreach ($value3 as $key4 => $value4) {
									$reg_makeup_exam_grades_sum += count($value4);
								}
							}
						}
					}
				}

				$reg_makeup_exam_grades = $reg_makeup_exam_grades_sum;

				$reg_supplementary_exam_grades = ClassRegistry::init('ExamGradeChange')->getListOfMakeupGradeChangeByDepartmentForRegistrarApproval($this->department_ids, $this->college_ids,  $this->program_ids, $this->program_type_ids);
				$reg_supplementary_exam_grades_sum = 0;
				
				if (!empty($reg_supplementary_exam_grades)) {
					foreach ($reg_supplementary_exam_grades as $key => $value) {
						foreach ($value as $key2 => $value2) {
							foreach ($value2 as $key3 => $value3) {
								foreach ($value3 as $key4 => $value4) {
									$reg_supplementary_exam_grades_sum += count($value4);
								}
							}
						}
					}
				}

				$reg_supplementary_exam_grades = $reg_supplementary_exam_grades_sum;

			}
		}

		$this->set(compact(
			'exam_grade_change_requests', 
			'makeup_exam_grades', 
			'rejected_makeup_exams',
			'rejected_supplementary_exams', 
			'exam_grade_changes_for_college_approval',
			'reg_exam_grade_change_requests', 
			'reg_makeup_exam_grades', 
			'reg_supplementary_exam_grades',
			'fm_exam_grade_change_requests', 
			'fm_makeup_exam_grades',
			'fm_rejected_makeup_exams', 
			'fm_rejected_supplementary_exams'
		));

		$this->set('_serialize', array(
			'exam_grade_change_requests', 
			'makeup_exam_grades', 
			'rejected_makeup_exams',
			'rejected_supplementary_exams', 
			'exam_grade_changes_for_college_approval',
			'reg_exam_grade_change_requests', 
			'reg_makeup_exam_grades', 
			'reg_supplementary_exam_grades',
			'fm_exam_grade_change_requests', 
			'fm_makeup_exam_grades',
			'fm_rejected_makeup_exams', 
			'fm_rejected_supplementary_exams'
		));
	}

	public function getBackupAccountRequest()
	{
		$this->layout = 'ajax';

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_SYSADMIN) {
			
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/Backups/index')) {
				$latest_backups = ClassRegistry::init('Backup')->getLatestBackups(3);
				$this->set(compact('latest_backups'));
			}

			$tasks_for_confirmation = ClassRegistry::init('Vote')->getListOfTaskForConfirmation($this->Auth->user('id'));
			$confirmed_tasks = ClassRegistry::init('Vote')->getListOfOtherAdminTasks($this->Auth->user('id'));
			
			$confirmed_taskss = count($confirmed_tasks);
			$password_reset_confirmation_request = 0;
			$admin_cancelation_confirmation_request = 0;
			$admin_assignment_confirmation_request = 0;
			$role_change_confirmation_request = 0;
			$deactivation_confirmation_request = 0;
			$activation_confirmation_request = 0;

			if (!empty($tasks_for_confirmation)) {
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
			}

			$this->set(compact(
				'password_reset_confirmation_request', 
				'admin_cancelation_confirmation_request', 
				'admin_assignment_confirmation_request', 
				'confirmed_taskss', 'confirmed_tasks', 
				'role_change_confirmation_request', 
				'deactivation_confirmation_request', 
				'activation_confirmation_request'
			));
		

			$this->set('_serialize', array(
				'password_reset_confirmation_request', 
				'admin_cancelation_confirmation_request', 
				'admin_assignment_confirmation_request', 
				'confirmed_taskss', 
				'role_change_confirmation_request', 
				'deactivation_confirmation_request',
				'activation_confirmation_request', 
				'latest_backups'
			));
		}
	}

	public function courseSchedule()
	{
		if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
			/* $student_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForStudent($this->student_id);
			$this->set(compact('section_course_schedule', 'starting_and_ending_hour'));
			$this->set('_serialize', array('section_course_schedule', 'starting_and_ending_hour')); */
		} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_INSTRUCTOR) {
			$instructor_course_schedules = ClassRegistry::init('CourseSchedule')->getCourseSchedulesForInstructor($this->Auth->user('id'), $this->role_id);
			$this->set(compact('instructor_course_schedules'));
			$this->set('_serialize', array('instructor_course_schedules'));
		}
	}

	public function disptachedAssignedCourseList()
	{
		$this->layout = "ajax";

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
			//If the user has instructor assignment
			if ($this->MenuOptimized->check($this->Auth->user(), 'controllers/CourseInstructorAssignments/assign_course_instructor')) {
				$dispatched_course_not_assigned = ClassRegistry::init('CourseInstructorAssignment')->getDisptachedCoursesNotAssigned($this->department_id);
				$dispatched_course_list = ClassRegistry::init('CourseInstructorAssignment')->getDisptachedCoursesForNotification($this->department_id);
				
				$this->set(compact('dispatched_course_not_assigned', 'dispatched_course_list'));

				$this->set('_serialize', array('dispatched_course_list', 'dispatched_course_not_assigned'));
			}
		}
	}

	public function view_logs()
	{
		$logs  = array();

		if (!empty($this->request->data)) {
			// $this->Model->findUserActions(301, array('fields' => array('id','model'),'model' => 'BookTest');
			$params = array();

			$params['fields'] = array('id', 'model', 'user_id', 'ip', 'foreign_key',  'description',  'action', 'change', 'created');

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

			$logs = ClassRegistry::init('User')->getUserLogDetail($this->Auth->user('id'), $params);
		}

		$this->set(compact('logs'));
	}


	/**
	 * Return a human-friendly label for academic year/semester requirement.
	 *
	 * @param array $certificationSetting CertificationCourseSetting record
	 * @param array $currentAcySemester Current academic year/semester from AcademicYearComponent
	 * @return string
	 */
	private function __getRequirementLabel($certificationSetting, $currentAcySemester) 
	{
		
		$settingAcademicYear = $certificationSetting['CertificationCourseSetting']['academic_year']; 
		$settingSemester = $certificationSetting['CertificationCourseSetting']['semester'];      

		$currentAcademicYear = $currentAcySemester['academic_year']; 
		$currentSemester = $currentAcySemester['semester']; 

		// Map semester codes to human-friendly labels
		$semesterMap = array(
			'I'   => '1st semester',
			'II'  => '2nd semester',
			'III' => '3rd semester'
		);

		// Map semester codes to numeric order
		$semesterOrder = array(
			'I'   => 1,
			'II'  => 2,
			'III' => 3
		);

		$humanSettingSemester = isset($semesterMap[$settingSemester]) ? $semesterMap[$settingSemester] : $settingSemester;
		$humanCurrentSemester = isset($semesterMap[$currentSemester]) ? $semesterMap[$currentSemester] : $currentSemester;

		// Parse academic years
		$settingYearStart = (int)explode('/', $settingAcademicYear)[0];
		$currentYearStart = (int)explode('/', $currentAcademicYear)[0];

		$settingSemesterOrder = isset($semesterOrder[$settingSemester]) ? $semesterOrder[$settingSemester] : 0;
		$currentSemesterOrder = isset($semesterOrder[$currentSemester]) ? $semesterOrder[$currentSemester] : 0;

		$labelPrefix = 'for this semester';

		// check if setting matches the next semester exactly
		$next = $this->AcademicYear->next_acy_and_semester($currentAcySemester);
		$nextAcademicYear = $next['academic_year'];
		$nextSemester = $next['semester'];

		$humanNextSemester = isset($semesterMap[$nextSemester]) ? $semesterMap[$nextSemester] : $nextSemester;

		if ($settingAcademicYear === $nextAcademicYear && $settingSemester === $nextSemester) {
			$labelPrefix = 'for the next semester';
			$academicYearForDisplay = $nextAcademicYear;
			$semesterForDisplay = $humanNextSemester;
		} else {
			// Past academic year
			if ($settingYearStart < $currentYearStart) {
				$labelPrefix = 'for the previous semester';
				$academicYearForDisplay = $settingAcademicYear;
				$semesterForDisplay = $humanSettingSemester;
			} else {
				// Current or future academic year
				if ($settingSemesterOrder === $currentSemesterOrder) {
					$labelPrefix = 'for this semester';
					$academicYearForDisplay = $settingAcademicYear;
					$semesterForDisplay = $humanSettingSemester;
				} else {
					$labelPrefix = 'for the next semester';
					$academicYearForDisplay = $currentAcademicYear;
					$semesterForDisplay = $humanCurrentSemester;
				}
			}
		}

		return $labelPrefix . ' (' . $academicYearForDisplay  . ', ' . $semesterForDisplay . ')';
	}


	/**
	 * Check if a student is registered or has a confirmed course add
	 * for the current academic year and semester.
	 *
	 * @param int   $student_id
	 * @param array $currentAcySemester ['academic_year' => '2025/26', 'semester' => 'I']
	 * @return bool
	 */
	private function __checkTheStudentRegisteredOrAddedForCurrentSemester($student_id, $currentAcySemester) 
	{

		$academicYear = $currentAcySemester['academic_year'];
		$semester = $currentAcySemester['semester'];

		// Check course registrations
		$registered = ClassRegistry::init('CourseRegistration')->find('count', array(
			'conditions' => array(
				'CourseRegistration.student_id' => $student_id,
				'CourseRegistration.academic_year' => $academicYear,
				'CourseRegistration.semester' => $semester
			),
		));

		if ($registered > 0) {
			return true;
		}

		// Check confirmed course adds
		$added = ClassRegistry::init('CourseAdd')->find('count', array(
			'conditions' => array(
				'CourseAdd.student_id' => $student_id,
				'CourseAdd.academic_year' => $academicYear,
				'CourseAdd.semester' => $semester,
				'CourseAdd.registrar_confirmation' => 1
			),
		));

		if ($added > 0) {
			return true;
		}

		return false;
	}

}
