<div class="dismissals form">
<?php echo $this->Form->create('Dismissal');?>
	<fieldset>
		<legend><?php __('Add Dismissal'); ?></legend>
	<?php
		echo $this->Form->input('student_id');
		echo $this->Form->input('reason');
		echo $this->Form->input('request_date');
		echo $this->Form->input('acceptance_date');
		echo $this->Form->input('for_good');
		echo $this->Form->input('dismisal_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dismissals', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>