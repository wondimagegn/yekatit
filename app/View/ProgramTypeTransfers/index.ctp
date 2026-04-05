<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Program Type Transfers'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<div style="margin-top: -30px;">
					<hr>

					<?= $this->Form->create('ProgramTypeTransfer'); ?>

                    <fieldset style="padding-bottom: 0px;padding-top: 15px;">
                        <!-- <legend>&nbsp;&nbsp; Search / Filter &nbsp;&nbsp;</legend> -->
                        <div class="row">
                            <div class="large-6 columns">
								<?php
								if (!empty($college_name) && ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE)) { ?>
									<h6 class='fs13 text-gray'><?= $college_type; ?>: <?= $college_name; ?></h6>
									<?php
								} else {
									echo $this->Form->input('college_id', array('options' => $colleges, 'label' => 'College: ', 'style' => 'width:90%', 'empty' => '[ All Colleges ]', 'onchange' => 'getDepartment(1)', 'id' => 'college_id'));
								} ?>
                            </div>
							<div class="large-6 columns">
								<?php
								if (!empty($department_name) && $this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) { ?>
									<h6 class='fs13 text-gray'><?= (isset($department_type) && !empty($department_type) ? $department_type : 'Department'); ?>: <?= $department_name; ?></h6>
									<?php
								} else {
									echo $this->Form->input('department_id', array('label' => 'Department: ', 'style' => 'width:90%', 'empty' => '[ All Departments ]', 'id' => 'department_id_1'));
								} ?>
                            </div>
                        </div>
						<div class="row">
                            <div class="large-4 columns">
								<?= $this->Form->input('program_id', array('id' => 'programId', 'label' => 'Program: ', 'style' => 'width:90%', 'type' => 'select', 'empty' => '[ All Programs ]', 'div' => false )); ?>
							</div>
							<div class="large-4 columns">
								<?= $this->Form->input('program_type_id', array('id' => 'programTypeId', 'label' => 'To Program Type: ',  'style' => 'width:90%', 'type' => 'select', 'empty' => '[ All Program Types ]',  'div' => false )); ?>
							</div>
							<div class="large-4 columns">
								<?= $this->Form->input('name', array('id' => 'studentIdOrName', 'label' => 'Student Name or ID:', 'placeholder' => 'Student Name or ID.. ', 'default' => (isset($name) ? $name : ''), 'style' => 'width:90%;')); ?>
								<?= (isset($this->data['ProgramTypeTransfer']['page']) ? $this->Form->hidden('page', array('value' => $this->data['ProgramTypeTransfer']['page'])) : ''); ?>
								<?= (isset($this->data['ProgramTypeTransfer']['sort']) ? $this->Form->hidden('sort', array('value' => $this->data['ProgramTypeTransfer']['sort'])) : ''); ?>
								<?= (isset($this->data['ProgramTypeTransfer']['direction']) ? $this->Form->hidden('direction', array('value' => $this->data['ProgramTypeTransfer']['direction'])) : ''); ?>
							</div>
						</div>
						<hr>
						<?= $this->Form->submit(__('Search Program Transfer'), array('name' => 'viewProgramTransfer', 'id' => 'listProgramTransfers', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
                    </fieldset>
					<?= $this->Form->end(); ?>
                </div>
				
				<div id="searchAgain" class="fs14 text-gray" style="display: none;"></div>

				<?php
				if (!empty($programTypeTransfers)) { ?>
					<div id="showSeachResults"> 
						<hr>
						<div style="overflow-x:auto;">
							<table cellpadding="0" cellspacing="0" class="table">
								<thead>
									<tr>
										<th class="center">#</th>
										<th class="vcenter"><?= $this->Paginator->sort('student_id'); ?></th>
										<th class="center">Student ID</th>
										<!-- <th class="center"><?php //echo $this->Paginator->sort('program_type_id', 'From'); ?></th> -->
										<th class="center"><?= $this->Paginator->sort('program_type_id', 'To Program Type'); ?></th>
										<th class="center"><?= $this->Paginator->sort('academic_year', 'ACY'); ?></th>
										<th class="center"><?= $this->Paginator->sort('semester', 'Sem'); ?></th>
										<th class="center"><?= $this->Paginator->sort('transfer_date'); ?></th>
										<th class="center"><?= ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR && $this->Session->read('Auth.User')['is_admin'] == 1 ? __('Actions') : ''); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$start = $this->Paginator->counter('%start%');
									foreach ($programTypeTransfers as $programTypeTransfer) { ?>
										<tr>
											<td class="center"><?= $start++; ?></td>
											<td class="vcenter"><?= $this->Html->link($programTypeTransfer['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile', $programTypeTransfer['Student']['id'])); ?></td>
											<td class="center"><?= $programTypeTransfer['Student']['studentnumber']; ?></td>
											<!-- <td class="center"><?php //echo (isset($programTypeTransfer['Student']['base_program_type_id']) && !empty($programTypeTransfer['Student']['base_program_type_id']) ? $programTypes[$programTypeTransfer['Student']['base_program_type_id']] : ''); ?></td> -->
											<td class="center"><?= $this->Html->link($programTypeTransfer['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $programTypeTransfer['ProgramType']['id'])); ?></td>
											<td class="center"><?= $programTypeTransfer['ProgramTypeTransfer']['academic_year']; ?></td>
											<td class="center"><?= $programTypeTransfer['ProgramTypeTransfer']['semester']; ?></td>
											<td class="center"><?= ($this->Time->format("M j, Y", $programTypeTransfer['ProgramTypeTransfer']['transfer_date'], NULL, NULL)); ?></td>
											<td class="center"><?= ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR && $this->Session->read('Auth.User')['is_admin'] == 1 && !$programTypeTransfer['Student']['graduated'] ? $this->Html->link(__('Delete'), array('action' => 'delete', $programTypeTransfer['ProgramTypeTransfer']['id']), array('confirm' => sprintf(__('Are you sure you want to delete this program type transfer for %s? Please note that deleting this transfer will not revert the student’s program type to the previous program type, but it may affect their status during status regeneration. Do you want to proceed?'), $programTypeTransfer['Student']['full_name_studentnumber']))) : ''); ?></td>
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

<script>

	function getDepartment(id) {
		
		var formData = $("#college_id").val();
		
		$("#department_id_" + id).empty();
		//$("#department_id_" + id).append('<option style="width:100px">loading...</option>');
		$("#department_id_" + id).attr('disabled', true);

		if (!isNaN(formData) && formData != 0 && formData != '0' && formData != '') {
			var formUrl = '/departments/get_department_combo/' + formData + '/0/0/1';
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data, textStatus, xhr) {
					$("#department_id_" + id).attr('disabled', false);
					$("#department_id_" + id).empty();
					//$("#department_id_" + id).append('<option style="width:100px"></option>');
					$("#department_id_" + id).append(data);
				},
				error: function(xhr, textStatus, error) {
					alert(textStatus);
				}
			});
			return false;
		} else {
			$("#department_id_" + id).empty().append('<option value">[ Please Select College ]</option>');
		}
	}

    $(function () {

        const $searchForm = $('#programTypeId').closest('form');
        const $showSearchResults = $('#showSeachResults');
        const $searchAgain = $('#searchAgain');
        const $searchBtn = $('#listProgramTransfers');
		const $studentIdOrName = $('#studentIdOrName');

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

        // Search button click
        $searchBtn.on('click', function () {
            $(this).val('Searching...');
            if ($showSearchResults.length) $showSearchResults.hide();
        });

		function allRequiredFieldsAreNotEmpty() {
			
			let allValid = true;

			$searchForm.find('[required]').each(function () {
				if ($(this).is(':checkbox') && !$(this).is(':checked')) {
					allValid = false;
					return false; // Exit loop early
				} else if (!$(this).is(':checkbox') && $(this).val().trim() === '') {
					allValid = false;
					return false;
				}
			});

			if (allValid) {
				return true;
			} else {
				return false;
			}
        }

        // Auto-submit or prompt to search again on search filter change
        $('#college_id, #department_id_1, #programId, #programTypeId').on('change', function () {
            if (allRequiredFieldsAreNotEmpty()) {
				if($studentIdOrName) {
					$studentIdOrName.val('');
				}
                hideSearchResults('Looking for search results based on your current search filters...');
                submitSearchForm();
            } else {
                hideSearchResults();
            }
        });
    });
</script>
