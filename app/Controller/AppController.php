<?php
//App::uses('Controller', 'Controller');
class AppController extends Controller {

	// use DataTableRequestHandlerTrait;
	//public $theme = "CakeAdminLTE";

    public $cacheAction = true;

	public $components = array(
		'Acl', 'Session', 'Paginator', 'MenuOptimized', 'RequestHandler', 'Flash', /* 'DataTable', */
		'Auth' => array(
			'authorize' => array(
				'Actions' => array('actionPath' => 'controllers')
			),
			/* 'loginAction' => array(
				'controller' => 'users',
				'action' => 'login',
				//'plugin' => 'users'
			), */
			'authError' => 'You do not have permission to access the page you just selected',
			/* 'authenticate' => array(
				'Form' => array(
					'fields' => array(
					  'username' => 'username', 
					  'password' => 'password'
					)
				)
			) */
		),
		/* 'Security' => array(
            'csrfCheck' => true,        // Enable CSRF validation
            'csrfUseOnce' => false,     // Token reused until expiry
            'csrfExpires' => '+30 minutes'
        ), */
	);

	public $persistModel = true; // performance

	public $helpers = array(
		'Js' => 'Jquery',
		'AssetCompress.AssetCompress',
		'Html',
		'Form',
		'Session',
		'Format',
		'Link',
		'Flash',
		'Csv'
	);

	public $college_id = null,
	$department_id = null,
	$role_id = null,
	$role_name = null,
	$college_name = null,
	$department_name = null,
	$student_id = null,
	$program_id = null,
	$program_type_id = null,
	$staff_id = null;

	public $programs = array(),
	$programs_list = array(),
	$program_types = array(),
	$program_types_list = array(),
	$departments = array(),
	$last_section  = array(),
	$year_levels  = array(),
	$departments_list = array();

	// Completed list of assignment for accounts created from the main account holder of registrar

    public $college_ids = array(), 
	$department_ids = array(), 
	$program_ids = array(), 
	$program_type_ids = array(), 
	$departments_college_ids = array(),
	$onlyPre = 0;

	// to check if the routes are public facing routes that doesnt need authentication and apply rate limmiting per IP and check form inputs doesn't contain URL links
	//protected $publicRoutes = Configure::read('public_facing_pages');

	protected $publicRoutes = array(
        /*
		'users/login',
		'users/forget',
		'alumni/register',
		'pages/academic_calender',
		'pages/announcement',
		'pages/check_graduate',
		'pages/admission',
		'pages/online_admission_tracking',
		'pages/official_transcript_request',
		'pages/official_request_tracking',
		'pages/check_remedial_result',
		'pages/check_campus_placement',
        'pages/admission'
	*/
        );

	protected $safeRoutes = array(
		'users/logout',
	);

	function _findIp() 
	{
		// Check for X-Real-IP (commonly set by Nginx reverse proxy)
		$realIp = getenv("X-Real-IP");
		if (!empty($realIp) && filter_var($realIp, FILTER_VALIDATE_IP)) {
			return $realIp;
		}
	
		// Check for X-Forwarded-For (commonly used by Nginx reverse proxy or load balancers)
		$xForwardedFor = getenv("X-Forwarded-For");
		if (!empty($xForwardedFor)) {
			$ipList = explode(',', $xForwardedFor);
			foreach ($ipList as $ip) {
				$ip = trim($ip);
				if (filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip; // Return first valid IP
				}
			}
		}
	
		// Check for HTTP_X_FORWARDED_FOR (used by Apache or certain proxies)
		$httpXForwardedFor = getenv("HTTP_X_FORWARDED_FOR");
		if (!empty($httpXForwardedFor)) {
			$ipList = explode(',', $httpXForwardedFor);
			foreach ($ipList as $ip) {
				$ip = trim($ip);
				if (filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip; // Return first valid IP
				}
			}
		}
	
		// Check for HTTP_CLIENT_IP (legacy proxy configurations)
		$httpClientIp = getenv("HTTP_CLIENT_IP");
		if (!empty($httpClientIp) && filter_var($httpClientIp, FILTER_VALIDATE_IP)) {
			return $httpClientIp;
		}
	
		// Fallback to REMOTE_ADDR (server-detected client IP)
		$remoteAddr = getenv("REMOTE_ADDR");
		if (!empty($remoteAddr) && filter_var($remoteAddr, FILTER_VALIDATE_IP)) {
			return $remoteAddr;
		}
	
		// Return null if no valid IP is found
		return null;
	}	

