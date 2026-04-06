<?php echo $this->Form->create('User');?>
<script type="text/javascript">
  function showIncludePre(id) {
	
	if ($("#"+id).is(":checked") && 
$(".onlyPre").css("display")=='none') {
            $(".onlyPre").css("display","block");    
        } else {
            $(".onlyPre").css("display","none");
        }
  }

  $(document).ready(function() { 
       /************Others College Checkbox*******************/
     
        if ($("#department").is(":checked")) {
            $("#departmentshow").css("display","block");    
        } else {
            $("#departmentshow").css("display","none");
        }
        
        if ($("#college").is(":checked")) {
                 $("#collegeshow").css("display","block");
        
        } else {
           $("#collegeshow").css("display","none");
        
        }
        // Add onclick handler to checkbox w/id checkme
       /**
       *Department Level Assignment
       */
       $("#department").click(function(){
        
        // If checked
        if ($("#department").is(":checked"))
        {
            //show the hidden div
            $("#departmentshow").show("fast");
            $("#collegeshow").hide("fast");
           
            if ($("#college").is(":checked")) {
                //alert('dsfsd');
                $('#college').attr('checked', false);
            }
        }
        else
        {      
            //otherwise, hide it 
            $("#departmentshow").hide("fast");
           
        }
       });
       /**
       *College Level Assignment
       */
       $("#college").click(function(){
        
        // If checked
            if ($("#college").is(":checked"))
            {
                //show the hidden div
                $("#departmentshow").hide("fast");
                $("#collegeshow").show("fast");
                if ($("#department").is(":checked")) {
                    //alert('dsfsd');
                    $('#department').attr('checked', false);
                }
            }
            else
            {      
                //otherwise, hide it 
                $("#collegeshow").hide("fast");
               
            }
      });
      
    
  });
</script>


<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title"> <?php echo __('Assign Responsibility');?></h2>
     </div>
     <div class="box-body">
	 <div class="row">
              <div class="large-12 columns">
                        <p><strong>Basic Form</strong>
                        </p>
			<strong>Important Note:</strong>
			<ol class="fs13" style="padding-top:0px; margin-top:0px">
				<li>Assignment to department will make the user to view and manage only those students in the assigned department.</li>
				<li>Assignment to college will make the user to view and manage only those students assigned to college but without department(Pre/Fresh)</li>
			</ol>

	      </div>
    </div>
    <div class="row">
	      <div class="large-6 columns">
		 <?php 
                    if (isset($basic_data['Staff'][0]['full_name'])) {
                        echo "Name:".$basic_data['Staff'][0]['full_name'].'<br>';
                    }
                     if (isset($basic_data['Staff'][0]['email'])) {
                        echo "Email: ".$basic_data['Staff'][0]['email'].'<br/>';
                    }
                     if (isset($basic_data['User']['username'])) {
                        echo "Username: ".$basic_data['User']['username'].'<br/>';
                    }
                     if (isset($basic_data['Role']['name'])) {
                        echo "Role: ".$basic_data['Role']['name'].'<br/>';
                    }
                   
                 ?>
	      </div>
		
	     <div class="large-6 columns">
        <div class="row">
			     <div class="large-12 columns">
          		  <span>
          		  
          	          <?php
          			echo $this->Form->hidden('id',
          	array('value'=>$id));	
          			echo $this->Form->hidden('StaffAssigne.id');		
          		    if (isset($collegelevel)) {
          			 echo $this->Form->input('StaffAssigne.collegelevel', array('id'=>'college','label'=>'Assign to college','type'=>'checkbox','checked'=>'checked'));
          		
          		     } else {
          				echo $this->Form->input('StaffAssigne.collegelevel', array('id'=>'college','label'=>'Assign to college','type'=>'checkbox'));
          		    }
                  	?>
          		<?php
                  if (isset($departmentlevel)) { //departmentlevel
                     echo $this->Form->input('StaffAssigne.departmentlevel', array('id'=>'department','label'=>'Assign to department','type'=>'checkbox','checked'=>'checked'));
                  } else {
                    echo $this->Form->input('StaffAssigne.departmentlevel', array('id'=>'department','label'=>'Assign to department','type'=>'checkbox'));
                  }
          		
          		
          ?>
          </span>
			  </div>
		  </div> 
      </div>
      <div class="row">
      <div class="large-12 columns">
          <table>
       <?php 
        
         echo "<tr><td>".$this->Form->input('StaffAssigne.program_id',array('type'=>'select','multiple'=>'checkbox')).'</td><td>'.$this->Form->input('StaffAssigne.program_type_id',array('type'=>'select','multiple'=>'checkbox')).'</td></tr>';

       ?>
     </table>
        
      </div>
       

      </div>
		  <div class="row">
			<div class="large-12 columns">
	                <div id="collegeshow">
    <?php 
