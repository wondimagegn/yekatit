<div class="graduationWorks form">
<?php echo $this->Form->create('GraduationWork');?>
	<fieldset>
		<legend><?php __('Edit Graduation Work'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('type');
		echo $this->Form->input('title');
		echo $this->Form->input('course_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

