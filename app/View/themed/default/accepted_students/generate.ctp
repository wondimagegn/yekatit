<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-selectall'); ?> 

<?php echo $this->Form->create('AcceptedStudent', array('action' => 'generate'));?> 
<div>
<?php if(!isset($show_list_generated)) { ?>
<div class="smallheading"><?php echo __('Generate student number')?></div>
<div class="centeralign_smallheading"><?php echo __('Tables:Summary of students those haven\'t student identification')?></div>
<table><tbody><tr>
<?php
$college_count = count($colleges);
$count_program = count($programs);
$count_program_type = count($programTypes);
for($i=1;$i<=$college_count;$i++) {
    echo '<td><table style="border: #CCC solid 1px"><tr><td class="smallheading" colspan="3">'.
        $colleges[$i].'</B></td></tr>'; //Display College name
    echo '<tr><th style="border-right: #CCC solid 1px">'."ProgramType/ Program".'</th>'; //Display ProgramType/Program label
    foreach($programs as $kp=>$vp) {
        echo '<th style="border-right: #CCC solid 1px">'.$vp.'</th>';
    }
    echo '</tr>';
    for($j=1;$j<=$count_program_type;$j++) {
        echo '<tr><td style="border-right: #CCC solid 1px">'.$programTypes[$j].'</td>';
        for($k=1;$k<=$count_program;$k++) {
            echo '<td style="border-right: #CCC solid 1px">'.$data[$colleges[$i]][$programs[$k]][$programTypes[$j]].'</td>';
        }
        echo '</tr>';
    }
    echo '</table></td>';
    if(($i%3) == 0) {
         echo '<tr></tr>';
    }
}
?>
<?php } ?>
</tr></tbody></table>
<?php if(!isset($show_list_generated)) { ?>
<table cellpadding="0" cellspacing="0"><tr> 
	<?php 
			echo '<td>'.$this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
                'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
                'empty'=>"--Select Academic Year--",'selected'=>isset($selectedsacdemicyear)?$selectedsacdemicyear:'')).'</td>';
            echo '<td>'. $this->Form->input('AcceptedStudent.college_id',array('empty'=>"--Select College--")).'</td></tr>';
            echo '<tr><td>'. $this->Form->input('AcceptedStudent.program_id',array('empty'=>"--Select Program--")).'</td>'; 
            echo '<td>'. $this->Form->input('AcceptedStudent.program_type_id',array('empty'=>"--Select Program Type--")).'</td></tr>'; 
            ?>
	<tr><td><?php echo $this->Form->submit('Search',array('name'=>'search','div'=>'false')); ?> </td>	
</tr></table>
<?php } ?>
<?php 
if(!empty($acceptedStudents)){
?>
    <?php 
        //echo $this->Form->create('AcceptedStudent', array('action' => 'generate', 'id' => 'student-form'));
	?>
	<table cellpadding=0 cellspacing=0>
    <tbody>
	<tr>
            <th style="padding:0">
            <?php echo 'Select/Unselect All <br/>'.$this->Form->checkbox(null, array('id' => 'select-all','checked'=>'')); ?> </th>
			
            <th><?php echo $this->Paginator->sort('Full Name','full_name');?></th>
			<th><?php echo $this->Paginator->sort("Sex",'sex');?></th>
			<th><?php echo $this->Paginator->sort("Student Number",'studentnumber');?></th>
			<th><?php echo $this->Paginator->sort("EHEECE Result",'EHEECE_total_results');?></th>
			<th><?php echo $this->Paginator->sort('Department','department_id');?></th>
			<th><?php echo $this->Paginator->sort('Program Type','program_type_id');?></th>
			<th><?php echo $this->Paginator->sort('Academic Year','academicyear');?></th>
			<th><?php echo $this->Paginator->sort("Placement Approved By Department",'Placement_Approved_By_Department');?></th>
			
			<th><?php echo $this->Paginator->sort('Placement Type', 'placementtype');?></th>
		
			
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
        <td><?php echo $form->checkbox('AcceptedStudent.generate.' . $acceptedStudent['AcceptedStudent']['id']); ?>&nbsp;</td>
      
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;</td>
	    <td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($acceptedStudent['Department']['name'], array('controller' => 'departments', 'action' => 'view', $acceptedStudent['Department']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($acceptedStudent['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $acceptedStudent['ProgramType']['id'])); ?>
		</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['Placement_Approved_By_Department']==1?'Approved':'Not Approved'; ?>&nbsp;</td>
		
		<td><?php echo $acceptedStudent['AcceptedStudent']['placementtype']; ?>&nbsp;</td>
	
	</tr>
<?php endforeach; ?>
    </tbody>
	</table>
    <table>
    <tbody>
    
         <tr><td>
    <?php 
    echo $this->Form->Submit('Generate ID',array('name'=>'generateid','div'=>'false'));
    echo $this->Form->end();
    ?>
    </td>
    </tr>
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
    echo "<div class='info-box info-message'> <span></span> No Accepted students without student identification in these selected criteria</div>";
}
?>
</div>
