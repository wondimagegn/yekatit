<?php
App::uses('AppController', 'Controller');
class PlacementEntranceExamResultEntriesController extends AppController
{
	var $name = 'PlacementEntranceExamResultEntries';
	var $uses = array();

	public $menuOptions = array(
		'parent' => 'placement',
		'alias' => array(
			'add' => 'Add Entrance Exam Result',
		),
		'exclude' => array(
			'index',
			'get_selected_section',
			'get_selected_student',
			'get_selected_participant',
			'autoSaveResult',
			'delete',
			'view',
			'get_selected_participant_exam'
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
		/* $this->Auth->Allow(
			'add',
			'index',
			'get_selected_section',
			'get_selected_student',
			'get_selected_participant',
			'autoSaveResult',
			'get_selected_participant_exam',
			'add'
		); */
	}

	public function index()
	{
		$this->PlacementEntranceExamResultEntry->recursive = 0;
		$this->set('placementEntranceExamResultEntries', $this->Paginator->paginate());
	}

	public function view($id = null)
	{
		if (!$this->PlacementEntranceExamResultEntry->exists($id)) {
			throw new NotFoundException(__('Invalid placement entrance exam result entry'));
		}

		$options = array('conditions' => array('PlacementEntranceExamResultEntry.' . $this->PlacementEntranceExamResultEntry->primaryKey => $id));
		$this->set('placementEntranceExamResultEntry', $this->PlacementEntranceExamResultEntry->find('first', $options));
	}

	public function add()
	{
		if ($this->request->is('post')) {
			$this->PlacementEntranceExamResultEntry->create();
			if ($this->PlacementEntranceExamResultEntry->save($this->request->data)) {
				$this->Flash->success(__('The placement entrance exam result entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The placement entrance exam result entry could not be saved. Please, try again.'));
			}
		}

		$colleges = classRegistry::init('College')->find('list', array('conditions' => array('College.active' => 1)));
		$departments = classRegistry::init('Department')->find('list', array('conditions' => array('Department.active' => 1)));
		$types = array('College' => 'College', 'Department' => 'Department', 'Specialization' => 'Specialization' );

		$programs_available_for_placement_preference = Configure::read('programs_available_for_placement_preference');
		$program_types_available_for_placement_preference = Configure::read('program_types_available_for_placement_preference');

		$programs = classRegistry::init('Program')->find('list', array('conditions' => array('Program.id' => $programs_available_for_placement_preference)));
		$programTypes = classRegistry::init('ProgramType')->find('list', array('conditions' => array('ProgramType.id' => $program_types_available_for_placement_preference)));
		$fieldSetups = 'type,foreign_key,name,edit';

		if ($this->role_id == ROLE_COLLEGE) {
			$allUnits = classRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = classRegistry::init('Department')->allUnits($this->role_id, $this->college_id);
		} elseif ($this->role_id == ROLE_DEPARTMENT) {
			$allUnits = classRegistry::init('Department')->allUnits(null, null, 1);
			$currentUnits = classRegistry::init('Department')->allUnits($this->role_id, $this->department_id);
		} else if ($this->role_id == ROLE_REGISTRAR) {
			$allUnits = classRegistry::init('Department')->allUnits($this->role_id, null);
			$currentUnits = $allUnits;
		}

		$sections = array();
		$section_combo_id = null;

		$this->set(compact('colleges', 'types', 'allUnits', 'departments', 'sections', 'colleges', 'fieldSetups', 'programs', 'currentUnits', 'section_combo_id', 'programTypes'));
	}


	public function edit($id = null)
	{
		if (!$this->PlacementEntranceExamResultEntry->exists($id)) {
			throw new NotFoundException(__('Invalid placement entrance exam result entry'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->PlacementEntranceExamResultEntry->save($this->request->data)) {
				$this->Flash->success(__('The placement entrance exam result entry has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The placement entrance exam result entry could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PlacementEntranceExamResultEntry.' . $this->PlacementEntranceExamResultEntry->primaryKey => $id));
			$this->request->data = $this->PlacementEntranceExamResultEntry->find('first', $options);
		}

		$acceptedStudents = $this->PlacementEntranceExamResultEntry->AcceptedStudent->find('list');
		$students = $this->PlacementEntranceExamResultEntry->Student->find('list');
		$placementRoundParticipants = $this->PlacementEntranceExamResultEntry->PlacementRoundParticipant->find('list');

		$this->set(compact('acceptedStudents', 'students', 'placementRoundParticipants'));
	}

	public function delete($id = null)
	{
		$this->PlacementEntranceExamResultEntry->id = $id;

		if (!$this->PlacementEntranceExamResultEntry->exists()) {
			throw new NotFoundException(__('Invalid placement entrance exam result entry'));
		}

		$this->request->allowMethod('post', 'delete');

		if ($this->PlacementEntranceExamResultEntry->delete()) {
			$this->Flash->success(__('The placement entrance exam result entry has been deleted.'));
		} else {
			$this->Flash->error(__('The placement entrance exam result entry could not be deleted. Please, try again.'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	public function get_selected_section()
	{
		$this->layout = 'ajax';

		$sections = $this->PlacementEntranceExamResultEntry->get_selected_section($this->request->data);
		$this->set(compact('sections'));
	}

	public function get_selected_participant()
	{
		$this->layout = 'ajax';

		$placementRoundParticipants = classRegistry::init('PlacementRoundParticipant')->find('list', array(
			'conditions' => array(
				'PlacementRoundParticipant.applied_for' => $this->request->data['Search']['applied_for'],
				'PlacementRoundParticipant.program_id' => $this->request->data['Search']['program_id'],
				'PlacementRoundParticipant.program_type_id' => $this->request->data['Search']['program_type_id'],
				'PlacementRoundParticipant.academic_year' => $this->request->data['Search']['academic_year'],
				'PlacementRoundParticipant.placement_round' => $this->request->data['Search']['placement_round'],
			),
			'fields' => array('PlacementRoundParticipant.id', 'PlacementRoundParticipant.name')
		));

		$this->set(compact('placementRoundParticipants'));
	}

	public function get_selected_participant_exam()
	{
		$this->layout = 'ajax';

		$placementRoundParticipants = classRegistry::init('PlacementRoundParticipant')->find('list', array(
			'conditions' => array(
				'PlacementRoundParticipant.applied_for' => $this->request->data['Search']['applied_for'],
				'PlacementRoundParticipant.program_id' => $this->request->data['Search']['program_id'],
				'PlacementRoundParticipant.program_type_id' => $this->request->data['Search']['program_type_id'],
				'PlacementRoundParticipant.academic_year' => $this->request->data['Search']['academic_year'],
				'PlacementRoundParticipant.placement_round' => $this->request->data['Search']['placement_round'],
				'PlacementRoundParticipant.exam_giver' => 1

			),
			'fields' => array('PlacementRoundParticipant.id', 'PlacementRoundParticipant.name')
		));

		$this->set(compact('placementRoundParticipants'));
	}

	public function get_selected_student()
	{
		$this->layout = 'ajax';

		$students = $this->PlacementEntranceExamResultEntry->get_selected_student($this->request->data);
		$this->set(compact('students'));
	}

	public function autoSaveResult()
	{
		$this->autoRender = false;
		$exam_results = array();
		$save_is_ok = true;
		$do_manipulate = false;

		if (isset($this->request->data['PlacementEntranceExamResultEntry']) && !empty($this->request->data['PlacementEntranceExamResultEntry'])) {
			//debug($this->request->data);
			foreach ($this->request->data['PlacementEntranceExamResultEntry'] as $key => $exam_result) {
				$save_is_ok = true;
				//debug($exam_result);
				if (is_array($exam_result)) {
					if (trim($exam_result['result']) != "") {
						$exam_results = $exam_result;
						if (!is_numeric($exam_result['result'])) {
							$save_is_ok = false;
						}
						if ($save_is_ok) {
							$data['PlacementEntranceExamResultEntry'] = $exam_results;
							if (isset($data['PlacementEntranceExamResultEntry']['id']) && !empty($data['PlacementEntranceExamResultEntry']['id'])) {
								$alreadyRecored = $this->PlacementEntranceExamResultEntry->find('first', array(
									'conditions' => array(
										'PlacementEntranceExamResultEntry.id' => $data['PlacementEntranceExamResultEntry']['id']
									),
									'recursive' => -1
								));
							} else {
								$alreadyRecored = $this->PlacementEntranceExamResultEntry->find('first', array(
									'conditions' => array(
										'PlacementEntranceExamResultEntry.placement_round_participant_id' => $data['PlacementEntranceExamResultEntry']['placement_round_participant_id'], 'PlacementEntranceExamResultEntry.accepted_student_id' => $data['PlacementEntranceExamResultEntry']['accepted_student_id'],
										'PlacementEntranceExamResultEntry.student_id' => $data['PlacementEntranceExamResultEntry']['student_id']
									),
									'recursive' => -1
								));
							}

							if (isset($alreadyRecored) && !empty($alreadyRecored) ) {
								$data['PlacementEntranceExamResultEntry']['id'] = $alreadyRecored['PlacementEntranceExamResultEntry']['id'];
							} else {
								$this->PlacementEntranceExamResultEntry->create();
							}

							$this->set($data['PlacementEntranceExamResultEntry']);
							//debug($data);

							if ($this->PlacementEntranceExamResultEntry->save($data)) {
							} else {
								//debug($data);
							}
						}
					}
				}
			}
		}
	}
}
