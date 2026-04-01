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
<?php echo $this->Form->create('StudentStatusPattern');?>

<p class="fs16">
                    <strong> Important Note: </strong> 
                  
                     
                      This tool will help you to regenerate student academic status. 
                      It is important when the status generated was wrong. 
                    
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
            <tr> 
	        <?php 
            
                 echo '<tr><td>'. $this->Form->input('Student.studentnumber',array('label'=>'Student ID')).'</td>'; 
           
            ?>
	        </tr>
	        
	        <tr>
	            <td colspan=2>
	                <?php 
	                    echo $this->Form->submit('Continue',
	                    array('name'=>'regeneratestudentstatus','div'=>'false')); ?> 
	             </td>	
            </tr>
</table>

</div>
<?php 
 if(isset($hide_search) && $hide_search) {
   echo $this->element('student_basic');  
 }  
    if(isset($alreadyGeneratedStatus) && 
    !empty($alreadyGeneratedStatus)) {
      //  echo $this->element('student_basic');  
         echo "<table id='fieldsForm'><tbody>";
                 echo '<tr>';
                  
                    echo "<th> S.No </th>";
                    echo "<th> &nbsp;</th>";
                    echo "<th> Academic Year </th>";
                    echo "<th> Semester </th>";
                    echo "<th> Grade Point Sum </th>"; 
                    echo "<th> Credit Hour Sum </th>";
                    echo "<th> Major Grade Point Sum </th>"; 
                    echo "<th> Major Credit Hour Sum </th>";
                    echo "<th> SGPA</th>";
                    echo "<th> CGPA</th>";
                    echo "<th> MCGPA</th>";
                     echo "<th> Academic Status</th>";
                    echo "<th> Generated Date</th>";
                echo '</tr>';
                $counter=1;
                foreach ($alreadyGeneratedStatus as $value) {
                    echo '<tr>';
                         echo '<td>';
                           echo $counter; 
                         echo '</td>';
                         
                          echo '<td>';
                            echo $this->Form->hidden('StudentStatusPattern.'.
                            $value['StudentExamStatus']['id'].'.id',
                   array('value'=>$value['StudentExamStatus']['id']));
                   
                         echo '</td>';
                         
                          echo '<td>';
                            echo $value['StudentExamStatus']['academic_year'];
                         echo '</td>';
                           echo '<td>';
                            echo $value['StudentExamStatus']['semester'];
                         echo '</td>';
                          echo '<td>';
                            echo $value['StudentExamStatus']['grade_point_sum'];
                         echo '</td>';
                          echo '<td>';
                            echo $value['StudentExamStatus']['credit_hour_sum'];
                         echo '</td>';
                         
                           echo '<td>';
                            echo $value['StudentExamStatus']['m_grade_point_sum'];
                         echo '</td>';
                          echo '<td>';
                            echo $value['StudentExamStatus']['m_credit_hour_sum'];
                         echo '</td>';
                         
                           echo '<td>';
                            echo $value['StudentExamStatus']['sgpa'];
                         echo '</td>';
                         
                          echo '<td>';
                            echo $value['StudentExamStatus']['cgpa'];
                         echo '</td>';
                         
                         echo '<td>';
                            echo $value['StudentExamStatus']['mcgpa'];
                         echo '</td>';
                         
                          echo '<td>';
                            echo $value['AcademicStatus']['name'];
                         echo '</td>';
                         
                           echo '<td>';
                            echo $this->Format->humanize_date($value['StudentExamStatus']['created']);
                         echo '</td>';
                         
                    echo '</tr>';   
                    $counter++;       
                }
               
                   
            
         echo "</tbody></table>";
         
                    
    } 
     if(isset($hide_search) && $hide_search) {
        
        echo "<table id='fieldsForm'><tbody>";
        echo '<tr>';
                    echo '<td colspan="7">';
                    if (isset($student_section_exam_status['StudentBasicInfo']['id'])) {
                     echo $this->Form->hidden('Student.id',
                array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
                }
                        echo $this->Form->submit('Regenerate Status',array('name'=>'regenerate',
                              'div'=>'false'));
                    echo '</td>';
                echo '</tr>';   
        echo "</tbody></table>";
     }
?>

