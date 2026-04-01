<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<div class="courseInstructorAssignments index">
<?php echo $this->Form->create('CourseInstructorAssignment');  ?>
	<div class="smallheading"><?php echo __('Course Instructor Assignments');?></div>
	<table cellpadding="0" cellspacing="0"><tr>
	<td class="font" colspan="2"><?php echo __('Course Instructor Assignments Optional Search Parameters');?></td></tr>
		<?php 
        if(ROLE_COLLEGE == $role_id ) {  
        	 echo '<tr><td colspan="2">'. $this->Form->input('department_id',array('empty'=>'---Please Select Department---')).'</td></tr>'; 
        }
        echo '<tr><td>'. $this->Form->input('instructor_name').'</td>'; 
        echo '<td>'. $this->Form->input('course_name').'</td></tr>'; 
		echo '<tr><td>'.$this->Form->input('academicyear',array('label' => 'Academic Year','type'=>'select',
			'options'=>$acyear_array_data,'empty'=>"All")).'</td>';
		echo '<td >'.$this->Form->input('semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'All')).'</td></tr>';

		echo '</tr>';
        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','continue'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>'; 
	?> 
	</table>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th><?php echo $this->Paginator->sort('section_id');?></th>
			<th><?php echo $this->Paginator->sort('instructor');?></th>
			<th><?php echo $this->Paginator->sort('position');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('course');?></th>
			<th><?php echo $this->Paginator->sort('credit');?></th>
			<th><?php echo $this->Paginator->sort('course_detail');?></th>
			<!-- <th class="actions"><?php echo __('Actions');?></th> -->
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($courseInstructorAssignments as $courseInstructorAssignment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['CourseInstructorAssignment']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['CourseInstructorAssignment']['semester']; ?>&nbsp;</td>
		<?php
		if(empty($courseInstructorAssignment['CourseSplitSection']['section_name'])){
			echo '<td>'. $courseInstructorAssignment['Section']['name'].'&nbsp;</td>';
		} else {
			echo '<td>'. $courseInstructorAssignment['CourseSplitSection']['section_name'].'&nbsp;</td>';
		}
		?>
		<td><?php echo $courseInstructorAssignment['Staff']['Title']['title'].' '.$courseInstructorAssignment['Staff']
			['full_name'];
			debug($courseInstructorAssignment['Staff']);

			 ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['Staff']['Position']['position']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['CourseInstructorAssignment']['type']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['PublishedCourse']['Course']['course_code_title']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['PublishedCourse']['Course']['credit']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['PublishedCourse']['Course']['course_detail_hours']; ?>&nbsp;</td>
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
<?php echo $this->Form->end(); ?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
