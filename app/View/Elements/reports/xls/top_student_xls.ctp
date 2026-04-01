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


<?php 
if (isset($top) && !empty($top)) {

foreach($top as $program=>$programType) {
    foreach ($programType as $programTypeName=> $statDetail) {
		//debug($statDetail);
?>
    <p class="fs16">
            Top <?php echo $this->data['Report']['top'].' '.$this->data['Report']['gender']; ?> students as of  <?php echo $this->data['Report']['acadamic_year']; ?> A/Y, 
            and Semester    <?php  echo $this->data['Report']['semester']; ?>  <br/>
            <strong> Program : </strong>   <?php 
                  echo $program;
                ?>
                <br/>
            <strong> Program Type: </strong>  <?php 
                  echo $programTypeName;
                  
                 
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
			<td class="bordering2"> Year </td> 
                        <td class="bordering2"> SGPA </td> 
                         <td class="bordering2"> CGPA </td> 
                    </tr>     
                 <?php 
                    $count=0;
                    foreach ($statDetail as $in=>$val) {
		
                  ?>
                      <tr>
                        <td class="bordering2" > <?php echo ++$count; ?> </td> 
                        <td class="bordering2" > <?php echo $val['Student']['studentnumber']; ?>  </td> 
                         <td class="bordering2" > <?php echo $val['Student']['gender']; ?>  </td> 
                        <td class="bordering2" > <?php echo $val['Student']['full_name']; ?> </td> 
		 <td class="bordering2" > <?php echo $val['Student']['Department']['name']; ?> </td> 
			 <td class="bordering2" > <?php echo $val['Student']['yearLevel']; ?> </td> 
        <td class="bordering2" > <?php echo $val['StudentExamStatus']['sgpa']; ?> </td> 
                        <td class="bordering2" > <?php echo $val['StudentExamStatus']['cgpa']; ?> </td> 
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
}   
?>

