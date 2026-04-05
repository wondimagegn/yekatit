<div class="placementPreferences form">
	<?= $this->Form->create('PlacementPreference'); ?>
	<fieldset>
		<legend><?= __('Edit Placement Preference'); ?></legend>
		<?php
		echo $this->Form->input('id');
		echo $this->Form->input('accepted_student_id');
		echo $this->Form->input('student_id');
		echo $this->Form->input('placement_round_participant_id');
		echo $this->Form->input('academic_year');
		echo $this->Form->input('round');
		echo $this->Form->input('preference_order');
		echo $this->Form->input('user_id');
		echo $this->Form->input('edited_by'); ?>
	</fieldset>
	<?= $this->Form->end(__('Submit')); ?>
</div>
