<?php
class DepartmentTransfersController extends AppController {

    var $name = 'DepartmentTransfers';
    var $menuOptions = array(
             'parent' => 'transfers',
             'alias' => array(
                    'index'=>'View department transfer',
                    'add'=>'Department Transfer',
            )
    );
    function index() {
	$this->DepartmentTransfer->recursive = 0;
	$this->paginate = array('order' => array('DepartmentTransfer.created DESC'));	

	if (!empty($this->request->data) && isset($this->request->data['viewTransferApplication'])) { 
		$options = array();
		if (!empty($this->request->data['Search']['department_id'])) {
		$options [] = array(
		'Student.department_id'=>$this->request->data['Search']['department_id']

		);
		}

		if (!empty($this->request->data['Search']['department_id'])) {
		$options[] = array(

		"Student.department_id"=>$this->request->data['Search']['department_id']
		);  
		} 
		if (!empty($this->request->data['Search']['academic_year'])) {
		$options[] = array(

		"DepartmentTransfer.academic_year like "=>$this->request->data['Search']['academic_year'].'%'
		);  
		}


		if ($this->request->data['Search']['rejected']==1 && $this->request->data['Search']['accepted']==0 
		&& $this->request->data['Search']['notprocessed']==0) {
		$options[] = array(

		"DepartmentTransfer.sender_department_approval"=>-1
		);         
		}

		if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
		&& $this->request->data['Search']['notprocessed']==0) {
		$options[] = array(

		"DepartmentTransfer.sender_department_approval"=>1
		);         
		}

		if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==0
		&& $this->request->data['Search']['notprocessed']==1) {
		$options[] = array(

		"DepartmentTransfer.sender_department_approval is null"
		);         
		}

