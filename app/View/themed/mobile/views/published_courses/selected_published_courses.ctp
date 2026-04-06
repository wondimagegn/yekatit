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
                   <tr><th colspan=9><?php echo "Section: ".$selected_section[$section_id]; ?></td></tr>
                    <tr><th colspan=9><?php echo "Select the course you want to publish."; ?></td></tr>
                    <tr>
                    <?php 
                    echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                     echo "<th style='padding:0'> Year </th>";
                    echo "<th style='padding:0'> Semester </th>";
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Prerequisite </th>";
                   /* echo "<th style='padding:0'> Lecture hour </th>";
                    echo "<th style='padding:0'> Tutorial hour </th>"; 
                    */
                    echo "<th style='padding:0'> Credit </th>";
                     echo "<th style='padding:0'> L T L </th>";
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
                         echo "<td>".$count.'</td>';
                         echo '<td>'.$vc['YearLevel']['name'].'</td>';
                         echo '<td>'.$vc['Course']['semester'].'</td>';
                         echo '<td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         /*echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         */
                         echo "<td>";
                         
                          if (!empty($vc['Prerequisite'])) {
                                     foreach ($vc['Prerequisite'] as $ppindex=>$pvlll) {
                                            echo $pvlll['pre_code'];
                                     }
                          } else {
                              echo 'none';
                          }
                          //$vc['Prerequisite']['prerequisite_course_id']
                         
                         
                         echo "</td><td>".$vc['Course']['credit']."</td>";
                         
                         echo "<td>".$vc['Course']['course_detail_hours']."</td>";
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
                        /*  echo "<td id=".$count.">".$this->Html->link(__('Delete', true),
                           array('action' => 'delete',$published_id),array('class'=>'confirm_delete')).'</td>'; 
                         */
                         
                         /*echo '<td id='.$count.'>'.$this->Js->link(__('Delete', true),
			'/publishedCourses/delete/'.$published_id,array('update'=>'#'.$count,'evalScripts'=>true)).'</td>';
			'</td>';*/
                          // simple HTML link with a class of 'confirm_delete'
                        //echo $html->link('Delete',array('action'=>'delete',$item['Item']['id']),array('class'=>'confirm_delete'));
                 
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
                  
                  <td style='padding:0'> <?php 
                  echo $this->Form->submit('Publish Selected as Add',array('name'=>'publishselectedasadd','div'=>'false'));?></td>
              <?php } ?>
            </tr>
           
           </table>
           <?php 
          if (!empty($taken_courses_allow_to_publishe_it) && 
          count($taken_courses_allow_to_publishe_it)>0) {
          
            foreach($taken_courses_allow_to_publishe_it as $section_id=>$coursss) {
          
           if (!empty($coursss)) {
                   echo "<div class='info-box info-message'><span></span>Already taken courses of the selected section. You can repulish courses to allow students to register for the courses again. This happens when all students fail the course or not able to follow the courses. </div>";
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=7><?php echo "Section: ".$selected_section[$section_id]; ?></td></tr>
                    <tr>
                    <?php 
                    
                     echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Prerequisite </th>";
                   /* echo "<th style='padding:0'> Lecture hour </th>";
                    echo "<th style='padding:0'> Tutorial hour </th>"; 
                    */
                    echo "<th style='padding:0'> Credit </th>";
                     echo "<th style='padding:0'> L T L </th>";
                     
                   
                   
                    $count=1;
                    foreach ($coursss as $kc=>$vc) {
                        echo "<tr>";
                        
                         echo '<td>'.$form->checkbox('Course.'.$section_id.'.'.$vc['Course']['id']) . '</td>';
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>";
                         if (!empty($vc['Prerequisite'])) {
                                     foreach ($vc['Prerequisite'] as $ppindex=>$pvlll) {
                                        if (isset($pvlll['pre_code']) && 
                                        !empty($pvlll['pre_code'])) {
                                            echo $pvlll['pre_code'];
                                          }
                                     }
                          } else {
                              echo 'none';
                          }
                         
                         echo "</td><td>".$vc['Course']['credit']."</td>";
                         echo "<td>".$vc['Course']['course_detail_hours']."</td>";
                         
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
