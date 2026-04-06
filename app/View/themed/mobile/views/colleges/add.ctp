<?php echo $this->Html->script('amharictyping'); ?>   
<div class="colleges form">
<?php echo $this->Form->create('College');?>
<table><tbody>	
		<tr><td><div class="smallheading"><?php __('Add College'); ?></div> </td></tr>
	<?php
		echo "<tr><td>".$this->Form->input('campus_id')."</td></tr>";
		
		echo "<tr><td>".$this->Form->input('name', array('style' => 'width:300px'))."</td></tr>";
		echo "<tr><td>".$this->Form->input('shortname')."</td></tr>";
		echo "<tr><td>".$this->Form->input('amharic_name', array('style' => 'width:300px', 'id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))."</td></tr>";
		echo "<tr><td>".$this->Form->input('amharic_short_name',
		array('id'=>'AmharicText','onkeypress'=>"return AmharicPhoneticKeyPress(event,this);"))."</td></tr>";
		echo "<tr><td>".$this->Form->input('description')."</td></tr>";
		echo "<tr><td>".$this->Form->input('phone')."</td></tr>";
		//echo $this->Form->input('type');echo "<br>";
		//echo $this->Form->input('Student');
	?>
	
<?php echo "<tr><td>".$this->Form->end(__('Submit', true))."</td></tr>";?>
</tbody></table>>
</div>
