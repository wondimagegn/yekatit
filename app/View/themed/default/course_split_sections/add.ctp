<div class="courseSplitSections form">
<?php echo $this->Form->create('CourseSplitSection');?>
	<fieldset>
		<legend><?php __('Add Course Split Section'); ?></legend>
	<?php
		echo $this->Form->input('section_split_for_published_course_id');
		echo $this->Form->input('section_name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Section Split For Published Courses', true), array('controller' => 'section_split_for_published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section Split For Published Course', true), array('controller' => 'section_split_for_published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>