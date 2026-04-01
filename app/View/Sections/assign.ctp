<?php 
 echo $this->Form->create('Section',array('id' => 'AssignmentForm'));  
?>
<script type='text/javascript'>

var image = new Image();
image.src = '/img/busy.gif';
//$("#runautoplacementbutton").attr('disabled', true);
 //Get placement setting summery  continueAssignment
function getSectionSummery() {
            //serialize form data
            var summery = $("#academicyearSearch").val();
            var exploded=summery.split('/');
          
            var academicYear= exploded[0]+'-'+exploded[1];
          
            $("#academicyearSearch").attr('disabled', true);
          
            $("#sectionNotAssignClass").empty().
            html('<img src="/img/busy.gif" class="displayed" >');
          //get form action
            var formUrl = '/sections/un_assigned_summeries/'+academicYear;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: summery,
                success: function(data,textStatus,xhr){
                    $("#academicyearSearch").attr('disabled', false);
                   
                    $("#sectionNotAssignClass").empty();
                    $("#sectionNotAssignClass").append(data);
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            });
            return false;
 }

  window.location.hash = '#assignmentDiv';
  

 
 
</script>
<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
		     <h2 class="box-title">
			<?php echo __('Section Assignment Only for Freshman Students');?>
		      </h2>
		</div>
		<div class="large-12 columns">
                   <p class="fs13"><strong>Important Note:</strong> Students can be involved in section management if and only if
<ol class="fs13" style="padding-top:0px; margin-top:0px">
	<li>They have student ID/number and</li>
	<li>They are admitted</li>
	<li>They should have curriculum</li>
</ol>
</p>
                </div>
		<div class="large-12 columns">
	          <table class="fs13 small_padding">
<tbody>
<tr>
<td style="width:60%">
    <table class="fs13 small_padding" >
	    <?php 
            echo '<tr>';
            echo '<td style="width:15%">Academic Year</td>';
            echo '<td style="width:35%">'.$this->Form->input('Section.academicyearSearch',array('id'=>'academicyearSearch',
                'label' => false,'type'=>'select','style'=>'width:60%','options'=>$acyear_array_data,
               
            'onchange'=>'getSectionSummery()',
                'empty'=>"--Select Academic Year--",'selected'=>isset($academicyear)?$academicyear:'')).'</td>'; 
           echo '<td style="width:15%">Program</td>';
              
            echo '<td style="width:35%">'. 
            $this->Form->input('Section.program_id',array('empty'=>"--Select Program--",'label'=>false)).'</td>';
            
            echo '</tr>'; 
            echo '<tr>';
            echo '<td style="width:15%">Program Type</td>';
            echo '<td style="width:35%">'. $this->Form->input('Section.program_type_id',array('empty'=>"--Select Program Type--",
            'label'=>false,'style'=>'width:60%')).
            '</td>'; 
             echo '<td style="width:15%">Assignment Type</td>';
            echo '<td style="width:35%">'. $this->Form->input('assignment_type',array('id'=>'assignmenttype','type'=>'select',
            'options'=>$assignment_type_array,'style'=>'width:60%','label'=>false,
            'empty'=>"--Select Assignment Type--")).'</td>';
            
            echo '</tr>';
            
            if(ROLE_COLLEGE != $role_id )
            {  
               echo '<tr>';
                echo '<td style="width:15%">Year Level</td>'; 
               echo '<td style="width:35%">'. $this->Form->input('Section.year_level_id',array('readonly'=>true,
               'label'=>false,'style'=>'width:60%')).'</td>'; 
               echo '</tr>';
               
            }
            echo '<tr><td colspan="2">'. $this->Form->Submit('Continue',array('name'=>'search','div'=>false,
            'id'=>'continueAssignment','class'=>'tiny radius button bg-blue')).'</td></tr>'; 
     ?> 
    </table>
