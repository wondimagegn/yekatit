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
header ("Content-Disposition: attachment; filename=".$filename.".xls" );
header ("Content-Description: Exported as XLS" );
?>
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
if (isset($registeredList) && 
!empty($registeredList)) {
?>
 
</p>
<?php 
foreach($registeredList as $programD=>$list) {
    $headerExplode=explode('~',$programD);
?>
	     <p class="fs16">
		  <strong> College : </strong>   <?php 
		          echo $headerExplode[0];
		        ?>
		        <br/>
		   <strong> Department : </strong>   <?php 
		          echo $headerExplode[1];
		        ?>
		        <br/>
	 
		   <strong> Program : </strong>   <?php 
		          echo $headerExplode[2];
		        ?>
		        <br/>
		    <strong> Program Type: </strong>  <?php 
		          echo $headerExplode[3];
		          
		         
		        ?>
		        <br/>
  			<strong> Year  : </strong>   <?php 
		          echo $headerExplode[4];
		        ?>
		        <br/>
		
	    </p>
		   
            <?php 

  
              ?>
                <table style="width:100%">
                   
                    <tr>
                        <td class="bordering2"> S.N<u>o</u> </td> 
                        <td class="bordering2"> Full Name </td> 
                        <td class="bordering2"> ID </td> 
                        <td class="bordering2"> Sex </td> 
                       <td class="bordering2"> Section </td>
                                           <td class="bordering2"> Credit Hour </td> 
		
                    </tr>     
                 <?php 
                    $count=0;
             
                    foreach ($list as $ko=>$val) {

		
                  ?>
 
                       <tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?php echo $val['Student']['id'];?>">
                        <td class="bordering" > <?php echo ++$count; ?> </td> 
                       
                       
                        <td class="bordering" > <?php echo $val['Student']['full_name']; ?> </td> 
			 <td class="bordering" > <?php echo $val['Student']['studentnumber']; ?>  </td> 
			<td class="bordering" > <?php echo $val['Student']['gender']; ?>  </td> 
			
			<td class="bordering" > <?php echo $val['Student']['sectionname']; ?>  </td> 
			
			<td class="bordering" > <?php echo $val['Student']['credithour']; ?>  </td> 
  		
                    </tr>     
                  <?php 
                   
                 }
?>
    </table>
<?php 
}
                 ?>
            
          
        
  <?php 
 
}   
?>

