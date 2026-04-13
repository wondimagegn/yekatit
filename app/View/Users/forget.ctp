			<h5 class="mb-3 text-dark">Forgot Password?</h5>
			<hr>
			<?php
			$flash = $this->Session->read('Message.flash');
			if (!empty($flash['message'])) {
				$msg = h($flash['message']);
				$type = isset($flash['params']['class']) ? h($flash['params']['class']) : 'info';
				$delay = isset($flash['params']['delay']) ? (int)$flash['params']['delay'] : 5000; ?>
				<script>
					document.addEventListener('DOMContentLoaded', function () {
						if (typeof showToast === 'function') {
						showToast("<?= $msg ?>", "<?= $type ?>", <?= $delay ?>);
						}
					});
				</script>
				<?php
			} else {
				$flash_message = $this->Session->flash();
				if (!empty($flash_message)) {
					echo $flash_message . '<br>';
				}
			} ?>

            <!-- Passive Alert -->
            <div class="alert alert-warning alert-dismissible fade show mb-4" id="passiveAlert" role="alert">
                <i class="fas fa-bell me-2"></i>
                If you don’t find an email from SIS in your inbox after submitting this form and receiving a success message, kindly check your <em>Spam</em> or <em>Junk</em> folders before attempting another request.<br />
                <strong>Note:</strong> The link is valid for <strong><?= (isset($tokenExpiration) && !empty($tokenExpiration) ?  $tokenExpiration : '30 minutes'); ?></strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="shrinkForgotBox()"></button>
            </div>

			<?= $this->Form->create('User', array('id' => 'forgotForm', 'action' => 'forget')); ?>

			<div class="mb-3 input-group">
				<span class="input-group-text bg-primary text-white"><i class="fas fa-envelope"></i></span>
				<!-- <input type="email" class="form-control" id="userEmail" placeholder="Email" required autocomplete="off" /> -->
				<?= $this->Form->input('email', array('id'=> 'userEmail', 'size' => '40', 'placeholder' => 'Email', 'class' => 'form-control', 'label' => false, 'required', 'autocomplete' => 'off', 'div' => false)); ?>
			</div>

			<div class="mb-2 text-start small">
				Please enter the sum of <strong class="math-challenge"><?= ($mathCaptcha); ?></strong>
			</div>

			<div class="mb-3 input-group">
				<span class="input-group-text bg-primary text-white"><i class="fas fa-shield-alt"></i></span>
				<!-- <input type="number" class="form-control" id="securityCode" placeholder="Security Code" min="0" max="100" required /> -->
				<?= $this->Form->input('security_code', array('id' => 'securityCode', 'label' => false, 'class' => 'form-control', 'placeholder' => 'Enter sum of the numbers above', 'required',  'autocomplete' => 'off', 'type' => 'number', 'min' => 0, 'max' => 100, 'div' => false));  ?>
			</div>

			

			<div class="login-button">
				<!-- <button type="submit" class="btn btn-primary w-100">Reset Password</button> -->
				<?= $this->Form->submit(__('Reset Password', true), array('class' => 'btn btn-primary w-100')); ?>
			</div>

			<div class="mt-3">
				<?= $this->Html->link(__('Back to Login Page', true), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-secondary w-100')); ?>
			</div>
			

            <?= $this->Form->end(); ?>

        