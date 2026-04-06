<script type="text/javascript">
function getUsersBasedOnRole(obj) {
	$("#RoleID").attr('disabled', true);
	$("#UserID").attr('disabled', true);
	$("#SubmitID").attr('disabled', true);
	window.location.replace("/users/reset_password/"+obj.value);
}
</script>
<div class="smallheading">Reset Login Account Password</div>
<p class="fs12">This tool will enable you to reset main account, instructors, and system administrators account password using voting system. Note that <br />
1. Password reset is available for active user accounts regardless of staff activeness.<br />
2. After you make password reset, it has to be confirmed by one of the other system administrator within 72 hours to be effective.
</p>
<?php echo $this->Form->create('User'); ?>
<div>
<table class="fs12">
	<tr>
		<td style="width:15%">Role:</td>
		<td style="width:85%"><?php echo $this->Form->input('role_id', array('label' => false, 'style' => 'width:400px', 'onchange' => 'getUsersBasedOnRole(this)', 'id' => 'RoleID', 'type' => 'select', 'default' => $role_id, 'options' => $roles)); ?></td>
	</tr>
	<tr>
		<td>User:</td>
		<td><?php echo $this->Form->input('user_id', array('label' => false, 'style' => 'width:400px', 'id' => 'UserID', 'options' => $users)); ?></td>
	</tr>
    <tr>
    	<td>Password:</td>
    	<td><?php echo $this->Form->input('passwd', array('label' => false));?></td>
    </tr>
    <tr>
    	<td>Confirm Password:</td>
    	<td><?php echo $this->Form->input('password2', array('type'=>'password','label'=>false));?></td>
    </tr>
    <tr><td colspan="2"><?php echo $this->Form->Submit('Reset Password', array('id' => 'SubmitID'));?></td></tr>
</table>
<?php echo $form->end(); ?>
</div>
