<?php
App::import('Vendor', 'PhpExcelReader/Excel/reader');
App::uses('CakeTime', 'Utility'); // to use as time helper from a controller.
class CertificationCourseSettingsController extends AppController
{
	public $name = 'CertificationCourseSettings';

	public $menuOptions = array(
		'parent' => 'placement',
		'exclude' => array(
            //'add'
		),
		'alias' => array(
			'index' => 'eSHE Certifications Settings',
			'add' => 'Set Certification Course Setting',
			'mass_import_eshe_certifications' => 'Mass Import ESHE Certifications'
		)
	);

	public $components = array('AcademicYear');
	public $helpers = array('Xls');
	public $paginate = array();

	public function beforeFilter()
	{
		parent::beforeFilter();
		/* $this->Auth->Allow('index', 'add', 'edit', 'delete', 'mass_import_eshe_certifications'); */
	}

	public function beforeRender()
	{
		parent::beforeRender();

		$current_acy_and_semester = $this->AcademicYear->current_acy_and_semester();
		$defaultacademicyear = $current_acy_and_semester['academic_year'];
		$current_semester = $current_acy_and_semester['semester'];
        
        $eshe_start_ac_year = ESHE_SSS_COURSE_COMPLETION_STARTED_ACADEMIC_YEAR;


        if ($eshe_start_ac_year == $defaultacademicyear) {
            $acyear_array_data[$defaultacademicyear] = $defaultacademicyear;
        } else {

            if (strlen($eshe_start_ac_year) == 7) {
                $acyear_array_data = $this->AcademicYear->academicYearInArray((explode('/', $eshe_start_ac_year)[0]), (explode('/', $defaultacademicyear)[0]));
            } else if (strlen($eshe_start_ac_year) == 4 && is_numeric($eshe_start_ac_year)) {
                $acyear_array_data = $this->AcademicYear->academicYearInArray($eshe_start_ac_year, (explode('/', $defaultacademicyear)[0]));
            } else {
                $acyear_array_data[$defaultacademicyear] = $defaultacademicyear;
            }
        }

		$programs = ClassRegistry::init('Program')->find('list', array('conditions' => array(/* 'Program.id' => $this->program_ids, */ 'Program.active' => 1)));
		$programTypes = ClassRegistry::init('ProgramType')->find('list', array('conditions' => array(/* 'ProgramType.id' => $this->program_type_ids, */ 'ProgramType.active' => 1)));
		
		$this->set(compact('acyear_array_data', 'current_semester', 'defaultacademicyear', 'programs', 'programTypes'));

	}

    public function index() 
	{
		$this->Paginator->settings =  array(
			'contain' => array(), 
			'order' => array('CertificationCourseSetting.academic_year' => 'ASC', 'CertificationCourseSetting.semester' => 'ASC', 'CertificationCourseSetting.id' => 'ASC'),
			'limit' => 100,
			'maxLimit' => 100,
			'recursive'=> -1
		);

		$certificationCourseSettings = array();

		try {
			$certificationCourseSettings = $this->Paginator->paginate($this->modelClass);
		} catch (NotFoundException $e) {
			return $this->redirect(array('action' => 'index'));
		} catch (Exception $e) {
			return $this->redirect(array('action' => 'index'));
		}

		if (empty($certificationCourseSettings)) {
			$this->Flash->info('No Certification Course Setting is found in the system.');
		}

		$this->set(compact('certificationCourseSettings'));
    }

	public function add()
	{
		if (isset($this->request->data['addSetting'])) {

			unset($this->request->data['addSetting']);

			$sentData = $this->request->data;

			//debug($this->request->data);

			if (!empty($this->request->data['CertificationCourseSetting']['certification_course_id']) && !empty($this->request->data['CertificationCourseSetting']['academic_year']) && !empty($this->request->data['CertificationCourseSetting']['semester']) && !empty($this->request->data['CertificationCourseSetting']['program_id'])) {
				if ($this->CertificationCourseSetting->isUniqueCertificationCourseSetting($this->request->data)) {

					$this->request->data['CertificationCourseSetting']['certification_course_id'] = serialize($this->request->data['CertificationCourseSetting']['certification_course_id']);
					$this->request->data['CertificationCourseSetting']['program_type_ids_to_exclude'] = serialize($this->request->data['CertificationCourseSetting']['program_type_ids_to_exclude']);

					if ($this->CertificationCourseSetting->save($this->request->data)) {
						$this->Flash->success(__('Certification Course Setting is saved.'));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Flash->error(__('Certification Course Setting could not be saved. Please, try again.'));
					}
				} else {
					$this->Flash->error(__('Certification Course Setting alaready exists. You can edit that instead.'));
				}
			} else {
				$this->Flash->error(__('Please select and set all required fields and try again.'));
			}

			$this->request->data = $sentData;
		}

		$certificationCourses = ClassRegistry::init('CertificationCourse')->find('list', array('conditions' => array('CertificationCourse.status' => 1), 'fields' => array('CertificationCourse.id', 'CertificationCourse.course_title'), 'recursive' => -1));

		$this->set(compact('certificationCourses'));
	}

