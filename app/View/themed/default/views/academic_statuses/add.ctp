<div class="academicStatuses form">
<?php echo $this->Form->create('AcademicStatus');?>
<div class="smallheading"><?php __('Add Academic Status'); ?></div>
<p class="fs14">Please enter new acadamic status that will be applied in both undergraduate and postgraduate students. For example Pass, Warning, Disimasal, Readmission, Probation etc.</p>
<table>
	<tr>
		<td style="width:15%">Academic Status</td>
		<td style="width:85%">
		<?php
			echo $this->Form->input('name', array('label' => false));
		?>
		</td>
	</tr>
	<tr>
		<td>Evaluation Order</td>
		<td>
		<?php
			echo $this->Form->input('order', array('label' => false, 'size' => 3, 'maxlength' => 1));
		?>
		<p>This order will be used to determine which status evaluation should come first. For example the student is evaluated first for "Pass" acadamic status before "Warning" or "Dismisal" status. If a stuent fail to achive the "Pass" status, then s/he will be evaluated for "Warning" status before "Dismisal".</p>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
