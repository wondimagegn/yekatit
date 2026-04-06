<div class="classPeriodCourseConstraints view">
<h2><?php  __('Class Period Course Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classPeriodCourseConstraint['ClassPeriodCourseConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($classPeriodCourseConstraint['PublishedCourse']['id'], 
			array('controller' => 'published_courses', 'action' => 'view', 
			$classPeriodCourseConstraint['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Week Day'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classPeriodCourseConstraint['ClassPeriod']['week_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Period Setting id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($classPeriodCourseConstraint['ClassPeriod']['period_setting_id'],
			array('controller' => 'period_settings', 'action' => 'view', 
			$classPeriodCourseConstraint['ClassPeriod']['period_setting_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classPeriodCourseConstraint['ClassPeriodCourseConstraint']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classPeriodCourseConstraint['ClassPeriodCourseConstraint']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>