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
			    if(rowCount >2){
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

		<div class="smallheading"><?php echo __('Add Grade Type'); ?></div>
	<table>
	<tr><td style="padding-left:-150px">
	<?php
	  
		echo $this->Form->input('type',array('label'=>'Grade Type Name'));
		
	?>
	</td>
	</tr>
	<tr><td><?php echo $this->Form->input('used_in_gpa',array('label'=>'Used In GPA','checked'=>true)); ?></td></tr>
	<tr><td><?php echo $this->Form->input('scale_required',
	array('label'=>'Required Scale','checked'=>true,'type'=>'checkbox')); ?></td></tr>
	
	<tr><td class="fs15">Add possible grades with its point value for the above grade type you entered.</td></tr>
	<tr>
	<td>
	  <table id="grade"><tr><th>S.No</th><th>Grade</th><th>Point Value</th><th>Pass Grade</th></tr>
	    
	                <?php 
	                 
	                   if (!empty($this->request->data['Grade'])) {
		                    $count=1;
		                      foreach ($this->request->data['Grade'] as $bk=>$bv) {
		                      echo "<tr><td>".$count."</td><td>".$this->Form->input('Grade.'.$bk.'.grade',
		            array(
		            'value'=>isset($this->request->data['Grade'][$bk]['grade'])?$this->request->data['Grade'][$bk]['grade']:'','label'=>false,'div'=>false,'size'=>4)).
		            "</td><td>".$this->Form->input('Grade.'.$bk.'.point_value',
		            array(
		            'value'=>isset($this->request->data['Grade'][$bk]['point_value'])?$this->request->data['Grade'][$bk]['point_value']:'','label'=>false,'div'=>false,'size'=>4))."</td><td>".$this->Form->input('Grade.'.$bk.'.pass_grade',
		            array( 'value'=>isset($this->request->data['Grade'][$bk]['pass_grade'])?$this->request->data['Grade'][$bk]['point_value']:'','label'=>false,'div'=>false));
		                      echo "</td></tr>";
		                      $count++;
		                  }
		         } else {
		                echo "<tr><td>1</td><td>".$this->Form->input('Grade.0.grade',
		            array(
		            'value'=>isset($this->request->data['Grade'][0]['grade'])?$this->request->data['Grade'][0]['grade']:'','label'=>false,'div'=>false,'size'=>4)).
		            "</td><td>".$this->Form->input('Grade.0.point_value',
		            array(
		            'value'=>isset($this->request->data['Grade'][0]['point_value'])?$this->request->data['Grade'][0]['point_value']:'','label'=>false,'div'=>false,'size'=>4))."</td><td>".$this->Form->input('Grade.0.pass_grade',
		            array( 'value'=>isset($this->request->data['Grade'][0]['pass_grade'])?$this->request->data['Grade'][0]['point_value']:'','label'=>false,'div'=>false));
		                      echo "</td></tr>";
		         }
		         ?>
	                
	  </table>
	       <table><tr><td colspan=4>
		<INPUT type="button" value="Add Row" onclick="addRow('grade','Grade',3,'<?php echo $all_grade_detail; ?>')" />
		<INPUT type="button" value="Delete Row" onclick="deleteRow('grade')" />
	</td></tr></table>
	</td>
	</tr>
	</table>
	
<?php 

echo $this->Form->Submit('Submit',array('class'=>'tiny radius button bg-blue','div'=>false))

?>
</div>
<?php echo $this->Form->end();?>

