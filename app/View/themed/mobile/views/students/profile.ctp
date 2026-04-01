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
function addRow(tableID,model,no_of_fields,all_fields,other) {
			
			 var elementArray = all_fields.split(',');
            
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell0 = row.insertCell(0);
			cell0.innerHTML = rowCount ;
			for(var i=1;i<=no_of_fields;i++) {
				var cell = row.insertCell(i);
				if (elementArray[i-1] == "region_id") {
				  
			            var element = document.createElement("select");
						var string='<option value="">--select region--- </option>';
						for (var f=1;f<region.length;f++) {
						   string += '<option value="'+f+'"> '+region[f]+'</option>';
						}		
						element.style.width='150px';
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
				} else if (elementArray[i-1]=='national_exam_taken') {
				
				   var element = document.createElement("input");
				   element.type = "checkbox";
				  
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
<?php 
$readOnly=true;

?>
		<div id="basic_fields" style="display:block">	
		 <?php
		   
            echo $this->element('user_tab_menu',
                array('current_tab' => 'basic_fields'));
             echo $this->Form->hidden('Student.id',array('value'=>$this->data['Student']['id']));
            echo "<div class=\"AddTab\">\n";
                echo '<table cellspacing="0" cellpading="0"><tbody>';
                echo "<tr><td><table><tbody>";
                echo '<tr><td colspan=2><strong>Demographic Information</strong></td></tr>';
                
		         echo $this->Form->hidden('first_name');
		          echo '<tr><td style="padding-left:95px;">First Name:<strong> '.$this->data['Student']['first_name'].'</strong></td></tr>';
		          echo '<tr><td style="padding-left:95px;">Amharic First Name:<strong>'.$this->data['Student']['amharic_first_name'].'</strong></td></tr>';
		          
		        echo $this->Form->hidden('middle_name');
		             echo '<tr><td style="padding-left:95px;">Middle Name:<strong>'.$this->data['Student']['middle_name'].'</strong></td></tr>';
		             
		          // echo '<tr><td>'.$this->Form->input('amharic_middle_name',array('label'=>'Middle name in  Amharic',array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))).'</td></tr>';
		            echo '<tr><td style="padding-left:95px;">Amharic Middle Name:<strong>'.$this->data['Student']['amharic_middle_name'].'</strong></td></tr>';
		            
		             echo '<tr><td style="padding-left:95px;">Last Name:<strong>'.$this->data['Student']['last_name'].'</strong></td></tr>';
		             
		        echo $this->Form->hidden('last_name');
		        
		           //echo '<tr><td >'.$this->Form->input('amharic_last_name',array('label'=>'Last name in  Amharic',array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))).'</td></tr>';
		           //echo '<tr><td >'.$this->Form->input('amharic_last_name',array('label'=>'Last name in  Amharic',array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))).'</td></tr>';
		         echo '<tr><td style="padding-left:95px;">Amharic Last Name:<strong>'.$this->data['Student']['amharic_last_name'].'</strong></td></tr>';
		         
		       // echo '<tr><td>'. $this->Form->input('gender',array('label'=>'Gender','readOnly'=>$readOnly)).'</td></tr>';
		          echo '<tr><td style="padding-left:95px;">Sex:<strong>'.$this->data['Student']['gender'].'</strong></td></tr>';
		          echo '<tr><td style="padding-left:95px;"> Student Number: '.$this->data['Student']['studentnumber'].'</td></tr>';
		             echo '<tr><td style="padding-left:95px;"> Birth Date:'.$this->Format->humanize_date($this->data['Student']['birthdate']).'</td></tr>';
		        
		        
		        
		         
		         
		       
		        
		         echo '<tr><td>'. $this->Form->input('email',array('label'=>'Email','class'=>'edittextField')).'</td></tr>';
		         echo '<tr><td>'. $this->Form->input('email_alternative',array('label'=>'Alternative Email','class'=>'edittextField')).'</td></tr>';
		         echo '<tr><td>'. $this->Form->input('phone_home',array('label'=>'Home Phone','class'=>'edittextField')).'</td></tr>';
		          
		          echo '<tr><td>'. $this->Form->input('phone_mobile',array('label'=>'Mobile Phone')).'</td></tr>';
		      
		     
		         
		         
		      //  echo '<tr><td style="padding-left:100px;color:green;"> Birth Date: '.$this->data['Student']['birthdate'].'</td></tr>';
		        
		        echo "</tbody></table></td>";
		
		          // save account information in the user table
		        echo '<td><table><tbody>';
		        echo '<tr><td colspan=2 style="height:50px; width:50px"><strong>Profile Picture</strong></td></tr>';
	           
		        if(isset($this->data['Attachment']) && !empty($this->data['Attachment'])){
                    foreach($this->data['Attachment'] as $ak=>$av){
                       if(!empty($av['dirname']) && !empty($av['basename']) ){
                      // echo $media->embed($media->file('s'.DS.$av['dirname'].DS.$av['basename']));
                       echo $media->embed($media->file($av['dirname'].DS.$av['basename']));
                       
                       }
                    
                    /*echo $this->Media->embed($this->Media->file("{/$av['dirname']}/{$av['basename']}"), array('restrict' => array('image')
				    ));*/
				    }
                } else {
                    echo '<tr><td valign="top" align="right"><img src="/img/noimage.jpg" width="144" class="profile-picture"></td></tr>';
                    echo '<tr><td>'.$this->element('attachments', array('plugin' => 'media','label'=>false)).'</td></tr>';
                }
		        echo '<tr><td colspan=2><strong>Access Information</strong></td></tr>';
               // echo $this->Form->hidden('User.id',array('value'=>$this->data['User']['id']));
		        echo '<tr><td> Username: '.$this->data['Student']['studentnumber'].'</td></tr>';
		      
		         
		         	echo $this->Form->hidden('program_id',array('value'=>$this->data['Student']['program_id']));
                    echo $this->Form->hidden('college_id',array('value'=>$this->data['Student']['college_id']));
                    
		        	echo $this->Form->hidden('program_type_id');
		        	
		         echo '<tr><td colspan=2><strong>Classification of Admission</strong></td></tr>';
		         echo "<tr><td> Program: ".$programs[$this->data['Student']['program_id']] ."</td></tr>";
			    
			     echo "<tr><td> Program Type: ".$programTypes[$this->data['Student']['program_type_id']] ."</td></tr>";
			     
				
		        echo "<tr><td> College: ".$colleges[$this->data['Student']['college_id']]."</td></tr>";
               
                  if (!empty($this->data['Student']['department_id'])) {
                        echo "<tr><td> Department:".$departments[$this->data['Student']['department_id']].'</td></tr>';
                      
                  } else {
                  
                        echo "<tr><td> Department:--- </td></tr>";
                        
                  }
                  
                  //$this->Form->input('admissionyear',array('label'=>'Admission Year','disabled'=>true))
                  echo '<tr><td>Admission Year: '.$this->Format->humanize_date($this->data['Student']['admissionyear']).'</td></tr>';
		        
		        
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
                 echo '<tr><td colspan=2><strong>Address & Contact </strong></td></tr>';
                  echo '<tr><td colspan=2><hr/></td></tr>';
		        
	            // save student primary address 
		        echo '<tr><td>'.$this->Form->input('Contact.0.id',array('type'=>'hidden')).'</td></tr>';
		       
		        echo '<tr><td>'.$this->Form->input('country_id',
		        array('label'=>'Country','style'=>'width:250px', 'selected'=>!empty($this->data['Student']['country_id'])?$this->data['Student']['country_id']:68)).'</td></tr>';
		        
		        echo '<tr><td>'.$this->Form->input('region_id',array('label' => 'Region/City','style'=>'width:250px')).'</td></tr>';
		        
		        echo '<tr><td>'. $this->Form->input('zone_subcity',array('label'=>'Zone/Subcity')).'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('woreda').'</td></tr>';
		       	      
		        echo '<tr><td>'.$this->Form->input('kebele').'</td></tr>';
		        echo '<tr><td>'.$this->Form->input('house_number',array('label'=>'House Number')).'</td></tr>';
		        
		        echo '<tr><td>'.$this->Form->input('address1',array('label'=>'Address')).'</td></tr>';
		        
		        echo "</tbody></table></td>";
		
		          // save account information in the user table
		        echo '<td><table><tbody>';
		        echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td colspan=2><strong>Primary Emergency Contact</strong></td></tr>';
                echo '<tr><td colspan=2><hr/></td></tr>';
		        echo '<tr><td>'.$this->Form->input('Contact.0.first_name',array('label'=>'First Name')).'</td></td>';
		        echo '<tr><td>'.$this->Form->input('Contact.0.middle_name',array('label'=>'Middle Name')).'</td></tr>';
		        
             echo '<tr><td>'.$this->Form->input('Contact.0.last_name',
            array('label'=>'Last Name')).'</td></tr>';
             echo '<tr><td>'.$this->Form->input('Contact.0.relationship',
            array('label'=>'Relationship')).'</td></tr>';
            
            echo '<tr><td>'.$this->Form->input('Contact.0.country_id',
            array('label'=>'Country','style'=>'width:250px',
             'selected'=>!empty($this->data['Contact'][0]['country_id'])?$this->data['Contact'][0]['country_id']:68)).'</td></tr>';
              echo '<tr><td>'.$this->Form->input('Contact.0.region_id',
            array('label'=>'Region','style'=>'width:250px')).'</td></tr>';
              echo '<tr><td>'.$this->Form->input('Contact.0.city_id',array('label'=>'City',
              'style'=>'width:250px')).'</td></tr>';
           
            echo '<tr><td>'.$this->Form->input('Contact.0.email',
            array('label'=>'Email')).'</td></tr>';
              echo '<tr><td>'.$this->Form->input('Contact.0.alternative_email',
            array('label'=>'Alternative Email')).'</td></tr>';
            
             echo '<tr><td>'.$this->Form->input('Contact.0.phone_home',
            array('label'=>'Phone Home')).'</td></tr>';
            
             echo '<tr><td>'.$this->Form->input('Contact.0.phone_office',
            array('label'=>'Phone Office')).'</td></tr>';
            
             echo '<tr><td>'.$this->Form->input('Contact.0.phone_mobile',
            array('label'=>'Phone Mobile')).'</td></tr>';
            
             echo '<tr><td>'.$this->Form->input('Contact.0.address1',
            array('label'=>'Address')).'</td></tr>';
            echo '<tr><td>'.$this->Form->input('Contact.0.primary_contact',
            array('label'=>'Primary Contact')).'</td></tr>';
            
		        echo '</tbody></table></td></tr>';
		       
		        echo '</tbody></table>';
             
		echo '</div>'; // End add tab div
		?>
	 </div> <!-- End address block -->
	  
	  <div id="education_background" style="display:none">	
		 <?php
		 $fields=array('school_level'=>'1','name'=>'2','national_exam_taken'=>3,'town'=>4,'zone'=>5,'region_id'=>6);
		            $all_fields = "";
			        $sep = "";

			        foreach ($fields as $key => $tag) {
				        $all_fields.= $sep.$key;
				        $sep = ",";
			        }
			
            echo $this->element('user_tab_menu',
                array('current_tab' => 'education_background'));
            
            echo "<div class=\"AddTab\">\n";
             // save account information in the user table
		        echo '<table><tbody><tr><td> <div class="smallheading">Senior Secondary/Preparatory school attended </div> <table  id="high_school_education"><tbody>';
		       // echo '<tr><td colspan=6><hr/></td></tr>';
		        //echo '<tr><td colspan=6><strong>Senior Secondary/Preparatory school attended</strong></td></tr>';
                //echo '<tr><td colspan=6><hr/></td></tr>';
                echo '<tr><th>No.</th><th>School Level</th><th>Name</th><th>National Exam Taken ?</th><th>Town</th><th>Zone</th><th>Region</th></tr>';
		           
		            if (!empty($this->data['HighSchoolEducationBackground'])) {
		                    $count=1;
		                      foreach ($this->data['HighSchoolEducationBackground'] as $bk=>$bv) {
		                       echo $this->Form->hidden('HighSchoolEducationBackground.'.$bk.'.id');
		            echo "<tr><td>".$count."</td><td>".$this->Form->input('HighSchoolEducationBackground.'.$bk.'.school_level',
		            array(
		           'label'=>false,'div'=>false,'size'=>13)).'</td><td>'.
		            $this->Form->input('HighSchoolEducationBackground.'.$bk.'.name',
		            array(
		            'label'=>false,'div'=>false,'size'=>13)).'</td>';
		           echo '<td>';
		           echo $this->Form->input('HighSchoolEducationBackground.'.$bk.'.national_exam_taken',array('label'=>false,'div'=>false));
					
		           echo '</td>';
		           
		           
		            echo '<td>'.
					$this->Form->input('HighSchoolEducationBackground.'.$bk.'.town',
		            array(
		           'label'=>false,'div'=>false,'size'=>13)).'</td><td>'.
		            $this->Form->input('HighSchoolEducationBackground.'.$bk.'.zone',
		            array(
		           'label'=>false,'div'=>false,'size'=>13)).'</td><td>'.
					$this->Form->input('HighSchoolEducationBackground.'.$bk.'.region_id',
		            array('options'=>$regions,'type'=>'select','label'=>false,'empty'=>'--select region--','style'=>'width:150px')).'</td><td>'.'</td></tr>';
				        $count++;
		            }
		         } else {
		             echo $this->Form->hidden('HighSchoolEducationBackground.0.id');
		            echo "<tr><td>1</td><td>".$this->Form->input('HighSchoolEducationBackground.0.school_level',
		            array('label'=>false,'div'=>false,'size'=>13)).'</td><td>'.
		            $this->Form->input('HighSchoolEducationBackground.0.name',
		            array(
		            'label'=>false,'div'=>false,'size'=>13)).'</td>';
		            echo '<td>';
		             echo $this->Form->input('HighSchoolEducationBackground.0.national_exam_taken',
					array('label'=>false,'div'=>false));
		            echo '</td>';
		            
		            echo '<td>'.
					$this->Form->input('HighSchoolEducationBackground.0.town',
		            array(
		            'label'=>false,'div'=>false,'size'=>13)).'</td><td>'.
		            $this->Form->input('HighSchoolEducationBackground.0.zone',
		            array(
		           'label'=>false,'div'=>false,'size'=>13)).'</td><td>'.
					$this->Form->input('HighSchoolEducationBackground.0.region_id',
		            array('options'=>$regions,'type'=>'select','label'=>false,'style'=>'width:150px','empty'=>'--select region--')).'</td><td>'.'</td></tr>';
		         ?>
		        
		         <?php 
		         
		         }
		
                echo "</tbody></table>";
               
                echo '</td></tr>';
                 ?>
                
                <table><tr><td colspan=6>
		 <INPUT type="button" value="Add Row" onclick="addRow('high_school_education','HighSchoolEducationBackground',6,'<?php echo $all_fields; ?>')" />
		<INPUT type="button" value="Delete Row" onclick="deleteRow('high_school_education')" /> 
	</td></tr></table>
                
                <?php 
                    $higher_fields=array('name'=>'1','field_of_study'=>'2','diploma_awarded'=>'3','date_graduated'=>'4','cgpa_at_graduation'=>'5');
		            $higher_all_fields = "";
			        $sepp = "";

			        foreach ($higher_fields as $key => $tag) {
				       $higher_all_fields.= $sepp.$key;
				        $sepp = ",";
			        }
			    if (isset($this->data['HigherEducationBackground']) && count($this->data['HigherEducationBackground'])>0) {
		        echo '<tr><td><div class="smallheading">Higher Education Attended</div><table id="higher_education_background"><tbody>';
		        // echo '<tr><td colspan=2><hr/></td></tr>';
		        //echo '<tr><td colspan=2><strong>Higher Education Attended</strong></td></tr>';
                //echo '<tr><td colspan=2><hr/></td></tr>';
                 echo '<tr><th>No.</th><th>Name of Institution/College</th><th>Field of study</th><th>Diploam Awared</th><th>Date graduated </th><th>CGPA at Graduation</th></tr>';
		           
		        if (!empty($this->data['HigherEducationBackground'])) {
		                    $count=1;
		                      foreach ($this->data['HigherEducationBackground'] as $bk=>$bv) {
		                     
		            echo "<tr><td>".$count."</td><td>".$this->data['HigherEducationBackground'][$bk]['name'].'</td><td>'.$this->data['HigherEducationBackground'][$bk]['field_of_study'].
		            '</td><td>'.$this->data['HigherEducationBackground'][$bk]['diploma_awarded'].
		            '</td><td>'.$this->data['HigherEducationBackground'][$bk]['date_graduated'].
		            '</td><td>'.$this->data['HigherEducationBackground'][$bk]['cgpa_at_graduation'].'</td><td>'.'</td></tr>';
				        $count++;
		            }
		         }
		        ?>
		      
		        <?php 
		        echo '</tr>';
		        
		        }
		        
		        echo '</tbody></table>';
		        echo "<table>";
		        	$eheece_fields=array('subject'=>'1','mark'=>'2','exam_year'=>'3');
		            $eheece_all_fields = "";
			        $sepeheece = "";

			        foreach ($eheece_fields as $key => $tag) {
				        $eheece_all_fields.= $sepeheece.$key;
				        $sepeheece = ",";
			        }
		         
		            $eslce_fields=array('subject'=>'1','grade'=>'2','exam_year'=>'3');
		            $eslce_all_fields = "";
			        $sepeslce = "";

			        foreach ($eslce_fields as $key => $tag) {
				        $eslce_all_fields.= $sepeslce.$key;
				        $sepeslce = ",";
			        }
			       $from = date('Y') - Configure::read('Calendar.birthdayInPast');
                   $to = date('Y')-1;
                   $format = Configure::read('Calendar.yearFormat');
                   $yearoptions=array();
                    for($j=date('Y');$j>=$from;$j--) {
                        $yearoptions[$j]=$j;
                    }
		            echo "<tr>";
		              if (isset($this->data['EheeceResult']) && count($this->data['EheeceResult'])>0) {
		            echo "<td width='50%'><div class='smallheading'>EHEECE Results</div><table id='eheece_result'>";
		            echo '<tr><th>No.</th><th>Subject</th><th>Mark</th><th>Exam Year</th></tr>';
		            if (!empty($this->data['EheeceResult'])) {
		                    $count=0;
		                    
		                      foreach ($this->data['EheeceResult'] as $bk=>$bv) {
		                        echo $this->Form->hidden('EheeceResult.'.$bk.'.id');
		                        echo "<tr><td>".++$count."</td><td>".
		                        $bv['subject']."</td>";
					
					echo "<td>".$bv['mark']."</td>";
					
					
					echo "<td>".$bv['exam_year']."</td></tr>";
					
		                      }
		            } 
		            echo "</table>";
		            
		            ?>
		            <!--
		              <table><tr><td colspan=4>
		<INPUT type="button" value="Add Row" onclick="addRow('eheece_result','EheeceResult',3,'<?php echo  $eheece_all_fields; ?>','<?php echo $from; ?>')" />
		<INPUT type="button" value="Delete Row" onclick="deleteRow('eheece_result')" />
	</td></tr></table> -->
		            <?php 
		            echo "</td>";
		            }
		            if (isset($this->data['EslceResult']) && count($this->data['EslceResult'])>0) {
		            echo "<td width='50%'><div class='smallheading'>ESLCE Results</div><table id='eslce_result'>";
		            echo '<tr><th>No.</th><th>Subject</th><th>Grade</th><th>Exam Year</th></tr>';
		            
                      ///echo '<tr><td>'.$this->Form->input('birthdate',array('label'=>'Birth date','dateFormat'=>$format,'minYear'=>$from,'maxYear'=>$to)).'</td></tr>';
		            if (!empty($this->data['EslceResult'])) {
		                    $count=0;
		                      foreach ($this->data['EslceResult'] as $bk=>$bv) {
		                     
		                        echo "<tr><td>".++$count."</td><td>".$bv['subject']."</td>";
					
					echo "<td>".$bv['grade']."</td>";
						
					echo "<td>".$bv['exam_year']."</td></tr>";
					
					
					
		                      }
		            }
		            echo "</table>";
		            ?>
		                 <?php 
		            echo "</td>";
		            
		            }
		            echo "</tr>";
		         echo "</table>";
            echo "</div>";
        
            
            echo $this->Js->get('#StudentCountryId')->event('change', 
	$this->Js->request(array(
		'controller'=>'students',
		'action'=>'get_regions'
		), array(
		'update'=>'#StudentRegionId',
		'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => false,
			'inline' => true
			))
		))
	);
	
	echo $this->Js->get('#StudentRegionId')->event('change', 
	$this->Js->request(array(
		'controller'=>'students',
		'action'=>'get_cities'
		), array(
		'update'=>'#StudentCityId',
		'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => false,
			'inline' => true
			))
		))
	);
            ?>
     </div>
	
<?php 
if ($role_id!=3) {
    echo $this->Form->end(__('Update  Detail', true));
}

?>

</div>
