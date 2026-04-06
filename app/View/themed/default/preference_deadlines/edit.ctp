<div class="preferenceDeadlines form">
<?php echo $this->Form->create('PreferenceDeadline');?>
	
		<div class="smallheading"><?php __('Edit Preference Deadline'); ?></div>
	<?php
	    echo "<table><tbody>";
		echo $this->Form->input('id');
		//echo $this->Form->hidden('user_id',array('value'=>$user_id));
		echo "<tr><td>".$this->Form->input('deadline')."</td></tr>";
		
		//echo "<tr><td>".$this->Form->input('academicyear')."</td></tr>";
		echo '<tr><td>'.$this->Form->input('academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($recordedacademicyear)?$recordedacademicyear:'')).'</td>
            </tr>';
	    echo "</tbody></table>";
	?>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>

