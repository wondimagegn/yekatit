<?php echo $this->Form->create('Page', array(
    'controller' => 'pages', 'action' => 'online_admission_tracking', 'method' => 'post',
    'id' => 'MyForm',
    'enctype' => 'multipart/form-data',
    'type' => 'file',
)); ?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <h3> <?php echo __('Online Application  Status.'); ?>
                </h3>

                <p style="color:green;">
                    <u>Note: You can
                        check your
                        application
                        status only by
                        providing the
                        tracking number
                        and clicking on
                        Search/Submit.
                        Incase you were
                        asked to submit
                        additional
                        document or
                        didnt upload the
                        payment slip
                        while applied
                        use this form to
                        submit the
                        files.</u>
                </p>
            </div>
            <div
                class="large-12 columns">
                <?php echo $this->Form->input('OnlineApplicant.trackingnumber', array('label' => '', 'placeholder' => 'Application number')); ?>



            </div>

            <div
                onclick="toggleViewFullId('ListPublishedCourse')">
                <?php
                if (!empty($request)) {
                    echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg'));
                ?><span
                    style="font-size:10px; vertical-align:top; font-weight:bold"
                    id="ListPublishedCourseTxt">Display</span><?php
                                                                                                                            } else {
                                                                                                                                echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg'));
                                                                                                                                ?><span
                    style="font-size:10px; vertical-align:top; font-weight:bold"
                    id="ListPublishedCourseTxt">Hide</span><?php
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                            ?>
            </div>

            <div id="ListPublishedCourse"
                style="display:<?php echo (!empty($request) ? 'none' : 'display'); ?>">
                <div
                    class="large-6 columns">

                    <label>Incase if you
                        didnt submit
                        Application
                        Files
                        and attach

                        <ol>
                            <li>Student
                                Copy
                                or
                                graduation
                                certificate
                                with GPA
                            </li>
                            <li>Work
                                Experience
                                and
                                sponsorship
                                letter(If
                                any)
                            </li>

                        </ol>
                        <u>Note: Please
                            combine all
                            the
                            above
                            document
                            in one PDF
                            file
                            and attache
                            here</u>
                        <?php
                        echo $this->Form->input(
                            'Attachment.0.file',
                            array(
                                'type' => 'file', 'label' => '',

                                'id' => 'EduFormAttachment',

                                'onchange' =>
                                "return fileValidation(this)",

                            )
                        );
                        ?>
                    </label>
                </div>
                <div
                    class="large-6 columns">

                    <label>Incase if you
                        didnt submit
                        payment
                        slip attach here
                        <?php
                        echo $this->Form->input(
                            'Attachment.1.file',
                            array(
                                'type' => 'file', 'label' => '',

                                'id' => 'ReceiptFormAttachment',

                                'onchange' =>
                                "return fileValidation(this)",

                            )
                        );
                        ?>
                    </label>
                </div>

                <div
                    class="large-12 columns">
                    <?php echo $this->Form->input('OnlineApplicant.email', array(
                        'label' => 'Your email you used while applied', 'placeholder' => 'Your email',
                        'required' => false
                    )); ?>
                    <p
                        style="color:red;">
                        <u>Note: Your
                            updated
                            application
                            file
                            and
                            payment fee
                            will
                            be
                            reflected if
                            and
                            only if the
                            email
                            and tracking
                            number
                            provided
                            is
                            correct.</u>
                    </p>
                </div>

                <div
                    class="large-12 columns">
                    <?php
                    echo $this->Form->end(
                        array('label' => __('Search/Submit', true), 'class' => 'tiny radius button bg-blue')
                    );

                    ?>
                </div>

            </div>
            <?php if (isset($request) && !empty($request)) { ?>
            <div
                class="large-12 columns">
                <table>
                    <thead>
                        <tr>
                            <th>Name
                            </th>
                            <th
                                colspan="3">
                                <?php echo $request['OnlineApplicant']['first_name'] . ' ' . $request['OnlineApplicant']['father_name'] . ' ' . $request['OnlineApplicant']['grand_father_name']; ?>
                            </th>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th
                                colspan="3">
                                <?php
                                    echo $request['OnlineApplicant']['applicationnumber']; ?>
                            </th>
                        </tr>
                        <tr>
                            <th>Status
                            </th>
                            <th>Request
                                Date
                            </th>
                            <th>Remark
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($request['OnlineApplicantStatus']) && !empty($request['OnlineApplicantStatus'])) {
                                foreach ($request['OnlineApplicantStatus'] as $kk => $kv) {
                            ?>
                        <tr>

                            <td>
                                <?php


                                            echo $kv['status'];
                                            ?>
                            </td>
                            <td>
                                <?php


                                            echo date(
                                                "F j, Y, g:i a",
                                                strtotime($kv['created'])
                                            );
                                            ?>
                            </td>
                            <td>
                                <?php

                                            echo $kv['remark'];
                                            ?>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                                ?>
                        <tr>

                            <td>
                                Pending
                            </td>
                            <td>
                                <?php
                                        echo date(
                                            "F j, Y, g:i a",
                                            strtotime(date('Y-m-d'))
                                        );
                                        ?>
                            </td>
                            <td>
                                Your
                                status
                                will be
                                updated
                                soon,
                                please
                                come
                                back

                            </td>
                        </tr>


                        <?php
                            } ?>
                    </tbody>
                </table>
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

function toggleView(obj) {
    if ($('#c' + obj.id).css(
            "display") == 'none')
        $('#i' + obj.id).attr("src",
            '/img/minus2.gif');
    else
        $('#i' + obj.id).attr("src",
            '/img/plus2.gif');
    $('#c' + obj.id).toggle("slow");
}

function toggleViewFullId(id) {
    if ($('#' + id).css("display") ==
        'none') {
        $('#' + id + 'Img').attr("src",
            '/img/minus2.gif');
        $('#' + id + 'Txt').empty();
        $('#' + id + 'Txt').append(
            'Hide Filter');
    } else {
        $('#' + id + 'Img').attr("src",
            '/img/plus2.gif');
        $('#' + id + 'Txt').empty();
        $('#' + id + 'Txt').append(
            'Display Filter');
    }
    $('#' + id).toggle("slow");
}
</script>