<?php ?>
<script>

$(document).ready(function () {
	$("#PublishedCourse").change(function(){
		
		//serialize form data
		window.location.replace("/exam_grades/manage_ng/"+$("#PublishedCourse").val());
	});
});

</script>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="examGrades manage_ng">
<?php echo $this->Form->create('ExamGrade',array('novalidate' => true));?>
<div class="smallheading"><?php echo __('NG Grade Management');?></div>
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
	<th style="width:35%">Full Name</th>
	<th style="width:15%">Student ID</th>
	<th style="width:10%">Current Grade</th>
	<th style="width:30%">New Grade</th>
	<th style="width:10%">Is Cheating</th>
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
		
		<td><?php
		
		echo $this->Form->input('ExamGrade.'.$count.'.cheating', array('label' => false, 'type' => 'checkbox'));
		?></td>
		
	</tr>
	<?php
}
?>
</table>
<?php
echo $this->Form->submit(__('Change NG Grade'), array('name' => 'changeNgGrade', 'div' => false,'class'=>'tiny radius button bg-blue')); 
}
?>
<?php echo $this->Form->end(); ?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
