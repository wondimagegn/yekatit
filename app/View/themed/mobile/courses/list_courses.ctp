<div class="courses form">
<?php echo $this->Form->create('Course');?>
<script type='text/javascript'>
function getDepartment(id) {
            //serialize form data
            var formData = $("#college_id_"+id).val();
			$("#department_id_"+id).empty();
			$("#department_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#department_id_"+id).attr('disabled', true);
			$("#curriculum_id_"+id).empty();
			$("#curriculum_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#curriculum_id_"+id).attr('disabled', true);
			//get form action
            var formUrl = '/departments/get_department_combo/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#department_id_"+id).attr('disabled', false);
						$("#department_id_"+id).empty();
						$("#department_id_"+id).append(data);
							//Curriculum list
							var subCat = $("#department_id_"+id).val();
							$("#curriculum_id_"+id).empty();
							//get form action
							var formUrl = '/curriculums/get_curriculum_combo/'+subCat;
							$.ajax({
								type: 'get',
								url: formUrl,
								data: subCat,
								success: function(data,textStatus,xhr){
										$("#curriculum_id_"+id).attr('disabled', false);
										$("#curriculum_id_"+id).empty();
										$("#curriculum_id_"+id).append(data);
								       
							            
										
								},
								error: function(xhr,textStatus,error){
										alert(textStatus);
								}
							});
							//Curriculum list
							var subCat = $("#department_id_"+id).val();
							$("#year_level_id_"+id).empty();
							//get form action
							var formUrl = '/dormitory_assignments/get_year_levels/'+subCat;
							$.ajax({
								type: 'get',
								url: formUrl,
								data: subCat,
								success: function(data,textStatus,xhr){
										$("#year_level_id_"+id).attr('disabled', false);
										$("#year_level_id_"+id).empty();
										$("#year_level_id_"+id).append(data);
								       
							            
										
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
 
 
function updateCourseCategory(id) {
           
            //serialize form data
            var formData = $("#curriculum_id_"+id).val();
			$("#curriculum_id_"+id).attr('disabled', true);
			$("#course_category_id_"+id).attr('disabled', true);
			
			//get form action
            var formUrl = '/curriculums/get_course_category_combo/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#curriculum_id_"+id).attr('disabled', false);
			            $("#course_category_id_"+id).attr('disabled', false);
						$("#course_category_id_"+id).empty();
					    $("#course_category_id_"+id).append('<option></option>');
						
						$("#course_category_id_"+id).append(data);
					},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
      
}

function updateCurriculumAndYearLevel(id) {
           
            //serialize form data
            var formData = $("#department_id_"+id).val();
			$("#department_id_"+id).attr('disabled', true);
			$("#curriculum_id_"+id).attr('disabled', true);
			$("#year_level_id_"+id).attr('disabled', true);
			
			//get form action
            var formUrl = '/curriculums/get_curriculum_combo/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						
			            $("#department_id_"+id).attr('disabled', false);
						$("#curriculum_id_"+id).attr('disabled', false);
						$("#curriculum_id_"+id).empty();
					   
						$("#curriculum_id_"+id).append(data);
					},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
				//get form action
            var formUrl = '/course_schedules/get_year_levels/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						
			            $("#department_id_"+id).attr('disabled', false);
						$("#year_level_id_"+id).attr('disabled', false);
						$("#year_level_id_"+id).empty();
					   
						$("#year_level_id_"+id).append(data);
					},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
      
}
</script>
<div class="smallheading"><?php __('List Courses'); ?></div>
	<!-- <table>
		<?php
		if($role_id == ROLE_DEPARTMENT) {
			echo '<tr><td class="fs15"><strong>College:</strong> '.$college_name.'</td></tr>';
			echo '<tr><td class="fs15"><strong>Department:</strong> '.$department_name.'</td></tr>';
		}
		if($role_id == ROLE_COLLEGE) {
			echo '<tr><td class="fs15"><strong>College:</strong> '.$college_name.'</td></tr>';
		}
		echo "<tr><td>".$this->Form->input('curriculum_id',array('empty'=>'---Select Curriculum---'))."</td></tr>";
		if($role_id != ROLE_DEPARTMENT) {
			echo "<tr><td>".$this->Form->input('department_id',array('empty'=>'---Select Department---'))."</td></tr>";
		}
		echo "<tr><td>".$this->Form->Submit('Search',array('name'=>'search','div'=>false))."</td></tr>";
		echo $this->Form->end();
		?>
	</table>
	
	-->
	<table class="fs13 small_padding">
	   
		<tr>
			<td style="width:15%">College:</td>
			<td style="width:35%"><?php 
			if (!empty($college_name) && ($role_id==ROLE_DEPARTMENT || $role_id==ROLE_COLLEGE)) {
			    echo $college_name;
			} else {
			      echo $this->Form->input('Search.college_id',
			           array('empty'=>'---Select College---','label'=>false,
			           'onchange'=>'getDepartment(1)','style'=>'width:250px','id'=>'college_id_1'));
			}
			 ?>
			</td>
			<td style="width:13%"> Department:</td>
			<td style="width:37%">
			<?php 
			      if (!empty($department_name) && $role_id==ROLE_DEPARTMENT) {
			            echo $department_name;
			      } else {
			           echo $this->Form->input('Search.department_id',
			           array('empty'=>'---Select Department---','style'=>'width:250px','label'=>false,
			           'onchange'=>'updateCurriculumAndYearLevel(1)','id'=>'department_id_1'));
			      }
			      
			?>
			
			</td>
		</tr>
		  
		<tr>
			<td style="width:15%">Curriculum:</td>
			<td style="width:35%"><?php 
			 echo $this->Form->input('Search.curriculum_id',array('empty'=>' ',
		'onchange'=>'updateCourseCategory(1)',
		'style'=>'width:250px','id'=>'curriculum_id_1','label'=>false));
			 ?>
			</td>
			<td style="width:13%"> Course/Module Category:</td>
			<td style="width:37%">
			<?php 
			 echo $this->Form->input('Search.course_category_id',array('empty'=>' ',
	    'id'=>"course_category_id_1",'label'=>false));
			?>		
			</td>
		</tr>
		<tr>
			<td style="width:15%">Semester:</td>
			<td style="width:35%"><?php 
			  echo $this->Form->input('Search.semester',array('empty'=>' ',
        'options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'label'=>false));
			 ?>
			</td>
			<td style="width:13%"> Year Level:</td>
			<td style="width:37%">
			<?php 
			 echo $this->Form->input('Search.year_level_id',array('empty'=>' ',
			 'id'=>'year_level_id_1','label'=>false));
			?>		
			</td>
		</tr>
		<tr>
		
		</tr>

		<tr>
			<td colspan="4"><?php echo $this->Form->submit(__('Get Courses', true), 
			array('name' => 'search', 'id' => 'getCourses', 'div' => false)); ?></td>
		</tr>
	</table>
<?php 
if(!empty($course_associate_array)){
?>
<table cellpadding="0" cellspacing="0">
	<?php
	echo "<div class='fs15'><strong>Program:</strong> ".$program_name."</div>";
	
	echo '<tr><td style="text-align:right;">'.$this->Html->link($this->Html->image("/img/pdf_icon.gif",array("alt"=>"Print To Pdf")), 
			array('action' => 'print_courses_pdf'),array('escape'=>false))."Print".  $this->Html->link($this->Html->image("/img/xls-icon.gif",array("alt"=>"Export TO Excel")), 
        array('action' => 'export_courses_xls'),array('escape'=>false))."Export".'</td></tr>';
	?>
</table>
<?php
foreach($course_associate_array as $yearkey=>$yearvalue) {
        
		foreach($yearvalue as $semesterKey => $semestervalue) {
			echo '<div class="fs15"> <strong>Year Level:</strong> '.$yearvalue[$semesterKey][0]['YearLevel']['name'].'</div>'; 
			echo '<div class="fs15"> <strong>Semester:</strong> '.$semesterKey.'</div>';	

?>
<table cellpadding="0" cellspacing="0" style="border: #CCC solid 1px">
	<tr>
			<th style="border-right: #CCC solid 1px">S.N<u>o</u></th>
			<th style="border-right: #CCC solid 1px"><?php echo $this->Paginator->sort('course_title');?></th>
			<th style="border-right: #CCC solid 1px"><?php echo $this->Paginator->sort('course_code');?></th>
			<th style="border-right: #CCC solid 1px"><?php echo $this->Paginator->sort('credit');?></th>
			<th style="border-right: #CCC solid 1px; width:40px;"><?php echo $this->Paginator->sort('L T L');?></th>
			<th style="border-right: #CCC solid 1px"><?php echo $this->Paginator->sort('course_category_id');?></th>
			<th style="border-right: #CCC solid 1px"><?php echo $this->Paginator->sort('lecture_attendance_requirement');?></th>
			<th style="border-right: #CCC solid 1px"><?php echo $this->Paginator->sort('lab_attendance_requirement');?></th>
			<th style="border-right: #CCC solid 1px; width: 120px;"><?php echo $this->Paginator->sort('grade_type_id');?></th>
			<th class="actions" style="border-right: #CCC solid 1px"><?php __('Actions');?></th>

	</tr>
	<?php
	$i = 0;
	$count=1;
	foreach ($semestervalue as $course):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style="border-right: #CCC solid 1px"><?php echo $count++; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['Course']['course_title']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['Course']['course_code']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['Course']['credit']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['Course']['course_detail_hours']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['CourseCategory']['name']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['Course']['lecture_attendance_requirement']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px"><?php echo $course['Course']['lab_attendance_requirement']; ?>&nbsp;</td>
		<td style="border-right: #CCC solid 1px; width: 120px;">
			<?php echo $this->Html->link($course['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $course['GradeType']['id'])); ?>
		</td>
		<td class="actions" style="border-right: #CCC solid 1px">
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $course['Course']['id'])); ?>
		<?php
		if($role_id == ROLE_DEPARTMENT) {
		?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $course['Course']['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $course['Course']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $course['Course']['id'])); ?>
			</td>
		<?php
		}
		?>
	</tr>
<?php endforeach; 
	?>
	</table>
	<?php
		}
	}
} /*
else if(empty($course_associate_array) && !($isbeforesearch)){
    echo "<div class='info-box info-message'><span></span>No course is found with these search criteria</div>";
}
*/
?>
</div>
