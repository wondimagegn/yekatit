<?php 
if (!empty($otherAdds)) { ?>
    <h6 class="fs14 text-gray">Select courses you want to add</h6>
	<h6 id="validation-message_non_selected2" class="text-red fs14"></h6>
    <br>
	<div style="overflow-x:auto;">
		<table id="fieldsForm" cellspacing="0" cellpadding="2" class="table">
			<thead>
				<tr>
					<th class="center" style="width: 5%;">&nbsp;</th>
					<th class="center" style="width: 3%;">#</th>
					<th class="vcenter">Course Title</th>
					<th class="center">Course Code</th>
					<th class="center">Credit</th>
					<th class="center">Grade</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$count = 1;
				$button_visible = 0;

				$failed_prequisite = 0;
                $already_taken_courses = 0;

				foreach ($otherAdds as $pk => $pv) {
					if ($pv['already_added'] == 0) { ?>
						<tr>
							<td class="center"><div style="margin-left: 20%;"><?= $this->Form->input('CourseAdd.' . $count . '.gp', array('type' => 'checkbox', 'class' => 'checkbox1', 'label' => false, 'id' => 'StudentSelection' . $count)); ?></div></td>
							<td class="center"><?= $count; ?></td>
							<td class="vcenter"><?= $pv['Course']['course_title']; ?></td>
							<td class="center"><?= $pv['Course']['course_code']; ?></td>
							<td class="center"><?= $pv['Course']['credit']; ?></td>
							<?php
							$button_visible++;
					} else {
						if (isset($pv['prerequiste_failed']) && $pv['prerequiste_failed'] == 1) { ?>
							<tr>
								<td class="center" style="color:red;">--</td>
								<td class="center" style="color:red;"><?= $count; ?></td>
								<td class="vcenter" style="color:red;"><?= $pv['Course']['course_title']; ?></td>
								<td class="center" style="color:red;"><?= $pv['Course']['course_code']; ?></td>
								<td class="center" style="color:red;"><?= $pv['Course']['credit']; ?></td>
								<?php
								$failed_prequisite++;
						} else { ?>
							<tr>
								<td class="center" style="color:green;">**</td>
								<td class="center" style="color:green;"><?= $count; ?></td>
								<td class="vcenter" style="color:green;"><?= $pv['Course']['course_title']; ?></td>
								<td class="center" style="color:green;"><?= $pv['Course']['course_code']; ?></td>
								<td class="center" style="color:green;"><?= $pv['Course']['credit']; ?></td>
								<?php
								$already_taken_courses++;
						}
					
					} ?>
					
						
						<td class="center">
							<?php
							if ($pv['already_added'] == 0) {

								$gradeList = array();

								if (isset($pv['Course']['GradeType']['Grade']) && !empty($pv['Course']['GradeType']['Grade'])) {
									foreach ($pv['Course']['GradeType']['Grade'] as $key => $value) {
										$gradeList[$value['grade']] = $value['grade'];
									}
								}

								$gradeList['NG'] = 'NG';
								$gradeList['I'] = 'I';
								$gradeList['W'] = 'W';
								$gradeList['DO'] = 'DO';

								echo $this->Form->input('CourseAdd.' . $count . '.student_id', array('type' => 'hidden', 'value' => $addParamaterss['student_id']));
								echo $this->Form->input('CourseAdd.' . $count . '.semester', array('type' => 'hidden', 'value' => $addParamaterss['semester']));
								echo $this->Form->input('CourseAdd.' . $count . '.academic_year', array('type' => 'hidden', 'value' => $pv['PublishedCourse']['academic_year']));
								echo $this->Form->input('CourseAdd.' . $count . '.section_id', array('type' => 'hidden', 'value' => $pv['PublishedCourse']['section_id']));
								echo $this->Form->input('CourseAdd.' . $count . '.published_course_id', array('type' => 'hidden', 'value' => $pv['PublishedCourse']['id']));
								echo $this->Form->input('CourseAdd.' . $count . '.year_level_id', array('type' => 'hidden', 'value' => $pv['PublishedCourse']['year_level_id']));
								echo $this->Form->hidden('CourseAdd.' . $count . '.grade_scale_id', array('value' => $pv['PublishedCourse']['grade_scale_id']));
								echo $this->Form->hidden('CourseAdd.' . $count . '.department_approval', array('value' => 1));
								echo $this->Form->hidden('CourseAdd.' . $count . '.registrar_confirmation', array('value' => 1)); ?>

								<div style="margin-top: 10px;">
									<?= $this->Form->input('CourseAdd.' . $count . '.grade', array('label' => false, 'style' => 'width: 70%;', 'type' => 'select', 'options' => $gradeList, 'empty' => '[ Select ]')); ?>
								</div>
								<?php
							} else  { ?>
								<!-- Display Existing Grade -->
								 ---
								<?php
							} ?>
						</td>
					</tr>
					<?php
					$count++;
				} ?>
			</tbody>
			<?php
            if ($failed_prequisite || $already_taken_courses) { ?>
                <tfoot>
                    <tr>
                        <td class="hcenter"><?= ($already_taken_courses != 0 ? '**' : ''); ?></td>
                        <td colspan=5>
                            <span class="fs14" style="margin-bottom: 5px; font-weight: normal;">
                                <?= ($already_taken_courses != 0 ? 'Green colored courses: you have already registred or taken the course and got pass grade, you don\'t need to add again.' . ($failed_prequisite != 0 ? '<br>' : '') : ''); ?>
                                <?= ($failed_prequisite != 0 ? 'Red colored courses: prerequiste course requirement not fullfilled.' : ''); ?>
                            </span>
                        </td>
                    </tr>
                </tfoot>
                <?php
            } ?>
		</table>
	</div>
	<hr>
	<?php
	if ($button_visible > 0) {
		//echo $this->Form->end('Add Selected');
		echo $this->Form->submit('Add Course & Grade', array('id' => 'add_button_disable', 'class' => 'tiny radius button bg-blue', 'div' => false, 'name' => 'addCoursesGrade'));
	}
} else { ?>
	<div class="info-box info-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span>There is no published course by the selected criteria.</div>
	<?php
} ?>

