<?php echo $this->Form->create('Staff');?>
<script type='text/javascript'>
//Sub Cat Combo 1
function updateDepartment(id) {
            //serialize form data
            var formData = $("#college_id_"+id).val();
            $("#college_id_"+id).attr('disabled', true);
			$("#department_id_"+id).empty();
			$("#department_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#department_id_"+id).attr('disabled', true);
			$("#staff_id_"+id).empty();
			$("#staff_id_"+id).append('<option style="width:100px">loading...</option>');
			$("#staff_id_"+id).attr('disabled', true);
			//get form action
            var formUrl = '/departments/get_department_combo/'+formData+'/'+1;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: formData,
                success: function(data,textStatus,xhr){
						$("#department_id_"+id).attr('disabled', false);
						 $("#college_id_"+id).attr('disabled', false);
						$("#department_id_"+id).empty();
						$("#department_id_"+id).append(data);
							
				},
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
			});
			
			return false;
}

</script>

<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
             
<p class="smallheading">View  Payment  .</p>
<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Academic Year:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.academic_year', array('id' => 'AcadamicYear', 'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select', 'options' => $acyear_array_data,
			'selected'=>isset($this->request->data['Search']['academic_year']) ? $this->request->data['Search']['academic_year'] :$defaultacademicyear)); ?></td>
			<td style="width:12%">Semester:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.semester', array('id' => 'Semester', 'class' => 'fs14', 'type' => 'select', 'style' => 'width:125px', 'label' => false, 'options' => array('I' => 'I', 'II' => 'II', 'III' => 'III'),'empty'=>'')); ?></td>
			
		</tr>
		

		<tr>
			<td style="width:12%">Program:</td>
			<td style="width:38%"><?php 
			 echo $this->Form->input('Search.program_id',array('id'=>'program_id','label'=>false,
			 'type'=>'select','multiple'=>'checkbox','div'=>false));
			
			 ?>
			</td>
			<td style="width:12%"> Program Type</td>
			<td style="width:38%" id="ProgramTypeCheckBox">
			&nbsp;
			<?php 
			  echo $this->Form->input('Search.program_type_id',array('id'=>'program_type_id','label'=>false,
			 'type'=>'select','multiple'=>'checkbox','div'=>false));
			
			?>		
			</td>
		</tr>

		<tr>
			 <td style="width:12%">Staff Name:</td>
			<td style="width:38%"><?php echo $this->Form->input('Search.name', 
			array('label' => false)); ?></td>
			<td style="width:8%"> Payment Round</td>
			<td style="width:38%" >
			&nbsp;
			<?php 
			  echo $this->Form->input('Search.round',array('id'=>'program_type_id','label'=>false,
			 'type'=>'select','options'=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4'),'div'=>false));
			
			?>		
			</td>
		</tr>

	
	<tr>
		<td colspan="2">
		<?php echo $this->Form->submit(__('View Payments', true), array('name' => 'getReport', 'div' => false,'class'=>'tiny radius button bg-blue')); ?>
		</td>

		<td colspan="2" >
		<?php echo $this->Form->submit(__('Export Report Excel', true), array('name' => 'getReportExcel', 'div' => false,'class'=>'tiny radius button bg-blue','onclick'=>'')); ?>
		</td>

	</tr>

</table>


<?php 
if (isset($instructor_loads) && !empty($instructor_loads)) {

foreach($instructor_loads as $centerDetail=>$statDetail) {
    $center_detail=explode('~',$centerDetail);

?>

    <table border="1">
      <tr>
        <td colspan="17">Arbaminch College of Teachers' Education</td>
      </tr>
      <tr>
        <td colspan="17">Continuing and Distance Education <?php echo $center_detail[0]; ?> Payment of round <?php echo $center_detail[1];?> <?php echo $this->data['Search']['academic_year']; ?> AY Semester <?php  echo $this->data['Search']['semester']; ?>  </td>
      </tr>
      <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="3" style="border: 1px;">Weekly Hours</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2" style="border: 1px;">Partime Payment</td>
          <td colspan="2" style="border: 1px;">Weekly Total Teaching Hour Missed</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
         
      </tr>
     

      <tr>
          <td>S.No</td>
          <td>Position</td>
          <td>Name</td>
          <td>Coordination</td>
          <td>Teaching</td>
          <td>Total</td>
          <td>Hourly Rate</td>
          <td>Total Monthly</td>
          <td>Weekly Total Hour</td>
          <td>Total Payment</td>
          <td>Teaching</td>
          <td>Exam</td>
          <td>Deducated</td>
          <td>Net</td>
          <td>Remark</td>
      </tr>
      <?php 
      $count=1;
      foreach($statDetail as $k=>$st) { 

      	?>
       <tr>
          <td><?php echo $count++;?></td>
          <td><?php echo $st['PositionAssignment'];?></td>
          <td><?php echo $st['full_name'];?></td>
          <td><?php echo $st['coordination'];?></td>
          <td><?php echo $st['teaching'];?></td>
          <td><?php echo $st['teaching']+$st['coordination'];?></td>
          <td><?php echo $st['hourlyRate'];?></td>
          <td><?php echo $st['hourlyRate']*($st['teaching']+$st['coordination'])*4;?></td>
          <td><?php echo $st['teaching'];?></td>
          <td><?php echo $st['teaching']*$st['hourlyRate'];?></td>
          <td> &nbsp;</td>
          <td> &nbsp;</td>
          <td> &nbsp;</td>
          <td><?php echo ($st['teaching']+$st['coordination'])*$st['hourlyRate'] ?></td>
          <td>&nbsp;</td>
      </tr>

      <?php } ?>     

      <tr>
          <th colspan="6">Continuding and Distance Education Coordinator</th>
          <th colspan="6">V/Dean</th>
          <th colspan="3">College Dean</th>
        
      </tr>
    
       <tr>
          <td colspan="6">
              Name:____________________ <br>
              
              Signature:_______________<br>
              Date:____________________
          </td>
           <td colspan="6">
              Name:____________________ <br>
              
              Signature:_______________<br>
              Date:____________________
          </td>
          <td colspan="3">
             Name:____________________ <br>
              
              Signature:_______________<br>
              Date:____________________
          </td>
       
      </tr>
   
    </table>

<?php
 }
 ?>
 


 <?php 
}
?>


	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
