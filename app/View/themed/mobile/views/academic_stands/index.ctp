<?php 
  echo $this->Form->Create('AcademicStand');
 
?>

 	<div class="smallheading"><?php __('Academic Stand and Rule search');?></div>
	<?php

	   
	   echo '<table><tr><td>';
        echo '<table>';	
              
        echo '<tr><td>'.$this->Form->input('Search.academic_year_from',array('empty'=>' ',
        'options'=>$acyear_array_data)).'</td></tr>';
		//$this->set(compact('acyear_array_data','defaultacademicyear'));
        echo '<tr><td>'.$this->Form->input('Search.program_id',array('empty'=>' ')).'</td></tr>';
  
  		echo '</table>';
		echo '</td>';
		
		echo '</tr>';
		echo '<tr><td>';
		 echo $this->Form->submit(__('View Academic Stand', true), array('name' => 'viewAcademicStand', 'id' => 'viewAcademicStand', 'div' => false));
		echo '</td></tr>';
		echo '</table>';
		
		//echo $this->Form->submit('Search');
		
		
	?>
	
<?php //echo $this->Form->end();?>

<div class="academicStands index">
<?php 
    if (isset($academicStands) && !empty($academicStands)) {
?>
	<div class="smallheading"><?php __('Academic Stands');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
	
			<th><?php echo $this->Paginator->sort('Program','program_id');?></th>
			<th><?php echo $this->Paginator->sort('Year Level','year_level_id');?></th>
			<th><?php echo $this->Paginator->sort('Semester','semester');?></th>
			
			<th><?php echo $this->Paginator->sort('Academic Status','academic_status_id');?></th>
			
			<th><?php echo $this->Paginator->sort('applicable_for_all_current_student');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($academicStands as $academicStand):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
       <td>		
			<?php echo $this->Html->link($academicStand['Program']['name'], array('controller' => 'programs', 'action' => 'view', $academicStand['Program']['id'])); ?>
		</td>
		<td><?php echo $academicStand['AcademicStand']['year_level_id']; ?>&nbsp;</td>
		<td><?php echo $academicStand['AcademicStand']['semester']; ?>&nbsp;</td>
		
		<td>
			<?php echo $this->Html->link($academicStand['AcademicStatus']['name'], array('controller' => 'academic_statuses', 'action' => 'view', $academicStand['AcademicStatus']['id'])); ?>
		</td>
		
		<td><?php echo $academicStand['AcademicStand']['applicable_for_all_current_student']==1?'Yes':'No'; ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($academicStand['AcademicStand']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($academicStand['AcademicStand']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $academicStand['AcademicStand']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $academicStand['AcademicStand']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $academicStand['AcademicStand']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $academicStand['AcademicStand']['id'])); ?>
		</td>
	</tr>
	<tr><td colspan=7>
	<?php 
	        if (!empty($academicStand['AcademicRule'])) {
	           ?>
	           <table cellpadding = "0" cellspacing = "0" border="5">
	<tr>
			<td><?php echo __('S.No');?></td>
			
			<td><?php echo __('Academic Status');?></td>
			
			<td><?php echo __('Semester GPA');?></td>
			<td><?php echo __('');?></td>
			<td><?php echo __('Cumulative GPA');?></td>
			<td><?php echo __('');?></td>
			<td><?php echo __('Two Consecutive Warning');?></td>
			
			<td><?php echo __('Probation Followed By Warning');?></td>
			
			<!-- <th class="actions"><?php __('Actions');?></th> -->
	</tr>
	<?php
		
		$count=1;
		foreach ($academicStand['AcademicRule'] as $academic):
			
		?>
	<tr>
		<td><?php echo $count++; ?>&nbsp;</td>
		
		<td>
			<?php echo $academicStand['AcademicStatus']['name'];?>
		</td>
		<td>
			<?php 
			 if (!empty($academic['sgpa']) && $academic['sgpa']>0) {
			    echo $academic['cmp_sgpa'];
			 }
			?>
		</td>
		
		<td>
			<?php echo $academic['operatorI'];?>
		</td>
		<td>
			<?php 
			    if (!empty($academic['cgpa']) && $academic['cgpa']>0) {
			         echo $academic['cmp_cgpa'];
			    }
			?>
		</td>
		<td>
			<?php echo $academic['operatorII'];?>
		</td>
		
		<td>
			<?php echo $academic['tcw']==1 ? 'Two Consecutive Warning' : '';?>
		</td>
		<td>
			<?php echo $academic['pfw']==1 ? 'Probation Followed By Warning' : '';?>
		</td>
		<!-- <td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $academic['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $academic['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $academic['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $academic['id'])); ?>
		</td> -->
	</tr>
	<?php endforeach; ?>
	</table>
	</td></tr>
	           <?php 
	        }
	?>
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
