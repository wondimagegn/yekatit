<?php
App::uses('AppController', 'Controller');
/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 */
class TransactionsController extends AppController {

    public $name = 'Transactions';
    public $menuOptions = array(
        'parent'=>'invoices',
        'exclude' => array('search', 'accepted_document', 'get_department_combo'),
        'alias' => array(
            'index' => 'View Transactions',
            'generate' => 'Generate Transactions',
        )
    );

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('generate');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Transaction->recursive = 0;
		$this->set('transactions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Transaction->exists($id)) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
		$this->set('transaction', $this->Transaction->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function generate() {
		if ($this->request->is('post')) {
			$this->Transaction->create();
			if ($this->Transaction->save($this->request->data)) {
				$this->Session->setFlash(__('The transaction has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transaction could not be saved. Please, try again.'));
			}
		}
		$invoices = $this->Transaction->Invoice->find('list');
		$currencies = $this->Transaction->Currency->find('list');
		$methods = $this->Transaction->Method->find('list');
		$this->set(compact('invoices',  'currencies', 'methods'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Transaction->id = $id;
		if (!$this->Transaction->exists()) {
			throw new NotFoundException(__('Invalid transaction'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Transaction->delete()) {
			$this->Session->setFlash(__('The transaction has been deleted.'));
		} else {
			$this->Session->setFlash(__('The transaction could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
