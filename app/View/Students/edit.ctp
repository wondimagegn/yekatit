<?= $this->Html->script('amharictyping'); ?>
<script type="text/javascript">
    var region = Array();
    var months = Array();

    var minGraduationYear = <?= (isset($student_admission_year) && !empty($student_admission_year) ? ($student_admission_year - 20) : date('Y') - 30); ?>;
    var maxGraduationYear = <?= (isset($student_admission_year) && !empty($student_admission_year) ?  $student_admission_year : (date('Y'))); ?>;

    //alert(minGraduation);
    //alert(maxGraduation);

    <?php
    for ($i = 1; $i <= 12; $i++) { ?>
    months[<?= $i - 1; ?>] = new Array();
    months[<?= $i - 1; ?>][0] = "<?= date('m', mktime(0, 0, 0, $i, 1, 2011)); ?>";
    months[<?= $i - 1; ?>][1] = "<?= date('F', mktime(0, 0, 0, $i, 1, 2011)); ?>";
    <?php
    }

    if (!empty($regionsAll)) {
    foreach ($regionsAll as $region_id => $region_name) { ?>
    region["<?= $region_id; ?>"] = "<?= $region_name; ?>";
    <?php
    }
    } ?>

    function updateRegionCity(id) {
        //serialize form data
        var formData = $("#country_id_" + id).val();

        $("#region_id_" + id).empty();
        $("#region_id_" + id).attr('disabled', true);
        $("#city_id_" + id).attr('disabled', true);

        //get form action
        var formUrl = '/students/get_regions/' + formData;

        $.ajax({
            type: 'get',
            url: formUrl,
            data: formData,
            success: function(data, textStatus, xhr) {
                $("#region_id_" + id).attr('disabled', false);
                $("#region_id_" + id).empty();
                $("#region_id_" + id).append(data);

                //Items list
                var subCat = $("#region_id_" + id).val();
                $("#city_id_" + id).empty();

                //get form action
                var formUrl = '/students/get_cities/' + subCat;
                $.ajax({
                    type: 'get',
                    url: formUrl,
                    data: subCat,
                    success: function(data, textStatus, xhr) {
                        $("#city_id_" + id).attr('disabled', false);
                        $("#city_id_" + id).empty();
                        $("#city_id_" + id).append(data);
                    },
                    error: function(xhr, textStatus, error) {
                        alert(textStatus);
                    }
                });
                //End of items list
            },
            error: function(xhr, textStatus, error) {
                alert(textStatus);
            }
        });

        return false;
    }

    //Update city given region
    function updateCity(id) {
        //serialize form data
        var subCat = $("#region_id_" + id).val();
        $("#city_id_" + id).attr('disabled', true);
        $("#city_id_" + id).empty();

        //get form action
        var formUrl = '/students/get_cities/' + subCat;

        $.ajax({
            type: 'get',
            url: formUrl,
            data: subCat,
            success: function(data, textStatus, xhr) {
                $("#city_id_" + id).attr('disabled', false);
                $("#city_id_" + id).empty();
                $("#city_id_" + id).append(data);
            },
            error: function(xhr, textStatus, error) {
                alert(textStatus);
            }
        });

        return false;
    }
</script>

