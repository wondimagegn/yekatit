<?php echo $this->Form->create('CourseAdd');?>

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

/*if (!isset($hide_search) || true) { ?>
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
            
             echo '<tr><td>';
             if ($role_id == ROLE_DEPARTMENT) {
                echo $this->Form->input('Student.year_level_id',array('label'=>'Year Level'));
             
             }
             echo '</td>'; 
            echo '<td>'. $this->Form->input('Student.program_id',array('label'=>'Program')).'</td></tr>'; 
            echo '<tr><td>'.$this->Form->input('Student.program_type_id',array('label'=>'Program Type',
			'empty'=>"--Select Program Type--")).'</td><td>'.$this->Form->input('Student.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';   
            ?>
	<tr><td colspan=2><?php echo $this->Form->submit('Continue',array('name'=>'getaddsection','div'=>'false')); ?> </td>	
</tr></table>

<?php 

}
*/
?>
<div id="dialog-modal" title="Academic Profile "></div>
<?php 

  if(!empty($coursesss)) {
  
                ?>
        <div class="fs16">List of students  submitted add request for approval.</div>
           <?php 
          
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
           $count=0;
           foreach($sections as $section_id=>$coursss) {
           $section_count++;
           if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=12><?php echo "Section: ".$section_id; ?></td></tr>
                   
                    <tr><th colspan=12><?php echo "Select the course you want to accept or reject drop request."; ?></td></tr>
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
                    
                    if ($role_id == ROLE_REGISTRAR ) {
                       $options=array('1'=>'Accept','0'=>'Reject');
                    $attributes=array('legend'=>false,'separator'=>"<br/>");
                     echo "<th style='padding:0'> Confirm Add Request</th>";
                    
                    }
                    echo "</tr>";
                   
                    
                    foreach ($coursss as $kc=>$vc) {
                      
                        
                        echo "<tr>";
                       
					echo $this->Form->hidden('CourseAdd.'.$count.'.id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$vc['CourseAdd']['id']));
					    
                         echo "<td>".($count+1)."</td>";
                        
                            echo "<td>";
                         
                        
                        // echo $this->Html->link($vc['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile',$vc['Student']['id'])); 
                         echo $this->Js->link($vc['Student']['full_name'],array('controller'=>'students','action'=>'get_modal_box',$vc['Student']['id']),array('class'=>'jsview','update'=>'#dialog-modal'));
                         
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
		            'value'=>isset($this->data['CourseAdd'][$count]['reason'])?
					$this->data['CourseAdd'][$count]['reason']:'','label'=>false,'size'=>4,'div'=>false))."</td>";
					
					} else if ($role_id == ROLE_REGISTRAR) {
					    echo "<td>".$this->Form->radio('CourseAdd.'.$count.'.registrar_confirmation',$options,$attributes)."</td>";
					}
					     
                         echo "</tr>";
                         
                        $count++;
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
