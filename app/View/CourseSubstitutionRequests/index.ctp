<div class="courseSubstitutionRequests index">
<?php echo $this->Form->create('CourseSubstitutionRequest');?>
<?php if (isset($search_visible)) { ?>
<table cellpadding="0" cellspacing="0">
<?php 
         if ($role_id != ROLE_STUDENT) {
           echo '<tr><td>'.$this->Form->input('Student.studentnumber').
            '</td></tr>';
         }
         
            
          
            if ($role_id == ROLE_REGISTRAR) {
                echo '<tr><td>'.$this->Form->input('Student.department_id',array(
            'label' => 'Department',
            'empty'=>"--Select Department--")).'</td></tr>';  
            }
            
           
            
          ?>
<tr> 
<td><?php
 if ($role_id != ROLE_STUDENT) {
    echo $this->Form->submit('Search'); 
 }
 ?> </td>	
</tr></table>
<?php 

}

?>
<?php if (!empty($courseSubstitutionRequests)) { ?>
<?php //debug($courseSubstitutionRequests); ?>
	<div class="smallheading">
	
	    <?php 
	     if ($role_id != ROLE_STUDENT) {
	         __('Latest list of course substitution request.');
	      
	     } else {
	          __('List of course substitution request.');
	           
	     }
	        
	        
	   ?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('S.No','id');?></th>
			<th><?php echo $this->Paginator->sort('request_date');?></th>
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('course_for_substitued_id');?></th>
			<th><?php echo $this->Paginator->sort('course_be_substitued_id');?></th>
			<th><?php echo $this->Paginator->sort('Accepted/Rejected');?></th>
			
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start=$this->Paginator->counter('%start%');
	foreach ($courseSubstitutionRequests as $courseSubstitutionRequest):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $courseSubstitutionRequest['CourseSubstitutionRequest']['request_date']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseSubstitutionRequest['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile', $courseSubstitutionRequest['Student']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link(
			$courseSubstitutionRequest['CourseForSubstitued']['course_code'].'-'.$courseSubstitutionRequest['CourseForSubstitued']['course_title'].'-'.$courseSubstitutionRequest['CourseForSubstitued']['Curriculum']['name'].' '.$courseSubstitutionRequest['CourseForSubstitued']['Curriculum']['year_introduced'].'('.$courseSubstitutionRequest['CourseForSubstitued']['Department']['name'].')', array('controller' => 'courses', 'action' => 'view', $courseSubstitutionRequest['CourseForSubstitued']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($courseSubstitutionRequest['CourseBeSubstitued']['course_code'].'-'.$courseSubstitutionRequest['CourseBeSubstitued']['course_title'].'-'.$courseSubstitutionRequest['CourseBeSubstitued']['Curriculum']['name'].' '.$courseSubstitutionRequest['CourseBeSubstitued']['Curriculum']['year_introduced'].'('.$courseSubstitutionRequest['CourseBeSubstitued']['Department']['name'].')', array('controller' => 'courses', 'action' => 'view', $courseSubstitutionRequest['CourseBeSubstitued']['id'])); ?>
		</td>
		<td>
		<?php 
		     
		     if ($courseSubstitutionRequest['CourseSubstitutionRequest']['department_approve']==1) {
		         echo 'Accepted';
		     }  else {
		    
		        if (is_null($courseSubstitutionRequest['CourseSubstitutionRequest']['department_approve'])) {
		             echo '--';
		        } else if ($courseSubstitutionRequest['CourseSubstitutionRequest']['department_approve']==0) {
		            echo 'Rejected';
		        }
		    }
		
		?>
		
		&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $courseSubstitutionRequest['CourseSubstitutionRequest']['id'])); ?>
			<?php 
			if ($role_id != ROLE_STUDENT ) {
			  
			echo $this->Html->link(__('Approve Substitution'), array('action' => 'approve_substitution', $courseSubstitutionRequest['CourseSubstitutionRequest']['id']));
			
			}
			 
			?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<?php 
}
?>
</div>
