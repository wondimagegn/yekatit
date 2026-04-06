<div class="unschedulePublishedCourses view">
<h2><?php  __('Unschedule Published Course');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($unschedulePublishedCourse['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $unschedulePublishedCourse['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course Split Section'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($unschedulePublishedCourse['CourseSplitSection']['id'], array('controller' => 'course_split_sections', 'action' => 'view', $unschedulePublishedCourse['CourseSplitSection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period Length'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['period_length']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unschedulePublishedCourse['UnschedulePublishedCourse']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Unschedule Published Course', true), array('action' => 'edit', $unschedulePublishedCourse['UnschedulePublishedCourse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Unschedule Published Course', true), array('action' => 'delete', $unschedulePublishedCourse['UnschedulePublishedCourse']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $unschedulePublishedCourse['UnschedulePublishedCourse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Unschedule Published Courses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Unschedule Published Course', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('controller' => 'course_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add')); ?> </li>
	</ul>
</div>
