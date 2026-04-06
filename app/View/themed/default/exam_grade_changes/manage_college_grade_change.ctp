<?php ?>
<script>
function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}
</script>
<div style="margin-bottom:10px" class="smallheading">Exam Grade Change Approval</div>
<?php echo $this->Form->create('ExamGradeChange');
if(!empty($exam_grade_changes)) {
?>
<div style="font-size:14px; font-weight:bold">Exam grade change requests by instructors and/or departement and which are approved by the department</div>
<?php
	}
else	{
?>
<div id="flashMessage" class="info-box info-message"><span></span>There is no exam grade change request to approve. Exam grade changes are required to be placed by either instructor or department and approved by departement in-order to appear here.</div>
<?php
}
$st_count = 1;
foreach($exam_grade_changes as $department_name => $department_grade_changes) {
		foreach($department_grade_changes as $program_name => $program_grade_changes) {
			foreach($program_grade_changes as $program_type_name => $program_type_grade_changes) {
			?>
<table>
	<tr>
		<td colspan="7">
			<table style="margin:0px; border:dashed 2px #CCCCCC">
				<tr class="fs13">
					<td style="font-weight:bold; width:5%">Department:</td>
					<td style="width:20%"><?php echo $department_name; ?></td>
					<td style="font-weight:bold; width:5%">Program:</td>
					<td style="width:13%"><?php echo $program_name; ?></td>
					<td style="font-weight:bold; width:12%">Program Type:</td>
					<td style="width:45%"><?php echo $program_type_name; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th style="width:2%">&nbsp;</td>
		<th style="width:18%">Student Name</th>
		<th style="width:10%">ID</th>
		<th style="width:30%">Course</th>
		<th style="width:10%">Previous Grade</th>
		<th style="width:10%">New Grade</th>
		<th style="width:20%">Request Date</th>
	</tr>
	<?php
	foreach($program_type_grade_changes as $key => $grade_change) {
	?>
	<tr>
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
		<td><?php echo $grade_change['Student']['first_name'].' '.$grade_change['Student']['middle_name'].' '.$grade_change['Student']['last_name']; ?></td>
		<td><?php echo $grade_change['Student']['studentnumber']; ?></td>
		<td><?php echo $grade_change['Course']['course_title'].' ('.$grade_change['Course']['course_code'].')'; ?></td>
		<td><?php echo $grade_change['latest_grade']; ?></td>
		<td><?php echo $grade_change['ExamGradeChange']['grade']; ?></td>
		<td><?php echo $this->Format->humanize_date($grade_change['ExamGradeChange']['created']); ?></td>
	</tr>
	<tr id="c<?php echo $st_count; ?>" style="display:none">
		<td>&nbsp;</td>
		<td colspan="6">
		<table>
			<?php
				if($grade_change['ExamGradeChange']['initiated_by_department'] == 1) {
				?>
				<tr>
					<td class="fs14" colspan="2" style="font-weight:bold">Importnat Note: This exam grade change is requested by the department; not instructor.</td>
				</tr>
				<?php
				}
				?>
			<tr>
				<td style="width:15%; font-weight:bold">Section:</td>
				<td style="width:85%"><?php echo $grade_change['Section']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Instructor:</td>
				<td><?php echo $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Reason for Change:</td>
				<td><?php echo $grade_change['ExamGradeChange']['reason']; ?></td>
			</tr>
		</table>
		<table>
			<tr>
				<td style="vertical-align:top; width:40%">
		<?php
		//debug($grade_change);
		$register_or_add = 'gh';
		if(isset($grade_change['ExamGradeHistory']))
			$grade_history = $grade_change['ExamGradeHistory'];
		else
			$grade_history = array();
		if($grade_change['Section']['department_id'] == null)
			$freshman_program = true;
		else
			$freshman_program = false;
		$this->set(compact('register_or_add', 'grade_history', 'freshman_program'));
		echo $this->element('registered_or_add_course_grade_history');
		?>
				</td>
				<td style="vertical-align:top; width:60%">
					<table>
						<tr>
							<th colspan="2">
							<?php
							echo '<div style="font-weight:bold; font-size:14px">Grade Change Request Approval</div>';
							?>
							</th>
						</tr>
						<tr>
							<td style="width:18%">Accept / Reject:</td>
							<td style="width:82%">
								<?php
								echo $this->Form->input('ExamGradeChange.'.$st_count.'.id', array('type' => 'hidden', 'value' => $grade_change['ExamGradeChange']['id']));
								$options=array('1'=>'Accept','-1'=>'Reject');
								$attributes=array('legend'=>false,'label'=>false,
								'separator'=>"<br />", 'default' => 1);
								echo $this->Form->radio('ExamGradeChange.'.$st_count.'.college_approval', $options, $attributes);
								?>							
							</td>
						</tr>
						<tr>
							<td>Remark:</td>
							<td><?php echo $this->Form->input('ExamGradeChange.'.$st_count.'.college_reason',array('label'=>false, 'cols' => 40)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $this->Form->Submit('Approve Grade Change Request',array('div'=>false, 'name'=>'approveGradeChangeByCollege_'.$st_count++)); ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php
		$student_exam_grade_change_history = $grade_change['ExamGradeHistory'];
		$student_exam_grade_history = $grade_change['ExamGrade'];
		$this->set(compact('student_exam_grade_history', 'student_exam_grade_change_history'));
		echo $this->element('registered_or_add_course_grade_detail_history');
		//debug($grade_change);
		?>
		</td>
	</tr>
	<?php
	}
	?>
</table>
		<?php
		}
	}
}
echo $this->Form->input('grade_change_count', array('type' => 'hidden', 'value' => ($st_count-1)));
echo $this->Form->end();
?>
