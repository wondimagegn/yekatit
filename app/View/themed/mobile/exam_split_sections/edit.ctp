<div class="examSplitSections form">
<?php echo $this->Form->create('ExamSplitSection');?>
	<fieldset>
 		<legend><?php __('Edit Exam Split Section'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('section_split_for_exam_id');
		echo $this->Form->input('section_name');
		echo $this->Form->input('Student');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExamSplitSection.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExamSplitSection.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Exam Split Sections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Section Split For Exams', true), array('controller' => 'section_split_for_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section Split For Exam', true), array('controller' => 'section_split_for_exams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>