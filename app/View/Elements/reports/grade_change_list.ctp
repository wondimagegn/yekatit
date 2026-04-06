<?php
/* if (isset($gradeChangeLists) && !empty($gradeChangeLists)) { 
    $total_grade_chages = 0;
    $auto_converted_ng_grades = 0;
    $manually_converted_ng_grades = 0;
    $initiated_by_department = 0;
    $grade_changes_from_instructors = 0; ?>
    <!-- <h5><?php //echo $headerLabel; ?></h5> -->
    <div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <th></th>
                    <th class="center">#</th>
                    <th class="vcenter">Student Name</th>
                    <th class="center">Sex</th>
                    <th class="center">Student ID</th>
                    <th class="center">Old</th>
                    <th class="center">New</th>
                    <th class="center">Course</th>
                    <th class="vcenter">Instructor</th>
                    <th class="center">Initiated By</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($gradeChangeLists as $staffName => $courseList) {
                    foreach ($courseList as $ck => $cd) { 
                        ++$count; 
                        $total_grade_chages++; ?>
                        <tr>
                            <td class="vcenter" onclick="toggleView(this)" id="<?= $count; ?>"><?= $this->Html->image('plus2.gif', array('id' => 'i' . $count)); ?></td>
                            <td class="center"><?= $count; ?></td>
                            <td class="vcenter"><?= $cd['Student']['full_name']; ?></td>
                            <td class="center"><?= (strcasecmp(trim($cd['Student']['gender']), 'male') == 0 ? 'M' : (strcasecmp(trim($cd['Student']['gender']), 'female') == 0 ? 'F' : trim($cd['Student']['gender']))); ?></td>
                            <td class="center"><?= $this->Html->link($cd['Student']['studentnumber'], '#', array('class' => 'jsview', 'data-animation' => "fade", 'data-reveal-id' => 'myModal', 'data-reveal-ajax' => "/students/get_modal_box/" . $cd['Student']['id'])); ?></td>
                            <td class="center"><?= $cd['oldGrade']; ?></td>
                            <td class="center"><?= $cd['grade']; ?></td>
                            <td class="center"><?= $cd['course']; ?></td>
                            <td class="vcenter"><?= $cd['instructor']; ?></td>
                            <td class="center">
                                <?php
                                if ($cd['manual_ng_conversion'] == 1) {
                                    echo '<strong style="color:red">Manual NG to F Conversion</strong>';
                                    $manually_converted_ng_grades++;
                                } else if ($cd['auto_ng_conversion'] == 1) {
                                    echo '<strong style="color:red">Automatic NG to F Conversion</strong>';
                                    $auto_converted_ng_grades++;
                                } else if ($cd['initiated_by_department'] == 1) {
                                    echo "<span class='rejected'>Department</span>";
                                    $initiated_by_department++;
                                } else if ($cd['initiated_by_department'] == 0 && $cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1) {
                                    echo "Instructor";
                                    $grade_changes_from_instructors++;
                                } ?>
                            </td>
                        </tr>
                        <tr id="c<?= $count; ?>" style="display:none;">
                            <td colspan="2" style="background-color: white;"></td>
                            <td colspan="8" style="font-size:14px;background-color: white;">
                                <table table cellpadding="0" cellspacing="0" class="table">
                                    <tbody>
                                        <?php
                                        if (isset($cd['section'])) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white; width: 25%;"><strong>Section: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['section'] . (isset($cd['registrationType']) ? ' &nbsp; &nbsp; &nbsp; &nbsp; <spna class="accepted">From: ' . $cd['registrationType'] . '</spna> ': ''); ?></td>
                                            </tr>
                                            <?php
                                        }

                                        if (isset($cd['Student']['Department']['id']) || isset($cd['Student']['College']['id'])) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white; width: 25%;"><strong><?= (isset($cd['Student']['Department']['id']) && !empty($cd['Student']['Department']['id']) ? $cd['Student']['Department']['type'] : $cd['Student']['College']['type']); ?>:  </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (isset($cd['Student']['Department']['id']) && !empty($cd['Student']['Department']['id']) ? $cd['Student']['Department']['name'] : $cd['Student']['College']['name']); ?></td>
                                            </tr>
                                            <?php
                                        } ?>
                                        <tr>
                                            <td class="vcenter" style="background-color: white; width: 25%;"><strong>Grade Change Requested Date: </strong></td>
                                            <td class="vcenter" style="background-color: white;"><?= (($cd['created'] == '0000-00-00 00:00:00' || $cd['created'] == '' || is_null($cd['created'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['created'], NULL, NULL))); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="vcenter" style="background-color: white;"><strong>Grade Change Reason: </strong></td>
                                            <td class="vcenter" style="background-color: white;"><?= (!empty($cd['reason']) ? $cd['reason'] : '---'); ?></td>
                                        </tr>
                                        <?php
                                        if ($cd['initiated_by_department'] != 1) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['initiated_by_department'] == 0 && $cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1 ? '<strong>Request Initiated By: </strong></td><td class="vcenter" style="background-color: white;">Instructor' : ($cd['manual_ng_conversion'] == 1  ? '<td colspan=2 class="vcenter" style="background-color: white;"><strong style="color:red">Manual NG to F Grade Conversion By Registrar</strong></td>' : '<td colspan=2 class="vcenter" style="background-color: white;"><strong style="color:red">Automatic NG to F Conversion By System</strong></td>'); ?></td>
                                            </tr>
                                            <?php
                                            if ($cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1) { ?>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Department Approved By: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['department_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Department Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['department_reason']) ? $cd['department_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Department Approval Date: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['department_approval_date'] == '0000-00-00 00:00:00' || $cd['department_approval_date'] == '' || is_null($cd['department_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['department_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>College Approved By: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['college_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>College Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['college_reason']) ? $cd['college_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>College Approval Date: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['college_approval_date'] == '0000-00-00 00:00:00' || $cd['college_approval_date'] == '' || is_null($cd['college_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['college_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Registrar Approved By: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['registrar_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Registrar Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['registrar_reason']) ? $cd['registrar_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Registrar Approval Date: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <?php
                                            } else if ($cd['manual_ng_conversion'] == 1 || $cd['auto_ng_conversion'] == 1) { ?>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Converted by: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['registrar_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Conversion Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['registrar_reason']) ? $cd['registrar_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Date Converted: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else if ($cd['initiated_by_department'] == 1) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Request Initiated By: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><strong class="rejected">Department</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Request Initiated Date: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (($cd['department_approval_date'] == '0000-00-00 00:00:00' || $cd['department_approval_date'] == '' || is_null($cd['department_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['department_approval_date'], NULL, NULL))); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>College Approved By: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['college_approved_by']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>College Reason: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (!empty($cd['college_reason']) ? $cd['college_reason'] : '---'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>College Approval Date: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (($cd['college_approval_date'] == '0000-00-00 00:00:00' || $cd['college_approval_date'] == '' || is_null($cd['college_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['college_approval_date'], NULL, NULL))); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Registrar Approved by: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['registrar_approved_by']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Registrar Reason: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (!empty($cd['registrar_reason']) ? $cd['registrar_reason'] : '---'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Registrar Approval Date: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                                            </tr>
                                            <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <?php
                    }
                } ?>
            </tbody>
        </table>
    </div>
    <br>
    <hr>
    <span class="text-black fs14">
		<strong>Stats for selected Grade Changes: </strong><br />
		Total: <?= ($total_grade_chages) ?> <br />
		Initiated by Instructor:  <?= $grade_changes_from_instructors; ?><br />
		Initiated by Department: <?= $initiated_by_department; ?><br />
		Manually Converted NG Grades: <?= $manually_converted_ng_grades; ?><br/>
        Auto Converted NG Grades: <?= $auto_converted_ng_grades; ?><br/>
	</span>
    <?php
} */ ?>

