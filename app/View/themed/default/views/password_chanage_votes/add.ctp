<div class="passwordChanageVotes form">
<?php echo $this->Form->create('PasswordChanageVote');?>
	<fieldset>
		<legend><?php __('Add Password Chanage Vote'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('role_id');
		echo $this->Form->input('is_voted');
		echo $this->Form->input('chanage_password_request_date');
		echo $this->Form->input('done');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Password Chanage Votes', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles', true), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role', true), array('controller' => 'roles', 'action' => 'add')); ?> </li>
	</ul>
</div>