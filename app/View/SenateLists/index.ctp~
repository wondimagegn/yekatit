<?php echo $this->Form->create('SenateList');?>
<script>
function toggleView(obj) {
	if($('#c'+obj.id).css("display") == 'none')
		$('#i'+obj.id).attr("src", '/img/minus2.gif');
	else
		$('#i'+obj.id).attr("src", '/img/plus2.gif');
	$('#c'+obj.id).toggle("slow");
}
</script>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<div class="senateLists index">
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
		<td><?php echo $this->Form->input('department_id', array('id' => 'ProgramType', 'class' => 'fs13', 'label' => false, 'type' => 'select', 'options' => $departments, 'default' => $default_department_id)); ?></td>
		
		<td>Limit:</td>
		<td>
                   <?php echo $this->Form->input('limit', array('id' => 'Limit', 'class' => 'fs13', 'label' => false)); ?>
                </td>
	</tr>
	<tr>
		<td>Approval From:</td>
		<td><?php 
		echo $this->Form->input('senate_date_from', array('label' => false, 'type' => 'date', 'minYear' => $yFrom, 'maxYear' => $yTo, 'default' => false,'style'=>'width:70px'));
		?></td>
		<td>Approval To:</td>
		<td><?php 
		echo $this->Form->input('senate_date_to', array('label' => false, 'type' => 'date', 
		'minYear' => $yFrom, 'maxYear' => $yTo, 
'default' => false,'style'=>'width:70px'));
		?></td>
	</tr>
	<tr>
		<td>Minute N<u>o</u>:</td>
		<td><?php echo $this->Form->input('minute_number', array('id' => 'MinuteNumber', 'class' => 'fs13', 'label' => false)); ?>

		<td>Exclude Major:</td>
		<td><?php echo $this->Form->input('exclude_major', array('id' => 'exclude_major','type'=>'checkbox', 'class' => 'fs13', 'label' => false)); ?>

	<?php echo $this->Form->hidden('page', array('value'=>1)); ?>
</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Sort By:</td>
		<td><?php  
		 echo $this->Form->input('sort_by',array('options'=>array('full_name ASC'=>'Full name A-Z',
		 'full_name DESC'=>'Full name Z-A',
            'SenateList.created DESC'=>'Recent First',
            'SenateList.created ASC'=>'Recent Last',
            ),'label'=>''
            ));
		 ?>
        </td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6">
		<?php echo $this->Form->submit(__('List Students', true), array('name' => 'listStudentsForSenateList','class'=>'tiny radius button bg-blue', 'div' => false)); ?>
		</td>
	</tr>
</table>

<?php 
debug($this->request->data['SenateList']['exclude_major']);

