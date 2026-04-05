<div class="box">
	<div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px; padding-right: 15px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">Downgrade Sections to the Previous Year Level: <?= (!empty($department_name) ? '('. $department_name . ')' : (!empty($college_name) ? '('. $college_name . ')' : '')); ?></span>
        </div>
    </div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">

				<?= $this->Form->create('Section');  ?>

				<?php
				if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['Role']['parent_id'] == ROLE_DEPARTMENT) { ?>
					<div style="margin-top: -30px;">
						<?php
						if (empty($formateddowngradableSections)) { ?>
							<hr>
							<blockquote>
								<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
								<span style="text-align:justify;" class="fs14 text-gray">This tool will help you to downgrade sections to the previous year level. Here <b style="text-decoration: underline;"><i>you get only potentially downgradable sections that doesn't have any published courses.</i></b> 
								<br/> <br> <b class="rejected">You are advised to downgrade year level of a section only if you upgraded the section by mistake.</b></span>
							</blockquote>
							<?php
						} ?>

						<hr>

						<div onclick="toggleViewFullId('ListPublishedCourse')">
							<?php
							if (!empty($formateddowngradableSections)) {
								echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
								<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span>
								<?php
							} else {
								echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
								<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span>
								<?php
							} ?>
						</div>

						<div id="ListPublishedCourse" style="display:<?= (!empty($formateddowngradableSections) ? 'none' : 'display'); ?>">
							<fieldset style="padding-bottom: 5px;padding-top: 25px;">
								<!-- <legend>&nbsp;&nbsp; Search / Filter &nbsp;&nbsp;</legend> -->
								<div class="row">
									<div class="large-3 columns">
										<?= $this->Form->input('Section.academicyear', array('label' => 'Academic Year: ', 'options' => $acyear_array_data_custom, 'required', 'style' => 'width:90%;')); ?>
									</div>
									<?php
									if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) {
										if (!empty($yearLevels)) {
											$key = array_search('1st', $yearLevels);
											if ($key != false) {
												unset($yearLevels[$key]);
											}
										} ?>
										<div class="large-3 columns">
											<?= $this->Form->input('Section.year_level_id', array('label' => 'Year Level: ', 'options' => $yearLevels, 'empty' => '[ All Year Levels ]', 'required', 'style' => 'width:90%;')); ?>
										</div>
										<?php
									} ?>
									<div class="large-3 columns">
										<?= $this->Form->input('Section.program_id', array('label' => 'Program: ', 'empty' => "[ All Programs ]", 'required',  'style' => 'width:90%;')); ?>
									</div>
									<div class="large-3 columns">
										<?= $this->Form->input('Section.program_type_id', array('label' => 'Program Type: ', 'empty' => "[ All Program Types ]",  'required', 'style' => 'width:90%;')); ?>
									</div>
								</div>
								<div class="row">
									<div class="large-12 columns">
										<hr>
										<?= $this->Form->Submit('Search', array('name' => 'search', 'id' => 'searchBtn', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<hr>

					<div id="searchAgain" class="fs14 text-gray" style="display: none;"></div>

					<?php
					$enableSubmitButton = 0;

					if (isset($formateddowngradableSections) && !empty($formateddowngradableSections)) { ?>
						<div id="showSeachResults"> 
							<h6 id="validation-message_non_selected" class="text-red fs14"></h6>
							<?php
							foreach ($formateddowngradableSections as $fsk => $fsv) { ?>
								<h6 class="fs14 text-gray"><?= (!empty($this->data['Section']['program_id']) ? $programs[$this->data['Section']['program_id']] . ' - ' : '') . (!empty($this->data['Section']['program_type_id']) ? ' ' . $program_types[$this->data['Section']['program_type_id']] . ', ' : '') . $fsk . ' year'; ?></h6>
								<div style="overflow-x:auto;">
									<table style="border: #CCC solid 2px" cellpadding="0" cellspacing="0" class="table">
										<?php
										if (isset($fsv['Downgradable']) && !empty($fsv['Downgradable'])) { ?>
											<thead>
												<tr>
													<td><h6 class="fs14 text-gray">Downgradable Sections</h6></td>
												</tr>
											</thead>
											<tr>
												<td>
													<table cellpadding="0" cellspacing="0" class="table">
														<tbody>
															<?php
															foreach ($fsv['Downgradable'] as $ufsk => $ufsv) { ?>
																<tr>
																	<td class="vcenter" style="background-color: white;">
																		<div style="margin-left: 1%; margin-top: 1%;">
																			<?= $this->Form->input('Section.Downgradable_Selected.' . $ufsk, array('class' => 'downgradableSelectedSection', 'type' => 'checkbox', 'value' => $ufsk, 'label' => $ufsv)); ?>
																		</div>
																	</td>
																</tr>
																<?php
															} ?>
														</tbody>
													</table>
												</td>
											</tr>
											<?php
											$enableSubmitButton++;
										}

										if (isset($fsv['Notdowngradable']) && !empty($fsv['Notdowngradable'])) { ?>
											<thead>
												<tr>
													<td class="font">The following list of sections do not qualify for year level downgrade</td>
												</tr>
											</thead>
											<tr>
												<td>
													<table cellpadding="0" cellspacing="0" class="table">
														<tbody>
															<?php
															foreach ($fsv['Notdowngradable'] as $uufsk => $uufsv) { ?>
																<tr>
																	<td style="background-color: white;" class="vcenter"><?= $uufsv; ?></td>
																</tr>
																<?php
															} ?>
														</tbody>
													</table>
												</td>
											</tr>
											<?php
										} ?>
									</table>
								</div>
								<hr>
								<?php
							} 

							if ($enableSubmitButton) { ?>
								<hr>
								<?= $this->Form->Submit('Downgrade Selected Sections', array('name' => 'downgrade', 'div' => false, 'class' => 'tiny radius button bg-blue', 'id' => 'downgradeSection')); ?>
								<?php
							} ?>

						</div>
						<?php
					} else if (empty($formateddowngradableSections) && !($isbeforesearch)) { ?>
						<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>There is no section found to downgrade with the selected search criteria.</div>
						<?php
					}
				} ?>

				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

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

	document.addEventListener('DOMContentLoaded', function () {

		const form = document.getElementById('SectionDowngradeSectionsForm');

		// Select all relevant <select> elements
		const filters = [
			document.getElementById('SectionAcademicyear'),
			document.getElementById('SectionProgramId'),
			document.getElementById('SectionProgramTypeId'),
			document.getElementById('SectionYearLevelId')
		];

		// Attach change event to each
		filters.forEach(select => {
			if (select) {
				select.addEventListener('change', function () {
					const searchResultShown = document.getElementById('showSeachResults');
					const searchAgain = document.getElementById('searchAgain');

					if (searchResultShown) {
						searchResultShown.style.display = 'none';
						searchAgain.textContent = 'Click Search button again to get new search results based on your changed filters.';
						searchAgain.style.display = 'block';

						// Uncheck all selected checkboxes
						const checkboxes2 = document.querySelectorAll('input[type="checkbox"][name^="data[Section][Downgradable_Selected]["]');
						checkboxes2.forEach(cb => {
							if (cb.checked) {
								cb.checked = false;
							}
						});

						// optionally auto submit the form
						//form.submit();
					} else {
						// If searchResultShown doesn't exist, just show the message
						// searchAgain.textContent = 'Click Search button again to get new search results based on your changed filters.';
						// searchAgain.style.display = 'block';
					}
				});
			}
		});

		let formBeingSubmitted = false;

		form.addEventListener('submit', function (e) {
			
			const clickedButton = e.submitter;
			const isThisSearchBtn = clickedButton.id === 'searchBtn';
			const searchBtn = form.searchBtn;
			const secondaryBtn = form.downgradeSection;

			const searchBtnProcessing = 'Searching...';
			const secondaryBtnProcessing = 'Downgrading Selected Sections...';
			const formBeingSubmittedSearchingWaitMessage = 'Searching for downgradable sections, please wait a moment...';
			const formBeingSubmittedSecondaryWaitMessage = 'Downgrading selected sections, please wait a moment...';

			const confirmActionConfimationText = 'Are you sure you want to downgrade selected sections to the previous year level?';

			const notSelectedCheckBoxNotification = 'At least one section must be selected to downgrade year level.';

			let valid = true;

			// check if required select fields are selected and not empty
			for (let i = 0; i < filters.length; i++) {
				const select = filters[i];
				// Check if it's required and not selected
				if (select && select.hasAttribute('required') && !select.value) {
					e.preventDefault();
					select.focus();
					valid = false;
					break; // Stop at the first invalid field
				}
			}

			if (!valid) return;  // Continue with other existing validation and submission logic...


			if (!isThisSearchBtn && clickedButton.id === secondaryBtn.id && !formBeingSubmitted) {
				const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="data[Section][Downgradable_Selected]["]');
				const isChecked = Array.from(checkboxes).some(cb => cb.checked);

				if (!isChecked) {
					e.preventDefault();
					alert(notSelectedCheckBoxNotification);
					const validationMessageNonSelected = document.getElementById('validation-message_non_selected');
					if (validationMessageNonSelected) {
						validationMessageNonSelected.textContent = notSelectedCheckBoxNotification;
					}
					valid = false;
					return;
				}

				const confirmm = confirm(confirmActionConfimationText);
				
				if (!confirmm) {
					e.preventDefault();
					valid = false;
					return;
				}
			}

			if (!valid) {
				e.preventDefault();
				return;
			}

			if (formBeingSubmitted && isThisSearchBtn) {
				alert(formBeingSubmittedSearchingWaitMessage);
				searchBtn.disabled = true;
				secondaryBtn.disabled = true;
				e.preventDefault();
				return;
			} else if (formBeingSubmitted && !isThisSearchBtn) {
				alert(formBeingSubmittedSecondaryWaitMessage);
				searchBtn.disabled = true;
				secondaryBtn.disabled = true;
				e.preventDefault();
				return;
			}

			if (isThisSearchBtn) {
				searchBtn.value = searchBtnProcessing;
				secondaryBtn.disabled = true; // disable the secondary button.

				// Hide search results if shown
				const isSearchResultShown = document.getElementById('showSeachResults');
				if (isSearchResultShown) {
					isSearchResultShown.style.display = 'none';
				}

				// Uncheck all selected checkboxes
				const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="data[Section][Downgradable_Selected]["]');
				checkboxes.forEach(cb => {
					if (cb.checked) {
						cb.checked = false;
					}
				});

			} else if (clickedButton.id === secondaryBtn.id) {
				secondaryBtn.value = secondaryBtnProcessing;
				searchBtn.disabled = true;
			}

			formBeingSubmitted = true;
		});

		// prevent form resubmission on page refresh
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	});
	
</script>
