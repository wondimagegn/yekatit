<hr>
<b>Equivalent to: </b><br><br>
<?php
if (isset($othersprogramTypes) && !empty($othersprogramTypes)) {
	echo $this->Form->input('ProgramType.equivalent_to_id', array(
		'multiple' => 'checkbox',
		'options' => $othersprogramTypes,
		'value' => (!empty($selectedEquivalents) ? $selectedEquivalents : array()), // Ensure pre-selected checkboxes
		'div' => false,
		'label'  => false,
	));
} ?>
