<div class="helps form">
<?php
echo $this->Form->create('Help',array('type'=>'file'));
echo $this->Form->input('id');
?>
	<div class="smallheading"><?php __('Edit Help Document'); ?></div>
<table>
	<tr>
		<td style="width:15%">Title:</td>
		<td style="width:85%"><?php echo $this->Form->input('title', array('style' => 'width:400px', 'label' => false)); ?></td>
	</tr>
	<tr>
		<td>Document Date::</td>
		<td><?php echo $this->Form->input('document_release_date', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Version:</td>
		<td><?php echo $this->Form->input('version', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Order:</td>
		<td><?php echo $this->Form->input('order', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Target:</td>
		<td><?php echo $this->Form->input('target',array('label' => 'Target', 'type'=>'select', 'multiple'=>'checkbox', 'options' => $roles)); ?></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $this->element('attachments', array('plugin' => 'media', 'label' => false)); ?></td>
	</tr>
</table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
