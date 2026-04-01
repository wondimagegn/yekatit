<?php echo $this->Html->script('amharictyping'); ?>   
<div class="universities form">
<?php echo $this->Form->create('University',array('action' => 'add','enctype' => 'multipart/form-data'));?>
	
		<div class="smallheading"><?php __('Add  University Name'); ?></div>
	<?php
		
	    echo '<table>';
		
		echo '<tr><td>'.$this->Form->input('name', array('style' => 'width:300px')).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('amharic_name',array('style' => 'width:300px', 'id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('short_name').'</td></tr>';
		echo '<tr><td>'.$this->Form->input('amharic_short_name',array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")).'</td></tr>';	
		echo '<tr><td>'.$this->Form->input('academic_year', array('style' => 'width:100px', 'type' => 'select', 'options' => $years, 'default' => (isset($this->data['University']['academic_year']) ? $this->data['University']['academic_year'] : date('Y')))).'</td></tr>';
		
		echo '<tr><td>'.$this->Form->input('p_o_box',array('style' => 'width:50px')).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('telephone', array('style' => 'width:200px')).'</td></tr>';
		echo '<tr><td>'.$this->Form->input('fax', array('style' => 'width:200px')).'</td></tr>';
	
		echo '<tr><td>'.$this->Form->input('Attachment.0.file',array('type'=>'file','label'=>'Transparent Logo')).'</td></tr>';
        echo '<tr><td>'.$this->Form->input('Attachment.1.file',array('type'=>'file','label'=>'Small Logo')).'</td></tr>';
		echo '</table>';
		
	?>

<?php echo $this->Form->end(__('Submit', true));?>
</div>

