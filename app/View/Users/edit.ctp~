<?php echo $this->Form->create('User');?>
<script type='text/javascript'>

function getDepartmentList (id) {
       // var college = $("#ajax_college_id").val();
        var cid = $("#college_id_"+id).val();
        $("#department_id_"+id).attr('disabled', true);
		$("#department_id_"+id).empty();
		
		//get form action
		var formUrl = '/departments/get_department_combo/'+cid;
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
<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            <div class="users form">
    <div class="headerfont"><?php echo __('Edit  User Profile'); ?></div>
	<table>
	<tr>
	<?php
	     echo '<td><table><tbody>';
		       
		        echo '<tr><td colspan=2><strong>Basic Data </strong></td></tr>';
              
                echo $this->Form->input('Staff.0.id');
                 echo '<tr><td>'.$this->Form->input('Staff.0.title_id',
            array('label'=>'Title','empty'=>'--select title--')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.position_id',
            array('label'=>'Position','empty'=>'--select position--')).'</td></tr>';
            /*
            echo '<tr><td>'.$this->Form->input('Staff.0.college_id',
            array('label'=>'College','empty'=>'--select college--')).'</td></tr>';
            echo '<tr><td>'.$this->Form->input('Staff.0.department_id',
            array('label'=>'Department','empty'=>'--select department--')).'</td></tr>';
            */
            if ($role_id == ROLE_SYSADMIN) {
                echo '<tr><td>'.$this->Form->input('Staff.0.college_id',
            array('label'=>'College','id'=>'college_id_1','empty'=>'--select college--',
            'onchange'=>'getDepartmentList(1)')).'</td></tr>';
               /* 
               echo '<tr><td>'.$this->Form->input('Staff.0.department_id',
            array('label'=>'Department','id'=>'department_id_1','empty'=>'--select department--')).'</td></tr>';
            */
            }
            
            
            
            
             echo '<tr><td>'.$this->Form->hidden('Staff.0.user_id').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('Staff.0.first_name',array('label'=>'First Name',
		         'readOnly'=>'true')).'</td></td>';
		        echo '<tr><td>'.$this->Form->input('Staff.0.middle_name',array('label'=>'Middle Name',
		        'readOnly'=>'true')).'</td></tr>';
		         echo '<tr><td>'.$this->Form->input('Staff.0.last_name',
            array('label'=>'Last Name', 'readOnly'=>'true')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.birthdate',
            array('label'=>'Birth Date','style'=>'width:80px')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.email',
            array('label'=>'Email')).'</td></tr>';

              
  $options=array('male'=>'Male','female'=>'Female');
               echo '<tr><td> Gender '. $this->Form->input('Staff.0.gender',array('options'=>$options,'type'=>'radio','legend'=>false,'separator'=>'','label'=>false)).'</td></tr>';
            
        echo '</tbody></table>';
        echo '<td><table><tbody>';
		        
		        echo '<tr><td colspan=2><strong>Access Data</td></tr>';
               
                echo $this->Form->input('User.id');
              
                if($this->request->data['User']['is_admin']==1){
                      echo '<tr><td>';
                    echo $this->Form->input('active', array('label' => 'Active/Deactive', 
                 'type' => 'checkbox', 'checked' => (!isset($this->request->data['User']['active']) || 
                 $this->request->data['User']['active'] == 1 ? 'checked' : false)));
                      echo '</td></tr>';
                }
               
              

                echo '<tr><td>'. $this->Form->input('username',array( 'readOnly'=>'true')).'</td></td>';
                if ($this->request->data['User']['is_admin']==1 ) {
		        //    echo '<tr><td>'.$this->Form->input('role_id',array('empty'=>'--select role--')).'</td></tr>';
		        }	        
		echo '</tbody></table>';
		echo '<table>';
		 echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Address Data</td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
                echo '<tr><td>'.$this->Form->input('Staff.0.phone_office',
            array('label'=>'Phone Office')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.phone_mobile',
            array('label'=>'Phone Mobile')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.address',
            array('label'=>'Address')).'</td></tr>';
		echo '</table>';
		
		echo '</td>';
	?>
	</tr>
    	
	</table>
<?php echo $this->Form->end(array('label'=>__('Submit'),
'class'=>'tiny radius button bg-blue'));?>
</div>

	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
