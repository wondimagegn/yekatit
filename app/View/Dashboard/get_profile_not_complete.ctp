
<?php 
//Profile not complete 
if(isset($profile_not_build) && !empty($profile_not_build)) {
?>
		<?php 		
		if($profile_not_build >0) {
		echo '<p style="font-size:12px">'.
$this->Html->link(__($profile_not_build,true), array('controller' => 'students', 'action' => 'profile_not_build_list')).' number of students profile is not complete. Please complete their profile</p>';
		}

		?>
		  <div class="utils">
		<?php echo $this->Html->link(__('View All', true), array('controller' => 'students', 'action' => 'profile_not_build_list'),array('class'=>'tiny radius button bg-blue')); ?>
		   </div>	
<?php
  } else {
?>


<?php } ?>
