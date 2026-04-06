<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;">
			<i class="fontello- college" style="font-size: larger; font-weight: bold; color: black; padding-left: 7%;"></i>
			<span style="font-size: large; font-weight: bold; margin-top: 20px;" class="text-black"> <?= __('Register to our Alumni Portal'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">

				<hr style="margin-top: -20px;">

				<?= $this->Form->create('Alumnus', array('controller' => 'alumni',  'action' => 'member_registration', 'method' => 'post')); ?>

				<div class="row">

					<div class="large-12 columns">
						<?php
						if (isset($errors) && !empty($errors)) { ?>
							<p style="color: red">
								<?php 
								foreach ($errors as $ercode => $errorlist) {
									echo ucwords($ercode) . ':';
									echo '<ul>';
										foreach ($errorlist as $ek => $erv) {
											echo '<li style="color: red">' . $erv . '</li>';
										}
									echo '</ul>';
								} ?>
							</p>
							<?php
						} ?>
					</div>
					
					<div class="large-12 columns">

						<div class="row">
							<div class="large-4 columns">
								<label for="title"><?= __('Title: '); ?></label>
								<?= $this->Form->input('title', array('label' => '', 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<label for="first_name"><?= __('First Name: '); ?></label>
								<?= $this->Form->input('first_name', array('label' => '', 'placeholder' => 'First Name', 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<label for="last_name"><?= __('Father\'s Name: '); ?></label>
								<?= $this->Form->input('last_name', array('label' => '', 'placeholder' => 'Last  Name', 'required' => 'required')); ?>
							</div> 
						</div>
						
						<div class="row">
							<div class="large-4 columns">
								<label><?= __('Gender: '); ?></label>
								<?php $options = array('Male' => ' &nbsp;Male', 'Female' => ' &nbsp;Female'); ?>
								<span style="line-height: 3;">
									<?= $this->Form->input('gender', array('options' => $options, 'type' => 'radio', 'div' => false, 'legend' => false, 'separator' => '   ')); ?>
								</span>
							</div>
							<div class="large-4 columns">
								<label for="date_of_birth"><?= __('Date of Birth: '); ?></label>
								
								<?= $this->Form->input('date_of_birth', array('label' => '', 'type' => 'date', 'dateFormat' => Configure::read('Calendar.dateFormat'), 'minYear' => date('Y') - Configure::read('Calendar.birthdayInPast'), 'maxYear' => (date('Y') - 17), 'orderYear' => 'desc', 'style' => 'width: 25%;')); ?>
							</div>
							<div class="large-4 columns">
								<label><?= __('Program: '); ?></label>
								<?= $this->Form->input('program', array('label' => '')); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="large-4 columns">
								<label><?= __('Phone: '); ?></label>
								<?= $this->Form->input('phone', array('label' => '', 'id' => "phone", 'placeholder' => 'Phone', 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<label><?= __('Work Phone: '); ?></label>
								<?= $this->Form->input('work_telephone', array('label' => '', 'placeholder' => 'Work Phone')); ?>
							</div>
							<div class="large-4 columns">
								<label for="email"><?= __('Email: '); ?></label>
								<?= $this->Form->input('email', array('label' => '', 'placeholder' => 'Email', 'required' => 'required')); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="large-4 columns">
								<label for="institute_college"><?= __('Institute/College/School: '); ?></label>
								<?= $this->Form->input('institute_college', array('label' => '', 'type' => 'select', 'options' => $institute_colleges, 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<label for="department"><?= __('Department: '); ?></label>
								<?= $this->Form->input('department', array('label' => '', 'placeholder' => 'Department', 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<?php
								$from = Configure::read('CompanyEstablishedYear');
								$to = date('Y');
								$format = 'Y'; ?>
								<label for="graduation"><?= __('Gradution Year (G.C.): '); ?></label>
								<?= $this->Form->input('gradution', array('label' => '', 'type' => 'date', 'required' => 'required', 'dateFormat' => $format, 'minYear' => $from, 'maxYear' => $to)); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="large-4 columns">
								<label for="name_of_employer"><?= __('Current Employer: '); ?></label>
								<?= $this->Form->input('name_of_employer', array('label' => '', 'placeholder' => 'Name of employer', 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<label for="current_position"><?= __('Current Position: '); ?></label>
								<?= $this->Form->input('current_position', array('label' => '', 'required' => 'required')); ?>
							</div>
							<div class="large-4 columns">
								<label for="country"><?= __('Current Country: '); ?></label>
								<?= $this->Form->input('country', array('label' => '', 'type' => 'select', 'options' => $countries, 'default' => 'Ethiopia', 'required' => 'required')); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="large-4 columns">
								&nbsp;
							</div>
							<div class="large-4 columns">
								&nbsp;
							</div>
							<div class="large-4 columns">
								<label for="city"><?= __('Current City: '); ?></label>
								<?= $this->Form->input('city', array('label' => '', 'placeholder' => 'City', 'required' => 'required')); ?>
							</div>
						</div>
                        <div class="row">
                            <div class="large-4 collapse">
                                    Please enter the sum of <strong class="math-challenge"><?= ($mathCaptcha); ?></strong>
                                    <?= '<br>' . $this->Form->input('security_code', array('label' => false,
                                            'placeholder' => 'Enter sum of the numbers above',  'autocomplete' => 'off',
                                            'id' => 'securityCode', 'value' => '', 'type' => 'number', 'min' => 0, 'max' => 100,
                                            'required'));  ?>

                                <?php
                                if (isset($mathCaptcha)) {
                                    echo $this->Form->hidden('mathCaptcha', array('value' => 1));
                                } ?>
                               <div style="margin-bottom: 50px;"></div>
                            </div>
                        </div>
						
						<hr>
						<div class="row">
							<div class="large-10 columns">
								<?= $this->Form->end(array('label' => __('Register', true), 'class' => 'tiny radius button bg-blue', 'name' => 'applyOnline', 'id' => 'saveIt')); ?>
							</div>
							<div class="large-2 columns">
								<?= $this->Html->link(__('Back to Login Page', true), array('controller' => 'users', 'action' => 'login'), array('class' => 'glyph-icon flaticon-back5')); ?>
							</div>
						</div>
					</div>
				</div>

				<?= $this->Form->end(); ?>

		  	<div>
		</div>
	</div>
</div>
    </div>

<script type='text/javascript'>

	var form_being_submitted = false;

	$('#applyOnline').click(function(event) {
		var allFilled = true;
		var isValid = true;

		var radios = document.querySelectorAll('input[type="radio"]');
		var checkedOne = Array.prototype.slice.call(radios).some(x => x.checked);

		// Check all fields with required attribute
		$('form input[required], form select[required], form textarea[required]').each(function() {
			if ($(this).val() === '') {
				allFilled = false;
				isValid = false;
				$(this).css('border', '1px solid red'); // Optionally highlight the empty field
				return false;
			} else {
				$(this).css('border', ''); // Remove highlight if filled
			}
		});

		if (!allFilled) {
			event.preventDefault();
			alert('Please fill all required fields.');
			isValid = false;
			return false;
		}

		if (!checkedOne) {
            alert('Please select gender.');
			isValid = false;
			return false;
		}

		if (form_being_submitted) {
			alert("Submitting your form , please wait a moment...");
			$('#applyOnline').attr('disabled', true);
			isValid = false;
			return false;
		}

		if (!form_being_submitted && allFilled && isValid) {
			$('#applyOnline').val('Registering...');
			form_being_submitted = true;
			isValid = true;
			return true;
		} else {
			isValid = false;
			return false;
		}

	});

	$('form input[required], form select[required], form textarea[required]').on('input change keyup', function() {
		if ($(this).val() !== '') {
			$(this).css('border', '');
		}
	});

	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>

