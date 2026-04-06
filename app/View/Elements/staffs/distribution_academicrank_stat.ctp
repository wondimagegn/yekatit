<?php
if (isset($distributionStatistics['distributionStatsTeachersByAcademicRank']) && !empty($distributionStatistics['distributionStatsTeachersByAcademicRank']) && isset($positions) && !empty($positions)) { ?>
	<?= $this->element('staffs/graph'); ?>
	<hr>
	<div style="overflow-x:auto;">
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th rowspan="2"  class="center" style="width: 3%; text-align: center; vertical-align: bottom;">#</th>
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
	</div>
	<br>
	<?php
} ?>