<?php ?>
<script type='text/javascript'> 
function getDepartmentList (id) {
        var cid = $("#college_id_"+id).val();
        $("#department_id_"+id).attr('disabled', true);
		$("#department_id_"+id).empty();
		
		//get form action
		var formUrl = '/departments/get_department_combo/'+cid+'/'+1;
		$.ajax({
			type: 'get',
			url: formUrl,
			data: cid,
			success: function(data,textStatus,xhr){
			        $("#department_id_"+id).attr('disabled', false);
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
            
<div class="staffs form">
<?php 
echo $this->Form->create('Staff',array('type'=>'file',
'novalidate' => true,'enctype' => 'multipart/form-data'));
echo $this->Form->hidden('id');

?>

		<div class="smallheading"><?php

		if(isset($this->request->data['Staff']['id']) && !empty($this->request->data['Staff']['id'])){
			 echo __('Update Staff Profile'); 

		} else {
			 echo __('Add Staff'); 	
		}
		

		 ?></div>
	<?php
		 $options=array('male'=>'Male','female'=>'Female');
		$attributes=array('legend'=>false,'label'=>false);
	    echo '<table>';
	    echo '<tr><td style="width:50%">';
	    echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">Basic </td></td>';
	    echo '<tr><td>'.$this->Form->input('title_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('position_id').'</td></tr>';
        echo '<tr><td>'.$this->Form->input('education').'</td></tr>';
        echo '<tr><td>'.$this->Form->input('servicewing').'</td></tr>';
		
		
		echo '<tr><td>'.$this->Form->input('first_name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('middle_name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('last_name').'</td></tr>';

		  echo '<tr><td>'.$this->Form->input('staffid').'</td></tr>';
       
        $from = date('Y') - Configure::read('Calendar.birthdayInPast');
        $to = date('Y') + Configure::read('Calendar.birthdayAhead');
        $format = Configure::read('Calendar.dateFormat');
        
		echo '<tr><td>'.$this->Form->input('birthdate',array('label'=>'Birth date','dateFormat'=>$format,'minYear'=>$from,'maxYear'=>$to,'style'=>'width:80px;')).'</td></tr>';
 
		echo '<tr><td> Gender '. $this->Form->input('gender',array('options'=>$options,'type'=>'radio','legend'=>false,'separator'=>'','label'=>false)).'</td></tr>';
		  echo '<tr><td> Profile Picture:'.$this->Form->input('Attachment.0.file', array('type' => 'file')).'</td></tr>';

		echo '</table>';
		echo '</td>';
		echo '<td>';
		 echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">Address </td></td>';
	     echo '<tr><td>'.$this->Form->input('country_id',
	     	array('empty'=>false,'value'=>68)).'</td></tr>';

	  
	    echo '<tr><td>'.$this->Form->input('phone_mobile').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('phone_office').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('phone_home').'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('email').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('alternative_email').'</td></tr>';
		
		echo '</table>';

		echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">College/Department To Service </td></td>';
	    echo '<tr><td>'.$this->Form->input('Staff.college_id',
            array('label'=>'College','id'=>'college_id_1','empty'=>'--select college--',
            'onchange'=>'getDepartmentList(1)')).'</td></tr>';

	     echo '<tr><td>'.$this->Form->input('Staff.department_id',
            array('label'=>'Department','id'=>'department_id_1','empty'=>'--select department--')).'</td></tr>';
	    
		echo '</table>';

		echo '</td></tr>';
	    echo '</table>';
		
		
	?>
<?php echo $this->Form->end(array('label'=>__('Submit'),
'class'=>'tiny radius button bg-blue'));?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->

<script type="text/javascript">
    (function($) {
       	 $('#college_id').change(function () { 
           
             $('#department_id_1').load('/users/get_department/'+$(this).val());

        });
    })(jQuery);
</script>
