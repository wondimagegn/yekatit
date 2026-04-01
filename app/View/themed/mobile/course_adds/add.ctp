<?php 

echo $this->Form->create('CourseAdd');

?>

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

<script type='text/javascript'>  
//Sub cat combo
var student_id = null ;
<?php 
  if(!empty($student_section_exam_status)) {
  ?>
    student_id = "<?php echo $student_section_exam_status['StudentBasicInfo']['id'];?>";
  <?php
  }

?>
function updateDepartmentCollege(id) {
           
            //serialize form data
            var formData = $("#college_id_"+id).val();
			$("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled', true);
			$("#section_id_"+id).attr('disabled', true);
			$("#add_button_disable").attr('disabled',true);
			//get form action
            var formUrl = '/departments/get_department_combo/'+formData+'/'+1;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#department_id_"+id).attr('disabled', false);
						$("#college_id_"+id).attr('disabled', false);
						$("#department_id_"+id).empty();
						$("#department_id_"+id).append(data);
							//student lists
							var subCat = $("#department_id_"+id).val();
							$("#section_id_"+id).attr('disabled', true);	
							
							//get form action
							var formUrl = '/sections/get_sections_by_dept/'+subCat;
							$.ajax({
								type: 'get',
								url: formUrl,
								data: subCat,
								success: function(data,textStatus,xhr){
										$("#section_id_"+id).attr('disabled', false);
										
										$("#section_id_"+id).empty();
										$("#section_id_"+id).append(data);
										
								},
								error: function(xhr,textStatus,error){
										alert(textStatus);
								}
							});
							
					},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
      
}

//Sub cat combo
function updateSection(id) {
           
            //serialize form data
            var formData = $("#department_id_"+id).val();
			$("#section_id_"+id).attr('disabled', true);
			$("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled',true);	
			$("#add_button_disable").attr('disabled',true);
					//get form action
			var formUrl = '/sections/get_sections_by_dept/'+formData;
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data,textStatus,xhr){
						$("#section_id_"+id).attr('disabled', false);
						$("#college_id_"+id).attr('disabled', false);
			            $("#department_id_"+id).attr('disabled',false);
			            $("#add_button_disable").attr('disabled',false);	
						$("#section_id_"+id).empty();
						$("#section_id_"+id).append(data);
						
				},
				error: function(xhr,textStatus,error){
						alert(textStatus);
				}
			});
			return false;
 }

  function updatePublishedCourse (id) {
           //serialize form data
            var formData = $("#section_id_"+id).val();
            if ($("#AcademicYear").val() && $("#Semester").val() ) {
                
                var academic_year = $("#AcademicYear").val().replace("/", "-");
                var semester = $("#Semester").val();
                var academicYearandSemester = academic_year + "," + semester;
                alert(academicYearandSemester);
            } else { 
                var academicYearandSemester = "";
            }

         

			$("#college_id_"+id).attr('disabled', true);
			$("#section_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled', true);
            $("#add_button_disable").attr('disabled',true);			
			//get form action
            var formUrl = '/courseAdds/get_published_add_courses/'+formData+'/'+student_id+'/'+academicYearandSemester;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#section_id_"+id).attr('disabled', false);
						$("#department_id_"+id).attr('disabled', false);
						$("#college_id_"+id).attr('disabled', false);
						$("#add_button_disable").attr('disabled',false);
						$("#get_published_add_courses_id_"+id).empty();
						$("#get_published_add_courses_id_"+id).append(data);
				},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
 }
</script>

