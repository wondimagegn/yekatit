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

if (isset($distributionStatistics['getDistributionStatsTeacherToStudents']) && !empty($distributionStatistics['getDistributionStatsTeacherToStudents'])) {
  ?>
 <h5><?php echo $headerLabel;?></h5>
 
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> Department </td> 
                    <td class="bordering2"> Type </td>   
                    <td class="bordering2"> Number </td>  
                    <td class="bordering2"> Ratio </td>   
                </tr>     
               
<?php  
$count=0;  
foreach($distributionStatistics['getDistributionStatsTeacherToStudents'] as $departmentNamee=>$genderWithRank) {
 ?>
     <tr>
        <td rowspan="2" class="bordering2" > 
          <?php echo ++$count;?>
        </td>
         <td rowspan="2" class="bordering2" > 
          <?php echo $departmentNamee;?>
        </td>
        <td class="bordering2">
          Student
        </td>
        <td class="bordering2">
           <?php 
              echo $genderWithRank['student'];
           ?>
        </td>
        <td rowspan="2" class="bordering2"  style="vertical-align: center;" ><?php 

        if($genderWithRank['teacher']>0) {
            echo 'One teacher to '.round($genderWithRank['student']/$genderWithRank['teacher']).' students '; 

        } else {
          echo 'No teacher is feeded into the system by given department';
        }
       

        ?></td>
    </tr>

    <tr>
       
        <td class="bordering2">
          Teacher
        </td>
        <td class="bordering2">
           <?php 
              echo $genderWithRank['teacher'];
           ?>
        </td>
        
    </tr>
 <?php 

 }
 ?>

 </table>
 <?php 
}   
?>
