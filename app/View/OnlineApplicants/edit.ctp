<div class="box">
    <div class="box-body">
        <div class="row">

            <div
                class="large-12 columns">
                <div
                    class="onlineApplicants form">
                    <?php echo $this->Form->create(
						'OnlineApplicant',
						array(
							'method' => 'post', 'id' => 'MyForm',
							'enctype' => 'multipart/form-data',
							'type' => 'file',
						)
					); ?>
                    <fieldset>
                        <legend>
                            <?php echo __('Edit Online Applicant'); ?>
                        </legend>
                        <table>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('id') . $this->Form->input('college_id', array('label' => 'Department')) . '</td>';
								echo '<td>' . $this->Form->input('department_id', array('label' => 'Field of study')) . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('program_id') . '</td>';
								echo '<td>' . $this->Form->input('program_type_id') . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php

								echo '<td>' . $this->Form->input('undergraduate_university_name') . '</td>';
								echo '<td>' . $this->Form->input('undergraduate_university_cgpa') . '</td>';

								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('undergraduate_university_field_of_study') . '</td>';
								echo '<td>' . $this->Form->input('postgraduate_university_name') . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('postgraduate_university_cgpa') . '</td>';
								echo '<td>' . $this->Form->input('postgraduate_university_field_of_study') . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('financial_support') . '</td>';
								echo '<td>' . $this->Form->input('name_of_sponsor') . '</td>';
								?>
                            </tr>
                            <?php
							echo '<td>' . $this->Form->input('disability') . '</td>';
							echo '<td>' . $this->Form->input('first_name') . '</td>';
							?>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('father_name') . '</td>';
								echo '<td>' . $this->Form->input('grand_father_name') . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('date_of_birth') . '</td>';
								echo '<td>' . $this->Form->input('gender') . '</td>';
								echo '<td>' . $this->Form->input('mobile_phone') . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('email') . '</td>';
								echo '<td>' . $this->Form->input('application_status', array('label' => 'Is selected for admission')) . '</td>';
								?>
                            </tr>
                            <tr>
                                <?php
								echo '<td>' . $this->Form->input('document_submitted') . '</td>';
								echo '<td>' . $this->Form->input('entrance_result') . '</td>';
								?>
                            </tr>
                            <?php
							if (!empty($this->request->data['Attachment'])) {
								echo '<tr>
                                <td
                                    colspan=2>
                                    <strong>Attachment</strong>
                                </td>
                            </tr>';

								foreach ($this->request->data['Attachment']
									as $cuk => $cuv) {
									//$this->Format->humanize_date
									$action_controller_id = 'edit~online_applicants~' . $cuv['foreign_key'];


									echo '<tr>
                            <td>Type:
                                ' . $cuv['group'] .
										'</td>
                        </tr>';
									echo '<tr>
                            <td>';
									echo '<a
                                    href=' . $this->Media->url(
										$cuv['dirname'] . DS . $cuv['basename'],
										true
									) . '
                                    target=_blank>View
                                    Attachment</a>';
									echo '<br/>' . $this->Html->link(
										__('Delete Attachment', true),
										array(
											'controller' => 'attachments', 'action' => 'delete',
											$cuv['id'], $action_controller_id
										),
										null,
										sprintf(__('Are you sure you want to delete attachment ?', true))
									);
									echo '
                            </td>
                        </tr>';
								}
							} else {

							?>

                            <tr>
                                <?php
									echo '<td colspan="2">' . $this->Form->input('Attachment.0.file', array(
										'type' => 'file', 'label' => 'Combined All Your
                                            Application Files and attach', 'required' => 'required',
										'id' => 'ApplicationFormAttachment',
										'onchange' =>
										"return fileValidation(this)"
									)) . '</td>';

									?>
                            </tr>

                            <tr>
                                <?php
									echo '<td colspan="2">' . $this->Form->input(
										'Attachment.1.file',
										array(
											'type' => 'file', 'label' => 'Payment Receipt',
											'required' => 'required',
											'id' => 'ReceiptFormAttachment',


											'onchange' =>
											"return fileValidation(this)",

										)
									) . '</td>';
									?>
                            </tr>
                            <?php
							}
							?>

                        </table>
                    </fieldset>
                    <?php //echo $this->Form->end(__('Submit'));
					?>
                    <?php
					echo $this->Form->submit(__('Update the application'), array('class' => 'tiny radius button bg-blue', 'div' => false));
					?>

                </div>

            </div>
        </div>
    </div>
</div>

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