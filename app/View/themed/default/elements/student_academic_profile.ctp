<?php ?>
<div class="students form" style="align:center">
        <div id='basic_info' style='display:block'>
            <?php 
            if (!empty($student_academic_profile)) {
                  echo $this->element('user_academic_menu',
                array('current_tab' => 'basic_info'));
                   echo "<div class=\"AddTab\">\n";
                echo '<table cellspacing="0" cellpading="0"><tbody>';
                echo "<tr><td><table><tbody>";
                echo '<tr><td colspan=2><strong>Demographic Information</strong></td></tr>';
               
		          echo '<tr><td style="padding-left:95px;">First Name:<strong> '.
		          $student_academic_profile['BasicInfo']['Student']['first_name'].'</strong></td></tr>';
		          echo '<tr><td style="padding-left:95px;">Amharic First Name:<strong>'.$student_academic_profile['BasicInfo']['Student']['amharic_first_name'].'</strong></td></tr>';
		          
		             echo '<tr><td style="padding-left:95px;">Middle Name:<strong>'.
		             $student_academic_profile['BasicInfo']['Student']['middle_name'].'</strong></td></tr>';
		            
		            echo '<tr><td style="padding-left:95px;">Amharic Middle Name:<strong>'.
		            $student_academic_profile['BasicInfo']['Student']['amharic_middle_name'].'</strong></td></tr>';
		            
		             echo '<tr><td style="padding-left:95px;">Last Name:<strong>'.$student_academic_profile['BasicInfo']['Student']['last_name'].'</strong></td></tr>';
		        
		         echo '<tr><td style="padding-left:95px;">Amharic Last Name:<strong>'.
		         $student_academic_profile['BasicInfo']['Student']['amharic_last_name'].'</strong></td></tr>';
		       
		          echo '<tr><td style="padding-left:95px;">Sex:<strong>'.$student_academic_profile['BasicInfo']['Student']['gender'].'</strong></td></tr>';
		          echo '<tr><td style="padding-left:95px;"> Student Number: '.$student_academic_profile['BasicInfo']['Student']['studentnumber'].'</td></tr>';
		             echo '<tr><td style="padding-left:95px;"> Birth Date:'.$this->Format->humanize_date($student_academic_profile['BasicInfo']['Student']['birthdate']).'</td></tr>';
		        
		        echo "</tbody></table></td>";
		
		          // save account information in the user table
		        echo '<td><table><tbody>';
		        echo '<tr><td colspan=2 style="height:50px; width:50px"><strong>Profile Picture</strong></td></tr>';
	           
		        if(isset($student_academic_profile['BasicInfo']['Attachment']) && !empty($student_academic_profile['BasicInfo']['Attachment'])){
                    foreach($student_academic_profile['BasicInfo']['Attachment'] as $ak=>$av){
                       if(!empty($av['dirname']) && !empty($av['basename']) ){
                      // echo $media->embed($media->file('s'.DS.$av['dirname'].DS.$av['basename']));
                       echo $media->embed($media->file($av['dirname'].DS.$av['basename']),
                       array('width'=>'144'));
                       
                       }
                    
				    }
                } else {
                    echo '<tr><td valign="top" align="right"><img src="/img/noimage.jpg" 
                    width="144" class="profile-picture"></td></tr>';
                }
		        echo '<tr><td colspan=2><strong>Access Information</strong></td></tr>';
                
		        echo '<tr><td> Username: '.$student_academic_profile['BasicInfo']['Student']['studentnumber'].'</td></tr>';
		        	
		         echo '<tr><td colspan=2><strong>Classification of Admission</strong></td></tr>';
		         echo "<tr><td> Program: ".$student_academic_profile['BasicInfo']['Program']['name']."</td></tr>";
			    
			     echo "<tr><td> Program Type: ".$student_academic_profile['BasicInfo']['ProgramType']['name']."</td></tr>";
			     
				
		        echo "<tr><td> College: ".$student_academic_profile['BasicInfo']['College']['name']."</td></tr>";
               
                  if (!empty($student_academic_profile['BasicInfo']['Student']['department_id'])) {
                        echo "<tr><td> Department:".$student_academic_profile['BasicInfo']['Department']['name'].'</td></tr>';
                      
                  } else {
                  
                        echo "<tr><td> Department:--- </td></tr>";
                        
                  }
                
                  echo '<tr><td>Admission Year: '.$this->Format->humanize_date(
                  $student_academic_profile['BasicInfo']['Student']['admissionyear']).'</td></tr>';
		        
		        
		        echo '</tbody></table></td>';
		        
		         echo "</tr>";
		        echo '</tbody></table>';
		        
		        }
		    echo "</div>"; // end add tab div
            
            ?>  
        </div>
		<div id="registred_course" style="display:none">	
		 <?php
		  
            echo $this->element('user_academic_menu',
                array('current_tab' => 'registred_course'));
         
            echo "<div class=\"AddTab\">\n";
                 if (!empty($student_academic_profile)) {
                     echo '<table>';
                        echo '<tr><th>Course</th><th>Credit</th><th>Acadamic Year</th><th>Semester</th></tr>';
                        foreach ($student_academic_profile['Course Registered'] as $in=>$value ) {
                           
                            echo '<tr>';
                            echo '<td>'.$value['course_title'].'</td>';
                            echo '<td>'.$value['credit'].'</td>';
                            echo '<td>'.$value['acadamic_year'].'</td>';
                             echo '<td>'.$value['semester'].'</td>';
                            echo '</tr>';
                        }
                     echo '</table>';
                 }
		    echo "</div>"; // end add tab div
		    
	    ?>
	   </div> <!-- end registred info block --->
	 
	  <div id="add_courses" style="display:none">	
		 <?php
		  
            echo $this->element('user_academic_menu',
                array('current_tab' => 'add_courses'));
           
            echo "<div class=\"AddTab\">\n";
            
                 if (!empty($student_academic_profile)) {
                     echo '<table>';
                        echo '<tr><th>Course</th><th>Credit</th><th>Acadamic Year</th><th>Semester</th></tr>';
                        foreach ($student_academic_profile['Course Added'] as $in=>$value ) {
                           
                            echo '<tr>';
                            echo '<td>'.$value['course_title'].'</td>';
                            echo '<td>'.$value['credit'].'</td>';
                            echo '<td>'.$value['acadamic_year'].'</td>';
                             echo '<td>'.$value['semester'].'</td>';
                            echo '</tr>';
                        }
                     echo '</table>';
                 }
                 
		    echo "</div>"; // end add tab div
		    
	    ?>
	   </div> <!-- end add course info block --->
	   
	   
	   
	    <div id="drop_courses" style="display:none">	
		 <?php
		  
            echo $this->element('user_academic_menu',
                array('current_tab' => 'drop_courses'));
           
            echo "<div class=\"AddTab\">\n";
                    if (!empty($student_academic_profile)) {
                     echo '<table>';
                        echo '<tr><th>Course</th><th>Credit</th><th>Acadamic Year</th><th>Semester</th></tr>';
                        foreach ($student_academic_profile['Course Dropped'] as $in=>$value ) {
                           
                            echo '<tr>';
                            echo '<td>'.$value['course_title'].'</td>';
                            echo '<td>'.$value['credit'].'</td>';
                            echo '<td>'.$value['acadamic_year'].'</td>';
                             echo '<td>'.$value['semester'].'</td>';
                            echo '</tr>';
                        }
                     echo '</table>';
                 }
		    echo "</div>"; // end add tab div
		    
	    ?>
	   </div> <!-- end add course info block --->
	 
	   <div id="exam_result" style="display:none">	
		 <?php
		  
            echo $this->element('user_academic_menu',
                array('current_tab' => 'exam_result'));
           
            echo "<div class=\"AddTab\">\n";
                   echo $this->element('grade_report_organized_by_ac_semester');
                 
		    echo "</div>"; // end add tab div
		    
	    ?>
	   </div> <!--- end add course info block --->
	 
       <div id="curriculum" style="display:none">
	   <?php   
      
	    echo $this->element('user_academic_menu',
                array('current_tab' => 'curriculum'));
            
            echo "<div class=\"AddTab\">\n";
            if(!empty($student_academic_profile['Curriculum']['id'])){
                echo '<table>';
                echo '<tr>';
                echo '<td>';
                ?>
                <table>
                  <tr><td><?php echo '<strong>Name:</strong>'; ?> &nbsp;&nbsp;<?php 
                  echo $student_academic_profile['Curriculum']['name']; ?></td></tr>
        <tr><td><?php 
        echo '<strong>Year Introduced:</strong>';
        
         ?>&nbsp;&nbsp;<?php echo $student_academic_profile['Curriculum']['year_introduced']; ?></td></tr>
        <tr><td><?php
         echo '<strong>Type Of Credit:</strong>'; ?>&nbsp;&nbsp;<?php echo $student_academic_profile['Curriculum']['type_credit']; ?></td></tr>
        <tr><td><?php 
         echo '<strong>Amharic Degree Nomenclature:</strong>';
        
        
        ?>&nbsp;&nbsp;<?php echo $student_academic_profile['Curriculum']['amharic_degree_nomenclature']; ?></td></tr>
        <tr><td><?php 
        
         echo '<strong>English Degree Nomenclature:</strong>'; ?>&nbsp;&nbsp;<?php echo $student_academic_profile['Curriculum']['english_degree_nomenclature']; ?></td></tr>
        <tr><td><?php 
            echo '<strong>Minimum Credit Points:</strong>';  
        ?>&nbsp;&nbsp;<?php echo $student_academic_profile['Curriculum']['minimum_credit_points']; ?></td></tr>
        
        </table>
                <?php 
                echo '</td>';
                echo '<td>';
                       ?>
                       <table>
                        <tr>
                        <th>S.N<u>o</u></th><th>Name</th><th>Mandatory Credit</th>
                        <th>Total Credit</th>
                        </tr>
                        <?php 
                            $cCount=1;
                            foreach ($student_academic_profile['Curriculum']['CourseCategory'] as $courseCategory=>$courseCategoryValue) {
                                echo '<tr>';
                                echo '<td>'.$cCount++.'</td><td>'.$courseCategoryValue['name'].'</td><td>'.
                                $courseCategoryValue['mandatory_credit'].'</td><td>'.
                                $courseCategoryValue['total_credit'].'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </table>
                       <?php 
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan=2>';
                   echo $this->element('curriculum_organized_semester_courses');
                echo '</td>';
                echo '</tr>';
                echo '</table>';
                } else {
                    echo '<div class="info-box info-message"><span></span>The student is not yet attached to the  curriculum.</div>';
                }
            echo '</div>';
      ?>
      </div> <!-- end curriculum --->

</div>
