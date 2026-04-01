<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	 <?php echo __('Security Setting View');?>
	 </h2>
     </div>
     <div class="box-body">
	

       <div class="row">
	   <div class="large-12 columns">
                <table class="fs12">
		<tr>
			<td style="width:25%"><?php echo __('Minimum Password Length'); ?></td>
			<td style="width:75%"><?php echo $securitysetting['Securitysetting']['minimum_password_length']; ?></td>
		</tr>
		<tr>
			<td><?php echo __('Maximum Password Length'); ?></td>
			<td><?php echo $securitysetting['Securitysetting']['maximum_password_length']; ?></td>
		</tr>
		<tr>
			<td><?php echo __('Password Strength'); ?></td>
			<td><?php
			if($securitysetting['Securitysetting']['password_strength'] == 1) {
				echo 'Password should contain Uppercase Letters, Lowercase Letters, and Numbers.';
			}
			else {
				echo 'Password should contain Uppercase Letters, Lowercase Letters, Numbers and Symbols.';
			}
			?></td>
		</tr>
		<tr>
			<td><?php echo __('Password Duration'); ?></td>
			<td><?php echo $securitysetting['Securitysetting']['password_duration']; ?> Days</td>
		</tr>
		<tr>
			<td><?php echo __('Previous Password Use Allowed'); ?></td>
			<td><?php echo ($securitysetting['Securitysetting']['previous_password_use_allowance'] == 1 ? 'Yes' : 'No'); ?></td>
		</tr>
		<tr>
			<td><?php echo __('Session Duration'); ?></td>
			<td><?php echo $securitysetting['Securitysetting']['session_duration']; ?> Minues</td>
		</tr>
		<tr>
			<td><?php echo __('Last Updated'); ?></td>
			<td><?php echo $this->Format->humanize_date($securitysetting['Securitysetting']['modified']); ?></td>
		</tr>
		<tr>
			<td colspan="2" style="padding-top:20px"><?php echo $this->Html->link("Change Security Setting", array('controller' => 'securitysettings', 'action' => 'edit'), array('style' => 'font-weight:bold','class'=>'tiny radius button bg-blue')); ?></td>
		</tr>
	</table>
	   </div>

       </div>
    </div>
</div>
