<div class="mergedSectionsExams form">
<?php echo $this->Form->create('MergedSectionsExam');?>
	<fieldset>
 		<legend><?php __('Add Merged Sections Exam'); ?></legend>
	<?php
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('section_name');
		echo $this->Form->input('Section');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Merged Sections Exams', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
	</ul>
</div>