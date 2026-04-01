<div class="modules view">
<h2><?php  __('Module');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['parent_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Menu'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $module['Module']['is_menu']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Module', true), array('action' => 'edit', $module['Module']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Module', true), array('action' => 'delete', $module['Module']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $module['Module']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Modules', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Module', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Role Module Maps', true), array('controller' => 'role_module_maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role Module Map', true), array('controller' => 'role_module_maps', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Role Module Maps');?></h3>
	<?php if (!empty($module['RoleModuleMap'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Role Id'); ?></th>
		<th><?php __('Module Id'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($module['RoleModuleMap'] as $roleModuleMap):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $roleModuleMap['id'];?></td>
			<td><?php echo $roleModuleMap['role_id'];?></td>
			<td><?php echo $roleModuleMap['module_id'];?></td>
			<td><?php echo $roleModuleMap['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'role_module_maps', 'action' => 'view', $roleModuleMap['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'role_module_maps', 'action' => 'edit', $roleModuleMap['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'role_module_maps', 'action' => 'delete', $roleModuleMap['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $roleModuleMap['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Role Module Map', true), array('controller' => 'role_module_maps', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
