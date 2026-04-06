<?php echo $this->Form->create('Section',array('action'=>'add_student_section_update', 'method'=>"GET"));
	echo $this->Form->input('Selected_student_id',array('label'=>'Students','id'=>'Selected_student_id','type'=>'select',
       'options'=>$sectionless_student,'onchange'=>"this.form.submit();",'empty'=>"--Select Student--"));
	echo $this->Form->hidden('section_id', array('value'=>$section_id));
	//echo $students;
?>