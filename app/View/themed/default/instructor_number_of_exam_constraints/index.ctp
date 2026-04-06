<div class="instructorNumberOfExamConstraints index">
	<h2><?php __('Instructor Number Of Exam Constraints');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('staff_id');?></th>
			<th><?php echo $this->Paginator->sort('staff_for_exam_id');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th><?php echo $this->Paginator->sort('year_level_id');?></th>
			<th><?php echo $this->Paginator->sort('max_number_of_exam');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($instructorNumberOfExamConstraints as $instructorNumberOfExamConstraint):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($instructorNumberOfExamConstraint['Staff']['id'], array('controller' => 'staffs', 'action' => 'view', $instructorNumberOfExamConstraint['Staff']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($instructorNumberOfExamConstraint['StaffForExam']['staff_id'], array('controller' => 'staff_for_exams', 'action' => 'view', $instructorNumberOfExamConstraint['StaffForExam']['id'])); ?>
		</td>
		<td><?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['semester']; ?>&nbsp;</td>
		<td><?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['year_level_id']; ?>&nbsp;</td>
		<td><?php echo $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['max_number_of_exam']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $instructorNumberOfExamConstraint['InstructorNumberOfExamConstraint']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Instructor Number Of Exam Constraint', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Staffs', true), array('controller' => 'staffs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff', true), array('controller' => 'staffs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Staff For Exams', true), array('controller' => 'staff_for_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Staff For Exam', true), array('controller' => 'staff_for_exams', 'action' => 'add')); ?> </li>
	</ul>
</div>