<div class="graduateLists graduation_certificate">
<?php echo $this->Form->create('GraduateList');?>
<div class="smallheading"><?php __('Graduation Certificate Printing');?></div>
<table class="fs13">
	<tr>
		<td style="width:10%">Student ID:</td>
		<td style="width:15%"><?php echo $this->Form->input('studentnumber', array('label'=> false, 'style' => 'width:150px')); ?></td>
		<td style="width:75%"><?php echo $this->Form->submit(__('Get Student Graduation Certificate', true), array('name' => 'continueGraduationCertificatePrint', 'div' => false)); ?></td>
	</tr>
</table>
<?php
if(!empty($graduation_certificate)) {
	?>
	<style>
		table.stu_summery tr td{
			padding:2px;
		}
	</style>
	<table class="fs13 stu_summery">
		<tr>
			<td style="width:12%; font-weight:bold">Full Name:</td>
			<td style="width:88%"><?php echo $graduation_certificate['student_detail']['Student']['first_name'].' '.$graduation_certificate['student_detail']['Student']['middle_name'].' '.$graduation_certificate['student_detail']['Student']['last_name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Student ID:</td>
			<td><?php echo $graduation_certificate['student_detail']['Student']['studentnumber']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Sex:</td>
			<td><?php echo ucwords(strtolower($graduation_certificate['student_detail']['Student']['gender'])); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program:</td>
			<td><?php echo $graduation_certificate['student_detail']['Program']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program Type:</td>
			<td><?php echo $graduation_certificate['student_detail']['ProgramType']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">College:</td>
			<td><?php echo $graduation_certificate['student_detail']['College']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Department:</td>
			<td><?php echo (!empty($graduation_certificate['student_detail']['Department']['name']) ? $graduation_certificate['student_detail']['Department']['name'] : 'Freshman Program'); ?></td>
		</tr>
	</table>
	<?php
	if(!empty($graduation_certificate_template)) {
		echo $this->Form->input('id', array('value' => $graduation_certificate['student_detail']['Student']['id']));
		echo $this->Form->submit(__('Display Student Graduation Certificate', true), array('name' => 'displayGraduationCertificatePrint', 'div' => false));
	}
}
echo $this->Form->end(); ?>
</div>
