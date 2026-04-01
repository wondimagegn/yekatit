<?php 
//Course Exemption Request
if(isset($exemption_request) && !empty($exemption_request)) {
 $counter++; 
 ?>
			<table class="small_padding">
			<?php
			if($exemption_request == 0 ) {
				echo '<tr><td style="border:0px solid #ffffff" colspan="2">
				<p style="font-size:12px">There is no course exemption  requests.</p></td></tr>';
			}
			else {
				
				if($exemption_request != 0) {
				      echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">'.$this->Html->link(__('You have '.$clearance_request.' exemption request that needs your approval', true), array('controller' => 'courseExemptions',  'action'=>'list_exemption_request'), array('class' => 'action_link')).'</p></td></tr>';
				}
				
			}
			?>
		     </table>		
<?php
  }
?>
