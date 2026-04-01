<div class="yearLevels form">
<?php echo $this->Form->create('YearLevel');?>
	<fieldset>
 		<legend><?php __('Edit Year Level'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('department_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
