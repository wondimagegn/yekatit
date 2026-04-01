<div class="classRooms view">
<h2><?php  __('Class Room');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classRoom['ClassRoom']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Class Room Block'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($classRoom['ClassRoomBlock']['id'], array('controller' => 'class_room_blocks', 'action' => 'view', $classRoom['ClassRoomBlock']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Room Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classRoom['ClassRoom']['room_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Available For Lecture'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classRoom['ClassRoom']['available_for_lecture']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Available For Exam'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classRoom['ClassRoom']['available_for_exam']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lecture Capacity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classRoom['ClassRoom']['lecture_capacity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Exam Capacity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $classRoom['ClassRoom']['exam_capacity']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Class Room', true), array('action' => 'edit', $classRoom['ClassRoom']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Class Room', true), array('action' => 'delete', $classRoom['ClassRoom']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $classRoom['ClassRoom']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Room Blocks', true), array('controller' => 'class_room_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room Block', true), array('controller' => 'class_room_blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
