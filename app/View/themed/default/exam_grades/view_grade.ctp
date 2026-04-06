<?php ?>
<script>
$(document).ready(function () {
	$("#PublishedCourse").change(function(){
		//serialize form data
		var pc = $("#PublishedCourse").val().split('~', 2);
		if(pc.length > 1) {
			window.location.replace("/exam_grades/<?php echo $this->action; ?>/"+pc[1]+"/section/"+
			$("#AcadamicYear").val()+"/"+$("#Semester").val());
		} else {
			window.location.replace("/exam_grades/<?php echo $this->action; ?>/"+pc[0]+"/pc/"+
			$("#AcadamicYear").val()+"/"+$("#Semester").val());
	    }
	});
});

function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}
</script>
<div class="examGrades <?php echo $this->action; ?>">
<?php echo $this->Form->create('ExamGrade');?>
<div class="smallheading"><?php __('Exam Grade View');?></div>
<?php echo $this->element('publish_course_filter_by_dept'); ?>
<?php echo $this->Form->end(); ?>
<?php
//Displaying list of students with their grade
if(isset($students) && count($students) > 0 && !empty($course_detail) && !empty($section_detail))
	echo '<p style="font-size:14px"><strong>'.$course_detail['course_title'].' ('.$course_detail['course_code'].')</strong> '.' exam grade for <strong>'.$section_detail['name'].'</strong> section.</p>';
if(!empty($publishedCourses) && !isset($published_course_id)) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>Please select a course.</div>';
}
else if(isset($published_course_id) && count($students) <= 0 && count($student_adds) <= 0) {
	echo '<div id="flashMessage" class="info-box info-message"><span></span>The system unable to find list of students who are registered for the course you selected. Please contact your department for more information.</div>';
}
else if(isset($students)){
	if(count($students) > 0) {
		$in_progress = 0;
		$students_process = $students;
		$makeup_exam = false;
		$count = 1;
		$st_count = 0;
		$this->set(compact('students_process', 'count', 'st_count', 'in_progress', 'makeup_exam'));
		echo $this->element('exam_sheet');
		?>

	<?php
	}
	
	if(count($student_adds) > 0) {
		echo '<p style="font-size:14px">Students who add <strong>'.$course_detail['course_title'].' ('.$course_detail['course_code'].')</strong> course from other section/s.</p>';
		$students_process = $student_adds;
		$makeup_exam = false;
		$count = ((count($students))+1);
		$st_count = count($students);
		$in_progress = count($students);
		$this->set(compact('students_process', 'count', 'st_count', 'in_progress', 'makeup_exam'));
		echo $this->element('exam_sheet');
		?>
	<?php
	}

	if(count($student_makeup) > 0) {
		echo '<p style="font-size:14px">Students who are taking makeup exam for <strong>'.$course_detail['course_title'].' ('.$course_detail['course_code'].')</strong> course.</p>';
		$students_process = $student_makeup;
		$makeup_exam = true;
		$count = (count($students)+count($student_adds)+1);
		$st_count = (count($students)+count($student_adds));
		$in_progress = (count($students)+count($student_adds));
		$this->set(compact('students_process', 'count', 'st_count', 'in_progress', 'makeup_exam'));
		echo $this->element('exam_sheet');
	}
	
}
?>
</div>
