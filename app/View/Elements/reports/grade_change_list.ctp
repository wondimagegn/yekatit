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

if (isset($gradeChangeLists) && !empty($gradeChangeLists)) {
  ?>
 <h5><?php echo $headerLabel;?></h5>
 <table style="width:100%">
                   
                <tr>
                    <td class="bordering2"> S.N<u>o</u> </td> 
		    <td class="bordering2"> &nbsp;&nbsp;&nbsp;</td> 
                    <td class="bordering2"> Instructor </td> 
                    <td class="bordering2"> Student </td> 
                    <td class="bordering2"> Old Grade </td> 
                    <td class="bordering2"> New Grade </td>
                    <td class="bordering2"> Course </td> 
		     <td class="bordering2"> Initiated By </td> 
                   
                </tr>     
               
<?php  
$count=0;  
foreach($gradeChangeLists as $staffName=>$courseList) { 
     foreach($courseList as $ck=>$cd){ 
      ?>
      <tr>
        <td class="bordering"><?php echo ++$count; ?> </td> 
        <td onclick="toggleView(this)" id="<?php echo $count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$count)); ?></td>
        <td class="bordering"><?php echo $staffName; ?>  </td> 
        <td class="bordering"><?php 
	  echo $this->Html->link($cd['full_name'],
    '#',
   array('class'=>'jsview','data-animation'=>"fade",
'data-reveal-id'=>'myModal','data-reveal-ajax'=>"/students/get_modal_box/".$cd['student_id']));
?></td> 
       
         <td class="bordering"><?php echo $cd['oldGrade']; ?></td> 
         <td class="bordering"><?php echo $cd['grade']; ?></td> 
	  <td class="bordering"><?php echo $cd['course']; ?></td> 
	  <td class="bordering"><?php 
            if($cd['manual_ng_conversion'] == 1)
			echo 'Registrar NG Grade Conversion';
	    else if($cd['auto_ng_conversion'] == 1)
		       echo 'Automatic F';
            else if ($cd['initiated_by_department']==1)
			echo "Department";
	    else if ($cd['initiated_by_department']==0)
			echo "Instructor"; 
	

?></td> 
     </tr>
     <tr id="c<?php echo $count; ?>" style="display:none">
         <td colspan="6" style="font-weight:bold; font-size:14px">
		
	    Instructor:<?php echo $staffName; ?> <br/>
	    Student:<?php echo $cd['full_name']; ?> <br/>
	    Grade change from <?php echo $cd['oldGrade']; ?> to <?php echo $cd['grade'].' for '.$cd['course']; ?> <br/>
	   <?php if($cd['initiated_by_department']!=1) { ?>
	    Request initiated by instructor <br/>
	    Department Approved  by <?php echo $cd['department_approved_by'].$cd['department_reason'].' at '.$this->Format->humanize_date($cd['department_approval_date']); ?> <br/>
            College Approved  by <?php echo $cd['college_approved_by'].$cd['college_reason'].' at '.$this->Format->humanize_date($cd['college_approval_date']); ?><br/> 
            Registrar Approved  by <?php echo $cd['registrar_approved_by'].$cd['registrar_reason'].' at '.$this->Format->humanize_date($cd['registrar_approval_date']); ?> <br/>
           <?php } else if ($cd['initiated_by_department']==1) { ?>
             Request initiated by Department <br/>
             College Approved  by <?php echo $cd['college_approved_by'].$cd['college_reason'].' at '.$this->Format->humanize_date($cd['college_approval_date']); ?><br/> 
            Registrar Approved  by <?php echo $cd['registrar_approved_by'].$cd['registrar_reason'].' at '.$this->Format->humanize_date($cd['registrar_approval_date']); ?> <br/>

	  <?php } ?>
           <?php 	   
		if($cd['manual_ng_conversion'] == 1)
			echo 'Registrar NG Grade Conversion';
	        else if($cd['auto_ng_conversion'] == 1)
		     echo 'Automatic F';
			
	   ?>

	</td>
     </tr>
  <?php } ?> 
   
  <?php 
 }
 ?>
 </table>
 <?php 
}   
?>
