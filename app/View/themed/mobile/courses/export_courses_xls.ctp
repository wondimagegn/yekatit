<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */
    
     $xls->setHeader('Courses of '.$selected_curriculum_name);
     $xls->addXmlHeader();
     $xls->setWorkSheetName('Courses of '.$selected_curriculum_name);
     
     if(!empty($course_associate_array)){
	    $xls->openRow();
                $xls->writeString('College: '.$this_department_college_name);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Department: '.$selected_department_name);
        $xls->closeRow();  
        $xls->openRow();
                $xls->writeString('Program: '.$program_name);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Program Type: '.$program_type_name);
        $xls->closeRow(); 
        $xls->openRow();
                $xls->writeString('Curriculum: '.$selected_curriculum_name);
        $xls->closeRow(); 
		$xls->openRow();
		$xls->closeRow(); 		
        foreach($course_associate_array as $yearkey=>$yearvalue) {
			foreach($yearvalue as $semesterKey => $semestervalue) {
                $xls->openRow();
                    $xls->writeString('Year Level: '.$yearvalue[$semesterKey][0]['YearLevel']['name']);
                $xls->closeRow();    
                $xls->openRow();
                    $xls->writeString('Semester: '.$semesterKey);
                $xls->closeRow();
				$xls->openRow();
				$xls->closeRow(); 	 				
                $xls->openRow();
                     $xls->writeString('No');
                     $xls->writeString('Course Title');
                     $xls->writeString('Course Code');
                     $xls->writeString('Credit');
					 $xls->writeString('L T L');
                     $xls->writeString('Course Category');
                     $xls->writeString('Lecture Attendance Requirement');
                     $xls->writeString('Lab Attendance Requirement');
                     $xls->writeString('Grade Type');
                $xls->closeRow();
				$count=1;
                foreach ($semestervalue as $course) { 
                    $xls->openRow();
						 $xls->writeString($count++);
						 $xls->writeString($course['Course']['course_title']);
						 $xls->writeString($course['Course']['course_code']);
						 $xls->writeString($course['Course']['credit']);
						 $xls->writeString($course['Course']['course_detail_hours']);
						 $xls->writeString($course['CourseCategory']['name']);
						 $xls->writeString($course['Course']['lecture_attendance_requirement']);
						 $xls->writeString($course['Course']['lab_attendance_requirement']);
						 $xls->writeString($course['GradeType']['type']);
                    $xls->closeRow();
                }
				$xls->openRow();
				$xls->closeRow(); 	
			}
		}
	}
    $xls->addXmlFooter();
    exit();
?>
