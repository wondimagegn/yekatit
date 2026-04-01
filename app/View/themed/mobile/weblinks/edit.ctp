<div class="weblinks form">
<?php echo $this->Form->create('Weblink');?>
	<fieldset>
		<legend><?php __('Edit Weblink'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('url_address');
		echo $this->Form->input('Course');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Weblink.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Weblink.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Weblinks', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>