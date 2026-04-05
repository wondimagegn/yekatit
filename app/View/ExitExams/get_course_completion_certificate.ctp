<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class=" icon-print" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Course Completion Certificate Printing'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<?= $this->Form->Create('ExitExam'); ?>
				<div style="margin-top: -30px;">
                    <hr>
                    <blockquote>
						<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
						<p style="text-align:justify;">
							<span class="fs16">This tool will help you to mass print course completion certificates for not graduaated students who fulfilled required course work requirement for graduation but FAILED National Exit Exam.
							<br> <i class="rejected">You can directly search by Student Name/ID to check for student's course completion certificate eligibility form all applicable exam dates or If you have transfered students from other universities which have exempted or transfered courses.</i>
						</p>
					</blockquote>
					<hr>

                    <!-- <div class="warning-box warning-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span>This tool is still under development and might include students that don't completed the requirement for graduation but took exit exam. <b class="rejected fs16">You're required to identify and select only students who completed the required requirements for graduation!!</b></div>
                    <hr> -->

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
						<fieldset style="padding-bottom: 5px;padding-top: 25px;">
							<!-- <legend>&nbsp;&nbsp; Search Filters &nbsp;&nbsp;</legend> -->
							<div class="row">
								<div class="large-3 columns">
									<?= $this->Form->input('exam_date', array('id' => 'exam_date_1', 'label' => 'Exam Date: ','required', 'default' => (!empty($exam_date) ? array_keys($exam_date)[0] : ''), 'style' => 'width:90%;', 'options' => $exam_date)); ?>
								</div>
								<div class="large-3 columns">
									<?= $this->Form->input('program_id', array('id' => 'program_id_1', 'label' => 'Program: ', 'required', /*  'empty' => '[ All Programs ]', */ 'style' => 'width:90%;')); ?>
								</div>
								<div class="large-3 columns">
									<?= $this->Form->input('program_type_id', array('label' => 'Program Type: ', /* 'required', */ 'empty' => '[ Assigned Program Types ]', 'style' => 'width:90%;')); ?>
								</div>
								<div class="large-3 columns">
									<?php // $this->Form->input('Search.limit', array('id' => 'limit ', 'type' => 'number', 'min' => '100',  'max' => '1000', 'value' => $limit, 'step' => '100', 'label' => ' Limit: ', 'style' => 'width:90%;')); ?>
								</div>
							</div>
							<div class="row">
								<div class="large-6 columns">
									<?= $this->Form->input('department_id', array('empty' => '[ All Assigned Departments ]', 'id' => 'department_id_1', /* 'required', */ 'onchange' => 'updateSection(1)', 'label' => 'Department:', 'style' => 'width:95%;')); ?>
								</div>
								<div class="large-3 columns">
									<?= $this->Form->input('section_id', array('id' => 'section_id_1', 'empty' => '[ Select/Leave Section ]', 'label' => 'Section: ', 'style' => 'width:90%;')); ?>
								</div>
								<div class="large-3 column">
									<?= $this->Form->input('name_or_id', array('id' => 'name_or_id', 'label' => 'Student Name/ID: ', 'type' => 'text', 'placeholder' => 'Student ID or name..',  'style' => 'width:90%;')); ?>
								</div>
							</div>
							<hr>
							<?= $this->Form->submit(__('List Students'), array('name' => 'getStudents', 'id' => 'getStudents',  'div' => false, 'class' => 'tiny radius button bg-blue')); ?>
						</fieldset>
					</div>
				</div>
				<hr>

                <div id="show_search_results">
                    <div id="dialog-modal" title="Academic Profile "></div>

                    <?php
                    /* if (!empty($exitExams)) { ?>
                        <h6 class="fs14 text-gray">Please select student(s) for whom you want to prepare a course completion certificate.</h6>
                        <h6 id="validation-message_non_selected" class="text-red fs14"></h6>
                        <br>
                        <div style="overflow-x:auto;">
                            <table cellpadding="0" cellspacing="0" class="table">
                                <thead>
                                    <tr>
                                        <td class="center" style="width:4%"><div style="margin-left: 15%;"><?= $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'label' => false)); ?></div></td>
                                        <td class="center" style="width:4%">#</td>
                                        <td class="vcenter">Student Name</td>
                                        <td class="center">Student ID</td>
                                        <td class="center">Department</td>
                                        <td class="center">Program Type</td>
                                        <td class="center">Exam Date</td>
                                        <td class="center">Result</td>
                                        <td class="center">Latest Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $st_count = 0;
                                    $counter = 1;
                                    foreach ($exitExams as $exitExam) { ?>
                                        <tr>
                                            <td class="center">
                                                <div style="margin-left: 20%;"><?= $this->Form->input('ExitExam.' . $st_count . '.gp', array('type' => 'checkbox', 'label' => false, 'class' => 'checkbox1', 'id' => 'Student' . $st_count)); ?></div>
                                                <?= $this->Form->input('ExitExam.' . $st_count . '.student_id', array('type' => 'hidden', 'value' => $exitExam['Student']['id'])); ?>
                                            </td>
                                            <td class="center"><?= $counter++; ?></td>
                                            <td class='jsView vcenter' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?= $exitExam['Student']['id']; ?>"><?= $exitExam['Student']['full_name']; ?></td>
                                            <td class="center"><?= $exitExam['Student']['studentnumber']; ?></td>
                                            <td class="center"><?= $exitExam['Student']['Department']['name']; ?></td>
                                            <td class="center"><?= $exitExam['Student']['ProgramType']['name']; ?></td>
                                            <td class="center"><?= (!empty($exitExam['ExitExam']['exam_date']) ? $this->Time->format("M j, Y", $exitExam['ExitExam']['exam_date'], NULL, NULL) : 'N/A');  ?></td>
                                            <td class="center"><?= $exitExam['ExitExam']['result']; ?></td>
                                            <td class="center"><?= (isset($exitExam['Student']['StudentExamStatus'][0]['academic_year']) && !empty($exitExam['Student']['StudentExamStatus'][0]['academic_year']) ? $exitExam['Student']['StudentExamStatus'][0]['academic_year'] .'-' . $exitExam['Student']['StudentExamStatus'][0]['semester']  : 'N/A'); ?></td>
                                        </tr>
                                        <?php
                                        $st_count++; 
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <br>

                        <hr>
                        <?= $this->Form->submit(__('Get Course Completion Certificate'), array('name' => 'getcourseCompletionPDF', 'id' => 'getcourseCompletionPDF',  'div' => false, 'class' => 'tiny radius button bg-blue')); ?>
                        <?php
                    }  */?>

					<?php
					if (isset($exitExamsAsSenateList) && !empty($exitExamsAsSenateList)) {

						$eligible_students_count = 0;
						$count = 1;

						foreach ($exitExamsAsSenateList as $c_id => $students) { ?>
							<table cellpadding="0" cellspacing="0" class="table">
								<tbody>
									<tr>
										<td style="width:22%" class="vcenter"><span class="text-gray">Department: </span>&nbsp; <?= $students[0]['Department']['name']; ?></td>
									</tr>
									<tr>
										<td class="vcenter"><span class="text-gray">Degree Designation: </span>&nbsp; <?= $students[0]['Curriculum']['english_degree_nomenclature']; ?>  &nbsp; &nbsp; &nbsp; &nbsp; <a href="/curriculums/view/<?=$students[0]['Curriculum']['id']; ?>" target="_blank">(Open Curriculum Details)</a></td>
									</tr>
									<tr>
										<td class="vcenter"><span class="text-gray">Required <?= (!isset($students[0]['Curriculum']['id']) ? 'Credit' : (count(explode('ECTS', $students[0]['Curriculum']['type_credit'])) >= 2 ? 'ECTS' : 'Credit')); ?> for Graduation: </span>&nbsp; <?= $students[0]['Curriculum']['minimum_credit_points']; ?></td>
									</tr>
								</tbody>
							</table>
							<br>

							<div style="overflow-x:auto;">
								<table cellpadding="0" cellspacing="0" class="table student_list">
									<thead>
										<tr>
											<td style="width:4%" class="center"><div style="margin-left: 5%;"><?= $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'label' => false)); ?></div></td>
											<td style="width:4%" class="center">#</td>
											<td style="width:25%" class="vcenter">Student Name</td>
											<td style="width:5%" class="center">Sex</td>
											<td style="width:13%" class="center">Student ID</td>
											<td style="width:15%" class="center">Program Type</td>
											<td style="width:13%" class="center"><?= (!isset($students[0]['Curriculum']['id']) ? 'Credit' : (count(explode('ECTS', $students[0]['Curriculum']['type_credit'])) >= 2 ? 'ECTS' : 'Credit')); ?> Taken</td>
											<td style="width:10%" class="center">CGPA</td>
											<td style="width:10%" class="center">MCGPA</td>
										</tr>
									</thead>
									<tbody>
										<?php
										$s_count = 1;
										foreach ($students as $key => $student) {
											if ($key == 0) {
												continue;
											} ?>
											<tr style="color:<?= (empty($student['disqualification']) ? 'green' : 'red'); ?>"  class="center">
												<?php
												if (!empty($student['disqualification'])) { ?>
													<td style="background-color:white" onclick="toggleView(this)" id="<?= $count; ?>" class="center">
														<div style="margin-left: 10%;"><?= $this->Html->image('plus2.gif', array('id' => 'i' . $count, 'div' => false, 'align' => 'left')); ?> ? </div>
													</td>
													<?php
												} else { ?>
													<td style="background-color:white" class="center">
														<?= $this->Form->input('ExitExam.' . $count . '.student_id', array('type' => 'hidden', 'value' => $student['Student']['id'])); ?>
														<div style="margin-left: 10%;"><?= $this->Form->input('ExitExam.' . $count . '.gp', array('type' => 'checkbox', 'label' => false, 'class' => 'checkbox1', 'id' => 'Student' . $count)); ?></div>
													</td>
													<?php
													$eligible_students_count++;
												} ?>
												<td style="background-color:white" class="center"><?= $s_count++; ?></td>
												<td style="background-color:white" class="vcenter"><?= $this->Html->link(__($student['Student']['full_name']), array('controller' => 'students', 'action' => 'student_academic_profile', $student['Student']['id']), array('target' => '_blank', 'style' => 'font-weight:normal; color:' . (empty($student['disqualification']) ? 'green' : 'red'))); ?></td>
												<td style="background-color:white" class="center"><?= (strcasecmp(trim($student['Student']['gender']), 'male') == 0 ? 'M' :(strcasecmp(trim($student['Student']['gender']), 'female') == 0 ? 'F' : trim($student['Student']['gender']))); ?></td>
												<td style="background-color:white" class="center"><?= $student['Student']['studentnumber']; ?></td>
												<td style="background-color:white;" class="center"><?= ($student['Student']['program_type_id'] != PROGRAM_TYPE_REGULAR ? '<span style="font-weight: bold">' . $student['ProgramType']['name'] .'</span>' : $student['ProgramType']['name']); ?></td>
												<td style="background-color:white" class="center"><?= $student['credit_taken']; ?></td>
												<td style="background-color:white" class="center"><b><?= $student['cgpa']; ?></b></td>
												<td style="background-color:white" class="center"><?= $student['mcgpa']; ?></td>
											</tr>
											<?php
											if (!empty($student['disqualification'])) { ?>
												<tr id="c<?= $count; ?>" style="display:none">
													<td style="background-color:white">&nbsp;</td>
													<td colspan="8" style="background-color:white;">
														<ol>
															<?php
															foreach ($student['disqualification'] as $d_key => $disqualification) {
																echo '<li>' . $disqualification . '</li>';
															} ?>
														</ol>
													</td>
												</tr>
												<?php
											}
											$count++;
										} ?>
									</tbody>
								</table>
							</div>
							<hr>
							<?php
						}

						echo $this->Form->submit(__('Get Course Completion Certificate'), array('name' => 'getcourseCompletionPDF', 'id' => 'getcourseCompletionPDF',  (empty($eligible_students_count) ? 'disabled': ''), 'div' => false, 'class' => 'tiny radius button bg-blue'));

					} else if (!empty($exitExams)) { ?>
                        <div style="overflow-x:auto;">
                            <table cellpadding="0" cellspacing="0" class="table">
                                <thead>
                                    <tr>
                                        <td class="center" style="width:4%">#</td>
                                        <td class="vcenter">Student Name</td>
                                        <td class="center">Student ID</td>
                                        <td class="center">Department</td>
                                        <td class="center">Program Type</td>
                                        <td class="center">Exam Date</td>
                                        <td class="center">Result</td>
                                        <td class="center">Latest Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $st_count = 0;
                                    $counter = 1;
                                    foreach ($exitExams as $exitExam) { ?>
                                        <tr>
                                            <td class="center"><?= $counter++; ?></td>
                                            <td class='jsView vcenter' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?= $exitExam['Student']['id']; ?>"><?= $exitExam['Student']['full_name']; ?></td>
                                            <td class="center"><?= $exitExam['Student']['studentnumber']; ?></td>
                                            <td class="center"><?= $exitExam['Student']['Department']['name']; ?></td>
                                            <td class="center"><?= $exitExam['Student']['ProgramType']['name']; ?></td>
                                            <td class="center"><?= (!empty($exitExam['ExitExam']['exam_date']) ? $this->Time->format("M j, Y", $exitExam['ExitExam']['exam_date'], NULL, NULL) : 'N/A');  ?></td>
                                            <td class="center"><?= $exitExam['ExitExam']['result']; ?></td>
                                            <td class="center"><?= (isset($exitExam['Student']['StudentExamStatus'][0]['academic_year']) && !empty($exitExam['Student']['StudentExamStatus'][0]['academic_year']) ? $exitExam['Student']['StudentExamStatus'][0]['academic_year'] .'-' . $exitExam['Student']['StudentExamStatus'][0]['semester']  : 'N/A'); ?></td>
                                        </tr>
                                        <?php
                                        $st_count++; 
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <?php
                    } ?>
                </div>
				
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>

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

	function toggleView(obj) {
		if ($('#c' + obj.id).css("display") == 'none') {
			$('#i' + obj.id).attr("src", '/img/minus2.gif');
		} else {
			$('#i' + obj.id).attr("src", '/img/plus2.gif');
		}
		$('#c' + obj.id).toggle("slow");
	}

	function updateSection(id) {
		var formData = $("#department_id_" + id).val();

		// empty student name or id on department field change
		$("#name_or_id").val('');
		
		if (formData) {
			$("#section_id_" + id).attr('disabled', true);
			$("#department_id_" + id).attr('disabled', true);
			//get form action
			var formUrl = '/sections/get_sections_by_dept_for_exit_exam/' + formData + '/' + $("#program_id_1").val() + '/' + $("#exam_date_1").val();
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data, textStatus, xhr) {
					$("#section_id_" + id).attr('disabled', false);
					$("#department_id_" + id).attr('disabled', false);
					$("#section_id_" + id).empty();
					$("#section_id_" + id).append(data);
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});
			return false;
		} else {
			$("#section_id_1" + id).empty().append('<option value="">[ Select Department ]</option>');
		}
	}

    var search_button_clicked = false;

    $("#show_search_results").show();

    $('#getStudents').click(function(event) {

        let formIsValid = true;

        if (search_button_clicked) {
            alert('Looking for students, please wait a moment...');
            $('#getStudents').attr('disabled', true);
			formIsValid = false;
            return false;
        }

		if (!formIsValid) {
            event.preventDefault();
            formIsValid = false;
            return false;
        }

        if (!search_button_clicked && formIsValid) {
        
            search_button_clicked = true;

            $('#getStudents').val('Looking for Students...');

            if ($('#show_search_results').length) {
                $("#show_search_results").hide();
            }

            if ($('#getcourseCompletionPDF').length) {
                $("#getcourseCompletionPDF").attr('disabled', true);
            }

            if ($('#select-all').length) {
                $("#select-all").prop('checked', false);
            }

            $('input[type="checkbox"][name^="data[ExitExam]"]').each(function() {
                const namePatternSelected = /data\[ExitExam\]\[\d+\]\[gp\]/;
                if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
                    $(this).prop('checked', false);
                }
            });
        }
	});

    var generating_ceriificate = false;

	const validationMessageNonSelected = document.getElementById('validation-message_non_selected');

    $('#getcourseCompletionPDF').click(function() {
		var isValid = true;

		let selectedStudentCount = 0;

        $('input[type="checkbox"][name^="data[ExitExam]"]').each(function() {
            const namePatternSelected = /data\[ExitExam\]\[\d+\]\[gp\]/;
            if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
                selectedStudentCount++;
            }
        });

        if (!selectedStudentCount) {
            alert('At least one student must be selected for selected to print course completion certificate.');
            validationMessageNonSelected.innerHTML = 'At least one student must be selected for selected to print course completion certificate.';
           	var isValid = true;
			return false;
        }

		if (generating_ceriificate) {
			alert('Generating course completion certificates, please wait a moment...');
			$('#getcourseCompletionPDF').attr('disabled', true);
			isValid = false;
			return false;
		}

		if (!generating_ceriificate && isValid) {
			$('#getcourseCompletionPDF').val('Generating Course Completion Certificates...');
			generating_ceriificate = true;
			isValid = true
			return true;
		} else {
			return false;
		}
	});

	/* if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	} */
</script>