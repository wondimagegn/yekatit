<div class="graduationRequirements view">
<h2><?php  __('Graduation Requirement');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $graduationRequirement['GraduationRequirement']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cgpa'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $graduationRequirement['GraduationRequirement']['cgpa']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($graduationRequirement['Program']['name'], array('controller' => 'programs', 'action' => 'view', $graduationRequirement['Program']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $graduationRequirement['GraduationRequirement']['academic_year']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Applicable For Current Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $graduationRequirement['GraduationRequirement']['applicable_for_current_student']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $graduationRequirement['GraduationRequirement']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $graduationRequirement['GraduationRequirement']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Graduation Requirement', true), array('action' => 'edit', $graduationRequirement['GraduationRequirement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Graduation Requirement', true), array('action' => 'delete', $graduationRequirement['GraduationRequirement']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $graduationRequirement['GraduationRequirement']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Graduation Requirements', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Graduation Requirement', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Programs', true), array('controller' => 'programs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program', true), array('controller' => 'programs', 'action' => 'add')); ?> </li>
	</ul>
</div>
