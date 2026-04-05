<?php
// This file contains configuration parameters of the smis application that  are common to all installations.  */

//----------------------------- BACKUP PATH -------------------------------------------------
//Wonde
Configure::write('Utility.backupPath', '/home/wonde/code/yekatit/sisupdate/app/backup/');
Configure::write('Utility.cache', '/home/wonde/code/yekatit/sisupdate/app/tmp/cache');
Configure::write('Utility.command',"/home/wonde/code/yekatit/sisupdate/lib/Cake/Console/cake -app /home/wonde/code/yekatit/sisupdate/app backup");

/*
	The following equivalentACL is used to automatically give privilege for false controllers index or other action if any of sub menu privilege is enabled. 
	Even if it is primarily designed for false controllers, it can be used for other controllers. 
	The checking is taken place @ cake/libs/controller/components/acl.php line 268 - 310 (DbAcl class check() function). 
	Make sure that you use capitalized controller name.
*/

// To give privilege if any of the given controller action is enabled, use     
// 		Controller/*    syntax
// To give privilege if only specific action is granted, use
// 		Controller/action     syntax

$equivalentACL =  array(
	'Graduation/index' => array(
		'GraduationStatuses/*',
		'GraduateLists/*',
		'SenateLists/*',
		'Certificates/*',
		'GraduationLetters/*',
		'GraduationCertificates/*',
		'GraduationWorks/*',
		'ExamGrades/student_copy'
	),
	'Certificates/index' => array(
		'ExamGrades/student_copy'
	),
	'Placement/index' => array(
		//'AcceptedStudents/*',
		'ReservedPlaces/*',
		'PlacementsResultsCriterias/*',
		/* 'Students/index',
		'Students/admit_all',
		'Students/admit', */
		'Preferences/*',
		'PreferenceDeadlines/*',
		'Sections/*',
		'ParticipatingDepartments/*',
		'Quotas/*',
		'acceptedStudents/index',
		'acceptedStudents/add',
		'acceptedStudents/generate',
		'acceptedStudents/export_print_students_number',
		'acceptedStudents/import_newly_students',
		'Students/index',
		'Students/admit_all',
		'Students/admit'
	),
	'AcceptedStudents/index' => array(
		'Students/index',
		'Students/admit_all',
		'Students/admit'
	),
	'Dormitory/index' => array(
		'DormitoryBlocks/*',
		'DormitoryAssignments/*'
	),
	'MealService/index' => array(
		'MealHalls/*',
		'MealHallAssignments/*',
		'MealAttendances/*',
		'MealTypes/*'
	),
	'Transfers/index' => array(
		'ProgramTypeTransfers/*',
		'DepartmentTransfers/*'
	),
	/// false controller of schedule 
	'Schedule/index' => array(
		'CourseSchedule/*',
		'ExamSchedule/*',
		'ClassRoomBlocks/*',
		'ScheduleSetting/*'
	),
	'Evalution/index' => array(
		'InstructorEvalutionQuestions/*',
		'InstructorEvalutionSettings/*',
		'ColleagueEvalutionRates/*',
		'StudentEvalutionRates/*',
		'ContinuousAssessment/*'
	),
	'CourseSchedule/index' => array(
		'CourseConstraint/*',
		'PublishedCourses/add_course_session'
	),
	'CourseConstraint/index' => array(
		'ClassPeriodCourseConstraints/*',
		'ClassRoomClassPeriodConstraints/*',
		'ClassRoomCourseConstraints/*',
		'InstructorClassPeriodCourseConstraints/*'
	),
	'ExamSchedule/index' => array(
	    'ExamSchedules/*',
	    'ExamPeriods/*',
	    'MergedSectionsExams/*',
	    'ExamExcludedDateAndSessions/*',
	    'ExcludedPublishedCourseExams/*',
	    'ExamRoomNumberOfInvigilators/*',
	    'StaffForExams/*',
	    'SectionSplitForExams/*',
	    'ExamConstraint/*'
	),
	'ExamConstraint/index' => array(
	    'CourseExamGapConstraints/*',
	    'CourseExamConstraints/*',
	    'ExamRoomConstraints/*',
	    'ExamRoomCourseConstraints/*',
	    'InstructorExamExcludeDateConstraints/*',
	    'InstructorNumberOfExamConstraints/*',
	),
	'ScheduleSetting/index' => array(
	    'ClassPeriods/*',
	    'PeriodSettings/*',
	),
	'Registrations/index' => array(
		'CourseAdds/*',
		'CourseExemptions/*',
		'CourseDrops/*',
		'CourseSubstitutionRequests/*',
		'CourseRegistrations/*'
	),
	'Security/index' => array(
		'Users/*',
		'Logs/*',
		'Securitysettings/*'
	),
	'MainDatas/index' => array(
		'Universities/*',
		'Titles/*',
		'Positions/*',
		'Countries/*',
		'Cities/*'
	),
	'Grades/index' => array(
		'ExamGrades/*',
		'ExamTypes/*',
		'GradeSettings/*',
		'Attendances/*',
		'ExamResults/*',
		'MakeupExams/*',
		'ExamGradeChanges/department_makeup_exam_result',
		'ExamGradeChanges/manage_department_grade_change',
		'ExamGradeChanges/manage_college_grade_change',
		'ExamGradeChanges/freshman_makeup_exam_result',
		'ExamGradeChanges/manage_freshman_grade_change',
	),
	'GradeSettings/index' => array(
		'GradeScales/*',
		'Colleges/delegate_scale'
	),
	'Curriculums/index' => array(
		'PublishedCourses/*',
		'Courses/*',
		'CourseInstructorAssignments/*',
		'EquivalentCourses/*',
		'DepartmentStudyPrograms/*',
		'StudyPrograms/*',
	),
	'Clearances/index' => array(
		'TakenProperties/*'
	),
	'CostShares/index' => array(
		'Payments/*',
		'ApplicablePayments/*',
		'CostSharingPayments/*',
	),
	'HealthService/index' => array(
		'MedicalHistories/*',
		'Students/manage_student_medical_card_number',
	),
	'Billings/index' => array(
		//'FeeSettings/*',
	),
);

Configure::write('ACL.equivalentACL', $equivalentACL);

/*
Excluded controllers from the ACL management.
	It will be used when:
		1. Controller is a false controller with out any action
		2. Controller on which any user should not has any access right. E.G. Role management
*/

//	To exclude one action from one controller, 
//		use     Controller/action     syntax
//	To exclude controller, 
//		use     Controller    syntax
//	To exclude the given action from all controllers, 
// 		use     */action    syntax

$excludedACL = array(
    'Dashboard',
    'Security',
    'Acls',
    'PlacementSettings',
    'Schedule',
    'Evalution',
    //'ExamSchedule',
    'CourseSchedule',
    'Transfers',
    'MealService',
    'Dormitory',
    'Placement',
    'Notes',
    'Departments/get_department_combo',
	'Departments/index',
    'CourseDrops/list_students',
    'CourseDrops/edit',
    'CourseDrops/view',
    'CourseDrops/delete',
    'CourseAdds/edit',
    'CourseAdds/view',
    'CourseAdds/delete',
    'CourseAdds/invalid',
    'CourseAdds/search',
    'CourseAdds/get_published_add_courses',
    'TypeCredits',
    'Registrations',
    'PublishedCourses/print_published_pdf',
    'PublishedCourses/export_published_xls',
    'PublishedCourses/get_year_level',
    'PublishedCourses/get_course_type_session',
    'PublishedCourses/getPublishedCoursesForSplit',
    'PublishedCourses/getPublishedCoursesForExam',
    'PublishedCourses/get_course_grade_scale',
    'PublishedCourses/getPublishedCourses',
    'PublishedCourses/selectedPublishedCourses',
    'PublishedCourses/selectedPublishedCourses',
    'PublishedCourses/get_course_published_for_section',
    'PublishedCourses/publisheForUnassigned',
    'PublishedCourses/getPublishedCoursesForExamForSplit',
    'PublishedCourses/delete',
    'PublishedCourses/view',
    'PublishedCourses/edit',
	'Curriculums/get_courses',
    'Curriculums/get_curriculums',
    'Curriculums/get_curriculum_combo',
    'Curriculums/search',
	'Curriculums/approve', 
	'Curriculums/lock',
	'Curriculums/activate',
	'Curriculums/add_departmernt_study_program_for_curriculum',
	'Sections/export',
	'Sections/edit',
	'Certificates/*',
	'Sections/section_move_update',
	'Sections/section_move_update',
	'Sections/view_pdf',
	'Sections/deleteStudentforThisSection',
	'Sections/move',
	'Sections/upgrade_selected_student_section',
	'AcademicCalendars/index',
	'AcademicStands/index',
	'CourseDrops/index',
	'SenateLists/index',
	'SenateLists/search',
	'GraduateLists/index',
	'GraduateLists/search',
	'GraduateLists/edit',
	'AcademicRules/index',
	'StudentStatusPatterns/index',
	'Reports/index',
	'Titles/index',
	'UnschedulePublishedCourses/*',
	'ClassRoomBlocks/get_class_room_block_exam_rooms',
	'Sections/add_student_section',
	'Sections/add_student_section_update',
	'Sections/get_sections_by_program',
	'Sections/get_sections_by_dept',
	'Sections/get_sections_by_academic_year',
	'Sections/get_sections_of_college',
	'Sections/get_modal_box',
	'Sections/get_sections_by_program_and_dept',
	'Sections/get_year_level',
	'Sections/get_section_students',
	'Media',
   	'Roles/edit',
    'Weblinks',
    'Books',
    'Journals',
    'Attachments',
    'Contacts',
    'XmlRpc',
    'Pages',
    'Offers',
    'Students/search',
    'Students/student_lists',
    'Students/get_course_registered_and_add',
    'Students/get_modal_box',
    'Students/ajax_get_department',
    'Students/delete',
    'Students/get_regions',
    'Students/get_cities',
    'Students/ajax_update',
    'Students/add',
    'GradesRegistrationsDates',
    'Departments/get_department_combo',
    'Courses/search',
    'StudentsDepartments',
    'PasswordChanageVotes', // is used by you (haile)?
    'Programs',
    'HighSchoolEducationBackgrounds',
    'HigherEducationBackgrounds',
    'Prerequisites',
    'GradeScalePublishedCourses',
    'Dismissals',
    'Withdrawals',
    'Webservices',
    'AutoMessages',
    'MainDatas',
    'ProgramTypes/view',
    'ProgramTypes/edit',
    'ProgramTypes/delete',
    'ProgramTypes/add',
    'ProgramTypes/get_program_types',
    'Staffs/get_instructor_combo',
    'CourseInstructorAssignments/get_department',
    'CourseInstructorAssignments/assign_instructor_update',
    'CourseInstructorAssignments/reset_department',
    'CourseInstructorAssignments/get_assigned_courses_of_instructor_by_section_for_combo',
    'CourseInstructorAssignments/assign_instructor',
    'CourseInstructorAssignments/get_course_instructor_detail',
    'CourseInstructorAssignments/edit',
    'CourseInstructorAssignments/add',
    'CourseSubstitutionRequests/edit',
    'GradeScaleDetails',
    'Mailers/add',
    'Mailers/edit',
    'Mailers/delete', 
    'AcademicStatuses/add',
    'AcademicStatuses/edit',
    'AcademicStatuses/delete',
    'AcademicStands/search',
    'CourseGroupedSections',
    'MergedSectionsForCourses',
    'MergedSectionsCourses',
    'CourseSplitSections',
    'ExamConstraintView',
    'ExamSplitSections',
    'GradeSettings',
    'ScheduleSetting',
    'CourseConstraint',
    'ExamConstraint',
    'ClassRooms/add',
    'ClassRooms/view',
    'ClassRooms/edit',
    'CourseSchedules/edit',
    'CourseSchedules/add',
    'CourseSchedules/delete',
    'CourseSchedules/edit',
    'CourseSchedules/unschedule_courses_possible_causes',
    'CourseSchedules/manual_schedule_unscheduled',
    'CourseSchedules/change_schedule',
    'CourseSchedules/manual_schedule_unscheduled',
	'Graduation', //Exclude "Graduation" controller from permission management
	'Users/get_department',
	//'ExamResults/get_exam_result_entry_form', //Remove "get_exam_result_entry_form" action from "ExamResults" controller
	'ExamResults/edit',
	'ExamResults/delete',
	'ExamResults/view',
	'AcceptedStudents/search',
	'AcceptedStudents/view',
	'AcceptedStudents/auto_fill_preference',
	'AcceptedStudents/summery',
	'AcceptedStudents/count_result',
	'AcceptedStudents/manual_placement',
	'AcceptedStudents/print_autoplaced_pdf',
	'AcceptedStudents/export_autoplaced_xls',
	'AcceptedStudents/download',
	'AcceptedStudents/print_students_number_pdf',
	'AcceptedStudents/export_students_number_xls',
	'Preferences/get_preference',
	'Preferences/view',
	'users/login',
	'users/logout',
	'users/delete',
	'users/editprofile',
	'users/useticket',
	'users/add',
	'users/edit',
	'user/forget',
	'users/newpassword',
	'users/confirm_task',
	'users/changePwd',
	'users/forget',
	'Votes',
	'ExamResults/index',
	'ExamGrades/auto_ng_and_do_to_f',
	'HealthService',
	'MedicalHistories/index',
	'MedicalHistories/view',
	'MedicalHistories/delete',
	'Dormitories',
	'DormitoryBlocks/index',
	'DormitoryAssignments/index',
	'MealHalls/index',
	'MealAttendances/index',
	'MealHallAssignments/get_colleges',
	'MealHallAssignments/get_departments',
	'MealHallAssignments/get_year_levels',
	'MealHallAssignments/get_department_year_levels',
	'MealHallAssignments/add_student_meal_hall',
	'MealHallAssignments/add_student_meal_hall_update',
	'DepartmentStudyPrograms/get_department_study_programs_combo',
	'DepartmentStudyPrograms/get_selected_department_department_study_programs',
	'*/autocomplete', //Remove "autocomplete" from all controllers
);
Configure::write('ACL.excludedACL', $excludedACL);

