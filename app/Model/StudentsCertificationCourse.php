<?php
class StudentsCertificationCourse extends AppModel
{
	var $name = 'StudentsCertificationCourse';

	/* var $actsAs = array(
		'Containable',
		'Tools.Logable' => array(
			'change' => 'full',
			//'change' => 'list',
			'description_ids' => 'true',
			'displayField' => 'username',
			'foreignKey' => 'foreign_key',
			//'skip' => array('search', 'view'), // functions to skip logging
			'ignore' => array('created', 'modified') // fields to ignore in log
		)
	); */

	var $belongsTo = array(
		'CertificationCourse' => array(
			'className' => 'CertificationCourse',
			'foreignKey' => 'certification_course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		/* 'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		), */
	);

	function checkRequirementSatisfied($student_id = null,  $number_of_courses_to_complete = DEFAULT_ESHE_SSS_COURSES_TO_COMPLETE, $pass_score = DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE,  $certification_course_ids = array()) 
	{
		
		if (empty($student_id) || empty($number_of_courses_to_complete) || empty($certification_course_ids)) {
			return true;
		}

		$student_passed_courses_count = $this->find('count', array(
			'conditions' => array(
				'StudentsCertificationCourse.student_id' => $student_id,
				'StudentsCertificationCourse.certification_course_id' => $certification_course_ids,
				//'StudentsCertificationCourse.score >= ' => $pass_score,
				'StudentsCertificationCourse.status' => 1
			),
			'contain' => array()
		));
		
		if ($student_passed_courses_count && $student_passed_courses_count >= $number_of_courses_to_complete) {
			//requirement satisfied
			return true;
		}

		return false;
	}


