<?php echo $this->Form->create('User', array('action' => 'index'));?>
<div class="users index">
	<div class="smallheading"><?php __('User Account List');?></div>

 <table>
	           <tr>
	               <td class="fs16" >
	                 
	                 Important Note: Clicking on the <strong>Construct Menu</strong> link will run expensive process that will consume extensive system resourse, please click on the <strong>Construct Menu</strong> if and only if there is a change on the user privilage; assignment of new privilage/s to the user or provoked privilage/s from the user.
	               </td>
	           </tr>
</table>
<p class="fs12">Please enter the first one or two letter of staff first, middle or last name.</p>
<table class="fs13 small_padding">
	<tr> 
		<td style="width:15%">First Letter of Name:</td>
		<td style="width:85%"><?php echo $this->Form->input('User.name',array('label'=>false)); ?></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $this->Form->Submit('Search',array('div'=>false,'name'=>'getUsers')); ?></td>	
	</tr>
	</table>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th style="width:40%"><?php echo $this->Paginator->sort('full_name');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('username');?></th>
			<th style="width:20%"><?php echo $this->Paginator->sort('role_id');?></th>
			<th style="width:10%"><?php echo $this->Paginator->sort('active');?></th>
			<th style="width:10%; text-align:center" class="actions"><?php __('Actions');?></th>
		</tr>
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
			 <?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $user['User']['id'])); ?> 
			  <?php echo $this->Html->link(__('Construct Menu', true), array('action' => 'build_user_menu', $user['User']['id'])); ?> 
			 <?php 
			 if ($user['User']['active']==0) {
			
			    echo $this->Html->link(__('Reset Password', true), 
			     array('action' => 'resetpassword'),
			     array('onclick'=>'return false','style'=>'color:gray'));
			 } else {
			     if ($user['User']['role_id'] == ROLE_INSTRUCTOR) {
			        echo $this->Html->link(__('Reset Password', true), 
			     array('action' => 'resetpassword'),
			     array('onclick'=>'return false',
			     'style'=>'color:gray'));
			     } else {
			        echo $this->Html->link(__('Reset Password', true), 
			     array('action' => 'resetpassword', $user['User']['id']));
			  
			     }
			     //disabled="true"
			     
			 }
			 ?>
			 
			 <?php 
			 if ($role_id ==ROLE_REGISTRAR) {
			  
			     if ($user['User']['active']==0) {
			           echo $this->Html->link(__('Assign', true), array('action' => 'assign'),array('onclick'=>'return false',
			           'style'=>'color:gray')); 
			     } else {
			              echo $this->Html->link(__('Assign', true), array('action' => 'assign', $user['User']['id'])); 
			     
			     }
			    
			 }
			 
			 if ($role_id == ROLE_ACCOMODATION ) {
			    
			  
			     if ($user['User']['active']==0) {
			             echo $this->Html->link(__('Assign', true), array('action' => 'assign_user_dorm_block'),array('onclick'=>'return false',
			             'style'=>'color:gray'));
			     } else {
			             echo $this->Html->link(__('Assign', true), array('action' => 'assign_user_dorm_block', $user['User']['id']));  
			     }
			 
			 }
			 
			 if ($role_id == ROLE_MEAL ) {
			  
			    
			     if ($user['User']['active']==0) {
			         echo $this->Html->link(__('Assign', true), array('action' => 'assign_user_meal_hall'),array('onclick'=>'return false',
			         'style'=>'color:gray')); 
			     } else {
			            echo $this->Html->link(__('Assign', true), array('action' => 'assign_user_meal_hall', $user['User']['id']));  
			     }
			    
			 }
			 
			
			 
			 ?>
			<!-- <?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> -->
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
</div>
