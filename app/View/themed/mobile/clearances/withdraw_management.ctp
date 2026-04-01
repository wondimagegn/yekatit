<?php 
echo $this->Form->create('Clearance');
?>
<p class="smallheading">Filter Withdrawal Applicant.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Academic Year:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.academic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>
			<?php if (!empty($departments)) { ?>
			<td style="width:12%">Department:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.department_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$departments,'empty'=>' ','style'=>'width:200px')); ?></td>
			<?php 
			 }
			?>
			
			<?php if (!empty($colleges)) { ?>
			<td style="width:12%">College:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.college_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$colleges,'empty'=>' ','style'=>'width:200px')); ?></td>
			<?php 
			 }
			?>
			
		</tr>
		<tr>
			<td style="width:12%">Program Type:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.program_type_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$programTypes,'style'=>'width:150px','empty'=>' ')); ?></td>
			<td style="width:8%">Program:</td>
			<td style="width:25%"><?php echo $this->Form->input('Search.program_id', array('class' => 'fs14',  'style' => 'width:150px', 'label' => false,'options'=>$programs,'empty'=>' ')); ?></td>
			
		</tr>
		<!---
		 <tr>
		  	<td> Type:</td>
			<td><?php 
			echo $this->Form->input('Search.clear', array('type' => 'checkbox', 'label' => 'Clearance Approved', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['clear'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.notcleared', array('type' => 'checkbox', 'label' => 'Not Clearance  Approved', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['notcleared'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr> --->
			
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('Filter Withdrawal Applicant', true), array('name' => 'viewWithdrawal', 'div' => false)); ?></td>
		</tr>
</table>
 <div class="clearances index">
<?php 

    if (!empty($clearances)) {
    $options=array('1'=>'Yes','-1'=>'No');
  // $attributes=array('legend'=>false);
   $attributes=array('legend'=>false,'label'=>false,'separator'=>'<br/>');

?>
	<div class="smallheading"><?php __('List of withdrawal applicant.');?></div>
	<?php 
	    foreach ($clearances as $deptname=>$program) {          // department 
	        echo '<div class="fs16">Department: '.$deptname.'</div>';
	        foreach ($program as $progr_name=>$programType) {        // program
	            echo '<div class="fs16">Progam: '.$progr_name.'</div>'; 
	            foreach ($programType as $progr_type_name=>$clearnacess) {    // program type 
	                echo '<div class="fs16">ProgramType: '.$progr_type_name.'</div>';
	            
	?>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('Full Name','student_id');?></th>
		    <th><?php echo $this->Paginator->sort('Student ID','studentnumber');?></th>
			<th><?php echo $this->Paginator->sort('request_date');?></th>
			<th><?php echo $this->Paginator->sort('reason');?></th>
			<th><?php echo $this->Paginator->sort('Attachment');?></th>
			
			<th><?php echo $this->Paginator->sort('Accept/Reject Withdrawal');?></th>
			<th><?php echo $this->Paginator->sort('minute_number');?></th>
			
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($clearnacess as $clearance):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($clearance['Student']['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile', $clearance['Student']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($clearance['Student']['studentnumber'], array('controller' => 'students', 'action' => 'student_academic_profile', $clearance['Student']['id'])); ?>
		</td>
		<td><?php echo $this->Format->humanize_date($clearance['Clearance']['request_date']); ?>&nbsp;</td>
	    <td><?php echo $clearance['Clearance']['reason']; ?>&nbsp;</td>
	    
		<td><?php 
		
		        if (isset($clearance['Attachment']) && 
		                !empty($clearance['Attachment'])) { 
			             
			              echo " <a href=".$this->Media->url($clearance['Attachment'][0]['dirname'].DS.$clearance['Attachment'][0]['basename'],true)." target=_blank'>View Attachment</a>";
		                 
		       } else {
		                  echo 'Not Available';
		       }
		    
		    
		    ?>&nbsp;
		</td>
		<?php 
	   echo $this->Form->hidden('Clearance.'.$start.'.id',array('value'=>$clearance['Clearance']['id']));
		         echo $this->Form->hidden('Clearance.'.$start.'.student_id',array('value'=>$clearance['Student']['id']));
		         ?>
		<td><?php 
		      
		      echo $this->Form->radio('Clearance.'.$start.'.forced_withdrawal',$options,$attributes)
		     
		    ?>
	&nbsp;</td>
		   <td><?php 
		      
		      echo $this->Form->input('Clearance.'.$start.'.minute_number',array('label'=>false));
		     
		    ?>
	&nbsp;</td>
		<?php 
		$start++;
		?>
		
	
	</tr>
<?php endforeach; ?>
	</table>

	<?php
	
	    }
	   }
	}
	
	echo $this->Form->submit('Accept/Reject Withdrawal',array('name'=>'saveIt','div'=>'false')); 
	    
 } ?>
 <?php 
    echo $this->Form->end();
 ?>
</div>
