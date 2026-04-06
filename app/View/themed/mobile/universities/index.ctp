<div class="universities index">
	<div class="smallheading"><?php __('University Name Management');?></div>
	<table cellpadding="0" cellspacing="0">

	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('amharic_name');?></th>
			<th><?php echo $this->Paginator->sort('short_name');?></th>
			<th><?php echo $this->Paginator->sort('amharic_short_name');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
		
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($universities as $university):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $university['University']['name']; ?>&nbsp;</td>
		<td><?php echo $university['University']['amharic_name']; ?>&nbsp;</td>
		<td><?php echo $university['University']['short_name']; ?>&nbsp;</td>
		<td><?php echo $university['University']['amharic_short_name']; ?>&nbsp;</td>
		<td><?php echo $university['University']['academic_year']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $university['University']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $university['University']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $university['University']['id']), null, sprintf(__('Are you sure you want to delete "%s" university name?', true), $university['University']['name'])); ?>
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
