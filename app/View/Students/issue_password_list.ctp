<script>
var number_of_students = <?php echo (isset($students_in_section) ? count($students_in_section) : 0); ?>;
function check_uncheck(id) {
	var checked = ($('#'+id).attr("checked") == 'checked' ? true : false);
	for(i = 1; i <= number_of_students; i++) {
		$('#StudentSelection'+i).attr("checked", checked);
	}
}

$(document).ready(function () {
	$("#Section").change(function(){
		
	    var s_id = $("#Section").val();
		window.location.replace("/students/<?php echo $this->request->action; ?>/"+s_id);
	    
	});
});

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
        <div class="examGrades <?php echo $this->request->action; ?>">
<?php echo $this->Form->create('Student');?>
<div class="smallheading"><?php echo __('Issue/Reset Student Password');?></div>
<div onclick="toggleViewFullId('ListSection')"><?php 
	if (!empty($sections)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListSection" style="display:<?php echo (!empty($sections) ? 'none' : 'display'); ?>">
<table cellspacing="0" cellpadding="0" class="fs14">
	<tr>
		<td style="width:15%">Year Level:</td>
		<td style="width:20%"><?php echo $this->Form->input('year_level_id', 
		array('id' => 'YearLevelId', 'label' => false, 'class' => 'fs14', 
		'style' => 'width:125px', 'type' => 'select', 'options' => $yearLevels)); ?></td>
		
		
		
		<td style="width:15%">Admission Year:</td>
		<td style="width:20%"><?php echo $this->Form->input('acadamic_year', array('id' => 'AcadamicYear', 
		'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select',
		 'options' => $acyear_array_data, 
		 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>
	
	</tr>
	<tr>
		<td>Program:</td>
		<td><?php echo $this->Form->input('program_id', array('id' => 'Program', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $programs, 'default' => (isset($program_id) ? $program_id : false))); ?></td>
		<td>Program Type:</td>
		<td><?php echo $this->Form->input('program_type_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $program_types, 'default' => (isset($program_type_id) ? $program_type_id : false))); ?></td>
	</tr>

         <tr>
		<td>Name:</td>
		<td><?php echo $this->Form->input('name', array('id' => 'name', 'class' => 'fs14', 'label' => false)); ?></td>
		
	</tr>
   <tr>
				<td>Multiple Student On Single Page:</td>
				<td><?php echo $this->Form->input('single_page', array('label'=> false, 'type' => 'select',  'div' => false, 'default' => 'no', 'options' => array('no' => 'No', 'yes' => 'Yes'))); ?> 
				</td>
	</tr>
	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('Get Students'), array('name' => 'listSections','class'=>'tiny radius button bg-blue','div' => false)); ?>
		</td>
	</tr>
</table>
</div>
<?php
if(!empty($sections)) {
?>
<table class="fs14">
	<tr>
		<td style="width:15%">Sections</td>
		<td colspan="3" style="width:85%">
<?php
	echo $this->Form->input('section_id', array('class' => 'fs14','id' => 'Section', 
	'label' => false, 'type' => 'select', 'options' => $sections, 
	'default' => (isset($section_id) ? $section_id : false)));
?>
		</td>
	</tr>
</table>
<?php
	}
if(isset($students_in_section) && empty($students_in_section)) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>There is no student in the selected section</div>';
}
else if(isset($students_in_section) && !empty($students_in_section)) {
	?>
	<p class="fs13">Please select student/s for whom you want to issue/reset password. The password should be changed during first login by student.</p>
	<table>
		<tr>
			<th style="width:10%"><?php echo $this->Form->input('select_all', 
			array('type' => 'checkbox', 'id' => 'select-all', 'div' => false,
			 'label' => false)); ?>Select All</th>
			<th style="width:25%">Student Name</th>
			<th style="width:25%">Sex</th>
			<th style="width:50%">ID</th>
		</tr>
		<?php
		$st_count = 0;
		foreach($students_in_section as $key => $student) {
			$st_count++;
			?>
			<tr>
				<td><?php 
					echo $this->Form->input('Student.'.$st_count.'.gp', array('type' => 'checkbox', 'label' => false, 'id' => 'StudentSelection'.$st_count,'class'=>'checkbox1'));
					echo $this->Form->input('Student.'.$st_count.'.student_id', array('type' => 'hidden', 'value' => $student['Student']['id']));
				?></td>
				<td><?php echo $student['Student']['full_name']; ?></td>
				<td><?php echo $student['Student']['gender']; ?></td>
				<td><?php echo $student['Student']['studentnumber']; ?></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php echo $this->Form->submit(__('Get Student Password'), array('name' => 'issueStudentPassword', 
	'div' => false,'class'=>'tiny radius button bg-blue')); ?>
	<?php
	
}
?>
<?php echo $this->Form->end(); ?>
</div>
		</div>
       </div>
     </div>
</div>
