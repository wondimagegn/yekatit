<div class="courseExamGapConstraints view">
<h2><?php  __('Course Exam Gap Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseExamGapConstraint['CourseExamGapConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Published Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseExamGapConstraint['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $courseExamGapConstraint['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gap Before Exam'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseExamGapConstraint['CourseExamGapConstraint']['gap_before_exam']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
