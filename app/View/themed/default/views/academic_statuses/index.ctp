<div class="academicStatuses index">
	<h2><?php __('List of Academic Status');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th style="width:75%"><?php echo $this->Paginator->sort('Acdamic Status', 'name');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($academicStatuses as $academicStatus):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $academicStatus['AcademicStatus']['name']; ?>&nbsp;</td>
		
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
