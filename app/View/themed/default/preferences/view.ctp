<div class="preferences view">
<h2><?php  __('Preference');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preference['Preference']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Selected Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($preference['SelectedStudent']['id'], array('controller' => 'selected_students', 'action' => 'view', $preference['SelectedStudent']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academicyear'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preference['Preference']['academicyear']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($preference['Department']['name'], array('controller' => 'departments', 'action' => 'view', $preference['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Preferences Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preference['Preference']['preferences_order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Preference Deadline'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preference['Preference']['preference_deadline']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preference['Preference']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preference['Preference']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Preference', true), array('action' => 'edit', $preference['Preference']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Preference', true), array('action' => 'delete', $preference['Preference']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $preference['Preference']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Preferences', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Preference', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Selected Students', true), array('controller' => 'selected_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Selected Student', true), array('controller' => 'selected_students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
	</ul>
</div>
