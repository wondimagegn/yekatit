<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php 
echo $this->Form->create('DepartmentTransfer');
if ($role_id != ROLE_STUDENT ) {
?>
<p class="smallheading">View Department Transfers.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">From:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.transfer_request_date_from',
			array('label'=>false,'type'=>'date','style'=>'width:80px')); ?></td>
			<td style="width:8%">To:</td>
			<td style="width:25%"><?php echo $this->Form->input('Search.transfer_request_date_to',
			array('label'=>false,'type'=>'date','style'=>'width:80px')); ?></td>
			
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
			echo $this->Form->input('Search.rejected', array('type' => 'checkbox', 'label' => 'Rejected', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['rejected'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.accepted', array('type' => 'checkbox', 'label' => 'Accepted', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['accepted'] == 1 ? 'checked' : false))).'<br/>';
		    
		    echo $this->Form->input('Search.notprocessed', array('type' => 'checkbox', 'label' => 'Not Processed', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['notprocessed'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr>
		
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Department Transfer'), array('name' => 'viewTransferApplication','class'=>'tiny radius button bg-blue', 'div' => false)); ?></td>
		</tr>
</table>
<?php 
}
?>
<?php
    if (!empty($departmentTransfers)) {
 ?>
<div class="departmentTransfers index">
	<div class="smallheading"><?php echo __('Department Transfers Request.');?></div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			<th><?php echo $this->Paginator->sort('department_id','Transfer To Department');?></th>
			<th><?php echo $this->Paginator->sort('student_id','Full Name');?></th>
			
			<th><?php echo $this->Paginator->sort('transfer_request_date','Request Date');?></th>
			<th><?php echo $this->Paginator->sort('sender_department_approval','Sender Department Approval');?></th>
			<th><?php echo $this->Paginator->sort('sender_college_approval','Sender College Approval');?></th>
			<th><?php echo $this->Paginator->sort('sender_college_approval_date','Sender College Approval Date');?></th>
			
			<th><?php echo $this->Paginator->sort('receiver_department_approval','Receiver Department Approval');?></th>
			
			
			
			<th><?php echo $this->Paginator->sort('receiver_department_approval_date','Receiver Department Date');?></th>
			
			<th><?php echo $this->Paginator->sort('receiver_college_approval','Receiver College Approval');?></th>
			<th><?php echo $this->Paginator->sort('receiver_college_approval_date','Receiver College Approval Date');?></th>
			<?php if ($role_id == ROLE_STUDENT) { ?>
			<th class="actions"><?php echo __('Actions');?></th>
			
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
		    if ($departmentTransfer['DepartmentTransfer']['sender_department_approval']==1) {
		        echo 'Accepted';
		        
		    } else if ($departmentTransfer['DepartmentTransfer']['sender_department_approval']==-1) {
		        echo 'Rejected';
		    } else {
		        echo 'Waiting Decision';
		    }
		     
		    
		    ?>
		    &nbsp;</td>
		    
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
		
			<?php echo $this->Html->link(__('Cancel Request'), array(
			'action' => 'delete', $departmentTransfer['DepartmentTransfer']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $departmentTransfer['Department']['name'])); ?>
		</td>
		
		<?php } ?>
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
<?php 
}
?>
	  </div> <!-- end of columns 12 -->
	</div> <!-- end of row --->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
