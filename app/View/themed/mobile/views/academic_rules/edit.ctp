<div class="academicRules form">
<?php echo $this->Form->create('AcademicRule');?>
<div style="padding-bottom:20px;"></div>
	<fieldset>
		<legend class="smallheading"><?php __('Edit Academic Rule'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('from');
		echo $this->Form->input('to');
		echo $this->Form->input('AcademicStand');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('AcademicRule.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('AcademicRule.id'))); ?></li>
		
	</ul>
</div>
