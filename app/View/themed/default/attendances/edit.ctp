<div class="attendances form">
<?php echo $this->Form->create('Attendance');?>
	<fieldset>
		<legend><?php __('Edit Attendance'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('attendace_type');
		echo $this->Form->input('attendance_date');
		echo $this->Form->input('attendance');
		echo $this->Form->input('remark');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Attendance.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Attendance.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Attendances', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>