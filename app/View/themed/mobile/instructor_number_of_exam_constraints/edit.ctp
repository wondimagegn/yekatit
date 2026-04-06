<div class="instructorNumberOfExamConstraints form">
<?php echo $this->Form->create('InstructorNumberOfExamConstraint');?>
	<fieldset>
		<legend><?php __('Edit Instructor Number Of Exam Constraint'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('staff_id');
		echo $this->Form->input('staff_for_exam_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('year_level_id');
		echo $this->Form->input('max_number_of_exam');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('InstructorNumberOfExamConstraint.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('InstructorNumberOfExamConstraint.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Instructor Number Of Exam Constraints', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Staffs', true), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff', true), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staff For Exams', true), array('controller' => 'staff_for_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff For Exam', true), array('controller' => 'staff_for_exams', 'action' => 'add')); ?> </li>
	</ul>
</div>