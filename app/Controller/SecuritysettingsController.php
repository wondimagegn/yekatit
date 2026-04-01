<?php
class SecuritysettingsController extends AppController {

	var $name = 'Securitysettings';
   
     var $menuOptions = array(
            
            // 'parent' => 'dashboard',
             'parent' => 'security',
             'exclude' => array('index'),
            'alias' => array(
                    'view_ss'=>'Security Settings',
            )
             
    );
    
    function permission_management() {
        /*
        $this->redirect(array(
                  'controller' => 'acls',
                  'action' => 'index',
                  'admin' => false,
                  'plugin' => false
        ));
	*/

	$this->redirect(array(
			 'plugin' => 'acls',
		          'controller' => 'acos',
		          'action' => 'index',
		         // 'admin' => false,
        ));
    }
    
	function index() {
		return $this->redirect(array('action' => 'view_ss'));
	}
	
	function view_ss() {
		$this->set('securitysetting', $this->Securitysetting->find('first'));
	}

	function edit() {
		if (!empty($this->request->data)) {
			if($this->request->data['Securitysetting']['minimum_password_length'] <= $this->request->data['Securitysetting']['maximum_password_length']) {
				if ($this->Securitysetting->save($this->request->data)) {
					$this->Session->setFlash('<span></span>'.__('Security settings has been updated'), 'default', array ('class' => 'success-box success-message'));
					return $this->redirect(array('action' => 'view_ss'));
				} else {
					$this->Session->setFlash('<span></span>'.__('Security settings could not be updated. Please, try again.'), 'default', array ('class' => 'error-box error-message'));
				}
			}
			else {
				$this->Session->setFlash('<span></span>'.__('Minimum password length can not be greater than maximum password length. Please, try again.'), 'default', array ('class' => 'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Securitysetting->find('first');
		}
		for($i = 8; $i <= 30; $i++) {
			$min_password_length[$i] = $i;
		}
		for($i = 10; $i <= 40; $i++) {
			$max_password_length[$i] = $i;
		}
		for($i = 30; $i <= 240; $i++) {
			$password_duration[$i] = $i.' Days';
		}
		for($i = 60; $i <= 240; $i++) {
			$session_duration[$i] = $i.' Minutes';
		}
		$password_strength[1] = 'Password should contain Uppercase Letters, Lowercase Letters, and Numbers.';
		$password_strength[2] = 'Password should contain Uppercase Letters, Lowercase Letters, Numbers and Symbols.';
		$this->set(compact('min_password_length', 'max_password_length', 'password_strength', 'password_duration', 'session_duration'));
	}

}
