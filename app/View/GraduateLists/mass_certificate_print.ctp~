<script type="text/javascript">
/*
var number_of_students = <?php echo (isset($student_lists) ? count($student_lists) : 0); ?>;
function check_uncheck(id) {
	var checked = ($('#'+id).attr("checked") == 'checked' ? true : false);
	for(i = 1; i <= number_of_students; i++) {
		$('#Student'+i).attr("checked", checked);
	}
}
*/
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
<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="form">
<?php echo $this->Form->create('GraduateList');?>
<p class="fs16">
             <strong> Important Note: </strong> 
               This tool will help you to print certification to graduated students. By providing some criteria you can find the list of students who are graduated.
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($student_lists)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
	}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
	}
?>
</div>
<div id="ListPublishedCourse" 
style="display:<?php echo (!empty($student_lists) ? 'none' : 'display'); ?>">

<table cellspacing="0" cellpadding="0" class="fs13">
		<tr>
		<td style="width:10%">Department:</td>
		<td style="width:25%"><?php echo $this->Form->input('department_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $departments, 'default' => $default_department_id)); ?></td>
		<td style="width:20%">Admission Year:</td>
		
		<td style="width:40%"><?php echo $this->Form->input('acadamic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>

	</tr>
	<tr>
		<td style="width:10%">Program:</td>
		<td style="width:25%"><?php echo $this->Form->input('program_id', array('id' => 'Program', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $programs, 'default' => $default_program_id)); ?></td>
		<td style="width:12%">Program Type:</td>
		<td style="width:53%"><?php echo $this->Form->input('program_type_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $program_types, 'default' => $default_program_type_id)); ?></td>
	</tr>

	<tr>
		<td style="width:10%">Name:</td>
		<td style="width:25%"><?php echo $this->Form->input('name', array('id' => 'name', 'class' => 'fs14', 'label' => false)); ?></td>
		<td style="width:10%">Student ID:</td>
		<td style="width:25%"><?php echo $this->Form->input('studentnumber', array('id' => 'studentnumber', 'class' => 'fs14', 'label' => false)); ?></td>
	</tr>
	<tr>
		<td> Certificate Type:</td>
		<td><?php echo $this->Form->input('certificate_type', array('label'=> false, 'type' => 'select', 'style' => 'width:200px', 'div' => false, 'default' => 'graduation_certificate', 'options' => $certificate_type_options)); ?> <span style="font-size:11px"></span></td>

	<td style="width:25%"> Graduated</td>
		<td colspan="4"><?php echo $this->Form->input('graduated', array('label'=> false, 'type' => 'select', 'style' => 'width:60px', 'div' => false, 'default' => 1, 'options' => array(1=>'Yes',0=>'No'))); ?> <span style="font-size:11px"></span></td>
	</tr>

	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('List Students', true), array('name' => 'listStudentsForCertficatePrint', 'div' => false,'class'=>'tiny radius button bg-blue')); ?>
		</td>
	</tr>
</table>
</div>
<?php 	
if(isset($student_lists) && 
empty($student_lists)) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>There is no student in the selected criteria</div>';
}
else if(isset($student_lists) && !empty($student_lists)) {
	?>
     <div onclick="toggleViewFullId('StudentCopyDisplaySetting')"><?php 
	if (!empty($student_lists)) {
		echo $this->Html->image('plus2.gif', array('id' => 'DisplaySettingImg')); 
			
		?>
		
	<span style="font-size:10px; vertical-align:top; font-weight:bold" id="DisplaySetting">Display Student Copy Setting</span>
	<?php
	}
	else {
		
echo $this->Html->image('minus2.gif', array('id' => 'DisplaySettingImg')); 	
		?>
  <span style="font-size:10px; vertical-align:top; font-weight:bold" id="DisplaySetting">Hide Student Copy Setting</span>
<?php
	}
	?>
       </div>
	<div id="StudentCopyDisplaySetting" style="display:none;">
	  <table class="fs13">
			<tr>
				<td style="width:17%">Semesters on One Side:</td>
				<td style="width:83%"><?php echo $this->Form->input('Setting.no_of_semester', array('label'=> false, 'type' => 'select', 'style' => 'width:150px', 'div' => false, 'default' => 3, 'options' => array(2 => 2, 3 => 3, 4 => 4, 5 => 5))); ?> <span style="font-size:11px">(Number of semesters to display on one side of the student copy)</span></td>
			</tr>
			<tr>
				<td>Text Padding:</td>
				<td><?php echo $this->Form->input('Setting.course_justification', array('label'=> false, 'type' => 'select', 'style' => 'width:150px', 'div' => false, 'default' => 1, 'options' => array(0 => 0, 1 => 1, 2 => 2))); ?> <span style="font-size:11px">(The space around each text)</span></td>
			</tr>
			<tr>
				<td>Font Size:</td>
				<td><?php echo $this->Form->input('Setting.font_size', array('label'=> false, 'type' => 'select', 'style' => 'width:150px', 'div' => false, 'default' => 30, 'options' => $font_size_options)); ?> <span style="font-size:11px"></span></td>
			</tr>
		</table>

	</div>

      <p class="fs13">Please select student/s for whom you want to prepare certificate.</p>
	
	<table>
		<tr>
			<th style="width:10%"><?php echo $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false, 'label' => false)); ?>Select All</th>
			<th style="width:25%">Student Name</th>
			<th style="width:65%">ID</th>
		</tr>
		<?php
		$st_count = 0;
		foreach($student_lists as $key => $student) {
		
			$st_count++;
			?>
			<tr>
				<td><?php 
					echo $this->Form->input('Student.'.$st_count.'.gp', array('type' => 'checkbox', 'label' => false,'class'=>'checkbox1', 'id' => 'Student'.$st_count));
					echo $this->Form->input('Student.'.$st_count.'.student_id', array('type' => 'hidden', 
'value' =>$student['Student']['id']));
				?></td>
				<td><?php echo $student['Student']['full_name']; ?></td>
				<td><?php echo $student['Student']['studentnumber']; ?></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php echo $this->Form->submit(__('Get Student Certificate', true), array('name' => 'getStudentCertficate', 'div' => false,'class'=>'tiny radius button bg-blue')); ?>
	<?php
	//debug($students_in_section);
}
?>
<?php echo $this->Form->end(); ?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
