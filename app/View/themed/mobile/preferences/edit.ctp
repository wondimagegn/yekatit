<div class="preferences form">
<?php echo $this->Form->create('Preference');?>
	<fieldset>
 		<legend><?php __('Edit Preference'); ?></legend>
	<?php
	    echo '<table><tbody>';
		echo '<tr><td>'.$this->Form->input('accepted_student_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','value'=>$current_acyear,'readonly' => 'readonly')).'</td></tr>';
        echo '<tr><td>'.$this->Form->hidden('user_id',array('value'=>$user_id)).'</td></tr>';
        
        for($i=1;$i<=$departmentcount;$i++) {
		    echo '<tr><td>'.$this->Form->hidden('Preference.'.$i.'.accepted_student_id').'</td></tr>';
			echo '<tr><td>'.$this->Form->input('Preference.'.$i.'.department_id',array('label'=>'Preference '.$i)).'</td></tr>';
			echo '<tr><td>'.$this->Form->hidden('Preference.'.$i.'.preferences_order',array('value'=>$i)).'</td></tr>';
			// Model.$id.field
		}
		echo '</table></tbody>';
		/*echo $this->Form->input('id');
		echo $this->Form->input('accepted_student_id');echo '<br/>';
		echo $this->Form->input('academicyear');echo '<br/>';
		echo $this->Form->input('department_id');echo '<br/>';
		echo $this->Form->hidden('user_id',array('value'=>$user_id));
		echo $this->Form->input('preferences_order');
		*/
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

