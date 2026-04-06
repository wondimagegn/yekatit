<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Student Course Check List'); ?> <?= (isset($student_academic_profile['BasicInfo']['Student']) ? ' - ' . $student_academic_profile['BasicInfo']['Student']['full_name'] . ' (' . $student_academic_profile['BasicInfo']['Student']['studentnumber'] . ')' : ''); ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns" style="margin-top: -20px;">
                <hr>
                <?= $this->Form->create('Student'); ?>
                <?php
                if ($role_id != ROLE_STUDENT && !isset($student_academic_profile)) { ?>
                    <fieldset style="padding-bottom: 5px;">
                        <legend>&nbsp;&nbsp; Student Number / ID &nbsp;&nbsp;</legend>
                        <div class="row">
                            <div class="large-4 columns">
                                <?= $this->Form->input('studentID', array('label' => false, 'placeholder' => 'Type Student ID...', 'required', 'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB)); ?>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <?= $this->Form->Submit('Search', array('name' => 'continue', 'id' => 'continue', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
                    <?php
                }
                if (!empty($student_academic_profile)) {
                    $this->assign('title_details', (!empty($this->request->params['controller']) ? ' ' . Inflector::humanize(Inflector::underscore($this->request->params['controller'])) . (!empty($this->request->params['action']) && $this->request->params['action'] != 'index' ? ' | ' . ucwords(str_replace('_', ' ', $this->request->params['action'])) : '') : '') . (isset($student_academic_profile['BasicInfo']['Student']) ? ' - ' . $student_academic_profile['BasicInfo']['Student']['full_name'] . ' (' . $student_academic_profile['BasicInfo']['Student']['studentnumber'] .')' : ''));
                    echo $this->element('course_check_list');
                } ?>
            </div>
        </div>
    </div>
</div>
<script>

	document.addEventListener('DOMContentLoaded', function () {

		const form = document.getElementById('StudentCourseCheckListForm');
		let formBeingSubmitted = false;

		form.querySelectorAll('input').forEach(input => {
			input.addEventListener('input', function () {
				this.value = this.value.replace(/\s+/g, ''); // removes spaces and tabs
				removeInlineError(this);
			});

			input.addEventListener('blur', function () {
				this.value = this.value.trim(); // full trim on blur
			});
		});


		form.addEventListener('submit', function (e) {

			const studentStudentID = form.StudentStudentID;

			let valid = true;

			if (!valid) {
				e.preventDefault();
				return;
			}

			if (formBeingSubmitted) {
                alert('Searching for ' + studentStudentID.value.trim() + ', please wait a moment...')
				e.preventDefault();
				form.continue.disabled = true;
				return;
			}

			form.continue.value = 'Searching...';
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