<?php 
echo $this->Form->create('ColleagueEvalutionRate');
?>

<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
        <div class="examGrades ">
<div class="smallheading"><?php echo __('Evaluate Colleague');?></div>
<div onclick="toggleViewFullId('ListSection')"><?php 
	if (!empty($colleagueLists)) {
		echo $this->Html->image('plus2.gif', array('id' => 'ListSectionImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt">Display Filter</span><?php
		}
	else {
		echo $this->Html->image('minus2.gif', array('id' => 'ListSectionImg')); 
		?><span style="font-size:10px; vertical-align:top; font-weight:bold" id="ListSectionTxt">Hide Filter</span><?php
		}
?></div>
<div id="ListSection" style="display:<?php echo (!empty($colleagueLists) ? 'none' : 'display'); ?>">
<table cellspacing="0" cellpadding="0" class="fs14">
	<tr>
		<td style="width:20%">Academic Year:</td>
		<td style="width:20%">
          <?php echo $this->Form->input('Search.acadamic_year', array('id' => 'AcadamicYear', 
		'label' => false, 'class' => 'fs14', 'style' => 'width:125px', 'type' => 'select',
		 'options' => $acyear_array_data, 
		 'default' => (isset($academic_year_selected) ? $academic_year_selected : $this->request->data['Search']['acadamic_year']))); ?>

		</td>
		
		
		
		<td style="width:20%">Semester:</td>
		<td style="width:20%">
		  <?php 
		  echo $this->Form->input('Search.semester',
array('options'=>array('I'=>'I','II'=>'II',
            'III'=>'III')));
            ?>
		 
		</td>
	
	</tr>

	<tr>
		<td style="width:20%">Name:</td>
		<td style="width:20%">
		   <?php echo $this->Form->input('Search.name', array(
		'label' => false)); ?>
		</td>
	</tr>

	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('Get Colleague'), array('name' => 'getInstructorList','class'=>'tiny radius button bg-blue','div' => false)); ?>
		</td>
	</tr>
</table>
</div>
<?php
if(!empty($colleagueLists)) {
?>
<table class="fs14">
	<tr>
		<td style="width:15%">Instructor</td>
		<td colspan="3" style="width:85%">
<?php
	echo $this->Form->input('Search.staff_id', array('class' => 'fs14','id' => 'Staff', 
	'label' => false, 'type' => 'select', 'options' => $colleagueLists, 
	'default' => (isset($staff_id) ? $staff_id : $this->request->data['Search']['staff_id'])));
?>
		</td>
	</tr>
</table>
<?php
}
if(isset($instructorEvalutionQuestionsObjective) && !empty($instructorEvalutionQuestionsObjective) && !empty($colleagueLists)) {
	?>
	<div class='fs16'>
               <p class="fs16">
              Listed below are statements, which describe aspects of your worker’s behavior. Please rate him/her on each of these items by circling the appropriate coded response category.  Your ratings should be based on a comparison between the particular individual and the other members of the department. If you feel that you cannot rate him on a particular item or that the item is not applicable to his work, then mark the response category NA.
               </p>
		     
		       
		     
    </div>

    <table style="width:100%">
	  
			    <tr>
					<th width="5%" class="bordering2">S.N<u>o</u>
					</th>
					<th width="30%" class="bordering2">Question</th>
					<th width="40%" class="bordering2">Response</th>

				</tr>
				
				<?php 
				  $count=1;
				  $options=array(5=>'Very good',4=>'Good',
				  	3=>'Fair',2=>'Poor',1=>'Very Poor',0=>'Do not know');
				  $attributes=array(
                      'label'=>false,
                      'div'=>false,
                      'legend'=>false,
                      'separator'=>' ',
                      'required'=>true
                      //'hiddenField'=>false

				  );
				  foreach ($instructorEvalutionQuestionsObjective as $kc=>$vc) {
                        echo "<tr>";
                        echo "<td> $count ".$this->Form->hidden('ColleagueEvalutionRate.'.$count.'.instructor_evalution_question_id',array('label'=>false,'size'=>4,'div'=>false,'value'=>$vc['InstructorEvalutionQuestion']['id']))."</td>";
                         echo "<td>".$vc['InstructorEvalutionQuestion']['question'].'/'.$vc['InstructorEvalutionQuestion']['question_amharic']."</td>";
                      
                         echo "<td>".$this->Form->radio('ColleagueEvalutionRate.'.$count.'.rating',$options,$attributes)."</td>";
                       
                        echo "</tr>";
                        $count++;

                    }

                  ?>
                 <tr>
                 	<td colspan="4">
                 		<?php echo $this->Form->submit(__('Submit Evalution'), array('name' => 'submitEvaluationResult', 
	'div' => false,'class'=>'tiny radius button bg-blue')); ?>
                 	</td>

                 </tr>
			</table>
	
	
	<?php
	
}
?>
<?php echo $this->Form->end(); ?>
</div>
		</div>
       </div>
     </div>
</div>

<script>
$(document).ready(function () {
	$("#Staff").change(function(){
		
	    var s_id = $("#Staff").val();
		window.location.replace("/ColleagueEvalutionRates/<?php echo $this->request->action; ?>/"+s_id);
	    
	});
});

function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}

function toggleViewFullId(id) {
	if($('#'+id).css("display") == 'none') {
		$('#'+id+'Img').attr("src", '/img/minus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Hide Filter');
		}
	else {
		$('#'+id+'Img').attr("src", '/img/plus2.gif');
		$('#'+id+'Txt').empty();
		$('#'+id+'Txt').append('Display Filter');
		}
	$('#'+id).toggle("slow");
}
</script>
