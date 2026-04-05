<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"> <?= __('Department Study Programs'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<?= $this->Form->Create('DepartmentStudyProgram'); ?>
				<div style="margin-top: -30px;">
					<hr>
                    <fieldset style="padding-bottom: 5px;padding-top: 15px;">
                        <!-- <legend>&nbsp;&nbsp; Search / Filter &nbsp;&nbsp;</legend> -->
                        <div class="row">
							<div class="large-6 columns">
								<?php
								if (!empty($department_name) && $this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) { ?>
									<h6 class='fs13 text-gray'>Department: <?= $department_name; ?></h6>
									<?php
								} else {
									echo $this->Form->input('department_id', array('label' => 'Department: ', 'style' => 'width:90%', 'empty' => '[ Select Department ]', 'onchange' => 'getStudyProgram(1)', 'id' => 'department_id'));
								} ?>
                            </div>
							<div class="large-6 columns">
							<?= $this->Form->input('academic_year', array('label' => 'From Academic Year: ', 'options' => $academic_year, 'style' => 'width:42%', 'empty' => '[ Select Academic Year ]')); ?>
							</div>
                        </div>
						<div class="row">
							<div class="large-3 columns">
								<?= $this->Form->input('study_program_id', array('id' => 'study_program_id_1', 'label' => 'Study Program: ', 'style' => 'width:90%', 'empty' => '[ Select Study Program ]')); ?>
							</div>
                            <div class="large-3 columns">
								<?= $this->Form->input('qualification_id', array('label' => 'Qualification: ', 'style' => 'width:90%', 'empty' => '[ Select Qualification ]')); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('program_modality_id', array('label' => 'Program Modality: ', 'style' => 'width:90%', 'empty' => '[ Select Program Modality ]')); ?>
							</div>
							<div class="large-3 columns">
								<br><?= $this->Form->input('apply_for_current_students', array('label' => 'Applied for current Students', 'type' =>  'checkbox' , 'checked' => (isset($apply_for_current_students) && $apply_for_current_students ? 'checked' :  false))); ?>
								<?= (isset($this->data['DepartmentStudyProgram']['page']) ? $this->Form->hidden('page', array('value' => $this->data['DepartmentStudyProgram']['page'])) : ''); ?>
								<?= (isset($this->data['DepartmentStudyProgram']['sort']) ? $this->Form->hidden('sort', array('value' => $this->data['DepartmentStudyProgram']['sort'])) : ''); ?>
								<?= (isset($this->data['DepartmentStudyProgram']['direction']) ? $this->Form->hidden('direction', array('value' => $this->data['DepartmentStudyProgram']['direction'])) : ''); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<hr>
								<?= $this->Form->submit(__('Search'), array('name' => 'search', 'id' => 'searchBtn', 'div' => false, 'class' => 'tiny radius button bg-blue')); ?>
							</div>
						</div>
                    </fieldset>
					<?= $this->Form->end(); ?>
                </div>

				<div id="searchAgain" class="fs14 text-gray" style="display: none;"></div>

                <?php
                //debug($departmentStudyPrograms);
                if (!empty($departmentStudyPrograms)) { ?>
					<div id="showSeachResults">
						<hr>
						<div style="overflow-x:auto;">
							<table cellpadding="0" cellspacing="0" class="table">
								<thead>
									<tr>
										<th class="center">#</th>
										<th class="vcenter"><?= $this->Paginator->sort('department_id', 'Department'); ?></th>
										<th class="vcenter"><?= $this->Paginator->sort('study_program_id', 'Study Program'); ?></th>
										<th class="center">Code</th>
										<th class="center"><?= $this->Paginator->sort('program_modality_id', 'Modality'); ?></th>
										<th class="center"><?= $this->Paginator->sort('qualification_id', 'Qualification'); ?></th>
										<th class="center"><?= $this->Paginator->sort('academic_year', 'ACY'); ?></th>
										<th class="center">Current?</th>
										<th class="center"><?= __('Actions'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$count = $this->Paginator->counter('%start%');
									foreach ($departmentStudyPrograms as $departmentStudyProgram) { ?>
										<tr>
											<td class="center"><?= $count++; ?></td>
											<td class="vcenter"><?= $departmentStudyProgram['Department']['name']; ?></td>
											<td class="vcenter"><?= $departmentStudyProgram['StudyProgram']['study_program_name']; ?></td>
											<td class="center"><?= $departmentStudyProgram['StudyProgram']['code']; ?></td>
											<td class="center"><?= $departmentStudyProgram['ProgramModality']['code']; ?></td>
											<td class="center"><?= $departmentStudyProgram['Qualification']['code']; ?></td>
											<td class="center"><?= $departmentStudyProgram['DepartmentStudyProgram']['academic_year']; ?></td>
											<td class="center"><?= (isset($departmentStudyProgram['DepartmentStudyProgram']['apply_for_current_students']) && $departmentStudyProgram['DepartmentStudyProgram']['apply_for_current_students'] == 1 ? '<span class="accepted">Yes</span>' : '<span class="rejected">No</span>'); ?></td>
											<td class="center">
												<?= $this->Html->link(__(''), array('action' => 'view', $departmentStudyProgram['DepartmentStudyProgram']['id']), array('class' => 'fontello-eye', 'title' => 'View')); ?> &nbsp;
												<?php
												if (($this->Session->read('Auth.User')['Role']['id'] == ROLE_REGISTRAR && $this->Session->read('Auth.User')['is_admin'] == 1) || $this->Session->read('Auth.User')['Role']['id'] == ROLE_SYSADMIN ) {  ?>
													<?= $this->Html->link(__(''), array('action' => 'edit', $departmentStudyProgram['DepartmentStudyProgram']['id']), array('class' => 'fontello-pencil', 'title' => 'Edit')); ?> &nbsp;
													<?= $this->Html->link(__(''), array('action' => 'delete', $departmentStudyProgram['DepartmentStudyProgram']['id']), array('class' => 'fontello-trash', 'title' => 'Delete'), sprintf(__('Are you sure you want to delete %s study program from %s department?'), $departmentStudyProgram['StudyProgram']['study_program_name'], $departmentStudyProgram['Department']['name'])); ?>
													<?php
												} ?>
											</td>
										</tr>
										<?php 
									} ?>
								</tbody>
							</table>
						</div>
						
						<hr>
						<div class="row">
							<div class="large-5 columns">
								<?= $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total'))); ?>
							</div>
							<div class="large-7 columns">
								<div class="pagination-centered">
									<ul class="pagination">
										<?= $this->Paginator->prev('<< ' . __(''), array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?> <?= $this->Paginator->numbers(array('separator' => '', 'tag' => 'li')); ?> <?= $this->Paginator->next(__('') . ' >>', array('tag' => 'li'), null, array('class' => 'arrow unavailable')); ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php
                } ?>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript'>

	function getStudyProgram(id) {
		
		var formData = $("#department_id").val();
		$("#study_program_id_" + id).empty();
		//$("#study_program_id_" + id).append('<option style="width:100px">loading...</option>');
		$("#study_program_id_" + id).attr('disabled', true);
		
		if (!isNaN(formData) && formData != 0 && formData != '0' && formData != '') {
			var formUrl = '/departmentStudyPrograms/get_selected_department_department_study_programs/' + formData;
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data, textStatus, xhr) {
					$("#study_program_id_" + id).attr('disabled', false);
					$("#study_program_id_" + id).empty();
					//$("#study_program_id_" + id).append('<option style="width:100px"></option>');
					$("#study_program_id_" + id).append(data);
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});
			return false;
		}  else {
			$("#study_program_id_" + id).empty().append('<option value">[ Select Department First ]</option>');
		}

		$("#study_program_id_" + id).attr('disabled', false);
	}

    $(function () {

        const $searchForm = $('#department_id').closest('form');
        const $showSearchResults = $('#showSeachResults');
        const $searchAgain = $('#searchAgain');
        const $searchBtn = $('#searchBtn');

		const $departmentID = $('#department_id').val();

        // Hide seaech results and show search prompt
        function hideSearchResults(message = 'Click Search button again to get new search results based on your changed filters.') {
            if ($showSearchResults.length) {
                $showSearchResults.hide();
                $searchAgain.text(message).show();
            }
        }

        // Submit form with feedback
        function submitSearchForm(message = 'Looking for search results based on your current search filters...') {
            $searchBtn.val('Searching...');
            $searchAgain.text(message).show();
            $searchForm.submit();
        }

		$('#department_id').on('change', function () {
            getStudyProgram($(this).val());
            hideSearchResults();
        });

		if ($departmentID !== '') {
			getStudyProgram($departmentID);
		}

        // Search button click
        $searchBtn.on('click', function () {
            $(this).val('Searching...');
            if ($showSearchResults.length) $showSearchResults.hide();
        });

        // Auto-submit or prompt to search again on search filter change
        $('#study_program_id_1, #DepartmentStudyProgramProgramModalityId, #DepartmentStudyProgramQualificationId, #CurriculumActive').on('change keyup', function () {
            if ($showSearchResults.length || 1) {
                hideSearchResults('Looking for search results based on your current search filters...');
                submitSearchForm();
            } else {
                hideSearchResults(); // just hide search and prompt to search again.
            }
        });
    });
</script>