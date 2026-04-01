<div class="examRoomCourseConstraints index">
	<h2><?php __('Exam Room Course Constraints');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('class_room_id');?></th>
			<th><?php echo $this->Paginator->sort('published_course_id');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($examRoomCourseConstraints as $examRoomCourseConstraint):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $examRoomCourseConstraint['ExamRoomCourseConstraint']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($examRoomCourseConstraint['ClassRoom']['id'], array('controller' => 'class_rooms', 'action' => 'view', $examRoomCourseConstraint['ClassRoom']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($examRoomCourseConstraint['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $examRoomCourseConstraint['PublishedCourse']['id'])); ?>
		</td>
		<td><?php echo $examRoomCourseConstraint['ExamRoomCourseConstraint']['active']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $examRoomCourseConstraint['ExamRoomCourseConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $examRoomCourseConstraint['ExamRoomCourseConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $examRoomCourseConstraint['ExamRoomCourseConstraint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examRoomCourseConstraint['ExamRoomCourseConstraint']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Exam Room Course Constraint', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>