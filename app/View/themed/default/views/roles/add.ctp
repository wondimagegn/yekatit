<div class="roles form">
<?php echo $this->Form->create('Role');?>

		<div class="smallheading"><?php __('Add Role'); ?></div>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		//echo $this->Form->input('created');
		//echo $this->Form->input('modified');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

