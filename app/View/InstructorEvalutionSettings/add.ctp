<div class="instructorEvalutionSettings form">
<?php echo $this->Form->create('InstructorEvalutionSetting'); ?>
	<fieldset>
		<legend><?php echo __('Add Instructor Evalution Setting'); ?></legend>
	<?php
		echo $this->Form->input('academic_year');
		echo $this->Form->input('head_percent');
		echo $this->Form->input('colleague_percent');
		echo $this->Form->input('student_percent');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Instructor Evalution Settings'), array('action' => 'index')); ?></li>
	</ul>
</div>
