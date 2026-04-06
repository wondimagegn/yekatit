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
if (isset($activeList) && 
!empty($activeList)) {
?>
 
</p>
<?php 

foreach($activeList as $programD=>$list) {
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
  			<strong> Section  : </strong>   <?php 
		          echo $headerExplode[4];
		        ?>
		        <br/>
		  <strong> Academic Year : </strong>   <?php 
		          echo $headerExplode[5];
		        ?>
		        <br/>
                  <strong>Semester : </strong>   <?php 
		          echo $headerExplode[6];
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
                        <td class="bordering2"> Credit </td> 
                        <td class="bordering2"> CGPA </td> 
                        <td class="bordering2"> Status </td> 
		
                    </tr>     
                 <?php 
                    $count=0;
             
                    foreach ($list as $ko=>$val) {

		if($val['academic_status_id']!=4){
                  ?>
 
                       <tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?php echo $val['id'];?>">
                        <td class="bordering" > <?php echo ++$count; ?> </td> 
                       
                       
                        <td class="bordering" > <?php echo $val['first_name'].' '.
$val['middle_name'].' '.$val['last_name']; ?> </td> 
			 <td class="bordering" > <?php echo $val['studentnumber']; ?>  </td> 
			<td class="bordering" > <?php echo $val['gender']; ?>  </td> 
			<td class="bordering" > <?php echo $val['credit_hour_sum']; ?>  </td> 
  			<td class="bordering" > <?php echo $val['cgpa']; ?>  </td> 
			<td class="bordering" > <?php echo $academicStatus[$val['academic_status_id']]; ?>  </td> 
 			
                    </tr>     
                  <?php 
                   
                 }
                 }
?>
    </table>
<?php 
}
                 ?>
            
          
        
  <?php 
 
}   
?>

