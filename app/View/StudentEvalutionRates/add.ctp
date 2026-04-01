<?php echo $this->Form->create('StudentEvalutionRate'); ?>
<style>
.bordering {
border-left:1px #cccccc solid;
border-right:1px #cccccc solid;
}
.bordering2 {
border-left:1px #000000 solid;
border-right:1px #000000 solid;
border-top:1px #000000 solid;
border-bottom:1px #000000 solid;
}
.courses_table tr td, .courses_table tr th {
padding:1px
}
</style>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
<?php 
  if(!empty($courseList)) {
   ?>
           <div class='fs16'>
               <p class="fs16">
               This questionnaire has been prepared to get your views regarding the teaching performance of your instructor. Please   to the items on the questioner frankly and honestly.  Do not write your name on the questionnaire, but write the name of your instructor, your department and faculty, the title of the course, course number, the academic year, semester, and your college year in the spaces provided. After you have filled in these, read carefully each of the statements listed from 1 – 30 below.  Then indicate bow you evaluate your instructor on each statement by circling one of the following options against each statement:
               </p>
		       <u><?php echo $courseList['PublishedCourse']['Course']['course_title'].' ('.$courseList['PublishedCourse']['Course']['course_code'].')'; ?></u> is waiting your evaluation result. Please make sure that the submitted evaluation is correct as <strong> your evaluation will be used for improving quality of eduation</strong>. 
		       
		       <h5><?php
		      
		       echo 'Instructor: '.$courseList['PublishedCourse']['CourseInstructorAssignment'][0]['Staff']['Title']['title'].' '.$courseList['PublishedCourse']['CourseInstructorAssignment'][0]['Staff']['full_name'].'('.$courseList['PublishedCourse']['CourseInstructorAssignment'][0]['Staff']['Position']['position'].')';
		       echo '<br/> Course: '.$courseList['PublishedCourse']['Course']['course_title'].' ('.$courseList['PublishedCourse']['Course']['course_code'].')';

		       echo $this->Form->hidden('Instructor.full_name',array('label'=>false,'value'=>$courseList['PublishedCourse']['CourseInstructorAssignment'][0]['Staff']['Title']['title'].' '.$courseList['PublishedCourse']['CourseInstructorAssignment'][0]['Staff']['full_name'].' '.$courseList['PublishedCourse']['CourseInstructorAssignment'][0]['Staff']['Position']['position'].' '));
		      

		       ?></h5>
           </div>
           <table style="width:100%">
	  
			    <tr>
					<th width="5%" class="bordering2">S.N<u>o</u>
					</th>
					<th width="30%" class="bordering2">Question</th>
					<th width="40%" class="bordering2">Response</th>

				</tr>
				
				<?php 
				  $count=1;
				  $options=array(5=>'Very good',4=>'Good',
				  	3=>'Fair',2=>'Poor',1=>'Very Poor',0=>'Do not know');
				  $attributes=array(
                      'label'=>false,
                      'div'=>false,
                      'legend'=>false,
                      'separator'=>' ',
                      'required'=>true
                      //'hiddenField'=>false

				  );
				  foreach ($instructorEvalutionQuestionsObjective as $kc=>$vc) {
                        echo "<tr>";
                        echo "<td> $count ".$this->Form->hidden('StudentEvalutionRate.'.$count.'.instructor_evalution_question_id',array('label'=>false,'size'=>4,'div'=>false,
                        'value'=>$vc['InstructorEvalutionQuestion']['id'])).$this->Form->hidden('StudentEvalutionRate.'.$count.'.student_id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$courseList['CourseRegistration']['student_id'])).$this->Form->hidden('StudentEvalutionRate.'.$count.'.published_course_id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$courseList['CourseRegistration']['published_course_id']))."</td>";
                         echo "<td>".$vc['InstructorEvalutionQuestion']['question'].'/'.$vc['InstructorEvalutionQuestion']['question_amharic']."</td>";
                      
                         echo "<td>".$this->Form->radio('StudentEvalutionRate.'.$count.'.rating',$options,$attributes)."</td>";
                       
                        echo "</tr>";
                        $count++;

                    }

                    foreach ($instructorEvalutionQuestionsOpenEnded as $kc=>$vc) {


                        echo "<tr>";
                        echo "<td> $count ".$this->Form->hidden('StudentEvalutionComment.'.$count.'.instructor_evalution_question_id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$vc['InstructorEvalutionQuestion']['id'])).$this->Form->hidden('StudentEvalutionComment.'.$count.'.student_id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$courseList['CourseRegistration']['student_id'])).$this->Form->hidden('StudentEvalutionComment.'.$count.'.published_course_id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$courseList['CourseRegistration']['published_course_id']))."</td>";
                         echo "<td>".$vc['InstructorEvalutionQuestion']['question'].'/'.$vc['InstructorEvalutionQuestion']['question_amharic']."</td>";
                      
                         echo "<td>".$this->Form->input('StudentEvalutionComment.'.$count.'.comment',array('label'=>false))."</td>";
                       
                        echo "</tr>";
                        $count++;

                    }
                  ?>
                 <tr>
                 	<td colspan="4">
                 		<?php 
                         echo $this->Form->submit('Submit',array('class'=>'tiny radius button bg-blue','div'=>'false'));
                         ?>
                 	</td>

                 </tr>
			</table>
      <?php 
  }
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
