<?php
class CertificationCourseSetting extends AppModel
{
	var $name = 'CertificationCourseSetting';
	
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

    function isUniqueCertificationCourseSetting($data = null)
	{
		$count = 0;

		//debug($data);

		if (!empty($data['CertificationCourseSetting']['id'])) {
			$count = $this->find('count', array(
				'conditions' => array(
                    'CertificationCourseSetting.id <> ' => $data['CertificationCourseSetting']['id'],
					'CertificationCourseSetting.academic_year' => $data['CertificationCourseSetting']['academic_year'], 
					'CertificationCourseSetting.semester' => $data['CertificationCourseSetting']['semester'],
					'CertificationCourseSetting.program_id' => $data['CertificationCourseSetting']['program_id'],
				)
			));
		} else if (!empty($data['CertificationCourseSetting'])) {
			$count = $this->find('count', array(
				'conditions' => array(
					'CertificationCourseSetting.academic_year' => $data['CertificationCourseSetting']['academic_year'], 
					'CertificationCourseSetting.semester' => $data['CertificationCourseSetting']['semester'],
					'CertificationCourseSetting.program_id' => $data['CertificationCourseSetting']['program_id'],
				)
			));
		} else {
            return false;
        }

		//debug($count);

		if ($count > 0) {
			return false;
		}

		return true;
	}

    public function getCertificationCourseSetting($academic_year = null, $semester = null, $program_id = null, $program_type_ids_to_exclude = array())
    {

        $certificationCourseSetting = array();

        if (empty($academic_year) || empty($semester) || empty($program_id)) {
            return 0;
        }

        $certificationCourseSetting = $this->find('first', array(
            'conditions' => array(
                'CertificationCourseSetting.academic_year' => $academic_year,
                'CertificationCourseSetting.semester' => $semester,
                'CertificationCourseSetting.program_id' => $program_id,
                //'CertificationCourseSetting.program_type_ids_to_exclude' => $program_type_ids_to_exclude
            ), 
            'contain' => array()
        ));

        
        return $certificationCourseSetting;
    }
}