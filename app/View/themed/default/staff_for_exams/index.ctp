<div class="staffForExams index">
<?php echo $this->Form->create('StaffForExam');?>
	<div class="smallheading"><?php __('Staff For Exams (Invigilators From Other Colleges)');?></div>
	<div class="font"><?php echo 'Institute/College: '.$college_name?></div>
	<table cellpadding="0" cellspacing="0">
	<?php 
		echo '<tr><td>'.$this->Form->input('academicyear',array('label' => 'Academic Year','id'=>'academicyear','type'=>'select','options'=>$acyear_array_data,'empty'=>'All')).'</td>';
			
		echo '<td >'.$this->Form->input('semester',array('id'=>'semester', 'options'=>array('I'=>'I','II'=>'II', 'III'=>'III'),'empty'=>'All')).'</td></tr>'; 
		echo '<tr><td colspan=2>'.$this->Form->end('Search').'</td></tr>'; 
	?>
	</table>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo ('S.N<u>o</u>.');?></th>
			<th><?php echo $this->Paginator->sort('staff Name');?></th>
			<th><?php echo $this->Paginator->sort('Position');?></th>
			<th><?php echo $this->Paginator->sort('college_id');?></th>
			<th><?php echo $this->Paginator->sort('academic_year');?></th>
			<th><?php echo $this->Paginator->sort('semester');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count = $this->Paginator->counter('%start%');
	foreach ($staffForExams as $staffForExam):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($staffForExam['Staff']['Title']['title'] .' '.$staffForExam['Staff']['full_name'], array('controller' => 'staffs', 'action' => 'view', $staffForExam['Staff']['id'])); ?>
		</td>
		<td><?php echo $staffForExam['Staff']['Position']['position']; ?>&nbsp;</td>
		<td>
			<?php echo $staffForExam['Staff']['College']['name']; ?>
		</td>
		<td><?php echo $staffForExam['StaffForExam']['academic_year']; ?>&nbsp;</td>
		<td><?php echo $staffForExam['StaffForExam']['semester']; ?>&nbsp;</td>

		<td class="actions">

			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $staffForExam['StaffForExam']['id']), null, sprintf(__('Are you sure you want to delete?', true), $staffForExam['StaffForExam']['id'])); ?>
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
