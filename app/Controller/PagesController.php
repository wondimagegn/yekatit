<?php
App::uses('AppController', 'Controller');
App::uses('ArrayUtils', 'Lib');
class PagesController extends AppController
{
	public $menuOptions = array(
		'parent' => 'dashboard',
		'exclude' => array(
			'academic_calender', 
			'announcement',
			'official_transcript_request',
			'official_request_tracking',
			'online_admission_tracking', 
			'admission',
			'check_graduate',
			'check_remedial_result',
			'check_campus_placement',
			'get_department_combo'
		)
	);

	var $helpers = array('DatePicker', 'Media.Media');

	public $uses = array('OfficialTranscriptRequest', 'OnlineApplicant');

	public $paginate = array();

	public $components = array('EthiopicDateTime', 'Email','Billing', 'Paginator', 'AcademicYear', 'MathCaptcha',);


	public function beforeRender()
	{
		$acyear_array_data = $this->AcademicYear->academicYearInArray(date('Y') - 1, date('Y'));
		$defaultacademicyear = $this->AcademicYear->current_academicyear();
		$this->set(compact('acyear_array_data', 'defaultacademicyear'));
	}

	public function beforeFilter()
	{
		parent::beforeFilter();
		//$this->layout='page';
		$this->layout = "page-alternative";
		$this->Auth->allow(
			'academic_calender',
			'announcement',
			'official_transcript_request',
			'official_request_tracking',
			'online_admission_tracking',
			'admission',
			'check_graduate',
			'check_remedial_result',
			'check_campus_placement',
			'get_department_combo'
		);
	}

	public function display()
	{
		$this->layout = 'default-e';
		$path = func_get_args();
		$count = count($path);

		if (!$count) {
			return $this->redirect('/');
		}

		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}

