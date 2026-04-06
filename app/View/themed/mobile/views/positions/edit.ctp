<div class="positions form">
<?php echo $this->Form->create('Position');?>
	
		<div class="smallheading"><?php __('Edit Position'); ?></div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('position');
		echo $this->Form->input('description');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

