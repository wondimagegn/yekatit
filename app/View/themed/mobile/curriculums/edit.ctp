<?php echo $this->Form->create('Curriculum',array('type'=>'file','enctype' => 'multipart/form-data'));?>
<?php echo $this->Html->script('amharictyping'); ?>  
<script  type="text/javascript" >

	 function addRow(tableID,model,no_of_fields,all_fields) {
	       
			var elementArray = all_fields.split(',');
            
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell0 = row.insertCell(0);
			cell0.innerHTML = rowCount ;
			
			for(var i=1;i<=no_of_fields;i++) {
				var cell = row.insertCell(i);
				
				
				if (elementArray[i-1] == "name") {
				       
				       //var element = document.createElement("select");
								
			            /*var string='<option value="None">--Select Course Category--- </option>'
			            for(var i=0;i<pcount;i++) {
			             
				            string += '<option value="'+i+'"> '+cclist[i]+'</option>';
			            }
			
			            element.innerHTML = string;
			             */
			       	  /* var element = document.createElement("select");						
					   var string='<option value="None">--Select Course Category---</option>';
						for (var f=0;f<course_category_values.length;f++) {
						   string += '<option value="'+course_category_values[f][0]
						   +'">'+course_category_values[f][1]+'</option>';
						}
						
			            element.innerHTML = string;
			          	*/
			           var element = document.createElement("input");
				       element.size = "13";
				       element.type = "text";		              
				}
				
				if (elementArray[i-1] == "total_credit") {
				   var element = document.createElement("input");
				   element.size = "5";
				   element.type = "text";
				 
				}
				if (elementArray[i-1] == "mandatory_credit") {
				   var element = document.createElement("input");
				   element.size = "5";
				   element.type = "text";
				 
				}
				
				element.name = "data["+model+"]["+rowCount+"]["+elementArray[i-1]+"]";
				
				cell.appendChild(element);
			}

		}

		function deleteRow(tableID) {
			
			try {
			    var table = document.getElementById(tableID);
			    var rowCount = table.rows.length;
			    if(rowCount !=2 ){
                    table.deleteRow(rowCount-1);
			    } else {
			
			        alert('No more rows to delete');
			    }
			
			} catch(e) {
				alert(e);
			}
			
		}
		
		function addDropdownRow(tableID,controller,no_of_fields,
		all_fields,course_list_category) {
			 var elementArray = all_fields.split(',');
			 var cclist = course_list_category.split(',');
			
			var table = document.getElementById(tableID);
            
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			
			var pcount = cclist.length;
           for(var i=1;i<=no_of_fields;i++) {
              
			    var cell0 = row.insertCell(0);
			    cell0.innerHTML = rowCount+1 ;
			    var cell = row.insertCell(1);
			    var element = document.createElement("select");
								
			    var string='<option value="None">--Select Course Category--- </option>'
			    for(var i=0;i<pcount;i++) {
			     
				    string += '<option value="'+i+'"> '+cclist[i]+'</option>';
			    }
			
			    element.innerHTML = string;
			    element.name = "data["+controller+"]["+rowCount+"]["+elementArray[0]+"]";
			    cell.appendChild(element);
			    
			    var cell1 = row.insertCell(i);
				var element = document.createElement("input");
				element.type = "text";
				
				if (elementArray[i-1]== "total_credit") {
				    element.size = "13";
				}
				element.name = "data["+controller+"]["+rowCount+"]["+elementArray[i-1]+"]";
				cell.appendChild(element);
			
			}

		}

	</SCRIPT>
