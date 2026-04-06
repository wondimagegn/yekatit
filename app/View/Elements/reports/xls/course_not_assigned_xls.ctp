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
        text-align: center;
        width: 100%;
        table-layout: auto; /* Let columns grow naturally */
        /* border: 1px solid #000; */
    }
    th, td {
        /* border: 1px solid #000; */
        /* padding: 5px; */
        text-align: left; /* Aligns text naturally */
        white-space: nowrap; /* Prevents text wrapping */
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
if (isset($notAssignedCourseeList) && !empty($notAssignedCourseeList)) { 
    foreach ($notAssignedCourseeList as $dept => $yearLevel) {
        $filteredLevels = array();
        foreach ($yearLevel as $ykey => $courses) {
            if (!empty($courses)) {
                $filteredLevels[$ykey] = $courses;
            }
        }

        if (!empty($filteredLevels)) {
            $notAssignedCourseeList[$dept] = $filteredLevels;
        } else {
            unset($notAssignedCourseeList[$dept]);
        }
    }  
    
    if (!empty($notAssignedCourseeList)) {
        if (!empty($headerLabel)) { ?>
            <hr>
            <table cellpadding="0" cellspacing="0" class="table" style="border: none;">
                <thead>
                    <tr>
                        <td colspan=6 style="border: none;"><b><?= $headerLabel; ?></b></td>
                    </tr>
                </thead>
            </table>
            <hr>
            <?php
        }

        $count = 0;
        foreach ($notAssignedCourseeList as $departmentNamee => $courseList) { 
            $dptName = !empty($departmentNamee) ? $departmentNamee : 'Freshman';
            if (!empty($courseList)) {
                foreach ($courseList as $rkey => $rvalue) { ?>
                    <div style="overflow-x:auto;">
                        <table style="width:100%" cellpadding="0" cellspacing="0" class='table'>
                            <thead>
                                <tr>
                                    <th colspan="6" style="vertical-align:middle; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: rgb(85, 85, 85); line-height: 1.5;">
                                        <?= $dptName . ', ' . ($year = !empty($rkey) ? $rkey . ' year' : '1st'); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="center">#</th>
                                    <th class="vcenter">Course Given By</th>
                                    <th class="vcenter">Course</th>
                                    <th class="center">Section</th>
                                    <th class="center">Program</th>
                                    <th class="center">Program Type</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                $count = 0;
                                if (isset($rvalue) && !empty($rvalue)) {
                                    foreach ($rvalue as $mn => $ym) { ?>
                                        <tr>
                                            <td class="center"><?= ++$count; ?></td>
                                            <td class="vcenter"><?= (isset($ym['GivenByDepartment']['name']) ? $ym['GivenByDepartment']['name'] : '<span class="rejected"><<-- Not Dispatched -->></span>'); ?></td>
                                            <td class="vcenter"><?= $ym['Course']['course_title'] . ' (' . $ym['Course']['course_code'] .')'; ?> </td>
                                            <td class="center"><?= $ym['Section']['name'] ?></td>
                                            <td class="center"><?= $ym['Program']['name'] ?></td>
                                            <td class="center"><?= $ym['ProgramType']['name']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <br>
                    <?php
                }
            }
        }      
    }
 } ?>