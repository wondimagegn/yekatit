<div class="examRoomConstraints view">
<h2><?php  __('Exam Room Constraint');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examRoomConstraint['ExamRoomConstraint']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Class Room'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($examRoomConstraint['ClassRoom']['id'], array('controller' => 'class_rooms', 'action' => 'view', $examRoomConstraint['ClassRoom']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examRoomConstraint['ExamRoomConstraint']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examRoomConstraint['ExamRoomConstraint']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Exam Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examRoomConstraint['ExamRoomConstraint']['exam_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examRoomConstraint['ExamRoomConstraint']['session']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $examRoomConstraint['ExamRoomConstraint']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Exam Room Constraint', true), array('action' => 'edit', $examRoomConstraint['ExamRoomConstraint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Exam Room Constraint', true), array('action' => 'delete', $examRoomConstraint['ExamRoomConstraint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $examRoomConstraint['ExamRoomConstraint']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Room Constraints', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Room Constraint', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
	</ul>
</div>
