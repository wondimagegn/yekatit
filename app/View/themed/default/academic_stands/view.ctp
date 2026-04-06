<div class="academicStands view">
<h2><?php  __('Academic Stand');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Program'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($academicStand['Program']['name'], array('controller' => 'programs', 'action' => 'view', $academicStand['Program']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Year Level Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['year_level_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Semester'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['semester']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year From'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['academic_year_from']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Year To'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['academic_year_to']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Academic Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($academicStand['AcademicStatus']['name'], array('controller' => 'academic_statuses', 'action' => 'view', $academicStand['AcademicStatus']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sort Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['sort_order']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status Visible'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['status_visible']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Applicable For All Current Student'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStand['AcademicStand']['applicable_for_all_current_student']==1?'Yes':'No'; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicStand['AcademicStand']['created']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Format->humanize_date($academicStand['AcademicStand']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Related Academic Rule');?></h3>
	<?php if (!empty($academicStand['AcademicRule'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
			<th><?php echo __('S.No');?></th>
			
			<th><?php echo __('Academic Status');?></th>
			
			<th><?php echo __('Semester GPA');?></th>
			<th><?php echo __('');?></th>
			<th><?php echo __('Cumulative GPA');?></th>
			<th><?php echo __('');?></th>
			<th><?php echo __('Two Consecutive Warning');?></th>
			
			<th><?php echo __('Probation Followed By Warning');?></th>
			
			<!-- <th class="actions"><?php __('Actions');?></th> -->
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($academicStand['AcademicRule'] as $academic):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		
		<td>
			<?php echo $academicStand['AcademicStatus']['name'];?>
		</td>
		<td>
			<?php echo $academic['cmp_sgpa'];?>
		</td>
		
		<td>
			<?php echo $academic['operatorI'];?>
		</td>
		<td>
			<?php echo $academic['cmp_cgpa'];?>
		</td>
		<td>
			<?php echo $academic['operatorII'];?>
		</td>
		
		<td>
			<?php echo $academic['tcw']==1 ? 'Two Consecutive Warning' : '';?>
		</td>
		<td>
			<?php echo $academic['pfw']==1 ? 'Probation Followed By Warning' : '';?>
		</td>
		<!-- <td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $academic['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $academic['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $academic['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $academic['id'])); ?>
		</td> -->
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
