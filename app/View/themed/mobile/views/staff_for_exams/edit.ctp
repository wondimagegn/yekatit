<div class="staffForExams form">
<?php echo $this->Form->create('StaffForExam');?>
	<fieldset>
		<legend><?php __('Edit Staff For Exam'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('college_id');
		echo $this->Form->input('acadamic_year');
		echo $this->Form->input('semester');
		echo $this->Form->input('staff_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('StaffForExam.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('StaffForExam.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Staff For Exams', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Colleges', true), array('controller' => 'colleges', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New College', true), array('controller' => 'colleges', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staffs', true), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff', true), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Instructor Exam Exclude Date Constraints', true), array('controller' => 'instructor_exam_exclude_date_constraints', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Instructor Exam Exclude Date Constraint', true), array('controller' => 'instructor_exam_exclude_date_constraints', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Instructor Number Of Exam Constraints', true), array('controller' => 'instructor_number_of_exam_constraints', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Instructor Number Of Exam Constraint', true), array('controller' => 'instructor_number_of_exam_constraints', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invigilators', true), array('controller' => 'invigilators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invigilator', true), array('controller' => 'invigilators', 'action' => 'add')); ?> </li>
	</ul>
</div>