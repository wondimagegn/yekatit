<div class="users form">
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

    <div class="smallheading"><?php __('Create user account for system access'); ?></div>
	<table>
	<tr>
	<?php
	     echo '<td><table><tbody>';
		        echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Basic Data </strong></td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
                echo $this->Form->input('Staff.0.id');
                 echo '<tr><td>'.$this->Form->input('Staff.0.title_id',
            array('label'=>'Title','empty'=>'--select title--')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.position_id',
            array('label'=>'Position','empty'=>'--select position--')).'</td></tr>';
         
            if ($role_id == ROLE_SYSADMIN) {
            
            
              echo '<tr><td>'.$this->Form->input('Staff.0.college_id',
            array('label'=>'College','id'=>'college_id_1','empty'=>'--select college--',
            'onchange'=>'getDepartmentList(1)','style'=>'width:250px')).'</td></tr>';
            echo '<tr><td>'.$this->Form->input('Staff.0.department_id',
            array('label'=>'Department','id'=>'department_id_1','empty'=>'--select department--',
            'style'=>'width:250px')).'</td></tr>';
            
            }
           echo '<tr><td>'.$this->Form->hidden('Staff.0.user_id').'</td></tr>';
		   echo '<tr><td>'.$this->Form->input('Staff.0.first_name',
		   array('label'=>'First Name')).'</td></td>';
		  echo '<tr><td>'.$this->Form->input('Staff.0.middle_name',
		  array('label'=>'Middle Name')).'</td></tr>';
		      echo '<tr><td>'.$this->Form->input('Staff.0.last_name',
            array('label'=>'Last Name')).'</td></tr>';
            $from = date('Y') - Configure::read('Calendar.birthdayInPast');
            $to = date('Y') + Configure::read('Calendar.birthdayAhead');
            $format = Configure::read('Calendar.dateFormat');
             
            
             echo '<tr><td>'.$this->Form->input('Staff.0.birthdate',
            array('label'=>'Birth Date','dateFormat'=>$format,'minYear'=>$from,'maxYear'=>$to)).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Staff.0.email',
            array('label'=>'Email')).'</td></tr>';
            
        echo '</tbody></table>';
        echo '<td><table><tbody>';
		        echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Access Data</td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
                echo $this->Form->input('User.id');
                echo '<tr><td>'. $this->Form->input('username').'</td></td>';
		        echo '<tr><td>'.$this->Form->input('passwd',array('label'=>'Password')).'</td></tr>';	
		         echo '<tr><td>'.$this->Form->input('role_id',array('style'=>'width:250px','empty'=>'--select role--')).
		         '</td></tr>';	        
		
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
	
<?php 

echo $this->Form->end(__('Submit', true));?>
</div>

<script type="text/javascript">
  $(document).ready(function() { 
        $('#college_id').change(function () { 
           
             $('#department_assignment').load('/users/get_department/'+$(this).val());

        });
      
    
  });
</script>

