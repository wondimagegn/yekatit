<?php 
//Department exam grade changes, makeup exams, supplementary exams
 if(!empty($exam_grade_change_requests)) {
  ?>
		<?php 
                  
         if($exam_grade_change_requests == 0 && empty($makeup_exam_grades) && empty($rejected_makeup_exams) 
&& empty($rejected_supplementary_exams)) {
		echo '<p style="font-size:12px">There is no exam grade change requests.</p>';
	} else {
	
	 if($exam_grade_change_requests != 0)
		echo '<li>You have '.($exam_grade_change_requests).' 
grade change requests.</li>';
	if($makeup_exam_grades != 0)
		echo '<li>You have '.($makeup_exam_grades).' makeup exam approval requests.</li>';
	if($rejected_makeup_exams != 0)
		echo '<li class="rejected">You have '.($rejected_makeup_exams).' rejected makeup exam grade.</li>';
	if($rejected_supplementary_exams != 0)
		echo '<li class="rejected">You have '.($rejected_supplementary_exams).' rejected supplementary exam grade.</li>';
	echo '</ul>';
    	
		 echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_department_grade_change'));
     }
?>			
<?php
  }
?>



<?php 
//College exam grade changes approval requests 
if(isset($exam_grade_changes_for_college_approval) && !empty($exam_grade_changes_for_college_approval)) 
{
?>	
		<?php 
		 if($exam_grade_changes_for_college_approval == 0) {
		    echo '<p>There is no grade change requests to be approved.</p>';
		 } else {
		    echo '<ul>';
		       if($exam_grade_changes_for_college_approval != 0)
			echo '<li>You have '.($exam_grade_changes_for_college_approval).' grade change requests.</li>';
		     echo '</ul>';
		}
		?>
		
		<?php echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_college_grade_change')); ?>				
<?php
  }
?>


<?php 
//Registrar exam grade changes approval requests
 if(isset($reg_exam_grade_change_requests) && !empty($reg_exam_grade_change_requests)) {	
  ?>
		<?php 
		if($reg_exam_grade_change_requests == 0 && empty($reg_supplementary_exam_grades) && empty($fm_rejected_makeup_exams) 
	&& empty($fm_rejected_supplementary_exams)){
		echo '<p style="font-size:12px">There is no exam grade change requests.</p>';
		} else {
		  
			echo '<ul>';
			if($reg_exam_grade_change_requests != 0)
				echo '<li>You have '.($reg_exam_grade_change_requests).' grade change requests.</li>';
			if($reg_makeup_exam_grades != 0)
				echo '<li>You have '.($reg_makeup_exam_grades).' makeup exam approval requests.</li>';
			if($reg_supplementary_exam_grades != 0)
				echo '<li>You have '.($reg_supplementary_exam_grades).' supplementary exam approval requests.</li>';
			echo '</ul>';
		}
		
		?>
		<a href="/exam_grade_changes/manage_registrar_grade_change" class="tiny radius button bg-blue">
               View All
		</a>			
<?php
  }
?>



<?php 
//Freshman exam grade changes, makeup exams, supplementary exams 
if(isset($fm_exam_grade_change_requests) && !empty($fm_exam_grade_change_requests)) {  
?>		  <table class="small_padding">
			<?php
			if($fm_exam_grade_change_requests == 0 && empty($fm_makeup_exam_grades) && empty($fm_rejected_makeup_exams) && empty($fm_rejected_supplementary_exams)) {
				echo '<tr><td colspan="2"><p style="font-size:12px">There is no freshman exam grade change requests.</p></td></tr>';
			}
			else {
				echo '<tr><td>';
				echo '<ul>';
				if($fm_exam_grade_change_requests != 0)
					echo '<li>You have '.($fm_exam_grade_change_requests).' grade change requests.</li>';
				if($fm_makeup_exam_grades != 0)
					echo '<li>You have '.($fm_makeup_exam_grades).' makeup exam approval requests.</li>';
				if($fm_rejected_makeup_exams != 0)
					echo '<li class="rejected">You have '.($fm_rejected_makeup_exams).' rejected makeup exam grade.</li>';
				if($fm_rejected_supplementary_exams != 0)
					echo '<li class="rejected">You have '.($fm_rejected_supplementary_exams).' rejected supplementary exam grade.</li>';
				echo '</ul>';
				echo '</td></tr>';
			}
			?>
		      </table>
		   <?php echo $this->Html->link(__('View All', true), array('controller' => 'exam_grade_changes', 'action' => 'manage_freshman_grade_change'),array('class'=>'tiny radius button bg-blue')); ?>
         		
<?php
  }
?>
