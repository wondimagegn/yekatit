<?php 
  echo $this->Form->Create('CostShare',array('action'=>'search'));
?>
<script type='text/javascript'>
function updateSection(id) {
           
            //serialize form data
            var formData = $("#department_id_"+id).val();
			$("#section_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled',true);	
					//get form action
			var formUrl = '/sections/get_sections_by_dept/'+formData;
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data,textStatus,xhr){
						$("#section_id_"+id).attr('disabled', false);
					    $("#department_id_"+id).attr('disabled',false);	
						$("#section_id_"+id).empty();
						$("#section_id_"+id).append(data);
						
				},
				error: function(xhr,textStatus,error){
						alert(textStatus);
				}
			});
			return false;
 }
 
function updateCollegeSection(id) {
           
            //serialize form data
            var formData = $("#college_id_"+id).val();
			$("#college_id_"+id).attr('disabled', true);
			
			$("#section_id_"+id).attr('disabled', true);
			
			
			//get form action
			var formUrl = '/sections/get_sections_of_college/'+formData;
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data,textStatus,xhr){
						
						$("#section_id_"+id).attr('disabled', false);
                       $("#college_id_"+id).attr('disabled', false);
						$("#section_id_"+id).empty();
						$("#section_id_"+id).append(data);
						
				},
				error: function(xhr,textStatus,error){
						alert(textStatus);
				}
			});

			return false;
      
}

</script>
<?php  if ($role_id != ROLE_STUDENT) { ?>
 	<div class="smallheading"><?php __('CostShare  search');?></div>
	<?php

	   
	    echo '<table><tr><td>';
        echo '<table class="fs13 small_padding">';	
        ?>
       <tr>
			<td style="width:13%">Academic Year:</td>
			<td style="width:37%"><?php echo $this->Form->input('Search.academic_year',array(
			'empty'=>' ','options'=>$acyear_array_data,'label'=>false));?></td>
        <?php 
        if (isset($college_ids) && !empty($college_ids)) {
        ?>
            <td style="width:13%">College:</td>
        <?php 
            echo '<td  style="width:37%">'.$this->Form->input('Search.college_id',array('empty'=>' ',
        'id'=>'college_id_1','onchange'=>'updateCollegeSection(1)','label'=>false,
        'style'=>'width:250px')).'</td>';
        
        } else {
        ?>
          <td style="width:13%">Department:</td>
        <?php 
           echo '<td style="width:37%">'.$this->Form->input('Search.department_id',array('empty'=>' ',
        'id'=>'department_id_1','onchange'=>'updateSection(1)','label'=>false,
        'style'=>'width:250px')).'</td>';
        
        }
        ?>
		</tr>
		
		<tr>
			<td style="width:13%">Student Name:</td>
			<td style="width:37%"><?php echo $this->Form->input('Search.name',array('empty'=>' ','label'=>false));?></td>
            <td style="width:13%">Section:</td>
			<td style="width:37%"><?php 
		           echo $this->Form->input('Search.section_id',array('empty'=>'','id'=>'section_id_1',
		           'label'=>false));
			?></td>
		</tr>
		<?php 
       /* echo '<tr><td>'.$this->Form->input('Search.academic_year',array('empty'=>' ',
        'options'=>$acyear_array_data)).'</td>';
        
        echo '<td>';
        if (isset($college_ids) && !empty($college_ids)) {
           echo $this->Form->input('Search.college_id',array('empty'=>' ',
        'id'=>'college_id_1','onchange'=>'updateCollegeSection(1)'));
        
        } else {
           echo $this->Form->input('Search.department_id',array('empty'=>' ',
        'id'=>'department_id_1','onchange'=>'updateSection(1)'));
        
        }
        
        
        echo '</td></tr>';
        echo '<tr><td>'.$this->Form->input('Search.name',array('empty'=>' ')).'</td><td>'.
        $this->Form->input('Search.section_id',array('empty'=>'','id'=>'section_id_1')).'</td></tr>';
		*/
  		echo '</table>';
		echo '</td><td>';
		
		echo '</td></tr>';
		echo '</table>';
		
		echo $this->Form->submit('Search');
	}
	?>
<?php echo $this->Form->end();?>

<div class="costShares index">
<?php if (!empty($costShares)) { ?>
	<div class="smallheading"><?php __('Cost Shares');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('education_fee');?></th>
			<th><?php echo $this->Paginator->sort('accomodation_fee');?></th>
			<th><?php echo $this->Paginator->sort('cafeteria_fee');?></th>
			<th><?php echo $this->Paginator->sort('medical_fee');?></th>
			<th><?php echo $this->Paginator->sort('cost_sharing_sign_date');?></th>
		     <?php 
		 if ($role_id != ROLE_STUDENT ) {
		?>	
			<th class="actions"><?php __('Actions');?></th>
	
	    <?php 
	        }
	    ?>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($costShares as $costShare):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($costShare['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $costShare['Student']['id'])); ?>
		</td>
		<td><?php echo $costShare['CostShare']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $costShare['CostShare']['education_fee']; ?>&nbsp;</td>
		<td><?php echo $costShare['CostShare']['accomodation_fee']; ?>&nbsp;</td>
		<td><?php echo $costShare['CostShare']['cafeteria_fee']; ?>&nbsp;</td>
		<td><?php echo $costShare['CostShare']['medical_fee']; ?>&nbsp;</td>
		<td><?php echo $costShare['CostShare']['cost_sharing_sign_date']; ?>&nbsp;</td>
		<?php 
		 if ($role_id != ROLE_STUDENT ) {
		?>
		<td class="actions">
			<?php
			
			  
			//echo $this->Html->link(__('View', true), array('action' => 'view', $costShare['CostShare']['id'])); 
		   echo $this->Html->link(__('Edit', true), array('action' => 'edit', $costShare['CostShare']['id'])); 
			
			?>
		</td>
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
