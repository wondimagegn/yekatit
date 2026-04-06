<div class="modules form">
<?php echo $this->Form->create('Module');?>
	<fieldset>
		<legend><?php __('Add Module'); ?></legend>
	<?php
		echo $this->Form->input('parent_id');
		echo $this->Form->input('name');
		echo $this->Form->input('url');
		echo $this->Form->input('order');
		echo $this->Form->input('status');
		echo $this->Form->input('is_menu');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Modules', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Role Module Maps', true), array('controller' => 'role_module_maps', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role Module Map', true), array('controller' => 'role_module_maps', 'action' => 'add')); ?> </li>
	</ul>
</div>