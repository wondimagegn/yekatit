<?php
App::uses('AppController', 'Controller');
class StaffStudiesController extends AppController
{
	public $helpers = array('Media.Media');
	public $menuOptions = array(
		'parent' => 'security',
		'exclude' => array('*'),
	);

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('add_staff_study');
	}

	public $components = array('Paginator');

	public function index()
	{
		$this->StaffStudy->recursive = 0;
		$this->set('staffStudies', $this->Paginator->paginate());
	}

	public function add()
	{
		if ($this->request->is('post')) {
			$this->StaffStudy->create();
			if ($this->StaffStudy->save($this->request->data)) {
				$this->Flash->success(__('The staff study has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The staff study could not be saved. Please, try again.'));
			}
		}

		//$staffs = $this->StaffStudy->Staff->find('list');
		$countries = $this->StaffStudy->Country->find('list');
		$this->set(compact('staffs', 'countries'));
	}

	public function edit($id = null)
	{
		if (!$this->StaffStudy->exists($id)) {
			throw new NotFoundException(__('Invalid staff study'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if (isset($this->request->data['Attachment']) && empty($this->request->data['Attachment'])) {
				unset($this->request->data['Attachment']);
			}
			if ($this->StaffStudy->save($this->request->data)) {
				$this->Flash->success(__('The staff study has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The staff study could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('StaffStudy.' . $this->StaffStudy->primaryKey => $id));
			$this->request->data = $this->StaffStudy->find('first', $options);
		}

		$staffs = $this->StaffStudy->Staff->find('list');
		$countries = $this->StaffStudy->Country->find('list');
		$this->set(compact('staffs', 'countries'));

	}

	public function delete($id = null)
	{
		$this->StaffStudy->id = $id;

		if (!$this->StaffStudy->exists()) {
			throw new NotFoundException(__('Invalid staff study'));
		}

		$this->request->allowMethod('post', 'delete');

		if ($this->StaffStudy->delete()) {
			$this->Flash->success(__('The staff study has been deleted.'));
		} else {
			$this->Flash->error(__('The staff study could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function add_staff_study($staff_id = null)
	{
		if ($this->request->is('post')) {

			$this->request->data = $this->StaffStudy->preparedAttachment($this->request->data, 'Commitement');

			if (isset($this->request->data['Attachment']) && empty($this->request->data['Attachment'])) {
				unset($this->request->data['Attachment']);
			}

			if (!isset($this->request->data['StaffStudy']['staff_id']) && empty($this->request->data['StaffStudy']['staff_id'])) {
				$this->StaffStudy->create();
			}

			debug($this->request->data);

			if ($this->StaffStudy->saveAll($this->request->data, array('validate' => 'first'))) {
				$this->Flash->success(__('Staff study has been saved.'));
			} else {
				$this->Flash->error(__('The staff study could not be saved. Please, try again.'));
			}
		}

		$this->redirect(array('controller' => 'staffs', 'action' => 'staff_profile', $this->request->data['StaffStudy']['staff_id']));
	}

	public function view($id = null)
	{
		if (!$this->StaffStudy->exists($id)) {
			throw new NotFoundException(__('Invalid staff study'));
		}

		$options = array('conditions' => array('StaffStudy.' . $this->StaffStudy->primaryKey => $id));
		//debug($this->StaffStudy->find('first', $options));
		$this->set('staffStudy', $this->request->data = $this->StaffStudy->find('first', $options));
	}
}