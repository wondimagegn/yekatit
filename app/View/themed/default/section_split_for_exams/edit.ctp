<div class="sectionSplitForExams form">
<?php echo $this->Form->create('SectionSplitForExam');?>
	<fieldset>
 		<legend><?php __('Edit Section Split For Exam'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('section_id');
		echo $this->Form->input('published_course_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('SectionSplitForExam.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('SectionSplitForExam.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Section Split For Exams', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exam Split Sections', true), array('controller' => 'exam_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam Split Section', true), array('controller' => 'exam_split_sections', 'action' => 'add')); ?> </li>
	</ul>
</div>