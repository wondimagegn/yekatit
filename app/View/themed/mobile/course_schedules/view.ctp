<div class="courseSchedules view">
<h2><?php  __('Course Schedule');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseSchedule['CourseSchedule']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Class Room'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseSchedule['ClassRoom']['id'], array('controller' => 'class_rooms', 'action' => 'view', $courseSchedule['ClassRoom']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseSchedule['Section']['name'], array('controller' => 'sections', 'action' => 'view', $courseSchedule['Section']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseSchedule['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $courseSchedule['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Split Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseSchedule['CourseSplitSection']['id'], array('controller' => 'course_split_sections', 'action' => 'view', $courseSchedule['CourseSplitSection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acadamic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseSchedule['CourseSchedule']['acadamic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseSchedule['CourseSchedule']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseSchedule['CourseSchedule']['type']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Schedule', true), array('action' => 'edit', $courseSchedule['CourseSchedule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Course Schedule', true), array('action' => 'delete', $courseSchedule['CourseSchedule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseSchedule['CourseSchedule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Schedules', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Schedule', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('controller' => 'course_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Periods', true), array('controller' => 'class_periods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Period', true), array('controller' => 'class_periods', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Class Periods');?></h3>
	<?php if (!empty($courseSchedule['ClassPeriod'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Week Day'); ?></th>
		<th><?php __('Period Setting Id'); ?></th>
		<th><?php __('College Id'); ?></th>
		<th><?php __('Program Type Id'); ?></th>
		<th><?php __('Program Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($courseSchedule['ClassPeriod'] as $classPeriod):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $classPeriod['id'];?></td>
			<td><?php echo $classPeriod['week_day'];?></td>
			<td><?php echo $classPeriod['period_setting_id'];?></td>
			<td><?php echo $classPeriod['college_id'];?></td>
			<td><?php echo $classPeriod['program_type_id'];?></td>
			<td><?php echo $classPeriod['program_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'class_periods', 'action' => 'view', $classPeriod['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'class_periods', 'action' => 'edit', $classPeriod['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'class_periods', 'action' => 'delete', $classPeriod['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $classPeriod['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Class Period', true), array('controller' => 'class_periods', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
