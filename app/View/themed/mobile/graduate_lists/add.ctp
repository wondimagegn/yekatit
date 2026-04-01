<script>
function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}
function toggleViewFullId(id) {
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}
</script>
<div class="graduateLists form">
<?php echo $this->Form->create('GraduateList');?>
<div class="smallheading"><?php __('Add Student to Graduate List'); ?></div>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($students_for_graduate_list)) {
		echo $html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (!empty($students_for_graduate_list) ? 'none' : 'display'); ?>">
<table cellspacing="0" cellpadding="0" class="fs13">
	<tr>
		<td style="width:10%">Program:</td>
		<td style="width:25%"><?php echo $this->Form->input('program_id', array('id' => 'Program', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $programs, 'default' => $default_program_id)); ?></td>
		<td style="width:12%">Program Type:</td>
		<td style="width:53%"><?php echo $this->Form->input('program_type_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $program_types, 'default' => $default_program_type_id)); ?></td>
	</tr>
	<tr>
		<td>Department:</td>
		<td colspan="3"><?php echo $this->Form->input('department_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $departments, 'default' => $default_department_id)); ?></td>
	</tr>
	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('List Students', true), array('name' => 'listStudentsForGraduateList', 'div' => false)); ?>
		</td>
	</tr>
</table>
</div>
<?php
if(!empty($students_for_graduate_list)) {
$yFrom = date('Y') - Configure::read('Calendar.graduateApprovalInPast');
$yTo = date('Y') + Configure::read('Calendar.graduateApprovalAhead');
?>
<p class="fs14" style="margin-bottom:0px">Please enter minute number, graduation date and select students from the senate list (below) who will be included in the graduate list.</p>
<p class="fs14" style="color:red; margin-top:0px"><strong>Important Note:</strong> Please make your entry and selection carefully. You will have limited time to apply changes on the already graduated students.</p>
<table class="fs13">
	<tr>
		<td style="width:12%">Minute Number:</td>
		<td style="width:88%"><?php echo $this->Form->input('minute_number', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Graduation Date:</td>
		<td><?php echo $this->Form->input('graduate_date', array('label' => false, 'minYear' => $yFrom, 'maxYear' => $yTo)); ?></td>
	</tr>
</table>
<hr />
<style>
table.summery tr td{
padding:2px;
}
table.student_list tr td{
padding:2px;
}
</style>
<?php
$count = 1;
foreach($students_for_graduate_list as $c_id => $students) {
	?>
	<table class='fs13 summery'>
		<tr>
			<td style="width:22%">Department:</td>
			<td style="width:78%; font-weight:bold"><?php echo $students[0]['Department']['name']; ?></td>
		</tr>
		<tr>
			<td>Program:</td>
			<td style="font-weight:bold"><?php echo $students[0]['Program']['name']; ?></td>
		</tr>
		<tr>
			<td>Curriculum:</td>
			<td style="font-weight:bold"><?php echo $students[0]['Curriculum']['name']; ?></td>
		</tr>
		<tr>
			<td>Degree Designation:</td>
			<td style="font-weight:bold"><?php echo $students[0]['Curriculum']['english_degree_nomenclature']; ?></td>
		</tr>
		<?php
		if(!empty($students[0]['Curriculum']['specialization_english_degree_nomenclature'])) {
		?>
		<tr>
			<td>Specialization:</td>
			<td style="font-weight:bold"><?php echo $students[0]['Curriculum']['specialization_english_degree_nomenclature']; ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td>Degree Designation (Amharic):</td>
			<td><?php echo $students[0]['Curriculum']['amharic_degree_nomenclature']; ?></td>
		</tr>
		<?php
		if(!empty($students[0]['Curriculum']['specialization_amharic_degree_nomenclature'])) {
		?>
		<tr>
			<td>Specialization (Amharic):</td>
			<td><?php echo $students[0]['Curriculum']['specialization_amharic_degree_nomenclature']; ?></td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td>Required Credit for Graduation:</td>
			<td style="font-weight:bold"><?php echo $students[0]['Curriculum']['minimum_credit_points']; ?></td>
		</tr>
	</table>
	<table class="student_list">
		<tr>
			<th style="width:4%"></th>
			<th style="width:2%">S.No</th>
			<th style="width:28%">Student Name</th>
			<th style="width:10%">ID</th>
			<th style="width:5%">Sex</th>
			<th style="width:10%">Credit Taken</th>
			<th style="width:10%">CGPA</th>
			<th style="width:31%">MCGPA</th>
		</tr>
	<?php
	$s_count = 1;
	foreach($students as $key => $student) {
		if($key == 0)
			continue;
		//TODO: Remove the following code
		//if($key > 5)
			//$student['disqualification'] = null;
		?>
		<tr>
			<?php
			if(!empty($student['disqualification'])) {
			?>
				<td style="background-color:white" onclick="toggleView(this)" id="<?php echo $count; ?>"><?php echo $html->image('plus2.gif', array('id' => 'i'.$count, 'div' => false, 'align' => 'left')); ?>?</td>
			<?php
			}
			else {
				?>
				<td style="background-color:white"><?php 
				echo $this->Form->input('Student.'.$count.'.id', array('type' => 'hidden', 'value' => $student['Student']['id']));
				echo $this->Form->input('Student.'.$count.'.include_graduate', array('type' => 'checkbox', 'label' => false));
				?></td>
				<?php
			}
			?>
			<td style="background-color:white"><?php echo $s_count++; ?></td>
			<td style="background-color:white"><?php echo $this->Html->link(__($student['Student']['full_name'], true), array('controller' => 'students', 'action' => 'view', $student['Student']['id']), array('target' => '_blank', 'style' =>  'font-weight:normal')); ?></td>
			<td style="background-color:white"><?php echo $student['Student']['studentnumber']; ?></td>
			<td style="background-color:white"><?php echo (strcasecmp($student['Student']['gender'], 'male') == 0 ? 'M' : 'F'); ?></td>
			<td style="background-color:white"><?php echo $student['credit_taken']; ?></td>
			<td style="background-color:white"><?php echo $student['cgpa']; ?></td>
			<td style="background-color:white"><?php echo $student['mcgpa']; ?></td>
		</tr>
		<?php
		if(!empty($student['disqualification'])) {
		?>
		<tr id="c<?php echo $count; ?>" style="display:none">
			<td colspan="8" style="background-color:#f0f0f0">
				<ol>
					<?php
					foreach($student['disqualification'] as $d_key => $disqualification) {
						echo '<li>'.$disqualification.'</li>';
					}
					?>
				</ol>
			</td>
		</tr>
		<?php
		}
		$count++;
	}
	?>
	</table>
	<?php
	}//End of each curriculum students
echo $this->Form->submit(__('Add Student to Graduate List', true), array('name' => 'addStudentToGraduateList', 'div' => false));
}
else if(isset($this->data) && empty($students_for_graduate_list)) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>The system unable to find list of students who are not in the graduate list but in the senate list.</div>';
}
?>
<?php echo $this->Form->end();?>
</div>
