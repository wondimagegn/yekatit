<div class="box">
    <div class="box-body">
        <div class="row">

            <div
                class="large-12 columns">
                <!--id="ListOfTab"-->
                <ul class="tabs"
                    data-tab>
                    <li id="list_admission_details"
                        class="tab-title active_tab1 active">
                        <a data-toggle="tab"
                            href="#panel1b">Admission
                            Type</a>
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
                            href="#panel4b">Emergency
                            and
                            Support</a>
                    </li>

                    <li id="list_additional_details"
                        class="tab-title inactive_tab1">
                        <a data-toggle="tab"
                            href="#panel5b">Billing</a>
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
                                <table>
                                    <tr>
                                        <td>College/Faculty/School
                                        </td>
                                        <td><?php echo $applicant['College']['name']; ?>
                                        </td>
                                        <td>Field
                                            of
                                            Study/Department
                                        </td>
                                        <td><?php echo $applicant['Department']['name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Study
                                            Level
                                        </td>
                                        <td><?php echo $applicant['Program']['name']; ?>
                                        </td>
                                        <td>Enrollment
                                            Type
                                        </td>
                                        <td><?php echo $applicant['ProgramType']['name']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Academic
                                            Year
                                        </td>
                                        <td><?php echo $applicant['OnlineApplicant']['academic_year']; ?>
                                        </td>
                                        <td>Semester
                                        </td>
                                        <td><?php echo $applicant['OnlineApplicant']['semester']; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Application
                                            Number
                                        </td>
                                        <td><?php echo $applicant['OnlineApplicant']['applicationnumber']; ?>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td
                                            colspan="2">
                                            Profile
                                            Picture
                                        </td>
                                        <td
                                            colspan="2">
                                            Education
                                            Document
                                        </td>
                                    </tr>
                                    <tr>

                                        <?php
                                        $foundProfile = false;
                                        $foundProfileString = '';
                                        $foundEduDoc = false;
                                        $foundEduDocString = '';

                                        if (!empty($applicant['Attachment'])) {


                                            foreach ($applicant['Attachment'] as $ak => $av) {

                                                if (!empty($av['dirname']) && !empty($av['basename']) && strcasecmp($av['dirname'], 'img') == 0 && strcasecmp($av['group'], 'OnlineApplicantProfile') == 0) {

                                                    $foundProfileString = $this->Media->embedAsObject($av['dirname'] . DS . $av['basename'], array('width' => 144, 'class' => 'profile-picture'));

                                                    $foundProfile = true;
                                                } else if (strcasecmp($av['dirname'], 'doc') == 0 && strcasecmp($av['group'], 'OnlineApplicantFiles') == 0) {

                                                    $foundEduDocString = $av['path'];
                                                    $foundEduDoc = true;
                                                }
                                            }
                                        }
                                        ?>

                                        <?php
                                        if ($foundProfile) {
                                            echo '<td colspan="2">' . $foundProfileString . '</td>';
                                        } else {
                                            echo '<td colspan="2">No profile picture provided</td>';
                                        }

                                        if ($foundEduDoc) {

                                        ?>
                                        <td
                                            colspan="2">
                                            <a href="<?php ?>"
                                                target="_blank"
                                                onclick="window.open('<?php echo $this->Media->url($foundEduDocString); ?>', 'popup', 'height=330, width=600,scrollbars=yes,resizable=yes'); return false;"><?php echo __('View Education Document'); ?></a>
                                        </td>

                                        <?php

                                        } else {
                                            echo '<td colspan="2">No Education Document</td>';
                                        }
                                        ?>


                                    </tr>

                                    <tr>

                                        <?php
                                            if ($applicant['Invoice'][0]['status'] == 'Pending') {
								echo "<td colspan=4 style='color:grey'> Payment Status: Pending</td>";

							} else if ($applicant['Invoice'][0]['status'] == 'Approved') {

                                echo "<td colspan=4 style='color:green'> Payment Status: Approved</td>";

							} else {
								 echo "<td colspan=4 style='color:red'> Payment Status: Rejected</td>";
							}
                            ?>

                                    </tr>

                                    <tr>
                                        <td
                                            colspan="4">
                                            <?php


                                            if ($applicant['OnlineApplicant']['document_submitted'] == 1) {
                                                echo '<p class="tiny radius button bg-green">';

                                                echo __('Applicant Document Approved!');
                                                echo '</p>';
                                            } else {

                                                echo $this->Html->link('Do you want to accept the document as complete ?', '#', array(
                                                    'class' => 'tiny radius button bg-blue',
                                                    'data-animation' => "fade", 'data-reveal-id' => 'myModalInvoice',
                                                    'data-reveal-ajax' => '/onlineApplicants/accept_document/'
                                                        . $applicant['OnlineApplicant']['id']
                                                ));
                                            }
                                            ?>

                                        </td>
                                    </tr>

                                </table>
                                <?php if (isset($applicant['OnlineApplicantStatus']) && !empty($applicant['OnlineApplicantStatus'])) {

                                ?>
                                <table>
                                    <tr>
                                        <th>S.No
                                        </th>
                                        <th>Staus
                                        </th>
                                        <th>Remark
                                        </th>
                                        <th>Date
                                        </th>
                                        <th>Updated
                                            By
                                        </th>
                                    </tr>
                                    <?php

                                        $stcount = 1;
                                        foreach ($applicant['OnlineApplicantStatus'] as $stk => $stv) {

                                        ?>
                                    <tr>
                                        <td><?php echo $stcount++; ?>
                                        </td>
                                        <td>
                                            <?php echo $stv['status']; ?>
                                        </td>
                                        <td>
                                            <?php echo $stv['remark']; ?>
                                        </td>
                                        <td>
                                            <?php echo $stv['created']; ?>
                                        </td>
                                        <td>
                                            <?php echo $stv['User']['full_name']; ?>
                                        </td>
                                    </tr>

                                    <?php } ?>

                                </table>
                                <?php } ?>


                            </div>

                        </div>
                    </div>
                    <div class="content tab-pane"
                        id="panel2b">
                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <table>
                                    <tr>
                                        <th
                                            colspan=4>
                                            Personal
                                            Information
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>ሙሉ
                                            ስም
                                            ከነአያት/በአማርኛ
                                        </td>
                                        <td><?php echo h($applicant['OnlineApplicant']['amharic_fullname']); ?>
                                        </td>
                                        <td>First
                                            Name
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['first_name']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Father
                                            Name

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['father_name']); ?>
                                        </td>
                                        <td>Grandfather
                                            Name
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['grand_father_name']); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Marital
                                            Status
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['marital_status']); ?>
                                        </td>
                                        <td>Nationality

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['nationality']); ?>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td>
                                            Gender


                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['gender']); ?>
                                        </td>
                                        <td>Disability

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['disability']); ?>
                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            Date
                                            of
                                            birth
                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['date_of_birth']);
                                            ?>
                                        </td>
                                        <td>Place
                                            of
                                            birth

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['place_of_birth']);
                                                ?>

                                        </td>

                                    </tr>
                                    <tr>

                                        <td>
                                            Mother
                                            Name
                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['mother_fullname']);
                                            ?>
                                        </td>
                                        <td>Where
                                            you
                                            come
                                            from

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['come_from']).'/'. h($applicant['OnlineApplicant']['area_type']);
                                                ?>

                                        </td>

                                    </tr>

                                    <tr>
                                        <th
                                            colspan=4>
                                            Present
                                            Address
                                        </th>
                                    </tr>

                                    <tr>

                                        <td>
                                            Country
                                        </td>
                                        <td>
                                            <?php echo h($applicant['Country']['name']);
                                            ?>
                                        </td>
                                        <td>Region
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['region']);
                                                ?>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>
                                            Zone/Subcity
                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['zone']);
                                            ?>
                                        </td>
                                        <td>Woreda
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['woreda']);
                                            ?>
                                        </td>

                                    </tr>


                                    <tr>

                                        <td>
                                            House
                                            Number
                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['house_number']);
                                            ?>
                                        </td>
                                        <td>Pobox
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['pobox']);
                                            ?>
                                        </td>

                                    </tr>


                                    <tr>

                                        <td>
                                            Email


                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['email']);
                                            ?>
                                        </td>
                                        <td>Mobile
                                            Phone

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['mobile_phone']);
                                                ?>
                                        </td>

                                    </tr>

                                    <tr>
                                        <th
                                            colspan=4>
                                            Person
                                            to
                                            be
                                            contact
                                            in
                                            case
                                            of
                                            emergency
                                        </th>
                                    </tr>

                                    <tr>

                                        <td>
                                            Research
                                            Experience

                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['research_experience']);
                                            ?>



                                        </td>
                                        <td>Research
                                            Output
                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['research_output']);
                                                ?>
                                        </td>

                                    </tr>

                                    <tr>

                                        <td>Present
                                            Occuption

                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['present_occupation']);
                                            ?>




                                        </td>
                                        <td>Address
                                            Employer

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['address_employer']);
                                                ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            Year
                                            of
                                            experience

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['emergency_contact_address']);
                                                ?>

                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                        </td>

                                    </tr>





                                </table>



                            </div>







                        </div>




                    </div>

                    <div class="content tab-pane "
                        id="panel3b">
                        <table>

                            <?php if (isset($applicant['HighSchoolEducationBackground']) && !empty($applicant['HighSchoolEducationBackground'])) { ?>
                            <tr>
                                <th
                                    colspan="7">
                                    School

                                    Background
                                </th>
                            </tr>
                            <tr>
                                <th>Name
                                </th>
                                <th>School
                                    Level
                                </th>
                                <th>Town
                                </th>
                                <th>Zone
                                </th>
                                <th>National
                                    Exam
                                    Taken
                                </th>
                                <th>Grade
                                    12
                                    Result
                                </th>
                                <th>Grade
                                    10
                                    Result
                                </th>
                            </tr>

                            <?php foreach ($applicant['HighSchoolEducationBackground'] as $ak => $av) { ?>
                            <tr>
                                <td><?php echo $av['name']; ?>
                                </td>
                                <td><?php echo $av['school_level']; ?>
                                </td>
                                <td><?php echo $av['town']; ?>
                                </td>
                                <td><?php echo $av['zone']; ?>
                                </td>
                                <td><?php echo $av['national_exam_taken'] == 1 ? 'Yes' : 'No'; ?>
                                </td>

                                <td><?php echo $av['grade_12']; ?>
                                </td>
                                <td><?php echo $av['grade_10']; ?>
                                </td>


                            </tr>

                            <?php } ?>

                            <?php } ?>

                            <?php if (isset($applicant['HigherEducationBackground']) && !empty($applicant['HigherEducationBackground'])) { ?>
                            <tr>
                                <th
                                    colspan="7">
                                    Higher
                                    Education
                                    Background
                                </th>
                            </tr>
                            <tr>
                                <th>Name
                                </th>
                                <th>Field
                                    of
                                    Study
                                </th>
                                <th>Diploma
                                    Awarded
                                </th>
                                <th>Date
                                    Graduated
                                </th>
                                <th>CGPA
                                    at
                                    Graduation
                                </th>
                                <th>First/Second
                                    Degree
                                    Taken
                                </th>
                                <th>City
                                </th>
                            </tr>

                            <?php foreach ($applicant['HigherEducationBackground'] as $ak => $av) { ?>
                            <tr>
                                <td><?php echo $av['name']; ?>
                                </td>
                                <td><?php echo $av['field_of_study']; ?>
                                </td>
                                <td><?php echo $av['diploma_awarded']; ?>
                                </td>
                                <td><?php echo $av['date_graduated']; ?>
                                </td>
                                <td><?php echo $av['cgpa_at_graduation']; ?>
                                </td>
                                <td>

                                    <?php
                                    $fanswer=$av['first_degree_taken'] == 1 ? 'Yes' : 'No';
                                    echo 'First Degree taken:'.$fanswer; ?>
                                    <br>
                                    <?php
                                    $sanswer=$av['second_degree_taken'] == 1 ? 'Yes' : 'No';
                                    echo 'Second Degree taken:'.$sanswer; ?>
                                </td>
                                <td><?php echo $av['city']; ?>
                                </td>
                            </tr>

                            <?php } ?>

                            <?php } ?>

                        </table>


                    </div>
                    <div class="content tab-pane"
                        id="panel4b">

                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <table>
                                    <tr>
                                        <td>Emergency
                                            Contact
                                            Name
                                        </td>
                                        <td><?php echo h($applicant['OnlineApplicant']['emergency_contact_name']); ?>
                                        </td>
                                        <td>Emergency
                                            Contact
                                            Relation:

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['emergency_contact_relation']);
                                                ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Emergency
                                            Contact
                                            Address

                                        </td>
                                        <td> <?php echo h($applicant['OnlineApplicant']['emergency_contact_address']);
                                                ?>

                                        </td>
                                        <td>
                                            Financial
                                            Support
                                        </td>
                                        <td>
                                            <?php echo h($applicant['OnlineApplicant']['financial_support']);
                                            ?>
                                        </td>
                                    </tr>


                                </table>

                            </div>
                        </div>


                    </div>

                    <div class="content tab-pane"
                        id="panel5b">


                        <div
                            class="row">
                            <div
                                class="large-12 columns">
                                <?php

                                $applicant_detail = $applicant;
                                $this->set(compact('applicant_detail'));
                                echo $this->element('billing/billing_new');
                                ?>


                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>