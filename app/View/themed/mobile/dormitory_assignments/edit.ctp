<div class="dormitoryAssignments form">
<?php echo $this->Form->create('DormitoryAssignment');?>
	<fieldset>
		<legend><?php __('Edit Dormitory Assignment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('dormitory_id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('accepted_student_id');
		echo $this->Form->input('assignment_date');
		echo $this->Form->input('leave_date');
		echo $this->Form->input('received');
		echo $this->Form->input('received_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('DormitoryAssignment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('DormitoryAssignment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dormitory Assignments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dormitories', true), array('controller' => 'dormitories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dormitory', true), array('controller' => 'dormitories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Accepted Students', true), array('controller' => 'accepted_students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Accepted Student', true), array('controller' => 'accepted_students', 'action' => 'add')); ?> </li>
	</ul>
</div>