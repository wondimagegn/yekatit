<div class="participatingDepartments form">
<?php echo $this->Form->create('ParticipatingDepartment');?>
	<table><tbody>
	<tr><td class='headerfont'>
		<?php __('Edit Participating Department'); ?>
		</td>
    </tr>
    
	<?php
		echo $this->Form->input('id');
		echo '<tr><td>'.$this->Form->input('college_id').'</td></tr>'; 
		echo '<tr><td>'.$this->Form->input('department_id').'<td></tr>';
		
		
		if(!empty($this->data['ParticipatingDepartment']['other_college_department'])){
		    echo '<tr><td>'.$this->Form->input('other_college_department',
		    array('disabled'=>'true')).'</td></tr>';
		    echo $this->Form->hidden('other_college_department',array('value'=>
		    $this->data['ParticipatingDepartment']['other_college_department']));
		    echo '<tr><td>'.$this->Form->input('number').'</td></tr>';
		}
		echo '<tr><td>'.$this->Form->input('academic_year',array('readonly'=>'readonly')).'</td></tr>';
	
		echo '<tr><td>'.$this->Form->input('number').'<td></tr>';
	    //echo '<tr><td>'.$this->Form->input('female').'<td></tr>';
	    //echo '<tr><td>'.$this->Form->input('regions').'<td></tr>';
	    //echo '<tr><td>'.$this->Form->input('disability').'<td></tr>';
	?>
<?php echo '<tr><td>'.$this->Form->end(__('Submit', true)).'</tr></td>';?>
    </tbody>
    </table>
</div>

