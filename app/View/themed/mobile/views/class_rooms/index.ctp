<div class="classRooms index">
	<h2><?php __('Class Rooms');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('class_room_block_id');?></th>
			<th><?php echo $this->Paginator->sort('room_code');?></th>
			<th><?php echo $this->Paginator->sort('available_for_lecture');?></th>
			<th><?php echo $this->Paginator->sort('available_for_exam');?></th>
			<th><?php echo $this->Paginator->sort('lecture_capacity');?></th>
			<th><?php echo $this->Paginator->sort('exam_capacity');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($classRooms as $classRoom):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $classRoom['ClassRoom']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($classRoom['ClassRoomBlock']['id'], array('controller' => 'class_room_blocks', 'action' => 'view', $classRoom['ClassRoomBlock']['id'])); ?>
		</td>
		<td><?php echo $classRoom['ClassRoom']['room_code']; ?>&nbsp;</td>
		<td><?php echo $classRoom['ClassRoom']['available_for_lecture']; ?>&nbsp;</td>
		<td><?php echo $classRoom['ClassRoom']['available_for_exam']; ?>&nbsp;</td>
		<td><?php echo $classRoom['ClassRoom']['lecture_capacity']; ?>&nbsp;</td>
		<td><?php echo $classRoom['ClassRoom']['exam_capacity']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $classRoom['ClassRoom']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $classRoom['ClassRoom']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $classRoom['ClassRoom']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $classRoom['ClassRoom']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Class Room', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Class Room Blocks', true), array('controller' => 'class_room_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room Block', true), array('controller' => 'class_room_blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>