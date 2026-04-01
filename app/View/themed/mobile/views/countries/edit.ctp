<div class="countries form">
<?php echo $this->Form->create('Country');?>
	
		<div class="smallheading"><?php __('Edit Country'); ?></div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('code');
	?>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
