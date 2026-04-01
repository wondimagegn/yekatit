<div class="highSchoolEducationBackgrounds form">
<?php echo $this->Form->create('HighSchoolEducationBackground');?>
	<fieldset>
		<legend><?php __('Add High School Education Background'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('town');
		echo $this->Form->input('zone');
		echo $this->Form->input('region');
		echo $this->Form->input('school_level');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List High School Education Backgrounds', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
	</ul>
</div>