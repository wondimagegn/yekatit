<div class="box">
    <div class="box-header bg-transparent">
        <div class="box-title" style="margin-top: 10px;"><i class="fontello-plus"></i>
            <span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Map Equivalent Courses'); ?></span>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="large-12 columns">
                <?= $this->Form->create('EquivalentCourse'); ?>

                <div style="margin-top: -30px;"><hr></div>

                <blockquote>
                    <h6><i class="fa fa-info"></i> &nbsp; Important Note:</h6>
                    <span style="text-align:justify;" class="fs16 text-black">This tool will help you to map a course from a given curriculum to anogther course in different curriculum. <br> <span class="rejected">Only curriculums which are approved by the registrar and not deactivated will appear for course mapping.</span></span> 
                </blockquote>
                <hr>
                
                <?php
                if (isset($curriculum_id) && !empty($curriculum_id) && isset($curriculums_with_graduated_students) && !empty($curriculums_with_graduated_students)) {
                    if (!empty($curriculums) && in_array($curriculum_id, $curriculums_with_graduated_students)) { ?>
                        <div class="warning-box warning-message" style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                            <span style="margin-right: 15px;"></span>
                            <i>Students have already graduated under the "<?= $curriculums[$curriculum_id]; ?>" curriculum. Please ensure that any course mapping you add does not affect their academic records.</i>
                            <br><br><i class="rejected">Be aware that once a course mapping is added, it cannot be undone. Double-check to confirm your mapping is correct and accurate before proceeding.</i>
                        </div>
                        <hr>
                        <?php
                    }
                } ?>

                <div class="row">
                    <div class="large-6 columns">
                        <fieldset style="padding-bottom: 25px; padding-top: 15px;">
                            <legend>&nbsp;&nbsp; Course to be Substituted &nbsp;&nbsp;</legend>
                            <div class="row">
                                <div class="large-12 columns">
                                    <?= $this->Form->input('program_id', array('label' => 'Program: ', 'id' => 'program_id_1', 'onchange' => 'updateCurriculumGivenProgram(1,' . $dept_id . ')', 'options' => $programs, 'type' => 'select', 'empty' => '[ Select Program ]', 'required', 'style' => 'width:100%;')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-12 columns">
                                    <?= $this->Form->input('curriculum_id', array('id' => 'curriculum_id_1', 'options' => $curriculums, 'type' => 'select', 'empty' => '[ Select Curriculum ]', 'onchange' => 'updateCourse(1)', 'required', 'style' => 'width:100%;')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-12 columns">
                                    <?= $this->Form->input('course_for_substitued_id', array('id' => 'course_id_1', 'options' => $courseForSubstitueds, 'type' => 'select', 'empty' => '[ Select Course ]', 'label' => 'Course: ', 'required', 'style' => 'width:100%;')); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="large-6 columns">
                        <fieldset style="padding-bottom: 25px; padding-top: 15px;">
                            <legend>&nbsp;&nbsp; Equivalent Course &nbsp;&nbsp;</legend>
                            <div class="row">
                                <div class="large-12 columns">
                                    <?= $this->Form->input('department_id', array('onchange' => 'updateSubCurriculum(2)', 'options' => $departments, 'type' => 'select', 'empty' => '[ Select Department ]', 'id' => "department_id_2", 'required', 'style' => 'width:100%;')); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="large-12 columns">
                                    <?= $this->Form->input('other_curriculum_id', array('id' => 'curriculum_id_2', 'onchange' => 'updateCourse(2)', 'options' => $otherCurriculums, 'type' => 'select', 'empty' => '[ Select Curriculum ]', 'required', 'style' => 'width:100%;')); ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="large-12 columns">
                                    <?= $this->Form->input('course_be_substitued_id', array('id' => 'course_id_2', 'options' => $courseBeSubstitueds, 'type' => 'select', 'empty' => '[ Select Course ]',  'label' => 'Course: ', 'required', 'style' => 'width:100%;')) ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <hr>

                <?= $this->Form->submit('Map Selected Courses', array('name' => 'mapEquivalentCourses', 'id' => 'mapEquivalentCourses', 'div' => 'false', 'class' => 'tiny radius button bg-blue')); ?>
                
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>

    //$("#mapEquivalentCourses").attr('disabled', true);

    function updateCurriculumGivenProgram(id, department_id) {
		//serialize form data
		var formData = $("#program_id_" + id).val();

        $("#department_id_2").val('');
        $("#curriculum_id_2").empty().append('<option value="">[ Select Department First ]</option>');
        $("#course_id_2").empty().append('<option value="">[ Select Curriculum First ]</option>');

        if (formData) {
            $("#program_id_" + id).attr('disabled', true);
            $("#curriculum_id_1").attr('disabled', true);
            $("#curriculum_id_1").empty();
            $("#curriculum_id_" + id).attr('disabled', true);
            $("#course_id_" + id).attr('disabled', true);
            $("#mapEquivalentCourses").attr('disabled', true);

            //get form action
            var formUrl = '/curriculums/get_curriculum_combo/' + department_id + '/' + formData + '/3';
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data, textStatus, xhr) {
                    $("#program_id_" + id).attr('disabled', false);
                    $("#curriculum_id_" + id).attr('disabled', false);
                    $("#curriculum_id_" + id).empty();
                    //$("#curriculum_id_" + id).append('<option></option>');
                    $("#curriculum_id_" + id).append(data);
                },
                error: function(xhr, textStatus, error) {
                    alert(textStatus);
                }
            });
            return false;
        } else {
            $("#curriculum_id_1").empty().append('<option value="">[ Select Program First ]</option>');
            $("#course_id_1").empty().append('<option value="">[ Select Program First ]</option>');
            $("#department_id_2").val('');
            $("#curriculum_id_2").empty().append('<option value="">[ Select Program First ]</option>');
            $("#course_id_2").empty().append('<option value="">[ Select Program First ]</option>');
            $("#course_id_2").empty().append('<option value="">[ Select Program First ]</option>');
            $("#mapEquivalentCourses").attr('disabled', true);
        }
	}

    function updateSubCurriculum(id) {
        //serialize form data
        var formData = $("#department_id_" + id).val();
        var program_id = $("#program_id_1").val();
        
        if (formData) {
            $("#curriculum_id_" + id).empty();
            $("#curriculum_id_" + id).attr('disabled', true);
            $("#course_id_" + id).attr('disabled', true);
            $("#mapEquivalentCourses").attr('disabled', true);
            
            //get form action
            var formUrl = '/curriculums/get_curriculum_combo/' + formData + '/' + program_id + '/1';

            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data, textStatus, xhr ) {
                    $("#curriculum_id_" + id).attr('disabled', false);
                    $("#curriculum_id_" + id).empty();
                    $("#curriculum_id_" + id).append(data);
                    //Items list
                    var subCat = $("#curriculum_id_" + id).val();

                    if (subCat) {
                        $("#course_id_" + id).empty();
                        //get form action
                        var formUrl = '/curriculums/get_courses/' + subCat + '/1/1';
                        $.ajax({
                            type: 'get',
                            url: formUrl,
                            data: subCat,
                            success: function(data, textStatus, xhr) {
                                $("#mapEquivalentCourses").attr('disabled', false);
                                $("#course_id_" + id).attr('disabled', false);
                                $("#course_id_" + id).empty();
                                $("#course_id_" + id).append(data);
                            },
                            error: function(xhr, textStatus, error) {
                                alert(textStatus);
                            }
                        });

                        //End of items list
                        return false;

                    } else {
                        $("#course_id_" + id).empty().append('<option value="">[ Select Curriculum First ]</option>');
                        $("#mapEquivalentCourses").attr('disabled', true);
                    }
                },
                error: function(xhr, textStatus, error) {
                    alert(textStatus);
                }
            });

            return false;

        } else {
            $("#course_id_" + id).empty().append('<option value="">[ Select Curriculum First ]</option>');
            $("#mapEquivalentCourses").attr('disabled', true);
        }
    }

    //update course combo
    function updateCourse(id) {
        //serialize form data
        var subCat = $("#curriculum_id_" + id).val();
        
        if (subCat) {

            $("#course_id_" + id).attr('disabled', true);
            $("#mapEquivalentCourses").attr('disabled', true);
            $("#course_id_" + id).empty();
            
            //get form action
            var formUrl = '/curriculums/get_courses/' + subCat + '/1/1';
            
            $.ajax({
                type: 'get',
                url: formUrl,
                data: subCat,
                success: function(data, textStatus, xhr) {
                    $("#mapEquivalentCourses").attr('disabled', false);
                    $("#course_id_" + id).attr('disabled', false);
                    $("#course_id_" + id).empty();
                    $("#course_id_" + id).append(data);
                },
                error: function(xhr, textStatus, error) {
                    alert(textStatus);
                }
            });

            return false;

        } else {
            $("#course_id_" + id).empty().append('<option value="">[ Select Curriculum First ]</option>');
            $("#mapEquivalentCourses").attr('disabled', true);
        }
    }


    var form_being_submitted = false;

	$('#mapEquivalentCourses').click(function() {

        if ($("#curriculum_id_1").val() == '') {
			alert('Please select the curriculum of the course to be substituted.');
            //$('#curriculum_id_1').val().focus();
			return false;
		}

        if ($("#course_id_1").val() == '') {
			alert('Please select the course to be substituted.');
            $('#course_id_1').val().focus();
			return false;
		}

        if ($("#curriculum_id_2").val() == '') {
			alert('Please select the curriculum of the course to be equivalent.');
            //$('#curriculum_id_2').val().focus();
			return false;
		}

        if ($("#course_id_2").val() == '') {
			alert('Please select the equivalent course for substitution.');
            $('#course_id_2').val().focus();
			return false;
		}

        if ($("#curriculum_id_1").val() == $("#curriculum_id_2").val()) {
            alert('You can\'t map courses from the same curriculum!, Please change either of your selected curriculums.');
            //$('#course_id_2').val().focus();
			return false;
        }

		if (form_being_submitted) {
			alert('Mapping the selected courses request, please wait a moment...');
			$('#mapEquivalentCourses').prop('diabled', true);
			return false;
		}

        var confirmm =  confirm('If there are graduated students attached to this curriculum (' + $("#curriculum_id_1 option:selected").text() + '), you will not have the option to delete this course map if it is a wrong mapping. You have chosen to map ' + $("#course_id_1 option:selected").text() + ' to ' + $("#course_id_2 option:selected").text() + ' from ' + $("#curriculum_id_2 option:selected").text() + '?, Is that the correct and are sure you want save this mapping?');

		if (confirmm) {
			$('#mapEquivalentCourses').val('Mapping Selected Courses...');
			form_being_submitted = true;
			return true;
		} else {
            return false;
        }

	});


	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>