<?php
class PublishedCoursesController extends AppController
{

	public $name = 'PublishedCourses';
	public $helpers = array('Xls', 'Media.Media');
	public $menuOptions = array(
		'parent' => 'curriculums',
		'exclude' => array(
			'print_published_pdf', 'export_published_xls', 'get_year_level', 'get_course_type_session',
			'getPublishedCoursesForSplit', 'getPublishedCoursesForExam', 'get_course_grade_scale', 'get_course_grade_stats',
			'getPublishedCourses', 'selectedPublishedCourses', 'getPublishedCoursesForExamForSplit',
			'selectedPublishedCourses', 'get_course_published_for_section', 'publisheForUnassigned'
		),
		'alias' => array(
			'index' => 'View Published Courses',
			'attache_scale' => 'Attach Grade Scale',
			'add' => 'Publish/Make semester courses',
			'college_attache_scale' => 'Attache Scale',
			'unpublish' => 'Unpublish/Publish as drop semester courses',
			'college_publish_course' => 'Publish Courses For Freshman.',
			'college_unpublish_course' => 'Unpublish/Publish Courses as drop For Freshman.'

		)
	);
	public $components = array('AcademicYear');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->Allow(
			'getPublishedCourses',
			'getPublishedCoursesForSplit',
			'get_year_level',
			'selectedPublishedCourses',
			'getPublishedCoursesForExam',
			'getPublishedCoursesForExamForSplit',
			'get_course_type_session',
			'publisheForUnassigned',
			'get_course_grade_scale',
			'get_course_grade_stats',
			'get_course_published_for_section'
		);
	}
	public function beforeRender()
	{

		$acyear_array_data = $this->AcademicYear->acyear_array();
		//To diplay current academic year as default in drop down list
		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		foreach ($acyear_array_data as $k => $v) {
			if ($v == $defaultacademicyear) {
				$defaultacademicyear = $k;
				break;
			}
		}
		$this->set(compact('acyear_array_data', 'defaultacademicyear'));
	}

	public function index($semester = null, $academic_year = null)
	{
		//	$this->PublishedCourse->recursive = 0;
		if (!empty($semester) && !empty($academic_year)) {
			$academic_year = str_replace('-', '/', $academic_year);
			$this->request->data['PublishedCourse']['semester'] = $semester;
			$this->request->data['PublishedCourse']['academic_year'] = $academic_year;
		}
		if ($this->role_id == ROLE_COLLEGE) {
			$conditions = null;
			if (!empty($this->request->data)) {
				$everythingfine = false;
				switch ($this->request->data) {
					case empty($this->request->data['PublishedCourse']['academic_year']):
						$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to view publish courses.'), 'default', array('class' => 'error-box error-message'));
						break;
					case empty($this->request->data['PublishedCourse']['semester']):
						$this->Session->setFlash('<span></span> ' . __('Please select the semester you want to view published courses. '), 'default', array('class' => 'error-box error-message'));
						break;

					default:
						$everythingfine = true;
				}
				if ($everythingfine) {
					$programs = $this->PublishedCourse->Program->find('list');
					// debug($programs);
					$programTypes = $this->PublishedCourse->ProgramType->find('list');

					$academic_year = $this->request->data['PublishedCourse']['academic_year'];
					$semester = $this->request->data['PublishedCourse']['semester'];

					$sections = $this->PublishedCourse->Section->find(
						'list',
						array('condtions' => array(
							'Section.college_id' => $this->college_id,
							'Section.academicyear ' => $academic_year,
							'OR' => array(
								'Section.department_id is null',
								'Section.department_id' => array('', 0)
							)
						))
					);

					foreach ($sections as $sk => $sv) {  // loop section by section
						//debug($sv);
						if (!empty($academic_year)) {
							$conditions = array(
								"PublishedCourse.college_id " => $this->college_id,

								"PublishedCourse.semester" => $this->request->data['PublishedCourse']['semester'],

								"PublishedCourse.published" => 1,
								"PublishedCourse.section_id" => $sk,
								"PublishedCourse.academic_year LIKE " => $academic_year . '%'
							);
						} else {
							$conditions = array(
								"PublishedCourse.college_id " => $this->college_id,
								"PublishedCourse.semester" => $this->request->data['PublishedCourse']['semester'],

								"PublishedCourse.published" => 1,
								"PublishedCourse.section_id" => $sk

							);
						}
						$checkempty = $this->paginate($conditions);
						if (!empty($checkempty)) {
							$tmpcopy = array();
							foreach ($checkempty as $chindex => $chevalue) {
								if (
									$chevalue['PublishedCourse']['add'] == 0
									&& $chevalue['PublishedCourse']['drop'] == 0
								) {
									$tmpcopy['Semester Registered'][] = $chevalue;
								} else if ($chevalue['PublishedCourse']['add'] == 1) {
									$tmpcopy['Mass Add'][] = $chevalue;
								} else if ($chevalue['PublishedCourse']['drop'] == 1) {
									$tmpcopy['Mass Drop'][] = $chevalue;
								}
							}

							$publishedCourses[$sv] = $tmpcopy;
						}
					} // end of section by

					if (empty($publishedCourses)) {
						$this->Session->setFlash('<span></span>' . __('There is no published courses in the given search criteria. Please select different criteria.'), 'default', array('class' => 'error-box error-message'));
					} else {

						$this->set('publishedCoursesCollege', $publishedCourses);
						$this->set(compact('semester', 'academic_year'));
						//$this->Session->write('publishedCourses',$publishedCourses);
						$this->Session->write('selected_academic_year', $academic_year);
					}
				}
			}
		}
		if ($this->role_id == ROLE_DEPARTMENT) {
			$conditions = null;
			if (!empty($this->request->data)) {
				$everythingfine = false;
				switch ($this->request->data) {
					case empty($this->request->data['PublishedCourse']['academic_year']):
						$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to view publish courses.'), 'default', array('class' => 'error-box error-message'));
						break;
					case empty($this->request->data['PublishedCourse']['semester']):
						$this->Session->setFlash('<span></span> ' . __('Please select the semester you want to view published courses. '), 'default', array('class' => 'error-box error-message'));
						break;

					default:
						$everythingfine = true;
				}
				if ($everythingfine) {
					if ($this->role_id == ROLE_COLLEGE) {
						$college_department['PublishedCourse.college_id'] = $this->college_id;
					} else {
						$college_department['PublishedCourse.department_id'] = $this->department_id;
					}

					$academic_year = $this->request->data['PublishedCourse']['academic_year'];

					$publishedCourses = null;
					$options = array();

					$options['conditions']['PublishedCourse.department_id'] = $this->department_id;
					$options['conditions']['PublishedCourse.semester'] =  $this->request->data['PublishedCourse']['semester'];

					$options['conditions']['PublishedCourse.academic_year'] =  $academic_year;
					//   $options['conditions']['PublishedCourse.published'] =  1;
					$options['contain'] = array(
						'YearLevel',
						'Course',
						'ProgramType',
						'Program',
						'Department',
						'GivenByDepartment',
						'College',
						'Section'
					);

					//  $checkempty=$this->paginate($conditions);
					$checkempty = $this->PublishedCourse->find('all', $options);
					// debug($checkempty);

					if (!empty($checkempty)) {
						$section_one = null;

						$last_index = count($checkempty) - 1;
						foreach ($checkempty as $chindex => $chevalue) {


							if (
								$chevalue['PublishedCourse']['add'] == 0
								&& $chevalue['PublishedCourse']['drop'] == 0
							) {
								$tmpcopy[$chevalue['PublishedCourse']['section_id']]['Semester Registered'][] = $chevalue;
							} else if ($chevalue['PublishedCourse']['add'] == 1) {
								$tmpcopy[$chevalue['PublishedCourse']['section_id']]['Mass Add'][] = $chevalue;
							} else if ($chevalue['PublishedCourse']['drop'] == 1) {
								$tmpcopy[$chevalue['PublishedCourse']['section_id']]['Mass Drop'][] = $chevalue;
							}

							$publishedCourses[$this->request->data['PublishedCourse']['semester']][$chevalue['Program']['name']][$chevalue['ProgramType']['name']][$chevalue['YearLevel']['name']][$chevalue['Section']['name']] =
								$tmpcopy[$chevalue['PublishedCourse']['section_id']];
						}
					}


					if (empty($publishedCourses)) {
						$this->Session->setFlash('<span></span>' . __('There is no published courses in the given search criteria. Please select different criteria.'), 'default', array('class' => 'error-box error-message'));
					} else {
						$this->set('publishedCourses', $publishedCourses);
						$this->set(compact('semester', 'academic_year'));
						$this->Session->write('publishedCourses', $publishedCourses);
						$this->Session->write('selected_academic_year', $academic_year);
					}
				}
			} else {
				// $this->set('publishedCourses', $this->paginate());

			}
		}
		if ($this->role_id == ROLE_REGISTRAR) {
			$year_level_find = $this->PublishedCourse->YearLevel->find('all', array(
				'fields' => array('DISTINCT YearLevel.name', 'YearLevel.id'),
				'order' => 'YearLevel.name asc', 'group' => 'YearLevel.name', 'recursive' => -1
			));
			$extract = Set::extract('/YearLevel/name', $year_level_find);
			$another = Set::extract('/YearLevel/id', $year_level_find);
			$combined = array_combine($another, $extract);
			$yearLevels = $combined;
			$this->set(compact('yearLevels'));
		}
	}

	public function view($id = null)
	{
		if (!$id) {
			$this->Session->setFlash(
				'<span>' . __('Invalid published course'),
				'default',
				array('class' => 'error-box error-message')
			);
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->role_id == ROLE_DEPARTMENT) {
			$conditions = array('PublishedCourse.id' => $id, 'PublishedCourse.department_id' => $this->department_id);
		} else if ($this->role_id == ROLE_DEPARTMENT) {
			$conditions = array('PublishedCourse.id' => $id, 'PublishedCourse.department_id' => $this->college_id);
		}
		$publishedCourse = $this->PublishedCourse->find('first', array('conditions' => $conditions));
		$this->set('publishedCourse', $publishedCourse);
	}

	public function add()
	{
		if (!empty($this->request->data) && isset($this->request->data['getsection'])) {
			$everythingfine = false;
			switch ($this->request->data) {
				case empty($this->request->data['Course']['academicyear']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to publish courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['Curriculum']['semester']):
					$this->Session->setFlash('<span></span> ' . __('Please select the semester you want to publish courses. Please, try again.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['Course']['year_level_id']):
					$this->Session->setFlash('<span></span> ' . __('Please select the year level you want to publish courses. Please, try again.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['Curriculum']['program_id']):
					$this->Session->setFlash('<span></span> ' . __('Please select the program you want to publish courses. Please, try again.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['Curriculum']['program_type_id']):
					$this->Session->setFlash('<span></span> ' . __('Please select the program type you want to publish courses. Please, try again.'), 'default', array('class' => 'error-box error-message'));
					break;
				default:
					$everythingfine = true;
			}

			if ($everythingfine) {
				debug($this->request->data);
				$sections = $this->PublishedCourse->Section->find(
					'list',
					array('conditions' => array(
						'Section.department_id' => $this->department_id,
						'Section.year_level_id' => $this->request->data['Course']['year_level_id'],
						'Section.program_id' => $this->request->data['Curriculum']['program_id'],
						'Section.program_type_id' => $this->request->data['Curriculum']['program_type_id'],
						'Section.archive' => 0,

						'Section.academicyear' =>
						$this->request->data['Course']['academicyear']
					))
				);
				debug($sections);
				// get the curriculum of each section student is attending and
				// attach it and display for the user
				$section_array_list = $this->__section_curriculum($sections, true);
				debug($section_array_list);
				$sections = $section_array_list;

				if (empty($sections)) {

					$this->Session->setFlash('<span></span> ' . __('There is no section  needs courses publishing in the selected criteria.'), 'default', array('class' => 'info-box info-message'));
				} else {
					$year_level_id = $this->request->data['Course']['year_level_id'];
					$program_id = $this->request->data['Curriculum']['program_id'];
					$program_type_id = $this->request->data['Curriculum']['program_type_id'];
					$academic_year = $this->request->data['Course']['academicyear'];
					$semester = $this->request->data['Curriculum']['semester'];

					$this->set('turn_off_search', true);
					$this->set(compact(
						'sections',
						'year_level_id',
						'program_id',
						'program_type_id',
						'curriculum_id',
						'academic_year',
						'section_map_curriculum',
						'semester'
					));
				}
			} else {

				//$this->redirect(array('action'=>'add'));
			}
		}

		if (!empty($this->request->data) && isset($this->request->data['continuepublish'])) {

			$everythingfine = false;
			switch ($this->request->data) {

				case empty($this->request->data['PublishedCourse']['section_id']):
					$this->Session->setFlash('<span></span>' . __('Please select atleast one section you want to publish courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				default:
					$everythingfine = true;
			}
			if ($everythingfine) {
				$sections = $this->PublishedCourse->Section->find(
					'list',
					array('conditions' => array(
						'Section.department_id' => $this->department_id,
						'Section.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
						'Section.archive' => 0,
						'Section.academicyear' => $this->request->data['Course']['academicyear']
					))
				);

				$selected_section = array();

				foreach ($this->request->data['PublishedCourse']['section_id'] as $pse => $psv) {
					$selected_section[$psv] = $sections[$psv];
				}

				// curriculum of selected section
				$section_curriculum_attachment = $this->__section_curriculum($selected_section, false);
				//$sections=$this->__section_curriculum($selected_section,true);
				$sections = $this->__section_curriculum($sections, true);

				//find the already taken courses of the section
				$section_already_taken_courses = array();
				$max_courses_taken_count = 0;
				$max_courses_taken_index_student = 0;
				//  debug($this->request->data['PublishedCourse']['section_id']);
				foreach ($this->request->data['PublishedCourse']['section_id'] as $sec_key => $sec_Id) {

					$courses = $this->PublishedCourse->Section->studentsAlreaydTakenCourse($sec_Id);

					foreach ($courses as $ck => $cv) {
						if (!empty($cv['Student'])) {

							foreach ($cv['Student']
								as $index => $course) {
								if (count($course['CourseRegistration']) <= $max_courses_taken_count) {
									$max_courses_taken_count = count($course['CourseRegistration']);
									$max_courses_taken_index_student = $index;
								}
							}
							debug($max_courses_taken_index_student);

							if (
								isset($cv['Student'][$max_courses_taken_index_student]['CourseRegistration'])
								&& !empty($cv['Student'][$max_courses_taken_index_student]['CourseRegistration'])
							) {
								foreach ($cv['Student'][$max_courses_taken_index_student]['CourseRegistration'] as $kk => $course_ids) {
									debug($course_ids);
									if ($this->PublishedCourse->Course->isCourseTakenHaveRecentPassGrade($course_ids['student_id'], $course_ids['PublishedCourse']['course_id'])) {
										$section_already_taken_courses[$sec_Id][] = $course_ids['PublishedCourse']['course_id'];
									}
								}
							} else {
								$section_already_taken_courses[$sec_Id][] = 0;
							}
						}
					}
				}
				debug($section_already_taken_courses);

				$ready_for_publishing_courses = array();
				// incase all students fail or something happens
				$taken_courses_allow_to_publishe_it = array();

				foreach ($section_already_taken_courses as $section_id => $taken_courses) {

					if (!empty($taken_courses)) {
						// without semester to make it flexible for users, but huge course list
						// 'Course.semester'=>trim($this->request->data['PublishedCourse']['semester'])
						$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find('all', array('conditions' => array('Course.curriculum_id' => $section_curriculum_attachment[$section_id], 'Course.department_id' => $this->department_id, "NOT" => array('Course.id ' => $taken_courses)), 'contain' => array('PublishedCourse')));
						$taken_courses_allow_to_publishe_it[$section_id] = $this->PublishedCourse->Course->find('all', array('conditions' => array(
							'Course.curriculum_id' =>
							$section_curriculum_attachment[$section_id],
							'Course.department_id' => $this->department_id,
							'Course.id ' => $taken_courses
						), 'contain' => array('PublishedCourse')));

						$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find('all', array('conditions' => array('Course.curriculum_id' => $section_curriculum_attachment[$section_id], "NOT" => array('Course.id ' => $taken_courses)), 'contain' => array('PublishedCourse')));
						$taken_courses_allow_to_publishe_it[$section_id] = $this->PublishedCourse->Course->find('all', array('conditions' => array(
							'Course.curriculum_id' =>
							$section_curriculum_attachment[$section_id],
							'Course.department_id' => $this->department_id,
							'Course.id ' => $taken_courses
						), 'contain' => array('PublishedCourse')));
					} else {
						// without semester to make it flexible for users, but huge course list
						// 'Course.semester'=>trim($this->request->data['PublishedCourse']['semester'])
						$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find(
							'all',
							array(
								'conditions' => array(
									'Course.curriculum_id' =>
									$section_curriculum_attachment[$section_id],

									'Course.department_id' => $this->department_id
								),
								'contain' => array(
									'PublishedCourse'
								)
							)
						);
					}
				}


				$this->set('coursesss', $ready_for_publishing_courses);
				$this->set(compact('taken_courses_allow_to_publishe_it'));
				$show_publish_page = true;

				$year_level_id = $this->request->data['PublishedCourse']['year_level_id'];
				$program_id = $this->request->data['PublishedCourse']['program_id'];
				$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
				$academic_year = $this->request->data['PublishedCourse']['academic_year'];
				$semester = $this->request->data['PublishedCourse']['semester'];
				// $sections=$selected_section;
				$this->set(compact('show_publish_page'));
				$this->set('turn_off_search', true);


				$this->set(compact(
					'sections',
					'year_level_id',
					'program_id',
					'program_type_id',
					'academic_year',
					'semester',
					'selected_section'
				));
			} else {
				$sections = $this->PublishedCourse->Section->find(
					'list',
					array('conditions' => array(
						'Section.department_id' => $this->department_id,
						'Section.year_level_id' => $this->request->data['PublishedCourse']['year_level_id']
					))
				);


				$section_array_list = $this->__section_curriculum($sections, true);
				$sections = $section_array_list;
				$year_level_id = $this->request->data['PublishedCourse']['year_level_id'];
				$academic_year = $this->request->data['PublishedCourse']['academic_year'];
				$program_id = $this->request->data['PublishedCourse']['program_id'];
				$semester = $this->request->data['PublishedCourse']['semester'];
				$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
				$this->set('turn_off_search', true);
				$this->set(compact(
					'year_level_id',
					'academic_year',
					'program_id',
					'program_type_id',
					'semester'
				));
			}
		}

		if (!empty($this->request->data) && isset($this->request->data['publishselectedasadd'])) {

			unset($this->request->data['PublishedCourse']['section_id']);

			$this->request->data['PublishedCourse']['department_id'] = $this->department_id;

			$save_reformated_published_courses = array();
			$courses_ids = array();
			$section_ids = array();

			$count = 0;
			foreach ($this->request->data['Course'] as $section_id => $courses) {

				$section_ids[] = $section_id;
				foreach ($courses as $cid => $is_selected) {
					if ($is_selected != 0) {

						$save_reformated_published_courses['PublishedCourse'][$count] = $this->request->data['PublishedCourse'];
						$save_reformated_published_courses['PublishedCourse'][$count]['published'] = 1;
						$save_reformated_published_courses['PublishedCourse'][$count]['course_id'] = $cid;
						$save_reformated_published_courses['PublishedCourse'][$count]['section_id'] = $section_id;
						$save_reformated_published_courses['PublishedCourse'][$count]['given_by_department_id'] =
							$this->department_id;

						$save_reformated_published_courses['PublishedCourse'][$count]['add'] = 1;
						$courses_ids[] = $cid;

						$count++;
					}
				}
			}

			$check_courses_published = $this->PublishedCourse->find(
				'count',
				array('conditions' => array(
					'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'], 'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
					'PublishedCourse.course_id' => $courses_ids, 'PublishedCourse.section_id' => $section_ids, 'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'], 'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
					'PublishedCourse.department_id' => $this->department_id
				))
			);

			$published_courses = $this->PublishedCourse->find(
				'list',
				array(
					'conditions' => array(
						'PublishedCourse.academic_year like' => $this->request->data['PublishedCourse']['academic_year'] . '%',
						'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.section_id' => $section_ids,
						'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
						'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.department_id' => $this->department_id
					),
					'fields' => 'PublishedCourse.course_id'
				)
			);

			// unset those courses which has already published and publish only coures not published
			foreach ($published_courses as $pk => $pv) {
				//check and unset those already published courses
				foreach ($save_reformated_published_courses['PublishedCourse'] as $sk => &$sv) {
					if ($sv['course_id'] == $pv) {
						unset($save_reformated_published_courses['PublishedCourse'][$sk]);
					}
				}
			}

			// check if all courses has already published and redirect the user to the published course page.
			if ($check_courses_published == count($courses_ids)) {
				$this->Session->setFlash(
					'<span></span>' . __('The selected courses has  already published  for the selected criteria'),
					'default',
					array('class' => 'info-box info-message')
				);
				$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
				$this->redirect(array(
					'action' => 'index',
					$this->request->data['PublishedCourse']['semester'], $academic_year
				));
			}
			$count_already_published = count($published_courses);
			$count_ready_published = count($save_reformated_published_courses);
			if ($this->PublishedCourse->saveAll(
				$save_reformated_published_courses['PublishedCourse'],
				array('validate' => 'first')
			)) {
				if ($count_already_published == 0) {
					$this->Session->setFlash(
						'<span></span>' . __('The course has been published for registration.'),
						'default',
						array('class' => 'success-box success-message')
					);
				} else {
					$this->Session->setFlash(
						'<span></span>' . __('Among selected courses for the publishing ' . $count_ready_published . ' has been published, but ' . $count_already_published . ' has already published previously, you don\'t need to republish it.'),
						'default',
						array('class' => 'success-box success-message')
					);
				}
				$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
				$this->redirect(array(
					'action' => 'index',
					$this->request->data['PublishedCourse']['semester'], $academic_year
				));
			} else {
				$this->Session->setFlash(
					'<span></span>' . __('The published course could not be saved. Please, try again.'),
					'default',
					array('class' => 'error-box error-message')
				);
			}
		}

		if (!empty($this->request->data) && isset($this->request->data['publishselected'])) {

			unset($this->request->data['PublishedCourse']['section_id']);
			$this->request->data['PublishedCourse']['department_id'] = $this->department_id;
			$save_reformated_published_courses = array();
			$courses_ids = array();
			$section_ids = array();
			$upgrade_downgrade_section = 0;
			$count = 0;
			/////////////////////////////////////////////////////////////////////
			debug($this->request->data);
			foreach ($this->request->data['Course'] as $section_id => $courses) {
				$section_ids[] = $section_id;
				foreach ($courses as $cid => $is_selected) {
					if ($is_selected != 0) {

						$save_reformated_published_courses['PublishedCourse'][$count] = $this->request->data['PublishedCourse'];
						$save_reformated_published_courses['PublishedCourse'][$count]['published'] = 1;
						$save_reformated_published_courses['PublishedCourse'][$count]['course_id'] = $cid;
						$save_reformated_published_courses['PublishedCourse'][$count]['section_id'] = $section_id;
						$save_reformated_published_courses['PublishedCourse'][$count]['given_by_department_id'] = $this->department_id;

						$save_reformated_published_courses['PublishedCourse'][$count]['elective'] = $this->request->data['Elective'][$section_id][$cid];

						$courses_ids[] = $cid;

						$count++;
					}
				}
			}

			//$selected_sections_publishe=array();
			if ($this->role_id == ROLE_DEPARTMENT) {
				foreach ($this->request->data['Section']['selected'] as $sec_id => $sec_value) {
					if ($sec_value != 0) {
						$check_if_course_is_published_for_given_academic_year_semester = $this->PublishedCourse->find('count', array('conditions' => array(
							'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'],
							'PublishedCourse.department_id' => $this->department_id,
							'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'], 'PublishedCourse.section_id' => $sec_id,
							'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
							'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
							'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id']
						)));


						if ($check_if_course_is_published_for_given_academic_year_semester == 0) {
							$prev_semester_academic_year = $this->PublishedCourse->CourseRegistration->Student->StudentExamStatus->getPreviousSemester(
								$this->request->data['PublishedCourse']['academic_year'],
								$this->request->data['PublishedCourse']['semester']
							);

							$check_previous_semester_published = $this->PublishedCourse->previous_semester_and_academic_course_published(
								$this->request->data['PublishedCourse']['semester'],
								$this->request->data['PublishedCourse']['academic_year'],
								$this->department_id,
								$this->request->data['PublishedCourse']['program_id'],
								$this->request->data['PublishedCourse']['program_type_id'],
								$this->request->data['PublishedCourse']['year_level_id'],
								$sec_id
							);

							if (!$check_previous_semester_published) {
								$upgrade_downgrade_section = $sec_value;

								break;
							}
						}
					}
				}
			}
			///////////////////////////////////////////////////////////////////////
			debug($upgrade_downgrade_section);
			if ($count == 0 ||  $upgrade_downgrade_section > 0) {
				$year_level_id = $this->request->data['PublishedCourse']['year_level_id'];
				$program_id = $this->request->data['PublishedCourse']['program_id'];
				$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
				$academic_year = $this->request->data['PublishedCourse']['academic_year'];
				$semester = $this->request->data['PublishedCourse']['semester'];

				$this->set('turn_off_search', true);

				$sections = $this->PublishedCourse->Section->find(
					'list',
					array('conditions' => array(
						'Section.department_id' => $this->department_id,
						'Section.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
						'Section.id' => $this->request->data['Section']['selected']
					))
				);

				$selectedsection = $this->request->data['Section']['selected'];

				$sections = $this->__section_curriculum($sections, true);


				if ($count == 0) {
					$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to publish.'), 'default', array('class' => 'error-box error-message'));
				} else {
					$prev_semester_academic_year = $this->PublishedCourse->CourseRegistration->Student->StudentExamStatus->getPreviousSemester(
						$this->request->data['PublishedCourse']['academic_year'],
						$this->request->data['PublishedCourse']['semester']
					);

					$this->Session->setFlash(
						'<span></span>' . __('You can not publish semester ' . $this->request->data['PublishedCourse']['semester'] . ' of ' . $this->request->data['PublishedCourse']['academic_year'] . '
                               before publishing semester ' .
							$prev_semester_academic_year['semester'] . ' of '
							. $prev_semester_academic_year['academic_year'] . '
                               for ' . $sections[$upgrade_downgrade_section] . '', true),
						"session_flash_link",
						array(
							"class" => 'error-box error-message',
							"link_text" => " Upgrade or downgrade section.",
							"link_url" => array(
								"controller" => "sections",
								"action" => "upgrade_sections",
								"admin" => false
							)
						)
					);
				}
				$this->set(compact(
					'sections',
					'year_level_id',
					'program_id',
					'program_type_id',
					'curriculum_id',
					'academic_year',
					'section_map_curriculum',
					'semester',
					'selectedsection'
				));
				//$this->render('selectedPublishedCourses');
			} else {

				$selected_sections_ids = array();
				//debug($this->request->data['Section']['selected']);
				foreach ($this->request->data['Section']['selected'] as $se_index => $se_value) {
					if ($se_value != 0) {
						$selected_sections_ids[] = $se_index;
					}
				}

				$check_courses_published = $this->PublishedCourse->find(
					'count',
					array('conditions' => array(
						'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'], 'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.course_id' => $courses_ids,
						'PublishedCourse.section_id' => $selected_sections_ids,
						'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
						'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.department_id' => $this->department_id
					))
				);

				// dont allow publication for semester if students has started registration

				if (!empty($selected_sections_ids)) {
					$list_courses_published_ids = $this->PublishedCourse->find(
						'list',
						array('conditions' => array(
							'PublishedCourse.academic_year like ' =>
							$this->request->data['PublishedCourse']['academic_year'] . '%',
							'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
							'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
							'PublishedCourse.section_id' => $selected_sections_ids,
							'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
							'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
							'PublishedCourse.department_id' => $this->department_id
						), 'fields' => 'id')
					);
				}


				if (isset($list_courses_published_ids) && !empty($list_courses_published_ids)) {

					$check_registration_started = $this->PublishedCourse->CourseRegistration->find(
						'count',
						array('conditions' => array('CourseRegistration.published_course_id' => $list_courses_published_ids))
					);

					if ($check_registration_started == 0) {
						$check_registration_started = $this->PublishedCourse->CourseAdd->find(
							'count',
							array('conditions' => array('CourseAdd.published_course_id' => $list_courses_published_ids))
						);
					}
				} else {
					$check_registration_started = 0;
				}

				if ($check_registration_started == 0) {

					///////////////////////////////////////////////////////////////////
					$published_courses = $this->PublishedCourse->find(
						'list',
						array(
							'conditions' => array(
								'PublishedCourse.academic_year like ' =>
								$this->request->data['PublishedCourse']['academic_year'] . '%',
								'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
								'PublishedCourse.section_id' => $section_ids,
								'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
								'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
								'PublishedCourse.department_id' => $this->department_id
							),
							'fields' => 'PublishedCourse.course_id'
						)
					);

					if ($this->PublishedCourse->saveAll(
						$save_reformated_published_courses['PublishedCourse'],
						array('validate' => 'first')
					)) {
						$this->Session->setFlash(
							'<span></span>' . __('Course has been published for
			            registration for ' . $this->request->data['PublishedCourse']['academic_year'] . ' academic year
			            and semester ' . $this->request->data['PublishedCourse']['semester'] . '.', true),
							'default',
							array('class' => 'success-box success-message')
						);

						$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
						$this->redirect(array(
							'action' => 'index',
							$this->request->data['PublishedCourse']['semester'], $academic_year
						));
					} else {
						$this->Session->setFlash(
							'<span></span>' . __('The published course could not be saved. Please, try again.'),
							'default',
							array('class' => 'error-box error-message')
						);
					}
				} else {
					$this->Session->setFlash(
						'<span></span>' . __(' You can not publish semester courses since registration has already started, but you can publish course as mass add.'),
						'default',
						array('class' => 'error-box error-message')
					);

					$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
					$this->redirect(array(
						'action' => 'index',
						$this->request->data['PublishedCourse']['semester'], $academic_year
					));
				}
			}

			$this->request->data['PublishedCourse'] = $this->Session->read('search_data');

			$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
				'PublishedCourse.department_id' => $this->department_id, 'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'], 'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'], 'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
				'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'],
				'PublishedCourse.published' => 1
			)));

			$this->set('turn_off_search', true);
			$this->set('show_unpublish_page', true);
			$this->set('publishedcourses', $this->PublishedCourse->getSectionofPublishedCourses(
				$this->request->data,
				$this->department_id,
				$publishedcourses
			));
		}
		$yearLevels = $this->PublishedCourse->YearLevel->find('list', array('conditions' => array(
			'YearLevel.department_id' => $this->department_id
		)));

		$programTypes = $this->PublishedCourse->ProgramType->find('list');
		$programs = $this->PublishedCourse->Program->find('list');

		$this->set(compact('yearLevels', 'courses', 'programTypes', 'colleges', 'programs', 'departments', 'sections'));
	}

	public function unpublish()
	{

		if (!empty($this->request->data) && isset($this->request->data['getsection'])) {

			$everythingfine = false;
			switch ($this->request->data) {
				case empty($this->request->data['PublishedCourse']['academic_year']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['year_level_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the year level you want to unpublished courses. Please, try again.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['semester']):
					$this->Session->setFlash('<span></span>' . __('Please select the semester you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['program_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the program you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['program_type_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the program type you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				default:
					$everythingfine = true;
			}

			if ($everythingfine) {
				// Function to load/save search criteria.
				$this->__init_search();

				$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
					'PublishedCourse.department_id' => $this->department_id,
					'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
					'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
					'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
					'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
					'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
					'PublishedCourse.published' => 1
				), 'contain' => array(
					'Course' => array('fields' => array('id', 'course_title', 'course_code', 'semester', 'credit', 'lecture_hours', 'tutorial_hours'), 'YearLevel' => array('id', 'name')), 'YearLevel' => array('id', 'name'), 'Section' => array('id', 'name'), 'Program' => array('id', 'name'),
					'ProgramType' => array('id', 'name')
				)));



				if (empty($publishedcourses)) {
					$this->Session->setFlash('<span></span>' . __('There is no published courses in the given criteria, please select different criteria.'), 'default', array('class' => 'error-box error-message'));
					// exit;
				} else {


					$this->set('turn_off_search', true);
					$this->set('show_unpublish_page', true);
					$year_level_id = $this->request->data['PublishedCourse']['year_level_id'];
					$program_id = $this->request->data['PublishedCourse']['program_id'];
					$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];

					$this->set('publishedcourses', $this->PublishedCourse->getSectionofPublishedCourses(
						$this->request->data,
						$this->department_id,
						$publishedcourses
					));


					$this->set(compact('year_level_id', 'program_id', 'program_type_id'));
				}
			} else {

				//$this->redirect(array('action'=>'add'));
			}
		}

		//delete publisehd courses
		if (!empty($this->request->data) && isset($this->request->data['deleteselected'])) {

			$count = 0;
			$courses_ids = array();
			$section_ids = array();
			foreach ($this->request->data['Course']['pub'] as $section_id => $selected_courses) {
				$section_ids[] = $section_id;
				foreach ($selected_courses as $course_id => $selected_flag) {
					if ($selected_flag == 1) {

						$count++;
						$courses_ids[$section_id][] = $course_id;
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to delete.'), 'default', array('class' => 'error-box error-message'));
			} else {
				$this->request->data['PublishedCourse'] = $this->Session->read('search_data');
				$courses_not_allowed = array();
				$courses_allowed_to_delete = array();

				foreach ($section_ids as $kk => $sv) {
					if (isset($courses_ids[$sv])) {

						$publishedcourses = $this->PublishedCourse->find(
							'all',
							array(
								'conditions' => array(
									'PublishedCourse.department_id' => $this->department_id,
									'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
									'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
									'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],

									'PublishedCourse.course_id' => $courses_ids[$sv],
									'PublishedCourse.section_id' => $sv,
									'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
									'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%'
								),

								'contain' => array(

									'CourseRegistration' => array(
										'Student' => array(
											'fields' => array(
												'Student.full_name',

											)
										)

									)
								),

							)
						);

						foreach ($publishedcourses as $pk => $pv) {

							if (count($pv['CourseRegistration']) == 0) {
								$courses_allowed_to_delete[$sv][$pk] = $pv['PublishedCourse']['id'];
								//$courses_allowed_to_delete[$pk]['course_id']=$pv['PublishedCourse']['course_id'];

							} else {
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['id'];
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['course_id'];
							}
						}
					}
				}
				//iterate section by section

				if (count($courses_not_allowed) > 0) {
					$this->Session->setFlash('<span></span>' . __('You can not delete the red marked courses , students has already registered for the courses. Please uncheck the red marked courses.'), 'default', array('class' => 'error-box error-message'));
					$this->set(compact('courses_not_allowed'));
				} else {
					//$count_deleted_record=count($courses_allowed_to_delete);

					$count_delete_record = array();
					foreach ($section_ids as $key => $section_id) {
						if (isset($courses_allowed_to_delete[$section_id])) {
							if ($this->PublishedCourse->deleteAll(array('PublishedCourse.id' => $courses_allowed_to_delete[$section_id]), false)) {
								$count_delete_record[$section_id] = count($courses_allowed_to_delete[$section_id]);
							}
						}
					}

					if (!empty($count_delete_record)) {
						$sum = 0;
						foreach ($count_delete_record as $sec_id => $del_count) {
							$sum += $del_count;
						}
						if ($sum > 0) {
							$this->Session->setFlash(
								'<span></span>' .
									__('You have deleted ' . $sum . '  published course.'),
								'default',
								array('class' => 'success-box success-message')
							);
						} else {
							$this->Session->setFlash(
								'<span></span>' . __('Published course was not deleted.Pleas try again.'),
								'default',
								array('class' => 'error-box error-message')
							);
						}
					}
				}
			}

			$this->request->data['PublishedCourse'] = $this->Session->read('search_data');
			$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
				'PublishedCourse.department_id' => $this->department_id,
				'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
				'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
				'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
				'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
				'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'],
				'PublishedCourse.published' => 1
			)));

			$this->set('turn_off_search', true);
			$this->set('show_unpublish_page', true);
			$this->set('publishedcourses', $this->PublishedCourse->getSectionofPublishedCourses($this->request->data, $this->department_id, $publishedcourses));
		}

		//publish as drop coures drop publisehd courses
		if (!empty($this->request->data) && isset($this->request->data['dropselected'])) {

			$count = 0;
			$courses_ids = array();
			$section_ids = array();
			if (!empty($this->request->data['Course']['pub'])) {

				foreach ($this->request->data['Course']['pub'] as $section_id => $selected_courses) {
					$section_ids[] = $section_id;
					foreach ($selected_courses as $course_id => $selected_flag) {
						if ($selected_flag == 1) {

							$count++;
							$courses_ids[$section_id][] = $course_id;
						}
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to publish as drop course.'), 'default', array('class' => 'error-box error-message'));
			} else {
				$this->request->data['PublishedCourse'] = $this->Session->read('search_data');

				$courses_not_allowed = array();
				$courses_allowed_to_drop = array();
				foreach ($section_ids as $kk => $sv) {
					if (isset($courses_ids[$sv])) {
						$publishedcourses = $this->PublishedCourse->find(
							'all',
							array(
								'conditions' => array(
									'PublishedCourse.department_id' => $this->department_id, 'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'], 'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'], 'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
									'PublishedCourse.published' => 1, 'PublishedCourse.course_id' => $courses_ids[$sv],
									'PublishedCourse.section_id' => $sv,
									'PublishedCourse.drop' => 0,
									'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
									'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%'
								),

								'contain' => array(

									'CourseRegistration' => array(
										'Student' => array(
											'fields' => array(
												'Student.full_name',

											)
										)

									)
								)
							)
						);

						foreach ($publishedcourses as $pk => $pv) {

							if (count($pv['CourseRegistration']) > 0) {
								$courses_allowed_to_drop[$sv][$pk] = $pv['PublishedCourse']['id'];
								//$courses_allowed_to_delete[$pk]['course_id']=$pv['PublishedCourse']['course_id'];

							} else {
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['id'];
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['course_id'];
							}
						}
					}
				}

				if (count($courses_not_allowed) > 0) {
					$this->Session->setFlash('<span></span>' . __('There is no registration for the red marked course(s) so you can delete it permanently rather than asking the registrar or student to drop.'), 'default', array('class' => 'error-box error-message'));
					$this->set(compact('courses_not_allowed'));
				} else {

					// reformat courses_allowed to unpublished
					$save_reformat_drop_published_courses = array();
					if (!empty($section_ids)) {
						$count_drop = 0;
						foreach ($section_ids as $section_index => $section_id) {
							if (isset($courses_allowed_to_drop[$section_id])) {
								foreach ($courses_allowed_to_drop[$section_id] as $index => $course_id) {
									$save_reformat_drop_published_courses['PublishedCourse'][$count_drop]['id']
										= $course_id;

									$save_reformat_drop_published_courses['PublishedCourse'][$count_drop]['published'] = 1;
									$save_reformat_drop_published_courses['PublishedCourse'][$count_drop]['drop'] = 1;
									$count_drop++;
								}
							}
						}



						//save the drop published coureses
						if (count($save_reformat_drop_published_courses['PublishedCourse']) > 0) {
							if ($this->PublishedCourse->saveAll(
								$save_reformat_drop_published_courses['PublishedCourse'],
								array('validate' => 'first')
							)) {

								$this->Session->setFlash(
									'<span></span>' . __('Among selected  courses ' . $count_drop . ' has been published as drop course.'),
									'default',
									array('class' => 'success-box success-message')
								);

								//$academic_year=str_replace('/','-',$this->request->data['PublishedCourse']['academic_year']);
								// $this->redirect(array('action' => 'index',
								// $this->request->data['PublishedCourse']['semester'],$academic_year));
							} else {
								$this->Session->setFlash(
									'<span></span>' . __('The course could not be published as drop coures. Please, try again.'),
									'default',
									array('class' => 'error-box error-message')
								);
							}
						} else {
							$this->Session->setFlash(
								'<span></span>' . __('Internal Error for publishing as drop.'),
								'default',
								array('class' => 'error-box error-message')
							);
						}
					}
				}
			}
			$this->request->data['PublishedCourse'] = $this->Session->read('search_data');

			$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
				'PublishedCourse.department_id' => $this->department_id,
				'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
				'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
				'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
				'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
				'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'],
				'PublishedCourse.published' => 1, 'PublishedCourse.drop' => 0
			)));

			$section_organized_published_courses = $this->PublishedCourse->getSectionofPublishedCourses(
				$this->request->data,
				$this->department_id,
				$publishedcourses
			);
			$this->set('turn_off_search', true);
			$this->set('show_unpublish_page', true);
			$this->set('publishedcourses', $section_organized_published_courses);
		}
		//unpublished coures
		if (!empty($this->request->data) && isset($this->request->data['unpublishselected'])) {

			$count = 0;
			$courses_ids = array();
			foreach ($this->request->data['Course']['pub'] as $section_id => $selected_courses) {
				foreach ($selected_courses as $course_id => $course_selected_flag) {
					if ($course_selected_flag == 1) {
						$count++;
						$courses_ids[$section_id][] = $course_id;
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to unpublished.'), 'default', array('class' => 'error-box error-message'));
			} else {


				$this->request->data['PublishedCourse'] = $this->Session->read('search_data');
				$publishedcourses = $this->PublishedCourse->find('all', array(
					'conditions' => array(
						'PublishedCourse.department_id' => $this->department_id,
						'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
						'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
						'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.published' => 1, 'PublishedCourse.course_id' => $courses_ids,
						'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year']
					),

					'contain' => array(

						'Course' => array(
							'Student' => array(
								'fields' => array(
									'Student.full_name',

								)
							)

						)
					)
				));
				$courses_not_allowed = array();
				$courses_allowed_to_unpublished = array();
				foreach ($publishedcourses as $pk => $pv) {

					if (count($pv['Course']['Student']) == 0) {
						$courses_allowed_to_unpublished[$pk]['id'] = $pv['PublishedCourse']['id'];
						$courses_allowed_to_unpublished[$pk]['course_id'] = $pv['PublishedCourse']['course_id'];
					} else {
						$courses_not_allowed[$pk] = $pv['PublishedCourse']['id'];
						$courses_not_allowed[$pk] = $pv['PublishedCourse']['course_id'];
					}
				}

				if (count($courses_not_allowed) > 0) {
					$this->Session->setFlash('<span></span>' . __('You can not unpublished the red marked courses , students has already registered for the courses. Please uncheck the red marked courses.'), 'default', array('class' => 'error-box error-message'));
					$this->set(compact('courses_not_allowed'));
				} else {

					// reformat courses_allowed to unpublished
					$save_reformat_unpublished_courses = array();
					foreach ($courses_allowed_to_unpublished as $pk => $pv) {
						//check
						$save_reformat_unpublished_courses['PublishedCourse'][$pk]['id'] = $pv['id'];
						$save_reformat_unpublished_courses['PublishedCourse'][$pk]['course_id'] = $pv['course_id'];
						$save_reformat_unpublished_courses['PublishedCourse'][$pk]['published'] = 0;
					}
					//save the unpublished courses
					if ($this->PublishedCourse->saveAll(
						$save_reformat_unpublished_courses['PublishedCourse'],
						array('validate' => 'first')
					)) {

						$this->Session->setFlash(
							'<span></span>' . __('The course has been unpublished.'),
							'default',
							array('class' => 'success-box success-message')
						);

						$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
						$this->redirect(array(
							'action' => 'index',
							$this->request->data['PublishedCourse']['semester'], $academic_year
						));
					} else {
						$this->Session->setFlash(
							'<span></span>' . __('The published course could not be saved. Please, try again.'),
							'default',
							array('class' => 'error-box error-message')
						);
					}
				}
			}
			$this->request->data['PublishedCourse'] = $this->Session->read('search_data');
			$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
				'PublishedCourse.department_id' => $this->department_id,
				'PublishedCourse.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
				'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
				'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
				'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id']
			)));

			$this->set('turn_off_search', true);
			$this->set('show_unpublish_page', true);
			$this->set('publishedcourses', $publishedcourses);
		}
		$yearLevels = $this->PublishedCourse->YearLevel->find(
			'list',
			array('conditions' => array('YearLevel.department_id' => $this->department_id))
		);
		$curriculums = $this->PublishedCourse->Course->Curriculum->find(
			'list',
			array('fields' => array('Curriculum.curriculum_detail'))
		);

		$programTypes = $this->PublishedCourse->ProgramType->find('list');
		$programs = $this->PublishedCourse->Program->find('list');
		if (!empty($this->request->data['PublishedCourse']['academic_year'])) {
			$academic_year = $this->request->data['PublishedCourse']['academic_year'];
			$this->set(compact('academic_year'));
		}
		$this->set(compact('yearLevels', 'programTypes', 'programs', 'departments'));
	}
	function delete($id = null)
	{
		// set default class and message for setFlash

		if (!$id) {
			$this->Session->setFlash(
				'<span></span>' . __('Invalid id for published course'),
				'default',
				array('class' => 'error-box error-message')
			);
			return $this->redirect(array('action' => 'index'));
		}
		$is_publish_belongs_to_department = $this->PublishedCourse->find(
			'count',
			array('conditions' => array('PublishedCourse.id' => $id, 'PublishedCourse.department_id' =>
			$this->department_id))
		);
		if ($is_publish_belongs_to_department > 0) {
			$delete_allowed = $this->PublishedCourse->canItBeDeleted($id);
			if ($delete_allowed) {
				if ($this->PublishedCourse->delete($id)) {
					$this->Session->setFlash(
						'<span></span>' . __('Published course deleted'),
						'default',
						array('class' => 'success-box success-message')
					);
					$this->render('selected_published_courses');
					//$this->redirect(array('action'=>'add'));
					//$this->render('selected_published_courses');
				}
			}
		} else {
			$this->Session->setFlash(
				'<span></span>' . __('You are not
		    elegible to delete this course.', true),
				'default',
				array('class' => 'error-box error-message')
			);
			$this->render('selected_published_courses');
			//$this->redirect(array('action'=>'index'));
		}

		$this->Session->setFlash(
			'<span></span>' . __('Published course was not deleted.'),
			'default',
			array('class' => 'error-box error-message')
		);
		$this->render('selected_published_courses');
		//$this->redirect(array('action' => 'add'));

	}
	/**
	 * Print to pdf
	 */
	function print_published_pdf()
	{
		$publishedCourses = $this->Session->read('publishedCourses');
		$selected_academic_year = $this->Session->read('selected_academic_year');

		$this->set(compact('publishedCourses', 'selected_academic_year'));
		$this->layout = 'pdf';
		$this->render();
	}
	/**
	 * export to xls
	 */
	function export_published_xls()
	{
		$publishedCourses = $this->Session->read('publishedCourses');
		$selected_academic_year = $this->Session->read('selected_academic_year');
		$this->set(compact('publishedCourses', 'selected_academic_year'));
	}

	function __init_search()
	{
		// We create a search_data session variable when we fill any criteria
		// in the search form.
		if (!empty($this->request->data['PublishedCourse'])) {

			$search_session = $this->request->data['PublishedCourse'];
			// Session variable 'search_data'
			$this->Session->write('search_data', $search_session);
		} else {

			$search_session = $this->Session->read('search_data');
			$this->request->data['PublishedCourse'] = $search_session;
		}
	}

	function __section_curriculum($sections = array(), $flag = null)
	{
		$array_list_sections = array();
		$section_array_list = array();
		$section_map_curriculum = array();

		foreach ($sections as $sk => $sv) {
			$array_list_sections = $this->PublishedCourse->Section->find(
				'all',
				array(
					'conditions' => array('Section.id' => $sk),
					'fields' => array('Section.id', 'Section.name'),
					'contain' => array(

						'Student' => array(
							'fields' => array(
								'Student.id',
								'Student.curriculum_id',
								'Student.full_name',
							),
							'Section',
							'Curriculum' => array(
								'fields' => array(
									'Curriculum.curriculum_detail'
								)
							)
						)

					)
				)
			);
			debug($array_list_sections);
			$curriculum_mapped = false;
			$found_curriculum = false;
			foreach ($array_list_sections as $as => $av) {

				if (count($av['Student']) > 0) {
					/*
		              if (isset($av['Student'][0]['Curriculum'])
		              && !empty($av['Student'][0]['Curriculum'])) {
		                    $section_array_list[$sk]='Section '.$sv.' attached to ('.
		                    $av['Student'][0]['Curriculum']['curriculum_detail'].') curriculum';
		              }
		             */
					foreach ($av['Student'] as $studentv) {
						if (
							isset($studentv['curriculum_id'])
							&& !empty($studentv['curriculum_id']) && !$curriculum_mapped
						) {
							$section_map_curriculum[$sk] = $studentv['curriculum_id'];

							$section_array_list[$sk] = 'Section ' . $sv . ' attached to (' . $studentv['Curriculum']['curriculum_detail'] . ') curriculum';

							$curriculum_mapped = true;
							break 1;
						}
					}
				}
			}
		}

		if ($flag) {
			return $section_array_list;
		} else {
			return $section_map_curriculum;
		}
	}

	function getPublishedCourses($data = null)
	{
		$this->layout = 'ajax';
		$selected_sections = array();
		$interesected = array();
		$is_list_of_course_execute = 0;
		/// give the user the list of courses which is already difsplayed
		// from the session when validation error occur.
		if ($this->Session->read('list_of_courses')) {

			if ($data == 2) {
				$is_list_of_course_execute = 1;
				$interesected = $this->Session->read('list_of_courses');
			} else {
				$this->Session->delete('list_of_courses');
			}
		}


		if (!empty($this->request->data['Section'])) {

			foreach ($this->request->data['Section']['selected'] as $key => $selected_section_id) {
				if ($selected_section_id != 0) {

					$is_list_of_course_execute = 1;
					$list_of_course = $this->PublishedCourse->find(
						'all',
						array(
							'conditions' => array(
								'PublishedCourse.program_id' => $this->request->data['MergedSectionsCourse']['program_id'], 'PublishedCourse.semester' => $this->request->data['MergedSectionsCourse']['semester'], 'PublishedCourse.program_type_id' => $this->request->data['MergedSectionsCourse']['program_type_id'], 'PublishedCourse.year_level_id' => $this->request->data['MergedSectionsCourse']['year_level_id'],
								'PublishedCourse.academic_year like' => $this->AcademicYear->current_academicyear() . '%',
								'PublishedCourse.section_id' => $selected_section_id
							), 'fields' => array('PublishedCourse.id', 'PublishedCourse.course_id'),
							'contain' => array('Course' => array('fields' => array(
								'Course.id', 'Course.course_code',
								'Course.course_title', 'Course.credit'
							)))
						)
					);
					if (empty($interesected)) {
						$interesected = $list_of_course;
						//$this->set(compact(''));
					} else {
						foreach ($list_of_course as $course) {

							foreach ($interesected as $read) {
								if ($read['Course']['id'] == $course['Course']['id']) {
									$selected_sections[] = $course;
								}
							}
						}
						$interesected = $selected_sections;
						$selected_sections = array();
					}
				}
			}
		}

		$list_of_courses = $interesected;
		if ($is_list_of_course_execute == 0) {
			$list_of_courses = null;
		}

		$this->Session->Write('list_of_courses', $list_of_courses);
	}
	/**
	 *Get list of candidate publish courses
	 */
	function selectedPublishedCourses($data = null)
	{

		$this->layout = 'ajax';

		$selected_section = array();
		$ready_for_publishing_courses = array();
		// incase all students fail or something happens
		$taken_courses_allow_to_publishe_it = array();

		$section_already_taken_courses = array();
		$selected_students_ids = array();
		$max_courses_taken_count = 0;
		$max_courses_taken_index_student = 0;
		/// give the user the list of courses which is already displayed
		// from the session when validation error occur.
		if ($this->Session->read('candidate_publish_courses')) {

			if ($data == 2) {
				$ready_for_publishing_courses = $this->Session->read('candidate_publish_courses');
				$taken_courses_allow_to_publishe_it = $this->Session->read('taken_courses_allow_to_publishe_it');
				$published_courses_disable_not_to_published = $this->Session->read('published_courses_disable_not_to_published');
				$selected_section = $this->Session->read('selected_section');
			} else {

				$this->Session->delete('candidate_publish_courses');
				$this->Session->delete('taken_courses_allow_to_publishe_it');
				$this->Session->delete('selected_section');
				$this->Session->delete('published_courses_disable_not_to_published');
			}
		}

		if (!empty($this->request->data['Section'])) {
			debug($this->request->data);
			$sections = $this->PublishedCourse->Section->find('list', array(
				'conditions' => array(
					'Section.department_id' => $this->department_id,
					'Section.year_level_id' => $this->request->data['PublishedCourse']['year_level_id'],
					'Section.archive' => 0
				)
			));

			foreach ($this->request->data['Section']['selected'] as $section_id => $selecte_flag) {
				if ($selecte_flag != 0) {
					$selected_section[$selecte_flag] = $sections[$selecte_flag];
				}
			}
			debug($selected_section);
			// curriculum of selected section
			$section_curriculum_attachment = $this->__section_curriculum($selected_section, false);

			$sections = $this->__section_curriculum($sections, true);

			//find the already taken courses of the section


			foreach ($this->request->data['Section']['selected'] as $sec_key => $sec_Id) {

				if ($sec_Id != 0) {


					//$courses=$this->PublishedCourse->Section->studentsSectionById($sec_Id);
					//  $list=$this->PublishedCourse->Section->studentsAlreaydTakenCourse($sec_Id);
					// debug($list);
					/*
			              $courses=$this->PublishedCourse->Section->studentsAlreaydTakenCourse($sec_Id);
						*/

					$taken_student = $this->PublishedCourse->Section->getMostRepresntiveTakenCourse($sec_Id);
					$section_already_taken_courses = $taken_student['taken'];
					debug($taken_student);

					$selected_students_ids = $taken_student['selected_student'];
				} //check selected

			}
			// if there is no courses taken by the section display the list of
			// courses attached to the curriculum.
			debug($section_already_taken_courses);

			//echo "Start Time ".date("D M j, Y-H:i:s",time());
			if (!empty($section_already_taken_courses)) {
				foreach ($section_already_taken_courses
					as $section_id => $taken_courses) {
					//due to talking to much time
					if (0 && !empty($taken_courses)) {
						$taken_equivalent_course_ids = array();
						if (isset($selected_students_ids[$section_id]) && !empty($selected_students_ids[$section_id])) {
							foreach ($taken_courses
								as $dd => $ddv) {
								if ($ddv != 0) {
									$tmp_course_ids = $this->PublishedCourse->Course->getTakenEquivalentCourses(
										$selected_students_ids[$section_id],
										$ddv
									);
									foreach ($tmp_course_ids
										as $tmp_ind => $tmp_value) {
										$taken_equivalent_course_ids[] = $tmp_value;
									}
								}
							}
						} else {
							$taken_equivalent_course_ids = $taken_courses;
						}
						if (!empty($taken_equivalent_course_ids)) {
							$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find('all', array(
								'conditions' => array(
									'Course.curriculum_id' =>
									$section_curriculum_attachment[$section_id],
									'Course.department_id' => $this->department_id,
									"NOT" => array('Course.id ' =>
									$taken_equivalent_course_ids)
								),
								'contain' => array(
									'PublishedCourse',
									'YearLevel' => array('id', 'name'),
									'Prerequisite' => array(
										'fields' => array(
											'id', 'prerequisite_course_id',
											'course_id', 'co_requisite'
										)
									)
								),
								'order' => array('Course.year_level_id', 'Course.semester')
							));
						} else {
							debug($section_curriculum_attachment[$section_id]);
							debug($this->department_id);
							$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find('all', array(
								'conditions' => array(
									'Course.curriculum_id' =>
									$section_curriculum_attachment[$section_id],
									'Course.department_id' => $this->department_id
								),
								'contain' => array(
									'PublishedCourse',
									'YearLevel' => array('id', 'name'),
									'Prerequisite' => array(
										'fields' => array(
											'id', 'prerequisite_course_id',
											'course_id', 'co_requisite'
										)
									)
								),
								'order' => array('Course.year_level_id', 'Course.semester')
							));
							debug($ready_for_publishing_courses);
						}

						// attach prerequiste code
						foreach ($ready_for_publishing_courses[$section_id] as $ll => &$rrvalue) {
							if (!empty($rrvalue['Prerequisite'])) {
								foreach ($rrvalue['Prerequisite'] as $pll => $pvv) {
									if ($pvv['co_requisite'] == 1) {

										$rrvalue['Prerequisite'][$pll]['pre_code'] = $this->PublishedCourse->Course->field(
											'course_code',
											array('id' => $pvv['prerequisite_course_id'])
										) . '- Co requiste';
									} else {

										$rrvalue['Prerequisite'][$pll]['pre_code'] = $this->PublishedCourse->Course->field(
											'course_code',
											array('id' => $pvv['prerequisite_course_id'])
										);
									}
								}
							}
						}


						$taken_courses_allow_to_publishe_it[$section_id] = $this->PublishedCourse->Course->find(
							'all',
							array(
								'conditions' => array(
									'Course.curriculum_id' =>
									$section_curriculum_attachment[$section_id],

									'Course.department_id' => $this->department_id,
									'Course.id ' => $taken_equivalent_course_ids
								),
								'contain' => array('PublishedCourse', 'YearLevel' => array('id', 'name'), 'Prerequisite')
							)
						);
					} else {

						$ready_for_publishing_courses[$section_id] = $this->PublishedCourse->Course->find(
							'all',
							array(
								'conditions' => array(
									'Course.curriculum_id' =>
									$section_curriculum_attachment[$section_id],
									//'Course.id '=>$taken_courses,
									'NOT' => array('Course.id' => $taken_courses),

									'Course.department_id' => $this->department_id
								),
								'contain' => array(
									'PublishedCourse', 'YearLevel' => array('id', 'name'), 'Prerequisite'
								)
							)
						);
						debug($ready_for_publishing_courses);
						debug($taken_courses);
					}
				}
				// echo "End Time".date("D M j, Y-H:i:s",time());


			} else {
				// section has not already taken coures.

				if (!empty($this->request->data['Section']['selected'])) {
					foreach ($this->request->data['Section']['selected'] as $sec_key => $sec_Id) {
						// only for the selected sections
						if ($sec_Id != 0) {
							$ready_for_publishing_courses[$sec_Id] = $this->PublishedCourse->Course->find(
								'all',
								array(
									'conditions' => array(
										'Course.curriculum_id' =>
										$section_curriculum_attachment[$sec_Id],

										'Course.department_id' => $this->department_id
									),
									'contain' => array(
										'PublishedCourse', 'YearLevel' => array('id', 'name'), 'Prerequisite' => array(
											'fields' => array('id', 'prerequisite_course_id', 'course_id', 'co_requisite')
										)
									)
								)
							);

							/////////////////////////////////////////fixes///////////////////////
							debug($ready_for_publishing_courses[$sec_Id]);
							foreach ($ready_for_publishing_courses[$sec_Id] as $ll => &$rrvalue) {
								if (!empty($rrvalue['Prerequisite'])) {
									foreach ($rrvalue['Prerequisite'] as $pll => $pvv) {
										if ($pvv['co_requisite'] == 1) {

											$rrvalue['Prerequisite'][$pll]['pre_code'] = $this->PublishedCourse->Course->field(
												'course_code',
												array('id' => $pvv['prerequisite_course_id'])
											) . '- Co requiste';
										} else {

											$rrvalue['Prerequisite'][$pll]['pre_code'] = $this->PublishedCourse->Course->field(
												'course_code',
												array('id' => $pvv['prerequisite_course_id'])
											);
										}
									}
								}
							}

							/////////////////////////////////////////////////////////
						}
					}
				}
			}
			$published_courses_disable_not_to_published = $this->PublishedCourse->find(
				'all',
				array(
					'conditions' => array(
						'PublishedCourse.year_level_id' =>
						$this->request->data['PublishedCourse']['year_level_id'],
						'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',

						'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.drop' => 0,
						'PublishedCourse.program_id' =>
						$this->request->data['PublishedCourse']['program_id'],
						'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.section_id' => $this->request->data['Section']['selected']
					),
					'fields' => array('id', 'course_id', 'section_id'), 'contain' => array()
				)
			);
			$this->set('turn_off_search', true);
			$this->set(compact('sections'));
		} else {
		}

		$tmp = array();
		//debug($published_courses_disable_not_to_published);
		foreach ($published_courses_disable_not_to_published as $keey => $pcdv) {
			if (isset($pcdv['PublishedCourse']['section_id'])) {
				$tmp[$pcdv['PublishedCourse']['section_id']][$pcdv['PublishedCourse']['id']] =
					$pcdv['PublishedCourse']['course_id'];
			}
		}

		$published_courses_disable_not_to_published = $tmp;

		debug($ready_for_publishing_courses);
		//published courses detail for a selected category
		$this->Session->Write('candidate_publish_courses', $ready_for_publishing_courses);
		$this->Session->Write('taken_courses_allow_to_publishe_it', $taken_courses_allow_to_publishe_it);
		$this->Session->Write('selected_section', $selected_section);
		$this->Session->Write(
			'published_courses_disable_not_to_published',
			$published_courses_disable_not_to_published
		);
		$departments = $this->PublishedCourse->Department->find('list', array('conditions' =>
		array('Department.college_id' => $this->college_id)));
		$defaultDepartment = $this->department_id;
		$defaultCollege = $this->college_id;
		$colleges = $this->PublishedCourse->College->find('list');

		$this->set(compact('colleges', 'departments', 'defaultDepartment', 'defaultCollege'));
	}

	function publisheForUnassigned($data = null)
	{
		$this->layout = 'ajax';

		$selected_section = array();
		$ready_for_publishing_courses = array();

		if ($this->Session->read('candidate_publish_courses')) {

			if ($data == 2) {
				$ready_for_publishing_courses = $this->Session->read('candidate_publish_courses');

				$published_courses_disable_not_to_published = $this->Session->read('published_courses_disable_not_to_published');
				$selected_section = $this->Session->read('selected_section');
			} else {

				$this->Session->delete('candidate_publish_courses');
				$this->Session->delete('selected_section');
				$this->Session->delete('published_courses_disable_not_to_published');
			}
		}

		if (!empty($this->request->data['Section'])) {
			$sections = $this->PublishedCourse->Section->find('list', array('conditions' => array('Section.college_id' => $this->college_id, 'OR' => array('Section.department_id is null', 'Section.department_id' => array(0, '')), 'Section.academicyear like ' => $this->request->data['PublishedCourse']['academic_year'] . '%')));

			foreach ($this->request->data['Section']['selected'] as $section_id => $selecte_flag) {
				if ($selecte_flag != 0) {
					$selected_section[$selecte_flag] = $sections[$selecte_flag];
				}
			}

			// section has not already taken coures.
			if (!empty($this->request->data['Section']['selected'])) {
				foreach ($this->request->data['Section']['selected'] as $sec_key => $sec_Id) {
					// only for the selected sections
					if ($sec_Id != 0) {
						$ready_for_publishing_courses[$sec_Id] = $this->PublishedCourse->Course->find(
							'all',
							array(
								'conditions' => array('Course.curriculum_id' => $this->request->data['PublishedCourse']['curriculum_id'], 'Course.semester' => $this->request->data['PublishedCourse']['semester'], 'Course.department_id' => $this->request->data['PublishedCourse']['department_id']),
								'order' => 'year_level_id',
								'contain' => array(
									'PublishedCourse'
								),
								'limit' => 7
							)
						);
					}
				}
			}

			$published_courses_disable_not_to_published = $this->PublishedCourse->find(
				'all',
				array(
					'conditions' => array(
						'PublishedCourse.college_id' => $this->college_id,
						'OR' => array(
							'PublishedCourse.department_id is null',
							'PublishedCourse.department_id' => array('', 0)
						),
						'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
						'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
						'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.section_id' => $this->request->data['Section']['selected']
					),

					'fields' => array('id', 'course_id', 'section_id'), 'contain' => array()
				)
			);

			$this->set(compact('sections', 'selected_sections'));
		}
		$tmp = array();

		foreach ($published_courses_disable_not_to_published as $keey => $pcdv) {
			$tmp[$pcdv['PublishedCourse']['section_id']][$pcdv['PublishedCourse']['id']] = $pcdv['PublishedCourse']['course_id'];
		}

		$published_courses_disable_not_to_published = $tmp;
		$this->Session->Write('published_courses_disable_not_to_published', $published_courses_disable_not_to_published);

		$this->Session->Write('candidate_publish_courses', $ready_for_publishing_courses);
		$this->Session->Write('selected_section', $selected_section);
	}

	function getPublishedCoursesForSplit($data = null)
	{

		$this->layout = 'ajax';
		if ($this->Session->read('list_of_courses') && $data == 2) {
			$is_list_of_course_execute = 1;
			$list_of_courses = $this->Session->read('list_of_courses');
			$course_type_array = $this->Session->read('course_type_array');
		} else {
			$this->Session->delete('list_of_courses');
			$this->Session->delete('course_type_array');
			$list_of_courses = null;
			$course_type_array = array();
			if (!empty($this->request->data['Section']) and $this->request->data['SectionSplitForPublishedCourse']['selectedsection'] >= 0) {
				$selected_section_id = $this->request->data['Section'][$this->request->data['SectionSplitForPublishedCourse']['selectedsection']]['id'];
				$list_of_courses = $this->PublishedCourse->find('all', array(
					'conditions' => array(
						'PublishedCourse.program_id' =>
						$this->request->data['SectionSplitForPublishedCourse']['program_id'], 'PublishedCourse.semester' =>
						$this->request->data['SectionSplitForPublishedCourse']['semester'], 'PublishedCourse.program_type_id' =>
						$this->request->data['SectionSplitForPublishedCourse']['program_type_id'], 'PublishedCourse.year_level_id' =>
						$this->request->data['SectionSplitForPublishedCourse']['year_level_id'], 'PublishedCourse.academic_year'
						=> $this->request->data['SectionSplitForPublishedCourse']['academicyear'],
						'PublishedCourse.section_id' => $selected_section_id
					),
					'fields' => array('PublishedCourse.id', 'PublishedCourse.course_id'),
					'contain' => array('Course' => array('fields' => array(
						'Course.id', 'Course.course_code', 'Course.course_title',
						'Course.credit', 'Course.lecture_hours', 'Course.tutorial_hours', 'Course.laboratory_hours'
					)))
				));
				//debug($list_of_courses);
				//$course_type_array = array();
				foreach ($list_of_courses as $lck => &$lcv) {
					$course_type_array[$lck][-1] = "---Selecte Course Type---";
					$course_type_array[$lck]["Lecture"] = "Lecture";
					if ($lcv['Course']['tutorial_hours'] > 0) {
						$course_type_array[$lck]["Tutorial"] = "Tutorial";
						$course_type_array[$lck]["Lecture+Tutorial"] = "Lecture+Tutorial";
					} else if ($lcv['Course']['laboratory_hours'] > 0) {
						$course_type_array[$lck]["Lab"] = "Lab";
						$course_type_array[$lck]["Lecture+Lab"] = "Lecture+Lab";
					}
					$lcv['GradeSubmitted'] = $this->PublishedCourse->CourseRegistration->ExamResult->isExamResultSubmitted(
						$lcv['PublishedCourse']['id']
					);
				}

				$this->Session->write('list_of_courses', $list_of_courses);
				$this->Session->write('course_type_array', $course_type_array);
			}
		}
		$this->set(compact('list_of_courses', 'course_type_array'));
	}

	function getPublishedCoursesForExam($data = null)
	{
		$this->layout = 'ajax';
		//$selected_sections=array();
		$list_of_courses = array();
		$is_list_of_course_execute = 0;
		/// give the user the list of courses which is already displayed
		// from the session when validation error occur.
		if ($this->Session->read('list_of_courses')) {

			if ($data == 2) {
				$is_list_of_course_execute = 1;
				$list_of_courses = $this->Session->read('list_of_courses');
			} else {
				$this->Session->delete('list_of_courses');
			}
		}

		if (!empty($this->request->data['Section'])) {
			$selction_array = array();
			foreach ($this->request->data['Section']['selected'] as $key => $selected_section_id) {
				if ($selected_section_id != 0) {
					$selction_array[$selected_section_id] = $selected_section_id;
				}
			}
			if (count($selction_array) > 0) {

				$is_list_of_course_execute = 1;
				$list_of_courses = $this->PublishedCourse->find(
					'all',
					array(
						'conditions' => array(
							'PublishedCourse.program_id' => $this->request->data['MergedSectionsExam']['program_id'], 'PublishedCourse.semester' => $this->request->data['MergedSectionsExam']['semester'],
							'PublishedCourse.program_type_id' => $this->request->data['MergedSectionsExam']['program_type_id'],
							'PublishedCourse.academic_year' => $this->AcademicYear->current_academicyear(),
							'PublishedCourse.section_id' => $selction_array,
							'PublishedCourse.id NOT IN( select published_course_id from merged_sections_exams)',
							'PublishedCourse.id NOT IN( select published_course_id from excluded_published_course_exams)'
						),
						'fields' => array('PublishedCourse.id', 'PublishedCourse.course_id'),
						'contain' => array('Course' => array('fields' => array(
							'Course.id', 'Course.course_code',
							'Course.course_title', 'Course.credit'
						)), 'Section' => array('fields' => array('Section.name')))
					)
				);
			}
		}

		if ($is_list_of_course_execute == 0) {
			$list_of_courses = null;
		}
		$this->Session->Write('list_of_courses', $list_of_courses);
	}
	function getPublishedCoursesForExamForSplit($data = null)
	{
		//debug($this->request->data);
		$this->layout = 'ajax';
		if ($this->Session->read('list_of_courses') and $data == 2) {
			$is_list_of_course_execute = 1;
			$list_of_courses = $this->Session->read('list_of_courses');
			//$course_type_array = $this->Session->read('course_type_array');

		} else {
			$this->Session->delete('list_of_courses');
			//$this->Session->delete('course_type_array');
			$list_of_courses = null;
			$course_type_array = array();
			if (!empty($this->request->data['Section']) and $this->request->data['SectionSplitForExam']['selectedsection'] >= 0) {
				$selected_section_id = $this->request->data['Section'][$this->request->data['SectionSplitForExam']['selectedsection']]['id'];
				$list_of_courses = $this->PublishedCourse->find('all', array(
					'conditions' => array(
						'PublishedCourse.program_id' =>
						$this->request->data['SectionSplitForExam']['program_id'], 'PublishedCourse.semester' =>
						$this->request->data['SectionSplitForExam']['semester'], 'PublishedCourse.program_type_id' =>
						$this->request->data['SectionSplitForExam']['program_type_id'], 'PublishedCourse.academic_year like' =>
						$this->AcademicYear->current_academicyear() . '%', 'PublishedCourse.section_id' => $selected_section_id,
						'PublishedCourse.id NOT IN( select published_course_id from section_split_for_exams)',
						'PublishedCourse.id NOT IN( select published_course_id from excluded_published_course_exams)'
					),
					'fields' => array('PublishedCourse.id', 'PublishedCourse.course_id'),
					'contain' => array('Course' => array('fields' => array(
						'Course.id', 'Course.course_code', 'Course.course_title',
						'Course.credit', 'Course.lecture_hours', 'Course.tutorial_hours', 'Course.laboratory_hours'
					)))
				));
				//debug($list_of_courses);
				/*$course_type_array = array();
				foreach($list_of_courses as $lck=>$lcv) {
					$course_type_array[$lck][-1] = "---Selecte Course Type---";
					$course_type_array[$lck]["Lecture"] = "Lecture";
					if($lcv['Course']['tutorial_hours'] >0){
						$course_type_array[$lck]["tutorial"] = "Tutorial";
						$course_type_array[$lck]["Lecture+Tutorial"] = "Lecture + Tutorial";
					} else if($lcv['Course']['laboratory_hours'] >0){
						$course_type_array[$lck]["Lab"] = "Lab";
						$course_type_array[$lck]["Lecture+Lab"] = "Lecture + Lab";
					}
				} */
				$this->Session->write('list_of_courses', $list_of_courses);
				//$this->Session->write('course_type_array',$course_type_array);
			}
		}
		$this->set(compact('list_of_courses'));
	}
	public function add_course_session()
	{
		$programs = $this->PublishedCourse->Program->find('list');
		$programTypes = $this->PublishedCourse->ProgramType->find('list');
		$departments = $this->PublishedCourse->Department->find('list', array('conditions' =>
		array('Department.college_id' => $this->college_id)));
		$yearLevels = null;
		$yearLevels = $this->PublishedCourse->YearLevel->find('list', array('conditions' =>
		array('YearLevel.department_id' => $this->department_id)));
		$this->set(compact('programs', 'programTypes', 'departments', 'yearLevels'));

		if (!empty($this->request->data) && isset($this->request->data['search'])) {
			if ($this->Session->read('sections_array')) {
				$this->Session->delete('sections_array');
			}
			//debug($this->request->data);
			$everythingfine = false;
			switch ($this->request->data) {
				case empty($this->request->data['PublishedCourse']['academicyear']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year of the publish courses
					that you want to define courses number of session.', true), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['program_id']):
					$this->Session->setFlash('<span></span> ' . __('Please select the program of the publish courses
					that you want to define courses number of session. ', true), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['program_type_id']):
					$this->Session->setFlash('<span></span> ' . __('Please select the program type of the publish courses
					that you want to define courses number of session. ', true), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['semester']):
					$this->Session->setFlash('<span></span> ' . __('Please select the semester of the publish courses
					that you want to define courses number of session. ', true), 'default', array('class' => 'error-box error-message'));
					break;
				default:
					$everythingfine = true;
			}
			if ($everythingfine) {
				$selected_academicyear = $this->request->data['PublishedCourse']['academicyear'];
				$this->Session->write('selected_academicyear', $selected_academicyear);
				$selected_program = $this->request->data['PublishedCourse']['program_id'];
				$this->Session->write('selected_program', $selected_program);
				$selected_program_type = $this->request->data['PublishedCourse']['program_type_id'];
				$this->Session->write('selected_program_type', $selected_program_type);
				$selected_semester = $this->request->data['PublishedCourse']['semester'];
				$this->Session->write('selected_semester', $selected_semester);
				//$program_type_id=$this->AcademicYear->equivalent_program_type($selected_program_type);

				if ($this->role_id == ROLE_COLLEGE) {
					if (empty($this->request->data['PublishedCourse']['department_id'])) {
						$conditions = array(
							'PublishedCourse.academic_year' => $selected_academicyear,
							'PublishedCourse.college_id' => $this->college_id, 'PublishedCourse.program_id' => $selected_program,
							'PublishedCourse.program_type_id' => $selected_program_type, 'PublishedCourse.semester' => $selected_semester, 'PublishedCourse.drop' => 0, "OR" => array("PublishedCourse.department_id is null", "PublishedCourse.department_id" => array(0, ''))
						);
					} else {
						$selected_year_level = $this->request->data['PublishedCourse']['year_level_id'];
						$this->Session->write('selected_year_level', $selected_year_level);
						if (empty($selected_year_level) || ($selected_year_level == "All")) {
							$selected_year_level = '%';
						}
						$selected_department = $this->request->data['PublishedCourse']['department_id'];
						$this->Session->write('selected_department', $selected_department);
						$yearLevels = $this->PublishedCourse->YearLevel->find('list', array(
							'conditions' => array('YearLevel.department_id' => $selected_department)
						));
						$conditions = array(
							'PublishedCourse.academic_year' => $selected_academicyear,
							'PublishedCourse.department_id' => $selected_department, 'PublishedCourse.program_id' =>
							$selected_program, 'PublishedCourse.program_type_id' => $selected_program_type,
							'PublishedCourse.year_level_id LIKE' => $selected_year_level, 'PublishedCourse.semester' => $selected_semester, 'PublishedCourse.drop' => 0
						);
					}
				} else {
					$selected_year_level = $this->request->data['PublishedCourse']['year_level_id'];
					$this->Session->write('selected_year_level', $selected_year_level);
					if (empty($selected_year_level) || ($selected_year_level == "All")) {
						$selected_year_level = '%';
					}
					$selected_department = $this->department_id;
					$this->Session->write('selected_department', $selected_department);
					$yearLevels = $this->PublishedCourse->YearLevel->find('list', array(
						'conditions' => array('YearLevel.department_id' => $selected_department)
					));
					$conditions = array(
						'PublishedCourse.academic_year' => $selected_academicyear,
						'PublishedCourse.department_id' => $selected_department, 'PublishedCourse.program_id' =>
						$selected_program, 'PublishedCourse.program_type_id' => $selected_program_type,
						'PublishedCourse.year_level_id LIKE' => $selected_year_level, 'PublishedCourse.semester' => $selected_semester, 'PublishedCourse.drop' => 0
					);
				}
				$publishedcourses = $this->PublishedCourse->find('all', array(
					'conditions' => $conditions, 'fields' => array('PublishedCourse.id', 'PublishedCourse.section_id'),
					'contain' => array('Section' => array('fields' => array('Section.id', 'Section.name')), 'Course' => array(
						'fields' => array(
							'Course.id', 'Course.course_title', 'Course.course_code', 'Course.credit',
							'Course.lecture_hours', 'Course.tutorial_hours', 'Course.laboratory_hours'
						)
					))
				));
				//debug($publishedcourses);
				$sections_array = array();
				foreach ($publishedcourses as $key => $publishedcourse) {
					$sections_array[$publishedcourse['Section']['name']][$key]['course_title'] = $publishedcourse['Course']['course_title'];
					$sections_array[$publishedcourse['Section']['name']][$key]['course_id'] = $publishedcourse['Course']['id'];
					$sections_array[$publishedcourse['Section']['name']][$key]['course_code'] = $publishedcourse['Course']['course_code'];
					$sections_array[$publishedcourse['Section']['name']][$key]['credit'] = $publishedcourse['Course']['credit'];
					$sections_array[$publishedcourse['Section']['name']][$key]['credit_detail'] = $publishedcourse['Course']['lecture_hours'] . ' ' . $publishedcourse['Course']['tutorial_hours'] . ' ' .
						$publishedcourse['Course']['laboratory_hours'];
					$sections_array[$publishedcourse['Section']['name']][$key]['section_id'] =
						$publishedcourse['PublishedCourse']['section_id'];
					$sections_array[$publishedcourse['Section']['name']][$key]['published_course_id'] =
						$publishedcourse['PublishedCourse']['id'];
				}
				//debug($sections_array);
				if (empty($sections_array)) {
					$this->Session->setFlash('<span></span> ' . __('There is no published courses to define
					 number of session the selected criteria.', true), 'default', array('class' => 'info-box info-message'));
				} else {
					$this->Session->write('sections_array', $sections_array);
					$this->Session->write('yearLevels', $yearLevels);
					$this->set(compact('sections_array', 'yearLevels'));
				}
			}
		}
		if (!empty($this->request->data) && isset($this->request->data['submit'])) {
			//debug($this->request->data);
			if (!empty($this->request->data['PublishedCourse']['courses'])) {
				$PublishedCourse_update_array = array();
				$PublishedCourse_update_array['PublishedCourse']['id'] = $this->request->data['PublishedCourse']['courses'];
				if (isset($this->request->data['lecture_number_of_session'])) {
					$PublishedCourse_update_array['PublishedCourse']['lecture_number_of_session'] =
						$this->request->data['lecture_number_of_session'];
				}
				if (isset($this->request->data['tutorial_number_of_session'])) {
					$PublishedCourse_update_array['PublishedCourse']['tutorial_number_of_session'] =
						$this->request->data['tutorial_number_of_session'];
				}
				if (isset($this->request->data['lab_number_of_session'])) {
					$PublishedCourse_update_array['PublishedCourse']['lab_number_of_session'] =
						$this->request->data['lab_number_of_session'];
				}
				$this->PublishedCourse->save($PublishedCourse_update_array);
				$this->Session->setFlash(
					'<span></span> ' . __('Course number of sessions has been updated.'),
					'default',
					array('class' => 'success-box success-message')
				);
			} else {
				$this->Session->setFlash('<span></span> ' . __('Please select course.'), 'default', array(
					'class' => 'error-box error-message'
				));
			}
			$sections_array = $this->Session->read('sections_array');
			$yearLevels = $this->Session->read('yearLevels');
			$this->set(compact('sections_array', 'yearLevels'));
		}
		//debug($this->request->data);
		if (isset($this->request->data['PublishedCourse']) && !empty($this->request->data['PublishedCourse'])) {
			$selected_academicyear = $this->request->data['PublishedCourse']['academicyear'];
			$selected_program = $this->request->data['PublishedCourse']['program_id'];
			$selected_program_type = $this->request->data['PublishedCourse']['program_type_id'];
			$selected_semester = $this->request->data['PublishedCourse']['semester'];
			$selected_year_level = $this->request->data['PublishedCourse']['year_level_id'];
		}

		if ($this->Session->read('yearLevels')) {
			$yearLevels = $this->Session->read('yearLevels');
		}

		if ($this->role_id == ROLE_COLLEGE) {
			if (!empty($this->request->data['PublishedCourse']['department_id'])) {
				$selected_department = $this->request->data['PublishedCourse']['department_id'];
				$this->Session->write('selected_department', $selected_department);
			}
			if (empty($this->request->data['PublishedCourse']['department_id']) && !empty($selected_academicyear) && !empty($selected_program)) {
				$conditions = array(
					'PublishedCourse.academic_year' => $selected_academicyear,
					'PublishedCourse.college_id' => $this->college_id, 'PublishedCourse.program_id' => $selected_program,
					'PublishedCourse.program_type_id' => $selected_program_type, 'PublishedCourse.semester' =>
					$selected_semester, "OR" => array(
						"PublishedCourse.department_id is null",
						"PublishedCourse.department_id" => array(0, '')
					)
				);
			} else {
				if (!empty($this->request->data['PublishedCourse']['year_level_id'])) {
					$selected_year_level = $this->request->data['PublishedCourse']['year_level_id'];
					$this->Session->write('selected_year_level', $selected_year_level);
				}
				if (empty($selected_year_level) || ($selected_year_level == "All")) {
					$selected_year_level = '%';
				}
				if (!empty($selected_department)) {
					$yearLevels = $this->PublishedCourse->YearLevel->find('list', array(
						'conditions' => array('YearLevel.department_id' => $selected_department)
					));
					$conditions = array(
						'PublishedCourse.academic_year' => $selected_academicyear,
						'PublishedCourse.department_id' => $selected_department, 'PublishedCourse.program_id' =>
						$selected_program, 'PublishedCourse.program_type_id' => $selected_program_type,
						'PublishedCourse.year_level_id LIKE' => $selected_year_level, 'PublishedCourse.semester' => $selected_semester, 'PublishedCourse.drop' => 0
					);
				}
			}
		} else {
			$selected_year_level = $this->request->data['PublishedCourse']['year_level_id'];
			$this->Session->write('selected_year_level', $selected_year_level);
			if (empty($selected_year_level) || ($selected_year_level == "All")) {
				$selected_year_level = '%';
			}
			$selected_department = $this->department_id;
			$this->Session->write('selected_department', $selected_department);
			$yearLevels = $this->PublishedCourse->YearLevel->find('list', array(
				'conditions' => array('YearLevel.department_id' => $selected_department)
			));
			$conditions = array(
				'PublishedCourse.academic_year' => $selected_academicyear,
				'PublishedCourse.department_id' => $selected_department, 'PublishedCourse.program_id' =>
				$selected_program, 'PublishedCourse.program_type_id' => $selected_program_type,
				'PublishedCourse.year_level_id LIKE' => $selected_year_level, 'PublishedCourse.semester' => $selected_semester, 'PublishedCourse.drop' => 0
			);
		}
		if (!empty($conditions)) {
			$PublishedCorseHistory = $this->PublishedCourse->find('all', array(
				'conditions' => $conditions, 'fields' => array(
					'PublishedCourse.id', 'PublishedCourse.section_id',
					'PublishedCourse.lecture_number_of_session', 'PublishedCourse.tutorial_number_of_session',
					'PublishedCourse.lab_number_of_session'
				),
				'contain' => array('Section' => array('fields' => array('Section.id', 'Section.name')), 'Course' => array(
					'fields' => array(
						'Course.id', 'Course.course_title', 'Course.course_code', 'Course.credit',
						'Course.lecture_hours', 'Course.tutorial_hours', 'Course.laboratory_hours'
					)
				))
			));
		}
		$PublishedCorseHistory_formatted_array = array();
		if (isset($PublishedCorseHistory) && !empty($PublishedCorseHistory)) {
			foreach ($PublishedCorseHistory as $key => $publishedcourse) {
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['course_title'] =
					$publishedcourse['Course']['course_title'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['course_id'] =
					$publishedcourse['Course']['id'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['course_code'] =
					$publishedcourse['Course']['course_code'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['credit'] =
					$publishedcourse['Course']['credit'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['credit_detail'] =
					$publishedcourse['Course']['lecture_hours'] . ' ' . $publishedcourse['Course']['tutorial_hours'] . ' ' .
					$publishedcourse['Course']['laboratory_hours'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['section_id'] =
					$publishedcourse['PublishedCourse']['section_id'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['published_course_id'] =
					$publishedcourse['PublishedCourse']['id'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['lecture_number_of_session'] =
					$publishedcourse['PublishedCourse']['lecture_number_of_session'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['tutorial_number_of_session'] =
					$publishedcourse['PublishedCourse']['tutorial_number_of_session'];
				$PublishedCorseHistory_formatted_array[$publishedcourse['Section']['name']][$key]['lab_number_of_session'] =
					$publishedcourse['PublishedCourse']['lab_number_of_session'];
			}
		}
		//debug($PublishedCorseHistory_formatted_array);

		$this->set(compact(
			'selected_academicyear',
			'selected_program',
			'selected_program_type',
			'selected_semester',
			'selected_year_level',
			'selected_department',
			'yearLevels',
			'PublishedCorseHistory_formatted_array'
		));
	}
	function get_year_level($department_id = null)
	{
		if (!empty($department_id)) {
			$this->layout = 'ajax';
			//debug($this->request->data);
			$yearLevels = $this->PublishedCourse->YearLevel->find('list', array('conditions' =>
			array('YearLevel.department_id' => $department_id)));
			$this->set(compact('yearLevels'));
		}
	}
	function get_course_type_session($publishedCourse_id = null)
	{
		if (!empty($publishedCourse_id)) {
			$publishedcourse_data = $this->PublishedCourse->find('all', array(
				'conditions' => array('PublishedCourse.id' => $publishedCourse_id), 'fields' => array(
					'PublishedCourse.id'
				), 'contain' => array('Course' => array('fields' => array(
					'Course.id',
					'Course.course_title', 'Course.course_code', 'Course.credit', 'Course.lecture_hours',
					'Course.tutorial_hours', 'Course.laboratory_hours'
				)))
			));
			//$publishedcourse_data[0]['Course']
			$this->set(compact('publishedcourse_data'));
		}
	}
	function attache_scale()
	{

		if (!empty($this->request->data) && isset($this->request->data['attachescaletocourse'])) {

			$data['PublishedCourse'] = $this->request->data['Published'];



			if (empty($data['PublishedCourse'])) {
				$this->Session->setFlash('<span></span>' . __('No course has been attached to any scale.'), 'default', array('class' => 'info-box info-message'));
			} else {

				if ($this->PublishedCourse->saveAll(
					$data['PublishedCourse'],
					array('validate' => 'first')
				)) {
					$this->Session->setFlash(
						'<span></span>' . __('The grade scale has been saved'),
						'default',
						array('class' => 'success-message success-box')
					);
					//$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<span></span>' . __('The grade scale could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
				}
			}


			$this->request->data['getPublishedCourseList'] = true;
		}
		if (!empty($this->request->data) && isset($this->request->data['getPublishedCourseList'])) {

			$everythingfine = false;

			switch ($this->request->data) {

				case empty($this->request->data['PublishedCourse']['academic_year']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to attach scale.'), 'default', array('class' => 'error-box error-message'));
					break;

				case empty($this->request->data['PublishedCourse']['semester']):
					$this->Session->setFlash('<span></span>' . __('Please select the semester you want to attache scale.'), 'default', array('class' => 'error-box error-message'));
					break;

				case empty($this->request->data['PublishedCourse']['program_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the program you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['year_level_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the year level  you want  attache scale.'), 'default', array('class' => 'error-box error-message'));
					break;

				default:
					$everythingfine = true;
			}

			if ($everythingfine) {

				$publishedCourses = $this->PublishedCourse->find('all', array(
					'fields' => array(
						'id',
						'section_id', 'grade_scale_id', 'year_level_id'
					), 'conditions' =>
					array(
						'PublishedCourse.semester ' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
						'PublishedCourse.drop' => 0,
						'PublishedCourse.given_by_department_id' => $this->department_id,
						//  'PublishedCourse.year_level_id'=>$this->request->data['PublishedCourse']['year_level_id'],
						'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id']
					),
					'contain' => array(
						'Course' => array('fields' => array(
							'id', 'course_title', 'credit',
							'course_code', 'grade_type_id'
						)),
						'Section' => array(
							'fields' => array('id', 'name'),
							'conditions' => array('Section.archive <> ' => 1),
							'ProgramType' => array('fields' => array('id', 'name')),
							'YearLevel' => array('fields' => array('id', 'name')),
							'Department' => array('fields' => array('id', 'name')),
							'College' => array('fields' => array('id', 'name')),

						)
					)
				));



				if (!empty($publishedCourses)) {

					$gradeScales = $this->PublishedCourse->GradeScale->find(
						'all',
						array(
							'conditions' => array(
								'GradeScale.model' => 'Department',
								'GradeScale.foreign_key' => $this->department_id,
								'GradeScale.active' => 1,
								'GradeScale.program_id' => $this->request->data['PublishedCourse']['program_id']
							),
							'fields' => array('id', 'name'),
							'contain' => array(
								'GradeScaleDetail' => array(
									'Grade' => array(
										'fields' => array('id', 'grade'),
										'GradeType' => array('id', 'type')
									)
								),
								'Program' => array('id', 'name')

							)
						)
					);

					$college_id = $this->PublishedCourse->Department->field(
						'college_id',
						array('Department.id' => $this->department_id)
					);

					$find_delegation_program_ids = $this->PublishedCourse->College->find(
						'first',
						array(
							'conditions' => array('College.id' => $college_id),
							'fields' => array('deligate_for_graduate_study', 'deligate_scale')
						)
					);

					if (empty($gradeScales)) {

						if (
							$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 1 &&
							$this->request->data['PublishedCourse']['program_id'] == PROGRAM_POST_GRADUATE
						) {
							$this->Session->setFlash('<span></span>' . __('There is no grade scale in the system that are defined, please define scale before attaching grade scale to published courses.'), 'default', array('class' => 'error-box error-message'));
							$this->redirect(array('controller' => 'gradeScales', 'action' => 'add'));
						} else if (
							$find_delegation_program_ids['College']['deligate_scale'] == 1
							&& PROGRAM_UNDEGRADUATE == $this->request->data['PublishedCourse']['program_id']
						) {
							$this->Session->setFlash('<span></span>' . __('There is no grade scale in the system that are defined, please define scale before attaching grade scale to published courses.'), 'default', array('class' => 'error-box error-message'));
							$this->redirect(array('controller' => 'gradeScales', 'action' => 'set_grade_scale'));
						} else {
							$this->Session->setFlash('<span></span>' . __('You dont have mandate to attach
			              grade scale to published courses,
			              grade scale defined by the college will be applicable to
			              the published courses, if this is not right please contact college to delegate scale to department.', true), 'default', array('class' => 'error-box error-message'));
						}
					}

					$return = array();
					foreach ($gradeScales as $kk => $vv) {

						if (!empty($vv['GradeScaleDetail'][0]['Grade']['GradeType']['type'])) {
							$return[$vv['GradeScaleDetail'][0]['Grade']['GradeType']['id']][$vv['GradeScale']['name'] . '-'
								. $vv['GradeScaleDetail'][0]['Grade']['GradeType']['type'] . '-' .
								$vv['Program']['name']][$vv['GradeScale']['id']] = $vv['GradeScale']['name'];
						}
					}
					$gradeScales = $return;



					$section_organized_published_courses = $this->PublishedCourse->get_section_organized_published_courses($this->request->data, $this->department_id, $publishedCourses);

					$section_organized_published_courses = $this->PublishedCourse->getSectionOrganizedPublishedCoursesM($publishedCourses);

					if (empty($section_organized_published_courses)) {
						$this->Session->setFlash('<span></span>' . __('There is no published courses in the given criteria that needs scale attachment.'), 'default', array('class' => 'error-box error-message'));
					}
					$this->set(compact('section_organized_published_courses', 'gradeScales'));
				} else {
					$this->Session->setFlash('<span></span>' .
						__('There is no published courses in the given criteria that needs scale attachment.
			         ', true), 'default', array('class' => 'error-box error-message'));
				}
			}
		}


		$yearLevels = $this->PublishedCourse->YearLevel->find('list', array('conditions' => array(
			'YearLevel.department_id' => $this->department_id
		)));



		$college_id = $this->PublishedCourse->Department->field(
			'college_id',
			array('Department.id' => $this->department_id)
		);
		$find_delegation_program_ids = $this->PublishedCourse->College->find(
			'first',
			array(
				'conditions' => array('College.id' => $college_id),
				'fields' => array('deligate_for_graduate_study', 'deligate_scale')
			)
		);

		if ($find_delegation_program_ids['College']['deligate_for_graduate_study'] == 1 && $find_delegation_program_ids['College']['deligate_scale'] == 1) {
			$programs = $this->PublishedCourse->Program->find('list');
		} else if (
			$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 0 &&
			$find_delegation_program_ids['College']['deligate_scale'] == 1
		) {
			$programs = $this->PublishedCourse->Program->find('list', array('conditions' =>
			array('Program.id' => PROGRAM_UNDEGRADUATE)));
		} else if (
			$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 1
			&& $find_delegation_program_ids['College']['deligate_scale'] == 0
		) {

			$programs = $this->PublishedCourse->Program->find('list', array('conditions' =>
			array('Program.id' => PROGRAM_POST_GRADUATE)));
		} else if (
			$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 0
			&& $find_delegation_program_ids['College']['deligate_scale'] == 0
		) {
			$programs['no_delegation'] = 'Not Delegated';
		}
		$gradeTypes = $this->PublishedCourse->Course->GradeType->find('list');

		$this->set(compact('programs', 'yearLevels', 'gradeTypes'));
	}

	function get_course_grade_scale($published_course_id = null)
	{
		$this->layout = 'ajax';
		$grade_scale = $this->PublishedCourse->getGradeScaleDetail($published_course_id);
		debug($grade_scale);
		$this->set(compact('grade_scale'));
	}

	function get_course_grade_stats($published_course_id = null)
	{
		$this->layout = 'ajax';

		$gradeStatistics = $this->PublishedCourse->CourseRegistration->ExamGrade->getLetterGradeStatistics($published_course_id);
		$this->set(compact('gradeStatistics'));
	}

	function get_course_published_for_section($section_id = "", $last = 1)
	{
		$this->layout = 'ajax';


		if ($last == 1) {
			$published_courses_list = $this->PublishedCourse->lastPublishedCoursesForSection($section_id);
			debug($section_id);
			debug($last);
		} else {
			$published_courses_list = $this->PublishedCourse->sectionPublishedCourses($section_id);
			debug($section_id);
			debug($last);
		}

		$this->set(compact('published_courses_list'));
	}

	/**
	 * Publish course for department unassigned students
	 */
	function college_publish_course()
	{


		if (!empty($this->request->data) && isset($this->request->data['getsection'])) {

			$everythingfine = false;
			switch ($this->request->data) {
				case empty($this->request->data['PublishedCourse']['academicyear']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to publish courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['semester']):
					$this->Session->setFlash('<span></span>' . __('Please select the semester you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['department_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the department you want to to select curriculum to be published.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['curriculum_id']):
					$this->Session->setFlash('<span></span>' . __('Please select curriculum you want to to select courses to be published.'), 'default', array('class' => 'error-box error-message'));
					break;
				default:
					$everythingfine = true;
			}

			if ($everythingfine) {
				// $year_level_id=$this->request->data['PublishedCourse']['year_level_id'];
				$program_id = $this->request->data['PublishedCourse']['program_id'];

				$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
				$academic_year = $this->request->data['PublishedCourse']['academicyear'];
				$semester = $this->request->data['PublishedCourse']['semester'];
				$department_id = $this->request->data['PublishedCourse']['department_id'];
				$curriculum_id = $this->request->data['PublishedCourse']['curriculum_id'];
				// $sections=$selected_section;

				$sections = $this->PublishedCourse->Section->find('list', array('conditions' => array(
					'Section.college_id' => $this->college_id,
					'Section.academicyear like ' => $academic_year . '%',
					'OR' => array('Section.department_id is null', 'Section.department_id' => array(0, ''))
				)));
				if (empty($sections)) {

					$this->Session->setFlash(
						'<span></span>' . __('You need to create section before publish courses for pre-engineering/freshman students.'),
						'default',
						array('class' => 'info-box info-message')
					);

					$this->redirect(
						array('controller' => 'sections', 'action' => 'add')
					);
				}


				$this->set(compact('show_publish_page'));
				$this->set('turn_off_search', true);

				$this->set(compact(
					'sections',
					'program_id',
					'program_type_id',
					'academic_year',
					'semester',
					'department_id',
					'curriculum_id'
				));
			}
		}

		if (!empty($this->request->data) && isset($this->request->data['publishselectedadd'])) {

			$this->request->data['PublishedCourse']['college_id'] = $this->college_id;
			unset($this->request->data['PublishedCourse']['department_id']);
			$save_reformated_published_courses = array();
			$courses_ids = array();
			$section_ids = array();

			$count = 0;

			foreach ($this->request->data['Course'] as $section_id => $courses) {
				$section_ids[] = $section_id;
				foreach ($courses as $cid => $is_selected) {
					if ($is_selected != 0) {

						$save_reformated_published_courses['PublishedCourse'][$count] = $this->request->data['PublishedCourse'];
						$save_reformated_published_courses['PublishedCourse'][$count]['published'] = 1;
						$save_reformated_published_courses['PublishedCourse'][$count]['add'] = 1;
						$save_reformated_published_courses['PublishedCourse'][$count]['course_id'] = $cid;
						$save_reformated_published_courses['PublishedCourse'][$count]['section_id'] = $section_id;
						$courses_ids[] = $cid;

						$count++;
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to publish as an add .'), 'default', array('class' => 'error-box error-message'));

				$program_id = $this->request->data['PublishedCourse']['program_id'];
				$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
				$academic_year = $this->request->data['PublishedCourse']['academic_year'];
				$semester = $this->request->data['PublishedCourse']['semester'];
				$department_id = $this->request->data['PublishedCourse']['department_id'];
				$curriculum_id = $this->request->data['PublishedCourse']['curriculum_id'];

				$this->set('turn_off_search', true);

				$sections = $this->PublishedCourse->Section->find('list', array('conditions' => array(
					'Section.college_id' => $this->college_id,
					'OR' => array('Section.department_id is null', 'Section.department_id' => array(0, ''))
				)));

				$selectedsection = $this->request->data['Section']['selected'];


				$this->set(compact(
					'sections',
					'program_id',
					'program_type_id',
					'curriculum_id',
					'department_id',
					'academic_year',
					'semester',
					'selectedsection'
				));
			} else {

				$check_courses_published = $this->PublishedCourse->find(
					'count',
					array('conditions' => array(
						'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'], 'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.course_id' => $courses_ids, 'PublishedCourse.section_id' => $section_ids, 'PublishedCourse.program_id' => 1, 'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.college_id' => $this->college_id,
						'PublishedCourse.department_id is null'
					))
				);
				$published_courses = $this->PublishedCourse->find(
					'list',
					array('conditions' => array('PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%', 'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'], 'PublishedCourse.section_id' => $section_ids, 'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'], 'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'], 'PublishedCourse.college_id' => $this->college_id), 'fields' => 'PublishedCourse.course_id')
				);





				// unset those courses which has already published and publish only coures not published
				foreach ($published_courses as $pk => $pv) {
					//check and unset those already published courses
					foreach ($save_reformated_published_courses['PublishedCourse'] as $sk => &$sv) {
						if ($sv['course_id'] == $pv) {
							unset($save_reformated_published_courses['PublishedCourse'][$sk]);
						}
					}
				}

				// check if all courses has already published and redirect the user to the published course page.
				if ($check_courses_published == count($courses_ids)) {
					$this->Session->setFlash(
						'<span></span>' . __('The selected courses has  already published  for the selected criteria'),
						'default',
						array('class' => 'info-box info-message')
					);
					$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
					$this->redirect(array(
						'action' => 'index',
						$this->request->data['PublishedCourse']['semester'], $academic_year
					));
				}


				$selected_sections_ids = array();
				//debug($this->request->data['Section']['selected']);
				foreach ($this->request->data['Section']['selected'] as $se_index => $se_value) {
					if ($se_value != 0) {
						$selected_sections_ids[] = $se_index;
					}
				}

				if (!empty($selected_sections_ids)) {
					$list_courses_published_ids = $this->PublishedCourse->find(
						'list',
						array('conditions' => array(
							'PublishedCourse.academic_year like ' =>
							$this->request->data['PublishedCourse']['academic_year'] . '%',
							'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
							'PublishedCourse.section_id' => $selected_sections_ids,
							'PublishedCourse.program_id' => 1,
							'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
							'PublishedCourse.department_id is null',
							'PublishedCourse.year_level_id' => 0,
							'PublishedCourse.college_id' => $this->college_id
						))
					);
				}
				if (!empty($list_courses_published_ids)) {
					$check_registration_started = $this->PublishedCourse->CourseRegistration->find(
						'count',
						array('conditions' => array(
							'CourseRegistration.publish_course_id' => $list_courses_published_ids
						))
					);
					if ($check_registration_started == 0) {
						$check_registration_started = $this->PublishedCourse->CourseAdd->find('count', array('conditions' => array(
							'CourseAdd.published_course_id' =>
							$list_courses_published_ids
						)));
					}
				} else {
					$check_registration_started = 0;
				}


				if ($check_registration_started == 0) {
					if ($this->PublishedCourse->saveAll(
						$save_reformated_published_courses['PublishedCourse'],
						array('validate' => 'first')
					)) {
						$this->Session->setFlash(
							'<span></span>' . __('The course has been published for registration.'),
							'default',
							array('class' => 'success-box success-message')
						);


						$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
						$this->redirect(array(
							'action' => 'index',
							$this->request->data['PublishedCourse']['semester'], $academic_year
						));
					} else {

						$this->Session->setFlash(
							'<span></span>' . __('The published course could not be saved. Please, try again.'),
							'default',
							array('class' => 'error-box error-message')
						);
					}
				} else {
					$this->Session->setFlash(
						'<span></span>' . __('Course registration has been started you can not publish semester courses but you can publish mass add course.'),
						'default',
						array('class' => 'success-box success-message')
					);


					$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
					$this->redirect(array(
						'action' => 'index',
						$this->request->data['PublishedCourse']['semester'], $academic_year
					));
				}
			}
		}

		if (!empty($this->request->data) && isset($this->request->data['publishselected'])) {


			$this->request->data['PublishedCourse']['college_id'] = $this->college_id;
			unset($this->request->data['PublishedCourse']['department_id']);
			$save_reformated_published_courses = array();
			$courses_ids = array();
			$section_ids = array();

			$count = 0;

			foreach ($this->request->data['Course'] as $section_id => $courses) {
				debug($section_id);
				$section_ids[] = $section_id;
				foreach ($courses as $cid => $is_selected) {
					if ($is_selected != 0) {

						$save_reformated_published_courses['PublishedCourse'][$count] = $this->request->data['PublishedCourse'];
						$save_reformated_published_courses['PublishedCourse'][$count]['published'] = 1;
						$save_reformated_published_courses['PublishedCourse'][$count]['course_id'] = $cid;
						$save_reformated_published_courses['PublishedCourse'][$count]['section_id'] = $section_id;
						$courses_ids[] = $cid;

						$count++;
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to publish.'), 'default', array('class' => 'error-box error-message'));

				$program_id = $this->request->data['PublishedCourse']['program_id'];
				$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
				$academic_year = $this->request->data['PublishedCourse']['academic_year'];
				$semester = $this->request->data['PublishedCourse']['semester'];
				$department_id = $this->request->data['PublishedCourse']['department_id'];
				$curriculum_id = $this->request->data['PublishedCourse']['curriculum_id'];

				$this->set('turn_off_search', true);

				$sections = $this->PublishedCourse->Section->find('list', array('conditions' => array(
					'Section.college_id' => $this->college_id,
					'OR' => array('Section.department_id is null', 'Section.department_id' => array(0, ''))
				)));
				debug($sections);
				$selectedsection = $this->request->data['Section']['selected'];


				$this->set(compact(
					'sections',
					'program_id',
					'program_type_id',
					'curriculum_id',
					'academic_year',
					'semester',
					'selectedsection',
					'department_id'
				));
			} else {

				$check_courses_published = $this->PublishedCourse->find(
					'count',
					array('conditions' => array(
						'PublishedCourse.academic_year' => $this->request->data['PublishedCourse']['academic_year'], 'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
						'PublishedCourse.course_id' => $courses_ids, 'PublishedCourse.section_id' => $section_ids, 'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'], 'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
						'PublishedCourse.college_id' => $this->college_id
					))
				);

				$published_courses = $this->PublishedCourse->find(
					'list',
					array(
						'conditions' => array(
							'PublishedCourse.academic_year like ' =>
							$this->request->data['PublishedCourse']['academic_year'] . '%',
							'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
							'PublishedCourse.section_id' => $section_ids,
							'PublishedCourse.department_id is null ',
							'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
							'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
							'PublishedCourse.college_id' => $this->college_id
						),
						'fields' => 'PublishedCourse.course_id'
					)
				);
				//debug($published_courses);
				//debug($save_reformated_published_courses);

				// unset those courses which has already published and publish only coures not published
				/*foreach ($published_courses as $pk=>$pv) {
		                //check and unset those already published courses
		                foreach($save_reformated_published_courses['PublishedCourse'] as $sk=>&$sv) {
		                        if ($sv['course_id'] == $pv) {
		                           unset($save_reformated_published_courses['PublishedCourse'][$sk]);

		                        }
		                }
		        }
		        */


				// check if all courses has already published and redirect the user to the published course page.

				if ($check_courses_published == count($courses_ids)) {
					$this->Session->setFlash(
						'<span></span>' . __('The selected courses has  already published  for the selected criteria'),
						'default',
						array('class' => 'info-box info-message')
					);
					$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
					$this->redirect(array(
						'action' => 'index',
						$this->request->data['PublishedCourse']['semester'], $academic_year
					));
				}
				$count_already_published = count($published_courses);
				$count_ready_published = count($save_reformated_published_courses);

				if ($this->PublishedCourse->saveAll(
					$save_reformated_published_courses['PublishedCourse'],
					array('validate' => 'first')
				)) {
					$this->Session->setFlash(
						'<span></span>' . __('The course has been published for registration.'),
						'default',
						array('class' => 'success-box success-message')
					);


					$academic_year = str_replace('/', '-', $this->request->data['PublishedCourse']['academic_year']);
					$this->redirect(array(
						'action' => 'index',
						$this->request->data['PublishedCourse']['semester'], $academic_year
					));
				} else {

					$this->Session->setFlash(
						'<span></span>' . __('The published course could not be saved. Please, try again.'),
						'default',
						array('class' => 'error-box error-message')
					);
				}
			}
		}
		$departments = $this->PublishedCourse->Department->find('list');
		$programs = $this->PublishedCourse->Program->find('list');
		$programTypes = $this->PublishedCourse->ProgramType->find('list');
		$this->set(compact('sections', 'departments', 'programs', 'programTypes'));
	}



	function college_unpublish_course()
	{

		if (!empty($this->request->data) && isset($this->request->data['getsection'])) {

			$everythingfine = false;
			switch ($this->request->data) {
				case empty($this->request->data['PublishedCourse']['academic_year']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to publish courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['semester']):
					$this->Session->setFlash('<span></span>' . __('Please select the semester you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				default:
					$everythingfine = true;
			}

			if ($everythingfine) {
				// Function to load/save search criteria.
				$this->__init_search();

				$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
					'PublishedCourse.college_id' => $this->college_id,
					'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
					'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
					'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
					'PublishedCourse.published' => 1, 'PublishedCourse.department_id is null'
				), 'contain' => array(
					'Course' => array('id', 'course_title', 'course_code', 'credit', 'lecture_hours', 'tutorial_hours'), 'YearLevel' => array('id', 'name'), 'Section' => array('id', 'name'), 'Program' => array('id', 'name'),
					'ProgramType' => array('id', 'name')
				)));



				if (empty($publishedcourses)) {
					$this->Session->setFlash('<span></span>' . __('There is no published courses in the given criteria, please select different criteria.'), 'default', array('class' => 'error-box error-message'));
				} else {


					$this->set('turn_off_search', true);
					$this->set('show_unpublish_page', true);

					$program_id = $this->request->data['PublishedCourse']['program_id'];
					$program_type_id = $this->request->data['PublishedCourse']['program_type_id'];
					// $this->set(compact('publishedCourses'));

					$this->set('publishedcourses', $this->PublishedCourse->getSectionofPublishedCourses($this->request->data, null, $publishedcourses, $this->college_id));


					$this->set(compact('program_id', 'program_type_id'));
				}
			} else {

				//$this->redirect(array('action'=>'add'));
			}
		}


		//delete publisehd courses
		if (!empty($this->request->data) && isset($this->request->data['deleteselected'])) {


			$count = 0;
			$courses_ids = array();
			$section_ids = array();
			foreach ($this->request->data['Course']['pub'] as $section_id => $selected_courses) {
				$section_ids[] = $section_id;
				foreach ($selected_courses as $course_id => $selected_flag) {
					if ($selected_flag == 1) {

						$count++;
						$courses_ids[$section_id][] = $course_id;
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to delete.'), 'default', array('class' => 'error-box error-message'));
			} else {
				$this->request->data['PublishedCourse'] = $this->Session->read('search_data');
				//  debug($this->request->data);
				$courses_not_allowed = array();
				$courses_allowed_to_delete = array();

				foreach ($section_ids as $kk => $sv) {
					if (isset($courses_ids[$sv])) {

						$publishedcourses = $this->PublishedCourse->find('all', array(
							'conditions' => array(
								'PublishedCourse.college_id' => $this->college_id,
								// 'PublishedCourse.department_id'=>$this->department_id,
								'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
								'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
								'PublishedCourse.published' => 1,
								'PublishedCourse.course_id' => $courses_ids[$sv],
								'PublishedCourse.section_id' => $sv,
								'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
								'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%'
							),

							'contain' => array(

								'CourseRegistration' => array(
									'Student' => array(
										'fields' => array(
											'Student.full_name',

										)
									)

								)
							),

						));

						foreach ($publishedcourses as $pk => $pv) {
							// debug($pv);
							if (count($pv['CourseRegistration']) == 0) {
								$courses_allowed_to_delete[$sv][$pk] = $pv['PublishedCourse']['id'];
								//$courses_allowed_to_delete[$pk]['course_id']=$pv['PublishedCourse']['course_id'];

							} else {
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['id'];
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['course_id'];
							}
						}
					}
				}

				//iterate section by section

				if (count($courses_not_allowed) > 0) {
					$this->Session->setFlash('<span></span>' . __('You can not delete the red marked courses , students has already registered for the courses. Please uncheck the red marked courses.'), 'default', array('class' => 'error-box error-message'));
					$this->set(compact('courses_not_allowed'));
				} else {
					//$count_deleted_record=count($courses_allowed_to_delete);
					$count_delete_record = array();
					foreach ($section_ids as $key => $section_id) {
						if (isset($courses_allowed_to_delete[$section_id])) {
							if ($this->PublishedCourse->deleteAll(array('PublishedCourse.id' => $courses_allowed_to_delete[$section_id], 'PublishedCourse.section_id' => $section_id))) {
								$count_delete_record[$section_id] = count($courses_allowed_to_delete[$section_id]);
							}
						}
					}
					if (!empty($count_delete_record)) {
						$sum = 0;
						foreach ($count_delete_record as $sec_id => $del_count) {
							$sum += $del_count;
						}
						if ($sum > 0) {
							$this->Session->setFlash(
								'<span></span>' .
									__('You have deleted ' . $sum . '  published course.'),
								'default',
								array('class' => 'success-box success-message')
							);
						} else {
							$this->Session->setFlash(
								'<span></span>' . __('Published course was not deleted.Pleas try again.'),
								'default',
								array('class' => 'error-box error-message')
							);
						}
					}
				}
			}

			$this->request->data['PublishedCourse'] = $this->Session->read('search_data');

			$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
				'PublishedCourse.college_id' => $this->college_id,
				'PublishedCourse.department_id is null',

				'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
				'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],

				'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
				'PublishedCourse.published' => 1
			)));

			$this->set('turn_off_search', true);
			$this->set('show_unpublish_page', true);

			$this->set('publishedcourses', $this->PublishedCourse->getSectionofPublishedCourses($this->request->data, null, $publishedcourses, $this->college_id));
		}

		/////////////////////////////////////////////////////////////////////////////////

		//publish as drop coures drop publisehd courses
		if (!empty($this->request->data) && isset($this->request->data['dropselected'])) {

			$count = 0;
			$courses_ids = array();
			$section_ids = array();
			if (!empty($this->request->data['Course']['pub'])) {

				foreach ($this->request->data['Course']['pub'] as $section_id => $selected_courses) {
					$section_ids[] = $section_id;
					foreach ($selected_courses as $course_id => $selected_flag) {
						if ($selected_flag == 1) {

							$count++;
							$courses_ids[$section_id][] = $course_id;
						}
					}
				}
			}

			if ($count == 0) {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one course you want to publish as drop course.'), 'default', array('class' => 'error-box error-message'));
			} else {
				$this->request->data['PublishedCourse'] = $this->Session->read('search_data');

				$courses_not_allowed = array();
				$courses_allowed_to_drop = array();
				foreach ($section_ids as $kk => $sv) {
					if (isset($courses_ids[$sv])) {
						$publishedcourses = $this->PublishedCourse->find(
							'all',
							array(
								'conditions' => array(
									'PublishedCourse.department_id is null', 'PublishedCourse.year_level_id' => 0,

									'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
									'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],

									'PublishedCourse.published' => 1,
									'PublishedCourse.course_id' => $courses_ids[$sv],
									'PublishedCourse.section_id' => $sv,
									'PublishedCourse.drop' => 0,
									'PublishedCourse.semester' => $this->request->data['PublishedCourse']['semester'],
									'PublishedCourse.academic_year like ' =>
									$this->request->data['PublishedCourse']['academic_year'] . '%'
								),

								'contain' => array(

									'CourseRegistration' => array(
										'Student' => array(
											'fields' => array(
												'Student.full_name',

											)
										)

									)
								)
							)
						);

						foreach ($publishedcourses as $pk => $pv) {

							if (count($pv['CourseRegistration']) > 0) {
								$courses_allowed_to_drop[$sv][$pk] = $pv['PublishedCourse']['id'];
								//$courses_allowed_to_delete[$pk]['course_id']=$pv['PublishedCourse']['course_id'];

							} else {
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['id'];
								$courses_not_allowed[$sv][$pk] = $pv['PublishedCourse']['course_id'];
							}
						}
					}
				}

				if (count($courses_not_allowed) > 0) {
					$this->Session->setFlash('<span></span>' . __('You can not publish as drop courses of the red marked courses , no student has registred for it. Please check the red marked courses and press delete button at the bottom if you intend to  make it invisible for registration'), 'default', array('class' => 'error-box error-message'));
					$this->set(compact('courses_not_allowed'));
				} else {

					// reformat courses_allowed to unpublished
					$save_reformat_drop_published_courses = array();
					if (!empty($section_ids)) {
						$count_drop = 0;
						foreach ($section_ids as $section_index => $section_id) {
							if (isset($courses_allowed_to_drop[$section_id])) {
								foreach ($courses_allowed_to_drop[$section_id] as $index => $course_id) {
									$save_reformat_drop_published_courses['PublishedCourse'][$count_drop]['id']
										= $course_id;

									$save_reformat_drop_published_courses['PublishedCourse'][$count_drop]['published'] = 1;
									$save_reformat_drop_published_courses['PublishedCourse'][$count_drop]['drop'] = 1;
									$count_drop++;
								}
							}
						}



						//save the drop published coureses
						if (count($save_reformat_drop_published_courses['PublishedCourse']) > 0) {
							if ($this->PublishedCourse->saveAll(
								$save_reformat_drop_published_courses['PublishedCourse'],
								array('validate' => 'first')
							)) {

								$this->Session->setFlash(
									'<span></span>' . __('Among selected  courses ' . $count_drop . ' has been published as drop course.'),
									'default',
									array('class' => 'success-box success-message')
								);

								//$academic_year=str_replace('/','-',$this->request->data['PublishedCourse']['academic_year']);
								// $this->redirect(array('action' => 'index',
								// $this->request->data['PublishedCourse']['semester'],$academic_year));
							} else {
								$this->Session->setFlash(
									'<span></span>' . __('The course could not be published as drop coures. Please, try again.'),
									'default',
									array('class' => 'error-box error-message')
								);
							}
						} else {
							$this->Session->setFlash(
								'<span></span>' . __('Internal Error for publishing as drop.'),
								'default',
								array('class' => 'error-box error-message')
							);
						}
					}
				}
			}
			$this->request->data['PublishedCourse'] = $this->Session->read('search_data');

			$publishedcourses = $this->PublishedCourse->find('all', array('conditions' => array(
				'PublishedCourse.department_id is null',
				'PublishedCourse.college_id' => $this->college_id,
				'PublishedCourse.year_level_id' => 0,
				'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id'],
				'PublishedCourse.program_type_id' => $this->request->data['PublishedCourse']['program_type_id'],
				'PublishedCourse.academic_year like' => $this->request->data['PublishedCourse']['academic_year'] . '%',
				'PublishedCourse.published' => 1, 'PublishedCourse.drop' => 0
			)));
			/*
			$section_organized_published_courses = $this->PublishedCourse->getSectionofPublishedCourses($this->request->data,$this->department_id,
			$publishedcourses);
			*/

			$section_organized_published_courses = $this->PublishedCourse->getSectionofPublishedCourses($this->request->data, null, $publishedcourses, $this->college_id);

			$this->set('turn_off_search', true);
			$this->set('show_unpublish_page', true);
			$this->set('publishedcourses', $section_organized_published_courses);
		}
		$programs = $this->PublishedCourse->Program->find('list');
		$programTypes = $this->PublishedCourse->ProgramType->find('list');

		$this->set(compact('programs', 'programTypes'));

		////////////////////////////////////////////////////////////////////
	}



	function college_attache_scale()
	{

		if (!empty($this->request->data) && isset($this->request->data['attachescaletocourse'])) {

			$data['PublishedCourse'] = $this->request->data['Published'];

			if (empty($data['PublishedCourse'])) {
				$this->Session->setFlash('<span></span>' . __('No course has been attached to any scale.'), 'default', array('class' => 'info-box info-message'));
			} else {

				if ($this->PublishedCourse->saveAll(
					$data['PublishedCourse'],
					array('validate' => 'first')
				)) {
					$this->Session->setFlash(
						'<span></span>' . __('The grade scale has been saved'),
						'default',
						array('class' => 'success-message success-box')
					);
					//$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<span></span>' . __('The grade scale could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
				}
			}


			$this->request->data['getPublishedCourseList'] = true;
		}


		if (!empty($this->request->data) && isset($this->request->data['getPublishedCourseList'])) {

			$everythingfine = false;

			switch ($this->request->data) {

				case empty($this->request->data['PublishedCourse']['academic_year']):
					$this->Session->setFlash('<span></span> ' . __('Please select the academic year you want to attach scale.'), 'default', array('class' => 'error-box error-message'));
					break;

				case empty($this->request->data['PublishedCourse']['semester']):
					$this->Session->setFlash('<span></span>' . __('Please select the semester you want to attache scale.'), 'default', array('class' => 'error-box error-message'));
					break;

				case empty($this->request->data['PublishedCourse']['program_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the program you want to unpublished courses.'), 'default', array('class' => 'error-box error-message'));
					break;
				case empty($this->request->data['PublishedCourse']['department_id']):
					$this->Session->setFlash('<span></span>' . __('Please select the department  you want  attache scale.'), 'default', array('class' => 'error-box error-message'));
					break;

				default:
					$everythingfine = true;
			}


			if ($everythingfine) {

				if (strcasecmp($this->request->data['PublishedCourse']['department_id'], 'pre') === 0) {
					$publishedCourses = $this->PublishedCourse->find('all', array(
						'fields' => array('id', 'section_id', 'grade_scale_id'), 'conditions' =>
						array(
							'PublishedCourse.semester ' => $this->request->data['PublishedCourse']['semester'],
							'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
							'PublishedCourse.drop' => 0,
							'PublishedCourse.department_id is null',
							'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id']
						),
						'contain' => array(
							'Course' => array('fields' => array('id', 'course_title', 'credit', 'course_code', 'grade_type_id')),
							'Section' => array(
								'fields' => array('id', 'name'),
								'conditions' => array('Section.archive <> ' => 1), 'ProgramType' => array('fields' => array('id', 'name'))
							)
						)
					));
				} else {
					$publishedCourses = $this->PublishedCourse->find('all', array(
						'fields' => array('id', 'section_id', 'grade_scale_id'), 'conditions' =>
						array(
							'PublishedCourse.semester ' => $this->request->data['PublishedCourse']['semester'],
							'PublishedCourse.academic_year like ' => $this->request->data['PublishedCourse']['academic_year'] . '%',
							'PublishedCourse.drop' => 0,
							'PublishedCourse.department_id' => $this->request->data['PublishedCourse']['department_id'],
							'PublishedCourse.program_id' => $this->request->data['PublishedCourse']['program_id']
						),
						'contain' => array(
							'Course' => array('fields' => array('id', 'course_title', 'credit', 'course_code', 'grade_type_id')),
							'Section' => array(
								'fields' => array('id', 'name'),
								'conditions' => array('Section.archive <> ' => 1), 'ProgramType' => array('fields' => array('id', 'name'))
							)
						)
					));
				}

				if (!empty($publishedCourses)) {

					if (
						strcasecmp($this->request->data['PublishedCourse']['department_id'], 'pre') === 0 &&
						$this->request->data['PublishedCourse']['program_id'] == PROGRAM_UNDEGRADUATE
					) {

						$gradeScales = $this->PublishedCourse->GradeScale->find(
							'all',
							array(
								'conditions' => array(
									'GradeScale.model' => 'College',
									'GradeScale.foreign_key' => $this->college_id,
									'GradeScale.active' => 1,
									// 'GradeScale.own'=>1,
									'GradeScale.own' => 0,
									'GradeScale.program_id' => $this->request->data['PublishedCourse']['program_id']
								),
								'fields' => array('id', 'name'),
								'contain' => array('GradeScaleDetail' => array(
									'Grade' => array(
										'fields' => array('id', 'grade'),
										'GradeType' => array('id', 'type')
									)
								), 'Program' => array('fields' => array('id', 'name')))
							)
						);
					} else {
						$gradeScales = $this->PublishedCourse->GradeScale->find(
							'all',
							array(
								'conditions' => array(
									'GradeScale.model' => 'College',
									'GradeScale.foreign_key' => $this->college_id,
									'GradeScale.active' => 1,
									'GradeScale.own' => 0,
									'GradeScale.program_id' => $this->request->data['PublishedCourse']['program_id']
								),
								'fields' => array('id', 'name'),
								'contain' => array('GradeScaleDetail' => array(
									'Grade' => array(
										'fields' => array('id', 'grade'),
										'GradeType' => array('id', 'type')
									)
								), 'Program' => array('fields' => array('id', 'name')))
							)
						);
					}

					$find_delegation_program_ids = $this->PublishedCourse->College->find('first', array('conditions' => array(
						'College.id' => $this->college_id
					), 'fields' => array('deligate_for_graduate_study', 'deligate_scale')));

					if (empty($gradeScales)) {

						if (
							$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 0 &&
							$this->request->data['PublishedCourse']['program_id'] == PROGRAM_POST_GRADUATE
						) {
							$this->Session->setFlash('<span></span>' . __(' There is no grade scale in the system that are defined, please define scale before attaching grade scale to published courses.'), 'default', array('class' => 'error-box error-message'));
							$this->redirect(array('controller' => 'gradeScales', 'action' => 'set_grade_scale'));
						} else if (
							$find_delegation_program_ids['College']['deligate_scale'] == 0
							&& PROGRAM_UNDEGRADUATE == $this->request->data['PublishedCourse']['program_id']
						) {
							$this->Session->setFlash('<span></span>' . __('There is no grade scale in the system that are defined, please define scale before attaching grade scale to published courses.'), 'default', array('class' => 'error-box error-message'));
							$this->redirect(array('controller' => 'gradeScales', 'action' => 'set_grade_scale'));
						} else {
							if (
								$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 1 &&
								$this->request->data['PublishedCourse']['program_id'] == PROGRAM_POST_GRADUATE
							) {
								$this->Session->setFlash(
									'<span></span>' .
										__('You have delegated attaching grade scale to department for
			                 postgraduate program.', true),
									'default',
									array('class' => 'error-box error-message')
								);
							}

							if (
								$find_delegation_program_ids['College']['deligate_scale'] == 1 &&
								$this->request->data['PublishedCourse']['program_id'] == PROGRAM_POST_GRADUATE
							) {
								$this->Session->setFlash(
									'<span></span>' .
										__('You have delegated attaching grade scale to department for
			                 undergraduate program.', true),
									'default',
									array('class' => 'error-box error-message')
								);
							}
						}
					}

					$return = array();
					foreach ($gradeScales as $kk => $vv) {
						if (!empty($vv['GradeScaleDetail'][0]['Grade']['GradeType']['type'])) {
							$return[$vv['GradeScaleDetail'][0]['Grade']['grade_type_id']][$vv['GradeScale']['name'] . '-' .
								$vv['GradeScaleDetail'][0]['Grade']['GradeType']['type'] . '-' .
								$vv['Program']['name']][$vv['GradeScale']['id']] = $vv['GradeScale']['name'];
						}
					}
					$gradeScales = $return;

					$section_organized_published_courses = $this->PublishedCourse->get_section_organized_published_courses_scale_attachment($this->request->data, $this->request->data['PublishedCourse']['department_id'], $publishedCourses, $this->college_id);

					if (empty($section_organized_published_courses)) {
						$this->Session->setFlash(
							'<span></span>' .
								__('There is no published courses in the given criteria that needs
			       scale attachment.', true),
							'default',
							array('class' => 'error-box error-message')
						);
					}
					$this->set(compact('section_organized_published_courses', 'gradeScales'));
				} else {
					$this->Session->setFlash(
						'<span></span>' .
							__('There is no published courses in the given criteria that needs
			       scale attachment.', true),
						'default',
						array('class' => 'error-box error-message')
					);
				}
			}
		}
		$beginning['pre'] = 'Pre/Fresh';

		$find_delegation_program_ids = $this->PublishedCourse->College->find('first', array('conditions' => array(
			'College.id' => $this->college_id
		), 'fields' => array('deligate_for_graduate_study', 'deligate_scale')));

		if ($find_delegation_program_ids['College']['deligate_for_graduate_study'] == 0 && $find_delegation_program_ids['College']['deligate_scale'] == 0) {
			$programs = $this->PublishedCourse->Program->find('list');
			$departments = $this->PublishedCourse->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id)));
		} else if (
			$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 1 &&
			$find_delegation_program_ids['College']['deligate_scale'] == 0
		) {
			$programs = $this->PublishedCourse->Program->find('list', array('conditions' =>
			array('Program.id' => PROGRAM_UNDEGRADUATE)));
			$departments = $this->PublishedCourse->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id)));
		} else if (
			$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 0
			&& $find_delegation_program_ids['College']['deligate_scale'] == 1
		) {

			$programs = $this->PublishedCourse->Program->find('list', array('conditions' =>
			array('Program.id' => PROGRAM_POST_GRADUATE)));
			$departments = $this->PublishedCourse->Department->find('list', array('conditions' => array('Department.college_id' => $this->college_id)));
		} else if (
			$find_delegation_program_ids['College']['deligate_for_graduate_study'] == 1
			&& $find_delegation_program_ids['College']['deligate_scale'] == 1
		) {
			$programs = $this->PublishedCourse->Program->find('list', array('conditions' =>
			array('Program.id' => PROGRAM_UNDEGRADUATE)));
			$programs['delegation'] = 'Delegated To Department';
			$departments = array();
		}

		$departments = $beginning + $departments;

		$gradeTypes = $this->PublishedCourse->Course->GradeType->find('list');

		$this->set(compact('programs', 'departments', 'gradeTypes'));
	}
}