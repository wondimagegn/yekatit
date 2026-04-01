<?php echo $this->Form->create('Payment',array('enctype' => 'multipart/form-data',
        'type' => 'file','novalidate' => true));?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div
                class="large-12 columns">

                <h3> <?php echo __('Add  Payment'); ?>
                </h3>
            </div>
         </div>
         <div  class="row">
           <div class="large-12 columns">
           		<h5> 
           		Before you try to submit the payment  you need to settle the payment at finance department,  scan and upload the receipt at the provided place. The format of file should be PDF(maximum size 5MB)
           		</h5>
           </div>
	   <div class="large-12 columns">
		<div class="row">
		    <div
			class="large-3 columns">
			<label>Academic Year
			    <?php echo $this->Form->input('academic_year',
		                array('options'=>$acyear_array_data,'style'=>'width:100px',
		                'selected'=>$defaultacademicyear,'label'=>false)); ?>
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
		                array('options'=>array('0'=>'--Select Sponsor Type--','Self'=>'Self','Government'=>'Government',
            'Others'=>'Others'),'label'=>false, 'onchange' => "displayFields(this)",)) ?>
			</label>
		    </div>

		</div>
           </div>
	</div>
	 <?php
	 	$display="none";
	 	if(isset($this->request->data['Payment']['sponsor_type']) && !empty($this->request->data['Payment']['sponsor_type']) && $this->request->data['Payment']['sponsor_type']=='Self'){
	 		$display="block";
	 	}
	 	debug($display);

	 ?>
	 
	 
	 <div  id="displayField" class="row" style="display:<?php echo $display?>;">
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
		 <div	class="large-12 columns">
		                        <?php
		                            echo $this->Form->submit(__('Submit the payment'), array('name' => 'paid', 'class' => 'tiny radius button bg-blue', 'id' => 'applyOnline', 'div' => false));
		                          
		                            ?>

		 </div>

        </div>

	<div class="row">
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


    </div>
</div>
<?php echo $this->Form->end(); ?>


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

