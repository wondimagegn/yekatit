<div class="participatingDepartments index">
	<h3><?php __('Participating Departments in the Student Auto Placement to Department');?></h3>
	<table cellpadding="0" cellspacing="0">
	<tr>
	        <th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('college_id');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<!-- <th><?php echo $this->Paginator->sort('other_college_department');?></th> -->
			<th><?php echo $this->Paginator->sort('number');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions" style="text-align:center"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start=$this->Paginator->counter('%start%');
	foreach ($participatingDepartments as $participatingDepartment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
	    <td><?php echo $start++;?></td>
		<td>
			<?php echo $this->Html->link($participatingDepartment['College']['name'], array('controller' => 'colleges', 'action' => 'view', $participatingDepartment['College']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($participatingDepartment['Department']['name'], array('controller' => 'departments', 'action' => 'view', $participatingDepartment['Department']['id'])); ?>
		</td>
		<td>
			<?php echo $participatingDepartment['ParticipatingDepartment']['number']; ?>
		</td>
		<!--<td><?php echo $participatingDepartment['ParticipatingDepartment']['other_college_department']; ?>&nbsp;</td> -->
		<td><?php echo $participatingDepartment['ParticipatingDepartment']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $participatingDepartment['ParticipatingDepartment']['created']; ?>&nbsp;</td>
		<td><?php echo $participatingDepartment['ParticipatingDepartment']['modified']; ?>&nbsp;</td>
		<td class="actions">
			
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $participatingDepartment['ParticipatingDepartment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $participatingDepartment['ParticipatingDepartment']['id'])); ?>
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
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array('update' => '#ajax_div', 
'evalScripts' => true,
'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', 
array('buffer' => false)), 
'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>',array('update' => '#ajax_div', 
'evalScripts' => true,
'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', 
array('buffer' => false)), 
'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
), null, array('class' => 'disabled'));?>
		
	</div>
</div>
