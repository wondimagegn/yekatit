<div class="participatingDepartments view">
<h2><?php  __('Participating Department');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $participatingDepartment['ParticipatingDepartment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('College'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($participatingDepartment['College']['name'], array('controller' => 'colleges', 'action' => 'view', $participatingDepartment['College']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($participatingDepartment['Department']['name'], array('controller' => 'departments', 'action' => 'view', $participatingDepartment['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Other College Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $participatingDepartment['ParticipatingDepartment']['other_college_department']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $participatingDepartment['ParticipatingDepartment']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $participatingDepartment['ParticipatingDepartment']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $participatingDepartment['ParticipatingDepartment']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Participating Department', true), array('action' => 'edit', $participatingDepartment['ParticipatingDepartment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Participating Department', true), array('action' => 'delete', $participatingDepartment['ParticipatingDepartment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $participatingDepartment['ParticipatingDepartment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Participating Departments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Participating Department', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colleges', true), array('controller' => 'colleges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New College', true), array('controller' => 'colleges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
	</ul>
</div>