//Login page background
//images in /webroot/img/login-background folder

$imgcnt = 10; 
$login_page_background = array();

if($imgcnt) {
	for ($i= 0; $i < $imgcnt; $i++) {
		$login_page_background[$i]['1366_768'] = $i.'-1280-800.jpg';
		$login_page_background[$i]['1280_800'] = $i.'-1280-800.jpg';
		$login_page_background[$i]['1280_768'] = $i.'-1280-768.jpg';
		$login_page_background[$i]['1280_720'] = $i.'-1280-720.jpg';
		$login_page_background[$i]['1024_768'] = $i.'-1024-768.jpg';
		$login_page_background[$i]['800_600'] = $i.'-800-600.jpg';
	}
}

Configure::write('Image.login_background', $login_page_background);
Configure::write('App.base_currency_id', 1);
Configure::write('Invoice.required', true);


//Rename ACL generated menu by humanized name suitable to the application
//$rename_menu_title['courseRegistrations']='Registration';
$rename_menu_title['registrations'] = 'Registration';
$rename_menu_title['costShares'] = 'Billing';
$rename_menu_title['securitysettings'] = 'Security Settings';
$rename_menu_title['students'] = 'Admitted Students';
$rename_menu_title['mainDatas'] = 'Main Data';
$rename_menu_title['examTypes'] = 'Exam Setup';
$rename_menu_title['examResults'] = 'Exam Result & Grade';
$rename_menu_title['courseInstructorAssignments'] = 'Assign Instructor for a Course';
$rename_menu_title['graduationLetters'] = 'Letter Template';
$rename_menu_title['graduationCertificates'] = 'Graduation Certificate Template';
$rename_menu_title['graduationWorks'] = 'Graduation Works';
$rename_menu_title['graduationStatuses'] = 'Graduation Statuses';
$rename_menu_title['graduationRequirements'] = 'Graduation Requirements';
$rename_menu_title['examGrades'] = 'Grades';
$rename_menu_title['examGradeChanges'] = 'Grade Change';
$rename_menu_title['makeupExams'] = 'Makeup Exam';
$rename_menu_title['gradeSettings'] = 'Grade Setting';
$rename_menu_title['makeupExams'] = 'Makeup & Supplmentary Exam';
$rename_menu_title['helps'] = 'Help';
$rename_menu_title['sections'] = 'Manage Sections';
$rename_menu_title['colleagueEvalutionRates'] = 'Colleague Evaluation';
$rename_menu_title['studentStatusPatterns'] = 'Academic Status & Pattern';
$rename_menu_title['studentEvalutionRates'] = 'Evaluate Your Instructor';
$rename_menu_title['Evalution'] = 'Evaluations';
$rename_menu_title['instructorEvalutionSettings'] = 'Instructor Evaluation Settings';
$rename_menu_title['Billings'] = 'Online Payments';
$rename_menu_title['PlacementEntranceExamResultEntries'] = 'Placement Entrance Exam Results';

Configure::write('Menu.title_rename', $rename_menu_title);


// When entering dates for objects like 'expected graduated date', show only a limited range of years:

Configure::write('Calendar.universityEstablishement', 1986);
Configure::write('Calendar.yearsAhead', 10);
Configure::write('Calendar.yearsInPast', 2);
Configure::write('Calendar.birthdayInPast', 60);
Configure::write('Calendar.birthdayAhead', 0);
Configure::write('Calendar.senateApprovalInPast', 5);
Configure::write('Calendar.senateApprovalAhead', 0);
Configure::write('Calendar.senateListStartYear', 2011);
Configure::write('Calendar.graduateListStartYear', 2011);
Configure::write('Calendar.applicationStartYear', 2012);
Configure::write('Calendar.graduateApprovalAhead', 0);
Configure::write('Calendar.expectedGraduationInFuture', 8);
Configure::write('Calendar.graduateApprovalInPast', 5);
Configure::write('Calendar.clearanceWithdrawInPast', 1);
Configure::write('Calendar.clearanceWithdrawInFuture', 0);
Configure::write('Calendar.daysAvaiableForGraduateDeletion', 60);

// added by neway for smis 4 update  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

Configure::write('ExamGrade.Approval.yearsInPast', 2);
Configure::write('ExamGradeChange.SuppExam.yearsInPast', 5);
Configure::write('Users.AccountDeactivation.yearstoLookGivenLastLogin', 2);

Configure::write('FootableDataPageSizeXSmall', 20);
Configure::write('FootableDataPageSizeSmall', 50);
Configure::write('FootableDataPageSizeLarge', 100);
Configure::write('FootableDataPageSizeXLarge', 500);

// Decimal Places for Round Function to use System-wide
define('DECIMAL_PLACES', 2);

// Decimal Places for Round Function to use in Placement
define('DECIMAL_PLACES_PLACEMENT', 2);
define('SHOW_REGION_ON_ADD_PREFERENCE_ON_BEHALF_OF_STUDENT', 2);

// Credit to ECTS conversion 
/* The study load of subjects is expressed in ECTS (European Credit Transfer System). 
	** One ECTS is equal to 28 hours of study (can be 25 -30 hours in some countries)
	** course subjects have a study load of either 5 ECTS  equal to 140 (5 x 28 hours)
	** The total study load for a three-year Bachelor’s degree course is 180 ECTS (3 x 60 ECTS).

	** 3 Credit Hour course is equivalent to 5 ECTS in AMU, so, 1 credit  = 1.666666667 ECTS
*/

define('CREDIT_TO_ECTS', 1.666666667);

define('REQUIRE_FILE_UPLOAD_FOR_CLEARANCE', 0);
define('REQUIRE_FILE_UPLOAD_FOR_WITHDRAWAL', 1); 

// for filtering clearance approal and profile not build lists
define('DAYS_BACK_CLEARANCE', 365);
define('DAYS_BACK_COURSE_SUBSTITUTION', 365);
define('DAYS_BACK_PROFILE', 365);
define('DAYS_BACK_DISPATCHED_NOTIFICATION', 365);

define('DAYS_BACK_READMISSION', 365);
define('DAYS_ALLOWED_TO_DELETE_PROFILE_PICTURE_FROM_LAST_UPLOAD', 1);

define('DAYS_ALLOWED_TO_ADD_PREFERENCE_ON_BEHALF_OF_STUDENTS_AFTER_DEADLINE', 2);

// checks admission date of the student and last student_section created especially speeds up for freshman
// sectionless/ adding students for freshman sections is taking long time to load given many students are dropping out
define('DAYS_BACK_FOR_SECTIONLESS_LOOKUP', 365);
// replaced by the following codes

// If ALLOW_STUDENT_SECTION_MOVE_TO_NEXT_YEAR_LEVEL is set to 0, students can only be added to the next level section either by add student to section or section year level upgrade.
define('ALLOW_STUDENT_SECTION_MOVE_TO_NEXT_YEAR_LEVEL', 1); // default 0, don't allow, set 1 to allow move to next year level.

