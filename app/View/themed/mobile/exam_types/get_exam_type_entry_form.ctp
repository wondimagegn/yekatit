<?php echo $this->Form->input('ExamType.edit', array('type' => 'hidden', 'value' => $edit));?>
<?php
if(!empty($published_course_id)) {
	$input_disable = ($grade_submitted ? "disabled" : false);
	if($view_only && empty($exam_types)) {
		?>
		<div id="flashMessage" class="info-box info-message"><span></span>Exam setup is not yet created by the assigned instructor for the published course you selected. If you want to manage the exam setup on belhalf of the instructor, the instructor account should be closed by the system administrator.</div>
		<?php
	}
	else if(!$grade_submitted) {
		?>
		<p class="fs14">Please enter all the exam type for the course you selected with its weight in the given field, below.</p>
		<?php
	}
	else{
		?>
		<div id="flashMessage" class="info-box info-message"><span></span>Exam grade is submited and changes on the exam setup is disabled.</div>
		<?php
	}
	if(!$view_only || ($view_only && !empty($exam_types))) {
	?>
	<table cellspacing="0" cellpadding="0" id="exam_setup" style="margin-bottom:5px">
		<tr>
			<th style="width:5%">No</th>
			<th style="width:25%">Exam Type</th>
			<th style="width:20%">In Percent</th>
			<th style="width:20%">Order</th>
			<th style="width:10%">Mandatory</th>
			<th style="width:20%">&nbsp;</th>
		</tr>
		<?php
		if(empty($exam_types) && !$view_only) {
			?>
			<tr id="ExamType_1">
				<td style="vertical-align:middle">1</td>
				<td><?php echo $this->Form->input('ExamType.1.exam_name', array('label' => false));?></td>
				<td><?php echo $this->Form->input('ExamType.1.percent', array('label' => false, 'style' => 'width:75px'));?></td>
				<td><?php echo $this->Form->input('ExamType.1.order', array('type' => 'text', 'label' => false, 'maxlength' => '2', 'style' => 'width:75px'));?></td>
				<td><?php echo $this->Form->input('ExamType.1.mandatory', array('label' => false));?></td>
				<td><a href="javascript:deleteSpecificRow('ExamType_1')">Delete</a></td>
			</tr>
			<?php
			}
		else{
			$count = 0;
			foreach($exam_types as $key => $exam_type) {
				if(!$grade_submitted && !$view_only) {
					?>
					<tr id="ExamType_<?php echo ++$count; ?>">
						<td style="vertical-align:middle"><?php echo $count; ?></td>
						<td><?php echo $this->Form->input('ExamType.'.$count.'.id', array('type' => 'hidden', 'value' => $exam_type['ExamType']['id']));?>
							<?php echo $this->Form->input('ExamType.'.$count.'.exam_name', array('value' => $exam_type['ExamType']['exam_name'], 'label' => false, 'disabled' => $input_disable));?></td>
						<td><?php echo $this->Form->input('ExamType.'.$count.'.percent', array('value' => $exam_type['ExamType']['percent'], 'label' => false, 'style' => 'width:75px', 'disabled' => $input_disable));?></td>
						<td><?php echo $this->Form->input('ExamType.'.$count.'.order', array('type' => 'text', 'value' => ($exam_type['ExamType']['order'] != 0 ? $exam_type['ExamType']['order'] : ''), 'label' => false, 'maxlength' => '2', 'style' => 'width:75px', 'disabled' => $input_disable));?></td>
						<td><?php
						$coptions = array();
						$coptions['value'] = 1;
						$coptions['label'] = false;
						$coptions['disabled'] = $input_disable;
						if($exam_type['ExamType']['mandatory'] == 1)
							$coptions['checked'] = 'checked';
						echo $this->Form->input('ExamType.'.$count.'.mandatory', $coptions);?></td>
						<td><?php if(!$grade_submitted) { ?><a href="javascript:deleteSpecificRow('ExamType_<?php echo $count; ?>')">Delete</a><?php } ?></td>
					</tr>
					<?php
				}
				else {
					?>
					<tr>
						<td style="vertical-align:middle"><?php echo ++$count; ?></td>
						<td><?php echo $exam_type['ExamType']['exam_name']; ?></td>
						<td><?php echo $exam_type['ExamType']['percent'].'%'; ?></td>
						<td><?php echo $exam_type['ExamType']['order']; ?></td>
						<td><?php echo ($exam_type['ExamType']['mandatory'] == 1 ? 'Yes' : 'No'); ?></td>
						<td>&nbsp;</td>
					</tr>
					<?php
				}
			}
		$count++;
		}
		?>
	</table>
	<?php
		}//End of view only with empty checking
	if(!$grade_submitted && !$view_only) {
		?>
		<p><input type="button" value="Add Row" onclick="addRow('exam_setup', 'ExamType', 5, '<?php echo $all_exam_setup_detail; ?>')" /></p>
		<div id="flashMessage" class="info-box info-message"><span></span>Important Note: If a student fail to take any of the mandatory exam/s, the system will automatically give NG to the student.</div>
		<?php
		echo $this->Form->submit(__('Submit Exam Setup', true), array('div' => false));
		}
	}
else
	echo '<div id="flashMessage" class="info-box info-message"><span></span>Please select a course to get to get exam setup form.</div>';
?>
