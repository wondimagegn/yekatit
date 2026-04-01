<?php
echo $this->Form->create('Section');  
if($role_id == ROLE_DEPARTMENT){
	echo "<div class='centeralign_smallheading'> List of Section-less Students</div>";
    echo "<div class='font'>".$college_name."</div>";
    echo "<div class='font'>"."Department of ".$department_name."</div>";
    echo "<div class='info-message info-box'><span></span><u>Note:</u><br/> - 
    Please be notice that the list of section less students doesn not include graduated,
    disciplinary dismissed, drop out students. It only lists  those students elegible and not have section  
    currently and readmitted students without section.</div>";


?>
<table cellpadding="0" cellspacing="0">
	<?php 
       
        echo '<tr><td width="250PX">'. $this->Form->input('Section.program_id',array('empty'=>"--Select Program--")).'</td>'; 
        echo '<td width="400PX">'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--")).'</td></tr>';  

        echo '<tr><td colspan="3">'. $this->Form->Submit('Search',array('name'=>'search','div'=>false)).'</td></tr>'; 
	?> 
</table>
<?php

if(!empty($sectionless_students_last_sections_details)){
		echo '<table style="border: #CCC solid 1px">';
        echo '<tr><th style="border-right: #CCC solid 1px">'. "No. ".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "ID".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "Name ".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "Last Section".'</th>
                <th style="border-right: #CCC solid 1px">'. "Year Level".'</th>'.
                '<th style="border-right: #CCC solid 1px">'. "Academic Year".'</th></tr>';
           $count = 1;
	foreach($sectionless_students_last_sections_details as $sslsdk => $sslsdv){
		 echo '<tr><td style="border-right: #CCC solid 1px">'.$count++.'</td>';
		 echo '<td style="border-right: #CCC solid 1px">'.
		 
		 $this->Html->link($sslsdv['Student'][0]['studentnumber'], array('controller' => 'students', 'action' => 'student_academic_profile', $sslsdv['Student'][0]['id'])).'</td>';
         echo '<td style="border-right: #CCC solid 1px">'.$this->Html->link($sslsdv['Student'][0]['full_name'], array('controller' => 'students', 'action' => 'student_academic_profile', $sslsdv['Student'][0]['id'])).'</td>';
         echo '<td style="border-right: #CCC solid 1px">'.$sslsdv['Section']['name'].'</td>';
		 echo '<td style="border-right: #CCC solid 1px">'.$sslsdv['YearLevel']['name'].'</td>';
         echo '<td style="border-right: #CCC solid 1px">'.$sslsdv['Section']['academicyear'].'</td></tr>';
	}
	echo '</table>';

} else if(empty($sectionless_students_last_sections_details) && !($isbeforesearch)) { 
	echo "<div class='info-box info-message'><span></span> There is no section-less students in the search criteria </div>";
}
} // close if department
$this->Form->end(); 
?>
