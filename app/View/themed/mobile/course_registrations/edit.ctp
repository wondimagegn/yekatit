<div class="courseRegistrations form">
<?php echo $this->Form->create('CourseRegistration');?>
	<fieldset>
		<legend><?php __('Edit Course Registration'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('year_level_id');
		echo $this->Form->input('registration_date');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('student_id');
		echo $this->Form->input('course_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CourseRegistration.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CourseRegistration.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Registrations', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Year Levels', true), array('controller' => 'year_levels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Year Level', true), array('controller' => 'year_levels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>