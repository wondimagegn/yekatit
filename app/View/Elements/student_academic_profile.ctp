<?php ?>
<div class="row">
<div class="large-12 columns">
	<!-- tabs -->
	<ul class="tabs" data-tab>
	    <li class="tab-title active"><a href="#basicinformation">Basic</a>
	    </li>
		 <li class="tab-title"><a href="#exemption">Exemption</a>
	    </li>
	    <li class="tab-title"><a href="#registration">Registration</a>
	    </li>
	    <li class="tab-title"><a href="#addcourses">Add Courses</a>
	    </li>
	    <li class="tab-title"><a href="#dropcourses">Drop Courses</a>
	    </li>
	   <li class="tab-title"><a href="#examresults">Results</a>
	    </li>

	  <li class="tab-title"><a href="#curriculum">Curriculum</a>
	    </li>
	    <li class="tab-title"><a href="#Billing">Billing</a>
	    </li>
	</ul>
	<div class="tabs-content edumix-tab-horz">
	    <div class="content active" id="basicinformation">
	        <?php 
			
           if (!empty($student_academic_profile)) 
           {
                 
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
		             if($role_id!=ROLE_STUDENT){
                             echo '<tr><td style="padding-left:95px;">ID Card Printed:'.$student_academic_profile['BasicInfo']['Student']['print_count'].' times </td></tr>';
		             }
		            

$prevSection=array();
$sectionLess=true;

foreach ($studentAttendedSections as $index=>$student_copys) {
	if($prevSection!=$student_copys['Section']) {
		
?>
     <tr>
		
		<td> <strong><?php 
		if(!empty($student_copys['YearLevel']['name'])) {
				echo $student_copys['Section']['name'].'('.$student_copys['YearLevel']['name'].')';
		} else {
		  echo $student_copys['Section']['name'].'(1st)';
		}
 ?>
		  <?php 
		echo $student_copys['Section']['archive']==true ? 'Previous Section':'Current Section'; ?>
		</strong>

		</td>
		<td>
		<?php 
		   if($student_copys['Section']['archive']==false) 
           {
			  $sectionLess=false;
              echo $this->Html->link('Move Section','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalAdd','data-reveal-ajax'=>'/sections/move_student_section_to_new/'.
$student_copys['Section']['id'].'/'.$student_academic_profile['BasicInfo']['Student']['id']));
			 echo '<br/>';
			/*
			 echo $this->Html->link(__('Delete'), array('controller'=>'Sections','action' => 'deleteStudentforThisSection', $student_copys['Section']['id'], str_replace('/','-',$student_academic_profile['BasicInfo']['Student']['studentnumber'])),null, sprintf(__('Are you sure you want to delete %s?'),$student_academic_profile['BasicInfo']['Student']['full_name'], str_replace('/','-',$student_academic_profile['BasicInfo']['Student']['studentnumber'])));
		echo '<br/>';
		echo $this->Html->link('Upgrade','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalAdd','data-reveal-ajax'=>'/sections/upgrade_selected_student_section/'.
$student_copys['Section']['id'].'/'.$student_academic_profile['BasicInfo']['Student']['id']));
	*/
          } 

     echo $this->Html->link(__('Delete'), array('controller'=>'Sections','action' => 'deleteStudent', $student_copys['Section']['id'], str_replace('/','-',$student_academic_profile['BasicInfo']['Student']['studentnumber'])),null, sprintf(__('Are you sure you want to delete %s?'),$student_academic_profile['BasicInfo']['Student']['full_name'], str_replace('/','-',$student_academic_profile['BasicInfo']['Student']['studentnumber'])));

			?>
		</td>
		
	 </tr>

<?php
		$prevSection=$student_copys['Section'];
	}		
}

if ($this->Session->read('role_id')== ROLE_DEPARTMENT || $this->Session->read('role_id')==ROLE_COLLEGE || $this->Session->read('role_id')==ROLE_REGISTRAR ) {
	if($sectionLess || true) {
 echo '<tr><td>'.$this->Html->link('Add Student To Section','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalAdd',
'data-reveal-ajax'=>'/sections/add_student_to_section/'
.$student_academic_profile['BasicInfo']['Student']['id'])).'</td></tr>';

	echo '<tr><td>'.$this->Html->link('Manage Registration','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalReg',
'data-reveal-ajax'=>'/courseRegistrations/manage_missing_registration/'
.$student_academic_profile['BasicInfo']['Student']['id'])).'</td></tr>';

	}

}

