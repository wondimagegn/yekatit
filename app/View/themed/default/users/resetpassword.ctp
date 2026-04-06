<?php echo $this->Form->create('User', array('action' => 'resetpassword')); ?>
<div>
<?php
echo '<div class="smallheading">'. __('Password Reset',true).'</div>';
echo $this->Form->hidden('id');
echo $this->Form->hidden('User.role_id');
?>
<table class="fs12">
    <tr>
    	<td style="width:15%">Name:</td>
    	<td style="width:85%"><?php  echo $this->data['User']['first_name'].' '.$this->data['User']['middle_name'].' '.$this->data['User']['last_name'] ;?></td>
    </tr>
    <tr>
    	<td>Username:</td>
    	<td><?php  echo $this->data['User']['username'] ;?></td>
    </tr>
    <tr>
    	<td>Role:</td>
    	<td><?php  echo $this->data['Role']['name'] ;?></td>
    </tr>
    <tr>
    	<td>Password:</td>
    	<td><?php echo $this->Form->input('passwd', array('label' => false));?></td>
    </tr>
    <tr>
    	<td>Confirm Password:</td>
    	<td><?php echo $this->Form->input('password2', array('type'=>'password','label'=>false));?></td>
    </tr>
    <tr><td colspan="2"><?php echo $this->Form->Submit('Reset Password');?></td></tr>
</table>
</div>
