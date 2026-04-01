<?php
App::uses('AppController', 'Controller');
/**
 * GeneralSettings Controller
 *
 * @property GeneralSetting $GeneralSetting
 * @property PaginatorComponent $Paginator
 */
class GeneralSettingsController extends AppController {

	  public $menuOptions = array(
            
             'parent' => 'dashboard',
             'alias' => array(
                    'index'=>'View General Settings',
                    'add'=>'Set GeneralSettings',

            )
    );

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	 public function beforeFilter() {
	     parent::beforeFilter();
	    $this->Auth->Allow();
	
     }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		debug($this->GeneralSetting->notifyStudentsGradeByEmail(2));
		$this->GeneralSetting->recursive = 0;
        $generalSetting=$this->Paginator->paginate();
		foreach ($generalSetting as $ack=>&$ackv) {
			$programs = $this->GeneralSetting->Program->find('list',array('conditions'=>array('id'=>unserialize($ackv['GeneralSetting']['program_id']))));
			$programTypes = $this->GeneralSetting->ProgramType->find('list',array('conditions'=>array('id'=>unserialize($ackv['GeneralSetting']['program_type_id']))));
			 
			 $ackv['GeneralSetting']['program_id']=array_values($programs);
			  $ackv['GeneralSetting']['program_type_id']=array_values($programTypes);
		}
		
		$this->set('generalSettings',$generalSetting);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->GeneralSetting->exists($id)) {
			throw new NotFoundException(__('Invalid general setting'));
		}
		$options = array('conditions' => array('GeneralSetting.' . $this->GeneralSetting->primaryKey => $id));
		$generalSetting = $this->GeneralSetting->find('first', $options);
		$generalSetting['GeneralSetting']['program_type_id']=unserialize($generalSetting['GeneralSetting']['program_type_id']);
		$generalSetting['GeneralSetting']['program_id']=unserialize($generalSetting['GeneralSetting']['program_id']);

		$this->set('generalSetting', $generalSetting);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->GeneralSetting->create();
			$this->request->data['GeneralSetting']['program_id']=serialize($this->request->data['GeneralSetting']['program_id']);
			$this->request->data['GeneralSetting']['program_type_id']=serialize($this->request->data['GeneralSetting']['program_type_id']);
			if ($this->GeneralSetting->save($this->request->data)) {
				
				$this->Session->setFlash('<span></span>'.__('The general setting has been saved..'),'default',array('class'=>'success-box success-message'));

				return $this->redirect(array('action' => 'index'));
			} else {
				
				$this->Session->setFlash('<span></span>'.__('The general setting could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
			$this->request->data['GeneralSetting']['program_id']=unserialize($this->request->data['GeneralSetting']['program_id']);
			$this->request->data['GeneralSetting']['program_type_id']=unserialize($this->request->data['GeneralSetting']['program_type_id']);
			
		}
		$programs = $this->GeneralSetting->Program->find('list');
		$programTypes = $this->GeneralSetting->ProgramType->find('list');
		$this->set(compact('programs', 'programTypes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->GeneralSetting->exists($id)) {
			throw new NotFoundException(__('Invalid general setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['GeneralSetting']['program_id']=serialize($this->request->data['GeneralSetting']['program_id']);
			$this->request->data['GeneralSetting']['program_type_id']=serialize($this->request->data['GeneralSetting']['program_type_id']);

			if ($this->GeneralSetting->save($this->request->data)) {
				
				$this->Session->setFlash('<span></span>'.__('The general setting has been saved.'),'default',array('class'=>'success-box success-message'));

				return $this->redirect(array('action' => 'index'));
			} else {
				
				$this->Session->setFlash('<span></span>'.__('The general setting could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		} else {
			$options = array('conditions' => array('GeneralSetting.' . $this->GeneralSetting->primaryKey => $id));
			$this->request->data = $this->GeneralSetting->find('first', $options);
			$this->request->data['GeneralSetting']['program_id']=unserialize($this->request->data['GeneralSetting']['program_id']);
			$this->request->data['GeneralSetting']['program_type_id']=unserialize($this->request->data['GeneralSetting']['program_type_id']);
		}
		$programs = $this->GeneralSetting->Program->find('list');
		$programTypes = $this->GeneralSetting->ProgramType->find('list');
		$this->set(compact('programs', 'programTypes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->GeneralSetting->id = $id;
		if (!$this->GeneralSetting->exists()) {
			throw new NotFoundException(__('Invalid general setting'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->GeneralSetting->delete()) {
			
			$this->Session->setFlash('<span></span>'.__('The general setting has been deleted.'),'default',array('class'=>'success-box success-message'));
		} else {
			$this->Session->setFlash('<span></span>'.__('The general setting could not be deleted. Please, try again.'),'default',array('class'=>'success-box success-message'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
