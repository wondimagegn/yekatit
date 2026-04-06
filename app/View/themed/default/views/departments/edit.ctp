<?php echo $this->Html->script('amharictyping'); ?>   
<div class="departments form">
<?php echo $this->Form->create('Department');?>
	
	<div class="smallheading"><?php __('Edit Department'); ?></div>
	<?php
	
	    echo '<table>';
		echo $this->Form->input('id');
		
		echo '<tr><td>'.$this->Form->input('college_id').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('name', array('style' => 'width:300px')).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('shortname').'</td></tr>';
		echo "<tr><td>".$this->Form->input('amharic_name',
		array('style' => 'width:300px', 'id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))."</td></tr>";
		echo "<tr><td>".$this->Form->input('amharic_short_name',
		array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))."</td></tr>";
		echo '<tr><td>'.$this->Form->input('description').'</td></tr>';
		echo "<tr><td>".$this->Form->input('phone')."</td></tr>";
		
	    echo '</table>';
	?>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
