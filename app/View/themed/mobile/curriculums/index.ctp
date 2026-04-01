<?php 
  //echo $this->Form->Create('Curriculum',array('action'=>'search'));
 echo $this->Form->Create('Curriculum');
?>
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


 	<div class="smallheading"><?php __('Curriculum search');?></div>
	<?php
     /*
	   
	   echo '<table><tr><td>';
        echo '<table class="fs13 small_padding">';	
        if ($role_id== ROLE_DEPARTMENT) {
          
        echo '<tr><td style="width:26%"> Program</td><td  style="width:74%">'.$this->Form->input('Search.program_id',array('empty'=>' ','id'=>'ProgramId','label'=>false)).'</td></tr>';
        
        } else {
          echo '<tr><td style="width:13%">Program</td><td  style="width:37%">';
          echo $this->Form->input('Search.program_id',
          array('empty'=>' ','label'=>false,'id'=>'program_id_1')).'</td>';
          echo '<td style="width:13%"> Department';
          echo '</td>';
          echo '<td style="width:37%">';
          echo $this->Form->input('Search.department_id',
          array('empty'=>' ','id'=>'department_id_1','onchange'=>'updateCurriculum(1)','label'=>false,
          'style'=>'width:300px'));
          echo '</td>';
          echo '</tr>';
          
          echo '<tr><td style="width:13%">&nbsp;</td><td  style="width:37%">';
          
          echo '</td>';
          echo '<td style="width:13%"> Curriculum ';
          echo '</td>';
          echo '<td style="width:37%">';
          echo $this->Form->input('Search.curriculum_id',
          array('empty'=>' ','options'=>$curr_list,'style'=>'width:300px','id'=>'curriculum_id_1','label'=>false));
          echo '</td>';
          echo '</tr>';
        
        }
        
      
  		echo '</table>';
		echo '</td><td>';
		echo '<table>';
	
		echo '</table>';
		echo '</td></tr>';
		echo '</table>';
		
		echo $this->Form->submit('Search');
	*/	
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
			<?php 
			 /*echo $this->Form->input('Search.curriculum_id',array('empty'=>' ',
	    'id'=>"curriculum_id",'label'=>false));
	    */
			?>		
			</td>
		</tr>
	

		<tr>
			<td colspan="4"><?php echo $this->Form->submit(__('Get Curriculums', true), 
			array('name' => 'search', 'id' => 'getCurriculums', 'div' => false)); ?></td>
		</tr>
	</table>
	
<div class="curriculums index">
	
<?php 
     if (!empty($result_curriculums)) {
?>
<div class="smallheading"><?php __('Curriculums');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('Name','name');?></th>
			<th><?php echo $this->Paginator->sort('Year Introduced','year_introduced');?></th>
			<th><?php echo $this->Paginator->sort('Type Credit','type_credit');?></th>
			<th><?php echo $this->Paginator->sort('Amharic Degree Nomenclature','amharic_degree_nomenclature');?></th>
			<th><?php echo $this->Paginator->sort('English Degree Nomenclature','english_degree_nomenclature');?></th>
			<th><?php echo $this->Paginator->sort('Minimum Credit Point Required','minimum_credit_points');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			
			<th class="actions"><?php __('Actions');?></th>
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
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $curriculum['Curriculum']['id'])); ?>
			<?php if ($role_id == ROLE_DEPARTMENT ) {?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $curriculum['Curriculum']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $curriculum['Curriculum']['id']), null, sprintf(__('Are you sure you want to delete  %s?', true), $curriculum['Curriculum']['name'].''.$curriculum['Curriculum']['year_introduced'])); ?>
			
			<?php } ?>
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
<?php echo $this->Form->end();?>
