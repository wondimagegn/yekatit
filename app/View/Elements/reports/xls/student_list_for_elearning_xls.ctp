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
        text-align: left;
        width: 100%;
        /* border: 1px solid #000; */
    }
    th, td {
        /* border: 1px solid #000; */
        /* padding: 5px; */
        text-align: left;
        white-space: nowrap;
    }
    thead tr {
        background-color: #f2f2f2;
        /* border-bottom: 2px solid #000; */
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
if (isset($studentListForElearning) && !empty($studentListForElearning)) {
	foreach ($studentListForElearning as $programD => $list) {
		$headerExplode = explode('~', $programD);  ?>
		<table cellpadding="0" cellspacing="0" class="table">
			<thead>
				<tr>
					<th class="vcenter">username</th>
					<th class="vcenter">password</th>
					<th class="center">firstname</th>
					<th class="center">lastname</th>
					<th class="center">middlename</th>
					<th class="center">department</th>
					<th class="center">idnumber</th>
					<th class="center">email</th>
					<th class="center">institution</th>
					<th class="center">address</th>
					<th class="center">description</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($list as $ko => $val) { ?>
					<tr>
						<td class="vcenter"><?= (str_replace('/', '.', strtolower(trim($val['studentnumber'])))); ?></td>
						<td class="vcenter"><?= (trim($val['first_name']) . '@'. date('Y')); ?></td>
						<td class="vcenter"><?= (trim($val['first_name'])); ?></td>
						<td class="vcenter"><?= (trim($val['middle_name'])); ?></td>
						<td class="vcenter"><?= (trim($val['last_name'])); ?></td>
						<td class="vcenter"><?= (trim($val['Department'])); ?></td>
						<td class="vcenter"><?= (trim($val['studentnumber'])); ?></td>
						<td class="vcenter"><?= (isset($val['email_alternative']) && !empty($val['email_alternative']) && !empty($val['email']) ? (count(explode(INSTITUTIONAL_EMAIL_SUFFIX, $val['email'])) > 0 ? (strtolower(trim($val['email_alternative']))) : (strtolower(trim($val['email'])))) : (!empty(trim($val['email'])) ? strtolower(trim($val['email'])) : (str_replace('/', '.', strtolower(trim($val['studentnumber']))) . INSTITUTIONAL_EMAIL_SUFFIX))); ?></td>
						<td class="vcenter"><?= (trim($val['College'])); ?></td>

						<?php
						if (isset($this->data['Report']['freshman']) &&  $this->data['Report']['freshman'] == 1 ) {
							$sectionNameLC = !empty($val['Department']) ? strtolower(trim($val['Department'])) : '';
							$foundCampus = '';
							$campusNameForDisplay = trim($val['Campus']);
							if (!empty($campusListLC) && !empty($campusList)) {
								foreach ($campusListLC as $key => $value) {
									if (strpos($sectionNameLC, $value) !== false) {
										$foundCampus = $campusList[$key];
										break;
									}
								}

								if (!empty($foundCampus)) {
									$campusNameForDisplay = $foundCampus;
								}
							} ?>
							<td class="vcenter"><?= $campusNameForDisplay; ?></td>
							<?php
						} else { ?>
							<td class="vcenter"><?= (trim($val['Campus'])); ?></td>
							<?php
						} ?>
						
						<td class="vcenter"><?= $val['academicyear'] . ': ' . $val['Program'] . ' - ' . $val['ProgramType']; ?></td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>
		<?php
	}
} ?>