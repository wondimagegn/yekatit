<div class="instructorNumberOfExamConstraints view">
<h2><?php  __('Instructor Number Of Exam Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Staff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorNumberOfExamConstraint['Staff']['id'], array('controller' => 'staffs', 'action' => 'view', $instructorNumberOfExamConstraint['Staff']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Staff For Exam'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorNumberOfExamConstraint['StaffForExam']['staff_id'], array('controller' => 'staff_for_exams', 'action' => 'view', $instructorNumberOfExamConstraint['StaffForExam']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Year Level Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['year_level_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Max Number Of Exam'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['max_number_of_exam']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
