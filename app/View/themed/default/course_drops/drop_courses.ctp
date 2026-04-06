<?php
echo $this->Form->create('CourseDrop');
 if (isset($student_section_exam_status) && !empty($student_section_exam_status)) {
     echo $this->element('student_basic'); 
 }
 if(isset($coursesDrop)){
    echo $this->element('course_drop_template');
}
 echo $this->Form->end();
?>
