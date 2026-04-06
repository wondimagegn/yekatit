<div class="courseSubstitutionRequests index">
<?php echo $this->Form->create('CourseSubstitutionRequest');?>
<script type='text/javascript'>
//Sub cat combo
function updateCurriculumGivenProgram(id,department_id) {
           
            //serialize form data
            var formData = $("#program_id_"+id).val();
			$("#program_id_"+id).attr('disabled', true);
			$("#curriculum_id_"+id).attr('disabled', true);
			
			
			//get form action
            var formUrl = '/curriculums/get_curriculum_combo/'+department_id+'/'+formData;
           
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#program_id_"+id).attr('disabled', false);
			            $("#curriculum_id_"+id).attr('disabled', false);
						$("#curriculum_id_"+id).empty();
						$("#curriculum_id_"+id).append('<option></option>');
						$("#curriculum_id_"+id).append(data);
						
					},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
      
}
</script>
<p class="smallheading">View Course Substitution.</p>
<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
		    <td style="width:13%"> Program:</td>
		    <td style="width:37%"><?php echo $this->Form->input('Search.program_id',array('label'=>false,
		    'style'=>'width:250px','id'=>'program_id_1','onchange'=>'updateCurriculumGivenProgram(1,'.$department_id.')',
		    'empty'=>' ')); ?></td>
		    <td style="width:13%">Curiculum:</td>
		    <td style="width:37%"><?php echo $this->Form->input('Search.curriculum_id',array('label'=>false,
		    'empty'=>' ','style'=>'width:250px','id'=>'curriculum_id_1')); ?></td>
	    </tr>
	    
	    
        <tr>
		  	<td style="width:13%"> Type:</td>
			<td style="width:37%"><?php 
			echo $this->Form->input('Search.accepted', array('type' => 'checkbox', 'label' => 'Accepted', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['accepted'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.rejected', array('type' => 'checkbox', 'label' => 'Rejected', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['rejected'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.notprocessed', array('type' => 'checkbox', 'label' => 'Not Processed', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['notprocessed'] == 1 ? 'checked' : false))).'<br/>';
			
			?></td>		
			<td style="width:13%">&nbsp;</td>
			<td style="width:37%">&nbsp;</td>
		</tr>
		
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Substitution', true), array('name' => 'viewSubstitution', 'div' => false)); ?></td>
		</tr>
	</table>

<?php

/* if (isset($search_visible)) { ?>
<table cellpadding="0" cellspacing="0">
<?php 
echo '<tr><td>'.$this->Form->input('Student.studentnumber').
            '</td></tr>';
          
            if ($role_id == ROLE_REGISTRAR) {
                echo '<tr><td>'.$this->Form->input('Student.department_id',array(
            'label' => 'Department',
            'empty'=>"--Select Department--")).'</td></tr>';  
            }
            
           
            
          ?>
<tr> 
<td><?php echo $this->Form->submit('Search'); ?> </td>	
</tr></table>
<?php 

}
*/
?>
<?php if (!empty($courseSubstitutionRequests)) { 

?>
<?php //debug($courseSubstitutionRequests); ?>
	<div class="smallheading"><?php __('Course Substitution Requests.');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('S.No','id');?></th>
			<th><?php echo $this->Paginator->sort('request_date');?></th>
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('course_for_substitued_id');?></th>
			<th><?php echo $this->Paginator->sort('course_be_substitued_id');?></th>
			<th><?php echo $this->Paginator->sort('Accepted/Rejected');?></th>

			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
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
			<?php 
			echo $this->Html->link($courseSubstitutionRequest['CourseBeSubstitued']['course_code'].'-'.$courseSubstitutionRequest['CourseBeSubstitued']['course_title'].'-'.$courseSubstitutionRequest['CourseBeSubstitued']['Curriculum']['name'].' '.$courseSubstitutionRequest['CourseBeSubstitued']['Curriculum']['year_introduced'].'('.$courseSubstitutionRequest['CourseBeSubstitued']['Department']['name'].')', array('controller' => 'courses', 'action' => 'view', $courseSubstitutionRequest['CourseBeSubstitued']['id'])); ?>
		</td>
		
		<td><?php 
		
		     
		     if ($courseSubstitutionRequest['CourseSubstitutionRequest']['department_approve']==1) {
		         echo 'Accepted';
		     }  else {
		    
		        if (is_null($courseSubstitutionRequest['CourseSubstitutionRequest']['department_approve'])) {
		             echo '--';
		        } else if ($courseSubstitutionRequest['CourseSubstitutionRequest']['department_approve']==0) {
		            echo 'Rejected';
		        }
		    }
		
		
		?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $courseSubstitutionRequest['CourseSubstitutionRequest']['id'])); ?>
		
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
<?php 
}
?>
</div>
