<?php echo $this->Form->create('ExamGrade',array('novalidate' => true));?>
<?php

$st_count = 1;
$applied_count=0;

?>
<div class="box">
   <div class="box-body">
     <div class="row">
	  <div class="large-12 columns">
          <div style="margin-bottom:10px" class="smallheading">Select the course you want to sit for FX exam. It is only allowed to sit only  one FX on given semester  based on the new legistlation, and the other FX will be converted to F automatically and calculated on your status. </div>
         
         <table>
  
	       <tr> 
            <th><?php echo ('No.'); ?> </th>
            <th style="padding:0;width:30px;">
            </th> 
            <th><?php echo ('Name');?></th>
            <th><?php echo ('ID');?></th>
		    <th><?php echo ('Course Name');?></th>
            <th><?php echo ('Academic Year');?></th>
			<th><?php echo ('Semester');?></th>	
			<th><?php echo ('Grade');?></th>
			<th><?php echo ('Action');?></th>	
		</tr>
		
	<?php 
    $count=1;
	foreach ($fx_grade_change as $fx) { 

		
?>
	  <tr>         
		<td><?php echo $count;?></td>
       
   		 <td ><?php echo $this->Form->checkbox('FxResitRequest.'.$count.'.selected_id',array('class'=>'checkbox1')); ?>&nbsp;
   		   <?php echo $this->Form->hidden('FxResitRequest.'.$count.'.student_id',array('value'=>$fx['Student']['id'])); 
   		    if(isset($fx['CourseRegistration']['id']) && !empty($fx['CourseRegistration']['id'])){
   		    echo $this->Form->hidden('FxResitRequest.'.$count.'.course_registration_id',array('value'=>$fx['CourseRegistration']['id']));
   		     echo $this->Form->hidden('FxResitRequest.'.$count.'.published_course_id',array('value'=>$fx['CourseRegistration']['published_course_id']));
   		     
   		    }
   		     if(isset($fx['CourseAdd']['id']) && !empty($fx['CourseAdd']['id'])){
   		     echo $this->Form->hidden('FxResitRequest.'.$count.'.course_add_id',array('value'=>$fx['CourseAdd']['id']));
   		     echo $this->Form->hidden('FxResitRequest.'.$count.'.published_course_id',array('value'=>$fx['CourseAdd']['published_course_id']));
   		     
   		     }
   		     echo $this->Form->hidden('FxResitRequest.'.$count.'.applied_id',array('value'=>$fx['Student']['applied_id']));
   		     
   		     
   		   ?>
   		 </td> 
     
        <td><?php echo $fx['Student']['full_name']; ?>&nbsp;</td>
        <td><?php echo $fx['Student']['studentnumber']; ?>&nbsp;</td>
        <td><?php echo $fx['PublishedCourse']['Course']['course_title']; ?>&nbsp;</td>
         <td><?php echo $fx['PublishedCourse']['academic_year']; ?>&nbsp;</td>
          <td><?php echo $fx['PublishedCourse']['semester']; ?>&nbsp;</td>
          <td><?php echo $fx['ExamGrade'][0]['grade']; ?>&nbsp;</td>
         
       	<td>
       		<?php 
       			if(isset($fx['Student']['applied_id']) && !empty($fx['Student']['applied_id']) && 
       			$fx['Student']['fxgradesubmitted']==false){
       			 echo $this->Html->link(__('Delete'), array('controller'=>'ExamGrades',
                'action' => 'cancel_fx_resit_request', $fx['Student']['applied_id']),null, sprintf(__('Are you sure you want to delete %s?'),
				$fx['PublishedCourse']['Course']['course_title']));
				
       		  }
       		
       		  if(isset($fx['Student']['applied_id']) 
       		  && !empty($fx['Student']['applied_id']) || 
       		  $fx['Student']['fxgradesubmitted']==true){
       		  	$applied_count++;
       		  }
       		?>
       	</td>
       </tr>
         
	<?php 
	
	$count++;
	} ?>
    
</table>
	<?php
	if($applied_count==0 && $applied_request==1){
echo $this->Form->submit(__('Apply Fx Exam Resit'), array('name' => 'applyFxExamResit', 'div' => false,'class'=>'tiny radius button bg-blue')); 
}

?>
<?php echo $this->Form->end(); ?>

	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->

<script>
	$(document).ready(function () {
	   $('input[type="checkbox"]').on('change', 
	   function() {
   			$('input[type="checkbox"]').not(this).prop('checked', false);
	});

	});
</script>
