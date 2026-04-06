 <?php 
 echo $this->Form->Create('CourseDrop');
 if ($role_id != ROLE_STUDENT) {
?>

 	<div class="smallheading"><?php __('View Course Drops ');?></div>
 	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
		    <td style="width:13%"> Program:</td>
		    <td style="width:37%"><?php echo $this->Form->input('Search.program_id',array('label'=>false,
		    'style'=>'width:250px','id'=>'program_id_1','empty'=>' ')); ?></td>
		    <?php
		        if (isset($departments) && !empty($departments)) {
		     ?>
		    <td style="width:13%">Department:</td>
		    <td style="width:37%"><?php echo $this->Form->input('Search.department_id',array('label'=>false,
		    'empty'=>' ','style'=>'width:250px','id'=>'department_id_1')); ?></td>
	         
	          <?php 
	            } else if (isset($colleges) && !empty($colleges)) {
	            ?>
	             <td style="width:13%">College:</td>
		    <td style="width:37%"><?php echo $this->Form->input('Search.college_id',array('label'=>false,
		    'empty'=>' ','style'=>'width:250px','id'=>'college_id_1')); ?></td>
	            
	            <?php 
	            }
	          ?>
	    </tr>
	    <tr>
		    <td style="width:13%"> Program Type:</td>
		    <td style="width:37%"><?php echo $this->Form->input('Search.program_type_id',array('label'=>false,
		    'style'=>'width:250px','empty'=>' ')); ?></td>
		    <td style="width:13%">Academic Year:</td>
		    <td style="width:37%"><?php 
		    echo $this->Form->input('Search.academic_year',array('empty'=>' ',
        'options'=>$acyear_array_data,'label'=>false));
		    //echo $this->Form->input('Search.year_approved',array('label'=>false)); ?></td>
	    </tr>
	    
        <tr>
		  	<td style="width:13%"> Type:</td>
			<td style="width:37%"><?php 
			echo $this->Form->input('Search.accepted', array('type' => 'checkbox', 'label' => 'Accepted', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['accepted'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.rejected', array('type' => 'checkbox', 'label' => 'Rejected', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['rejected'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.notprocessed', array('type' => 'checkbox', 'label' => 'Not Processed', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['notprocessed'] == 1 ? 'checked' : false))).'<br/>';
			
			?></td>		
			<td style="width:13%">Semester</td>
			<td style="width:37%">
			    <?php 
			        echo $this->Form->input('Search.semester',array('empty'=>' ',
        'options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'label'=>false));
			    ?>
			</td>
		</tr>
		
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Course Drops ', true), array('name' => 'viewCourseDrops', 'div' => false)); ?></td>
		</tr>
</table>
<?php 
}

if(!empty($courseDrops)) {
?>

<div class="courseDrops index">
	<h2><?php __('Course Drops');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			
			<th><?php echo $this->Paginator->sort('Full Name','student_id');?></th>
			
			<th><?php echo $this->Paginator->sort('year_level_id');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			
			<th><?php 
			echo $this->Paginator->sort('Course','course_code_title');?>&nbsp;</th>
		    <th><?php 
		    echo $this->Paginator->sort('Credit','credit');?>&nbsp;</th>
		    <th><?php echo $this->Paginator->sort('Department','department_approval');?></th>
			<th><?php echo $this->Paginator->sort('Registrar','registrar_confirmation');?></th>
		
			  <th><?php echo $this->Paginator->sort('Department','department_approval');?></th>
			<th><?php echo $this->Paginator->sort('Registrar','registrar_confirmation');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	
	$start=$this->Paginator->counter('%start%');
	$i = 0;

	foreach ($courseDrops as $courseDrop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		
		<td>
			<?php echo $this->Html->link($courseDrop['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile', $courseDrop['Student']['id'])); ?>
			
			
		</td>
		
		<td>
			<?php 
			if (empty($courseDrop['CourseRegistration']['YearLevel']['id']) ||
			$courseDrop['CourseRegistration']['YearLevel']['id']==0 ) {
			        echo 'Pre/Fresh';
			} else {
			    echo $courseDrop['CourseRegistration']['YearLevel']['name'];
			}
			?>
		</td>
		<td><?php echo $courseDrop['CourseDrop']['semester']; ?>&nbsp;</td>
		<td><?php echo $courseDrop['CourseDrop']['academic_year']; ?>&nbsp;</td>
		
		<td><?php echo $courseDrop['CourseRegistration']['PublishedCourse']['Course']['course_code_title']; ?>&nbsp;</td>
		<td><?php echo $courseDrop['CourseRegistration']['PublishedCourse']['Course']['credit']; ?>&nbsp;</td>
			<td><?php 
		
		   
		    if ($courseDrop['CourseDrop']['department_approval']==1) {
		         echo 'Accepted';
		    }  else {
		    
		        if (is_null($courseDrop['CourseDrop']['department_approval'])) {
		             echo '--';
		        } else if ($courseDrop['CourseDrop']['department_approval']==0) {
		            echo 'Rejected';
		        }
		    }
		   
		   
		
		 ?>&nbsp;</td>
		
		<td>
		<?php 
		   if ($courseDrop['CourseDrop']['department_approval']==1) {		
		
		        if ($courseDrop['CourseDrop']['registrar_confirmation']==1) {
		             echo 'Accepted';
		        }  else {
		        
		            if (is_null($courseDrop['CourseDrop']['registrar_confirmation'])) {
		                 echo '--';
		            } else if ($courseDrop['CourseDrop']['registrar_confirmation']==0) {
		                echo 'Rejected';
		            }
		        }
		   
		   
		       
		    } else { 
		        echo '--';
		    
		    } 
		    ?>
		</td>
		<td><?php 
		
		?>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $courseDrop['CourseDrop']['id'])); ?>
		
			
		</td>
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

</div>

<?php 
}
?>
