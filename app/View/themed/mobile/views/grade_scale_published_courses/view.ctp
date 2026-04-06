<div class="gradeScalePublishedCourses view">
<h2><?php  __('Grade Scale Published Course');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScalePublishedCourse['GradeScalePublishedCourse']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Scale'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($gradeScalePublishedCourse['GradeScale']['name'], array('controller' => 'grade_scales', 'action' => 'view', $gradeScalePublishedCourse['GradeScale']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($gradeScalePublishedCourse['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $gradeScalePublishedCourse['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScalePublishedCourse['GradeScalePublishedCourse']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gradeScalePublishedCourse['GradeScalePublishedCourse']['semester']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Grade Scale Published Course', true), array('action' => 'edit', $gradeScalePublishedCourse['GradeScalePublishedCourse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Grade Scale Published Course', true), array('action' => 'delete', $gradeScalePublishedCourse['GradeScalePublishedCourse']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gradeScalePublishedCourse['GradeScalePublishedCourse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Grade Scale Published Courses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade Scale Published Course', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Grade Scales', true), array('controller' => 'grade_scales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade Scale', true), array('controller' => 'grade_scales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
