<div class="classRoomClassPeriodConstraints form">
<?php echo $this->Form->create('ClassRoomClassPeriodConstraint');?>
	<fieldset>
		<legend><?php __('Edit Class Room Class Period Constraint'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('class_room_id');
		echo $this->Form->input('class_period_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ClassRoomClassPeriodConstraint.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ClassRoomClassPeriodConstraint.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Class Room Class Period Constraints', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Class Rooms', true), array('controller' => 'class_rooms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Room', true), array('controller' => 'class_rooms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Class Periods', true), array('controller' => 'class_periods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Class Period', true), array('controller' => 'class_periods', 'action' => 'add')); ?> </li>
	</ul>
</div>