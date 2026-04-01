<div class="courseExemptions form">
<?php echo $this->Form->create('CourseExemption',array('action' => 'add','type'=>'file'));?>
<?php 
  echo $this->element('student_basic');
  /*
 if (isset($student_section_exam_status) && !empty($student_section_exam_status)) {   
?>
    <table><tr><td>
     <table>
            <tr><td class="font">Name:&nbsp;&nbsp;&nbsp;
            <?php 
                echo $student_section_exam_status['StudentBasicInfo']['full_name'];
            ?>
            </td></tr>
            <tr><td class="font">Student Number:&nbsp;&nbsp;&nbsp;
            <?php 
                echo $student_section_exam_status['StudentBasicInfo']['studentnumber']; 
            ?>
            </td></tr>
         
            <tr><td class="font">Year Level:&nbsp;&nbsp;&nbsp;
            <?php 
                echo $student_section_exam_status['Section']['YearLevel']['name'];
            
            ?>
            </td></tr>
            <tr><td class="font">Section:&nbsp;&nbsp;&nbsp;
            <?php 
            
            echo $student_section_exam_status['Section']['name'];
            
            ?>
            </td></tr>
           
       </table>
       </td><td>
        <?php 
         if (!empty($student_section_exam_status['StudentExamStatus'])) {
            echo "<table>";
           
            ?>
           <tr><td class="font">Semester:&nbsp;&nbsp;&nbsp;<?php echo $student_section_exam_status['StudentExamStatus']['semester']?></td></tr>
            <tr><td class="font">Academic Year:&nbsp;&nbsp;&nbsp;<?php echo $student_section_exam_status['StudentExamStatus']['academic_year'];?></td></tr>
         
             <tr><td class="font">SGPA:&nbsp;&nbsp;&nbsp;<?php echo $student_section_exam_status['StudentExamStatus']['sgpa'];?></td></tr>
             <?php 
                if (!empty($student_section_exam_status['StudentExamStatus']['sgpa'])) {
                ?>
                <tr><td class="font">CGPA:&nbsp;&nbsp;&nbsp;<?php echo $student_section_exam_status['StudentExamStatus']['cgpa'];?></td></tr>
                <?php 
                
                }
                if (!empty($student_section_exam_status['StudentExamStatus']['AcademicStatus'])) {
                     echo '<tr><td class="font">Academic Status:&nbsp;&nbsp;&nbsp;'.$student_section_exam_status['StudentExamStatus']['AcademicStatus']['name'].'</td></tr>';
                }
             ?>
          
            <?php 

        echo "</table>";
    }
   ?>
       
       </td></tr>
       </table>
 <?php }
 
 */
 
 
  ?> 
  
  

         <table>

	        <?php 
	            if (!empty($previous_substitution_accepted)) {
	                echo "<tr><td class='smallheading' colspan=3> Previous course exemption request by you and accepted by the department.</td</tr>";
	                $count=0;
	                foreach ($previous_substitution_accepted as $psk=>$pvv) {
	                  echo "<tr><td><table>";
	                  echo "<tr><th>Course Title</th><th>Course Code</th><th>Credit</th></tr>";
	                  echo "<tr><td>".$pvv['CourseForSubstitued']['course_title']."</td><td>".$pvv['CourseForSubstitued']['course_code']."</td><td>".$pvv['CourseForSubstitued']['course_code']."</td></tr>";
	                   
	                  echo "</table></td><td class='smallheading' style='vertical-align:middle; align:center'>Substituted by => </td>";
	                  echo "<td>";
	                  echo "<table>";
echo "<tr><th>Course Title</th><th>Course Code</th><th>Credit</th></tr>";
echo "<tr><td>".$pvv['CourseBeSubstitued']['course_title']."</td><td>".$pvv['CourseBeSubstitued']['course_code']."</td><td>".$pvv['CourseBeSubstitued']['course_code']."</td></tr>";
echo "</table>";
	                  echo "</td></tr>";
	                }
	                
	            }
	        ?>
	    </table>
		<div class="smallheading"><?php __('Request Course Exemption'); ?></div>
	<?php
		//echo $this->Form->hidden('request_date');
		echo "<table>";
	//	echo $this->Form->input('course_id');
		echo "<tr><td width='25px'><table><tr><td style='width:24%'>Exempt Course</td><td style='width:76%'>".$this->Form->input('course_id',array('style'=>'width:250px',
		'label'=>false))."
		</td></tr></table></td><td><table>";
		
		
		echo "<tr><td>".$this->Form->input('taken_course_title')."</td></tr>";
		echo "<tr><td>".$this->Form->input('taken_course_code')."</td></tr>";
		echo "<tr><td>".$this->Form->input('course_taken_credit')."</td></tr>";
		echo "<tr><td>".$this->Form->input('reason').'</td></tr>';
		echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
		echo '<tr><td>'.$this->element('attachments', array('plugin' => 'media','label'=>'Upload profile picture')).'</td></tr></table></td></tr>';
		
		echo "</table>";
		//echo $this->Form->input('department_accept_reject');
		//echo $this->Form->input('department_reason');
		//echo $this->Form->input('registrar_confirm_deny');
		//echo $this->Form->input('registrar_reason');
		//echo $this->Form->input('department_approve');
		//echo $this->Form->input('department_approve_by');
		//echo $this->Form->input('registrar_approve');
		//echo $this->Form->input('registrar_approve_by');
		
		//echo $this->Form->input('student_id');
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
