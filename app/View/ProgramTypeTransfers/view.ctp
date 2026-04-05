<div class="box">
    <div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-info-outline" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Program Transfer Details'); ?> <?= (isset($students) ? ' - ' . array_values($students)[0] : 'of Student'); ?></span>
		</div>
	</div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns" style="margin-top: -30px;">
                <hr>
                <?= $this->Form->create('ProgramTypeTransfer'); ?>
				<?php $isGraduated = 1; ?>
				<fieldset style="padding-bottom: 5px;">
					<!-- <legend>&nbsp;&nbsp; Select applicable program type for transfer  &nbsp;&nbsp;</legend> -->
					<div class="row">
						<div class="large-8 columns">
							<?= $this->Form->input('student_id', array('style' => 'width:96%;', 'options' => $students, 'required', 'disabled' => $isGraduated)); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('program_type_id', array('style' => 'width:96%;', 'required', 'disabled' => $isGraduated)); ?>
						</div>
					</div>
					<div class="row">
						<div class="large-4 columns">
							<?= $this->Form->input('academic_year', array('style' => 'width:96%;', 'type' => 'select', 'options' => (isset($acyear_array_data_custom) && !empty($acyear_array_data_custom) ? $acyear_array_data_custom : $acyear_array_data), 'required', 'disabled' => $isGraduated)); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('semester', array('style' => 'width:96%;', 'options' => Configure::read('semesters'),  'required', 'disabled' => $isGraduated)); ?>
						</div>
						<div class="large-4 columns">
							<?= $this->Form->input('transfer_date', array('style' => 'width:30%;', 'disabled' => $isGraduated)); ?>
						</div>
					</div>
				</fieldset>
            </div>
        </div>
    </div>
</div>
