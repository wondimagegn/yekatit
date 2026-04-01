<?php 
/*
This file should be in app/views/elements/export_xls.ctp
Thanks to Marco Tulio Santos for this simple XLS Report
*/
header ("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls" );
header ("Content-Description: Exported as XLS" );
?>
<?php
if(!isset($grade_view_only))
	$grade_view_only = false;
?>
<style>
table.grade_list tr td{
	padding:0px;
	vertical-align:middle;
}
</style>

<table class="fs13">
	<tr>
	  <td colspan="8" style="text-align:center">
			<?php 
			if(isset($university['University']['name'])) {
				echo $university['University']['name'];

			} else {
				echo '----';

			}
		

			?>
             </td>
	</tr>
	<tr>
	  <td colspan="8" style="text-align:center">
			
  OFFICE OF THE REGISTRAR
             </td>
	</tr>

   	<tr>
	    <td colspan="8" style="text-align:center">
		Mark Sheet	
             </td>
	</tr>

     	<tr>
	    <td>
		School/Center: 
             </td>
             <td>
		<?php 
			if(isset($publish_course_detail_info['Department']['College']['name'])) {
				echo $publish_course_detail_info['Department']['College']['name'];
			}
		?>
             </td>
	</tr>

       <tr>
	    <td>
		<?php 
			if(isset($publish_course_detail_info['Department']['name'])) {
				echo $publish_course_detail_info['Department']['name'];
			}
		?>
             </td>
             <td>
		<?php 
			if(isset($publish_course_detail_info['Section']['name'])) {
				echo $publish_course_detail_info['Section']['name'];
			}
		?>
             </td>
	     <td>
		 <?php 
			if(isset($publish_course_detail_info['Section']['YearLevel']['name'])) {
				echo $publish_course_detail_info['Section']['YearLevel']['name'];
			}
		?>
	     </td>
	     
	     <td>
		  <?php 
			if(isset($publish_course_detail_info['Course']['course_title'])) {
				echo $publish_course_detail_info['Course']['course_title'];
			}
		?>
	     </td>
	</tr>

       <tr>
	    <td>
		Department
             </td>
             <td>
		Section
             </td>
	     <td>
		CLASS YEAR
	     </td>
	    
	     <td>
		COURSE TITLE
	     </td>
	</tr>


	<tr>
	    <td>
		<?php 
			if(isset($publish_course_detail_info['Course']['course_code'])) {
				echo $publish_course_detail_info['Course']['course_code'];
			}
		?>
             </td>
             <td>
		<?php 
			if(isset($publish_course_detail_info['Course']['credit'])) {
				echo $publish_course_detail_info['Course']['credit'];
			}
		?>
             </td>
	   
	    
              <td>
		  <?php 
			echo $publish_course_detail_info['PublishedCourse']['semester'];
		?>
	     </td>

	    <td>
		  <?php 
			if(isset($publish_course_detail_info['CourseInstructorAssignment'][0]['Staff']['full_name'])) {
			    
				echo $publish_course_detail_info['CourseInstructorAssignment'][0]['Staff']['full_name'];
			} else {

                        	 echo 'Submitted by department';
		      }
		?>
	     </td>
             <td>
	             <?php 
			echo $publish_course_detail_info['PublishedCourse']['academic_year'];
		?>
	    </td>
	</tr>

	 <tr>
	    <td>
		Course N<u>o</u>
             </td>
             <td>
		   <?php 
			if(isset($publish_course_detail_info['Course']['Curriculum']['type_credit'])
&& $publish_course_detail['Course']['Curriculum']['type_credit']=="ECTS Credit Point") {
				echo 'ECTS Credit Point';
			} else {
				echo 'ECTS Credit Point';
			}
		?>
             </td>
	     <td>
		SEMESTER
	     </td>
	    
	     <td>
		INSTRUCTOR
	     </td>
	     <td>
		 ACADEMIC YEAR
	     </td>	
	</tr>
</table>

