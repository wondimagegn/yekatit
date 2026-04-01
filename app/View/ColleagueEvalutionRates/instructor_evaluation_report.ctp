<?php 
echo $this->Form->create('ColleagueEvalutionRate');
?>

<div class="box">
     <div class="box-body">
       <div class="row">
		<div class="large-12 columns">
        <div class="examGrades ">
<div class="smallheading"><?php echo __(' Colleague Report ');?></div>
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
            'III'=>'III'),'label'=>false));
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
/*
	echo $this->Form->input('Search.staff_id', array('class' => 'fs14','id' => 'Staff', 
	'label' => false, 'type' => 'select', 'options' => $colleagueLists, 
	'default' => (isset($staff_id) ? $staff_id : $this->request->data['Search']['staff_id'])));
	*/
?>
		</td>
	</tr>
	<?php if(isset($colleagueLists) && !empty($colleagueLists)) { ?>

	<?php } ?>
	<?php if(isset($colleagueLists) && !empty($colleagueLists)) { ?>
	<tr>
			<th style="width:10%"><?php echo $this->Form->input('select_all', array('type' => 'checkbox', 'id' => 'select-all', 'div' => false, 'label' => false)); ?>Select All</th>
			<th style="width:25%"> Name</th>
			
		</tr>
		<?php } ?>

	<?php

		$st_count = 0;
		foreach($colleagueLists as $skey => $staff) {
			$st_count++;
			?>
			<tr>
				<td><?php 
					echo $this->Form->input('Staff.'.$st_count.'.gp', array('type' => 'checkbox','class'=>'checkbox1' ,'label' => false, 'id' => 'StaffEvaluation'.$st_count));
					echo $this->Form->input('Staff.'.$st_count.'.id', array('type' => 'hidden', 'value' => $skey));
				?></td>
				<td><?php echo $staff; ?></td>
				
			</tr>
			<?php
		}
		?>
	<tr>
		

		<td colspan="4" style="width:85%">
<?php
	echo $this->Form->submit(__('Generate Evaluation PDF'), array('name' => 'generateEvaluationReport', 
	'div' => false,'class'=>'tiny radius button bg-blue'));
?>
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
