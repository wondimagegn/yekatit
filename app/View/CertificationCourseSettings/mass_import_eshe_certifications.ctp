
<div class="box">
    <div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-download" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Import ESHE Certifications'); ?></span>
		</div>
	</div>
    <div class="box-body pad-forty">
        <div class="row">
            <div class="large-12 columns" style="margin-top: -55px;">
                <div class="row">
                    <hr>
                    <blockquote>
                        <h6 class="text-red"><i class="fa fa-info"></i> &nbsp; Be-aware:</h6>
                        <span style="text-align:justify;" class="fs14 text-gray">Before importing the excel keep non requred fields empty and <b class="text-black"><i>make sure that the first row of your excel file is filled with <br>
                            <ul>
                                <li>studentnumber(sso email with studentnumber header), course_code, score, status, start_date</li>
                            </ul>
                            fields and you saved your excel file with Excel 97-2003 Format.</i></b> <a href="<?= SSS_IMPORT_TEMPLATE_FILE; ?>">Download Import Template here</a> with the required fields and sample pre-populated data.
                        </span> 
                    </blockquote>
                    <hr>
                </div>
            </div>

            <fieldset style="padding-top: 0px; padding-bottom: 0px;">
                <?= $this->Form->create('CertificationCourseSetting', array('action' => 'mass_import_eshe_certifications', 'type' => 'file')); ?>
                <div class="large-6 columns" style="margin-top: 30px;">
                    <label>
                        <strong>Student List with score: </strong>
                        <?= $this->Form->file('File', array('label' => 'Excel', 'name' => 'data[CertificationCourseSetting][xls]', 'required')); ?>
                    </label>
                    <span id="fileError" style="color:red;" class="fs14"></span>
                    <br>
                </div>
                <div class="large-4 columns">
                </div>
                <div class="large-2 columns">

                </div>
                <hr />
                <?= $this->Form->submit('Upload Certifications', array('id' => 'uploadBtn', 'class' => 'tiny radius button bg-blue')); ?>
                <?= $this->Form->end(); ?>
            </fieldset>
        </div>
    </div>
</div>

<script>

    var form_being_submitted = false;

    $('#uploadBtn').click(function(e) {
        var isValid = true;

        var fileInput = $('#CertificationCourseSettingFile');
        var filePath = fileInput.val();
        var allowedExtensions = /(\.xls)$/i;

        if (!filePath) {
            $('#fileError').text('Excel 2007 format(.xls) file is required.');
            e.preventDefault();
            isValid = false;
            return false;
        } else if (!allowedExtensions.exec(filePath)) {
            $('#fileError').text('Invalid file type. Only Excel 2007 format(.xls) file is allowed.');
            fileInput.val('');
            e.preventDefault();
            isValid = false;
            return false;
        } else {
            $('#fileError').text('');
            isValid = true;
        }

        if (form_being_submitted) {
            alert('Importing from File, please wait a moment..');
            $('#uploadBtn').attr('disabled', true);
            isValid = false;
            return false;
        }

        if (!form_being_submitted && isValid) {
            $('#uploadBtn').val('Importing...');
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