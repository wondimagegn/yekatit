<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-lock-filled" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Update Site Security Settings'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				
				<?= $this->Form->create('Securitysetting'); ?>
				<?= $this->Form->input('id'); ?>

				<div style="margin-top: -30px;"><hr></div>

				<fieldset style="padding-bottom: 5px;padding-top: 15px;">
					<legend>&nbsp;&nbsp; Site Security Settings &nbsp;&nbsp;</legend>
					<div class="row">
						<div class="large-3 columns">
							<?= $this->Form->input('minimum_password_length', array('label' => 'Minimum Password Length: ', 'type' => 'number', 'min' => '6',  'max' => '10', 'step' => '1' /*, 'options' => $min_password_length*/)); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('maximum_password_length', array('label' => 'Maximum Password Length: ', 'type' => 'number', 'min' => '15',  'max' => '20', 'step' => '1' /*, 'options' => $max_password_length*/)); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('password_duration', array('label' => 'Password Duration: (Days) ', 'type' => 'number', 'min' => '30',  'max' => '240', 'step' => '30' /*, 'options' => $password_duration*/)); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('session_duration', array('label' => 'Session Duration: (Minutes)', 'type' => 'number', 'min' => '30',  'max' => '180', 'step' => '30' /*, 'options' => $session_duration*/)); ?>
						</div>
					</div>
					<div class="row">
						<div class="large-3 columns">
							<?= $this->Form->input('number_of_login_attempt', array('label' => 'Maximum Login Attempt Limit: (Times)', 'type' => 'number', 'min' => '5', 'max' => '10', 'step' => '1')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('attempt_period', array('label' => 'Time to Wait after Maximum Login Attempt: (Minutes)', 'type' => 'number', 'min' => '0', 'max' => '30', 'step' => '5')); ?>
						</div>
						<div class="large-6 columns">
							<br>
							<?= $this->Form->input('password_strength', array('label' => 'Password Strength: ', 'options' => $password_strength, 'style' => 'width:100%;')); ?>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<hr>
							<?= $this->Form->input('previous_password_use_allowance', array('label' => 'Allow Previously Used Password? ')); ?>
							<br>
						</div>
					</div>
				</fieldset>
				<hr>
				<?= $this->Form->end(array('label' => 'Update Security Setting', 'class' => 'tiny radius button bg-blue')); ?>
			</div>
		</div>
	</div>
</div>