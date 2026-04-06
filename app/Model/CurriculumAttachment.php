<?php
App::uses('AppModel', 'Model');
class CurriculumAttachment extends AppModel
{
	public $belongsTo = array(
		'Student' => array(
			'className' => 'Student',
			'foreignKey' => 'student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Curriculum' => array(
			'className' => 'Curriculum',
			'foreignKey' => 'curriculum_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	// the course given taken from previous curriculum ? 

	// IMPORTANT!: not used anywhere in the repository. corrected errors and return types anyway incase if some part of the code is copied later for other use cases, Neway.

	/* public function isEquivalentTakenCoursesFromCurriculum($course_id = null, $student_id = null)
	{

		if (empty($course_id) || empty($student_id)) {
			return false;
		}

		$currentStudentCurriculum = $this->Student->field('Student.curriculum_id', array('Student.id' => $student_id));
		
		$curriculumAttachmentHistoryOfStudent = array();

		if (!empty($currentStudentCurriculum) && is_numeric($currentStudentCurriculum)) {
			$curriculumAttachmentHistoryOfStudent = $this->find('list', array('conditions' => array('CurriculumAttachment.student_id' => $student_id, 'CurriculumAttachment.curriculum_id !=' => $currentStudentCurriculum), 'fields' => array('CurriculumAttachment.student_id', 'CurriculumAttachment.curriculum_id')));
		}

		if (!empty($curriculumAttachmentHistoryOfStudent)) {
			foreach ($curriculumAttachmentHistoryOfStudent as $k => $v) {
				$courseDetails = $this->Curriculum->Course->find('count', array('conditions' => array('Course.id' => $course_id, 'Course.curriculum_id' => $v), 'contain' => array()));
				if (!empty($courseDetails)) {
					return true;
				}
			}
		} else {
			return true;
		}

		return false;
	} */

	/* public function readyForPublishingCourses($student_id, $department_id, $taken_courses, $section_id)
	{
		$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find('all', array('conditions' => array('Course.curriculum_id' => $section_curriculum_attachment[$section_id], "NOT" => array('Course.id ' => $taken_courses)), 'contain' => array('PublishedCourse')));
	}

	public function takenCourseOfSection($student_id, $department_id, $taken_courses, $section_id)
	{
		$taken_courses_allow_to_publishe_it[$section_id] = $this->PublishedCourse->Course->find('all', array('conditions' => array('Course.curriculum_id' => $section_curriculum_attachment[$section_id], 'Course.department_id' => $this->department_id, 'Course.id ' => $taken_courses), 'contain' => array('PublishedCourse')));
	} */

}
