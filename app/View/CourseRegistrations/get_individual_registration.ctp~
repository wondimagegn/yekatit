<?php ?>

<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
     
<?php
if(isset($publishedCourses) && !empty($publishedCourses)) {
  echo $this->Form->create('CourseRegistration',array('action'=>'update_missing_registration', "method"=>"POST"));
?>

<div class="smallheading"><?php __('Student Missing Registration and Wrong NG Management ');?>
<?php 
echo $this->Form->input('Student.selected_student_id', array('type' => 'hidden',
'value'=>$studentDetail['Student']['id']));
?>
</div>

<p class="fs16">
              <strong> Important Note: </strong> 
               This tool will help you to manage missing registration due to prerequisite and cancel wrong NG grade. The system will retrieve students registration based on current active section and list the courses.  
</p>
	<p class="fs13">Please select course/s and enter corresponding grade.</p>

<div class="smallheading">
<?php echo $studentDetail['Student']['full_name'].'('.$studentDetail['Student']['studentnumber'].')';?>

</div>
	<table>
		<tr>
			<th style="width:10%">&nbsp;</th>
 			<th style="width:25%">Course Title</th>
			<th style="width:25%">Course Code</th>
			
			<th style="width:20%"><?php echo $studentDetail['Curriculum']['type_credit']=="ECTS Credit Point" ? "ECTS":"Credit" ?></th>
			<th style="width:10%">AY/Sem.</th>
			<th style="width:10%">Grade</th>
		</tr>
		<?php
		$st_count = 0;
		$checkBoxCountNG=0;
		$checkBoxCountMissing=0;
		foreach($publishedCourses as $key => $course) {
			$st_count++;
		   
			?>
			<tr>
				<td>
					<?php 
                     if($course['PublishedCourse']['prerequisiteFailed']) {
						echo "***";
					 } else if(empty($course['PublishedCourse']['Grade']) && $course['PublishedCourse']['readOnly']==false && empty($course['PublishedCourse']['course_registration_id'])) {
							$checkBoxCountMissing++;
							echo $this->Form->input('CourseRegistration.'.$st_count.'.gp', array('type' => 'checkbox','class'=>'checkbox1', 'label' => false, 'id' => 'StudentSelection'.$st_count));
						    echo $this->Form->input('CourseRegistration.'.$st_count.'.student_id', array('type' => 'hidden', 'value'=>$studentDetail['Student']['id']));	
                     echo $this->Form->input('CourseRegistration.'.$st_count.'.published_course_id', array('type' => 'hidden', 'value'=>$course['PublishedCourse']['id']));	        
						
					  } else if (isset($course['PublishedCourse']['grade']) && $course['PublishedCourse']['grade']=="NG") {
						    $checkBoxCountNG++;
							echo $this->Form->input('CourseRegistration.'.$st_count.'.gp', array('type' => 'checkbox','class'=>'checkbox1', 'label' => false, 'id' => 'StudentSelection'.$st_count));
						    echo $this->Form->input('CourseRegistration.'.$st_count.'.id', array('type' => 'hidden', 'value' =>$course['PublishedCourse']['course_registration_id']));	

					  } else {
                               if(isset($course['PublishedCourse']['prerequisiteFailed'])
&& $course['PublishedCourse']['prerequisiteFailed']){
                                 echo "***";
							   }
					   }
				?>
				</td>
				<td><?php echo $course['Course']['course_title']; ?></td>
	
				<td><?php echo $course['Course']['course_code']; ?></td>
				<td><?php echo $course['Course']['credit']; ?></td>
				<td><?php
					if(!empty($course['PublishedCourse']['academic_year'])) {
				 echo $course['PublishedCourse']['academic_year'].'/'.$course['PublishedCourse']['semester']; 
					} else {
				 echo $course['PublishedCourse']['academic_year'].'/'.$course['PublishedCourse']['semester']; 

					}
				?></td>
				<td>				  	
					<?php 
					if(isset($course['PublishedCourse']['grade']) && 
!empty($course['PublishedCourse']['grade'])) {
					   echo $course['PublishedCourse']['grade'];
					} 
					?>
				</td>
			</tr>
			<?php
		}
	?>
   <tr>
		<td colspan="3">*** failed to take prerequisites</td>
	</tr>
    <tr>
		<td colspan="3">
			<?php 
if($checkBoxCountMissing>0){
echo $this->Form->submit(__('Save ', true), array('name' => 'registerMissingCourse','class'=>'tiny radius button bg-blue', 'div' => false));

} 
?>
        </td>
        <td colspan="3">
<?php 
if($checkBoxCountNG>0){
echo $this->Form->submit(__('Cancel ', true), array('name' => 'cancelNG','class'=>'tiny radius button bg-blue', 'div' => false)); 
}


?>
		</td>
	</tr>
	</table>

<?php echo $this->Form->end(); ?>
<?php 
} else {
	if(isset($status) && !empty($status)){
		echo "<div id='flashMessage' class='info-box info-message'> <span></span>".$status."</div>";
	} else {
  echo '<div id="flashMessage" class="info-box info-message"><span></span>There is no course registration for the given academic year and semester of the selected student.</div>';
	}
}
?>
</div>
</div>
</div>
</div>
