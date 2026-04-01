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

if (isset($resultBy) && !empty($resultBy)) {

foreach($resultBy as $program=>$statDetail) {
	$headerExplode=explode('~',$program);
    
		//debug($statDetail);
?>
    <p class="fs16">
        
            <strong> Program : </strong>   <?php 
                  echo $headerExplode[0];
                ?>
                <br/>
            <strong> Program Type: </strong>  <?php 
                  echo $headerExplode[1];
                  
                 
                ?>
                <br/>       

		    <strong> Department: </strong>  <?php 
                  echo $headerExplode[2];
                  
                 
                ?>
                <br/>      
		  <strong> Year: </strong>  <?php 
                  echo $headerExplode[3];
                  
                 
                ?>
                <br/>        
    </p>
           
            <?php 

  
              ?>
                <table style="width:100%">
                   
                    <tr>
                        <td class="bordering2"> S.N<u>o</u> </td> 
                        <td class="bordering2"> ID </td> 
                        <td class="bordering2"> Sex </td> 
                        <td class="bordering2"> Full Name </td> 
						<td class="bordering2"> Department </td> 
                        <td class="bordering2"> CGPA </td> 
					     <td class="bordering2"> SGPA </td> 
                    </tr>     
                 <?php 
                    $count=0;
                    $totalGenderCount['female']=0;
                    $totalGenderCount['male']=0;
                    foreach ($statDetail as $in=>$val) {
		
                  ?>
                      <tr>
                        <td class="bordering2" > <?php echo ++$count; ?> </td> 
                        <td class="bordering2" > <?php echo $val['Student']['studentnumber']; ?>  </td> 
                         <td class="bordering2" > <?php echo $val['Student']['gender']; ?>  </td> 
                        <td class="bordering2" > <?php echo $val['Student']['full_name']; ?> </td> 
		 				<td class="bordering2" > <?php echo $val['Student']['Department']['name']; ?> </td> 
                        <td class="bordering2" > <?php echo $val['StudentExamStatus']['cgpa']; ?> </td> 
					   <td class="bordering2" > <?php echo $val['StudentExamStatus']['sgpa']; ?> </td> 
                    </tr>     
                  <?php 
                      $totalGenderCount[$val['Student']['gender']]++;
                    }
                 ?>
				  <tr>
					<td>Total Female</td> <td><?php echo $totalGenderCount['female']; ?></td>
                    <td>Percent</td> <td><?php echo (($totalGenderCount['female']/($totalGenderCount['female']+$totalGenderCount['male']))*100).'%';?></td>
				 </tr>
        <tr>
					<td>Total Male</td> <td><?php echo $totalGenderCount['male']; ?></td>
                     <td>Percent</td> <td><?php echo (($totalGenderCount['male']/($totalGenderCount['female']+$totalGenderCount['male']))*100).'%';?></td>
				 </tr>
    </table>
  <?php 
 }
}   
?>

