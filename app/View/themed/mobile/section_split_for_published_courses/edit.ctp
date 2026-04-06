<div class="sectionSplitForPublishedCourses form">
<?php echo $this->Form->create('SectionSplitForPublishedCourse');?>
	<fieldset>
		<legend><?php __('Edit Section Split For Published Course'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('section_id');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('SectionSplitForPublishedCourse.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('SectionSplitForPublishedCourse.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Section Split For Published Courses', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sections', true), array('controller' => 'sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Section', true), array('controller' => 'sections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Split Sections', true), array('controller' => 'course_split_sections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Split Section', true), array('controller' => 'course_split_sections', 'action' => 'add')); ?> </li>
	</ul>
</div>