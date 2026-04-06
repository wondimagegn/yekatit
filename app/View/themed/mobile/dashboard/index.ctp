<?php ?>
<script type="text/javascript">
var image = new Image();
image.src = '/img/busy.gif';
var delete_message_on_process = false;
function closeMessage(id) {
	if(delete_message_on_process == false) {
		delete_message_on_process = true;
		$("#AutoMessageDeleting").append('<p style="font-size:10px">Processing...</p>');
		try {
			var row = document.getElementById(id+'1');
			row.parentNode.removeChild(row);
			row = document.getElementById(id+'2');
			row.parentNode.removeChild(row);
		}catch(e) {
			alert(e);
		}
		
		var formUrl = '/auto_messages/delete/'+id;
		$.ajax({
			type: 'get',
			url: formUrl,
			data: id,
			success: function(data,textStatus,xhr){
				$("#AutoMessage").empty();
				$("#AutoMessage").append(data);
				$("#AutoMessageDeleting").empty();
				delete_message_on_process = false;
			},
			error: function(xhr,textStatus,error){
				alert(textStatus);
			}
		});
	}
	return false;
}
$(document).ready(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$("#dialog-modal").dialog({
			heght: 140,
			width:400,
			autoOpen: false,
			closeOnEscape: true,
			modal: true

	});

	$(".jsview").click(function() {
				$('#dialog-modal').empty().html('<img src="'+image.src+'" class="displayed" >');
				$("#dialog-modal").dialog("open");

				return false;
	});		

});
</script>
<style>
table.condence tr td{
	padding:2px;
}
.action_content{
	padding:2px;
	font-size:12px;
}

