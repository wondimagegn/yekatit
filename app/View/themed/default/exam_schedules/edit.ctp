<div class="examSchedules form">
<?php echo $this->Form->create('ExamSchedule');?>
	<fieldset>
		<legend><?php __('Edit Exam Schedule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('class_room_id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('acadamic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('exam_date');
		echo $this->Form->input('session');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExamSchedule.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExamSchedule.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exam Schedules', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>