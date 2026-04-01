<div class="courseRegistrations index">
<?php 
  echo $this->Form->Create('CourseRegistration',array('action'=>'search'));
 if ($role_id != ROLE_STUDENT) {
?>

 	<div class="smallheading"><?php __('Course Registration search');?></div>
	<?php

	   
	   echo '<table><tr><td>';
        echo '<table>';	
        echo '<tr><td>'.$this->Form->input('Search.academic_year',array('empty'=>' ',
        'options'=>$acyear_array_data)).'</td></tr>';
        
        echo '<tr><td>'.$this->Form->input('Search.semester',array('empty'=>' ',
        'options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'))).'</td></tr>';
		if ($role_id != ROLE_STUDENT ) {
		   echo '<tr><td>'.$this->Form->input('Search.program_type_id',array('empty'=>' ')).'</td></tr>';
		}
		echo '</table>';
		echo '</td><td>';
		echo '<table>';
		/*echo '<tr><td>'.$this->Form->input('Search.registration_date', array('after'=>'eg: today, 
		>= 2 weeks ago,last friday')).'</td></tr>';
		*/
		//echo '<tr><td>'.$this->Form->input('Search.course_title').'</td></tr>';
		if ($role_id == ROLE_REGISTRAR || $role_id == ROLE_COLLEGE ) {
		    echo '<tr><td>'.$this->Form->input('Search.department_id',array('empty'=>' ')).'</td></tr>';
		}
		if ($role_id != ROLE_STUDENT ) {
		   echo '<tr><td>'.$this->Form->input('Search.program_id',array('empty'=>' ')).'</td></tr>';
		}
		echo '</table>';
		echo '</td></tr>';
		echo '</table>';
		
		echo $this->Form->submit('Search');
		
	?>
	
<?php 

    echo $this->Form->end();
}
?>

<?php 
if (!empty($courseRegistrations)) {   

      ?>
    	
    <?php 
     if (isset($to) && isset($from)) {
       if ($role_id != ROLE_STUDENT) {
     
     ?>
       <div class="smallheading"><?php __('Course registration between '.$this->Format->short_date($from).' and '.$this->Format->short_date($to));?></div>
       <?php 
       
       } else {
       ?>
         <div class="smallheading"> List of courses you have registred so far.</div>
       <?php 
       }
     } else {
     
   ?>
	<div class="smallheading"><?php __('Course registration Lists');?></div>
<?php 
      }
      ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('year_level_id');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<th><?php echo $this->Paginator->sort('program_id');?></th>
			<th><?php echo $this->Paginator->sort('program_type_id');?></th>
			<th><?php echo $this->Paginator->sort('course_id');?></th>
		   <?php 	if ($role_id != ROLE_STUDENT ) { ?>
			<!-- <th class="actions"><?php __('Actions');?></th> -->
			<?php } ?>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');

	foreach ($courseRegistrations as $courseRegistration):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++ ?>&nbsp;</td>
		<td>
			<?php 
			if (isset($courseRegistration['YearLevel']['name'])) {
			   echo $courseRegistration['YearLevel']['name'];
			} else {
			     echo 'Pre/Freshman';
			}
			?>
			
		</td>
	
		<td><?php echo $courseRegistration['CourseRegistration']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $courseRegistration['CourseRegistration']['semester']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseRegistration['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $courseRegistration['Student']['id'])); ?>
		</td>
		<td>
			<?php 
			  if (isset($courseRegistration['Student']['Department']['name'])) {
			    echo $courseRegistration['Student']['Department']['name'];
			  } else {
			      echo 'Non assigned.';
			  }
			 ?>
		
		
		</td>
		<td>
			<?php echo $courseRegistration['Student']['Program']['name']; ?>
		</td>
		<td>
			<?php echo $courseRegistration['Student']['ProgramType']['name']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($courseRegistration['PublishedCourse']['Course']['course_code_title'], array('controller' => 'courses', 'action' => 'view', $courseRegistration['PublishedCourse']['Course']['id'])); 
		
			if (isset($courseRegistration['CourseDrop'][0]) &&
			$courseRegistration['CourseDrop'][0]['department_approval']==1 && count($courseRegistration['CourseDrop'])>0 && $courseRegistration['CourseDrop'][0]['registrar_confirmation']==1) {
			    echo "<b style='color:red'> - Dropped </b>";
			 } else {
			 
			 }
			?>
		</td>
		<?php 
		if ($role_id != ROLE_STUDENT ) { ?>
		<!-- <td class="actions">
		  
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $courseRegistration['CourseRegistration']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $courseRegistration['CourseRegistration']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $courseRegistration['CourseRegistration']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseRegistration['CourseRegistration']['id'])); ?>
		</td> -->
		
		<?php } ?>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<?php } ?>
</div>
