<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-check" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR ? __('Confirm Course Exemption') : __('Approve Course Exemption')); ?></span>
		</div>
	</div>
    <div class="box-body">
    	<div class="row">
	  		<div class="large-12 columns">
			 	<div style="margin-top: -30px;"><hr></div>
				<div class="courseExemptions form">

					<?= $this->Form->create('CourseExemption'); ?>

					<?php 
					if (isset($student_section_exam_status) && !empty($student_section_exam_status)) { ?>
						<table cellpadding="0" cellspacing="0" class="table">
							<tr>
								<td style="background-color: white;">
									<table cellpadding="0" cellspacing="0" class="table">
										<tr>
											<td class="font">Name:&nbsp;&nbsp;&nbsp; <?=  $student_section_exam_status['StudentBasicInfo']['full_name']; ?></td>
										</tr>
										<tr>
											<td class="font">Student Number:&nbsp;&nbsp;&nbsp; <?= $student_section_exam_status['StudentBasicInfo']['studentnumber']; ?></td>
										</tr>
										<tr>
											<td class="font">Year Level:&nbsp;&nbsp;&nbsp; <?= (isset($student_section_exam_status['Section']['YearLevel']['name']) ? $student_section_exam_status['Section']['YearLevel']['name'] : 'N/A'); ?> </td>
										</tr>
										<tr>
											<td class="font">Section:&nbsp;&nbsp;&nbsp; <?= (isset($student_section_exam_status['Section']['name']) ? $student_section_exam_status['Section']['name'] : 'N/A'); ?></td>
										</tr>
									</table>
								</td>
								<td style="background-color: white;">
									<?php 
									if (!empty($student_section_exam_status['StudentExamStatus'])) { ?>
										<table cellpadding="0" cellspacing="0" class="table">
											<tr><td class="font">Semester:&nbsp;&nbsp;&nbsp;<?= $student_section_exam_status['StudentExamStatus']['semester']?></td></tr>
											<tr><td class="font">Academic Year:&nbsp;&nbsp;&nbsp;<?= $student_section_exam_status['StudentExamStatus']['academic_year'];?></td></tr>
											<tr><td class="font">SGPA:&nbsp;&nbsp;&nbsp;<?= $student_section_exam_status['StudentExamStatus']['sgpa'];?></td></tr>
											<?php 
											if (!empty($student_section_exam_status['StudentExamStatus']['sgpa'])) { ?>
												<tr><td class="font">CGPA:&nbsp;&nbsp;&nbsp;<?= $student_section_exam_status['StudentExamStatus']['cgpa'];?></td></tr>
												<?php
											}
											if (!empty($student_section_exam_status['StudentExamStatus']['AcademicStatus'])) {
												echo '<tr><td class="font">Academic Status:&nbsp;&nbsp;&nbsp;'.$student_section_exam_status['StudentExamStatus']['AcademicStatus']['name'].'</td></tr>';
											} ?>
										</table>
										<?php
									} ?>
								</td>
							</tr>
						</table>
						<?php 
					} ?> 
					
					
					<div class="row">
						<br>
						<div class="large-8 columns">
							<br>
							<div style="overflow-x:auto;">
								<table cellpadding="0" cellspacing="0" class="table">
									<?php 
									if (!empty($previous_exemption_accepted)) { ?>
										<tr>
											<td colspan=3> <span class="fs14 text-gray"><strong>Previous course exemption request by this student and accepted by the department and confirmed by registrar.</strong></span></td>
										</tr>
										<?php
										$count = 0;
										foreach ($previous_exemption_accepted as $psk=>$pvv) { ?>
											<tr>
												<td style="background-color: white;">
													<table cellpadding="0" cellspacing="0" class="table">
														<thead>
															<tr>
																<th class="vcenter">Course Title</th>
																<th class="center">Code</th>
																<th class="center">Credit</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="vcenter"><?= $pvv['Course']['course_title']; ?></td>
																<td class="center"><?= $pvv['Course']['course_code']; ?></td>
																<td class="center"><?= $pvv['Course']['course_code']; ?></td>
															</tr>
														</tbody>
													</table>
												</td>
												<td class="center" style="background-color: white;">Exempted by => </td>
												<td style="background-color: white;">
													<table cellpadding="0" cellspacing="0" class="table">
														<thead>
															<tr>
																<th class="vcenter">Course Title</th>
																<th class="center">Code</th>
																<th class="center">Credit</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td class="vcenter"><?= $pvv['CourseExemption']['taken_course_title']; ?></td>
																<td class="center"><?= $pvv['CourseExemption']['taken_course_code']; ?></td>
																<td class="center"><?= $pvv['CourseExemption']['course_taken_credit']; ?></td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<?php
										}
									} ?>
								</table>
							</div>
						</div>

						<div class="large-4 columns">
							<br>
							<div style="overflow-x:auto;">
								<table cellpadding="0" cellspacing="0" class="table">
									<tr>
										<td style="background-color: white;">
											<table cellpadding="0" cellspacing="0" class="table">
												<thead>
													<tr>
														<td>	
															<?php
															if ($role_id == ROLE_DEPARTMENT) { ?> 
																<?= __('Course Exemption Request Waiting Decision'); ?>
																<?php 
															} else if ($role_id == ROLE_REGISTRAR) { ?>
																<?= __('Course Exemption Approved by Department waiting registrar confirmation.');  ?>
																<?php 
															} ?>
														</td>
													</tr>
												</thead>
												<?php
												echo $this->Form->hidden('id');
												echo '<tr><td>Request Date : <strong>'.$this->Format->humanize_date($this->request->data['CourseExemption']['request_date']).'</strong></td></tr>';
												echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
												//echo '<tr><td>'.$this->Form->input('course_id',array('label'=>'Course Requested Exemption')).'</td></tr>';
												echo '<tr><td colspan=2><strong>Course to be exempted </strong></td></tr>';
												echo '<tr><td>Course Title: <strong>'.$this->request->data['Course']['course_title'].'</strong></td></tr>';
												echo '<tr><td>Course Code: <strong>'.$this->request->data['Course']['course_code'].'</strong></td></tr>';
												echo '<tr><td>Course Credit: <strong>'.$this->request->data['Course']['credit'].'</strong></td></tr>';
												echo '<tr><td colspan=2><strong>To be Exempted By </strong></td></tr>';
												echo '<tr><td>Course Title: <strong>'.$this->request->data['CourseExemption']['taken_course_title'].'</strong></td></tr>';
												echo '<tr><td>Course Code: <strong>'.$this->request->data['CourseExemption']['taken_course_code'].'</strong></td></tr>';
												echo '<tr><td> Course Credit: <strong>'.$this->request->data['CourseExemption']['course_taken_credit'].'</strong></td></tr>';
												
												if (isset($this->request->data['Attachment']) && count($this->request->data['Attachment'])>0) { 
													echo '<tr><td>';
													echo 'PDF file uploaded on: '.$this->Format->humanize_date($this->request->data['Attachment'][0]['created']). '<br/> '; 
													echo "<a href=".$this->Media->url($this->request->data['Attachment'][0]['dirname'].DS.$this->request->data['Attachment'][0]['basename'],true)." target=_blank'>View Attachment</a>";
													echo '</td></tr>';
												}
													
												// echo $this->Media->embedAsObject($courseExemption['Attachment'][0]['dirname'].DS.$courseExemption['Attachment'][0]['basename'],array('width'=>860,'height'=>'500'));
											
												$options = array('1' => 'Accept', '0' => 'Reject');
												$attributes = array('legend' => false, 'separator' => "<br/>");
												if ($role_id == ROLE_DEPARTMENT) {
													echo '<tr><td style="padding-left:10%;">Accept/Reject Request <br/>'.$this->Form->radio('department_accept_reject',$options,$attributes).'</td></tr>';
													echo '<tr><td>'.$this->Form->input('department_reason',array('label'=>'Reason')).'</td></tr>';
												} else if ($role_id == ROLE_REGISTRAR) {
													echo '<tr><td style="padding-left:10%;"> Confirm/Deny Exemption <br/>'.$this->Form->radio('registrar_confirm_deny',$options,$attributes).'</td></tr>';
													echo '<tr><td>Reason</td></tr>';
													echo '<tr><td>'.$this->Form->input('registrar_reason',array('label'=>false)).'</td></tr>';
												} ?>
											</table>
										</td>
									</tr>
								</table>
							</div>
							<hr>
							<?= $this->Form->end(array('label'=>__('Submit'), 'class'=>'tiny radius button bg-blue'));?>
						</div>
					</div>
				</div>
	  		</div>
		</div>
    </div>
</div>
