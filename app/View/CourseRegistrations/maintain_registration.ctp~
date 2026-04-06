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
<script>
function updateCourseListOnChangeofOtherField() {
        
	//AcademicYear Semester ProgramTypeId SectionId DepartmentId CollegeId ProgramId
            //serialize form data
			var formData='';
			var department_id=$("#DepartmentId").val();
			var college_id= $("#CollegeId").val();
			var academic_year= $("#AcademicYear").val().replace("/", "-");
			var program_id=$("#ProgramId").val();
			var program_type_id=$("#ProgramTypeId").val();
           
            if(typeof department_id!="undefined" && typeof academic_year!="undefined" 
&&  typeof program_id !="undefined" && 
program_type_id !="undefined") {
            
            formData = department_id+'~'+academic_year+'~'+program_id+'~'+program_type_id+'~'+'d';
   
		    } else if(typeof college_id!="undefined" && typeof academic_year!="undefined" 
&& typeof program_id !="undefined" && 
program_type_id !="undefined") {
                formData = college_id+'~'+academic_year+'~'+program_id+'~'+program_type_id+'~'+'c';
		   } else {
              return false;
		    }
          
            $("#SectionId").attr('disabled', true);
			$("#Search").attr('disabled',true);
			//get form action
            var formUrl = '/courseRegistrations/get_section_combo/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						
				        $("#AcadamicYear").attr('disabled', false);
						$("#Semester").attr('disabled', false);
						$("#Program").attr('disabled',false);
						$("#ProgramType").attr('disabled',false);
					    $("#department_id").attr('disabled', false);
						$("#college_id").attr('disabled', false);
                        $("#SectionId").attr('disabled', false);
						$("#SectionId").empty();
					    $("#SectionId").append(data);
                    
					},
                error: function(xhr,textStatus,error){
                        //alert(textStatus);
                }
			});
		       $("#Search").attr('disabled',false);
                      

						
			return false;
		
 }

</script>

<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
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
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
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
	        echo $this->Form->input('Student.department_id',array('label'=>'Department','id'=>'DepartmentId',
'onchange'=>'updateCourseListOnChangeofOtherField()')); 
	        } else if (!empty($colleges)) {
	              echo $this->Form->input('Student.college_id',array('label'=>'College'));    
	              
	        }
	?>
	
	</td>
	<tr>
	<td>
	  <?php 
	     echo $this->Form->input('Student.semester',array('label'=>'Semester',
	     'id'=>'Semester',
'onchange'=>'updateCourseListOnChangeofOtherField()',
	              'options'=>array('I'=>'I','II'=>'II',
            'III'=>'III')));
	  ?>
	</td>
	<td>
	    <?php 
	       echo $this->Form->input('Student.academicyear',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
                'id'=>'AcademicYear',
'onchange'=>'updateCourseListOnChangeofOtherField()',
                'selected'=>isset($this->request->data['Student']['academicyear'])?$this->request->data['Student']['academicyear']:
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
			'id'=>'ProgramId',
'onchange'=>'updateCourseListOnChangeofOtherField()')); 
			
			?>
	</td><td><?php 
	       
	        
	        echo $this->Form->input('Student.program_type_id',array('label'=>'Program Type','id'=>'ProgramTypeId',
'onchange'=>'updateCourseListOnChangeofOtherField()')); 
	        
	
	?></td></tr>

  <tr>
	  <td>
		<?php 
				echo $this->Form->input('Student.year_level_id',array('label'=>'Year Level'));
				?>
		</td>
		<td>
			<?php 
			echo $this->Form->input('Student.section_id',
array('id'=>'SectionId'));
			?>
		</td>
     </tr>


	<tr><td colspan=2><?php echo $this->Form->Submit('Continue',array('div'=>false,'class'=>'tiny radius button bg-blue','name'=>'continue')); ?> </td>	
</tr>
</tbody>
</table>
</div>
	
<?php
if(isset($published_courses) && !empty($published_courses)){
echo $this->element('student_basic');
echo $this->element('registration/student_register');
} else {
if(isset($students) && !empty($students)) {
      $st_count=0;
	  foreach($students as $desdetail=>$stuList) {
		 $sectionDetail=explode('~',$desdetail);
     
      	echo "<div class='fs16'> Program:".$sectionDetail[0]."</div>";
        echo "<div class='fs16'> Program Type: ".$sectionDetail[1]."</div>";
 		echo "<div class='fs16'> Year Level: ".$sectionDetail[2]."</div>";
        echo "<div class='fs16'> Section : ".$sectionDetail[3]."</div>";
		echo "<table cellpadding=0 cellspacing=0>";

?>
  <tr>
            <th style="width:10%">
<?php echo $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false, 'label' => false)); ?>Select All</th>
			<th><?php echo ('No.');?></th>
			<th><?php echo ('Student Number');?></th>
			
			<th><?php echo ('Full Name');?></th>
			<th><?php echo ('Department');?></th>
			<th><?php echo ('Program');?></th>
			<th><?php echo ('Program Type');?></th>
		
			
			<th class="button-success"><?php // __('Actions');?>
			  	<?php 
			/*
			echo $this->Html->link(__('Register All'), 
			array('action' => 'maintain_registration',0,$sectionDetail[4])); 
		
			*/
			?>
			</th>
	</tr>
    <?php
	$i = 0;
	$count=1;
	foreach ($stuList as $student):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		
	?>
	<tr<?php echo $class;?>>
		<td>
		<?php 
		echo $this->Form->input('CourseRegistration.'.$count.'.ggp',array('type' => 'checkbox','class'=>'checkbox1', 'label' => false,'id' => 'StudentSelection'.$count));
		echo $this->Form->hidden('CourseRegistration.'.$count.'.student_id',array('value' =>$student['Student']['id'] ,'class'=>'checkbox1', 'label' => false));
		
		?>
		</td>
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
			echo $this->Html->link(__('Register'), array('action' => 'maintain_registration', $student['Student']['id'])); 
			
			?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
  <?php echo $this->Form->Submit('Register Selected Students',array('div'=>false,'class'=>'tiny radius button bg-blue', 'name'=>'registerSelected_'.$st_count++)); ?>
  
<?php 
	echo $this->Form->input('register_count', array('type' => 'hidden', 'value' => ($st_count-1)));		
   }
 }
}
 
if(isset($studentss) && !empty($studentss)) {
    foreach ($studentss as $pk => $pv) {
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
			/*
			echo $this->Html->link(__('Register All'), 
			array('action' => 'maintain_registration',0,$section_name)); 
		*/
			
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
			echo $this->Html->link(__('Register'), array('action' => 'maintain_registration', $student['Student']['id'])); 
			
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
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
