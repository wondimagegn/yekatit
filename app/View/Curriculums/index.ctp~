<?php ?>
<script type='text/javascript'>
function getDepartment(id) {
            //serialize form data
            var formData = $("#college_id").val();
			$("#department_id_"+id).empty();
			$("#department_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#department_id_"+id).attr('disabled', true);
			//get form action
            var formUrl = '/departments/get_department_combo/'+formData;
            $.ajax({
               
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#department_id_"+id).attr('disabled', false);
						$("#department_id_"+id).empty();
						$("#department_id_"+id).append('<option style="width:100px"></option>');
						$("#department_id_"+id).append(data);
				},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
 }
 
 
 function updateCurriculum (id) {
           //serialize form data
            var formData = $("#department_id_"+id).val();
           
			$("#curriculum_id_"+id).empty();
			$("#curriculum_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled', true);
			//get form action
            var formUrl = '/curriculums/get_curriculum_combo/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#program_id_"+id).attr('disabled', false);
						$("#curriculum_id_"+id).attr('disabled', false);
						$("#department_id_"+id).attr('disabled', false);
						
						$("#curriculum_id_"+id).empty();
						$("#curriculum_id_"+id).append(data);
				},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
  }

</script>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
                     <h2 class="box-title">
			<?php echo __('Curriculum search');?>
		      </h2>
		</div>
		<div class="large-12 columns">
			<?php 
 echo $this->Form->Create('Curriculum');
?>
	<table class="fs13 small_padding">
	   
		<tr>
			<td style="width:15%">College:</td>
			<td style="width:35%"><?php 
			if (!empty($college_name) && ($role_id==ROLE_DEPARTMENT || $role_id==ROLE_COLLEGE)) {
			            echo $college_name;
			} else {
			      echo $this->Form->input('Search.college_id',
			           array('empty'=>'---Select College---','label'=>false,
			           'onchange'=>'getDepartment(1)','id'=>'college_id',
			           'style'=>'width:200px'));
			}
			 ?>
			</td>
			<td style="width:13%"> Department:</td>
			<td style="width:37%">
			<?php 
			      if (!empty($department_name) && $role_id==ROLE_DEPARTMENT) {
			            echo $department_name;
			      } else {
			           echo $this->Form->input('Search.department_id',
			           array('empty'=>'---Select Department---',
			           'style'=>'width:200px','label'=>false,'id'=>'department_id_1'));
			      }
			      
			?>
			
			</td>
		</tr>
		  
		<tr>
			<td style="width:15%">Program:</td>
			<td style="width:35%"><?php 
			 echo $this->Form->input('Search.program_id',array('id'=>'program_id','label'=>false,
			 'type'=>'select','multiple'=>'checkbox','div'=>false));
			
			 ?>
			</td>
			<td style="width:13%"> &nbsp;</td>
			<td style="width:37%">
			&nbsp;
				
			</td>
		</tr>
	

		<tr>
			<td colspan="4"><?php echo $this->Form->submit(__('Get Curriculums'), 
			array('name' => 'search', 'id' => 'getCurriculums', 'div' => false,'class'=>'tiny radius button bg-blue')); ?></td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	
<?php 
     if (!empty($result_curriculums)) {
?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name','Name');?></th>
			<th><?php echo $this->Paginator->sort('year_introduced','Year Introduced');?></th>
			<th><?php echo $this->Paginator->sort('type_credit','Type Credit');?></th>
			<th><?php echo $this->Paginator->sort('amharic_degree_nomenclature','Amharic Degree Nomenclature');?></th>
			<th><?php echo $this->Paginator->sort('english_degree_nomenclature','English Degree Nomenclature');?></th>
			<th><?php echo $this->Paginator->sort('minimum_credit_points','Minimum Credit Point Required');?></th>
			<th><?php echo $this->Paginator->sort('department_id','Department');?></th>
			
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	
	foreach ($result_curriculums as $curriculum):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $curriculum['Curriculum']['name']; ?>&nbsp;</td>
		<td><?php echo $curriculum['Curriculum']['year_introduced']; ?>&nbsp;</td>
		<td><?php echo $curriculum['Curriculum']['type_credit']; ?>&nbsp;</td>
		
		<td><?php echo $curriculum['Curriculum']['amharic_degree_nomenclature']; ?>&nbsp;</td>
		<td><?php echo $curriculum['Curriculum']['english_degree_nomenclature']; ?>&nbsp;</td>
		<td><?php echo $curriculum['Curriculum']['minimum_credit_points']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($curriculum['Department']['name'], array('controller' => 'departments', 'action' => 'view', $curriculum['Department']['id'])); ?>
		</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__(''), array('action' => 'view', $curriculum['Curriculum']['id']),array('class'=>'fontello-eye','title'=>'View')); ?>
			<?php if ($role_id == ROLE_DEPARTMENT ) {
			?>
			<?php if($curriculum['Curriculum']['registrar_approved']==0){?>
			<?php echo $this->Html->link(__(''), array('action' => 'edit', $curriculum['Curriculum']['id']),array('class'=>'fontello-pencil','title'=>'Edit')); ?>
			<?php echo $this->Html->link(__(''), array('action' => 'delete', $curriculum['Curriculum']['id']),array('class'=>'fontello-trash','title'=>'Delete'), sprintf(__('Are you sure you want to delete  %s?'), $curriculum['Curriculum']['name'].''.$curriculum['Curriculum']['year_introduced'])); ?>
			<?php } else { ?>
			  Curriculum approved and locked by registrar
			<?php } ?>
			<?php } ?>
			<?php 
			if($role_id == ROLE_REGISTRAR){
				
				 $lock=($curriculum['Curriculum']['lock']==0 ? 'lock':'unlock');
				 $curapp=($curriculum['Curriculum']['registrar_approved']==0 ? 'Pending':'Approved');
				  echo $this->Form->postLink(__($lock), array('action' => 'lock', $curriculum['Curriculum']['id']), array('confirm' => __('Are you sure you want to '.$lock.' # %s ?', $curriculum['Curriculum']['name'])));
				 
				 
				 echo '<br/>';
				  echo $this->Form->postLink(__($curapp), array('action' => 'approve', $curriculum['Curriculum']['id']), array('confirm' => __('Are you sure you want to '.$curapp.' # %s ?', $curriculum['Curriculum']['name'])));
				  /*
				  echo $this->Form->postLink(__("$lock"), array('action' => 'lock', $curriculum['Curriculum']['id']),array(),
				  __('Are you sure you want to '.$lock.' # %s ?', $curriculum['Curriculum']['name']));
				  */
				  
				 
				  
				 /*
				 echo $this->Form->postLink($curriculum['Curriculum']['lock']==0 ? 'lock':'unlock', array('action' => 'lock', $curriculum['Curriculum']['id']), array('confirm' => __('Are you sure you want to '.$lock.' # %s ?', $curriculum['Curriculum']['name']))); 
				 */
				 
				/*
				
			*/
			/*
			  echo $this->Form->postLink($curriculum['Curriculum']['registrar_approved']==0 ? 'Pending Approval':'Approved', array('action' => 'approve', $curriculum['Curriculum']['id']), array('confirm' => __('Are you sure you want to '.$curapp.' # %s ?', $curriculum['Curriculum']['name']))); 
			  */
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
</div>
</div>
</div>
