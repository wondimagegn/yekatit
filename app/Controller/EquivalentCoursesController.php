<?php
class EquivalentCoursesController extends AppController
{

	public $name = 'EquivalentCourses';

	public $menuOptions = array(
		'parent' => 'curriculums',
		'alias' => array(
			'add' => 'Map Equivalent Courses',
			'index' => 'View Mapped/Equivalent Courses'
		)
	);

	public $paginate = array();

	public function index()
	{
		$this->EquivalentCourse->recursive = 1;
		
		$this->paginate = array(
			'contain' => array(
				'CourseForSubstitued' => array(
					'Department' => array('id', 'name'), 
					'Curriculum' => array('id', 'name', 'year_introduced'), 
					'fields' => array('id', 'course_title', 'course_code', 'credit'), 
				),
				'CourseBeSubstitued'  => array(
					'Department' => array('id', 'name'), 
					'Curriculum' => array('id', 'name', 'year_introduced'), 
					'fields' => array('id', 'course_title', 'course_code', 'credit'), 
				),
			),
			'limit' => 100,
			'maxLimit' => 100
		);

		$this->__init_search_index();
		
		if ($this->Session->read('search_data_index')) {
			$this->request->data['viewCourseMap'] = true;
		}

		debug($this->request->data);

		$this->paginate['conditions'][] = array('CourseForSubstitued.department_id' => $this->department_id);
	
		if (isset($this->request->data['Search']['curriculum_id']) && !empty($this->request->data['Search']['curriculum_id'])) {
			$this->paginate['conditions'][] = array('CourseForSubstitued.curriculum_id' => $this->request->data['Search']['curriculum_id']);
			$isCurriculumApproved = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->field('registrar_approved', array('Curriculum.id' => $this->request->data['Search']['curriculum_id']));
		}

		if (isset($this->request->data['Search']['program_id']) && !empty($this->request->data['Search']['program_id'])) {
			$curriculums = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list', array(
				'conditions' => array(
					'Curriculum.department_id' => $this->department_id,
					'Curriculum.program_id' => $this->request->data['Search']['program_id']
				), 
				'fields' => array('id')
			));

