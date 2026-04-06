<div class="unschedulePublishedCourses form">
<?php echo $this->Form->create('UnschedulePublishedCourse');?>
	<fieldset>
		<legend><?php __('Add Unschedule Published Course'); ?></legend>
	<?php
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('course_split_section_id');
		echo $this->Form->input('period_length');
		echo $this->Form->input('type');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Unschedule Published Courses', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('controller' => 'course_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add')); ?> </li>
	</ul>
</div>