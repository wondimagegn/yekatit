<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<div class="courseRegistrations form">
<?php echo $this->Form->create('CourseRegistration');?>
	
<?php

 echo $this->element('student_basic');
// debug($published_courses);
 
 if (isset($published_courses) && !empty ($published_courses)) 
{
   
            echo "<table id='fieldsForm'><tbody>";
            
            ?>
         
            
            <?php 
            echo "<tr><th style='padding:0'> Elective </th>";
            echo "<th style='padding:0'> S.No </th>";
            echo "<th style='padding:0'> Course Title </th>";
            echo "<th style='padding:0'> Course Code </th>";
            echo "<th style='padding:0'> Lecture hour </th>";
            echo "<th style='padding:0'> Tutorial hour </th>"; 
            echo "<th style='padding:0'> Credit </th></tr>";
            $count=1;
          
            foreach ($published_courses as $pk=>$pv) {
              
                 
                 // allow registration without passing prerequiste but the registration 
                 // should be cancelled by the registrar in case student grade is not changed.
                 
                 $style="class='accepted'";                
                
                 
                 // normal registration 
                 if (!isset($pv['prequisite_taken_passsed']) && !isset($pv['exemption']) || 
                 (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==1 )) {
                    
                      echo $this->Form->hidden('CourseRegistration.'.$count.'.published_course_id',array('value'=>$pv['PublishedCourse']['id']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.course_id',array('value'=>$pv['Course']['id']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.semester',array('value'=>$pv['PublishedCourse']['semester']));
                      echo $this->Form->hidden('CourseRegistration.'.$count.'.academic_year',array('value'=>$pv['PublishedCourse']['academic_year']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.student_id',
                     array('value'=>$student_section['Student']['id']));
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.section_id',
                     array('value'=>$student_section['Section'][0]['id']));
                     
                     echo $this->Form->hidden('CourseRegistration.'.$count.'.year_level_id',
                     array('value'=>$student_section['Section'][0]['year_level_id']));

                    
                     
                 }
                 
                 if (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==0) {
                     $style='class="rejected"';
                 }
                 
                 if (isset($pv['exemption']) && $pv['exemption']==1) {
                     $style='class="exempted"';
                 }
                 
                 
                 // type of registration 
                 
                 if ((isset($pv['registration_type']) && $pv['registration_type']==2
                 && !isset($pv['exemption']))) {
                    echo $this->Form->hidden('CourseRegistration.'.$count.'.type',array('value'=>11));
                        
                    echo "<tr><td></td><td>".$count++."</td><td>".$pv['Course']['course_title']."**"."</td>";
                 
                 } else if (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==2
                 && !isset($pv['exemption']) ) {
                    echo $this->Form->hidden('CourseRegistration.'.$count.'.type',array('value'=>11));
                        
                 echo "<tr><td>&nbsp;</td><td>".$count++."</td><td>".$pv['Course']['course_title']."**"."</td>";
                 
                 } else if ((isset($pv['registration_type']) && $pv['registration_type']==2) &&
                 (isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==2) 
                 && !isset($pv['exemption'])) {
                      echo $this->Form->hidden('CourseRegistration.'.$count.'.type',array('value'=>13));
                      
                 echo "<tr><td>&nbsp;</td><td>".$count++."</td><td>".$pv['Course']['course_title']."**"."</td>";
                 
                 } else  {
                     
                       if(($pv['PublishedCourse']['elective']==1)){
                         echo "<tr ".$style.">";
                         if(isset($pv['prequisite_taken_passsed']) && $pv['prequisite_taken_passsed']==0){
                             echo "<td>&nbsp;</td><td>".$count++."</td><td>".$pv['Course']['course_title']."</td>";
                         } else {
                                 echo "<td>".$this->Form->checkbox('CourseRegistration.'.$count.'.gp') ."</td><td>".$count++."</td><td>".$pv['Course']['course_title']."</td>";
                         }
                        

                       } else {
                         echo "<tr ".$style." ><td>&nbsp;</td><td>".$count++."</td><td>".$pv['Course']['course_title']."</td>";
                       }
                       
                     
                 }
                 
                 
                 echo "<td>".$pv['Course']['course_code']."</td>";
                 echo "<td>".$pv['Course']['lecture_hours']."</td>";
                 echo "<td>".$pv['Course']['tutorial_hours']."</td>";
                 echo "<td>".$pv['Course']['credit']."</td></tr>";
            }
          //}
           
           $options=array('1' => 'Cafe Consumer', '0' => 'Non Cafe');
        $attributes=array('legend'=>false,'label'=>false,'separator'=>'<span>','required'=>'true');
            
        echo '<tr><td colspan="2">Are you ? </td> <td>'.$this->Form->radio('CourseRegistration.0.cafeteria_consumer',$options,$attributes).
        '</td><td colspan="4"></td></tr>';

      

            if (!isset($deadlinepassed)) {
           		/* echo "<tr><td colspan=7>".$this->Form->end(array(
                    'onclick'=>"this.disable=true;this.value='Submitting...';this.form.submit();",
					'label'=>__('Register'),'class'=>'tiny radius button bg-blue'))."</td></tr>";
					*/
					echo "<tr><td colspan=7>".$this->Form->end(array(
					'label'=>__('Register'),'class'=>'tiny radius button bg-blue'))."</td></tr>";
					
            }
             echo "<tr><td colspan=7>Note: <ol>
                <li>Green marked courses  are courses you are elegible for registration.</li>
                <li>Red marked courses are courses you are not elegible for registration since you are not fullfilled prerequisite requirement.
                </li>
                 <li>Blue marked courses are courses that are exempted.
                
                </li>
                <li>** registration on hold, since either student academic  status is not generated or grade for the prerequsite is not submitted.
                
                </li>

                <li>checkbox courses are published as elective by the department.
                    
                    </li>
           
            </ol></td></tr>";
            echo  "</table>";
}    
            ?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
<style type="text/css">
    .ajax_status {
    display: none;
}
.ajax_success {
    color: #036A0D;
}

.ajax_error {
    color: #FF0000;
}

</style>
<script type="text/javascript">
    $(document).ready(function() {
    $("#Ecardnumber").focusout(function() {
       
            var formUrl = '/students/ajax_check_ecardnumber';
            $.ajax({
                type: 'post',
                url: formUrl,
                data: {'Student':{'ecardnumber':$("#Ecardnumber").val()}},
                success: function(data,textStatus,xhr){
                    if($("#Ecardnumber").val().length<8){
                          $("#ecard_ajax_result").empty();
                        $("#ecard_ajax_result").append('<span style="color:red">Invalid</span>');
                    } else {
                        $("#ecard_ajax_result").empty();
                        $("#ecard_ajax_result").append(data);
                    }
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            });
        });
});


</script>