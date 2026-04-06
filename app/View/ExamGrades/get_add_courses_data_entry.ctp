<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-check" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Add Missing Course Add & Grade'); ?></span>
		</div>

		<a class="close-reveal-modal">&#215;</a>
	</div>
	<div class="box-body">
        <div class="row">
            <div class="large-12 columns">

                <div style="margin-top: -25px;">
					<hr>
					<!-- <blockquote>
						<h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
						<span style="text-align:justify;" class="fs14 text-gray">This tool will help you to manage missing course adds <b style="text-decoration: underline;"><i>due to prerequisite or other reasons.</i></b></span>
					</blockquote>
					<hr> -->
				</div>


                <!-- ORIGINAL -->
                <?php //echo $this->Form->create('ExamGrade', array('action' => 'data_entry_interface', "method" => "POST")); ?>
                
                <!-- UPDATED -->
                <?= $this->Form->create('ExamGrade', array('action' => 'grade_update', "method" => "POST")); ?>
                
                <?= (isset($student_section_exam_status) && !empty($student_section_exam_status) ? $this->element('student_basic') : ''); ?> 
                
                <?php
                $student_dismissed = false;
                if (isset($student_section_exam_status['StudentExamStatus']['academic_status_id']) && $student_section_exam_status['StudentExamStatus']['academic_status_id'] == DISMISSED_ACADEMIC_STATUS_ID) {  
                    $student_dismissed = true; ?>
                    <div class="warning-box warning-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span>PROCEED WITH CAUTION!! <?= $student_section_exam_status['StudentBasicInfo']['full_name'] . ' (' . $student_section_exam_status['StudentBasicInfo']['studentnumber'] . ')';  ?> is dismissed in <?= $student_section_exam_status['StudentExamStatus']['academic_year'] . ', semester ' . $student_section_exam_status['StudentExamStatus']['semester']; ?>.</div>
                    <hr>
                    <?php
                }

                $add_allowed = true;
                if (isset($already_added_courses_count) && !empty($already_added_courses_count)) {
                    //debug($already_added_courses_count);
                    if (is_numeric(MAXIMUM_COURSES_TO_ADD_PER_SEMESTER) && MAXIMUM_COURSES_TO_ADD_PER_SEMESTER > 0 && $already_added_courses_count >= MAXIMUM_COURSES_TO_ADD_PER_SEMESTER)  {
                        $add_allowed = false;
                    }
                }  
                
                if ($add_allowed) { ?>

                    <div class="row">
                        <div class="large-6 columns">
                            <?= $this->Form->input('Student.college_id', array('label' => 'College/Institute/School: ', 'style' => 'width: 90%;', 'options' => (isset($collegesList) && !empty($collegesList) ? $collegesList : $colleges),  'empty' => ' [ Select College ]', 'id' => 'college_id_1', 'onchange' => 'updateDepartmentCollege(1)')); ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="large-6 columns">
                            <?= $this->Form->input('Student.department_id', array('label' => 'Department: ', 'id' => 'department_id_1', 'options' => (isset($departmentsList) && !empty($departmentsList) ? $departmentsList : $departments), 'style' => 'width: 90%;', 'onchange' => 'updateSection(1)', 'empty' => '[ Select College First ]')); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="large-6 columns">

                            <?= $this->Form->input('Student.section_id', array('label' => 'Section: ', 'id' => 'section_id_1', 'style' => 'width: 90%;', 'empty' => ' [ Select Department First ]', 'onchange' => 'updatePublishedCourse(1,"' . join(',', $addParamaters) . '")')); ?>

                            <?= $this->Form->hidden('Student.studentnumber', array('value' => (str_replace('-', '/', $addParamaters['studentnumber'])))); ?>
                            <?= $this->Form->hidden('Student.semester', array('value' => $addParamaters['semester'])); ?>
                            <?= $this->Form->hidden('Student.acadamic_year', array('value' => $addParamaters['academic_year'])); ?>
                        </div>
                    </div>

                    <hr>

                    <!-- AJAX LOADING -->
                    <div id="get_published_add_courses_id_1">

                    </div>
                    <!-- END AJAX LOADING -->

                    <?php 
                } else { ?>
                    <div class="error-box error-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span><?= $student_section_exam_status['StudentBasicInfo']['full_name'] . ' (' . $student_section_exam_status['StudentBasicInfo']['studentnumber'] . ')';  ?> already added <?= $already_added_courses_count . ' ' . ($already_added_courses_count == 1  ? 'course' : 'courses') . ' for ' . (str_replace('-', '/', $addParamaters['academic_year'])) . ', semester ' . $addParamaters['semester'] . '. Only ' . MAXIMUM_COURSES_TO_ADD_PER_SEMESTER . ' ' . (MAXIMUM_COURSES_TO_ADD_PER_SEMESTER == 1 ? 'course is' : 'courses are') .  ' allowed to add per semester.'; ?></div>
                    <hr>
                    <?php
                } ?>

            </div>
        </div>
    </div>
</div>

