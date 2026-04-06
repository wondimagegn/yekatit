<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-info-outline"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Course details: ' . (isset($course['Course']['course_title']) ? $course['Course']['course_title'] : '') . (isset($course['Course']['course_code']) ? '  (' .$course['Course']['course_code'] . ')': '') ; ?></span>
		</div>
	</div>
	<div class="box-body">

		<div class="row">
			<div class="large-12 columns">
				<div style="margin-top: -30px;"><hr></div>
			</div>
		</div>

		<div class="row">
			<?php 
			if (!empty($course['Course'])) {

				$creditType = 'Credit';

				if (!empty($course['Curriculum']['type_credit']) && count(explode('ECTS', $course['Curriculum']['type_credit'])) >= 2) {
					$creditType = 'ECTS';
				} else if (!empty($course['Curriculum']['type_credit'])) {
					$creditType = trim($course['Curriculum']['type_credit']);
				} ?>
				
				<div class="large-6 columns">
					<table cellspacing="0" cellpading="0" class="table-borderless fs13">
						<tbody>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Course Title:</span>  <?= $course['Course']['course_title']; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Course Code:</span>  <?= $course['Course']['course_code']; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;"><?= $creditType; ?>:</span>  <?= $course['Course']['credit']; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">L T L:</span>  <?= $course['Course']['course_detail_hours']; ?></td>
							</tr>
							<tr>
								<td>
									<span class="text-gray" style="font-weight: bold; padding-left: 50px;">Major Course:</span>  <?= $course['Course']['major'] == 1 ? 'Yes' : 'No'; ?> 
									<?php
									if ($course['Course']['thesis'] == 1 ) { ?>
										<br>
										<span class="text-gray" style="font-weight: bold; padding-left: 50px;">Thesis/Dissertation/Project:</span>  Yes 
										<?php
									}

									if ($course['Course']['exit_exam'] == 1 ) { ?>
										<br>
										<span class="text-gray" style="font-weight: bold; padding-left: 50px;">Exit Exam: </span>  Yes 
										<?php
									} 

									if ($course['Course']['elective'] == 1 ) { ?>
										<br>
										<span class="text-gray" style="font-weight: bold; padding-left: 50px;">Elective: </span>  Yes 
										<?php
									} ?>
								</td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Course Category:</span>  <?= $course['CourseCategory']['name']; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Year Level:</span>  <?= $course['YearLevel']['name']; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Course Curriculum:</span> <br><?= $this->Html->link($course['Curriculum']['name'], array('controller' => 'curriculums', 'action' => 'view', $course['Curriculum']['id'])); ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;"><?= (isset($course['Department']['type']) && !empty($course['Department']['type']) ? $course['Department']['type'] : 'Department'); ?>:</span>  <?= $this->Html->link($course['Department']['name'], array('controller' => 'departments', 'action' => 'view', $course['Department']['id'])); ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Lecture Attendance Requirement:</span>  <?= !empty($course['Course']['lecture_attendance_requirement']) ? $course['Course']['lecture_attendance_requirement'] :'N/A'; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Lab Attendance Requirement:</span>  <?= !empty($course['Course']['lab_attendance_requirement']) ?  $course['Course']['lab_attendance_requirement'] : 'N/A'; ?></td>
							</tr>
							<tr>
								<td><span class="text-gray" style="font-weight: bold;">Grade Type:</span>  <?= $this->Html->link($course['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $course['GradeType']['id'])); ?></td>
							</tr>
							
							<?php
							if ($this->Session->check('Auth.User') && $this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT ) { ?>
								<tr>
									<td><span class="text-gray" style="font-weight: bold;">Created:</span>  <?= $this->Time->format("M j, Y h:i:s A", $course['Course']['created'], NULL, NULL); ?></td>
								</tr>
								<tr>
									<td><span class="text-gray" style="font-weight: bold;">Last Updated:</span>  <?= $this->Time->format("M j, Y h:i:s A", $course['Course']['modified'], NULL, NULL); ?></td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>
				</div>

				<div class="large-6 columns">
					<table cellspacing="0" cellpading="0" class="table-borderless fs13">
						<tbody>
							<tr>
								<td>
									<span class="text-black" style="font-weight: bold;">Co(Pre)requisite Courses:</span>  
									<?php
									if (isset($course['Prerequisite']) && !empty($course['Prerequisite'])) {
										echo '<br><br>';
										echo '<ol>';
										foreach ($course['Prerequisite'] as $k => $v) { ?>
											<li><?= $v['PrerequisiteCourse']['course_title'] . ' (' . $v['PrerequisiteCourse']['course_code'] . ')  &nbsp;  &nbsp; ' . ($v['co_requisite'] == 1 ? '<span class="accepted">Co-requisite</span>' : '<span class="rejected">Prerequisite</span>'); ?></li>
											<?php
										}
										echo '</ol>';
									} else { ?>
										None
										<?php 
									} ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<?php
				if ($this->Session->check('Auth.User') && $this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT && $this->Session->read('Auth.User')['is_admin'] == 1 && isset($course['PublishedCourse']) && !empty($course['PublishedCourse'])) { ?>
					<div class="large-6 columns">
						<table cellspacing="0" cellpading="0" class="table-borderless fs13">
							<thead>
								<tr>
									<td class="text-gray">Course Published Stats:</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span class="text-gray" style="font-weight: bold;">Published:</span>  <?= count($course['PublishedCourse']) ?> times until now</td>
								</tr>
								<?php
								if (count($course['PublishedCourse'])) { ?>
									<tr>
										<td><span class="text-gray" style="font-weight: bold;">Last published:</span>  <?= $this->Time->timeAgoInWords($course['PublishedCourse'][0]['created'], array('format' => 'M j, Y h:i:s A', 'end' => '1 year', 'accuracy' => array('month' => 'month'))); ?></td>
									</tr>
									<tr>
										<td><span class="text-gray" style="font-weight: bold;">Last Section:</span>  <?= $course['PublishedCourse'][0]['Section']['name'] . ' ('  . $course['PublishedCourse'][0]['academic_year'] . ', ' . (!empty($course['PublishedCourse'][0]['YearLevel']['name']) ? $course['PublishedCourse'][0]['YearLevel']['name'] . ' year' : 'Pre/1st') . ')'; ?></td>
									</tr>
									<tr>
										<td><span class="text-gray" style="font-weight: bold;">Academic Year:</span>  <?= ($course['PublishedCourse'][0]['semester'] == 'I' ? '1st' : ($course['PublishedCourse'][0]['semester'] == 'II' ? '2nd' : ($course['PublishedCourse'][0]['semester'] == 'III' ? '3rd': $course['PublishedCourse'][0]['semester'])))  . ' semester, ' . $course['PublishedCourse'][0]['academic_year']; ?></td>
									</tr>
									<tr>
										<td><span class="text-gray" style="font-weight: bold;">Given By <?= (isset($course['PublishedCourse'][0]['GivenByDepartment']['type']) && !empty($course['PublishedCourse'][0]['GivenByDepartment']['type']) ? $course['PublishedCourse'][0]['GivenByDepartment']['type'] : 'Department'); ?>:</span>  <?= $this->Html->link($course['PublishedCourse'][0]['GivenByDepartment']['name'], array('controller' => 'departments', 'action' => 'view', $course['PublishedCourse'][0]['GivenByDepartment']['id'])); ?></td>
									</tr>
									<tr>
										<td>
											<span class="text-gray" style="font-weight: bold;">Instructor:</span>  
											<?php
											if (isset($course['PublishedCourse'][0]['CourseInstructorAssignment'][0]) && !empty($course['PublishedCourse'][0]['CourseInstructorAssignment'][0])) {
												if (isset($course['PublishedCourse'][0]['CourseInstructorAssignment'][0]['Staff']['full_name']) && !empty($course['PublishedCourse'][0]['CourseInstructorAssignment'][0]['Staff']['full_name'])) { ?>
													<?= $course['PublishedCourse'][0]['CourseInstructorAssignment'][0]['Staff']['Title']['title'] . ' ' . $course['PublishedCourse'][0]['CourseInstructorAssignment'][0]['Staff']['full_name'] . ' ('. $course['PublishedCourse'][0]['CourseInstructorAssignment'][0]['Staff']['Position']['position'] . ')'; ?>
													<?php
												} else { ?>
													<span class="rejected" style="font-weight: bold;">Couln't load Instructor data</span>
													<?php
												}
											} else { ?>
												<span class="on-process" style="font-weight: bold;">Not assigned</span>
												<?php
											} ?>
										</td>
									</tr>
									<?php
									if (isset($graduatedStudentWithThisCourse) && $graduatedStudentWithThisCourse == 1) { ?>
										<tr>
											<td class="center"><span class="rejected">There are graduated students with this course.</span></td>
										</tr>
									<?php
									}
								} ?>
							</tbody>
						</table>
					</div>
					<?php
				} ?>

				<?php
				if (!empty($course['Course']['course_description'])) { ?>
					<div class="large-12 columns mt-2">
						<br>
						<div class="input">
							<label for="CourseCourseDescription">
								<span class="text-gray" style="font-weight: bold;">Course Description:</span>
							</label>
							<br>
							<?php //echo h(strip_tags(preg_replace('/[^\x00-\x7F]/', '', $course['Course']['course_description']))); ?> <!-- Strip everything outside ASCII -->
							<?php //echo h(strip_tags(preg_replace('/[^ -~]/', '', $course['Course']['course_description']))); ?> <!-- Allow only printable ASCII -->
							<?php //echo h(strip_tags($course['Course']['course_description'])); ?>
							<textarea name="data[Course][course_description]" rows="10" id="CourseCourseDescription"><?= h(strip_tags(preg_replace('/[^\x00-\x7F]/', '', $course['Course']['course_description']))); ?></textarea>
						</div>
					</div>
					<?php
				}

				if (!empty($course['Course']['course_objective'])) { ?>
					<div class="large-12 columns mt-2">
						<br>
						<div class="input">
							<label for="CourseCourseObjective">
								<span class="text-gray" style="font-weight: bold;">Course Objective:</span>
							</label>
							<br>
							<textarea name="data[Course][course_objective]" rows="10" id="CourseCourseObjective"><?= h(strip_tags(preg_replace('/[^\x00-\x7F]/', '', $course['Course']['course_objective']))); ?></textarea>
						</div>
					</div>
					<?php
				}  ?>

				<div class="large-12 columns">
					<?php
					if (!empty($course['Book'])) { ?>
						<div class="related">
							<hr>
							<h5><?= __('Related Books'); ?></h5>
							<br>
							<?php 
							if (!empty($course['Book'])) { ?>
								<div style="overflow-x:auto;">
									<table cellspacing="0" cellpading="0" class="table">
										<thead>
											<tr>
												<td style="width: 5%;" class="center"><?= __('#'); ?></td>
												<td class="vcenter"><?= __('Title'); ?></td>
												<td class="vcenter"><?= __('Author'); ?></td>
												<td class="center"><?= __('Year'); ?></td>
												<td class="center"><?= __('Edition'); ?></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$count = 1;
											foreach ($course['Book'] as $book) {  ?>
												<tr>
													<td class="center"><?= $count++; ?></td>
													<td class="vcenter"><?= $book['title']; ?></td>
													<td class="vcenter"><?= $book['author']; ?></td>
													<td class="center"><?= $book['year_of_publication']; ?></td>
													<td class="center"><?= $book['edition']; ?></td>
												</tr>
												<?php 
											} ?>
										</tbody>
									</table>
								</div>
								<br>
								<?php
							} ?>
						</div>
						<?php
					}

					if (!empty($course['Journal'])) { ?>
						<div class="related">
							<hr>
							<h5><?= __('Related Journals'); ?></h5>
							<br>
							<?php 
							if (!empty($course['Journal'])) { ?>
								<div style="overflow-x:auto;">
									<table cellpadding="0" cellspacing="0" class="table">
										<thead>
											<tr>
												<td style="width: 5%;" class="center"><?= __('#'); ?></td>
												<td class="vcenter"><?= __('Title'); ?></td>
												<td class="center"><?= __('Created'); ?></td>
												<td class="center"><?= __('Modified'); ?></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$count = 1;
											foreach ($course['Journal'] as $journal) { ?>
												<tr>
													<td class="center"><?= $count++; ?></td>
													<td class="vcenter"><?= $journal['title']; ?></td>
													<td class="center"><?= $this->Time->format("M j, Y h:i:s A", $journal['created'], NULL, NULL); ?></td>
													<td class="center"><?= $this->Time->format("M j, Y h:i:s A", $journal['modified'], NULL, NULL); ?></td>
												</tr>
												<?php 
											} ?>
										</tbody>
									</table>
								</div>
								<br>
								<?php
							} ?>
						</div>
						<?php
					}

					if (!empty($course['Weblink'])) { ?>
						<div class="related">
							<hr>
							<h5><?= __('Related Weblinks'); ?></h5>
							<br>
							<?php 
							if (!empty($course['Weblink'])) { ?>
								<div style="overflow-x:auto;">
									<table cellpadding="0" cellspacing="0" class="table">
										<thead>
											<tr>
												<td style="width: 5%;" class="center"><?= __('#'); ?></td>
												<td class="vcenter"><?= __('Title'); ?></td>
												<td class="vcenter"><?= __('Url Address'); ?></td>
												<td class="center"><?= __('Created'); ?></td>
												<td class="center"><?= __('Modified'); ?></td>
											</tr>
										</thead>
										<tbody>
											<?php
											$count = 1;
											foreach ($course['Weblink'] as $weblink) { ?>
												<tr>
													<td style="width: 5%;" class="center"><?= $count++; ?></td>
													<td class="vcenter"><?= $weblink['title']; ?></td>
													<td class="vcenter"><?= $weblink['url_address']; ?></td>
													<td class="center"><?= $this->Time->format("M j, Y h:i:s A", $weblink['created'], NULL, NULL); ?></td>
													<td class="center"><?= $this->Time->format("M j, Y h:i:s A", $weblink['modified'], NULL, NULL); ?></td>
												</tr>
												<?php 
											} ?>
										</tbody>
									</table>
								</div>
								<br>
								<?php 
							} ?>
						</div>
						<?php 
					} ?>
				</div>
				<?php
			} else { ?>
				<div class="large-12 columns">
					<div id="ErrorMessage" class="error-box error-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span> Course not found!!</div>
				</div>
				<?php
			} ?>
		</div>
	</div>
</div>