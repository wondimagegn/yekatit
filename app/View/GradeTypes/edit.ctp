<?php echo $this->Form->create('GradeType');?>
<SCRIPT language="javascript">

		function addRow(tableID,model,no_of_fields,all_fields) {
		    
		   	var elementArray = all_fields.split(',');
		  
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			
			var row = table.insertRow(rowCount);
           
			var cell0 = row.insertCell(0);
			
			cell0.innerHTML = rowCount;
			
			//construct the other cells
			for(var j=1;j<=no_of_fields;j++) {
				var cell = row.insertCell(j);
				
				if (elementArray[j-1] == "grade") {
				   var element = document.createElement("input");
				   element.size = "4";
				   element.type = "text";
				 
				} else if (elementArray[j-1] == 'point_value') {
				       var element = document.createElement("input");
				       element.size = "4";
				       element.type = "text";
				} else if (elementArray[j-1] == "pass_grade") {
				      
				        var element = document.createElement("input");
				        element.type = "checkbox";
				}
				
				
				element.name = "data["+model+"]["+rowCount+"]["+elementArray[j-1]+"]";
				
				cell.appendChild(element);
		   }   

		}

		function deleteRow(tableID) {
			
			try {
			    var table = document.getElementById(tableID);
			    var rowCount = table.rows.length;
			    if(rowCount !=0 ){
                    table.deleteRow(rowCount-1);
			    } else {
			
			        alert('No more rows to delete');
			    }
			
			}catch(e) {
				alert(e);
			}
			
		}
		

</SCRIPT>

<?php 

