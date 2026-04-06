<div class="box">
	<div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-plus" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Set Certification Course Setting'); ?></span>
        </div>
    </div>
    <div class="box-body">
    	<div class="row">
	  		<div class="large-12 columns">
				<div style="margin-top: -30px;"><hr></div>
				<div class="programTypes form">
					<fieldset style="padding-top: 15px; padding-bottom: 0px;">
                        
						<?= $this->Form->create('CertificationCourseSetting'); ?>

                        <div class="row">
                            <div class="large-3 columns">
                                <?= $this->Form->input('academic_year', array('options' => $acyear_array_data, 'default' => $defaultacademicyear, 'style' => 'width: 90%;', 'required' => true, 'id' => 'AcademicYear')); ?>
                            </div>
                            <div class="large-2 columns">
                                <?= $this->Form->input('semester', array('options' => Configure::read('semesters'), 'style' => 'width: 90%;', 'required' => true,  'default' => $current_semester, 'id' => 'Semester')) ?>
                            </div>
                            <div class="large-2 columns">
                                <?= $this->Form->input('program_id', array('options' => $programs, 'default' => PROGRAM_UNDEGRADUATE,  'required' => true, 'id' => 'ProgramId', 'style' => 'width: 90%;')); ?>
                            </div>
                            <div class="large-2 columns">
                                <?= $this->Form->input('pass_score', array('id' => 'pass_score ', 'type' => 'number', 'value' => (isset($this->request->data['CertificationCourseSetting']['pass_score']) ? $this->request->data['CertificationCourseSetting']['pass_score'] : DEFAULT_ESHE_SSS_COURSES_COMPLETION_PASS_SCORE), 'min' => 50,  'max' => 100, 'step' => '1', 'style' => 'width:90%;')); ?>
                            </div>
                            <div class="large-3 columns">
                                <?= $this->Form->input('required_courses_count', array('id' => 'required_courses_count ', 'type' => 'number', 'value' => (isset($this->request->data['CertificationCourseSetting']['required_courses_count']) ? $this->request->data['CertificationCourseSetting']['required_courses_count'] : DEFAULT_ESHE_SSS_COURSES_TO_COMPLETE), 'min' => 0,  'max' => (isset($certification_course_id) && !empty($certification_course_id) ? count($certification_course_id) : 7), 'step' => '1', 'style' => 'width:90%;')); ?>
                            </div>
                        </div>
						 <div class="row">
                            <div class="large-12 columns"><hr></div>
                            <div class="large-8 columns">
								<?= $this->Form->input('certification_course_id', array('id' => 'certification_course_id', 'type' => 'select', 'multiple' => 'checkbox',  'options' => $certificationCourses, 'label' => 'Select Certification Courses: ', 'required')); ?>
							</div>
	  						<div class="large-4 columns">
								<?= $this->Form->input('program_type_ids_to_exclude', array('id' => 'program_type_ids_to_exclude', 'type' => 'select', 'multiple' => 'checkbox',  'options' => $programTypes, 'label' => 'Program Types to Exclude: ', 'error' => false)); ?>
							</div>
						</div>
                         <div class="row">
                            <div class="large-12 columns"><hr></div>
                        </div>
                        <div class="row">
                            <div class="large-8 columns">
                                <?= $this->Form->input('status', array('type' => 'checkbox', 'checked' => (isset($this->request->data['CertificationCourseSetting']['status']) ? $this->request->data['CertificationCourseSetting']['status'] : false))); ?>
                                <?= $this->Form->input('hold_registration_for_students', array('type' => 'checkbox', 'checked' => (isset($this->request->data['CertificationCourseSetting']['hold_registration_for_students']) ? $this->request->data['CertificationCourseSetting']['hold_registration_for_students'] : 'checked'))); ?>
                                <?= $this->Form->input('hold_registration_for_registrar', array('type' => 'checkbox', 'checked' => (isset($this->request->data['CertificationCourseSetting']['hold_registration_for_registrar']) ? $this->request->data['CertificationCourseSetting']['hold_registration_for_registrar'] : false))); ?>
                                <?= $this->Form->input('show_notifications', array('type' => 'checkbox', 'checked' => (isset($this->request->data['CertificationCourseSetting']['show_notifications']) ? $this->request->data['CertificationCourseSetting']['show_notifications'] : 'checked'))); ?>
                            </div>
                        </div>
						<hr>
						<?= $this->Form->end(array('label' => __('Add Setting'), 'name' => 'addSetting', 'id' => 'addSetting', 'class' => 'tiny radius button bg-blue')); ?>
					</fieldset>
				</div>   
			</div>
		</div>
    </div>
</div>
