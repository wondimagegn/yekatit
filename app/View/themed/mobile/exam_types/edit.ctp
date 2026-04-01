<div class="examTypes form">
<?php echo $this->Form->create('ExamType');?>
	<fieldset>
		<legend><?php __('Edit Exam Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('exam_name');
		echo $this->Form->input('percent');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('section_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExamType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExamType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exam Types', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Results', true), array('controller' => 'exam_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Result', true), array('controller' => 'exam_results', 'action' => 'add')); ?> </li>
	</ul>
</div>