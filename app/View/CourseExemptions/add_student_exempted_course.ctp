<?php 
?>
<SCRIPT language="javascript">
 
var courses=Array();
var courses_combo='';			
var index = 0;

<?PHP
    foreach($courses as $course_id=>$course_name){
    ?>
    index = courses.length;
    courses[index] = new Array();
    courses[index][0] = "<?php echo $course_id; ?>";
    courses[index][1] = "<?php echo $course_name; ?>";
    courses_combo +="<option value='<?php echo $course_id;?>'><?php echo $course_name;?></option>";
    <?php
   }
?>

var totalRow = <?php if(!empty($this->request->data)) echo (count($this->request->data['CourseExemption'])); else if(!empty($exemptedCourseLists)) echo (count($exemptedCourseLists)); else echo 2; ?>;

function updateSequence(tableID) {
	var s_count = 1;
	for(i = 1; i < document.getElementById(tableID).rows.length; i++) {
		document.getElementById(tableID).rows[i].cells[0].childNodes[0].data = s_count++;
	}
}

    function addRow(tableID,model,no_of_fields,all_fields) {
		   	var elementArray = all_fields.split(',');
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			totalRow++;
            row.id = model+'_'+totalRow;
			var cell0 = row.insertCell(0);
			
			cell0.innerHTML = rowCount;
			
			//construct the other cells
			for(var j=1;j<=no_of_fields;j++) {
				var cell = row.insertCell(j);
				
				if (elementArray[j-1] == "course_id") {
				        var element = document.createElement("select");						
						string = "";
						for (var f=0;f<courses.length;f++) {
						   string += '<option value="'+courses[f][0]+'"> '+courses[f][1]+'</option>';
						}
						
						element.id = "course_id_"+rowCount;
			            //element.innerHTML = string;
			            element.innerHTML = courses_combo;
				 
				} else if (elementArray[j-1] == 'taken_course_title') {
				       var element = document.createElement("input");
				       element.size = "20";
				       element.type = "text";
				} else if (elementArray[j-1] == "taken_course_code") {
				      
				        var element = document.createElement("input");
				        element.size = "4";
				        element.type = "text";
				} else if (elementArray[j-1] == "course_taken_credit") {
				      
				        var element = document.createElement("input");
				        element.size = "4";
				        element.type = "text";
				} 
				
				
				element.name = "data["+model+"]["+rowCount+"]["+elementArray[j-1]+"]";
				
				cell.appendChild(element);
		   }   
           updateSequence(tableID);
		}

		function deleteRow(tableID) {
			
			try {
			    var table = document.getElementById(tableID);
			    var rowCount = table.rows.length;
			    if(rowCount !=0 ){
                   table.deleteRow(rowCount-1);
				   updateSequence(tableID);
			    } else {
			
			        alert('No more rows to delete');
			    }
			
			}catch(e) {
				alert(e);
			}
			
		}


function deleteSpecificRow(id) {
	try {
		var row = document.getElementById(id);
		//var table = row.parentElement;
		var table = row.parentNode;
		if(table.rows.length > 2 ){
			
			row.parentNode.removeChild(row);
			updateSequence('course_details');
			//row.parentElement.removeChild(row);
		} else {
			alert('There must be at least one exam type.');
		}
	}catch(e) {
		alert(e);
	}
}
		
</SCRIPT>

<?php 

$course_details=array('taken_course_title'=>1,
'taken_course_code'=>2,'course_taken_credit'=>3,'course_id'=>4);
$all_course_details = "";
$sep = "";
foreach ($course_details as $key => $tag) {
        $all_course_details.= $sep.$key;
        $sep = ",";
}
?>

<div class="row">
<div class="large-12 columns">

<?php echo $this->Form->create('CourseExemption',array('action'=>'add_student_exemption', "method"=>"POST"));
	 echo '<h3>'.$student_detail['Student']['first_name'].' '.$student_detail['Student']['middle_name'].' '.$student_detail['Student']['last_name'].'('.$student_detail['Student']['studentnumber'].')'.'</h3>';

echo '<h6>Please provide the list of courses the student has  taken in other university and exempted</h6>';


echo $this->Form->hidden('CourseExemption.0.student_id',
array('value'=>$student_detail['Student']['id']));
if(!empty($exemptedCourseLists['CourseExemption'][0]['transfer_from'])){
   echo $this->Form->input('CourseExemption.0.transfer_from',
array('value'=>$exemptedCourseLists['CourseExemption'][0]['transfer_from']));
} else {
	echo $this->Form->input('CourseExemption.0.transfer_from');
}


