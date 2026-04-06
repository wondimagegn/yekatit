<?php
class ProgramTypesController extends AppController {

	var $name = 'ProgramTypes';
	var $menuOptions = array(
		'parent' => 'dashboard',
		'exclude' => array('index'),
		'alias' => array(
			//'index' => 'View All Program Types',
			'map_program_types' => 'Map program types',
		)
	);
    
    function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('get_program_types');
	}
   
	function index() 
	{
		$this->ProgramType->recursive = 0;
		$this->set('programTypes', $this->paginate());
	}

	function view($id = null)
	{
		if (!$id) {
			$this->Flash->error(__('Invalid program type'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->ProgramType->recursive = -1;
		$this->set('programType', $this->ProgramType->read(null, $id));
	}

	function add()
	{
		if (!empty($this->request->data)) {
			$this->ProgramType->create();
			if ($this->ProgramType->save($this->request->data)) {
				$this->Flash->success(__('The program type has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The program type could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) 
	{
		if (!$id && empty($this->request->data)) {
			$this->Flash->error(__('Invalid program type'));
			return $this->redirect(array('action' => 'index'));
		}

		if (!empty($this->request->data)) {
			/* if ($this->ProgramType->save($this->request->data)) {
				$this->Flash->success(__('The program type has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The program type could not be saved. Please, try again.'));
			} */
		}

		if (empty($this->request->data)) {
			$this->ProgramType->recursive = -1;
			$this->request->data = $this->ProgramType->read(null, $id);
		}
	}

	function delete($id = null) 
	{
		if (!$id) {
			$this->Flash->error(__('Invalid id for program type'));
			return $this->redirect(array('action' => 'index'));
		}

		// prevent program type delete, just incase it is assigned to users
		/* if ($this->ProgramType->delete($id)) {
			$this->Flash->success(__('Program type deleted'));
			return $this->redirect(array('action' => 'index'));
		}

		$this->Flash->error(__('Program type was not deleted')); */

		return $this->redirect(array('action' => 'index'));
	}
	
	function map_program_types()
	{
		if (!empty($this->request->data)) {
			debug($this->request->data);
			if (!empty($this->request->data['ProgramType']['program_type_id']) && !empty($this->request->data['ProgramType']['equivalent_to_id'])) {
				$this->request->data['ProgramType']['id'] = $this->request->data['ProgramType']['program_type_id'];
				$this->request->data['ProgramType']['equivalent_to_id'] = serialize($this->request->data['ProgramType']['equivalent_to_id']);
				unset($this->request->data['ProgramType']['program_type_id']);
				
				if ($this->ProgramType->save($this->request->data)) {
					$this->Flash->success(__('The program type has been mapped.'));
					//$this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->error(__('The program type map could not be saved. Please, try again.'));
				}
			} else {
				$this->Flash->error(__('The program type map could not be saved. Please, try again.'));
			}
		}

		$programTypes = $this->ProgramType->find('list');

		$this->set(compact('programTypes'));
	}

	function get_program_types($program_type_id = null)
	{
		$this->layout = 'ajax';

		$othersprogramTypes = array();
		$selectedEquivalents = array();

		if (!empty($program_type_id)) {
			$othersprogramTypes = $this->ProgramType->find('list', array('conditions' => array('ProgramType.id <> ' => $program_type_id/* , 'ProgramType.active' => 1 */)));

			// Retrieve the serialized `equivalent_to_id` field
			$programTypeSelected = $this->ProgramType->find('first', array('conditions' => array('ProgramType.id' => $program_type_id), 'fields' => array('ProgramType.equivalent_to_id'), 'recursive' => -1));
			
			if (!empty($programTypeSelected['ProgramType']['equivalent_to_id'])) {
				$selectedEquivalents = unserialize($programTypeSelected['ProgramType']['equivalent_to_id']);
			}
		}

		$this->set(compact('othersprogramTypes', 'selectedEquivalents'));

	}
	
}
