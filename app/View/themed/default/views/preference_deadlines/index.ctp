<div class="preferenceDeadlines index">
	<h3><?php __('Student Department Placement Preference Submition Deadline');?></h3>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('deadline');?></th>
			<th><?php echo $this->Paginator->sort('Academic Year', 'academicyear');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions" style="text-align:center""><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($preferenceDeadlines as $preferenceDeadline):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $preferenceDeadline['PreferenceDeadline']['deadline']; ?>&nbsp;</td>
		<td><?php echo $preferenceDeadline['PreferenceDeadline']['academicyear']; ?>&nbsp;</td>
		<td><?php echo $preferenceDeadline['PreferenceDeadline']['created']; ?>&nbsp;</td>
		<td><?php echo $preferenceDeadline['PreferenceDeadline']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $preferenceDeadline['PreferenceDeadline']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $preferenceDeadline['PreferenceDeadline']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $preferenceDeadline['PreferenceDeadline']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $preferenceDeadline['PreferenceDeadline']['id'])); ?>
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
