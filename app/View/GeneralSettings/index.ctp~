<div class="box">
     <div class="box-body">
       <div class="row">
	  	<div class="large-12 columns">
	  	  <h2><?php echo __('General Settings'); ?></h2>
	<table class="responsive" >
	<thead>
	<tr>
			
			<th><?php echo $this->Paginator->sort('program_id'); ?></th>
			<th><?php echo $this->Paginator->sort('program_type_id'); ?></th>

 <th><?php echo $this->Paginator->sort('minimumCreditForStatus','Minimum Credit For Status'); ?></th>
			 <th><?php echo $this->Paginator->sort('daysAvaiableForGradeChange','Grade Change'); ?></th>

			<th><?php echo $this->Paginator->sort('daysAvaiableForNgToF','NG To F'); ?></th>
			<th><?php echo $this->Paginator->sort('daysAvaiableForDoToF','Days Do To F'); ?></th>
			<th><?php echo $this->Paginator->sort('daysAvailableForFxToF','Days Fx To F'); ?></th>
		
			<th><?php echo $this->Paginator->sort('allowMealWithoutCostsharing','Allow Meal Without Cost Sharing'); ?></th>
			<th><?php echo $this->Paginator->sort('notifyStudentsGradeByEmail','Notify Students Grade By Email'); ?></th>
			<th><?php echo $this->Paginator->sort('allowStudentsGradeViewWithouInstructorsEvalution','Allow Student Grade View Without Instructors Evaluation'); ?></th>
			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($generalSettings as $generalSetting): ?>
	<tr>
		
		<td>
			<?php 
            foreach ($generalSetting['GeneralSetting']['program_id'] as $key => $value) {
            	echo $value.'<br/>';
            }
		 ?>
		</td>
		<td>
			
			<?php 
            foreach ($generalSetting['GeneralSetting']['program_type_id'] as $key => $value) {
            	echo $value.'<br/>';
            }
		 ?>
		</td>

<td><?php echo h($generalSetting['GeneralSetting']['minimumCreditForStatus']); ?>&nbsp;</td>

		<td><?php echo h($generalSetting['GeneralSetting']['daysAvaiableForGradeChange']); ?>&nbsp;</td>
		<td><?php echo h($generalSetting['GeneralSetting']['daysAvaiableForNgToF']); ?>&nbsp;</td>
		<td><?php echo h($generalSetting['GeneralSetting']['daysAvaiableForDoToF']); ?>&nbsp;</td>
		<td><?php echo h($generalSetting['GeneralSetting']['daysAvailableForFxToF']); ?>&nbsp;</td>
		
		<td><?php echo h($generalSetting['GeneralSetting']['allowMealWithoutCostsharing']==1 ? 'Yes':'No'); ?>&nbsp;</td>
		
		<td><?php echo h($generalSetting['GeneralSetting']['allowStudentsGradeViewWithouInstructorsEvalution']==1 ? 'Yes':'No'); ?>&nbsp;</td>
		<td><?php echo h($generalSetting['GeneralSetting']['allowRegistrationWithoutPayment']==1 ? 'Yes':'No'); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $generalSetting['GeneralSetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $generalSetting['GeneralSetting']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $generalSetting['GeneralSetting']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $generalSetting['GeneralSetting']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
	  	</div>
	  </div>
	 </div>
</div>	
