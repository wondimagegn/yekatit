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

if (isset($gradeStatistics['statistics']) && !empty($gradeStatistics['statistics'])) {
  ?>
 
  <?php 

  echo $this->element('reports/graph-grade-statistics');
  ?>
 <table style="width:100%">
                   
                <tr>
                 
                    <td class="bordering2"> Grade </td> 
                    <td class="bordering2"> Freq. </td> 
                </tr>     
              
<?php  
$count=0;  
foreach($gradeStatistics['statistics'] as $grade=>$freq) {
   ?>
  	    
                <tr>
                 
                    <td class="bordering"> <?php echo $grade; ?> </td> 
                    <td class="bordering"><?php echo $freq;?> </td> 
                </tr>     

<?php } ?>
   
 </table>
 <?php 
}   
?>
