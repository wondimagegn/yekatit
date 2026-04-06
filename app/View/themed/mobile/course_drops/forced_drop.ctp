<?php ?>
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

<div class="courseDrops form">
<?php 
echo $this->Form->create('CourseDrop');
?>
 <h1 class="heading"> Forced Drop</h1>
<p class="fs16">
   
                    <strong> Important Note: </strong> 
                    This tool will help you to perform forced drop for 
                    selected academic year and semester. Only students 
                    who have been registred on hold bases will be displayed.
                    
                   
                    
                    
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 

	if (!isset($student_lists)) {
		
		echo $html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?>
</div>
<div id="ListPublishedCourse" style="display:<?php echo (isset($student_lists) ? 'none' : 'display'); ?>">

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
	       
	
	
	?></td>
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
		
	
	<tr><td colspan=2><?php echo $this->Form->Submit('Continue',array('div'=>false,'name'=>'continue')); ?> </td>	
</tr>
</tbody>
</table>
</div>

<?php 


 if (isset($student_lists) && !isset($no_display) && !empty($student_lists)) {
 // debug($students);
 
  ?>
  <div class="smallheading"> List of students who have registered on hold bases. 
  Now the system found out they are not qualified to proceed the course. 
  You need to drop the courses they are registered.</div>
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
	foreach ($student_lists as $index=>$student):
		$class = null;
		if ($i++ % 2 == 0) {
		    // debug($student);
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td><?php echo $student['Student']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $student['Student']['full_name']; ?>&nbsp;</td>
		
		<td>
			<?php echo $student['Student']['Department']['name']; ?>
		</td> 
		
		<td>
			<?php echo $student['Student']['Program']['name']; ?>
		</td> 
		
		<td>
			<?php echo $student['Student']['Program']['name']; ?>
		</td> 
		
		<td class="actions">
			<?php 
			/*
			Turn on this when onhold registration is integrated with 
			grade change, and status generation. That means, when status is
			generated check that student has already registred for the next semester
			and academic year, and update registration type based on result.
			    echo $this->Html->link(__('Drop Course', true), array('action' => 'add', 
			    0,$student['CourseRegistration']['id'])); 
			*/
			  echo $this->Html->link(__('Drop Course', true), array('action' => 'add',$student['Student']['id'])); 
			
			?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
<?php 
}

echo $this->Form->end();
?>
</div>
