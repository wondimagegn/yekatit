<?php
echo $this->Form->create(
    'OnlineApplicant',
    array(
        'method' => 'Post', 'id' => 'MyForm',
        'enctype' => 'multipart/form-data',
        'type' => 'file',
    )
);
$years = range(1900, strftime("%Y", time()));
?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <h3> <?php echo __('Update Online Admission.'); ?>
                </h3>
            </div>

            <div
                class="large-12 columns">
                <!--id="ListOfTab"-->
                <ul class="tabs"
                    data-tab>
                    <li id="list_admission_details"
                        class="tab-title active_tab1 active">
                        <a data-toggle="tab"
                            href="#panel1b">Admission
                            Choice</a>
                    </li>

                    <li id="list_basic_details"
                        class="tab-title inactive_tab1">
                        <a data-toggle="tab"
                            href="#panel2b">Basic
                            Information</a>
                    </li>
                    <li id="list_education_details"
                        class="tab-title inactive_tab1">
                        <a data-toggle="tab"
                            href="#panel3b">Educational
                            Background</a>
                    </li>
                    <li id="list_additional_details"
                        class="tab-title inactive_tab1">
                        <a data-toggle="tab"
                            href="#panel4b">Additional
                            Information</a>
                    </li>

                </ul>




                <div
                    class="tabs-content edumix-tab-horz">
                    <div class="content tab-pane active"
                        id="panel1b">

                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <label>Study
                                            Level
                                            <?php
                                            echo $this->Form->input('id');
                                            echo $this->Form->input('OnlineApplicant.program_id', array(
                                                'label' => '', 'id' => 'ProgramId', 'class' => 'form-control', 'placeholder' => 'Study Level',
                                                'required' => 'required'
                                            )); ?>
                                        </label>
                                        <span
                                            id="error_program"
                                            class="text-danger"></span>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Admission
                                            Type
                                            <?php echo $this->Form->input('OnlineApplicant.program_type_id', array(
                                                'label' => '', 'id' => 'ProgramTypeId', 'class' => 'form-control', 'placeholder' => 'Admission Type',
                                                'required' => 'required'
                                            )); ?>
                                        </label>
                                        <span
                                            id="error_program_type"
                                            class="text-danger"></span>
                                    </div>

                                    <div
                                        class="large-6 columns">
                                        <label>Faculty/School
                                            <?php echo $this->Form->input('OnlineApplicant.college_id', array(
                                                'label' => '', 'class' => 'form-control', 
                                                'placeholder' => 'College',
                                                'required' => 'required',
                                                'options'=>$colleges_opened,
                                                'empty' => '--Select Faculty/School--',
                                                'id' => 'college_id_1',
                                               // 'onload' => "updateDepartmentCollege(1)",
                                                'onchange' => 'updateDepartmentCollege(1)', 
                                                'style' => 'width:250px'
                                            )); ?>
                                        </label>
                                        <span
                                            id="error_college"
                                            class="text-danger"></span>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Field
                                            of
                                            study
                                            <?php echo $this->Form->input('OnlineApplicant.department_id', array(
                                                'label' => '', 'class' => 'form-control', 'placeholder' => 'Field of study',
                                                'required' => 'required',
                                                'empty' => '--Select Field of study--',
	                                            'options'=>$department_opened,
                                                'id' => 'department_id_1'
                                            )); ?>
                                        </label>
                                        <span
                                            id="error_department"
                                            class="text-danger"></span>
                                    </div>


                                    <div
                                        class="large-6 columns">
                                        <label>Academic
                                            Year


                                            <?php

                                            echo $this->Form->input('OnlineApplicant.academic_year', array(
                                                'id' => 'academicyear',
                                                'label' => '', 'type' => 'select', 'options' => $acyear_array_data
                                            ))
                                            ?>

                                        </label>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Semester
                                            <?php

                                            echo $this->Form->input('OnlineApplicant.semester', array(
                                                'options' => array('1' => '1', '2' => '2', '3' => '3'),
                                                'type' => 'select',  'class' => 'form-control', 'label' => ''
                                            ));
                                            ?>
                                        </label>
                                    </div>
                                </div>
                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <button
                                            name="btn_admission_detail"
                                            id="btn_admission_detail"
                                            class="btn tiny btnNext"
                                            type="button">Next</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content tab-pane"
                        id="panel2b">
                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-12-columns">
                                        <label>
                                            ሙሉ
                                            ስም
                                            ከነአያት/በአማርኛ
                                            <?php echo $this->Form->input(
                                                'OnlineApplicant.amharic_fullname',
                                                array('label' => '')
                                            ); ?>
                                        </label>
                                    </div>

                                </div>
                                <div
                                    class="row">
                                    <div
                                        class="large-3 columns">
                                        <label>First
                                            Name
                                            <?php echo $this->Form->input(
                                                'OnlineApplicant.first_name',
                                                array('label' => '', 'id' => 'FirstName')
                                            ); ?>
                                        </label>
                                        <span
                                            id="error_firstname"
                                            class="text-danger"></span>
                                    </div>
                                    <div
                                        class="large-3 columns">
                                        <label>Father
                                            Name
                                            <?php echo $this->Form->input(
                                                'OnlineApplicant.father_name',
                                                array('label' => '', 'id' => 'FatherName')
                                            ); ?>
                                        </label>
                                        <span
                                            id="error_fathername"
                                            class="text-danger"></span>
                                    </div>

                                    <div
                                        class="large-3 columns">
                                        <label>Grandfather
                                            Name
                                            <?php echo $this->Form->input(
                                                'OnlineApplicant.grand_father_name',
                                                array('label' => '', 'id' => 'GrandFatherName')
                                            ); ?>
                                        </label>
                                        <span
                                            id="error_grandfathername"
                                            class="text-danger"></span>
                                    </div>

                                    <div
                                        class="large-3 columns">
                                        <label>
                                            Marital
                                            Status

                                            <?php
                                            echo $this->Form->input('OnlineApplicant.marital_status', array(
                                                'label' => '', 'id' => 'MaritalStatus', 'type' => 'select', 'empty' => '--Select Marital Status--',
                                                'options' => array('Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed')
                                            ));
                                            ?>

                                        </label>
                                        <span
                                            id="error_maritalstatus"
                                            class="text-danger"></span>


                                    </div>


                                </div>
                            </div>

                            <div
                                class="large-12 columns">
                                <div
                                    class="row">

                                    <div
                                        class="large-4 columns">
                                        <label>
                                            Country
                                            <?php

                                            echo $this->Form->input('OnlineApplicant.country_id', array(
                                                'label' => '',
                                                'id' => 'Country',
                                                'options' => $countries,
                                                'empty' => '--Select Country--',
                                                'required' => true,
                                                'onchange' => "ShowHideDivAddressBlock('AddressBlock')"
                                            ));


                                            ?>
                                        </label>
                                        <span
                                            id="error_nationality"
                                            class="text-danger"></span>

                                    </div>

                                    <div
                                        class="large-4 columns">
                                        <label>
                                            Nationality
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.nationality', array(
                                                'label' => '',
                                                'id' => 'Nationality',
                                                 'type' => 'select',
                                                    'empty' => '--Select Nationality --',
                                                    'options' => array('Ethiopian' => 'Ethiopian', 'Non Ethiopian' => 'Non Ethiopian')
                                            ));


                                            ?>
                                        </label>
                                        <span
                                            id="error_nationality"
                                            class="text-danger"></span>

                                    </div>

                                    <div
                                        class="large-4 columns">

                                        <label>
                                            Do
                                            you
                                            have
                                            physical
                                            or
                                            any
                                            other
                                            disability
                                            ?

                                            <label
                                                for="chkYes">
                                                <input
                                                    type="radio"
                                                    id="chkYesD"
                                                    name="chk"
                                                    onclick="ShowHideDiv('chkYesD')" />
                                                Yes
                                            </label>
                                            <label
                                                for="chkNo">
                                                <input
                                                    type="radio"
                                                    id="chkNoD"
                                                    name="chk"
                                                    onclick="ShowHideDiv('chkYesD')" />
                                                No
                                            </label>
                                            <div id="dvtext_chkYesD"
                                                style="display: none">
                                                <?php
                                                echo $this->Form->input('OnlineApplicant.disability', array(
                                                    'label' => ''
                                                ));


                                                ?>

                                            </div>
                                        </label>



                                    </div>
                                </div>

                                <div class="row"
                                    id="AddressBlock"
                                    style="display: none">
                                    <div
                                        class="large-3 columns">

                                        <label>
                                            Region
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.region', array(
                                                'label' => '',
                                                'id' => 'Region',
                                                'empty' => 'No Region'
                                            ));


                                            ?>
                                        </label>
                                        <span
                                            id="error_region"
                                            class="text-danger"></span>

                                    </div>
                                    <div
                                        class="large-3 columns">
                                        <label>Zone/Subcity

                                            <?php
                                            echo $this->Form->input('OnlineApplicant.zone', array('label' => '', 'id' => 'zone'));
                                            ?>
                                        </label>
                                        <span
                                            id="error_zone"
                                            class="text-danger"></span>
                                    </div>
                                    <div
                                        class="large-2 columns">
                                        <label>Woreda
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.woreda', array(
                                                'label' => '',
                                                'id' => 'Woreda'
                                            ));
                                            ?>
                                        </label>
                                        <span
                                            id="error_woreda"
                                            class="text-danger"></span>
                                    </div>

                                    <div
                                        class="large-2 columns">
                                        <label>Kebele
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.kebele', array(
                                                'label' => '',
                                                'id' => 'Kebele'
                                            ));
                                            ?>
                                        </label>
                                        <span
                                            id="error_kebele"
                                            class="text-danger"></span>
                                    </div>

                                    <div
                                        class="large-2 columns">
                                        <label>Area
                                            Type
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.kebele', array(
                                                'label' => '',
                                                'id' => 'Area Type',
                                                'options' => array('Non Pastoral' => 'Non Pastoral', 'Pastoral' => 'Pastoral')
                                            ));
                                            ?>
                                        </label>
                                        <span
                                            id="error_areatype"
                                            class="text-danger"></span>
                                    </div>


                                </div>


                            </div>

                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-2 columns">
                                        <label>Gender

                                            <?php
                                            echo $this->Form->input('OnlineApplicant.gender', array(
                                                'label' => '', 'id' => 'Gender', 'type' => 'select', 'empty' => '--Select Gender--',
                                                'options' => array('female' => 'Female', 'male' => 'Male')
                                            ));
                                            ?>
                                            <span
                                                id="error_gender"
                                                class="text-danger"></span>
                                        </label>

                                    </div>


                                    <div
                                        class="large-6 columns">
                                        <label>Date
                                            of
                                            birth
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.date_of_birth', array(
                                                'label' => '',
                                                'minYear' => date('Y') - Configure::read('Calendar.birthdayInPast'), 'maxYear' => date('Y') - 14, 'orderYear' => 'desc', 'type' => 'date', 'style' => 'width:100px;'
                                            ));


                                            ?>
                                        </label>
                                    </div>

                                    <div
                                        class="large-4 columns">
                                        <label>Place
                                            of
                                            birth
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.place_of_birth', array(
                                                'label' => '', 'required',
                                                'id' => 'PlaceOfBirth'
                                            ));


                                            ?>
                                        </label>
                                        <span
                                            id="error_placeofbirth"
                                            class="text-danger"></span>

                                    </div>

                                </div>
                            </div>

                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <label>Email

                                            <?php
                                            echo $this->Form->input('OnlineApplicant.email', array('label' => '', 'id' => 'Email'));
                                            ?>
                                        </label>
                                        <span
                                            id="error_email"
                                            class="text-danger"></span>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Mobile
                                            Phone
                                            <?php
                                            echo $this->Form->input('OnlineApplicant.mobile_phone', array(
                                                'label' => '',
                                                'id' => 'MobilePhone'
                                            ));
                                            ?>
                                        </label>
                                        <span
                                            id="error_mobilephone"
                                            class="text-danger"></span>
                                    </div>

                                </div>



                                <div
                                    class="row">
                                    <div
                                        class="large-12 columns">

                                        <div
                                            class="row">
                                            <div
                                                class="large-6 columns">
                                                <?php
                                                echo $this->Form->input(
                                                    'OnlineApplicant.emergency_contact_name',
                                                    array('id' => 'CName')
                                                );
                                                ?>
                                                <span
                                                    id="error_cname"
                                                    class="text-danger"></span>
                                            </div>

                                            <div
                                                class="large-6 columns">
                                                <?php
                                                echo $this->Form->input('OnlineApplicant.emergency_contact_relation', array('id' => 'CRelation'));
                                                ?>
                                                <span
                                                    id="error_crelation"
                                                    class="text-danger"></span>
                                            </div>


                                        </div>


                                        <div
                                            class="row">
                                            <div
                                                class="large-12 columns">
                                                <?php
                                                echo $this->Form->input('OnlineApplicant.emergency_contact_address', array('id' => 'CAddress'));
                                                ?>
                                                <span
                                                    id="error_caddress"
                                                    class="text-danger"></span>
                                            </div>



                                        </div>


                                    </div>


                                </div>


                                <div
                                    class="row">
                                    <div
                                        class="large-12 columns">

                                        <div
                                            class="row">
                                            <div
                                                class="large-6 columns">
                                                <?php
                                                echo $this->Form->input('OnlineApplicant.present_occupation');
                                                ?>
                                            </div>

                                            <div
                                                class="large-6 columns">
                                                <?php
                                                echo $this->Form->input('OnlineApplicant.address_employer');
                                                ?>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <label>
                                            Profile
                                            Picture
                                            <?php
                                            echo $this->Form->input('Attachment.1.file', array(
                                                'type' => 'file', 'label' => '', 'required' => 'required',
                                                'id' => 'ApplicationFormProfile',
                                                'onchange' =>
                                                "return fileValidationImg(this)"
                                            ));
                                            ?>
                                        </label>

                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>
                                            Combined
                                            All
                                            Your
                                            Application
                                            Files
                                            and
                                            attach

                                            <ol>
                                                <li>Education
                                                    Certificates
                                                </li>
                                                <li>Work
                                                    Experience
                                                    and
                                                    sponsorship
                                                    letter(If
                                                    any)
                                                </li>

                                            </ol>
                                            <u>Note:
                                                Please
                                                combine
                                                all
                                                the
                                                above
                                                document
                                                in
                                                one
                                                PDF
                                                file
                                                and
                                                attache
                                                here</u>
                                            <?php
                                            echo $this->Form->input('Attachment.0.file', array(
                                                'type' => 'file', 'label' => '', 'required' => 'required',
                                                'id' => 'ApplicationFormAttachment',
                                                'onchange' =>
                                                "return fileValidation(this)"
                                            ));
                                            ?>
                                        </label>
                                    </div>



                                </div>



                            </div>


                        </div>

                        <div
                            class="row">
                            <div
                                class="large-6 columns">
                                <button
                                    name="previous_btn_basic_detail"
                                    id="previous_btn_basic_detail"
                                    class="btn tiny btnNext"
                                    type="button">Previous</button>

                            </div>

                            <div
                                class="large-6 columns">
                                <button
                                    name="btn_basic_detail"
                                    id="btn_basic_detail"
                                    class="btn tiny btnNext"
                                    type="button">Next</button>

                            </div>
                        </div>


                    </div>

                    <div class="content tab-pane "
                        id="panel3b">
                        <div
                            class="row">

                            <div class="large-12 columns"
                                id="SenPrepSchool">
                                <?php


                                $fields = array('school_level' => '1', 'name' => '2', 'national_exam_taken' => 3, 'town' => 4, 'year_from' => 5, 'year_to' => 6);
                                $all_fields = "";
                                $sep = "";

                                foreach ($fields as $key => $tag) {
                                    $all_fields .= $sep . $key;
                                    $sep = ",";
                                }
                                ?>

                                <div
                                    class="smallheading">
                                    Senior
                                    Secondary/Preparatory
                                    school
                                    attended
                                </div>
                                <table
                                    id="high_school_education">
                                    <tbody>
                                        <tr>
                                            <th>No.
                                            </th>
                                            <th>School
                                                Level
                                            </th>
                                            <th>Name
                                            </th>
                                            <th>National
                                                Exam
                                                Taken
                                            </th>
                                            <th>City/Town
                                            </th>
                                            <th>Year
                                                From
                                            </th>
                                            <th>Year
                                                To
                                            </th>
                                        </tr>
                                        <?php
                                        $count = 1;
                                        foreach ($this->request->data['HighSchoolEducationBackground'] as $ek => $dv) {

                                        ?>
                                        <tr>

                                            <td><?php echo $count++; ?>
                                            </td>
                                            <td>
                                                <?php
                                                 echo  $this->Form->hidden(
                                                        'HighSchoolEducationBackground.' . $ek . '.id'
                                                    );
                                                   echo  $this->Form->input(
                                                        'HighSchoolEducationBackground.' . $ek . '.school_level',
                                                        array(
                                                            'label' => false, 'div' => false, 'size' => 13
                                                        )
                                                    );
                                                    ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $this->Form->input(
                                                        'HighSchoolEducationBackground.' . $ek . '.name',
                                                        array(
                                                            'label'
                                                            =>
                                                            false,
                                                            'div'
                                                            =>
                                                            false,
                                                            'size'
                                                            =>
                                                            13
                                                        )
                                                    );
                                                    ?>
                                            </td>

                                            <td>
                                                <?php
                                                    echo
                                                    $this->Form->input(
                                                        'HighSchoolEducationBackground.' . $ek . '.national_exam_taken',
                                                        array(
                                                            'label'
                                                            =>
                                                            false,
                                                            'div'
                                                            =>
                                                            false
                                                        )
                                                    );
                                                    ?>
                                            </td>

                                            <td>
                                                <?php
                                                    echo $this->Form->input(
                                                        'HighSchoolEducationBackground.' . $ek . '.town',
                                                        array(
                                                            'label'
                                                            =>
                                                            false,
                                                            'div'
                                                            =>
                                                            false,
                                                            'size'
                                                            =>
                                                            13
                                                        )
                                                    );
                                                    ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $this->Form->input(
                                                        'HighSchoolEducationBackground.' . $ek . '.year_from',
                                                        array(
                                                            'type'
                                                            =>
                                                            'number',
                                                            'div'
                                                            =>
                                                            false,
                                                            'label'
                                                            =>
                                                            false,
                                                            "maxlength"
                                                            =>
                                                            4,
                                                            'max'
                                                            =>
                                                            '3000'
                                                        )
                                                    );
                                                    ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $this->Form->input(
                                                        'HighSchoolEducationBackground.' . $ek . '.year_to',
                                                        array(
                                                            'type'
                                                            =>
                                                            'number',
                                                            'maxlength'
                                                            =>
                                                            4,
                                                            'max'
                                                            =>
                                                            '3000',
                                                            'label'
                                                            =>
                                                            false,
                                                            'div'
                                                            =>
                                                            false
                                                        )
                                                    );
                                                    ?>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <table>
                                    <tr>
                                        <td
                                            colspan=6>
                                            <INPUT
                                                type="button"
                                                value="Add Row"
                                                onclick="addRow('high_school_education','HighSchoolEducationBackground',6,'<?php echo $all_fields; ?>')" />
                                            <INPUT
                                                type="button"
                                                value="Delete Row"
                                                onclick="deleteRow('high_school_education')" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="large-12 columns"
                                id="HigherEducationDetail">


                                <?php

                                $higher_fields = array(
                                    'name' => '1', 'field_of_study' => '2',
                                    'diploma_awarded' => '3', 'date_graduated' => '4', 'cgpa_at_graduation' => '5',
                                    'city' => '6',
                                    'first_degree_taken' => 7,
                                    'second_degree_taken' => 8
                                );
                                $higher_all_fields = "";
                                $sepp = "";

                                foreach ($higher_fields as $key => $tag) {
                                    $higher_all_fields .= $sepp . $key;
                                    $sepp = ",";
                                }

                                foreach ($fields as $key => $tag) {
                                    $all_fields .= $sep . $key;
                                    $sep = ",";
                                }
                                ?>

                                <div
                                    class="smallheading">
                                    College/University
                                </div>
                                <table
                                    id="higher_education_background">
                                    <tbody>

                                        <tr>
                                            <th>No.
                                            </th>
                                            <th>Name
                                            </th>
                                            <th>Field
                                                of
                                                study
                                            </th>
                                            <th>Diploma
                                                Awared
                                            </th>
                                            <th>Year
                                                graduation
                                            </th>
                                            <th>CGPA
                                                at
                                                Graduation
                                            </th>
                                            <th>City
                                            </th>
                                            <th>First
                                                Degree
                                            </th>
                                            <th>Second
                                                Degree
                                            </th>
                                        </tr>

                                        <?php
                                        $hcount = 1;
                                        foreach ($this->request->data['HigherEducationBackground'] as $ek => $dv) {

                                        ?>

                                        <tr>
                                            <td><?php echo  $hcount; ?>
                                            </td>

                                            <td>
                                                <?php
                                                  echo  $this->Form->hidden(
                                                        'HigherEducationBackground.' . $ek . '.id'
                                                    );

                                                echo $this->Form->input(
                                                        'HigherEducationBackground.' . $ek . '.name',
                                                        array('div' => false, 'label' => false)
                                                    ); ?>
                                            </td>


                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.field_of_study',
                                                            array('div' => false, 'label' => false)
                                                        ) ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.diploma_awarded',
                                                            array('div' => false, 'label' => false)
                                                        ); ?>
                                            </td>
                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.date_graduated',
                                                            array('div' => false, "maxlength" => 4, 'type' => 'number', 'label' => false)
                                                        ); ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.cgpa_at_graduation',
                                                            array('div' => false, "maxlength" => 2, 'label' => false, 'size' => 1)
                                                        ); ?>
                                            </td>
                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.city',
                                                            array('div' => false, 'label' => false, 'type' => 'text')
                                                        ); ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.first_degree_taken',
                                                            array('div' => false, 'label' => false, 'type' => 'checkbox')
                                                        ) ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.' . $ek . '.second_degree_taken',
                                                            array('div' => false, 'label' => false, 'type' => 'checkbox')
                                                        ) ?>
                                            </td>


                                        </tr>
                                        <?php }

                                        if(empty($this->request->data['HigherEducationBackground'])){
                                        ?>

                                          <tr>
                                            <td><?php echo  $hcount; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->Form->input(
                                                        'HigherEducationBackground.0.name',
                                                        array('div' => false, 'label' => false)
                                                    ); ?>
                                            </td>


                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.field_of_study',
                                                            array('div' => false, 'label' => false)
                                                        ) ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.diploma_awarded',
                                                            array('div' => false, 'label' => false)
                                                        ); ?>
                                            </td>
                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.date_graduated',
                                                            array('div' => false, "maxlength" => 4, 'type' => 'number', 'label' => false)
                                                        ); ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.cgpa_at_graduation',
                                                            array('div' => false, "maxlength" => 2, 'label' => false, 'size' => 1)
                                                        ); ?>
                                            </td>
                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.city',
                                                            array('div' => false, 'label' => false, 'type' => 'text')
                                                        ); ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.first_degree_taken',
                                                            array('div' => false, 'label' => false, 'type' => 'checkbox')
                                                        ) ?>
                                            </td>

                                            <td> <?php echo $this->Form->input(
                                                            'HigherEducationBackground.0.second_degree_taken',
                                                            array('div' => false, 'label' => false, 'type' => 'checkbox')
                                                        ) ?>
                                            </td>


                                        </tr>


                                        <?php } ?>
                                </table>

                                <table>
                                    <tr>
                                        <td
                                            colspan=6>
                                            <INPUT
                                                type="button"
                                                value="Add Row"
                                                onclick="addRow('higher_education_background','HigherEducationBackground',8,'<?php echo  $higher_all_fields; ?>')" />
                                            <INPUT
                                                type="button"
                                                value="Delete Row"
                                                onclick="deleteRow('higher_education_background')" />
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <div class="large-12 columns"
                                id="TVETEducationDetail"
                                style="display:none;">
                                <?php

                                $coc_fields = array(
                                    'name' => '1', 'level' => '2',
                                    'cocresult' => '3', 'cocdate' => '4'
                                );
                                $coc_all_fields = "";
                                $sepp = "";

                                foreach ($coc_fields as $key => $tag) {
                                    $coc_all_fields .= $sepp . $key;
                                    $sepp = ",";
                                }

                                foreach ($fields as $key => $tag) {
                                    $all_fields .= $sep . $key;
                                    $sep = ",";
                                }
                                ?>

                                <div
                                    class="smallheading">
                                    COC
                                </div>
                                <table
                                    id="coc_education_background">
                                    <tbody>

                                        <tr>
                                            <th>No.
                                            </th>
                                            <th>Level
                                            </th>
                                            <th>Field
                                                of
                                                study
                                            </th>
                                            <th>
                                                COC
                                                Date
                                            </th>

                                            <th>
                                                COC
                                                Result
                                            </th>

                                        </tr>

                                        <?php
                                        $ccount = 1;
                                        foreach ($this->request->data['CocBackground'] as $ek => $dv) {

                                        ?>

                                        <tr>
                                            <td><?php echo  $ccount; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->Form->input(
                                                        'CocBackground.' . $ccount . '.name',
                                                        array('div' => false, 'label' => false)
                                                    ); ?>
                                            </td>

                                            <td>
                                                <?php echo $this->Form->input(
                                                        'CocBackground.' . $ccount . '.level',
                                                        array('div' => false, 'label' => false)
                                                    ); ?>
                                            </td>

                                            <td>
                                                <?php echo $this->Form->input(
                                                        'CocBackground.' . $ccount . '.cocresult',
                                                        array('div' => false, 'label' => false)
                                                    ); ?>
                                            </td>
                                            <td>
                                                <?php echo $this->Form->input(
                                                        'CocBackground.' . $ccount . '.cocdate',
                                                        array('div' => false, 'label' => false)
                                                    ); ?>
                                            </td>

                                        </tr>
                                        <?php } ?>
                                </table>


                                </table>

                            </div>

                            <div class="large-12 columns"
                                id="EquivalentDiplomaDegree"
                                style="display:none;">
                                <?php

                                $coc_fields = array(
                                    'name' => '1', 'attachment' => '2'
                                );
                                $coc_all_fields = "";
                                $sepp = "";

                                foreach ($coc_fields as $key => $tag) {
                                    $coc_all_fields .= $sepp . $key;
                                    $sepp = ",";
                                }

                                foreach ($fields as $key => $tag) {
                                    $all_fields .= $sep . $key;
                                    $sep = ",";
                                }
                                ?>

                                <div
                                    class="smallheading">
                                    Equivalent
                                    Diploma
                                </div>
                                <table
                                    id="equivalent_background">
                                    <tbody>

                                        <tr>
                                            <th>No.
                                            </th>

                                            <th>Field
                                                of
                                                study
                                            </th>

                                            <th>
                                                Attachment
                                            </th>

                                        </tr>

                                        <?php
                                        $ecount = 1;
                                        foreach ($this->request->data['EquivalentDiploma'] as $ek => $dv) {

                                        ?>

                                        <tr>
                                            <td><?php echo $ecount; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->Form->input(
                                                        'EquivalentDiploma.' . $ek . '.name',
                                                        array(
                                                            'div' => false, 'label' => false
                                                        )
                                                    );

                                                    ?>
                                            </td>

                                            <td>

                                                <?php

                                                    echo $this->Form->input('EquivalentDiploma.' . $ek . '.file', array(
                                                        'type' => 'file', 'label' => '',
                                                        'id' => 'ApplicationFormEquivalent',
                                                        'onchange' =>
                                                        "return fileValidationImg(this)"
                                                    ));

                                                    echo $this->Form->hidden('EquivalentDiploma' . '.' . $ek . '.model', array('value' => 'EquivalentDiploma'));
                                                    echo $this->Form->hidden('EquivalentDiploma' . '.' . $ek . '.group', array('value' => strtolower('diploma')));


                                                    ?>

                                            </td>
                                        </tr>
                                        <?php } ?>
                                </table>


                            </div>
                        </div>
                        <div
                            class="row">
                            <div
                                class="large-6 columns">
                                <button
                                    name="previous_btn_education_detail"
                                    id="previous_btn_education_detail"
                                    class="btn tiny btnNext"
                                    type="button">Previous</button>

                            </div>

                            <div
                                class="large-6 columns">
                                <button
                                    name="btn_education_detail"
                                    id="btn_education_detail"
                                    class="btn tiny btnNext"
                                    type="button">Next</button>

                            </div>
                        </div>
                    </div>
                    <div class="content tab-pane"
                        id="panel4b">

                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <label>Financial
                                            Support
                                            <?php echo $this->Form->input(
                                                'OnlineApplicant.financial_support',
                                                array('label' => '', 'options' => $financial_supports)
                                            ); ?>
                                        </label>
                                    </div>

                                    <div
                                        class="large-6 columns">
                                        <label>
                                            Year
                                            of
                                            experience
                                            <?php echo $this->Form->input(
                                                'OnlineApplicant.year_of_experience',
                                                array('label' => '')
                                            ); ?>
                                        </label>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div
                            class="row">
                            <div
                                class="large-6 columns">
                                <label>
                                    Have
                                    you
                                    had
                                    any
                                    research
                                    experience
                                    ?

                                    <label
                                        for="chkYes">
                                        <input
                                            type="radio"
                                            name="research_experience" />
                                        Yes
                                    </label>
                                    <label
                                        for="chkNo">
                                        <input
                                            type="radio"
                                            name="research_experience" />
                                        No
                                    </label>

                                </label>


                            </div>

                            <div
                                class="large-6 columns">
                                <label>
                                    Have
                                    your
                                    research
                                    output
                                    been
                                    published
                                    ?

                                    <label
                                        for="chkYes">
                                        <input
                                            type="radio"
                                            id="chkYesP"
                                            name="chkp"
                                            onclick="ShowHideDiv('chkYesP')" />
                                        Yes
                                    </label>
                                    <label
                                        for="chkNo">
                                        <input
                                            type="radio"
                                            id="chkNoP"
                                            name="chkp"
                                            onclick="ShowHideDiv('chkYesP')" />
                                        No
                                    </label>
                                    <div id="dvtext_chkYesP"
                                        style="display: none">
                                        Provide
                                        reference
                                        where
                                        and
                                        when
                                        they
                                        were
                                        published:
                                        <?php
                                        echo $this->Form->input('OnlineApplicant.research_output', array(
                                            'label' => ''
                                        ));


                                        ?>

                                    </div>
                                </label>


                            </div>

                        </div>

                        <div
                            class="row">

                            <div
                                class="large-6 columns">
                                <label>
                                    Have
                                    you
                                    received
                                    any
                                    commendation
                                    or
                                    awards
                                    in
                                    recognition
                                    of
                                    your
                                    merits
                                    ?

                                    <label
                                        for="chkYes">
                                        <input
                                            type="radio"
                                            id="chkYesA"
                                            name="chka"
                                            onclick="ShowHideDiv('chkYesA')" />
                                        Yes
                                    </label>
                                    <label
                                        for="chkNo">
                                        <input
                                            type="radio"
                                            id="chkNoA"
                                            name="chka"
                                            onclick="ShowHideDiv('chkYesA')" />
                                        No
                                    </label>
                                    <div id="dvtext_chkYesA"
                                        style="display: none">
                                        Provide
                                        abrief
                                        description
                                        of
                                        the
                                        award
                                        and
                                        the
                                        citation
                                        made
                                        at
                                        the
                                        time
                                        ?
                                        <?php
                                        echo $this->Form->input('OnlineApplicant.award', array(
                                            'label' => ''
                                        ));


                                        ?>

                                    </div>
                                </label>


                            </div>

                        </div>


                        <div
                            class="row">
                            <div
                                class="large-6 columns">
                                <button
                                    name="previous_btn_additional_detail"
                                    id="previous_btn_additional_detail"
                                    class="btn tiny btnNext"
                                    type="button">Previous</button>

                            </div>
                            <div
                                class="large-6 columns">
                                <button
                                    name="btn_additional_detail"
                                    id="btn_additional_detail"
                                    class="btn tiny btnNext"
                                    type="button">Submit</button>

                                <?php
                                // echo $this->Form->submit(__('Submit the application'), array('name' => 'applyOnline', 'class' => 'tiny radius button bg-blue', 'id' => 'applyOnline', 'div' => false));
                                //echo $this->Form->end(array('label'=>__('Submit'),'class'=>'tiny radius button bg-blue'));

                                ?>

                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

