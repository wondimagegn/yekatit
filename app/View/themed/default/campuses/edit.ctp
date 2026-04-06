<div class="campuses form">
<?php echo $this->Form->create('Campus');?>

	<div class="smallheading"><?php __('Edit Campus'); ?></div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name').'<br/>';
		echo $this->Form->input('description');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
