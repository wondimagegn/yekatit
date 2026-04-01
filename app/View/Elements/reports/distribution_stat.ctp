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

if (isset($distributionStatistics['distributionByDepartmentYearLevel']) && !empty($distributionStatistics['distributionByDepartmentYearLevel'])) {

  ?>
 <h5><?php echo $headerLabel;?></h5>
  <?php 
  echo $this->element('reports/graph');
  ?>
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> Department </td> 
                    <td class="bordering2"> Gender </td> 
                    <td class="bordering2" colspan="<?php echo count($years);?>">Year Level</td> 
                </tr>     
                <tr>
                      <td class="bordering2"> &nbsp;</td> 
                      <td class="bordering2"> &nbsp; </td> 
                      <td class="bordering2"> &nbsp; </td> 
                      <?php 
		     if(!empty($this->data['Report']['year_level_id'])){
			?>
			    <td class="bordering2"> 
                   <?php echo $this->data['Report']['year_level_id']; ?> </td> 
			<?php 
			
		     } else {
                      foreach ($years as $ykey => $yvalue) {
                       
                        ?>
                   <td class="bordering2"> 
                   <?php echo $yvalue; ?> </td> 
                        <?php 
                       
                      }
		    }		
                   ?>
                     
                    
                </tr>  
<?php  
 $count=0;  
foreach($distributionStatistics['distributionByDepartmentYearLevel'] as 
  $departmentName=>$yll) {
    ?>
      <tr>


        <td class="bordering2" > <?php echo ++$count; ?> </td> 
        <td class="bordering2" > <?php echo $departmentName; ?>  </td> 
        <td class="bordering2" > Male</td> 
        <?php 
        if(empty($this->data['Report']['year_level_id'])){
		$ylmale=0;	
		
		foreach($yll as $yn=>$yv){ 
			$ylmale++;
		?>
			<td class="bordering2"><?php echo $yv['male'];?></td> 
		<?php } ?>

		<?php 	       
		for($ylmale;$ylmale<count($years);
		$ylmale++) { ?>
		           <td class="bordering2">&nbsp;</td>
		<?php } ?>

	<?php } else { ?>
                  <td class="bordering2" ><?php echo $yll[$this->data['Report']['year_level_id']]['male']; ?> </td> 

	<?php } ?>

 
    </tr>

     <tr>


        <td class="bordering2"></td> 
        <td class="bordering2"></td> 
        <td class="bordering2">Female</td> 
        <?php 
   if(empty($this->data['Report']['year_level_id'])){
	     $ylfemale=0;
	  foreach($yll as $yn=>$yv){ 
	     $ylfemale++;
	?>
        <td class="bordering2"><?php echo $yv['female'];?></td> 
        <?php } ?>
	
         <?php 
       
        for($ylfemale;$ylfemale<count($years);
        $ylfemale++) { ?>
                   <td class="bordering2">&nbsp;</td>
        <?php } ?>

     <?php } else { ?>
                <td class="bordering2" ><?php echo $yll[$this->data['Report']['year_level_id']]['female']; ?> </td> 
     <?php } ?>
 
    </tr>
        
  <?php 
 }
 ?>
 </table>
 <?php 
}   
?>



<?php 

if (isset($distributionStatistics['distributionByRegionYearLevel']) && !empty($distributionStatistics['distributionByRegionYearLevel'])) {
  ?>
   <h5><?php echo $headerLabel;?></h5>
   <?php 
    echo $this->element('reports/graph');?>
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> Department </td> 
                     <td class="bordering2"> Region</td>
                    <td class="bordering2"> Gender </td> 
                    <td class="bordering2" colspan="<?php echo count($years);?>">Year Level</td> 
                </tr>     
                <tr>
                      <td class="bordering2"> &nbsp;</td> 
                      <td class="bordering2"> &nbsp; </td> 
                      <td class="bordering2"> &nbsp; </td> 
                      <td class="bordering2"> &nbsp; </td> 
                      <?php 
                  if(empty($this->data['Report']['year_level_id'])){
                      foreach ($years as $ykey => $yvalue) {
                       
                        ?>
                   <td class="bordering2"> 
                   <?php echo $yvalue; ?> </td> 
                        <?php 
                       
                      }
		  } else if(!empty($this->data['Report']['year_level_id'])) {
                      ?>
                           <td class="bordering2"> <?php echo $this->data['Report']['year_level_id']; ?> </td>    
		<?php } ?>
                </tr>  
<?php  
$count=0;  
foreach($distributionStatistics['distributionByRegionYearLevel'] as $departmentNamee=>$regionss) {
    $nameDisplay=false;
    foreach ($regionss as $rkey => $rvalue) {

    ?>
    <?php if(isset($rvalue['male'])){ ?>
      <tr>
        <td class="bordering2" > 
		<?php 
			if($nameDisplay==false){
			   echo ++$count;
			}
		?>
        </td>
        <td class="bordering2" > 
        <?php
        if($nameDisplay==false){
          echo $departmentNamee;
          $nameDisplay=true;
        }
         
         ?>  </td> 
         <td class="bordering2" > <?php echo $rkey;?>  </td> 
         <td class="bordering2" > Male</td> 
        <?php 
        if(empty($this->data['Report']['year_level_id'])) { 
		$counttdm=0;
		foreach($rvalue['male'] as $mn=>$ym){ 
		     $counttdm++;
		?>
		<td class="bordering2"><?php echo $ym;?></td> 
		<?php } ?>

	       
		 <?php 
	       
		for($counttdm;$counttdm<count($years);
		$counttdm++) { ?>
		           <td class="bordering2">&nbsp;</td>
		<?php } ?>

	<?php } else { ?>
                <td class="bordering2"><?php echo $rvalue['male'][$this->data['Report']['year_level_id']];?></td> 

	<?php } ?>

    </tr>
    <?php } ?>


    <?php if(isset($rvalue['female'])){ ?>
      <tr>
        <td class="bordering2" > 
<?php 
        if($nameDisplay==false){
           echo ++$count;
        }
?>
        </td>
        <td class="bordering2" > 
        <?php
        if($nameDisplay==false){
          echo $departmentNamee;
          $nameDisplay=true;
        }
         
         ?>  </td> 
         <td class="bordering2" > <?php echo $rkey;?>  </td> 
         <td class="bordering2" > Female</td> 
        <?php 
	if(empty($this->data['Report']['year_level_id'])) {
        $counttdf=0;
        foreach($rvalue['female'] as $mn=>$ym){ 
         $counttdf++;
       ?>
        <td class="bordering2"><?php echo $ym;?></td> 
        <?php } ?>

       
         <?php 
       
        for($counttdf;$counttdf<count($years);
        $counttdf++) { ?>
                   <td class="bordering2">&nbsp;</td>
        <?php } ?>

	<?php } else { ?>
             <td class="bordering2"><?php echo $rvalue['female'][$this->data['Report']['year_level_id']];?></td>

	<?php } ?>
    </tr>
    <?php } ?>

    
  <?php 
    }
 }
 ?>
 </table>
 <?php 
}   
?>
