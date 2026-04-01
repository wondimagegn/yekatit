<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail','Network/Email');
class UsersController extends AppController {

	public $name = 'Users';
	public $menuOptions = array(
	//'parent' => 'dashboard',
	'parent'=>'security',
	'exclude' => array('resetpassword','assign', 'assign_user_dorm_block',
	'assign_user_meal_hall', 'cancel_task_confirmation','build_user_menu', 'confirm_task',
	'editprofile'),
	'alias' => array(
	'index' => 'List All Users',
	'add' => 'Create User',
	'changePwd' => 'Change Your Password',
	'department_create_user_account'=>'Create User Account'
	),
	'weight'=>-2,
	);
	public $components = array(
	'Attempt','MathCaptcha','Email','Ticketmaster','Session'
	);
	public $helpers = array('Xls','Media.Media','Session');
	public $loginAttemptLimit = 3;
	//var $loginAttemptDuration = '+1 hour';
	// var $loginAttemptDuration = '5m';
	public $loginAttemptDuration = '+5 minutes';

 	public $paginate = array(
	'limit' => 20,
	'order' => array(
	    'User.full_name' => 'asc'
	));
	public function beforeRender(){
	parent::beforeRender();
	// Ensure that encrypted passwords are not sent back to the user
	unset($this->request->data['User']['password']);
	unset($this->request->data['User']['passwd']);
	unset($this->request->data['User']['oldpassword']);
	unset($this->request->data['User']['password2']);
	unset($this->request->data['User']['confirm_password']);
	}
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login','logout','forget','useticket','changePwd',
		'resetpassword','build_user_menu','edit','newpassword',
		'get_department');
		//delete auth flash message from the session
		if($this->Session->check('Message.auth')){
		 $this->Session->delete('Message.auth');
		}
		
		// If logged in, these pages require logout
		if ($this->Auth->user() && in_array($this->request->params['action'], array('login'))) {
		return $this->redirect($this->Auth->logout());
		}	

	}

    public function login() {
		$this->layout='home';
		$this->loadModel('Securitysetting');
		$securitysetting['Securitysetting'] = array();
		$securitysetting=$this->Securitysetting->find('first');
		
		if(isset($securitysetting)){
		   $number_of_login_attempt= 
		   $securitysetting['Securitysetting']['number_of_login_attempt'];
		   
		} else {
		    $number_of_login_attempt=$this->loginAttemptLimit;
		 
		}
       
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash(__('<span></span>You are logged in!'),'default',
	array('class'=>'success-box success-message'));
			return $this->redirect('/');
		}
	    if ($this->request->is('post')) 
        {
        $this->request->data['User']['username']=trim($this->request->data['User']['username']);
        	 
				if($this->Attempt->limit($this->request->data['User']['username'],'login', $number_of_login_attempt)) {
				 
				if ($this->Auth->login() && $this->Auth->user('active')) {
				//debug($this->data);
					
					$this->User->id=$this->Auth->user('id');
					$this->User->saveField('last_login',date('Y-m-d H:i:s'));
					
					return $this->redirect('/');
				} else {
				  
				   if($this->Auth->user('active')==false && $this->Auth->user('role_id')==3){
				      // has a graduated status
				     $graduated=ClassRegistry::init('Student')->find('first',array('conditions'=>array('Student.studentnumber'=>$this->Auth->user('username')),'contain'=>array('GraduateList','Alumnus')));
				     if(isset($graduated['GraduateList']['student_id']) && !empty($graduated['GraduateList']['student_id']) && empty($graduated['Alumnus']['student_id'])){
				     
				      return $this->redirect(array('controller' => 'alumni', 'action' => 'add'));
				      
				   	  }
				   }
				   // Invalid credentials, 
				   // count as failed attempt for an hour
					$this->Session->setFlash(__('<span></span>Your username or password was incorrect.'),'default',array('class'=>'error-box error-message'));
				     $this->Attempt->fail($this->request->data['User']['username'],'login', $this->loginAttemptDuration);
				}
		
			   } else {
			    
				 // User exceeded attempt limit
				  $bruteForce=$this->request->data['User']['username'].' account has been attempted '.$number_of_login_attempt.' times  from '.$this->RequestHandler->getClientIP().' IP address';

                 ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$bruteForce.'</u>. Please give appropriate warning.');

				 $this->Session->setFlash('<span></span>Too many failed attempts! ','default', array('class' => 'error-box error-message'));
				 if (!empty($this->request->data['User']['security_code'])) {
					 if (
		$this->MathCaptcha->validates($this->request->data['User']['security_code'])){
					if ($this->Auth->login() && $this->Auth->user('active')) {
					$this->User->id = $this->Auth->user('id');
					$this->User->lastLogin($this->Auth->user('id'));
					$this->Session->setFlash(__('<span></span>You are logged in!'),'default',
		array('class'=>'success-box success-message'));
					$this->redirect('/');         

					}  else {
					// Invalid credentials, count as failed attempt for an hour
					$this->Attempt->fail($this->request->data['User']['username'],'login', $this->loginAttemptDuration);
					$this->Session->setFlash(__('<span></span>Unknown username or wrong password.',true),'default', array('class' => 'error-box error-message'));
					}

					} else {
					$this->Session->setFlash(__('<span></span>Please enter the correct answer to the math question.', true),'default',array('class' => 'error-box error-message')); 
					}
				        }
				$this->set('mathCaptcha', $this->MathCaptcha->generateEquation()); 
			   }
		  }
	
     }
     public function logout() {
     	/*
			 $this->Session->setFlash(__('<span></span>Thank you for using SMiS. Come again!'),'default', array('class' => 'success-box success-message'));
			 */
			 $this->Session->destroy();
			 $this->redirect($this->Auth->logout());
     }
     public function index() {
		$this->User->recursive = 0;
		if(!empty($this->request->data)){
			$conditions=$this->User->searchUserConditions($this->role_id, $this->request->data,$this->department_id, $this->college_id);
		} else {
			$conditions=$this->User->searchUserConditions($this->role_id, null,$this->department_id, $this->college_id);
		}
        debug($conditions);
		$parent_roles=$this->User->Role->find('list',
array('conditions'=>array('Role.parent_id'=>$this->role_id)));
	
		$parent_roles[$this->role_id]=$this->role_id;
        unset($parent_roles[3]);
        debug($parent_roles);
		$roles = $this->User->Role->find('list',array('conditions'=>array('OR'=>array('Role.parent_id'=>$parent_roles,'Role.id'=>$this->role_id)))); 
		$this->set(compact('roles'));
		$this->Paginator->settings=$this->paginate;		
		$this->Paginator->settings['conditions']=$conditions['conditions'];
       
        $this->set('users', $this->Paginator->paginate('User'));
      }

    public function view($id = null) {
	if (!$id) {
	$this->Session->setFlash('<span></span>'.__('Invalid user!'),'default', array('class' => 'error-box error-message'));
          return $this->redirect(array('action' => 'index'));
	 }
	  $colleges = $this->User->Staff->College->find('list');
	   $departments = $this->User->Staff->Department->find('list', 
	array('fields' => array('id', 'name'), 'order' => 'Department.name'));

		 $user=$this->User->find('first',array('conditions'=>array('User.id'=>$id),
'contain'=>array('Role','StaffAssigne','Staff'=>array('College','Department','Position','Title'),'Student'=>array('College','Department'))));

	   $this->set(compact('user','colleges','departments'));
    }
    
    public function add() 
    {
	
        if(!empty($this->request->data)) {
	     $this->set($this->request->data); 
             
	     foreach($this->request->data['Staff'] as 
$k=>$v){
               $this->request->data['User']['first_name']=$v['first_name'];
               $this->request->data['User']['last_name']=$v['last_name'];
               $this->request->data['User']['middle_name']=$v['middle_name'];
               $this->request->data['User']['email']=$v['email'];
                              break;
         }
		 if ($this->role_id == ROLE_SYSADMIN) {
			 $check=$this->User->checkNumberOfUserAccount($this->request->data);
		 } else {
			$check=true;
		 }
	     if ($check) {
				$password=$this->User->generatePassword(5);		
				$this->request->data['User']['passwd']=$password;	
				if($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
						$this->Session->setFlash(__('<span></span>The user has been created and email sent to user.', true),'default', array('class' => 'success-box success-message'));
				         $staff_details= $this->User->find('first',array('conditions'=>array('User.id'=>$this->User->id),'contain'=>array('Staff'=>array('Department','College'=>array('Campus'),'Title'))));
				$university=ClassRegistry::init('University')->find('first',array('contain'=>array('Attachment'=>array('order'=>array('Attachment.created DESC'))),'order'=>array('University.created DESC')));
			
				$this->set(compact('staff_details','university','password'));
				
				$this->response->type('application/pdf');
		 		$this->layout = '/pdf/default';
				$this->render('issue_password_staff_pdf');
				
									
				} else {
				debug($this->User->invalidFields());
				  $this->Session->setFlash(__('<span></span>The user could not be saved. Please, try again.', true), 'default', array('class' => 'error-box error-message'));
				}
	    } else {
                  $error=$this->User->invalidFields();
				  
				   if (isset($error['college_department'])) {
					     $this->Session->setFlash('<span></span>'.($error['college_department'][0]),'default',array('class'=>'error-box error-message'));
					}
	    }
	}
	$parent_roles=$this->User->Role->find('list',
array('conditions'=>array('Role.parent_id'=>$this->role_id)));
	
	$parent_roles[$this->role_id]=$this->role_id;
	$roles = $this->User->Role->find('list',array('conditions'=>array('OR'=>array('Role.parent_id'=>$parent_roles,'Role.id'=>$this->role_id)))); 
         //$countries=$this->User->Staff->Country->find('list');
	 $positions=$this->User->Staff->Position->find('list', array('fields'=>array('id','position')));
	 $titles=$this->User->Staff->Title->find('list');
	 //$cities=$this->User->Staff->City->find('list');
	 $colleges = $this->User->Staff->College->find('list');
	 $departments = $this->User->Staff->Department->find('list');

	 $educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree',
	    	'Diploma'=>'Diploma','Certificate'=>'Certificate');
	    $servicewings=array('Academician'=>'Academician','Librarian'=>'Librarian','Registrar'=>'Registrar','Technical Support'=>'Technical Support');

	$this->set(compact('departments','educations','servicewings','countries',
	'cities','colleges','roles','titles','positions',
'college_department'));
       }
       public function edit($id = null) {
	   
	    if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('<span></span>Invalid user!'), 'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
	    }
	    $check_existed_user_ids=$this->User->find('count',
array('conditions'=>array('User.id'=>$id)));
	    
	    if ($check_existed_user_ids == 0) {
	    
	        $this->Session->setFlash('<span></span>'.__('Invalid user!. The selected user does not exist.'), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                 
                 $this->redirect(array('action'=>'index'));
	    
	    }
	    
	    if ($this->role_id == ROLE_COLLEGE ) {
	          if (!$this->User->checkUserIsBelongsInYourAdmin($id,$this->role_id,null,
	          $this->college_id)){
				
					  $ownAccount=$this->User->find('count',
                         array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
					 if(!$ownAccount){
                        $this->Session->setFlash('<span></span>'.__('
				         You are not elegible to edit the selected user details. The user belongs to other administrator.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                 
                        $this->redirect(array('action'=>'index'));
					 }
	          }
	          
	    } else if ($this->role_id == ROLE_DEPARTMENT) {
				
	             if (!$this->User->checkUserIsBelongsInYourAdmin($id,$this->role_id,$this->department_id,null)){
					
					  $ownAccount=$this->User->find('count',
                         array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
					 if(!$ownAccount){
                        $this->Session->setFlash('<span></span>'.__('
				         You are not elegible to edit the selected user details. The user belongs to other administrator.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                 
                        $this->redirect(array('action'=>'index'));
					 }
	            }
	           
	    } else {
	          if (!$this->User->checkUserIsBelongsInYourAdmin($id,$this->role_id)){
					  $ownAccount=$this->User->find('count',
                         array('conditions'=>array('User.id'=>$this->Auth->user('id'))));
					 if(!$ownAccount){
                        $this->Session->setFlash('<span></span>'.__('
				         You are not elegible to edit the selected user details. The user belongs to other administrator.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                 
                        $this->redirect(array('action'=>'index'));
					 }
	              
	          }
	         
	    }
	      /*
	     $is_account_admin=$this->User->find('count',
                         array('conditions'=>array('User.id'=>$this->Auth->user('id'),'User.role_id'=>$this->role_id,
                         'User.is_admin'=>1)));
            
	     if ($is_account_admin==0) {
	                $this->Session->setFlash('<span></span>'.__('Edit  is failed.
				         You are not elegible to edit the selected user details. Contact the administrator of your respective department.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                         $this->redirect(array('action'=>'index'));
                        //$this->redirect(array('action'=>'view',$id));  
	      }
	   */
	    if (!empty($this->request->data)) {
		            $this->User->set($this->request->data); // this set the data to the model then we can use validates function
		            if($this->User->validates()){
		              
		                 foreach($this->request->data['Staff'] as $k=>&$v){
                              $this->request->data['User']['first_name']=$v['first_name'];
                              $this->request->data['User']['last_name']=$v['last_name'];
                              $this->request->data['User']['middle_name']=$v['middle_name'];
                              if(!empty($v['email'])){
                                $this->request->data['User']['email']=$v['email'];
                              }
                              $this->request->data['User']['id']=$id;
                              break;
                         }
                       
                         if ($this->role_id == ROLE_REGISTRAR){
					   				
				                   // $this->request->data['Staff'][0]['assigned_to']=serialize($this->request->data['Staff'][0]['assigned_to']);     
				                      
						    }
			if ($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
				/*
			if ($this->request->data['User']['active']==0) {

			$this->Session->setFlash('<span></span>'.__('You have deactivated the user. Please assigned to other user the deactived user assignment. Deactivated user do not have access to the system .'),'default', array('class' => 'success-box success-message'));

			} else {

			$this->Session->setFlash('<span></span>'.__('The user data has been updated.'),
			'default', array('class' => 'success-box success-message'));

			}
			*/
            $this->Session->setFlash('<span></span>'.__('The user data has been updated.'),
			'default', array('class' => 'success-box success-message'));
			$this->redirect(array('action' => 'index'));
		} else {
		    $this->Session->setFlash(__('<span></span>The user could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
		    debug($this->User->invalidFields());
		}
				            
		}

		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
		}
		
	    $countries=$this->User->Staff->Country->find('list');
		$positions=$this->User->Staff->Position->find('list', array('fields'=>array('id','position')));
		$titles=$this->User->Staff->Title->find('list');
		$cities=$this->User->Staff->City->find('list');
		$colleges = $this->User->Staff->College->find('list');
		$departments = $this->User->Staff->Department->find('list');

         
		//filter out main account roles they are allowed to create 
	
		  if($this->role_id==ROLE_DEPARTMENT){
		        
		         $conditions=array(
	                    'Role.id'=>array(ROLE_DEPARTMENT,ROLE_INSTRUCTOR));
		       
		   } elseif($this->role_id==ROLE_REGISTRAR){
		        $conditions=array('id'=>ROLE_REGISTRAR);
		   } elseif($this->role_id==ROLE_MEAL){
		        $conditions=array('id'=>ROLE_MEAL);
		    } elseif($this->role_id==ROLE_HEALTH){
		        $conditions=array('id'=>ROLE_HEALTH);
		    } elseif($this->role_id==ROLE_ACCOMODATION) {
		         $conditions=array('id'=>ROLE_ACCOMODATION);
		         
		    } elseif($this->role_id == ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM){
		         $conditions=array('id'=>ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM);
		   
		    } elseif($this->role_id == ROLE_SYSADMIN) {
		        $conditions=array('Role.id <>'=>ROLE_INSTRUCTOR,
		        'OR'=>array('Role.id <>'=>ROLE_STUDENT));
		    } else {
		        $conditions=array();
		    }
		    
		    if($conditions){
				/*
		        $roles = $this->User->Role->find('list',array('conditions'=>$conditions));
$parent_roles=$this->User->Role->find('list',
array('conditions'=>array('Role.parent_id'=>$this->role_id)));
				*/
	$parent_roles[$this->role_id]=$this->role_id;
	$roles = $this->User->Role->find('list',array('conditions'=>array('OR'=>array('Role.parent_id'=>$parent_roles,'Role.id'=>$this->role_id)))); 

		    }
		    $this->set(compact('roles'));
		
           $colleges = $this->User->Staff->College->find('list');
		   $college_department=array();
	       foreach($colleges as $college_id => $college_name) {
	      
            $departmentss = $this->User->Staff->Department->find('list', 
array('fields' => array('id', 'name'), 
'conditions' => array('Department.college_id' => $college_id), 'order' => 'Department.name'));
           
			    foreach($departmentss as $department_id => $departmentname) {
				    $college_department[$college_id][$department_id] =  $departmentname;
			    }
            
          }
		 $this->set(compact('departments','countries',
		'cities','colleges','titles','positions','college_department'));
		//$this->render('add');
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('<span></span>Invalid id for user.'),
			'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('<span></span>User deleted!'),
			'default', array('class' => 'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('<span></span>User was not deleted.'),
		'default', array('class' => 'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	
	
     /*
	 * change password
	 */
	public function changePwd() {
		if(!empty($this->request->data)) {	 
		$this->loadModel('Securitysetting');
		$securitysetting = $this->Securitysetting->find('first');
		$password_strength = $this->User->doesItFullfillPasswordStrength($this->request->data['User']['passwd'], $securitysetting['Securitysetting']);
		$password_used = $this->User->PasswordHistory->isThePasswordUsedBefore($this->Auth->user('id'), $this->request->data['User']['passwd']);
		if (!empty ($this->request->data['User']['password2']) && !empty ($this->request->data['User']['passwd'])) {
		$passwd = $this->request->data['User']['passwd'];
		$passwd2 = $this->request->data['User']['password2'];
		if(strcmp($passwd, $passwd2) != 0)	{
		$this->request->data=null;

		$this->Session->setFlash('<span></span>'.__('Password change is failed.
		You entered two different passwords,
		please try again.', true), 'default', array ('class' => 'error-box error-message'));

	
		} else {
		$this->request->data['User']['id']=$this->Auth->user('id');
		$this->request->data['User']['oldpassword'] = 
		$this->Auth->password($this->request->data['User']['oldpassword']);
		//debug($this->request->data);

		if($this->User->veryifyOldPassword($this->request->data)){
		$this->request->data['User']['role_id']=$this->role_id;
		// Limit to 10 failed attempts
		if (strlen($this->request->data['User']['passwd'])>=$securitysetting['Securitysetting']['minimum_password_length'] && strlen($this->request->data['User']['passwd'])<=$securitysetting['Securitysetting']['maximum_password_length']) {
		if($password_strength) {
		if($securitysetting['Securitysetting']['previous_password_use_allowance'] == 1 || 
	!$password_used) {
		$user = $this->User->find('first',							array(
										'conditions' =>									array(										'User.id' => $this->Auth->user('id')
										)
									)
								);
								$passwordHistory['user_id'] = $this->Auth->user('id');
								$passwordHistory['password'] = $user['User']['password'];
								$this->User->PasswordHistory->save($passwordHistory);
		$this->request->data['User']['force_password_change'] = 0;
		$this->request->data['User']['last_password_change_date'] = date('Y-m-d H:i:s');
		if ($this->User->save($this->request->data)) {
		 $this->Session->setFlash('<span></span>'.__('The password was changed successfully'),
		 'default',array('class'=>'success-box success-message'));
		 $this->redirect('/');
		} else {
		 $this->Session->setFlash('<span></span>'.__('The User could not be saved. ' .
		 'Please, try again.', true),
		 'default',array('class'=>'error-box error-message'));
		}
		}
		else {
			$this->Session->setFlash('<span></span>'.__('You already use the password that you entered as a new password before. Please use a password that you never used before.'), 'default', array('class' => 'error-box error-message'));
		}
		}
		else {
		$this->Session->setFlash('<span></span>'.__('Your password does not fulfill the required strength which is mentioned below'), 'default', array('class' => 'error-box error-message'));
		}
		} else {
			$this->Session->setFlash('<span></span>'.__('Password policy: Your password should be greater than or equal to '.$securitysetting['Securitysetting']['minimum_password_length'].' and less than or equal to '.$securitysetting['Securitysetting']['maximum_password_length'].''), 'default', array('class' => 'error-box error-message'));
		}
		} else {
		$error=$this->User->invalidFields();
		if(isset($error['invaliduser'])){
		$this->Session->setFlash('<span></span>'.__($error['invaliduser'][0]),
		'default',array('class'=>'error-box error-message'));       
		}
		}
		}
		} else {
		$this->Session->setFlash('<span></span>'.__('Please give your password.'),'default',array('class'=>'error-box error-message'));

		}

		}
		$securitysetting = ClassRegistry::init('Securitysetting')->find('first');
		$this->set(compact('securitysetting'));	
	}

    
	/**
	* Reset main account user password and others account,
	* reseting of main account user account requires votting
	*/
	
	public function resetpassword($id=null) {
	
	    $check_existed_user_ids=$this->User->find('count',array('conditions'=>array('User.id'=>$id)));
	    
	    if ($check_existed_user_ids == 0) {
	        $this->Session->setFlash('<span></span>'.__('Password reset is failed. The selected user does not exist.'), 'default', array ('class' => 'error-box error-message'));
                 $this->redirect(array('action'=>'index'));
	    
	    }
	    
	    $check_only_active_account=$this->User->find('count',array('conditions'=>array('User.id'=>$id,
	            'User.active'=>0)));
	    if ($check_only_active_account>0) {
	       	$this->Session->setFlash('<span></span>'.__('Password reset is failed. The account is deactive please activate the account before resetting password.'), 'default', 
array ('class' => 'error-box error-message'));	
		$this->redirect(array('action'=>'index'));
	    
	    }
	    
	    if ($this->role_id == ROLE_COLLEGE ) {
	          if (!$this->User->checkUserIsBelongsInYourAdmin($id,$this->role_id,null,
	          $this->college_id)){
	             $this->Session->setFlash('<span></span>'.__('Password reset is failed.
				         You are not elegible to reset the password. The user belongs to other administrator.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                 $this->redirect(array('action'=>'index'));
	          }
	          
	    } else if ($this->role_id == ROLE_DEPARTMENT) {
	             if (!$this->User->checkUserIsBelongsInYourAdmin($id,$this->role_id,$this->department_id,null)){
	                $this->Session->setFlash('<span></span>'.__('Password reset is failed.
				         You are not elegible to reset the password. The user belongs to other administrator.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                
                 $this->redirect(array('action'=>'index'));
	            }
	           
	            
	    } else {
	            if (!$this->User->checkUserIsBelongsInYourAdmin($id,$this->role_id)){
	               $this->Session->setFlash('<span></span>'.__('Password reset is failed.
				         You are not elegible to reset the password. The user belongs to other administrator.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                 
                 $this->redirect(array('action'=>'index'));
	          }
	    }
	    
	    $breaker_detail = ClassRegistry::init('User')->find('first',
                      			array(
                      				'conditions' =>
                      				array(
                      					'User.id' =>$this->Auth->user('id')
                      				),
                      				'contain' => 
                      				array(
                      					'Staff',
                      					'Student'
                      				)
                      			)
            );
            $details=null;
	    if (isset ($breaker_detail['Staff']) && !empty($breaker_detail['Staff'])) {
						  $details.=$breaker_detail['Staff'][0]['first_name'].' '.$breaker_detail['Staff'][0]['middle_name'].' '.$breaker_detail['Staff'][0]['last_name'].' ('.$breaker_detail['User']['username'].')';
	   } else if (isset ($breaker_detail['Student']) && !empty($breaker_detail['Student'])) {
						$details.=$breaker_detail['Student'][0]['first_name'].' '.$breaker_detail['Student'][0]['middle_name'].' '.$breaker_detail['Student'][0]['last_name'].' ('.$breaker_detail['User']['username'].')';
						
	    }
	    $check_instructor_account=$this->User->find('count',array('conditions'=>array('User.id'=>$id,
	            'User.role_id'=>ROLE_INSTRUCTOR)));
	    if ($check_instructor_account>0) {
	                   
			$this->Session->setFlash('<span></span>'.__('You are trying to break system security. Your action is logged and reported to the system administrators. Do not try this action again otherwise your account will be closed.'), 'default',array('class'=>'error-box error-message'));
				       
			ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$details.'</u> is trying to reset  password of an instructor. Please give appropriate warning.');
                      		
                       $this->redirect(array('action'=>'index'));
	    
	    }
	    
	     $is_account_admin=$this->User->find('count',
                         array('conditions'=>array('User.id'=>$this->Auth->user('id'),'User.role_id'=>$this->role_id,
                         'User.is_admin'=>1)));
                         
              $is_account_urs=$this->User->find('count',
                         array('conditions'=>array('User.id'=>$this->Auth->user('id'),'User.role_id'=>$this->role_id)));
            // if admin or ur account allow  else deny
	     if ($is_account_admin!=1 && $this->Auth->user('id')!=$id ) {
	                $this->Session->setFlash('<span></span>'.__('You are trying to break system security. Your action is logged and reported to the system administrators. Do not try this action again otherwise your account will be closed.'), 'default',array('class'=>'error-box error-message'));
				       
			ClassRegistry::init('AutoMessage')->sendPermissionManagementBreakAttempt(Configure::read('User.user'), '<u>'.$details.'</u> is trying to reset password of other user. Please give appropriate warning.');
                         $this->redirect(array('controller'=>'dashboard','action'=>'index'));
                        //$this->redirect(array('action'=>'view',$id));  
	      }

	    
	    if(!empty($this->request->data)) {
		        if (empty ($this->request->data['User']['id'])) {
                    $this->Session->setFlash(__('User not specified'));
                    $this->redirect(array (
                        'action' => 'index'
                    ));
                  }
           
                if (!empty ($this->request->data['User']['password2']) && !empty ($this->request->data['User']['passwd'])) {
                     $passwd = $this->request->data['User']['passwd'];
                     $passwd2 = $this->request->data['User']['password2'];
			        if(strcmp($passwd, $passwd2) != 0)	{
				        $this->request->data=null;
				   
				         $this->Session->setFlash(__('Password change is failed.
				         You entered two different passwords,
                        please try again.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                       
				    			
			         } else {
			           
                        // check password length
                           $this->loadModel('Securitysetting');
                           
                           $securitysetting=$this->Securitysetting->find('first');
                           if (strlen($this->request->data['User']['passwd'])>=$securitysetting['Securitysetting']['minimum_password_length'] && strlen($this->request->data['User']['passwd'])<=$securitysetting['Securitysetting']['maximum_password_length']) {
								$userH = $this->User->find('first',
									array(
										'conditions' =>
										array(
											'User.id' => $this->request->data['User']['id']
										)
									)
								);
								$passwordHistory['user_id'] = $this->request->data['User']['id'];
								$passwordHistory['password'] = $userH['User']['password'];
								$this->User->PasswordHistory->save($passwordHistory);
                        $this->request->data['User']['force_password_change'] = 2;
                        $this->request->data['User']['last_password_change_date'] = date('Y-m-d H:i:s');
                        if ($this->User->save($this->request->data)) {
                            $this->Session->setFlash('<span></span>'.__('The password was changed successfully'),
                            'default',array('class'=>'success-box success-message'));
                            $this->redirect(array('action'=>'index'));
                        } else {
                            $this->Session->setFlash('<span></span>'.__('The User could not be saved. ' .
                            'Please, try again.', true),'default',array('class'=>'error-box error-message'));
                        }
				      } else {
				         $this->Session->setFlash('<span></span>'.__('Password policy: Your password should be greather than or equal to '.$securitysetting['Securitysetting']['minimum_password_length'].' and less than or equal to '.$securitysetting['Securitysetting']['maximum_password_length'].''), 'default', array('class' => 'error-box error-message'));
				      }
				      
			        }
			   } else {
			     $this->Session->setFlash('<span></span>'.__('Password change is failed. You have not provided password.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                       
			   
			   }
			
			 $this->request->data = $this->User->read(null, $id);	
		}
		if(empty($this->request->data)){
		   	
		    $this->request->data = $this->User->read(null, $id);	
	    }
	}
	
	function editprofile($id=null){
	
	    if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('<span></span>Invalid user!'),
			'default', array('class' => 'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		 if($id !== $this->Auth->user('id')){
                 //throw new NotFoundException(); // or redirect to a view saying that he doesn't have
                $this->redirect(array('action' => 'index'));
        }
		if (!empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('<span></span>The user has been saved'),
				'default', array('class' => 'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('<span></span>The user could not be saved. Please, try again.'),
				'default', array('class' => 'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
		}
		$roles = $this->User->Role->find('list');
		//$students = $this->User->Student->find('list');
		$staffs = $this->User->Staff->find('list');
		$addresses=$this->User->Address->find('list');
		$this->set(compact('roles', 'students', 'staffs','addresses'));
	
	}
	
    public function forget(){
	     $this->layout='login';
	     if(!empty($this->request->data)) {
		 $this->User->set($this->request->data); 
		 if($this->User->validates())
                 {
		     if (empty($this->request->data['User']['email'])){
		       $this->Session->setFlash(__('<span></span>Please enter email address.'),'default', array('class' => 'error-box error-message')); 
		     } else {
		         if ($this->MathCaptcha->validates($this->request->data['User']['security_code']))
			 {	//email entered, check for it
				$account=$this->User->findByEmail($this->request->data['User']['email']);

				if(!isset($account['User']['email'])){
					$this->Session->setFlash('<span></span>Sorry the system couldn\'t find your email address.','default', array('class' => 'error-box error-message'));
					 return $this->redirect('/'); 
				} else if(!$account['User']['active']){
					//banned user, tell em where to go
					$this->Session->setFlash('<span></span>This account is deactivated. Please contact your main account administrator or your system administrator to access your account.','default', array('class' => 'error-box error-message'));
					return $this->redirect('/');
				}
				$hashyToken=md5(date('mdY').rand(4000000,4999999));
				$message = $this->Ticketmaster->createMessage($hashyToken);
				
			$Email = new CakeEmail('default');
            $Email->template('password_reset');
			$Email->emailFormat('html');
			$Email->from(array('wondetask@gmail.com'=>'SMIS'));
			$Email->to($this->request->data['User']['email']);
			$Email->subject('Password Reset SMIS'); 
            $Email->viewVars(array('message'=>$message));
			    if($Email->send()) {
                  	    $this->set('sent',__('Check your email. The password reset email has been sent 
                           successfully to '.$this->request->data['User']['email'],true));   
		        } else {
		          $this->Session->setFlash('<span></span>'.
__('Email not sent.Check your email server is up and running',true),'default',array('class'=>'error-box error-message'));	          
		        }
				//$this->Email->useremail($email,$account['User']['username'],$message);
				$data['Ticket']['hash']=$hashyToken;
				$data['Ticket']['data']=$this->request->data['User']['email'];
				$data['Ticket']['expires']=$this->Ticketmaster->getExpirationDate();
				$this->loadModel('Ticket');
				if ($this->Ticket->save($data)){
				     $this->Session->setFlash('<span></span>An email has been sent with instructions to reset your password.','default', array('class' => 'success-message success-box'));
				    return $this->redirect('/');
				}else{
				    $this->Session->setFlash('<span></span> Ticket could not be issued','default', array('class' => 'error-box error-message'));
				   return $this->redirect('/');
				}
		   	} else {
				$this->Session->setFlash(__('<span></span>Please enter the correct answer to the math question.'),'default', array('class' => 'error-box error-message')); 
			}
		      }
		   }
		}
		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation()); 
	}
	function useticket($hash){
		//purge all expired tickets
		//built into check
		$this->layout='forget';
		$this->loadModel('Ticket');
		$results=$this->Ticketmaster->checkTicket($hash);
		
		if($results){
			//now pull up mine IF still present
			
			$passTicket=$this->User->findByEmail($results['Ticket']['data']);
        
			$this->Ticketmaster->voidTicket($hash);
			$this->Session->write('tokenreset',$passTicket['User']['id']);
			$this->Session->setFlash('<span></span>Enter your new password below.',
			'default', array('class' => 'info-box info-message'));
			return $this->redirect('/users/newpassword/'.$passTicket['User']['id']);
		} else{
			$this->Session->setFlash('<span></span>Your ticket is lost or expired.',
			'default', array('class' => 'error-box error-message'));
			return $this->redirect('/');
		}
               
 
	}
  
 	public function newpassword($id = null) 
	{
       		$this->layout='forget';
		if($this->Session->check('tokenreset')){
			//user is not logged in, BUT has TOKEN in hand
			
		}else{
		
			//But youll need to read the user info somehow, and only the user who owns the profile 
			$attempter=$this->Session->read('Auth.User');
 
			//make sure its the admin or the rigth user
			if($attempter['User']['id']!=$id && $attempter['User']['role_id']=!ROLE_SYSADMIN)
			{
				//not  the user, not the admin and not a reset request via toekns
				/*
				 * SHAME
				 */
				//$this->Userban->banuser('Edit Anothers Password');
				//$this->saveFiled();
				$this->Session->setFlash('<span></span>Your account has been banned.',
				'default', array('class' => 'error-box error-message'));
				return $this->redirect('/');
			}
 
		}	
 
		if (empty($this->request->data)) {
			if($this->Session->check('tokenreset')) $id=$this->Session->read('tokenreset');
			if (!$id) {
				$this->Session->setFlash('<span></span>Invalid id for User.',
				'default', array('class' => 'error-box error-message'));
				return $this->redirect('/');
			}
			$this->request->data = $this->User->read(null, $id);
			
		} else {				
            //debug($this->request->data);
			if(!empty($this->request->data)){
			  $this->set($this->request->data);
			  if($this->User->validates()){
			   if (!empty ($this->request->data['User']['confirmpassword']) && !empty ($this->request->data['User']['passwd'])) {
                     $passwd = $this->request->data['User']['passwd'];
                     $passwd2 = $this->request->data['User']['confirmpassword']; 
                      if(strcmp($passwd, $passwd2) != 0)	{
				        //$this->request->data=null;
				   
				         $this->Session->setFlash('<span></span>'.__('Password change is failed.
				         You entered two different passwords,
                        please try again.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
                       $this->redirect(array('action'=>'newpassword',$id));
				    			
			         } else {
			    // validate against password policy 
			      // Limit to 10 failed attempts
                    $this->loadModel('Securitysetting');
                    $securitysetting=$this->Securitysetting->find('first');
                    if (strlen($this->request->data['User']['passwd'])>=$securitysetting['Securitysetting']['minimum_password_length'] && strlen($this->request->data['User']['passwd'])<=$securitysetting['Securitysetting']['maximum_password_length']) { 
			        if ($this->User->save($this->request->data)) {
				        //delete session token and dlete used ticket from table
				        $this->Session->delete('tokenreset');
				        $this->Session->setFlash('<span></span>The User\'s Password has been updated',
				        'default', array('class' => 'success-box success-message'));
				        $this->redirect('/');
			        } else {
				        $this->Session->setFlash('<span></span>Please correct errors below.',
				        'default', array('class' => 'error-box error-message'));
			        }
			      } else {
			         $this->Session->setFlash('<span></span>'.__('Password policy: Your password should be greather than or equal to '.$securitysetting['Securitysetting']['minimum_password_length'].' and less than or equal to '.$securitysetting['Securitysetting']['maximum_password_length'].''), 'default', array('class' => 'error-box error-message'));
			       
			      }
			     }
			  } else {
			    $this->Session->setFlash(__('<span></span>Please provide password. Please, try again.'), 'default', array('class' => 'error-box error-message'));
			  }
			} else {
			   $this->Session->setFlash(__('<span></span>The password could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
			}
		}
		
	 }

    }
    
    function assign($id=null) {
	if(!empty($this->request->data) 
		&& isset($this->request->data)) 
	{
        	if(!empty($this->request->data['StaffAssigne']['program_id'])){
				$this->request->data['StaffAssigne']['program_id']=serialize($this->request->data['StaffAssigne']['program_id']);
			}
			if(!empty($this->request->data['StaffAssigne']['program_type_id'])){
				$this->request->data['StaffAssigne']['program_type_id']=serialize($this->request->data['StaffAssigne']['program_type_id']);
				debug($this->request->data['StaffAssigne']);
			}
		    if(!empty($this->request->data['StaffAssigne']['departmentlevel'])) {
			$this->set('departmentlevel',true);
			$this->request->data['StaffAssigne']['department_id']=serialize($this->request->data['StaffAssigne']['department_id']);
			$this->request->data['StaffAssigne']['college_id']=null;
			$this->request->data['StaffAssigne']['collegepermission']=0;

		    } else if (!empty($this->request->data['StaffAssigne']['collegelevel'])) {
			$this->set('collegelevel',true);
			$this->request->data['StaffAssigne']['college_id']=serialize($this->request->data['StaffAssigne']['college_id']);
			$this->request->data['StaffAssigne']['collegepermission']=1;
			$this->request->data['StaffAssigne']['department_id']=null;
			}

	  $this->request->data['StaffAssigne']['user_id']=$this->request->data['User']['id'];
       if($this->User->StaffAssigne->save($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('
			Responsibility has been assigned.If you assigned to yourself, then
			you need to logout to make the change effective.', true),
			'default', array('class' => 'success-box success-message'));
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash('<span></span>'.__('The user could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
			if (!empty($this->request->data['StaffAssigne']['departmentlevel'])) {
			$this->set('departmentlevel',true);
				if(!empty($this->request->data['StaffAssigne']['department_id'])) {
			$this->request->data['StaffAssigne']['department_id']=unserialize($this->request->data['StaffAssigne']['department_id']);
				}
			} else if (!empty($this->request->data['StaffAssigne']['collegelevel'])) {
		$this->set('collegelevel',true);
		$this->request->data['StaffAssigne']['college_id']=unserialize($this->request->data['StaffAssigne']['college_id']);
			}
		}

	}

	if (empty($this->request->data)) {

	  $this->request->data = $this->User->find('first',array('conditions'=>array('User.id'=>$id),
	'contain'=>array('Role','StaffAssigne','Staff')));
	  debug($this->request->data);
		if($this->request->data['StaffAssigne']) {
			if (!empty($this->request->data['StaffAssigne']['collegepermission'])) {
					$this->request->data['StaffAssigne']['college_id']=unserialize($this->request->data['StaffAssigne']['college_id']);
					$this->set('collegelevel',true);
			} else {
				$this->request->data['StaffAssigne']['department_id']=unserialize($this->request->data['StaffAssigne']['department_id']);    
				if (!empty( $this->request->data['StaffAssigne']['department_id'])) {
					$this->set('departmentlevel',true);
				}
			}
			if(!empty($this->request->data['StaffAssigne']['program_id'])){
				$this->request->data['StaffAssigne']['program_id']=unserialize($this->request->data['StaffAssigne']['program_id']);
			}
			if(!empty($this->request->data['StaffAssigne']['program_type_id'])){
				$this->request->data['StaffAssigne']['program_type_id']=unserialize($this->request->data['StaffAssigne']['program_type_id']);
			}
		}
	}

	$colleges = $this->User->Staff->College->find('list');
	$college_department=array();
	foreach($colleges as $college_id => $college_name) {

	$departments = $this->User->Staff->Department->find('list', 
	array('fields' => array('id', 'name'), 
	'conditions' => array('Department.college_id' => $college_id), 'order' => 'Department.name'));
	// debug($departments);
	foreach($departments as $department_id => $departmentname) {
	$college_department[$college_id][$department_id] =  $departmentname;
	}

	}
	$basic_data=$this->User->find('first',array('conditions'=>array('User.id'=>$id),
	'contain'=>array('Role','StaffAssigne','Staff')));	
	$programs=ClassRegistry::init('Program')->find('list');
	$programTypes=ClassRegistry::init('ProgramType')->find('list');
	$this->set(compact('colleges','college_department','programs','basic_data','id','programTypes'));
    }
  
    
    function assign_user_meal_hall ($id=null,$unassign=null) {
    
        if($unassign){
             $this->__unassign_user_meal_hall($unassign,$id);
        }
        
        if (!empty($this->request->data)) {
                
                if (count($this->request->data['User']['meal_hall_id'])>0) {
                        $data=$this->__reformatedDataForMealRespAssignment($this->request->data);
                        
                        if ($this->User->UserMealAssignment->checkDuplicationAssignment($data) ) {
                            if ($this->User->UserMealAssignment->saveAll($data['UserMealAssignment'],array('validate'=>'first'))) {
                            $this->Session->setFlash('<span></span>'.
                            __('Responsibility has been assigned .'),'default', 
                            array('class' => 'success-box success-message'));
                              $this->redirect(array('action'=>'index'));
                            } else {
                            
                            }    
                        } else {
                            $error=$this->User->UserMealAssignment->invalidFields();
                            $string='';
                            foreach ($error['error'] as $kk => $kv) {
                            	$string.=''.$kv;
                            }
			                if (isset($error['error'])) {
			                    $this->Session->setFlash('<span></span>'.__($string),'default',array('class'=>'error-box error-message'));
			                }
			                
                        }
                        
                } else {
                    $this->Session->setFlash(__('<span></span>The assignment could not be saved.Check atleast one meal hall  for assignment .'), 'default', array('class' => 'error-box error-message'));
                }
                
           
        }
        
        if ($id) {
              
            $staff_basic_data=$this->User->find('first',array('conditions'=>array('User.id'=>$id),
               'contain'=>array('Role','UserMealAssignment','Staff'=>array('Position','Title'))));
              $alreadyAssignedMealHalls=$this->User->UserMealAssignment->mealHallAssignmentOrganizedByCampus($id);
        } else if (!empty($this->request->data['User']['id'])) {
          
            $staff_basic_data=$this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['User']['id']),
           'contain'=>array('Role','UserMealAssignment','Staff'=>array('Position','Title'))));
           
           $alreadyAssignedMealHalls=$this->User->UserMealAssignment->mealHallAssignmentOrganizedByCampus($id);
        
        }
       
        $mealHalls = $this->User->UserMealAssignment->MealHall->getMealHall();
       
		$this->set(compact('mealHalls'));
        $this->set(compact('staff_basic_data','alreadyAssignedMealHalls'));
    }
    
    
    function __reformatedDataForDormRespAssignment ($data=null) {
            $user_assignment=array();
            $count=0;
            foreach ($data['User']['dormitory_block_id'] as $i=>$v) {
                $user_assignment['UserDormAssignment'][$count]['user_id']=$data['User']['id'];
                $user_assignment['UserDormAssignment'][$count]['dormitory_block_id']=$v;
                $count++;
            }
            return $user_assignment;
    }
    
    function __reformatedDataForMealRespAssignment ($data=null) {
            $user_assignment=array();
            $count=0;
            foreach ($data['User']['meal_hall_id'] as $i=>$v) {
                $user_assignment['UserMealAssignment'][$count]['user_id']=$data['User']['id'];
                $user_assignment['UserMealAssignment'][$count]['meal_hall_id']=$v;
                $count++;
            }
            return $user_assignment;
    
    }
    
    function __unassign_user_dorm_block ($assignment_id=null, $user_id=null) {
         if ($this->User->UserDormAssignment->delete($assignment_id)) {
			$this->Session->setFlash('<span></span>'.__('User dorm block assignment responsibility deleted successfully'),'default',array('class'=>'success-box success-message'));
			 $this->redirect(array('action' => 'assign_user_dorm_block',$user_id));
		 } else {
		    $this->Session->setFlash('<span></span>'.__('User dorm block assignment responsibility  was not deleted '),'default',array('class'=>'error-box error-message'));
		    $this->redirect(array('action' => 'assign_user_dorm_block',$user_id));
		 }
		 
    }
   
    function __unassign_user_meal_hall ($assignment_id=null, $user_id=null) {
         if ($this->User->UserMealAssignment->delete($assignment_id)) {
			$this->Session->setFlash('<span></span>'.__('User meal hall assignment responsibility deleted successfully'),'default',array('class'=>'success-box success-message'));
			 $this->redirect(array('action' => 'assign_user_meal_hall',$user_id));
		 } else {
		    $this->Session->setFlash('<span></span>'.__('User meal hall assignment responsibility  was not deleted '),'default',array('class'=>'error-box error-message'));
		    $this->redirect(array('action' => 'assign_user_meal_hall',$user_id));
		 }
		 
    }
   
    
    public function assign_user_dorm_block ($id=null,$unassign=null) {

        if($unassign){
          
            $this->__unassign_user_dorm_block($unassign,$id);
        }
        if (!empty($this->request->data)) {
                
                if (count($this->request->data['User']['dormitory_block_id'])>0) {
                        $data=$this->__reformatedDataForDormRespAssignment($this->request->data);
                        
                        if ($this->User->UserDormAssignment->checkDuplicationAssignment($data) ) {
                            if ($this->User->UserDormAssignment->saveAll($data['UserDormAssignment'],array('validate'=>'first'))) {
                            $this->Session->setFlash('<span></span>'.
                            __('Responsibility has been assigned .'),'default', 
                            array('class' => 'success-box success-message'));
                              $this->redirect(array('action'=>'index'));
                            } else {
                            
                            }    
                        } else {
                           
                            $error=$this->User->UserDormAssignment->invalidFields();
                            $string='';
                            foreach ($error['error'] as $kk => $kv) {
                            	$string.=''.$kv;
                            }

			                if (isset($error['error'])) {
			                    $this->Session->setFlash('<span></span>'.__($string),'default',array('class'=>'error-box error-message'));
			                }
			                
                        }
                        
                } else {
                    $this->Session->setFlash(__('<span></span>The assignment could not be saved.Check atleast one dorm block for assignment .'), 'default', array('class' => 'error-box error-message'));
                }
                
           
        }
        
        if ($id) {
          
        $staff_basic_data=$this->User->find('first',array('conditions'=>array('User.id'=>$id),
           'contain'=>array('Role','UserMealAssignment','Staff'=>array('Position','Title'))));
      
          $alreadyAssignedBlocks=$this->User->UserDormAssignment->dormitoryBlocksAssignmentOrganizedByCampus($id);
        } else if (!empty($this->request->data['User']['id'])) {
          
            $staff_basic_data=$this->User->find('first',array('conditions'=>array('User.id'=>$this->request->data['User']['id']),
           'contain'=>array('Role','UserMealAssignment','Staff'=>array('Position','Title'))));
           
           $alreadyAssignedBlocks=$this->User->UserDormAssignment->dormitoryBlocksAssignmentOrganizedByCampus($id);
        
        }
        
        $dormitoryBlocks = $this->User->UserDormAssignment->DormitoryBlock->getDormitoryBlock();
       
		$this->set(compact('dormitoryBlocks'));
        $this->set(compact('staff_basic_data','alreadyAssignedBlocks'));
    }
    
    
    
    
    /**
    *create account for staffs 
    */
    function department_create_user_account ($staff_id=null) {
    
          if (!empty($this->request->data) && isset($this->request->data['createAccount']))  {
    	      
              $staff_detail=$this->User->Staff->find('first',array('conditions'=>array('Staff.id'=>$this->request->data['Staff'][0]['id'])));
              $this->request->data['User']['first_name']=$staff_detail['Staff']['first_name'];
              $this->request->data['User']['last_name']=$staff_detail['Staff']['last_name'];
              $this->request->data['User']['middle_name']=$staff_detail['Staff']['middle_name'];
            if (!empty($staff_detail['Staff']['email'])) {
             $this->request->data['User']['email']=$staff_detail['Staff']['email'];

               $this->request->data['Staff'][0]['email']=$staff_detail['Staff']['email'];
            }
           
            if(empty($staff_detail['Staff']['gender'])){
               	  $this->request->data['Staff'][0]['gender']='male';
             } else {
             		  $this->request->data['Staff'][0]['gender']=$staff_detail['Staff']['gender'];
             }
            $password=$this->User->generatePassword(5);		
		    $this->request->data['User']['passwd']=$password;

		    debug($this->request->data);
             if ($this->User->saveAll($this->request->data, array('validate'=>'first'))) {
								
		   $staff_details= $this->User->find('first',array('conditions'=>array('User.id'=>$this->User->id),'contain'=>array('Staff'=>array('Department','College'=>array('Campus'),'Title'))));
		$university=ClassRegistry::init('University')->find('first',array('contain'=>array('Attachment'=>array('order'=>array('Attachment.created DESC'))),'order'=>array('University.created DESC')));
		  if(!empty($staff_details)&&!empty($university)){
			$this->set(compact('staff_details','university','password'));
		
			$this->response->type('application/pdf');
	 		$this->layout = '/pdf/default';
			$this->render('issue_password_staff_pdf');
		  } else {
			 $this->Session->setFlash(__('<span></span>The user has been saved.Username='.$staff_details['User']['username'].' and Password='.$staff_details['User']['password'].''),'default', array('class' => 'success-box success-message'));
			$this->redirect(array('action' => 'index'));	
		  }
		 } else {
				$this->Session->setFlash(__('<span></span>The user could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
		   $staff_id=$this->request->data['Staff'][0]['id'];
		  }
        } 
    	 
         if (!empty($staff_id)) {
                $is_staff_belongs_to_ur_dept=$this->User->Staff->find(
                'count',array(
                'conditions'=>array('Staff.id'=>$staff_id,
                'Staff.department_id'=>$this->department_id,
                'Staff.user_id not in (select id from users)',
                
                ))
                );
                if ($is_staff_belongs_to_ur_dept==0) {
                     $this->Session->setFlash('<span></span>'.__('You do not have privilage to create user account for the given ID.'), 'default',array('class'=>'info-box info-message'));
                } else {
                    $staff_account_valid=true;
                    $basic_data=$this->User->Staff->find('first',array('conditions'=>array('Staff.id'=>$staff_id),
           'contain'=>array('Position','Title')));
                    $staff_basic_data['Staff'][0]=$basic_data['Staff'];
                    $staff_basic_data['Staff'][0]['Position']=$basic_data['Position'];
                    $staff_basic_data['Staff'][0]['Title']=$basic_data['Title'];
                    $this->set(compact('staff_account_valid','staff_basic_data'));
                }
                
         }
         
	     if (!empty($this->request->data['Staff']['name']) && isset($this->request->data['search']))  {
	            
		         $staffs=$this->User->Staff->find('all',array(
        	  'conditions'=>array('Staff.department_id'=>$this->department_id,
        	  'Staff.user_id not in (select id from users)',
        	    "OR"=>array(
        	            'Staff.first_name like'=>$this->request->data['Staff']['name'].'%',
        	            'Staff.last_name like'=>$this->request->data['Staff']['name'].'%',
        	            'Staff.middle_name LIKE '=>$this->request->data['Staff']['name'].'%'
        	       ),
        	       'OR'=>array('Staff.user_id is null','Staff.user_id'=>array('')
        	     )
        	    )
        	   )
        	  );
        	   $staffs=$this->User->Staff->find('all',array(
        	  'conditions'=>array('Staff.department_id'=>$this->department_id,
        	  'Staff.user_id not in (select id from users)',
        	    "OR"=>array(
        	            'Staff.first_name like'=>$this->request->data['Staff']['name'].'%',
        	          
        	       ),
        	     ),
        	     'contain'=>array('College','Position','Department','Title')
        	    )
        	   );
    	      
		      if(isset($this->request->data) && !empty($this->request->data) && empty($staffs) && (!empty($this->request->data['Staff']['name']))) {
		           $this->Session->setFlash('<span></span>'.__('Based on your search, there is no staff in the system who does not have an account for system access.'), 'default',array('class'=>'info-box info-message'));
		       }
		      
		   
    	  } else {
    	       $staffs=$this->User->Staff->find('all',array(
        	  'conditions'=>array(
        	        'Staff.department_id'=>$this->department_id,
        	        'Staff.user_id not in (select id from users)',
        	        'OR'=>array('Staff.user_id is null','Staff.user_id'=>array('')
        	    )),
        	    'contain'=>array('College','Position','Department','Title')));  
    	  }
    	 
    	
		   if( empty($staffs)) {
		           $this->Session->setFlash('<span></span>'.__('There is no staff in the system who does not have an account for system access.'), 'default',array('class'=>'info-box info-message'));
		   }
		   
		  $conditions=array(
	                    'Role.id'=>array(ROLE_DEPARTMENT,ROLE_INSTRUCTOR));
		   $roles = $this->User->Role->find('list',array('conditions'=>$conditions));
		   $this->set(compact('staffs','roles'));
     }
   
    function get_department($college_id=null) {
        $this->layout = 'ajax';
        $departments=$this->User->Staff->Department->find('list',
		array('conditions'=>array('Department.college_id'=>$college_id)));
	   
		$this->set(compact('departments','college_id'));
      
    }
    
     function reset_password($role_id = null) 
     {
	if(!empty($this->request->data)) {
	 $role_id = $this->request->data['User']['role_id'];
         if (empty ($this->request->data['User']['user_id'])) {
	  $this->request->data['User']['passwd']=null;
          $this->request->data['User']['password2']=null;
          $this->Session->setFlash('<span></span>'.__('Please select the user for whom you want to reset his/her password.'), 'default', array ('class' => 'error-box error-message'));
          } else if (!empty ($this->request->data['User']['password2']) && !empty ($this->request->data['User']['passwd'])){
             $passwd = $this->request->data['User']['passwd'];
             $passwd2 = $this->request->data['User']['password2'];
	     if(strcmp($passwd, $passwd2) != 0){
	     $this->request->data['User']['passwd']=null;    
             $this->request->data['User']['password2']=null;
	     $this->Session->setFlash('<span></span>'.__('Password change is failed.You entered two different passwords,please try again.', true), 'default', array (
                            'class' => 'error-box error-message'));
	    } else {
             // $this->loadModel('Securitysetting');
             $securitysetting=ClassRegistry::init('Securitysetting')->find('first');
             if (strlen($this->request->data['User']['passwd'])>=$securitysetting['Securitysetting']['minimum_password_length'] && strlen($this->request->data['User']['passwd'])<=$securitysetting['Securitysetting']['maximum_password_length']) {
								 		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
								 		$alread_requested = ClassRegistry::init('Vote')->find('count',
								 			array(
								 				'conditions' =>
								 				array(
								 					'Vote.task' => 'Password Reset',
								 					'Vote.confirmation' => 0,
								 					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
								 					'Vote.created >= ' => $valid_date_from
								 				)
								 			)
								 		);
								 		if($alread_requested > 0) {
										   $this->request->data['User']['passwd']=null;
										   $this->request->data['User']['password2']=null;
								 			$this->Session->setFlash('<span></span>'.__('There is already password reset request for the selected user. The request has to be either canceled or expired in-order to place password reset request again.'),'default',array('class'=>'error-box error-message'));
								 		}
								 		else {
		                        	$vote = array();
		                        	$vote['task'] = 'Password Reset';
		                        	$vote['requester_user_id'] = $this->Auth->user('id');
		                        	$vote['applicable_on_user_id'] = $this->request->data['User']['user_id'];
		                        	$vote['data'] = Security::hash($this->request->data['User']['passwd'], null, true);
						            if (ClassRegistry::init('Vote')->save($vote)) {
												  $this->request->data['User']['passwd']=null;
												  $this->request->data['User']['password2']=null;
						                   $this->Session->setFlash('<span></span>'.__('Password reset request is sent to other system administrators and it will be effective up on confirmation. You will be informed when your request is confirmed and applied.'), 'default',array('class'=>'success-box success-message'));
						                   $this->redirect(array('action'=>'task_confirmation'));
						               } else {
						                   $this->Session->setFlash('<span></span>'.__('Password reset request is failed. Please, try again.'),'default',array('class'=>'error-box error-message'));
						               }
                        }
				      } else {
						  $this->request->data['User']['passwd']=null;
						  $this->request->data['User']['password2']=null;
				         $this->Session->setFlash('<span></span>'.__('Password policy: Your password should be greater than or equal to '.$securitysetting['Securitysetting']['minimum_password_length'].' and less than or equal to '.$securitysetting['Securitysetting']['maximum_password_length'].''), 'default', array('class' => 'error-box error-message'));
				      }
				      
			        }
	} else {
	$this->request->data['User']['passwd']=null;
	$this->request->data['User']['password2']=null;
        $this->Session->setFlash('<span></span>'.__('Password change is failed.You have not provided the password with its confirmation.', true), 'default', array (
                            'class' => 'error-box error-message'
                        ));
        }
     }
		//End of isset($this->request->data)
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id NOT ' => array(ROLE_STUDENT, ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)
				)
			)
		);
		$roles = array(0 => '--- Select Role ---') + $roles;
		$role_ids = array_keys($roles);
        $users = array();
        if($role_id && in_array($role_id, $role_ids)) {
        	$options =
        		array(
        			'conditions' =>
        			array(
        				'User.role_id' => $role_id,
        				'Staff.active' => 1,
        				'User.active' => 1,
        			),
        			'fields' =>
        			array(
        				'Staff.full_name',
        				'Staff.college_id',
        				'Staff.department_id',
        				'User.username',
        				'User.id'
        			),
        			'contain' => 
        			array(
        				'User',
					'Department'=>array('id','name'),
					'College'=>array('id','name')
        			)
        		);
        	if($role_id == ROLE_INSTRUCTOR || $role_id == ROLE_SYSADMIN || $role_id == ROLE_GENERAL ||  $role_id == ROLE_CLEARANCE) {
        $options['conditions']['User.role_id'] = $role_id;
        	}
        	else {
        		$options['conditions']['User.is_admin'] = 1;
        		$options['conditions']['User.role_id'] = $role_id;
        	}
        	$users = ClassRegistry::init('Staff')->find('all', $options);

		debug($users);
        	$users_f = array();
        	if($role_id == ROLE_COLLEGE) {
	/*        	
	$colleges = ClassRegistry::init('College')->find('list');
        		$college_ids = array_keys($colleges);
	*/
                   foreach($users as $user) {
		   $collegeName=ClassRegistry::init('College')->field('College.name',array('College.id'=>$user['Staff']['college_id']));	
        			if(!isset($users_f[$collegeName])) {
        				$users_f[$collegeName] = array();
        			}
        			$users_f[$collegeName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        	 }
        		$users = $users_f;
        	}
        	else if($role_id == ROLE_INSTRUCTOR || $role_id == ROLE_DEPARTMENT) {
        		//$departments = ClassRegistry::init('Department')->find('list');
        		//$department_ids = array_keys($departments);
        	foreach($users as $user) {
        	 $departmentName=ClassRegistry::init('Department')->field('Department.name',array('Department.id'=>$user['Staff']['department_id']));	
		   if(!isset($users_f[$departmentName])) {
        	      $users_f[$departmentName] = array();
        	   }	    
		  $users_f[$departmentName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')  '.$user['College']['name'].' '.$user['Department']['name'].'';
        	 }
        	 $users = $users_f;
        	}
        	else {
        		foreach($users as $user) {
        			$users_f[$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')  '.$user['College']['name'].' '.$user['Department']['name'].'';
        		}
        		$users = $users_f;
        	}
        	if(!empty($users))
        		$users = array(0 => '--- Select user ---') + $users;
        	else
        		$users = array(0 => '--- There is no user to display ---') + $users;
        }
        else {
        	$users = array(0 => '--- Select Role First ---') + $users;
        }
        $this->set(compact('roles', 'users', 'role_id'));


	}
	
	function cancel_main_account_administrator($role_id = null) {
		if(!empty($this->request->data)) {
			 $role_id = $this->request->data['User']['role_id'];
		    if (empty ($this->request->data['User']['user_id'])) {
               $this->Session->setFlash('<span></span>'.__('Please select the user from whom you want to cancel the main account administration privilage.'), 'default', array ('class' => 'error-box error-message'));
          }
          else {
          		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
          		$alread_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Administrator Cancellation',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		if($alread_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already "Administrator Cancellation" request for the selected user. The request has to be either canceled or expired in-order to place administrator cancellation request again.'),'default',array('class'=>'error-box error-message'));
          		}
          		else {
				   	$vote = array();
				   	$vote['task'] = 'Administrator Cancellation';
				   	$vote['requester_user_id'] = $this->Auth->user('id');
				   	$vote['applicable_on_user_id'] = $this->request->data['User']['user_id'];
						if (ClassRegistry::init('Vote')->save($vote)) {
						    $this->Session->setFlash('<span></span>'.__('Main account administrator cancellation request is sent to other system administrators and it will be effective up on confirmation. You will be informed when your request is confirmed and applied.'), 'default',array('class'=>'success-box success-message'));
						    $this->redirect(array('action'=>'task_confirmation'));
						} else {
						    $this->Session->setFlash('<span></span>'.__('Main account administrator cancellation request is failed. Please, try again.'),'default',array('class'=>'error-box error-message'));
						} 
				   }
			   }
			}
		//End of isset($this->request->data)
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id NOT ' => array(ROLE_STUDENT, ROLE_SYSADMIN, ROLE_INSTRUCTOR, ROLE_GENERAL, ROLE_CLEARANCE, ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)
				)
			)
		);
		$roles = array(0 => '--- Select Role ---') + $roles;
		$role_ids = array_keys($roles);
        $users = array();
        if($role_id && in_array($role_id, $role_ids)) {
        	$options =
        		array(
        			'conditions' =>
        			array(
        				'User.role_id' => $role_id,
        				'User.is_admin' => 1,
        			),
        			'fields' =>
        			array(
        				'Staff.full_name',
        				'Staff.college_id',
        				'Staff.department_id',
        				'User.username',
        				'User.id'
        			),
        			'contain' => 
        			array(
        				'User'
        			)
        		);
        	$users = ClassRegistry::init('Staff')->find('all', $options);
        	$users_f = array();
        	if($role_id == ROLE_COLLEGE) {
        		$colleges = ClassRegistry::init('College')->find('list');
        		$college_ids = array_keys($colleges);
        		foreach($users as $user) {
        			if(!isset($users_f[$colleges[$user['Staff']['college_id']]])) {
        				$users_f[$colleges[$user['Staff']['college_id']]] = array();
        			}
        			$users_f[$colleges[$user['Staff']['college_id']]][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else if($role_id == ROLE_DEPARTMENT) {
        		$departments = ClassRegistry::init('Department')->find('list');
        		$department_ids = array_keys($departments);
        		foreach($users as $user) {
        			if(!isset($users_f[$departments[$user['Staff']['department_id']]])) {
        				$users_f[$departments[$user['Staff']['department_id']]] = array();
        			}
        			$users_f[$departments[$user['Staff']['department_id']]][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else {
        		foreach($users as $user) {
        			$users_f[$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	if(!empty($users))
        		$users = array(0 => '--- Select user ---') + $users;
        	else
        		$users = array(0 => '--- There is no administrator to display ---') + $users;
        }
        else {
        	$users = array(0 => '--- Select Role First ---') + $users;
        }
        $this->set(compact('roles', 'users', 'role_id'));
	}
	
	function task_confirmation() {
		$tasks_for_confirmation = ClassRegistry::init('Vote')->getListOfTaskForConfirmation($this->Auth->user('id'));
		$task_confirmation_request_status = ClassRegistry::init('Vote')->getListOfMyTaskForConfirmation($this->Auth->user('id'));
		$confirmed_tasks = ClassRegistry::init('Vote')->getListOfConfirmedTasks($this->Auth->user('id'));
		$other_admin_tasks = ClassRegistry::init('Vote')->getListOfOtherAdminTasks($this->Auth->user('id'));
		$this->set(compact('tasks_for_confirmation', 'task_confirmation_request_status', 'confirmed_tasks', 'other_admin_tasks'));
	}
	
     function cancel_task_confirmation($vote_id = null) {
	if(!empty($vote_id)) 
        {
		$vote = $this->User->TaskRequester->find('first',array(
		'conditions' =>
		array(
		'TaskRequester.id' => $vote_id
		),
		'recursive' => -1
		)
		);
		//debug($vote);
		if(isset($vote['TaskRequester']['requester_user_id']) && strcasecmp($this->Auth->user('id'), $vote['TaskRequester']['requester_user_id']) == 0) {
		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-7, date("Y")));
		if(isset($vote['TaskRequester']['confirmation']) && $vote['TaskRequester']['confirmation'] == 0) {
		//debug($valid_date_from);
		//debug($vote['TaskRequester']['created']);
		if($valid_date_from < $vote['TaskRequester']['created']) {
		if($this->User->TaskRequester->delete($vote_id)) {
		$this->Session->setFlash('<span></span>Task for confirmation is successfully canceled.','default', array('class' => 'success-box success-message'));
		} else {
		$this->Session->setFlash('<span></span>Task for confirmation cancellation is failed. Please try again.','default', array('class' => 'error-box error-message'));
		}
		} else {
		$this->Session->setFlash('<span></span>Task confirmation request is already expired and there is no need to cancel it.','default', array('class' => 'error-box error-message'));
		}
		} else {
		$this->Session->setFlash('<span></span>Task confirmation request is already confirmed and there is no need to cancel it.','default', array('class' => 'error-box error-message'));
		}
		} else {
		$this->Session->setFlash('<span></span>You are trying to cancel others task confirmation request which is illegal.','default', array('class' => 'error-box error-message'));
		}
  	}
	
	return $this->redirect(array('action' => 'task_confirmation'));

	}
	
	function confirm_task($vote_id = null) {
           if(!empty($vote_id)) {
			$vote = $this->User->TaskRequester->find('first',
				array(
					'conditions' =>
					array(
						'TaskRequester.id' => $vote_id
					),
					'recursive' => -1
				)
			);
			
			if(strcasecmp($this->Auth->user('id'), $vote['TaskRequester']['requester_user_id']) != 0) {
				$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
				//debug($vote);debug($valid_date_from);exit();
				if($vote['TaskRequester']['confirmation'] == 0) {
					if($valid_date_from < $vote['TaskRequester']['created']) {
						if(strcasecmp($vote['TaskRequester']['task'], 'Password Reset') == 0) {
							$user_reset['id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$user_reset['force_password_change'] = 2;
							$user_reset['last_password_change_date'] = date('Y-m-d H:i:s');
							$user_reset['password'] = $vote['TaskRequester']['data'];
							$userH = $this->User->find('first',
								array(
									'conditions' =>
									array(
										'User.id' => $vote['TaskRequester']['applicable_on_user_id']
									)
								)
							);
							$passwordHistory['user_id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$passwordHistory['password'] = $userH['User']['password'];
							$this->User->PasswordHistory->save($passwordHistory);
						}
						else if(strcasecmp($vote['TaskRequester']['task'], 'Role Change') == 0) {
							$user_reset['id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$user_reset['role_id'] = $vote['TaskRequester']['data'];
						}
						else if(strcasecmp($vote['TaskRequester']['task'], 'Account Deactivation') == 0) {
							$user_reset['id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$user_reset['active'] = 0;
						}
						else if(strcasecmp($vote['TaskRequester']['task'], 'Account Activation') == 0) {
							$user_reset['id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$user_reset['active'] = 1;
						}
						else if(strcasecmp($vote['TaskRequester']['task'], 'Administrator Cancellation') == 0) {
							$user_reset['id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$user_reset['is_admin'] = 0;
							$aro_id = ClassRegistry::init('Aro')->field('id', array('model' => 'User', 'foreign_key' => $vote['TaskRequester']['applicable_on_user_id']));
							$permission = ClassRegistry::init('Permission')->deleteAll(
								array(
									'Permission.aro_id' => $aro_id
								)
							);
						}
						else if(strcasecmp($vote['TaskRequester']['task'], 'Administrator Assignment') == 0) {
							/* Check if there is already administrator */
				    		$selected_user = $this->User->find('first',
				    			array(
				    				'conditions' =>
				    				array(
				    					'User.id' => $vote['TaskRequester']['applicable_on_user_id']
				    				),
				    				'contain' => 
				    				array(
				    					'Staff'
				    				)
				    			)
				    		);
				    		$options = 
				    			array(
				    				'conditions' =>
				    				array(
				    					'User.is_admin' => 1,
				    					'User.role_id' => $selected_user['User']['role_id'],
				    				),
				    				'contain' =>
				    				array(
				    					'College',
				    					'Department',
				    					'User'
				    				)
				    			);
				    		if($selected_user['User']['role_id'] == ROLE_COLLEGE) {
				    			$options['conditions']['Staff.college_id'] = $selected_user['Staff'][0]['college_id'];
				    		}
				    		if($selected_user['User']['role_id'] == ROLE_DEPARTMENT) {
				    			$options['conditions']['Staff.department_id'] = $selected_user['Staff'][0]['department_id'];
				    		}
				    		$is_there_admin = $this->User->Staff->find('first', $options);
				    		if(!empty($is_there_admin)) {
				    			$office = "";
				    			if($selected_user['User']['role_id'] == ROLE_MEAL) {
				    				$office = "Meal service";
				    			}
				    			if($selected_user['User']['role_id'] == ROLE_ACCOMODATION) {
				    				$office = "Accommodation service";
				    			}
				    			if($selected_user['User']['role_id'] == ROLE_HEALTH) {
				    				$office = "Health service";
				    			}
				    			if($selected_user['User']['role_id'] == ROLE_REGISTRAR) {
				    				$office = "Health service";
				    			}
				    			if($selected_user['User']['role_id'] == ROLE_DEPARTMENT) {
				    				$office = $is_there_admin['Department']['name'];
				    			}
				    			if($selected_user['User']['role_id'] == ROLE_COLLEGE) {
				    				$office = $is_there_admin['College']['name'];
				    			}
				    			$this->Session->setFlash('<span></span>'.__($office.' already has '.$is_there_admin['Staff']['first_name'].' '.$is_there_admin['Staff']['middle_name'].' '.$is_there_admin['Staff']['last_name'].' ('.$is_there_admin['User']['username'].') as an administrator. Please cancel the already assigned administrator before you confirm the new assignment.'),'default',array('class'=>'error-box error-message'));
				    			return $this->redirect(array('action'=>'task_confirmation'));
				    		}
							$user_reset['id'] = $vote['TaskRequester']['applicable_on_user_id'];
							$user_reset['is_admin'] = 1;
						}
						if($this->User->save($user_reset)) {
							$vote_update['id'] = $vote_id;
							$vote_update['confirmation'] = 1;
							$vote_update['confirmation_date'] = date('Y-m-d H:i:s');
							$vote_update['confirmed_by'] = $this->Auth->user('id');
							if($this->User->TaskRequester->save($vote_update)) {
								$vote = $this->User->TaskRequester->find('first',
									array(
										'conditions' =>
										array(
											'TaskRequester.id' => $vote_id
										),
										'contain' =>
										array(
											'Requester' =>
											array(
												'first_name',
												'last_name',
												'middle_name',
												'username'
											),
											'ApplicableOn' =>
											array(
												'first_name',
												'last_name',
												'middle_name',
												'username',
												'role_id',
												'Staff' =>
												array(
													'Department',
													'College'
												)
											),
											'ConfirmedBy' =>
											array(
												'first_name',
												'last_name',
												'middle_name',
												'username'
											),
										)
									)
								);
								//debug($vote);exit();
								if(strcasecmp($vote['TaskRequester']['task'], 'Password Reset') == 0) {
									$message = 'Your password reset request for <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u> is confirmed by <u>'.$vote['ConfirmedBy']['first_name'].' '.$vote['ConfirmedBy']['middle_name'].' '.$vote['ConfirmedBy']['last_name'].' ('.$vote['ConfirmedBy']['username'].')</u> and password change applied. Please communicate the new password to <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u>.';
								}
								else if(strcasecmp($vote['TaskRequester']['task'], 'Role Change') == 0) {
									$message = 'Your role change request for <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u> is confirmed by <u>'.$vote['ConfirmedBy']['first_name'].' '.$vote['ConfirmedBy']['middle_name'].' '.$vote['ConfirmedBy']['last_name'].' ('.$vote['ConfirmedBy']['username'].')</u> and role change is done.';
								}
								else if(strcasecmp($vote['TaskRequester']['task'], 'Account Deactivation') == 0) {
									$message = 'Your user account deactivation request for <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u> is confirmed by <u>'.$vote['ConfirmedBy']['first_name'].' '.$vote['ConfirmedBy']['middle_name'].' '.$vote['ConfirmedBy']['last_name'].' ('.$vote['ConfirmedBy']['username'].')</u> and account is deactivated.';
								}
								else if(strcasecmp($vote['TaskRequester']['task'], 'Account Activation') == 0) {
									$message = 'Your user account activation request for <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u> is confirmed by <u>'.$vote['ConfirmedBy']['first_name'].' '.$vote['ConfirmedBy']['middle_name'].' '.$vote['ConfirmedBy']['last_name'].' ('.$vote['ConfirmedBy']['username'].')</u> and account is activated.';
								}
								else if(strcasecmp($vote['TaskRequester']['task'], 'Administrator Cancellation') == 0) {
									$message = 'Your administrator cancellation request for <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u> is confirmed by <u>'.$vote['ConfirmedBy']['first_name'].' '.$vote['ConfirmedBy']['middle_name'].' '.$vote['ConfirmedBy']['last_name'].' ('.$vote['ConfirmedBy']['username'].')</u> and administrator cancellation is done.';
								}
								else if(strcasecmp($vote['TaskRequester']['task'], 'Administrator Assignment') == 0) {
						 			$office = "";
						 			if($vote['ApplicableOn']['role_id'] == ROLE_MEAL) {
						 				$office = "Meal service";
						 			}
						 			if($vote['ApplicableOn']['role_id'] == ROLE_ACCOMODATION) {
						 				$office = "Accommodation service";
						 			}
						 			if($vote['ApplicableOn']['role_id'] == ROLE_HEALTH) {
						 				$office = "Health service";
						 			}
						 			if($vote['ApplicableOn']['role_id'] == ROLE_REGISTRAR) {
						 				$office = "Health service";
						 			}
						 			if($vote['ApplicableOn']['role_id'] == ROLE_DEPARTMENT) {
						 				$office = $vote['ApplicableOn']['Staff'][0]['Department']['name'];
						 			}
						 			if($vote['ApplicableOn']['role_id'] == ROLE_COLLEGE) {
						 				$office = $vote['ApplicableOn']['Staff'][0]['College']['name'];
						 			}
									$message = 'Your administrator assignment request for <u>'.$vote['ApplicableOn']['first_name'].' '.$vote['ApplicableOn']['middle_name'].' '.$vote['ApplicableOn']['last_name'].' ('.$vote['ApplicableOn']['username'].')</u> is confirmed by <u>'.$vote['ConfirmedBy']['first_name'].' '.$vote['ConfirmedBy']['middle_name'].' '.$vote['ConfirmedBy']['last_name'].' ('.$vote['ConfirmedBy']['username'].')</u> and the user becomes an administrator for '.$office.'. Please let the assigned person know the new assignment.';
								}
								ClassRegistry::init('AutoMessage')->sendMessage($vote['TaskRequester']['requester_user_id'], $message, 1);
								$this->Session->setFlash('<span></span>Task is successfully confirmed and applied.','default', array('class' => 'success-box success-message'));
							}
							else {
								$this->Session->setFlash('<span></span>Task confirmation is failed. Please try again.','default', array('class' => 'error-box error-message'));
							}
						}
						else {
							$this->Session->setFlash('<span></span>Task confirmation is failed. Please try again.','default', array('class' => 'error-box error-message'));
						}
					}
					else {
						$this->Session->setFlash('<span></span>Task confirmation request is expired to confirm.','default', array('class' => 'error-box error-message'));
					}
				}
				else {
					$this->Session->setFlash('<span></span>Task confirmation request is already confirmed.','default', array('class' => 'error-box error-message'));
				}
			}
			else {
				$this->Session->setFlash('<span></span>You can not confirm your own request. Please inform other system administrator to confirm your task request.','default', array('class' => 'error-box error-message'));
			}
		}
		return $this->redirect(array('action' => 'task_confirmation'));
	}
	
	function assign_main_account_administrator($role_id = null) {
	 if(!empty($this->request->data)) {
	    $role_id = $this->request->data['User']['role_id'];
           if (empty ($this->request->data['User']['user_id'])) {
               $this->Session->setFlash('<span></span>'.__('Please select the user that you want to assign as an administrator.'), 'default', array ('class' => 'error-box error-message'));
          }
          else {
          		/*
          		1. Check if there is another assignment request
          		2. Check if there is already an administrator for the selected role
          		3. Check if there is already role change request
          		*/
         $valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
          $alread_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Administrator Assignment',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		$there_is_role_change_alread_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Role Change',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		$selected_user = $this->User->find('first',
          			array(
          				'conditions' =>
          				array(
          					'User.id' => $this->request->data['User']['user_id']
          				),
          				'contain' => 
          				array(
          					'Staff'
          				)
          			)
          		);
          		$options = 
          			array(
          				'conditions' =>
          				array(
          					'User.is_admin' => 1,
          					'User.role_id' => $role_id,
          				),
          				'contain' =>
          				array(
          					'College',
          					'Department',
          					'User'
          				)
          			);
          		if($role_id == ROLE_COLLEGE) {
          			$options['conditions']['Staff.college_id'] = $selected_user['Staff'][0]['college_id'];
          		}
          		if($role_id == ROLE_DEPARTMENT) {
          			$options['conditions']['Staff.department_id'] = $selected_user['Staff'][0]['department_id'];
          		}
          		$is_there_admin = $this->User->Staff->find('first', $options);
          		if(!empty($is_there_admin)) {
          			$office = "";
          			if($role_id == ROLE_MEAL) {
          				$office = "Meal service";
          			}
          			if($role_id == ROLE_ACCOMODATION) {
          				$office = "Accommodation service";
          			}
          			if($role_id == ROLE_HEALTH) {
          				$office = "Health service";
          			}
          			if($role_id == ROLE_REGISTRAR) {
          				$office = "Health service";
          			}
          			if($role_id == ROLE_DEPARTMENT) {
          				$office = $is_there_admin['Department']['name'];
          			}
          			if($role_id == ROLE_COLLEGE) {
          				$office = $is_there_admin['College']['name'];
          			}
          			$this->Session->setFlash('<span></span>'.__($office.' already has '.$is_there_admin['Staff']['first_name'].' '.$is_there_admin['Staff']['middle_name'].' '.$is_there_admin['Staff']['last_name'].' ('.$is_there_admin['User']['username'].') as an administrator. Please cancel the already assigned administrator before you make a new assignment.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($alread_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already "Administrator Assignment" request for the selected user. The request has to be either canceled or expired in-order to place administrator assignment request again.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($there_is_role_change_alread_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already "Role Change" request for the selected user. The role change request has to be either canceled or expired in-order to place administrator assignment request.'),'default',array('class'=>'error-box error-message'));
          		}
          		else {
				   	$vote = array();
				   	$vote['task'] = 'Administrator Assignment';
				   	$vote['requester_user_id'] = $this->Auth->user('id');
				   	$vote['applicable_on_user_id'] = $this->request->data['User']['user_id'];
						if (ClassRegistry::init('Vote')->save($vote)) {
						    $this->Session->setFlash('<span></span>'.__('Main account administrator assignment request is sent to other system administrators and it will be effective up on confirmation. You will be informed when your request is confirmed and applied.'), 'default',array('class'=>'success-box success-message'));
						    $this->redirect(array('action'=>'task_confirmation'));
						} else {
						    $this->Session->setFlash('<span></span>'.__('Main account administrator assignment request is failed. Please, try again.'),'default',array('class'=>'error-box error-message'));
						} 
				   }
			   }
			}
		//End of isset($this->request->data)
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id NOT ' => array(ROLE_STUDENT, ROLE_SYSADMIN, ROLE_INSTRUCTOR, ROLE_GENERAL, ROLE_CLEARANCE, ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)
				)
			)
		);
		$roles = array(0 => '--- Select Role ---') + $roles;
		$role_ids = array_keys($roles);
        $users = array();
        if($role_id && in_array($role_id, $role_ids)) {
        	$options =
        		array(
        			'conditions' =>
        			array(
        				'User.role_id' => $role_id,
        				'User.is_admin' => 0,
        				'User.active' => 1,
        			),
        			'fields' =>
        			array(
        				'Staff.full_name',
        				'Staff.college_id',
        				'Staff.department_id',
        				'User.username',
        				'User.id'
        			),
        			'contain' => 
        			array(
        				'User'
        			)
        		);
        	$users = ClassRegistry::init('Staff')->find('all', $options);
        	//debug($users);
        	$users_f = array();
        	if($role_id == ROLE_COLLEGE) {
        		//$colleges = ClassRegistry::init('College')->find('list');
        		// $college_ids = array_keys($colleges);
                        
        		foreach($users as $user) {
                              $collegeName=ClassRegistry::init('College')->field('College.name',array('College.id'=>$user['Staff']['college_id']));
        			if(!isset($users_f[$collegeName])) {
        				$users_f[$collegeName] = array();
        			}
        			$users_f[$collegeName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else if($role_id == ROLE_DEPARTMENT) {
        		//$departments = ClassRegistry::init('Department')->find('list');
        		//$department_ids = array_keys($departments);
        		foreach($users as $user) {
                       $departmentName=ClassRegistry::init('Department')->field('Department.name',array('Department.id'=>$user['Staff']['department_id']));
        			if(!isset($users_f[$departmentName])) {
        				$users_f[$departmentName] = array();
        			}
        			$users_f[$departmentName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else {
        		foreach($users as $user) {
        			$users_f[$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	if(!empty($users))
        		$users = array(0 => '--- Select user ---') + $users;
        	else
        		$users = array(0 => '--- There is no user to display ---') + $users;
        }
        else {
        	$users = array(0 => '--- Select Role First ---') + $users;
        }
        $this->set(compact('roles', 'users', 'role_id'));
	}
	
	function change_user_role($role_id = null) {
		/*
		Possible if 
		1. The user is not an administrator by his/her current role
		2. To department if the user has department id
		3. To college if the user has college id
		4. There is no administrator assignment process
		5. There is no already on process role change
		*/
		if(!empty($this->request->data)) {
			 $role_id = $this->request->data['User']['role_id'];
		    if (empty ($this->request->data['User']['user_id'])) {
               $this->Session->setFlash('<span></span>'.__('Please select the user for whom you want to change his/her role.'), 'default', array ('class' => 'error-box error-message'));
          }
          else {
          		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
          		$already_assignment_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Administrator Assignment',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		$already_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Role Change',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		$user_detail = $this->User->find('first',
          			array(
          				'conditions' =>
          				array(
          					'User.id' => $this->request->data['User']['user_id']
          				),
          				'recursive' => -1
          			)
          		);
          		if($user_detail['User']['is_admin'] == 1) {
          			$this->Session->setFlash('<span></span>'.__('The selected user is an administrator. You need to cancel his/her administrator privilege in order to change his/her role.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($already_assignment_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already administrator assignment request for the selected user. The request has to be either canceled or expired in-order to place role change request.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($already_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already a role change request for the selected user. The request has to be either canceled or expired in-order to place another role change request.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if(empty($this->request->data['User']['new_role_id'])) {
          			$this->Session->setFlash('<span></span>'.__('Please select user new role.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($user_detail['User']['role_id'] == $this->request->data['User']['new_role_id']) {
          			$this->Session->setFlash('<span></span>'.__('Please select a different role the user is supposed to has.'),'default',array('class'=>'error-box error-message'));
          		}
          		else {
				   	$vote = array();
				   	$vote['task'] = 'Role Change';
				   	$vote['requester_user_id'] = $this->Auth->user('id');
				   	$vote['data'] = $this->request->data['User']['new_role_id'];
				   	$vote['applicable_on_user_id'] = $this->request->data['User']['user_id'];
						if (ClassRegistry::init('Vote')->save($vote)) {
						    $this->Session->setFlash('<span></span>'.__('User role change request is sent to other system administrators and it will be effective up on confirmation. You will be informed when your request is confirmed and applied.'), 'default',array('class'=>'success-box success-message'));
						    $this->redirect(array('action'=>'task_confirmation'));
						} else {
						    $this->Session->setFlash('<span></span>'.__('User role change request is failed. Please, try again.'),'default',array('class'=>'error-box error-message'));
						}
				   }
			   }
			}
		//End of isset($this->request->data)
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id NOT ' => array(ROLE_STUDENT, ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)
				)
			)
		);
		$roles = array(0 => '--- Select Role ---') + $roles;
		$role_ids = array_keys($roles);
        $users = array();
        if($role_id && in_array($role_id, $role_ids)) {
        	$options =
        		array(
        			'conditions' =>
        			array(
        				'User.role_id' => $role_id,
        				'User.active' => 1,
        			),
        			'fields' =>
        			array(
        				'Staff.full_name',
        				'Staff.college_id',
        				'Staff.department_id',
        				'User.username',
        				'User.id'
        			),
        			'contain' => 
        			array(
        				'User'
        			)
        		);
        	$users = ClassRegistry::init('Staff')->find('all', $options);
        	$users_f = array();
        	if($role_id == ROLE_COLLEGE) {
        	//	$colleges = ClassRegistry::init('College')->find('list');
        	//	$college_ids = array_keys($colleges);
        		foreach($users as $user) {
 $collegeName=ClassRegistry::init('College')->field('College.name',array('College.id'=>$user['Staff']['college_id']));
        			if(!isset($users_f[$collegeName])) {
        				$users_f[$collegeName] = array();
        			}
        			$users_f[$collegeName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else if($role_id == ROLE_DEPARTMENT || $role_id == ROLE_INSTRUCTOR) {
        		// $departments = ClassRegistry::init('Department')->find('list');
        		// $department_ids = array_keys($departments);
        		foreach($users as $user) {
            $departmentName=ClassRegistry::init('Department')->field('Department.name',array('Department.id'=>$user['Staff']['department_id']));
        			if(!isset($users_f[$departmentName])) {
        				$users_f[$departmentName] = array();
        			}
        			$users_f[$departmentName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else {
        		foreach($users as $user) {
        			$users_f[$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	if(!empty($users))
        		$users = array(0 => '--- Select user ---') + $users;
        	else
        		$users = array(0 => '--- There is no user to display ---') + $users;
        }
        else {
        	$users = array(0 => '--- Select Role First ---') + $users;
        }
        $this->set(compact('roles', 'users', 'role_id'));
	}
	
	function deactivate_account($role_id = null) {
		if(!empty($this->request->data)) {
			 $role_id = $this->request->data['User']['role_id'];
		    if (empty ($this->request->data['User']['user_id'])) {
               $this->Session->setFlash('<span></span>'.__('Please select the user whose account is going to be deactivated.'), 'default', array ('class' => 'error-box error-message'));
          }
          else {
          		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
          		$already_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Account Deactivation',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		$user_detail = $this->User->find('first',
          			array(
          				'conditions' =>
          				array(
          					'User.id' => $this->request->data['User']['user_id']
          				),
          				'recursive' => -1
          			)
          		);
          		if($user_detail['User']['active'] == 0) {
          			$this->Session->setFlash('<span></span>'.__('The selected user account is already deactivated.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($already_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already account deactivation request for the selected user. The request has to be either canceled or expired in-order to place another request.'),'default',array('class'=>'error-box error-message'));
          		}
          		else {
				   	$vote = array();
				   	$vote['task'] = 'Account Deactivation';
				   	$vote['requester_user_id'] = $this->Auth->user('id');
				   	$vote['applicable_on_user_id'] = $this->request->data['User']['user_id'];
						if (ClassRegistry::init('Vote')->save($vote)) {
						    $this->Session->setFlash('<span></span>'.__('User account deactivation request is sent to other system administrators and it will be effective up on confirmation. You will be informed when your request is confirmed and applied.'), 'default',array('class'=>'success-box success-message'));
						    $this->redirect(array('action'=>'task_confirmation'));
						} else {
						    $this->Session->setFlash('<span></span>'.__('User account deactivation request is failed. Please, try again.'),'default',array('class'=>'error-box error-message'));
						}
				   }
			   }
			}
		//End of isset($this->request->data)
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id NOT ' => array(ROLE_STUDENT, ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)
				)
			)
		);
		$roles = array(0 => '--- Select Role ---') + $roles;
		$role_ids = array_keys($roles);
        $users = array();
	
        if($role_id && in_array($role_id, $role_ids)) {
        	$options =
        		array(
        			'conditions' =>
        			array(
        				'User.role_id' => $role_id,
        				'User.active' => 1,
        			),
        			'fields' =>
        			array(
        				'Staff.full_name',
        				'Staff.college_id',
        				'Staff.department_id',
        				'User.username',
        				'User.id'
        			),
        			'contain' => 
        			array(
        				'User'
        			)
        		);
        	$users = ClassRegistry::init('Staff')->find('all', $options);
		debug(count($users));
        	$users_f = array();
        	if($role_id == ROLE_COLLEGE) {
        		//$colleges = ClassRegistry::init('College')->find('list');
        		//$college_ids = array_keys($colleges);
        		foreach($users as $user) {
                       $collegeName=ClassRegistry::init('College')->field('College.name',array('College.id'=>$user['Staff']['college_id']));
        			if(!isset($users_f[$collegeName])) {
        				$users_f[$collegeName] = array();
        			}
        			$users_f[$collegeName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else if($role_id == ROLE_DEPARTMENT || $role_id == ROLE_INSTRUCTOR) {
        		$departments = ClassRegistry::init('Department')->find('list');
        		//$department_ids = array_keys($departments);
        		foreach($users as $user) {
				//$departmentName=ClassRegistry::init('Department')->field('Department.name',array('Department.id'=>$user['Staff']['department_id']));
			        if(!isset($users_f[$departments[$user['Staff']['department_id']]])) {

        				$users_f[$departments[$user['Staff']['department_id']]] = array();
        			}
        			$users_f[$departments[$user['Staff']['department_id']]][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].'=>'.$departmentName.')';

        		}
			
        		$users = $users_f;
        	}
        	else {
        		foreach($users as $user) {
        			$users_f[$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	if(!empty($users))
        		$users = array(0 => '--- Select user ---') + $users;
        	else
        		$users = array(0 => '--- There is no active user to display ---') + $users;
        }
        else {
        	$users = array(0 => '--- Select Role First ---') + $users;
        }
        $this->set(compact('roles', 'users', 'role_id'));
	}
	
	function activate_account($role_id = null) {
	 if(!empty($this->request->data)) {
	     $role_id = $this->request->data['User']['role_id'];
	    if (empty ($this->request->data['User']['user_id'])) {
               $this->Session->setFlash('<span></span>'.__('Please select the user whose account is going to be activated.'), 'default', array ('class' => 'error-box error-message'));
            } else {
          		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j")-3, date("Y")));
          		$already_requested = ClassRegistry::init('Vote')->find('count',
          			array(
          				'conditions' =>
          				array(
          					'Vote.task' => 'Account Activation',
          					'Vote.confirmation' => 0,
          					'Vote.applicable_on_user_id' => $this->request->data['User']['user_id'],
          					'Vote.created >= ' => $valid_date_from
          				)
          			)
          		);
          		$user_detail = $this->User->find('first',
          			array(
          				'conditions' =>
          				array(
          					'User.id' => $this->request->data['User']['user_id']
          				),
          				'recursive' => -1
          			)
          		);
          		if($user_detail['User']['active'] == 1) {
          			$this->Session->setFlash('<span></span>'.__('The selected user account is already activated.'),'default',array('class'=>'error-box error-message'));
          		}
          		else if($already_requested > 0) {
          			$this->Session->setFlash('<span></span>'.__('There is already account activation request for the selected user. The request has to be either canceled or expired in-order to place another request.'),'default',array('class'=>'error-box error-message'));
          		}
          		else {
				   	$vote = array();
				   	$vote['task'] = 'Account Activation';
				   	$vote['requester_user_id'] = $this->Auth->user('id');
				   	$vote['applicable_on_user_id'] = $this->request->data['User']['user_id'];
						if (ClassRegistry::init('Vote')->save($vote)) {
						    $this->Session->setFlash('<span></span>'.__('User account activation request is sent to other system administrators and it will be effective up on confirmation. You will be informed when your request is confirmed and applied.'), 'default',array('class'=>'success-box success-message'));
						    $this->redirect(array('action'=>'task_confirmation'));
						} else {
						    $this->Session->setFlash('<span></span>'.__('User account activation request is failed. Please, try again.'),'default',array('class'=>'error-box error-message'));
						}
				   }
			   }
			}
		//End of isset($this->request->data)
		$roles = ClassRegistry::init('Role')->find('list',
			array(
				'conditions' =>
				array(
					'Role.id NOT ' => array(ROLE_STUDENT, ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM)
				)
			)
		);
		$roles = array(0 => '--- Select Role ---') + $roles;
		$role_ids = array_keys($roles);
        $users = array();
        if($role_id && in_array($role_id, $role_ids)) {
        	$options =
        		array(
        			'conditions' =>
        			array(
        				'User.role_id' => $role_id,
        				'User.active' => 0,
        			),
        			'fields' =>
        			array(
        				'Staff.full_name',
        				'Staff.college_id',
        				'Staff.department_id',
        				'User.username',
        				'User.id'
        			),
        			'contain' => 
        			array(
        				'User'
        			)
        		);
        	$users = ClassRegistry::init('Staff')->find('all', $options);
        	$users_f = array();
        	if($role_id == ROLE_COLLEGE) {
        		// $colleges = ClassRegistry::init('College')->find('list');
        		// $college_ids = array_keys($colleges);
        		foreach($users as $user) {
                   $collegeName=ClassRegistry::init('College')->field('College.name',array('College.id'=>$user['Staff']['college_id']));
        			if(!isset($users_f[$collegeName])) {
        				$users_f[$collegeName] = array();
        			}
        			$users_f[$collegeName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else if($role_id == ROLE_DEPARTMENT || $role_id == ROLE_INSTRUCTOR) {
        		//$departments = ClassRegistry::init('Department')->find('list');
        		//$department_ids = array_keys($departments);
        		foreach($users as $user) {
       $departmentName=ClassRegistry::init('Department')->field('Department.name',array('Department.id'=>$user['Staff']['department_id']));
        			if(!isset($users_f[$departmentName])) {
        				$users_f[$departmentName] = array();
        			}
        			$users_f[$departmentName][$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	else {
        		foreach($users as $user) {
        			$users_f[$user['User']['id']] = $user['Staff']['full_name'].' ('.$user['User']['username'].')';
        		}
        		$users = $users_f;
        	}
        	if(!empty($users))
        		$users = array(0 => '--- Select user ---') + $users;
        	else
        		$users = array(0 => '--- There is no deactive user to display ---') + $users;
        }
        else {
        	$users = array(0 => '--- Select Role First ---') + $users;
        }
        $this->set(compact('roles', 'users', 'role_id'));
	}
	/**
	*Build user menu 
	*/
	function build_user_menu ($user_id=null) {
	        //It is used to ignore recorded number of process which are older than 1 hour to avoid stacked processes
	        $last_process_date = date('Y-m-d H:i:s', mktime(date("H"), date("i")-20, date("s"), date("n"), date("j"), date("Y")));
	        $numberProcess = $this->User->NumberProcess->find('count',
	        	array(
	        		'conditions' =>
	        		array(
	        			'NumberProcess.created >' => $last_process_date
	        		)
	        	)
	        );
	        $number_of_user_initiated_process = $this->User->NumberProcess->find('count',
	        	array(
	        		'conditions' =>
	        		array(
	        			'NumberProcess.created >' => $last_process_date,
	        			'NumberProcess.initiated_by' => $this->Auth->user('id')
	        		)
	        	)
	        );
	        /*
	        One administrator is allowed to run a maximum of one menu building task
	        */
	        if($number_of_user_initiated_process <= 0) {
			     if ($numberProcess<Configure::read('NumberProcessAllowedToRunProfile')) {
			         $saveRunningProcess=$this->User->NumberProcess->recoredAsRunning ($user_id, $this->Auth->user('id'));
			         $runningusers=$this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'recursive'=>-1));
			         /*Construct the menus From the Controllers in the Application. This is an 
			         expensive Process Timewise and is cached.*/
			          $this->Session->delete('permissionLists');
		            // clear menu cache if existed 
			         $this->_clearMenuCatch($user_id);
			         //$this->Menu->clearCache();
			        // $this->Menu->constructMenu($runningusers);
			         $this->MenuOptimized->constructMenu($user_id);
			         $this->User->NumberProcess->jobDoneDelete($user_id);
			         $this->Session->setFlash('<span></span>'.__('The system build the selected user menu successfully based on assigned user privilege.'), 'default',array('class'=>'success-box success-message'));
			         
			     } else {
			          $this->Session->setFlash('<span></span>'.__('The system is busy handling user menu construct requests. Please come back after some minutes to construct user menu.'), 'default',array('class'=>'info-box info-message'));
			         
			     }
	        }
	        else {
	        		$this->Session->setFlash('<span></span>'.__('You already has menu construction request being handled by the system. Please be patent till the system finish the requested menu construction task to initiate another menu construction request.'), 'default',array('class'=>'info-box info-message'));
	        }
	       $this->redirect(array('action'=>'index'));
	        
	}
	
	function suspended($userId){
		$userDetails=$this->User->find('first',array('conditions'=>
			array('User.id'=>$userId)));
		$this->set(compact('userDetails'));
	}
	function _clearMenuCatch ($user_id=null) {
		App::import('Folder');
		
		$dir = new Folder(Configure::read('Utility.cache'));
		$files = $dir->findRecursive('menu_storageuser'.$user_id.'.*');
		foreach ($files as $in=>$file) {
		    $output=shell_exec('rm '.$file." 2>&1");
		}
		 
	}
	 
}