		if (!empty($path[1])) {
			$subpage = $path[1];
		}

		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}

		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}


	public function academic_calender()
	{
		if (isset($this->request->data) && !empty($this->request->data['viewAcademicCalendar'])) {
			
			$options = array();

			if (!empty($this->request->data['Search']['program_id'])) {
				$options[] = array(
					'AcademicCalendar.program_id' => $this->request->data['Search']['program_id']
				);
			}

			if (!empty($this->request->data['Search']['program_type_id'])) {
				$options[] = array(
					'AcademicCalendar.program_type_id' => $this->request->data['Search']['program_type_id']
				);
			}

			if (!empty($this->request->data['Search']['department_id'])) {
				$options[] = array(
					'AcademicCalendar.department_id like ' => '%s:_:"' . $this->request->data['Search']['department_id'] . '"%',
				);
			}

			if (!empty($this->request->data['Search']['academic_year'])) {
				$options[] = array(
					'AcademicCalendar.academic_year' => $this->request->data['Search']['academic_year']
				);
			}

			if (!empty($this->request->data['Search']['semester'])) {
				$options[] = array(
					'AcademicCalendar.semester' => $this->request->data['Search']['semester']
				);
			}

			$academicCalendars = ClassRegistry::init('AcademicCalendar')->find('all', array(
				'conditions' => $options,
				'contain' => array('Program', 'ProgramType')
			));

			/* $academicCalendars = ClassRegistry::init('AcademicCalendar')->find('all', array(
				'conditions' => $options,
				'contain' => array('College', 'Department', 'YearLevel', 'Program', 'ProgramType')
			)); */

			if (empty($academicCalendars)) {
				$this->Flash->info('There is no academic calendar defined in the system in the given criteria.');
			} else {
				foreach ($academicCalendars as $ack => &$ackv) {
					$department_ids = unserialize($ackv['AcademicCalendar']['department_id']);
					$year_level_ids = unserialize($ackv['AcademicCalendar']['year_level_id']);
					$found = false;

					$college_ids_found = array();

					if(!empty($department_ids)){
						
						foreach ($department_ids as $dptkey => $dptvalue) {
							$college_ids = explode('pre_', $dptvalue);
							if (count($college_ids) > 1) {
								array_push($college_ids_found, $college_ids[1] );
							}
						}

						// debug(implode(", ", $college_ids_found));

						// this is  not the correct setting, pre selection in adding in acalendar affects how department and year level is being displayed, this fixes that temporarly
						// but it is not to see and correct duplicated calendar definitions for frehsnam(selecting check all for departments while adding calendar, pre is also selected) 

						//$ackv['AcademicCalendar']['department_name'] = implode(", ", ClassRegistry::init('AcademicCalendar')->Department->find('list', array('conditions' => array('Department.id' => $department_ids))));
						//$ackv['AcademicCalendar']['year_name'] = implode(", ", $year_level_ids);

						if(!empty($college_ids_found)){
							$ackv['AcademicCalendar']['department_name'] = implode(", ", ClassRegistry::init('AcademicCalendar')->College->find('list', array('conditions' => array('College.id' => $college_ids_found))));
							$ackv['AcademicCalendar']['year_name'] = 'Pre/Freshman';
						} else {

							// will show the calendar have duplicate definition or whether the added calendar is correct as desired.
							// although this is the correct setting, pre selection in adding in acalendar affects how department and year level is being displayed 

							$ackv['AcademicCalendar']['department_name'] = implode(", ", ClassRegistry::init('AcademicCalendar')->Department->find('list', array('conditions' => array('Department.id' => $department_ids))));
							$ackv['AcademicCalendar']['year_name'] = implode(", ", $year_level_ids);
						}
					}


					/* if (in_array("pre_", $department_ids, true)) {
						$ackv['AcademicCalendar']['department_name'] = implode(", ", ClassRegistry::init('AcademicCalendar')->College->find('list', array('conditions' => array('College.id' => $department_ids))));
						$ackv['AcademicCalendar']['year_name'] = 'Pre/1st';
					} else {
						$ackv['AcademicCalendar']['department_name'] = implode(", ", ClassRegistry::init('AcademicCalendar')->Department->find('list', array('conditions' => array('Department.id' => $department_ids))));
						$ackv['AcademicCalendar']['year_name'] = implode("\n", $year_level_ids);
					} */
				}
			}
		}

		$programs = ClassRegistry::init('Program')->find('list');
		$programTypes = ClassRegistry::init('ProgramType')->find('list');

		$this->set(compact('academicCalendars', 'programs', 'programTypes'));
		//$this->set(compact('departments', 'academicCalendars', 'programs', 'programTypes'));
	}


	public function announcement()
	{
		$announcements = ClassRegistry::init('Announcement')->getNotExpiredAnnouncements();
		$this->set(compact('announcements'));
	}

	public function official_transcript_request()
	{

        $this->layout = "page-alternative";
        $trackingnumber = ClassRegistry::init('OfficialTranscriptRequest')->nextTrackingNumber();

		$this->OfficialTranscriptRequest->set($this->request->data);

		if ($this->OfficialTranscriptRequest->validates($this->request->data)) {
			debug($this->request->data);
		} else {
			$errors = $this->OfficialTranscriptRequest->validationErrors;
			$errors = $this->OfficialTranscriptRequest->invalidFields();
		}
		if ($this->request->is('post')) {
			$this->request->data['OfficialTranscriptRequest']['trackingnumber'] = $trackingnumber;
			$this->OfficialTranscriptRequest->create(); 
			$this->OfficialTranscriptRequest->set($this->request->data);
			if ($this->OfficialTranscriptRequest->saveAll($this->request->data)) {
				$this->Flash->success('The official transcript request has been forwared to designated personnel.Your tracking number is $trackingnumber.');

                $request=$this->OfficialTranscriptRequest->find('first',
                array('conditions' => array('OfficialTranscriptRequest.id' =>$this->OfficialTranscriptRequest->id),
                    'recursive' => -1));
                $selectedFeeTypeIds=ClassRegistry::init('FeeType')->findActiveApplicableFeeTypes(
                    array('official'),
                    'one-time',
                    'all_applicants'
                );
                $feeType=array();

                $context = array(
                    'targetEntity' => $request,
                    'payer_name'   =>ucfirst(strtolower($request['OfficialTranscriptRequest']['first_name'])) . ' ' .
                        ucfirst(strtolower($request['OfficialTranscriptRequest']['father_name'])) . ' ' .
                        ucfirst(strtolower($request['OfficialTranscriptRequest']['grand_father_name'])),
                    'payer_email'  =>  $request['OfficialTranscriptRequest']['email'],
                    'dynamic'      => $feeType // will be used in calculateFeeAmount
                );

                $generated = $this->Billing->generateInvoices(
                    'OfficialTranscriptRequest',
                    $request['OfficialTranscriptRequest']['id'],
                    $selectedFeeTypeIds,
                    $context
                );
                debug($generated);
                if($generated) {
                    $receiptNumberr = ClassRegistry::init('Invoice')->find('first',
                        array('conditions' => array(
                            'Invoice.payer_id' => $request['OfficialTranscriptRequest']['id'],
                            'Invoice.payer_type' => 'OfficialTranscriptRequest',

                        ),
                            'recursive' => -1,
                            'order' => 'Invoice.id DESC'
                        ));
                    $receiptNumber=$receiptNumberr['Invoice']['receipt_code'];

                    $invoiceUrl = Router::url(array(
                        'controller' => 'invoices', 'action' => 'generate_invoice',$receiptNumber
                    ));
                }


                return $this->redirect(array('action' => 'official_request_tracking'));
			} else {
				$error = $this->OfficialTranscriptRequest->invalidFields();
				debug($error);
				$this->Flash->error('The official transcript request could not be saved.');
			}
		}

		$admissiontypes = ClassRegistry::init('ProgramType')->find('list', array('fields' => array(
			'ProgramType.name',
			'ProgramType.name'
		)));

		$degreetypes['Bachelor of Arts'] = "Bachelor of Arts";
		$degreetypes['Bachelor of Science'] = "Bachelor of Science";
		$degreetypes['Doctor of Medicine'] = "Doctor of Medicine";
		$degreetypes['Master of Science'] = "Master of Science";
		$degreetypes['Master of Arts'] = "Master of Arts";
		$degreetypes['Doctor of Philosophy'] = 'Doctor of Philosophy';

		$this->set(compact('admissiontypes', 'degreetypes'));
	}

	public function official_request_tracking()
	{
		if (isset($this->request->data['OfficialTranscriptRequest']) && !empty($this->request->data['OfficialTranscriptRequest']['trackingnumber'])) {
			$request = $this->OfficialTranscriptRequest->find('first', array('conditions' => array('OfficialTranscriptRequest.trackingnumber' => trim($this->request->data['OfficialTranscriptRequest']['trackingnumber'])), 'contain' => array('OfficialRequestStatus')));
			if (empty($request)) {
				$this->Flash->warning('The tracking number provided is not valid or request cancelled.');
			}
			$this->set(compact('request'));
		}

		$statuses = array(
			'request_verified' => 'Request Verified', 
			'request_cancelled' => 'Request Cancelled',
			'document_sent' => 'Document Sent To Destination'
		);
		$this->set(compact('statuses'));
	}




    public function online_admission_tracking($receiptNumber = null)
    {
        debug($this->request->data);
        if (isset($this->request->data['OnlineApplicant']) && !empty($this->request->data['OnlineApplicant']['applicationnumber'])) {
            debug($this->request->data);
            $request = $this->OnlineApplicant->find('first', array('conditions' => array('OnlineApplicant.applicationnumber' =>
                trim($this->request->data['OnlineApplicant']['applicationnumber'])), 'contain' => array(
                'OnlineApplicantStatus','Invoice', 'Program', 'ProgramType',
                'Department', 'College', 'Attachment'
            )));

            if (empty($request['Invoice']) && !empty($request['OnlineApplicant']['id'])){

                debug($request);
                // check if invoice is required for registration
                $invoiceRequired = Configure::read('Invoice.required');
                if($invoiceRequired) {
                    debug($this->params['action']);
                    $selectedFeeTypeIds=ClassRegistry::init('FeeType')->findActiveApplicableFeeTypes(
                        array('admission'),
                        'one-time',
                        'all_applicants'
                    );
                    $feeType=array();

                    $context = array(
                        'targetEntity' => $request,
                        'payer_name'   =>ucfirst(strtolower($request['OnlineApplicant']['first_name'])) . ' ' .
                            ucfirst(strtolower($request['OnlineApplicant']['father_name'])) . ' ' .
                            ucfirst(strtolower($request['OnlineApplicant']['grand_father_name'])),
                        'payer_email'  =>  $request['OnlineApplicant']['email'],
                        'dynamic'      => $feeType // will be used in calculateFeeAmount
                    );

                    $generated = $this->Billing->generateInvoices(
                        'OnlineApplicant',
                        $request['OnlineApplicant']['id'],
                        $selectedFeeTypeIds,
                        $context
                    );
                    debug($generated);
                    if($generated) {
                        $receiptNumberr = ClassRegistry::init('Invoice')->find('first',
                            array('conditions' => array(
                                'Invoice.payer_id' => $request['OnlineApplicant']['id'],
                                'Invoice.payer_type' => 'OnlineApplicant',
                            ),
                                'recursive' => -1,
                                'order' => 'Invoice.id DESC'
                            ));
                        $receiptNumber=$receiptNumberr['Invoice']['receipt_code'];

                        $invoiceUrl = Router::url(array(
                            'controller' => 'invoices', 'action' => 'generate_invoice',$receiptNumber
                        ));
                    }

                }
                //create the invoice

                //$receiptNumber = $this->Billing->generateInvoice($request['OnlineApplicant']['id'], 'admission', $payerDetails, $dueDate);



                $request = $this->OnlineApplicant->find('first', array('conditions' => array('OnlineApplicant.applicationnumber' =>
                    trim($request['OnlineApplicant']['applicationnumber'])), 'contain' => array(
                    'OnlineApplicantStatus', 'Program', 'ProgramType',
                    'Department', 'College', 'Attachment'
                )));
            }

            if(isset($request['OnlineApplicant']['id']) && !empty($request['OnlineApplicant']['id'])){

                $academicCalendar = ClassRegistry::init('AcademicCalendar')->find('count', array('conditions' => array(
                    'AcademicCalendar.online_admission_end_date >=' => date('Y-m-d'),

                    'AcademicCalendar.academic_year' => $request['OnlineApplicant']['academic_year'],
                    'AcademicCalendar.semester' => $request['OnlineApplicant']['semester'],

                    'AcademicCalendar.department_id like' => '%s:_:"' . $request['OnlineApplicant']['department_id'] . '"%',
                    'AcademicCalendar.program_id' => $request['OnlineApplicant']['program_id'],
                    'AcademicCalendar.program_type_id' => $request['OnlineApplicant']['program_type_id']

                )));

            }

            $submittedRequest = $this->request->data['OnlineApplicant'];
            debug($this->request->data);
            if (
                (isset($this->request->data['Attachment'][1]['file']['name']) && !empty($this->request->data['Attachment'][1]['file']['name']) ||
                    isset($this->request->data['Attachment'][0]['file']['name']) && !empty($this->request->data['Attachment'][0]['file']['name']))
                && isset($request) && !empty($request) && !empty(($this->request->data['OnlineApplicant']['email'])
            )) {
                //incase already submitted update attachment
                $this->request->data = $this->OnlineApplicant->preparedAttachment($this->request->data);
                $this->request->data['OnlineApplicant'] = $request['OnlineApplicant'];
                $validUpdate = 0;
                if (
                    strcasecmp(
                        $submittedRequest['email'],
                        $request['OnlineApplicant']['email']
                    ) == 0
                ) {

                    $validUpdate = 1;
                }
                foreach ($request['Attachment'] as $kkk => $vvv) {
                    $this->request->data['Attachment'][$kkk]['id'] = $vvv['id'];
                    $this->request->data['Attachment'][$kkk]['foreign_key'] = $vvv['foreign_key'];
                }
                debug($validUpdate);
                debug($academicCalendar);
                if ($validUpdate && $academicCalendar) {
                    debug($academicCalendar);
                    if ($this->OnlineApplicant->saveAll($this->request->data)) {
                        $this->Session->setFlash('<span></span>' . __("Your online application files is updated successfully to application number " . $request['OnlineApplicant']['applicationnumber'] . " and use it for tracking your application status. "), 'default', array('class' => 'success-box success-message'));
                    } else {
                        debug($this->request->data);
                    }
                } else {
                    if ($validUpdate && $academicCalendar!=0) {
                        $this->Session->setFlash('<span></span>' . __("Your online application files is not updated due to mismatch of email address on the already filed application. "), 'default', array('class' => 'error-box error-message'));
                    } else if ($academicCalendar == 0) {
                        $this->Session->setFlash('<span></span>' . __("Updating  online application deadline is passed. "), 'default', array('class' => 'error-box error-message'));
                    }
                }
            }



            if (empty($request)) {
                $this->Session->setFlash('<span></span>' . __("The application number  is invalid or request cancelled."),
                    'default', array('class' => 'error-box	error-message'));
            }

            debug($request);

            if (isset($request['Invoice'][0]['receipt_code']) && !empty($request['Invoice'][0]['receipt_code'])) {

                $receiptNumber=$request['Invoice'][0]['receipt_code'];
                $unpaidPayment = ClassRegistry::init('Invoice')->find(
                    'first',
                    array(
                        'conditions' => array(
                            'Invoice.receipt_code' => $receiptNumber,
                            'Invoice.status' => 'Pending',
                        ),
                        'order' => array('Invoice.created DESC'),
                        'recursive' => -1
                    )
                );

                $paymentMethods = ClassRegistry::init('PaymentMethod')->find(
                    'all',
                    array(
                        'conditions' => array('PaymentMethod.active' => 1),
                        'order' => array('PaymentMethod.created DESC'),
                        'contain' => array('Attachment')
                    )
                );
                $this->set(compact('unpaidPayment', 'paymentMethods'));
            }

            $this->set(compact('request'));
        }
        //$statuses = array('pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected');
        $statuses = array('0' => 'Pending', '1' => 'Approved', '-1' => 'Rejected');



        if (isset($receiptNumber) && !empty($receiptNumber)) {
            $payments = ClassRegistry::init('Invoice')->find(
                'all',
                array(
                    'conditions' => array('Invoice.receipt_code' => $receiptNumber),
                    'order' => array('Invoice.created DESC'),
                    'recursive' => -1
                )
            );
            $paymentMethods = ClassRegistry::init('PaymentMethod')->find(
                'all',
                array(
                    'conditions' => array('PaymentMethod.active' => 1),
                    'order' => array('PaymentMethod.created DESC'),
                    'contain' => array('Attachment')
                )
            );
            debug($paymentMethods);
            $this->set(compact('payments', 'paymentMethods'));

        }

        $this->set(compact('statuses'));
    }

    public function admission()
    {

        // application form will be active based on the deadline
        $academicCalendars = ClassRegistry::init('AcademicCalendar')->find('all',
            array('conditions' => array('AcademicCalendar.online_admission_end_date >=' => date('Y-m-d'))));
        $student_payment_types = array('Full Paying Students'=>'Full Paying Students',
            'Full Scholarship'=>'Full Scholarship');

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


            $departments = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.id' => $departmentIds)));
            $college_ids = ClassRegistry::init('Department')->find('list', array('conditions' => array('Department.id' => $departmentIds), 'fields' => array('Department.college_id', 'Department.college_id')));

            $colleges = ClassRegistry::init('Department')->allCollegeByCampus($college_ids);

            $campus_ids = ClassRegistry::init('College')->find(
                'list',
                array(
                    'conditions' => array('College.id' => $college_ids),
                    'fields' => array('College.campus_id', 'College.campus_id')
                )
            );
            $campuses = ClassRegistry::init('Campus')->find(
                'list',
                array(
                    'conditions' => array('Campus.id' => $campus_ids),
                    'fields' => array('Campus.id', 'Campus.name')
                )
            );
            $programs = ClassRegistry::init('Program')->find(
                'list',
                array('conditions' => array('Program.id' => $programIds))
            );

            $programTypes = ClassRegistry::init('ProgramType')->find(
                'list',
                array('conditions' => array('ProgramType.id' => $programTypesIds))
            );
        }


        if (
            $this->request->is('post') && isset($this->request->data['OnlineApplicant']['declaration'])
            && !empty($this->request->data['OnlineApplicant']['declaration'])
        ) {

            $deptDetails = ClassRegistry::init('Department')->find('first',
                array('conditions' => array('Department.id' =>
                    $this->request->data['OnlineApplicant']['department_id']),'recursive' => -1));
            $this->request->data['OnlineApplicant']['college_id'] = $deptDetails['Department']['college_id'];

            $isAdmitted = $this->OnlineApplicant->isAppliedFordmittion($this->request->data);

            if ($isAdmitted == 0) {

                $this->request->data = $this->OnlineApplicant->preparedAttachment($this->request->data);
                $this->request->data['OnlineApplicant']['first_name'] = ucfirst(strtolower($this->request->data['OnlineApplicant']['first_name']));
                $this->request->data['OnlineApplicant']['father_name'] = ucfirst(strtolower($this->request->data['OnlineApplicant']['father_name']));
                $this->request->data['OnlineApplicant']['grand_father_name'] = ucfirst(strtolower($this->request->data['OnlineApplicant']['grand_father_name']));
                $this->request->data['OnlineApplicant']['mother_fullname'] = ucfirst(strtolower($this->request->data['OnlineApplicant']['mother_fullname']));
                $this->request->data['OnlineApplicant']['place_of_birth'] = ucwords(strtolower($this->request->data['OnlineApplicant']['place_of_birth']));
                $this->request->data['OnlineApplicant']['emergency_contact_name'] = ucwords(strtolower($this->request->data['OnlineApplicant']['emergency_contact_name']));
                $this->request->data['OnlineApplicant']['emergency_contact_relation'] = ucwords(strtolower($this->request->data['OnlineApplicant']['emergency_contact_relation']));
                $this->request->data['OnlineApplicant']['emergency_contact_address'] = ucwords(strtolower($this->request->data['OnlineApplicant']['emergency_contact_address']));
                $this->request->data['OnlineApplicant']['disability']=implode(',', $this->request->data['OnlineApplicant']['disability']);

                if ($this->OnlineApplicant->saveAll($this->request->data)) {


                    $applicationnumber = $this->OnlineApplicant->field('OnlineApplicant.applicationnumber',
                        array('OnlineApplicant.id' => $this->OnlineApplicant->id));

                    // check if invoice is required for registration
                    $invoiceRequired = Configure::read('Invoice.required');
                    if($invoiceRequired) {

                        $targetEntity=$this->OnlineApplicant->findById($this->OnlineApplicant->id);

                        debug($this->params['action']);
                        $selectedFeeTypeIds=ClassRegistry::init('FeeType')->findActiveApplicableFeeTypes(
                            array($this->params['action']),
                            'one-time',
                            'all_applicants'
                        );
                        $feeType=array();

                        $context = array(
                            'targetEntity' => $targetEntity,
                            'payer_name'   =>ucfirst(strtolower($this->request->data['OnlineApplicant']['first_name'])) . ' ' .
                                ucfirst(strtolower($this->request->data['OnlineApplicant']['father_name'])) . ' ' .
                                ucfirst(strtolower($this->request->data['OnlineApplicant']['grand_father_name'])),
                            'payer_email'  =>  $this->request->data['OnlineApplicant']['email'],
                            'dynamic'      => $feeType // will be used in calculateFeeAmount
                        );

                        $generated = $this->Billing->generateInvoices(
                            'OnlineApplicant',
                            $this->OnlineApplicant->id,
                            $selectedFeeTypeIds,
                            $context
                        );
                        debug($generated);
                        if($generated) {
                            $receiptNumber = ClassRegistry::init('Invoice')->find('first',
                            array('conditions' => array(
                                    'Invoice.payer_id' => $this->OnlineApplicant->id,
                                    'Invoice.payer_type'=>'OnlineApplicant'
                                ),
                                'recursive' => -1,
                                'order' => 'Invoice.id DESC'
                                ));
                            $invoiceUrl = Router::url(array(
                                'controller' => 'invoices', 'action' => 'generate_invoice', $receiptNumber['Invoice']['receipt_code']
                            ));
                        }
                    }

                    $message = "You made an online admission application request that has been forwared to designated personnel of 
the university for further processing. <br /> <strong>Your application  number is <u> $applicationnumber </u> 
and use it for tracking your application status.</strong> <br /> <br/> ";

                    $departmentName = $this->OnlineApplicant->Department->field('Department.name', array('Department.id' => $this->request->data['OnlineApplicant']['department_id']));
                    $collegeName = $this->OnlineApplicant->College->field('College.name', array('College.id' => $this->request->data['OnlineApplicant']['college_id']));
                    $programName = $this->OnlineApplicant->Program->field('Program.name', array('Program.id' => $this->request->data['OnlineApplicant']['program_id']));
                    $programTypeName = $this->OnlineApplicant->ProgramType->field('ProgramType.name', array('ProgramType.id' => $this->request->data['OnlineApplicant']['program_type_id']));
                    $message .= '<table width="100%" bgcolor="#ffffff" border="0"
			    cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;border:0;margin:0;auto">';
                    $message .= "<tr><td align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>Name:</td><td align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>" . $this->request->data['OnlineApplicant']['first_name'] . ' ' . $this->request->data['OnlineApplicant']['father_name'] . ' ' . $this->request->data['OnlineApplicant']['father_name'] . "</td></tr>";

                    $message .= "<tr><td  align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>Study Level:</td><td  align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>" . $programName . "</td></tr>";

                    $message .= "<tr><td align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>Admission Type:</td><td  align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>" . $programTypeName . "</td></tr>";

                    $message .= "<tr><td align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>College:</td><td  align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>" . $collegeName . "</td></tr>";


                    $message .= "<tr><td align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>Department:</td><td  align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'>" . $departmentName . "</td></tr>";

                    $message .= "<tr><td colspan='2' align='left' valign='top' style='font-family:Tahoma,Arial,Helvetica,sans-serif;color:#000;font-size:16px;line-height:24px;'> Please  <a href=$invoiceUrl>  download the invoice by clicking this link </a> and settled the payment at bank.</td></tr>";


                    $message .= '</table>';

                    $Email = new CakeEmail('default');
                    $Email->template('onlineapplication');
                    $Email->emailFormat('html');
                    //$Email->from(array('wondetask@gmail.com' => 'AMU Student Portal'));
                    $Email->to($this->request->data['OnlineApplicant']['email']);
                    $Email->subject('Online Admission Summary: ' . $this->request->data['OnlineApplicant']['first_name'] . ' ' . $this->request->data['OnlineApplicant']['father_name'] . ' for ' . $this->request->data['OnlineApplicant']['academic_year'] . ' academic year');
                    $Email->viewVars(array('message' => $message));


                    try {
                        if ($Email->send()) {
                            $this->Session->setFlash('<span></span>' .
                                __("Your online admission application request has been forwarded to designated personnel 
                                of the university for further processing. Your application number is  $applicationnumber 
                                and sent to " . $this->request->data['OnlineApplicant']['email'] . " 
                                address for tracking your application status. 
                                Please  <a href=$invoiceUrl>  download the invoice by clicking this link </a> 
                                and settled the payment at bank."), 'default', array('class' => 'success-box success-message'));


                        } else {
                            $this->Session->setFlash('<span></span>' . __("Your online application request has been forwared 
to designated personnel of the university for further processing. Your application  number is $applicationnumber 
and use it for tracking your application status.Please  <a href=$invoiceUrl>  download the invoice by clicking this link </a> 
and settled the payment at bank. "), 'default', array('class' => 'success-box success-message'));
                        }
                    } catch (Exception $e) {
                        $this->Session->setFlash('<span></span>' . __("Your online application request has been forwared to 
designated personnel of the university for further processing. Your application  number is $applicationnumber and use it for
 tracking your application status. Please  <a href=$invoiceUrl>  download the invoice by clicking this link </a> and settled the 
 payment at bank. "), 'default', array('class' => 'success-box success-message'));
                        return $this->redirect(array('action' => 'online_admission_tracking'));
                    }
                    return $this->redirect(array('action' => 'online_admission_tracking'));

                } else {
                    $error = $this->OnlineApplicant->invalidFields();

                    $this->set('errors', $error);

                    $this->Session->setFlash('<span></span>' . __('The online admission  request could not be saved.'), 'default', array('class' => 'error-box	error-message'));
                }
            } else {

                $applicationnumber = $this->OnlineApplicant->find('first',
                    array('conditions' => array(
                        'OnlineApplicant.applicationnumber' => $isAdmitted
                    ),
                        'recursive' => -1));
                $receiptNumber = ClassRegistry::init('Invoice')->find('first',
                    array('conditions' => array(
                        'Invoice.payer_id' => $applicationnumber['OnlineApplicant']['payer_id'],
                        'Invoice.payer_type'=>'OnlineApplicant'
                    ),
                        'recursive' => -1,
                        'order' => 'Invoice.id DESC'
                    ));

                $this->Session->setFlash('<span></span>' . __("Your online application request has been forwared to designated personnel of the university for further processing. Your application  number is $isAdmitted and use it for tracking your application status. "), 'default', array('class' => 'success-box success-message'));
                 $this->redirect(array('action' => 'online_admission_tracking', $receiptNumber['Invoice']['receipt_code']));
            }
        }


        $country_id_of_region = COUNTRY_ID_OF_ETHIOPIA;

        $financial_supports = array('Self' => 'Self', 'Non-Governmental Organization' => 'Non-Governmental Organization', 'Government Organization' => 'Government Organization');
        $regions = ClassRegistry::init('Region')->find(
            'list',
            array('fields' => array('Region.id', 'Region.name'))
        );
        $countries = ClassRegistry::init('Country')->find(
            'list',
            array('fields' => array('Country.id', 'Country.name'))
        );

        $regionsAll = ClassRegistry::init('Region')->find('list', array('conditions' => array('Region.active' => 1,
            'Region.country_id' => $country_id_of_region)));
        $zonesAll =  ClassRegistry::init('Zone')->find('list', array('conditions' => array('Zone.active' => 1)));
        $woredasAll =  ClassRegistry::init('Woreda')->find('list', array('conditions' => array('Woreda.active' => 1)));
        $citiesAll =  ClassRegistry::init('City')->find('list', array('conditions' => array('City.active' => 1)));


        $this->set(compact(
            'departments',
            'academicCalendars',
            'programs',
            'programTypes',
            'regionsAll',
            'zonesAll',
            'woredasAll',
            'citiesAll',
            'countries',
            'regions',
            'departments',
            'semester',
            'acyeardatas',
            'financial_supports',
            'campuses',
            'student_payment_types'
        ));
    }


	public function check_graduate($studentID = null)
	{
		//debug($this->request->data);
		if ((!empty($this->request->data) && isset($this->request->data['continue'])) || !empty($studentID)) {

			if ((isset($this->request->data['Page']['security_code']) && $this->MathCaptcha->validates($this->request->data['Page']['security_code'])) || isset($this->request->data['Page']['mathCaptcha']) ||!empty($studentID)) {
				
				if (empty($studentID)) {
					$studentID = trim($this->request->data['Page']['studentID']);
				} else {
					$studentID = str_replace('-','/', $studentID);
				}
				
				$isStudentValid = ClassRegistry::init('Student')->find('count', array('conditions' => array('Student.studentnumber' => $studentID), 'recursive' => -1));

				//debug($this->request->data);
				//debug($isStudentValid);

				if ($isStudentValid > 0) {

					$students = ClassRegistry::init('GraduateList')->Student->find('first', array(
						'conditions' => array(
							'Student.studentnumber' => $studentID
						),
						'contain' => array(
							'GraduateList', 
							'Attachment', 
							'Program', 
							'Department', 
							'College', 
							'ProgramType', 
							'Curriculum' => array(
								'fields' => array('english_degree_nomenclature')
							),
							'StudentExamStatus' => array(
								//'order' => array('StudentExamStatus.created' => 'DESC')
								'order' => array('StudentExamStatus.id' => 'DESC', 'StudentExamStatus.academic_year' => 'DESC', 'StudentExamStatus.semester' => 'DESC')
							),
							'ExitExam' => array(
								'order' => array('ExitExam.exam_date' => 'DESC', 'ExitExam.id' => 'DESC')
							),
							/* 'CertificateVerificationCode' => array(
								'conditions' => array(
									'CertificateVerificationCode.type' => 'CC'
								),
								'order' => array('CertificateVerificationCode.id' => 'DESC'),
								'limit' => 1
							) */
						)
					));

					//debug($students);

					$this->set(compact('students'));

				} else {
					//$this->Flash->info('The student number provided is not found in our system. If you made typo error please try again else the given student number is not our student based on the admitted student data since 2012 G.C!. For Further verification of students graduated offline or not enrolled online, contact office of the university registrar via email, official letter or in person.');
					$this->Flash->info('The student ID you entered was not found in our system. Please double-check for any typing errors and try again. If the number is correct, it may not belong to a student admitted since 2012 G.C. For verification of students who graduated offline or were not enrolled through the online system, kindly contact the Office of the Registrar via email, official letter, or in person.');
					$this->set('studentIDNotFound', 1);
				}
			} else {
				$this->Flash->error('Please enter the correct answer to the math question.');
			}

			if (!empty($this->request->data['Page']['studentID'])) {
				$this->set('studentID', trim($this->request->data['Page']['studentID']));
			} else {
				$this->set('studentID', $studentID);
			}
		}

		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
	}


    function get_department_combo()
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
                $allDeptIds=ClassRegistry::init('Department')->find('list',
                    array('conditions' => array('Department.college_id' =>
                        $allCollegeIds
                    ), 'fields' => array('Department.id', 'Department.id')));

            } else if(isset($this->request->data['OnlineApplicant']['college_id']) &&
                !empty($this->request->data['OnlineApplicant']['college_id'])) {

                $allDeptIds=ClassRegistry::init('Department')->find('list',
                    array('conditions' => array('Department.college_id' =>
                        $this->request->data['OnlineApplicant']['college_id']
                    ), 'fields' => array('Department.id', 'Department.id')));

            }


            $academicCalendarss = ClassRegistry::init('AcademicCalendar')->find('all', array(
                'conditions' => array(
                    'AcademicCalendar.online_admission_end_date >=' => date('Y-m-d'),
                    'AcademicCalendar.program_id' => $this->request->data['OnlineApplicant']['program_id'],

                    'AcademicCalendar.program_type_id' => $this->request->data['OnlineApplicant']['program_type_id'],
                    'AcademicCalendar.academic_year' => $this->request->data['OnlineApplicant']['academic_year'],
                    'AcademicCalendar.semester' => $this->request->data['OnlineApplicant']['semester'],
                ),
                'recursive' => -1
            ));
        } else if(isset($this->request->data['Page']) && !empty($this->request->data['Page'])){

            if(isset($this->request->data['Page']['campus_id']) &&
                !empty($this->request->data['Page']['campus_id'])){
                $allCollegeIds=ClassRegistry::init('College')->find('list',
                    array('conditions' => array('College.campus_id' =>
                        $this->request->data['Page']['campus_id']),

                        'fields' => array('College.id', 'College.id')));
                $allDeptIds=ClassRegistry::init('Department')->find('list',
                    array('conditions' => array('Department.college_id' =>
                        $allCollegeIds
                    ), 'fields' => array('Department.id', 'Department.id')));

            } else if(isset($this->request->data['Page']['college_id']) &&
                !empty($this->request->data['Page']['college_id'])) {

                $allDeptIds=ClassRegistry::init('Department')->find('list',
                    array('conditions' => array('Department.college_id' =>
                        $this->request->data['OnlineApplicant']['college_id']
                    ), 'fields' => array('Department.id', 'Department.id')));

            }


            $academicCalendarss = ClassRegistry::init('AcademicCalendar')->find('all', array(
                'conditions' => array(
                    'AcademicCalendar.online_admission_end_date >=' => date('Y-m-d'),
                    'AcademicCalendar.program_id' => $this->request->data['Page']['program_id'],
                    'AcademicCalendar.program_type_id' => $this->request->data['Page']['program_type_id'],
                    'AcademicCalendar.academic_year' => $this->request->data['Page']['academic_year'],
                    'AcademicCalendar.semester' => $this->request->data['Page']['semester'],
                ),
                'recursive' => -1
            ));
            debug($academicCalendarss);
        }


        // get all departments which is open
        $depIds = array();
        foreach ($academicCalendarss as $ack => $acv) {
            $tmpIds = unserialize($acv['AcademicCalendar']['department_id']);
            $matched = ArrayUtils::extractContained($tmpIds, $allDeptIds);
            $depIds = array_merge($depIds, $matched);
        }


        if (isset($depIds) && !empty($depIds)) {

            $academicCalendars['AcademicCalendar']['department_id'] = $depIds;
            if (isset($depIds) && !empty($depIds)) {
                $departments = ClassRegistry::init('Department')->find('list', array('conditions' => array(
                    'Department.id' => $depIds

                )));
            }
        }

        $this->set(compact('departments'));
    }


    function populate_student_detail()
    {
        $this->layout = 'ajax';
        $this->autoRender = false;


        $studentdetail = ClassRegistry::init('Student')->find('first', array('conditions'
        => array('OR' => array(
                'Student.studentnumber like' => $this->request->data['OfficialTranscriptRequest']['studentnumber'] . '%',
                'Student.studentid like' => $this->request->data['OfficialTranscriptRequest']['studentnumber'] . '%',
            )), 'recursive' => -1));
        //return json_encode($studentdetail);

        echo json_encode($studentdetail);



        //$this->set('_serialize', array('studentdetail'));
    }


    public function check_remedial_result()
	{
		if (SHOW_REMEDIAL_RESULT_CHECK_LINK == 1) {

			$firstNameProvided = '';
			$searchKeyProvided = '';

			if ((!empty($this->request->data) && isset($this->request->data['continue']))) {

				$firstNameProvided = $this->request->data['Page']['first_name'];
				$searchKeyProvided = $this->request->data['Page']['search_key']; 

				if ((isset($this->request->data['Page']['security_code']) && $this->MathCaptcha->validates($this->request->data['Page']['security_code']))) {
					$resultFound = ClassRegistry::init('RemedialResult')->findRemedialResult($this->request->data);
					//debug($resultFound);
					if (empty($resultFound)) {
						$this->Flash->info('The combination of First Name and AMU Student ID or MoE Admission Number appears to be incorrect. Please review your input for any typing errors and try again.');
					}
					unset($this->request->data['continue']);
					$this->set(compact('resultFound'));
				} else {
					$this->Flash->error('Please enter the correct answer to the math question.');
				}
			}

			// pass the search keys for redisplay for correction if searched entry doesn't exist.
			$this->set('firstNameProvided', $firstNameProvided);
			$this->set('searchKeyProvided', $searchKeyProvided);

			$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

		} else {
			$this->Session->setFlash('Sorry, we couldn’t process your request. Either no recent remedial result announcement is available, or the result checking period for the previous batch has expired.', 'default', ['class' => 'info']);
			return $this->redirect('/');
		}
	}

	public function check_campus_placement()
	{
		if (SHOW_CAMPUS_PLACEMENT_CHECK_LINK == 1) {

			$firstNameProvided = '';
			$searchKeyProvided = '';

			if ((!empty($this->request->data) && isset($this->request->data['continue']))) {

				$firstNameProvided = $this->request->data['Page']['first_name'];
				$searchKeyProvided = $this->request->data['Page']['search_key']; 

				if ((isset($this->request->data['Page']['security_code'])
                    && $this->MathCaptcha->validates($this->request->data['Page']['security_code']))) {
					$resultFound = ClassRegistry::init('CampusPlacement')->checkCampusPlacement($this->request->data);
					//debug($resultFound);
					if (empty($resultFound)) {
						$this->Flash->info('The combination of First Name and MoE Admission Number appears to be incorrect. Please review your input for any typing errors and try again.');
					}
					unset($this->request->data['continue']);
					$this->set(compact('resultFound'));
				} else {
					$this->Flash->error('Please enter the correct answer to the math question.');
				}
			}

			// pass the search keys for redisplay for correction if searched entry doesn't exist.
			$this->set('firstNameProvided', $firstNameProvided);
			$this->set('searchKeyProvided', $searchKeyProvided);

			$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

		} else {
			//$this->Session->setFlash('Sorry, we couldn’t process your request. Either no recent campus placement announcement is available, or the campus placement checking period for the previous batch has expired.', 'default', ['class' => 'info']);
			return $this->redirect('/');
		}
	}
}
