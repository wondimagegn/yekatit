
<?php
// ============================================================
// FILE: app/View/Elements/exam_type_staff_assignment_form.ctp
// ALSO CAN BE USED AS app/View/ExamTypes/get_exam_type_staff_assignment_form.ctp
// ============================================================

if (empty($published_course_id)) { ?>
    <div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        <span style='margin-right: 15px;'></span>
        Please select a course to get assignment form.
    </div>
    <?php return;
}

if (empty($exam_types)) { ?>
    <div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        <span style='margin-right: 15px;'></span>
        No exam types are defined yet for the selected course.
    </div>
    <?php return;
}

if (empty($secondary_instructors)) { ?>
    <div class='warning-box warning-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        <span style='margin-right: 15px;'></span>
        No secondary instructors are assigned to this course. Please assign secondary instructors first.
    </div>
    <?php return;
}

$readOnly = !empty($grade_submitted);
?>

<?php if (!empty($published_course_detail)) { ?>
    <div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        <span style='margin-right: 15px;'></span>
        <?= h($published_course_detail['Course']['course_title'] . ' (' . $published_course_detail['Course']['course_code'] . ') - ' . $published_course_detail['Section']['name']); ?>
    </div>
<?php } ?>

<?php if ($readOnly) { ?>
    <div class='warning-box warning-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        <span style='margin-right: 15px;'></span>
        Grade is partially or fully submitted for the selected course. Assignment changes are disabled.
    </div>
<?php } ?>

<?= $this->Form->create('Assignment', array(
    'url' => array('controller' => 'examTypes', 'action' => 'save_exam_type_staff_assignment')
)); ?>

<?= $this->Form->hidden('published_course_id', array('value' => $published_course_id)); ?>

<div style="overflow-x:auto;">
    <table cellpadding="0" cellspacing="0" class="table">
        <thead>
        <tr>
            <th style="width:5%" class="center">#</th>
            <th style="width:35%" class="vcenter">Exam Type</th>
            <th style="width:15%" class="center">Percent</th>
            <th style="width:15%" class="center">Order</th>
            <th style="width:30%" class="center">Secondary Instructor</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($exam_types as $index => $exam_type) { ?>
            <tr>
                <td class="center"><?= $index + 1; ?></td>
                <td class="vcenter"><?= h($exam_type['ExamType']['exam_name']); ?></td>
                <td class="center"><?= h($exam_type['ExamType']['percent']); ?>%</td>
                <td class="center"><?= h($exam_type['ExamType']['order']); ?></td>
                <td class="center">
                    <?= $this->Form->input('ExamType.' . $exam_type['ExamType']['id'] . '.staff_id', array(
                        'type' => 'select',
                        'label' => false,
                        'options' => $secondary_instructors,
                        'empty' => '-- Unassigned --',
                        'default' => $exam_type['ExamType']['staff_id'],
                        'disabled' => $readOnly,
                        'style' => 'width:95%'
                    )); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php if (!$readOnly) { ?>
    <hr>
    <?= $this->Form->submit(__('Save Assignment'), array(
        'div' => false,
        'class' => 'tiny radius button bg-blue'
    )); ?>
<?php } ?>

<?= $this->Form->end(); ?>