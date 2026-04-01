<?php
class AttachmentsController extends AppController {

	var $name = 'Attachments';
	var $menuOptions = array(
			'controllerButton'=>false,
			'exclude' => array('*'),
    );
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('delete');
    }
	function index() {
		$this->Attachment->recursive = 0;
		$this->set('attachments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid attachment'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('attachment', $this->Attachment->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Attachment->create();
			if ($this->Attachment->save($this->request->data)) {
				$this->Session->setFlash(__('The attachment has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The attachment could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid attachment'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Attachment->save($this->request->data)) {
				$this->Session->setFlash(__('The attachment has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The attachment could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Attachment->read(null, $id);
		}
	}

	function delete($id = null,$action_controller_id=null) {
	    $attachment_detail=explode('~',$action_controller_id);
	   
	    if (!$id) {
           $this->Session->setFlash('<span></span>'.__('Invalid id for attachment'),
			'default',array('class'=>'error-box error-message'));
			if (!empty($attachment_detail[0]) && !empty($attachment_detail[1]) && 
			!empty($attachment_detail[2])) {
			return $this->redirect(array('controller'=>$attachment_detail[1],'action'=>$attachment_detail[0],$attachment_detail[2]));
			}
        }
       /* $this->Attachment->id = $id;
        
        if (!$this->Attachment->exists()) {
             $this->Session->setFlash('<span></span>'.__('Invalid id for attachment'),
			'default',array('class'=>'error-box error-message'));
			if (!empty($attachment_detail[0]) && !empty($attachment_detail[1]) && 
			!empty($attachment_detail[2])) {
			    $this->redirect(array('controller'=>$attachment_detail[1],
			    'action'=>$attachment_detail[0],$attachment_detail[2]));
			}
			
        }
        */
       
		if ($this->Attachment->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Attachment deleted successfully.'),
			'default',array('class'=>'success-box success-message'));
			if (!empty($attachment_detail[0]) && !empty($attachment_detail[1]) && 
			!empty($attachment_detail[2])) {
			    $this->redirect(array('controller'=>$attachment_detail[1],'action'=>$attachment_detail[0],$attachment_detail[2]));
			}
		}
		if (!empty($attachment_detail[0]) && !empty($attachment_detail[1]) && 
			!empty($attachment_detail[2])) {
			    $this->Session->setFlash('<span></span>'.__('Attachment can not be deleted.'),
			'default',array('class'=>'error-box error-message'));
			    $this->redirect(array('controller'=>$attachment_detail[1],'action'=>$attachment_detail[0],$attachment_detail[2]));
		}
			
		//$this->redirect(array('action' => 'index'));
	}
}
