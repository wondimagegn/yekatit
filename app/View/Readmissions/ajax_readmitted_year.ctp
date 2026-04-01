<?php 
?>

<div class="row">
<div class="large-12 columns">

<?php echo $this->Form->create('Readmission',array('action'=>'readmission_data_entry', "method"=>"POST"));
	 echo '<h3>'.$student_detail['Student']['first_name'].' '.$student_detail['Student']['middle_name'].' '.$student_detail['Student']['last_name'].'('.$student_detail['Student']['studentnumber'].')'.'</h3>';

echo '<h6>Please select the academic year and semester student has been readmitted</h6>';


echo $this->Form->input('Search.student_id', 
array('type' => 'hidden', 'value'=>$student_detail['Student']['id']));

?>

<table>
		<tr>
			<th style="width:25%"></th>
 			<th style="width:25%">Academic Year</th>
			<th style="width:25%">Semester</th>
			<th style="width:25%"></th>
		
		</tr>
       <?php 
		$count=0;
		foreach($pAcYear as $k=> $Year) {
			$count++;
		    $ek=explode('~',$k);
			?>
			<tr>
				<td>
<?php 

if(!empty($ek[1])) {
  
echo $this->Form->input('Readmission.'.$count.'.id', 
array('type' => 'hidden', 'value'=>$ek[1]));

}
echo $this->Form->input('Readmission.'.$count.'.gp', array('type' => 'checkbox','class'=>'checkbox1', 'label' => false, 'id' => 'StudentSelection'.$count));

echo $this->Form->input('Readmission.'.$count.'.student_id', 
array('type' => 'hidden', 'value'=>$student_detail['Student']['id']));


echo $this->Form->input('Readmission.'.$count.'.academic_year', 
array('type' => 'hidden', 'value'=>$Year));


?>
</td>
				<td><?php echo $Year;?></td>

				<td>

 <?php      
if(!empty($ek[1])) {
 echo $this->Form->input('Readmission.'.$count.'.semester', array('label' => false,'type'=>'select','options'=>array('I'=>'I','II'=>'II','III'=>'III')));

} else {   
echo $this->Form->input('Readmission.'.$count.'.semester', array('label' => false,'type'=>'select','options'=>array('I'=>'I','II'=>'II','III'=>'III'),'empty'=>'select'));

}
?>

               </td>
			  <td>
			<?php 
              if(!empty($ek[1])) {
 					echo "Readmitted";
			  }
			?>
			  </td>

			</tr>


		<?php } ?>

	  <tr>
			<td>
			<?php 
             echo $this->Form->submit(__('Save ', true), array('name' => 'saveReadmission','class'=>'tiny radius button bg-blue', 'div' => false)); 
			?>
			</td>

			<td>
			<?php 
             echo $this->Form->submit(__('Delete ', true), array('name' => 'deleteReadmission','class'=>'tiny radius button bg-blue', 'div' => false)); 
			?>
			</td>
			<td>
              &nbsp;
			</td>
		

	 </tr>

</table>

</div>
</div>
<a class="close-reveal-modal">&#215;</a>
