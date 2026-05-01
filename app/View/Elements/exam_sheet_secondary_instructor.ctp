<style>
    input::placeholder {
        color: #d3d3d3;
        opacity: 0.9;
    }
    input {
        color: #000000;
    }
</style>

<?php
if (!isset($total_student_count)) {
    $total_student_count = count($students_process);
}

if (!isset($grade_view_only)) {
    $grade_view_only = false;
}

if (!isset($secondary_result_entry_mode)) {
    $secondary_result_entry_mode = true;
}

$allow_result_entry = (
        $secondary_result_entry_mode &&
        !$grade_view_only &&
        !$display_grade &&
        !$grade_submission_status['grade_submited']
);
?>

<script>
    var col = Number(<?= count($exam_types); ?>);
    var rows = Number(<?= $total_student_count; ?>);
    var current = 1;
    var next;
    var allowResultEntry = <?= ($allow_result_entry ? 'true' : 'false'); ?>;

    document.onkeydown = moveByKeyPress;

    function moveByKeyPress(e) {
        if (!allowResultEntry) {
            return true;
        }

        if (!e) {
            e = window.event;
        }

        var currentId = $(e.target).attr("id");
        if (!currentId || currentId.indexOf('result_') !== 0) {
            return true;
        }

        var currentRow = currentId.split('_', 3);
        var nextRowNumber = Number(currentRow[1]) + 1;
        var currentCol = Number(currentRow[2]);
        var liveValue = $(e.target).val();
        var key;

        (e.keyCode) ? key = e.keyCode : key = e.which;

        try {
            if (key == 37 || key == 38 || key == 39 || key == 40 || key == 9) {
                if (liveValue != "" && isNaN(liveValue)) {
                    alert('Please enter a valid result.');
                    $('#' + $(e.target).attr("id")).focus();
                } else if (liveValue != "" && parseFloat(liveValue) > parseFloat($(e.target).attr("data-percent"))) {
                    alert('The maximum value of "' + $(e.target).attr("data-type") + '" exam result is ' + $(e.target).attr("data-percent") + '.');
                    $('#' + $(e.target).attr("id")).focus();
                } else if (liveValue != "" && parseFloat(liveValue) < 0) {
                    alert('The minimum value of "' + $(e.target).attr("data-type") + '" exam result is 0.');
                    $('#' + $(e.target).attr("id")).focus();
                    $('#' + $(e.target).attr("id")).select();
                } else {
                    var next;
                    switch (key) {
                        case 37:
                            next = currentCol - 1;
                            if (next > col) {
                                var nextRowNumber = Number(currentRow[1]) + 1;
                                var newRowId = 'result_' + nextRowNumber + '_1';
                                $('#' + newRowId).focus();
                            } else {
                                var currentRowId = 'result_' + currentRow[1] + '_' + next;
                                $('#' + currentRowId).focus();
                            }
                            break;
                        case 38:
                            e.preventDefault();
                            var previousRowNumber = Number(currentRow[1]) - 1;
                            var newRowId = 'result_' + previousRowNumber + '_' + currentCol;
                            if ($('#' + newRowId).length != 0) {
                                $('#' + newRowId).focus();
                            } else {
                                $('#' + currentId).focus();
                            }
                            break;
                        case 39:
                            next = currentCol + 1;
                            if (next > col) {
                                var nextRowNumber = Number(currentRow[1]) + 1;
                                var newRowId = 'result_' + nextRowNumber + '_1';
                                $('#' + newRowId).focus();
                            } else {
                                var currentRowId = 'result_' + currentRow[1] + '_' + next;
                                $('#' + currentRowId).focus();
                            }
                            break;
                        case 40:
                            e.preventDefault();
                            var nextRowNumber = Number(currentRow[1]) + 1;
                            var newRowId = 'result_' + nextRowNumber + '_' + currentCol;
                            if ($('#' + newRowId).length != 0) {
                                $('#' + newRowId).focus();
                            } else {
                                $('#' + currentId).focus();
                            }
                            break;
                    }
                }
            } else {
                return;
            }
        } catch (exception) {
        }
    }
