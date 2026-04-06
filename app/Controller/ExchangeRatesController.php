<?php
App::uses('AppController', 'Controller');
/**
 * ExchangeRates Controller
 *
 * @property ExchangeRate $ExchangeRate
 * @property PaginatorComponent $Paginator
 */
class ExchangeRatesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ExchangeRate->recursive = 0;
		$this->set('exchangeRates', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ExchangeRate->exists($id)) {
			throw new NotFoundException(__('Invalid exchange rate'));
		}
		$options = array('conditions' => array('ExchangeRate.' . $this->ExchangeRate->primaryKey => $id));
		$this->set('exchangeRate', $this->ExchangeRate->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ExchangeRate->create();
			if ($this->ExchangeRate->save($this->request->data)) {
				$this->Session->setFlash(__('The exchange rate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exchange rate could not be saved. Please, try again.'));
			}
		}
		$fromCurrencies = $this->ExchangeRate->FromCurrency->find('list');
		$toCurrencies = $this->ExchangeRate->ToCurrency->find('list');
		$this->set(compact('fromCurrencies', 'toCurrencies'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ExchangeRate->exists($id)) {
			throw new NotFoundException(__('Invalid exchange rate'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ExchangeRate->save($this->request->data)) {
				$this->Session->setFlash(__('The exchange rate has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exchange rate could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ExchangeRate.' . $this->ExchangeRate->primaryKey => $id));
			$this->request->data = $this->ExchangeRate->find('first', $options);
		}
		$fromCurrencies = $this->ExchangeRate->FromCurrency->find('list');
		$toCurrencies = $this->ExchangeRate->ToCurrency->find('list');
		$this->set(compact('fromCurrencies', 'toCurrencies'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ExchangeRate->id = $id;
		if (!$this->ExchangeRate->exists()) {
			throw new NotFoundException(__('Invalid exchange rate'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ExchangeRate->delete()) {
			$this->Session->setFlash(__('The exchange rate has been deleted.'));
		} else {
			$this->Session->setFlash(__('The exchange rate could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
