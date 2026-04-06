<div class="attachments form">
<?php echo $this->Form->create('Attachment');?>
	<fieldset>
		<legend><?php __('Add Attachment'); ?></legend>
	<?php
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('dirname');
		echo $this->Form->input('basename');
		echo $this->Form->input('checksum');
		echo $this->Form->input('group');
		echo $this->Form->input('alternative');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Attachments', true), array('action' => 'index'));?></li>
	</ul>
</div>

