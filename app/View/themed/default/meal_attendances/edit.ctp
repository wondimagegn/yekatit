<div class="mealAttendances form">
<?php echo $this->Form->create('MealAttendance');?>
	<fieldset>
		<legend><?php __('Edit Meal Attendance'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('meal_type_id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('accepted_student_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MealAttendance.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('MealAttendance.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Meal Attendances', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Meal Types', true), array('controller' => 'meal_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Type', true), array('controller' => 'meal_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>