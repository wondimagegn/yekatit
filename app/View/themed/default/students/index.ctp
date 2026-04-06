<?php ?>
<script type='text/javascript'>
var image = new Image();
image.src = '/img/busy.gif';

$(document).ready(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$("#dialog-modal").dialog({
			heght: 500,
			width:700,
			autoOpen: false,
			closeOnEscape: true,
			modal: true

	});

	$(".jsview").click(function() {
				$('#dialog-modal').empty().html('<img src="'+image.src+'" class="displayed" />');
				$("#dialog-modal").dialog("open");

				return false;
	});		

});
</script>
<div class="students index">
<?php 
 echo $this->Form->Create('Student',array('action'=>'search'));
/*
echo $this->Form->create('Student', array('action' => 'index'));
 

 if (!isset($search) && $role_id==ROLE_REGISTRAR) { 
 ?>
<table cellpadding="0" cellspacing="0"><tr> 
	
	<td> <?php 
	$from = date('Y') - Configure::read('Calendar.birthdayInPast');
                   $to = date('Y');
                   $format = Configure::read('Calendar.yearFormat');
			echo $this->Form->input('Student.admissionyear',array('dateFormat'=>$format,'minYear'=>$from,'maxYear'=>$to)); 
			echo $this->Form->input('Student.first_name',array('label'=>'First Letter of Name')); 
			
			?>
	</td></tr>
	<tr><td>
	   <?php 
	       if (!empty($college_level)) {
			echo $this->Form->input('Student.college_id',array('label'=>'Select College','type'=>'select','empty'=>'---Select College --'));
			 }
			 if (!empty($department_level)) {
			    echo $this->Form->input('Student.department_id',array('label'=>'Select Department','type'=>'select','empty'=>'---Select Department --'));
			 }
			
			 ?>  
	</td></tr>
	<tr><td><?php echo $this->Form->Submit('Search',array('div'=>false,'name'=>'getacceptedstudent')); ?> </td>	
</tr></table>
<?php 

 }
 
 
 
 if ( !isset($search) && $role_id==ROLE_DEPARTMENT) {
          
           
           echo "<div class='smallheading'>";
           echo "Search student to view profile.";
           echo "</div>";
           echo "<table>";
			echo "<tr><td>".$this->Form->input('Student.first_name',array('label'=>'First Letter of Name'))."</td></tr>"; 
			echo "<tr><td>".$this->Form->Submit('Search',array('div'=>false,'name'=>'getacceptedstudent'))."</td></tr>"; 
			 echo "</table>";
          
         
 }
 */
 ?>
  	<div class="smallheading"><?php __('Search Admitted Students');?></div>
	<?php
       
	   // college_id program_id department_id
	   echo '<table><tr><td>';
        echo '<table>';	
              
        echo '<tr><td>'.$this->Form->input('Search.admissionyear',array('type'=>'date',
        'label'=>'Admission From ')).'</td></tr>';
		if (isset($colleges) && !empty($colleges)) {
            echo '<tr><td>'.$this->Form->input('Search.college_id',array('empty'=>' ','style'=>'width:200px')).'</td></tr>';
        }
  		 echo '<tr><td>'.$this->Form->input('Search.name',array('label'=>'Name')).
  		 '</td></tr>';
  		
  		echo '</table>';
		echo '</td><td>';
		echo '<table>';
		if (isset($departments) && !empty($departments)) {
		    echo '<tr><td>'.$this->Form->input('Search.department_id',array('empty'=>' ')).'</td></tr>';
	    }
	    
	    echo '<tr><td>'.$this->Form->input('Search.program_id',array('empty'=>' ')).'</td></tr>';
	    echo '<tr><td>'.$this->Form->input('Search.program_type_id',array('empty'=>' ')).'</td></tr>';
	    
		echo '</table>';
		echo '</td></tr>';
		echo '</table>';
		
		echo $this->Form->submit('Search');
		echo $this->Form->end();
	?> 
<div id="dialog-modal" title="Academic Profile "></div>
<?php 

  if (!empty($students)) {
  
 
?>
	<div class="smallheading"><?php __('Students');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
	        <th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<!--<th><?php echo $this->Paginator->sort('middle_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th> -->
			<th><?php echo $this->Paginator->sort('gender');?></th>
			<th><?php echo $this->Paginator->sort('studentnumber');?></th>
			
			<th><?php echo $this->Paginator->sort('admissionyear');?></th>

			<th><?php echo $this->Paginator->sort('Program');?></th>
			<th><?php echo $this->Paginator->sort('Program Type');?></th>
			
			<th><?php echo $this->Paginator->sort('College');?></th>
						<th><?php echo $this->Paginator->sort('Department','department_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
    $start = $this->Paginator->counter('%start%');
	foreach ($students as $student):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $student['Student']['full_name']; ?>&nbsp;</td>
		<!--<td><?php echo $student['Student']['middle_name']; ?>&nbsp;</td>
		<td><?php echo $student['Student']['last_name']; ?>&nbsp;</td> -->
		<td><?php echo $student['Student']['gender']; ?>&nbsp;</td>
		<td><?php echo $student['Student']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $this->Format->short_date($student['Student']['admissionyear']); ?>&nbsp;</td>
		<td><?php echo $student['Program']['name']; ?>&nbsp;</td>
		<td><?php echo $student['ProgramType']['name']; ?>&nbsp;</td>
		<td><?php echo $student['College']['name']; ?>&nbsp;</td>
		
		<td><?php echo $student['Department']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View', true), array('action' => 'view', $student['Student']['id'])); ?>
			<?php 
			echo $this->Js->link('View',array('controller'=>'students','action'=>'get_modal_box',$student['Student']['id']),array('class'=>'jsview','update'=>'#dialog-modal'));
			?>
			<?php 
			  if ($role_id == ROLE_REGISTRAR ) {
			   echo $this->Html->link(__('Edit Profile', true), array('action' => 'edit', $student['Student']['id']));
			  }
			 ?>
			
		</td>
	</tr>
<?php 

endforeach;

?>
   
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
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	
<?php 
}
?>
</div>
