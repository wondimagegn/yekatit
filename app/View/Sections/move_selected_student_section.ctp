<?php 
echo $this->Form->create('Section',
array('controller'=>'sections','action'=>'section_move_update',
"method"=>"POST"));
?>
<div class="row">
<div class="large-12 columns">
	<div class="row">
		<div class="large-12 columns">
			<p>
			Select the section you want to move the selected 
			</p>
		</div>
  </div>
  <div class="row">
		<div class="large-6 columns">
			 <?php 

	echo $this->Form->input('Selected_section_id',array('label'=>false,'id'=>'Selected_section_id','type'=>'select',
        'options'=>$sections,'empty'=>"--Select Section--"));

	echo $this->Form->hidden('previous_section_id', array('value'=>$previous_section_id));


?>
		</div>
		<div class="large-6 columns">
			 		 

<?php 
echo $this->Form->Submit(__('Move Selected'),array('div'=>false,'class'=>'tiny radius button bg-blue','name'=>'attach'));
?>
		</div>
	
</div>

<table>
   <tr><th colspan=5 class="smallheading"><?php echo  __('List of student placed to '.$previousSectionName['Section']['name'].'('.$previousSectionName['Program']['name'].'-'.$previousSectionName['ProgramType']['name'].'-'.$previousSectionName['Department']['name'].')');?></th></tr>
	<tr>
	        
            <th><?php echo ('No.'); ?> </th>
            <th style="padding:0;width:30px;">
            <?php echo 'Select/ Unselect All <br/>'.$this->Form->checkbox("SelectAll", array('id' => 'select-all','checked'=>'')); ?> </th> 
		    <th><?php echo ('Student Number');?></th>
            <th><?php echo ('Name');?></th>
			<th><?php echo ('Sex');?></th>	
	</tr>
	
	<?php 
    $count=1;
	foreach ($studentsections['Student'] as $student) { 

		
?>
	  <tr>         
		<td><?php echo $count;?></td>
       
   		 <td ><?php echo $this->Form->checkbox('Section.'.$count.'.selected_id',array('class'=>'checkbox1')); ?>&nbsp;</td> 
       <?php echo $this->Form->hidden('Section.'.$count.'.student_id',array('value'=>$student['id'])); ?>
        <td><?php echo $student['studentnumber']; ?>&nbsp;</td>
        <td><?php echo $student['full_name']; ?>&nbsp;</td>
		<td><?php echo $student['gender']; ?>&nbsp;</td>
       </tr>
         
	<?php 

	$count++;
	} ?>

</table>

</div>
</div>

<?php echo $this->Form->end();?>
<a class="close-reveal-modal">&#215;</a>

