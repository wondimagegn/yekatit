<?php
App::uses('AppController', 'Controller');
class PlacementRoundParticipantsController extends AppController
{
	public $name = 'PlacementRoundParticipants';

	public $menuOptions = array(
		'parent' => 'placement',
		'alias' => array(
			'index' => 'List Placement Participants',
			'add' => 'Add Placement Participant',

		),
		'exclude' => array(
			'get_participant_unit',
			'get_selected_participant_unit'
		),
	);

	public $components = array('EthiopicDateTime', 'AcademicYear', 'Paginator');

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

		if (isset($this->request->params['action']) && in_array($this->request->params['action'], array('add', 'edit'))) {

			// allow all programs and program types 
			$programs_available_for_placement_preference = Configure::read('programs_available_for_placement_preference');
			//$program_types_available_for_placement_preference = Configure::read('program_types_available_for_placement_preference');

			$programs = ClassRegistry::init('Program')->find('list', array('conditions' => array('Program.id' => $programs_available_for_placement_preference)));
			//$programTypes = ClassRegistry::init('ProgramType')->find('list', array('conditions' => array('ProgramType.id' => $program_types_available_for_placement_preference)));

		} else {

			if (!empty($availableAcademicYears)) {
				$acyear_array_data = $availableAcademicYears;
			}

			if (!empty($acyear_array_data)) {
				$defaultacademicyear = array_values($acyear_array_data)[0];
			}

			$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for();

			if (isset($this->request->data['PlacementRoundParticipant']) && !empty($this->request->data['PlacementRoundParticipant']['applied_for'])) {
				$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for($this->request->data['PlacementRoundParticipant']);
				//$latestACYRoundAppliedFor = ClassRegistry::init('PlacementRoundParticipant')->latest_defined_academic_year_and_round($this->request->data['PlacementRoundParticipant']['applied_for']);
				
				$latestDefinedAppliedFor = $this->request->data['PlacementRoundParticipant']['applied_for'];
				$latestACY = $latestDefinedAcademicYear = $defaultacademicyear = $this->request->data['PlacementRoundParticipant']['academic_year'];
				$latestDefinedRound = $this->request->data['PlacementRoundParticipant']['placement_round'];
			} else {
				if (!empty($availableAcademicYears) && !empty($latestDefinedRound)) {
					$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for(null, $availableAcademicYears, $latestDefinedRound);
				} else if (!empty($latestACYRoundAppliedFor)) {
					$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for(null, $latestACYRoundAppliedFor['academic_year'], $latestDefinedRound);
				} else {
					if (!empty($availableAcademicYears)) {
						$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for(null, $availableAcademicYears, (isset($latestDefinedRound) ? $latestDefinedRound : null));
					} else {
						$appliedForList = ClassRegistry::init('PlacementPreference')->get_defined_list_of_applied_for();
					}
				}
			}

			$this->set(compact('appliedForList'));
		}
		
		$this->set(compact('acyear_array_data', 'defaultacademicyear', 'current_semester', 'latestACYRoundAppliedFor', 'latestDefinedAcademicYear', 'latestDefinedRound', 'latestDefinedAppliedFor', 'programTypes', 'programs'));

