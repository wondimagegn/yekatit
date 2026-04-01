<div class="higherEducationBackgrounds form">
<?php echo $this->Form->create('HigherEducationBackground');?>
	<fieldset>
		<legend><?php __('Edit Higher Education Background'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('field_of_study');
		echo $this->Form->input('diploma_awarded');
		echo $this->Form->input('date_graduated');
		echo $this->Form->input('cgpa_at_graduation');
		echo $this->Form->input('city');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('HigherEducationBackground.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('HigherEducationBackground.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Higher Education Backgrounds', true), array('action' => 'index'));?></li>
	</ul>
</div>