</td>
   <td   style="width:40%" id="sectionNotAssignClass">
                <div class="fs15"><?php echo __('Tables: Summary of students who are not assign to section')?></div>
                <table style="border: #CCC solid 1px"><tbody>
                <?php 
                $count_program = count($programs);
                $count_program_type = count($programTypes);
                    echo '<tr><th style="border-right: #CCC solid 1px">'."ProgramType/ Program".'</th>'; //Display ProgramType/Program label
                    foreach($programs as $kp=>$vp) {
                        echo '<th style="border-right: #CCC solid 1px">'.$vp.'</th>';
                    }
                    echo '</tr>';
                    for($i=1;$i<=$count_program_type;$i++) {
                        echo '<tr><td style="border-right: #CCC solid 1px">'.$programTypes[$i].'</td>';
                        for($j=1;$j<=$count_program;$j++) {
                            echo '<td style="border-right: #CCC solid 1px">'.$summary_data[$programs[$j]][$programTypes[$i]].'</td>';
                        }
                        echo '</tr>';
                    }
                ?>
                </tbody></table>
     </td>
</tr>
<?php if(isset($curriculum_unattached_student_count) && $curriculum_unattached_student_count >0){
echo '<tr><td colspan="2" class="centeralign_smallheading">'.$curriculum_unattached_student_count.' students did not attached to the department 

curriculum, So these students did not participate in any section assignment.</td></tr>';

}?>
</tbody></table>

<div class="sections form" id="assignmentDiv">

<?php if($section_less_total_students>0) {?>
	<?php if(isset($sectionlessStudentCurriculum)) { 
		echo "<div class='info-box info-message'><span></span> The system notes that there is more than 1 curriculum taken by section 		

			unassigned students,So please select curriculum and press continue button.</div>";
		
		echo '<table><tr><td>'. $this->Form->input('Curriculum',array('type'=>'select','options'=>$sectionlessStudentCurriculumArray,
			'empty'=>"--Select Curriculum --")).'</td></tr>'; 
        echo '<tr><td>'. $this->Form->Submit('Continue',array('name'=>'continue','div'=>false)).'</td></tr></table>'; 
	 } ?>
<?php 
if(!empty($sections)){
?>
	<fieldset>
 		<legend class="smallheading"><?php echo __('Assign students to the given section'); ?></legend>
	
		<table>
	<?php
        echo "<div class='font'>".$collegename."</div>";
        //Display department name if user role is not college
        if(ROLE_COLLEGE != $role_id )
        {
        echo "<div class='font'>"."Department of ".$departmentname."</div>";
        }
		echo '<div class="font">'."Total number of ".$selected_program_name." students those are not assigned 

        to any section is: ".$section_less_total_students.'</div>';
        ?>
        <?php
        //foreach($students as $student) {
        //echo $this->Form->input('Student');
        //}
        $section_list_name=array();
		foreach($sections as $key=>$value) {
	    //echo $this->Form->hidden('Section.'.$key.'.id');
		 echo $this->Form->hidden('Section.'.$key.'.id', array('value'=>$value['Section']['id']));
      
        if($assignmenttype == "result") {
                $section_list_name[]=$value['Section']['name'].' (Current hosted students: '.$current_sections_occupation[$key].' Section students curriculum '.$sections_curriculum_name[$key].')';
        } else { 
            echo '<tr><td>'.$value['Section']['name'].' (Current hosted students: '.$current_sections_occupation[$key].
				' Section students curriculum '.$sections_curriculum_name[$key].')'.
            ''.$this->Form->input('Section.'.$key.'.number');
        }
	?>
	</td></tr>
	<?php
		}
        
	?>
        <tr><td class="auto-width"><?php 
        if($assignmenttype == "result"){
            echo $this->Form->input('Section.Sections',
            array('type' => 'select', 'multiple' => 'checkbox','div'=>'input select',
            'options'=>$section_list_name));
        }
        ?></td></tr>
		</table></tr>
        <table>
		<tr><td>
	<?php
		echo $this->Form->input('Section.academicyear',array('id'=>'academicyear','value'=>$academicyear,
        'readonly'=>'readonly'));
		
		//echo $this->Form->input('description');
	?>
	</td></tr>
	</table>
	</fieldset>
<?php echo $this->Form->Submit('Submit',array('div'=>false,'name'=>'assign','class'=>'tiny radius button bg-blue'));?> 
<?php 
} else if(empty($sections) && !($isbeforesearch)){
    echo "<div class='info-box info-message'><span></span> No section is found with these search criteria</div>";
}
?>
<?php } else if(($section_less_total_students<=0) && !($isbeforesearch)) { 
	echo "<div class='info-box info-message'><span></span> There is no section unassigned student in the search criteria </div>";
} ?>
<?php echo $this->Form->end();?>
	      </div>
        </div>
     </div>
</div>
