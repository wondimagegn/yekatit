<div class="row">
    <div class="large-12 columns">
        <?php

        if (empty($academicCalendars)) {
            ?>
            <div class="box" style="background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.1);">

                <div class="box-header bg-transparent">
                    <div class="box-title" style="margin-top: 10px;"><i class="fontello-check-outline" style="font-size: larger; font-weight: bold;"></i>
                        <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?=  __('The date for online admission is closed.'); ?></span>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="box" style="background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.1);">

                <div class="box-header bg-transparent">
                    <div class="box-title" style="margin-top: 10px;"><i class="fontello-check-outline" style="font-size: larger; font-weight: bold;"></i>
                        <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?=  __('Online  Application Form'); ?></span>
                    </div>
                </div>

                <!-- Beautiful Numbered Tabs -->
                <dl class="tabs contained" data-tab style="background:#f8f8f8; margin:0; padding:10px 0; border-bottom:3px solid #1779ba;">
                    <dd class="active"><a href="#tab1"><span class="tab-number">1</span> Admission Choice</a></dd>
                    <dd class="disabledTab"><a href="#tab2"><span class="tab-number">2</span> Personal Info</a></dd>
                    <dd class="disabledTab"><a href="#tab3"><span class="tab-number">3</span> Address and Emergency</a></dd>
                    <dd class="disabledTab"><a href="#tab4"><span class="tab-number">4</span> Previous Education</a></dd>
                    <dd class="disabledTab"><a href="#tab5"><span class="tab-number">5</span> Photo and Document</a></dd>
                    <dd class="disabledTab"><a href="#tab6"><span class="tab-number">6</span> Submission</a></dd>
                </dl>

                <!-- FORM STARTS HERE -->
                <?= $this->Form->create('Page', [
                        'controller' => 'pages',
                        'action' => 'admission',
                        'id' => 'MyForm',
                        'type' => 'file',
                        'enctype' => 'multipart/form-data',
                        'class' => 'custom'
                ]); ?>



                <div class="tabs-content" style="padding:30px 40px; min-height:500px; background:#fff;">

                    <!-- TAB 1 -->
                    <div class="content active" id="tab1">
                        <fieldset style="border:1px solid #ddd; padding:20px; border-radius:6px;">
                            <legend style="background:#1779ba; color:white; padding:8px 15px; border-radius:4px;">1. Admission Choice</legend>
                            <div class="row">
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.campus_id', [

                                            'empty' => '-- Select Campus --',
                                            'id' => 'campus_id' ,  // ← This must be "campus_id"
                                            'label' => 'Campus <span class="required">*</span>',
                                            'class' => 'radius'
                                    ]); ?>
                                </div>
                                <div class="large-6 columns">

                                    <label>Field of Study <span class="required">*</span></label>
                                    <select name="data[OnlineApplicant][department_id]" id="department_id" class="radius" required <?= empty($this->request->data['OnlineApplicant']['department_id']) ? 'disabled' : '' ?>>
                                        <?php if (!empty($this->request->data['OnlineApplicant']['department_id'])): ?>
                                            <option value="<?= h($this->request->data['OnlineApplicant']['department_id']) ?>">
                                                <?= h($departments[$this->request->data['OnlineApplicant']['department_id']]) ?>
                                            </option>
                                        <?php else: ?>
                                            <option>-- Select Campus First --</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                            </div>
                            <!-- ... other fields same as before ... -->
                            <div class="row">
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.academic_year', ['options' => $acyeardatas,
                                            'label' => 'Academic Year <span class="required">*</span>',
                                            'class' => 'radius']); ?>
                                </div>
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.semester', ['options' => $semester,
                                            'label' => 'Semester <span class="required">*</span>', 'class' => 'radius']); ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.program_type_id', ['options' => $programTypes, 'label' => 'Admission Type <span class="required">*</span>', 'class' => 'radius']); ?>
                                </div>
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.program_id', ['options' => $programs,
                                            'label' => 'Study  level <span class="required">*</span>', 'class' => 'radius']); ?>
                                </div>



                            </div>
                        </fieldset>
                        <button type="button" class="button radius success btnNext right" style="margin-top:20px;">Next</button>
                    </div>

                    <!-- TAB 2 -->
                    <div class="content" id="tab2">
                        <fieldset style="border:1px solid #ddd; padding:20px; border-radius:6px;">
                            <legend style="background:#1779ba; color:white; padding:8px 15px; border-radius:4px;">2. Personal Information</legend>
                            <div class="row">
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.first_name', ['label'=>'First Name <span class="required">*</span>', 'class'=>'radius']); ?></div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.father_name', ['label'=>'Father Name <span class="required">*</span>', 'class'=>'radius']); ?></div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.grand_father_name', ['label'=>'Grandfather Name <span class="required">*</span>', 'class'=>'radius']); ?></div>
                            </div>
                            <div class="row">
                                <div class="large-4 columns">
                                    <?=$this->Form->input(
                                            'OnlineApplicant.amharic_fullname',
                                            array(
                                                    'id' => 'AmharicFullName',
                                                    'label' => 'ሙሉ ስም ከነአያት/በአማርኛ/Amharic Full Name ',
                                                    'onkeypress' => "return AmharicPhoneticKeyPress(event,this);"
                                            )
                                    ); ?>
                                </div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.date_of_birth',
                                            ['type'=>'date', 'label'=>'Date of Birth <span class="required">*</span>',
                                                    'minYear' => 1950,
                                                    'maxYear' => date('Y') - 15,  // Example: must be at least 15 years old
                                                    'class'=>'radius'
                                            ]); ?></div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.gender', ['options'=>['Male'=>'Male','Female'=>'Female'], 'empty'=>'-- Select --', 'label'=>'Gender <span class="required">*</span>', 'class'=>'radius']); ?></div>
                            </div>
                            <div class="row">
                                <div class="large-4 columns">
                                    <?=$this->Form->input('OnlineApplicant.nationality', array('id' => 'Nationality',
                                            'label' => 'Nationality <span class="required">*</span>',
                                            'empty' => '--Select Nationality --',
                                            'options' => array('Ethiopian' => 'Ethiopian', 'Non Ethiopian' => 'Non Ethiopian'))); ?>
                                </div>
                                <div class="large-4 columns">
                                    <?=$this->Form->input('OnlineApplicant.place_of_birth', array('id' => 'PlaceOfBirth', 'label' => 'Place of Birth',)); ?>
                                </div>

                                <div class="large-4 columns">
                                    <?=$this->Form->input('OnlineApplicant.marital_status', array('id' => 'MaritalStatus',
                                            'label' => 'Marital Status',
                                            'empty' => '--Select Marital Status--',
                                            'options' => array('Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed')
                                    )); ?>
                                </div>


                            </div>
                            <div class="row">
                                <div class="large-4 columns">
                                    <?= $this->Form->input('OnlineApplicant.mother_fullname',
                                            [ 'label'=>'Mother Fullname', 'class'=>'radius'

                                            ]); ?>
                                </div>
                                <div class="large-4 columns">
                                    <?= $this->Form->input('OnlineApplicant.come_from', [
                                            'label'=>'Where you come from', 'class'=>'radius',
                                            'type' => 'select',
                                            'empty' => '--Select--',
                                            'options' => array('Rural' => 'Rural', 'Urban' => 'Urban')
                                    ]); ?></div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.area_type',
                                            [ 'label'=>'Area Type', 'class'=>'radius',
                                                    'empty' => '--Select Area Type--',
                                                    'options' => array('Pastoral' => 'Pastoral', 'Non Pastoral' => 'Non Pastoral')
                                            ]); ?>
                                </div>

                            </div>
                            <div class="row">
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.disability',
                                            [
                                                    'type' => 'select',
                                                    'multiple' => 'checkbox',
                                                    'options' => array('Seeing' => 'Seeing', 'Hearing' => 'Hearing',
                                                            'Speaking' => 'Speaking', 'Physically Challenged' => 'Physically Challenged',
                                                            'Mentally Challenged'),
                                                    'label'=>'Disability ', 'class'=>'radius']); ?></div>
                            </div>


                        </fieldset>
                        <button type="button" class="button radius btnPrevious">Previous</button>
                        <button type="button" class="button radius success btnNext right">Next</button>
                    </div>

                    <!-- TAB 3 to TAB 6 (same structure - keep your fields inside each .content) -->
                    <!-- ... keep exactly as in previous message ... -->

                    <div class="content" id="tab3">
                        <fieldset style="border:1px solid #ddd; padding:20px; border-radius:6px;">
                            <legend style="background:#1779ba; color:white; padding:8px 15px; border-radius:4px;">3. Address and Emergency</legend>


                            <div class="row">
                                <div class="large-4 columns">
                                    <?=$this->Form->input(
                                            'OnlineApplicant.email',
                                            array(
                                                    'id' => 'Email',
                                                    'label' => 'Your email  <span class="required">*</span>'
                                            )
                                    ); ?>
                                </div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.mobile_phone',
                                            [ 'type' => 'tel', 'id'=>'etPhone',
                                                    'label'=>'Your   Phone <span class="required">*</span>', 'class'=>'radius phone-et']); ?></div>

                                <div class="large-4 columns"></div>

                            </div>

                            <div class="row">
                                <div class="large-4 columns">
                                    <?=$this->Form->input(
                                            'OnlineApplicant.emergency_contact_name',
                                            array(
                                                    'id' => 'EmergencyContactName',
                                                    'label' => 'Emergency Contact Name  <span class="required">*</span>'
                                            )
                                    ); ?>
                                </div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.emergency_contact_relation',
                                            ['label'=>'Emergency contact relation <span class="required">*</span>', 'class'=>'radius']); ?></div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.emergency_contact_address',
                                            [ 'type' => 'tel', 'id'=>'etMobilePhone',
                                                    'label'=>'Emergency Contact  Phone <span class="required">*</span>', 'class'=>'radius phone-et']); ?></div>
                            </div>

                            <div class="row">
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.country_id',
                                            ['label'=>'Country <span class="required">*</span>','id'=>'country_id',
                                                    'default' => COUNTRY_ID_OF_ETHIOPIA, 'class'=>'radius']); ?></div>
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.region_id',
                                            ['label'=>'Region <span class="required">*</span>',
                                                    'options' => $regionsAll,'empty' => '[ Select Region ]','id'=>'region_id', 'class'=>'radius']); ?></div>

                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.zone_id',
                                            ['label'=>'Zone <span class="required">*</span>',
                                                    'options' => $zonesAll,
                                                    'empty' => '[ Select Zone ]',
                                                    'id'=>'zone_id', 'class'=>'radius']); ?></div>
                            </div>
                            <div class="row">
                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.woreda_id',
                                            ['label'=>'Woreda <span class="required">*</span>','id'=>'woreda_id',
                                                    'options' => $woredasAll,
                                                    'empty' => '[ Select Woreda ]',
                                                    'class'=>'radius']); ?></div>

                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.city_id',
                                            ['label'=>'City <span class="required">*</span>','id'=>'city_id',
                                                    'options' => $citiesAll,
                                                    'empty' => '[ Select City or Leave, if not listed ]',
                                                    'class'=>'radius']); ?></div>

                                <div class="large-4 columns"><?= $this->Form->input('OnlineApplicant.house_number', ['label'=>'House Number <span class="required">*</span>', 'class'=>'radius']); ?></div>
                            </div>
                        </fieldset>
                        <button type="button" class="button radius btnPrevious">Previous</button>
                        <button type="button" class="button radius success btnNext right">Next</button>
                    </div>

                    <div class="content" id="tab4">
                        <fieldset style="border:1px solid #ddd; padding:25px; border-radius:8px;">
                            <legend style="background:#1779ba; color:white; padding:10px 20px; border-radius:6px; font-size:1.4em;">
                                4.  Education Background
                            </legend>
                            <div style="overflow-x:auto;">
                                <hr style="margin-top: -10px;">
                                <blockquote>
                                    <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                                    <span style="text-align:justify;" class="fs15 text-black">Please also make sure that school name doesn't exceed more than 30
                                    characters and replace spacial characters like - , ( , ) by a space if any found in school name.
                                    <br> If you want to add more than one record for the required information,
                                    you can use 'Add Additional School' or 'Add Additional Subject' buttons and make sure
                                    that the information you are entering is chronologically ordered from the most recent to old for
                                    highschool background information.</span>
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
                                                        ?>
                                                        <tr>
                                                            <td class="center"><?= $count; ?></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.school_level', array('class' => "otherRequiredText-input", 'label' => false, 'style' => 'width:100%;', 'required', 'placeholder' => 'preparatory, highschool etc..', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.name', array('class' => "otherRequiredText-input", 'label' => false, 'style' => 'width:100%;', 'required', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.national_exam_taken', array('label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.region_id', array('options' => $regionsAll, 'style' => 'width:100%;', 'type' => 'select', 'label' => false, 'required')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.zone', array('class' => "otherRequiredText-input", 'label' => false, 'type' => 'text', 'style' => 'width:100%;', 'required', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.' . $bk . '.town', array('class' => "otherRequiredText-input", 'label' => false, 'style' => 'width:100%;', 'required', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    }
                                                } else {

                                                    ?>
                                                    <tr>
                                                        <td class="center">1</td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.school_level', array('class' => "otherRequiredText-input", 'label' => false, 'placeholder' => 'preparatory, highschool etc..', 'style' => 'width:100%;', 'onBlur' => 'checkIsAlpha(this)', 'required')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.name', array('class' => "otherRequiredText-input", 'label' => false, 'style' => 'width:100%;', 'required', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.national_exam_taken', array('label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.region_id', array('options' => $regionsAll, 'type' => 'select',  'style' => 'width:100%;', 'label' => false, 'empty' => '[ Select Region ]')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.zone', array('class' => "otherRequiredText-input", 'label' => false, 'type' => 'text', 'required', 'onBlur' => 'checkIsAlpha(this)', 'style' => 'width:100%;')); ?></div></td>
                                                        <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HighSchoolEducationBackground.0.town', array('class' => "otherRequiredText-input", 'label' => false, 'style' => 'width:100%;', 'required', 'onBlur' => 'checkIsAlpha(this)')); ?></div></td>
                                                    </tr>
                                                    <?php
                                                } ?>
                                                </tbody>
                                            </table>

                                            <table cellpadding="0" cellspacing="0" class="table">
                                                <tr>
                                                    <td colspan=7>
                                                        <div style="padding-top: 10px;padding-bottom: 10px;">
                                                            <input type="button" value="Add Additional School" onclick="addRow('high_school_education','HighSchoolEducationBackground',6,'<?= $all_fields; ?>')" /> &nbsp;  &nbsp;  &nbsp;
                                                            <input type="button" value="Delete Last School" onclick="deleteRow('high_school_education')" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>

                            <div style="overflow-x:auto;">

                                <hr style="margin-top: -10px;">
                                <blockquote>
                                    <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                                    <span style="text-align:justify;" class="fs15 text-black">
                                    If you want to add more than one record for the required information,
                                    you can use 'Add Additional Row' button and make sure that the information you are
                                    entering is chronologically ordered from the most recent to old for higher education you attended.</span>
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
                                            ?>
                                            <tr>
                                                <td class="center"><?= $count; ?></td>
                                                <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.name', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.field_of_study', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.diploma_awarded', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'label' => false, 'style' => 'width:100%;')); ?></div></td>
                                                <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.date_graduated', array('required',
                                                                'label' => false, 'style' => 'width:30%;', 'minYear' =>  date('Y'))); ?></div></td>
                                                <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.cgpa_at_graduation', array('class' => "cgpa-input", 'required', 'label' => false, 'placeholder' => 'CGPA', 'type' => 'text', 'onBlur' => 'checkCGPA(this)' )); ?></div></td>
                                                <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.' . $bk . '.city', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'style' => 'width:100%;', 'label' => false, 'type' => 'text')); ?></div></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                    } else {?>
                                        <tr>
                                            <td class="center">1</td>
                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.name', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'label' => false, 'placeholder' => 'Name of the Institution..')); ?></div></td>
                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.field_of_study', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'label' => false, 'placeholder' => 'Field of Study..')); ?></div></td>
                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.diploma_awarded', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'label' => false, 'placeholder' => 'BSc, MSc, BA, MA..')); ?></div></td>
                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.date_graduated', array('required', 'label' => false, 'style' => 'width:30%;', 'minYear' =>  ( date('Y') - 30), 'maxYear' => (date('Y')))); ?></div></td>
                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.cgpa_at_graduation', array('class' => "cgpa-input", 'required', 'label' => false, 'placeholder' => 'CGPA', 'type' => 'text', 'onBlur' => 'checkCGPA(this)')); ?></div></td>
                                            <td class="center"><div style="margin-top: 10px;"><?= $this->Form->input('HigherEducationBackground.0.city', array('class' => "otherRequiredText-input", 'required', 'onBlur' => 'checkIsAlpha(this)', 'style' => 'width:100%;', 'label' => false, 'type' => 'text', 'placeholder' => 'City..')); ?></div></td>
                                        </tr>
                                        <?php
                                    } ?>
                                    </tbody>
                                </table>
                                <table cellpadding="0" cellspacing="0" class="table">
                                    <tr>
                                        <td colspan=7>
                                            <div style="padding-top: 10px;padding-bottom: 10px;">
                                                <input type="button" value="Add Additional Row" onclick="addRow('higher_education_background','HigherEducationBackground',6,'<?= $higher_all_fields; ?>')" />  &nbsp;  &nbsp;  &nbsp;
                                                <input type="button" value="Delete Last Row" onclick="deleteRow('higher_education_background')" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </fieldset>

                        <button type="button" class="button radius btnPrevious">Previous</button>
                        <button type="button" class="button radius success btnNext right">Next</button>
                    </div>

                    <!-- ===================== TAB 4: Photo & Combined PDF Upload ===================== -->
                    <div class="content" id="tab5">
                        <fieldset style="border:2px solid #1779ba; padding:30px; border-radius:12px; background:#f8fdff;">
                            <legend style="background:#1779ba; color:white; padding:12px 25px; border-radius:8px; font-size:1.5em; font-weight:bold;">
                                4. Profile & Documents (Combined PDF)
                            </legend>

                            <div class="row">
                                <!-- LEFT: Photo Upload -->
                                <div class="large-6 medium-6 small-12 columns" style="padding:15px;">
                                    <div class="callout" style="border:2px dashed #1779ba; border-radius:10px; padding:20px; text-align:center; height:100%; background:#fff;">
                                        <h5 style="color:#1779ba; margin-bottom:15px;">
                                            Passport-Size Photo <span class="required">*</span>
                                        </h5>
                                        <p style="font-size:0.9em; color:#555;">
                                            Recent color photo • White background • Max 2MB • JPG/PNG
                                        </p>

                                        <div style="margin:20px 0;">
                                            <img id="photoPreview"
                                                 src="/img/no-photo.png"
                                                 alt="Your Photo"
                                                 style="width:180px; height:220px; object-fit:cover; border:3px solid #ddd; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                                            <p id="photoStatus" style="margin-top:10px; color:#888; font-style:italic;">No photo selected</p>
                                        </div>

                                        <?= $this->Form->input('Attachment.1.file', [
                                                'id' => 'ApplicationFormProfile',
                                                'type' => 'file',
                                                'style' => 'display:none;',
                                                'accept' => 'image/jpeg,image/png',
                                                'required' => true,
                                                'error' => array(
                                                        'error' => __d('media', 'An error occurred while transferring the file.'),
                                                        'resource' => __d('media', 'The file is invalid.'),
                                                        'access' => __d('media', 'The file cannot be processed.'),
                                                        'location' => __d('media', 'The file cannot be transferred from or to location.'),
                                                        'permission' => __d('media', 'Executable files cannot be uploaded.'),
                                                        'size' => __d('media', 'The file is too large.'),
                                                        'pixels' => __d('media', 'The file resolution is too large, adjust it .'),
                                                        'extension' => __d('media', 'The file has the wrong extension.'),
                                                        'mimeType' => __d('media', 'The file has the wrong MIME type.'),
                                                )
                                        ]); ?>

                                        <button type="button" id="photoBtn" class="button radius" style="background:#1779ba; padding:12px 30px;">
                                            Choose Photo
                                        </button>
                                        <div id="photoError" style="color:#e74c3c; margin-top:10px; font-weight:bold; display:none;"></div>
                                    </div>
                                </div>

                                <!-- RIGHT: Combined PDF Upload -->
                                <div class="large-6 medium-6 small-12 columns" style="padding:15px;">
                                    <div class="callout" style="border:2px dashed #e67e22; border-radius:10px; padding:20px; text-align:center; height:100%; background:#fff;">
                                        <h5 style="color:#e67e22; margin-bottom:15px;">
                                            Combined PDF Document <span class="required">*</span>
                                        </h5>
                                        <p style="font-size:0.9em; color:#555;">
                                            All certificates, transcripts, ID, COC, etc. in <strong>ONE PDF</strong><br>
                                            Maximum file size: 10MB
                                        </p>

                                        <div style="margin:20px 0;">
                                            <div id="pdfPreview" style="padding:20px; background:#fff; border:3px dashed #ccc; border-radius:10px; min-height:150px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                                                <i class="fa fa-file-pdf-o" style="font-size:70px; color:#ccc;"></i>
                                                <p style="margin:10px 0 0; color:#888; font-style:italic;">No file selected</p>
                                            </div>
                                        </div>

                                        <?= $this->Form->input('Attachment.0.file', [
                                                'id' => 'ApplicationFormAttachment',
                                                'type' => 'file',
                                                'style' => 'display:none;',
                                                'accept' => 'application/pdf',

                                                'required' => true,
                                                'error' => array(
                                                        'error' => __d('media', 'An error occurred while transferring the file.'),
                                                        'resource' => __d('media', 'The file is invalid.'),
                                                        'access' => __d('media', 'The file cannot be processed.'),
                                                        'location' => __d('media', 'The file cannot be transferred from or to location.'),
                                                        'permission' => __d('media', 'Executable files cannot be uploaded.'),
                                                        'size' => __d('media', 'The file is too large.'),
                                                        'pixels' => __d('media', 'The file resolution is too large, adjust it .'),
                                                        'extension' => __d('media', 'The file has the wrong extension.'),
                                                        'mimeType' => __d('media', 'The file has the wrong MIME type.'),
                                                )
                                        ]); ?>

                                        <button type="button" id="pdfBtn" class="button radius" style="background:#e67e22; padding:12px 30px;">
                                            Select PDF File
                                        </button>
                                        <div id="pdfInfo" style="margin-top:10px; color:#27ae60; font-weight:bold; display:none;"></div>
                                        <div id="pdfError" style="color:#e74c3c; margin-top:10px; font-weight:bold; display:none;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Final Buttons -->
                            <div class="row" style="margin-top:30px;">
                                <div class="large-6 columns">
                                    <button type="button" class="button radius large btnPrevious" style="padding:15px 30px;">
                                        Previous
                                    </button>
                                </div>
                                <div class="large-6 columns text-right">
                                    <button type="button" class="button success radius large btnNext" style="padding:15px 40px; font-size:1.2em;">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!-- ===================== TAB 5: Final Submission & Declaration ===================== -->
                    <div class="content" id="tab6">
                        <fieldset style="border:2px solid #1779ba; padding:35px; border-radius:14px; background: linear-gradient(to bottom, #f8fdff, #ffffff); box-shadow: 0 8px 25px rgba(0,0,0,0.08);">
                            <legend style="background:#1779ba; color:white; padding:14px 30px; border-radius:10px; font-size:1.6em; font-weight:bold; letter-spacing:0.5px;">
                                Final Review & Submission
                            </legend>

                            <!-- Financial Support & Experience -->
                            <div class="row" style="margin-bottom:30px;">
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.financial_support', [
                                            'options' => $student_payment_types,
                                            'empty' => '-- Select Financial Support --',
                                            'label' => 'Financial Support <span class="required">*</span>',
                                            'class' => 'radius',
                                            'style' => 'height:48px; font-size:1.1em;'
                                    ]); ?>
                                </div>
                                <div class="large-6 columns">
                                    <?= $this->Form->input('OnlineApplicant.year_of_experience', [
                                            'type' => 'number',
                                            'min' => 0,
                                            'placeholder' => 'e.g., 0',
                                            'label' => 'Years of Work Experience',
                                            'class' => 'radius',
                                            'style' => 'height:48px; font-size:1.1em;'
                                    ]); ?>
                                </div>
                            </div>

                            <!-- Toggle Questions -->
                            <div class="row">
                                <!-- Research Experience -->
                                <div class="large-6 columns" style="margin-bottom:25px;">
                                    <label style="font-weight:bold; color:#2c3e50; font-size:1.1em;">
                                        Do you have research experience?
                                    </label>
                                    <div style="display:flex; align-items:center; gap:30px; margin-top:12px;">
                                        <label class="switch">
                                            <?= $this->Form->checkbox('OnlineApplicant.research_experience', ['hiddenField' => false, 'id' => 'research_exp_toggle']); ?>
                                            <span class="slider round"></span>
                                        </label>
                                        <span style="font-size:1.2em; color:#34495e;">
                        <span id="researchLabel">No</span>
                    </span>
                                    </div>
                                </div>

                                <!-- Research Published -->
                                <div class="large-6 columns" style="margin-bottom:25px;">
                                    <label style="font-weight:bold; color:#2c3e50; font-size:1.1em;">
                                        Were your research outputs published?
                                    </label>
                                    <div style="display:flex; align-items:center; gap:30px; margin-top:12px;">
                                        <label class="switch">
                                            <input type="checkbox" id="research_published_toggle">
                                            <span class="slider round"></span>
                                        </label>
                                        <span style="font-size:1.2em; color:#34495e;">
                        <span id="publishedLabel">No</span>
                    </span>
                                    </div>
                                    <div id="research_output_div" style="display:none; margin-top:20px; padding:15px; background:#f0f8ff; border-radius:8px; border-left:4px solid #1779ba;">
                                        <?= $this->Form->input('OnlineApplicant.research_output', [
                                                'type' => 'textarea',
                                                'rows' => 4,
                                                'label' => 'Publication Details (Journal, Year, Title, etc.)',
                                                'class' => 'radius',
                                                'placeholder' => 'e.g., Published in Journal of Science, 2023...'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Awards -->
                                <div class="large-12 columns">
                                    <label style="font-weight:bold; color:#2c3e50; font-size:1.1em;">
                                        Have you received any awards or commendations?
                                    </label>
                                    <div style="display:flex; align-items:center; gap:30px; margin-top:12px;">
                                        <label class="switch">
                                            <input type="checkbox" id="award_toggle">
                                            <span class="slider round"></span>
                                        </label>
                                        <span style="font-size:1.2em; color:#34495e;">
                        <span id="awardLabel">No</span>
                    </span>
                                    </div>
                                    <div id="award_div" style="display:none; margin-top:20px; padding:15px; background:#f0f8ff; border-radius:8px; border-left:4px solid #1779ba;">
                                        <?= $this->Form->input('OnlineApplicant.award', [
                                                'type' => 'textarea',
                                                'rows' => 4,
                                                'label' => 'Describe the Award(s)',
                                                'class' => 'radius',
                                                'placeholder' => 'e.g., Best Researcher Award, 2024...'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Final Declaration -->
                            <div class="row" style="margin-top:40px;">
                                <div class="large-12 columns">
                                    <div class="callout" style="background:#fff8f0; border:2px solid #f39c12; border-radius:12px; padding:25px; text-align:center;">
                                        <h4 style="color:#e67e22; margin-bottom:15px;">
                                            Final Declaration
                                        </h4>
                                        <label style="font-size:1.2em; line-height:1.8; display:block;">
                                            <input type="checkbox" name="data[OnlineApplicant][declaration]" required style="transform:scale(1.8); margin-right:15px; accent-color:#e67e22;">
                                            <strong>I hereby declare</strong> that all information provided in this application is true, accurate, and complete to the best of my knowledge.<br>
                                            I have read and agree to the
                                            <a href="/files/template/terms.html" target="_blank" style="color:#1779ba; font-weight:bold; text-decoration:underline;">
                                                Terms and Conditions
                                            </a> of the university.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div style="text-align:center; margin-top:40px;">
                                <?= $this->Form->button('Submit Application', [
                                        'type' => 'submit',
                                        'class' => 'button success large radius',
                                        'style' => 'padding:20px 80px; font-size:1.6em; font-weight:bold; box-shadow:0 6px 20px rgba(39,174,96,0.4);'
                                ]); ?>
                            </div>
                        </fieldset>


                        <button type="button" class="button radius btnPrevious">Previous</button>

                    </div>

                </div> <!-- END .tabs-content -->

                <?= $this->Form->end(); ?> <!-- CLOSE FORM HERE -->
            </div>
            <?php
        }
        ?>
    </div>
</div>

<!-- CSS & JS (same as before) -->
<style>
    /* ... same beautiful styles from previous message ... */
    .tabs.contained dd { margin: 0 5px; }
    .tabs dd > a { padding: 12px 18px !important; background: #e0e0e0; color: #555; border-radius: 30px; font-weight: bold; transition: all 0.3s; }
    .tabs dd.active > a, .tabs dd > a:hover { background: #1779ba; color: white; }
    .tabs dd.disabledTab > a { background: #f0f0f0; color: #aaa; cursor: not-allowed; }
    .tab-number { display: inline-block; width: 28px; height: 28px; background: white; color: #1779ba; border-radius: 50%; margin-right: 10px; font-weight: bold; line-height: 28px; font-size: 14px; }
    .tabs dd.active .tab-number { background: white; color: #1779ba; }
    .required { color: red; }
</style>

<script>

    // ──────────────────────────────────────────────────────
    // 1. AJAX: Load Departments based on Campus + Calendar Rules
    // ──────────────────────────────────────────────────────

    let selectedDepartment = <?= json_encode(!empty($this->request->data['OnlineApplicant']['department_id']) ?
            $this->request->data['OnlineApplicant']['department_id']:'') ?>;
    $('#campus_id').on('change', function() {
        const campusId = $(this).val();
        const $dept = $('#department_id');

        if (!campusId) {
            $dept.html('<option>-- Select Campus First --</option>').prop('disabled', true);
            return;
        }

        $.post('/pages/get_department_combo', $('form').serialize(), function(html) {
            $dept.html(html).prop('disabled', false);

            // Restore previously selected department if available
            if (selectedDepartment && $dept.find('option[value="' + selectedDepartment + '"]').length) {
                $dept.val(selectedDepartment);
            }
        }).fail(() => {
            $dept.html('<option>Error loading departments</option>').prop('disabled', true);
        });
    });


    // ──────────────────────────────────────────────────────
    // 2. Trigger reload when other filters change (optional but recommended)
    // ──────────────────────────────────────────────────────
    $('#program_type_id, #academic_year, #semester').on('change', function () {
        if ($('#campus_id').val()) {
            $('#campus_id').trigger('change'); // Re-fetch departments with new filters
        }
    });

    // ──────────────────────────────────────────────────────
    // 3. Photo Preview
    // ──────────────────────────────────────────────────────
    $('#profile_photo').on('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#photoPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ──────────────────────────────────────────────────────
    // 4. Wizard Navigation + Validation
    // ──────────────────────────────────────────────────────
    $('.btnNext').on('click', function () {
        var $current = $('.tabs-content > .content.active');
        var valid = true;

        $current.find('[required]').each(function () {
            if (!this.value || this.value === '' || (this.type === 'select-one' && !this.value)) {
                alert('Please complete all required fields.');
                this.focus();
                valid = false;
                return false;
            }
        });

        if (!valid) return;

        // Special validation: Department must be selected
        if ($current.is('#tab1') && (!$('#department_id').val() || $('#department_id').is(':disabled'))) {
            alert('Please select a valid Department from the list.');
            $('#campus_id').focus();
            return;
        }

        // Activate next tab
        var $next = $('.tabs dd.disabledTab').first();
        if ($next.length) {
            $next.removeClass('disabledTab').find('a').trigger('click');
        }
    });

    $('.btnPrevious').on('click', function () {
        var $prev = $('.tabs dd.active').prev('dd');
        if ($prev.length) $prev.find('a').trigger('click');
    });

    // Optional: Auto-load departments if campus already selected (e.g., edit mode)
    $(document).ready(function () {
        if ($('#campus_id').val()) {
            $('#campus_id').trigger('change');
        }

        if ($('#country_id').val()) {
            $('#country_id').trigger('change');
        }

    });

</script>

<script>
    // PHOTO + PDF UPLOAD WITH FULL VALIDATION & PREVIEW
    $(function () {
        const $photoInput = $('#ApplicationFormProfile');
        const $photoPreview = $('#photoPreview');
        const $photoStatus = $('#photoStatus');
        const $photoBtn = $('#photoBtn');
        const $photoError = $('#photoError');

        const $pdfInput = $('#ApplicationFormAttachment');
        const $pdfPreview = $('#pdfPreview');
        const $pdfInfo = $('#pdfInfo');
        const $pdfError = $('#pdfError');
        const $pdfBtn = $('#pdfBtn');

        // === PHOTO UPLOAD ===
        $photoBtn.on('click', () => $photoInput.trigger('click'));

        $photoInput.on('change', function () {
            const file = this.files[0];
            $photoError.hide();

            if (!file) { resetPhoto(); return; }

            if (!file.type.match(/^image\/(jpeg|png)$/i)) {
                showPhotoError('Only JPG or PNG allowed');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                showPhotoError('Photo too large (max 2MB)');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                $photoPreview.attr('src', e.target.result);
                $photoStatus.html('<span style="color:#27ae60;">Ready!</span>');
                $photoBtn.text('Change Photo').addClass('success');
            };
            reader.readAsDataURL(file);
        });

        function showPhotoError(msg) {
            $photoError.html(msg).show();
            resetPhoto();
        }

        function resetPhoto() {
            $photoPreview.attr('src', '/img/no-photo.png');
            $photoStatus.text('No photo selected');
            $photoBtn.text('Choose Photo').removeClass('success');
        }

        // === PDF UPLOAD ===
        $pdfBtn.on('click', () => $pdfInput.trigger('click'));

        $pdfInput.on('change', function () {
            const file = this.files[0];
            $pdfError.hide();
            $pdfInfo.hide();

            if (!file) { resetPdf(); return; }

            if (file.type !== 'application/pdf') {
                showPdfError('Only PDF files allowed');
                this.value = '';
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                showPdfError('PDF too large (max 10MB)');
                this.value = '';
                return;
            }

            const size = (file.size / 1024 / 1024).toFixed(2);
            $pdfPreview.html(`
            <i class="fa fa-file-pdf-o" style="font-size:70px; color:#e67e22;"></i>
            <p style="margin:10px 0 0; color:#27ae60; font-weight:bold;">
                ${file.name}<br>
                <small style="color:#555;">${size} MB</small>
            </p>
        `);
            $pdfInfo.html('Ready to submit!').show();
            $pdfBtn.text('Change PDF').addClass('success');
        });

        function showPdfError(msg) {
            $pdfError.html(msg).show();
            resetPdf();
        }

        function resetPdf() {
            $pdfPreview.html(`
            <i class="fa fa-file-pdf-o" style="font-size:70px; color:#ccc;"></i>
            <p style="margin:10px 0 0; color:#888; font-style:italic;">No file selected</p>
        `);
            $pdfBtn.text('Select PDF File').removeClass('success');
        }

    });
</script>


<style>
    /* Modern Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 70px;
        height: 38px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 30px;
        width: 30px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #27ae60;
    }
    input:checked + .slider:before {
        transform: translateX(32px);
    }
    .slider.round { border-radius: 34px; }
    .slider.round:before { border-radius: 50%; }
</style>

<script>
    // Toggle Switches with Labels
    $(function () {
        // Research Experience
        $('#research_exp_toggle').on('change', function () {
            $('#researchLabel').text(this.checked ? 'Yes' : 'No');
        });

        // Research Published
        $('#research_published_toggle').on('change', function () {
            $('#publishedLabel').text(this.checked ? 'Yes' : 'No');
            $('#research_output_div').slideToggle(this.checked);
        });

        // Awards
        $('#award_toggle').on('change', function () {
            $('#awardLabel').text(this.checked ? 'Yes' : 'No');
            $('#award_div').slideToggle(this.checked);
        });


        // Final submit validation
        $('form').on('submit', function (e) {
            if (!$('input[name="data[OnlineApplicant][declaration]"]').is(':checked')) {
                alert('You must agree to the declaration before submitting.');
                e.preventDefault();
                return false;
            }
            // Optional: Show loading
            $('button[type="submit"]').html('Submitting...').prop('disabled', true);
        });
    });

</script>

<script>
    // Global state from CakePHP (preserves values after submit)
    const preserved = {
        country_id: <?= json_encode(!empty($this->request->data['OnlineApplicant']['country_id']) ?
                $this->request->data['OnlineApplicant']['country_id']:'') ?>,
        region_id: <?= json_encode(!empty($this->request->data['OnlineApplicant']['region_id']) ?
                $this->request->data['OnlineApplicant']['region_id']:'') ?>,
        zone_id:<?= json_encode(!empty($this->request->data['OnlineApplicant']['zone_id']) ?
                $this->request->data['OnlineApplicant']['zone_id']:'') ?>,
        woreda_id: <?= json_encode(!empty($this->request->data['OnlineApplicant']['woreda_id']) ?
                $this->request->data['OnlineApplicant']['woreda_id']:'') ?>,
        city_id:<?= json_encode(!empty($this->request->data['OnlineApplicant']['city_id']) ?
                $this->request->data['OnlineApplicant']['city_id']:'') ?>
    };

    // Helper: Restore selected value after AJAX
    function restoreSelected($select, value) {
        if (value && $select.find('option[value="' + value + '"]').length) {
            $select.val(value);
        }
    }

    // 1. Country → Region
    $('#country_id').on('change', function () {
        const countryId = $(this).val();
        const $region = $('#region_id');

        $region.prop('disabled', true).html('<option>Loading regions...</option>');
        $('#zone_id, #woreda_id, #city_id').prop('disabled', true).html('<option>-- Select --</option>');

        if (!countryId) {
            $region.html('<option value="">[ Select Region ]</option>').prop('disabled', false);
            return;
        }

        $.get('/students/get_regions/' + countryId)
            .done(function (data) {
                $region.html(data).prop('disabled', false);
                restoreSelected($region, preserved.region_id);

                // Auto-trigger region load if previously selected
                if (preserved.region_id) {
                    $region.trigger('change');
                }
            })
            .fail(() => {
                $region.html('<option>Error loading regions</option>');
            });
    });

    // 2. Region → Zone
    $('#region_id').on('change', function () {
        const regionId = $(this).val();
        const $zone = $('#zone_id');

        $zone.prop('disabled', true).html('<option>Loading zones...</option>');
        $('#woreda_id, #city_id').prop('disabled', true).html('<option>-- Select --</option>');

        if (!regionId) {
            $zone.html('<option value="">[ Select Zone ]</option>').prop('disabled', false);
            return;
        }

        $.get('/students/get_zones/' + regionId)
            .done(function (data) {
                $zone.html(data).prop('disabled', false);
                restoreSelected($zone, preserved.zone_id);

                if (preserved.zone_id) {
                    $zone.trigger('change');
                }
            });
    });

    // 3. Zone → Woreda
    $('#zone_id').on('change', function () {
        const zoneId = $(this).val();
        const $woreda = $('#woreda_id');

        $woreda.prop('disabled', true).html('<option>Loading woredas...</option>');

        if (!zoneId) {
            $woreda.html('<option value="">[ Select Woreda ]</option>').prop('disabled', false);
            return;
        }

        $.get('/students/get_woredas/' + zoneId)
            .done(function (data) {
                $woreda.html(data).prop('disabled', false);
                restoreSelected($woreda, preserved.woreda_id);
            });
    });

    // 4. Region → City (independent of zone)
    $('#region_id').on('change', function () {
        const regionId = $(this).val();
        const $city = $('#city_id');

        if (!regionId) {
            $city.html('<option value="">[ Select City ]</option>').prop('disabled', true);
            return;
        }

        $.get('/students/get_cities/' + regionId)
            .done(function (data) {
                $city.html(data).prop('disabled', false);
                restoreSelected($city, preserved.city_id);
            });
    });

    // INITIALIZE ON PAGE LOAD
    $(function () {
        // If country was selected before submit → trigger cascade
        if (preserved.country_id) {
            $('#country_id').val(preserved.country_id).trigger('change');
        }

        // Restore current values (in case AJAX already loaded them)
        restoreSelected($('#region_id'), preserved.region_id);
        restoreSelected($('#zone_id'), preserved.zone_id);
        restoreSelected($('#woreda_id'), preserved.woreda_id);
        restoreSelected($('#city_id'), preserved.city_id);
    });
</script>

<script>
    var region = Array();
    var months = Array();

    var minGraduationYear = <?= (date('Y') - 30); ?>;
    var maxGraduationYear = <?= date('Y'); ?>;

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

    function addRow(tableID, model, no_of_fields, all_fields, other) {

        var elementArray = all_fields.split(',');
        var table = document.getElementById(tableID);
        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);
        var cell0 = row.insertCell(0);
        cell0.classList.add("center");

        cell0.innerHTML = rowCount;

        for (var i = 1; i <= no_of_fields; i++) {

            var cell = row.insertCell(i);
            var div = document.createElement("div");
            div.style.marginTop = "10px";

            if (elementArray[i - 1] == "region_id") {
                var element = document.createElement("select");
                var string = '<option value="">[ Select Region ]</option>';

                for (var f = 1; f < region.length; f++) {
                    if (!(typeof region[f] === 'undefined')) {
                        string += '<option value="' + f + '">' + region[f] + '</option>';
                    }
                }

                element.style = "width:100%;";
                element.required = "required";
                element.innerHTML = string;

            } else if (elementArray[i - 1] == "exam_year") {
                var element = document.createElement("select");
                var d = new Date();
                var full_year = d.getFullYear();
                var string = '<option value="">[ Select Year ]</option>';

                var selectElement = document.getElementById('EslceResult0ExamYear');
                //var selectElement = document.getElementById('EslceResult' + (rowCount - 1) + 'ExamYear');

                // Get the selected index
                var selectedIndex = selectElement.selectedIndex;

                // Get the selected value
                var selectedValue = selectElement.options[selectedIndex].value;
                //alert(selectedValue);

                for (var j = full_year - 1; j > other; j--) {
                    if (selectedValue != '' && selectedValue == j) {
                        string += '<option value="' + j + '" selected="selected">' + j + '</option>';
                    } else {
                        string += '<option value="' + j + '">' + j + '</option>';
                    }
                }

                element.innerHTML = string;
                //element.style = "width:70%;";
                element.style = "width:100%;";
                element.required = "required";

            } else if (elementArray[i - 1] == 'grade') {
                var element = document.createElement("input");
                element.type = "text";
                element.style = "width:100%;";
                element.placeholder = "A";
                element.required = "required";

                element.classList.add("otherRequiredText-input");

                element.onblur = function() {
                    checkIsAlpha(this);
                };

            } else if (elementArray[i - 1] == 'mark') {
                var element = document.createElement("input");
                element.type = "number";
                element.max = "100";
                element.min = "0";
                element.step = "any";
                element.style = "width:100%;";
                element.placeholder = "Mark " + rowCount;
                element.required = "required";

                element.classList.add("subjectMark-input");

                element.onblur = function() {
                    checkValidMarkInput(this);
                };

            } else if (elementArray[i - 1] == 'national_exam_taken') {
                var element = document.createElement("input");
                element.type = "checkbox";
                element.style = "width:100%;";
            } else if (elementArray[i - 1] == 'cgpa_at_graduation') {
                var element = document.createElement("input");
                element.type = "text";
                /* element.max = "4.0";
                element.min = "2.0";
                element.step = "any"; */
                element.classList.add("cgpa-input");
                element.required = "required";

                element.onblur = function() {
                    checkCGPA(this);
                };

            } else if (elementArray[i - 1] == 'date_graduated') {
                //var element = document.createElement("input");
                //element.type = "date";
                //element.format = "dd/mm/yyyy";
                // element.minYear = "<?php //echo date('Y') - 30; ?>";
                // element.maxYear = "<?php //echo date('Y') - 1; ?>";
                //element.style.width = '30%';
                //element.style = "width:90%;";
                //element.required = "required";

                var divDateGraduated = document.createElement("div");
                var textNode = document.createTextNode("-");
                var textNode1 = document.createTextNode("-");

                var currentYear = new Date().getFullYear();
                currentYear = currentYear - 1;

                var currentMonth = ("0" + (new Date().getMonth() + 1)).slice(-2); // Months are 0-based
                var currentDay = ("0" + new Date().getDate()).slice(-2);

                var monthSelect = document.createElement("select");
                monthSelect.name = "data[HigherEducationBackground][" + rowCount + "][date_graduated][month]";
                monthSelect.style = "width:30%;";
                monthSelect.required = "required";

                var monthOptions = [
                    { value: "01", text: "January" },
                    { value: "02", text: "February" },
                    { value: "03", text: "March" },
                    { value: "04", text: "April" },
                    { value: "05", text: "May" },
                    { value: "06", text: "June" },
                    { value: "07", text: "July" },
                    { value: "08", text: "August" },
                    { value: "09", text: "September" },
                    { value: "10", text: "October" },
                    { value: "11", text: "November" },
                    { value: "12", text: "December" }
                ];

                monthOptions.forEach(function(option) {
                    var opt = document.createElement("option");
                    opt.value = option.value;
                    opt.textContent = option.text;
                    if (option.value === currentMonth) {
                        opt.selected = true;
                    }
                    monthSelect.appendChild(opt);
                });

                var daySelect = document.createElement("select");
                daySelect.name = "data[HigherEducationBackground][" + rowCount + "][date_graduated][day]";
                daySelect.style = "width:30%;";
                daySelect.required = "required";

                for (var day = 1; day <= 31; day++) {
                    var opt = document.createElement("option");
                    var dayValue = ("0" + day).slice(-2);
                    opt.value = dayValue;
                    opt.textContent = day;
                    if (dayValue === currentDay) {
                        opt.selected = true;
                    }
                    daySelect.appendChild(opt);
                }

                var yearSelect = document.createElement("select");
                yearSelect.name = "data[HigherEducationBackground][" + rowCount + "][date_graduated][year]";
                yearSelect.style = "width:30%;";
                yearSelect.required = "required";

                if (maxGraduationYear != '' && minGraduationYear != '') {
                    for (var year = maxGraduationYear; year >= minGraduationYear; year--) {
                        var opt = document.createElement("option");
                        opt.value = year;
                        opt.textContent = year;
                        if (year === currentYear) {
                            opt.selected = true;
                        }
                        yearSelect.appendChild(opt);
                    }
                } else {
                    for (var year = currentYear; year >= currentYear - 30; year--) {
                        var opt = document.createElement("option");
                        opt.value = year;
                        opt.textContent = year;
                        if (year === currentYear) {
                            opt.selected = true;
                        }
                        yearSelect.appendChild(opt);
                    }
                }

                divDateGraduated.appendChild(monthSelect);
                divDateGraduated.appendChild(textNode);
                divDateGraduated.appendChild(daySelect);
                divDateGraduated.appendChild(textNode1);
                divDateGraduated.appendChild(yearSelect);

            } else if (elementArray[i - 1] == 'subject') {
                var element = document.createElement("input");
                element.type = "text";
                element.style = "width:100%;";
                element.placeholder = "Subject " + rowCount;
                //element.pattern = "^[A-Za-z]+$"

                element.required = "required";

                element.classList.add("subject-input");

                element.onblur = function() {
                    checkIsAlpha(this);
                };

            } else {
                var element = document.createElement("input");
                element.type = "text";
                //element.size = "13";
                element.style = "width:100%;";
                element.required = "required";

                element.classList.add("otherRequiredText-input");
                // override the previous div and styling
                //var div = document.createElement("div");

                element.onblur = function() {
                    checkIsAlpha(this);
                };
            }

            //cell.appendChild(element);

            if (elementArray[i - 1] != 'date_graduated') {
                element.name = "data[" + model + "][" + rowCount + "][" + elementArray[i - 1] + "]";
                div.appendChild(element);
            } else if (elementArray[i - 1] == 'date_graduated') {
                div.appendChild(divDateGraduated);
            }

            cell.appendChild(div);

            cell.classList.add("center");
        }

        updateSequence(tableID);

    }

    function deleteRow(tableID) {
        try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            if (rowCount > 2) {
                table.deleteRow(rowCount - 1);
                updateSequence(tableID);
            } else {
                alert('No more rows to delete');
            }
        } catch (e) {
            alert(e);
        }
    }

    function updateSequence(tableID) {
        var s_count = 1;
        for (i = 1; i < document.getElementById(tableID).rows.length; i++) {
            document.getElementById(tableID).rows[i].cells[0].childNodes[0].data = s_count++;
        }
    }

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

    function checkIsAlpha(obj) {

        const pattern = /^[a-zA-Z\s&()']+$/; // support space and &, (, ), and '

        let message = document.getElementById("customMessage");

        // Trim preceding and trailing spaces and capitalize each word if a string and exclude prepositions
        obj.value = capitalizeWordsExcludePrepositions(obj.value.trim());

        if (!pattern.test(obj.value)) {

            obj.style.border = '2px solid red';

            if (!message) {
                message = document.createElement("div");
                message.id = "customMessage";
                // Append the message to the modal container
                document.getElementById('myModalAdd').appendChild(message);
            }

            message.innerText = 'Please use only alphabets. Allowed special charachters: & ( ) and \'';
            message.classList.add('callout', 'alert'); // Foundation callout style

            // Position the message relative to the input field
            const rect = obj.getBoundingClientRect();
            const modalRect = document.getElementById('myModalAdd').getBoundingClientRect();
            message.style.top = `${rect.top - modalRect.top + obj.offsetHeight + 5}px`;
            message.style.left = `${rect.left - modalRect.left}px`;
            message.style.backgroundColor = '#f8d7da';
            message.style.color = '#721c24';
            message.style.border = '1px solid #f5c6cb';
            message.style.position = 'absolute';
            message.style.width = 'max-content';
            message.style.padding = '0.5rem';

            obj.focus();

            // Remove the message after a few seconds
            setTimeout(() => {
                message.remove();
            }, 6000);

            return false;

        } else {

            obj.style.border = '2px solid #ccc';

            if (message) {
                message.remove();
            }

            return true;
        }
    }

</script>
<?php echo $this->Html->script('amharictyping'); ?>