<div class="programTypes view">
<h2><?php  __('Program Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programType['ProgramType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programType['ProgramType']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $programType['ProgramType']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Program Type', true), array('action' => 'edit', $programType['ProgramType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Program Type', true), array('action' => 'delete', $programType['ProgramType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $programType['ProgramType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Applications', true), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application', true), array('controller' => 'applications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Placements', true), array('controller' => 'placements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Placement', true), array('controller' => 'placements', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Applications');?></h3>
	<?php if (!empty($programType['Application'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Student Id'); ?></th>
		<th><?php __('Program Type Id'); ?></th>
		<th><?php __('Acadamicyear'); ?></th>
		<th><?php __('Applicationstatus'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($programType['Application'] as $application):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $application['id'];?></td>
			<td><?php echo $application['department_id'];?></td>
			<td><?php echo $application['student_id'];?></td>
			<td><?php echo $application['program_type_id'];?></td>
			<td><?php echo $application['acadamicyear'];?></td>
			<td><?php echo $application['applicationstatus'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'applications', 'action' => 'view', $application['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'applications', 'action' => 'edit', $application['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'applications', 'action' => 'delete', $application['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $application['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Application', true), array('controller' => 'applications', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Offers');?></h3>
	<?php if (!empty($programType['Offer'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Program Type Id'); ?></th>
		<th><?php __('Acadamicyear'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($programType['Offer'] as $offer):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $offer['id'];?></td>
			<td><?php echo $offer['department_id'];?></td>
			<td><?php echo $offer['program_type_id'];?></td>
			<td><?php echo $offer['acadamicyear'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'offers', 'action' => 'view', $offer['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'offers', 'action' => 'edit', $offer['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'offers', 'action' => 'delete', $offer['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $offer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Placements');?></h3>
	<?php if (!empty($programType['Placement'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Department Id'); ?></th>
		<th><?php __('Student Id'); ?></th>
		<th><?php __('Program Type Id'); ?></th>
		<th><?php __('Academicyear'); ?></th>
		<th><?php __('Approval'); ?></th>
		<th><?php __('Applicationstatus'); ?></th>
		<th><?php __('Currentstatus'); ?></th>
		<th><?php __('Placementtype'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($programType['Placement'] as $placement):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $placement['id'];?></td>
			<td><?php echo $placement['department_id'];?></td>
			<td><?php echo $placement['student_id'];?></td>
			<td><?php echo $placement['program_type_id'];?></td>
			<td><?php echo $placement['academicyear'];?></td>
			<td><?php echo $placement['approval'];?></td>
			<td><?php echo $placement['applicationstatus'];?></td>
			<td><?php echo $placement['currentstatus'];?></td>
			<td><?php echo $placement['placementtype'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'placements', 'action' => 'view', $placement['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'placements', 'action' => 'edit', $placement['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'placements', 'action' => 'delete', $placement['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $placement['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Placement', true), array('controller' => 'placements', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
