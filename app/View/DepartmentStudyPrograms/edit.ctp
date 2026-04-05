<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-edit" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Edit Department Study Program: ' .  (isset($departmentStudyProgramDetails['StudyProgram']['study_program_name']) ? $departmentStudyProgramDetails['StudyProgram']['study_program_name'] . ' (' .$departmentStudyProgramDetails['StudyProgram']['code'] . ')'  : '') . (isset($departmentStudyProgramDetails['ProgramModality']['modality']) && isset($departmentStudyProgramDetails['Qualification']['qualification']) ?  ' ' . $departmentStudyProgramDetails['Qualification']['qualification'] . ', ' .  $departmentStudyProgramDetails['ProgramModality']['modality'] . '' : ''); ?></span>
        </div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<hr style="margin-top: -15px;">
                <fieldset style="margin-top: 5px; padding-bottom: 5px;padding-top: 25px;">
					<?= $this->Form->create('DepartmentStudyProgram'); ?>
					<div class="row">
						<div class="large-6 columns">
							<?= $this->Form->hidden('id'); ?>
							<?= $this->Form->input('department_id', array('empty' => '[ Select Department ]', 'required', 'style' => 'width:96%;')); ?>
							<?= $this->Form->input('study_program_id', array('id' => 'StudyProgramID', 'class' => 'custom-select', 'empty' => '[ Select Study Program ]', 'required', 'style' => 'width:96%;')); ?>
							<br><br>
						</div>
						<div class="large-6 columns">
							<?= $this->Form->input('program_modality_id', array('empty' => '[ Select Program Modality ]', 'required', 'style' => 'width:96%;')); ?>
							<?= $this->Form->input('qualification_id', array('empty' => '[ Select Qualification ]', 'required', 'style' => 'width:96%;')); ?>
							<?= $this->Form->input('academic_year', array('label' => 'From Academic Year', 'empty' => '[ Select Academic Year ]', 'default' => '2022/23', 'style' => 'width:96%;', 'options' => $academic_year)); ?>
							<?= '<br>' . $this->Form->input('apply_for_current_students', array('type'=>'checkbox', 'checked' =>'checked')); ?>
							<br>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<hr>
							<?= $this->Form->end(array('label' => 'Save Study Program', 'name' => 'editStudyProgram', 'id' => 'editStudyProgram', 'class' => 'tiny radius button bg-blue')); ?>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>

<style>
	.input.select .custom-select {
		width: 96% !important;
		display: block;
	}

	.input.select .custom-select a {
		display: block;
		width: 96% !important;
		box-sizing: border-box;
	}

	.input.select .custom-select a span {
		display: block;
		width: 96% !important;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.input.select .custom-select input {
		width: 98% !important;
		box-sizing: border-box;
		margin: 5px 5px 0;
    	padding: 5px;
	}
</style>

<script>

    $(function() {

		$("#StudyProgramID").customselect();

		const $form = $('#DepartmentStudyProgramDepartmentId').closest('form');
		const $submitBtn = $('#editStudyProgram');

		let formBeingSubmitted = false;

		$form.on('submit', function (e) {

			let valid = true;

			$form.find('[required]').each(function () {
				if ($(this).is(':checkbox') && !$(this).is(':checked')) {
					//valid = false;
					//return false; // Exit loop early
				} else if (!$(this).is(':checkbox') && $(this).val().trim() === '') {
					valid = false;
					return false;
				}
			});

			if ($('#StudyProgramID').val().trim() === '') {
				valid = false;
				return false;
			}

			if (!valid) {
				e.preventDefault();
				return;
			}

			if (formBeingSubmitted) {
				alert('Saving Department Study Program, please wait a moment...');
				e.preventDefault();
				$submitBtn.prop('disabled', true);
				return;
			}

			$submitBtn.val('Saving Study Program...');
			formBeingSubmitted = true;
		});

		// Prevent duplicate submissions via browser history
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}

	});
</script>