<?php
App::uses('AppController', 'Controller');

class PlacementDeadlinesController extends AppController
{
	var $name = 'PlacementDeadlines';
	public $menuOptions = array(
		'parent' => 'placement',
		'alias' => array(
			'add' => 'Add Placement Deadline',
			'index' => 'List Placement Deadlines'
		),
		'exclude' => array(
			'get_participant_unit',
			'view',
			'edit'
		),
	);
	public $components = array('AcademicYear', 'Paginator');

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

		$placementRoundParticipantModel = ClassRegistry::init('PlacementRoundParticipant');

		$availableAcademicYears = $placementRoundParticipantModel->find('list', array(
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

		$latestACYRoundAppliedFor = $placementRoundParticipantModel->latest_defined_academic_year_and_round();
		//debug($latestACYRoundAppliedFor);
		
		
		if (!empty($latestACYRoundAppliedFor)) {
			$latestDefinedAcademicYear = $latestACYRoundAppliedFor['academic_year'];
			$latestDefinedRound = $latestACYRoundAppliedFor['round'];
			$latestDefinedAppliedFor = $latestACYRoundAppliedFor['applied_for'];
		} else {
			$latestDefinedAppliedFor = '';
			$latestDefinedAcademicYear = $defaultacademicyear;
			$latestDefinedRound = ($current_semester == 'I' ? 1 : 2);
		}

		$types = array('College' => 'College', 'Department' => 'Department', 'Specialization' => 'Specialization');
		$fieldSetups = 'type,foreign_key,name,edit';

		$availablePrograms = $placementRoundParticipantModel->find('list', array('fields' => array('PlacementRoundParticipant.program_id', 'PlacementRoundParticipant.program_id'), 'group' => array('PlacementRoundParticipant.program_id')));
		$availableProgramTypes = $placementRoundParticipantModel->find('list', array('fields' => array('PlacementRoundParticipant.program_type_id', 'PlacementRoundParticipant.program_type_id'), 'group' => array('PlacementRoundParticipant.program_type_id')));

		if (!empty($availablePrograms)) {
			$programs = ClassRegistry::init('Program')->find('list', array('conditions' => array('Program.id' => $availablePrograms)));
		} else {
			$programs_available_for_placement_preference = Configure::read('programs_available_for_placement_preference');
			$programs = ClassRegistry::init('Program')->find('list', array('conditions' => array('Program.id' => $programs_available_for_placement_preference)));
		}

		if (!empty($availableProgramTypes)) {
			$programTypes = ClassRegistry::init('ProgramType')->find('list', array('conditions' => array('ProgramType.id' => $availableProgramTypes)));
		} else {
			$program_types_available_for_placement_preference = Configure::read('program_types_available_for_placement_preference');
			$programTypes = ClassRegistry::init('ProgramType')->find('list', array('conditions' => array('ProgramType.id' => $program_types_available_for_placement_preference)));
		}

		if (!empty($availableAcademicYears)) {
			$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for(null, $availableAcademicYears, $latestDefinedRound);
		} else {
			$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for(null, $latestACYRoundAppliedFor['academic_year'], $latestDefinedRound);
		}
		
		$this->set(compact('acyear_array_data', 'defaultacademicyear', 'current_semester', 'latestDefinedAcademicYear', 'latestDefinedRound', 'latestDefinedAppliedFor', 'programs', 'programTypes', 'appliedForList', 'fieldSetups', 'types'));

		//////////////////////////////////// END BLOCK ///////////////////////////////////////////////////
	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		// $this->Auth->Allow('add', 'index', 'get_participant_unit', 'view', 'edit');
	}

	public function index()
	{
		//$this->PlacementDeadline->recursive = 0;

		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		$defaultRound = 1;

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

		if (empty($availableAcademicYears)) {
			$availableAcademicYears = $acyear_array_data;
		}

		$this->Paginator->settings =  array(
			'conditions' => array(
				'PlacementDeadline.academic_year' => $availableAcademicYears
			),
			'order' => array(
				'PlacementDeadline.academic_year' => 'DESC', 
				'PlacementDeadline.placement_round' => 'DESC', 
				'PlacementDeadline.modified' => 'DESC'
			),
			'recursive' => 0
		);

		if ($this->role_id == ROLE_COLLEGE) {
			$allUnit = ClassRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->college_id);
		} elseif ($this->role_id == ROLE_DEPARTMENT) {
			$allUnit = ClassRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->department_id);
		} else if ($this->role_id == ROLE_REGISTRAR) {
			$allUnit = ClassRegistry::init('Department')->allUnits($this->role_id, null);
			$currentUnits = $allUnit;
		}

