<div class="courseSubstitutionRequests form">
<?php echo $this->Form->create('CourseSubstitutionRequest');?>
	<fieldset>
		<legend><?php __('Edit Course Substitution Request'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('request_date');
		echo $this->Form->input('student_id');
		echo $this->Form->input('course_for_substitued_id');
		echo $this->Form->input('course_be_substitued_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CourseSubstitutionRequest.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CourseSubstitutionRequest.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Course Substitution Requests', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course For Substitued', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
	</ul>
</div>