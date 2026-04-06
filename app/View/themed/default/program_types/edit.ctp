<div class="programTypes form">
<?php echo $this->Form->create('ProgramType');?>
	<fieldset>
		<legend><?php __('Edit Program Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ProgramType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ProgramType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Applications', true), array('controller' => 'applications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Application', true), array('controller' => 'applications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Placements', true), array('controller' => 'placements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Placement', true), array('controller' => 'placements', 'action' => 'add')); ?> </li>
	</ul>
</div>