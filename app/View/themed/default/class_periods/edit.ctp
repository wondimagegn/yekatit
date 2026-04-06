<div class="classPeriods form">
<?php echo $this->Form->create('ClassPeriod');?>
	<fieldset>
 		<legend><?php __('Edit Class Period'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('week_day');
		echo $this->Form->input('period_setting_id');
		echo $this->Form->input('college_id');
		echo $this->Form->input('program_type_id');
		echo $this->Form->input('program_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>