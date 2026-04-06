<div class="instructorClassPeriodCourseConstraints view">
<h2><?php  __('Instructor Class Period Course Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorClassPeriodCourseConstraint['InstructorClassPeriodCourseConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Staff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorClassPeriodCourseConstraint['Staff']['id'], array('controller' => 'staffs', 'action' => 'view', $instructorClassPeriodCourseConstraint['Staff']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Class Period'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorClassPeriodCourseConstraint['ClassPeriod']['week_day'], array('controller' => 'class_periods', 'action' => 'view', $instructorClassPeriodCourseConstraint['ClassPeriod']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('College'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorClassPeriodCourseConstraint['College']['name'], array('controller' => 'colleges', 'action' => 'view', $instructorClassPeriodCourseConstraint['College']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorClassPeriodCourseConstraint['InstructorClassPeriodCourseConstraint']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorClassPeriodCourseConstraint['InstructorClassPeriodCourseConstraint']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorClassPeriodCourseConstraint['InstructorClassPeriodCourseConstraint']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
