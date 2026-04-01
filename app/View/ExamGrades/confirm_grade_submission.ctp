<?php 
?>
<script type="text/javascript">
function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
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
function showHideGradeScale(id) {
	if($("#ShowHideGradeScale").val() == 'Show Grade Scale') {
	      
		var p_course_id = id;
		$("#GradeScale").empty();
		$("#GradeScale").append('Loading ...');
			var formUrl = '/published_courses/get_course_grade_scale/'+p_course_id;
			$.ajax({
				type: 'get',
				url: formUrl,
				data: p_course_id,
				success: function(data,textStatus,xhr){
						$("#GradeScale").empty();
						$("#GradeScale").append(data);
						$("#ShowHideGradeScale").attr('value', 'Hide Grade Scale');
				},
				error: function(xhr,textStatus,error){
						alert(textStatus);
				}
			});
		}
		else {
			$("#GradeScale").empty();
			$("#ShowHideGradeScale").attr('value', 'Show Grade Scale');
		}
		
		return false;
}

</script>
<?php echo $this->Form->create('ExamGrade');?> 
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="smallheading">
<p class="fs16">
                    <strong> Important Note: </strong> 
                    This tool will help you to approve grade which was approved by department for your final 
                    confirmation. Only those course which was not be approved early will be approved.
                    
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
<div id="ListPublishedCourse" style="display:<?php echo (!empty($turn_off_search) ? 'none' : 'display'); ?>">
<table class="fs13 small_padding">
	   
		<tr>
			<td style="width:15%">Academic Year:</td>
			<td style="width:35%"><?php 
			    echo $this->Form->input('Search.academicyear',array(
            'label' => false,'type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($this->request->data['Search']['academicyear'])
            ?$this->request->data['Search']['academicyear']:$defaultacademicyear));
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
			<td colspan="4"><?php echo $this->Form->submit(__('Continue'), 
			array('name' => 'getCourseNeedsApproval',  'div' => false,'class'=>'tiny radius button bg-blue')); ?></td>
		</tr>
	</table>
</div>

