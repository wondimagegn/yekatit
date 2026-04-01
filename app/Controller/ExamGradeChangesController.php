<?php
class ExamGradeChangesController extends AppController
{

	var $name = 'ExamGradeChanges';
	var $components = array('AcademicYear');
	var $menuOptions = array(
		'parent' => 'examGrades',
		'controllerButton' => false,
		'exclude' => array('*'), //array('index'),
		'alias' => array(
			'manage_department_grade_change' => 'Approve Grade Change',
			'manage_college_grade_change' => 'Manage Grade Change',
			'manage_registrar_grade_change' => 'Manage Grade Change',
			'department_makeup_exam_result' => 'Supplementary Exam',
			'freshman_makeup_exam_result' => 'Freshman Supplementary Exam',
			'manage_freshman_grade_change' => 'Manage Freshman Grade Change',
			'cancel_auto_grade_change' => 'Cancel Auto Grade Change'
		)
	);

	function beforeFilter()
	{
		parent::beforeFilter();

		//To diplay current academic year as default in drop down list

		//$this->Auth->allow('');


	}
	public function beforeRender()
	{
		$acyear_list = $acyear_array_data = $this->AcademicYear->acyear_array();
		$defaultacademicyear = $this->AcademicYear->current_academicyear();

		$this->set(compact('acyear_array_data', 'defaultacademicyear'));
		if (!empty($this->program_type_id)) {
			$program_types = $programTypes = ClassRegistry::init('ProgramType')->find('list', array('conditions' =>
			array('ProgramType.id' => $this->program_type_id)));
		} else {
			$program_types = $programTypes = ClassRegistry::init('ProgramType')->find('list');
		}

		if (!empty($this->program_id)) {
			$programs = ClassRegistry::init('Program')->find('list', array('conditions' =>
			array('Program.id' => $this->program_id)));
		} else {
			$programs = ClassRegistry::init('Program')->find('list');
		}
		$this->set(compact(
			'programs',
			'programTypes',
			'acyear_list',
			'program_types'
		));
	}
	function index()
	{
		if ($this->Acl->check($this->Auth->user(), 'controllers/examGrades/freshman_grade_view')) {
			return $this->redirect(array('controller' => 'exam_grades', 'action' => 'freshman_grade_view'));
		} else {
			return $this->redirect(array('controller' => 'exam_grades', 'action' => 'department_grade_view'));
		}
	}

	//College Freshman
	function manage_freshman_grade_change()
	{
		$this->__manage_grade_change(0);
		$this->render('manage_department_grade_change');
	}

