<div class="votes index">
	<h2><?php __('Votes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('task');?></th>
			<th><?php echo $this->Paginator->sort('requester_user_id');?></th>
			<th><?php echo $this->Paginator->sort('applicable_on_user_id');?></th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th><?php echo $this->Paginator->sort('confirmation');?></th>
			<th><?php echo $this->Paginator->sort('confirmation_date');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($votes as $vote):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $vote['Vote']['id']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['task']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['requester_user_id']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['applicable_on_user_id']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['data']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['confirmation']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['confirmation_date']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['created']; ?>&nbsp;</td>
		<td><?php echo $vote['Vote']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $vote['Vote']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $vote['Vote']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $vote['Vote']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $vote['Vote']['id'])); ?>
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
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Vote', true), array('action' => 'add')); ?></li>
	</ul>
</div>