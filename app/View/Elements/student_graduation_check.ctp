<?php 

 if (isset($students) && !empty($students)) {   
?>
    <table border=0>
            <tr><td class="font">Name:&nbsp;&nbsp;&nbsp;
            <?php 
              if (isset($students['Student']['full_name'])) {
                echo $students['Student']['full_name'];
                
              }
            ?>
            </td> <td rowspan="6">
              
              <table>
            <tr><td>Profile Picture</td></tr>
            <?php 
             
             if(isset($students['Attachment']) && !empty($students['Attachment'])){
                    foreach($students['Attachment'] as $ak=>$av){
                  
                      if(!empty($av['dirname']) && !empty($av['basename']) ){
                            if (file_exists($av['basename'])) {
                                 echo '<tr><td valign="top" align="right">'.$this->Media->embed($this->Media->file($av['dirname'].DS.$av['basename']),
                               array('width'=>'144')).'</td></tr>';
                            } else {
                                echo '<tr><td valign="top" align="right"><img src="/img/noimage.jpg" 
                    width="144" class="profile-picture"></td></tr>';
                            }


                             
                               
                        }
                            
                    }
                } else {
                    echo '<tr><td valign="top" align="right"><img src="/img/noimage.jpg" 
                    width="144" class="profile-picture"></td></tr>';
                }

                ?>
                 <tr>
                   
                   <td class="font">Graduated:&nbsp;&nbsp;&nbsp;
                     <?php 
                     if(isset($students['GraduateList']['id']) && !empty($students['GraduateList']['id'])){
                        echo 'Yes ('.$students['Curriculum']['english_degree_nomenclature'].')';
                     } else if (!isset($students['GraduateList']['id'])) {
                          echo 'No';
                     }

                     ?>
                   </td>
                 </tr></table>
            </td> </tr>
            <tr><td class="font">Student Number:&nbsp;&nbsp;&nbsp;
            <?php
                if (isset($students['Student']['studentnumber'])) { 
                    echo $students['Student']['studentnumber']; 
                   
                } 
            ?>
            </td></tr>
           <tr><td class="font">Faculty:&nbsp;&nbsp;&nbsp;
            <?php 
            
            echo $students['College']['name'];
            
            ?>
            </td></tr>


            
           <tr><td class="font">Department:&nbsp;&nbsp;&nbsp;
            <?php 
                if (isset($students['Department']['name'])
                && !empty($students['Department']['name'])) {
                   echo $students['Department']['name'];
                 } 
            ?>
            </td></tr>
             <tr><td class="font">Program:&nbsp;&nbsp;&nbsp;
            <?php 
                if (isset($students['Program']['name'])
                && !empty($students['Program']['name'])) {
                   echo $students['Program']['name'];
                 } 
            ?>
            </td></tr>
             <tr><td class="font">Program Type:&nbsp;&nbsp;&nbsp;
            <?php 
                if (isset($students['ProgramType']['name'])
                && !empty($students['ProgramType']['name'])) {
                   echo $students['ProgramType']['name'];
                 } 
            ?>
            </td></tr>
        
       </table>
 <?php 
 
 }
 
?> 	
