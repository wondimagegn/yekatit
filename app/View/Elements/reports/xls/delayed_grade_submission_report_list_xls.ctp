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
if (isset($delayedGradeSubmissionReportList) && !empty($delayedGradeSubmissionReportList)) { 
    if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table" style="border: none;">
			<thead>
				<tr>
					<td colspan=8 style="border: none;"><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
        <hr>
		<?php
	}  ?>
	<div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
				<tr>
					<th class="center">#</th>
					<th class="vcenter">Program</th>
					<th class="center">Program Type</th>
					<th class="center">Section</th>
					<th class="center">Course</th>
					<th class="center">Instructor's Name</th>
					<th class="center">Instructor Department</th>
					<th class="center">Delayed</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 0;
				foreach ($delayedGradeSubmissionReportList as $departmentNamee => $courseList) {
					foreach ($courseList as $rkey => $rvalue) { 
						foreach ($rvalue as $mn => $ym) { ?>
							<tr>
								<td class="center"><?= ++$count; ?></td>
								<td class="vcenter"><?= $ym['Section']['Program']['name']; ?></td>
								<td class="center"><?= $ym['Section']['ProgramType']['name']; ?></td>
								<td class="center"><?= $ym['Section']['name'] . '(' . (!isset($ym['Section']['YearLevel']) ? 'Pre/1st' :  $ym['Section']['YearLevel']['name'] ) . ')'; ?></td>
								<td class="center"><?= $rkey; ?></td>
								<td class="center"><?= $ym['Staff']['Title']['title'] . ' ' . $ym['Staff']['full_name'] . '(' . $ym['Staff']['Position']['position'] . ')'; ?></td>
								<td class="center"><?= $departmentNamee; ?></td>
								<td class="center" style="mso-number-format:'@'; white-space: nowrap; <?= isset($ym['CourseInstructorAssignment']['grade_submission_deadline']) && !empty($ym['CourseInstructorAssignment']['grade_submission_deadline']) && $ym['CourseInstructorAssignment']['grade_submission_deadline'] > date('Y-m-d') ? 'color:green' : 'color:red' ?>">
									<?= (isset($ym['CourseInstructorAssignment']['grade_submission_deadline']) && !empty($ym['CourseInstructorAssignment']['grade_submission_deadline']) ? $this->Format->humanTiming($ym['CourseInstructorAssignment']['grade_submission_deadline']) : ''); ?>
								</td>
							</tr>
							<?php 
						} ?>
						<?php
					}
				} ?>
			</tbody>
		</table>
	</div>
	<?php
} ?>