<div class="courseAdds form">
<p class="fs16">
                    <strong> Important Note: </strong> 
                    This tool will help you to perform course add on behalf of  students 
                  
                      
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (!empty($hide_search)) {
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
			echo $this->Form->input('Search.studentnumber',array('label'=>'Student Number')); 
			
			?>
	</td><td>
	
	<?php 
	        if (!empty($departments)) {
	        echo $this->Form->input('Search.department_id',array('label'=>'Department',
	        'style'=>'width:200px')); 
	        } else if (!empty($colleges)) {
	              echo $this->Form->input('Search.college_id',array('label'=>'College','style'=>'width:200px'));    
	              
	        }
	       
	
	
	?></td>
	<tr>
	<td>
	  <?php 
	     echo $this->Form->input('Search.semester',array('label'=>'Semester','id'=>"Semester",
	              'options'=>array('I'=>'I','II'=>'II',
            'III'=>'III')));
	  ?>
	</td>
	<td>
	    <?php 
	       echo $this->Form->input('Search.academicyear',array(
            'label' => 'Academic Year','type'=>'select','id'=>"AcademicYear",'options'=>$acyear_array_data,
           
                'selected'=>isset($this->data['Search']['academicyear'])?$this->data['Search']['academicyear']:
                (isset($defaultacademicyear) ? $defaultacademicyear:'' )
            
            )
            
            );
            ?>
	</td>
	</tr>
	</tr>
		
	
	<tr><td colspan=2><?php echo $this->Form->Submit('Continue',array('div'=>false,'name'=>'continue')); ?> </td>	
</tr>
</tbody>
</table>
</div>
<?php
/*
 if (isset($student_section)) {
    ?>
    <table>
    <tr><td><table><tr><td class="font">Name:&nbsp;&nbsp;&nbsp;<?php echo $student_section['Student']['full_name']?></td></tr>
    <tr><td class="font">Student Number:&nbsp;&nbsp;&nbsp;<?php echo $student_section['Student']['studentnumber']?></td></tr>
   <tr><td class="font">Year Level:&nbsp;&nbsp;&nbsp;<?php echo $year_level_id;?></td></tr>
   </table></td><td>
   <?php 
       echo $this->Form->hidden('CourseRegistration.student_id',array('value'=>$student_section['Student']['id']));
       if (!empty($student_section['StudentExamStatus'])) {
            echo "<table>";
            foreach ($student_section['StudentExamStatus'] as $k=>$v) {
            ?>
           <tr><td class="font">Semester:&nbsp;&nbsp;&nbsp;<?php echo $v['semester']?></td></tr>
            <tr><td class="font">Academic Year:&nbsp;&nbsp;&nbsp;<?php echo $v['academic_year']?></td></tr>
            <tr><td class="font">Year Level:&nbsp;&nbsp;&nbsp;<?php echo $year_level_id;?></td></tr>
             <tr><td class="font">SGPA:&nbsp;&nbsp;&nbsp;<?php echo $v['sgpa']?></td></tr>
             <?php 
                if (!empty($v['sgpa'])) {
                ?>
                <tr><td class="font">CGPA:&nbsp;&nbsp;&nbsp;<?php echo $v['cgpa']?></td></tr>
                <?php 
                
                }
                if (!empty($v['AcademicStatus'])) {
                     echo '<tr><td class="font">Academic Status:&nbsp;&nbsp;&nbsp'.$v['AcademicStatus']['name'].'</td></tr>';
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
  */
  
  ?>  
    <?php 
    if (isset($student_section_exam_status) && !empty($student_section_exam_status)) {   
        	echo $this->element('student_basic');
        	//echo $this->Form->input('CourseRegistration.student_id',array('value'=>$student_section_exam_status['Student']['id']));
 echo "<table><tr>";
 echo "<td>";
 $button_visible=0;   
 if ($role_id  != ROLE_REGISTRAR) {
    if (!empty($ownDepartmentPublishedForAdd)) {
            
      echo "<div class='smallheading'> List of courses published as an add to your section.</div>";
            echo "<table id='fieldsForm'><tbody>";
           
            echo "<tr><th style='padding:0'> S.No </th>";
             echo "<th style='padding:0'> Select </th>";
            echo "<th style='padding:0'> Course Title </th>";
            echo "<th style='padding:0'> Course Code </th>";
            echo "<th style='padding:0'> Lecture hour </th>";
            echo "<th style='padding:0'> Tutorial hour </th>"; 
            echo "<th style='padding:0'> Credit </th></tr>";
            $count=0;
            
            foreach ($ownDepartmentPublishedForAdd as $pk=>$pv) {
                 if ($pv['already_added'] == 0) {
                     $button_visible++;
                     echo $this->Form->hidden('CourseAdd.'.$count.'.published_course_id',array('value'=>$pv['PublishedCourse']['id']));
                     echo $this->Form->hidden('CourseAdd.'.$count.'.academic_year',array('value'=>$pv['PublishedCourse']['academic_year']));
                     echo $this->Form->hidden('CourseAdd.'.$count.'.semester',
                     array('value'=>$pv['PublishedCourse']['semester']));
                     
                     echo $this->Form->hidden('CourseAdd.'.$count.'.student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));//$student_section['Student']['studentnumber'];
                     echo $this->Form->hidden('CourseAdd.'.$count.'.year_level_id',array('value'=>$pv['PublishedCourse']['year_level_id']));
                     
                     echo "<tr><td>".++$count."</td><td>".$form->checkbox('CourseAdd.add.' . $pv['PublishedCourse']['id'])."</td><td>".$pv['Course']['course_title']."</td>";
                 } else {
                       echo "<tr><td>".++$count."</td><td>***</td><td>".$pv['Course']['course_title']."</td>";
                 
                 }
                 echo "<td>".$pv['Course']['course_code']."</td>";
                 echo "<td>".$pv['Course']['lecture_hours']."</td>";
                 echo "<td>".$pv['Course']['tutorial_hours']."</td>";
                 echo "<td>".$pv['Course']['credit']."</td></tr>";
            }
          //}
            echo "<tr><td colspan=7>*** are courses which is already added.</td></tr>";
            echo  "</table>";
    }
 }
 echo "</td>";
 echo "<td width='70%'>";
 echo '<table>';
     echo $this->Form->hidden('Student.id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
     echo '<tr><td>'.$this->Form->input('Student.college_id',array('label'=>'Select College You want to Add Course.','empty'=>'--select college--','id'=>'college_id_1',
     'options'=>$collegess,
     'onchange'=>'updateDepartmentCollege(1)')).'</td></tr>'; 
     echo '<tr><td>'.$this->Form->input('Student.department_id',array('id'=>'department_id_1',
     'onchange'=>'updateSection(1)')).'</td></tr>';
     echo '<tr><td>'.$this->Form->input('Student.section_id',array('id'=>'section_id_1',
     'onchange'=>'updatePublishedCourse(1)')).'</td></tr></table>';
     
     echo '<div id="get_published_add_courses_id_1"></div>';
     echo "</td>";
     echo "</tr>";
 echo "</table>";
 echo $this->Form->submit('Add Selected',array('id'=>'add_button_disable','div'=>false,'name'=>'add'));
 echo '</td></tr></table>';


}
       if (isset($coursesAdd) && !empty($coursesAdd)) {
          
         //  debug($student_section);
            echo "<table id='fieldsForm'><tbody>";
            
            ?>
         
            
            <?php 
            
            echo "<tr><th style='padding:0'> S.No </th>";
             echo "<th style='padding:0'> Select </th>";
            echo "<th style='padding:0'> Course Title </th>";
            echo "<th style='padding:0'> Course Code </th>";
            echo "<th style='padding:0'> Lecture hour </th>";
            echo "<th style='padding:0'> Tutorial hour </th>"; 
            echo "<th style='padding:0'> Credit </th></tr>";
            $count=0;
           
            foreach ($coursesAdd as $pk=>$pv) {
               
                //echo $this->Form->hidden('CourseRegistration.'.$count.'.id',array('value'=>$pv['id'])); 
                echo $this->Form->hidden('CourseRegistration.'.$count.'.published_course_id',array('value'=>$pv['PublishedCourse']['id']));
                //echo $this->Form->hidden('CourseRegistration.'.$count.'.course_id',array('value'=>$pv['PublishedCourse']['course_id']));
                 echo $this->Form->hidden('CourseRegistration.'.$count.'.academic_year',array('value'=>$pv['PublishedCourse']['academic_year']));
                // echo $this->Form->hidden('CourseRegistration.'.$count.'.section_id',array('value'=>$pv['section_id']));
                 echo $this->Form->hidden('CourseRegistration.'.$count.'.semester',
                 array('value'=>$pv['PublishedCourse']['semester']));
                 echo $this->Form->hidden('CourseRegistration.'.$count.'.student_id',array('value'=>$student_section['Student']['id']));
                 
                  echo $this->Form->hidden('CourseRegistration.'.$count.'.year_level_id',array('value'=>$pv['PublishedCourse']['year_level_id']));
                 
                // echo "<td>".$form->checkbox('CourseRegistration.drop.' . $pv['id'])."</td>"; 
                //debug($pv);
                 echo "<tr><td>".++$count."</td><td>".$form->checkbox('CourseRegistration.add.' . $pv['PublishedCourse']['id'])."</td><td>".$pv['Course']['course_title']."</td>";
                 echo "<td>".$pv['Course']['course_code']."</td>";
                 echo "<td>".$pv['Course']['lecture_hours']."</td>";
                 echo "<td>".$pv['Course']['tutorial_hours']."</td>";
                 echo "<td>".$pv['Course']['credit']."</td></tr>";
            }
          //}
            echo "<tr><td colspan=7>".$this->Form->submit('Add Selected',
            array('div'=>false,'name'=>'add'))."</td></tr>";
            echo  "</table>";
    }

 //debug($student_lists);

 if (!empty($student_lists) && !isset($no_display)) {
 // debug($students);
  ?>
  <table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo ('No.');?></th>
			<th><?php echo ('Student Number');?></th>
			
			<th><?php echo ('Full Name');?></th>
			<th><?php echo ('Department');?></th>
			<th><?php echo ('Program');?></th>
			<th><?php echo ('Program Type');?></th>
		
			
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count=1;
	
	foreach ($student_lists as $student):
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
			<?php echo $this->Html->link(__('Add Course', true), array('action' => 'add', $student['Student']['id'])); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
<?php 
}
?>
 </div>
