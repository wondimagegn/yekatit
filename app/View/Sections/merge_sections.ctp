<div class="box">
	<div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Merge Sections'); ?></span>
        </div>
    </div>
 	<div class="box-body">
		<div class="row">
            <div class="large-12 columns">
				<?= $this->Form->create('Section'); ?>
				<div style="margin-top: -30px;">
					<hr>
					<blockquote>
						<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
						<p style="text-align:justify;">
							<span class="fs15 text-black">This tool will help you to merge sections for the purpose of management if the number of students in a given section is too small.</span> <br>
							<i class="rejected fs16">To avoid possible complications, you're not advised to merge sections which have different curriculum attachments, same/different course publication, instructor assignments or grade submissions. Section merges which originate from a previous section split are okay.</i>
						</p> 
					</blockquote>
					<hr>

					<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
						if (!empty($sections)) {
							echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
							<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt"> Display Filter</span>
							<?php
						} else {
							echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
							<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt"> Hide Filter</span>
							<?php
						} ?>
					</div>

					<div id="ListPublishedCourse" style="display:<?= (!empty($sections) ? 'none' : 'display'); ?>">
						<fieldset style="padding-bottom: 0px;padding-top: 15px;">
							<!-- <legend>&nbsp;&nbsp; Search / Filter &nbsp;&nbsp;</legend> -->
							<div class="row">
								<div class="large-3 columns">
									<?= $this->Form->input('Section.academicyear', array('label' => 'Academic Year: ', 'required', 'type' => 'select', 'style' => 'width:90%;', 'options' => $custom_acy_list /* $acyear_array_data */, 'default' => (isset($this->request->data['Section']['academicyear']) ? $this->request->data['Section']['academicyear'] : (isset($defaultacademicyear) ? $defaultacademicyear : '')))); ?>
								</div>
								<div class="large-3 columns">
									<?= $this->Form->input('Section.program_id', array('label' => 'Program: ', 'required', 'style' => 'width:90%;')); ?>
								</div>
								<div class="large-3 columns">
									<?= $this->Form->input('Section.program_type_id', array('label' => 'Program Type: ', 'required', 'style' => 'width:90%;')); ?>
								</div>
								<div class="large-3 columns">
									<?php
									if ($role_id == ROLE_DEPARTMENT) { ?>
										<?= $this->Form->input('Section.year_level_id', array('label' => 'Year Level: ', 'empty' => '[ Select Year Level ]', 'required', 'style' => 'width:90%;')); ?>
										<?php
									} ?>
								</div>
							</div>
							<hr>
							<?= $this->Form->Submit('Search', array('name' => 'search', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
						</fieldset>
					</div>
					<hr>
				</div>

				<?php
				if (!empty($sections)) {
					$section_list_name = array();
					$no_of_sections = 0;

					foreach ($sections as $key => $value) {
						if (isset($current_sections_occupation[$key]) && !empty($current_sections_occupation[$key])) {
							echo $this->Form->hidden('Section.' . $key . '.id', array('value' => $value['Section']['id']));
							$section_list_name[] = $value['Section']['name'] . ' (Currently hosted students: ' . $current_sections_occupation[$key] . (isset($sections_curriculum_name[$key]) && !empty($sections_curriculum_name[$key]) ? ', Section Curriculum: ' . $sections_curriculum_name[$key] : '') . ')';
							$no_of_sections++;
						}
					} 
					
					if (!empty($section_list_name)) { ?>
						<h6 id="validation-message_non_selected" class="text-red fs14"></h6>

						<fieldset style="padding-bottom: 15px; padding-top: 15px;">
							<legend>&nbsp;&nbsp; Select Sections to Merge &nbsp;&nbsp;</legend>
							<div class="row">
								<div class="large-12 columns">
									<?= $this->Form->input('Section.Sections', array('label' => false, 'type' => 'select', 'multiple' => 'checkbox', 'div' => 'input select', 'options' => $section_list_name)); ?>
								</div>
							</div>
						</fieldset>
						<hr>
						<?= $this->Form->Submit('Merge Sections', array('name' => 'merge', 'id' => 'mergeSections', 'disabled' => ($no_of_sections < 2 ? true : false), 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
						<?php
					} else { ?>
						<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>Unfortunately all sections are empty and no section to merge without students.</div>
						<?php
					}
				} else if (empty($sections) && !($isbeforesearch)) { ?>
					<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>No section is found with the selcted search criteria.</div>
					<?php
				} ?>
				<?= $this->Form->end(); ?>
			</div>
        </div>
   </div>
</div>

<script type='text/javascript'>
	function toggleViewFullId(id) {
		if ($('#'+id).css("display") == 'none') {
			$('#'+id+'Img').attr("src", '/img/minus2.gif');
			$('#'+id+'Txt').empty();
			$('#'+id+'Txt').append(' Hide Filter');
		} else {
			$('#'+id+'Img').attr("src", '/img/plus2.gif');
			$('#'+id+'Txt').empty();
			$('#'+id+'Txt').append(' Display Filter');
		}
		$('#'+id).toggle("slow");
	}

	var merging_selected_sections = false;

	const validationMessageNonSelected = document.getElementById('validation-message_non_selected');

	$('#mergeSections').click(function() {
		var isValid = true;
		var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="data[Section][Sections]"]');
		var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
		var selectedCount = Array.prototype.slice.call(checkboxes).filter(x => x.checked).length;

		//alert(checkedOne);
		//alert(selectedCount);

		if (!checkedOne || selectedCount < 2 ) {
			alert('At least two sections must be selected for section merge.');
			validationMessageNonSelected.innerHTML = 'At least two sections must be selected for section merge.';
			isValid = false;
			return false;
		} else if (selectedCount > 3) {
			alert('Merging more than 3 sections at a time is not allowed.');
			validationMessageNonSelected.innerHTML = 'Merging more than 3 sections at a time is not allowed.';
			isValid = false;
			return false;
		}

		if (merging_selected_sections) {
			alert('Merging Selected Sections, please wait a moment...');
			$('#mergeSections').attr('disabled', true);
			isValid = false;
			return false;
		}

		var confirmmm = confirm('The selected ' + selectedCount + ' sections will be merged in to one section and  all students currently assinged in this section will be moved to the new section. Are you sure you want to merege these ' + selectedCount + ' sections in to one section?');

		if (!merging_selected_sections && isValid && confirmmm) {
			$('#mergeSections').val('Merging Selected Sections...');
			merging_selected_sections = true;
			isValid = true
			return true;
		} else {
			return false;
		}
	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>