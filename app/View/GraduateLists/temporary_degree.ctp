<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="graduateLists temporary_degree">
<?php echo $this->Form->create('GraduateList');?>
<div class="smallheading"><?php echo __('Temporary Student Degree Printing');?></div>
<table class="fs13">
	<tr>
		<td style="width:10%">Student ID:</td>
		<td style="width:15%"><?php echo $this->Form->input('studentnumber', array('label'=> false, 'style' => 'width:150px')); ?></td>
		<td style="width:75%"><?php echo $this->Form->submit(__('Get Student Temporary Degree'), array('name' => 'continueTemporaryDegreePrint','class'=>'tiny radius button bg-blue', 'div' => false)); ?></td>
	</tr>
</table>
<?php
if(!empty($temporary_degree)) {
	?>
	<style>
		table.stu_summery tr td{
			padding:2px;
		}
	</style>
	<table class="fs13 stu_summery">
		<tr>
			<td style="width:12%; font-weight:bold">Full Name:</td>
			<td style="width:88%"><?php echo $temporary_degree['student_detail']['Student']['first_name'].' '.$temporary_degree['student_detail']['Student']['middle_name'].' '.$temporary_degree['student_detail']['Student']['last_name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Student ID:</td>
			<td><?php echo $temporary_degree['student_detail']['Student']['studentnumber']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Sex:</td>
			<td><?php echo ucwords(strtolower($temporary_degree['student_detail']['Student']['gender'])); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program:</td>
			<td><?php echo $temporary_degree['student_detail']['Program']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Program Type:</td>
			<td><?php echo $temporary_degree['student_detail']['ProgramType']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">College:</td>
			<td><?php echo $temporary_degree['student_detail']['College']['name']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Department:</td>
			<td><?php echo (!empty($temporary_degree['student_detail']['Department']['name']) ? $temporary_degree['student_detail']['Department']['name'] : 'Freshman Program'); ?></td>
		</tr>
	</table>
	<?php
	echo $this->element('cost_sharing_due_and_payment');
	echo $this->element('student_clearance_list');
	echo $this->Form->input('id', array('value' => $temporary_degree['student_detail']['Student']['id']));
	echo $this->Form->submit(__('Display Student Temporary Degree'), array('name' => 'displayTemporaryDegreePrint', 'div' => false,'class'=>'tiny radius button bg-blue'));
}
echo $this->Form->end(); ?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
