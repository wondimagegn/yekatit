<div class="programTypeTransfers form">
<?php echo $this->Form->create('ProgramTypeTransfer');?>
	<fieldset>
		<legend><?php __('Edit Program Type Transfer'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('program_type_id');
		echo $this->Form->input('transfer_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ProgramTypeTransfer.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ProgramTypeTransfer.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Program Type Transfers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('controller' => 'program_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type', true), array('controller' => 'program_types', 'action' => 'add')); ?> </li>
	</ul>
</div>