		$allUnits = array();

		if (!empty($allUnit)) {
			foreach ($allUnit as $ak => $v) {
				foreach ($v as $vvk => $vvv) {
					$allUnits[$vvk] = $vvv;
				}
			}
		}
		
		$this->set('placementDeadlines', $this->Paginator->paginate());
		$this->set(compact('allUnits'));
	}

	public function view($id = null)
	{
		return $this->redirect(array('action' => 'index'));
	}

	public function add()
	{
		if ($this->request->is('post')) {
			if (isset($this->request->data['PlacementDeadline']) && !empty($this->request->data['PlacementDeadline'])) {
				// check duplication 
				$findDefinedParticipants = ClassRegistry::init('PlacementRoundParticipant')->isPossibleToDefineDeadline($this->request->data);

				if (isset($findDefinedParticipants) && !empty($findDefinedParticipants)) {
					if (!$this->PlacementDeadline->isDuplicated($this->request->data)) {
						
						$this->request->data['PlacementDeadline']['group_identifier'] = $findDefinedParticipants;
						$this->PlacementDeadline->create();
						
						if ($this->PlacementDeadline->save($this->request->data)) {
							$this->Flash->success(__('The placement deadline has been saved.'), 'default', array('class' => 'success-message success-box'));
							return $this->redirect(array('action' => 'index'));
						} else {
							$this->Flash->error(__('The placement deadline could not be saved. Please, try again.'));
						}

					} else {
						$colleges = ClassRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
						$departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1)));
						
						$this->Flash->error(__('The there is aleady defined deadline for ' . (count(explode('c~', $this->request->data['PlacementDeadline']['applied_for'])) > 1 ?  $colleges[explode('c~', $this->request->data['PlacementDeadline']['applied_for'])[1]] : $departments[explode('d~', $this->request->data['PlacementDeadline']['applied_for'])[1]])  . ' in ' . $this->request->data['PlacementDeadline']['academic_year'] . ' for round '. $this->request->data['PlacementDeadline']['placement_round'] . '. Please chnage it or try again.'));
					}
				} else {
					if ($findDefinedParticipants == false) {
						$this->Flash->error(__('Unable to create placement deadline due participant is not defined, please define participants first to set a deadline.'));
						return $this->redirect(array('controller' => 'PlacementRoundParticipants', 'action' => 'add'));
					}
				}
			}
		}
	}

	public function edit($id = null)
	{
		if (!$this->PlacementDeadline->exists($id)) {
			throw new NotFoundException(__('Invalid placement deadline'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if (!$this->PlacementDeadline->isDuplicated($this->request->data)) {
				if ($this->PlacementDeadline->save($this->request->data)) {
					$this->Flash->success(__('The placement deadline has been updated.'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('The placement deadline could not be saved. Please, try again.'));
				}
			} else {
				$colleges = ClassRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
				$departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1)));

				$this->Flash->error(__('The there is aleady defined deadline for ' . (count(explode('c~', $this->request->data['PlacementDeadline']['applied_for'])) > 1 ?  $colleges[explode('c~', $this->request->data['PlacementDeadline']['applied_for'])[1]] : $departments[explode('d~', $this->request->data['PlacementDeadline']['applied_for'])[1]])  . ' in ' . $this->request->data['PlacementDeadline']['academic_year'] . ' for round '. $this->request->data['PlacementDeadline']['placement_round'] . '. Please chnage it or try again.'));
			}
		} else {
			$options = array('conditions' => array('PlacementDeadline.' . $this->PlacementDeadline->primaryKey => $id));
			$this->request->data = $this->PlacementDeadline->find('first', $options);
		}
	}

	public function delete($id = null)
	{
		$this->PlacementDeadline->id = $id;

		if (!$this->PlacementDeadline->exists()) {
			throw new NotFoundException(__('Invalid placement deadline'));
		}

		//$this->request->allowMethod('post', 'delete');

		if ($this->PlacementDeadline->delete()) {
			$this->Flash->success(__('The placement deadline has been deleted.'));
		} else {
			$this->Flash->error(__('The placement deadline could not be deleted. Please, try again.'));
		}

		return $this->redirect(array('action' => 'index'));
	}
}