<script type="text/javascript">

	var form_being_submitted = false;
	var submitButtonUsedBefore = false;

	var maxCoursesAllowedPerSemester = '<?= MAXIMUM_COURSES_TO_ADD_PER_SEMESTER; ?>';

	const validationMessageNonSelected = document.getElementById('validation-message_non_selected2');

	$('#add_button_disable').click(function() {
		
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
		var selectedCount = Array.prototype.slice.call(checkboxes).filter(x => x.checked).length;

		//alert(checkedOne);
		//alert (selectedCount);

		if (!checkedOne) {
			alert('At least one course must be selected to add.');
			validationMessageNonSelected.innerHTML = 'At least one course must be selected to add.';
			return false;
		} else if (selectedCount > maxCoursesAllowedPerSemester) {
			alert('Only ' + maxCoursesAllowedPerSemester + ' courses are allowed to add per semester. Please uncheck any course from your current selection and only select ' + maxCoursesAllowedPerSemester + ' courses to add.');
			validationMessageNonSelected.innerHTML = 'Only ' + maxCoursesAllowedPerSemester + ' courses are allowed to add per semester. Please uncheck any course from your current selection and only select ' + maxCoursesAllowedPerSemester + ' courses to add.';
			return false;
		}

		let nonEmptyGradeCount = 0;
		let nonEmptySelectedCount = 0;

		$('select[name^="data[CourseAdd]"]').each(function() {
			const namePatternGrade = /data\[CourseAdd\]\[\d+\]\[grade\]/;
			if (namePatternGrade.test($(this).attr('name')) && $(this).val()) {
				nonEmptyGradeCount++;
			}
		});

		$('input[type="checkbox"][name^="data[CourseAdd]"]').each(function() {
			const namePatternSelected = /data\[CourseAdd\]\[\d+\]\[gp\]/;
			if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
				nonEmptySelectedCount++;
			}
		});

		//alert(nonEmptyGradeCount);
		//alert(nonEmptySelectedCount);

		var course_lebel = (nonEmptySelectedCount > 1 ? 'course adds' : 'course add');
		var grade_lebel = (nonEmptyGradeCount > 1 ? 'grades' : 'grade');

		if (nonEmptyGradeCount != nonEmptySelectedCount) {
			//event.preventDefault(); // Prevent form submission
			isValid = false;
            alert('You have selected ' + nonEmptySelectedCount + ' ' + course_lebel + ' but selected ' + nonEmptyGradeCount + ' ' + grade_lebel + ', please correct your selection.');
			validationMessageNonSelected.innerHTML = 'You have selected ' + nonEmptySelectedCount + ' ' + course_lebel + ' but selected ' + nonEmptyGradeCount + ' ' + grade_lebel + ', please correct your selection.';
			return false;
		}

		if (form_being_submitted && !submitButtonUsedBefore) {
			alert("Processing the selected course add and grade entry, please wait a moment...");
			$('#add_button_disable').attr('disabled', true);
			submitButtonUsedBefore = true;
			return false;
		} 
		
		if (submitButtonUsedBefore) {
			$('#add_button_disable').val('Refresh Page');
			$('#add_button_disable').attr('disabled', true);
		}

		var confirmm = confirm('You are about to add ' + nonEmptyGradeCount + ' ' + course_lebel +  ' and ' + grade_lebel + ' for the selected student. Are you sure you want to add the selected ' + course_lebel +  ' and ' + grade_lebel + '?');

		if (confirmm && !form_being_submitted) {
			$('#add_button_disable').val('Processing Selected Course Adds & Grade...');
			form_being_submitted = true;
			submitButtonUsedBefore = true;
			return true;
		} else {
			return false;
		}

	});

	if (form_being_submitted || submitButtonUsedBefore) {
		$('#add_button_disable').val('Refresh Page');
		$('#add_button_disable').attr('disabled', true);
	}

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
	
</script>
