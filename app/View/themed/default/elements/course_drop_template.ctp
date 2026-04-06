<?php 
if (isset($coursesDrop) && !empty($coursesDrop)) {
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
                $style="class='accepted'";    
                echo $this->Form->hidden('CourseDrop.'.$count.'.course_registration_id',array('value'=>$pv['CourseRegistration']['id'])); 
               // echo $this->Form->hidden('CourseRegistration.'.$count.'.course_id',array('value'=>$pv['course_id']));
                 echo $this->Form->hidden('CourseDrop.'.$count.'.academic_year',array('value'=>$pv['CourseRegistration']['academic_year']));
                // echo $this->Form->hidden('CourseRegistration.'.$count.'.section_id',array('value'=>$pv['section_id']));
                 echo $this->Form->hidden('CourseDrop.'.$count.'.semester',
                 array('value'=>$pv['CourseRegistration']['semester']));
                 echo $this->Form->hidden('CourseDrop.'.$count.'.student_id',array('value'=>$pv['CourseRegistration']['student_id']));
                  if (!empty($pv['CourseRegistration']['year_level_id'])) {
                    
                  echo $this->Form->hidden('CourseDrop.'.$count.'.year_level_id',array('value'=>$pv['CourseRegistration']['year_level_id']));
                  } else {
                    
                     echo $this->Form->hidden('CourseDrop.'.$count.'.year_level_id',array('value'=>0));
                  }
                  
                  
                  if ($pv['PublishedCourse']['drop'] == 1) {
                        echo $this->Form->hidden('CourseDrop.'.$count.'.forced',array('value'=>1));
                        echo $this->Form->hidden('CourseDrop.'.$count.'.department_approval',
                        array('value'=>1));
                       echo $this->Form->hidden('CourseDrop.'.$count.'.registrar_confirmation',array('value'=>1));     
                  }
             
                 if(in_array($pv['CourseRegistration']['id'],$already_dropped)){
                 echo "<tr class='linethough'><td>".++$count."</td><td>".$form->checkbox('CourseRegistration.drop.' . $pv['CourseRegistration']['id'],array('disabled'=>in_array($pv['CourseRegistration']['id'],$already_dropped)?true:false))."</td><td>".$pv['PublishedCourse']['Course']['course_title']."</td>";
                 } else {
                   if ($pv['PublishedCourse']['drop']==1) {
                       $style='class="exempted"';
                   } else {
                       
                       if (empty($pv['CourseRegistration']['type'])) {
                          $style='class="accepted"';
                       } else if ($pv['CourseRegistration']['type']==32 || $pv['CourseRegistration']['type']==33 || $pv['CourseRegistration']['type']==31) {
                            $style='class="rejected"';
                       }
                   
                   }
                    
                   echo "<tr ".$style." ><td>".++$count."</td><td>".$form->checkbox('CourseRegistration.drop.' . $pv['CourseRegistration']['id'])."</td><td>".$pv['PublishedCourse']['Course']['course_title']."</td>";
                 
                 }
                 
                 echo "<td>".$pv['PublishedCourse']['Course']['course_code']."</td>";
                 echo "<td>".$pv['PublishedCourse']['Course']['lecture_hours']."</td>";
                 echo "<td>".$pv['PublishedCourse']['Course']['tutorial_hours']."</td>";
                 echo "<td>".$pv['PublishedCourse']['Course']['credit']."</td></tr>";
                
            }
            if($count != count($already_dropped)) {
            echo "<tr><td colspan=7>".$this->Form->Submit('Drop Selected',array('div'=>false,'name'=>'drop'))."</td></tr>";
            }
         
                 
                 echo "<tr><td colspan=6>Note:<ol>
                    <li>The underline courses has already dropped.</li>
                    <li>Green marked courses  are courses you are not  adviced to drop .</li>
                     <li>Blue marked courses  are courses you are requested by department to drop .</li>
                    <li style='font-size:16px;color:red'>
                    Red marked courses are courses you are not elegible since you are not 
                    fullfilled prerequisite requirement or status, drop it.
                    </li>
                  
               
                </ol></td></tr>";
            
            echo  "</table>";
            
  }
?>
