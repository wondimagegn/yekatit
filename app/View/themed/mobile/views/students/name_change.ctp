<div class="student form">
<?php echo $this->Form->create('Student');?>
<?php echo $this->Html->script('amharictyping'); ?> 
    <table>
    <tr>
    <td>
    <table>
           <tr><td colspan=2 class="fs16">From</td></tr>
           <tr><td>First Name</td><td>
           <?php echo $this->Form->input('StudentNameHistory.from_first_name',array('label'=>false)); ?></td></tr>
           <tr><td>Middle Name</td><td> <?php echo $this->Form->input('StudentNameHistory.from_middle_name',array('label'=>false)); ?></td></tr>
           <tr><td>Last Name</td><td> <?php echo $this->Form->input('StudentNameHistory.from_last_name',array('label'=>false)); ?></td></tr>
           <tr><td>Amharic First Name</td><td><?php echo $this->Form->input('StudentNameHistory.from_amharic_first_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td>Amharic Middle Name</td><td><?php echo $this->Form->input('StudentNameHistory.from_amharic_middle_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td>Amharic Last Name</td><td><?php echo $this->Form->input('StudentNameHistory.from_amharic_last_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
	</table>
	</td>
	<td>
	  <table>
           <tr><td colspan=2 class="fs16">To</td></tr>
           <tr><td>First Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_first_name',array('label'=>false)); ?></td></tr>
           <tr><td>Middle Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_middle_name',array('label'=>false)); ?></td></tr>
           <tr><td>Last Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_last_name',array('label'=>false)); ?></td></tr>
           <tr><td> Amharic First Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_amharic_first_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td> Amharic Middle Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_amharic_middle_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
           <tr><td> Amharic Last Name</td><td><?php echo $this->Form->input('StudentNameHistory.to_amharic_last_name',array('id'=>'AmharicText','label'=>false,'onkeypress'=>"return AmharicPhoneticKeyPress(event,this);")); ?></td></tr>
            <tr><td>Minute Number</td><td>
            <?php 
              echo $this->Form->input('StudentNameHistory.minute_number',array('label'=>false)); 
              echo $this->Form->hidden('StudentNameHistory.student_id',array('label'=>false)); 
            ?>
            
            </td></tr>
	</table>
	</td>
	</tr>
	</table>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
