<div class="box">
	<div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-edit" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= 'Edit Student Status Pattern' . (isset($this->data['Program']['name']) ? ' for ' . $this->data['Program']['name'] . (isset($this->data['ProgramType']['name']) ? ', ' . $this->data['ProgramType']['name']  : '') : ''); ?></span>
        </div>
    </div>
    <div class="box-body">
    	<div class="row">
	  		<div class="large-12 columns">
             	<div style="margin-top: -30px;"><hr></div>

				<blockquote>
					<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
					<span style="text-align:justify;" class="fs16 text-black">The status pattern helps to display students' academic status on their grade report by considering their program and program type. The academic year start specifies from which acacemic year the pattern begins and the pattern specifies how many semesters should be used for status determination.</span>
				</blockquote>
				<hr>

				<div class="studentStatusPatterns form">
					<fieldset style="padding-top: 15px; padding-bottom: 0px;">
						<?= $this->Form->create('StudentStatusPattern'); ?>
						<?= $this->Form->input('id'); ?>

						<div class="row">
							<div class="large-3 columns">
								<?= $this->Form->input('program_id', array('label' => 'Program: ', 'style' => 'width: 90%;')); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('program_type_id', array('label' => 'Program Type: ', 'style' => 'width: 90%;')); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('acadamic_year', array('label' => 'Starting From: ', 'style' => 'width: 90%;', 'type' => 'select', 'options' => $ac_year_list)); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('application_date', array('label' => 'Application Date: ', 'style' => 'width: 30%;', 'minYear' => APPLICATION_START_YEAR, 'maxYear' => date('Y'), 'orderYear' => 'desc')); ?>
							</div>
						</div>

						<div class="row">
							<div class="large-3 columns">
								<?= $this->Form->input('pattern', array('label' => 'Pattern: (No of Semesters)', 'style' => 'width: 90%;', 'options' => array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5))); ?>
							</div>
							<div class="large-6 columns">
								<?= $this->Form->input('description', array('label' => 'Description: ', 'style' => 'width: 95%;')); ?>
							</div>
							<div class="large-3 columns">
								&nbsp;
							</div>
						</div>
						<hr>
						<?= $this->Form->end(array('label' => __('Save Changes'), 'class' => 'tiny radius button bg-blue')); ?>
					</fieldset>
				</div>
	  		</div>
		</div>
    </div>
</div>
