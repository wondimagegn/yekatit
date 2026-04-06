<div class="gradeScaleDetails form">
<?php echo $this->Form->create('GradeScaleDetail');?>
	<fieldset>
		<legend><?php __('Add Grade Scale Detail'); ?></legend>
	<?php
		echo $this->Form->input('minimum_result');
		echo $this->Form->input('maximum_result');
		echo $this->Form->input('grade_scale_id');
		echo $this->Form->input('grade_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

