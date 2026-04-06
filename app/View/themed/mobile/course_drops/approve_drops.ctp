<?php echo $this->Form->create('CourseDrop');?>

<script type='text/javascript'>
var image = new Image();
image.src = '/img/busy.gif';

$(document).ready(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$("#dialog-modal").dialog({
			heght: 500,
			width:700,
			autoOpen: false,
			closeOnEscape: true,
			modal: true

	});

	$(".jsview").click(function() {
				$('#dialog-modal').empty().html('<img src="'+image.src+'" class="displayed" />');
				$("#dialog-modal").dialog("open");

				return false;
	});		

});
</script>

<?php

/* if (!isset($hide_search)) { ?>
<!--- 
<table cellpadding="0" cellspacing="0">
<?php 
echo '<tr><td>'.$this->Form->input('Student.academic_year',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')).
            '</td>';
               if ($role_id == ROLE_REGISTRAR) {
                echo '<td>'.$this->Form->input('Student.department_id',array(
            'label' => 'Department',
            'empty'=>"--Select Department--")).'</td>';  
            }
          
            echo '</tr>';
            
          ?>
<tr> 
	<?php 
            
             echo '<tr><td>'. $this->Form->input('Student.year_level_id',array('label'=>'Year Level','empty'=>"--Select Year Level--")).'</td>'; 
            echo '<td>'. $this->Form->input('Student.program_id',array('label'=>'Program')).'</td></tr>'; 
            echo '<tr><td>'.$this->Form->input('Student.program_type_id',array('label'=>'Program Type',
			'empty'=>"--Select Program Type--")).'</td><td>'.$this->Form->input('Student.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';   
            ?>
	<tr><td colspan=2><?php echo $this->Form->submit('Continue',array('name'=>'getdroprequests','div'=>'false')); ?> </td>	
</tr></table>

<?php 
}
*/
 ?>
<div id="dialog-modal" title="Academic Profile "></div>
<?php 

if (!empty($coursesss)) {

    echo "<div class='smallheading'> List of course drop request required approval.</div>"; 
$count=0;
foreach ($coursesss as $department_name=>$program) {               // department 
                echo "<div class='fs16'>Department: ".$department_name.'</div>'; 
             foreach ($program as $program_name=>$programType) { 
                echo "<div class='fs16'> Program: ".$program_name.'</div>';            //program 
              foreach ($programType as $program_type_name =>$sections ) {          // program Type 
                   
           ?>
                 <?php echo  "<div class='fs16'>Program Type: ".$program_type_name.'</div>'; ?>               
                    
       
        <?php 
           
           foreach($sections as $section_id=>$courses) {

            echo  "<div class='fs16'>Section: ".$section_id.'</div>';              
                ?>

        <?php 
          
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                        
                    <tr><th colspan=12><?php
                    if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE ) {
                         echo "Select the course you want to accept or reject drop request."; 
                     } else if ($role_id == ROLE_REGISTRAR) {
                       echo "Select the  list of courses for repsective student which needs your  confirmation has been approved by department."; 
                     }  
                     ?>  
                     </td></tr>
                    <tr>
                    <?php 
                   // echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='width:3%'> S.N<u>o</u> </th>";
                    echo "<th> Full Name </th>";
                     echo "<th style='padding:0'> Semester </th>";
                    echo "<th style='padding:0'> ACY </th>";
                    echo "<th> Current Load </th>";
                    echo "<th> Course Title </th>";
                    echo "<th> Course Code </th>";
                    echo "<th> Course Credit </th>";
                    echo "<th> L T L</th>";
                      if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE ) {
                    echo "<th style='padding:0'> Accept/Reject Request</th>";
                    //$options=array('1'=>'Accept','0'=>'Reject');$attributes=array('legend'=>false);echo $this->Form->radio('gender',$options,$attributes);
                    $options=array('1'=>'Accept','0'=>'Reject');
                    $attributes=array('legend'=>false,'separator'=>"<br/>");
                    
                    echo "<th style='padding:0'>Reason </th>";
                    }
                     
                    if ($role_id == ROLE_REGISTRAR ) {
                       $options=array('1'=>'Confirm','0'=>'Deny');
                    $attributes=array('legend'=>false,'separator'=>"<br/>");
                     echo "<th style='padding:0'> Confirm Drop</th>";
                    
                    }
                    echo "</tr>";
                   
                    
                    foreach ($courses as $kc=>$vc) {
                        echo "<tr>";
                        
                         
                         echo $this->Form->hidden('CourseDrop.'.$count.'.id',array(
		            'value'=>$vc['CourseDrop']['id'],'label'=>false,'size'=>4,'div'=>false));
				
					    
                         echo "<td>".($count+1)."</td>";
                         echo "<td>";
                         
                        
                         //echo $this->Html->link($vc['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile',$vc['Student']['id'])); 
                      
			echo $this->Js->link($vc['Student']['full_name'],array('controller'=>'students','action'=>'get_modal_box',$vc['Student']['id']),array('class'=>'jsview','update'=>'#dialog-modal'));
			
                         echo "</td>";
                         echo "<td>".$vc['CourseRegistration']['PublishedCourse']['semester']."</td>";
                         echo "<td>".$vc['CourseRegistration']['PublishedCourse']['academic_year']."</td>";
                         echo "<td>".$vc['Student']['max_load']."</td>";
                         echo "<td>".$vc['CourseRegistration']['PublishedCourse']['Course']['course_title']."</td>";
                         echo "<td>".$vc['CourseRegistration']['PublishedCourse']['Course']['course_code']."</td>";
                       
                         echo "<td>".$vc['CourseRegistration']['PublishedCourse']['Course']['credit']."</td>";
                         echo "<td>".$vc['CourseRegistration']['PublishedCourse']['Course']['course_detail_hours']."</td>";  
                           if ($role_id == ROLE_REGISTRAR ) {
                             echo "<td>".$this->Form->radio('CourseDrop.'.$count.'.registrar_confirmation',$options,$attributes)."</td>";
                           }
                         if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE ) {
                           echo "<td>".$this->Form->radio('CourseDrop.'.$count.'.department_approval',$options,$attributes)."</td>";
                         echo "<td>".$this->Form->input('CourseDrop.'.$count.'.reason',array(
		            'value'=>isset($this->data['CourseDrop'][$count]['reason'])?
					$this->data['CourseDrop'][$count]['reason']:'','label'=>false,'size'=>4,'div'=>false))."</td>";
					
					}
                         echo "</tr>";
                        $count++;
                     } 
                    
                     echo "</tbody></table>";
                     
             }
             
            ?>
            
              <table>
            <tr>

                <td style='padding:0'> <?php 
                 if ($role_id == ROLE_REGISTRAR) {
                  echo $this->Form->submit('Confirm/Deny Request',array('name'=>'approverejectdrop','div'=>'false'));
                  } else if ($role_id == ROLE_DEPARTMENT || $role_id == ROLE_COLLEGE ) {
                     echo $this->Form->submit('Approve/Reject Drop',array('name'=>'approverejectdrop','div'=>'false'));
                  }
                  ?></td>

            </tr>
           
           </table>
           
              
             <?php 
       }
      }
    }
 }
?>
