<div class="row">
<div class="large-12 columns">
<?php echo $this->Form->create('Section',array('action'=>'mass_student_section_add', "method"=>"POST"));
/*
	echo $this->Form->hidden('section_id', array('value'=>$section_id));
      echo $this->Form->input('Selected_student_id',array('label'=>'Students','id'=>'Selected_student_id','type'=>'select',
       'options'=>$sectionless_student,'empty'=>"--Select Student--"));
*/

echo $this->Form->hidden('SectionDetail.section_id',array('value'=>$section_detail['Section']['id']));

?>


<table>
 
    <tr><th colspan=4 class="smallheading"><?php 
 if(!empty($section_detail['Department']['name'])) {
echo  __('Select the student you want to place to '.$section_detail['Section']['name'].'('.$section_detail['Program']['name'].'-'.$section_detail['ProgramType']['name'].'-'.$section_detail['Department']['name'].')');
} else if(empty($section_detail['Department']['name'])) {
 echo  __('Select the student you want to place to '.$section_detail['Section']['name'].'('.$section_detail['Program']['name'].'-'.$section_detail['ProgramType']['name'].')');
}
?>

</th></tr>
	<tr>
	        
            <th><?php echo ('Noo.'); ?> </th>
            <th style="padding:0;width:30px;">
            <?php echo 'Select/ Unselect All <br/>'.$this->Form->checkbox("SelectAll", array('id' => 'select-all','checked'=>'')); ?> </th> 
          
			<th><?php echo ('Student Number');?></th>	
              <th><?php echo ('Name');?></th>
	</tr>
	
	<?php 
    $count=1;
	foreach ($students as $k=>$student) { 

		
?>
	  <tr>         
		<td><?php echo $count;?></td>
       
   		 <td><?php echo $this->Form->checkbox('Section.'.$count.'.selected_id',array('class'=>'checkbox1')); ?>&nbsp;</td> 
       <?php echo $this->Form->hidden('Section.'.$count.'.student_id',
array('value'=>$student['Student']['id']));
   echo $this->Form->hidden('Section.'.$count.'.section_id',
array('value'=>$section_detail['Section']['id']));

 ?>
		</td>
         <td><?php echo $student['Student']['studentnumber']; ?>&nbsp;</td>
         <td><?php echo $student['Student']['full_name']; ?></td>
       
       </tr>
         
	<?php 

	$count++;
	} 
?>

</table>

<?php 
if(!empty($students)){
	echo $this->Form->end('Submit');
}
?>
</div>
</div>
<a class="close-reveal-modal">&#215;</a>
