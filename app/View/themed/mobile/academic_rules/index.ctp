<div class="academicRules index">
	<h2><?php __('Academic Rules');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('from');?></th>
			<th><?php echo $this->Paginator->sort('to');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	
	foreach ($academicRules as $academicRule):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $academicRule['AcademicRule']['id']; ?>&nbsp;</td>
		<td><?php echo $academicRule['AcademicRule']['name']; ?>&nbsp;</td>
		<td><?php echo $academicRule['AcademicRule']['from']; ?>&nbsp;</td>
		<td><?php echo $academicRule['AcademicRule']['to']; ?>&nbsp;</td>
		<td><?php echo $academicRule['AcademicRule']['created']; ?>&nbsp;</td>
		<td><?php echo $academicRule['AcademicRule']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $academicRule['AcademicRule']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $academicRule['AcademicRule']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $academicRule['AcademicRule']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $academicRule['AcademicRule']['id'])); ?>
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
