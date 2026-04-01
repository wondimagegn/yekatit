<?php 
 echo $this->Form->create('Student');
if ($role_id != ROLE_STUDENT && !isset($student_academic_profile) ) {
?>
<table cellpadding="0" cellspacing="0">
<?php 	
        echo '<tr><td class="smallheading">Search Student Acadamic Profile</td></tr>';
        
		echo '<tr><td class="font">'.$this->Form->input('studentID',array('label' => 'Student Number/ID')).'</td></tr>';
       echo '<tr><td>'. $this->Form->Submit('Continue',array('name'=>'continue','div'=>false)).'</td></tr>';
?>
</table>
<?php 
}
if (!empty($student_academic_profile)) {
        echo $this->element('student_academic_profile');

}
?>
