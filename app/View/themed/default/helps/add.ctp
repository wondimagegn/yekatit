<?php echo $this->Form->create('Help',array('action' => 'add','enctype' => 'multipart/form-data'));?>
<div class="helps form">

	<div class="smallheading"><?php __('Add Latest Released  Help Document'); ?></div>
<table>
	<tr>
		<td style="width:15%">Title:</td>
		<td style="width:85%"><?php echo $this->Form->input('Help.title', array('style' => 'width:400px', 'label' => false)); ?></td>
	</tr>
	<tr>
		<td>Document Date::</td>
		<td><?php echo $this->Form->input('Help.document_release_date', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Version:</td>
		<td><?php echo $this->Form->input('Help.version', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Order:</td>
		<td><?php echo $this->Form->input('Help.order', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Target:</td>
		<td><?php echo $this->Form->input('Help.target',array('label' => 'Target', 'type'=>'select', 'multiple'=>'checkbox', 'options' => $roles)); ?></td>
	</tr>
	<tr>
		<td colspan="2"><?php //echo $this->element('attachments', array('plugin' => 'media', 'label' => false)); 
		echo $this->Form->input('Attachment.0.file', array('type' => 'file'));

		?></td>
	</tr>
</table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
