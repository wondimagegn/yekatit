<div class="higherEducationBackgrounds index">
	<h2><?php __('Higher Education Backgrounds');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('field_of_study');?></th>
			<th><?php echo $this->Paginator->sort('diploma_awarded');?></th>
			<th><?php echo $this->Paginator->sort('date_graduated');?></th>
			<th><?php echo $this->Paginator->sort('cgpa_at_graduation');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($higherEducationBackgrounds as $higherEducationBackground):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['id']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['name']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['field_of_study']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['diploma_awarded']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['date_graduated']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['cgpa_at_graduation']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['city']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['created']; ?>&nbsp;</td>
		<td><?php echo $higherEducationBackground['HigherEducationBackground']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $higherEducationBackground['HigherEducationBackground']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $higherEducationBackground['HigherEducationBackground']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $higherEducationBackground['HigherEducationBackground']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $higherEducationBackground['HigherEducationBackground']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Higher Education Background', true), array('action' => 'add')); ?></li>
	</ul>
</div>