<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
              
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

	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
