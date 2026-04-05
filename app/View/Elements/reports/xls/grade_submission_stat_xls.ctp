<?php
header ("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls" );
header ("Content-Description: Exported as XLS" );
?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: auto; /* Let columns grow naturally */
        /* border: 1px solid #000; */
    }
    th, td {
        /* border: 1px solid #000; */
        padding: 5px 12px; /* Some breathing space */
        text-align: left;
        white-space: nowrap;
    }
    
    thead tr {
        background-color: #f2f2f2;
        border-bottom: 2px solid #000;
    }
    thead th {
        background-color: #d9edf7;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

<?php
if (isset($gradeSubmissionDelay) && !empty($gradeSubmissionDelay)) {
	if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table" style="border: none;">
			<thead>
				<tr>
					<td colspan=11 style="border: none;"><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
        <hr>
		<?php
	} ?>
    <h5 class="rejected fs14">Date Generated: <?= $this->Time->format("F j, Y h:i:s A", date('Ymd H:i:s'), NULL, NULL); ?></h5>
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
                                    <td  style="mso-number-format:'@'; white-space: nowrap;"><?= (($ym['CourseInstructorAssignment']['created'] == $ym['CourseInstructorAssignment']['modified']) ? $this->Time->format("F j, Y h:i:s A", $ym['CourseInstructorAssignment']['created'], NULL, NULL) : ($this->Time->format("F j, Y h:i:s A", $ym['CourseInstructorAssignment']['modified'], NULL, NULL))); ?></td>
                                    <td class="center"><?= $departmentNamee; ?></td>
                                    <td class="center" style="mso-number-format:'@'; white-space: nowrap; <?= (!empty($ym['CourseInstructorAssignment']['grade_submission_deadline']) ? ($ym['CourseInstructorAssignment']['grade_submission_deadline'] > date('Y-m-d') ? 'color:green' : 'color:red') : 'color:gray'); ?>">
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