$options = array();
$ccc[]=$this->request->data['StaffAssigne']['college_id'];
foreach($colleges as $value => $label) { 
  $options[] = array( 
    'name' => $label, 
    'value' => $value, 
    'selected' =>(isset($this->request->data['StaffAssigne']['college_id']) && in_array($value,$ccc)) ? true:false,
    'div'=>false,
    'onClick' => 'showIncludePre(this.id)' 
  ); 
  
} 
//debug($options);
        echo "<table><tr><td>Check the college the user is responsible for</td></tr><tr><td>".$this->Form->input('StaffAssigne.college_id',array('multiple' => 'checkbox','options'=>$options))."
                   </td></tr>
</table>";

$displaypre=isset($this->request->data['StaffAssigne']['collegepermission']) ? 'block':'none';
echo "<table class='onlyPre' style='display:".$displaypre."'><tr><td>Only Pre/Department Unassigned</td></tr><tr><td>".
$this->Form->input('StaffAssigne.collegepermission',
array('label'=>'Responsible Only for Pre/Department Unassigned'))."</td></tr>
</table>";

?>

  </div>
  

  <div id="departmentshow"> 
    
      <?php 
                 echo "<table>";
                 $count=0;
                 foreach($colleges as $college_id=>$college_name) {
                
		               if (isset($college_department[$college_id]) && count($college_department[$college_id])>0) {
		                 echo '<tr><td>Select/ Unselect All'.$this->Form->checkbox("SelectAll", array('id' => 'select-all','checked'=>'')).'</td></tr>'; 
		                 echo "<tr><td><div class='smallheading'>Check the departments the user is responbile  </div></td></tr>";
                                     echo "<tr><td ><div class='smallheading'>".$college_name.'</div>&nbsp;&nbsp;&nbsp;';
                        echo "<table><tbody>";
                         if (!empty($college_department[$college_id])){
                              foreach($college_department[$college_id] as $department_id=>$department_name){
                              if (isset($this->data['StaffAssigne']['department_id']) && !empty($this->data['StaffAssigne']['department_id']) && in_array($department_id,$this->data['StaffAssigne']['department_id'])) {
                             
                               echo '<tr><td ><input type="checkbox" class="checkbox1" checked="checked" name="data[StaffAssigne][department_id][]" value='.$department_id.' id="StaffAssigneDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                              } else {
                           
                               echo '<tr><td ><input type="checkbox" class="checkbox1"  name="data[StaffAssigne][department_id][]" value='.$department_id.' id="StaffAssigneDepartmentId'.$department_id.'">'.$department_name.'</td></tr>';
                               }
                             }
                         }
                    
                        echo "</tbody></table></td></tr>";
		               }
                 
         }
	
         echo "</table>";
    ?>
    </div>

			</div>
		  </div>     
 </div>
</div>
	<?php echo $this->Form->end(
array('label'=>__('Assign'),'class'=>'tiny radius button bg-blue'));?>
     </div>
</div>
