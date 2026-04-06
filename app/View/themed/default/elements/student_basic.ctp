<?php 

 if (isset($student_section_exam_status) && !empty($student_section_exam_status)) {   
?>
    <table><tr><td>
     <table>
           
           <tr><td class="font">College:&nbsp;&nbsp;&nbsp;
            <?php 
            
            echo $student_section_exam_status['College']['name'];
            
            ?>
            </td></tr>
            
           <tr><td class="font">Department:&nbsp;&nbsp;&nbsp;
            <?php 
                if (isset($student_section_exam_status['Department']['name'])
                && !empty($student_section_exam_status['Department']['name'])) {
                   echo $student_section_exam_status['Department']['name'];
                 } else {
                    echo 'Pre/Freshman';
                 }
            ?>
            </td></tr>
             <tr><td class="font">Program:&nbsp;&nbsp;&nbsp;
            <?php 
                if (isset($student_section_exam_status['Program']['name'])
                && !empty($student_section_exam_status['Program']['name'])) {
                   echo $student_section_exam_status['Program']['name'];
                 } else {
                    echo '---';
                 }
            ?>
            </td></tr>
             <tr><td class="font">Program Type:&nbsp;&nbsp;&nbsp;
            <?php 
                if (isset($student_section_exam_status['ProgramType']['name'])
                && !empty($student_section_exam_status['ProgramType']['name'])) {
                   echo $student_section_exam_status['ProgramType']['name'];
                 } else {
                    echo '---';
                 }
            ?>
            </td></tr>
            
            <tr><td class="font">Name:&nbsp;&nbsp;&nbsp;
            <?php 
              if (isset($student_section_exam_status['StudentBasicInfo']['full_name'])) {
                //echo $student_section_exam_status['StudentBasicInfo']['full_name'];
                 
                 echo $this->Html->link($student_section_exam_status['StudentBasicInfo']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile',$student_section_exam_status['StudentBasicInfo']['id']));
              } else if (isset($student_section_exam_status['Student']['full_name'])) {
               // echo $student_section_exam_status['Student']['full_name'];
                
                 echo $this->Html->link($student_section_exam_status['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile',$student_section_exam_status['Student']['id']));
              }
            ?>
            </td></tr>
            <tr><td class="font">Student Number:&nbsp;&nbsp;&nbsp;
            <?php
                if (isset($student_section_exam_status['StudentBasicInfo']['studentnumber'])) { 
                   // echo $student_section_exam_status['StudentBasicInfo']['studentnumber']; 
                    echo $this->Html->link($student_section_exam_status['StudentBasicInfo']['studentnumber'], array('controller' => 'students', 'action' => 'student_academic_profile',$student_section_exam_status['StudentBasicInfo']['id']));
                } else if (isset($student_section_exam_status['Student']['studentnumber'])) {
                    // echo $student_section_exam_status['Student']['studentnumber'];
                     
                      echo $this->Html->link($student_section_exam_status['Student']['studentnumber'], array('controller' => 'students', 'action' => 'student_academic_profile',$student_section_exam_status['Student']['id']));
                }
            ?>
            </td></tr>
         
            <tr><td class="font">Year Level:&nbsp;&nbsp;&nbsp;
            <?php 
               if (isset($student_section_exam_status['Section']['YearLevel']['name'])) {
                    echo $student_section_exam_status['Section']['YearLevel']['name'];
               } else {
                    if (isset($student_section_exam_status['Section']) && $student_section_exam_status['Section']['StudentsSection']['archive']==0) {
                            echo 'Pre/Fresh';
                    } else {
                        echo '---';
                    }
                    
               }
            ?>
            </td></tr>
            <tr><td class="font">Section:&nbsp;&nbsp;&nbsp;
            <?php 
            if (isset($student_section_exam_status['Section']['name'])) {
                echo $student_section_exam_status['Section']['name'];
            } else {
                echo '---';
            }
            ?>
            </td></tr>
            
           
       </table>
       </td><td>
        <?php 
         if (!empty($student_section_exam_status['StudentExamStatus'])) {
            echo "<table>";
           
            ?>
           <tr><td class="font">Semester:&nbsp;&nbsp;&nbsp;<?php
           		if (isset($student_section_exam_status['StudentExamStatus']['semester'])) {
           		  
            		echo $student_section_exam_status['StudentExamStatus']['semester'];
           		} else {
           		     echo '---';
           		}
           		
            
            ?></td></tr>
            <tr><td class="font">Academic Year:&nbsp;&nbsp;&nbsp;<?php 
            if (isset($student_section_exam_status['StudentExamStatus']['academic_year'])) {
              
            echo $student_section_exam_status['StudentExamStatus']['academic_year'];
            
            } else {
            	echo '---';
            }
            
            ?></td></tr>
         
             <tr><td class="font">SGPA:&nbsp;&nbsp;&nbsp;<?php 
               if (isset($student_section_exam_status['StudentExamStatus']['sgpa'])) {
                 	echo $student_section_exam_status['StudentExamStatus']['sgpa'];
             
               } else {
               		echo '---';
               }
             	
             
             ?></td></tr>
             <?php 
                if (!empty($student_section_exam_status['StudentExamStatus']['sgpa'])) {
                ?>
                <tr><td class="font">CGPA:&nbsp;&nbsp;&nbsp;<?php echo $student_section_exam_status['StudentExamStatus']['cgpa'];?></td></tr>
                <?php 
                
                }
                
                if (!empty($student_section_exam_status['StudentExamStatus']['AcademicStatus'])) {
                     echo '<tr><td class="font">Academic Status:&nbsp;&nbsp;&nbsp;';
                     if (isset($student_section_exam_status['StudentExamStatus']['AcademicStatus'])) {
                     	echo $student_section_exam_status['StudentExamStatus']['AcademicStatus']['name'];
                     } else {
                     	echo '---';
                     }
                     
                     
                     echo '</td></tr>';
                }
             ?>
          
            <?php 

        echo "</table>";
    }
   ?>
       
       </td></tr>
       </table>
 <?php 
 
 }
 
?> 	
