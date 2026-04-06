<?php
if (isset($students) && !empty($students)) { ?>
    <h6 id="validation-message_non_selected" class="text-red fs14"></h6>
    <br>

    <div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table">
            <thead>
                <tr>
                    <th style="width:2%" class="center">#</th>
                    <th style="width:3%" class="center"><?= (empty($error) ? $this->Form->checkbox("SelectAll", array('id' => 'select-all', 'checked' => '')) : '**'); ?></th>
                    <th style="width:10%" class="vcenter">Student Name</th>
                    <th style="width:8%" class="center">Student ID</th>
                    <th style="width:5%" class="center">Sex</th>
                    <th style="width:10%" class="center">CGPA</th>
                    <th style="width:10%" class="center">Academic Status</th>
                    <th style="width:4%" class="center">Entrance</th>
                    <th style="width:4%" class="center">Result Wgt</th>
                    <th style="width:10%" class="center">Females Wgt</th>
                    <th style="width:10%" class="center">Disability Wgt</th>
                    <th style="width:10%" class="center">Dev. Region Wgt</th>
                    <th style="width:4%" class="center">Total Wgt</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Building every student exam result entry
                //$st_count = 1;
                $st_count = 0;
                $visibleTheButton = false;
                $includededStudents_count = 0;

                $formatOptions = array('places' => 2, 'before' => false, 'decimals' => '.', 'thousands' => ',');

                foreach ($students as $key => $student) { ?>
                    <tr>
                        <td class="center"><?= ++$st_count; ?></td>
                        <td class="center">
                            <?php
                            if (empty($error)) {
                                if (!isset($student['Student']['academic_status_id']) || $student['Student']['academic_status_id'] == DISMISSED_ACADEMIC_STATUS_ID) {
                                    echo '**';
                                } else if (!isset($student['PlacementParticipatingStudent']['id']) && empty($student['PlacementParticipatingStudent']['id'])) {
                                    echo $this->Form->checkbox('PlacementParticipatingStudent.approve.' . $student['AcceptedStudent']['id'], array('class' => 'checkbox1'));
                                    $visibleTheButton = true;
                                } else if (isset($student['PlacementParticipatingStudent']['id'])) {
                                    if (!isset($student['PlacementParticipatingStudent']['placement_round_participant_id']) && empty($student['PlacementParticipatingStudent']['placement_round_participant_id'])) {
                                        echo $this->Form->checkbox('PlacementParticipatingStudent.approve.' . $student['AcceptedStudent']['id'], array('class' => 'checkbox1'));
                                        echo $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.id', array('value' => $student['PlacementParticipatingStudent']['id']));
                                        echo '<a href="#" class="delete" data-id=' . $student['PlacementParticipatingStudent']['id'] . '>Exclude</a>';
                                        $visibleTheButton = true;
                                        $includededStudents_count++;
                                    }
                                }
                            } else {
                                echo '**';
                            } ?>
                        </td>
                        <td class="vcenter">
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.accepted_student_id', array('value' => $student['AcceptedStudent']['id'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.student_id', array('value' => $student['Student']['id'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.program_id', array('value' => $student['PlacementParticipatingStudent']['program_id'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.program_type_id', array('value' => $student['PlacementParticipatingStudent']['program_type_id'])); ?>
                            <?php //echo $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.original_college_department', array('value' => $student['AcceptedStudent']['original_college_id']));   ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.academic_year', array('value' => $student['PlacementParticipatingStudent']['academic_year'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.applied_for', array('value' => $student['PlacementParticipatingStudent']['applied_for'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.round', array('value' => $student['PlacementParticipatingStudent']['round'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.result_weight', array('value' => $student['PlacementParticipatingStudent']['result_weight'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.total_placement_weight', array('value' => $student['PlacementParticipatingStudent']['total_placement_weight'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.female_placement_weight', array('value' => $student['PlacementParticipatingStudent']['female_placement_weight'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.disability_weight', array('value' => $student['PlacementParticipatingStudent']['disability_weight'])); ?>
                            <?= $this->Form->hidden('PlacementParticipatingStudent.' . $st_count . '.developing_region_weight', array('value' => $student['PlacementParticipatingStudent']['developing_region_weight'])); ?>

                            <?=  $student['Student']['full_name']; ?>
                        </td>
                        <td class="center"><?= $student['Student']['studentnumber']; ?></td>
                        <td class="center"><?= (strcasecmp(trim($student['AcceptedStudent']['sex']), 'male') == 0 ? 'M' : (strcasecmp(trim($student['AcceptedStudent']['sex']), 'female') == 0 ? 'F' : trim($student['AcceptedStudent']['sex']))); ?></td>
                        <td class="center"><?= (isset($student['Student']['cgpa']) ? $student['Student']['cgpa'] : ''); ?></td>
                        <td class="center"><?= (isset($student['Student']['academic_status']) ? $student['Student']['academic_status'] : ''); ?></td>
                        <td class="center"><?= $student['PlacementParticipatingStudent']['entrance']; ?></td>
                        <td class="center"><?= $student['PlacementParticipatingStudent']['result_weight']; ?></td>
                        <td class="center"><?= $student['PlacementParticipatingStudent']['female_placement_weight']; ?></td>
                        <td class="center"><?= $student['PlacementParticipatingStudent']['disability_weight']; ?></td>
                        <td class="center"><?= $student['PlacementParticipatingStudent']['developing_region_weight']; ?></td>
                        <td class="center"><?= $student['PlacementParticipatingStudent']['total_weight']; ?></td>
                    </tr>
                    <?php
                } ?>
            </tbody>
        </table>
    </div>
    <br>

    <?php
    if ($visibleTheButton && empty($error)) { ?>
        <hr>
        <div class="row">
            <div class="large-3 columns">
                <?= $this->Form->Submit('Save Placement Ready Students', array('div' => false, 'name' => 'readyForPlacement', 'id' => 'savePlacementReadyStudents', 'class' => 'tiny radius button bg-blue')); ?>
            </div>
            <div class="large-3 columns">
                <?php
                if (isset($this->data['PlacementSetting']['include']) && $includededStudents_count) {
                    echo $this->Form->Submit('Exclude Selected from Placement Ready Students', array('div' => false, 'name' => 'deleteFormPlacementReady', 'id' => 'deleteFormPlacementReadyStudents', 'class' => 'tiny radius button bg-red'));
                } ?>
            </div>
            <div class="large-3 columns">
                &nbsp;
            </div>
        </div>
        <?php
    } ?>

    <script>

        const validationMessageNonSelected = document.getElementById('validation-message_non_selected');

        $(document).ready(function () {

            let form_being_submitted = false;

            $('a.delete').click(function () {
                var row = $(this).parents('tr:first');
                var id = $(this).attr('data-id');
                var formUrl = '/PlacementParticipatingStudents/delete_ajax/' + id;
                $.ajax({
                    type: 'POST',
                    url: formUrl,
                    data: "id=" + id,
                    success: function (response) {
                        $(row).remove();
                    },
                    error: function (xhr, textStatus, error) {
                        alert(textStatus);
                    }
                });
            });

            $('#savePlacementReadyStudents').click(function(event) {
                //event.preventDefault(); 
                var checkedOne = false;

                $('input[type="checkbox"][name^="data[PlacementParticipatingStudent][approve]"]').each(function() {
                    const namePatternSelected = /^data\[PlacementParticipatingStudent\]\[approve\]\[\d+\]$/;
                    if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
                        checkedOne = true;
                        //return false;
                    }
                });

                let valid = false;

                if (!checkedOne) {
                    alert('At least one student must be selected to placement preparation.');
                    validationMessageNonSelected.innerHTML = 'At least one student must be selected to placement preparation.';
                    //valid = false;
                    return false; // prevent form submission
                } else {
                    valid = true;
                }

                if (form_being_submitted) {
                    alert("Including selected students to placement ready student list, please wait a moment...");
                    $('#savePlacementReadyStudents').attr('disabled', true);
                    valid = false;
                }

                if (valid) {
                    var confirmm = confirm('Are you sure you want to add the selected students in to placement ready student list?. Please make sure that Placement Result Settings are set for the given academic year and round for the selected unit before proceeding. Are you sure to proceed??');
                    if (confirmm && valid && !form_being_submitted) {
                        $('#savePlacementReadyStudents').val('Saving Placement Ready Students...');
                        form_being_submitted = true;
                        $('#PlacementSettingPrepareForm').submit();
                    } else {
                        return false; // Prevent submission if user cancels
                    }
                }
            });

            $('#deleteFormPlacementReadyStudents').click(function(event) {
                //event.preventDefault();
                var checkedOne = false;

                $('input[type="checkbox"][name^="data[PlacementParticipatingStudent][approve]"]').each(function() {
                    const namePatternSelected = /^data\[PlacementParticipatingStudent\]\[approve\]\[\d+\]$/;
                    if (namePatternSelected.test($(this).attr('name')) && $(this).is(':checked')) {
                        checkedOne = true;
                        return false;
                    }
                });

                let valid = false;

                if (!checkedOne) {
                    alert('At least one student must be selected to delete from to placement Ready Students.');
                    validationMessageNonSelected.innerHTML = 'At least one student must be selected to delete from to placement Ready Students.';
                    //valid = false;
                    return false; // prevent form submission
                } else {
                    valid = true;
                }

                if (form_being_submitted) {
                    alert("removing selected students from placement ready student list, please wait a moment...");
                    $('#deleteFormPlacementReadyStudents').attr('disabled', true);
                    valid = false;
                }

                if (valid) {
                    var confirmm = confirm('Are you sure you want to Exclude/DELETE the selected placement ready students?.');
                    if (confirmm && !form_being_submitted) {
                        $('#deleteFormPlacementReadyStudents').val('Excluding Selected from Placement Ready Students...');
                        form_being_submitted = true;
                        $('#PlacementSettingPrepareForm').submit();
                    } else {
                        return false; // Prevent submission if user cancels
                    }
                }
            });

            return false;
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <?php
} ?>