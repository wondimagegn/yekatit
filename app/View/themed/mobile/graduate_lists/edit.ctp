<div class="graduateLists form">
<?php echo $this->Form->create('GraduateList');?>
	<fieldset>
 		<legend><?php __('Edit Graduate List'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('minute_number');
		echo $this->Form->input('graduate_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('GraduateList.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('GraduateList.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Graduate Lists', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>