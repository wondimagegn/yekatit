<?php echo $this->Form->create('Student');?>
<?php if (!isset($admitsearch)) { ?>
<div class="smallheading"> Admit selected students at once. Please dont forget to 
record and maintain each students record after batch admission. </div>
<table cellpadding="0" cellspacing="0"><tr> 
	
	<td> <?php 
			echo $this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')); ?>
	</td></tr>
	<tr><td>
	   <?php 
	       if (!empty($college_level)) {
			echo $this->Form->input('AcceptedStudent.college_id',array('label'=>'Select College','type'=>'select','empty'=>'---Select College --'));
			 }
			 if (!empty($department_level)) {
			    echo $this->Form->input('AcceptedStudent.department_id',array('label'=>'Select Department','type'=>'select','empty'=>'---Select Department --'));
			 }
			
			 ?>  
	</td></tr>
	<tr><td><?php echo $this->Form->Submit('Continue',array('div'=>false,'name'=>'getacceptedstudent')); ?> </td>	
</tr></table>
<?php } ?>
<?php 
    if (!empty($acceptedStudents)) {
?>
<table>
   <tr><th colspan=11 class="smallheading"><?php echo  __('Select List of student you want to batch admit.',true);?></th></tr>
	<tr>
	        
            <th><?php echo ('No.'); ?> </th>
            <th style="padding:0">
            <?php echo 'Select/ Unselect All <br/>'.$this->Form->checkbox("SelectAll", 
            array('id' => 'select-all','checked'=>'')); ?> </th> 
            <th><?php echo ('Full Name');?></th>
			<th><?php echo ('Sex');?></th>
			<th><?php echo ('Student Number');?></th>
		
			<th><?php echo ('EHEECE Total Result');?></th>
			
			<th><?php echo ('Department');?></th>
			<th><?php echo ('Academic Year');?></th>
			
	</tr>
	<?php
	$i = 0;
	$serial_number=1;
	
	foreach ($acceptedStudents as $acceptedStudent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
       
        <td><?php echo $serial_number++;?></td>
         <td ><?php echo $form->checkbox('AcceptedStudent.approve.' . $acceptedStudent['AcceptedStudent']['id']); ?>&nbsp;</td> 
       
              <?php 
                   echo $this->Form->hidden('Student.'.$serial_number.'.first_name',array('value'=>$acceptedStudent['AcceptedStudent']['first_name']));
                   echo $this->Form->hidden('Student.'.$serial_number.'.middle_name',array('value'=>$acceptedStudent['AcceptedStudent']['middle_name']));
                   echo $this->Form->hidden('Student.'.$serial_number.'.last_name',array('value'=>$acceptedStudent['AcceptedStudent']['last_name']));
                   echo $this->Form->hidden('Student.'.$serial_number.'.amharic_first_name',array('value'=>isset($acceptedStudent['AcceptedStudent']['amharic_first_name'])?$acceptedStudent['AcceptedStudent']['amharic_first_name'] :''));
                   echo $this->Form->hidden('Student.'.$serial_number.'.amharic_last_name',array('value'=>isset($acceptedStudent['AcceptedStudent']['amharic_last_name'])?$acceptedStudent['AcceptedStudent']['amharic_last_name']:''));
                   echo $this->Form->hidden('Student.'.$serial_number.'.user_id',array('value'=>isset($acceptedStudent['AcceptedStudent']['user_id'])?$acceptedStudent['AcceptedStudent']['user_id']:''));
                   echo $this->Form->hidden('Student.'.$serial_number.'.accepted_student_id',array('value'=>$acceptedStudent['AcceptedStudent']['id']));
                 echo $this->Form->hidden('Student.'.$serial_number.'.gender',array('value'=>isset($acceptedStudent['AcceptedStudent']['sex'])?$acceptedStudent['AcceptedStudent']['sex'] :''));
                 echo $this->Form->hidden('Student.'.$serial_number.'.studentnumber',array('value'=>$acceptedStudent['AcceptedStudent']['studentnumber']));
                 echo $this->Form->hidden('Student.'.$serial_number.'.region_id',array('value'=>$acceptedStudent['AcceptedStudent']['region_id']));
                 
                 echo $this->Form->hidden('Student.'.$serial_number.'.program_id',array('value'=>$acceptedStudent['AcceptedStudent']['program_id']));
                  echo $this->Form->hidden('Student.'.$serial_number.'.college_id',array('value'=>$acceptedStudent['AcceptedStudent']['college_id']));
                   echo $this->Form->hidden('Student.'.$serial_number.'.department_id',array('value'=>isset($acceptedStudent['AcceptedStudent']['department_id'])?$acceptedStudent['AcceptedStudent']['department_id']:''));
                 echo $this->Form->hidden('Student.'.$serial_number.'.program_type_id',array('value'=>isset($acceptedStudent['AcceptedStudent']['program_type_id'])?$acceptedStudent['AcceptedStudent']['program_type_id']:''));
                    
                  echo $this->Form->hidden('Student.'.$serial_number.'.base_program_type_id',array('value'=>isset($acceptedStudent['AcceptedStudent']['program_type_id'])?$acceptedStudent['AcceptedStudent']['program_type_id'] :''));
                  echo $this->Form->hidden('Student.'.$serial_number.'.curriculum_id',
                  array('value'=>isset($acceptedStudent['AcceptedStudent']['curriculum_id'])?
                  $acceptedStudent['AcceptedStudent']['curriculum_id']:''));
                  
                   echo $this->Form->hidden('Student.'.$serial_number.'.admissionyear',
                  array('value'=>isset($acceptedStudent['AcceptedStudent']['academicyear'])?
                  $acceptedStudent['AcceptedStudent']['academicyear']:''));
                  
                  
             ?>
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		
		<td><?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?>&nbsp;</td>

		<td><?php echo $acceptedStudent['Department']['name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;</td>
		
	
	</tr>
	
<?php 

endforeach; 
           
echo '<tr><td>'.$this->Form->Submit('Admit Selected Students',array('div'=>false,'name'=>'admit')).'</td></tr>';
?>
</table>
<?php 
    }
echo $this->Form->end();
?>
