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
<?php
$st_count = 1;
?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
              
<div style="margin-bottom:10px" class="smallheading">Exam Grade Change, Makeup &amp; Supplementary Exam Approval</div>
<?php echo $this->Form->create('ExamGradeChange');
if(!empty($exam_grade_changes)) {
?>
<div style="font-size:14px; font-weight:bold">Exam grade change request from instructors for approval</div>
<?php
	}
foreach($exam_grade_changes as $program_name => $program_grade_changes) {
	foreach($program_grade_changes as $program_type_name => $program_type_grade_changes) {
	?>
<table style="margin-bottom:15px">
	<tr>
		<td colspan="7">
			<table style="margin:0px; border:dashed 2px #CCCCCC">
				<tr class="fs13">
					<td style="font-weight:bold; width:5%">Program:</td>
					<td style="width:13%"><?php echo $program_name; ?></td>
					<td style="font-weight:bold; width:12%">Program Type:</td>
					<td style="width:70%"><?php echo $program_type_name; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	    
	    <th style="width:10%"><?php echo $this->Form->input('Mass.ExamGradeChange.select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false,'label' => false)); ?>
	    Select All</th>
			 
		<th style="width:2%">&nbsp;</td>
		<th style="width:15%">Student Name</th>
		<th style="width:10%">ID</th>
		<th style="width:25%">Course</th>
		<th style="width:10%">Previous Grade</th>
		<th style="width:10%">New Grade</th>
		<th style="width:15%">Request Date</th>
	</tr>
	<?php
	foreach($program_type_grade_changes as $key => $grade_change) {
	?>
	<tr>
	    <td>
	    <?php 
	      echo $this->Form->input('Mass.ExamGradeChange.'.$st_count.'.gp', array('type' => 'checkbox', 'label' => false, 'id' => 'ExamGradeChange'.$st_count,'class'=>'checkbox1'));
	      
	      echo $this->Form->input('Mass.ExamGradeChange.'.$st_count.'.id', array('type' => 'hidden', 'value' => $grade_change['ExamGradeChange']['id']));
	      
	       echo $this->Form->input('Mass.ExamGradeChange.'.$st_count.'.department_approval', array('type' => 'hidden', 'value' =>1));
	      
	      
	      
	      ?>
	    </td>
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
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
			<tr>
				<td style="width:15%; font-weight:bold">Section:</td>
				<td style="width:85%"><?php echo $grade_change['Section']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Instructor:</td>
				<td><?php echo (isset($grade_change['Staff']) && !empty($grade_change['Staff']) ? $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name'] : '---'); ?></td>
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
								echo $this->Form->radio('ExamGradeChange.'.$st_count.'.department_approval', $options, $attributes);
								?>							
							</td>
						</tr>
						<tr>
							<td>Remark:</td>
							<td><?php echo $this->Form->input('ExamGradeChange.'.$st_count.'.department_reason',array('label'=>false, 'cols' => 40)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $this->Form->Submit('Approve Grade Change Request',array('div'=>false,'class'=>'tiny radius button bg-blue', 'name'=>'approveGradeChangeByDepartment_'.$st_count++)); ?></td>
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
?>
<?php if(count($exam_grade_changes)>1) { ?>
    		<?php echo $this->Form->Submit('Approve All Grade Change Request',array('div'=>false,'class'=>'tiny radius button bg-blue', 'name'=>'ApproveAllGradeChangeByDepartment')); ?></td>
		
 <?php } ?>
<br />
<?php
/************************************  MAKEUP EXAM **************************************/
if(!empty($makeup_exam_grade_changes)) {
?>
<div style="font-size:14px; font-weight:bold">Makeup exam approval request from instructors</div>
<?php
	}
foreach($makeup_exam_grade_changes as $program_name => $program_grade_changes) {
	foreach($program_grade_changes as $program_type_name => $program_type_grade_changes) {
	?>
<table>
	<tr>
		<td colspan="7">
			<table style="margin:0px; border:dashed 2px #CCCCCC">
				<tr class="fs13">
					<td style="font-weight:bold; width:5%">Program:</td>
					<td style="width:13%"><?php echo $program_name; ?></td>
					<td style="font-weight:bold; width:12%">Program Type:</td>
					<td style="width:70%"><?php echo $program_type_name; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th style="width:2%">&nbsp;</td>
		<th style="width:15%">Student Name</th>
		<th style="width:10%">ID</th>
		<th style="width:25%">Exam Taken for</th>
		<th style="width:25%">Exam Course</th>
		<th style="width:5%">Grade</th>
		<th style="width:18%">Request Date</th>
	</tr>
	<?php
	foreach($program_type_grade_changes as $key => $grade_change) {
	?>
	<tr>
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
		<td><?php echo $grade_change['Student']['first_name'].' '.$grade_change['Student']['middle_name'].' '.$grade_change['Student']['last_name']; ?></td>
		<td><?php echo $grade_change['Student']['studentnumber']; ?></td>
		<td><?php echo $grade_change['Course']['course_title'].' ('.$grade_change['Course']['course_code'].')'; ?></td>
		<td><?php echo $grade_change['ExamCourse']['course_title'].' ('.$grade_change['ExamCourse']['course_code'].')'; ?></td>
		<td><?php echo $grade_change['ExamGradeChange']['grade']; ?></td>
		<td><?php echo $this->Format->humanize_date($grade_change['ExamGradeChange']['created']); ?></td>
	</tr>
	<tr id="c<?php echo $st_count; ?>" style="display:none">
		<td>&nbsp;</td>
		<td colspan="6">
		<?php
		if(!isset($grade_change['MakeupExam'])) {
		?>
		<table>
			<tr>
				<td style="width:15%; font-weight:bold">Section:</td>
				<td style="width:85%"><?php echo $grade_change['Section']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Instructor:</td>
				<td><?php echo (isset($grade_change['Staff']) && !empty($grade_change['Staff']) ? $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name'] : '---'); ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Reason for Change:</td>
				<td><?php echo $grade_change['ExamGradeChange']['reason']; ?></td>
			</tr>
		</table>
		<?php
		}
		else {
		?>
		<table>
			<tr>
				<td style="width:12%; font-weight:bold">Minute number:</td>
				<td style="width:88%"><?php echo $grade_change['MakeupExam']['minute_number']; ?></td>
			</tr>
			<tr>
				<td style="width:12%; font-weight:bold">Exam section:</td>
				<td style="width:88%"><?php echo $grade_change['ExamSection']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Exam given by:</td>
				<td><?php echo $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name']; ?></td>
			</tr>
		</table>
		<?php
		}
		?>
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
		$this->set(compact('register_or_add', 'grade_history'));
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
								echo $this->Form->radio('ExamGradeChange.'.$st_count.'.department_approval', $options, $attributes);
								?>							
							</td>
						</tr>
						<tr>
							<td>Remark:</td>
							<td><?php echo $this->Form->input('ExamGradeChange.'.$st_count.'.department_reason',array('label'=>false, 'cols' => 40)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $this->Form->Submit('Approve Grade Change Request',array('div'=>false,'class'=>'tiny radius button bg-blue', 'name'=>'approveGradeChangeByDepartment_'.$st_count++)); ?></td>
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
?>
<br />
<?php
/**************************** REJECTED MAKEUP EXAM GRADE CHANGE ***********************************/
if(!empty($rejected_makeup_exam_grade_changes)) {
?>
<div style="font-size:14px; font-weight:bold" class="rejected">Rejected makeup exam grades from registrar</div>
<p class="fs13">You are required either to reject the makeup exam so that the instructor can modify the result and resubmit the grade again or to accept it again (even if it is rejected by the registrar) so that the registrar can consider the makeup exam grade based on the remark you sent to them.</p>

<?php
	}
foreach($rejected_makeup_exam_grade_changes as $program_name => $program_grade_changes) {
	foreach($program_grade_changes as $program_type_name => $program_type_grade_changes) {
	?>
<table>
	<tr>
		<td colspan="7">
			<table style="margin:0px; border:dashed 2px #CCCCCC">
				<tr class="fs13">
					<td style="font-weight:bold; width:5%">Program:</td>
					<td style="width:13%"><?php echo $program_name; ?></td>
					<td style="font-weight:bold; width:12%">Program Type:</td>
					<td style="width:70%"><?php echo $program_type_name; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th style="width:2%">&nbsp;</td>
		<th style="width:15%">Student Name</th>
		<th style="width:10%">ID</th>
		<th style="width:25%">Exam Taken for</th>
		<th style="width:25%">Exam Course</th>
		<th style="width:5%">Grade</th>
		<th style="width:18%">Request Date</th>
	</tr>
	<?php
	foreach($program_type_grade_changes as $key => $grade_change) {
	?>
	<tr>
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
		<td><?php echo $grade_change['Student']['first_name'].' '.$grade_change['Student']['middle_name'].' '.$grade_change['Student']['last_name']; ?></td>
		<td><?php echo $grade_change['Student']['studentnumber']; ?></td>
		<td><?php echo $grade_change['Course']['course_title'].' ('.$grade_change['Course']['course_code'].')'; ?></td>
		<td><?php echo $grade_change['ExamCourse']['course_title'].' ('.$grade_change['ExamCourse']['course_code'].')'; ?></td>
		<td><?php echo $grade_change['ExamGradeChange']['grade']; ?></td>
		<td><?php echo $this->Format->humanize_date($grade_change['ExamGradeChange']['created']); ?></td>
	</tr>
	<tr id="c<?php echo $st_count; ?>" style="display:none">
		<td>&nbsp;</td>
		<td colspan="6">
		<?php
		if(!isset($grade_change['MakeupExam'])) {
		?>
		<table>
			<tr>
				<td style="width:15%; font-weight:bold">Section:</td>
				<td style="width:85%"><?php echo $grade_change['Section']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Instructor:</td>
				<td><?php echo (isset($grade_change['Staff']) && !empty($grade_change['Staff']) ? $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name'] : '---'); ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Reason for Change:</td>
				<td><?php echo $grade_change['ExamGradeChange']['reason']; ?></td>
			</tr>
		</table>
		<?php
		}
		else {
		?>
		<table>
			<tr>
				<td style="width:12%; font-weight:bold">Minute number:</td>
				<td style="width:88%"><?php echo $grade_change['MakeupExam']['minute_number']; ?></td>
			</tr>
			<tr>
				<td style="width:12%; font-weight:bold">Exam section:</td>
				<td style="width:88%"><?php echo $grade_change['ExamSection']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Exam given by:</td>
				<td><?php echo $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Registrar remark:</td>
				<td><?php echo ($grade_change['ExamGradeChange']['registrar_reason'] != "" ? $grade_change['ExamGradeChange']['registrar_reason'] : '---'); ?></td>
			</tr>
		</table>
		<?php
		}
		?>
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
		$this->set(compact('register_or_add', 'grade_history'));
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
								echo $this->Form->radio('ExamGradeChange.'.$st_count.'.department_approval', $options, $attributes);
								?>							
							</td>
						</tr>
						<tr>
							<td>Remark:</td>
							<td><?php echo $this->Form->input('ExamGradeChange.'.$st_count.'.department_reason',array('label'=>false, 'cols' => 40)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $this->Form->Submit('Approve Grade Change Request',array('div'=>false,'class'=>'tiny radius button bg-blue', 'name'=>'approveGradeChangeByDepartment_'.$st_count++)); ?></td>
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
echo '<br />';
/************ SUPLEMENTARY EXAM REQUESTED BY THE DEPARTMENT BUT REJECTED BY REGISTRAR ************/
if(!empty($rejected_department_makeup_exam_grade_changes)) {
$key_1 = array_keys($rejected_department_makeup_exam_grade_changes);
$key_2 = array_keys($rejected_department_makeup_exam_grade_changes[$key_1[0]]);
$key_3 = array_keys($rejected_department_makeup_exam_grade_changes[$key_1[0]][$key_2[0]]);
$key_4 = array_keys($rejected_department_makeup_exam_grade_changes[$key_1[0]][$key_2[0]][$key_3[0]]);
if($rejected_department_makeup_exam_grade_changes[$key_1[0]][$key_2[0]][$key_3[0]][$key_4[0]][0]['Section']['department_id'] == null)
	$freshman_program = true;
else
	$freshman_program = false;
?>
<div style="font-size:14px; font-weight:bold; color:red">Rejected supplementary exam grades from registrar<?php //echo 'which was directlly requested by the  '.($freshman_program ? 'freshman program' : 'department'); ?>.</div>
<?php
	}
foreach($rejected_department_makeup_exam_grade_changes as $college_name => $college_grade_changes) {
	foreach($college_grade_changes as $department_name => $department_grade_changes) {
		foreach($department_grade_changes as $program_name => $program_grade_changes) {
			foreach($program_grade_changes as $program_type_name => $program_type_grade_changes) {
			?>
<table>
	<tr>
		<td colspan="7">
			<table style="margin:0px; border:dashed 2px #CCCCCC">
				<tr class="fs13">
					<td style="font-weight:bold; width:5%">Program:</td>
					<td style="width:13%"><?php echo $program_name; ?></td>
					<td style="font-weight:bold; width:12%">Program Type:</td>
					<td style="width:70%"><?php echo $program_type_name; ?></td>
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
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
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
			<tr>
				<td style="width:15%; font-weight:bold">Student Section:</td>
				<td style="width:85%"><?php echo $grade_change['Section']['name']; ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Course Instructor:</td>
				<td><?php echo (isset($grade_change['Staff']) && !empty($grade_change['Staff']) ? $grade_change['Staff']['first_name'].' '.$grade_change['Staff']['middle_name'].' '.$grade_change['Staff']['last_name'] : '---'); ?></td>
			</tr>
			<tr>
				<td style="font-weight:bold">Remark by registrar:</td>
				<td><?php echo $grade_change['ExamGradeChange']['registrar_reason']; ?></td>
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
		$this->set(compact('register_or_add', 'grade_history'));
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
								echo $this->Form->radio('ExamGradeChange.'.$st_count.'.department_approval', $options, $attributes);
								?>							
							</td>
						</tr>
						<tr>
							<td>Remark:</td>
							<td><?php echo $this->Form->input('ExamGradeChange.'.$st_count.'.department_reason',array('label'=>false, 'cols' => 40)); ?></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo $this->Form->Submit('Approve Grade Change Request',array('div'=>false,'class'=>'tiny radius button bg-blue', 'name'=>'approveGradeChangeByDepartment_'.$st_count++)); ?></td>
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
}

echo $this->Form->input('grade_change_count', array('type' => 'hidden', 'value' => ($st_count-1)));
if(empty($makeup_exam_grade_changes) && empty($exam_grade_changes) && empty($rejected_makeup_exam_grade_changes) && empty($rejected_department_makeup_exam_grade_changes)) {
?>
<div id="flashMessage" class="info-box info-message"><span></span>There is no exam grade change request and makeup exam grade submission to approve. Exam grade changes and makeup exams are required to be submitted by instructor in-order to appear here.</div>
<?php
	}
echo $this->Form->end();
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
