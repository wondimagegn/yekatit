<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Year Levels');?>
		      </h2>
		</div>

                 <div class="large-12 columns">
		     <div class="yearLevels index">
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($yearLevels as $yearLevel):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++ ?>&nbsp;</td>
		<td><?php echo $yearLevel['YearLevel']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($yearLevel['Department']['name'], array('controller' => 'departments', 'action' => 'view', $yearLevel['Department']['id'])); ?>
		</td>
		<td><?php echo $yearLevel['YearLevel']['created']; ?>&nbsp;</td>
		<td><?php echo $yearLevel['YearLevel']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $yearLevel['YearLevel']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $yearLevel['YearLevel']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $yearLevel['YearLevel']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $yearLevel['YearLevel']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
		</div>
       </div>
    </div>
</div>
