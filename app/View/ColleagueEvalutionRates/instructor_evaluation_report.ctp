<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class=" icon-print" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Colleague Evaluation Report'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">

				<div style="margin-top: -30px;"><hr></div>

				<?= $this->Form->create('ColleagueEvalutionRate'); ?>

				<?php
				if (isset($colleagueLists) && !empty($colleagueLists)) { ?>
					<blockquote>
						<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
						<p style="text-align:justify;">
							<span class="fs16 text-black">
							<strong>If a staff member marked with ** is found in the list, ensure that the staff has been evaluated by students, at least one colleague, and the head of the department for the specified academic year and semester.</strong>
							<br>To ensure fairness in the evaluation process, it is recommended to maintain a minimum of <?= REQURED_MINIMUM_COLLEAGUE_EVALUATION_TO_FILL_INSTRUCTOR; ?> or more colleague evaluations for each staff member.
							</span>
						</p> 
					</blockquote>
					<?php
				} else { ?>
					<blockquote>
						<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
						<p style="text-align:justify;">
							<span class="fs16 text-black">
							You can search by partial or full <strong>first name in the Staff Name field</strong> to retrieve specific staff evaluations. Leave the field empty to display all staff members with course assignments for the given academic year and semester.
							<br><b>Not all staff members in your department are listed here; only those assigned to a course in the given academic year and semester are included.</b>
							</span>
						</p> 
					</blockquote>
					<?php
				} ?>
				<hr>
				

				<div class="examGrades ">
					<div onclick="toggleViewFullId('ListSection')">
						<?php
						if (!empty($colleagueLists)) {
							echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg')); ?>
							<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt"> Display Filter</span>
							<?php
						} else {
							echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg')); ?>
							<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt"> Hide Filter</span>
							<?php
						} ?>
					</div>

					<div id="ListSection" style="display:<?php echo (!empty($colleagueLists) ? 'none' : 'display'); ?>">
						<fieldset style="padding-bottom: 0px;padding-top: 15px;">
							<!-- <legend>&nbsp;&nbsp; Search Filters &nbsp;&nbsp;</legend> -->
							<div class="large-3 columns">
								<?= $this->Form->input('Search.acadamic_year', array('id' => 'AcadamicYear', 'label' => 'Academic Year: ', 'class' => 'fs14', 'style' => 'width:90%;', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($defaultacademicyear) ? $defaultacademicyear : $this->request->data['Search']['acadamic_year']))); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('Search.semester', array('options' => Configure::read('semesters'), 'style' => 'width:90%;', 'type' => 'select', 'label' => 'Semester: ', 'default' => (isset($semester_selected) ? $semester_selected : $current_semester))); ?>
							</div>
							<div class="large-6 columns">
								<?= $this->Form->input('Search.name', array('label' => 'Staff Name: ', 'style' => 'width:90%;', 'id' => 'staffName',  'placeholder' => 'Leave empty for all staffs or enter name here...', 'maxlength' => 25)); ?>
							</div>
							<hr>

							<?= $this->Form->submit(__('Search'), array('name' => 'getInstructorList', 'id' => 'getInstructorList', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
						</fieldset>
					</div>
					<hr>

					<?php
					if (isset($colleagueLists) && !empty($colleagueLists)) { ?>
						<div id="show_search_results">
							<br>
							<h6 id="validation-message_non_selected" class="text-red fs14"></h6>
							<br>

							<div style="overflow-x:auto;">
								<table cellspacing="0" cellpadding="0" class="fs14 table">
									<thead>
										<tr>
											<td style="width:15%" colspan="6">Instructors that have course assignment for <?= (isset($academic_year_selected) ? $academic_year_selected : $this->request->data['Search']['acadamic_year']) ?> Academic Year, <?= (isset($this->request->data['Search']['semester']) ? ' Semester: ' . $this->request->data['Search']['semester'] : ' selected semester') ?></td>
										</tr>
										<tr>
											<td style="width:3%" class="center"><?= $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'label' => false)); ?><!-- <label for="select-all">All</label> --></th>
											<td style="width:2%" class="vcenter">#</td>
											<td style="width:55%" class="vcenter">Staff Full Name</td>
											<td class="center">By Students</td>
											<td class="center">By Colleagues</td>
											<td class="center">By Head</td>
										</tr>
									</thead>
									<tbody>
										<?php
										$st_count = 0;
										$enableButton = 0;

										foreach ($colleagueLists as $skey => $staff) {
											//debug($assignedCoursesList);
											$staffColumns = explode('~', $staff);
											$st_count++; ?>
											<tr>
												<td class="center">
													<?php
													if ($staffColumns[4] == 1 || $staffColumns[4] == '1') { ?>
														<div style="margin-left: 20%;">
															<?= $this->Form->input('Staff.' . $st_count . '.gp', array('type' => 'checkbox', 'class' => 'checkbox1', 'label' => false, 'id' => 'StaffEvaluation' . $st_count)); ?>
															<?= $this->Form->input('Staff.' . $st_count . '.id', array('type' => 'hidden', 'value' => $skey)); ?>
														</div>
														<?php
														$enableButton++;
													} else { 
														echo '**';
													} ?>
												</td>
												<td class="center"><?= $st_count; ?></td>
												<td class="vcenter"><?= $staffColumns[0]; ?></td>
												<td class="center"><?= ($staffColumns[1] == 0 || $staffColumns[1] == '0' ? 'No' : $staffColumns[1]); ?></td>
												<td class="center"><?= $staffColumns[2]; ?></td>
												<td class="center"><?= ($staffColumns[3] == 0 ? 'No' : 'Yes'); ?></td>
											</tr>
											<?php
										} ?>
									</tbody>
								</table>
							</div>
							<hr>

							<?= $this->Form->submit(__('Generate Evaluation PDF'), array('name' => 'generateEvaluationReport', 'id' => 'generateEvaluationReport', 'div' => false, 'class' => 'tiny radius button bg-blue', 'disabled' => ($enableButton > 0 ? false : true))); ?>
							<?= $this->Form->end(); ?>

						</div>
						<?php
					} ?>

				</div>
			</div>
		</div>
	</div>