<div class="curriculums form">	
		<div class="smallheading"><?php __('Edit Curriculum'); ?> </div>
		<div>
		    <strong style="color:red">Important Note:</strong> <ol><li>English and amharic degree nomenclature is used 
	        in temporary and permanent diploma. Please make sure that it is correct and complete.</li>
	        <li>Course category which are marked as mandatory will be used to check if a student is ligible for graduation. Please 
	        make sure that it is correct and complete.</li>
	        <li> Minimum credit point/hour be used to check if a student is ligible for graduation. Please 
	        make sure that it is correct and complete  </li>
	        </ol>
		</div>
	<?php
	    echo "<table><tbody><tr><td>";
	    echo "<table><tbody>";
	    echo '<tr><td class="font">'.$college_name.'</td></tr>';
	    echo '<tr><td class="font">'.$department_name.'</td></tr>';
	    echo $this->Form->hidden('id',array('value'=>$this->data['Curriculum']['id']));
		echo '<tr><td>'.$this->Form->input('name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('program_id',array('empty'=>'--select program--')).'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('year_introduced').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('type_credit',array('empty'=>'--select credit type--','options'=>array('ECTS Credit Point'=>'ECTS Credit Point','Credit'=>'Credit'))).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('amharic_degree_nomenclature',array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);",
		'after'=>'ምሳሌ የሳይንስ ማስተርስ ዲግሪ ፤ የሳይንስ ባለር ዲግሪ  '));
		echo '<tr><td>'.$this->Form->input('specialization_amharic_degree_nomenclature',array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"));
		echo '<tr><td>'.$this->Form->input('english_degree_nomenclature',
		array('after'=>'Master of Science, Bachelor of Science')).'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('specialization_english_degree_nomenclature').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('certificate_name',
		array('after'=>'  E.g M.Sc. Program, B.Sc. Program ')).'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('minimum_credit_points').'</td></tr>';
		echo $this->Form->hidden('department_id',array('value'=>$department_id));
		
		echo '<tr><td>';
	
		echo '</td></tr>';
		//echo '<tr><td>'.$this->element('attachments', array('plugin' => 'media')).'</td></tr>';	
		
		echo "</tbody></table>";
		
		echo "</td>";
		
		echo "<td>";
		
		?>
		<table>
		<?php 
		$fields=array('name'=>1,'total_credit'=>2,'mandatory_credit'=>3);
		$all_fields = "";
	    $sep = "";
	    foreach ($fields as $key => $tag) {
				$all_fields.= $sep.$key;
				$sep = ",";
	    }
	     $course_category_values=array('mandatory'=>'Manadatory',' optional'=>'Optional','general'=>'General','elective'=>'Elective');
	    $course_category_list = "";
			$ccl ="";
			foreach($course_category_values as $pk =>$pv) {
				$course_category_list.=$ccl.$pv;
				$ccl = ",";
			}
		?>
		<tr><th colspan=5>Course Category and Its Total Credit Point/Hours</th></tr>
	  
		</table>
		<TABLE id="course_categories" >
		 <TR><td>S.N<u>o</u></td><td>Name</td><td>Total Credit</td><td>Mandatory Credit</td><td>Action</td</TR>
		<?php 
		    if (isset($this->data['CourseCategory']) && count($this->data['CourseCategory'])>0 ) {
		       $count=1;
		         foreach ($this->data['CourseCategory'] as $ck=>$cv) {
		            if (!empty($cv['id'])) {
		                      echo $this->Form->hidden('CourseCategory.'.$ck.'.id');
		                      echo $this->Form->hidden('CourseCategory.'.$ck.'.curriculum_id');
		                      $action_controller_id='edit~curriculums~'.$cv['curriculum_id'];
		                      
		            }
		           
		            echo "<tr><td>".$count."</td><td>".$this->Form->input('CourseCategory.'.$ck.'.name',array('label'=>false,'size'=>'7px')).'</td>';
		            
		            ?> 
		        
		            <?php 
		          
		            echo '<td>'.$this->Form->input('CourseCategory.'.$ck.'.total_credit',
		            array('label'=>false,'size'=>'7px')).'</td>';
		            echo '<td>'.$this->Form->input('CourseCategory.'.$ck.'.mandatory_credit',
		            array('label'=>false,'size'=>'7px')).'</td>';
		            if(!empty($action_controller_id)) {
		                
		                echo "<td>".$this->Html->link(__('Delete', true), array('action' => 'deleteCourseCategory', $cv['id'],$action_controller_id), null, sprintf(__('Are you sure you want to delete # %s?', true), $cv['name'])).'</td>';  
		                
		            }
		            
		            echo "</tr>";
		          $count++;
		        }
		    } else {
		    ?>
			      <TR>
			        <TD> 1 </TD>
			    
				
				<?php 
				     echo "<td>";
				     echo $this->Form->input('CourseCategory.0.name',array('label'=>false,'size'=>13));
				     echo "</td>";
					 echo "<td>".$this->Form->input('CourseCategory.0.total_credit',
					 array('size'=>5,'label'=>false,'div'=>false)).'</td>';
					
					echo '<td>'.$this->Form->input('CourseCategory.0.mandatory_credit',
					array('label'=>false,'size'=>5)).'</td>';
		            ?>
			        <td>&nbsp;&nbsp;</td>
		         </TR>
		    <?php 
		    }
		?>
		
		</TABLE>
		
		<table><tr><td colspan=3>
		
		<INPUT type="button" value="Add Row" onclick="addRow('course_categories','CourseCategory',3,'<?php echo $all_fields; ?>','<?php echo $course_category_list ?>')" /> 
		<INPUT type="button" value="Delete Row" onclick="deleteRow('course_categories')" />
	</td></tr></table> 
	
		</td>
		<?php 
		echo "</tr>";
		
		//echo '<tr><td>'.$this->element('attachments', array('plugin' => 'media','model'=>'Curriculum','div'=>false)).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('Attachment.0.file', array('type' => 'file')).'</td></tr>';
		echo '<tr><td>'.$this->Form->end(__('Submit', true)).'</td></tr>';
	
		echo "</tbody></table>";
		
		
		
	?>

</div>