	function edit($id = null)
	{
		if (!$id && empty($this->request->data)) {
			$this->Flash->error('Invalid Certification Course Setting ID');
			return $this->redirect(array('action' => 'index'));
		}

		$this->CertificationCourseSetting->id = $id;

		if (!$this->CertificationCourseSetting->exists()) {
			$this->Flash->error('Invalid Certification Course Setting ID');
			return $this->redirect(array('action' => 'index'));
		}

		if (isset($this->request->data['saveSetting'])) {

			unset($this->request->data['saveSetting']);

			$sentData = $this->request->data;

			if (!empty($this->request->data['CertificationCourseSetting']['certification_course_id']) && !empty($this->request->data['CertificationCourseSetting']['academic_year']) && !empty($this->request->data['CertificationCourseSetting']['semester']) && !empty($this->request->data['CertificationCourseSetting']['program_id'])) {
				if ($this->CertificationCourseSetting->isUniqueCertificationCourseSetting($this->request->data)) {

					$this->request->data['CertificationCourseSetting']['certification_course_id'] = serialize($this->request->data['CertificationCourseSetting']['certification_course_id']);
					$this->request->data['CertificationCourseSetting']['program_type_ids_to_exclude'] = serialize($this->request->data['CertificationCourseSetting']['program_type_ids_to_exclude']);

					if ($this->CertificationCourseSetting->save($this->request->data)) {
						$this->Flash->success(__('Certification Course Setting is saved.'));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Flash->error(__('Certification Course Setting could not be saved. Please, try again.'));
					}
				} else {
					$this->Flash->error(__('Certification Course Setting alaready exists. You can edit that instead.'));
				}
			} else {
				$this->Flash->error(__('Please select and set all required fields and try again.'));
			}

			$this->request->data = $sentData;
		}


		if (empty($this->request->data)) {

			$this->request->data = $this->CertificationCourseSetting->find('first', array('conditions' => array('CertificationCourseSetting.id' => $id), 'recursive'=> -1));

			$this->request->data['CertificationCourseSetting']['certification_course_id'] = unserialize($this->request->data['CertificationCourseSetting']['certification_course_id']);
			$this->request->data['CertificationCourseSetting']['program_type_ids_to_exclude'] = unserialize($this->request->data['CertificationCourseSetting']['program_type_ids_to_exclude']);
		}

		$certificationCourses = ClassRegistry::init('CertificationCourse')->find('list', array('conditions' => array('CertificationCourse.status' => 1), 'fields' => array('CertificationCourse.id', 'CertificationCourse.course_title'), 'recursive' => -1));

		$this->set(compact('certificationCourses'));
	}

	function delete($id = null)
	{
		if (!$id) {
			$this->Flash->error('Invalid Certification Course Setting ID');
			return $this->redirect(array('action' => 'index'));
		}

		$this->CertificationCourseSetting->id = $id;

		if (!$this->CertificationCourseSetting->exists()) {
			$this->Flash->error('Invalid Certification Course Setting ID');
			return $this->redirect(array('action' => 'index'));
		}

		
		if ($this->CertificationCourseSetting->delete($id)) {
			$this->Flash->success('Certification Course Setting deleted.');
			$this->redirect(array('action' => 'index'));
		}

		$this->Flash->error('Certification Course Setting was not deleted, Please try again.');
		return $this->redirect(array('action' => 'index'));
	}


