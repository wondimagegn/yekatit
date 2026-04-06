<?php echo $this->Form->create('CourseInstructorAssignment');?>
<script type='text/javascript'>
//Sub Cat Combo 1
function updateDepartment(id) {
            //serialize form data
            var formData = $("#college_id_"+id).val();
            $("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).empty();
			$("#department_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#department_id_"+id).attr('disabled', true);
			$("#staff_id_"+id).empty();
			$("#staff_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#staff_id_"+id).attr('disabled', true);
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
							//Items list
							var subCat = $("#department_id_"+id).val();
							$("#staff_id_"+id).empty();
							//get form action
							var formUrl = '/staffs/get_instructor_combo/'+subCat;
							$.ajax({
								type: 'get',
								url: formUrl,
								data: subCat,
								success: function(data,textStatus,xhr){
										$("#staff_id_"+id).attr('disabled', false);
										$("#staff_id_"+id).empty();
										$("#staff_id_"+id).append(data);
								},
								error: function(xhr,textStatus,error){
										alert(textStatus);
								}
							});
							//End of items list
				},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
}
//Staff List
function updateInstructor(id) {
            //serialize form data
            var subCat = $("#department_id_"+id).val();
			$("#staff_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled', true);
			$("#staff_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#staff_id_"+id).empty();
			//get form action
            var formUrl = '/staffs/get_instructor_combo/'+subCat;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: subCat,
                success: function(data,textStatus,xhr){
						$("#staff_id_"+id).attr('disabled', false);
						$("#department_id_"+id).attr('disabled', false);
						$("#staff_id_"+id).empty();
						$("#staff_id_"+id).append(data);
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            });
			
            return false;
}
</script>
<p class="smallheading">View Instructor Load .</p>
<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Academic Year:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.academic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data,'empty'=>'')); ?></td>
			<td style="width:12%">Semester:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.semester', array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'),'empty'=>'')); ?></td>
			
		</tr>
		<tr>
			
		    <td style="width:12%">College:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.college_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$colleges,'empty'=>' ',
			'onchange'=>'updateDepartment(1)','id'=>'college_id_1','style'=>'width:200px')); ?></td>
			<td style="width:12%">Department:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.department_id', array('class' => 'fs14',  'style' => 'width:200px', 'label' => false,'id'=>'department_id_1','empty'=>' ','onchange'=>'updateInstructor(1)','options'=>$departments)); ?></td>    
			
		</tr>
		<tr>
			
		    <td style="width:12%">Instructor:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.staff_id', 
			array('label' => false,'id'=>'staff_id_1', 'class' => 'fs14',
			'options'=>$staffs)); ?></td>
			<td style="width:8%">&nbsp;</td>
			<td style="width:60%">&nbsp;</td>    
			
		</tr>
		<!--- 
		<tr>
		  	<td style="width:20%"> Type:</td>
			<td style="width:80%"><?php 
			echo $this->Form->input('Search.lecture', array('type' => 'checkbox', 'label' => 'Lecture', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['lecture'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.lec_lab', array('type' => 'checkbox', 'label' => 'Lecture+Lab', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['lec_lab'] == 1 ? 'checked' : false))).'<br/>';
			
			echo $this->Form->input('Search.lab', array('type' => 'checkbox', 'label' => 'Laboratory', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['lab'] == 1 ? 'checked' : false))).'<br/>';
			
			?></td>		
		</tr>
		--->
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Instructor Load', true), array('name' => 'viewInstructorLoad', 'div' => false)); ?></td>
		</tr>
</table>

<style>
.low_padding_table tr td{
padding:2px
}
</style>
<?php 
if (isset($instructor_loads) && !empty($instructor_loads))  {

foreach ($instructor_loads as $acadamic_year=>$semester) {
    foreach ($semester as $sem=>$course_instructor) {
?>
    
<table class="low_padding_table fs13">
    <tr>
		<td style="width:26%; font-weight:bold">Instructor Name:</td>
		<td style="width:74%"><?php
		        if (isset($staff_details) && !empty($staff_details)) {
		                $staff_title_position=null;
		                if (isset($staff_details['Title'])) {
		                        $staff_title_position.=$staff_details['Title']['title'];
		                }
		                
		                if (isset($staff_details['Staff'])) {
		                  $staff_title_position .= ' '.$staff_details['Staff']['full_name'];
		                }
		                
		                if (isset($staff_details['Position'])) {
		                     $staff_title_position.='<strong>('. $staff_details['Position']['position'].')</strong>'; 
		                          
		                }
		                echo  $staff_title_position;
		                
		               
		        }
		       
		 
		 ?></td>
	</tr>
	<tr>
		<td style="width:26%; font-weight:bold">Acadamic Year:</td>
		<td style="width:74%"><?php echo $acadamic_year; ?></td>
	</tr>
	<tr>
		<td style="width:26%; font-weight:bold">Semester:</td>
		<td style="width:74%"><?php echo $sem; ?></td>
	</tr>
</table>
   <table class="low_padding_table fs13">
	    <tr>
		     <th style="width:10%">S.N<u>o</u></th>
		     <th style="width:10%">Course Code</th>
		     <th style="width:25%">Course Title</th>
		     <th style="width:25%"> Assigned Section</th>
		      <th style="width:12%"> Assignment Type </th>
		     <th style="width:6%">Credit</th>
		     <th style="width:6%">L T L</th>
		     <th style="width:6%">Load</th>
	    </tr>
	
    <?php
      $c_count=1;
      $loads=0;
      //L T L
        //2 + 3* 2/3 0x2/3 = LOAD
      foreach ($course_instructor as $index=>$value) {
          
        ?>
         <tr>
		    <td><?php echo $c_count++; ?></td>
		    <td><?php echo $value['PublishedCourse']['Course']['course_code']; ?></td>
		    <td><?php echo $value['PublishedCourse']['Course']['course_title']; ?></td>
		     <td><?php echo $value['Section']['name']; ?></td>
		      <td><?php echo ucwords($value['CourseInstructorAssignment']['type']); ?></td>
		    <td><?php echo $value['PublishedCourse']['Course']['credit']; ?>
		    </td>
		    <td><?php echo $value['PublishedCourse']['Course']['course_detail_hours']; ?> </td>
		    
		    <td> 
		         <?php 
		            if (strcasecmp($value['CourseInstructorAssignment']['type'],'Lecture')===0) {
		                  
		                  echo $value['PublishedCourse']['Course']['lecture_hours'];
		                  
		                  $loads += $value['PublishedCourse']['Course']['lecture_hours'];
		                  
		            } else if (strcasecmp($value['CourseInstructorAssignment']['type'],'Lecture+Tutorial')===0) {
		                  
		                  echo number_format($value['PublishedCourse']['Course']['lecture_hours']+
		                  $value['PublishedCourse']['Course']['tutorial_hours']*(2/3),2,'.',',');
		                  $loads +=($value['PublishedCourse']['Course']['lecture_hours']+
		                  $value['PublishedCourse']['Course']['tutorial_hours']*(2/3));
		            
		            } else if (strcasecmp($value['CourseInstructorAssignment']['type'],'tutorial')===0) {
		            
		                 
		                  if (isset($value['PublishedCourse']['Course']['tutorial_hours'])) {
		                    echo number_format(
		                  $value['PublishedCourse']['Course']['tutorial_hours']*(2/3),2,'.',','); 
		                   $loads += ($value['PublishedCourse']['Course']['tutorial_hours']*(2/3));
		                  }
		                 
		            } else if (strcasecmp($value['CourseInstructorAssignment']['type'],'lab')===0) {
		                 
		                  if (isset($value['PublishedCourse']['Course']['laboratory_hours'])) {
		                    echo number_format(
		                  $value['PublishedCourse']['Course']['laboratory_hours']*(2/3),2,'.',','); 
		                   $loads += ($value['PublishedCourse']['Course']['laboratory_hours']*(2/3));
		                  }
		                 
		            } else if (strcasecmp($value['CourseInstructorAssignment']['type'],'Lecture+Lab')===0
		            ) {
		                   echo number_format($value['PublishedCourse']['Course']['lecture_hours']+
		                  $value['PublishedCourse']['Course']['laboratory_hours']*(2/3),2,'.',',');
		                  $loads +=($value['PublishedCourse']['Course']['lecture_hours']+
		                  $value['PublishedCourse']['Course']['laboratory_hours']*(2/3));
		            }
		          
		         ?>
		    </td>
		    
	    </tr>
        <?php  
        /*
        Lecture 
tutorial
Lecture+Tutorial
        */ 
         
      } // end of course iteration 
      echo '<tr><td colspan=7><strong>Total Load</strong></td><td><strong>'.number_format(
      $loads, 2, '.', ',').'</strong></td></tr>';
    echo '</table>';
     
	} // end of semester
  }	// end of year level  
} // end of curriculum  
?>

