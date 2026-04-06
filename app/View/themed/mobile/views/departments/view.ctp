<div class="departments view">
<h2><?php  __('Department');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $department['Department']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('College'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($department['College']['name'], array('controller' => 'colleges', 'action' => 'view', $department['College']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $department['Department']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $department['Department']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="related">
	<h3><?php __('Related Staffs');?></h3>
	<?php if (!empty($department['Staff'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('College Id'); ?></th>
		<th><?php __('Position Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Title Id'); ?></th>
		<th><?php __('First Name'); ?></th>
		<th><?php __('Middle Name'); ?></th>
		<th><?php __('Ethnicity'); ?></th>
		<th><?php __('Birthdate'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($department['Staff'] as $staff):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $staff['id'];?></td>
			<td><?php echo $staff['college_id'];?></td>
			<td><?php echo $staff['position_id'];?></td>
			<td><?php echo $staff['department_id'];?></td>
			<td><?php echo $staff['title_id'];?></td>
			<td><?php echo $staff['first_name'];?></td>
			<td><?php echo $staff['middle_name'];?></td>
			<td><?php echo $staff['ethnicity'];?></td>
			<td><?php echo $staff['birthdate'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'staffs', 'action' => 'view', $staff['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'staffs', 'action' => 'edit', $staff['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'staffs', 'action' => 'delete', $staff['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $staff['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
