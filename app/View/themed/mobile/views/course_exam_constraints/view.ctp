<div class="courseExamConstraints view">
<h2><?php  __('Course Exam Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseExamConstraint['CourseExamConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseExamConstraint['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $courseExamConstraint['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Exam Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseExamConstraint['CourseExamConstraint']['exam_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseExamConstraint['CourseExamConstraint']['session']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseExamConstraint['CourseExamConstraint']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Course Exam Constraint', true), array('action' => 'edit', $courseExamConstraint['CourseExamConstraint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Course Exam Constraint', true), array('action' => 'delete', $courseExamConstraint['CourseExamConstraint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseExamConstraint['CourseExamConstraint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Exam Constraints', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Exam Constraint', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