</div>

<script>

	$('#getInstructorList').click(function() {

		var staffName = $("#staffName").val();

		if (staffName !== '') {
			staffName = ' with name starting ' + staffName;
		}

		$('#getInstructorList').val('Looking for Staffs' + staffName + '...');

		if ($('#show_search_results').length) {
			$("#show_search_results").hide();
		}

		if ($('#select-all').length) {
			$("#select-all").prop('checked', false);
		}

		$('input[type="checkbox"][name^="data[Staff]"]').each(function() {
            const namePatternSelected = /data\[Staff\]\[\d+\]\[gp\]/;
            if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
                $(this).prop('checked', false);
            }
        });

	});

	function toggleView(obj) {
		if ($('#c' + obj.id).css("display") == 'none') {
			$('#i' + obj.id).attr("src", '/img/minus2.gif');
		} else {
			$('#i' + obj.id).attr("src", '/img/plus2.gif');
		}
		$('#c' + obj.id).toggle("slow");
	}

	function toggleViewFullId(id) {
		if ($('#' + id).css("display") == 'none') {
			$('#' + id + 'Img').attr("src", '/img/minus2.gif');
			$('#' + id + 'Txt').empty();
			$('#' + id + 'Txt').append('Hide Filter');
		} else {
			$('#' + id + 'Img').attr("src", '/img/plus2.gif');
			$('#' + id + 'Txt').empty();
			$('#' + id + 'Txt').append('Display Filter');
		}
		$('#' + id).toggle("slow");
	}

	var form_being_submitted = false;

    const validationMessageNonSelected = document.getElementById('validation-message_non_selected');

	$('#generateEvaluationReport').click(function() {
		
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);

		//alert(checkedOne);
		if (!checkedOne) {
            alert('At least one instructor must be selected to generate evaluation PDF.');
			validationMessageNonSelected.innerHTML = 'At least one instructor must selected to generate evaluation PDF.';
			return false;
		}

		if (form_being_submitted) {
			alert('Generating Evaluation PDF, please wait a moment...');
			$('#generateEvaluationReport').attr('disabled', true);

			// Re-enable getInstructorList button after a delay
			/* setTimeout(function () {
				$("#generateEvaluationReport").attr('disabled', false);
				$('#generateEvaluationReport').val('Generate Evaluation PDF');
				//form_being_submitted = false;
			}, 10000); // 5000 milliseconds = 5 seconds */
			
			return false;
		}


		if (!form_being_submitted) {
			$('#generateEvaluationReport').val('Generating Evaluation PDF...');

			if ($("#getInstructorList").length) {
				$("#getInstructorList").attr('disabled', true);

				// Re-enable getInstructorList button after a delay
				setTimeout(function () {
					$("#getInstructorList").attr('disabled', false);
				}, 10000); // 5000 milliseconds = 5 seconds
			}

			form_being_submitted = true;

			return true;
		} else {
			return false;
		}

	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
	
</script>