?>

<table id="course_details">
	            <tr><th>S.No</th><th> Course Title</th>
<th> Course Code</th><th>ECTS/Credit</th><th>Equivalent Course</th><th>Action</th></tr>
	            
	    <?php 
	   if (!empty($exemptedCourseLists)) 
       {
		  $count=1;
		  $bkc=0;
		  foreach ($exemptedCourseLists as $bk=>$bv) {
		  

		  		//echo $this->Form->hidden('CourseExemption.'.$bkc.'.student_id',array( 'value'=>$bv['CourseExemption']['student_id']));

		    echo "<tr id='CourseExemption_".$count."'><td>".$count."</td><td>".$this->Form->input('CourseExemption.'.$bkc.'.taken_course_title',
		    	array('value'=>isset($bv['CourseExemption']['taken_course_title'])?$bv['CourseExemption']['taken_course_title']:'',
'label'=>false,'div'=>false,'size'=>20)).$this->Form->hidden('CourseExemption.'.$bkc.'.id',array( 'value'=>$bv['CourseExemption']['id']))."</td><td>".$this->Form->input('CourseExemption.'.$bkc.'.taken_course_code',array( 'value'=>isset($bv['CourseExemption']['taken_course_code'])?$bv['CourseExemption']['taken_course_code']:'','label'=>false,'div'=>false,'size'=>4))
.'</td>';

echo '<td>'.$this->Form->input('CourseExemption.'.$bkc.'.course_taken_credit',array( 'value'=>isset($bv['CourseExemption']['course_taken_credit'])?
	$bv['CourseExemption']['course_taken_credit']:'','label'=>false,'div'=>false,'size'=>4,
'type'=>'number')).
'</td>';

echo '<td>'.$this->Form->input('CourseExemption.'.$bkc.'.course_id',array('options'=>$courses,'type'=>'select',
	'label'=>false,'id'=>"course_id_".$count,
	'selected'=>!empty($bv['CourseExemption']['course_id'])?$bv['CourseExemption']['course_id'] :'','required'));
		                      echo "</td><td><a 
		                      href='javascript:deleteSpecificRow(\"CourseExemption_".$count."\")'>Delete</a></td></tr>";
		                      $count++;
		                      $bkc++;
		}
     } else {
		echo "<tr id='CourseExemption_1'><td>1</td><td>".$this->Form->input('CourseExemption.0.taken_course_title',array('value'=>isset($this->request->data['CourseExemption'][0]['taken_course_title'])?$this->request->data['CourseExemption'][0]['taken_course_title']:'','label'=>false,'size'=>12,'required')).'</td>';

echo '<td>'.$this->Form->input('CourseExemption.0.taken_course_code',array( 'value'=>isset($this->request->data['CourseExemption'][0]['taken_course_code'])?$this->request->data['CourseExemption'][0]['taken_course_code']:'','label'=>false,'size'=>10,'required')).'</td>';

echo '<td>'.$this->Form->input('CourseExemption.0.course_taken_credit',array( 'value'=>isset($this->request->data['CourseExemption'][0]['course_taken_credit'])?$this->request->data['CourseExemption'][0]['course_taken_credit']:'','label'=>false,'size'=>4,
'type'=>'number','required'));

echo "</td><td>".$this->Form->input('CourseExemption.0.course_id',array('options'=>$courses,'type'=>'select','label'=>false,
'selected'=>!empty($this->request->data['CourseExemption'][0]['course_id'])?$this->request->data['CourseExemption'][0]['course_id'] :'','id'=>"course_id_0",
'required'));
		                      echo "</td><td><a 
		                      href='javascript:deleteSpecificRow(\"CourseExemption_1\")'>Delete</a>
		                      </td></tr>";
		                      
		 }
		         ?>
	        </table>
	        <table>
	            <tr><td colspan=4><INPUT type="button" value="Add Row" 
	            onclick="addRow('course_details','CourseExemption',4,
	            '<?php echo $all_course_details; ?>')" />
		            <INPUT type="button" value="Delete Row" 
		            onclick="deleteRow('course_details')" />
	            </td></tr>
	 </table>

<?php 

	
echo $this->Form->end('Add/Update Exemption');

?>
</div>
</div>
<a class="close-reveal-modal">&#215;</a>
