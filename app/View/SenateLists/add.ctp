<?php ?>
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
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="senateLists form">
<?php echo $this->Form->create('SenateList');?>
<div class="smallheading"><?php echo __('Add Student to Senate List'); ?></div>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($students_for_senate_list)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (!empty($students_for_senate_list) ? 'none' : 'display'); ?>">
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
		<?php echo $this->Form->submit(__('List Students'), array('name' => 'listStudentsForSenateList','class'=>'tiny radius button bg-blue', 'div' => false)); ?>
		</td>
	</tr>
</table>
</div>
<?php
if(!empty($students_for_senate_list)) {
$yFrom = date('Y') - Configure::read('Calendar.senateApprovalInPast');
$yTo = date('Y') + Configure::read('Calendar.senateApprovalAhead');
?>
<p class="fs14">Below is list of students who fullfill the minimum credit hour requirement. Please enter minute number, approval date and select students who will be included in the senate list. <u>Students who doesn't fullfill the minimum credit hour and students who are already either in senate list or graduate list will not be displayed here.</u></p>
<table class="fs13">
	<tr>
		<td style="width:12%">Minute Number:</td>
		<td style="width:88%"><?php echo $this->Form->input('minute_number', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Approval Date:</td>
		<td><?php echo $this->Form->input('approved_date', array('label' => false, 'minYear' => $yFrom, 'maxYear' => $yTo,'style'=>'width:80px')); ?></td>
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
foreach($students_for_senate_list as $c_id => $students) {
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
			<td class="bold"><?php echo $students[0]['Curriculum']['amharic_degree_nomenclature']; ?></td>
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
		<tr style="color:<?php echo (empty($student['disqualification']) ? 'green' : 'red'); ?>">
			<?php
			if(!empty($student['disqualification'])) {
			?>
				<td style="background-color:white" onclick="toggleView(this)" 

				id="<?php echo $count; ?>"><?php echo $this->Html->image('plus2.gif', 
				array('id' => 'i'.$count, 'div' => false, 'align' => 'left')); ?>?</td>
			<?php
			}
			else {
				?>
				<td style="background-color:white"><?php 
				echo $this->Form->input('Student.'.$count.'.id', array('type' => 'hidden', 'value' => $student['Student']['id']));
				echo $this->Form->input('Student.'.$count.'.include_senate', array('type' => 'checkbox', 'label' => false));
				?></td>
				<?php
			}
			?>
			<td style="background-color:white"><?php echo $s_count++; ?></td>
			<td style="background-color:white"><?php echo $this->Html->link(__($student['Student']['full_name']), array('controller' => 'students', 'action' => 'view', $student['Student']['id']), array('target' => '_blank', 'style' =>  'font-weight:normal; color:'.(empty($student['disqualification']) ? 'green' : 'red'))); ?></td>
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
echo $this->Form->submit(__('Add Student to Senate List'), array('name' => 'addStudentToSenateList','class'=>'tiny radius button bg-blue', 'div' => false));
}
else if(isset($this->request->data) && empty($students_for_senate_list)) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>The system unable to find list of students who are not on the senate list but fully take the minimum credit hour which is set on their curriculum.</div>';
}
?>
<?php echo $this->Form->end();?>
</div>


	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
