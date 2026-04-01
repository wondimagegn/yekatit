<div class="regions index">
	<h2><?php __('Regions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('short');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('country_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($regions as $region):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++ ;?>&nbsp;</td>
		<td><?php echo $region['Region']['name']; ?>&nbsp;</td>
		<td><?php echo $region['Region']['short']; ?>&nbsp;</td>
		<td><?php echo $region['Region']['description']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($region['Country']['name'], array('controller' => 'countries', 'action' => 'view', $region['Country']['id'])); ?>
		</td>
		<td><?php echo $region['Region']['created']; ?>&nbsp;</td>
		<td><?php echo $region['Region']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $region['Region']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $region['Region']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $region['Region']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $region['Region']['id'])); ?>
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
