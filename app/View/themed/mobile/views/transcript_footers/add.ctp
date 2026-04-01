<div class="transcriptFooters form">
<?php echo $this->Form->create('TranscriptFooter');?>
<div class="smallheading"><?php __('Add Transcript Footer'); ?></div>
<table>
	<tr>
		<td style="width:10%">Footer Line 1:</td>
		<td style="width:90%"><?php echo $this->Form->input('line1', array('label' => false, 'style' => 'width:700px; height:50px')); ?></td>
	</tr>
	<tr>
		<td>Footer Line 2:</td>
		<td><?php echo $this->Form->input('line2', array('label' => false, 'style' => 'width:700px; height:50px')); ?></td>
	</tr>
	<tr>
		<td>Footer Line 3:</td>
		<td><?php echo $this->Form->input('line3', array('label' => false, 'style' => 'width:700px; height:50px')); ?></td>
	</tr>
	<tr>
		<td>Program:</td>
		<td><?php echo $this->Form->input('program_id', array('label' => false)); ?></td>
	</tr>
	<tr>
		<td>Admission Year:</td>
		<td><?php echo $this->Form->input('academic_year', array('label' => false, 'options' => $acyear_array_data, 'after' => ' when the application of the footer starts')); ?></td>
	</tr>
</table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
