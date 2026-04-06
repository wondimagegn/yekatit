<div class="placementsResultsCriterias form">
<?php echo $this->Form->create('PlacementsResultsCriteria');?>

		<legend><?php __('Edit Placements Results Criteria'); ?></legend>
		<table>
        <tbody>
	<?php
	    echo '<tr><td class="font"> '.$college_name.' result criteria for '
	    .$selected.' academic year placement</td></tr>';
		echo '<tr><td>'.$this->Form->input('id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('admissionyear',array('label'=>'Academic Year',
		'value'=>$selected,'readonly'=>'readonly')).'</td></tr>';
		echo $this->Form->hidden('college_id',array('value'=>$college_id));
		echo '<tr><td>'.$this->Form->hidden('prepartory_result').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('result_from').'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('result_to').'</td></tr>';
		
	?>
	</tbody>
	</table>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>

