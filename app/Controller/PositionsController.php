<?php
class PositionsController extends AppController {

	var $name = 'Positions';
     var $menuOptions = array(
            'parent' => 'mainDatas',
             'alias' => array(
                    'index'=>'View Position',
                    'add'=>'Add Position',
                )
    );
	function index() {
		$this->Position->recursive = 0;
		$this->set('positions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid position'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('position', $this->Position->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Position->create();
			if ($this->Position->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The position has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The position could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid position'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Position->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The position has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The position could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Position->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for position'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Position->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Position deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<span></span>'.__('Position was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
}
