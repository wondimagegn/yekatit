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
if (isset($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']) && !empty($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']) && isset($positions) && !empty($positions)) { 
	
	if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<td colspan=<?= (count($positions) * 3) + 7; ?>><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
		<br>
		<?php
	} ?>
    <div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <th rowspan="2" class="center" style="width: 3%; vertical-align: bottom; text-align: center;">#</th>
                    <th rowspan="2" class="vcenter" style="vertical-align: bottom; text-align: left;">Institute/College/School</th>
                    <th rowspan="2" class="vcenter" style="vertical-align: bottom; text-align: left;">Department</th>
                    <th rowspan="2" class="center" style="vertical-align: bottom; text-align: center;">Degree</th>
                    <?php 
					foreach ($positions as $rank) { ?>
                        <th colspan="3" class="center" style="border-left:2px #000 solid;"><?= $rank; ?></th>
                    	<?php 
					} ?>
                    <th colspan="3" class="center" style="border-left:2px #000 solid;">Grand Total</th>
                </tr>
                <tr>
                    <?php 
					foreach ($positions as $rank) { ?>
                        <th class="center" style="border-left:2px #000 solid;">M</th>
                        <th class="center">F</th>
                        <th class="center">T</th>
                    	<?php 
					} ?>
                    <th class="center" style="border-left:2px #000 solid;">M</th>
                    <th class="center">F</th>
                    <th class="center">T</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank'] as $college => $departments) {
                    $count++;
                    $collegeRowspan = 0;

                    foreach ($departments as $department => $educationData) {
                        $collegeRowspan += count($educationData); // Count rows per department for rowspan
                    }

                    $firstCollegeRow = true;

                    foreach ($departments as $department => $educationData) {
                        $departmentRowspan = count($educationData); // Count rows for each gender per department
                        $firstDepartmentRow = true;

                        foreach ($educationData as $education => $rankData) { ?>
                            <tr>
                                <?php 
								if ($firstCollegeRow) { ?>
                                    <td rowspan="<?= $collegeRowspan; ?>" class="center" style="vertical-align: top; text-align: center;"><?= $count; ?></td>
                                    <td rowspan="<?= $collegeRowspan; ?>" class="vcenter" style="vertical-align: top; text-align: left;"><?= $college; ?></td>
                                    <?php 
									$firstCollegeRow = false; ?>
                                	<?php 
								} ?>

                                <?php 
								if ($firstDepartmentRow) { ?>
                                    <td rowspan="<?= $departmentRowspan; ?>" class="vcenter" style="vertical-align: top; text-align: left;"><?= $department; ?></td>
                                    <?php 
									$firstDepartmentRow = false; ?>
                                	<?php 
								} ?>

                                <td class="vcenter"><?= ucwords($education); ?></td>
                                <?php
                                $grandTotals = ['Male' => 0, 'Female' => 0, 'Total' => 0];
                                foreach ($positions as $rank) {
                                    $male = isset($rankData[$rank]['male']) ? $rankData[$rank]['male'] : 0;
                                    $female = isset($rankData[$rank]['female']) ? $rankData[$rank]['female'] : 0;
                                    $total = $male + $female;

                                    $grandTotals['Male'] += $male;
                                    $grandTotals['Female'] += $female;
                                    $grandTotals['Total'] += $total; ?>

                                    <td class="center" style="border-left:2px #000 solid;"><?= $male; ?></td>
                                    <td class="center"><?= $female; ?></td>
                                    <td class="center" style="font-weight: bold;"><?= $total; ?></td>
                                	<?php 
								} ?>
                                <td class="center" style="border-left:2px #000 solid;"><?= $grandTotals['Male']; ?></td>
                                <td class="center"><?= $grandTotals['Female']; ?></td>
                                <td class="center" style="font-weight: bold;"><?= $grandTotals['Total']; ?></td>
                            </tr>
                        	<?php 
						}
                    }
                } ?>
            </tbody>
        </table>
    </div>
	<?php 
} ?>