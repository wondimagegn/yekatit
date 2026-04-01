<?php 
?>
<script>
function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}
</script>
<script type='text/javascript'>
var image = new Image();
image.src = '/img/busy.gif';

$(document).ready(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$("#dialog-modal").dialog({
			heght: 500,
			width:700,
			autoOpen: false,
			closeOnEscape: true,
			modal: true

	});

	$(".jsview").click(function() {
				$('#dialog-modal').empty().html('<img src="'+image.src+'" class="displayed" />');
				$("#dialog-modal").dialog("open");

				return false;
	});		

});
</script>
<div class="graduateLists index">
<?php //echo $this->Form->create('GraduateList');?>
<?php echo $this->Form->Create('GraduateList',array('action'=>'search')); ?>
<div class="smallheading"><?php __('Graduate List View'); ?></div>
<?php
$yFrom = Configure::read('Calendar.graduateListStartYear');
$yTo = date('Y');
?>
<div id="dialog-modal" title="Academic Profile "></div>
<table cellspacing="0" cellpadding="0" class="fs13">
	<tr>
		<td style="width:11%">Program:</td>
		<td style="width:25%"><?php echo $this->Form->input('program_id', array('id' => 'Program', 'class' => 'fs13', 'label' => false, 'type' => 'select', 'options' => $programs, 'default' => $default_program_id)); ?></td>
		<td style="width:11%">Program Type:</td>
		<td style="width:53%"><?php echo $this->Form->input('program_type_id', array('id' => 'ProgramType', 'class' => 'fs13', 'label' => false, 'type' => 'select', 'options' => $program_types, 'default' => $default_program_type_id)); ?></td>
	</tr>
	<tr>
		<td>Department:</td>
		<td colspan="3"><?php echo $this->Form->input('department_id', array('id' => 'ProgramType', 'class' => 'fs13', 'label' => false, 'type' => 'select', 'options' => $departments, 'default' => $default_department_id)); ?></td>
	</tr>
	<tr>
		<td>Graduate From:</td>
		<td><?php 
		echo $this->Form->input('graduate_date_from', array('label' => false, 'type' => 'date',
		 'minYear' => $yFrom, 'maxYear' => $yTo-1, 'default' => false));
		?></td>
		<td>Graduate To:</td>
		<td><?php 
		/*
		echo $this->Form->input('graduate_date_to', array('label' => false, 'type' => 'date', 
		'minYear' => $yFrom, 'maxYear' => $yTo, 'default' => false));
		*/
		
		echo $this->Form->input('graduate_date_to', array('label' => false, 'type' => 'date', 
		'minYear' => $yFrom, 'maxYear' => $yTo));
		
		?></td>
	</tr>
	<tr>
		<td>Minute N<u>o</u>:</td>
		<td><?php echo $this->Form->input('minute_number', array('id' => 'MinuteNumber', 'class' => 'fs13', 'label' => false)); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('List Students', true), array('name' => 'listStudentsForGraduateList', 'div' => false)); ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();
