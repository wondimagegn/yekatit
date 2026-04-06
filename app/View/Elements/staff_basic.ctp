<?php
if (isset($staff_basic_data) && !empty($staff_basic_data)) { ?>
    <table cellspacing="0" cellpading="0" class="table fs14">
        <tbody>
            <tr>
                <td class="vcenter" style="background-color: white;"><span class="text-gray">Full Name: </span><?= (isset($staff_basic_data['Staff'][0]['Title']['title']) ? $staff_basic_data['Staff'][0]['Title']['title'] : '') . (isset($staff_basic_data['Staff'][0]['full_name']) ? ' ' . $staff_basic_data['Staff'][0]['full_name'] : ''); ?></td>
            </tr>
            <tr>
                <td class="vcenter"><span class="text-gray">Position: </span><?= (isset($staff_basic_data['Staff'][0]['Position']) && !empty($staff_basic_data['Staff'][0]['Position']) ? ' ' . $staff_basic_data['Staff'][0]['Position']['position'] : '---'); ?></td>
            </tr>
            <tr>
                <td class="vcenter" style="background-color: white;"><span class="text-gray">Email: </span><?= (!empty($staff_basic_data['Staff'][0]['email']) ? $staff_basic_data['Staff'][0]['email'] : '---'); ?></td>
            </tr>
            <tr>
                <td class="vcenter"><span class="text-gray">Mobile: </span><?= (!empty($staff_basic_data['Staff'][0]['phone_mobile']) ? $staff_basic_data['Staff'][0]['phone_mobile'] : '---'); ?></td>
            </tr>
            <?php
            if (isset($staff_basic_data['Staff'][0]['phone_office']) && !empty($staff_basic_data['Staff'][0]['phone_office'])) { ?>
                <tr>
                    <td class="vcenter" style="background-color: white;"><span class="text-gray">Office Phone: </span><?=  $staff_basic_data['Staff'][0]['phone_office']; ?></td>
                </tr>
                <?php
            } ?>
        </tbody>
    </table>
    <?php
} ?>