		//////////////////////////////////// END BLOCK ///////////////////////////////////////////////////

	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		
		/* $this->Auth->Allow(
			'edit',
			'add',
			'index',
			'get_participant_unit',
			'get_selected_participant_unit'
		); */
	}

	public function index()
	{
		//debug($this->request->data);

		if (isset($this->request->data['search']) && !empty($this->request->data)) {
			//debug($this->request->data);
			$options = array(
				'conditions' => array(
					'PlacementRoundParticipant.academic_year' => $this->request->data['PlacementRoundParticipant']['academic_year'],
					'PlacementRoundParticipant.placement_round' => $this->request->data['PlacementRoundParticipant']['placement_round'],
					'PlacementRoundParticipant.applied_for' => $this->request->data['PlacementRoundParticipant']['applied_for'],
					'PlacementRoundParticipant.program_id' => $this->request->data['PlacementRoundParticipant']['program_id'],
					'PlacementRoundParticipant.program_type_id' => $this->request->data['PlacementRoundParticipant']['program_type_id'],
				),
				'recursive' => -1
			);

			$placementRoundParticipants = $this->PlacementRoundParticipant->find('all', $options);

			$this->set(compact('placementRoundParticipants'));
		}


		$types = array('College' => 'College', 'Department' => 'Department', 'Specialization' => 'Specialization');
		$fieldSetups = 'type,foreign_key,name,edit';

		$currentUnits = $allUnits = array();

		$colleges = ClassRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
		$departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1)));

		if ($this->role_id == ROLE_COLLEGE) {
			$allUnits = ClassRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->college_id);
		} elseif ($this->role_id == ROLE_DEPARTMENT) {
			$allUnits = ClassRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->department_id);
		} else if ($this->role_id == ROLE_REGISTRAR || $this->role_id == ROLE_SYSADMIN) {
			$allUnits = ClassRegistry::init('Department')->allUnits($this->role_id, null);
			$currentUnits = $allUnits;
		}

		$this->set(compact('colleges', 'types', 'allUnits', 'departments', 'colleges', 'fieldSetups'));
	}

	public function view($id = null)
	{
		if (!$this->PlacementRoundParticipant->exists($id)) {
			throw new NotFoundException(__('Invalid placement round participant'));
		}
		$options = array('conditions' => array('PlacementRoundParticipant.' . $this->PlacementRoundParticipant->primaryKey => $id));
		$this->set('placementRoundParticipant', $this->PlacementRoundParticipant->find('first', $options));
	}

	public function add()
	{
		if ($this->request->is('post')) {

			if (isset($this->request->data['PlacementRoundParticipant']) && !empty($this->request->data['PlacementRoundParticipant'])) {
				$reformated = $this->PlacementRoundParticipant->reformat($this->request->data);
				// check duplication
				$checkDuplication = $this->PlacementRoundParticipant->isDuplicated($this->request->data);
				$placementRoundChecker = ClassRegistry::init('PlacementParticipatingStudent')->isCurrentPlacementRoundDefined($this->request->data);

				if ($placementRoundChecker == 0 && $reformated != false && $checkDuplication == false) {
					$groupIdentifier = $reformated['PlacementRoundParticipant'][1]['group_identifier'];

					$this->PlacementRoundParticipant->create();

					if ($this->PlacementRoundParticipant->saveAll($reformated['PlacementRoundParticipant'], array('validate' => 'first'))) {
						$this->Flash->success('The placement round participant has been saved, and please fill their quota capacity for each unit.');
						//redirect to quota management where we can fill the quota for the involved units with groupIdentifier as argument
						return $this->redirect(array('controller' => 'placement_settings', 'action' => 'quota', $groupIdentifier));
					} else {
						$this->Flash->error('The placement round participant could not be saved. Please, try again.');
					}
				} else {

					$error = $this->PlacementRoundParticipant->invalidFields();
					$rlabel = ClassRegistry::init('PlacementRoundParticipant')->roundLabel($placementRoundChecker);

					if (isset($error['foreign_key'])) {
						$this->Flash->error($error['foreign_key'][0]);
					} else if (isset($checkDuplication)) {
						$this->Flash->error('Unable to create placement round participants since they have been created earlier.');
						return $this->redirect(array('controller' => 'placement_settings', 'action' => 'quota', $checkDuplication));
					} else if ($placementRoundChecker) {
						$this->Flash->error('Unable to create  ' . $rlabel . ' round placement since the placement round has took place, and students were assigned. Please change the round, and try again.');
					}
				}
			}
		}

		$colleges = ClassRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
		$departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1), 'order' => array('Department.college_id' => 'ASC', 'Department.name'=> 'ASC')));
		$types = array('College' => 'College', 'Department' => 'Department', 'Specialization' => 'Specialization');
		$fieldSetups = 'type,foreign_key,name,edit';

		if ($this->role_id == ROLE_COLLEGE) {
			$allUnits = ClassRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->college_id);
		} elseif ($this->role_id == ROLE_DEPARTMENT) {
			$allUnits = ClassRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->department_id);
		} else if ($this->role_id == ROLE_REGISTRAR) {
			$allUnits = ClassRegistry::init('Department')->allUnits($this->role_id, null);
			$currentUnits = $allUnits;
		}

		$this->set(compact('colleges', 'types', 'allUnits', 'departments', 'fieldSetups'));
	}

	public function edit($group_identifier = null)
	{

		if (empty($this->request->data) && empty($group_identifier)) {
			$this->Flash->error('Invalid or Empty Placement Round Particpants Group Identifier!');
			return $this->redirect(array('action' => 'index'));
		} else if (!empty($group_identifier)) {
			
			$check_participants = $this->PlacementRoundParticipant->find('count', array(
				'conditions' => array('PlacementRoundParticipant.group_identifier' => $group_identifier),
				'contain' => array(),
				'recursive' => -1
			));

			if (empty($check_participants)) {
				$this->Flash->error('Invalid Placement Round Particpants Group Identifier!');
				return $this->redirect(array('action' => 'index'));
			}
		}

		if ($this->request->is('post')) {
			if (isset($this->request->data['PlacementRoundParticipant']) && !empty($this->request->data['PlacementRoundParticipant']) && isset($this->request->data['saveIt'])) {

				$reformated = $this->PlacementRoundParticipant->reformat($this->request->data);
				// check duplication

				$checkDuplication = $this->PlacementRoundParticipant->isDuplicated($this->request->data , $edit = 1);
				$placementRoundChecker = ClassRegistry::init('PlacementParticipatingStudent')->isCurrentPlacementRoundDefined($this->request->data);

				if ($placementRoundChecker == 0 && $reformated != false && $checkDuplication == false) {
					
					$groupIdentifier = $reformated['PlacementRoundParticipant'][1]['group_identifier'];

					//$this->PlacementRoundParticipant->create();

					if ($this->PlacementRoundParticipant->saveAll($reformated['PlacementRoundParticipant'], array('validate' => 'first'))) {
						$this->Flash->success('The placement round participant has been saved, and please fill their quota capacity for each unit.');
						//redirect to quota management where we can fill the quota for the involved units with groupIdentifier as argument 
						return $this->redirect(array('controller' => 'placement_settings', 'action' => 'quota', $groupIdentifier));
					} else {
						$this->Flash->error('The placement round participant could not be saved. Please, try again.');
					}
				} else {

					$error = $this->PlacementRoundParticipant->invalidFields();
					$rlabel = ClassRegistry::init('PlacementRoundParticipant')->roundLabel($placementRoundChecker);

					if (isset($error['foreign_key'])) {
						$this->Flash->error($error['foreign_key'][0]);
					} else if (isset($checkDuplication)) {
						$this->Flash->error('Unable to create placement round participants since they have been created earlier.');
						return $this->redirect(array('controller' => 'placement_settings', 'action' => 'quota', $checkDuplication));
					} else if ($placementRoundChecker) {
						$this->Flash->error('Unable to create  ' . $rlabel . ' round placement participating units since the placement round has took place, and students were assigned. Please change the round, and try again.');
					}
				}
			}
		}

		if (isset($group_identifier) && !empty($group_identifier)) {

			$options = array(
				'conditions' => array('PlacementRoundParticipant.group_identifier' => $group_identifier),
				'recursive' => -1
			);

			$placementRoundParticipants = $this->request->data = $this->PlacementRoundParticipant->find('all', $options);
			//debug($placementRoundParticipants);


			if (!empty($placementRoundParticipants)) {

				$applied_for = $placementRoundParticipants[0]['PlacementRoundParticipant']['applied_for'];
				$academic_year = $placementRoundParticipants[0]['PlacementRoundParticipant']['academic_year'];
				$placementRound = $placementRoundParticipants[0]['PlacementRoundParticipant']['placement_round'];

				$participantIDs = $this->PlacementRoundParticipant->get_placement_participant_ids_by_group_identifier($group_identifier);
				//debug($participantIDs);

				$isThereAnyPreferenceFilledByStudents = ClassRegistry::init('PlacementPreference')->find('count', array(
					'conditions' => array(
						'PlacementPreference.round' => $placementRound,
						'PlacementPreference.academic_year LIKE ' => $academic_year . '%',
						'PlacementPreference.placement_round_participant_id' => $participantIDs
					)
				)); 
				//debug($isThereAnyPreferenceFilledByStudents);
				
				if ($isThereAnyPreferenceFilledByStudents) {
					$this->Flash->error('There are placement preferences recorded by students using these placement round participants, you can not edit placement round participants at this time.');
					//$this->redirect(array('action' => 'index'));
				}

				$data = array();
				$i = 1;

				if (!empty($this->request->data)) {
					foreach ($this->request->data as $k => $prp) {
						//debug($prp);
						 if (/* !is_null($dev['PlacementPreference']['placement_round_participant_id']) && ($prp['PlacementPreference']['preference_order']) == $i */ 1 ){
							$data['PlacementRoundParticipant'][$i] = $prp['PlacementRoundParticipant'];
						 	$i++;
						}
					}
				}
				//debug($data);
				
				$this->request->data = $data;
				$this->set(compact('isThereAnyPreferenceFilledByStudents'));
			} 
	
			$colleges = ClassRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
			$departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1), 'order' => array('Department.college_id' => 'ASC', 'Department.name'=> 'ASC')));
			$types = array('College' => 'College', 'Department' => 'Department', 'Specialization' => 'Specialization');
			$fieldSetups = 'type,foreign_key,name,edit';
	
			if ($this->role_id == ROLE_COLLEGE) {
				$allUnits = ClassRegistry::init('Department')->allUnits(null, null, 1);
				$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->college_id);
			} elseif ($this->role_id == ROLE_DEPARTMENT) {
				$allUnits = ClassRegistry::init('Department')->allUnits(null, null, 1);
				$currentUnits = ClassRegistry::init('Department')->allUnits($this->role_id, $this->department_id);
			} else if ($this->role_id == ROLE_REGISTRAR) {
				$allUnits = ClassRegistry::init('Department')->allUnits($this->role_id, null);
				$currentUnits = $allUnits;
			}
	
			$this->set(compact('colleges', 'types', 'allUnits', 'departments', 'fieldSetups'));
		}
	}

	public function delete($id = null)
	{
		$this->PlacementRoundParticipant->id = $id;

		if (!$this->PlacementRoundParticipant->exists()) {
			throw new NotFoundException(__('Invalid placement round participant'));
		}

		$this->request->allowMethod('post', 'delete');

		// check is needed if PlacementRoundParticipant id is used  in `placement_entrance_exam_result_entries`, `placement_participating_students` and `placement_preferences` tables before delete 
		if ($this->PlacementRoundParticipant->canItBeDeleted($id)) {
			if ($this->PlacementRoundParticipant->delete()) {
				$this->Flash->success('The placement round participant has been deleted.');
				return $this->redirect(array('action' => 'index'));
			}
		} else {
			$this->Flash->error('The placement round participant could not be deleted. It is associated to placement settings.');
			return $this->redirect(array('action' => 'index'));
		}

		$this->Flash->error('The placement round participant could not be deleted. Please, try again.');

		return $this->redirect(array('action' => 'index'));
	}

	public function get_participant_unit($type = "", $appliedFor = "", $appliedForValue = "")
	{
		$this->layout = 'ajax';

		$units = array();

		if ($type == "College") {
			$units = ClassRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
		} else if ($type == "Department") {
			//$units = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1)));
			
			$units = array();
			$departments_data = ClassRegistry::init('Department')->find('all', array(
				'conditions' => array(
					//'Department.college_id' => $college_id,
					'Department.active' => 1
				),
				'contain' => array(
					'College' => array('id', 'name', 'shortname')
				),
				'order' => array('Department.college_id' => 'ASC', 'Department.name' => 'ASC'),
				'recursive' => -1
			));

			if (!empty($departments_data)) {
				foreach ($departments_data as $key => $department) {
					$units[$department['College']['name']][$department['Department']['id']] = $department['Department']['name'];
				}
			}
		} else if ($type == "Specialization") {
			$units = ClassRegistry::init('Specialization')->find('list');
		} else {
			if ($appliedFor == "d") {
				$units = ClassRegistry::init('Specialization')->find('list', array('conditions' => array('Specialization.department_id' => $appliedForValue)));
			} else if ($appliedFor == "c") {
				//$units = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.college_id' => $appliedForValue, 'Department.active' => 1)));
				//debug($units);

				$units = array();

				$departments_data = ClassRegistry::init('Department')->find('all', array(
					'conditions' => array(
						'Department.college_id' => $appliedForValue,
						'Department.active' => 1
					),
					'contain' => array(
						'College' => array('id', 'name', 'shortname')
					),
					'order' => array('Department.college_id' => 'ASC', 'Department.name' => 'ASC'),
					'recursive' => -1
				));

				if (!empty($departments_data)) {
					foreach ($departments_data as $key => $department) {
						$units[$department['College']['name']][$department['Department']['id']] = $department['Department']['name'];
					}
				}
			}
		}

		$this->set(compact('units'));
	}

	public function get_selected_participant_unit($model = null)
	{
		$this->layout = 'ajax';

		if (isset($model) && !empty($model)) {
			$units = $this->PlacementRoundParticipant->get_participating_unit_name($this->request->data["$model"]);
		} else {
			$units = $this->PlacementRoundParticipant->get_selected_participating_unit_name($this->request->data);
		}

		$this->set(compact('units'));
	}
}
