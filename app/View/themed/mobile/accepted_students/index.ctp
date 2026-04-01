<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-selectall'); ?> 

<div>

<!-- 
<table cellpadding="0" cellspacing="0"><tr> 
	<?php echo $this->Form->create('AcceptedStudent', array('action' => 'index'));?> 
	<td> <?php 
			echo $this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($selected)?$selected:'')); ?>
	</td></tr>
	<?php 
	if ($role_id==ROLE_REGISTRAR) {
	?>
	<tr><td><?php echo $this->Form->input('AcceptedStudent.college_id',array(
            'empty'=>"--Select College --",'selected'=>isset($selected_college)?$selected_college:'')); ?></td></tr>
      <?php
      
      }       
      ?>
	<tr><td><?php echo $this->Form->end(__('Search',true)); ?> </td>	
	
</tr></table>

-->
 	<div class="smallheading"><?php __('Accepted Student Search');?></div>
	<?php
        echo $this->Form->Create('AcceptedStudent',array('action'=>'search'));
	   // college_id program_id department_id
	   echo '<table><tr><td>';
        echo '<table>';	
              
        echo '<tr><td>'.$this->Form->input('Search.academicyear',array('empty'=>' ',
        'options'=>$acyear_array_data,'empty'=> ' ' )).'</td></tr>';
		if (isset($colleges) && !empty($colleges)) {
            echo '<tr><td>'.$this->Form->input('Search.college_id',array('empty'=>' ','style'=>'width:200px')).'</td></tr>';
        }
  		echo '</table>';
		echo '</td><td>';
		echo '<table>';
		if (isset($departments) && !empty($departments)) {
		    echo '<tr><td>'.$this->Form->input('Search.department_id',array('empty'=>' ')).'</td></tr>';
	    }
	    echo '<tr><td>'.$this->Form->input('Search.program_id',array('empty'=>' ')).'</td></tr>';
	    echo '<tr><td>'.$this->Form->input('Search.program_type_id',array('empty'=>' ')).'</td></tr>';
	    echo '<tr><td>'.$this->Form->input('Search.name').'</td></tr>';
	    
		echo '</table>';
		echo '</td></tr>';
		echo '</table>';
		
		echo $this->Form->submit('Search');
		echo $this->Form->end();
	?>
