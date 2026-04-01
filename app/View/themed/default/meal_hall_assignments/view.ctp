<div class="mealHallAssignments view">
<h2><?php  __('Meal Hall Assignment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealHallAssignment['MealHallAssignment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meal Hall'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mealHallAssignment['MealHall']['name'], array('controller' => 'meal_halls', 'action' => 'view', $mealHallAssignment['MealHall']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mealHallAssignment['Student']['id'], array('controller' => 'students', 'action' => 'view', $mealHallAssignment['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Accepted Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mealHallAssignment['AcceptedStudent']['id'], array('controller' => 'accepted_students', 'action' => 'view', $mealHallAssignment['AcceptedStudent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealHallAssignment['MealHallAssignment']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealHallAssignment['MealHallAssignment']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealHallAssignment['MealHallAssignment']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meal Hall Assignment', true), array('action' => 'edit', $mealHallAssignment['MealHallAssignment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Meal Hall Assignment', true), array('action' => 'delete', $mealHallAssignment['MealHallAssignment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mealHallAssignment['MealHallAssignment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Hall Assignments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Hall Assignment', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Halls', true), array('controller' => 'meal_halls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Hall', true), array('controller' => 'meal_halls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>
