<?php
App::uses('AppController', 'Controller');
/**
 * PaymentMethods Controller
 *
 * @property PaymentMethod $PaymentMethod
 * @property PaginatorComponent $Paginator
 */
class PaymentMethodsController extends AppController
{
	var $name = 'PaymentMethods';
	var $menuOptions = array(
		'parent' => 'invoices',
		'alias' => array(
			'index' => 'View Payment Methods',
			'add' => 'Add Payment Method',

		)
	);


	public $helpers = array('Xls', 'Media.Media');

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(

			'view'
		);
	}
	function beforeRender()
	{
		parent::beforeRender();
	}

	public function index()
	{
		$this->PaymentMethod->recursive = 0;
		$this->set('paymentMethods', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null)
	{
		if (!$this->PaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid payment method'));
		}
		$options = array('conditions' => array('PaymentMethod.' . $this->PaymentMethod->primaryKey => $id), 'contain' => array('Attachment'));
		$this->set('paymentMethod', $this->PaymentMethod->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add()
	{


		if (!empty($this->request->data) && isset($this->request->data)) {
			$this->PaymentMethod->create();
			if ($this->PaymentMethod->duplication($this->request->data) == 0) {
				$this->request->data = $this->PaymentMethod->preparedAttachment($this->request->data);
				if ($this->PaymentMethod->saveAll($this->request->data, array('validate' => first))) {
					$this->Session->setFlash(
						'<span></span>' . __('The payment method has been saved'),
						'default',
						array('class' => 'success-box success-message')
					);
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<span></span>' . __('The payment method could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
				}
			} else {
				$this->Session->setFlash('<span></span>' . __('You have already recorded  payment method .'), 'default', array('class' => 'error-box error-message'));
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null)
	{
		if (!$this->PaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid payment method'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data = $this->PaymentMethod->preparedAttachment($this->request->data);
			if ($this->PaymentMethod->saveAll($this->request->data, array('validate' => first))) {
				$this->Session->setFlash(
					'<span></span>' . __('The payment method has been saved'),
					'default',
					array('class' => 'success-box success-message')
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>' . __('The payment method could not be saved. Please, try again.'), 'default', array('class' => 'error-box error-message'));
			}
		} else {
			$options = array('conditions' => array('PaymentMethod.' . $this->PaymentMethod->primaryKey => $id), 'contain' => array('Attachment'));
			$this->request->data = $this->PaymentMethod->find('first', $options);
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null)
	{
		if (!$this->PaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid payment method'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PaymentMethod->delete($id)) {
			$this->Session->setFlash(
				'<span></span>' . __('The payment method has been deleted.'),
				'default',
				array('class' => 'success-box success-message')
			);
		} else {
			$this->Session->setFlash(
				'<span></span>' . __('The payment method could not be deleted. Please, try again.'),
				'default',
				array('class' => 'error-box error-message')
			);
		}
		return $this->redirect(array('action' => 'index'));
	}
}