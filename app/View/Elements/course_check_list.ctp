<?php 
$exemptedCourses = array();
$allTakenCourses = array();
$exempted_courses_credit_sum = 0;
$exempted_courses_count = 0;

$from_other_curriculum_and_mapped = array();

//debug($student_academic_profile['Curriculum']);

if (isset($student_academic_profile['CourseExemption'])) {
    foreach ($student_academic_profile['CourseExemption'] as $in => $exCourse) {
        if (isset($exCourse['Course']) && !empty($exCourse['Course'])) {
            if (isset($exCourse['registrar_confirm_deny'])) {
                if ($exCourse['registrar_confirm_deny'] == true) {
                    $exempted_courses_count++;
                    $exempted_courses_credit_sum += $exCourse['Course']['credit'];
                    $exemptedCourses[$exCourse['Course']['id']] = $exCourse['Course']['id'];
                    $allTakenCourses[$exCourse['Course']['id']] = $exCourse['Course']['id'];
                }
            }
        }
    }
} 


if (isset($student_academic_profile['Course Registered'])) {
    foreach ($student_academic_profile['Course Registered'] as $in => $regCourse) {
        if (isset($regCourse['otherCurriculum']) && $regCourse['otherCurriculum']) {
            // debug($regCourse['otherCurriculum']);
            // debug($regCourse['course_id']);
            // debug($regCourse['mapped']);
            $from_other_curriculum_and_mapped[$regCourse['course_id']] = $regCourse['mapped'];
        }
    }
} 

if (isset($student_academic_profile['Course Added'])) {
    foreach ($student_academic_profile['Course Added'] as $in => $addCourse) {
        if (isset($addCourse['otherCurriculum']) && $addCourse['otherCurriculum']) {
            // debug($addCourse['otherCurriculum']);
            // debug($addCourse['course_id']);
            // debug($addCourse['mapped']);
            $from_other_curriculum_and_mapped[$addCourse['course_id']] = $addCourse['mapped'];
        }
    }
}

$credit_type = 'Credit';

if (isset($student_academic_profile['Curriculum']['type_credit']) && !empty($student_academic_profile['Curriculum']['type_credit'])) {
    if (count(explode('ECTS', $student_academic_profile['Curriculum']['type_credit'])) >= 2) {
        $credit_type = 'ECTS';
    }
} ?>