<script nonce="<?php echo h($nonce)?>"  type='text/javascript'>
    function fileValidation(obj) {

        var fileInput =
            document.getElementById(obj.id);

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =
            /(\.pdf)$/i;

        if (!allowedExtensions.exec(
                filePath)) {
            alert(
                'Invalid file type: Please upload only pdf file'
            );
            fileInput.value = '';
            return false;
        }
        return true;
    }

    function fileValidation(obj) {

        var fileInput =
            document.getElementById(obj.id);

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =
            /(\.pdf)$/i;

        if (!allowedExtensions.exec(
                filePath)) {
            alert(
                'Invalid file type: Please upload only pdf file'
            );
            fileInput.value = '';
            return false;
        }
        return true;
    }

    function fileValidationImg(obj) {

        var fileInput =
            document.getElementById(obj.id);

        var filePath = fileInput.value;

        // Allowing file type
        var allowedExtensions =
            /\.(jpe?g|png|gif|bmp)$/i;

        if (!allowedExtensions.exec(
                filePath)) {
            alert(
                '<?php echo __('Invalid file type: Please upload only image file'); ?>'
            );
            fileInput.value = '';
            return false;
        }
        return true;
    }

    function ShowHideDiv(id) {
        var chkYes = document
            .getElementById(id);
        var dvtext = document
            .getElementById("dvtext_" + id);
        dvtext.style.display = chkYes
            .checked ? "block" : "none";
    }

    function ShowHideDivAddressBlock(id) {
        var divBlock = document
            .getElementById(id);
        var dvtext = document
            .getElementById("Country");
        divBlock.style.display = dvtext
            .value == "68" ? "block" :
            "none";
    }

