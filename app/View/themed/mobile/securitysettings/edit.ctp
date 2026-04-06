<div class="securitysettings form">
<?php
echo $this->Form->create('Securitysetting');
echo $this->Form->input('id');
?>
<div class="smallheading"><?php __('Update Security Setting'); ?></div>
<table class="fs12">
	<tr>
		<td style="width:20%">Minimum Password Length:</td>
		<td style="width:80%"><?php echo $this->Form->input('minimum_password_length', array('label' => false, 'options' => $min_password_length, 'style' => 'width:100px')); ?></td>
	</tr>
	<tr>
		<td>Maximum Password Length</td>
		<td><?php echo $this->Form->input('maximum_password_length', array('label' => false, 'options' => $max_password_length, 'style' => 'width:100px')); ?></td>
	</tr>
	<tr>
		<td>Password Strength</td>
		<td><?php echo $this->Form->input('password_strength', array('label' => false, 'options' => $password_strength, 'style' => 'width:600px')); ?></td>
	</tr>
	<tr>
		<td>Password Duration</td>
		<td><?php echo $this->Form->input('password_duration', array('label' => false, 'options' => $password_duration, 'style' => 'width:100px')); ?></td>
	</tr>
	<tr>
		<td>Previously Used Password Allowed</td>
		<td><?php echo $this->Form->input('previous_password_use_allowance', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Session Duration:</td>
		<td><?php echo $this->Form->input('session_duration', array('label' => false, 'options' => $session_duration, 'style' => 'width:100px')); ?></td>
	</tr>
</table>
	<?php
		//echo $this->Form->input('number_of_login_attempt');
		//echo $this->Form->input('falsify_duration');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Update Security Setting', true));?>
</div>
