<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	<?php echo __('Update Security Setting'); ?>
	 </h2>
     </div>
     <div class="box-body">
       <div class="row">
	   <div class="large-12 columns">
		<?php               
		echo $this->Form->create('Securitysetting');
		echo $this->Form->input('id');
		?>
	     <table class="fs12">
	<tr>
		<td style="width:20%">Minimum Password Length:</td>
		<td style="width:80%"><?php echo $this->Form->input('minimum_password_length', array('label' => false, 'options' => $min_password_length, 'style' => 'width:100px')); ?></td>
	</tr>
	<tr>
		<td>Maximum Password Length</td>
		<td><?php echo $this->Form->input('maximum_password_length', array('label' => false, 'options' => $max_password_length, 'style' => 'width:100px')); ?></td>
	</tr>
	<tr>
		<td>Password Strength</td>
		<td><?php echo $this->Form->input('password_strength', array('label' => false, 'options' => $password_strength, 'style' => 'width:600px')); ?></td>
	</tr>
	<tr>
		<td>Password Duration</td>
		<td><?php echo $this->Form->input('password_duration', array('label' => false, 'options' => $password_duration, 'style' => 'width:100px')); ?></td>
	</tr>
	<tr>
		<td>Previously Used Password Allowed</td>
		<td><?php echo $this->Form->input('previous_password_use_allowance', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Session Duration:</td>
		<td><?php echo $this->Form->input('session_duration', array('label' => false, 'options' => $session_duration, 'style' => 'width:100px')); ?></td>
	</tr>
</table>
<?php echo $this->Form->end(array('label'=>'Update Security Setting','class'=>'tiny radius button bg-blue'));?>

	   </div>
	</div>
      </div>
</div>
