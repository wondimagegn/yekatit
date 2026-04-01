<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	<?php echo __('User Account List');?>
	
	</h2>
     </div>
     <div class="box-body">
	

       <div class="row">
	   <div class="large-12 columns">
	  <?php echo $this->Form->create('User', array('action' => 'index'));?>
	   <table style="border:0px !important">
	           <tr>
	               <td class="fs16" >
	                 
	                 Important Note: Clicking on the <strong>Construct Menu</strong> link will run expensive process that will consume extensive system resourse, please click on the <strong>Construct Menu</strong> if and only if there is a change on the user privilage; assignment of new privilage/s to the user or provoked privilage/s from the user.
	               </td>
	           </tr>
</table>
<p class="fs12">Please enter the first one or two letter of staff first, middle or last name.</p>
<table  style="border:0px !important">
	<tr> 
		<td >First Letter of Name:</td>
		<td><?php echo $this->Form->input('User.name',array('label'=>false)); ?></td>
		<td>Role</td>
		<td><?php echo $this->Form->input('User.role_id',array('label'=>false)); ?></td>	
	</tr>
      
	<tr>
	  <td colspan="4" style="border:0px !important" >
		<table style="border:0px !important" >
			<tr>
				<td><?php echo $this->Form->input('Staff.active', array('label' => 'Active Staff', 'type' => 'checkbox', 'checked' => (!isset($this->data['Staff']['active']) || $this->request->data['Staff']['active'] == 1 ? 'checked' : false))); ?></td>
				
				<td><?php echo $this->Form->input('User.active', array('label' => 'Active User Account', 'type' => 'checkbox', 
'checked' => (!isset($this->request->data['User']['active']) || $this->request->data['User']['active'] == 1 ? 'checked' : false))); ?></td>
			</tr>
		</table>
	</td>
	</tr>

	<tr>
		<td colspan="2">
<?php echo $this->Form->Submit('Search',array('div'=>false,'class'=>'tiny radius button bg-blue','name'=>'getUsers')); ?>

</td>	
	</tr>
	</table>
	   </div>

	</div>

	<div class="row">
	   <div class="large-12 columns">
		
		<table class="display" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('username');?></th>
			<th><?php echo $this->Paginator->sort('role_id');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
		</tr>
		</thead>
	<tbody>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $user['User']['full_name']; ?>&nbsp;</td>
		<td><?php echo $user['User']['username']; ?>&nbsp;</td>
		<td><?php echo $user['Role']['name']; ?>
		</td>
		<td><?php echo ($user['User']['active'] == 1 ? 'Yes' : '<span class="rejected">No</span>'); ?>&nbsp;</td>
		<td class="actions">
			<?php	
	       echo $this->Html->link(__(''), array('action' => 'view', $user['User']['id']),array('class'=>'fontello-eye','title'=>'Assign'));  
?>
			
			 <?php echo $this->Html->link(__(''), array('action' => 'edit', $user['User']['id']),
array('class'=>'fontello-pencil','title'=>'Edit')); ?> 
		
			  <?php echo $this->Html->link(__(''), array('action' => 'build_user_menu', $user['User']['id']),array('class'=>'icon icon-clockwise','title'=>'Construct Menu')); ?> 
			 <?php 
			 if ($user['User']['active']==0) {
			
			    echo $this->Html->link(__('Reset Password'), 
			     array('action' => 'resetpassword'),
			     array('onclick'=>'return false','style'=>'color:gray'),
array('class'=>'fontello-unlock','title'=>'Reset Password'));
			 } else {
			     if ($user['User']['role_id'] == ROLE_INSTRUCTOR) {
			        echo $this->Html->link(__(''), 
			     array('action' => 'resetpassword'),
			     array('onclick'=>'return false',
			     'style'=>'color:gray'),
array('class'=>'fontello-unlock','title'=>'Reset Password'));
			     } else {
			        echo $this->Html->link(__('Reset '), 
			     array('action' => 'resetpassword', $user['User']['id']),
array('class'=>'fontello-unlock',
'title'=>'Reset Password'));
			  
			     }
			     //disabled="true"
			     
			 }
			 ?>
			 
			 <?php 
			 if ($role_id ==ROLE_REGISTRAR || 
$role_id == $this->Session->read('Auth.User')['Role']['parent_id']) {
			  
			     if ($user['User']['active']==0) {
			           echo $this->Html->link(__(''), array('action' => 'assign'),array('onclick'=>'return false',
			           'style'=>'color:gray'),
array('class'=>'fontello-user-add-outline','title'=>'Assign')); 
			     } else {
			              echo $this->Html->link(__(''), array('action' => 'assign', $user['User']['id']),array('class'=>'fontello-users','title'=>'Assign')); 
			     
			     }
			    
			 }
			 
			 if ($role_id == ROLE_ACCOMODATION ) {
			    
			  
			     if ($user['User']['active']==0) {
			             echo $this->Html->link(__(''), array('action' => 'assign_user_dorm_block'),array('onclick'=>'return false',
			             'style'=>'color:gray'),
array('class'=>'fontello-users','title'=>'Assign'));
			     } else {
			             echo $this->Html->link(__(''), array('action' => 'assign_user_dorm_block', $user['User']['id']),
array('class'=>'fontello-users','title'=>'Assign'));  
			     }
			 
			 }
			 
			 if ($role_id == ROLE_MEAL ) {
			  
			    
			     if ($user['User']['active']==0) {
			         echo $this->Html->link(__(''), array('action' => 'assign_user_meal_hall'),array('onclick'=>'return false',
			         'style'=>'color:gray'),
array('class'=>'fontello-users','title'=>'Assign')); 
			     } else {
			            echo $this->Html->link(__(''), array('action' => 'assign_user_meal_hall', $user['User']['id']),array('class'=>'fontello-users','title'=>'Assign'));  
			     }
			    
			 }
			 
			  if ($role_id == ROLE_SYSADMIN ) {

            echo $this->Html->link(__(''), array('action' => 'delete', $user['User']['id']),array('class'=>'fontello-trash','title'=>'Delete'));  
			  }
			 
			 ?>
			
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>	
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
	</div>
     </div>
</div>
