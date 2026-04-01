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
header ("Content-Disposition: attachment; 
  filename=".$filename.".xls" );
header ("Content-Description: Exported as XLS" );
?>


<?php 

if (isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) {
  ?>               
<?php  
 
foreach($distributionStatistics['getDistributionStatsTeacherToStudents'] as $departmentNamee=>$listStaff) {
 ?>
  <h5><?php echo $headerLabel.' '.$departmentNamee;?></h5>

 <table style="width:100%">
                   
      <tr>
          <td class="bordering2"> S.N<u>o</u> </td> 
         
          <td class="bordering2"> Name </td>   
          <td class="bordering2"> Position </td>  
          
      </tr>   
      <?php 
      $count=0; 
      foreach($listStaff as $k=>$v) { ?>
     <tr>
        <td rowspan="2" class="bordering2" > 
          <?php echo ++$count;?>
        </td>
         <td rowspan="2" class="bordering2" > 
          <?php echo $v['Title']['title'].' '.$v['Staff']['full_name'];?>
        </td>
       <td>
          <?php echo $v['Position']['position'];?>

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