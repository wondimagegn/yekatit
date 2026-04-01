<div class="classRoomCourseConstraints index">
	<h2><?php __('List of Class Room Course Constraints');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo 'S.N<u>o</u>';?></th>
			<th><?php echo $this->Paginator->sort('published_course_id');?></th>
			<th><?php echo $this->Paginator->sort('Section');?></th>
			<th><?php echo $this->Paginator->sort('class_room_id');?></th>
			<th><?php echo $this->Paginator->sort('Block');?></th>
			<th><?php echo $this->Paginator->sort('Campus');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('Option');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count = $this->Paginator->counter('%start%');
	foreach ($classRoomCourseConstraints as $classRoomCourseConstraint):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		$active = null;
		if($classRoomCourseConstraint['ClassRoomCourseConstraint']['active'] == 1){
			$active = "Assign";
		} else {
			$active = "Do Not Assign";
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($classRoomCourseConstraint['PublishedCourse']['Course']['course_code_title'], array('controller' => 'published_courses', 'action' => 'view', $classRoomCourseConstraint['PublishedCourse']['id'])); ?>
		</td>
		<td><?php echo $classRoomCourseConstraint['PublishedCourse']['Section']['name']; ?>&nbsp;</td>
		<td><?php echo $classRoomCourseConstraint['ClassRoom']['room_code']; ?>&nbsp;</td>
		<td><?php echo $classRoomCourseConstraint['ClassRoom']['ClassRoomBlock']['block_code']; ?>&nbsp;</td>
		<td><?php echo $classRoomCourseConstraint['ClassRoom']['ClassRoomBlock']['Campus']['name']; ?>&nbsp;</td>
		<td><?php echo $classRoomCourseConstraint['ClassRoomCourseConstraint']['type']; ?>&nbsp;</td>
		<td><?php echo $active; ?>&nbsp;</td>
		<td class="actions">
			<!--<?php echo $this->Html->link(__('View', true), array('action' => 'view', $classRoomCourseConstraint['ClassRoomCourseConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $classRoomCourseConstraint['ClassRoomCourseConstraint']['id'])); ?> -->
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $classRoomCourseConstraint['ClassRoomCourseConstraint']['id']), null, sprintf(__('Are you sure you want to delete?', true), $classRoomCourseConstraint['ClassRoomCourseConstraint']['id'])); ?>
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
