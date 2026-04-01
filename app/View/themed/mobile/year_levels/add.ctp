<div class="yearLevels form">
<?php echo $this->Form->create('YearLevel');?>
	
 	<div class="smallheading" ><?php __('Add Year Level'); ?></div>
    <table class="fs13 small_padding">
		<tr>
			<td style="width:13%">Department:</td>
			<td style="width:37%"><?php echo $this->Form->input('department_id',
			array('label'=>false)); ?></td>
		</tr>
		<tr>
			<td style="width:13%">Maximum Numer of year level:</td>
			<td style="width:37%"><?php echo $this->Form->input('numberofyear',array('label'=>false)); ?></td>
		</tr>
    </table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
