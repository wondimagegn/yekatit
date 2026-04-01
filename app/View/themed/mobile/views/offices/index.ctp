<div class="offices index">
	<h2><?php __('Clearance Offices');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('telephone');?></th>
			<th><?php echo $this->Paginator->sort('alternative_telephone');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('alternative_email');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($offices as $office):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $office['Office']['name']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['address']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['telephone']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['alternative_telephone']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['email']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['alternative_email']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['created']; ?>&nbsp;</td>
		<td><?php echo $office['Office']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $office['Office']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $office['Office']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $office['Office']['id']), null, sprintf(__('Are you sure you want to delete  %s?', true), $office['Office']['name'])); ?>
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
