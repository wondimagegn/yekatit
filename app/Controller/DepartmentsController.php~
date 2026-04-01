<?php
class DepartmentsController extends AppController {

	var $name = 'Departments';
    var $menuOptions = array(
        'parent' => 'campuses',
        'alias' => array(
                    'index' => 'View all Departments',
                    'add' => 'Add New Department'
         )
    );
    public $paginate=array();
     /*
	 *Generic search for returned items
	 */
	 function search() {
		// the page we will redirect to
		$url['action'] = 'index';
		
		// build a URL will all the search elements in it
		// the resulting URL will be 
		// domain.com/returned_items/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->request->data as $k=>$v){ 
			foreach ($v as $kk=>$vv){ 
				if(is_array($vv)) {
					foreach($vv as $kkk => $vvv)
						$url[$k.'.'.$kk.'.'.$kkk] = $vvv;
				}
				else
					$url[$k.'.'.$kk]=$vv;
			} 
		}
		// redirect the user to the url
		return $this->redirect($url, null, true);
	}
    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->Allow('search','get_department_combo','get_department_for_transfer');
    }
	function index() {
		$this->paginate = array('limit' => 100);
		$this->paginate = array('contain'=>array('College' => array('order' => array('College.name ASC'))));

		// filter by college 
		if (isset($this->passedArgs['Department.college_id']) && !empty($this->passedArgs['Department.college_id'])) {
			$this->paginate['conditions']['Department.college_id'] = $this->passedArgs['Department.college_id'];
			//set the Search data, so the form remembers the option
			$this->request->data['Department']['college_id'] = $this->passedArgs['Department.college_id'];
		}

		// filter by department name 
		if (isset($this->passedArgs['Department.name']) && !empty($this->passedArgs['Department.name'])) {
			$this->paginate['conditions']['Department.name like '] = $this->passedArgs['Department.name'].'%';
			//set the Search data, so the form remembers the option
			$this->request->data['Department']['name'] = $this->passedArgs['Department.name'];
		}


		$this->Paginator->settings=$this->paginate;
	    if(!empty($this->Paginator->settings['conditions'])) {
			$departments= $this->Paginator->paginate('Department');  
		}
		else {
			$departments= $this->Paginator->paginate('Department'); 
		}
		
		if (empty($departments) && isset($this->passedArgs) && !empty($this->passedArgs)) {
			$this->Session->setFlash('<span></span>'.__('There is no department based on the given criteria.', true),'default',array('class'=>'info-box info-message'));
		}
		$colleges = $this->Department->College->find('list');
		$this->set('departments', $departments);
		$this->set(compact('colleges'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid department'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('department', $this->Department->read(null, $id));
	}

	function add() {
		
		if (!empty($this->request->data)) {
			$this->Department->create();
			if ($this->Department->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The department has been saved'),
			'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The department could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		$colleges = $this->Department->College->find('list');
		$this->set(compact('colleges'));
	    
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid department'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Department->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The department has been saved'),
				'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The department could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Department->read(null, $id);
		}
		$colleges = $this->Department->College->find('list');
		$this->set(compact('colleges'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for department'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if($this->Department->canItBeDeleted($id)) {
		    if ($this->Department->delete($id)) {
			    $this->Session->setFlash('<span></span>'.__('Department deleted'),
			    'default',array('class'=>'success-box success-message'));
			    $this->redirect(array('action'=>'index'));
		    }
		}
		$this->Session->setFlash('<span></span>'.__('Department was not deleted'),
		'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
	function get_department_combo($college_id=null,$all=0) {
	  $this->layout = 'ajax';
	  $departments=array();
	  if (!empty($college_id) && $all) {
	       $departments = $this->Department->find('list',array('conditions'=>array('Department.college_id'=>$college_id)));
	  } else if (!empty($college_id)) {
	            if (!empty($this->department_ids)) {
                    $departments = $this->Department->find('list',
                    array('conditions'=>array('Department.college_id'=>$college_id,
                    'Department.id'=>$this->department_ids)));
	            
	            } else {
	                $departments = $this->Department->find('list',array('conditions'=>array('Department.college_id'=>$college_id)));

	            }
         	    	  
	  } else {
	      // $departments = $this->Department->find('list',array('conditions'=>array('Department.college_id'=>$college_id)));
	  }
     
	   $this->set(compact('departments'));
	}

      function get_department_for_transfer($college_id=null,$exclude_department=null) 
      {
	  $this->layout = 'ajax';
	  $departments=array();
	  if (!empty($college_id) && !empty($exclude_department)) {
	       $departments = $this->Department->find('list',array('conditions'=>array('Department.college_id'=>$college_id,'Department.id!='.$exclude_department.'')));
		
	  }
         
	 $this->set(compact('departments'));
	 $this->render('get_department_combo');
     }
}
