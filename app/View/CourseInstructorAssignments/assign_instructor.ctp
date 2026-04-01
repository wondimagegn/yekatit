<?php ?>
<script type="text/javascript">

$(function() {
	$("#staff_id").customselect();
	
}
); 	
</script>
<?php 
echo $this->Html->script('smis',false); 
echo $this->Form->create('CourseInstructorAssignment',array('action'=>'assign_instructor_update', 'method'=>"GET"));
	echo '<table><tr><td>'.$this->Form->input('staff_id',array('label'=>'Instructors','id'=>'staff_id',
	'type'=>'select','class'=>'custom-select','options'=>$instructors_list,'onchange'=>"this.form.submit();",'empty'=>"--Select Instructor--")).'</td></tr>';
	  echo "<tr><td id='show'><a href=\"javascript:toggle('instructor_course_detail');hideById('show');showBlockById('hide');\">Show Experiance Of Instructors</a></td></tr>";
 echo "<tr><td id='hide' style='display:none'><a href=\"javascript:toggle('instructor_course_detail');showBlockById('show');hideById('hide');\">Hide Experiance Of Instructors</a></td></tr>";
 
	echo "<tr><td id='instructor_course_detail' style='display:none'>";
	 echo "<table>";
	 echo "<tr><td colspan=2 class='smallheading'> Instructors Experiance For ".$course_code_title."</td></tr>";
	  echo "<tr><th> Full Name</th><th>Frequency of Teaching ".$course_code_title."</th></tr>";
	if(!empty($instructors_detail)){
	 foreach ($instructors_detail as $kk=>$vv) {
	        echo "<tr><td>".$vv['Staff']['full_name'].'</td><td>'.$vv['Experiance'].'</td></tr>';
	 }
	 }
	 echo "</table>";
	echo "</td></tr>";
	echo "</table>";
	
	echo $this->Form->hidden('selected_department_id', array('value'=>$selected_department_id));
	echo $this->Form->hidden('type', array('value'=>$selected_course_type));
	echo $this->Form->hidden('section_id', array('value'=>$selected_section_id));
	echo $this->Form->hidden('published_course_id', array('value'=>$selected_published_course_id));
	echo $this->Form->hidden('course_split_section_id', array('value'=>$selected_course_split_section_id));
	echo $this->Form->hidden('academic_year', array('value'=>$selected_academicyear));
	echo $this->Form->hidden('selected_program_id', array('value'=>$selected_program_id));
	echo $this->Form->hidden('selected_program_type_id', array('value'=>$selected_program_type_id));
	echo $this->Form->hidden('selected_year_level_id', array('value'=>$selected_year_level_id));
	echo $this->Form->hidden('semester', array('value'=>$selected_semester));
	echo $this->Form->hidden('isprimary', array('value'=>$isprimary));
	echo $this->Form->hidden('selected_course_title', array('value'=>$selected_course_title));

	echo $this->Js->get("#instructor_detail")->event('click', 
							$this->Js->request(array(
								'controller'=>'course_instructor_assignments',
								'action'=>'get_course_instructor_detail'
								,$selected_published_course_id), array(
								'update'=>"#instructor_course_detail",
								'async' => true,
								'method' => 'post',
								'dataExpression'=>true,
								'data'=> $this->Js->serializeForm(array(
									'isForm' => false,
									'inline' => true
									))
								))
							);
?>
