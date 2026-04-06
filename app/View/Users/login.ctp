		<h5 class="text-dark mb-3">Login to SIS</h5>
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

		<?= $this->Form->create('User', array('action' => 'login')); ?>
		
		<div class="mb-3 input-group">
			<span class="input-group-text bg-transparent text-dark">
				<i class="fas fa-user"></i>
			</span>
			<?= $this->Form->input('username', array('placeholder' => 'Username', 'class' => 'form-control', 'label' => false, 'autocomplete' => 'off', 'id' => 'Text1', 'required', 'div' => false)); ?>
		</div>
		<div class="mb-3 input-group">
			<span class="input-group-text bg-transparent text-dark">
				<i class="fas fa-key"></i>
			</span>
			<?= $this->Form->input('password', array('label' => false, 'autocomplete' => "off", 'class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'id' => "Text2", 'required', 'div' => false)); ?>
		</div>

		<?php
		if (isset($mathCaptcha)) { ?>
			<div class="mb-3 input-group">
				<span class="input-group-text bg-transparent text-dark">
					<i class="fas fa-shield-alt"></i>
				</span>
				<?= $this->Form->input('security_code', array('type' => 'number', 'label' => false, 'class' => 'form-control', 'autocomplete' => 'off', 'id' => 'securityCode', 'min' => 0, 'max' => 100, 'placeholder' => 'Enter the sum of ' . $mathCaptcha, 'required', 'div' => false)); ?>
			</div>
			<?php
		} ?>

		<?= ($this->Form->Submit('Login', array('id' => 'loginButton', 'class' => 'btn btn-primary w-100', 'div' => false))); ?>
		
		<div class="mt-3">
			<?= $this->Html->link(__('Forgot Password?', true), array('action' => 'forget'), array('class' => 'btn btn-secondary w-100', 'target' => '_blank')); ?>
		</div>

		<?= $this->Form->end(); ?>

		<script>
			if (window.history.replaceState) {
				window.history.replaceState(null, null, window.location.href);
			}
		</script>
