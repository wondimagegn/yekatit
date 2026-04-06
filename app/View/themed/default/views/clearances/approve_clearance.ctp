<?php 
echo $this->Form->create('Clearance');
?>
<p class="smallheading">Please select academic year, department, program and semester for which you want to approve clearance/withdraw application.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Academic Year:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.academic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($academic_year_selected) ? $academic_year_selected : $defaultacademicyear))); ?></td>
			<td style="width:12%">Program Type:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.program_type_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$programTypes)); ?></td>
			<!---
			<td style="width:8%">Semester:</td>
			
			 
			<td style="width:25%"><?php echo $this->Form->input('Search.semester', array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'), 'default' => (isset($semester_selected) ? $semester_selected : false))); ?></td>
			
			--->
			
			
		</tr>
		<tr>
			<?php if (!empty($departments)) { ?>
			<td style="width:12%">Department:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.department_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$departments)); ?></td>
			<?php } else if (!empty($colleges)) { ?>
			     <td style="width:12%">College:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.college_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$colleges)); ?></td>
			<?php } ?>
			<td style="width:8%">Program:</td>
			<td style="width:25%"><?php echo $this->Form->input('Search.program_id', array('class' => 'fs14',  'style' => 'width:125px', 'label' => false,'options'=>$programs)); ?></td>
			
		</tr>
			<tr>
		  	<td> Type:</td>
			<td><?php 
			echo $this->Form->input('Search.clear', array('type' => 'checkbox', 'label' => 'Clearance', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['clear'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.withdrawl', array('type' => 'checkbox', 'label' => 'Withdrawal', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['withdrawl'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr>
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('Filter Clearnce Application', true), array('name' => 'filterClearnce', 'div' => false)); ?></td>
		</tr>
	</table>

  <div class="clearances index">
<?php 
    if (!empty($clearances)) {
    $options=array('1'=>'Clear','-1'=>'Not Clear');
  // $attributes=array('legend'=>false);
   $attributes=array('legend'=>false,'label'=>false,'separator'=>'<br/>');

?>
	<div class="smallheading"><?php __('List of clearance/withdraw applicant processed by the system and not taken properties from the concerned bodies and waiting your decision.');?></div>
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
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('reason');?></th>
			
			<th><?php echo $this->Paginator->sort('request_date');?></th>
			<th><?php echo $this->Paginator->sort('program');?></th>
			<th><?php echo $this->Paginator->sort('clearnce');?></th>
			
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
		<td><?php 
		
		        echo $clearance['Clearance']['type'].'<br/>'; 
		        if (isset($clearance['Attachment']) && 
		                !empty($clearance['Attachment'])) { 
			             
			              echo " <a href=".$this->Media->url($clearance['Attachment'][0]['dirname'].DS.$clearance['Attachment'][0]['basename'],true)." target=_blank'>View Attachment</a>";
		                 
		       }
		    
		    
		    ?>&nbsp;</td>
		<td><?php echo $clearance['Clearance']['reason']; ?>&nbsp;</td>
		<td><?php echo $this->Format->humanize_date($clearance['Clearance']['request_date']); ?>&nbsp;</td>
	
		<td><?php echo $clearance['Student']['Program']['name'];; ?>&nbsp;</td>
	   <?php 
	   echo $this->Form->hidden('Clearance.'.$start.'.id',array('value'=>$clearance['Clearance']['id']));
		         echo $this->Form->hidden('Clearance.'.$start.'.student_id',array('value'=>$clearance['Student']['id']));
		         ?>
		<td><?php 
		      
		      echo $this->Form->radio('Clearance.'.$start.'.confirmed',$options,$attributes)
		     
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
	
	echo $this->Form->submit('submit',array('name'=>'saveIt','div'=>'false')); 
	    
 } ?>
 <?php 
    echo $this->Form->end();
 ?>
</div>

