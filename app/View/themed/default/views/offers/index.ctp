<div class="offers index">
	<h2><?php __('Offers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<th><?php echo $this->Paginator->sort('program_type_id');?></th>
			<th><?php echo $this->Paginator->sort('acadamicyear');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($offers as $offer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $offer['Offer']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($offer['Department']['name'], array('controller' => 'departments', 'action' => 'view', $offer['Department']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($offer['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $offer['ProgramType']['id'])); ?>
		</td>
		<td><?php echo $offer['Offer']['acadamicyear']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $offer['Offer']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $offer['Offer']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $offer['Offer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $offer['Offer']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Offer', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Departments', true), array('controller' => 'departments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Department', true), array('controller' => 'departments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Program Types', true), array('controller' => 'program_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Program Type', true), array('controller' => 'program_types', 'action' => 'add')); ?> </li>
	</ul>
</div>