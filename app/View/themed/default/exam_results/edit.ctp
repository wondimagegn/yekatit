<div class="examResults form">
<?php echo $this->Form->create('ExamResult');?>
	<fieldset>
		<legend><?php __('Edit Exam Result'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('grade');
		echo $this->Form->input('grade_submission_date');
		echo $this->Form->input('student_id');
		echo $this->Form->input('grade_scale_id');
		echo $this->Form->input('published_course_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExamResult.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExamResult.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exam Results', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Grade Scales', true), array('controller' => 'grade_scales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade Scale', true), array('controller' => 'grade_scales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>