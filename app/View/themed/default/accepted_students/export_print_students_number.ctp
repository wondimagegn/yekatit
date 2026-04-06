<?php echo $this->Form->create('AcceptedStudent', array('action' => 'export_print_students_number'));?> 
<div>
<?php //if(!isset($show_list_generated)) { ?>
<div class="smallheading"><?php echo __('Export/Print Students Id')?></div>
<table cellpadding="0" cellspacing="0"><tr> 
	<?php 
			echo '<td>'.$this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
                'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
                'empty'=>"--Select Academic Year--",'selected'=>isset($selectedsacdemicyear)?$selectedsacdemicyear:'')).'</td>';
		if($role_id == ROLE_REGISTRAR) {
            echo '<td>'. $this->Form->input('AcceptedStudent.college_id',array('empty'=>"--Select College--")).'</td></tr>';
		}
            echo '<tr><td>'. $this->Form->input('AcceptedStudent.program_id',array('empty'=>"--Select Program--")).'</td>'; 
            echo '<td>'. $this->Form->input('AcceptedStudent.program_type_id',array('empty'=>"--Select Program Type--")).'</td></tr>'; 
    ?>
		<tr><td colspan="2";><?php echo $this->Form->submit('Search',array('name'=>'search','div'=>'false')); ?> </td></tr>
</table>
<?php 
if(!empty($acceptedStudents)){
?>
	<table>
	<?php

		echo '<tr><td class="smallheading" colspan="2">College: '.$selected_college_name.'</td></tr>';
		echo '<tr><td class="smallheading" colspan="2">Program: '.$selected_program_name.'</td></tr>';
		echo '<tr><td class="smallheading" colspan="2">Program Type: '.$selected_program_type_name.'</td></tr>';
		echo '<tr><td class="smallheading">Academic Year: '.$selectedsacdemicyear.'</td>';
		echo '<td style="text-align:right;">'.$this->Html->link($this->Html->image("/img/pdf_icon.gif",
		array("alt"=>"Print To Pdf")), 
				array('action' => 'print_students_number_pdf'),array('escape'=>false))."Print".  
			$this->Html->link($this->Html->image("/img/xls-icon.gif",array("alt"=>"Export TO Excel")),
			 array('action' => 
				'export_students_number_xls'),array('escape'=>false))."Export".'</td></tr>';
	?>
	</table>
	<table cellpadding=0 cellspacing=0 width="60%">
    <tbody>
	<tr>
            <th><?php echo "No";?></th>
			<th><?php echo $this->Paginator->sort('Full Name','full_name');?></th>
			<th><?php echo $this->Paginator->sort("Sex",'sex');?></th>
			<th><?php echo $this->Paginator->sort("Student Id",'studentnumber');?></th>
			<th><?php echo $this->Paginator->sort("Region",'region_id');?></th>
			
	</tr>
	<?php
	$i = 0;
	$count =1;
	foreach ($acceptedStudents as $acceptedStudent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
	
		<td><?php echo $count++; ?>&nbsp;</td>
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;</td>
	    <td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['Region']['name']; ?>&nbsp;</td>
	
	</tr>
<?php endforeach; ?>
    </tbody>
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
<?php 
} else if(empty($acceptedStudents) && !($isbeforesearch)){
    echo "<div class='info-box info-message'> <span></span> No Accepted students have student identification in the selected
	criteria. If you have students in these criteria, Please go to Generate Student Id page and generate student id before export/print</div>";
}
?>
</div>
