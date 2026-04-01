<div class="courseSubstitutionRequests form">
<?php echo $this->Form->create('CourseSubstitutionRequest');?>
<?php 
 
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
 <?php } ?> 
 <table>
    <tr>
 	 <td>
	    <table>
	        <?php 
	            if (!empty($previous_substitution_accepted)) {
	                echo "<tr><td class='smallheading' colspan=3> Previous course substitution request by this students and accepted by the department.</td</tr>";
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
	 </td></tr>
  </table>
  <div class="smallheading"><?php echo __('Course Substitution Request Waiting Decision'); ?></div>
  <?php 
        echo $this->Form->hidden('id');
	
		echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
		echo $this->Form->hidden('request_date');
		
		$options=array('1'=>'Accept','0'=>'Reject');
        $attributes=array('legend'=>false,'label'=>false,'separator'=>"<br/>");
       
  ?>
  <table cellspacing="0" cellpadding="0" class="fs14 small_padding">
		<tr>
		    <td style="width:13%"> Request Date:</td>
		    <td style="width:37%"><?php echo $this->Format->humanize_date($this->request->data['CourseSubstitutionRequest']['request_date']); ?></td>
		    <td style="width:13%">&nbsp;</td>
		    <td style="width:37%"> &nbsp;</td>
	    </tr>
	    <tr>
	      <td style="width:13%">Course For Substituted:</td>
		  <td style="width:37%"><?php 
		   echo $courseBeSubstitueds[$this->request->data['CourseSubstitutionRequest']['course_for_substitued_id']];
		  echo $this->Form->hidden('course_for_substitued_id'); ?></td>
		  
		  <td style="width:13%">Course Be Substituted:</td>
		  <td style="width:37%"><?php 
		  echo $courseBeSubstitueds[$this->request->data['CourseSubstitutionRequest']['course_be_substitued_id']];
		  echo $this->Form->hidden('course_be_substitued_id'); ?></td>
		  
		  
	    </tr>
	   <tr>
	      
		  <td style="width:13%">Accept/Reject Request:</td>
		  <td style="width:37%"><?php echo $this->Form->radio('department_approve',$options,$attributes); ?></td>
	      <td style="width:13%">Remark:</td>
		  <td style="width:37%"><?php echo $this->Form->input('remark',array('label'=>false)); ?></td>
		  
	    </tr>
  </table>
  <!---
  <table>
       <tr><td>
       <table>	
        <tr><td>	
		<legend class="smallheading"><?php echo __('Course Substitution Request Waiting Decision'); ?></legend>
		
		</td></tr>
	<?php
		echo $this->Form->hidden('id');
		echo '<tr><td>'.$this->Form->input('request_date').'</td></tr>';
		echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
		echo '<tr><td>'.$this->Form->input('course_for_substitued_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('course_be_substitued_id').'</td></tr>';
		$options=array('1'=>'Accept','0'=>'Reject');
        $attributes=array('legend'=>false,'separator'=>"<br/>");
		echo '<tr><td style="padding-left:300px"> Accept/Reject Request <br/>'.$this->Form->radio('department_approve',$options,$attributes).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('remark',array('label'=>'Remark')).'</td></tr>';
		
	?>
	</table>
	 </td>

	 </tr>
  </table>
  --->
<?php echo $this->Form->end(__('Submit'));?>
</div>
