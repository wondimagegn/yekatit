<div class="mealHallAssignments form">
<?php echo $this->Form->create('MealHallAssignment');?>
	<fieldset>
		<legend><?php __('Edit Meal Hall Assignment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('meal_hall_id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('accepted_student_id');
		echo $this->Form->input('academic_year');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MealHallAssignment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('MealHallAssignment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Meal Hall Assignments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Meal Halls', true), array('controller' => 'meal_halls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Hall', true), array('controller' => 'meal_halls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>