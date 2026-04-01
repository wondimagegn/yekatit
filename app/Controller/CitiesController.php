<?php
class CitiesController extends AppController {

	var $name = 'Cities';
     var $menuOptions = array(
            'parent' => 'countries',
             'alias' => array(
                    'index'=>'View Cities',
                    'add'=>'Add City',
                )
    );
	function index() {
		$this->City->recursive = 0;
		$this->set('cities', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid city'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('city', $this->City->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The city has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The city could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		$regions = $this->City->Region->find('list');
		$this->set(compact('regions'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid city'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->City->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The city has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The city could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->City->read(null, $id);
		}
		$regions = $this->City->Region->find('list');
		$this->set(compact('regions'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for city'));
			return $this->redirect(array('action'=>'index'));
		}
		//check deletion is possible 
		if ($this->City->canItBeDeleted($id)) {
		    if ($this->City->delete($id)) {
			    $this->Session->setFlash('<span></span>'.__('City deleted'),
			    'default',array('class'=>'success-box success-message'));
			    $this->redirect(array('action'=>'index'));
		    }
		} else {
		   $this->Session->setFlash('<span></span>'.__('City was not deleted. It is related to student and contacts.'),
		'default',array('class'=>'error-box error-message'));   
		}
		$this->Session->setFlash('<span></span>'.__('City was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
}