<?php 
if(!empty($acceptedStudents)){
?>
    <?php 
    if ($role_id==ROLE_REGISTRAR) {
      
       echo $this->Form->create('AcceptedStudent', array('action' => 'delete', 'id' => 'accepted-form'));
       /*if (isset($this->data['Search']['college_id']) && !empty($this->data['Search']['college_id'])) {
           echo $this->Form->hidden('AcceptedStudent.college_id',array('value'=>
       $this->data['Search']['college_id'])); 
       }
       
       if (isset($this->data['Search']['department_id']) && !empty($this->data['Search']['department_id'])) {
          
        echo $this->Form->hidden('AcceptedStudent.department_id',array('value'=>
       $this->data['Search']['department_id']));      
       }
       
       if (isset($this->data['Search']['program_id']) && !empty($this->data['Search']['program_id'])) {
          
      
        echo $this->Form->hidden('AcceptedStudent.program_id',array('value'=>
       $this->data['Search']['program_id']));
       
       }
       
       if (isset($this->data['Search']['academicyear']) && !empty($this->data['Search']['academicyear'])) {
         
        echo $this->Form->hidden('AcceptedStudent.academicyear',array('value'=>$this->data['Search']['academicyear']));
       }
       
       */
       
    
       }
       
	?>
	<table cellpadding=0 cellspacing=0 border=0>
    <tbody>
	<tr>
	    <?php 
	    	if ($role_id==ROLE_REGISTRAR) {
	    	?>
           <th style="padding:0; width:5%">
            <?php echo 'Select/ Unselect All <br/>'.$this->Form->checkbox(null, array('id' => 'select-all','checked'=>'')); ?> </th> 
            <?php } ?>
			<th style="width:5%"><?php echo $this->Paginator->sort('No.','id');?></th>
            <th style="width:30%"><?php echo $this->Paginator->sort('Full Name','full_name');?></th>
			<th style="width:5%"><?php echo $this->Paginator->sort("Sex",'sex');?></th>
			<th style="width:5%"><?php echo $this->Paginator->sort("Student Number",'studentnumber');?></th>
			<th style="width:5%"><?php echo $this->Paginator->sort("EHEECE Result",'EHEECE_total_results');?></th>
			<th style="width:1%"><?php echo $this->Paginator->sort('College','college_id');?></th>
			<th style="width:11%"><?php echo $this->Paginator->sort('Department','department_id');?></th> 
			<th style="width:5%"><?php echo $this->Paginator->sort('Program Type','program_type_id');?></th>
			<!-- <th><?php echo $this->Paginator->sort('Academic Year','academicyear');?></th> -->
			<th style="width:9%"><?php echo $this->Paginator->sort("Placement Approved By Department",'Placement_Approved_By_Department');?></th>
			
			<th style="width:5%"><?php echo $this->Paginator->sort('Placement Type', 'placementtype');?></th>
			 <?php 
		    if ($role_id==ROLE_REGISTRAR || $role_id==ROLE_COLLEGE ) {
		    ?>
		    
			<th class="actions" style="text-align:center; width:10%"><?php __('Actions');?></th>
			
			<?php } ?>
	</tr>
	<?php
	$i = 0;
	
	$start = $this->Paginator->counter('%start%');
	foreach ($acceptedStudents as $acceptedStudent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<?php 
		//debug($acceptedStudent);
	    $red=null;
	    //debug($student_not_deleted);
	    //$student_not_deleted=$this->Session->read('student_not_deleted'); 
	   
	    if (isset($student_not_deleted) && 
	    in_array($acceptedStudent['AcceptedStudent']['id'],$student_not_deleted)) {
	
	        $red='style="color:red"'; 
	 
	    } 
	    
	  
	 ?>
	
	<tr <?php echo $class;?> <?php echo $red;?> >
	<?php 
     if ($role_id==ROLE_REGISTRAR) {
	    	?>
      <td ><?php echo $form->checkbox('AcceptedStudent.delete.' . $acceptedStudent['AcceptedStudent']['id']); ?>&nbsp;</td> 
      <?php } ?>
      <!-- <td><?php echo $acceptedStudent['AcceptedStudent']['id']; ?>&nbsp;</td> -->
      <td><?php echo $start++; ?>&nbsp;</td>
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo ucwords($acceptedStudent['AcceptedStudent']['sex']); ?>&nbsp;</td>
	    <td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($acceptedStudent['College']['shortname'], array('controller' => 'colleges', 'action' => 'view', $acceptedStudent['College']['id'])); ?>
		</td>
		 <td>
			<?php echo $this->Html->link($acceptedStudent['Department']['name'], array('controller' => 'departments', 'action' => 'view', $acceptedStudent['Department']['id'])); ?>
		</td> 
		<td>
			<?php echo $this->Html->link($acceptedStudent['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $acceptedStudent['ProgramType']['id'])); ?>
		</td>
		<!-- <td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;</td> -->
		<td><?php echo $acceptedStudent['AcceptedStudent']['Placement_Approved_By_Department']==1?'Approved':'Not Approved'; ?>&nbsp;</td>
		
		<td><?php echo $acceptedStudent['AcceptedStudent']['placementtype']; ?>&nbsp;</td>
	    <?php 
	    if ($role_id==ROLE_REGISTRAR || $role_id==ROLE_COLLEGE) {
	    ?>
		<td class="actions" >
			
			<?php 
			if ($role_id==ROLE_COLLEGE) {
			  echo $this->Html->link(__('Update Disability', true), array('action' => 'edit', $acceptedStudent['AcceptedStudent']['id']));
			} else {
			    echo $this->Html->link(__('Edit', true), array('action' => 'edit', $acceptedStudent['AcceptedStudent']['id']));
			}
			 ?>
            <?php //echo $this->Html->link(__('Admit', true), array('controller'=>'students','action' => 'admit', $acceptedStudent['AcceptedStudent']['id'])); ?>
			
		</td>
		<?php } ?>
	</tr>
<?php endforeach; ?>
    </tbody>
	</table>
    <table>
    <tbody>
    
         <tr><td>
    <?php 
  
     if ($role_id==ROLE_REGISTRAR) {
	    	
        echo $this->Form->Submit('Delete Selected');
        echo $this->Form->end();
     }
    ?>

    </td>
    </tr>
    </tbody>
	</table>
	<p>
	<?php
	 
     $paginator->options(array('url' => $this->passedArgs)); 
   
    
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));
		?>
	</div>

<?php 
} 
?>
</div>
