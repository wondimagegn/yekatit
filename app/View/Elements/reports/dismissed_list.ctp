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
if(isset($dismissedList) && !empty($dismissedList)){
  ?>
  <h5><?php echo $headerLabel;?></h5>
  <?php 
  foreach ($dismissedList as $dkey => $dvalue) {
?>
 <h5><?php echo $dkey;?></h5>
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
                    <td class="bordering2"> ID </td> 
                    <td class="bordering2"> Fullname </td> 
                    <td class="bordering2"> Sex </td> 
                    <td class="bordering2"> CGPA </td> 
                    <td class="bordering2"> SGPA </td> 
                    <td class="bordering2"> Program </td> 
                    <td class="bordering2"> ProgramType </td> 
                </tr>      
                <?php 
                $count=0;
                foreach($dvalue as $dk) { 
                  $count++;
                  
                  ?>
                 <tr class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?php echo $dk['id'];?>">
                    <td class="bordering"> <?php echo $count++;?> </td> 
                     <td class="bordering"> <?php 
                     /*
           echo $this->Html->link($dk['studentnumber'],
    '#',
   array('class'=>'jsview','data-animation'=>"fade",
'data-reveal-id'=>'myModal','data-reveal-ajax'=>"/students/get_modal_box/".$dk['id'])
);
*/
echo $dk['studentnumber'];
?> </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dk['first_name'].' '.$dk['middle_name'].' ';
                      
?>
                     </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dk['gender'];
?>
                     </td> 
                     <td class="bordering">
                       
                       <?php 
                       echo $dk['cgpa'];
?>
                     </td> 

                      <td class="bordering">
                       
                       <?php 
                       echo $dk['sgpa'];
?>
                     </td> 
                      <td class="bordering">
                       
                       <?php 
                       echo $dk['program_id'];
?>
                     </td> 

                      <td class="bordering">
                       
                       <?php 
                       echo $dk['program_type_id'];
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