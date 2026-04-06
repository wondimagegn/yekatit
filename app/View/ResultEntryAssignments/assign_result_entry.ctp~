<?php ?>
<script>
$(document).ready(function () {
	$("#PublishedCourse").change(function(){
		//serialize form data
		window.location.replace("/resultEntryAssignments/assign_result_entry/"+$("#PublishedCourse").val());
	});
});
</script>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php echo $this->Form->create('ResultEntryAssignment',array('novalidate' => true));?>

<div class="smallheading"><?php echo __('Assign Grade Entry for Instructor ');?></div>
<?php echo $this->element('publish_course_filter_by_dept'); ?>
<?php 
if(!empty($students_no_entry)) {
?>
<div class="info-box info-message"><span></span>After you create an assingment for the instructor, the system will make available the student for exam result entry and grade submition to the instructor curentlly assigned to the selected course the student is taking.</div>
<table class="fs14">
	<tr>
		<td style="width:30%">Minute Number</td>
		<td style="width:70%"><?php echo $this->Form->input('ResultEntryAssignment.minute_number', array('label' => false, 'class' => 'fs14','value'=>'Inst. Grade Entry','readonly'=>'true','required')); ?></td>
	</tr>
</table>

<table class="fs14" id="StudentListEntry">
<tr>
	<th><?php echo $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all','div' => false, 'label' => false, 'onchange' => 'check_uncheck(this.id)')); ?>Select All</th>
	<th>Full Name</th>
	<th>Student ID</th>
	<th>Section</th>
	<th></th>
</tr>
<?php
$st_count = 0;
$isAllMakeUpApplied=count($students_no_entry);
foreach($students_no_entry as $key => $student) {
   
	$st_count++;
	?>
	<tr>
		<td style="width:10%">
			<?php
			
				echo $this->Form->input('ResultEntryAssignment.'.$st_count.'.gp', array('type' => 'checkbox', 'label' => false,'class'=>'checkbox1','checked'=>false, 'id' => 'StudentSelection'.$st_count));
			
			echo $this->Form->input('ResultEntryAssignment.'.$st_count.'.student_id', array('type' => 'hidden', 'value' => $student['Student']['id']));
			
		  
					?>
		</td>
		<td style="width:15%"><?php echo $student['Student']['full_name']; ?></td>
		<td style="width:10%"><?php echo $student['Student']['studentnumber']; ?></td>
		
		<td style="width:10%"><?php
		echo $selectedPublishedCourseDetail['Section']['name'].'('.$selectedPublishedCourseDetail['YearLevel']['name'].')';
		?></td>
		<td style="width:10%">
			<?php 
			if(empty($student['result']) && $student['makeupalreadyapplied'] )
						echo $this->Html->link(__('Delete'), array('action' => 'deleteExamResultEntryAssignment', $student['makeupalreadyapplied']), null, sprintf(__('Are you sure you want to delete %s \'s grade entry assignment ?'), $student['full_name']));
			
			?>
		</td>
	</tr>
	<?php
}

?>
</table>
<?php 
echo "How many ".$isAllMakeUpApplied;
?>
<table >
<?php if(isset($sectionsHaveSameCourses) && !empty($sectionsHaveSameCourses)) { ?>
    <tr>
		<td style="width:25%">In which section students are going to take exam?</td>
		<td style="width:25%"><?php echo $this->Form->input('ResultEntryAssignment.exam_published_course_id', array('id' => 'ExamPublishedCourse', 'label' => false, 'type' => 'select', 'class' => 'fs14', 'options' => $sectionsHaveSameCourses)); ?></td>
	</tr>
	<tr>
		<td colspan="2">
		<?php echo $this->Html->link('Assign Students as add courses','#',array('data-animation'=>"fade",
'data-reveal-id'=>'myModal','data-reveal-ajax'=>'/resultEntryAssignments/get_student_to_add_course/'.$published_course_combo_id));
?></td>
	<tr>
	<?php } ?>
</table>
<?php
if($isAllMakeUpApplied!=0){


echo $this->Form->submit(__('Assign Grade Entry'), array('name' => 'assignGradeEntry', 'div' => false,'class'=>'tiny radius button bg-blue')); 
}
}
?>
<?php echo $this->Form->end(); ?>

	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
