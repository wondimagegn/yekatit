<div class="securitysettings form">
<?php echo $this->Form->create('Securitysetting');?>

		<div class="smallheading"><?php __('Add Securitysetting'); ?></div>
	<?php
	    echo "<table><tbody>";
		//echo "<tr><td>".$this->Form->input('session_duration')."</td><tr>";
		echo "<tr><td>".$this->Form->input('minimum_password_length')."</td><tr>";
		echo "<tr><td>".$this->Form->input('maximum_password_length')."</td><tr>";
		//echo "<tr><td>".$this->Form->input('password_duration')."</td><tr>";
		//echo "<tr><td>".$this->Form->input('previous_password_use_allowance')."</td><tr>";
		echo "<tr><td>". $this->Form->input('number_of_login_attempt')."</td><tr>";
		
		echo "<tr><td>".$this->Form->input('falsify_duration')."</td><tr>";
		echo "</tbody></table>";
	?>

<?php echo $this->Form->end(__('Submit', true));?>
</div>

