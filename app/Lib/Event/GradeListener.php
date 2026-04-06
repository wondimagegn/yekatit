<?php // In app/Lib/Event/UserListener.php
 App::uses('CakeEmail', 'Network/Email');
 App::uses('CakeEventListener', 'Event');
 class GradeListener implements CakeEventListener {
    
    public function implementedEvents() {
       return ['Model.ExamGrade.createdModified' => 'sendNotificationEmail'];
    }

    public function sendNotificationEmail(CakeEvent $Event) {
    	$notifyEnabled=ClassRegistry::init('GeneralSetting')->notifyStudentsGradeByEmail($Event->data['id']);
        $gradeDetail=ClassRegistry::init('ExamGrade')->getGradeDetailsForEmailNotification($Event->data['id']);
	$Email = new CakeEmail('amumail');
	$Email->from(array(
	'wondetask@gmail.com' => 'SMIS'
	));

    	if(!empty($Event->data['id']) && $notifyEnabled)
        {
              if(!empty($gradeDetail['ExamGrade']['registrar_approval'])) {
			   $email='';
			   $message='';
			   $department_approved_by=ClassRegistry::
				    init('User')->find('first',array('conditions'=>array('User.id'=>$gradeDetail['ExamGrade']['department_approved_by']),'recursive'=>-1));
			     if(!empty($gradeDetail['CourseRegistration']['id'])){
		           $message="Dear ".$gradeDetail['CourseRegistration']['Student']['first_name']." , <br/> You get ".$gradeDetail['ExamGrade']['grade']." for the course ".$gradeDetail['CourseRegistration']['PublishedCourse']['Course']['course_title']."(".$gradeDetail['CourseRegistration']['PublishedCourse']['Course']['course_code'].") approved by ".$department_approved_by['User']['first_name']." ";
		           $email=$gradeDetail['CourseRegistration']['Student']['email'];
			     } else if(!empty($gradeDetail['CourseAdd']['id'])) {
		          $message="Dear ".$gradeDetail['CourseRegistration']['Student']['first_name']." , <br/> You get ".$gradeDetail['ExamGrade']['grade']." for the course ".$gradeDetail['CourseAdd']['PublishedCourse']['Course']['course_title']."(".$gradeDetail['CourseAdd']['PublishedCourse']['Course']['course_code'].") approved by ".$department_approved_by['User']['first_name']." ";
		          $email=$gradeDetail['CourseAdd']['Student']['email'];
			     } else if(!empty($gradeDetail['MakeupExam']['id'])){
		          $message="Dear ".$gradeDetail['CourseRegistration']['Student']['first_name']." , <br/> You get ".$gradeDetail['ExamGrade']['grade']." for the course ".$gradeDetail['MakeupExam']['PublishedCourse']['Course']['course_title']."(".$gradeDetail['CourseAdd']['PublishedCourse']['Course']['course_code'].") approved by ".$department_approved_by['User']['first_name']." ";
		           	$email=$gradeDetail['MakeupExam']['Student']['email'];
			     }
			     if(!empty($message) && !empty($email)) {
			    	    $Email->to($email);
				    $Email->subject('Grade');
				    $Email->template('grade_notification');
				    $Email->emailFormat('html');
				    $Email->viewVars(array(
					'message' => $message
				    ));
				  

				     if($Email->send()){
				    	return ;
				     }
			     }
		} 
    	}
	$message='';
	$email='';
	// notify exam grade insertion to instructor 
	debug($gradeDetail);
	if(!empty($gradeDetail['CourseRegistration']['published_course_id'])){
		 $instructorDetail=ClassRegistry::init('CourseInstructorAssignment')->find('first',array('conditions'=>array('CourseInstructorAssignment.published_course_id'=>$gradeDetail['CourseRegistration']['published_course_id']),'contain'=>array('Staff'=>array('Title'))));
		$email=$instructorDetail['Staff']['email'];
		if(!empty($instructorDetail['Staff']) && isset($gradeDetail['CourseRegistration']['id']) ){
		   $message="Dear ".$instructorDetail['Staff']['Title']['title'].' '.$instructorDetail['Staff']['full_name']." , <br/> 
		".$gradeDetail['CourseRegistration']['Student']['full_name'].'('.$gradeDetail['CourseRegistration']['Student']['studentnumber'].') '.$gradeDetail['ExamGrade']['grade']." for the course ".$gradeDetail['MakeupExam']['PublishedCourse']['Course']['course_title']."(".$gradeDetail['CourseRegistration']['PublishedCourse']['Course']['course_code'].") submitted and approved by ".$department_approved_by['User']['first_name']." ";
		}

	} else if(!empty($gradeDetail['CourseAdd']['published_course_id'])){
		 $email=$instructorDetail['Staff']['email'];
		 $instructorDetail=ClassRegistry::init('CourseInstructorAssignment')->find('first',array('conditions'=>array('CourseInstructorAssignment.published_course_id'=>$gradeDetail['CourseAdd']['published_course_id']),'contain'=>array('Staff'=>array('Title'))));
		if(!empty($instructorDetail['Staff']) &&  isset($gradeDetail['CourseAdd']['id'])){
		   $message="Dear ".$instructorDetail['Staff']['Title']['title'].' '.$instructorDetail['Staff']['full_name']." , <br/> 
		".$gradeDetail['CourseAdd']['Student']['full_name'].'('.$gradeDetail['CourseAdd']['Student']['studentnumber'].') '.$gradeDetail['ExamGrade']['grade']." for the course ".$gradeDetail['CourseAdd']['PublishedCourse']['Course']['course_title']."(".$gradeDetail['CourseAdd']['PublishedCourse']['Course']['course_code'].") submitted and approved by ".$department_approved_by['User']['first_name']." ";
		}
	}

        if(!empty($message) && !empty($email)) {
	    	    $Email->to($email);
		    $Email->subject('Grade');
		    $Email->template('grade_notification');
		    $Email->viewVars(array(
			'message' => $message
		    ));
    		try{
		    	 if($Email->send()){
		    		//success 
				 } else {
				    	if($Event->isStopped()){
				    		return false;
				    	}
				  
				  }
		    } catch(Exception $e){
		    	if($Event->isStopped()){
				    return false;
				}
			
		    }
	 }
        return ;
   }
}
