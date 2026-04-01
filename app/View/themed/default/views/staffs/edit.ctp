<div class="staffs form">
<?php echo $this->Form->create('Staff');?>
	
		<div class="smallheading"><?php __('Edit Staff'); ?></div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('position');
		echo $this->Form->input('college_id');
		echo $this->Form->input('department_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('middle_name');
		echo $this->Form->input('last_name');
		
	?>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
