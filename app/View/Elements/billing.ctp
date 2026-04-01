	<?php
	if(!empty($student_academic_profile['CostShare'])) {

		?>
		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Cost sharing dues</p>
		<table style="margin-top:0px; width:85%">
			<tr>
				<th style="width:10%">Academic Year</th>
				<th style="width:10%">Sharing Cycle</th>
				<th style="width:10%">Education Fee</th>
				<th style="width:10%">Accomodation Fee</th>
				<th style="width:10%">Meal Service Fee</th>
				<th style="width:10%">Medical Fee</th>
				<th style="width:10%">Total</th>
				<th style="width:15%">Sign Date</th>
				
			</tr>
		<?php
		$total_due = 0;
		foreach($student_academic_profile['CostShare'] as $ks=> $costShare) {
			?>
			<tr>
				<td><?php echo $costShare['academic_year']; ?></td>
				<td><?php echo $costShare['sharing_cycle']; ?></td>
				<td><?php echo number_format($costShare['education_fee'], 2, '.', ','); ?></td>
				<td><?php echo number_format($costShare['accomodation_fee'], 2, '.', ','); ?></td>
				<td><?php echo number_format($costShare['cafeteria_fee'], 2, '.', ','); ?></td>
				<td><?php echo number_format($costShare['medical_fee'], 2, '.', ','); ?></td>
				<td><?php 
					$year_total = ($costShare['education_fee']+$costShare['accomodation_fee']+$costShare['cafeteria_fee']+$costShare['medical_fee']);
					$total_due += $year_total;
					echo number_format($year_total, 2, '.', ',');
				?></td>
				<td><?php echo $this->Format->short_date($costShare['cost_sharing_sign_date']); ?></td>
			</tr>
			<?php
		}
		?>
			<tr>
				<td style="font-weight:bold; text-align:right" colspan="6">TOTAL</td>
				<td style="font-weight:bold"><?php echo number_format($total_due, 2, '.', ','); ?></td>
				<td></td>
			</tr>
		</table>
		<?php
		if(!empty($student_academic_profile['CostSharingPayment'])) {
		?>
		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Cost sharing payment</p>
		<table style="margin-top:0px; width:50%">
			<tr>
				<th style="width:30%">Reference Number</th>
				<th style="width:30%">Payment Amount</th>
				<th style="width:40%">Payment Type</th>
			</tr>
		<?php
		foreach($student_academic_profile['CostSharingPayment'] as $cshP=> $costSharingPayment) {
			?>
			<tr>
				<td><?php echo $costSharingPayment['reference_number']; ?></td>
				<td><?php echo $costSharingPayment['amount']; ?></td>
				<td><?php echo $costSharingPayment['payment_type']; ?></td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
		}
		else {
			echo '<div class="info-box info-message">There is no recorded cost sharing payments.</div>';
		}
	} else if(!empty($student_academic_profile['ApplicablePayment'])){
		?>

		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Applicable Payment Due</p>
		<table style="margin-top:0px; width:85%">
			<tr>
				<th style="width:10%">Academic Year</th>
				<th style="width:10%">Semester</th>
				<th style="width:10%">Tutition fee</th>
				<th style="width:10%">Accomodation Fee</th>
				<th style="width:10%">Meal Service Fee</th>
				<th style="width:10%">Medical Fee</th>
				<th style="width:10%">Sponsor Type</th>
				<th style="width:10%">Sponsor Name</th>
			</tr>
		<?php
		$total_due = 0;
		foreach($student_academic_profile['ApplicablePayment'] as $app=> $applicablePayment) {
			?>
			<tr>
				<td><?php echo $applicablePayment['academic_year']; ?></td>
				<td><?php echo $applicablePayment['semester']; ?></td>
				<td><?php echo $applicablePayment['tutition_fee']==1 ? "Yes":"No" ?></td>
				<td><?php echo $applicablePayment['accomodation']==1 ? "Yes":"No" ?></td>

				<td><?php echo $applicablePayment['meal']==1 ? "Yes":"No" ?></td>
				<td><?php echo $applicablePayment['health']==1 ? "Yes":"No" ?></td>
				<td><?php echo $applicablePayment['sponsor_type'];?></td>
				<td><?php echo $applicablePayment['sponsor_name'];?></td>
			</tr>
			<?php
		}
		?>
		
		</table>
		<?php
		if(!empty($student_academic_profile['Payment'])) {
		?>
		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Payment Details</p>
		<table style="margin-top:0px; width:50%">
			<tr>
			    <th style="width:15%">Academic year</th>
			     <th style="width:15%">Semester</th>
				<th style="width:30%">Reference Number</th>
				<th style="width:30%">Payment Amount</th>
				
			</tr>
		<?php
		foreach($student_academic_profile['Payment'] as $pk=>$payment) {
			?>
			<tr>
				<td><?php echo $payment['academic_year']; ?></td>
				<td><?php echo $payment['semester']; ?></td>
				<td><?php echo $payment['reference_number']; ?></td>

				<td><?php echo $payment['fee_amount']; ?></td>
			</tr>
			<?php
		}
		?>
		</table>

		<?php } else { ?>
		<div class="info-box info-message">There is no recorded payment</div>
		<?php } ?>

		<?php 

	} else {
		echo '<div class="info-box info-message">There is no recorded cost sharing dues.</div>';
	}
	?>