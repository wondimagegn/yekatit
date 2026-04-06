<div class="gradeTypes index">
	<div class="smallheading"><?php __('Grade Types');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th style="width:2%">S.No</th>
			<th style="width:38%"><?php echo $this->Paginator->sort('type');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('Date Created', 'created');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('Date Modified', 'modified');?></th>
			<th style="width:20%; text-align:center" class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count=1;
	foreach ($gradeTypes as $gradeType):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++;?></td>
		<td><?php echo $gradeType['GradeType']['type']; ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($gradeType['GradeType']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($gradeType['GradeType']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $gradeType['GradeType']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $gradeType['GradeType']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $gradeType['GradeType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gradeType['GradeType']['id'])); ?>
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
