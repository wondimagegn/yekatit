<div class="studentEvalutionRates view">
<h2><?php echo __('Student Evalution Rate'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($studentEvalutionRate['StudentEvalutionRate']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Instructor Evalution Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($studentEvalutionRate['InstructorEvalutionQuestion']['id'], array('controller' => 'instructor_evalution_questions', 'action' => 'view', $studentEvalutionRate['InstructorEvalutionQuestion']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Student'); ?></dt>
		<dd>
			<?php echo $this->Html->link($studentEvalutionRate['Student']['id'], array('controller' => 'students', 'action' => 'view', $studentEvalutionRate['Student']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Published Course'); ?></dt>
		<dd>
			<?php echo $this->Html->link($studentEvalutionRate['PublishedCourse']['id'], array('controller' => 'published_courses', 'action' => 'view', $studentEvalutionRate['PublishedCourse']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rating'); ?></dt>
		<dd>
			<?php echo h($studentEvalutionRate['StudentEvalutionRate']['rating']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($studentEvalutionRate['StudentEvalutionRate']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($studentEvalutionRate['StudentEvalutionRate']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Student Evalution Rate'), array('action' => 'edit', $studentEvalutionRate['StudentEvalutionRate']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Student Evalution Rate'), array('action' => 'delete', $studentEvalutionRate['StudentEvalutionRate']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $studentEvalutionRate['StudentEvalutionRate']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Student Evalution Rates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student Evalution Rate'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Instructor Evalution Questions'), array('controller' => 'instructor_evalution_questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Instructor Evalution Question'), array('controller' => 'instructor_evalution_questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students'), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student'), array('controller' => 'students', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Published Courses'), array('controller' => 'published_courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Published Course'), array('controller' => 'published_courses', 'action' => 'add')); ?> </li>
	</ul>
</div>
