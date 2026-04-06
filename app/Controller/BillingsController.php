<?php
class BillingsController extends AppController
{
    var $name = "Billings";
    var $uses = array();
    var $menuOptions = array(
        'weight' => 500,
        //'exclude' => array('index'),
        'alias' => array(
			'index' => 'Fee Settings'
		)
    );


    function beforeRender()
    {
    }
    function beforeFilter()
    {
        parent::beforeFilter();
    }


    function index()
    {
        if (($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR && $this->Session->read('Auth.User')['is_admin'] == 1) || $this->Session->read('Auth.User')['role_id'] == ROLE_SYSADMIN) {
            return $this->redirect(array('controller' => 'fee_settings', 'action' => 'index'));
        } else {
            $this->Flash->error('You are not authorized to access this page.');
            return $this->redirect('/');
        }
    }
}