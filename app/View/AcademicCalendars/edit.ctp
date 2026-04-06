<?php echo $this->Form->create('AcademicCalendar');?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
	     <h6 class="box-title">
		<?php echo __('Edit Setup Academic Calendar'); ?>
	     </h6>
	  </div>
	  <div class="large-12 columns">
           
	<?php
		echo "<table><tbody>";
		echo $this->Form->input('id');
	    echo "<tr><td><table><tr><td>".$this->Form->input('academic_year',array('id'=>'academicyear',
            'label' =>'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset(
            $this->request->data['AcademicCalendar']['academic_year'])? $this->request->data['AcademicCalendar']['academic_year']: $defaultacademicyear)).'</td></tr>';
        	echo "<tr><td>".$this->Form->input('semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';
		echo '<tr>';
		//debug($departments);
		//debug($departments_ids);
		
		echo '<td><table><tr><td>';
		 echo $this->Form->input('AcademicCalendar.department_id',array(
	    'type'=>'select',
	    'multiple'=>'checkbox',
	    'options'=>$departments,
	    'div'=>false,
	    'label'=>false,
	    'selected'=>isset($this->request->data['AcademicCalendar']['department_id']) ? $this->request->data['AcademicCalendar']['department_id']:array_keys($departments_ids) 
	    
    ));
		echo '</td></tr></table></td>';
		echo '</tr>';
		
        echo "</table></td>";
        echo "<td><table><tbody>";
	
		echo "<tr><td>".$this->Form->input('course_registration_start_date', array('label'=>'Registration Start','style'=>'width:80px',
'minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_registration_end_date', array('label'=>'Registration End','style'=>'width:80px','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_add_start_date', array('label'=>'Course Add Start','style'=>'width:80px','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_add_end_date', array('label'=>'Course Add End','style'=>'width:80px','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_drop_start_date', array('label'=>'Course Drop Start','style'=>'width:80px','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('course_drop_end_date', array('label'=>'Course Drop End','style'=>'width:80px','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('grade_submission_start_date', array('label'=>'Grade Submission Start','style'=>'width:80px',
'minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';
		echo "<tr><td>".$this->Form->input('grade_submission_end_date', array('label'=>'Grade Submission End','style'=>'width:80px','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1)).'</td></tr>';


echo "<tr><td colspan='2'>".$this->Form->input('grade_fx_submission_end_date', array('label'=>'Fx Grade Submission','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td colspan='2'>".$this->Form->input('senate_meeting_date', array('label'=>'Senate Meeting Date','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td colspan='2'>".$this->Form->input('graduation_date', array('label'=>'Graduation Date','type'=>'date','minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';
			echo "<tr><td>".$this->Form->input('program_id',array('style'=>'width:200px')).'</td></tr>';
		echo "<tr><td>".$this->Form->input('program_type_id',array('style'=>'width:200px')).'</td></tr>';
		
		 echo "<tr><td>".$this->Form->input('year_level_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';
		
		echo "<tr><td>".$this->Form->input('online_admission_start_date', array('label'=>'Online Admission Start Date','type'=>'date','minYear'=>date('Y')-2,'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';

echo "<tr><td>".$this->Form->input('online_admission_end_date', array('label'=>'Online Admission End Date','type'=>'date', 'minYear'=>date('Y')-2,
'maxYear'=>date('Y')+1,'style'=>'width:80px')).'</td></tr>';



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
