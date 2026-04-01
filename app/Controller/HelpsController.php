<?php
class HelpsController extends AppController {

	public $name = 'Helps';
	public $helpers = array('Media.Media');
    public $menuOptions = array(
            'parent'=>'dashboard',
			'alias' => array(
                    'index' => 'View Helps',
            )
    );
    public $paginate=array();
	public function index() {
		$this->Help->recursive = 1;
		$this->paginate = array('order' => 
			array(
				'Help.created DESC','Help.order ASC'),'limit'=>50,
			'contain'=>array('Attachment')
		);
		$this->Paginator->settings=$this->paginate;
		$helps = $this->Paginator->paginate('Help');
		foreach($helps as $k => $v) {
			$admin_ids = explode(',', $v['Help']['target']);
			if(!in_array(Configure::read('User.role_id'), $admin_ids)) {
				unset($helps[$k]);
			}
		}
		
		$this->set(compact('helps'));
	}

	public function add() {
		if (!empty($this->request->data)) {
		   
			$this->request->data['Help']['target'] = implode(',', $this->request->data['Help']['target']);
			$this->Help->create();
			
			$this->request->data=$this->Help->preparedAttachment($this->request->data);
			
			if ($this->Help->saveAll($this->request->data,array('validate'=>'first'))) {
				$this->Session->setFlash('<span></span>'.__('The help has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The help could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
				$targets=explode(',',$this->request->data['Help']['target']);
				$this->request->data['Help']['target']=$targets;
				
			}
			
		}
     $roles = ClassRegistry::init('Role')->find('list');
    
     $this->set(compact('roles'));
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid help'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			$this->request->data['Help']['target'] = implode(',', $this->request->data['Help']['target']);
			if ($this->Help->save($this->request->data)) {
				$this->Session->setFlash(__('The help has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The help could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Help->read(null, $id);
			$this->request->data['Help']['target'] = explode(',', $this->request->data['Help']['target']);
		}
     $roles = ClassRegistry::init('Role')->find('list');
     $this->set(compact('roles'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for help'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Help->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Help deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<span></span>'.__('Help was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
}
