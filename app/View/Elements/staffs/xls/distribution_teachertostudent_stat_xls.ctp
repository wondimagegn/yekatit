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
		/* font-family: Arial, sans-serif;
		font-size: 12px; */
		text-align: center;
		width: 100%;
		border: 1px solid #000;
	}
	th, td {
		border: 1px solid #000;
		padding: 5px;
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
if (isset($distributionStatistics['getDistributionStatsTeacherToStudents']) && !empty($distributionStatistics['getDistributionStatsTeacherToStudents'])) { 
	if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<td colspan=5><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
		<br>
		<?php
	} ?>
	<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th class="center" style="width: 5%;">#</th>
				<th class="vcenter" style="width: 35%;">Department</th>
				<th class="center" style="width: 10%;">Type</th>
				<th class="center" style="width: 10%;">Number</th>
				<th class="center">Ratio</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			foreach ($distributionStatistics['getDistributionStatsTeacherToStudents'] as $departmentNamee => $genderWithRank) { ?>
				<tr>
					<td rowspan="2" class="center" style="vertical-align: top; text-align: center;"><?= ++$count; ?></td>
					<td rowspan="2" class="vcenter" style="vertical-align: top; text-align: left;"><?= $departmentNamee; ?></td>
					<td class="center">Student</td>
					<td class="center"><?= (isset($genderWithRank['student']) && !empty($genderWithRank['student']) ? $genderWithRank['student'] : ''); ?></td>
					<td rowspan="2" class="center" style="vertical-align: middle; text-align: center;">
						<?php
						if ($genderWithRank['teacher'] > 0 && $genderWithRank['student'] > 0) {
							echo 'One Instructor to ' . (round($genderWithRank['student'] / $genderWithRank['teacher'])) . ' students ';
						} else if ($genderWithRank['teacher'] == 0 && $genderWithRank['student'] == 0) {
							echo 'No Instructor & Student is found';
						} else if ($genderWithRank['student'] == 0) {
							echo 'No Student is found';
						} else {
							echo 'No Instructor is found';
						} ?>
					</td>
				</tr>
				<tr>
					<td class="center">Instructor</td>
					<td class="center"><?= (isset($genderWithRank['teacher']) && !empty($genderWithRank['teacher']) ? $genderWithRank['teacher'] : ''); ?></td>
				</tr>
				<?php
			} ?>
		</tbody>
	</table>
	
	<?php
} ?>