function addRow(tableID, model,
    no_of_fields, all_fields, other
) {

    var elementArray = all_fields
        .split(
            ',');
    var table = document
        .getElementById(
            tableID);
    var rowCount = table.rows
        .length;
    var row = table.insertRow(
        rowCount);
    var cell0 = row.insertCell(0);
    cell0.innerHTML = rowCount;
    for (var i = 1; i <=
        no_of_fields; i++) {
        var cell = row.insertCell(
            i);

        if (elementArray[i - 1] ==
            'school_level') {
            var element = document
                .createElement(
                    "input");
            element.type = "text";
            element.size = "4";
        } else if (elementArray[i -
                1] == 'year_from') {
            var element = document
                .createElement(
                    "input");
            element.type = "number";
            element.size = "4";
            element.maxlength = "4";

        } else if (elementArray[i -
                1] == 'year_to') {
            var element = document
                .createElement(
                    "input");
            element.type = "number";
            element.size = "4";
            element.maxlength = "4";

        } else if (elementArray[i -
                1] ==
            'date_graduated') {

            var element = document
                .createElement(
                    "input");
            element.type = "number";
            element.size = "4";
            element.maxlength = "4";

        } else if (elementArray[i -
                1] == 'name') {
            var element = document
                .createElement(
                    "input");
            element.type = "text";
            element.size = "5";
        } else if (elementArray[i -
                1] == 'town') {
            var element = document
                .createElement(
                    "input");
            element.type = "text";
            element.size = "5";

        } else if (elementArray[i -
                1] ==
            'national_exam_taken') {

            var element = document
                .createElement(
                    "input");
            element.type =
                "checkbox";

        } else if (elementArray[i -
                1] ==
            'first_degree_taken') {
            var element = document
                .createElement(
                    "input");
            element.type =
                "checkbox";

        } else if (elementArray[i -
                1] ==
            'second_degree_taken') {
            var element = document
                .createElement(
                    "input");
            element.type =
                "checkbox";

        } else if (elementArray[i -
                1] ==
            'cgpa_at_graduation') {
            var element = document
                .createElement(
                    "input");
            element.type = "text";
            element.size = "2";
            element.maxlength = "2";

        } else {
            var element = document
                .createElement(
                    "input");
            element.type = "text";
            element.size = "13";
        }


        element.name = "data[" +
            model +
            "][" + rowCount + "][" +
            elementArray[i - 1] +
            "]";
        cell.appendChild(element);
    }

}

function deleteRow(tableID) {
    try {
        var table = document
            .getElementById(
                tableID);
        var rowCount = table.rows
            .length;
        if (rowCount != 2) {
            table.deleteRow(
                rowCount -
                1);
        } else {
        }
    } catch (e) {
        alert(e);
    }
}


function updateDepartmentCollege(id) {

    //serialize form data
    var formData = $("#college_id_"+id).val();
  
    //get form action
    var formUrl =
        '/pages/get_department_combo/' +
        formData;
    $.ajax({
        type: 'post',
         url: formUrl,
            data: $('form')
                .serialize(),
        success: function(data,
            textStatus, xhr
        ) {
        
            $("#department_id_"+id)
                .empty();
            $("#department_id_"+id)
                .append(
                    data);


        },
        error: function(xhr,
            textStatus,
            error) {
            alert(
                textStatus
            );
        }
    });

    return false;

}

</script>