.action_link, .action_link a{
	font-size:12px;
	color:#272525;
	font-weight:normal;
	padding-left:0px;
	text-decoration:underline;
}
</style>
<div id="dialog-modal" title="Course Details"></div>
<div id="content" class="container_12 clearfix">
				<div class="grid_5">
					<div class="box">
						<h2><?php echo $username; ?></h2>
						  <p><strong>Last Signed In : </strong> <?php 
						
						  echo $this->Format->humanize_date($last_login);?><br /></p>
						<!-- <div class="utils">
							<a href="#">View More</a>
						</div> -->
						<!-- <p><strong>Last Signed In : </strong> Wed 11 Nov, 7:31<br /><strong>IP Address : </strong> 192.168.1.101</p>
					    -->
					</div>
				  <!-- 
					<div class="box">
						<h2>Files</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>Newton 2</td>
									<td>8/10</td>
								</tr>
								<tr>
									<td>Wicked Twister</td>
									<td>9/10</td>
								</tr>
								<tr>
									<td>Forester</td>
									<td>9.12/10</td>
								</tr>
								<tr>
									<td>Sabertooth</td>
									<td>8.9/10</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					-->
					
		<div class="box">
			<h2>Messages</h2>
			<div class="utils">
			</div>
			<span id="AutoMessageDeleting" style="padding:0px"></span>
			<table style="width:100%" class="condence" id="AutoMessage">
				<?php
				if(empty($auto_messages)) {
					echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="padding-bottom:17px">There is no message to display.</p></td></tr>';
				}
				else {
					foreach($auto_messages as $key => $auto_message) {
						?>
						<tr id="<?php echo $auto_message['AutoMessage']['id']; ?>1">
							<td style="font-size:10px; font-weight:bold"><?php echo $this->Format->humanize_date($auto_message['AutoMessage']['created']); ?> (<span style="color:red; cursor:url('../img/error.ico'), default" onclick="closeMessage('<?php echo $auto_message['AutoMessage']['id']; ?>')">close</span>)</td>
						</tr>
						<tr id="<?php echo $auto_message['AutoMessage']['id']; ?>2">
							<td style="padding-left:10px"><?php echo $auto_message['AutoMessage']['message']; ?></td>
						</tr>
						<?php
					}
				}
				?>
			</table>
		</div>
					<!-- 
					<div class="box">
						<h2>CMS Updates</h2>
						<div class="utils">
							<a href="#">Check</a>
						</div>
						<p class="center">You are running the latest version.</p>
					</div>
					-->
				</div>
            <div class='grid_6'>
				     <?php
				     if(isset($password_reset_confirmation_request) || isset($admin_cancelation_confirmation_request) || isset($confirmed_tasks) || isset($admin_assignment_confirmation_request) || isset($role_change_confirmation_request) || isset($deactivation_confirmation_request) || isset($activation_confirmation_request)) {
				     	?>
						 <div class='box'>
						 	<h2>Confirmation Request</h2>
						 	<?php
						 	if($password_reset_confirmation_request > 0 || $admin_cancelation_confirmation_request > 0 || count($confirmed_tasks) > 0 || $admin_assignment_confirmation_request > 0 || $role_change_confirmation_request > 0 || $deactivation_confirmation_request > 0 || $activation_confirmation_request > 0) {
						 		?>
						 		<table style="padding-bottom:20px">
						 			<?php
						 			if($password_reset_confirmation_request > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">You have <?php echo $password_reset_confirmation_request; ?> password reset confirmation request. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			if($admin_cancelation_confirmation_request > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">You have <?php echo $admin_cancelation_confirmation_request; ?> administrator cancellation confirmation request. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			if($admin_assignment_confirmation_request > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">You have <?php echo $admin_assignment_confirmation_request; ?> administrator assignment confirmation request. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			if(count($confirmed_tasks) > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">There are <?php echo count($confirmed_tasks); ?> tasks which are done by other system administrators. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			if($role_change_confirmation_request > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">You have <?php echo $role_change_confirmation_request; ?> role change request. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			if($deactivation_confirmation_request > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">You have <?php echo $deactivation_confirmation_request; ?> user account deactivation request. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			if($activation_confirmation_request > 0) {
						 			?>
						 			<tr>
						 				<td style="border-bottom:0px">You have <?php echo $activation_confirmation_request; ?> user account activation request. <?php echo $this->Html->link(__('View', true), array('action' => 'task_confirmation', 'controller' => 'users')); ?></td>
						 			</tr>
						 			<?php
						 			}
						 			?>
						 		</table>
						 		<?php
						 	}
						 	else {
						 		echo '<p style="padding-top:20px; padding-bottom:30px">There is no confirmation request.</p>';
						 	}
						 	?>
						 </div>
				     	<?php
				     }
				     ?>
				     <?php 
                    if (0 && (isset($usersActivities) && !empty($usersActivities))) {
                    ?>
				    <div class='box'>
				    <h2>Recent Log</h2>
			        
                    <?php 
                    foreach ($usersActivities as $k=>$v) {
                     
                        $extract=$grade_type=explode('~',$k);
                      
                       
                        
                       
                        echo "<table><tr>";
                       /* echo '<td> Full Name:'.$extract[0].' </td>';
                        echo '<td> Role '.$extract[1].'</td>';
                        echo '<td> Username '.$extract[1].'</td>';  
                        echo '</tr>';
                        
                        echo "<tr><td> The above user has performed the following activities in the system</td>";
                        echo "</tr>";
                        */
                        echo "<tr><td>";
                            echo "<table>";
                            echo "<tr><th>Date</th><th>Model</th><th>User</th><th>IP</th><th>Change</th></tr>";
                            foreach ($v as $k=>$d) {
                                echo "<tr><td>".$this->Format->humanize_date($d['Log']['created'])."</td><td>".$d['Log']['model']."</td><td>".$extract[0]."</td><td>".$d['Log']['ip']."</td><td><table>";
                                foreach(explode(',',$d['Log']['change']) as $change ){
                                     preg_match('/(\w+?) \((\w*?)\) => \((\w+?)\)/', $change, $matches); 
                                    if(isset($matches)&&!empty($matches)){
                                    list($search, $field, $from, $to) = $matches;
                                    echo "<tr><td>"."change \"$field\" from \"$from\" to \"$to\"\n".'</td></tr>';
                                    }
                                }
                                echo "</table></td></tr>";
                            }
                            echo "</table>";
                        echo "</td></tr>";
                        echo "</table>";    
                    }
                    ?>
                    </div>
                    <?php 
                   }
                  ?>
				<?php
				if(isset($latest_assigned_courses)) {
				?>
					<div class="box">
						<h2>Assigned Courses</h2>
						<table class="small_padding">
							<?php
							if(empty($latest_assigned_courses)) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="padding-bottom:17px">Currently you do not have assigned courses.</p></td></tr>';
							}
							else {
								foreach($latest_assigned_courses as $key => $latest_assigned_course) {
									?>
									<tr>
										<td><?php
										echo '<strong>Course:</strong> '.$latest_assigned_course['Course']['course_title'].' ('.$latest_assigned_course['Course']['course_code'].')<br /><strong>Section:</strong> '.$latest_assigned_course['Section']['name'].' ('.(isset($latest_assigned_course['Department']['name']) ? $latest_assigned_course['Department']['name'].' Department' : $latest_assigned_course['College']['name'].' Freshman Program').')';
										?></td>
									</tr>
									<tr>
										<td>
										<?php
										echo $this->Html->link(__('Manage Exam', true), array('controller' => 'exam_results', 'action' => 'add', $latest_assigned_course['PublishedCourse']['id']));
										echo ' | ';
										echo $this->Html->link(__('Take Attendance', true), array('controller' => 'attendances', 'action' => 'take_attendance', $latest_assigned_course['PublishedCourse']['id']));
										echo ' | ';
										echo $this->Html->link(__('View Attendance', true), array('controller' => 'attendances', 'action' => 'instructor_view_attendance', $latest_assigned_course['PublishedCourse']['id']));
										?>
										</td>
									</tr>
									<?php
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				
			
				//Department exam grade changes, makeup exams, supplementary exams
				if(isset($exam_grade_change_requests)) {
					?>
					<div class="box">
						<h2>Grade Change</h2>
						<div class="utils">
							<?php echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_department_grade_change')); ?>
						</div>
						<table class="small_padding">
							<?php
							if($exam_grade_change_requests == 0 && empty($makeup_exam_grades) 
							&& empty($rejected_makeup_exams) && empty($rejected_supplementary_exams)) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2">
								<p style="font-size:12px">There is no exam grade change requests.</p></td></tr>';
							}
							else {
								echo '<ul>';
								if($exam_grade_change_requests != 0)
									echo '<li>You have '.($exam_grade_change_requests).' grade change requests.</li>';
								if($makeup_exam_grades != 0)
									echo '<li>You have '.($makeup_exam_grades).' makeup exam approval requests.</li>';
								if($rejected_makeup_exams != 0)
									echo '<li class="rejected">You have '.($rejected_makeup_exams).' rejected makeup exam grade.</li>';
								if($rejected_supplementary_exams != 0)
									echo '<li class="rejected">You have '.($rejected_supplementary_exams).' rejected supplementary exam grade.</li>';
								echo '<ul>';
							}
							?>
						</table>
					</div>
				<?php
				}
				
				if (isset($profile_not_build) && !empty($profile_not_build)) {
				
				?>
				 <div class="box">
						<h2>Profile Not Built</h2>
						<div class="utils">
							<?php echo $this->Html->link(__('View All', true), array('controller' => 'students', 'action' => 'profile_not_build_list')); ?>
						</div>
						<table class="small_padding">
							<?php 
							if(count($profile_not_build) >0) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2">
								<p style="font-size:12px">
								There are '.$this->Html->link(__(count($profile_not_build), true), 
								array('controller' => 'students', 
								'action' => 'profile_not_build_list')).
								' students profile not build .</p></td></tr>';
							}
							?>
						</table>
					</div>
				<?php 
				
				}
				
				//Freshman exam grade changes, makeup exams, supplementary exams
				if(isset($fm_exam_grade_change_requests)) {
					?>
					<div class="box">
						<h2>Grade Change</h2>
						<div class="utils">
							<?php echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_freshman_grade_change')); ?>
						</div>
						<table class="small_padding">
							<?php
							if($fm_exam_grade_change_requests == 0 && empty($fm_makeup_exam_grades) && empty($fm_rejected_makeup_exams) && empty($fm_rejected_supplementary_exams)) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">There is no freshman exam grade change requests.</p></td></tr>';
							}
							else {
								echo '<ul>';
								if($fm_exam_grade_change_requests != 0)
									echo '<li>You have '.($fm_exam_grade_change_requests).' grade change requests.</li>';
								if($fm_makeup_exam_grades != 0)
									echo '<li>You have '.($fm_makeup_exam_grades).' makeup exam approval requests.</li>';
								if($fm_rejected_makeup_exams != 0)
									echo '<li class="rejected">You have '.($fm_rejected_makeup_exams).' rejected makeup exam grade.</li>';
								if($fm_rejected_supplementary_exams != 0)
									echo '<li class="rejected">You have '.($fm_rejected_supplementary_exams).' rejected supplementary exam grade.</li>';
								echo '<ul>';
							}
							?>
						</table>
					</div>
				<?php
				}
				
				//College exam grade changes approval requests
				if(isset($exam_grade_changes_for_college_approval)) {
					?>
					<div class="box">
						<h2>Grade Change</h2>
						<div class="utils">
							<?php echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_college_grade_change')); ?>
						</div>
						<table class="small_padding">
							<?php
							if($exam_grade_changes_for_college_approval == 0) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">There is no grade change requests to be approved.</p></td></tr>';
							}
							else {
								echo '<ul>';
								if($exam_grade_changes_for_college_approval != 0)
									echo '<li>You have '.($exam_grade_changes_for_college_approval).' grade change requests.</li>';
								echo '<ul>';
							}
							?>
						</table>
					</div>
				<?php
				}
				
				//Registrar exam grade changes approval requests
				if(isset($reg_exam_grade_change_requests)) {
					?>
					<div class="box">
						<h2>Grade Change</h2>
						<div class="utils">
							<?php echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_registrar_grade_change')); ?>
						</div>
						<table class="small_padding">
							<?php
							if($reg_exam_grade_change_requests == 0 && empty($reg_supplementary_exam_grades) && empty($fm_rejected_makeup_exams) && empty($fm_rejected_supplementary_exams)) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">There is no exam grade change confirmation requests.</p></td></tr>';
							}
							else {
							    
								echo '<ul>';
								if($reg_exam_grade_change_requests != 0)
									echo '<li>You have '.($reg_exam_grade_change_requests).' grade change requests.</li>';
								if($reg_makeup_exam_grades != 0)
									echo '<li>You have '.($reg_makeup_exam_grades).' makeup exam approval requests.</li>';
								if($reg_supplementary_exam_grades != 0)
									echo '<li>You have '.($reg_supplementary_exam_grades).' supplementary exam approval requests.</li>';
								echo '<ul>';
							}
							?>
						</table>
					</div>
				<?php
				}
				
				
				//Department grade approval
				if(isset($courses_for_dpt_approvals) && !empty($courses_for_dpt_approvals)) {
				?>
					<div class="box">
						<h2>Grade Approval</h2>
						<table class="small_padding">
							<?php
							if(empty($courses_for_dpt_approvals)) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">
								There is no course that needs grade approval.</p></td></tr>';
							}
							else {
							   	echo '<tr><td style="border:0px solid #ffffff">
							   	<p style="font-size:16px;font-weight:bold">List of courses grade submitted
							   	by instructor and needs department approval
							   	.</p></td></tr>';
					
								$row_count = 1;
								foreach($courses_for_dpt_approvals as $key => $course_for_grade_confirmation) {
									if($row_count <= 100) {
									   
									?>
									<tr>
										<td class="action_content">
										<?php
										    
										    echo $this->Html->link(
										    __($course_for_grade_confirmation['Course']['course_title'].' ('
										    .$course_for_grade_confirmation['Course']['course_code'].')', true), 
										    array('controller' => 'exam_grades', 
										    'action' => 'approve_non_freshman_grade_submission', $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));
										    echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
										    echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
										    echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year'];
										    
										   
										   										
									?></td>
									</tr>
									<?php
									}
									else {
										if(count($courses_for_registrar_approvals) > 100) {
											echo '<tr><td style="font-size:12px">And other '.
											(count($courses_for_registrar_approval) - 100).
											' courses. '.$this->Html->link(__('View All', true), 
											array('controller' => 'exam_grades', 
											'action' => 'approve_non_freshman_grade_submission')).'</td></tr>';
										}
										break;
									}
								$row_count++;
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
				
				<?php 
				
					//College grade approval for department unassigned students
				if(isset($courses_for_freshman_approvals) && !empty($courses_for_freshman_approvals)) {
				?>
					<div class="box">
						<h2>Grade Approval</h2>
						<table class="small_padding">
							<?php
							if(empty($courses_for_freshman_approvals)) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">
								There is no freshman course that needs grade approval.</p></td></tr>';
							}
							else {
							   	echo '<tr><td style="border:0px solid #ffffff">
							   	<p style="font-size:16px;font-weight:bold">List of courses grade submitted
							   	by instructor for department unassigned students and needs your approval
							   	.</p></td></tr>';
					
								$row_count = 1;
								foreach($courses_for_freshman_approvals as $key => $course_for_grade_confirmation) {
									if($row_count <= 100) {
									   
									?>
									<tr>
										<td class="action_content">
										<?php
										    
										    echo $this->Html->link(
										    __($course_for_grade_confirmation['Course']['course_title'].' ('
										    .$course_for_grade_confirmation['Course']['course_code'].')', true), 
										    array('controller' => 'exam_grades', 
										    'action' => 'approve_freshman_grade_submission', 
										    $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));
										    echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
										    echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
										    echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year'];
										    
										   
										   										
									?></td>
									</tr>
									<?php
									}
									else {
										if(count($courses_for_registrar_approvals) > 100) {
											echo '<tr><td style="font-size:12px">And other '.
											(count($courses_for_registrar_approval) - 100).
											' courses. '.$this->Html->link(__('View All', true), 
											array('controller' => 'exam_grades', 
											'action' => 'approve_freshman_grade_submission')).'</td></tr>';
										}
										break;
									}
								$row_count++;
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
				
				
				
					
				<?php 
				
					//dispatched courses 
				if(isset($dispatched_course_list) && !empty($dispatched_course_list)) {
				?>
					<div class="box">
						<h2>Dispatched Courses For Instructor Assignment</h2>
						<table class="small_padding">
							<?php
							if(empty($dispatched_course_list)) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">
								There is no other department who dispatched courses to assign
								 instructor from your department.</p></td></tr>';
							}
							else {
							   	echo '<tr><td style="border:0px solid #ffffff">
							   	<p style="font-size:16px;font-weight:bold">List of courses dispatched
							   	by other department who needs you to assign instructor 
							   	from your department
							   	.</p></td></tr>';
					
								$row_count = 1;
								foreach($dispatched_course_list as $dk => $dc) {
									if($row_count <= 100) {
									    
									?>
									<tr>
										<td class="action_content">
										<?php
										      
										    echo $this->Html->link(
										    __($dc['Course']['course_title'].' ('
										    .$dc['Course']['course_code'].')', true), 
										    array('controller' => 'course_instructor_assignments', 
										    'action' => 'assign_course_instructor', 
										    $dc['PublishedCourse']['id']),
										     array('class' => 'action_link'));
										  
										    echo '<br /><strong>Section:</strong> '.
										    $dc['Section']['name'].
										    ' ('.((!empty($dc['Department']['name']) ? 
										    $dc['Department']['name'] : 'Freshman Program').' / '.
										    $dc['Program']['name'].' / '.
										    $dc['ProgramType']['name']).')';
										    echo '<br/> <strong>Semester:</strong>'.
										     $dc['PublishedCourse']['semester'];
										    echo '<br/> <strong>Academic Year:</strong>'. 
										    $dc['PublishedCourse']['academic_year'];  
										   
										   										
									?></td>
									</tr>
									<?php
									}
									else {
										if(count($courses_for_registrar_approvals) > 100) {
											echo '<tr><td style="font-size:12px">And other '.
											(count($courses_for_registrar_approval) - 100).
											' courses. '.$this->Html->link(__('View All', true), 
											array('controller' => 'exam_grades', 
											'action' => 'approve_freshman_grade_submission')).'</td></tr>';
										}
										break;
									}
								$row_count++;
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
				
						
				<?php 
				
					//dispatched courses 
				if(isset($dispatched_course_not_assigned) && !empty($dispatched_course_not_assigned)) {
				?>
					<div class="box">
						<h2>Dispatched courses instructor assignment is not done!</h2>
						<table class="small_padding">
							<?php
							if(empty($dispatched_course_not_assigned)) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">
								There is no other department who dispatched courses to assign
								 instructor from your department.</p></td></tr>';
							}
							else {
							   	echo '<tr><td style="border:0px solid #ffffff">
							   	<p style="font-size:16px;font-weight:bold">Courses published by your department 
							   	and needs other department instructor assignment
							   	.</p></td></tr>';
					
								$row_count = 1;
								foreach($dispatched_course_not_assigned as $dk => $dc) {
									if($row_count <= 100) {
									    
									?>
									<tr>
										<td class="action_content">
										<?php
										;
										   echo '<br/> <strong>Dispatched To Department: </strong>'.
										    $dc['GivenByDepartment']['name'].'<br/>';
										     
										    echo '<strong>Course: </strong>'.
										    $dc['Course']['course_title'].' ( '
										    .$dc['Course']['course_code'].' ) <br/>';
										   
										  
										    echo '<strong>Section:</strong> '.
										    $dc['Section']['name'].
										    ' ('.((!empty($dc['Department']['name']) ? 
										    $dc['Department']['name'] : 'Freshman Program').' / '.
										    $dc['Program']['name'].' / '.
										    $dc['ProgramType']['name']).')';
										    echo '<br/> <strong>Semester:</strong>'.
										     $dc['PublishedCourse']['semester'];
										    echo '<br/> <strong>Academic Year:</strong>'. 
										    $dc['PublishedCourse']['academic_year'];  
										   
										   										
									?></td>
									</tr>
									<?php
									}
									
								$row_count++;
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
				
			<?php 
					
				//Registrar grade confirmation
				if(isset($courses_for_registrar_approval)) {
				?>
					<div class="box">
						<h2>Grade Confirmation</h2>
						<table class="small_padding">
							<?php
							if(empty($courses_for_registrar_approval)) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no course that needs grade confirmation.</p></td></tr>';
							}
							else {
							   	echo '<tr><td style="border:0px solid #ffffff">
							   	<p style="font-size:16px;font-weight:bold">List of courses grade submitted
							   	by instructor and approved by department
							   	and wait your confirmation
							   	.</p></td></tr>';
					
								$row_count = 1;
								foreach($courses_for_registrar_approval as $key => $course_for_grade_confirmation) {
									if($row_count <= 100) {
									   
									?>
									<tr>
										<td class="action_content">
										<?php
										    
										    echo $this->Html->link(__($course_for_grade_confirmation['Course']['course_title'].' ('.$course_for_grade_confirmation['Course']['course_code'].')', true), array('controller' => 'exam_grades', 'action' => 'confirm_grade_submission', $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));
										    echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
										    echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
										    echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year'];
										    
										   
										   										
									?></td>
									</tr>
									<?php
									}
									else {
										if(count($courses_for_registrar_approval) > 100) {
											echo '<tr><td style="font-size:12px">And other '.(count($courses_for_registrar_approval) - 100).' courses. '.$this->Html->link(__('View All', true), array('controller' => 'exam_grades', 'action' => 'confirm_grade_submission')).'</td></tr>';
										}
										break;
									}
								$row_count++;
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
				 <?php if ((isset($add_request) && !empty($add_request)) || 
				 (isset($forced_drops) && !empty($forced_drops)) || (isset($drop_request) 
				 && !empty($drop_request))) { ?>
				   <div class="box">
						<h2>Course Add/Drop</h2>
						<table class="small_padding">
							<?php
						 if ($role_id == ROLE_REGISTRAR) {
							if(empty($forced_drops['count'])) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no course that needs force drop.</p></td></tr>';
							} else {
							?>
									<tr>
										<td class="action_content">
										<?php
										if ($forced_drops['count']>0) {
									
										 			echo $this->Html->link(__('You have '.$forced_drops['count'].' students who are registered on hold base but failed to qualify.', true), array('controller' => 'courseDrops', 'action'=>'forced_drop'), array('class' => 'action_link'));
										}
										
										?>
									  </td>
									</tr>
							<?php 	
							  }
						  }			
						
						if(empty($add_request)) {
							    if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no add course request that needs approval.</p></td></tr>';                  
								} else {
								    echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no add course request that needs confirmation.</p></td></tr>';                  

								}
							} else {
							?>
									<tr>
										<td class="action_content">
										<?php
										if ($role_id == ROLE_REGISTRAR) {
										if ($add_request>0) {
									
										 			echo $this->Html->link(__('You have '.$add_request.' students whose add request is approved by department and waiting confirmation .', true), array('controller' => 'course_adds',  'action'=>'approve_adds'), array('class' => 'action_link'));
										 		
										}
										
										} else {
										  			echo $this->Html->link(__('You have '.$add_request.' students  add request  waiting approval.', true), array('controller' => 'course_adds',  'action'=>'approve_adds'), array('class' => 'action_link'));
										
										
										}
										
										?>
									  </td>
									</tr>
							<?php 	
							  }
							?>
						<?php 	
						if(empty($drop_request)) {
							    if ($role_id == ROLE_DEPARTMENT ) {
								echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no course drop request that needs approval.</p></td></tr>';                  
								} else {
								    echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no course drop request that needs confirmation.</p></td></tr>';                  

								}
							} else {
							?>
									<tr>
										<td class="action_content">
										<?php
										if ($role_id == ROLE_REGISTRAR) {
										if ($drop_request>0) {
									
										 			echo $this->Html->link(__('You have '.$drop_request.' students whose drop request is approved by department and waiting confirmation .', true), array('controller' => 'course_drops',  'action'=>'approve_drops'), array('class' => 'action_link'));
										 		
										}
										
										} else {
										  			echo $this->Html->link(__('You have '.$drop_request.' students  drop request  waiting for approval.', true), array('controller' => 'course_drops',  'action'=>'approve_drops'), array('class' => 'action_link'));
										
										
										}
										
										?>
									  </td>
									</tr>
							<?php 	
							  }
							?>
							
						</table>
				   </div>
				<?php } ?>
				
				
				</div>
				<div class="grid_5">
				<?php
				//BACKUP
				if(isset($latest_backups) && !empty($latest_backups)) {
				?>
					<div class="box">
						<h2>Backup</h2>
						<div class="utils">
						<?php echo $this->Html->link(__('View More', true), array('controller' => 'backups', 'action' => 'index')); ?>
						</div>
						<?php
						if(!empty($latest_backups)) {
						?>
							<table>
						<?php
							foreach($latest_backups as $backup) {
						?>
								<tr>
									<td style="width:65%"><?php echo $this->Format->humanize_date_short2($backup['Backup']['created']); ?></td>
									<td style="width:35%; text-align:center"><?php echo (!$backup['Backup']['file_exists'] ? 'Not Available' : $this->Html->link(__('Download', true), array('controller' => 'backups', 'action' => 'index', $backup['Backup']['id']))); ?></td>
								</tr>
						<?php
							}
						?>
							</table>
						<?php
						}
						else {
							echo '<p>There is no backup. Please make sure that you configured the system to generate database backup regularly.</p>';
						}
						?>
					</div>
				<?php
				}
				
					//Clearance/Withdraw Request
				if(isset($clearance_request)) {
					?>
					<div class="box">
						<h2>Clearance/Withdraw </h2>
						
						<table class="small_padding">
							<?php
							if($clearance_request == 0 ) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">There is no clearance/withdraw requests.</p></td></tr>';
							}
							else {
								
								if($clearance_request != 0) {
								      echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">'.$this->Html->link(__('You have '.$clearance_request.' clearance/withdraw request that needs your approval', true), array('controller' => 'clearances',  'action'=>'approve_clearance'), array('class' => 'action_link')).'</p></td></tr>';
								}
								 
							}
							?>
						</table>
					</div>
				<?php
				}
				
				//Course Exemption Request
				if(isset($exemption_request)) {
				  //  debug($exemption_request);
					?>
					<div class="box">
						<h2>Exemption </h2>
						
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
					</div>
				<?php
				}
				
				
				//Course Exemption Request
				if(isset($substitution_request)) {
					?>
					<div class="box">
						<h2>Substitution </h2>
						
						<table class="small_padding">
							<?php
							if($substitution_request == 0 ) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">There is no course substitution  requests.</p></td></tr>';
							}
							else {
								//http://smis.trunk/courseSubstitutionRequests/approve_substitution
								if($substitution_request != 0) {
								      echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="font-size:12px">'.$this->Html->link(__('You have '.$substitution_request.' course substitution  request that needs your approval', true), array('controller' => 'courseSubstitutionRequests',  'action'=>'approve_substitution'), array('class' => 'action_link')).'</p></td></tr>';
								}
								
							}
							?>
						</table>
					</div>
				<?php
				}
				
				?>
				
				
					<!-- 
					<div class="box">
						<h2>Statistics</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>News</td>
									<td>+ 120%</td>
								</tr>
								<tr>
									<td>Downloads</td>
									<td>+ 220%</td>
								</tr>
								<tr>
									<td>Users</td>
									<td>- 10%</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="box">
						<h2>Schedule</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table class="date">
							<caption><a href="#">Prev</a> November 2009 <a href="#">Next</a> </caption>
							<thead>
								<tr>
									<th>Mon</th>
									<th>Tue</th>
									<th>Wed</th>
									<th>Thu</th>
									<th>Fri</th>
									<th>Sat</th>
									<th>Sun</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><a href="#">1</a></td>
								</tr>
								<tr>
									<td><a href="#">2</a></td>
									<td><a href="#">3</a></td>
									<td><a href="#">4</a></td>
									<td><a href="#">5</a></td>
									<td><a href="#">6</a></td>
									<td><a href="#">7</a></td>
									<td><a href="#">8</a></td>
								</tr>
								<tr>
									<td><a href="#">9</a></td>
									<td><a href="#">10</a></td>
									<td><a href="#" class="active">11</a></td>
									<td><a href="#">12</a></td>
									<td><a href="#">13</a></td>
									<td><a href="#">14</a></td>
									<td><a href="#">15</a></td>
								</tr>
								<tr>
									<td><a href="#">16</a></td>
									<td><a href="#">17</a></td>
									<td><a href="#">18</a></td>
									<td><a href="#">19</a></td>
									<td><a href="#">20</a></td>
									<td><a href="#">21</a></td>
									<td><a href="#">22</a></td>
								</tr>
								<tr>
									<td><a href="#">23</a></td>
									<td><a href="#">24</a></td>
									<td><a href="#">25</a></td>
									<td><a href="#">26</a></td>
									<td><a href="#">27</a></td>
									<td><a href="#">28</a></td>
									<td><a href="#">29</a></td>
								</tr>
								<tr>
									<td><a href="#">30</a></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					-->
				<!-- Schedule for Instructor -->	
									<?php
									
				if(isset($instructor_course_schedules)) {
				?>
					<div class="box">
						<h2>Course Schedules</h2>
						<table class="small_padding">
							<?php
							if(empty($instructor_course_schedules)) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="padding-bottom:17px">Currently there is no released course schedule for you but you can view general course schedule from Schedule tab or '.$this->Html->link(__('here',true), array('controller' => 'course_schedules', 'action' => 'index')).' .</p></td></tr>';
							}
							else {
								foreach($instructor_course_schedules as $icsk => $icsv) {
									if(!empty($icsv)) {
									?>
									<tr>
										<td><?php
										echo '<strong>Course:</strong> '.$icsv[0]['PublishedCourse']['Course']['course_title'].' ('.$icsv[0]['PublishedCourse']['Course']['course_code'].')<br /><strong>Section:</strong> '.$icsv[0]['Section']['name'].' ('.(isset($icsv[0]['PublishedCourse']['Department']['name']) ? $icsv[0]['PublishedCourse']['Department']['name'].' Department' : $icsv[0]['PublishedCourse']['College']['name'].' Freshman Program').')<br /><strong>Schedule:</strong><br />';
										$count = 1;
										foreach($icsv as $schedule_key => $schedule_value) {
											$week_day = null;
											switch ($schedule_value['ClassPeriod'][0]['week_day']){
												case 1: $week_day = "Sunday";
														break;
												case 2: $week_day = "Monday";
														break;
												case 3: $week_day = "Tuesday";
														break;
												case 4: $week_day = "Wednesday";
														break;
												case 5: $week_day = "Thursday";
														break;
												case 6: $week_day = "Friday";
														break;
												case 7: $week_day = "Saturday";
														break;
											}
											$period_count = count($schedule_value['ClassPeriod']);
											$ending_period = $schedule_value['ClassPeriod'][($period_count - 1)]['PeriodSetting']['hour'];
											$ending_hour = substr($ending_period,0,2);
											$other = substr($ending_period,2);
											$ending_period_plus_one_hour = ($ending_hour + 01).$other;
											$class_room = null;
											if(!empty($schedule_value['ClassRoom']['room_code'])){
												$class_room = $schedule_value['ClassRoom']['room_code'].' - '.$schedule_value['ClassRoom']['ClassRoomBlock']['Campus']['name'];
											} else {
												$class_room = "TBA";
											}
											$display_str = $week_day .' '.$this->Format->humanize_hour($schedule_value['ClassPeriod'][0]['PeriodSetting']['hour']).' - '.$this->Format->humanize_hour($ending_period_plus_one_hour)." (". $schedule_value['CourseSchedule']['type'].', '.$class_room.', '.$schedule_value['CourseSplitSection']['section_name'].") ";
											
											echo '<strong>'.$count++.'.</strong> '.$display_str .'<br />';
										}
										?>
										</td>
											</tr>
										<?php
									}
								}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
				<!-- Schedule for Student -->	
									<?php
				if(isset($section_course_schedule)) {
				?>
					<div class="box">
						<h2>Course Schedules</h2>
						<table class="small_padding">
							<?php
							if(empty($section_course_schedule)) {
								echo '<tr><td style="border:0px solid #ffffff" colspan="2"><p style="padding-bottom:17px">Currently there is no released course schedule for you but you can view general course schedule from Schedule tab or '.$this->Html->link(__('here',true), array('controller' => 'dashboard', 'action' => 'index')).' .</p></td></tr>';
							}
							else {
							
		foreach($section_course_schedule as $scsk=>$scsv){
		echo '<table class="condence" style="border: #CCC double 3px ">';
		echo '<tr><td class="smallheading" colspan="2">'.$scsv[0]['Section']['name'].'</td></tr>';
		echo '<tr><td><table style="border: #CCC solid 1px ">';
		$starting =$starting_and_ending_hour['starting'];
		$starting_hour = substr($starting,0,2);
		$other = substr($starting,2);
		$ending = $starting_and_ending_hour['ending'];
		$ending_hour = substr($ending,0,2);
		echo '<tr><td style="border-right: #CCC solid 1px; width:40PX; background-color:#C6A6C6"> Week Day/Periods</td>';
		$time_deference=($ending_hour - $starting_hour);
		$i=0;
		while($i<=$time_deference){
			echo '<td style="border-right: #CCC solid 1px; width:40PX; background-color:#EBF3FB" >'.$this->Format->humanize_hour(($starting_hour+$i).$other).'</td>';
			$i++;
		}
		echo '</tr>';
		for($week_day=1;$week_day<=7;$week_day++){
			$week_day_class_periods = array();
			foreach($scsv as $csk=>$csv){
				if($csv['ClassPeriod'][0]['week_day'] == $week_day){
					foreach($csv['ClassPeriod'] as $cpk=>$cpv){
						$week_day_class_periods[$csk][] = $cpv['PeriodSetting']['hour'];
					}
				}
			}
			//debug($week_day_class_periods);
			if(empty($week_day_class_periods)){
				echo '<tr>';
				switch ($week_day){
					case 1: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Sunday</td>';
							break;
					case 2: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Monday</td>';
							break;
					case 3: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Tuesday</td>';
							break;
					case 4: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Wednesday</td>';
							break;
					case 5: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Thursday</td>';
							break;
					case 6: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Friday</td>';
							break;
					case 7: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Saturday</td>';
							break;
				}
				for($i=$starting_hour;$i<=$ending_hour;$i++){
					echo '<td style="border-right: #CCC solid 1px; background-color:#899F47"></td>';
				}
				echo '</tr>';
			} else {
				echo '<tr>';
				switch ($week_day){
					case 1: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Sunday</td>';
							break;
					case 2: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Monday</td>';
							break;
					case 3: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Tuesday</td>';
							break;
					case 4: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Wednesday</td>';
							break;
					case 5: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Thursday</td>';
							break;
					case 6: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Friday</td>';
							break;
					case 7: echo '<td style="border-right: #CCC solid 1px;background-color:#EBF3FB"> Saturday</td>';
							break;
				}
				$j=0;
				while($j<=$time_deference){
					$scheduled = false;
					foreach($week_day_class_periods as $course_schedule_key=>$wdcpv){
						foreach($wdcpv as $wdcp_hour){

							if(date("H:i:s",$wdcp_hour) == date("H:i:s",(($starting_hour + $j).$other))){
								$count_td = count($wdcpv);
								$class_room = null;
								if(!empty($scsv[$course_schedule_key]['ClassRoom']['room_code'])){
									$class_room = $scsv[$course_schedule_key]['ClassRoom']['room_code'].' - '.$scsv[$course_schedule_key]['ClassRoom']['ClassRoomBlock']['Campus']['name'];
								} else {
									$class_room = "TBA";
								}
								/*echo '<td style="border-right: #CCC solid 1px; text-align:center;" colspan="'.$count_td.'">'.$this->Js->link($scsv[$course_schedule_key]['PublishedCourse']['Course']['course_code'].' ('.$scsv[$course_schedule_key]['CourseSchedule']['type'].', '.$class_room.', '.$scsv[$course_schedule_key]['CourseSplitSection']['section_name'].')',array('controller'=>'dashboard','action'=>'get_modal',$scsv[$course_schedule_key]['PublishedCourse']['id']),array('class'=>'jsview','update'=>'#dialog-modal')).'</td>'; */
								echo '<td style="border-right: #CCC solid 1px; text-align:center;" colspan="'.$count_td.'">'.$scsv[$course_schedule_key]['PublishedCourse']['Course']['course_code'].' ('.$scsv[$course_schedule_key]['CourseSchedule']['type'].', '.$class_room.', '.$scsv[$course_schedule_key]['CourseSplitSection']['section_name'].')</td>';
								$j = $j + $count_td;
								$scheduled = true;
								break 2;
							} 
						}
					}
					if($scheduled == false){
						echo '<td style="border-right: #CCC solid 1px; background-color:#899F47"></td>';
						$j++;
					}
				}
				echo '</tr>';
			}
		}
		echo '</table></td></tr>';
		//echo '<tr><td> <div class="info-box info-message"><font color=RED><u>Note:</u></font><br/> -You can find course type, assigned class room and split section name if the orginal section splited for that course, respectively in the bracket.<br/> -You can view course details by clicking on each course code.</div></td><tr>';
		echo '</table>';
		
	}
							}
							?>
						</table>
					</div>
				<?php
				}
				?>
			</div>
</div>
<!-- 
<div id="content" class="container_12 clearfix">
				<div class="grid_5">
					<div class="box">
						<h2>Mathew</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<p><strong>Last Signed In : </strong> Wed 11 Nov, 7:31<br /><strong>IP Address : </strong> 192.168.1.101</p>
					</div>
					<div class="box">
						<h2>Files</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>Newton 2</td>
									<td>8/10</td>
								</tr>
								<tr>
									<td>Wicked Twister</td>
									<td>9/10</td>
								</tr>
								<tr>
									<td>Forester</td>
									<td>9.12/10</td>
								</tr>
								<tr>
									<td>Sabertooth</td>
									<td>8.9/10</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box">
						<h2>Messages</h2>
						<div class="utils">
							<a href="#">Inbox</a>
						</div>
						<p class="center">Have have <a href="#">10</a> unread messages.</p>
					</div>
					<div class="box">
						<h2>CMS Updates</h2>
						<div class="utils">
							<a href="#">Check</a>
						</div>
						<p class="center">You are running the latest version.</p>
					</div>
				</div>
				    		
                    <?php 
                    if (isset($usersActivities) && !empty($usersActivities)) {
                    ?>
                    <div class='grid_6'>
				    <div class='box'>
				    <h2>Recent Log</h2>
			        
                    <?php 
                    foreach ($usersActivities as $k=>$v) {
                     
                        $extract=$grade_type=explode('~',$k);
                      
                       
                        
                       
                        echo "<table><tr>";
                       /* echo '<td> Full Name:'.$extract[0].' </td>';
                        echo '<td> Role '.$extract[1].'</td>';
                        echo '<td> Username '.$extract[1].'</td>';  
                        echo '</tr>';
                        
                        echo "<tr><td> The above user has performed the following activities in the system</td>";
                        echo "</tr>";
                        */
                        echo "<tr><td>";
                            echo "<table>";
                            echo "<tr><th>Date</th><th>Model</th><th>User</th><th>IP</th><th>Change</th></tr>";
                            foreach ($v as $k=>$d) {
                                echo "<tr><td>".$this->Format->humanize_date($d['Log']['created'])."</td><td>".$d['Log']['model']."</td><td>".$extract[0]."</td><td>".$d['Log']['ip']."</td><td><table>";
                                foreach(explode(',',$d['Log']['change']) as $change ){
                                     preg_match('/(\w+?) \((\w*?)\) => \((\w+?)\)/', $change, $matches); 
                                    if(isset($matches)&&!empty($matches)){
                                    list($search, $field, $from, $to) = $matches;
                                    echo "<tr><td>"."change \"$field\" from \"$from\" to \"$to\"\n".'</td></tr>';
                                    }
                                }
                                echo "</table></td></tr>";
                            }
                            echo "</table>";
                        echo "</td></tr>";
                        echo "</table>";    
                    }
                    ?>
                    </div>
				</div>    
                    <?php 
                   }
                  ?>
				
				<div class="grid_6">
					<div class="box">
						<h2>Grade Submission Waiting Approval</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>1 Post</td>
									<td>2 Comments</td>
								</tr>
								<tr>
									<td>1 Page</td>
									<td>2 Approved</td>
								</tr>
								<tr>
									<td>1 Categories</td>
									<td>0 Pending</td>
								</tr>
								<tr>
									<td>0 Tags</td>
									<td>0 Spam</td>
								</tr>
							</tbody>
						</table>
					</div>
		
				</div>
				<div class="grid_5">
					<div class="box">
						<h2>Statistics</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>News</td>
									<td>+ 120%</td>
								</tr>
								<tr>
									<td>Downloads</td>
									<td>+ 220%</td>
								</tr>
								<tr>
									<td>Users</td>
									<td>- 10%</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box">
						<h2>Schedule</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table class="date">
							<caption><a href="#">Prev</a> November 2009 <a href="#">Next</a> </caption>
							<thead>
								<tr>
									<th>Mon</th>
									<th>Tue</th>
									<th>Wed</th>
									<th>Thu</th>
									<th>Fri</th>
									<th>Sat</th>
									<th>Sun</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><a href="#">1</a></td>
								</tr>
								<tr>
									<td><a href="#">2</a></td>
									<td><a href="#">3</a></td>
									<td><a href="#">4</a></td>
									<td><a href="#">5</a></td>
									<td><a href="#">6</a></td>
									<td><a href="#">7</a></td>
									<td><a href="#">8</a></td>
								</tr>
								<tr>
									<td><a href="#">9</a></td>
									<td><a href="#">10</a></td>
									<td><a href="#" class="active">11</a></td>
									<td><a href="#">12</a></td>
									<td><a href="#">13</a></td>
									<td><a href="#">14</a></td>
									<td><a href="#">15</a></td>
								</tr>
								<tr>
									<td><a href="#">16</a></td>
									<td><a href="#">17</a></td>
									<td><a href="#">18</a></td>
									<td><a href="#">19</a></td>
									<td><a href="#">20</a></td>
									<td><a href="#">21</a></td>
									<td><a href="#">22</a></td>
								</tr>
								<tr>
									<td><a href="#">23</a></td>
									<td><a href="#">24</a></td>
									<td><a href="#">25</a></td>
									<td><a href="#">26</a></td>
									<td><a href="#">27</a></td>
									<td><a href="#">28</a></td>
									<td><a href="#">29</a></td>
								</tr>
								<tr>
									<td><a href="#">30</a></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
			</div>
</div>

-->