// The system will check for students that have been registered or have section assignments in the last 2 academic years and current academic year to search for eligible students to add to section with add to section option in display section students page.
define('ACY_BACK_FOR_SECTION_ADD', 2); // Default: 2, current and 2 academic years back totalling 3 academic years.

// To consider curriculum Attachment history to find sections to add student on his current or next year level.
define('CONSIDER_PREVOUS_CURRICULUM_ATTACHMENTS_FOR_ADDING_STUDENT_TO_SECTION', 1); // default 1, consider previous curriculum attachments, set 0 to not consider previous curriculum attachments.

// The system will check for students that have section assignments in the the last 2 academic years and current academic year to consider them as sectionless students.
define('ACY_BACK_FOR_SECTION_LESS', 2); // Default: 2, current and 2 academic years back totalling 3 academic years.

// The system will check for students that have been dismissed in the last 2 academic years or current academic year and shows 3 academic year ranges in dropdown options for readmission related options. 
define('ACY_BACK_FOR_READMISSION', 3); // Default: 3, current and 3 academic years back totalling 5 academic yearsk.

// The system will check for the last 2 academic years and current academic year student section assignments in order to check thier registered and added courses for possibe supplementary exam entry.
define('ACY_BACK_FOR_SECTION_LIST_SUPPLEMENTARY_EXAM', 2);	// Default: 2, current and 2 academic years back sctions will be listed, Set 0 for currenct academic year only

// ACY_BACK_FOR_ALL setting is used for most of the year level things throughout the system set it carefully. Shows 5 academic years, current academic year and previous 4 academic year in dropdowns and other places where it is used.
define('ACY_BACK_FOR_ALL', 4);	// Default: 4, current and 4 academic years back totalling 5 academic years.

define('COUNTRY_ID_OF_ETHIOPIA', 68);

define('REGION_ID_OF_ADDIS_ABABA', 1);
define('REGION_ID_OF_DIRE_DAWA', 5);

define('DISMISSED_ACADEMIC_STATUS_ID', 4);

// Sets the available academic years for rolling back grade submission back to department and instructor for resubmission.
define('ACY_BACK_FOR_ROLLING_BACK_GRADE_SUBMISSION', 1); // Default: 0, currenct accademic year only. 1, current and 1 academic year back.

// The system will check for grade change requests in the last 2 academic years and current academic year to show for grade change approval. It also limits the year range available for for grade change approval search filters and supplimentary exam entry to only 3 academic years, 2 past and current academic year when it is used in models or year ranges.
define('ACY_BACK_FOR_GRADE_CHANGE_APPROVAL', 2); // Default: 2, current and 2 academic years back totalling 3 academic years.

// Maximum number of C+ and C grades allowed for Postgraduate students to check for graduation eligibility.
define('MAXIMUM_C_PLUS_GRADES_ALLOWED_FOR_POST_GRADUATE', 1);
define('MAXIMUM_C_GRADES_ALLOWED_FOR_POST_GRADUATE', 1);

// whether to allow profile editing of graduated students by non admin registrar accounts
define('ALLOW_EDITING_GRADUATED_STUDENTS_FOR_NON_ADMIN_REGISTRAR_ACCOUNTS', 0); // default: 0, don't allow, 1: allow editing


################ critical settings for course registration ####################

// This is used to allow students to register on hold for courses with prequisite not met and does not have previous semester status and other conditions.
// 0, disable, 1, enable
define('ALLOW_ON_HOLD_COURSE_REGISTRATION_SYSTEM_WIDE', 0);


// This is used to allow students to register or registrar account to register students for latest semester registrations if their previous semester status is not generated.
// they system is configured to consider students who only registered for pass or fail grade type, for status patterns that are not set to generate status every semester like summer, evening, weekend, etc.

// 0, disable, 1, enable
define('ALLOW_COURSE_REGISTRATION_WITHOUT_PREVIOUS_SEMSESTER_STATUS_SYSTEM_WIDE', 0);

// to allow registrar admin or director to register students for latest semester registrations if their previous semester status is not generated.
define('ALLOW_COURSE_REGISTRATION_WITHOUT_PREVIOUS_SEMSESTER_STATUS_FOR_REGISTRAR_ADMIN', 0);

// to allow registrar role to mass register students for latest semester registrations
// 0, disable, 1, enable
define('ALLOW_MASS_REGISTRATION_SYSTEM_WIDE', 0);

// to allow registrar admin to mass register students for latest semester registrations even if ALLOW_MASS_REGISTRATION_SYSTEM_WIDE is set to disabled
// 0, disable, 1, enable
define('ALLOW_MASS_REGISTRATION_FOR_REGISTRAR_ADMIN', 1);

// to allow or deny mass course registration by section for courses with submitted grades,
// 0, do not allow, 1, allow
define('MASS_COURSE_REGISTRATION_IS_ALLOWED_FOR_COURSES_WITH_SUBMITTED_GRADES', 0);

// to allow or deny courses published as mass add to be available for registration in manage missing registration, on student Academic Profile
// KEEP IT ON 0, UNLESS VERY REQUIRED, TURNING THIS ON MAY RESULT IN DOUBLE REGISTRATION IN SOME CASES!!!
// 0, do not allow, 1, allow, 
define('MASS_ADDED_COURSE_IS_ALLOWED_TO_BE_REGISTERED_ON_MANAGE_MISSION_REGISTRATION', 0);


################ end critical settings for course registration ####################


########### Academic Calendar Edit Settings ###########

// Wheather to allow or not adding departments and year levels that were not listed in the defined academic calendar during edit.
define('ALLOW_EDITING_WITH_UNLISTED_DEPARTMENTS', 0); 	// Default: 0 (recommended).
define('ALLOW_EDITING_WITH_UNLISTED_YEAR_LEVELS', 0);		// Default: 0 (recommended).

// Wheather to allow or not changing Academic Year,  Program and Program Type of the defined academic calendar during edit.
define('ALLOW_CHANGING_ACADEMIC_YEAR', 0);	// Default: 0 (recommended).
define('ALLOW_CHANGING_SEMESTER', 1);			// Default: 1 (recommended). 
define('ALLOW_CHANGING_PROGRAM', 0);			// Default: 0 (recommended).
define('ALLOW_CHANGING_PROGRAM_TYPE', 0); 	// Default: 0 (recommended).

########### END Academic Calendar Edit Settings ###########


//// 1, force students to fill basic profile and prevent grade view, registration etc, 0, disable
// Graduating class students are always forced to fill basic profile and FAIDA FIN on their last year any semester
define('FORCE_ALL_STUDENTS_TO_FILL_BASIC_PROFILE', 0); 

define('FORCE_ALL_STUDENTS_TO_FILL_FAYDA_NUMBERS', 0); 

define('FORCE_ALL_STUDENTS_TO_FILL_TIN_NUMBER', 0); 


define('USE_CALENDAR_GRADE_SUBMISSION_END_DATE_INSTEAD_OF_GRADE_SUBMITTED_DATE_FOR_GRADE_CHANGE_DEADLINE_CALCULATION', 1); // 0 = don't allow grade change before any approved grade.
// 0, is the default and will use the grade submitted date for the student and calculates the grade change deadline by adding days available for grade change from general settings.
// 1, will use the grade submission deadline set in academic calendar and calculates the grade change deadline by adding days available for grade change from general settings regardless of the date student grade is submitted.

// ACY Back for Grade Cancellation and Update Back Dated Data Entry
define('ACY_BACK_FOR_BACK_DATED_DATA_ENTRY', 4); // Default: 0, Set 0 for currenct accademic year only 

// whether to allow or not students having F / NG  grade appear in Supplemetary grade submission student selection box.
define('STUDENTS_WITH_F_GRADE_ALLOWED_FOR_SUPPLEMENTARY_GRADE_SUBMISSION', 0);
define('STUDENTS_WITH_NG_GRADE_ALLOWED_FOR_SUPPLEMENTARY_GRADE_SUBMISSION', 0);

// section or student program types allowed for supplementary exam entry (mostly by department supplementary exam), 
$program_types_to_allowed_for_supplementary_exam = array(); // array(3 => 3); // = array(); no restriction, = array(3 => 3); for summer for now!
Configure::write('program_types_to_allowed_for_supplementary_exam', $program_types_to_allowed_for_supplementary_exam);

// the ability to enforce the defined program types without any conditions, default 0.
define('ALWAYS_ENFORCE_ALLOWED_PROGRAM_TYPES_FOR_SUPPLEMENTARY_GRADE_SUBMISSION', 0);

// whether to allow NG grade change or not .
define('NG_GRADE_CAN_BE_CHANGED', 0);


// Allowed Grades to delete in Back Dated Data Entry/ Grade Cancelattion and update
$allowed_grades_for_deletion = array('NG' => 'NG', 'I' => 'I', 'W' => 'W', 'DO' => 'DO');
Configure::write('allowed_grades_for_deletion', $allowed_grades_for_deletion);


############################ DO NOT CHANGE THESE, BUT CAN ADD MORE ############################ 
// to compare student grades throughout the system instead of using strcasecomp function 

$invalid_grades_list = array('NG' => 'NG', 'I' => 'I', 'W' => 'W', 'DO' => 'DO');
Configure::write('invalid_grades_list', $invalid_grades_list);

#################################### END DO NOT CHANGE THESE  #################################


// Back Dated Data Entry/ Grade Cancelattion and update settings for registrar admin and non admin registrar accounts
define('ALLOW_REGISTRAR_ADMIN_TO_DELETE_VALID_GRADES', 0); // Default: 0, do not allow valid grades deletion, set 1 to allow valid grades deletion

// To allow or deny registrar admin account to change valid grades 
define('ALLOW_REGISTRAR_ADMIN_TO_CHANGE_VALID_GRADES', 0); // Default: 0, do not allow valid grades changes to other grades, set 1 to allow valid grades changes to other grades

// To allow or deny NON ADMIN registrar accounts(except main registrar account holder) to enter grades on not deactivated instructor assignment.
define('ALLOW_NON_ADMIN_REGISTRAR_GRADE_ENTRY_ON_NOT_DEACTIVATED_INSTRUCTOR_ASSIGNMENT', 0);

// To allow or deny ADMIN registrar (main registrar account holder) account to enter grades on not deactivated instructor assignment.
define('ALLOW_ADMIN_REGISTRAR_GRADE_ENTRY_ON_NOT_DEACTIVATED_INSTRUCTOR_ASSIGNMENT', 1);


define('NATIONAL_ID_IMPORT_TEMPLATE_FILE', '/files/template/national_id_import_template.xls');
define('ACY_BACK_FOR_STUDENT_NATIONAL_ID_CHECK', 1);

