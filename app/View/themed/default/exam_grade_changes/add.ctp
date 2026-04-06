<div class="examGradeChanges form">
<?php echo $this->Form->create('ExamGradeChange');?>
	<fieldset>
		<legend><?php __('Add Exam Grade Change'); ?></legend>
	<?php
		echo $this->Form->input('exam_grade_id');
		echo $this->Form->input('grade');
		echo $this->Form->input('reason');
		echo $this->Form->input('minute_number');
		echo $this->Form->input('initiated_by_department');
		echo $this->Form->input('department_approval');
		echo $this->Form->input('department_approval_date');
		echo $this->Form->input('department_approved_by');
		echo $this->Form->input('registrar_approval');
		echo $this->Form->input('registrar_approval_date');
		echo $this->Form->input('registrar_approved_by');
		echo $this->Form->input('college_approval');
		echo $this->Form->input('college_approval_date');
		echo $this->Form->input('college_approved_by');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Exam Grade Changes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Exam Grades', true), array('controller' => 'exam_grades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Grade', true), array('controller' => 'exam_grades', 'action' => 'add')); ?> </li>
	</ul>
</div>