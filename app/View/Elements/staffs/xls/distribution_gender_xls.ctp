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
if (isset($distributionStatistics['distributionStatsTeachersByGender']) && !empty($distributionStatistics['distributionStatsTeachersByGender'])) {
	
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

	<!-- <div style="overflow-x:auto;"> -->
	<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th style="width: 5%;">#</th>
				<th style="width: 65%;">Department</th>
				<th style="width: 10%;">Male</th>
				<th style="width: 10%;">Female</th>
				<th style="width: 10%;">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			foreach ($distributionStatistics['distributionStatsTeachersByGender'] as $departmentName => $yll) { 
				$maleCount = (isset($yll['Male']) && !empty($yll['Male']) ? $yll['Male'] : (isset($yll['male']) && !empty($yll['male']) ? $yll['male'] : 0)); 
				$femaleCount = (isset($yll['Female']) && !empty($yll['Female']) ? $yll['Female'] : (isset($yll['female']) && !empty($yll['female']) ? $yll['female'] : 0)); 
				$totalCount = $maleCount + $femaleCount; ?>
				<tr>
					<td><?= ++$count; ?></td>
					<td><?= $departmentName; ?></td>
					<td><?= $maleCount; ?></td>
					<td><?= $femaleCount; ?></td>
					<td><?= $totalCount; ?></td>
				</tr>
				<?php
			} ?>
		</tbody>
	</table>
	<br>
	<?php
} ?>