		if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==1
		&& $this->request->data['Search']['notprocessed']==0) {
		$options[] = array(

		"DepartmentTransfer.sender_department_approval"=>array(1,-1)
		);         
		}

		if ($this->request->data['Search']['accepted']==1 && $this->request->data['Search']['rejected']==0
		&& $this->request->data['Search']['notprocessed']==1) {
		$options[] = array(

		'OR'=>array("DepartmentTransfer.sender_department_approval"=>1,
		"DepartmentTransfer.sender_department_approval is null ")
		);         
		}

		if ($this->request->data['Search']['accepted']==0 && $this->request->data['Search']['rejected']==1 && $this->request->data['Search']['notprocessed']==1) {
		$options[] = array(

		'OR'=>array("DepartmentTransfer.sender_department_approval"=>-1,
		"DepartmentTransfer.sender_department_approval is null ")
		);         
		}
		$departmentTransfers=$this->paginate($options);
		if(empty($departmentTransfers)) {
		$this->Session->setFlash('<span></span>'.__('There is no department transfer applicant  in the given criteria.'),'default',array('class'=>'info-box info-message'));
		}
	} else {
		if ($this->role_id == ROLE_STUDENT) {
		$conditions = array('DepartmentTransfer.student_id'=>$this->student_id);
		$departmentTransfers=$this->paginate($conditions);
		} else if ($this->role_id == ROLE_COLLEGE) {

		$conditions = array('Student.college_id'=>$this->college_id);
		$departmentTransfers=$this->paginate($conditions);

		} else if ($this->role_id == ROLE_DEPARTMENT) {
		$conditions = array('Student.department_id'=>$this->department_id);
		$departmentTransfers=$this->paginate($conditions);

		} else {
		$departmentTransfers=$this->paginate();
		}
	}

	if ($this->role_id == ROLE_DEPARTMENT ){
		$departments = $this->DepartmentTransfer->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_id)));
	} else if ($this->role_id == ROLE_REGISTRAR) {
		$departments = $this->DepartmentTransfer->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_ids)));
	} else if ($this->role_id == ROLE_COLLEGE) {
		$departments = $this->DepartmentTransfer->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->college_id)));
	}
      $this->set(compact('departmentTransfers','departments'));
    }

   public function request_transfer () {
	$check_id_is_valid=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id'=>$this->student_id)));
	  debug($this->student_id);
      if(empty($check_id_is_valid['Student']['department_id'])) {
	 $this->Session->setFlash('<span></span>'.__('You can not request department transfer since you don\'t have department currently.'),'default',array('class'=>'info-box info-message'));
	return $this->redirect(array('action' => 'index'));
      }

      if (!empty($this->request->data)) {
	 debug($this->request->data);
	$college_id = $this->DepartmentTransfer->Department->find('first',array('conditions'=>array('Department.id'=>$this->request->data['DepartmentTransfer']['department_id'])));
	$this->request->data['DepartmentTransfer']['to_college_id']=$college_id['Department']['college_id'];
    $this->request->data['DepartmentTransfer']['from_department_id']=$check_id_is_valid['Student']['department_id'];
    
     $this->request->data['DepartmentTransfer']['student_id']=$check_id_is_valid['Student']['id'];

	$this->DepartmentTransfer->create();
	if ($this->DepartmentTransfer->save($this->request->data)) {
	$this->Session->setFlash('<span></span>'.__('The department transfer request has been send to your current department'),'default',array('class'=>'success-box success-message'));
	return $this->redirect(array('action' => 'index'));
	} else {
	$this->Session->setFlash('<span></span>'.__('The department transfer could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
	}
	}

	$student_section_exam_status=$this->DepartmentTransfer->Student->
	get_student_section($this->student_id);

	$colleges=$this->DepartmentTransfer->Student->College->find('list');
	if (!empty($this->request->data['DepartmentTransfer']['college_id'])) {
	$departments = $this->DepartmentTransfer->Department->find('list',
	array('conditions'=>array('Department.college_id'=>$this->request->data['DepartmentTransfer']['college_id'])));    
	} else {
	$temp = array_keys($colleges);
	$collegeIds = $temp[0];
	$departments = $this->DepartmentTransfer->Department->find('list',
	array('conditions'=>array('Department.college_id'=>$collegeIds)));    
	}

	$attended_semester=ClassRegistry::init('ExamGrade')->getListOfAyAndSemester($this->student_id);
	$check_id_is_valid=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.id'=>$this->student_id)));

	$this->set(compact('student_section_exam_status','colleges',
'departments','attended_semester','check_id_is_valid'));
     }

	public function department_approve_transfer () 
	{

	if (!empty($this->request->data) && isset($this->request->data['saveIt'])) 
    {
	   $this->DepartmentTransfer->create();
	   foreach ($this->request->data['DepartmentTransfer'] as $in=>&$va) {
		if (isset($va['sender_department_approval']) && $va['sender_department_approval']!="") {
		$va['sender_department_approval_by']=$this->Auth->user('id');
		$va['sender_department_approval_date']=date('Y-m-d');
		} else if (isset($va['sender_college_approval']) &&  $va['sender_college_approval']!="") { 
		$va['sender_college_approval_by']=$this->Auth->user('id');
		$va['sender_college_approval_date']=date('Y-m-d');
		} else if (isset($va['receiver_department_approval']) && $va['receiver_department_approval'] !="") { 
		// is transfer intra 
		$student_orginal_department_college=$this->DepartmentTransfer->Student->field('college_id',array('Student.id'=>$va['student_id']));
		$student_requested_department_college=$this->DepartmentTransfer->Department->field('college_id',array('Department.id'=>$va['department_id']));
		if ($student_orginal_department_college==$student_requested_department_college) {
		$va['receiver_college_approval']= $va['receiver_department_approval'];
		$va['receiver_college_approval_date']=date('Y-m-d');
		$va['receiver_college_approval_by']='Automatical';
		
		// accepted 
		if ($va['receiver_department_approval']==1) 
                {
		// update student department id in student table	
		$acceptedStudentId=$this->DepartmentTransfer->Student->field('Student.accepted_student_id',
		array('Student.id'=>
		$va['student_id']));
		
		$this->DepartmentTransfer->Student->id=$va['student_id'];
		$this->DepartmentTransfer->Student->
		saveField('department_id',$va['department_id']);
		$this->DepartmentTransfer->Student->
		saveField('curriculum_id',"");
		
		ClassRegistry::init('AcceptedStudent')->id=$acceptedStudentId;
		ClassRegistry::init('AcceptedStudent')->
		saveField('department_id',$va['department_id']);
		
		ClassRegistry::init('AcceptedStudent')->
		saveField('curriculum_id',"");
		
		// archive the section 
		$this->DepartmentTransfer->Student->StudentsSection->id=
		$this->DepartmentTransfer->Student->
		StudentsSection->field('StudentsSection.id',
		array('StudentsSection.student_id'=>
		$va['student_id'],'StudentsSection.archive'=>0));
		$this->DepartmentTransfer->Student->StudentsSection->
		saveField('archive','1');
		}
		
		
	}
		$va['receiver_department_approval_by']=$this->Auth->user('id');
		$va['receiver_department_approval_date']=date('Y-m-d');
		
		} else if (isset($va['receiver_college_approval']) && $va['receiver_college_approval'] !="") {
		$va['receiver_college_approval_by']=$this->Auth->user('id');
		$va['receiver_college_approval_date']=date('Y-m-d');
		} else {
		unset($this->request->data['DepartmentTransfer'][$in]);
		}
	  }

	     if (!empty($this->request->data['DepartmentTransfer'])) {
		  if ($this->DepartmentTransfer->saveAll($this->request->data['DepartmentTransfer'],array('validate'=>'first'))) {
			$this->Session->setFlash('<span></span>'.__('The selected transfer applicant has been approved,and students will be notified.'),'default',array('class'=>'success-box success-message'));

	return $this->redirect(array('action' => 'index'));

		  } else {
			$this->Session->setFlash('<span></span>'.__('The transfer could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
		
		   }
	     }              
	}

      

         
	$optionsleaver['conditions'][] = array(
	"DepartmentTransfer.sender_department_approval is null",
	"DepartmentTransfer.from_department_id"=>$this->department_id
	);
	$optionscoming['conditions'][] = array(
	"DepartmentTransfer.sender_department_approval=1",
	"DepartmentTransfer.sender_college_approval=1",
	"DepartmentTransfer.receiver_college_approval is null",
	"DepartmentTransfer.receiver_department_approval is null",
	"DepartmentTransfer.department_id"=>$this->department_id
	);
	$departmentTransfersLeaverRequest=$this->DepartmentTransfer->find('all',$optionsleaver);
	
	$departmentTransfersIncomingToYourDepartment=$this->DepartmentTransfer->find('all',$optionscoming);


	if (empty($departmentTransfersLeaverRequest) && empty($departmentTransfersIncomingToYourDepartment) ) {
	$this->Session->setFlash('<span></span>'.
	__('There is no department transfer request in the system that needs approval.'),
	'default',array('class'=>'info-box info-message'));
	//  $this->redirect(array('action' => 'index'));

	} else {
	$departmentTransfersLeaverRequest=$this->DepartmentTransfer->attachSemesterAttended($departmentTransfersLeaverRequest);

	$departmentTransfersIncomingToYourDepartment=$this->DepartmentTransfer->attachSemesterAttended($departmentTransfersIncomingToYourDepartment);


	}
 $this->set(compact('departmentTransfersIncomingToYourDepartment',
'departmentTransfersLeaverRequest'));
        
    }
	
    function college_approve_transfer () {

	
	if (!empty($this->request->data) && isset($this->request->data['saveIt'])) {
	$this->DepartmentTransfer->create();
	
	
	foreach ($this->request->data['DepartmentTransfer'] as $in=>&$va) {
	
	$designationDepartmentId= $this->DepartmentTransfer->field('DepartmentTransfer.department_id',array('DepartmentTransfer.id'=>$va['id']));
	
	if (isset($va['sender_college_approval']) 
	&&  $va['sender_college_approval']!="") { 
	$va['sender_college_approval_by']=$this->Auth->user('id');
	$va['sender_college_approval_date']=date('Y-m-d');

	} else if (isset($va['receiver_college_approval']) && $va['receiver_college_approval'] !="") {
	$va['receiver_college_approval_by']=$this->Auth->user('id');
	$va['receiver_college_approval_date']=date('Y-m-d');
	} else {
           unset($this->request->data['DepartmentTransfer'][$in]);
	}

     if ($va['receiver_college_approval']==1) {
	// update student department id in student table
			if(isset($designationDepartmentId) && !empty($designationDepartmentId)){
			$this->DepartmentTransfer->Student->id=$va['student_id'];
			$this->DepartmentTransfer->Student->
			saveField('department_id',$designationDepartmentId);
			$this->DepartmentTransfer->Student->
			saveField('college_id',$this->college_id);
	
			$this->DepartmentTransfer->Student->
			saveField('curriculum_id','');
	
			// archive the section 
			$this->DepartmentTransfer->Student->StudentsSection->id=$this->DepartmentTransfer->Student->
			StudentsSection->field('StudentsSection.id',
			array('StudentsSection.student_id'=>$va['student_id'],'StudentsSection.archive'=>0));
			$this->DepartmentTransfer->Student->StudentsSection->
			saveField('archive','1');
		 }
	   }
     }
     
     if (!empty($this->request->data['DepartmentTransfer'])) {
	if ($this->DepartmentTransfer->saveAll($this->request->data['DepartmentTransfer'],array('validate'=>'first'))) {
	$this->Session->setFlash('<span></span>'.__('The selected transfer applicant has been approved,and students will be notified.'),'default',
	array('class'=>'success-box success-message'));
	   $this->redirect(array('action' => 'index'));
	} else {
	$this->Session->setFlash('<span></span>'.__('The transfer could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
	}
      }
     }
	$optionsleaver['conditions'][] = array(
	"DepartmentTransfer.sender_college_approval is null",
	"DepartmentTransfer.sender_department_approval=1",
	
	"Student.college_id "=>$this->college_id
	);
	$optionscoming['conditions'][] = array(
	"DepartmentTransfer.sender_department_approval=1",
	"DepartmentTransfer.sender_college_approval=1",
	"DepartmentTransfer.receiver_department_approval=1",
"DepartmentTransfer.receiver_college_approval is null",
	"DepartmentTransfer.to_college_id "=>$this->college_id
	);
	$departmentTransfersLeaverRequest=$this->DepartmentTransfer->find('all',$optionsleaver);
	$departmentTransfersIncomingToYourDepartment=$this->DepartmentTransfer->find('all',$optionscoming);


	if (empty($departmentTransfersLeaverRequest) && empty($departmentTransfersIncomingToYourDepartment) ) {
	$this->Session->setFlash('<span></span>'.
	__('There is no department transfer request in the system that needs approval.'),
	'default',array('class'=>'info-box info-message'));
	 $this->redirect(array('action' => 'index'));

	} else {
	$departmentTransfersLeaverRequest=$this->DepartmentTransfer->attachSemesterAttended($departmentTransfersLeaverRequest);

	$departmentTransfersIncomingToYourDepartment=$this->DepartmentTransfer->attachSemesterAttended($departmentTransfersIncomingToYourDepartment);
	}
	$this->set(compact('departmentTransfersIncomingToYourDepartment','departmentTransfersLeaverRequest'));
      }

   function edit($id = null) {
	if (!$id && empty($this->request->data)) {
	$this->Session->setFlash(__('Invalid department transfer'));
	return $this->redirect(array('action' => 'index'));
	}
	if (!empty($this->request->data)) {
	if ($this->DepartmentTransfer->save($this->request->data)) {
	$this->Session->setFlash(__('The department transfer has been saved'));
	return $this->redirect(array('action' => 'index'));
	} else {
	$this->Session->setFlash(__('The department transfer could not be saved. Please, try again.'));
	}
	}
	if (empty($this->request->data)) {
	$this->request->data = $this->DepartmentTransfer->read(null, $id);
	}
	$departments = $this->DepartmentTransfer->Department->find('list');
	$students = $this->DepartmentTransfer->Student->find('list');
	$this->set(compact('departments', 'students'));
      }

    function delete($id = null) {
	if (!$id) {
	$this->Session->setFlash('<span></span>'.__('Invalid id for department transfer'),
	'default',array('class'=>'error-box error-message'));
	return $this->redirect(array('action'=>'index'));
	}
	$check=$this->DepartmentTransfer->find('count',array('conditions'=>array('DepartmentTransfer.sender_department_approval is null','DepartmentTransfer.student_id'=>$this->student_id,'DepartmentTransfer.id'=>$id)));

	if ($check) {
	if ($this->DepartmentTransfer->delete($id)) {
	$this->Session->setFlash('<span></span>'.__('Department transfer request cancelled.'),
	'default',array('class'=>'success-box success-message'));
	return $this->redirect(array('action'=>'index'));
	}

	} 
	$this->Session->setFlash('<span></span>'.__('Department transfer was not deleted'),
	'default',array('class'=>'error-box error-message'));
	return $this->redirect(array('action' => 'index'));
    }


   function apply_department_transfer_for_student () 
   {
     if (!empty($this->request->data) && isset($this->request->data['applyTransfer'])) {
			
	$everythingfine=true;
	if (empty($this->request->data)){
	      $this->Session->setFlash('<span></span> '.__('Please provide transfer details.'),'default',array('class'=>'error-box error-message'));  
	       $everythingfine=false;
	}
	$department_id = null;
	$college_id =null;
	if (!empty($this->department_ids)) {
		$department_id = $this->department_ids;
	} else if (!empty($this->department_id)) { 
		$department_id = $this->department_id;
	} else {
	   if($this->role_id == ROLE_REGISTRAR) {
		if(!empty($this->department_ids)) {
		$department_id=$this->department_ids;
		} else if (!empty($this->college_ids)) {
		$college_id=$this->college_ids;
		}  
	   }				
	}
			
	if ($everythingfine) {

		if (!empty($department_id)) {
			$check_id_is_valid=ClassRegistry::init('Student')->
			find('first',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentnumber']),'Student.department_id'=>$department_id)));
		} else if (!empty($college_id)) {
			$check_id_is_valid=ClassRegistry::init('Student')->find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Student']['studentnumber']),'Student.college_id'=>$college_id,'Student.department_id is null')));
		}

	  if ($check_id_is_valid) {
              $everythingfine=true;
              $student_section_exam_status=$this->DepartmentTransfer->Student->get_student_section($check_id_is_valid['Student']['id']);
		$attended_semester=ClassRegistry::init('ExamGrade')->getListOfAyAndSemester($check_id_is_valid['Student']['id']);
     		$colleges=$this->DepartmentTransfer->Student->College->find('list');
		
	   $colleges=$this->DepartmentTransfer->Student->College->find('list');
	   $temp = array_keys($colleges);
	   $collegeIds = $temp[0];
	   $departments = $this->DepartmentTransfer->Department->find('list',array('conditions'=>array('Department.college_id'=>$collegeIds)));    

	  if(empty($check_id_is_valid['Student']['department_id'])) {
	 $this->Session->setFlash('<span></span>'.__('You can not request department transfer for this student. The student don\'t have department currently.'),'default',array('class'=>'info-box info-message'));
	return $this->redirect(array('action' => 'index'));
         }
	
	   $this->set(compact('student_section_exam_status','check_id_is_valid','departments','colleges','attended_semester')); 

	    } else {
		  $everythingfine=false;
$this->Session->setFlash('<span></span> '.__('The provided student number  is not valid.'),'default',array('class'=>'error-box error-message'));      
	    }
       }
     }

    if(!empty($this->request->data) && isset($this->request->data['saveTransfer'])) {
	$college_id = $this->DepartmentTransfer->Department->find('first',array('conditions'=>array('Department.id'=>$this->request->data['DepartmentTransfer']['department_id'])));
	$this->request->data['DepartmentTransfer']['to_college_id']=$college_id['Department']['college_id'];
	$this->DepartmentTransfer->create();		
	// find the college where the department locates
	
		
	if ($this->DepartmentTransfer->save($this->request->data)) {
	$this->Session->setFlash('<span></span>'.__('The department transfer request has been send to your current department'),'default',array('class'=>'success-box success-message'));
	return $this->redirect(array('action' => 'index'));
	} else {
	$this->Session->setFlash('<span></span>'.__('The department transfer could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
	}
	
	
    }
  }

  function __auto_department_transfer_update() {
    
	$optionscoming['conditions'][] = array(
	"DepartmentTransfer.to_college_id is null",
	"DepartmentTransfer.from_department_id is null",
	);
	$optionscoming['contain']= array(
		'Student'=>array('AcceptedStudent')
	);
	$departmentTransfersLeaverRequest=$this->DepartmentTransfer->find('all',$optionscoming);
	//debug($departmentTransfersLeaverRequest);	
	$transferUpdate=array();
	$count=0;	
	foreach($departmentTransfersLeaverRequest as $k=>$v) {
       if(isset($v['Student']['AcceptedStudent']['department_id'])) {
       $transferUpdate['DepartmentTransfer'][$count]['id']=$v['DepartmentTransfer']['id'];
$transferUpdate['DepartmentTransfer'][$count]['from_department_id']=$v['Student']['AcceptedStudent']['department_id'];
	$transferUpdate['DepartmentTransfer'][$count]['to_college_id']=$this->DepartmentTransfer->Department->field('college_id',array('Department.id'=>$v['DepartmentTransfer']['department_id']));
$count++;
}

	
	}
	// debug($transferUpdate);
       if(isset($transferUpdate['DepartmentTransfer'])) {
	 if($this->DepartmentTransfer->saveAll($transferUpdate['DepartmentTransfer'],array('validate'=>false))) {
		echo 'Done';
	} else {
		echo 'Something went wrong';
	}
      }	
	
  }
	

}
