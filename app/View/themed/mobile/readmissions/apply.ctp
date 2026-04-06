<div class="readmissions form">
<?php echo $this->Form->create('Readmission');?>
	<div class="smallheading"><?php __('Apply For Readmission'); ?></div>
	<?php
	    echo '<table >';
	    echo '<tr>';
	    echo '<td>';
	      echo '<table class="fs13 small_padding">';
	    echo '<tr><td style="width:26%">Academic Year</td><td style="width:74%">'.$this->Form->input('academic_year',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'','label'=>false,'style'=>'width:100px')).'</td></tr>';
	    echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
		echo '<tr><td style="width:26%">Semester</td><td style="width:74%">'.$this->Form->input('semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--','label'=>false,
            'style'=>'width:100px')).'</td></tr>';
	    echo '</td>';
	    echo '</tr>';
	    echo '</table>';
	    
	    echo '</td>';
	    
	    
	    echo '<td>';
	   echo $this->element('student_basic');
	    echo '</td>';
	    echo '</tr>';
	    echo '</table>';
		
		
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
