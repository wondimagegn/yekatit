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
if (isset($getActiveTeacherByDegree['teachersStatisticsByDegree']) && !empty($getActiveTeacherByDegree['teachersStatisticsByDegree']) && isset($educations) && !empty($educations)) { 
	
	if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<td colspan=<?= (count($educations) * 3) + 7; ?>><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
		<br>
		<?php
	}
	
	?>
    <!-- <div style="overflow-x:auto;"> -->
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <th rowspan="2" class="center" style="width: 3%; vertical-align: bottom; text-align: center;">#</th>
                    <th rowspan="2" class="vcenter" style="vertical-align: bottom; text-align: left;">Institute/College/School</th>
                    <th rowspan="2" class="vcenter" style="vertical-align: bottom; text-align: left;">Department</th>
                    <th rowspan="2" class="center" style="vertical-align: bottom; text-align: center;">Sex</th>
                    <?php 
					foreach ($educations as $degree) { ?>
                        <th colspan="3" class="center" style="border-left:2px #000 solid;"><?= $degree; ?></th>
                    	<?php 
					} ?>
                    <th colspan="3" class="center" style="border-left:2px #000 solid;">Grand Total</th>
                </tr>
                <tr>
                    <?php 
					foreach ($educations as $degree) { ?>
                        <th class="center" style="border-left:2px #000 solid;">Ethiopian</th>
                        <th class="center">Expatriate</th>
                        <th class="center">Total</th>
                    	<?php 
					} ?>
                    <th class="center" style="border-left:2px #000 solid;">Ethiopian</th>
                    <th class="center">Expatriate</th>
                    <th class="center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($getActiveTeacherByDegree['teachersStatisticsByDegree'] as $college => $departments) {
                    $count++;
                    $firstCollegeRow = true;

                    foreach ($departments as $department => $genderData) {
                        $firstDepartmentRow = true;

                        foreach ($genderData as $gender => $degreeData) { ?>
                            <tr>
                                <?php 
								if ($firstCollegeRow) { ?>
                                    <td rowspan="<?= count($departments) * 2; ?>" class="center" style="vertical-align: top; text-align: center;"><?= $count; ?></td>
                                    <td rowspan="<?= count($departments) * 2; ?>" class="vcenter" style="vertical-align: top; text-align: left;"><?= $college; ?></td>
                                    <?php 
									$firstCollegeRow = false; ?>
                                	<?php 
								} ?>
                                
                                <?php 
								if ($firstDepartmentRow) { ?>
                                    <td rowspan="2" class="vcenter" style="vertical-align: top; text-align: left;"><?= $department; ?></td>
                                    <?php $firstDepartmentRow = false; ?>
                                	<?php 
								} ?>

                                <td class="vcenter"><?= ucwords($gender); ?></td>
                                <?php
                                $grandTotals = ['Ethiopian' => 0, 'Foreigner' => 0, 'Total' => 0];

                                foreach ($educations as $degree) {
                                    $ethiopianCount = isset($degreeData[$degree]['Ethiopian']) ? $degreeData[$degree]['Ethiopian'] : 0;
                                    $foreignerCount = isset($degreeData[$degree]['Foreigner']) ? $degreeData[$degree]['Foreigner'] : 0;
                                    $totalCount = $ethiopianCount + $foreignerCount;

                                    $grandTotals['Ethiopian'] += $ethiopianCount;
                                    $grandTotals['Foreigner'] += $foreignerCount;
                                    $grandTotals['Total'] += $totalCount; ?>

                                    <td class="center" style="border-left:2px #000 solid;"><?= $ethiopianCount; ?></td>
                                    <td class="center"><?= $foreignerCount; ?></td>
                                    <td class="center" style="font-weight: bold;"><?= $totalCount; ?></td>
                                	<?php 
								} ?>
                                <td class="center" style="border-left:2px #000 solid;"><?= $grandTotals['Ethiopian']; ?></td>
                                <td class="center"><?= $grandTotals['Foreigner']; ?></td>
                                <td class="center" style="font-weight: bold;"><?= $grandTotals['Total']; ?></td>
                            </tr>
                        	<?php 
						} ?>
                    	<?php 
					} ?>
                	<?php 
				} ?>
            </tbody>
        </table>
    <!-- </div> -->
	<?php 
} ?>