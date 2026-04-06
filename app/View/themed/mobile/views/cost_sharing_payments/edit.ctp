<div class="costSharingPayments form">
<?php echo $this->Form->create('CostSharingPayment');?>
	<fieldset>
		<legend><?php __('Edit Cost Sharing Payment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('reference_number');
		echo $this->Form->input('amount');
		echo $this->Form->input('payment_type');
		echo $this->Form->input('student_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CostSharingPayment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CostSharingPayment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Cost Sharing Payments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>