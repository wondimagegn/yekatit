<?php ?>
<div class="attrationView index">
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

if (isset($currentlyActiveStudentStatistics['result']) 
  && !empty($currentlyActiveStudentStatistics['result'])) {
    foreach($currentlyActiveStudentStatistics['result'] as 
      $program=>$statDetail) {
     
    ?>
      <p class="fs16">
            

                <?php echo str_replace('undergraduate/graduate ', $program, $headerLabel); ?>
      </p>

<table style="width:100%">
  
    <tr>
    		<th rowspan="2" class="bordering2" style="vertical-align:bottom; width:2%">S.N<u>o</u>
    		</th>
		
		    <th rowspan="2" class="bordering2" style="vertical-align:bottom; width:15%">College/School/Center</th>
		    <th rowspan="2" class="bordering2"  style="vertical-align:bottom; width:8%">Department</th>
         <th rowspan="2" class="bordering2"  style="vertical-align:bottom; width:8%">Year</th>
         
         <?php
           unset($program_types[0]);
          foreach ($program_types as $k=>$value) { ?>
    
    <th colspan="3"  class="bordering2" class="bordering2"><?php echo $value;?></th>
     <?php } ?>
    </tr>
    <tr>
     <?php foreach ($program_types as $k=>$value) { ?>
       <th style="width:5%" class="bordering2">M</th>
    <th style="width:5%" class="bordering2">F</th>
    <th style="width:5%" class="bordering2">Total</th>
   
     <?php } ?>
     </tr>
    
   <?php 
   $count=0;
   foreach($statDetail as $college=>$departmentList) { ?>
          <tr>
              <td class="bordering2" rowspan="<?php echo  $currentlyActiveStudentStatistics['collegeRowSpan'][$college]+count($departmentList)+1;?>">
              <?php echo ++$count;?>
              </td>

               <td class="bordering2" rowspan="<?php echo  $currentlyActiveStudentStatistics['collegeRowSpan'][$college]+count($departmentList)+1;?>">
              <?php echo $college;?>
              </td>
          </tr>
        
             <?php foreach($departmentList as $deptname=>$yearList) { ?>
                 <tr>
                        <td class="bordering2" rowspan="<?php echo count($yearList)+1 ?>"><?php echo $deptname; ?></td>
                  </tr>

                  <?php foreach ($yearList as $yk => $programTypesList) {
                    ?>
                     <tr>
                      <td class="bordering2"><?php echo $yk; ?></td>
                       <?php foreach($programTypesList as $pk=>$ppv) { 
                          $sumByProgramType[$pk]['male']+=$ppv['male'];
                           $sumByProgramType[$pk]['female']+=$ppv['female'];
                           $sumByProgramType[$pk]['total']+=$ppv['total'];
                        ?>
                        <td class="bordering2"><?php echo $ppv['male']; ?></td>
                         <td class="bordering2"><?php echo $ppv['female']; ?></td>
                          <td class="bordering2"><?php echo $ppv['total']; ?></td>
                       <?php } ?>
                 </tr>

                    <?php 
                  
                  } ?>

                
            <?php } ?>
          
         
   <?php } ?>

   <tr>
        <th rowspan="2" class="bordering2" style="vertical-align:bottom; width:2%">
        </th>
    
        <th rowspan="2" class="bordering2" style="vertical-align:bottom; width:15%"></th>
        <th rowspan="2" class="bordering2"  style="vertical-align:bottom; width:8%"></th>
         <th rowspan="2" class="bordering2"  style="vertical-align:bottom; width:8%">Sum</th>
         
         <?php
           unset($program_types[0]);
           ?>
    </tr>
    <tr>
     <?php 

     foreach ($program_types as $k=>$pvalue) { ?>
       <th style="width:5%" class="bordering2"><?php echo 
       $sumByProgramType[$pvalue]['male'];?></th>
    <th style="width:5%" class="bordering2"><?php echo 
       $sumByProgramType[$pvalue]['female'];?></th>
    <th style="width:5%" class="bordering2"><?php echo 
       $sumByProgramType[$pvalue]['total'];?></th>
   
     <?php } ?>
     </tr>

</table>
<?php 
     
  }
 }
?>