<?php ?>
<table style="border: #CCC solid 1px" id="sectionNotAssignClass"><tbody>
<tr>
    <td colspan="3">
      <?php echo __('Tables: Summary of students who are not assign to section for '.$sselectedAcademicYear.'
academic year.');
    // debug($selectedAcademicYear);
?>
    
    </td>
</tr>
<?php 
$count_program = count($programs);
$count_program_type = count($programTypes);
    echo '<tr><th style="border-right: #CCC solid 1px">'."ProgramType/ Program".'</th>'; //Display ProgramType/Program label
    foreach($programs as $kp=>$vp) {
        echo '<th style="border-right: #CCC solid 1px">'.$vp.'</th>';
    }
    echo '</tr>';
    for($i=1;$i<=$count_program_type;$i++) {
        echo '<tr><td style="border-right: #CCC solid 1px">'.$programTypes[$i].'</td>';
        for($j=1;$j<=$count_program;$j++) {
            echo '<td style="border-right: #CCC solid 1px">'.$summary_data[$programs[$j]][$programTypes[$i]].'</td>';
        }
        echo '</tr>';
    }
 
 if(isset($curriculum_unattached_student_count) && $curriculum_unattached_student_count >0){
	echo '<tr><td colspan="3" class="centeralign_smallheading">'.$curriculum_unattached_student_count.
	' students did not attached to the department 
	curriculum, So these students did not participate in any section assignment.</td></tr>';

}
?>
</tbody></table></td>
</tr></table>
<script type="text/javascript">
$(document).ready(function() {
   $("#FixedSectionName").val("<?php echo $FixedSectionName;?>");
});

</script>
