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

if (isset($distributionStatistics['getActiveStaffList']) && !empty($distributionStatistics['getActiveStaffList'])) {
  ?>               
<?php  
 
foreach($distributionStatistics['getActiveStaffList'] as $departmentNamee=>$listStaff) {
   if(isset($listStaff) && !empty($listStaff)){
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
                  <td class="bordering2" > 
                    <?php echo ++$count;?>
                  </td>
                   <td class="bordering2" > 
                    <?php 

                    echo $v['Title']['title'].' '.
                    $v['Staff']['full_name'];

                    if($v['User']['is_admin']==1 ) {
                        echo ' <strong>(Main Account)</strong> ';
                    } 

                    ?>
                  </td>
                 <td class="bordering2">
                    <?php echo $v['Position']['position'];?>

                 </td>
              </tr>
     <?php } ?>
 </table>
   
 <?php 
    }
 }
 ?>

 <?php 
}   
?>