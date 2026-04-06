<div class="makeupExams form">
<?php echo $this->Form->create('MakeupExam');?>
	<fieldset>
		<legend><?php __('Edit Makeup Exam'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('minute_number');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('section_id');
		echo $this->Form->input('student_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MakeupExam.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('MakeupExam.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Makeup Exams', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Grades', true), array('controller' => 'exam_grades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Grade', true), array('controller' => 'exam_grades', 'action' => 'add')); ?> </li>
	</ul>
</div>