<?php
if (isset($studentDetail) && !empty($studentDetail['Student'])) { ?>
    <div class="box">
        <div class="box-header bg-transparent">
            <div class="box-title" style="margin-top: 10px;"><i class="fontello-edit" style="font-size: larger; font-weight: bold;"></i>
                <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= 'Update Student Details: ' . $studentDetail['Student']['full_name'] . '  (' .  $studentDetail['Student']['studentnumber'] . ')'; ?></span>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="large-12 columns">
                    <div style="margin-top: -40px;"><hr></div>

                    <?php
                    if (isset($require_update) && $require_update) { ?>
                        <div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>The system detected some invalid fields, to save the changes, you're required to review the listed fields and click "Update Student Details" button to save auto corrected changes.</div>
                        <?php
                        if (isset($require_update_fields) && count($require_update_fields) > 0) { ?>
                            <div class="errorSummary">
                                <ol>
                                    <?php
                                    foreach ($require_update_fields as $key => $value) { ?>
                                        <li class="rejected">Field: <?= ($value['field']); ?>,  Exitsting Value: <?= (!is_array($value['previous_value']) ? $value['previous_value'] : implode($value['previous_value'])); ?>, Auto Corrected Value: <?= ($value['auto_corrected_value']); ?> , Reason: <?= ($value['reason']); ?></li>
                                        <?php
                                    } ?>
                                </ol>
                            </div>
                            <?php
                        } ?>
                        <hr>
                        <?php
                    } ?>

                    <?php $this->assign('title_details', (!empty($this->request->params['controller']) ? ' ' . Inflector::humanize(Inflector::underscore($this->request->params['controller'])) . (!empty($this->request->params['action']) && $this->request->params['action'] != 'index' ? ' | ' . ucwords(str_replace('_', ' ', $this->request->params['action'])) : '') : '') . (isset($studentDetail['Student']['id']) ? ' - '. $studentDetail['Student']['full_name'] . ' ('. $studentDetail['Student']['studentnumber'] .')' : '')); ?>

                    <?php
                    if (!empty($studentDetail['Attachment'][0]['basename']) || (empty($studentDetail['Attachment'][0]['basename']) && ALLOW_REGISTRAR_TO_UPLOAD_PROFILE_PICTURE == 0)) { ?>
                        <?php
                        // $this->Form->create('Student', array('data-abide', 'novalidate' => true));
                        ?>
                        <?= $this->Form->create('Student', array(
                                'id' => 'StudentEditForm',
                                'novalidate' => true,           // Disable HTML5 validation
                                'data-abide' => false           // IMPORTANT: Disable Foundation Abide completely
                        )); ?>


                        <?php
                    } else { ?>
                        <?php /* $this->Form->create('Student', array('data-abide',
                                'type' => 'file', 'novalidate' => true));*/
                        ?>

                        <?= $this->Form->create('Student', array(
                                'id' => 'StudentEditForm',
                                'type' => 'file',
                                'novalidate' => true,           // Disable HTML5 validation
                                'data-abide' => false           // IMPORTANT: Disable Foundation Abide completely
                        )); ?>
                        <?php
                    } ?>

                    <ul class="tabs" data-tab>
                        <li class="tab-title active"><a href="#basic_data">Basic Student Information</a></li>
                        <li class="tab-title"><a href="#add_address">Address & Primary Contact</a></li>
                        <li class="tab-title"><a href="#education_background">Educational Background</a></li>
                    </ul>

                    <div class="tabs-content edumix-tab-horz">
                        <div class="content active" id="basic_data" style="padding-left: 0px; padding-right: 0px;">
                            <div class="row">
                                <div class="large-12 columns">
                                    <hr style="margin-top: -10px;">
                                    <?php
                                    echo $this->Form->hidden('id', array('value' => $studentDetail['Student']['id']));

                                    if (isset($studentDetail['Contact'][0]['id'])) {
                                        echo $this->Form->hidden('Contact.0.id', array('value' => $studentDetail['Contact'][0]['id']));
                                    }

                                    echo $this->Form->hidden('Contact.0.student_id', array('value' => $studentDetail['Student']['id']));

                                    $errors = $this->Form->validationErrors;

                                    $ethiopianStudent = (isset($studentDetail['Student']['country_id']) && $studentDetail['Student']['country_id'] == COUNTRY_ID_OF_ETHIOPIA ? true : false);

                                    // force all nationals to fill fayda.
                                    $ethiopianStudent = 1;

                                    $ugProgram = (isset($studentDetail['Student']['program_id']) && $studentDetail['Student']['program_id'] == PROGRAM_UNDEGRADUATE ? true : false);


                                    if (isset($student_mobile_phone_number_error) && !empty($student_mobile_phone_number_error)) { ?>
                                        <div class='warning-box warning-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span><?= $student_mobile_phone_number_error; ?></div>
                                        <?php
                                    }

                                    if (count($errors['Student']) > 0 && isset($this->data['Student'])) {
                                        $flatErrors = Set::flatten($errors['Student']); ?>
                                        <div class="errorSummary">
                                            <ul>
                                                <?php
                                                foreach ($flatErrors as $key => $value) { ?>
                                                    <li class="rejected"><?= ($value); ?></li>
                                                    <?php
                                                } ?>
                                            </ul>
                                        </div>
                                        <?php
                                    } ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-6 columns">
                                    <table cellspacing="0" cellpading="0" class="table">
                                        <tbody>
                                        <tr>
                                            <td><strong> Demographic Information</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: white;">
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('first_name', array('readOnly' => true, 'label' => 'First Name (English): ')); ?>
                                                    <?= $this->Form->hidden('first_name', array('value' => (!empty($studentDetail['Student']['first_name']) ? $studentDetail['Student']['first_name'] : (isset($studentDetail['AcceptedStudent']) && !empty($studentDetail['AcceptedStudent']['first_name']) ? $studentDetail['AcceptedStudent']['first_name'] : NULL)))); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('middle_name', array('label' => 'Middle Name (English): ', 'readOnly' => true)); ?>
                                                    <?= $this->Form->hidden('middle_name', array('value' => (!empty($studentDetail['Student']['middle_name']) ? $studentDetail['Student']['middle_name'] : (isset($studentDetail['AcceptedStudent']) && !empty($studentDetail['AcceptedStudent']['middle_name']) ? $studentDetail['AcceptedStudent']['middle_name'] : NULL)))); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('last_name', array('label' => 'Last Name (English): ', 'readOnly' => true)); ?>
                                                    <?= $this->Form->hidden('last_name', array('value' => (!empty($studentDetail['Student']['last_name']) ? $studentDetail['Student']['last_name'] : (isset($studentDetail['AcceptedStudent']) && !empty($studentDetail['AcceptedStudent']['last_name']) ? $studentDetail['AcceptedStudent']['last_name'] : NULL)))); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <label> First Name (Amharic): <?= ($ethiopianStudent ? '&nbsp;<span class="rejected">*</span>' : ''); ?>
                                                        <?= $this->Form->input('amharic_first_name', array('label' => false, 'required' => $ethiopianStudent, 'id' => 'AmharicText', 'onkeypress' => "return AmharicPhoneticKeyPress(event,this);")); ?>

                                                    </label>
                                                </div>
                                                <div class="large-12 columns">
                                                    <label> Middle Name (Amharic): <?= ($ethiopianStudent ? '&nbsp;<span class="rejected">*</span>' : ''); ?>
                                                        <?= $this->Form->input('amharic_middle_name', array('label' => false, 'div' => true, 'required' => $ethiopianStudent, 'id' => 'AmharicTextMiddleName', 'onkeypress' => "return AmharicPhoneticKeyPress(event,this);")); ?>

                                                    </label>
                                                </div>
                                                <div class="large-12 columns">
                                                    <label> Last Name (Amharic):<?= ($ethiopianStudent ? '&nbsp;<span class="rejected">*</span>' : ''); ?>
                                                        <?= $this->Form->input('amharic_last_name', array('label' => false, 'div' => true, 'required' => $ethiopianStudent, 'id' => 'AmharicTextLastName', 'onkeypress' => "return AmharicPhoneticKeyPress(event,this);")); ?>

                                                    </label>
                                                </div>

                                                <?php
                                                if ($ethiopianStudent) { ?>
                                                    <div class="large-12 columns">
                                                        <hr>
                                                        <br>
                                                        <?= $this->Form->input('faida_alias_number', array('id' => 'faidaFan',  'type' => 'text', 'label' => 'Fayda FAN Number (16 digit) : &nbsp;<span class="rejected">* (Fill out this very carefully!)</span>', 'style' => 'width:100%;', 'placeholder' => 'Check the FRONT SIDE of your Fayda ID for FAN.', 'onBlur' => 'checkFaidaFan(this)')); ?>
                                                        <br>
                                                        <br>
                                                    </div>

                                                    <?php
                                                } ?>

                                                <?php
                                                if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR) { ?>
                                                    <div class="large-12 columns">
                                                        <hr>
                                                        <?= $this->Html->link('Name Spelling Error Correction', '#', array('data-animation' => "fade", 'data-reveal-id' => 'myModalCorrectName', 'data-reveal-ajax' => '/students/correct_name/' . $studentDetail['Student']['id'])) . '<br/>'; ?> <br>
                                                        <?= $this->Html->link('Change Name By Court Decision', '#', array('data-animation' => "fade", 'data-reveal-id' => 'myModalChangeName', 'data-reveal-ajax' => '/students/name_change/' . $studentDetail['Student']['id'])) . '<br/>'; ?>
                                                        <hr>
                                                    </div>
                                                    <?php
                                                } ?>

                                                <div class="large-12 columns">
                                                    <label> Estimated Graduation Date: (G.C) &nbsp;
                                                        <?= $this->Form->input('estimated_grad_date', array('minYear' => (isset($student_admission_year) && !empty($student_admission_year) ?  $student_admission_year : date('Y')), 'maxYear' => (isset($maximum_estimated_graduation_year_limit) && !empty($maximum_estimated_graduation_year_limit) ?  $maximum_estimated_graduation_year_limit :  (date('Y') + Configure::read('Calendar.expectedGraduationInFuture'))), 'orderYear' => 'desc', 'label' => false, 'style' => 'width: 25%;')); ?>
                                                    </label>
                                                </div>
                                                <div class="large-12 columns">
                                                    <label> Admission Date: (G.C) &nbsp;
                                                        <?= $this->Form->input('admissionyear', array('minYear' => (isset($student_admission_year) && !empty($student_admission_year) ?  $student_admission_year : date('Y')), 'maxYear' => date('Y'), 'orderYear' => 'desc', 'label' => false, 'style' => 'width: 25%;')); ?>
                                                    </label>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('gender', array('label' => 'Sex: ', 'type' => 'select', 'style' => 'width:30%;', 'div' => false, 'options' => array('Female' => 'Female', 'Male' => 'Male'))); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('lanaguage', array('label' => 'Primary Lanaguage: ')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('email', array('type' => 'email', 'id' => 'email', 'required', 'label' => 'Email: &nbsp;<span class="rejected">*</span>')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('email_alternative', array('type' => 'email', 'id' => 'alternativeEmail', 'label' => 'Alternative Email: ')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('phone_home', array('type' => 'tel', 'id'=>'phoneoffice', 'label' => 'Phone (Home): ')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('phone_mobile', array('type' => 'tel', 'id'=>'etPhone', 'required', 'label' => 'Phone (Mobile): &nbsp;<span class="rejected">*</span>')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('birthdate', array(/* 'type' => 'text', */ 'label' => 'Birth Date: (G.C) &nbsp;<span class="rejected">* (set this carefully!)</span>', 'minYear' => date('Y') - Configure::read('Calendar.birthdayInPast'), 'maxYear' => (date('Y') - 17), 'orderYear' => 'desc', 'style' => 'width: 25%;')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?php
                                                    echo $this->Form->input('nationality', array(
                                                            'label' => 'Nationality',
                                                            'id' => 'Nationality',
                                                            'type' => 'select',
                                                            'empty' => '--Select Nationality --',
                                                            'options' => array('Ethiopian' => 'Ethiopian', 'Non Ethiopian' => 'Non Ethiopian')
                                                    ));
                                                    ?>

                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br><br>
                                </div>

                                <div class="large-6 columns">
                                    <table cellpadding="0" cellspacing="0" class="table">
                                        <tbody>
                                        <tr><td colspan=2><strong>Profile Picture</strong></td></tr>
                                        <?php

                                        $atLeastOneImage = true;

                                        if (!empty($studentDetail['Attachment'][0]['basename'])) {
                                            ?>
                                            <?php
                                            if ($this->Media->file($studentDetail['Attachment'][0]['dirname'] . DS . $studentDetail['Attachment'][0]['basename'])) { ?>
                                                <tr>
                                                    <td valign="top">
                                                        <?= $this->Media->embed($this->Media->file($studentDetail['Attachment'][0]['dirname'] . DS . $studentDetail['Attachment'][0]['basename']), array('width' => '144', 'class' => 'profile-picture')); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $canbe_deleted = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("n"), date("j") - DAYS_ALLOWED_TO_DELETE_PROFILE_PICTURE_FROM_LAST_UPLOAD, date("Y")));
                                                //debug($canbe_deleted);

                                                //if ($canbe_deleted < $studentDetail['Attachment'][0]['modified'] && $this->Session->read('Auth.User')['role_id'] == ROLE_STUDENT) {
                                                $action_controller_id = 'edit~students~' . $studentDetail['Attachment'][0]['foreign_key'];
                                                ?>
                                                <tr>
                                                    <td><?= $this->Html->link(__('Delete Profile Picture', true), array('controller' => 'attachments', 'action' => 'delete', $studentDetail['Attachment'][0]['id'], $action_controller_id), null, sprintf(__('Are you sure you want to delete student profile picture which is uploaded on %s ?'/* , true */), $studentDetail['Attachment'][0]['modified'] )); ?></td>
                                                </tr>
                                                <?php
                                                //}
                                            } else { ?>
                                                <tr>
                                                    <td valign="top">
                                                        <span class="rejected">Could't load profile Picture, Directory/File inaccessasible</span> <br><br>
                                                        <img src="/img/noimage.jpg" width="144" class="profile-picture">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else { ?>
                                            <tr><td valign="top"><img src="/img/noimage.jpg" width="144" class="profile-picture"></td></tr>
                                            <?= (ALLOW_REGISTRAR_TO_UPLOAD_PROFILE_PICTURE ? '<tr><td class="vcenter">'. $this->Form->input('Attachment.0.file', array('type' => 'file', 'label' => 'Uploaad Profile Picture',  'accept' => '.jpg, .jpeg, .png')) : '' .'</td></tr>'); ?>
                                            <?php //ehco $this->element('Media.attachments'); ?>
                                            <?php
                                        } ?>

                                        <tr><td colspan=2><strong>Access Information</strong></td></tr>
                                        <?php
                                        if (isset($studentDetail['User']) && !empty($studentDetail['User']['username'])) { ?>
                                            <tr><td style="padding-left:30px;">Username: <?= (!empty($studentDetail['User']['username']) ?  $studentDetail['User']['username'] : '<span class="rejected">Usename not issued for the student</span>'); ?></td></tr>
                                            <tr><td style="padding-left:30px;">Last Login: <?= (($studentDetail['User']['last_login'] == '' ||  $studentDetail['User']['last_login'] == '0000-00-00 00:00:00' || is_null($studentDetail['User']['last_login'])) ? '<span class="rejected">Never loggedin</span>' : $this->Time->timeAgoInWords($studentDetail['User']['last_login'], array('format' => 'M j, Y', 'end' => '1 year', 'accuracy' => array('month' => 'month')))); ?></td></tr>
                                            <tr><td style="padding-left:30px;">Last Password Change: <?= (($studentDetail['User']['last_password_change_date'] == '' ||  $studentDetail['User']['last_password_change_date'] == '0000-00-00 00:00:00' || is_null($studentDetail['User']['last_password_change_date'])) ? '<span class="rejected">Never Changed</span>' : $this->Time->timeAgoInWords($studentDetail['User']['last_password_change_date'], array('format' => 'M j, Y', 'end' => '1 year', 'accuracy' => array('month' => 'month')))); ?></td></tr>
                                            <tr><td style="padding-left:30px;">Failed Logins: <?= (isset($studentDetail['User']['failed_login']) && $studentDetail['User']['failed_login'] != 0  ?  $studentDetail['User']['failed_login'] : '---'); ?></td></tr>
                                            <tr><td style="padding-left:30px;">Ecardnumber: <?= (isset($studentDetail['Student']['ecardnumber']) && !empty($studentDetail['Student']['ecardnumber']) ? $studentDetail['Student']['ecardnumber'] : '---'); ?></td></tr>
                                            <?php
                                        } else { ?>
                                            <tr><td style="padding-left:30px;" class="on-process">Username and password is not issued by the <?= (!is_null($studentDetail['Student']['department_id']) ? (isset($studentDetail['Department']['type']) && !empty($studentDetail['Department']['type']) ? $studentDetail['Department']['type'] : 'Department') : ((isset($studentDetail['College']['type']) && !empty($studentDetail['College']['type']) ? $studentDetail['College']['type'] : 'College'))); ?></td></tr>
                                            <?php
                                        } ?>
                                        <?php
                                        $preEngineeringColleges = Configure::read('preengineering_college_ids');

                                        if ($studentDetail['Student']['program_id'] == PROGRAM_REMEDIAL) {
                                            $stream = 'Remedial Program';
                                        } else if (isset($studentDetail['College']['stream']) && $studentDetail['College']['stream'] == STREAM_NATURAL && in_array($studentDetail['Student']['college_id'], $preEngineeringColleges)) {
                                            $stream = 'Freshman - Pre Engineering';
                                        } else if (isset($studentDetail['College']['stream']) && $studentDetail['College']['stream'] == STREAM_NATURAL) {
                                            $stream = 'Freshman - Natural Stream';
                                        } else if (isset($studentDetail['College']['stream']) && $studentDetail['College']['stream'] == STREAM_SOCIAL) {
                                            $stream = 'Freshman - Social Stream';
                                        } else {
                                            $stream = '---';
                                        } ?>

                                        <tr><td colspan=2><strong>Classification of Admission</strong></td></tr>
                                        <tr><td style="padding-left:30px;">Program: <?= $programs[$studentDetail['Student']['program_id']]; ?></td></tr>
                                        <tr><td style="padding-left:30px;">Program Type: <?= $programTypes[$studentDetail['Student']['program_type_id']]; ?></td></tr>
                                        <tr><td style="padding-left:30px;"><?= (isset($studentDetail['College']['type']) && !empty($studentDetail['College']['type']) ? $studentDetail['College']['type'] : 'College') ?>: <?= $colleges[$studentDetail['Student']['college_id']]; ?></td></tr>
                                        <tr><td style="padding-left:30px;"><?= (isset($studentDetail['Department']['type']) && !empty($studentDetail['Department']['type']) ? $studentDetail['Department']['type'] : 'Department') ?>: <?= (!empty($studentDetail['Student']['department_id']) && isset($studentDetail['Department']['name']) && !empty($studentDetail['Department']['name']) ? $studentDetail['Department']['name'] : (isset($departments) && !empty($departments[$studentDetail['Student']['department_id']]) ? $departments[$studentDetail['Student']['department_id']] : $stream )); ?></td></tr>
                                        <tr><td style="padding-left:30px;">Admission Year: <?= (isset($studentDetail['Student']['academicyear']) ? $studentDetail['Student']['academicyear'] : '---'); ?></td></tr>
                                        <tr><td style="padding-left:30px;">Admission Date: <?= $this->Time->format("M j, Y", $studentDetail['Student']['admissionyear'], NULL, NULL); ?></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="content" id="add_address" style="padding-left: 0px; padding-right: 0px;">
                            <div class="row">
                                <div class="large-12 columns">
                                    <hr style="margin-top: -10px;">
                                </div>
                                <div class="large-6 columns">
                                    <table cellspacing="0" cellpading="0" class="table">
                                        <tbody>
                                        <tr>
                                            <td><strong>Student's Home Address</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: white;">
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('country_id', array('id' => 'country_id_2','label' => 'Country: ',
                                                            'empty' => false, 'style' => 'width:70%;', 'default' => COUNTRY_ID_OF_ETHIOPIA)); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('region_id', array('id' => 'region_id_2','options' => $regionsAll,
                                                            'label' => 'Region: ',
                                                            'style' => 'width:70%;')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?php
                                                    if ($studentDetail['Student']['graduated'] == 1) { ?>
                                                        <?= $this->Form->input('zone_subcity', array('label' => 'Zone/Subcity: ')); ?>
                                                        <?php
                                                    } else { ?>
                                                        <?= $this->Form->input('zone_id', array('id' => 'zone_id_2',
                                                                'label' => 'Zone: ', 'empty' => '[ Select Zone ]', 'style' => 'width:70%;')); ?>
                                                        <?php
                                                    } ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?php
                                                    if ($studentDetail['Student']['graduated'] == 1) { ?>
                                                        <?= $this->Form->input('woreda', array('label' => 'Woreda: ')); ?>
                                                        <?php
                                                    } else { ?>
                                                        <?= $this->Form->input('woreda_id', array('id' => 'woreda_id_2',
                                                                'label' => 'Woreda: ', 'empty' => '[ Select Woreda ]', 'style' => 'width:70%;')); ?>
                                                        <?php
                                                    } ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('city_id', array('label' => 'City: ', 'id' => 'city_id_2', 'style' => 'width:70%;', 'empty' => '[ Select City or Leave, if not listed ]')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('kebele', array('label' => 'Kebele: ')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('house_number', array('label' => 'House Number: ')); ?>
                                                </div>
                                                <div class="large-12 columns">
                                                    <?= $this->Form->input('address1', array('label' => 'Address: ')); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br><br>
                                </div>

                                <div class="large-6 columns">
                                    <table cellspacing="0" cellpading="0" class="table">
                                        <tbody>
                                        <tr>
                                            <td><strong>Student's Primary Emergency Contact</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: white;">
                                                <?php
                                                if (FORCE_REGISTRAR_TO_FILL_STUDENTS_PRIMARY_CONTACT_INFORMATION == 1) { ?>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.first_name', array('label' => 'First Name: ',
                                                                'type' => 'text',  'onBlur' => 'checkIsAlpha(this)', 'div' => true)); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.middle_name', array('label' => 'Middle Name: ',
                                                                'type' => 'text', 'onBlur' => 'checkIsAlpha(this)')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.last_name', array('label' => 'Last Name: ',
                                                                'type' => 'text',  'onBlur' => 'checkIsAlpha(this)',)); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.country_id', array('label' => 'Country: ',
                                                                'id' => 'country_id_1', 'default' => COUNTRY_ID_OF_ETHIOPIA, 'style' => 'width:70%;',
                                                                'onchange' => 'updateRegionCity(1)')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.region_id', array('label' => 'Region: ',
                                                                'options' => $regionsAll, 'id' => 'region_id_1',
                                                                'empty' => '[ Select Region ]','style' => 'width:70%;')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.zone_id', array('label' => 'Zone: ',
                                                                'options' => $zonesAll, 'id' => 'zone_id_1',
                                                                'empty' => '[ Select Zone ]', 'style' => 'width:70%;')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.woreda_id', array('label' => 'Woreda: ',
                                                                'options' => $woredasAll, 'id' => 'woreda_id_1', 'empty' => '[ Select Woreda ]',

                                                                'style' => 'width:70%;')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.city_id', array('label' => 'City: ',
                                                                'options' => $citiesAll, 'id' => 'city_id_1', 'style' => 'width:70%;',
                                                                'empty' => '[ Select City or Leave, if not listed ]')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.email', array('type' => 'email', 'label' => 'Email: ')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.alternative_email', array('type' => 'email',
                                                                'label' => 'Alternative Email: ')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.phone_home', array('type' => 'tel',
                                                                'id' => 'intPhone1', 'label' => 'Phone (Home): ')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.phone_office', array('type' => 'tel',
                                                                'id' => 'intPhone2', 'label' => 'Phone (Office): ')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.phone_mobile', array('type' => 'tel',
                                                                'id' => 'phonemobile', 'label' => 'Phone (Mobile): ')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <?= $this->Form->input('Contact.0.address1', array('label' => 'Address: ')); ?>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <hr>
                                                        <?= $this->Form->input('Contact.0.primary_contact', array('label' => 'Primary Contact?',
                                                                'checked' => 'checked')); ?>
                                                    </div>
                                                    <?php
                                                } else { ?>
                                                    <div class="large-12 columns">
                                                        <label for="">First Name: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['first_name']) ? $this->data['Contact'][0]['first_name'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Middle Name: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['middle_name']) ? $this->data['Contact'][0]['middle_name'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Last Name: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['last_name']) ? $this->data['Contact'][0]['last_name'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Country: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['country_id']) ? $countries[$this->data['Contact'][0]['country_id']] : '[ Select Country ]'); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Region: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['region_id']) ? $regionsAll[$this->data['Contact'][0]['region_id']] : '[ Select Region ]'); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Zone: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['zone_id']) ? $zonesAll[$this->data['Contact'][0]['zone_id']] : '[ Select Zone ]'); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Woreda: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['woreda_id']) ? $woredasAll[$this->data['Contact'][0]['woreda_id']] : '[ Select Woreda ]'); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">City: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['city_id']) ? $citiesAll[$this->data['Contact'][0]['city_id']] : '[ Select City or Leave, if not listed ]'); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Email: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['email']) ? $this->data['Contact'][0]['email'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Alternative Email: </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['alternative_email']) ? $this->data['Contact'][0]['alternative_email'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Phone (Home): </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['phone_home']) ? $this->data['Contact'][0]['phone_home'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Phone (Office): </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['phone_office']) ? $this->data['Contact'][0]['phone_office'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Phone (Mobile): </label>
                                                        <input style="width: 70%;" type="text" value="<?= (isset($this->data['Contact'][0]['phone_mobile']) ? $this->data['Contact'][0]['phone_mobile'] : ''); ?>" readonly />
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <label for="">Address: </label>
                                                        <textarea cols="30" rows="6" value="<?= (isset($this->data['Contact'][0]['address1']) ? $this->data['Contact'][0]['address1'] : ''); ?>" ></textarea>
                                                    </div>
                                                    <div class="large-12 columns">
                                                        <hr>
                                                        <input type="checkbox" checked="<?= (isset($this->data['Contact'][0]['primary_contact']) && $this->data['Contact'][0]['primary_contact'] == 1 ? 'checked' : false); ?>" id="primary_contact" disabled />
                                                        <label for="primary_contact">Primary Contact?</label>
                                                    </div>
                                                    <?php

                                                } ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="content" id="education_background" style="padding-left: 0px; padding-right: 0px;">

                            <?php
                            if (($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR && $studentDetail['Program']['id'] == PROGRAM_UNDEGRADUATE)
                                    || (!empty($this->data['HighSchoolEducationBackground']))) { ?>

                                <hr style="margin-top: -10px;">
                                <blockquote>
                                    <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                                    <span style="text-align:justify;" class="fs15 text-black">Information you provide in this page should be properly formated and error free as <b><i class="rejected">it affects official transcript or student copy address contents</i></b>. <br> Please also make sure that school name doesn't exceed more than 30 characters and replace spacial characters like - , ( , ) by a space if any found in school name. <br> If you want to add more than one record for the required information, you can use 'Add Additional School' or 'Add Additional Subject' buttons and make sure that the information you are entering is chronologically ordered from the most recent to old for highschool background information.</span>
                                </blockquote>
                                <hr>

                                <?php

                                $fields = array(
                                        'school_level' => '1',
                                        'name' => '2',
                                        'national_exam_taken' => '3',
                                        'region_id' => '4',
                                        'zone' => '5',
                                        'town' => '6',
                                );

                                $all_fields = "";
                                $sep = "";

                                foreach ($fields as $key => $tag) {
                                    $all_fields .= $sep . $key;
                                    $sep = ",";
                                } ?>

                                <div class="row">
                                    <div class="large-12 columns">
                                        <div style="overflow-x:auto;">
                                            <table cellpadding="0" cellspacing="0" class="table">
                                                <thead>
                                                <tr>
                                                    <td colspan="7" style="vertical-align:middle; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: rgb(85, 85, 85); line-height: 1.5;"><h6 class="fs18 text-black">Senior Secondary/Preparatory School Attended</h6></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="high_school_education" cellpadding="0" cellspacing="0" class="table">
                                                <thead>
                                                <tr>
                                                    <th style="width: 3%;" class="center">#</th>
                                                    <th style="width: 16%;" class="ccenter">School Level</th>
                                                    <th style="width: 21%;" class="vcenter">Name</th>
                                                    <th style="width: 15%;" class="center">National Exam Taken</th>
                                                    <th style="width: 15%;" class="center">Region</th>
                                                    <th style="width: 15%;" class="center">Zone</th>
                                                    <th style="width: 15%;" class="center">Town</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (!empty($this->data['HighSchoolEducationBackground'])) {
                                                    $count = 1;
                                                    foreach ($this->data['HighSchoolEducationBackground'] as $bk => $bv) {
                                                        echo $this->Form->hidden('HighSchoolEducationBackground.' . $bk . '.student_id', array('value' => $studentDetail['Student']['id']));
                                                        if (!empty($bv['id'])) {
                                                            echo $this->Form->hidden('HighSchoolEducationBackground.' . $bk . '.id');
                                                        } ?>
                                                        <tr>
                                                            <td class="center"><?= $count; ?></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.school_level', array( 'label' => false, 'style' => 'width:100%;', 'placeholder' => 'preparatory, highschool etc..', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.name', array( 'label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.national_exam_taken', array('label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.region_id', array('options' => $regionsAll, 'style' => 'width:100%;', 'type' => 'select', 'label' => false)); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.zone', array('label' => false, 'type' => 'text')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.town', array('label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    }
                                                } else { ?>
                                                    <tr>
                                                        <td class="center">1</td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.school_level', array( 'label' => false, 'placeholder' => 'preparatory, highschool etc..', 'style' => 'width:100%;', 'value' => (isset($this->data['HighSchoolEducationBackground'][0]['school_level']) && !empty($this->data['HighSchoolEducationBackground'][0]['school_level']) ? $this->data['HighSchoolEducationBackground'][0]['school_level'] : (isset($studentDetail['AcceptedStudent']['high_school']) && !empty($studentDetail['AcceptedStudent']['high_school']) ? 'Preparatory' : '')))); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.name', array('label' => false, 'style' => 'width:100%;',   'value' => (isset($this->data['HighSchoolEducationBackground'][0]['name']) && !empty($this->data['HighSchoolEducationBackground'][0]['name']) ? $this->data['HighSchoolEducationBackground'][0]['name'] : (isset($studentDetail['AcceptedStudent']['high_school']) && !empty($studentDetail['AcceptedStudent']['high_school']) ? (ucwords(strtolower(trim($studentDetail['AcceptedStudent']['high_school'])))) : '')))); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.national_exam_taken', array('label' => false, 'style' => 'width:100%;', 'checked' => (isset($studentDetail['AcceptedStudent']['high_school']) && !empty($studentDetail['AcceptedStudent']['high_school']) ? 'checked' : false))); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.region_id', array('options' => $regionsAll, 'default' => (isset($this->data['HighSchoolEducationBackground'][0]['region_id']) && !empty($this->data['HighSchoolEducationBackground'][0]['region_id']) ? $this->data['HighSchoolEducationBackground'][0]['region_id'] : (isset($studentDetail['AcceptedStudent']['region_id']) && !empty($studentDetail['AcceptedStudent']['region_id']) ? $studentDetail['AcceptedStudent']['region_id'] :  (isset($studentDetail['Student']['region_id']) && !empty($studentDetail['Student']['region_id']) ? $studentDetail['Student']['region_id'] : ''))), 'type' => 'select',  'style' => 'width:100%;', 'label' => false, 'empty' => '[ Select Region ]')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.zone', array('label' => false, 'type' => 'text', 'style' => 'width:100%;', 'value' => (isset($this->data['HighSchoolEducationBackground'][0]['zone']) && !empty($this->data['HighSchoolEducationBackground'][0]['zone']) ? $this->data['HighSchoolEducationBackground'][0]['zone'] : (isset($studentDetail['AcceptedStudent']['zone_id']) && !empty($studentDetail['AcceptedStudent']['zone_id']) ? $zones[$studentDetail['AcceptedStudent']['zone_id']] :  (isset($studentDetail['Student']['zone_id']) && !empty($studentDetail['Student']['zone_id']) ? $zones[$studentDetail['Student']['zone_id']] : ''))))); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.town', array('label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                    </tr>
                                                    <?php
                                                    echo $this->Form->hidden('HighSchoolEducationBackground.0.student_id', array('value' => $studentDetail['Student']['id']));
                                                } ?>
                                                </tbody>
                                            </table>


                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <?php
                            }

                            if (($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR && ($studentDetail['Program']['id'] == PROGRAM_POST_GRADUATE || $studentDetail['Program']['id'] == PROGRAM_PhD )) || (!empty($this->data['HigherEducationBackground']))) { ?>

                                <hr style="margin-top: -10px;">
                                <blockquote>
                                    <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                                    <span style="text-align:justify;" class="fs15 text-black">Information you provide in this page should be properly formated and error free as <b><i class="rejected">it affects official transcript or student copy address contents</i></b>.<br> If you want to add more than one record for the required information, you can use 'Add Additional Row' button and make sure that the information you are entering is chronologically ordered from the most recent to old for higher education you attended.</span>
                                </blockquote>
                                <hr>

                                <?php

                                $higher_fields = array(
                                        'name' => '1',
                                        'field_of_study' => '2',
                                        'diploma_awarded' => '3',
                                        'date_graduated' => '4',
                                        'cgpa_at_graduation' => '5',
                                        'city' => '6'
                                );

                                $higher_all_fields = "";
                                $sepp = "";

                                foreach ($higher_fields as $key => $tag) {
                                    $higher_all_fields .= $sepp . $key;
                                    $sepp = ",";
                                } ?>

                                <div class="row">
                                    <div class="large-12 columns">
                                        <div style="overflow-x:auto;">
                                            <table cellpadding="0" cellspacing="0" class="table">
                                                <thead>
                                                <tr>
                                                    <td colspan="7" style="vertical-align:middle; border-bottom-width: 2px; border-bottom-style: solid; border-bottom-color: rgb(85, 85, 85); line-height: 1.5;"><h6 class="fs18 text-black">Higher Education Attended</h6></td>
                                                </tr>
                                                </thead>
                                            </table>
                                            <table id="higher_education_background" cellpadding="0" cellspacing="0" class="table">
                                                <thead>
                                                <tr>
                                                    <th style="width: 3%;" class="center">#</th>
                                                    <th style="width: 18%;" class="vcenter">Institution/College</th>
                                                    <th style="width: 15%;" class="center">Field of study</th>
                                                    <th style="width: 15%;" class="center">Diploma Awared</th>
                                                    <th style="width: 26%;" class="center">Date Graduated (G.C)</th>
                                                    <th style="width: 8%;" class="center">CGPA</th>
                                                    <th style="width: 15%;" class="center">City</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if (!empty($this->data['HigherEducationBackground'])) {
                                                    $count = 1;
                                                    foreach ($this->data['HigherEducationBackground'] as $bk => $bv) {
                                                        echo $this->Form->hidden('HigherEducationBackground.' . $bk . '.id');
                                                        echo $this->Form->hidden('HigherEducationBackground.' . $bk . '.student_id', array('value' => $studentDetail['Student']['id'])); ?>
                                                        <tr>
                                                            <td class="center"><?= $count; ?></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.name', array( 'label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.field_of_study', array( 'label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.diploma_awarded', array('label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.date_graduated', array( 'label' => false, 'style' => 'width:30%;', 'minYear' =>  (isset($student_admission_year) && !empty($student_admission_year) ? ($student_admission_year - 20) : date('Y') - 30), 'maxYear' => (isset($student_admission_year) && !empty($student_admission_year) ?  $student_admission_year : (date('Y'))))); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.cgpa_at_graduation', array('label' => false, 'placeholder' => 'CGPA', 'type' => 'text', 'onBlur' => 'checkCGPA(this)' /* 'min' => '2.00', 'max' => '4.00', 'step' => '0.01', */)); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.city', array('style' => 'width:100%;', 'label' => false, 'type' => 'text')); ?></div></td>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    }
                                                } else {?>
                                                    <tr>
                                                        <td class="center">1</td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.name', array('label' => false, 'placeholder' => 'Name of the Institution..')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.field_of_study', array('label' => false, 'placeholder' => 'Field of Study..')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.diploma_awarded', array('label' => false, 'placeholder' => 'BSc, MSc, BA, MA..')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.date_graduated', array( 'label' => false, 'style' => 'width:30%;', 'minYear' =>  (isset($student_admission_year) && !empty($student_admission_year) ? ($student_admission_year - 20) : date('Y') - 30), 'maxYear' => (isset($student_admission_year) && !empty($student_admission_year) ?  $student_admission_year : (date('Y'))))); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.cgpa_at_graduation', array('label' => false, 'placeholder' => 'CGPA', 'type' => 'text', 'onBlur' => 'checkCGPA(this)' /* 'min' => '2.00', 'max' => '4.00', 'step' => '0.01', */)); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.city', array( 'style' => 'width:100%;', 'label' => false, 'type' => 'text', 'placeholder' => 'City..')); ?></div></td>
                                                    </tr>
                                                    <?php
                                                    echo $this->Form->hidden('HigherEducationBackground.0.student_id', array('value' => $studentDetail['Student']['id']));
                                                } ?>
                                                </tbody>
                                            </table>

                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <?php
                            }


                            $from = date('Y') - 30;
                            $to = date('Y') - 1;
                            $format = Configure::read('Calendar.yearFormat');
                            $yearoptions = array();

                            for ($j = $to ; $j >= $from; $j--) {
                                $yearoptions[$j] = $j;
                            } ?>

                            <div class="row">

                                <?php

                                if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR ) {

                                    $eslce_fields = array('subject' => '1', 'grade' => '2', 'exam_year' => '3');
                                    $eslce_all_fields = "";
                                    $sepeslce = "";

                                    foreach ($eslce_fields as $key => $tag) {
                                        $eslce_all_fields .= $sepeslce . $key;
                                        $sepeslce = ",";
                                    }  ?>

                                    <?php
                                }

                                if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR ) {

                                    debug( $this->data['EheeceResult']);
                                    ?>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="fs13 warning-box" style="font-weight: normal;">Inputs/fields marked <b class="rejected">*</b> are required and you have to select or provide the required information, not marked fields are optional. Please check all tabs before updating your profile.</h6>
                    <h6 class="fs13 info-box" style="font-weight: normal;">By submitting this form, you certify that all the information provided in this form is accurate and truthful to the best of your knowledge or supporting documents. Any false, misleading, or inaccurate information may be subject to further actions as permitted by the university's legislation or applicable law.</h6>
                    <hr>



                    <?php
                    if($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR){
                        echo $this->Form->end(array(
                                'label' => 'Update Student Detail',
                                'name'  => 'updateStudentDetail',
                                'id'    => 'updateStudentDetail',
                                'class' => 'tiny radius button bg-blue'
                        ));
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php
} ?>


<script type="text/javascript">
    var form_being_submitted = false;
    var ethiopianStudent = <?= json_encode($ethiopianStudent); ?>;
    var faidaMandatory = <?= json_encode($faidaMandatory); ?>;

    function isValidEmail(value) {
        return (/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/).test(value.trim());
    }

    function checkFaidaFan(obj) {
        obj.value = obj.value.replace(/\s+/g, '').replace(/[^0-9]/g, '');
        if (faidaMandatory && obj.value === '') {
            alert('Please enter 16-digit Fayda Alias Number (FAN).');
            obj.focus();
            return false;
        }
        if (obj.value !== '' && obj.value.length !== 16) {
            alert('Fayda FAN must be exactly 16 digits.');
            obj.focus();
            return false;
        }
        return true;
    }

    // ==================== RELIABLE SUBMIT ====================
    $('#updateStudentDetail').on('click', function(e) {
        var $btn = $(this);

        if (form_being_submitted) {
            alert("Updating in progress. Please wait...");
            return false;
        }

        // === Critical validation ===
        if (ethiopianStudent) {
            if ($('#AmharicText').val().trim() === '') {
                alert('Please provide Amharic first name.');
                $('#AmharicText').focus();
                return false;
            }
            if ($('#AmharicTextMiddleName').val().trim() === '') {
                alert('Please provide Amharic middle name.');
                $('#AmharicTextMiddleName').focus();
                return false;
            }
            if ($('#AmharicTextLastName').val().trim() === '') {
                alert('Please provide Amharic last name.');
                $('#AmharicTextLastName').focus();
                return false;
            }
            if (!checkFaidaFan($('#faidaFan')[0])) return false;
        }

        if ($('#email').val().trim() === '') {
            alert('Please provide primary email address.');
            $('#email').focus();
            return false;
        } else if (!isValidEmail($('#email').val())) {
            alert('Please enter a valid email address.');
            $('#email').focus();
            return false;
        }

        if ($('#etPhone').val().trim() === '') {
            alert('Please provide mobile phone number.');
            $('#etPhone').focus();
            return false;
        } else if ($('#etPhone').val().trim().length !== 13) {
            alert('Mobile number must be 13 digits (including +251).');
            $('#etPhone').focus();
            return false;
        }

        // Fayda confirmation
        var faidaFanValue = $('#faidaFan').val().replace(/\s+/g, '').replace(/[^0-9]/g, '');
        if (faidaFanValue !== '' && !confirm('You have provided FAN: ' + faidaFanValue + '\n\nConfirm this is correct? This cannot be easily changed later.')) {
            return false;
        }

        // === SUBMIT THE FORM PROPERLY ===
        form_being_submitted = true;
        $btn.val('Updating Student Profile...').prop('disabled', true);

        // Use jQuery submit with small delay - most reliable in CakePHP 2.10
        setTimeout(function() {
            $('#StudentEditForm').submit();
        }, 100);

        return false;
    });

    // Reset flag
    $(window).on('load', function() {
        form_being_submitted = false;
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>