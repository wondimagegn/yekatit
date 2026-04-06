<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('Curriculums'); ?></span>
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="large-12 columns">
				<?= $this->Form->Create('Curriculum'/* , array('action' => 'Search') */); ?>
				<div style="margin-top: -30px;">
					<hr>
                    <fieldset style="padding-bottom: 0px;padding-top: 15px;">
                        <!-- <legend>&nbsp;&nbsp; Search / Filter &nbsp;&nbsp;</legend> -->
                        <div class="row">
                            <div class="large-6 columns">
								<?php
								if (!empty($college_name) && ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT || $this->Session->read('Auth.User')['role_id'] == ROLE_COLLEGE)) { ?>
									<h6 class='fs13 text-gray'><?= $college_type; ?>: <?= $college_name; ?></h6>
									<?php
								} else {
									echo $this->Form->input('college_id', array('options' => $colleges, 'label' => 'College: ', 'style' => 'width:90%', 'empty' => '[ Select College ]', 'onchange' => 'getDepartment(1)', 'id' => 'college_id'));
								} ?>
                            </div>
							<div class="large-6 columns">
								<?php
								if (!empty($department_name) && $this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) { ?>
									<h6 class='fs13 text-gray'><?= (isset($department_type) && !empty($department_type) ? $department_type : 'Department'); ?>: <?= $department_name; ?></h6>
									<?php
								} else {
									echo $this->Form->input('department_id', array('label' => 'Department: ', 'style' => 'width:90%', 'empty' => '[ Select Department ]', 'id' => 'department_id_1'));
								} ?>
                            </div>
                        </div>
						<div class="row">
                            <div class="large-6 columns">
								<h6 class='fs13 text-gray'>Program: </h6>
								<?= $this->Form->input('program_id', array('id' => 'program_id', 'label' => false, 'type' => 'select', 'multiple' => 'checkbox', 'div' => false )); ?>
								<?= (isset($this->data['Curriculum']['page']) ? $this->Form->hidden('page', array('value' => $this->data['Curriculum']['page'])) : ''); ?>
								<?= (isset($this->data['Curriculum']['sort']) ? $this->Form->hidden('sort', array('value' => $this->data['Curriculum']['sort'])) : ''); ?>
								<?= (isset($this->data['Curriculum']['direction']) ? $this->Form->hidden('direction', array('value' => $this->data['Curriculum']['direction'])) : ''); ?>
							</div>
							<div class="large-6 columns">
								<br>
								<?= $this->Form->input('active', array('label' => 'Status: ', 'type' =>  'select' , 'empty' => '[ All ]', 'options' => array('1' => 'Active', '0' => 'Deactivated'), 'default' => '1')); ?>
								<!-- <br><br><?php //echo $this->Form->input('active', array('label' => 'Only Active Curriculums', 'type' =>  'checkbox' , 'checked' => (isset($active) && $active ? 'checked' :  false))); ?>
								<br><strong class="fs11">Uncheck this to get all curriculums including deactivated ones.</strong><br> -->
							</div>
						</div>
						<hr>
						<?= $this->Form->submit(__('Search'), array('name' => 'search', 'id' => 'getCurriculums', 'div' => false, 'class' => 'tiny radius button bg-blue')); ?>
                    </fieldset>
					<?= $this->Form->end(); ?>
                </div>
				
				<div id="searchAgain" class="fs14 text-gray" style="display: none;"></div>

				<?php
				if (!empty($result_curriculums)) { ?>
					<div id="showSeachResults"> 
						<hr>
						<div style="overflow-x:auto;">
							<table cellpadding="0" cellspacing="0" class="table">
								<thead>
									<tr>
										<td class="center">#</td>
										<td class="vcenter"><?= $this->Paginator->sort('name', 'Curriculum Name'); ?></td>
										<td class="center"><?= $this->Paginator->sort('year_introduced', 'Year Introduced'); ?></td>
										<td class="center"><?= $this->Paginator->sort('type_credit', 'Credit Type'); ?></td>
										<td class="center"><?= $this->Paginator->sort('english_degree_nomenclature', 'Degree Nomenclature'); ?></td>
										<td class="center"><?= $this->Paginator->sort('minimum_credit_points', 'Min. Cr'); ?></td>
										<?php
										if ($this->Session->read('Auth.User')['role_id'] != ROLE_DEPARTMENT) { ?>
											<td class="center"><?= $this->Paginator->sort('department_id', 'Department'); ?></td> 
											<?php
										} ?>
										<td class="center"><?= $this->Paginator->sort('program_id', 'Program'); ?></td>
										<td class="center"><?= $this->Paginator->sort('department_study_program_id', 'Study Program'); ?></td>
										<td class="center">Modality</td>
										<td class="center"><?= __('Actions'); ?></td>
									</tr>
								</thead>
								<tbody>
									<?php
									$start = $this->Paginator->counter('%start%');
									//debug($result_curriculums[0]);
									foreach ($result_curriculums as $curriculum) { ?>
										<tr>
											<td class="center"><?= $start++; ?></td>
											<td class="vcenter"><?= $curriculum['Curriculum']['name']; ?></td>
											<td class="center"><?= $this->Time->format("M j, Y", $curriculum['Curriculum']['year_introduced'], NULL, NULL); ?></td>
											<td class="center"><?= (count(explode('ECTS', $curriculum['Curriculum']['type_credit'])) >= 2  ? 'ECTS': 'Credit'); ?></td>
											<td class="vcenter"><?= $curriculum['Curriculum']['english_degree_nomenclature']; ?></td>
											<td class="center"><?= $curriculum['Curriculum']['minimum_credit_points']; ?></td>
											<?php
											if ($this->Session->read('Auth.User')['role_id'] != ROLE_DEPARTMENT) { ?>
												<td class="center"><?= $this->Html->link($curriculum['Department']['name'], array('controller' => 'departments', 'action' => 'view', $curriculum['Department']['id'])); ?></td>
												<?php
											} ?>
											<td class="center"><?= (!empty($curriculum['Program']['shortname']) ? $curriculum['Program']['shortname'] : $curriculum['Program']['name']); ?></td>
											<td class="center"><?= (isset($curriculum['DepartmentStudyProgram']['StudyProgram']) ? $curriculum['DepartmentStudyProgram']['StudyProgram']['code'] : 'N/A'); ?></td>
											<td class="center"><?= (isset($curriculum['DepartmentStudyProgram']['ProgramModality']) ? $curriculum['DepartmentStudyProgram']['ProgramModality']['code'] : 'N/A'); ?></td>
											<td class="center">
												<?= $this->Html->link(__(''), array('action' => 'view', $curriculum['Curriculum']['id']), array('class' => 'fontello-eye', 'title' => 'View')); ?> &nbsp;
												<?php 
												if ($this->Session->read('Auth.User')['role_id'] == ROLE_DEPARTMENT) { ?>
													<?php 
													if ($curriculum['Curriculum']['registrar_approved'] == 0) { ?>
														<?= $this->Html->link(__(''), array('action' => 'edit', $curriculum['Curriculum']['id']), array('class' => 'fontello-pencil', 'title' => 'Edit')); ?> &nbsp;
														<?= (empty($curriculum['Student']) ? $this->Html->link(__(''), array('action' => 'delete', $curriculum['Curriculum']['id']), array('class' => 'fontello-trash', 'title' => 'Delete'), sprintf(__('Are you sure you want to delete  %s?'), ((trim($curriculum['Curriculum']['name'])) . ' - ' . $curriculum['Curriculum']['year_introduced']))) : ''); ?>
														<?php 
													} else { ?>
														Curriculum Locked
														<?php 
													} ?>
													<?php 
												} ?>
												<?php
												if ($this->Session->read('Auth.User')['role_id'] == ROLE_REGISTRAR || $this->Session->read('Auth.User')['role_id'] == ROLE_SYSADMIN) {
													$lock = ($curriculum['Curriculum']['lock'] == 0 ? '[ Lock ]' : 'Unlock');
													$curapp = ($curriculum['Curriculum']['registrar_approved'] == 0 ? '[ Approve ]' : 'Unapprove');
													$activate = ($curriculum['Curriculum']['active'] == 0 ? 'Activate' : 'Deactivate');
													$lockAction = ($curriculum['Curriculum']['lock'] == 0 ? 'lock' : 'unlock');
													$curappAction = ($curriculum['Curriculum']['registrar_approved'] == 0 ? 'Approve' : 'unapprove'); 
													$activateAction = ($curriculum['Curriculum']['active'] == 0 ? 'activate' : 'deactivate'); 
													?>
													<br>
													<?php
													if ($curriculum['Curriculum']['active'] == 1) { ?>
														<?= $this->Form->postLink(__($lock), array('action' => 'lock', $curriculum['Curriculum']['id']), array('style' => ($lockAction == "unlock" ? 'color: green;': 'color: red;'), 'confirm' => __('Are you sure you want to ' . $lockAction . ' "%s" curriculum? ' . ($lockAction == "unlock" ? ' Unlocking a curriculum will result in curriculum modification by department account holder. Are you sure you want to unlock the curriculum anyway?' : '') . '', trim($curriculum['Curriculum']['name'])))); ?> <br/>
														<?= $this->Form->postLink(__($curapp), array('action' => 'approve', $curriculum['Curriculum']['id']), array('style' => ($curappAction == "unapprove" ? 'color: green;': 'color: red;'), 'confirm' => __('Are you sure you want to ' . $curappAction . ' "%s" curriculum? ' . ($curappAction == "unapprove" ? ' Unapproving a curriculum will result in curriculum modification by department account holder. Are you sure you want to unapprove the curriculum anyway?' : '') . '', trim($curriculum['Curriculum']['name'])))); ?> <br>
														<?php
													} ?>
													<?= $this->Form->postLink(__($activate), array('action' => 'activate', $curriculum['Curriculum']['id']), array('style' => ($activateAction == "deactivate" ? 'color: green;': 'color: red;'),  'confirm' => __('Are you sure you want to ' . $activateAction . ' "%s" curriculum? ' . ($activateAction == "deactivate" ? ' Deactivating this curriculum will remove it from the list of available curriculums for student curriculum attachment. It will also be excluded from course publishing and curriculum course mappings. Are you sure you want to proceed with deactivation?' : ' Activating this curriculum will add it to the list of available curriculums for student curriculum attachment. It will also become accessible for course publishing and curriculum course mappings. Are you sure you want to proceed with activation?') . '', trim($curriculum['Curriculum']['name'])))); ?> <br>
													<?php
													if ((is_null($curriculum['Curriculum']['department_study_program_id']) || empty($curriculum['Curriculum']['department_study_program_id'])) && $curriculum['Curriculum']['active']) { ?>
														<?= $this->Html->link('[Link Study Program]', '#', array('style' => 'color: red;', 'data-animation' => "fade", 'data-reveal-id' => 'myModalAdd', 'data-reveal-ajax' => '/departmentStudyPrograms/get_department_study_programs_combo/' . $curriculum['Curriculum']['id'])); ?>
														<?php
													}
												} ?>
											</td>
										</tr>
										<?php 
									} ?>
								</tbody>
							</table>
						</div>
						<br>

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

<div class="row">
	<div class="large-12 columns">

		<div id="myModalAdd" class="reveal-modal" data-reveal>

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

        const $searchForm = $('#CurriculumActive').closest('form');
        const $showSearchResults = $('#showSeachResults');
        const $searchAgain = $('#searchAgain');
        const $searchBtn = $('#getCurriculums');

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
			
			/* let isProgramSelected = false;

			$('[id^="program_id"]').each(function() {
				if ($(this).is(':checked')) {
					isProgramSelected = true;
					return false; // break loop
				}
			}); */

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

			if (allValid/*  && isProgramSelected */) {
				return true;
			} else {
				return false;
			}
        }

        // Auto-submit or prompt to search again on search filter change
        $('[id^="program_id"], #college_id, #department_id_1, #CurriculumActive').on('change keyup', function () {
            if (allRequiredFieldsAreNotEmpty()) {
                hideSearchResults('Looking for search results based on your current search filters...');
                submitSearchForm();
            } else {
                hideSearchResults(); // just hide search and prompt to search again.
            }
        });
    });
</script>