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
if (isset($distributionStatistics['distributionStatsTeachersByAcademicRank']) && !empty($distributionStatistics['distributionStatsTeachersByAcademicRank']) && isset($positions) && !empty($positions)) {
	
	if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<td colspan=<?= (count($positions) + 3); ?>><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
		<br>
		<?php
	}  ?>
	
	<table cellpadding="0" cellspacing="0" class="table">
		<thead>
			<tr>
				<th rowspan="2"  class="center" style="width: 5%; text-align: center; vertical-align: bottom;">#</th>
				<th rowspan="2" class="vcenter" style="width: 30%; text-align: left; vertical-align: bottom;">Department</th>
				<th rowspan="2" class="vcenter" style="width: 7%; text-align: left; vertical-align: bottom; border-right:2px #000000 solid;">Sex</th>
				<th class="center" colspan="<?= count($positions); ?>" style="border-right:2px #000000 solid;">Position</th>
			</tr>
			<tr>
				<?php
				foreach ($positions as $sk => $svalue) { ?>
					<th class="center" style="border-right:2px #000000 solid;"><?= $svalue; ?></th>
					<?php
				}  ?>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			foreach ($distributionStatistics['distributionStatsTeachersByAcademicRank'] as $departmentNamee => $genderWithRank) { ?>
				<tr>
					<td rowspan=2 class="center" style="text-align: center; vertical-align: top;"><?= ++$count; ?></td>
					<td rowspan=2 class="vcenter" style="text-align: left; vertical-align: top;"><?= $departmentNamee; ?></td>
					<td class="vcenter" style="border-right:2px #000000 solid;">Male</td>
					<?php
					foreach ($genderWithRank['male'] as $sk => $svalue) { ?>
						<td class="center" style="border-right:2px #000000 solid;"><?= (!empty($svalue) ? $svalue : ''); ?></td>
						<?php
					} ?>
				</tr>
				<tr>
					<td class="vcenter" style="border-right:2px #000000 solid;">Female</td>
					<?php
					foreach ($genderWithRank['female'] as $sk => $svalue) { ?>
						<td class="center" style="border-right:2px #000000 solid;"><?= (!empty($svalue) ? $svalue : ''); ?></td>
						<?php
					} ?>
				</tr>
				<?php
			} ?>
		</tbody>
	</table>
	
	<?php
} ?>