$grade_detail=array('grade'=>1,'point_value'=>2,'pass_grade'=>3);
$all_grade_detail = "";
$sep = "";
foreach ($grade_detail as $key => $tag) {
        $all_grade_detail.= $sep.$key;
        $sep = ",";
}
?>
<div class="gradeTypes form">
  <?php 
    if (isset($check_not_involved_in_grade_computing) && $check_not_involved_in_grade_computing == false) {
    
    ?>
    
		<div  class="info-box info-message"><span></span><?php echo __('The grade type can not be editted because it is attached to courses.'); ?></div>
    <table>
	<tr>
	
	<td style="width:10%">Grade Type:</td>
	<td style="width:90%">
	<?php
	    echo $this->request->data['GradeType']['type'];
	?>
	</td>
	</tr>
	<tr>
	<td style="width:10%"> Used in GPA
	</td>
	<td style="width:5%">
	<?php
	  if ($this->request->data['GradeType']['used_in_gpa']==1) {
	    echo 'Yes';
	  } else {
	    echo 'No';
	  }
	  
	?></td>
	
	
	</tr>
	
	<tr>
	<td style="width:10%"> Required Scale
	</td>
	<td style="width:5%">
	<?php
	 
	  if ($this->request->data['GradeType']['scale_required']==1) {
	    echo 'Yes';
	  } else {
	    echo 'No';
	  }
	  
	?></td>
	
	
	</tr>
	</table>
	<table>
	<tr><td class="fs15">List of grades with its point value for the above grade type.</td></tr>
	<tr>
	<td>
	  <table id="grade"><tr><th>S.No</th><th>Grade</th><th>Point Value</th><th>
	  Pass Grade</th></tr>
	    
	                <?php 
	                
	                
	               if (!empty($this->request->data['Grade'])) {
		                    $count=1;
		                      foreach ($this->request->data['Grade'] as $bk=>$bv) {
		                   
		                      echo "<tr><td>".$count."</td><td>".
		                      $bv['grade']."</td><td>".$bv['point_value']."</td>";
		                      if ($bv['pass_grade'] == 1) {
		                        echo '<td>';
		                        echo 'Yes';
		                        echo '</td>';
		                      } else {
		                        echo '<td>';
		                        echo 'No';
		                        echo '</td>';
		                      }
		                      
		                      echo "</tr>";
		                      $count++;
		             }
		          }
		         
		         ?>      
	  </table>
	</td>
	</tr>
	</table>
    <?php 
    
    } else {
  ?>
	
		<div  class="smallheading"><?php echo __('Edit Grade Type'); ?></div>
	<table>
	<tr><td style="padding-left:-150px">
	<?php
	    echo $this->Form->hidden('id');
		/*echo $this->Form->input('type',array('options'=>array('letter grade'=>'Letter Grade',
		'pass fail grade'=>'Pass/Fail Grade','numeric grade'=>'Numeric Grade'),
		'label'=>false));
	    */
	    echo $this->Form->input('type',array('label'=>false));
		
	?>
	</td>
	</tr>
	<tr><td><?php echo $this->Form->input('used_in_gpa',array('label'=>'Used In GPA')); ?></td></tr>
	<tr><td class="fs15">Add possible grades with its point value for the above grade type you entered.</td></tr>
	<tr>
	<td>
	  <table id="grade"><tr><th>S.No</th><th>Grade</th><th>Point Value</th><th>Pass Grade</th><th>Action</th></tr>
	    
	                <?php 
	                 
	                   if (!empty($this->request->data['Grade'])) {
		                    $count=1;
		                      foreach ($this->request->data['Grade'] as $bk=>$bv) {
		                     
		                       if (isset($bv['id']) && !empty($bv['id'])) {
		                            echo $this->Form->hidden('Grade.'.$bk.'.id',
		                            array('value'=>isset($this->request->data['Grade'][$bk]['id']) && !empty($this->request->data['Grade'][$bk]['id'])?$this->request->data['Grade'][$bk]['id']:''));
		                             $action_controller_id='edit~gradeTypes~'.$bv['grade_type_id'];
		                        }
		                      echo $this->Form->hidden('Grade.'.$bk.'.grade_type_id');
		                      
		                      echo "<tr><td>".$count."</td><td>".$this->Form->input('Grade.'.$bk.'.grade',
		            array(
		            'value'=>isset($this->request->data['Grade'][$bk]['grade'])?$this->request->data['Grade'][$bk]['grade']:'','label'=>false,'div'=>false,'size'=>4)).
		            "</td><td>".$this->Form->input('Grade.'.$bk.'.point_value',
		            array(
		            'value'=>isset($this->request->data['Grade'][$bk]['point_value'])?$this->request->data['Grade'][$bk]['point_value']:'','label'=>false,'div'=>false,'size'=>4))."</td><td>".$this->Form->input('Grade.'.$bk.'.pass_grade',
		            array( 'value'=>isset($this->request->data['Grade'][$bk]['pass_grade'])?$this->request->data['Grade'][$bk]['pass_grade']:'','label'=>false,'div'=>false)).'</td>';
		                      echo "<td>".$this->Html->link(__('Delete'), array('controller'=>'grades','action' => 'delete', $bv['id'], $action_controller_id), null, sprintf(__('Are you sure you want to delete # %s?'), $bv['id'])); 
		                      echo "</td></tr>";
		                      $count++;
		                  }
		         } else {
		                if (isset($this->request->data['Grade'][0]['id']) && !empty($this->request->data['Grade'][0]['id'])) {
		                   echo $this->Form->hidden('Grade.0.id');
		                }
		                echo "<tr><td>1</td><td>".$this->Form->input('Grade.0.grade',
		            array(
		            'value'=>isset($this->request->data['Grade'][0]['grade'])?$this->request->data['Grade'][0]['grade']:'','label'=>false,'div'=>false,'size'=>4)).
		            "</td><td>".$this->Form->input('Grade.0.point_value',
		            array(
		            'value'=>isset($this->request->data['Grade'][0]['point_value'])?$this->request->data['Grade'][0]['point_value']:'','label'=>false,'div'=>false,'size'=>4))."</td><td>".$this->Form->input('Grade.0.pass_grade',
		            array( 'value'=>isset($this->request->data['Grade'][0]['pass_grade'])?$this->request->data['Grade'][0]['pass_grade']:'','label'=>false,'div'=>false));
		                      echo "</td></tr>";
		         }
		         ?>
	                
	  </table>
	       <table><tr><td colspan=4>
		<INPUT type="button" value="Add Row" onclick="addRow('grade','Grade',3,'<?php echo $all_grade_detail; ?>')" />
		
	</td></tr></table>
	</td>
	</tr>
	</table>
<?php 
echo $this->Form->end(__('Submit'));
}
?>
</div>

