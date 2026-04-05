<?php
	$enableDisplayExport = 0;

	//isset($distributionStatistics) ? debug($distributionStatistics) : '';

	if (isset($distributionStatistics['distributionStatsTeachersByGender']) && !empty($distributionStatistics['distributionStatsTeachersByGender'])) {
		$enableDisplayExport = 1;
	} else if (!empty($distributionStatistics['distributionStatsTeachersByAcademicRank'])) {
		$enableDisplayExport = 1;
	} else if (!empty($distributionStatistics['getDistributionStatsTeacherToStudents'])) {
		$enableDisplayExport = 1;
	} else if (isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) {
		$enableDisplayExport = 1;
	}
?>

<div class="box" ng-app="generalReport">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-chart-outline" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= 'Staff General Reports'; ?></span>
		</div>
	</div>
	<div class="box-body" ng-controller="reportCntrl">
		<div class="row">
			<div class="large-12 columns">

				<?= $this->Form->create('Staff'); ?>
				<div class="form">
					<?php
                    if (isset($headerLabel) && !empty($headerLabel)) {
                        $this->assign('title_details', (!empty($this->request->params['controller']) ? ' ' . Inflector::humanize(Inflector::underscore($this->request->params['controller'])) . (!empty($this->request->params['action']) && $this->request->params['action'] != 'index' ? ' | ' . ucwords(str_replace('_', ' ', $this->request->params['action'])) : '') : '') . ' - ' . $headerLabel);
                    } ?>

                    <div style="margin-top: -30px;"><hr></div>

                    <blockquote>
                        <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                        <span style="text-align:justify;" class="fs16 text-black">This tool will help you to get some predefined staff reports by providing some search criteria.</span> 
                    </blockquote>
                    <hr>

					<div onclick="toggleViewFullId('ListPublishedCourse')">
						<?php
						if ($enableDisplayExport || !empty($attrationRate) || !empty($student_lists) || !empty($resultBy)) {
							echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
							<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt"> Display Filter</span>
							<?php
						} else {
							echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
							<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span>
							<?php
						} ?>
					</div>

					<div id="ListPublishedCourse" style="display:<?= ($enableDisplayExport ? 'none' : 'display'); ?>">

						<fieldset style="margin-bottom: 0px;">
                            <legend>&nbsp;&nbsp; Search Filters &nbsp;&nbsp;</legend>

                            <div class="row align-items-center">
                                <div class="large-6 columns">
                                    <?= $this->Form->input('report_type', array('label' => 'Report Type: ', 'type' => 'select', 'style' => 'width:90%;', 'div' => false, 'empty' => 'Select Report Type', 'onchange' => 'toggleFields()', 'options' => $report_type_options, 'id' => 'reportType', 'required' => 'required')); ?>
                                </div>
                                <div class="large-6 columns">
                                    &nbsp;
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="large-6 columns">
                                    <?= $this->Form->input('department_id', array('class' => 'fs14', 'style' => 'width:90%;', 'label' => 'College / Department: ', 'type' => 'select', 'options' => $departments, 'default' => $default_department_id)); ?>
                                </div>
								<div class="large-3 columns">
                                    <div class='gender' style='display:display;'>
										<?= $this->Form->input('gender', array('id' => 'Gender', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:80%;', 'label' => 'Sex: ', 'options' => array('all' => 'All', 'female' => 'Female', 'male' => 'Male'))); ?>
                                    </div>
                                </div>
                                <div class="large-3 columns">
									<?php
									if (isset($this->data['Staff']['report_type']) && ($this->data['Staff']['report_type'] == 'distributionStatsGenderTeachersByGender' || $this->data['Staff']['report_type'] == 'distributionStatsByAcademicRank' || $this->data['Staff']['report_type'] == 'distributionStatsByStudents')) { ?>
										<div class='visibleOnDistribution' style='display:display;'>
											<?= $this->Form->input('graph_type', array('label' => 'Graph Type: ','style' => 'width:80%;', 'type' => 'select', 'div' => false, 'options' => $graph_type, 'default' => 'bar')); ?>
										</div>
										<?php
									} else { ?>
										<div class='visibleOnDistribution' style='display:none;'>
											<?= $this->Form->input('graph_type', array('label' => 'Graph Type: ', 'style' => 'width:80%;', 'type' => 'select', 'div' => false, 'options' => $graph_type, 'default' => 'bar')); ?>
										</div>
										<?php
									} ?>
                                </div>
                            </div>
							<hr>
                            <?= $this->Form->submit(__('Get Report', true), array('name' => 'getReport', 'id' => 'getReport', 'div' => false, 'class' => 'tiny radius button bg-blue')); ?>
						</fieldset>
					</div>
				</div>

				<div id="show_report_details">
					<?php
					if ($enableDisplayExport == 1) {
						echo '<hr>' . $this->Form->submit(__('Export Report to Excel', true), array('name' => 'getReportExcel', 'id' => 'getReportExcel1', 'div' => false, 'class' => 'tiny radius button bg-blue', 'onclick' => '')) . '<hr>';
					} ?>

					<?php
					if (!empty($headerLabel)) {
						echo '<h6 class"fs10 text-gray">'. $headerLabel . '</h6><hr>';
					}

					if (isset($distributionStatistics['distributionStatsTeachersByGender']) && !empty($distributionStatistics['distributionStatsTeachersByGender'])) {
						echo $this->element('staffs/distribution_stat');
					} else if (!empty($distributionStatistics['distributionStatsTeachersByAcademicRank'])) {
						echo $this->element('staffs/distribution_academicrank_stat');
					} else if (!empty($distributionStatistics['getDistributionStatsTeacherToStudents'])) {
						echo $this->element('staffs/distribution_teachertostudent_stat');
					} else if (isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) {
						echo $this->element('staffs/active_staff_list');
					} else { ?>
						<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>There is no report in the selected criteria</div>
						<?php
					} 

					if ($enableDisplayExport == 1 ) {
						echo '<hr>' . $this->Form->submit(__('Export Report to Excel', true), array('name' => 'getReportExcel', 'id' => 'getReportExcel2', 'div' => false, 'class' => 'tiny radius button bg-blue', 'onclick' => ''));
					} ?>
				</div>

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

	function toggleFields(id) {
		if ($('#reportType').val() == 'attrition_rate') {
			$(".notVisibleOnAttritionRate ").hide();
			$('.visibleOnDistribution').show();
		} else if (($('#reportType').val() == 'distributionStatsGenderTeachersByGender' || $('#reportType').val() == 'distributionStatsByAcademicRank' || $('#reportType').val() == 'distributionStatsByStudents')) {
			$('.visibleOnDistribution').show();
		} else {
			$('.visibleOnDistribution').hide();
			$(".notVisibleOnAttritionRate ").hide();
			$('.visibleOnDistribution').hide();
		}
	}

	var selected_report_type = '';

    if ($("#reportType").val() != '') {
        selected_report_type = $("#reportType option:selected").text();
    }

	$(document).ready(function() {

		if ($('#reportType').val() == 'attrition_rate') {
			$(".notVisibleOnAttritionRate ").hide();
			$('.visibleOnDistribution').show();
		} else if (($('#reportType').val() == 'distributionStatsGenderTeachersByGender' ||$('#reportType').val() == 'distributionStatsByAcademicRank' || $('#reportType').val() == 'distributionStatsByStudents')) {
			$('.visibleOnDistribution').show();
		} else {
			$('.visibleOnDistribution').hide();
			$(".notVisibleOnAttritionRate ").hide();
			$('.visibleOnDistribution').hide();
		}

		if ($("#reportType").val() != '') {
            selected_report_type = $("#reportType option:selected").text()
            $("#getReportExcel1").val('Export ' + selected_report_type + ' Report to Excel');
            $("#getReportExcel2").val('Export ' + selected_report_type + ' Report to Excel');
        }

		var get_report_button_clicked = false;

		$('#getReport').click(function(event) {
			
			var isValid = true;

			$('#show_report_details').hide();
			$('#getReportExcel1').attr('disabled', true);
			$('#getReportExcel2').attr('disabled', true);

			if ($("#reportType").val() == '') {
				$("#reportType").focus();
				isValid = false;
				return false;
			} else {
				selected_report_type = $("#reportType option:selected").text()
			}

			if (get_report_button_clicked) {
				alert('Generating ' + selected_report_type + ', please wait a moment...');
				$('#getReport').attr('disabled', true);
				$("#getReportExcel1").attr('disabled', true);
				$("#getReportExcel2").attr('disabled', true);
				isValid = false;
				return false;
			}

			if (!get_report_button_clicked && isValid) {
				$('#getReport').val('Generating ' + selected_report_type + '...');
				get_report_button_clicked = true;
				isValid = true
				return true;
			} else {
				get_report_button_clicked = false;
				return false;
			}
		});


		var export_report_button_clicked = false;
		var isValid2 = true;

		// get Report button at the begining of the page

		$("#getReportExcel1").click(function(event) {

			// Submit the form, After submitting, disable form elements & Set timeout to 0 to ensure it runs immediately after form submission
			$('#getReport').attr('disabled', false);
			$("#getReportExcel1").attr('disabled', false);
			$("#getReportExcel2").attr('disabled', false);

			if (export_report_button_clicked) {

				$('#getReport').attr('disabled', true);
				$("#getReportExcel1").attr('disabled', true);
				$("#getReportExcel2").attr('disabled', true);

				if (!isValid2) {
					alert('Still Processing ' + selected_report_type + ' for Excel Export...');
					$('#getReportExcel1').val('Still Processing ' + selected_report_type + ' for Excel Export...');
					$('#getReportExcel2').val('Still Processing ' + selected_report_type + ' for Excel Export...');
				}

				setTimeout(function() {
					$("input, select, textarea, button").prop("disabled", false);

					if (isValid2) {
						$("#getReportExcel1").val('Export ' + selected_report_type + ' Report to Excel');
						$("#getReportExcel2").val('Export ' + selected_report_type + ' Report to Excel');
					} else {
						$("#getReportExcel1").val('Refresh Report to Export ' + selected_report_type + ' to Excel again');
						$("#getReportExcel2").val('Refresh Report to Export ' + selected_report_type + ' to Excel again');
					}
				}, 5000);

				isValid2 = false;
				return false;
			}

			if (!export_report_button_clicked && isValid2) {

				$('#getReport').attr('disabled', true);

				$("form").submit();

				setTimeout(function() {
					$("input, select, textarea, button").prop("disabled", true);
					$('#getReportExcel1').val('Processing ' + selected_report_type + ' for Excel Export...');
					$('#getReportExcel2').val('Processing ' + selected_report_type + ' for Excel Export...');
				}, 0); 
				
				// Assuming the file save dialog appears within a few seconds after form submission, Re-enable form elements after a delay
				setTimeout(function() {
					$("input, select, textarea, button").prop("disabled", false);
					$("#getReportExcel1").val('Export ' + selected_report_type + ' Report to Excel');
					$("#getReportExcel2").val('Export ' + selected_report_type + ' Report to Excel');
				}, 5000); // Adjust the delay as needed (in milliseconds, 5 seconds);

				export_report_button_clicked = true;
				isValid2 = true
				return true;
			} else {
				$('#getReport').attr('disabled', false);
				isValid2 = false;
				$("#getReportExcel1").attr('disabled', true);
				$("#getReportExcel2").attr('disabled', true);
				//return false;
			}
		});

		// get Report button at the bottom of the page

		$("#getReportExcel2").click(function(event) {

			// Submit the form, After submitting, disable form elements & Set timeout to 0 to ensure it runs immediately after form submission
			$('#getReport').attr('disabled', false);
			$("#getReportExcel1").attr('disabled', false);
			$("#getReportExcel2").attr('disabled', false);

			if (export_report_button_clicked) {

				$('#getReport').attr('disabled', true);
				$("#getReportExcel1").attr('disabled', true);
				$("#getReportExcel2").attr('disabled', true);

				if (!isValid2) {
					alert('Still Processing ' + selected_report_type + ' for Excel Export...');
					$('#getReportExcel1').val('Still Processing ' + selected_report_type + ' for Excel Export...');
					$('#getReportExcel2').val('Still Processing ' + selected_report_type + ' for Excel Export...');
				}

				setTimeout(function() {
					$("input, select, textarea, button").prop("disabled", false);
					if (isValid2) {
						$("#getReportExcel1").val('Export ' + selected_report_type + ' Report to Excel');
						$("#getReportExcel2").val('Export ' + selected_report_type + ' Report to Excel');
					} else {
						$("#getReportExcel1").val('Refresh Report to Export ' + selected_report_type + ' to Excel again');
						$("#getReportExcel2").val('Refresh Report to Export ' + selected_report_type + ' to Excel again');
					}
				}, 5000);

				isValid2 = false;
				return false;
			}

			if (!export_report_button_clicked && isValid2) {

				$('#getReport').attr('disabled', true);

				$("form").submit();

				setTimeout(function() {
					$("input, select, textarea, button").prop("disabled", true);
					$('#getReportExcel1').val('Processing ' + selected_report_type + ' for Excel Export...');
					$('#getReportExcel2').val('Processing ' + selected_report_type + ' for Excel Export...');
				}, 0); 
				
				// Assuming the file save dialog appears within a few seconds after form submission, Re-enable form elements after a delay
				setTimeout(function() {
					$("input, select, textarea, button").prop("disabled", false);
					$("#getReportExcel1").val('Export ' + selected_report_type + ' Report to Excel');
					$("#getReportExcel2").val('Export ' + selected_report_type + ' Report to Excel');
				}, 5000); // Adjust the delay as needed (in milliseconds, 5 seconds);

				export_report_button_clicked = true;
				isValid2 = true
				return true;
			} else {
				$('#getReport').attr('disabled', false);
				isValid2 = false;
				$("#getReportExcel1").attr('disabled', true);
				$("#getReportExcel2").attr('disabled', true);
				//return false;
			}
		});

		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	});
</script>