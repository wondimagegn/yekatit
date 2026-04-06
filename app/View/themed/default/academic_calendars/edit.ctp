<div class="academicCalendars form">
<?php echo $this->Form->create('AcademicCalendar');?>
	
		<div class="smallheading"><?php __('Setup Academic Calendar'); ?></div>
	<?php
		echo "<table><tbody>";
		echo $this->Form->input('id');
	    echo "<tr><td><table><tr><td>".$this->Form->input('academic_year',array('id'=>'academicyear',
            'label' =>'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset(
            $this->data['AcademicCalendar']['academic_year'])? $this->data['AcademicCalendar']['academic_year']: $defaultacademicyear)).'</td></tr>';
        	echo "<tr><td>".$this->Form->input('semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';
          
		///echo "<tr><td>".$this->Form->input('college_id',array('multiple' => 'checkbox', 'options' => $colleges, 'selected' =>array_keys($colleges))).'</td></tr>';
		echo '<tr>';
		
		echo '<td><table><tr><td>';
		 echo $this->Form->input('AcademicCalendar.department_id',array(
	    'multiple'=>'checkbox',
	    'options'=>$departments,
	    'div'=>false,
	    'label'=>false,
	    'selected'=>isset($this->data['AcademicCalendar']['department_id']) ? $this->data['AcademicCalendar']['department_id']:array_keys($departments_ids) 
	    
    ));
		echo '</td></tr></table></td>';
		echo '</tr>';
		
		/*echo "<tr>";
		foreach($colleges as $college_id=>$college_name){
		
                if (isset($college_department[$college_id]) && count($college_department[$college_id])>0) {
                    echo "<tr><td ><div class='smallheading'>".$college_name.'</div>&nbsp;&nbsp;&nbsp;';
                    echo "<table><tbody>";
                     if (!empty($college_department[$college_id])){
                          foreach($college_department[$college_id] as $department_id=>$department_name){
                         
                          if (isset($this->data['AcademicCalendar']['department_id'])) {
                             if (in_array($department_id,$this->data['AcademicCalendar']['department_id'])) {
                                echo '<tr><td><input type="checkbox"  checked="checked" 
                                name="data[AcademicCalendar][department_id][]" 
                                value='.$department_id.' 
                                id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                            } else {
                               echo '<tr><td><input type="checkbox" 
                                name="data[AcademicCalendar][department_id][]" 
                                value='.$department_id.' 
                                id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                            }
                          } else {
                             echo '<tr><td ><input type="checkbox" checked="checked" name="data[AcademicCalendar][department_id][]" value='.$department_id.' id="AcademicCalendarDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                          }
                         
                          
                         }
                     }
                
                echo "</tbody></table></td></tr>";
               }
        }
        */
		//echo "<tr><td>".$this->Form->input('department_id').'</td></tr>';
	
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
			echo "<tr><td>".$this->Form->input('program_id',array('style'=>'width:200px')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('program_type_id',array('style'=>'width:200px')).'</td></tr>';
		
		 echo "<tr><td>".$this->Form->input('year_level_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';
		
		echo "</tbody></table></td></tr>";
	?>
	 
<?php 
        echo "<tr><td>".$this->Form->end(__('Submit', true)).'</td></tr>';
        echo "</tbody></table>";
?>
      
</div>
