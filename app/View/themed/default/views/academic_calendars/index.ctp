<div class="academicCalendars index">
	<h2><?php __('Academic Calendars');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('No.','id');?></th>
			<th><?php echo $this->Paginator->sort('Academic Year-Semester','full_year');?></th>
			
			<th><?php echo $this->Paginator->sort('Year Level','year_name');?></th>
			<th><?php echo $this->Paginator->sort('Department','department_name');?></th>
			<th><?php echo $this->Paginator->sort('program_id');?></th>
			<th><?php echo $this->Paginator->sort('program_type_id');?></th>
		
			
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count=1;
	foreach ($academicCalendars as $academicCalendar):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td><?php echo $academicCalendar['AcademicCalendar']['full_year']; ?>&nbsp;</td>
		
		<td>
			<?php echo $this->Html->link($academicCalendar['AcademicCalendar']['year_name'], array('action' => 'view', $academicCalendar['AcademicCalendar']['id'])); ?>
		</td> 
		<td>
			<?php echo $this->Html->link($academicCalendar['AcademicCalendar']['department_name'], array('action' => 'view', $academicCalendar['AcademicCalendar']['id'])); ?>
		</td> 
		<td>
			<?php echo $this->Html->link($academicCalendar['Program']['name'], array('controller' => 'programs', 'action' => 'view', $academicCalendar['Program']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($academicCalendar['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $academicCalendar['ProgramType']['id'])); ?>
		</td>
	
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $academicCalendar['AcademicCalendar']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $academicCalendar['AcademicCalendar']['id'])); ?>
			
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
