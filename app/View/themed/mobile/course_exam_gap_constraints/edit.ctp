<div class="courseExamGapConstraints form">
<?php echo $this->Form->create('CourseExamGapConstraint');?>
	<fieldset>
		<legend><?php __('Edit Course Exam Gap Constraint'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('gap_before_exam');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CourseExamGapConstraint.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CourseExamGapConstraint.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Exam Gap Constraints', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>