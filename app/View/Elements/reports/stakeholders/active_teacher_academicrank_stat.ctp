<?php 
/* if (isset($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']) && !empty($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']) && isset($positions) && !empty($positions)) { 
	//debug($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']);
	?>
	<div style="overflow-x:auto;">
		<table cellpadding="0" cellspacing="0" class="table">
			<tr>
				<th rowspan="3" class="center" style="width:2%">#</th>
				<th rowspan="3" class="center" style="width:15%">College/School/Center</th>
				<th rowspan="3" class="center" style="width:8%">Department</th>
				<th rowspan="3" class="center" style="width:8%;border-right:2px #000000 solid;">Degree</th>
				<th colspan="<?= count($positions) * 3; ?>"  class="center" style="border-right:2px #000000 solid;">Academic Rank</th>
			</tr>
			<tr>
				<?php
				foreach ($positions as $k=>$value) { ?>
					<th colspan="3"  class="vcenter" style="border-right:2px #000000 solid;"><?= $value;?></th>
					<?php 
				} ?>
			</tr>
			<tr>
				<?php
				foreach ($positions as $k=>$value) { ?>
					<th style="width:5%" class="center">M</th>
					<th style="width:5%" class="center">F</th>
					<th style="width:5%;border-right:2px #000000 solid;font-weight: bold;" class="center">T</th>
					<?php 
				} ?>
			</tr>
			<?php 
			$count = 0;
			foreach ($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank'] as $college => $departmentList) { ?>
				<tr>
					<td class="center" rowspan="<?= $getActiveTeacherByAcademicRank['collegeRowSpan'][$college] + count($departmentList) + 1; ?>"><?= ++$count; ?></td>
					<td class="vcenter" rowspan="<?= $getActiveTeacherByAcademicRank['collegeRowSpan'][$college] + count($departmentList) + 1; ?>"><?= $college; ?></td>
				</tr>
				<?php 
				foreach($departmentList as $deptname => $degreeLists) { 
					//debug($degreeLists); ?>
					<tr>
						<td class="vcenter" rowspan="<?= count($degreeLists) + 1; ?>"><?= $deptname; ?></td>   
					</tr>
					<?php 
					foreach ($degreeLists as $dk => $rankLists) {
						//debug($rankLists); ?>
						<tr>
							<td class="center" style="border-right:2px #000000 solid;"><?= $dk; ?></td>
							<?php 
							foreach ($rankLists as $rk => $rv) { ?>
								<td class="center"><?= $rv['male']; ?></td>
								<td class="center"><?= $rv['female']; ?></td>
								<td class="center" style="border-right:2px #000000 solid;font-weight: bold;"><?= $rv['female']+$rv['male']; ?></td>
								<?php  
							} ?>
						</tr>
						<?php 
					} 
				}
			} ?>
		</table>
	</div>
	<?php 
  } */
?>

<?php
if (isset($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']) && !empty($getActiveTeacherByAcademicRank['teachersStatisticsByAcademicRank']) && isset($positions) && !empty($positions)) { ?>
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