if(!empty($senateLists)) {
echo $this->Form->submit(__('View PDF', true), array('name' =>'viewPDF','class'=>'tiny radius button bg-blue', 'div' => false)); 
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
			<th style="width:17%"><?php echo $this->Paginator->sort('Student.first_name','Student Name');?></th>
			<th style="width:9%"><?php echo $this->Paginator->sort('student_id','ID');?></th>
			<th style="width:5%"><?php echo $this->Paginator->sort('Student.gender','Sex');?></th>
			<th style="width:17%"><?php echo $this->Paginator->sort('minute_number');?></th>
			<th style="width:14%"><?php echo $this->Paginator->sort('approved_date');?></th>
			<th style="width:9%"><?php echo $this->Paginator->sort('credit_hour_sum','Credit Taken');?></th>
			<th style="width:7%"><?php echo $this->Paginator->sort('cgpa','CGPA');?></th>
			<?php if((strcasecmp($this->request->data['SenateList']['exclude_major'],'0')==0)) { ?>
			<th style="width:7%"><?php echo $this->Paginator->sort('mcgpa','MCGPA');?></th>
			<?php } ?>

			<th class="actions" style="width:10%; text-align:center"><?php __('Action');?></th>
	</tr>
	<?php
	$i = 0;
	$count = 1;
	foreach ($senateLists as $senateList):
		$credit_hour_sum = 0;
	    $st_credit_hour_sum = 0;
		$not_used_gpa_sum=0;
		$dropped_credit_sum=0;
		foreach($senateList['Student']['StudentExamStatus'] as $ses_key => $ses_value) {
			$st_credit_hour_sum += $ses_value['credit_hour_sum'];
		}
		
		foreach($senateList['Student']['CourseDrop'] as $drop_key => $drop_value) {
			  if(isset($drop_value['CourseRegistration']['PublishedCourse']['Course']) && !empty($drop_value['CourseRegistration']['PublishedCourse']['Course'])){
			    if($drop_value['CourseRegistration']['PublishedCourse']['Course']){
			    	if($drop_value['registrar_confirmation']==1 && $drop_value['department_approval']==1){
			    		 $dropped_credit_sum+=$drop_value['CourseRegistration']['PublishedCourse']['Course']['credit'];
			  		
			    	}
			    	
			    }
			  
			  }
		}
		
		foreach($senateList['Student']['CourseAdd'] as $ses_key => $ses_value) {
			if($ses_value['PublishedCourse']['Course']['GradeType']['used_in_gpa']==false){
				$not_used_gpa_sum+= $ses_value['PublishedCourse']['Course']['credit'];
			}
			$credit_hour_sum += $ses_value['PublishedCourse']['Course']['credit'];
		}
		
		
		foreach($senateList['Student']['CourseRegistration'] as $ses_key => $ses_value) {
		  
			if($ses_value['PublishedCourse']['Course']['GradeType']['used_in_gpa']==false){
				$not_used_gpa_sum+= $ses_value['PublishedCourse']['Course']['credit'];
			}
			$credit_hour_sum += $ses_value['PublishedCourse']['Course']['credit'];
		}
		
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		$label='';
		if((($credit_hour_sum-$dropped_credit_sum)!=($st_credit_hour_sum+$not_used_gpa_sum))){
			$label="color:red;";
		} 
	?>
	<tr<?php echo $class ;?> >
		<td style="background-color:white" onclick="toggleView(this)" id="<?php echo $count; ?>"><?php echo $this->Html->image('plus2.gif', array('id' => 'i'.$count, 'div' => false, 'align' => 'left')); ?></td>
		<td style="background-color:white"><?php echo $count; ?></td>
		<td style="background-color:white"><?php 
		/*echo $this->Html->link($senateList['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $senateList['Student']['id']), array('style' => 'font-weight:normal')); 

		*/
		?>
		<?php 
		

echo $this->Html->link(
    $senateList['Student']['full_name'],
    '#',
   array('class'=>'jsview','data-animation'=>"fade",
'data-reveal-id'=>'myModal','data-reveal-ajax'=>"/students/get_modal_box/".$senateList['Student']['id'])
);

			?>
		
		</td>
		<td style="background-color:white"><?php echo $senateList['Student']['studentnumber']; ?></td>
		<td style="background-color:white"><?php echo (strcasecmp($senateList['Student']['gender'], 'male') == 0 ? 'M' : 'F'); ?></td>
		<td style="background-color:white"><?php echo $senateList['SenateList']['minute_number']; ?>&nbsp;</td>
		<td style="background-color:white"><?php echo $this->Format->humanize_date_short_extended($senateList['SenateList']['approved_date']); ?>&nbsp;</td>
		<td style="background-color:white;<?php echo $label ;?>"><?php 
				if(($credit_hour_sum-$dropped_credit_sum)>$senateList['Student']['Curriculum']['minimum_credit_points']){
					echo $senateList['Student']['Curriculum']['minimum_credit_points'];
				} else {
				   echo $credit_hour_sum-$dropped_credit_sum;
				}
		 ?>
		
		&nbsp;</td>
		<td style="background-color:white"><?php echo $senateList['Student']['StudentExamStatus'][0]['cgpa']; ?>&nbsp;</td>
		<?php  if((strcasecmp($this->request->data['SenateList']['exclude_major'],'0')==0)) { ?>
		<td style="background-color:white"><?php echo $senateList['Student']['StudentExamStatus'][0]['mcgpa']; ?>&nbsp;</td>
		<?php } ?>
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
	<strong style="color:red">Red: Requires Status Generation</strong>
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
	 </div> <!-- end of columns 12 -->
	</div> <!-- end of row -->
   </div> <!-- end of box-body -->
</div><!-- end of box -->

<?php $this->Form->end();
?>
