<div class="otherAcademicRules index">
	<h2><?php echo __('Other Academic Rules'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('curriculum_id'); ?></th>
			<th><?php echo $this->Paginator->sort('course_id'); ?></th>
			<th><?php echo $this->Paginator->sort('academic_statuse_id'); ?></th>
			<th><?php echo $this->Paginator->sort('grade'); ?></th>
			<th><?php echo $this->Paginator->sort('number_courses'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($otherAcademicRules as $otherAcademicRule): ?>
	<tr>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['id']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['curriculum_id']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['course_id']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['academic_statuse_id']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['grade']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['number_courses']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['created']); ?>&nbsp;</td>
		<td><?php echo h($otherAcademicRule['OtherAcademicRule']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $otherAcademicRule['OtherAcademicRule']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $otherAcademicRule['OtherAcademicRule']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $otherAcademicRule['OtherAcademicRule']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $otherAcademicRule['OtherAcademicRule']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Other Academic Rule'), array('action' => 'add')); ?></li>
	</ul>
</div>
