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
if (isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) { 
    if (!empty($headerLabel)) { ?>
		<hr>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<td colspan=5><b><?= $headerLabel; ?></b></td>
				</tr>
			</thead>
		</table>
		<br>
		<?php
	}
    
    foreach ($distributionStatistics['getActiveStaffList'] as $departmentNamee => $listStaff) {
        if (isset($listStaff) && !empty($listStaff)) { ?>
            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr><th colspan=5><?= $departmentNamee; ?></th></tr>
                    <tr>
                        <th class="center" style="width: 5%;">#</th>
                        <th class="vcenter" style="width: 35%;">Full Name</th>
                        <th class="center" style="width: 10%;">Sex</th>
                        <th class="vcenter">Position</th>
                        <th class="vcenter">Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($listStaff as $k => $v) { ?>
                        <tr>
                            <td class="center"><?= ++$count; ?></td>
                            <td class="vcenter">
                                <?php
                                echo $v['Title']['title'] . ' ' . $v['Staff']['full_name'];
                                if ($v['User']['is_admin'] == 1) {
                                    echo ' <strong>(Department Head Account)</strong> ';
                                } ?>
                            </td>
                            <td class="center"><?= (strcasecmp(trim($v['Staff']['gender']), 'male') == 0 ? 'M' : (strcasecmp(trim($v['Staff']['gender']), 'female') == 0 ? 'F' : trim($v['Staff']['gender']))); ?></td>
                            <td class="vcenter"><?= $v['Position']['position']; ?></td>
                            <td class="vcenter" style="mso-number-format:'@'; white-space: nowrap;"><?= (!empty($v['Staff']['phone_mobile']) ? $v['Staff']['phone_mobile'] : ''); ?></td>
                        </tr>
                        <?php 
                    } ?>
                </tbody>
            </table>
            <br>
            <br>
            <?php
        }
    } ?>
    <?php
} ?>