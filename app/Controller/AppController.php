<?php
//App::uses('Controller', 'Controller');
//App::uses('DataTableRequestHandlerTrait', 'DataTable.Lib');
class AppController extends Controller {
	// use DataTableRequestHandlerTrait;
	//public $theme = "CakeAdminLTE";
    public $cacheAction = true;
	public $components = array('Acl','Session','Paginator','MenuOptimized','RequestHandler',
	'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            ),
        ),
	);
	public $persistModel = true; // performance
	public $helpers = array('Js'=>'Jquery','AssetCompress.AssetCompress',
'Html','Form','Session','Format','Link');
	public $college_id=null,$department_id=null,$role_id=null,$role_name=null,
	$college_name=null,$department_name=null,$student_id=null,$program_id=null,$program_type_id=null,
	$staff_id=null;
	/**
	* Completed list of assignment for accounts created from the main account holder of registrar
	* @var array
	**/
       public $college_ids = array();
       public $department_ids = array();
       public $onlyPre = 0;

       function _findIp() { 
		if(getenv("HTTP_CLIENT_IP"))
		    return getenv("HTTP_CLIENT_IP");
		elseif(getenv("HTTP_X_FORWARDED_FOR"))
		    return getenv("HTTP_X_FORWARDED_FOR");
		else
		    return getenv("REMOTE_ADDR");
       }
       function beforeFilter() {

	
          parent::beforeFilter();
          $this->Auth->autoRedirect=false;   
          $this->Auth->userScope = array('User.active '=> 1);
          $this->Auth->authError = __('<div class="warning-box warning-message"><span></span>You do not have permission to access the page you just selected.</div>');
           //Configure AuthComponent
		  $this->Auth->loginAction = array(
			  'controller' => 'users',
			  'action' => 'login',
		               'plugin'=>false,
		              'admin'=>false
		  );
		  $this->Auth->logoutRedirect = array(
			  'controller' => 'users',
			  'action' => 'login'
			);
		  $this->Auth->loginRedirect = array(
			  'controller' => 'dashboard',
			  'action' => 'index'
		  );
       
	  	  $auth = $this->Session->read('Auth.User');
	  	 
          if($auth) 
          {         
	
             $this->set('username',$auth['username']);
             $this->set('last_login',$auth['last_login']);
             $this->set('user_id',$auth['id']);
	     	 $this->set('auto_messages',ClassRegistry::init('AutoMessage')->getMessages($auth['id']));
		  
             //generate menu based on user privilage and save it to session 
             if (($auth['id'] && !$this->Session->read('permissionLists'))) {
                $aroKey = $auth;
                       
                $permissionLists=ClassRegistry::init('User')->getAllPermissions($auth['id']);
               
				Configure::write('permissionLists',$permissionLists['permission']);
				Configure::write('PermissionLists.Perm',$permissionLists['permission']);
				Configure::write('reformatePermission',$permissionLists['reformatePermission']);  
				$this->Session->write('permissionLists', $permissionLists['permission']);
				$this->Session->write('reformatePermission',$permissionLists['reformatePermission']);      
             }
             //save to the session the role of the user 
             $this->Session->write('role_id', $auth['role_id']);
             $this->role_id=$auth['role_id'];
		
			Configure::write('User.user', $auth['id']);
			Configure::write('User.role_id', $auth['role_id']);
			Configure::write('User.is_admin', $auth['is_admin']);
			Configure::write('User.active', $auth['active']);

			$this->set('user_full_name', $auth['full_name']);
			$this->Session->write('user_id', $auth['id']);
			//only query if the user details in not in the session 
			if (!$this->Session->read('users_relation')) {
					$this->Session->write('users_relation',ClassRegistry::init('User')->getUserDetails($auth['id']));
			}

		     $users_college=$this->Session->read('users_relation');
                    // Basic varibles are set to be visible by all controller of the application
                    // to access the variable in any controller use $this->variblename. Dont
                    // forget to call parent::beforeFilter in your controller beforeFilter
                    // action, then all variable set in app controller will be used.
                    // to access it from view just write $variablename
	               
		if (!empty($users_college['Staff'])) {
					$this->staff_id = $users_college['Staff'][0]['id'];

					if (!empty($users_college['Staff'][0]['college_id'])) {
							$this->college_id=$users_college['Staff'][0]['college_id'];
							if(!empty($users_college['Staff'][0]['College'])){
								$this->set('college_name',$users_college['Staff'][0]['College']['name']);
								$this->set('college_id',$users_college['Staff'][0]['college_id']);
								$this->college_name=$users_college['Staff'][0]['College']['name'];
							}
					}

					if (!empty($users_college['Staff'][0]['college_id']) && !empty($users_college['Staff'][0]['department_id'])) {
					$this->set('college_id',$users_college['Staff'][0]['college_id']);
					$this->set('department_id',$users_college['Staff'][0]['department_id']);
					if(!empty($users_college['Staff'][0]['College']['name'])){
					$this->set('college_name',$users_college['Staff'][0]['College']['name']);
					}


					if(isset($users_college['Role'])){
					$this->role_id=$users_college['Role']['id'];
					$this->rolename=$users_college['Role']['name'];
					$this->set('role_id',$users_college['Role']['id']);
					$this->set('role_name',$users_college['Role']['name']);
					}

					if(!empty($users_college['Staff'][0]['College'])&&!empty($users_college['Staff'][0]['Department'])){
					$this->set('college_name',$users_college['Staff'][0]['College']['name']);
					$this->set('department_name',$users_college['Staff'][0]['Department']['name']);
					$this->college_name=$users_college['Staff'][0]['College']['name'];
					$this->department_name=$users_college['Staff'][0]['Department']['name'];
					$this->department_id = $users_college['Staff'][0]['department_id'];

					}

					}
					//debug($this->Session->read('Auth.User'));
					//registrar role
					if ($this->role_id == ROLE_REGISTRAR
			|| ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
						if (isset($users_college['StaffAssigne']['department_id']) && !empty($users_college['StaffAssigne']['department_id'])) {
						$this->department_ids = unserialize($users_college['StaffAssigne']['department_id']);
						} elseif(isset($users_college['StaffAssigne']['college_id']) && !empty($users_college['StaffAssigne']['college_id'])) {
						$this->college_ids = unserialize($users_college['StaffAssigne']['college_id']);
						$this->onlyPre=$users_college['StaffAssigne']['collegepermission'];
						}

						if (!empty($users_college['StaffAssigne']['program_id'])) {
							
								$this->program_id=unserialize($users_college['StaffAssigne']['program_id']);
						
						}

						if (!empty($users_college['StaffAssigne']['program_type_id'])) {
							$this->program_type_id=unserialize($users_college['StaffAssigne']['program_type_id']);
						}

					  }
		} 
                     
	    if(!empty($users_college['Student'][0])) {
				$this->set('college_id',$users_college['Student'][0]['college_id']);
				$this->set('department_id',$users_college['Student'][0]['department_id']);                     
				$this->college_id=$users_college['Student'][0]['college_id'];                     
				$this->department_id=$users_college['Student'][0]['department_id'];

				//$this->student_id=$users_college['Student'][0]['accepted_student_id'];
				$this->student_id=$users_college['Student'][0]['id'];
				if(!empty($users_college['Role'])){
				$this->role_id=$users_college['Role']['id'];
				$this->role_name=$users_college['Role']['name'];
				$this->set('role_id',$users_college['Role']['id']);
				$this->set('role_name',$users_college['Role']['name']);
				}

				if(!empty($users_college['Student'][0]['College'])){
				$this->set('college_name',$users_college['Student'][0]['College']['name']);

				$this->college_name=$users_college['Student'][0]['College']['name'];


				}
				if(!empty($users_college['Student'][0]['Department'])){
				$this->set('department_name',$users_college['Student'][0]['Department']['name']);
				$this->department_name=$users_college['Student'][0]['Department']['name'];
				}

	   }

		if(isset($users_college['Role'])){
			$this->role_id=$users_college['Role']['id'];
			$this->rolename=$users_college['Role']['name'];
			$this->set('role_id',$users_college['Role']['id']);
			$this->set('role_name',$users_college['Role']['name']);
		}
        
        // http://bakery.cakephp.org/articles/view/logablebehavior

		if (count($this->uses) && $this->{$this->modelClass}->Behaviors->loaded('Logable')) {
					$activeUser = array( 'User' => array('id' => $auth['id'],'username' => $auth['username']));
					
					//$this->{$this->modelClass}->setUserData($this->modelClass,$activeUser);
					$this->{$this->modelClass}->setUserData($activeUser);
					 $this->{$this->modelClass}->setUserIp($this->modelClass,$this->_findIp());
					 
		} 
	   } else {
              if (count($this->uses) && $this->{$this->modelClass}->Behaviors->loaded('Logable')) {
              			
		 				$this->{$this->modelClass}->setUserIp($this->modelClass,$this->_findIp());
	           }
	    }

		$user = ClassRegistry::init('User')->find('first',
		array(
		'conditions' =>
		array(
		'User.id' => $auth['id']
		),
		'recursive' => -1
		)
		);
		$first_time_login = 0;
		$password_duration_expired = false;
		$last_password_change_date = null;
		//Check if the user has to change his/her password
		$securitysetting = ClassRegistry::init('Securitysetting')->find('first');
		$password_to_change_date = 
		date('Y-m-d H:i:s', mktime (date('H'), date('i'), date('s'), date('n'), date('j') - $securitysetting['Securitysetting']['password_duration'], date('Y')));
		if(isset($user['User']['last_password_change_date']) && $password_to_change_date > 
		$user["User"]['last_password_change_date']) {
			$password_duration_expired = true;
			$last_password_change_date = $user["User"]['last_password_change_date'];
		}
		//Check if the user login is for the first time
		if(isset($user["User"]['force_password_change']) && $user["User"]['force_password_change'] == 1) {
				$first_time_login = 1;
		}
		if(isset($user["User"]['force_password_change'])) {
			$this->set('force_password_change', $user["User"]['force_password_change']);
		}
		else {
		$this->set('force_password_change', 0);
		}
		$this->set('first_time_login', $first_time_login);
		$this->set('password_duration_expired', $password_duration_expired);
		$this->set('last_password_change_date', $last_password_change_date);
		$this->set('password_duration', $securitysetting['Securitysetting']['password_duration']);
		if(isset($user["User"]['id']) && !empty($user["User"]['id']) 
			&& ($user["User"]['force_password_change'] != 0 || $password_duration_expired) 
		&& strcasecmp($this->request->params['controller'], 'users') != 0 
		&& strcasecmp($this->request->params['action'], 'changePwd') != 0) {
				return $this->redirect(array('controller' => 'users', 'action' => 'changePwd'));
		}

		$studentnumber=null;
		if(!empty($this->request->data[$this->modelClass]['studentnumber']) || 
			!empty($this->request->data[$this->modelClass]['studentID'])){
			if(!empty($this->request->data[$this->modelClass]['studentnumber'])){
		       		$studentnumber=$this->request->data[$this->modelClass]['studentnumber'];
			} elseif(!empty($this->request->data[$this->modelClass]['studentID'])) {
		        	$studentnumber=$this->request->data[$this->modelClass]['studentID'];
			} 
		} else {
			if(!empty($this->request->data['Student']['studentnumber'])){
	       			$studentnumber=$this->request->data['Student']['studentnumber'];
			} elseif(!empty($this->request->data['Student']['studentID'])) {
		       		$studentnumber=$this->request->data['Student']['studentID'];
			}
		}
	       
		if($studentnumber && (!in_array($auth['role_id'],
array(ROLE_DEPARTMENT,ROLE_REGISTRAR))) && 0 ){
			$suspended=ClassRegistry::init('Student')->find('first',
				array('conditions'=>array('Student.studentnumber'=>
					$studentnumber,'Student.user_id in (select id from users where active=0)'),'recursive'=>-1));
			 if($suspended){
			   $this->set(compact('suspended'));
		           return $this->redirect(array('controller'=>'users', 'action' => 'suspended',$suspended['Student']['user_id']));
			 }
		}
		/*
		if($this->role_id==3 &&  ){
		  
		   return $this->redirect(array('controller'=>'alumni','action' => "add"));
		   
		}
		*/
		/*	
		if(isset($user["User"]['id']) && !empty($user["User"]['id']) && strcasecmp($this->request->params['controller'], 'alumni') != 0 && strcasecmp($this->request->params['action'], 'add') != 0 && $user["User"]['role_id']==3 
		&& ClassRegistry::init('Alumnus')->checkIfStudentGradutingClass($this->student_id)==true  
			&& ($user["User"]['force_password_change'] != 0 || $password_duration_expired) && strcasecmp($this->request->params['controller'], 'users') != 0 && strcasecmp($this->request->params['action'], 'changePwd') != 0 ) {
				
				if( ClassRegistry::init('Alumnus')->completedRoundOneQuestionner($this->student_id)==false){
				return $this->redirect(array('controller' => 'alumni', 'action' => 'add'));
				} 
				
		}
		*/
		
		
	 	
      }  
}
?>
