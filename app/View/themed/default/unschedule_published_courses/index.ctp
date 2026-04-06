<div class="unschedulePublishedCourses index">
	<h2><?php __('Unschedule Published Courses');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('published_course_id');?></th>
			<th><?php echo $this->Paginator->sort('course_split_section_id');?></th>
			<th><?php echo $this->Paginator->sort('period_length');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($unschedulePublishedCourses as $unschedulePublishedCourse):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($unschedulePublishedCourse['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $unschedulePublishedCourse['PublishedCourse']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($unschedulePublishedCourse['CourseSplitSection']['id'], array('controller' => 'course_split_sections', 'action' => 'view', $unschedulePublishedCourse['CourseSplitSection']['id'])); ?>
		</td>
		<td><?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['period_length']; ?>&nbsp;</td>
		<td><?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['type']; ?>&nbsp;</td>
		<td><?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['description']; ?>&nbsp;</td>
		<td><?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['created']; ?>&nbsp;</td>
		<td><?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $unschedulePublishedCourse['UnschedulePublishedCourse']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $unschedulePublishedCourse['UnschedulePublishedCourse']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $unschedulePublishedCourse['UnschedulePublishedCourse']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $unschedulePublishedCourse['UnschedulePublishedCourse']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Unschedule Published Course', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('controller' => 'course_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add')); ?> </li>
	</ul>
</div>