<?php 
?>
<div id="view_page">

<?php echo $this->Form->create('User', array('action' => 'forget'));?>
<table cellpadding="0" cellspacing="0" style="margin-top:300px; width:50%; margin-left: auto; margin-right: auto" class="alpha60">
	<tr>
		<td colspan="2" style="padding-left:40px"><h2 style="color:#E8C803">Reset Lost Password</h2></td>
	</tr>
	<tr> 
	    <td colspan="2" style="padding-left:40px">
	        <div class="flashmessage"> <?php echo $this->Session->flash(); ?></div>
	    </td>
	</tr>
	<tr>
		<td style="width:42%; padding-left:40px">Email:</td>
		<td><?php echo $this->Form->input('email', array('style' => 'height:20px; width:300px; border:1px solid #073e8e; background-color:transparent;', 'size' => '40', 'class' => 'fullwidth', 'label'=> false, 'autocomplete' => "off"));?></td>
	</tr>
	<tr>
		<td colspan="2" style="height:14px">&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:40px">Please Enter the Sum of <?php echo $mathCaptcha; ?>:</td>
		<td><?php echo $this->Form->input('security_code', array('style' => 'height:20px; width:300px; border:1px solid #073e8e; background-color:transparent;', 'label' => false, 'autocomplete' => "off"));  ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="padding-top:12px"><?php echo $this->Form->submit(__('Reset Password', true)); ?></td>
	</tr>
	<tr>
		<td colspan="2" style="height:20px">&nbsp;</td>
	</tr>
</table>
<div class="required"> 
 	
</div>
<div class="submit">
	<?php echo $this->Form->end();?>
</div>
</form>
</div>
