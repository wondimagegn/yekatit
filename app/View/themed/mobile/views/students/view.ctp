<div class="students form" style="align:center">
<?php echo $this->Form->create('Student',array('type'=>'file'));?>
<?php echo $this->Html->script('amharictyping'); ?> 

<script type="text/javascript">
var region=Array();		
//alert("<?PHP foreach ($regions as $k=>$v) echo $v; ?>"); 

<?PHP 
   
    foreach($regions as $region_id=>$region_name){
    ?>
        region["<?php echo $region_id; ?>"] = "<?php echo $region_name; ?>";
    <?php
    
        }
?>
//alert(region);
 		function addRow(tableID,model,no_of_fields,all_fields,other) {
			
			 var elementArray = all_fields.split(',');
            
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell0 = row.insertCell(0);
			cell0.innerHTML = rowCount ;
			for(var i=1;i<=no_of_fields;i++) {
				var cell = row.insertCell(i);
				if (elementArray[i-1] == "region") {
				     /* 
                        
				        var element = document.createElement("select");
						string = '';
						for (var f=1;f<region.length;f++) {
						   string += '<option value="'+f+'"> '+region[f]+'</option>';
						}		
			           
			            for(keyVar in region) {
			             
				            string += '<option value="'+keyVar+'"> '+region[keyVar]+'</option>';
			            }
			            */
			            var element = document.createElement("select");
						var string='<option value="">--select region--- </option>';
						for (var f=1;f<region.length;f++) {
						   string += '<option value="'+f+'"> '+region[f]+'</option>';
						}		
			            element.innerHTML = string;
			            
				} else if ( elementArray[i-1] == "exam_year") {
				        var element = document.createElement("select");
					    var d = new Date();
			            var full_year =d.getFullYear();
			            var string='<option value="">--select year--- </option>';
			            
			            for(var j=full_year-1;j>other;j--) {
			                
				            string += '<option value="'+j+'"> '+j+'</option>';
			            }
			
			            element.innerHTML = string;
				
				} else if (elementArray[i-1]=='grade') {
				    var element = document.createElement("input");
				    element.type = "text";
				    element.size = "4";
				} else if (elementArray[i-1] == 'mark') {
				    var element = document.createElement("input");
				    element.type = "text";
				    element.size = "5";
				} else {
				   var element = document.createElement("input");
				    element.type = "text";
				     element.size = "13";
				}
			
				
				element.name = "data["+model+"]["+rowCount+"]["+elementArray[i-1]+"]";
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
</script>
<div style="padding-top:20px"></div>

<div class="smallheading"><?php __('Profile of '.ucwords(strtolower($student['Student']['full_name']))); ?></div>

		<div id="basic_fields" style="display:block">	
		 <?php
            echo $this->element('user_tab_menu',
                array('current_tab' => 'basic_fields'));
             echo $this->Form->hidden('id');
            echo "<div class=\"AddTab\">\n";
                echo '<table cellspacing="0" cellpading="0"><tbody>';
                echo "<tr><td><table><tbody>";
                   echo '<tr><td colspan=2><strong>Demographic Information</strong></td></tr>';
             
		         echo '<tr><td>First Name:<strong>'.$student['Student']['first_name'].'</strong></td></tr>';
		         echo '<tr><td>First Name in Amharic:<strong>'.$student['Student']['amharic_first_name'].'</strong></td></tr>';
		        echo '<tr><td>Middle Name:<strong>'.$student['Student']['middle_name'].'</strong></td></tr>';
		         echo '<tr><td>Middle Name in  Amharic:<strong>'.$student['Student']['amharic_middle_name'].'</strong></td></tr>';
		        echo '<tr><td> Last Name:<strong>'.$student['Student']['last_name'].'</strong></td></tr>';
		         echo '<tr><td> Last Name in Amharic:<strong>'.$student['Student']['amharic_last_name'].'</strong></td></tr>';
		         
		        echo '<tr><td> Gender:<strong>'.$student['Student']['gender'].'</strong></td></tr>';
		        echo '<tr><td> Ethnicity:<strong>'.$student['Student']['ethnicity'].'</strong></td></tr>';
		       
		         echo '<tr><td> Student Number:<strong>'.$student['Student']['studentnumber'].'</strong></td></tr>';
		       
		
		         echo '<tr><td> Email:<strong>'.$student['Student']['email'].'</strong></td></tr>';
		        
		          echo '<tr><td> Mobile Phone:<strong>'.$student['Student']['email'].'</strong></td></tr>';
		      
		        echo '<tr><td> Birth Date:<strong>'.$this->Format->humanize_date($student['Student']['birthdate']).'</strong></td></tr>';
		        
		        echo "</tbody></table></td>";
		
		          // save account information in the user table
		        echo '<td><table><tbody>';
		       
	           
		        if(!empty($student['Attachment'])){
		            echo '<tr><td colspan=2><strong>Attachment</strong></td></tr>';
                    foreach($student['Attachment'] as $ak=>$av){
                       if(!empty($av['dirname']) && !empty($av['basename']) && strcasecmp($av['dirname'],'img')==0){
                      
                      // echo $media->embed($media->file($av['dirname'].DS.$av['basename']));
                       echo '<tr><td valign="top" align="right">'.$this->Media->embedAsObject($av['dirname'].DS.$av['basename'],array('width'=>144,'class'=>'profile-picture'))."</td></tr>";
                       
                       }
                       
				    }
                } else {
                   echo '<tr><td valign="top" align="right"><img src="/img/noimage.jpg" width="144" class="profile-picture"></td></tr>';
                   
                } 
		        echo '<tr><td colspan=2><strong>Access Information</strong></td></tr>';
               
		        echo '<tr><td> Username:<strong>'.$student['User']['username'].'</strong></td></tr>';
		          echo '<tr><td colspan=2><strong>Classification of Admission</strong></td></tr>';
		            echo "<tr><td> Program:<strong>".$student['Program']['name']."</strong></td></tr>";
				echo "<tr><td> Program Type:<strong>".$student['ProgramType']['name']."</strong></td></tr>";
		        echo "<tr><td> College:<strong>".$student['College']['name']."</strong></td></tr>";
                  echo "<tr><td> Department:<strong>";
                        if (!empty($student['Department']['name'])) {
                            echo $student['Department']['name'];
                        }  else {
                            echo '---';    
                        }
                      
                  
                  echo "</strong></td></tr>";
		  
                  echo '<tr><td> Admission Year:<strong>'.$this->Format->humanize_date($student['Student']['admissionyear']).'</strong></td></tr>';
		        echo '</tbody></table></td>';
		        
		         echo "</tr>";
		        echo '</tbody></table>';
		    echo "</div>"; // end add tab div
		    
		    
	    ?>
	   </div> <!-- end basic info block --->
	<div id="add_address" style="display:none">
	<?php		
        echo $this->element('user_tab_menu',
                array('current_tab' => 'add_address'));
        
        echo "<div class=\"AddTab\">\n";
                echo '<table cellspacing="0" cellpading="0"><tbody>';
                echo "<tr><td><table><tbody>";
                 echo '<tr><td colspan=2><hr/></td></tr>';
                 
                 echo '<tr><td colspan=2><strong>Address </strong></td></tr>';
                  echo '<tr><td colspan=2><hr/></td></tr>';
		            echo '<tr><td> Country:<strong>'.$student['Country']['name'].'</strong></td></tr>';
		            echo '<tr><td> Region:<strong>'.$student['Region']['name'].'</strong></td></tr>';
		            echo '<tr><td> City:<strong>'.$student['City']['name'].'</strong></td></tr>';
		            if (isset($student['woreda']) && !empty($student['woreda'])) {
		            echo '<tr><td> Woreda:<strong>'.$student['woreda'].'</strong></td></tr>';
		            
		            }
		             if (isset($student['kebele']) && !empty($student['kebele'])) {
		                echo '<tr><td> Kebele:<strong>'.$student['kebele'].'</strong></td></tr>';
		            }
		             if (isset($student['house_number']) && !empty($student['house_number'])) {
		           	        echo '<tr><td> House Number:<strong>'.$student['house_number'].'</strong></td></tr>';
		           	 }
		           	 if (isset($student['address1']) && !empty($student['address1'])) {
		           	echo '<tr><td> Address :<strong>'.$student['address1'].'</strong></td></tr>';
		           	
		           	}
		         
		        echo "</tbody></table></td>";
		
		          // save account information in the user table
		        echo '<td>';
		        if (!empty($student['Contact'])) {
		            echo '<table><tbody>';
		            
		            echo '<tr><td colspan=2><hr/></td></tr>';
		            echo '<tr><td colspan=2><strong>Primary Emergency Contact</strong></td></tr>';
                  
		             foreach ($student['Contact'] as $k=>$v ) {
		              
		                echo '<tr><td> Full Name:<strong>'.$v['full_name'].'</strong></td></tr>';
		                echo '<tr><td> Country: <strong>'.$v['Country']['name'].'</strong></td></tr>';
		                echo '<tr><td> City: <strong>'.$v['City']['name'].'</strong></td></tr>';
		                echo '<tr><td> Region: <strong>'.$v['Region']['name'].'</strong></td></tr>';
		                echo '<tr><td> E-mail:<strong>'.$v['email'].'</strong></td></tr>';
		                echo '<tr><td> Primary Contact: <strong>'.($v['primary_contact'] == 1 ? "Yes": "No").'</strong></td></tr>';
		                echo '<tr><td> Office Phone: <strong>'.$v['phone_office'].'</strong></td></tr>';
		                echo '<tr><td> Home Phone: <strong>'.$v['phone_home'].'</strong></td></tr>';
		                echo '<tr><td> Mobile Phone: <strong>'.$v['phone_mobile'].'</strong></td></tr>';
		                
		                echo '<tr><td> Address : <strong>'.$v['address1'].'</strong></td></tr>';
		               
		             }
                
		            echo '</tbody></table>';
		        }
		        echo '</td></tr>';
		       
		        echo '</tbody></table>';
             
		echo '</div>'; // End add tab div
		?>
	 </div> <!-- End address block -->
	 
	  <div id="education_background" style="display:none">	
		 <?php
		
			
            echo $this->element('user_tab_menu',
                array('current_tab' => 'education_background'));
            
            echo "<div class=\"AddTab\">\n";
             // save account information in the user table
               
		        echo "<table><tbody>";
		        if (!empty($student['HighSchoolEducationBackground'])) {
		            echo '<tr><td> <div class="smallheading">Senior Secondary/Preparatory school attended </div> <table  id="high_school_education"><tbody>';
		          
                    echo '<tr><th>No.</th><th>School Level</th><th>Name</th><th>National Exam Taken </th><th>Town</th><th>Zone</th><th>Region</th></tr>';
		               
		                if (!empty($student['HighSchoolEducationBackground'])) {
		                        $count=1;
		                          foreach ($student['HighSchoolEducationBackground'] as $bk=>$bv) {
		                          
		                            echo "<tr><td>".$count."</td><td>".$bv['school_level'].'</td>';
		                            echo '<td>';
		                                if ($bv['national_exam_taken']==1) {
		                                    echo 'yes';
		                                }
		                            echo '</td>';
		                            
		                            echo '<td>'.
		                            $bv['name'].'</td><td>'.$bv['town'].'</td><td>'.$bv['zone'].'</td><td>'.$regions[$bv['region_id']].'</td><td>'.'</td></tr>';
				                        $count++;
		                }
		             }
		
                    echo "</tbody></table>";
                   
                    echo '</td></tr>';
                }
                if (!empty($student['HigherEducationBackground'])) {
                    echo "<tr>";
                    echo "<td>";
                     echo '<div class="smallheading">Higher Education Attended</div><table id="higher_education_background"><tbody>';
		           
                     echo '<tr><th>No.</th><th>Name of Institution/College</th><th>Field of study</th><th>Diploam Awared</th><th>Date graduated </th><th>CGPA at Graduation</th></tr>';
		               
		                if (!empty($student['HigherEducationBackground'])) {
		                        $count=1;
		                          foreach ($student['HigherEducationBackground'] as $bk=>$bv) {
		                         
		                echo "<tr><td>".$count."</td><td>".$bv['name'].'</td><td>'.$bv['field_of_study'].
		                '</td><td>'.$this->Format->humanize_date($bv['diploma_awarded']).'</td><td>'.$this->Format->humanize_date($bv['date_graduate']).'</td><td>'.$bv['cgpa_at_graduation'].'</td></tr>';
				            $count++;
		                }
		             } 
		             echo "</tbody>";
		             echo "</table>";
                    echo "</td>";
                    echo "</tr>";
                    
                }
                if (!empty($student['EheeceResult'])) {
                    echo "<tr>"; 
		            echo "<td width='50%'><div class='smallheading'>EHEECE Results</div><table id='eheece_result'>";
		               echo "<table>";
		            echo '<tr><th>No.</th><th>Subject</th><th>Mark</th><th>Exam Year</th></tr>';
		            if (!empty($student['EheeceResult'])) {
		                    $count=0;
		                    
		                      foreach ($student['EheeceResult'] as $bk=>$bv) {
		                      
		                        echo "<tr><td>".++$count."</td>";
					
					echo "<td>".$bv['subject']."</td>";
					
					
					echo "<td>".$bv['mark']."</td><td>".$bv['exam_year']."</td></tr>";
					
		                      }
		            } 
		            echo "</table>";
		            echo "</td>";
                    echo "</tr>";
                
                }
                if (!empty($student['EslceResult'])) {
                    echo "<tr>";   
		            echo "<td width='50%'><div class='smallheading'>ESLCE Results</div><table id='eheece_result'>";
		               echo "<table>";
		            echo '<tr><th>No.</th><th>Subject</th><th>Grade</th><th>Exam Year</th></tr>';
		            if (!empty($student['EslceResult'])) {
		                    $count=0;
		                    
		                      foreach ($student['EslceResult'] as $bk=>$bv) {
		                      
		                        echo "<tr><td>".++$count."</td>";
					
					echo "<td>".$bv['subject']."</td>";
					
					
					echo "<td>".$bv['grade']."</td><td>".$bv['exam_year']."</td></tr>";
					
		                      }
		            } 
		            echo "</table>";
		            echo "</td>";
                    echo "</tr>";
                 }
                 echo "</table>";
               ?>
            <?php 
            
            echo "</div>";
            ?>
 </div>

</div>
