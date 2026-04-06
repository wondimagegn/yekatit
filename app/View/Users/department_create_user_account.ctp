<?php
$staff_id_passed = false;

// to disable create button;
$staff_email_exists = true;
$staff_mobile_exists = true;
$other_account_exits_for_staff = false;
$error_message = '';

// Check if any additional parameters are present in the URL
if (isset($this->request->params['pass']) && !empty($this->request->params['pass'])) {
	//debug($this->request->params['pass']);
    $staff_id_passed = $this->request->params['pass'][0];
    //debug($staff_id_passed);
} ?>
<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-user-add-outline" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Create User Account for System Access'); ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">
                <div style="margin-top: -30px;"><hr></div>

                <?= $this->Form->create('User'/* , array('data-abide', 'onSubmit' => 'return checkForm(this);') */); ?>
                
                <?php
                if (/* !isset($staff_account_valid) || */ empty($staff_id_passed)) { ?>
                    <blockquote class="fs16">
                        <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                        Staff without existing user account will appear here!
                    </blockquote>
                    <hr>
                    <fieldset>
                        <!-- <legend> <span style="color:gray;">&nbsp; <?php // echo __('Search staff for new account'); ?> &nbsp; </span></legend> -->
                        <div class="row justify-content-md-center" style="margin-top: 15px; margin-bottom: 5px;">
                            <div class="large-2 columns col-lg-2">
                                <p>&nbsp;</p>
                            </div>
                            <div class="large-8 columns col-md-auto">
                                <div class="large-12 columns">
                                    <div class="row collapse postfix-round">
                                        <div class="small-9 columns">
                                            <?= $this->Form->input('Staff.name', array('id' => 'searchNameField', 'style' => "padding: 12px; 12px;", 'type' => "text", 'label' => false, 'placeholder' => 'Search by name or email')); ?></td>
                                        </div>
                                        <div class="small-3 columns">
                                            <?= $this->Form->Submit('Search', array('div' => false, 'class' => 'button postfix', 'name' => 'search', 'id' => 'searchBtn')); ?></td>
                                            <?= $this->Form->hidden('searchBtnClicked', array('id' => 'searchBtnClicked', 'value' => 0)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="large-2 columns col-lg-2">
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </fieldset>
                    <hr>
                    <?php
                } ?>

                <div id="show_search_results">
                <?php
                if (!empty($staffs) /* && !isset($staff_account_valid) */ && empty($staff_id_passed)) { ?>
                    <div class="staffs index mt-3 mb-3">
                        <table cellpadding="0" cellspacing="0" class="table">
                            <thead>
                                <tr>
                                    <td class="center" style="width:5%"> # </td>
                                    <td class="vcenter" style="width:55%"> Full Name </td>
                                    <td class="vcenter" style="width:30%"> Email </td>
                                    <td style="width:10%;" class="center">Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $count = 1;

                                foreach ($staffs as $user) {

                                    $check_existed_users_from_email = -1;

                                    if (isset($user['Staff']['email']) && !empty($user['Staff']['email'])) {
                                        $check_existed_users_from_email = ClassRegistry::init('User')->find('count', array('conditions' => array('User.email' => strtolower(trim($user['Staff']['email'])))));
                                    } ?>

                                    <tr>
                                        <td class="center"><?= $count++; ?></td>
                                        <td class="vcenter" <?= ($check_existed_users_from_email != 0 ? 'style="color:gray; text-decoration: line-through;"' : ''); ?>><?= $user['Title']['title'] . '. ' . $user['Staff']['full_name'] . ' (' . $user['Position']['position'] . ')'; ?></td>
                                        <td class="vcenter" <?= ($check_existed_users_from_email != 0 ? 'style="color:gray; text-decoration: line-through;"' : '');  ?>><?= ($user['Staff']['email'] == "" ? '---' : $user['Staff']['email']); ?></td>
                                        <td class="center">
                                            <?php
                                            if ($check_existed_users_from_email != -1 && !empty($user['Staff']['email'])) {
                                                echo $this->Html->link(__('Create Account'), array('action' => 'department_create_user_account', $user['Staff']['id']));
                                                if ($check_existed_users_from_email > 0) {
                                                    echo '<br/><span class="rejected"> +' . $check_existed_users_from_email . ' more</span>';
                                                }
                                            } else {
                                                if ($check_existed_users_from_email == -1 || empty($user['Staff']['email'])) {
                                                    echo '<span class="rejected">Email is required</span>';
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } ?>
                </div>

                <?php
                if (isset($staff_account_valid) && !empty($staff_id_passed) && isset($staff_basic_data) && !empty($staff_basic_data)) { ?>
                    <br>
                    <div class="mt- col-md-12">
                        <div class="large-8 columns">
                            <table cellpadding="0" cellspacing="0" class="fs13 table">
                                <tbody>
                                    <tr><td colspan="3" class="fs13" style="font-weight:bold">Basic Data</td></tr>
                                    <tr><td style="background-color: white;"><?= $this->element('staff_basic'); ?></td></tr>
                                    <tr>
                                        <td colspan="3">
                                            <br>
                                            <blockquote class="fs13">
                                                <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                                                <!-- You can use the recommened username generated or edit as needed. Please make sure that usernames are short and easly memorizable for the users. -->
                                                You may use the suggested username or modify it as needed. Please ensure usernames are concise, easy to remember, and at least <?= MINIMUM_USERNAME_LENGTH; ?> characters long.
                                            </blockquote>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br> <br>
                        </div>
                        <div class="large-4 columns">
                            <?php //debug( $staff_basic_data['Staff'][0]['id']); ?>
                            <?= $this->Form->hidden('Staff.0.id', array('value' => $staff_basic_data['Staff'][0]['id'])); ?>
                            <?= $this->Form->hidden('Staff.0.phone_mobile', array('value' => $staff_basic_data['Staff'][0]['phone_mobile'])); ?>
                            <?php
                            if (isset($staff_basic_data['Staff'][0]['phone_mobile']) && empty($staff_basic_data['Staff'][0]['phone_mobile'])) {
                                $staff_mobile_exists = false; 
                                $error_message  = 'Mobile phone number is required to create user account.';
                            } 
                            
                            if (isset($staff_basic_data['Staff'][0])) {

                                if(isset($staff_basic_data['Staff'][0]['email']) && !empty($staff_basic_data['Staff'][0]['email'])) {
                                    $staff_email_exists = true;
                                }

                                //debug($staff_basic_data['Staff'][0]);
                                
                                $check_other_account_exits_for_staff = ClassRegistry::init('Staff')->find('first', array(
                                    'conditions' => array(
                                        'Staff.id NOT ' => $staff_basic_data['Staff'][0]['id'],
                                        'Staff.department_id' => $head_department_id,
                                        'Staff.first_name LIKE ' => ((trim($staff_basic_data['Staff'][0]['first_name'])) . '%'),
                                        'Staff.middle_name LIKE ' => ((trim($staff_basic_data['Staff'][0]['middle_name'])) . '%'),
                                        'Staff.last_name LIKE ' => ((trim($staff_basic_data['Staff'][0]['last_name'])) . '%'),
                                        'Staff.user_id IS NOT NULL'
                                    ),
                                    'contain' => array(
                                        'User' => array('id', 'username'),
                                        'Department' => array('id', 'name', 'type')
                                    )
                                ));

                               //debug($check_other_account_exits_for_staff);
                                if (!empty($check_other_account_exits_for_staff)) { 
                                    $other_account_exits_for_staff = true;
                                    $error_message = $check_other_account_exits_for_staff['Staff']['full_name'] . ' have existing user account under ' .  (isset($check_other_account_exits_for_staff['Department']['name']) ? $check_other_account_exits_for_staff['Department']['name'] . ' ' . $check_other_account_exits_for_staff['Department']['type'] : 'your department') . '.';
                                } 
                            } ?>

                            <table cellpadding="0" cellspacing="0" class="table">
                                <tbody>
                                    <tr><td colspan=2 class="fs13" style="font-weight:bold">Access Data</td></tr>
                                    <tr>
                                        <td colspan=2 style="text-align:left"><?= $this->Form->input('User.username', array('style' => 'width:90%;',  'class' => 'radius tiny tooltipster-growing tooltipstered', 'id' => 'username', 'title' => 'Please don\'t change this uniquely generated username unless you have some reason.', 'placeholder' => 'Something Like:' . $recommeded_username . '',  'maxlength' => MAXIMUM_STUDENT_ID_NUMBER_LENGTH_DB, 'value' => (!empty($this->data['User']['username']) ? $this->data['User']['username'] : $recommeded_username))); ?>
                                    </td>
                                    </tr>
                                    <!-- <tr><td colspan=2 style="text-align:left"><?php //echo $this->Form->input('User.passwd', array('label' => 'Password')); ?></td></tr> -->
                                    <tr>
                                        <td colspan=2 style="text-align:left"><?= $this->Form->input('User.role_id', array('empty' => '[ Select Role ]', 'id' => 'RoleID', 'style' => 'width:90%;', 'default' => ROLE_INSTRUCTOR)); ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="large-4 columns" style="margin-top: 50px;">
                                    <?= $this->Form->submit('Create Account', array('name' => 'createAccount', 'disabled' => ((empty($staff_id_passed) || $other_account_exits_for_staff || !$staff_mobile_exists) ? true : false), 'id' => 'SubmitID', 'class' => 'tiny radius button bg-blue', 'div' => 'false')); ?>
                                    <?= $this->Form->hidden('createAccountBtnClicked', array('id' => 'createAccountBtnClicked', 'value' => 0)); ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (!empty($error_message)) { ?>
                            <div class="large-12 columns">
                                <hr>
                                <div class="warning-box warning-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style="margin-right: 15px;"></span><?= $error_message; ?></div>
                            </div>
                            <?php
                        } ?>

                    </div>
                    <?php
                } ?>

                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {

        const USERNAME_REGEX = <?php echo json_encode(trim(USERNAME_REGEX, '/')); ?>;
        const regex = new RegExp(USERNAME_REGEX);

        const userNameInput = $("#username");
        const roleID = $("#RoleID");

        const searchBtn = $("#searchBtn");
        const secondaryBtn = $("#SubmitID");

        const searchNameField = $("#searchNameField");

        const searchBtnClicked = $("#searchBtnClicked");
        const createAccountBtnClicked = $("#createAccountBtnClicked");

        const showSearchResults = $("#show_search_results");

        let isValid = true;
        let form_being_submitted = false;
        
        let searchBtnUsed = false;
        let createAccountBtnUsed = false;

        searchBtn.on("click", function (e) {
            searchBtn.val('Searching...');
            showSearchResults.hide();
            secondaryBtn.prop('disabled', true);
            searchBtnUsed = true;
            searchBtnClicked.val(searchBtnUsed);
            $('form').submit();
        });
        

        searchNameField.on("blur input", function () {
            const val = searchNameField.val().trim().replace(/\s{2,}/g, ' ');
            showSearchResults.hide();
            searchNameField.val(val);
        });

        // Validate username input
        userNameInput.on("blur input", function () {
            const val = userNameInput.val().trim().replace(/\s{2,}/g, ' '); // removes leading and trailing spaces ang collapses any sequence of two or more spaces into a single if ALLOW_SPACE_IN_USERNAME is permitted by in the global system setting.
            isValid = val !== '' && regex.test(val);
            userNameInput.css('border', isValid ? '' : '1px solid red');
            userNameInput.val(val);
            toggleSubmitButtonActive();
        });

        // Validate role selection
        roleID.on("change input", function () {
            toggleSubmitButtonActive();
        });

        function toggleSubmitButtonActive() {

            const staff_mobile_exists = <?php echo json_encode($staff_mobile_exists); ?>;
            const check_other_account_exits_for_staff = <?php echo json_encode($other_account_exits_for_staff); ?>;

            if (!staff_mobile_exists || check_other_account_exits_for_staff) {
                secondaryBtn.prop('disabled', true);
            } else {
                const roleVal = roleID.val();
                const roleIsValid = roleVal !== '' && roleVal !== '0';
                secondaryBtn.prop('disabled', !(roleIsValid && isValid));
            }
        }

        // Initial toggle on page load
        toggleSubmitButtonActive();
        

        // Submit button click handler
        secondaryBtn.on("click", function (e) {
            e.preventDefault();

            const staff_id_passed = <?php echo json_encode($staff_id_passed); ?>;
            isValid = true;

            $('form input[required], form select[required]').each(function () {
                const val = $(this).val().trim();
                if (val === '') {
                    isValid = false;
                    $(this).css('border', '1px solid red').focus();
                    return false;
                } else {
                    $(this).css('border', '');
                }
            });

            if (!isValid || !staff_id_passed) {
                return false;
            }

            if (form_being_submitted) {
                alert("Creating User Account, please wait a moment...");
                secondaryBtn.prop('disabled', true);
                return false;
            }

            form_being_submitted = true;
            secondaryBtn.val('Creating User Account...');
            createAccountBtnUsed = true;

            createAccountBtnClicked.val(createAccountBtnUsed);
            $('form').submit();
            //return true;
        });

        if (createAccountBtnUsed) {
            if (window.history.replaceState) {
                //window.history.replaceState(null, null, window.location.href);
                window.history.replaceState(null, null, '/users/department_create_user_account');
            }
        }
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        //window.history.replaceState(null, null, '/users/department_create_user_account');
    }
    
</script>