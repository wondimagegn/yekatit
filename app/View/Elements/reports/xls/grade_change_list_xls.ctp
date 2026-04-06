<?php
header("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Content-Description: Exported as XLS");
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
if (isset($gradeChangeLists) && !empty($gradeChangeLists)) { 

    if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table" style="border: none;">
			<thead>
				<tr>
					<td colspan=25 style="border: none;"><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
        <hr>
		<?php
	} 

    $total_grade_chages = 0;
    $auto_converted_ng_grades = 0;
    $manually_converted_ng_grades = 0;
    $initiated_by_department = 0;
    $grade_changes_from_instructors = 0; ?>

    
    <table cellpadding="0" cellspacing="0" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>College</th>
                <th>Department</th>
                <th>Program</th>
                <th>Program Type</th>
                <th>Student Name</th>
                <th>Sex</th>
                <th>Student ID</th>
                <th>Instructor</th>
                <th>Section</th>
                <th>From</th>
                <th>Course</th>
                <th>Old</th>
                <th>New</th>
                <th>Grade Change Requested Date</th>
                <th>Initiated By</th>
                <th>Grade Change Reason</th>
                <th>Department Approved By</th>
                <th>Department Reason</th>
                <th>Department Approval Date</th>
                <th>College Approved By</th>
                <th>College Approval Date</th>
                <th>Registrar Approved by</th>
                <th>Registrar Approval Date</th>
                <th>Graduated?</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach ($gradeChangeLists as $staffName => $courseList) {
                foreach ($courseList as $ck => $cd) { 
                    ++$count; 
                    $total_grade_chages++; ?>
                    <tr>
                        <td><?= $count; ?></td>
                        <td><?= $cd['Student']['College']['name']; ?></td>
                        <td><?= (isset($cd['Student']['Department']['id']) && !empty($cd['Student']['Department']['id']) ? $cd['Student']['Department']['name'] : ($cd['Student']['Program']['id'] == PROGRAM_REMEDIAL ? 'Remedial' : 'Pre/Freshman')); ?></td>
                        <td><?= $cd['Student']['Program']['name']; ?></td>
                        <td><?= $cd['Student']['ProgramType']['name']; ?></td>
                        <td><?= $cd['Student']['full_name']; ?></td>
                        <td><?= (strcasecmp(trim($cd['Student']['gender']), 'male') == 0 ? 'M' : (strcasecmp(trim($cd['Student']['gender']), 'female') == 0 ? 'F' : trim($cd['Student']['gender']))); ?></td>
                        <td><?= $cd['Student']['studentnumber']; ?></td>
                        <td><?= $cd['instructor']; ?></td>
                        <td><?= $cd['section']; ?></td>
                        <td><?= $cd['registrationType']; ?></td>
                        <td><?= $cd['course']; ?></td>
                        <td style="vertical-align: center; text-align: center; font-weight: bold;"><?= $cd['oldGrade']; ?></td>
                        <td style="vertical-align: center; text-align: center; font-weight: bold;"><?= $cd['grade']; ?></td>
                        <td style="mso-number-format:'@'; white-space: nowrap;"><?= $this->Time->format("F j, Y h:i:s A", $cd['created'], NULL, NULL); ?></td>
                        <td style="vertical-align: center; text-align: center; font-weight: bold;">
                            <?php
                            if ($cd['manual_ng_conversion'] == 1) {
                                echo '<strong style="color:red">Manual NG to F Conversion</strong>';
                                $manually_converted_ng_grades++;
                            } else if ($cd['auto_ng_conversion'] == 1) {
                                echo '<strong style="color:red">Automatic NG to F Conversion</strong>';
                                $auto_converted_ng_grades++;
                            } else if ($cd['initiated_by_department'] == 1) {
                                echo "<span class='rejected'>Department</span>";
                                $initiated_by_department++;
                            } else if ($cd['initiated_by_department'] == 0 && $cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1) {
                                echo "Instructor";
                                $grade_changes_from_instructors++;
                            } ?>
                        </td>
                        <td><?= (!empty($cd['reason']) ? $cd['reason'] : '---'); ?></td>
                        <td><?= $cd['department_approved_by']; ?></td>
                        <td><?= (!empty($cd['department_reason']) ? $cd['department_reason'] : '---'); ?></td>
                        <td style="mso-number-format:'@'; white-space: nowrap;"><?= (($cd['department_approval_date'] == '0000-00-00 00:00:00' || $cd['department_approval_date'] == '' || is_null($cd['department_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['department_approval_date'], NULL, NULL))); ?></td>
                        <td><?= $cd['college_approved_by']; ?></td>
                        <td style="mso-number-format:'@'; white-space: nowrap;"><?= (($cd['college_approval_date'] == '0000-00-00 00:00:00' || $cd['college_approval_date'] == '' || is_null($cd['college_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['college_approval_date'], NULL, NULL))); ?></td>
                        <td><?= $cd['registrar_approved_by']; ?></td>
                        <td style="mso-number-format:'@'; white-space: nowrap;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                        <td><?= ($cd['Student']['graduated'] == 1 ? 'Yes' : 'No'); ?></td>
                    </tr>
                    <?php
                }
            } ?>
        </tbody>
    </table>
    
    <br>
    <hr>
    <span class="text-black fs14">
		<strong>Stats for selected Grade Changes: </strong><br />
		Total: <?= ($total_grade_chages) ?> <br />
		Initiated by Instructor:  <?= $grade_changes_from_instructors; ?><br />
		Initiated by Department: <?= $initiated_by_department; ?><br />
		Manually Converted NG Grades: <?= $manually_converted_ng_grades; ?><br/>
        Auto Converted NG Grades: <?= $auto_converted_ng_grades; ?><br/>
	</span>
    <hr>
    <?php
} ?>