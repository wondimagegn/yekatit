<table>
<tbody>
<tr><td class="smallheading"><?php  __('Accepted Student Detail');?></td></tr>
<?php $i = 0; $class = ' class="altrow"';?>
<tr <?php if ($i % 2 == 0) echo $class;?>><td><?php __('First Name'); ?> &nbsp;<?php echo $acceptedStudent['AcceptedStudent']['first_name']; ?></td></tr>
<tr <?php if (++$i % 2 == 0) echo $class;?>>><td><?php __('Middle Name'); ?> &nbsp;<?php echo $acceptedStudent['AcceptedStudent']['middle_name']; ?></td></tr>
<tr <?php if ($i % 2 == 0) echo $class;?>><td><?php __('Last Name'); ?> &nbsp; <?php echo $acceptedStudent['AcceptedStudent']['last_name']; ?></td></tr>
<tr <?php if ($i % 2 == 0) echo $class;?>><td><?php __('Sex'); ?> &nbsp;<?php echo $acceptedStudent['AcceptedStudent']['sex'];?></td></tr>
<tr <?php if (++$i % 2 == 0) echo $class;?>>
<td><?php __('Student Number'); ?> <?php echo $acceptedStudent['AcceptedStudent']['studentnumber']; ?></td></tr>
<tr <?php if (++$i % 2 == 0) echo $class;?>><td>
<?php __('EHEECE  Total Results'); ?> &nbsp;
<?php echo $acceptedStudent['AcceptedStudent']['EHEECE_total_results']; ?></td></tr>
<tr <?php if ($i % 2 == 0) echo $class;?>><td>
<?php __('Program Type'); ?> &nbsp; <?php echo $this->Html->link($acceptedStudent['ProgramType']['name'], array('controller' => 'program_types', 'action' => 'view', $acceptedStudent['ProgramType']['id'])); ?>
		</td></tr>
<tr <?php if ($i % 2 == 0) echo $class;?>><td><?php __('Department'); ?> &nbsp;
<?php echo $this->Html->link($acceptedStudent['Department']['name'], array('controller' => 'departments', 'action' => 'view', $acceptedStudent['Department']['id'])); ?></td></tr>
<tr<?php if (++$i % 2 == 0) echo $class;?>>
		<td> <?php __('Academicyear'); ?> &nbsp; <?php echo $acceptedStudent['AcceptedStudent']['academicyear']; ?></td></tr>
		
</tbody>
</table>
