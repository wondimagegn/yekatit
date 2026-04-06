<div class="offers form">
<?php echo $this->Form->create('Offer');?>
	<fieldset>
		<legend><?php __('Add Offer'); ?></legend>
	<?php
		echo $this->Form->input('department_id');
		echo $this->Form->input('program_type_id');
		echo $this->Form->input('acadamicyear');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Offers', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('controller' => 'program_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type', true), array('controller' => 'program_types', 'action' => 'add')); ?> </li>
	</ul>
</div>