<?php ?>
<script type='text/javascript'>
$(document).ready(function () {
    $("#CollegeID").change(function(){
		    //serialize form data
		    $("#DepartmentID").attr('disabled', true);
		    $("#CollegeID").attr('disabled', true);
		    var cid = $("#CollegeID").val();
		    //get form action
		    var formUrl = '/departments/get_department_combo/'+cid;
		    $.ajax({
			    type: 'get',
			    url: formUrl,
			    data: cid,
			    success: function(data,textStatus,xhr){
			            $("#DepartmentID").attr('disabled', false);
					    $("#CollegeID").attr('disabled', false);
					    $("#DepartmentID").empty();
					     $("#DepartmentID").append('<option>No department</option>');
					    $("#DepartmentID").append(data);
					
			    },
			    error: function(xhr,textStatus,error){
					    alert(textStatus);
			    }
		    });
		
		    return false;
	    });
});
</script>
<div class="acceptedStudents form">
<?php echo $this->Form->create('AcceptedStudent');?>
	
		
	<?php
	  if($role_id == ROLE_COLLEGE)  {
	  ?>
	  <div class="smallheading">Updating disability information for auto placement</div>
	  <p class="fs16"> <strong>Important Note </strong>Please write the type of disability for those student who are disable and you want to consider disability for auto placement.</p>
	  <table class="fs13 small_padding">
		
		<tr>
			<td style="width:10%">First Name:</td>
			<td style="width:40%"><?php 
			echo $this->Form->input('id');
			echo $this->data['AcceptedStudent']['first_name'];
			?></td>
			<td style="width:10%">Middle Name:</td>
			<td style="width:40%"><?php 
			echo $this->data['AcceptedStudent']['middle_name'];
			?></td>
		</tr>
		<tr>
			<td style="width:10%">Last Name:</td>
			<td style="width:40%"><?php 
			echo $this->Form->input('id');
			echo $this->data['AcceptedStudent']['last_name'];
			?></td>
			<td style="width:10%">Sex:</td>
			<td style="width:40%"><?php 
			echo $this->data['AcceptedStudent']['sex'];
			?></td>
		</tr>
		
		<tr>
			
			<td style="width:10%">Student Number/ID :</td>
			<td style="width:40%">
			<?php 
			 echo $this->data['AcceptedStudent']['studentnumber'];
			?>
			</td>
			<td style="width:10%">
			&nbsp;
			</td>
			<td style="width:40%">
			&nbsp;
			</td>
		</tr>
		
		<tr>
			<td style="width:10%">Disability :</td>
			<td style="width:40%">
			<?php 
			 echo $this->Form->input('disability',array('label'=>false));
			?>
			</td>
			<td style="width:10%">
			&nbsp;
			</td>
			<td style="width:40%">
			&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan=2><?php echo $this->Form->Submit(__('Update', true));?></td>
			
		</tr>
			
	 </table>
	 <?php 
		/*echo "<table><tbody>";
		echo $this->Form->input('id');
		
		echo "<tr><td>".$this->Form->input('first_name',array('readonly'=>'readonly'))."</td></tr>";
		echo "<tr><td>".$this->Form->input('middle_name',array('readonly'=>'readonly'))."</td></tr>";
		echo "<tr><td>".$this->Form->input('last_name',array('readonly'=>'readonly'))."</td></tr>";	
		echo '<tr><td>'.$this->Form->input('disability',array('label'=>'Disability Type')).'</td></tr>';
		echo "<tr><td>".$this->Form->Submit(__('Submit', true))."</td></tr>"; 
		echo "</tbody></table>";
		*/
	  } else {
	   ?>
	   <div class="smallheading"><?php __('Edit Accepted Student'); ?></div>
	    <?php 
	    echo "<table><tbody>";
		echo $this->Form->input('id');
		echo "<tr><td>".$this->Form->input('first_name')."</td></tr>";
		echo "<tr><td>".$this->Form->input('middle_name')."</td></tr>";
		echo "<tr><td>".$this->Form->input('last_name')."</td></tr>";
		
		$options=array('male'=>'Male','female'=>'Female');
		$attributes=array('legend'=>false,'label'=>false);
		      
		echo '<tr><td>'. $this->Form->input('sex',array('type'=>'radio','options'=>$options,'label'=>false,'legend'=>false)).'</td></tr>';
		
		        //echo $this->Form->radio('gender',$options,$attributes);
		//echo '<tr><td><ul><li>'. $this->Form->radio('sex',$options,$attributes).'</li></ul></td></tr>';
		//echo $this->Form->input('student_identification');
		
		echo  '<tr><td>'.$this->Form->input('EHEECE_total_results'). '</td></tr>';
        
      
		 echo  '<tr><td>'.$this->Form->input('region_id').'<td></tr>';
       // // is the student admitted and have department, dont allow edit of department 
		if (isset($isAdmittedAndHaveDepartment['Student']) && 
		!empty($isAdmittedAndHaveDepartment['Student']) && 
		!empty($isAdmittedAndHaveDepartment['Student']['department_id']) ) {	
		?>
		<tr>
		  <td>
		        <div class="input text">
		        <label>College</label>
		         <?php echo $isAdmittedAndHaveDepartment['Student']['College']['name'];  ?>
		        </div>       
           </td>
          </tr>
          <tr>
           <td>
		        <div class="input text">
		        <label>Department</label>
		         <?php echo $isAdmittedAndHaveDepartment['Student']['Department']['name'];  ?>
		        </div>       
           </td>
           </tr>
		 <?php  
		  
		} else {
		
	       echo  '<tr><td>'.$this->Form->input('college_id',array('id'=>'CollegeID')).'<td></tr>';
		echo '<tr><td>'.$this->Form->input('department_id',
		array('selected'=>isset($selected_department) ? $selected_department:'',
		'empty'=>'No department','id'=>'DepartmentID')).'</td></tr>';	
		}
		echo '<tr><td>'.$this->Form->input('program_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('program_type_id').'</td></tr>';
        
		echo '<tr><td>'.$this->Form->input('academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($currentacyeardata)?$currentacyeardata:'')).'</td></tr>';
       echo "<tr><td>".$this->Form->Submit(__('Submit', true))."</td></tr>"; 
	   echo "</tbody></table>";
	}
	?>
<?php ?>
<?php echo $this->Form->end();?>
</div>

