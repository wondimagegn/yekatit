<?php
class EquivalentCoursesController extends AppController {

	public $name = 'EquivalentCourses';
    public $menuOptions = array(
             'parent' => 'curriculums',
             //'exclude' => array('index'),
             'alias' => array(
                    'add' => 'Map Courses',
                    'index'=>'View Mapped Courses'
            )
	 );
	public $paginate=array();

	public function index() 
   {
		 $this->EquivalentCourse->recursive = 1;
		 $this->paginate = array('contain'=>array('CourseForSubstitued' => array('Department','Curriculum'),'CourseBeSubstitued'=>array('Department','Curriculum')));

        $this->paginate['conditions'][]=array('CourseForSubstitued.department_id'=>$this->department_id);
         // filter by curriculum
		if (isset($this->request->data['Search']['curriculum_id']) && !empty($this->request->data['Search']['curriculum_id'])){
			$this->paginate['conditions'][]=array(
	                            'CourseForSubstitued.curriculum_id'=>$this->request->data['Search']['curriculum_id']
	                       );
		}

		  // filter by program 
		if (isset($this->request->data['Search']['program_id']) && !empty($this->request->data['Search']['program_id'])){

			 $curriculums=$this->EquivalentCourse->CourseBeSubstitued->
	                        Curriculum->find('list',array('fields'=>array('id'),
	                        'conditions'=>array('Curriculum.department_id'=>$this->department_id,
	                        'Curriculum.program_id'=>$this->request->data['Search']['program_id']))); 

			$this->paginate['conditions'][]=array(
	                            'CourseForSubstitued.curriculum_id'=>$curriculums);
	                       
		}

        if (isset($this->request->data['Search']['title']) && !empty($this->request->data['Search']['title'])){
			$this->paginate['conditions'][]=array(
	                            'CourseForSubstitued.course_title like'=>'%'.$this->request->data['Search']['title'].'%'
	                       );
		}

	    $this->Paginator->settings=$this->paginate;
	    //debug($this->Paginator->settings);
	
        if(isset($this->Paginator->settings['conditions'])) {
		      $equivalentCourses=$this->Paginator->paginate('EquivalentCourse');  
		}
		else {
			$equivalentCourses= array();
		}

	   if (empty($equivalentCourses) && isset($this->request->data) && !empty($this->request->data)) {
			 $this->Session->setFlash('<span></span>'.__('There is no course equivalent mapping in the system in the given criteria.'),'default',array('class'=>'info-box info-message'));
		}
        
	      $programs=$this->EquivalentCourse->CourseBeSubstitued->Curriculum->Program->find('list');
	      if (!empty($this->request->data['Search']['program_id'])) {
	           $curriculums=$this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list',array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array(
		    'Curriculum.department_id'=>$this->department_id,
		    'Curriculum.program_id'=>$this->request->data['Search']['program_id']
		    )));    
	      } else {
	           $curriculums=array();
	      }
	     
	      $this->set(compact('programs','curriculums','equivalentCourses'));
		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid equivalent course'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->set('equivalentCourse', $this->EquivalentCourse->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
            
			$this->EquivalentCourse->create();
			if (empty($this->request->data['EquivalentCourse']['course_for_substitued_id']) || 
			empty($this->request->data['EquivalentCourse']['course_be_substitued_id'])) {
			    $check_duplicate=0;
			} else {
			$check_duplicate=$this->EquivalentCourse->find('count',array('conditions'=>array(
			'course_for_substitued_id'=>$this->request->data['EquivalentCourse']['course_for_substitued_id'],'course_be_substitued_id'=>$this->request->data['EquivalentCourse']['course_be_substitued_id'])));
			
			}
			
			if ($check_duplicate==0) {
			  
			    if ($this->EquivalentCourse->isSimilarCurriculum($this->request->data)) {
			            if ($this->EquivalentCourse->save($this->request->data)) {
				            $this->Session->setFlash('<span></span>'.__('The equivalent course has been saved'),'default',array('class'=>'success-box success-message'));
				            //$this->redirect(array('action' => 'index'));
			            } else {
				            $this->Session->setFlash('<span></span>'.__('The equivalent course could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			            }
			       
			    } else {
			      $error=$this->EquivalentCourse->invalidFields();
                   
                         if(isset($error['error'])){
                            $this->Session->setFlash(__('<span></span>'.
                            $error['error'][0], true),'default',array('class'=>'error-box error-message'));
			            }
			   }
			  
			} else {
			   $this->Session->setFlash('<span></span>'.__('The selected courses has already mapped. You dont need to map it again'),'default',array('class'=>'error-box error-message'));
			    $this->redirect(array('action' => 'index'));
			}
			
		}
	  
	
		$departments=$this->EquivalentCourse->CourseBeSubstitued->Department->find('all',
		array('fields'=>array('id','name'),
		'contain'=>array('College'=>array('id','name'))));
		$return=array();
		if (!empty($departments)) {
		    foreach($departments as $dep_id=>$dep_name) {
	                $return[$dep_name['College']['name']][$dep_name['Department']['id']]=$dep_name['Department']['name'];	
		    }
		}
		$departments=$return;
		 $curriculums=$this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list',
		array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array('Curriculum.department_id'=>$this->department_id))); 
		
		if (empty($this->request->data)) {
		    
		    $courseBeSubstitueds = array(); 
		    $otherCurriculums=array();
		}
		if (empty($this->request->data['EquivalentCourse']['other_curriculum_id'])) {
		     $otherCurriculums=array();
		}
		if (!empty($this->request->data['EquivalentCourse']['other_curriculum_id'])) {
		    $other_department_id=$this->EquivalentCourse->CourseBeSubstitued->Curriculum->field('department_id',array('Curriculum.id'=>$this->request->data['EquivalentCourse']['other_curriculum_id']));    
		
		   $otherCurriculums=$this->EquivalentCourse->CourseBeSubstitued->Curriculum->find('list',
		array('fields'=>array('id','curriculum_detail'),
		'conditions'=>array('Curriculum.department_id'=>$other_department_id)));    
		
		}
		if (!empty($this->request->data['EquivalentCourse']['course_be_substitued_id'])) {
		      $curriculum_id=$this->EquivalentCourse->CourseBeSubstitued->field('curriculum_id',
		      array('CourseBeSubstitued.id'=>$this->request->data['EquivalentCourse']['course_be_substitued_id']));
		       
		     $courseBeSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list',
		array('conditions'=>array('CourseBeSubstitued.curriculum_id'=>$curriculum_id),'fields'=>array('id','course_code','course_title')));
		}
		
		if (!empty($this->request->data['EquivalentCourse']['course_for_substitued_id'])) {
		   
		     $curriculum_id=$this->EquivalentCourse->CourseBeSubstitued->field('curriculum_id',
		      array('CourseBeSubstitued.id'=>$this->request->data['EquivalentCourse']['course_for_substitued_id']));
		    
		     $courseForSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list',
		array('conditions'=>array('CourseBeSubstitued.curriculum_id'=>$curriculum_id),'fields'=>array('id','course_code','course_title')));
		
		
		}
		
		
		
	
		$this->set(compact('courseForSubstitueds','departments',
		'curriculums','otherCurriculums','courseBeSubstitueds'));
	}
	
	
	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash('<span></span>'.__('Invalid equivalent course'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->EquivalentCourse->save($this->request->data)) {
				$this->Session->setFlash('<span></span>'.__('The equivalent course has been saved'),'default',array('class'=>'success-box success-message'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('<span></span>'.__('The equivalent course could not be saved. Please, try again.'),'default',array('class'=>'error-box error-message'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->EquivalentCourse->read(null, $id);
			
		}
		$courseForSubstitueds = $this->EquivalentCourse->CourseForSubstitued->find('list',
		array('conditions'=>array('CourseForSubstitued.department_id'=>$this->department_id),'fields'=>array('id','course_title')));
		$courseBeSubstitueds = $this->EquivalentCourse->CourseBeSubstitued->find('list',
		array('fields'=>array('id','course_title')));
		
		$this->set(compact('courseForSubstitueds', 'courseBeSubstitueds'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('<span></span>'.__('Invalid id for equivalent course'),
			'default',array('class'=>'error-box error-message'));
			return $this->redirect(array('action'=>'index'));
		}
		//TODO check the taken equivalent course
		//Attache and Deattch, curriculum history for the student should be kept in the tables 
		if ($this->EquivalentCourse->checkStudentTakeingEquivalentCourseAndDenyDelete($id,$this->department_id)) {
		    
		    if ($this->EquivalentCourse->delete($id)) {
			$this->Session->setFlash('<span></span>'.__('Equivalent course deleted'),
			'default',array('class'=>'success-box success-message'));
			return $this->redirect(array('action'=>'index'));
		    }
		  
		} else {
		      $this->Session->setFlash('<span></span>'.__('Equivalent course map could not be deleted. It is associated with students.'),
		    'default',array('class'=>'error-box error-message'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
