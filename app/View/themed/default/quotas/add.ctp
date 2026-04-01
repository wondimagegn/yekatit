<div class="quotas form">
<?php echo $this->Form->create('Quota');?>
			<legend><?php __('Add Privilaged Quota'); ?></legend>
		<table>
		<tbody>
		
	<?php
	
		echo $this->Form->hidden('college_id',array('value'=>$college_id));
		echo '<tr><td class="font">'.$college_name.'</td></tr>';
		echo '<tr><td>'.$this->Form->input('academicyear',array('id'=>'academicyear',
            'label' => 'Academic Year','type'=>'select','options'=>$acyear_array_data,
            'empty'=>"--Select Academic Year--",'selected'=>isset($defaultacademicyear)?$defaultacademicyear:'')).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('female',array('label'=>'Female')).'</td></tr>';
		
		//echo $this->Form->input('developing_regions_id');
       echo  '<tr><td class="font">List of regions.Please check the  developing regions you
want to give privilaged quota.</td></tr>';
	   echo '<tr><td>'.$this->Form->input('developing_regions_id', 
array('type' => 'select', 'multiple' => 'checkbox',
'div'=>'input select')).'</td></tr>';
       echo '<tr><td>'.$this->Form->input('regions',array('label'=>'Developing Region Quotas')).'</td></tr>';
       echo '<tr><td>'.$this->Form->end(__('Submit', true)).'</td></tr>';
	?>
	
	</tbody>
	</table>
	
<?php //echo $this->Form->end(__('Submit', true));?>
</div>

