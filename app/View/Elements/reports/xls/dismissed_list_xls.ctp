<?php 
/*
This file should be in app/views/elements/export_xls.ctp
Thanks to Marco Tulio Santos for this simple XLS Report
*/
header ("Expires: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=".$filename.".xls" );
header ("Content-Description: Exported as XLS" );
?>

<?php 
if(isset($dismissedList) && !empty($dismissedList)){
  ?>
  <h5><?php echo $headerLabel;?></h5>
  <?php 
  foreach ($dismissedList as $dkey => $dvalue) {
?>
 <h5><?php echo $dkey;?></h5>
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> ID </td> 
                    <td class="bordering2"> Fullname </td> 
                    <td class="bordering2"> Sex </td> 
                    <td class="bordering2"> CGPA </td> 
                    <td class="bordering2"> SGPA </td> 
                    <td class="bordering2"> Program </td> 
                    <td class="bordering2"> ProgramType </td> 
                </tr>      
                <?php 
                $count=0;
                foreach($dvalue as $dk) { 
                  $count++;
                  
                  ?>
                 <tr>
                    <td class="bordering"> <?php echo $count++;?> </td> 
                     <td class="bordering"> <?php 
                     echo $dk['studentnumber'];
           
?> </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dk['first_name'].' '.$dk['middle_name'].' ';
                      
?>
                     </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dk['gender'];
?>
                     </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dk['cgpa'];
?>
                     </td> 

                      <td class="bordering">
                       
                       <?php 
                       echo $dk['sgpa'];
?>
                     </td> 
                      <td class="bordering">
                       
                       <?php 
                       echo $dk['program_id'];
?>
                     </td> 

                      <td class="bordering">
                       
                       <?php 
                       echo $dk['program_type_id'];
?>
                     </td> 
                   
                </tr>    
                <?php } ?>
               
  </table>
<?php 
  }
?>
<?php 
}
?>
