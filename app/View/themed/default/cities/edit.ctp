<div class="cities form">
<?php echo $this->Form->create('City');?>
	
	<div class="smallheading"><?php __('Edit City'); ?></div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('region_id');
		echo $this->Form->input('name');
		
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
