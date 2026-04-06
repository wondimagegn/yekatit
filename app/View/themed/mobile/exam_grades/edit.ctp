<div class="examGrades form">
<?php echo $this->Form->create('ExamGrade');?>
	<fieldset>
		<legend><?php __('Edit Exam Grade'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('grade');
		echo $this->Form->input('course_registration_id');
		echo $this->Form->input('makeup_exam_id');
		echo $this->Form->input('department_approval');
		echo $this->Form->input('department_approval_date');
		echo $this->Form->input('department_approved_by');
		echo $this->Form->input('registrar_approval');
		echo $this->Form->input('registrar_approval_date');
		echo $this->Form->input('registrar_approved_by');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExamGrade.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExamGrade.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exam Grades', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Course Registrations', true), array('controller' => 'course_registrations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Registration', true), array('controller' => 'course_registrations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Makeup Exams', true), array('controller' => 'makeup_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Makeup Exam', true), array('controller' => 'makeup_exams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Grade Changes', true), array('controller' => 'exam_grade_changes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Grade Change', true), array('controller' => 'exam_grade_changes', 'action' => 'add')); ?> </li>
	</ul>
</div>