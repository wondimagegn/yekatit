<?php ?>
<script type="text/javascript">
function getUsersBasedOnRole(obj) {
	$("#RoleID").attr('disabled', true);
	$("#UserID").attr('disabled', true);
	$("#NewRoleID").attr('disabled', true);
	$("#SubmitID").attr('disabled', true);
	window.location.replace("/users/change_user_role/"+obj.value);
}
</script>

<script type="text/javascript">
		
		function getUsersBasedOnRole(obj) {
			$("#RoleID").attr('disabled', true);
			$("#UserID").attr('disabled', true);
			$("#SubmitID").attr('disabled', true);
			window.location.replace("/users/change_user_role/"+obj.value);
		}

$(function() {
	$("#UserID").customselect();
	
}
); 	
</script>


<div class="box">    
     <div class="box-body">
       <div class="row">
	  <?php echo $this->Form->create('User'); ?>
	  <div class="large-12 columns">
              <h5 class="box-title">
                User Role Change
              </h5>
              <p class="fs12">This tool will enable you to change user role. It is mainly important when you want to assign a person as an administrator of the newly to-be-selected role and when department administrator leaves his position and to enable him/her gain instructor privilage. Note that:</p>
<ol class="fs12">
<li>Only active accounts are displayed in the user list.</li>
<li>It is not possible to change administrator role. You need to cancel his/her administration privilege first.</li>
</ol>

<table class="fs12">
	<tr>
		<td style="width:10%">Role:</td>
		<td style="width:90%"><?php echo $this->Form->input('role_id', array('label' => false, 'style' => 'width:400px', 'onchange' => 'getUsersBasedOnRole(this)', 'id' => 'RoleID', 'type' => 'select', 'default' => $role_id, 'options' => $roles)); ?></td>
	</tr>
	<tr>
		<td>User:</td>
		<td><?php echo $this->Form->input('user_id', array('label' => false, 'style' => 'width:400px', 'id' => 'UserID', 'class'=>'custom-select','options' => $users)); ?></td>
	</tr>
	<tr>
		<td>New Role:</td>
		<td><?php echo $this->Form->input('new_role_id', array('label' => false, 'style' => 'width:400px', 'id' => 'NewRoleID', 'type' => 'select', 'options' => $roles)); ?></td>
	</tr>
    <tr><td colspan="2"><?php echo $this->Form->Submit('Change User Role', array('id' => 'SubmitID',
'class'=>'tiny radius button bg-blue'));?></td></tr>
</table>

           </div>
         <?php echo $this->Form->end(); ?>

</div>
</div>
</div>
