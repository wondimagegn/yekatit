<?php ?>
<style>
.low_padding_table tr td{
padding:2px
}
</style>
<?php 

if (isset($student_academic_profile['Curriculum']['Course']) && !empty($student_academic_profile['Curriculum']['Course']))  {

$curriculums=$student_academic_profile['Curriculum']['Course'];
foreach ($curriculums as $year_level=>$semester) {
    foreach ($semester as $sem=>$course) {
?>
    
<table class="low_padding_table fs13">
	<tr>
		<td style="width:26%; font-weight:bold">Year Level:</td>
		<td style="width:74%"><?php echo $year_level; ?></td>
	</tr>
	<tr>
		<td style="width:26%; font-weight:bold">Semester:</td>
		<td style="width:74%"><?php echo $sem; ?></td>
	</tr>
</table>
<table class="low_padding_table fs13">
	<tr>
		<th style="width:5%">N<u>o</u></th>
		<th style="width:13%">Course Code</th>
		<th style="width:20%">Course Title</th>
		<th style="width:10%; text-align:center">Credit Hour</th>
		<th style="width:20%; text-align:center">Course Category</th>
		<th style="width:17%">Grade Type</th>
		<th style="width:15%; text-align:center">Prerequisite</th>
	</tr>
	
    <?php
      $c_count=1;
      foreach ($course as $index=>$value) {
		
    ?>
         <tr>
		    <td><?php echo $c_count++; ?></td>
		    <td><?php echo $value['course_code']; ?></td>
		    <td><?php echo $value['course_title']; ?></td>
		    <td style="text-align:center"><?php echo $value['credit']; ?></td>
		    <td style="text-align:center"><?php echo $value['CourseCategory']['name']; ?></td>
		    <td style="text-align:center"><?php echo $value['GradeType']['type'];?></td>
			<td>
				<?php 

				if(!empty($value['Prerequisite'])){
						echo '<ul>';
						foreach($value['Prerequisite'] as $p=>$pv){
							echo '<li>'.$pv['PrerequisiteCourse']['course_title'].'('.$pv['PrerequisiteCourse']['course_code'].')'.'</li>';
						}
						echo '</ul>';
			    } else {

					echo 'none';
				}


				?>
			</td>
	    </tr>
    <?php   
      } // end of course iteration 
    echo '</table>';
     
	} // end of semester
  }	// end of year level  
} // end of curriculum  
?>

