<div class="box">
	<div class="box-header bg-transparent">
		<div class="box-title" style="margin-top: 10px;"><i class="fontello-th-list" style="font-size: larger; font-weight: bold;"></i>
			<span style="font-size: medium; font-weight: bold; margin-top: 20px;"><?= __('View Alumni Baseline Survey Questionnaire'); ?></span>
		</div>
	</div>
    <div class="box-body">
    	<div class="row">
			<div class="large-12 columns">
				
				<div style="margin-top: -30px;"><hr></div>
				<?= $this->Form->create('Alumnus'); ?>

				<div onclick="toggleViewFullId('ListDepartment')">
					<?php 
					if (!empty($sections)) {
						echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg')); ?>
						<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt"> Display Filter</span>
						<?php
					} else {
						echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg')); ?>
						<span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt"> Hide Filter</span>
						<?php
					} ?>
				</div>

				<div id="ListDepartment" style="display:<?= (!empty($sections) ? 'none' : 'display'); ?>">
					<fieldset style="padding-bottom: 0px;padding-top: 15px;">
						<!-- <legend>&nbsp;&nbsp; Search Filters &nbsp;&nbsp;</legend> -->
						<div class="row">
							<div class="large-3 columns">
								<?= $this->Form->input('Search.gradution_academic_year', array('id' => 'GradutionAcademicYear', 'label' => 'Gradution Academic Year: ', 'class' => 'fs14', 'style' => 'width:90%', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('Search.program_id', array('label' => 'Program: ', 'style' => 'width:90%', 'empty' => 'All Programs', 'options' => $programs)); ?>
							</div>
							<div class="large-3 columns">
								<?= $this->Form->input('Search.program_type_id', array('label' => 'Program Type: ', 'style' => 'width:90%', 'empty' => 'All Program Types', 'options' => $programTypes)); ?>
							</div>
							<div class="large-3 columns">
							<?= $this->Form->input('Search.name', array('label' => 'Student Name ID: ', 'placeholder' => 'Name or Student ID ..', 'default' => $name, 'style' => 'width:90%;')); ?>
							</div>
						</div>
						<div class="row">
							<div class="large-6 columns">
								<?php
								if (isset($departments) && !empty($departments)) {
									echo $this->Form->input('Search.department_id', array('id' => 'ProgramType', 'class' => 'fs13', 'style' => 'width:90%', 'label' => 'Department: ', 'type' => 'select', 'options' => $departments, 'default' => $default_department_id));
								} ?>
							</div>
							<div class="large-3 columns">
							<?= $this->Form->input('Search.limit', array('id' => 'limit ', 'type' => 'number', 'min' => '1',  'max' => '5000', 'value' => (isset($this->data['Search']['limit']) ? $this->data['Search']['limit'] : ''), 'step' => '1', 'label' => 'Limit: ', 'style' => 'width:40%;')); ?>
							</div>
							<div class="large-3 columns">
								
								
								<?= (isset($this->data['Search']['page']) ? $this->Form->hidden('page', array('value' => $this->data['Search']['page'])) : ''); ?>
								<?= (isset($this->data['Search']['sort']) ? $this->Form->hidden('sort', array('value' => $this->data['Search']['sort'])) : ''); ?>
								<?= (isset($this->data['Search']['direction']) ? $this->Form->hidden('direction', array('value' => $this->data['Search']['direction'])) : ''); ?>

							</div>
						</div>
						<hr>
						<?= $this->Form->submit(__('Get Alumni'), array('name' => 'listAlumni', 'class' => 'tiny radius button bg-blue', 'div' => false)); ?>
					</fieldset>
				</div>
				<hr>

				<?php
				if (isset($alumni) && empty($alumni)) {?>
					<div class='info-box info-message' style="font-family: 'Times New Roman', Times, serif; font-weight: bold;"><span style='margin-right: 15px;'></span>There is no alumni student in the selected section</div>
					<?php
				} else if (isset($alumni) && !empty($alumni)) { ?>

					<!-- <h6 class="fs13 text-gray">Please select alumni/s for whom you want to completed baseline survey questionnaire.</h6> -->
					
					<h6 class="fs13 rejected">Red: Not graduated but completed survey</h6>
					<h6 class="fs13 accepted">Green: Graduated and completed survey.</h6>
					
					<h6 id="validation-message_non_selected" class="text-red fs14"></h6>
					<br>

					<div style="overflow-x:auto;">
						<table cellpadding="0" cellspacing="0" class="table">
							<thead>
								<tr>
									<th style="width:5%" class="center"><div style="margin-left: 10%;"><?= $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false, 'label' => false)); ?></div></th>
									<th style="width:4%" class="center">#</th>
									<th style="width:30%" class="venter">Student Name</th>
									<th class="center">Sex</th>
									<th class="center">Student ID</th>
									<th style="width:35%" class="vcenter">Department</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$st_count = 0;
								foreach($alumni as $key => $student) {
									$st_count++;
									$class = null;
									debug($student);
									
									if (empty($student['Student']['SenateList'])) {
										$class = ' class="rejected"';
									} else if(!empty($student['Student']['SenateList'])) {
										$class = ' class="accepted"';
									} ?>

									<tr <?= $class;?>>
										<td class="center">
											<div style="margin-left: 15%;"><?= $this->Form->input('Alumnus.'.$st_count.'.gp', array('type' => 'checkbox', 'label' => false, 'id' => 'AlumnusSelection'.$st_count,'class'=>'checkbox1')); ?></div>
											<?= $this->Form->input('Alumnus.'.$st_count.'.student_id', array('type' => 'hidden', 'value' => $student['Student']['id'])); ?>
										</td>
										<td class="center"><?= $st_count; ?></td>
										<td class="vcenter"><?= $student['Alumnus']['full_name']; ?></td>
										<td class="center"><?= (strcasecmp(trim($student['Alumnus']['sex']), 'male') == 0 ? 'M' : (strcasecmp(trim($student['Alumnus']['sex']), 'female') == 0 ? 'F' : '')); ?></td>
										<td class="center"><?= $student['Student']['studentnumber']; ?></td>
										<td class="vcenter"><?= $student['Student']['Department']['name']; ?></td>
									</tr>
									<?php
								} ?>
							</tbody>
						</table>
					</div>
					<hr>
					
					<div class="row">
						<div class="large-3 columns">
							<?= $this->Form->submit(__('Get  Alumni Questionnaire'), array('name' => 'getAlumniQuestionnaireInExcel', 'div' => false,'class'=>'tiny radius button bg-blue')); echo '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
						</div>
						<div class="large-3 columns">
							<?= $this->Form->submit(__('Delete Alumni Questionnaire Not Graduated'), array('name' => 'deleteAlumniQuestionnaireInExcel', 'div' => false,'class'=>'tiny radius button bg-blue')); ?>
						</div>
						<div class="large-6 columns">

						</div>
						
					</div>
					<?php
					
				} ?>
				<?= $this->Form->end(); ?>
			</div>
       	</div>
    </div>
</div>

<script>
	$(function() {
		$("#Department").customselect();
	});

	function toggleView(obj) {
		if($('#c'+obj.id).css("display") == 'none') {
			$('#i'+obj.id).attr("src", '/img/minus2.gif');
		} else {
			$('#i'+obj.id).attr("src", '/img/plus2.gif');
		}
		$('#c'+obj.id).toggle("slow");
	}

	function toggleViewFullId(id) {
		if($('#'+id).css("display") == 'none') {
			$('#'+id+'Img').attr("src", '/img/minus2.gif');
			$('#'+id+'Txt').empty();
			$('#'+id+'Txt').append('Hide Filter');
		} else {
			$('#'+id+'Img').attr("src", '/img/plus2.gif');
			$('#'+id+'Txt').empty();
			$('#'+id+'Txt').append('Display Filter');
		}
		$('#'+id).toggle("slow");
	}
</script>
