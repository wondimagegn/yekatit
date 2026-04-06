<div class="disciplines form">
<?php echo $this->Form->create('Discipline');?>
	<fieldset>
		<legend><?php __('Edit Discipline'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Discipline.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Discipline.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Disciplines', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>