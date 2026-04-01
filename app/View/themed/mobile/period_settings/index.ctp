<div class="periodSettings index">
	<!-- <h2><?php __('Period Settings');?></h2> -->
	<div class="smallheading"><?php __('Period Setting Lists'); ?></div>
	<?php echo "<div class='font'>".$college_name."</div>"; ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo 'S.N<u>o</u>';?></th>
			<!--<th><?php echo $this->Paginator->sort('college_id');?></th> -->
			<th><?php echo $this->Paginator->sort('period');?></th>
			<th><?php echo $this->Paginator->sort('Starting Time');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count = $this->Paginator->counter('%start%');
	foreach ($periodSettings as $periodSetting):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<!-- <td>
			<?php echo $this->Html->link($periodSetting['College']['name'], array('controller' => 'colleges', 'action' => 'view', $periodSetting['College']['id'])); ?>
		</td> --> 
		<td><?php echo $periodSetting['PeriodSetting']['period']; ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_hour($periodSetting['PeriodSetting']['hour']); ?>&nbsp;</td>
		<td class="actions">
			<!--<?php echo $this->Html->link(__('View', true), array('action' => 'view', $periodSetting['PeriodSetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $periodSetting['PeriodSetting']['id'])); ?> -->
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $periodSetting['PeriodSetting']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $periodSetting['PeriodSetting']['hour'])); ?>
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