    function beforeFilter() 
	{
        parent::beforeFilter();

		
		if (Configure::read('debug') == 0) {
			//// SECURITY CHECK FOR FRONT FACING PUBLIC PAGES THAT DOESN"T NEED AUTHENTICATION

			#### IMOPORTANT: Uncomment these 2 lines CLEAR ALL or user_ or bots_ to clear all cache entries in user folder or by type manually 
			//Cache::clear(false, 'users'); // clears 'users' cache
			//Cache::clear(false, 'bots');  // clears 'bots' cache

			// --- CSRF Protection ---
			//$this->Security->blackHoleCallback = 'blackHole';

			// --- Rate Limiting (per IP) ---
			//$ip = $this->request->clientIp();
			$ip = $this->_findIp();
			$rateKey = 'rate_' . $ip;
			$lockKey = 'lock_' . $ip;

			// Build current route string: controller/action
			$currentRoute = strtolower($this->request->params['controller'] . '/' . $this->request->params['action']);

			/* if (!empty($currentRoute) && in_array($currentRoute, $this->safeRoutes)) {
				return; // skip rate limiting for logout ### breaks complete logouts
			} */

			// Apply only if user is not logged in AND route is public
			if (!$this->Session->check('Auth.User') && in_array($currentRoute, $this->publicRoutes)) {

				$count = Cache::read($rateKey, 'users');
				$lockedAt = Cache::read($lockKey, 'users');

				$requestsPerMinute = 10;   // threshold
				$lockOutMinutes    = 5;    // lockout duration

				// --- Basic WAF Rules ---
				$userAgent = $this->request->header('User-Agent');
				$accept = $this->request->header('Accept');

				// --- Check Lockout (bot): Check if IP is already locked as a bot --- 
				$agentLocked = Cache::read($lockKey, 'bots');
				//debug($agentLocked);

				if ($agentLocked !== false) {
					//$this->Flash->error('Your IP is locked due to suspicious activity. Try again later after 24 hours.');
					$this->set('message', 'Your IP is locked due to suspicious activity. Try again later after 24 hours.');
					$this->response->statusCode(403); // Forbidden
					$this->render('/Errors/error403');
					$this->response->send();
					$this->_stop();
				}

				// --- Check Lockout (user): Check if IP is already locked by rate limit --- 
				if ($lockedAt !== false) {
					$elapsed = time() - $lockedAt;
					if ($elapsed < ($lockOutMinutes * 60)) {
						$remaining = ($lockOutMinutes * 60) - $elapsed;
						//$this->Flash->error('Too many requests. Try again in ' . ceil($remaining / 60) . ' minutes.');
						// Instead of redirect (to avoid loops), send 429 status and stop
						// Flash + Halt: Set a flash message and stop processing without redirect:
						$this->set('message', 'You have exceeded the allowed number of requests. Please close any other opened tabs if any, and try again in ' . ceil($remaining / 60) . ' minutes.');
						$this->response->statusCode(429);		// Too Many Requests
						$this->render('/Errors/rate_limit'); 	// render your custom template
						$this->response->send();
						$this->_stop(); // halts execution
					} else {
						// Lockout expired => reset
						Cache::delete($lockKey, 'users');
						Cache::write($rateKey, 0, 'users');
						//Cache::delete($rateKey, 'users');
					}
				}

				// --- Rate Limiting ---
				if ($count === false) {
					Cache::write($rateKey, 1, 'users');
				} else {
					if ($count > $requestsPerMinute) {
						Cache::write($lockKey, time(), 'users'); // start lockout
						//$this->Flash->warning('Too many requests. Please slow down.');
						$this->set('message', 'You have exceeded the allowed number of requests. Please close any other opened tabs if any, and wait +5 minutes before trying again.');
						$this->response->statusCode(429);
						$this->render('/Errors/rate_limit');
						$this->response->send();
						$this->_stop();
					}
					Cache::write($rateKey, $count + 1, 'users');
				}

				// --- Block Suspicious Agents ---
				
				$ua = strtolower($userAgent);

				// Whitelist common crawlers
				$allowedBots = array('googlebot', 'bingbot', 'duckduckbot', 'yandexbot', 'baiduspider');

				$whitelisted = false;

				if (!empty($allowedBots) && is_array($allowedBots)) {
					foreach ($allowedBots as $allowed) {
						if (strpos($ua, $allowed) !== false) {
							$whitelisted = true;
							break;
						}
					}
				}

				if (!$whitelisted && preg_match('/curl|wget|bot|spider/i', $ua)) {
					
					// Write a lockout marker for 1 day
					Cache::write($lockKey, time(), 'bots'); // store timestamp

					// --- Logging suspicious agent ---
					App::uses('CakeLog', 'Log');

					CakeLog::write(
						'security',
						sprintf(
							"Suspicious agent blocked: IP=%s, UA=%s, Route=%s, Time=%s",
							$ip,
							$userAgent,
							strtolower($this->request->params['controller'] . '/' . $this->request->params['action']),
							date('Y-m-d H:i:s')
						)
					);

					$this->Flash->error('Automated requests are not allowed. You are locked out for 24 hours.');
					$this->set('message', 'Automated requests are not allowed. You are locked out for 24 hours.');
					$this->response->statusCode(403); // Forbidden
					$this->render('/Errors/error403');
					$this->response->send();
					$this->_stop();
				}

				// --- Improved Block Suspicious Payloads ---
				if (!empty($this->request->data)) {

					// Define closure by reference so recursion works in PHP 5.6
					$scanPayload = null;
					$scanPayload = function($data, $parentField = '') use (&$scanPayload, $ip, $userAgent, $lockKey) {
						foreach ($data as $field => $value) {
							$fullField = $parentField ? $parentField . '.' . $field : $field;

							if (is_array($value)) {
								// Recurse into nested arrays
								$scanPayload($value, $fullField);
							} else {
								if (is_string($value) && preg_match('/http[s]?:\/\/[^\s]+/i', $value)) {
									
									//IMPORTANT: Disable this or Optionally Lock the user for 5 minutes or change 'users' to bots to lock them for 24 hours
									Cache::write($lockKey, time(), 'bots'); 

									// --- Logging suspicious payload attempt ---
									App::uses('CakeLog', 'Log');
									CakeLog::write(
										'security',
										sprintf(
											"Suspicious payload blocked: IP=%s, UA=%s, Field=%s, Value=%s, Route=%s, Time=%s",
											$ip,
											$userAgent,
											$fullField,
											$value,
											strtolower($this->request->params['controller'] . '/' . $this->request->params['action']),
											date('Y-m-d H:i:s')
										)
									);

									$this->Flash->error('Links are not allowed in this field.');
									$this->set('message', 'Links are not allowed in this field.');
									$this->response->statusCode(403);
									$this->render('/Errors/error403');
									$this->response->send();
									$this->_stop();
								}
							}
						}
					};

					// Run scanner on request data
					$scanPayload($this->request->data);
				}

				//debug($count);
				//debug($ip);

			} else {
				if ($this->Session->check('Auth.User')) {
					// Reset counter for logged-in users
					// Cache::write($rateKey, 0, 'users');

					if (Cache::read($rateKey, 'users') !== false) {
						Cache::delete($rateKey, 'users');
					}

					if (Cache::read($lockKey, 'users') !== false) {
						Cache::delete($lockKey, 'users');
					}
				}
			}

			//debug($this->Session->read());
			//debug($ip);
			//debug($userAgent);
			//debug($accept);


			//// END SECURITY CHECK FOR FRONT FACING PUBLIC PAGES THAT DOESN"T NEED AUTHENTICATION
		}



		//$this->Auth->autoRedirect = false;
		//$this->Auth->userScope = array('User.active '=> 1);

		//$this->Auth->authError = __('<div class="warning-box warning-message"><span></span>You do not have permission to access the page you just selected.</div>');

		//Configure AuthComponent
		$prohibited_roles_to_access_this_host = array();

		if (gethostname() != 'KELI' && gethostname() != 'mistest' && gethostname() != 'smis') {
			//debug(gethostname());
			//debug($_SERVER['SERVER_NAME']);
			//$prohibited_roles_to_access_this_host = array(ROLE_STUDENT => ROLE_STUDENT/* , ROLE_INSTRUCTOR => ROLE_INSTRUCTOR */);
		}

		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login',
			'plugin' => false,
			'admin' => false
		);

