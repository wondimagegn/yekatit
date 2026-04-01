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
<div class="senateLists index">
<?php //echo $this->Form->create('SenateList');?>
<?php echo $this->Form->Create('SenateList',array('action'=>'search')); ?>
<div class="smallheading"><?php __('Senate List View'); ?></div>
<?php
$yFrom = Configure::read('Calendar.senateListStartYear');
$yTo = date('Y');
?>
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
		<td>Approval From:</td>
		<td><?php 
		echo $this->Form->input('senate_date_from', array('label' => false, 'type' => 'date', 'minYear' => $yFrom, 'maxYear' => $yTo, 'default' => false));
		?></td>
		<td>Approval To:</td>
		<td><?php 
		echo $this->Form->input('senate_date_to', array('label' => false, 'type' => 'date', 
		'minYear' => $yFrom, 'maxYear' => $yTo, 'default' => false));
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
		<?php echo $this->Form->submit(__('List Students', true), array('name' => 'listStudentsForSenateList', 'div' => false)); ?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();
if(!empty($senateLists)) {
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
<div id="dialog-modal" title="Academic Profile "></div>
	<table cellpadding="0" cellspacing="0" class="student_list">
	<tr>
			<th style="width:3%"></th>
			<th style="width:2%">N<u>o</u></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('Student Name', 'Student.first_name');?></th>
			<th style="width:9%"><?php echo $this->Paginator->sort('ID', 'student_id');?></th>
			<th style="width:5%"><?php echo $this->Paginator->sort('Sex', 'Student.gender');?></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('minute_number');?></th>
			<th style="width:14%"><?php echo $this->Paginator->sort('approved_date');?></th>
			<th style="width:9%"><?php echo $this->Paginator->sort('Credit Taken', 'credit_hour_sum');?></th>
			<th style="width:7%"><?php echo $this->Paginator->sort('CGPA', 'cgpa');?></th>
			<th style="width:7%"><?php echo $this->Paginator->sort('MCGPA', 'mcgpa');?></th>
			<th class="actions" style="width:10%; text-align:center"><?php __('Action');?></th>
	</tr>
	<?php
	$i = 0;
	$count = 1;
	foreach ($senateLists as $senateList):
		$credit_hour_sum = 0;
		foreach($senateList['Student']['StudentExamStatus'] as $ses_key => $ses_value) {
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
		<td style="background-color:white"><?php 
		/*echo $this->Html->link($senateList['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $senateList['Student']['id']), array('style' => 'font-weight:normal')); 
		*/
		?>
		<?php 
			echo $this->Js->link($senateList['Student']['full_name'],array('controller'=>'students','action'=>'get_modal_box',$senateList['Student']['id']),array('class'=>'jsview','update'=>'#dialog-modal'));
			?>
		
		</td>
		<td style="background-color:white"><?php echo $senateList['Student']['studentnumber']; ?></td>
		<td style="background-color:white"><?php echo (strcasecmp($senateList['Student']['gender'], 'male') == 0 ? 'M' : 'F'); ?></td>
		<td style="background-color:white"><?php echo $senateList['SenateList']['minute_number']; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $this->Format->humanize_date_short_extended($senateList['SenateList']['approved_date']); ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $credit_hour_sum; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $senateList['Student']['StudentExamStatus'][0]['cgpa']; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $senateList['Student']['StudentExamStatus'][0]['mcgpa']; ?>&nbsp;</td>
		<td class="actions" style="background-color:white">
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $senateList['SenateList']['id']), null, sprintf(__('Are you sure you want to delete \'%s\' from the senate list?', true	), $senateList['Student']['full_name'])); ?>
		</td>
	</tr>
	<tr id="c<?php echo $count++; ?>" style="display:none">
		<td colspan="11" style="background-color:#f0f0f0">
			<table class='summery'>
				<tr>
					<td style="width:17%">Department:</td>
					<td style="width:83%; font-weight:bold"><?php echo $senateList['Student']['Department']['name']; ?></td>
				</tr>
				<tr>
					<td>Program:</td>
					<td style="font-weight:bold"><?php echo $senateList['Student']['Program']['name']; ?></td>
				</tr>
				<tr>
					<td>Base Program Type:</td>
					<td style="font-weight:bold"><?php echo $senateList['Student']['ProgramType']['name']; ?></td>
				</tr>
				<tr>
					<td>Curriculum:</td>
					<td style="font-weight:bold"><?php echo $senateList['Student']['Curriculum']['name']; ?></td>
				</tr>
				<tr>
					<td>Degree Designation:</td>
					<td style="font-weight:bold"><?php echo $senateList['Student']['Curriculum']['english_degree_nomenclature']; ?></td>
				</tr>
				<?php
				if(!empty($senateList['Student']['Curriculum']['specialization_english_degree_nomenclature'])) {
				?>
				<tr>
					<td>Specialization:</td>
					<td style="font-weight:bold"><?php echo $senateList['Student']['Curriculum']['specialization_english_degree_nomenclature']; ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td>Degree Designation (Amharic):</td>
					<td class="bold"><?php echo $senateList['Student']['Curriculum']['amharic_degree_nomenclature']; ?></td>
				</tr>
				<?php
				if(!empty($senateList['Student']['Curriculum']['specialization_amharic_degree_nomenclature'])) {
				?>
				<tr>
					<td>Specialization (Amharic):</td>
					<td><?php echo $senateList['Student']['Curriculum']['specialization_amharic_degree_nomenclature']; ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td>Required Credit for Graduation:</td>
					<td style="font-weight:bold"><?php echo $senateList['Student']['Curriculum']['minimum_credit_points']; ?></td>
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
