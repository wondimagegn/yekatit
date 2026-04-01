<?php ?>
<script type="text/javascript">
var image = new Image();
image.src = '/img/busy.gif';
 //Get year level
function getYearLevel() {
            //serialize form data
            var dept = $("#ajax_department_id").val();
$("#ajax_year_level_id").attr('disabled', true);
$("#ajax_year_level_id").empty().html('<img src="/img/busy.gif" class="displayed" >');
//get form action
            var formUrl = '/section_split_for_exams/get_year_levels_for_view/'+dept;
            $.ajax({
                type: 'get',
                url: formUrl,
                data: dept,
                success: function(data,textStatus,xhr){
$("#ajax_year_level_id").attr('disabled', false);
$("#ajax_year_level_id").empty();
$("#ajax_year_level_id").append(data);
                },
                error: function(xhr,textStatus,error){
                        alert(textStatus);
                }
            });
            return false;
 }

</script>
<div class="sectionSplitForExams index">
<?php echo $this->Form->create('SectionSplitForExam');?>
	<div class="smallheading"><?php __('List of Section Split For Exams');?></div>
	<div class="font"><?php echo 'Colege/Institute: '.$college_name ?></div>
	<div class="font"><?php __('Optional search parameters');?> </div>
<table cellpadding="0" cellspacing="0">
	<?php 
		echo '<tr><td class="font"> Academic Year</td>';
		echo '<td>'.$this->Form->input('academic_year',array('label'=>false,'type'=>'select','options'=>$acyear_array_data,'empty'=>"All", 'style'=>'width:150PX')).'</td>';
        echo '<td class="font"> Semester</td>';
		echo '<td >'.$this->Form->input('semester',array('label'=>false,'options'=>array('I'=>'I','II'=>'II','III'=>'III'), 'empty'=>'All', 'style'=>'width:150PX')).'</td>'; 
		echo '<td class="font"> Program</td>';
        echo '<td>'. $this->Form->input('program_id',array('label' => false,'empty'=>"All", 'style'=>'width:150PX')).'</td></tr>'; 
        echo '<tr><td class="font"> Program Type</td>';
        echo '<td>'. $this->Form->input('program_type_id',array('label' => false,'style'=>'width:150PX','empty'=>"All")).'</td>';
        echo '<td class="font"> Department</td>';
        echo '<td >'. $this->Form->input('department_id',array('label'=>false, 'id'=>'ajax_department_id','onchange'=>'getYearLevel()','empty'=>'All', 'style'=>'width:150PX')).'</td>';  
        echo '<td class="font"> Year Level</td>';
		echo '<td>'. $this->Form->input('year_level_id',array('label' => false,'id'=>'ajax_year_level_id', 'style'=>'width:150PX', 'empty'=>"All")).'</td></tr>';

        echo '<tr><td colspan="6">'.$this->Form->end(__('Search', true)).'</td></tr>'; 
	?> 
</table>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo ('S.N<u>o</u>');?></th>
			<th><?php echo $this->Paginator->sort('published_course_id');?></th>
			<th><?php echo $this->Paginator->sort('section_id');?></th>
			<th><?php echo $this->Paginator->sort('Academic Year');?></th>
			<th><?php echo $this->Paginator->sort('Semester');?></th>
			<th><?php echo $this->Paginator->sort('Program');?></th>
			<th><?php echo $this->Paginator->sort('Program Type');?></th>
			<th><?php echo $this->Paginator->sort('Year Level');?></th>
			<!--- <th><?php echo $this->Paginator->sort('type');?></th> --->
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$count = $this->Paginator->counter('%start%');
	foreach ($sectionSplitForExams as $sectionSplitForExam){
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($sectionSplitForExam['PublishedCourse']['Course']['course_code_title'], array(
			'controller' => 'courses', 'action' => 'view', $sectionSplitForExam['PublishedCourse']['course_id'])); ?>
		</td> 
		<td>
			<?php echo $this->Html->link($sectionSplitForExam['Section']['name'], array('controller' => 'sections', 'action' => 'view', $sectionSplitForExam['Section']['id'])); ?>
		</td>
		<td><?php echo $sectionSplitForExam['PublishedCourse']['academic_year'];?>&nbsp;</td>
		<td><?php echo $sectionSplitForExam['PublishedCourse']['semester']; ?>&nbsp;</td> 
		<td><?php echo $sectionSplitForExam['PublishedCourse']['Program']['name']; ?>&nbsp;</td>
		<td><?php echo $sectionSplitForExam['PublishedCourse']['ProgramType']['name'];?>&nbsp;</td>
		<?php if(isset($sectionSplitForExam['PublishedCourse']['YearLevel']['name'])) {?>
			<td><?php echo $sectionSplitForExam['PublishedCourse']['YearLevel']['name']; ?>&nbsp;</td> 
		<?php } else {?>
			<td><?php echo "Pre"; ?>&nbsp;</td>
		<?php }?>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $sectionSplitForExam['SectionSplitForExam']['id'])); ?>
			<!--- <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $sectionSplitForExam['SectionSplitForExam']['id'])); ?> 
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $sectionSplitForExam['SectionSplitForExam']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sectionSplitForExam['SectionSplitForExam']['id'])); ?> --->
		</td>
	</tr>
	<tr><td colspan="9"><table style="width:20%;"><tr>
		<th><?php echo 'Split into Section Name';?></th></tr>
		<?php 
		foreach ($sectionSplitForExam['ExamSplitSection'] as $examSplitSection){
			echo '<tr><td>'.$examSplitSection['section_name'].'</td></tr>';
		}
		?>
	</table></td></tr>
<?php } ?>
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
</div>
