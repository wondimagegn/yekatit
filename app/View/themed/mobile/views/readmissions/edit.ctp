<div class="readmissions form">
<?php echo $this->Form->create('Readmission');?>
	<fieldset>
		<legend><?php __('Edit Readmission'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('minute_number');
		echo $this->Form->input('registrar_approval');
		echo $this->Form->input('registrar_approval_date');
		echo $this->Form->input('registrar_approved_by');
		echo $this->Form->input('academic_commision_approval');
		echo $this->Form->input('academic_commision_approval_date');
		echo $this->Form->input('remark');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

