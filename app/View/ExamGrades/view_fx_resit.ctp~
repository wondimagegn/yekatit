<?php echo $this->Form->create('ExamGrade',array('novalidate' => true));?>
<div class="box">
   <div class="box-body">
     <div class="row">
	  <div class="large-12 columns">
	  	<h3>Fx Exam Retake Application</h3>
         <p class="fs13">To view FX exam retake application,please select academic year and semester for which you want to view Fx retake.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Academic Year:</td>
			<td style="width:20%"><?php echo $this->Form->input('academic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data, 'default' => (isset($defaultacademicyear) ? $defaultacademicyear : $defaultacademicyear))); ?></td>
			
			<td style="width:8%">Semester:</td>
			<td style="width:25%"><?php echo $this->Form->input('semester', array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'), 'default' => (isset($semester_selected) ? $semester_selected : false))); ?></td>
			<td style="width:35%"><?php echo $this->Form->submit(__('View Fx Application'), array('name' => 'viewFxApplication','class'=>'tiny radius button bg-blue','div' => false)); ?></td>
		</tr>
	</table>
	<?php if(isset($fxRequests) && !empty($fxRequests)) ?>
         
         <table>
  
	       <tr> 
            <th><?php echo ('No.'); ?> </th>
            <th><?php echo ('Name');?></th>
            <th><?php echo ('ID');?></th>
		    <th><?php echo ('Course Name');?></th>
            <th><?php echo ('Academic Year');?></th>
			<th><?php echo ('Semester');?></th>	
			
		</tr>
		
	<?php 
    $count=1;
	foreach ($fxRequests as $kf=> $fxx) {
	 
		foreach($fxx['FxResitRequest'] as 
		$kkk=> $fx){
		
		
?>
	  <tr>         
		<td><?php echo $count;?></td>
      
        <td><?php echo $fx['Student']['full_name']; ?>&nbsp;</td>
        <td><?php echo $fx['Student']['studentnumber']; ?>&nbsp;</td>
        <td><?php echo $fxx['Course']['course_title']; ?>&nbsp;</td>
         <td><?php echo $fxx['PublishedCourse']['academic_year']; ?>&nbsp;</td>
          <td><?php echo $fxx['PublishedCourse']['semester']; ?>&nbsp;</td>
         
       </tr> 
	<?php 
			$count++;
		}	
	} ?>
    
</table>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
<?php echo $this->Form->end(); ?>
