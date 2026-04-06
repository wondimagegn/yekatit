<div class="courseSplitSections index">
	<h2><?php __('Course Split Sections');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('section_split_for_published_course_id');?></th>
			<th><?php echo $this->Paginator->sort('section_name');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($courseSplitSections as $courseSplitSection):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $courseSplitSection['CourseSplitSection']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseSplitSection['SectionSplitForPublishedCourse']['id'], array('controller' => 'section_split_for_published_courses', 'action' => 'view', $courseSplitSection['SectionSplitForPublishedCourse']['id'])); ?>
		</td>
		<td><?php echo $courseSplitSection['CourseSplitSection']['section_name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $courseSplitSection['CourseSplitSection']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $courseSplitSection['CourseSplitSection']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $courseSplitSection['CourseSplitSection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseSplitSection['CourseSplitSection']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Section Split For Published Courses', true), array('controller' => 'section_split_for_published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section Split For Published Course', true), array('controller' => 'section_split_for_published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>