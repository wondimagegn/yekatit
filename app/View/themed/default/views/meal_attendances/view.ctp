<div class="mealAttendances view">
<h2><?php  __('Meal Attendance');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealAttendance['MealAttendance']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meal Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mealAttendance['MealType']['meal_name'], array('controller' => 'meal_types', 'action' => 'view', $mealAttendance['MealType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mealAttendance['Student']['id'], array('controller' => 'students', 'action' => 'view', $mealAttendance['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Accepted Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($mealAttendance['AcceptedStudent']['id'], array('controller' => 'accepted_students', 'action' => 'view', $mealAttendance['AcceptedStudent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealAttendance['MealAttendance']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealAttendance['MealAttendance']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meal Attendance', true), array('action' => 'edit', $mealAttendance['MealAttendance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Meal Attendance', true), array('action' => 'delete', $mealAttendance['MealAttendance']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mealAttendance['MealAttendance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Attendances', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Attendance', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Types', true), array('controller' => 'meal_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Type', true), array('controller' => 'meal_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>
