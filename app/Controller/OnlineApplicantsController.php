<?php
App::uses('AppController', 'Controller');

class OnlineApplicantsController extends AppController
{

	public $name = 'OnlineApplicants';
	public $menuOptions = array(
		'parent' => 'placement',
		'exclude' => array('search', 'accepted_document', 'get_department_combo','get_campus_department_combo'),
		'alias' => array(
			'new_applicant_requests' => 'New Applicant Requests',
			'index' => 'View Online Request',
			'process_selected' => 'Process Selected'

		)
	);

	var $helpers = array('DatePicker', 'Media.Media');

	public $paginate = array();
	public $components = array('Paginator', 'AcademicYear');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->Allow('get_department_combo', 'edit','new_applicant_requests','accept_document',
        'get_campus_department_combo');
	}
	public function beforeRender()
	{
		parent::beforeRender();
		//$acyear_array_data = $this->AcademicYear->acyear_array();
		$acyear_array_data = $this->AcademicYear->academicYearInArray(date('Y') - 1, date('Y') + 1);



		//	$acyear_array_data = $this->AcademicYear->acyear_array(); //acyear_array
		//To diplay current academic year as default in drop down list
		$defaultacademicyear = $this->AcademicYear->current_academicyear();


		//To diplay current academic year as default in drop down list
		$defaultacademicyear = $this->AcademicYear->current_academicyear();


		if (!empty($this->program_type_id)) {
			$program_types = $programTypes = $this->OnlineApplicant->ProgramType->find(
				'list',
				array(
					'conditions' =>
						array('ProgramType.id' => $this->program_type_id)
				)
			);
		} else {
			$program_types = $programTypes = $this->OnlineApplicant->ProgramType->find('list');
		}
		if (!empty($this->program_id)) {
			$programs = $this->OnlineApplicant->Program->find(
				'list',
				array(
					'conditions' =>
						array('Program.id' => $this->program_id)
				)
			);
		} else {
			$programs = $this->OnlineApplicant->Program->find('list');
		}

		$this->set(
			compact(
				'acyear_array_data',
				'acYearMinuSeparated',
				'defaultacademicyear',
				'program_types',
				'programs',
				'programTypes',
				'defaultacademicyearMinusSeparted'
			)
		);
	}
	/*
	 *Generic search for returned items
	 */
	public function search()
	{
		// the page we will redirect to
		$url['action'] = 'index';

		// build a URL will all the search elements in it
		// the resulting URL will be
		// domain.com/returned_items/index/Search.keywords:mykeyword/Search.tag_id:3
		//debug($this->request->data);
		foreach ($this->request->data as $k => $v) {
			foreach ($v as $kk => $vv) {
				if (is_array($vv)) {
					foreach ($vv as $kkk => $vvv)
						$url[$k . '.' . $kk . '.' . $kkk] = $vvv;
				} else
					$url[$k . '.' . $kk] = $vv;
			}
		}
		// redirect the user to the url
		return $this->redirect($url, null, true);
	}

	public function index()
	{
		$this->paginate = array(

			'maxLimit' => 100,
			'limit' => 100,
			'contain' => array(
				'OnlineApplicantStatus',

				'HigherEducationBackground',
				'HighSchoolEducationBackground',
				'College' => array('Campus'),
				'Program',
				'ProgramType',
				'Department',
				'Invoice'=>array('Transaction'),
				'Attachment'
			),

			'order' => array('OnlineApplicant.full_name' => 'ASC', 'OnlineApplicant.created' => 'DESC')
		);


		debug($this->request->data);
		// Sort

		if (isset($this->request->data['OnlineApplicant']['sort_by']) && !empty($this->request->data['OnlineApplicant']['sort_by'])) {

			$this->paginate['order'] = $this->request->data['OnlineApplicant']['sort_by'];
		}

		if ((isset($this->request->data['OnlineApplicant']) && isset($this->request->data['viewPDF']))) {

			$search_session = $this->Session->read('search_data');
			$this->request->data['OnlineApplicant'] = $search_session;
		}


		if ((isset($this->request->data['OnlineApplicant']) && isset($this->request->data['viewPDF']))) {
			$search_session = $this->Session->read('search_data');
			$this->request->data['OnlineApplicant'] = $search_session;
		}

		if (isset($this->passedArgs)) {
			if (isset($this->passedArgs['page'])) {
				$this->__init_search();
				$this->request->data['OnlineApplicant']['page'] = $this->passedArgs['page'];
				$this->__init_search();
			}
		}



		if ((isset($this->request->data['OnlineApplicant']) && isset($this->request->data['listOnlineApplicant']))) {

			$this->__init_search();
		}

		// limit

		if (isset($this->request->data['OnlineApplicant']['limit']) && !empty($this->request->data['OnlineApplicant']['limit'])) {

			$this->paginate['limit'] = $this->request->data['OnlineApplicant']['limit'];

			$this->paginate['maxLimit'] = $this->request->data['OnlineApplicant']['limit'];
		}
		// filter by name
		if (isset($this->request->data['OnlineApplicant']['name'])) {
			$name = $this->request->data['OnlineApplicant']['name'];
			if (!empty($name)) {
				$this->paginate['conditions'][]['OnlineApplicant.first_name like'] = '%' . $name . '%';
			}
		}


		// filter by department or college

		if (
			isset($this->request->data['OnlineApplicant']['department_id']) &&
			!empty($this->request->data['OnlineApplicant']['department_id'])
		) {

			$department_id = $this->request->data['OnlineApplicant']['department_id'];
			$this->paginate['conditions'][]['OnlineApplicant.department_id'] = $department_id;
		}

		if (
			isset($this->request->data['OnlineApplicant']['academic_year']) &&
			!empty($this->request->data['OnlineApplicant']['academic_year'])
		) {

			$this->paginate['conditions'][]['OnlineApplicant.academic_year'] = $this->request->data['OnlineApplicant']['academic_year'];
		}

		// filter by period

		if (isset($this->request->data['OnlineApplicant']['request_from']['year'])) {
			$this->paginate['conditions'][] = array('OnlineApplicant.created >= \'' . $this->request->data['OnlineApplicant']['request_from']['year'] . '-' . $this->request->data['OnlineApplicant']['request_from']['month'] . '-' . $this->request->data['OnlineApplicant']['request_from']['day'] . '\'');
			$this->paginate['conditions'][] = array('OnlineApplicant.created <= \'' . $this->request->data['OnlineApplicant']['request_to']['year'] . '-' . $this->request->data['OnlineApplicant']['request_to']['month'] . '-' . $this->request->data['OnlineApplicant']['request_to']['day'] . '\'');
		}


		if (isset($this->request->data['OnlineApplicant']['limit']) && !empty($this->request->data['OnlineApplicant']['limit'])) {
			$this->paginate['limit'] = $this->request->data['OnlineApplicant']['limit'];
			$this->paginate['maxLimit'] = $this->request->data['OnlineApplicant']['limit'];
		} else {
			$this->paginate['limit'] = 500;
			$this->paginate['maxLimit'] = 500;
		}




		if (isset($this->request->data['OnlineApplicant']['page']) && !empty($this->request->data['OnlineApplicant']['page'])) {

			$this->paginate['page'] = $this->request->data['OnlineApplicant']['page'];
		}
		$status = '';
		if (
			isset($this->request->data['OnlineApplicant']['statuses']) &&
			!empty($this->request->data['OnlineApplicant']['statuses'])
		) {

			$status = $this->request->data['OnlineApplicant']['statuses'];
		}

		// filter by tracking number
		if (isset($this->request->data['OnlineApplicant']['applicationnumber'])) {

			$trackingnumber = $this->request->data['OnlineApplicant']['applicationnumber'];
			debug($trackingnumber);
			if (!empty($trackingnumber)) {
				unset($this->paginate['conditions']);
				$this->paginate['conditions'][]['OnlineApplicant.applicationnumber'] = $trackingnumber;
			}
		}



		$this->Paginator->settings = $this->paginate;
		debug($this->Paginator->settings);

		if (isset($this->Paginator->settings['conditions'])) {

			$onlineApplicants = $this->Paginator->paginate('OnlineApplicant');
		} else {

			$onlineApplicants = array();
		}
		debug($onlineApplicants);
		if (empty($onlineApplicants) && isset($this->request->data) && !empty($this->request->data)) {

			$this->Session->setFlash('<span></span>' . __('There is no online applicants in the application list based on the given criteria.'), 'default', array('class' => 'info-box info-message'));
		}
		debug(count($onlineApplicants));
		if (isset($onlineApplicants) && !empty($onlineApplicants)) {
			foreach ($onlineApplicants as $k => &$v) {
				$st = '';
				if (isset($status) && !empty($status)) {
					$highest = 0;
					$hindex = 0;
					foreach ($v['OnlineApplicantStatus'] as $onst => $onval) {
						if ($onval['id'] > $highest) {
							$highest = $onval['id'];
							$hindex = $onst;
						}
					}
					if ($highest) {
						$st = $v['OnlineApplicantStatus'][$hindex]['status'];
					}
					if (strcasecmp($status, $st) == 0) {

						$v['OnlineApplicant']['status'] = $st;
						$v['OnlineApplicant']['status_remark'] = $v['OnlineApplicantStatus'][$hindex]['remark'];
					} else {
						unset($onlineApplicants[$k]);
					}
				} else {
					$v['OnlineApplicant']['status'] = $st;
					$v['OnlineApplicant']['status_remark'] = '';
				}
			}
		}


		$programs = $this->OnlineApplicant->Program->find('list');

		$program_types = $this->OnlineApplicant->ProgramType->find('list');

		if ((!empty($this->request->data['OnlineApplicant']) && !empty($this->request->data['viewPDF']))) {
			$onlineapplicant_list_pdf = array();
			//$count = 1;
			//debug($onlineApplicants);
			//die;
			foreach ($onlineApplicants as $k => $v) {
				if (
					isset($v['Program']['name']) && !empty($v['Program']['name']) &&
					isset($v['ProgramType']['name']) && !empty($v['ProgramType']['name']) && isset($v['Department']['name']) && !empty($v['Department']['name'])
				) {
					$onlineapplicant_list_pdf[$v['Program']['name'] . '~' . $v['ProgramType']['name'] . '~' . $v['College']['Campus']['name'] . '~' . $v['College']['name'] . '~' . $v['Department']['name']][] = $v;
					// $count++;

				}
			}

			$this->set(compact('onlineapplicant_list_pdf'));
			$this->response->type('application/pdf');
			$this->layout = '/pdf/default';
			$this->render('onlineapplicantlist_pdf');
		}
        $campuses = ClassRegistry::init('Campus')->find(
            'list',
            array(
                'fields' => array('Campus.id', 'Campus.name')
            )
        );

		$statuses = array('0' => 'All', 'Pending' => 'Pending', 'Accepted' => 'Accepted', 'Rejected' => 'Rejected');
		$this->set(compact('programs', 'campuses', 'onlineApplicants', 'statuses'));
	}
	public function process_selected()
	{
		if (
			!empty($this->request->data)
			&& !empty($this->request->data['processSelected'])
		) {
			$atleast_select_one = array_sum($this->request->data['OnlineApplicant']['approve']);
			if ($atleast_select_one > 0) {
				unset($this->request->data['OnlineApplicant']['SelectAll']);
				$admittedStudentsLists = array();
				$selectedAdmittedCount = 0;
				$dptSearch = $this->Session->read('dptSearch');
				$batchNotDefinedCount=0;
				foreach ($this->request->data['OnlineApplicant']['approve'] as $id => $selected) {

					$checkIfAccepted = ClassRegistry::init('AcceptedStudent')->find(
						'count',
						array(
							'conditions' => array('AcceptedStudent.online_applicant_id' => $id),
							'recursive' => -1
						)
					);

					if ($selected == 1 && $checkIfAccepted == 0) {
						$selected_students[] = $id;
						$basicData = $this->OnlineApplicant->find(
							'first',
							array(
								'conditions' => array('OnlineApplicant.id' => $id),
								'contain' => array('College', 'Department')
							)
						);

						if (!empty($basicData)) {
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['first_name'] = ucwords(strtolower($basicData['OnlineApplicant']['first_name']));
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['middle_name'] = ucwords(strtolower($basicData['OnlineApplicant']['father_name']));
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['last_name'] = ucwords(strtolower($basicData['OnlineApplicant']['grand_father_name']));

							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['sex'] = ucwords(strtolower($basicData['OnlineApplicant']['gender']));

							// amharic name explode
							$amharicNameExplode = mb_split(" ", $basicData['OnlineApplicant']['amharic_fullname']);



							if (isset($amharicNameExplode[0]) && !empty($amharicNameExplode[0])) {
								$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['amharic_first_name'] = $amharicNameExplode[0];
							}

							if (isset($amharicNameExplode[1]) && !empty($amharicNameExplode[1])) {
								$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['amharic_middle_name'] = $amharicNameExplode[1];
							}
							if (isset($amharicNameExplode[2]) && !empty($amharicNameExplode[2])) {
								$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['amharic_last_name'] = $amharicNameExplode[2];
							}



							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['department_id'] = $basicData['OnlineApplicant']['department_id'];
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['program_id'] = $basicData['OnlineApplicant']['program_id'];
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['program_type_id'] = $basicData['OnlineApplicant']['program_type_id'];
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['college_id'] = $basicData['OnlineApplicant']['college_id'];
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['campus_id'] = $basicData['College']['campus_id'];

							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['online_applicant_id'] = $basicData['OnlineApplicant']['id'];


							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['academicyear'] = $basicData['OnlineApplicant']['academic_year'];

							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['nationality'] = $basicData['OnlineApplicant']['nationality'];

							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['zone_id'] = $basicData['OnlineApplicant']['zone_id'];

							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['woreda_id'] = $basicData['OnlineApplicant']['woreda_id'];
							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['region_id'] = $basicData['OnlineApplicant']['region_id'];

							$admittedStudentsLists['AcceptedStudent'][$selectedAdmittedCount]['place_of_birth'] = $basicData['OnlineApplicant']['place_of_birth'];


                        }
						$selectedAdmittedCount++;
					}
				}

				if ($batchNotDefinedCount==0 && ClassRegistry::init('AcceptedStudent')->saveAll($admittedStudentsLists['AcceptedStudent'],
                        array('validate' => 'first'))) {
					$this->Session->setFlash(__('<span></span>All selected students has been ready for in the registrar accepted student list for further processing.'), 'default', array('class' => 'success-box success-message'));
					$this->redirect(array('action' => 'index'));
				} else {
					$error = ClassRegistry::init('AcceptedStudent')->invalidFields();
					debug($error);
					if($batchNotDefinedCount>0){
						$this->Session->setFlash(__('<span></span> '.$batchNotDefinedCount.
                            ' student could not be saved since their batch fee setting is not defined.'), 'default',
                            array('class' => 'error-box error-message'));

					}
					$this->Session->setFlash(__('<span></span>The student could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));

				}
			} else {
				$this->Session->setFlash('<span></span>' . __('Please select atleast one student to process.'), 'default', array('class' => 'error-box error-message'));
				$this->request->data['getacceptedstudent'] = true;

				$this->request->data['OnlineApplicant'] = $this->Session->read('search_data');
			}
		}
		if (!empty($this->request->data) && !empty($this->request->data['getonlineapplicant'])) {

			if (!empty($this->request->data['OnlineApplicant']['academicyear'])) {
				$this->Session->write('dptSearch', $this->request->data['OnlineApplicant']);
				$conditions = null;
				$ssacdemicyear = $this->request->data['OnlineApplicant']['academicyear'];
				$pprogram_id = $this->request->data['OnlineApplicant']['program_id'];
				$pprogram_type_id = $this->request->data['OnlineApplicant']['program_type_id'];
				$name = $this->request->data['OnlineApplicant']['name'];
				$college_ids = array();
				$department_ids = array();
				if (!empty($this->college_ids)) {
					$college_ids = $this->college_ids;
				} elseif (!empty($this->department_ids)) {
					$department_ids = $this->department_ids;
				}
				// retrive list of students based on registrar clerk assigned responsibility
				if (!empty($college_ids)) {
					if (!empty($this->request->data['OnlineApplicant']['college_id'])) {
						$conditions = array(
							"OnlineApplicant.application_status" => 1,
							"OnlineApplicant.academic_year LIKE" => "$ssacdemicyear%",
							"OnlineApplicant.first_name LIKE" => "$name%",
							"OnlineApplicant.college_id" => $this->request->data['OnlineApplicant']['college_id'],
							"OnlineApplicant.program_id" => $pprogram_id,
							"OnlineApplicant.program_type_id" => $pprogram_type_id,
							"OnlineApplicant.id NOT IN (select online_applicant_id from accepted_students where online_applicant_id is not null )",
						);
					} else if (isset($this->request->data['OnlineApplicant']['department_id']) && !empty($this->request->data['OnlineApplicant']['department_id'])) {
						$conditions = array(
							"OnlineApplicant.application_status" => 1,
							"OnlineApplicant.academic_year LIKE" => "$ssacdemicyear%",
							"OnlineApplicant.first_name LIKE" => "$name%",
							"OnlineApplicant.college_id" => $college_ids,
							"OnlineApplicant.program_id" => $pprogram_id,
							"OnlineApplicant.program_type_id" => $pprogram_type_id,
							"OnlineApplicant.department_id" => $this->request->data['OnlineApplicant']['department_id'],
							"OnlineApplicant.id NOT IN (select online_applicant_id from accepted_students where online_applicant_id is not null )",
						);
					}
				} elseif (!empty($department_ids)) {

					if (!empty($this->request->data['OnlineApplicant']['department_id'])) {
						$conditions = array(
							"OnlineApplicant.application_status" => 1,
							"OnlineApplicant.academic_year" => $ssacdemicyear,
							"OnlineApplicant.department_id" => $this->request->data['OnlineApplicant']['department_id'],
							"OnlineApplicant.program_id" => $pprogram_id,
							"OnlineApplicant.program_type_id" => $pprogram_type_id,
							"OnlineApplicant.id NOT IN (select online_applicant_id from accepted_students where online_applicant_id is not null )",

						);
						debug($conditions);
					} else {
						$conditions = array(
							"OnlineApplicant.application_status" => 1,
							"OnlineApplicant.academic_year LIKE" => "$ssacdemicyear%",
							"OnlineApplicant.first_name LIKE" => "$name%",
							"OnlineApplicant.department_id" => $department_ids,
							"OnlineApplicant.program_id" => $pprogram_id,
							"OnlineApplicant.program_type_id" => $pprogram_type_id,
							"OnlineApplicant.id NOT IN (select online_applicant_id from accepted_students where online_applicant_id is not null )",
						);
					}
				}
				//
				if (!empty($conditions)) {
					if (isset($this->request->data['OnlineApplicant']['limit'])) {
						$limit = $this->request->data['OnlineApplicant']['limit'];
					} else {
						$limit = 1800;
					}

					$this->paginate = array(
						'limit' => $limit,
						'maxLimit' => $limit,
						'order' => array('OnlineApplicant.first_name ASC'),
						'contain' => array('Invoice', 'Department', 'College')
					);
					$this->paginate['conditions'] = $conditions;
					$this->Paginator->settings = $this->paginate;
					$onlineApplicants = $this->Paginator->paginate('OnlineApplicant');
					$this->set('onlineApplicants', $onlineApplicants);
					if (!empty($onlineApplicants)) {
						$this->set('admitsearch', true);
					} else {
						$this->Session->setFlash(__('<span></span>There is no applicants who was accepted and required admission. Either all students has been processed or no student is applied online in the given criteria.'), 'default', array('class' => 'info-box info-message'));
					}
					$admitsearch = true;
					$this->request->data['getonlineapplicant'] = true;
				} else {
					$this->Session->setFlash(__('<span></span>You dont have privilage to admit students in the given criteria.'), 'default', array('class' => 'error-box error-message'));
				}
			} else {
				$this->Session->setFlash(__('<span></span>Please select academic  year'), 'default', array('class' => 'error-box error-message'));
			}
		}
		// display the right department and college based on the privilage of registrar users
		if ($this->role_id == ROLE_REGISTRAR || ROLE_REGISTRAR == $this->Session->read('Auth.User')['Role']['parent_id']) {
			$college_ids = array();
			$department_ids = array();

			if (!empty($this->college_ids)) {

				$college_ids = $this->college_ids;

				$colleges = $this->OnlineApplicant->Department->allCollegeByCampus($this->college_ids);

				$departments = $this->OnlineApplicant->Department->find(
					'list',
					array('conditions' => array('Department.college_id' => $college_ids))
				);

				$this->set('college_level', true);
			} elseif (!empty($this->department_ids)) {
				$department_ids = $this->department_ids;

				$departments = $this->OnlineApplicant->Department->find(
					'list',
					array('conditions' => array('Department.id' => $department_ids))
				);
				$colleges = $this->OnlineApplicant->Department->allCollegeByCampus($this->college_ids);

				$this->set('department_level', true);
			}
			//$this->set(compact('colleges'));
		} else {
			//$colleges = $this->OnlineApplicant->Department->allCollegeByCampus($this->college_ids);
			$departments = $this->OnlineApplicant->Department->find('list');
			//$this->set(compact('colleges', 'departments'));
		}




        $campuses=$this->OnlineApplicant->College->Campus->find('list');
		$programs = $this->OnlineApplicant->Program->find('list');
		$programTypes = $this->OnlineApplicant->ProgramType->find('list');
		$this->set(
			compact(
				'programs',
				'programTypes',
                'campuses'
			)
		);
	}


	public function view($id = null)
	{
		if (!$this->OnlineApplicant->exists($id)) {
			throw new NotFoundException(__('Invalid online applicant  request'));
		}
		$options = array(
			'conditions' => array('OnlineApplicant.' . $this->OnlineApplicant->primaryKey => $id),
			'contain' => array(
				'Attachment',
				'Program',
				'ProgramType',
				'Department',
				'College',
				'OnlineApplicantStatus',
				'HigherEducationBackground',
				'HighSchoolEducationBackground',
			)
		);
		$applicant = $onlineApplicant = $this->OnlineApplicant->find('first', $options);

		$this->set(compact('onlineApplicant', 'applicant'));


		//$this->set(compact('statuses'));
	}

	function edit($id = null)
	{
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid weblink'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			
			if (isset($this->request->data['Attachment']) && !empty($this->request->data['Attachment'])) {
				$this->request->data = $this->OnlineApplicant->preparedAttachment($this->request->data);
				debug($this->request->data);
			}

			if($this->OnlineApplicant->HighSchoolEducationBackground->deleteHighSchoolEducationBackgroundForOnlineList($id,$this->request->data)){

			}

			if (
				$this->OnlineApplicant->saveAll(
					$this->request->data,
					array('validate' => 'first')
				)
			) {
				//update accepted student and admitted student if exist
				$studentDD=ClassRegistry::init('AcceptedStudent')->find('first',
					array('conditions'=>array('AcceptedStudent.online_applicant_id'=>$this->OnlineApplicant->id),
						'recursive'=>-1));
				debug($studentDD);
				if(isset($studentDD) && !empty($studentDD)){
					$x=$this->OnlineApplicant->updateAcceptedAdmitted($this->OnlineApplicant->id);
					debug($x);
					/*
					ClassRegistry::init('Student')->saveField('archive'
				  ,'1');
				ClassRegistry::init('AcceptedStudent')->

				  $this->AcceptedStudent->Student->StudentsSection->
				  */

				}




				$this->Session->setFlash('<span></span>' . __("The online applicants has been saved "), 'default', array('class' => 'success-box success-message'));

				//return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The  online applicants could not be saved. Please, try again.'));

				$this->Session->setFlash('<span></span>' . __("The  online applicants could not be saved. Please, try again. "), 'default', array('class' => 'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->OnlineApplicant->read(null, $id);
		}
		$programs = $this->OnlineApplicant->Program->find('list');
		$programTypes = $this->OnlineApplicant->ProgramType->find('list');
		$countries = ClassRegistry::init('Country')->find('list');

		$academicCalendars = ClassRegistry::init('AcademicCalendar')->find(
			'all',
			array(
				'conditions' => array(
					'AcademicCalendar.semester' => $this->request->data['OnlineApplicant']['semester'],
					'AcademicCalendar.academic_year' => $this->request->data['OnlineApplicant']['academic_year']
				)
			)
		);
		//


		if (isset($academicCalendars) && !empty($academicCalendars)) {
			$departmentIds = array();
			$programIds = array();
			$programTypesIds = array();
			foreach ($academicCalendars as $k => $v) {
				$tmp = unserialize($v['AcademicCalendar']['department_id']);
				$departmentIds = array_merge($departmentIds, $tmp);
				$programIds[$v['AcademicCalendar']['program_id']] = $v['AcademicCalendar']['program_id'];
				$programTypesIds[$v['AcademicCalendar']['program_type_id']] = $v['AcademicCalendar']['program_type_id'];
				$acyeardatas[$v['AcademicCalendar']['academic_year']] = $v['AcademicCalendar']['academic_year'];
				$semester[$v['AcademicCalendar']['semester']] = $v['AcademicCalendar']['semester'];
			}

			$academicCalendar['AcademicCalendar']['department_id'] = $departmentIds;
			
			$departments = ClassRegistry::init('Department')->find('list',
				array('conditions' => array('Department.id' => $departmentIds)));
			$college_ids = ClassRegistry::init('Department')->find('list', 
				array('conditions' => array('Department.id' => $departmentIds), 
					'fields' => array('Department.college_id', 'Department.college_id')));

			$colleges_opened_all = ClassRegistry::init('College')->find('all', 
				array('conditions' => array('College.id' => $college_ids),
					'contain'=>array('Campus')
					));
			foreach($colleges_opened_all as $cop=>$cov){
				$colleges_opened[$cov['Campus']['name']][$cov['College']['id']] = $cov['College']['name'];
			}
			debug($colleges_opened);
			$department_opened= ClassRegistry::init('Department')->find('list',
				array('conditions' => array('Department.college_id' =>
					$this->request->data['OnlineApplicant']['college_id'])));
			
			debug($colleges_opened);


			//$colleges = ClassRegistry::init('Department')->allCollegeByCampus($college_ids);
			$programs = ClassRegistry::init('Program')->find(
				'list',
				array('conditions' => array('Program.id' => $programIds))
			);

			$programTypes = ClassRegistry::init('ProgramType')->find(
				'list',
				array('conditions' => array('ProgramType.id' => $programTypesIds))
			);
		}

		$this->set(compact('programs', 'countries', 'programTypes',
			'colleges_opened','department_opened', 'departments'));
	}


	public function delete($id = null)
	{
		$this->OnlineApplicant->id = $id;
		if (!$this->OnlineApplicant->exists()) {
			throw new NotFoundException(__('Invalid online applicant request'));
		}
		$this->request->allowMethod('post', 'delete');

		//check if the online applicant is accepted
		$countAccepted = $this->OnlineApplicant->AcceptedStudent->find(
			'count',
			array('conditions' => array('AcceptedStudent.online_applicant_id' => $id))
		);
		if ($countAccepted == 0) {
			if ($this->OnlineApplicant->delete($id, true)) {

				$this->Session->setFlash('<span></span>' . __('The online applicant request has been deleted.'), 'default', array('class' => 'success-box	success-message'));
			} else {
				$this->Flash->error(__(''));
				$this->Session->setFlash('<span></span>' . __('The online applicant request could not be deleted. Please, try again.'), 'default', array('class' => 'error-box error-message'));
			}
		} else {
			$this->Session->setFlash('<span></span>' . __('The online applicant request could not be deleted since student was admitted.'), 'default', array('class' => 'error-box error-message'));

		}
		return $this->redirect(array('action' => 'index'));
	}

	public function __init_search()
	{
		// We create a search_data session variable when we fill any criteria  in the search form.

		if (!empty($this->request->data['OnlineApplicant'])) {
			$search_session = $this->request->data['OnlineApplicant'];
			$this->Session->write('search_data', $search_session);
		} else {
			$search_session = $this->Session->read('search_data');
			$this->request->data['OnlineApplicant'] = $search_session;
		}
	}

	function get_department_combo($college_id)
	{
		$this->layout = 'ajax';
		$departments = array();

		if (isset($college_id) && !empty($college_id)) {
			$departments = ClassRegistry::init('Department')->find(
				'list',
				array(
					'conditions' => array(
						'Department.college_id' => $college_id
					)
				)
			);
		}

		$this->set(compact('departments'));
	}

	public function accept_document($id = null)
	{
		if (isset($id) && !empty($id)) {
			$this->layout = 'ajax';

			$applicant_details = $this->OnlineApplicant->find(
				'first',
				array(
					'conditions' => array(
						'OnlineApplicant.id' => $id,

					),
					'recursive' => -1
				)
			);
		} else if (isset($this->request->data['updateDocumentStaus']) && !empty($this->request->data['updateDocumentStaus'])) {


			// up on success show them a link to download invoice and settle payment

			$applicantDetail = $this->OnlineApplicant->find(
				'first',
				array(
					'conditions' => array(
						'OnlineApplicant.id' => $this->request->data['OnlineApplicant']['id'],

					),
					'recursive' => -1
				)
			);

			if (isset($this->request->data['OnlineApplicant']) && !empty($this->request->data['OnlineApplicant'])) {
				$this->request->data['OnlineApplicantStatus']['user_id'] = $this->Auth->user('id');
				$this->request->data['OnlineApplicantStatus']['online_applicant_id'] = $this->request->data['OnlineApplicant']['id'];
				if (isset($this->request->data['OnlineApplicant']['remark']) && !empty($this->request->data['OnlineApplicant']['remark'])) {
					$this->request->data['OnlineApplicantStatus']['remark'] = $this->request->data['OnlineApplicant']['remark'];
				} else {
					$this->request->data['OnlineApplicantStatus']['remark'] = 'No remark';
				}


				if ($this->request->data['OnlineApplicant']['document_submitted'] == "Yes") {
					// generate invoice and send email about the payment settlement
					$this->request->data['OnlineApplicantStatus']['status'] = 'Accepted';
				} else {
					// only update the status
					$this->request->data['OnlineApplicantStatus']['status'] = 'Pending';
				}

				debug($this->request->data);



				$this->OnlineApplicant->OnlineApplicantStatus->create();

				if ($this->OnlineApplicant->OnlineApplicantStatus->save($this->request->data['OnlineApplicantStatus'])) {
					//update processed when the status of is document_sent

					$this->OnlineApplicant->id = $this->request->data['OnlineApplicantStatus']['online_applicant_id'];

					if ($this->request->data['OnlineApplicantStatus']['status'] == "Accepted") {
						$request_processed = 1;
					} else {
						$request_processed = 0;
					}

					$trackingUrl = Router::url(
						array(
							'controller' => 'pages',
							'action' => 'online_admission_tracking',
							$applicantDetail['OnlineApplicant']['applicationnumber']
						)
					);
					// check if the appplicant status is complete and send payment for applicant

					if ($request_processed) {

						$invoiceNumberr = $this->OnlineApplicant->Payment->find(
							'first',
							array(
								'conditions' => array(
									'Payment.online_applicant_id' => $applicantDetail['OnlineApplicant']['id']
								)
							)
						);
						$invoiceNumber = $invoiceNumberr['Payment']['receipt_number'];




						$this->OnlineApplicant->saveField(
							'document_submitted',
							$request_processed
						);
						$this->OnlineApplicant->saveField(
							'application_status',
							$request_processed
						);
						$this->OnlineApplicant->saveField(
							'approved_by',
							$this->Auth->user('full_name')
						);
					}


					$message = "Your online application status has been updated and please check  the most recent status using your application  number  <u> <a href='" . $trackingUrl . "' > " . $applicantDetail['OnlineApplicant']['applicationnumber'] . "</a></u>  <br/> ";
					/*


																																										  $Email = new CakeEmail();
																																										  $Email->config('default');
																																										  $Email->template('status_notification', 'default');
																																										  $Email->emailFormat('html');
																																										  $emailFrom = Configure::read('Email.default.replyTo');
																																										  $portalName = Configure::read('portalName');

																																										  $Email->from(array($emailFrom => $portalName));
																																										  $Email->to($applicantDetail['OnlineApplicant']['email']);

																																										  $Email->subject('Online Unity University Applicant Status Updated: ' . $applicantDetail['OnlineApplicant']['first_name'] . ' ' . $applicantDetail['OnlineApplicant']['father_name'] . ' for ' . $applicantDetail['OnlineApplicant']['academic_year'] . '');
																																										  $Email->viewVars(array('message' => $message, 'applicantDetail' => $applicantDetail));
																																										  $Email->delivery = 'smtp';

																																										  try {
																																											  if ($Email->send()) {
																																												  $this->Session->setFlash('<span></span>' . __("Status updated and notification sent to " . $applicantDetail['OnlineApplicant']['email'] . " email address. "), 'default', array('class' => 'success-box success-message'));
																																											  } else {
																																												  $this->Session->setFlash('<span></span>' . __("Status updated but unable to send notification to . "), 'default', array('class' => 'success-box success-message'));
																																											  }
																																										  } catch (Exception $e) {
																																											  $this->Session->setFlash('<span></span>' . __("Someting went wrong when sending notification  to " . $applicantDetail['OnlineApplicant']['email'] . " email address."), 'default', array('class' => 'success-box success-message'));
																																											  //return $this->redirect(array('action' => 'index'));
																																										  }
																																										  */
					$this->Session->setFlash('<span></span>' . __("Someting went wrong when sending notification  to " . $applicantDetail['OnlineApplicant']['email'] . " email address."), 'default', array('class' => 'success-box success-message'));

					return $this->redirect(array('action' => 'new_applicant_requests'));
				} else {
					$error = $this->OnlineApplicant->OnlineApplicantStatus->invalidFields();
					debug($error);
					$this->Session->setFlash('<span></span>' . __('The online applicant status could not be saved. Please, try again.'), 'default', array('class' => 'error-box success-message'));
				}
			}
			return $this->redirect(array('action' => 'new_applicant_requests'));
		}

		$this->set(
			compact(
				'applicant_details'

			)
		);
		//return $this->redirect(array('action' => 'index'));
	}

	public function new_applicant_requests()
	{
		$this->paginate = array(

			'maxLimit' => 100,
			'limit' => 100,
			'contain' => array(
				'OnlineApplicantStatus' => array('User'),

				'HigherEducationBackground',
				'HighSchoolEducationBackground',
				'Attachment',
				'Country',
				'Region',
				'Invoice'=>array(
                    'order' => 'Invoice.created DESC',
                    'Transaction'=>array('PaymentMethod',
                    'PaymentCurrency')
                ),
				'College' => array('Campus'),
				'Program',
				'ProgramType',
				'Department'
			),

			'order' => array(
                'OnlineApplicant.full_name' => 'ASC',
				'OnlineApplicant.created' => 'DESC'
			)
		);
		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		if(isset($defaultacademicyear) && !empty($defaultacademicyear)){
			$this->paginate['conditions'][]['OnlineApplicant.academic_year'] = $defaultacademicyear;

		}

		if (!empty($this->department_ids)) {
			$this->paginate['conditions'][]['OnlineApplicant.department_id'] = $this->department_ids;
		} else if (!empty($this->college_ids)) {
			$this->paginate['conditions'][]['OnlineApplicant.college_id'] = $this->college_ids;
		}


		if (isset($this->request->data['OnlineApplicant']['limit']) && !empty($this->request->data['OnlineApplicant']['limit'])) {

			$this->paginate['limit'] = $this->request->data['OnlineApplicant']['limit'];

			$this->paginate['maxLimit'] = $this->request->data['OnlineApplicant']['limit'];
		}

		$this->paginate['conditions'][]=[
            'OnlineApplicant.approved_by' => null
        ];
        $this->paginate['conditions'][]['OnlineApplicant.application_status'] = 0;
		$this->paginate['conditions'][]['OnlineApplicant.document_submitted'] = 0;
		$this->Paginator->settings = $this->paginate;

		if (isset($this->Paginator->settings['conditions'])) {

			$applicant_lists = $this->Paginator->paginate('OnlineApplicant');
		} else {

			$applicant_lists = array();
		}


		if (empty($applicant_lists) && isset($this->request->data) && !empty($this->request->data)) {

			$this->Session->setFlash('<span></span>' . __('There is no new registered applicant.'), 'default', array('class' => 'info-box info-message'));
		}


		$this->set(compact('applicant_lists', 'statuses'));
	}

    function get_campus_department_combo()
    {
        $this->layout = 'ajax';
        $departments = array();
        debug($this->request->data);
        if (isset($this->request->data['OnlineApplicant']) && !empty($this->request->data['OnlineApplicant'])) {

            if(isset($this->request->data['OnlineApplicant']['campus_id']) &&
                !empty($this->request->data['OnlineApplicant']['campus_id'])){
                $allCollegeIds=ClassRegistry::init('College')->find('list',
                    array('conditions' => array('College.campus_id' =>
                        $this->request->data['OnlineApplicant']['campus_id']),

                        'fields' => array('College.id', 'College.id')));
                $allDeptInAdmission=$this->OnlineApplicant->find('list',
                    array('conditions' => array('OnlineApplicant.college_id' =>$allCollegeIds),

                        'fields' => array('OnlineApplicant.department_id', 'OnlineApplicant.department_id')));
                $departments=ClassRegistry::init('Department')->find('list',
                    array('conditions' => array('Department.id' =>
                        $allDeptInAdmission
                    ), 'fields' => array('Department.id', 'Department.name')));
            }
        }
        $this->set(compact('departments'));
    }

}