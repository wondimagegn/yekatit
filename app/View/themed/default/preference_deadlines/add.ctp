<?php 
?>
<div class="preferenceDeadlines form">

   <table>
   <tbody>
   <tr><td>
   <?php echo $this->Form->create('PreferenceDeadline');?>
		<div class="smallheading"><?php __('Add Preference Deadline'); ?></div>
	</td>
	</tr>
	<?php
		echo '<tr><td>'.$this->Form->input('deadline').'</td></tr>';
		echo $this->Form->hidden('user_id',array('value'=>$user_id));
		echo $this->Form->hidden('college_id',array('value'=>$college_id));
		
		echo '<tr><td>'.$this->Form->input('academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($selected)?$selected:'')).'</td>
            </tr>';
	?>
     <tr>
<?php echo '<td>'.$this->Form->end(__('Submit', true)).'</td>';?>
    </tr>
    </tbody></table>
</div>

