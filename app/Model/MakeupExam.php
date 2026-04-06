<?php
class MakeupExam extends AppModel
{
	var $name = 'MakeupExam';
	var $validate = array(
		'minute_number' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please provide minute number.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'published_course_id' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
				'message' => 'Please select course',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'student_id' => array(
			'numeric' => array(
				'rule' => array('notBlank'),
				'message' => 'Please select the student who is taking the makeup exam.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	var $belongsTo = array(
		'PublishedCourse' => array(
			'className' => 'PublishedCourse',
			'foreignKey' => 'published_course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseRegistration' => array(
			'className' => 'CourseRegistration',
			'foreignKey' => 'course_registration_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseAdd' => array(
			'className' => 'CourseAdd',
			'foreignKey' => 'course_add_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $hasMany = array(
		'ExamResult' => array(
			'className' => 'ExamResult',
			'foreignKey' => 'makeup_exam_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ExamGrade' => array(
			'className' => 'ExamGrade',
			'foreignKey' => 'makeup_exam_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ExamGradeChange' => array(
			'className' => 'ExamGradeChange',
			'foreignKey' => 'makeup_exam_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	function getmakeupExams($department_id = "", $acadamic_year = "", $program_id = "", $program_type_id = "", $semester = "")
	{
		$makeup_exams_formated = array();

		if (!empty($department_id) && !empty($acadamic_year) && !empty($program_id)) {
			$conditions['PublishedCourse.department_id'] = $department_id;
			$conditions['PublishedCourse.academic_year'] = $acadamic_year;
			$conditions['PublishedCourse.program_id'] = $program_id;

			if (!empty($program_type_id)) {
				$conditions['PublishedCourse.program_type_id'] = $program_type_id;
			}

			if (!empty($semester)) {
				$conditions['PublishedCourse.semester'] = $semester;
			}

			//Makeup exams which are assigned to the instructor
			$all_makeup_exams = $this->PublishedCourse->find('all', array(
				'conditions' => $conditions,
				'contain' => array(
					'Section' => array('YearLevel' => array('id', 'name'), 'Curriculum' => array('id', 'name', 'year_introduced', 'type_credit')),
					'Course',
					'MakeupExam' => array(
						'ExamGradeChange',
						'ExamResult',
						'ExamGrade',
						'CourseRegistration' => array(
							'PublishedCourse' => array('Course'),
							'Student' => array('Curriculum' => array('id', 'name', 'year_introduced', 'type_credit')),
						),
						'CourseAdd' => array(
							'PublishedCourse' => array('Course'),
							'Student' => array('Curriculum' => array('id', 'name', 'year_introduced', 'type_credit')),
						)
					),
				)
			));

			//debug($all_makeup_exams);
			$count = 0;

			if (!empty($all_makeup_exams)) {
				foreach ($all_makeup_exams as $key => $makeup_exams) {
					if (isset($makeup_exams['MakeupExam']) && !empty($makeup_exams['MakeupExam'])) {
						foreach ($makeup_exams['MakeupExam'] as $me_key => $makeup_exam) { 
							//debug($makeup_exam);

							if (!empty($makeup_exam['CourseRegistration']) && isset($makeup_exam['CourseRegistration']['Student']['id'])) {
								$makeup_exams_formated[$count]['student_name'] = $makeup_exam['CourseRegistration']['Student']['full_name'];
								$makeup_exams_formated[$count]['student_id'] = $makeup_exam['CourseRegistration']['Student']['studentnumber'];
								$makeup_exams_formated[$count]['exam_for'] = $makeup_exam['CourseRegistration']['PublishedCourse']['Course']['course_code_title'] . ' (Course Registration)';
								$makeup_exams_formated[$count]['gender'] = $makeup_exam['CourseRegistration']['Student']['gender'];
								$makeup_exams_formated[$count]['graduated'] = $makeup_exam['CourseRegistration']['Student']['graduated'];
								$makeup_exams_formated[$count]['student_attached_curriculum'] = (isset($makeup_exam['CourseRegistration']['Student']['Curriculum']['name']) ? $makeup_exam['CourseRegistration']['Student']['Curriculum']['name'] . ' - ' . $makeup_exam['CourseRegistration']['Student']['Curriculum']['year_introduced'] . ' (' . (count(explode('ECTS', $makeup_exam['CourseRegistration']['Student']['Curriculum']['type_credit'] )) >= 2 ? 'ECTS' : 'Credit')  .')' : '');
							} else if (!empty($makeup_exam['CourseAdd']) && isset($makeup_exam['CourseAdd']['Student']['id'])) {
								$makeup_exams_formated[$count]['student_name'] = $makeup_exam['CourseAdd']['Student']['full_name'];
								$makeup_exams_formated[$count]['student_id'] = $makeup_exam['CourseAdd']['Student']['studentnumber'];
								$makeup_exams_formated[$count]['exam_for'] = $makeup_exam['CourseAdd']['PublishedCourse']['Course']['course_code_title'] . ' (Course Add)';
								$makeup_exams_formated[$count]['gender'] = $makeup_exam['CourseAdd']['Student']['gender'];
								$makeup_exams_formated[$count]['graduated'] = $makeup_exam['CourseAdd']['Student']['graduated'];
								$makeup_exams_formated[$count]['student_attached_curriculum'] = (isset($makeup_exam['CourseAdd']['Student']['Curriculum']['name']) ? $makeup_exam['CourseAdd']['Student']['Curriculum']['name'] . ' - ' . $makeup_exam['CourseAdd']['Student']['Curriculum']['year_introduced'] . ' (' . (count(explode('ECTS', $makeup_exam['CourseAdd']['Student']['Curriculum']['type_credit'] )) >= 2 ? 'ECTS' : 'Credit')  .')' : '');
							} else {
								continue;
							}

							$makeup_exams_formated[$count]['minute_number'] = $makeup_exam['minute_number'];

							$makeup_exams_formated[$count]['taken_exam'] = $makeup_exams['Course']['course_code_title'];
							$makeup_exams_formated[$count]['section_exam_taken'] = $makeup_exams['Section']['name'];

							$makeup_exams_formated[$count]['section_exam_taken'] =  ($makeup_exams['Section']['name'] . ' (' . (isset($makeup_exams['Section']['YearLevel']['name']) ? $makeup_exams['Section']['YearLevel']['name'] : ($makeup_exams['Section']['program_id'] == PROGRAM_REMEDIAL ? 'Remedial' : 'Pre/1st')) . ', ' . $makeup_exams['Section']['academicyear'] . ')') . ' &nbsp ' . ($makeup_exams['Section']['archive'] ? '<span class="rejected"> (Archieved) </span>' : '<span class="accepted"> (Active) </span>');
							$makeup_exams_formated[$count]['section_curriculum'] = (isset($makeup_exams['Section']['Curriculum']['name']) ? $makeup_exams['Section']['Curriculum']['name'] . ' - ' . $makeup_exams['Section']['Curriculum']['year_introduced'] . ' (' . (count(explode('ECTS', $makeup_exams['Section']['Curriculum']['type_credit'] )) >= 2 ? 'ECTS' : 'Credit')  .')' : '');

							$makeup_exams_formated[$count]['created'] = $makeup_exam['created'];
							$makeup_exams_formated[$count]['modified'] = $makeup_exam['modified'];

							$makeup_exams_formated[$count]['ExamGrade'] = $makeup_exam['ExamGrade'];
							$makeup_exams_formated[$count]['ExamResult'] = $makeup_exam['ExamResult'];

							if (!empty($makeup_exam['ExamGradeChange'])) {
								$makeup_exams_formated[$count]['ExamGradeChange'] = $makeup_exam['ExamGradeChange'][0];
								$status = $this->CourseRegistration->ExamGrade->ExamGradeChange->examGradeChangeStateDescription($makeup_exam['ExamGradeChange'][0]);
								$makeup_exams_formated[$count]['ExamGradeChange']['state'] = $status['state'];
								$makeup_exams_formated[$count]['ExamGradeChange']['description'] = $status['description'];
							}

							$makeup_exams_formated[$count]['id'] = $makeup_exam['id'];
							$count++;
						}
					}
				}
			}

			//Makeup exams which are directly submted by the department
			$all_makeup_exams = $this->PublishedCourse->find('all', array(
				'conditions' => $conditions,
				'contain' => array(
					'Course',
					'CourseRegistration' => array(
						'Student',
						'ExamGrade' => array(
							'ExamGradeChange' => array(
								'conditions' => array(
									'ExamGradeChange.initiated_by_department' => 1
								)
							)
						)
					),
					'CourseAdd' => array(
						'Student',
						'ExamGrade' => array(
							'ExamGradeChange' => array(
								'conditions' => array(
									'ExamGradeChange.initiated_by_department' => 1
								)
							)
						)
					)
				)
			));
			//debug($all_makeup_exams);

			if (!empty($all_makeup_exams)) {
				foreach ($all_makeup_exams as $key => $published_course) {
					if (isset($published_course['CourseRegistration']['id'])) {
						foreach ($published_course['CourseRegistration'] as $key => $course_registration) {
							if (isset($course_registration['Student']['id']) && isset($course_registration['ExamGrade'][0]['ExamGradeChange']) && !empty($course_registration['ExamGrade'][0]['ExamGradeChange'])) {
								foreach ($course_registration['ExamGrade'][0]['ExamGradeChange'] as $key => $exam_grade_change) {
									
									$makeup_exams_formated[$count]['student_name'] = $course_registration['Student']['full_name'];
									$makeup_exams_formated[$count]['student_id'] = $course_registration['Student']['studentnumber'];
									$makeup_exams_formated[$count]['exam_for'] = $published_course['Course']['course_code_title'] . ' (Course Registration)';

									$makeup_exams_formated[$count]['gender'] = $course_registration['Student']['gender'];
									$makeup_exams_formated[$count]['graduated'] = $course_registration['Student']['graduated'];

									$makeup_exams_formated[$count]['taken_exam'] = null;
									$makeup_exams_formated[$count]['section_exam_taken'] = null;

									$makeup_exams_formated[$count]['ExamGradeChange'] = $exam_grade_change;
									$status = $this->CourseRegistration->ExamGrade->ExamGradeChange->examGradeChangeStateDescription($exam_grade_change);
									$makeup_exams_formated[$count]['ExamGradeChange']['state'] = $status['state'];
									$makeup_exams_formated[$count]['ExamGradeChange']['description'] = $status['description'];
									//$makeup_exams_formated[$count]['ExamGradeChange']['status'] = $this->CourseRegistration->getExamGradeChangeStatus($exam_grade_change);
									$count++;
								}
							}
						}
					} else if (isset($published_course['CourseAdd']['id'])) {
						foreach ($published_course['CourseAdd'] as $key => $course_add) {
							if (isset($course_add['Student']['id']) && isset($course_add['ExamGrade'][0]['ExamGradeChange']) && !empty($course_add['ExamGrade'][0]['ExamGradeChange'])) {
								foreach ($course_add['ExamGrade'][0]['ExamGradeChange'] as $key => $exam_grade_change) {
									
									$makeup_exams_formated[$count]['student_name'] = $course_add['Student']['full_name'];
									$makeup_exams_formated[$count]['student_id'] = $course_add['Student']['studentnumber'];
									$makeup_exams_formated[$count]['exam_for'] = $published_course['Course']['course_code_title'] . ' (Course Add)';

									$makeup_exams_formated[$count]['gender'] = $course_add['Student']['gender'];
									$makeup_exams_formated[$count]['graduated'] = $course_add['Student']['graduated'];

									$makeup_exams_formated[$count]['taken_exam'] = null;
									$makeup_exams_formated[$count]['section_exam_taken'] = null;

									$makeup_exams_formated[$count]['ExamGradeChange'] = $exam_grade_change;
									$status = $this->CourseAdd->ExamGrade->ExamGradeChange->examGradeChangeStateDescription($exam_grade_change);
									$makeup_exams_formated[$count]['ExamGradeChange']['state'] = $status['state'];
									$makeup_exams_formated[$count]['ExamGradeChange']['description'] = $status['description'];
									$count++;
								}
							}
						}
					}
				}
			}
		}
		//debug($all_makeup_exams);
		//debug($makeup_exams_formated);
		//debug($all_makeup_exams);

		return $makeup_exams_formated;
	}

	function BACKUP_getmakeupExams($department_id = "", $acadamic_year = "", $program_id = "", $program_type_id = "0", $semester = "0")
	{
		$makeup_exams_formated = array();

		if (!empty($department_id) && !empty($acadamic_year) && !empty($program_id)) {
			$conditions['PublishedCourse.department_id'] = $department_id;
			$conditions['PublishedCourse.academic_year'] = $acadamic_year;
			$conditions['PublishedCourse.program_id'] = $program_id;

			if (!empty($program_type_id)) {
				$conditions['PublishedCourse.program_type_id'] = $program_type_id;
			}

			if (!empty($semester)) {
				$conditions['PublishedCourse.semester'] = $semester;
			}

			$all_makeup_exams = $this->PublishedCourse->find('all', array(
				'conditions' => $conditions,
				'contain' => array(
					'Section',
					'Course',
					'MakeupExam' => array(
						'ExamResult',
						'ExamGrade',
						'CourseRegistration' => array(
							'PublishedCourse' => array('Course'),
							'Student'
						),
						'CourseAdd' => array(
							'PublishedCourse' => array('Course'),
							'Student'
						)
					)
				)
			));

			$count = 0;

			if (!empty($all_makeup_exams)) {
				foreach ($all_makeup_exams as $key => $makeup_exams) {
					if (isset($makeup_exams['MakeupExam']) && !empty($makeup_exams['MakeupExam'])) {
						foreach ($makeup_exams['MakeupExam'] as $me_key => $makeup_exam) { 
							//debug($makeup_exam);

							if (!empty($makeup_exam['CourseRegistration'])) {
								$makeup_exams_formated[$count]['student_name'] = $makeup_exam['CourseRegistration']['Student']['full_name'];
								$makeup_exams_formated[$count]['student_id'] = $makeup_exam['CourseRegistration']['Student']['studentnumber'];
								$makeup_exams_formated[$count]['exam_for'] = $makeup_exam['CourseRegistration']['PublishedCourse']['Course']['course_code_title']  . ' (Course Registration)';
							} else {
								$makeup_exams_formated[$count]['student_name'] = $makeup_exam['CourseAdd']['Student']['full_name'];
								$makeup_exams_formated[$count]['student_id'] = $makeup_exam['CourseAdd']['Student']['studentnumber'];
								$makeup_exams_formated[$count]['exam_for'] = $makeup_exam['CourseAdd']['PublishedCourse']['Course']['course_code_title'] . ' (Course Add)';
							}

							$makeup_exams_formated[$count]['minute_number'] = $makeup_exam['minute_number'];

							$makeup_exams_formated[$count]['taken_exam'] = $makeup_exams['Course']['course_code_title'];
							$makeup_exams_formated[$count]['section_exam_taken'] = $makeup_exams['Section']['name'];

							$makeup_exams_formated[$count]['created'] = $makeup_exam['created'];
							$makeup_exams_formated[$count]['modified'] = $makeup_exam['modified'];

							$makeup_exams_formated[$count]['ExamGrade'] = $makeup_exam['ExamGrade'];
							$makeup_exams_formated[$count]['ExamResult'] = $makeup_exam['ExamResult'];
							$makeup_exams_formated[$count]['id'] = $makeup_exam['id'];
							$count++;
						}
					}
				}
			}
		}
		//debug($makeup_exams_formated);
		//debug($all_makeup_exams);
		return $makeup_exams_formated;
	}

	public function canItBeDeleted($id = "")
	{
		if (!empty($id)) {
			$result_and_grade = $this->find('first', array('conditions' => array('MakeupExam.id' => $id), 'contain' => array('ExamResult', 'ExamGrade', 'ExamGradeChange')));
			if (count($result_and_grade['ExamResult']) > 0 || count($result_and_grade['ExamGrade']) > 0 || count($result_and_grade['ExamGradeChange'])) {
				return false;
			} else {
				return true;
			}
		}
		return false;
	}

	public function makeUpExamApplied($student_id, $published_course_id, $reg_add_id, $reg = 0)
	{

		if ($reg == 1) {
			$return = $this->find('first', array(
				'conditions' => array(
					'MakeupExam.student_id' => $student_id,
					//'MakeupExam.published_course_id' => $published_course_id,
					'MakeupExam.course_registration_id' => $reg_add_id,
				),
				'recursive' => -1
			));
		} else if ($reg == 0) {
			$return = $this->find('first', array(
				'conditions' => array(
					'MakeupExam.student_id' => $student_id,
					//'MakeupExam.published_course_id'=>$published_course_id,
					'MakeupExam.course_add_id' => $reg_add_id,
				),
				'recursive' => -1
			));
			debug($return);
			debug($student_id);
			debug($published_course_id);
			debug($reg_add_id);
		}

		if (isset($return['MakeupExam']['id']) && !empty($return['MakeupExam']['id'])) {
			return $return['MakeupExam']['id'];
		}

		return 0;
	}

	public function assignedMakeup($published_course_id)
	{
		$assigned = 0;
		if (!empty($published_course_id)) {
			$assigned = $this->find('count', array(
				'conditions' => array(
					'MakeupExam.published_course_id' => $published_course_id,
				),
				'recursive' => -1
			));
		}
		return $assigned;
	}
}