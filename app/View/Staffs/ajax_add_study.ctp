<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Add Staff Study' . (isset($staff_profile['Staff']['full_name']) ? ' : ' . $staff_profile['Staff']['full_name'] : ''); ?></span>
		</div>

		
		<a class="close-reveal-modal">&#215;</a>
			
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns" style="padding: 0px;">
				<div style="margin-top: -30px;"><hr></div>

				<?= $this->Form->create('StaffStudy', array('action' => 'add_staff_study', "method" => "POST", 'enctype' => 'multipart/form-data')); ?>
				<?= $this->Form->hidden('StaffStudy.staff_id', array('value' => $staff_profile['Staff']['id'])); ?>
				<?= $this->Form->hidden('StaffStudy.id'); ?>

				<?php //debug($this->data['Attachment']); ?>

				<fieldset style="padding-bottom: 5px;">
					<legend>&nbsp;&nbsp; Please provide the study attended with university & commitement &nbsp;&nbsp;</legend>
				
					<div class="large-6 columns">
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.education', array('label' => 'Education: ',  'required' => 'required',  'style' => 'width: 90%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.country_id', array('label' => 'Country of Study: ', 'default' => 68, 'options' => $countries, 'style' => 'width: 90%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.university_joined', array('label' => 'University Attended: ', 'placeholder' => 'Type University Attended...', 'style' => 'width: 90%;',  'maxlength' => 50)); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.specialization', array('label' => 'Specialization: ', 'placeholder' => 'Type Specialization...', 'style' => 'width: 90%;',  'maxlength' => 50)); ?>
								<br>
							</div>
						</div>
					</div>
					
					<div class="large-6 columns">
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.leave_date', array('label' => 'Leave Date: ', 'minYear' => date('Y') - 10, 'maxYear' => date('Y'), 'orderYear' => 'desc', 'style' => 'width: 30%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.return_date', array('label' => 'Return Date: ', 'minYear' => date('Y') - 10, 'maxYear' => date('Y') + 10, 'orderYear' => 'desc', 'style' => 'width: 30%;')); ?>
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<br>
								<?= $this->Form->input('StaffStudy.committement_signed'); ?>
								<br>
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<?php
								// /debug($this->Media->file($this->data['Attachment'][0]['dirname'] . DS . $this->data['Attachment'][0]['basename']));
								if (isset($this->data['Attachment'][0]) && $this->Media->file($this->data['Attachment'][0]['dirname'] . DS . $this->data['Attachment'][0]['basename'])) { ?>
									<a href="<?= $this->Media->url($this->data['Attachment'][0]['dirname'] . DS . $this->data['Attachment'][0]['basename'], true); ?>" target=_blank>View Commitement Attachment</a><br>
									<?= isset($staff_profile['StaffStudy'][0]['Attachment'][0]['basenameFormarted']) ? $staff_profile['StaffStudy'][0]['Attachment'][0]['basenameFormarted'] : $this->data['Attachment'][0]['basename']; ?> (<?= $size = $this->Number->toReadableSize($this->Media->size($this->Media->file($this->data['Attachment'][0]['dirname'] . DS . $this->data['Attachment'][0]['basename']))); ?>)
									<?php echo $this->Media->embed($this->Media->file($this->data['Attachment'][0]['dirname'] . DS . $this->data['Attachment'][0]['basename']), array('width' => '144', 'height' => '144'));  ?>
									<?php
								} else {
									echo $this->Form->input('Attachment.0.file', array('type' => 'file', 'label' => 'Attach Commitement: ', 'accept' => '.pdf')); 
								} ?>
							</div>
						</div>
					</div>
					<hr>

					<?php $button_lebel = (isset($staff_profile['StaffStudy']) && !empty($staff_profile['StaffStudy'])) ? 'Maintain Study' : 'Add Study'; ?>

					<?= $this->Form->Submit($button_lebel, array('name' => 'addStudy', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
				</fieldset>
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<!-- <a class="close-reveal-modal">&#215;</a> -->
