<div class="excludedCourseFromTranscripts index">
	<h2><?php __('Excluded Course From Transcripts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('course_registration_id');?></th>
			<th><?php echo $this->Paginator->sort('course_exemption_id');?></th>
			<th><?php echo $this->Paginator->sort('minute_number');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($excludedCourseFromTranscripts as $excludedCourseFromTranscript):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($excludedCourseFromTranscript['CourseRegistration']['id'], array('controller' => 'course_registrations', 'action' => 'view', $excludedCourseFromTranscript['CourseRegistration']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($excludedCourseFromTranscript['CourseExemption']['id'], array('controller' => 'course_exemptions', 'action' => 'view', $excludedCourseFromTranscript['CourseExemption']['id'])); ?>
		</td>
		<td><?php echo $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['minute_number']; ?>&nbsp;</td>
		<td><?php echo $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['created']; ?>&nbsp;</td>
		<td><?php echo $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $excludedCourseFromTranscript['ExcludedCourseFromTranscript']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Excluded Course From Transcript', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Course Registrations', true), array('controller' => 'course_registrations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Registration', true), array('controller' => 'course_registrations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Exemptions', true), array('controller' => 'course_exemptions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course Exemption', true), array('controller' => 'course_exemptions', 'action' => 'add')); ?> </li>
	</ul>
</div>