<?php
 echo $this->Form->Create('GraduationWork');
 ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">

<div class="graduationWorks index">
        <table class="fs13 small_padding">	
    
       <tr>
			 <td style="width:13%">Department:</td>
        <?php 
           echo '<td style="width:37%">'.$this->Form->input('Search.department_id',array('empty'=>' ',
        'id'=>'department_id_1','onchange'=>'updateSection(1)','label'=>false,
        'style'=>'width:250px')).'</td>';
       ?> 
        <td style="width:13%">Section:</td>
		<td style="width:37%"><?php 
		           echo $this->Form->input('Search.section_id',array('empty'=>'','id'=>'section_id_1',
		           'label'=>false));
			?>
		</td>
		</tr>
       
		<tr>
			<td style="width:13%">Student Name:</td>
			<td style="width:37%"><?php echo $this->Form->input('Search.name',array('empty'=>' ','label'=>false));?></td>
			<td style="width:13%">&nbsp;</td>

			<td style="width:37%">&nbsp;</td>
           
		</tr>
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Graduation Works'), array('name' => 'viewGraduationWorks', 'div' => false,
		'class'=>'tiny radius button bg-blue')); ?></td>
		</tr>
</table>
<div id="dialog-modal" title="Academic Profile "></div>
<?php if (!empty($graduationWorks)) { ?> 
	<h2><?php echo __('Graduation Works');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('student_id');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('course_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	foreach ($graduationWorks as $graduationWork):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td class='jsView' data-animation="fade" data-reveal-id="myModal" data-reveal-ajax="/students/get_modal_box/<?php echo $graduationWork['Student']['id'];?>">
			
			<?php 
			echo $graduationWork['Student']['full_name'];
			?>
		</td>
		<td><?php echo $graduationWork['GraduationWork']['type']; ?>&nbsp;</td>
		<td><?php echo $graduationWork['GraduationWork']['title']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($graduationWork['Course']['course_title'].''.$graduationWork['Course']['course_code'], array('controller' => 'courses', 'action' => 'view', $graduationWork['Course']['id'])); ?>
		</td>
		<td><?php echo $graduationWork['GraduationWork']['created']; ?>&nbsp;</td>
		<td><?php echo $graduationWork['GraduationWork']['modified']; ?>&nbsp;</td>
		<td class="actions">

			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $graduationWork['GraduationWork']['id']), null, sprintf(__('Are you sure you want to delete  %s?'), $graduationWork['GraduationWork']['title'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<?php } ?>
</div>

<script type='text/javascript'>

function updateSection(id) {
           
            //serialize form data
            var formData = $("#department_id_"+id).val();
			$("#section_id_"+id).attr('disabled', true);
			$("#department_id_"+id).attr('disabled',true);	
					//get form action
			var formUrl = '/sections/get_sections_by_dept/'+formData;
			$.ajax({
				type: 'get',
				url: formUrl,
				data: formData,
				success: function(data,textStatus,xhr){
						$("#section_id_"+id).attr('disabled', false);
					    $("#department_id_"+id).attr('disabled',false);	
						$("#section_id_"+id).empty();
						$("#section_id_"+id).append(data);
						
				},
				error: function(xhr,textStatus,error){
						alert(textStatus);
				}
			});
			return false;
 }
</script>

</div>
</div>
</div>
</div>