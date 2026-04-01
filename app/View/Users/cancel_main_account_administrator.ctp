<?php ?>
<script type="text/javascript">
function getUsersBasedOnRole(obj) {
	$("#RoleID").attr('disabled', true);
	$("#UserID").attr('disabled', true);
	$("#SubmitID").attr('disabled', true);
	window.location.replace("/users/cancel_main_account_administrator/"+obj.value);
}
</script>
<div class="box">    
     <div class="box-body">
       <div class="row">
	  <?php echo $this->Form->create('User');?>
	  <div class="large-12 columns">
              <h5 class="box-title">
                Main Account Administrator Cancellation
              </h5>
              <p class="fs12">This tool will enable you to cancel main account administrator so that you can assign another administrator. Note that:</p>
<ol class="fs12">
<li>For security reason, any privilage which was assigned to the administrator by its username will be removed and reassignment of privilage is expected to be done again, if necessary.</li>
<li>If to-be-cancelled-account role is Department and the user is instructor, please do not forget to change his user-type from Department to Instructor so that he can get basic privilage like submiting grade, taking attendance and etc.</li>
<li>If you didn't get administrator name for the office or role you want, it is because there is no assigned administrator. Please use the administrator assignment tool to assign staff as office administrator. </li>
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
    <tr><td colspan="2"><?php echo $this->Form->Submit('Cancel Main Account Administrator', array('id' => 'SubmitID',
'class'=>'tiny radius button bg-blue'));?></td></tr>
</table>
           </div>
           <?php echo $this->Form->end(); ?>
        </div>
     </div>
</div>
