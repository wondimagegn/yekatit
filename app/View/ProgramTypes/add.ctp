<div class="box">
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div class="programTypes form">
					<?= $this->Form->create('ProgramType'); ?>
					<fieldset>
						<legend><?= __('Add Program Type'); ?></legend>
						<?php
						echo $this->Form->input('name');
						echo $this->Form->input('description');
						?>
					</fieldset>
					<?= $this->Form->end(array('label' => __('Submit'), 'class' => 'tiny radius button bg-blue')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
