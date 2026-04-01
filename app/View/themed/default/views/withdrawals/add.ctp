<div class="withdrawals form">
<?php echo $this->Form->create('Withdrawal');?>
	<fieldset>
		<legend><?php __('Add Withdrawal'); ?></legend>
	<?php
		echo $this->Form->input('student_id');
		echo $this->Form->input('reason');
		echo $this->Form->input('acceptance_date');
		echo $this->Form->input('forced_withdrawal');
		echo $this->Form->input('minute_number');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Withdrawals', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>