if ( $this->Session->read('role_id')== ROLE_REGISTRAR) {

 echo '<tr><td>'.$this->Html->link('Add Exempted Courses From Other University','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalAdd',
'data-reveal-ajax'=>'/courseExemptions/add_student_exempted_course/'
.$student_academic_profile['BasicInfo']['Student']['id'])).'</td></tr>';


 echo '<tr><td>'.$this->Html->link('Add Readmitted Year','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalAdd',
'data-reveal-ajax'=>'/readmissions/ajax_readmitted_year/'
.$student_academic_profile['BasicInfo']['Student']['id'])).'</td></tr>';


	  }
      
		        echo "</tbody></table></td>";
		
		          // save account information in the user table
		        echo '<td><table><tbody>';
		        echo '<tr><td colspan=2 style="height:50px; width:50px"><strong>Profile Picture</strong></td></tr>';
	           
		        if(isset($student_academic_profile['BasicInfo']['Attachment']) && !empty($student_academic_profile['BasicInfo']['Attachment'])){
                    foreach($student_academic_profile['BasicInfo']['Attachment'] as $ak=>$av){
					
                       if(!empty($av['dirname']) && !empty($av['basename']) ){
                      // echo $this->Media->embed($this->Media->file('s'.DS.$av['dirname'].DS.$av['basename']));
                       echo $this->Media->embed($this->Media->file($av['dirname'].DS.$av['basename']),
                       array('width'=>'144'));
                       
                       }
                    
				    }
                } else {
                    echo '<tr><td valign="top" align="right"><img src="/img/noimage.jpg" 
                    width="144" class="profile-picture"></td></tr>';
                }
		        echo '<tr><td colspan=2><strong>Access Information</strong></td></tr>';
                
		        echo '<tr><td> Username: '.$student_academic_profile['BasicInfo']['Student']['studentnumber'].'</td></tr>';
		        echo '<tr><td> Ecardnumber: '.$student_academic_profile['BasicInfo']['Student']['ecardnumber'].'</td></tr>';
                          if ( $this->Session->read('role_id')== ROLE_REGISTRAR) {
				  if($student_academic_profile['BasicInfo']['User']['active']==1){
				   echo '<tr><td>'.$this->Html->link(__('Deactivate', true), array('action' => 'activate_deactivate_profile', 
				   	$student_academic_profile['BasicInfo']['Student']['id'])).'</td></tr>';
				  } else {
				      echo '<tr><td>'.$this->Html->link(__('Activate', true), array('action' => 'activate_deactivate_profile', 
				   	$student_academic_profile['BasicInfo']['Student']['id'])).'</td></tr>';
				  }
               		}
		        	
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
		        
		          echo '<tr><td>'.$this->Html->link('View Preferences','#',array('data-animation'=>"fade",'data-reveal-id'=>'myModalPref',
'data-reveal-ajax'=>'/preferences/getStudentPreference/'
.$student_academic_profile['BasicInfo']['Student']['accepted_student_id'])).'</td></tr>';
		        
		        echo '</tbody></table></td>';
		        
		         echo "</tr>";
		        echo '</tbody></table>';
		        // debug($student_academic_profile);



		        } 
		    echo "</div>"; // end add tab div
            
            ?>  
	    </div>

       <div class="content" id="exemption">
	       <?php
		  
          
            echo "<div class=\"AddTab\">\n";
                 if (!empty($student_academic_profile)) {
                     echo '<table>';
                     if(!empty($student_academic_profile['CourseExemption'][0])){
                     echo '<tr><th colspan="4">'.strtoupper($student_academic_profile['CourseExemption'][0]['transfer_from']).'</tr>';
                     }
           echo '<tr><th colspan="2">Taken Course</th><th colspan="2">Exempted By</th></tr>';
 echo '<tr><th>Course</th><th></th><th>Course</th></tr>';
		   
                        foreach ($student_academic_profile['CourseExemption'] as $in=>$value ) {
                           
                            echo '<tr>';
                            echo '<td>'.$value['taken_course_title'].'('.$value['taken_course_code'].')'.'</td>';
                            echo '<td>'.$value['course_taken_credit'].'</td>';
                            echo '<td>'.$value['Course']['course_title'].'('.$value['Course']['course_code'].')'.'</td>';
                             echo '<td>'.$value['Course']['credit'].'</td>';
                            echo '</tr>';
                        }
                     echo '</table>';
                 }
		    echo "</div>"; // end add tab div
		    
	    ?>
	    </div>
	    <div class="content" id="registration">
	       <?php
		  
          
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
	    </div>
	    <div class="content" id="addcourses">
	       <?php
		  
             echo "<div class=\"AddTab\">\n";
            
                 if (!empty($student_academic_profile)) {
                     echo '<table>';
                        echo '<tr><th>Course</th><th>Credit</th><th>Acadamic Year</th><th>Semester</th><th>Section</th></tr>';
                        foreach ($student_academic_profile['Course Added'] as $in=>$value ) {
                           
                            echo '<tr>';
                            echo '<td>'.$value['course_title'].'</td>';
                            echo '<td>'.$value['credit'].'</td>';
                            echo '<td>'.$value['acadamic_year'].'</td>';
                             echo '<td>'.$value['semester'].'</td>';
			   echo '<td>'.$value['sectionname'].'('.$value['curriculumname'].')'.'</td>';
                            echo '</tr>';
                        }
                     echo '</table>';
                 }
                 
		    echo "</div>"; // end add tab div
		    
	    ?>
	    </div>
	    <div class="content" id="dropcourses">
	        <?php
		  
          
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
	   </div> <!-- end add course info block -->
	 
	   <div id="exam_result" style="display:none">	
		 <?php
		  
            
            echo "<div class=\"AddTab\">\n";
                   echo $this->element('grade_report_organized_by_ac_semester');
                 
		    echo "</div>"; // end add tab div
		    
	    ?>
	    </div>
	    <div class="content" id="examresults">
	        <?php
		  
           echo "<div class=\"AddTab\">\n";
                   echo $this->element('grade_report_organized_by_ac_semester');
                 
		    echo "</div>"; // end add tab div
		    
	    ?>
	    </div>
	   <div class="content" id="curriculum">
	          <?php  
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
	    </div>

	     <div class="content" id="Billing">
	        <?php
		  
           echo "<div class=\"AddTab\">\n";
                echo $this->element('billing');
                 
		    echo "</div>"; // end add tab div
		    
	    ?>
	    </div>

	</div>
<!-- end of tabs -->

</div>
</div>
<a class="close-reveal-modal">&#215;</a>

<div class="row">
	<div class="large-12 columns">
		<div id="myModalMove" class="reveal-modal" data-reveal>

		</div>

		<div id="myModalAdd" class="reveal-modal" data-reveal>

		</div>

		<div id="myModalReg" class="reveal-modal" data-reveal>

		</div>

		<div id="myModalPref" class="reveal-modal" data-reveal>

		</div>

	</div>
</div>
