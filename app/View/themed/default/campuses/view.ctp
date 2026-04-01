<div class="campuses view">
<div class="smallheading"><?php  __('Campus');?></div>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!-- <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $campus['Campus']['id']; ?>
			&nbsp;
		</dd> -->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $campus['Campus']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $campus['Campus']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<p class="fs15"><?php __('Colleges in the Campus');?></p>
	<?php if (!empty($campus['College'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<!--<th><?php __('Id'); ?></th>
		<th><?php __('Campus Id'); ?></th> -->
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Type'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($campus['College'] as $college):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<!--- <td><?php echo $college['id'];?></td>
			<td><?php echo $college['campus_id'];?></td> --->
			<td><?php echo $college['name'];?></td>
			<td><?php echo $college['description'];?></td>
			<td><?php echo $college['type'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'colleges', 'action' => 'view', $college['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'colleges', 'action' => 'edit', $college['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'colleges', 'action' => 'delete', $college['id']), null, sprintf(__('Are you sure you want to delete "%s" college?', true), $college['name'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
