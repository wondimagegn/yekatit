<?php
class ReportsController extends AppController {

	 public $name = 'Reports';
	 public $uses = array();
	 public $menuOptions = array(
                 //'title'=>'ljkasdfjklasdf',
                'exclude'=>array('index'),
                
            );
            
     public $helpers = array('Xls','Media.Media');  

	 public $components =array('EthiopicDateTime','AcademicYear','Email');
	
	 public function beforeFilter() {
		parent::beforeFilter();
		
		 $this->Auth->allow('stakeholder_report');	
	 }
	
	 public function beforeRender() {
		$acyear_array_data = $this->AcademicYear->acyear_array();
		//To diplay current academic year as default in drop down list
		$defaultacademicyear=$this->AcademicYear->current_academicyear();
		$this->set(compact('acyear_array_data','defaultacademicyear'));
	 }
	
	public function index() {
				$statArray=array();
				$currentSemester=ClassRegistry::init('AcademicCalendar')->currentSemesterInTheDefinedAcademicCalender($this->AcademicYear->current_academicyear());
				$currentAcademicYear=$this->AcademicYear->current_academicyear();	
				$admissionYear =$this->AcademicYear->get_academicYearBegainingDate($this->AcademicYear->current_academicyear());
	       
	       //Total student status 
		    $statArray['Student']['total']= ClassRegistry::init('Student')->find('count',array('recursive'=>-1));
		    $statArray['Student']['total_male']=ClassRegistry::init('Student')->find('count',array('recursive'=>-1,'conditions'=>array('Student.gender'=>'male')));
		    $statArray['Student']['total_female']=ClassRegistry::init('Student')->find('count',array('recursive'=>-1,'conditions'=>array('Student.gender'=>'female')));
			 $statArray['Student']['total_new_female']=ClassRegistry::init('Student')->find('count',array('conditions'=>array('Student.admissionyear >='=>$admissionYear,'Student.gender'=>'female'),'recursive'=>-1));
			 $statArray['Student']['total_new_male']=ClassRegistry::init('Student')->find('count',array('conditions'=>array('Student.admissionyear >='=>$admissionYear,'Student.gender'=>'male'),'recursive'=>-1));
			 $statArray['Student']['total_new']=ClassRegistry::init('Student')->find('count',
array('conditions'=>array('Student.admissionyear >='=>$admissionYear),'recursive'=>-1));
			 $statArray['Student']['total_graduate_overall']=ClassRegistry::init('GraduateList')->find('count',array('recursive'=>-1));
			 $statArray['Student']['total_graduate_new']=ClassRegistry::init('GraduateList')->find('count',array('conditions'=>array('GraduateList.graduate_date >='=>$admissionYear),'recursive'=>-1));
			 $statArray['Student']['total_graduate_new_female']=ClassRegistry::init('GraduateList')->find('count',array('conditions'=>array('GraduateList.graduate_date >='=>date('Y-m-d'),'GraduateList.student_id in (select id from students where gender="female") '),'recursive'=>-1));;
			 $statArray['Student']['total_graduate_new_male']=ClassRegistry::init('GraduateList')->find('count',array('conditions'=>array('GraduateList.graduate_date >='=>date('Y-m-d'),'GraduateList.student_id in (select id from students where gender="male") '),'recursive'=>-1));
     
           //Registration  and dismissal stat  
		    $statArray['Registration']['total_registration']=ClassRegistry::init('CourseRegistration')->find('count',
array('conditions'=>array('CourseRegistration.academic_year'=>$currentAcademicYear,'CourseRegistration.semester'=>$currentSemester),
 'group' => 'CourseRegistration.student_id','recursive'=>-1));
			  $statArray['Registration']['total_registration_female']=ClassRegistry::init('CourseRegistration')->find('count',
array('conditions'=>array('CourseRegistration.academic_year'=>$currentAcademicYear,'CourseRegistration.semester'=>$currentSemester,
'CourseRegistration.student_id in (select id from students where gender="female")'
),
 'group' => 'CourseRegistration.student_id','recursive'=>-1));
  $statArray['Registration']['total_registration_male']=ClassRegistry::init('CourseRegistration')->find('count',
array('conditions'=>array('CourseRegistration.academic_year'=>$currentAcademicYear,'CourseRegistration.semester'=>$currentSemester,
'CourseRegistration.student_id in (select id from students where gender="male")'
),'group' => 'CourseRegistration.student_id','recursive'=>-1));

		    $statArray['Registration']['total_active_student_in_section']=ClassRegistry::init('StudentsSection')->find('count',
array('conditions'=>array('StudentsSection.archive'=>0,
'StudentsSection.section_id in (select section_id from published_courses where semester="'.$currentSemester.'" and academic_year="'.$currentAcademicYear.'") ',
),'recursive'=>-1));
		  
			$statArray['Registration']['total_active_female_in_section']=ClassRegistry::init('StudentsSection')->find('count',array('conditions'=>array('StudentsSection.archive'=>0,
			'StudentsSection.student_id not in (select id from students where gender="female")',
'StudentsSection.section_id in (select section_id from published_courses where semester="'.$currentSemester.'" and academic_year="'.$currentAcademicYear.'")'),'group'=>'StudentsSection.student_id','recursive'=>-1));
            $statArray['Registration']['total_active_male_in_section']=ClassRegistry::init('StudentsSection')->find('count',array('conditions'=>array('StudentsSection.archive'=>0,
			'StudentsSection.student_id not in (select id from students where gender="male")',
'StudentsSection.section_id in (select section_id from published_courses where semester="'.$currentSemester.'" and academic_year="'.$currentAcademicYear.'") ',
),'group'=>'StudentsSection.student_id','recursive'=>-1));

            $statArray['Registration']['dismissalStat']=ClassRegistry::init('StudentExamStatus')->getNumberOfDismissedStudent($currentAcademicYear,$currentSemester);
			
			$gradeSubmissionDelay=ClassRegistry::init('CourseInstructorAssignment')->getGradeSubmissionStatNumber($currentAcademicYear,$currentSemester);
            debug($gradeSubmissionDelay);
			//debug($statArray);
		$this->set(compact('currentSemester','gradeSubmissionDelay','statArray','currentAcademicYear'));		
	}
    /*
	public function attration_rate() {
	    $options=array();
	    if(isset($this->request->data['getReport'])) {
	         $attrationRateAndYearLevel=ClassRegistry::init('StudentExamStatus')->getAttrationRate(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
                   $this->request->data['Report']['year_level_id'],
		   $this->request->data['Report']['region_id'],
		   $this->request->data['Report']['gender']
	        );
			//debug($attrationRateAndYearLevel);
            
	        $yearLevel=$attrationRateAndYearLevel['yearLevel'];
	        sort($yearLevel);
            unset($attrationRateAndYearLevel['yearLevel']);
	        $attrationRate=$attrationRateAndYearLevel;
	        $this->set(compact('attrationRate','yearLevel'));
	    }
	    $programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		
		if (!empty($this->department_ids) || !empty($this->college_ids)) {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
		} else {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);
		}
		$yearLevels =  ClassRegistry::init('YearLevel')->distinct_year_level(); 
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Students') + $departments;
		$yearLevels =   array(0 => 'All Year Level') + $yearLevels;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
                $default_year_level_id=null;
		 
		
		$this->set(compact('programs', 'program_types', 'departments',
		 'default_department_id', 'default_program_id', 'default_program_type_id','yearLevels','default_year_level_id'));
	
	}
	
	public function grade_change_stat() {
		$options=array();
	    if(isset($this->request->data['getReport'])) {
	        $gradeChangeStat=ClassRegistry::init('ExamGradeChange')->getGradeChangeStat(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id']
	        );
	        
	      //  debug($gradeChangeStat);
	        
	        if (empty($gradeChangeStat)) {
			       $this->Session->setFlash('<span></span>'.
	                         __('There is no report found for the given search criteria.'),
	                         'default',array('class'=>'info-box info-message'));
			}		
	    
	      
	        $this->set(compact('gradeChangeStat'));
	    }
	    $programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		if (!empty($this->department_ids) || !empty($this->college_ids)) {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
		} else {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);
		
		}
		
		
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Instructors') + $departments;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		
		$this->set(compact('programs', 'program_types', 'departments',
		 'default_department_id', 'default_program_id', 'default_program_type_id'));
	}
	
	public function grade_submission_stat() {
		$options=array();
	    if(isset($this->request->data['getReport'])) {
	        $gradeSubmissionDelay=ClassRegistry::init('CourseInstructorAssignment')->getGradeSubmissionDelayStat(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id']
	        );
	        
	        if (empty($gradeSubmissionDelay)) {
			       $this->Session->setFlash('<span></span>'.
	                         __('There is no report found for the given search criteria.'),
	                         'default',array('class'=>'info-box info-message'));
			}		
	    
	      
	        $this->set(compact('gradeSubmissionDelay'));
	    }
	    $programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		if (!empty($this->department_ids) || !empty($this->college_ids)) {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
		} else {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);

		debug($departments);
		
		}
		
		
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Instructors') + $departments;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		
		$this->set(compact('programs', 'program_types', 'departments',
		 'default_department_id', 'default_program_id', 'default_program_type_id'));
	}
	
	public function top_female() {
         $options=array();
	     if(isset($this->request->data['getReport'])) {
	        if (isset($this->request->data['Report']['top']) && !empty($this->request->data['Report']['top'])) {
	              $top=ClassRegistry::init('StudentExamStatus')->getTopScorer(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['top'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id']
	                
	            );
	            if (isset($top) && !empty($top)) {
	                $this->set(compact('top'));
	              
	            } else {
	                $this->Session->setFlash('<span></span>'.
	                         __('There is no report found for the given search criteria.'),
	                         'default',array('class'=>'info-box info-message'));
	            }
	           
	       } else {
	            $this->Session->setFlash('<span></span>'.
	                         __('Please provide the number of top student you want.'),
	                         'default',array('class'=>'info-box info-message'));
	       }
	      
	    } 
	    $programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		if (!empty($this->department_ids) || !empty($this->college_ids)) {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
		} else {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege3(1);
		
		}
		
		$yearLevels =  ClassRegistry::init('YearLevel')->distinct_year_level(); 
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Student') + $departments;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		
		$this->set(compact('programs', 'program_types', 'departments',
		 'default_department_id', 'default_program_id', 'default_program_type_id','yearLevels'));		
	}
	
	public function dismissed_list() {
		$options=array();
	     if(isset($this->request->data['getReport'])) {
	      
	        $dismissedStudent=ClassRegistry::init('StudentExamStatus')->getDismissedStudent(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id']
	              
	            );
	            
	         
	         if (empty($dismissedStudent)) {
	            $this->Session->setFlash('<span></span>'.
	                         __('There is no report found for the given search criteria.'),
	                         'default',array('class'=>'info-box info-message'));
	         } else {
	           $this->set(compact('dismissedStudent'));     
	         }
	    } 
	    $programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		if (!empty($this->department_ids) || !empty($this->college_ids)) {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
		} else {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege3(1);
		
		}
		
		
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Student') + $departments;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		
		$this->set(compact('programs', 'program_types', 'departments',
		 'default_department_id', 'default_program_id', 'default_program_type_id'));		
	}
    
	public function enroll_stat() {
		
	     $options=array();
	    if(isset($this->request->data['getReport'])) {
	       // debug($this->request->data);
	        $attrationRateAndYearLevel=ClassRegistry::init('CourseRegistration')->getRegistrationStats(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
	            $this->request->data['Type']
	        );
	        debug($attrationRateAndYearLevel);
	        $yearLevel=$attrationRateAndYearLevel['YearLevel'];
	        sort($yearLevel);
	        $attrationRate=$attrationRateAndYearLevel['attractionRate'];
	        $this->set(compact('attrationRate','yearLevel'));
	    }
	    $programs = ClassRegistry::init('Program')->find('list');
		$program_types = ClassRegistry::init('ProgramType')->find('list');
		
		if (!empty($this->department_ids) || !empty($this->college_ids)) {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);

		} else {
		  $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);
		}
		
		$programs = array(0 => 'All Programs') + $programs;
		$program_types = array(0 => 'All Program Types') + $program_types;
		$departments = array(0 => 'All University Students') + $departments;
		$default_department_id = null;
		$default_program_id = null;
		$default_program_type_id = null;
		
		$this->set(compact('programs', 'program_types', 'departments',
		 'default_department_id', 'default_program_id', 'default_program_type_id'));
	}
    */
	public function general_report() {

	  if(isset($this->request->data['getReport']) || 
	  	isset($this->request->data['getReportExcel'])) {
        
	     if($this->request->data['Report']['report_type']=='attrition_rate') {
	     	$attrationRateAndYearLevel=ClassRegistry::init('Student')->findAttrationRate(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
                   $this->request->data['Report']['year_level_id'],
		   $this->request->data['Report']['region_id'],
		   $this->request->data['Report']['gender']
	        );
	         $years=$this->__years($this->request->data['Report']['department_id']);
	      
	        $attrationRate=$attrationRateAndYearLevel;
	        $showFromToBlock=true;
	        $this->set(compact('attrationRate','years','showFromToBlock'));
            if($this->request->data['Report']['report_type']=='attrition_rate' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Attrition Rate -'.date('Ymd H:i:s');

	            $this->set(compact('attrationRate','years','filename'));
				$this->render('/Elements/reports/xls/attration_rate_stats_xls');
				return;	
	       } 
		   

	     } else if($this->request->data['Report']['report_type']=='admittedMoreThanOneProgram') {

	     	$admittedMoreThanOneProgram=ClassRegistry::init('Student')->admittedMoreThanOneProgram($this->request->data['Report']['department_id']);
	     	debug($admittedMoreThanOneProgram);
	        
	       
	        $showFromToBlock=true;
	        $this->set(compact('admittedMoreThanOneProgram','years','showFromToBlock'));
            if($this->request->data['Report']['report_type']=='admittedMoreThanOneProgram' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Amitted In Multiple Programs-'.date('Ymd H:i:s');

	            $this->set(compact('admittedMoreThanOneProgram','filename'));
				$this->render('/Elements/reports/xls/admitted_in_multiple_program_xls');
				return;	
	       } 
		   


	     } else if($this->request->data['Report']['report_type']=='top_students') {


		    $top=ClassRegistry::init('StudentExamStatus')->getTopScorer(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['top'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id'],
				$this->request->data['Report']['gpa']

			);

		     $showFromToBlock=true;
             $this->set(compact('top','showFromToBlock'));
		    if($this->request->data['Report']['report_type']=='top_students' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Top Student List -'.date('Ymd H:i:s');

	            $this->set(compact('top','filename'));
				$this->render('/Elements/reports/xls/top_student_xls');
				return;	
	       } 
		
		    
	     } else if($this->request->data['Report']['report_type']=='dismissed_student_list') {
                  $dismissedList=ClassRegistry::init('StudentExamStatus')->getDismissedStudent(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
			$this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']    
	            );
            $headerLabel=$this->__label('List of academically Dismissed Students',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		    $showFromToBlock=true;
		    $this->set(compact('dismissedList','showFromToBlock','headerLabel'));
		    if($this->request->data['Report']['report_type']=='dismissed_student_list' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Dismissed Student List -'.date('Ymd H:i:s');

	            $this->set(compact('dismissedList','filename','headerLabel'));
				$this->render('/Elements/reports/xls/dismissed_list_xls');
				return;	
	       } 

	     } else if ($this->request->data['Report']['report_type']=='notRegisteredList') {


	     	 $notRegisteredList=ClassRegistry::init('Student')->getNotRegisteredList(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
			$this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']    
	            );
	          
             $headerLabel=$this->__label('List of not registered  students',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		    $showFromToBlock=true;
		  
		    $this->set(compact('notRegisteredList','showFromToBlock','headerLabel'));
              
	          if($this->request->data['Report']['report_type']=='notRegisteredList' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Not Registered Student List -'.date('Ymd H:i:s');

	            $this->set(compact('notRegisteredList','filename','showFromToBlock','headerLabel'));
		    
				$this->render('/Elements/reports/xls/not_registered_list_xls');
				return;	
	       } 
	           
	     } else if($this->request->data['Report']['report_type']=='registeredList'){
	     
	     	 $registeredList=ClassRegistry::init('Student')->getRegisteredStudentList(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
			$this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']);
	          
             $headerLabel=$this->__label('List of  registered  students',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		    $showFromToBlock=true;
		  
		    $this->set(compact('registeredList','showFromToBlock','headerLabel'));
		    
		     if($this->request->data['Report']['report_type']=='registeredList' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Registered Student List -'.date('Ymd H:i:s');

	            $this->set(compact('registeredList','filename','showFromToBlock','headerLabel'));
		    
				$this->render('/Elements/reports/xls/registered_list_xls');
				return;	
	       } 

	     } else if ($this->request->data['Report']['report_type']=='active_student_list') {
	     	debug($this->request->data);
	     	$activeList=ClassRegistry::init('StudentExamStatus')->getActiveStudent(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
			$this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']    
	            );
           
            $headerLabel=$this->__label('List of active students',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		    $showFromToBlock=true;
		    $academicStatus=classRegistry::init('AcademicStatus')->find('list');
		    $this->set(compact('activeList','showFromToBlock','headerLabel','academicStatus'));
		    if($this->request->data['Report']['report_type']=='active_student_list' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Active Student List -'.date('Ymd H:i:s');

	            $this->set(compact('activeList','filename','headerLabel'));
				$this->render('/Elements/reports/xls/active_list_xls');
				return;	
	       } 

	     } else if($this->request->data['Report']['report_type']=='grade_change_statistics') {

		 $gradeChangeStat=ClassRegistry::init('ExamGradeChange')->getInstGradeChangeStat(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id']
	        );
        $showFromToBlock=true;
		$this->set(compact('gradeChangeStat','showFromToBlock'));

	     } else if($this->request->data['Report']['report_type']=='lateGradeSubmission') {
                $gradeSubmissionDelay=ClassRegistry::init('StudentExamStatus')->getNotGradeSubmittedList(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
	            $this->request->data['Report']['year_level_id']
	        );

             $headerLabel=$this->__label('Grade Not Submitted For ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id']);
              $showFromToBlock=true;
             $this->set(compact('gradeSubmissionDelay','headerLabel','showFromToBlock'));
             if($this->request->data['Report']['report_type']=='lateGradeSubmission' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Grade Not Submitted List  -'.date('Ymd H:i:s');
	            $this->set(compact('gradeSubmissionDelay','headerLabel','filename'));
				$this->render('/Elements/reports/xls/grade_submission_stat_xls');
				return;	
	       } 

	     } else if($this->request->data['Report']['report_type']=='delayedCountGradeSubmissionList'){

	     	$delayedGradeSubmissionReportList=ClassRegistry::init('StudentExamStatus')->getDelayedGradeSubmissionList(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
	            $this->request->data['Report']['year_level_id']
	        );

             $headerLabel=$this->__label('Late Grade Submitted Report List For ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id']);
              $showFromToBlock=true;
             $this->set(compact('delayedGradeSubmissionReportList','headerLabel','showFromToBlock'));
             if($this->request->data['Report']['report_type']=='lateGradeSubmission' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Late Grade Submitted Report List -'.date('Ymd H:i:s');
	            $this->set(compact('delayedGradeSubmissionReportList','headerLabel','filename'));
				$this->render('/Elements/reports/xls/grade_submission_stat_xls');
				return;	
	       } 


	     } else if($this->request->data['Report']['report_type']=='gradeSubmittedInstructorList') {

	     	        $gradeSubmissionDelay=ClassRegistry::init('StudentExamStatus')->getGradeSubmittedInstructorList(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
	            $this->request->data['Report']['year_level_id']
	        );
	     	        debug($gradeSubmissionDelay);

             $headerLabel=$this->__label('Grade  Submitted For ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id']);
              $showFromToBlock=true;
             $this->set(compact('gradeSubmissionDelay','headerLabel','showFromToBlock'));
             if($this->request->data['Report']['report_type']=='gradeSubmittedInstructorList' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Grade Submitted Instructor List  -'.date('Ymd H:i:s');
	            $this->set(compact('gradeSubmissionDelay','headerLabel','filename'));
				$this->render('/Elements/reports/xls/grade_submission_stat_xls');
				return;	
	       } 


	     } else if ($this->request->data['Report']['report_type']=='notAssignedCourseeList') {
	     
	      $notAssignedCourseeList=ClassRegistry::init('CourseInstructorAssignment')->getCourseNotAssigned(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	          $this->request->data['Report']['program_id'],
	           $this->request->data['Report']['program_type_id'],
	            $this->request->data['Report']['department_id'],
	            $this->request->data['Report']['year_level_id']
	        );
			
            $headerLabel=$this->__label('Course not assigned lists for ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id']);
              $showFromToBlock=true;
             $this->set(compact('notAssignedCourseeList','headerLabel','showFromToBlock'));
             if($this->request->data['Report']['report_type']=='notAssignedCourseeList' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Course not assigned list for -'.date('Ymd H:i:s');
	            $this->set(compact('notAssignedCourseeList','headerLabel','filename'));
				$this->render('/Elements/reports/xls/course_not_assigned_xls');
				return;	
	       } 
	       
	     
	     } else if($this->request->data['Report']['report_type']=='getGradeChangeList') {
             $gradeChangeLists=ClassRegistry::init('StudentExamStatus')->getGradeChangeList(
	            $this->request->data['Report']['acadamic_year'],
	            $this->request->data['Report']['semester'],
	            
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                $this->request->data['Report']['year_level_id']
	            );
             $headerLabel=$this->__label('Grade Change List For ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
              $showFromToBlock=true;
             $this->set(compact('gradeChangeLists','headerLabel','showFromToBlock'));
             if($this->request->data['Report']['report_type']=='getGradeChangeList' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Grade Change List For -'.date('Ymd H:i:s');
	            $this->set(compact('gradeChangeLists','headerLabel','filename'));
				$this->render('/Elements/reports/xls/grade_change_list_xls');
				return;	
	       } 
		 
           
	    } else if($this->request->data['Report']['report_type']=='graduated')  {
              
              $graduated=ClassRegistry::init('StudentExamStatus')->getGraduatingStudent(
	            $this->request->data['Report']['acadamic_year'],
	            
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['region_id']
	            );
              $showFromToBlock=true;
              $this->set(compact('graduated','showFromToBlock'));

	   } else if ($this->request->data['Report']['report_type']=='graduatedRateCompareToEntry') {

	   	   $graduateRateToEntry=ClassRegistry::init('StudentExamStatus')->getGraduatingRateToEntryStudent(
	            $this->request->data['Report']['acadamic_year'],
	            
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['region_id']
	            );
              $showFromToBlock=true;
              $this->set(compact('graduateRateToEntry','showFromToBlock'));

              if($this->request->data['Report']['report_type']=='graduatedRateCompareToEntry' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Graduation Entry and Admitted Statistics -'.date('Ymd H:i:s');
	             $this->set(compact('graduateRateToEntry','showFromToBlock','filename'));
				$this->render('/Elements/reports/xls/grade_change_list_xls');
				return;	
	       } 


	   } else if ($this->request->data['Report']['report_type']=='academic_status_range') {
			
			
		    $resultBy=ClassRegistry::init('StudentExamStatus')->getStudentByResult(
	            $this->request->data['Report']['acadamic_year'],
				 $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	               
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id'],
    $this->request->data['Report']['from'],
$this->request->data['Report']['to'],
	$this->request->data['Report']['academic_status_id'],
	$this->request->data['Report']['type']
	            ); 
	    $showFromToBlock=true;
		
		$this->set(compact('showFromToBlock','resultBy'));   
		if($this->request->data['Report']['report_type']=='academic_status_range' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='List of student by result range -'.date('Ymd H:i:s');

	            $this->set(compact('resultBy','filename'));
				$this->render('/Elements/reports/xls/result_range_list_xls');
				return;	
	       } 
		         

	   } else if ($this->request->data['Report']['report_type']=='distributionStatsGender') {
                $distributionStatistics=ClassRegistry::init('Student')->getDistributionStats(
	            $this->request->data['Report']['acadamic_year'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']
	            ); 
	         $showFromToBlock=true;
	       $years=$this->__years($this->request->data['Report']['department_id']);
		   
		   $headerLabel=$this->__label('Distribution Statistics By Gender ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		    debug($distributionStatistics);
	       if($this->request->data['Report']['report_type']=='distributionStatsGender' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Gender-'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/reports/xls/distribution_gender_xls');
				return;	
	       } 
           $this->set(compact('distributionStatistics','showFromToBlock','years','headerLabel'));
	  } else if ($this->request->data['Report']['report_type']=='distributionStatsLetterGrade'){ 
             $distributionStatsLetterGrade=ClassRegistry::init('Student')->distributionStatsLetterGrade(
	            $this->request->data['Report']['acadamic_year'],
	            $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']
	            ); 
             $headerLabel=$this->__label('Distribution Statistics of Letter Grade ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);

            $letterGrades=ClassRegistry::init('Grade')->find('list',array('fields'=>array('Grade.grade','Grade.grade'),'order'=>array('Grade.grade ASC')));
           $this->set(compact('distributionStatsLetterGrade','letterGrades','headerLabel'));

           if($this->request->data['Report']['report_type']
	       	=='distributionStatsLetterGrade' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Statistics of Letter Grade-'.date('Ymd H:i:s');
	            $this->set(compact('distributionStatsLetterGrade','letterGrades','filename','headerLabel'));
				$this->render('/Elements/reports/xls/distribution_stats_letter_grade_xls');
				return;	
	       } 

	  } else if ($this->request->data['Report']['report_type']=='listFx'){ 

	  	 $studentList=ClassRegistry::init('Student')->listStudentByLetterGrade(
	            $this->request->data['Report']['acadamic_year'],
	            $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id'],"Fx"
	            ); 
             $headerLabel=$this->__label('List Fx Students ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
           $this->set(compact('studentList','headerLabel'));
            if($this->request->data['Report']['report_type']
	       	=='listFx' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='List Fx Student-'.date('Ymd H:i:s');
                 $this->set(compact('studentList','filename','headerLabel'));
				$this->render('/Elements/reports/xls/list_bygrade_student_xls');
				return;	
	       } 
          

	  } else if($this->request->data['Report']['report_type']=='listNG'){

	  	 $studentList=ClassRegistry::init('Student')->listStudentByLetterGrade(
	            $this->request->data['Report']['acadamic_year'],
	            $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id'],
			"NG"
	            ); 
             $headerLabel=$this->__label('List NG Students ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
           $this->set(compact('studentList','headerLabel'));

            if($this->request->data['Report']['report_type']
	       	=='listNG' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='List NG Student-'.date('Ymd H:i:s');
                 $this->set(compact('studentList','filename','headerLabel'));
				$this->render('/Elements/reports/xls/list_bygrade_student_xls');
				return;	
	       } 

	  } else if ($this->request->data['Report']['report_type']=='distributionStatsGenderAndRegion') {
                $distributionStatistics=ClassRegistry::init('Student')->getDistributionStatsOfRegion(
	            $this->request->data['Report']['acadamic_year'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']
	            ); 
	        debug($distributionStatistics);
	        $showFromToBlock=true;
            $headerLabel=$this->__label('Distribution Statistics By Region ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		 
		    $years=$this->__years($this->request->data['Report']['department_id']);
	       if($this->request->data['Report']['report_type']
	       	=='distributionStatsGenderAndRegion' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Region-'.date('Ymd H:i:s');

	            $this->set(compact('distributionStatistics','filename','years','headerLabel'));
				$this->render('/Elements/reports/xls/distribution_region_xls');
				return;	
	       } 
           $this->set(compact('distributionStatistics','showFromToBlock','years','headerLabel'));
	  } else if ($this->request->data['Report']['report_type']=='distributionStatsStatus') {
                $distributionStatisticsStatus=ClassRegistry::init('Student')->getDistributionStatsOfStatus(
	            $this->request->data['Report']['acadamic_year'],
	             $this->request->data['Report']['semester'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['year_level_id'],
			$this->request->data['Report']['region_id']); 
			$years=$this->__years($this->request->data['Report']['department_id']);
	        $academicStatus=ClassRegistry::init('AcademicStatus')->find('list');
	        $headerLabel=$this->__label('Distribution Statistics By Academic Status ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],
	               $this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		 
		    $years=$this->__years($this->request->data['Report']['department_id']);

	    $this->set(compact('distributionStatisticsStatus','showFromToBlock','academicStatus','years','headerLabel')); 

	     if($this->request->data['Report']['report_type']
	       	=='distributionStatsStatus' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Status-'.date('Ymd H:i:s');
	             $this->set(compact('distributionStatisticsStatus','academicStatus','years','filename','headerLabel')); 
				$this->render('/Elements/reports/xls/distribution_status_xls');
				return;	
	       }  
	  } else if ($this->request->data['Report']['report_type']=='distributionStatsGraduate') {
                $distributionStatsGraduate=ClassRegistry::init('Student')->getDistributionStatsOfGraduate(
	            $this->request->data['Report']['acadamic_year'],
	              $this->request->data['Report']['program_id'],
	               $this->request->data['Report']['program_type_id'],
	                $this->request->data['Report']['department_id'],
	                 $this->request->data['Report']['gender'],
			$this->request->data['Report']['region_id']); 
		
		$headerLabel=$this->__label('Distribution Statistics By Graduates  ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id'],
	               $this->request->data['Report']['gender']);
		 
        $academicStatus=ClassRegistry::init('AcademicStatus')->find('list');
	    $this->set(compact('distributionStatsGraduate','showFromToBlock','academicStatus','years',
	    	'headerLabel')); 

	     if($this->request->data['Report']['report_type']
	       	=='distributionStatsGraduate' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Distribution Stat Graduate-'.date('Ymd H:i:s');
	             $this->set(compact('distributionStatsGraduate','academicStatus','filename',
	             	'headerLabel')); 
				$this->render('/Elements/reports/xls/distribution_graduate_xls');
				return;	
	       }  
	  }
	 
	 
	$default_department_id = $this->request->data['Report']['department_id'];
	$default_program_id = $this->request->data['Report']['program_id'];
	$default_program_type_id = $this->request->data['Report']['program_type_id'];
	$academic_year_selected = $this->request->data['Report']['acadamic_year'];

	$program_id = $this->request->data['Report']['program_id'];
	$program_type_id = $this->request->data['Report']['program_type_id'];
		   
	}
    	  $report_type_options = array(
    	  	'Distribution'=>array(
    	 	'distributionStatsGender'=>'Distribution Statistics Gender',
    	 	'distributionStatsGenderAndRegion'=>'Distribution Statistics By Region',
    	 	//'distributionStatsGrade'=>'Distribution Statistics Grade',
    	 	'distributionStatsStatus'=>'Distribution Statistics By Status',
    	 	//'grade_change_statistics' => 'Distribution Statistics Grade Change',
    	 	'distributionStatsGraduate' => 'Distribution Statistics Graduated',
    	 	'distributionStatsLetterGrade'=>'Distribution Statistics Letter Grade',
    	 	'graduatedRateCompareToEntry'=>'Distribution Statistics of Graduate With Entry',
    	 	'enrollStatistics'=>'Enroll Statistics',

    	 	),
    	  	
    	  	'List'=>array(
    	  		   'active_student_list'=>'Active Student List',
                   'dismissed_student_list' => 'Dismissed Student List',
    	  			'top_students'=>'Top Students List',
    	  			'academic_status_range'=>'List By Result Range',
    	  			'getGradeChangeList'=>'Grade Change List',
    	  			'lateGradeSubmission'=>'List of not submitted grade',
    	  			
    	  			'gradeSubmittedInstructorList'=>'List Instructor submitted grade',
    	  			'delayedCountGradeSubmissionList'=>'Late Grade Submitted Instructor List',
    	  			'notAssignedCourseeList'=>'Not assigned course list',


    	  			'delayedCountGradeSubmissionList'=>'Late Grade Submitted Instructor List',

    	  			'listFx'=>'List Fx Students',
    	  			'listNG'=>'List NG Students',
    	  			'notRegisteredList'=>'Not Registered List',
    	  			'registeredList'=>'Registered List',
    	  			'admittedMoreThanOneProgram'=>'Admitted More Than One Program'

    	  		),
    	  	'Academic Status'=>array(
    	  		
    	  		'attrition_rate' => 'Attrition Rate',   
    	  		
    	  	 ),
    	 	);
      $regions=ClassRegistry::init('Region')->find('list');
	
	  $programs = ClassRegistry::init('Program')->find('list');
	  $program_types = ClassRegistry::init('ProgramType')->find('list');
	  $academicStatuses = ClassRegistry::init('AcademicStatus')->find('list');
	  //debug($academicStatuses);
	 if (!empty($this->department_ids) || 
!empty($this->college_ids)) {
	     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
	 } else {
	     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);
	 }
	$yearLevels =  ClassRegistry::init('YearLevel')->distinct_year_level(); 
	$programs = array(0 => 'All Programs') + $programs;
	$program_types = array(0 => 'All Program Types') + $program_types;
	if($this->role_id == ROLE_DEPARTMENT){
    	$departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(0, 
		$this->department_id, array());
	} else if ($this->role_id==ROLE_COLLEGE) {
       $departments =  ClassRegistry::init('Department')->allDepartmentsByCollege2(1, array(), $this->college_id);
	} else {
		$departments = array(0 => 'All University Students') + $departments;
	}
	
	$yearLevels =   array(0 => 'All Year Level') + $yearLevels;
	$regions = array(0=>'All')+$regions;

	$default_department_id = null;
	$default_program_id = null;
	$default_program_type_id = null;
        $default_year_level_id=null;
	$default_year_level_id=null;
	$default_region_id = null;
	$graph_type=array('bar'=>'Bar Chart',
'pie'=>'Pie Chart','line'=>'Line Chart');		
	  $this->set(compact('departments','regions','academicStatuses','graph_type','default_region_id','program_types',
'programs','default_program_type_id','graph_type','student_lists','default_program_id',
'default_department_id','report_type_options','default_year_level_id','yearLevels'));
	}	

	public function stakeholder_report() {
      
       
	  if(isset($this->request->data['getReport']) || 
	  	isset($this->request->data['getReportExcel'])) {
        
	     if($this->request->data['Report']['report_type']=='currentlyActiveStudentStatistics') {
	     	$currentlyActiveStudentStatistics=ClassRegistry::init('Student')->getActiveStudentStatistics(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	            $this->request->data['Report']['department_id'],
		   $this->request->data['Report']['region_id'],
		    $this->request->data['Report']['program_id'],
		     $this->request->data['Report']['program_type_id'],
		   $this->request->data['Report']['gender']
	        );

	        $headerLabel=$this->__label('Current Active Students ',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id']);
	        $program_types = ClassRegistry::init('ProgramType')->find('list');
             if($this->request->data['Report']['report_type']=='currentlyActiveStudentStatistics' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Active Student Statistics -'.date('Ymd H:i:s');
	            $this->set(compact('currentlyActiveStudentStatistics','headerLabel','program_types','filename'));
				$this->render('/Elements/reports/xls/stakeholders/active_student_stat_xls');
				return;	
	       } 

             $this->set(compact('currentlyActiveStudentStatistics','headerLabel'));
	     
	     } else if($this->request->data['Report']['report_type']=='studentConstituencyByAgeGroup') {
	     		$studentConstituencyByAgeGroup=ClassRegistry::init('Student')->getStudentConsistencyByAgeRangeStatistics(
	        $this->request->data['Report']['acadamic_year'],
	         $this->request->data['Report']['semester'],
	            $this->request->data['Report']['department_id'],
		   $this->request->data['Report']['region_id'],
		    $this->request->data['Report']['program_id'],
		     $this->request->data['Report']['program_type_id'],
		   $this->request->data['Report']['gender']
	        );

	     	$headerLabel=$this->__label('Student Distribution By Age Group',$this->request->data['Report']['acadamic_year'],$this->request->data['Report']['semester'],
	               $this->request->data['Report']['program_type_id'],$this->request->data['Report']['program_id'],$this->request->data['Report']['department_id']);
	        $program_types = ClassRegistry::init('ProgramType')->find('list');
	         $this->set(compact('studentConstituencyByAgeGroup','headerLabel','program_types'));

	          if($this->request->data['Report']['report_type']=='studentConstituencyByAgeGroup' 
	       	&& isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Active Student Statistics -'.date('Ymd H:i:s');
	            $this->set(compact('headerLabel','program_types','filename'));
				$this->render('/Elements/reports/xls/stakeholders/agegroup_student_stat_xls');
				return;	
	       } 


	     } else if($this->request->data['Report']['report_type']=='activeTeachersByDegree'){
	     	$getActiveTeacherByDegree=ClassRegistry::init('Staff')->getActiveTeacherByDegree(
	            $this->request->data['Report']['department_id'],
		   $this->request->data['Report']['gender']
	        );
           
	     	$headerLabel='Currently Teaching Teachers  Statistics'.$this->request->data['Report']['acadamic_year'];

	     	$educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree');
	         $this->set(compact('getActiveTeacherByDegree','headerLabel','educations'));

	          if($this->request->data['Report']['report_type']=='activeTeachersByDegree' && isset($this->request->data['getReportExcel'])){

		       	$this->autoLayout = false;
	            $filename='Currently Teaching Teachers  Statistics-'.date('Ymd H:i:s');
	            $this->set(compact('headerLabel','filename','getActiveTeacherByDegree','educations'));
				$this->render('/Elements/reports/xls/stakeholders/active_teacher_degree_stat_xls');
				return;	
	       } 
	     } else if($this->request->data['Report']['report_type']=='teachersOnStudyLeave'){ 

	     	$getTeachersOnStudyLeave=ClassRegistry::init('Staff')->getTeachersOnStudyLeave(
	            $this->request->data['Report']['department_id'],
		   $this->request->data['Report']['gender']
	        );
           
	     	$headerLabel='Teachers  On Study Leave '.$this->request->data['Report']['acadamic_year'];

	     	$educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree');
	         $this->set(compact('getTeachersOnStudyLeave','headerLabel','educations'));

	          if($this->request->data['Report']['report_type']=='teachersOnStudyLeave' && isset($this->request->data['getReportExcel'])){

		       	$this->autoLayout = false;
	            $filename='Teachers  On Study Leave-'.date('Ymd H:i:s');
	            $this->set(compact('headerLabel','filename','getTeachersOnStudyLeave','educations'));
				$this->render('/Elements/reports/xls/stakeholders/teacher_on_study_leave_stat_xls');
				return;	
	       } 

	     } else if($this->request->data['Report']['report_type']=='staffHDPCompletedTeachers'){
	     	$getStaffCompletedHDPStatistics=ClassRegistry::init('StaffStudy')->getStaffCompletedHDPStatistics(
	        $this->request->data['Report']['acadamic_year'],
	        
	            $this->request->data['Report']['department_id'],
		   
		   $this->request->data['Report']['gender']
	        );
            debug($getStaffCompletedHDPStatistics);
	     	$headerLabel='Teachers  HDP Training Statistics'.$this->request->data['Report']['acadamic_year'];

	     	 $completed=array('0'=>'Not Completed','1'=>'Completed');

	         $this->set(compact('getStaffCompletedHDPStatistics','headerLabel','completed'));

	          if($this->request->data['Report']['report_type']=='staffHDPCompletedTeachers' && isset($this->request->data['getReportExcel'])){
	       		
		       	$this->autoLayout = false;
	            $filename='Teachers  HDP Training -'.date('Ymd H:i:s');
	            $this->set(compact('headerLabel','filename'));
				$this->render('/Elements/reports/xls/stakeholders/teacher_completed_hdp_stat_xls');
				return;	
	       } 
	     } else if($this->request->data['Report']['report_type']=='activeTeachersByAcademicRank'){
	     	$getActiveTeacherByAcademicRank=ClassRegistry::init('Staff')->getActiveTeacherByAcademicRank(
	            $this->request->data['Report']['department_id'],
		   $this->request->data['Report']['gender']
	        );
           
	     	$headerLabel='Currently Teaching Teachers  By Academic Rank Statistics'.$this->request->data['Report']['acadamic_year'];

	     	$educations=array('Doctorate'=>'PhD','Master'=>'Master',
'Medical Doctor'=>'Medical Doctorate',
	    	'Degree'=>'Degree');
	    	$positions=array('4'=>'Lecturer','5'=>'Assistant Professor','6'=>'Associate Professor','7'=>'Professor');

	         $this->set(compact('getActiveTeacherByAcademicRank','headerLabel','educations','positions'));

	          if($this->request->data['Report']['report_type']=='activeTeachersByAcademicRank' && isset($this->request->data['getReportExcel'])){

		       	$this->autoLayout = false;
	            $filename='Currently Teaching Teachers  By Academic Rank Statistics-'.date('Ymd H:i:s');
	            $this->set(compact('headerLabel','filename','getActiveTeacherByAcademicRank','positions','educations'));
				$this->render('/Elements/reports/xls/stakeholders/active_teacher_academicrank_stat_xls');
				return;	
	       } 
	     } else if($this->request->data['Report']['report_type']=='specialNeedsStudentStatistics'){

	     }
	 
	$default_department_id = $this->request->data['Report']['department_id'];
	$default_program_id = $this->request->data['Report']['program_id'];
	$default_program_type_id = $this->request->data['Report']['program_type_id'];
	$academic_year_selected = $this->request->data['Report']['acadamic_year'];

	$program_id = $this->request->data['Report']['program_id'];
	$program_type_id = $this->request->data['Report']['program_type_id'];
		   
	}
    	  $report_type_options = array(
    	  	'Statistics'=>array(
    	 		'currentlyActiveStudentStatistics'=>'Currently Active Student Statistics',
    	 		'studentConstituencyByAgeGroup'=>'Student Constituency By Age Group',
    	 		
    	 		'staffHDPCompletedTeachers'=>'HDP Training Completed Teachers',
    	 	
    	 		'activeTeachersByDegree'=>'Currently Active Teachers By Degree',
    	 		'activeTeachersByAcademicRank'=>'Currently Active Teachers By Academic Rank',
    	 		'teachersOnStudyLeave'=>'Teachers On Study Leave',
    	 	
    	 		//'specialNeedsStudentStatistics'=>'Special Needs Students Statistics',
    	 		//todo 
    	 		//	'prospectiveGraduates'=>'Prospective graduates',
    	 		
    	 		// 'foreignStudents'=>'Foreign Students',
    	 		
    	 	),
    	  
    	 	);
      $regions=ClassRegistry::init('Region')->find('list');
	
	  $programs = ClassRegistry::init('Program')->find('list');
	  $program_types = ClassRegistry::init('ProgramType')->find('list');
	  $academicStatuses = ClassRegistry::init('AcademicStatus')->find('list');
	  //debug($academicStatuses);
	 if (!empty($this->department_ids) || 
!empty($this->college_ids)) {
	     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_ids, $this->college_ids);
	 } else {
	     $departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(1, 
		$this->department_id, $this->college_id);
	 }
	$yearLevels =  ClassRegistry::init('YearLevel')->distinct_year_level(); 
	$programs = array(0 => 'All Programs') + $programs;
	$program_types = array(0 => 'All Program Types') + $program_types;
	if($this->role_id == ROLE_DEPARTMENT){
    	$departments = ClassRegistry::init('Department')->allDepartmentsByCollege2(0, 
		$this->department_id, array());
	} else if ($this->role_id==ROLE_COLLEGE) {
       $departments =  ClassRegistry::init('Department')->allDepartmentsByCollege2(1, array(), $this->college_id);
	} else {
		$departments = array(0 => 'All University Students') + $departments;
	}
	
	$yearLevels =   array(0 => 'All Year Level') + $yearLevels;
	$regions = array(0=>'All')+$regions;

	$default_department_id = null;
	$default_program_id = null;
	$default_program_type_id = null;
        $default_year_level_id=null;
	$default_year_level_id=null;
	$default_region_id = null;
	$graph_type=array('bar'=>'Bar Chart',
'pie'=>'Pie Chart','line'=>'Line Chart');		
	  $this->set(compact('departments','regions','academicStatuses','graph_type','default_region_id','program_types',
'programs','default_program_type_id','graph_type','student_lists','default_program_id',
'default_department_id','report_type_options','default_year_level_id','yearLevels'));
	}	
	private function __years($college_idds){
		   $college_id = explode('~', $college_idds);
			if(count($college_id) > 1) {
			     $years =  ClassRegistry::init('YearLevel')->find('list',array('conditions'=>array('YearLevel.department_id in (select id from departments where college_id='.$college_id[1].' )'),
			     	'fields'=>array(
				'YearLevel.name','YearLevel.name')));
			} else if(!empty($college_idds)) {
                $years =  ClassRegistry::init('YearLevel')->find('list',array('conditions'=>array('YearLevel.department_id'=>$college_idds),
			     	'fields'=>array(
				'YearLevel.name','YearLevel.name')));
			} else {
				$years=ClassRegistry::init('YearLevel')->find('list',array(
			     	'fields'=>array(
				'YearLevel.name','YearLevel.name')));
			}
			return $years;
	}

	private function __label($prefix,$acadamic_year,$semester=null,$program_type_id,$program_id,$department_id,$gender){

		    $programs = ClassRegistry::init('Program')->find('list');
			$programTypes = ClassRegistry::init('ProgramType')->find('list');

		     $label='';
		     $name='';
		     $label.=$prefix.' '.$acadamic_year.' '.$semester.' of ';
		     if($program_type_id==0){
		     	$label.='all program types ';
		     } else {
		     	$label.=$programTypes[$program_type_id];
		     }

		     if($program_id==0){
		     	$label.='undergraduate/graduate ';
		     } else {
		     	$label.='in '.$programs[$program_id];
		     	debug($program_id);
		     }


		     if($gender=="all"){
		     	//$label.=' both gender';
		     }

		    $college_id = explode('~', $department_id);
			if(count($college_id) > 1) {
			     $namee=ClassRegistry::init('College')->find('first',array('conditions'=>array('College.id'=>$college_id[1]),
			     	'recursive'=>-1));
			     $name.=' '.$namee['College']['name'];
			} else if(!empty($department_id)) {
                 $namee=ClassRegistry::init('Department')->find('first',array('conditions'=>array('Department.id'=>$department_id),
			     	'recursive'=>-1));
                  $name.=' '.$namee['Department']['name'];
			} else if($department_id==0) {
				$name.='for all department';
			}
            $label.=$name;
            return $label;
	}
		
}
