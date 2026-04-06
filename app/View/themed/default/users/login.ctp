<?php e($this->Form->create('User', array('action' => 'login')));?>
<table id="upper_table" cellspacing="0" cellpadding="0" style="width:500px; margin-top:300px; padding:0px; margin-bottom:2px; border-bottom:0px solid; margin-left: auto; margin-right: auto;" class="bg0">
	<tr>
		<td style="background-color:#073e8e; height:10px; width:100px; padding:0px; text-align:center; font-size:22px; font-weight:bold; color:#939598; font-family:tahoma, verdana, arial">Sign In</td>
		<td <?php 
		$flash_message = $this->Session->flash();
		if(empty($flash_message)) echo ' colspan="2"'; ?> 
		class="bg0" style="<?php if(empty($flash_message)) echo 'width:450px; '; else echo 'width:100px; '; ?>height:10px; padding:4px; border-bottom:0px solid"></td>
		<?php
		if(!empty($flash_message)) {
		?>
		<td class="alpha60y" style="width:350px; font-size:12px; border:2px solid #ff0024; color:#a31919; height:10px; padding:4px"><?php echo $flash_message; ?></td>
		<?php
		}
		?>
	</tr>
</table>
<table style="width:500px; margin-top:0px; margin-left: auto; margin-right: auto; border:1px solid #43689e" cellspacing="0" cellpadding="0" class="alpha60">
	<tr>
		<td style="height:30px" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:50px; width:30%; font-weight:bold; color:#073e8e">Username:</td>
		<td style="width:70%"><?php e($this->Form->input('username', array('style' => 'height:20px; width:300px; border:1px solid #073e8e; background-color:transparent;', 'class' => 'alpha60 fullwidth','label'=>false, 'autocomplete' => "off"))); ?></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:50px; font-weight:bold; color:#073e8e">Password:</td>
		<td><?php e($this->Form->input('password', array('style' => 'height:20px; width:300px; border:1px solid #073e8e; background-color:transparent;', 'class' => 'fullwidth','label'=>false, 'autocomplete' => "off"))); ?></td>
	</tr>
	<?php
		if(isset($mathCaptcha)){
	?>
	<tr>
		<td style="text-align:center; padding-top:15px; padding-left:30px" colspan="2">Please enter the sum of <strong><?php e($mathCaptcha); ?></strong>: <?php echo $this->Form->input('security_code', array('style' => 'height:20px; width:70px; border:1px solid #073e8e; background-color:transparent;', 'label' => false, 'div' => false)); ?></td>
	</tr>
	<tr>
		<td style="text-align:center" colspan="2"></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<table style="width:300px; margin-top:15px;" cellpadding="0" cellspacing="0">
			<tr>
				<td style="font-weight:bold; font-size:13px; background-color:transparent"><?php echo $this->Html->link(__('Forget Password', true).'?', array('action' => 'forget')); ?></td>
				<td style="text-align:right; background-color:transparent"><?php e($this->Form->Submit('Enter', array('div' => false,'class' => 'submitbutton', 'style' => 'width:70px; height:25px; background-color:#336eb5; border-color:#FFFFFF; border-width:1px; color:#F5F5F5; font-weight:bold'))); ?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td style="height:15px" colspan="2">&nbsp;</td>
	</tr>
</table>
<table style="width:500px; margin-left: auto; margin-right: auto; font-family:verdana; font-size:12px">
	<tr>
		<td style="color:white; padding-top:7px; text-align:justify; font-family:verdana, arial; font-size:12px">This is a restricted network. Use of this network, its equipment, and resources
is monitored at all times and requires explicit permission from the system
adminstrator. If you do not have this permission in writing, you are violationg
the regulations of this network and can and will be prosecuted to the fullest
extent of law. By continuing into this system, you are acknowledging that you
are aware of and agree to these terms.
</td>
	</tr>
	<tr>
		<td style="height:60px">&nbsp;</td>
	</tr>
	<tr>
		<td style="color:white; padding-top:7px; text-align:center; font-family:verdana, arial; font-size:13px">&copy; 2012 Arba Minch University<br />
         <!-- Designed and Developed by Mereb Technologies -->
</td>
	</tr>
</table>
<?php e($this->Form->end()); ?>

