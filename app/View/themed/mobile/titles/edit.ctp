<div class="titles form">
<?php echo $this->Form->create('Title');?>
	<fieldset>
		<legend class="smallheading"><?php __('Edit Title'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

