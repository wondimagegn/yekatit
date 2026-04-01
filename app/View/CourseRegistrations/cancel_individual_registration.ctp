<?php ?>
<script type='text/javascript'>
function toggleViewFullId(id) {
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}
//Sub cat combo
</script>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php echo $this->Form->create('CourseRegistration');?>

<p class="fs16">
                    <strong> Important Note: </strong> 
                  
                     
                      This tool will help you to cancel/delete course registration. 
                      It is important when the course registration was wrong. Cancelation/Deletion 
                      is possible if and only  if  grade is not submitted for one or more 
                      courses of the semester. The student will not be visible to the 
        instructor if you cancel the registration.
                    
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (isset($organized_published_course_by_section) && 
	!empty($organized_published_course_by_section)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (isset($organized_published_course_by_section) ? 'none' : 'display'); ?>">


<table cellpadding="0" cellspacing="0">
<?php 
echo '<tr><td>'.$this->Form->input('Student.academic_year',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($this->request->data['Student']['academic_year'])
            ?$this->request->data['Student']['academic_year']:$defaultacademicyear)).
            '</td><td>'.$this->Form->input('Student.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';
            
          ?>
<tr> 
	<?php 
            
             echo '<tr><td>'. $this->Form->input('Student.studentnumber',array('label'=>'Student ID')).'</td>'; 
           
            ?>
	<tr><td colspan=2><?php echo $this->Form->submit('Continue',array('name'=>'getstudentregistration','class'=>'tiny radius button bg-blue','div'=>'false')); ?> </td>	
</tr></table>


</div>
<?php 
if(isset($organized_published_course_by_section) && !empty($organized_published_course_by_section)) {
  
    echo $this->element('student_basic'); 
   
           foreach($organized_published_course_by_section as $section_id=>$coursss) {
          
                if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                  ?>
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
                        
                         if($vc['grade_submitted']) {
                         echo '<td>**</td>';
                        
                        } else {
                               echo '<td>&nbsp;</td>';
                          
                        }
                         
                         
                       
                         
                         
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         echo "<td>".$vc['Course']['credit']."</td>";
                         
                         echo "</tr>";
                         echo "<tr><td colspan=7 id=cancel_".$count.">";
                         echo "</td></tr>";
                      
                        $count++;
                     } 
                    
                     echo "</tbody></table>";
                     
                 } 
          }
          
          if (!empty($course_registration_id_publish_ids)) {
                
                foreach ($course_registration_id_publish_ids as $key=>$value) {
                   echo $this->Form->hidden('CourseRegistration.'.$key.'.id',
                   array('value'=>$key));
                }
                
          }
               
    ?>
           <table>
                        <tr>
                           <?php 
                           
                           if (!$isGradeSubmittedToAnyCourse) { ?>
                            <td style='padding:0'> <?php 
                              echo $this->Form->submit('Cancel Registration',array('name'=>'canceregistration',
'class'=>'tiny radius button bg-blue',
                              'div'=>'false'));?></td>
                              
                             
                          <?php } ?>
                        </tr>
                        <tr>
                            <?php 
                           if ($isGradeSubmittedToAnyCourse) { ?>
                            <td style='padding:0'> ** Those courses are not allowed for cancellation since grade has been started to
                            be submitted for one or more courses so you need to use drop course module for those
                            course grade not submitted.</td>
                            
                             <?php } ?>
                        </tr>
           
            </table>
    <?php 
}
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
