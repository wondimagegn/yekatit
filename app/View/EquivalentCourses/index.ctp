<?php echo $this->Form->create('EquivalentCourse');?>
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
<div>
<table class="fs13 small_padding" style="margin-bottom:0px">
    <tr><td class="smallheading" colspan="4">View Course Maps </td></tr>
	
	
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
		<td style="width:13%"> Course Title:</td>
		<td style="width:37%"><?php echo $this->Form->input('Search.title',array('label'=>false,
		'style'=>'width:250px','id'=>'course_title')); ?></td>
		
	</tr>
   
   
	<tr>
			<td colspan="4"><?php echo $this->Form->submit(__('View Course Map '), array('name' => 'viewCourseMap', 'id' => 'viewCourseMap', 'div' => false)); ?></td>
	</tr>
	</table>
</div>
<div class="equivalentCourses index">
	<div class="smallheading"><?php echo __('Equivalent Courses');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('Course To Be Equivalent','course_for_substitued_id');?></th>
			<th><?php echo $this->Paginator->sort('Equivalent Course','course_be_substitued_id');?></th>
			
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start=$this->Paginator->counter('%start%');
	foreach ($equivalentCourses as $equivalentCourse):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($equivalentCourse['CourseForSubstitued']['course_code'].'-'.$equivalentCourse['CourseForSubstitued']['course_title'].'-'.$equivalentCourse['CourseForSubstitued']['Curriculum']['name'].' '.$equivalentCourse['CourseForSubstitued']['Curriculum']['year_introduced'].'('.$equivalentCourse['CourseForSubstitued']['Department']['name'].')', array('controller' => 'courses', 'action' => 'view', $equivalentCourse['CourseForSubstitued']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($equivalentCourse['CourseBeSubstitued']['course_code'].'-'.$equivalentCourse['CourseBeSubstitued']['course_title'].'-'.$equivalentCourse['CourseBeSubstitued']['Curriculum']['name'].' '.$equivalentCourse['CourseBeSubstitued']['Curriculum']['year_introduced'].'('.$equivalentCourse['CourseBeSubstitued']['Department']['name'].')', array('controller' => 'courses', 'action' => 'view', $equivalentCourse['CourseBeSubstitued']['id'])); ?>
		</td>
		
		<td class="actions">
			
				<?php echo $this->Html->link(__('Delete Map'), array('action' => 'delete', 
			$equivalentCourse['EquivalentCourse']['id']), null, sprintf(__('Are you sure you want to delete  %s?'), $equivalentCourse['CourseBeSubstitued']['course_code'].'-'.$equivalentCourse['CourseBeSubstitued']['course_title'].' mapped '.$equivalentCourse['CourseForSubstitued']['course_code'].'-'.$equivalentCourse['CourseForSubstitued']['course_title'])); ?>
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
</div>
