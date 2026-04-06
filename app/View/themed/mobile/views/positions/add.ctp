<div class="positions form">
<?php echo $this->Form->create('Position');?>
	<div class="smallheading"><?php __('Add Position'); ?></div>
<table>
	<tr>
		<td style="width:10%">Position:</td>
		<td style="width:90%"><?php echo $this->Form->input('position',array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><?php echo $this->Form->input('description', array('label' => false)); ?></td>
	</tr>
</table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
