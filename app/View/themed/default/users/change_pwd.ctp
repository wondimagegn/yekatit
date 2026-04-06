<?php ?>
<link rel="stylesheet" type="text/css" href="/css/password_strength.css" media="screen" />
<?php echo $this->Html->script('password_strength'); ?>
<?php
echo $this->Form->create('User', array('action' => 'changePwd'));
echo $this->Form->hidden('id');
if($force_password_change == 0 && !$password_duration_expired) {
	?>
	<div class="smallheading"><?php __('Change Password'); ?></div>
	<?php
}
if($force_password_change != 0 || $password_duration_expired) {
if($force_password_change && $first_time_login == 1) {
?>
<div style="text-align:center" class="smallheading">Welcome to your SMiS Account</div>
<?php
}
else if($force_password_change == 2 && $first_time_login == 0) {
?>
<div style="text-align:center" class="smallheading">Your Account Password Is Reset</div>
<?php
}
else if($password_duration_expired) {
?>
<div style="text-align:center" class="smallheading">Time To Change Your Password</div>
<?php
}
?>
<p class="fs14">Hello <?php // echo $user_full_name; ?>,</p>
<p style="text-align:center" class="rejected fs15">PLEASE READ THE FOLLOWING MESSAGE CAREFULLY</p>
<?php
if($force_password_change && $first_time_login == 1) {
	?>
<p class="fs14">You are logedin into this account for the first time. From this time onward, you will be responsible for any action/task performed using this account. As a result, you are required to change the password that you are given from your system administrator to your own.<p>
	<?php
}
else if($force_password_change && $first_time_login == 0) {
	?>
	<p class="fs14"><strong>Based on your request</strong>, your account password is reset and you are login into this account for the first time after password reset is done. As a result, you are required to change the password that you are given from your system administrator to your own.</p>
	<p class="fs14">If you are getting this message without any request to reset your account password. Then it means your account password is changed and something has been done with your account illegally. If this is the case, please click on the "Log Out" button which is found on the upper right corner WITHOUT CHANGING THE GIVEN PASSWORD and contact your help desk so that your acount will be investigated for any abuse which is done in the name of you. <u>If you change the given password, it means you acknowledge the password reset and you can not make a complain after you make a change.</u></p>
	<?php
}
else if($password_duration_expired) {
	?>
	<p class="fs14">According to the SIS password policy, you are required to change your password every <?php echo $password_duration; ?> days. The last date your password changed was on <?php echo $this->Format->humanize_date($last_password_change_date); ?>.</p>
	<?php
}
?>
<?php
}
?>
<p class="fs14">
Inorder to make your account secure, you are required to follow the following password policy:
<ol class="fs14">
	<li>Your password length should be a minimum of <?php echo $securitysetting['Securitysetting']['minimum_password_length']; ?> and a maximum of <?php echo $securitysetting['Securitysetting']['maximum_password_length']; ?> characters. The longer the password is, the harder to crack it using brute force attack.</li>
	<?php
	if($securitysetting['Securitysetting']['password_strength'] == 1) {
		?><li>Your password should contain Uppercase Letters, Lowercase Letters and Numbers. It is advisable if you include also symbols (e.g. @#$%^&*()_+|~-=\`{}[]:";'<>/ etc).</li><?php
	}
	else {
		?><li>Your password should contain Uppercase Letters, Lowercase Letters, Numbers and Symbols (e.g. @#$%^&*()_+|~-=\`{}[]:";'<>/ etc).</li><?php
	}
	?>
	<li>Always use different password for this account from other access including email, LDAP, Active Directory, etc.</li>
	<li>Do not hint at the format of a password (e.g., "my family name")</li>
</ol>
</p>

<p class="fs14" style="font-weight:bold">In addition to the above password creation guidline, you should note the following points:</p>
<ol class="fs14">
	<li>NEVER tell/share your password to any body even to your close friend, system administrator, administrative assistants, secretaries or boss.</li>
	<li>If someone demands a password, direct them to the help desk.</li>
	<li>Passwords should NEVER be written down or stored on-line without encryption.</li>
	<li>Do not reveal a password in email, chat, or other electronic communication.</li>
	<li>Do not speak about a password in front of others.</li>
	<li>Do not reveal a password on questionnaires or security forms.</li>
	<li>When you are asked to save your password by your browser, select NEVER REMEMBER option. You should also NEVER save your password on your browser or computer as it can be known at any time by the person who has access to your computer for any reason including to temporarily use your computer, to maintain your computer or for some other reason.</li>
	<li>Make sure that the computer that you are using to access this application has good and updated anti virus to protect your computer against malware and other pesky attacks. If there is no antivirus installed on your computer or if you get "out of date" or similar warning from your anti virus software, please contact your help desk to get good anti virus and/or updates.</li>
	<li>If an account or password compromise is suspected, please report the incident to your help desk as soon as possible.</li>
</ol>
<?php
if($force_password_change == 1) {
?>
<p class="fs14" style="font-weight:bold">Please use the following form to change the given password to your own.</p>
<?php
}
else {
?>
<p class="fs14" style="font-weight:bold">Please use the following form to change your password.</p>
<?php
}
?>
<table class="fs12">
    <tr>
		 <td style="width:20%">Your Current Password:</td>
		 <td colspan="2" style="width:80%"><?php echo $this->Form->input('oldpassword',array('label'=>false,'type'=>"password")); ?></td>
	</tr>
	<tr>
		<td>New Password:</td>
		<td style="width:28%"><?php echo $this->Form->input('User.passwd',array('label'=>false,
		'type'=>"password", 'id' => 'pass', 'onkeyup' => 'passwordStrength(this.value)')); ?></td>
		<td style="width:52%">
			<p>
		      <label for="passwordStrength">Password strength: Enter the password till you get "<strong>Strong</strong>" or "<strong>Strongest</strong>" result.</label>
		      <div id="passwordDescription">Password not entered</div>
		      <div id="passwordStrength" class="strength0"></div>
          </p>
		</td>
	</tr>
	<tr>
		<td>Confirm The New Password:</td>
		
		<td colspan="2"><?php echo $this->Form->input('password2',array('type'=>"password",'label'=>false));?></td>
	  <!--
	   <td>
			<p>
		      <label for="passwordStrength">Password strength: Enter the password till you get "<strong>Strong</strong>" or "<strong>Strongest</strong>" result.</label>
		      <div id="passwordDescription">Password not entered</div>
		      <div id="passwordStrength" class="strength0"></div>
          </p>
		</td>
	  -->
	</tr>
	<tr>
		<td colspan="3"><?php echo $form->end('Change Password');?></td>
	</tr>
</table>
