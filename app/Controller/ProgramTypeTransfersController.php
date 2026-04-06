<?php
class ProgramTypeTransfersController extends AppController {

	var $name = 'ProgramTypeTransfers';

	var $menuOptions = array(
		'parent' => 'transfers',
		'exclude' => array('notify_program_transfer_to_department'),
		'alias' => array(
			'index' => 'View transfer',
			'add' => 'Transfer',
		)
	);

    var $components = array('AcademicYear');

	function __init_search_program_type_transfers()
	{
		if (!empty($this->request->data['ProgramTypeTransfer'])) {
			$this->Session->write('ProgramTypeTransfer.program_type_transfer', $this->request->data['ProgramTypeTransfer']);
		} else {
			if ($this->Session->check('ProgramTypeTransfer.program_type_transfer')) {
				$this->request->data['ProgramTypeTransfer'] = $this->Session->read('ProgramTypeTransfer.program_type_transfer');
			}
		}
	}

	function __init_clear_session_filters($data = null)
	{
		if ($this->Session->check('ProgramTypeTransfer.program_type_transfer')) {
			$this->Session->delete('ProgramTypeTransfer.program_type_transfer');
		}
	}
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->Auth->allow('search');
	}
    
    function beforeRender() 
	{
		parent::beforeRender();

		$current_academicyear = $defaultacademicyear = $this->AcademicYear->current_academicyear();
		$acyear_array_data = $this->AcademicYear->academicYearInArray((explode('/', $current_academicyear)[0]) - ACY_BACK_FOR_ALL, (explode('/', $current_academicyear)[0]));

		$programs = ClassRegistry::init('Program')->find('list', array('conditions' => array('Program.id' => $this->program_ids, 'Program.active' => 1)));
		$program_types = $programTypes = ClassRegistry::init('ProgramType')->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids, 'ProgramType.active' => 1)));

		$this->set(compact('acyear_array_data','defaultacademicyear', 'programs', 'program_types', 'programTypes'));
	}

	function index($data = null)
	{

		$page = '';
		$limit = 100;
		$name = '';

		$order = array(
			'ProgramTypeTransfer.academic_year' => 'ASC',
			'ProgramTypeTransfer.semester' => 'ASC',
			'ProgramTypeTransfer.program_type_id' => 'ASC',
			'ProgramTypeTransfer.transfer_date' => 'DESC',
			'ProgramTypeTransfer.student_id' => 'ASC',
		);

		if (isset($this->passedArgs) && !empty($this->passedArgs)) {
			if (isset($this->passedArgs['page'])) {
				$page = $this->request->data['ProgramTypeTransfer']['page'] = $this->passedArgs['page'];
			}

			if (isset($this->passedArgs['sort'])) {
				$this->request->data['ProgramTypeTransfer']['sort'] = $this->passedArgs['sort'];
			}

			if (isset($this->passedArgs['direction'])) {
				$this->request->data['ProgramTypeTransfer']['direction'] = $this->passedArgs['direction'];
			}
		}

		if (isset($this->request->data['ProgramTypeTransfer']['sort']) && !empty($this->request->data['ProgramTypeTransfer']['sort'])) {
			$order = array(
				'ProgramTypeTransfer.'. $this->request->data['ProgramTypeTransfer']['sort'] => (isset($this->request->data['ProgramTypeTransfer']['direction']) ? $this->request->data['ProgramTypeTransfer']['direction'] : 'ASC'),
			);
		}


		if (isset($this->request->data['viewProgramTransfer'])) {
			unset($this->passedArgs);
			$this->__init_clear_session_filters();
			$this->__init_search_program_type_transfers();
		}

		$options = array();


		if (!empty($this->request->data)) {

			if (!empty($page) && !isset($this->request->data['viewProgramTransfer'])) {
				$this->request->data['ProgramTypeTransfer']['page'] = $page;
			}

			if (isset($this->request->data['ProgramTypeTransfer']['name']) && !empty($this->request->data['ProgramTypeTransfer']['name'])) {
				$name = trim($this->request->data['ProgramTypeTransfer']['name']);
			}


			$this->__init_search_program_type_transfers();

			if (!empty($this->request->data['ProgramTypeTransfer']['program_type_id'])) {
				$options['conditions'][] = array(
					'Student.program_type_id' => $this->request->data['ProgramTypeTransfer']['program_type_id'], 
					'ProgramTypeTransfer.program_type_id' => $this->request->data['ProgramTypeTransfer']['program_type_id']
				);
			} else if (!empty($this->program_type_ids)) {
				$options['conditions'][] = array(
					'Student.program_type_id' => $this->program_type_ids, 
					'ProgramTypeTransfer.program_type_id' => $this->program_type_ids
				);
			}

			if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {

				$options['conditions'][] = array('Student.department_id' => $this->department_id);

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
				
				$department_ids = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1), 'fields' => array('Department.id', 'Department.id')));

				if (!empty($this->request->data['ProgramTypeTransfer']['department_id'])) {
					$options['conditions'][] = array('Student.department_id' => $this->request->data['ProgramTypeTransfer']['department_id']);
				} else {
					$options['conditions'][] = array('Student.department_id' => $department_ids);
				}

				$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1)));

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {

				if (isset($this->request->data['ProgramTypeTransfer']['college_id']) && !empty($this->request->data['ProgramTypeTransfer']['college_id']) && isset($this->request->data['ProgramTypeTransfer']['department_id']) && empty($this->request->data['ProgramTypeTransfer']['department_id'])) {
					$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['ProgramTypeTransfer']['college_id'], 'Department.active' => 1)));
					$options['conditions'][] = array('Student.department_id' => array_keys($departments));
				} else {
					$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
					if (!empty($this->request->data['ProgramTypeTransfer']['department_id'])) {
						$options['conditions'][] = array('Student.department_id' => $this->request->data['ProgramTypeTransfer']['department_id']);
					} else if (empty($this->request->data['ProgramTypeTransfer']['department_id']) && !empty($this->request->data['ProgramTypeTransfer']['college_id']) ) {
						$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['ProgramTypeTransfer']['college_id'], 'Department.active' => 1)));
						$options['conditions'][] = array('Student.department_id' => array_keys($departments));
					} else {
						$options['conditions'][] = array('Student.department_id' => $this->department_ids);
					}
				}

				$college_ids = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1), 'fields' => array('Department.college_id')));
				$colleges = $this->ProgramTypeTransfer->Student->Department->College->find('list', array('conditions' => array('College.id' => $college_ids, 'College.active' => 1)));

			} else {

				if (!empty($this->college_ids)) {
					$colleges = $this->ProgramTypeTransfer->Student->Department->College->find('list', array('conditions' => array('College.id' => $this->college_ids, 'College.active' => 1)));
				} else {
					$colleges = $this->ProgramTypeTransfer->Student->Department->College->find('list', array('conditions' => array('College.active' => 1)));
				}

				$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => array_keys($colleges), 'Department.active' => 1)));

				if (isset($this->request->data['ProgramTypeTransfer']['college_id']) && !empty($this->request->data['ProgramTypeTransfer']['college_id']) && isset($this->request->data['ProgramTypeTransfer']['department_id']) && !empty($this->request->data['ProgramTypeTransfer']['department_id'])) {
					$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['ProgramTypeTransfer']['college_id'], 'Department.active' => 1)));
					$options['conditions'][] = array('Student.department_id' => array_keys($departments));
				} else {

					if (!empty($this->request->data['ProgramTypeTransfer']['department_id'])) {
						$options['conditions'][] = array('Student.department_id' => $this->request->data['ProgramTypeTransfer']['department_id']);
					} else if (empty($this->request->data['ProgramTypeTransfer']['department_id']) && !empty($this->request->data['ProgramTypeTransfer']['college_id']) ) {
						$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['ProgramTypeTransfer']['college_id'], 'Department.active' => 1)));
						$options['conditions'][] = array('Student.department_id' => array_keys($departments));
					} else {
						$options['conditions'][] = array('Student.department_id' => array_keys($departments));
					}

					if (!empty($this->department_ids)) {
						$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
					} else {
						if (!empty($this->college_ids)) {
							$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_ids, 'Department.active' => 1)));
						} else {
							$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.active' => 1)));
						}
					}
				}
			}

			if (!empty($this->request->data['ProgramTypeTransfer']['program_id'])) {
				$options['conditions'][] = array('Student.program_id' => $this->request->data['ProgramTypeTransfer']['program_id']);
			} else if (!empty($this->program_ids)) {
				$options['conditions'][] = array('Student.program_id' => $this->program_ids);
			}

			if (isset($name) && !empty($name)) {
				$options['conditions'][] = array(
					'OR' => array(
						'Student.first_name LIKE ' => '%' . $name . '%',
						'Student.middle_name LIKE ' =>  '%' . $name . '%',
						'Student.last_name LIKE ' =>  '%' . $name . '%',
						'Student.studentnumber LIKE ' =>  $name . '%',
					)
				);
			}

			if (isset($this->request->data['ProgramTypeTransfer']['limit']) && empty($this->request->data['ProgramTypeTransfer']['limit'])) {
				$limit = $this->request->data['ProgramTypeTransfer']['limit'];
			}

			if (!empty($this->request->data['ProgramTypeTransfer']['college_id'])) {
				$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['ProgramTypeTransfer']['college_id'], 'Department.active' => 1)));
			}

		} else {

			if (!empty($this->program_ids)) {
				$options['conditions'][] = array('Student.program_id' => $this->program_ids);
			}

			if (!empty($this->program_type_ids)) {
				$options['conditions'][] = array(
					'Student.program_type_id' => $this->program_type_ids, 
					'ProgramTypeTransfer.program_type_id' => $this->program_type_ids
				);
			}

			if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
				$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1)));
				$options['conditions'][] = array('Student.department_id' => array_keys($departments));
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_id)));
				$options['conditions'][] = array('Student.department_id' => $this->department_id);
			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
				if (!empty($this->department_ids)) {
					$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
					$college_ids = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1 ), 'fields' => array('Department.college_id')));
					$colleges = $this->ProgramTypeTransfer->Student->Department->College->find('list', array('conditions' => array('College.id' => $college_ids, 'College.active' => 1)));
					$options['conditions'][] = array('Student.department_id' => $this->department_ids);
				}
			} else {
				$departments = $this->ProgramTypeTransfer->Student->Department->find('list', array('conditions' => array('Department.active' => 1)));
				$colleges = $this->ProgramTypeTransfer->Student->Department->College->find('list', array('conditions' => array('College.active' => 1)));
				$options['conditions'][] = array('Student.department_id' => array_keys($departments));
			}
		}

		//debug($options['conditions']);
		$programTypeTransfers = array();

		if (!empty($options['conditions'])) {

			$this->Paginator->settings =  array(
				'conditions' => $options['conditions'],
				'contain' => array(
					'ProgramType', 
					'Student' => array(
						'Department', 
						'College', 
						'ProgramType', 
						'Program'
					)
				),
				'order' => $order,
				'limit' => $limit,
				'maxLimit' => $limit,
				'recursive'=> -1,
				'page' => $page
			);

			try {
				$programTypeTransfers = $this->Paginator->paginate($this->modelClass);
				$this->set(compact('programTypeTransfers'));
			} catch (NotFoundException $e) {
				unset($this->request->data['ProgramTypeTransfer']['page']);
				unset($this->request->data['ProgramTypeTransfer']['sort']);
				unset($this->request->data['ProgramTypeTransfer']['direction']);
				unset($this->passedArgs);
				return $this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				unset($this->request->data['ProgramTypeTransfer']['page']);
				unset($this->request->data['ProgramTypeTransfer']['sort']);
				unset($this->request->data['ProgramTypeTransfer']['direction']);
				unset($this->passedArgs);
				return $this->redirect(array('action' => 'index'));
			}

		} else {
			$programTypeTransfers = array();
			$this->set(compact('programTypeTransfers'));
		}

		//debug($programTypeTransfers);
			
		if (empty($programTypeTransfers) && !empty($options['conditions'])) {
			$this->Flash->info('No Program Type Transfers found based on the the given search criteria.');
		}

		$department_type = 'Department';

		if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
			$department_college_id = $this->ProgramTypeTransfer->Student->Department->field('Department.college_id', array('Department.id' => $this->department_id));
			$college_type = $this->ProgramTypeTransfer->Student->Department->College->field('College.type', array('College.id' => $department_college_id));
			$department_type = $this->ProgramTypeTransfer->Student->Department->field('Department.type', array('Department.id' => $this->department_id));
			if (empty($department_type)) {
				$department_type = 'Department';
			}
		} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
			$college_type = $this->ProgramTypeTransfer->Student->Department->College->field('College.type', array('College.id' => $this->college_id));
		} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
			$programs = $this->ProgramTypeTransfer->Student->Program->find('list', array('conditions' => array('Program.id' => $this->program_ids)));
			$college_type = '';
		} else {
			$college_type = '';
		}
		
		$programs =  $this->ProgramTypeTransfer->Student->Program->find('list', array('conditions' => array('Program.id' => $this->program_ids, 'Program.active' => 1)));
		$program_types = $programTypes =  $this->ProgramTypeTransfer->Student->ProgramType->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids, 'ProgramType.active' => 1)));

		if ($this->Session->read('Auth.User')['role_id'] != ROLE_DEPARTMENT) {
			if (isset($this->request->data['ProgramTypeTransfer']['college_id']) && !empty($this->request->data['ProgramTypeTransfer']['college_id'])) {
				$departments = $this->ProgramTypeTransfer->Student->Department->allDepartmentsByCollege2(0, null, $this->request->data['ProgramTypeTransfer']['college_id'], 1, $excludeFreshmanFromList = 1);
			} else {
				// exclude Freshman from list of departments, not requied here.
				$departments = $this->ProgramTypeTransfer->Student->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids, 1, $excludeFreshmanFromList = 1);
			}
		}

		$this->set(compact('colleges', 'college_type', 'programs', 'programTypes', 'departments', 'department_type', 'name'));
	}

	function view($id = null) 
	{
		if (!$id) {
			$this->Session->setFlash(__('Invalid program type transfer'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->ProgramTypeTransfer->id = $id;

		if (!$this->ProgramTypeTransfer->exists()) {
			$this->Flash->error('Invalid program type transfer');
			return $this->redirect(array('action' => 'index'));
		}
		
		$programTypeTransfer = $this->ProgramTypeTransfer->find('first', array('conditions' => array('ProgramTypeTransfer.id' => $id), 'recursive' => -1));

		if (empty($this->request->data)) {
			$this->request->data = $programTypeTransfer;
		}

		$students = $this->ProgramTypeTransfer->Student->find('list', array('conditions' => array('Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']), 'fields' => array('id', 'full_name_studentnumber')));
		$programTypes = $this->ProgramTypeTransfer->ProgramType->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids, 'ProgramType.active' => 1)));

		$isGraduated = $this->ProgramTypeTransfer->Student->field('graduated', array('Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']));
		
		$current_academicyear = $this->AcademicYear->current_academicyear();
		$acyear_array_data_custom = $this->AcademicYear->academicYearInArray((explode('/', $current_academicyear)[0]) - ACY_BACK_FOR_ALL, (explode('/', $current_academicyear)[0]));

		$check_elegibility = 0;

		if (!empty($this->college_ids)) {
			$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
				'conditions' => array(
					'Student.college_id' => $this->college_ids,
					'Student.program_type_id' => $this->program_type_ids,
					'Student.program_id' => $this->program_ids,
					'Student.id' => $id
				)
			));
		} else if (!empty($this->department_ids)) {
			$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
				'conditions' => array(
					'Student.department_id' => $this->department_ids,
					'Student.program_type_id' => $this->program_type_ids,
					'Student.program_id' => $this->program_ids,
					'Student.id' => $id
				)
			));
		}

		if ($check_elegibility == 0) {
			$this->Flash->error(__('You are not eligible to access ' . (array_values($students)[0]). '\'s profile. You are attempting to access students outside your assigned scope. If you believe you are eligible, please verify your assignment.'));
			$this->redirect(array('action' => 'index'));
		}


		if ($isGraduated || (isset($programTypeTransfer['ProgramTypeTransfer']['academic_year']) && !empty($programTypeTransfer['ProgramTypeTransfer']['academic_year']) && !in_array($programTypeTransfer['ProgramTypeTransfer']['academic_year'], $acyear_array_data_custom))) {
			$acyear_array_data_custom = array(); // only show the transfered academic_year, not allow editing acy if it is old transfer or the student is graduated
			$acyear_array_data_custom[$programTypeTransfer['ProgramTypeTransfer']['academic_year']] = $programTypeTransfer['ProgramTypeTransfer']['academic_year'];
		}

		if ($isGraduated) {
			$this->Flash->info(__((array_values($students)[0]) . ' is a graduated student.'));
		}

		$this->set(compact('students', 'programTypes', 'acyear_array_data_custom', 'isGraduated'));
	}

	function add() 
	{
		if (!empty($this->request->data) && isset($this->request->data['saveTransfer'])) {
			
			$this->ProgramTypeTransfer->create();
			
			if ($this->ProgramTypeTransfer->getProgramTransferDate($this->request->data) && $this->ProgramTypeTransfer->noDuplicateEntry($this->request->data) && isset($this->request->data['ProgramTypeTransfer']['student_id'])) {
			    
			    if ($this->ProgramTypeTransfer->save($this->request->data['ProgramTypeTransfer'])) {

					ClassRegistry::init('Student')->id = $this->request->data['ProgramTypeTransfer']['student_id'];
					ClassRegistry::init('Student')->saveField('program_type_id', $this->request->data['ProgramTypeTransfer']['program_type_id']);

					// detach student attached curriculum 
					ClassRegistry::init('Student')->saveField('curriculum_id', NULL);

					$accepted_student_id = $this->ProgramTypeTransfer->Student->field('accepted_student_id', array('Student.id' => $this->request->data['ProgramTypeTransfer']['student_id']));

					if (!empty($accepted_student_id)) {
						ClassRegistry::init('AcceptedStudent')->id = $accepted_student_id;
						ClassRegistry::init('AcceptedStudent')->saveField('program_type_id', $this->request->data['ProgramTypeTransfer']['program_type_id']);

						// detach student attached curriculum 
						ClassRegistry::init('AcceptedStudent')->saveField('curriculum_id', NULL);
						ClassRegistry::init('AcceptedStudent')->saveField('Placement_Approved_By_Department', NULL);
					}

					// make the student section less and allow department to put him in the new section.
					$sectionDeactivate = $this->ProgramTypeTransfer->query("UPDATE students_sections SET archive = 1 WHERE student_id = " . $this->request->data['ProgramTypeTransfer']['student_id'] . "");
					//debug($sectionDeactivate);

					$this->Flash->success(__('The program type transfer has been saved. Please communicate student department to attach curriculum and assign section.'), 'default', array('class' => 'success-box success-message'));
					$this->redirect(array('action' => 'index'));
				
			    } else {
					$this->Flash->error(__('The program type transfer could not be saved. Please, try again.'));
					$this->request->data['continue'] = true;
					$student_number = $this->ProgramTypeTransfer->Student->field('studentnumber', array('id' => trim($this->request->data['ProgramTypeTransfer']['student_id'])));
					$this->request->data['ProgramTypeTransfer']['studentID'] = $student_number;
			    }
	        } else {

				$error = $this->ProgramTypeTransfer->invalidFields();

				if (isset($error['error'])) {
					$this->Flash->error(__($error['error'][0]));
				}
			}
		}

		if (!empty($this->request->data) && isset($this->request->data['continue'])) {

			$everythingfine = false;

			if (!empty($this->request->data['ProgramTypeTransfer']['studentID'])) {
				
				$check_id_is_valid = $this->ProgramTypeTransfer->Student->find('count', array('conditions' => array('Student.studentnumber' => trim($this->request->data['ProgramTypeTransfer']['studentID']))));
				$studentIDs = 1;

				if ($check_id_is_valid > 0) {

					$everythingfine = true;
					$student_id = $this->ProgramTypeTransfer->Student->field('id', array('studentnumber' => trim($this->request->data['ProgramTypeTransfer']['studentID'])));

					$student_section_exam_status = $this->ProgramTypeTransfer->Student->get_student_section($student_id);

					$isGraduated = $this->ProgramTypeTransfer->Student->field('graduated', array('Student.id' => $student_id));
					$studentsNameNumber = $this->ProgramTypeTransfer->Student->find('list', array('conditions' => array('Student.id' => $student_id), 'fields' => array('id', 'full_name_studentnumber')));

					$check_elegibility = 0;

					if (!empty($this->college_ids)) {
						$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
							'conditions' => array(
								'Student.college_id' => $this->college_ids,
								'Student.program_type_id' => $this->program_type_ids,
								'Student.program_id' => $this->program_ids,
								'Student.id' => $student_id
							)
						));
					} else if (!empty($this->department_ids)) {
						$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
							'conditions' => array(
								'Student.department_id' => $this->department_ids,
								'Student.program_type_id' => $this->program_type_ids,
								'Student.program_id' => $this->program_ids,
								'Student.id' => $student_id
							)
						));
					}

					if ($check_elegibility == 0) {
						$this->Flash->error(__('You are not eligible to access ' . (array_values($studentsNameNumber)[0]). '\'s profile. You are attempting to access students outside your assigned scope. If you believe you are eligible, please verify your assignment.'));
						$this->redirect(array('action' => 'index'));
					}

					if ($isGraduated) {
						$this->Flash->warning(__((array_values($studentsNameNumber)[0]) . ' is a graduated student and you can\'t add program type transfer at this time.'));
						return $this->redirect(array('action' => 'add'));
					}

					// check if there is a recorded program transfer on the name of the student and notify the user 
					$programTypeTransfer = $this->ProgramTypeTransfer->find('first', array('conditions' => array('ProgramTypeTransfer.student_id' => $student_id), 'recursive' => -1));

					if (!empty($programTypeTransfer)) {
						$this->Flash->warning(__('There is a previous program transfer for ' . (array_values($studentsNameNumber)[0]) . ' recorded on ' . (date('M j, Y h:i A', strtotime($programTypeTransfer['ProgramTypeTransfer']['created']))) . '.  Please check that before adding a new one.'));
						//return $this->redirect(array('action' => 'index'));
					}

					$this->set(compact('studentIDs', 'student_id', 'student_section_exam_status', 'isGraduated'));
				} else {
					$this->Flash->error( __('The provided student number "' . $this->request->data['ProgramTypeTransfer']['studentID'] . '" is not valid.'));
				}
			} else {
				$this->Flash->error( __('Please provide student number to maintain student program transfer.'));
			}
		}
		
		$programTypes = $this->ProgramTypeTransfer->Student->ProgramType->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids, 'ProgramType.active' => 1)));
		$this->set(compact('programTypes'));

	}

	function edit($id = null)
	{
		
		if (!$id && empty($this->request->data)) {
			$this->Flash->error(__('Invalid program type transfer ID!'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->ProgramTypeTransfer->id = $id;

		if (!$this->ProgramTypeTransfer->exists()) {
			$this->Flash->error('Invalid program type transfer ID!');
			return $this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data) && isset($this->request->data['saveTransfer'])) {
			if ($this->ProgramTypeTransfer->save($this->request->data)) {
				$this->Flash->success(__('The program type transfer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The program type transfer could not be saved. Please try again.'));
			}
		}

		$programTypeTransfer = $this->ProgramTypeTransfer->find('first', array('conditions' => array('ProgramTypeTransfer.id' => $id), 'recursive' => -1));

		if (empty($this->request->data)) {
			//$this->request->data = $this->ProgramTypeTransfer->read(null, $id);
			$this->request->data = $programTypeTransfer;
		}

		$students = $this->ProgramTypeTransfer->Student->find('list', array('conditions' => array('Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']), 'fields' => array('id', 'full_name_studentnumber')));
		$programTypes = $this->ProgramTypeTransfer->ProgramType->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids, 'ProgramType.active' => 1)));

		$check_elegibility = 0;

		if (!empty($this->college_ids)) {
			$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
				'conditions' => array(
					'Student.college_id' => $this->college_ids,
					'Student.program_type_id' => $this->program_type_ids,
					'Student.program_id' => $this->program_ids,
					'Student.id' => $id
				)
			));
		} else if (!empty($this->department_ids)) {
			$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
				'conditions' => array(
					'Student.department_id' => $this->department_ids,
					'Student.program_type_id' => $this->program_type_ids,
					'Student.program_id' => $this->program_ids,
					'Student.id' => $id
				)
			));
		}

		if ($check_elegibility == 0) {
			$this->Flash->error(__('You are not eligible to access ' . (array_values($students)[0]). '\'s profile. You are attempting to access students outside your assigned scope. If you believe you are eligible, please verify your assignment.'));
			$this->redirect(array('action' => 'index'));
		}

		$isGraduated = $this->ProgramTypeTransfer->Student->field('graduated', array('Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']));
		
		$current_academicyear = $this->AcademicYear->current_academicyear();
		$acyear_array_data_custom = $this->AcademicYear->academicYearInArray((explode('/', $current_academicyear)[0]) - ACY_BACK_FOR_ALL, (explode('/', $current_academicyear)[0]));

		if ($isGraduated || (isset($programTypeTransfer['ProgramTypeTransfer']['academic_year']) && !empty($programTypeTransfer['ProgramTypeTransfer']['academic_year']) && !in_array($programTypeTransfer['ProgramTypeTransfer']['academic_year'], $acyear_array_data_custom))) {
			$acyear_array_data_custom = array(); // only show the transfered academic_year, not allow editing acy if it is old transfer or the student is graduated
			$acyear_array_data_custom[$programTypeTransfer['ProgramTypeTransfer']['academic_year']] = $programTypeTransfer['ProgramTypeTransfer']['academic_year'];
		}

		if ($isGraduated) {
			$this->Flash->warning(__((array_values($students)[0]) . ' is a graduated student and you can\'t edit program type transfer at this time.'));
		}

		$this->set(compact('students', 'programTypes', 'acyear_array_data_custom', 'isGraduated'));
	}

	function delete($id = null)
	{
		
		if (!$id) {
			$this->Flash->error(__('Invalid id for program type transfer ID!'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->ProgramTypeTransfer->id = $id;

		if (!$this->ProgramTypeTransfer->exists()) {
			$this->Flash->error('Invalid program type transfer ID!');
			return $this->redirect(array('action' => 'index'));
		}

		$programTypeTransfer = $this->ProgramTypeTransfer->find('first', array('conditions' => array('ProgramTypeTransfer.id' => $id), 'recursive' => -1));
		$students = $this->ProgramTypeTransfer->Student->find('list', array('conditions' => array('Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']), 'fields' => array('id', 'full_name_studentnumber')));
		$isGraduated = $this->ProgramTypeTransfer->Student->field('graduated', array('Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']));

		$check_elegibility = 0;

		if (!empty($this->college_ids)) {
			$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
				'conditions' => array(
					'Student.college_id' => $this->college_ids,
					'Student.program_type_id' => $this->program_type_ids,
					'Student.program_id' => $this->program_ids,
					'Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']
				)
			));
		} else if (!empty($this->department_ids)) {
			$check_elegibility = $this->ProgramTypeTransfer->Student->find('count', array(
				'conditions' => array(
					'Student.department_id' => $this->department_ids,
					'Student.program_type_id' => $this->program_type_ids,
					'Student.program_id' => $this->program_ids,
					'Student.id' => $programTypeTransfer['ProgramTypeTransfer']['student_id']
				)
			));
		}

		if ($check_elegibility == 0) {
			$this->Flash->error(__('You are not eligible to access ' . (array_values($students)[0]). '\'s profile. You are attempting to access students outside your assigned scope. If you believe you are eligible, please verify your assignment.'));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!$isGraduated) {
			if ($this->ProgramTypeTransfer->delete($id)) {
				$this->Flash->success(__('This program type transfer for ' . (array_values($students)[0]) . ' is deleted successfuly.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error( __('Program type transfer was not deleted'));
		} else {
			$this->Flash->warning(__((array_values($students)[0]) . ' is a graduated student and you can\'t delete program type transfer at this time.'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	function notify_program_transfer_to_department()
	{
		$options = array();
		$options['conditions'][] = array('Student.department_id' => $this->department_id);
		$options['conditions'][] = array('ProgramTypeTransfer.academic_year' => $this->AcademicYear->current_academicyear());
	}
}
