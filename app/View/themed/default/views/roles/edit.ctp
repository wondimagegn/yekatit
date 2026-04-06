<div class="roles form">
<?php echo $this->Form->create('Role');?>
	
		<div class="smallheading"><?php __('Edit Role'); ?></div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		//echo $this->Form->input('modified');
		//echo $this->Form->input('modified');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

