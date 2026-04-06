<?php
if (isset($gradeSubmissionDelay) && !empty($gradeSubmissionDelay)) { ?>
    <h5 class="rejected fs14">Date Generated: <?= $this->Time->format("F j, Y h:i:s A", date('Ymd H:i:s'), NULL, NULL); ?></h5><br>
    <div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <td class="center">#</td>
                    <td class="center">Program</td>
                    <td class="center">Program Type</td>
                    <td class="center">Section</td>
                    <td class="center">Year</td>
                    <td class="center">Course</td>
                    <td class="center">Assigned Instructor</td>
                    <td class="center">Date Assigned</td>
                    <td class="center">Instructor's Department</td>
                    <td class="center">Deadline</td>
                    <td class="center">Delay in days</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count = 0;
                    foreach ($gradeSubmissionDelay as $departmentNamee => $courseList) {
                        foreach ($courseList as $rkey => $rvalue) {
                            foreach ($rvalue as $mn => $ym) { ?>
                                <tr>
                                    <td class="center"><?= ++$count; ?></td>
                                    <td class="center"><?= $ym['Section']['Program']['name']; ?></td>
                                    <td class="center"><?= $ym['Section']['ProgramType']['name']; ?></td>
                                    <td class="center"><?= (isset($ym['Section']['name']) ? $ym['Section']['name'] : 'N/A'); ?></td>
                                    <td class="center"><?= (!isset($ym['Section']['YearLevel']) ? 'Pre/1st' : (!isset($ym['Section']['YearLevel']['name'])  ? 'Pre/1st' : $ym['Section']['YearLevel']['name'])); ?></td>
                                    <td class="center"><?= $rkey; ?></td>
                                    <td class="center"><?= $ym['Staff']['Title']['title'] . ' ' . $ym['Staff']['full_name'] . ' (' . $ym['Staff']['Position']['position'] . ')'; ?></td>
                                    <td class="center"><?= (($ym['CourseInstructorAssignment']['created'] == $ym['CourseInstructorAssignment']['modified']) ? $this->Time->format("F j, Y h:i:s A", $ym['CourseInstructorAssignment']['created'], NULL, NULL) : ($this->Time->format("F j, Y h:i:s A", $ym['CourseInstructorAssignment']['modified'], NULL, NULL))); ?></td>
                                    <td class="center"><?= $departmentNamee; ?></td>
                                    <td class="center" style="<?= (!empty($ym['CourseInstructorAssignment']['grade_submission_deadline']) ? ($ym['CourseInstructorAssignment']['grade_submission_deadline'] > date('Y-m-d') ? 'color:green' : 'color:red') : 'color:gray'); ?>">
                                        <?= (($ym['CourseInstructorAssignment']['grade_submission_deadline'] == '0000-00-00 00:00:00' || $ym['CourseInstructorAssignment']['grade_submission_deadline'] == '' || is_null($ym['CourseInstructorAssignment']['grade_submission_deadline'])) ? 'Deadline not defined.' : ($this->Time->format("F j, Y", $ym['CourseInstructorAssignment']['grade_submission_deadline'], NULL, NULL))); ?>
                                    </td>
                                    <td class="center" style="<?= (!empty($ym['CourseInstructorAssignment']['grade_submission_deadline']) ? ($ym['CourseInstructorAssignment']['grade_submission_deadline'] < date('Y-m-d') ? 'color:red' : '') : ''); ?>">
                                        <?php
                                        if (isset($ym['CourseInstructorAssignment']['grade_submission_deadline']) && !empty($ym['CourseInstructorAssignment']['grade_submission_deadline'])) {
                                            $deadline = new DateTime($ym['CourseInstructorAssignment']['grade_submission_deadline']);
                                            $currentDate = new DateTime(date('Y-m-d'));
                                            echo (($ym['CourseInstructorAssignment']['grade_submission_deadline'] > date('Y-m-d')) ? '' : $currentDate->diff($deadline)->format("%a"));
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    } ?>
            </tbody>
        </table>
    </div>
    <?php
} ?>