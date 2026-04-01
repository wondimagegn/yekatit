<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<div class="applicablePayments form">
<?php echo $this->Form->create('Payment',array('enctype' => 'multipart/form-data',
        'type' => 'file','novalidate' => true));?>
<?php 
    if (!isset($studentIDs)) {

?>
<table cellpadding="0" cellspacing="0">
<?php 	
        echo '<tr><td class="smallheading">Add  Payment For Student</td></tr>';
        echo '<tr><td >'.$this->Form->input('academic_year',
		                array('options'=>$acyear_array_data,'style'=>'width:100px',
		                'selected'=>$defaultacademicyear)).'</td></tr>';
		                
		                 echo '<tr><td >'.$this->Form->input('semester',
		                array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III'))).'</td></tr>';
		echo '<tr><td class="font">'.$this->Form->input('studentID',array('label' => 'Student ID')).'</td></tr>';
       echo '<tr><td>'. $this->Form->Submit('Continue',array('name'=>'continue','class'=>'tiny radius button bg-blue','div'=>false)).'</td></tr>';
?>
</table>
<?php 
}
?>
<?php 
if (isset($courses) && !empty($courses)) {
        echo $this->element('student_basic'); 
?>
		<div  class="row">
			   <div class="large-12 columns">
				<div class="row">
				    <div
					class="large-3 columns">
					<label>Academic Year
					    <?php echo $this->Form->input('academic_year',
						array('options'=>$acyear_array_data,'style'=>'width:100px',
						'selected'=>$defaultacademicyear,'label'=>false));
						
						 echo $this->Form->hidden('student_id',array('value'=>$acyear_array_data));
						
						 ?>
					</label>
				    </div>
				    <div
					class="large-3 columns">
					<label>Semester
					    <?php echo $this->Form->input('semester',
						array('options'=>$semester,'label'=>false)) ?>
					</label>
				    </div>
				  <div
					class="large-3 columns">
					<label>Sponsor
					    <?php echo $this->Form->input('sponsor_type',
						array('options'=>array('0'=>'--Select Sponsor Type--','self'=>'Self','gov'=>'Government',
			    'others'=>'Others'),'label'=>false, 'onchange' => "displayFields(this)",)) ?>
					</label>
				    </div>

				</div>
			   </div>
		</div>
		 <div  id="displayField" class="row" style="display:none;">
		    <div class="large-12 columns">
			<div class="row">
			  <div class="large-6 columns">
				 <label>Reference Number<br/>
		             	  <?php echo $this->Form->input('reference_number',
		                array('label'=>false)) ?>
				</label>
			  </div>
			  

			  <div class="large-6 columns">
				 <label>Amount<br/>
		             	  <?php echo $this->Form->input('fee_amount',
		                array('label'=>false,'id'=>'Amount'));
			echo $this->Form->hidden('student_id',
		                array('value'=>$studentId));

		 ?>
				</label>
			  </div>
			
		       </div>

			<div class="row">
			     <div class="large-12 columns">
		              <label>Payment Receipt <br/>
		                   <u>Note: Please paye the fee at finance department and attach the payment slip in PDF </u>
					<?php
					echo $this->Form->input(
					'Attachment.0.file',
					array(
					'type' => 'file', 'label' => '',
					'required' => 'required',
					'id' => 'ReceiptFormAttachment',

					'onchange' =>
					"return fileValidation(this)",

					)
					);
					?>
		           </label>
			  </div>
			 
		       </div>
		  </div>
         </div>
         	
	<div class="row">
		 <div class="large-12 columns">
			        <?php 
			  	 echo $this->Form->submit(__('Submit the payment'), array('name' => 'paid', 'class' => 'tiny radius button bg-blue', 'id' => 'applyOnline', 'div' => false)); ?>
		</div>
		 <div	class="large-12 columns">
		            <?php if(isset($courses) && !empty($courses)){ ?>
					<table>
						<tr><td>S.No</td> <td>Course</td><td>Credit</td></tr>
						<?php 
					        $count=1;
						$sum=0;
						foreach ($courses as $pk=>$pv) {
							echo "<tr><td>".$count."</td> <td>".$pv['Course']['course_title']." ".$pv['Course']['course_code']."</td><td>".$pv['Course']['credit']."</td></tr>";
							$sum+=$pv['Course']['credit'];
							$count++;
						} 
					echo "<tr><td colspan=2>Total Credit</td><td>".$sum."</td></tr>";
					echo "<tr><td colspan=2>Expected Payment</td><td id='totalAmount'>".number_format($sum*$perCreditHourPayment+$registrationFee, 0, '.', ',')."</td></tr>";

?>
					</table>
			   <?php } ?>
		 </div>

        </div>
<?php 
}
?>
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->

<script>
function fileValidation(obj) {

    var fileInput =
        document.getElementById(obj.id);

    var filePath = fileInput.value;

    // Allowing file type
    var allowedExtensions =
        /(\.pdf)$/i;

    if (!allowedExtensions.exec(
            filePath)) {
        alert(
            'Invalid file type: Please upload only pdf file'
        );
        fileInput.value = '';
        return false;
    }
    return true;
}

function displayFields(dropdown) {
    var selectedOption = dropdown.options[dropdown.selectedIndex].value;
    var displayField = document.getElementById('displayField');
    var totalAmount=document.getElementById('totalAmount');
    
    var Amount=document.getElementById('Amount');
    if (selectedOption == 'Self') {
         displayField.style.display = 'block'; // Show bar.
	 //Amount.value = parseInt(totalAmount.innerHTML); // Show bar.
	
    } else {
        displayField.style.display = 'none'; // Show bar.
    }
}



</script>

