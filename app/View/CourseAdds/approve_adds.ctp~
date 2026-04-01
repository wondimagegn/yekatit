<?php echo $this->Form->create('CourseAdd');?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<?php 

  if(!empty($coursesss)) {
  
                ?>
        <div class="fs16">List of students  submitted add request for approval.</div>
           <?php 
           $count=0;
           foreach ($coursesss as $department_name=>$program) {               // department 
                echo "<div class='fs16'>Department: ".$department_name.'</div>'; 
             foreach ($program as $program_name=>$programType) { 
                echo "<div class='fs16'> Program: ".$program_name.'</div>';            //program 
              foreach ($programType as $program_type_name =>$sections ) {          // program Type 
                   
           ?>
                 <?php echo  "<div class='fs16'>Program Type: ".$program_type_name.'</div>'; ?>               
                    
       
        <?php 
           $display_button=0;
           $section_count=0;
          
           foreach($sections as 
           $section_id=>$coursss) {
           $section_count++;
           if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=12><?php echo "Section: ".$section_id; ?></td></tr>
                   
                    <tr><th colspan=12><?php echo "Select the course you want to accept or reject add request."; ?></td></tr>
                    <tr>
                    <?php 
                   // echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                    echo "<th style='padding:0'> Full Name </th>";
                    echo "<th style='padding:0'> Semester </th>";
                    echo "<th style='padding:0'> ACY </th>";
                    echo "<th style='padding:0'> Current Load </th>";
                    
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Course Credit </th>";
                    echo "<th style='padding:0'> L T L</th>";
                      if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE) {
                    echo "<th style='padding:0'> Accept/Reject Request</th>";
                    //$options=array('1'=>'Accept','0'=>'Reject');$attributes=array('legend'=>false);echo $this->Form->radio('gender',$options,$attributes);
                    $options=array('1'=>'Accept','0'=>'Reject');
                    $attributes=array('legend'=>false,'separator'=>"<br/>");
                    
                    echo "<th style='padding:0'>Reason </th>";
                    }
                    
                    if (
                    $role_id == ROLE_REGISTRAR || 
ROLE_REGISTRAR==$this->Session->read('Auth.User')['Role']['parent_id']) {
                       $options=array('1'=>'Accept','0'=>'Reject');
                    $attributes=array('legend'=>false,'separator'=>"<br/>");
                     echo "<th style='padding:0'> Confirm Add Request</th>";
                    
                    }
                    echo "</tr>";
                   
            foreach ($coursss as $kc=>$vc) {
                    echo "<tr>";
					echo $this->Form->hidden('CourseAdd.'.$count.'.id',array('label'=>false,
					'size'=>4,'div'=>false,
					'value'=>$vc['CourseAdd']['id']));
					    
                         echo "<td>".($count+1)."</td>";
                        
                            echo "<td>";
                         
                        echo $this->Html->link(
    $vc['Student']['full_name'],
    '#',
   array('class'=>'jsview','data-animation'=>"fade",
'data-reveal-id'=>'myModal','data-reveal-ajax'=>"/students/get_modal_box/".$vc['Student']['id'])
);
                         
                         
                         echo "</td>";
                         echo "<td>".$vc['PublishedCourse']['semester']."</td>";
                         echo "<td>".$vc['PublishedCourse']['academic_year']."</td>"; 
                         echo "<td>".$vc['Student']['max_load']."</td>";
                         echo "<td>".$vc['PublishedCourse']['Course']['course_title']."</td>";
                         echo "<td>".$vc['PublishedCourse']['Course']['course_code']."</td>";
                       
                         echo "<td>".$vc['PublishedCourse']['Course']['credit']."</td>";
                         echo "<td>".$vc['PublishedCourse']['Course']['course_detail_hours']."</td>";  
                    if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE ) {
                           echo "<td>".$this->Form->radio('CourseAdd.'.$count.'.department_approval',$options,$attributes)."</td>";
                         echo "<td>".$this->Form->input('CourseAdd.'.$count.'.reason',array(
		            'value'=>isset($this->request->data['CourseAdd'][$count]['reason'])?
					$this->request->data['CourseAdd'][$count]['reason']:'','label'=>false,'size'=>4,'div'=>false))."</td>";
					
					} else if(
					$role_id == ROLE_REGISTRAR) {
					    echo "<td>".
					    $this->Form->radio('CourseAdd.'.$count.'.registrar_confirmation',$options,$attributes)."</td>";
					    debug($options);
					}
					     
                         echo "</tr>";
                        debug($count);  
                        $count++;
                       
                     } 
                    
                     echo "</tbody></table>";
                     
                 } else {
                   $display_button++;
                 
                 }
                 //$count++;
             }
             
            ?>
            
              <table>
            <tr>
               <?php if ($display_button!=$section_count) { ?>
                <td style='padding:0'> <?php 
                 if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE) {
                          echo $this->Form->submit('Approve/Reject Add',array('name'=>'approverejectadd','div'=>'false'));
                  }  else if ($role_id ==  ROLE_REGISTRAR) {
                  echo $this->Form->submit('Confirm/Deny Add',array('name'=>'approverejectadd','div'=>'false'));
                  }
                  ?>
                 </td>
              <?php } ?>
            </tr>
           
           </table>
           
              
             <?php 
             
              } //programType
             } //program 
           } //department 
        
        }
        
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
