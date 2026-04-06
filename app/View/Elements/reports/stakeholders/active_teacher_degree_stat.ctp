
<?php 
/* if (isset($getActiveTeacherByDegree['teachersStatisticsByDegree']) && !empty($getActiveTeacherByDegree['teachersStatisticsByDegree']) && isset($educations) && !empty($educations)) {
    debug($getActiveTeacherByDegree); ?>
	<div style="overflow-x:auto;">
		<table cellpadding="0" cellspacing="0" class="table">
			<tr>
				<th rowspan="2" class="center" style="width:2%">#</th>
				<th rowspan="2" class="center" style="width:15%">Institute/College/School</th>
				<th rowspan="2" class="center" style="width:8%">Department</th>
				<th rowspan="2" class="center" style="width:8%; border-right:2px #000000 solid;">Sex</th>
				<?php
				foreach ($educations as $k => $value) { ?>
					<th colspan="3" class="center" style="border-right:2px #000000 solid;"><?= $value; ?></th>
					<?php
				} ?>
			</tr>
			<tr>
				<?php 
				foreach ($educations as $k => $value) { ?>
					<th style="width:5%" class="center">Ethiopian</th>
					<th style="width:5%" class="center">Expatriate</th>
					<th style="width:5%; border-right:2px #000000 solid;" class="center">Total</th>
					<?php 
				} ?>
			</tr>
			<?php 
			$count = 0;
			foreach ($getActiveTeacherByDegree['teachersStatisticsByDegree'] as $college => $departmentList) { ?>
				<tr>
					<td class="center" rowspan="<?= $getActiveTeacherByDegree['collegeRowSpan'][$college] + count($departmentList) + 1; ?>"><?= ++$count;?></td>
					<td class="vcenter" rowspan="<?= $getActiveTeacherByDegree['collegeRowSpan'][$college] + count($departmentList) + 1; ?>"><?= $college;?></td>
				</tr>
				<?php 
				foreach($departmentList as $deptname => $genderList) { ?>
					<tr>
						<td class="vcenter" rowspan="<?= count($genderList) + 2 ?>"><?= $deptname; ?></td>
					</tr>
					<?php 
					$sumByDegree = array();
					foreach ($genderList as $gk => $degreelist) { ?>
						<tr>
							<td class="center" style="border-left:2px #000000 solid;border-right:2px #000000 solid;"><?= ucwords($gk); ?></td>
							<?php

							foreach ($degreelist as $pk => $ppv) {
								$sumByDegree[$pk]['Ethiopian'] += $ppv['Ethiopian'];
								$sumByDegree[$pk]['Foreigner'] += $ppv['Foreigner']; ?>
								<td class="center"><?= $ppv['Ethiopian']; ?></td>
								<td class="center"><?= $ppv['Foreigner']; ?></td>
								<td class="center" style="border-right:2px #000000 solid;font-weight: bold;"><?= $ppv['Ethiopian'] + $ppv['Foreigner']; ?></td>
								<?php 
							} ?>
						</tr>
						<?php 
					} ?>
					<tr>
						<td class="center" style="border-left:2px #000000 solid;border-right:2px #000000 solid; font-weight: bold;">Total</td>
						<?php
						foreach ($sumByDegree as $d => $dv) { ?>
							<td class="center"><?= $dv['Ethiopian']; ?></td>
							<td class="center"><?= $dv['Foreigner']; ?></td>
							<td class="center" style="border-right:2px #000000 solid; font-weight: bold;"><?= $dv['Ethiopian'] + $dv['Foreigner']; ?></td>
							<?php
						} ?>
					</tr>
					<?php 
				} 
			} ?>
		</table>
	</div>
	<?php 
  } */ ?>

<?php
if (isset($getActiveTeacherByDegree['teachersStatisticsByDegree']) && !empty($getActiveTeacherByDegree['teachersStatisticsByDegree']) && isset($educations) && !empty($educations)) { ?>
    <div style="overflow-x:auto;">
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
    </div>
	<?php 
} ?>