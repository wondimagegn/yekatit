<div class="securitysettings view">
<div class="smallheading"><?php  __('Security Setting View');?></div>
	<table class="fs12">
		<tr>
			<td style="width:25%"><?php __('Minimum Password Length'); ?></td>
			<td style="width:75%"><?php echo $securitysetting['Securitysetting']['minimum_password_length']; ?></td>
		</tr>
		<tr>
			<td><?php __('Maximum Password Length'); ?></td>
			<td><?php echo $securitysetting['Securitysetting']['maximum_password_length']; ?></td>
		</tr>
		<tr>
			<td><?php __('Password Strength'); ?></td>
			<td><?php
			if($securitysetting['Securitysetting']['password_strength'] == 1) {
				echo 'Password should contain Uppercase Letters, Lowercase Letters, and Numbers.';
			}
			else {
				echo 'Password should contain Uppercase Letters, Lowercase Letters, Numbers and Symbols.';
			}
			?></td>
		</tr>
		<tr>
			<td><?php __('Password Duration'); ?></td>
			<td><?php echo $securitysetting['Securitysetting']['password_duration']; ?> Days</td>
		</tr>
		<tr>
			<td><?php __('Previous Password Use Allowed'); ?></td>
			<td><?php echo ($securitysetting['Securitysetting']['previous_password_use_allowance'] == 1 ? 'Yes' : 'No'); ?></td>
		</tr>
		<tr>
			<td><?php __('Session Duration'); ?></td>
			<td><?php echo $securitysetting['Securitysetting']['session_duration']; ?> Minues</td>
		</tr>
		<tr>
			<td><?php __('Last Updated'); ?></td>
			<td><?php echo $this->Format->humanize_date($securitysetting['Securitysetting']['modified']); ?></td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top:20px"><?php echo $this->Html->link("Change Security Setting", array('controller' => 'securitysettings', 'action' => 'edit'), array('style' => 'font-weight:bold')); ?></td>
		</tr>
	</table>
</div>
