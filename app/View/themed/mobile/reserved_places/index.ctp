<table cellpadding="0" cellspacing="0"><tr> 
	<?php echo $this->Form->create('ReservedPlace', array('action' => 'index'));?> 
	<td> <?php echo $this->Form->input('ReservedPlace.department_id',array('label'=>'Department'));
			echo $this->Form->input('ReservedPlace.academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($selected)?$selected:'')); ?>
	</td></tr>
	<tr><td><?php echo $this->Form->end(__('Search',true)); ?> </td>	
</tr></table>
<?php 
if(!empty($reservedPlaces)){


?>
 <div class="reservedPlaces index">
	<h2><?php __('Reserved Places');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			
			<th><?php echo $this->Paginator->sort('Result Category','placements_results_criteria_id');?></th>
			<th><?php echo $this->Paginator->sort('Department','participating_department_id');?></th>
			<th><?php echo $this->Paginator->sort('college_id');?></th>
			<th><?php echo $this->Paginator->sort('Department Capacity','number');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('Academic Year','academicyear');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($reservedPlaces as $reservedPlace):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		
		<!--<td>
			<?php echo $this->Html->link($reservedPlace['PlacementsResultsCriteria']['name'], array('controller' => 'placements_results_criterias', 'action' => 'view', $reservedPlace['PlacementsResultsCriteria']['id'])); ?>
		</td> -->
		<td>
			<?php echo $this->Html->link($reservedPlace['PlacementsResultsCriteria']['result_category'], array('controller' => 'placements_results_criterias', 'action' => 'view', $reservedPlace['PlacementsResultsCriteria']['id'])).')'; ?>
		</td>
		<td>
			<?php echo $this->Html->link($reservedPlace['ReservedPlace']['participating_department_name'], array('controller' => 'departments', 'action' => 'view', $reservedPlace['ReservedPlace']['participating_department_id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($reservedPlace['College']['name'], array('controller' => 'colleges', 'action' => 'view', $reservedPlace['College']['id'])); ?>
		</td>
		<td><?php echo $reservedPlace['ReservedPlace']['number']; ?>&nbsp;</td>
		<td><?php echo $reservedPlace['ReservedPlace']['description']; ?>&nbsp;</td>
		<td><?php echo $reservedPlace['ReservedPlace']['academicyear']; ?>&nbsp;</td>
		<td><?php echo $reservedPlace['ReservedPlace']['created']; ?>&nbsp;</td>
		<td><?php echo $reservedPlace['ReservedPlace']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $reservedPlace['ReservedPlace']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $reservedPlace['ReservedPlace']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $reservedPlace['ReservedPlace']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $reservedPlace['ReservedPlace']['id'])); ?>
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
<?php 
} 

?>