		$this->Auth->logoutRedirect = array(
			'controller' => 'users',
			'action' => 'login'
		);

		$this->Auth->loginRedirect = array(
			'controller' => 'dashboard',
			'action' => 'index'
		);

		$auth = null;

		if ($this->Session->check('Auth.User')) {

			$auth = $this->Session->read('Auth.User');
			
			if (isset($auth) && !empty($auth)) {  

				if (!empty($prohibited_roles_to_access_this_host) && in_array($auth['role_id'], $prohibited_roles_to_access_this_host)) {
					$this->Flash->warning('You are not allowed to access this server ('.$_SERVER['SERVER_NAME'].'). Please use ' . PORTAL_URL_HTTPS . ' to access your account.');
					return $this->redirect($this->Auth->logout());
					//return $this->redirect(PORTAL_URL_HTTPS);
				}

				//debug(preg_replace('/[^-\.@_a-z0-9]/', '', strtolower($auth['username'])));
		
				$this->set('username', $auth['username']);
				$this->set('last_login', $auth['last_login']);
				$this->set('user_id', $auth['id']);
				$this->set('auto_messages', ClassRegistry::init('AutoMessage')->getMessages($auth['id']));
			
				//generate menu based on user privilage and save it to session 

				if (($auth['id'] && !$this->Session->read('permissionLists'))) {
					$aroKey = $auth;

					$permissionLists = ClassRegistry::init('User')->getAllPermissions($auth['id']);
				
					Configure::write('permissionLists', $permissionLists['permission']);
					Configure::write('PermissionLists.Perm', $permissionLists['permission']);
					Configure::write('reformatePermission', $permissionLists['reformatePermission']);

					$this->Session->write('permissionLists', $permissionLists['permission']);
					$this->Session->write('reformatePermission',$permissionLists['reformatePermission']);      
				}

				//save to the session the role of the user 
				$this->Session->write('role_id', $auth['role_id']);
				$this->role_id = $auth['role_id'];
			
				Configure::write('User.user', $auth['id']);
				Configure::write('User.role_id', $auth['role_id']);
				Configure::write('User.is_admin', $auth['is_admin']);
				Configure::write('User.active', $auth['active']);

				$this->set('user_full_name', $auth['full_name']);
				$this->Session->write('user_id', $auth['id']);

				//only query if the user details if not found in the session
				/* if (!$this->Session->read('users_relation')) {
					$this->Session->write('users_relation', ClassRegistry::init('User')->getUserDetails($auth['id']));
				} */

				//$userDetail = $this->Session->read('users_relation');

				if ($this->Session->check('users_relation')) {
					if ($auth['id'] === $this->Session->read('users_relation')['User']['id']) {
						$userDetail = $this->Session->read('users_relation');
					} else {
						$this->Session->destroy();
						$userDetail = array();
						$this->Flash->error('There is a conflicting session, Please close all open browser tabs that uses '.$_SERVER['SERVER_NAME'].' and login again.');
						return $this->redirect($this->Auth->logout());
					}
				} else {
					$userDetail = array();
					$this->Session->write('users_relation', ClassRegistry::init('User')->getUserDetails($auth['id']));
					$userDetail = $this->Session->read('users_relation');
				}

				// 1. Basic varibles are set to be visible by all controller of the application.
				// 2. To access the variable in any controller, use $this->variblename. Dont
				// 3. Dont forget to call parent::beforeFilter in your controller beforeFilter action, then all variable set in app controller will be used.
				// 4. To access it from view, just write $variablename

				/* if( $auth['id'] !== $this->Session->read('users_relation')['User']['id']){
					$this->Session->destroy();
					$this->Flash->error('There is a conflicting session, Please close all open browser tabs that uses '.$_SERVER['SERVER_NAME'].' and login again.');
					return $this->redirect($this->Auth->logout());
				} */

				//debug($userDetail);
					
				if (!empty($userDetail['Staff'][0])) {

					$this->staff_id = $userDetail['Staff'][0]['id'];

					if (isset($userDetail['Role']) && !empty($userDetail['Role'])) {
						$this->role_id = $userDetail['Role']['id'];
						$this->rolename = $userDetail['Role']['name'];
						$this->set('role_id', $userDetail['Role']['id']);
						$this->set('role_name', $userDetail['Role']['name']);
					}
					
					if (isset($userDetail['Staff'][0]['college_id']) && !empty($userDetail['Staff'][0]['college_id']) && isset($userDetail['Staff'][0]['department_id']) && !empty($userDetail['Staff'][0]['department_id'])) {

						$this->set('college_id', $userDetail['Staff'][0]['college_id']);
						$this->set('department_id', $userDetail['Staff'][0]['department_id']);
						$this->college_id = $userDetail['Staff'][0]['college_id'];
						$this->department_id = $userDetail['Staff'][0]['department_id'];

						if (isset($userDetail['Staff'][0]['College']) && !empty($userDetail['Staff'][0]['College']['name'])) {
							$this->set('college_name', $userDetail['Staff'][0]['College']['name']);
							$this->college_name = $userDetail['Staff'][0]['College']['name'];
						}

						if (isset($userDetail['Staff'][0]['Department']) && !empty($userDetail['Staff'][0]['Department']['name'])) {
							$this->set('department_name', $userDetail['Staff'][0]['Department']['name']);
							$this->department_name = $userDetail['Staff'][0]['Department']['name'];
						}

					} else if (isset($userDetail['Staff'][0]['college_id']) && !empty($userDetail['Staff'][0]['college_id'])) {

						$this->college_id = $userDetail['Staff'][0]['college_id'];
						$this->set('college_id', $userDetail['Staff'][0]['college_id']);

						if (isset($userDetail['Staff'][0]['College']) && !empty($userDetail['Staff'][0]['College']['name'])) {
							$this->set('college_name', $userDetail['Staff'][0]['College']['name']);
							$this->college_name = $userDetail['Staff'][0]['College']['name'];
						}
					}

					//debug($this->Session->read('Auth.User'));

					//registrar role

					/* if ($this->role_id == ROLE_REGISTRAR || $this->Session->read('Auth.User')['Role']['parent_id'] == ROLE_REGISTRAR) {
						if (isset($userDetail['StaffAssigne']['department_id']) && !empty($userDetail['StaffAssigne']['department_id'])) {
							$this->department_ids = unserialize($userDetail['StaffAssigne']['department_id']);
						} else if (isset($userDetail['StaffAssigne']['college_id']) && !empty($userDetail['StaffAssigne']['college_id'])) {
							$this->college_ids = unserialize($userDetail['StaffAssigne']['college_id']);
							$this->onlyPre = $userDetail['StaffAssigne']['collegepermission'];
						}

						if (!empty($userDetail['StaffAssigne']['program_id'])) {
							$this->program_ids = $this->program_id = unserialize($userDetail['StaffAssigne']['program_id']);
						}

						if (!empty($userDetail['StaffAssigne']['program_type_id'])) {
							$this->program_type_ids = $this->program_type_id = unserialize($userDetail['StaffAssigne']['program_type_id']);
						}
					} */

					//debug($userDetail['ApplicableAssignments']);

					$this->department_ids = $userDetail['ApplicableAssignments']['department_ids'];
					$this->college_ids = $userDetail['ApplicableAssignments']['college_ids'];
					$this->program_id = $this->program_ids = $userDetail['ApplicableAssignments']['program_ids'];
					$this->program_type_id = $this->program_type_ids = $userDetail['ApplicableAssignments']['program_type_ids'];
					$this->onlyPre = $userDetail['ApplicableAssignments']['college_permission'];
					$this->year_levels = $userDetail['ApplicableAssignments']['year_level_names'];

					$this->departments_college_ids = (isset($userDetail['ApplicableAssignments']['departments_college_ids']) && !empty($userDetail['ApplicableAssignments']['departments_college_ids']) ? $userDetail['ApplicableAssignments']['departments_college_ids'] : array());


					if ($this->onlyPre == 1) {
						$this->department_ids = array();
						$this->departments_college_ids = array();
					}

				} else if (!empty($userDetail['Student'][0]) && $this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
					
					$this->student_id = $userDetail['Student'][0]['id'];

					$this->set('college_id', $userDetail['Student'][0]['college_id']);
					$this->set('department_id', $userDetail['Student'][0]['department_id']);                     
					$this->college_id = $userDetail['Student'][0]['college_id'];                     
					$this->department_id = $userDetail['Student'][0]['department_id'];
					$this->program_id = $userDetail['Student'][0]['program_id'];
					$this->program_type_id = $userDetail['Student'][0]['program_type_id'];

					$this->set('program_id', $userDetail['Student'][0]['program_id']);
					$this->set('program_type_id', $userDetail['Student'][0]['program_type_id']);
					
					$this->last_section = $userDetail['ApplicableAssignments']['last_section'];

					if (isset($userDetail['Role']) && !empty($userDetail['Role'])) {
						$this->role_id = $userDetail['Role']['id'];
						$this->rolename = $userDetail['Role']['name'];
						$this->set('role_id', $userDetail['Role']['id']);
						$this->set('role_name', $userDetail['Role']['name']);
					}

					if (isset($userDetail['Student'][0]['College']) && !empty($userDetail['Student'][0]['College']['name'])) {
						$this->set('college_name', $userDetail['Student'][0]['College']['name']);
						$this->college_name = $userDetail['Student'][0]['College']['name'];
					}

					if (isset($userDetail['Student'][0]['Department']) && !empty($userDetail['Student'][0]['Department']['name'])) {
						$this->set('department_name', $userDetail['Student'][0]['Department']['name']);
						$this->department_name = $userDetail['Student'][0]['Department']['name'];
					}

					$this->department_ids = $userDetail['ApplicableAssignments']['department_ids'];
					$this->college_ids = $userDetail['ApplicableAssignments']['college_ids'];
					$this->program_ids = $userDetail['ApplicableAssignments']['program_ids'];
					$this->program_type_ids = $userDetail['ApplicableAssignments']['program_type_ids'];
					$this->onlyPre = $userDetail['ApplicableAssignments']['college_permission'];
					$this->year_levels = $userDetail['ApplicableAssignments']['year_level_names'];

					if ($this->onlyPre == 1) {
						$this->department_ids = array();
						$this->department_id = null;
					}

					
				} else if (!empty($userDetail['ApplicableAssignments'])) {
					
					$this->department_ids = (isset($userDetail['ApplicableAssignments']['department_ids']) && !empty($userDetail['ApplicableAssignments']['department_ids']) ? $userDetail['ApplicableAssignments']['department_ids'] : array());
					$this->college_ids = (isset($userDetail['ApplicableAssignments']['college_ids']) && !empty($userDetail['ApplicableAssignments']['college_ids']) ? $userDetail['ApplicableAssignments']['college_ids'] : array());
					$this->program_ids = (isset($userDetail['ApplicableAssignments']['program_ids']) && !empty($userDetail['ApplicableAssignments']['program_ids']) ? $userDetail['ApplicableAssignments']['program_ids'] : array());
					$this->program_type_ids = (isset($userDetail['ApplicableAssignments']['program_type_ids']) && !empty($userDetail['ApplicableAssignments']['program_type_ids']) ? $userDetail['ApplicableAssignments']['program_type_ids'] : array());
					$this->onlyPre = $userDetail['ApplicableAssignments']['college_permission'];
					$this->year_levels = (isset($userDetail['ApplicableAssignments']['year_level_names']) && !empty($userDetail['ApplicableAssignments']['year_level_names']) ? $userDetail['ApplicableAssignments']['year_level_names'] : array());

					$this->departments_college_ids = (isset($userDetail['ApplicableAssignments']['departments_college_ids']) && !empty($userDetail['ApplicableAssignments']['departments_college_ids']) ? $userDetail['ApplicableAssignments']['departments_college_ids'] : array());

					if ($this->onlyPre == 1) {
						$this->department_ids = array();
						$this->departments_college_ids = array();
					}
					
					if (isset($userDetail['Role']) && !empty($userDetail['Role'])) {
						$this->role_id = $userDetail['Role']['id'];
						$this->rolename = $userDetail['Role']['name'];
						$this->set('role_id', $userDetail['Role']['id']);
						$this->set('role_name', $userDetail['Role']['name']);
					}

				} else if (isset($userDetail['Role']) && !empty($userDetail['Role'])) {
					$this->role_id = $userDetail['Role']['id'];
					$this->rolename = $userDetail['Role']['name'];
					$this->set('role_id', $userDetail['Role']['id']);
					$this->set('role_name', $userDetail['Role']['name']);
				} else {

					if (count($this->uses) && $this->{$this->modelClass}->Behaviors->loaded('Logable')) {
						$activeUser = array('User' => array('id' => $auth['id'], 'username' => $auth['username']));
						$this->{$this->modelClass}->setUserData($activeUser);
						$this->{$this->modelClass}->setUserIp($this->modelClass, $this->_findIp()); 
					} 

					$this->Session->destroy();
					$userDetail = array();
					$this->Flash->error('There is a conflicting session, Please close all open browser tabs that uses '.$_SERVER['SERVER_NAME'].' and login again.');
					return $this->redirect($this->Auth->logout());

				}

				// merged to the last else in to if-else chain to prevent role rewrite , Neway
			
				// http://bakery.cakephp.org/articles/view/logablebehavior

				if (count($this->uses) && $this->{$this->modelClass}->Behaviors->loaded('Logable')) {

					$activeUser = array('User' => array('id' => $auth['id'], 'username' => $auth['username']));
							
					//$this->{$this->modelClass}->setUserData($this->modelClass,$activeUser);
					$this->{$this->modelClass}->setUserData($activeUser);
					$this->{$this->modelClass}->setUserIp($this->modelClass, $this->_findIp());
					/// needs some refinement for forwarded addresses if a load balancer is used.	 
				} 
			} else {
				// why we are logging not loggedin user ?? it increases the db size exponentially and not relevant. it  will also result in slow log table read time.
				if (count($this->uses) && $this->{$this->modelClass}->Behaviors->loaded('Logable')) {
					$this->{$this->modelClass}->setUserIp($this->modelClass, $this->_findIp());
				}
			}
		

			if (isset($auth) && !empty($auth)) {

				$user = ClassRegistry::init('User')->find('first', array('conditions' => array('User.id' => $auth['id']), 'recursive' => -1));

				unset($user['User']['password']);

				$first_time_login = 0;
				$password_duration_expired = false;
				$last_password_change_date = null;

				$email_verified = 0;
				$email_address = $user['User']['email'];
				$last_email_verified_date = null;
				$email_validation_expired = false;

				//Check if the user has to change his/her password
				$securitysetting = ClassRegistry::init('Securitysetting')->find('first');

				$password_to_change_date =  date('Y-m-d H:i:s', mktime (date('H'), date('i'), date('s'), date('n'), date('j') - $securitysetting['Securitysetting']['password_duration'], date('Y')));
				
				if (isset($user['User']['last_password_change_date']) && $password_to_change_date >  $user['User']['last_password_change_date']) {
					$password_duration_expired = true;
					$last_password_change_date = $user['User']['last_password_change_date'];
				}

				//Check if the user login is for the first time
				if (isset($user['User']['force_password_change']) && $user['User']['force_password_change'] == 1) {
					$first_time_login = 1;
				}
					
				if (isset($user['User']['force_password_change'])) {
					$this->set('force_password_change', $user['User']['force_password_change']);
				} else {
					$this->set('force_password_change', 0);
				}

				$this->set('first_time_login', $first_time_login);
				$this->set('password_duration_expired', $password_duration_expired);
				$this->set('last_password_change_date', $last_password_change_date);
				$this->set('password_duration', $securitysetting['Securitysetting']['password_duration']);

				if (isset($user['User']['id']) && !empty($user['User']['id']) && ($user['User']['force_password_change'] != 0 || $password_duration_expired) && strcasecmp($this->request->params['controller'], 'users') != 0  && strcasecmp($this->request->params['action'], 'changePwd') != 0) {
					return $this->redirect(array('controller' => 'users', 'action' => 'changePwd'));
				}

				if (FORCE_EMAIL_VERIFICATION && FORCE_EMAIL_VERIFICATION_AFTER_LOGIN) {
					if (!empty($user['User']['email'])) {
						$email_to_revalidate_date =  date('Y-m-d H:i:s', mktime (date('H'), date('i'), date('s'), date('n'), date('j') - DAYS_TO_ENFORCE_EMAIL_REVALIDATION, date('Y')));
						//debug($email_to_revalidate_date);
						//debug(DAYS_TO_ENFORCE_EMAIL_REVALIDATION);

						if (FORCE_EMAIL_VERIFICATION_FOR_ALL_ROLES == 0) {
							$roles_to_check = Configure::read('roles_for_email_verification');
							//debug($roles_to_check);
							if (in_array($auth['role_id'], $roles_to_check)) {
								if ($user['User']['email_verified'] == 0) {
									$email_validation_expired = true;
								} else if (isset($user['User']['last_email_verified_date']) && $email_to_revalidate_date >  $user['User']['last_email_verified_date']) {
									$email_validation_expired = true;
									$last_email_verified_date = $user['User']['last_email_verified_date'];
								} else if (!isset($user['User']['last_email_verified_date'])) {
									$email_validation_expired = true;
								} else {
									//$email_validation_expired = true;
								}
							}
						} else {
							if ($user['User']['email_verified'] == 0) {
								$email_validation_expired = true;
							} else if (isset($user['User']['last_email_verified_date']) && $email_to_revalidate_date >  $user['User']['last_email_verified_date']) {
								$email_validation_expired = true;
								$last_email_verified_date = $user['User']['last_email_verified_date'];
							} else if (!isset($user['User']['last_email_verified_date'])) {
								$email_validation_expired = true;
							} else {
								//$email_validation_expired = true;
							}
						}
					} else {
						$email_validation_expired = true;
					}

					if ($email_validation_expired) {
						if (empty($email_address) && isset($user['User']['id']) && !empty($user['User']['id']) && strcasecmp($this->request->params['controller'], 'users') != 0  && strcasecmp($this->request->params['action'], 'edit') != 0) {
							$this->Flash->info('Dear, ' . $user['User']['first_name']. ' you are required to have an email address inorder to use this platform, please provide a valid email address here and verify it.');
							return $this->redirect(array('controller' => 'users', 'action' => 'edit', $user['User']['id']));
						} else if (isset($user['User']['id']) && !empty($user['User']['id']) && strcasecmp($this->request->params['controller'], 'users') != 0  && strcasecmp($this->request->params['action'], 'edit') != 0) {
							$this->Flash->info('Dear, ' . $user['User']['first_name']. ' you are required to validate your email address every ' .DAYS_TO_ENFORCE_EMAIL_REVALIDATION . ' days to continue access to use this platform, Please verify your ' . $email_address . ' email address here.');
							return $this->redirect(array('controller' => 'users', 'action' => 'edit' , $user['User']['id']));
						}
					}
				}
				
				$studentnumber = null;

				if (!empty($this->request->data[$this->modelClass]['studentnumber']) || !empty($this->request->data[$this->modelClass]['studentID'])) {
					if (!empty($this->request->data[$this->modelClass]['studentnumber'])) {
						$studentnumber = $this->request->data[$this->modelClass]['studentnumber'];
					} else if(!empty($this->request->data[$this->modelClass]['studentID'])) {
						$studentnumber = $this->request->data[$this->modelClass]['studentID'];
					} 
				} else {
					if(!empty($this->request->data['Student']['studentnumber'])){
						$studentnumber = $this->request->data['Student']['studentnumber'];
					} else if(!empty($this->request->data['Student']['studentID'])) {
						$studentnumber = $this->request->data['Student']['studentID'];
					}
				}
					
				if ($studentnumber && (!in_array($auth['role_id'], array(ROLE_DEPARTMENT,ROLE_REGISTRAR))) && 0 ){
					
					$suspended = ClassRegistry::init('Student')->find('first', array(
						'conditions' => array(
							'Student.studentnumber' => $studentnumber,
							'Student.user_id in (select id from users where active=0)'
						), 'recursive' => -1
					));

					if ($suspended) {
						$this->set(compact('suspended'));
						return $this->redirect(array('controller' => 'users', 'action' => 'suspended', $suspended['Student']['user_id']));
					}
				}
					
				/* if ($this->role_id == ROLE_STUDENT &&  ){
					return $this->redirect(array('controller'=>'alumni','action' => "add"));
				} */
					
				/* if (isset($user['User']['id']) && !empty($user['User']['id']) 
					&& strcasecmp($this->request->params['controller'], 'alumni') != 0 
					&& strcasecmp($this->request->params['action'], 'add') != 0 
					&& $user['User']['role_id'] == ROLE_STUDENT
					&& ClassRegistry::init('Alumnus')->checkIfStudentGradutingClass($this->student_id) == true  
					&& ($user['User']['force_password_change'] != 0 || $password_duration_expired) 
					&& strcasecmp($this->request->params['controller'], 'users') != 0 
					&& strcasecmp($this->request->params['action'], 'changePwd') != 0 ) {
							
					if ( ClassRegistry::init('Alumnus')->completedRoundOneQuestionner($this->student_id) == false) {
						return $this->redirect(array('controller' => 'alumni', 'action' => 'add'));
					} 
							
				} */
			}
		} else {
			//$this->Session->destroy();
			//$this->Flash->info('You are required to login.');
		}
    }
}
