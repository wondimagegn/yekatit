<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Student Examination Grade Report'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div class="examGrades <?= $this->request->action; ?>">

					<?= $this->Form->create('ExamGrade'); ?>

					<div style="margin-top: -30px;">
						<hr>

						<div onclick="toggleViewFullId('ListSection')">
							<?php
							if (!empty($sections)) {
								echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg')); ?>
								<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt"> Display Filter</span>
								<?php
							} else {
								echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg')); ?>
								<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt"> Hide Filter</span>
								<?php
							} ?>
						</div>

						<div id="ListSection" style="display:<?= (!empty($sections) ? 'none' : 'display'); ?>">
							<fieldset style="padding-bottom: 5px; padding-top: 15px;">
								<!-- <legend>&nbsp;&nbsp; Search Filters &nbsp;&nbsp;</legend> -->
								<div class="row">
									<div class="large-3 columns">
										<?= $this->Form->input('acadamic_year', array('id' => 'AcadamicYear', 'label' => 'Academic Year: ', 'style' => 'width:90%', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('semester', array('id' => 'Semester', 'type' => 'select', 'label' => 'Semester: ', 'style' => 'width:90%', 'options' => Configure::read('semesters'), 'default' => (isset($semester_selected) ? $semester_selected : false)));
										if (isset($semester_selected)) {
											echo $this->Form->input('semester_selected', array('id' => 'SemesterSelected', 'type' => 'hidden', 'value' => $semester_selected));
										} ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('program_id', array('id' => 'Program', 'label' => 'Program: ', 'style' => 'width:90%', 'type' => 'select', 'options' => $programs, 'default' => (isset($program_id) ? $program_id : false))); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('program_type_id', array('id' => 'ProgramType', 'label' => 'Program Type: ', 'style' => 'width:90%', 'type' => 'select', 'options' => $program_types, 'default' => (isset($program_type_id) ? $program_type_id : false))); ?>
									</div>
								</div>
								<hr>
								<?= $this->Form->submit(__('Get Sections'), array('name' => 'listSections', 'id' => 'listSections', 'div' => false, 'class' => 'tiny radius button bg-blue')); ?>
							</fieldset>
						</div>

						<hr>
					</div>

					<div id="show_sections_drop_down">
						<?php
						if (!empty($sections)) { ?>
								<table class="fs14" cellpadding="0" cellspacing="0" class='table'>
									<tr>
										<td style="width:25%;" class="center">Sections</td>
										<td colspan="3">
											<div class="large-10 columns">
											<br>
											<?= $this->Form->input('section_id', array('style' => 'width:90%', 'id' => 'Section', 'label' => false, 'type' => 'select', 'options' => $sections, 'default' => (isset($section_id) && !empty($section_id) ? $section_id : 0))); ?>
											</div>
										</td>
									</tr>
								</table>
							<?php
						} ?>
					</div>

					<div id="searchAgain" class="fs14 text-gray" style="display: none;"></div>

					<div id="show_search_results">
						<?php
						if (isset($students_in_section) && empty($students_in_section)) { ?>
							<hr>
							<div class="info-box info-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span>There is no student in the selected section.</div>
							<?php
						} else if (isset($students_in_section) && !empty($students_in_section)) { ?>

							<hr>
							<blockquote>
								<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
								<span style="text-align:justify;" class="fs14 text-gray"><b class="text-black"><i>Only students with course registration for the selected academic year or semester or students that have status for atleast one semester and not graduated appear here for printing.</i></b> Use Student copy for graduated students instead if applicable.</span>
							</blockquote>
							<hr>
							

							<h6 class="fs14 text-gray">Please select student/s for whom you want to prepare student examination grade report.</h6>

							<h6 id="validation-message_non_selected" class="text-red fs14"></h6>
							<br>

							<div style="overflow-x:auto;">
								<table cellpadding="0" cellspacing="0" class="table">
									<thead>
										<tr>
											<th class="center" style="width: 4%;"><div style="margin-left: 20%;"><?= $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all','label' => false)); ?></div></th>
											<th class="center" style="width: 3%;">#</th>
											<th class="vcenter" style="width:30%">Student Name</th>
											<th class="center" style="width: 10%">Sex</th>
											<th class="vcenter">Student ID</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php

										$st_count = 0;
										$printable_count = 0;

										foreach ($students_in_section as $key => $student) {
											$st_count++; ?>
											<tr>
												<td class="center">
													<?php
													if (!$student['Student']['graduated']) {
														echo '<div style="margin-left: 25%;">' . $this->Form->input('Student.' . $st_count . '.gp', array('type' => 'checkbox', 'class' => 'checkbox1', 'label' => false, 'id' => 'StudentSelection' . $st_count)) . '</div>';
														echo $this->Form->input('Student.' . $st_count . '.student_id', array('type' => 'hidden', 'value' => $student['Student']['id']));
														$printable_count++;
													} else {
														echo '**';
													} ?>
												</td>
												<td class="center"><?= $st_count; ?></td>
												<td class="vcenter" ><?= $student['Student']['full_name']; ?></td>
												<td class="center"><?= (strcasecmp(trim($student['Student']['gender']), 'male') == 0 ? 'M' : (strcasecmp(trim($student['Student']['gender']), 'female') == 0 ? 'F' : trim($student['Student']['gender']))); ?></td>
												<td class="vcenter" ><?= $student['Student']['studentnumber']; ?></td>
												<td></td>
											</tr>
											<?php
										} ?>
									</tbody>
								</table>
							</div>
							<hr>
							<?= $this->Form->submit(__('Get Grade Report'), array('name' => 'getGradeReport', 'id' => 'getGradeReport', 'div' => false, 'disabled' => ($printable_count ? false: true), 'class' => 'tiny radius button bg-blue')); ?>
							<?php
						} ?>
					</div>
					<?= $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	var number_of_students = <?= (isset($students_in_section) ? count($students_in_section) : 0); ?>;

	function check_uncheck(id) {
		var checked = ($('#' + id).attr("checked") == 'checked' ? true : false);
		for (i = 1; i <= number_of_students; i++) {
			$('#StudentSelection' + i).attr("checked", checked);
		}
	}

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
			$('#' + id + 'Txt').append(' Hide Filter');
		} else {
			$('#' + id + 'Img').attr("src", '/img/plus2.gif');
			$('#' + id + 'Txt').empty();
			$('#' + id + 'Txt').append(' Display Filter');
		}
		$('#' + id).toggle("slow");
	}

	$(function () {

        const $showSearchResults = $('#show_search_results');
        const $searchAgain = $('#searchAgain');

		const $dynamicOnchangePageReloadField = $("#Section");
		const $dynamicOnchangePageReloadFieldDiv = $("#show_sections_drop_down");

		const $semesterField = $("#SemesterSelected");
		const $selectAllBox = $('#select-all');

		const $searchBtn = $("#listSections");
		const $searchBtnText = 'Get Sections';
		const $searchBtnSearchingText = 'Looking for Sections...';

		const $secondaryBtn = $('#getGradeReport');
		const $secondaryBtnProcessingText = 'Generating Grade Report...'

		let form_being_submitted = false;

		let selected_section = '';

		const validationMessageNonSelected = document.getElementById('validation-message_non_selected');

		if ($dynamicOnchangePageReloadField.val() != '') {
			//selected_section = $("#Section option:selected").text();
			selected_section = $dynamicOnchangePageReloadField.find("option:selected").text();
		}

		$dynamicOnchangePageReloadField.change(function() {
			
			var s_id = $dynamicOnchangePageReloadField.val();
			var semester = $semesterField.val();
			
			if (s_id != 0 && s_id != '0' && s_id != '') {
				window.location.replace("/exam_grades/<?= $this->request->action; ?>/" + s_id + "/" + semester);
			} else {
				$dynamicOnchangePageReloadField.val(0)
			}

			//$('#Section').val(0)

			$dynamicOnchangePageReloadFieldDiv.hide();

			if ($showSearchResults.length) {
				$showSearchResults.hide();
			}

			if ($secondaryBtn.length) {
				$secondaryBtn.attr('disabled', true);
			}

			if ($selectAllBox.length) {
				$selectAllBox.prop('checked', false);
			}

			$('input[type="checkbox"][name^="data[Student]"]').each(function() {
				const namePatternSelected = /data\[Student\]\[\d+\]\[gp\]/;
				if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
					$(this).prop('checked', false);
				}
			});
		});

		$secondaryBtn.click(function() {

			//selected_section = $("#Section option:selected").text();
			selected_section = $dynamicOnchangePageReloadField.find("option:selected").text();

			var checkedOne = false;

			$('input[type="checkbox"][name^="data[Student]"]').each(function() {
				const namePatternSelected = /data\[Student\]\[\d+\]\[gp\]/;
				if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
					checkedOne = true;
					return;
				}
			});

			var acy_and_semester =  document.getElementById("AcadamicYear").value + ', semester: ' + document.getElementById("Semester").value;

			var isValid = true;

			if (!checkedOne) {
				alert('At least one student must be selected from ' + selected_section + ' section to prepare student examination grade report for ' + acy_and_semester + '.');
				validationMessageNonSelected.innerHTML = 'At least one student must be selected from ' + selected_section + ' section to prepare student examination grade report for ' + acy_and_semester + '.';
				isValid = false;
				return false;
			}

			if (form_being_submitted) {
				alert('Generating student examination grade report for the selected students from ' + selected_section + ' section, please wait a moment...');
				$secondaryBtn.attr('disabled', true);
				if ($dynamicOnchangePageReloadField.length) {
					$dynamicOnchangePageReloadField.attr('disabled', true);
				}
				isValid = false;
				return false;
			} else {
				form_being_submitted = false;
			}

			if (!form_being_submitted && isValid) {
				$secondaryBtn.val($secondaryBtnProcessingText);
				if ($searchBtn.length) {
					$searchBtn.attr('disabled', true);
				}
				form_being_submitted = true;
				return true;
			} else {
				return false;
			}
		});

		$('#AcadamicYear, #Semester, #Program, #ProgramType').on('change', function () {
			if ($showSearchResults.length) {
				hideSearchResults();
			} else {
				hideSearchResults('');
			}
		});
		
		$searchBtn.click(function(event) {
			$searchBtn.val($searchBtnSearchingText);
			hideSearchResults('Looking for search results based on your current search filters...');
		});

		// Hide seaech results and show search prompt
		function hideSearchResults(message = 'Click ' + $searchBtnText + ' button again to get new search results based on your changed filters.') 
		{
			$dynamicOnchangePageReloadFieldDiv.hide();

			if ($showSearchResults.length) {
				$showSearchResults.hide();
			} else {
				message = '';
			}

			if ($secondaryBtn.length) {
				$secondaryBtn.attr('disabled', true);
			}

			if ($selectAllBox.length) {
				$selectAllBox.prop('checked', false);
			}

			$('input[type="checkbox"][name^="data[Student]"]').each(function() {
				const namePatternSelected = /data\[Student\]\[\d+\]\[gp\]/;
				if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
					$(this).prop('checked', false);
				}
			});

			$searchAgain.text(message).show();
		}

		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}

	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>