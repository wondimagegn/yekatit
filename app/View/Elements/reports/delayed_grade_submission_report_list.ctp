<?php
if (isset($delayedGradeSubmissionReportList) && !empty($delayedGradeSubmissionReportList)) { ?>
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
								<td class="center" style="<?= isset($ym['CourseInstructorAssignment']['grade_submission_deadline']) && !empty($ym['CourseInstructorAssignment']['grade_submission_deadline']) && $ym['CourseInstructorAssignment']['grade_submission_deadline'] > date('Y-m-d') ? 'color:green' : 'color:red' ?>">
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