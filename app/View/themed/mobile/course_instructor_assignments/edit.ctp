<div class="courseInstructorAssignments form">
<?php echo $this->Form->create('CourseInstructorAssignment');?>
	<fieldset>
		<legend><?php __('Edit Course Instructor Assignment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('section_id');
		echo $this->Form->input('staff_id');
		echo $this->Form->input('course_id');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CourseInstructorAssignment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CourseInstructorAssignment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Instructor Assignments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staffs', true), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff', true), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>