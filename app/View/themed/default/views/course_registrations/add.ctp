<div class="courseRegistrations form">
<?php echo $this->Form->create('CourseRegistration');?>
	<fieldset>
		<legend><?php __('Add Course Registration'); ?></legend>
	<?php
		echo $this->Form->input('year_level_id');
		echo $this->Form->input('academic_calendar_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('student_id');
		echo $this->Form->input('course_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
