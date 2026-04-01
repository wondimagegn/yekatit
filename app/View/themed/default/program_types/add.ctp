<div class="programTypes form">
<?php echo $this->Form->create('ProgramType');?>
	<fieldset>
		<legend><?php __('Add Program Type'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
