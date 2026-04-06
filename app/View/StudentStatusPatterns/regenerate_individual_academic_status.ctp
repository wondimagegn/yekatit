<div class="box">
    <div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-check-outline" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Regenarate Status For a Student'); ?></span>
		</div>
	</div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">

                <?= $this->Form->create('StudentStatusPattern'); ?>

                <div style="margin-top: -30px"><hr></div>

                <blockquote>
					<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
					<p style="text-align:justify;" >
                    <span class="fs14 text-gray" style="font-weight: bold;">
                        This tool will help you to regenerate or correct wrongly generated student academic status. This tool will regenarete status of the student from the begening until the time of regenaration if the student fulfills the minimum required credit defined currently in "General Settings" system wide, as per program and program type. </span>
					</p> 
				</blockquote>
				<hr>

                <div onclick="toggleViewFullId('ListPublishedCourse')" id="toggleShowStudentID">
                    <?php
                    if (isset($alreadyGeneratedStatus) && !empty($alreadyGeneratedStatus)) {
                        echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
                        <span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span>
                        <?php
                    } else {
                        echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
                        <span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span>
                        <?php
                    } ?>
                </div>

                <div id="ListPublishedCourse" style="display:<?= (isset($alreadyGeneratedStatus) ? 'none' : 'display'); ?>">
                    <fieldset style="padding-bottom: 5px;">
                        <legend>&nbsp;&nbsp; Student Number / ID &nbsp;&nbsp;</legend>
                        <div class="row">
                            <div class="large-4 columns">
                                <?= $this->Form->input('Student.studentnumber', array('label' => false, 'placeholder' => 'Type Student ID...', 'id' => 'StudentStudentID', 'required', 'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB)); ?>
                            </div>
                        </div>
                    </fieldset>
                    <?= $this->Form->submit('Get Student Details', array('name' => 'regeneratestudentstatus', 'id' => 'getStudentDetails', 'class' => 'tiny radius button bg-blue', 'div' => 'false')); ?>
                </div>

                <?php
                if (isset($hide_search) && $hide_search) {
                    echo '<div id="showStudentBasicProfile"><hr>';
                    echo $this->element('student_basic');
                    echo '</div>';
                }

                if (isset($alreadyGeneratedStatus) && !empty($alreadyGeneratedStatus)) { ?>
                    <div id="showSearchResults">
                        <div style="overflow-x:auto;">
                            <table id='fieldsForm' cellpadding="0" cellspacing="0" class='table'>
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="center">ACY</th>
                                        <th class="center">Sem</th>
                                        <th class="center">CHS</th>
                                        <th class="center">GPS</th>
                                        <th class="center">MCHS</th>
                                        <th class="center">MGPS</th>
                                        <th class="center">SGPA</th>
                                        <th class="center">CGPA</th>
                                        <th class="center">MCGPA</th>
                                        <th class="center">Status</th>
                                        <th class="center">Date Generated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($alreadyGeneratedStatus as $value) { ?>
                                        <tr>
                                            <td class="center"><?= $counter; ?></td>
                                            <td class="center">
                                                <?= $this->Form->hidden('StudentStatusPattern.' . $value['StudentExamStatus']['id'] . '.id', array('value' => $value['StudentExamStatus']['id'])); ?>
                                                <?= $value['StudentExamStatus']['academic_year']; ?>
                                            </td>
                                            <td class="center"><?= $value['StudentExamStatus']['semester']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['credit_hour_sum']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['grade_point_sum']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['m_credit_hour_sum']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['m_grade_point_sum']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['sgpa']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['cgpa']; ?></td>
                                            <td class="center"><?= $value['StudentExamStatus']['mcgpa']; ?></td>
                                            <td class="center"><?= (isset($value['AcademicStatus']['name']) ? $value['AcademicStatus']['name'] : ''); ?></td>
                                            <td class="center"><?= $this->Time->format("M j, Y g:i A", $value['StudentExamStatus']['modified'], NULL, NULL); ?></td>
                                        </tr>
                                        <?php
                                        $counter++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    </div>
                    <?php
                }

                if (isset($hide_search) && $hide_search) { ?>
                    <div id="regenerateBtnContainer">
                        <?php
                        if (isset($student_section_exam_status['StudentBasicInfo']['id'])) {
                            echo $this->Form->hidden('Student.id', array('value' => $student_section_exam_status['StudentBasicInfo']['id']));
                        }
                        echo $this->Form->submit('Regenerate Student Status', array('name' => 'regenerate', 'id' => 'regenerateStudentStatus', 'disabled' => ((isset($alreadyGeneratedStatus) && !empty($alreadyGeneratedStatus) || (isset($have_registrations) && $have_registrations)) ? false : true),  'div' => 'false', 'class' => 'tiny radius button bg-blue')); ?>
                    </div>
                    <hr>
                    <?php
                } ?>
                
                <?= $this->Form->end(); ?>

            </div>

            <?php
            if (isset($alreadyGeneratedStatus) && !empty($alreadyGeneratedStatus)) { ?>
                <div class="large-12 columns" id="showAdditionalInformation">

                    <?php $showAdditionalInfo = ''; ?>

                    <div onclick="toggleViewFullId('displayAdditionalInfo')">
                        <?=$this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
                        <span style="font-size:10px; vertical-align:top; font-weight:bold" id="showAdditionalInfoTxt">Show/Hide Additional Information (Current Minimum Required Credit/ECTS for Status per Program and Program Type)</span>
                    </div>
                    <br>

                    <div id="displayAdditionalInfo" style="display:none">
                        <div class="large-6 columns">
                            <p style="text-align:justify;" ><span class="fs14 text-black" style="font-weight: bold;">Table: Keys and Descriptions</span></p>
                            <div style="overflow-x:auto;">
                                <table cellpadding="0" cellspacing="0" class='table'>
                                    <thead>
                                        <tr>
                                            <td>Short</td>
                                            <td>Description</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>CHS</td>
                                            <td>Credit Hour Sum</td>
                                        </tr>
                                        <tr>
                                            <td>GPS</td>
                                            <td>Grade Point Sum</td>
                                        </tr>
                                        <tr>
                                            <td>MCHS</td>
                                            <td>Major Credit Hour Sum</td>
                                        </tr>
                                        <tr>
                                            <td>MGPS</td>
                                            <td>Major Grade Point Sum</td>
                                        </tr>
                                        <tr>
                                            <td>SGPA</td>
                                            <td>Semester Grade Point Average</td>
                                        </tr>
                                        <tr>
                                            <td>CGPA</td>
                                            <td>Cummulative Grade Point Average</td>
                                        </tr>
                                        <tr>
                                            <td>MCGPA</td>
                                            <td>Major Cummulative Grade Point Average</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>

                        <div class="large-6 columns">
                            <?php
                            if (isset($generalSettings) && !empty($generalSettings)) { ?>
                                <p style="text-align:justify;" ><span class="fs14 text-black" style="font-weight: bold;">Table: Current Minimum Required Credit/ECTS for Status</span></p>
                                <div style="overflow-x:auto;">
                                    <table cellpadding="0" cellspacing="0" class="table">
                                        <thead>
                                            <tr>
                                                <td>Program</td>
                                                <td>Program Type</td>
                                                <td class="center">Credit</td>
                                                <td class="center">ECTS</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($generalSettings as $generalSetting) { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        foreach ($generalSetting['GeneralSetting']['program_id'] as $key => $value) {
                                                            echo $value . '<br/>';
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        foreach ($generalSetting['GeneralSetting']['program_type_id'] as $key => $value) {
                                                            echo $value . ', ';
                                                        } ?>
                                                    </td>
                                                    <td class="center"><?= $generalSetting['GeneralSetting']['minimumCreditForStatus']; ?></td>
                                                    <td class="center"><?= round(($generalSetting['GeneralSetting']['minimumCreditForStatus'] * CREDIT_TO_ECTS), 0); ?></td>
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
                    </div>
                    <hr>
                </div>
                <?php
            } ?>
        </div>
    </div>
</div>

<script type='text/javascript'>

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

		const form = document.getElementById('StudentStatusPatternRegenerateIndividualAcademicStatusForm');

		let formBeingSubmitted = false;
        let regeneratingStudentStatusOnProgress = false;


		form.querySelectorAll('input').forEach(input => {
			input.addEventListener('input', function () {
				this.value = this.value.replace(/\s+/g, ''); // removes spaces and tabs
				removeInlineError(this);
			});

			input.addEventListener('blur', function () {
				this.value = this.value.trim(); // full trim on blur
			});
		});

		function removeInlineError(input) {
			const existing = input.parentNode.querySelector('.legacy-tooltip');
			if (existing) existing.remove();
		}

        function hideSearchResultsAndInfo() {

            const elements = [
                'showSearchResults',
                'showAdditionalInformation',
                'showStudentBasicProfile'
            ];

            elements.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });

            const regenerateBtnContainer = document.getElementById('regenerateBtnContainer');

            if (regenerateBtnContainer) {
                form.regenerateStudentStatus.disabled = true;
                regenerateBtnContainer.style.display = 'none';
            } else {
                regeneratingStudentStatusOnProgress = false;
            }
        }

		form.addEventListener('submit', function (e) {

            const clickedButton = e.submitter;

			const studentStudentID = form.StudentStudentID;

            const isThisSearchBtn = (clickedButton.id === 'getStudentDetails');

			let valid = true;

			if (!valid) {
				e.preventDefault();
				return;
			}

            if (formBeingSubmitted && isThisSearchBtn) {
                alert('Searching for ' + studentStudentID.value.trim() + ', please wait a moment...');
                form.regenerateStudentStatus.disabled = true;
                form.getStudentDetails.disabled = true;
                e.preventDefault();
                return;
			} else if (formBeingSubmitted && !isThisSearchBtn) {
                alert('Regenerating status for ' + studentStudentID.value.trim() + ', please wait a moment...');
				e.preventDefault();
                form.regenerateStudentStatus.disabled = true;
				form.getStudentDetails.disabled = true;
				return;
            }

            if (isThisSearchBtn) {
                form.getStudentDetails.value = 'Searching...';
                form.regenerateStudentStatus.disabled = true;
                hideSearchResultsAndInfo();
            } else if (clickedButton.id === 'regenerateStudentStatus') {
                form.regenerateStudentStatus.value = 'Regenerating Student Status...';
                form.getStudentDetails.disabled = true;
                regeneratingStudentStatusOnProgress = true;

                // Optionally Hide and Disable the toggle button to prevent further clicks
                /* const toggleDiv = document.getElementById('toggleShowStudentID');
                if (toggleDiv) {
                    toggleDiv.removeAttribute('onclick');
                    toggleDiv.style.display = 'none';
                } */
            }
            
            formBeingSubmitted = true;
            
		});

		form.querySelectorAll('input').forEach(input => {
			input.addEventListener('input', () => removeInlineError(input));
		});

		// prevent form resubmission on page refresh
        if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	});
</script>