if(!empty($graduateLists)) {
?>
<style>
table.summery tr td{
background-color:#f0f0f0;
padding:2px;
}
table.student_list tr td{
padding:2px;
}
</style>
	<table cellpadding="0" cellspacing="0" class="student_list">
	<tr>
			<th style="width:3%"></th>
			<th style="width:2%">N<u>o</u></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('Student Name', 'Student.first_name');?></th>
			<th style="width:9%"><?php echo $this->Paginator->sort('ID', 'student_id');?></th>
			<th style="width:5%"><?php echo $this->Paginator->sort('Sex', 'Student.gender');?></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('minute_number');?></th>
			<th style="width:14%"><?php echo $this->Paginator->sort('graduate_date');?></th>
			<th style="width:9%"><?php echo $this->Paginator->sort('Credit Taken', 'credit_hour_sum');?></th>
			<th style="width:7%"><?php echo $this->Paginator->sort('CGPA', 'cgpa');?></th>
			<th style="width:7%"><?php echo $this->Paginator->sort('MCGPA', 'mcgpa');?></th>
			<th class="actions" style="width:10%; text-align:center"><?php __('Action');?></th>
	</tr>
	<?php
	$i = 0;
	$count = 1;
	foreach ($graduateLists as $graduateList):
		$valid_deletion_time = 
		date('Y-m-d H:i:s', mktime(substr($graduateList['GraduateList']['created'],11 ,2), 
		substr($graduateList['GraduateList']['created'],14 ,2), 
		substr($graduateList['GraduateList']['created'],17 ,2), 
		substr($graduateList['GraduateList']['created'],5 ,2), 
		substr($graduateList['GraduateList']['created'],8 ,2) + Configure::read('Calendar.daysAvaiableForGraduateDeletion'), 
		substr($graduateList['GraduateList']['created'],0 ,4)));
		
		$credit_hour_sum = 0;
		foreach($graduateList['Student']['StudentExamStatus'] as $ses_key => $ses_value) {
			$credit_hour_sum += $ses_value['credit_hour_sum'];
		}
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style="background-color:white" onclick="toggleView(this)" id="<?php echo $count; ?>"><?php echo $html->image('plus2.gif', array('id' => 'i'.$count, 'div' => false, 'align' => 'left')); ?></td>
		<td style="background-color:white"><?php echo $count; ?></td>
		<td style="background-color:white">
		
		<?php /*echo $this->Html->link($graduateList['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $graduateList['Student']['id']), array('style' => 'font-weight:normal'));
		*/ ?>
	
		    	<?php 
			echo $this->Js->link($graduateList['Student']['full_name'],array('controller'=>'students','action'=>'get_modal_box',$graduateList['Student']['id']),array('class'=>'jsview','style' => 'font-weight:normal','update'=>'#dialog-modal'));
			?>
	
		</td>
		<td style="background-color:white"><?php echo $graduateList['Student']['studentnumber']; ?></td>
		<td style="background-color:white"><?php echo (strcasecmp($graduateList['Student']['gender'], 'male') == 0 ? 'M' : 'F'); ?></td>
		<td style="background-color:white"><?php echo $graduateList['GraduateList']['minute_number']; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $this->Format->humanize_date_short_extended($graduateList['GraduateList']['graduate_date']); ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $credit_hour_sum; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $graduateList['Student']['StudentExamStatus'][0]['cgpa']; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $graduateList['Student']['StudentExamStatus'][0]['mcgpa']; ?>&nbsp;</td>
		<td class="actions" style="background-color:white">
			<?php 
			if($valid_deletion_time > date('Y-m-d')) {
				echo $this->Html->link(__('Delete', true), array('action' => 'delete', $graduateList['GraduateList']['id']), null, sprintf(__('Are you sure you want to delete \'%s\' from the graduate list?', true	), $graduateList['Student']['full_name']));
			}
			else {
				echo '--';
			}
			?>
		</td>
	</tr>
	<tr id="c<?php echo $count++; ?>" style="display:none">
		<td colspan="11" style="background-color:#f0f0f0">
			<table class='summery'>
				<tr>
					<td style="width:17%">Department:</td>
					<td style="width:83%; font-weight:bold"><?php echo $graduateList['Student']['Department']['name']; ?></td>
				</tr>
				<tr>
					<td>Program:</td>
					<td style="font-weight:bold"><?php echo $graduateList['Student']['Program']['name']; ?></td>
				</tr>
				<tr>
					<td>Base Program Type:</td>
					<td style="font-weight:bold"><?php echo $graduateList['Student']['ProgramType']['name']; ?></td>
				</tr>
				<tr>
					<td>Curriculum:</td>
					<td style="font-weight:bold"><?php echo $graduateList['Student']['Curriculum']['name']; ?></td>
				</tr>
				<tr>
					<td>Degree Designation:</td>
					<td style="font-weight:bold"><?php echo $graduateList['Student']['Curriculum']['english_degree_nomenclature']; ?></td>
				</tr>
				<?php
				if(!empty($graduateList['Student']['Curriculum']['specialization_english_degree_nomenclature'])) {
				?>
				<tr>
					<td>Specialization:</td>
					<td style="font-weight:bold"><?php echo $graduateList['Student']['Curriculum']['specialization_english_degree_nomenclature']; ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td>Degree Designation (Amharic):</td>
					<td class="bold"><?php echo $graduateList['Student']['Curriculum']['amharic_degree_nomenclature']; ?></td>
				</tr>
				<?php
				if(!empty($graduateList['Student']['Curriculum']['specialization_amharic_degree_nomenclature'])) {
				?>
				<tr>
					<td>Specialization (Amharic):</td>
					<td><?php echo $graduateList['Student']['Curriculum']['specialization_amharic_degree_nomenclature']; ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td>Required Credit for Graduation:</td>
					<td style="font-weight:bold"><?php echo $graduateList['Student']['Curriculum']['minimum_credit_points']; ?></td>
				</tr>
			</table>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<?php
}
?>
</div>
