<div class="mealAttendances index">
	<h2><?php __('Meal Attendances');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('meal_type_id');?></th>
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('accepted_student_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($mealAttendances as $mealAttendance):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $mealAttendance['MealAttendance']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mealAttendance['MealType']['meal_name'], array('controller' => 'meal_types', 'action' => 'view', $mealAttendance['MealType']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($mealAttendance['Student']['id'], array('controller' => 'students', 'action' => 'view', $mealAttendance['Student']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($mealAttendance['AcceptedStudent']['id'], array('controller' => 'accepted_students', 'action' => 'view', $mealAttendance['AcceptedStudent']['id'])); ?>
		</td>
		<td><?php echo $mealAttendance['MealAttendance']['created']; ?>&nbsp;</td>
		<td><?php echo $mealAttendance['MealAttendance']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $mealAttendance['MealAttendance']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $mealAttendance['MealAttendance']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $mealAttendance['MealAttendance']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mealAttendance['MealAttendance']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Meal Attendance', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Meal Types', true), array('controller' => 'meal_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Meal Type', true), array('controller' => 'meal_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>