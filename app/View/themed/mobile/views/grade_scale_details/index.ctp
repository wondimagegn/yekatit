
<div class="gradeScaleDetails index">

	<h2><?php __('Grade Scale Details');?></h2>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('minimum_result');?></th>
			<th><?php echo $this->Paginator->sort('maximum_result');?></th>
			<th><?php echo $this->Paginator->sort('grade_scale_id');?></th>
			<th><?php echo $this->Paginator->sort('grade_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($gradeScaleDetails as $gradeScaleDetail):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $gradeScaleDetail['GradeScaleDetail']['id']; ?>&nbsp;</td>
		<td><?php echo $gradeScaleDetail['GradeScaleDetail']['minimum_result']; ?>&nbsp;</td>
		<td><?php echo $gradeScaleDetail['GradeScaleDetail']['maximum_result']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($gradeScaleDetail['GradeScale']['name'], array('controller' => 'grade_scales', 'action' => 'view', $gradeScaleDetail['GradeScale']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($gradeScaleDetail['Grade']['id'], array('controller' => 'grades', 'action' => 'view', $gradeScaleDetail['Grade']['id'])); ?>
		</td>
		<td><?php echo $gradeScaleDetail['GradeScaleDetail']['created']; ?>&nbsp;</td>
		<td><?php echo $gradeScaleDetail['GradeScaleDetail']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $gradeScaleDetail['GradeScaleDetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $gradeScaleDetail['GradeScaleDetail']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $gradeScaleDetail['GradeScaleDetail']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gradeScaleDetail['GradeScaleDetail']['id'])); ?>
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
