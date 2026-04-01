<?php
App::uses('AppController', 'Controller');

class ResultEntryAssignmentsController extends AppController {
  	var $menuOptions = array(
			'parent' => 'grades',
			'exclude' => array('edit', 'delete', 'view',
			'deleteAssignment'),
			'alias' => array(
				'assign_result_entry'=>
				'Assign Grade Entry To Instructor',
				'index'=>'View Result Entry Assignments'
			)
   );
   public $components =array('AcademicYear');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->Allow('assign_result_entry','index','get_student_to_add_course',
		'deleteAssignment');
     
	}

  
	function beforeRender() {
        $acyear_array_data = $this->AcademicYear->acyear_array();
        $defaultacademicyear=$this->AcademicYear->current_academicyear();
        $this->set(compact('acyear_array_data','defaultacademicyear'));
	}
	 public function index() {
		$makeup_exams = array();
		if (!empty($this->request->data)) {
			
			$makeup_exams = $this->ResultEntryAssignment->getExamResultEntry($this->request->data['ResultEntryAssignment']['department_id'], 
			$this->request->data['ResultEntryAssignment']['acadamic_year'], $this->request->data['ResultEntryAssignment']['program_id'], 
			$this->request->data['ResultEntryAssignment']['program_type_id'], $this->request->data['ResultEntryAssignment']['semester']);
			debug($makeup_exams);
		}
		if(!empty($this->department_ids) || !empty($this->college_ids)){
		$departments = $this->ResultEntryAssignment->CourseRegistration->Student->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids);
		} else {
				$departments = $this->ResultEntryAssignment->CourseRegistration->Student->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id),
		'recursive'=>-1));
		}
		$programs = $this->ResultEntryAssignment->PublishedCourse->Section->Program->find('list');
			$program_types = $this->ResultEntryAssignment->PublishedCourse->Section->ProgramType->find('list');
			$program_types = array('0' => 'Any Program Type') + $program_types;
			
		$this->set(compact('makeup_exams', 'programs','departments','program_types', 'makeup_exams'));
		
	}
	
	public function assign_result_entry($published_course_id = null)
    {
    	if(isset($published_course_id) && !empty($published_course_id)){
    		$pub=$this->ResultEntryAssignment->PublishedCourse->find('first',array('conditions'=>array('PublishedCourse.id'=>$published_course_id),'recursive'=>-1));
    		$program_id=$pub['PublishedCourse']['program_id'];
			$program_type_id=$pub['PublishedCourse']['program_type_id'];
			$department_id = $pub['PublishedCourse']['department_id'];
			$academic_year_selected = $pub['PublishedCourse']['academic_year'];
			$semester_selected = $pub['PublishedCourse']['semester'];
    	}
		//initialization 
		if(isset($this->request->data['ResultEntryAssignment']) && !empty($this->request->data['ResultEntryAssignment'])){
			$program_id=$this->request->data['ResultEntryAssignment']['program_id'];
			$program_type_id=$this->request->data['ResultEntryAssignment']['program_type_id'];
			$department_id = $this->request->data['ResultEntryAssignment']['department_id'];
			$academic_year_selected = $this->request->data['ResultEntryAssignment']['acadamic_year'];
			$semester_selected = $this->request->data['ResultEntryAssignment']['semester'];
		}	
    	$published_course_combo_id = null;
		$department_combo_id = null;
		$publishedCourses = array();
		$students_with_ng = array();
		$have_message = false;
		$programs = $this->ResultEntryAssignment->CourseRegistration->PublishedCourse->Section->Program->find('list');
		$program_types = $this->ResultEntryAssignment->CourseRegistration->PublishedCourse->Section->ProgramType->find('list');
		if(!empty($this->department_ids) || !empty($this->college_ids)){
		$departments = $this->ResultEntryAssignment->CourseRegistration->Student->Department->allDepartmentsByCollege2(0, $this->department_ids, $this->college_ids);
		} else {
                    $departments = $this->ResultEntryAssignment->CourseRegistration->Student->Department->find('list',array('conditions'=>array('Department.id'=>$this->department_id),
'recursive'=>-1));
		}
		//Add is clicked
		if(isset($this->request->data['assignAddCourseGradeEntry'])) {
			//There is nothing to do here for the time being
			//check if the student is belongs to the given user, and 
			$isIdExist=$this->ResultEntryAssignment->Student->
			find('first',array('conditions'=>array('Student.studentnumber'=>trim($this->request->data['ResultEntryAssignment']['studentnumber']),
			'Student.program_type_id'=>$this->program_type_id,
			'Student.program_id'=>$this->program_id,
			'Student.department_id'=>$this->department_ids),
			'recursive'=>-1
			));
			if(isset($isIdExist) && !empty($isIdExist)){
			  //check if the student has registered or added the selected published course
				$isRegAdd=$this->ResultEntryAssignment->isRegisteredAndAddedCourse($this->request->data['ResultEntryAssignment']['exam_published_course_id'],$isIdExist['Student']['id']);
				$courseRegDetail=array();
				if($isRegAdd==0){
				$publishedDetail=$this->ResultEntryAssignment->CourseRegistration->PublishedCourse->find('first',array('conditions'=>
				array('PublishedCourse.id'=>$this->request->data['ResultEntryAssignment']['exam_published_course_id']),
				'recursive'=>-1
				));
				//add course them 
				    	$courseRegDetail['CourseAdd']['year_level_id']=$publishedDetail['PublishedCourse']['year_level_id'];
				    	
				    	$courseRegDetail['CourseAdd']['semester']=$publishedDetail['PublishedCourse']['semester'];
				    	$courseRegDetail['CourseAdd']['academic_year']=$publishedDetail['PublishedCourse']['academic_year'];
				    	$courseRegDetail['CourseAdd']['student_id']=$isIdExist['Student']['id'];
				    	$courseRegDetail['CourseAdd']['published_course_id']=$publishedDetail['PublishedCourse']['id'];
				    	$courseRegDetail['CourseAdd']['department_approval']=1;
				    	$courseRegDetail['CourseAdd']['registrar_confirmation']=1;
				    	$courseRegDetail['CourseAdd']['registrar_confirmed_by']=$this->Auth->user('id');
				    	$courseRegDetail['CourseAdd']['department_approved_by']=$this->Auth->user('id');
				    	   	
				}
			if(isset($courseRegDetail) 
			&& !empty($courseRegDetail)){
			$this->ResultEntryAssignment->CourseAdd->create();
			if($this->ResultEntryAssignment->CourseAdd->save($courseRegDetail)){
			} 
			$regDetail=$this->ResultEntryAssignment->CourseAdd->find('first',
			array('conditions'=>array('CourseAdd.student_id'=>$isIdExist['Student']['id'],
			'CourseAdd.published_course_id'=>$publishedDetail['PublishedCourse']['id']),
			'contain'=>array('YearLevel','PublishedCourse','Student')));

			if(isset($regDetail) 
			&& !empty($regDetail)){
			$not_processed_entry= $this->ResultEntryAssignment->find('count',array('conditions'=>
			array(
			'ResultEntryAssignment.course_add_id' =>
			$regDetail['CourseAdd']['id'],

			'ResultEntryAssignment.course_add_id NOT IN (SELECT course_add_id FROM exam_grades WHERE course_add_id IS NOT NULL)'),'contain' => array()));
			if($not_processed_entry==0){

			$resultyEntryAssignments['ResultEntryAssignment']['course_add_id']=$regDetail['CourseAdd']['id'];
			$resultyEntryAssignments['ResultEntryAssignment']['published_course_id']=$this->request->data['ResultEntryAssignment']['exam_published_course_id'];
			$resultyEntryAssignments['ResultEntryAssignment']['minute_number']="Inst. Grade Entry";
			$resultyEntryAssignments['ResultEntryAssignment']['student_id']=$regDetail['CourseAdd']['student_id'];

			}

			}
			}
			if(isset($resultyEntryAssignments) && !empty($resultyEntryAssignments)){
			  if ($this->ResultEntryAssignment->save($resultyEntryAssignments)) {
					$this->Session->setFlash('<span></span>'.__('The resulty entry assignment  has been saved.'),'default',array('class'=>'success-box success-message'));
					return $this->redirect(array('controller' => 'resultEntryAssignments', 'action' => 'assign_result_entry',$this->request->data['ResultEntryAssignment']['exam_published_course_id']));
				}
			} 
			
	} else{
			  $this->Session->setFlash('<span></span>'.__('The given student number is not under your privilege.'),'default',array('class'=>'error-box error-message'));
			  return $this->redirect(array('controller' => 'resultEntryAssignments', 'action' => 'assign_result_entry',$this->request->data['ResultEntryAssignment']['exam_published_course_id']));
			}
		}
		//Assign  button is clicked
		else if(isset($this->request->data['assignGradeEntry'])) {
              //debug($this->request->data);
			if(trim($this->request->data['ResultEntryAssignment']['minute_number']) == "") {
				$this->Session->setFlash('<span></span>'.__('Please enter minute number.'), 'default',array('class'=>'error-box error-message'));
			} else {
				
				$resultyEntryAssignments = array();
				$count=0;
				$publishedDetail=$this->ResultEntryAssignment->CourseRegistration->PublishedCourse->find('first',array('conditions'=>
				array('PublishedCourse.id'=>$this->request->data['ResultEntryAssignment']['exam_published_course_id']),
				'recursive'=>-1
				));
				foreach($this->request->data['ResultEntryAssignment'] 
				as $key => $resultyentry) {
					
					if(is_numeric($key) 
					&& $resultyentry['gp']==1){
					//check if the student has registered or added that course and no grade has submitted
					
				    $isRegAdd=$this->ResultEntryAssignment->isRegisteredAndAddedCourse($this->request->data['ResultEntryAssignment']['exam_published_course_id'],$resultyentry['student_id']);
				   $courseRegDetail=array();
				   if($isRegAdd==0){
				     	//register them 
				    	$courseRegDetail['CourseRegistration']['year_level_id']=$publishedDetail['PublishedCourse']['year_level_id'];
				    	$courseRegDetail['CourseRegistration']['section_id']=$publishedDetail['PublishedCourse']['section_id'];
				    	$courseRegDetail['CourseRegistration']['semester']=$publishedDetail['PublishedCourse']['semester'];
				    	$courseRegDetail['CourseRegistration']['academic_year']=$publishedDetail['PublishedCourse']['academic_year'];
				    	$courseRegDetail['CourseRegistration']['student_id']=$resultyentry['student_id'];
				    	$courseRegDetail['CourseRegistration']['published_course_id']=$publishedDetail['PublishedCourse']['id'];
				    	if(isset($courseRegDetail) 
				    	&& !empty($courseRegDetail)){
				   	$this->ResultEntryAssignment->CourseRegistration->create();
				    		if($this->ResultEntryAssignment->CourseRegistration->save($courseRegDetail)){
				    		} else {
				    		
				    		debug($this->ResultEntryAssignment->CourseRegistration->invalidFields());
				    		}
				    		$regDetail=$this->ResultEntryAssignment->CourseRegistration->find('first',
				    		array('conditions'=>array('CourseRegistration.student_id'=>$resultyentry['student_id'],
				    		'CourseRegistration.published_course_id'=>$publishedDetail['PublishedCourse']['id']),
				    		'contain'=>array('YearLevel','PublishedCourse','Student')));
				    	
						   if(isset($regDetail) 
						   && !empty($regDetail)){
$not_processed_entry= $this->ResultEntryAssignment->find('count',array('conditions'=>
array(
'ResultEntryAssignment.course_registration_id' =>
$regDetail['CourseRegistration']['id'],

'ResultEntryAssignment.course_registration_id NOT IN (SELECT course_registration_id FROM exam_grades WHERE course_registration_id IS NOT NULL)'),'contain' => array()));
			if($not_processed_entry==0){
			
$resultyEntryAssignments['ResultEntryAssignment'][$count]['course_registration_id']=$regDetail['CourseRegistration']['id'];
$resultyEntryAssignments['ResultEntryAssignment'][$count]['published_course_id']=$this->request->data['ResultEntryAssignment']['exam_published_course_id'];
$resultyEntryAssignments['ResultEntryAssignment'][$count]['minute_number']=$this->request->data['ResultEntryAssignment']['minute_number'];
$resultyEntryAssignments['ResultEntryAssignment'][$count]['student_id']=$regDetail['CourseRegistration']['student_id'];
						   
			}
							
						   }
				    	}	
				     }	
				  }
				  $count++;
				}
				
			   if(isset($resultyEntryAssignments['ResultEntryAssignment']) && !empty($resultyEntryAssignments['ResultEntryAssignment'])){
				if ($this->ResultEntryAssignment->saveAll($resultyEntryAssignments['ResultEntryAssignment'])) {
					$this->Session->setFlash('<span></span>'.__('The resulty entry assignment  has been saved.'),'default',array('class'=>'success-box success-message'));
				} else {
					$this->Session->setFlash('<span></span>'.__('The resulty entry assignment  could not be saved. Please, try again.'), 'default', array('class'=>'error-box error-message'));
				}
			  }
		    }
		}

		if(!empty($this->request->data) && isset($this->request->data['listPublishedCourses'])) {
            $department_id = $this->request->data['ResultEntryAssignment']['department_id'];
            $this->request->data['ResultEntryAssignment']['published_course_id']=null;
            $published_course_id=null;
			$department_combo_id = $department_id;
			$college_id = explode('~', $department_id);
          
			if(is_array($college_id) 
			&& count($college_id) > 1) {
                 $college_id = $college_id[1];
                 $publishedCourses = $this->ResultEntryAssignment->CourseRegistration->getlistOfPublishedCourseGradeEntryMissed($college_id, $this->request->data['ResultEntryAssignment']['acadamic_year'], $this->request->data['ResultEntryAssignment']['semester'], 
                 $this->request->data['ResultEntryAssignment']['program_id'], $this->request->data['ResultEntryAssignment']['program_type_id']);
			} else {
                         
               $publishedCourses = $this->ResultEntryAssignment->CourseRegistration->getlistOfPublishedCourseGradeEntryMissed($department_id, $this->request->data['ResultEntryAssignment']['acadamic_year'], $this->request->data['ResultEntryAssignment']['semester'], $this->request->data['ResultEntryAssignment']['program_id'], $this->request->data['ResultEntryAssignment']['program_type_id']);
               
			}
			if(empty($publishedCourses)) {
				$this->Session->setFlash('<span></span>'.__('We could not find courses with selected criteria. Only student not registered and grade not submitted to them by different reasons are displayed here.'), 'default',array('class'=>'info-box info-message'));
					
			}
			else
				$publishedCourses = array('0' => '--- Select Published Course ---') + $publishedCourses;
		}

        //When published course is selected from the combo box
		if(!empty($published_course_id) 
		|| (isset($this->request->data['ResultEntryAssignment']['published_course_id']) 
		&& $this->request->data['ResultEntryAssignment']['published_course_id'] != 0)) {

			if(isset($this->request->data['ExamGrade']['published_course_id']))
				$published_course_id = $this->request->data['ExamGrade']['published_course_id'];
			$publishedCourses = array();
			$published_course = $this->ResultEntryAssignment->CourseRegistration->PublishedCourse->find('first', 
				array(
					'conditions' => array('PublishedCourse.id' => $published_course_id),
					'contain' => array('Section','YearLevel')
				)
			);
			if(empty($published_course) || (!empty($published_course['PublishedCourse']['department_id']) && $published_course['PublishedCourse']['given_by_department_id']!=$this->department_id && $this->role_id==ROLE_DEPARTMENT) || (!empty($published_course['PublishedCourse']['department_id']) && !in_array($published_course['PublishedCourse']['department_id'], $this->department_ids) && $this->role_id==ROLE_REGISTRAR) || (!empty($published_course['PublishedCourse']['college_id']) && !in_array($published_course['PublishedCourse']['college_id'], $this->college_ids) && $this->role_id==ROLE_REGISTRAR) || (!empty($published_course['PublishedCourse']['given_by_department_id']) && $this->department_id!=$published_course['PublishedCourse']['given_by_department_id'] && $this->role_id!=ROLE_REGISTRAR)) {
				$this->Session->setFlash('<span></span>'.__('You dont have the privilege to perform this action.'), 'default',array('class'=>'error-box error-message'));
				return $this->redirect('/');
				
			} else {
                 if(empty($published_course['PublishedCourse']['department_id'])) {
                    if(!empty($published_course['PublishedCourse']['department_id'])){
					$publishedCourses = $this->ResultEntryAssignment->CourseRegistration->getlistOfPublishedCourseGradeEntryMissed($published_course['PublishedCourse']['department_id'], 
					$published_course['PublishedCourse']['academic_year'], $published_course['PublishedCourse']['semester'], $published_course['PublishedCourse']['program_id'], $published_course['PublishedCourse']['program_type_id']);
					$department_combo_id = $published_course['PublishedCourse']['given_by_department_id'];
					} else {
						$publishedCourses = $this->ResultEntryAssignment->CourseRegistration->getlistOfPublishedCourseGradeEntryMissed($published_course['PublishedCourse']['college_id'], 
						$published_course['PublishedCourse']['academic_year'], $published_course['PublishedCourse']['semester'], $published_course['PublishedCourse']['program_id'], $published_course['PublishedCourse']['program_type_id']);
						$department_combo_id = 'c~'.$published_course['PublishedCourse']['college_id'];
					}
                 } else {
                     $publishedCourses = $this->ResultEntryAssignment->CourseRegistration->getlistOfPublishedCourseGradeEntryMissed($published_course['PublishedCourse']['department_id'], $published_course['PublishedCourse']['academic_year'], $published_course['PublishedCourse']['semester'], $published_course['PublishedCourse']['program_id'], $published_course['PublishedCourse']['program_type_id']);
					$department_combo_id = $published_course['PublishedCourse']['department_id'];
                 }
			}
			$published_course_combo_id = $published_course_id;
		
			$students_no_entry= $this->ResultEntryAssignment->Student->getStudentNotRegisteredPublishourse($published_course_id);
			//debug($students_no_entry);
			if(empty($students_no_entry)) {
				if($have_message == false) {
					$this->Session->setFlash(
					'<span></span>'.__('There is no student in the selected course.'), 'default',array('class'=>'info-box info-message'));
				}
			}
			$program_id = $published_course['PublishedCourse']['program_id'];
			$program_type_id = $published_course['PublishedCourse']['program_type_id'];
			$department_id = $published_course['PublishedCourse']['department_id'];
			$academic_year_selected = $published_course['PublishedCourse']['academic_year'];
			$semester_selected = $published_course['PublishedCourse']['semester'];
			$sectionsHaveSameCourses=$this->ResultEntryAssignment->CourseRegistration->PublishedCourse->listSimilarPublishedCoursesForCombo($published_course['PublishedCourse']['id']);
			
			
			$selectedPublishedCourseDetail=$this->ResultEntryAssignment->CourseRegistration->PublishedCourse->find('first',array('conditions'=>array('PublishedCourse.id'=>$published_course['PublishedCourse']['id']),'contain'=>array('Section','YearLevel')));
	    }
	    
	    $this->set(compact('publishedCourses', 'programs', 'program_types','selectedPublishedCourseDetail', 'departments', 'publishedCourses', 'published_course_combo_id', 'department_combo_id', 'students_no_entry', 'applicable_grades', 'program_id', 'program_type_id', 'department_id', 'academic_year_selected', 'semester_selected','sectionsHaveSameCourses'));
    }

	
	public function view($id = null) {
		if (!$this->ResultEntryAssignment->exists($id)) {
			throw new NotFoundException(__('Invalid result entry assignment'));
		}
		$options = array('conditions' => array('ResultEntryAssignment.' . $this->ResultEntryAssignment->primaryKey => $id));
		$this->set('resultEntryAssignment', $this->ResultEntryAssignment->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->ResultEntryAssignment->create();
			if ($this->ResultEntryAssignment->save($this->request->data)) {
				$this->Flash->success(__('The result entry assignment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The result entry assignment could not be saved. Please, try again.'));
			}
		}
		/*
		$students = $this->ResultEntryAssignment->Student->find('list');
		$publishedCourses = $this->ResultEntryAssignment->PublishedCourse->find('list');
		$courseRegistrations = $this->ResultEntryAssignment->CourseRegistration->find('list');
		$courseAdds = $this->ResultEntryAssignment->CourseAdd->find('list');
		*/
		$this->set(compact('students', 'publishedCourses', 'courseRegistrations', 'courseAdds'));
	
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ResultEntryAssignment->exists($id)) {
			throw new NotFoundException(__('Invalid result entry assignment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ResultEntryAssignment->save($this->request->data)) {
				$this->Flash->success(__('The result entry assignment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The result entry assignment could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ResultEntryAssignment.' . $this->ResultEntryAssignment->primaryKey => $id));
			$this->request->data = $this->ResultEntryAssignment->find('first', $options);
		}
		/*
		$students = $this->ResultEntryAssignment->Student->find('list');
		$publishedCourses = $this->ResultEntryAssignment->PublishedCourse->find('list');
		$courseRegistrations = $this->ResultEntryAssignment->CourseRegistration->find('list');
		$courseAdds = $this->ResultEntryAssignment->CourseAdd->find('list');
		$this->set(compact('students', 'publishedCourses', 'courseRegistrations', 'courseAdds'));
		*/
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ResultEntryAssignment->id = $id;
		if (!$this->ResultEntryAssignment->exists()) {
			throw new NotFoundException(__('Invalid result entry assignment'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ResultEntryAssignment->delete()) {
			$this->Flash->success(__('The result entry assignment has been deleted.'));
		} else {
			$this->Flash->error(__('The result entry assignment could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	 public function get_student_to_add_course($published_course_id)
     {
		 $this->layout='ajax';
		 //find students who doesnt register for this course and 
		 if(isset($published_course_id) 
		 && !empty($published_course_id)){
		 $publishedCourseDetail=$this->ResultEntryAssignment->CourseRegistration->PublishedCourse->find('first',array('conditions'=>array('PublishedCourse.id'=>$published_course_id),
		 'contain'=>array('Course','CourseInstructorAssignment'=>array('Staff'),'Section','GivenByDepartment')));
		 $sectionsHaveSameCourses=$this->ResultEntryAssignment->CourseRegistration->PublishedCourse->listSimilarPublishedCoursesForCombo($publishedCourseDetail['PublishedCourse']['id']);
			
			
		 }
		 
     $this->set(compact('sectionsHaveSameCourses','publishedCourseDetail'));
		 /*
		 $student=$this->ExamGrade->CourseAdd->Student->find('first',array('conditions'=>array('Student.id'=>$student_id),'recursive'=>-1));
         $departments= $this->ExamGrade->CourseAdd->PublishedCourse->Department->find('list',
array('conditions'=>array('Department.id in (select department_id from published_courses where semester="'.$semester.'" and academic_year="'.str_replace('-','/',$academic_year).'" and program_id='.$student['Student']['program_id'].' and program_type_id='.$student['Student']['program_type_id'].')')));
	     $colleges = $this->ExamGrade->CourseAdd->PublishedCourse->College->find('list');
		 $addParamaters['student_id']=$student_id;
		 $addParamaters['academic_year']=$academic_year;
		 $addParamaters['semester']=$semester;
		 $addParamaters['studentnumber']=$student['Student']['studentnumber'];
	     $this->set(compact('colleges','departments','addParamaters'));
		*/
	 }	
	 public function deleteAssignment($id = null) {
		$this->ResultEntryAssignment->id = $id;
		if (!$this->ResultEntryAssignment->exists()) {
			throw new NotFoundException(__('Invalid result entry assignment'));
		}
		$this->request->allowMethod('post', 'delete');
		$anyGradeSubmitted=$this->ResultEntryAssignment->find('first',array('conditions'=>array('ResultEntryAssignment.id'=>
		$id),'recursive'=>-1));
		
		if ($this->ResultEntryAssignment->delete() && 
		empty($anyGradeSubmitted['ResultEntryAssignment']['result']
		)) {
			
			$this->Session->setFlash('<span></span>'.__('The result entry assignment has been deleted.'), 'default',array('class'=>'success-box success-message'));
					
					
		} else {
			
			$this->Session->setFlash('<span></span>'.__('The result entry assignment could not be deleted. Please, try again.'), 'default',array('class'=>'error-box error-message'));
			
		}
		return $this->redirect(array('action' => 'index'));
	}
}
