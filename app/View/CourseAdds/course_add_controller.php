<?php 
/*
	function mass_add () {
	  
	    //get list of students and registered courses 
	    if (!empty($this->request->data) && isset($this->request->params['form']['continue'])) {
	        
	       	$everythingfine=false;
		    switch($this->request->data) {
		    
			        case empty($this->request->data['Student']['department_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select department you want to add courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['academic_year']) :
			         $this->Session->setFlash('<span></span> '.__('Please select academic year you  want to add  courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			          case empty($this->request->data['Student']['year_level_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select year level you  want to add  courses for mass students.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			        case empty($this->request->data['Student']['program_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program you want to add courses for mass students. Please, try again.'),'default',array('class'=>'error-box error-message'));  
			         break; 
			         case empty($this->request->data['Student']['program_type_id']) :
			         $this->Session->setFlash('<span></span> '.__('Please select the program type you want to add courses for mass students. Please, try again.'),'default',array('class'=>'error-box error-message'));  
			         break;    
			        
			         default:
			         $everythingfine=true;
			                
		    }
	       // everthing is selected, reterive from the data list of published coures for the selected criteria
	      if ($everythingfine) {
	         $this->__init_search();
	         $program_type_id=$this->AcademicYear->equivalent_program_type(
	         $this->request->data['Student']['program_type_id']);
	         
	         //debug($this->request->data['Student']['semester']);
	         $published_courses=$this->CourseAdd->PublishedCourse->find('all',
	         array('fields'=>array('id','section_id','semester','academic_year','year_level_id'),
	         'conditions'=>array('PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
	         'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
	         'PublishedCourse.program_type_id'=>$program_type_id,
	         'PublishedCourse.add'=>1,
	         'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
	         'PublishedCourse.academic_year like '=>$this->request->data['Student']['academic_year'].'%'
	         ),
	         'contain'=>array('Course'=>array('id','course_title','course_code','lecture_hours',
	         'tutorial_hours','credit'))));
	         //'PublishedCourse.id NOT IN (select published_course_id from course_adds where published_course_id is not null)
	         
	         $program=$this->CourseAdd->PublishedCourse->Program->field('name',array('id'=>$this->request->data['Student']['program_id']));
	         $programType=$this->CourseAdd->PublishedCourse->ProgramType->field('name',array('id'=>$this->request->data['Student']['program_type_id']));
	        if(empty($published_courses)) {
	              $this->Session->setFlash('<span></span>'.__('There is no published courses 
	              who need mass add for the selected criteria.', true),
	              'default',array('class'=>'error-box error-message'));
	        } else {
	             $section_ids=array();
	             $published_course_ids = array();
	             foreach ($published_courses as $pkk=>$pvv) {
	              if ($this->CourseAdd->ExamGrade->
	              is_grade_submitted($pvv['PublishedCourse']['id'])==0) {
	                   $section_ids[]=$pvv['PublishedCourse']['section_id'];
	                   $published_course_ids[]=$pvv['PublishedCourse']['id'];
	               }
	             }
	            $published_courses=$this->CourseAdd->PublishedCourse->find('all',
	         array('fields'=>array('id','section_id','semester','academic_year','year_level_id'),
	         'conditions'=>array('PublishedCourse.department_id'=>$this->request->data['Student']['department_id'],
	         'PublishedCourse.program_id'=>$this->request->data['Student']['program_id'],
	         'PublishedCourse.add'=>1,
	         'PublishedCourse.section_id'=>$section_ids,
	         'PublishedCourse.semester'=>$this->request->data['Student']['semester'],
	         'PublishedCourse.academic_year like '=>$this->request->data['Student']['academic_year'].'%'
	         ),
	         'contain'=>array('Course'=>array('id','course_title','course_code','lecture_hours',
	         'tutorial_hours','credit'))));
	         
	         
	             if(!empty($section_ids)) {
	           
	              $list_of_students_in_active_section=$this->CourseAdd->PublishedCourse->Section->StudentsSection->find('all',
	              array('conditions'=>array('StudentsSection.section_id'=>$section_ids,
	              'StudentsSection.archive'=>0)));
	             
	              $student_index=array();
	              $student_section_index = array();
	              foreach($list_of_students_in_active_section as $index=>$student){
	                    $course_add=$this->CourseAdd->find('count',array('conditions'=>
	                    array('CourseAdd.student_id'=>$student['StudentsSection']['student_id'],
	                    'CourseAdd.published_course_id'=>$published_course_ids)));
	                    if ($course_add==0) {
	                        $student_index[]=$student['StudentsSection']['student_id'];
	                        $student_section_index[$student['StudentsSection']['student_id']]=$student['StudentsSection']['section_id'];
	                    }
	              }
	             
	              $students=$this->CourseAdd->Student->find('all',
	              array('conditions'=>array('Student.department_id'=>$this->request->data['Student']['department_id'],
	              'Student.id'=>$student_index,'Student.program_type_id'=>$program_type_id,'Student.program_id'=>$this->request->data['Student']['program_id'],
	              'Student.id NOT IN (select student_id from graduate_lists)'),'fields'=>array('id','studentnumber','full_name'),'contain'=>array()));
	              
	              $sections=$this->CourseAdd->Student->Section->find('list',array('conditions'=>array('Section.id'=>$section_ids)));
	              //list of students organized by section.
	              $section_organized_students=array();
                    foreach ($section_ids as $id=>$section_id) {
                     
                          foreach($students as $st_index=>$studentdetail){
                                   
                                  if(in_array($studentdetail['Student']['id'],
                                  $student_index)){
                                    if ($section_id == $student_section_index[$studentdetail['Student']['id']]) {      
                                        $section_organized_students[$section_id][]=
                                        $studentdetail['Student'];
                                    }
                                }
                          }         
                     
                   }
	             
	            }
	            
	            if (empty($section_organized_students)) {
		        $this->Session->setFlash('<span></span>'.__('There is no section who need mass add for the selected criteria.'),'default',array('class'=>'error-box error-message'));
		        } else {
		        
		        
		        }
	            $this->set(compact('section_organized_students','published_courses','sections',
	            
	            'program','programType'));
	            
	          
	        }
	        
	      } 
	    }
	     
	      // drop the selected courses
	    if (!empty($this->request->data) && isset($this->request->params['form']['massadd'])) {
	          
	           //check for duplicate entry
	                $already_added_courses=array();
	                $selected_courses_add=array();
	                unset($this->request->data['Student']);
	                $count=0;
	                foreach ($this->request->data['CourseAdd'] as $cdd=>$cdv) {
	                       
	                        $check=$this->CourseAdd->find('count',array('conditions'=>$cdv,'recursive'=>-1));
	                      
	                        // already added, unset it
	                        if ($check>0) {
	                           $already_added_courses[]=$cdv['published_course_id'];
	                       
	                        } else {
	                            $selected_courses_add['CourseAdd'][$count]=$cdv;
	                            $selected_courses_add['CourseAdd'][$count]['department_approval']=1;
	                            $selected_courses_add['CourseAdd'][$count]['reason']='Published as add';
	                            $selected_courses_add['CourseAdd'][$count]['department_approved_by']='Published as add';
	                            $selected_courses_add['CourseAdd'][$count]['registrar_confirmed_by']=$this->Auth->user('id');
	                            $selected_courses_add['CourseAdd'][$count]['registrar_confirmation']=1;
	                            $count++;
	                        }
	                }
	                
		           if (count($already_added_courses)==count($this->request->data['CourseAdd'])) {
		                  $this->Session->setFlash('<span></span>'.__('All the selected courses has already  added for the selected sections. You do not need to add it again'),'default',array('class'=>'error-box error-message'));
	                     $this->redirect(array('action'=>'index'));
		            } else {
		                  unset($this->request->data);
		                  $this->request->data=$already_added_courses;
		            }
			       //saveAll
			       $this->set($this->request->data);
			    
			           if ($this->CourseAdd->saveAll($selected_courses_add['CourseAdd'],
			           array('validate'=>'first'))) {
				                $this->Session->setFlash('<span></span>'.__('The course add has been saved'),'default',
				                array('class'=>'success-box success-message'));
				                $this->Session->delete('search_data');
				                // save to course registration table
				              
				                $this->redirect(array('action' => 'index'));
			           } else {
				                $this->Session->setFlash('<span></span>'.__('The course add could not be saved. Please, try again.'),
				                'default',array('class'=>'error-box error-message'));
			           }
	        
	    }
	    
	     if ($this->role_id == ROLE_REGISTRAR) {
	        $year_level_find=$this->CourseAdd->YearLevel->find('all',
		   array('fields'=>array('DISTINCT YearLevel.name','YearLevel.id'),
		  'order'=>'YearLevel.name asc','group'=>'YearLevel.name','recursive'=>-1));
		    $extract=Set::extract('/YearLevel/name', $year_level_find);
		    $another=Set::extract('/YearLevel/id',$year_level_find);
		    $combined=array_combine($another, $extract);
		    $yearLevels=$combined;
		    $this->set(compact('yearLevels'));
		} else if ($this->role_id == ROLE_DEPARTMENT) {
		     $yearLevels = $this->CourseAdd->YearLevel->find('list',array('conditions'=>array(
		     'YearLevel.department_id'=>$this->department_id)));
		      $this->set(compact('yearLevels'));
		} else {
            $yearLevels = $this->CourseAdd->YearLevel->find('list');
            $this->set(compact('yearLevels'));
		
		}
        if (!empty($this->department_ids)) {
        $departments= $this->CourseAdd->PublishedCourse->Department->find('list',
        array('conditions'=>array(
		'Department.id'=>$this->department_ids)));
		$this->set(compact('departments'));  
		} else if (!empty($this->college_ids)) {
		  $colleges= $this->CourseAdd->PublishedCourse->College->find('list',
        array('conditions'=>array(
		'College.id'=>$this->college_ids)));
		$this->set(compact('colleges'));
		}
		$programTypes=$this->CourseAdd->PublishedCourse->ProgramType->find('list');
		$programs=$this->CourseAdd->PublishedCourse->Program->find('list');
	    $this->set(compact('departments','programTypes','programs'));
	}
	*/
	?>
