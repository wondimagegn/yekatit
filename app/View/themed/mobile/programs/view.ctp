<div class="programs view">
<h2><?php  __('Program');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $program['Program']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $program['Program']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $program['Program']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Program', true), array('action' => 'edit', $program['Program']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Program', true), array('action' => 'delete', $program['Program']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $program['Program']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Programs', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
