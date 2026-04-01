<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
              
<div class="gradeScales index">
	<h2><?php echo __('Grade Scales');?></h2>
   
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('grade_type_id');?></th>
		
			<th><?php echo $this->Paginator->sort('program_id');?></th>

    		<!---	<th><?php //echo $this->Paginator->sort('own');?></th> --->
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$start = $this->Paginator->counter('%start%');
	
	foreach ($gradeScales as $gradeScale):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $gradeScale['GradeScale']['name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($gradeScale['GradeScaleDetail'][0]['Grade']['GradeType']['type'], array('controller' => 'grade_types', 'action' => 'view',$gradeScale['GradeScaleDetail'][0]['Grade']['GradeType']['id'])); ?>
		</td>
		
		<td>
			<?php echo $this->Html->link($gradeScale['Program']['name'], array('controller' => 'programs', 'action' => 'view', $gradeScale['Program']['id'])); ?>
		</td>
		<!--- <td><?php //echo (($gradeScale['GradeScale']['own']==1) ? 'Yes' : 'No'); ?>&nbsp;
		
		</td>
		--->
		<td><?php 
		    echo (($gradeScale['GradeScale']['active']==1) ? 'Yes' : 'No'); 
		
		?>&nbsp;
		
		</td>
		<td><?php echo $gradeScale['GradeScale']['created']; ?>&nbsp;</td>
		<td><?php echo $gradeScale['GradeScale']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $gradeScale['GradeScale']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $gradeScale['GradeScale']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', 
			$gradeScale['GradeScale']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), 
			$gradeScale['GradeScale']['id'])); ?>
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
</div>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
