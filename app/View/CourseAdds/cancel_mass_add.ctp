<?php ?>
<script type='text/javascript'>
function toggleViewFullId(id) {
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}
//Sub cat combo
</script>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<?php echo $this->Form->create('CourseAdd');?>

<p class="fs16">
                    <strong> Important Note: </strong> 
                  
                     
                      This tool will help you to cancel/delete  mass add courses. Mass add 
                      cancellation or deletion is possible if there is no grade submitted for
                      the selected courses.
                    
</p>
<div onclick="toggleViewFullId('ListPublishedCourse')"><?php 
	if (isset($organized_published_course_by_section) && 
	!empty($organized_published_course_by_section)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListPublishedCourseImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListPublishedCourseTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListPublishedCourse" style="display:<?php echo (isset($organized_published_course_by_section) ? 'none' : 'display'); ?>">

<table cellpadding="0" cellspacing="0">
<?php 

echo '<tr><td>'.$this->Form->input('Student.academic_year',array(
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')).
            '</td><td>'.$this->Form->input('Student.department_id',array(
            'label' => 'Department',
            'empty'=>"--Select Department--",
             'style'=>'width:200px'
            )).'</td></tr>';
            
          ?>
<tr> 
	<?php 
            
             echo '<tr><td>'. $this->Form->input('Student.year_level_id',array('label'=>'Year Level','empty'=>"--Select Year Level--")).'</td>'; 
            echo '<td>'. $this->Form->input('Student.program_id',array('label'=>'Program')).'</td></tr>'; 
            echo '<tr><td>'.$this->Form->input('Student.program_type_id',array('label'=>'Program Type',
			'empty'=>"--Select Program Type--")).'</td><td>'.$this->Form->input('Student.semester',array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'),'empty'=>'--select semester--')).'</td></tr>';   
            ?>
	<tr><td colspan=2><?php echo $this->Form->submit('Continue',array('name'=>'getsection','class'=>'tiny radius button bg-blue','div'=>'false')); ?> </td>	
</tr></table>

</div>
<?php 

if(isset($organized_published_course_by_section) && !empty($organized_published_course_by_section)) {

    
        echo "<div class='fs16'>";
  
                       echo "Department: ".$department_name.'<br/>'; 
                       echo "Program: ".$program_name.'<br/>'; 
                       echo "Program Type: ".$program_type_name.'<br/>';                
                       echo "Year Level: ".$year_level_id.'<br/>';
                       echo "Academic Year: ".$academic_year.'<br/>'; 
                       echo "Semester: ".$semester.'<br/>'; 
                       ?>
       <?php  
       echo "</div>";
           $display_button=0;
           $section_count=0;
            foreach($organized_published_course_by_section as $section_id=>$coursss) {
           $section_count++;
                if (!empty($coursss)) {
                    echo "<table id='fieldsForm'><tbody>";
                    
                    ?>
                   <tr><th colspan=7><?php echo "Section: ".$sections[$section_id]; ?></td></tr>
                    <tr><th colspan=7><?php echo "Select the course you want to cancel mass add."; ?></td></tr>
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
                        if($vc['grade_submitted']) {
                         echo '<td>**</td>';
                        
                        } else {
                           echo '<td>'.$this->Form->checkbox('PublishedCourse.'.$section_id.'.'.$vc['PublishedCourse']['id'],
                         array('class'=>'listOfPublishedCourse','id'=>$count)).'</td>';
                        }
                         
                         echo "<td>".$count.'</td><td>'.$vc['Course']['course_title'].'</td>';
                         echo "<td>".$vc['Course']['course_code']."</td>";
                         echo "<td>".$vc['Course']['lecture_hours']."</td><td>".$vc['Course']['tutorial_hours']."</td>";
                         echo "<td>".$vc['Course']['credit']."</td>";
                         
                         echo "</tr>";
                         echo "<tr><td colspan=7 id=cancel_".$count.">";
                         echo "</td></tr>";
                     
                        $count++;
                     } 
                    
                     echo "</tbody></table>";
                     
                 } else {
                   $display_button++;
                 
                 }
                 ?>
    
            <?php      
             }
             
             ?>
             
             
                                  <table>
            <tr>
               <?php if ($grade_submitted_counter!=$publish_counter) { ?>
                <td style='padding:0'> <?php 
                  echo $this->Form->submit('Cancel Mass Add',array('name'=>'cancelmassadd','div'=>'false'));?></td>
                  
                 
              <?php } ?>
            </tr>
            
              <tr>
            
                <td style='padding:0'> ** Those courses are not allowed for cancellation since one or 
                more students has got grade.</td>
            
            </tr>
</table>

<?php 
}
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
