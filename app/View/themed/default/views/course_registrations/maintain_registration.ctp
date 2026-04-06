<?php echo $this->Form->create('CourseRegistration');?>
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

</script>

<?php // if (!isset($hide_search)) { ?>
<div class="smallheading">
<?php 
/*
if(isset($latest_semester_academic_year) && !empty($latest_semester_academic_year)) {
    echo "Course registration maintaince  for ".$latest_semester_academic_year['academic_year']." academic year ";
}
*/
?>
</div>

<?php 
   //if (!isset($turn_off_search)) {
?>
<p class="fs16">
                    <strong> Important Note: </strong> 
                    This tool will help you to register students 
                    for selected academic year and semester. 
                    
                    
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($turn_off_search)) {
		echo $html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (isset($hide_search) ? 'none' : 'display'); ?>">

<table cellpadding="0" cellspacing="0"><tbody>
	
	<tr><td>
	
	
	<?php 
			echo $this->Form->input('Student.studentnumber',array('label'=>'Student Number')); 
			
			?>
	</td><td>
	
	<?php 
	        if (!empty($departments)) {
	        echo $this->Form->input('Student.department_id',array('label'=>'Department',
	        'style'=>'width:200px')); 
	        } else if (!empty($colleges)) {
	              echo $this->Form->input('Student.college_id',array('label'=>'College','style'=>'width:200px'));    
	              
	        }
	       
	
	
	?>
	
	</td>
	<tr>
	<td>
	  <?php 
	     echo $this->Form->input('Student.semester',array('label'=>'Semester',
	              'options'=>array('I'=>'I','II'=>'II',
            'III'=>'III')));
	  ?>
	</td>
	<td>
	    <?php 
	       echo $this->Form->input('Student.academicyear',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
           
                'selected'=>isset($this->data['Student']['academicyear'])?$this->data['Student']['academicyear']:
                (isset($defaultacademicyear) ? $defaultacademicyear:'' )
            
            )
            
            );
            ?>
	</td>
	</tr>
	</tr>
		<tr><td>
	
	
	<?php 
			echo $this->Form->input('Student.program_id',array('label'=>'Program',
			'style'=>'width:100px')); 
			
			?>
	</td><td><?php 
	       
	        
	        echo $this->Form->input('Student.program_type_id',array('label'=>'Program Type',
	        'empty'=>' ','style'=>'width:100px')); 
	        
	
	?></td></tr>
	<!-- <tr><td><?php echo $this->Form->input('Student.program_id',array('label'=>'Program','empty'=>'--select program--')); ?></td><td><?php echo $this->Form->input('Student.program_type_id',array('label'=>'Program Type','empty'=>'--select program type--')); ?></td></tr>
	<tr><td>
	<?php echo $this->Form->input('Student.year_level_id',array('label'=>'Year Level','empty'=>'--select year level--')); ?>
	</td></tr> -->
	<tr><td colspan=2><?php echo $this->Form->Submit('Continue',array('div'=>false,'name'=>'continue')); ?> </td>	
</tr>
</tbody>
</table>
</div>
<?php // } ?>

	
<?php
/*
 if (isset($student_section)) {
    ?>
    <table>
    <tr><td><table><tr><td class="font">Name:&nbsp;&nbsp;&nbsp;<?php echo $student_section['Student']['full_name']?></td></tr>
    <tr><td class="font">Student Number:&nbsp;&nbsp;&nbsp;<?php echo $student_section['Student']['studentnumber']?></td></tr>
   <tr><td class="font">Year Level:&nbsp;&nbsp;&nbsp;<?php echo $year_level_name;?></td></tr>
   </table></td><td>
   <?php 
       if (!empty($student_section['StudentExamStatus'])) {
            echo "<table>";
            foreach ($student_section['StudentExamStatus'] as $k=>$v) {
            ?>
           <tr><td class="font">Semester:&nbsp;&nbsp;&nbsp;<?php echo $v['semester']?></td></tr>
            <tr><td class="font">Academic Year:&nbsp;&nbsp;&nbsp;<?php echo $v['academic_year']?></td></tr>
            <tr><td class="font">Year Level:&nbsp;&nbsp;&nbsp;<?php echo $year_level_name;?></td></tr>
             <tr><td class="font">SGPA:&nbsp;&nbsp;&nbsp;<?php echo $v['sgpa']?></td></tr>
             <?php 
                if (!empty($v['sgpa'])) {
                ?>
                <tr><td class="font">CGPA:&nbsp;&nbsp;&nbsp;<?php echo $v['cgpa']?></td></tr>
                <?php 
                
                }
                if (!empty($v['AcademicStatus'])) {
                     echo '<tr><td class="font">Academic Status:&nbsp;&nbsp;&nbsp;'.$v['AcademicStatus']['name'].'</td></tr>';
                }
             ?>
          
            <?php 
        }
        echo "</table>";
    }
   ?>
   </td></tr>
    </table>
    
    <?php 
      

 }
 */
 echo $this->element('student_basic');
 echo $this->element('registration/student_register');
 

if(isset($students) && !empty($students)) {
    foreach ($students as $pk => $pv) {
         if (!empty($pk)) {
            echo "<div class='smallheading'> Program:".$pk."</div>";
             foreach ($pv as $ptk=>$ptv) {                 
                         if (!empty($ptk)) {
                                 echo "<div class='fs16'> Program Type: ".$ptk."</div>";
                               
                              foreach ($ptv as $yk=>$yv) {
                                  if (!empty($yv)) {
                                     if ($yk == 0) {
                                     echo "<div class='fs16'> Year Level: Freshman</div>";
                                     } else {
                                       echo "<div class='fs16'> Year Level: ".$yearLevels[$yk]."</div>";
                                     }
                                     
                                     foreach ($yv as $section_name=>$section_value) {
                                      echo "<div class='fs16'> Section : ".$sections[$section_name]."</div>";
                                      echo "<table cellpadding=0 cellspacing=0>";
                                      ?>
	<tr>
			<th><?php echo ('No.');?></th>
			<th><?php echo ('Student Number');?></th>
			
			<th><?php echo ('Full Name');?></th>
			<th><?php echo ('Department');?></th>
			<th><?php echo ('Program');?></th>
			<th><?php echo ('Program Type');?></th>
		
			
			<th class="button-success"><?php // __('Actions');?>
			  	<?php 
			echo $this->Html->link(__('Register All', true), 
			array('action' => 'maintain_registration',0,$section_name)); 
			
			?>
			</th>
	</tr>
	<?php
	$i = 0;
	$count=1;
	foreach ($section_value as $student):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td><?php echo $student['Student']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $student['Student']['full_name']; ?>&nbsp;</td>
		
		<td>
			<?php echo $this->Html->link($student['Department']['name'], array('action' => 'view', $student['Department']['id'])); ?>
		</td> 
		<td>
			<?php echo $this->Html->link($student['Program']['name'], array('action' => 'view', $student['Program']['id'])); ?>
		</td> 
		
		<td>
			<?php echo $this->Html->link($student['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $student['ProgramType']['id'])); ?>
		</td>
	
		<td class="actions">
			<?php 
			echo $this->Html->link(__('Register', true), array('action' => 'maintain_registration', $student['Student']['id'])); 
			
			?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
  <?php                                     
                                    }
                                }
                            }
                      }//check program type
             } // end program type
        } // check program is not empty
  } // end of outer loop
}
?>
