<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */
    
     $xls->setHeader('Master Sheet ');
     $xls->addXmlHeader();
     $xls->setWorkSheetName('Section '.$section_detail['name']);
     
     if(!empty($master_sheet['students_and_grades'])){
     
	    $xls->openRow();
                $xls->writeString('College: '.$college_detail['name']);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Program: '.$program_detail['name']);
        $xls->closeRow();  
        $xls->openRow();
                $xls->writeString('Program Type: '.$program_type_detail['name']);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Department: '. (!empty($department_detail['name']) && 
                $department_detail['name'] != "" ? $department_detail['name'] : 'Freshman Program'));
        $xls->closeRow(); 
        
        $xls->openRow();
                $xls->writeString('Academic Year: '. $academic_year);
        $xls->closeRow(); 
        
        $xls->openRow();
                $xls->writeString('Semester: '.$semester);
        $xls->closeRow(); 
        
		$xls->openRow();
		$xls->closeRow(); 	
		
		if(count($master_sheet['registered_courses']) > 0) {
		  	$xls->openRow();
			    $xls->writeString('No');
			    $xls->writeString('Course Title');
			    $xls->writeString('Course Code');
			    $xls->writeString('Cr. Hr.');
			   
		    $xls->closeRow();
		   
		    $registered_and_add_course_count = 0;
			$registered_course_credit_sum = 0;
			foreach($master_sheet['registered_courses'] as $key => $registered_course) {
				$registered_and_add_course_count++;
				$registered_course_credit_sum += $registered_course['credit'];
			    $xls->openRow();
				     $xls->writeString($registered_and_add_course_count);
				     $xls->writeString($registered_course['course_title']);
				     $xls->writeString($registered_course['course_code']);
				     $xls->writeString($registered_course['credit']);
			     $xls->closeRow();
			
			}
			
			$xls->openRow();
				     $xls->writeString('Total:'.$registered_course_credit_sum);	
			$xls->closeRow();
			
		
		}
		$xls->openRow();
		$xls->closeRow(); 	
		
		if(count($master_sheet['added_courses']) > 0) {
		  	$xls->openRow();
			    $xls->writeString('No');
			    $xls->writeString('Course Title');
			    $xls->writeString('Course Code');
			    $xls->writeString('Cr. Hr.');
			   
		    $xls->closeRow();
		   
		   $added_course_credit_sum = 0;
			foreach($master_sheet['added_courses'] as $key => $added_course) {
				$registered_and_add_course_count++;
				$added_course_credit_sum += $added_course['credit'];
				
			    $xls->openRow();
				     $xls->writeString($registered_and_add_course_count);
				     $xls->writeString($added_course['course_title']);
				     $xls->writeString($added_course['course_code']);
				     $xls->writeString($added_course['credit']);
			     $xls->closeRow();
			
			}
			
			$xls->openRow();
				     $xls->writeString('Total:'.$added_course_credit_sum);	
			$xls->closeRow();
			
		
		}
		
		$xls->openRow();
		$xls->closeRow(); 
		
		$xls->openRow();
			 $xls->writeString('');
			 $xls->writeString('');
			 $xls->writeString('');
			 $xls->writeString('');
			
		
		
		$registered_and_add_course_count = 0;
		
		foreach($master_sheet['registered_courses'] as $key => $registered_course) {
			$registered_and_add_course_count++;
			 $xls->writeString($registered_and_add_course_count);
			  $xls->writeString('');
		
			
		}
		
		foreach($master_sheet['added_courses'] as $key => $added_course) {
			$registered_and_add_course_count++;
		    $xls->writeString($registered_and_add_course_count);
		     $xls->writeString('');
		
		}
		
		  $xls->writeString('Semester');
		  $xls->writeString('');
		  $xls->writeString('');
		  $xls->writeString('Previous');
		  $xls->writeString('');
		  $xls->writeString('');
		  
	      $xls->writeString('Cumulative');
	      $xls->writeString('');
		  $xls->writeString('');
		  
		  $xls->writeString('Status');
		  
		
		
		$xls->closeRow();
		
	    $xls->openRow();
			 $xls->writeString('No');
			 $xls->writeString('Full Name');
			 $xls->writeString('ID NO');
			 $xls->writeString('Sex');
		
		    foreach($master_sheet['registered_courses'] as $key => $registered_course) {
		           $xls->writeString('G');
		           $xls->writeString('GP');
		    }
		
		    foreach($master_sheet['added_courses'] as $key => $added_course) {
			      $xls->writeString('G');
		           $xls->writeString('GP');
		    }
		
			 
			  $xls->writeString('CH');
			  $xls->writeString('GP');
			  $xls->writeString('SGPA');
			
			
			  $xls->writeString('CH');
			  $xls->writeString('GP');
			  $xls->writeString('SGPA');
			  
			  $xls->writeString('CH');
			  $xls->writeString('GP');
			  $xls->writeString('SGPA');
			    
		
		$xls->closeRow();
		
		$student_count = 0;
        foreach($master_sheet['students_and_grades'] as $key => $student) {
	        $credit_hour_sum = 0;
	        $gp_sum = 0;
	        $student_count++;
	        $xls->openRow();
	            $xls->writeString($student_count);
	            $xls->writeString($student['full_name']);
	            $xls->writeString($student['studentnumber']);
	            $xls->writeString((strcasecmp($student['gender'], 'male') == 0 ? 'M' : 'F'));
	       foreach($master_sheet['registered_courses'] as $key => $registered_course) {
			 if($student['courses']['r-'.$registered_course['id']]['registered'] == 1) {
			 	if(isset($student['courses']['r-'.$registered_course['id']]['grade'])) {
			 		   $xls->writeString($student['courses']['r-'.$registered_course['id']]['grade']);
			 		    $xls->writeString($student['courses']['r-'.$registered_course['id']]['grade']);
			 		
			 		
			 		if(isset($student['courses']['r-'.$registered_course['id']]['point_value'])) {
			 			$xls->writeString(number_format(($student['courses']['r-'.$registered_course['id']]['credit'] *
			 			 $student['courses']['r-'.$registered_course['id']]['point_value']), 2, '.', ''));
			 			 $gp_sum += ($student['courses']['r-'.$registered_course['id']]['credit'] * $student['courses']['r-'.$registered_course['id']]['point_value']);
			 		}
			 		
			 	}
			 	else {
			 	     $xls->writeString($student['courses']['r-'.$registered_course['id']]['droped'] == 1 ? 'DP' : '**');
			 	     $xls->writeString('');
			 	}
			 if($student['courses']['r-'.$registered_course['id']]['droped'] == 0)
			 	$credit_hour_sum += $student['courses']['r-'.$registered_course['id']]['credit'];
			 }
			 else {
			     $xls->writeString('---');
			 	 $xls->writeString('');
			 }
		}
		foreach($master_sheet['added_courses'] as $key => $added_course) {
			 if($student['courses']['a-'.$added_course['id']]['added'] == 1) {
			 	if(isset($student['courses']['a-'.$added_course['id']]['grade'])) {
			 	
			 		$xls->writeString($student['courses']['a-'.$added_course['id']]['grade']);
			 	    $xls->writeString('');
			 	 
			 		if(isset($student['courses']['a-'.$added_course['id']]['point_value'])) {
			 			 $xls->writeString(number_format(($student['courses']['a-'.$added_course['id']]['credit'] * 
			 			 $student['courses']['a-'.$added_course['id']]['point_value']), 2, '.', ''));
			 			$gp_sum += ($student['courses']['a-'.$added_course['id']]['credit'] * $student['courses']['a-'.$added_course['id']]['point_value']);
			 		}
			 		
			 	}
			 	else {
			 		
			 		$xls->writeString('***');
			 	    $xls->writeString('');
			 	}
			 $credit_hour_sum += $student['courses']['a-'.$added_course['id']]['credit'];
			 }
			 else {
			 	 $xls->writeString('---');
			 	 $xls->writeString('');
			 }
		}
		
		 $xls->writeString(!empty($student['StudentExamStatus']) ? 
		 $student['StudentExamStatus']['credit_hour_sum'] : '---'); 
		 $xls->writeString(!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['grade_point_sum'] : 
		 '---');
		 
		$xls->writeString(!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['sgpa'] : '---');

	  $xls->writeString(!empty($student['PreviousStudentExamStatus']) ? 
	  $student['PreviousStudentExamStatus']['previous_credit_hour_sum'] : '---');
	  
		$xls->writeString(!empty($student['PreviousStudentExamStatus']) ? 
		$student['PreviousStudentExamStatus']['previous_grade_point_sum'] : '---');
		
		$xls->writeString(!empty($student['PreviousStudentExamStatus']) ? 
		$student['PreviousStudentExamStatus']['cgpa'] : '---');
	
			if(!empty($student['StudentExamStatus']) && !empty($student['PreviousStudentExamStatus'])) {
				$xls->writeString(($student['StudentExamStatus']['credit_hour_sum']+
				$student['PreviousStudentExamStatus']['previous_credit_hour_sum']) - $student['deduct_credit']);
			}
			else if(!empty($student['StudentExamStatus'])) {
				
				$xls->writeString($student['StudentExamStatus']['credit_hour_sum']);
			}
			else if(!empty($student['PreviousStudentExamStatus'])) {
				$xls->writeString($student['PreviousStudentExamStatus']['previous_credit_hour_sum']);
			}
			else
				 $xls->writeString('---');
		
			if(!empty($student['StudentExamStatus']) && !empty($student['PreviousStudentExamStatus'])) {
			    $xls->writeString((($student['StudentExamStatus']['grade_point_sum']+
			    $student['PreviousStudentExamStatus']['previous_grade_point_sum']) - $student['deduct_gp']));
			}
			else if(!empty($student['StudentExamStatus'])) {
				
				 $xls->writeString($student['StudentExamStatus']['grade_point_sum']);
			}
			else if(!empty($student['PreviousStudentExamStatus'])) {
				
				  $xls->writeString($student['PreviousStudentExamStatus']['previous_grade_point_sum']);
			}
			else
			   $xls->writeString('---');
		
		
		 
          $xls->writeString((!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['cgpa'] : '---'));
	      $xls->writeString((!empty($student['AcademicStatus']) && 
		!empty($student['AcademicStatus']['id'])? $student['AcademicStatus']['name'] : '---'));  
	    
	     $xls->writeString('');
	    
	    $xls->closeRow();
	
	
	 }
		
		
		$xls->openRow();
		$xls->closeRow(); 	
	}
    $xls->addXmlFooter();
    exit();
?>
