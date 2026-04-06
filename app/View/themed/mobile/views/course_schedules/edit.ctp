<div class="courseSchedules form">
<?php echo $this->Form->create('CourseSchedule');?>
	<fieldset>
		<legend><?php __('Edit Course Schedule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('class_room_id');
		echo $this->Form->input('section_id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('course_split_section_id');
		echo $this->Form->input('acadamic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('type');
		echo $this->Form->input('ClassPeriod');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CourseSchedule.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CourseSchedule.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Schedules', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('controller' => 'course_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Periods', true), array('controller' => 'class_periods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Period', true), array('controller' => 'class_periods', 'action' => 'add')); ?> </li>
	</ul>
</div>