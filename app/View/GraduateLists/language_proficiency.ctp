<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="graduateLists language_proficiency">
<?php echo $this->Form->create('GraduateList');?>
<div class="smallheading"><?php echo __('Language Proficiency Printing');?></div>
<table class="fs13">
	<tr>
		<td style="width:10%">Student ID:</td>
		<td style="width:15%"><?php echo $this->Form->input('studentnumber', array('label'=> false, 'style' => 'width:150px')); ?></td>
		<td style="width:75%"><?php echo $this->Form->submit(__('Get Student Language Proficiency Letter'), array('name' => 'continueLanguageProficiencyLetterPrint','class'=>'tiny radius button bg-blue', 'div' => false)); ?></td>
	</tr>
</table>
<?php
if(!empty($graduation_letter)) {
	?>
	<style>
		table.stu_summery tr td{
			padding:2px;
		}
	</style>
	<table class="fs13 stu_summery">
		<tr>
			<td style="width:12%; font-weight:bold">Full Name:</td>
			<td style="width:88%"><?php echo $graduation_letter['student_detail']['Student']['first_name'].' '.$graduation_letter['student_detail']['Student']['middle_name'].' '.$graduation_letter['student_detail']['Student']['last_name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Student ID:</td>
			<td><?php echo $graduation_letter['student_detail']['Student']['studentnumber']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Sex:</td>
			<td><?php echo ucwords(strtolower($graduation_letter['student_detail']['Student']['gender'])); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program:</td>
			<td><?php echo $graduation_letter['student_detail']['Program']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program Type:</td>
			<td><?php echo $graduation_letter['student_detail']['ProgramType']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">College:</td>
			<td><?php echo $graduation_letter['student_detail']['College']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Department:</td>
			<td><?php echo (!empty($graduation_letter['student_detail']['Department']['name']) ? $graduation_letter['student_detail']['Department']['name'] : 'Freshman Program'); ?></td>
		</tr>
	</table>
	<?php
	if(!empty($graduation_letter_template)) {
		echo $this->Form->input('id', array('value' => $graduation_letter['student_detail']['Student']['id']));
		echo $this->Form->submit(__('Display Student Language Proficiency Letter'), array('name' => 'displayLanguageProficiencyLetterPrint','class'=>'tiny radius button bg-blue','class'=>'tiny radius button bg-blue', 'div' => false));
	}
}
echo $this->Form->end(); ?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
