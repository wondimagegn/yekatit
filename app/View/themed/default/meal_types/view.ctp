<div class="mealTypes view">
<h2><?php  __('Meal Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealType['MealType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meal Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealType['MealType']['meal_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealType['MealType']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $mealType['MealType']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Meal Type', true), array('action' => 'edit', $mealType['MealType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Meal Type', true), array('action' => 'delete', $mealType['MealType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mealType['MealType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Type', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Meal Attendances', true), array('controller' => 'meal_attendances', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Attendance', true), array('controller' => 'meal_attendances', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Meal Attendances');?></h3>
	<?php if (!empty($mealType['MealAttendance'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Meal Type Id'); ?></th>
		<th><?php __('Student Id'); ?></th>
		<th><?php __('Accepted Student Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($mealType['MealAttendance'] as $mealAttendance):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $mealAttendance['id'];?></td>
			<td><?php echo $mealAttendance['meal_type_id'];?></td>
			<td><?php echo $mealAttendance['student_id'];?></td>
			<td><?php echo $mealAttendance['accepted_student_id'];?></td>
			<td><?php echo $mealAttendance['created'];?></td>
			<td><?php echo $mealAttendance['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'meal_attendances', 'action' => 'view', $mealAttendance['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'meal_attendances', 'action' => 'edit', $mealAttendance['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'meal_attendances', 'action' => 'delete', $mealAttendance['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mealAttendance['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Meal Attendance', true), array('controller' => 'meal_attendances', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
