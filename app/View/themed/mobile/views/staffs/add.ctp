<div class="staffs form">
<?php echo $this->Form->create('Staff');?>

		<div class="smallheading"><?php __('Add Staff'); ?></div>
	<?php
	    echo '<table>';
	    echo '<tr><td style="width:50%">';
	    echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">Basic </td></td>';
	    echo '<tr><td>'.$this->Form->input('title_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('position_id').'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('first_name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('middle_name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('last_name').'</td></tr>';
       
        $from = date('Y') - Configure::read('Calendar.birthdayInPast');
        $to = date('Y') + Configure::read('Calendar.birthdayAhead');
        $format = Configure::read('Calendar.dateFormat');
        
		echo '<tr><td>'.$this->Form->input('birthdate',array('label'=>'Birth date','dateFormat'=>$format,'minYear'=>$from,'maxYear'=>$to)).'</td></tr>';;
		echo '</table>';
		echo '</td>';
		echo '<td>';
		 echo '<table>';
	    echo '<tr><td class="fs16" style="font-weight:bold">Address </td></td>';
	    echo '<tr><td>'.$this->Form->input('phone_mobile').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('phone_office').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('phone_home').'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('email').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('alternative_email').'</td></tr>';
		
		echo '</table>';
		echo '</td></tr>';
	    echo '</table>';
		
		
	?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
