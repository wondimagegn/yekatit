<?php
class SecuritysettingsController extends AppController
{
	var $name = 'Securitysettings';

	var $menuOptions = array(
		'parent' => 'security',
		'exclude' => array('index'),
		'alias' => array(
			'view_ss' => 'Site Security Settings',
		)
	);

	function beforeFilter()
	{
		parent::beforeFilter();

		if ($this->Session->read('Auth.User')['is_admin'] != 1) {
			$this->Flash->warning('You are not authorized to view or manage security settings.');
			$this->redirect('/');
		} 
	}

	function beforeRender()
	{
		parent::beforeRender();
	}

	function permission_management()
	{
		$this->redirect(array(
			'plugin' => 'acls',
			'controller' => 'acos',
			'action' => 'index',
		));
	}

	function index()
	{
		return $this->redirect(array('action' => 'view_ss'));
	}

	function view_ss()
	{
		$password_strength[1] = 'Should Contain Uppercase Letters, Lowercase Letters and Numbers';
		$password_strength[2] = 'Should Containing Uppercase Letters, Lowercase Letters, Numbers and Symbols';

		$this->set('securitysetting', $this->Securitysetting->find('first'));
		$this->set(compact('password_strength'));
	}

	function edit()
	{
		if (!empty($this->request->data)) {
			if ($this->request->data['Securitysetting']['minimum_password_length'] <= $this->request->data['Securitysetting']['maximum_password_length']) {
				if ($this->Securitysetting->save($this->request->data)) {
					$this->Flash->success('Security settings has been updated.');
					return $this->redirect(array('action' => 'view_ss'));
				} else {
					$this->Flash->error('Security settings could not be updated. Please, try again.');
				}
			} else {
				$this->Flash->error('Minimum password length can not be greater than maximum password length. Please, try again.');
			}
		}
		
		if (empty($this->request->data)) {
			$this->request->data = $this->Securitysetting->find('first');
		}

		for ($i = 8; $i <= 30; $i++) {
			$min_password_length[$i] = $i;
		}

		for ($i = 8; $i <= 40; $i++) {
			$max_password_length[$i] = $i;
		}

		for ($i = 30; $i <= 240; $i++) {
			$password_duration[$i] = $i . ' Days';
		}
		
		for ($i = 30; $i <= 180; $i++) {
			$session_duration[$i] = $i . ' Minutes';
		}

		$password_strength[1] = 'Should Contain Uppercase Letters, Lowercase Letters and Numbers';
		$password_strength[2] = 'Should Containing Uppercase Letters, Lowercase Letters, Numbers and Symbols';
		$this->set(compact('min_password_length', 'max_password_length', 'password_strength', 'password_duration', 'session_duration'));
	}
}
