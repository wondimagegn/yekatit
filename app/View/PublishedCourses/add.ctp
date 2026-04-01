<?php echo $this->Form->create('PublishedCourse');?>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Publish Semester Courses');?>
		      </h2>
		</div>
		<div class="large-12 columns">
                  <?php 
   if (!isset($turn_off_search)) {
?>
<table cellpadding="0" cellspacing="0">
<?php 
echo "<tr><td colspan=2 class='smallheading'> Publish or Prepare Semester Courses.</td></tr>";
echo '<tr><td colspan=2>'.$this->Form->input('Course.academicyear',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')).'</td></tr>';
            
          ?>
<tr> 
	<?php 
            
             echo '<tr><td>'. $this->Form->input('Course.year_level_id',array('label'=>'Year Level','empty'=>"--Select Year Level--")).'</td>'; 
            echo '<td>'. $this->Form->input('Curriculum.program_id',array('label'=>'Program','empty'=>"--Select Program--")).'</td></tr>'; 
            echo '<tr><td>'.$this->Form->input('Curriculum.program_type_id',array('label'=>'Program Type',
			'empty'=>"--Select Program Type--")).'</td><td>'.$this->Form->input('Curriculum.semester',
array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';   
            ?>
	<tr><td colspan=2><?php echo $this->Form->submit('Continue',array('name'=>'getsection','class'=>'tiny radius button bg-blue','div'=>'false')); ?> </td>	
</tr></table>
<?php 
}
?>
<div id="loading">

</div>
<table cellpadding="0" cellspacing="0">
<?php 

if (isset($turn_off_search)){
          
             echo '<tr><td class="smallheading"> Select the course you want to publish
for '.$academic_year.' of semester '.$semester.'</td></tr>'; 
            echo $this->Form->hidden('PublishedCourse.semester',array('value'=>$semester));
            echo $this->Form->hidden('PublishedCourse.program_id',array('value'=>$program_id));
            echo $this->Form->hidden('PublishedCourse.program_type_id',array('value'=>$program_type_id));
            echo $this->Form->hidden('PublishedCourse.academic_year',array('value'=>$academic_year));
            echo $this->Form->hidden('PublishedCourse.year_level_id',array('value'=>$year_level_id));
          
            foreach($sections as $key=>$value) {
              
            echo "<tr><td>".$this->Form->input('Section.selected.'.$key, array('class'=>'candidatePublishCourse',
     'label'=>$value,'type'=>'checkbox','value'=>$key,'checked'=>isset($selectedsection) && in_array($key,$selectedsection)? 'checked':'')).'</td></tr>';
		
		    }
          echo $this->Js->get("input.candidatePublishCourse")->event("change",
             $this->Js->request(array('controller'=>'publishedCourses',
			'action'=>'selectedPublishedCourses'), array(
						'update'=>"#candidate_published_course_list",
						'async' => true,
						'method' => 'post',
						'dataExpression'=>true,
					
						 'beforeSend' => '$("#busy_indicator").show();',
                        'complete' => '$("#busy_indicator").hide();',
      
						'data'=> $this->Js->serializeForm(array(
						'isForm' => false,
						'inline' => true
			))
		))
	);   
}

?>
</table>
<div id="candidate_published_course_list">
</div>
<?php 
    if (isset($show_publish_page)) {
       
        if(!empty($coursesss)) {
      ?>
    
           
           <?php 
          // echo "Check All/Uncheck All <br/>".$this->Form->checkbox(null, array('id' => 'select-all','checked'=>''));
           $display_button=0;
           $section_count=0;
           foreach($coursesss as $section_id=>$coursss) {
           $section_count++;
           
           if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=7><?php echo "Section: ".$selected_section[$section_id]; ?></td></tr>
                    <tr><th colspan=7><?php echo "Select the course you want to publish
for ".$academic_year." of semester ".$semester." "; ?></td></tr>
                    <tr>
                    <?php 
                    echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Lecture hour </th>";
                    echo "<th style='padding:0'> Tutorial hour </th>"; 
                    echo "<th style='padding:0'> Credit </th></tr>";
                    
                    $count=1;
                    foreach ($coursss as $kc=>$vc) {
                        echo "<tr>";
                       
                         echo '<td>'.$this->Form->checkbox('Course.'.$section_id.'.'.$vc['Course']['id'],
                         array('disabled'=>in_array($vc['Course']['id'],
                 $published_courses_disable_not_to_published[$section_id])?true:false)) . '</td>';
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         echo "<td>".$vc['Course']['credit']."</td>";
                         
                         echo "</tr>";
                        $count++;
                     } 
                    
                     echo "</tbody></table>";
                     
                 } else {
                   $display_button++;
                 
                 }
             }
             
            ?>
            
              <table>
            <tr>
               <?php if ($display_button!=$section_count) { ?>
                <td style='padding:0'> <?php 
                  echo $this->Form->submit('Publish Selected',array('name'=>'publishselected','class'=>'tiny radius button bg-blue','div'=>'false'));?></td>
                  
                  <td style='padding:0'> <?php 
                  echo $this->Form->submit('Publish Selected as Add',array('name'=>'publishselectedasadd','class'=>'tiny radius button bg-blue','div'=>'false'));?></td>
              <?php } ?>
            </tr>
           
           </table>
           <?php 
           if (!empty($taken_courses_allow_to_publishe_it)) {
           echo "<div class='smallheading'>Already taken coures of the selected section, you can check it the already taken 
           courses to allow students to register for the courses again. This happens when all students
           fail the course or not able to follow the course </div>";
            foreach($taken_courses_allow_to_publishe_it as $section_id=>$coursss) {
          
           if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=7><?php echo "Section: ".$selected_section[$section_id]; ?></td></tr>
                    <tr>
                    <?php 
                    echo "<th style='padding:0'> &nbsp;</th>";
                    echo "<th style='padding:0'> S.No </th>";
                    echo "<th style='padding:0'> Course Title </th>";
                    echo "<th style='padding:0'> Course Code </th>";
                    echo "<th style='padding:0'> Lecture hour </th>";
                    echo "<th style='padding:0'> Tutorial hour </th>"; 
                    echo "<th style='padding:0'> Credit </th></tr>";
                   
                    $count=1;
                    foreach ($coursss as $kc=>$vc) {
                        echo "<tr>";
                        
                         echo '<td>'.$this->Form->checkbox('Course.'.$section_id.'.'.$vc['Course']['id']).'</td>';
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         echo "<td>".$vc['Course']['credit']."</td>";
                         
                         echo "</tr>";
                        $count++;
                     } 
                    
                     echo "</tbody></table>";
                     
                 } 
             }
             ?>
              
             <?php 
           }
           
          }  
      
    }
  echo $this->Form->end();
?>
                </div>
        </div>
      </div>
</div>

<script type="text/javascript">
  
  $(document).ready(function() { 
    $(".candidatePublishCourse").each( function() {
            if ($(this).is(":checked")){
              $('#candidate_published_course_list').load('/publishedCourses/selectedPublishedCourses/2');
           }
    });
   }); 
</script>
<?php echo $this->Js->writeBuffer();?>
