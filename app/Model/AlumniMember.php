<?php
App::uses('AppModel', 'Model');
class AlumniMember extends AppModel {
  public $validate = array(
	'first_name' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please provide first name.',
		),
        'validChars' => array(
            'rule' => array('custom', '/^[a-zA-ZÀ-ÿ\'\-\s]{2,50}$/u'),
            'message' => 'Invalid characters in first name'
        ),
        'noUrl' => array(
            'rule' => 'noUrl',
            'message' => 'URLs are not allowed'
        )
	),
	'last_name' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please provide father\'s name.',
		),
        'validChars' => array(
            'rule' => array('custom', '/^[a-zA-ZÀ-ÿ\'\-\s]{2,50}$/u'),
            'message' => 'Invalid characters in last name'
        ),
        'noUrl' => array(
            'rule' => 'noUrl',
            'message' => 'URLs are not allowed'
        )
	),
	'email' => array(
		'email' => array(
			'rule' => array('email'),
			'message' => 'Please enter a valid email address.',
		),
		'unique'=>array(
			'rule' => 'isUnique',
			'message'=>'The email address is used by someone. Please provide unique email.',
		)
	),
	/* 'date_of_birth' => array(
		'date' => array(
			'rule' => array('date'),
			'message' => 'Please provide birth date.',
		),
	), */
	'gradution' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please provide gradution year.',
		),
	),
	'gender' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please select  gender.',
		),
	),
	'phone' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please provide a valid phone number.',
		),
	),
	'institute_college' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please select college/institute/school.',
		),
	),
	'department' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please provide department.',
		),
	),
	'program' => array(
		'notBlank' => array(
			'rule' => array('notBlank'),
			'message' => 'Please select a program.',
		),
	));

	public $virtualFields = array('full_name' => "CONCAT(AlumniMember.first_name,' ',AlumniMember.last_name)");

	public function nextTrackingNumber()
	{
		$nextapplicationnumber = $this->find('first', array('order' => array('AlumniMember.created DESC', 'AlumniMember.trackingnumber' => 'DESC')));

		if (isset($nextapplicationnumber) && !empty($nextapplicationnumber)) {
			return $nextapplicationnumber['AlumniMember']['trackingnumber'] + 1;
		}

		return 20011;
	}

	function checkUnique($data, $fieldName)
	{
		$valid = false;

		if (isset($fieldName) && $this->hasField($fieldName)) {
			$valid = $this->isUnique(array($fieldName => $data));
		}
		return $valid;
	}

    public function noUrl($check) {
        $value = array_values($check)[0];
        return !preg_match('/https?:\/\/|www\./i', $value);
    }
}
