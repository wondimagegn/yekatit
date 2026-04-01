<?php
class GraduationCertificatesController extends AppController {

	var $name = 'GraduationCertificates';
	var $menuOptions = array(
		'parent' => 'graduation',
		'weight'=>5,
		'alias' => array(
			'index' => 'View Graduation Certificate Templates',
			'add' => 'New Graduation Certificate Template'
		)
	);
	
	function index() {
		$this->GraduationCertificate->recursive = 0;
		$this->set('graduationCertificates', $this->paginate());
                   $departments = $this->GraduationCertificate->Program->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);
              $departments = array(0 => 'All University') + $departments;
              $this->set(compact('departments'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid graduation certificate'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('graduationCertificate', $this->GraduationCertificate->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$duplicated = $this->GraduationCertificate->find('count',
				array(
					'conditions' =>
					array(
						'GraduationCertificate.program_id' => $this->request->data['GraduationCertificate']['program_id'],
						'GraduationCertificate.program_type_id' => $this->request->data['GraduationCertificate']['program_type_id'],
		'GraduationCertificate.academic_year' => $this->request->data['GraduationCertificate']['academic_year'],

'GraduationCertificate.department' => $this->request->data['GraduationCertificate']['department']
					)
				)
			);
			if($duplicated > 0) {
				$this->Session->setFlash('<span></span>'.__('There is already a graduation certificate template by the selected program, program type, and academic year. Please use edit to apply changes.'), 'default',array('class'=>'error-box error-message'));
			}
			else {
				$this->GraduationCertificate->create();
				if ($this->GraduationCertificate->save($this->request->data)) {
					$this->Session->setFlash('<span></span>'.__('The graduation certificate has been saved'), 'default',array('class'=>'success-box success-message'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<span></span>'.__('The graduation certificate could not be saved. Please, try again.'), 'default',array('class'=>'error-box error-message'));
				}
			}
		}
		$programs = $this->GraduationCertificate->Program->find('list');
		$programTypes = $this->GraduationCertificate->ProgramType->find('list');
		$acs = array();
		for($i = date('Y')+1; $i >= Configure::read('Calendar.universityEstablishement'); $i--) {
			$acs[$i] = $i;
		}
              $departments = $this->GraduationCertificate->Program->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);
              $departments = array(0 => 'All University') + $departments;

		$default_department_id = null;

	      $this->set(compact('programs','departments', 'programTypes', 'acs','default_department_id','departments'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid graduation certificate'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			$duplicated = $this->GraduationCertificate->find('count',
				array(
					'conditions' =>
					array(
						'GraduationCertificate.id <> ' => $this->request->data['GraduationCertificate']['id'],
						'GraduationCertificate.program_id' => $this->request->data['GraduationCertificate']['program_id'],
						'GraduationCertificate.program_type_id' => $this->request->data['GraduationCertificate']['program_type_id'],
						'GraduationCertificate.academic_year' => $this->request->data['GraduationCertificate']['academic_year'],

'GraduationCertificate.department' => $this->request->data['GraduationCertificate']['department']
					)
				)
			);
			if($duplicated > 0) {
				$this->Session->setFlash('<span></span>'.__('There is already a graduation certificate template by the selected program, program type, and academic year. Please use edit to apply changes.'), 'default',array('class'=>'error-box error-message'));
			}
			else {
				if ($this->GraduationCertificate->save($this->request->data)) {
					$this->Session->setFlash('<span></span>'.__('The graduation certificate has been saved'), 'default',array('class'=>'success-box success-message'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<span></span>'.__('The graduation certificate could not be saved. Please, try again.'), 'default',array('class'=>'error-box error-message'));
				}
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->GraduationCertificate->read(null, $id);
		}
		$programs = $this->GraduationCertificate->Program->find('list');
		$programTypes = $this->GraduationCertificate->ProgramType->find('list');
		$acs = array();
		for($i = date('Y')+1; $i >= Configure::read('Calendar.universityEstablishement'); $i--) {
			$acs[$i] = $i;
		}
                $departments = $this->GraduationCertificate->Program->Student->Department->allDepartmentsByCollege2(1, $this->department_ids, $this->college_ids);
              $departments = array(0 => 'All University') + $departments;

		$default_department_id = null;

	      $this->set(compact('programs','departments', 'programTypes', 'acs','default_department_id','departments'));
		
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for graduation certificate'), 'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		if ($this->GraduationCertificate->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Graduation certificate deleted'), 'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('<span></span>'.__('Graduation certificate was not deleted'), 'default',array('class'=>'error-box error-message'));
		return $this->redirect(array('action' => 'index'));
	}
}
