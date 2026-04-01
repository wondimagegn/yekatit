<div class="otherAcademicRules form">
<?php echo $this->Form->create('OtherAcademicRule'); ?>
	<fieldset>
		<legend><?php echo __('Edit Other Academic Rule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('curriculum_id');
		echo $this->Form->input('course_id');
		echo $this->Form->input('academic_statuse_id');
		echo $this->Form->input('grade');
		echo $this->Form->input('number_courses');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('OtherAcademicRule.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('OtherAcademicRule.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Other Academic Rules'), array('action' => 'index')); ?></li>
	</ul>
</div>
