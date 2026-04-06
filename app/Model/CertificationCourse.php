<?php
class CertificationCourse extends AppModel
{
	var $name = 'CertificationCourse';
    var $displayField = 'course_code';

    var $actsAs = array(
        //'Containable',
		'Tools.Logable' => array(
			'change' => 'full',
			//'change' => 'list',
			'description_ids' => 'true',
			'displayField' => 'username',
			'foreignKey' => 'foreign_key',
			//'skip' => array('search', 'view'), // functions to skip logging
			'ignore' => array('created', 'modified') // fields to ignore in log
		)
	);
    
	public function beforeValidate($options = array())
	{
		if (!$this->id) {
			if ($this->findByName($this->data['CertificationCourse']['course_code'])) {
				$this->invalidate('course_code');
				return false;
			}

            if ($this->findByName($this->data['CertificationCourse']['course_title'])) {
				$this->invalidate('course_title');
				return false;
			}
		}
		return true;
	}

    public function getCertificationCourses($certification_course_ids = array(), $details = 0) 
    {

        $certification_course_details = array();

        if (empty($certification_course_ids)) {
            return false;
        }

        $certification_course_details = array();
        
        $certification_courses = $this->find('all', array(
            'conditions' => array(
                'CertificationCourse.id' => $certification_course_ids,
            ),
            'contain' => array(),
            'fields' => array('CertificationCourse.id', 'CertificationCourse.course_title', 'CertificationCourse.course_code')
        ));


        if (!empty($certification_courses)) {
            foreach ($certification_courses as $key => $c_courses) {
                if ($details) {
                   $certification_course_details[$c_courses['CertificationCourse']['id']] = (trim($c_courses['CertificationCourse']['course_title']) . ' (' . (trim($c_courses['CertificationCourse']['course_code'])) . ')');
                } else {
                    $certification_course_details[$c_courses['CertificationCourse']['id']] = trim($c_courses['CertificationCourse']['course_title']);
                }
            }
        }

        return $certification_course_details;

    }
}