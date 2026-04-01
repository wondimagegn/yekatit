<?php
class GraduateListsController extends AppController {

	public $name = 'GraduateLists';
	public $helpers = array('Media.Media');
	public $components =array('EthiopicDateTime','AcademicYear');
	var $menuOptions = array(
		'parent' => 'graduation',
		'weight'=>2,
		'exclude' => array('search', 'delete', 'graduation_certificate', 'to_whom_it_may_concern', 'language_proficiency', 'temporary_degree','mass_certificate_print','check_graduate'),
		'alias' => array(
			'index' => 'View Graduates',
			'add' => 'Prepare Graduate List'
		)
	);
	public $paginate=array();
		
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('search','check_graduate');
	}
     
    public function beforeRender() {
		$acyear_array_data = $this->AcademicYear->acyear_array();
		//To diplay current academic year as default in drop down list
		$defaultacademicyear=$this->AcademicYear->current_academicyear();
		
		$this->set(compact('acyear_array_data','defaultacademicyear'));
		unset($this->request->data['User']['password']);
	}


	 /*
	 *Generic search for returned items
	 */
	 function search() {
		// the page we will redirect to
		$url['action'] = 'index';
		
		// build a URL will all the search elements in it
		// the resulting URL will be 
		// domain.com/returned_items/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->request->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				if(is_array($vv)) {
					foreach($vv as $kkk => $vvv)
						$url[$k.'.'.$kk.'.'.$kkk] = $vvv;
				}
				else
					$url[$k.'.'.$kk]=$vv;
			} 
		}
		// redirect the user to the url
		return $this->redirect($url, null, true);
	}
	
	public function index() {
		$this->paginate = array('limit' => 100);
		$this->paginate = array('contain'=>array('Student' => array('order' => array('Student.first_name ASC', 'Student.middle_name ASC', 'Student.last_name ASC'), 'Department', 'Curriculum', 'ProgramType', 'Program', 'StudentExamStatus' => array('order' => array('StudentExamStatus.created DESC')))));
		//$this->paginate['reset']=false;
		// filter by department or college
		if (isset($this->passedArgs['GraduateList.department_id']) && !empty($this->passedArgs['GraduateList.department_id'])) {
			$department_id = $this->passedArgs['GraduateList.department_id'];
			$college_id = explode('~', $department_id);
			if(count($college_id) > 1)
				$this->paginate['conditions'][]['Student.college_id'] = $college_id[1];
			else
				$this->paginate['conditions'][]['Student.department_id'] = $department_id;
			// set the Search data, so the form remembers the option
			$this->request->data['GraduateList']['department_id'] = $this->passedArgs['GraduateList.department_id'];
			}
		
		// filter by program 
		if (isset($this->passedArgs['GraduateList.program_id']) && !empty($this->passedArgs['GraduateList.program_id'])) {
			$this->paginate['conditions'][]['Student.program_id'] = $this->passedArgs['GraduateList.program_id'];
			//set the Search data, so the form remembers the option
			$this->request->data['GraduateList']['program_id'] = $this->passedArgs['GraduateList.program_id'];
		}
		
		// filter by program type
		if (isset($this->passedArgs['GraduateList.program_type_id']) && !empty($this->passedArgs['GraduateList.program_type_id'])) {
			$this->paginate['conditions'][]['Student.program_type_id'] = $this->passedArgs['GraduateList.program_type_id'];
			//set the Search data, so the form remembers the option
			$this->request->data['GraduateList']['program_type_id'] = $this->passedArgs['GraduateList.program_type_id'];
		}

		// filter by minute number
		if (isset($this->passedArgs['GraduateList.minute_number']) && !empty($this->passedArgs['GraduateList.minute_number'])) {
			$this->paginate['conditions'][]['GraduateList.minute_number'] = $this->passedArgs['GraduateList.minute_number'];
			//set the Search data, so the form remembers the option
			$this->request->data['GraduateList']['minute_number'] = $this->passedArgs['GraduateList.minute_number'];
		}

		// filter by period
		if(isset($this->passedArgs['GraduateList.graduate_date_from.year'])) {
			$this->paginate['conditions'][] = array('GraduateList.graduate_date >= \''.$this->passedArgs['GraduateList.graduate_date_from.year'].'-'.$this->passedArgs['GraduateList.graduate_date_from.month'].'-'.$this->passedArgs['GraduateList.graduate_date_from.day'].'\'');
			$this->paginate['conditions'][] = array('GraduateList.graduate_date <= \''.$this->passedArgs['GraduateList.graduate_date_to.year'].'-'.$this->passedArgs['GraduateList.graduate_date_to.month'].'-'.$this->passedArgs['GraduateList.graduate_date_to.day'].'\'');
			//set the Search data, so the form remembers the option
			$this->request->data['GraduateList']['graduate_date_from']['year'] = $this->passedArgs['GraduateList.graduate_date_from.year'];
			$this->request->data['GraduateList']['graduate_date_from']['month'] = $this->passedArgs['GraduateList.graduate_date_from.month'];
			$this->request->data['GraduateList']['graduate_date_from']['day'] = $this->passedArgs['GraduateList.graduate_date_from.day'];
		
			$this->request->data['GraduateList']['graduate_date_to']['year'] = $this->passedArgs['GraduateList.graduate_date_to.year'];
			$this->request->data['GraduateList']['graduate_date_to']['month'] = $this->passedArgs['GraduateList.graduate_date_to.month'];
			$this->request->data['GraduateList']['graduate_date_to']['day'] = $this->passedArgs['GraduateList.graduate_date_to.day'];
		}
		$this->Paginator->settings=$this->paginate;
	    if(!empty($this->Paginator->settings['conditions'])) {
			$graduateLists= $this->Paginator->paginate('GraduateList');  
		}
		else {
			$graduateLists= array();
		}
		
		if (empty($graduateLists) && isset($this->passedArgs) && !empty($this->passedArgs)) {
			$this->Session->setFlash('<span></span>'.__('There is no student in the graduate list based on 
			the given criteria.', true),'default',array('class'=>'info-box info-message'));
		}
	   $programs = $this->GraduateList->Student->Program->find('list');
		$program_types = $this->GraduateList->Student->ProgramType->find('list');
		$departments = $this->GraduateList->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Students') + $departments;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		
$this->set(compact('programs', 'program_types', 'departments', 'default_department_id', 'default_program_id', 'default_program_type_id', 'graduateLists'));
	}
	
	function add($department_id = null, $program_id = null, $program_type_id = null) {
		$programs = $this->GraduateList->Student->Program->find('list');
		$program_types = $this->GraduateList->Student->ProgramType->find('list');
		$departments = $this->GraduateList->Student->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids);
		$program_types = array(0 => 'All Program Types') + $program_types;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		//When any of the button is clicked (List students or Add to Graduate List)
		if(isset($this->request->data) && !empty($this->request->data)) {
			
			$students_for_graduate_list = $this->GraduateList->getListOfStudentsForGraduateList(
			$this->request->data['GraduateList']['program_id'], $this->request->data['GraduateList']['program_type_id'],
			 $this->request->data['GraduateList']['department_id']);
			$default_department_id = $this->request->data['GraduateList']['department_id'];
			$default_program_id = $this->request->data['GraduateList']['program_id'];
			$default_program_type_id = $this->request->data['GraduateList']['program_type_id'];
		}
		else if(!empty($department_id) && !empty($program_id)) {
			$students_for_graduate_list = $this->GraduateList->getListOfStudentsForGraduateList($program_id, $program_type_id, $department_id);
			$default_department_id = $department_id;
			$default_program_id = $program_id;
			$default_program_type_id = $program_type_id;
		}
		//debug($students_for_graduate_list);
		if(isset($this->request->data) && isset($this->request->data['addStudentToGraduateList'])) {
			//debug($this->request->data);
			if(trim($this->request->data['GraduateList']['minute_number']) == "") {
				$this->Session->setFlash('<span></span>'.__('Please enter minute number.'), 'default',array('class'=>'error-box error-message'));
			}
			else {
				$graduate_list = array();
				$deactivateAccount=array();
				$studentIdForSectionArchive=array();
				$count=0;
				foreach($this->request->data['Student'] as $key => $student) {
					if($student['include_graduate'] == 1) {
						$sl_count = $this->GraduateList->find('count', array('conditions' => array('GraduateList.student_id' => $student['id'])));
						if($sl_count == 0) {
							$sl_index = count($graduate_list);
							$graduate_list[$sl_index]['student_id'] = $student['id'];
							$graduate_list[$sl_index]['minute_number'] = trim($this->request->data['GraduateList']['minute_number']);
							$graduate_list[$sl_index]['graduate_date'] = $this->request->data['GraduateList']['graduate_date']['year'].'-'.$this->request->data['GraduateList']['graduate_date']['month'].'-'.$this->request->data['GraduateList']['graduate_date']['day'];
					$studentDetail=
					$this->GraduateList->Student->find('first',
					 array('conditions'=>
					 array('Student.id' => $student['id'])));
							// deactivate account if exist
							if(isset($studentDetail['Student']['user_id']) && !empty($studentDetail['Student']['user_id'])){
							 $deactivateAccount['User'][$count]['id']=$studentDetail['Student']['user_id'];
							   $deactivateAccount['User'][$count]['active']=0;
							}
							//archive section 
							if(isset($studentDetail['Student']['id']) && !empty($studentDetail['Student']['id'])){
							$studentIdForSectionArchive[$studentDetail['Student']['id']]=$studentDetail['Student']['id'];

							
							}
							$count++;
						}
					}
				}
				if(empty($graduate_list)) {
					$this->Session->setFlash('<span></span>'.__('You are required to select at least one student to be included in the graduate list.'), 'default',array('class'=>'error-box error-message'));
				}
				else {
					if($this->GraduateList->saveAll($graduate_list, array('validate'=>false))) {
						$this->Session->setFlash('<span></span>'.__(count($graduate_list).' students are included in the graduate list.'), 'default',array('class'=>'success-box success-message'));
						//archiveSection
						if(isset($studentIdForSectionArchive) && !empty($studentIdForSectionArchive)){
						 $sectionDeactivate=$this->GraduateList->query("UPDATE students_sections SET archive = 1 WHERE student_id in (".join(', ',$studentIdForSectionArchive).") ");
						}
						//deactivateAccount
						if(ClassRegistry::init('User')->saveAll($deactivateAccount['User'],array('validate'=>false))){
						}
						
				
						return $this->redirect(array('action' => 'add', $this->request->data['GraduateList']['department_id'], $this->request->data['GraduateList']['program_id'], $this->request->data['GraduateList']['program_type_id']));
					}
					else {
						$this->Session->setFlash('<span></span>'.__('The system unable to include the selected students in the graduate list. Please try again.'), 'default',array('class'=>'error-box error-message'));
					}
				}
			}
		}
		$this->set(compact('programs', 'program_types', 'departments', 'students_for_graduate_list', 'default_department_id', 'default_program_id', 'default_program_type_id'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid graduate list'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->GraduateList->save($this->request->data)) {
				$this->Session->setFlash(__('The graduate list has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The graduate list could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GraduateList->read(null, $id);
		}
		$students = $this->GraduateList->Student->find('list');
		$this->set(compact('students'));
	}

	function delete($id = null) {
		$this->GraduateList->id = $id;
		if (!$id || !$this->GraduateList->exists($id)) {
			$this->Session->setFlash('<span></span>'.__('Invalid graduate list'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$graduate_detail = $this->GraduateList->find('first', 
			array(
				'conditions' =>
				array(
					'GraduateList.id' => $id
				),
				'contain' =>
				array(
					'Student'
				)
			)
		);
		if(!in_array($graduate_detail['Student']['department_id'], $this->department_ids)) {
			$this->Session->setFlash('<span></span>'.__('You do not have privilege to manage the selected student records.'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$valid_deletion_time = 
		date('Y-m-d H:i:s', mktime(substr($graduate_detail['GraduateList']['created'],11 ,2), 
		substr($graduate_detail['GraduateList']['created'],14 ,2), 
		substr($graduate_detail['GraduateList']['created'],17 ,2), 
		substr($graduate_detail['GraduateList']['created'],5 ,2), 
		substr($graduate_detail['GraduateList']['created'],8 ,2) + 
		Configure::read('Calendar.daysAvaiableForGraduateDeletion'), 
		substr($graduate_detail['GraduateList']['created'],0 ,4)));
		if($valid_deletion_time < date('Y-m-d')) {
			$this->Session->setFlash('<span></span>'.__('You can not delete the record as it is an archive.'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		else {
			if ($this->GraduateList->delete($id)) {
				$this->Session->setFlash('<span></span>'.__('<u>'.$graduate_detail['Student']['full_name'].'</u> is successfully removed from the graduate list'), 'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action'=>'index'));
			}
		}
		$this->Session->setFlash('<span></span>'.__('<u>'.$graduate_detail['Student']['full_name'].'</u> is not removed from the graduate list. Please try again.'), 'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	
	function temporary_degree($student_id = null) {
		$temporary_degree = null;
		if(!empty($this->request->data['displayTemporaryDegreePrint']) && !empty($this->request->data['GraduateList']['id']))
			$student_id = $this->request->data['GraduateList']['id'];
		if(!empty($student_id) || !empty($this->request->data['continueTemporaryDegreePrint'])) {
			//Check if the user has privilege to print the student temporary degree
			if(!empty($this->request->data['GraduateList']['studentnumber']) && !empty($this->request->data['continueTemporaryDegreePrint'])) {
				if(trim($this->request->data['GraduateList']['studentnumber']) == "") {
					$this->Session->setFlash('<span></span>'.__('Please enter student ID.'), 'default', array('class'=>'error-box error-message'));
					return $this->redirect(array('action' => 'temporary_degree'));
				}
				else {
					$student_detail = $this->GraduateList->Student->find('first',
						array(
							'conditions' =>
							array(
								'Student.studentnumber' => $this->request->data['GraduateList']['studentnumber']
							),
							'contain' =>
							array(
								'GraduateList'
							)
						)
					);
					if(isset($student_detail['Student']['id'])) {
						$costShares = $this->GraduateList->Student->CostShare->find('all',
							array(
								'conditions' =>
								array(
									'CostShare.student_id' => $student_detail['Student']['id']
								),
								'recursive' => -1,
								'order' =>
								array(
									'CostShare.cost_sharing_sign_date ASC'
								)
							)
						);
						$costSharingPayments = $this->GraduateList->Student->CostSharingPayment->find('all',
							array(
								'conditions' =>
								array(
									'CostSharingPayment.student_id' => $student_detail['Student']['id']
								),
								'recursive' => -1,
								'order' =>
								array(
									'CostSharingPayment.created ASC'
								)
							)
						);
						$clearances = $this->GraduateList->Student->Clearance->find('all',
							array(
								'conditions' =>
								array(
									'Clearance.student_id' => $student_detail['Student']['id'],
									'Clearance.type' => 'clearance',
									'Clearance.confirmed' => 1
								),
								'recursive' => -1,
								'order' =>
								array(
									'Clearance.request_date ASC'
								)
							)
						);
					}
				}
			}
			else {
				$student_detail = $this->GraduateList->Student->find('first',
					array(
						'conditions' =>
						array(
							'Student.id' => $student_id
						),
						'contain' =>
						array(
							'GraduateList'
						),
					)
				);
			}
			if(empty($student_detail)) {
				$this->Session->setFlash('<span></span>'.__('Please enter a valid student ID.'), 'default', array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => 'temporary_degree'));
			}
			else if(!empty($student_detail['Student']['department_id']) && !in_array($student_detail['Student']['department_id'], $this->department_ids)) {
				if(!empty($student_detail['Student']['department_id'])) {
					$department_name = $this->GraduateList->CourseRegistration->Student->Department->field('name', 
						array(
							'Department.id' => $student_detail['Student']['department_id']
						)
					);
					$department_name .= ' Department';
				}
				else {
					$department_name = $this->GraduateList->CourseRegistration->Student->College->field('name', 
						array(
							'College.id' => $student_detail['Student']['college_id']
						)
					);
					$department_name .= ' Freshman Program';
				}
				
				$this->Session->setFlash('<span></span>'.__('You do not have privilege to manage '.$department_name.' students. Please contact the registrar system administrator to get privilege on '.$department_name.'.'), 'default', array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => 'temporary_degree'));
			}
			else{
				//Retrieve and pass student cost sharing, clearance, billing and other credits
				if(empty($student_detail['GraduateList']) || $student_detail['GraduateList']['id'] == "") {
					$this->Session->setFlash('<span></span>'.__($student_detail['Student']['full_name'].' is not graduated to display '.(strcasecmp($student_detail['Student']['gender'], 'male') == 0 ? 'his' : 'her').' temporary degree.'), 'default', array('class'=>'error-box error-message'));
				}
				else {
					$temporary_degree = $this->GraduateList->temporaryDegree($student_detail['Student']['id']);
					if(isset($this->request->data['displayTemporaryDegreePrint']) && isset($this->request->data['GraduateList']['id'])) {
						$this->set(compact('temporary_degree'));
						
$this->response->type('application/pdf');
 		$this->layout = '/pdf/default';
						$this->render('temporary_degree_pdf');
					}
				}
			}
		}
		$this->set(compact('temporary_degree', 'costShares', 'costSharingPayments', 'clearances'));
	}

	function language_proficiency($student_id = null) {
		$this->_graduation_letter($student_id, 1);
	}
	
	function to_whom_it_may_concern($student_id = null) {
		$this->_graduation_letter($student_id, 0);
	}
	
	private function _graduation_letter($student_id = null, $language_proficiency = null) {
		$graduation_letter = null;
		if(isset($this->request->data['displayLanguageProficiencyLetterPrint']) && isset($this->request->data['GraduateList']['id']))
			$student_id = $this->request->data['GraduateList']['id'];
		if(isset($student_id) || isset($this->request->data['continueLanguageProficiencyLetterPrint'])) {
			//Check if the user has privilege to print the student graduation certificate
			if(isset($this->request->data['GraduateList']['studentnumber']) && isset($this->request->data['continueLanguageProficiencyLetterPrint'])) {
				if(trim($this->request->data['GraduateList']['studentnumber']) == "") {
					$this->Session->setFlash('<span></span>'.__('Please enter student ID.'), 'default', array('class'=>'error-box error-message'));
					return $this->redirect(array('action' => ($language_proficiency == 1 ? 'language_proficiency' : 'to_whom_it_may_concern')));
				}
				else {
					$student_detail = $this->GraduateList->Student->find('first',
						array(
							'conditions' =>
							array(
								'Student.studentnumber' => $this->request->data['GraduateList']['studentnumber']
							),
							'contain' =>
							array(
								'GraduateList',
								'Program',
								'ProgramType'
							)
						)
					);
				}
			}
			else {
				$student_detail = $this->GraduateList->Student->find('first',
					array(
						'conditions' =>
						array(
							'Student.id' => $student_id
						),
						'contain' =>
						array(
							'GraduateList',
							'Program',
							'ProgramType'
						),
					)
				);
			}
			if(empty($student_detail)) {
				$this->Session->setFlash('<span></span>'.__('Please enter a valid student ID.'), 'default', array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => ($language_proficiency == 1 ? 'language_proficiency' : 'to_whom_it_may_concern')));
			}
			else if(!empty($student_detail['Student']['department_id']) && !in_array($student_detail['Student']['department_id'], $this->department_ids)) {
				if(!empty($student_detail['Student']['department_id'])) {
					$department_name = $this->GraduateList->CourseRegistration->Student->Department->field('name', 
						array(
							'Department.id' => $student_detail['Student']['department_id']
						)
					);
					$department_name .= ' Department';
				}
				else {
					$department_name = $this->GraduateList->CourseRegistration->Student->College->field('name', 
						array(
							'College.id' => $student_detail['Student']['college_id']
						)
					);
					$department_name .= ' Freshman Program';
				}
				
				$this->Session->setFlash('<span></span>'.__('You do not have privilege to manage '.$department_name.' students. Please contact the registrar system administrator to get privilege on '.$department_name.'.'), 'default', array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => ($language_proficiency == 1 ? 'language_proficiency' : 'to_whom_it_may_concern')));
			}
			else{
				//Retrieve and pass student cost sharing, clearance, billing and other credits
				if(empty($student_detail['GraduateList']) || $student_detail['GraduateList']['id'] == "") {
					$this->Session->setFlash('<span></span>'.__($student_detail['Student']['full_name'].' is not graduated to display '.(strcasecmp($student_detail['Student']['gender'], 'male') == 0 ? 'his' : 'her').' '.($language_proficiency == 1 ? '<u>language proficiency</u>' : '<u>to whom it may concern</u>').' letter.'), 'default', array('class'=>'error-box error-message'));

				}
				else {
					$graduation_letter_template = ClassRegistry::init('GraduationLetter')->getGraduationLetter($student_detail['Student']['id'], $language_proficiency);
					/*$graduation_letter_template = ClassRegistry::init('GraduationLetter')->find('first', 
						array(
							'conditions' =>
							array(
								'GraduationLetter.program_id' => $student_detail['Student']['program_id'],
								'GraduationLetter.program_type_id' => $student_detail['Student']['program_type_id'],
								'GraduationLetter.type' => ($language_proficiency == 1 ? 'Language Proficiency' : 'To Whom It May Concern'),
							),
							'recursive' => -1
						)
					);*/
					$graduation_letter = $this->GraduateList->temporaryDegree($student_detail['Student']['id']);
					if(isset($this->request->data['displayLanguageProficiencyLetterPrint']) && isset($this->request->data['GraduateList']['id'])) {
						$e_day = $this->EthiopicDateTime->GetEthiopicDay(date('j'), date('n'), date('Y'));
						$e_month = $this->EthiopicDateTime->GetEthiopicMonth(date('j'), date('n'), date('Y'));
						$e_year = $this->EthiopicDateTime->GetEthiopicYear(date('j'), date('n'), date('Y'));
						$e_month_name = $this->EthiopicDateTime->GetEthiopicMonthName(date('j'), date('n'), date('Y'));
						$g_d = $graduation_letter['student_detail']['GraduateList']['graduate_date'];
						$e_g_day = $this->EthiopicDateTime->GetEthiopicDay(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
						$e_g_month = $this->EthiopicDateTime->GetEthiopicMonth(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
						$e_g_year = $this->EthiopicDateTime->GetEthiopicYear(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
						$e_g_month_name = $this->EthiopicDateTime->GetEthiopicMonthName(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
			
			$graduate_date = date('d F, Y', 
				mktime(0, 0, 0, 
					substr($graduation_letter['student_detail']['GraduateList']['graduate_date'],5 ,2), 
					substr($graduation_letter['student_detail']['GraduateList']['graduate_date'],8 ,2), 
					substr($graduation_letter['student_detail']['GraduateList']['graduate_date'],0 ,4)
				)
			);
						
						$this->set(compact('graduation_letter', 'graduation_letter_template', 'e_day', 'e_month', 'e_year', 'e_month_name', 'e_g_day', 'e_g_month', 'e_g_year', 'e_g_month_name', 'graduate_date'));
						
				$this->response->type('application/pdf');
 		$this->layout = '/pdf/default';
						$this->render('graduation_letter_pdf');
					}
				}
			}
		}
		if(isset($student_detail) && !empty($student_detail)) {
			$graduation_letter_template = ClassRegistry::init('GraduationLetter')->getGraduationLetter($student_detail['Student']['id'], $language_proficiency);
			/*$graduation_letter_template = ClassRegistry::init('GraduationLetter')->find('first', 
				array(
					'conditions' =>
					array(
						'GraduationLetter.program_id' => $student_detail['Student']['program_id'],
						'GraduationLetter.program_type_id' => $student_detail['Student']['program_type_id'],
						'GraduationLetter.type' => ($language_proficiency == 1 ? 'Language Proficiency' : 'To Whom It May Concern'),
					),
					'recursive' => -1
				)
			);*/
			if(empty($graduation_letter_template)) {
				$this->Session->setFlash('<span></span>'.__('The system unable to find template for '.($language_proficiency == 1 ? '<u>language proficiency</u>' : '<u>to whom it may concern</u>').' letter. Please first record language proficiency letter template for '.$student_detail['Program']['name'].' program and '.$student_detail['ProgramType']['name'].' program type.'), 'default', array('class'=>'error-box error-message'));
			}
		}
		$this->set(compact('graduation_letter', 'graduation_letter_template'));
		$this->render(($language_proficiency == 1 ? 'language_proficiency' : 'to_whom_it_may_concern'));
	}

	function graduation_certificate($student_id = null) {
		$graduation_certificate = null;
		if(isset($this->request->data['displayGraduationCertificatePrint']) && isset($this->request->data['GraduateList']['id']))
			$student_id = $this->request->data['GraduateList']['id'];
		if(isset($student_id) || isset($this->request->data['continueGraduationCertificatePrint'])) {
			//Check if the user has privilege to print the student graduation certificate
			if(isset($this->request->data['GraduateList']['studentnumber']) && isset($this->request->data['continueGraduationCertificatePrint'])) {
				if(trim($this->request->data['GraduateList']['studentnumber']) == "") {
					$this->Session->setFlash('<span></span>'.__('Please enter student ID.'), 'default', array('class'=>'error-box error-message'));
					return $this->redirect(array('action' => 'graduation_certificate'));
				}
				else {
					$student_detail = $this->GraduateList->Student->find('first',
						array(
							'conditions' =>
							array(
								'Student.studentnumber' => $this->request->data['GraduateList']['studentnumber']
							),
							'contain' =>
							array(
								'GraduateList',
								'Program',
								'ProgramType'
							)
						)
					);
				}
			}
			else {
				$student_detail = $this->GraduateList->Student->find('first',
					array(
						'conditions' =>
						array(
							'Student.id' => $student_id
						),
						'contain' =>
						array(
							'GraduateList',
							'Program',
							'ProgramType'
						),
					)
				);
			}
			if(empty($student_detail)) {
				$this->Session->setFlash('<span></span>'.__('Please enter a valid student ID.'), 'default', array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => 'graduation_certificate'));
			}
			else if(!empty($student_detail['Student']['department_id']) && !in_array($student_detail['Student']['department_id'], $this->department_ids)) {
				if(!empty($student_detail['Student']['department_id'])) {
					$department_name = $this->GraduateList->CourseRegistration->Student->Department->field('name', 
						array(
							'Department.id' => $student_detail['Student']['department_id']
						)
					);
					$department_name .= ' Department';
				}
				else {
					$department_name = $this->GraduateList->CourseRegistration->Student->College->field('name', 
						array(
							'College.id' => $student_detail['Student']['college_id']
						)
					);
					$department_name .= ' Freshman Program';
				}
				
				$this->Session->setFlash('<span></span>'.__('You do not have privilege to manage '.$department_name.' students. Please contact the registrar system administrator to get privilege on '.$department_name.'.'), 'default', array('class'=>'error-box error-message'));
				return $this->redirect(array('action' => 'graduation_certificate'));
			}
			else{
				//Retrieve and pass student cost sharing, clearance, billing and other credits
				if(empty($student_detail['GraduateList']) || $student_detail['GraduateList']['id'] == "") {
					$this->Session->setFlash('<span></span>'.__($student_detail['Student']['full_name'].' is not graduated to display '.(strcasecmp($student_detail['Student']['gender'], 'male') == 0 ? 'his' : 'her').' temporary degree.'), 'default', array('class'=>'error-box error-message'));

				}
				else {
					$graduation_certificate_template = ClassRegistry::init('GraduationCertificate')->getGraduationCertificate($student_detail['Student']['id']);
					/*$graduation_certificate_template = ClassRegistry::init('GraduationCertificate')->find('first', 
						array(
							'conditions' =>
							array(
								'GraduationCertificate.program_id' => $student_detail['Student']['program_id'],
								'GraduationCertificate.program_type_id' => $student_detail['Student']['program_type_id'],
							),
							'recursive' => -1
						)
					);*/
					$graduation_certificate = $this->GraduateList->temporaryDegree($student_detail['Student']['id']);
					if(isset($this->request->data['displayGraduationCertificatePrint']) && isset($this->request->data['GraduateList']['id'])) {

						$e_day = $this->EthiopicDateTime->GetEthiopicDay(date('j'), date('n'), date('Y'));
						$e_month = $this->EthiopicDateTime->GetEthiopicMonth(date('j'), date('n'), date('Y'));
						$e_year = $this->EthiopicDateTime->GetEthiopicYear(date('j'), date('n'), date('Y'));
						$e_month_name = $this->EthiopicDateTime->GetEthiopicMonthName(date('j'), date('n'), date('Y'));
						$g_d = $graduation_certificate['student_detail']['GraduateList']['graduate_date'];
						$e_g_day = $this->EthiopicDateTime->GetEthiopicDay(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
						$e_g_month = $this->EthiopicDateTime->GetEthiopicMonth(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
						$e_g_year = $this->EthiopicDateTime->GetEthiopicYear(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
						$e_g_month_name = $this->EthiopicDateTime->GetEthiopicMonthName(substr($g_d, 8, 2), substr($g_d, 5, 2), substr($g_d, 0, 4));
			
			$graduate_date = date('d F, Y', 
				mktime(0, 0, 0, 
					substr($graduation_certificate['student_detail']['GraduateList']['graduate_date'],5 ,2), 
					substr($graduation_certificate['student_detail']['GraduateList']['graduate_date'],8 ,2), 
					substr($graduation_certificate['student_detail']['GraduateList']['graduate_date'],0 ,4)
				)
			);
						
						$this->set(compact('graduation_certificate', 'graduation_certificate_template', 'e_day', 'e_month', 'e_year', 'e_month_name', 'e_g_day', 'e_g_month', 'e_g_year', 'e_g_month_name', 'graduate_date'));
						$this->response->type('application/pdf');
 		$this->layout = '/pdf/default';
						$this->render('graduation_certificate_pdf');
					}
				}
			}
		}
		if(isset($student_detail) && !empty($student_detail)) {
			$graduation_certificate_template = ClassRegistry::init('GraduationCertificate')->getGraduationCertificate($student_detail['Student']['id']);
			/*$graduation_certificate_template = ClassRegistry::init('GraduationCertificate')->find('first', 
				array(
					'conditions' =>
					array(
						'GraduationCertificate.program_id' => $student_detail['Student']['program_id'],
						'GraduationCertificate.program_type_id' => $student_detail['Student']['program_type_id'],
					),
					'recursive' => -1
				)
			);*/
			if(empty($graduation_certificate_template)) {
				$this->Session->setFlash('<span></span>'.__('The system unable to find template for the certificate. Please first record certificate template for '.$student_detail['Program']['name'].' program and '.$student_detail['ProgramType']['name'].' program type.'), 'default', array('class'=>'error-box error-message'));

			}
		}
		$this->set(compact('graduation_certificate', 'graduation_certificate_template'));
	}
	
	function mass_certificate_print() {

		$this->__mass_certificate_print(null,null,null,null);
	}

	function __mass_certificate_print ($program_id=null,$program_type_id=null,$department=null) {
		
		/*
		1. Retrieve list of students based on the given search criteria
		2. Display list of students
		3. Up on the selection of section, display list of students with check-box
		4. Prepare student grade copy in PDF for the selected students 
		*/
            
		$programs = $this->GraduateList->Student->Program->find('list');
		$program_types = $this->GraduateList->Student->ProgramType->find('list');
		$departments = $this->GraduateList->Student->Department->allDepartmentsByCollege2(0, 
		$this->department_ids, $this->college_ids);
		$department_combo_id = null;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;


	  //Get list of students who are graduated when a button is clicked
$certificate_type_options = array('graduation_certificate' => 'Graduation Certificate', 'language_proficiency' => 'Language Proficiency', 'to_whom_it_may_concern' => 'To Whom It May Concern', 'student_copy' => 'Student Copy');
	   if(isset($this->request->data['listStudentsForCertficatePrint'])) {
	     $student_lists= $this->GraduateList->getStudentListGraduated($this->request->data['GraduateList']['acadamic_year'],$this->request->data['GraduateList']['program_id'], $this->request->data['GraduateList']['program_type_id'], $this->request->data['GraduateList']['department_id'],null,$this->request->data['GraduateList']['studentnumber'],$this->request->data['GraduateList']['name'],$this->request->data['GraduateList']['graduated']);
	
		$default_department_id = $this->request->data['GraduateList']['department_id'];
		$default_program_id = $this->request->data['GraduateList']['program_id'];
		$default_program_type_id = $this->request->data['GraduateList']['program_type_id'];
		$academic_year_selected = $this->request->data['GraduateList']['acadamic_year'];
	
		$program_id = $this->request->data['GraduateList']['program_id'];
		$program_type_id = $this->request->data['GraduateList']['program_type_id'];
		   
	}
	//Get Certification button is clicked
	if(isset($this->request->data['getStudentCertficate'])) {
	     $student_ids = array();
	     $certificate_template =array();
	   
	     foreach($this->request->data['Student'] as $key => $student) 
             {
		   if($student['gp'] == 1) {
			$student_ids[] = $student['student_id'];
		   }

		   if(empty($certificate_template)) {	
		        if($this->request->data['GraduateList']['certificate_type']=='graduation_certificate') {
			 // get graduation certificate 
			  $certificate_template = ClassRegistry::init('GraduationCertificate')->getGraduationCertificate($student['student_id']);
			} else if ($this->request->data['GraduateList']['certificate_type']=='to_whom_it_may_concern') {
		         $certificate_template=ClassRegistry::init('GraduationLetter')->getGraduationLetter($student['student_id'], 0);
			} else if ($this->request->data['GraduateList']['certificate_type']=='language_proficiency') {
		        $certificate_template = ClassRegistry::init('GraduationLetter')->getGraduationLetter($student['student_id'], 1);
			
			
			} 	
		   } 
	      }
	   

	    if(empty($student_ids)) {
			$this->Session->setFlash('<span></span>'.__('You are required to select at least one student to isssue certificate.'), 'default', array('class'=>'error-box error-message'));
	    } else {

		if($this->request->data['GraduateList']['certificate_type']=='graduation_certificate') {
		// get graduation certificate 
		$graduation_certificate_template=$certificate_template;
		$graduation_certificates = $this->GraduateList->getTemporaryDegreeCertificateForMassPrint($student_ids);
		
		$this->set(compact('graduation_certificates','graduation_certificate_template'));
			if(!empty($graduation_certificates)) {
				$this->response->type('application/pdf');
		 		$this->layout = '/pdf/default';
				$this->render('mass_graduation_certificate_print_pdf');
			} else {
              	$this->Session->setFlash('<span></span>'.__('The system unable to find template for graduation certificate. Please define graduation certificate first.', true), 'default', array('class'=>'error-box error-message'));
			}	

		 
		} else if($this->request->data['GraduateList']['certificate_type']=='student_copy') {
		  
		$student_copies =ClassRegistry::init('ExamGrade')->studentCopy($student_ids);

		 $no_of_semester = $this->request->data['Setting']['no_of_semester'];
		$course_justification = $this->request->data['Setting']['course_justification'];
		$font_size = $this->request->data['Setting']['font_size'];
		if($course_justification == 2)
			$course_justification = 0;
		else if($course_justification == 0)
			$course_justification = -2;
		else
			$course_justification = -1;

		$this->set(compact('student_copies', 'no_of_semester', 'course_justification', 'font_size'));
		$this->response->type('application/pdf');
 		$this->layout = '/pdf/default';
		$this->render('mass_student_copy_pdf');

		} else if ($this->request->data['GraduateList']['certificate_type']=='to_whom_it_may_concern') {
		    
		    $graduation_letter_template=$certificate_template;
		    $graduation_letters = $this->GraduateList->getTemporaryDegreeCertificateForMassPrint($student_ids);
		      $this->set(compact('graduation_letters', 'graduation_letter_template'));
		   if(!empty($graduation_letter_template)) {  	
			  $this->response->type('application/pdf');
	 		  $this->layout = '/pdf/default';
			  $this->render('to_whom_profiency_letter_pdf');
		    } else {
				$this->Session->setFlash('<span></span>'.__('The system unable to find template for "to whom it may concern" letter. Please define to whom it may concern template first.', true), 'default', array('class'=>'error-box error-message'));
				
			}
		} else if ($this->request->data['GraduateList']['certificate_type']=='language_proficiency') {
		   
		   $graduation_letter_template=$certificate_template;
		   $graduation_letters = $this->GraduateList->getTemporaryDegreeCertificateForMassPrint($student_ids);
		   $this->set(compact('graduation_letters', 'graduation_letter_template'));
		   if(!empty($graduation_letter_template)) {
			  $this->response->type('application/pdf');
	 		  $this->layout = '/pdf/default';
			  $this->render('to_whom_profiency_letter_pdf');
		   } else {
				$this->Session->setFlash('<span></span>'.__('The system unable to find template for "language proficiency" letter. Please define language proficiency template first.', true), 'default', array('class'=>'error-box error-message'));
		   }
		} else if ($this->request->data['GraduateList']['certificate_type']=='temporary_degree') {
			$temporary_degrees = $this->GraduateList->getTemporaryDegreeCertificateForMassPrint($student_ids);
			$this->set(compact('temporary_degrees'));
			$this->response->type('application/pdf');
 			$this->layout = '/pdf/default';
			$this->render('mass_temporary_degree_pdf');
		} else {
		// something is wrong 
		$this->Session->setFlash('<span></span>'.__('Something went wrong. Please try again.'), 'default', array('class'=>'error-box error-message'));
	     }	  
	 }
	}
         $font_size_options = array(27 => 'Small 1', 28 => 'Small 2', 29 => 'Small 3', 30 => 'Medium 1', 31 => 'Medium 2', 32 => 'Medium 3', 33 => 'Large 1', 34 => 'Large 2');
	$certificate_type_options = array('graduation_certificate' => 'Graduation Certificate', 'language_proficiency' => 'Language Proficiency', 'to_whom_it_may_concern' => 'To Whom It May Concern', 'graduation_certificate' => 'Graduation Certificate', 'student_copy' => 'Student Copy','temporary_degree'=>'Temporary Degree');	 
	  $this->set(compact('departments','program_types',
'programs','default_program_type_id',
'student_lists','default_program_id',
'default_department_id','certificate_type_options','font_size_options'));
	
    }

    public function check_graduate(){
    	  $this->layout='login';
    	 
    	  if (!empty($this->request->data) && isset($this->request->data['continue'])) { 

			 $isStudentValid=$this->GraduateList->Student->find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['GraduateList']['studentID']))));
			  if ($isStudentValid>0) {
			  	$students=$this->GraduateList->Student->find('first',array('conditions'=>array('Student.studentnumber'=>
			  		trim($this->request->data['GraduateList']['studentID'])),
			  		'contain'=>array('GraduateList','Attachment','Program','Department','College',
			  		'ProgramType','Curriculum'=>array('fields'=>array('english_degree_nomenclature'
			  			,'amharic_degree_nomenclature',
			  			'certificate_name',
			  			'specialization_amharic_degree_nomenclature',
			  			'specialization_english_degree_nomenclature')))
			  		));

			  	 $this->set(compact('students'));
			  } else {
			  	 $this->Session->setFlash('<span></span> '.__('The student number provided is not in our system. If you made typo error please try again else the given student number is not our student based on the admitted student data since 2012!'),'default',array('class'=>'info-box info-message'));   
			  }
    	  }
    }
}
?>
