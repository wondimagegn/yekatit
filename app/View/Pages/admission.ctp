<?php echo $this->Form->create(
    'Page',
    array(
        'controller' => 'pages', 'action' => 'admission', 'method' => 'post', 'id' => 'MyForm',
        'enctype' => 'multipart/form-data',
        'type' => 'file',
    )
);
?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <h3> <?php echo __('Online Admission.'); ?>
                </h3>
            </div>
            <?php if (empty($academicCalendars)) {
            ?>
            <div
                class="large-12 columns">

                <h5> <?php echo __('The date for online admission is closed.'); ?>
                </h5>
            </div>
            <?php

            } else { ?>
            <div
                class="large-12 columns">
                <ul id="ListOfTab"
                    class="tabs"
                    data-tab>
                    <li
                        class="tab-title active">
                        <a data-toggle="tab"
                            href="#panel1b">Admission
                            Choice</a>
                    </li>
                    <li
                        class="tab-title">
                        <a data-toggle="tab"
                            href="#panel2b">Previous
                            Study</a>
                    </li>
                    <li
                        class="tab-title">
                        <a data-toggle="tab"
                            href="#panel3b">Financial
                            Support</a>
                    </li>
                    <li
                        class="tab-title">
                        <a data-toggle="tab"
                            href="#panel4b">Basic
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
                                            <?php echo $this->Form->input('OnlineApplicant.program_id', array(
                                                    'label' => '', 'class' => 'form-control', 'placeholder' => 'Study Level',
                                                    'required' => 'required'
                                                )); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Admission
                                            Type
                                            <?php echo $this->Form->input('OnlineApplicant.program_type_id', array(
                                                    'label' => '', 'class' => 'form-control', 'placeholder' => 'Admission Type',
                                                    'required' => 'required'
                                                )); ?>
                                        </label>
                                    </div>

                                    <div
                                        class="large-6 columns">
                                        <label>Department
                                            <?php echo $this->Form->input('OnlineApplicant.college_id', array(
                                                    'label' => '', 'class' => 'form-control', 'placeholder' => 'Department',
                                                    'required' => 'required',
                                                    'empty' => '--Select Department--', 'id' => 'college_id_1',
                                                    'onload' => "updateDepartmentCollege(1)",
                                                    'onchange' => 'updateDepartmentCollege(1)', 'style' => 'width:250px'
                                                )); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Field of study
                                            <?php echo $this->Form->input('OnlineApplicant.department_id', array(
                                                    'label' => '', 'class' => 'form-control', 'placeholder' => 'Field of study',
                                                    'required' => 'required',
                                                    'empty' => '--Select Field of study--',
                                                    'id' => 'department_id_1'
                                                )); ?>
                                        </label>
                                    </div>


                                    <div
                                        class="large-6 columns">
                                        <label>Academic
                                            Year


                                            <?php

                                                echo $this->Form->input('OnlineApplicant.academic_year', array(
                                                    'id' => 'academicyear',
                                                    'label' => '', 'type' => 'select', 'options' => $acyeardatas
                                                ))
                                                ?>

                                        </label>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Semester
                                            <?php

                                                echo $this->Form->input('OnlineApplicant.semester', array(
                                                    'options' => $semester,
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
                                            class="btn tiny btnNext"
                                            type="button">Next</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content tab-pane "
                        id="panel2b">
                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-4 columns">
                                        <label>Undergraduate
                                            University
                                            name
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.undergraduate_university_name',
                                                    array('label' => '')
                                                ); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-4 columns">
                                        <label>Undergraduate
                                            University
                                            CGPA
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.undergraduate_university_cgpa',
                                                    array('label' => '', 'min' => 0, 'max' => 10, 'style' => 'width:100px')
                                                ); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-4 columns">
                                        <label>Undergraduate
                                            University
                                            Field
                                            of
                                            Study
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.undergraduate_university_field_of_study',
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
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-4 columns">
                                        <label>Postgraduate
                                            University
                                            name
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.postgraduate_university_name',
                                                    array('label' => '')
                                                ); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-4 columns">
                                        <label>Postgraduate
                                            University
                                            CGPA
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.postgraduate_university_cgpa',
                                                    array('label' => '', 'min' => 0, 'max' => 10, 'style' => 'width:100px')
                                                ); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-4 columns">
                                        <label>Postgraduate
                                            University
                                            Field
                                            of
                                            Study
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.postgraduate_university_field_of_study',
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
                                <button
                                    class="btn tiny btnNext"
                                    type="button">Next</button>
                                <button
                                    class="btn tiny btnPrevious"
                                    type="button">Previous</button>

                            </div>
                        </div>
                    </div>
                    <div class="content tab-pane"
                        id="panel3b">

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
                                                    array('label' => '')
                                                ); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Sponsor
                                            Name
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.name_of_sponsor',
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
                                class="large-4 columns">
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
                        <div
                            class="row">
                            <div
                                class="large-6 columns">
                                <button
                                    class="btn tiny btnNext"
                                    type="button">Next</button>
                                <button
                                    class="btn tiny btnPrevious"
                                    type="button">Previous</button>

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
                                        class="large-4 columns">
                                        <label>First
                                            Name
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.first_name',
                                                    array('label' => '')
                                                ); ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-4 columns">
                                        <label>Father
                                            Name
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.father_name',
                                                    array('label' => '')
                                                ); ?>
                                        </label>
                                    </div>

                                    <div
                                        class="large-4 columns">
                                        <label>Grandfather
                                            Name
                                            <?php echo $this->Form->input(
                                                    'OnlineApplicant.grand_father_name',
                                                    array('label' => '')
                                                ); ?>
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div
                                class="large-12 columns">
                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <label>Gender

                                            <?php
                                                echo $this->Form->input('OnlineApplicant.gender', array(
                                                    'label' => '', 'type' => 'select','empty' => '--Select Gender--',
                                                    'options' => array('female' => 'Female', 'male' => 'Male')
                                                ));
                                                ?>
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
                                                echo $this->Form->input('OnlineApplicant.email', array('label' => ''));
                                                ?>
                                        </label>
                                    </div>
                                    <div
                                        class="large-6 columns">
                                        <label>Mobile
                                            Phone
                                            <?php
                                                echo $this->Form->input('OnlineApplicant.mobile_phone', array('label' => ''));
                                                ?>
                                        </label>
                                    </div>

                                </div>

                                <div
                                    class="row">
                                    <div
                                        class="large-6 columns">
                                        <label>
                                            Combined All Your
                                            Application Files and attach
                                           
					    <ol>
						<li>Student Copy or graduation certificate with GPA</li>
						<li>Work Experience and sponsorship letter(If any)</li>
						
					    </ol>
					    <u>Note: Please combine all the above document in one PDF file and attache here</u>
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
                                    <div
                                        class="large-6 columns">
                                        <label>Payment Receipt <br/>
                                             <u>Note: Please deposit the fee  in account number <strong>1000010795218</strong> of commercial bank of Ethiopia and attach the payment slip in PDF </u>
                                            <?php
                                                echo $this->Form->input(
                                                    'Attachment.1.file',
                                                    array(
                                                        'type' => 'file', 'label' => '',
                                                        'required' => 'required',
                                                        'id' => 'ReceiptFormAttachment',

                                                        'onchange' =>
                                                        "return fileValidation(this)",

                                                    )
                                                );
                                                ?>
                                        </label>
                                    </div>

                                </div>



                            </div>
                            <div
                                class="large-12 columns">
                                <?php
                                    echo $this->Form->submit(__('Submit the application'), array('name' => 'applyOnline', 'class' => 'tiny radius button bg-blue', 'id' => 'applyOnline', 'div' => false));
                                    //echo $this->Form->end(array('label'=>__('Submit'),'class'=>'tiny radius button bg-blue'));

                                    ?>

                            </div>

                        </div>


                    </div>

                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>


<script>
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

function updateDepartmentCollege(id) {

    //serialize form data
    var formData = $("#college_id_" +
        id).val();
    $("#college_id_" + id).attr(
        'disabled', true);
    $("#department_id_" + id).attr(
        'disabled', true);

    //get form action
    var formUrl =
        '/pages/get_department_combo/' +
        formData;
    $.ajax({
        type: 'get',
        url: formUrl,
        data: formData,
        success: function(data,
            textStatus, xhr
        ) {
            $("#department_id_" +
                    id)
                .attr(
                    'disabled',
                    false);
            $("#college_id_" +
                    id)
                .attr(
                    'disabled',
                    false);
            $("#department_id_" +
                    id)
                .empty();
            $("#department_id_" +
                    id)
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
