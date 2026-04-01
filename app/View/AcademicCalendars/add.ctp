<?php echo $this->Form->create('AcademicCalendar');?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
	     <h6 class="box-title">
			<?php echo __('Setup Academic Calendar'); ?>
	     </h6>
	  </div>
	  <div class="large-12 columns">
              	<?php
		echo "<table><tbody>";
	    echo "<tr><td><table><tr><td>".$this->Form->input('academic_year',array('id'=>'academicyear',
            'label' =>'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')).'</td></tr>';
        	echo "<tr><td>".$this->Form->input('semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';
           ?> 
            
            <?php echo '<tr><td>Select/ Unselect All'.$this->Form->checkbox("SelectAll", array('id' => 'select-all','checked'=>'')).'</td></tr>'; ?> 
            <?php 
        
         
		echo "<tr>";
		foreach($colleges as $college_id=>$college_name){
		

        if (isset($college_department[$college_id]) && count($college_department[$college_id])>0) {
            echo "<tr><td ><div class='smallheading'>".$college_name.'</div>&nbsp;&nbsp;&nbsp;';
            echo "<table><tbody>";
             if (!empty($college_department[$college_id])){
                  foreach($college_department[$college_id] as $department_id=>$department_name){
                  
                  $recorded=null;
                  if (isset($alreadyexisteddepartment) && !empty($alreadyexisteddepartment) && 
                   in_array($department_id,$alreadyexisteddepartment)){
                   $recorded="style='color:red'";
                  } 
                  
                  if (isset($this->request->data['AcademicCalendar']['department_id'])) {
                     if (in_array($department_id,$this->request->data['AcademicCalendar']['department_id'])) {
                        if (isset($recorded) && !empty($recorded)) {
                             echo '<tr '.$recorded.' ><td><input class="checkbox1" type="checkbox" 
                        name="data[AcademicCalendar][department_id][]" 
                        value='.$department_id.' 
                        id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>'; 
                        } else {
                           echo '<tr><td><input type="checkbox" class="checkbox1"  checked="checked" 
                        name="data[AcademicCalendar][department_id][]" 
                        value='.$department_id.' 
                        id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';     
                        }
                       
                    } else {
                      
                       echo '<tr><td><input type="checkbox" class="checkbox1"
                        name="data[AcademicCalendar][department_id][]" 
                        value='.$department_id.'  
                        id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                    }
                  } else {
                     echo '<tr><td ><input type="checkbox" class="checkbox1"  checked="checked"  name="data[AcademicCalendar][department_id][]" value='.$department_id.' id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                  }
               
                 }
             }
        
        echo "</tbody></table></td></tr>";
       }
}

        echo "</table></td>";
        echo "<td><table><tbody>";
	
		echo "<tr><td colspan='2'>".$this->Form->input('course_registration_start_date', array('label'=>'Registration Start','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('course_registration_end_date', array('label'=>'Registration End','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('course_add_start_date', array('label'=>'Course Add Start','type'=>'date','minYear'=>date('Y')-2,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('course_add_end_date', array('label'=>'Course Add End',
'type'=>'date','maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('course_drop_start_date', array('label'=>'Course Drop Start','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('course_drop_end_date', array('label'=>'Course Drop End','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('grade_submission_start_date', array('label'=>'Grade Submission Start','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('grade_submission_end_date', array('label'=>'Grade Submission End','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td colspan='2'>".$this->Form->input('grade_fx_submission_end_date', array('label'=>'Fx Grade Submission','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td colspan='2'>".$this->Form->input('senate_meeting_date', array('label'=>'Senate Meeting Date','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td colspan='2'>".$this->Form->input('graduation_date', array('label'=>'Graduation Date','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

		echo "<tr><td colspan='2'>".$this->Form->input('program_id').'</td></tr>';
		echo "<tr><td colspan='2'>".$this->Form->input('program_type_id').'</td></tr>';
		
		 echo "<tr><td colspan='2'>".$this->Form->input('year_level_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';
		 
		  echo "<tr><td colspan='2'>".$this->Form->input('online_admission_start_date', array('label'=>'Online Admission Start Date','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td colspan='2'>".$this->Form->input('online_admission_end_date', array('label'=>'Online Admission End Date','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
		 
		
		/*
		echo '<tr><td>'.$this->Form->input('excluding_department_id',array('type'=>'select',
		'name'=>'excluding_department_ids[]','style' => 'width:200px;height:auto;', 'multiple' => true,'options'=>$departments)).'</td><td>'.
		$this->Form->input('excluding_year_level_id',array('type'=>'select',
		'name'=>'excluding_year_level_ids[]','style' => 'width:200px;height:auto;', 'multiple' => true,'options'=>$yearLevels)).'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('excluding_program_id',array('type'=>'select',
		'name'=>'excluding_program_ids[]','style' => 'width:200px;height:auto;', 'multiple' => true,'options'=>$programs)).'</td><td>'.$this->Form->input('excluding_program_type_id',array('type'=>'select',
		'name'=>'excluding_program_type_ids[]','style' => 'width:200px;height:auto;', 'multiple' => true,'options'=>$programTypes)).'</td></tr>';
		*/
		
		
		echo "</tbody></table></td></tr>";
		
		
	?>
	 
<?php 
        echo "<tr><td>".$this->Form->end(array('label'=>__('Submit'),'class'=>'tiny radius button bg-blue')).'</td></tr>';
        echo "</tbody></table>";
?>
	  </div>
       </div>
    </div>
</div>
