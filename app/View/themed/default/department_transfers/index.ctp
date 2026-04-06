<?php 
echo $this->Form->create('DepartmentTransfer');
if ($role_id != ROLE_STUDENT ) {
?>
<p class="smallheading">View Department Transfers.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">From:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.transfer_request_date_from',
			array('label'=>false,'type'=>'date')); ?></td>
			<td style="width:8%">To:</td>
			<td style="width:25%"><?php echo $this->Form->input('Search.transfer_request_date_to',
			array('label'=>false,'type'=>'date')); ?></td>
			
		</tr>
		<tr>
			<td style="width:12%">Department:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.department_id', 
			array('label' => false, 'class' => 'fs14',
			'options'=>$departments)); ?></td>
			<td style="width:8%">&nbsp;</td>
			<td style="width:25%">&nbsp;</td>
			
		</tr>
		
		<tr>
		  	<td> Type:</td>
			<td><?php 
			echo $this->Form->input('Search.rejected', array('type' => 'checkbox', 'label' => 'Rejected', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['rejected'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.accepted', array('type' => 'checkbox', 'label' => 'Accepted', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['accepted'] == 1 ? 'checked' : false))).'<br/>';
		    
		    echo $this->Form->input('Search.notprocessed', array('type' => 'checkbox', 'label' => 'Not Processed', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['notprocessed'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr>
		
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Department Transfer', true), array('name' => 'viewTransferApplication', 'div' => false)); ?></td>
		</tr>
</table>
<?php 
}
?>
<?php
    if (!empty($departmentTransfers)) {
 ?>
<div class="departmentTransfers index">
	<div class="smallheading"><?php __('Department Transfers Request.');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('Transfer To Department','department_id');?></th>
			<th><?php echo $this->Paginator->sort('Full Name','student_id');?></th>
			
			<th><?php echo $this->Paginator->sort('Request Date','transfer_request_date');?></th>
			<th><?php echo $this->Paginator->sort('Receiver Department Approval','receiver_department_approval');?></th>
			<th><?php echo $this->Paginator->sort('Receiver Department Date','receiver_department_approval_date');?></th>
			
			<th><?php echo $this->Paginator->sort('Sender College Approval','sender_college_approval');?></th>
			<th><?php echo $this->Paginator->sort('Sender College Approval Date','sender_college_approval_date');?></th>
			<th><?php echo $this->Paginator->sort('receiver_college_approval');?></th>
			<th><?php echo $this->Paginator->sort('receiver_college_approval_date');?></th>
			<?php if ($role_id == ROLE_STUDENT) { ?>
			<th class="actions"><?php __('Actions');?></th>
			
			<?php } ?>
	</tr>
	<?php
	$i = 0;
	$count=1;
	foreach ($departmentTransfers as $departmentTransfer):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $count++; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($departmentTransfer['Department']['name'], array('controller' => 'departments', 'action' => 'view', $departmentTransfer['Department']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($departmentTransfer['Student']['full_name'], array('controller' => 'students', 'action' => 'view', $departmentTransfer['Student']['id'])); ?>
		</td>
		
		<td><?php echo $departmentTransfer['DepartmentTransfer']['transfer_request_date']; ?>&nbsp;</td>
		<td><?php 
		    if ($departmentTransfer['DepartmentTransfer']['receiver_department_approval']==1) {
		        echo 'Accepted';
		        
		    } else if ($departmentTransfer['DepartmentTransfer']['receiver_department_approval']==-1) {
		        echo 'Rejected';
		    } else {
		        echo 'Waiting Decision';
		    }
		     
		    
		    ?>
		    &nbsp;</td>
		<td><?php echo $departmentTransfer['DepartmentTransfer']['receiver_department_approval_date']; ?>&nbsp;</td>
		
		<td><?php 
		      if ($departmentTransfer['DepartmentTransfer']['sender_college_approval']==1) {
		        
		        echo 'Accepted';
		      } else if ($departmentTransfer['DepartmentTransfer']['sender_college_approval']==-1) {
		        echo 'Rejected';
		      } else {
		        echo 'Waiting Decision';
		      }    
		      
		    
		    ?>&nbsp;</td>
		<td><?php echo $departmentTransfer['DepartmentTransfer']['sender_college_approval_date']; ?>&nbsp;</td>
		<td><?php
		      if ($departmentTransfer['DepartmentTransfer']['receiver_college_approval']==1) {
		        
		        echo 'Accepted';
		      } else if ($departmentTransfer['DepartmentTransfer']['receiver_college_approval']==-1) {
		        echo 'Rejected';
		      } else {
		        echo 'Waiting Decision';
		      }  
		
		 ?>&nbsp;</td>
		<td><?php echo $departmentTransfer['DepartmentTransfer']['receiver_college_approval_date']; ?>&nbsp;</td>
		<?php 
		    if ($role_id == ROLE_STUDENT) {
		?>
		<td class="actions">
		
			<?php echo $this->Html->link(__('Cancel Request', true), array(
			'action' => 'delete', $departmentTransfer['DepartmentTransfer']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $departmentTransfer['Department']['name'])); ?>
		</td>
		
		<?php } ?>
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
</div>
<?php 
}
?>
