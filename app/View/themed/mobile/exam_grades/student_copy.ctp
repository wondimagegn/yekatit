<div class="examGrades student_copy">
<?php echo $this->Form->create('ExamGrade');?>
<div class="smallheading"><?php __('Student Copy Printing');?></div>
<table class="fs13">
	<tr>
		<td style="width:10%">Student ID:</td>
		<td style="width:15%"><?php echo $this->Form->input('studentnumber', array('label'=> false, 'style' => 'width:150px')); ?></td>
		<td style="width:75%"><?php echo $this->Form->submit(__('Get Student Copy', true), array('name' => 'continueStudentCopyPrint', 'div' => false)); ?></td>
	</tr>
</table>
<?php
if(!empty($student_copy)) {
	?>
	<style>
		table.stu_summery tr td{
			padding:2px;
		}
	</style>
	<table class="fs13 stu_summery">
		<tr>
			<td style="width:12%; font-weight:bold">Full Name:</td>
			<td style="width:88%"><?php echo $student_copy['student_detail']['Student']['first_name'].' '.$student_copy['student_detail']['Student']['middle_name'].' '.$student_copy['student_detail']['Student']['last_name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Student ID:</td>
			<td><?php echo $student_copy['student_detail']['Student']['studentnumber']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Sex:</td>
			<td><?php echo ucwords(strtolower($student_copy['student_detail']['Student']['gender'])); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program:</td>
			<td><?php echo $student_copy['student_detail']['Program']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program Type:</td>
			<td><?php echo $student_copy['student_detail']['ProgramType']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">College:</td>
			<td><?php echo $student_copy['student_detail']['College']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Department:</td>
			<td><?php echo (!empty($student_copy['student_detail']['Department']['name']) ? $student_copy['student_detail']['Department']['name'] : 'Freshman Program'); ?></td>
		</tr>
	</table>
	<?php
	echo $this->element('cost_sharing_due_and_payment');
	echo $this->element('student_clearance_list');
	if(isset($student_copy['courses_taken']) && !empty($student_copy['courses_taken'])) {
		?>
		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Student copy display setting</p>
		<table class="fs13">
			<tr>
				<td style="width:17%">Semesters on One Side:</td>
				<td style="width:83%"><?php echo $this->Form->input('no_of_semester', array('label'=> false, 'type' => 'select', 'style' => 'width:150px', 'div' => false, 'default' => 3, 'options' => array(2 => 2, 3 => 3, 4 => 4, 5 => 5))); ?> <span style="font-size:11px">(Number of semesters to display on one side of the student copy)</span></td>
			</tr>
			<tr>
				<td>Text Padding:</td>
				<td><?php echo $this->Form->input('course_justification', array('label'=> false, 'type' => 'select', 'style' => 'width:150px', 'div' => false, 'default' => 1, 'options' => array(0 => 0, 1 => 1, 2 => 2))); ?> <span style="font-size:11px">(The space around each text)</span></td>
			</tr>
			<tr>
				<td>Font Size:</td>
				<td><?php echo $this->Form->input('font_size', array('label'=> false, 'type' => 'select', 'style' => 'width:150px', 'div' => false, 'default' => 30, 'options' => $font_size_options)); ?> <span style="font-size:11px"></span></td>
			</tr>
		</table>
		<?php
		echo $this->Form->input('id', array('value' => $student_copy['student_detail']['Student']['id']));
		echo $this->Form->submit(__('Display Student Copy', true), array('name' => 'displayStudentCopyPrint', 'div' => false));
	}
	//debug($student_copy);
}
?>
<?php echo $this->Form->end(); ?>
</div>
