<?php
if (isset($students) && !empty($students)) { ?>
    <div class="row">
	    <div class="large-2 columns">
            <?php
            $profile_picture_found = 0;

            if (isset($students['Attachment']) && !empty($students['Attachment'])) {
                if ($this->Media->file($students['Attachment'][0]['dirname'] . DS . $students['Attachment'][0]['basename']) && $students['Attachment'][0]['group'] == 'profile') {
                    $profile_picture_found = 1;
                    echo $this->Media->embed($this->Media->file($students['Attachment'][0]['dirname'] . DS . $students['Attachment'][0]['basename']), array('width' => '144', 'class' => 'profile-picture'));
                } else {
                    foreach ($students['Attachment'] as $ak => $av) {
                        if (!empty($av['dirname']) && !empty($av['basename']) && $av['group'] == 'profile') {
                            if ($this->Media->file($av['dirname'] . DS . $av['basename'])) {
                                $profile_picture_found = 1;
                                //debug($profile_picture_found);
                                echo $this->Media->embed($this->Media->file($av['dirname'] . DS . $av['basename']), array('width' => '144', 'class' => 'profile-picture'));
                                break;
                            }
                        }
                    }

                    if (!$profile_picture_found) {
                        echo '<br><span style="color: red;">Student Photo deleted.</span><br>';
                        echo '<img src="/img/noimage.jpg"  width="144" class="profile-picture">';
                    }
                }
            } else {
                echo '<img src="/img/noimage.jpg"  width="144" class="profile-picture">';
            }  ?>
            <br>
            <br>
        </div>

        <div class="large-10 columns">
            <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" class="table-borderless">
                    <tbody>
                        <tr> 
                            <td rowspan="11" style="background-color: white; width: 3%;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Full Name: &nbsp; <b><?= (isset($students['Student']['full_name']) ? $students['Student']['full_name'] : ''); ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Student ID: &nbsp; <b><?= (isset($students['Student']['studentnumber']) ? $students['Student']['studentnumber'] : ''); ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;"><?= (isset($students['College']['type']) && !empty($students['College']['type']) ? $students['College']['type'] : 'College'); ?>: &nbsp; <b><?= $students['College']['name']; ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;"><?= (isset($students['Department']['type']) && !empty($students['Department']['type']) ? $students['Department']['type'] : 'Department'); ?>: &nbsp; <b><?= (isset($students['Department']['name']) && !empty($students['Department']['name']) ? $students['Department']['name'] : (isset($students['Program']['id']) && $students['Program']['id'] == PROGRAM_REMEDIAL ? 'Remedial' : 'Pre/Freshman')); ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Program: &nbsp; <b><?= (isset($students['Program']['name']) && !empty($students['Program']['name']) ? $students['Program']['name'] : ''); ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Program Type: &nbsp; <b><?= (isset($students['ProgramType']['name'])  && !empty($students['ProgramType']['name']) ?  $students['ProgramType']['name'] : ''); ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: white;">Graduated: &nbsp; <b>
                                <?php
                                if (isset($students['GraduateList']['id']) && !empty($students['GraduateList']['id'])) {
                                    echo 'Yes <br>(' . (trim($students['Curriculum']['english_degree_nomenclature'])) . ')';
                                } else if ((isset($students['Department']) && empty($students['Department']['id'])) || (isset($students['Program']['id']) && $students['Program']['id'] == PROGRAM_REMEDIAL)) {
                                    echo 'Not Applicable';
                                }  else if (!isset($students['GraduateList']['id'])) {
                                    echo 'No';
                                } ?> </b>
                            </td>
                        </tr>
                        <?php
                        if (isset($students['GraduateList']['id']) && !empty($students['GraduateList']['id'])) { ?>
                            <tr><td style="background-color: white;">Date Graduated: &nbsp; <b><?= $this->Time->format("M j, Y", $students['GraduateList']['graduate_date'], NULL, NULL); ?></b></td></tr>
                            <tr><td style="background-color: white;">CGPA: &nbsp; <b><?= $students['StudentExamStatus'][0]['cgpa']; ?></b></td></tr>
                            <?php
                            //debug($students['ExitExam']);
                            if (!empty($students['ExitExam'])) { ?>
                                <tr><td style="background-color: white;">Exit Exam: &nbsp; <b><?= ($students['ExitExam'][0]['result'] >= 50 ? 'Pass (' . $students['ExitExam'][0]['result'] . '%)' : '***'); ?></b></td></tr>
                                <?php
                            }
                        }
                        
                        if (isset($students['Student']['graduated']) && !$students['Student']['graduated'] && !isset($students['GraduateList']['id']) && !empty($students['ExitExam']) && SHOW_EXIT_EXAM_RESULTS_FOR_NOT_GRADUATED_STUDENTS_ON_CHECK_GRADUATES == 1) { 
                            $valid_exam_date = false;
                            if (isset($students['ExitExam'][0]['exam_date']) && !empty($students['ExitExam'][0]['exam_date'])) {
                                $dt = DateTime::createFromFormat('Y-m-d', $students['ExitExam'][0]['exam_date']);
                                if ($dt && $dt->format('Y-m-d') === $students['ExitExam'][0]['exam_date']) {
                                    $valid_exam_date = true;
                                }
                            } ?>
                            <tr><td style="background-color: white;">Exit Exam: &nbsp; <b><?= ($students['ExitExam'][0]['result'] >= 50 ? 'Pass (' . $students['ExitExam'][0]['result'] . '%)' : ($students['ExitExam'][0]['result'] < 50 ? 'Fail (' . $students['ExitExam'][0]['result'] . '%)' : '***')) . ($valid_exam_date ? ', ' . $this->Time->format("M Y", $students['ExitExam'][0]['exam_date'], NULL, NULL) : ''); ?></b></td></tr>
                            <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
} ?>