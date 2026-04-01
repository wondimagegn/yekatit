<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-department_placement');?>
<?php echo $this->Html->script('jquery-selectall'); ?> 
<?php echo $this->Form->create('AcceptedStudent', array('action' => 'deattach_curriculum'));?> 
<div class="smallheading">
<?php if (!isset($auto_approve)) { ?>
Please select the academic year, you want to deattach students from curriculum.

<?php } ?>


</div>

<div class="reservedPlaces form">

	<?php if (!isset($auto_approve)) { ?>
	
	 <?php 
	        echo '<table class="fs13 small_padding">';
			echo '<tr><td style="width:26%">Academic Year</td><td width:74%>'.
			$this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => false,'type'=>'select','options'=>$acyear_array_data,
             'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))).'</td></tr>';
            /*
             echo '<tr><td> Program: </td><td>'.$this->Form->input('AcceptedStudent.program_id',array('id'=>'program_id',
            'label' => false).'</td></tr>';
            
            echo '<tr><td> Curriculum: </td><td>'.$this->Form->input('AcceptedStudent.curriculum_id',array('id'=>'curriculum_id',
            'label' => false)).'</td></tr>';
            */
             
             echo '<tr><td colspan=2>'.$this->Form->Submit(__('Continue',true),array('div'=>false,
 'name'=>'searchbutton')).'</td></tr>';
            echo '</table>';
                   
             }
             ?>

<?php

if(!empty($autoplacedstudents)){

if(!isset($turn_of_approve_button)){
echo "<table>";

/*echo '<tr><td>'.$this->Form->Submit(__('Approve',true),array('div'=>false,
 'name'=>'approve')).'</td></tr>';
 
 */
echo "</table>";
}

 $count=0;

?>

 <?php 
 
 echo "<div class='info-message info-box'><span></span><strong>Note:</strong> Deattaching a given student from a curriculum if only necessary. You are advice to deattach the student from the curriculum if s/he is transfered to other department, or has not taken any course from the attached curriculum, if s/he has taken a course, it is required to substitute all the course from the old curriculum to the new curriculum to be consider as taken course.</div>";
 ?>

<table>
   <tr><th colspan=11 class="smallheading"><?php echo  __('List of student placed to '.$department_name.'',true);?></th></tr>
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
			<th><?php echo ('Curriculum');?></th>
			
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
		<td><?php echo $acceptedStudent['Curriculum']['curriculum_detail']; ?>&nbsp;</td>
	</tr>
	
<?php 
$count++;

endforeach; 

?>
<?php 
echo '<tr><td>'.$this->Form->Submit(__('Deattach',true),array('div'=>false,
 'name'=>'deaattach')).'</td></tr>';
?>
	</table>

	<?php 

}

 ?>

<?php echo $this->Form->end();?>
</div>
