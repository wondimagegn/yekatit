<div class="reservedPlaces view">
<h2><?php  __('Reserved Place');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reservedPlace['ReservedPlace']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Placements Results Criteria'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($reservedPlace['PlacementsResultsCriteria']['name'], array('controller' => 'placements_results_criterias', 'action' => 'view', $reservedPlace['PlacementsResultsCriteria']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($reservedPlace['Department']['name'], array('controller' => 'departments', 'action' => 'view', $reservedPlace['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('College'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($reservedPlace['College']['name'], array('controller' => 'colleges', 'action' => 'view', $reservedPlace['College']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reservedPlace['ReservedPlace']['number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reservedPlace['ReservedPlace']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academicyear'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reservedPlace['ReservedPlace']['academicyear']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reservedPlace['ReservedPlace']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $reservedPlace['ReservedPlace']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Reserved Place', true), array('action' => 'edit', $reservedPlace['ReservedPlace']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Reserved Place', true), array('action' => 'delete', $reservedPlace['ReservedPlace']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $reservedPlace['ReservedPlace']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Reserved Places', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Reserved Place', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Placements Results Criterias', true), array('controller' => 'placements_results_criterias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Placements Results Criteria', true), array('controller' => 'placements_results_criterias', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Colleges', true), array('controller' => 'colleges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New College', true), array('controller' => 'colleges', 'action' => 'add')); ?> </li>
	</ul>
</div>