<?php
if (isset($gradeChangeLists) && !empty($gradeChangeLists)) { ?>
    <?php
    $total_grade_chages = 0;
    $auto_converted_ng_grades = 0;
    $manually_converted_ng_grades = 0;
    $initiated_by_department = 0;
    $grade_changes_from_instructors = 0;

    foreach ($gradeChangeLists as $programD => $list) {
		$headerExplode = explode('~', $programD); ?>
        
		<div style="overflow-x:auto;">
			<table cellpadding="0" cellspacing="0" class="table">
				<thead>
					<tr>
						<td colspan="10" style="vertical-align:middle; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: rgb(85, 85, 85); line-height: 1.5;">
							<span style="font-size:15px;font-weight:bold;"><?= $headerExplode[1]; // . ' (' . (empty($this->request->data['Report']['semester']) ? '' : (($this->request->data['Report']['semester'] == 'I' ? '1st Semester, ' : ($this->request->data['Report']['semester'] == 'II' ? '2nd Semester, ' : ($this->request->data['Report']['semester'] == 'III' ? '3rd Semester. ' : $this->request->data['Report']['semester'] . ' Semester, '))))) . $this->request->data['Report']['acadamic_year'] . ')';?></span><br>
							<span class="text-gray" style="font-size: 13px; font-weight: bold">
								<?= (isset($headerExplode[0]) && !empty($headerExplode[0]) ? $headerExplode[0] . '<br>' : ''); ?>
								<?= $headerExplode[2] . ' &nbsp; | &nbsp; ' . $headerExplode[3]; ?><br>
								<?php //echo $this->request->data['Report']['acadamic_year'] . (empty($this->request->data['Report']['semester']) ? '' : (' &nbsp; | &nbsp; ' . ($this->request->data['Report']['semester'] == 'I' ? '1st Semester' : ($this->request->data['Report']['semester'] == 'II' ? '2nd Semester' : ($this->request->data['Report']['semester'] == 'III' ? '3rd Semester' : $this->request->data['Report']['semester'] . ' Semester'))))); ?><!-- <br> -->
							</span>
						</td>
					</tr>
					<tr>
						<th></th>
                        <th class="center">#</th>
                        <th class="vcenter">Student Name</th>
                        <th class="center">Sex</th>
                        <th class="center">Student ID</th>
                        <th class="center">Old</th>
                        <th class="center">New</th>
                        <th class="center">Course</th>
                        <th class="vcenter">Instructor</th>
                        <th class="center">Initiated By</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 0;
					foreach ($list as $ck => $cd) {
						++$count; 
                        $total_grade_chages++; ?>
                        <tr>
                            <td class="vcenter" onclick="toggleView(this)" id="<?= $cd['Student']['id']; ?>"><?= $this->Html->image('plus2.gif', array('id' => 'i' . $cd['Student']['id'])); ?></td>
                            <td class="center"><?= $count; ?></td>
                            <td class="vcenter"><?= $cd['Student']['full_name']; ?></td>
                            <td class="center"><?= (strcasecmp(trim($cd['Student']['gender']), 'male') == 0 ? 'M' : (strcasecmp(trim($cd['Student']['gender']), 'female') == 0 ? 'F' : trim($cd['Student']['gender']))); ?></td>
                            <td class="center"><?= $this->Html->link($cd['Student']['studentnumber'], '#', array('class' => 'jsview', 'data-animation' => "fade", 'data-reveal-id' => 'myModal', 'data-reveal-ajax' => "/students/get_modal_box/" . $cd['Student']['id'])); ?></td>
                            <td class="center"><?= $cd['oldGrade']; ?></td>
                            <td class="center"><?= $cd['grade']; ?></td>
                            <td class="center"><?= $cd['course']; ?></td>
                            <td class="vcenter"><?= $cd['instructor']; ?></td>
                            <td class="center">
                                <?php
                                if ($cd['manual_ng_conversion'] == 1) {
                                    echo '<strong style="color:red">Manual NG to F Conversion</strong>';
                                    $manually_converted_ng_grades++;
                                } else if ($cd['auto_ng_conversion'] == 1) {
                                    echo '<strong style="color:red">Automatic NG to F Conversion</strong>';
                                    $auto_converted_ng_grades++;
                                } else if ($cd['initiated_by_department'] == 1) {
                                    echo "<span class='rejected'>Department</span>";
                                    $initiated_by_department++;
                                } else if ($cd['initiated_by_department'] == 0 && $cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1) {
                                    echo "Instructor";
                                    $grade_changes_from_instructors++;
                                } ?>
                            </td>
                        </tr>
                        <tr id="c<?= $cd['Student']['id']; ?>" style="display:none;">
                            <td colspan="2" style="background-color: white;"></td>
                            <td colspan="8" style="font-size:14px;background-color: white;">
                                <table table cellpadding="0" cellspacing="0" class="table">
                                    <tbody>
                                        <?php
                                        if (isset($cd['section'])) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white; width: 25%;"><strong>Section: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['section'] . (isset($cd['registrationType']) ? ' &nbsp; &nbsp; &nbsp; &nbsp; <spna class="accepted">From: ' . $cd['registrationType'] . '</spna> ': ''); ?></td>
                                            </tr>
                                            <?php
                                        }

                                        if (isset($cd['Student']['Department']['id']) || isset($cd['Student']['College']['id'])) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white; width: 25%;"><strong><?= (isset($cd['Student']['Department']['id']) && !empty($cd['Student']['Department']['id']) ? $cd['Student']['Department']['type'] : $cd['Student']['College']['type']); ?>:  </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (isset($cd['Student']['Department']['id']) && !empty($cd['Student']['Department']['id']) ? $cd['Student']['Department']['name'] : $cd['Student']['College']['name']); ?></td>
                                            </tr>
                                            <?php
                                        } ?>
                                        <tr>
                                            <td class="vcenter" style="background-color: white; width: 25%;"><strong>Grade Change Requested Date: </strong></td>
                                            <td class="vcenter" style="background-color: white;"><?= (($cd['created'] == '0000-00-00 00:00:00' || $cd['created'] == '' || is_null($cd['created'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['created'], NULL, NULL))); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="vcenter" style="background-color: white;"><strong>Grade Change Reason: </strong></td>
                                            <td class="vcenter" style="background-color: white;"><?= (!empty($cd['reason']) ? $cd['reason'] : '---'); ?></td>
                                        </tr>
                                        <?php
                                        if ($cd['initiated_by_department'] != 1) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['initiated_by_department'] == 0 && $cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1 ? '<strong>Request Initiated By: </strong></td><td class="vcenter" style="background-color: white;">Instructor' : ($cd['manual_ng_conversion'] == 1  ? '<td colspan=2 class="vcenter" style="background-color: white;"><strong style="color:red">Manual NG to F Grade Conversion By Registrar</strong></td>' : '<td colspan=2 class="vcenter" style="background-color: white;"><strong style="color:red">Automatic NG to F Conversion By System</strong></td>'); ?></td>
                                            </tr>
                                            <?php
                                            if ($cd['manual_ng_conversion'] != 1 && $cd['auto_ng_conversion'] != 1) { ?>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Department Approved By: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['department_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Department Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['department_reason']) ? $cd['department_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Department Approval Date: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['department_approval_date'] == '0000-00-00 00:00:00' || $cd['department_approval_date'] == '' || is_null($cd['department_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['department_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>College Approved By: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['college_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>College Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['college_reason']) ? $cd['college_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>College Approval Date: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['college_approval_date'] == '0000-00-00 00:00:00' || $cd['college_approval_date'] == '' || is_null($cd['college_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['college_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Registrar Approved By: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['registrar_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Registrar Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['registrar_reason']) ? $cd['registrar_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Registrar Approval Date: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <?php
                                            } else if ($cd['manual_ng_conversion'] == 1 || $cd['auto_ng_conversion'] == 1) { ?>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Converted by: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= $cd['registrar_approved_by']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Conversion Reason: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (!empty($cd['registrar_reason']) ? $cd['registrar_reason'] : '---'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter" style="background-color: white;"><strong>Date Converted: </strong></td>
                                                    <td class="vcenter" style="background-color: white;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else if ($cd['initiated_by_department'] == 1) { ?>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Request Initiated By: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><strong class="rejected">Department</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Request Initiated Date: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (($cd['department_approval_date'] == '0000-00-00 00:00:00' || $cd['department_approval_date'] == '' || is_null($cd['department_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['department_approval_date'], NULL, NULL))); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>College Approved By: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['college_approved_by']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>College Reason: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (!empty($cd['college_reason']) ? $cd['college_reason'] : '---'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>College Approval Date: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (($cd['college_approval_date'] == '0000-00-00 00:00:00' || $cd['college_approval_date'] == '' || is_null($cd['college_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['college_approval_date'], NULL, NULL))); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Registrar Approved by: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= $cd['registrar_approved_by']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Registrar Reason: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (!empty($cd['registrar_reason']) ? $cd['registrar_reason'] : '---'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="vcenter" style="background-color: white;"><strong>Registrar Approval Date: </strong></td>
                                                <td class="vcenter" style="background-color: white;"><?= (($cd['registrar_approval_date'] == '0000-00-00 00:00:00' || $cd['registrar_approval_date'] == '' || is_null($cd['registrar_approval_date'])) ? '' : ($this->Time->format("F j, Y h:i:s A", $cd['registrar_approval_date'], NULL, NULL))); ?></td>
                                            </tr>
                                            <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <?php
					} ?>
				</tbody>
			</table>
		</div>
		<br>
        <br>
		<?php
	}  ?>

    <hr>
    <span class="text-black fs14">
		<strong>Stats for selected Grade Changes: </strong><br />
		Total: <?= ($total_grade_chages) ?> <br />
		Initiated by Instructor:  <?= $grade_changes_from_instructors; ?><br />
		Initiated by Department: <?= $initiated_by_department; ?><br />
		Manually Converted NG Grades: <?= $manually_converted_ng_grades; ?><br/>
        Auto Converted NG Grades: <?= $auto_converted_ng_grades; ?><br/>
	</span>
    <?php
} ?>