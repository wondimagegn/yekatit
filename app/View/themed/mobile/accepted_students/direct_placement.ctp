<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-selectall'); ?> 
<h3>Direct/Manual Student Placement to Department</h3>
<table>
<tbody>
<tr> 
	
	<td>
	<?php echo $this->Form->create('AcceptedStudent', array('action' => 'direct_placement',
	''));?> 
	 <?php 
			echo $this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')); 
           // echo $this->Js->submit()
            echo $this->Js->submit('Search', 
array('update'=>'#ajax_div','evalScripts'=>true,'before'=>$this->Js->get('#busy-indicator')
->effect('fadeOut',array('buffer'=>false)),
'complete'=>$this->Js->get('#busy-indicator')->effect('fadeOut',array('buffer'=>false)))); 
            echo $this->Form->end();
            
            ?>
	</td></tr>
	</tbody>
	</table>
<?php 
if(!empty($acceptedStudents)){
?>
<div class="acceptedStudents index">
	<h2><?php __('Select department');?></h2>
	
    <?php 
        echo $this->Form->create('AcceptedStudent',array('id'=>'directplacementform'));
	?>
	<table  cellpadding="0" cellspacing="0">
	<tbody>
	    <tr>
	    <td> <?php 
	   echo $this->Form->input('AcceptedStudent.department_id',array('id'=>'department_id','type'=>'select',
	    'options'=>$departments,'empty'=>'--Select Department--','selected'=>isset($selecteddepartment)?$selecteddepartment:''));
	 
	   //echo $this->Form->input('department_id');
	 
?>

	    </td>
	    </tr>
	</tbody>
	</table>
	<table  cellpadding="0" cellspacing="0"> 
    <tr>
            <th>
            <?php echo 'Select/Unselect All <br/>'.$this->Form->checkbox('selectall', array('id' => 'select-all')); ?> </th>
			
            <th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('sex');?></th>
			<th><?php echo $this->Paginator->sort('studentnumber');?></th>
			<!--<th><?php echo $this->Paginator->sort('assignment_type');?></th>-->
			<th><?php echo $this->Paginator->sort('EHEECE_total_results');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<th><?php echo $this->Paginator->sort('program_type_id');?></th>
			<th><?php echo $this->Paginator->sort('academicyear');?></th>
			<!-- <th><?php echo $this->Paginator->sort('approval');?></th> -->
			 <!-- <th><?php //echo $this->Paginator->sort('applicationstatus');?>
			 </th> -->
			<!-- <th><?php echo $this->Paginator->sort('currentstatus');?></th> -->
			<th><?php echo $this->Paginator->sort('placementtype');?></th> 
			<?php //echo $this->Paginator->sort('created');?>
			<?php //echo $this->Paginator->sort('modified');?>
			
	</tr>
	<?php
	
	$i = 0;
	foreach ($acceptedStudents as $acceptedStudent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
        <td><?php echo $this->Form->checkbox('AcceptedStudent.directplacement.' . $acceptedStudent['AcceptedStudent']['id'],array('disabled'=>$acceptedStudent['AcceptedStudent']['Placement_Approved_By_Department']==1?true:false)); ?></td>
       
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		<!--<td><?php echo $acceptedStudent['AcceptedStudent']['assignment_type']; ?>&nbsp;</td> -->
		<td><?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($acceptedStudent['Department']['name'], array('controller' => 'departments', 'action' => 'view', $acceptedStudent['Department']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($acceptedStudent['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $acceptedStudent['ProgramType']['id'])); ?>
		</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;</td>
		
		<td><?php echo $acceptedStudent['AcceptedStudent']['placementtype']; ?>&nbsp;</td>
		
	</tr>
<?php endforeach; ?>  
	</table>
    <table cellpadding="0" cellspacing="0"><tbody>
        <tr><td><tr><td >
 <?php echo $this->Form->Submit('Assign To Selected Department',array('div'=>false,
 'name'=>'assigndirectly'));
  /*echo $this->Js->Submit('Assign To Selected Department',array('div'=>false,
 'name'=>'assigndirectly','update'=>'#ajax_div','evalScripts'=>true));*/
 ?>
 
 </td>
 
  <td>
    <?php echo $this->Form->Submit('Transfer To Selected Department',array('div'=>false,
 'name'=>'transfertodepartment'));?>
 </td>
 <td>
  <?php echo $this->Form->Submit('Cancel Selected Student Placement',array('div'=>false,
 'name'=>'cancelplacement'));?>
 </td>
</tr>
    </tbody></table>
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
<?php 
} else {
    echo "<div class='info-box info-message'><span></span>No Accepted students in the selected academic year</div>";
}
 echo $this->Js->writeBuffer(); // Write cached scripts
?>