	function getStudentCertificationCourseDetails($student_id = null,  $number_of_courses_to_complete = DEFAULT_ESHE_SSS_COURSES_TO_COMPLETE, $pass_score = DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE,  $certification_course_ids = array()) 
	{
		
		if (empty($student_id) || empty($number_of_courses_to_complete) || empty($certification_course_ids)) {
			return array();
		}

		$certificationCourses = $this->CertificationCourse->getCertificationCourses($certification_course_ids, $details = 1);
		//debug($certificationCourses);

		$studentCertificationCourseDetails = $this->find('all', array(
			'conditions' => array(
				'StudentsCertificationCourse.student_id' => $student_id,
				'StudentsCertificationCourse.certification_course_id' => $certification_course_ids,
			),
			'contain' => array(/* 'CertificationCourse' */),
			'order' => array('StudentsCertificationCourse.certification_course_id')
		));


		$studentCertificationCourseResults = array();
		

		if (!empty($certificationCourses)) {

			if (empty($studentCertificationCourseDetails)) {

				foreach ($certificationCourses as $ckey => $c_course) {
					$studentCertificationCourseResults[$ckey]['course'] = $c_course;
					$studentCertificationCourseResults[$ckey]['score'] = NULL;
					$studentCertificationCourseResults[$ckey]['start_date'] = NULL;
					$studentCertificationCourseResults[$ckey]['status'] = '<span class="rejected">Not Started</span>';
					$studentCertificationCourseResults[$ckey]['last_updated'] = NULL;
				}
				
				$studentCertificationCourseResults['startedAtLeastOneCourse'] = false;

				$last_import_date = NULL;

				$last_import_date_array = $this->query('SELECT `modified` FROM `students_certification_courses` ORDER BY `modified` DESC LIMIT 1');
				$modified = Hash::get($last_import_date_array, '0.students_certification_courses.modified');

				if ($modified) {
					$studentCertificationCourseResults['lastImportedDate'] = $modified;
				}

			} else {

				$taken_certification_course_ids = array();
				$passed_certification_course_ids = array();
				$last_import_date_for_student = NULL;

				foreach ($studentCertificationCourseDetails as $ccd_key => $ccd_course) {
					if (in_array($ccd_course['StudentsCertificationCourse']['certification_course_id'], array_keys($certificationCourses))) {
						/// to check which courses from the required courses are taken and to count unique courses in case of duplication while importing from csv
						$taken_certification_course_ids[$ccd_course['StudentsCertificationCourse']['certification_course_id']] = $ccd_course['StudentsCertificationCourse']['certification_course_id'];
						
						if ($ccd_course['StudentsCertificationCourse']['status'] == 1 || (is_numeric($ccd_course['StudentsCertificationCourse']['score']) && $ccd_course['StudentsCertificationCourse']['score'] >= $pass_score)) {
							$passed_certification_course_ids[$ccd_course['StudentsCertificationCourse']['certification_course_id']] = $ccd_course['StudentsCertificationCourse']['certification_course_id'];
						}

						$studentCertificationCourseResults[$ccd_course['StudentsCertificationCourse']['certification_course_id']]['course'] = $certificationCourses[$ccd_course['StudentsCertificationCourse']['certification_course_id']];
						$studentCertificationCourseResults[$ccd_course['StudentsCertificationCourse']['certification_course_id']]['score'] = $ccd_course['StudentsCertificationCourse']['score'];
						$studentCertificationCourseResults[$ccd_course['StudentsCertificationCourse']['certification_course_id']]['start_date'] = (!empty($ccd_course['StudentsCertificationCourse']['start_date']) ? date('M d, Y', strtotime($ccd_course['StudentsCertificationCourse']['start_date'])) : NULL);
						$studentCertificationCourseResults[$ccd_course['StudentsCertificationCourse']['certification_course_id']]['status'] = ($ccd_course['StudentsCertificationCourse']['status'] == 1 ? '<span class="accepted">Completed</span>' : (is_numeric($ccd_course['StudentsCertificationCourse']['score']) ? ($ccd_course['StudentsCertificationCourse']['score'] >= $pass_score ? '<span class="accepted">Completed</span>' : '<span class="rejected">Failed</span>') : '<span class="on-process">In progress</span>'));
						$studentCertificationCourseResults[$ccd_course['StudentsCertificationCourse']['certification_course_id']]['last_updated'] = date('M d, Y', strtotime($ccd_course['StudentsCertificationCourse']['modified']));
  
						if (!empty($last_import_date_for_student) && !empty($ccd_course['StudentsCertificationCourse']['modified']) && strtotime($ccd_course['StudentsCertificationCourse']['modified']) > strtotime($last_import_date_for_student)) {
							$last_import_date_for_student = $ccd_course['StudentsCertificationCourse']['modified'];
						} else if (empty($last_import_date_for_student) && !empty($ccd_course['StudentsCertificationCourse']['modified'])) {
							$last_import_date_for_student = $ccd_course['StudentsCertificationCourse']['modified'];
						}
					}
				}


				if (count($taken_certification_course_ids) < count($certificationCourses)) {
					// append not taken courses at the bottom
					foreach ($certificationCourses as $ckey => $c_course) {
						if (!empty($taken_certification_course_ids) && !in_array($ckey, $taken_certification_course_ids)) {
							$studentCertificationCourseResults[$ckey]['course'] = $c_course;
							$studentCertificationCourseResults[$ckey]['score'] = NULL;
							$studentCertificationCourseResults[$ckey]['start_date'] = NULL;
							$studentCertificationCourseResults[$ckey]['status'] = '<span class="rejected">Not Started</span>';
							$studentCertificationCourseResults[$ckey]['last_updated'] = NULL;
						}
					}

					if (count($taken_certification_course_ids)) {
						$studentCertificationCourseResults['startedAtLeastOneCourse'] = true;
					}

					$studentCertificationCourseResults['startedAllRequiredCourses'] = false;

				} else if (count($taken_certification_course_ids) == count($certificationCourses)) {
					$studentCertificationCourseResults['startedAtLeastOneCourse'] = true;
					$studentCertificationCourseResults['startedAllRequiredCourses'] = true;
					if (count($passed_certification_course_ids) == count($certificationCourses)) {
						$studentCertificationCourseResults['tookAllRequiredCoursesWithAllPass'] = true;
					}
				}

				if (count($passed_certification_course_ids)) {
					$studentCertificationCourseResults['completedCourseCount'] = count($passed_certification_course_ids);
				}

				if (!empty($last_import_date_for_student)) {
					$studentCertificationCourseResults['lastImportedUpdated'] = $last_import_date_for_student;
				}
				
			}
		}

		asort($studentCertificationCourseResults);
		//debug($studentCertificationCourseResults);

		return($studentCertificationCourseResults);

	}
}
