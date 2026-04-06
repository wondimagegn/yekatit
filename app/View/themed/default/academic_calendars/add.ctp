<div class="academicCalendars form">
<?php echo $this->Form->create('AcademicCalendar');?>
	
		<div class="smallheading"><?php __('Setup Academic Calendar'); ?></div>
	<?php
		echo "<table><tbody>";
	    echo "<tr><td><table><tr><td>".$this->Form->input('academic_year',array('id'=>'academicyear',
            'label' =>'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')).'</td></tr>';
        	echo "<tr><td>".$this->Form->input('semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';
         
		echo "<tr>";
		foreach($colleges as $college_id=>$college_name){
		

        if (isset($college_department[$college_id]) && count($college_department[$college_id])>0) {
            echo "<tr><td ><div class='smallheading'>".$college_name.'</div>&nbsp;&nbsp;&nbsp;';
            echo "<table><tbody>";
             if (!empty($college_department[$college_id])){
                  foreach($college_department[$college_id] as $department_id=>$department_name){
                  //echo "<tr><td>".$this->Form->input('department_id',array('multiple' => 'checkbox', 'value' => $department_id, 'selected' =>isset($this->data['AcademicCalendar']['department_id'])?$this->data['AcademicCalendar']['department_id']:$department_id))."</td></tr>";
                  $recorded=null;
                  if (isset($alreadyexisteddepartment) && !empty($alreadyexisteddepartment) && 
                   in_array($department_id,$alreadyexisteddepartment)){
                   $recorded="style='color:red'";
                  } 
                  
                  if (isset($this->data['AcademicCalendar']['department_id'])) {
                     if (in_array($department_id,$this->data['AcademicCalendar']['department_id'])) {
                        if (isset($recorded) && !empty($recorded)) {
                             echo '<tr '.$recorded.' ><td><input type="checkbox" 
                        name="data[AcademicCalendar][department_id][]" 
                        value='.$department_id.' 
                        id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>'; 
                        } else {
                           echo '<tr><td><input type="checkbox"  checked="checked" 
                        name="data[AcademicCalendar][department_id][]" 
                        value='.$department_id.' 
                        id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';     
                        }
                       
                    } else {
                      
                       echo '<tr><td><input type="checkbox" 
                        name="data[AcademicCalendar][department_id][]" 
                        value='.$department_id.'  
                        id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                    }
                  } else {
                     echo '<tr><td ><input type="checkbox"  checked="checked"  name="data[AcademicCalendar][department_id][]" value='.$department_id.' id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                  }
               
                 }
             }
        
        echo "</tbody></table></td></tr>";
       }
}
		
		/*
		if (isset($yearLevels) && !empty($yearLevels)) {
		foreach ($yearLevels as $yk=>$yv ) {
		   // echo "<tr><td>".$this->Form->input('year_level_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';
		    $year_recorded=null;
		    
              if (isset($year_recorded) && !empty($year_recorded) && 
               in_array($yk,$alreadyexistedyearlevel)){
               $year_recorded="style='color:green'";
              } 
               if ($year_recorded) {    
		             echo '<tr><td '.$year_recorded.'><input type="checkbox"  checked="checked" name="data[AcademicCalendar][year_level_id][]" value='.$yk.' id="AcademicCalendarYearLevelId'.$yk.'">'.$yv.'</td></tr>';
		                
		        } else {
		           echo '<tr><td ><input type="checkbox"  checked="checked" name="data[AcademicCalendar][year_level_id][]" value='.$yk.' id="AcademicCalendarYearLevelId'.$yk.'">'.$yv.'</td></tr>';
		        }
		  }
		}
		*/
        echo "</table></td>";
        echo "<td><table><tbody>";
	
		echo "<tr><td>".$this->Form->input('course_registration_start_date', array('label'=>'Registration Start')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_registration_end_date', array('label'=>'Registration End')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_add_start_date', array('label'=>'Course Add Start')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_add_end_date', array('label'=>'Course Add End')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_drop_start_date', array('label'=>'Course Drop Start')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_drop_end_date', array('label'=>'Course Drop End')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('grade_submission_start_date', array('label'=>'Grade Submission Start')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('grade_submission_end_date', array('label'=>'Grade Submission End')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('program_id').'</td></tr>';
		echo "<tr><td>".$this->Form->input('program_type_id').'</td></tr>';
		
		 echo "<tr><td>".$this->Form->input('year_level_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';
		echo "</tbody></table></td></tr>";
	?>
	 
<?php 
        echo "<tr><td>".$this->Form->end(__('Submit', true)).'</td></tr>';
        echo "</tbody></table>";
?>
      
</div>
