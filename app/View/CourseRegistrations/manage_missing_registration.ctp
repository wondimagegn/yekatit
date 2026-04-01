<?php ?>
<div class="row">
		<div class="large-12 columns">
			<table cellspacing="0" cellpadding="0" class="fs14">
				<tr>
					<td style="width:15%">Academic Year:</td>
					<td style="width:17%"><?php echo $this->Form->input('acadamic_year', array('class' => 'AYS', 'id' => 'AcadamicYear', 'label' => false, 'style' => 'width:100px', 'type' => 'select', 'options' => $academicYearList, 'empty' =>'--select academic year--' ,'onchange'=>'updateCourseListOnChangeofOtherField()')); ?></td>
					<td style="width:10%">Semester:</td>
					<td style="width:58%"><?php echo $this->Form->input('semester', array('class' => 'AYS', 'id' => 'Semester', 'label' => false, 'style' => 'width:100px', 'type' => 'select', 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'), 'empty' => '--select semester--','onchange'=>'updateCourseListOnChangeofOtherField()')); 
echo $this->Form->input('student_id', array('id' => 'StudentId', 'type' => 'hidden', 'value' =>$studentID));

?></td>
				</tr>
			</table>
		</div>

		<div class="large-12 columns" id="ListPublishCourse">
			
		</div>
		
</div>

<a class="close-reveal-modal">&#215;</a>

<script>


function updateCourseListOnChangeofOtherField() {
			$("#ListPublishCourse").empty();
			$("#ListPublishCourse").append('Loading ...');

			var formData='';
			var AcadamicYearStr=$("#AcadamicYear").val();
			var AcadamicYear=AcadamicYearStr.replace('/','-');
			
			var Semester= $("#Semester").val();
		    var StudentId= $("#StudentId").val();
			
            if((typeof AcadamicYear!="undefined" && typeof Semester!="undefined" && 
typeof StudentId!="undefined") || 
(AcadamicYear!='' && Semester!='' && StudentId!='')) {
            		formData = AcadamicYear+'~'+Semester+'~'+StudentId;
					
		    } else {
              return false;
		    }
          
            //$("#AcadamicYear").attr('disabled', true);
			//get form action
            var formUrl = '/courseRegistrations/getIndividualRegistration/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						
				        $("#AcadamicYear").attr('disabled', false);
						$("#Semester").attr('disabled', false);
						$("#ListPublishCourse").empty();
					    $("#ListPublishCourse").append(data);
                    
					},
                error: function(xhr,textStatus,error){
                       // alert(textStatus);
                }
			});			
	return false;	
 }


</script>
