<?php ?>
<div class="box">
     <div class="box-body">
       <div class="row">
	  <div class="large-12 columns">
            
<?php 
echo $this->Form->create('Staff');?>
<p class="smallheading">View Staffs.</p>
	<table cellspacing="0" cellpadding="0" class="fs14">
		<tr>
			<td style="width:12%">Staff Name:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.name',
			array('label'=>false)); ?></td>
			<td style="width:12%">Department:</td>
			<td style="width:20%"><?php echo $this->Form->input('Search.department_id', 
			array('label' => false,'empty'=>' ', 'class' => 'fs14',
			'options'=>$departments)); ?></td>
			
		</tr>
		
		<tr>
		  	<td> Type:</td>
			<td><?php 
			
			echo $this->Form->input('Search.active', array('type' => 'checkbox', 'label' => 'Active', 'div' => false, 'checked' => (!isset($this->request->data) || ($this->request->data['Search']['active'] == 1 ? 'checked' : false)))).'<br/>';
			echo $this->Form->input('Search.deactive', array('type' => 'checkbox', 'label' => 'Deactive', 'div' => false, 'checked' => (!isset($this->request->data) || $this->request->data['Search']['deactive'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr>
			
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Staffs'), array('name' => 'viewStaff','class'=>'tiny radius button bg-blue','div' => false)); ?></td>
		</tr>
</table>

<div class="staffs index">
	<h2><?php echo __('Staffs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			
			<th><?php echo $this->Paginator->sort('position');?></th>
			<th><?php echo $this->Paginator->sort('staffid');?></th>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('college_id','Stream');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			
			<th class="actions"><?php echo __('Actions');?></th>
			
	</tr>
	<?php
	$i = 0;
	$start=$this->Paginator->counter('%start%');
	foreach ($staffs as $staff):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $start++; ?>&nbsp;</td>
		<td><?php echo $staff['Position']['position']; ?>&nbsp;</td>

		<th><?php echo $staff['Staff']['staffid'];?>&nbsp;</td>
		<td><?php echo $staff['Staff']['full_name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($staff['College']['name'], array('controller' => 'colleges', 'action' => 'view', $staff['College']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($staff['Department']['name'], array('controller' => 'departments', 'action' => 'view', $staff['Department']['id'])); ?>
		</td>
		<td class="actions">		
		<?php if ($role_id == ROLE_SYSADMIN) { ?>
		
			<?php echo $this->Html->link(__('View'), array('action' => 'staff_profile', $staff['Staff']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'update_staff_profile', $staff['Staff']['id'])); ?>
			
               
		<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $staff['Staff']['id']), array(), __('Are you sure you want to delete # %s?', $staff['Staff']['id'])); ?>
		<?php } elseif($role_id == ROLE_COLLEGE || $role_id==ROLE_DEPARTMENT) { ?>
		
			<?php echo $this->Html->link(__('View'), array('action' => 'staff_profile', $staff['Staff']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'update_staff_profile', $staff['Staff']['id'])); ?>
			
		<?php } else { ?>
                 <?php echo $this->Html->link(__('View'), array('action' => 'staff_profile', $staff['Staff']['id'])); ?>
			<?php echo $this->Html->link(__('Update Profile'), array('action' => 'update_staff_profile', $staff['Staff']['id'])); ?>

		<?php 
			}
		?>

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
	</div> <!-- end of row -->
      </div> <!-- end of box-body -->
</div><!-- end of box -->
