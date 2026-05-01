<script type="text/javascript">
    function toggleViewFullId(id) {
        if ($('#' + id).css("display") == 'none') {
            $('#' + id + 'Img').attr("src", '/img/minus2.gif');
            $('#' + id + 'Txt').empty().append('Hide Filter');
        } else {
            $('#' + id + 'Img').attr("src", '/img/plus2.gif');
            $('#' + id + 'Txt').empty().append('Display Filter');
        }
        $('#' + id).toggle("slow");
    }

    $(document).ready(function () {
        $("#PublishedCourse").change(function () {
            var pc = $(this).val();
            $("#ExamTypeAssignmentDiv").empty();

            if (!pc) {
                $("#ExamTypeAssignmentDiv").html('<div class="info-box info-message"><span style="margin-right:15px;"></span>Please select published course to get assignment form.</div>');
                return false;
            }

            $("#ExamTypeAssignmentDiv").html('<p>Loading ...</p>');

            $.ajax({
                type: 'get',
                url: '/examTypes/get_exam_type_staff_assignment_form/' + pc,
                success: function (data) {
                    $("#ExamTypeAssignmentDiv").html(data);
                },
                error: function (xhr, textStatus) {
                    alert(textStatus);
                }
            });

            return false;
        });
    });
</script>

<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;">
            <i class="fontello-plus" style="font-size: larger; font-weight: bold;"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;">
				<?= __('Exam Type Secondary Instructor Assignment'); ?>
			</span>
        </div>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">
                <div class="examTypes index">

                    <?= $this->Form->create('ExamType'); ?>

                    <div style="margin-top: -30px;">
                        <hr>
                        <div onclick="toggleViewFullId('ListPublishedCourse')">
                            <?php
                            if (!empty($publishedCourses)) {
                                echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
                                <span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span>
                                <?php
                            } else {
                                echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); ?>
                                <span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span>
                                <?php
                            } ?>
                        </div>

                        <div id="ListPublishedCourse" style="display:<?= (!empty($publishedCourses) ? 'none' : 'display'); ?>">
                            <fieldset style="padding-bottom: 5px; padding-top: 10px;">
                                <div class="row">
                                    <div class="large-3 columns">
                                        <?php
                                        echo $this->Form->input('acadamic_year', array(
                                            'id' => 'AcadamicYear',
                                            'label' => 'Acadamic Year: ',
                                            'class' => 'fs14',
                                            'style' => 'width:90%;',
                                            'type' => 'select',
                                            'options' => $acyear_array_data,
                                            'default' => $selected_acadamic_year
                                        ));
                                        ?>
                                    </div>
                                    <div class="large-3 columns">
                                        <?php
                                        echo $this->Form->input('semester', array(
                                            'id' => 'Semester',
                                            'class' => 'fs14',
                                            'label' => 'Semester: ',
                                            'style' => 'width:90%;',
                                            'type' => 'select',
                                            'options' => Configure::read('semesters'),
                                            'default' => $selected_semester
                                        ));
                                        ?>
                                    </div>
                                    <div class="large-3 columns">
                                        <?php
                                        echo $this->Form->input('program_id', array(
                                            'id' => 'Program',
                                            'class' => 'fs14',
                                            'label' => 'Program: ',
                                            'style' => 'width:90%;',
                                            'type' => 'select',
                                            'options' => $programs,
                                            'default' => $program_id
                                        ));
                                        ?>
                                    </div>
                                    <div class="large-3 columns">
                                        <?php
                                        echo $this->Form->input('program_type_id', array(
                                            'id' => 'ProgramType',
                                            'class' => 'fs14',
                                            'label' => 'Program Type: ',
                                            'style' => 'width:90%;',
                                            'type' => 'select',
                                            'options' => $program_types,
                                            'default' => $program_type_id
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <?= $this->Form->submit(__('List Published Courses'), array(
                                    'name' => 'listPublishedCourses',
                                    'class' => 'tiny radius button bg-blue',
                                    'div' => false
                                )); ?>
                            </fieldset>
                        </div>
                        <hr>
                    </div>

                    <?php if (!empty($publishedCourses)) { ?>
                        <table class="fs14" cellpadding="0" cellspacing="0" class="table">
                            <tr>
                                <td style="width:25%;" class="center">Published Courses</td>
                                <td colspan="3">
                                    <div class="large-10 columns">
                                        <br>
                                        <?= $this->Form->input('published_course_id', array(
                                            'style' => 'width: 90%;',
                                            'class' => 'fs14',
                                            'id' => 'PublishedCourse',
                                            'label' => false,
                                            'type' => 'select',
                                            'required',
                                            'options' => $publishedCourses,
                                            'default' => $published_course_combo_id
                                        )); ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>

                    <div id="ExamTypeAssignmentDiv">
                        <?php if (!empty($published_course_combo_id)) {
                            echo $this->element('exam_type_staff_assignment_form');
                        } else if (count($publishedCourses) <= 1) { ?>
                            <div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                                <span style='margin-right: 15px;'></span>
                                Please select academic year and semester to get list of published courses.
                            </div>
                        <?php } else { ?>
                            <div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                                <span style='margin-right: 15px;'></span>
                                Please select published course to get exam type secondary instructor assignment form.
                            </div>
                        <?php } ?>
                    </div>

                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>