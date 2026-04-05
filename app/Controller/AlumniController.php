<?php
//App::uses('AppController', 'Controller');
App::import('Vendor', 'PhpExcelReader/Excel/reader');
class AlumniController extends AppController {

	public $name = 'Alumni';

	public $helpers = array('Xls', 'Media.Media');

	public $components = array('EthiopicDateTime', 'Paginator', 'AcademicYear', 'Email','MathCaptcha');

	public $menuOptions = array(
		//'parent' => 'graduation',
		'exclude' => array('index', 'edit', 'add'),
		'weight' => 2,
		'alias' => array(
			'check_alumni_survey' => 'Check Alumni Survey',
			'alumni_survey_view' => 'Baseline Survey View',
			'add_baselinesurvey_onbehalf' => 'Fill Baseline Survey On Behalf of Student'
		)
	);

	public $paginate = array();

	public function beforeRender()
	{
		parent::beforeRender();
		$acyear_array_data = $this->AcademicYear->acyear_array();
		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		$this->set(compact('acyear_array_data', 'defaultacademicyear'));
	}
	
	public function beforeFilter()
	{
        parent::beforeFilter();
        //$this->Security->unlockedActions();
        $this->Auth->Allow(
			//'add', 
			//'alumni_survey_view',
			'member_registration'
			//'check_alumni_survey'
		);
    }
    
