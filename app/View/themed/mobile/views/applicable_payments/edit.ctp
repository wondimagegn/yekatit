<div class="applicablePayments form">
<?php echo $this->Form->create('ApplicablePayment');?>
	<fieldset>
		<legend><?php __('Edit Applicable Payment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('tutition_fee');
		echo $this->Form->input('meal');
		echo $this->Form->input('accomodation');
		echo $this->Form->input('health');
		echo $this->Form->input('sponsor_type');
		echo $this->Form->input('sponsor_name');
		echo $this->Form->input('sponsor_address');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ApplicablePayment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ApplicablePayment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Applicable Payments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>