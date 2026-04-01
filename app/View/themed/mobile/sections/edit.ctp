<div class="sections form">
<?php echo $this->Form->create('Section');?>
	<fieldset>
 		<legend><?php __('Edit Section'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		//echo $this->Form->input('college_id');
        if(ROLE_COLLEGE != $role_id ){
            //echo $this->Form->input('department_id');
           // echo $this->Form->input('year_level_id',array('readonly'=>true));
        }
		//echo $this->Form->input('academicyear');
		//echo $this->Form->input('Student');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
