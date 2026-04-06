<div id="view_page">
	<h2>New Password</h2>
	<form action="<?php echo $this->Html->url('/users/newpassword/'.$this->Form->value('User.id')); ?>" method="post">
	<div class="required"> 
		<?php echo $this->data['User']['first_name']." ".$this->data['User']['last_name'];?>
	 	<?php echo $this->Form->hidden('User.first_name', array('size' => '60','enabled'=>'false'));?>
	</div>
	<div class="required"> 
	 	<?php echo $this->Form->hidden('User.last_name', array('size' => '60'));?>
	</div>
	<div class="required"> 
		<b>Username: </b><?php echo $this->data['User']['username'] ;?>
	 	<?php echo $this->Form->hidden('User.username', array('size' => '60'));?>
	</div>
	<div class="required"> 
		<?php echo $this->Form->label('User.passwd', 'Password');?>
	 	<?php echo $this->Form->input('User.passwd', array('type'=>'password','size' => '30','value'=>'','label'=>false));?>
		<?php echo $this->Form->error('User.passwd', 'Please enter the Password.');?>
	</div>
	<div class="required"> 
		<?php echo $this->Form->label('User.confirmpassword', 'Confirm Password');?>
	 	<?php echo $this->Form->password('User.confirmpassword', array('size' => '30','value'=>''));?>
		<?php echo $this->Form->error('User.confirmpassword', 'Please enter the Password Again.');?>
		<?php echo $this->Form->error('User.checkpassword', 'Please Be Sure Passwords Match.');?>
	</div>
	<?php echo $this->Form->hidden('User.id')?>
	<div class="submit">
		<?php echo $this->Form->submit('Save');?>
	</div>
	</form>
</div>
<ul class="actions">
<li><?php echo $this->Html->link('Return Home', '/')?></li>
</ul>
