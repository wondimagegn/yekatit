<div class="classPeriodCourseConstraints form">
<?php echo $this->Form->create('ClassPeriodCourseConstraint');?>
	<fieldset>
 		<legend><?php __('Edit Class Period Course Constraint'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('week_day');
		echo $this->Form->input('period');
		echo $this->Form->input('type');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ClassPeriodCourseConstraint.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ClassPeriodCourseConstraint.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Class Period Course Constraints', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>