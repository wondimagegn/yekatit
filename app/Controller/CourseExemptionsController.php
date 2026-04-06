<?php
class CourseExemptionsController extends AppController
{

	var $name = 'CourseExemptions';

	var $menuOptions = array(
		'parent' => 'registrations',
		'exclude' => array(
			'approve_request', 
			'index',
			'add_student_exempted_course',
			'add_student_exemption',
			'search',
			'invalid'
		),
		'alias' => array(
			'list_exemption_request' => 'Approve Exemption Requests',
			'add' => 'Add Course Exemption Request',
			'list_approved' => 'List Exemption Requests'
		)
	);
	
	var $helpers = array('Media.Media');
	var $components = array('AcademicYear');

	function beforeRender()
	{
		$acyear_array_data = $this->AcademicYear->acyear_array();
		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		
		$programs = $this->CourseExemption->Student->Program->find('list', array('conditions' => array('Program.id' => $this->program_ids)));
		$programTypes = $program_types = $this->CourseExemption->Student->ProgramType->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids)));

		$this->set(compact('acyear_array_data', 'defaultacademicyear', 'programs', 'programTypes', 'program_types'));

		if (isset($this->request->data['User']['password'])) {
			unset($this->request->data['User']['password']);
		}
		
	}
	
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->Allow('invalid', 'search');
	}

	function search()
	{
		$url['action'] = 'list_approved';

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

	function __init_search_index()
	{
		if (!empty($this->request->data['Search'])) {
			$this->Session->write('search_data_index', $this->request->data['Search']);
		} else if ($this->Session->check('search_data_index')) {
			$this->request->data['Search'] = $this->Session->read('search_data_index');
		}
	}

	function __init_clear_session_filters()
	{
		if ($this->Session->check('search_data_index')) {
			$this->Session->delete('search_data_index');
		}

		if ($this->Session->check('search_data_approve')) {
			$this->Session->delete('search_data_approve');
		}
	}

	function list_exemption_request()
	{

		if ((($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) && $this->Session->read('Auth.User')['is_admin']) || $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR/*  || $this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT */) {
			return $this->redirect(array('action' => 'list_approved'));
		}

		return $this->redirect('/');

		// this is a duplicate implementation to that of list_approved, Neway

		/* $conditions = array();
		$limit = 100;

		if ($this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT) {

			if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				
				$conditions['conditions'][] = array(
					"CourseExemption.department_accept_reject is null",
					"Student.department_id" => $this->department_id,
					"Student.program_id" => (!empty($this->program_ids) ? $this->program_ids : 0),
					"Student.program_type_id" => (!empty($this->program_type_ids) ? $this->program_type_ids : 0),
					"Student.graduated" => 0
				);

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {

				if (!empty($this->college_ids)) {
					
					$conditions['conditions'][] = array(
						"Student.department_id is null",
						"Student.college_id " => $this->college_ids,
						"Student.program_id" => (!empty($this->program_ids) ? $this->program_ids : 0),
						"Student.program_type_id" => (!empty($this->program_type_ids) ? $this->program_type_ids : 0),
						"Student.graduated" => 0,
						"CourseExemption.registrar_confirm_deny is null",
						"CourseExemption.department_accept_reject" => 1,
					);

				} else if (!empty($this->department_ids)) {

					$conditions['conditions'][] = array(
						"Student.department_id" => $this->department_ids,
						"Student.program_id" => (!empty($this->program_ids) ? $this->program_ids : 0),
						"Student.program_type_id" => (!empty($this->program_type_ids) ? $this->program_type_ids : 0),
						"Student.graduated" => 0,
						"CourseExemption.registrar_confirm_deny is null",
						"CourseExemption.department_accept_reject" => 1,
					);

				}
			}
		}

		//debug($conditions['conditions']);

		$courseExemptions = array();

		if (!empty($conditions['conditions'])) {
			$this->Paginator->settings = array(
				'conditions' => $conditions['conditions'],
				'contain' => array(
					'Course' => array('id', 'course_code_title', 'credit'),
					'Student' => array(
						'fields' => array('id', 'full_name', 'program_id', 'program_type_id', 'graduated', 'gender', 'studentnumber'), 
						'Program' => array('id', 'name'), 
						'ProgramType' => array('id', 'name'), 
						'Department' => array('id', 'name')
					)
				),
				'order' => array('CourseExemption.request_date' => 'DESC'),
				'limit' => $limit,
				'maxLimit' => $limit, 
			);

			try {
				$courseExemptions = $this->Paginator->paginate($this->modelClass);
				$this->set(compact('courseExemptions'));
			} catch (NotFoundException $e) {
				if (!empty($this->request->data['Search'])) {
					unset($this->request->data['Search']['page']);
					unset($this->request->data['Search']['sort']);
					unset($this->request->data['Search']['direction']);
				}
				if (isset($this->passedArgs)) {
					unset($this->passedArgs);
				}
				return $this->redirect(array('action' => 'index'));
			} catch (Exception $e) {
				if (!empty($this->request->data['Search'])) {
					unset($this->request->data['Search']['page']);
					unset($this->request->data['Search']['sort']);
					unset($this->request->data['Search']['direction']);
				}
				if (isset($this->passedArgs)) {
					unset($this->passedArgs);
				}
				return $this->redirect(array('action' => 'index'));
			}
		}

		if (empty($courseExemptions)) {
			$this->Flash->info('There is no course exemptions requests that need your approval for now.');
		}

		$this->set('courseExemptions', $courseExemptions);
		$this->set(compact('limit', $limit)); */

	}

	function index()
	{
		if ((($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) && $this->Session->read('Auth.User')['is_admin']) || $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR/*  || $this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT */) {
			return $this->redirect(array('action' => 'list_approved'));
		}

		return $this->redirect('/');
	}

	function view($id = null)
	{
		if (!$id) {
			$this->Flash->error(__('Invalid course exemption'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->set('courseExemption', $this->CourseExemption->read(null, $id));
	}

	function add()
	{
		if (!empty($this->request->data)) {
			//check duplicate entry
			$duplicated = $this->CourseExemption->find('count', array('conditions' => $this->request->data['CourseExemption']));

			if ($duplicated == 0) {
				$this->CourseExemption->create();
				$this->request->data['CourseExemption']['request_date'] = date('Y-m-d');

				if ($this->CourseExemption->saveAll($this->request->data, array('validate' => 'first'))) {
					$this->Flash->success('The course exemption has been saved');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error('The course exemption could not be saved. Please, try again.');
				}
			} else {
				$this->Flash->warning('The course exemption could not be saved. You have already requested course exemptions for the selected courses.');
				$this->redirect(array('action' => 'index'));
			}
		}

		$current_academic_year = $this->AcademicYear->current_academicyear();

		$student_section_exam_status = $this->CourseExemption->Student->get_student_section($this->student_id, $current_academic_year);

		$courses = $this->CourseExemption->Course->find('list', array(
			'conditions' => array(
				'Course.curriculum_id' => $student_section_exam_status['StudentBasicInfo']['curriculum_id']
			),
			'fields' => array('id', 'course_code_title')
		));

		$previous_exemption_accepted = $this->CourseExemption->find('all', array(
			'conditions' => array(
				'CourseExemption.student_id' => $student_section_exam_status['StudentBasicInfo']['id'], 
				'CourseExemption.department_accept_reject' => 1,
				'CourseExemption.registrar_confirm_deny' => 1,
				'CourseExemption.department_approve_by is not null'
			)
		));

		//$students = $this->CourseExemption->Student->find('list');
		$this->set(compact('courses', 'previous_exemption_accepted', 'student_section_exam_status'));
	}

	function edit($id = null)
	{
		$this->CourseExemption->id = $id;

		if (!$this->CourseExemption->exists()) {
			$this->Flash->error(__('Invalid course exemption'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data)) {
			if ($this->CourseExemption->save($this->request->data)) {
				$this->Flash->success(__('The course exemption has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The course exemption could not be saved. Please, try again.'));
			}
		}

		if (empty($this->request->data)) {
			$this->request->data = $this->CourseExemption->read(null, $id);
		}

		//debug($this->request->data);
		$courses = array();
		$students = array();

		if (isset($this->request->data['Student']['id']) && !empty($this->request->data['Student']['id'])) {
			$students = $this->CourseExemption->Student->find('list', array('conditions' => array('Student.id' => $this->request->data['Student']['id']), 'fields' => array('Student.id', 'Student.full_name_studentnumber')));

			if (isset($this->request->data['Course']['id']) && !empty($this->request->data['Course']['id'])) {
				if (isset($this->request->data['Student']['curriculum_id']) && !empty($this->request->data['Student']['curriculum_id']) && !empty($this->request->data['Course']['curriculum_id'])) {
					$courses = $this->CourseExemption->Course->find('list', array(
						'conditions' => array(
							'OR' => array(
								'Course.curriculum_id' => array($this->request->data['Student']['curriculum_id'], $this->request->data['Course']['curriculum_id']),
								'Course.id' => $this->request->data['Course']['id'],
							)
						),
						'fields' => array('Course.id', 'Course.course_code_title')
					));
				} else if (!empty($this->request->data['Course']['curriculum_id'])) {
					$courses = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.curriculum_id' => $this->request->data['Course']['curriculum_id']), 'fields' => array('Course.id', 'Course.course_code_title')));
				} else {
					$courses = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.id' => $this->request->data['Course']['id']), 'fields' => array('Course.id', 'Course.course_code_title')));
				}
			}

		}

		$this->set(compact('courses', 'students'));
	}

	function delete($id = null)
	{
		if (!$id) {
			$this->Flash->error(__('Invalid id for course exemption'));
			return $this->redirect(array('action' => 'index'));
		}

		// dont allow deletion if the students request is accepted or reject by department
		$is_deletion_allowed = $this->CourseExemption->find('count', array(
			'conditions' => array(
				'CourseExemption.id' => $id, 
				"OR" => array(
					'CourseExemption.department_approve_by is null',
					'CourseExemption.department_approve_by' => array('')
				),
				'CourseExemption.student_id' => $this->student_id
			)
		));

		if ($is_deletion_allowed > 0) {
			if ($this->CourseExemption->delete($id)) {
				$this->Flash->success( __('Course exemption request is cancelled.'));
			} else {
				$this->Flash->error(__('Course exemption could not be cancelled. Please try again.'));
			}
		} else {
			$this->Flash->error(__('Course exemption could not be cancelled. You request has been approved/rejected by your department.'));
		}

		return $this->redirect(array('action' => 'index'));
	}
	
	function approve_request($id = null)
	{

		if (!empty($this->request->data)) {

			$department_ids = array();

			if (!empty($this->department_ids)) {
				$department_ids = $this->department_ids;
			} elseif (!empty($this->department_id)) {
				$department_ids = $this->department_id;
			}

			$elgibile_to_approve = $this->CourseExemption->Student->find('count', array(
				'conditions' => array(
					'Student.department_id' => $department_ids,
					'Student.id' => $this->request->data['CourseExemption']['student_id']
				)
			));

			if ($elgibile_to_approve > 0) {

				if ($this->role_id == ROLE_DEPARTMENT) {
					$this->request->data['CourseExemption']['department_approve_by'] = $this->Auth->user('full_name');
				} else if ($this->role_id == ROLE_REGISTRAR) {
					$this->request->data['CourseExemption']['registrar_approve_by'] = $this->Auth->user('full_name');
				}

				if ($this->CourseExemption->save($this->request->data)) {
					
					$this->Flash->success(__('The course exemption request has been saved'));
					//registrar

					if ($this->role_id == ROLE_REGISTRAR) {
						$count = $this->CourseExemption->find('count', array(
							'conditions' => array(
								'Student.department_id' => $department_ids,
								'CourseExemption.department_approve_by is not null', 
								"OR" => array(
									'CourseExemption.registrar_approve_by is null', 
									'CourseExemption.registrar_approve_by' => array('')
								)
							)
						));
					} else {
						$count = $this->CourseExemption->find('count', array(
							'conditions' => array(
								'Student.department_id' => $department_ids,
								"OR" => array(
									'CourseExemption.department_approve_by is null', 
									'CourseExemption.department_approve_by' => array('')
								)
							)
						));
					}

					if ($count == 0) {
						$this->redirect(array('action' => 'list_approved'));
					} else {
						$this->redirect(array('action' => 'index'));
					}
				} else {
					$this->Flash->error(__('The course exemption request could not be saved. Please, try again.'));
					$this->request->data = $this->CourseExemption->read(null, $id);
				}
			} else {
				$this->Flash->error(__('You are not elgible to approve the exemption request.'));
			}
		}

		if (empty($this->request->data)) {
			$this->request->data = $this->CourseExemption->read(null, $id);
		}

		$current_academic_year = $this->AcademicYear->current_academicyear();

		$student_section_exam_status = $this->CourseExemption->Student->get_student_section($this->request->data['CourseExemption']['student_id'], $current_academic_year);

		$courseForSubstitueds = $this->CourseExemption->Course->find('list', array(
			'conditions' => array(
				'Course.curriculum_id' => $student_section_exam_status['StudentBasicInfo']['curriculum_id']
			),
			'fields' => array('id', 'course_title')
		));

		$previous_exemption_accepted = $this->CourseExemption->find('all', array(
			'conditions' => array(
				'CourseExemption.student_id' => $this->request->data['CourseExemption']['student_id'], 
				'CourseExemption.department_accept_reject' => 1,
				'CourseExemption.registrar_confirm_deny' => 1,
				'CourseExemption.department_approve_by is not null'
			))
		);

		$courses = $this->CourseExemption->Course->find('list', array('fields' => array('id', 'course_title')));

		$this->set(compact(
			'students',
			'courses',
			'student_section_exam_status',
			'previous_exemption_accepted'
		));
	}

	function list_approved()
	{

		$limit = 100;
		$name = '';
		$default_department_id =  '';
		$default_college_id =  '';
		$selected_academic_year = '';
		$page = 1;
		$direction = 'desc';
		$sort = 'CourseExemption.request_date';

		$years = 1;
		$currYear = date('Y');
		$allowed_academic_years[$currYear] = $currYear;
		$default_ac_year = $this->AcademicYear->current_academicyear();
		
		
		if (is_numeric(ACY_BACK_FOR_ALL) && ACY_BACK_FOR_ALL) {
			$years = ACY_BACK_FOR_ALL;
			$allowed_academic_years_range = $this->AcademicYear->academicYearInArray(((explode('/', $default_ac_year)[0]) - ACY_BACK_FOR_ALL), (explode('/', $default_ac_year)[0]));
			foreach ($allowed_academic_years_range as $key => $yearvalue) {
				$yrexp = explode('/', $yearvalue)[0];
				if (!empty($yrexp)) {
					$allowed_academic_years[$yrexp] = $yrexp;
				}
			}
		}

		//debug($allowed_academic_years);
		// Create the interval string dynamically
		$intervalString = 'P' . $years . 'Y';

		// Use the interval string in DateInterval
		$interval = new DateInterval($intervalString);
		$currentDateTime = new DateTime();

		// Subtract the interval from the current date
		$currentDateTime->sub($interval);
		//debug("Date and Time $years Years Ago: " . $currentDateTime->format('Y-m-d H:i:s'));

		$date_back_to_check = $currentDateTime->format('Y-m-d');

		//debug($date_back_to_check);
		
		$options = array();
		
		if (!empty($this->passedArgs)) {

			//debug($this->passedArgs);

			if (!empty($this->passedArgs['Search.limit'])) {
				$limit = $this->request->data['Search']['limit'] = $this->passedArgs['Search.limit'];
			}

			if (!empty($this->passedArgs['Search.name'])) {
				$name = $this->request->data['Search']['name'] = str_replace('-', '/', trim($this->passedArgs['Search.name']));
			}

			if (!empty($this->passedArgs['Search.department_id'])) {
				$default_department_id = $this->request->data['Search']['department_id'] = $this->passedArgs['Search.department_id'];
			}

			if (isset($this->passedArgs['Search.college_id']) && !empty($this->passedArgs['Search.college_id'])) {
				$default_college_id = $this->request->data['Search']['college_id'] = $this->passedArgs['Search.college_id'];
			}

			if (!empty($this->passedArgs['Search.year_approved'])) {
				$selected_academic_year = $this->request->data['Search']['year_approved'] =  str_replace('-', '/', trim($this->passedArgs['Search.year_approved']));
			}

			if (!empty($this->passedArgs['Search.program_id'])) {
				$this->request->data['Search']['program_id'] = $this->passedArgs['Search.program_id'];
			}

			if (isset($this->passedArgs['Search.program_type_id'])) {
				$this->request->data['Search']['program_type_id'] = $this->passedArgs['Search.program_type_id'];
			}

			if (isset($this->passedArgs['Search.graduated'])) {
				$this->request->data['Search']['graduated'] = $this->passedArgs['Search.graduated'];
			}

			if (isset($this->passedArgs['Search.status']) && !empty($this->passedArgs['Search.status'])) {
				$this->request->data['Search']['status'] = $this->passedArgs['Search.status'];
			}

			if (isset($this->passedArgs['page'])) {
				$page = $this->request->data['Search']['page'] = $this->passedArgs['page'];
			}

			if (isset($this->passedArgs['sort'])) {
				$sort = $this->request->data['Search']['sort'] = $this->passedArgs['sort'];
			}

			if (isset($this->passedArgs['direction'])) {
				$direction = $this->request->data['Search']['direction'] = $this->passedArgs['direction'];
			}

			//$this->__init_search();
			$this->__init_search_index();
			//$this->request->data['search'] = true;
		}

		if (isset($data) && !empty($data['Search'])) {
			$this->request->data['Search'] = $data['Search'];
			$this->__init_clear_session_filters();
			$this->__init_search_index();
		}

		if (isset($this->request->data['search'])) {
			unset($this->passedArgs);
			$this->__init_clear_session_filters();
			$this->__init_search_index();
		}

		//debug($date_back_to_check);
		
		if (!empty($this->request->data)) {
			//debug($this->request->data);

			if (!empty($selected_academic_year) || isset($this->request->data['Search']['year_approved']) && !empty($this->request->data['Search']['year_approved'])) {
				$yearCurr = (!empty($selected_academic_year) ? $selected_academic_year : $this->request->data['Search']['year_approved']);
				$dateString = $yearCurr . '-01-01';
				/* $januaryFirst = new DateTime($dateString);
				debug($januaryFirst->format('Y-m-d'));
				$date_back_to_check = $januaryFirst->format('Y-m-d'); */
				$options['conditions'][] = array('YEAR(CourseExemption.request_date)' => $yearCurr);
			} else {
				debug($date_back_to_check);
				$options['conditions'][] = array('CourseExemption.request_date > ' => $date_back_to_check);
			}

			if (!empty($page) && !isset($this->request->data['search'])) {
				$this->request->data['Search']['page'] = $page;
			}

			if (!isset($this->request->data['Search']['status'])) {
				$this->request->data['Search']['status'] = 'accepted';
			}

			if (!isset($this->request->data['Search']['graduated'])) {
				$this->request->data['Search']['graduated'] = 2;
			}
			
			if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				
				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_id, 'Department.active' => 1))); 
				$options['conditions'][] = array('Student.department_id' => $this->department_id);
				$default_department_id = $this->request->data['Search']['department_id'] = $this->department_id;

				if ($this->request->data['Search']['status'] == 'notprocessed') {
					$options['conditions'][] = array('CourseExemption.department_accept_reject is null');
				} else if ($this->request->data['Search']['status'] == 'accepted') {
					$options['conditions'][] = array(
						'OR' => array(
							'CourseExemption.department_accept_reject' => 1,
							'CourseExemption.registrar_confirm_deny' => 1
						)
					);
				} else if ($this->request->data['Search']['status'] == 'rejected') {
					$options['conditions'][] = array(
						'OR' => array(
							'CourseExemption.department_accept_reject' => 0,
							'CourseExemption.registrar_confirm_deny' => 0
						),
					);
				}

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {

				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1)));
				$default_college_id = $this->request->data['Search']['department_id'] = $this->college_id;

				if (!empty($this->request->data['Search']['department_id'])) {
					$options['conditions'][] = array('Student.department_id' => $this->request->data['Search']['department_id']);
				} else {
					$options['conditions'][] = array('Student.college_id' => $this->college_id);
				}

				if ($this->request->data['Search']['status'] == 'notprocessed') {
					$options['conditions'][] = array('CourseExemption.department_accept_reject is null');
				} else if ($this->request->data['Search']['status'] == 'accepted') {
					$options['conditions'][] = array(
						'OR' => array(
							'CourseExemption.department_accept_reject' => 1,
							'CourseExemption.registrar_confirm_deny' => 1
						)
					);
				} else if ($this->request->data['Search']['status'] == 'rejected') {
					$options['conditions'][] = array(
						'OR' => array(
							'CourseExemption.department_accept_reject' => 0,
							'CourseExemption.registrar_confirm_deny' => 0
						),
					);
				}

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {

				if (!empty($this->department_ids)) {
					$colleges = array();
					//$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
					$departments = $this->CourseExemption->Student->Department->allDepartmentsByCollege2(0, $this->department_ids, array(), 1);

					if (!empty($this->request->data['Search']['department_id'])) {
						$options['conditions'][] = array('Student.department_id' => $this->request->data['Search']['department_id']);
					} else {
						$options['conditions'][] = array('Student.department_id' => $this->department_ids);
					}
				} else if (!empty($this->college_ids)) {
					
					$departments = array();
					$colleges =  $this->CourseExemption->Student->College->find('list', array('conditions' => array('College.id' => $this->college_ids, 'College.active' => 1)));
					
					if (!empty($this->request->data['Search']['college_id'])) {
						$options['conditions'][] = array('Student.college_id' => $this->request->data['Search']['college_id'], 'Student.department_id IS NULL');
					} else {
						$options['conditions'][] = array('Student.college_id' => $this->college_ids, 'Student.department_id IS NULL');
					}
				}

				if ($this->request->data['Search']['status'] == 'notprocessed') {
					$options['conditions'][] = array(
						'CourseExemption.department_accept_reject' => 1,
						'CourseExemption.registrar_confirm_deny is null'
					);
				} else if ($this->request->data['Search']['status'] == 'accepted') {
					$options['conditions'][] = array(
						'CourseExemption.department_accept_reject' => 1,
						'CourseExemption.registrar_confirm_deny' => 1
					);
				} else if ($this->request->data['Search']['status'] == 'rejected') {
					$options['conditions'][] = array(
						'CourseExemption.department_accept_reject' => 1, 
						'CourseExemption.registrar_confirm_deny' => 0
					);
				}

			} else  if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
				
				if (isset($this->passedArgs)) {
					unset($this->passedArgs);
				}
				if (isset($this->request->data)) {
					unset($this->request->data);
				}
				return $this->redirect(array('action' => 'list_approved'));
			} else {

				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
				$colleges =  $this->CourseExemption->Student->College->find('list', array('conditions' => array('College.id' => $this->college_ids, 'College.active' => 1)));

				if (!empty($this->request->data['Search']['department_id'])) {
					$options['conditions'][] = array('Student.department_id' => $this->request->data['Search']['department_id']);
				} else if (empty($this->request->data['Search']['department_id']) && !empty($this->request->data['Search']['college_id'])) {
					$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['Search']['college_id'], 'Department.active' => 1)));
					$options['conditions'][] = array(
						'OR' => array(
							'Student.college_id' => $this->request->data['Search']['college_id'],
							'Student.department_id' => array_keys($departments)
						)
					);
				} else {
					$options['conditions'][] = array(
						'OR' => array(
							'Student.college_id' => array_keys($colleges),
							'Student.department_id' => array_keys($departments)
						)
					);
				}

				if ($this->request->data['Search']['status'] == 'notprocessed') {
					$options['conditions'][] = array('CourseExemption.department_accept_reject is null');
				} else if ($this->request->data['Search']['status'] == 'accepted') {
					$options['conditions'][] = array(
						'OR' => array(
							'CourseExemption.department_accept_reject' => 1,
							'CourseExemption.registrar_confirm_deny' => 1
						)
					);
				} else if ($this->request->data['Search']['status'] == 'rejected') {
					$options['conditions'][] = array(
						'OR' => array(
							'CourseExemption.department_accept_reject' => 0,
							'CourseExemption.registrar_confirm_deny' => 0
						),
					);
				}
			}

			if (!empty($this->request->data['Search']['program_id'])) {
				$options['conditions'][] = array('Student.program_id' => $this->request->data['Search']['program_id']);
			} else if (empty($this->request->data['Search']['program_id']) && $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
				$options['conditions'][] = array('Student.program_id' => $this->program_ids);
			}

			if (!empty($this->request->data['Search']['program_type_id'])) {
				$options['conditions'][] = array('Student.program_type_id' => $this->request->data['Search']['program_type_id']);
			} else if (empty($this->request->data['Search']['program_type_id']) && $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
				$options['conditions'][] = array('Student.program_type_id' => $this->program_type_ids);
			}

			if (isset($this->request->data['Search']['college_id']) && !empty($this->request->data['Search']['college_id']) && $this->Session->read('Auth.User')['role_id'] != ROLE_REGISTRAR ) {
				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->request->data['Search']['college_id'], 'Department.active' => 1)));
			}

			if ($this->request->data['Search']['graduated'] == 0) {
				$options['conditions'][] = array('Student.graduated = 0');
			} else if ($this->request->data['Search']['graduated'] == 1) {
				$options['conditions'][] = array('Student.graduated = 1');
			}

			if (isset($name) && !empty($name)) {
				//unset($options['conditions']);
				$options['conditions'][] = array(
					'OR' => array(
						'Student.first_name LIKE ' => '%' . $name . '%',
						'Student.middle_name LIKE ' =>  '%' . $name . '%',
						'Student.last_name LIKE ' =>  '%' . $name . '%',
						'Student.studentnumber LIKE ' =>  '%' . $name . '%',
					)
				);
			}

		} else {

			if ($this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE) {
				
				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id, 'Department.active' => 1)));
				
				$options['conditions'][] = array(
					'CourseExemption.request_date > ' => $date_back_to_check,
					//'CourseExemption.department_accept_reject is null',
					'OR' => array(
						'Student.college_id' => $this->college_id,
						'Student.department_id' => array_keys($departments)
					)
				);

				$default_college_id = $this->college_id;

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
				
				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_id)));
				
				$options['conditions'][] = array(
					'CourseExemption.request_date > ' => $date_back_to_check,
					//'CourseExemption.department_accept_reject is null',
					'Student.department_id' => $this->department_id
				);

				$default_department_id = $this->department_id;

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) {
				if (!empty($this->department_ids)) {
					
					$colleges = array();
					//$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
					$departments = $this->CourseExemption->Student->Department->allDepartmentsByCollege2(0, $this->department_ids, array(), 1);
					
					$options['conditions'][] = array(
						'Student.department_id' => $this->department_ids, 
						'Student.program_id' => $this->program_ids, 
						'Student.program_type_id' => $this->program_type_ids
					);

				} else if (!empty($this->college_ids)) {
					
					$departments = array();
					$colleges =  $this->CourseExemption->Student->College->find('list', array('conditions' => array('College.id' => $this->college_ids, 'College.active' => 1)));
					
					$options['conditions'][] = array(
						'Student.college_id' => $this->college_ids, 
						'Student.department_id IS NULL', 
						'Student.program_id' => $this->program_ids, 
						'Student.program_type_id' => $this->program_type_ids
					);
				}

				$options['conditions'][] = array(
					'CourseExemption.request_date > ' => $date_back_to_check,
					//'CourseExemption.department_accept_reject' => 1,
					//'CourseExemption.registrar_confirm_deny is null'
				);

			} else if ($this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
				$options['conditions'][] = array('Student.id' => $this->student_id);
			} else {

				$departments =  $this->CourseExemption->Student->Department->find('list', array('conditions' => array('Department.id' => $this->department_ids, 'Department.active' => 1)));
				$colleges =  $this->CourseExemption->Student->College->find('list', array('conditions' => array('College.id' => $this->college_ids, 'College.active' => 1)));

				if (!empty($departments) && !empty($colleges)) {
					$options['conditions'][] = array(
						'CourseExemption.request_date > ' => $date_back_to_check,
						//'CourseExemption.department_accept_reject is null',
						'OR' => array(
							'Student.department_id' => $this->department_ids,
							'Student.college_id' => $this->college_ids
						)
					);
				} else if (!empty($departments)) {
					$options['conditions'][] = array(
						'CourseExemption.request_date > ' => $date_back_to_check,
						//'CourseExemption.department_accept_reject is null',
						'Student.department_id' => $this->department_ids
					);
				} else if (!empty($colleges)) {
					$options['conditions'][] = array(
						'CourseExemption.request_date > ' => $date_back_to_check,
						//'CourseExemption.department_accept_reject is null',
						'Student.college_id' => $this->college_ids
					);
				}
			}

			if (!empty($options['conditions'])) {
				$options['conditions'][] = array('Student.graduated = 0');
			}

		}

		debug($options['conditions']);

		$courseExemptions = array();

		if (!empty($options['conditions'])) {
			$this->Paginator->settings = array(
				'conditions' => $options['conditions'],
				'contain' => array(
					'Course' => array('id', 'course_code_title', 'credit'),
					'Student' => array(
						'fields' => array('id', 'full_name', 'program_id', 'program_type_id', 'graduated', 'gender', 'studentnumber'), 
						'Program' => array('id', 'name'), 
						'ProgramType' => array('id', 'name'), 
						'Department' => array('id', 'name')
					)
				),
				'order' => array($sort => $direction),
				'limit' => (!empty($limit) ? $limit : 100),
				'maxLimit' => (!empty($limit) ? $limit : 100),
				'page' => $page,
				'recursive' => -1
			);


			try {
				$courseExemptions = $this->Paginator->paginate($this->modelClass);
				$this->set(compact('courseExemptions'));
			} catch (NotFoundException $e) {
				if (!empty($this->request->data['Search'])) {
					unset($this->request->data['Search']['page']);
					unset($this->request->data['Search']['sort']);
					unset($this->request->data['Search']['direction']);
				}
				if (isset($this->passedArgs)) {
					unset($this->passedArgs);
				}
				return $this->redirect(array('action' => 'list_approved'));
			} catch (Exception $e) {
				if (!empty($this->request->data['Search'])) {
					unset($this->request->data['Search']['page']);
					unset($this->request->data['Search']['sort']);
					unset($this->request->data['Search']['direction']);
				}
				if (isset($this->passedArgs)) {
					unset($this->passedArgs);
				}
				return $this->redirect(array('action' => 'list_approved'));
			}
		} else {
			$this->set(compact('courseExemptions'));
		}

		if (empty($courseExemptions) && !empty($option)) {
			$this->Flash->info('No Course Exemption is found with the given search criteria.');
			$turn_off_search = false;
		} else {
			//debug($courseExemptions[0]);
			//debug($courseExemptions);
			if (empty($courseExemptions)) {
				$turn_off_search = false;
			} else {
				$turn_off_search = true;
			}
		}

		$this->set(compact('programs', 'programTypes', 'departments', 'colleges', 'limit', 'name', 'turn_off_search', 'default_department_id', 'default_college_id', 'allowed_academic_years'));

	}
	
	function invalid()
	{
		//$this->cakeError('youSuck');
	}

	public function add_student_exempted_course($student_id)
	{
		$this->layout = 'ajax';

		$student_detail = $this->CourseExemption->Student->find('first', array(
			'conditions' => array('Student.id' => $student_id),
			'contain' => array(
				'AcceptedStudent',
				'Curriculum' => array('id', 'name', 'type_credit', 'year_introduced'),
				'CurriculumAttachment'
			)
		));

		debug($student_detail);

		$student_attached_curriculums_count = count($student_detail['CurriculumAttachment']);

		debug($student_attached_curriculums_count);

		$student_attached_curriculum_ids = array();

		if ($student_attached_curriculums_count > 1) {

			foreach ($student_detail['CurriculumAttachment'] as $key => $cattachments) {
				$student_attached_curriculum_ids[$cattachments['curriculum_id']] = $cattachments['curriculum_id'];
			}

			$student_attached_curriculum_ids = array_unique($student_attached_curriculum_ids);

			$student_attached_curriculums_count = count($student_attached_curriculum_ids);

		} else {
			$student_attached_curriculum_ids[$student_detail['Student']['curriculum_id']] = $student_detail['Student']['curriculum_id'];
		}

		debug($student_attached_curriculums_count);
		debug($student_attached_curriculum_ids);

		//TO DO: Exclude Registered Added Courses, Neway
		$student_section_exam_status = ClassRegistry::init('Student')->get_student_section($student_id, null, null);
		//debug($student_section_exam_status);

		$takenCourses = $this->CourseExemption->Student->getStudentRegisteredAddDropCurriculumResult($student_id,null, /* $for_document =  */1, /* $includeBasicProfile = */ 0, /* $includeResult = */ 0, /* $includeExemption = */ 1);

		//debug($takenCourses);
		
		$excludeCoursesList = array();
		
		if (!empty($takenCourses)) {
			foreach ($takenCourses as $key => $courseRegAddExempt) {
				foreach ($courseRegAddExempt as $key => $course) {
					if (isset($course['course_id']) && !empty($course['course_id'])) {
						$excludeCoursesList[] = $course['course_id'];
						$equivalentCourses = ClassRegistry::init('EquivalentCourse')->find('list', array('conditions' => array('EquivalentCourse.course_be_substitued_id' => $course['course_id']), 'fields' => array('EquivalentCourse.course_for_substitued_id', 'EquivalentCourse.course_for_substitued_id')));
						if (!empty($equivalentCourses)) {
							//debug($equivalentCourses);
							foreach ($equivalentCourses as $ec_key => $ec_value) {
								$excludeCoursesList[] = $ec_value;
							}
						}
					}
				}
			}
		}

		/* $alreadyExemptedCourses = $this->CourseExemption->find('list', array('conditions' => array('CourseExemption.registrar_confirm_deny' => 1, 'CourseExemption.student_id' => $student_id), 'fields' => array('CourseExemption.course_id', 'CourseExemption.course_id')));
		debug($alreadyExemptedCourses);
		
		if (!empty($alreadyExemptedCourses)) {
			foreach ($alreadyExemptedCourses as $key => $ex_value) {
				$excludeCoursesList[] = $ex_value;
			}
		} */
		// check and remove already exempted courses while updating existing Exemptions exemptions, Neway

		//debug($excludeCoursesList);
		$studentHaveSection = 0;
		$takenCoursesCount = 0;

		if (isset($student_section_exam_status['Section']['id']) && isset($student_section_exam_status['Section']['YearLevel']['id']) /* && !$student_section_exam_status['Section']['archive'] */) {
			$studentHaveSection = 1;

			// check and remove section published courses from the list of courses to exempt,
			// can create problems if the student is transfered in second semester and added to a section that have first semester courses publication
			/* if (!empty($student_section_exam_status['Section']['id']) && $student_section_exam_status['Section']['id'] > 0) {
				$get_published_courses_for_the_section = ClassRegistry::init('PublishedCourse')->find('list', array('conditions' => array('PublishedCourse.section_id' => $student_section_exam_status['Section']['id']), 'fields' => array('PublishedCourse.course_id', 'PublishedCourse.course_id')));
				if (!empty($get_published_courses_for_the_section)) {
					//debug($get_published_courses_for_the_section);
					$get_published_courses_for_the_section = array_values($get_published_courses_for_the_section);
					$excludeCoursesList = $excludeCoursesList + $get_published_courses_for_the_section;
				}
			} */
		}

		//debug(count($takenCourses['Course Registered']));
		//debug(count($takenCourses['Course Added']));

		if (!empty($takenCourses['Course Registered'])) {
			$takenCoursesCount = count($takenCourses['Course Registered']);
		}

		if (!empty($takenCourses['Course Added'])) {
			$takenCoursesCount += count($takenCourses['Course Added']);
		}

		//debug($takenCourses);

		if (!empty($excludeCoursesList)) {

			$yearLevel = 0;

			if (isset($student_section_exam_status['Section']['id']) && isset($student_section_exam_status['Section']['YearLevel']['id'])) {
				$yearLevel = $student_section_exam_status['Section']['YearLevel']['id'];
				//$studentHaveSection = 1;
			}

			if ($yearLevel) {
				$courses = $this->CourseExemption->Course->find('list', array(
					'conditions' => array(
						'NOT' => array(
							'Course.id' => $excludeCoursesList,
						),
						'Course.curriculum_id' => $student_detail['Student']['curriculum_id'],
						'Course.year_level_id <=' => $yearLevel,
						'Course.active' => 1,
					), 
					'fields' => array('id', 'course_title'),
				));
			} else {
				$courses = $this->CourseExemption->Course->find('list', array(
					'conditions' => array(
						'NOT' => array(
							'Course.id' => $excludeCoursesList,
						),
						'Course.curriculum_id' => $student_detail['Student']['curriculum_id'],
						'Course.active' => 1,
					), 
					'fields' => array('id', 'course_title'),
				));
			}
		} else {
			$courses = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.curriculum_id' => $student_detail['Student']['curriculum_id']), 'fields' => array('id', 'course_title')));
		}


		$exemptedCourseLists = $this->CourseExemption->find('all', array(
			'conditions' => array(
				'CourseExemption.student_id' => $student_id,
				'CourseExemption.department_accept_reject' => 1,
				'CourseExemption.registrar_confirm_deny' => 1,
			), 
			'recursive' => -1
		));

		// uncomment this if it is required to show all curricullum courses for already exempted courses for drop down menu and comnment the following if else block 
		//$coursesForList = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.curriculum_id' => $student_attached_curriculum_ids), 'fields' => array('id', 'course_title')));
		
		if (!empty($exemptedCourseLists)) {
			$already_exempted_course_ids = $this->CourseExemption->find('list', array(
				'conditions' => array(
					'CourseExemption.student_id' => $student_id,
					'CourseExemption.department_accept_reject' => 1,
					'CourseExemption.registrar_confirm_deny' => 1,
				), 
				'fields' => array('CourseExemption.course_id','CourseExemption.course_id')
			));
			$coursesForList = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.curriculum_id' => $student_attached_curriculum_ids, 'Course.id' => $already_exempted_course_ids), 'fields' => array('id', 'course_title'))); 
		} else {
			$coursesForList = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.curriculum_id' => $student_attached_curriculum_ids), 'fields' => array('id', 'course_title')));
		}

		//uncommet up to this line if you comment the above to show only exempted courses in the drop down


		// Keep this for students that are attached to more than one curriculum DONT COMMENT THIS to list all courses from all curriculum attached plus with out excluding already exempted courses.
		if ($student_attached_curriculums_count > 1) {
			$coursesForList = $this->CourseExemption->Course->find('list', array('conditions' => array('Course.curriculum_id' => $student_attached_curriculum_ids), 'fields' => array('id', 'course_title')));
		}

		$this->set(compact(
			'sectionOrganized',
			'student_detail',
			'courses',
			'coursesForList',
			'exemptedCourseLists',
			'studentHaveSection',
			'takenCoursesCount',
			'student_section_exam_status',
			'student_attached_curriculums_count'
		));
	}

	public function add_student_exemption()
	{

		if (isset($this->request->data) && !empty($this->request->data)) {
			if (!empty($this->request->data['CourseExemption'])) {
				$formattedCourseExemption = array();
				$count = 0;
				reset($this->request->data['CourseExemption']);

				$student_id = $this->request->data['CourseExemption'][0]['student_id'];
				$transfer_from = $this->request->data['CourseExemption'][0]['transfer_from'];
				
				$allExemptedIds = $this->CourseExemption->find('list', array(
					'conditions' => array(
						'CourseExemption.student_id' => $student_id,
						//'CourseExemption.department_accept_reject' => 1,
						//'CourseExemption.registrar_confirm_deny' => 1,
					),
					'fields' => array('CourseExemption.id', 'CourseExemption.id'),
					'recursive' => -1, 
				));

				debug($this->request->data);


				foreach ($this->request->data['CourseExemption'] as $k => $v) {
					if (isset($student_id) && isset($v['course_id'])) {

						if (!empty($formattedCourseExemption['CourseExemption'][$count]['id'])) {
							$formattedCourseExemption['CourseExemption'][$count]['id'] = $v['id'];
							unset($allExemptedIds[$v['id']]);
						}

						$formattedCourseExemption['CourseExemption'][$count]['request_date'] = date('Y-m-d h:i:s');
						$formattedCourseExemption['CourseExemption'][$count]['reason'] = 'data entry via registrar';
						$formattedCourseExemption['CourseExemption'][$count]['taken_course_title'] = $v['taken_course_title'];
						$formattedCourseExemption['CourseExemption'][$count]['taken_course_code'] = $v['taken_course_code'];
						$formattedCourseExemption['CourseExemption'][$count]['course_taken_credit'] = $v['course_taken_credit'];

						$formattedCourseExemption['CourseExemption'][$count]['department_accept_reject'] = 1;


						$formattedCourseExemption['CourseExemption'][$count]['department_reason'] = 'data entry via registrar';
						$formattedCourseExemption['CourseExemption'][$count]['registrar_confirm_deny'] = 1;
						$formattedCourseExemption['CourseExemption'][$count]['registrar_reason'] = 'data entry via registrar';

						$formattedCourseExemption['CourseExemption'][$count]['department_approve_by'] = $this->Auth->user('full_name');
						$formattedCourseExemption['CourseExemption'][$count]['registrar_approve_by'] = $this->Auth->user('full_name');

						$formattedCourseExemption['CourseExemption'][$count]['course_id'] = $v['course_id'];
						$formattedCourseExemption['CourseExemption'][$count]['student_id'] = $student_id;
						$formattedCourseExemption['CourseExemption'][$count]['transfer_from'] = $transfer_from;
						$formattedCourseExemption['CourseExemption'][$count]['grade'] = $v['grade'];


						$count++;
					}
				}
				

				if (!empty($allExemptedIds)) {
					if ($this->CourseExemption->deleteAll(array('CourseExemption.id' => $allExemptedIds), false)) {
					}
				}

				debug($formattedCourseExemption);

				if (!empty($formattedCourseExemption)) {
					if ($this->CourseExemption->saveAll($formattedCourseExemption['CourseExemption'], array('validate' => 'first'))) {
						$this->Flash->success('The course exemption has been saved');
					} else {
						$this->Flash->error('The exempted courses lists coudnt be saved. Please, try again.');
					}
				}
			} else {
				$this->Flash->error('The exempted courses lists coudnt be saved. Please, try again.');
			}
		}

		$this->redirect(array('controller' => 'students', 'action' => 'student_academic_profile', $this->request->data['CourseExemption'][0]['student_id']));
	}
}
