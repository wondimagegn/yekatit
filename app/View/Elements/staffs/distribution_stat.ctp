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