define('OTP_IMPORT_TEMPLATE_FILE', '/files/template/otp_import_template.xls');
define('SSS_IMPORT_TEMPLATE_FILE', '/files/template/sss_import_template.xls');

// academic year list range for department transfer requests to show in drop down for searching requests for approval and invalidation.
define('ACY_BACK_FOR_DEPARTMENT_TRANSFER_DROP_DOWN', 1); // Default: 1, current and 1 academic year back.
define('DEFAULT_DAYS_FOR_DEPARTMENT_TRANSFER_REQUEST_CHECK', 365); // Back Days to check to list department transfer requests approval and invalidate auto delete/reject old requests from current day.

// Academic Calendar Default Settings, To make semester editing thtough out the system easier

$semesters = ['I' => 'I', 'II' => 'II', 'III' => 'III'];

Configure::write('semesters', $semesters);

define('DEFINED_SEMESTERS_COUNT', count($semesters));

// Possible Grades options available on Student Transfered courses from other university
$exemptedCourseGradesOptions = array(
	'A+' => 'A+', 'A' => 'A', 'A-' =>  'A-',
	'B+' => 'B+', 'B' => 'B', 'B-' =>  'B-',
	'C+' => 'C+', 'C' => 'C', 'C-' =>  'C-',
	'D' => 'D',
	'P' => 'P'
);

Configure::write('exemptedCourseGradesOptions', $exemptedCourseGradesOptions);

// disable this if you want to reduce database size or to force students to evaluate thier instructors before grade view
define('ALLOW_AUTO_MASSEGES_TO_BE_SENT_FOR_STUDENTS', 1); 

// The maximum number of years for all departments be allowed in the system, limits defining a year level and extending the year level in the department.
define('MAXIMUM_YEAR_LEVELS_ALLOWED', 7); // default: 7, but there are some departments that have more than 7 year levels, so we set it to 10 for now, can be changed in the future if needed.

define('APPLICATION_START_YEAR', '2012');
define('UNIVERSITY_START_YEAR', '1986');

// percentage of course completion to check students for exit exam eligibility checking, considered as 80% of the course completion, to filter out students who have not completed the course at least 80%.
define('COURSE_PERCENT_TO_COMPLETE_FOR_EXIT_EXAM', 0.8); 

$exit_exam_types = array('Exit Exam' => 'Exit Exam');
Configure::write('exit_exam_types', $exit_exam_types);

// Programs to look for exit exam eligibility
$programs_to_look_for_exit_exam_types = array(1 => 1); // only for undergraduate programs for now.
Configure::write('programs_to_look_for_exit_exam_types', $programs_to_look_for_exit_exam_types);

// whether to show or exit exam results for not graduated students on check graduates page, useful to show if course completed students took exit exam and show in advance or useful to check exit exam results for students without actually logging in or if exit results are not fed to registered Exit Exam Course or any stakeholders
define('SHOW_EXIT_EXAM_RESULTS_FOR_NOT_GRADUATED_STUDENTS_ON_CHECK_GRADUATES', 1); // Default: 0, don't show, privacy concerns, Recommendation: set it to 1 temporarly on exit exam released dates or keep it on if privacy is not a concern.


$benefit_groups = array('Normal' => 'Normal', 'Pastoralist' => 'Pastoralist', 'Visual Impaired' => 'Visual Impaired', 'Deaf' => 'Deaf');
Configure::write('benefit_groups', $benefit_groups);


// Certificate Verification Code Types for interface interpretation
$certificateVerificationCodeTypes = array(
	'TD' => 'Temporary Degree',
	'GC' => 'Graduation Certificate',
	'SC' => 'Student Copy',
	'CC' => 'Course Completion Certificate',
	'LP' => 'Language Proficiency',
	'TH' => 'To Whom it may concern',
);

Configure::write('certificateVerificationCodeTypes', $certificateVerificationCodeTypes);


define('ENABLE_MOODLE_INTEGRATION', 1);
define('ACY_BACK_FOR_MOODLE_INTEGRATION', 2);
define('MOODLE_SITE_URL', 'https://online.amu.edu.et');
define('MOODLE_PASSWORD_ENCRYPRION_ALGORITHM', 'sha1');

define('ALLOW_MOODLE_INTEGRATION_FOR_SUBMITTED_GRADE', 0);

define('SHOW_OTP_TAB_ON_STUDENT_ACADEMIC_PROFILE_FOR_STUDENTS', 1);
define('OTP_OFFICE_365_OUTLOOK_URL', 'https://outlook.office.com');
define('OTP_OFFICE_365_MAIN_URL', 'https://www.office.com');

$otp_services_option = array('Office365' => 'Office 365', 'Elearning' => 'E-Learning', 'ExitExam' => 'Exit Exam');
Configure::write('otp_services_option', $otp_services_option);

// Exclude students form Office 365 Import Report if they have OTP table entry with 'Office365' service type, Usefull to filter out students that have Office365 email to be imported again and to know which students doesn't have Office365 account 
define('EXCLUDE_STUDENTS_FROM_OFFICE_365_IMPORT_REPORT_IF_FOUND_IN_OTP_TABLE', 1); // default 1, Exclude the students

$allowed_grades_graduation_for_pg = array(
	'A+' => 'A+', 'A' => 'A', 'A-' =>  'A-',
	'B+' => 'B+', 'B' => 'B', 'B-' =>  'B-',
	'C+' => 'C+', 'C' => 'C',
	'P' => 'P', 'PASS' => 'PASS',
);

Configure::write('allowed_grades_graduation_for_pg', $allowed_grades_graduation_for_pg);

define('C_PLUS_GRADES_ALLOWED_FOR_GRADUATION_FOR_PG_PROGRAM', 1);
define('C_GRADES_ALLOWED_FOR_GRADUATION_FOR_PG_PROGRAM', 1);

define('ALLOW_STUDENTS_TO_UPLOAD_PROFILE_PICTURE', 0);
define('ALLOW_REGISTRAR_TO_UPLOAD_PROFILE_PICTURE', 0);

define('FORCE_REGISTRAR_TO_FILL_STUDENTS_PRIMARY_CONTACT_INFORMATION', 0);

define('REQUIRE_STUDENTS_TO_UPLOAD_PROFILE_PICTURE_WHEN_UPDATING_PROFILE', 0);

define('ALLOW_ESLCE_RESULTS_TO_BE_FILLED_FOR_UNDER_GRADUATE_STUDENTS', 0);


define('ALLOW_STAFFS_TO_UPLOAD_PROFILE_PICTURE', 0);

/* 
	Possible Values for ONLY_ALLOW_COURSE_ADD_FOR_FAILED_GRADES: 
	++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	'AUTO' = Determine from General Settings as set for each Program/Program Type, 
	1 = ignore General Settings and only allow course adds for failed Grades system wide, 
	0 = ignore general Settings and allow any course to be added system wide. 
*/

define('ONLY_ALLOW_COURSE_ADD_FOR_FAILED_GRADES', 'AUTO');  
//define('ONLY_ALLOW_COURSE_ADD_FOR_FAILED_GRADES', 1);  

/* 
	'AUTO' = Determine from General Settings as set for each Program/Program Type, 
	1 = Allow system wide, ignore General Settings set for each Program/Program Type
	0 = Disable system wide, ignore General Settings set for each Program/Program Type
*/

define('ALLOW_COURSE_ADD_FROM_HIGHER_YEAR_LEVEL_SECTIONS', 'AUTO');
define('ALLOW_GRADE_REPORT_PDF_DOWNLOAD_TO_STUDENTS', 'AUTO'); 
define('ALLOW_REGISTRATION_SLIP_PDF_DOWNLOAD_TO_STUDENTS', 'AUTO');
define('ALLOW_STUDENTS_TO_RESET_PASSWORD_BY_EMAIL', 'AUTO');

define('ALLOW_GRADE_REPORT_PDF_DOWNLOAD_CURRENT_SEMESTER_ONLY', 1);  // 1: allow to download current or last semester grade report only, 0: allow all registered semester grades to be dowloaded at any time( not recommended: increases server load to generate status for every semester up on request.)

// The system will automatically regenerates status for student role to avoid CGPA errors, if the students are allowed to download grade report bases on program set on general settings and allowed system wide.
// 1: Force to regenerate status automatically before downloading student grade report. //helps to avoid cgpa errors but it is slow and requires system resouces but accurate. Turn this on if accuracy is more important and system resources are not limited.
define('REQUIRE_AUTOMATIC_STATUS_REGENERATION_BEFORE_GRADE_REPORT_PDF_DOWNLOAD_FOR_ALL_ROLES', 0);  

define('ALLOW_STUDENTS_TO_USE_FORGOT_PASSWORD_BY_EMAIL', 'AUTO');

// Controlls the system to send or not send emails irrispective of general settings set per program and program type.

define('GRADE_NOTIFICATION_FOR_STUDENTES_SYSTEM_WIDE_ENABLED', 0); // 0: disabled system wide   1: Enabeled System Wide but checked against General Settings to send or not send depending on Program or Program Type.

// Not applicable in real world exept there are different Academic Year definition within the same year. We will consider in the future, not needed as such now, Neway
//define('ALLOW_COURSE_ADD_FROM_DIFFERENT_ACADEMIC_YEAR', 'AUTO'); 

// No of days should be a multiple if 7 (7 days a week)

define('DEFAULT_DAYS_AVAILABLE_FOR_GRADE_CHANGE', 14);
define('DEFAULT_DAYS_AVAILABLE_FOR_NG_TO_F', 28);
define('DEFAULT_DAYS_AVAILABLE_FOR_DO_TO_F', 28);
define('DEFAULT_DAYS_AVAILABLE_FOR_FX_TO_F', 28);

// No of weeks should be a multiple if 4 (48 weeks in ACY)

define('DEFAULT_WEEK_COUNT_FOR_ONE_SEMESTER', 16);
define('DEFAULT_WEEK_COUNT_FOR_ACADEMIC_YEAR', 48);
define('DEFAULT_SEMESTER_COUNT_FOR_ACADEMIC_YEAR',  2/* count($semesters) */);

define('YEARS_BACK_TO_CONSIDER_USER_ACTIVE', Configure::read('Users.AccountDeactivation.yearstoLookGivenLastLogin'));


//Days Available for staff evaluation after grade submission end date.
define('ACY_BACK_FOR_STAFF_EVALUATION_LIST_PRINT_AND_ARCHIEVE', 3);

//Maximun staff evaluation rate
define('MAXIMUM_STAFF_EVALUATION_RATE', 5);

