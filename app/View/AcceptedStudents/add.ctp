<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-plus" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Add Accepted Student'; ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">

				<div style="margin-top: -30px;"><hr></div>

				<?= $this->Form->create('AcceptedStudent'); ?>
				
				<div class="large-12 columns">
					<div class="row">
						<div class="large-4 columns">
							<?= $this->Form->input('first_name', array('style' => 'width:100%', 'label' => 'First Name: ', 'required', 'id' => 'firstName')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('middle_name', array('style' => 'width:100%', 'label' => 'Middle Name: ', 'required', 'id' => 'middleName')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('last_name', array('style' => 'width:100%', 'label' => 'Last Name: ', 'required', 'id' => 'lastName')); ?>
						</div>
					</div>
				</div>

				<div class="large-12 columns">
					<div class="row">
						<div class="large-4 columns">
							<?php
							$options = array('Male' => ' Male', 'Female' => ' Female'); 
							echo '<h6 class="fs13 text-gray">Sex: </h6> ' . $this->Form->input('sex', array('options' => $options, 'type' => 'radio', 'legend' => false, 'separator' => ' &nbsp; ', 'label' => true, 'div' => false)); ?>
							<div id="sex-error" style="color: red; display: none;"></div>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('EHEECE_total_results', array('style' => 'width:100%', 'label' => 'EHEECE Result: ', 'required', 'id' => 'eheeceTotalResults', 'min' => 100,  'max' => 700, 'step' => 'any')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('moeadmissionnumber', array('style' => 'width:100%', 'label' => 'MoE Admission Number: ', 'id' => 'moeAdmissionNumber')); ?>
						</div>
					</div>
				</div>

				<div class="large-12 columns">
					<div class="row">
						<div class="large-4 columns">
							<?php // echo $this->Form->input('studentnumber', array('style' => 'width:100%', 'id' => 'studentNumber', 'label' => 'Student ID: ', 'required')); ?>
						</div>
						<div class="large-8 columns">
							<?= $this->Form->input('high_school', array('style' => 'width:100%', 'label' => 'High School Attended: ', 'id' => 'highSchoolName')); ?>
						</div>
					</div>
				</div>
				<div class="large-12 columns">
					<hr>
					<div class="row">
						<div class="large-3 columns">
							<?= $this->Form->input('academicyear', array('style' => 'width:100%', 'id' => 'AcademicYear', 'label' => 'Admission Year: ', 'type' => 'select', 'options' => $acyear_array_data, 'empty' => '[ Select Admission Year ]')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('program_id', array('style' => 'width:100%', 'label' => 'Program: ', 'id' => 'ProgramID', 'required')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('program_type_id', array('style' => 'width:100%', 'label' => 'Program Type: ', 'id' => 'ProgramTypeID', 'required')); ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->input('placement_type_id', array('style' => 'width:100%', 'label' => 'Placement Type: ', 'empty' => '[ Select Placement Type ]', 'default' => 4)); ?>
						</div>
					</div>
				</div>
				<div class="large-12 columns">
					<div class="row">
						<div class="large-4 columns">
							<?= $this->Form->input('college_id', array('style' => 'width:100%', 'label' => 'College: ', 'empty' => '[ Select College ]', 'options' => (isset($collegess) && !empty($collegess) ? $collegess : $colleges), 'id' => 'CollegeID',  'required')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('department_id', array('style' => 'width:100%', 'label' => 'Department: ', 'options' => (isset($departmentss) ? $departmentss : $departments), 'empty' => '[ Select College ]', 'id' => 'DepartmentID',)); ?>
						</div>
						<div class="large-4 columns">
							<?php //echo $this->Form->input('campus_id', array('style' => 'width:100%', 'label' => 'Campus: ', 'empty' => '[ Select Campus ]', 'disabled')); ?>
							<?= $this->Form->input('studentnumber', array('style' => 'width:100%', 'id' => 'studentNumber', 'label' => 'Student ID: ', 'required')); ?>
						</div>
					</div>
				</div>
				<div class="large-12 columns">
					<div class="row">
						<div class="large-12 columns"><hr></div>
						<div class="large-4 columns">
							<?= $this->Form->input('country_id', array('id' => 'country_id_1', 'label' => 'Country: ', 'required', 'options' => $countries, 'style' => 'width:100%', 'default' => COUNTRY_ID_OF_ETHIOPIA)); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('region_id', array('id' => 'region_id_1', 'label' => 'Region: ', 'required', 'options' => $regions, 'style' => 'width:100%', 'empty' => '[ Select Region ]')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('zone_id', array('id' => 'zone_id_1', 'label' => 'Zone: ', 'required', 'options' => $zones, 'style' => 'width:100%', 'empty' => '[ Select Zone ]')); ?>
						</div>
					</div>
				</div>

				<div class="large-12 columns">
					<div class="row">
						<div class="large-4 columns">
							<?= $this->Form->input('woreda_id', array('id' => 'woreda_id_1', 'label' => 'Woreda: ', 'required',  'options' => $woredas, 'style' => 'width:100%', 'empty' => '[ Select Woreda ]')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('city_id', array('id' => 'city_id_1', 'label' => 'City: ', 'options' => $cities, 'style' => 'width:100%', 'empty' => '[ Select City ]')); ?>
						</div>
						<div class="large-4 columns">
							&nbsp;
						</div>
					</div>
				</div>

				<div class="large-12 columns">
					<div class="row">
						<div class="large-12 columns"><hr></div>
						<div class="large-4 columns">
							<?= $this->Form->input('benefit_group', array('label' => 'Benefit Group: ', 'options' => Configure::read('benefit_groups'), 'style' => 'width:100%', 'default' => 'Normal', 'empty' => '[ Select Benefit Group ]')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('disability_id', array('label' => 'Disability: ', 'style' => 'width:100%', 'empty' => '[ Select Disability (If Applicable) ]')); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('foreign_program_id', array('label' => 'Foreign Program: ', 'style' => 'width:100%', 'empty' => '[ Select Foreign Program (If Applicable) ]')); ?>
						</div>
					</div>
				</div>
				<div class="large-12 columns">
					<div class="row">
						<hr>
						<?= $this->Form->Submit('Add Accepted Student', array('id' => 'addAcceptedStudent', 'name' => 'addAcceptedStudent', 'class' => 'tiny radius button bg-blue')); ?>
					</div>
				</div>
					
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>

	//$(document).ready(function() {
		$("#CollegeID").change(function() {
			$("#DepartmentID").attr('disabled', true);
			$("#CollegeID").attr('disabled', true);

			var cid = $("#CollegeID").val();
			var formUrl = '/departments/get_department_combo/' + cid;

			if (cid != '') {

				$.ajax({
					type: 'get',
					url: formUrl,
					data: cid,
					success: function(data, textStatus, xhr) {
						$("#DepartmentID").attr('disabled', false);
						$("#CollegeID").attr('disabled', false);
						$("#DepartmentID").empty();
						//$("#DepartmentID").append('<option>No department</option>');
						$("#DepartmentID").append(data);
					},
					error: function(xhr, textStatus, error) {
						alert(textStatus);
					}
				});

				return false;
			} else {
				$('#DepartmentID').empty().append('<option value="">[ Select College First ]</option>');
				$("#CollegeID").attr('disabled', false);
			}

			return false;
		});
	//});

	
	$('#AcademicYear, #CollegeID, #ProgramID, #ProgramTypeID, #DepartmentID').on('change keyup', function () {

        $("#studentNumber").val('');

        var formData = '';
        var college_id = $("#CollegeID").val();
        var academic_year = $("#AcademicYear").val().replace("/", "-");
        var program_id = $("#ProgramID").val();
        var program_type_id = $("#ProgramTypeID").val();
		var department_id = $("#DepartmentID").val();

        if (typeof college_id != "undefined" && typeof academic_year != "undefined" &&  typeof program_id != "undefined" &&  typeof program_type_id != "undefined") {
			if (college_id == '' || academic_year == '' || program_id == '' || program_type_id == '' ) {
				return false;
			} else {
				var cDtype = 'd';

				if (typeof department_id == "undefined" || (typeof department_id != "undefined" && (department_id == '' || department_id == '0' || department_id == 0 || department_id == '-1' || department_id == -1))) {
					cDtype = 'c';
				}

				formData = college_id + '~' + academic_year + '~' + program_id + '~' + program_type_id + '~' + cDtype;
			}
        } else {
            return false;
        }

		
        var formUrl = '/acceptedStudents/getNextStudentIdNumber/' + formData;

		$("#addAcceptedStudent").attr('disabled', true);
		$("#CollegeID").attr('disabled', true);
		$("#AcademicYear").attr('disabled', true);
		$("#ProgramID").attr('disabled', true);
		$("#ProgramTypeID").attr('disabled', true);
		$("#DepartmentId").attr('disabled', true);
		$("#DepartmentID").attr('disabled', true);
		$("#studentNumber").attr('disabled', true);


        $.ajax({
            type: 'get',
            url: formUrl,
            data: formData,
            success: function(data,textStatus, xhr) {
            	$("#CollegeID").attr('disabled', false);
                $("#AcademicYear").attr('disabled', false);
                $("#ProgramID").attr('disabled', false);
                $("#ProgramTypeID").attr('disabled', false);
                $("#DepartmentId").attr('disabled', false);
                $("#DepartmentID").attr('disabled', false);
                $("#studentNumber").attr('disabled', false);
                $("#studentNumber").empty(); 
                $("#studentNumber").val(data);
            },
            error: function(xhr, textStatus, error) {
                alert(textStatus);
            }
        });

        $("#addAcceptedStudent").attr('disabled', false);
        return false;
    });


	// get regions based on selected country
	$('#country_id_1').change(function() {
		
		var countryId = $(this).val();

		$('#region_id_1').attr('disabled', true);
		$('#zone_id_1').attr('disabled', true);
		$('#woreda_id_1').attr('disabled', true);
		$('#city_id_1').attr('disabled', true);

		if (countryId) {
			$.ajax({
				url: '/students/get_regions/' + countryId,
				type: 'get',
				data: countryId,
				success: function(data, textStatus, xhr) {
					$('#region_id_1').attr('disabled', false);
					$('#region_id_1').empty();
					$('#region_id_1').append(data);

					$('#zone_id_1').empty().append('<option value="">[ Select Zone ]</option>');
					$('#woreda_id_1').empty().append('<option value="">[ Select Woreda ]</option>');
					$('#city_id_1').empty().append('<option value="">[ Select City ]</option>');
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});

			return false;

		} else {
			$('#region_id_1').empty().append('<option value="">[ Select Region ]</option>');
			$('#zone_id_1').empty().append('<option value="">[ Select Zone ]</option>');
			$('#woreda_id_1').empty().append('<option value="">[ Select Woreda ]</option>');
			$('#city_id_1').empty().append('<option value="">[ Select City ]</option>');
		}
	});

	// Load zone options based on selected region
	$('#region_id_1').change(function() {
		
		var regionId = $(this).val();

		$('#zone_id_1').attr('disabled', true);
		$('#woreda_id_1').attr('disabled', true);
		$('#city_id_1').attr('disabled', true);

		if (regionId) {
			$.ajax({
				url: '/students/get_zones/'+ regionId,
				type: 'get',
				data: regionId,
				success: function(data, textStatus, xhr) {
					$('#zone_id_1').attr('disabled', false);
					$('#zone_id_1').empty();
					$('#zone_id_1').append(data);

					$('#woreda_id_1').empty().append('<option value="">[ Select Woreda ]</option>');
					$('#city_id_1').empty().append('<option value="">[ Select City ]</option>');
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});

			return false;
			
		} else {
			$('#zone_id_1').empty().append('<option value="">[ Select Zone ]</option>');
			$('#woreda_id_1').empty().append('<option value="">[ Select Woreda ]</option>');
			$('#city_id_1').empty().append('<option value="">[ Select City ]</option>');
		}
	});

	// Load woreda options based on selected zone
	$('#zone_id_1').change(function() {

		var zoneId = $(this).val();

		$('#woreda_id_1').attr('disabled', true);
		$("#city_id_1").attr('disabled', true);

		if (zoneId) {
			$.ajax({
				url: '/students/get_woredas/'+ zoneId,
				type: 'get',
				data: zoneId,
				success: function(data, textStatus, xhr) {
					$('#woreda_id_1').attr('disabled', false);
					$('#woreda_id_1').empty();
					$('#woreda_id_1').append(data);

					// sub category
					var regionId = $("#region_id_1").val();
					$("#city_id_1").empty();

					$.ajax({
						type: 'get',
						url: '/students/get_cities/' + regionId,
						data: regionId,
						success: function(data, textStatus, xhr) {
							$("#city_id_1").attr('disabled', false);
							$("#city_id_1").empty();
							$("#city_id_1").append(data);
						},
						error: function(xhr, textStatus, error) {
							alert(textStatus);
						}
					});
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});

			return false;

		} else {
			$('#woreda_id_1').empty().append('<option value="">[ Select Woreda ]</option>');
			$('#city_id_1').empty().append('<option value="">[ Select City ]</option>');
		}
	});

	$('#ProgramID').on('change', function () {
		var ProgramID = $(this).val();
		$('#eheeceTotalResults').val( '');
		if (ProgramID !== '' && (ProgramID != '1' && ProgramID != '5')) {
			$('#eheeceTotalResults').removeAttr('required');
			$('#eheeceTotalResults').css('border', '');
			$('#eheeceTotalResults').attr('min', 2);
			$('#eheeceTotalResults').attr('max', 4);
			$('#eheeceTotalResults').attr('step', '0.01');
		} else {
			$('#eheeceTotalResults').attr('required', true);
			$('#eheeceTotalResults').attr('min', 100);
			$('#eheeceTotalResults').attr('max', 700);
			$('#eheeceTotalResults').attr('step', '1');
		}
	});

	function validateDepartmentRequirement() {

		const programID = $("#ProgramID").val();
		const programTypeID = $("#ProgramTypeID").val();
		const departmentID = $("#DepartmentID").val();

		const departmentRequired = (programID !== '1' && programID !== '5') || ((programID === '1' || programID === '5') && programTypeID !== '1');

		if (departmentRequired) {
			if (departmentID === '' || departmentID === '0' || departmentID === '-1') {
				$("#DepartmentID").css('border', '1px solid red');
				$("#DepartmentID").attr('required', true);
			} else {
				$("#DepartmentID").css('border', '');
				$("#DepartmentID").removeAttr('required');
			}
		} else {
			// Not required
			$("#DepartmentID").css('border', '');
			$("#DepartmentID").removeAttr('required');
		}
	}

	// Attach to change events
	$("#ProgramID, #ProgramTypeID, #DepartmentID").on('change', validateDepartmentRequirement);

	var form_being_submitted = false;

	$(document).ready(function () {

		//const STUDENT_ID_REGEX = <?php echo json_encode(trim(STUDENT_ID_NUMBER_REGEX, '/')); ?>;
		const STUDENT_ID_REGEX = <?php echo json_encode(trim((ENFORCE_STUDENT_ID_NUMBER_REGEX_ON_IMPORTING_STUDENTS == 0 ? STUDENT_ID_NUMBER_REGEX_FOR_GENERATED_ID_MODIFICATION : STUDENT_ID_NUMBER_REGEX), '/')); ?>;
		const regex = new RegExp(STUDENT_ID_REGEX);

		const studentIDInput = $("#studentNumber");

		// Validate on blur or input
		studentIDInput.on("blur input", function () {
			const val = studentIDInput.val().trim();
			if (val !== '' && !regex.test(val)) {
				studentIDInput.css('border', '1px solid red');
			} else {
				studentIDInput.css('border', '');
			}
		});

		const nameRegex = /^[A-Za-z\s]{2,20}$/;

		function validateNameField(field, fieldLabel) {
			let value = field.val().trim();

			if (value === '') {
				field.css('border', '1px solid red');
				field.attr('title', fieldLabel + ' is required.');
				return false;
			} else if (!nameRegex.test(value)) {
				field.css('border', '1px solid red');
				field.attr('title', 'Invalid ' + fieldLabel + '. Use only letters and spaces, maximum 20 characters.');
				return false;
			} else {
				field.css('border', '');
				field.removeAttr('title');
				return true;
			}
		}

		// Validate on input and blur
		$('#firstName, #middleName, #lastName').on('input blur', function () {
			const fieldLabel = $(this).attr('id').replace('Name', ' Name');
			validateNameField($(this), fieldLabel);
			$(this).val() = toTitleCase($(this).val()); // optional: change it to title case: ucwords php equivalent.
		});

		$("#ProgramID, #ProgramTypeID, #DepartmentID").on('change', validateDepartmentRequirement);

		// Optionally trigger once on page load to initialize state
		validateDepartmentRequirement();

		// Enforce min max for eheeceTotalResults on typing
		const eheeceTotalResults = $('#eheeceTotalResults');

        if (eheeceTotalResults.length) {
            $('#eheeceTotalResults').on('input blur', function () {
                const $input = $(this);
                const val = parseFloat($input.val());
                const min = parseFloat($input.attr('min'));
                const max = parseFloat($input.attr('max'));

                if (!isNaN(val)) {
                    if (val < min) $input.val(min);
                    else if (val > max) $input.val(min);
                }
            });
        }

		// Validate on submit
		$('#addAcceptedStudent').click(function () {

			let allFilled = true;
			let isValid = true;

			isValid &= validateNameField($('#firstName'), 'First Name');
			isValid &= validateNameField($('#middleName'), 'Middle Name');
			isValid &= validateNameField($('#lastName'), 'Last Name');

			// Check if any radio button in the group is selected for sex
			const sexSelected = $('input[name="data[AcceptedStudent][sex]"]:checked').length > 0;

			if (!sexSelected) {
				allFilled = false;
				isValid = false;
				$('#sex-error').text('Please select sex').show();

			} else {
				$('#sex-error').hide();
			}

			if (!isValid || !allFilled) {
				return false;
			}

			$('form input[required], form select[required]').each(function () {
				if ($(this).val().trim() === '') {
					allFilled = false;
					isValid = false;
					$(this).css('border', '1px solid red');
				} else {
					$(this).css('border', '');
				}
			});

			if (!isValid || !allFilled) {
				alert('Please correct the highlighted name fields.');
				allFilled = false;
				isValid = false;
				return false;
			}

			// Student ID  validation
			const studentNumber = studentIDInput.val().trim();

			if (studentNumber !== '' && !regex.test(studentNumber)) {
				studentIDInput.css('border', '1px solid red');
				studentIDInput.focus();
				isValid = false;
				return false;
			}

			// department ID requirement validation
			const programID = $("#ProgramID").val();
			const programTypeID = $("#ProgramTypeID").val();
			const departmentID = $("#DepartmentID").val();

			const departmentRequired = (programID !== '1' && programID !== '5') || ((programID === '1' || programID === '5') && programTypeID !== '1');

			if (departmentRequired && (departmentID === '' || departmentID === '0' || departmentID === '-1')) {
				alert('Please select Department from the list.');
				$("#DepartmentID").focus();
				$("#DepartmentID").css('border', '1px solid red');
				allFilled = false;
				isValid = false;
				return false;
			} else {
				$("#DepartmentID").css('border', '');
			}

			if (!isValid || !allFilled) {
				alert('Please correct the highlighted name fields.');
				allFilled = false;
				isValid = false;
				return false;
			}

			if (form_being_submitted) {
				alert('Adding Accepted Student. please wait a moment...');
				$('#addAcceptedStudent').attr('disabled', true);
				isValid = false;
				return false;
			}

			const confirmm = confirm('Are you certain the provided student information is correct and you want to finalize adding this Accepted Student?');

			if (!form_being_submitted && allFilled && isValid && confirmm) {
				$('#addAcceptedStudent').val('Adding Accepted Student...');
				form_being_submitted = true;
				return true;
			} else {
				return false;
			}
		});
		
	});

	$('form select[required]').on('change', function() {
		if ($(this).val() !== '') {
			$(this).css('border', '');
		}
	});

	$('input[name="data[AcceptedStudent][sex]"]').on('change', function () {
		$('#sex-error').hide();
	});

	// finction to convert given string to a title case.
	function toTitleCase(str) {
		return str.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
	}

	$('form input[required]').on('input blur keyup', function () {

		let field = $(this);
		let value = field.val();

		// Basic cleanup for all fields
		if (value !== '') {
			field.css('border', '');
		}

		// Trim and sanitize
		if (field.attr('id') === 'highSchoolName') {
			// Special sanitization for #highSchoolName
			// explanation: remove trailing spaces. Replace tabs with space . Replace multiple spaces with single space . Remove non-UTF-8 characters . Remove special characters
			value = value.trim().replace(/\t/g, ' ').replace(/\s{2,}/g, ' ').replace(/[^\u0000-\u007F]+/g, '').replace(/[^a-zA-Z0-9\s]/g, '');
		} else {
			// General sanitization for other fields, Replace tabs with space, Replace multiple spaces with single space
			value = value.trim().replace(/\t/g, ' ').replace(/\s{2,}/g, ' ');
			
			if (field.attr('id') === 'firstName' || field.attr('id') === 'middleName' || field.attr('id') === 'lastName') {
				value = toTitleCase(value);
			}
		}

		field.val(value);

	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	} 
</script>