			$this->paginate['conditions'][] = array('CourseForSubstitued.curriculum_id' => $curriculums);
		}

		if (isset($this->request->data['Search']['title']) && !empty($this->request->data['Search']['title'])) {
			$this->paginate['conditions'][] = array(
				'CourseForSubstitued.course_title like ' => '%' . trim($this->request->data['Search']['title']) . '%'
			);
		}

		if (!empty($this->request->data['Search'])){
			$this->Paginator->settings = $this->paginate;
		}

		if (isset($this->Paginator->settings['conditions'])) {
			$equivalentCourses = $this->Paginator->paginate('EquivalentCourse');
		} else {
			$equivalentCourses = array();
		}

		if (!empty($this->request->data['viewCourseMap'])) {
			$this->__init_search_index();
		}

		if (empty($equivalentCourses) && isset($this->request->data) && !empty($this->request->data['Search'])) {
			$this->Flash->info('There is no equivalent course mapping found in the given criteria.');
		}

		if (!empty($this->request->data['Search']['program_id'])) {
			$curriculums = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list', array(
				'conditions' => array(
					'Curriculum.department_id' => $this->department_id,
					'Curriculum.program_id' => $this->request->data['Search']['program_id']
				),
				'fields' => array('id', 'curriculum_detail')
			));
		} else {
			$curriculums = array();
		}

        debug($equivalentCourses);

		$programs = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->Program->find('list', array('conditions' => array('Program.id' => $this->program_ids, 'Program.active' => 1)));
		
		$this->set(compact('programs', 'curriculums', 'equivalentCourses', 'isCurriculumApproved'));
	}

	function view($id = null)
	{
		if (!$id) {
			$this->Flash->error('Invalid equivalent course id');
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('equivalentCourse', $this->EquivalentCourse->read(null, $id));
	}

	function add()
	{

		if ($this->Session->read('Auth.User')['role_id'] != ROLE_DEPARTMENT) {
			$this->Flash->warning( __('Your are not authorized to access the page you just selected!'));
			return $this->redirect('/');
		}

		// selected curriculum/department selected details
		$dept_id = $this->department_id;
		$coll_id = isset($this->college_id) && !is_array($this->college_id) && is_numeric($this->college_id) && $this->college_id ? $this->college_id : NULL;
		$program_id = isset($this->request->data['EquivalentCourse']['program_id']) && !empty($this->request->data['EquivalentCourse']['program_id']) ? $this->request->data['EquivalentCourse']['program_id'] : (!empty($this->program_ids) ? array_values($this->program_ids)[0] : 0);
		$curriculum_id = isset($this->request->data['EquivalentCourse']['curriculum_id']) && !empty($this->request->data['EquivalentCourse']['curriculum_id']) ? $this->request->data['EquivalentCourse']['curriculum_id'] : '';
		// selected curriculum course_id for substitution 
		$course_for_substitued_id = isset($this->request->data['EquivalentCourse']['course_for_substitued_id']) && !empty($this->request->data['EquivalentCourse']['course_for_substitued_id']) ? $this->request->data['EquivalentCourse']['course_for_substitued_id'] : '';

		$college_stream = NULL;
		$campus_id = NULL;

		if (!empty($coll_id) && $coll_id > 0) {
			$college_stream = $this->EquivalentCourse->CourseBeSubstitued->Department->College->field('College.stream', array('College.id' => $coll_id));
			$campus_id = $this->EquivalentCourse->CourseBeSubstitued->Department->College->field('College.campus_id', array('College.id' => $coll_id));
		} else {
			$coll_id = $this->EquivalentCourse->CourseBeSubstitued->Department->field('Department.college_id', array('Department.id' => $dept_id));
			$college_stream = $this->EquivalentCourse->CourseBeSubstitued->Department->College->field('College.stream', array('College.id' => $coll_id));
			$campus_id = $this->EquivalentCourse->CourseBeSubstitued->Department->College->field('College.campus_id', array('College.id' => $coll_id));
		}

		if (empty($college_stream)) {
			$college_stream = array(1, 2);
		}

		$freshman_curriculum_department_ids = array();

		if (!empty($this->program_ids) && in_array(PROGRAM_UNDEGRADUATE, $this->program_ids)) {
			$freshman_curriculum_department_ids = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list', array(
				'conditions' => array(
					'Curriculum.registrar_approved' => 1,
					'Curriculum.program_id' => PROGRAM_UNDEGRADUATE,
					'Curriculum.for_freshman' => 1,
					'Curriculum.stream' => $college_stream,
					'Curriculum.active' => 1
				),
				'fields' => array('Curriculum.department_id', 'Curriculum.department_id'),
			));
		}

		// other curriculum selected details
		$other_department_id = isset($this->request->data['EquivalentCourse']['department_id']) && !empty($this->request->data['EquivalentCourse']['department_id']) ? $this->request->data['EquivalentCourse']['department_id'] : '';
		$other_curriculum_id = isset($this->request->data['EquivalentCourse']['other_curriculum_id']) && !empty($this->request->data['EquivalentCourse']['other_curriculum_id']) ? $this->request->data['EquivalentCourse']['other_curriculum_id'] : '';
		// other curriculum course_id to be substituted
		$course_be_substitued_id = isset($this->request->data['EquivalentCourse']['course_be_substitued_id']) && !empty($this->request->data['EquivalentCourse']['course_be_substitued_id']) ? $this->request->data['EquivalentCourse']['course_be_substitued_id'] : '';


		// when mapEquivalentCourses is clicked 
		if (!empty($this->request->data) && isset($this->request->data['mapEquivalentCourses'])) {

			$this->EquivalentCourse->create();

			if (empty($this->request->data['EquivalentCourse']['course_for_substitued_id']) || empty($this->request->data['EquivalentCourse']['course_be_substitued_id'])) {
				$check_duplicate = 0;
			} else {
				$check_duplicate = $this->EquivalentCourse->find('count', array(
					'conditions' => array(
						'course_for_substitued_id' => $this->request->data['EquivalentCourse']['course_for_substitued_id'], 
						'course_be_substitued_id' => $this->request->data['EquivalentCourse']['course_be_substitued_id']
					)
				));
			}

			//TO Do: before saving, Check/detect cyclic course mappings that refer to each other, 
			// affects system data integrity for already graduated student documents( like student copy and others files for future, if prepared from the system and if there is no student copy attached to student folder at the time of graduation, Neway

			if ($check_duplicate == 0) {
				if ($this->EquivalentCourse->isSimilarCurriculum($this->request->data)) {
					if ($this->EquivalentCourse->save($this->request->data)) {
						$this->Flash->success('The equivalent course has been saved.');
						//$this->redirect(array('action' => 'index'));
					} else {
						$this->Flash->error('The equivalent course could not be saved. Please, try again.');
					}
				} else {
					$error = $this->EquivalentCourse->invalidFields();
					if (isset($error['error'])) {
						$this->Flash->error($error['error'][0]);
					}
				}
			} else {
				$this->Flash->warning('The selected courses are already mapped. You dont need to map it again.');
				//$this->redirect(array('action' => 'index'));
			}

			unset($this->request->data['mapEquivalentCourses']);
		}

		$return = array();
		$curriculums = array();
		$courseBeSubstitueds = array();
		$otherCurriculums = array();
		$courseForSubstitueds = array();

		// only load departments that are within the same stream and campus for the currently loggedin department
		$departments = $this->EquivalentCourse->CourseBeSubstitued->Department->find('all', array(
			'conditions' => array(
				'Department.active' => 1,
			),
			'contain' => array(
				'College' => array(
					'conditions' => array(
						'College.stream' => $college_stream,
						'College.campus_id' => $campus_id,
					),
					'fields' =>	array('id', 'name'),
				)
			),
			'fields' => array('id', 'name'),
			'order' => array('Department.college_id' => 'ASC', 'Department.name' => 'ASC', 'Department.created' => 'ASC')
		));

		if (!empty($departments)) {
			foreach ($departments as $dep_id => $dep_name) {
				$return[$dep_name['College']['name']][$dep_name['Department']['id']] = $dep_name['Department']['name'];
			}
		}

		// additionally include departments that have freshman curriculums but which are might not be found in the same campus
		if (!empty($freshman_curriculum_department_ids)) {

			$departments_with_freshman_curriculum = $this->EquivalentCourse->CourseBeSubstitued->Department->find('all', array(
				'conditions' => array(
					'Department.id' => $freshman_curriculum_department_ids,
					'Department.active' => 1,
				),
				'contain' => array(
					'College' => array(
						'conditions' => array(
							'College.stream' => $college_stream,
						),
						'fields' =>	array('id', 'name'),
					)
				),
				'fields' => array('id', 'name'),
				'order' => array('Department.college_id' => 'ASC', 'Department.name' => 'ASC', 'Department.created' => 'ASC')
			));

			if (!empty($departments_with_freshman_curriculum)) {
				foreach ($departments_with_freshman_curriculum as $dep_id => $dep_name) {
					$return[$dep_name['College']['name']][$dep_name['Department']['id']] = $dep_name['Department']['name'];
				}
			}
		}

		$departments = $return;
		
		$curriculums_with_graduated_students = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->Student->find('list', array(
			'conditions' => array(
				'Student.department_id' => $dept_id,
				'Student.program_id' => $program_id,
				'OR' => array(
					'Student.graduated' => 1,
					'Student.id in (select student_id from senate_lists)'
				)
			),
			'fields' => array('Student.curriculum_id', 'Student.curriculum_id')
		));

		if (!empty($this->request->data['EquivalentCourse']['program_id'])) {
			$curriculums = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list', array(
				'conditions' => array(
					'Curriculum.department_id' => $dept_id,
					'Curriculum.registrar_approved' => 1,
					'Curriculum.program_id' => $program_id,
					'Curriculum.active' => 1
					//"NOT" => array('Curriculum.id'  => $curriculums_with_graduated_students),
				),
				'fields' => array('Curriculum.id', 'Curriculum.curriculum_detail'),
				'order' => array('Curriculum.id' => 'DESC')
			));
		}

		if (!empty($this->request->data['EquivalentCourse']['other_curriculum_id']) || !empty($this->request->data['EquivalentCourse']['department_id'])) {
			
			if (empty($this->request->data['EquivalentCourse']['department_id'])) {
				$other_department_id = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->field('department_id', array(
					'Curriculum.id' => $this->request->data['EquivalentCourse']['other_curriculum_id'],
					'Curriculum.registrar_approved' => 1
				));
			}

			$otherCurriculums = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list', array(
				'conditions' => array(
					'Curriculum.department_id' => $other_department_id,
					'Curriculum.program_id' => $program_id,
					'Curriculum.registrar_approved' => 1,
					'Curriculum.active' => 1
				),
				'fields' => array('Curriculum.id', 'Curriculum.curriculum_detail'),
				'order' => array('Curriculum.id' => 'DESC')
			));
		}

		if (!empty($this->request->data['EquivalentCourse']['course_be_substitued_id']) || !empty($this->request->data['EquivalentCourse']['other_curriculum_id'])) {

			if (empty($this->request->data['EquivalentCourse']['other_curriculum_id'])) {
				$other_curriculum_id = $this->EquivalentCourse->CourseBeSubstitued->field('curriculum_id', array('CourseBeSubstitued.id' => $this->request->data['EquivalentCourse']['course_be_substitued_id']));
			}

			$courseBeSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list', array(
				'conditions' => array(
					'CourseBeSubstitued.curriculum_id' => $other_curriculum_id,
					'CourseBeSubstitued.active' => 1
				), 
				//'fields' => array('id', 'course_code', 'course_title'),		// original, Course Title appears in optgroup tag, which is more confusing and harder to filter in select box using short cut 
				'fields' => array('id', 'course_code_title', 'course_code'),  	// Course Code appears in optgroup tag and Course Tilte in the option text in select option easy to navigate and reduces error with similar course codes, 
				'order' => array('year_level_id' => 'ASC', 'id' => 'ASC')		// order courses by year level and course id for easy navigation
			));
		}

		if (!empty($this->request->data['EquivalentCourse']['course_for_substitued_id']) || !empty($this->request->data['EquivalentCourse']['curriculum_id'])) {

			if (empty($this->request->data['EquivalentCourse']['curriculum_id'])) {
				$curriculum_id = $this->EquivalentCourse->CourseBeSubstitued->field('curriculum_id', array('CourseBeSubstitued.id' => $this->request->data['EquivalentCourse']['course_for_substitued_id']));
			}

			$courseForSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list', array(
				'conditions' => array(
					'CourseBeSubstitued.curriculum_id' => $curriculum_id,
					'CourseBeSubstitued.active' => 1
				), 
				//'fields' => array('id', 'course_code', 'course_title'),		// original, Course Title appears in optgroup tag, which is more confusing and harder to filter in select box using short cut 
				'fields' => array('id', 'course_code_title', 'course_code'),  	// Course Code appears in optgroup tag and Course Tilte in the option text in select option easy to navigate and reduces error with similar course codes, 
				'order' => array('year_level_id' => 'ASC', 'id' => 'ASC')		// order courses by year level and course id for easy navigation
			));
		}

		
		$department_id = isset($this->request->data['EquivalentCourse']['department_id']) && !empty($this->request->data['EquivalentCourse']['department_id']) ? $this->request->data['EquivalentCourse']['department_id'] : (!empty($other_department_id) ? $other_department_id : '');
		$program_id = isset($this->request->data['EquivalentCourse']['program_id']) && !empty($this->request->data['EquivalentCourse']['program_id']) ? $this->request->data['EquivalentCourse']['program_id'] : (!empty($program_id) ? $program_id : '');

		$programs = $this->EquivalentCourse->CourseBeSubstitued->Curriculum->Program->find('list', array('conditions' => array('Program.id' => $this->program_ids, 'Program.active' => 1)));

		$this->set(compact(
			'courseForSubstitueds',
			'departments',
			'curriculums',
			'otherCurriculums',
			'courseBeSubstitueds',
			'programs',
			'dept_id',
			'department_id',
			'program_id',
			'other_curriculum_id',
			'course_for_substitued_id',
			'course_be_substitued_id',
			'curriculum_id',
			'curriculums_with_graduated_students'
		));
	}


	function edit($id = null)
	{
		if (!$id && empty($this->request->data)) {
			$this->Flash->error('Invalid equivalent course');
			return $this->redirect(array('action' => 'index'));
		}

		if (!$this->EquivalentCourse->checkStudentTakeingEquivalentCourseAndDenyDelete($id, $this->department_id)) {
			$this->Flash->error('Equivalent course map could not be edited. It is associated with students.');
			return $this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data)) {
			if ($this->EquivalentCourse->save($this->request->data)) {
				$this->Flash->success('The equivalent course mapping has been saved.');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The equivalent course mapping could not be saved. Please, try again.');
			}
		}

		if (empty($this->request->data)) {
			$this->request->data = $this->EquivalentCourse->read(null, $id);
		}

		$courseForSubstitueds = $this->EquivalentCourse->CourseForSubstitued->find('list', array(
			'conditions' => array(
				'CourseForSubstitued.department_id' => $this->department_id
			), 
			'fields' => array('id', 'course_title')
		));

		$courseBeSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list', array('fields' => array('id', 'course_title')));

		$this->set(compact('courseForSubstitueds', 'courseBeSubstitueds'));
	}

	function delete($id = null)
	{
		if (!$id) {
			$this->Flash->error('Invalid id for equivalent course');
			return $this->redirect(array('action' => 'index'));
		}

		//TODO check the taken equivalent course
		//Attach and Deattch, curriculum history for the student should be kept in the tables

		if ($this->EquivalentCourse->checkStudentTakeingEquivalentCourseAndDenyDelete($id, $this->department_id)) {
			if ($this->EquivalentCourse->delete($id)) {
				$this->Flash->success('Equivalent course mapping is deleted.');
				return $this->redirect(array('action' => 'index'));
			}
		} else {
			$this->Flash->error('Equivalent course map could not be deleted. It is associated with students.');
		}

		return $this->redirect(array('action' => 'index'));
	}
	function __init_search_index()
	{
		if (!empty($this->request->data['Search'])) {
			$search_session = $this->request->data['Search'];
			$this->Session->write('search_data_index', $search_session);
		} else {
			$search_session = $this->Session->read('search_data_index');
			$this->request->data['Search'] = $search_session;
		}
	}
}
