<?php echo $this->Form->create('DepartmentTransfer');?>
<script type='text/javascript'>
      
//Sub cat combo
function updateDepartmentCollege(id) {
           
            //serialize form data
            var formData = $("#college_id_"+id).val();
			$("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled', true);
			$("#add_button_disable").attr('disabled',true);
			//get form action
            var formUrl = '/departments/get_department_combo/'+formData;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#department_id_"+id).attr('disabled', false);
						$("#college_id_"+id).attr('disabled', false);
						$("#add_button_disable").attr('disabled',false);
						$("#department_id_"+id).empty();
						$("#department_id_"+id).append(data);
					},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
      
 }
</script>

<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="smallheading"><?php echo __('Request Department Transfer'); ?></div>
	<table>
	    <tr>
	     <td style='width:55%'>
	        <table>
	           <tr>
	               <td class="fs16" >
	                 <?php echo __('Provide receiver college and department, your current department will make decision and forward to receiver department if your transfer is approved by your current department.');
	                     
	                    
	                 ?>
	                 Note: You will be responsible for all the consequences that such tranfer may entail.
	               </td>
	           </tr>
	            <?php
		            echo $this->Form->hidden('student_id',array('value'=>$student_section_exam_status['StudentBasicInfo']['id']));
		            echo '<tr><td>'.$this->Form->input('Student.college_id',array(
		            'id'=>'college_id_1',
		            'onchange'=>'updateDepartmentCollege(1)',
		            'label'=>'Receiver College','style'=>'width:250px')).'</td></tr>'; 
                    echo '<tr><td>'.$this->Form->input('department_id',
                    array('id'=>'department_id_1')).'</td></tr>';
 
		            echo '<tr>';
		                 echo '<td>'.$this->Form->input('transfer_request_date',
		                 array('maxYear' => date('Y'),'minYear'=>date('Y'),'style'=>'width:80px;')).'</td>';
		              
		            echo '</tr>'; 
		           
		         
	        ?>
	        </table>
	    
	    </td>
	    <td style='width:45%'><?php 
	       echo $this->element('student_basic');
	      
	    ?></td>
	    
	    </tr>
	    <tr>
	    <?php 
	       
	        echo '<td class="fs16">';
	             if (isset($attended_semester) && count($attended_semester)==1) {
	                    echo 'You have stayed in  '.$student_section_exam_status['Department']['name'].' department for one semester.';
	                     echo '<strong style="color:green">Note:</strong> You have stayed in  '.$student_section_exam_status['Department']['name'].' department <strong> '.count($attended_semester).' semester </strong>, request for transfer is elegible. Please do not request transfer if you joined your current department  on affirmative basis.';
	                    
	             } else if (isset($attended_semester) && count($attended_semester)>1) {
	                 echo '<strong style="color:red">Note:</strong> You have stayed in  '.$student_section_exam_status['Department']['name'].' department <strong> '.count($attended_semester).' semester </strong>, request for transfer can not be entertained. Please do not request transfer if you joined your current department  on affirmative basis.';
	             } else {
	                 echo '<strong style="color:red">Note:</strong>Please do not request transfer if you joined your current department  on affirmative basis.';
	             }
	        echo '</td>';
	    ?>
	    </tr>
	 <tr><td> <?php echo $this->Form->Submit('Save',array('name'=>'saveTransfer','class'=>'tiny radius button bg-blue','div'=>false,'id'=>'add_button_disable')); 
	 ?>
	 </td></tr>
</table>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
