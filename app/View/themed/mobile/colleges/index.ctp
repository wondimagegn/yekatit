<div class="colleges index">
	<h2><?php __('Colleges');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('campus_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('shortname');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($colleges as $college):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $college['College']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($college['Campus']['name'], array('controller' => 'campuses', 'action' => 'view', $college['Campus']['id'])); ?>
		</td>
		<td><?php echo $college['College']['name']; ?>&nbsp;</td>
		<td><?php echo $college['College']['shortname']; ?>&nbsp;</td>
		<td><?php echo $college['College']['description']; ?>&nbsp;</td>
		<td><?php echo $college['College']['type']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $college['College']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $college['College']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $college['College']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $college['College']['id'])); ?>
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
