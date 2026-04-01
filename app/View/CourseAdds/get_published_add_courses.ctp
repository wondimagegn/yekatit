<?php 
if (!empty($otherAdds)) {
   // echo $this->Form->create('CourseAdd');     
    echo "<div class='smallheading'> Select courses you want to add.</div>";
            echo "<table id='fieldsForm'><tbody>";
           
            echo "<tr><th style='padding:0'> S.No </th>";
             echo "<th style='padding:0'> Select </th>";
            echo "<th style='padding:0'> Course Title </th>";
            echo "<th style='padding:0'> Course Code </th>";
           
            echo "<th style='padding:0'> Credit </th></tr>";
            $count=0;
            $button_visible=0;
            foreach ($otherAdds as $pk=>$pv) {
                  if ($pv['already_added'] == 0) {
                     echo "<tr><td>".++$count."</td><td>".$this->Form->checkbox('CourseAdd.add.' . $pv['PublishedCourse']['id'])."</td><td>".$pv['Course']['course_title']."</td>";
                   $button_visible++;
                 } else {
                       if (isset($pv['prerequiste_failed']) && $pv['prerequiste_failed']==1 ) {
                          echo "<tr style='color:red'><td>".++$count."</td><td></td><td>".$pv['Course']['course_title']."</td>";
                       
                 		} else {
                 		   echo "<tr><td>".++$count."</td><td>***</td><td>".$pv['Course']['course_title']."</td>";
                 
                 		}
                  
                 }
                
                 
                 echo "<td>".$pv['Course']['course_code']."</td>";
                
                 echo "<td>".$pv['Course']['credit']."</td></tr>";
                 
            }
            echo '<tr><td colspan=6>
             	Note: <ol>
                    <li>*** Courses you have already registred or taken, and got pass grade,
                    not allowed to add it.
                    
                    </li>
                     <li> Red marked courses failed to fullfill prerequiste.
                    
                    </li>
               
                </ol>
                </tr>';
            echo  "</table>";
           if ($button_visible>0) {
                echo $this->Form->end('Add Selected');
           }
           
 }
 ?>
