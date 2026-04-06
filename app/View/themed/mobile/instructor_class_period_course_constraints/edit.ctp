<div class="instructorClassPeriodCourseConstraints form">
<?php echo $this->Form->create('InstructorClassPeriodCourseConstraint');?>
	<fieldset>
		<legend><?php __('Edit Instructor Class Period Course Constraint'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('staff_id');
		echo $this->Form->input('class_period_id');
		echo $this->Form->input('college_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('InstructorClassPeriodCourseConstraint.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('InstructorClassPeriodCourseConstraint.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Instructor Class Period Course Constraints', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Staffs', true), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff', true), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Periods', true), array('controller' => 'class_periods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Period', true), array('controller' => 'class_periods', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colleges', true), array('controller' => 'colleges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New College', true), array('controller' => 'colleges', 'action' => 'add')); ?> </li>
	</ul>
</div>