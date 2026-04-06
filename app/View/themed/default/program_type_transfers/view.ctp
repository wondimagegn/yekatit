<div class="programTypeTransfers view">
<h2><?php  __('Program Type Transfer');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programTypeTransfer['ProgramTypeTransfer']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($programTypeTransfer['Student']['id'], array('controller' => 'students', 'action' => 'view', $programTypeTransfer['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($programTypeTransfer['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $programTypeTransfer['ProgramType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Transfer Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programTypeTransfer['ProgramTypeTransfer']['transfer_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programTypeTransfer['ProgramTypeTransfer']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programTypeTransfer['ProgramTypeTransfer']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Program Type Transfer', true), array('action' => 'edit', $programTypeTransfer['ProgramTypeTransfer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Program Type Transfer', true), array('action' => 'delete', $programTypeTransfer['ProgramTypeTransfer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $programTypeTransfer['ProgramTypeTransfer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Type Transfers', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type Transfer', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('controller' => 'program_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type', true), array('controller' => 'program_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
