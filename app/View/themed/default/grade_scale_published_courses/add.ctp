<div class="gradeScalePublishedCourses form">
<?php echo $this->Form->create('GradeScalePublishedCourse');?>
	<fieldset>
		<legend><?php __('Add Grade Scale Published Course'); ?></legend>
	<?php
		echo $this->Form->input('grade_scale_id');
		echo $this->Form->input('published_course_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('semester');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Grade Scale Published Courses', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Grade Scales', true), array('controller' => 'grade_scales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade Scale', true), array('controller' => 'grade_scales', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses', true), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course', true), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>