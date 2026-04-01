<div class="titles form">
<?php echo $this->Form->create('Title');?>
	
		<div class="smallheading"><?php __('Add Title'); ?></div>
<table>
	<tr>
		<td style="width:10%">Title:</td>
		<td style="width:90%"><?php echo $this->Form->input('title',array('label' => false, 'after'=>'E.g Dr.,Ato,Mrs,Ms')); ?></td>
	</tr>
	<tr>
		<td>Description:</td>
		<td><?php echo $this->Form->input('description', array('label' => false)); ?></td>
	</tr>
</table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

