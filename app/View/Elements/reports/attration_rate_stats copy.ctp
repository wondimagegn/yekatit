<div class="attrationView index">
	<?php
	if (isset($attrationRate) && !empty($attrationRate) && isset($years) && !empty($years)) {

		$table_width = (count($years)*10) + (count($years)*10) + 86;
		$grandTCollege = array();

		foreach ($attrationRate as $program => $statDetail) {
			$program_detail = explode('~',$program); ?>

			<p class="fs16">
				<!-- Student Attration rate of <?php //echo $this->data['Report']['acadamic_year']; ?> AY, Semester: <?php //echo $this->data['Report']['semester']; ?> <br/> -->
				<strong>Program : </strong> <?= $program_detail[0]; ?><br/>
				<strong>Program Type: </strong> <?= $program_detail[1]; ?>
			</p>

			<div style="overflow-x:auto;">
				<table cellpadding="0" cellspacing="0" class="table">
					<thead>
						<tr>
							<th rowspan="2" class="center" style="vertical-align:bottom; width:2%">#</th>
							<th rowspan="2"  class="vcenter" style="vertical-align:bottom; width:15%">Institute/College/School</th>
							<th rowspan="2" class="vcenter"  style="vertical-align:bottom; width:8%">Department</th>
							<?php
							$percent = 10;
							$last_percent = false;
							$total_percent = (count($years) * 10) + (count($years) * 10) + 86;

							if ($total_percent > 100) {
								//$percent = (100 - 86) / (count($master_sheet['registered_courses']) + count($master_sheet['added_courses']));
							} else if ($total_percent < 100) {
								$last_percent = 100 - $total_percent;
							}

							foreach ($years as $k => $value) { ?> 
								<th colspan="4"  class="center" style="text-align:center; border-left:2px #000000 solid; width:<?= $percent; ?>%;"  class="center"><?= $value; ?></th>
								<?php 
							} ?>

							<th colspan="4" class="center" style="text-align:center; width:15%; border-left:2px #000000 solid;" class="center">Grand Total</th>	
						</tr>
						<tr>
							<?php 
							foreach ($years as $k => $value) { ?>
								<th style="width:5%; border-left:2px #000000 solid;" class="center">M</th>
								<th style="width:5%" class="center">F</th>
								<th style="width:5%" class="center">TRS</th>
								<th style="width:5%" class="center">RD</th>
								<?php
							} ?>
							
							<th style="width:5%; border-left:2px #000000 solid;" class="center">M</th>
							<th style="width:5%" class="center">F</th>
							<th style="width:5%" class="center">TRS</th>
							<th style="width:5%" class="center">RD</th>
						</tr>
					</thead>
					<tbody>
						<?php     
						$count = 0;
						foreach($statDetail as $college => $stat) {

							$grandTCollege[$college]['male'] = 0;
							$grandTCollege[$college]['female'] = 0;
							$grandTCollege[$college]['total'] = 0;
							$grandTCollege[$college]['rate'] = 0;

							foreach ($stat as $department => $deptyearLevel)  { 
								$count++; ?>
								<tr>
									<td class="center"><?= $count; ?></td>
									<td class="vcenter"><?= $college; ?></td>
									<td class="vcenter"><?= $department; ?></td>
									<?php
									$grand_total_female = 0;
									$grand_total_male = 0;
									$dept_total = 0;
									$dept_rate = 0;

									$grandT[$department]['male'] = 0;
									$grandT[$department]['female'] = 0;
									$grandT[$department]['total'] = 0;
									$grandT[$department]['rate'] = 0;

									foreach ($years as $yk => $yvalue) {
										if (isset($deptyearLevel[$yvalue])) { ?>
											<td class="center" style="border-left:2px #000000 solid;"><?= (isset($deptyearLevel[$yvalue]['male']) ? $deptyearLevel[$yvalue]['male'] : '0'); ?></td>
											<td class="center"><?= (isset($deptyearLevel[$yvalue]['female']) ? $deptyearLevel[$yvalue]['female'] : '0'); ?></td>
											<td class="center"><?= (isset($deptyearLevel[$yvalue]['total']) ? $deptyearLevel[$yvalue]['total'] : '0'); ?></td>
											<td class="center"><?= ($deptyearLevel[$yvalue]['total'] > 0  ? (isset($deptyearLevel[$yvalue]['male']) && isset($deptyearLevel[$yvalue]['female']) ? number_format(($deptyearLevel[$yvalue]['male'] + $deptyearLevel[$yvalue]['female']) / $deptyearLevel[$yvalue]['total'], 3, '.', '') : '0') : '0'); ?></td>  
											<?php

											if (isset($deptyearLevel[$yvalue]['male'])) {
												$grand_total_male += $deptyearLevel[$yvalue]['male'];
												$grandT[$department]['male'] += $deptyearLevel[$yvalue]['male'];
												$grandTCollege[$college]['male'] += $deptyearLevel[$yvalue]['male'];
											}

											if (isset($deptyearLevel[$yvalue]['female'])) {
												$grand_total_female += $deptyearLevel[$yvalue]['female'];
												$grandT[$department]['female'] += $deptyearLevel[$yvalue]['female'];
												$grandTCollege[$college]['female'] += $deptyearLevel[$yvalue]['female'];
											}

											if (isset($deptyearLevel[$yvalue]['total'])) {
												$dept_total += $deptyearLevel[$yvalue]['total'];
												$grandT[$department]['total'] += $deptyearLevel[$yvalue]['total'];
												$grandTCollege[$college]['total'] += $deptyearLevel[$yvalue]['total'];
											}

										} else { ?>
											<td class="center" class="center" style="border-left:2px #000000 solid;">--</td>
											<td class="center">--</td>
											<td class="center">--</td>
											<td class="center">--</td>
											<?php
										}
									} ?>
								
									<!-- <td class="center"  class="center" style="border-left:2px #000000 solid;"><?php //echo $grand_total_male; ?></td>
									<td class="center"><?php //echo $grand_total_female; ?></td>
									<td class="center"><?php //echo $dept_total; ?></td>
									<td class="center"><?php //echo ($dept_total > 0 ? number_format(($grand_total_female + $grand_total_male) / $dept_total, 3, '.', '') : '0'); ?></td> -->

									<td class="center"  class="center" style="border-left:2px #000000 solid;"><?= $grandT[$department]['male']; ?></td>
									<td class="center"><?= $grandT[$department]['female']; ?></td>
									<td class="center"><?= $grandT[$department]['total']; ?></td>
									<td class="center"><?= ($grandT[$department]['total'] > 0 ? number_format(($grandT[$department]['male'] + $grandT[$department]['female']) / $grandT[$department]['total'], 3, '.', '') : '0'); ?></td>
								</tr>
								<?php
							}

							//$count = 0;

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
			debug($grandTCollege);
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
