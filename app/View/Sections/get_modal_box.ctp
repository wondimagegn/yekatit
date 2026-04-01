<?php ?>
<div class="row">
<div class="large-12 columns">
	<h1>
	 Detail of Un-Upgraded Students
	</h1>

<?php 
	 if(isset($students_details)){
	 $unqualified_students_count = count($students_details);
	 if($unqualified_students_count ==0){
	 	 echo '<div class="font_color"> All Students of this Section are qualified to upgrade.</div>';
	 } else {
	 	if($unqualified_students_count ==1){
	 		echo '<div class="font_color"> '.$unqualified_students_count.' Student is not qualified to upgrade with their section. Thus a student will be section-less if this section is upgraded to next level.</div>';	
	 	}else {
		 echo '<div class="font_color"> '.$unqualified_students_count.' Students are not qualified to upgrade with their section. Thus those students will be section-less if this section is upgrade to next level.</div>';	}
		?>
	 <table style="border: #CCC solid 1px">
		 	<tr><th style="border-right: #CCC solid 1px"><?php echo 'No.';?></th><th style="border-right: #CCC solid 1px"><?php echo 'Full Name';?></th><th style="border-right: #CCC solid 1px"><?php echo 'ID';?></th><th style="border-right: #CCC solid 1px"><?php echo 'Status';?></th></tr>
		 	<?php 
		 	
		 	$count = 1;
			foreach ($students_details as $sdk=>$sdv){
				echo '<tr><td style="border-right: #CCC solid 1px">'.$count++.'</td>';
				echo '<td style="border-right: #CCC solid 1px">'.$sdv['Student']['full_name'].'</td>';
				echo '<td style="border-right: #CCC solid 1px">'.$sdv['Student']['studentnumber'].'</td>';
				echo '<td style="border-right: #CCC solid 1px">Not generate/'.$status_name.'</td></tr>';
			 }
		}
	} 
	?>
	</table> 
</div>
</div>
<a class="close-reveal-modal">&#215;</a>
