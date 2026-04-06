<?php 

   if ($this->Session->read('candidate_publish_courses')) {
        $coursesss=$this->Session->read('candidate_publish_courses');
          
        $taken_courses_allow_to_publishe_it=$this->Session->read('taken_courses_allow_to_publishe_it');
	    $selected_section=$this->Session->read('selected_section');
	    $published_courses_disable_not_to_published=$this->Session->read('published_courses_disable_not_to_published');
	   
  if(!empty($coursesss)) {
       
                ?>

           <?php 
       
           $display_button=0;
           $section_count=0;
           foreach($coursesss as $section_id=>$coursss) {
           $section_count++;
           if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=8><?php echo "Section: ".$selected_section[$section_id]; ?></td></tr>
                    <tr><th colspan=8><?php echo "Select the course you want to publish."; ?></td></tr>
                    <tr>
                    <?php 
                    echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Lecture hour </th>";
                    echo "<th style='padding:0'> Tutorial hour </th>"; 
                    echo "<th style='padding:0'> Credit </th>";
                    //echo "<th style='padding:0'> Action </th></tr>";
                    $count=1;
                    foreach ($coursss as $kc=>$vc) {
                        echo "<tr>";
                        
                         if(isset($published_courses_disable_not_to_published[$section_id])
                          && in_array($vc['Course']['id'],
                 $published_courses_disable_not_to_published[$section_id])){
                          /*echo '<td>'.$form->checkbox('Course.'.$section_id.'.'.$vc['Course']['id'],
                         array('disabled'=>in_array($vc['Course']['id'],
                 $published_courses_disable_not_to_published[$section_id])?true:false)) . '</td>';
                         */
                           echo "<td>**</td>";
	                      } else {
                             echo '<td>'.$form->checkbox('Course.'.$section_id.'.'.$vc['Course']['id']) . '</td>';
                          }
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         echo "<td>".$vc['Course']['credit']."</td>";
                         if(isset($published_courses_disable_not_to_published[$section_id]) && in_array($vc['Course']['id'],
                 $published_courses_disable_not_to_published[$section_id])){
                          //find the publish course id
                          foreach ($published_courses_disable_not_to_published[$section_id] as
                           $p_id=>$p_course_id) {
                               if($p_course_id == $vc['Course']['id']){
                                   $published_id=$p_id;
                                    break 1;
                                }
                          }
                       
                 
	                      }
                         echo "</tr>";
                        $count++;
                     } 
                     if(isset($published_courses_disable_not_to_published[$section_id]) && count($published_courses_disable_not_to_published[$section_id])>0){
                            echo "<tr><td colspan=5>** Those courses with asterik is a course already published for the given criteria.</td></tr>";
                      }
                     echo "</tbody></table>";
                     
                 } else {
                   $display_button++;
                 
                 }
             }
             
            ?>
            
              <table>
            <tr>
               <?php if ($display_button!=$section_count) { ?>
                <td style='padding:0'> <?php 
                  echo $this->Form->submit('Publish Selected',array('name'=>'publishselected','div'=>'false'));?></td>
                    <?php 
                    if(isset($published_courses_disable_not_to_published[$section_id]) && count($published_courses_disable_not_to_published[$section_id])>0){
                          //echo '<td>'.$this->Form->submit('Delete published.',array('name'=>'deletepublished','div'=>'false')).'</td>';
                          
                      }
                      //check if student is registred and show drop button 
                      if (true) {
                        
                         //  echo '<td>'.$this->Form->submit('Drop published.',array('name'=>'deletepublished','div'=>'false')).'</td>';
                      }
                      
                      ?>
                  <td style='padding:0'> <?php 
                  echo $this->Form->submit('Publish Selected as Add',array('name'=>'publishselectedadd','div'=>'false'));?>
                  
                  </td>
              <?php } else {
                    echo "<div class='smallheading'>It seems there is no courses in selected curriculum. You need to define courses
                    under the curriculum before publishing it. </div>";  
               } 
              ?>
            </tr>
           
           </table>
           <?php 
          if (!empty($taken_courses_allow_to_publishe_it) && 
          count($taken_courses_allow_to_publishe_it)>0) {
           echo "<div class='smallheading'>Already taken coures of the selected section, you can check it the already taken 
           courses to allow students to register for the courses again. This happens when all students
           fail the course or not able to follow the course </div>";
            foreach($taken_courses_allow_to_publishe_it as $section_id=>$coursss) {
          
           if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=7><?php echo "Section: ".$selected_section[$section_id]; ?></td></tr>
                    <tr>
                    <?php 
                    echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Lecture hour </th>";
                    echo "<th style='padding:0'> Tutorial hour </th>"; 
                    echo "<th style='padding:0'> Credit </th></tr>";
                   
                    $count=1;
                    foreach ($coursss as $kc=>$vc) {
                        echo "<tr>";
                        
                         echo '<td>'.$form->checkbox('Course.'.$section_id.'.'.$vc['Course']['id']) . '</td>';
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         echo "<td>".$vc['Course']['credit']."</td>";
                         
                         echo "</tr>";
                        $count++;
                     } 
                    
                     echo "</tbody></table>";
                     
                 } 
             }
             ?>
              
             <?php 
           }
       }  
      
    }
  echo $this->Form->end();
?>
