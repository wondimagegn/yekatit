<?php ?>
<script>
$(document).ready(function () {
	$("#PublishedCourse").change(function(){
		//serialize form data
		var pc = $("#PublishedCourse").val().split('~', 2);
		if(pc.length > 1)
			window.location.replace("/exam_grades/<?php echo $this->action; ?>/"+pc[1]+"/section/"+$("#AcadamicYear").val()+"/"+$("#Semester").val());
		else
			window.location.replace("/exam_grades/<?php echo $this->action; ?>/"+pc[0]+"/pc/"+$("#AcadamicYear").val()+"/"+$("#Semester").val());
	});
});

function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}
</script>
<div class="examGrades <?php echo $this->action; ?>">
<?php echo $this->Form->create('ExamGrade');?>
<div class="smallheading"><?php __('Exam Grade View by Section');?></div>
<?php echo $this->element('publish_course_filter_by_dept'); ?>
<?php echo $this->Form->end(); ?>
<?php
//Displaying list of students with their grade
if(!empty($publishedCourses) && !isset($published_course_id)) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>Please select a course or section.</div>';
}
else if(isset($published_course_id) && count($master_sheet['students_and_grades']) <= 0) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>The system unable to find list of students for the selected section. Please contact the department for more information.</div>';
}
else if(isset($published_course_id) && empty($master_sheet['registered_courses']) && empty($master_sheet['added_courses'])) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>The system unable to find list of courses section students register and/or add.</div>';
}
else{
?>
<style>
.bordering {
border-left:1px #cccccc solid;
border-right:1px #cccccc solid;
}
.bordering2 {
border-left:1px #000000 solid;
border-right:1px #000000 solid;
}
.courses_table tr td, .courses_table tr th {
padding:1px
}
</style>
<table>
    <tr>
        <td colspan="2">
            <?php 
            echo $this->Html->link($this->Html->image("/img/xls-icon.gif",array("alt"=>"Export")),array(
            'controller'=>'examGrades',
            'action' =>'export_mastersheet_xls'),array('escape'=>false));
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				  <?php 
            echo $this->Html->link($this->Html->image("/img/pdf_icon.gif",array("alt"=>"Print")),array(
            'controller'=>'examGrades',
            'action' =>'export_mastersheet_pdf'),array('escape'=>false));
				?>
        </td>
    </tr>
	<tr>
		<td style="width:40%">
			<table class="fs13">
				<tr>
					<td style="width:30%">College:</td>
					<td style="width:70%; font-weight:bold"><?php echo $college_detail['name']; ?></td>
				</tr>
				<tr>
					<td>Program:</td>
					<td style="font-weight:bold"><?php echo $program_detail['name']; ?></td>
				</tr>
				<tr>
					<td>Program Type:</td>
					<td style="font-weight:bold"><?php echo $program_type_detail['name']; ?></td>
				</tr>
				<tr>
					<td>Department:</td>
					<td style="font-weight:bold"><?php echo (!empty($department_detail['name']) && $department_detail['name'] != "" ? $department_detail['name'] : 'Freshman Program'); ?></td>
				</tr>
				<tr>
					<td>Section:</td>
					<td style="font-weight:bold"><?php echo $section_detail['name']; ?></td>
				</tr>
				<tr>
					<td>Acdamic Year:</td>
					<td style="font-weight:bold"><?php echo $academic_year; ?></td>
				</tr>
				<tr>
					<td>Semester:</td>
					<td style="font-weight:bold"><?php echo $semester; ?></td>
				</tr>
			</table>
		</td>
		<td style="width:60%">
		<?php
		if(count($master_sheet['registered_courses']) > 0) {
			?>
			<div style="font-weight:bold; background-color:#cccccc; padding:0px; font-size:14px">Registered Courses</div>
			<table class="courses_table">
				<tr>
					<th style="width:5%">No</th>
					<th style="width:55%">Course Title</th>
					<th style="width:20%">Course Code</th>
					<th style="width:20%">Cr. Hr.</th>
				</tr>
			<?php
			$registered_and_add_course_count = 0;
			$registered_course_credit_sum = 0;
			foreach($master_sheet['registered_courses'] as $key => $registered_course) {
				$registered_and_add_course_count++;
				$registered_course_credit_sum += $registered_course['credit'];
				?>
				<tr>
					<td><?php echo $registered_and_add_course_count; ?></td>
					<td><?php echo $registered_course['course_title']; ?></td>
					<td><?php echo $registered_course['course_code']; ?></td>
					<td><?php echo $registered_course['credit']; ?></td>
				</tr>
				<?php
			}
			?>
				<tr style="font-weight:bold">
					<td colspan="3" style="text-align:right">Total</td>
					<td><?php echo $registered_course_credit_sum; ?></td>
				</tr>
			</table>
			<?php
			}
			if(count($master_sheet['added_courses']) > 0) {
				?>
			<div style="font-weight:bold; background-color:#cccccc; padding:0px; font-size:14px">Add Courses</div>
			<table class="courses_table">
				<tr>
					<th style="width:5%">No</th>
					<th style="width:55%">Course Title</th>
					<th style="width:20%">Course Code</th>
					<th style="width:20%">Cr. Hr.</th>
				</tr>
			<?php
			$added_course_credit_sum = 0;
			foreach($master_sheet['added_courses'] as $key => $added_course) {
				$registered_and_add_course_count++;
				$added_course_credit_sum += $added_course['credit'];
				?>
				<tr>
					<td><?php echo $registered_and_add_course_count; ?></td>
					<td><?php echo $added_course['course_title']; ?></td>
					<td><?php echo $added_course['course_code']; ?></td>
					<td><?php echo $added_course['credit']; ?></td>
				</tr>
				<?php
			}
			?>
				<tr style="font-weight:bold">
					<td colspan="3" style="text-align:right">Total</td>
					<td><?php echo $added_course_credit_sum; ?></td>
				</tr>
			</table>
			<?php
		}
		?>
		</td>
	</tr>
</table>
<?php
$table_width = (count($master_sheet['registered_courses'])*10) + (count($master_sheet['added_courses'])*10) + 86;
?>
<table style="width:<?php echo ($table_width > 100 ? $table_width : 100); ?>%">
	<tr>
		<th rowspan="2" style="vertical-align:bottom; width:2%">No</th>
		<th rowspan="2" style="vertical-align:bottom; width:18%">Full Name</th>
		<th rowspan="2" style="vertical-align:bottom; width:8%">ID No</th>
		<th rowspan="2" style="vertical-align:bottom; width:3%">Sex</th>
		<?php
		$percent = 10;
		$last_percent = false;
		$total_percent = (count($master_sheet['registered_courses'])*10) + 
		(count($master_sheet['added_courses'])*10) + 86;
		if($total_percent > 100) {
			//$percent = (100 - 86) / (count($master_sheet['registered_courses']) + count($master_sheet['added_courses']));
		}
		else if($total_percent < 100) {
			$last_percent = 100 - $total_percent;
		}
		$registered_and_add_course_count = 0;
		foreach($master_sheet['registered_courses'] as $key => $registered_course) {
			$registered_and_add_course_count++;
			?>
			<th colspan="2" style="width:<?php echo $percent; ?>%; text-align:center" class="bordering2">
			<?php echo $registered_and_add_course_count; ?></th>
			<?php
		}
		foreach($master_sheet['added_courses'] as $key => $added_course) {
			$registered_and_add_course_count++;
			?>
			<th colspan="2" style="width:<?php echo $percent; ?>%; text-align:center;"><?php echo $registered_and_add_course_count; ?></th>
			<?php
		}
		?>
		<th colspan="3" style="text-align:center; width:15%" class="bordering2">Semester</th>
		<th colspan="3" style="text-align:center; width:15%" class="bordering2">Previous</th>
		<th colspan="3" style="text-align:center; width:15%" class="bordering2">Cumulative</th>
		<th rowspan="2" style="text-align:center; vertical-align:bottom; width:10%" class="bordering2">Status</th>
		<?php
		if($last_percent) {
			?>
			<th style="width:<?php echo $last_percent; ?>%;">&nbsp;</th>
			<?php
		}
		?>
	</tr>
	<tr>
		<?php
		foreach($master_sheet['registered_courses'] as $key => $registered_course) {
			?>
			<th style="width:<?php echo $percent/2; ?>%; border-left:1px #000000 solid; border-right:1px #000000 solid">G</th>
			<th style="width:<?php echo $percent/2; ?>%; border-left:1px #000000 solid; border-right:1px #000000 solid">GP</th>
			<?php
		}
		foreach($master_sheet['added_courses'] as $key => $added_course) {
			?>
			<th style="width:<?php echo $percent/2; ?>%; border-left:1px #000000 solid; border-right:1px #000000 solid">G</th>
			<th style="width:<?php echo $percent/2; ?>%; border-left:1px #000000 solid; border-right:1px #000000 solid">GP</th>
			<?php
		}
		?>
		<th style="width:5%" class="bordering2">CH</th>
		<th style="width:5%" class="bordering2">GP</th>
		<th style="width:5%" class="bordering2">SGPA</th>
		
		<th style="width:5%" class="bordering2">CH</th>
		<th style="width:5%" class="bordering2">GP</th>
		<th style="width:5%" class="bordering2">CGPA</th>
		
		<th style="width:5%" class="bordering2">CH</th>
		<th style="width:5%" class="bordering2">GP</th>
		<th style="width:5%" class="bordering2">CGPA</th>
		<?php
		if($last_percent) {
			?>
			<th>&nbsp;</th>
			<?php
		}
		?>
	</tr>
<?php
$student_count = 0;
foreach($master_sheet['students_and_grades'] as $key => $student) {
	$credit_hour_sum = 0;
	$gp_sum = 0;
	$student_count++;
	?>
	<tr>
		<td><?php echo $student_count; ?></td>
		<td><?php echo $student['full_name']; ?></td>
		<td><?php echo $student['studentnumber']; ?></td>
		<td><?php echo (strcasecmp($student['gender'], 'male') == 0 ? 'M' : 'F'); ?></td>
		<?php
		foreach($master_sheet['registered_courses'] as $key => $registered_course) {
			 if($student['courses']['r-'.$registered_course['id']]['registered'] == 1) {
			 	if(isset($student['courses']['r-'.$registered_course['id']]['grade'])) {
			 		echo '<td class="bordering">'.$student['courses']['r-'.$registered_course['id']]['grade'].'</td>';
			 		echo '<td class="bordering">';
			 		if(isset($student['courses']['r-'.$registered_course['id']]['point_value'])) {
			 			echo number_format(($student['courses']['r-'.$registered_course['id']]['credit'] * $student['courses']['r-'.$registered_course['id']]['point_value']), 2, '.', '');
			 			$gp_sum += ($student['courses']['r-'.$registered_course['id']]['credit'] * $student['courses']['r-'.$registered_course['id']]['point_value']);
			 		}
			 		echo '</td>';
			 	}
			 	else {
			 		echo '<td class="bordering">'.($student['courses']['r-'.$registered_course['id']]['droped'] == 1 ? 'DP' : '**').'</td>';
			 		echo '<td class="bordering">&nbsp;</td>';
			 	}
			 if($student['courses']['r-'.$registered_course['id']]['droped'] == 0)
			 	$credit_hour_sum += $student['courses']['r-'.$registered_course['id']]['credit'];
			 }
			 else {
			 	echo '<td class="bordering">---</td>';
			 	echo '<td class="bordering">&nbsp;</td>';
			 	//the student didn't register and there is nothing to display
			 }
		}
		foreach($master_sheet['added_courses'] as $key => $added_course) {
			 if($student['courses']['a-'.$added_course['id']]['added'] == 1) {
			 	if(isset($student['courses']['a-'.$added_course['id']]['grade'])) {
			 		echo '<td class="bordering">'.$student['courses']['a-'.$added_course['id']]['grade'].'</td>';
			 		echo '<td class="bordering">';
			 		if(isset($student['courses']['a-'.$added_course['id']]['point_value'])) {
			 			echo number_format(($student['courses']['a-'.$added_course['id']]['credit'] * $student['courses']['a-'.$added_course['id']]['point_value']), 2, '.', '');
			 			$gp_sum += ($student['courses']['a-'.$added_course['id']]['credit'] * $student['courses']['a-'.$added_course['id']]['point_value']);
			 		}
			 		echo '</td>';
			 	}
			 	else {
			 		echo '<td class="bordering">**</td>';
			 		echo '<td class="bordering">&nbsp;</td>';
			 	}
			 $credit_hour_sum += $student['courses']['a-'.$added_course['id']]['credit'];
			 }
			 else {
			 	echo '<td class="bordering">---</td>';
			 	echo '<td class="bordering">&nbsp;</td>';
			 	//the student didn't register and there is nothing to display
			 }
		}
		?>
		<td class="bordering"><?php echo (!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['credit_hour_sum'] : '---'); ?></td>
		<td class="bordering"><?php echo (!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['grade_point_sum'] : '---'); ?></td>
		<td class="bordering"><?php echo (!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['sgpa'] : '---'); ?></td>

		<td class="bordering"><?php echo (!empty($student['PreviousStudentExamStatus']) ? $student['PreviousStudentExamStatus']['previous_credit_hour_sum'] : '---'); ?></td>
		<td class="bordering"><?php echo (!empty($student['PreviousStudentExamStatus']) ? $student['PreviousStudentExamStatus']['previous_grade_point_sum'] : '---'); ?></td>
		<td class="bordering"><?php echo (!empty($student['PreviousStudentExamStatus']) ? $student['PreviousStudentExamStatus']['cgpa'] : '---'); ?></td>

		<td class="bordering"><?php
			if(!empty($student['StudentExamStatus']) && !empty($student['PreviousStudentExamStatus'])) {
				echo (($student['StudentExamStatus']['credit_hour_sum']+$student['PreviousStudentExamStatus']['previous_credit_hour_sum']) - $student['deduct_credit']);
			}
			else if(!empty($student['StudentExamStatus'])) {
				echo $student['StudentExamStatus']['credit_hour_sum'];
			}
			else if(!empty($student['PreviousStudentExamStatus'])) {
				echo $student['PreviousStudentExamStatus']['previous_credit_hour_sum'];
			}
			else
				echo '---';
		?>
		</td>
		<td class="bordering"><?php
			if(!empty($student['StudentExamStatus']) && !empty($student['PreviousStudentExamStatus'])) {
				echo (($student['StudentExamStatus']['grade_point_sum']+$student['PreviousStudentExamStatus']['previous_grade_point_sum']) - $student['deduct_gp']);
			}
			else if(!empty($student['StudentExamStatus'])) {
				echo $student['StudentExamStatus']['grade_point_sum'];
			}
			else if(!empty($student['PreviousStudentExamStatus'])) {
				echo $student['PreviousStudentExamStatus']['previous_grade_point_sum'];
			}
			else
				echo '---';
		?>
		</td>
		<td class="bordering"><?php echo (!empty($student['StudentExamStatus']) ? $student['StudentExamStatus']['cgpa'] : '---'); ?></td>

		<td><?php echo (!empty($student['AcademicStatus']) && 
		!empty($student['AcademicStatus']['id'])? $student['AcademicStatus']['name'] : '---'); ?></td>
		<?php
		if($last_percent) {
			?>
			<td>&nbsp;</td>
			<?php
		}
		?>
	</tr>
	<?php
}
?>
</table>
<?php
}
?>
</div>
