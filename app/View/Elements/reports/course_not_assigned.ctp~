<?php ?>
<style>
.bordering {
border-left:1px #cccccc solid;
border-right:1px #cccccc solid;
}
.bordering2 {
border-left:1px #000000 solid;
border-right:1px #000000 solid;
border-top:1px #000000 solid;
border-bottom:1px #000000 solid;
}
.courses_table tr td, .courses_table tr th {
padding:1px
}
</style>

<?php 

if (isset($notAssignedCourseeList) && 
!empty($notAssignedCourseeList)) {
  ?>
 <h5><?php echo $headerLabel;?></h5>
 <table style="width:100%">
                   
			<tr>
			<td class="bordering2">S.N<u>o</u> </td> 
			<td class="bordering2">Course Department </td> 
			<td class="bordering2">Course</td> 

			<td class="bordering2">Section </td> 
			<td class="bordering2">Program </td> 
			<td class="bordering2">Program Type </td> 

			</tr>     
               
<?php  
$count=0;  
foreach($notAssignedCourseeList as $departmentNamee=>$courseList) {
?>
  <tr>
         <td colspan="6">Student Department: <?php echo $departmentNamee ?></td> 
 </tr>     
<?php 
    foreach ($courseList as $rkey => $rvalue) {
      $count=0;
     
    ?>
   <tr>
         <td colspan="6">Year: <?php echo $rkey ?></td> 
 </tr>     
     
    
        <?php 
    if(isset($rvalue) && !empty($rvalue)){
        foreach($rvalue as $mn=>$ym){ 
         
          ?>
          <tr>
        <td class="bordering" > 
<?php 
           echo ++$count;      
?>
        </td>
        <td class="bordering" > 
         <?php 
          echo $ym['GivenByDepartment']['name'];
	?>
         </td> 
         <td class="bordering" >  <?php 
          echo $ym['Course']['course_title'].' '.$ym['Course']['course_code'];
	?>  </td> 
        <td class="bordering"><?php echo $ym['Section']['name']?> 
        </td>
        <td class="bordering"><?php echo $ym['Program']['name']?> 
        </td>
        <td class="bordering"><?php echo $ym['ProgramType']['name'];?> 
        </td>
    </tr>
   
        <?php 
        
          }
        } else {
        
         ?>
          <tr><td colspan="6" class="info-message info-box">There is no course in given criteria which is not assigned to instructors.</td></tr>
         <?php 
		}
    
    }
 }
 ?>
 </table>
 <?php 
}   
?>
