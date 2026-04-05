<div class="row">
    <div class="large-12 columns">
        <?php
        if (isset($comingAcademicCalendarsDeadlines) && !empty($comingAcademicCalendarsDeadlines)) {
            echo '<p class="rejected">';
            $str = '';
            foreach ($comingAcademicCalendarsDeadlines as $k => $v) {
                if ($v['GradeSubmissionDeadline'] > date('Y-m-d') && $v['GradeSubmissionDeadline'] == "0000-00-00") {
                    $str .= 'Grade submission deadline ' . $v['GradeSubmissionDeadline'] . ' ';
                }
            }
            echo $str;
            echo '</p>';
        } ?>
    </div>
</div>

<div class="row" ng-app="dashboardApp">
    <div class="large-4 columns">
        <div class="box">
            <div class="box-header bg-transparent">
                <div class="pull-right box-tools">
                    <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                    <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                </div>
                <h3 class="box-title"><i class="fontello-chat-alt"></i><span>Messages</span></h3>
            </div>

            <?php
            if (($role_id == ROLE_STUDENT && isset($show_notification_message) && $show_notification_message) || $role_id != ROLE_STUDENT) { ?>
                <div ng-init="getAll()" ng-controller="messageController" class="box-body " style="display: block; margin-top: -15px;" id="AutoMessageDashBoard">
                    <loading-ajax> </loading-ajax>
                    <table cellpadding="0" cellspacing="0"  style="width:100%; border:0px;" class="condence table" id="AutoMessage">
                        <tbody>
                            <tr ng-repeat="message in auto_messages | limitTo: paginationLimit() ">
                                <td style="font-size:10px; font-weight:bold; background-color: white;">
                                    <!-- <div>
                                        {{message.AutoMessage.created | dateToISO | date:'medium' }} (<span style="color:red; cursor:url('../img/error.ico'), default" ng-click="deleteMessage(message.AutoMessage.id)"> close</span>)
                                    </div> -->
                                    <div>
                                        {{message.AutoMessage.created | dateToISO | date:'medium' }} ( <span style="color:red; cursor:pointer;" ng-click="deleteMessage(message.AutoMessage.id)"><img src="img/error-icon.gif" style="vertical-align:middle; width:9px; height:9px;" alt="Mark as Read"> close</span>)
                                    </div>
                                    <div style="text-align:justify; font-size:11px; font-weight:bold; background-color: white;" ng-bind-html="$sce.trustAsHtml(message.AutoMessage.message)">

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: white;">
                                    <div class="pagination pagination-centered">
                                        <button class="tiny radius button bg-blue" ng-show="hasMoreItemsToShow()" ng-click="showMoreItems()">Show more</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
            } else if ($role_id == ROLE_STUDENT && isset($show_notification_message) && !$show_notification_message) { ?>
                <div class="box-body " style="display: block; margin-top: -15px;" id="AutoMessageDashBoard">
                    <table cellpadding="0" cellspacing="0"  style="width:100%; border:0px;" class="condence table" id="AutoMessage">
                        <tbody>
                            <tr>
                                <td><hr>Please <a href="studentEvalutionRates/add">evaluate your instructors</a> first before checking your new messages!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
            } ?>
        </div>
    </div>

    <?php 
    if ($role_id == ROLE_STUDENT) { ?>
        <div class="large-4 columns">
            <div class="box" ng-controller="studentRankController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i  class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-graduation-cap "></i><span>Rank</span></h3>
                </div>
                <div class="box-body " style="display: block; margin-top: -15px;" id="StudentRankDashBoard">
                    <loading-ajax> </loading-ajax>
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody ng-if="rank !== null" ng-init="getAll()">
                            <tr ng-repeat="rnk in rank">
                                <td style="font-size:10px; font-weight:bold">

                                    <h6 class="text-black" style="text-align:center"> By CGPA </h6>

                                    <div>
                                        <span>Academic Year/Semester</span>
                                        <span> {{rnk.cgpa.StudentRank.academicyear}}</span>/<span>{{rnk.cgpa.StudentRank.semester}}</span>
                                    </div>

                                    <div class="semesterStand">
                                        <div>
                                            <span>From Section:</span>
                                            <span>{{rnk.cgpa.StudentRank.section_rank}}</span>
                                        </div>
                                        <div>
                                            <span>From Batch:</span>
                                            <span>{{rnk.cgpa.StudentRank.batch_rank}}</span>
                                        </div>
                                        <div>
                                            <span>From College:</span>
                                            <span> {{rnk.cgpa.StudentRank.college_rank}}</span>
                                        </div>
                                    </div>

                                    <h6 class="text-black" style="text-align:center"> By SGPA </h6>

                                    <div>
                                        <span>Academic Year/Semester</span>
                                        <span>{{rnk.sgpa.StudentRank.academicyear}}</span>/<span>{{rnk.sgpa.StudentRank.semester}}</span>
                                    </div>

                                    <div class="semesterStand">
                                        <div>
                                            <span>From Section:</span>
                                            <span>{{rnk.sgpa.StudentRank.section_rank}}</span>
                                        </div>
                                        <div>
                                            <span>From Batch:</span>
                                            <span>{{rnk.sgpa.StudentRank.batch_rank}}</span>
                                        </div>
                                        <div>
                                            <span>From College:</span> 
                                            <span>{{rnk.sgpa.StudentRank.college_rank}}</span>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="large-4 columns">
            <div class="box" ng-controller="studentDormDashBoardController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-home-outline"></i><span>Dorm</span></h3>
                </div>
                <div ng-if="dormAssignedStudent.Dormitory !== null" ng-init="getAll()" class="box-body " style="display: block; margin-top: -15px;" id="StudentDormDashBoard">
                    <loading-ajax> </loading-ajax>
                    <div style="margin:0" class="row summary-border-top">
                        <div class="large-12 columns">
                            <div class="school-timetable">
                                <h6><i class=" fontello-home-outline"></i> Block <span class="bg-blue">{{dormAssignedStudent.Dormitory.DormitoryBlock.block_name}}</span></h6>
                                <h6><i class=" fontello-home-outline"></i> Floor <span class="bg-blue">{{dormAssignedStudent.Dormitory.floor}}</span></h6>
                                <h6><i class=" fontello-home-outline"></i> Room <span class="bg-green">{{dormAssignedStudent.Dormitory.dorm_number}}</span></h6>
                                <h6><i class=" fontello-home-outline"></i> Capacity <span class="bg-blue">{{ dormAssignedStudent.Dormitory.capacity }}</span></h6>
                                <a href="#" data-animation='fade' data-reveal-id='myModalUpgrade' data-reveal-ajax='/dormitoryAssignments/getAssignedStudent/{{dormAssignedStudent.Dormitory.id}}'> Room mates </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
    } ?>

    <?php 
    if ($role_id == ROLE_COLLEGE || $role_id == ROLE_DEPARTMENT || $role_id == ROLE_REGISTRAR ) { ?>
        <div class="large-4 columns">
            <div class="box" ng-controller="gradeChangeController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-check"></i><span>Grade Change Approval</span></h3>
                </div>

                <div class="box-body " style="display: block; margin-top: -15px;" id="GradeChangeApproval">
                    <loading-ajax> </loading-ajax>
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody ng-init="getAll()">
                            <tr ng-if="isNotZeroOrUndefined(exam_grade_change_requests)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_department_grade_change">
                                        You have {{exam_grade_change_requests}} grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(exam_grade_changes_for_college_approval)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_college_grade_change">
                                        You have {{exam_grade_changes_for_college_approval}} grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(makeup_exam_grades)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_department_grade_change">
                                        You have {{makeup_exam_grades}} makeup exam approval requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(rejected_makeup_exams)">
                                <td class="rejected">
                                    <a ng-href="/exam_grade_changes/manage_department_grade_change">
                                        <!-- You have {{rejected_makeup_exams}} rejected makeup exam grades. -->
                                        You have {{rejected_makeup_exams}} rejected makeup exam grades.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(rejected_supplementary_exams)">
                                <td class="rejected">
                                    <a ng-href="/exam_grade_changes/manage_department_grade_change">
                                        <!-- You have {{rejected_supplementary_exams}} rejected supplementary exam grades. -->
                                        You have rejected supplementary exam grades.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(fm_exam_grade_change_requests)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_freshman_grade_change">
                                        You have {{fm_exam_grade_change_requests}} freshman grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(fm_makeup_exam_grades)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_freshman_grade_change">
                                        You have {{fm_makeup_exam_grades}} freshman makeup grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(fm_rejected_makeup_exams)">
                                <td class="rejected">
                                    <a ng-href="/exam_grade_changes/manage_freshman_grade_change">
                                        <!-- You have {{fm_rejected_makeup_exams}} rejected freshman makeup grade change requests -->
                                        You have rejected freshman makeup grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(fm_rejected_supplementary_exams)">
                                <td class="rejected">
                                    <a ng-href="/exam_grade_changes/manage_freshman_grade_change">
                                        <!-- You have {{fm_rejected_supplementary_exams}} rejected supplementary grade change requests -->
                                        You have rejected supplementary grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(reg_exam_grade_change_requests)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_registrar_grade_change">
                                        You have {{reg_exam_grade_change_requests}} grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(reg_makeup_exam_grades)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_registrar_grade_change">
                                        You have {{reg_makeup_exam_grades}} makeup grade change requests
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="isNotZeroOrUndefined(reg_supplementary_exam_grades)">
                                <td>
                                    <a ng-href="/exam_grade_changes/manage_registrar_grade_change">
                                        You have {{reg_supplementary_exam_grades}} supplementary grade change requests
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
    } ?>


    <?php 
    if ($role_id == ROLE_COLLEGE || $role_id == ROLE_DEPARTMENT || $role_id == ROLE_REGISTRAR) { ?>
        <div class="large-4 columns">
            <div class="box" id="gradeBox">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-check"></i><span>Grade Approval/Confirmation</span></h3>
                </div>
                <loading-ajax> </loading-ajax>

                <div class="box-body" style="display: block; margin-top: -15px;" id="GradeConfiramationApproval" ng-controller="gradeApprovalConfirmation">
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tr ng-repeat="grade in courses_for_dpt_approvals | startFrom:currentPage*pageSize | limitTo:pageSize">
                            <td>
                                <a ng-href="/exam_grades/approve_non_freshman_grade_submission/{{grade.PublishedCourse.id}}">
                                    Instructor: {{grade.CourseInstructorAssignment[0].Staff.Title.title}}. {{grade.CourseInstructorAssignment[0].Staff.full_name}} <br />
                                    Course: {{grade.Course.course_title}} ({{ grade.Course.course_code }}) <br /> 
                                    Department: {{grade.Department.name}} {{grade.College.name}} <br />
                                    Section: {{grade.Section.name}} <br />
                                    <!-- Year Level: {{grade.YearLevel.name }} <br /> -->
                                    Year Level: {{(grade.YearLevel.name ? grade.YearLevel.name : 'Pre/Freshman') }} <br />
                                    Program: {{grade.Program.name }} <br />
                                    ProgramType: {{grade.ProgramType.name }} <br />
                                    Academic Year: {{grade.PublishedCourse.academic_year}} <br />
                                    Semester: {{grade.PublishedCourse.semester}} <br />
                                </a>
                            </td>
                        </tr>
                    </table>

                    <?php 
                    if ($role_id == ROLE_DEPARTMENT ) {?>
                        <table ng-show="courses_for_dpt_approvals.length == 0 " cellpadding="0" cellspacing="0" class="table">
                            <tr>
                                <td>
                                    <a href="/examGrades/approve_non_freshman_grade_submission"> Check grade submissions prior to <?= $acy_ranges_by_coma_quoted_for_display?></a>
                                </td>
                            </tr>
                        </table>
                        <?php
                    } ?>

                    <?php 
                    if ($role_id == ROLE_REGISTRAR ) {?>
                        <table ng-show="courses_for_registrar_approval.length == 0" cellpadding="0" cellspacing="0" class="table">
                            <tr>
                                <td>
                                    <a href="/examGrades/confirm_grade_submission"> Check grade submissions prior to <?= $acy_ranges_by_coma_quoted_for_display?></a>
                                </td>
                            </tr>
                        </table>
                        <?php
                    } ?>

                    <div class="pagination-centered" ng-show="courses_for_dpt_approvals.length > 0">
                        <br>
                        <ul class="pagination">
                            <li class="arrow">
                                <button type="button" class="tiny radius button bg-blue" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1"> &lt; PREV</button>
                            </li>
                            <li>
                                <span>{{currentPage+1}} of {{ numberOfPages()}}</span>
                            </li>
                            <li class="arrow">
                                <button class="tiny radius button bg-blue" ng-disabled="currentPage >= courses_for_dpt_approvals.length/pageSize-1" ng-click="currentPage=currentPage+1">NEXT &gt;</button>
                            </li>
                        </ul>
                    </div>

                    <table ng-show="courses_for_registrar_approval.length > 0" cellpadding="0" cellspacing="0" class="table">
                        <tr ng-repeat="grade in courses_for_registrar_approval | startFrom:currentPage*pageSize | limitTo:pageSize">
                            <td>
                                <a ng-href="/exam_grades/confirm_grade_submission/{{grade.PublishedCourse.id}}">
                                    Instructor: {{grade.CourseInstructorAssignment[0].Staff.Title.title}}. {{grade.CourseInstructorAssignment[0].Staff.full_name}} <br />
                                    Course: {{grade.Course.course_title}} ({{ grade.Course.course_code }}) <br />
                                    Department: {{grade.Department.name}} {{grade.College.name}} <br /> 
                                    Section: {{grade.Section.name}} <br />
                                    <!-- Year Level: {{grade.YearLevel.name }} <br /> -->
                                    Year Level: {{(grade.YearLevel.name ? grade.YearLevel.name : 'Pre/Freshman') }} <br />
                                    Academic Year: {{grade.PublishedCourse.academic_year}} <br />
                                    Semester: {{grade.PublishedCourse.semester}} <br />
                                </a>
                            </td>
                        </tr>
                    </table>

                    <div class="pagination-centered" ng-show="courses_for_registrar_approval.length > 0">
                        <br>
                        <ul class="pagination">
                            <li class="arrow">
                                <button type="button" class="tiny radius button bg-blue" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1"> &lt; PREV</button>
                            </li>
                            <li>
                                <span>{{currentPage+1}} of {{ numberOfPages()}}</span>
                            </li>
                            <li class="arrow">
                                <button class="tiny radius button bg-blue" ng-disabled="currentPage >= courses_for_registrar_approval.length/pageSize - 1 " ng-click="currentPage=currentPage+1">NEXT &gt;</button>
                            </li>
                        </ul>
                    </div>

                    <table ng-show="courses_for_freshman_approvals.length > 0" cellpadding="0" cellspacing="0" class="table">
                        <tr ng-repeat="grade in courses_for_freshman_approvals | startFrom:currentPage*pageSize | limitTo:pageSize  ">
                            <td>
                                <a ng-href="/exam_grades/approve_freshman_grade_submission/{{grade.PublishedCourse.id}}">
                                    Instructor: {{grade.CourseInstructorAssignment[0].Staff.Title.title}} {{grade.CourseInstructorAssignment[0].Staff.full_name}} <br />
                                    Course: {{grade.Course.course_title}}. ({{ grade.Course.course_code }}) <br />
                                    Department: {{grade.Department.name}} {{grade.College.name}} <br />
                                    Section: {{grade.Section.name}} <br />
                                    <!-- Year Level: Pre/1st <br /> -->
                                    Year Level: {{(grade.YearLevel.name ? grade.YearLevel.name : 'Pre/Freshman') }} <br />
                                    Program: {{grade.Program.name }} <br />
                                    ProgramType: {{grade.ProgramType.name }} <br />
                                    Academic Year: {{grade.PublishedCourse.academic_year}} <br />
                                    Semester: {{grade.PublishedCourse.semester}} <br />
                                </a>
                            </td>
                        </tr>
                    </table>

                    <div class="pagination-centered" ng-show="courses_for_freshman_approvals.length > 0 ">
                        <br>
                        <ul class="pagination">
                            <li class="arrow">
                                <button type="button" class="tiny radius button bg-blue" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1"> &lt;  PREV</button>
                            </li>
                            <li>
                                <span>{{currentPage+1}} of {{ numberOfPages()}}</span>
                            </li>
                            <li class="arrow">
                                <button class="tiny radius button bg-blue" ng-disabled="currentPage >=courses_for_freshman_approvals.length/pageSize - 1 " ng-click="currentPage=currentPage+1">NEXT &gt;</button>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <?php 
    } ?>

    <?php 
    if ($role_id == ROLE_DEPARTMENT/*  || $role_id == ROLE_INSTRUCTOR */) { ?>
        <div class="large-4 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-check"></i><span>Dispatched Courses</span></h3>
                </div>

                <div class="box-body" style="display: block; margin-top: -15px;" id="DispatchedAndAssignedCourseID" ng-controller="dispatchedNotYetAssignedCourseController">
                    <loading-ajax> </loading-ajax>
                    <span ng-if="dispatched_course_list.length > 0"><strong class="fs-12 text-gray">Courses without Instructor assignment</strong><br></span><br>

                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody>
                            <tr ng-repeat="course in dispatched_course_list | startFrom:currentPage*pageSize | limitTo:pageSize">
                                <td>
                                    <a ng-href="/course_instructor_assignments/assign_course_instructor/{{course.PublishedCourse.id}}">
                                        <strong>Dispatched to: </strong> {{course.GivenByDepartment.name}} <br />
                                        <strong>From: </strong> {{course.Department.name}} {{course.College.name}} <br />
                                        <strong>Course: </strong> {{course.Course.course_title}} ({{course.Course.course_code}}) <br />
                                        <strong>Section: </strong> {{course.Section.name}} ({{course.Department.name}}{{course.College.name}}) <br />
                                        <strong>Program: </strong> {{course.Program.name}} - {{course.ProgramType.name}} <br />
                                        <strong>ACY/Semester: </strong> {{course.PublishedCourse.academic_year}} - {{course.PublishedCourse.semester}} <br />
                                    </a>
                                </td>
                            </tr>
                            <tr ng-repeat="course in dispatched_course_not_assigned | startFrom:currentPage*pageSize | limitTo:pageSize">
                                <td>
                                    <strong>Dispatched to: </strong> {{course.GivenByDepartment.name}} <br />
                                    <strong>Course: </strong> {{course.Course.course_title}} ({{course.Course.course_code}}) <br />
                                    <strong>Section: </strong> {{course.Section.name}} ({{course.Department.name}}{{course.College.name}}) <br />
                                    <strong>Program: </strong> {{course.Program.name}} - {{course.ProgramType.name}} <br />
                                    <strong>ACY/Semester: </strong> {{course.PublishedCourse.academic_year}} - {{course.PublishedCourse.semester}} <br />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>

                    <div class="pagination-centered">
                        <ul class="pagination" ng-show="dispatched_course_list.length > 0 || dispatched_course_not_assigned.length > 0">
                            <li class="arrow">
                                <button type="button" class="tiny radius button bg-blue" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage - 1"> &lt; PREV</button>
                            </li>
                            <li>
                                <span>{{currentPage + 1}} of {{ numberOfPages()}}</span>
                            </li>
                            <li class="arrow">
                                <button ng-show="dispatched_course_list.length > 0 && dispatched_course_not_assigned.length == 0" class="tiny radius button bg-blue" ng-disabled="currentPage >= dispatched_course_list.length/pageSize -1"  ng-click="currentPage=currentPage + 1">NEXT &gt; </button>
                                <button ng-show="dispatched_course_not_assigned.length > 0 && dispatched_course_list.length == 0" class="tiny radius button bg-blue" ng-disabled="currentPage >=dispatched_course_not_assigned.length/pageSize -1" ng-click="currentPage=currentPage + 1">NEXT &gt; </button>
                                <button ng-show="dispatched_course_not_assigned.length > 0 && dispatched_course_list.length > 0" class="tiny radius button bg-blue" ng-disabled="currentPage>=dispatched_course_not_assigned.length/pageSize -1" ng-click="currentPage=currentPage + 1">NEXT &gt; </button>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <?php 
    } ?>

    <?php 
    if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_REGISTRAR || $role_id == ROLE_COLLEGE) { ?>
        <div class="large-4 columns">
            <div class="box" ng-controller="addDropRequestController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-check"></i><span>Course Add/Drop Requests</span></h3>
                </div>

                <div class="box-body " style="display: block; margin-top: -15px;" id="AddDropRequest">
                    <loading-ajax> </loading-ajax>
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody>
                            <tr>
                                <?php
                                if ($role_id == ROLE_REGISTRAR) { ?>
                                    <td ng-show="add_request">
                                        <a ng-show="add_request > 0" ng-href="/course_adds/approve_adds">
                                            You have {{add_request}} Course Add requests which are approved by department and waiting your confirmation.
                                        </a>
                                    </td>
                                    <td ng-if="add_request == 0">
                                        There is no Course Add request that needs your approval for now.
                                    </td>
                                    <?php
                                } else { ?>
                                    <td ng-show="add_request_dpt">
                                        <a ng-show="add_request_dpt > 0" ng-href="/course_adds/approve_adds">
                                            You have {{add_request_dpt}} Course Add requests from your students waiting your approval.
                                        </a>
                                    </td>
                                    <td ng-if="add_request_dpt == 0">
                                        There is no Course Add request that needs your approval for now.
                                    </td>
                                    <?php
                                } ?>
                            </tr>
                            <!-- <tr ng-show="drop_request_dpt > 0 || drop_request > 0"> -->
                            <tr>
                                <?php
                                 if ($role_id == ROLE_REGISTRAR) { ?>
                                    <td ng-show="drop_request">
                                        <a ng-href="/course_drops/approve_drops">
                                            You have {{drop_request}} course drop request approved by department and waiting your confirmation.
                                        </a>
                                    </td>
                                    <td ng-if="drop_request == 0">There is no drop request that needs your approval for now.</td>
                                    <?php
                                } else { ?>
                                    <td ng-show="drop_request_dpt">
                                        <a ng-show="drop_request_dpt > 0" ng-href="/course_drops/approve_drops">
                                            You have {{drop_request_dpt}} course drop request from your students waiting for approval.
                                        </a>
                                    </td>
                                    <td ng-if="drop_request_dpt == 0">There is no drop request that needs your approval for now.</td>
                                    <?php
                                } ?>
                            </tr>
                            <?php
                            if ($role_id == ROLE_REGISTRAR) { ?>
                                <tr>
                                    <td ng-show="forced_drops">
                                        <a ng-href="/course_drops/forced_drop">You have students that need forced drop. </a>
                                    </td>
                                    <td ng-if="forced_drops == 0"> You don't have any student that need forced drop for now.</td>
                                </tr>
                                <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
    } ?>

    <?php 
    if (/* $role_id == ROLE_COLLEGE ||  $role_id == ROLE_DEPARTMENT || */ $role_id == ROLE_REGISTRAR) { ?>
        <div class="large-4 columns">
            <div class="box" ng-controller="clearnceWithdrawSubController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-check"></i><span>Clearnce/Withdraw Requests</span></h3>
                </div>

                <div class="box-body " style="display: block; margin-top: -15px;" id="ClearnceAndWithdraw">
                    <loading-ajax> </loading-ajax>
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody>
                            <?php
                            if ($role_id == ROLE_REGISTRAR) { ?>
                                <tr ng-if="clearance_request>0 && isNotZeroOrUndefined(clearance_request)">
                                    <td>
                                        <a ng-href="/clearances/approve_clearance">
                                            You have {{clearance_request}} clearance/withdraw requests that needs your approval
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                            <tr ng-if="exemption_request>0 && isNotZeroOrUndefined(exemption_request)">
                                <td style="background-color: white;">
                                    <a ng-href="/courseExemptions/list_exemption_request">
                                        You have {{exemption_request}} exemption requests that needs your approval
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="substitution_request>0 && isNotZeroOrUndefined(substitution_request)">
                                <td style="background-color: white;">
                                    <a ng-href="/CourseSubstitutionRequests/approve_substitution">
                                        You have {{substitution_request}} course substitution requests that needs your approval
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
    } ?>

    <?php 
    if ($role_id == ROLE_SYSADMIN) { ?>
        <div class="large-4 columns">
            <div class="box" ng-controller="backupController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-check"></i><span>Backup/Voting Request</span></h3>
                </div>

                <div class="box-body " style="display: block; margin-top: -15px;" id="BackupAccountRequest">
                    <loading-ajax> </loading-ajax>
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody>
                            <tr ng-repeat="backup in latest_backups | startFrom:currentPage*pageSize | limitTo:pageSize">
                                <td> {{backup.Backup.created | dateToISO | date:'medium'}} </td>
                                <td>
                                    <a ng-if="backup.Backup.file_exists" ng-href="/backups/index/{{backup.Backup.id}}"> Download </a>
                                    <div ng-if="!backup.Backup.file_exists"> Not Available </div>
                                </td>
                            </tr>
                            <tr ng-if="password_reset_confirmation_request">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        You have {{ password_reset_confirmation_request }} password reset confirmation requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="admin_cancelation_confirmation_request">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        You have {{ admin_cancelation_confirmation_request }} administrator cancellation confirmation requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="admin_assignment_confirmation_request">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        You have {{ admin_assignment_confirmation_request}} administrator assignment confirmation requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="confirmed_taskss">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        There are {{confirmed_taskss}} confirmed tasks by other system administrators.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="role_change_confirmation_request">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        You have {{ role_change_confirmation_request}} role change requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="deactivation_confirmation_request">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        You have {{deactivation_confirmation_request}} user account deactivation requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="activation_confirmation_request">
                                <td colspan="2">
                                    <a ng-href="/users/task_confirmation/">
                                        You have {{activation_confirmation_request}} user account activation requests.
                                    </a>
                                </td>
                            </tr>
                            <tr ng-if="latest_backups">
                                <td colspan="2" class="utils">
                                    <a ng-href="/backups/index"> View More </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
    } ?>

    <?php
    if ($role_id == ROLE_REGISTRAR /* || $this->Session->read('Auth.User')['Role']['parent_id'] == ROLE_REGISTRAR */) { ?>
        <div class="large-4 columns">
            <div class="box"
                ng-controller="profileNotCompleteController">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-contacts"></i><span>Student Profile(Not Complete)</span></h3>
                </div>
                <div class="box-body "  style="display: block; margin-top: -15px;" id="ProfileNotComplete">
                    <loading-ajax>  </loading-ajax>
                    <table cellpadding="0" cellspacing="0" class="table">
                        <tbody>
                            <tr ng-if="profile_not_buildc">
                                <td>
                                    <a ng-href="/students/profile_not_build_list"> {{profile_not_buildc}} students profile is not complete. Please complete their profile.</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php 
    } ?>

    <div class="large-4 columns">
        <div class="box">
            <div class="box-header bg-transparent">
                <div class="pull-right box-tools">
                    <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                    <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                </div>
                <h3 class="box-title"><i class="icon-view-list"></i><span>Events</span></h3>
            </div>
            <div class="box-body " style="display: block; margin-top: -15px;" id="AcademicCalender">

            </div>
        </div>
    </div>
</div>

<?php 
if ($role_id == ROLE_STUDENT || $role_id == ROLE_INSTRUCTOR) { ?>
    <div class="row">
        <div class="large-12 columns">
            <div class="box">
                <div class="box-header bg-transparent">
                    <div class="pull-right box-tools">
                        <span class="box-btn" data-widget="collapse"><i class="icon-minus"></i></span>
                        <!-- <span class="box-btn" data-widget="remove"><i class="icon-cross"></i></span> -->
                    </div>
                    <h3 class="box-title"><i class="fontello-calendar-1"></i><span>Calendar</span></h3>
                </div>

                <div class="box-body" style="display: block;" id="CourseSchedule">
                    <div class="row">
                        <?php
                        if (isset($calendar) && !empty($calendar)) {
                            if (!empty($calendar)) { 
                                foreach ($calendar as $caldar) { ?>
                                    <div class="large-6 columns">
                                        <div style="overflow-x:auto;">
                                            <table cellpadding="0" cellspacing="0" class="table">
                                                <tr>
                                                    <td class="vcenter">Academic Year</td>
                                                    <td class="vcenter"><?= $caldar['academic_year']; ?></td>
                                                    <td class="vcenter">Semester</td>
                                                    <td class="vcenter"><?= $caldar['semester']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Program</td>
                                                    <td class="vcenter"><?= $caldar['calendarDetail']['Program']['name']; ?></td>
                                                    <td class="vcenter">Program Type</td>
                                                    <td class="vcenter"><?= $caldar['calendarDetail']['ProgramType']['name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Department</td>
                                                    <td class="vcenter" colspan="3"><?= $caldar['departmentname']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Year Level</td>
                                                    <td class="vcenter" colspan="3">
                                                        <?php
                                                        if (is_array($caldar['yearlevel']) && !empty($caldar['yearlevel'])) { ?>
                                                            <ul>
                                                                <?php
                                                                foreach ($caldar['yearlevel'] as $ky => $kv) { ?>
                                                                    <li><?= $kv; ?></li>
                                                                    <?php 
                                                                } ?>
                                                            </ul>
                                                            <?php
                                                        } else if (!empty($caldar['yearlevel'])) {
                                                            echo $caldar['yearlevel'];
                                                        } else {
                                                            echo '';
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Course Registration: </td>
                                                    <td class="vcenter" colspan="3"><?= $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['course_registration_start_date'], NULL, NULL) . ' - ' . $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['course_registration_end_date'], NULL, NULL); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Course Add: </td>
                                                    <td class="vcenter" colspan="3"><?= $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['course_add_start_date'], NULL, NULL) . ' - ' . $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['course_add_end_date'] , NULL, NULL); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Course Drop: </td>
                                                    <td class="vcenter" colspan="3"><?= $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['course_drop_start_date'], NULL, NULL) . ' - ' . $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['course_drop_end_date'], NULL, NULL); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="vcenter">Grade Submission: </td>
                                                    <td class="vcenter" colspan="3"><?= $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['grade_submission_start_date'], NULL, NULL) . ' - ' . $this->Time->format("M j, Y", $caldar['calendarDetail']['AcademicCalendar']['grade_submission_end_date'], NULL, NULL); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else { ?>
                                <!-- <p>There is no academic calendar defined for now.</p> -->
                                <?php
                            } 
                        }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
} ?>

