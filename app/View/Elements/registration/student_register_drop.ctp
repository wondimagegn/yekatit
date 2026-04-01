<?php  
     //debug($student_section['CourseRegistration']);
 if (isset($coursesDrop) && !empty($coursesDrop)) {
           //debug($published_courses);
            echo "<table id='fieldsForm'><tbody>";
            
            ?>
         
            
            <?php 
            
            echo "<tr><th style='padding:0'> S.No </th>";
             echo "<th style='padding:0'> Select </th>";
            echo "<th style='padding:0'> Course Title </th>";
            echo "<th style='padding:0'> Course Code </th>";
            echo "<th style='padding:0'> Lecture hour </th>";
            echo "<th style='padding:0'> Tutorial hour </th>"; 
            echo "<th style='padding:0'> Credit </th></tr>";
            $count=0;
           
            foreach ($coursesDrop as $pk=>$pv) {
                echo $this->Form->hidden('CourseDrop.'.$count.'.course_registration_id',array('value'=>$pv['CourseRegistration']['id'])); 
            
                 echo $this->Form->hidden('CourseDrop.'.$count.'.academic_year',array('value'=>$pv['CourseRegistration']['academic_year']));
               
                 echo $this->Form->hidden('CourseDrop.'.$count.'.semester',
                 array('value'=>$pv['CourseRegistration']['semester']));
                 echo $this->Form->hidden('CourseDrop.'.$count.'.student_id',array('value'=>$pv['CourseRegistration']['student_id']));
                  echo $this->Form->hidden('CourseDrop.'.$count.'.year_level_id',array('value'=>$pv['CourseRegistration']['year_level_id']));
              
              
                 if(in_array($pv['CourseRegistration']['id'],$already_dropped)){
                 echo "<tr class='linethough'><td>".++$count."</td><td>".$this->Form->checkbox('CourseRegistration.drop.' . $pv['CourseRegistration']['id'],array('disabled'=>in_array($pv['CourseRegistration']['id'],$already_dropped)?true:false))."</td><td>".$pv['PublishedCourse']['Course']['course_title']."</td>";
                 } else {
                   echo "<tr><td>".++$count."</td><td>".$this->Form->checkbox('CourseRegistration.drop.' . $pv['CourseRegistration']['id'])."</td><td>".$pv['PublishedCourse']['Course']['course_title']."</td>";
                 }
                 echo "<td>".$pv['PublishedCourse']['Course']['course_code']."</td>";
                 echo "<td>".$pv['PublishedCourse']['Course']['lecture_hours']."</td>";
                 echo "<td>".$pv['PublishedCourse']['Course']['tutorial_hours']."</td>";
                 echo "<td>".$pv['PublishedCourse']['Course']['credit']."</td></tr>";
                
            }
          //}
            if($count != count($already_dropped)) {
            echo "<tr><td colspan=7>".$this->Form->Submit('Drop Selected',array('div'=>false,'class'=>'tiny radius button bg-blue','name'=>'drop'))."</td></tr>";
            }
            if (isset($already_dropped) && !empty($already_dropped)) {
                echo "<tr><td colspan=7 class='smallheading'>Note: The uderline courses has already dropped.</td></tr>";
            }
            echo  "</table>";
            
  }
 if (isset($published_courses) && !empty ($published_courses)) {
            echo "<table id='fieldsForm'><tbody>";
            
            ?>
         
            
            <?php 
            
            echo "<tr><th style='padding:0'> S.No </th>";
            echo "<th style='padding:0'> Course Title </th>";
            echo "<th style='padding:0'> Course Code </th>";
            echo "<th style='padding:0'> Lecture hour </th>";
            echo "<th style='padding:0'> Tutorial hour </th>"; 
            echo "<th style='padding:0'> Credit </th></tr>";
            $count=1;
           
            foreach ($published_courses as $pk=>$pv) {
              
                 /**
                 * allow registration without passing prerequiste but the registration 
                 * should be cancelled by the registrar in case student grade is not changed.
                 */
                 $style="class='accepted'";                
                
                 
                 // normal registration 
                 if (!isset($pv['prequisite_taken_passsed']) && !isset($pv['exemption'])) {
                   
                      echo $this->Form->hidden('CourseRegistration.'.$count.'.published_course_id',array('value'=>$pv['PublishedCourse']['id']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.course_id',array('value'=>$pv['Course']['id']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.semester',array('value'=>$pv['PublishedCourse']['semester']));
                      echo $this->Form->hidden('CourseRegistration.'.$count.'.academic_year',array('value'=>$pv['PublishedCourse']['academic_year']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.student_id',
                     array('value'=>$student_section['Student']['id']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.section_id',
                     array('value'=>$student_section['Section'][0]['id']));
                     
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.year_level_id',
                     array('value'=>$student_section['Section'][0]['year_level_id']));
                     
                 }
                 
                 if (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==0) {
                     $style='class="rejected"';
                 }
                 
                 if (isset($pv['exemption']) && $pv['exemption']==1) {
                     $style='class="exempted"';
                 }
                 
                 
                 // type of registration 
                 
                 if ((isset($pv['registration_type']) && $pv['registration_type']==2
                 && !isset($pv['exemption']))) {
                    echo $this->Form->hidden('CourseRegistration.'.$count.'.type',array('value'=>11));
                        
                    echo "<tr><td>".$count++."</td><td>".$pv['Course']['course_title']."**"."</td>";
                 
                 } else if (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==2
                 && !isset($pv['exemption']) ) {
                    echo $this->Form->hidden('CourseRegistration.'.$count.'.type',array('value'=>11));
                        
                 echo "<tr><td>".$count++."</td><td>".$pv['Course']['course_title']."**"."</td>";
                 
                 } else if ((isset($pv['registration_type']) && $pv['registration_type']==2) &&
                 (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==2) 
                 && !isset($pv['exemption'])) {
                      echo $this->Form->hidden('CourseRegistration.'.$count.'.type',array('value'=>13));
                      
                 echo "<tr><td>".$count++."</td><td>".$pv['Course']['course_title']."**"."</td>";
                 
                 } else  {
                        if ((isset($dismissed) && $dismissed===true)) {
                          $style='class="rejected"';
                        } 
                        
                       echo "<tr ".$style." ><td>".$count++."</td><td>".$pv['Course']['course_title']."</td>"; 
                                             
                 }
                 
                 
                 echo "<td>".$pv['Course']['course_code']."</td>";
                 echo "<td>".$pv['Course']['lecture_hours']."</td>";
                 echo "<td>".$pv['Course']['tutorial_hours']."</td>";
                 echo "<td>".$pv['Course']['credit']."</td></tr>";
            }
          //}
            if((isset($dismissed) && $dismissed===true)){
            // dont show 
            } else if (!isset($deadlinepassed)){
              echo "<tr><td colspan=6>".$this->Form->submit(__('Register'),
              array('name'=>'register','div'=>false))."</td></tr>";
              
            }
             if(!isset($dismissed)){
                 echo "<tr><td colspan=6>Note: <ol>
                    <li>Green marked courses  are courses you are elegible for registration.</li>
                    <li>Red marked courses are courses you are not elegible for registration since you are not fullfilled prerequisite requirement.
                    </li>
                     <li>Blue marked courses are courses that are exempted.
                    
                    </li>
                    <li>** registration on hold, since either student academic  status is not generated or grade for the prerequsite is not submitted.
                    
                    </li>
               
                </ol></td></tr>";
            }
            echo  "</table>";
}    
?>
