<?php
header("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=" . $filename . ".xls");
header("Content-Description: Exported as XLS");
?>


<?php
if (isset($resultBy) && !empty($resultBy)) {

    if (!empty($headerLabel)) { ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td colspan='11'>
					<hr><?= $headerLabel; ?>
				</td>
			</tr>
		</table>
		<?php
	}
    foreach ($resultBy as $program => $statDetail) {
        $headerExplode = explode('~', $program); ?>
        
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <td colspan="11">
                        <?= $headerExplode[0]; ?><br>
                        <?= $headerExplode[1] . ' &nbsp; | &nbsp; ' . $headerExplode[2]; ?><br>
                        <?= $this->request->data['Report']['acadamic_year'] . (empty($this->request->data['Report']['semester']) ? '' : (' &nbsp; | &nbsp; ' . ($this->request->data['Report']['semester'] == 'I' ? '1st Semester' : ($this->request->data['Report']['semester'] == 'II' ? '2nd Semester' : ($this->request->data['Report']['semester'] == 'III' ? '3rd Semester' : $this->request->data['Report']['semester'] . ' Semester'))))); ?>
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th class="center">#</th>
                    <th class="vcenter">Full Name</th>
                    <th class="vcenter">Student ID</th>
                    <th class="center">Sex</th>
                    <th class="center">Department</th>
                    <th class="center">Section</th>
                    <th class="center">Year</th>
                    <th class="center">ACY</th>
                    <th class="center">Sem</th>
                    <th class="center">SGPA</th>
                    <th class="center">CGPA</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count = 0;
                $totalMaleCount = 0;
                $totalFemaleCount = 0;

                foreach ($statDetail as $in => $val) {?>
                    <tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?= $val['id']; ?>">
                        <td class="center"><?= ++$count; ?> </td>
                        <td class="vcenter"><?= $val['first_name'] . ' ' . $val['middle_name'] . ' ' . $val['last_name']; ?></td>
                        <td class="vcenter"><?= $val['studentnumber']; ?></td>
                        <td class="center"><?php if (strcasecmp(trim($val['gender']), 'male') == 0) {  echo 'M'; $totalMaleCount++; } else {  echo 'F'; $totalFemaleCount++;  } ?></td>
                        <td class="vcenter"><?= (isset($val['Department']) ? $val['Department'] : 'Pre/Freshman'); ?></td>
                        <td class="center"><?= $val['Section']; ?></td>
                        <td class="center"><?= $val['YearLevel']; ?></td>
                        <td class="center"><?= $val['AcademicYear']; ?></td>
                        <td class="center"><?= $val['Semester']; ?></td>
                        <td class="center"><?= $val['sgpa']; ?></td>
                        <td class="center"><b><?= $val['cgpa']; ?></b></td>
                    </tr>
                    <?php
                } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="10">
                        <hr>
                        Male: <?= $totalMaleCount; ?>&nbsp;(<?= ($this->Number->precision((($totalMaleCount / ($totalFemaleCount + $totalMaleCount)) * 100), 2) . '%'); ?>)<br> 
                        Female: <?= $totalFemaleCount; ?>&nbsp;(<?= ($this->Number->precision((($totalFemaleCount / ($totalFemaleCount + $totalMaleCount)) * 100), 2) . '%'); ?>)
                        <hr>
                    </td>
                </tr>
            </tfoot>
        </table>
        <br><br>
        <?php
    }
} ?>