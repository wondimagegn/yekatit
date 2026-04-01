<?php ?>
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
           /*
			$("#DepartmentId").attr('disabled', true);
			$("#CollegeId").attr('disabled', true);
			$("#AcademicYear").attr('disabled', true);
		    $("#Semester").attr('disabled', true);
			$("#ProgramId").attr('disabled', true);
			$("#ProgramTypeId").attr('disabled', true);
			*/
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
            
<div class="courseRegistrations index">
<?php 
  echo $this->Form->Create('CourseRegistration');
 if ($role_id != ROLE_STUDENT) {
?>

 	<div class="smallheading"><?php echo __('Course Registration search');?></div>
	<?php

	   
	   echo '<table><tr><td>';
        echo '<table>';	
         
		if($role_id != ROLE_STUDENT) {
        echo '<tr><td>'.$this->Form->input('Search.academic_year',array('options'=>$acyear_array_data,
'empty'=>'--select academic year--','required'=>true,'id'=>'AcademicYear',
'onchange'=>'updateCourseListOnChangeofOtherField()')).'</td></tr>';

		} 
        
        echo '<tr><td>'.$this->Form->input('Search.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester --','required'=>true,
'id'=>'Semester','onchange'=>'updateCourseListOnChangeofOtherField()')).'</td></tr>';
		if ($role_id != ROLE_STUDENT ) {
		   echo '<tr><td>'.$this->Form->input('Search.program_type_id',
array('empty'=>'--select program type--','required'=>true,'id'=>'ProgramTypeId',
'onchange'=>'updateCourseListOnChangeofOtherField()')).'</td></tr>';

           echo '<tr><td>'.$this->Form->input('Search.section_id',
array('id'=>'SectionId')).'</td></tr>';
		
		}
		echo '</table>';
		echo '</td><td>';
		echo '<table>';
		
		if ((($role_id == ROLE_REGISTRAR || ROLE_REGISTRAR== $this->Session->read('Auth.User')['Role']['parent_id'])) || $role_id == ROLE_COLLEGE) {
		    echo '<tr><td>'.$this->Form->input('Search.department_id',
array('required'=>true,'empty'=>'--select dept--',
'id'=>'DepartmentId','onchange'=>'updateCourseListOnChangeofOtherField()')).'</td></tr>';
		} else if (($role_id == ROLE_REGISTRAR || ROLE_REGISTRAR== $this->Session->read('Auth.User')['Role']['parent_id'])){
		 echo '<tr><td>'.$this->Form->input('Search.college_id',
array('required'=>true,'id'=>'CollegeId','onchange'=>'updateCourseListOnChangeofOtherField()')).'</td></tr>';

		}
		if ($role_id != ROLE_STUDENT ) {
		   echo '<tr><td>'.$this->Form->input('Search.program_id',
array('empty'=>'--select program --','required'=>true,'id'=>'ProgramId',
'onchange'=>'updateCourseListOnChangeofOtherField()')).'</td></tr>';
          echo '<tr><td>'.$this->Form->input('Search.studentnumber').'</td></tr>';
        
		}
		echo '</table>';
		echo '</td></tr>';
		echo '</table>';
		
		
		
	?>
	
<?php 
} else if ($role_id == ROLE_STUDENT) {
?>
<div class="smallheading"><?php echo __('Course Registration search');?></div>
<?php  

 echo '<table>';	
        echo '<tr><td>'.$this->Form->input('Search.academic_year',array('options'=>$acadamic_years,
'default'=>!isset($this->request->data['Search']['academic_year']) ? $defaultacademicyear:$this->request->data['Search']['academic_year'])).'</td>
<td>'.$this->Form->input('Search.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'))).'</td></tr>';
        echo '</table>';

}

	echo '<span>'.$this->Form->submit('Search',array('class'=>'tiny radius button bg-blue','name' => 'search', 'div' => false,'id'=>'Search')).'    ';

if (isset($courseRegistrations) && !empty($courseRegistrations)) { 


	if($role_id != ROLE_STUDENT) {
		echo ''.$this->Form->submit('Generate Slip',array('class'=>'tiny radius button bg-blue','name' => 'generateSlip', 'div' => false));
	   echo '  '.$this->Form->submit('Generate Registered List',array('class'=>'tiny radius button bg-blue','name' => 'generateRegisteredList', 'div' => false));
		
	}


		echo '</span>';

?>
      	<table cellpadding="0" cellspacing="0">
				<tr>
						<th>S.N<u>o</u></th>
                        <th>ID</th>
                        <th>Name</th>
						<th>Department</th>
                        <th>Program</th>
                        <th>Program Type</th>
						<th>Year</th>
						<th>Academic Year</th>
						<th>Semester</th>
						<th>Course</th>
				</tr>
			<?php 
			   $start=1;
               foreach ($courseRegistrations as $courseRegistration)
				{
			?>
       		<tr>
					<td><?php echo $start++ ?>&nbsp;</td>
				    <td>
						<?php echo $courseRegistration['Student']['studentnumber'];?>
					</td>

					<td>
						<?php 
echo $this->Html->link(
    $courseRegistration['Student']['full_name'],
    '#',
   array('class'=>'jsview','data-animation'=>"fade",
'data-reveal-id'=>'myModal','data-reveal-ajax'=>"/students/get_modal_box/".$courseRegistration['Student']['id'])
);

 ?>

					</td>
					<td>
						<?php 
						  if (isset($courseRegistration['Student']['Department']['name'])) {
							echo $courseRegistration['Student']['Department']['name'];
						  } else {
							  echo 'Non assigned.';
						  }
						 ?>
					</td>
					<td>
						<?php echo $courseRegistration['Student']['Program']['name']; ?>
					</td>
					<td>
						<?php echo $courseRegistration['Student']['ProgramType']['name']; ?>
					</td>
		
		
					<td>
						<?php 
						if (isset($courseRegistration['YearLevel']['name'])) {
						   echo $courseRegistration['YearLevel']['name'];
						} else {
							 echo 'Pre/Freshman';
						}
						?>
			
					</td>
	
					<td><?php echo $courseRegistration['CourseRegistration']['academic_year']; ?>&nbsp;</td>
					<td><?php echo $courseRegistration['CourseRegistration']['semester']; ?>&nbsp;</td>
		     <td>
			<?php 
			echo $this->Html->link($courseRegistration['PublishedCourse']['Course']['course_code_title'], array('controller' => 'courses', 'action' => 'view', $courseRegistration['PublishedCourse']['Course']['id'])); 

			if (isset($courseRegistration['CourseDrop'][0]) &&
			$courseRegistration['CourseDrop'][0]['department_approval']==1 && count($courseRegistration['CourseDrop'])>0 && $courseRegistration['CourseDrop'][0]['registrar_confirmation']==1) {
			    echo "<b style='color:red'> - Dropped </b>";
			 } else {
			 
			 }
			?>
		</td>
					
	</tr>

			<?php 
               $start++;
           }
	  ?>
	  </table>

<?php 

}




echo $this->Form->end();

?>

</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
