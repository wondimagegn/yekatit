<?php
class DepartmentStudyProgramsController extends AppController
{
	var $name = 'DepartmentStudyPrograms';
	var $helpers = array('Xls', 'Media.Media');
	var $components = array('AcademicYear', 'EthiopicDateTime');

	public $menuOptions = array(
		//'title' => 'Department Study Programs',
		'parent' => 'curriculums',
		'exclude' => array(
			'get_department_study_programs_combo',
			'get_selected_department_department_study_programs'
		),
		'alias' => array(
			'index' => 'List Department Study Programs',
            'add' => 'Add Study Program for Department'
		)
	);

	public $paginate = array();

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->Allow(
			//'index', 'add', 'edit', 'delete', 'view', 
			'get_selected_department_department_study_programs', 'get_department_study_programs_combo'
		);
	}

	function __init_search_study_programs()
	{
		if (!empty($this->request->data['DepartmentStudyProgram'])) {
			$this->Session->write('DepartmentStudyProgram.search_data_study_programs', $this->request->data['DepartmentStudyProgram']);
		} else {
			if ($this->Session->check('DepartmentStudyProgram.search_data_study_programs')) {
				debug($this->Session->read('DepartmentStudyProgram.search_data_study_programs'));
				$this->request->data['DepartmentStudyProgram'] = $this->Session->read('DepartmentStudyProgram.search_data_study_programs');
			}
		}
	}

	function __init_clear_session_filters()
	{
		if ($this->Session->check('DepartmentStudyProgram.search_data_study_programs')) {
			$this->Session->delete('DepartmentStudyProgram.search_data_study_programs');
		}
	}

	function search()
	{
		$this->__init_search_study_programs();

		$url['action'] = 'index';

		if (isset($this->request->data) && !empty($this->request->data)) {
			foreach ($this->request->data as $k => $v) {
				if (!empty($v) && is_array($v)) {
					foreach ($v as $kk => $vv) {
						if (!empty($vv) && is_array($vv)) {
							foreach ($vv as $kkk => $vvv){
								$url[$k . '.' . $kk . '.' . $kkk] = str_replace('/', '-', trim($vvv));
							}
						} else {
							$url[$k . '.' . $kk] = str_replace('/', '-', trim($vv));
						}
					}
				}
			}
		}

		return $this->redirect($url, null, true);
	}

	public function beforeRender()
	{
		$thisacademicyear = $this->AcademicYear->current_academicyear();
		$acyear_array_data = $this->AcademicYear->academicYearInArray(date('Y') - ACY_BACK_FOR_ALL, date('Y'));
		$this->set(compact('thisacademicyear', 'acyear_array_data'));
	}

	public function index()
	{

		$page = 1;
		$sort = 'id';
		$direction = 'desc';

		if (isset($this->passedArgs) && !empty($this->passedArgs)) {
			if (isset($this->passedArgs['page'])) {
				$page = $this->request->data['DepartmentStudyProgram']['page'] = $this->passedArgs['page'];
			}

			if (isset($this->passedArgs['sort'])) {
				$sort = $this->request->data['DepartmentStudyProgram']['sort'] = $this->passedArgs['sort'];
			}

			if (isset($this->passedArgs['direction'])) {
				$direction = $this->request->data['DepartmentStudyProgram']['direction'] = $this->passedArgs['direction'];
			}
		}


		if (isset($this->request->data['search'])) {
			unset($this->passedArgs);
			$this->__init_clear_session_filters();
			$this->__init_search_study_programs();
		}

		$options = array();

		$programModalities = $this->DepartmentStudyProgram->ProgramModality->find('list');
		$qualifications = $this->DepartmentStudyProgram->Qualification->find('list');
		$academic_year = $this->DepartmentStudyProgram->find('list', array('fields' => array('DepartmentStudyProgram.academic_year', 'DepartmentStudyProgram.academic_year'), 'group' => array('DepartmentStudyProgram.academic_year')));

		$department_ids = $this->department_ids;
		$program_modality_ids = array_keys($programModalities);
		$qualification_ids = array_keys($qualifications);
		$apply_for_current_students = 1;
		$academic_years = $academic_year;


		if (!empty($this->request->data) && isset($this->request->data['DepartmentStudyProgram'])) {
			if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				$options['conditions'][] = array("DepartmentStudyProgram.department_id" => $this->department_id);
				$department_ids = $this->department_id;
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
				if (!empty($this->department_ids)) {
					$department_ids = $this->department_ids;
				} else {
					$department_ids = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1), 'fields' => array('Department.id', 'Department.id')));
				}
				if (!empty($this->request->data['DepartmentStudyProgram']['department_id'])) {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $this->request->data['DepartmentStudyProgram']['department_id']);
					$department_ids = $this->request->data['DepartmentStudyProgram']['department_id'];
				} else {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $department_ids);
				}
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
				if (!empty($this->request->data['DepartmentStudyProgram']['department_id'])) {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $this->request->data['DepartmentStudyProgram']['department_id']);
					$department_ids = $this->request->data['DepartmentStudyProgram']['department_id'];
				} else if (!empty($department_ids)) {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $department_ids);
				}
			} else {
				if (!empty($this->request->data['DepartmentStudyProgram']['department_id'])) {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $this->request->data['DepartmentStudyProgram']['department_id']);
					$department_ids = $this->request->data['DepartmentStudyProgram']['department_id'];
				} else if (!empty($department_ids)) {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $department_ids);
				}
			}

			if (!empty($this->request->data['DepartmentStudyProgram']['study_program_id'])) {
				$options['conditions'][] = array('DepartmentStudyProgram.study_program_id' => $this->request->data['DepartmentStudyProgram']['study_program_id']);
			}

			if (!empty($this->request->data['DepartmentStudyProgram']['program_modality_id'])) {
				$options['conditions'][] = array('DepartmentStudyProgram.program_modality_id' => $this->request->data['DepartmentStudyProgram']['program_modality_id']);
				$program_modality_ids = $this->request->data['DepartmentStudyProgram']['program_modality_id'];
			}

			if (!empty($this->request->data['DepartmentStudyProgram']['qualification_id'])) {
				$options['conditions'][] = array('DepartmentStudyProgram.qualification_id' => $this->request->data['DepartmentStudyProgram']['qualification_id']);
				$qualification_ids = $this->request->data['DepartmentStudyProgram']['qualification_id'];
			}

			if (!empty($this->request->data['DepartmentStudyProgram']['academic_year'])) {
				$ac_year = str_replace('-', '/', $this->request->data['DepartmentStudyProgram']['academic_year']);
				$options['conditions'][] = array('DepartmentStudyProgram.academic_year' => $ac_year);
				$academic_years = $ac_year;
			}

			if (isset($this->request->data['DepartmentStudyProgram']['apply_for_current_students'])) {
				$options['conditions'][] = array('DepartmentStudyProgram.apply_for_current_students' => $this->request->data['DepartmentStudyProgram']['apply_for_current_students']);
				$apply_for_current_students = $this->request->data['DepartmentStudyProgram']['apply_for_current_students'];
			}

		} else {
			if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
				if (!empty($this->department_ids)) {
					$department_ids = $this->department_ids;
				} else {
					$department_ids = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1), 'fields' => array('Department.id', 'Department.id')));
				}
				$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $department_ids, 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students);
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				$department_ids = $this->department_id;
				$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $this->department_id, 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students);
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
				if (!empty($this->department_ids)) {
					$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $this->department_ids, 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students);
				} else {
					$options['conditions'][] = array('DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students);
				}
			} else if (!empty($this->department_ids)) {
				$options['conditions'][] = array('DepartmentStudyProgram.department_id' => $this->department_ids, 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students);
			}
		}

		//debug($options);
		//$departmentStudyPrograms = $this->paginate($options);

		$departmentStudyPrograms = array();

		if (!empty($options['conditions'])) {

			$this->Paginator->settings =  array(
				'conditions' => $options['conditions'],
				'contain' => array(
					'Department' => array(
						'fields' => array('Department.id', 'Department.name',' Department.institution_code'),
						/* 'College' => array(
							'fields' => array('College.id', 'College.name',' College.institution_code'),
							'Campus' => array(
								'fields' => array('Campus.id', 'Campus.name',' Campus.campus_code')
							)
						) */
					), 
					'StudyProgram' => array('fields' => array('StudyProgram.id', 'StudyProgram.study_program_name', 'StudyProgram.code')),
					'ProgramModality' => array('fields' => array('ProgramModality.id', 'ProgramModality.code')),
					'Qualification'  => array('fields' => array('Qualification.id', 'Qualification.code')),
				), 
				'limit' => 100, 
				'maxLimit' => 100, 
				'order' => array('DepartmentStudyProgram.' . $sort . '' => $direction), 
				'page' => (!empty($page) ? $page : 1),
				'recursive' => -1
			);


			try {
				$departmentStudyPrograms = $this->Paginator->paginate($this->modelClass);
				$this->set(compact('departmentStudyPrograms'));
			} catch (NotFoundException $e) {
				unset($this->request->data['DepartmentStudyProgram']['page']);
				unset($this->request->data['DepartmentStudyProgram']['sort']);
				unset($this->request->data['DepartmentStudyProgram']['direction']);
				unset($this->passedArgs);
				return $this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				unset($this->request->data['DepartmentStudyProgram']['page']);
				unset($this->request->data['DepartmentStudyProgram']['sort']);
				unset($this->request->data['DepartmentStudyProgram']['direction']);
				unset($this->passedArgs);
				return $this->redirect(array('action' => 'index'));
			}
		}
	
		if (empty($departmentStudyPrograms) && !empty($options['conditions'])) {
			$this->Flash->info('No Department Study Program is found with the given search criteria.');
		}

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
			$departments = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.id' => $this->department_id)));
			$department_college_id = $this->DepartmentStudyProgram->Department->field('Department.college_id', array('Department.id' => $this->department_id));
			//$attachedStudyProgramsIDs = $this->DepartmentStudyProgram->find('list', array('conditions' => array('DepartmentStudyProgram.department_id' => $this->department_id, 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students), 'fields' => array('DepartmentStudyProgram.study_program_id', 'DepartmentStudyProgram.study_program_id')));
		} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
			//$departments = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1)));
			$departments = $this->DepartmentStudyProgram->Department->allDepartmentsByCollege2(0, array(), $this->college_id, 1);
			//$attachedStudyProgramsIDs = $this->DepartmentStudyProgram->find('list', array('conditions' => array('DepartmentStudyProgram.department_id' =>  array_keys($departments), 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students), 'fields' => array('DepartmentStudyProgram.study_program_id', 'DepartmentStudyProgram.study_program_id')));
		} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
			if (isset($this->department_ids) && !empty($this->department_ids)) {
				//$departments = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
				$departments = $this->DepartmentStudyProgram->Department->allDepartmentsByCollege2(0, $this->department_ids, array(), 1);
				//$attachedStudyProgramsIDs = $this->DepartmentStudyProgram->find('list', array('conditions' => array('DepartmentStudyProgram.department_id' => $this->department_ids, 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students), 'fields' => array('DepartmentStudyProgram.study_program_id', 'DepartmentStudyProgram.study_program_id')));
			} else {
				$departments = array();
				//$attachedStudyProgramsIDs = array();
			}
		} else {
			//$attachedStudyProgramsIDs = $this->DepartmentStudyProgram->find('list', array('fields' => array('DepartmentStudyProgram.study_program_id', 'DepartmentStudyProgram.study_program_id')));
			//$departments = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.active' => 1)));
			$departments = $this->DepartmentStudyProgram->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids, 1);
		}
		

		/* if (isset($this->request->data['DepartmentStudyProgram']['department_id']) && !empty($this->request->data['DepartmentStudyProgram']['department_id'])) {
			$attachedStudyProgramsIDs = $this->DepartmentStudyProgram->find('list', array('conditions' => array('DepartmentStudyProgram.department_id' => $this->request->data['DepartmentStudyProgram']['department_id'], 'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students), 'fields' => array('DepartmentStudyProgram.study_program_id', 'DepartmentStudyProgram.study_program_id')));
			$studyPrograms = $this->DepartmentStudyProgram->StudyProgram->find('list', array('conditions' => array('StudyProgram.id' => $attachedStudyProgramsIDs, 'StudyProgram.active' => 1), 'order' => array('StudyProgram.local_band', 'StudyProgram.study_program_name')));
		} else {
			$studyPrograms = $this->DepartmentStudyProgram->StudyProgram->find('list', array('conditions' => array('StudyProgram.id' => $attachedStudyProgramsIDs, 'StudyProgram.active' => 1), 'order' => array('StudyProgram.local_band', 'StudyProgram.study_program_name')));
		} */

		$this->__init_search_study_programs();

		$studyPrograms = array();

		if (!empty($department_ids) || !empty($this->department_ids)) {

			$attachedStudyProgramsIDs = $this->DepartmentStudyProgram->find('list', array(
				'conditions' => array(
					'DepartmentStudyProgram.department_id' => !(empty($department_ids) ? $department_ids : $this->department_ids),
					'DepartmentStudyProgram.program_modality_id' => $program_modality_ids,
					'DepartmentStudyProgram.qualification_id' => $qualification_ids,
					'DepartmentStudyProgram.academic_year' => $academic_years,
					'DepartmentStudyProgram.apply_for_current_students' => $apply_for_current_students
				), 
				'fields' => array('DepartmentStudyProgram.study_program_id', 'DepartmentStudyProgram.study_program_id')
			));

			if (!empty($attachedStudyProgramsIDs)) {
				$studyPrograms = $this->DepartmentStudyProgram->StudyProgram->find('list', array('conditions' => array('StudyProgram.id' => $attachedStudyProgramsIDs, 'StudyProgram.active' => 1), 'order' => array('StudyProgram.local_band', 'StudyProgram.study_program_name')));
			}
		}

		$this->set(compact(
			'departments',
			'departmentStudyPrograms',
			'studyPrograms',
			'programModalities',
			'qualifications',
			'academic_year',
			'apply_for_current_students'
		));
	}

	public function view($id = null)
	{
		if (!$id) {
			$this->Flash->error('Invalid Department Study Program ID');
			return $this->redirect(array('action' => 'index'));
		}

		$this->DepartmentStudyProgram->id = $id;

		if (!$this->DepartmentStudyProgram->exists()) {
			$this->Flash->error('Invalid Department Study Program ID');
			return $this->redirect(array('action' => 'index'));
		}

		$departmentStudyProgram = $this->DepartmentStudyProgram->find('first', array(
			'conditions' => array(
				'DepartmentStudyProgram.id' => $id
			), 
			'contain' => array(
				'Department' => array('fields' => array('Department.id', 'Department.name')),
				'StudyProgram' => array('fields' => array('StudyProgram.id', 'StudyProgram.study_program_name', 'StudyProgram.code')),
				'ProgramModality' => array('fields' => array('ProgramModality.id', 'ProgramModality.modality', 'ProgramModality.code')),
				'Qualification'  => array('fields' => array('Qualification.id', 'Qualification.qualification', 'Qualification.code')),
			),
			'recursive'=> -1
		));

		$associated_curriculums =  ClassRegistry::init('Curriculum')->find('all', array(
			'conditions' => array('Curriculum.department_study_program_id' => $id),
			'contain' => array(
				'Department' => array('fields' => array('Department.id', 'Department.name')),
				'Program' => array('fields' => array('Program.id', 'Program.name', 'Program.shortname')),
			),
			'order' => array('Curriculum.department_id', 'Curriculum.program_id', 'Curriculum.year_introduced'),
			'recursive'=> -1
		));
		

		$similar_study_programs = $this->DepartmentStudyProgram->find('list', array(
			'conditions' => array(
				'DepartmentStudyProgram.study_program_id' => $departmentStudyProgram['DepartmentStudyProgram']['study_program_id'],
				'NOT' => array(
					'DepartmentStudyProgram.id' => $id
				)
			),
			'fields' => array('DepartmentStudyProgram.id', 'DepartmentStudyProgram.id')
		));

		//debug($similar_study_programs);

		if (count($similar_study_programs)) {
			$similar_curriculums =  ClassRegistry::init('Curriculum')->find('all', array(
				'conditions' => array('Curriculum.department_study_program_id' => $similar_study_programs),
				'contain' => array(
					'Department' => array('fields' => array('Department.id', 'Department.name')),
					'Program' => array('fields' => array('Program.id', 'Program.name', 'Program.shortname')),
				),
				'order' => array('Curriculum.department_id', 'Curriculum.program_id', 'Curriculum.year_introduced'),
				'recursive'=> -1
			));
		} else {
			$similar_curriculums = array();
		}

		$this->set('departmentStudyProgram', $departmentStudyProgram);
		$this->set('associated_curriculums', $associated_curriculums);
		$this->set('similar_curriculums', $similar_curriculums);
	}

	public function add()
	{
		if (!empty($this->request->data) && isset($this->request->data['addStudyProgram'])) {
			if ($this->DepartmentStudyProgram->isUniqueDepartmentStudyProgram($this->request->data)) {
				$this->DepartmentStudyProgram->create();
				if ($this->DepartmentStudyProgram->save($this->request->data)) {
					$this->Flash->success('Department Study Program has been saved');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error('Department Study Program could not be saved. Please, try again.');
				}
			} else {
				$this->Flash->error('Department Study Program already exists. Change Study Program, Program Modality or Qualification and try again.');
			}
		}

		//$departments = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.active' => 1), 'order' => array('Department.college_id', 'Department.name')));
		$departments = $this->DepartmentStudyProgram->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids, 1);
		$studyPrograms = $this->DepartmentStudyProgram->StudyProgram->find('list', array('conditions' => array('StudyProgram.active' => 1), 'order' => array('StudyProgram.local_band', 'StudyProgram.study_program_name')));
		$programModalities = $this->DepartmentStudyProgram->ProgramModality->find('list');
		$qualifications = $this->DepartmentStudyProgram->Qualification->find('list');
		$academic_year = $this->AcademicYear->academicYearInArray(date('Y') - ACY_BACK_FOR_ALL, date('Y'));

		$this->set(compact('departments', 'studyPrograms', 'programModalities', 'qualifications', 'academic_year'));
	}

	public function edit($id = null)
	{
		if (!$id && empty($this->request->data)) {
			$this->Flash->error('Invalid Department Study Program ID');
			return $this->redirect(array('action' => 'index'));
		}

		$this->DepartmentStudyProgram->id = $id;

		if (!$this->DepartmentStudyProgram->exists()) {
			$this->Flash->error('Invalid Department Study Program ID');
			return $this->redirect(array('action' => 'index'));
		}

		$this->set($this->request->data);

		if (!empty($this->request->data) && isset($this->request->data['editStudyProgram'])) {
			if ($this->DepartmentStudyProgram->isUniqueDepartmentStudyProgram($this->request->data)) {
				if ($this->DepartmentStudyProgram->save($this->request->data)) {
					$this->Flash->success('Department Study Program has been updated');
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error('Department Study Program could not be updated. Please, try again.');
				}
			} else {
				$this->Flash->error('Department Study Program already exists. Change Study Program, Program Modality or Qualification and try again.');
			}
		}

		if (empty($this->request->data)) {
			$departmentStudyProgram = $this->DepartmentStudyProgram->find('first', array('conditions' => array('DepartmentStudyProgram.id' => $id), 'recursive'=> -1));
			$this->request->data =  $departmentStudyProgram;
		}

		//$departments = $this->DepartmentStudyProgram->Department->find('list', array('conditions' => array('Department.active' => 1), 'order' => array('Department.college_id', 'Department.name')));
		$departments = $this->DepartmentStudyProgram->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids, 1);
		$studyPrograms = $this->DepartmentStudyProgram->StudyProgram->find('list', array('conditions' => array('StudyProgram.active' => 1), 'order' => array('StudyProgram.local_band', 'StudyProgram.study_program_name')));
		$programModalities = $this->DepartmentStudyProgram->ProgramModality->find('list');
		$qualifications = $this->DepartmentStudyProgram->Qualification->find('list');
		$academic_year = $this->AcademicYear->academicYearInArray(date('Y') - ACY_BACK_FOR_ALL, date('Y'));

		$departmentStudyProgramDetails = $this->DepartmentStudyProgram->find('first', array(
			'conditions' => array(
				'DepartmentStudyProgram.id' => $id
			), 
			'contain' => array(
				//'Department' => array('fields' => array('Department.id', 'Department.name')), 
				'StudyProgram' => array('fields' => array('StudyProgram.study_program_name', 'StudyProgram.code')),
				'ProgramModality' => array('fields' => array('ProgramModality.modality')),
				'Qualification'  => array('fields' => array('Qualification.qualification')),
			),
			'recursive'=> -1
		));

		$this->set(compact('departments', 'studyPrograms', 'programModalities', 'qualifications', 'academic_year', 'departmentStudyProgramDetails'));
	}

	public function delete($id = null)
	{
		if (!$id) {
			$this->Flash->error('Invalid Department Study program ID');
			return $this->redirect(array('action' => 'index'));
		}

		$this->DepartmentStudyProgram->id = $id;

		if (!$this->DepartmentStudyProgram->exists()) {
			$this->Flash->error('Invalid Department Study program ID');
			return $this->redirect(array('action' => 'index'));
		}

		if ($this->DepartmentStudyProgram->canItBeDeleted($id)) {
			if ($this->DepartmentStudyProgram->delete($id)) {
				$this->Flash->success('Department Study Program is deleted.');
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->Flash->error('Department Study Program was not deleted, It is associated to Curriculums.');
		return $this->redirect(array('action' => 'index'));
	}

	function get_department_study_programs_combo($curriculum_id = null)
	{
		$this->layout = 'ajax';

		$departmentStudyPrograms = array();

		if (!empty($curriculum_id)) {

			$curriculumDetail = ClassRegistry::init('Curriculum')->find('first', array(
				'conditions' => array('Curriculum.id' => $curriculum_id), 
				'contain' => array(
					'Program' => array('fields' => 'Program.name'),
					'Department' => array('fields' => 'Department.name')
				), 
				'recursive' => -1
			));

			//debug($curriculumDetail);

			if (!empty($curriculumDetail)) {

				$qualification_ids = ClassRegistry::init('Qualification')->find('list', array('fields' => array('Qualification.id'), 'conditions' => array('Qualification.program_id' => $curriculumDetail['Curriculum']['program_id'])));
				//$program_modality_ids = $this->Curriculum->ProgramType->find('list', array('fields' => array('ProgramType.program_modality_id'), 'conditions' => array('ProgramType.id' => $curriculumDetail['Curriculum']['program_type_id'])));

				$departmentStudyProgramDetails = $this->DepartmentStudyProgram->find('all', array(
					'conditions' => array(
						'DepartmentStudyProgram.department_id' => $curriculumDetail['Curriculum']['department_id'],
						//'DepartmentStudyProgram.program_modality_id' => $program_modality_ids,
						'DepartmentStudyProgram.qualification_id' => $qualification_ids
					),
					'contain' => array(
						'StudyProgram' => array('fields' => array('id', 'study_program_name', 'code')),
						'ProgramModality' => array('fields' => array('id', 'modality', 'code')),
						'Qualification'  => array('fields' => array('id', 'qualification', 'code')),
					),
					'fields' => array('DepartmentStudyProgram.id', 'DepartmentStudyProgram.study_program_id')
				));
			}
	
			if (!empty($departmentStudyProgramDetails)) {
				foreach ($departmentStudyProgramDetails as $dspkey => $dspval) {
					$departmentStudyPrograms[$dspval['DepartmentStudyProgram']['id']] =  $dspval['StudyProgram']['study_program_name'] . '(' . $dspval['StudyProgram']['code'] .') => ' . $dspval['ProgramModality']['modality'] . '(' . $dspval['ProgramModality']['code'] . ') => ' . $dspval['Qualification']['qualification'] . '(' . $dspval['Qualification']['code'] . ')';
				}
			}
		}

		//debug($departmentStudyPrograms);

		$this->set(compact('departmentStudyPrograms')); 
		$this->set(compact('curriculumDetail'));
	}

	function get_selected_department_department_study_programs($department_id = null, $all = 0/* , $for_current_students_only = '' */)
	{
		$this->layout = 'ajax';

		$studyPrograms = array();

		/* if (empty($for_current_students_only)) {
			$apply_for_current_students = array(0 => 0, 1 => 1);
		} else {
			$apply_for_current_students =  $for_current_students_only;
		} */

		if (!empty($department_id) && $all) {
			$selectedDepartmentStudyPrograms = $this->DepartmentStudyProgram->find('list', array(
				'conditions' => array(
					'DepartmentStudyProgram.department_id' => $department_id,
				), 
				'fields' => array(
					'DepartmentStudyProgram.study_program_id',
					'DepartmentStudyProgram.study_program_id',
				)
			));
		} else if (!empty($department_id)) {
			$selectedDepartmentStudyPrograms = $this->DepartmentStudyProgram->find('list', array(
				'conditions' => array(
					'DepartmentStudyProgram.department_id' => $department_id,
				),
				'fields' => array(
					'DepartmentStudyProgram.study_program_id',
					'DepartmentStudyProgram.study_program_id',
				)
			));
		} else {
			if (!empty($this->department_ids)) {
				$selectedDepartmentStudyPrograms = $this->DepartmentStudyProgram->find('list', array(
					'conditions' => array(
						'DepartmentStudyProgram.department_id' => $this->department_ids,
					), 
					'fields' => array(
						'DepartmentStudyProgram.study_program_id',
						'DepartmentStudyProgram.study_program_id',
					)
				));
			} else {
				$selectedDepartmentStudyPrograms = $this->DepartmentStudyProgram->find('list', array(
					'fields' => array(
						'DepartmentStudyProgram.study_program_id',
						'DepartmentStudyProgram.study_program_id',
					)
				));
			}
		}

		if (isset($selectedDepartmentStudyPrograms) && !empty($selectedDepartmentStudyPrograms)) {
			$studyPrograms = $this->DepartmentStudyProgram->StudyProgram->find('list', array('conditions' => array('StudyProgram.id' => $selectedDepartmentStudyPrograms)));
		}

		//debug($studyPrograms);

		$this->set(compact('studyPrograms'));
	}
}
