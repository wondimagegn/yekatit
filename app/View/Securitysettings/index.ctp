<?php ?>
<div class="box">
     <div class="box-header bg-transparent">
  	 <h2 class="box-title">
	  <?php echo __('Securitysettings');?>
	 </h2>
     </div>
     <div class="box-body">
	

       <div class="row">
	   <div class="large-12 columns">
               <table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('session_duration');?></th>
			<th><?php echo $this->Paginator->sort('minimum_password_length');?></th>
			<th><?php echo $this->Paginator->sort('maximum_password_length');?></th>
			<th><?php echo $this->Paginator->sort('password_duration');?></th>
			<th><?php echo $this->Paginator->sort('previous_password_use_allowance');?></th>
			<th><?php echo $this->Paginator->sort('number_of_login_attempt');?></th>
			<th><?php echo $this->Paginator->sort('falsify_duration');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($securitysettings as $securitysetting):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $securitysetting['Securitysetting']['id']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['session_duration']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['minimum_password_length']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['maximum_password_length']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['password_duration']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['previous_password_use_allowance']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['number_of_login_attempt']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['falsify_duration']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['created']; ?>&nbsp;</td>
		<td><?php echo $securitysetting['Securitysetting']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $securitysetting['Securitysetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $securitysetting['Securitysetting']['id'])); ?>
			
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

	</div>
     </div>
</div>
