<?php
class CollegesController extends AppController {

	var $name = 'Colleges';
    var $menuOptions = array(
             'parent' => 'campuses',
             'exclude' => array('index', 'delegate_scale','registrar_delegate_scale'),
             'alias' => array(
                    'add' => 'Add College',
                    'delegate_scale'=>'Delegate Scale',
            )
    );
 
	function index() {
		$this->College->recursive = 0;
		$this->set('colleges', $this->paginate());
	}
        
    function beforeFilter(){
        parent::beforeFilter();
       
    }
    
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid college'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		
		$this->College->id = $id;
		if(!$this->College->exists()) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for college'), 'default', array('class' => 'error-message error-box'));
			
			return $this->redirect(array('action' => 'index'));
		}
		
		$this->set('college', $this->College->read(null, $id));
	}

	function add() {
		$this->set($this->request->data);
		if (!empty($this->request->data)) {
			$this->College->create();
			if ($this->College->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The college has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The college could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		$campuses = $this->College->Campus->find('list');
		
		$this->set(compact('campuses', 'students'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid college'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		
		$this->College->id = $id;
		if(!$this->College->exists()) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for college'), 'default', array('class' => 'error-message error-box'));
			
			return $this->redirect(array('action' => 'index'));
		}
		
		$this->set($this->request->data);
		if (!empty($this->request->data)) {
			if ($this->College->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The college has been updated.'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The college could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->College->read(null, $id);
		}
		$campuses = $this->College->Campus->find('list');
		
		$this->set(compact('campuses', 'students'));
	}
    function delegate_scale() {
    
		if (!empty($this->request->data)) {
			if ($this->College->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('Delegation of grade scale has been successful.'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The scale delegation couldnt be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
		    
			$this->request->data = $this->College->find('first',array('conditions'=>array('College.id'=>
			$this->college_id),'contain'=>array('Campus'=>array('fields'=>array('id','name')),'Department'=>array('fields'=>array('id','name')))));
		}
		$campuses = $this->College->Campus->find('list');
		$this->set(compact('campuses'));
    }
   
    function registrar_delegate_scale () {
        if (!empty($this->request->data) && isset($this->request->data['update'])) {
			if ($this->College->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('Delegation of grade scale has been successful.'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The scale delegation couldnt be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (!empty($this->request->data) && isset($this->request->data['continue'])) {
		    if (!empty($this->request->data['Search']['college_id'])) {
			    $this->request->data = $this->College->find('first',
			    array('conditions'=>array('College.id'=>$this->request->data['Search']['college_id']),'contain'=>array('Campus'=>array('fields'=>array('id','name')),'Department'=>array('fields'=>array('id','name')))));
		    }
		    
		}
		
        $colleges=$this->College->find('list');
        $campuses = $this->College->Campus->find('list');
		$this->set(compact('campuses','colleges'));
    }
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for college'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->College->id = $id;
		if(!$this->College->exists()) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for college'), 'default', array('class' => 'error-message error-box'));
			
			return $this->redirect(array('action' => 'index'));
		}
		if($this->College->canItBeDeleted($id)) {
		   if ($this->College->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('College deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		  }
		}
		
		$this->Session->setFlash('<span></span>'.__('College was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
}
