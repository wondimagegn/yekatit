<?php
class RegionsController extends AppController {

    public $name = 'Regions';
    public $components = array('RequestHandler');
    //var $helpers = array('Ajax','Javascript');
    public $menuOptions = array(
            'parent' => 'countries',
             'alias' => array(
                    'index'=>'View Regions',
                    'add'=>'Add Region',
                )
    );
   public function beforeFilter() {
      parent::beforeFilter();
     
      $this->Auth->allowedActions = array('getRegions');
    }
   
   public function index() {
		$this->Region->recursive = 0;
		$this->set('regions', $this->paginate());
	}

   public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid region'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('region', $this->Region->read(null, $id));
	}

	public function add() {
		if (!empty($this->request->data)) {
			$this->Region->create();
			if ($this->Region->save($this->request->data)) {

			    $this->Session->setFlash('<span></span>'.__('Region saved'),
			    'default',array('class'=>'success-box success-message'));
			    $this->redirect(array('action' => 'index'));
			} else {
			    $this->Session->setFlash('<span></span>'.__('The region  could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		$countries = $this->Region->Country->find('list');
		$this->set(compact('countries'));
	}

	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->flash(sprintf(__('Invalid region')), array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Region->save($this->request->data)) {
				 $this->Session->setFlash('<span></span>'.__('Region updated successfully'),
			    'default',array('class'=>'success-box success-message'));
			    $this->redirect(array('action' => 'index'));
			} else {
			     $this->Session->setFlash('<span></span>'.__('The region  could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Region->read(null, $id);
		}
		$countries = $this->Region->Country->find('list');
		$this->set(compact('countries'));
	}

	public function delete($id = null) {
		
	    
	    if (!$id) {
			$this->Session->setFlash(__('Invalid id for region'));
			return $this->redirect(array('action'=>'index'));
		}
		//check deletion is possible 
		if ($this->Region->canItBeDeleted($id)) {
		    if ($this->Region->delete($id)) {
			    $this->Session->setFlash('<span></span>'.__('Region deleted'),
			    'default',array('class'=>'success-box success-message'));
			    $this->redirect(array('action'=>'index'));
		    }
		} else {
		   $this->Session->setFlash('<span></span>'.__('Region was not deleted. It is related to student and contacts.'),
		'default',array('class'=>'error-box error-message'));   
		}
		$this->Session->setFlash('<span></span>'.__('Region was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}	
}
