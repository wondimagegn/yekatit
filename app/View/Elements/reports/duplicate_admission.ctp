<?php
if (isset($admittedMoreThanOneProgram) && !empty($admittedMoreThanOneProgram)) { ?>
    <!-- <h5><?php //ehco $headerLabel; ?></h5> -->
    <?php
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
    } ?>

    <hr>
    <span class="text-black fs14">
		<span class="fs14 text-gray">Found <?= (count($admittedMoreThanOneProgram)) ?> entries</span><br />
	</span>
    <?php

} ?>