	//DEPARTMENT
	function manage_department_grade_change()
	{
		//Role based checking is removed
		//if($this->role_id == 6) {
		if (1) {
			$this->__manage_grade_change(1);
			$this->render('manage_department_grade_change');
		} else {
			$this->Session->setFlash('<span></span>' . __('You need to have department role to access exam grade change management area. Please contact your system administrator to get department role.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}

	//DEPARTMENT and COLLEGE freshman grade change (common)
	private function __manage_grade_change($department = 1)
	{
		//Role based checking is removed
		//if($this->role_id == 6 || $this->role_id == 5) {
		if (1) {
			if ($department)
				$col_or_dpt_id = $this->department_id;
			else
				$col_or_dpt_id = $this->college_id;

			debug($col_or_dpt_id);
			
			$exam_grade_changes = $this->ExamGradeChange->getListOfGradeChangeForDepartmentApproval($col_or_dpt_id, $department);
			
			
			//getListOfGradeChangeForCollegeApproval
			
			debug($exam_grade_changes);
			$makeup_exam_grade_changes = $this->ExamGradeChange->getListOfMakeupGradeChangeForDepartmentApproval($col_or_dpt_id, 0, $department);
			$rejected_makeup_exam_grade_changes = $this->ExamGradeChange->getListOfMakeupGradeChangeForDepartmentApproval($col_or_dpt_id, 1, $department);
			$rejected_department_makeup_exam_grade_changes = $this->ExamGradeChange->getMakeupGradesAskedByDepartmentRejectedByRegistrar($col_or_dpt_id, $department);
			debug($this->request->data);
			if (
				isset($this->request->data)
				&& !isset($this->request->data['ApproveAllGradeChangeByDepartment'])
			) {
				for ($i = 1; $i <= $this->request->data['ExamGradeChange']['grade_change_count']; $i++) {
					if (isset($this->request->data['approveGradeChangeByDepartment_' . $i])) {
						$exam_grade_change_detail = $this->ExamGradeChange->find(
							'first',
							array(
								'conditions' => array('ExamGradeChange.id' => $this->request->data['ExamGradeChange'][$i]['id']),
								'contain' => array('ExamGrade' => array('CourseRegistration' => array('PublishedCourse'), 'CourseAdd' => array('PublishedCourse')))
							)
						);
						if (empty($exam_grade_change_detail)) {
							$this->Session->setFlash('<span></span>' . __('The system unable to find the exam grade change request. It happens when the grade change request is canceled in the middle of approval process. Please try again.'), 'default', array('class' => 'error-box error-message'));
						} else if ((isset($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && !empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['id'] != "" && (($department == 1 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['given_by_department_id']) || ($department == 0 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id']))) ||
							(isset($exam_grade_change_detail['ExamGrade']['CourseAdd']) && !empty($exam_grade_change_detail['ExamGrade']['CourseAdd']) && $exam_grade_change_detail['ExamGrade']['CourseAdd']['id'] != "" && (($department == 1 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['given_by_department_id']) || ($department == 0 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['college_id'])))
						) {
						debug($exam_grade_change_detail);
						debug($department);
							$this->Session->setFlash('<span></span>' . __('You are not authorized to manage the selected exam grade change request. Please try again.'), 'default', array('class' => 'error-box error-message'));
						} else if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] == 1 && ($exam_grade_change_detail['ExamGradeChange']['registrar_approval'] == 1 || $exam_grade_change_detail['ExamGradeChange']['registrar_approval'] == null)) {
							$this->Session->setFlash('<span></span>' . __('The selected grade change request is already processed. Please use the following report tool to get details on the status of the grade change request.'), 'default', array('class' => 'error-box error-message'));
							return $this->redirect(array('action' => 'index'));
						} else {
							$department_grade_change_approval = array();
							if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] == null) {
								$department_grade_change_approval['id'] = $this->request->data['ExamGradeChange'][$i]['id'];
								$department_grade_change_approval['department_approval'] = (isset($this->request->data['ExamGradeChange'][$i]['department_approval']) ? ($this->request->data['ExamGradeChange'][$i]['department_approval'] == 1 ? 1 : -1) : -1);
								$department_grade_change_approval['department_reason'] = $this->request->data['ExamGradeChange'][$i]['department_reason'];
								$department_grade_change_approval['department_approval_date'] = date('Y-m-d H:i:s');
								$department_grade_change_approval['department_approved_by'] = $this->Auth->user('id');
							} else {
								$department_grade_change_approval['exam_grade_id'] = $exam_grade_change_detail['ExamGradeChange']['exam_grade_id'];
								$department_grade_change_approval['grade'] = $exam_grade_change_detail['ExamGradeChange']['grade'];
								$department_grade_change_approval['minute_number'] = $exam_grade_change_detail['ExamGradeChange']['minute_number'];
								$department_grade_change_approval['makeup_exam_id'] = $exam_grade_change_detail['ExamGradeChange']['makeup_exam_id'];
								$department_grade_change_approval['makeup_exam_result'] = $exam_grade_change_detail['ExamGradeChange']['makeup_exam_result'];
								$department_grade_change_approval['initiated_by_department'] = $exam_grade_change_detail['ExamGradeChange']['initiated_by_department'];
								$department_grade_change_approval['result'] = $exam_grade_change_detail['ExamGradeChange']['result'];
								$department_grade_change_approval['department_reply'] = 1;
								$department_grade_change_approval['department_approval'] = (isset($this->request->data['ExamGradeChange'][$i]['department_approval']) ? ($this->request->data['ExamGradeChange'][$i]['department_approval'] == 1 ? 1 : -1) : -1);
								$department_grade_change_approval['department_reason'] = $this->request->data['ExamGradeChange'][$i]['department_reason'];
								$department_grade_change_approval['department_approval_date'] = date('Y-m-d H:i:s');
								$department_grade_change_approval['department_approved_by'] = $this->Auth->user('id');
							}
							if ($this->ExamGradeChange->save($department_grade_change_approval, array('validate' => false))) {
								//Notifications
								ClassRegistry::init('AutoMessage')->sendNotificationOnDepartmentGradeChangeApproval($department_grade_change_approval);
								$this->Session->setFlash('<span></span>' . __('Your exam grade change request approval is successfully done.'), 'default', array('class' => 'success-box success-message'));
								return $this->redirect(array('action' => ($department == 1 ? 'manage_department_grade_change' : 'manage_freshman_grade_change')));
							} else {
								$this->Session->setFlash('<span></span>' . __('The system is unable to complete your exam grade change request approval. Please try again.'), 'default', array('class' => 'error-box error-message'));
								return $this->redirect(array('action' => ($department == 1 ? 'manage_department_grade_change' : 'manage_freshman_grade_change')));
							}
						}
					}
				}
			} else if (
				isset($this->request->data)
				&& isset($this->request->data['ApproveAllGradeChangeByDepartment'])
			) {

				unset($this->request->data['Mass']['ExamGradeChange']['select_all']);
				$sucessfulapproval = 0;
				foreach ($this->request->data['Mass']['ExamGradeChange'] as $grk => $grv) {
					if ($grv['gp'] == 1) {
						$exam_grade_change_detail = $this->ExamGradeChange->find('first', array('conditions' => array('ExamGradeChange.id' => $grv['id']), 'contain' => array('ExamGrade' => array('CourseRegistration' => array('PublishedCourse'), 'CourseAdd' => array('PublishedCourse')))));

						if (empty($exam_grade_change_detail)) {
							//request grade change cancelled
						} else if ((isset($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && !empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['id'] != "" && (($department == 1 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['given_by_department_id']) || ($department == 0 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id']))) ||
							(isset($exam_grade_change_detail['ExamGrade']['CourseAdd']) && !empty($exam_grade_change_detail['ExamGrade']['CourseAdd']) && $exam_grade_change_detail['ExamGrade']['CourseAdd']['id'] != "" && (($department == 1 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['given_by_department_id']) || ($department == 0 && $col_or_dpt_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['college_id'])))
						) {
							//not authorized 
						} else if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] == 1 && ($exam_grade_change_detail['ExamGradeChange']['registrar_approval'] == 1 || $exam_grade_change_detail['ExamGradeChange']['registrar_approval'] == null)) {
							//already approved
						} else {

							$department_grade_change_approval = array();
							if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] == null) {
								$department_grade_change_approval['id'] = $grv['id'];
								$department_grade_change_approval['department_approval'] = $grv['department_approval'];
								$department_grade_change_approval['department_reason'] = "Teacher reason accepted!";
								$department_grade_change_approval['department_approval_date'] = date('Y-m-d H:i:s');
								$department_grade_change_approval['department_approved_by'] = $this->Auth->user('id');
							}

							if (
								$this->ExamGradeChange->save($department_grade_change_approval, array('validate' => false))
							) {
								$sucessfulapproval++;
								//Notifications
								ClassRegistry::init('AutoMessage')->sendNotificationOnDepartmentGradeChangeApproval($department_grade_change_approval);
							}
						}
					}
				}
				if ($sucessfulapproval) {
					$this->Session->setFlash('<span></span>' . __('You have approved exam grade change request successfully.'), 'default', array('class' => 'success-box success-message'));
					return $this->redirect(array('action' => ($department == 1 ? 'manage_department_grade_change' : 'manage_freshman_grade_change')));
				}
			}
			$this->set(compact('exam_grade_changes', 'makeup_exam_grade_changes', 'rejected_makeup_exam_grade_changes', 'rejected_department_makeup_exam_grade_changes'));
		} else {
			$this->Session->setFlash('<span></span>' . __('You need to have either college or department role to access exam grade change management area. Please contact your system administrator to get college or department role.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}

	//COLLEGE
	function manage_college_grade_change()
	{
		//Role based checking is removed
		//if($this->role_id == 5 || $this->role_id == 6) {
		if (1) {
			$exam_grade_changes = $this->ExamGradeChange->getListOfGradeChangeForCollegeApproval($this->college_id);

			if (
				isset($this->request->data)
				&& !isset($this->request->data['ApproveAllGradeChangeByCollege'])
			) {

				for ($i = 1; $i <= $this->request->data['ExamGradeChange']['grade_change_count']; $i++) {
					if (isset($this->request->data['approveGradeChangeByCollege_' . $i])) {
						$exam_grade_change_detail = $this->ExamGradeChange->find(
							'first',
							array(
								'conditions' => array('ExamGradeChange.id' => $this->request->data['ExamGradeChange'][$i]['id']),
								'contain' => array('ExamGrade' => array('CourseRegistration' => array('PublishedCourse' => array('Department', 'GivenByDepartment')), 'CourseAdd' => array('PublishedCourse' => array('Department', 'GivenByDepartment'))))
							)
						);
						$given_by_dept_ids = ClassRegistry::init('Department')->find(
							'list',
							array(
								'conditions' => array('Department.college_id' => $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']),
								'fields' => array('Department.id', 'Department.id')
							)
						);
						debug($exam_grade_change_detail);
						if (empty($exam_grade_change_detail)) {
							$this->Session->setFlash('<span></span>' . __('The system unable to find the exam grade change request. It happens when the grade change request is cancelled in the middle of the approval process. Please try again.'), 'default', array('class' => 'error-box error-message'));
						} else if ((isset($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && !empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['id'] != "" && ((!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']) || (!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id'] != $this->college_id || !in_array($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['given_by_department_id'], $given_by_dept_ids)))) ||
							(isset($exam_grade_change_detail['ExamGrade']['CourseAdd']) && !empty($exam_grade_change_detail['ExamGrade']['CourseAdd']) && $exam_grade_change_detail['ExamGrade']['CourseAdd']['id'] != "" && ((!empty($exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['Department']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']['college_id']) || (!empty($exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']['college_id']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']['college_id'])))
						) {
						
						debug((!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']) || (!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id'] != $this->college_id || !in_array($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['given_by_department_id'], $given_by_dept_ids)));
						debug((!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']));
						debug(!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id'] != $this->college_id);
						debug(!in_array($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['given_by_department_id'], $given_by_dept_ids));
						debug($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id'] != $this->college_id);
						debug(strcasecmp($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id'],$this->college_id)!=0);
						debug($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id']);
						debug($this->college_id);
						
	debug($exam_grade_change_detail);
						debug($department);
							$this->Session->setFlash('<span></span>' . __('You are not authorized to manage the selected exam grade change request. Please try again.'), 'default', array('class' => 'error-box error-message'));
						} else if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] != 1) {
							$this->Session->setFlash('<span></span>' . __('The selected grade change request is being processed by the departement. Please try again later.'), 'default', array('class' => 'error-box error-message'));
							return $this->redirect(array('action' => 'index'));
						} else if ($exam_grade_change_detail['ExamGradeChange']['college_approval'] != null) {
							$this->Session->setFlash('<span></span>' . __('The selected grade change request is already processed. Please use the following report tool to get details on the status of the grade change request.'), 'default', array('class' => 'error-box error-message'));
							return $this->redirect(array('action' => 'index'));
						} else {
							$college_grade_change_approval = array();
							$college_grade_change_approval['id'] = $this->request->data['ExamGradeChange'][$i]['id'];
							$college_grade_change_approval['college_approval'] = (isset($this->request->data['ExamGradeChange'][$i]['college_approval']) ? ($this->request->data['ExamGradeChange'][$i]['college_approval'] == 1 ? 1 : -1) : -1);
							$college_grade_change_approval['college_reason'] = $this->request->data['ExamGradeChange'][$i]['college_reason'];
							$college_grade_change_approval['college_approval_date'] = date('Y-m-d H:i:s');
							$college_grade_change_approval['college_approved_by'] = $this->Auth->user('id');
							if ($this->ExamGradeChange->save($college_grade_change_approval, array('validate' => false))) {
								//Notifications
								ClassRegistry::init('AutoMessage')->sendNotificationOnCollegeGradeChangeApproval($college_grade_change_approval);
								$this->Session->setFlash('<span></span>' . __('Your exam grade change request approval is successfully done.'), 'default', array('class' => 'success-box success-message'));
								return $this->redirect(array('action' => 'manage_college_grade_change'));
							} else {
								$this->Session->setFlash('<span></span>' . __('The system is unable to complete your exam grade change request approval. Please try again.'), 'default', array('class' => 'error-box error-message'));
								return $this->redirect(array('action' => 'manage_college_grade_change'));
							}
						}
					}
				}
			} else if (isset($this->request->data['ApproveAllGradeChangeByCollege'])) {

				unset($this->request->data['Mass']['ExamGradeChange']['select_all']);
				$sucessfulapproval = 0;
				foreach ($this->request->data['Mass']['ExamGradeChange'] as $grk => $grv) {
					if ($grv['gp'] == 1) {

						$exam_grade_change_detail = $this->ExamGradeChange->find(
							'first',
							array(
								'conditions' => array('ExamGradeChange.id' => $grv['id']),
								'contain' => array('ExamGrade' => array('CourseRegistration' => array('PublishedCourse' => array('Department', 'GivenByDepartment')), 'CourseAdd' => array('PublishedCourse' => array('Department', 'GivenByDepartment'))))
							)
						);
						$given_by_dept_ids = ClassRegistry::init('Department')->find(
							'list',
							array(
								'conditions' => array('Department.college_id' => $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']),
								'fields' => array('Department.id', 'Department.id')
							)
						);


						if (empty($exam_grade_change_detail)) {
							//request grade change cancelled
						} else if ((isset($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && !empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['id'] != "" && ((!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id']) || (!empty($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['college_id']) && $exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['GivenByDepartment']['college_id'] != $this->college_id || !in_array($exam_grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse']['given_by_department_id'], $given_by_dept_ids)))) ||
							(isset($exam_grade_change_detail['ExamGrade']['CourseAdd']) && !empty($exam_grade_change_detail['ExamGrade']['CourseAdd']) && $exam_grade_change_detail['ExamGrade']['CourseAdd']['id'] != "" && ((!empty($exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']['college_id']) || (!empty($exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']['college_id']) && $this->college_id != $exam_grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse']['GivenByDepartment']['college_id'])))
						) {
						} else if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] != 1) {
						} else if ($exam_grade_change_detail['ExamGradeChange']['college_approval'] != null) {
						} else {

							$college_grade_change_approval = array();
							$college_grade_change_approval['id'] = $grv['id'];
							$college_grade_change_approval['college_approval'] = 1;
							$college_grade_change_approval['college_reason'] = "Teacher reason accepted!";
							$college_grade_change_approval['college_approval_date'] = date('Y-m-d H:i:s');
							$college_grade_change_approval['college_approved_by'] = $this->Auth->user('id');
							if ($this->ExamGradeChange->save(
								$college_grade_change_approval,
								array('validate' => false)
							)) {
								$sucessfulapproval++;
								//Notifications
								ClassRegistry::init('AutoMessage')->sendNotificationOnCollegeGradeChangeApproval($college_grade_change_approval);
							}
						}
					}
				}
				if ($sucessfulapproval) {
					$this->Session->setFlash('<span></span>' . __('You have approved exam grade change request successfully.'), 'default', array('class' => 'success-box success-message'));
					return $this->redirect(array('action' => 'manage_college_grade_change'));
				}
			}
			$this->set(compact('exam_grade_changes'));
		} else {
			$this->Session->setFlash('<span></span>' . __('You need to have either college or department role to access exam grade change management area. Please contact your system administrator to get college or department role.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}
	function cancel_auto_grade_change()
	{
		if (isset($this->request->data) && !empty($this->request->data['cancelAutoGrade'])) {
			$gradeToBeCancelled = array();
			foreach ($this->request->data['ExamGradeChange'] as $key => $student) {
				if (
					is_int($key) &&
					$student['gp'] == 1
				) {
					$gradeToBeCancelled[] = $student['id'];
				}
			}

			if (
				isset($gradeToBeCancelled)
				&& !empty($gradeToBeCancelled)
			) {
				//
				if ($this->ExamGradeChange->deleteAll(array('ExamGradeChange.id' => $gradeToBeCancelled), false)) {
					$this->Session->setFlash('<span></span>' . __('You have cancelled ' . count($gradeToBeCancelled) . ' auto converted grades.'), 'default', array('class' => 'success-box success-message'));
				}
			}
		}
		if (
			isset($this->request->data)
			&& !empty($this->request->data['listPublishedCourses'])
		) {

			if (
				isset($this->college_ids)
				&& !empty($this->college_ids)
			) {
				$type = 1;
			} else if (
				isset($this->department_ids) &&
				!empty($this->department_ids)
			) {
				$type = 0;
			}
			debug($this->request->data);

			$examGradeChanges = $this->ExamGradeChange->getListOfGradeAutomaticallyConverted(
				$this->request->data['ExamGradeChange']['acadamic_year'],
				$this->request->data['ExamGradeChange']['semester'],
				$this->request->data['ExamGradeChange']['department_id'],
				$this->request->data['ExamGradeChange']['program_id'],
				$this->request->data['ExamGradeChange']['program_type_id'],
				$this->request->data['ExamGradeChange']['grade'],
				$type
			);
			debug($examGradeChanges);
			$this->set(compact('examGradeChanges'));
		}
		if (
			isset($this->college_ids)
			&& !empty($this->college_ids)
		) {
			$departments = ClassRegistry::init('College')->find('list', array('conditions' => array('College.id' => $this->college_ids)));
		} else if (
			isset($this->department_ids) &&
			!empty($this->department_ids)
		) {
			$departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.id' => $this->department_ids)));
		}

		$this->set(compact('departments'));
	}
	//REGISTRAR
	function manage_registrar_grade_change()
	{
		//Role based checking is removed
		//if($this->role_id == 4) {
		if (1) {
			//debug($this->department_ids);
			//debug($this->college_ids);
			$exam_grade_changes = $this->ExamGradeChange->getListOfGradeChangeForRegistrarApproval($this->department_ids, $this->college_ids, $this->program_id, $this->program_type_id);

			$makeup_exam_grade_changes = $this->ExamGradeChange->getListOfMakeupGradeChangeForRegistrarApproval(
				$this->department_ids,
				$this->college_ids,
				$this->program_id,
				$this->program_type_id
			);
			$department_makeup_exam_grade_changes = $this->ExamGradeChange->getListOfMakeupGradeChangeByDepartmentForRegistrarApproval(
				$this->department_ids,
				$this->college_ids,
				$this->program_id,
				$this->program_type_id
			);

			if (
				isset($this->request->data) &&
				!isset($this->request->data['ApproveAllGradeChangeByRegistrar'])
			) {
				for ($i = 1; $i <= $this->request->data['ExamGradeChange']['grade_change_count']; $i++) {
					if (isset($this->request->data['approveGradeChangeByRegistrar_' . $i])) {
						$exam_grade_change_detail = $this->ExamGradeChange->find(
							'first',
							array(
								'conditions' => array('ExamGradeChange.id' => $this->request->data['ExamGradeChange'][$i]['id']),
								'contain' => array('ExamGrade' => array('CourseRegistration' => array('PublishedCourse' => array('Department')), 'CourseAdd' => array('PublishedCourse' => array('Department'))))
							)
						);
						if (empty($exam_grade_change_detail)) {
							$this->Session->setFlash('<span></span>' . __('The system unable to find the exam grade change request. It happens when the grade change request is canceled in the middle of the approval process. Please try again.'), 'default', array('class' => 'error-box error-message'));
						} else if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] != 1 || ($exam_grade_change_detail['ExamGradeChange']['makeup_exam_result'] == null && $exam_grade_change_detail['ExamGradeChange']['college_approval'] != 1)) {
							$this->Session->setFlash('<span></span>' . __('The selected grade change request is being processed by the department and/or college. Please try again later.'), 'default', array('class' => 'error-box error-message'));
							return $this->redirect(array('action' => 'index'));
						} else if ($exam_grade_change_detail['ExamGradeChange']['registrar_approval'] != null) {
							$this->Session->setFlash('<span></span>' . __('The selected grade change request is already processed. Please use the following report tool to get details on the status of the grade change request.'), 'default', array('class' => 'error-box error-message'));
							return $this->redirect(array('action' => 'index'));
						} else {
							$registrar_grade_change_approval = array();
							$registrar_grade_change_approval['id'] = $this->request->data['ExamGradeChange'][$i]['id'];
							$registrar_grade_change_approval['registrar_approval'] = (isset($this->request->data['ExamGradeChange'][$i]['registrar_approval']) ? ($this->request->data['ExamGradeChange'][$i]['registrar_approval'] == 1 ? 1 : -1) : -1);
							$registrar_grade_change_approval['registrar_reason'] = $this->request->data['ExamGradeChange'][$i]['registrar_reason'];
							$registrar_grade_change_approval['registrar_approval_date'] = date('Y-m-d H:i:s');
							$registrar_grade_change_approval['registrar_approved_by'] = $this->Auth->user('id');
							if ($this->ExamGradeChange->save($registrar_grade_change_approval, array('validate' => false))) {
								//Notifications
								ClassRegistry::init('AutoMessage')->sendNotificationOnRegistrarGradeChangeApproval($registrar_grade_change_approval);
								if ($registrar_grade_change_approval['registrar_approval'] == 1) {
									//Check if status is generated or not
									$grade_change_detail = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->CourseRegistration->ExamGrade->ExamGradeChange->find(
										'first',
										array(
											'conditions' =>
											array(
												'ExamGradeChange.id' => $registrar_grade_change_approval['id']
											),
											'contain' =>
											array(
												'ExamGrade' =>
												array(
													'CourseRegistration' =>
													array(
														'PublishedCourse',
														'Student'
													),
													'CourseAdd' =>
													array(
														'PublishedCourse',
														'Student'
													)
												)
											)
										)
									);
									if (isset($grade_change_detail['ExamGrade']['CourseRegistration']) && !empty($grade_change_detail['ExamGrade']['CourseRegistration']) && $grade_change_detail['ExamGrade']['CourseRegistration']['id'] != "") {
										$student = $grade_change_detail['ExamGrade']['CourseRegistration']['Student'];
										$published_course = $grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse'];
									} else {
										$student = $grade_change_detail['ExamGrade']['CourseAdd']['Student'];
										$published_course = $grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse'];
									}

									$previous_student_exam_status = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->StudentExamStatus->find(
										'first',
										array(
											'conditions' =>
											array(
												'StudentExamStatus.student_id' => $student['id'],
												'StudentExamStatus.academic_year' => $published_course['academic_year'],
												'StudentExamStatus.semester' => $published_course['semester']
											),
											'recursive' => -1
										)
									);

									if (!empty($previous_student_exam_status)) {
										//Status is already generated
										$status_status = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->StudentExamStatus->updateAcdamicStatusForGradeChange($registrar_grade_change_approval['id']);
									} else {
										$status_status = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->StudentExamStatus->updateAcdamicStatusByPublishedCourse($published_course['id']);
									}



									if ($status_status) {
										$this->Session->setFlash('<span></span>' . __('Your exam grade change request approval is successfully done.'), 'default', array('class' => 'success-box success-message'));
									} else {
										$this->Session->setFlash('<span></span>' . __('Your exam grade change request approval is successfully done but student academic status is not successfully completed. Please use re-build student academic status tool to update student semester academic status.'), 'default', array('class' => 'warning-box warning-message'));
									}
								} else
									$this->Session->setFlash('<span></span>' . __('Your exam grade change request approval is successfully done.'), 'default', array('class' => 'success-box success-message'));
								return $this->redirect(array('action' => 'manage_registrar_grade_change'));
							} else {
								$this->Session->setFlash('<span></span>' . __('The system is unable to complete your exam grade change request approval. Please try again.'), 'default', array('class' => 'error-box error-message'));
								return $this->redirect(array('action' => 'manage_registrar_grade_change'));
							}
						}
					}
				}
			} else if (
				isset($this->request->data)
				&& isset($this->request->data['ApproveAllGradeChangeByRegistrar'])
			) {

				unset($this->request->data['Mass']['ExamGradeChange']['select_all']);
				$sucessfulapproval = 0;
				foreach ($this->request->data['Mass']['ExamGradeChange'] as $grk => $grv) {
					if ($grv['gp'] == 1) {
						$exam_grade_change_detail = $this->ExamGradeChange->find('first', array('conditions' => array('ExamGradeChange.id' => $grv['id']), 'contain' => array('ExamGrade' => array('CourseRegistration' => array('PublishedCourse' => array('Department')), 'CourseAdd' => array('PublishedCourse' => array('Department'))))));
						if (empty($exam_grade_change_detail)) {
						} else if ($exam_grade_change_detail['ExamGradeChange']['department_approval'] != 1 || ($exam_grade_change_detail['ExamGradeChange']['makeup_exam_result'] == null && $exam_grade_change_detail['ExamGradeChange']['college_approval'] != 1)) {
						} else if ($exam_grade_change_detail['ExamGradeChange']['registrar_approval'] != null) {
						} else {
							$registrar_grade_change_approval = array();
							$registrar_grade_change_approval['id'] = $grv['id'];
							$registrar_grade_change_approval['registrar_approval'] = 1;
							$registrar_grade_change_approval['registrar_reason'] = "Teacher reason accepted!";
							$registrar_grade_change_approval['registrar_approval_date'] = date('Y-m-d H:i:s');
							$registrar_grade_change_approval['registrar_approved_by'] = $this->Auth->user('id');
							if ($this->ExamGradeChange->save($registrar_grade_change_approval, array('validate' => false))) {
								$sucessfulapproval++;
								//Notifications
								ClassRegistry::init('AutoMessage')->sendNotificationOnRegistrarGradeChangeApproval($registrar_grade_change_approval);
								if ($registrar_grade_change_approval['registrar_approval'] == 1) {
									//Check if status is generated or not
									$grade_change_detail = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->CourseRegistration->ExamGrade->ExamGradeChange->find(
										'first',
										array(
											'conditions' =>
											array(
												'ExamGradeChange.id' => $registrar_grade_change_approval['id']
											),
											'contain' =>
											array(
												'ExamGrade' =>
												array(
													'CourseRegistration' =>
													array(
														'PublishedCourse',
														'Student'
													),
													'CourseAdd' =>
													array(
														'PublishedCourse',
														'Student'
													)
												)
											)
										)
									);
									if (isset($grade_change_detail['ExamGrade']['CourseRegistration']) && !empty($grade_change_detail['ExamGrade']['CourseRegistration']) && $grade_change_detail['ExamGrade']['CourseRegistration']['id'] != "") {
										$student = $grade_change_detail['ExamGrade']['CourseRegistration']['Student'];
										$published_course = $grade_change_detail['ExamGrade']['CourseRegistration']['PublishedCourse'];
									} else {
										$student = $grade_change_detail['ExamGrade']['CourseAdd']['Student'];
										$published_course = $grade_change_detail['ExamGrade']['CourseAdd']['PublishedCourse'];
									}

									$previous_student_exam_status = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->StudentExamStatus->find(
										'first',
										array(
											'conditions' =>
											array(
												'StudentExamStatus.student_id' => $student['id'],
												'StudentExamStatus.academic_year' => $published_course['academic_year'],
												'StudentExamStatus.semester' => $published_course['semester']
											),
											'recursive' => -1
										)
									);
									if (!empty($previous_student_exam_status)) {
										//Status is already generated
										$status_status = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->StudentExamStatus->updateAcdamicStatusForGradeChange($registrar_grade_change_approval['id']);
									} else {
										$status_status = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->StudentExamStatus->updateAcdamicStatusByPublishedCourse($published_course['id']);
									}
								}
							}
						}
					}
				}
				if ($sucessfulapproval) {
					$this->Session->setFlash('<span></span>' . __('Your exam grade change request approval is successfully.'), 'default', array('class' => 'success-box success-message'));
					return $this->redirect(array('action' => 'manage_registrar_grade_change'));
				}
			}
			$this->set(compact('exam_grade_changes', 'makeup_exam_grade_changes', 'department_makeup_exam_grade_changes'));
		} else {
			$this->Session->setFlash('<span></span>' . __('You need to have registrar role to access exam grade change management area. Please contact your system administrator to get registrar role.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}

	function freshman_makeup_exam_result()
	{
		$this->__makeup_exam_result(0);
		$this->render('makeup_exam_result');
	}

	function department_makeup_exam_result()
	{
		//Role based checking is skipped
		//if($this->role_id == 6) {
		if (1) {
			$this->__makeup_exam_result(1);
			$this->render('makeup_exam_result');
		} else {
			$this->Session->setFlash('<span></span>' . __('You need to have department role to access makeup exam administration. Please contact your system administrator to get department role.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}

	//TODO: Reject grade change when there is other submitted grade which is on process (DONE)
	private function __makeup_exam_result($departement = 1)
	{
		$grade_history = array();
		$register_or_add = array();
		//Role based checking is skipped
		//if($this->role_id == 6 || $this->role_id == 5) {
		if (1) {
			if (!empty($this->request->data)) {
				//debug($this->request->data);
				$save_is_ok = true;
				if ($this->request->data['ExamGradeChange']['course_registration_id'] != "0") {
					$register_or_add = explode('~', $this->request->data['ExamGradeChange']['course_registration_id']);
					if (strcasecmp($register_or_add[1], 'add') == 0) {
						$grade_id = $this->ExamGradeChange->ExamGrade->find(
							'first',
							array(
								'fields' => array('ExamGrade.id'),
								'conditions' =>
								array(
									'ExamGrade.course_add_id' => $register_or_add[0]
								),
								'order' => array('ExamGrade.created DESC'),
								'recursive' => -1
							)
						);
						$grade_id = $grade_id['ExamGrade']['id'];
						$published_course_id = $this->ExamGradeChange->ExamGrade->CourseAdd->field('published_course_id', array('id' => $register_or_add[0]));
						$grade_history = $this->ExamGradeChange->ExamGrade->CourseAdd->getCourseAddGradeHistory($register_or_add[0]);
						$student = $this->ExamGradeChange->ExamGrade->CourseAdd->find(
							'first',
							array(
								'conditions' => array('CourseAdd.id' => $register_or_add[0]),
								'contain' => array('Student')
							)
						);
						$student = $student['Student'];
						$on_progress = $this->ExamGradeChange->ExamGrade->CourseAdd->isAnyGradeOnProcess($register_or_add[0]);
					} else {
						$grade_id = $this->ExamGradeChange->ExamGrade->find(
							'first',
							array(
								'fields' => array('ExamGrade.id'),
								'conditions' =>
								array(
									'ExamGrade.course_registration_id' => $register_or_add[0]
								),
								'order' => array('ExamGrade.created DESC'),
								'recursive' => -1
							)
						);
						$grade_id = $grade_id['ExamGrade']['id'];
						$published_course_id = $this->ExamGradeChange->ExamGrade->CourseRegistration->field('published_course_id', array('id' => $register_or_add[0]));
						$grade_history = $this->ExamGradeChange->ExamGrade->CourseRegistration->getCourseRegistrationGradeHistory($register_or_add[0]);
						$student = $this->ExamGradeChange->ExamGrade->CourseRegistration->find(
							'first',
							array(
								'conditions' => array('CourseRegistration.id' => $register_or_add[0]),
								'contain' => array('Student')
							)
						);
						$student = $student['Student'];
						$on_progress = $this->ExamGradeChange->ExamGrade->CourseRegistration->isAnyGradeOnProcess($register_or_add[0]);
					}
					if (($departement == 1 && $student['department_id'] != $this->department_id) ||
						($departement == 0 && $student['college_id'] != $this->college_id)
					) {
						if($departement == 1){
							$this->cakeError('youSuck');
						}					
					}
					if (empty($published_course_id)) {
						$this->Session->setFlash('<span></span>' . __('Invalid course is selected.'), 'default', array('class' => 'error-box error-message'));
						return $this->redirect(array('action' => 'add'));
					}
					if (empty($grade_id)) {
						$this->Session->setFlash('<span></span>' . __('Exam grade is not yet submitted for the selected course and student. Makeup exam result can only be submitted after the instructor submit student grade. Please tell the assigned instructor to submit grade for the student or you can submit on behalf of him.'), 'default', array('class' => 'error-box error-message'));
						$save_is_ok = false;
					} else {
						$status = $this->ExamGradeChange->ExamGrade->gradeCanBeChanged($grade_id);
						if ($status === true) {
							$exam_grade_change['ExamGradeChange']['exam_grade_id'] = $grade_id;
							$previous_grade = $this->ExamGradeChange->ExamGrade->field('grade', array('id' => $grade_id));
						} else {
							$this->Session->setFlash('<span></span>' . __($status), 'default', array('class' => 'error-box error-message'));
							$save_is_ok = false;
						}
					}
				} else {
					$this->Session->setFlash('<span></span>' . __('You are required to select the course for which the student takes makeup exam.'), 'default', array('class' => 'error-box error-message'));
					$save_is_ok = false;
				}

				if (!isset($this->request->data['ExamGradeChange']['student_id']) || $this->request->data['ExamGradeChange']['student_id'] == "0") {
					$this->Session->setFlash('<span></span>' . __('You are required to select the student who takes the makeup exam.'), 'default', array('class' => 'error-box error-message'));
					$save_is_ok = false;
				} else if ($save_is_ok && (!isset($this->request->data['ExamGradeChange']['grade']) || $this->request->data['ExamGradeChange']['grade'] == "" || $this->request->data['ExamGradeChange']['grade'] == "0")) {
					$this->Session->setFlash('<span></span>' . __('You are required to select exam grade the student scores for the course you selected.'), 'default', array('class' => 'error-box error-message'));
					$save_is_ok = false;
				} else if ($save_is_ok && !$this->ExamGradeChange->ExamGrade->CourseRegistration->PublishedCourse->isItValidGradeForPublishedCourse($published_course_id, $this->request->data['ExamGradeChange']['grade'])) {
					$this->cakeError('youSuck');
				} else
					$exam_grade_change['ExamGradeChange']['grade'] = $this->request->data['ExamGradeChange']['grade'];

				if ($save_is_ok && !(is_numeric($this->request->data['ExamGradeChange']['makeup_exam_result']) && $this->request->data['ExamGradeChange']['makeup_exam_result'] != "" && $this->request->data['ExamGradeChange']['makeup_exam_result'] >= 0 && $this->request->data['ExamGradeChange']['makeup_exam_result'] <= 100)) {
					$this->Session->setFlash('<span></span>' . __('Please enter a valid exam result.'), 'default', array('class' => 'error-box error-message'));
					$save_is_ok = false;
				} else
					$exam_grade_change['ExamGradeChange']['makeup_exam_result'] = $this->request->data['ExamGradeChange']['makeup_exam_result'];

				$exam_grade_change['ExamGradeChange']['reason'] = $this->request->data['ExamGradeChange']['reason'];
				$exam_grade_change['ExamGradeChange']['initiated_by_department'] = 1;
				$exam_grade_change['ExamGradeChange']['department_approval'] = 1;
				$exam_grade_change['ExamGradeChange']['minute_number'] = $this->request->data['ExamGradeChange']['minute_number'];

				$this->ExamGradeChange->create();
				if ($save_is_ok) {
					if ($this->ExamGradeChange->save($exam_grade_change)) {
						$this->Session->setFlash('<span></span>' . __('The makeup/supplementary exam result has been saved.'), 'default', array('class' => 'success-box success-message'));
						return $this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('<span></span>' . __('The makeup exam result could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
					}
				}

				//redisplay
				$programs = $this->ExamGradeChange->ExamGrade->CourseRegistration->PublishedCourse->Section->Program->find('list');
				$program_id = $this->request->data['ExamGradeChange']['program_id'];

				$student_sections = $this->ExamGradeChange->ExamGrade->CourseRegistration->PublishedCourse->Section->allDepartmentSectionsOrganizedByProgramType(($departement == 1 ? $this->department_id : $this->college_id), $departement, $this->request->data['ExamGradeChange']['program_id']);
				$student_section_id = $this->request->data['ExamGradeChange']['student_section_id'];

				$students = $this->ExamGradeChange->ExamGrade->CourseRegistration->PublishedCourse->Section->allStudents($student_section_id);
				$student_id = $this->request->data['ExamGradeChange']['student_id'];
				//debug($students);
				////
				$student_registered_courses = $this->ExamGradeChange->ExamGrade->CourseRegistration->Student->getStudentRegisteredAndAddCourses($student_id);
				$registered_course_id = $this->request->data['ExamGradeChange']['course_registration_id'];

				if (isset($published_course_id))
					$exam_grades = $this->ExamGradeChange->ExamGrade->CourseRegistration->getPublishedCourseGradeScaleList($published_course_id);
				else
					$exam_grades = array();
				$exam_grades = array('0' => '--- Select Grade ---') + $exam_grades;
				//$exam_grades = $exam_grades + array('NG' => 'NG');
				//debug($exam_grades);
				if (isset($this->request->data['ExamGradeChange']['grade']) && $this->request->data['ExamGradeChange']['grade'] != "")
					$grade = $this->request->data['ExamGradeChange']['grade'];
				else
					$grade = "0";
			} else {
				$programs = $this->ExamGradeChange->ExamGrade->CourseRegistration->PublishedCourse->Section->Program->find('list');
				$program_id = "";
				
				$student_sections = $this->ExamGradeChange->ExamGrade->CourseRegistration->PublishedCourse->Section->allDepartmentSectionsOrganizedByProgramType(($departement == 1 ? $this->department_id : $this->college_id), $departement, 1);
				$student_section_id = "0";

				$students = array();
				$student_id = "0";

				$student_registered_courses = array();
				$registered_course_id = "0";

				$exam_grades = array('0' => '--- Select Grade ---');
				$grade = "0";

				$grade_history = "";
			}

			$student_sections = array('0' => '--- Select Section ---') + $student_sections;
			$students = array('0' => '--- Select Student ---') + $students;
			$student_registered_courses = array('0' => '--- Select Course ---') + $student_registered_courses;

			$this->set(compact('student_sections', 'student_section_id', 'programs', 'program_id', 'students', 'student_id', 'student_registered_courses', 'registered_course_id', 'exam_grades', 'grade', 'grade_history', 'register_or_add'));
		} else {
			$this->Session->setFlash('<span></span>' . __('You need to have either college or department role to access makeup exam administration. Please contact your system administrator to get college or department role.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
		}
	}

	function delete($id = null)
	{
		if (!$id || !$this->ExamGradeChange->exists($id)) {
			$this->Session->setFlash(__('Invalid id for exam grade change deletion.'));
			return $this->redirect(array('controller' => 'makeup_exams', 'action' => 'index'));
		}
		if ($this->ExamGradeChange->canItBeDeleted($id)) {
			if ($this->ExamGradeChange->delete($id)) {
				$this->Session->setFlash('<span></span>' . __('Exam grade change is deleted'), 'default', array('class' => 'success-box success-message'));
				return $this->redirect(array('controller' => 'makeup_exams', 'action' => 'index'));
			}
			$this->Session->setFlash('<span></span>' . __('Exam grade change was not deleted'));
			return $this->redirect(array('controller' => 'makeup_exams', 'action' => 'index'), 'default', array('class' => 'error-box error-message'));
		} else {
			$this->Session->setFlash('<span></span>' . __('Exam grade change is either submitted by the instructor or already on approval process to delete.'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('controller' => 'makeup_exams', 'action' => 'index'));
		}
	}
}
