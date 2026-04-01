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

if (isset($distributionStatistics['distributionStatsTeachersByGender']) && !empty($distributionStatistics['distributionStatsTeachersByGender'])) {

  ?>
 <h5><?php echo $headerLabel;?></h5>
  <?php 
  echo $this->element('staffs/graph');
  ?>
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> Department </td> 
                    <td class="bordering2"> Gender </td> 
                     <td class="bordering2"> Number </td> 
                </tr>     
            
<?php  
 $count=0;  
foreach($distributionStatistics['distributionStatsTeachersByGender'] as $departmentName=>$yll) {
    ?>
      <tr>


        <td class="bordering2" > <?php echo ++$count; ?> </td> 
        <td class="bordering2" > <?php echo $departmentName; ?>  </td> 
        <td class="bordering2" > Male</td> 
        <td class="bordering2" > <?php echo $yll['male']; ?> </td> 
       
    </tr>

      <tr>


        <td class="bordering2" > </td> 
        <td class="bordering2" > </td>
        <td class="bordering2" > Female</td> 
        <td class="bordering2" > <?php echo $yll['female']; ?> </td> 
    </tr>
        
  <?php 
 }
 ?>
 </table>
 <?php 
}   
?>