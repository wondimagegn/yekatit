<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-department_placement');?>
<?php echo $this->Html->script('jquery-selectall'); ?> 
<?php echo $this->Form->create('AcceptedStudent', array('action' => 'attach_curriculum'));?> 

<div class="reservedPlaces form">
<table><tbody><tr><td width="100%">
<table><tbody><tr> 
	
	<td>
	<?php if (!isset($auto_approve)) { ?>
	<div class="smallheading">Please select the academic year and program, you want to attach  curriculum.</div>
	 <?php 
	      
	        echo '<table class="fs16 small_padding" >';
			echo '<tr><td style="width:26%">Academic Year</td><td style="width:74%">'.$this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => false,'type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($selected_academicyear)?$selected_academicyear:'')).'</td></tr>';
            echo '<tr><td style="width:26%">Program</td><td style="width:74%">'.$this->Form->input('AcceptedStudent.program_id',array(
            'label' =>'Program','label'=>false)).'</td>';
            echo '<tr>';
            /*echo '<td>'.$this->Form->input('AcceptedStudent.program_type_id',array(
            'label' =>'Program Type','class'=>false)).'</td>';
            */
            echo '</tr>';
            echo '</table>';
             echo $this->Form->Submit(__('Continue',true),array('div'=>false,
 'name'=>'searchbutton'));
             echo '</table>';
                   
             }
        ?>
      
	</td></tr>
	
</tbody></table>
</td>
</tr>

<tr><td colspan=2>
<?php

if(!empty($autoplacedstudents)){
echo $this->Form->hidden('AcceptedStudent.academicyear',array('value'=>$selected_academicyear));
if(!isset($turn_of_approve_button)){
echo "<table>";

echo "<tr><td>".$this->Form->input('curriculum_id',array('empty'))
."</td></tr>";
/*echo '<tr><td>'.$this->Form->Submit(__('Approve',true),array('div'=>false,
 'name'=>'approve')).'</td></tr>';
 
 */
echo "</table>";
}

 $count=0;

?>
<table>
   <tr><th colspan=11 class="smallheading"><?php echo  __('List of student placed to '.$department_name.' and has not attached to curriculum.',true);?></th></tr>
	<tr>
	        
            <th><?php echo ('No.'); ?> </th>
            <th style="padding:0">
            <?php echo 'Select/ Unselect All <br/>'.$this->Form->checkbox("SelectAll", array('id' => 'select-all','checked'=>'')); ?> </th> 
            <th><?php echo ('Full Name');?></th>
			<th><?php echo ('Sex');?></th>
			<th><?php echo ('Student Number');?></th>
		
			<th><?php echo ('EHEECE Total Result');?></th>
		
			<th><?php echo ('Department');?></th>
			<th><?php echo ('Academic Year');?></th>
			<th><?php echo ('Department approval');?></th>
			
			<th><?php echo ('Placement Type ');?></th>
			
	</tr>
	<?php
	$i = 0;
	$serial_number=1;
	
	foreach ($autoplacedstudents as $acceptedStudent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
       
        <td><?php echo $serial_number++;?></td>
         <td ><?php echo $form->checkbox('AcceptedStudent.approve.' . $acceptedStudent['AcceptedStudent']['id']); ?>&nbsp;</td> 
          <?php echo $this->Form->hidden('AcceptedStudent.'.$count.'.id',array('value'=>$acceptedStudent['AcceptedStudent']['id']));?>
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		
		<td><?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?>&nbsp;</td>

		<td><?php echo $acceptedStudent['Department']['name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['Placement_Approved_By_Department']==1 ? 'Approved By Department':'Not Approved By Department'; ?>&nbsp;</td>
	
		<td><?php echo $acceptedStudent['AcceptedStudent']['placementtype']; ?>&nbsp;</td>
		
	</tr>
	
<?php 
$count++;

endforeach; 

?>
	</table>

	<?php 
	
 
echo '<tr><td>'.$this->Form->Submit(__('Attach',true),array('div'=>false,
 'name'=>'attach')).'</td></tr>';
	
}

 ?>
</td></tr>
    </tbody></table>
   
</td></tr>

</tbody></table>
<?php echo $this->Form->end();?>
</div>
