<?php ?>
<div class="box"> 
     <div class="box-body">
       <div class="row">
	    <?php echo $this->Form->create('User', array('action' => 'resetpassword')); ?>
	    <div class="large-12 columns">
              <h5 class="box-title">
                 Password Reset
               </h5>
              <?php

echo $this->Form->hidden('id');
echo $this->Form->hidden('User.role_id');
?>
<table class="fs12">
    <tr>
    	<td style="width:15%">Name:</td>
    	<td style="width:85%"><?php  echo $this->request->data['User']['first_name'].' '.$this->request->data['User']['middle_name'].' '.$this->request->data['User']['last_name'] ;?></td>
    </tr>
    <tr>
    	<td>Username:</td>
    	<td><?php  echo $this->request->data['User']['username'] ;?></td>
    </tr>
    <tr>
    	<td>Role:</td>
    	<td><?php  echo $this->request->data['Role']['name'] ;?></td>
    </tr>
    <tr>
    	<td>Password:</td>
    	<td><?php echo $this->Form->input('passwd', array('label' => false));?></td>
    </tr>
    <tr>
    	<td>Confirm Password:</td>
    	<td><?php echo $this->Form->input('password2', array('type'=>'password','label'=>false));?></td>
    </tr>
    <tr><td colspan="2"><?php echo $this->Form->Submit('Reset Password',array('class'=>'tiny radius button bg-blue'));?></td></tr>
</table>
            </div>
       </div>
      </div>
</div>
