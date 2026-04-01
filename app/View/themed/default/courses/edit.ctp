<?php
?>
<script type="text/javascript">

var prerequisite_courses=Array();
var index = 0;

<?PHP
    if(!empty($prerequisite_courses)){
        foreach($prerequisite_courses as $course_id=>$course_name){
        ?>
        index = prerequisite_courses.length;
        prerequisite_courses[index] = new Array();
        prerequisite_courses[index][0] = "<?php echo $course_id; ?>";
        prerequisite_courses[index][1] = "<?php echo $course_name; ?>";
      
        <?php
            }
     }
?>

       
 function addRowNew(tableID,model,no_of_fields,left_fields,right_fields) {
            var elementArrayLeft = left_fields.split(',');
			var elementArrayRight = right_fields.split(',');
           
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell0 = row.insertCell(0);
			cell0.innerHTML = rowCount;
			var left=1;
			var right=2;
			for(var i=1;i<=no_of_fields;i++) {
				var cell = row.insertCell(i);
			
			    //construct left_fields
			    if(left==i) {
			         
			          for(var l=1;l<=elementArrayLeft.length;l++){
			            //////////////////ISBN//////////////////////////////////////
			              if (elementArrayLeft[l-1] == "ISBN") {
			                 var text=document.createTextNode('ISBN');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				                            
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
            	       
            	          ///////////////////title///////////////////////////////
            	        if (elementArrayLeft[l-1] == "title") {
			                 var text=document.createTextNode('Title');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
            	            
            	       }
            	       
            	       /////////////////////////Edition//////////////////////////////////
            	       if (elementArrayLeft[l-1] == "edition") {
			                 var text=document.createTextNode('Edition');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            	                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
            	            
            	          }
            	          
            	         if (elementArrayLeft[l-1] == "author") {
			                 var text=document.createTextNode('Author');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
            	            
            	          }
            	          
            	         if (elementArrayLeft[l-1] == "journal_title") {
			                 var text=document.createTextNode('Journal Title');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
            	            
            	          }
            	           
            	         if (elementArrayLeft[l-1] == "article_title") {
			                 var text=document.createTextNode('Article Title');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
            	            
            	          }
            	          
            	 
                        
            	         if (elementArrayLeft[l-1] == "url_address") {
			                 var text=document.createTextNode('URL Address');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayLeft[l-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
            	            
            	          }

				         var table = document.createElement('TABLE');
			             table.appendChild(tr1);
			             table.appendChild(tr2); 
			             cell.appendChild(table); 
				       
			             
			          } // end of foreach
			        
			     } // end of left fields
			     
			     if (right==i) {
			        
			          
			        for(var r=1;r<=elementArrayRight.length;r++) {
			            if (elementArrayRight[r-1] == "publisher") {
			                 var text=document.createTextNode('Publisher');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
            	          if (elementArrayRight[r-1] == "place_of_publication") {
			                 var text=document.createTextNode('Place of Publication');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
            	          
            	          //year_of_publication
			             if (elementArrayRight[r-1] == "year_of_publication") {
			                 var text=document.createTextNode('Year of Publication');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
			             
			             
			              //year
			              
			             if (elementArrayRight[r-1] == "year") {
			                 var text=document.createTextNode('Year');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
            	        if (elementArrayRight[r-1] == "url_address") {
			                 var text=document.createTextNode('URL Address');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
			         
			          if (elementArrayRight[r-1] == "volume") {
			                 var text=document.createTextNode('Volume');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
			           
			              if (elementArrayRight[r-1] == "issue") {
			                 var text=document.createTextNode('Issue');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
            	          
            	           if (elementArrayRight[r-1] == "page_number") {
			                 var text=document.createTextNode('Page Number');
			                 
			                 var td1=document.createElement('TD');
			                 td1.appendChild(text);
			                 var tr1 = document.createElement('TR');
			                 tr1.appendChild(td1); 
			                 cell.appendChild(tr1);
			                  var td2=document.createElement('TD');
			                  var element = document.createElement("input");
						      element.type = "text";
				            		                
            	              element.name = "data["+model+"]["+rowCount+"]["+elementArrayRight[r-1]+"]";
            	              td2.appendChild(element);
            	              
			                 var tr2 = document.createElement('TR');
			                
			                 tr2.appendChild(td2);
			                
			               
            		         cell.appendChild(tr2);
     
            	          }
			        
			        }
			     } // end of right fields 
			} // end for each
			
       }
       
		function addRow(tableID,controller,no_of_fields,all_fields) {
			 var elementArray = all_fields.split(',');
           
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell0 = row.insertCell(0);
			cell0.innerHTML = rowCount+1 ;
			for(var i=1;i<=no_of_fields;i++) {
				var cell = row.insertCell(i);
				var element = document.createElement("input");
				element.type = "text";
				if(controller =="Book") {
					element.size = "13";
				} else if(controller =="Journal") {
					element.size = "10";
				} else if(controller =="Weblink") {
					element.size = "30";
				} else if (elementArray[i-1] == "prerequisite_course_id") {
				     
				       var element = document.createElement("select");						
					    var string='<option value="">--Select Prerequisite course---</option>';
						for (var f=0;f<prerequisite_courses.length;f++) {
						   string += '<option value="'+prerequisite_courses[f][0]
						   +'">'+prerequisite_courses[f][1]+'</option>';
						}
						string +='<option value="">None</option>';
						element.style.width= "200px";
			            element.innerHTML = string;
			          		              
				
				} else if (elementArray[i-1] == 'co_requisite') {
				
				   var element = document.createElement("input");
				 
				  	element.value=1;
				    element.type = "checkbox";
				
				}
				element.name = "data["+controller+"]["+rowCount+"]["+elementArray[i-1]+"]";
				cell.appendChild(element);
			}

		}
		
	function deleteRow(tableID) {
		   
			try {
			    var table = document.getElementById(tableID);
			    var rowCount = table.rows.length;
			    if(rowCount !=2){
                    table.deleteRow(rowCount-1);
			    } else {
			
			        //alert('No more rows to delete');
			    }
			
			} catch(e) {
				alert(e);
			}
			
	 }
	 
	
</SCRIPT>
<div class="courses form">

<?php echo $this->Form->create('Course');?>
     <?php if (isset($this->data['Course']['course_code_title'])) {  ?>
		<div class="smallheading"><?php __(' Edit Course '.$this->data['Course']['course_code_title'].'. '); ?></div>
		<?php 
		} else {
		?>
	        	<div class="smallheading"><?php __(' Edit Course '.$course_code_title.' '); ?></div>	
		<?php 
		
		}
		
		?>
		
	<table>
		<tr><td>
		<?php 
		echo "<table><tbody>";
		echo $this->Form->input('id');
		echo "<tr><td>".$this->Form->input('year_level_id',array('empty'=>"---Select Year Level---"))."</td></tr>";
		echo "<tr><td>".$this->Form->input('semester',array('type'=>'select','options'=>$semester_array,'empty'=>"---Select Semester---"))."</td></tr>";
		
		echo $this->Form->hidden('Course.curriculum_id',array('value'=>$this->data['Course']['curriculum_id']));
		
	    if ($editCreditDetail ==0 ) {
	        echo "<tr><td>".$this->Form->input('course_title')."</td></tr>";
		    echo "<tr><td>".$this->Form->input('course_code')."</td></tr>";
		} else {
		    echo "<tr><td style='padding-left:150px'> Course Title: ".$this->data['Course']['course_title']."</td></tr>";
		    echo "<tr><td style='padding-left:150px'> Course Code: ".$this->data['Course']['course_code']."</td></tr>";
		        echo "<tr><td>Editing course title and course code is not allowed since students has already graduted with this course.</td></tr>";
		}
		//editCreditDetail
		
		if ($editCredit ==0 ) {
		    echo "<tr><td>".$this->Form->input('credit',array('label'=>$creditname))."</td></tr>";
		} else {
		       echo "<tr><td style='padding-left:100px'>".$creditname.': '.$this->data['Course']['credit']."</td></tr>";
		      echo "<tr><td>Editing ".$creditname." is not allowed since students has already scored grade and result is computed.</td></tr>";
		}
		echo "<tr><td>".$this->Form->input('lecture_hours')."</td></tr>";
		echo "<tr><td>".$this->Form->input('tutorial_hours')."</td></tr>";
		echo "<tr><td>".$this->Form->input('laboratory_hours')."</td></tr>";
		echo "<tr><td>".$this->Form->input('course_category_id',array('empty'=>"---Select Course Category---"))."</td></tr>";
		
		if ($this->data['Course']['major']==1) {
		echo "<tr><td style='padding-left:200px;'>".$this->Form->input('major',array('checked'=>'checked'))."</td></tr>";
		} else {
		  echo "<tr><td style='padding-left:200px;'>".$this->Form->input('major')."</td></tr>";
		}
		
		if ($this->data['Course']['thesis']==1) {
		    echo "<tr><td style='padding-left:200px;'>".$this->Form->input('thesis',array('checked'=>'checked'))."</td></tr>";
		} else {
		      echo "<tr><td style='padding-left:200px;'>".$this->Form->input('thesis')."</td></tr>";
		}
		echo "</tbody></table></td><td><table><tbody>";
		//echo "<tr><td>&nbsp;</td></tr>";
		echo "<tr><td>".$this->Form->input('course_description')."</td></tr>";
		echo "<tr><td>".$this->Form->input('course_objective')."</td></tr>";
		echo $this->Form->hidden('department_id',array('value'=>$department_id));
		echo "<tr><td>".$this->Form->input('lecture_attendance_requirement')."</td></tr>";
		
		echo "<tr><td>".$this->Form->input('lab_attendance_requirement')."</td></tr>";
		echo "<tr><td>".$this->Form->input('grade_type_id',array('empty'=>"---Select Grade Type---"))."</td></tr>";
		echo "</tbody></table>";
		?>
		</td>
		<table>
			<?php 
		$fields=array('prerequisite_course_id'=>1,'co_requisite'=>2);
		    $all_fields = "";
			$sep = "";

			foreach ($fields as $key => $tag) {
				$all_fields.= $sep.$key;
				$sep = ",";
			}
			$prerequisite_course_list = "";
			$se ="";
			foreach($prerequisite_courses as $pk =>$pv) {
				$prerequisite_course_list .=$se.$pv;
				$se = ",";
			}
		?>
		<tr><th colspan=3>Prerequisite/Co-Requisite Course</th></tr>
	 
		</table>
		<TABLE id="prerequisite" border="1">
		<TR><th>S.N<u>o</u></th><th>Prerequisite Course</th><th>Is co-requisite ? </th>
		    <?php 
		        if (!empty($this->data['Prerequisite'])) {
		            echo '<th>';
		            echo 'Action';
		            echo '</th>';
		        }
		        
		    
		    ?>
		</TR>
			<?php 
			
		     if (isset($this->data['Prerequisite']) && count($this->data['Prerequisite'])>0 ) {
		                $count=1;
		                 foreach ($this->data['Prerequisite'] as $ck=>$cv) {
		                    if (!empty($cv['id'])) {
		                                 echo $this->Form->hidden('Prerequisite.'.$ck.'.id');
		                             
		                              $action_model_id='edit~Prerequisite~'.$cv['course_id'];
		                              
		                    }
		                   
		                    echo "<tr><td>".$count."</td><td>".$this->Form->input('Prerequisite.'.$ck.'.prerequisite_course_id',
		                    array(
		                    'options'=>$prerequisite_courses,'type'=>'select','label'=>false,
		                    'selected'=>(!empty($this->data['Prerequisite'][$ck]['prerequisite_course_id']))?$this->data['Prerequisite'][$ck]['prerequisite_course_id'] :'',
		                    'style'=>'width:200px'));
		                    echo "</td>";
		                    echo '<td>';
		                     echo $this->Form->input('Prerequisite.'.$ck.'.co_requisite',array('label'=>false));     
		                     echo '</td>';
		                  
		                       if(!empty($action_model_id)) {
		                
		                        echo "<td>".$this->Html->link(__('Delete', true), 
		                        array('action' => 'deleteChildren', $cv['id'],
		                        $action_model_id), null, 
		                        sprintf(__('Are you sure you want to delete # %s?', true), $cv['id'])).'</td>';  
		                        
		                      }
		                      
		                    
		                    
		                    echo '</tr>';
		                    $count++;
		            }
		        
			} else {
			
			?>
				<TR>
					<TD> 1 </TD>
				
					<TD> 
					    <select style="width:200px" name="data[Prerequisite][0][prerequisite_course_id]">
						      <option value="None">--Select Prerequisite course --- </option>
					        <?php foreach($prerequisite_courses as $key=> $prerequisite_course) {
					        ?>
						         <option value="<?php echo $key;?>"><?php echo $prerequisite_course; ?> </option>
					        <?php }?> 
				        </select>

				    </TD>
				     <td>
			   
			            <?php 
			                echo $this->Form->input('Prerequisite.0.co_requisite',array('label'=>false)); 
			            
			            ?>
			        </td>
				</TR>
			<?php 
			
			}
			?>
		</TABLE>
	<table><tr><td colspan=3>
				<INPUT type="button" value="Add Row" onclick="addRow('prerequisite','Prerequisite',2, '<?php echo $all_fields; ?>')" />
				
		<INPUT type="button" value="Delete Row" onclick="deleteRow('prerequisite')" /> 
	</td></tr></table>
	
		<?php 
		
		
	        $book_list_fields_left=array('ISBN'=>'1','title'=>2,'edition'=>3,
		   'author'=>4);
		   
		    $all_fields_left = "";
	        $sep_left = "";
	        foreach ($book_list_fields_left as $key => $tag) {
				                $all_fields_left.= $sep_left.$key;
				                $sep_left = ",";
	        }
	       
	        $book_list_fields_left=array('publisher'=>1,'place_of_publication'=>2,'year_of_publication'=>3);
		   
		    $all_fields_right = "";
	        $sep_right = "";
	        foreach ($book_list_fields_left as $key => $tag) {
				                $all_fields_right.= $sep_right.$key;
				               $sep_right = ",";
	        } 
	        
	   /*
		$fields=array('ISBN'=>'1','title'=>'2','publisher'=>'3','edition'=>'4','author'=>'5','place_of_publication'=>'6','year_of_publication'=>'7');
		    $all_fields = "";
			$sep = "";

			foreach ($fields as $key => $tag) {
				$all_fields.= $sep.$key;
				$sep = ",";
			}
		 */
		?>

		
		<TABLE id="book"  border="1">
		<?php 
		echo "<tr><th align='right'>S.No</th><th align='right'>Book Detail</th><th align='right'>Publish</th>";
		
		        if (!empty($this->data['Book'])) {
		            echo '<th>';
		            echo 'Action';
		            echo '</th>';
		        }
		        
		    
		  
		echo "</tr>";
		if (isset($this->data['Book']) && count($this->data['Book'])>0) {
		   $count=1;
		   foreach ($this->data['Book'] as $book_index=>$book_value){
		          
		            if (!empty($book_value['id'])) {
		                         echo $this->Form->input('Book.'.$book_index.'.id');
		                             
		                         $action_book_id='edit~Book~'.$book_value['course_id'];
		                              
		             }
		           
		            echo "<tr>";
		            echo '<td>'.$count++.'</td>';
		            echo '<td>';
		            echo '<table >';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.ISBN').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.author').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.edition').'</td></tr>';
		            echo '</table>';
		            echo '</td>';
		            echo '<td>';
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.publisher').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.place_of_publication').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Book.'.$book_index.'.year_of_publication',array('type'=>'text')).'</td></tr>';
		            echo '</table>';
		
		            echo '</td>';
		              if(!empty($action_book_id)) {
		                
		                echo "<td>".$this->Html->link(__('Delete', true), 
		                array('action' => 'deleteChildren', $book_value['id'],$action_book_id), null, 
		                sprintf(__('Are you sure you want to delete # %s?', true), $book_value['id'])).'</td>';  
		                
		                  }
		                
		            echo "</tr>";
		    
		  }
		    
		} else {
		    echo "<tr>";
		    echo '<td> 1';
		    echo '</td>';
		    echo '<td>';
		    echo '<table>';
		        echo '<tr><td>'.$this->Form->input('Book.0.ISBN').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('Book.0.title').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('Book.0.author').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('Book.0.edition').'</td></tr>';
		    echo '</table>';
		    echo '</td>';
		    echo '<td>';
		    echo '<table>';
		        echo '<tr><td>'.$this->Form->input('Book.0.publisher').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('Book.0.place_of_publication').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('Book.0.year_of_publication',
		        array('type'=>'text')).'</td></tr>';
		    echo '</table>';
		
		    echo '</td>';
		    echo "</tr>";
		}
		?>
	
		</TABLE>
        <table><tr><td colspan=3>
		<INPUT type="button" value="Add Row" onclick="addRowNew('book','Book',7,'<?php echo $all_fields_left; ?>','<?php echo $all_fields_right;  ?>')" />
		<INPUT type="button" value="Delete Row" onclick="deleteRow('book')" />
	</td></tr></table>
	
	<?php 
	  
	        $journal_list_fields_left=array('journal_title'=>'1','article_title'=>2,'author'=>3,
		   'ISBN'=>4,'url_address'=>4);
		   
		    $all_journal_fields_left = "";
	        $sep_left_journal = "";
	        foreach ($journal_list_fields_left as $jkey => $jtag) {
				                $all_journal_fields_left.= $sep_left_journal.$jkey;
				                $sep_left_journal = ",";
	        }
	       
	        $journal_list_fields_right=array('volume'=>1,'issue'=>2,'page_number'=>3);
		   
		    $all_journal_fields_right = ""; 
	        $sep_right_journal = "";
	        foreach ($journal_list_fields_right as $jkey => $jtag) {
				                $all_journal_fields_right.= $sep_right_journal.$jkey;
				                $sep_right_journal = ",";
	        }
	   
		?>
	
		<TABLE id="journal" >
		 <?php 
		echo "<tr><th>S.No</th><th>Journal Detail</th><th>Volume</th>";
		if (!empty($this->data['Journal'])) {
		    echo '<th>';
		    echo 'Action';
		    echo '</th>';
		}
		
		echo "</tr>";
		if (isset($this->data['Journal']) && count($this->data['Journal'])>0) {
		   $count=1;
		  
		   
		   foreach ($this->data['Journal'] as $journal_index=>$journal_value){
		              if (!empty($journal_value['id'])) {
		                       	echo $this->Form->hidden('Journal.'.$journal_index.'.id',
		                       	array('value'=>$this->data['Journal'][$journal_index]['id']));    
		                        $action_journal_id='edit~Journal~'.$journal_value['course_id'];
		                              
		              }
		            echo "<tr>";
		            echo '<td>'.$count++.'</td>';
		            echo '<td>';
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.journal_title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.article_title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.author').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.ISBN').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.url_address').'</td></tr>';
		            echo '</table>';
		            echo '</td>';
		            echo '<td>';
		            
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.volume').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.issue').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$journal_index.'.page_number').'</td></tr>';
		            echo '</table>';
		
		            echo '</td>';
		              if(!empty($action_journal_id)) {
		                
		                echo "<td>".$this->Html->link(__('Delete', true), 
		                array('action' => 'deleteChildren', $journal_value['id'],$action_journal_id), null, 
		                sprintf(__('Are you sure you want to delete # %s?', true), $journal_value['id']))."</td>";  
		                
		               }
		               
		            echo "</tr>";
		    
		  }
		    
		} else {
		   
		            echo "<tr>";
		            echo '<td>1</td>';
		            echo '<td>';
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.journal_title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.article_title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.author').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.ISBN').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.url_address').'</td></tr>';
		            echo '</table>';
		            echo '</td>';
		            echo '<td>';
		            
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.volume').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.issue').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.0.page_number').'</td></tr>';
		            echo '</table>';
		
		            echo '</td>';
		            echo "</tr>";
		}
	    ?>
		</TABLE>
	   <table><tr><td colspan=3>
		<INPUT type="button" value="Add Row" onclick="addRowNew('journal','Journal',2,
		'<?php echo $all_journal_fields_left; ?>','<?php echo $all_journal_fields_right; ?>')" />
		<INPUT type="button" value="Delete Row" onclick="deleteRow('journal')" />
	</td></tr></table>
	
	
	    <?php 
		      $web_link_fields_left=array('title'=>'1','author'=>2);
		   
		      $all_web_link_fields_left = "";
	          $sep_left_weblink = "";
	          foreach ($web_link_fields_left as $wkey => $wtag) {
				                $all_web_link_fields_left.= $sep_left_weblink.$wkey;
				                $sep_left_weblink = ",";
	          }
	          $web_link_fields_right=array('url_address'=>'1','year'=>2); 
		      $all_web_link_fields_right = ""; 
	          $sep_right_weblink = "";
	          foreach ($web_link_fields_right as $wrkey => $wrtag) {
				                $all_web_link_fields_right.= $sep_right_weblink.$wrkey;
				                $sep_right_weblink = ",";
	          }
	   ?>
		 
		<TABLE id="weblink"  border="1">
		 <?php 
		echo "<tr><th>S.No</th><th> Web Link Detail</th><th>Link</th>";
		if (!empty($this->data['Weblink'])) {
		        echo '<th>';
		        echo 'Action';
		        echo '</th>';
		}
		echo "</tr>";
		if (isset($this->data['Weblink']) && count($this->data['Weblink'])>0) {
		   $count=1;
		  
		   
		   foreach ($this->data['Weblink'] as $weblink_index=>$web_value){
		           
					  if (!empty($web_value['id'])) {
		                       	echo $this->Form->input('Weblink.'.$weblink_index.'.id');    
		                        $action_weblink_id='edit~Weblink~'.$web_value['course_id'];
		                              
		              }
                   
                    		              
		            echo "<tr>";
		            echo '<td>'.$count++.'</td>';
		            echo '<td>';
		               $fields=array('title'=>'1','url_address'=>'2','author'=>'3','year'=>'4');
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Weblink.'.$weblink_index.'.title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Weblink.'.$weblink_index.'.author').'</td></tr>';
		                
		            echo '</table>';
		            echo '</td>';
		            echo '<td>';
		            
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Weblink.'.$weblink_index.'.url_address').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Journal.'.$weblink_index.'.year',
		                array('type'=>'text')).'</td></tr>';
		               
		            echo '</table>';
		
		            echo '</td>';
		             if(!empty($action_weblink_id)) {
		                    
		                    echo '<td>'.$this->Html->link(__('Delete', true), 
		                    array('action' => 'deleteChildren', $web_value['id'],
		                     $action_weblink_id), null, 
		                    sprintf(__('Are you sure you want to delete # %s?', true), $web_value['url_address'])).'</td>';  
		                    
		               }
		             
		            echo "</tr>";
		    
		  }
		    
		} else {
		   
		           echo "<tr>";
		            echo '<td>1</td>';
		            echo '<td>';
		            
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Weblink.0.title').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Weblink.0.author').'</td></tr>';
		                
		            echo '</table>';
		            echo '</td>';
		            echo '<td>';
		            
		            echo '<table>';
		                echo '<tr><td>'.$this->Form->input('Weblink.0.url_address').'</td></tr>';
		                echo '<tr><td>'.$this->Form->input('Weblink.0.year',array('type'=>'text')).'</td></tr>';
		               
		            echo '</table>';
		
		            echo '</td>';
		            echo "</tr>";
		    
		}
		?>
		
		</TABLE>
         <table>
	        <tr><td colspan=3>
		<INPUT type="button" value="Add Row" onclick="addRowNew('weblink','Weblink',2,
		'<?php echo $all_web_link_fields_left; ?>','<?php echo $all_web_link_fields_right;?>')" />
		<INPUT type="button" value="Delete Row" onclick="deleteRow('weblink')" />
	</td></tr></table>
	</td>
</tr>
		<tr> <td colspan="2" style="text-align:center;">
<?php echo $this->Form->Submit('Submit',array('name'=>'submit','div'=>false));?>	
	
		</td></tr>
		</table>
		<?php  
echo $this->Form->end();

 ?>
</div>
