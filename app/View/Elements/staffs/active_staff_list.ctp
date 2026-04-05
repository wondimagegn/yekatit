<?php
if (isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) { 
    foreach ($distributionStatistics['getActiveStaffList'] as $departmentNamee => $listStaff) {
        if (isset($listStaff) && !empty($listStaff)) { ?>
            <div style="overflow-x:auto;">
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
                                <td class="vcenter"><?= (!empty($v['Staff']['phone_mobile']) ? $v['Staff']['phone_mobile'] : ''); ?></td>
                            </tr>
                            <?php 
                        } ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <?php
        }
    } ?>
    <?php
} ?>