    public function alumni_survey_view()
	{
		$this->paginate = array('contain' => array('Student' => array('SenateList', 'Department' => array('id', 'name')), 'AlumniResponse'));
    	 
		if (isset($this->request->data['Search']['gradution_academic_year']) && !empty($this->request->data['Search']['gradution_academic_year'])) {
			$this->paginate['conditions'][]['Alumnus.gradution_academic_year'] = $this->request->data['Search']['gradution_academic_year'];
		}
		
		if (isset($this->request->data['Search']['program_id']) && !empty($this->request->data['Search']['program_id'])) {
			$this->paginate['conditions'][]['Student.program_id'] = $this->request->data['Search']['program_id'];
		}

		if (isset($this->request->data['Search']['program_type_id']) && !empty($this->request->data['Search']['program_type_id'])) {
			$this->paginate['conditions'][]['Student.program_type_id'] = $this->request->data['Search']['program_type_id'];
		}
		
		if (isset($this->request->data['Search']['department_id']) && !empty($this->request->data['Search']['department_id'])) {

			$department_id = $this->request->data['Search']['department_id'];
			$college_id = explode('~', $department_id);

			if (count($college_id) > 1) {
				$this->paginate['conditions'][]['Student.college_id'] = $college_id[1];
			} else {
				$this->paginate['conditions'][]['Student.department_id'] = $department_id;
			}

			$default_department_id = $this->request->data['Search']['department_id'];
		}

		if (isset($this->request->data['Search']['name']) && !empty($this->request->data['Search']['name'])) {
			$this->paginate['conditions'][]['Alumnus.full_name like '] = $this->request->data['SenateList']['minute_number'].'%';
		}

		if (isset($this->request->data['Search']['limit'])) {
			$this->paginate['limit'] = $this->request->data['Search']['limit'];
			$this->paginate['maxLimit'] = $this->request->data['Search']['limit'];
		}

	  	//debug($this->paginate);

		$this->Paginator->settings = $this->paginate;

		if (isset($this->Paginator->settings['conditions'])) {
			$alumni = $this->Paginator->paginate('Alumnus');
		} else {
			$alumni = array();
		}

		if (empty($alumni) && isset($this->request->data) && !empty($this->request->data)) {
			$this->Flash->info(__('There is no student based on your search criteria.'));
		}
		
		//Issue Student Password button is clicked
		if (isset($this->request->data['getAlumniQuestionnaireInExcel'])) {

			$surveyQuestions = $this->Alumnus->AlumniResponse->SurveyQuestion->find('list', array('fields' => array('SurveyQuestion.id', 'SurveyQuestion.question_english')));

			$student_ids = array();

			if (!empty($this->request->data['Alumnus'])) {
				foreach ($this->request->data['Alumnus'] as $key => $student) {
					if (is_numeric($key) && !empty($student['student_id'])) {
						if (isset($student['gp']) && $student['gp'] == 1) {
							$student_ids[] = $student['student_id'];
						}
					}
				}
			}

			if (empty($student_ids)) {
				$this->Flash->error(__('You are required to select at least one student.'));
			} else {
				$alumniSurvey = $this->Alumnus->getCompletedSurvey($student_ids);

				if (empty($alumniSurvey)) {
					$this->Flash->info(__('Baseline Survey Questionnaire generation has experiance problem  for the selected students. Please try again.'));
				} else {
					$this->autoLayout = false;
					$filename = 'baselinequestionnaire' . date('Ymd H:i:s');
					$this->set(compact('alumniSurvey', 'surveyQuestions', 'filename'));
					$this->render('/Elements/baseline_survey_questionnaire_xls');
					return;
				}
			}
		}

		if (isset($this->request->data['deleteAlumniQuestionnaireInExcel'])) {
			
			$surveyQuestions = $this->Alumnus->AlumniResponse->SurveyQuestion->find('list', array('fields' => array('SurveyQuestion.id', 'SurveyQuestion.question_english')));
			
			$student_ids = array();

			if (!empty($this->request->data['Alumnus'])) {
				foreach ($this->request->data['Alumnus'] as $key => $student) {
					if (is_numeric($key) && !empty($student['student_id'])) {
						if (isset($student['gp']) && $student['gp'] == 1) {
							$student_ids[] = $student['student_id'];
						}
					}
				}
			}

			if (empty($student_ids)) {
				$this->Flash->error(__('You are required to select at least one student.'));
			} else {
				$alumniSurvey = $this->Alumnus->getSelectedAlumniSurvey($student_ids);
				$deletedCount = 0;
				
				if (!empty($alumniSurvey)) {
					foreach ($alumniSurvey as $alk => $alv) {
						if ($this->Alumnus->delete($alv['Alumnus']['id'])) {
							$deletedCount++;
						}
					}
				}

				if ($deletedCount) {
					$this->Flash->success(__('You have deleted ' . $deletedCount . ' alumni baseline survey, please ask them to fill again.'));
					return $this->redirect(array('controller' => 'alumni', 'action' => "alumni_survey_view"));
				}
			}
		}

		$programs = $this->Alumnus->Student->Program->find('list', array('conditions' => array('Program.id' => $this->program_ids, 'Program.active' => 1)));
		$programTypes = $this->Alumnus->Student->ProgramType->find('list', array('conditions' => array('ProgramType.id' => $this->program_type_ids, 'ProgramType.active' => 1)));

		if ($this->Session->read('Auth.User')['is_admin'] == 1 && $this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR ) {
			//$departments = $this->Alumnus->Student->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_ids)));
			$departments = $this->Alumnus->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);
			$departments = array(0 => 'All University Students') + $departments;
		} else {
			//$departments = $this->Alumnus->Student->Department->find('list');
			$departments = $this->Alumnus->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);
		}

		$default_department_id = null;
		$this->set(compact('programs', 'programTypes', 'alumni', 'departments', 'default_department_id'));
    }

	public function index() 
	{
	   
	}

	public function view($id = null)
	{
		if (!$this->Alumnus->exists($id)) {
			throw new NotFoundException(__('Invalid Alumnus'));
		}

		$options = array('conditions' => array('Alumnus.' . $this->Alumnus->primaryKey => $id));
		$this->set('alumnus', $this->Alumnus->find('first', $options));
	}

	public function add()
	{
		$student_id = null;

		$student = $this->Alumnus->Student->find('first', array('conditions' => array('Student.studentnumber' => $this->Auth->user('username')), 'contain' => array('GraduateList', 'User')));
		
		if (isset($student['Student']['id']) && !empty($student['Student']['id'])) {
			//check if it exists
			$student_id = $student['Student']['id'];
		} else {
			$this->Flash->warning(__('You are not elegible to fill the survey. The Alumni baseline survey is only available for graduting students.'));
			return $this->redirect('/');
		}

		if (empty($student_id) || empty($student) || (!empty($student_id) && !$this->Alumnus->Student->exists($student_id))) {
			$this->Flash->warning(__('You are not elegible to fill the survey. The Alumni baseline survey is only available for graduting students.'));
			return $this->redirect('/');
		}

		if (!$this->Alumnus->checkIfStudentGradutingClass($student_id)) {
			$this->Flash->warning(__('Either you are not graduting class student or your department did not defined a final year project as thesis or project work. You can not fill alumni baseline survey at this time, please try again later after you are registered for final year reaserch, project work or thesis.'));
			return $this->redirect('/');
		}

		//$student_id=2020;
		$filled1stLevelQuestionair = $this->Alumnus->completedRoundOneQuestionner($student_id);

		if ($filled1stLevelQuestionair == true) {
			$this->Flash->success(__('Thank you for completing alumni baseline questionnair. Congratulations for your graduation and part of our alumni.'));
			return $this->redirect(array('controller' => 'exam_grades', 'action' => "student_grade_view"));
		} else if ($this->Alumnus->checkIfStudentGradutingClass($student_id) == false && false) {
			$this->Flash->error(__('You are not elegible to fill the survey. The survey is intended only for graduating class.'));
			return $this->redirect(array('controller' => 'exam_grades', 'action' => "student_grade_view"));
		}

		//debug($this->Auth->user('username'));

		if ($this->request->is('post')) {
			//debug($this->request);
			$this->request->data = $this->Alumnus->formatResponse($this->request->data);
			$this->Alumnus->create();
			if ($this->Alumnus->saveAll($this->request->data)) {
				$this->Flash->success(__('THANK YOU FOR YOUR PARTICIPATION!'));
				return $this->redirect(array('controller' => 'exam_grades', 'action' => "student_grade_view"));
			} else {
				$this->Flash->error(__('Your response could not be saved. Please try again.'));
				debug($this->Alumnus->invalidFields());
			}
		}


		$surveyQuestions = $this->Alumnus->AlumniResponse->SurveyQuestion->find('all', array('contain' => array('SurveyQuestionAnswer')));
		$student = $this->Alumnus->Student->find('first', array('conditions' => array('Student.id' => $student_id), 'contain' => array('Region', 'Curriculum')));
		$student['Student']['age'] = $this->Alumnus->Student->getAge($student['Student']['birthdate']);

		$regions = $this->Alumnus->Student->Region->find('list', array('fields' => array('Region.name', 'Region.name')));
		$sexes = array('female' => 'Female', 'male' => 'Male');
		$university = ClassRegistry::init('University')->getStudentUnivrsity($student_id);
		$this->set(compact('surveyQuestions', 'sexes', 'university', 'student', 'regions', 'student_id'));

	}
	
	public function add_baselinesurvey_onbehalf() 
	{

		$student_id = 0;
		$everythingfine = false;

		if (!empty($this->request->data) && isset($this->request->data['continue'])) {
			if (!empty($this->request->data['Alumnus']['studentID'])) {
				$student_id_valid = $this->Alumnus->Student->find('count', array('conditions' => array('Student.studentnumber' => trim($this->request->data['Alumnus']['studentID']))));
				//debug($student_id_valid);
				$studentIDs = 1;
				if ($student_id_valid > 0) {
					$everythingfine = true;
					$student_id = $this->Alumnus->Student->field('id', array('studentnumber' => trim($this->request->data['Alumnus']['studentID'])));
				} else {
					if ($student_id_valid == 0) {
						$this->Flash->error(__('You dont have the privilage to view the selected students profile.'));
					} else {
						$this->Flash->error(__('The provided student number is not valid.'));
					}
				}
			} else {
				$this->Flash->error(__('Please provide student number or ID to continue.'));
			}
		}

		if ($everythingfine) {

			$student = $this->Alumnus->Student->find('first', array('conditions' => array('Student.id' => $student_id), 'contain' => array('GraduateList', 'User')));

			if (isset($student['Student']['id']) && !empty($student['Student']['id'])) {
				//check if it exists
				$student_id = $student['Student']['id'];
			} else {
				$this->Flash->warning(__('You are not elegible to fill the survey. The Alumni baseline survey is only available for graduting students.'));
				return $this->redirect('/');
			}

			if ($this->Alumnus->checkIfStudentGradutingClass($student_id) == false) {
				$this->Flash->warning(__('Either you are not graduting class student or your department did not defined a final year project as thesis or project work. You can not fill alumni baseline survey at this time, please try again later after you are registered for final year reaserch, project work or thesis.'));
				return $this->redirect('/');
			}

			//$student_id=2020;
			$filled1stLevelQuestionair = $this->Alumnus->completedRoundOneQuestionner($student_id);

			if ($filled1stLevelQuestionair == true) {
				$this->Flash->success(__('Thank you for completing alumni baseline questionnair. Congratulations for your graduation and part of our alumni.'));
				return $this->redirect('/');
			} else if ($this->Alumnus->checkIfStudentGradutingClass($student_id) == false && false) {
				$this->Flash->warning(__('You are not elegible to fill the survey. The survey is intended only for graduating class students.'));
				return $this->redirect('/');
			}

			$surveyQuestions = $this->Alumnus->AlumniResponse->SurveyQuestion->find('all', array('contain' => array('SurveyQuestionAnswer')));
			$student = $this->Alumnus->Student->find('first', array('conditions' => array('Student.id' => $student_id), 'contain' => array('Region', 'Curriculum')));
			$student['Student']['age'] = $this->Alumnus->Student->getAge($student['Student']['birthdate']);

			$regions = $this->Alumnus->Student->Region->find('list', array('fields' => array('Region.name', 'Region.name')));
			$sexes = array('female' => 'Female', 'male' => 'Male');
			$university = ClassRegistry::init('University')->getStudentUnivrsity($student_id);

			$this->set(compact('surveyQuestions', 'sexes', 'university', 'student', 'regions', 'student_id'));

		}

		if ($this->request->is('post') && isset($this->request->data['fillAlumnus'])) {
			$this->request->data = $this->Alumnus->formatResponse($this->request->data);
			$this->Alumnus->create();
			if ($this->Alumnus->saveAll($this->request->data)) {
				$this->Flash->success(__('THANK YOU FOR YOUR PARTICIPATION!'));
				//return $this->redirect(array('controller'=>'exam_grades','action' => "student_grade_view"));
				$this->redirect('/');
			} else {
				$this->Flash->error(__('Your response could not be saved. Please try again.'));
			}
		}

		$this->set(compact('everythingfine'));
	}

	public function check_alumni_survey()
	{
		//debug($this->request->data);
		
		if (!empty($this->request->data) && isset($this->request->data['check'])) {

			$studentValid = $this->Alumnus->Student->find('first', array('conditions' => array('Student.studentnumber' => trim($this->request->data['Alumnus']['studentID'])), 'recursive' => -1));
			
			if (isset($studentValid) && !empty($studentValid)) {

				$alumniDetail = $this->Alumnus->find('first', array('conditions' => array('Alumnus.student_id' => $studentValid['Student']['id']), 'contain' => array('AlumniResponse' => array('SurveyQuestion', 'SurveyQuestionAnswer'), 'Student' => array('GraduateList'))));

				if (!isset($alumniDetail) && empty($alumniDetail)) {
					$this->Flash->info(__('The student is not an alumni member and has not completed alumni survey.'));
				}

				//debug($alumniDetail);

				$surveyQuestions = $this->Alumnus->AlumniResponse->SurveyQuestion->find('all', array('contain' => array('SurveyQuestionAnswer')));
				$student = $this->Alumnus->Student->find('first', array('conditions' => array('Student.id' => $studentValid['Student']['id']), 'contain' => array('Region', 'Curriculum')));
				$student['Student']['age'] = $this->Alumnus->Student->getAge($studentValid['Student']['birthdate']);

				$regions = $this->Alumnus->Student->Region->find('list', array('fields' => array('Region.name', 'Region.name')));
				$sexes = array('female' => 'Female', 'male' => 'Male');
				$university = ClassRegistry::init('University')->getStudentUnivrsity($studentValid['Student']['id']);

				$this->set(compact('alumniDetail', 'student', 'regions', 'university', 'surveyQuestions'));
			} else {
				$this->Flash->error(__('The provided student number is not valid.'));
			}
		}
	}

	public function member_registration()
	{

		//$this->layout = 'login';
        $this->layout = "page-alternative";

		if ($this->request->is('post') && isset($this->request->data['applyOnline']) && !empty($this->request->data['applyOnline'])) {

            if ((isset($this->request->data['Alumnus']['security_code'])
                && $this->MathCaptcha->validates($this->request->data['Alumnus']['security_code']))) {
            } else {
                $this->Flash->error('Please enter the correct answer to the math question.');

                $titles = array('Mr' => 'Mr', 'Ms' => 'Ms', 'Mrs' => 'Mrs', 'Dr.' => 'Dr.', 'Professor' => 'Professor');

                $programs = array('Degree' => 'Bachelor\'s Degree', 'Master' => 'Master\'s Degree', 'PhD' => 'PhD', 'Diploma' => 'Diploma');

                $institute_colleges = $this->Alumnus->Student->College->find('list', array('fields' => array('name', 'name'), 'conditions' => array('NOT' => array('College.id' => Configure::read('only_stream_based_freshman_college_ids')), 'College.active' => 1), 'order' => array('College.name' => 'ASC')));

                $countries = $this->Alumnus->Student->Country->find('list', array('fields' => array('name', 'name')));

                $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

                $this->set(compact('titles', 'institute_colleges', 'programs', 'countries'));

                return ;
            }

			$applicationnumber = ClassRegistry::init('AlumniMember')->nextTrackingNumber();

			$data['AlumniMember'] = $this->request->data['Alumnus'];
			$data['AlumniMember']['trackingnumber'] = $applicationnumber;

			//debug($this->request->data);

			if (!empty($data['AlumniMember']['date_of_birth']) && is_array($data['AlumniMember']['date_of_birth'])) {
				$data['AlumniMember']['date_of_birth'] = $data['AlumniMember']['date_of_birth']['year'] . '-' . $data['AlumniMember']['date_of_birth']['month'] . '-' . $data['AlumniMember']['date_of_birth']['day'];
			}

			if (!empty($data['AlumniMember']['gradution']) && is_array($data['AlumniMember']['gradution'])) {
				$data['AlumniMember']['gradution'] = $data['AlumniMember']['gradution']['year'];
			}

			//debug($data);
            /*

            */


			ClassRegistry::init('AlumniMember')->create();
			ClassRegistry::init('AlumniMember')->set($data);

			if (ClassRegistry::init('AlumniMember')->save($data)) {

				$fullname = $data['AlumniMember']['title'] . '. ' . $data['AlumniMember']['first_name'] . ' ' . $data['AlumniMember']['last_name'];
				$autoMessage = "$fullname registered to our alumni membership database with an alumni number " . $data['AlumniMember']['trackingnumber'];
				ClassRegistry::init('AutoMessage')->alumniRegistrationMessage($autoMessage);

				$message = "<p>Dear $fullname,</p>
			    Now you are officially Arbaminch University alumni member. You will recieve information related to alumni events through your email. Your alumni number is " . $data['AlumniMember']['trackingnumber'] . " and provide this number whenever you need service from Arba Minch University.<br /> 
				<p>Be our follower on the following social medias: </p> 
				<ul>
			     	<li>https://www.facebook.com/arbaminchuniversityalumni</li>
			      	<li>https://www.twitter.com/alumniarbaminch</li>
			       	<li>https://www.linkedin.com/arba-minch-university-alumni</li>
			    </ul> 
			    <br/>
			    Your faithfully<br/>
			    Alumni team!";

				if (!empty($data['AlumniMember']['email']) && filter_var($data['AlumniMember']['email'], FILTER_VALIDATE_EMAIL)) {
					
					$Email = new CakeEmail('default');
					$Email->template('onlineapplication');
					$Email->emailFormat('html');
					$Email->to($data['AlumniMember']['email']);
					$Email->subject('Congratulations! You\'ve successfully joined our alumni network.');
					$Email->viewVars(array('message' => $message));

					try {
						if ($Email->send()) {
							//debug('Email sent successfully');
						} else {
							//$this->Flash->error(__('Email could not be sent, please try again.'));
						}
					} catch (Exception $e) {
						//$this->Flash->error(__('Email could not be sent, please try again.'));
						//debug($e->getMessage());
					}
				}

				//$this->Flash->success(__("Now you are officially Arbaminch University alumni member. You will recieve information related to alumni events through your email."));
				$this->Session->setFlash('Now you are officially Arbaminch University alumni member. You will recieve information related to alumni events through your email.', 'default', ['class' => 'success', 'delay' => 15000]);
				unset($this->request->data);
				return $this->redirect('/');

			} else {
				$this->Flash->error(__('The Your Alumni membership request could not be saved, please try again.'));
				$errors = ClassRegistry::init('AlumniMember')->validationErrors;
				//$errors=ClassRegistry::init('AlumniMember')->invalidFields();
				$this->set(compact('errors'));
			}

		}



        //$titles = ClassRegistry::init('Title')->find('list', array('fields' => array('title', 'title')));
        $titles = array('Mr' => 'Mr', 'Ms' => 'Ms', 'Mrs' => 'Mrs', 'Dr.' => 'Dr.', 'Professor' => 'Professor');

        $programs = array('Degree' => 'Bachelor\'s Degree', 'Master' => 'Master\'s Degree', 'PhD' => 'PhD', 'Diploma' => 'Diploma');

        $institute_colleges = $this->Alumnus->Student->College->find('list', array('fields' => array('name', 'name'), 'conditions' => array('NOT' => array('College.id' => Configure::read('only_stream_based_freshman_college_ids')), 'College.active' => 1), 'order' => array('College.name' => 'ASC')));

        $countries = $this->Alumnus->Student->Country->find('list', array('fields' => array('name', 'name')));

        $this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

        $this->set(compact('titles', 'institute_colleges', 'programs', 'countries'));
	}
}
