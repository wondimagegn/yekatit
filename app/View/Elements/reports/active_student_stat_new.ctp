<?php 
if (isset($currentlyActiveStudentStatistics['result']) && !empty($currentlyActiveStudentStatistics['result'])) {

	$result = array();

	foreach ($currentlyActiveStudentStatistics['result'] as $program => $colleges) {
		foreach ($colleges as $collegeName => $departments) {
			foreach ($departments as $departmentName => $yearLevels) {
				foreach ($yearLevels as $year => $modes) {
					foreach ($modes as $progType => $data) {
						$key = $program . '~' . $progType; // Combine program and progType as the key
						if (!isset($result[$key])) {
							$result[$key] = [];
						}
						if (!isset($result[$key][$collegeName])) {
							$result[$key][$collegeName] = [];
						}
						if (!isset($result[$key][$collegeName][$departmentName])) {
							$result[$key][$collegeName][$departmentName] = [];
						}
						$result[$key][$collegeName][$departmentName][$year] = $data;
					}
				}
			}
		}
	}

	//debug($result);

	if (!empty($result) && isset($years) && !empty($years)) {

		foreach ($result as $program => $statDetail) {
			$program_detail = explode('~',$program); ?>

			<!-- <h6 class="fs15 text-gray">Program: <?php //echo $program_detail[0] . ' / ' . $program_detail[1]; ?></h6> -->

			<div style="overflow-x:auto;">
				<table cellpadding="0" cellspacing="0" class="table">
					<thead>
						<tr>
							<th colspan="<?= (count($years) * 3) + 6; ?>" class="center" style="text-align:left;">Program: <?= $program_detail[0] . ' / ' . $program_detail[1]; ?></th>
						</tr>
						<tr> 
							<th rowspan="2" class="center" style="vertical-align:bottom; width:3%;">#</th>
							<th rowspan="2"  class="vcenter" style="vertical-align:bottom;">Institute/College/School</th>
							<th rowspan="2" class="vcenter"  style="vertical-align:bottom;">Department</th>
							<?php

							foreach ($years as $k => $value) { ?> 
								<th colspan="3"  class="center" style="text-align:center; border-left:2px #000000 solid;"><?= $value; ?></th>
								<?php 
							} ?>

							<th colspan="3" class="center" style="text-align:center; border-left:2px #000000 solid;">Grand Total</th>	
						</tr>
						<tr>
							<?php 
							foreach ($years as $k => $value) { ?>
								<th style="border-left:2px #000000 solid;" class="center">M</th>
								<th class="center">F</th>
								<th class="center">T</th>
								<?php
							} ?>
							
							<th style="border-left:2px #000000 solid;" class="center">M</th>
							<th class="center">F</th>
							<th class="center">T</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 0;

						foreach ($statDetail as $college => $stat) {

							$count++; // Increment for colleges only
							$rowspan = count($stat); // Determine the number of departments for rowspan
							$firstCollegeRow = true; // To ensure the college name is displayed only once

							foreach ($stat as $department => $deptyearLevel) { ?>
								<tr>
									<?php 
									if ($firstCollegeRow) { ?>
										<td style="vertical-align: top; text-align: center;" rowspan="<?= $rowspan; ?>"><?= $count; ?></td>
										<td style="vertical-align: top; text-align: left;" rowspan="<?= $rowspan; ?>"><?= $college; ?></td>
										<?php 
										$firstCollegeRow = false;
									} ?>

									<td class="vcenter"><?= $department; ?></td>

									<?php
									$grandT[$department]['male'] = 0;
									$grandT[$department]['female'] = 0;
									$grandT[$department]['total'] = 0;
									$grandT[$department]['rate'] = 0;

									foreach ($years as $yk => $yvalue) {
										if (isset($deptyearLevel[$yvalue])) { ?>
											<td class="center" style="border-left:2px #000000 solid;"><?= isset($deptyearLevel[$yvalue]['male']) ? $deptyearLevel[$yvalue]['male'] : '0'; ?></td>
											<td class="center"><?= isset($deptyearLevel[$yvalue]['female']) ? $deptyearLevel[$yvalue]['female'] : '0'; ?></td>
											<td class="center"><?= isset($deptyearLevel[$yvalue]['total']) ? $deptyearLevel[$yvalue]['total'] : '0'; ?></td>
											<?php
											if (isset($deptyearLevel[$yvalue]['male']) && !empty($deptyearLevel[$yvalue]['male'])) {
												$grandT[$department]['male'] += $deptyearLevel[$yvalue]['male'];
											}

											if (isset($deptyearLevel[$yvalue]['female']) && !empty($deptyearLevel[$yvalue]['female'])) {
												$grandT[$department]['female'] += $deptyearLevel[$yvalue]['female'];
											}

											if (isset($deptyearLevel[$yvalue]['total']) && !empty($deptyearLevel[$yvalue]['total'])) {
												$grandT[$department]['total'] += $deptyearLevel[$yvalue]['total'];
											}
										} else { ?>
											<td class="center" style="border-left:2px #000000 solid;">--</td>
											<td class="center">--</td>
											<td class="center">--</td>
										<?php }
									} ?>
									<td class="center" style="border-left:2px #000000 solid;"><?= ($grandT[$department]['male'] != 0 ? $grandT[$department]['male'] : '0') ; ?></td>
									<td class="center"><?= ($grandT[$department]['female'] != 0 ? $grandT[$department]['female'] : '0'); ?></td>
									<td class="center"><?= ($grandT[$department]['total'] != 0 ? $grandT[$department]['total'] : '0'); ?></td>
								</tr>
								<?php
							}
						} ?>
					</tbody>        
				</table>
			</div>
			<br>
			<br>
			<?php
		} ?>
		
		<?php 
	} else { ?>
		<script>
            $('#getReportExcel1').attr('disabled', true);//.hide();
            $('#getReportExcel2').attr('disabled', true);//.hide();
        </script>
		<?php
	}
 } ?>