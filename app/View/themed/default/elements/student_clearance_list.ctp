<?php
if(!empty($clearances)) {
?>
<p class="fs14" style="margin-bottom:0px; font-weight:bold">Clearance History</p>
<table style="margin-top:0px; width:40%">
	<tr>
		<th style="width:40%">Requested Date</th>
		<th style="width:60%">Accepted Date</th>
	</tr>
<?php
foreach($clearances as $clearance) {
	?>
	<tr>
		<td><?php echo $this->Format->short_date($clearance['Clearance']['request_date']); ?></td>
		<td><?php echo $this->Format->short_date($clearance['Clearance']['acceptance_date']); ?></td>
	</tr>
	<?php
}
?>
</table>
<?php
}
else {
	echo '<div class="warning-box warning-message"><span></span>The student does not has any clearance.</div>';
}
?>
