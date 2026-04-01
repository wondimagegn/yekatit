<?php ?>
<div class="box">    
     <div class="box-body">
       <div class="row">
	  <?php echo $this->Form->create('Permission'); ?>
	  <div class="large-12 columns">
              <h5 class="box-title">
                Task Confirmation
              </h5>
              
<?php
if(!empty($task_confirmation_request_status)) {
	?>
<div class="fs14">List of tasks requested by you within the past 7 days and their status</div>
	<table>
		<tr>
			<th style="width:15%">Task</th>
			<th style="width:12%">Date Created</th>
			<th style="width:20%">Applicable To</th>
			<th style="width:10%">Confirmation</th>
			<th style="width:12%">Date Confirmed</th>
			<th style="width:20%">Confirmed By</th>
			<th style="width:8%">Action</th>
		</tr>
	<?php
	foreach($task_confirmation_request_status as $value) {
		$valid_date_from = date("Y-m-d H:i:s", mktime(date("H")-72, date("i"), date("s"), date("n"), date("j"), date("Y")));
		?>
		<tr>
			<td><?php echo $value['Vote']['task'];
    			$office = "";
    			if(strcasecmp($value['Vote']['task'], 'Administrator Assignment') == 0 || 
    			strcasecmp($value['Vote']['task'], 'Administrator Cancellation') == 0) {
		 			if($value['ApplicableOn']['role_id'] == ROLE_MEAL) {
		 				$office = "Meal service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_ACCOMODATION) {
		 				$office = "Accommodation service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_HEALTH) {
		 				$office = "Health service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_REGISTRAR) {
		 				$office = "Registrar service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_DEPARTMENT) {
		 				$office = $value['ApplicableOn']['Staff'][0]['Department']['name'];
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_COLLEGE) {
		 				$office = $value['ApplicableOn']['Staff'][0]['College']['name'];
		 			}
		 			echo ' to '.$office;
    			   //  echo "dd=".$value['Vote']['applicable_on_user_id'];
    			}
    			else if(strcasecmp($value['Vote']['task'], 'Role Change') == 0) {
    				$to = "";
    				if($value['Vote']['data'] == ROLE_ACCOMODATION) {
    					$to = "Accommodation";
    				}
    				else if($value['Vote']['data'] == ROLE_HEALTH) {
    					$to = "Health Service";
    				}
    				else if($value['Vote']['data'] == ROLE_MEAL) {
    					$to = "Meal Service";
    				}
    				else if($value['Vote']['data'] == ROLE_DEPARTMENT) {
    					$to = "Department";
    				}
    				else if($value['Vote']['data'] == ROLE_COLLEGE) {
    					$to = "College";
    				}
    				else if($value['Vote']['data'] == ROLE_SYSADMIN) {
    					$to = "System Administrator";
    				}
    				else if($value['Vote']['data'] == ROLE_REGISTRAR) {
    					$to = "Registrar";
    				}
    				else if($value['Vote']['data'] == ROLE_INSTRUCTOR) {
    					$to = "Instructor";
    				}
    				else if($value['Vote']['data'] == ROLE_GENERAL) {
    					$to = "General";
    				}
    				else if($value['Vote']['data'] == ROLE_CLEARANCE) {
    					$to = "Clearance";
    				}
    				echo ' to <u>'.$to.'</u>';
    			}
			?></td>
			<td><?php echo $this->Format->humanize_date($value['Vote']['created']); ?></td>
			<td><?php echo $value['ApplicableOn']['first_name'].' '.$value['ApplicableOn']['middle_name'].' '.$value['ApplicableOn']['last_name'].' ('.$value['ApplicableOn']['username'].')'; ?></td>
			<td><?php
				if($value['Vote']['created'] >= $valid_date_from) {
					echo ($value['Vote']['confirmation'] == 0 ? '<span class="on-process">Waiting</span>' : ($value['Vote']['confirmation'] == 1 ? '<span class="accepted">Accepted</span>' : '<span class="rejected">Rejected</span>' ));
				}
				else {
					echo '<span class="rejected">Expired</span>';
				}
			?></td>
			<td><?php echo ($value['Vote']['confirmation_date'] != '0000-00-00 00:00:00' && $value['Vote']['confirmation_date'] != null ? $this->Format->humanize_date($value['Vote']['confirmation_date']) : '---'); ?></td>
			<td><?php echo ($value['ConfirmedBy']['first_name'] == null ? '---' : $value['ConfirmedBy']['first_name'].' '.$value['ConfirmedBy']['middle_name'].' '.$value['ConfirmedBy']['last_name'].' ('.$value['ConfirmedBy']['username'].')'); ?></td>
			<td>
			<?php
			if($value['Vote']['confirmation'] == 0 && $value['Vote']['created'] >= $valid_date_from) {
				echo $this->Html->link(__('Cancel'), array('action' => 'cancel_task_confirmation', $value['Vote']['id']), null, sprintf(__('Are you sure you want to cancel "%s" request for "'.$value['ApplicableOn']['first_name'].' '.$value['ApplicableOn']['middle_name'].' '.$value['ApplicableOn']['last_name'].' ('.$value['ApplicableOn']['username'].')"?'), $value['Vote']['task']));
			}
			else
				echo '---';
			?>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
else {
	echo '<p class="fs14">*** There is no task which is created by you within the past 7 days. ***</p>';
}
?>
<hr />
<?php
if(!empty($tasks_for_confirmation)) {
	?>
	<div class="fs14">List of confirmation request for some critical tasks. The request will be automatically expired after 72 hours if it is not accepted.</div>
	<table>
		<tr>
			<th style="width:18%">Task</th>
			<th style="width:17%">Date Created</th>
			<th style="width:20%">Applicable To</th>
			<th style="width:25%">Requested By</th>
			<th style="width:20%; text-align:center">Action</th>
		</tr>
	<?php
	foreach($tasks_for_confirmation as $value) {
		?>
		<tr>
			<td><?php echo $value['Vote']['task'];
    			$office = "";
    			if(strcasecmp($value['Vote']['task'], 'Administrator Assignment') == 0 || strcasecmp($value['Vote']['task'], 'Administrator Cancellation') == 0) {
		 			if($value['ApplicableOn']['role_id'] == ROLE_MEAL) {
		 				$office = "Meal service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_ACCOMODATION) {
		 				$office = "Accommodation service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_HEALTH) {
		 				$office = "Health service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_REGISTRAR) {
		 				$office = "Registrar service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_DEPARTMENT) {
		 				$office = $value['ApplicableOn']['Staff'][0]['Department']['name'];
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_COLLEGE) {
		 				$office = $value['ApplicableOn']['Staff'][0]['College']['name'];
		 			}
		 			echo ' to '.$office;
    			}
    			else if(strcasecmp($value['Vote']['task'], 'Role Change') == 0) {
    				$to = "";
    				if($value['Vote']['data'] == ROLE_ACCOMODATION) {
    					$to = "Accommodation";
    				}
    				else if($value['Vote']['data'] == ROLE_HEALTH) {
    					$to = "Health Service";
    				}
    				else if($value['Vote']['data'] == ROLE_MEAL) {
    					$to = "Meal Service";
    				}
    				else if($value['Vote']['data'] == ROLE_DEPARTMENT) {
    					$to = "Department";
    				}
    				else if($value['Vote']['data'] == ROLE_COLLEGE) {
    					$to = "College";
    				}
    				else if($value['Vote']['data'] == ROLE_SYSADMIN) {
    					$to = "System Administrator";
    				}
    				else if($value['Vote']['data'] == ROLE_REGISTRAR) {
    					$to = "Registrar";
    				}
    				else if($value['Vote']['data'] == ROLE_INSTRUCTOR) {
    					$to = "Instructor";
    				}
    				else if($value['Vote']['data'] == ROLE_GENERAL) {
    					$to = "General";
    				}
    				else if($value['Vote']['data'] == ROLE_CLEARANCE) {
    					$to = "Clearance";
    				}
    				$from = "";
    				if($value['ApplicableOn']['role_id'] == ROLE_ACCOMODATION) {
    					$from = "Accommodation";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_HEALTH) {
    					$from = "Health Service";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_MEAL) {
    					$from = "Meal Service";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_DEPARTMENT) {
    					$from = "Department";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_COLLEGE) {
    					$from = "College";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_SYSADMIN) {
    					$from = "System Administrator";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_REGISTRAR) {
    					$from = "Registrar";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_INSTRUCTOR) {
    					$from = "Instructor";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_GENERAL) {
    					$from = "General";
    				}
    				else if($value['ApplicableOn']['role_id'] == ROLE_CLEARANCE) {
    					$from = "Clearance";
    				}
    				echo ' from <u>'.$from.'</u> to <u>'.$to.'</u>';
    			}
			?></td>
			<td><?php echo $this->Format->humanize_date($value['Vote']['created']); ?></td>
			<td><?php echo $value['ApplicableOn']['first_name'].' '.$value['ApplicableOn']['middle_name'].' '.$value['ApplicableOn']['last_name'].' ('.$value['ApplicableOn']['username'].')'; ?></td>
			<td><?php echo ($value['Requester']['first_name'] == null ? '---' : $value['Requester']['first_name'].' '.$value['Requester']['middle_name'].' '.$value['Requester']['last_name'].' ('.$value['Requester']['username'].')'); ?></td>
			<td class="actions">
			<?php
			$valid_date_from = date("Y-m-d H:i:s", mktime(date("H")-72, date("i"), date("s"), date("n"), date("j"), date("Y")));
			if($value['Vote']['confirmation'] == 0 && $value['Vote']['created'] >= $valid_date_from) {
				echo $this->Html->link(__('Accept'), array('action' => 'confirm_task', $value['Vote']['id']), null, sprintf(__('Are you sure you want to accept "%s" request for "'.$value['ApplicableOn']['first_name'].' '.$value['ApplicableOn']['middle_name'].' '.$value['ApplicableOn']['last_name'].' ('.$value['ApplicableOn']['username'].')"?'), $value['Vote']['task']));
			}
			else
				echo '---';
			?>
			</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
else {
	echo '<p class="fs14">*** There is no task confirmation request which is placed by other system administrators. ***</p>';
}
?>
<hr />
<?php
if(!empty($confirmed_tasks)) {
	?>
	<div class="fs14">List of tasks which are confirmed by you within the past 7 days.</div>
	<table>
		<tr>
			<th style="width:20%">Task</th>
			<th style="width:20%">Date Created</th>
			<th style="width:30%">Applicable To</th>
			<th style="width:30%">Requested By</th>
		</tr>
	<?php
	foreach($confirmed_tasks as $value) {
		?>
		<tr>
			<td><?php echo $value['Vote']['task'];
    			$office = "";
    			if(strcasecmp($value['Vote']['task'], 'Administrator Assignment') == 0 || strcasecmp($value['Vote']['task'], 'Administrator Cancellation') == 0) {
		 			if($value['ApplicableOn']['role_id'] == ROLE_MEAL) {
		 				$office = "Meal service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_ACCOMODATION) {
		 				$office = "Accommodation service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_HEALTH) {
		 				$office = "Health service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_REGISTRAR) {
		 				$office = "Health service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_DEPARTMENT) {
		 				$office = $value['ApplicableOn']['Staff'][0]['Department']['name'];
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_COLLEGE) {
		 				$office = $value['ApplicableOn']['Staff'][0]['College']['name'];
		 			}
		 			echo ' to '.$office;
    			}
    			else if(strcasecmp($value['Vote']['task'], 'Role Change') == 0) {
    				$to = "";
    				if($value['Vote']['data'] == ROLE_ACCOMODATION) {
    					$to = "Accommodation";
    				}
    				else if($value['Vote']['data'] == ROLE_HEALTH) {
    					$to = "Health Service";
    				}
    				else if($value['Vote']['data'] == ROLE_MEAL) {
    					$to = "Meal Service";
    				}
    				else if($value['Vote']['data'] == ROLE_DEPARTMENT) {
    					$to = "Department";
    				}
    				else if($value['Vote']['data'] == ROLE_COLLEGE) {
    					$to = "College";
    				}
    				else if($value['Vote']['data'] == ROLE_SYSADMIN) {
    					$to = "System Administrator";
    				}
    				else if($value['Vote']['data'] == ROLE_REGISTRAR) {
    					$to = "Registrar";
    				}
    				else if($value['Vote']['data'] == ROLE_INSTRUCTOR) {
    					$to = "Instructor";
    				}
    				else if($value['Vote']['data'] == ROLE_GENERAL) {
    					$to = "General";
    				}
    				else if($value['Vote']['data'] == ROLE_CLEARANCE) {
    					$to = "Clearance";
    				}
    				echo ' to <u>'.$to.'</u>';
    			}
			?></td>
			<td><?php echo $this->Format->humanize_date($value['Vote']['created']); ?></td>
			<td><?php echo $value['ApplicableOn']['first_name'].' '.$value['ApplicableOn']['middle_name'].' '.$value['ApplicableOn']['last_name'].' ('.$value['ApplicableOn']['username'].')'; ?></td>
			<td><?php echo ($value['Requester']['first_name'] == null ? '---' : $value['Requester']['first_name'].' '.$value['Requester']['middle_name'].' '.$value['Requester']['last_name'].' ('.$value['Requester']['username'].')'); ?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
else {
	echo '<p class="fs14">*** There is no task which is confirmed within the past 7 days. ***</p>';
}

?>
<hr />
<?php
if(!empty($other_admin_tasks)) {
	?>
	<div class="fs14">List of tasks which are asked and confirmed by other system administrators within the past 30 days.</div>
	<table>
		<tr>
			<th style="width:20%">Task</th>
			<th style="width:20%">Date Created</th>
			<th style="width:20%">Applicable To</th>
			<th style="width:20%">Requested By</th>
			<th style="width:20%">Confirmed By</th>
		</tr>
	<?php
	foreach($other_admin_tasks as $value) {
		?>
		<tr>
			<td><?php
				echo $value['Vote']['task'];
    			$office = "";
    			if(strcasecmp($value['Vote']['task'], 'Administrator Assignment') == 0 || strcasecmp($value['Vote']['task'], 'Administrator Cancellation') == 0) {
		 			if($value['ApplicableOn']['role_id'] == ROLE_MEAL) {
		 				$office = "Meal service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_ACCOMODATION) {
		 				$office = "Accommodation service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_HEALTH) {
		 				$office = "Health service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_REGISTRAR) {
		 				$office = "Health service";
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_DEPARTMENT) {
		 				$office = $value['ApplicableOn']['Staff'][0]['Department']['name'];
		 			}
		 			if($value['ApplicableOn']['role_id'] == ROLE_COLLEGE) {
		 				$office = $value['ApplicableOn']['Staff'][0]['College']['name'];
		 			}
		 			echo ' to '.$office;
    			}
    			else if(strcasecmp($value['Vote']['task'], 'Role Change') == 0) {
    				$to = "";
    				if($value['Vote']['data'] == ROLE_ACCOMODATION) {
    					$to = "Accommodation";
    				}
    				else if($value['Vote']['data'] == ROLE_HEALTH) {
    					$to = "Health Service";
    				}
    				else if($value['Vote']['data'] == ROLE_MEAL) {
    					$to = "Meal Service";
    				}
    				else if($value['Vote']['data'] == ROLE_DEPARTMENT) {
    					$to = "Department";
    				}
    				else if($value['Vote']['data'] == ROLE_COLLEGE) {
    					$to = "College";
    				}
    				else if($value['Vote']['data'] == ROLE_SYSADMIN) {
    					$to = "System Administrator";
    				}
    				else if($value['Vote']['data'] == ROLE_REGISTRAR) {
    					$to = "Registrar";
    				}
    				else if($value['Vote']['data'] == ROLE_INSTRUCTOR) {
    					$to = "Instructor";
    				}
    				else if($value['Vote']['data'] == ROLE_GENERAL) {
    					$to = "General";
    				}
    				else if($value['Vote']['data'] == ROLE_CLEARANCE) {
    					$to = "Clearance";
    				}
    				echo ' to <u>'.$to.'</u>';
    			}
			?></td>
			<td><?php echo $this->Format->humanize_date($value['Vote']['created']); ?></td>
			<td><?php echo $value['ApplicableOn']['first_name'].' '.$value['ApplicableOn']['middle_name'].' '.$value['ApplicableOn']['last_name'].' ('.$value['ApplicableOn']['username'].')'; ?></td>
			<td><?php echo ($value['Requester']['first_name'] == null ? '---' : $value['Requester']['first_name'].' '.$value['Requester']['middle_name'].' '.$value['Requester']['last_name'].' ('.$value['Requester']['username'].')'); ?></td>
			<td><?php echo ($value['ConfirmedBy']['first_name'] == null ? '---' : $value['ConfirmedBy']['first_name'].' '.$value['ConfirmedBy']['middle_name'].' '.$value['ConfirmedBy']['last_name'].' ('.$value['ConfirmedBy']['username'].')'); ?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
}
else {
	echo '<p class="fs14">*** There is no task which is created and confirmed by other system administrators within the past 30 days. ***</p>';
}
?>
           </div>         
        </div>
     </div>
</div>

