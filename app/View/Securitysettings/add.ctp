<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="securitysettings form">
<?php echo $this->Form->create('Securitysetting');?>

		<div class="smallheading"><?php echo __('Add Securitysetting'); ?></div>
	<?php
	    echo "<table><tbody>";
		
		echo "<tr><td>".$this->Form->input('minimum_password_length')."</td><tr>";
		echo "<tr><td>".$this->Form->input('maximum_password_length')."</td><tr>";
		echo "<tr><td>". $this->Form->input('number_of_login_attempt')."</td><tr>";
		
		echo "<tr><td>".$this->Form->input('falsify_duration')."</td><tr>";
		echo "</tbody></table>";
	?>
<?php echo $this->Form->end(array('label'=>__('Submit'),
'class'=>'tiny radius button bg-blue'));?>
</div>

	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
