<?php echo $this->Html->script('jquery-1.6.2.min'); ?>  
<?php echo $this->Html->script('jquery-department_placement');?>
<?php echo $this->Form->create('AcceptedStudent', array('action' => 'auto_report'));?> 
<h3>Auto Placement Report</h3>
<div class="reservedPlaces form">
<table><tbody><tr><td width="100%">
<table><tbody><tr> 
	
	<td>
	<?php if (!isset($auto_report)) { ?>
	
	 <?php 
	        echo '<div style="font-weight:bold">Academic Year:</div>';
			echo $this->Form->input('AcceptedStudent.academicyear',array('id'=>'academicyear',
            'label' => false,'type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--"));
            }
            
             echo $this->Form->Submit(__('Continue',true));
             ?>
      
	</td></tr>
	
</tbody></table>
</td>
</tr>

<tr><td colspan=2>
<?php

if(!empty($autoplacedstudents)){
$summery=$autoplacedstudents['auto_summery'];
unset($autoplacedstudents['auto_summery']);
if(!empty($autoplacedstudents)){
echo "<table><tbody><tr><td>".$this->Html->link($this->Html->image("pdf_icon.gif",array("alt"=>"Print to PDF")),
array('action'=>"print_autoplaced_pdf"),array('escape'=>false))." Print</td><td>".$this->Html->link($this->Html->image("xls-icon.gif",array('alt'=>'Export To Xls')),array('action'=>"export_autoplaced_xls"),array('escape'=>false))." Export</td></tr></tbody></table>";
echo "<table><tbody>";
echo "<tr><th colspan=3> Summery of Auto Placement.</th></tr>";
 echo "<tr><th>Department</th><th>Competitive Assignment</th><th> Privilaged Quota Assignment</th>";
foreach ($summery as $sk=>$sv){
         echo "<tr><td>".$sk."</td><td>".$sv['C']."</td><td>".$sv['Q'].'</td>';
        
}
echo "</tbody></table>";


foreach($autoplacedstudents as $key =>$data){
?>
<table>
 <tr><td colspan=11 class="headerfont"><?php echo $key ?></td></tr> 
	<tr>
           
            <th><?php echo ('Full Name');?></th>
			<th><?php echo ('Sex');?></th>
			<th><?php echo ('Student Number');?></th>
			<th><?php echo ('Assignment Type');?></th>
			<th><?php echo ('EHEECE Total Result');?></th>
			<th><?php echo ('Preference Order');?></th>
			<th><?php echo ('Department');?></th>
			<th><?php echo ('Academic Year');?></th>
			<th><?php echo ('Department approval');?></th>
			
			<th><?php echo ('Placement Type ');?></th>
			<th><?php echo ('Placement Based');?></th>
			
	</tr>
	<?php
	$i = 0;
	foreach ($data as $acceptedStudent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
      
        <td><?php echo $acceptedStudent['AcceptedStudent']['full_name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['sex']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['assignment_type']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?>&nbsp;</td>
		<td><?php 
		if(!empty($acceptedStudent['Preference'])){
		       foreach($acceptedStudent['Preference'] as $key=>$value){
		        if($value['department_id']==$acceptedStudent['Department']['id']){
	                	echo $value['preferences_order']; 
	                	break;
	        	}
		    }
		}
		?>&nbsp;</td>
		<td><?php echo $acceptedStudent['Department']['name']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?>&nbsp;</td>
		<td><?php echo isset($acceptedStudent['AcceptedStudent']['approval'])?'Approved By Department':'Not Approved By Department'; ?>&nbsp;</td>
	
		<td><?php echo $acceptedStudent['AcceptedStudent']['placementtype']; ?>&nbsp;</td>
		<td><?php echo $acceptedStudent['AcceptedStudent']['placement_based'] == 'C' ? 'Competitive' : 'Quota'; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>

	<?php 
	} 
} /*else {
	echo "<div class='info-box info-message'> <span></span>There is no auto placement report  in the selected 
academic year.</div>";
} 
*/
}
 ?>
</td></tr>
    </tbody></table>
   
</td></tr>
</tbody></table>

</div>
<?php echo $this->Form->end();?>

