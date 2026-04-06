<?php 
//Registrar grade confirmation
if(isset($courses_for_registrar_approval) && !empty($courses_for_registrar_approval)) {
?>
		<?php 
		if(empty($courses_for_registrar_approval)) {
		echo '<p>There is no course that needs grade confirmation</p>';
		} else {
		  echo '<p style="font-size:16px;font-weight:bold">List of courses grade submitted by instructor and approved by department
   	and wait your confirmation.</p>';
              $row_count = 1;
	      foreach($courses_for_registrar_approval as $key => $course_for_grade_confirmation) {
		   if($row_count <= 100) {
			 echo $this->Html->link(__($course_for_grade_confirmation['Course']['course_title'].' ('.$course_for_grade_confirmation['Course']['course_code'].')', true), array('controller' => 'exam_grades', 'action' => 'confirm_grade_submission', $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));
			echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
			echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
			echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year'];
			    
		   } else {
			if(count($courses_for_registrar_approval) > 100) {
				echo 'And other '.(count($courses_for_registrar_approval) - 100).' courses. '.$this->Html->link(__('View All', true), array('controller' => 'exam_grades', 'action' => 'confirm_grade_submission'), array('class'=>'tiny radius button bg-blue')).'';
			}
			break;
		}
               $row_count++;
	      }			 
	 }
	?>		
<?php
  }
?>

<?php 
//College grade approval for department unassigned students
if(isset($courses_for_freshman_approvals) && !empty($courses_for_freshman_approvals)){

  ?>
		    <table class="small_padding">
			<?php
			if(empty($courses_for_freshman_approvals)) {
				echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">
				There is no freshman course that needs grade approval.</p></td></tr>';
			}
			else {
		  echo '<tr><td style="border:0px solid #ffffff">
		   	<p style="font-size:16px;font-weight:bold">List of courses grade submitted
		   	by instructor for department unassigned students and needs your approval
		   	.</p></td></tr>';

			$row_count = 1;
			foreach($courses_for_freshman_approvals as $key => $course_for_grade_confirmation) {
				if($row_count <= 100) {
				   
				?>
				<tr>
			          <td class="action_content">
<?php
echo $this->Html->link(__($course_for_grade_confirmation['Course']['course_title'].' ('.$course_for_grade_confirmation['Course']['course_code'].')', true), array('controller' => 'exam_grades', 
'action' => 'approve_freshman_grade_submission', $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));

echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year']; 										
				?></td>
				</tr>
				<?php
				}
				else {
		                 if(count($courses_for_registrar_approvals) > 100) {
		echo '<tr><td style="font-size:12px">And other '.
		(count($courses_for_registrar_approval) - 100).' courses. '.$this->Html->link(__('View All', true), array('controller' => 'exam_grades', 'action' => 'approve_freshman_grade_submission')).'</td></tr>';
					}
				break;
			   }
			   $row_count++;
			}
		}
		?>
		</table>
           				
<?php
  }
?>

<?php 
//Department grade approval
if(isset($courses_for_dpt_approvals) && !empty($courses_for_dpt_approvals)) {

  ?>
		    <table class="small_padding">
		<?php
		if(empty($courses_for_dpt_approvals)) {
	          echo '<tr><td style="border:0px solid #ffffff"><p style="font-size:12px">There is no course that needs grade approval.
</p></td></tr>';
		}
		else {
		   	echo '<tr><td style="border:0px solid #ffffff">
		   	<p style="font-size:16px;font-weight:bold">List of courses grade submitted by instructor and needs department approval
		   	.</p></td></tr>';
		$row_count = 1;
		foreach($courses_for_dpt_approvals as $key => $course_for_grade_confirmation) {
			if($row_count <= 100) {
				?>
		          <tr>
			   <td class="action_content">
			<?php
			    
			    echo $this->Html->link(
			    __($course_for_grade_confirmation['Course']['course_title'].' ('
			    .$course_for_grade_confirmation['Course']['course_code'].')', true), 
			    array('controller' => 'exam_grades', 
			    'action' => 'approve_non_freshman_grade_submission', $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));
			    echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
			    echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
			    echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year'];
			    ?>
                         </td>
		       </tr>
			<?php
		     } else {
			if(count($courses_for_registrar_approvals) > 100){
			echo '<tr><td style="font-size:12px">And other '.
(count($courses_for_registrar_approval) - 100).' courses. '.$this->Html->link(__('View All', true), array('controller' => 'exam_grades', 'action' => 'approve_non_freshman_grade_submission')).'</td></tr>';
			}
			break;
		      }
		      $row_count++;
		    }
		}
		?>
	</table>			
<?php
  }
?>


<?php 

//Registrar grade confirmation
if(isset($courses_for_registrar_approval) && !empty($courses_for_registrar_approval)) {
?>
		<?php 
		if(empty($courses_for_registrar_approval)) {
		echo '<p>There is no course that needs grade confirmation</p>';
		} else {
		  echo '<p style="font-size:16px;font-weight:bold">List of courses grade submitted by instructor and approved by department
   	and wait your confirmation.</p>';
          $row_count = 1;
	      foreach($courses_for_registrar_approval as $key => $course_for_grade_confirmation) {
				   if($row_count <= 10) {
					 echo $this->Html->link(__($course_for_grade_confirmation['Course']['course_title'].' ('.$course_for_grade_confirmation['Course']['course_code'].')', true), array('controller' => 'exam_grades', 'action' => 'confirm_grade_submission', $course_for_grade_confirmation['PublishedCourse']['id']), array('class' => 'action_link'));
					echo '<br /><strong>Section:</strong> '.$course_for_grade_confirmation['Section']['name'].' ('.((!empty($course_for_grade_confirmation['Department']['name']) ? $course_for_grade_confirmation['Department']['name'] : 'Freshman Program').' / '.$course_for_grade_confirmation['Program']['name'].' / '.$course_for_grade_confirmation['ProgramType']['name']).')';
					echo '<br/> <strong>Semester:</strong>'. $course_for_grade_confirmation['PublishedCourse']['semester'];
					echo '<br/> <strong>Academic Year:</strong>'. $course_for_grade_confirmation['PublishedCourse']['academic_year'];
					
				   } else {
					if(count($courses_for_registrar_approval) > 10) {
						echo 'And other '.(count($courses_for_registrar_approval) - 10).' courses. '.$this->Html->link(__('View All', true), array('controller' => 'exam_grades', 'action' => 'confirm_grade_submission'), array('class'=>'tiny radius button bg-blue')).'';
					}
					break ;
				}
               $row_count++;
	      }			 
	 }
	?>			
<?php
  }
?>
