<div class="regions form">
<?php echo $this->Form->create('Region');?>
		<div class="smallheading"><?php __('Add Region'); ?></div>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('short');
		echo $this->Form->input('description');
		echo $this->Form->input('country_id');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
