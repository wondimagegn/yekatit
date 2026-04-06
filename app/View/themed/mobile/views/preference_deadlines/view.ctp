<div class="preferenceDeadlines view">
<h2><?php  __('Preference Deadline');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preferenceDeadline['PreferenceDeadline']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Preference Deadline'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preferenceDeadline['PreferenceDeadline']['preference_deadline']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academicyear'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preferenceDeadline['PreferenceDeadline']['academicyear']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preferenceDeadline['PreferenceDeadline']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $preferenceDeadline['PreferenceDeadline']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Preference Deadline', true), array('action' => 'edit', $preferenceDeadline['PreferenceDeadline']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Preference Deadline', true), array('action' => 'delete', $preferenceDeadline['PreferenceDeadline']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $preferenceDeadline['PreferenceDeadline']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Preference Deadlines', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Preference Deadline', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Preferences', true), array('controller' => 'preferences', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Preference', true), array('controller' => 'preferences', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Preferences');?></h3>
	<?php if (!empty($preferenceDeadline['Preference'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Accepted Student Id'); ?></th>
		<th><?php __('Academicyear'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Preferences Order'); ?></th>
		<th><?php __('Preference Deadline Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($preferenceDeadline['Preference'] as $preference):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $preference['id'];?></td>
			<td><?php echo $preference['accepted_student_id'];?></td>
			<td><?php echo $preference['academicyear'];?></td>
			<td><?php echo $preference['department_id'];?></td>
			<td><?php echo $preference['preferences_order'];?></td>
			<td><?php echo $preference['preference_deadline_id'];?></td>
			<td><?php echo $preference['created'];?></td>
			<td><?php echo $preference['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'preferences', 'action' => 'view', $preference['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'preferences', 'action' => 'edit', $preference['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'preferences', 'action' => 'delete', $preference['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $preference['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Preference', true), array('controller' => 'preferences', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
