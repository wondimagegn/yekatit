<div class="examRoomNumberOfInvigilators index">
	<h2><?php __('Exam Room Number Of Invigilators');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('class_room_id');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th><?php echo $this->Paginator->sort('number_of_invigilator');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($examRoomNumberOfInvigilators as $examRoomNumberOfInvigilator):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($examRoomNumberOfInvigilator['ClassRoom']['id'], array('controller' => 'class_rooms', 'action' => 'view', $examRoomNumberOfInvigilator['ClassRoom']['id'])); ?>
		</td>
		<td><?php echo $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['semester']; ?>&nbsp;</td>
		<td><?php echo $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['number_of_invigilator']; ?>&nbsp;</td>
		<td><?php echo $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['created']; ?>&nbsp;</td>
		<td><?php echo $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examRoomNumberOfInvigilator['ExamRoomNumberOfInvigilator']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Exam Room Number Of Invigilator', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
	</ul>
</div>