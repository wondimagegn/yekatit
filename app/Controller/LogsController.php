<?php
class LogsController extends AppController {

	var $name = 'Logs';
    var $menuOptions = array(
            
             //'parent' => 'dashboard',
             'parent'=>'security',
             'alias' => array(
			        'index' => 'View logs',
		    )
             
    );
  
    function __init_search() {
        // We create a search_data session variable when we fill any criteria 
        // in the search form.
        if(!empty($this->request->data['Log'])){
		     $search_session = $this->request->data['Log'];
		     // Session variable 'search_data'
		     $this->Session->write('log_search_data', $search_session);
        } else {
        	$search_session = $this->Session->read('log_search_data');
        	$this->request->data['Log'] = $search_session;
        } 
    }
    
	function index() {
	    $this->__init_search();	
		if (!empty($this->request->data)) {
		    $this->paginate['limit'] = $this->request->data['Log']['size'];
			$this->paginate['order'] = array('Log.created DESC');
			
		   if(!empty($this->request->data['Log']['role_id']) && $this->request->data['Log']['role_id'] != 0 && empty($this->request->data['Log']['username'])) {
				$this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE role_id = \''.$this->request->data['Log']['role_id'].'\')');
			}
		   if(!empty($this->request->data['Log']['change'])) {
				$this->paginate['conditions'][] = array('Log.change LIKE' => '%'.$this->request->data['Log']['change'].'%');
			}
		   if(!empty($this->request->data['Log']['key'])) {
				$this->paginate['conditions'][] = array('Log.foreign_key LIKE' => '%'.$this->request->data['Log']['key'].'%');
			}
		   if(!empty($this->request->data['Log']['description'])) {
				$this->paginate['conditions'][] = array('Log.description LIKE' => '%'.$this->request->data['Log']['description'].'%');
			}
			if($this->request->data['Log']['deactive'] == 0 && $this->request->data['Log']['active'] == 1) {
				$this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE active = 1)');
				
			}
			if($this->request->data['Log']['active'] == 0 && $this->request->data['Log']['deactive'] == 1) {
			    $this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE active = 0)');
			}
			if(!empty($this->request->data['Log']['username'])) {
			    $users = explode(',', $this->request->data['Log']['username']);
			    $include_users = array();
			    $exclude_users = array();
			    foreach($users as $user) {
			    	if(substr(trim($user), 0, 1) == '-') {
			    		$exclude_users[] = addslashes(substr(trim($user), 1));
			    	}
			    	else {
			    		$include_users[] = addslashes(trim($user));
			    	}
			    }
			    if(!empty($include_users)) {
			    	if(count($include_users) == 1) {
			    		$this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username = \''.$include_users[0].'\')');
			    	}
			    	else {
			    		$include_users_s = implode("', '", $include_users);
			    		$include_users_s = "('".$include_users_s."')";
			    		$this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username IN '.$include_users_s.')');
			    	}
			    }
			    if(!empty($exclude_users)) {
			    	if(count($exclude_users) == 1)
			    		$this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username <> \''.$exclude_users[0].'\')');
			    	else {
			    		$exclude_users_s = implode("', '", $exclude_users);
			    		$exclude_users_s = "('".$exclude_users_s."')";debug($exclude_users_s);
			    		$this->paginate['conditions'][] = array('Log.user_id IN (SELECT id FROM users WHERE username NOT IN '.$exclude_users_s.')');
			    	}
			    }
			}
			if(!empty($this->request->data['Log']['ip'])) {
			    $ips = explode(',', $this->request->data['Log']['ip']);
			    $include_ips = array();
			    $exclude_ips = array();
			    foreach($ips as $ip) {
			    	if(substr(trim($ip), 0, 1) == '-') {
			    		$exclude_ips[] = substr(trim($ip), 1);
			    	}
			    	else {
			    		$include_ips[] = trim($ip);
			    	}
			    }
			    if(!empty($include_ips)) {
			    	if(count($include_ips) == 1) {
			    		$this->paginate['conditions'][] = array('Log.ip' =>  $include_ips[0]);
			    	}
			    	else {
			    		$this->paginate['conditions'][] = array('Log.ip' =>  $include_ips);
			    	}
			    }
			    if(!empty($exclude_ips)) {
			    	if(count($exclude_ips) == 1)
			    		$this->paginate['conditions'][] = array('Log.ip <> ' =>  $exclude_ips[0]);
			    	else
			    		$this->paginate['conditions'][] = array('Log.ip NOT ' =>  $exclude_ips);
			    }
			}
			if(!empty($this->request->data['Log']['action'])) {
			    $actions = explode(',', $this->request->data['Log']['action']);
			    $include_actions = array();
			    $exclude_actions = array();
			    foreach($actions as $action) {
			    	if(substr(trim($action), 0, 1) == '-') {
			    		$exclude_actions[] = substr(trim($action), 1);
			    	}
			    	else {
			    		$include_actions[] = trim($action);
			    	}
			    }
			    if(!empty($include_actions)) {
			    	if(count($include_actions) == 1) {
			    		$this->paginate['conditions'][] = array('Log.action' =>  $include_actions[0]);
			    	}
			    	else {
			    		$this->paginate['conditions'][] = array('Log.action' =>  $include_actions);
			    	}
			    }
			    if(!empty($exclude_actions)) {
			    	if(count($exclude_actions) == 1)
			    		$this->paginate['conditions'][] = array('Log.action <> ' =>  $exclude_actions[0]);
			    	else
			    		$this->paginate['conditions'][] = array('Log.action NOT ' =>  $exclude_actions);
			    }
			}
			if(!empty($this->request->data['Log']['model'])) {
			    $models = explode(',', $this->request->data['Log']['model']);
			    $include_models = array();
			    $exclude_models = array();
			    foreach($models as $model) {
			    	if(substr(trim($model), 0, 1) == '-') {
			    		$exclude_models[] = substr(trim($model), 1);
			    	}
			    	else {
			    		$include_models[] = trim($model);
			    	}
			    }
			    if(!empty($include_models)) {
			    	if(count($include_models) == 1) {
			    		$this->paginate['conditions'][] = array('Log.model' =>  $include_models[0]);
			    	}
			    	else {
			    		$this->paginate['conditions'][] = array('Log.model' =>  $include_models);
			    	}
			    }
			    if(!empty($exclude_models)) {
			    	if(count($exclude_models) == 1)
			    		$this->paginate['conditions'][] = array('Log.model <> ' =>  $exclude_models[0]);
			    	else
			    		$this->paginate['conditions'][] = array('Log.model NOT ' =>  $exclude_models);
			    }
			}
			$change_date_from = $this->request->data['Log']['change_date_from'];
			$change_date_to = $this->request->data['Log']['change_date_to'];
			$this->paginate['conditions'][] = array('Log.created >= \''.$change_date_from['year'].'-'.$change_date_from['month'].'-'.$change_date_from['day'].'\'');
			$this->paginate['conditions'][] = array(' date(Log.created) <= \''.$change_date_to['year'].'-'.$change_date_to['month'].'-'.$change_date_to['day'].'\'');
			$this->paginate['contain'] = array('User' => array('fields' => 'id', 'username', 'first_name', 'middle_name', 'last_name'));
			//$this->paginate['reset']=false;
			//debug($this->paginate['conditions']);
			$logs = $this->paginate();
			//debug($logs);
			if (empty($logs)) {
			  $this->Session->setFlash('<span></span>'.__('There is no logs in the given criteria.'), 'default',array('class'=>'info-message info-box'));
			}
			$this->set(compact('logs'));
		}
		
		$roles = $this->Log->User->Role->find('list',
			array(
				'conditions' =>
				array(
					'Role.id <> ' => ROLE_CONTINUINGANDDISTANCEEDUCTIONPROGRAM
				)
			)
		);
		$roles = array('0' => '--- All ---') + $roles;
		$this->set(compact('roles'));
	    
	}

}
