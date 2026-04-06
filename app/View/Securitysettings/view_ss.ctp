<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-lock-filled" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Site Security Settings'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">

				<div style="margin-top: -30px;"><hr></div>

				<?= $this->Form->create('Securitysetting'); ?>

				<fieldset style="padding-bottom: 5px;padding-top: 15px;">
					<legend>&nbsp;&nbsp; Site Security Settings &nbsp;&nbsp;</legend>
					<div class="row">
						<div class="large-3 columns">
							<?= $this->Form->input('minimum_password_length', array('label' => 'Minimum Password Length: ', 'type' => 'number', 'min' => '6',  'max' => '10', 'step' => '1', 'value' => $securitysetting['Securitysetting']['minimum_password_length'], 'disabled')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('maximum_password_length', array('label' => 'Maximum Password Length: ', 'type' => 'number', 'min' => '15',  'max' => '20', 'step' => '1', 'value' => $securitysetting['Securitysetting']['maximum_password_length'] , 'disabled')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('password_duration', array('label' => 'Password Duration: (Days) ', 'type' => 'number', 'min' => '30',  'max' => '240', 'step' => '30', 'value' => $securitysetting['Securitysetting']['password_duration'], 'disabled')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('session_duration', array('label' => 'Session Duration: (Minutes)', 'type' => 'number', 'min' => '30',  'max' => '180', 'step' => '30' , 'value' => $securitysetting['Securitysetting']['session_duration'], 'disabled')); ?>
						</div>
					</div>
					<div class="row">
						<div class="large-3 columns">
							<?= $this->Form->input('number_of_login_attempt', array('label' => 'Maximum Login Attempt Limit: (Times)', 'type' => 'number', 'min' => '5', 'max' => '10', 'step' => '1', 'value' => $securitysetting['Securitysetting']['number_of_login_attempt'], 'disabled')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('attempt_period', array('label' => 'Time to Wait after Maximum Login Attempt: (Minutes)', 'type' => 'number', 'min' => '0', 'max' => '30', 'step' => '5', 'value' => $securitysetting['Securitysetting']['attempt_period'], 'disabled')); ?>
						</div>
						<div class="large-6 columns">
							<br>
							<?= $this->Form->input('password_strength', array('label' => 'Password Strength: ', 'options' => $password_strength, 'style' => 'width:100%;', 'value' => $securitysetting['Securitysetting']['password_strength'], 'disabled')); ?>
						</div>
					</div>
					<div class="row">
						<div class="large-6 columns">
							<hr>
							<?= $this->Form->input('previous_password_use_allowance', array('label' => 'Allow Previously Used Password? ', 'checked' => $securitysetting['Securitysetting']['previous_password_use_allowance'], 'disabled')); ?>
							<br>
						</div>
						<div class="large-6 columns">
							<hr>
							<?= __('Last Updated: '); ?>
							<?= $this->Time->format("M j, Y g:i A", $securitysetting['Securitysetting']['modified'], NULL, NULL); ?>
							<br>
						</div>
					</div>
				</fieldset>
				<hr>
				<?= $this->Form->end(); ?>
				<?= $this->Html->link('Change Site Security Setting', array('controller' => 'securitysettings', 'action' => 'edit'), array('style' => 'font-weight:bold', 'class' => 'tiny radius button bg-blue')); ?>
			</div>
		</div>
	</div>
</div>