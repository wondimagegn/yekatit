<div class="examExcludedDateAndSessions form">
<?php echo $this->Form->create('ExamExcludedDateAndSession');?>
	<fieldset>
		<legend><?php __('Edit Exam Excluded Date And Session'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('exam_period_id');
		echo $this->Form->input('excluded_date');
		echo $this->Form->input('session');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExamExcludedDateAndSession.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExamExcludedDateAndSession.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exam Excluded Date And Sessions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Exam Periods', true), array('controller' => 'exam_periods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Period', true), array('controller' => 'exam_periods', 'action' => 'add')); ?> </li>
	</ul>
</div>