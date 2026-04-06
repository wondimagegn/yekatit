<div class="academicRules view">
<h2><?php  __('Academic Rule');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicRule['AcademicRule']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicRule['AcademicRule']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('From'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicRule['AcademicRule']['from']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('To'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicRule['AcademicRule']['to']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicRule['AcademicRule']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicRule['AcademicRule']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Academic Rule', true), array('action' => 'edit', $academicRule['AcademicRule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Academic Rule', true), array('action' => 'delete', $academicRule['AcademicRule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $academicRule['AcademicRule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Academic Rules', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Academic Rule', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Academic Stands', true), array('controller' => 'academic_stands', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Academic Stand', true), array('controller' => 'academic_stands', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Academic Stands');?></h3>
	<?php if (!empty($academicRule['AcademicStand'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Year Level Id'); ?></th>
		<th><?php __('Semester'); ?></th>
		<th><?php __('Academic Year From'); ?></th>
		<th><?php __('Academic Year To'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Sort Order'); ?></th>
		<th><?php __('Status Visible'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($academicRule['AcademicStand'] as $academicStand):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $academicStand['id'];?></td>
			<td><?php echo $academicStand['year_level_id'];?></td>
			<td><?php echo $academicStand['semester'];?></td>
			<td><?php echo $academicStand['academic_year_from'];?></td>
			<td><?php echo $academicStand['academic_year_to'];?></td>
			<td><?php echo $academicStand['name'];?></td>
			<td><?php echo $academicStand['sort_order'];?></td>
			<td><?php echo $academicStand['status_visible'];?></td>
			<td><?php echo $academicStand['created'];?></td>
			<td><?php echo $academicStand['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'academic_stands', 'action' => 'view', $academicStand['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'academic_stands', 'action' => 'edit', $academicStand['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'academic_stands', 'action' => 'delete', $academicStand['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $academicStand['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Academic Stand', true), array('controller' => 'academic_stands', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
