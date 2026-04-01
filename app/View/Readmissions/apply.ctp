<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<div class="readmissions form">
<?php echo $this->Form->create('Readmission');?>
	<div class="smallheading"><?php echo __('Apply For Readmission'); ?></div>
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
<?php echo $this->Form->end(array('label'=>__('Submit'),
'class'=>'tiny radius button bg-blue'));?>
</div>

	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
