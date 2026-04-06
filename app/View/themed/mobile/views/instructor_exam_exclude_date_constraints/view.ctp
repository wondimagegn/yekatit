<div class="instructorExamExcludeDateConstraints view">
<h2><?php  __('Instructor Exam Exclude Date Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Staff'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorExamExcludeDateConstraint['Staff']['id'], array('controller' => 'staffs', 'action' => 'view', $instructorExamExcludeDateConstraint['Staff']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Staff For Exam'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($instructorExamExcludeDateConstraint['StaffForExam']['staff_id'], array('controller' => 'staff_for_exams', 'action' => 'view', $instructorExamExcludeDateConstraint['StaffForExam']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Exam Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['exam_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['session']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Instructor Exam Exclude Date Constraint', true), array('action' => 'edit', $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Instructor Exam Exclude Date Constraint', true), array('action' => 'delete', $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $instructorExamExcludeDateConstraint['InstructorExamExcludeDateConstraint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Instructor Exam Exclude Date Constraints', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Instructor Exam Exclude Date Constraint', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staffs', true), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff', true), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staff For Exams', true), array('controller' => 'staff_for_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff For Exam', true), array('controller' => 'staff_for_exams', 'action' => 'add')); ?> </li>
	</ul>
</div>
