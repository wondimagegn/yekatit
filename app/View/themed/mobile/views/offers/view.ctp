<div class="offers view">
<h2><?php  __('Offer');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $offer['Offer']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Department'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($offer['Department']['name'], array('controller' => 'departments', 'action' => 'view', $offer['Department']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($offer['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $offer['ProgramType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Acadamicyear'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $offer['Offer']['acadamicyear']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Offer', true), array('action' => 'edit', $offer['Offer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Offer', true), array('action' => 'delete', $offer['Offer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $offer['Offer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('controller' => 'program_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type', true), array('controller' => 'program_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
