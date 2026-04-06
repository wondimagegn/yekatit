<div class="courseExamConstraints index">
	<h2><?php __('Course Exam Constraints');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('published_course_id');?></th>
			<th><?php echo $this->Paginator->sort('exam_date');?></th>
			<th><?php echo $this->Paginator->sort('session');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($courseExamConstraints as $courseExamConstraint):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $courseExamConstraint['CourseExamConstraint']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseExamConstraint['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $courseExamConstraint['PublishedCourse']['id'])); ?>
		</td>
		<td><?php echo $courseExamConstraint['CourseExamConstraint']['exam_date']; ?>&nbsp;</td>
		<td><?php echo $courseExamConstraint['CourseExamConstraint']['session']; ?>&nbsp;</td>
		<td><?php echo $courseExamConstraint['CourseExamConstraint']['active']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $courseExamConstraint['CourseExamConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $courseExamConstraint['CourseExamConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $courseExamConstraint['CourseExamConstraint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseExamConstraint['CourseExamConstraint']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Course Exam Constraint', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>