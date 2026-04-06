<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Staff Study & Commitement Details'; ?></span>
		</div>

		
		<a class="close-reveal-modal">&#215;</a>
			
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns" style="padding: 0px;">
				<div style="margin-top: -30px;"><hr></div>

				<?= $this->Form->create('StaffStudy'); ?>
				<?php //echo $this->Form->hidden('StaffStudy.staff_id', array('value' => $staff_profile['Staff']['id'])); ?>
				<?php //echo $this->Form->hidden('StaffStudy.id'); ?>

				<?php //debug($this->data['Attachment']); ?>

				<fieldset>
					<legend>&nbsp;&nbsp; <?= (isset($staffStudy['Staff']['full_name']) ? ' : ' . $staffStudy['Staff']['full_name'] : ''); ?> &nbsp;&nbsp;</legend>
				
					<div class="large-6 columns">
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.education', array('label' => 'Education: ', 'type' => 'text', 'value' => $staffStudy['StaffStudy']['education'], 'readonly', 'style' => 'width: 90%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.country_id', array('label' => 'Country of Study: ', 'type' => 'text', 'value' => $staffStudy['Country']['name'],  'readonly', 'style' => 'width: 90%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.university_joined', array('label' => 'University Attended: ', 'readonly',  'placeholder' => 'Type University Attended...', 'style' => 'width: 90%;',  'maxlength' => 50)); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.specialization', array('label' => 'Specialization: ', 'readonly',  'placeholder' => 'Type Specialization...', 'style' => 'width: 90%;',  'maxlength' => 50)); ?>
								<br>
							</div>
						</div>
					</div>
					
					<div class="large-6 columns">
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.leave_date', array('label' => 'Leave Date: ',  'disabled', 'minYear' => date('Y') - 10, 'maxYear' => date('Y'), 'orderYear' => 'desc', 'style' => 'width: 30%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?= $this->Form->input('StaffStudy.return_date', array('label' => 'Return Date: ', 'disabled', 'minYear' => date('Y') - 10, 'maxYear' => date('Y') + 10, 'orderYear' => 'desc', 'style' => 'width: 30%;')); ?>
							</div>
						</div>

						<div class="row">
							<div class="large-12 columns">
								<br>
								<?= $this->Form->input('StaffStudy.committement_signed', array('disabled')); ?>
								<br>
							</div>
						</div>
					</div>
					<div class="large-12 columns">
						<?php
						if (!empty($staffStudy['Attachment'])) {
							echo "<table width='100%'>";
							foreach ($staffStudy['Attachment'] as $cuk => $cuv) {
								echo '<tr><td >File uploaded on: ' . $this->Format->humanize_date($cuv['created']) . '</td></tr>';
								if (strcasecmp($cuv['group'], 'Commitement') == 0) {
									echo '<tr><td style="width:100%;" >Commitement<br/>' . $this->Media->embedAsObject($cuv['dirname'] . DS . $cuv['basename'], array('width' => '100%', 'height' => "600px")) . "</td></tr>";
								}
							}
							echo "</table>";
						} ?>
					</div>
				</fieldset>
				<?= $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<!-- <a class="close-reveal-modal">&#215;</a> -->