// an instructor should have the following no of evaluation from his/her colleagues before his head evaluates him/her and print his report.
define('MINIMUM_COLLEAGUE_EVALUATION_COUNT_FOR_HEAD_EVALUATION_AND_PRINT', 3);

// the minimum no of evaluation an instructor should fill before getting his evaluation printted.
define('REQURED_MINIMUM_COLLEAGUE_EVALUATION_TO_FILL_INSTRUCTOR', 3);

// Force the instructor to fill the defined no of colleage evaluations for the current active academic calendar after login/before allowing him/her ro do anything.
define('FORCE_INSTRUCTOR_TO_FILL_REQURED_MINIMUM_COLLEAGUE_EVALUATION_AFTER_LOGIN', 0);

// days available for students to fill evaluation starting from definfed days prior to grade submission, 
// The system must not prevent students to see their continues assesment before some predefined weeks of defined grade submission deadline or must not allow/force students to fill evaluation just in the first weeks of classes or just after the head assigns instructors to courses
define('DEFAULT_WEEK_COUNT_FOR_STAFF_EVALUATION_FOR_STUDENTS', 2);

// weather to allow or deny students to fill evaluation after grade is submitted or after grade submission dead line.
define('ALLOW_STAFF_EVALUATION_AFTER_GRADE_SUBMISSION', 0);

// weather to allow or deny colleages to fill evaluation after an academic semester is passed
// This is mandatory as staffs are filling evaluation after evaluations are printed and claiming the evaluations are not correct or ask department to reprint evaluation for promotions in the case of department head change.
define('DEFAULT_DAYS_AVAILABLE_FOR_STAFF_EVALUATION', DEFAULT_WEEK_COUNT_FOR_ONE_SEMESTER * 7);

// Default minimum and maximum credits per semester to use if it is not defined for the given program and program type combination
define('DEFAULT_MINIMUM_CREDIT_FOR_STATUS', 6);
define('DEFAULT_MAXIMUM_CREDIT_PER_SEMESTER', 24);

// to add the alloed credits for Graduating class students as per senate legislations, to bypass credit limitations imposed by the program and program type of the student if the student is graduating class and in its final semester
define('ADDITIONAL_CREDIT_ALLOWED_FOR_GRADUATING_STUDENTS', 5);
define('ADDITIONAL_ECTS_ALLOWED_FOR_GRADUATING_STUDENTS', (int) (CREDIT_TO_ECTS * ADDITIONAL_CREDIT_ALLOWED_FOR_GRADUATING_STUDENTS));

// to allow department heads to override course add requests auto-rejected by the system due to over credit requirent checking for students in thier department.
define('ENABE_AUTO_COURSE_ADD_REJECTION_OVERRIDE_FOR_DEPARTMENTS', 1);

// to allow registrar to override course add requests auto-rejected by the system due to over credit requirent checking for students under their assignment.
define('ENABE_AUTO_COURSE_ADD_REJECTION_OVERRIDE_FOR_REGISTRAR', 1);

// To force students not to add more than 2 courses per semester, this is to avoid students take over the allowed maximum credit per program. adding 2 courses considerning full load is a starting point 24 + 6 max, 30 credits .
define('MAXIMUM_COURSES_TO_ADD_PER_SEMESTER', 2);

// Academic year ranges to check for approval, academic years available in the dropdowns for course add and drop. It will also be used in approval filtering on search pages, dashboard, models and other places.
define('ACY_BACK_COURSE_ADD_DROP_APPROVAL', 2); //Recomended: 1, current acy and 1 year back,  Default: 2, Current academic year and 2 academic years back.

// Academic year ranges to check for approval for dashboard, It is used to boost dashboard loading time and to focus on current academic year and previous academic year only. Approval In the Grades > Approve/Confirm Grade Submission is not affected by this setting and it is not restricted.
define('ACY_BACK_GRADE_APPROVAL_DASHBOARD', 1); //Recommended: 1, current acy and 1 year back,  Default: 0, Current academic year only 

// Academic year ranges for non admin registrar accounts to maintain missing course registrations and wrong NG cancellations. Restrictions is needed as MoE is collecting data  and the system must be strict on the number of years to maintain missing course registrations and wrong NG cancellations.
define('ACY_BACK_COURSE_REGISTRATION', 2); //Recommended: 2, current acy and 2 year back,  Default: 0, Current academic year only

// To restrict non admin registrar accounts to maintain missing course registrations and wrong NG cancellations for a defined number of years from current academic year.
define('RESTRICT_NON_ADMIN_REGISTRAR_TO_ACY_BACK_COURSE_REGISTRATION', 1);  // Default: 1, restrict non admin registrar accounts to maintain missing course registrations and wrong NG cancellations for a defined number of years from current academic year

// Academic year ranges available to search for NG, I, W, DO, FX grade cancellation in dropdowns and models
define('ACY_BACK_FOR_NG_F_FX_W_DO_I_CANCELATION', 4); // Default: 4, current academic year and 4 academic year back totalling 5 years

// To keep or delete assesment records in NG grade cancellation
define('DELETE_ASSESMENT_AND_ASSOCIATED_RECORDS_ON_NG_CANCELATION', 0); // Default 0: Delete only Grade and Keep Assesment data if available, 1: Delete All Data Grades, Assesments and Registrations, Adds, etc

// Academic year ranges available to search students for curriculum attachment and detachment considering students admissin year and current academic year
define('ACY_BACK_FOR_CURRICULUM_ATTACH_DETACH', 7); // Default: 3, current academic year and 3 years back, totaling 5 academic years, some programs have specializations after 3 or 4 years that requires different curriculum. Eg. Electrical, Mechanical else, it shoudn't be that much big 3 years is enough.

// Auto Messege limit to fetch from database to show on dashboard and message notification 
define('AUTO_MESSAGE_LIMIT', 5); // limit to load auto messages from db for dashboard Auto Message Modal.

// owner password for TCPDF PDF Encryption for $owner_pass parameter
define('OWNER_PASSWORD', '1qazXSw23eDC@@');

// user password for TCPDF PDF Encryption for $user_pass parameter
define('USER_PASSWORD', '');

// the small logo file full path to be used in TCPPDF PDF Files
define('UNIVERSITY_LOGO_HEADER_FOR_TCPDF', '/app/webroot/img/logo.gif');

// Transparent full page logo file full path to be used in TCPPDF PDF Files
define('UNIVERSITY_FULL_PAGE_TRANSPARENT_LOGO_FOR_TCPDF', '/app/webroot/img/logo-transparent.gif');

// Transparent registrar stamp/ seal  file full path to be used for grade report and registration slips TCPPDF PDF Files
define('REGISTRAR_TRANSPARENT_STAMP_FOR_TCPDF', '/app/webroot/img/seal.png');

// for QR Code don't ommit the last /
define ('BASE_URL_HTTPS','https://sis.y12hmc.edu.et/');

// for student Copy
define ('UNIVERSITY_WEBSITE','https://www.y12hmc.edu.et');
define ('REGISTRAR_EMAIL','our@y12hmc.edu.et');
define ('PORTAL_URL_HTTPS','https://sis.y12hmc.edu.et');

## Social Medial Links
define ('UNIVERSITY_FACEBOOK_PAGE','https://facebook.com/y12hmc/?_rdc=1&_rdr');
define ('UNIVERSITY_FACEBOOK_PAGE_SHORT','y12hmc');
define ('UNIVERSITY_TELEGRAM_CHANNEL','https://t.me/y12hmc');
define ('UNIVERSITY_TELEGRAM_CHANNEL_SHORT','@y12hmc');
define ('UNIVERSITY_X_PAGE','https://x.com/y12hmc');
define ('UNIVERSITY_X_PAGE_SHORT','@y12hmc');
define ('UNIVERSITY_YOUTUBE_CHANNEL','https://www.youtube.com/@y12hmc');
define ('UNIVERSITY_YOUTUBE_CHANNEL_SHORT','@y12hmc');


define ('UNIVERSITY_MOTTO_EN','To improve healty every day!');
define ('UNIVERSITY_MOTTO_AM','!');

define ('INSTITUTIONAL_EMAIL_SUFFIX','@y12hmc.edu.et');

//To allow/deny to edit instructor profile for Department and College Admin Accounts (only Title Position and Education fields allowed to edit 
//(Email & Phone number fields are disabled by default except the instructor itself or system Admin)

define('ENABLE_INSTRUCTOR_USER_EDIT_COLLEGE_DEPARTMENT', 1); 

//define('STUDENT_IMPORT_TEMPLATE_FILE', '/files/template/template.xls'); 
define('INCLUDE_STUDENT_NUMBER_IN_IMPORT_TEMPLATE_FILE', 0);

define('STUDENT_IMPORT_TEMPLATE_FILE', '/files/template/accepted_students_import_template.xls'); 
define('STUDENT_IMPORT_TEMPLATE_FILE_WITHOUT_STUDENT_NUMBER', '/files/template/accepted_students_import_template_new.xls'); 

define('EXIT_EXAM_IMPORT_TEMPLATE_FILE', '/files/template/exit_exam_import_template.xls'); 

// for formating words like curriculum names, course titles, Thesis titles and others to Title Case
$prepositions_ucf = [' And ',' The ',' About ',' Like ',' Above ',' Near ',' Across ',' Of ',' After ',' Off ',' Against ',' On ',' Along ',' Onto ',' Among ',' Opposite ',' Around ',' Out ',' As ',' Outside ',' At ',' Over ',' Before ',' Past ',' Behind ',' Round ',' Below ',' Since ',' Beneath ',' Than ',' Beside ',' Through ',' Between ',' To ',' Beyond ',' Towards ',' By ',' Under ',' Despite ',' Underneath ',' Down ',' Unlike ',' During ',' Until ',' Except ',' Up ',' For ',' Upon ',' From ',' Via ',' In ',' With ',' Inside ',' Within ',' Into ',' Without '];
$prepositions_lc = [' and ',' the ', ' about ',' like ',' above ',' near ',' across ',' of ',' after ',' off ',' against ',' on ',' along ',' onto ',' among ',' opposite ',' around ',' out ',' as ',' outside ',' at ',' over ',' before ',' past ',' behind ',' round ',' below ',' since ',' beneath ',' than ',' beside ',' through ',' between ',' to ',' beyond ',' towards ',' by ',' under ',' despite ',' underneath ',' down ',' unlike ',' during ',' until ',' except ',' up ',' for ',' upon ',' from ',' via ',' in ',' with ',' inside ',' within ',' into ',' without '];

Configure::write('prepositions_ucf', $prepositions_ucf);
Configure::write('prepositions_lc', $prepositions_lc);


