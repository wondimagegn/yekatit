<div class="excludedPublishedCourseExams form">
<?php echo $this->Form->create('ExcludedPublishedCourseExam');?>
	<fieldset>
 		<legend><?php __('Add Excluded Published Course Exam'); ?></legend>
	<?php
		echo $this->Form->input('published_course_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Excluded Published Course Exams', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>