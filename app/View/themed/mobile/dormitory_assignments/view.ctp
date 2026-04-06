<div class="dormitoryAssignments view">
<h2><?php  __('Dormitory Assignment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Dormitory'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($dormitoryAssignment['Dormitory']['dorm_name'], array('controller' => 'dormitories', 'action' => 'view', $dormitoryAssignment['Dormitory']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($dormitoryAssignment['Student']['id'], array('controller' => 'students', 'action' => 'view', $dormitoryAssignment['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Accepted Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($dormitoryAssignment['AcceptedStudent']['id'], array('controller' => 'accepted_students', 'action' => 'view', $dormitoryAssignment['AcceptedStudent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Assignment Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['assignment_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Leave Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['leave_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Received'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['received']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Received Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['received_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $dormitoryAssignment['DormitoryAssignment']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dormitory Assignment', true), array('action' => 'edit', $dormitoryAssignment['DormitoryAssignment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Dormitory Assignment', true), array('action' => 'delete', $dormitoryAssignment['DormitoryAssignment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dormitoryAssignment['DormitoryAssignment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dormitory Assignments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dormitory Assignment', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dormitories', true), array('controller' => 'dormitories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dormitory', true), array('controller' => 'dormitories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>
