<?php
class ProgramsController extends AppController {

	var $name = 'Programs';

	function index() {
		$this->Program->recursive = 0;
		$this->set('programs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid program'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('program', $this->Program->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Program->create();
			if ($this->Program->save($this->request->data)) {
				$this->Session->setFlash(__('The program has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The program could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid program'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Program->save($this->request->data)) {
				$this->Session->setFlash(__('The program has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The program could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Program->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for program'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->Program->delete($id)) {
			$this->Session->setFlash(__('Program deleted'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Program was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