<div class="row">
    <div class="large-12 columns">
        <div id="myModalUpgrade" class="reveal-modal" data-reveal>

        </div>
    </div>
</div>

<?php 
if ($role_id == ROLE_STUDENT && isset($dashboardNotificationModalContent) && !empty($dashboardNotificationModalContent)) { ?>
    <div id="myModalDashboadNotification" class="reveal-modal small" data-reveal>
        <div class="box">
            <div class="box-header bg-transparent">
                <div class="box-title" style="margin-top: 10px;">
                    <i class="fontello-bell <?= (isset($dashboardNotificationModalContent['alertHeaderColor']) ? $dashboardNotificationModalContent['alertHeaderColor'] : 'text-red'); ?>" style="font-size: x-large; font-weight: bold;"></i>
                    <span style="font-size: medium; font-weight: bold; margin-top: 20px;" class="<?= (isset($dashboardNotificationModalContent['alertHeaderColor']) ? $dashboardNotificationModalContent['alertHeaderColor'] : 'text-red'); ?>">
                        <?= $dashboardNotificationModalContent['notification_header'] ?>
                    </span>
                </div>
                <!-- <a class="close-reveal-modal">&#215;</a> -->
            </div>

            <div class="box-body" style="padding-bottom: 0px;">
                <div class="row">
                    <div style="margin-top: -30px;">
                        <hr>
                    </div>
                    <div class="modal-content">
                        <blockquote>
                            <h6 style="text-align: justify;"><span class="fs16"><?= $dashboardNotificationModalContent['notification_content']; ?></span></h6>
                        </blockquote>
                        <?php
                        if (isset($dashboardNotificationModalContent['required_courses_list']) && !empty($dashboardNotificationModalContent['required_courses_list'])) { ?>
                            <fieldset style="margin-bottom: 0px; padding-bottom: 0px;">
                                <legend> &nbsp; &nbsp; Required Courses &nbsp; &nbsp; </legend>
                                <?php
                                foreach ($dashboardNotificationModalContent['required_courses_list'] as $reqCourseList) {
                                    if (isset($dashboardNotificationModalContent['withDetails']) && $dashboardNotificationModalContent['withDetails']) { 
                                        if (is_array($reqCourseList)) { ?>
                                            <ul style="line-height: 1;">
                                                <li><?= $reqCourseList['course'] . ' - ' . $reqCourseList['status']; ?></li>
                                            </ul>
                                            <?php
                                        }
                                    } else { ?>
                                        <ul style="line-height: 1;">
                                            <li><?= $reqCourseList; ?></li>
                                        </ul>
                                        <?php
                                    }
                                } ?>
                                <?= isset($dashboardNotificationModalContent['required_courses_list']['lastImportedUpdated']) ? '<div style="margin: 5px;"> Last Updated: <b>' . (date('M d, Y h:i A', strtotime($dashboardNotificationModalContent['required_courses_list']['lastImportedUpdated']))) . '</b></div>' : (isset($dashboardNotificationModalContent['required_courses_list']['lastImportedDate']) ? '<div style="margin: 5px;"> Last Updated: <b>' . (date('M d, Y h:i A', strtotime($dashboardNotificationModalContent['required_courses_list']['lastImportedDate']))) . '</b></div>' : ''); ?>
                            </fieldset>
                            <hr>
                            <?php
                        } ?>

                        <?= (isset($dashboardNotificationModalContent['notification_footer']) && !empty($dashboardNotificationModalContent['notification_footer']) ? '<h6 class="text-gray fs14">'. $dashboardNotificationModalContent['notification_footer'] . '</h6>' : ''); ?>
                        <?= (isset($dashboardNotificationModalContent['additional_notification_footer_URL_1']) && !empty($dashboardNotificationModalContent['additional_notification_footer_URL_1']) ? '<hr><h6 class="text-gray fs14">'. $dashboardNotificationModalContent['additional_notification_footer_URL_1'] . '</h6>' : ''); ?>
                        <?= (isset($dashboardNotificationModalContent['additional_notification_footer_URL_2']) && !empty($dashboardNotificationModalContent['additional_notification_footer_URL_2']) ? '<hr><h6 class="text-gray fs14">'. $dashboardNotificationModalContent['additional_notification_footer_URL_2'] . '</h6>' : ''); ?>
                    </div>
                    <hr>
                    <div class="modal-footer" style="text-align: center; margin-top: 20px; margin-bottom: 0px;">
                        <button id="closeModal" class="tiny radius button bg-light-blue-gradient">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myModalDashboadNotification').foundation('reveal', 'open');

            $('#closeModal').click(function() {
                $('#myModalDashboadNotification').foundation('reveal', 'close');
            });
        });
    </script>
    <?php 
} ?>