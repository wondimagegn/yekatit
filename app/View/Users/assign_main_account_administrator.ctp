<?php ?>
<script type="text/javascript">
function getUsersBasedOnRole(obj) {
	$("#RoleID").attr('disabled', true);
	$("#UserID").attr('disabled', true);
	$("#SubmitID").attr('disabled', true);
	window.location.replace("/users/assign_main_account_administrator/"+obj.value);
}
</script>

<div class="box">    
     <div class="box-body">
       <div class="row">
	  <?php echo $this->Form->create('User'); ?>
	  <div class="large-12 columns">
              <h5 class="box-title">
                Main Account Administrator Assignment
              </h5>
              
<p class="fs12">This tool will enable you to assign main account administrator. Note that:</p>
<ol class="fs12">
<li>Only one administrator is allowed for the given office and please make sure that you cancel the already existing administrator before you make an assignment.</li>
<li>If to-be-assigned-account role is other than the one specified on the combo box, please use change role tool to change account role to the one which is specified on the combo box.</li>
<li>If you didn't get users for the office or role you want, it is because there is no recorded staff with the role you just selected. Please use add user tool to record office staff who is going to be an administrator.</li>
<li>Only active accounts are displayed in the user combo box and you need to activate if there is deactivated user account that you want to make an assignment for him/her.</li>
</ol>


<table class="fs12">
	<tr>
		<td style="width:10%">Role:</td>
		<td style="width:90%"><?php echo $this->Form->input('role_id', array('label' => false, 'style' => 'width:400px', 'onchange' => 'getUsersBasedOnRole(this)', 'id' => 'RoleID', 'type' => 'select', 'default' => $role_id, 'options' => $roles)); ?></td>
	</tr>
	<tr>
		<td>User:</td>
		<td><?php echo $this->Form->input('user_id', array('label' => false, 'style' => 'width:400px', 'id' => 'UserID', 'options' => $users)); ?></td>
	</tr>
    <tr><td colspan="2"><?php echo $this->Form->Submit('Assign Main Account Administrator', array('id' => 'SubmitID',
'class'=>'tiny radius button bg-blue'));?></td></tr>
</table>
           </div> 
          <?php echo $this->Form->end(); ?>
</div>
</div>
</div>
