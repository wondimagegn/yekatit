<div class="grades form">
<?php echo $this->Form->create('Grade');?>
	<fieldset>
		<legend><?php __('Edit Grade'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('grade');
		echo $this->Form->input('grade_type_id');
		echo $this->Form->input('point_value');
		echo $this->Form->input('pass_grade');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="grades index">
	<h2><?php __('Grades');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			
			<th><?php echo __('Grade',true);?></th>
			<th><?php echo __('Grade Type',true);?></th>
			<th><?php echo __('Point Value',true);?></th>
			<th><?php echo __('Pass/Fail',true);?></th>
			<th><?php echo __('Active',true);?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($gradesss as $grade):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $grade['Grade']['id']; ?>&nbsp;</td>
		<td><?php echo $grade['Grade']['grade']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($grade['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view', $grade['GradeType']['id'])); ?>
		</td>
		<td><?php echo $grade['Grade']['point_value']; ?>&nbsp;</td>
		<td><?php echo $grade['Grade']['pass_grade']; ?>&nbsp;</td>
		<td><?php echo $grade['Grade']['active']; ?>&nbsp;</td>
		<td><?php echo $grade['Grade']['created']; ?>&nbsp;</td>
		<td><?php echo $grade['Grade']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $grade['Grade']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $grade['Grade']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $grade['Grade']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $grade['Grade']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
