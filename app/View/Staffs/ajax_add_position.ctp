<div class="row">
<div class="large-12 columns">

<?php echo $this->Form->create('PositionAssignment',
	array('action'=>'add_staff_position', "method"=>"POST"));
	
echo '<h6>Please provide the additional position assigned besides academic duty.</h6>';

echo $this->Form->hidden('PositionAssignment.staff_id',array('value'=>$staff_profile['Staff']['id']));

echo $this->Form->hidden('PositionAssignment.id');
?>

<?php 

echo '<table>';
	    echo '<tr><td style="width:50%">';
	    echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">PositionAssignment </td></td>';
	    echo '<tr><td>'.$this->Form->input('PositionAssignment.position_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('PositionAssignment.OverloadValue',array('empty'=>false,'value'=>3)).'</td></tr>';
		
		echo '</table>';
		echo '</td>';
		
		echo '<td style="width:50%">';

		 echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">Position Active Date </td></td>';
	    echo '<tr><td>'.$this->Form->input('PositionAssignment.from',
	    	array('type'=>'date','minYear'=>date('Y'),
'maxYear'=>date('Y')-3)).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('PositionAssignment.to',
			array('type'=>'date','minYear'=>date('Y'),
'maxYear'=>date('Y')+2)).'</td></tr>';

echo '</table>';
echo '</table>';
 echo $this->Form->end(array('label'=>__('Add Position Assignment'),
'class'=>'tiny radius button bg-blue'));

?>
</div>
</div>
<a class="close-reveal-modal">&#215;</a>
