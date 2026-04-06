	<?php
	if(!empty($costShares)) {
		?>
		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Cost sharing dues</p>
		<table style="margin-top:0px; width:85%">
			<tr>
				<th style="width:10%">Academic Year</th>
				<th style="width:10%">Education Fee</th>
				<th style="width:10%">Accomodation Fee</th>
				<th style="width:10%">Meal Service Fee</th>
				<th style="width:10%">Medical Fee</th>
				<th style="width:10%">Total</th>
				<th style="width:15%">Sign Date</th>
			</tr>
		<?php
		$total_due = 0;
		foreach($costShares as $costShare) {
			?>
			<tr>
				<td><?php echo $costShare['CostShare']['academic_year']; ?></td>
				<td><?php echo number_format($costShare['CostShare']['education_fee'], 2, '.', ','); ?></td>
				<td><?php echo number_format($costShare['CostShare']['accomodation_fee'], 2, '.', ','); ?></td>
				<td><?php echo number_format($costShare['CostShare']['cafeteria_fee'], 2, '.', ','); ?></td>
				<td><?php echo number_format($costShare['CostShare']['medical_fee'], 2, '.', ','); ?></td>
				<td><?php 
					$year_total = ($costShare['CostShare']['education_fee']+$costShare['CostShare']['accomodation_fee']+$costShare['CostShare']['cafeteria_fee']+$costShare['CostShare']['medical_fee']);
					$total_due += $year_total;
					echo number_format($year_total, 2, '.', ',');
				?></td>
				<td><?php echo $this->Format->short_date($costShare['CostShare']['cost_sharing_sign_date']); ?></td>
			</tr>
			<?php
		}
		?>
			<tr>
				<td style="font-weight:bold; text-align:right" colspan="5">TOTAL</td>
				<td style="font-weight:bold"><?php echo number_format($total_due, 2, '.', ','); ?></td>
				<td></td>
			</tr>
		</table>
		<?php
		if(!empty($costSharingPayments)) {
		?>
		<p class="fs14" style="margin-bottom:0px; font-weight:bold">Cost sharing payment</p>
		<table style="margin-top:0px; width:50%">
			<tr>
				<th style="width:30%">Reference Number</th>
				<th style="width:30%">Payment Amount</th>
				<th style="width:40%">Payment Type</th>
			</tr>
		<?php
		foreach($costSharingPayments as $costSharingPayment) {
			?>
			<tr>
				<td><?php echo $costSharingPayment['CostSharingPayment']['reference_number']; ?></td>
				<td><?php echo $costSharingPayment['CostSharingPayment']['amount']; ?></td>
				<td><?php echo $costSharingPayment['CostSharingPayment']['payment_type']; ?></td>
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
	}
	else {
		echo '<div class="info-box info-message">There is no recorded cost sharing dues.</div>';
	}
