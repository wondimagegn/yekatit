<style>
table.grade_scale tr td{
padding:2px;
}
</style>
<?php
if(!empty($grade_scale) && !isset($grade_scale['error'])) {
	echo '<p class="fs14">Grade scale detail for '.$grade_scale['Course']['course_title'].' ('.$grade_scale['Course']['course_code'].') course.</p>';
	echo '<table class="grade_scale" style="width:50%; border:1px solid #000000">';
	echo '<tr>
				<th style="width:10%">Grade</th>
				<th style="width:24%">Minimum Result</th>
				<th style="width:24%">Maximum Result</th>
				<th style="width:24%">Grade Point Value</th>
				<th style="width:18%">Pass Grade</th>
			</tr>';
	foreach($grade_scale['GradeScaleDetail'] as $key => $grade_scale_detail) {
		echo '<tr>
					<td>'.$grade_scale_detail['grade'].'</td>
					<td>'.number_format($grade_scale_detail['minimum_result'], 2, '.', ',').'</td>
					<td>'.number_format($grade_scale_detail['maximum_result'], 2, '.', ',').'</td>
					<td>'.$grade_scale_detail['point_value'].'</td>
					<td>'.($grade_scale_detail['pass_grade'] == 1 ? 'Yes' : 'No').'</td>
				</tr>';
	}
	echo '</table>';
}
else if(isset($grade_scale['error']))
	echo '<div class="info-message info-box"><span></span>'.$grade_scale['error'].'</div>';
else
	echo '<div class="info-message info-box">Grade scale for the selected course is not found in the system.</div>';
?>
