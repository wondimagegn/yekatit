<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-check-outline" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Verify Graduation Status'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div style="margin-top: -30px;">
					<hr>

					<?php
					$flash_message = $this->Session->flash();
					if (!empty($flash_message)) {
						echo $flash_message;
						echo '<hr>';
					} ?>

					<?php //echo '<h6 class="text-gray" style="text-align: justify;">This is an interface for employer and any stakeholder who would like to check graduates of our university. Forgery protection is one of our main value!</h6>'; ?>
					<h6 class="text-gray" style="text-align: justify;">This interface is designed for employers and stakeholders seeking to confirm the credentials of our graduates. Protecting against forgery and ensuring data integrity are core values of our system!</h6>
					<hr>

					<?php
					if (!isset($students['GraduateList'])) { ?>
						<fieldset style="padding-bottom: 5px; padding-top: 15px;">
							<div class="row">
								<?= $this->Form->Create('Page'); ?>

								<br>
								<div class="large-4 columns">
									<?= $this->Form->input('studentID', array('id' => 'StudentStudentID', 'size' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB, 'placeholder' => 'Type Student ID...', 'autocomplete' => 'off', 'label' => 'Student ID', 'required', 'value' => (isset($studentID) ? $studentID : ''), 'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB)); ?>
									<div style="margin-bottom: 50px;"></div>
								</div>

								<?php
								if (!isset($students['GraduateList'])) { ?>
									<div class="large-4 columns" data-nosnippet>
										<div class="row collapse">
											Please enter the sum of <strong class="math-challenge"><?= ($mathCaptcha); ?></strong>
											<?= '<br>' . $this->Form->input('security_code', array('label' => false,  'placeholder' => 'Enter sum of the numbers above',  'autocomplete' => 'off', 'id' => 'securityCode', 'value' => '', 'type' => 'number', 'min' => 0, 'max' => 100, 'required'));  ?>
											<div style="margin-bottom: 50px;"></div>
										</div>
									</div>
									<?php
								} 

								if (isset($mathCaptcha)) {
									echo $this->Form->hidden('mathCaptcha', array('value' => 1));
								} ?>
								
								<div class="large-12 columns">
									<hr>
									<?= $this->Form->Submit(__('Check Status', true), array('class' => 'tiny radius button bg-blue btn-primary', 'name' => 'continue', 'id' => 'continue', 'div' => false)); ?>
								</div>

								<?= $this->Form->end(); ?>
							</div>
						</fieldset>
						<?php
					} ?>
				</div>

				<?php
				if (isset($students['GraduateList']) && !empty($students['GraduateList'])) { ?>
					<!-- <hr> -->
					<div class="large-12 columns">
						<?php
						if (!empty($students['GraduateList']) && !empty($students['Student'])) {
							echo $this->element('student_graduation_check');
						} else if (empty($students['GraduateList']) && !empty($students['Student'])) {
							echo $this->element('student_graduation_check');
						} ?>
						<br>
					</div>
					<hr>
					<div class="large-12 columns">
						<?php
						if (!empty($students['Student'])) {
							//echo '<p style="text-align: justify;"><strong>Note: </strong> If you need student official copy, please send us your company details to our email <a href="mailto:' . REGISTRAR_EMAIL . '">' . REGISTRAR_EMAIL . '</a>. It is going to take 2-4 business days to verify your request and send the student official copy to your company address.</p>';
							echo '<p style="text-align: justify;"><strong>Note: </strong>To request an official copy of a student\'s record, please send your company details via email at <a href="mailto:' . REGISTRAR_EMAIL . '">' . REGISTRAR_EMAIL . '</a> or by official letter addressed to Office of the Registrar,  P.O.Box: ' . Configure::read('POBOX') . ', ' . Configure::read('CompanyName') . ', ' . Configure::read('ApplicationDeployedCityEnglish') .  ', ' . Configure::read('ApplicationDeployedCountryEnglish') .'. Verification and processing typically take 2 to 4 business days, after which the official copy will be sent to your company’s address.</p>';

						} ?>
					</div>
					<?php
				} else if (isset($studentIDNotFound) && $studentIDNotFound) {
					echo '<hr><p style="text-align: justify;"><strong>Office of the Registrar:</strong><br>Email: <a href="mailto:' . REGISTRAR_EMAIL . '">' . REGISTRAR_EMAIL . '</a> <br> P.O.Box: ' . Configure::read('POBOX') . ', ' . Configure::read('CompanyName') . ', ' . Configure::read('ApplicationDeployedCityEnglish') .  ', ' . Configure::read('ApplicationDeployedCountryEnglish') . '.</p>';
				} ?>
			</div>
		</div>
	</div>
</div>

<script>

	document.addEventListener('DOMContentLoaded', function () {

		const form = document.getElementById('PageCheckGraduateForm');

		const STUDENT_ID_REGEX_SEARCH = <?php echo json_encode(trim(STUDENT_ID_NUMBER_REGEX_FOR_SEARCH, '/')); ?>;
  		const basicStudentIDPattern = new RegExp(STUDENT_ID_REGEX_SEARCH);

		const minStudentIdNumberLength = <?php echo json_encode(MINIMUM_STUDENT_ID_NUMBER_LENGTH); ?>;
		const maxStudentIdNumberLengthDB = <?php echo json_encode(MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB); ?>;
		const minStudentIdDigitsLength = <?php echo json_encode(MINIMUM_STUDENT_ID_DIGITS_LENGTH); ?>;
		const maxStudentIdDigitsLength = <?php echo json_encode(MAXIMUM_STUDENT_ID_DIGITS_LENGTH + STUDENT_ID_BATCH_YEAR_LENGTH); ?>;


		let formBeingSubmitted = false;

		function showInlineError(input, message) {

			removeInlineError(input);

			const tooltip = document.createElement('div');
			tooltip.className = 'legacy-tooltip';
			tooltip.textContent = message;

			const br = document.createElement('br');

			const parent = input.closest('.input');
			parent.style.position = 'relative';

			tooltip.style.cssText = `
				position: absolute;
				top: 100%;
				left: 0;
				width: ${input.offsetWidth}px;
				background: #fff;
				color: #dc3545;
				border: 1px solid #dc3545;
				padding: 6px 10px;
				border-radius: 4px;
				font-size: 0.75rem;
				white-space: nowrap;
				margin-top: 8px;
				margin-bottom: 12px;
				z-index: 999;
				box-shadow: 0 2px 6px rgba(220, 53, 69, 0.1);
			`;

			parent.appendChild(tooltip);
		}

		form.querySelectorAll('input').forEach(input => {
			input.addEventListener('input', function () {
				this.value = this.value.replace(/\s+/g, '');
				removeInlineError(this);
			});

			input.addEventListener('blur', function () {
				this.value = this.value.trim();
			});
		});

		function removeInlineError(input) {
			const existing = input.parentNode.querySelector('.legacy-tooltip');
			if (existing) existing.remove();
		}

		if (form.securityCode) {
			const secCode = document.getElementById('securityCode');
			['input', 'blur'].forEach(event => {
				secCode.addEventListener(event, function () {
					const val = parseFloat(this.value);
					const min = parseFloat(this.getAttribute('min'));
					const max = parseFloat(this.getAttribute('max'));

					if (!isNaN(val)) {
						if (val < min) this.value = min;
						else if (val > max) this.value = max;
					}
				});
			});
		}

		form.addEventListener('submit', function (e) {

			const studentStudentID = form.StudentStudentID;
			const studentStudentIDvalue = studentStudentID.value.trim();

			const securityCode = form.securityCode;
			const mathChallenge = document.querySelector('.math-challenge')?.innerText || '';
			const mathAnswer = parseInt(securityCode.value.trim(), 10);

			let valid = true;

			if (studentStudentIDvalue.length < minStudentIdNumberLength) {
				showInlineError(studentStudentID, "Student ID is too short. Please check it.");
				studentStudentID.focus();
				valid = false;
			} else if (studentStudentIDvalue.length > maxStudentIdNumberLengthDB) {
				showInlineError(studentStudentID, "Student ID is too long. Please check it.");
				studentStudentID.focus();
				valid = false;
			} else {
				removeInlineError(studentStudentID);
			}

			// Test the provided Student ID against the pattern
			const basicStudentIDPatternPassed = basicStudentIDPattern.test(studentStudentIDvalue);

			if (basicStudentIDPatternPassed) {
				digitsCount = (studentStudentIDvalue.match(/\d/g) || []).length;
				if (!digitsCount || digitsCount < minStudentIdDigitsLength || digitsCount > maxStudentIdDigitsLength) {
					showInlineError(studentStudentID, "Invalid Student ID, Please check it.");
					studentStudentID.focus();
					valid = false;
				} else {
					removeInlineError(studentStudentID);
				}
			} else {
				showInlineError(studentStudentID, "Invalid Student ID, Please check it.");
				studentStudentID.focus();
				valid = false;
			}

			if (!valid) {
				e.preventDefault();
				return;
			}

			if (securityCode.value.trim() === "") {
				showInlineError(securityCode, "Please solve the math challenge.");
				securityCode.focus();
				valid = false;
			} else {
				try {
					const sanitized = mathChallenge.replace(/[^\d+\-*/(). ]/g, '');
					const expected = eval(sanitized);
					if (mathAnswer !== expected) {
						showInlineError(securityCode, "Incorrect math answer!");
						securityCode.focus();
						valid = false;
					} else {
						removeInlineError(securityCode);
					}
				} catch (err) {
					showInlineError(securityCode, "Invalid math expression!");
					valid = false;
				}
			}

			if (!valid) {
				e.preventDefault();
				return;
			}

			if (formBeingSubmitted) {
                alert('Checking status for ' + studentStudentID.value.trim() + ', please wait a moment...')
				e.preventDefault();
				form.continue.disabled = true;
				return;
			}

			form.continue.value = 'Checking Status...';
			formBeingSubmitted = true;
            
		});

		form.querySelectorAll('input').forEach(input => {
			input.addEventListener('input', () => removeInlineError(input));
		});

        if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>