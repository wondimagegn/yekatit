<div class="sectionSplitForPublishedCourses view">
<h2><?php  __('Section Split For Published Course');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sectionSplitForPublishedCourse['SectionSplitForPublishedCourse']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($sectionSplitForPublishedCourse['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $sectionSplitForPublishedCourse['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($sectionSplitForPublishedCourse['Section']['name'], array('controller' => 'sections', 'action' => 'view', $sectionSplitForPublishedCourse['Section']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sectionSplitForPublishedCourse['SectionSplitForPublishedCourse']['type']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php __('Related Course Split Sections');?></h3>
	<?php if (!empty($sectionSplitForPublishedCourse['CourseSplitSection'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Section Split For Published Course Id'); ?></th>
		<th><?php __('Section Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($sectionSplitForPublishedCourse['CourseSplitSection'] as $courseSplitSection):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $courseSplitSection['id'];?></td>
			<td><?php echo $courseSplitSection['section_split_for_published_course_id'];?></td>
			<td><?php echo $courseSplitSection['section_name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'course_split_sections', 'action' => 'view', $courseSplitSection['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'course_split_sections', 'action' => 'edit', $courseSplitSection['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'course_split_sections', 'action' => 'delete', $courseSplitSection['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseSplitSection['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