$department_types = ['Department' => 'Department', 'Faculty' => 'Faculty', 'School' => 'School'];
Configure::write('department_types', $department_types);

define('DEPARTMENT_TYPE_DEPARTMENT', 'Department');
define('DEPARTMENT_TYPE_FACULTY', 'Faculty');
define('DEPARTMENT_TYPE_SCHOOL', 'School');
define('DEPARTMENT_TYPE_AMHARIC_DEPARTMENT', 'ትምህርት ክፍል');
define('DEPARTMENT_TYPE_AMHARIC_FACULTY', 'ፋኩልቲ');
define('DEPARTMENT_TYPE_AMHARIC_SCHOOL', 'ትምህርት ቤት');

// All possible Course Categoties, many departments create course categories as many as courses and it's my impact performance when generating senate lists
// SELECT `name` FROM `course_categories` WHERE 1 GROUP BY `name` HAVING count(`name`) > 20 ORDER BY `name`; 
$course_category_options = ['Core(Major)' => 'Core(Major)', 'Common' => 'Common', 'Elective' => 'Elective', 'Supportive' => 'Supportive', 'Optional' => 'Optional', 'General' => 'General', 'Thesis' => 'Thesis'];
Configure::write('course_category_options', $course_category_options);

// Streams available to save on colleges table, useful to filter out departmtnets and colleges available to select on Course Add
$streams = ['1' => 'Natural', '2' => 'Social'];
Configure::write('streams', $streams);

define('STREAM_NATURAL', 1);
define('STREAM_SOCIAL', 2);


$preengineering_college_ids = ['1' => '1', '11' => '11', '16' => '16'];
Configure::write('preengineering_college_ids', $preengineering_college_ids);

$social_stream_college_ids = ['6' => '6', '15' => '15'];
Configure::write('social_stream_college_ids', $social_stream_college_ids);

$natural_stream_college_ids = ['2' => '2', '14' => '14'];
Configure::write('natural_stream_college_ids', $natural_stream_college_ids);

$all_pre_freshman_remedial_college_ids = $preengineering_college_ids + $social_stream_college_ids + $natural_stream_college_ids;
Configure::write('all_pre_freshman_remedial_college_ids', $all_pre_freshman_remedial_college_ids);

// used to exclude only freshman college_ids that don't actually have department from pages like alumni filling and other places
$only_stream_based_freshman_college_ids = ['14' => '14', '15' => '15', '16' => '16'];
Configure::write('only_stream_based_freshman_college_ids', $only_stream_based_freshman_college_ids);

$curriculum_types = ['1' => 'Semester Based', '2' => 'Year Based'];
Configure::write('curriculum_types', $curriculum_types);

define('SEMESTER_BASED_CURRICULUM', 1);
define('YEAR_BASED_CURRICULUM', 2);

$foriegn_students_region_ids = ['12' => '12', '13' => '13', '14' => '14', '15' => '15', '17' => '17'];
Configure::write('foriegn_students_region_ids', $foriegn_students_region_ids);

define('DEFAULT_MAXIMUM_STUDENTS_PER_SECTION', 50);


//// ++++++++++++++++++++++++++++++++ TEMPORARY HEMIS VARIABLES ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// Missing institution_codes(colleges and departments not exist in SMiS)  ================ FOR HEMIS REPORTS USE ONLY ===================

// for non regular students UG and PG Ptogram Types and Except Regular, Part-Time and Advance-Standing Program Types
define('CCDE_INISTITUTION_CODE', 'Y12HMC-CCDE');

// for all PG and PhD programs & for Regular, Part-Time Students 
define('PG_SCHOOL_INISTITUTION_CODE', 'Y12HMC-SPGS');

define('FRESHMAN_COORDINATION_INISTITUTION_CODE', 'Y12HMC-CFMC');

// Non Deparment Assigned Students for both semesters (under College of Social Sciences)
define('SOCIAL_SCIENCE_FRESHMAN_INISTITUTION_CODE', 'Y12HMC-CFMC-DSSF');

// Non Deparment Assigned Students for first semester only (under College of Natural Sciences)
define('NATURAL_SCIENCE_FRESHMAN_INISTITUTION_CODE', 'Y12HMC-CFMC-DNSF');

// Non Deparment Assigned Students for second semester only (under College of Natural Sciences)
define('OTHER_NATURAL_SCIENCE_FRESHMAN_INISTITUTION_CODE', 'Y12HMC-CFMC-ONSF');

// Non Deparment Assigned Students for second semester only (under AMiT)
define('PRE_ENGINEERING_FRESHMAN_INISTITUTION_CODE', 'Y12HMC-PREF');

### DB study_program_id directly imported from MoE (table Study Programs); for quick referencing throughout SMiS App

define('NATURAL_SCIENCE_STUDY_PROGRAM_ID', 1);
define('OTHER_NATURAL_SCIENCE_STUDY_PROGRAM_ID', 5);

define('PRE_ENGINEERING_STUDY_PROGRAM_ID', 8);

define('SOCIAL_SCIENCE_STUDY_PROGRAM_ID', 2);
define('OTHER_SOCIAL_SCIENCE_STUDY_PROGRAM_ID', 6);


// END Missing institution_codes(colleges and departments not exist in SMiS) for HEMIS  ================ FOR HEMIS REPORTS USE ONLY ===================

/* 
	Sponsor Types

	1	Regional Government => PG Regular
	2	Federal Government => UG: Primarly Regular except Scholarships; Exceptions: Advance Standing, Parttime,
	3	Private/Self => PG => All Program Types, UG: non Regular programs Except Advance Standing, Parttime, Summer
	4	Employer => UG: Advance Standing, Part-time, Summer; PG => Regualr, Part-time, PHD => All Program Types
	5	Other: all scholarship students in all programs

*/

define('SPONSORED_BY_REGIONAL_GOVERNMENT', 1);
define('SPONSORED_BY_FEDERAL_GOVERNMENT', 2);
define('SPONSORED_BY_SELF_PRIVATE', 3);
define('SPONSORED_BY_EMPLOYER', 4);
define('SPONSORED_BY_OTHER', 5);

$sponsor_types = ['1' => 'Regional Government', '2' => 'Federal Government', '3' => 'Private(Self Sponsored)' , '4' => 'Employer', '5' => 'Other'];

Configure::write('sponsor_types', $sponsor_types);

define('NON_HEALTH_STREAM_COSTSHARING_PAIMENT_YEARLY_FROM_2012_EC', 8692.75);
define('HEALTH_SCIENCES_COLLEGE_ID', 3);

// length of the generated password for students and staffs, default is 5, can be changed to 6 or more if needed
define('GENERATE_PASSWORD_LENGTH', 5); 

// minimum username length for staffs, default is 3, can be changed to 4 or more if needed, for student it is their student number by default, so, it is not needed to change for students.
define('MINIMUM_USERNAME_LENGTH', 3);
define('MAXIMUM_USERNAME_LENGTH', 20);

// to allow space character in username
define('ALLOW_SPACE_IN_USERNAME', 0); // 0: don't allow, 1: allow

$allowedCharsInUsername = 'A-Za-z0-9\/\-\._@'; // Allows letters, digits, / - _ . @ characters

if (ALLOW_SPACE_IN_USERNAME) {
    $allowedCharsInUsername .= '\s'; // add space optional character if setting allows
}

$usernameRegexPattern = '/^[A-Za-z][' . $allowedCharsInUsername . ']{' . (MINIMUM_USERNAME_LENGTH - 1) . ',' . (MAXIMUM_USERNAME_LENGTH - 1) . '}$/';

define('USERNAME_REGEX', $usernameRegexPattern);



##############################################  STUDENT ID FORMAT FOR ID GENERATION AND SEARCH REGEX ############################################ 

// Program type shortname position for department unassigned students 
define('PROGRAM_TYPE_AFTER_COLLEGE_SHORT_NAME_FOR_DEPARTMENT_UNASSIGNED', 1); // to use NSR instead of RNS for freshman only.

// Student ID prefix
define('MINIMUM_STUDENT_ID_PREFIX_LENGTH', 2); // shortest college short name LS (Law School) plus admission type, R: Regular, EV: for Evening, S: for summer, PT; for Partime, D: for Distance etc.  Example Student ID Prefix: RLS
define('MAXIMUM_STUDENT_ID_PREFIX_LENGTH', 5); // longest & maximum possible College shortname 4 (AMIT) plus admission type, EV: for Evening, PT; for Partime etc.  Example Student ID longest Prefix: EVAMIT 

// applicable for transfered students from other departments
define('ADDITIONAL_STUDENT_ID_PREFIX_LENGTH', 1); // for transferd students MAXIMUM_STUDENT_ID_PREFIX_LENGTH and T letter

// Student ID length
define('MINIMUM_STUDENT_ID_DIGITS_LENGTH', 3); // 001
define('MAXIMUM_STUDENT_ID_DIGITS_LENGTH', 4); // 0001

// Student ID Suffix
define('STUDENT_ID_BATCH_YEAR_LENGTH', 2); // YY format in Ethiopian Calendar


// Student ID separator
define('STUDENT_ID_SEPARATOR', '/');  // that separates student id prefix, student id number and student id suffix 
define('MINIMUM_STUDENT_ID_SEPARATOR_COUNT', 2);  // separating ID prefix(program type + college shortname), student ID(3-4 digits) and batch year suffix(2 digits YY format in Ethiopian Calendar)
define('MAXIMUM_STUDENT_ID_SEPARATOR_COUNT', 3); // specially for transfered students from other universities RAMIT/T/0001/15, NSR/T/004/17


$minimimStudentIdNumberLength = MINIMUM_STUDENT_ID_PREFIX_LENGTH + MINIMUM_STUDENT_ID_DIGITS_LENGTH + STUDENT_ID_BATCH_YEAR_LENGTH + MINIMUM_STUDENT_ID_SEPARATOR_COUNT;
$maximumStudentIdNumberLength = MAXIMUM_STUDENT_ID_PREFIX_LENGTH + ADDITIONAL_STUDENT_ID_PREFIX_LENGTH + MAXIMUM_STUDENT_ID_DIGITS_LENGTH + STUDENT_ID_BATCH_YEAR_LENGTH + MAXIMUM_STUDENT_ID_SEPARATOR_COUNT; 


define('MINIMUM_STUDENT_ID_NUMBER_LENGTH', $minimimStudentIdNumberLength); // considering shortest school prefxi RLS/001/17
define('MAXIMUM_STUDENT_ID_NUMBER_LENGTH', $maximumStudentIdNumberLength); // considerations NSR/T/AM/14/245: existing wiered students issued by registrar

