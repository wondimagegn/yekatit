<?php
class AutoMessage extends AppModel {
	var $name = 'AutoMessage';
	var $validate = array(
		'message' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function getMessages($user_id = null) {
		$auto_messages = $this->find('all',
			array(
				'conditions' =>
				array(
					'AutoMessage.read = 0',
					'AutoMessage.user_id' => $user_id
				),
				'order' => array('AutoMessage.created DESC'),
				'recursive' => -1,
				'limit' => 5
			)
		);
		return $auto_messages;
	}
	
	function sendMessage($user_id = null, $message = null, $type = null){
		$auto_message = array();
		$auto_message['message'] = $message;
		if($type === 1)
			$auto_message['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message['message'].'</p>';
		else if($type === -1)
			$auto_message['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message['message'].'</p>';
		else if($type === 0)
			$auto_message['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="on-process">'.$auto_message['message'].'</p>';
		$auto_message['read'] = 0;
		$auto_message['user_id'] = $user_id;
		$this->save($auto_message);
	}
	
	function alumniRegistrationMessage($message){
		$auto_message = array();
		$usersLists=ClassRegistry::init('User')->find('list',array('conditions'=>array('User.role_id'=>13),'fields'=>array('User.id','User.id')));
		foreach($usersLists as $usr){
			$auto_message['message'] = $message;
			if($type === 1)
				$auto_message['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message['message'].'</p>';
			else if($type === -1)
				$auto_message['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message['message'].'</p>';
			else if($type === 0)
				$auto_message['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="on-process">'.$auto_message['message'].'</p>';
			$auto_message['read'] = 0;
			$auto_message['user_id'] = $usr;
			$this->save($auto_message);
		}
	}


	function postMessageToGroup($role_id = null,$subject=null,
		$message = null,$data=null)
	{
		debug($message);
		$auto_message['message'] = '
		<h7>'.$subject.'</h7>
		<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.nl2br(htmlentities($message))
		.'</p>';

		$usersMessage['AutoMessage']=$this->User->getListOfUsersRole($role_id,$auto_message['message'],$data);
		debug($usersMessage);
		if(!empty($usersMessage)){
			return $this->saveAll($usersMessage['AutoMessage'], array('validate' => false));
		}

		return false;
	}
	
	function sendNotificationOnRegistrarGradeConfirmation($confirmed_grades = null) {
		//Notification to student
		//debug($confirmed_grades);
		$grade_ids = array();
		$auto_message = array();
		if(!empty($confirmed_grades) && $confirmed_grades[0]['registrar_approval'] == 1) {
			foreach($confirmed_grades as $key => $grade) {
				$grade_ids[] = $grade['id'];
			}
			$grade_details = ClassRegistry::init('ExamGrade')->find('all',
				array(
					'conditions' =>
					array(
						'ExamGrade.id' => $grade_ids
					),
					'contain' =>
					array(
						'CourseAdd' => array('PublishedCourse' => array('Course'), 'Student'),
						'CourseRegistration' => array('PublishedCourse' => array('Course'), 'Student')
					)
				)
			);
			
			//Student notification
			foreach($grade_details as $key => $grade_detail) {
				if(isset($grade_detail['CourseRegistration']['Student']) && !empty($grade_detail['CourseRegistration']['Student']['user_id'])) {
					$index = count($auto_message);
					$auto_message[$index]['message'] = 'You get <strong>'.$grade_detail['ExamGrade']['grade'].'</strong> for the course <u>'.$grade_detail['CourseRegistration']['PublishedCourse']['Course']['course_title'].' ('.$grade_detail['CourseRegistration']['PublishedCourse']['Course']['course_code'].')</u>.';
					$auto_message[$index]['read'] = 0;
					$auto_message[$index]['user_id'] = $grade_detail['CourseRegistration']['Student']['user_id'];
				}
			}
		}
		//Instructor notification
		$index = count($auto_message);
		$course_instructor = ClassRegistry::init('PublishedCourse')->getInstructorByExamGradeId($confirmed_grades[0]['id']);
		$course = ClassRegistry::init('Course')->getCourseByExamGradeId($confirmed_grades[0]['id']);
		$section = ClassRegistry::init('Section')->getSectionByExamGradeId($confirmed_grades[0]['id']);
		$published_course = ClassRegistry::init('PublishedCourse')->getPublishedCourseByExamGradeId($confirmed_grades[0]['id']);
		if(!empty($course_instructor) && $course_instructor['user_id'] != "") {
			$auto_message[$index]['message'] = 'Your <u>'.$course['course_title'].' ('.$course['course_code'].')</u> grade submission is '.($confirmed_grades[0]['registrar_approval'] == 1 ? 'accepted' : 'rejected').' by the registrar for <u>'.($section['name']).'</u> section. <a href="/exam_results/add/'.$published_course['id'].'">View Grade</a>';

			if($confirmed_grades[0]['registrar_approval'] == -1)
				$auto_message[$index]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[$index]['message'].'</p>';
			else if($confirmed_grades[0]['registrar_approval'] == 1)
				$auto_message[$index]['message'] = '<p style="text-align:justify; 
				padding:0px; margin:0px" class="accepted">'.$auto_message[$index]['message'].'</p>';

			$auto_message[$index]['read'] = 0;
			$auto_message[$index]['user_id'] = $course_instructor['user_id'];
		}
		//Department notification
		$grade_ids = array();
		foreach($confirmed_grades as $key => $grade) {
			$grade_ids[] = $grade['id'];
		}
		$department_approved_bys = ClassRegistry::init('ExamGrade')->find('list',
			array(
				'conditions' =>
				array(
					'ExamGrade.id' => $grade_ids
				),
				'fields' => array('ExamGrade.department_approved_by'), 
				'recursive' => -1
			)
		);
		$department_approved_bys = array_unique($department_approved_bys);
		foreach($department_approved_bys as $key => $department_approved_by) {
			if(!empty($department_approved_by)) {
				$index = count($auto_message);
				$auto_message[$index]['message'] = '<u>'.$course['course_title'].' ('.$course['course_code'].')</u> course grade is '.($confirmed_grades[0]['registrar_approval'] == 1 ? 'accepted' : 'rejected').' by the registrar for <u>'.($section['name']).'</u> section. <a href="/exam_results/submit_grade_for_instructor/'.$published_course['id'].'">View Grade</a>';
				if($confirmed_grades[0]['registrar_approval'] == -1)
					$auto_message[$index]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[$index]['message'].'</p>';
				else if($confirmed_grades[0]['registrar_approval'] == 1)
					$auto_message[$index]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[$index]['message'].'</p>';
				$auto_message[$index]['read'] = 0;
				$auto_message[$index]['user_id'] = $department_approved_by;
			}
		}
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
		//debug($auto_message);
		//debug($grade_details);
	}
	
	 function sendNotificationOnInstructorAssignment($publishedCourseId = null) {
		    //Notification to student
		
		    $auto_message = array();
		    if(!empty($publishedCourseId)) {
			
			    $assignment_details = ClassRegistry::init('CourseInstructorAssignment')->find('all',
				    array(
					    'conditions' =>
					    array(
						    'CourseInstructorAssignment.published_course_id' => $publishedCourseId,
					    ),
					    'contain' =>
					    array(
						    'PublishedCourse'=>array('Department'=>array('fields'=>array('id',
						    'name')),'College'=>array('fields'=>array('id',
						    'name')),'GivenByDepartment'=>array('fields'=>array('id',
						    'name')),'Program',
						    'ProgramType','Course'), 
						    'Staff'=>array('User','Title'),
						    'Section'=>array('YearLevel')
					    )
				    )
			    );
			
			    //Instructor and Course Owner Department Notification
			    
			    foreach($assignment_details as $key => $assignment_detail) {
				    if(
				    !empty($assignment_detail['Staff']['user_id'])) {
					    $index = count($auto_message);

                       if(empty($assignment_detail['Section']['YearLevel']['name'])) {
					    $auto_message[$index]['message'] = 'You have assigned  to <strong><u>'.
					    $assignment_detail['PublishedCourse']['Course']['course_title'].'('.
					     $assignment_detail['PublishedCourse']['Course']['course_code'].')'.'</u> 
					     <br /> Section:'.$assignment_detail['Section']['name'].' <br/> Year Level: Pre <br/> 
					     Department: '.$assignment_detail['PublishedCourse']['College']['name'].' <br/> 
					     Program: '.$assignment_detail['PublishedCourse']['Program']['name'].' <br/> 
					     Program Type: '.$assignment_detail['PublishedCourse']['ProgramType']['name'].'<br/> 
					     Academic Year: '.$assignment_detail['PublishedCourse']['academic_year'].' <br/> 
					     Semester: '.$assignment_detail['PublishedCourse']['semester'].'';
                        } else {
                          	    $auto_message[$index]['message'] = 'You have assigned  to <strong><u>'.
					    $assignment_detail['PublishedCourse']['Course']['course_title'].'('.
					     $assignment_detail['PublishedCourse']['Course']['course_code'].')'.'</u> 
					     <br /> Section:'.$assignment_detail['Section']['name'].' <br/> 
					     Year Level: '.$assignment_detail['Section']['YearLevel']['name'].'<br/> 
					     Department: '.$assignment_detail['PublishedCourse']['Department']['name'].' <br/> 
					     Program: '.$assignment_detail['PublishedCourse']['Program']['name'].' <br/> 
					     Program Type: '.$assignment_detail['PublishedCourse']['ProgramType']['name'].'<br/> 
					     Academic Year: '.$assignment_detail['PublishedCourse']['academic_year'].' <br/> 
					     Semester: '.$assignment_detail['PublishedCourse']['semester'].'';

                       }


					    $auto_message[$index]['read'] = 0;
					    $auto_message[$index]['user_id'] = $assignment_detail['Staff']['user_id'];
				    }
				    
                    if (empty($assignment_detail['PublishedCourse']['department_id'])) 
                    {

                      
				            $ownerDepartmentUser = ClassRegistry::init('User')->find('first',
			                array(
				                'conditions' =>
				                array(
					                'User.is_admin' =>1,
					                 'User.role_id' =>ROLE_COLLEGE,
					                'User.id IN (select user_id from staffs where college_id='.
					                $assignment_detail['PublishedCourse']['college_id'].')' 
				                ),
				
				                'recursive' => -1
			                )
		                  );
		
					    $index = count($auto_message);
					    $auto_message[$index]['message'] = 'The course you disptached <strong><u>'.
					    $assignment_detail['PublishedCourse']['Course']['course_title'].'('.
					     $assignment_detail['PublishedCourse']['Course']['course_code'].')'.'</u>  to department of  
					     '.$assignment_detail['PublishedCourse']['GivenByDepartment']['name'].' has  assigned '.$assignment_detail['Staff']['Title']['title'].' '.
					     $assignment_detail['Staff']['full_name'].' 
					     <br /> Section:'.$assignment_detail['Section']['name'].' <br/> 
					     Year Level: Pre<br/> 
					     Department: '.$assignment_detail['PublishedCourse']['College']['name'].' <br/> 
					     Program: '.$assignment_detail['PublishedCourse']['Program']['name'].' <br/> 
					     Program Type: '.$assignment_detail['PublishedCourse']['ProgramType']['name'].'<br/> 
					     Academic Year: '.$assignment_detail['PublishedCourse']['academic_year'].' <br/> 
					     Semester: '.$assignment_detail['PublishedCourse']['semester'].'';
					    $auto_message[$index]['read'] = 0;
					    $auto_message[$index]['user_id'] = $ownerDepartmentUser['User']['id'];

				    } else if($assignment_detail['PublishedCourse']['department_id']!=
				    $assignment_detail['PublishedCourse']['given_by_department_id']) {
				            
				         
				            $ownerDepartmentUser = ClassRegistry::init('User')->find('first',
			                array(
				                'conditions' =>
				                array(
					                'User.is_admin' =>1,
					                 'User.role_id' =>ROLE_DEPARTMENT,
					                'User.id IN (select user_id from staffs where department_id='.
					                $assignment_detail['PublishedCourse']['department_id'].')' 
				                ),
				
				                'recursive' => -1
			                )
		                  );
		
					    $index = count($auto_message);
					    $auto_message[$index]['message'] = 'The course you disptached <strong><u>'.
					    $assignment_detail['PublishedCourse']['Course']['course_title'].'('.
					     $assignment_detail['PublishedCourse']['Course']['course_code'].')'.'</u>  to department of  
					     '.$assignment_detail['PublishedCourse']['GivenByDepartment']['name'].' has assigned '.$assignment_detail['Staff']['Title']['title'].' '.
					     $assignment_detail['Staff']['full_name'].' 
					     <br /> Section:'.$assignment_detail['Section']['name'].' <br/> 
					     Year Level: '.$assignment_detail['Section']['YearLevel']['name'].'<br/> 
					     Department: '.$assignment_detail['PublishedCourse']['Department']['name'].' <br/> 
					     Program: '.$assignment_detail['PublishedCourse']['Program']['name'].' <br/> 
					     Program Type: '.$assignment_detail['PublishedCourse']['ProgramType']['name'].'<br/> 
					     Academic Year: '.$assignment_detail['PublishedCourse']['academic_year'].' <br/> 
					     Semester: '.$assignment_detail['PublishedCourse']['semester'].'';
					    $auto_message[$index]['read'] = 0;
					    $auto_message[$index]['user_id'] = $ownerDepartmentUser['User']['id'];
				    }
				    
				    
				    
				    
			    }
			   
		  }
		
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
		
	}
   
  
	
	function sendNotificationOnDepartmentGradeChangeApproval($grade_change = null) {
		$auto_message = array();
		$exam_garde_change = ClassRegistry::init('ExamGradeChange')->find('first',
			array(
				'conditions' =>
				array(
					'ExamGradeChange.id' => $grade_change['id']
				),
				'recursive' => -1
			)
		);
		$exam_garde_details = $this->gradeRelatedDetails($exam_garde_change['ExamGradeChange']['exam_grade_id']);
		//Instructor notification
		if(isset($exam_garde_details['Instructor']['user_id']) && !empty($exam_garde_details['Instructor']['user_id']) && $exam_garde_change['ExamGradeChange']['initiated_by_department'] == 0) {
			if(!empty($exam_garde_change['ExamGradeChange']['makeup_exam_result']) && !empty($exam_garde_change['ExamGradeChange']['makeup_exam_id'])) {
				$auto_message[0]['message'] = 'Your makeup exam grade submission to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['department_approval'] == 1 ? (isset($grade_change['department_reply']) ? 're-accepted' : 'accepted') : (isset($grade_change['department_reply']) ? 'rejected (after register rejection)' : 'rejected')).' by <u>'.(!empty($exam_garde_details['PublishedCourse']['department_id']) ? $exam_garde_details['Department']['name'].' Department' : $exam_garde_details['College']['name'].' Freshman Program').'</u>. <a href="/exam_results/add/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
			}
			else {
				$auto_message[0]['message'] = 'Your exam grade change request to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['department_approval'] == 1 ? 'accepted' : 'rejected').' by <u>'.(!empty($exam_garde_details['PublishedCourse']['department_id']) ? $exam_garde_details['Department']['name'].' Department' : $exam_garde_details['College']['name'].' Freshman Program').'</u>. <a href="/exam_results/add/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
			}
			if($grade_change['department_approval'] == -1)
				$auto_message[0]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[0]['message'].'</p>';
			else if($grade_change['department_approval'] == 1)
				$auto_message[0]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[0]['message'].'</p>';
			
			$auto_message[0]['read'] = 0;
			$auto_message[0]['user_id'] = $exam_garde_details['Instructor']['user_id'];
		}
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
	}
	
	function sendNotificationOnCollegeGradeChangeApproval($grade_change = null) {
		$auto_message = array();
		$exam_garde_change = ClassRegistry::init('ExamGradeChange')->find('first',
			array(
				'conditions' =>
				array(
					'ExamGradeChange.id' => $grade_change['id']
				),
				'recursive' => -1
			)
		);
		//debug($exam_garde_change);
		$exam_garde_details = $this->gradeRelatedDetails($exam_garde_change['ExamGradeChange']['exam_grade_id']);
		//Instructor notification
		if(isset($exam_garde_details['Instructor']['user_id']) && !empty($exam_garde_details['Instructor']['user_id']) && $exam_garde_change['ExamGradeChange']['initiated_by_department'] == 0) {
			$auto_message[0]['message'] = 'Your exam grade change request to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['college_approval'] == 1 ? 'accepted' : 'rejected').' by <u>'.(!empty($exam_garde_details['PublishedCourse']['department_id']) ? $exam_garde_details['Department']['College']['name'] : $exam_garde_details['College']['name']).'</u>. <a href="/exam_results/add/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
			if($grade_change['college_approval'] == -1)
				$auto_message[0]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[0]['message'].'</p>';
			else if($grade_change['college_approval'] == 1)
				$auto_message[0]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[0]['message'].'</p>';
			
			$auto_message[0]['read'] = 0;
			$auto_message[0]['user_id'] = $exam_garde_details['Instructor']['user_id'];
		}
		
		$dept_approved_by_staff_detail = ClassRegistry::init('Staff')->find('first',
			array(
				'conditions' =>
				array(
					'Staff.id' => $exam_garde_change['ExamGradeChange']['department_approved_by']
				),
				'recursive' => -1
			)
		);
		//debug($dept_approved_by_staff_detail);exit();
		if(!empty($exam_garde_change['ExamGradeChange']['department_approved_by'])) {
			$auto_message[1]['message'] = 'Exam grade change request to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['college_approval'] == 1 ? 'accepted' : 'rejected').' by <u>'.(!empty($exam_garde_details['PublishedCourse']['department_id']) ? $exam_garde_details['Department']['College']['name'] : $exam_garde_details['College']['name']).'</u>. <a href="/exam_results/submit_grade_for_instructor/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
			if($grade_change['college_approval'] == -1)
				$auto_message[1]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[1]['message'].'</p>';
			else if($grade_change['college_approval'] == 1)
				$auto_message[1]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[1]['message'].'</p>';
			
			$auto_message[1]['read'] = 0;
			$auto_message[1]['user_id'] = $exam_garde_change['ExamGradeChange']['department_approved_by'];
		}
		//debug($auto_message);exit();
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
	}
	
	function sendNotificationOnRegistrarGradeChangeApproval($grade_change = null) {
		//To college, department, instructor, student
		$auto_message = array();
		$exam_garde_change = ClassRegistry::init('ExamGradeChange')->find('first',
			array(
				'conditions' =>
				array(
					'ExamGradeChange.id' => $grade_change['id']
				),
				'recursive' => -1
			)
		);
		//debug($exam_garde_change);
		$exam_garde_details = $this->gradeRelatedDetails($exam_garde_change['ExamGradeChange']['exam_grade_id']);
		//debug($exam_garde_details);
		//Instructor notification
		if(isset($exam_garde_details['Instructor']['user_id']) && !empty($exam_garde_details['Instructor']['user_id']) && $exam_garde_change['ExamGradeChange']['initiated_by_department'] == 0) {
			$auto_message[0]['message'] = 'Your exam grade change request to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['registrar_approval'] == 1 ? 'accepted' : 'rejected').' by <u>registrar</u>. <a href="/exam_results/add/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
			if($grade_change['registrar_approval'] == -1)
				$auto_message[0]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[0]['message'].'</p>';
			else if($grade_change['registrar_approval'] == 1)
				$auto_message[0]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[0]['message'].'</p>';
			
			$auto_message[0]['read'] = 0;
			$auto_message[0]['user_id'] = $exam_garde_details['Instructor']['user_id'];
		}
		
		$dept_approved_by_staff_detail = ClassRegistry::init('Staff')->find('first',
			array(
				'conditions' =>
				array(
					'Staff.id' => $exam_garde_change['ExamGradeChange']['department_approved_by']
				),
				'recursive' => -1
			)
		);
		//debug($dept_approved_by_staff_detail);exit();
		
		//Department notification
		if(!empty($exam_garde_change['ExamGradeChange']['department_approved_by'])) {
			$auto_message[1]['message'] = 'Exam grade change request to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['registrar_approval'] == 1 ? 'accepted' : 'rejected').' by <u>registrar</u>. <a href="/exam_results/submit_grade_for_instructor/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
			if($grade_change['registrar_approval'] == -1)
				$auto_message[1]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[1]['message'].'</p>';
			else if($grade_change['registrar_approval'] == 1)
				$auto_message[1]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[1]['message'].'</p>';
			
			$auto_message[1]['read'] = 0;
			$auto_message[1]['user_id'] = $exam_garde_change['ExamGradeChange']['department_approved_by'];
		}
		
		//Student Notification
		if(!empty($exam_garde_details['Student']['user_id']) && $grade_change['registrar_approval'] == 1 ) {
			$auto_message[2]['message'] = 'Your Exam grade for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is changed to <strong>'.($exam_garde_change['ExamGradeChange']['grade']).'</strong>.';
			
			$auto_message[2]['read'] = 0;
			$auto_message[2]['user_id'] = $exam_garde_details['Student']['user_id'];
		}
		
		//College Notification
		if(!empty($exam_garde_change['ExamGradeChange']['college_approved_by'])) {
			$auto_message[3]['message'] = 'Exam grade change request to <u>'.$exam_garde_details['Student']['full_name'].'</u> for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is '.($grade_change['registrar_approval'] == 1 ? 'accepted' : 'rejected').' by <u>registrar</u>.';
			if($grade_change['registrar_approval'] == -1)
				$auto_message[3]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[3]['message'].'</p>';
			else if($grade_change['registrar_approval'] == 1)
				$auto_message[3]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="accepted">'.$auto_message[3]['message'].'</p>';
			
			$auto_message[3]['read'] = 0;
			$auto_message[3]['user_id'] = $exam_garde_change['ExamGradeChange']['college_approved_by'];
		}
		
		//debug($auto_message);exit();
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
		//debug($grade_change);exit();
	}
	
	function sendNotificationOnAutoAndManualGradeChange($grade_changes = null, $privilaged_registrars = array()) {
		//To student and registrar
		$auto_message = array();
		$grade_changes[0]['grade'] = 'F';
		$grade_changes[0]['exam_grade_id'] = 1;
		$grade_changes[0]['manual_ng_conversion'] = 1;
		foreach($grade_changes as $key => $grade_change) {
			$index = count($auto_message);
			$exam_garde_details = $this->gradeRelatedDetails($grade_change['exam_grade_id']);
			
			//Student Notification
			if(!empty($exam_garde_details['Student']['user_id'])) {
				$auto_message[$index]['message'] = 'Your Exam grade for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is changed to <strong>'.($grade_change['grade']).'</strong>.';
				$auto_message[$index]['read'] = 0;
				$auto_message[$index]['user_id'] = $exam_garde_details['Student']['user_id'];
			}
			//debug($privilaged_registrars);
			//debug($exam_garde_details);
			foreach($privilaged_registrars as $key => $privilaged_registrar) {
				$index = count($auto_message);
				//Registrar Notification
				if(!empty($privilaged_registrar['StaffAssigne']['id'])) {
					if(!empty($privilaged_registrar['StaffAssigne']['department_id']))
						$department_ids = unserialize($privilaged_registrar['StaffAssigne']['department_id']);
					else
						$department_ids = array();
					if(!empty($privilaged_registrar['StaffAssigne']['college_id']))
						$college_ids = unserialize($privilaged_registrar['StaffAssigne']['college_id']);
					else
						$college_ids = array();
				}
				//debug($department_ids);
				//debug($college_ids);
				if((!empty($exam_garde_details['Student']['department_id']) && in_array($exam_garde_details['Student']['department_id'], $department_ids))
							||
					(empty($exam_garde_details['Student']['department_id']) && !empty($exam_garde_details['Student']['college_id']) && in_array($exam_garde_details['Student']['college_id'], $college_ids))
				) {
					$auto_message[$index]['message'] = '<u>'.$exam_garde_details['Student']['full_name'].'</u> exam grade for the course <u>'.$exam_garde_details['Course']['course_title'].' ('.$exam_garde_details['Course']['course_code'].')</u> is changed to <strong>'.($grade_change['grade']).'</strong>';
					if(isset($grade_change['auto_ng_conversion']) && $grade_change['auto_ng_conversion'] == 1)
						$auto_message[$index]['message'] .= ' automatically.';
					else
						$auto_message[$index]['message'] .= ' manually.';
					$auto_message[$index]['message'] .= ' <a href="/exam_grades/view_grade/'.$exam_garde_details['PublishedCourse']['id'].'">View Grade</a>';
					$auto_message[$index]['read'] = 0;
					$auto_message[$index]['user_id'] = $privilaged_registrar['User']['id'];
				}
			}
		}
		//debug($auto_message);
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
	}
	
	function gradeRelatedDetails($exam_grade_id = null) {
		$exam_garde_details = array();
		$exam_garde_details_r = ClassRegistry::init('ExamGrade')->find('first',
			array(
				'conditions' =>
				array(
					'ExamGrade.id' => $exam_grade_id
				),
				'contain' =>
				array(
					'CourseRegistration' =>
					array(
						'Student',
						'PublishedCourse' =>
						array(
							'CourseInstructorAssignment' =>
							array(
								'conditions' => array('CourseInstructorAssignment.type LIKE \'%Lecture%\''),
								'Staff'
							),
							'Course',
							'Section',
							'Department',
							'College'
						)
					),
					'CourseAdd' =>
					array(
						'Student',
						'PublishedCourse' =>
						array(
							'CourseInstructorAssignment' =>
							array(
								'conditions' => array('CourseInstructorAssignment.type LIKE \'%Lecture%\''),
								'Staff'
							),
							'Course',
							'Section',
							'Department' =>
							array(
								'College'
							),
							'College'
						)
					)
				)
			)
		);
		//debug($exam_garde_details_r);
		if(!empty($exam_garde_details_r['CourseRegistration']['id'])) {
			$exam_garde_details['Student'] = $exam_garde_details_r['CourseRegistration']['Student'];
			$exam_garde_details['Course'] = $exam_garde_details_r['CourseRegistration']['PublishedCourse']['Course'];
			$exam_garde_details['Section'] = $exam_garde_details_r['CourseRegistration']['PublishedCourse']['Section'];
			$exam_garde_details['Department'] = $exam_garde_details_r['CourseRegistration']['PublishedCourse']['Department'];
			$exam_garde_details['College'] = $exam_garde_details_r['CourseRegistration']['PublishedCourse']['College'];
			if(isset($exam_garde_details_r['CourseRegistration']['PublishedCourse']['CourseInstructorAssignment'][0]['Staff'])) {
				$exam_garde_details['Instructor'] = $exam_garde_details_r['CourseRegistration']['PublishedCourse']['CourseInstructorAssignment'][0]['Staff'];
			}
			else {
				$exam_garde_details['Instructor'] = array();
			}
			$exam_garde_details['PublishedCourse'] = $exam_garde_details_r['CourseRegistration']['PublishedCourse'];
			unset($exam_garde_details['PublishedCourse']['Course']);
			unset($exam_garde_details['PublishedCourse']['Section']);
			unset($exam_garde_details['PublishedCourse']['CourseInstructorAssignment']);
			unset($exam_garde_details['PublishedCourse']['Department']);
			unset($exam_garde_details['PublishedCourse']['College']);
		}
		else {
			$exam_garde_details['Student'] = $exam_garde_details_r['CourseAdd']['Student'];
			$exam_garde_details['Course'] = $exam_garde_details_r['CourseAdd']['PublishedCourse']['Course'];
			$exam_garde_details['Section'] = $exam_garde_details_r['CourseAdd']['PublishedCourse']['Section'];
			$exam_garde_details['Department'] = $exam_garde_details_r['CourseAdd']['PublishedCourse']['Department'];
			$exam_garde_details['College'] = $exam_garde_details_r['CourseAdd']['PublishedCourse']['College'];
			if(isset($exam_garde_details_r['CourseAdd']['PublishedCourse']['CourseInstructorAssignment'][0]['Staff'])) {
				$exam_garde_details['Instructor'] = $exam_garde_details_r['CourseAdd']['PublishedCourse']['CourseInstructorAssignment'][0]['Staff'];
			}
			else {
				$exam_garde_details['Instructor'] = array();
			}
			$exam_garde_details['PublishedCourse'] = $exam_garde_details_r['CourseAdd']['PublishedCourse'];
			unset($exam_garde_details['PublishedCourse']['Course']);
			unset($exam_garde_details['PublishedCourse']['Section']);
			unset($exam_garde_details['PublishedCourse']['CourseInstructorAssignment']);
			unset($exam_garde_details['PublishedCourse']['Department']);
			unset($exam_garde_details['PublishedCourse']['College']);
		}
		return $exam_garde_details;
	}
	
	function getInstructorLatestCourseAssignment($user_id = null) {
		$staff = ClassRegistry::init('Staff')->find('first',
			array(
				'conditions' =>
				array('Staff.user_id' => $user_id),
				'recursive' => -1
			)
		);
		$latest_course_assignment = ClassRegistry::init('CourseInstructorAssignment')->find('first',
			array(
				'conditions' =>
				array(
					'CourseInstructorAssignment.staff_id' => $staff['Staff']['id']
				),
				'order' => array('CourseInstructorAssignment.created DESC'),
				'recursive' => -1
			)
		);
		$course_assignments = ClassRegistry::init('CourseInstructorAssignment')->find('all',
			array(
				'conditions' =>
				array(
					'CourseInstructorAssignment.staff_id' => $staff['Staff']['id'],
					'CourseInstructorAssignment.academic_year' => $latest_course_assignment['CourseInstructorAssignment']['academic_year'],
					'CourseInstructorAssignment.semester' => $latest_course_assignment['CourseInstructorAssignment']['semester'],
					'CourseInstructorAssignment.type LIKE \'%Lecture%\''
				),
				'contain' => 
				array(
					'PublishedCourse' =>
					array(
						'Department',
						'College',
						'Section',
						'Course',
						'CourseRegistration' =>
						array(
							'ExamGrade' =>
							array(
								'order' => array('ExamGrade.created DESC')
							)
						),
						'CourseAdd' =>
						array(
							'ExamGrade' =>
							array(
								'order' => array('ExamGrade.created DESC')
							)
						)
					)
				)
			)
		);
		//debug($course_assignments);
		$ongoing_courses = array();
		foreach($course_assignments as $key => $course_assignment) {
			$grade_submitted = true;
			if($course_assignment['PublishedCourse']['drop'] == 0) {
				if(!isset($course_assignment['PublishedCourse']['CourseRegistration']))
				    debug($course_assignment);
				foreach($course_assignment['PublishedCourse']['CourseRegistration'] as $key2 => $course_registration) {
					//Excluding students who dropped the course
					$course_droped = ClassRegistry::init('CourseRegistration')->isCourseDroped($course_registration['id']);
					if(!$course_droped && (empty($course_registration['ExamGrade']) || $course_registration['ExamGrade'][0]['department_approval'] == -1)) {
						$grade_submitted = false;
						
						if($course_assignment['PublishedCourse']['id'] == 6) {
							debug($course_registration);
						}
						break;
					}
				}
				if($grade_submitted == true) {
					foreach($course_assignment['PublishedCourse']['CourseAdd'] as $key2 => $course_add) {
						//Course drop consideration left
						if(empty($course_add['ExamGrade']) || $course_add['ExamGrade'][0]['department_approval'] == -1) {
							$grade_submitted = false;
						
							if($course_assignment['PublishedCourse']['id'] == 6) {
								debug($course_add);
							}
							break;
						}
					}
				}
				if($grade_submitted == false) {
					$index = count($ongoing_courses);
					$ongoing_courses[$index]['Course'] = $course_assignment['PublishedCourse']['Course'];
					$ongoing_courses[$index]['Section'] = $course_assignment['PublishedCourse']['Section'];
					$ongoing_courses[$index]['Department'] = $course_assignment['PublishedCourse']['Department'];
					$ongoing_courses[$index]['College'] = $course_assignment['PublishedCourse']['College'];
					$ongoing_courses[$index]['PublishedCourse'] = $course_assignment['PublishedCourse'];
					unset($ongoing_courses[$index]['PublishedCourse']['Course']);
					unset($ongoing_courses[$index]['PublishedCourse']['CourseRegistration']);
					unset($ongoing_courses[$index]['PublishedCourse']['CourseAdd']);
				}
			}
		}
		
		//debug($ongoing_courses);
		//debug($course_assignments);
		//debug($latest_course_assignment);
		//debug($staff);
		return $ongoing_courses;
	}
	
	function sendPermissionManagementBreakAttempt($user_id = null, $message = null){
		$user = ClassRegistry::init('User')->find('first',
			array(
				'conditions' =>
				array(
					'User.id' => $user_id
				),
				'recursive' => -1
			)
		);
		$sys_admins = ClassRegistry::init('User')->find('all',
			array(
				'conditions' =>
				array(
					'User.role_id' => 1
				),
				'recursive' => -1
			)
		);
		$auto_message = array();
		foreach($sys_admins as $sys_admin) {
			$index = count($auto_message);
			if($message)
				$auto_message[$index]['message'] = $message;
			else
				$auto_message[$index]['message'] = '<u>'.$user['User']['first_name'].' '.$user['User']['middle_name'].' '.$user['User']['last_name'].' ('.$user['User']['username'].')</u> is trying to break permission management system. Please give appropriate warning.';
			$auto_message[$index]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[$index]['message'].'</p>';
			$auto_message[$index]['read'] = 0;
			$auto_message[$index]['user_id'] = $sys_admin['User']['id'];
		}
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
	}
	
	function sendRegistrarAssignedNotificationToDepartmentAndCollege($current_academic_year=null) {
	
		/*
		$accepted_student_department_notified = ClassRegistry::init('AcceptedStudent')->find('all',
		            array(
		            
		                'conditions'=>array(
		                    'AcceptedStudent.Placement_Approved_By_Department is null',
		                    'AcceptedStudent.academicyear'=>$current_academic_year,
		                    'AcceptedStudent.placementtype'=>REGISTRAR_ASSIGNED
		                )
		              )
		            )
		          );
		
		$colleges_departments = ClassRegistry::init('User')->find('all',
			array(
				'conditions' =>
				array(
					
					    'User.role_id' =>array(5,6),
					    'User.admin'=>1,
					    'User.id IN (select user_id from staffs where department_id = '.$department_id.' OR college_id='.$college_id.' ) '
					
				),
				'recursive' =>-1
			)
		);
		$auto_message = array();
		foreach($colleges_departments as $sys_admin) {
			$index = count($auto_message);
			if($message)
				$auto_message[$index]['message'] = $message;
			else
				$auto_message[$index]['message'] = '<u>'.$user['User']['first_name'].' '.$user['User']['middle_name'].' '.$user['User']['last_name'].' ('.$user['User']['username'].')</u> is trying to break permission management system. Please give appropriate warning.';
			$auto_message[$index]['message'] = '<p style="text-align:justify; padding:0px; margin:0px" class="rejected">'.$auto_message[$index]['message'].'</p>';
			$auto_message[$index]['read'] = 0;
			$auto_message[$index]['user_id'] = $sys_admin['User']['id'];
		}
		
		if(!empty($auto_message))
			$this->saveAll($auto_message, array('validate' => false));
        */	    
	    
	}
	
}
