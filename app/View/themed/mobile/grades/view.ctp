<div class="grades view">
<h2><?php  __('Grade');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['grade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Grade Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($grade['GradeType']['name'], array('controller' => 'grade_types', 'action' => 'view', $grade['GradeType']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Point Value'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['point_value']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pass Grade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['pass_grade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['active']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $grade['Grade']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Grade', true), array('action' => 'edit', $grade['Grade']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Grade', true), array('action' => 'delete', $grade['Grade']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $grade['Grade']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Grades', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Grade Types', true), array('controller' => 'grade_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade Type', true), array('controller' => 'grade_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Grade Scale Details', true), array('controller' => 'grade_scale_details', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grade Scale Detail', true), array('controller' => 'grade_scale_details', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Grade Scale Details');?></h3>
	<?php if (!empty($grade['GradeScaleDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Minimum Result'); ?></th>
		<th><?php __('Maximum Result'); ?></th>
		<th><?php __('Grade Scale Id'); ?></th>
		<th><?php __('Grade Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($grade['GradeScaleDetail'] as $gradeScaleDetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $gradeScaleDetail['id'];?></td>
			<td><?php echo $gradeScaleDetail['minimum_result'];?></td>
			<td><?php echo $gradeScaleDetail['maximum_result'];?></td>
			<td><?php echo $gradeScaleDetail['grade_scale_id'];?></td>
			<td><?php echo $gradeScaleDetail['grade_id'];?></td>
			<td><?php echo $gradeScaleDetail['created'];?></td>
			<td><?php echo $gradeScaleDetail['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'grade_scale_details', 'action' => 'view', $gradeScaleDetail['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'grade_scale_details', 'action' => 'edit', $gradeScaleDetail['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'grade_scale_details', 'action' => 'delete', $gradeScaleDetail['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gradeScaleDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
