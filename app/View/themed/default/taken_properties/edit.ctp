<?php ?>
<script type='text/javascript'>
var months = Array();
//Sub cat combo
function updateDepartmentCollege(id) {
           
            //serialize form data
            var formData = $("#college_id_"+id).val();
			$("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled', true);
			$("#section_id_"+id).attr('disabled', true);
			$("#student_id_"+id).attr('disabled', true);
			
			//get form action
            var formUrl = '/departments/get_department_combo/'+formData;
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
			                            $("#student_id_"+id).attr('disabled', false);
			                            
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
						$("#section_id_"+id).empty();
						$("#section_id_"+id).append(data);
						
				},
				error: function(xhr,textStatus,error){
						alert(textStatus);
				}
			});
			return false;
 }
//Sub cat combo
function updateStudent(id) {
           
            //serialize form data
            var formData = $("#section_id_"+id).val();
			$("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled',true);	
			$("#section_id_"+id).attr('disabled', true);
			$("#student_id_"+id).attr('disabled', true);
			//get form action
            var formUrl = '/sections/get_section_students/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#section_id_"+id).attr('disabled', false);
						$("#student_id_"+id).attr('disabled',false);
						$("#college_id_"+id).attr('disabled', false);
			            $("#department_id_"+id).attr('disabled',false);	
						$("#student_id_"+id).empty();
						$("#student_id_"+id).append(data);
							
				},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
      
}

</script>
<div class="takenProperties form">
<?php echo $this->Form->create('TakenProperty');?>
	
	<?php
	 $from = date('Y') - 5;
        $to = date('Y') + 1;
        echo '<table>';
        echo '<tr>';
        echo '<td>';
             echo $this->element('student_basic');
             echo $this->Form->hidden('id');
              echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
        echo '</td>';
        echo '<td>';
                echo '<table id="taken_properties_id">';
                echo '<tr><th>Property</th><th>Taken Date</th><th>Remark</th></tr>';
              
                echo "<tr><td>".$this->Form->input('name',array('label'=>false))."</td>";
	            
	           echo "<td>".$this->Form->input('taken_date',
	           array('minYear'=>$from,'maxYear'=>$to,'orderYear' => 'desc','label'=>false)).'</td>';
	
		        echo "<td>".$this->Form->input('remark',array('label'=>false)).'</td></tr>';
		        echo '</table>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		
		echo "<tr><td>".$this->Form->Submit('Save',array('name'=>'saveTakenProperties','div'=>false)).'</td></tr>';
		echo '</table>';
	
	/*   echo $this->Form->hidden('id');
	  
	  echo '<table>';
	echo '<tr><td width="30%">';
	    echo '<table>';
	
		         $from = date('Y') - 1;
                 $to = date('Y') + 1;
    if ($role_id == ROLE_CLEARANCE) {        
         echo '<tr><td>'.$this->Form->input('college_id',array('label'=>'Select College.','empty'=>'--select college--','id'=>'college_id_1',
         'onchange'=>'updateDepartmentCollege(1)')).'</td></tr>'; 
         echo '<tr><td>'.$this->Form->input('department_id',
         array('id'=>'department_id_1',
         'onchange'=>'updateSection(1)')).'</td></tr>';
         echo '<tr><td>'.$this->Form->input('section_id',array('id'=>'section_id_1',
         'onchange'=>'updateStudent(1)')).'</td></tr>'; 
		  echo '<tr><td>'.$this->Form->input('student_id',array('id'=>'student_id_1')).'</td></tr>';
    } else if ($role_id == ROLE_COLLEGE) {
         echo '<tr><td>'.$this->Form->input('department_id',
         array('id'=>'department_id_1',
         'onchange'=>'updateSection(1)')).'</td></tr>';
         echo '<tr><td>'.$this->Form->input('section_id',array('id'=>'section_id_1',
         'onchange'=>'updateStudent(1)')).'</td></tr>'; 
		  echo '<tr><td>'.$this->Form->input('student_id',array('id'=>'student_id_1')).'</td></tr>';
    } else if ($role_id == ROLE_DEPARTMENT) {
        echo '<tr><td>'.$this->Form->input('section_id',array('id'=>'section_id_1',
         'onchange'=>'updateStudent(1)','empty'=>' ')).'</td></tr>'; 
		echo '<tr><td>'.$this->Form->input('student_id',array('id'=>'student_id_1','empty'=>' ')).
		'</td></tr>';
    }		
    echo '</table></td><td>';
		echo '<table>';
		if ($role_id == ROLE_CLEARANCE ) {
		    echo "<tr><td>".$this->Form->input('office_id')."</td></tr>";
	    
	    }
	    echo "<tr><td>".$this->Form->input('name',array('label'=>'Property Name'))."</td></tr>";
	    
	   echo "<tr><td>".$this->Form->input('taken_date').'</td></tr>';
		//echo "<tr><td style='padding-left:200px'>".$this->Form->input('returned').'</td></tr>';
		echo "<tr><td>".$this->Form->input('return_date',array('empty'=>' ',
		'minYear'=>$from,'maxYear'=>$to)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('remark').'</td></tr>';
	    echo '</table>';
	    echo '</td></tr>';
	    echo '</table>';
	?>
<?php 
echo $this->Form->end(__('Submit', true));
*/
?>
</div>