<?php if (isset($grade_submitted_courses_organized_by_published_course) 
&& !empty($grade_submitted_courses_organized_by_published_course)) { ?>
Exam Grade Approval
<?php 

} 
?>
</div>
<div class="publishedCourses index">
<?php 
//if(!isset($hide_approve_list)){
?><?php
if (isset($grade_submitted_courses_organized_by_published_course) && 
!empty($grade_submitted_courses_organized_by_published_course)) {
?>
<div class="fs14" style="font-weight:bold">List of exam grades submitted by instructors for approval.</div>
<?php 
                foreach ($grade_submitted_courses_organized_by_published_course as $dep => $depvalue) 
                	{
                       echo "<div class='fs14'>Department: ".($dep == 0 ? 'Freshman Program' : $departments[$dep])."</div>";
                   foreach ($depvalue as $pk=>$pv) {
                    if (!empty($pk)) {
                            echo "<div class='fs14'>Program: ".$pk."</div>";
                       foreach ($pv as $ptk=>$ptv) {
                       
                         if (!empty($ptk)) {
                                 echo "<div class='fs14'>Program Type: ".$ptk."</div>";
                               
                              foreach ($ptv as $yk=>$yv) {
                                  if (!empty($yv)) {
                                     echo "<div class='fs14'>Year Level: ".$yk."</div>";
                                     foreach ($yv as $section_name=>$section_value) {
                                      echo "<div class='fs14'>Section : ".$section_name."</div>";
                                      echo "<table cellpadding=0 cellspacing=0>";
                                      ?>
                                       <tr>
                 <th style="width:5%"><?php echo 'S. N<u>o</u>';?></th>
			        <th style="width:25%"><?php echo 'Course Title';?></th>
			        <th style="width:10%"><?php echo 'Course Code';?></th>
			        <th style="width:10%"><?php echo 'Credit';?></th>
			        <th style="width:10%"><?php echo 'L T L';?></th>
			        <th style="width:25%"><?php echo 'Instructor';?></th>
			        <th style="width:15%; text-align:center"><?php echo 'Action';?></th>
						</tr>
                                      <?php  
                                      $sn_count = 1;
                                      foreach ($section_value as $pub_id=> $publishedCourse) {
                                          
                                           ?>
                                          
                                           <?php 
                                            if (!empty($publishedCourse)) {
                                              
	                    $i = 0;
	                 
	                        
		                    $class = null;
		                    if ($i++ % 2 == 0) {
			                    $class = ' class="altrow"';
		                    }
		                    ?>
		                    <tr<?php echo $class;?>>
				<td><?php echo $sn_count++; ?>&nbsp;</td>
				<td>
			<?php echo $this->Html->link($publishedCourse['Course']['course_title'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['Course']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($publishedCourse['Course']['course_code'], array('controller' => 'courses', 'action' => 'view', $publishedCourse['Course']['id'])); ?>
		</td>
		<td>
			<?php echo $publishedCourse['Course']['credit']; ?>
		</td>
		<td>
			<?php echo $publishedCourse['Course']['course_detail_hours']; ?>
		</td>
		<td>
		
		  <?php 
		   if(isset($publishedCourse['CourseInstructorAssignment']) && count($publishedCourse['CourseInstructorAssignment'])>0) {
		     echo $publishedCourse['CourseInstructorAssignment'][0]['Staff']['full_name']; 
		   }
		  ?>
		</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__('Approve Grade Submission'), array('action' => 'confirm_grade_submission', $publishedCourse['PublishedCourse']['id'])); ?>
		</td>  

	</tr>
		                    
		                    <?php   
		
		            
                                            }
                                         
                                       }
                                         echo "</table>";
                                     } 
                                     
                                     } //section end 
                                 } // end year level
                         }
                    
                      }
                   }
                }
               }
?>  

<?php 
    } 
// }  //hide list of grade approval list
 
if (isset($get_list_of_students_with_grade) && !empty($get_list_of_students_with_grade)) {
      if(count($get_list_of_students_with_grade) > 0) {
	    //debug($get_list_of_students_with_grade);
	    
	   /* $this->set(compact('get_list_of_students_with_grade',
		        'hide_approve_list','search_published_course','gradeScaleDetail','instructorDetail',
		        'publishedCourseDetail'));
		        
		        */
		      
	if(isset($publishedCourseDetail['Department']['name'])) {
		$freshman_program = false;
		$approver = 'department';
		$approver_c = 'Department';
	}
	else {
		$freshman_program = true;
		$approver = 'freshman program';
		$approver_c = 'Freshman Program';
	}
	?>
	<div class="fs14">This grade is submitted by <u><?php
	if(isset($instructorDetail['Staff']) && !empty($instructorDetail['Staff'])) {
		echo $instructorDetail['Staff']['first_name'].' '.$instructorDetail['Staff']['middle_name'].' '.$instructorDetail['Staff']['last_name'];
	}
	else {
		echo (isset($publishedCourseDetail['Department']['name']) ? 'the department' : 'the freshman program (college)');
	}
	 ?></u> for 
	<u><?php echo $publishedCourseDetail['Course']['course_title'].' ('.$publishedCourseDetail['Course']['course_code'].')'; ?></u> course and waiting for your confirmation. Please make sure that the submitted course exam grade is correct as <strong>your decision is final</strong>. If you reject the grade, then it will be returned back to the <?php echo $approver; ?> for re-consideration. If you accept the the grade, it will become permanent grade and it can only be changed either through grade change process or makeup exam.</div>
<style>
table.exam_grade_detail td {
padding:2px
}
</style>
<br />
<table class="exam_grade_detail">
<tr>
	<td style="width:11%; font-weight:bold">Department:</td>
	<td style="width:20%"><?php echo (isset($publishedCourseDetail['Department']['name']) ? $publishedCourseDetail['Department']['name'] : 'Freshman'); ?></td>
	<td style="width:11%; font-weight:bold">Section:</td>
	<td style="width:58%"><?php echo $publishedCourseDetail['Section']['name']; ?><td>
</tr>
<tr>
	<td style="font-weight:bold">Course Title:</td>
	<td><?php echo $publishedCourseDetail['Course']['course_title']; ?></td>
	<td style="font-weight:bold">Credit:</td>
	<td><?php echo $publishedCourseDetail['Course']['credit']; ?></td>
</tr>
<tr>
	<td style="font-weight:bold">Program:</td>
	<td> <?php echo $publishedCourseDetail['Program']['name'].' / '.$publishedCourseDetail['ProgramType']['name'];?></td>
	<td style="font-weight:bold">Year Level:</td>
	<td><?php echo (isset($publishedCourseDetail['YearLevel']['name']) ? $publishedCourseDetail['YearLevel']['name'] : '1st'); ?></td>
</tr>
<tr>
	<td style="font-weight:bold">Academic Year:</td>
	<td><?php echo $publishedCourseDetail['PublishedCourse']['academic_year'];?></td>
	<td style="font-weight:bold">Semester:</td>
	<td><?php echo $publishedCourseDetail['PublishedCourse']['semester'];?></td>
</tr>
</table>	
<style>
table.grade_list tr td{
	background-color:#ffffff;
	padding:0px;
	vertical-align:middle;
}
</style>
<table class="grade_list">
	<tr>
		<th style="width:2%">&nbsp;</th>
		<th style="width:25%">Student Name</th>
		<th style="width:15%">Student ID</th>
		<th style="width:10%">Grade</th>
		<th style="width:50%"> Status</th>
	</tr>
	<?php
	if (isset($get_list_of_students_with_grade['register']) && 
	!empty($get_list_of_students_with_grade['register'])) {
	$count = 1;
	$frequency_count=array();
	$st_count = 0;
	foreach($get_list_of_students_with_grade['register'] as $key => $student) {
	    $st_count++;
	?>
	    <tr<?php if(isset($student['ExamGrade']) && !empty($student['ExamGrade']) && $student['ExamGrade'][0]['registrar_approval'] == null) echo ' style="font-weight:bold"'; ?>>
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
		<td><?php echo $student['Student']['first_name'].' '.$student['Student']['middle_name'].' '.$student['Student']['last_name']; ?></td>
		<td><?php echo $student['Student']['studentnumber']; ?></td>
		<td>
		<?php 
		  if (isset($student['ExamGrade']) && !empty($student['ExamGrade'])) {
		       $frequency_count[]=$student['ExamGrade'][0]['grade'];
		       echo $student['ExamGrade'][0]['grade'];
		       if($student['ExamGrade'][0]['registrar_approval'] == null) {
		        echo $this->Form->hidden('ExamGrade.'.$count.'.id',array('value'=>$student['ExamGrade'][0]['id']));
		       }
		  } else {
		   echo '**';
		  
		  }
		?>
		</td>
		<td>
			<?php
			//STATUS
			//Status of grade submision
			if(!isset($student['ExamGrade']) || empty($student['ExamGrade']))
				echo '<p class="on-process">Grade not submited</p>';
			else if($student['ExamGrade']['0']['department_approval'] == null)
				echo '<p class="on-process">Pending for '.$approver.' approval</p>';
			else if($student['ExamGrade']['0']['department_approval'] == -1)
				echo '<p class="rejected">Grade is rejected by the '.$approver.'</p>';
			else
				{
				if($student['ExamGrade']['0']['registrar_approval'] == null)
					echo '<p class="on-process">Approved by '.$approver.', pending for registrar approval</p>';
				else if($student['ExamGrade']['0']['registrar_approval'] == -1)
					echo '<p class="rejected">Approved by '.$approver.', but rejected by registrar</p>';
				else
					echo '<p class="accepted">Accepted</p>';
				}
			?>
		</td>
		</tr>
		<?php //Detail view started  ?>
		<tr id="c<?php echo $st_count; ?>" style="display:none">
			<td colspan="<?php echo 5; ?>">
				<?php
				if(isset($student['MakeupExam']) && isset($student['ExamGradeChange']) && count($student['ExamGradeChange']) > 0) {
					?>
					<table>
						<tr>
							<td style="width:18%; font-weight:bold">Makeup Exam Minute Number:</td>
							<td style="width:82%"><?php echo $student['ExamGradeChange'][0]['minute_number']; ?></td>
						</tr>
					</table>
					<?php
				}
				$register_or_add = 'gh';
				if(isset($student['ExamGradeHistory']))
					$grade_history = $student['ExamGradeHistory'];
				else
					$grade_history = array();
				$this->set(compact('register_or_add', 'grade_history', 'freshman_program'));
				?>
				<table>
					<tr>
						<td style="vertical-align:top; width:40%"><?php
						echo $this->element('registered_or_add_course_grade_history'); ?></td>
						<td style="vertical-align:top; width:60%">&nbsp;</td>
					</tr>
				</table>
				<?php
				$student_exam_grade_change_history = $student['ExamGradeHistory'];
				$student_exam_grade_history = $student['ExamGrade'];
				$this->set(compact('student_exam_grade_history', 'student_exam_grade_change_history', 'freshman_program'));
				echo $this->element('registered_or_add_course_grade_detail_history');
				?>
			</td>
		</tr>
		<?php
		//End of detail view
		$count++;
	   }
	  
	  }
	  	
	 if (isset($get_list_of_students_with_grade['add']) && 
	 !empty($get_list_of_students_with_grade['add'])) { 	
	  	  // ADDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD
	  	
	  	foreach($get_list_of_students_with_grade['add'] as $key => $student) {
	    $st_count++;
	?>
	    <tr<?php if(isset($student['ExamGrade']) && !empty($student['ExamGrade']) && $student['ExamGrade'][0]['registrar_approval'] == null) echo ' style="font-weight:bold"'; ?>>
		<td onclick="toggleView(this)" id="<?php echo $st_count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$st_count)); ?></td>
		<td><?php echo $student['Student']['first_name'].' '.$student['Student']['middle_name'].' '.$student['Student']['last_name']; ?></td>
		<td><?php echo $student['Student']['studentnumber']; ?></td>
		<td>
		
		<?php 
		  if (isset($student['ExamGrade']) && !empty($student['ExamGrade'])) {
		       $frequency_count[]=$student['ExamGrade'][0]['grade'];
		       echo $student['ExamGrade'][0]['grade'];
		       if($student['ExamGrade'][0]['registrar_approval'] == null)
		       	echo $this->Form->hidden('ExamGrade.'.$count.'.id',array('value'=>
		       $student['ExamGrade'][0]['id']));
		  } else {
		   echo '**';
		  
		  }
		?>
		</td>
		<td>
			<?php
			//STATUS
			//Status of grade submision
			if(!isset($student['ExamGrade']) || empty($student['ExamGrade']))
				echo '<p class="on-process">Grade not submited</p>';
			else if($student['ExamGrade']['0']['department_approval'] == null)
				echo '<p class="on-process">Pending for '.$approver.' approval</p>';
			else if($student['ExamGrade']['0']['department_approval'] == -1)
				echo '<p class="rejected">Grade is rejected by the '.$approver.'</p>';
			else
				{
				if($student['ExamGrade']['0']['registrar_approval'] == null)
					echo '<p class="on-process">Approved by '.$approver.', pending for registrar approval</p>';
				else if($student['ExamGrade']['0']['registrar_approval'] == -1)
					echo '<p class="rejected">Approved by '.$approver.', but rejected by registrar</p>';
				else
					echo '<p class="accepted">Accepted</p>';
				}
			?>
		</td>
		</tr>
		<?php //Detail view started  ?>
		<tr id="c<?php echo $st_count; ?>" style="display:none">
			<td colspan="<?php echo 5; ?>">
				<?php
				if(isset($student['MakeupExam']) && isset($student['ExamGradeChange']) && count($student['ExamGradeChange']) > 0) {
					?>
					<table>
						<tr>
							<td style="width:18%; font-weight:bold">Makeup Exam Minute Number:</td>
							<td style="width:82%"><?php echo $student['ExamGradeChange'][0]['minute_number']; ?></td>
						</tr>
					</table>
					<?php
				}
				$register_or_add = 'gh';
				if(isset($student['ExamGradeHistory']))
					$grade_history = $student['ExamGradeHistory'];
				else
					$grade_history = array();
				$this->set(compact('register_or_add', 'grade_history', 'freshman_program'));
				?>
				<table>
					<tr>
						<td style="vertical-align:top; width:40%"><?php
						echo $this->element('registered_or_add_course_grade_history'); ?></td>
						<td style="vertical-align:top; width:60%">&nbsp;</td>
					</tr>
				</table>
				<?php
				$student_exam_grade_change_history = $student['ExamGradeHistory'];
				$student_exam_grade_history = $student['ExamGrade'];
				$this->set(compact('student_exam_grade_history', 'student_exam_grade_change_history', 'freshman_program'));
				echo $this->element('registered_or_add_course_grade_detail_history');
				?>
			</td>
		</tr>
		<?php
		//End of detail view
		$count++;
	  }
	  
	  }
		?>
	
	<?php
	}
	 $array_count=array_count_values($frequency_count);
	?>
</td></tr></table>
<p class="fs14">Legend:
		<ol class="fs14">
			<li> <strong>Bold</strong>: Waiting your decision
			<li> **: Course in progress		
		</ol>

</p>
<p>
 
  <input type="button" value="Show Grade Scale" 
  onclick="showHideGradeScale('<?php echo $publishedCourseDetail['PublishedCourse']['id'];?>')" id="ShowHideGradeScale" class="tiny radius button bg-blue">
  <div style="margin-top:10px" id="GradeScale"></div>
</p>
<table>
	<tr>
		<td style="width:30%">
	
<table>
<tr><th colspan="2"> Summery</th></tr>
<tr><td>Grade</td><td>Number</td></tr>
<?php 
    foreach ($array_count as $grade=>$freqeuncy){
    echo "<tr><td>".$grade."</td><td>".$freqeuncy."</td></tr>";
    }
?>
</table>

		</td>
		<td style="width:70%; padding-left:100px">

 <?php
$options=array('1'=>'Accept','-1'=>'Reject');
$attributes=array('legend'=>false,'label'=>false,'separator'=>"<br/>", 'default' => 1);
 //echo "<td colspan=2>";
//echo $this->Form->radio('department_approval',$options,$attributes);
 //echo "</td></tr>";
 
echo '<table><tr><td> Accept / Reject <br>'.$this->Form->radio('ExamGrade.registrar_approval',$options,$attributes).'</td></tr>';
		 echo '<tr><td> Remark <br/>'.$this->Form->input('ExamGrade.registrar_reason',array('label'=>false, 'cols' => 60)).
		 '</td></tr></table>';

?>
<table>
<tr> <td colspan=2> <?php
 echo $this->Form->Submit('Confirm Grade Submission',array('div'=>false,
 'name'=>'confirmgradesubmission','class'=>'tiny radius button bg-blue'));
 ?> </td>
</tr>
</table>

		</td>
	</tr>
</table>
<?php 
}
?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
