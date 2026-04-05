<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-vcard" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Add Program Transfer For Student'); ?> <?= (isset($student_section_exam_status['StudentBasicInfo']['full_name']) ? ' - ' . $student_section_exam_status['StudentBasicInfo']['full_name'] . ' (' . $student_section_exam_status['StudentBasicInfo']['studentnumber'] . ')' : ''); ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns" style="margin-top: -30px;">
                <hr>
                <?= $this->Form->create('ProgramTypeTransfer'); ?>
                <?php

                use PSpell\Config;

                if (!isset($studentIDs)) { ?>
                    <fieldset style="padding-bottom: 5px;">
                        <legend>&nbsp;&nbsp; Student Number / ID &nbsp;&nbsp;</legend>
                        <div class="row">
                            <div class="large-4 columns">
                                <?= $this->Form->input('studentID', array('label' => false, 'placeholder' => 'Type Student ID...', 'required', 'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB)); ?>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <?= $this->Form->Submit('Search', array('name' => 'continue', 'id' => 'continue', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
                    <?php
                }
				
                if (isset($studentIDs) && !empty($studentIDs)) {
					//debug($student_section_exam_status);
					//$kk = ClassRegistry::init('ProgramTypeTransfer')->getStudentProgramType($student_section_exam_status['StudentBasicInfo']['id']);
					//debug($kk);
					if (isset($student_id) && !empty($student_id)) {
						echo $this->Form->hidden('student_id', array('value' => $student_id));
					} else {
						echo $this->Form->hidden('student_id', array('value' => $student_section_exam_status['StudentBasicInfo']['id']));
					}

                    $this->assign('title_details', (!empty($this->request->params['controller']) ? ' ' . Inflector::humanize(Inflector::underscore($this->request->params['controller'])) . (!empty($this->request->params['action']) && $this->request->params['action'] != 'index' ? ' | ' . ucwords(str_replace('_', ' ', $this->request->params['action'])) : '') : '') . (isset($student_section_exam_status['StudentBasicInfo']['full_name']) ? ' - ' . $student_section_exam_status['StudentBasicInfo']['full_name'] . ' (' . $student_section_exam_status['StudentBasicInfo']['studentnumber'] . ')' : '')); ?>
					
                    <blockquote>
                        <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                        <p style="text-align:justify;"><span class="fs16 text-black">Initiating a student program transfer <strong class="rejected">will detach the student from currently attached curriculum and make the student section-less</strong>. It also <strong class="rejected">affects how the student's CGPA is calculated</strong> before and after the transfer date. For accuracy and consistency, it is recommended to perform program transfers at the end of an academic year or semester.</span></p>
                    </blockquote>
                    <hr>
					
					<fieldset style="padding-bottom: 5px;">
                        <legend>&nbsp;&nbsp; Select applicable program type for transfer  &nbsp;&nbsp;</legend>

						<div class="row">
            				<div class="large-4 columns">
								<div class="large-12 columns">
									<?= $this->Form->input('program_type_id', array('style' => 'width:96%;')); ?>
								</div>
								<div class="large-12 columns">
									<?= $this->Form->input('academic_year', array('style' => 'width:96%;', 'type' => 'select', 'options' => $acyear_array_data, 'empty' => '[ Select Academic Year ]', 'default' => (isset($defaultacademicyear) ? $defaultacademicyear : ''))); ?>
								</div>
								<div class="large-12 columns">
									<?= $this->Form->input('semester', array('style' => 'width:96%;', 'options' => Configure::read('semesters'), 'empty' => ' [ Select Semester ]')); ?>
								</div>
								<div class="large-12 columns">
									<?= $this->Form->input('transfer_date', array('style' => 'width:30%;')); ?>
								</div>
							</div>
							<div class="large-8 columns">
								<?= $this->element('student_basic'); ?>
							</div>
						</div>
						<hr>
						<?= $this->Form->Submit('Save Transfer', array('name' => 'saveTransfer', 'id' => 'saveTransfer', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
					</fieldset>
					<?php
                } ?>
            </div>
        </div>
    </div>
</div>
