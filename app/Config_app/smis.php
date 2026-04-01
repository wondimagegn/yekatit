<?php

Configure::write('Utility.backupPath', 
	'/var/www/sisy/app/backup/');
Configure::write('Utility.cache', '/var/www/sisy/app/tmp/cache');

Configure::write('Utility.command',"/var/www/sisy/lib/Cake/Console/cake -app /var/www/sisy/app backup");

/*
The following equivalentACL is used to automatically give privilege for false controllers index or other action if any of sub menu privilege is enabled. Even if it is primarily designed for false controllers, it can be used for other controllers. The checking is taken place @ cake/libs/controller/components/acl.php line 268 - 310 (DbAcl class check() function). Make sure that you use capitalized controller name.
*/
//To give privilege if any of the given controller action is enabled, use     Controller/*    syntax
//To give privilege if only specific action is granted, use      Controller/action     syntax
$equivalentACL = 
array(
	'Graduation/index' =>
		array(
			'GraduationStatuses/*',
			'GraduateLists/*',
			'SenateLists/*',
			'Certificates/*',
			'GraduationLetters/*',
			'GraduationCertificates/*',
			'GraduationWorks/*',
			'ExamGrades/student_copy',
			
		),
	'Certificates/index' =>
		array(
			'ExamGrades/student_copy'
		),
	'Placement/index' =>
		array(
			//'AcceptedStudents/*',
			'ReservedPlaces/*',
			'PlacementsResultsCriterias/*',
			/*'Students/index',
			'Students/admit_all',
			'Students/admit',
			*/
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
			'Students/admit',
			'PracticumeAssignments/*',
			'PracticumeStations/*',
			'PracticumePreferences/*'
			
		),
	'AcceptedStudents/index' =>
		array(
			'Students/index',
			'Students/admit_all',
			'Students/admit'
		),
	'Dormitory/index'=>array(
	        'DormitoryBlocks/*',
	        'DormitoryAssignments/*'
	),
	
	'MealService/index'=>array(
	        'MealHalls/*',
	        'MealHallAssignments/*',
	        'MealAttendances/*',
	        'MealTypes/*'
	),
	'Transfers/index'=>array(
	        'ProgramTypeTransfers/*',
	        'DepartmentTransfers/*'
	),
	/// false controller of schedule 
	'Schedule/index'=>array(
	        'CourseSchedule/*',
	        'ExamSchedule/*',
	        'ClassRoomBlocks/*',
	        'ScheduleSetting/*',
	        'Attendances/*'
	),
	'Evalution/index'=>array(
	        'InstructorEvalutionQuestions/*',
	        'InstructorEvalutionSettings/*',
	        'ColleagueEvalutionRates/*',
	        'StudentEvalutionRates/*',
	        'ContinuousAssessment/*'
	),
	'CourseSchedule/index'=>array(
	        'CourseConstraint/*',
	        'PublishedCourses/add_course_session'
	),
	'CourseConstraint/index'=>array(
	        'ClassPeriodCourseConstraints/*',
	        'ClassRoomClassPeriodConstraints/*',
	        'ClassRoomCourseConstraints/*',
	        'InstructorClassPeriodCourseConstraints/*'
	),
	'ExamSchedule/index'=>array(
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
	'ExamConstraint/index'=>array(
	    'CourseExamGapConstraints/*',
	    'CourseExamConstraints/*',
	    'ExamRoomConstraints/*',
	    'ExamRoomCourseConstraints/*',
	    'InstructorExamExcludeDateConstraints/*',
	    'InstructorNumberOfExamConstraints/*',
	),
	'ScheduleSetting/index'=>array(
	    'ClassPeriods/*',
	    'PeriodSettings/*',
	),
	'Registrations/index'=>array(
	      'CourseAdds/*',
	      'CourseExemptions/*',
	      'CourseDrops/*',
	      'CourseSubstitutionRequests/*',
	      'CourseRegistrations/*'
	),
	'Security/index'=>array(
	        'Users/*',
	        'Logs/*',
	        'Securitysettings/*',
	        'Staffs/*'
	),
	
	'MainDatas/index' =>array(
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
		'EquivalentCourses/*'
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
);
Configure::write('ACL.equivalentACL', $equivalentACL);

/*
Excluded controllers from the ACL management.
It will be used when:
	1. Controller is a false controller with out any action
	2. Controller on which any user should not has any access right. E.G. Role management
*/
//To exclude one action from one controller, use     Controller/action     syntax
//To exclude controller, use     Controller    syntax
//To exclude the given action from all controllers, use     */action    syntax
$excludedACL = 
array(
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
    'PublishedCourses/college_publish_course',
    'PublishedCourses/college_unpublish_course',
    'PublishedCourses/get_course_grade_stats',
    'Curriculums/get_courses',
    'Curriculums/get_curriculums',
    'Curriculums/get_curriculum_combo',
    'Curriculums/search',
	'Sections/export',
	'Sections/edit',
	'Certificates/*',
	//'Sections/section_move_update',
	//'Sections/section_move_update',
	'Sections/view_pdf',
	'Sections/deleteStudentforThisSection',
	'Sections/un_assigned_summeries',
	'Sections/get_sections_by_dept_data_entry',
	'Sections/get_sections_by_year_level',
	'Sections/move',
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
   //'Roles/edit',
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
    
   // 'CostShares/*',
   // 'CostSharingPayments/*',
    
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
	// 'ExamResults/get_exam_result_entry_form', //Remove "get_exam_result_entry_form" action from "ExamResults" controller
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
	'Preferences/*',
	'PreferenceDeadlines/*',
	'ReservedPlaces/*',
	'ParticipatingDepartments/*',
	'PlacementsResultsCriterias/*',
	'ExamTypes/college_exam_type_mgt_for_instructor',
	'Attendances/freshman_view_attendance',

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
	'ExamGradeChanges/freshman_makeup_exam_result',
	'ExamGradeChanges//manage_freshman_grade_change',
	'ExamGrades/approve_freshman_grade_submission',
	'ExamGrades/freshman_grade_view',
	'ExamTypes/college_exam_type_mgt_for_instructor',

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
	'Curriculums/deleteCourseCategory',
	'Curriculums/get_course_category_combo',
	'*/autocomplete', //Remove "autocomplete" from all controllers
);
Configure::write('ACL.excludedACL', $excludedACL);


/** When entering dates for objects like 'expected graduated date', show only
 * a limited range of years:
 */
 
//Login page background
//1. Library
$login_page_background[0]['1366_768'] = '1-1280-800.jpg';
$login_page_background[0]['1280_800'] = '1-1280-800.jpg';
$login_page_background[0]['1280_768'] = '1-1280-768.jpg';
$login_page_background[0]['1280_720'] = '1-1280-720.jpg';
$login_page_background[0]['1024_768'] = '1-1024-768.jpg';
$login_page_background[0]['800_600'] = '1-800-600.jpg';
//2. Zebra
$login_page_background[1]['1366_768'] = '2-1280-800.jpg';
$login_page_background[1]['1280_800'] = '2-1280-800.jpg';
$login_page_background[1]['1280_768'] = '2-1280-768.jpg';
$login_page_background[1]['1280_720'] = '2-1280-720.jpg';
$login_page_background[1]['1024_768'] = '2-1024-768.jpg';
$login_page_background[1]['800_600'] = '2-800-600.jpg';
//3. Pelican
$login_page_background[2]['1366_768'] = '3-1366-768.jpg';
$login_page_background[2]['1280_800'] = '3-1280-800.jpg';
$login_page_background[2]['1280_768'] = '3-1280-768.jpg';
$login_page_background[2]['1280_720'] = '3-1280-720.jpg';
$login_page_background[2]['1024_768'] = '3-1024-768.jpg';
$login_page_background[2]['800_600'] = '3-800-600.jpg';
//4. Pelican 2
$login_page_background[3]['1366_768'] = '4-1366-768.jpg';
$login_page_background[3]['1280_800'] = '4-1280-800.jpg';
$login_page_background[3]['1280_768'] = '4-1280-768.jpg';
$login_page_background[3]['1280_720'] = '4-1280-720.jpg';
$login_page_background[3]['1024_768'] = '4-1024-768.jpg';
$login_page_background[3]['800_600'] = '4-800-600.jpg';

$login_page_background[4]['1366_768'] = '5-1366-768.jpg';
$login_page_background[4]['1280_800'] = '5-1280-800.jpg';
$login_page_background[4]['1280_768'] = '5-1280-768.jpg';
$login_page_background[4]['1280_720'] = '5-1280-720.jpg';
$login_page_background[4]['1024_768'] = '5-1024-768.jpg';
$login_page_background[4]['800_600'] = '5-800-600.jpg';

$login_page_background[5]['1366_768'] = '6-1366-768.jpg';
$login_page_background[5]['1280_800'] = '6-1280-800.jpg';
$login_page_background[5]['1280_768'] = '6-1280-768.jpg';
$login_page_background[5]['1280_720'] = '6-1280-720.jpg';
$login_page_background[5]['1024_768'] = '6-1024-768.jpg';
$login_page_background[5]['800_600'] = '6-800-600.jpg';

$login_page_background[6]['1366_768'] = '7-1366-768.jpg';
$login_page_background[6]['1280_800'] = '7-1280-800.jpg';
$login_page_background[6]['1280_768'] = '7-1280-768.jpg';
$login_page_background[6]['1280_720'] = '7-1280-720.jpg';
$login_page_background[6]['1024_768'] = '7-1024-768.jpg';
$login_page_background[6]['800_600'] = '7-800-600.jpg';

$login_page_background[7]['1366_768'] = '8-1366-768.jpg';
$login_page_background[7]['1280_800'] = '8-1280-800.jpg';
$login_page_background[7]['1280_768'] = '8-1280-768.jpg';
$login_page_background[7]['1280_720'] = '8-1280-720.jpg';
$login_page_background[7]['1024_768'] = '8-1024-768.jpg';
$login_page_background[7]['800_600'] = '8-800-600.jpg';

$login_page_background[8]['1366_768'] = '9-1366-768.jpg';
$login_page_background[8]['1280_800'] = '9-1280-800.jpg';
$login_page_background[8]['1280_768'] = '9-1280-768.jpg';
$login_page_background[8]['1280_720'] = '9-1280-720.jpg';
$login_page_background[8]['1024_768'] = '9-1024-768.jpg';
$login_page_background[8]['800_600'] = '9-800-600.jpg';

$login_page_background[9]['1366_768'] = '10-1366-768.jpg';
$login_page_background[9]['1280_800'] = '10-1280-800.jpg';
$login_page_background[9]['1280_768'] = '10-1280-768.jpg';
$login_page_background[9]['1280_720'] = '10-1280-720.jpg';
$login_page_background[9]['1024_768'] = '10-1024-768.jpg';
$login_page_background[9]['800_600'] = '10-800-600.jpg';

Configure::write('Image.login_background', $login_page_background);


//Rename ACL generated menu by humanized name suitable to the application
//$rename_menu_title['courseRegistrations']='Registration';
$rename_menu_title['registrations']='Registration';
$rename_menu_title['payments'] = 'Billing';

$rename_menu_title['colleges'] = 'Stream';
$rename_menu_title['universities'] = 'Colleges';


//$rename_menu_title['securitysettings']='Security Setting';
$rename_menu_title['securitysettings']= 'Security';
$rename_menu_title['students']= 'Admitted Students';
$rename_menu_title['mainDatas']= 'Main Data ';
$rename_menu_title['evalution']="Evaluation";

$rename_menu_title['examTypes']='Exam Setup';
$rename_menu_title['examResults']='Exam Result & Grade';
$rename_menu_title['courseInstructorAssignments']='Assign Instructors';
$rename_menu_title['graduationLetters']='Letter Template';
$rename_menu_title['graduationCertificates']='Certificate Template';
$rename_menu_title['graduationWorks']='Works';
$rename_menu_title['graduationStatuses']='Statuses';
$rename_menu_title['graduationRequirements']='Requirements';
$rename_menu_title['examGrades']='Grade';
$rename_menu_title['examGradeChanges']='Grade Change';
$rename_menu_title['examResults']='Result & Grade';
$rename_menu_title['makeupExams']='Makeup Exam';
$rename_menu_title['gradeSettings']='Grade Setting';
$rename_menu_title['makeupExams']='Makeup & Supplmentary Exam';
$rename_menu_title['helps']='Help';

$rename_menu_title['sections']='Manage Sections';

$rename_menu_title['colleagueEvalutionRates']='Colleague Evalution';

$rename_menu_title['studentStatusPatterns']='Status Pattern and Determination';

$rename_menu_title['studentEvalutionRates']='Instructor';
$rename_menu_title['courseInstructorAssignments']='Instructor Assignment';
$rename_menu_title['practicumeAssignments']='Practicum Assignments';

$rename_menu_title['practicumeStations']='Practicum Stations';
$rename_menu_title['practicumePreferences']='Practicum Preferences';

		
Configure::write('Menu.title_rename', $rename_menu_title);

Configure::write('Calendar.universityEstablishement', 1900);
Configure::write('Calendar.yearsAhead', 10);
Configure::write('Calendar.yearsInPast', 2);
Configure::write('Calendar.birthdayInPast',60);
Configure::write('Calendar.birthdayAhead',-18);
Configure::write('Calendar.senateApprovalInPast',1);
Configure::write('Calendar.senateApprovalAhead',0);
Configure::write('Calendar.senateListStartYear', 1990);
Configure::write('Calendar.graduateListStartYear', 1990);
Configure::write('Calendar.applicationStartYear',2012);
Configure::write('Calendar.graduateApprovalAhead',0);
Configure::write('Calendar.expectedGraduationInFuture',8);
Configure::write('Calendar.graduateApprovalInPast', 1);

Configure::write('Calendar.clearanceWithdrawInPast',1);
Configure::write('Calendar.clearanceWithdrawInFuture', 0);

Configure::write('Calendar.daysAvaiableForGraduateDeletion', 60);
/***
* Application Deployed Country and City
*/
Configure::write('logo','logo.png');
Configure::write('ApplicationDeployedCountryAmharic', 'ኢትዮጵያ');
Configure::write('ApplicationDeployedCountryEnglish', 'Ethiopia');

Configure::write('ApplicationDeployedCityAmharic', 'አዲሰ  አበባ');
Configure::write('ApplicationDeployedCityEnglish', 'Addis Abeba');

Configure::write('CopyRightCompany', 'Yekatit 12 Hospital Medical College');

/***
* Application Deployed POBOX
*/

Configure::write('POBOX', 257);

/** Standard date format, currently Year - month - day
*/

Configure::write('Calendar.dateFormat', 'DMY');
Configure::write('Calendar.yearFormat', 'Y');

/** SMIS date format, used instead of the above
*/
Configure::write('SMISdateFormat', 'd-M-y');

/**SMIS currency format */
Configure::write('SMIScurrency','&ETB;');
/** SMISunit like % */
Configure::write('SMISunit','&#37;');

//////////////////////////////////////

$graduation_work['thesis']='Thesis';
$graduation_work['project']='Project';


Configure::write('Graduation.graduation_work', $graduation_work);
/** Disable ACL with a flag. */

// Configure::write('ACL.disabled', false);
// Configure::write('Developer', false);
Configure::write('Developer', true);
Configure::write('NumberProcessAllowedToRunProfile', 3);
#Wonde Web service url for accessing wimis from smis
define ('WIMIS_URL','http://wmis.dev/xml_rpc');
define ('BASE_URL','http://sis.y12hmc.edu.et/'); 
#define ('WIMIS_URL','http://wimis.amu.edu.et/xml_rpc');

//for forget password url construction
Configure::write('SMIS.url','sis.y12hmc.edu.et');

/** Default email headers */

Configure::write('Email.default.from', 'SIS <admin@y12hmc.edu.et>');
Configure::write('Email.default.replyTo', 'noreply@y12hmc.edu.et');
Configure::write('Email.default.returnPath', 'smis@y12hmc.edu.et');
Configure::write('Email.default.to', 'smis@y12hmc.edu.et');
Configure::write('Email.test.to', 'wonde74@gmail.com');

/** Statuses for the request communications and system modules. */
define( 'STATUS_CREATED', 'STATUS_CREATED');
define( 'STATUS_UPDATED', 'STATUS_UPDATED');
define( 'STATUS_SENT', 'STATUS_SENT' );
/**Roles ID can be used for quick reference in the code ***/
/** Main Role IDs, for quick reference in the code: */
define('ROLE_INSTRUCTOR', 2);
define('ROLE_STUDENT', 3);

define('ROLE_SYSADMIN', 1);
define('ROLE_REGISTRAR', 4);
define('ROLE_COLLEGE', 5);
define('ROLE_DEPARTMENT', 6);
define('ROLE_MEAL', 7);
define('ROLE_HEALTH', 8);
define('ROLE_ACCOMODATION', 9);
define('ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM', 10);
define('ROLE_GENERAL', 11);
define('ROLE_CLEARANCE', 12);
define('ROLE_MANAGEMENT', 14);

/**Program Types ***/
define('PROGRAM_TYPE_REGULAR',1);
define('PROGRAM_TYPE_EXTENSION',2);
define('PROGRAM_TYPE_SUMMER',3);
define('PROGRAM_TYPE_ADVANCED_STANDING',5);
define('PROGRAM_TYPE_IN_SERVICE',6);

/**Program  ***/
define('PROGRAM_UNDEGRADUATE',1);
define('PROGRAM_POST_GRADUATE',2);

/**PLACEMENT ASSIGMENT VARIABLES*/
define('AUTO_PLACEMENT','AUTO PLACED');
define('DIRECT_PLACEMENT','DIRECT PLACED');
define('MANUAL_PLACEMENT','MANUAL PLACED');
define('REGISTRAR_ASSIGNED','REGISTRAR PLACED');
define('CANCELLED_PLACEMENT','CANCELLED PLACEMENT');
// include(APP.'Plugin/media/config/core.php');
Configure::write('e', '2016-10-28');

?>