<table class="grade_list">
	   <tr>
		<th>&nbsp;</th>
	        <th>Student ID</th>
		<th>Student Name</th>
		<th>Sex</th>
		
		<?php
		$percent = 10;
		$last_percent = "";
		//It it is makeup exam entry
		if($grade_view_only) {
			//It is exam grade view only and there is nothing to do for now
			$percent = 10;
			$last_percent = 42;
		}
		else if($makeup_exam) {
			?><th>Total (100%)</th><?php
		$last_percent = 32;
		}
		//If it is not makeup exams (add and registered)
		else {
			$grade_width = 0;
			if($grade_submission_status['grade_submited'])
				$grade_width = 3;
			else if($display_grade || $view_only)
				$grade_width = 3;
			if(((100-28)/((count($exam_types)+1)+$grade_width)) > 10) {
				$last_percent = (100-28) - ((count($exam_types)+1+$grade_width)*10);
			}
			else
				$percent = ((100-28)/(count($exam_types)+1+$grade_width));
			$count_for_percent = 0;

			foreach($exam_types as $key => $exam_type) {
			$count_for_percent++;
			?>
			<th>
			<?php
			echo $exam_type['ExamType']['exam_name'].' ('.$exam_type['ExamType']['percent'].'%)';
			?>
			</th>
			<?php
			}
			?>
			<th>Total (100%)</th>
			<?php
		}
		//End of non-makeup exams
		
		//It it is submited grade or on "grade preview" state
		if($view_only || $grade_submission_status['grade_submited'] || $display_grade) {
			?>
			<th>Grade</th>
			
			<?php
		}
		?>
	</tr>
	<?php
	//Building every student exam result entry
	//if(!$makeup_exam) {
		if(!isset($total_student_count))
			$total_student_count = count($students);
		foreach($students as $key => $student) {
			$grade_history_count = 0;
			if(isset($student['freshman_program']) && $student['freshman_program'] == false) {
				$freshman_program = true;
				$approver = 'freshman program';
				$approver_c = 'Freshman Program';
			}
			else {
				$freshman_program = false;
				$approver = 'department';
				$approver_c = 'Department';
			}
			
			$total_100 = "";
			$st_count++;
		?>
		<tr>
			<td><?php echo $st_count; ?></td>
			<td><?php echo $student['Student']['studentnumber']; ?></td>
			<td><?php
			echo $student['Student']['first_name'].' '.$student['Student']['middle_name'].' '.$student['Student']['last_name']; ?></td>

			<td><?php

echo isset($student['Student']['gender']) && $student['Student']['gender']=='male' ? 'M':'F'; 


		?></td>
			
			<?php
			//If it is makeup exam entry
			if($grade_view_only) {
				//It is exam grade view only and there is nothing to do for now
			}
			else if($makeup_exam) {
				echo '<td>';
				if(!empty($student['ExamGradeChange']) && $student['ExamGradeChange'][0]['department_approval'] != -1) {
					echo ($student['MakeupExam']['result'] != null ? $student['MakeupExam']['result'] : '---');
				}
				else {
					if($display_grade || $view_only) {
						echo ($student['MakeupExam']['result'] != null ? $student['MakeupExam']['result'] : '---');
					}
					else {
						
					}
				}
				echo '</td>';
			}
			//If it is non-makeup exams (add and registered)
			else {
				$et_count = 0;
				//Each mark entry for each exam type (foreach loop)
				foreach($exam_types as $key => $exam_type) {
					$et_count++;
				?>
				<td>
				<?php
				$id = "";
				$value ="";
				//Searching for the exam result from the databse returned value
				if(isset($student['ExamResult']) && !empty($student['ExamResult'])) {
					foreach($student['ExamResult'] as $key => $examResult) {
						if($examResult['exam_type_id'] == $exam_type['ExamType']['id']) {
							$id = $examResult['id'];
							$value = $examResult['result'];
							$total_100 += $value;
							break;
						}
					}
				}
				//if save exam result button is clicked to add each exam result to get result sum
				$i = (($st_count-1)*count($exam_types))+1;
				
				if($display_grade || $view_only || (!empty($student['ExamGrade']) && $student['ExamGrade'][0]['department_approval'] != -1)) {
					echo ($value != "" ? $value : '---');
				}
				else {
					//It is if it is on exam result edit mode
					if($id != "") {
						echo ($value != "" ? $value : '---');
					}//End of exam result edit mode
					//New exam result entry
					else {
						
					}//End of new exam result entry
				}//echo ' - '.$count.' - '.$st_count;
				?>
				</td>
				<?php
				$count++;
				}//End of each mark entry for each exam type (foreach loop)
			?>
			<td id="total_100_<?php echo $st_count; ?>"><?php echo ($total_100 !== "" ? $total_100 : '---'); ?></td>
			<?php
			}//End of non-makeup exams result entry
			?>
			<?php
			if($view_only || $display_grade || $grade_submission_status['grade_submited']) {
			?>
			<td >
				<?php
					//GRADE
					//If the grade is from the database (regisration and add)
					$latest_grade_detail = $student['LatestGradeDetail'];
					
					if($display_grade && isset($student['GeneratedExamGrade']))
						echo $student['GeneratedExamGrade']['grade'];
					//If it is makeup exam
					//The following condition will be skipped if if makeup exam result is changed in the form of grade change or supplementary exam
					else if(isset($student['MakeupExam']) && (empty($student['ExamGradeChange']) || $student['ExamGradeChange'][0]['created'] >= $latest_grade_detail['ExamGrade']['created']))// && $latest_grade_detail['ExamGrade']['makeup_exam_result'] != null) 
					{//debug($student['ExamGradeChange']);
						//If the grade is from the database (makeup)
						if(isset($student['ExamGradeChange']) && !empty($student['ExamGradeChange'])) {
							if($student['ExamGradeChange'][0]['department_approval'] == -1)
								echo '<p class="rejected">';
							echo $student['ExamGradeChange'][0]['grade'];
							if($student['ExamGradeChange'][0]['department_approval'] == -1)
								echo '</p>';
						}
						//If the course is on progress (Neither generated or saved)
						else
							echo '**';
					}
					//If the result is about course registration and add 
					//considering makeup and exam change
					else if(!empty($latest_grade_detail['ExamGrade'])) {
						//If the grade from course registration or add
						if((!isset($latest_grade_detail['ExamGrade']['auto_ng_conversion']) || $latest_grade_detail['ExamGrade']['auto_ng_conversion'] == 0) && (!isset($latest_grade_detail['ExamGrade']['manual_ng_conversion']) || $latest_grade_detail['ExamGrade']['manual_ng_conversion'] == 0) && $latest_grade_detail['ExamGrade']['department_approval'] == -1)
							echo '<p class="rejected">';
						echo $latest_grade_detail['ExamGrade']['grade'];
						if($latest_grade_detail['ExamGrade']['department_approval'] == -1)
							echo '</p>';
						if(strcasecmp($latest_grade_detail['type'], 'Change') == 0) {
							if($latest_grade_detail['ExamGrade']['makeup_exam_id'] == null && $latest_grade_detail['ExamGrade']['makeup_exam_result'] != null)
								echo ' (Supplementary)';
							else if($latest_grade_detail['ExamGrade']['makeup_exam_result'] != null)
								echo ' (Makeup)';
							else
								echo ' (Change)';
						}
					}
					
					else
						echo '**';
				?>
			</td>
			
		</tr>
		<?php
	}
}
	//End of building every student exam result entry
	?>
</table>
