<div class="graduationRequirements index">
	<div class="smallheading"><?php __('List of Graduation Requirements');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th style="width:10%"><?php echo $this->Paginator->sort('CGPA', 'cgpa');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('program_id');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('Admission Year', 'academic_year');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('Date Created', 'created');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('Date Modified', 'modified');?></th>
			<th style="width:10%; text-align:center" class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($graduationRequirements as $graduationRequirement):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $graduationRequirement['GraduationRequirement']['cgpa']; ?>&nbsp;</td>
		<td>
			<?php echo $graduationRequirement['Program']['name']; ?>
		</td>
		<td><?php echo $graduationRequirement['GraduationRequirement']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($graduationRequirement['GraduationRequirement']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($graduationRequirement['GraduationRequirement']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $graduationRequirement['GraduationRequirement']['id'])); ?>
			<?php //echo $this->Html->link(__('Delete', true), array('action' => 'delete', $graduationRequirement['GraduationRequirement']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $graduationRequirement['GraduationRequirement']['id'])); ?>
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
