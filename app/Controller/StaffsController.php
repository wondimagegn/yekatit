<?php
class StaffsController extends AppController {

    public $name = 'Staffs';
    public $menuOptions = array(
        'parent' => 'security',
        'exclude'=>array('get_department_staffs',
        	'update_staff_profile','get_instructor_combo','ajax_add_study'),
                'alias' => array(
                    'index' => 'View Staffs',
                    'add' => 'Add Staffs',
                    'staff_profile'=>'View Staff Profile',
                     'general_report'=>'View Report',
                      'maintain_staff_profile'=>'Maintain Staff Profile',

                )
    );
    public $helpers = array('Media.Media');
    public function beforeFilter () {
            parent::beforeFilter();
            $this->Auth->allow('get_instructor_combo', 'get_department_staffs','ajax_add_study');		
    }
	public function index() {
		$this->Staff->recursive = 0;
		if (!empty($this->request->data) && isset($this->request->data['viewStaff'])) { 
	             $options = array();
	              if ($this->role_id == ROLE_DEPARTMENT) {
		           $options[] = array (
		                'Staff.department_id'=>$this->department_id
		           );  
		     } else if ($this->role_id == ROLE_COLLEGE) {
		                 $options[] = array (
		                    'Staff.college_id'=>$this->college_id
		               );  
		      } else {
                             $options[] = array (
		                    'Staff.id is not null'
		               );  
	              }
	              if (!empty($this->request->data['Search']['department_id'])) {
	                   $options [] = array(
	                        'Staff.department_id'=>$this->request->data['Search']['department_id']
	                   
	                     );
	              }
	              if (!empty($this->request->data['Search']['name'])) {
	                   $options [] = array(
	                       "OR"=>
				  	  		array(
				  	  			'Staff.first_name like'=>trim($this->request->data['Search']['name']).'%',
				  	  			'Staff.last_name like'=>trim($this->request->data['Search']['name']).'%',
				  	  			'Staff.middle_name LIKE '=>trim($this->request->data['Search']['name']).'%'
				  	  		)
		     	  		);
	              }
	              
	               if ($this->request->data['Search']['active']==1 && $this->request->data['Search']['deactive']==0) {
	                           $options[] = array(
	                               
	                                "Staff.active "=>1
	                           );         
	              }
	              
	             if ($this->request->data['Search']['deactive']==1 && $this->request->data['Search']['active']==0) {
	                           $options[] = array(
	                               
	                                "Staff.active "=>0
	                           );         
	              }
	               $staffs=$this->paginate($options);
	              if(empty($staffs)) {
                    $this->Session->setFlash('<span></span>'.__('There is no staff  in the given criteria.'),'default',array('class'=>'info-box info-message'));
	                
	              }
	              
	     } else  {
	          if ($this->role_id == ROLE_DEPARTMENT) {
		           $conditions = array (
		                'Staff.department_id'=>$this->department_id
		           );  
		      } else if ($this->role_id == ROLE_COLLEGE) {
		             $conditions = array (
		                'Staff.college_id'=>$this->college_id
		           );  
		      } 
		      
		       $staffs = $this->paginate($conditions);
	     }
		
		
		if ($this->role_id == ROLE_DEPARTMENT ){
		  $departments = $this->Staff->Department->find('list',
		array('conditions'=>array('Department.id'=>$this->department_id)));
		} else if ($this->role_id == ROLE_COLLEGE) {
		   $departments = $this->Staff->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$this->college_id)));
		} else {
                   $departments = $this->Staff->Department->find('list');
	     }
		
		$this->set(compact('staffs','departments'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid staff'),'default',
array('class'=>'info-box info-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if ($this->role_id == ROLE_DEPARTMENT) {
			    $staff=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$id,
'Staff.department_id'=>$this->department_id),'contain'=>array('College','Position','CourseInstructorAssignment'=>array('order'=>array('CourseInstructorAssignment.created DESC'),'PublishedCourse'=>array('Course','Section')),'Department','Title','User'=>array('Role'))));
			    if(empty($staff)){
				     $this->Session->setFlash('<span></span>'.__('You dont have the privilege to  view the selected staff.'),'default',array('class'=>'info-box info-message'));
					$this->redirect(array('action' => 'index'));
				}
		}
		if ($this->role_id == ROLE_COLLEGE) {
			     $staff=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$id,
'Staff.college_id'=>$this->college_id,'Staff.department_id is null'),
'contain'=>array('College','Position','CourseInstructorAssignment'=>array('order'=>array('CourseInstructorAssignment.created DESC'),'PublishedCourse'=>array('Course','Section')),'Department','Title','User'=>array('Role'))));
			    if(empty($staff)){
				     $this->Session->setFlash('<span></span>'.__('You dont have the privilege to  view the selected staff.'),'default',array('class'=>'info-box info-message'));
					$this->redirect(array('action' => 'index'));
				}  
		} else {
			  $staff=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$id),
