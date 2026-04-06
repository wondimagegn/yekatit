<div class="box">
	<div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Split Section'); ?></span>
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
							<span class="fs15 text-black">This tool will help you to split a section for the purpose of management if the number of students in the given section is too large.</span><br>
							<i class="rejected fs16">To avoid possible complications, you're not advised to split sections which have course instructor assignments or grade submissions.</i>
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
									<?= $this->Form->input('Section.academicyear', array('label' => 'Academic Year: ', 'required', 'type' => 'select', 'style' => 'width:90%;', 'options' =>  $custom_acy_list, 'default' => (isset($this->request->data['Section']['academicyear']) ? $this->request->data['Section']['academicyear'] : (isset($defaultacademicyear) ? $defaultacademicyear : '')))); ?>
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

					$sections_array = array();

					$sections_array[-1] = "[ Please Select Section ]";
					foreach ($sections as $key => $value) {
						if (isset($current_sections_occupation[$key]) && !empty($current_sections_occupation[$key])) {
							echo $this->Form->hidden('Section.' . $key . '.id', array('value' => $value['Section']['id']));
							$sections_array[] = $value['Section']['name'] . ' (Currently hosted students: ' . $current_sections_occupation[$key] . ')';
						}
					} ?>
					

					<fieldset style="padding-bottom: 0px; padding-top: 15px;">
						<legend>&nbsp;&nbsp; Select Section to Split &nbsp;&nbsp;</legend>
						<div class="row">
							<div class="large-8 columns">
								<?= $this->Form->input('selectedsection', array('label' => 'Sections: ', 'id' => 'selectedSectionName', 'style' => 'width:90%;', 'type' => 'select', 'options' => $sections_array)); ?>
							</div>
							<div class="large-2 columns">
								<?= $this->Form->input('number_of_section', array('label' => 'Split to: ', 'id' => 'splittingInToSections', 'style' => 'width:90%;', 'type' => 'select', 'options' => array('2' => '2 sections', '3' => '3 sections'))); ?>
							</div>
							<div class="large-2 columns">

							</div>
						</div>
						<hr>
						<?= $this->Form->Submit('Split Selected Section', array('name' => 'split', 'id' => 'splitSection', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
					</fieldset>

					<?php
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

	var splitting_selected_section = false;

	$('#splitSection').click(function() {

		var selectedSectionName = $('#selectedSectionName').val();
		var splittingInToSections = $('#splittingInToSections').val();

		//alert(selectedSectionName);

		if (selectedSectionName == '' /* || selectedSectionName == 0 || selectedSectionName == '0'  */|| selectedSectionName == -1 || selectedSectionName == '-1') {
			$('#selectedSectionName').focus();
			return false;
		} else {
			selectedSectionName = $('#selectedSectionName').find(':selected').text();
		}

		if (splitting_selected_section) {
			alert('Splitting Selected Section, please wait a moment...');
			$('#splitSection').attr('disabled', true);
			return false;
		}

		var confirmmm = confirm(selectedSectionName + ' section will be split in to ' + splittingInToSections + ' different sections and all students currently assinged in this section will be evenly distributed to ' + splittingInToSections + ' sections. Are you sure you want to split the section?');

		if (!splitting_selected_section && confirmmm) {
			$('#splitSection').val('Splitting Selected Section...');
			splitting_selected_section = true;
			return true;
		} else {
			return false;
		}

	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>
