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

if (isset($distributionStatistics['getDistributionStatsTeacherToStudents']) && !empty($distributionStatistics['getDistributionStatsTeacherToStudents'])) {
  ?>
 <h5><?php echo $headerLabel;?></h5>
  <?php 

  echo $this->element('staffs/graph');
  ?>
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