<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('List Course Exemptions'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<?= $this->Form->Create('CourseExemption', array('action' => 'search')); ?>
				<?php
				if ($this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT) { ?>
					<div style="margin-top: -30px;">
						<hr>
						<div onclick="toggleViewFullId('ListPublishedCourse')">
							<?php
							if (!empty($turn_off_search)) {
								echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
								<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt"> Display Filter</span>
								<?php
							} else {
								echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
								<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt"> Hide Filter</span>
								<?php
							} ?>
						</div>
						<div id="ListPublishedCourse" style="display:<?= (!empty($turn_off_search) ? 'none' : 'display'); ?>">
							<fieldset style="padding-bottom: 0px;padding-top: 15px;">
								<div class="row">
									<div class="large-3 columns">
										<?= $this->Form->input('Search.year_approved', array('label' => 'Approval Year: ', 'empty' => ' All Applicable Years', 'default' => (isset($this->request->data['Search']['year_approved']) ? $this->request->data['Search']['year_approved'] : ''),  'options' => $allowed_academic_years, 'style' => 'width:90%;')); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('Search.program_id', array('label' => 'Program: ', 'style' => 'width:90%;',  'id' => 'program_id_1', 'empty' => ' All Programs ', 'options' => $programs)); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('Search.program_type_id', array('label' => 'Program Type: ', 'style' => 'width:90%;', 'empty' => ' All Program Types ', 'options' => $programTypes)); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('Search.limit', array('id' => 'limit ', 'type' => 'number', 'min' => '1',  'max' => '1000', 'value' => (isset($this->data['Search']['limit']) ? $this->data['Search']['limit'] : $limit), 'step' => '1', 'label' => 'Limit: ', 'style' => 'width:90%;')); ?>
									</div>
								</div>
								<div class="row">
									<div class="large-6 columns">
										<?php
										if (isset($colleges) && !empty($colleges)) {
											echo $this->Form->input('Search.college_id', array('label' => 'College: ', 'style' => 'width:90%;', 'empty' => ' All Applicable Colleges ', 'onchange' => 'getDepartment(1)', 'id' => 'college_id', 'default' => (isset($default_college_id) && !empty($default_college_id) ? $default_college_id : '')));
										} else if (isset($departments) && !empty($departments)) {
											echo $this->Form->input('Search.department_id', array('label' => 'Department: ', 'style' => 'width:90%;', 'empty' => ' All Applicable Departments ', 'id' => 'department_id_1', 'default' => (isset($default_department_id) && !empty($default_department_id) ? $default_department_id : '')));
										} ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('Search.graduated', array('label' => 'Graduated: ', 'style' => 'width:90%;', 'options' => array('0' => 'No', '1' => 'Yes', '2' => 'All'), 'default' => '0')); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('Search.name', array('label' => 'Student Name or ID: ', 'placeholder' => 'Optional student name or ID...', 'default' => $name, 'style' => 'width:90%;')); ?>
									</div>
									
									<div class="large-6 columns">
										&nbsp;
									</div>
									<div class="large-3 columns">
										<div style="padding-left: 10%;">
											<br>
											<h6 class='fs13 text-gray'>Status: </h6>
											<?php $options = array('accepted' => ' Accepted', 'rejected' => ' Rejected', 'notprocessed' => ' Not Processed');  ?>
											<?= $this->Form->input('Search.status', array('options' => $options, 'type' => 'radio', 'legend' => false, 'separator' => '<br>', 'label' => false, 'default' => 'accepted')); ?>

											<?= (isset($this->data['Search']['page']) ? $this->Form->hidden('page', array('value' => $this->data['Search']['page'])) : ''); ?>
											<?= (isset($this->data['Search']['sort']) ? $this->Form->hidden('sort', array('value' => $this->data['Search']['sort'])) : ''); ?>
											<?= (isset($this->data['Search']['direction']) ? $this->Form->hidden('direction', array('value' => $this->data['Search']['direction'])) : ''); ?>

										</div>
									</div>
								</div>
								<?php
								if (isset($departments) && !empty($departments) && $this->Session->read('Auth.User')['role_id'] != ROLE_STUDENT && $this->Session->read('Auth.User')['role_id'] != ROLE_REGISTRAR &&  $this->Session->read('Auth.User')['role_id'] != ROLE_COLLEGE &&  $this->Session->read('Auth.User')['role_id'] != ROLE_DEPARTMENT) { ?>
									<div class="row">
										<div class="large-6 columns">
											<?= $this->Form->input('Search.department_id', array('label' => 'Department: ', 'style' => 'width:90%;', 'empty' => ' All Departments ', 'id' => 'department_id_1', 'default' => $default_department_id)); ?>
										</div>
										<div class="large-6 columns">
										</div>
									</div>
									<?php
								} ?>
								<hr>
								<?= $this->Form->submit(__('Search'), array('name' => 'search', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
							</fieldset>
							
							<?php
							if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) { ?>
								<br> 
								
								<div style="margin-top: -10px;">
									<hr>
									<blockquote>
										<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
										<span style="text-align:justify;" class="fs15 text-gray">The student list you will get here depends on your <b style="text-decoration: underline;"><i>assigned College or Department, assigned Program and Program Types, and with your search conditions</i></b>. You can contact the registrar to adjust permissions assigned to you if you miss your students here.</span>
									</blockquote>
								</div>
								<?php
							} ?>
						</div>
					</div>
					<hr>
					<?php
				} else {
					echo '<div style="margin-top: -30px;"><hr></div>';
				} ?>

				<?php 
				if (!empty($courseExemptions)) {  ?>
					<div style="overflow-x:auto;">
						<table cellpadding="0" cellspacing="0" class="table">
							<thead>
								<tr>
									<th class="center"><?= $this->Paginator->sort('id','#');?></th>
									<th class="center"><?= $this->Paginator->sort('student_id', 'Student Name');?></th>
									<th class="vcenter"><?= $this->Paginator->sort('taken_course_title', 'Exempted Course');?></th>
									<th class="vcenter"><?= $this->Paginator->sort('course_id', 'Exempted for');?></th>
									<th class="center"><?= $this->Paginator->sort('request_date', 'Request Date');?></th>
									<th class="center"><?= $this->Paginator->sort('department_accept_reject', 'Department Approval');?></th>
									<th class="center"><?= $this->Paginator->sort('registrar_confirm_deny', 'Registrar Confirmation');?></th>
									<th class="center"></th>
								</tr>
							</thead>
							<tbody>

								<?php
								$start = $this->Paginator->counter('%start%');
								foreach ($courseExemptions as $courseExemption) { ?>
								<tr>
									<td class="center"><?= $start++; ?></td>
									<td class="vcenter"><?= $this->Html->link($courseExemption['Student']['full_name'] . ' (' . $courseExemption['Student']['studentnumber'] . ')', array('controller' => 'students', 'action' => 'student_academic_profile', $courseExemption['Student']['id'])); ?></td>
									<td class="vcenter"><?= $courseExemption['CourseExemption']['taken_course_title'] . ' (' . $courseExemption['CourseExemption']['taken_course_code'] . ') - ' .  $courseExemption['CourseExemption']['course_taken_credit'] . ' Cr.'; ?></td>
									<td class="vcenter"><?= $this->Html->link($courseExemption['Course']['course_code_title'] . ' - ' . $courseExemption['Course']['credit'] . ' Cr.', array('controller' => 'courses', 'action' => 'view', $courseExemption['Course']['id'])); ?></td>
									<td class="center"><?= $this->Time->format("M j, Y", $courseExemption['CourseExemption']['request_date'], NULL, NULL); ?></td>
									<td class="center">
										<?php
										if ($courseExemption['CourseExemption']['department_accept_reject'] == 1) {
											echo '<span class="accepted">Accepted</span>';
											echo '<br><span class="text-gray fs12">' . $courseExemption['CourseExemption']['department_approve_by'] . '</span>';
										} else {
											if (is_null($courseExemption['CourseExemption']['department_accept_reject'])) {
												echo '<span class="text-gray">Waiting Decision</span>';
											} else if ($courseExemption['CourseExemption']['department_accept_reject'] == 0) {
												echo '<span class="rejected">Rejected</span>';
												echo '<br><span class="text-gray fs12">' . $courseExemption['CourseExemption']['department_approve_by'] . '</span>';
											}
										} ?>
									</td>
									<td class="center">
										<?php
										if ($courseExemption['CourseExemption']['registrar_confirm_deny'] == 1) {
											echo '<span class="accepted">Accepted</span>';
											echo '<br><span class="text-gray fs12">' . $courseExemption['CourseExemption']['registrar_approve_by']. '</span>';
										} else {
											if (is_null($courseExemption['CourseExemption']['registrar_confirm_deny'])) {
												echo '<span class="text-gray">Waiting Decision</span>';
											} else if ($courseExemption['CourseExemption']['registrar_confirm_deny'] == 0) {
												echo '<span class="rejected">Rejected</span>';
												echo '<br><span class="text-gray fs12">' . $courseExemption['CourseExemption']['registrar_approve_by']. '</span>';
											}
										} ?>
									</td>
									<td class="center">
										<?php 
										echo $this->Html->link(__(''), array('action' => 'view', $courseExemption['CourseExemption']['id']), array('class' => 'fontello-eye', 'title' => 'View'));
										
										if ($role_id == ROLE_DEPARTMENT) {
											if (is_null($courseExemption['CourseExemption']['department_accept_reject']) && $courseExemption['Student']['graduated'] == 0) {
												echo '<br>' . $this->Html->link(__('[ Accpet/Reject Exemption]'), array('action' => 'approve_request', $courseExemption['CourseExemption']['id']));
											} else if ($courseExemption['Student']['graduated']) {
												echo '<br><span class="text-gray fs12">Graduated Student</span>';
											}
										}
										
										if ($role_id == ROLE_REGISTRAR) {
											if (is_null($courseExemption['CourseExemption']['registrar_confirm_deny']) && $courseExemption['Student']['graduated'] == 0) {
												echo '<br>' . $this->Html->link(__('[Confirm/Reject Exemption]'), array('action' => 'approve_request', $courseExemption['CourseExemption']['id']));
											} else if ($courseExemption['Student']['graduated']) {
												echo '<br><span class="text-gray fs12">Graduated Student</span>';
											}
										} ?>
									</td>
								</tr>
								<?php 
							} ?>
							</tbody>
						</table>
					</div>
					<br>
					
					<hr>
					<div class="row">
						<div class="large-5 columns">
							<?= $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total'))); ?>
						</div>
						<div class="large-7 columns">
							<div class="pagination-centered">
								<ul class="pagination">
									<?= $this->Paginator->prev('<< ' . __(''), array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?> <?= $this->Paginator->numbers(array('separator' => '', 'tag' => 'li')); ?> <?= $this->Paginator->next(__('') . ' >>', array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?>
								</ul>
							</div>
						</div>
					</div>

					<?php
				} else { ?>
					<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>No Course Exemption is found with the given search criteria.</div>
					<?php
				} ?>
	  		</div>
		</div>
    </div>
</div>

<script type="text/javascript">
	
	function toggleViewFullId(id) {
		if ($('#' + id).css("display") == 'none') {
			$('#' + id + 'Img').attr("src", '/img/minus2.gif');
			$('#' + id + 'Txt').empty();
			$('#' + id + 'Txt').append(' Hide Filter');
		} else {
			$('#' + id + 'Img').attr("src", '/img/plus2.gif');
			$('#' + id + 'Txt').empty();
			$('#' + id + 'Txt').append(' Display Filter');
		}
		$('#' + id).toggle("slow");
	}

	function getDepartment(id) {
		//serialize form data
		var formData = $("#college_id").val();
		$("#department_id_" + id).empty();

		$("#department_id_" + id).append('<option style="width:90%;">loading...</option>');

		if (formData) {
			$("#department_id_" + id).attr('disabled', true);
			//get form action
			var formUrl = '/departments/get_department_combo/' + formData + '/0/1';
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data, textStatus, xhr) {
					$("#department_id_" + id).attr('disabled', false);
					$("#department_id_" + id).empty();
					//$("#department_id_" + id).append('<option style="width:100px"></option>');
					$("#department_id_" + id).append(data);
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});

			return false;

		} else {
			$("#department_id_" + id).empty().append('<option value="">[ Select College First ]</option>');
		}
	}

	function toggleView(obj) {
		if ($('#c' + obj.id).css("display") == 'none') {
			$('#i' + obj.id).attr("src",'/img/minus2.gif');
		} else {
			$('#i' + obj.id).attr("src", '/img/plus2.gif');
		}
		$('#c' + obj.id).toggle("slow");
	}
</script>
