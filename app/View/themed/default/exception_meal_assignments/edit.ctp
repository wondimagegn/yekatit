<div class="exceptionMealAssignments form">
<?php echo $this->Form->create('ExceptionMealAssignment');?>
	<fieldset>
		<legend><?php __('Edit Exception Meal Assignment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('meal_hall_id');
		echo $this->Form->input('accept_deny');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExceptionMealAssignment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExceptionMealAssignment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exception Meal Assignments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Halls', true), array('controller' => 'meal_halls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Hall', true), array('controller' => 'meal_halls', 'action' => 'add')); ?> </li>
	</ul>
</div>