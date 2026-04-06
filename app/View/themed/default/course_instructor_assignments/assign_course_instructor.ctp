<?php echo $this->Form->create('CourseInstructorAssignment');  ?>
<script type="text/javascript">
var image = new Image();
image.src = '/img/busy.gif';

 //update instructor combo
function getInstructorCombo(id,department_id,published_course_id,isprimary,course_split_section_id) {
           
            //serialize form data
           
            var subCat = department_id+'~'+$("#course_type_"+id).val()+'~'+published_course_id+ '~'+isprimary 
            +'~'+course_split_section_id;
            
            $("#ajax_instructor_"+id).attr('disabled', true);
            $("#ajax_instructor_"+id).empty().html('<img src="/img/busy.gif" class="displayed" >');

            var formUrl = '/course_instructor_assignments/assign_instructor/'+subCat;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: subCat,
                success: function(data,textStatus,xhr){
                   
                    $("#ajax_instructor_"+id).attr('disabled', false);
                    $("#ajax_instructor_"+id).empty();
                    $("#ajax_instructor_"+id).append(data);
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            });
            return false;
 }

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
<div class="courseInstructorAssignments form">

<p class="fs16">
<strong> Important Note: </strong> 
 This tool will help you to do instructor assignment to your own  department published courses and other department who published courses thought by your department and give permission.
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
<div id="ListPublishedCourse" style="display:<?php echo (!empty($turn_off_search) ? 'none' : 'display'); ?>">
<table class="fs13 small_padding">
	   
		<tr>
			<td style="width:15%">Academic Year:</td>
			<td style="width:35%"><?php 
			    echo $this->Form->input('Search.academicyear',array(
            'label' => false,'type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>
              isset($this->data['Search']['academicyear']) ? $this->data['Search']['academicyear']:(isset(
              $defaultacademicyear) ? $defaultacademicyear:'')
            
            )
            
            );
			?>
			</td>
			<td style="width:13%"> Semester:</td>
			<td style="width:37%">
			<?php 
			    echo $this->Form->input('Search.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'label'=>false,'empty'=>'--select semester--'));
			?>
			
			</td>
		</tr>
		  
		<tr>
			<td style="width:15%">Program:</td>
			<td style="width:35%"><?php 
			 echo $this->Form->input('Search.program_id',array('id'=>'program_id','label'=>false,
			 'type'=>'select','multiple'=>'checkbox','div'=>false));
			
			 ?>
			</td>
			<td style="width:13%"> Program Type</td>
			<td style="width:37%">
			&nbsp;
			<?php 
			  echo $this->Form->input('Search.program_type_id',array('id'=>'program_type_id','label'=>false,
			 'type'=>'select','multiple'=>'checkbox','div'=>false));
			
			?>		
			</td>
		</tr>
	    <tr>
			<td style="width:15%">Year Level:</td>
			<td style="width:35%"><?php 
			 echo $this->Form->input('Search.year_level_id',array('id'=>'year_level_id','label'=>false,
			 'type'=>'select','multiple'=>'checkbox','div'=>false));
			
			 ?>
			</td>
			<td style="width:13%"> &nbsp;</td>
			<td style="width:37%">
			&nbsp;
			
			</td>
		</tr>

		<tr>
			<td colspan="4"><?php echo $this->Form->submit(__('Continue', true), 
			array('name' => 'getPublishedCourse',  'div' => false)); ?></td>
		</tr>
	</table>
</div>
<?php 
 if (isset($sections_array)) { 
   $index=0;

  foreach ($sections_array as $depat => $depvalue) { 
   echo "<div class='fs16'> Department:".$depat."</div>";
    
   foreach ($depvalue as $pk => $pv) {
       echo "<div class='fs16'> Program:".$pk."</div>";
        foreach ($pv as $ptk=>$ptv) {
                 echo "<div class='fs16'> Program Type: ".$ptk."</div>";
               foreach ($ptv as $yk=>$yv) {
                   echo "<div class='fs16'> Year Level: ".$yk."</div>";
                 foreach ($yv as $section_name=>$section_value) {
                    $count = 1;
                    echo "<div class='fs16'> Section : ".$section_name."</div>";
                        echo '<table style="border: #CCC double 3px "><tr>';
			            echo '<th> No.</th>';
			            echo '<th> Course Title </th>';
			            echo '<th> Course Code </th>';
			            echo '<th> Credit </th>';
			            echo '<th> L T L </th></tr>';
			           
			            asort($section_value);
			            foreach($section_value as $sk=>$sv) {
				            $index =$index +1;
				            if(is_string($sk)){
				               
				               	 echo '<tr><td colspan="5"><B><I> Split section name for this publish course: '.
				               	 $sk .'</I></B></td></tr>';
				 
				                echo '<tr><td class="font_color">' . $count++ .'</td>';
					            echo '<td class="font_color">' . $sv['course_title'] .'</td>';
					            echo '<td class="font_color">' . $sv['course_code'] .'</td>';
					            echo '<td class="font_color">' . $sv['credit'] .'</td>';
					            echo '<td class="font_color">' . $sv['credit_detail'] .'</td></tr>';
				
					echo '<tr><td colspan="2">';
					 //for Primary Instructor
					 echo '<table style="border: #CCC dashed 2px">';
						echo '<tr><td colspan="4" style="text-align: center;"><B>Primary Instructor </B></td></tr>';
						echo '<tr><th style="border-right: #CCC solid 1px"> Full Name </th>';
						echo '<th style="border-right: #CCC solid 1px"> Position </th>';
						echo '<th style="border-right: #CCC solid 1px"> Assigned For</th>';
						if($sv['grade_submitted'] == 0){
							echo '<th style="border-right: #CCC solid 1px"> Action </th>';
						}
						echo '</tr>';
						if(!empty($sv['assign_instructor'][1])){
							foreach($sv['assign_instructor'][1] as $asvalue){
								echo '<tr><td style="border-right: #CCC solid 1px">'. $asvalue['full_name'].'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['position'] .'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['course_type'] .'</td>';
							if($sv['grade_submitted'] == 0){
								echo '<td style="border-right: #CCC solid 1px">'. $this->Html->link(__('Delete', 
								true), array('controller'=>'course_instructor_assignments','action' => 'delete',
								$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id']),null, 
								sprintf(__('Are you sure you want to delete?', true),	
								$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id'])).'</td>';
								echo '</tr>';
								}
							}
						}
						// debug($sv['course_split_section_id']);
						$isprimary =1;
						
						// $course_split_section_id = $sv['course_split_section_id'];
					    $course_split_section_id = $sv['course_split_section_id'];
						if(isset($thisdepartment)){
							$reformat_departments=array();
							$reformat_departments[$thisdepartment]=$departments[$thisdepartment];
							unset($departments[$thisdepartment]);
							foreach($departments as $id=>$name){
							  $reformat_departments[$id]=$name;
							}
							$departments = $reformat_departments;
						}
						if($sv['grade_submitted'] == 0){
                           		
                             if (empty($sv['given_by_department_id'])) {
					            $given_department_idddd='pre';
					        } else {
                                $given_department_idddd=$sv['given_by_department_id'];
                            }	
                           
							echo '<tr><td>'.$this->Form->input('CourseInstructorAssignment.'.$index.'.type',
							array('id'=>'course_type_'.$index,'label'=>'Type','empty'=>'Select Type.',
							'type'=>'select','options'=>$course_type_array[$depat][$pk][$ptk][$yk][$section_name][$sk],
							'onchange'=>'getInstructorCombo('.$index.',"'.$given_department_idddd.'",'
							.$sv['published_course_id'].','.$isprimary.','.$course_split_section_id.')'))."</td></tr>";
							
							
					   }				
						
						echo '<tr><td colspan="4" id="ajax_instructor_'.$index.'"></td></tr>';
				
					echo '</table></td>';
					 //for Secondary Instructor
					 $index=$index+1;
					 echo '<td colspan="3"><table style="border: #CCC dashed 2px">';
					 	echo '<tr><td colspan="4" style="text-align: center;"><B>Secondary Instructor </B></td></tr>';
						echo '<tr><th style="border-right: #CCC solid 1px"> Full Name </th>';
						echo '<th style="border-right: #CCC solid 1px"> Position </th>';
						echo '<th style="border-right: #CCC solid 1px"> Assigned For</th>';
						if($sv['grade_submitted'] == 0){
							echo '<th style="border-right: #CCC solid 1px"> Action </th>'; 
						}
						echo '</tr>';
						if(!empty($sv['assign_instructor'][0])){
							foreach($sv['assign_instructor'][0] as $asvalue){
								echo '<tr><td style="border-right: #CCC solid 1px">'. $asvalue['full_name'].'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['position'] .'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['course_type'] .'</td>';
							if($sv['grade_submitted'] == 0){
								echo '<td style="border-right: #CCC solid 1px">'. $this->Html->link(__('Delete', true), array('controller'=>'course_instructor_assignments','action' => 'delete',$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id']),null, sprintf(__('Are you sure you want to delete?', true),$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id'])).'</td>'; 
								}
								echo '</tr>';
							}
						}
						$isprimary =0;
						$course_split_section_id = $sv['course_split_section_id'];
						if(isset($thisdepartment)){
							$reformat_departments=array();
							$reformat_departments[$thisdepartment]=$departments[$thisdepartment];
							unset($departments[$thisdepartment]);
							foreach($departments as $id=>$name){
							  $reformat_departments[$id]=$name;
							}
							$departments = $reformat_departments;
						}
						
					    if($sv['grade_submitted'] == 0) {
					        if (empty($sv['given_by_department_id'])) {
					           $given_department_idddd='pre';
					        } else {
                                $given_department_idddd=$sv['given_by_department_id'];
                            }
					        
					       	echo '<tr><td>'.$this->Form->input('CourseInstructorAssignment.'.$index.'.type',array('id'=>'course_type_'.$index,'label'=>'Type','empty'=>'Select Type.',
					       	'type'=>'select','options'=>$course_type_array[$depat][$pk][$ptk][$yk][$section_name][$sk],
					       	'onchange'=>'getInstructorCombo('.$index.',"'.$given_department_idddd.'",
					       	'.$sv['published_course_id'].','.$isprimary.','.$course_split_section_id.')'))."</td></tr>";
					
					    }
					
						echo '<tr><td colspan="4" id="ajax_instructor_'.$index.'"></td></tr>';
					
					 echo '</table></td>';
					 echo '</tr>'; 

				            } else {
				               echo '<tr><td class="font_color">' . $count++ .'</td>';
					            echo '<td class="font_color">' . $sv['course_title'] .'</td>';
					            echo '<td class="font_color">' . $sv['course_code'] .'</td>';
					            echo '<td class="font_color">' . $sv['credit'] .'</td>';
					            echo '<td class="font_color">' . $sv['credit_detail'] .'</td></tr>';
				
					echo '<tr><td colspan="2">';
					 //for Primary Instructor
					 echo '<table style="border: #CCC dashed 2px">';
						echo '<tr><td colspan="4" style="text-align: center;"><B>Primary Instructor </B></td></tr>';
						echo '<tr><th style="border-right: #CCC solid 1px"> Full Name </th>';
						echo '<th style="border-right: #CCC solid 1px"> Position </th>';
						echo '<th style="border-right: #CCC solid 1px"> Assigned For</th>';
						if($sv['grade_submitted'] == 0){
							echo '<th style="border-right: #CCC solid 1px"> Action </th>';
						}
						echo '</tr>';
						if(!empty($sv['assign_instructor'][1])){
							foreach($sv['assign_instructor'][1] as $asvalue){
								echo '<tr><td style="border-right: #CCC solid 1px">'. $asvalue['full_name'].'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['position'] .'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['course_type'] .'</td>';
							if($sv['grade_submitted'] == 0){
								echo '<td style="border-right: #CCC solid 1px">'. $this->Html->link(__('Delete', true), array('controller'=>'course_instructor_assignments','action' => 'delete',$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id']),null, sprintf(__('Are you sure you want to delete?', true),	$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id'])).'</td>';
								echo '</tr>';
								}
							}
						}
						$isprimary =1;
						$course_split_section_id = 0;
						if(isset($thisdepartment)){
							$reformat_departments=array();
							$reformat_departments[$thisdepartment]=$departments[$thisdepartment];
							unset($departments[$thisdepartment]);
							foreach($departments as $id=>$name){
							  $reformat_departments[$id]=$name;
							}
							$departments = $reformat_departments;
						}
						if($sv['grade_submitted'] == 0){
                           		
                         if (empty($sv['given_by_department_id'])) {
					        $given_department_idddd='pre';
					    } else {
                            $given_department_idddd=$sv['given_by_department_id'];
                        }	
                        
							echo '<tr><td>'.$this->Form->input('CourseInstructorAssignment.'.$index.'.type',array('id'=>'course_type_'.$index,'label'=>'Type','empty'=>'Select Type.',
							'type'=>'select','options'=>$course_type_array[$depat][$pk][$ptk][$yk][$section_name][$sk],
							'onchange'=>'getInstructorCombo('.$index.',"'.$given_department_idddd.'",'.$sv['published_course_id'].','.$isprimary.','.$course_split_section_id.')'))."</td></tr>";
							
							
							}				
						
						echo '<tr><td colspan="4" id="ajax_instructor_'.$index.'"></td></tr>';
				
					echo '</table></td>';
					 //for Secondary Instructor
					 $index=$index+1;
					 echo '<td colspan="3"><table style="border: #CCC dashed 2px">';
					 	echo '<tr><td colspan="4" style="text-align: center;"><B>Secondary Instructor </B></td></tr>';
						echo '<tr><th style="border-right: #CCC solid 1px"> Full Name </th>';
						echo '<th style="border-right: #CCC solid 1px"> Position </th>';
						echo '<th style="border-right: #CCC solid 1px"> Assigned For</th>';
						if($sv['grade_submitted'] == 0){
							echo '<th style="border-right: #CCC solid 1px"> Action </th>'; 
						}
						echo '</tr>';
						if(!empty($sv['assign_instructor'][0])){
							foreach($sv['assign_instructor'][0] as $asvalue){
								echo '<tr><td style="border-right: #CCC solid 1px">'. $asvalue['full_name'].'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['position'] .'</td>';
								echo '<td style="border-right: #CCC solid 1px">'.$asvalue['course_type'] .'</td>';
							if($sv['grade_submitted'] == 0){
								echo '<td style="border-right: #CCC solid 1px">'. $this->Html->link(__('Delete', true), array('controller'=>'course_instructor_assignments','action' => 'delete',$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id']),null, sprintf(__('Are you sure you want to delete?', true),$asvalue['CourseInstructorAssignment_id'],$sv['published_course_id'])).'</td>'; 
								}
								echo '</tr>';
							}
						}
						$isprimary =0;
						$course_split_section_id = 0;
						if(isset($thisdepartment)){
							$reformat_departments=array();
							$reformat_departments[$thisdepartment]=$departments[$thisdepartment];
							unset($departments[$thisdepartment]);
							foreach($departments as $id=>$name){
							  $reformat_departments[$id]=$name;
							}
							$departments = $reformat_departments;
						}
					if($sv['grade_submitted'] == 0){
					    if (empty($sv['given_by_department_id'])) {
					       $given_department_idddd='pre';
					    } else {
                            $given_department_idddd=$sv['given_by_department_id'];
                        }
					    
					   	echo '<tr><td>'.$this->Form->input('CourseInstructorAssignment.'.$index.'.type',array('id'=>'course_type_'.$index,'label'=>'Type','empty'=>'Select Type.',
					   	'type'=>'select','options'=>$course_type_array[$depat][$pk][$ptk][$yk][$section_name][$sk],
					   	'onchange'=>'getInstructorCombo('.$index.',"'.$given_department_idddd.'",'.$sv['published_course_id'].','.$isprimary.','.$course_split_section_id.')'))."</td></tr>";
					
					}
					
						echo '<tr><td colspan="4" id="ajax_instructor_'.$index.'"></td></tr>';
					
					 echo '</table></td>';
					 echo '</tr>'; 
				            }            
				        }
				        echo '</table>';
			         
                  }
                }
            }
        }
    }
}
?>
</div>
