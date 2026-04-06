<?php 
header ("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls" );
header ("Content-Description: Exported as XLS" );
?>

<style>
    table {
        border-collapse: collapse;
        text-align: center;
        width: 100%;
        /* border: 1px solid #000; */
    }
    th, td {
        /* border: 1px solid #000; */
        /* padding: 5px; */
        text-align: left; /* Aligns text naturally */
        white-space: nowrap; /* Prevents text wrapping */
    }
    thead tr {
        background-color: #f2f2f2;
        /* border-bottom: 2px solid #000; */
    }
    thead th {
        background-color: #d9edf7;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>

<?php
if (isset($studentListForExitExam) && !empty($studentListForExitExam)) {
    foreach ($studentListForExitExam as $program => $programType) {
        foreach ($programType as $programTypeName => $statDetail) { ?>
            <br />
            <p class="fs16">
                <strong> Program : </strong>
                <strong><?= $program; ?></strong><br />
                <strong> Program Type: </strong>
                <strong><?= $programTypeName; ?></strong><br />
            </p>

            <table cellpadding="0" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th class="center">#</th>
                        <th class="vcenter">First Name</th>
                        <th class="vcenter">Middle Name</th>
                        <th class="vcenter">Last Name</th>
                        <th class="center">Sex</th>
                        <th class="vcenter">Student ID</th>
                        <th class="vcenter">College</th>
                        <th class="vcenter">Department</th>
                        
                        <th class="vcenter">Study Program</th>
                        <th class="center">Study Program CODE</th>
                        <th class="center">Band</th>

                        <?php
                        if ((isset($get_extended_report_for_exit_exam) && $get_extended_report_for_exit_exam) || (isset($this->request->data['Report']['get_extended_report_for_exit_exam']) && $this->request->data['Report']['get_extended_report_for_exit_exam'])) { ?>
                            <th class="vcenter">Degree Nomenclature</th>
                            <th class="vcenter">Specialization</th>
                            <th class="center">Credit Type</th>
                            <th class="center">Required Min Credit</th>
                            <th class="center">Curriculum Courses</th>
                            <th class="center">Taken courses</th>
                            <th class="center">Taken Credit</th>
                            <th class="center">Registered courses</th>
                            <th class="center">Registered Credit</th>
                            <th class="center">Added courses</th>
                            <th class="center">Added Credit</th>
                            <th class="center">Dropped courses</th>
                            <th class="center">Dropped Credit</th>
                            <th class="center">Exempted courses</th>
                            <th class="center">Exempted Credit</th>
                            <th class="center">Credit Remaining</th>
                            <?php
                        } else { ?>
                            <th class="vcenter">Degree Nomenclature</th>
                            <th class="center">Credit Type</th>
                            <th class="center">Required Min Credit</th>
                            <?php
                        } ?>

                        <th class="center">Year</th>
                        <th class="center">SGPA</th>
                        <th class="center">CGPA</th>
                        <th class="vcenter">Status</th>
                        <th class="center">Bith Date</th>
                        <th class="vcenter">Region</th>
                        <th class="vcenter">Zone</th>
                        <th class="vcenter">woreda</th>
                        <th class="vcenter">City</th>
                        <th class="vcenter">Email</th>
                        <th class="vcenter">Mobile</th>
                        <th class="center">FAYDA FIN</th>
                        <th class="center">FAYDA FAN</th>
                        <th class="center">TIN</th>
                        <th class="center">Student National ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($statDetail as $in => $val) {
                        if (!empty($val['Curriculum']['id'])) {
                            $row_style = ' ';
                        } else {
                            $row_style = ' style="color: red;" ';
                        }  ?>
                        <tr>
                            <td class="center"><?= ++$count; ?></td>
                            <td class="vcenter"><?= $val['Student']['first_name']; ?></td>
                            <td class="vcenter"><?= $val['Student']['middle_name']; ?></td>
                            <td class="vcenter"><?= $val['Student']['last_name']; ?></td>
                            <td <?= $row_style; ?> class="center"><?= ((strcasecmp(trim($val['Student']['gender']), 'male') == 0) ? 'Male' : 'Female'); ?></td>
                            <td <?= $row_style; ?> class="vcenter"><?= $val['Student']['studentnumber']; ?></td>
                            <td <?= $row_style; ?> class="vcenter"><?= ((isset($val['College']['name']) && !empty($val['College']['name'])) ? $val['College']['name'] : ''); ?></td>
                            <td class="vcenter"><?= ((isset($val['Department']['name']) && !empty($val['Department']['name'])) ? $val['Department']['name'] : 'N/A'); ?></td>
                            
                            <td class="vcenter"><?= ((isset($val['Curriculum']['DepartmentStudyProgram']['id']) && !empty($val['Curriculum']['DepartmentStudyProgram']['StudyProgram']['study_program_name'])) ? trim($val['Curriculum']['DepartmentStudyProgram']['StudyProgram']['study_program_name']) : 'N/A'); ?></td>
                            <td class="center"><?= ((isset($val['Curriculum']['DepartmentStudyProgram']['id']) && !empty($val['Curriculum']['DepartmentStudyProgram']['StudyProgram']['code'])) ? $val['Curriculum']['DepartmentStudyProgram']['StudyProgram']['code'] : 'N/A'); ?></td>
                            <td class="center"><?= ((isset($val['Curriculum']['DepartmentStudyProgram']['id']) && !empty($val['Curriculum']['DepartmentStudyProgram']['StudyProgram']['local_band'])) ? trim($val['Curriculum']['DepartmentStudyProgram']['StudyProgram']['local_band']) : 'N/A'); ?></td>

                            <?php
                            if ((isset($get_extended_report_for_exit_exam) && $get_extended_report_for_exit_exam) || (isset($this->request->data['Report']['get_extended_report_for_exit_exam']) && $this->request->data['Report']['get_extended_report_for_exit_exam'])) { ?>
                                <td class="vcenter"><?= ((isset($val['Curriculum']['english_degree_nomenclature']) && !empty($val['Curriculum']['english_degree_nomenclature'])) ?  trim($val['Curriculum']['english_degree_nomenclature']) : '---'); ?></td>
                                <td class="vcenter"><?= ((isset($val['Curriculum']['specialization_english_degree_nomenclature']) && !empty($val['Curriculum']['specialization_english_degree_nomenclature'])) ? trim($val['Curriculum']['specialization_english_degree_nomenclature']) : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Curriculum']['type_credit']) && !empty($val['Curriculum']['type_credit'])) ? $val['Curriculum']['type_credit'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Curriculum']['minimum_credit_points']) && !empty($val['Curriculum']['minimum_credit_points'])) ? $val['Curriculum']['minimum_credit_points'] : '---'); ?></td>
                                <td class="center"><?= (isset($val['Student']['taken']['curriculum_major_course_count']) ? $val['Student']['taken']['curriculum_major_course_count'] + $val['Student']['taken']['curriculum_minor_course_count'] : 0); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['taken_course_count']) && $val['Student']['taken']['taken_course_count'] != 0) ? $val['Student']['taken']['taken_course_count'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['credit_sum']) && $val['Student']['taken']['credit_sum'] != 0) ? $val['Student']['taken']['credit_sum'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['course_count_registration']) && $val['Student']['taken']['course_count_registration'] != 0) ? $val['Student']['taken']['course_count_registration'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['credit_sum_registration']) && $val['Student']['taken']['credit_sum_registration'] != 0) ? $val['Student']['taken']['credit_sum_registration'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['course_count_add']) && $val['Student']['taken']['course_count_add'] != 0) ? $val['Student']['taken']['course_count_add'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['credit_sum_add']) && $val['Student']['taken']['credit_sum_add'] != 0) ? $val['Student']['taken']['credit_sum_add'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['droped_courses_count']) && $val['Student']['taken']['droped_courses_count'] != 0) ? $val['Student']['taken']['droped_courses_count'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['droped_credit_sum']) && $val['Student']['taken']['droped_credit_sum'] != 0) ? $val['Student']['taken']['droped_credit_sum'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['exempted_course_count']) && $val['Student']['taken']['exempted_course_count'] != 0) ? $val['Student']['taken']['exempted_course_count'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Student']['taken']['exempted_credit_sum']) && $val['Student']['taken']['exempted_credit_sum'] != 0) ? $val['Student']['taken']['exempted_credit_sum'] : '---'); ?></td>
                                <td class="center">
                                    <?php
                                    if (isset($val['Curriculum']) && isset($val['Curriculum']['minimum_credit_points'])) {
                                        if ($val['Curriculum']['minimum_credit_points'] != 0) {
                                            $remaining_credits = ($val['Student']['taken']['credit_sum'] + $val['Student']['taken']['exempted_credit_sum']) - $val['Curriculum']['minimum_credit_points'];
                                            echo $remaining_credits;
                                        } else {
                                            echo 'Invalid minimun credit point for the curriculum';
                                        }
                                    } else {
                                        echo 'student not attached to curriculum';
                                    } ?>
                                </td>
                                <?php
                            } else { ?>
                                <td class="vcenter"><?= ((isset($val['Curriculum']['english_degree_nomenclature']) && !empty($val['Curriculum']['english_degree_nomenclature'])) ?  trim($val['Curriculum']['english_degree_nomenclature']) : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Curriculum']['type_credit']) && !empty($val['Curriculum']['type_credit'])) ? $val['Curriculum']['type_credit'] : '---'); ?></td>
                                <td class="center"><?= ((isset($val['Curriculum']['minimum_credit_points']) && !empty($val['Curriculum']['minimum_credit_points'])) ? $val['Curriculum']['minimum_credit_points'] : '---'); ?></td>
                                <?php
                            } ?>
                            
                            <td class="center"><?= $val['Student']['yearLevel']; ?></td>
                            <td class="center"><?= $val['StudentExamStatus'][0]['sgpa']; ?></td>
                            <td class="center"><?= $val['StudentExamStatus'][0]['cgpa']; ?></td>
                            <td class="vcenter"><?= (isset($val['StudentExamStatus'][0]['AcademicStatus']['id']) && !empty($val['StudentExamStatus'][0]['AcademicStatus']['name']) ? $val['StudentExamStatus'][0]['AcademicStatus']['name'] : ''); ?></td>
                            <td class="center" style="mso-number-format:'@'; white-space: nowrap;"><?= (isset($val['Student']['birthdate']) && !empty($val['Student']['birthdate']) ? $this->Time->format("M j, Y", $val['Student']['birthdate'], NULL, NULL) : ''); ?></td>
                            <td class="vcenter"><?= ((isset($val['Region']['id']) && !empty($val['Region']['name'])) ? $val['Region']['name'] : 'N/A'); ?></td>
                            <td class="vcenter"><?= ((isset($val['Zone']['id']) && !empty($val['Zone']['name'])) ? $val['Zone']['name'] : ''); ?></td>
                            <td class="vcenter"><?= ((isset($val['Woreda']['id']) && !empty($val['Woreda']['name'])) ? $val['Woreda']['name'] : ''); ?></td>
                            <td class="vcenter"><?= ((isset($val['City']['id']) && !empty($val['City']['name']) && isset($val['Woreda']['id']) && !empty($val['Woreda']['name'])) ? $val['City']['name'] : ''); ?></td>
                            <td class="vcenter"><?= (!empty($val['Student']['email_alternative']) && !empty($val['Student']['email']) && count(explode(INSTITUTIONAL_EMAIL_SUFFIX, $val['Student']['email'])) > 0 ? (strtolower(trim($val['Student']['email_alternative']))) : (strtolower(trim($val['Student']['email'])))); ?></td>
                            <td class="vcenter" style="mso-number-format:'@'; white-space: nowrap;"><?= (!empty($val['Student']['phone_mobile']) ?  $val['Student']['phone_mobile'] : ''); ?></td>
                            <td class="center" style="mso-number-format:'@'; white-space: nowrap;"><?= (!empty($val['Student']['fayda_identification_number']) ? $val['Student']['fayda_identification_number'] : ''); ?></td>
                            <td class="center"  style="mso-number-format:'@'; white-space: nowrap;"><?= (!empty($val['Student']['fayda_alias_number']) ? $val['Student']['fayda_alias_number'] : ''); ?></td>
                            <td class="center"  style="mso-number-format:'@'; white-space: nowrap;"><?= (isset($val['Student']['student_national_id']) && !empty($val['Student']['student_national_id']) ? $val['Student']['student_national_id'] : ''); ?></td>
                        </tr>
                        <?php
                    } ?>
                </tbody>
            </table>
            <hr>
            <?php
        } ?>
        <?php
    }
} ?>