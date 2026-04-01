<div class="courseExemptions form">
<?php echo $this->Form->create('CourseExemption');?>
	<fieldset>
		<legend><?php __('Edit Course Exemption'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('request_date');
		echo $this->Form->input('reason');
		echo $this->Form->input('taken_course_title');
		echo $this->Form->input('taken_course_code');
		echo $this->Form->input('course_taken_credit');
		echo $this->Form->input('department_accept_reject');
		echo $this->Form->input('department_reason');
		echo $this->Form->input('registrar_confirm_deny');
		echo $this->Form->input('registrar_reason');
		echo $this->Form->input('department_approve');
		echo $this->Form->input('department_approve_by');
		echo $this->Form->input('registrar_approve');
		echo $this->Form->input('registrar_approve_by');
		echo $this->Form->input('course_id');
		echo $this->Form->input('student_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CourseExemption.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CourseExemption.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Exemptions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>