<script>
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
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($publishedCourses)) {
		echo $html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (!empty($publishedCourses) ? 'none' : 'display'); ?>">
<table cellspacing="0" cellpadding="0" class="fs14">
	<tr>
		<td style="width:15%">Academic Year:</td>
		<td style="width:20%"><?php echo $this->Form->input('acadamic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>
		<td style="width:15%">Semester:</td>
		<td style="width:50%"><?php echo $this->Form->input('semester', array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'), 'default' => (isset($semester_selected) ? $semester_selected : false))); ?></td>
	</tr>
	<tr>
		<td>Program:</td>
		<td><?php echo $this->Form->input('program_id', array('id' => 'Program', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $programs, 'default' => (isset($program_id) ? $program_id : false))); ?></td>
		<td>Program Type:</td>
		<td><?php echo $this->Form->input('program_type_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $program_types, 'default' => (isset($program_type_id) ? $program_type_id : false))); ?></td>
	</tr>
	<?php
	if(!(isset($departments[0]) && $departments[0] == 0)) {
	?>
	<tr>
		<td>Department:</td>
		<td colspan="3"><?php echo $this->Form->input('department_id', array('id' => 'ProgramType', 'class' => 'fs14', 'label' => false, 'type' => 'select', 'options' => $departments, 'default' => (isset($department_id) ? $department_id : false))); ?></td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__(( isset($search_button_label) && !empty($search_button_label) ? $search_button_label : 'List Published Courses'), true), array('name' => 'listPublishedCourses', 'div' => false)); ?>
		</td>
	</tr>
</table>
</div>
<?php
if(!empty($publishedCourses)) {
?>
<table class="fs14">
	<tr>
		<td style="width:15%">Published Courses</td>
		<td colspan="3" style="width:85%">
<?php
	echo $this->Form->input('published_course_id', array('class' => 'fs14','id' => 'PublishedCourse', 'label' => false, 'type' => 'select', 'options' => $publishedCourses, 'default' => $published_course_combo_id));
?>
		</td>
	</tr>
</table>
<?php
	}
?>

