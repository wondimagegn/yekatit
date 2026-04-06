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
if (isset($admittedMoreThanOneProgram) && !empty($admittedMoreThanOneProgram)) {

    if (!empty($headerLabel)) { ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td colspan='7'>
					<hr><?= $headerLabel; ?>
				</td>
			</tr>
		</table>
        <br>
		<?php
	}

    foreach ($admittedMoreThanOneProgram as $dkey => $dvalue) { ?>
        <div style="overflow-x:auto;">
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <td class="center">#</td>
                        <td class="vcenter">Fullname</td>
                        <td class="center">Student ID</td>
                        <td class="center">Sex</td>
                        <td class="center">Department</td>
                        <td class="center">Program</td>
                        <td class="center">ProgramType</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($dvalue as $dk) { ?>
                        <tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?= $dk['Student']['id']; ?>">
                            <td class="center"><?= $count; ?></td>
                            <td class="vcenter"><?= $dk['Student']['full_name']; ?></td>
                            <td class="center"><?= $dk['Student']['studentnumber']; ?></td>
                            <td class="center"><?= (strcasecmp(trim($dk['Student']['gender']), 'male') == 0) ? 'M' : ((strcasecmp(trim($dk['Student']['gender']), 'female') == 0) ? 'F' : (trim($dk['Student']['gender']))); ?></td>
                            <td class="center"><?= $dk['Department']['name']; ?></td>
                            <td class="center"><?= $dk['Program']['name']; ?></td>
                            <td class="center"><?= $dk['ProgramType']['name']; ?></td>
                        </tr>
                        <?php
                        $count++;
                        } ?>
                </tbody>
            </table>
        </div>
        <br><br>
        <?php
    }
} ?>