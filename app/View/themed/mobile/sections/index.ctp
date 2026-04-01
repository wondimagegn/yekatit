<?php 
 echo $this->Form->create('Section');  
?>
<div class="sections index">
	<div class="centeralign_smallheading"><?php __('List of Sections');?></div>

	<table cellpadding="0" cellspacing="0">
	<?php 
       	echo '<tr><td class="font"> Academic Year</td>';
        echo '<td>'.$this->Form->input('Section.academicyearSearch',array('id'=>'academicyearSearch', 'label' => false,'type'=>'select','options'=>$acyear_array_data, 'empty'=>"All", 'style'=>'width:150PX')).'</td>'; 
       	echo '<td class="font"> Program</td>';
        echo '<td>'. $this->Form->input('Section.program_id',array('label'=>false, 'empty'=>"All", 'style'=>'width:150PX')).'</td>';
        echo '<td class="font"> Program Type</td>'; 
        echo '<td>'. $this->Form->input('Section.program_type_id',array('label'=>false, 'empty'=>"All", 'style'=>'width:150PX')).'</td><tr>'; 
		echo "<tr>";
        if(ROLE_COLLEGE == $role_id ){  
        	echo '<td class="font"> Department</td>';
        	echo '<td >'. $this->Form->input('Section.department_id',array('label'=>false, 'id'=>'ajax_department_id_section','empty'=>'All', 'style'=>'width:150PX')).'</td>'; 
        } 
        echo '<td class="font"> Year Level</td>';
        echo '<td id="ajax_year_level_section">'. $this->Form->input(
				'Section.year_level_id',array('label'=>false,'id'=>'ajax_year_level_s',
				'empty'=>'All', 'style'=>'width:150PX')).'</td></tr>'; 
        echo '<tr><td colspan="6">'. $this->Form->Submit('Search',array('name'=>'search','div'=>false)).'</td></tr>'; 
 ?> 
</table>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<!-- <th><?php echo $this->Paginator->sort('college_id');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th> -->
			<th><?php echo $this->Paginator->sort('year_level_id');?></th>
            <th><?php echo $this->Paginator->sort('program_id');?></th>
			<th><?php echo $this->Paginator->sort('program_type_id');?></th>
			<th><?php echo $this->Paginator->sort('academicyear');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($sections as $section):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $section['Section']['name']; ?>&nbsp;</td>
		<!--- <td>
			<?php echo $this->Html->link($section['College']['name'], array('controller' => 'colleges', 'action' => 'view', $section['College']['id'])); ?>
		</td> 
		<td>
			<?php echo $this->Html->link($section['Department']['name'], array('controller' => 'departments', 'action' => 'view', $section['Department']['id'])); ?>
		</td> --->
        <td><?php echo $section['YearLevel']['name']; ?>&nbsp;</td>
        <td><?php echo $section['Program']['name']; ?>&nbsp;</td>
        <td><?php echo $section['ProgramType']['name']; ?>&nbsp;</td>
		<td><?php echo $section['Section']['academicyear']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $section['Section']['id'])); ?>
			<?php //echo $this->Html->link(__('Edit', true), array('action' => 'edit', $section['Section']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $section['Section']['id']), null, sprintf(__('Are you sure you want to delete %s?', true), $section['Section']['name'])); ?>
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
<?php echo $this->Form->end();?>
