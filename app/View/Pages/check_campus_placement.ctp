<style>
	.legacy-tooltip {
		animation: fadein 0.2s ease-in;
	}
	@keyframes fadein {
		from { opacity: 0; }
		to { opacity: 1; }
	}
</style>

<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-check-outline" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Check Your Campus Placement'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div style="margin-top: -30px;"><hr></div>
				<?php

				$flash_message = $this->Session->flash();

				if (!empty($flash_message)) {
					echo $flash_message;
					echo '<hr>';
				}

				if (!isset($this->data['Page']) || (isset($this->data['Page']) && isset($resultFound) && empty($resultFound))) { ?>
					<fieldset style="padding-bottom: 5px; padding-top: 15px;">
						<div class="row">
							<?= $this->Form->Create('Page'); ?>
							<br>
							<div class="large-4 columns">
								<?= $this->Form->input('first_name', array('id' => 'first_name', 'size' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB, 'placeholder' => 'Your First Name', 'label' => 'Your First Name: ', 'value' => (!isset($this->data['Page']) ? '' : (isset($firstNameProvided) && !empty($firstNameProvided) ? $firstNameProvided : '')), 'autocomplete' => 'off', 'required', 'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB)); ?>
								<div style="margin-bottom: 50px;"></div>
							</div>
							<div class="large-4 columns">
								<?= $this->Form->input('search_key', array('id' => 'SearchKey', 'size' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB, 'placeholder' => 'MoE Admission Number', 'label' => 'MoE Admission Number: ', 'value' => (!isset($this->data['Page']) ? '' : (isset($searchKeyProvided) && !empty($searchKeyProvided) ? $searchKeyProvided : '')), 'autocomplete' => 'off', 'required', 'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB)); ?>
								<div style="margin-bottom: 50px;"></div>
							</div>
							
							<div class="large-4 columns" data-nosnippet>
								<div class="row collapse">
									Please enter the sum of <strong class="math-challenge"><?= ($mathCaptcha); ?></strong>
									<?= '<br>' . $this->Form->input('security_code', array('label' => false,  'placeholder' => 'Enter sum of the numbers above',  'autocomplete' => 'off', 'id' => 'securityCode', 'value' => '', 'type' => 'number', 'min' => 0, 'max' => 100, 'required'));  ?>
									<div style="margin-bottom: 50px;"></div>
								</div>
							</div>

							<?php
							if (isset($mathCaptcha)) {
								echo $this->Form->hidden('mathCaptcha', array('value' => 1));
							} ?>
							
							<div class="large-12 columns">
								<hr>
								<?= $this->Form->Submit(__('Check Campus', true), array('class' => 'tiny radius button bg-blue btn-primary', 'name' => 'continue', 'id' => 'continue', 'div' => false)); ?>
							</div>
							<?= $this->Form->end(); ?>
						</div>
					</fieldset>
					<?php
				}

				if (isset($resultFound) && !empty($resultFound)) { ?>
					<div class="large-12 columns">
						<?= $this->element('student_campus_placement_check'); ?>
						<br>
					</div>
					<hr>
					<?php
				} ?>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function () {

		const form = document.getElementById('PageCheckRemedialResultForm');

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
				margin-top: 8px;     /* space below input */
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

			const firstName = form.first_name;
			const searchKey = form.SearchKey;
			const securityCode = form.securityCode;
			const mathChallenge = document.querySelector('.math-challenge')?.innerText || '';
			const mathAnswer = parseInt(securityCode.value.trim(), 10);

			let valid = true;

			if (firstName.value.trim().length < 2) {
				showInlineError(firstName, "First Name too short.");
				firstName.focus();
				valid = false;
			} else if (firstName.value.trim().length > 20) {
				showInlineError(firstName, "First Name too long.");
				firstName.focus();
				valid = false;
			} else {
				removeInlineError(firstName);
			}

			const alphaRegex = /^[a-zA-Z/]+$/;

			if (!alphaRegex.test(firstName.value.trim())) {
				showInlineError(firstName, "Only letters are allowed.");
				firstName.focus();
				valid = false;
			}

			if (searchKey.value.trim().length < 4) {
				showInlineError(searchKey, "Search Key is too short.");
				searchKey.focus();
				valid = false;
			} else if (searchKey.value.trim().length > 20) {
				showInlineError(searchKey, "Search Key is too long.");
				searchKey.focus();
				valid = false;
			} else {
				removeInlineError(searchKey);
			}

			const rawKey = searchKey.value.trim();
			const containsLetter = /[a-zA-Z]/.test(rawKey);

			if (containsLetter) {
				const slashCount = (rawKey.match(/\//g) || []).length;
				const containsDigit = /\d/.test(rawKey);

				if (slashCount < 2 || !containsDigit) {
					showInlineError(searchKey, "Invalid Student ID or Admission Number.");
					searchKey.focus();
					valid = false;
				}
			} else {
				const numericPattern = /^[0-9/]+$/;
				if (!numericPattern.test(rawKey)) {
					showInlineError(searchKey, "Invalid admission number or student ID.");
					searchKey.focus();
					valid = false;
				}
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
				e.preventDefault();
				form.continue.disabled = true;
				return;
			}

			form.continue.value = 'Checking...';
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