</script>

<div style="overflow-x:auto;">
    <table cellpadding="0" cellspacing="0" class="table" onkeypress="javascript:moveByKeyPress();">
        <thead>
        <tr>
            <td class="center" style="width:3%">&nbsp;</td>
            <td class="center" style="width:2%">#</td>
            <td class="vcenter" style="width:14%">Student Name</td>
            <td class="center" style="width:8%">Student ID</td>
            <?php
            $percent = 10;
            $last_percent = "";

            if ($grade_view_only) {
                $percent = 10;
                $last_percent = 42;
            } else if ($makeup_exam) { ?>
                <td class="center" style="width:<?= ($allow_result_entry ? 72 : 10); ?>%">Total (100%)</td>
                <?php
                $last_percent = 32;
            } else {
                $grade_width = 0;
                if ($grade_submission_status['grade_submited']) {
                    $grade_width = 3;
                } else if ($display_grade) {
                    $grade_width = 3;
                }

                if (((100 - 28) / ((count($exam_types) + 1) + $grade_width)) > 10) {
                    $last_percent = (100 - 28) - ((count($exam_types) + 1 + $grade_width) * 10);
                } else {
                    $percent = ((100 - 28) / (count($exam_types) + 1 + $grade_width));
                }

                $count_for_percent = 0;
                foreach ($exam_types as $key => $exam_type) {
                    $count_for_percent++; ?>
                    <td class="center" style="width:<?= ($count_for_percent == (count($exam_types) + 1) && $last_percent != "" && $allow_result_entry ? $last_percent + $percent : $percent); ?>%">
                        <?= $exam_type['ExamType']['exam_name'] . ' (' . $exam_type['ExamType']['percent'] . '%)'; ?>
                    </td>
                    <?php
                } ?>
                <td class="center" style="width:<?= ($allow_result_entry ? $last_percent + $percent : $percent); ?>%">Total (100%)</td>
                <?php
            }

            if ($grade_submission_status['grade_submited'] || $display_grade) { ?>
                <td class="center" style="width:<?= $percent; ?>%">Grade</td>
                <td class="center" style="width:<?= $percent; ?>%">In Progress</td>
                <td class="center" style="width:<?= ($last_percent != "" ? $last_percent + $percent : $percent); ?>%">Status</td>
                <?php
            } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!isset($total_student_count)) {
            $total_student_count = count($students_process);
        }

        foreach ($students_process as $key => $student) {
            $grade_history_count = 0;

            if (isset($student['freshman_program']) && $student['freshman_program']) {
                $freshman_program = true;
                $approver = 'freshman program';
                $approver_c = 'Freshman Program';
            } else {
                $freshman_program = false;
                $approver = 'department';
                $approver_c = 'Department';
            }

            $total_100 = "";
            $st_count++; ?>
            <tr>
                <td class="center" onclick="toggleView(this)" id="<?= $st_count; ?>"><?= $this->Html->image('plus2.gif', array('id' => 'i' . $st_count)); ?></td>
                <td class="center"><?= $st_count; ?></td>
                <td class="vcenter"><?= $student['Student']['first_name'] . ' ' . $student['Student']['middle_name'] . ' ' . $student['Student']['last_name']; ?></td>
                <td class="center"><?= $student['Student']['studentnumber']; ?></td>
                <?php
                if ($grade_view_only) {
                } else if ($makeup_exam) { ?>
                    <td class="center" style="line-height: 1;">
                        <?php
                        if (!empty($student['ExamGradeChange']) && $student['ExamGradeChange'][0]['department_approval'] != -1) {
                            echo ($student['MakeupExam']['result'] != null ? $student['MakeupExam']['result'] : '---');
                        } else {
                            if (!$allow_result_entry) {
                                echo ($student['MakeupExam']['result'] != null ? $student['MakeupExam']['result'] : '---');
                            } else {
                                echo $this->Form->input('MakeupExam.' . $count . '.id', array(
                                        'type' => 'hidden',
                                        'value' => $student['MakeupExam']['id']
                                ));

                                $input_options = array(
                                        'type' => 'number',
                                        'label' => false,
                                        'style' => 'width:70px',
                                        'id' => 'result_' . $st_count . '_1',
                                        'max' => 100,
                                        'step' => 'any',
                                        'onBlur' => 'updateExamTotal(this, ' . $st_count . ', 1, 100, \'Total\', false)'
                                );

                                $input_options['value'] = ($student['MakeupExam']['result'] != null ? $student['MakeupExam']['result'] : '');
                                echo $this->Form->input('MakeupExam.' . $count . '.result', $input_options);
                                $count++;
                            }
                        } ?>
                    </td>
                    <?php
                } else {
                    $et_count = 0;

                    foreach ($exam_types as $key => $exam_type) {
                        $et_count++; ?>
                        <td class="center" style="line-height: 1;">
                            <?php
                            $id = "";
                            $value = "";

                            if (isset($student['ExamResult']) && !empty($student['ExamResult'])) {
                                foreach ($student['ExamResult'] as $key => $examResult) {
                                    if ($examResult['exam_type_id'] == $exam_type['ExamType']['id']) {
                                        $id = $examResult['id'];
                                        $value = $examResult['result'];
                                        $total_100 += $value;
                                        break;
                                    }
                                }
                            }

                            $i = (($st_count - 1) * count($exam_types)) + 1;

                            if (isset($this->request->data['ExamResult'][$i]['result'])) {
                                if (isset($this->request->data) && !$display_grade && $allow_result_entry) {
                                    $total_100 = "";
                                    for (; $i <= ((($st_count - 1) * count($exam_types)) + count($exam_types)); $i++) {
                                        if (isset($this->request->data['ExamResult'][$i])) {
                                            if ($this->request->data['ExamResult'][$i]['result'] != "" && is_numeric($this->request->data['ExamResult'][$i]['result'])) {
                                                $total_100 += $this->request->data['ExamResult'][$i]['result'];
                                            }
                                        }
                                    }
                                }
                            }

                            if (!$allow_result_entry || (!empty($student['ExamGrade']) && $student['ExamGrade'][0]['department_approval'] != -1)) {
                                echo ($value != "" ? $value : '---');
                            } else { ?>
                                <div style="padding-left: 25%;">
                                    <br>
                                    <?php
                                    if ($id != "") {
                                        echo $this->Form->input('ExamResult.' . $count . '.id', array(
                                                'type' => 'hidden',
                                                'value' => $id
                                        ));

                                        echo $this->Form->input('ExamResult.' . $count . '.result', array(
                                                'type' => 'number',
                                                'label' => false,
                                                'placeholder' => ' /' . ($exam_type['ExamType']['percent']) . '%',
                                                'style' => 'width:70px',
                                                'id' => 'result_' . $st_count . '_' . $et_count,
                                                'max' => $exam_type['ExamType']['percent'],
                                                'step' => 'any',
                                                'onBlur' => 'updateExamTotal(this, ' . $st_count . ', ' . count($exam_types) . ', ' . $exam_type['ExamType']['percent'] . ', \'' . $exam_type['ExamType']['exam_name'] . '\', true)',
                                                'data-type' => $exam_type['ExamType']['exam_name'],
                                                'data-percent' => $exam_type['ExamType']['percent'],
                                                'tabindex' => (($total_student_count * ($et_count - 1)) + $st_count),
                                                'value' => $value
                                        ));
                                    } else {
                                        echo $this->Form->input('ExamResult.' . $count . '.exam_type_id', array(
                                                'type' => 'hidden',
                                                'value' => $exam_type['ExamType']['id']
                                        ));

                                        if (isset($student['CourseRegistration'])) {
                                            echo $this->Form->input('ExamResult.' . $count . '.course_registration_id', array(
                                                    'type' => 'hidden',
                                                    'value' => $student['CourseRegistration']['id']
                                            ));
                                            echo $this->Form->input('ExamResult.' . $count . '.course_add', array(
                                                    'type' => 'hidden',
                                                    'value' => 0
                                            ));
                                        } else if (isset($student['CourseAdd'])) {
                                            echo $this->Form->input('ExamResult.' . $count . '.course_registration_id', array(
                                                    'type' => 'hidden',
                                                    'value' => $student['CourseAdd']['id']
                                            ));
                                            echo $this->Form->input('ExamResult.' . $count . '.course_add', array(
                                                    'type' => 'hidden',
                                                    'value' => 1
                                            ));
                                        }

                                        echo $this->Form->input('ExamResult.' . $count . '.result', array(
                                                'tabindex' => (($total_student_count * ($et_count - 1)) + $st_count),
                                                'type' => 'number',
                                                'label' => false,
                                                'placeholder' => ' /' . ($exam_type['ExamType']['percent']) . '%',
                                                'style' => 'width:70px',
                                                'id' => 'result_' . $st_count . '_' . $et_count,
                                                'max' => $exam_type['ExamType']['percent'],
                                                'step' => 'any',
                                                'onBlur' => 'updateExamTotal(this, ' . $st_count . ', ' . count($exam_types) . ', ' . $exam_type['ExamType']['percent'] . ', \'' . $exam_type['ExamType']['exam_name'] . '\', true)',
                                                'data-type' => $exam_type['ExamType']['exam_name'],
                                                'data-percent' => $exam_type['ExamType']['percent']
                                        ));
                                    } ?>
                                </div>
                                <?php
                            } ?>
                        </td>
                        <?php
                        $count++;
                    } ?>
                    <td class="center" id="total_100_<?= $st_count; ?>"><?= ($total_100 !== "" ? $total_100 : '---'); ?></td>
                    <?php
                }

                if ($grade_submission_status['grade_submited'] || $display_grade) { ?>
                    <td class="center" id="G_<?= ++$in_progress; ?>">
                        <?php
                        $latest_grade_detail = $student['LatestGradeDetail'];

                        if ($display_grade && isset($student['GeneratedExamGrade'])) {
                            echo $student['GeneratedExamGrade']['grade'];
                        } else if (isset($student['MakeupExam']) && (empty($student['ExamGradeChange']) || $student['ExamGradeChange'][0]['created'] >= $latest_grade_detail['ExamGrade']['created'])) {
                            if (isset($student['ExamGradeChange']) && !empty($student['ExamGradeChange'])) {
                                if ($student['ExamGradeChange'][0]['department_approval'] == -1) {
                                    echo '<p class="rejected">';
                                }
                                echo $student['ExamGradeChange'][0]['grade'];
                                if ($student['ExamGradeChange'][0]['department_approval'] == -1) {
                                    echo '</p>';
                                }
                            } else {
                                echo '**';
                            }
                        } else if (!empty($latest_grade_detail['ExamGrade'])) {
                            if ((!isset($latest_grade_detail['ExamGrade']['auto_ng_conversion']) || $latest_grade_detail['ExamGrade']['auto_ng_conversion'] == 0) && (!isset($latest_grade_detail['ExamGrade']['manual_ng_conversion']) || $latest_grade_detail['ExamGrade']['manual_ng_conversion'] == 0) && $latest_grade_detail['ExamGrade']['department_approval'] == -1) {
                                echo '<p class="rejected">';
                            }

                            echo $latest_grade_detail['ExamGrade']['grade'];

                            if ($latest_grade_detail['ExamGrade']['department_approval'] == -1) {
                                echo '</p>';
                            }

                            if (strcasecmp($latest_grade_detail['type'], 'Change') == 0) {
                                if ($latest_grade_detail['ExamGrade']['makeup_exam_id'] == null && $latest_grade_detail['ExamGrade']['makeup_exam_result'] != null) {
                                    echo ' (Supplementary)';
                                } else if ($latest_grade_detail['ExamGrade']['makeup_exam_result'] != null) {
                                    echo ' (Makeup)';
                                } else {
                                    echo ' (Change)';
                                }
                            }

                            if (isset($latest_grade_detail['ResultEntryAssignment']) && !empty($latest_grade_detail['ResultEntryAssignment'])) {
                                echo ' (Result Entry Assignment)';
                            }

                            if ((strpos($latest_grade_detail['ExamGrade']['registrar_reason'], 'backend') !== false) || $latest_grade_detail['ExamGrade']['registrar_reason'] == 'Via backend data entry interface') {
                                echo ' (Backend Data Entry)';
                            }
                        } else {
                            echo '**';
                        } ?>
                    </td>
                    <td class="center">
                        <?php
                        $latest_grade_detail = $student['LatestGradeDetail'];

                        if ($grade_submission_status['grade_submited'] && !$display_grade) {
                            if (isset($student['MakeupExam'])) {
                                if (!isset($student['ExamGradeChange']) || empty($student['ExamGradeChange']) || ($student['ExamGradeChange'][0]['department_approval'] == -1 && $latest_grade_detail['ExamGrade']['auto_ng_conversion'] == 0 && $latest_grade_detail['ExamGrade']['manual_ng_conversion'] == 0)) {
                                    echo '<span class="on-process">Yes</span>';
                                } else {
                                    echo '<span class="accepted">No</span>';
                                }
                            } else {
                                if ((empty($latest_grade_detail['ExamGrade']) || $latest_grade_detail['ExamGrade']['department_approval'] == -1) && (!isset($latest_grade_detail['ExamGrade']['auto_ng_conversion']) || $latest_grade_detail['ExamGrade']['auto_ng_conversion'] == 0) && (!isset($latest_grade_detail['ExamGrade']['manual_ng_conversion']) || $latest_grade_detail['ExamGrade']['manual_ng_conversion'] == 0)) {
                                    echo '<span class="on-process">Yes</span>';
                                } else {
                                    echo '<span class="accepted">No</span>';
                                }
                            }
                        } else {
                            if ((isset($student['MakeupExam']) && (!isset($student['ExamGradeChange']) || (isset($student['ExamGradeChange']) && (empty($student['ExamGradeChange']) || $student['ExamGradeChange'][0]['department_approval'] == -1)))) || ((!isset($student['MakeupExam']) && !isset($student['ExamGrade'])) || (isset($student['ExamGrade']) && (empty($student['ExamGrade']) || $student['ExamGrade'][0]['department_approval'] == -1)))) {
                                if (!$student['GeneratedExamGrade']['fully_taken']) {
                                    echo '<div style="margin-left: 40%;">' . $this->Form->input('InProgress.' . $in_progress . '.in_progress', array(
                                                    'type' => 'checkbox',
                                                    'value' => $student['Student']['id'],
                                                    'label' => false,
                                                    'onclick' => 'courseInProgress(' . $in_progress . ', this)',
                                                    'hiddenField' => false
                                            )) . '</div>';
                                } else {
                                    echo '---';
                                }
                            } else {
                                echo '<span class="accepted">No</span>';
                            }
                        } ?>
                    </td>
                    <td class="center">
                        <?php
                        $latest_grade_detail = $student['LatestGradeDetail'];

                        if (isset($student['MakeupExam'])) {
                            if (!isset($student['ExamGradeChange']) || empty($student['ExamGradeChange'])) {
                                echo '<span class="on-process">Grade not submitted</span>';
                            } else if ($student['ExamGradeChange']['0']['department_approval'] == null) {
                                echo '<span class="on-process">Waiting for ' . $approver . ' approval</span>';
                            } else if ($student['ExamGradeChange']['0']['department_approval'] == -1) {
                                if ($display_grade) {
                                    echo '<span class="on-process">Re-grade is not submitted</span>';
                                } else {
                                    echo '<span class="rejected">Grade is rejected by ' . $approver . '</span>';
                                }
                            } else {
                                if ($student['ExamGradeChange']['0']['registrar_approval'] == null) {
                                    if ($student['ExamGradeChange']['0']['initiated_by_department'] == 1) {
                                        echo '<span class="on-process">Requested by ' . $approver . ', waiting for registrar approval</span>';
                                    } else {
                                        echo '<span class="on-process">Approved by ' . $approver . ', waiting for registrar approval</span>';
                                    }
                                } else if ($student['ExamGradeChange']['0']['registrar_approval'] == -1) {
                                    if ($student['ExamGradeChange']['0']['initiated_by_department'] == 1) {
                                        echo '<span class="rejected">Requested by ' . $approver . ', but rejected by registrar</span>';
                                    } else {
                                        echo '<span class="rejected">Approved by ' . $approver . ', but rejected by registrar</span>';
                                    }
                                } else {
                                    echo '<span class="accepted">Accepted</span>';
                                }
                            }
                        } else if (!empty($latest_grade_detail['ExamGrade'])) {
                            if (strcasecmp($latest_grade_detail['type'], 'Register') == 0 || strcasecmp($latest_grade_detail['type'], 'Add') == 0 || (strcasecmp($latest_grade_detail['type'], 'Change') == 0 && $latest_grade_detail['ExamGrade']['makeup_exam_result'] != null)) {
                                if ($latest_grade_detail['ExamGrade']['department_approval'] == null) {
                                    echo '<span class="on-process">Waiting for ' . $approver . ' approval</span>';
                                } else if ($latest_grade_detail['ExamGrade']['department_approval'] == -1) {
                                    if ($display_grade) {
                                        echo '<span class="on-process">Re-grade is not submitted</span>';
                                    } else {
                                        echo '<span class="rejected">Grade is rejected by ' . $approver . '</span>';
                                    }
                                } else {
                                    if ($latest_grade_detail['ExamGrade']['registrar_approval'] == null) {
                                        if (strcasecmp($latest_grade_detail['type'], 'Change') == 0 && $latest_grade_detail['ExamGrade']['initiated_by_department'] == 1) {
                                            echo '<span class="on-process">Requested by ' . $approver . ' and waiting for registrar approval</span>';
                                        } else {
                                            echo '<span class="on-process">Approved by ' . $approver . ', waiting for registrar approval</span>';
                                        }
                                    } else if ($latest_grade_detail['ExamGrade']['registrar_approval'] == -1) {
                                        if (strcasecmp($latest_grade_detail['type'], 'Change') == 0 && $latest_grade_detail['ExamGrade']['initiated_by_department'] == 1) {
                                            echo '<span class="rejected">Requested by ' . $approver . ', but rejected by registrar</span>';
                                        } else {
                                            echo '<span class="rejected">Approved by ' . $approver . ', but rejected by registrar</span>';
                                        }
                                    } else {
                                        echo '<span class="accepted">Accepted</span>';
                                    }
                                }
                            } else {
                                if ($latest_grade_detail['ExamGrade']['manual_ng_conversion'] == 1) {
                                    echo '<span class="accepted">NG Grade Converted</span>';
                                } else if ($latest_grade_detail['ExamGrade']['auto_ng_conversion'] == 1) {
                                    echo '<span class="accepted">Automatic F</span>';
                                } else {
                                    if ($latest_grade_detail['ExamGrade']['initiated_by_department'] == 1 || $latest_grade_detail['ExamGrade']['department_approval'] == 1) {
                                        if ($latest_grade_detail['ExamGrade']['college_approval'] == 1 || $latest_grade_detail['ExamGrade']['makeup_exam_result'] != null) {
                                            if ($latest_grade_detail['ExamGrade']['registrar_approval'] == 1) {
                                                echo '<span class="accepted">Accepted</span>';
                                            } else if ($latest_grade_detail['ExamGrade']['registrar_approval'] == -1) {
                                                echo '<span class="rejected">Approved by ' . $approver . ' and college but rejected by registrar approval.</span>';
                                            } else if ($latest_grade_detail['ExamGrade']['registrar_approval'] == null) {
                                                echo '<span class="on-process">Approved by ' . $approver . ' and college and waiting for registrar approval.</span>';
                                            }
                                        } else if ($latest_grade_detail['ExamGrade']['college_approval'] == -1) {
                                            echo '<span class="rejected">Approved by ' . $approver . ' but rejected by college</span>';
                                        } else if ($latest_grade_detail['ExamGrade']['college_approval'] == null) {
                                            echo '<span class="on-process">Approved by ' . $approver . ' and waiting for college approval.</span>';
                                        }
                                    } else if ($latest_grade_detail['ExamGrade']['department_approval'] == -1) {
                                        echo '<span class="rejected">Rejected by ' . $approver . '</span>';
                                    } else if ($latest_grade_detail['ExamGrade']['department_approval'] == null) {
                                        echo '<span class="on-process">Waiting for ' . $approver . ' approval</span>';
                                    }
                                }
                            }
                        } else {
                            echo '<span class="on-process">Grade not submitted</span>';
                        } ?>
                    </td>
                    <?php
                } ?>
            </tr>

            <tr id="c<?= $st_count; ?>" style="display:none">
                <?php
                if ($grade_submission_status['grade_submited'] || $display_grade) {
                    $grade_width = 3;
                } else {
                    $grade_width = 0;
                }

                if ($makeup_exam) {
                    $colspan = ($grade_width + 4);
                } else {
                    $colspan = ($grade_width + 3 + count($exam_types) + 1);
                } ?>
                <td style="background-color: white;">&nbsp;</td>
                <td style="background-color: white;" colspan="<?= $colspan; ?>">
                    <?php
                    if (isset($student['MakeupExam']) && isset($student['ExamGradeChange']) && count($student['ExamGradeChange']) > 0) { ?>
                        <table cellpadding="0" cellspacing="0" class="table">
                            <tr>
                                <td style="width:18%; font-weight:bold; background-color: white;" class="vcenter">Makeup Exam Minute Number:</td>
                                <td style="width:82%; background-color: white;" class="vcenter"><?= $student['ExamGradeChange'][0]['minute_number']; ?></td>
                            </tr>
                        </table>
                        <?php
                    }

                    $register_or_add = 'gh';

                    if (isset($student['ExamGradeHistory'])) {
                        $grade_history = $student['ExamGradeHistory'];
                    } else {
                        $grade_history = array();
                    }

                    $this->set(compact('register_or_add', 'grade_history', 'freshman_program')); ?>

                    <table cellpadding="0" cellspacing="0" class="table">
                        <tr>
                            <td style="vertical-align:top; width:60%; background-color: white;">
                                <?= $this->element('registered_or_add_course_grade_history'); ?>
                            </td>
                            <td style="vertical-align:top; width:40%; background-color: white;">
                                <div id="flashMessage" class="info-box info-message" style="font-family: 'Times New Roman', Times, serif; font-weight: normal;">
                                    <span style="margin-right: 15px;"></span>Grade change is handled in the primary instructor flow.
                                </div>
                            </td>
                        </tr>
                    </table>
                    <?php
                    $student_exam_grade_change_history = $student['ExamGradeHistory'];
                    $student_exam_grade_history = $student['ExamGrade'];
                    $this->set(compact('student_exam_grade_history', 'student_exam_grade_change_history', 'freshman_program'));
                    echo $this->element('registered_or_add_course_grade_detail_history');
                    ?>
                </td>
            </tr>
            <?php
        } ?>
        </tbody>
    </table>
</div>
<br>