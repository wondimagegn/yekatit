<div class="examSchedules view">
<h2><?php  __('Exam Schedule');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examSchedule['ExamSchedule']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Class Room'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examSchedule['ClassRoom']['id'], array('controller' => 'class_rooms', 'action' => 'view', $examSchedule['ClassRoom']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examSchedule['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $examSchedule['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acadamic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examSchedule['ExamSchedule']['acadamic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examSchedule['ExamSchedule']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Exam Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examSchedule['ExamSchedule']['exam_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examSchedule['ExamSchedule']['session']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Exam Schedule', true), array('action' => 'edit', $examSchedule['ExamSchedule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Exam Schedule', true), array('action' => 'delete', $examSchedule['ExamSchedule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examSchedule['ExamSchedule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Schedules', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Schedule', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
