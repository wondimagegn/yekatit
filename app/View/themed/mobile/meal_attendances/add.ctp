<script type="text/javascript">
	function maintainStudentIDFocus() {
		window.document.getElementById("studentnumber").focus();
		window.document.getElementById("studentnumber").select();
	}
</script>
<div class="mealAttendances form">
<?php echo $this->Form->create('MealAttendance', array('defaultbutton' => "submit", 'defaultfocus' => "TextBox1"));?>
<div class="smallheading"><?php echo 'Add Meal Attendance'; ?></div>
<?php if(isset($mealHalls)) {?>
<table cellpadding="0" cellspacing="0">
<?php 	
		echo '<tr><td class="font">'.$this->Form->input('meal_hall_id',array('label' => 'Meal hall', 'id'=>'id_meal_hall','type'=>'select', 'options'=>$mealHalls, 'empty'=>"--Select Meal Hall--")).'</td></tr>';
       echo '<tr><td>'. $this->Form->Submit('Continue',array('name'=>'continue','div'=>false)).'</td></tr>';
?>
</table>
<?php if(isset($mealTypes)) { ?>

	<table cellpadding="0" cellspacing="0">
		
	<?php
		//echo '<tr><td class="font"> Program</td>'; 
		echo '<tr><td class="font" colspan="4">'.$this->Form->input('meal_type_id',array('style'=>'width:200PX', 'tabindex' => '3', 'selected'=>isset($auto_detected_meal_type)?$auto_detected_meal_type:(isset($this->data['MealAttendance']['meal_type_id']) ? $this->data['MealAttendance']['meal_type_id'] : ""))).'</td></tr>';
		//echo '<tr><td class="font"> Student ID</td>'; 
		echo '<tr><td class="font" colspan="4">'.$this->Form->input('studentnumber',array('label'=>'Student ID', 'id' => 'studentnumber', 'tabindex' => '4','style'=>'width:200PX')).'</td></tr>';
	
		echo '<tr><td colspan="4">'.$this->Form->Submit('Submit', array('name'=>'submit', 'id'=>'submit', 'tabindex' => '5', 'div'=>false)).'</td></tr>';
		}
		if(isset($students) && !empty($students)){
			echo '<tr><td colspan="4" style="text-align:center"><div class="smallheading"> Student Biodata To Check The Identity of Student.</div></td></tr>';
			echo '<tr><th> Student Name</th>';
			echo '<th> ID</th>';
			echo '<th> Gender</th>';
			echo '<th> Photo</th></tr>';
			echo '<tr><td>'.$students['Student']['full_name'].'</td>';
			echo '<td>'.$students['Student']['studentnumber'].'</td>';
			echo '<td>'.$students['Student']['gender'].'</td>';
			
			if(!empty($students['Attachment'])){
	            //echo '<tr><td colspan=2><strong>Attachment</strong></td></tr>';
                foreach($students['Attachment'] as $ak=>$av){
                   if(!empty($av['dirname']) && !empty($av['basename']) && strcasecmp($av['dirname'],'img')==0){
                  
                   echo '<td valign="top" align="right">'.$this->Media->embedAsObject($av['dirname'].DS.$av['basename'],array('width'=>144,'class'=>'profile-picture'))."</td></tr>";
            
		
                   }
                   
			    }
            } else {
               echo '<td valign="top" align="right"><img src="/img/noimage.jpg" width="144" class="profile-picture"></td></tr>';
               
            } 
		}
	?>
	</table>
<?php }
echo $this->Form->end();
?>
</div>
<script type="text/javascript">
maintainStudentIDFocus();
</script>
