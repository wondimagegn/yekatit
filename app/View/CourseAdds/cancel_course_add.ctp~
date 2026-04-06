<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	     <div class="large-12 columns">
             
			<div class="courseAdd ">
			<?php echo $this->Form->create('CourseAdd');?>
			<div class="smallheading"><?php __('Course Add Cancellation Interface');?></div>

			<p class="fs16">
			<strong> Important Note: </strong> This tool will help you to cancel student course add.  If the selected students has course add for selected academic year and semester, it will display those course.
			</p>
			<div onclick="toggleViewFullId('ListSection')"><?php 
				if (!empty($publishedCourses)) {
					echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg')); 
					?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt">Display Filter</span><?php
					}else {
					echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg')); 
					?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt">Hide Filter</span><?php
					}
			?></div>
<div id="ListSection" style="display:<?php echo (!empty($sections) ? 'none' : 'display'); ?>">
<table cellspacing="0" cellpadding="0" class="fs14">
	<tr>
		<td style="width:15%">Academic Year:</td>
		<td style="width:20%"><?php echo $this->Form->input('acadamic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_list, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>
		<td style="width:15%">Semester:</td>
		<td style="width:50%"><?php echo $this->Form->input('semester', array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'), 'default' => (isset($semester_selected) ? $semester_selected : false))); 
		if(isset($semester_selected)) {
			echo $this->Form->input('semester_selected', array('id' => 'SemesterSelected', 'type' => 'hidden', 'value' => $semester_selected));
		}
		?></td>
	</tr>
	<tr>
		<td>Student Number:</td>
		<td>
		<?php echo $this->Form->input('studentnumber', 
array('id' => 'StudentNumber', 'class' => 'fs14','label' => false, 'type' => 'text')); ?>
		</td>

		 <td>Password:</td>

		<td>
		
			<?php 

echo $this->Form->input('password', 
array('id' => 'Password', 'class' => 'fs14','label' => false));
		
 ?>
			</td>
    </tr>

    <tr>
		<td colspan="4">
			<strong>
			<?php 
				if(!empty($student_academic_profile)) {
					echo $student_academic_profile['BasicInfo']['Student']['first_name'].' '.$student_academic_profile['BasicInfo']['Student']['middle_name'].' '. $student_academic_profile['BasicInfo']['Student']['last_name'].'('.$student_academic_profile['BasicInfo']['Department']['name'].')';
				 } 
				?>	
			</strong>
		</td>
		
	</tr>
	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('Get Courses', true), array('name' => 'listAddedCourses', 'div' => false,'class'=>'tiny radius button bg-blue')); ?>
		</td>
	</tr>
</table>
</div>

<?php 
if(empty($publishedCourses)) {

?>
<p class="fs16">
   
                    
</p>
<?php 
}
else if(isset($publishedCourses) && !empty($publishedCourses)) {
	?>
	<div onclick="toggleViewFullId('Profile')"><?php 
	if (!empty($student_academic_profile)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ProfileImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ProfileTxt">Display Student Academic Profile</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ProfileImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ProfileTxt">Hide Student Academic Profile</span><?php
		}
?></div>
     <div id="Profile" style="display:<?php echo (!empty($student_academic_profile) ? 'none' : 'display'); ?>">
	<?php 
		if(isset($student_academic_profile) 
		&& !empty($student_academic_profile)){
			//echo $this->element('student_academic_profile');
		}
	?>
     </div>
	<p class="fs13">Please select course/s .</p>
	<table>
		<tr>
			<th style="width:10%">
<?php echo $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false, 'label' => false)); ?>Select All</th>
 			<th style="width:25%">Course Title</th>
			<th style="width:25%">Course Code</th>
			
			<th style="width:20%"><?php echo $student_academic_profile['Curriculum']['type_credit']=="ECTS Credit Point" ? "ECTS":"Credit" ?></th>
			<th style="width:10%">AY/Sem.</th>
			
		</tr>
		<?php
		$st_count = 0;
		$checkBoxCount=0;
		// debug($publishedCourses);
		foreach($publishedCourses as $key => $course) {
			$st_count++;
		   //	debug($course);
			?>
			<tr>
				<td><?php 

   				echo $this->Form->input('CourseAdd.'.$st_count.'.gp', array('type' => 'checkbox','class'=>'checkbox1', 'label' => false, 'id' => 'StudentSelection'.$st_count));
				echo $this->Form->input('CourseAdd.'.$st_count.'.student_id', 
array('type' => 'hidden', 'value' => $student_academic_profile['BasicInfo']['Student']['id']));	
      
         		echo $this->Form->hidden('CourseAdd.'.$st_count.'.id', array('label' => false,
'value'=>$course['CourseAdd']['id']));
echo $this->Form->hidden('CourseAdd.'.$st_count.'.published_course_id', array('label' => false,
'value'=>$course['CourseAdd']['published_course_id']));
	
				?></td>
				<td><?php echo $course['PublishedCourse']['Course']['course_title']; ?></td>
	
				<td><?php echo $course['PublishedCourse']['Course']['course_code']; ?></td>
		<td><?php echo $course['PublishedCourse']['Course']['credit']; ?></td>
		<td><?php
			echo $course['PublishedCourse']['academic_year'].' / '.$course['PublishedCourse']['semester'];
		?></td>
			
	
		</td>
		
	</tr>
			<?php

			
		}
	 
	?>
   

    <tr>
		<td colspan="3">
			<?php 


echo $this->Form->submit(__('Delete ', true), array('name' => 'deleteGrade','class'=>'tiny radius button bg-blue', 'div' => false)); 
?>
        </td>
        
	</tr>
	</table>
	
	<?php
	
}
?>
<?php  echo $this->Form->end(); ?>
</div>


	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->

<script type="text/javascript">

function toggleView(obj) {
   
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}

function toggleViewFullId(id) {
 
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		
        $('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}

</script>
