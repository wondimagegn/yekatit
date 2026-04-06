<script type="text/javascript">
function getUsersBasedOnRole(obj) {
	$("#RoleID").attr('disabled', true);
	$("#UserID").attr('disabled', true);
	$("#SubmitID").attr('disabled', true);
	window.location.replace("/users/activate_account/"+obj.value);
}
</script>
<div class="smallheading">User Account Activation</div>
<p class="fs12">This tool will enable you to activate user account. Note that:</p>
<ol class="fs12">
<li>Only deactive accounts are displayed in the user list.</li>
</ol>
<?php echo $this->Form->create('User'); ?>
<div>
<table class="fs12">
	<tr>
		<td style="width:10%">Role:</td>
		<td style="width:90%"><?php echo $this->Form->input('role_id', array('label' => false, 'style' => 'width:400px', 'onchange' => 'getUsersBasedOnRole(this)', 'id' => 'RoleID', 'type' => 'select', 'default' => $role_id, 'options' => $roles)); ?></td>
	</tr>
	<tr>
		<td>User:</td>
		<td><?php echo $this->Form->input('user_id', array('label' => false, 'style' => 'width:400px', 'id' => 'UserID', 'options' => $users)); ?></td>
	</tr>
    <tr><td colspan="2"><?php echo $this->Form->Submit('Activate User Account', array('id' => 'SubmitID'));?></td></tr>
</table>
<?php echo $form->end(); ?>
</div>
