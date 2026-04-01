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
tr:hover {
    background-color: #ccc;
    cursor: pointer;

}
</style>
<?php 
if(isset($studentList) && !empty($studentList)){
  ?>
  <h5><?php echo $headerLabel;?></h5>
  <?php 

  foreach ($studentList as $gkey => $gvalue) {
     $listgEx=explode('~', $gkey);
    
    echo '<p class="fs16">';
    echo "<strong>Program: </strong>".$listgEx[0]."<br/>";
    echo "<strong>ProgramType: </strong>".$listgEx[1]."<br/>";
    echo "<strong>Section:</strong>".$listgEx[2]."<br/>";
    echo "<strong>Course:</strong>".$listgEx[3]."<br/>";
    echo '</p>';
  ?>
         
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> ID </td> 
                    <td class="bordering2"> Fullname </td> 
                   
                    <td class="bordering2"> Gender </td> 
                   
                </tr>      
      <?php 
      $count=0;
     foreach($gvalue['studentList'] as $dkey=>$dvalue ){
      $count++;
?>

                 <tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?php echo $dvalue['id'];?>">
                    <td class="bordering"> <?php echo $count;?> </td> 
                     <td class="bordering"> <?php 
                    
echo $dvalue['studentnumber'];
?> </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dvalue['first_name'].' '.$dvalue['middle_name'].' '.$dvalue['last_name'];
                      
?>
                     </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo ucwords($dvalue['gender']);
?>
                     </td> 
            </tr>    
      <?php } ?>    
  </table>
<?php 
  }
?>
<?php 
}
?>