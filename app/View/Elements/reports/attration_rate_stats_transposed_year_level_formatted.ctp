<style>
	/* General Table Styling */
	.table {
		width: 100%;
		border-collapse: collapse;
		margin: 20px 0;
		font-size: 14px;
		font-family: Arial, sans-serif;
		text-align: left;
	}

	/* Table Header Styling */
	.table thead th {
		background-color: #f4f4f4;
		color: #333;
		font-weight: bold;
		border: 1px solid #ddd;
		padding: 10px;
		text-align: center; /* Align text in the center for headers */
	}

	/* Table Body Styling */
	.table tbody td {
		border: 1px solid #ddd;
		padding: 10px;
		vertical-align: middle; /* Align content vertically */
	}

	/* Alternate Row Colors */
	.table tbody tr:nth-child(odd) {
		background-color: #f9f9f9; /* Light gray for odd rows */
	}

	.table tbody tr:nth-child(even) {
		background-color: #ffffff; /* White for even rows */
	}

	/* Total Row Styling */
	.table tbody tr td[style*="font-weight: bold;"] {
		background-color: #e8f5e9; /* Soft green for total rows */
		color: #2e7d32; /* Dark green for total text */
		font-weight: bold;
	}

	/* Center Alignment for Numeric Columns */
	.table tbody td.center {
		text-align: center;
	}

	/* Add Table Border */
	.table {
		border: 1px solid #ddd;
	}

	/* Responsive Design */
	@media (max-width: 768px) {
		.table {
			font-size: 12px; /* Smaller font size for mobile */
		}

		.table thead th, .table tbody td {
			padding: 8px;
		}
	}
</style>
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
							<th class="center" style="width:5%">#</th>
							<th class="vcenter" style="width:35%; text-align: left;">Institute/College/School</th>
							<th class="vcenter" style="width:35%; text-align: left;">Department</th>
							<th class="center" style="width:5%">Year</th>
							<th class="center" style="width:5%">M</th>
							<th class="center" style="width:5%">F</th>
							<th class="center" style="width:5%">TRS</th>
							<th class="center" style="width:5%">RD</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$collegeCount = 0; // Counter for colleges
						foreach ($statDetail as $college => $departments) {
							$collegeCount++; // Increment college number

							// Calculate rowspan for the college
							$collegeRowSpan = 0;
							foreach ($departments as $department => $yearData) {
								$collegeRowSpan += count($yearData);
								if (count($yearData) > 1) {
									$collegeRowSpan++; // Add one row for "Total" if department has more than one year
								}
							}

							$firstCollegeRow = true; // Track the first row for a college
							foreach ($departments as $department => $yearData) {
								$departmentRowSpan = count($yearData); // Calculate department row span
								if (count($yearData) > 1) {
									$departmentRowSpan++; // Include "Total" row for multiple year levels
								}

								$firstDepartmentRow = true; // Track the first row for a department
								$totalMale = 0;
								$totalFemale = 0;
								$totalTRS = 0;
								$totalAR = 0;

								foreach ($yearData as $year => $data) {
									$male = isset($data['male']) ? $data['male'] : 0;
									$female = isset($data['female']) ? $data['female'] : 0;
									$total = isset($data['total']) ? $data['total'] : 0;
									$ar = $total > 0 ? number_format(($male + $female) / $total, 3, '.', '') : 0;

									$totalMale += $male;
									$totalFemale += $female;
									$totalTRS += $total;
									$totalAR += $ar;

									?>
									<tr>
										<?php if ($firstCollegeRow): ?>
											<td class="center" rowspan="<?= $collegeRowSpan; ?>"><?= $collegeCount; ?></td>
											<td class="vcenter" rowspan="<?= $collegeRowSpan; ?>"><?= $college; ?></td>
											<?php $firstCollegeRow = false; ?>
										<?php endif; ?>

										<?php if ($firstDepartmentRow): ?>
											<td class="vcenter" rowspan="<?= $departmentRowSpan; ?>"><?= $department; ?></td>
											<?php $firstDepartmentRow = false; ?>
										<?php endif; ?>

										<td class="center"><?= $year; ?></td>
										<td class="center"><?= $male; ?></td>
										<td class="center"><?= $female; ?></td>
										<td class="center"><?= $total; ?></td>
										<td class="center"><?= $ar; ?></td>
									</tr>
									<?php
								}

								// Add "Total" row for departments with more than one year level
								if (count($yearData) > 1) {
									$averageAR = count($yearData) > 0 ? number_format($totalAR / count($yearData), 3, '.', '') : 0;
									?>
									<tr>
										<td class="center" style="font-weight: bold;">Total</td> <!-- Under "Year" -->
										<td class="center" style="font-weight: bold;"><?= $totalMale; ?></td> <!-- Under "M" -->
										<td class="center" style="font-weight: bold;"><?= $totalFemale; ?></td> <!-- Under "F" -->
										<td class="center" style="font-weight: bold;"><?= $totalTRS; ?></td> <!-- Under "TRS" -->
										<td class="center" style="font-weight: bold;"><?= $averageAR; ?></td> <!-- Under "RD" -->
									</tr>
									<?php
								}
							}
						}
						?>
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
			<strong>Legends</strong><br/>
			<strong>M : </strong>Male Dismissed <br/>
			<strong>F : </strong>Female Dismissed <br/>
			<strong>TRS : </strong>Total Registred Students <br/>
			<strong>RD : </strong>Rate Dismissed<br/>
			<!-- <strong> -- : </strong>No registration for that year <br/> -->
		</p>
		<?php 
	} ?>
</div>
