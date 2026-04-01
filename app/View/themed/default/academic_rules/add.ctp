<div class="academicRules form">
<?php echo $this->Form->create('AcademicRule');?>
<div style="padding-bottom:20px;"></div>
	<fieldset>
		<legend class="smallheading"><?php __('Add Academic Rule'); ?></legend>
	<?php
		
		echo $this->Form->input('name',array('options'=>array('SGPA'=>'Semester Grade Point Average ','CGPA'=>'Commulative Grade Point Average',
            'TWW'=>'Two Consecutive Warning','PFW'=>'Probation Followed By Warning'),'empty'=>'--select rule name--'));
		echo $this->Form->input('from');
		echo $this->Form->input('to');
		//echo $this->Form->input('AcademicStand');
		if (!empty($academicStandsDetail)) {
		    echo "<table>";
		    echo "<tr><th>Name</th>";
		    echo "<th>Year Level</th>";
		    echo "<th>Semester</th>";
		    echo "<th>Applay To </th></tr>";
		    foreach ($academicStandsDetail as $academicstandkey=>$academicstandvalue) {
		        echo "<tr><td>".$academicstandvalue['AcademicStand']['name']."</td>";
		        echo "<td>".$academicstandvalue['YearLevel']['name']."</td>";
		        echo "<td>".$academicstandvalue['AcademicStand']['semester'].'</td>';
		       
		       echo "<td>".$form->checkbox("AcademicStand.approve.".$academicstandvalue['AcademicStand']['id'])."</td></tr>";    
                                     
                     
                                          
		    }
		    echo "</table>";
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>



    <?php 
    /*
$i = 0;
foreach($academicStands as $k=>$language) :
$fld_id = "AcademicRule.".$i.".academic_stand_id";
echo $form->input($fld_id, array("type"=> "hidden", "value"=>$k)); // Dynamically creating hidden field to store id
$fld_title = "AcademicRule.".$i.".delete";	// Dynamically creating title field for user to input
echo $form->input($fld_title);
$i++;
endforeach;
*/
    ?>
</div>
