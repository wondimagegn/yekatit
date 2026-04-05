<?php
class StudentStatusPattern extends AppModel
{
	var $name = 'StudentStatusPattern';
	
	var $belongsTo = array(
		'Program' => array(
			'className' => 'Program',
			'foreignKey' => 'program_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProgramType' => array(
			'className' => 'ProgramType',
			'foreignKey' => 'program_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function getProgramTypePattern($program_id = null, $program_type_id = null, $acadamic_year = null)
	{
		$status_patterns = $this->find('all', array(
			'conditions' => array(
				'StudentStatusPattern.program_id' => $program_id,
				'StudentStatusPattern.program_type_id' => $program_type_id
			),
			'order' => array('StudentStatusPattern.application_date' => 'ASC'),
			'recursive' => -1
		));

		if (!empty($status_patterns)) {
			$pattern = $status_patterns[0]['StudentStatusPattern']['pattern'];
			$sys_acadamic_year = $status_patterns[0]['StudentStatusPattern']['acadamic_year'];
			//If it is introduced latelly
			if (substr($sys_acadamic_year, 0, 4) > substr($acadamic_year, 0, 4)) {
				return 1;
			} else {
				do {
					foreach ($status_patterns as $key => $status_pattern) {
						if ($sys_acadamic_year == $status_pattern['StudentStatusPattern']['acadamic_year']) {
							$pattern = $status_pattern['StudentStatusPattern']['pattern'];
						}
					}

					if (strcasecmp($acadamic_year, $sys_acadamic_year) != 0) {
						$sys_acadamic_year = (substr($sys_acadamic_year, 0, 4) + 1) . '/' . substr((substr($sys_acadamic_year, 0, 4) + 2), 2, 2);
					} else {
						return $pattern;
					}
				} while ($sys_acadamic_year != '3000/01');
			}
			return $pattern;
		} else {
			return 1;
		}
	}
	
	function isLastSemesterInCurriculum($student_id)
	{
		$minimumPointofCurriculum = ClassRegistry::init('Student')->find('first', array(
			'conditions' => array(
				'Student.id' => $student_id
			), 
			'contain' => array(
				'Curriculum'
			)
		));

		if (!empty($minimumPointofCurriculum) && empty($minimumPointofCurriculum['Student']['curriculum_id'])) {
			return false;
		}

		//debug($minimumPointofCurriculum['Student']['curriculum_id']);

		$last_year_level_id = ClassRegistry::init('Course')->find('list', array('conditions' => array('Course.curriculum_id' => $minimumPointofCurriculum['Student']['curriculum_id']), 'group' => array('Course.year_level_id', 'Course.semester'), 'order' => array('Course.year_level_id' => 'DESC', 'Course.semester' => 'DESC'), 'fields' => array('Course.year_level_id', 'Course.year_level_id'), 'limit' => 1));
		//debug($last_year_level_id);

		$allAdded = ClassRegistry::init('CourseAdd')->find('all', array(
			'conditions' => array(
				'CourseAdd.student_id' => $student_id,
				'CourseAdd.department_approval' => 1,
				'CourseAdd.registrar_confirmation' => 1,
			),
			'contain' => array(
				'PublishedCourse' => array(
					'Course' => array(
						'CourseCategory',
						'Curriculum'
					)
				)
			)
		));

		$allRegistered = ClassRegistry::init('CourseRegistration')->find('all', array(
			'conditions' => array(
				'CourseRegistration.student_id' => $student_id,
			),
			'contain' => array(
				'PublishedCourse' => array(
					'Course' => array(
						'CourseCategory', 
						'Curriculum'
					)
				)
			)
		));

		$check_registered_last_year_level_courses_from_curriculum = ClassRegistry::init('CourseRegistration')->find('count', array(
			'conditions' => array(
				'CourseRegistration.student_id' => $student_id,
				'CourseRegistration.year_level_id' => $last_year_level_id
			)
		));

		//debug($minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');

		if ($check_registered_last_year_level_courses_from_curriculum) {
			//debug($check_registered_last_year_level_courses_from_curriculum);
			
			$lastCreditSum = 0;

			if (!empty($allRegistered)) {
				foreach ($allRegistered as $lk => $lv) {
					if (isset($lv['PublishedCourse']['Course']['credit']) && !empty($lv['PublishedCourse']['Course']['credit'])) {
						$lastCreditSum += $lv['PublishedCourse']['Course']['credit'];
					}
				}
			}

			if (!empty($allAdded)) {
				foreach ($allAdded as $lk => $lv) {
					if (isset($lv['PublishedCourse']['Course']['credit']) && !empty($lv['PublishedCourse']['Course']['credit'])) {
						$lastCreditSum += $lv['PublishedCourse']['Course']['credit'];
					}
				}
			}

			//debug($minimumPointofCurriculum['Curriculum']['minimum_credit_points']);
			//debug($lastCreditSum);

			if ($lastCreditSum >= $minimumPointofCurriculum['Curriculum']['minimum_credit_points']) {
				//debug($minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')' . ' completed minimum required credits & took last year courses from curriculum');
				return true;
			} else {
				//debug($minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')' . ' doesnot completed minimum required credits but took last year courses from curriculum');
			}
		} else {
			//debug($minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')' . ' doesnot took any last year courses from curriculum');
		}

		return false;
	}

	function isEligibleForExitExam($student_id)
	{
		$minimumPointofCurriculum = ClassRegistry::init('Student')->find('first', array(
			'conditions' => array(
				'Student.id' => $student_id
			), 
			'contain' => array(
				'Curriculum'
			)
		));

		if (!empty($minimumPointofCurriculum) && empty($minimumPointofCurriculum['Student']['curriculum_id'])) {
			return false;
		}

		//debug($minimumPointofCurriculum['Student']['curriculum_id']);

		$last_year_level_id = ClassRegistry::init('Course')->find('list', array('conditions' => array('Course.curriculum_id' => $minimumPointofCurriculum['Student']['curriculum_id']), 'group' => array('Course.year_level_id', 'Course.semester'), 'order' => array('Course.year_level_id' => 'DESC', 'Course.semester' => 'DESC'), 'fields' => array('Course.year_level_id', 'Course.year_level_id'), 'limit' => 1));
		$semester_count_of_the_curriculum = ClassRegistry::init('Course')->find('count', array('conditions' => array('Course.curriculum_id' => $minimumPointofCurriculum['Student']['curriculum_id']), 'group' => array('Course.year_level_id', 'Course.semester'), 'order' => array('Course.year_level_id' => 'DESC', 'Course.semester' => 'DESC'), 'fields' => array('Course.year_level_id', 'Course.year_level_id')));
		//debug($last_year_level_id);
		//debug($semester_count_of_the_curriculum);

		$check_registered_last_year_level_courses_from_curriculum = ClassRegistry::init('CourseRegistration')->find('count', array(
			'conditions' => array(
				'CourseRegistration.student_id' => $student_id,
				'CourseRegistration.year_level_id' => $last_year_level_id
			)
		));

		//debug($minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');

		if ($check_registered_last_year_level_courses_from_curriculum) {
			//debug($check_registered_last_year_level_courses_from_curriculum);
			
			$totalRegisteredCredits = ClassRegistry::init('CourseRegistration')->find('first', array(
				'fields' => array('SUM(Course.credit) as total_credits'),
				'conditions' => array(
					'CourseRegistration.student_id' => $student_id
				),
				'joins' => array(
					array(
						'table' => 'published_courses',
						'alias' => 'PublishedCourse1',
						'type' => 'INNER',
						'conditions' => array(
							'PublishedCourse1.id = CourseRegistration.published_course_id'
						)
					),
					array(
						'table' => 'courses',
						'alias' => 'Course',
						'type' => 'INNER',
						'conditions' => array(
							'Course.id = PublishedCourse1.course_id'
						)
					)
				)
			));
			
			//debug($totalRegisteredCredits);
			$totalRegisteredCredits = isset($totalRegisteredCredits[0]['total_credits']) ? $totalRegisteredCredits[0]['total_credits'] : 0; 
			//debug($totalRegisteredCredits);

			$totalAddedCredits = ClassRegistry::init('CourseAdd')->find('first', array(
				'fields' => array('SUM(Course.credit) as total_credits'),
				'conditions' => array(
					'CourseAdd.student_id' => $student_id,
					//'CourseAdd.department_approval' => 1,
					'CourseAdd.registrar_confirmation' => 1,
				),
				'joins' => array(
					array(
						'table' => 'published_courses',
						'alias' => 'PublishedCourse1',
						'type' => 'INNER',
						'conditions' => array(
							'PublishedCourse1.id = CourseAdd.published_course_id'
						)
					),
					array(
						'table' => 'courses',
						'alias' => 'Course',
						'type' => 'INNER',
						'conditions' => array(
							'Course.id = PublishedCourse1.course_id'
						)
					)
				)
			));

			//debug($totalAddedCredits);
			$totalAddedCredits = (isset($totalAddedCredits[0]['total_credits']) ? $totalAddedCredits[0]['total_credits'] : 0); 
			//debug($totalAddedCredits);

			$totalDroppedCredits = ClassRegistry::init('CourseDrop')->find('first', array(
				'fields' => array('SUM(Course.credit) as total_credits'),
				'conditions' => array(
					'CourseDrop.student_id' => $student_id,
					'CourseDrop.registrar_confirmation' => 1,
				),
				'joins' => array(
					array(
						'table' => 'course_registrations',
						'alias' => 'CourseRegistration1',
						'type' => 'INNER',
						'conditions' => array(
							'CourseRegistration1.id = CourseDrop.course_registration_id'
						)
					),
					array(
						'table' => 'published_courses',
						'alias' => 'PublishedCourse1',
						'type' => 'INNER',
						'conditions' => array(
							'PublishedCourse1.id = CourseRegistration1.published_course_id'
						)
					),
					array(
						'table' => 'courses',
						'alias' => 'Course',
						'type' => 'INNER',
						'conditions' => array(
							'Course.id = PublishedCourse1.course_id'
						)
					)
				)
			));

			//debug($totalDroppedCredits);
			$totalDroppedCredits = (isset($totalDroppedCredits[0]['total_credits']) ? $totalDroppedCredits[0]['total_credits'] : 0); 
			//debug($totalDroppedCredits);

			$totalExemptedCredits = ClassRegistry::init('CourseExemption')->find('first', array(
				'fields' => array('SUM(CourseAlias.credit) as total_credits'),
				'conditions' => array(
					'CourseExemption.student_id' => $student_id,
					'CourseExemption.department_accept_reject' => 1,
					'CourseExemption.registrar_confirm_deny' => 1,
				),
				'joins' => array(
					array(
						'table' => 'courses',
						'alias' => 'CourseAlias',
						'type' => 'INNER',
						'conditions' => array(
							'CourseAlias.id = CourseExemption.course_id'
						)
					)
				)
			));

			//debug($totalExemptedCredits);
			$totalExemptedCredits = (isset($totalExemptedCredits[0]['total_credits']) ? $totalExemptedCredits[0]['total_credits'] : 0); 
			//debug($totalExemptedCredits);
			
			$total_credits = (int) (($totalRegisteredCredits + $totalAddedCredits + $totalExemptedCredits) - $totalDroppedCredits);
			
			//debug($total_credits);

			/* if ($total_credits >= ((int) ($minimumPointofCurriculum['Curriculum']['minimum_credit_points'] * COURSE_PERCENT_TO_COMPLETE_FOR_EXIT_EXAM)))  {
				//debug( 'ELIGIBLE: taken ' . $total_credits . ' '  . $minimumPointofCurriculum['Curriculum']['type_credit'] .  ' : ' . $minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');
				return true;
			} else {
				//debug( 'NOT ELIGIBLE taken ' . $total_credits . ' '  . $minimumPointofCurriculum['Curriculum']['type_credit'] .  ' : '. $minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');
			} */
			
			$minimum_required_credits = (int) $minimumPointofCurriculum['Curriculum']['minimum_credit_points'];
			$credits_expected_per_semester = ($minimum_required_credits / $semester_count_of_the_curriculum);
			$credit_threshold = (($semester_count_of_the_curriculum - 2) * $credits_expected_per_semester);
			$credit_threshold = (int) ceil($credit_threshold);
			
			//debug($credit_threshold);

			if ($total_credits >= $credit_threshold)  {
				//debug( 'ELIGIBLE: taken ' . $total_credits . ' from threshhold filter '  . $credit_threshold . ' value out of  ' . $minimumPointofCurriculum['Curriculum']['minimum_credit_points'] . ' ' . $minimumPointofCurriculum['Curriculum']['type_credit'] .  's ' . $minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');
				return true;
			} else {
				//debug( 'NOT ELIGIBLE taken ' . $total_credits . ' from threshhold filter '  . $credit_threshold . ' value out of  ' . $minimumPointofCurriculum['Curriculum']['minimum_credit_points'] . ' ' . $minimumPointofCurriculum['Curriculum']['type_credit'] .  's ' . $minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');
			}
		}

		return false;
	}

	function isgraduatingClassStudent($student_id)
	{
		$minimumPointofCurriculum = ClassRegistry::init('Student')->find('first', array(
			'conditions' => array(
				'Student.id' => $student_id
			), 
			'contain' => array(
				'Curriculum'
			)
		));

		if (!empty($minimumPointofCurriculum) && empty($minimumPointofCurriculum['Student']['curriculum_id'])) {
			return false;
		}

		//debug($minimumPointofCurriculum['Student']['curriculum_id']);

		$last_year_level_id = ClassRegistry::init('Course')->find('list', array('conditions' => array('Course.curriculum_id' => $minimumPointofCurriculum['Student']['curriculum_id']), 'group' => array('Course.year_level_id', 'Course.semester'), 'order' => array('Course.year_level_id' => 'DESC', 'Course.semester' => 'DESC'), 'fields' => array('Course.year_level_id', 'Course.year_level_id'), 'limit' => 1));
		$semester_count_of_the_curriculum = ClassRegistry::init('Course')->find('count', array('conditions' => array('Course.curriculum_id' => $minimumPointofCurriculum['Student']['curriculum_id']), 'group' => array('Course.year_level_id', 'Course.semester'), 'order' => array('Course.year_level_id' => 'DESC', 'Course.semester' => 'DESC'), 'fields' => array('Course.year_level_id', 'Course.year_level_id')));
		//debug($last_year_level_id);
		//debug($semester_count_of_the_curriculum);

		$check_registered_last_year_level_courses_from_curriculum = ClassRegistry::init('CourseRegistration')->find('count', array(
			'conditions' => array(
				'CourseRegistration.student_id' => $student_id,
				'CourseRegistration.year_level_id' => $last_year_level_id
			)
		));

		if ($check_registered_last_year_level_courses_from_curriculum) {
			//debug($check_registered_last_year_level_courses_from_curriculum);
			
			$totalRegisteredCredits = ClassRegistry::init('CourseRegistration')->find('first', array(
				'fields' => array('SUM(Course.credit) as total_credits'),
				'conditions' => array(
					'CourseRegistration.student_id' => $student_id
				),
				'joins' => array(
					array(
						'table' => 'published_courses',
						'alias' => 'PublishedCourse1',
						'type' => 'INNER',
						'conditions' => array(
							'PublishedCourse1.id = CourseRegistration.published_course_id'
						)
					),
					array(
						'table' => 'courses',
						'alias' => 'Course',
						'type' => 'INNER',
						'conditions' => array(
							'Course.id = PublishedCourse1.course_id'
						)
					)
				)
			));
			
			//debug($totalRegisteredCredits);
			$totalRegisteredCredits = isset($totalRegisteredCredits[0]['total_credits']) ? $totalRegisteredCredits[0]['total_credits'] : 0; 
			//debug($totalRegisteredCredits);

			$totalAddedCredits = ClassRegistry::init('CourseAdd')->find('first', array(
				'fields' => array('SUM(Course.credit) as total_credits'),
				'conditions' => array(
					'CourseAdd.student_id' => $student_id,
					//'CourseAdd.department_approval' => 1,
					'CourseAdd.registrar_confirmation' => 1,
				),
				'joins' => array(
					array(
						'table' => 'published_courses',
						'alias' => 'PublishedCourse1',
						'type' => 'INNER',
						'conditions' => array(
							'PublishedCourse1.id = CourseAdd.published_course_id'
						)
					),
					array(
						'table' => 'courses',
						'alias' => 'Course',
						'type' => 'INNER',
						'conditions' => array(
							'Course.id = PublishedCourse1.course_id'
						)
					)
				)
			));

			//debug($totalAddedCredits);
			$totalAddedCredits = (isset($totalAddedCredits[0]['total_credits']) ? $totalAddedCredits[0]['total_credits'] : 0); 
			//debug($totalAddedCredits);

			$totalDroppedCredits = ClassRegistry::init('CourseDrop')->find('first', array(
				'fields' => array('SUM(Course.credit) as total_credits'),
				'conditions' => array(
					'CourseDrop.student_id' => $student_id,
					'CourseDrop.registrar_confirmation' => 1,
				),
				'joins' => array(
					array(
						'table' => 'course_registrations',
						'alias' => 'CourseRegistration1',
						'type' => 'INNER',
						'conditions' => array(
							'CourseRegistration1.id = CourseDrop.course_registration_id'
						)
					),
					array(
						'table' => 'published_courses',
						'alias' => 'PublishedCourse1',
						'type' => 'INNER',
						'conditions' => array(
							'PublishedCourse1.id = CourseRegistration1.published_course_id'
						)
					),
					array(
						'table' => 'courses',
						'alias' => 'Course',
						'type' => 'INNER',
						'conditions' => array(
							'Course.id = PublishedCourse1.course_id'
						)
					)
				)
			));

			//debug($totalDroppedCredits);
			$totalDroppedCredits = (isset($totalDroppedCredits[0]['total_credits']) ? $totalDroppedCredits[0]['total_credits'] : 0); 
			//debug($totalDroppedCredits);

			$totalExemptedCredits = ClassRegistry::init('CourseExemption')->find('first', array(
				'fields' => array('SUM(CourseAlias.credit) as total_credits'),
				'conditions' => array(
					'CourseExemption.student_id' => $student_id,
					'CourseExemption.department_accept_reject' => 1,
					'CourseExemption.registrar_confirm_deny' => 1,
				),
				'joins' => array(
					array(
						'table' => 'courses',
						'alias' => 'CourseAlias',
						'type' => 'INNER',
						'conditions' => array(
							'CourseAlias.id = CourseExemption.course_id'
						)
					)
				)
			));

			//debug($totalExemptedCredits);
			$totalExemptedCredits = (isset($totalExemptedCredits[0]['total_credits']) ? $totalExemptedCredits[0]['total_credits'] : 0); 
			//debug($totalExemptedCredits);
			
			$total_credits = (int) (($totalRegisteredCredits + $totalAddedCredits + $totalExemptedCredits) - $totalDroppedCredits);
			//debug($total_credits);

			$minimum_required_credits = (int) $minimumPointofCurriculum['Curriculum']['minimum_credit_points'];
			$credits_expected_per_semester = ($minimum_required_credits / $semester_count_of_the_curriculum);
			$credit_threshold = (($semester_count_of_the_curriculum - 1) * $credits_expected_per_semester);
			$credit_threshold = (int) ceil($credit_threshold);
			
			//debug($credit_threshold);

			if ($total_credits >= $credit_threshold)  {
				//debug( 'ELIGIBLE: taken ' . $total_credits . ' from threshhold filter '  . $credit_threshold . ' value out of  ' . $minimumPointofCurriculum['Curriculum']['minimum_credit_points'] . ' ' . $minimumPointofCurriculum['Curriculum']['type_credit'] .  's ' . $minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');
				return true;
			} else {
				//debug( 'NOT ELIGIBLE taken ' . $total_credits . ' from threshhold filter '  . $credit_threshold . ' value out of  ' . $minimumPointofCurriculum['Curriculum']['minimum_credit_points'] . ' ' . $minimumPointofCurriculum['Curriculum']['type_credit'] .  's ' . $minimumPointofCurriculum['Student']['full_name_studentnumber'] . ' (DB ID: '. $minimumPointofCurriculum['Student']['id'].')');
			}
		}

		return false;
	}

	function completedFillingProfileInfomation($student_id)
	{
		$studentDetails = ClassRegistry::init('Student')->find('first', array(
			'conditions' => array(
				'Student.id' => $student_id
			), 
			'contain' => array(
				'Contact',
				'HigherEducationBackground',
				'EheeceResult',
			)
		));

		//debug($studentDetails);

		if ($studentDetails['Student']['program_id'] == PROGRAM_REMEDIAL || $studentDetails['Student']['program_id'] == PROGRAM_PGDT) { 
			return true;
		} else if (empty($studentDetails['Contact'])) {
			return false;
		} else if ($studentDetails['Student']['program_id'] == PROGRAM_UNDEGRADUATE && empty($studentDetails['EheeceResult'])) {
			return false;
		} else if ($studentDetails['Student']['program_id'] != PROGRAM_UNDEGRADUATE && ($studentDetails['Student']['program_id'] == PROGRAM_POST_GRADUATE || $studentDetails['Student']['program_id'] == PROGRAM_PhD) && empty($studentDetails['HigherEducationBackground'])) {
			return false;
		}

		if (empty($studentDetails['Student']['phone_mobile'])) {
			return false;
		}

		if (empty($studentDetails['Student']['email'])) {
			return false;
		}

		return true;
	}

}
