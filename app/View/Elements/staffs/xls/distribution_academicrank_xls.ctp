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

<h5><?php echo $headerLabel;?></h5>
<?php 

<?php 

if (isset($distributionStatistics['distributionStatsTeachersByAcademicRank']) && !empty($distributionStatistics['distributionStatsTeachersByAcademicRank'])) {
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
                    <td class="bordering2" colspan="<?php echo count($positions);?>">Position</td> 
                </tr>     
                <tr>
                      <td class="bordering2"> &nbsp;</td> 
                      <td class="bordering2"> &nbsp; </td> 
                      <td class="bordering2"> &nbsp; </td> 
                     
                      <?php 
                     
                      foreach ($positions as $sk => $svalue) {
                       
                        ?>
                   <td class="bordering2"> 
                   <?php echo $svalue; ?> </td> 
                        <?php 
                       
                      }

                  ?>
                </tr>  
<?php  
$count=0;  
foreach($distributionStatistics['distributionStatsTeachersByAcademicRank'] as $departmentNamee=>$genderWithRank) {
 ?>
     <tr>
        <td class="bordering2" > 
          <?php echo ++$count;?>
        </td>
         <td class="bordering2" > 
          <?php echo $departmentNamee;?>
        </td>
        <td class="bordering2">
        Male
        </td>
         
        <?php 

        foreach ($genderWithRank['male'] as $sk => $svalue) {

        ?>
        <td class="bordering2"> 
        <?php echo $svalue; ?> </td> 
        <?php 

        }

        ?>
    </tr>

    <tr>
        <td class="bordering2" > 
         &nbsp;
        </td>
         <td class="bordering2" > 
         &nbsp;
        </td>
        <td class="bordering2">
        Female
        </td>
         
        <?php 

        foreach ($genderWithRank['female'] as $sk => $svalue) {

        ?>
        <td class="bordering2"> 
        <?php echo $svalue; ?> </td> 
        <?php 

        }

        ?>
    </tr>

 <?php 

 }
 ?>

 </table>
 <?php 
}   
?>