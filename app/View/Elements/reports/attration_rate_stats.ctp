<div class="attrationView index">
	<?php
	if (isset($attrationRate) && !empty($attrationRate) && isset($years) && !empty($years)) {

		$grandTCollege = array();

		foreach ($attrationRate as $program => $statDetail) {
			$program_detail = explode('~',$program); ?>

			<!-- <h6 class="fs15 text-gray">Program: <?php //echo $program_detail[0] . ' / ' . $program_detail[1]; ?></h6> -->

			<div style="overflow-x:auto;">
				<table cellpadding="0" cellspacing="0" class="table">
					<thead>
						<tr>
							<th rowspan="2" class="center" style="vertical-align:bottom; width:3%;">#</th>
							<th rowspan="2"  class="vcenter" style="vertical-align:bottom;">Institute/College/School</th>
							<th rowspan="2" class="vcenter"  style="vertical-align:bottom;">Department</th>
							<?php

							foreach ($years as $k => $value) { ?> 
								<th colspan="4"  class="center" style="text-align:center; border-left:2px #000000 solid;"><?= $value; ?></th>
								<?php 
							} ?>

							<th colspan="4" class="center" style="text-align:center; border-left:2px #000000 solid;">Grand Total</th>	
						</tr>
						<tr>
							<?php 
							foreach ($years as $k => $value) { ?>
								<th style="border-left:2px #000000 solid;" class="center">M</th>
								<th class="center">F</th>
								<th class="center">TRS</th>
								<th class="center">RD</th>
								<?php
							} ?>
							
							<th style="border-left:2px #000000 solid;" class="center">M</th>
							<th class="center">F</th>
							<th class="center">TRS</th>
							<th class="center">RD</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 0;

						foreach ($statDetail as $college => $stat) {

							$count++; // Increment for colleges only
							$rowspan = count($stat); // Determine the number of departments for rowspan
							$firstCollegeRow = true; // To ensure the college name is displayed only once

							$grandTCollege[$college]['male'] = 0;
							$grandTCollege[$college]['female'] = 0;
							$grandTCollege[$college]['total'] = 0;
							$grandTCollege[$college]['rate'] = 0;

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
											<td class="center"><?= isset($deptyearLevel[$yvalue]['total']) && $deptyearLevel[$yvalue]['total'] > 0 ? number_format(((isset($deptyearLevel[$yvalue]['male']) ? (int) $deptyearLevel[$yvalue]['male'] : 0 ) + (isset($deptyearLevel[$yvalue]['female']) ? (int) $deptyearLevel[$yvalue]['female'] : 0)) / $deptyearLevel[$yvalue]['total'], 3, '.', '') : '0'; ?></td>
											<?php
											if (isset($deptyearLevel[$yvalue]['male'])) {
												$grandT[$department]['male'] += $deptyearLevel[$yvalue]['male'];
												$grandTCollege[$college]['male'] += $deptyearLevel[$yvalue]['male'];
											}

											if (isset($deptyearLevel[$yvalue]['female'])) {
												$grandT[$department]['female'] += $deptyearLevel[$yvalue]['female'];
												$grandTCollege[$college]['female'] += $deptyearLevel[$yvalue]['female'];
											}

											if (isset($deptyearLevel[$yvalue]['total'])) {
												$grandT[$department]['total'] += $deptyearLevel[$yvalue]['total'];
												$grandTCollege[$college]['total'] += $deptyearLevel[$yvalue]['total'];
											}
										} else { ?>
											<td class="center" style="border-left:2px #000000 solid;">--</td>
											<td class="center">--</td>
											<td class="center">--</td>
											<td class="center">--</td>
										<?php }
									} ?>
									<td class="center" style="border-left:2px #000000 solid;"><?= $grandT[$department]['male']; ?></td>
									<td class="center"><?= $grandT[$department]['female']; ?></td>
									<td class="center"><?= $grandT[$department]['total']; ?></td>
									<td class="center"><?= $grandT[$department]['total'] > 0 ? number_format(($grandT[$department]['male'] + $grandT[$department]['female']) / $grandT[$department]['total'], 3, '.', '') : '0'; ?></td>
								</tr>
								<?php
							}

							if ($grandTCollege[$college]['total'] > 0) {
								$grandTCollege[$college]['rate'] = number_format(($grandTCollege[$college]['male'] + $grandTCollege[$college]['female']) / $grandTCollege[$college]['total'], 3, '.', '');
							}
						} ?>
					</tbody>        
				</table>
			</div>
			<br>
			<?php
		} 
		
		if (!empty($grandTCollege)) {
			//debug($grandTCollege);
		} ?>
		
		<hr>
		<p class="fs16">
			<strong>Legend: </strong><br/>
			<strong>M : </strong>Male Dismissed <br/>
			<strong>F : </strong>Female Dismissed <br/>
			<strong>TRS : </strong>Total Registred Students <br/>
			<strong>RD : </strong>Rate Dismissed<br/>
			<!-- <strong> -- : </strong>No registration for that year <br/> -->
		</p>
		<?php 
	} ?>
</div>
