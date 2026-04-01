<?php
App::import('Vendor', 'PhpExcelReader/Excel/reader');
class PaymentsController extends AppController {

	var $name = 'Payments';
	var $menuOptions = array(
	//'parent'=>'costShares',
	'alias' => array(
	        'index'=>'View Payment',
	        'add'=>'Add Payment',
		'student_settle_payment'=>'Settle Payment',
		'approve_payments'=>'Approve Payments'
	    
	),
	'weight'=>1,
	);
     public $paginate = array();    
     public $components =array('EthiopicDateTime','Paginator','AcademicYear');
     public $helpers = array('Media.Media');
     function beforeRender() {

        //$acyear_array_data = $this->AcademicYear->acyear_array();
        $acyear_array_data = $this->AcademicYear->academicYearInArray(date('Y') - 4, date('Y'));
	//To diplay current academic year as default in drop down list
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        $this->set(compact('acyear_array_data','defaultacademicyear'));
      
	}
	public function beforeFilter() {
       		parent::beforeFilter();
       		 
        }

	function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Payment'])){
               
                    $search_session = $this->request->data['Payment'];
                   // Session variable 'search_data'
                    $this->Session->write('search_data', $search_session);
                
        } else {

        	$search_session = $this->Session->read('search_data');
        	$this->request->data['Payment'] = $search_session;
        } 

    }
	
	function index() {
		$this->paginate = array('contain'=>array('Attachment','Student'),'order'=>array('Payment.created DESC '));
		$this->__init_search();
		if ($this->Session->read('search_data')) {
		   //$this->request->data['viewPayment']=true;
		}
		if (!empty($this->request->data) && isset($this->request->data['viewPayment'])) { 
	            $options = array();
	            if (!empty($this->request->data['Payment']['department_id'])) {
	               $options [] = array(
	                    'Student.department_id'=>$this->request->data['Payment']['department_id']
	               
	                 );
	            }
	            
	            if (!empty($this->request->data['Payment']['college_id'])) {
	                 $options [] = array(
	                    'Student.college_id'=>$this->request->data['Payment']['college_id']
	               
	                 );
	                
	            }
	            if (!empty($this->request->data['Payment']['paid_date_to'])) {
	               $options [] = array(
	                    'Payment.payment_date >= \''.
	                    $this->request->data['Payment']['paid_date_from']['year'].'-'.
	                    $this->request->data['Payment']['paid_date_from']['month'].'-'.
	                    $this->request->data['Payment']['paid_date_from']['day'].'\'',
	                    
	                     'Payment.payment_date <= \''.
	                    $this->request->data['Payment']['paid_date_to']['year'].'-'.
	                    $this->request->data['Payment']['paid_date_to']['month'].'-'.
	                    $this->request->data['Payment']['paid_date_to']['day'].'\'',
	               
	               );
			
			
	            }
	           
	            if (!empty($this->request->data['Payment']['reference_number'])) {
	               unset($options);
	               $options [] = array(
	                    'Payment.reference_number like '=>$this->request->data['Payment']['reference_number'].'%'
	               );
			
	            }
		    if(isset($this->request->data['Payment']['rejected']) && !empty($this->request->data['Payment']['rejected'])){
                    	$status[]=-1;
		    }
		    if(isset($this->request->data['Payment']['accepted']) && !empty($this->request->data['Payment']['accepted'])){
                    	$status[]=1;
		    }
		    if(isset($this->request->data['Payment']['notprocessed']) && !empty($this->request->data['Payment']['notprocessed'])){
                    	$status[]=0;
		    }
		    
		    if (isset($status) && !empty($status)) {
	                        $options [] = array(
	                    'Payment.approval_status'=>$status
	               );
	                          
	            }
		   
	            $this->paginate['conditions'] = $options;
		    if(isset($this->paginate['conditions']) && !empty($this->paginate['conditions'])){	
				$this->Paginator->settings['conditions']=$this->paginate['conditions'];
		    }
		    $this->Paginator->settings = $this->paginate;
	            $payments=$this->Paginator->paginate('Payment');
	          
	          if (empty($payments)) {
	            $this->Session->setFlash('<span></span>'.
	            __('There is no student in the system that  paid payment in the given criteria.'),
				    'default',array('class'=>'info-box info-message'));
			  }
	     } else {
			if($this->role_id==ROLE_STUDENT){
			     $options [] = array(
					'Student.id'=>$this->student_id
	               
	                      );
			      $this->paginate['conditions'] = $options;
		              if(isset($this->paginate['conditions']) && !empty($this->paginate['conditions'])){	
				   $this->Paginator->settings['conditions']=$this->paginate['conditions'];
			      }
		              $this->Paginator->settings = $this->paginate;
		              $payments=$this->Paginator->paginate('Payment');			
                       }

	     }
	     if (!empty($this->request->data['Payment']['college_id'])) {
		      if (!empty($this->department_ids)) {
		          $departments = $this->Payment->Student->Department->find('list',
		        array('conditions'=>array('Department.college_id'=>
		        $this->request->data['Payment']['college_id'],'Department.id'=>$this->department_ids
		        )));
		      }
		       
		      $this->set(compact('departments'));
		        
		}
		$colleges=$this->Payment->Student->College->find('list');
		
		$this->set(compact('payments'));
		$this->set(compact('colleges'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid payment'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

	function add() {
		/*
		 if (!empty($this->request->data) && isset($this->request->data['saveApplicablePayment'])) {
			$this->Payment->create();
		   if ($this->Payment->duplication($this->request->data)==0) {	
			    if ($this->Payment->save($this->request->data)) {
				    $this->Session->setFlash('<span></span>'.__('The payment has been saved'),
				    'default',array('class'=>'success-box success-message'));
				    $this->redirect(array('action' => 'index'));
				
			    } else {
				    $this->Session->setFlash('<span></span>'.__('The payment could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				
				    $this->request->data['continue']=true;
				    $student_number=$this->Payment->Student->field('studentnumber',
			                    array('id'=>trim($this->request->data['Payment']['student_id'])));
				    $this->request->data['Payment']['studentID']=$student_number;
			    }
			 } else {
			      $this->Session->setFlash('<span></span>'.__('You have already recorded  payment for the selected student for '.$this->request->data['Payment']['academic_year'].' of semester '.$this->request->data['Payment']['semester'].'.'),'default',array('class'=>'error-box error-message'));
			      $this->request->data['continue']=true;
				    $student_number=$this->Payment->Student->field('studentnumber',
			                    array('id'=>trim($this->request->data['Payment']['student_id'])));
				    $this->request->data['Payment']['studentID']=$student_number;
			 }
		}
		*/
		
		debug($this->request->data);
		if (!empty($this->request->data) && isset($this->request->data['paid']) 
		&& !empty($this->request->data['paid'])) {	
				 $check_duplication=$this->Payment->find('count',array('conditions'=>array('Payment.student_id'=>$this->request->data['Payment']['student_id'],'Payment.academic_year'=>$this->request->data['Payment']['academic_year'],'Payment.semester'=>$this->request->data['Payment']['semester'],'Payment.approval_status'=>array(0,1))));

				if ($check_duplication==0) {
				    $this->Payment->create();
				    $this->request->data = $this->Payment->preparedAttachment($this->request->data);
				    $this->request->data['Payment']['payment_date']= date('Y-m-d H:i:s');
				    //$this->request->data['Payment']['reference_number']= $this->request->data['Payment'][''];
				    //$this->request->data['Payment']['fee_amount']=0;
				   
				    if ($this->Payment->saveAll($this->request->data,array('validate'=>'first'))) {
					   $this->Session->setFlash('<span></span>'.__('The payment has been saved'),
					'default',array('class'=>'success-box success-message'));
					    $this->redirect(array('action' => 'index'));
				    } else {
				    	   $error=$this->Payment->invalidFields();
						debug($error);
					   $this->Session->setFlash('<span></span>'.__('The payment could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				    }
				} else if($check_duplication>0){
					  $student_full_name = $this->Payment->Student->field('full_name',array('Student.id'=>$this->request->data['Payment']['student_id']));
		       	  		 $this->Session->setFlash('<span></span>'.__('You have already recorded payment for '.$student_full_name.' for '.$this->request->data['Payment']['academic_year'].' and semester '.$this->request->data['Payment']['semester'].'.'),'default',array('class'=>'error-box error-message'));

				}	
		}
		if (!empty($this->request->data) && isset($this->request->data['continue'])) {
		   $everythingfine=false;
		   $StudentsSection=&ClassRegistry::init('StudentsSection');
		   if (!empty($this->request->data['Payment']['studentID'])) {
			 $check_id_is_valid=$this->Payment->Student->find('count',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['Payment']['studentID']))));
			 $studentIDs=1;
			 if ($check_id_is_valid>0) {
			                $everythingfine=true;
			                $student_id=$this->Payment->Student->field('id',
			                array('studentnumber'=>trim($this->request->data['Payment']['studentID'])));
					 if(isset($student_id) && !empty($student_id)){
	      					 $studentId=$student_id;
					 } else {
						 $studentId=0;
					 }
					 
					
					 if(isset($this->request->data['Payment']['academic_year']) 
					 &&  !empty($this->request->data['Payment']['academic_year'])) {
						    $latest_academic_year=$this->request->data['Payment']['academic_year'];
					  } else {
						    $latest_academic_year = $this->AcademicYear->current_academicyear();
					  }
					  /*
	      $latestAcSemester= ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($studentId,$latest_academic_year);
		
	      $latestAcSemester= ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($studentId,$latest_academic_year);
	      $latestSemester=$latestAcSemester['semester'];
	      				*/
	      				
					$acyear_array_data[$latest_academic_year]=$latest_academic_year;
		
			       		//To diplay current academic year as default in drop down list
					$defaultacademicyear=$latestAcSemester['academic_year'];
					$semester[$this->request->data['Payment']['semester']]=$this->request->data['Payment']['semester'];
					$courses=$StudentsSection->getMostRecentSectionPublishedCourseNotRegistered($studentId,$this->request->data['Payment']['semester']);
					
					$registrationFee=100;
					$perCreditHourPayment=900;
		
		
		$this->set(compact('courses','acyear_array_data','student_id','defaultacademicyear','semester','registrationFee','perCreditHourPayment','studentId'));


					
			                   
			             } else {
			                $this->Session->setFlash('<span></span> '.__('The provided student number is not valid.'),'default',array('class'=>'error-box error-message'));      
			             }
			     } else {
			          $this->Session->setFlash('<span></span> '.__('Please provide student number to maintain student applicable payment.'),'default',array('class'=>'error-box error-message'));  
			    
			     }
			
		}
		//$courses=ClassRegistry::init('StudentsSection')->getMostRecentSectionPublishedCourseNotRegistered(46);
		//debug($courses);
		
		
	}

	function student_settle_payment() {
		
		if (!empty($this->request->data) && isset($this->request->data['paid']) && !empty($this->request->data['paid'])) 
		{	
			 $check_duplication=$this->Payment->find('count',array('conditions'=>array('Payment.student_id'=>$this->request->data['Payment']['student_id'],'Payment.academic_year'=>$this->request->data['Payment']['academic_year'],'Payment.semester'=>$this->request->data['Payment']['semester'],'Payment.approval_status'=>array(0,1))));
			 $attachmentRequired=false;
			
			if($this->request->data['Payment']['sponsor_type']=='Self' && empty($this->request->data['Attachment'][0]['file']['name']) ){
				$attachmentRequired=true;
			}

			if ($check_duplication==0 && !$attachmentRequired ) {
			    $this->Payment->create();
			    $this->request->data = $this->Payment->preparedAttachment($this->request->data);
			    $this->request->data['Payment']['payment_date']= date('Y-m-d H:i:s');
			    //$this->request->data['Payment']['reference_number']= $this->request->data['Payment']['sponsor_type'];
			   // $this->request->data['Payment']['fee_amount']=0;
			    if ($this->Payment->saveAll($this->request->data,array('validate'=>'first'))) {
				   $this->Session->setFlash('<span></span>'.__('The payment has been saved'),
				'default',array('class'=>'success-box success-message'));
				    $this->redirect(array('action' => 'index'));
			    } else {
			    	   $error=$this->Payment->invalidFields();
					debug($error);
				   $this->Session->setFlash('<span></span>'.__('The payment could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			    }
			} else if($check_duplication>0){
				  $student_full_name = $this->Payment->Student->field('full_name',array('Student.id'=>$this->request->data['Payment']['student_id']));
               	  		 $this->Session->setFlash('<span></span>'.__('You have already recorded payment for '.$student_full_name.' for '.$this->request->data['Payment']['academic_year'].' and semester '.$this->request->data['Payment']['semester'].'.'),'default',array('class'=>'error-box error-message'));

			} else {
				 if($attachmentRequired){
				   $this->Session->setFlash('<span></span>'.__('Payment slip is not attached. Please attach the payment slip.'),'default',array('class'=>'error-box error-message'));
				  }	
			}	
	      }
	      if(isset($this->student_id) && !empty($this->student_id)){
	      	 $studentId=$this->student_id;
	      } else {
		 $studentId=0;
	      }
	      
	      
	      if(isset($this->request->data['Payment']['academic_year']) &&  !empty($this->request->data['Payment']['academic_year'])) {
		    $latest_academic_year=$this->request->data['Payment']['academic_year'];
	      } else {
		    $latest_academic_year = $this->AcademicYear->current_academicyear();
	      }
	     debug($latest_academic_year);
	     debug( $this->AcademicYear->current_academicyear());

	      $lAcSem=ClassRegistry::init('CourseRegistration')->paySemesterAndAcademicYear($studentId,$latest_academic_year);
	      debug($lAcSem);
	      $latestAcSemester= ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($studentId,$latest_academic_year);
		
	      $latestAcSemester= ClassRegistry::init('CourseRegistration')->getLastestStudentSemesterAndAcademicYear($studentId,$latest_academic_year);
	      $courses=ClassRegistry::init('StudentsSection')->getMostRecentSectionPublishedCourseNotRegistered($studentId,$latestAcSemester['semester']);
	      $latestSemester=$latestAcSemester['semester'];
	      $acyear_array_data[$latestAcSemester['academic_year']]=$latestAcSemester['academic_year']; 
		
       		        	
		// temporary , remove it 

                $semester[$lAcSem['semester']]=$lAcSem['semester'];
                $defaultacademicyear=$lAcSem['academic_year'];
		$acyear_array_data[$lAcSem['academic_year']]=$lAcSem['academic_year'];
		
		debug($defaultacademicyear);

		// To display current academic year as default in drop down list 
		/* replace 
		$defaultacademicyear=$latestAcSemester['academic_year'];
		$semester[$latestAcSemester['semester']]=$latestAcSemester['semester'];

		*/
		$registrationFee=100;
		$perCreditHourPayment=900;
		// temporary , remove it 
		$this->set(compact('courses','acyear_array_data','defaultacademicyear','semester','registrationFee','perCreditHourPayment','studentId'));

	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid payment'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Payment->save($this->request->data)) {
				$this->Session->setFlash(__('The payment has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payment could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Payment->read(null, $id);
		}
		$students = $this->Payment->Student->find('list');
		$this->set(compact('students'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for payment'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Payment->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Payment deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<span></span>'.__('Payment was not deleted'),
		'default',array('class'=>'errro-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}

	public function approve_payments()
	{
	    if (!empty($this->request->data) && !empty($this->request->data['processSelected'])) {
			 foreach ($this->request->data['Payment'] as $k=>&$v) {
                          //debug($v);
			  //die;
			  $basicData = $this->Payment->find('first',array('conditions' => array('Payment.id' => $v['id'])));
			   
			   debug($basicData); 
			   //debug($studentUser);
			   if (!empty($basicData)) {
			       	    	  if ($v['approval_status'] == '') {
					          unset($this->request->data['Payment'][$k]);
					  } else {
						debug($v);
						$v['id'] = $basicData['Payment']['id'];
						//$v['approval_status'] = 1;
						$v['payment_approval_date'] = date('Y-m-d H:i:s');
                                                $v['payment_approved_by'] = $this->Auth->user('full_name');
                                                $v['reference_number'] = $basicData['Payment']['reference_number'];
						   
						if($v['approval_status']==0){
       							$approval='pending';
     							$auto_message['AutoMessage']['message'] = '<p style="text-align:justify; padding:0px; margin:0px">
Your payment is '.$approval.' on state '.$v['approval_remark'].' </p>';
						 } else if($v['approval_status']==1){
	 						$approval='approved';
	 						//$style="style='text-align:justify; padding:0px; margin:0px' class="accepted" ";
	 						$auto_message['AutoMessage']['message'] = '<p style="text-align:justify; padding:0px; margin:0px"  class="accepted" >Your payment is '.$approval.' by '.$this->Auth->user('full_name').''.$v['approval_remark'].' </p>';

						 } else if($v['approval_status']==-1){
							$approval='rejected';
							$auto_message['AutoMessage']['message'] = '<p style="text-align:justify; padding:0px; margin:0px"  class="rejected" >Your payment is '.$approval.' by '.$this->Auth->user('full_name').' '.$v['approval_remark'].' </p>';
						 }
						 $auto_message['AutoMessage']['read'] = 0;
                                                 $auto_message['AutoMessage']['user_id'] = $basicData['Student']['user_id'];
                                                 ClassRegistry::init('AutoMessage')->save($auto_message);
			               }	                   
	                    }
			}
			if(isset($this->request->data['Payment'] ) && !empty($this->request->data['Payment'])){
				if ($this->Payment->saveAll($this->request->data['Payment'], array('validate' => 'first'))) {
					$this->Session->setFlash(__('<span></span>All selected students has been ready for registration.'), 'default', array('class' => 'success-box success-message'));
					$this->redirect(array('action' => 'index'));
				} else {
					$error=$this->Payment->invalidFields();
					debug($error);

					$this->Session->setFlash(__('<span></span>The student could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
				}
			}
	    }
	    if (!empty($this->request->data) && !empty($this->request->data['getonlineapplicant'])) {
			debug($this->request->data);

			if (!empty($this->request->data['Payment']['academic_year'])) {
				$conditions = null;
				$ssacdemicyear = $this->request->data['Payment']['academic_year'];
				$pprogram_id = $this->request->data['Payment']['program_id'];
				$pprogram_type_id = $this->request->data['Payment']['program_type_id'];
				$name = $this->request->data['Payment']['name'];
				$college_ids = array();
				$department_ids = array();
				if (!empty($this->college_ids)) {
					$college_ids = $this->college_ids;
				} elseif (!empty($this->department_ids)) {
					$department_ids = $this->department_ids;
				} else {

				   $department_ids = $this->department_id;
				}
				// retrive list of students based on registrar clerk assigned responsibility
				if (!empty($college_ids)) {
					if (!empty($this->request->data['Payment']['college_id'])) {
						$conditions = array(
							"Payment.academic_year" => $this->request->data['Payment']['academic_year'],
"Payment.academic_year" => $ssacdemicyear,
							"Payment.approval_status" => 0,
							"Student.first_name LIKE" => "$name%",
							"Student.college_id" => $this->request->data['Payment']['college_id'],
							"Student.program_id" => $pprogram_id,
							"Student.program_type_id" => $pprogram_type_id,
							
						);
					} else if (isset($this->request->data['Payment']['department_id']) && !empty($this->request->data['Payment']['department_id'])) {
						
						$conditions = array(
							"Payment.approval_status" => 0,
							"Payment.academic_year" => $this->request->data['Payment']['academic_year'],
"Payment.semester" => $this->request->data['Payment']['semester'],
							
							"Student.first_name LIKE" => "$name%",
							"Student.department_id" => $this->request->data['Payment']['department_id'],
							"Student.program_id" => $pprogram_id,
							"Student.program_type_id" => $pprogram_type_id,
							
						);

					}
				} elseif (!empty($department_ids)) {

					if (!empty($this->request->data['Payment']['department_id'])) {
						$conditions = array(
							
                                                       "Payment.approval_status" => 0,
							"Payment.academic_year" => $this->request->data['Payment']['academic_year'],
"Payment.semester" => $this->request->data['Payment']['semester'],
							
							"Student.first_name LIKE" => "$name%",
							"Student.department_id" => $this->request->data['Payment']['department_id'],
							"Student.program_id" => $pprogram_id,
							"Student.program_type_id" => $pprogram_type_id,

						);
						
					} else {
						$conditions = array(
							

                                                        "Payment.approval_status" => 0,
							"Payment.academic_year" => $this->request->data['Payment']['academic_year'],
"Payment.semester" => $this->request->data['Payment']['semester'],
							
							"Student.first_name LIKE" => "$name%",
							
							"Student.program_id" => $pprogram_id,
							"Student.program_type_id" => $pprogram_type_id,
						);
					}
				}
				//
				debug($conditions);
				if (!empty($conditions)) {
					if (isset($this->request->data['Payment']['limit'])) {
						$limit = $this->request->data['Payment']['limit'];
					} else {
						$limit = 1800;
					}

					$this->paginate = array(
						'limit' => $limit,
						'maxLimit' => $limit,
						'order'=>array('Student.first_name ASC'),
						'contain'=>array('Attachment','Student')
					);
					$this->paginate['conditions'] = $conditions;
					if(isset($this->paginate['conditions']) && !empty($this->paginate['conditions'])){	
	  					$this->Paginator->settings['conditions']=$this->paginate['conditions'];
	  				}

					$this->Paginator->settings = $this->paginate;
					debug($this->Paginator->settings);
					$onlineApplicants = $this->Paginator->paginate('Payment');
					debug($onlineApplicants);
					$this->set('onlineApplicants', $onlineApplicants);
					if (!empty($onlineApplicants)) {
						$this->set('admitsearch', true);
					} else {
						$this->Session->setFlash(__('<span></span>No data is found with your search criteria that needs approval, either all students has been process or no payment is applied online in the given criteria.'), 'default', array('class' => 'info-box info-message'));
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
				$this->set('colleges', $this->Payment->Student->College->find(
					'list',
					array('conditions' => array('College.id' => $college_ids))
				));
				$this->set('departments', $this->Payment->Student->Department->find(
					'list',
					array('conditions' => array('Department.college_id' => $college_ids))
				));
				$this->set('college_level', true);
			} elseif (!empty($this->department_ids)) {
				$department_ids = $this->department_ids;
				$college_ids = $this->Payment->Student->Department->find(
					'list',
					array('conditions' => array('Department.id' => $department_ids),
					'fields'=>array('Department.college_id'))
				);
				debug($department_ids);
				$this->set('departments', $this->Payment->Student->Department->find(
					'list',
					array('conditions' => array('Department.id' => $department_ids))
				));
				$this->set('colleges', $this->Payment->Student->College->find(
					'list',
					array('conditions' => array('College.id' => $college_ids))
				));
				$this->set('department_level', true);
			}
			$this->set(compact('colleges'));
		} else if($this->role_id == ROLE_DEPARTMENT) {
			$departments = ClassRegistry::init('Department')->find('list',
			array('conditions'=>array('Department.id'=>$this->department_id)));
			$collegeIds=ClassRegistry::init('Department')->find('list',
			array('conditions'=>array('Department.id'=>$this->department_id),'fields'=>array('Department.college_id','Department.college_id')));
			
			$colleges = ClassRegistry::init('College')->find('list',array('conditions'=>array('College.id'=>$collegeIds)));
			
			$this->set(compact('colleges', 'departments'));
		}

		$programs = ClassRegistry::init('Program')->find('list');
		$programTypes = ClassRegistry::init('ProgramType')->find('list');
		$this->set(compact(
			'programs',
			'programTypes',
			'departments'
		));
	}
}
