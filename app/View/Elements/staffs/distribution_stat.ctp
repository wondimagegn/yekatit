<?php
if (isset($distributionStatistics['distributionStatsTeachersByGender']) && !empty($distributionStatistics['distributionStatsTeachersByGender'])) { ?>
	<!-- <h6><?php //echo $headerLabel; ?></h6> -->
	<?= $this->element('staffs/graph'); ?>
	<hr>
	<div style="overflow-x:auto;">
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th class="center" style="width: 5%;">#</th>
					<th class="vcenter" style="width: 65%;">Department</th>
					<th class="center" style="width: 10%;">Male</th>
					<th class="center" style="width: 10%;">Female</th>
					<th class="center" style="width: 10%;">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 0;
				foreach ($distributionStatistics['distributionStatsTeachersByGender'] as $departmentName => $yll) { 
					$maleCount = (isset($yll['Male']) && !empty($yll['Male']) ? $yll['Male'] : (isset($yll['male']) && !empty($yll['male']) ? $yll['male'] : 0)); 
					$femaleCount = (isset($yll['Female']) && !empty($yll['Female']) ? $yll['Female'] : (isset($yll['female']) && !empty($yll['female']) ? $yll['female'] : 0)); 
					$totalCount = $maleCount + $femaleCount;
					?>
					<tr>
						<td class="center"><?= ++$count; ?></td>
						<td class="vcenter"><?= $departmentName; ?></td>
						<td class="center"><?= $maleCount; ?></td>
						<td class="center"><?= $femaleCount; ?></td>
						<td class="center"><?= $totalCount; ?></td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>
	</div>
	<br>
	<?php
} ?>