'contain'=>array('College','CourseInstructorAssignment'=>array('order'=>array('CourseInstructorAssignment.created DESC'),'PublishedCourse'=>array('Course','Section')),'Position','Department','Title','User'=>array('Role'))));
		}
		$this->set('staff', $staff);
	}

	public function add() {
	   
		if (!empty($this->request->data)) {
			$this->Staff->create();
			if ($this->role_id == ROLE_DEPARTMENT) {
			      $this->request->data['Staff']['department_id']=$this->department_id;
			       $this->request->data['Staff']['college_id']=$this->college_id;
				  
			}
			if ($this->role_id == ROLE_COLLEGE) {
			      $this->request->data['Staff']['college_id']=$this->college_id;
				  
			}
			$this->request->data=$this->Staff->preparedAttachment($this->request->data,'Profile');
			if ($this->Staff->saveAll($this->request->data,
				array('validate'=>'first'))) {
				$this->Session->setFlash('<span></span>'.__('The staff has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The staff could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
	    $educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree',
	    	'Diploma'=>'Diploma','Certificate'=>'Certificate');
	    $servicewings=array('Academician'=>'Academician','Librarian'=>'Librarian','Registrar'=>'Registrar','Technical Support'=>'Technical Support');

		$positions = $this->Staff->Position->find('list',array('fields'=>array('id','position')));
		$titles = $this->Staff->Title->find('list');
		 $countries=$this->Staff->Country->find('list');
		$this->set(compact('positions','countries','educations','servicewings', 'titles','users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid staff'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		
		if ($this->role_id == ROLE_DEPARTMENT) {
			    $staff=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$id,
'Staff.department_id'=>$this->department_id),'contain'=>array('College','College','Department','Title','Position','User'=>array('Role'))));
			    if(empty($staff)){
				     $this->Session->setFlash('<span></span>'.__('You don\'t have the privilege to  view the selected staff.'),'default',array('class'=>'info-box info-message'));
					$this->redirect(array('action' => 'index'));
				}
		}
		if ($this->role_id == ROLE_COLLEGE) {
			     $staff=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$id,
'Staff.college_id'=>$this->college_id,'Staff.department_id is null'),
'contain'=>array('College','College','Department','Position','Title','User'=>array('Role'))));
			    if(empty($staff)){
				     $this->Session->setFlash('<span></span>'.__('You don\'t have the privilege to  view the selected staff.'),'default',array('class'=>'info-box info-message'));
					$this->redirect(array('action' => 'index'));
			   }  
		} else {
                      $staff=$this->Staff->find('first',array('conditions'=>array('Staff.id'=>$id),
'contain'=>array('College','College','Department','Position','Title','User'=>array('Role'))));
		}

		if (!empty($this->request->data)) {
			if ($this->role_id == ROLE_DEPARTMENT) {
			      $this->request->data['Staff']['department_id']=$this->department_id;
			       $this->request->data['Staff']['college_id']=$this->college_id;
				  
			}
			if ($this->role_id == ROLE_COLLEGE) {
			      $this->request->data['Staff']['college_id']=$this->college_id;
				  
			}

			$this->request->data=$this->Staff->preparedAttachment($this->request->data,'Profile');
			if ($this->Staff->saveAll($this->request->data,
				array('validate'=>'first'))) {
				$this->Session->setFlash('<span></span>'.__('The staff has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The staff could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Staff->find('first',
			array('conditions'=>array('Staff.id'=>$id),'contain'=>array()));
		}
		
		$positions = $this->Staff->Position->find('list',array('fields'=>array('id',
		'position')));
		$educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree',
	    	'Diploma'=>'Diploma','Certificate'=>'Certificate');
	    $servicewings=array('Academician'=>'Academician','Librarian'=>'Librarian','Registrar'=>'Registrar','Technical Support'=>'Technical Support');
	    $countries=$this->Staff->Country->find('list');

		$titles = $this->Staff->Title->find('list');
		$this->set(compact( 'positions','educations','servicewings', 'departments','countries', 'titles', 'users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for staff'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Staff->canItBeDeleted($id)) {
		    if ($this->Staff->delete($id)) {
			    $this->Session->setFlash('<span></span>'.__('Staff deleted'),
			    'default',array('class'=>'success-box success-message'));
			    $this->redirect(array('action'=>'index'));
		    }
		
		} else {
		    $this->Session->setFlash('<span></span>'.__('Staff was not deleted. It is involved in course assignments.'),'default',array('class'=>'error-box error-message'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	function get_instructor_combo ($department_id=null) {
	         $this->layout='ajax';
	          
	          $staffs=$this->Staff->find('all',
	          array('conditions'=>array('Staff.department_id'=>$department_id,
			  'Staff.active'=>1,
	          'Staff.user_id  IN (SELECT id FROM users 
	          WHERE role_id='.ROLE_INSTRUCTOR.' OR (is_admin=1 and role_id ='.ROLE_DEPARTMENT.' ) ) '),'contain'=>array('Position','Title')));
	         $instructors=array();
	         
	         if (!empty($staffs)) {
	             foreach ($staffs as $in=>$value) {
	                     $instructors[$value['Position']['position']][$value['Staff']['id']]=$value['Title']['title'].' '.$value['Staff']['full_name'];
	             
	             }
	         }	                 
	         $this->set(compact('instructors'));
	}
	
	function get_department_staffs($department_id = null) {
		$this->layout = 'ajax';
		$staffs = array();
		if(!empty($department_id)) {
			if(strcasecmp($department_id, 'External') == 0) {
				$staffsTmp = ClassRegistry::init('StaffForExam')->find('all',
					array(
						'conditions' =>
						array(
							'StaffForExam.college_id' => $this->college_id,
							'StaffForExam.active' => 1,
						),
						'fields' =>
						array(
							'StaffForExam.id',
							'StaffForExam.first_name',
							'StaffForExam.middle_name',
							'StaffForExam.last_name'
						),
						'recursive' => -1
					)
				);
				foreach($staffsTmp as $staff) {
					$staffs[$staff['StaffForExam']['id']] = $staff['StaffForExam']['first_name'].' '.$staff['StaffForExam']['middle_name'].' '.$staff['StaffForExam']['last_name'];
				}
			}
			else {
				$staffs = $this->Staff->find('list',
					array(
						'conditions' =>
						array(
							'Staff.department_id' => $department_id,
							'Staff.active' => 1,
						),
						'fields' =>
						array(
							'Staff.id',
							'Staff.full_name'
						)
					)
				);
			}
		}
		$this->set(compact('staffs'));
	}

	public function general_report() {
	  $this->layout='report';
	  if(isset($this->request->data['getReport']) || 
	  	isset($this->request->data['getReportExcel'])) {

	  	 if($this->request->data['Staff']['report_type']=='distributionStatsGenderTeachersByGender') {

	  	 	
	     	$distributionStatistics=ClassRegistry::init('Staff')->getDistributionStats(
	                $this->request->data['Staff']['department_id'],
	                 $this->request->data['Staff']['gender']
	            ); 

	     	debug($distributionStatistics);
	       $showFromToBlock=true;
	     
		   
		   $headerLabel='Distribution Statistics of Teachers By Gender ';
		
	       if($this->request->data['Staff']['report_type']=='distributionStatsGenderTeachersByGender' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Statistics of Teacher By Gender-'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/staffs/xls/distribution_gender_xls');
				return;	
	       } 
           $this->set(compact('distributionStatistics','showFromToBlock','years','headerLabel'));

	     } else if($this->request->data['Staff']['report_type']=='distributionStatsByAcademicRank') {

	     	$distributionStatistics=ClassRegistry::init('Staff')->getDistributionStatsByAcademicRank(
	                $this->request->data['Staff']['department_id'],
	                 $this->request->data['Staff']['gender']
	            ); 
	     	
	       $showFromToBlock=true;
	     
		   
		   $headerLabel='Distribution Statistics of Teachers By Academic Year ';
		
	       if($this->request->data['Staff']['report_type']=='distributionStatsByAcademicRank' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Statistics of Teacher By Gender-'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/staffs/xls/distribution_academic_rank_xls');
				return;	
	       } 

	        $teacherPositionLists=$this->Staff->find('list',
	          array('conditions'=>array(
	          'Staff.user_id  IN 
	           (SELECT id FROM users WHERE role_id='.ROLE_INSTRUCTOR.' )',
	           ),
	          'fields'=>array('Staff.position_id'),
	          'group'=>array('Staff.position_id')
	          )
	         );
	   $positions=$this->Staff->Position->find('list',array('fields'=>array('id','position'),
	   	'conditions'=>array('Position.id'=>$teacherPositionLists)
	   	));

           $this->set(compact('distributionStatistics','showFromToBlock','positions','headerLabel'));
	     } if($this->request->data['Staff']['report_type']=='distributionStatsByStudents') {

	  	 	
	     	$distributionStatistics=ClassRegistry::init('Staff')->getDistributionStatsTeacherToStudents(
	                $this->request->data['Staff']['department_id'],
	                 $this->request->data['Staff']['gender']
	            ); 

	       debug($distributionStatistics);
	       $showFromToBlock=true;
	     
		   
		   $headerLabel='Distribution Statistics of Teacher To Student';
		
	       if($this->request->data['Staff']['report_type']=='distributionStatsByStudents' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Statistics of Teacher To Students -'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/staffs/xls/distribution_teachertostudent_stat_xls');
				return;	
	       } 
           $this->set(compact('distributionStatistics','showFromToBlock','years','headerLabel'));

	     } else if($this->request->data['Staff']['report_type']=='active_staff_list'){
	            $distributionStatistics=ClassRegistry::init('Staff')->getActiveStaffList(
	                $this->request->data['Staff']['department_id'],
	                 $this->request->data['Staff']['gender']
	            ); 
	       $showFromToBlock=true;
		   $headerLabel='Active Staff List';
		
	       if($this->request->data['Staff']['report_type']=='active_staff_list' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Active Staff List -'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/staffs/xls/active_staff_list_xls');
				return;	
	       } 
           $this->set(compact('distributionStatistics','showFromToBlock','years','headerLabel'));
           	
	     } else if($this->request->data['Staff']['report_type']=='inactive_staff_list') {
	     	  $distributionStatistics=ClassRegistry::init('Staff')->getActiveStaffList(
	                $this->request->data['Staff']['department_id'],
	                 $this->request->data['Staff']['gender'],0
	            ); 
	       $showFromToBlock=true;
		   $headerLabel='Deactivated Staff List';
		
	       if($this->request->data['Staff']['report_type']=='active_staff_list' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Deactivated Staff List -'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/staffs/xls/active_staff_list_xls');
				return;	
	       } 
           $this->set(compact('distributionStatistics','showFromToBlock','years','headerLabel'));
	     }

	   }
	 
	  $report_type_options = array(
    	  	'Distribution'=>array(
    	 	'distributionStatsGenderTeachersByGender'=>'Distribution Statistics Teachers By Gender',
    	 	'distributionStatsByAcademicRank'=>'Distribution Statistics By Academic Rank',
    	 
    	 	'distributionStatsByStudents'=>'Distribution Statistics of Teacher to  Students'
    	 	),
    	  	
    	  	'List'=>array(
    	  		   'active_staff_list'=>'Active Staff List',
                    'inactive_staff_list'=>'Deactivated Staff List',  	
    	  			//'top_academic_staff_rated_by_student'=>'Top Rated Teachers'

    	  		),
    	 );
	      //debug($academicStatuses);
	 if (!empty($this->department_ids) || 
!empty($this->college_ids)) {
	     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
	 } else {
	     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);
	 }
	    $default_department_id = $this->request->data['Staff']['department_id'];
	   // $default_region_id=$this->request->data['Staff']['default_region_id'];
	    $regions=ClassRegistry::init('Region')->find('list');
	    if($this->role_id == ROLE_DEPARTMENT){
	    	$departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(0, 
			$this->department_id, array());
		} else if ($this->role_id==ROLE_COLLEGE) {
	       $departments =  ClassRegistry::init('Department')->allDepartmentsByCollege2(1, array(), $this->college_id);
		} else {
			$departments =array(0 => 'All University Students') + $departments;
			
		}

		$graph_type=array('bar'=>'Bar Chart',
'pie'=>'Pie Chart','line'=>'Line Chart');
        $this->set(compact('departments','regions','report_type_options','graph_type','default_department_id','default_region_id'));
    }

    public function maintain_staff_profile() {
	   
		if (!empty($this->request->data)) {
			$nodept=true;
			if($this->request->data['Staff']['servicewing']=="Academician" && empty($this->request->data['Staff']['department_id'])){
				$nodept=false;
			} 
            $this->request->data=$this->Staff->preparedAttachment($this->request->data,'Profile');

			$this->Staff->create();	
			if ($this->Staff->saveAll($this->request->data,
				array('validate'=>'first')) && $nodept) {
				$this->Session->setFlash('<span></span>'.__('The staff has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				if($nodept==false){
                   $this->Session->setFlash('<span></span>'.__('Please provide department if the service wing is academician.'),'default',array('class'=>'error-box error-message'));
				} else {
					$this->Session->setFlash('<span></span>'.__('The staff could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				}
			}
		}
	    $educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree',
	    	'Diploma'=>'Diploma','Certificate'=>'Certificate');
	    $servicewings=array('Academician'=>'Academician','Librarian'=>'Librarian','Registrar'=>'Registrar','Technical Support'=>'Technical Support');
		$positions = $this->Staff->Position->find('list',array('fields'=>array('id','position')));
		$titles = $this->Staff->Title->find('list');
		$countries=$this->Staff->Country->find('list');
		$colleges=$this->Staff->College->find('list');
		$this->set(compact('positions', 'titles','countries','colleges','educations','servicewings'));
	}

	function update_staff_profile($id = null) {
        if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid staff'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data)) {
			$nodept=true;
			if($this->request->data['Staff']['servicewing']=="Academician" && empty($this->request->data['Staff']['department_id'])){
				$nodept=false;
			} 
			$this->request->data=$this->Staff->preparedAttachment($this->request->data,'Profile');

		
			$attachmentId=$this->Staff->Attachment->field('Attachment.id',array('Attachment.model'=>'Staff',
				'Attachment.group'=>'Profile',
				'Attachment.foreign_key'=>$id));
			
			if ($this->Staff->saveAll($this->request->data,
				array('validate'=>'first')) && $nodept) {
				$delete=$this->Staff->Attachment->delete($attachmentId);

				$this->Session->setFlash('<span></span>'.__('The staff has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				if($nodept==false){
                   $this->Session->setFlash('<span></span>'.__('Please provide department if the service wing is academician.'),'default',array('class'=>'error-box error-message'));
				} else {
					$this->Session->setFlash('<span></span>'.__('The staff could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				}
			}
		}

		if (empty($this->request->data)) {
			$this->request->data = $this->Staff->find('first',
			array('conditions'=>array('Staff.id'=>$id),'contain'=>array()));
			$departments=$this->Staff->Department->find('list',
				array('conditions'=>array('Department.college_id'=>$this->request->data['Staff']['college_id'])));
		}
		

	    $educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree',
	    	'Diploma'=>'Diploma','Certificate'=>'Certificate');
	    $servicewings=array('Academician'=>'Academician','Librarian'=>'Librarian','Registrar'=>'Registrar','Technical Support'=>'Technical Support');
		$positions = $this->Staff->Position->find('list',array('fields'=>array('id','position')));
		$titles = $this->Staff->Title->find('list');
		$countries=$this->Staff->Country->find('list');
		$colleges=$this->Staff->College->find('list');

		$this->set(compact('positions', 'titles','countries','colleges','educations','departments','servicewings'));
		 $this->render('maintain_staff_profile');
	}


	public function staff_profile($staff_id=null) {
	   if(!empty($staff_id) && is_numeric($staff_id)){
             $checkIdIsValid=$this->Staff->find('count',array('conditions'=>array('Staff.id'=>$staff_id)));
             if (isset($checkIdIsValid) && $checkIdIsValid>0) {
	           $staff_profile=$this->Staff->find('first',
	           	array('conditions'=>array('Staff.id'=>$staff_id),
	           		'contain'=>array('Department','College',
	           			'StaffStudy'=>array('Attachment'),'Position','Title','Country','Attachment')));
            	
	           $this->set(compact('staff_profile'));
	        }

	    }

	    if (!empty($this->request->data) && isset($this->request->data['continue'])) { 
	    	if (!empty($this->request->data['Staff']['staffid'])) {
                $checkIdIsValid=$this->Staff->find('count',array('conditions'=>array('Staff.staffid'=>$this->request->data['Staff']['staffid'])));
                if($checkIdIsValid>0){

                	 $staff_profile=$this->Staff->find('first',
	           	array('conditions'=>array('Staff.staffid'=>$this->request->data['Staff']['staffid']),
	           		'contain'=>array('Department','College',
	           			'StaffStudy'=>array('Attachment'),'Position','Title','Country','Attachment')));
                	 $this->set(compact('staff_profile'));

                } else {
                    $this->Session->setFlash('<span></span> '.__('The provided staff id is not valid.'),'default',array('class'=>'error-box error-message'));
                }
	    	}
	    }
	    $countries=$this->Staff->Country->find('list');
	    $this->set(compact('countries'));

	}

	 public function ajax_add_study($staff_id,$editId=null)
     {
		  	$this->layout='ajax';
       		$educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree',
	    	'Diploma'=>'Diploma','Certificate'=>'Certificate','HDP'=>'HDP');
	    	if(!empty($editId)){
	    		$this->request->data=$this->Staff->StaffStudy->find('first',
			array('conditions'=>array('StaffStudy.id'=>$editId),'contain'=>array()));
	    	}
	    	$staff_profile=$this->Staff->find('first',
	           	array('conditions'=>array('Staff.id'=>$staff_id),
	           		'contain'=>array('Department','College',
	           			'StaffStudy'=>array('Attachment','Country'),'Position','Title','Country','Attachment')));
        	$countries=$this->Staff->Country->find('list');
        	$this->set(compact('educations','countries','staff_profile'));
	  }

	
}