<div class="row">
    <div class="large-12 columns">
        <div class="tabs-content edumix-tab-horz">
            <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" class="table">
                    <tr>
                        <td style="width:15%;text-align:left; font-weight:bold;">Full Name</td>
                        <td style="text-align:left; font-weight:bold;"><?= $student_academic_profile['BasicInfo']['Student']['full_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:15%;text-align:left; font-weight:bold;">ID Number</td>
                        <td style="text-align:left; font-weight:bold;"><?= $student_academic_profile['BasicInfo']['Student']['studentnumber']; ?></td>
                    </tr>
                    <?php
                    if (is_null($student_academic_profile['BasicInfo']['Student']['department_id']) || empty($student_academic_profile['BasicInfo']['Student']['department_id'])) { ?>
                        <tr>
                            <td style="width:15%;text-align:left; font-weight:bold;"><?= (isset($student_academic_profile['BasicInfo']['College']['type']) && !empty($student_academic_profile['BasicInfo']['College']['type']) ? $student_academic_profile['BasicInfo']['College']['type'] : 'College'); ?></td>
                            <td style="text-align:left; font-weight:bold;"><?= $student_academic_profile['BasicInfo']['College']['name']; ?></td>
                        </tr>
                        <?php
                    } ?>
                    <tr>
                        <td style="width:15%;text-align:left; font-weight:bold;"><?= (isset($student_academic_profile['BasicInfo']['Department']['type']) && !empty($student_academic_profile['BasicInfo']['Department']['type']) ? $student_academic_profile['BasicInfo']['Department']['type'] : 'Department'); ?></td>
                        <td style="text-align:left; font-weight:bold;"><?= (isset($student_academic_profile['BasicInfo']['Department']['name']) ? $student_academic_profile['BasicInfo']['Department']['name'] : '---'); ?></td>
                    </tr>
                    <tr>
                        <td style="width:15%;text-align:left; font-weight:bold;">Program</td>
                        <td style="text-align:left; font-weight:bold;"><?= $student_academic_profile['BasicInfo']['Program']['name']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:15%;text-align:left; font-weight:bold;">Program Type</td>
                        <td style="text-align:left; font-weight:bold;"><?= $student_academic_profile['BasicInfo']['ProgramType']['name']; ?></td>
                    </tr>
                </table>
            </div>
            <hr>

            <?php
            if ($student_academic_profile['BasicInfo']['Student']['graduated']) { ?>
                <div class="info-box info-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span><?= $student_academic_profile['BasicInfo']['Student']['full_name_studentnumber']; ?> is graduated student and you are accessing graduated student profile. <br></div>
                <hr>
                <?php
            } ?>

            <?php
            $student_copys = $student_academic_profile['Exam Result'];
            if (isset($student_copys) && !empty($student_copys)) { ?>
                <div style="overflow-x:auto;">
                    <table cellpadding="0" cellspacing="0" class="table">
                        <thead>
                            <tr>
                                <th style="width:2%;" class="center">#</th>
                                <th style="width:10%" class="vcenter">Course Code</th>
                                <th style="width:30%" class="vcenter">Course Title</th>
                                <th style="width:5%;" class="center"><?= $credit_type; ?></th>
                                <th style="width:5%;" class="center">Grade</th>
                                <th style="width:5%;" class="center">Pass Grade</th>    
                                <th class="center">Curriculum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c_count = 0;
                            $credit_hour_sum_reg = 0;
                            $credit_hour_sum_pass = 0;
                            $pass_courses_count = 0;
                            $fail_courses_count = 0;
                            $credit_hour_sum_fail = 0;
                            $grade_point_sum = 0;
                            $taken_exempted_courses_sum = 0;
                            $takenCourses = array();
                            $takenAndEquivalent = array();
                            $c_grade_count = 0;
                            $c_plus_grade_count = 0;
                            $c_grade_courses = array();
                            $c_plus_grade_courses = array();

                            foreach ($student_copys as $index => $student_copy) {
                                if (isset($student_copy['courses']) && !empty($student_copy['courses'])) {
                                    foreach ($student_copy['courses'] as $key => $course_reg_add) {
                                        //debug($course_reg_add);
                                        $c_count++;
                                        if (isset($course_reg_add['Grade']['grade'])) {
                                            if (isset($course_reg_add['Grade']['used_in_gpa']) && $course_reg_add['Grade']['used_in_gpa'] == 1) {
                                                if ($course_reg_add['Grade']['pass_grade']) {
                                                    $pass_courses_count++;
                                                    //if ($course_reg_add['firstTime']) {
                                                        $credit_hour_sum_pass += $course_reg_add['Course']['credit'];
                                                        $credit_hour_sum_reg += $course_reg_add['Course']['credit'];
                                                        $grade_point_sum += ($course_reg_add['Grade']['point_value'] * $course_reg_add['Course']['credit']);
                                                    //}
                                                } else {
                                                    $credit_hour_sum_fail += $course_reg_add['Course']['credit'];
                                                    $credit_hour_sum_reg += $course_reg_add['Course']['credit'];
                                                    $fail_courses_count++;
                                                }
                                            } else if (isset($course_reg_add['Grade']['used_in_gpa']) && $course_reg_add['Grade']['used_in_gpa'] == 0) {
                                                if ($course_reg_add['Grade']['pass_grade']) {
                                                    //if ($course_reg_add['firstTime']) {
                                                        $credit_hour_sum_pass += $course_reg_add['Course']['credit'];
                                                        $credit_hour_sum_reg += $course_reg_add['Course']['credit'];
                                                    //}
                                                    $pass_courses_count++;
                                                } else {
                                                    $credit_hour_sum_fail += $course_reg_add['Course']['credit'];
                                                    $credit_hour_sum_reg += $course_reg_add['Course']['credit'];
                                                    $fail_courses_count++;
                                                }
                                            } else if (strcasecmp($course_reg_add['Grade']['grade'], 'I') == 0) {
                                                $credit_hour_sum_reg += $course_reg_add['Course']['credit'];
                                            }

                                            if (isset($student_academic_profile['BasicInfo']['Program']['id']) && ($student_academic_profile['BasicInfo']['Program']['id'] == PROGRAM_POST_GRADUATE || $student_academic_profile['BasicInfo']['Program']['id'] == PROGRAM_PhD)){
                                                if (strcasecmp($course_reg_add['Grade']['grade'], 'C') == 0) {
                                                    $c_grade_count ++;
                                                    $c_grade_courses[] = $course_reg_add['Course']['course_title'] . ' ('. $course_reg_add['Course']['course_code'] . ') ('. $course_reg_add['Course']['credit'] . ' ' . $credit_type . ')';
                                                } else if (strcasecmp($course_reg_add['Grade']['grade'], 'C+') == 0) {
                                                    $c_plus_grade_count ++;
                                                    $c_plus_grade_courses[] = $course_reg_add['Course']['course_title'] . ' ('. $course_reg_add['Course']['course_code'] . ') ('. $course_reg_add['Course']['credit'] . ' ' . $credit_type . ')';
                                                }
                                            }
                                        } else {
                                            $credit_hour_sum_reg += $course_reg_add['Course']['credit'];
                                        }

                                        //only taken courses from currently attached curriculum should be added to $takenCourses array, Neway
                                        $takenCourses[$course_reg_add['Course']['id']] = $course_reg_add['Course']['id'];
                                        //$allTakenCourses[] = $course_reg_add['Course']['id'];
                                        //debug($course_reg_add);
                                        $color = $course_reg_add['hasEquivalentMap'] ? 'green;' : 'red;';

                                        /* if (isset($course_reg_add['Grade']['grade']) && !$course_reg_add['Grade']['pass_grade']) {
                                            $color = 'red;';
                                        } */

                                        $linethrough = '';

                                        if (isset($course_reg_add['RepeatitionLabel']) && $course_reg_add['RepeatitionLabel']['repeated_old']) {
                                            $color .= ' text-decoration: line-through;';
                                            $linethrough = ' text-decoration: line-through;';
                                        }

                                        //debug($course_reg_add['hasEquivalentMap']);
                                        if ($course_reg_add['hasEquivalentMap']) {
                                            $takenAndEquivalent[$course_reg_add['Course']['id']] = $course_reg_add['Course']['id'];
                                            $allTakenCourses[$course_reg_add['Course']['id']] = $course_reg_add['Course']['id'];
                                        } ?>
                                        

                                        <tr>
                                            <td style="color:<?= $color; ?>" class="center"><?= $c_count; ?></td>
                                            <td style="color:<?= $color; ?>" class="vcenter"><?= $course_reg_add['Course']['course_code']; ?></td>
                                            <td style="color:<?= $color; ?>" class="vcenter"><?= $course_reg_add['Course']['course_title']; ?></td>
                                            <td style="text-align:center;color:<?= $color; ?>" class="center"><?= $course_reg_add['Course']['credit']; ?></td>
                                            <td style="text-align:center;color:<?= $color; ?>" class="center"><?= (isset($course_reg_add['Grade']['grade']) ? $course_reg_add['Grade']['grade'] : '---'); ?></td>
                                            <?= (isset($course_reg_add['Grade']['grade']) ? (isset($course_reg_add['Grade']['pass_grade']) && $course_reg_add['Grade']['pass_grade'] ? '<td style="color:green;'.$linethrough .'" class="center">Pass</td>' : '<td style="color:red;'.$linethrough .'" class="center">' . (isset($course_reg_add['Grade']['pass_grade']) && !$course_reg_add['Grade']['pass_grade'] ? 'Fail' : 'N/A') . '</td>') : '<td style="color:red;'.$linethrough .'" class="center">---</td>'); ?>
                                            <td style="color:<?= $color; ?>" class="center"><?= $course_reg_add['Course']['Curriculum']['curriculum_detail'] . '<br/>' . (isset($course_reg_add['Course']['Curriculum']['english_degree_nomenclature']) ? '(From:' . $course_reg_add['Course']['Curriculum']['english_degree_nomenclature'] . ')' : '---'); ?></td>
                                        </tr>
                                        <?php
                                    }   
                                }
                            } ?>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold;" colspan="2">Attached Curriculum:</td>
                                <td class="vcenter" style="font-weight:bold;" colspan="6"><?= (isset($student_academic_profile['BasicInfo']['Curriculum']['curriculum_detail']) ? $student_academic_profile['BasicInfo']['Curriculum']['curriculum_detail'].'</br>('.$student_academic_profile['BasicInfo']['Curriculum']['english_degree_nomenclature'] .')' : 'The student is not attached to any curriculum!'); ?></td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold" colspan="2">Minimum Graduation Requirement (<?= $credit_type; ?>):</td>
                                <td class="vcenter" style="font-weight:bold" colspan="5"><?= (isset($student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points']) ? $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'] . ' '. $student_academic_profile['BasicInfo']['Curriculum']['type_credit'] : '---' ); ?></td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold" colspan="2">Total Registered <?= $credit_type; ?> Sum:</td>
                                <td class="vcenter" style="font-weight:bold" colspan="5"><?= ($credit_hour_sum_reg != 0 ? $credit_hour_sum_reg . ' '. $credit_type : '---'); ?></td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right;font-weight:bold; color:red" colspan="2">Fail Grades: </td>
                                <td class="vcenter" style="font-weight:bold; color:red" colspan="5"><?= ($credit_hour_sum_fail != 0 ? $credit_hour_sum_fail : '---') . ($fail_courses_count ? ' ' . $student_academic_profile['BasicInfo']['Curriculum']['type_credit']. ' for ' . $fail_courses_count.' course(s)' : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold; color:green" colspan="2">Pass Grades:</td>
                                <td class="vcenter" style="font-weight:bold; color:green" colspan="5"><?= ($credit_hour_sum_pass != 0 ? $credit_hour_sum_pass : '---') . ($pass_courses_count ? ' '. $student_academic_profile['BasicInfo']['Curriculum']['type_credit'] . ' for ' . $pass_courses_count.' courses' : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold;" colspan="2">Remaining <?= $credit_type; ?>:</td>
                                <td class="vcenter" style="font-weight:bold;" colspan="5">
                                    <?php
                                    if (isset($student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points']) && $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'] != 0) {
                                        if ($credit_hour_sum_pass != 0) {
                                            if ($exempted_courses_credit_sum) {
                                                $remainig_credits = ($credit_hour_sum_pass + $exempted_courses_credit_sum) - $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'];
                                            } else {
                                                $remainig_credits = $credit_hour_sum_pass - $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'];
                                            }
                                            if ($remainig_credits < 0) {
                                                echo $remainig_credits . ' '. $credit_type;
                                            } else {
                                                echo '0 ' . $credit_type;
                                            }
                                        }
                                    } else {
                                        echo '---';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold;" colspan="2">Over <?= $credit_type; ?>:</td>
                                <td class="vcenter" style="font-weight:bold;" colspan="5">
                                    <?php
                                    if (isset($student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points']) && $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'] != 0) {
                                        if ($credit_hour_sum_pass != 0) {
                                            if ($exempted_courses_credit_sum) {
                                                $over_credits = ($credit_hour_sum_pass + $exempted_courses_credit_sum) - $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'];
                                            } else {
                                                $over_credits = $credit_hour_sum_pass - $student_academic_profile['BasicInfo']['Curriculum']['minimum_credit_points'];
                                            }
                                            if ($credit_hour_sum_fail) {
                                                $over_credits -= $credit_hour_sum_fail;
                                            }
                                            if ($over_credits > 0) {
                                                echo $over_credits . ' ' . $credit_type;
                                            } else {
                                                echo '---';
                                            }
                                        }
                                    } else {
                                        echo '---';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="center" style="text-align:right; font-weight:bold;" colspan="2">Exempted <?= $credit_type; ?>:</td>
                                <td class="vcenter" style="font-weight:bold;" colspan="5"><?= ($exempted_courses_credit_sum != 0 ? $exempted_courses_credit_sum : '---') . ($exempted_courses_count ?  ' ' . $student_academic_profile['BasicInfo']['Curriculum']['type_credit'] . ' for ' . $exempted_courses_count . ' course(s)' : ''); ?></td>
                            </tr>
                            <?php
                            if (isset($student_academic_profile['BasicInfo']['Program']['id']) && ($student_academic_profile['BasicInfo']['Program']['id'] == PROGRAM_POST_GRADUATE || $student_academic_profile['BasicInfo']['Program']['id'] == PROGRAM_PhD)){
                                $c_plus_color =   ($c_plus_grade_count > 2 ? 'red' : 'green'); ?>     
                                <tr>
                                    <td class="center" style="text-align:right; font-weight:bold; color:<?= $c_plus_color; ?>" colspan="2">C+ Grades:</td>
                                    <td class="vcenter" style="font-weight:bold; color:<?=$c_plus_color; ?>" colspan="5">
                                        <?php
                                        echo ($c_plus_grade_count != 0 ? $c_plus_grade_count .' course(s)<br/>' : '---');

                                        if (isset($c_plus_grade_courses) && !empty($c_plus_grade_courses)){
                                            foreach($c_plus_grade_courses as $cPlusGrades){
                                                echo $cPlusGrades . '<br/>';
                                            }
                                        } ?>
                                    </td>
                                </tr>

                                <?php $c_grade_color =   ($c_grade_count > 1 ? 'red' : 'green'); ?>

                                <tr>
                                    <td class="center" style="text-align:right; font-weight:bold; color:<?= $c_grade_color; ?>" colspan="2">C Grades:</td>
                                    <td class="vcenter" style="font-weight:bold; color:<?= $c_grade_color; ?>" colspan="5">
                                        <?php
                                        echo ($c_grade_count != 0 ? $c_grade_count .' course(s)<br/>' : '---');
                                        if (isset($c_grade_courses) && !empty($c_grade_courses)) {
                                            foreach ($c_grade_courses as $cGrades) {
                                                echo $cGrades . '<br/>';
                                            }
                                        } ?>
                                    </td>
                                </tr>

                                <?php

                                $gradEligiblecolor = 'green;';
                                $gradEligible = true;

                                if ($c_grade_count == 0 && $c_plus_grade_count == 0) {
                                    // eligible, no C and C+ grades
                                } else if ($c_grade_count == 1 && $c_plus_grade_count == 0) {
                                    // eligible only 1 C, allowed
                                } else if ($c_plus_grade_count <= 2 && $c_grade_count == 0) {
                                    // 1 or 2 C+ grades with out any C grade, allowed
                                } else  {
                                    $gradEligiblecolor = 'red;';
                                    $gradEligible = false;
                                }
                                  
                                if (!$student_academic_profile['BasicInfo']['Student']['graduated']) { ?>
                                    <tr>
                                        <td class="center" style="text-align:right; font-weight:bold; color: <?= $gradEligiblecolor; ?>" colspan="2">C+/C grade constraint for graduation:</td>
                                        <td class="vcenter" style="font-weight:bold; color: <?= $gradEligiblecolor; ?>" colspan="5"><?= ($gradEligible ? 'None' : '<span style="color:black;font-weight:normal">(The Student does not satisfy the minimum graduation requirement set for graduate studies! Only one C/C+ or two C+ grades without any C grade is allowed.</span>'); ?></td>
                                    </tr>
                                    <?php
                                }
                            } ?>
                            <tr>
                                <td colspan="7">&nbsp;</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="venter">Green:</td>
                                <td class="venter" colspan="6">Course taken from attached curriculum OR course equivalency is done for courses taken from other curriculum(s).</td>
                            </tr>
                            <tr>
                                <td class="vcenter">Red:</td>
                                <td class="vcenter" colspan="6">Course taken from other curriculum and course equivalency is NOT Done.</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php
            } 
            
            
            if (isset($student_academic_profile['BasicInfo']['Curriculum']['Course']) && !empty($student_academic_profile['BasicInfo']['Curriculum']['Course'])) { ?>
                <br>
                <hr>
                <h6 class="fs15 text-black">List of courses not taken from the current student attached curriculum <?= (isset($student_academic_profile['BasicInfo']['Curriculum']['curriculum_detail']) ? ' (' . $student_academic_profile['BasicInfo']['Curriculum']['curriculum_detail'] . ')' : ''); ?></h6>
                <br>
                <div style="overflow-x:auto;">
                    <table cellpadding="0" cellspacing="0" class="table">
                        <thead>
                            <tr>
                                <th style="width:3%;" class="center">#</th>
                                <th style="width:13%;" class="vcenter">Course Code</th>
                                <th class="vcenter">Course Title</th>
                                <th style="width:5%;" class="center"><?= $credit_type; ?></th>
                                <th class="center">Course Category</th>
                                <th class="center">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c = 1;
                            foreach ($student_academic_profile['BasicInfo']['Curriculum']['Course'] as $kk => $pp) {
                                //if (((in_array($pp['id'], $takenCourses) != true) || (in_array($pp['id'], $takenAndEquivalent) != true) || (in_array($pp['id'], $exemptedCourses) != true))) { 
                                //if (!in_array($pp['id'], $allTakenCourses)) { ?>
                                <?php
                                if (!in_array($pp['id'], $takenCourses) || !in_array($pp['id'], $takenAndEquivalent)) { 
                                    if (!empty($exemptedCourses) && in_array($pp['id'], $exemptedCourses)) {
                                        $remark = 'Transferred/Exempted Course';
                                        $row_class = 'exempted';
                                    } else if (!empty($from_other_curriculum_and_mapped) && in_array($pp['id'], $from_other_curriculum_and_mapped)) {
                                        $remark = 'Equivalency Mapped';
                                        $row_class = 'accepted';
                                    } else {
                                        $remark = 'NOT TAKEN';
                                        $row_class = 'rejected';
                                    } ?>
                                    <tr>
                                        <td class="center <?= $row_class; ?>"><?= $c++; ?></td>
                                        <td class="vcenter <?= $row_class; ?>"><?= $pp['course_code']; ?></td>
                                        <td class="vcenter <?= $row_class; ?>"><?= $pp['course_title'] . (isset($pp['elective']) && $pp['elective'] ? ' &nbsp; <span class="text-gray">(Elective Course)</span>' : ''); ?></td>
                                        <td class="center <?= $row_class; ?>"><?= $pp['credit']; ?></td>
                                        <td class="center <?= $row_class; ?>"><?= $pp['CourseCategory']['name']; ?></td>
                                        <td class="center <?= $row_class; ?>"><?= $remark; ?></td>
                                    </tr>
                                    <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <?php 
            }  ?>
        </div>
    </div>
</div>