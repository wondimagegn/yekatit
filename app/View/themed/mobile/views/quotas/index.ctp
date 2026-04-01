<div class="quotas index">
	<h2><?php __('Quotas');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('college_id');?></th>
			<th><?php echo $this->Paginator->sort('female');?></th>
			<th><?php echo $this->Paginator->sort('regions');?></th>
			<th><?php //echo $this->Paginator->sort('developing_regions_id');?></th>
			<th><?php echo $this->Paginator->sort('academicyear');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($quotas as $quota):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $quota['Quota']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($quota['College']['name'], array('controller' => 'colleges', 'action' => 'view', $quota['College']['id'])); ?>
		</td>
		<td><?php echo $quota['Quota']['female']; ?>&nbsp;</td>
		<td><?php echo $quota['Quota']['regions']; ?>&nbsp;</td>
		<td><?php //echo $quota['Quota']['developing_regions_id']; ?>&nbsp;</td>
		<td><?php echo $quota['Quota']['academicyear']; ?>&nbsp;</td>
		<td><?php echo $quota['Quota']['created']; ?>&nbsp;</td>
		<td><?php echo $quota['Quota']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $quota['Quota']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $quota['Quota']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $quota['Quota']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $quota['Quota']['id'])); ?>
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

