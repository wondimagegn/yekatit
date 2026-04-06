<div class="dormitories form">
<?php echo $this->Form->create('Dormitory');?>
	<fieldset>
		<legend><?php __('Add Dormitory'); ?></legend>
	<?php
		echo $this->Form->input('dormitory_block_id');
		echo $this->Form->input('dorm_number');
		echo $this->Form->input('floor');
		echo $this->Form->input('capacity');
		echo $this->Form->input('available');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dormitories', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dormitory Blocks', true), array('controller' => 'dormitory_blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dormitory Block', true), array('controller' => 'dormitory_blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
