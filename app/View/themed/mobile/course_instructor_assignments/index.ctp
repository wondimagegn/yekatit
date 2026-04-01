<div class="courseInstructorAssignments index">
<?php echo $this->Form->create('CourseInstructorAssignment');  ?>
	<div class="smallheading"><?php __('Course Instructor Assignments');?></div>
	<table cellpadding="0" cellspacing="0"><tr>
	<td class="font" colspan="2"><?php __('Course Instructor Assignments Optional Search Parameters');?></td></tr>
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
        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','div'=>false)).'</td></tr>'; 
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
			<!---<th class="actions"><?php __('Actions');?></th> --->
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
			['full_name']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['Staff']['Position']['position']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['CourseInstructorAssignment']['type']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['PublishedCourse']['Course']['course_code_title']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['PublishedCourse']['Course']['credit']; ?>&nbsp;</td>
		<td><?php echo $courseInstructorAssignment['PublishedCourse']['Course']['course_detail_hours']; ?>&nbsp;</td>
		<!--- <td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $courseInstructorAssignment['CourseInstructorAssignment']['id'])); ?> 
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $courseInstructorAssignment['CourseInstructorAssignment']['id'])); ?> 
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $courseInstructorAssignment['CourseInstructorAssignment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseInstructorAssignment['CourseInstructorAssignment']['id'])); ?>
		</td> --->
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
<?php echo $this->Form->end(); ?>
</div>
