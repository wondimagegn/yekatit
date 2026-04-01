<div class="higherEducationBackgrounds view">
<h2><?php  __('Higher Education Background');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Field Of Study'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['field_of_study']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Diploma Awarded'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['diploma_awarded']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date Graduated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['date_graduated']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cgpa At Graduation'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['cgpa_at_graduation']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $higherEducationBackground['HigherEducationBackground']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Higher Education Background', true), array('action' => 'edit', $higherEducationBackground['HigherEducationBackground']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Higher Education Background', true), array('action' => 'delete', $higherEducationBackground['HigherEducationBackground']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $higherEducationBackground['HigherEducationBackground']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Higher Education Backgrounds', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Higher Education Background', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
