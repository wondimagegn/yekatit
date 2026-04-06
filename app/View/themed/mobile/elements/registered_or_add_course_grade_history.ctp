<?php
if(!isset($freshman_program) || !$freshman_program)
	$approver = 'department';
else
	$approver = 'freshman program';
echo '<div style="font-weight:bold; font-size:14px">Grade History (Summery: From old to recent)</div>';
if($register_or_add) {
	if(!empty($grade_history)) {
		foreach($grade_history as $key => $grade) {
			if(strcasecmp($grade['type'], 'Add') == 0)
				echo 'Course Added: ';
			else if(strcasecmp($grade['type'], 'Register') == 0)
				echo 'Course Registered: ';
			else if($grade['ExamGrade']['makeup_exam_result'] != null && $grade['ExamGrade']['makeup_exam_id'] == null)
				echo 'Supplementary Exam: ';
			else if($grade['ExamGrade']['makeup_exam_result'] != null)
				echo 'Makeup Exam: ';
			else
				echo 'Grade Change: ';
			if((strcasecmp($grade['type'], 'Add') == 0 || strcasecmp($grade['type'], 'Register') == 0)) {
				if(empty($grade['ExamGrade']))
					echo '<br /><i style="padding-left:15px">Status:</i> <span class="on-process">Waiting for grade submision.</span>';
				else
					{
					echo '<strong>'.$grade['ExamGrade']['grade'].'</strong> '.($grade['ExamGrade']['department_reply'] == 1 ? '(Re-Submit)' : '').' ('.$this->Format->humanize_date($grade['ExamGrade']['created']).')';
					echo '<br /><i style="padding-left:15px">Status:</i> ';
					if($grade['ExamGrade']['department_approval'] == 1 && $grade['ExamGrade']['registrar_approval'] == 1)
						echo '<span class="accepted">Accepted</span>';
					else if($grade['ExamGrade']['department_approval'] == 1 && $grade['ExamGrade']['registrar_approval'] == null)
						echo '<span class="on-process">Accepted by '.$approver.' waiting for registrar approval.</span>';
					else if($grade['ExamGrade']['department_approval'] == 1 && $grade['ExamGrade']['registrar_approval'] == -1)
						echo '<span class="rejected">Accepted by '.$approver.' but rejcted by registrar.</span>';
					else if($grade['ExamGrade']['department_approval'] == null)
						echo '<span class="on-process">Waiting for '.$approver.' approval.</span>';
					else if($grade['ExamGrade']['department_approval'] == -1)
						echo '<span class="rejected">Rejected by '.$approver.'.</span>';
					}
			}
			//Grade change or makeup exam
			else {
				if(empty($grade['ExamGrade']))
					echo '<br /><i style="padding-left:15px">Status:</i> <span class="on-process">Waiting for grade submision.</span>';
				else
					{//debug($grade['ExamGrade']);
					echo '<strong>'.$grade['ExamGrade']['grade'].'</strong> '.($grade['ExamGrade']['department_reply'] == 1 ? '(Re-Submit)' : '').' ('.$this->Format->humanize_date($grade['ExamGrade']['created']).')';
					echo '<br /><i style="padding-left:15px">Status:</i> ';
					if($grade['ExamGrade']['manual_ng_conversion'] == 1) {
						echo '<span class="accepted">NG Grade Converted</span>';
					}
					else if($grade['ExamGrade']['auto_ng_conversion'] == 1) {
						echo '<span class="accepted">Automatic F</span>';
					}
					else {
					if(($grade['ExamGrade']['initiated_by_department'] == 1 || $grade['ExamGrade']['department_approval'] == 1) && $grade['ExamGrade']['department_approval'] != -1) {
						if($grade['ExamGrade']['college_approval'] == 1 || $grade['ExamGrade']['makeup_exam_result'] != null) {
							if($grade['ExamGrade']['registrar_approval'] == 1) {
								echo '<span class="accepted">Accepted</span>';
							}
							else if($grade['ExamGrade']['registrar_approval'] == -1) {
								if($grade['ExamGrade']['makeup_exam_result'] == null)
									echo '<span class="rejected">Approved by '.$approver.' &amp; college but rejected by registrar.</span>';
								else
									if($grade['ExamGrade']['initiated_by_department'] == 1)
										echo '<span class="rejected">Requested by '.$approver.' but rejected by registrar.</span>';
									else
										echo '<span class="rejected">Approved by '.$approver.' but rejected by registrar.</span>';
								}
							else if($grade['ExamGrade']['registrar_approval'] == null) {
								if($grade['ExamGrade']['makeup_exam_result'] == null)
									echo '<span class="on-process">Approved by '.$approver.' &amp; college and waiting for registrar approval.</span>';
								else {
									if($grade['ExamGrade']['initiated_by_department'] == 1)
										echo '<span class="on-process">Requested by '.$approver.' and waiting for registrar approval.</span>';
									else
										echo '<span class="on-process">Approved by '.$approver.' and waiting for registrar approval.</span>';
								}
							}
						}
						else if($grade['ExamGrade']['college_approval'] == -1)
							echo '<span class="rejected">Approved by '.$approver.' but rejected by college.</span>';
						else if($grade['ExamGrade']['college_approval'] == null)
							echo '<span class="on-process">Approved by '.$approver.' and waiting for college approval.</span>';
					}
					else if($grade['ExamGrade']['department_approval'] == -1)
						echo '<span class="rejected">Rejected by '.$approver.'.</span>';
					else if($grade['ExamGrade']['department_approval'] == null)
						echo '<span class="on-process">Waiting for '.$approver.' approval.</span>';
				}
				}
			}
			echo '<br />';
		}
	}
	else {
		echo 'There is no recorded/submited grade for the selected course.';
	}
}
else
	echo '---';
?>
