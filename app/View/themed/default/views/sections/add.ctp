<?php ?>
<script type='text/javascript'>

var image = new Image();
image.src = '/img/busy.gif';
//$("#runautoplacementbutton").attr('disabled', true);
 //Get placement setting summery 
function getSectionSummery() {
            //serialize form data
            var summery = $("#academicyear").val();
            var exploded=summery.split('/');
          
            var academicYear= exploded[0]+'-'+exploded[1];
          
            $("#academicyear").attr('disabled', true);
          
            $("#sectionNotAssignClass").empty().
            html('<img src="/img/busy.gif" class="displayed" >');
          //get form action
            var formUrl = '/sections/un_assigned_summeries/'+academicYear;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: summery,
                success: function(data,textStatus,xhr){
                    $("#academicyear").attr('disabled', false);
                   
                    $("#sectionNotAssignClass").empty();
                    $("#sectionNotAssignClass").append(data);
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            });
            return false;
 }
 
</script>
<div class="sections form">
<?php echo $this->Form->create('Section',array('onSubmit'=>'return checkForm(this);'));?>
<div class="centeralign_smallheading"><?php __('Add Section'); ?></div>
<p class="fs13"><strong>Important Note:</strong> Students can be involved in section management if and only if
<ol class="fs13" style="padding-top:0px; margin-top:0px">
	<li>They have student ID/number and</li>
	<li>They are admitted</li>
	<li>They should have curriculum</li>
</ol>
</p>
 <table><tr><td>
 <table><tr><td>
	<?php
        echo "<div class='font'>".$collegename."</div>";
        //Display department name if user role is not college
        if(ROLE_COLLEGE != $role_id )
        {
        echo "<div class='font'>"."Department of ".$departmentname."</div>";
        }
		//echo '<div class="font">'."Total number of students whose are not assigned 
        //to a section is: ".$section_less_total_students.'</div>';
        //debug($section_less_total_students);
        echo "<br/>";
        //echo $this->Form->hidden('name');
           echo $this->Form->input('academicyear',array('type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'id'=>'academicyear',
            'onchange'=>'getSectionSummery()',
            'selected'=>isset($thisacademicyear)?$thisacademicyear:''));
        echo "<br/>";
        echo $this->Form->input('number_of_class',array('label'=>'Number of Section','value'=>
			isset($this->data['Section']['number_of_class'])?$this->data['Section']['number_of_class']:''));
        echo "<br/>";
        if(ROLE_COLLEGE != $role_id ){
            echo $this->Form->input('prefix_section_name',array('after'=>'Eg. G(for Undergraduate Regular), PG(for Post graduate),A(for Advance Standing) etc.','value'=>isset($this->data['Section']['prefix_section_name'])?$this->data['Section']['prefix_section_name']:''));
			 echo "<br/>";
        }
        echo $this->Form->input('fixed_section_name',array('after'=>'Eg. Comp (for Computer Science), Acc (for Accounting) etc.','value'=>isset($this->data['Section']['fixed_section_name'])?$this->data['Section']['fixed_section_name']:''));
		echo "<br/>";
       
        echo $this->Form->input('variable_section_name',array('label'=>'Variable Section Name','id'=>'variablesectionname',
        'type'=>'select','options'=>$variable_section_name_array,'empty'=>"--Select Variable Section Name--", 
			'selected'=>isset($this->data['Section']['variable_section_name'])? $this->data['Section']['variable_section_name']:''));
        echo "<br/>";
        if(ROLE_COLLEGE != $role_id ){
			echo $this->Form->input('year_level_id');
			echo "<br/>";
        }
        echo $this->Form->input('program_id');
		echo "<br/>";
        echo $this->Form->input('program_type_id');
		echo "<br/>";
		/*
		echo $this->Form->input('academicyear',array('type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($thisacademicyear)?$thisacademicyear:''));
		*/
		//echo $this->Form->input('Student');
	?>
    </td></tr></table></td><td width="55%">
<div class="fs15">



</div>
<table style="border: #CCC solid 1px" id="sectionNotAssignClass"><tbody>
<tr>
    <td colspan="3">
      <?php echo __('Tables: Summary of students who are not assign to section for '.$thisacademicyear.'
academic year.')?>
    
    </td>
</tr>
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
 
 if(isset($curriculum_unattached_student_count) && $curriculum_unattached_student_count >0){
	echo '<tr><td colspan="3" class="centeralign_smallheading">'.$curriculum_unattached_student_count.' students did not attached to the department 
	curriculum, So these students did not participate in any section assignment.</td></tr>';

}
?>
</tbody></table></td>
    </tr></table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