define('MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB', 20); // the maximum allowed studentnumber length set on database. used for validationg existing student ID numbers that migth not satisfy regex or above MAXIMUM_STUDENT_ID_NUMBER_LENGTH

// whether to enforce or not the rules when importing students from excel or generating IDs
define('ENFORCE_MINIMUM_STUDENT_ID_NUMBER_LENGTH_ON_IMPORTING_STUDENTS', 1);
define('ENFORCE_MAXIMUM_STUDENT_ID_NUMBER_LENGTH_ON_IMPORTING_STUDENTS', 1);


// Application Deployed Country and City 
Configure::write('ApplicationName', 'Student Information System');
Configure::write('ApplicationShortName', 'SIS');
Configure::write('ApplicationVersion', '2.0');
Configure::write('ApplicationVersionShort', '2');

Configure::write('ApplicationMetaDescription', 'Yekatit 12 Hosptial Medical College Student 
 Information System portal for teachers and students for academic transparency');
Configure::write('ApplicationMetaKeywords', 'Y12HMC, SIS, Addis Ababa, Yekatit 12, College, Grade, Report,
 Registration, Acadamic, Calendar, online, Admission, Official, Transcript,');
Configure::write('ApplicationMetaAuthor', 'Y12HMC');
Configure::write('ApplicationTitleExtra', 'Yekatit 12 Hospital Medical College Student  Information System');

Configure::write('CompanyName', 'Yekatit 12 Hospital Medical College');
Configure::write('CompanyShortName', 'Y12HMC');
Configure::write('CompanyEstablishedYear', 1923);

Configure::write('CompanyAmharicName', 'የካቲት 12 ሆስፒታል ሜዲካል ኮሌጅ');

Configure::write('logo','logo.png');
Configure::write('ApplicationDeployedCountryAmharic', 'ኢትዮጵያ');
Configure::write('ApplicationDeployedCountryEnglish', 'Ethiopia');
Configure::write('ApplicationDeployedCityAmharic', 'አዲስ አበባ');
Configure::write('ApplicationDeployedCityEnglish', 'Addis Ababa');
Configure::write('CopyRightCompany', 'Yekatit 12 Hospital Medical College');
Configure::write('POBOX', 21);


Configure::write('Tel', '+251-468-810772');
Configure::write('Fax', '+251-468-810729/0820');

Configure::write('RegistrarName', 'Registrar and Alumni Directorate');
//Configure::write('RegistrarAmharicName', 'ሬጅስትራርና የቀድሞ ተማሪዎች ዳይሬክቶሬት');
Configure::write('RegistrarAmharicName', 'ሬጅስትራርና አሉምናይ ዳይሬክቶሬት');

// Standard date format, currently Year - month - day
Configure::write('Calendar.dateFormat', 'DMY');
Configure::write('Calendar.yearFormat', 'Y');

// SMIS date format, used instead of the above
Configure::write('SMISdateFormat', 'd-M-y');

// SMIS currency format 
Configure::write('SMIScurrency','&ETB;');

// SMISunit like % 
Configure::write('SMISunit','&#37;');

// Graduation work names

$graduation_work['thesis'] = 'Thesis';
$graduation_work['project'] = 'Project';

Configure::write('Graduation.graduation_work', $graduation_work);

/** Disable ACL with a flag. */

// Configure::write('ACL.disabled', false);
// Configure::write('Developer', false);
Configure::write('Developer', true);
Configure::write('NumberProcessAllowedToRunProfile', 3);

#Wonde Web service url for accessing wimis from smis
define ('BASE_URL','http://sis.y12hmc.edu.et/');

//for forget password url construction
Configure::write('SMIS.url', 'sis.y12hmc.edu.et');
define ('SITE_NAME', 'Yekatit 12 Hospital Medical College Student Information System');

/** Default email headers */

$email_default_from = 'SIS <noreply@y12hmc.edu.et>';
$email_default_reply_to = 'sis@y12hmc.edu.et';
$email_default_return_path = 'sis@y12hmc.edu.et';
$email_default_to = 'sis@y12hmc.edu.et';
$email_test_to = 'wonde74@gmail.com';

Configure::write('Email.default.from', $email_default_from );
Configure::write('Email.default.replyTo', $email_default_reply_to);
Configure::write('Email.default.returnPath', $email_default_return_path);
Configure::write('Email.default.to', $email_default_to);
Configure::write('Email.test.to', $email_test_to);

define( 'EMAIL_DEFAULT_FROM', $email_default_from);
define( 'EMAIL_DEFAULT_REPLY_TO', $email_default_reply_to);
define( 'EMAIL_DEFAULT_RETURN_PATH', $email_default_return_path);
define( 'EMAIL_DEFAULT_TO', $email_default_to);
define( 'EMAIL_TEST_TO', $email_test_to);

/** End Default email headers */

/** Statuses for the request communications and system modules. */
define( 'STATUS_CREATED', 'STATUS_CREATED');
define( 'STATUS_UPDATED', 'STATUS_UPDATED');
define( 'STATUS_SENT', 'STATUS_SENT' );

/**Roles ID can be used for quick reference in the code ***/
/** Main Role IDs, for quick reference in the code: */
define('ROLE_SYSADMIN', 1);
define('ROLE_INSTRUCTOR', 2);
define('ROLE_STUDENT', 3);
define('ROLE_REGISTRAR', 4);
define('ROLE_COLLEGE', 5);
define('ROLE_DEPARTMENT', 6);
define('ROLE_MEAL', 7);
define('ROLE_HEALTH', 8);
define('ROLE_ACCOMODATION', 9);
define('ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM', 10);
define('ROLE_GENERAL', 11);
define('ROLE_CLEARANCE', 12);
define('ROLE_ALUMNI', 13);
define('ROLE_MANAGEMENT', 14);

/**Program Types ***/
define('PROGRAM_TYPE_REGULAR', 1);
define('PROGRAM_TYPE_EVENING', 2);
define('PROGRAM_TYPE_SUMMER', 3);
define('PROGRAM_TYPE_ADVANCE_STANDING', 4);
define('PROGRAM_TYPE_PART_TIME', 5);
define('PROGRAM_TYPE_DISTANCE', 6);
define('PROGRAM_TYPE_ON_LINE', 7);
define('PROGRAM_TYPE_WEEKEND', 8);
define('PROGRAM_TYPE_EXCHANGE', 9);
define('PROGRAM_TYPE_DAY_TIME_EXTENSION', 10);


/**Program  ***/
define('PROGRAM_UNDEGRADUATE',1);
define('PROGRAM_POST_GRADUATE',2);
define('PROGRAM_PhD',3);
define('PROGRAM_PGDT',4);
define('PROGRAM_REMEDIAL',5);

/**PLACEMENT ASSIGMENT VARIABLES*/
define('AUTO_PLACEMENT','AUTO PLACED');
define('DIRECT_PLACEMENT','DIRECT PLACED');
define('MANUAL_PLACEMENT','MANUAL PLACED');
define('REGISTRAR_ASSIGNED','REGISTRAR PLACED');
define('CANCELLED_PLACEMENT','CANCELLED PLACEMENT');

// include(APP.'Plugin/media/config/core.php');
//Configure::write('e', '2016-10-28');

//// PLACEMENT RELATED SETTINGS

define('ACY_BACK_FOR_PLACEMENT', 1); // Default: 1, Set 0 or empty for currenct accademic year only

define('DEFAULT_MINIMUM_CGPA_FOR_PLACEMENT', 1.67);
define('DEFAULT_MAXIMUM_CGPA_FOR_PLACEMENT', 4.00);


//conversion constant
define('PREPARATORYMAXIMUM', 700);
define('FRESHMANMAXIMUM', 4);
define('ENTRANCEMAXIMUM', 30);

// can be changed accourdingly for each batch maximums set by MoE
define('SOCIAL_STREAM_PREPARATORY_MAXIMUM', 600);
define('NATURAL_STREAM_PREPARATORY_MAXIMUM', 700);


define('INCLUDE_FEMALE_AFFIRMATIVE_POINTS_FOR_PLACEMENT_BY_DEFAULT', 1); // Default: 1, Set 0 or empty to not use Female weight unless explicity defined in placement additional points.
define('DEFAULT_FEMALE_AFFIRMATIVE_POINTS_FOR_PLACEMENT', 5);

define('DEFAULT_FRESHMAN_RESULT_PERCENT_FOR_PLACEMENT', 50);
define('DEFAULT_PREPARATORY_RESULT_PERCENT_FOR_PLACEMENT', 20);
define('DEFAULT_DEPARTMENT_ENTRANCE_RESULT_PERCENT_FOR_PLACEMENT', 30);

// check curriculums under departments for program/program type with program modality and expect curriculums to be associated to DEPARTMENT STUDY PROGRAMS
// firter outs departments that have the selected program type by comparing program modality with program type.
define('CHECK_STUDY_PROGRAMS_FOR_ACADEMIC_CALENDAR_DEFINITION', 1); 

define('REQUIRE_STUDY_PROGRAMS_SELECTED_FOR_CURRICULUM_DEFINITION', 1); // Make Selection of Study Programs Mandatory while adding and editing curriculums

define('REQUIRE_STUDY_PROGRAMS_SELECTED_FOR_CURRICULUM_APPROVAL', 1); // Make Study Programs Mandatory while approving curriculums and make appropraite error message

define('REQUIRE_CURRICULUM_PDF_UPLOAD_FOR_CURRICULUM_DEFINITION', 1);  // Make curriculum PDF upload mandatory while adding or editing curriculums
define('REQUIRE_CURRICULUM_PDF_UPLOAD_FOR_CURRICULUM_APPROVAL', 1);  // Make curriculum PDF upload mandatory while approving curriculums and make appropraite error message
define('ALLOW_CURRICULUM_UNLOCKING_FOR_CURRICULUMS_INVOLVED_IN_GRADUATED_STUDENTS', 0);  // default: 0, Make Curriculums unlockable and uneditable if there are graduated students using that curriculum.
define('REGISTRAR_ADMIN_CAN_UNLOCK_CURRICULUMS_INVOLVED_IN_GRADUATED_STUDENTS', 1);  // default: 0, allow registrar admin(director) to unlock curriculums even if there are graduated students using that curriculum. Might be required for some flexibility with justified reseasons to unlock curriculums for modifications

$status_types_for_seach_approvals = ['' => 'All Statuses', '0' => 'Not Processed', '1' => 'Accepted', '-1' => 'Regected'];
Configure::write('status_types_for_seach_approvals', $status_types_for_seach_approvals);


define('REMEDIAL_PROGRAM_NATURAL_COLLEGE_ID', 14);
define('REMEDIAL_PROGRAM_SOCIAL_COLLEGE_ID', 15);

/// Mass Add or Mass Drop Switches

define('ALLOW_PUBLISH_AS_DROP_COURSE_FOR_COLLEGE_ROLE', 1);
define('ALLOW_PUBLISH_AS_DROP_COURSE_FOR_DEPARTMENT_ROLE', 1);

define('ALLOW_PUBLISH_AS_ADD_COURSE_FOR_COLLEGE_ROLE', 1);
define('ALLOW_PUBLISH_AS_ADD_COURSE_FOR_DEPARTMENT_ROLE', 1);

/// END Mass Add or Mass Drop Switches

define('MAXIMUM_ALLOWED_ATTENDED_SEMESTERS_FOR_TRANSFER', 4); // students that attended more than this value will not have the ability to request department transfer;

$only_stream_based_colleges_pre_social_natural = ['14' => '14', '15' => '15', '16' => '16'];
Configure::write('only_stream_based_colleges_pre_social_natural', $only_stream_based_colleges_pre_social_natural);

$placement_rounds = ['1' => '1', '2' => '2', '3' => '3'];
Configure::write('placement_rounds', $placement_rounds);

$programs_available_for_registrar_college_level_permissions = [ PROGRAM_UNDEGRADUATE => PROGRAM_UNDEGRADUATE, PROGRAM_REMEDIAL => PROGRAM_REMEDIAL];
Configure::write('programs_available_for_registrar_college_level_permissions', $programs_available_for_registrar_college_level_permissions);

$program_types_available_for_registrar_college_level_permissions = [ PROGRAM_TYPE_REGULAR => PROGRAM_TYPE_REGULAR, PROGRAM_TYPE_ADVANCE_STANDING => PROGRAM_TYPE_ADVANCE_STANDING, PROGRAM_TYPE_DAY_TIME_EXTENSION => PROGRAM_TYPE_DAY_TIME_EXTENSION];
Configure::write('program_types_available_for_registrar_college_level_permissions', $program_types_available_for_registrar_college_level_permissions);

$programs_available_for_placement_preference = [ PROGRAM_UNDEGRADUATE => PROGRAM_UNDEGRADUATE];
Configure::write('programs_available_for_placement_preference', $programs_available_for_placement_preference);

$program_types_available_for_placement_preference = [ PROGRAM_TYPE_REGULAR => PROGRAM_TYPE_REGULAR, PROGRAM_TYPE_ADVANCE_STANDING => PROGRAM_TYPE_ADVANCE_STANDING, PROGRAM_TYPE_PART_TIME => PROGRAM_TYPE_PART_TIME, PROGRAM_TYPE_DAY_TIME_EXTENSION => PROGRAM_TYPE_DAY_TIME_EXTENSION];
Configure::write('program_types_available_for_placement_preference', $program_types_available_for_placement_preference);

define('FORCE_EMAIL_VERIFICATION', 1);
define('FORCE_EMAIL_VERIFICATION_ON_UPDATE', 0);
define('FORCE_EMAIL_VERIFICATION_AFTER_LOGIN', 0);
define('FORCE_EMAIL_VERIFICATION_FOR_ALL_ROLES', 0);

define('FORCE_EMAIL_REVALIDATION', 1);
define('DAYS_TO_ENFORCE_EMAIL_REVALIDATION', (DEFAULT_WEEK_COUNT_FOR_ONE_SEMESTER * 7));

$roles_for_email_verification = [ ROLE_INSTRUCTOR => ROLE_INSTRUCTOR, ROLE_STUDENT => ROLE_STUDENT, ROLE_REGISTRAR => ROLE_REGISTRAR, ROLE_COLLEGE => ROLE_COLLEGE, ROLE_DEPARTMENT =>ROLE_DEPARTMENT];
Configure::write('roles_for_email_verification', $roles_for_email_verification);


define('TICKET_TOKEN_EXPIRATION_TIME_IN_HOURS', 0.25); // 0.25 = 15 minutes, 0.5 = 30 minutes,  1 = 1 hour, 2 = 2 hours, etc


/**Service Wings  ***/
define('SERVICE_WING_ACADEMICIAN', 1);
define('SERVICE_WING_LIBRARIAN', 2);
define('SERVICE_WING_REGISTRAR', 3);
define('SERVICE_WING_TECHNICAL_SUPPORT', 4);

/**Educations  ***/
define('EDUCATION_DOCTRATE', 1);
define('EDUCATION_MASTERS', 2);
define('EDUCATION_MEDICAL_DOCTOR', 3);
define('EDUCATION_DEGREE', 4);
define('EDUCATION_DIPLOMA', 5);
define('EDUCATION_CERTIFICATE', 6);

/*  eSHE SSS (Student Success Suite) Courses Settings */

// Global setting whether eSHE SSS (Student Success Suite) is enabled
define('ESHE_SSS_COURSE_COMPLETION_CHECKING_ENABLED', 1);

define('ESHE_SSS_COURSE_COMPLETION_STARTED_ACADEMIC_YEAR', '2025/26');
define('ESHE_SSS_COURSE_COMPLETION_STARTED_ETHIOPIAN_ACADEMIC_YEAR', '2018');
define('ESHE_SSS_COURSE_COMPLETION_STARTED_SEMESTER', 'I');

define('SHOW_ESHE_SSS_COURSE_COMPLETION_REMINDER', 1);
define('DEFAULT_ESHE_SSS_COURSES_TO_COMPLETE', 7);
define('DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE', 80);
define('ESHE_SSS_COURSE_COMPLETION_REMINDER_FOOTER', 'e-Learning Management Unit (eLMU)');
define('ESHE_WEB_URL', 'https://courses.amu.edu.et');
define('ESHE_PASSWORD_RESET_REQUEST_FORM', 'https://forms.cloud.microsoft/r/jR5fZJddMn');

$programs_to_enforce_eshe_sss_course_completion = array();
$program_types_to_exclude_enforcing_eshe_sss_course_completion = array();


if (SHOW_ESHE_SSS_COURSE_COMPLETION_REMINDER == 1 || ESHE_SSS_COURSE_COMPLETION_CHECKING_ENABLED == 1) {
	$programs_to_enforce_eshe_sss_course_completion = [ PROGRAM_UNDEGRADUATE => PROGRAM_UNDEGRADUATE];
	$program_types_to_exclude_enforcing_eshe_sss_course_completion = [ PROGRAM_TYPE_SUMMER => PROGRAM_TYPE_SUMMER, PROGRAM_TYPE_DISTANCE => PROGRAM_TYPE_DISTANCE];
}

Configure::write('programs_to_enforce_eshe_sss_course_completion', $programs_to_enforce_eshe_sss_course_completion);
Configure::write('program_types_to_exclude_enforcing_eshe_sss_course_completion', $program_types_to_exclude_enforcing_eshe_sss_course_completion);


/*  END eSHE SSS (Student Success Suite) Courses Settings */

/* Exit Remedia Exam Result on nav bar without login  */
define('SHOW_EXAM_RESULTS_ON_NAV_BAR', 0);
define('SHOW_REMEDIAL_RESULT_CHECK_LINK', 0);
define('REMEDIAL_RESULT_CHECK_URL', '/pages/check_remedial_result');

$show_new_notification_as_pulse = 0;
$exam_results_nav_bar_item_count = 0;

if (SHOW_EXAM_RESULTS_ON_NAV_BAR == 1) {
	if (SHOW_REMEDIAL_RESULT_CHECK_LINK == 1) {
		$exam_results_nav_bar_item_count++;
		if ($show_new_notification_as_pulse == 0) {
			//$show_new_notification_as_pulse = 1;
		}
	}
}

define('SHOW_NEW_PULSE_NOTIFICATION', $show_new_notification_as_pulse);
define('EXAM_RESULTS_NAV_BAR_ITEM_COUNT', $exam_results_nav_bar_item_count);



/* Show Campus Placement on nav bar without login  */
define('SHOW_CAMPUS_PLACEMENTS_ON_NAV_BAR', 0);
define('SHOW_CAMPUS_PLACEMENT_CHECK_LINK', 0);
define('CAMPUS_PLACEMENT_CHECK_URL', '/pages/check_campus_placement');

$show_new_notification_as_pulse = 1;
$campus_placement_nav_bar_item_count = 0;

if (SHOW_CAMPUS_PLACEMENTS_ON_NAV_BAR == 1) {
	if (SHOW_CAMPUS_PLACEMENT_CHECK_LINK == 1) {
		$campus_placement_nav_bar_item_count++;
		if ($show_new_notification_as_pulse == 0) {
			$show_new_notification_as_pulse = 1;
		}
	}
}

//define('SHOW_NEW_PULSE_NOTIFICATION', $show_new_notification_as_pulse);
define('CAMPUS_PLACEMENT_NAV_BAR_ITEM_COUNT', $campus_placement_nav_bar_item_count);

// Telebirr

CakePlugin::routes();

Configure::write('Telebirr.AppID', '284383bfbb504e8b9dd9984ef1a21e0a');
Configure::write('Telebirr.AppKey', '907233aadf6445da801c547cc8e7d338');
Configure::write('Telebirr.PublicKey',
    'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2pftcaTITZ/4scQOM52ls/4Wu1Jd613Gbci94lxYy9sP2Ez772ZXIijWjlb8vR+25ybMSax7jGNDnDB8/rMB9EC7OpPHrft/zByq9K9Gm/ARUDM0Iv+Z3g8nQA3yul0MeZGqKhs1uXpa4YwXWCAK/gKMfSLb8WM98m5wdkl4Yykk07pxIwoWDW36tiUzT4pVbAbEBZ10OIA0Ox0ZXgmlRtZXHUdmb/k9aoF73a1dWv+dLCDydRs6g2H8lttXc/1cDbsqozJuqXH2HxaiMy7bRUb+0Nti1agEk3tlLYEQvRtAf8AKZzER7Zy9wLy8fAZEsgqz3mmeroEs139C+PH5owIDAQAB');

Configure::write('Telebirr.shortcode', '513156'); //Telebirr.shortcode
Configure::write('Telebirr.receiver', 'Yekatit 12 Hospital Medical College');
Configure::write('Telebirr.Api', 'https://app.ethiomobilemoney.et:2121/ammapi/payment/service-openup/toTradeWebPay');
Configure::write('Telebirr.ReturnUrl', 'https://smis.amu.edu.et/invoices/');
Configure::write('Telebirr.NotifyUrl', Router::url('/invoices/payment_callback', true));
Configure::write('DefaultServicePaymentForAny', 500);
