<?php
App::uses('AppController', 'Controller');

class PlacementParticipatingStudentsController extends AppController
{
	var $name = 'PlacementParticipatingStudents';
	public $menuOptions = array(
		'parent' => 'placement',
		'alias' => array(
			//'index' => 'List Placement Participant Student',
		),
		'exclude' => array(
			'delete_ajax',
			'index'
		),
	);

	var $components = array('EthiopicDateTime', 'AcademicYear');
	public function beforeRender()
	{
		parent::beforeRender();
		//$acyear_array_data = $this->AcademicYear->academicYearInArray(date('Y') - 2, date('Y') - 1);

		////////////////////////////// BLOCK: DONT REMOVE ANY VARIABLE /////////////////////////////////////

		$current_acy_and_semester = $this->AcademicYear->current_acy_and_semester();
		$defaultacademicyear = $current_acy_and_semester['academic_year'];
		$current_semester = $current_acy_and_semester['semester'];

        if (is_numeric(ACY_BACK_FOR_PLACEMENT) && ACY_BACK_FOR_PLACEMENT == 0) {
            $acyear_array_data[$defaultacademicyear] = $defaultacademicyear;
        } else if (is_numeric(ACY_BACK_FOR_PLACEMENT) && ACY_BACK_FOR_PLACEMENT <= 2) {
			$acyear_array_data = $this->AcademicYear->academicYearInArray(((explode('/', $defaultacademicyear)[0]) - ACY_BACK_FOR_PLACEMENT), (explode('/', $defaultacademicyear)[0]));
        } else {
			$acyear_array_data[$defaultacademicyear] = $defaultacademicyear;
		}

		$availableAcademicYears = ClassRegistry::init('PlacementRoundParticipant')->find('list', array(
			'conditions' => array(
				'PlacementRoundParticipant.academic_year' => $acyear_array_data
			),
			'fields' => array('PlacementRoundParticipant.academic_year', 'PlacementRoundParticipant.academic_year'),
			'group' => array('PlacementRoundParticipant.academic_year'),
			'order' => array('PlacementRoundParticipant.academic_year' => 'DESC')
		));

		if (!empty($availableAcademicYears)) {
			$acyear_array_data = $availableAcademicYears;
		}

		if (!empty($acyear_array_data)) {
			$defaultacademicyear = array_values($acyear_array_data)[0];
		}
		
		$this->set(compact('acyear_array_data', 'defaultacademicyear', 'current_semester'));

		//////////////////////////////////// END BLOCK ///////////////////////////////////////////////////
		
	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->Auth->Allow('delete_ajax');
	}


	public function delete_ajax($id = null)
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		//check if placement is already run
		$placementParticpatingStu = $this->PlacementParticipatingStudent->find('first', array('conditions' => array('PlacementParticipatingStudent.id' => $id), 'recursive' => -1));

		$isPlaced = $this->PlacementParticipatingStudent->find('count', array(
			'conditions' => array(
				'PlacementParticipatingStudent.program_id' => $placementParticpatingStu['PlacementParticipatingStudent']['program_id'],
				'PlacementParticipatingStudent.program_type_id' => $placementParticpatingStu['PlacementParticipatingStudent']['program_type_id'],
				'PlacementParticipatingStudent.applied_for' => $placementParticpatingStu['PlacementParticipatingStudent']['applied_for'],
				'PlacementParticipatingStudent.round' => $placementParticpatingStu['PlacementParticipatingStudent']['round'],
				'PlacementParticipatingStudent.academic_year' => $placementParticpatingStu['PlacementParticipatingStudent']['academic_year'],
				'PlacementParticipatingStudent.placement_round_participant_id is not null'
			),
			'recursive' => -1
		));

		if ($isPlaced == 0) {
			$this->PlacementParticipatingStudent->id = $id;
			$this->request->allowMethod('post', 'delete');
			if ($this->PlacementParticipatingStudent->delete()) {
			}
		}
	}
}
