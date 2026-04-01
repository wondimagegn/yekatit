<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="courseAdds index">
<?php 
 // echo $this->Form->Create('CourseAdd',array('action'=>'search'));
 echo $this->Form->Create('CourseAdd');
 if ($role_id != ROLE_STUDENT) {
?>

 	<div class="smallheading"><?php echo __('View Course Adds');?></div>
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
			echo $this->Form->input('Search.accepted', array('type' => 'checkbox', 'label' => 'Accepted', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['accepted'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.rejected', array('type' => 'checkbox', 'label' => 'Rejected', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['rejected'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.notprocessed', array('type' => 'checkbox', 'label' => 'Not Processed', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['notprocessed'] == 1 ? 'checked' : false))).'<br/>';
			
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
		<td colspan='4'><?php echo $this->Form->submit(__('View Course Add'), array('name' => 'viewCourseAdds','class'=>'tiny radius button bg-blue', 'div' => false)); ?></td>
		</tr>
</table>
	<?php
}
?>
</div>
<?php if (!empty($courseAdds)) { 
   
?>
<div class="courseAdds index">
	<h2><?php echo __('Course Adds');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('year_level_id');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('course_id');?></th>
			<th><?php echo $this->Paginator->sort('Department','department_approval');?></th>
			<th><?php echo $this->Paginator->sort('Registrar','registrar_confirmation');?></th>
		
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($courseAdds as $courseAdd):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($courseAdd['YearLevel']['name'], array('controller' => 'year_levels', 'action' => 'view', $courseAdd['YearLevel']['id'])); ?>
		</td>
		<td><?php echo $courseAdd['CourseAdd']['semester']; ?>&nbsp;</td>
		<td><?php echo $courseAdd['CourseAdd']['academic_year']; ?>&nbsp;</td>
		
		<td>
			<?php echo $this->Html->link($courseAdd['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile', $courseAdd['Student']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($courseAdd['PublishedCourse']['Course']['course_title'], array('controller' => 'courses', 'action' => 'view', $courseAdd['PublishedCourse']['Course']['id'])); ?>
		</td>
		<td><?php 
		
		 	 if ($courseAdd['CourseAdd']['department_approval']==1) {		        
		         echo 'Accepted';
		     } else {   
		       if (is_null($courseAdd['CourseAdd']['department_approval'])) {
		          echo 'Waiting Decision';
		       } else if ($courseAdd['CourseAdd']['department_approval']==0) {
		            
		            echo 'Rejected';
		       }
		       
		    }
		   
		
		 ?>&nbsp;</td>
		<td><?php 
		
		 	if ($courseAdd['CourseAdd']['department_approval']==1) {		        
		       
		       if (is_null($courseAdd['CourseAdd']['registrar_confirmation'])) {
		          echo '--';
		       } else if ($courseAdd['CourseAdd']['registrar_confirmation']==1) {
		          echo 'Accepted';
		       } else if ($courseAdd['CourseAdd']['registrar_confirmation']==0) {
		            
		            echo 'Rejected';
		       }
		       
		    }
		
		    
		    ?>&nbsp;</td>
	
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
</div>
<?php } ?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
