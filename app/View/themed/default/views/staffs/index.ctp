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
			echo $this->Form->input('Search.active', array('type' => 'checkbox', 'label' => 'Active', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['active'] == 1 ? 'checked' : false))).'<br/>';
			echo $this->Form->input('Search.deactive', array('type' => 'checkbox', 'label' => 'Deactive', 'div' => false, 'checked' => (!isset($this->data) || $this->data['Search']['deactive'] == 1 ? 'checked' : false)));
			
			?></td>		
		</tr>
			
		<tr>
		<td colspan='4'><?php echo $this->Form->submit(__('View Staffs', true), array('name' => 'viewStaff', 'div' => false)); ?></td>
		</tr>
</table>

<div class="staffs index">
	<h2><?php __('Staffs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>S.N<u>o</u></th>
			
			<th><?php echo $this->Paginator->sort('position');?></th>
			<th><?php echo $this->Paginator->sort('full_name');?></th>
			<th><?php echo $this->Paginator->sort('college_id');?></th>
			<th><?php echo $this->Paginator->sort('department_id');?></th>
			<?php if ($role_id == ROLE_SYSADMIN) { ?>
			<th class="actions"><?php __('Actions');?></th>
			<?php } ?>
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
		<td><?php echo $staff['Staff']['full_name']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($staff['College']['name'], array('controller' => 'colleges', 'action' => 'view', $staff['College']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($staff['Department']['name'], array('controller' => 'departments', 'action' => 'view', $staff['Department']['id'])); ?>
		</td>
		<?php if ($role_id == ROLE_SYSADMIN) { ?>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $staff['Staff']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $staff['Staff']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $staff['Staff']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $staff['Staff']['id'])); ?>
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
