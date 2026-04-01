<script>
$(document).ready(function () {
	$("#PublishedCourse").change(function(){
		//serialize form data
		window.location.replace("/exam_grades/manage_ng/"+$("#PublishedCourse").val());
	});
});
</script>
<div class="examGrades manage_ng">
<?php echo $this->Form->create('ExamGrade');?>
<div class="smallheading"><?php __('NG Grade Management');?></div>
<?php echo $this->element('publish_course_filter_by_dept'); ?>
<?php //debug($students_with_ng); 
if(!empty($students_with_ng)) {
?>
<table>
	<tr>
		<td style="width:13%" class="fs14">Minute Number:</td>
		<td style="width:87%"><?php echo $this->Form->input('ExamGrade.minute_number', array('label' => false)); ?></td>
	</tr>
</table>
<table>
<tr>
	<th style="width:25%">Full Name</th>
	<th style="width:15%">Student ID</th>
	<th style="width:10%">Current Grade</th>
	<th style="width:50%">New Grade</th>
</tr>
<?php
$count = 0;
foreach($students_with_ng as $key => $student) {
	$count++;
	?>
	<tr>
		<td><?php echo $student['full_name']; ?></td>
		<td><?php echo $student['studentnumber']; ?></td>
		<td>NG</td>
		<td><?php
		echo $this->Form->input('ExamGrade.'.$count.'.id', array('value' => $student['grade_id'], 'label' => false, 'type' => 'hidden'));
		echo $this->Form->input('ExamGrade.'.$count.'.grade', array('label' => false, 'type' => 'select', 'options' => $applicable_grades));
		?></td>
	</tr>
	<?php
}
?>
</table>
<?php
echo $this->Form->submit(__('Change NG Grade', true), array('name' => 'changeNgGrade', 'div' => false)); 
}
?>
<?php echo $this->Form->end(); ?>
</div>
