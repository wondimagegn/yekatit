<div class="academicStatuses view">
<h2><?php  __('Academic Status');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStatus['AcademicStatus']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStatus['AcademicStatus']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $academicStatus['AcademicStatus']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Related Academic Stands');?></h3>
	<?php if (!empty($academicStatus['AcademicStand'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
			<th><?php echo __('S.No');?></th>
			
			<th><?php echo __('Program');?></th>
			<th><?php echo __('Year Level');?></th>
			<th><?php echo __('Semester');?></th>
			
			<th><?php echo __('Applicable for all current student');?></th>
	</tr>
	<?php
		$i = 0;
		$count=1;
		foreach ($academicStatus['AcademicStand'] as $academicStand):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		
		<td>
			<?php echo $this->Html->link($academicStand['program_name'], array('controller' => 'programs', 'action' => 'view', $academicStand['id'])); ?>
		</td>
		<td><?php echo $academicStand['year_level_id']; ?>&nbsp;</td>
		<td><?php echo $academicStand['semester']; ?>&nbsp;</td>
		
		<td><?php echo $academicStand['applicable_for_all_current_student']==1?'Yes':'No'; ?>&nbsp;</td>
		
		
	</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