	public function mass_import_eshe_certifications()
	{

		if (!empty($this->request->data)) {

			//debug($this->request->data);

			if (strcasecmp($this->request->data['CertificationCourseSetting']['xls']['type'], 'application/vnd.ms-excel')) {
				$this->Flash->error( __('Importing Error. Please  save your excel file as "Excel 97-2003 Workbook" type and import again. Current file format is: ' . $this->request->data['CertificationCourseSetting']['xls']['type']));
				return;
			}

			$data = new Spreadsheet_Excel_Reader();
			// Set output Encoding.
			$data->setOutputEncoding('CP1251');
			$data->read($this->request->data['CertificationCourseSetting']['xls']['tmp_name']);

			$non_existing_field = array();
			$created_records = 0;
			$failed_creating_records = 0;
			$updated_records = 0;
			$failed_updating_records = 0;
			$existed_records = 0;
			
			$required_fields = array('studentnumber', 'course_code', 'score', 'status', 'start_date');

			$certificationCourses = ClassRegistry::init('CertificationCourse')->find('list', array('conditions' => array('CertificationCourse.status' => 1), 'fields' => array('CertificationCourse.id', 'CertificationCourse.course_code')));

			if (empty($certificationCourses)) {
				$this->Flash->error( __('Importing Error. No Certification Courses found in the system. Please define it first.'));
				return;
			}
			
			if (empty($data->sheets[0]['cells'])) {
				$this->Flash->error( __('Importing Error. The excel file you uploaded is empty.'));
				return;
			}

			if (empty($data->sheets[0]['cells'][1])) {
				$this->Flash->error(__('Importing Error. Please insert your fieled name (studentnumber, course_code, score, status, start_date) at first row of your excel file.'));
				return;
			}

			for ($k = 0; $k < count($required_fields); $k++) {
				if (in_array($required_fields[$k], $data->sheets[0]['cells'][1]) === FALSE) {
					$non_existing_field[] = $required_fields[$k];
				}
			}

			if (count($non_existing_field) > 0) {
				$field_list = "";
				foreach ($non_existing_field as $k => $v) {
					$field_list .= ($v . ", ");
				}
				$field_list = substr($field_list, 0, (strlen($field_list) - 2));
				$this->Flash->error(__('Importing Error. ' . $field_list . ' is/are required in the excel file you imported at first row.'));
				return;
			} else {

				$fields_name_import_table = $data->sheets[0]['cells'][1];

				$uploadMaps = array();

				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {

					$row_data = array();
					$non_valid_rows = array(); 

					for ($j = 1; $j <= count($fields_name_import_table); $j++) {
						

						if ($fields_name_import_table[$j] == "studentnumber" && isset($data->sheets[0]['cells'][$i][$j]) && trim($data->sheets[0]['cells'][$i][$j]) == "") {
							$non_valid_rows[] = "Please enter a valid student or AMU Student Email number at row number " . $i;
							continue;
						}

						if ($fields_name_import_table[$j] == "course_code" && isset($data->sheets[0]['cells'][$i][$j]) && trim($data->sheets[0]['cells'][$i][$j]) == "") {
							$non_valid_rows[] = "Please enter a valid course_code at row number " . $i;
							continue;
						}

						if ($fields_name_import_table[$j] == "studentnumber" && isset($data->sheets[0]['cells'][$i][$j]) && trim($data->sheets[0]['cells'][$i][$j]) != "") {
							$row_data['studentnumber'] = trim($data->sheets[0]['cells'][$i][$j]);
						}

						if (isset($row_data['studentnumber']) && !empty($row_data['studentnumber']) /* && !in_array($row_data['studentnumber'], array_keys($uploadMaps)) */) {

							if ($fields_name_import_table[$j] == "course_code" && isset($data->sheets[0]['cells'][$i][$j]) && trim($data->sheets[0]['cells'][$i][$j]) != "") {
								$row_data['course_code'] = trim($data->sheets[0]['cells'][$i][$j]);
							}

							if ($fields_name_import_table[$j] == "score" && isset($data->sheets[0]['cells'][$i][$j])) {
								
								$scoreUserInput = trim($data->sheets[0]['cells'][$i][$j]);
								
								if (!empty($scoreUserInput) && stripos($scoreUserInput, 'null') !== false) {
									//echo "score contains 'null' or 'NULL'";
									$row_data['score'] = NULL;
								} else if (is_numeric($scoreUserInput)) {
									$row_data['score'] = $scoreUserInput;
								} else {
									$row_data['score'] = NULL;
								}
							}

							if ($fields_name_import_table[$j] == "status" && isset($data->sheets[0]['cells'][$i][$j])) {
								
								$statusUserInput = trim($data->sheets[0]['cells'][$i][$j]);
								
								if (!empty($statusUserInput) && stripos($statusUserInput, 'null') !== false) {
									//echo "status contains 'null' or 'NULL'";
									$row_data['status'] = 0;
								} else if (!empty($statusUserInput) && stripos($statusUserInput, 'created') !== false) {
									//echo "String contains 'created' ";
									$row_data['status'] = 1;
								} else if (is_numeric($statusUserInput)) {
									$row_data['status'] = $statusUserInput;
								} else {
									$row_data['status'] = 0;
								}

								if (isset($row_data['score']) && is_numeric($row_data['score']) && $row_data['score'] >= DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE) {
									$row_data['status'] = 1;
								}
							}

							if ($fields_name_import_table[$j] == "start_date" && isset($data->sheets[0]['cells'][$i][$j])) {
								
								$startDateUserInput = trim($data->sheets[0]['cells'][$i][$j]);
								
								if (!empty($startDateUserInput) && stripos($startDateUserInput, 'null') !== false) {
									//echo "date contains 'null' or 'NULL'";
									$row_data['start_date'] = NULL;
								} else if (!empty($startDateUserInput)) {
									$dateInput = str_replace([' ', '\\'], '/', $startDateUserInput);

									// Try to parse using DateTime
									$date = DateTime::createFromFormat('n/j/Y', $dateInput); // 'n' and 'j' allow single-digit month/day

									if ($date && $date->format('Y') >= 1900) {
										$row_data['start_date'] = $date->format('Y-m-d');
									} else {
										
										$date = DateTime::createFromFormat('Y-m-d', $dateInput);

										if ($date && $date->format('Y') >= 1900) {
											$row_data['start_date'] = $date->format('Y-m-d');
										} else {
											$row_data['start_date'] = NULL;
										}
									}
								} else {
									$row_data['start_date'] = NULL;
								}
							}
						}
					}

					//debug($non_valid_rows);

					if (empty($non_valid_rows) && isset($row_data['studentnumber']) && !empty($row_data['studentnumber'])) {

						$studentNumberEmail = $row_data['studentnumber'];

						if (strpos($studentNumberEmail, '@') !== false) {
							$parts = explode('@', $studentNumberEmail);
							if (!empty($parts[0])) {
								$studentNumberEmail = str_replace(['.', '-', '_'], '/', $parts[0]);
							}
						}

						$validStudenNumber = preg_match(STUDENT_ID_NUMBER_REGEX_FOR_SEARCH, $studentNumberEmail) === 1;

						if ($validStudenNumber) {

							$student_number_exist = ClassRegistry::init('Student')->find('first', array('conditions' => array('Student.studentnumber' => $studentNumberEmail), 'contain' => array(), 'fields' => array('Student.id', 'Student.id'), 'order' => array('Student.id')));

							if ($student_number_exist) {

								$certification_course_id =  array_search($row_data['course_code'], $certificationCourses);

								if (!empty($student_number_exist) && !empty($certification_course_id)) {
									$uploadMaps[] = array(
										'student_id' => $student_number_exist['Student']['id'],
										'certification_course_id' => $certification_course_id,
										'score' => (isset($row_data['score']) ? $row_data['score'] : NULL),
										'start_date' => (isset($row_data['start_date']) ? $row_data['start_date'] : NULL),
										'status' => (isset($row_data['status']) ? $row_data['status'] : (isset($row_data['score']) && !empty($row_data['score']) && $row_data['score'] >= DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE ? 1 : 0)),
									);
								}
							}
						}
					}
				}

				//debug($uploadMaps);

				if (!empty($uploadMaps)) {

					$rowCount = 1;

					$studentsCertificationCourseModel = ClassRegistry::init('StudentsCertificationCourse');


					foreach ($uploadMaps as $kk => $vv) {

						//check if same exact record exists;
						$exact_same_record_exists = $studentsCertificationCourseModel->find('count', array('conditions' => $vv, 'contain' => array()));

						if (!$exact_same_record_exists) {
							
							$same_course_exists_for_student = $studentsCertificationCourseModel->find('first', array('conditions' => array('StudentsCertificationCourse.student_id' => $vv['student_id'], 'StudentsCertificationCourse.certification_course_id' => $vv['certification_course_id']), 'contain' => array()));
							
							if (!empty($same_course_exists_for_student) && isset($same_course_exists_for_student['StudentsCertificationCourse']['id']) && !empty($same_course_exists_for_student)) {
								//update it
								$vv['id'] = $same_course_exists_for_student['StudentsCertificationCourse']['id'];

								if ($studentsCertificationCourseModel->save($vv)) {
									$updated_records++;
								} else {
									$failed_updating_records++;
								}
								unset($vv['id']);
							} else {
								//create a new record
								$studentsCertificationCourseModel->create();

								if ($studentsCertificationCourseModel->save($vv)) {
									$created_records++;
								} else {
									$failed_creating_records++;
								}
							}
						} else {
							$existed_records++;
						}

						$rowCount++;
					}
				}

				if ($created_records > 0 || $updated_records > 0) {
					$this->Flash->success(($created_records > 0 ? ('Imported ' . $created_records . ($updated_records > 0  ? ' and updated ' . $updated_records : '')) : ($updated_records > 0  ? 'Updated ' . $updated_records : '') . ' records.'));
				} else {
					$this->Flash->info('Nothing to update. all of ' . (isset($existed_records) && $existed_records > 0  ? $existed_records : 'the') . ' uploaded records exist in the system.');
				}
			}
		}
	}

}