<?php
App::uses('AppController', 'Controller');
class FeeSettingsController extends AppController
{
    public $name = 'FeeSettings';
    public $menuOptions = array(
        'parent'=>'billing',
        'alias' => array(
            'index'=>'View Category and Fee',
            'add_category'=>'Add Category',
            'add_fee_type'=>'Add Fee Type',

        )
    );
    public $components =array('AcademicYear');
    public function beforeFilter()
    {

        parent::beforeFilter();
        /* $this->Auth->allow(
            'index',
            'edit_category',
            'add_category',
            'delete_category',
            'edit_category_fee_types',
            'add_fee_type', 
            'add_category_fee_types',
            'edit_category_fee_types',
            'add_fee_types'
        ); */
    }
    public function index($tab = 'categories') {
        $validTabs = array('categories', 'fee_types', 'currencies', 'methods', 'exchange_rates');
        if (!in_array($tab, $validTabs)) {
            $tab = 'categories';
        }
        $this->set('activeTab', $tab);

        // Fee Categories
        $this->loadModel('FeeCategory');
        $this->FeeCategory->recursive = 0;
        $this->set('feeCategories', $this->paginate('FeeCategory'));

        // Fee Types
        $this->loadModel('FeeType');
        $this->FeeType->recursive = 0;
        $this->set('feeTypes', $this->paginate('FeeType'));
        $this->set('currencies', $this->FeeType->PaymentCurrency->find('list'));
        $this->set('categories', $this->FeeType->FeeCategory->find('list'));

        // Payment Currencies
        $this->loadModel('PaymentCurrency');
        $this->PaymentCurrency->recursive = 0;
        $this->set('paymentCurrencies', $this->paginate('PaymentCurrency'));

        // Payment Methods
        $this->loadModel('PaymentMethod');
        $this->PaymentMethod->recursive = 0;
        $this->set('paymentMethods', $this->paginate('PaymentMethod'));

        // Exchange Rates
        $this->loadModel('ExchangeRate');
        $this->ExchangeRate->recursive = 0;
        $this->set('exchangeRates', $this->paginate('ExchangeRate'));
    }
    public function add_category()
    {

        $this->loadModel('FeeCategory');
        if ($this->request->is('post')) {
            $this->FeeCategory->create();
            if ($this->FeeCategory->save($this->request->data)) {

                $this->Flash->success('FFee category created.');

                $this->redirect(array('action' => 'index', 'categories'));
            } else {
                $this->Flash->error('Failed to create fee category.');

            }
        }
    }
    public function edit_category($id = null)
    {

        $this->loadModel('FeeCategory');
        $feeCategory = $this->FeeCategory->findById($id);
        if (!$feeCategory) {
            throw new NotFoundException(__('Invalid fee category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->FeeCategory->id = $id;
            if ($this->FeeCategory->save($this->request->data)) {

                $this->Flash->success('Fee category updated.');

                $this->redirect(array('action' => 'index', 'categories'));
            } else {

                $this->Flash->error('FFee category updated.');

            }
        }
        $this->request->data = $feeCategory;
    }

    public function delete_category($id = null)
    {

        $this->loadModel('FeeCategory');
        $this->FeeCategory->id = $id;
        if (!$this->FeeCategory->exists()) {
            throw new NotFoundException(__('Invalid fee category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->FeeCategory->delete()) {
            $this->Flash->success('Fee category and its related fee type is deleted.');

        } else {

            $this->Flash->error('Failed to delete fee category');
            

        }
        $this->redirect(array('action' => 'index', 'categories'));
    }



    // Bulk add fee types for a category (dynamic form)
    public function add_fee_types($category_id = null) {
        $this->loadModel('FeeType');
        if ($this->request->is('post')) {
            if ($category_id) {
                foreach ($this->request->data['FeeType'] as &$feeType) {
                    $feeType['category_id'] = $category_id;
                    if (!empty($feeType['computation_rule'])) {
                        if (!json_decode($feeType['computation_rule'], true)) {
                            $this->Session->setFlash(__('Invalid computation rule JSON in one or more fee types.'), 'default', array('class' => 'error'));
                            return;
                        }
                    }
                }
            }
            if ($this->FeeType->saveAll($this->request->data['FeeType'])) {

                $this->Flash->success('Fee types created');

                $this->redirect(array('action' => 'index', 'fee_types'));
            } else {

                $this->Flash->error('Failed to create fee types.');

            }
        }
        $this->set('currencies', $this->FeeType->PaymentCurrency->find('list'));
        $this->set('category_id', $category_id);
    }

    // Group edit fee types for a category
    public function edit_category_fee_types($category_id = null) {
        $this->loadModel('FeeType');
        $feeTypes = $this->FeeType->find('all', array(
            'conditions' => array('FeeType.category_id' => $category_id)
        ));
        $categoryDetails= $this->FeeType->FeeCategory->find('first', array(
            'conditions' => array('FeeCategory.id' => $category_id),
            'recursive' => -1
        ));
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = array();
            foreach ($this->request->data['FeeType'] as $index => $feeTypeData) {
                $feeTypeData['id'] = $feeTypes[$index]['FeeType']['id']; // Preserve IDs for update
                if (!empty($feeTypeData['computation_rule'])) {
                    if (!json_decode($feeTypeData['computation_rule'], true)) {
                        $this->Flash->error('Invalid computation rule JSON in one or more fee types.');
                        return;
                    }
                }
                $data[] = $feeTypeData;
            }
            if ($this->FeeType->saveAll($data, array('validate' => 'first'))) {
                $this->Flash->success('Fee types updated.');

                $this->redirect(array('action' => 'index', 'categories'));
            } else {
                $error = $this->FeeType->invalidFields();
                debug($error);
                $this->Flash->error('Failed to update fee types.');

            }
        }
        $this->set('feeTypes', $feeTypes);
        $this->set('categoryDetails',$categoryDetails);
        $this->set('currencies', $this->FeeType->PaymentCurrency->find('list'));
        $this->set('category_id', $category_id);
    }



    public function add_fee_type()
    {

        $this->loadModel('FeeType');
        if ($this->request->is('post')) {
            $this->FeeType->create();
            // Validate computation_rule JSON
            if (!empty($this->request->data['FeeType']['computation_rule'])) {
                if (!json_decode($this->request->data['FeeType']['computation_rule'], true)) {
                    $this->Session->setFlash(__('Invalid computation rule JSON.'), 'default', array('class' => 'error')
                    );
                    return;
                }
            }
            if ($this->FeeType->save($this->request->data)) {
                $this->Flash->success('Fee type created.');

                $this->redirect(array('action' => 'index', 'fee_types'));
            } else {
                $this->Flash->error('Failed to create fee type.');

            }
        }
        $this->set('currencies', $this->FeeType->PaymentCurrency->find('list'));
        $this->set('categories', $this->FeeType->FeeCategory->find('list'));
    }

    public function edit_fee_type($id = null)
    {

        $this->loadModel('FeeType');
        $feeType = $this->FeeType->findById($id);
        if (!$feeType) {
            throw new NotFoundException(__('Invalid fee type'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->FeeType->id = $id;
            if (!empty($this->request->data['FeeType']['computation_rule'])) {
                if (!json_decode($this->request->data['FeeType']['computation_rule'], true)) {
                    $this->Session->setFlash(__('Invalid computation rule JSON.'), 'default', array('class' => 'error')
                    );
                    return;
                }
            }
            if ($this->FeeType->save($this->request->data)) {

                $this->Flash->success('Fee type updated.');

                $this->redirect(array('action' => 'index', 'fee_types'));
            } else {

                $this->Flash->error('Failed to update fee type');

            }
        }
        $this->request->data = $feeType;
        $this->set('currencies', $this->FeeType->PaymentCurrency->find('list'));
        $this->set('categories', $this->FeeType->FeeCategory->find('list'));
    }

    public function delete_fee_type($id = null)
    {

        $this->loadModel('FeeType');
        $this->FeeType->id = $id;
        if (!$this->FeeType->exists()) {
            throw new NotFoundException(__('Invalid fee type'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->FeeType->delete()) {
            $this->Flash->success('Fee type deleted.');
        } else {
            $this->Flash->error('Failed to delete fee type');
        }
        $this->redirect(array('action' => 'index', 'fee_types'));
    }



    // Payment Currency Actions
    public function add_currency() {
        $this->loadModel('PaymentCurrency');
        if ($this->request->is('post')) {
            $this->PaymentCurrency->create();
            if ($this->PaymentCurrency->save($this->request->data)) {
                $this->Flash->success('Payment currency created.');

                $this->redirect(array('action' => 'index', 'currencies'));
            } else {
                $this->Flash->error('Failed to create payment currency.');
            }
        }
    }

    public function edit_currency($id = null) {
        $this->loadModel('PaymentCurrency');
        $currency = $this->PaymentCurrency->findById($id);
        if (!$currency) {
            throw new NotFoundException(__('Invalid payment currency'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->PaymentCurrency->id = $id;
            if ($this->PaymentCurrency->save($this->request->data)) {

                $this->Flash->success('Payment currency updated.');

                $this->redirect(array('action' => 'index', 'currencies'));
            } else {

                $this->Flash->error('Failed to update payment currency.');

            }
        }
        $this->request->data = $currency;
    }

    public function delete_currency($id = null) {
        $this->loadModel('PaymentCurrency');
        $this->PaymentCurrency->id = $id;
        if (!$this->PaymentCurrency->exists()) {
            throw new NotFoundException(__('Invalid payment currency'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->PaymentCurrency->delete()) {
            $this->Flash->success('Failed to delete payment currency.');

        } else {
            $this->Flash->error('Failed to delete payment currency.');

        }
        $this->redirect(array('action' => 'index', 'currencies'));
    }

    // Payment Method Actions
    public function add_method() {
        $this->loadModel('PaymentMethod');
        if ($this->request->is('post')) {
            $this->PaymentMethod->create();
            if ($this->PaymentMethod->duplication($this->request->data) == 0) {
                $this->request->data = $this->PaymentMethod->preparedAttachment($this->request->data);
                if ($this->PaymentMethod->saveAll($this->request->data, array('validate' => 'first'))) {
                    $this->Flash->success('Payment method created.');

                    $this->redirect(array('action' => 'index', 'methods'));
                } else {
                    $this->Flash->error('Failed to create payment method.');
                }
            } else {
                $this->Flash->success('You have already recorded  payment method .');
            }
        }
    }

    public function edit_method($id = null) {
        $this->loadModel('PaymentMethod');
        $method = $this->PaymentMethod->findById($id);
        if (!$method) {
            throw new NotFoundException(__('Invalid payment method'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->PaymentMethod->id = $id;
            $this->request->data = $this->PaymentMethod->preparedAttachment($this->request->data);
            if ($this->PaymentMethod->saveAll($this->request->data, array('validate' => 'first'))) {

                $this->Flash->success('Payment method updated.');

                $this->redirect(array('action' => 'index', 'methods'));
            } else {
                $this->Flash->error('Failed to update payment method.');
            }
        }
        $this->request->data = $method;
    }

    public function delete_method($id = null) {
        $this->loadModel('PaymentMethod');
        $this->PaymentMethod->id = $id;
        if (!$this->PaymentMethod->exists()) {
            throw new NotFoundException(__('Invalid payment method'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->PaymentMethod->delete()) {
            $this->Flash->success('Payment method deleted..');
        } else {
            $this->Flash->error('Failed to delete payment method.');

        }
        $this->redirect(array('action' => 'index', 'methods'));
    }

    // Exchange Rate Actions
    public function add_exchange_rates() {
        $this->loadModel('ExchangeRate');
        if ($this->request->is('post')) {
            foreach ($this->request->data['ExchangeRate'] as &$rate) {
                if ($rate['from_currency_id'] == $rate['to_currency_id'] && $rate['rate'] != 1.0) {
                    $this->Flash->error('Same currency pair must have rate 1.0.');
                    return;
                }
            }
            if ($this->ExchangeRate->saveAll($this->request->data['ExchangeRate'])) {

                $this->Flash->success('Exchange rates created');

                $this->redirect(array('action' => 'index', 'exchange_rates'));
            } else {

                $this->Flash->error('Failed to create exchange rates.');

            }
        }
        $this->set('currencies', $this->ExchangeRate->FromCurrency->find('list'));
    }
}