<div class="clearances form">
<?php echo $this->Form->create('Clearance');?>
	<fieldset>
		<legend><?php __('Edit Clearance'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('reason');
		echo $this->Form->input('request_date');
		echo $this->Form->input('acceptance_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Clearance.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Clearance.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Clearances', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>