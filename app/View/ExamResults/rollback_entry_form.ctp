<?php ?>

<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
        <p class="fs13">Please select course/s and rollback the course instructor grade submission to grade before approval.</p>

<?php 
 
$gradeList = array();
if(isset($section_and_course_detail['Course']['GradeType']['Grade'])) {
   foreach($section_and_course_detail['Course']['GradeType']['Grade'] as $key=>$value) {
	$gradeList[$value['grade']]=$value['grade'];
   } 
    $gradeList['NG']='NG';
	$gradeList['I']='I';
	$gradeList['W']='W';
    $gradeList['DO']='DO';

}

echo $this->Form->hidden('PublishedCourse.id', array('value'=>$section_and_course_detail['PublishedCourse']['id']));

?>

<?php 

 if($view_only) {
	echo '<div id="flashMessage" class="info-box info-message">
<span></span>This course  grade entry is possible by the assigned instructor. Incase if s/he the instructor left the department his/her account should be closed by the system administrator so that you will able to enter grade.</div>';
} else {
?>
	<table>
		<tr>
		    <th style="width:10%">S.N<u>o</u></th>
			<th style="width:10%">
<?php echo $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false, 'label' => false)); ?>Select All</th>
 			<th style="width:25%">Student Name</th>
			<th style="width:25%">Student ID</th>
			<th style="width:10%">Grade</th>
			
		</tr>
		<?php
		$st_count = 0;
		$checkBoxCount=0;
		echo "<tr><td colspan='5'>Registered</td></tr>";
		
		foreach($student_course_register_and_adds['register'] as $key => $student) {
			$st_count++;
			?>
			<tr>
			   <td>
                  <?php  echo $st_count;?>
			   </td>
			   <td>
			<?php 
            if(!empty($student['ExamGrade'])) {
			    $checkBoxCount++;
				echo $this->Form->input('ExamResult.'.$st_count.'.gp', array('type' => 'checkbox','class'=>'checkbox1', 'label' => false, 'id' => 'StudentSelection'.$st_count));
				
               echo $this->Form->input('ExamResult.'.$st_count.'.exam_grade_id', array('type' => 'hidden', 'value' =>$student['LatestGradeDetail']['ExamGrade']['id']));	
           
	           }
		?>
               </td>
			   <td>
              <?php 
					echo $student['Student']['first_name'].' '.$student['Student']['middle_name'].' '.$student['Student']['last_name'];
				?>
               </td>
	
			   <td>
                  <?php 
					echo $student['Student']['studentnumber'];
				?>
               </td>
			   <td>
               <?php 
				if(!empty($student['LatestGradeDetail']['ExamGrade'])) {
					echo $student['LatestGradeDetail']['ExamGrade']['grade'];
				} 

					?>
				</td>
	         </tr>
			<?php
		}
      if(!empty($student_course_register_and_adds['add'])) {
      echo "<tr><td colspan='4'>Added</td></tr>";
      foreach($student_course_register_and_adds['add'] as $key => $course) {
			$st_count++;
			?>
			<tr>
			    <td>
                  <?php  echo $st_count;?>
			   </td>
			   <td>
               	<?php 
            if(!empty($course['ExamGrade'])) {
			    $checkBoxCount++;
				echo $this->Form->input('ExamResult.'.$st_count.'.gp', array('type' => 'checkbox','class'=>'checkbox1', 'label' => false, 'id' => 'StudentSelection'.$st_count));
               echo $this->Form->input('ExamResult.'.$st_count.'.exam_grade_id', array('type' => 'hidden', 'value' =>$student['LatestGradeDetail']['ExamGrade']['id']));	
           
	           }
		?>
               </td>
	            <td>
              <?php 
					echo $student['Student']['first_name'].' '.$student['Student']['middle_name'].' '.$student['Student']['last_name'];
				?>
               </td>
	
			   <td>
                  <?php 
					echo $student['Student']['studentnumber'];
				?>
               </td>
			   <td>
                       
				</td>
               
	         </tr>
			<?php
		}
	  }

	?>
   
	</table>
    <?php 
  echo $this->Form->submit(__('Rollback To Instructor', true), array('name' =>'rollback','class'=>'tiny radius button bg-blue', 'div' => false)); 
?>

<?php } ?>
      </div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
