<?php
if(!isset($freshman_program) || !$freshman_program) {
	$approver = 'department';
	$approver_c = 'Department';
}
else {
	$approver = 'freshman program';
	$approver_c = 'Freshman Program';
}

?>
<style>
table.grade_history_detail tr td{
	padding:1px;
	vertical-align:middle;
}
</style>
<?php
if(count($student_exam_grade_history) > 0) {
	echo '<div style="font-weight:bold; font-size:14px">Grade History (Detail: From recent to old)</div>';
	?>
	<table class="grade_history_detail">
	<?php
	}
if(isset($student_exam_grade_change_history) && !empty($student_exam_grade_change_history)) {
	for($i = count($student_exam_grade_change_history)-1; $i >= 0; $i--) {
		if(strcasecmp($student_exam_grade_change_history[$i]['type'], 'Change') == 0) {
			$exam_grade_change = $student_exam_grade_change_history[$i]['ExamGrade'];
		$reject_count = 1;
		?>
		<tr>
			<th colspan="2">
			<?php
			$department_reply = false;
			if($exam_grade_change['manual_ng_conversion'] == 1)
				echo 'Registrar NG Grade Conversion';
			else if($exam_grade_change['auto_ng_conversion'] == 1)
				echo 'Automatic F';
			else if($exam_grade_change['makeup_exam_result'] != null) {
				echo ($exam_grade_change['department_reply'] == 0 ? ($exam_grade_change['makeup_exam_id'] == null ? 'Supplementary Exam' : 'Makeup Exam') : $approver_c.' response for registrar '.($exam_grade_change['makeup_exam_id'] == null ? 'supplementary exam' : 'makeup exam').' grade rejection');
				if($exam_grade_change['department_reply'] == 1)
					$department_reply = true;
			}
			else {
				echo 'Exam Grade Change ('.($exam_grade_change['initiated_by_department'] == 1 ? 'By the department' : 'By the instructor').')';
			}
			?>
			</th>
		</tr>
		<?php
		if($exam_grade_change['manual_ng_conversion'] == 1) {
		?>
		<tr>
			<td style="width:20%; font-weight:bold">NG Converted to:</td>
			<td style="width:80%"><?php echo $exam_grade_change['grade']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Minute Number:</td>
			<td><?php echo $exam_grade_change['minute_number']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Convertion Date:</td>
			<td><?php echo $this->Format->humanize_date($exam_grade_change['created']); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Converted By:</td>
			<td><?php echo ($exam_grade_change['manual_ng_converted_by_name'] != "" ? $exam_grade_change['manual_ng_converted_by_name'] : '---'); ?></td>
		</tr>
		<?php
		}
		else if($exam_grade_change['auto_ng_conversion'] == 1) {
		?>
		<tr>
			<td style="width:20%; font-weight:bold">Auto Grade:</td>
			<td style="width:80%"><?php echo $exam_grade_change['grade']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Auto Convertion Date:</td>
			<td><?php echo $this->Format->humanize_date($exam_grade_change['created']); ?></td>
		</tr>
		<?php
		}
		else {
		 if(!$department_reply) { ?>
		<tr>
			<td style="width:20%; font-weight:bold">Grade:</td>
			<td style="width:80%"><?php echo $exam_grade_change['grade']; ?></td>
		</tr>
		<?php
		if(!empty($exam_grade_change['minute_number'])) {
		?>
		<tr>
			<td style="width:18%; font-weight:bold">Minute Number:</td>
			<td style="width:82%"><?php echo $exam_grade_change['minute_number']; ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td style="width:18%; font-weight:bold">Exam Result:</td>
			<td style="width:82%"><?php echo $exam_grade_change['makeup_exam_result'] == null ? $exam_grade_change['result'] : $exam_grade_change['makeup_exam_result']; ?></td>
		</tr>
		<?php
		if($exam_grade_change['makeup_exam_result'] == null) {
		?>
		<tr>
			<td style="width:18%; font-weight:bold">Grade Change Reason:</td>
			<td style="width:82%"><?php echo $exam_grade_change['reason']; ?></td>
		</tr>
		<?php
		}
		if($exam_grade_change['makeup_exam_result'] != null && $exam_grade_change['makeup_exam_id'] == null) {
		?>
		<tr>
			<td style="width:18%; font-weight:bold">Remark:</td>
			<td style="width:82%"><?php echo $exam_grade_change['reason']; ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td style="font-weight:bold">Request Date:</td>
			<td><?php echo $this->Format->humanize_date($exam_grade_change['created']); ?></td>
		</tr>
		<?php
		}
		if(!(empty($exam_grade_change['makeup_exam_id']) && $exam_grade_change['makeup_exam_result'] != null)) {
		?>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Approval:</td>
			<td class="<?php echo ($exam_grade_change['department_approval'] == 1 ? 'accepted' : ($exam_grade_change['department_approval'] == -1 ? 'rejected' : 'on-process')); ?>"><?php echo ($exam_grade_change['department_approval'] == 1 ? 'Accepted' : ($exam_grade_change['department_approval'] == -1 ? 'Rejected' : 'On Process')); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Approval By:</td>
			<td><?php echo ($exam_grade_change['department_approved_by_name'] != "" ? $exam_grade_change['department_approved_by_name'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Remark:</td>
			<td><?php echo ($exam_grade_change['department_reason'] != "" ? $exam_grade_change['department_reason'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Approval Date:</td>
			<td><?php echo ($exam_grade_change['department_approval_date'] != '0000-00-00 00:00:00' ?$this->Format->humanize_date($exam_grade_change['department_approval_date']) : '---'); ?></td>
		</tr>
		<?php
		}
		if($exam_grade_change['department_reply'] == 1 && empty($exam_grade_change['makeup_exam_id']) && $exam_grade_change['makeup_exam_result'] != null) {
		?>
		<tr>
			<td style="width:20%; font-weight:bold">Grade:</td>
			<td style="width:80%"><?php echo $exam_grade_change['grade']; ?></td>
		</tr>
		<tr>
			<td style="width:18%; font-weight:bold">Exam Result:</td>
			<td style="width:82%"><?php echo $exam_grade_change['makeup_exam_result'] == null ? $exam_grade_change['result'] : $exam_grade_change['makeup_exam_result']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Reply:</td>
			<td><?php echo ($exam_grade_change['department_reason'] != "" ? $exam_grade_change['department_reason'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Reply By:</td>
			<td><?php echo ($exam_grade_change['department_approved_by_name'] != "" ? $exam_grade_change['department_approved_by_name'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Reply Date:</td>
			<td><?php echo ($exam_grade_change['department_approval_date'] != '0000-00-00 00:00:00' ?$this->Format->humanize_date($exam_grade_change['department_approval_date']) : '---'); ?></td>
		</tr>
		<?php
		}
		//If it is only grade chnage
		if($exam_grade_change['makeup_exam_result'] == null) {
		?>
		<tr>
			<td style="font-weight:bold">College Approval:</td>
			<td class="<?php echo ($exam_grade_change['college_approval'] == 1 ? 'accepted' : ($exam_grade_change['college_approval'] == -1 ? 'rejected' : ($exam_grade_change['department_approval'] == 1 ? 'on-process' : ''))); ?>"><?php echo ($exam_grade_change['college_approval'] == 1 ? 'Accepted' : ($exam_grade_change['college_approval'] == -1 ? 'Rejected' : ($exam_grade_change['department_approval'] == 1 ? 'On Process' : '---'))); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Approval By:</td>
			<td><?php echo ($exam_grade_change['college_approved_by_name'] != "" ? $exam_grade_change['college_approved_by_name'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">College Remark:</td>
			<td><?php echo ($exam_grade_change['college_reason'] != "" ? $exam_grade_change['college_reason']: '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">College Approval Date:</th>
			<td><?php echo ($exam_grade_change['college_approval_date'] != '0000-00-00 00:00:00' ? $this->Format->humanize_date($exam_grade_change['college_approval_date']) : '---'); ?></td>
		</tr>
		<?php
		}
		if($exam_grade_change['makeup_exam_result'] != null) {
		?>
		<tr>
			<td style="font-weight:bold">Registrar Approval:</td>
			<td class="<?php echo ($exam_grade_change['registrar_approval'] == 1 ? 'accepted' : ($exam_grade_change['registrar_approval'] == -1 ? 'rejected' : ($exam_grade_change['department_approval'] == 1 ? 'on-process' : ''))); ?>"><?php echo ($exam_grade_change['registrar_approval'] == 1 ? 'Accepted' : ($exam_grade_change['registrar_approval'] == -1 ? 'Rejected' : ($exam_grade_change['department_approval'] == 1 ? 'On Process' : '---'))); ?></td>
		</tr>
		<?php
		}
		else {
		?>
		<tr>
			<td style="font-weight:bold">Registrar Approval:</td>
			<td class="<?php echo ($exam_grade_change['registrar_approval'] == 1 ? 'accepted' : ($exam_grade_change['registrar_approval'] == -1 ? 'rejected' : ($exam_grade_change['college_approval'] == 1 ? 'on-process' : ''))); ?>"><?php echo ($exam_grade_change['registrar_approval'] == 1 ? 'Accepted' : ($exam_grade_change['registrar_approval'] == -1 ? 'Rejected' : ($exam_grade_change['college_approval'] == 1 ? 'On Process' : '---'))); ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td style="font-weight:bold">Approval By:</td>
			<td><?php echo ($exam_grade_change['registrar_approved_by_name'] != "" ? $exam_grade_change['registrar_approved_by_name'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Registrar Remark:</td>
			<td><?php echo ($exam_grade_change['registrar_reason'] != "" ? $exam_grade_change['registrar_reason']: '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Registrar Approval Date:</th>
			<td><?php echo ($exam_grade_change['registrar_approval_date'] != '0000-00-00 00:00:00' ? $this->Format->humanize_date($exam_grade_change['registrar_approval_date']) : '---'); ?></td>
		</tr>
		<?php
		}
		}
	}
}




//Grade history
if(count($student_exam_grade_history) > 0) {
	?>
		<?php
		$reject_count = 1;
		foreach($student_exam_grade_history as $key => $exam_grade_detail) {
			if(isset($exam_grade_detail['ExamGrade']))
				$exam_grade_detail = $exam_grade_detail['ExamGrade'];
		?>
		<tr>
			<th colspan="2"><?php echo ($exam_grade_detail['department_reply'] == 0 ? 'Grade History '.$reject_count++ : $approver_c.' response for registrar exam grade rejection'); ?></th>
		</tr>
		<?php if($exam_grade_detail['department_reply'] == 0) { ?>
		<tr>
			<td style="width:18%; font-weight:bold">Grade:</td>
			<td style="width:82%"><?php echo $exam_grade_detail['grade']; ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Date Grade Submitted:</td>
			<td><?php echo $this->Format->humanize_date($exam_grade_detail['created']); ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Approval:</td>
			<td class="<?php echo ($exam_grade_detail['department_approval'] == 1 ? 'accepted' : ($exam_grade_detail['department_approval'] == -1 ? 'rejected' : 'on-process')); ?>"><?php echo ($exam_grade_detail['department_approval'] == 1 ? 'Accepted' : ($exam_grade_detail['department_approval'] == -1 ? 'Rejected' : 'On Process')); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Approval By:</td>
			<td><?php echo ($exam_grade_detail['department_approved_by_name'] != "" ? $exam_grade_detail['department_approved_by_name'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Remark:</td>
			<td><?php echo ($exam_grade_detail['department_reason'] != "" ? $exam_grade_detail['department_reason'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold"><?php echo $approver_c; ?> Approval Date:</td>
			<td><?php echo ($exam_grade_detail['department_approval_date'] != '0000-00-00 00:00:00' ?$this->Format->humanize_date($exam_grade_detail['department_approval_date']) : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Registrar Approval:</td>
			<td class="<?php echo ($exam_grade_detail['registrar_approval'] == 1 ? 'accepted' : ($exam_grade_detail['registrar_approval'] == -1 ? 'rejected' : ($exam_grade_detail['department_approval'] != -1 ? 'on-process' : ''))); ?>"><?php echo ($exam_grade_detail['registrar_approval'] == 1 ? 'Accepted' : ($exam_grade_detail['registrar_approval'] == -1 ? 'Rejected' : ($exam_grade_detail['department_approval'] == 1 ? 'On Process' : '---'))); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Approval By:</td>
			<td><?php echo ($exam_grade_detail['registrar_approved_by_name'] != "" ? $exam_grade_detail['registrar_approved_by_name'] : '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Registrar Remark:</td>
			<td><?php echo ($exam_grade_detail['registrar_reason'] != "" ? $exam_grade_detail['registrar_reason']: '---'); ?></td>
		</tr>
		<tr>
			<td style="font-weight:bold">Registrar Approval Date:</th>
			<td><?php echo ($exam_grade_detail['registrar_approval_date'] != '0000-00-00 00:00:00' ? $this->Format->humanize_date($exam_grade_detail['registrar_approval_date']) : '---'); ?></td>
		</tr>
		<?php
		}
}

if(count($student_exam_grade_history) > 0) {
	?>
	</table>
	<?php
	}
?>
