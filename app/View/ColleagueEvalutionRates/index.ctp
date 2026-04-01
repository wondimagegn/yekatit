<div class="colleagueEvalutionRates index">
	<h2><?php echo __('Colleague Evalution Rates'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('instructor_evalution_question_id'); ?></th>
			<th><?php echo $this->Paginator->sort('staff_id'); ?></th>
			<th><?php echo $this->Paginator->sort('dept_head'); ?></th>
			<th><?php echo $this->Paginator->sort('academic_year'); ?></th>
			<th><?php echo $this->Paginator->sort('rating'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($colleagueEvalutionRates as $colleagueEvalutionRate): ?>
	<tr>
		<td><?php echo h($colleagueEvalutionRate['ColleagueEvalutionRate']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($colleagueEvalutionRate['InstructorEvalutionQuestion']['id'], array('controller' => 'instructor_evalution_questions', 'action' => 'view', $colleagueEvalutionRate['InstructorEvalutionQuestion']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($colleagueEvalutionRate['Staff']['id'], array('controller' => 'staffs', 'action' => 'view', $colleagueEvalutionRate['Staff']['id'])); ?>
		</td>
		<td><?php echo h($colleagueEvalutionRate['ColleagueEvalutionRate']['dept_head']); ?>&nbsp;</td>
		<td><?php echo h($colleagueEvalutionRate['ColleagueEvalutionRate']['academic_year']); ?>&nbsp;</td>
		<td><?php echo h($colleagueEvalutionRate['ColleagueEvalutionRate']['rating']); ?>&nbsp;</td>
		<td><?php echo h($colleagueEvalutionRate['ColleagueEvalutionRate']['created']); ?>&nbsp;</td>
		<td><?php echo h($colleagueEvalutionRate['ColleagueEvalutionRate']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $colleagueEvalutionRate['ColleagueEvalutionRate']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $colleagueEvalutionRate['ColleagueEvalutionRate']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $colleagueEvalutionRate['ColleagueEvalutionRate']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $colleagueEvalutionRate['ColleagueEvalutionRate']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Colleague Evalution Rate'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Instructor Evalution Questions'), array('controller' => 'instructor_evalution_questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Instructor Evalution Question'), array('controller' => 'instructor_evalution_questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staffs'), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff'), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
	</ul>
</div>
